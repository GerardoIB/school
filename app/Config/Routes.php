<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/prueba','Prueba::index');
$routes-> get('/logout','Admin::logout');
$routes -> group('/auth', function($routes){

    $routes -> get('login', 'Auth::login', ['as' => 'login']);
    $routes -> get('register', 'Auth::register',  ['as' => 'formRegister']);
    $routes -> get('forget', 'Auth::forget',  ['as' => 'formForget']);
   
    $routes -> post('login', 'Auth::processLogin', ['as' => 'processLogin']);
    $routes -> post('registerProcess', 'Auth::registerProcess',  ['as' => 'registerProcess']);
    $routes -> post('password','Auth::changePassword');

});

$routes -> group('/student', ['filter' => 'role'], function($routes){
    $routes -> get('dashboard', 'Student::dashboard');
});
$routes -> group('/teacher', ['filter' => 'role'], function($routes){
    $routes -> get('dashboard', 'Teacher::dashboard');
});

$routes -> group('/Vehiculos',['filter'=>'auth'],function($routes){
    $routes -> get('/','Vehiculo::index',['auth:admin,cajero,user']);
    $routes ->get('create','Vehiculo::create',['auth:admin,cajero']);
    $routes -> post('store','Vehiculo::store',[ 'auth:admin,cajero']);
    $routes -> get('edit/(:num)','Vehiculo::edit/$1',[ 'auth:admin,cajero']);
    $routes -> patch('update/(:num)','Vehiculo::update/$1',[ 'auth:admin']);
    $routes -> delete('delete/(:num)','Vehiculo::delete/$1',[ 'auth:admin']);

});

// GRUPO ADMIN (Nivel 1)
$routes->group('/admin', ['filter' => 'role:1'], function($routes) {
    $routes->get('dashboard', 'Admin::dashboard', ['as' => 'dash']);
    $routes->post('levels', 'Levels::create');
    $routes->get('levels/read', 'Levels::read');
    $routes->get('levels/delete/(:num)', 'Levels::delete/$1');
    $routes ->patch('update/(:num)','Admin::updateProfile/$1');
    $routes -> post('/','Admin::create');
    $routes -> get('assign','Admin::assign');
    $routes -> post('storeAssignment', 'Admin::storeAssignment');
    // Cambié el filtro aquí para que use la misma lógica de nivel 1
    $routes->delete('users/(:num)', 'Admin::delete/$1'); 
});

// GRUPO USER (Nivel 4)
$routes->group('user', ['filter' => 'role:4'], function($routes) {
    $routes->get('profile', 'User::profile');
    $routes -> patch('(:num)','User::updateProfile/$1');
});

$routes -> group('product',function($routes){
    $routes -> get('', 'Product::index');
    $routes -> post('update','Product::update');
});



// Rutas para Telegram
$routes->get('/api/telegram', 'Api::telegram');
$routes->post('/api/telegram/send', 'Api::telegram');

//Rutas teacher 
$routes -> group('/teacher',['filter'=>'role:2'], function($routes){
    $routes -> get('/','Teacher::index');
    $routes -> get('getAll','Teacher::getAllStudents');

});
// GRUPO STUDENT (Nivel 3 o el que le corresponda)
$routes->group('/student', ['filter' => 'role:3'], function($routes){ // Asegúrate de poner el número de rol correcto en el filtro
    $routes->get('/', 'Student::dashboard');
    $routes->get('getAllTeachers', 'Student::getAllTeachers'); // <-- Nueva ruta para DataTables
});

$routes -> get("/encriptar", 'Prueba::index');
