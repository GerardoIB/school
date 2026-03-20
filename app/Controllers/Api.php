<?php

namespace App\Controllers;
use \Config\Services;

class Api extends BaseController{

public function telegram($mensaje){
    $token = "8733400965:AAEyk7oOj0JVFCGUPmvlAacPwwZ-FypTl-4";
    $chatId = "8254444833";

    $url = "https://api.telegram.org/bot{$token}/sendMessage";
    $cliente = \Config\Services::curlrequest();

    try {
        $response = $cliente->post($url,[
            'form_params' =>[
                'chat_id' => $chatId,
                'text' => $mensaje
            ]
        ]);

        $body = $response->getBody();
        $status = $response->getStatusCode();
        $result = json_decode($body, true);

        return $this->response->setJSON([
            'success' => $result['ok'] ?? false,
            'message' => $result['description'] ?? 'Mensaje enviado',
            'telegram_response' => $result
        ]);
    } catch (\Throwable $th) {
        return $this->response->setJSON([
            'success' => false,
            'error' => $th->getMessage()
        ])->setStatusCode(500);
    }
}
}


