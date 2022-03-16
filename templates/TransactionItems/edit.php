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

            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><legend><?= __('Edit Transaction Item') ?></legend>
                    <strong>
                        <h3>Transaction Code: <p style="font-family:'Courier New';color: #1C05F3;"><?= h($transactionItem->transaction->transaction_code) ?></p></h3>
                    </strong>
                </h3> 
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?= $this->Form->create($transactionItem) ?> 

                <div class="row custom-padding">
                   <div class="col-sm-4">
                       <!-- text input -->
                       <div class="form-group"> 
                            <label>Item Name</label>
                            <?=  $this->Form->control('item_id', ['options' => $itemOption, 'class' => 'form-control', 'placeholder' => 'Company From', 'label' => false]); ?>
 
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
                            <?= $this->Form->button(__('Update'), ['class' => 'btn btn-success']) ?>
                           <?= $this->Html->link(__(' Back to Transaction'), ['controller' => 'Transactions','action' => 'view/'.$this->request->getQuery('tid')], ['class' => 'btn btn-warning']) ?>
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
