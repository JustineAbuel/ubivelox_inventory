<!DOCTYPE html>
<html lang="en">
<head>
<title>UBIVELOX</title>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

<style type="text/css">
    .error-message {
    background-color:#a90329;
    color:#fff;
    }
</style>

<!-- CSS -->
<!-- Google Font: Source Sans Pro -->
<?= $this->Html->css('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') ?>
<!-- Font Awesome -->
<?= $this->Html->css('plugins/fontawesome-free/css/all.min') ?>
<!-- Ionicons -->
<?= $this->Html->css('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') ?>
<!-- Tempusdominus Bootstrap 4 -->
<?= $this->Html->css('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min') ?>
<!-- iCheck -->
<?= $this->Html->css('plugins/icheck-bootstrap/icheck-bootstrap.min') ?>
<!-- JQVMap -->
<?= $this->Html->css('plugins/jqvmap/jqvmap.min'); ?>
<!-- Theme style -->
<?= $this->Html->css('dist/css/adminlte.min'); ?>
<!-- overlayScrollbars -->
<?= $this->Html->css('plugins/overlayScrollbars/css/OverlayScrollbars.min'); ?>
<!-- Daterange picker -->    
<?= $this->Html->css('plugins/daterangepicker/daterangepicker'); ?>
<!-- summernote -->
<?= $this->Html->css('plugins/summernote/summernote-bs4.min'); ?>

<!-- jQuery -->
<?= $this->Html->script('plugins/jquery/jquery.min'); ?>
<!-- jQuery UI 1.11.4 -->
<?= $this->Html->script('plugins/jquery-ui/jquery-ui.min'); ?>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<?= $this->Html->script('plugins/bootstrap/js/bootstrap.bundle.min'); ?>
<!-- ChartJS -->
<?= $this->Html->script('plugins/chart.js/Chart.min'); ?>
<!-- Sparkline -->
<?= $this->Html->script('plugins/sparklines/sparkline'); ?>
<!-- JQVMap -->
<?= $this->Html->script('plugins/jqvmap/jquery.vmap.min'); ?>
<?= $this->Html->script('plugins/jqvmap/maps/jquery.vmap.usa'); ?>
<!-- jQuery Knob Chart -->
<?= $this->Html->script('plugins/jquery-knob/jquery.knob.min'); ?>
<!-- daterangepicker -->
<?= $this->Html->script('plugins/moment/moment.min'); ?>
<?= $this->Html->script('plugins/daterangepicker/daterangepicker'); ?>
<!-- Tempusdominus Bootstrap 4 -->
<?= $this->Html->script('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min'); ?>
<!-- Summernote -->
<?= $this->Html->script('plugins/summernote/summernote-bs4.min'); ?>
<!-- overlayScrollbars -->
<?= $this->Html->script('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min'); ?>
<!-- AdminLTE App -->
<?= $this->Html->script('dist/js/adminlte'); ?>
<!-- AdminLTE for demo purposes -->
<!--<script src="dist/js/demo.js"></script>-->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<?= $this->Html->script('dist/js/pages/dashboard'); ?>
</head>

<!-- Display content here -->
<?php //echo $this->fetch('content'); ?>