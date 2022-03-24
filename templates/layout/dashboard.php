<!DOCTYPE html>
<html lang="en">
<?php include("header.php"); ?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <!--<img class="animation__shake" src="dist/img/ubivelox2.png" alt="AdminLTELogo" height="60" width="60">-->
    <img src="<?php echo $this->Url->webroot; ?>img/ubivelox2.png" alt="AdminLTELogo" height="60" width="60" /> 
  </div>

  <?php include("navbar.php"); ?>

  <?php include("main-sidebar.php"); ?>

  <?= $this->Flash->render() ?>
  <?= $this->fetch('content'); ?>
  <?= $this->fetch('script');?>
  <footer class="main-footer">
    <strong>Copyright &copy; 2022-<?php echo date('Y'); ?></strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
</body>
</html>
