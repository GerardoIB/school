<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('public/css/main.css')?>">
    <link rel="shortcut icon" href="<?= base_url('public/test.svg');?>" type="image/svg">
    <!-- Font-icon css-->

    <title>Login - Vali Admin</title>
  </head>
  <body>

  <?= $this ->renderSection('content');?>

  <?= $this->renderSection('scripts') ?>

  <script src="<?= base_url('public/js/jquery-3.7.0.min.js')?>"></script>
    <script src="<?= base_url('public/js/bootstrap.min.js')?>"></script>
    <script src="<?= base_url('public/js/main.js')?>"></script>
  
    <script type="text/javascript">
      // Login Page Flipbox control
      $('.login-content [data-toggle="flip"]').click(function() {
      	$('.login-box').toggleClass('flipped');
      	return false;
      });
    </script>
  </body>
</html>