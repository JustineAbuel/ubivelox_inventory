  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li> 
      
      <li class="nav-item dropdown">
        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Forms</a>
        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
          <li><?= $this->Html->link('Items form', ['controller' => 'Items', 'action' => 'downloaditemform'], ['class' => 'dropdown-item'])?></li>
          <li><?= $this->Html->link('Categories form', ['controller' => 'Categories', 'action' => 'downloadcategoriesform'], ['class' => 'dropdown-item'])?></li>
          <li><?= $this->Html->link('Subcategories form', ['controller' => 'Subcategories', 'action' => 'downloadsubcategoriesform'], ['class' => 'dropdown-item'])?></li>
          <li><?= $this->Html->link('Company form', ['controller' => 'Company', 'action' => 'downloadcompanyform'], ['class' => 'dropdown-item'])?></li>
 
       
        </ul>
      </li>

    </ul>
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <!--
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>

        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      -->

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button" title="Fullscreen">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
       
      <li class="nav-item">
        <a class="nav-link" <?php echo $this->Html->link("
        <i class='fas fa-sign-out-alt' title='Logout'></i>", 
        [
          'controller' => 'Users',
          'action' => 'logout'
        ], [
          'confirm' => 'Are you sure you want to logout?',
        'escape' => false //'escape' => false - convert plain text to html
        ] 
        ); 
        ?>

      <?php echo "</li>"; ?>
    <?php echo "</ul>"; ?>
  <?php echo "</nav>"; ?>
<?php //navbar ?>