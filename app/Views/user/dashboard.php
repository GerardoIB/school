<?= $this->extend('layout/dashboard_layout') ?>

<?= $this->section('page_title') ?>
    <i class="bi bi-speedometer me-2"></i> Panel de Control
<?= $this->endSection() ?>

<?= $this->section('page_description') ?>
    Resumen general del estado de tus contenedores y nodos.
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-title-w-btn">
                <h3 class="title">Lista de Usuarios</h3>
                <button class="btn btn-success icon-btn" type="button" data-bs-toggle="modal" data-bs-target="#modalCrearAdmin">
    <i class="bi  bi-plus-circle"></i> Nuevo Administrador
</button>
            </div>
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Teléfono (FK)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $u): ?>
                            <tr>
                                <td><?= $u['nombre'] ?></td>
                                <td><?= $u['apellido_paterno'] ?></td>
                                <td><?= $u['pk_phone'] ?></td>
                                <td>
       
                                    <button class="btn btn-danger btn-sm" onclick="eliminarUsuario(<?= $u['pk_user'] ?>)"><i class="bi bi-trash"></i></button>
                                    <button class="btn btn-warning btn-sm" onclick="abrirModalEditar(<?= htmlspecialchars(json_encode($u)) ?>)">
    <i class="bi bi-pencil-square"></i>
</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->include('layout/modal_edit_user') ?>
 <?= $this->include('layout/sidebar_layout') ?>
 <?= $this->include('layout/modal_create_admin') ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>

async function eliminarUsuario(id) {
    // 1. Debes guardar el resultado de la promesa en una variable usando 'await'
    const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });

    
    if (result.isConfirmed) {
        try {
           
            const response = await fetch(`<?= base_url('admin/users') ?>/${id}`, {
                method: 'DELETE', 
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const res = await response.json();

            if (res.status === 'success') {
                await Swal.fire('¡Eliminado!', res.message, 'success');
                location.reload(); 
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire('Error', 'Hubo un error al procesar la solicitud.', 'error');
        }   
}
}
function abrirModalEditar(usuario) {
    document.getElementById('edit_id').value = usuario.pk_user;
    document.getElementById('edit_nombre').value = usuario.nombre;
    document.getElementById('edit_apellido_p').value = usuario.apellido_paterno;
    document.getElementById('edit_apellido_m').value = usuario.apellido_materno;
    document.getElementById('edit_phone').value = usuario.pk_phone;
    

    const myModal = new bootstrap.Modal(document.getElementById('modalEditarUsuario'));
    myModal.show();
}


document.getElementById('formEditarUsuario').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const id = document.getElementById('edit_id').value;
    const formData = new FormData(e.target);

    formData.append('_method','PATCH')
    
    try {
        const response = await fetch(`<?= base_url('admin/update') ?>/${id}`, {
            method: 'POST', 
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body:formData
        });

        const res = await response.json();

        if (res.status === 'success') {
            Swal.fire('¡Actualizado!', res.message, 'success').then(() => location.reload());
        } else {
            Swal.fire('Error', res.message, 'error');
        }
    } catch (error) {
        Swal.fire('Error', 'No se pudo conectar con el servidor', 'error');
    }
});

document.getElementById('formCrearAdmin').addEventListener('submit', async (e) => {

    e.preventDefault(); 
    
    const formData = new FormData(e.target);
    
    try {
        const response = await fetch(`<?= base_url('admin') ?>`, {
            method: 'POST', 
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        });

        const res = await response.json();

        if (res.status === 'success') {
            Swal.fire('¡Creado!', res.message, 'success').then(() => location.reload());
        } else {
            Swal.fire('Error', res.message, 'error');
        }
    } catch (error) {
        Swal.fire('Error', 'No se pudo conectar con el servidor', 'error');
    }
});
</script>
<?= $this->endSection() ?>