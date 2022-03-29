<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?> 
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
          <?= $this->Flash->render() ?>

            <div class="card">
              <div class="card-header">
                <h3 class="card-title"> <?= __('Change Password') ?> </h3> 
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?= $this->Form->create($user) ?> 

                <div class="row custom-padding"> 
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 
                            <?=  $this->Form->password('currentpassword', ['class' => 'form-control', 'placeholder' => 'Old Password']); ?> 
                       </div>
                   </div>
                </div>   
                <div class="row custom-padding"> 
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 
                            <?=  $this->Form->password('newpassword', ['class' => 'form-control', 'placeholder' => 'New Password']); ?>
                       
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 
                            <?=  $this->Form->password('retypepassword', ['class' => 'form-control', 'placeholder' => 'Confirm Password']); ?>
                       
                       </div>
                   </div>
                </div> 
                 

                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- Select multiple-->
                       <div class="form-group"> 
                            <?= $this->Form->button(__('Update'), ['class' => 'btn btn-primary']) ?>
                             
                           <a href="<?php echo $this->Url->build(('/users')); ?>" class="btn btn-warning"><font color="#F7F7F7">Cancel</font></a>
                       </div>
                   </div>
                </div>
                <?= $this->Form->end() ?>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
