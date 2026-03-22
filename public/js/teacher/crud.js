// public/js/teacher/dashboard.js

$(document).ready(function() {

    // ------------------------------------
    // 1. INICIALIZAR DATATABLES (Alumnos)
    // ------------------------------------
    let table = $('#studentsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        responsive: true,
        ajax: {
            url: ROUTES.getAllStudents, // Usa la constante definida en la vista
            type: 'GET',
            dataSrc: function(json) {
                if(json.status === 200) {
                    return json.students;
                } else {
                    Swal.fire('Error', json.message || 'Error al cargar alumnos', 'error');
                    return [];
                }
            }
        },
        columns: [
            { 
                data: null, 
                render: function(data, type, row) {
                    return `${row.nombre} ${row.apellido_paterno} ${row.apellido_materno}`;
                }
            },
            { data: 'pk_phone' },
            { 
                data: 'gender',
                render: function(data) {
                    return data ? data.charAt(0).toUpperCase() + data.slice(1) : '';
                }
            },
            { 
                data: 'telegram_chat_id',
                render: function(data) {
                    return data ? data : '<span class="badge bg-secondary">Sin vincular</span>';
                }
            },
            { 
                // Columna de Acciones (Botón de Telegram)
                data: null, 
                orderable: false,
                render: function (data, type, row) {
                    if (row.telegram_chat_id) {
                        return `
                            <button class="btn btn-info btn-sm text-white btn-telegram" 
                                data-chatid="${row.telegram_chat_id}" 
                                data-name="${row.nombre} ${row.apellido_paterno}">
                                <i class="bi bi-telegram"></i> Enviar Mensaje
                            </button>
                        `;
                    } else {
                        return `
                            <button class="btn btn-secondary btn-sm" disabled title="El alumno no ha registrado su Telegram">
                                <i class="bi bi-telegram"></i> No disponible
                            </button>
                        `;
                    }
                }
            }
        ]
    });

    // ------------------------------------
    // 2. ABRIR MODAL DE TELEGRAM
    // ------------------------------------
    $('#studentsTable tbody').on('click', '.btn-telegram', function() {
        let chatId = $(this).data('chatid');
        let studentName = $(this).data('name');

        $('#telegram_target').val(chatId);       
        $('#telegram_target_name').val(studentName); 

        const myModal = new bootstrap.Modal(document.getElementById('modalTelegram'));
        myModal.show();
    });

    // ------------------------------------
    // 3. ENVIAR MENSAJE TELEGRAM (AJAX)
    // ------------------------------------
    $('#formTelegram').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        
        Swal.fire({
            title: 'Enviando mensaje...',
            text: 'Conectando con Telegram...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
            url: ROUTES.telegram, 
            type: 'POST',
            data: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success' || res.status === 200) {
                    Swal.fire('¡Enviado!', 'El mensaje ha sido enviado por Telegram al alumno.', 'success');
                    $('#telegram_message').val(''); 
                    
                    let modalEl = document.getElementById('modalTelegram');
                    let modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if(modalInstance) modalInstance.hide();
                } else {
                    Swal.fire('Error', res.message || 'No se pudo enviar el mensaje.', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'No se pudo conectar con el servidor', 'error');
            }
        });
    });
});