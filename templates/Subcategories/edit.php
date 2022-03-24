 
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Subcategory $subcategory
 * @var \Cake\Collection\CollectionInterface|string[] $categories
 */
?> 
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

          <?= $this->Flash->render() ?>
          
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Edit Subcategory</h3><br><br>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?= $this->Form->create($subcategory) ?>
                
                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 
                           <?=  $this->Form->control('category_id', ['options' => $categories, 'class' => 'form-control', 'placeholder' => 'Category']); ?>
                          
                       </div>
                   </div> 
                </div> 
                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 
                           <?=  $this->Form->control('subcategory_name', ['class' => 'form-control', 'placeholder' => 'Subcategory name']); ?>
                          
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                        <?=  $this->Form->control('subcategory_description', ['class' => 'form-control', 'placeholder' => 'Description']); ?>
                       
                       </div>
                   </div>
                </div> 

                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- Select multiple-->
                       <div class="form-group"> 
                            <?= $this->Form->button(__('Add'), ['class' => 'btn btn-primary']) ?>
                           <a href="<?php echo $this->Url->build(('/subcategories')); ?>" class="btn btn-warning"><font color="#F7F7F7">Cancel</font></a>
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
