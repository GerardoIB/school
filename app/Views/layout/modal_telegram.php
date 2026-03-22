<div class="modal fade" id="modalTelegram" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="bi bi-telegram"></i> Mensaje a Alumno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formTelegram">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Destinatario</label>
                        <input type="text" class="form-control" id="telegram_target_name" readonly>
                    </div>
                    <input type="hidden" id="telegram_target" name="telegram_id">

                    <div class="mb-3">
                        <label class="form-label">Mensaje</label>
                        <textarea class="form-control" id="telegram_message" name="message" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-info text-white">Enviar Mensaje</button>
                </div>
            </form>
        </div>
    </div>
</div>