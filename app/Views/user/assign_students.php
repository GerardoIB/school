<?= $this->extend('layout/dashboard_layout') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-5">
        <div class="tile">
            <h3 class="tile-title"><i class="bi bi-person-plus"></i> Nueva Asignación</h3>
            <div class="tile-body">
                <form id="formAsignacion">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Profesor</label>
                        <select name="teacher_id" class="form-control" required>
                            <option value="">Seleccione al docente...</option>
                            <?php foreach($teachers as $t): ?>
                                <option value="<?= $t['pk_user'] ?>"><?= $t['nombre'] ?> <?= $t['apellido_paterno'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alumno</label>
                        <select name="student_id" class="form-control" required>
                            <option value="">Seleccione al alumno...</option>
                            <?php foreach($students as $s): ?>
                                <option value="<?= $s['pk_user'] ?>"><?= $s['nombre'] ?> <?= $s['apellido_paterno'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Asignar Ahora</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="tile">
            <h3 class="tile-title">Asignaciones Actuales</h3>
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th>Profesor</th>
                            <th>Alumno</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($assignments as $a): ?>
                        <tr>
                            <td><?= $a['profe_n'] ?></td>
                            <td><?= $a['alumno_n'] ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="quitarAsignacion(<?= $a['id'] ?>)">
                                    <i class="bi bi-trash"></i>
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Guardar
document.getElementById('formAsignacion').addEventListener('submit', async (e) => {
    e.preventDefault();
    const res = await fetch('<?= base_url('admin/storeAssignment') ?>', {
        method: 'POST',
        body: new FormData(e.target)
    }).then(r => r.json());
    
    if(res.status === 'success') location.reload();
    else Swal.fire('Error', res.message, 'error');
});

// Eliminar
async function quitarAsignacion(id) {
    if(!confirm('¿Eliminar esta asignación?')) return;
    const res = await fetch(`<?= base_url('admin/deleteAssignment') ?>/${id}`, { method: 'DELETE' }).then(r => r.json());
    if(res.status === 'success') location.reload();
}
</script>
<?= $this->endSection() ?>