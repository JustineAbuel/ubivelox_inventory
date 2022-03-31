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
                <h3 class="card-title"> <?= __('Edit Profile') ?> </h3> 
                
                <?= $this->Html->link(__('Change passowrd'), ['action' => 'change-password'], ['class' => 'button float-right btn btn-primary float-right  ']) ?>
 
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?= $this->Form->create($user,  ['type' => 'file', 'url' => ['controller'=> 'Users', 'action' => 'profile']]) ?> 
                
                <div class="row custom-padding">
                    <div class="col-sm-4"> 
                        <div class="form-group"> 
                            <?php 
                            
                            $imageclass = 'rounded-circle align-self-center mr-3';
                            $imagestyle = 'height:5rem;width:5rem;object-fit: cover;';
                            if(!$user->image){      
                                echo $this->Html->image('avatar.png', ['class' => $imageclass, 'style' => $imagestyle,'alt'=>'User img', 'id' => 'imageRender' ]); 

                            }else{
                                echo $this->Html->image('uploads/profilepicture/'.$user->id.'/'.$user->image, ['class' => $imageclass, 'style' => $imagestyle,'alt'=>'User img', 'id' => 'imageRender' ]);   
                            
                            }
                            ?>
                            <div class="custom-file mt-3">
                                <?= $this->Form->control('image_file', ['type' => 'file','class' => 'custom-file-input','id' => 'customFile', 'placeholder' => 'Image', 'label'=> false , 
                                    "accept"=>"image/png, image/gif, image/jpeg"
                                    ]); ?> 
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <span class="text-danger"><small><b> Only accepts .png, .jpg, .jpeg. File size must not exceed 5MB</b> </small></span>
                        </div>
                    </div> 
                </div>

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

    <script>
        document.getElementById("customFile").onchange = function () {
            var reader = new FileReader();

            reader.onload = function (e) {
                // get loaded data and render thumbnail.
                document.getElementById("imageRender").src = e.target.result;
            };

            // read the image file as a data URL.
            reader.readAsDataURL(this.files[0]);
        };
    </script>
