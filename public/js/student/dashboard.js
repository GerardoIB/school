$(document).ready(function() {
    // 1. Inicializar DataTables
    let table = $('#teachersTable').DataTable({
        "ajax": ROUTES.getAllData,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });

    // 2. Evento para abrir el modal y pasar los datos
    $('#teachersTable tbody').on('click', '.btn-telegram', function() {
        let chatId = $(this).data('chatid');
        let nombre = $(this).data('name');

        $('#telegram_target').val(chatId); // Input oculto
        $('#telegramModalLabel').text('Mensaje para el profesor: ' + nombre);
        $('#telegram_message').val(''); // Limpiar textarea
    });

    // 3. Evento para enviar el formulario por AJAX (Es EXACTAMENTE igual)
    $('#formTelegram').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        let btnSubmit = $(this).find('button[type="submit"]');
        let originalText = btnSubmit.html();

        btnSubmit.html('<i class="bi bi-hourglass-split"></i> Enviando...').prop('disabled', true);

        fetch(ROUTES.telegram, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                $('#telegramModal').modal('hide');
                Swal.fire('¡Enviado!', res.message, 'success');
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Hubo un problema de conexión.', 'error');
        })
        .finally(() => {
            btnSubmit.html(originalText).prop('disabled', false);
        });
    });
});