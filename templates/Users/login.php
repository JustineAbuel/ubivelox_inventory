<div class="login-box"> 

  <div class="login-logo">
    <!-- <a href="../../index2.html"><b>Admin</b>LTE</a> -->
    <?=  $this->Html->image('ubiveloxiconpng.png', ['alt' => 'Ubivelox', 'class' => 'px-5 img-fluid']); ?>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body"> 
 
    
      <?= $this->Form->create() ?>
        <div class="input-group mb-3"> 
          
          <?= $this->Form->input('username', ['class'=>'form-control', 'placeholder' => 'Username']) ?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <?= $this->Form->password('password', ['class'=>'form-control', 'placeholder' => 'Password', 'label' => false]) ?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <!-- <a href="register.html" class="text-center">Register</a> -->
          </div>
          <!-- /.col -->
          <div class="col-4"> 
            
            <?= $this->Form->button('Login', ['class' => 'btn btn-primary btn-block']) ?>
            
          </div>
          <!-- /.col -->
        </div>
        
        <?= $this->Form->end() ?>
   
    </div>
    
    <!-- /.login-card-body -->
  </div>
  <center><small >Copyright &copy; <?php echo date('Y'); ?> Ubivelox Inc. All rights reserved.  </small></center>
  
</div>
<!-- /.login-box -->