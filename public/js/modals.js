
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

    // 2. Ahora verificas si el usuario hizo clic en el botón de confirmar
    if (result.isConfirmed) {
        try {
            // Ajustamos la URL: base_url ya incluye la carpeta del proyecto
            // Asegúrate que en Routes.php tengas: $routes->delete('admin/delete/(:num)', 'Admin::delete/$1');
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
    
    // Mostrar el modal (Bootstrap 5)
    const myModal = new bootstrap.Modal(document.getElementById('modalEditarUsuario'));
    myModal.show();
}

// 2. Evento para enviar los datos actualizados
document.getElementById('formEditarUsuario').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const id = document.getElementById('edit_id').value;
    const formData = new FormData(e.target);

    formData.append('_method','PATCH')
    
    try {
        const response = await fetch(`<?= base_url('admin/update') ?>/${id}`, {
            method: 'POST', // Usamos POST porque CI4 maneja mejor FormData con POST
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
// Evento para Crear Admin
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
            Swal.fire('¡Éxito!', res.message, 'success').then(() => location.reload());
        } else {
            Swal.fire('Error', res.message, 'error');
        }
    } catch (error) {
        Swal.fire('Error', 'No se pudo conectar con el servidor', 'error');
    }
});