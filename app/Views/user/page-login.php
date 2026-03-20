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
    <div class="login-box">
        
        <?php 
            $attributes = ['class' => 'login-form'];
            // Cambia 'auth/login' por la ruta o controlador que procesará el formulario
            echo form_open('auth/login', $attributes); 
        ?>
            <h3 class="login-head"><i class="bi bi-person me-2"></i>SIGN IN</h3>
            
            <div class="mb-3">
                <label class="form-label">Phone</label>
                <?= form_input([
                    'name'        => 'phone',
                    'class'       => 'form-control',
                    'placeholder' => 'Phone',
                    'autofocus'   => 'autofocus',
                    'value'       => set_value('phone') ,
                    'old'         => 'phone'// Mantiene el valor si hay error
                ]); ?>
                <small id="phoneHelp" class="form-text text-muted"><p class="text-danger"><?= validation_show_error('phone') ?></p></small> 	
            </div>

            <div class="mb-3">
                <label class="form-label">PASSWORD</label>
                <?= form_password([
                    'name'        => 'password',
                    'class'       => 'form-control',
                    'placeholder' => 'Password',
                ]); ?>
                <small id="phoneHelp" class="form-text text-muted"><p class="text-danger"><?= validation_show_error('password') ?></p></small> 	
            </div>

            <div class="mb-3">
                <div class="utility">
                    <div class="form-check">
                        <label class="form-check-label">
                            <?= form_checkbox(['name' => 'remember', 'class' => 'form-check-input', 'id' => 'remember']); ?>
                            <span class="label-text">Stay Signed in</span>
                        </label>
                    </div>
                    <p class="semibold-text mb-2"><a href="<?= url_to('formForget') ?>">Forgot Password ?</a></p>
                    <p class="semibold-text mb-2"><a href="<?= url_to('formRegister') ?>">Registrate</a></p>
                </div>
            </div>

            <div class="mb-3 btn-container d-grid">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="bi bi-box-arrow-in-right me-2 fs-5"></i>SIGN IN
                </button>
            </div>
        <?= form_close(); ?>

        <?php 
            $attributes_forget = ['class' => 'forget-form'];
            echo form_open('forgot-password', $attributes_forget); 
        ?>
            <h3 class="login-head"><i class="bi bi-person-lock me-2"></i>Forgot Password ?</h3>
            <div class="mb-3">
                <label class="form-label">EMAIL</label>
                <?= form_input([
                    'type'        => 'email',
                    'name'        => 'email',
                    'class'       => 'form-control',
                    'placeholder' => 'Email'
                ]); ?>
            </div>
            <div class="mb-3 btn-container d-grid">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="bi bi-unlock me-2 fs-5"></i>RESET
                </button>
            </div>
            <div class="mb-3 mt-3">
                <p class="semibold-text mb-0">
                    <a href="#" data-toggle="flip"><i class="bi bi-chevron-left me-1"></i> Back to Login</a>
                </p>
            </div>
        <?= form_close(); ?>

    </div>
</section>
<?= $this -> endSection() ?>
<?= $this->section('scripts') ?>
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
    <?php if (session()->getFlashdata('toast_message')) : ?>
        Toast.fire({
            icon: '<?= session()->getFlashdata('toast_type') ?>',
            title: '<?= session()->getFlashdata('toast_message') ?>'
        });
    <?php endif; ?>
    <?php if (session()->getFlashdata('error_usuario')) : ?>
        Toast.fire({
            icon: '<?= session()->getFlashdata('tipo_toast') ?>',
            title: '<?= session()->getFlashdata('error_usuario') ?>'
        });
    <?php endif; ?>
    <?php if (session()->getFlashdata('mensaje_toast')) : ?>
        Toast.fire({
            icon: '<?= session()->getFlashdata('tipo_toast') ?>',
            title: '<?= session()->getFlashdata('mensaje_toast') ?>'
        });
    <?php endif; ?>
</script>
<?= $this->endSection(); ?>