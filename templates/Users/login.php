<div class="login-box"> 
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body"> 
 
      <?= $this->Form->create() ?>
        <div class="input-group mb-3"> 
          
          <?= $this->Form->input('username', ['class'=>'form-control', 'placeholder' => 'Email']) ?>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
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
</div>
<!-- /.login-box -->