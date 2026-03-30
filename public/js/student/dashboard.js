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

        $('#telegram_target').val(chatId);
        $('#telegram_target_name').val(nombre);
        $('#telegram_message').val('');

        const myModal = new bootstrap.Modal(document.getElementById('modalTelegram'));
        myModal.show();
    });

    // 3. Evento para enviar el formulario por AJAX
    $('#formTelegram').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        Swal.fire({
            title: 'Enviando mensaje...',
            text: 'Conectando con Telegram...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        fetch(ROUTES.telegram, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success' || res.status === 200) {
                Swal.fire('¡Enviado!', res.message || 'El mensaje ha sido enviado por Telegram.', 'success');
                $('#telegram_message').val('');

                let modalEl = document.getElementById('modalTelegram');
                let modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
            } else {
                Swal.fire('Error', res.message || 'No se pudo enviar el mensaje.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Hubo un problema de conexión.', 'error');
        });
    });
});