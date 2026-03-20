<?php

namespace App\Controllers;
use App\Models\Users as UserModel;
use App\Models\PersonsModel;
class Admin extends BaseController {

    public function dashboard() {
   
        $session = session();
        $model = new UserModel();
        $data['user'] = $model->getDataPerson($session->get('pk_user'));
    
  
        $data['usuarios'] = $model->db->table('users')
                                  ->join('persons', 'persons.pk_phone = users.fk_phone')
                                  ->get()->getResultArray();
    
        return view('user/dashboard', $data); 
    }

  
public function index() {
    $session = session();
    $model = new \App\Models\Users();
    
    
    $data['user'] = $model->getDataPerson($session->get('pk_user'));
    
  
    $data['usuarios'] = $model->db->table('users')
                              ->join('persons', 'persons.pk_phone = users.fk_phone')
                              ->get()->getResultArray();

    return view('user/dashboard', ['usuarios' => $data['usuarios']]); 
}

    public function logout() {
        
        session()->destroy();         
        return redirect() -> to(base_url('auth/login'));
    }

    public function delete($id){
        $model = new UserModel();
        $personModel = new PersonsModel();
        $user = $model -> where('pk_user',$id)->first();
        if($user){
            if($model -> where('pk_user', $id) ->delete()){
                if($personModel -> where('pk_phone',$user['fk_phone'])->delete())
            return $this -> response -> setJSON(['status' => 'success', 'message' => 'Usuario eliminado correctamente']);
            }
        } else {
            return $this -> response -> setJSON(['status' => 'error', 'message' => 'Usuario no encontrado']);
        }
    }

    public function updateProfile($id){
        $model = new UserModel();
        $user = $model -> find($id);
        if(!$user){
            return $this -> response -> setJSON(['status' => 'error', 'message' => 'Usuario no encontrado']);
        }
        $db = \Config\Database::connect();
        $builder = $db -> table('persons');

        $data = [
            'nombre' => $this -> request -> getVar('nombre'),
            'apellido_paterno' => $this -> request -> getVar('apellido_paterno'),
            'apellido_materno' => $this -> request -> getVar('apellido_materno')
        ];
        if ($builder->where('pk_phone', $user['fk_phone'])->update($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => $data]);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'No se pudo actualizar']);

    }

    public function create() {
        $personModel = new \App\Models\PersonsModel();
        $userModel = new \App\Models\Users();
        
        $tel = $this->request->getPost('tel');
    
        // Datos para la tabla Persons
        $personData = [
            'pk_phone'         => $tel,
            'nombre'           => $this->request->getPost('nombre'),
            'apellido_paterno' => $this->request->getPost('apellido_paterno'),
            'apellido_materno' => $this->request->getPost('apellido_materno'),
            'birthdate'        => $this->request->getPost('fecha_nacimiento')
        ];
    
        // Datos para la tabla Users
        $userData = [
            'fk_phone' => $tel,
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'fk_level' => 1 // <--- Forzamos nivel Administrador
        ];
    
        try {
            $db = \Config\Database::connect();
            $db->transStart(); // Iniciamos transacción
    
            $personModel->insert($personData);
            $userModel->insert($userData);
    
            $db->transComplete();
    
            if ($db->transStatus() === false) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Error al insertar en la base de datos']);
            }
    
            return $this->response->setJSON(['status' => 'success', 'message' => 'Administrador creado correctamente']);
    
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

}