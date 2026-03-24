<?php

namespace App\Controllers;

use App\Models\Users;
use App\Models\PersonsModel;

class Auth extends BaseController{
    public function login(){
        return view('user/page-login');
    }
    public function register(){
        return view('user/register');
    }
    public function forget(){
        return view('user/forget');
    }
    public function dashboard(){
        return view('user/dashboard');
    }

    public function processLogin(){
        helper('telegram'); // Cargas tu helper de Telegram
        $session = \Config\Services::session();
        $userModel = new Users();
        
        $rules = [
            'phone' => 'required|min_length[10]|numeric',
            'password' => 'required|min_length[6]'
        ];
        
        if(!$this->validate($rules)){
            return redirect()->back()->withInput()->with('errors',$this->validator->getErrors());
        }

        $data = [
            'phone' => $this->request->getPost('phone'),
            'password' => $this->request->getPost('password')
        ];

        // Buscamos al usuario
        $user = $userModel->where('fk_phone', $data['phone'])->first();
        
        if(!$user){
            return redirect()->back()->withInput()
            ->with('error_usuario', 'Error: Este usuario no existe')
            ->with('type_toast', 'error');
        }
            
        // VERIFICACIÓN DE CONTRASEÑA
        if(password_verify($data['password'], $user['password'])){
            
            // --- INICIA LÓGICA DEL MAGIC LINK ---
            
            // 1. Generamos un token criptográficamente seguro
            $token = bin2hex(random_bytes(32)); 
            $expires = time() + 900; // Expira en 15 minutos

            // 2. Guardamos el token en la base de datos para este usuario
            $userModel->where('fk_phone', $user['fk_phone'])->set([
                'magic_token'   => $token,
                'magic_expires' => $expires
            ])->update();

            // 3. Construimos el enlace mágico
            $magicLink = base_url("auth/magic-login/" . $token);

            // 4. Enviamos el enlace por Telegram. 
            // NOTA: Ajusta los parámetros de send_telegram según como lo tengas programado en tu helper.
            // Si tu helper requiere el ID de chat, podrías necesitar hacer un JOIN con PersonsModel para obtenerlo.
            $mensajeTelegram = "🔐 Se solicitó un inicio de sesión.\n\nHaz clic en el siguiente enlace para entrar a tu cuenta:\n" . $magicLink;
            
            // Ejemplo: send_telegram($mensajeTelegram, $chat_id_del_usuario);
            send_telegram($mensajeTelegram); 

            // 5. Redirigimos al inicio de sesión avisando que revise su Telegram
            return redirect()->to(base_url('auth/login'))
            ->with('toast_message', '¡Contraseña correcta! Revisa tu Telegram, te hemos enviado el enlace de acceso.')
            ->with('toast_type', 'success');

        } else {
            return redirect()->back()->withInput()
            ->with('error_usuario', 'Error: Contraseña incorrecta')
            ->with('tipo_toast', 'error');
        }
    }
    public function requestMagicLink() {
        $userModel = new Users();
        $phone = $this->request->getPost('phone');

        // 1. Buscamos al usuario por su teléfono
        $user = $userModel->where('fk_phone', $phone)->first();

        if (!$user) {
            return redirect()->back()->with('error_usuario', 'Este usuario no existe')->with('tipo_toast', 'error');
        }

        // 2. Generamos un token criptográficamente seguro
        $token = bin2hex(random_bytes(32)); // Ej: a1b2c3d4e5...
        $expires = time() + 900; // Expira en 15 minutos (900 segundos)

        // 3. Guardamos el token en la base de datos
        $userModel->where('fk_phone', $phone)->set([
            'magic_token'   => $token,
            'magic_expires' => $expires
        ])->update();

        // 4. Construimos el enlace
        $magicLink = base_url("auth/magic-login/" . $token);

        // AQUI DECIDES CÓMO ENTREGARLO:
        // Como no usas servicios externos, puedes mandarlo por Telegram si ya lo tienes configurado:
        // send_telegram("Haz clic aquí para iniciar sesión: " . $magicLink, $user['telegram_chat_id']);
        
        // O para pruebas locales, lo mostramos en un mensaje Toast (no recomendado para producción por seguridad)
        return redirect()->back()->with('toast_message', 'Link generado: ' . $magicLink)->with('toast_type', 'success');
    }

    // Procesa el clic en el Magic Link
    public function verifyMagicLink($token) {
        $session = \Config\Services::session();
        $userModel = new Users();

        // 1. Buscamos al usuario que tenga este token exacto
        $user = $userModel->where('magic_token', $token)->first();

        // 2. Validaciones de seguridad
        if (!$user) {
            return redirect()->to(base_url('auth/login'))->with('error_usuario', 'El enlace es inválido o ya fue usado.')->with('tipo_toast', 'error');
        }

        if (time() > $user['magic_expires']) {
            // Si ya expiró, borramos el token
            $userModel->where('id', $user['id'])->set(['magic_token' => null, 'magic_expires' => null])->update();
            return redirect()->to(base_url('auth/login'))->with('error_usuario', 'El enlace ha expirado. Solicita uno nuevo.')->with('tipo_toast', 'error');
        }

        // 3. ¡Éxito! Iniciamos la sesión del usuario
        $session->set($user);

        // 4. Destruimos el token para que no se pueda usar dos veces (CRÍTICO)
        $userModel->where('fk_phone', $user['fk_phone'])->set([
            'magic_token' => null, 
            'magic_expires' => null
        ])->update();

        // 5. Redirigimos según su rol
        switch ($user['fk_level']) {
            case '1': return redirect()->to(base_url('admin/dashboard'));
            case '2': return redirect()->to(base_url('teacher'));
            case '3': return redirect()->to(base_url('student'));
            case '4': return redirect()->to(base_url('user/profile'));
            default:  return redirect()->to(base_url('auth/login'));
        }}

    public function registerProcess(){
        $rules = [
            'nombre'           => 'required|string|min_length[3]',
            'telegram_chat_id' => 'permit_empty|numeric|min_length[5]',
            'apellido_paterno' => 'required|string|min_length[3]',
            'apellido_materno' => 'required|string|min_length[3]',
            'curp'             => 'required|exact_length[18]', 
            'tel'              => 'required|numeric|exact_length[10]',
            'email'            => 'required|valid_email',
            'fecha_nacimiento' => 'required|valid_date[Y-m-d]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
        ];
        if(!$this -> validate($rules)){
            return redirect() -> back() -> withInput() -> with('errors', $this -> validator -> getErrors());
        }
        $personModel = new PersonsModel();
        $userModel = new Users();
        $userData = $this -> request ->getPost([
             'tel',
            'password'
        ]);
        $passwordhash = password_hash($userData['password'],PASSWORD_DEFAULT);
        $personData = $this -> request -> getPost([
            'nombre',
            'telegram_chat_id',
            'apellido_paterno',
            'apellido_materno',
            'tel',
            'fecha_nacimiento'
        ]);


        try {
            // Guardamos el resultado en una variable
            $personaGuardada = $personModel->insert([
                'nombre'           => $personData['nombre'],
                'telegram_chat_id' => $personData('telegram_chat_id'),
                'apellido_paterno' => $personData['apellido_paterno'],
                'apellido_materno' => $personData['apellido_materno'],
                'pk_phone'         => $personData['tel'],
                'birthdate'        => $personData['fecha_nacimiento'] 
            ]);

            // EVALUACIÓN ESTRICTA: Verificamos que NO sea false
            if($personaGuardada !== false) { 
                
                // 2. Insertamos al usuario
                if($userModel->insert([
                    'fk_phone' => $personData['tel'],
                    'password' => $passwordhash, 
                    'fk_level' => 3
                ])) {
                    return redirect() -> to(base_url('auth/login'))
                    ->with('toast_message','¡Registro exitoso! Ya puedes iniciar sesión.')
                    ->with('toast_type','success');
                } else {
                    return $this->response->setJSON([
                        'message' => 'Error al crear la cuenta de usuario',
                        'errores' => $userModel->errors()
                    ]);
                }

            } else {
                return $this->response->setJSON([
                    'message' => 'Error al guardar los datos personales',
                    'errores' => $personModel->errors()
                ]);
            }
            
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()
            ->with('mensaje_toast', 'Error: Error al guardar los datos personales ')
            ->with('tipo_toast', 'error');
        }
    }
    public function changePassword() {
        $phone = $this->request->getPost('phone');
        $newPassword = $this->request->getPost('newPassword');
    
        $userModel = new Users();
    
        // 1. Buscamos si el usuario existe realmente
        $user = $userModel->where('fk_phone', $phone);
    
        if (!$user) {
            return $this->response->setJSON([
                "status"  => "error",
                "message" => "No se encontró el usuario con el teléfono: " . $phone
            ]);
        }
    
        // 2. Preparamos el hash
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    
        // 3. Actualizamos especificando el campo y el valor en el where
        // IMPORTANTE: Pasamos ambos parámetros al where
        $updateStatus = $userModel->where('fk_phone', $phone)
                                  ->set(['password' => $passwordHash])
                                  ->update();
    
        if ($updateStatus) {
            return $this->response->setJSON([
                "status"  => "success",
                "message" => "La contraseña ha sido actualizada correctamente"
            ]);
        }
    
        return $this->response->setJSON([
            "status"  => "error",
            "message" => "No se realizaron cambios (es posible que la contraseña sea la misma)"
        ]);
    }
    function generarOTP($longitud = 6) {
        $otp = "";
        for ($i = 0; $i < $longitud; $i++) {
            $otp .= random_int(0, 9);
        }
        return $otp;
    }
}