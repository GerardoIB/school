<?php

namespace App\Controllers;

class Student extends BaseController
{
    public function dashboard()
    {
        return view('student/dashboard');
    }

    public function getAllTeachers()
    {
        // Aquí haces tu consulta a la base de datos para obtener los maestros
        // Esto es un ejemplo de cómo armar la respuesta para DataTables
        $db = \Config\Database::connect();
        
        // Asumiendo que tus maestros tienen rol 2 en tu tabla users
        $builder = $db->table('users u');
        $builder->select('p.nombre, p.apellido_paterno, p.pk_phone, p.telegram_chat_id');
        $builder->join('persons p', 'p.pk_phone = u.fk_phone');
        $builder->where('u.rol_id', 2); // Nivel de los maestros
        
        $teachers = $builder->get()->getResultArray();

        // Armamos los botones de acción (El mismo botón de Telegram que ya conoces)
        $data = [];
        foreach ($teachers as $teacher) {
            $btnTelegram = '';
            
            // Solo mostramos el botón si el maestro tiene configurado Telegram
            if (!empty($teacher['telegram_chat_id'])) {
                $btnTelegram = "<button class='btn btn-info btn-sm btn-telegram'
                                data-chatid='{$teacher['telegram_chat_id']}'
                                data-name='{$teacher['nombre']} {$teacher['apellido_paterno']}'
                                data-bs-toggle='modal'
                                data-bs-target='#modalTelegram'>
                                <i class='bi bi-telegram'></i> Enviar Mensaje
                                </button>";
            } else {
                $btnTelegram = "<span class='badge bg-secondary'>Sin Telegram</span>";
            }

            $data[] = [
                $teacher['nombre'] . ' ' . $teacher['apellido_paterno'],
                $teacher['pk_phone'] ?? 'N/A',
                $teacher['telegram_chat_id'] ?? 'N/A',
                $btnTelegram
            ];
        }

        return $this->response->setJSON(['data' => $data]);
    }
}