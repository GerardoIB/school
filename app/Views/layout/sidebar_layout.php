<?php
// 1. Obtenemos los datos desde la sesión (para no depender de la variable $user)
$userRole = session('fk_level') ?? session('fk_level') ?? 0; 
$nombre = $user['nombre'] ?? 'Invitado';
$apellido = session('apellido_paterno') ?? '';

// 2. Determinamos la ruta del dashboard según el nivel del usuario
$dashRoute = '';
$dashActive = '';

switch ($userRole) {
    case 1: // Admin
        $dashRoute = 'admin/dashboard';
        $dashActive = 'admin*';
        break;
    case 2: // Teacher
        $dashRoute = 'teacher/';
        $dashActive = 'teacher*';
        break;
    case 4: // User
        $dashRoute = 'user/profile';
        $dashActive = 'user*';
        break;
    default: // Estudiante o cualquier otro
        $dashRoute = 'student/dashboard';
        $dashActive = 'student*';
        break;
}
?>

<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar shadow" style="background-color: #004a99 !important; border-right: 1px solid #003366;">
    
    <div class="app-sidebar__user bg-dark shadow-sm">
        <img class="app-sidebar__user-avatar" 
             src="https://ui-avatars.com/api/?name=<?= urlencode($nombre) ?>&background=0d6efd&color=fff" 
             alt="User Image" width="48">
        <div>
            <p class="app-sidebar__user-name text-white fw-bold mb-0"><?= $nombre ?></p>
            <p class="app-sidebar__user-designation text-light small"><?= $apellido ?></p>
        </div>
    </div>
    
    <ul class="app-menu">
        <li>
            <a class="app-menu__item <?= url_is($dashActive) ? 'active bg-primary border-start border-info' : 'text-white' ?>" href="<?= base_url($dashRoute) ?>">
                <i class="app-menu__icon bi bi-speedometer2"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        
        <?php if ($userRole == 1): ?>
        <li class="treeview <?= url_is('users*') ? 'is-expanded' : '' ?>">
            <a class="app-menu__item text-white" href="#" data-toggle="treeview">
                <i class="app-menu__icon bi bi-people"></i>
                <span class="app-menu__label">Usuarios</span>
                <i class="treeview-indicator bi bi-chevron-right"></i>
            </a>
            <ul class="treeview-menu bg-dark shadow-inset">
                <li>
                    <a class="treeview-item text-white-50" href="<?= base_url('admin') ?>">
                        <i class="icon bi bi-circle-fill" style="font-size: 0.5rem;"></i> Lista de Usuarios
                    </a>
                </li>
                <li>
                    <a class="treeview-item text-white-50" href="<?= base_url('admin/create') ?>">
                        <i class="icon bi bi-circle-fill" style="font-size: 0.5rem;"></i> Crear Nuevo
                    </a>
                </li>
            </ul>
        </li>
        <?php endif; ?>

        <hr class="border-light opacity-25 mx-3"> 
        
        <li>
            <a class="app-menu__item text-white" href="<?= base_url('logout') ?>">
                <i class="app-menu__icon bi bi-box-arrow-right text-warning"></i>
                <span class="app-menu__label text-white">Cerrar Sesión</span>
            </a>
        </li>
    </ul>
</aside>