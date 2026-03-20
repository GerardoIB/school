<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class UserFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Obtener el rol del usuario actual
        $userRole = session('role'); 
        echo $userRole;

        // Si no hay usuario logueado, mandar al login
        if (!$userRole) {
            return redirect()->to('/login');
        }

        // 2. Si no se pasaron argumentos en la ruta, el filtro es "pasivo" 
        // (o puedes decidir bloquear si no hay argumentos, depende de tu lógica)
        if (empty($arguments)) {
            return; 
        }

        // 3. Verificar si el rol del usuario ESTÁ en la lista de argumentos permitidos
        // $arguments es un array con los roles que envíes desde la ruta
        if (!in_array($userRole, $arguments)) {
            // Si el rol NO está permitido:
            
            // Opción A: Redirigir a una página de "Sin permiso"
           // return redirect()->to('/no-access')->with('error', 'No tienes permisos para esta sección.');
            
            // Opción B: Lanzar un error 403 (Prohibido)
             throw new \CodeIgniter\Exceptions\PageNotFoundException('No tienes permiso para acceder aquí.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Generalmente no necesitas nada aquí para roles
    }
}