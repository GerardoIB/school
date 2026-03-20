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
        $session = \Config\Services::session();
        $userModel = new Users();
        $rules = [
            'phone' => 'required|min_length[10]|numeric',
            'password' => 'required|min_length[6]'
        ];
        if(!$this -> validate($rules)){
            return redirect() -> back() -> withInput() -> with('errors',$this -> validator ->getErrors());
        }

        $data = [
            'phone' => $this -> request ->getPost('phone'),
            'password' => $this -> request -> getPost('password')
        ];

        $user  = $userModel -> where('fk_phone', $data['phone']) -> first();
       if(!$user){
            return redirect() -> back() -> withInput() 
            ->with('error_usuario', 'Error: Este usuario no existe')
            ->with('type_toast', 'error');
        }
            
        if(password_verify($data['password'],$user['password'])){

            $session -> set($user);
            send_telegram("El numero ". $user['fk_phone'] . "Ha iniciado sesion");
            if($user['fk_level'] == 1){
            return redirect()->to(base_url('admin/dashboard'));
            }else{
                return redirect()->to(base_url('user/profile'));
            }
        }else{
            return redirect()->back()->withInput()
            ->with('mensaje_toast', 'Error: Usuario y/o contraseña incorrectos ')
            ->with('tipo_toast', 'error');
        }
    }
    public function registerProcess(){
        $rules = [
            'nombre'           => 'required|string|min_length[3]',
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
            'apellido_paterno',
            'apellido_materno',
            'tel',
            'fecha_nacimiento'
        ]);


        try {
            // Guardamos el resultado en una variable
            $personaGuardada = $personModel->insert([
                'nombre'           => $personData['nombre'],
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
                    'fk_level' => 4
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
}