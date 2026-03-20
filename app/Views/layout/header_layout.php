<header class="app-header shadow-sm" style="background-color: #004a99 !important; border-bottom: 1px solid #003366;">
    
    <a class="app-header__logo fw-bold" 
       style="background-color: #003366 !important; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;" 
       href="<?= base_url('dashboard') ?>">
       <i class="bi bi-cpu me-2"></i>AdminPanel
    </a>

    <a class="app-header__toggle text-white" href="#" data-toggle="sidebar" aria-label="Hide Sidebar">
        <i class="bi bi-list fs-4"></i>
    </a>

    <ul class="app-nav">
        <li class="dropdown">
            <a class="app-nav__item text-white" href="#" data-bs-toggle="dropdown" aria-label="Show notifications">
                <i class="bi bi-bell fs-5"></i>
            </a>
            <ul class="app-notification dropdown-menu dropdown-menu-end shadow">
                <li class="app-notification__title">Tienes notificaciones nuevas.</li>
                </ul>
        </li>

        <li class="dropdown">
            <a class="app-nav__item text-white d-flex align-items-center" href="#" data-bs-toggle="dropdown" aria-label="Open Profile Menu">
                <i class="bi bi-person-circle fs-5 me-2"></i>
                <span class="d-none d-md-inline small"><?= $user['nombre'] ?? 'Usuario' ?></span>
            </a>
            <ul class="dropdown-menu settings-menu dropdown-menu-end shadow">
                <li>
                    <a class="dropdown-item" href="<?= base_url('user/profile') ?>">
                        <i class="bi bi-gear me-2 text-primary"></i> Configuración
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="<?= base_url('logout') ?>">
                        <i class="bi bi-box-arrow-right me-2 text-danger"></i> Salir
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</header>