 
<!DOCTYPE html>
<html lang="en">
<title>UBP - Inventory System</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

<?php  include("header-items.php"); ?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Preloader -->
  <div class="d-none preloader flex-column justify-content-center align-items-center">
    <!--<img class="animation__shake" src="dist/img/ubivelox2.png" alt="AdminLTELogo" height="60" width="60">--> 
    <?php $this->Html->image('ubivelox2.png', array('width' => '200px','alt'=>'aswq')); ?> 
  </div>

  <?php include("navbar.php"); ?>

  <?php include("main-sidebar.php"); ?>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <?= $this->fetch('content'); ?>
  </div>
  

  <footer class="main-footer">
    <!--
    <strong>Copyright &copy; 2022-<?php echo date('Y'); ?></strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
    -->
      <!--<b>Version</b> 1-->
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->

</body>
</html>
