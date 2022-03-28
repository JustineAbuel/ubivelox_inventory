<?php 
// $user =  $this->request->getAttribute('identity');
// $user = $this->Identity->get(); 
$user = $this->request->getAttribute('authentication')->getIdentity();
// dd($user->image);
      // dd($user);
?>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo $this->Url->build(('/dashboard'), array('action' => 'dashboard')); ?>"" class="brand-link"> 
      
      <?= $this->Html->image('ubivelox2.png', ['width' => '200px','alt'=>'Ubivelox Icon', 'class' => 'brand-image img-circle elevation-3 ', 'style'=> 'opacity:.8']); ?> 
      <span class="brand-text font-weight-light">UBIVELOX</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex active">
        <div class="image"> 
           
      <?php  
      $imageclass = 'rounded-circle align-self-center';
      $imagestyle = 'height:2.1rem;width:2.1rem;object-fit: cover;';
      if(!$user->image){      
        echo $this->Html->image('avatar.png', ['class' => $imageclass, 'style' => $imagestyle,'alt'=>'User img' ]); 
      }else{
        echo $this->Html->image('uploads/profilepicture/'.$user->id.'/'.$user->image, ['class' => $imageclass, 'style' => $imagestyle,'alt'=>'User img' ]);   
      }
      ?>
        </div>
        <div class="info">
          <a href="/users/profile" class="d-block"><?= ucfirst($user->firstname) . ' ' . ucfirst($user->lastname)?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <!--
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
      -->

      <!-- Sidebar Menu -->
      <?php include("sidebar-menu.php"); ?>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>