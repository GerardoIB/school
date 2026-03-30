<?= $this->extend('layout/dashboard_layout') ?>

<?= $this->section('page_title') ?>
    <i class="bi bi-person-badge me-2"></i> Mis Profesores
<?= $this->endSection() ?>

<?= $this->section('page_description') ?>
    Panel de alumno. Aquí puedes ver la lista de tus profesores y enviarles dudas por Telegram.
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title">Directorio de Profesores</h3>
            </div>
            
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="teachersTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre del Profesor</th>
                                <th>Teléfono</th>
                                <th>Telegram ID</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('layout/modal_telegram') ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!--<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>-->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

<script>
    const BASE_URL = '<?= base_url() ?>';
    const ROUTES = {
        // Apuntamos a la ruta del controlador Student
        getAllData: `${BASE_URL}/student/getAllTeachers`, 
        // ¡Usamos la misma API de Telegram que ya funciona!
        telegram: `${BASE_URL}/api/telegram/send` 
    };
</script>

<script src="<?= base_url('public/js/student/dashboard.js') ?>"></script>
<?= $this->endSection() ?>