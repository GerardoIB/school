<?php

namespace App\Controllers;

use App\Models\LevelsModel;

class Levels extends BaseController {
  
    public function create() {
     $controller = new LevelsModel();

     // Esto intenta obtener 'role' ya sea que venga de un formulario o de un JSON
    $json = $this->request->getJSON();
    $role = $json->role ?? $this->request->getPost('role');

    
    $data = [
        "id" => 4,
        "role" => $role
    ];

     if($controller->insert($data)){
        echo 'Nivel creado exitosamente';
        return $this -> response ->setJSON(["message"=> "ha sido creado exitosamente",
                                            "status" => 201]);
     }else{
        return $this -> response -> setJSON(["message" => "Algo ha salid mal",
                                             "status" => 500]);
     }
     echo 'Create levels';
    }

    public function read() {
        $model = new LevelsModel();
        
        $data = $model -> findAll();

        return $this -> response -> setJSON($data);
    }

    public function delete($id){
        $model = new LevelsModel();
        $data = $this -> request -> getPost(['']);
        
        try{
        if($model ->find($id)){
            $model -> where('id', $id) -> delete();
            return $this -> response -> setJSON(['message' => 'ha sido eliminado correcatamente']);
        }else{
            print_r($model -> errors());
            return $this -> response -> setJSON(['message' => 'Nivel no existe']);
        }
            } catch(Exception $e){
                return $this -> response -> setJSON(['message' => 'Ocurrio un error inesperado']);
            }

    }

    }
