<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formEditarUsuario">
        <div class="modal-body">
            <input type="hidden" id="edit_id" name="id">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Apellido Paterno</label>
                <input type="text" class="form-control" id="edit_apellido_p" name="apellido_paterno" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Apellido Materno</label>
                <input type="text" class="form-control" id="edit_apellido_m" name="apellido_materno" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono (No editable)</label>
                <input type="text" class="form-control" id="edit_phone" readonly>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>