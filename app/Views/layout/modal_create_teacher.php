<div class="modal fade" id="modalCrearTeacher" tabindex="-1" aria-labelledby="modalCrearTeacherLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalCrearTeacherLabel">
                    <i class="bi bi-person-plus-fill me-2"></i>Nuevo Profesor
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCrearTeacher">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Ej. Juan Pérez">
                    </div>
                    <div class="mb-3">
                        <label for="specialty" class="form-label">Especialidad <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="specialty" name="specialty" required placeholder="Ej. Matemáticas">
                    </div>
                    <div class="mb-3">
                        <label for="telegram_id" class="form-label">Telegram Chat ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="telegram_id" name="telegram_id" required placeholder="Ej. 123456789">
                        <div class="form-text">El ID numérico del chat de Telegram del profesor.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Guardar Profesor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>