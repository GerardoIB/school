<?= $this->extend('layout/dashboard_layout') ?>

<?= $this->section('page_title') ?>
    <i class="bi bi-person-circle me-2"></i> Mi Perfil
<?= $this->endSection() ?>

<?= $this->section('page_description') ?>
    Aquí puedes consultar y gestionar tu información personal.
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-4">
        <div class="tile">
            <div class="tile-body text-center">
                <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['nombre']) ?>&size=128&background=009688&color=fff" 
                     class="rounded-circle mb-3" alt="User Image">
                <h4><?= $user['nombre'] . ' ' . $user['apellido_paterno'] ?></h4>
                <p class="text-muted"><?= ($user['fk_level'] == 1) ? 'Administrador' : 'Usuario Estándar' ?></p>
            </div>
            
        </div>
    </div>

    <div class="col-md-8">
        <div class="tile">
            <h3 class="tile-title">Datos Personales</h3>
            <div class="tile-body">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 30%">Teléfono:</th>
                            <td><?= $user['pk_phone'] ?></td>
                        </tr>
                        <tr>
                            <th>Género:</th>
                            <td><?= ($user['gender'] == 'M') ? 'Masculino' : 'Femenino' ?></td>
                        </tr>
                        <tr>
                            <th>Fecha de Nacimiento:</th>
                            <td><?= date('d/m/Y', strtotime($user['birthdate'])) ?></td>
                        </tr>
                        <tr>
                            <th>Nivel de Acceso:</th>
                            <td><span class="badge bg-info">Nivel <?= $user['fk_level'] ?></span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tile-footer">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditarPerfil">
    <i class="bi bi-pencil-square me-2"></i>Editar Datos
</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalEditarPerfil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i> Actualizar Mi Información</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formUpdateProfile">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre(s)</label>
                            <input type="text" name="nombre" class="form-control" value="<?= $user['nombre'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellido Paterno</label>
                            <input type="text" name="apellido_paterno" class="form-control" value="<?= $user['apellido_paterno'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellido Materno</label>
                            <input type="text" name="apellido_materno" class="form-control" value="<?= $user['apellido_materno'] ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fecha de Nacimiento</label>
                            <input type="datetime" name="birthdate" class="form-control" value="<?= $user['birthdate'] ?>" required>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i> El teléfono (<?= $user['pk_phone'] ?>) no se puede modificar ya que es tu identificador de cuenta.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->include('layout/sidebar_layout') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
document.getElementById('formUpdateProfile').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    // Agregamos el spoofing para PATCH
    formData.append('_method', 'PATCH'); 

    // Mostramos estado de carga
    Swal.fire({
        title: 'Procesando...',
        didOpen: () => { Swal.showLoading() }
    });

    try {
        // Usamos el ID del usuario actual que viene de la sesión o del objeto $user
        const response = await fetch(`<?= base_url('user/'.$user['pk_user']) ?>`, {
            method: 'POST', // Físicamente POST, lógicamente PATCH
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: formData
        });

        const res = await response.json();

        if (res.status === 'success') {
            await Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: res.message,
                timer: 2000
            });
            location.reload(); // Recargamos para ver los cambios reflejados
        } else {
            Swal.fire('Error', res.message || 'No se pudo actualizar', 'error');
        }
    } catch (error) {
        Swal.fire('Error', 'Error de conexión con el servidor', 'error');
    }
});
</script>
<?= $this->endSection() ?>