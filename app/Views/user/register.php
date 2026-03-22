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
    
    <div class="login-box shadow-lg" style="min-height: 800px; width: 600px; border-radius: 10px;">
        
        <?php 
            $attributes = ['class' => 'login-form', 'id' => 'formRegistro'];
            echo form_open(url_to('registerProcess'), $attributes); 
        ?>
            <h3 class="login-head"><i class="bi bi-person-plus me-2"></i>REGISTRO DE ALUMNO</h3>
            
            <div class="mb-3">
                <label class="form-label fw-bold">NOMBRE(S)</label>
                <?= form_input([
                    'name'        => 'nombre',
                    'class'       => 'form-control ' . (validation_show_error('nombre') ? 'is-invalid' : ''),
                    'placeholder' => 'Ej. Juan Manuel',
                    'required'    => 'required',
                    'value'       => set_value('nombre')
                ]); ?>
                <div class="invalid-feedback"><?= validation_show_error('nombre') ?></div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">APELLIDO PATERNO</label>
                    <?= form_input([
                        'name'        => 'apellido_paterno',
                        'class'       => 'form-control ' . (validation_show_error('apellido_paterno') ? 'is-invalid' : ''),
                        'required'    => 'required',
                        'value'       => set_value('apellido_paterno')
                    ]); ?>
                    <div class="invalid-feedback"><?= validation_show_error('apellido_paterno') ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">APELLIDO MATERNO</label>
                    <?= form_input([
                        'name'        => 'apellido_materno',
                        'class'       => 'form-control ' . (validation_show_error('apellido_materno') ? 'is-invalid' : ''),
                        'required'    => 'required',
                        'value'       => set_value('apellido_materno')
                    ]); ?>
                    <div class="invalid-feedback"><?= validation_show_error('apellido_materno') ?></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-7 mb-3">
                    <label class="form-label fw-bold">CURP</label>
                    <?= form_input([
                        'name'        => 'curp',
                        'class'       => 'form-control ' . (validation_show_error('curp') ? 'is-invalid' : ''),
                        'placeholder' => '18 caracteres',
                        'maxlength'   => '18',
                        'required'    => 'required',
                        'style'       => 'text-transform: uppercase;',
                        'value'       => set_value('curp')
                    ]); ?>
                    <div class="invalid-feedback"><?= validation_show_error('curp') ?></div>
                </div>
                <div class="col-md-5 mb-3">
                    <label class="form-label fw-bold">TELÉFONO</label>
                    <?= form_input([
                        'type'        => 'tel',
                        'name'        => 'tel',
                        'class'       => 'form-control ' . (validation_show_error('tel') ? 'is-invalid' : ''),
                        'placeholder' => '10 dígitos',
                        'maxlength'   => '10',
                        'required'    => 'required',
                        'value'       => set_value('tel')
                    ]); ?>
                    <div class="invalid-feedback"><?= validation_show_error('tel') ?></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold text-info">
                        <i class="bi bi-telegram me-1"></i>TELEGRAM CHAT ID
                    </label>
                    <?= form_input([
                        'name'        => 'telegram_chat_id',
                        'class'       => 'form-control border-info ' . (validation_show_error('telegram_chat_id') ? 'is-invalid' : ''),
                        'placeholder' => 'Ej. 8254444833',
                        'value'       => set_value('telegram_chat_id')
                    ]); ?>
                    <small class="text-muted" style="font-size: 0.75rem;">Para recibir notificaciones del profesor.</small>
                    <div class="invalid-feedback"><?= validation_show_error('telegram_chat_id') ?></div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">FECHA NACIMIENTO</label>
                    <?= form_input([
                        'type'        => 'date',
                        'name'        => 'fecha_nacimiento',
                        'class'       => 'form-control ' . (validation_show_error('fecha_nacimiento') ? 'is-invalid' : ''), 
                        'required'    => 'required',
                        'value'       => set_value('fecha_nacimiento')
                    ]); ?>
                    <div class="invalid-feedback"><?= validation_show_error('fecha_nacimiento') ?></div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">CORREO ELECTRÓNICO</label>
                <?= form_input([
                    'type'        => 'email',
                    'name'        => 'email',
                    'class'       => 'form-control ' . (validation_show_error('email') ? 'is-invalid' : ''),
                    'placeholder' => 'correo@ejemplo.com',
                    'required'    => 'required',
                    'value'       => set_value('email')
                ]); ?>
                <div class="invalid-feedback"><?= validation_show_error('email') ?></div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">CONTRASEÑA</label>
                    <div class="input-group">
                        <?= form_password([
                            'name'        => 'password',
                            'id'          => 'password',
                            'class'       => 'form-control ' . (validation_show_error('password') ? 'is-invalid' : ''),
                            'required'    => 'required'
                        ]); ?>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="text-danger small mt-1"><?= validation_show_error('password') ?></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">CONFIRMAR</label>
                    <?= form_password([
                        'name'        => 'password_confirm',
                        'class'       => 'form-control ' . (validation_show_error('password_confirm') ? 'is-invalid' : ''),
                        'required'    => 'required'
                    ]); ?>
                    <div class="invalid-feedback"><?= validation_show_error('password_confirm') ?></div>
                </div>
            </div>

            <div class="mb-3 btn-container d-grid mt-4">
                <button type="submit" class="btn btn-primary btn-block p-2 fw-bold" id="btnSubmit">
                    <i class="bi bi-check-circle me-2 fs-5"></i>FINALIZAR REGISTRO
                </button>
            </div>

            <div class="mb-3 mt-3">
                <p class="semibold-text mb-0 text-center">
                    <a href="<?= url_to('login') ?>" class="text-decoration-none">
                        <i class="bi bi-chevron-left me-1"></i> Regresar al Login
                    </a>
                </p>
            </div>
        <?= form_close(); ?>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. Mostrar Toast de SweetAlert2
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000,
        timerProgressBar: true
    });

    <?php if (session()->getFlashdata('mensaje_toast')) : ?>
        Toast.fire({
            icon: '<?= session()->getFlashdata('tipo_toast') ?>',
            title: '<?= session()->getFlashdata('mensaje_toast') ?>'
        });
    <?php endif; ?>

    // 2. Mostrar/Ocultar contraseña
    document.getElementById('togglePassword').addEventListener('click', function (e) {
        const passInput = document.getElementById('password');
        const icon = this.querySelector('i');
        if (passInput.type === 'password') {
            passInput.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            passInput.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });

    // 3. Evitar doble envío del formulario
    document.getElementById('formRegistro').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Procesando...';
        btn.classList.add('disabled');
    });
</script>

<?= $this->endSection(); ?>