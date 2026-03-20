<?php

    namespace App\Filters;
    use CodeIgniter\HTTP\RequestInterface;
    use CodeIgniter\Filters\FilterInterface;

    class RoleFilter implements FilterInterface{
        public function before(RequestInterface $request, $arguments = null)
        {
                $session = session();
                $userLevel = (int) $session->get('fk_level'); 
                $requiredLevel = (int) $arguments[0];        
            
                if ($userLevel !== $requiredLevel) {
                    
                    if ($userLevel == 4) {
                        return redirect()->to(base_url('user/profile'))->with('error', 'Acceso restringido a administradores.');
                    }
                    
        
                    return redirect()->to(base_url('auth/login'));
                }
            
        }
    
        public function after(RequestInterface $request, $response, $arguments = null){
            // Do something here
        }
    }
