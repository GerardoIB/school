<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>GerardoDev | Portal Escolar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #1e293b;
            --accent: #6366f1;
            --admin-color: #ef4444;
            --teacher-color: #f59e0b;
            --student-color: #10b981;
            --bg: #f1f5f9;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg);
            margin: 0;
            color: #334155;
        }

        header {
            background: var(--primary);
            color: white;
            padding: 3rem 1rem;
            text-align: center;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0% 100%);
        }

        .container {
            max-width: 1100px;
            margin: -50px auto 50px;
            padding: 0 20px;
        }

        .welcome-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .grid-routes {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .route-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            border-left: 5px solid #cbd5e1;
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .route-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        /* Colores por Rol */
        .card-admin { border-left-color: var(--admin-color); }
        .card-teacher { border-left-color: var(--teacher-color); }
        .card-student { border-left-color: var(--student-color); }
        .card-auth { border-left-color: var(--accent); }

        .route-card h3 {
            margin-top: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .route-card p { font-size: 0.9rem; color: #64748b; }

        .btn-link {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            font-weight: bold;
            color: var(--accent);
            font-size: 0.85rem;
        }

        .badge {
            font-size: 0.7rem;
            padding: 2px 8px;
            border-radius: 10px;
            background: #e2e8f0;
            margin-left: 5px;
        }

        footer {
            text-align: center;
            padding: 3rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<header>
    <h1><i class="fas fa-graduation-cap"></i> Sistema Escolar Pro</h1>
    <p>Proyecto CI4 + AWS + SSL + Telegram API</p>
</header>

<div class="container">
    <div class="welcome-card">
        <div>
            <h2>¡Hola, Gerardo!</h2>
            <p>El sistema está listo. Las rutas filtradas requieren autenticación.</p>
        </div>
        <div>
            <a href="<?= url_to('login') ?>" style="background: var(--accent); color:white; padding: 10px 25px; border-radius: 8px; text-decoration:none; font-weight:bold;">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </a>
        </div>
    </div>

    <div class="grid-routes">
        <div class="route-card card-auth">
            <h3><i class="fas fa-key"></i> Autenticación <span class="badge">Público</span></h3>
            <p>Rutas: /auth/login, /auth/register</p>
            <a href="<?= url_to('formRegister') ?>" class="btn-link">Registrar nuevo usuario →</a>
        </div>

        <div class="route-card card-admin">
            <h3><i class="fas fa-user-shield"></i> Panel Admin <span class="badge">Rol: 1</span></h3>
            <p>Control de niveles, asignaciones y gestión de usuarios.</p>
            <a href="/admin/dashboard" class="btn-link">Ir al Dashboard →</a>
        </div>

        <div class="route-card card-teacher">
            <h3><i class="fas fa-chalkboard-teacher"></i> Profesores <span class="badge">Rol: 2</span></h3>
            <p>Visualización de estudiantes y gestión académica.</p>
            <a href="/teacher" class="btn-link">Ver mis alumnos →</a>
        </div>

        <div class="route-card card-student">
            <h3><i class="fas fa-user-graduate"></i> Estudiantes <span class="badge">Rol: 3</span></h3>
            <p>Acceso a dashboard personal y lista de profesores.</p>
            <a href="/student" class="btn-link">Mi Dashboard →</a>
        </div>

        <div class="route-card">
            <h3><i class="fas fa-car"></i> Vehículos <span class="badge">Auth Filter</span></h3>
            <p>Módulo de inventario (Admin, Cajero, User).</p>
            <a href="/Vehiculos" class="btn-link">Inventario →</a>
        </div>

        <div class="route-card" style="border-left-color: #0088cc;">
            <h3><i class="fab fa-telegram"></i> Telegram API</h3>
            <p>Integración de notificaciones vía Webhook.</p>
            <a href="/api/telegram" class="btn-link">Probar API →</a>
        </div>
    </div>
</div>

<footer>
    <p>Entorno: <strong><?= ENVIRONMENT ?></strong> | CI v<?= CodeIgniter\CodeIgniter::CI_VERSION ?></p>
    <p>&copy; <?= date('Y') ?> - Desarrollo Escolar en AWS, Gerardo Iglesias </p>
</footer>

</body>
</html>