<?= $this->extend('layout/dashboard_layout') ?>

<?= $this->section('page_title') ?>
    <i class="bi bi-people-fill me-2"></i> Mis Alumnos
<?= $this->endSection() ?>

<?= $this->section('page_description') ?>
    Panel de control. Aquí puedes ver la lista de los alumnos que tienes asignados y enviarles mensajes.
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title">Lista de Alumnos</h3>
            </div>
            
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="studentsTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nombre Completo</th>
                                <th>Teléfono</th>
                                <th>Género</th>
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

<script>
    const BASE_URL = '<?= base_url() ?>';
    const ROUTES = {
        getAllStudents: `${BASE_URL}/teacher/getAll`, 
        telegram: `${BASE_URL}/api/telegram/send` 
    };
</script>

<script src="<?= base_url('public/js/teacher/crud.js') ?>"></script>
<?= $this->endSection() ?>