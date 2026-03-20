<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar shadow" style="background-color: #004a99 !important; border-right: 1px solid #003366;">
    
    <div class="app-sidebar__user bg-dark shadow-sm">
        <img class="app-sidebar__user-avatar" 
             src="https://ui-avatars.com/api/?name=<?= urlencode($user['nombre'] ?? 'U') ?>&background=0d6efd&color=fff" 
             alt="User Image" width="48">
        <div>
            <p class="app-sidebar__user-name text-white fw-bold mb-0"><?= $user['nombre'] ?? 'Invitado' ?></p>
            <p class="app-sidebar__user-designation text-light small"><?= $user['apellido_paterno'] ?? '' ?></p>
        </div>
    </div>
    
    <ul class="app-menu">
        <li>
            <a class="app-menu__item <?= url_is('dashboard*') ? 'active bg-primary border-start border-info' : 'text-white' ?>" href="<?= base_url('dashboard') ?>">
                <i class="app-menu__icon bi bi-speedometer2"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        
        <li class="treeview <?= url_is('users*') ? 'is-expanded' : '' ?>">
            <a class="app-menu__item text-white" href="#" data-toggle="treeview">
                <i class="app-menu__icon bi bi-people"></i>
                <span class="app-menu__label">Usuarios</span>
                <i class="treeview-indicator bi bi-chevron-right"></i>
            </a>
            <ul class="treeview-menu bg-dark shadow-inset">
                <li>
                    <a class="treeview-item text-white-50" href="<?= base_url('users') ?>">
                        <i class="icon bi bi-circle-fill" style="font-size: 0.5rem;"></i> Lista de Usuarios
                    </a>
                </li>
                <li>
                    <a class="treeview-item text-white-50" href="<?= base_url('users/create') ?>">
                        <i class="icon bi bi-circle-fill" style="font-size: 0.5rem;"></i> Crear Nuevo
                    </a>
                </li>
            </ul>
        </li>

        <hr class="border-light opacity-25 mx-3"> <li>
            <a class="app-menu__item text-white" href="<?= base_url('logout') ?>">
                <i class="app-menu__icon bi bi-box-arrow-right text-warning"></i>
                <span class="app-menu__label text-white">Cerrar Sesión</span>
            </a>
        </li>
    </ul>
</aside>