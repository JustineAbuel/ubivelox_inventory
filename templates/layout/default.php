 
<!DOCTYPE html>
<html lang="en">
<title>UBIVELOX - Inventory System</title>
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />

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
    <?php 
    $currentPath = lcfirst($this->request->getParam('controller'));
    $actionpath = lcfirst($this->request->getParam('action'));  
    
    $wildcard = $this->request->getParam('pass')  ? $this->request->getParam('pass')[0] :null ;
    $this->Breadcrumbs->add([
        ['title' => 'Home', 'url'=> ['controller' => 'Items', 'action' => 'dashboard'], 'options' => ['class'=>"breadcrumb-item"]],
        ['title' => ucfirst($currentPath), 'url' => ['controller' => $currentPath, 'action' => 'index'], 'options' => ['class'=>"breadcrumb-item"]]
    ]);
    $withwildcard = $wildcard ?  ' - ' . $wildcard : '';
    $this->Breadcrumbs->insertAfter(
        ucfirst($currentPath),
        ucfirst($actionpath).$withwildcard,  ['controller' => $currentPath, 'action' => $actionpath, $wildcard ], ['class'=>"breadcrumb-item", 'innerAttrs' => [
          'class' => 'text-dark', 
      ]]
    ); 
    
    // $options = ['class'=>"breadcrumb-item active"];
    // if($wildcard){
    //   $this->Breadcrumbs->insertAfter(
    //     ucfirst($actionpath),
    //     $wildcard,  ['controller' => $currentPath, 'action' => $actionpath, $wildcard ], ['class'=>"breadcrumb-item active"]
    //   ); 
    // }
    
    $this->Breadcrumbs->setTemplates([
        'wrapper' => '<nav class="col-sm-6"><ol class="breadcrumb float-sm-right" {{attrs}}>{{content}}</ol></nav>',
        'item' => ' <li  {{attrs}}><a href="{{url}}"{{innerAttrs}}>{{title}}</a></li>{{separator}}',
        'itemWithoutLink' => '<li {{attrs}}><span{{innerAttrs}}>{{title}}</span></li>{{separator}}',
    ]);
  
    ?>
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?=  ucfirst($currentPath) ?></h1>
          </div><!-- /.col -->
          <?= $this->Breadcrumbs->render();?>
           
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
