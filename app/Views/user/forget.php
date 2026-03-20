<?= $this->extend('layout/main_layout') ?>

<?= $this->section('content'); ?>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
        <?= $this -> include('layout/logo_layout');?>
    </div>
    <div class="login-box">
        <form class="login-form" action="<?= base_url('auth/do_forget') ?>" method="POST">
            <h3 class="login-head"><i class="bi bi-person-lock me-2"></i>¿Olvidaste tu clave?</h3>
            
            <p class="text-muted text-center mb-4">Ingresa tu correo electrónico y te enviaremos las instrucciones para restablecer tu contraseña.</p>

            <div class="mb-3">
                <label class="form-label">EMAIL</label>
                <input class="form-control" type="email" name="email" placeholder="Tu correo de registro" autofocus required>
            </div>

            <div class="mb-3 btn-container d-grid">
                <button class="btn btn-primary btn-block"><i class="bi bi-unlock me-2 fs-5"></i>RESTABLECER</button>
            </div>

            <div class="mb-3 mt-3">
                <p class="semibold-text mb-0">
                    <a href="<?= url_to('formLogin') ?>"><i class="bi bi-chevron-left me-1"></i> Volver al Login</a>
                </p>
            </div>
        </form>
    </div>
</section>
<?= $this->endSection(); ?>