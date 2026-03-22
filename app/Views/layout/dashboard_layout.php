<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Vali Admin</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/main.css') ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="app sidebar-mini">
    
    <?= $this->include('layout/header_layout') ?>

    <?= $this -> include('layout/sidebar_layout') ?>

    <?= $this->include('layout/modal_create_admin') ?>

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><?= $this->renderSection('page_title') ?></h1>
                <p><?= $this->renderSection('page_description') ?></p>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            </ul>
        </div>

        <?= $this->renderSection('content') ?>
    </main>

    <script src="<?= base_url('public/js/jquery-3.7.0.min.js') ?>"></script>
    <script src="<?= base_url('public/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('public/js/main.js') ?>"></script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>