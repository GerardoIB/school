<?php
namespace App\Controllers;

class Prueba extends BaseController{
    public function index(){
        session() -> set('role','user');
        echo 'Has sido logueado como usuario';
       return $this -> response -> setJSON(["enc"=>password_hash('Jiqui50800%',PASSWORD_DEFAULT)]);
    }
}