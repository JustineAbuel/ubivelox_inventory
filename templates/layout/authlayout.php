<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UBIVELOX Inventory</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  
  <!-- Font Awesome --> 
  <?= $this->Html->css('plugins/fontawesome-free/css/all.min.css') ?>  

  <!-- icheck bootstrap --> 
  <?= $this->Html->css('plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>  

  <!-- Theme style --> 
  <?= $this->Html->css('dist/css/adminlte.min.css') ?>  
</head>
<body class="hold-transition login-page">

<?= $this->Flash->render() ?>
<?= $this->fetch('content'); ?>

<!-- jQuery -->

<?= $this->Html->script('plugins/jquery/jquery.min.js'); ?> 
<!-- Bootstrap 4 --> 
<?= $this->Html->script('plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>
<!-- AdminLTE App --> 
<?= $this->Html->script('dist/js/adminlte.min.js'); ?>
</body>
</html>
