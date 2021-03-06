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
            <?= $this->Flash->render() ?><!-- Validation Alert Display Here -->
            <div class="card">

              <div class="card-header">
                <h3 class="card-title"><legend><?= __('Add Transaction Item') ?></legend></h3> 
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?= $this->Form->create($transactionItem) ?> 

                <div class="row custom-padding">
                   <div class="col-sm-4">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Item <font color="blue"><strong>(All internal & external items)</strong></font></label>
                            <?=  $this->Form->control('item_id', ['options' => $items,'class' => 'form-control', 'placeholder' => 'Item', 'label' => false]); ?>
                       
                       </div>
                   </div>
                   <div class="col-sm-4">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Quantity</label>
                            <?=  $this->Form->control('quantity', ['class' => 'form-control', 'placeholder' => 'Quantity', 'label' => false]); ?>
                       
                       </div>
                   </div>
                   <div class="col-sm-4">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Internal Warranty Date</label>
                            <?=  $this->Form->control('internal_warranty', ['class' => 'form-control', 'placeholder' => 'Internal Warranty Date', 'label' => false]); ?>
                       
                       </div>
                   </div>
                </div> 

                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- Select multiple-->
                       <div class="form-group"> 
                            <?= $this->Form->button(__('Add Item'), ['class' => 'btn btn-primary']) ?>
                           <?= $this->Html->link(__(' Back to Transaction'), ['controller' => 'Transactions','action' => 'view?tid='.$this->request->getQuery('tid')], ['class' => 'btn btn-warning']) ?>
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
