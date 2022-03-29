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
                <h3 class="card-title"> <?= __('Edit User') ?> </h3> 
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?= $this->Form->create($user) ?> 

                <div class="row custom-padding">
                   <div class="col-sm-4">
                       <!-- text input -->
                       <div class="form-group"> 
                           <?=  $this->Form->control('firstname', ['class' => 'form-control', 'placeholder' => 'First name', 'label' => false]); ?>
                          
                       </div>
                   </div>
                   <div class="col-sm-4">
                       <!-- text input -->
                       <div class="form-group">
                            <?=  $this->Form->control('middlename', ['class' => 'form-control', 'placeholder' => 'Middle name', 'label' => false]); ?>
                       
                       </div>
                   </div>
                   <div class="col-sm-4">
                       <!-- text input -->
                       <div class="form-group">
                            <?=  $this->Form->control('lastname', ['class' => 'form-control', 'placeholder' => 'Last name', 'label' => false]); ?>
                       
                       </div>
                   </div>
                </div> 

                <div class="row custom-padding">
                   <div class="col-sm-4">
                       <!-- text input -->
                       <div class="form-group"> 
                           <?=  $this->Form->control('email', ['class' => 'form-control', 'placeholder' => 'Email', 'label' => false]); ?>
                          
                       </div>
                   </div>
                   <div class="col-sm-4">
                       <!-- text input -->
                       <div class="form-group">
                            <?=  $this->Form->control('username', ['class' => 'form-control', 'placeholder' => 'Username', 'label' => false]); ?> 
                       
                       </div>
                   </div>
                </div>  
                <div class="row custom-padding"> 
                   <div class="col-sm-4">
                       <!-- text input -->
                       <div class="form-group"> 
                            <?=  $this->Form->control('contactno', ['class' => 'form-control', 'placeholder' => 'Contact no', 'label' => false]); ?>
                       
                       </div>
                   </div>
                   <div class="col-sm-4">
                       <!-- text input -->
                       <div class="form-group"> 
                            <?=  $this->Form->control('role_id', ['options' => $userRole, 'class' => 'form-control', 'placeholder' => 'Contact no', 'label' => false]); ?>
 
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
