<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 */
?> 
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

          <?= $this->Flash->render() ?>
          
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Edit Company</h3> 
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?= $this->Form->create($company) ?>
                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 
                           <?=  $this->Form->control('company_name', ['class' => 'form-control', 'placeholder' => 'Company name']); ?>
                          
                       </div>
                   </div>
                   

                   <div class="col-sm-6">
                       <!-- text input -->
                       <?php 
                       $r_options = array('1' => 'Client', '2' => 'Supplier');
                       ?>
                       <strong>Company Type</strong><br>
                       <div class="form-group">
                       <?php 
                        $this->Form->setTemplates([
                            'nestingLabel' => '<div class="form-check form-check-inline">{{input}}<label{{attrs}} class="my-auto">{{text}}</label></div>',
                            'formGroup' => '{{label}}{{input}}',
                        ]);  
                        echo  $this->Form->radio('company_type', $r_options ,[ 'type'=>'radio', 'class'=> 'form-check-input',  ] );
                         ?>     
                       </div>
                   </div>
                </div>
                <div class="row custom-padding">
                   
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                        <?=  $this->Form->control('contactno', ['class' => 'form-control', 'placeholder' => 'Contact No']); ?>
                       
                       </div>
                   </div> 
                    <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                        <?=  $this->Form->control('address', ['class' => 'form-control', 'placeholder' => 'Address']); ?>
                       
                       </div>
                    </div>
                </div> 

                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- Select multiple-->
                       <div class="form-group"> 
                            <?= $this->Form->button(__('Update'), ['class' => 'btn btn-primary']) ?>
                           <a href="<?php echo $this->Url->build(('/company')); ?>" class="btn btn-warning"><font color="#F7F7F7">Cancel</font></a>
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

  </div>
  <!-- /.content-wrapper -->
