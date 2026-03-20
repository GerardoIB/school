<?= $this->extend('layout/main_layout') ?>

<?= $this->section('content'); ?>
<?= helper('form');?>
<section class="material-half-bg">
    <div class="cover"></div>
</section>

<section class="login-content">
    <div class="logo">
        <?= $this->include('layout/logo_layout'); ?>
    </div>
    <div class="login-box" style="min-height: 700px; width: 550px;">
        
        <?php 
            $attributes = ['class' => 'login-form'];
            // Usamos url_to() para apuntar al alias de la ruta que tienes en Routes.php
            echo form_open(url_to('registerProcess'), $attributes); 
        ?>
            <h3 class="login-head"><i class="bi bi-person-plus me-2"></i>REGISTRO</h3>
            
            <div class="mb-3">
                <label class="form-label">NOMBRE(S)</label>
                <?= form_input([
                    'name'        => 'nombre',
                    'class'       => 'form-control',
                    'placeholder' => 'Tu nombre',
                    'required'    => 'required',
                    'value'       => set_value('nombre')
                ]); ?>
                 <small class="form-text text-muted"><p class="text-danger mb-0"><?= validation_show_error('nombre') ?></p></small>   
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">APELLIDO PATERNO</label>
                    <?= form_input([
                        'name'        => 'apellido_paterno',
                        'class'       => 'form-control',
                        'placeholder' => 'Paterno',
                        'required'    => 'required',
                        'value'       => set_value('apellido_paterno')
                    ]); ?>
                     <small class="form-text text-muted"><p class="text-danger mb-0"><?= validation_show_error('apellido_paterno') ?></p></small>     
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">APELLIDO MATERNO</label>
                    <?= form_input([
                        'name'        => 'apellido_materno',
                        'class'       => 'form-control',
                        'placeholder' => 'Materno',
                        'required'    => 'required',
                        'value'       => set_value('apellido_materno')
                    ]); ?>
                     <small class="form-text text-muted"><p class="text-danger mb-0"><?= validation_show_error('apellido_materno') ?></p></small>     
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 mb-3">
                    <label class="form-label">CURP</label>
                    <?= form_input([
                        'name'        => 'curp',
                        'class'       => 'form-control',
                        'placeholder' => '18 caracteres',
                        'required'    => 'required',
                        'style'       => 'text-transform: uppercase;',
                        'value'       => set_value('curp')
                    ]); ?>
                     <small class="form-text text-muted"><p class="text-danger mb-0"><?= validation_show_error('curp') ?></p></small>     
                </div>
                <div class="col-md-5 mb-3">
                    <label class="form-label">TELÉFONO</label>
                    <?= form_input([
                        'type'        => 'tel',
                        'name'        => 'tel',
                        'class'       => 'form-control',
                        'placeholder' => '10 dígitos',
                        'required'    => 'required',
                        'value'       => set_value('tel') // Corregido el set_value
                    ]); ?>
                     <small class="form-text text-muted"><p class="text-danger mb-0"><?= validation_show_error('tel') ?></p></small>  
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-danger">
                        <i class="bi bi-calendar-x-fill me-1"></i>NACIMIENTO
                    </label>
                    <?= form_input([
                        'type'        => 'date',
                        'name'        => 'fecha_nacimiento',
                        'class'       => 'form-control border-danger shadow-sm text-danger fw-bold', 
                        'required'    => 'required',
                        'value'       => set_value('fecha_nacimiento')
                    ]); ?>
                     <small class="form-text text-muted"><p class="text-danger mb-0"><?= validation_show_error('fecha_nacimiento') ?></p></small>   
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">EMAIL</label>
                    <?= form_input([
                        'type'        => 'email',
                        'name'        => 'email',
                        'class'       => 'form-control',
                        'placeholder' => 'correo@ejemplo.com',
                        'required'    => 'required',
                        'value'       => set_value('email')
                    ]); ?>
                     <small class="form-text text-muted"><p class="text-danger mb-0"><?= validation_show_error('email') ?></p></small>    
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">CONTRASEÑA</label>
                    <?= form_password([
                        'name'        => 'password',
                        'class'       => 'form-control',
                        'placeholder' => '********',
                        'required'    => 'required'
                    ]); ?>
                     <small class="form-text text-muted"><p class="text-danger mb-0"><?= validation_show_error('password') ?></p></small>     
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">CONFIRMAR</label>
                    <?= form_password([
                        'name'        => 'password_confirm',
                        'class'       => 'form-control',
                        'placeholder' => '********',
                        'required'    => 'required'
                    ]); ?>
                     <small class="form-text text-muted"><p class="text-danger mb-0"><?= validation_show_error('password_confirm') ?></p></small>     
                </div>
            </div>

            <div class="mb-3 btn-container d-grid">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="bi bi-check-circle me-2 fs-5"></i>FINALIZAR REGISTRO
                </button>
            </div>

            <div class="mb-3 mt-3">
                <p class="semibold-text mb-0 text-center">
                    <a href="<?= url_to('login') ?>">
                        <i class="bi bi-chevron-left me-1"></i> Regresar al Login
                    </a>
                </p>
            </div>
        <?= form_close(); ?>

    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    // Verificamos si existe la variable de sesión enviada desde el controlador
    <?php if (session()->getFlashdata('mensaje_toast')) : ?>
        Toast.fire({
            icon: '<?= session()->getFlashdata('tipo_toast') ?>',
            title: '<?= session()->getFlashdata('mensaje_toast') ?>'
        });
    <?php endif; ?>
</script>
<?= $this->endSection(); ?>