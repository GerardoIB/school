<?php 

namespace App\Controllers;
 use App\Models\Users as UserModel;
 use App\Models\PersonsModel;

 class User extends BaseController {
    public function profile(){
        $userId = session() -> get('pk_user');
        $model = new UserModel();
        if(!$userId){
            return redirect() -> to(base_url('auth/login'));
        }
        $data['user'] = $model -> getDataPerson($userId);
        
        return view('user/profile',$data);
    }

    public function updateProfile($id) {
        $userModel = new UserModel();
        $personModel = new PersonsModel();
        
        $user = $userModel->find($id);
        if (!$user) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Usuario no encontrado']);
        }
    
        $data = [
            'nombre'           => $this->request->getVar('nombre'),
            'apellido_paterno' => $this->request->getVar('apellido_paterno'),
            'apellido_materno' => $this->request->getVar('apellido_materno'),
            'birthdate'        => $this->request->getVar('birthdate')
        ];
    
        try {
            // Usamos el Query Builder directamente para evitar la validación de "no data to update" del modelo
            // O simplemente verificamos si hubo cambios
            $db = \Config\Database::connect();
            $builder = $db->table('persons');
            $builder->where('pk_phone', $user['fk_phone']);
            $builder->update($data);
    
            // affectedRows() nos dice si realmente se cambió algo en la DB
            if ($db->affectedRows() >= 0) { 
                return $this->response->setJSON(['status' => 'success', 'message' => 'Información procesada']);
            }
    
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    
        return $this->response->setJSON(['status' => 'error', 'message' => 'No se pudo actualizar']);
    }
    public function logout(){
        session() -> destroy();
        return redirect() -> to(base_url('auth/login'));
    }
 }