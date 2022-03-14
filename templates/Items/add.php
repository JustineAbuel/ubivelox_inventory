<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $item
 * @var \Cake\Collection\CollectionInterface|string[] $categories
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
                <h3 class="card-title">Add Item</h3><br><br>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?= $this->Form->create($item) ?> 
                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                           <?= $this->Form->control('category_id', ['options' => $categories,'class' => 'form-control', 'placeholder' => 'Category']); ?>
  
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 
                           
                            <?= $this->Form->control('subcategory_id', ['options' => $subcategories,'class' => 'form-control', 'placeholder' => 'Subategory']); ?> 
                       </div>
                   </div>
                </div>
                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                           
                            <?= $this->Form->control('item_name', ['class' => 'form-control', 'placeholder' => 'Item name'] ); ?>
                           
                       </div>
                   </div>
                   
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                           
                       <?= $this->Form->control('quantity', ['class' => 'form-control', 'placeholder' => 'Quantity'] ); ?>
                             
                       </div>
                   </div>
                </div> 
                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                           
                       <?= $this->Form->control('serial_no', ['class' => 'form-control', 'placeholder' => 'Serial Number'] ); ?>
                           
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 

                       <?= $this->Form->control('supplier_id',['options' => $company, 'class'=> 'form-control'] ); ?>
                        </div>
                   </div>
                </div> 
                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                           
                       <?= $this->Form->control('issued_date', ['class' => 'form-control', 'empty'=> true] ); ?>
                             
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 

                       <?= $this->Form->control('manufacturer_warranty', ['class' => 'form-control', 'empty'=> true] ); ?>                      
                       </div>
                   </div>
                </div> 

                <div class="row custom-padding">
                   
                <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 
                           <?= $this->Form->control('item_description', ['class' => 'form-control', 'placeholder' => 'Item Description'] ); ?>
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                           
                       <?= $this->Form->control('remarks', ['class' => 'form-control', 'placeholder' => 'Remarks '] ); ?>
                             
                       </div>
                   </div>
                   
                </div> 
                

                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                           
                       <?= $this->Form->control('item_type_id', ['options' => $itemTypes, 'class' => 'form-control', 'placeholder' => 'Type '] ); ?>
                             
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                        <label for="quality">quality</label>
                        <div class="custom-control custom-radio custom-control-inline"> 
                        <?=  
                        // $this->Form->setTemplates([
                        //     'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
                        //     'formGroup' => '{{input}}{{label}}',
                        // ]);
                         $this->Form->radio('quality', $quality ,[ 'type'=>'radio', 'class'=> 'form-check-input mr-5',  ] ); ?>                       ;


                        </div>
                         
                   </div>
                </div> 
                
 


                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                           
                       <?= $this->Form->control('operating_system', ['class' => 'form-control', 'placeholder' => 'Operating System '] ); ?>
                             
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 

                       <?= $this->Form->control('kernel',["class"=> 'form-control','placeholder' => 'Kernel ' ] ); ?>
                        </div>
                   </div>
                </div> 

                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                           
                       <?= $this->Form->control('header_type', ['class' => 'form-control', 'placeholder' => 'Header Type '] ); ?>
                             
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 

                       <?= $this->Form->control('firmware',["class"=> 'form-control', 'placeholder' => 'Firmware ' ] ); ?>                      
                     </div>
                   </div>
                </div> 

                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                           
                       <?= $this->Form->control('features', ['class' => 'form-control', 'placeholder' => 'Features '] ); ?>
                             
                       </div>
                   </div>    
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 

                        <?= $this->Form->control('part_no',["class"=> 'form-control', ] ); ?>                       
                        </div>
                   </div>
                </div> 


                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- Select multiple-->
                       <div class="form-group">
                           <button class="btn btn-primary">Add</button>
                           <a href="<?php echo $this->Url->build(('/items'), array('action' => 'userlist')); ?>" class="btn btn-warning"><font color="#F7F7F7">Cancel</font></a>
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
