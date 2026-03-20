<?php
    namespace App\Controllers;

    class Teacher extends BaseController {
        function index() {
            session() -> set('role', 'cajero');
            echo ' has sido logueado como cajero';
        }
    }