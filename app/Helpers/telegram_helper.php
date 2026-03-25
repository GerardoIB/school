<?php

/**
 * Helper para enviar mensajes por Telegram
 */

/**
 * Envía un mensaje por Telegram al chat configurado por defecto
 *
 * @param string $mensaje Mensaje a enviar
 * @return array|false Respuesta de la API o false en caso de error
 */
function send_telegram($mensaje) {
    $token = getenv('TELEGRAM_BOT_TOKEN') ?: "8733400965:AAEyk7oOj0JVFCGUPmvlAacPwwZ-FypTl-4";
    $chatId = getenv('TELEGRAM_CHAT_ID') ?: "8254444833";

    return _send_telegram_request($token, $chatId, $mensaje);
}

/**
 * Envía un mensaje por Telegram a un usuario específico
 *
 * @param string $telegramChatId Chat ID de Telegram del usuario
 * @param string $mensaje Mensaje a enviar
 * @return array|false Respuesta de la API o false en caso de error
 */
function send_telegram_to_chat(string $telegramChatId, string $mensaje) {
    $token = getenv('TELEGRAM_BOT_TOKEN') ?: "8733400965:AAEyk7oOj0JVFCGUPmvlAacPwwZ-FypTl-4";

    if (empty($telegramChatId)) {
        log_message('error', 'Telegram: Chat ID no proporcionado');
        return false;
    }

    return _send_telegram_request($token, $telegramChatId, $mensaje);
}

/**
 * Envía un mensaje por Telegram a un usuario del sistema
 *
 * @param int $userId ID del usuario en el sistema
 * @param string $mensaje Mensaje a enviar
 * @return array|false Respuesta de la API o false en caso de error
 */
function send_telegram_to_user(int $userId, string $mensaje) {
    // Obtener el chat_id del usuario
    $db = \Config\Database::connect();
    $builder = $db->table('users u');
    $builder->select('p.telegram_chat_id, p.nombre, p.apellido_paterno');
    $builder->join('persons p', 'p.pk_phone = u.fk_phone');
    $builder->where('u.pk_user', $userId);
    $user = $builder->get()->getRowArray();

    if (!$user) {
        log_message('error', "Telegram: Usuario con ID {$userId} no encontrado");
        return false;
    }

    if (empty($user['telegram_chat_id'])) {
        log_message('error', "Telegram: Usuario {$user['nombre']} no tiene chat_id configurado");
        return false;
    }

    return send_telegram_to_chat($user['telegram_chat_id'], $mensaje);
}

/**
 * Formatea un mensaje de notificación para el sistema educativo
 *
 * @param string $tipo Tipo de mensaje (tarea, examen, aviso, etc.)
 * @param string $contenido Contenido del mensaje
 * @param string|null $remitente Nombre del remitente (opcional)
 * @return string Mensaje formateado
 */
function format_telegram_message(string $tipo, string $contenido, ?string $remitente = null): string {
    $emojis = [
        'tarea' => '📝',
        'examen' => '📚',
        'aviso' => '📢',
        'mensaje' => '💬',
        'recordatorio' => '⏰',
        'calificacion' => '✅',
        'default' => '📬'
    ];

    $emoji = $emojis[$tipo] ?? $emojis['default'];

    $mensaje = "{$emoji} *{$tipo}*\n\n";
    $mensaje .= $contenido;

    if ($remitente) {
        $mensaje .= "\n\n👤 De: {$remitente}";
    }

    $mensaje .= "\n\n_Este mensaje fue enviado desde el Sistema Educativo_";

    return $mensaje;
}

/**
 * Función interna para hacer la petición a la API de Telegram
 *
 * @param string $token Token del bot
 * @param string $chatId Chat ID destino
 * @param string $mensaje Mensaje a enviar
 * @return array|false
 */
function _send_telegram_request(string $token, string $chatId, string $mensaje) {
    $url = "https://api.telegram.org/bot{$token}/sendMessage";
    
    try {
        // 1. Movemos la instancia adentro del try para que si falla, no mate el script
        $cliente = \Config\Services::curlrequest();

        $response = $cliente->post($url, [
            'form_params' => [
                'chat_id' => $chatId,
                'text' => $mensaje,
                'parse_mode' => 'Markdown'
            ],
            // 2. Bajamos el timeout a 5 segundos. 30 segundos es mucho y Nginx podría cortar la conexión.
            'timeout' => 5 
        ]);

        $result = json_decode($response->getBody(), true);

        if (isset($result['ok']) && $result['ok'] === true) {
            log_message('info', "Telegram: Mensaje enviado a {$chatId}");
            return $result;
        } else {
            log_message('error', 'Telegram: ' . ($result['description'] ?? 'Error desconocido'));
            return false;
        }
    } catch (\Throwable $th) {
        // Ahora sí, cualquier error de cURL o de CodeIgniter será atrapado sin borrar tu base de datos
        log_message('error', 'Telegram error: ' . $th->getMessage());
        return false;
    }
}

/**
 * Verifica si un usuario tiene configurado su chat_id de Telegram
 *
 * @param int $userId ID del usuario
 * @return bool True si tiene chat_id configurado
 */
function has_telegram_configured(int $userId): bool {
    $db = \Config\Database::connect();
    $builder = $db->table('users u');
    $builder->select('p.telegram_chat_id');
    $builder->join('persons p', 'p.pk_phone = u.fk_phone');
    $builder->where('u.pk_user', $userId);
    $user = $builder->get()->getRowArray();

    return $user && !empty($user['telegram_chat_id']);
}