<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 */
?> 
<style type="text/css">
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
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
                           <label>Company Name<strong><font color="red">*</font></strong></label>
                           <?=  $this->Form->control('company_name', ['class' => 'form-control', 'placeholder' => 'Company name','label' => false]); ?>
                          
                       </div>
                   </div>
                   

                   <div class="col-sm-6">
                       <!-- text input -->
                       <?php 
                       $r_options = array('1' => 'Client', '2' => 'Supplier');
                       ?>
                       <strong>Company Type<font color="red">*</font></strong><br>
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
                   
                   <div class="col-sm-4">
                       <label>Mobile No.<font color="red">*</font></label>
                       <input class="form-control" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="11" name="contactno" placeholder="Mobile No." required="true" value="<?php echo $company->contactno; ?>" />
                   </div> 

                   <div class="col-sm-4">
                    <label>Tel No.<font color="red">*</font></label>
                       <input class="form-control" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="10" name="tel_no" placeholder="Tel No." required="true" value="<?php echo $company->tel_no; ?>" />
                   </div>

                   <div class="col-sm-4">
                    <label>Email<font color="red">*</font></label>
                       <input class="form-control" type="email" name="email" placeholder="Email" required="true" value="<?php echo $company->email; ?>" />
                   </div>

                    <div class="col-sm-12">
                       <!-- text input -->
                       <label>Address<font color="red">*</font></label>
                       <div class="form-group">
                        <?=  $this->Form->control('address', ['class' => 'form-control', 'placeholder' => 'Address','label' => false]); ?>
                       
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
