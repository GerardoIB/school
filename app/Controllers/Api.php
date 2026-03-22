<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Api extends BaseController
{
    // Función sin parámetros para recibir la petición AJAX (POST)
    public function telegram()
    {
        // 1. Cargamos tu helper de Telegram
        // CodeIgniter buscará el archivo app/Helpers/telegram_helper.php
        helper('telegram');

        // 2. Capturamos los datos enviados por el modal a través de AJAX
        $chatId = $this->request->getPost('telegram_id');
        $mensaje = $this->request->getPost('message');

        // 3. Validación básica
        if (empty($chatId) || empty($mensaje)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'El destinatario y el mensaje son obligatorios.'
            ])->setStatusCode(400);
        }

        // 4. (Opcional) Podemos usar tu función para darle un formato bonito al mensaje
        // Si prefieres enviar el texto plano, puedes saltarte esta línea
        $mensajeFormateado = format_telegram_message('mensaje', $mensaje, 'Profesor');

        // 5. Enviamos el mensaje utilizando la función de tu helper
        // Pasamos el Chat ID del alumno y el mensaje (o el mensaje formateado)
        $resultado = send_telegram_to_chat($chatId, $mensajeFormateado);

        // 6. Evaluamos el resultado que devuelve tu helper
        // Tu helper devuelve un array si es exitoso, o "false" si falla
        if ($resultado !== false) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Mensaje enviado correctamente por Telegram.'
            ]);
        } else {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Error al enviar el mensaje. Revisa los logs del sistema.'
            ])->setStatusCode(500);
        }
    }
}