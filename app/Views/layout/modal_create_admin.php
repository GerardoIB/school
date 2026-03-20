
<div class="modal fade" id="modalCrearAdmin" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Administrador</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formCrearAdmin" method="POST">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Teléfono (ID)</label>
                    <input type="number" class="form-control" name="tel" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Apellido Paterno</label>
                    <input type="text" class="form-control" name="apellido_paterno" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Apellido Materno</label>
                    <input type="text" class="form-control" name="apellido_materno" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" name="fecha_nacimiento" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Crear Administrador</button>
        </div>
      </form>
    </div>
  </div>
</div>
