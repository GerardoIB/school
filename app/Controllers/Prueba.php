<?php
namespace App\Controllers;

class Prueba extends BaseController{
    public function index(){
        session() -> set('role','user');
        echo 'Has sido logueado como usuario';
    }
}