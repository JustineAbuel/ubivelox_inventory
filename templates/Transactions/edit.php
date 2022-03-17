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
                <h3 class="card-title"><legend><?= __('Edit Transaction') ?></legend>
                    <strong>
                        <h3>Transaction Code: <p style="font-family:'Courier New';color: #1C05F3;"><?= h($transaction->transaction_code) ?></p></h3>
                    </strong>
                </h3> 
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?= $this->Form->create($transaction) ?> 

                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 
                            <label>Company From</label>
                            <?=  $this->Form->control('company_from', ['options' => $company, 'class' => 'form-control', 'placeholder' => 'Company From', 'label' => false]); ?>
 
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 
                            <label>Company To</label>
                            <?=  $this->Form->control('company_to', ['options' => $company, 'class' => 'form-control', 'placeholder' => 'Company To', 'label' => false]); ?>
 
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Transaction Type</label>
                            <?=  $this->Form->control('transaction_type_id', ['options' => $transactionType,'class' => 'form-control', 'placeholder' => 'Transaction Type', 'label' => false]); ?>
                       
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Transaction Status</label>
                            <?=  $this->Form->control('status', ['options' => $transactionStatus,'class' => 'form-control', 'placeholder' => 'Transaction Status', 'label' => false]); ?>
                       
                       </div>
                   </div>
                   <div class="col-sm-12">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Transaction Subject</label>
                            <?=  $this->Form->control('subject', ['class' => 'form-control', 'placeholder' => 'Subject', 'label' => false]); ?>
                       
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Received By:</label>
                            <?=  $this->Form->control('received_by', ['options' => $users,'class' => 'form-control', 'placeholder' => 'Received By', 'label' => false]); ?>
                       
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Received Date:</label>
                            <?=  $this->Form->control('received_date', ['class' => 'form-control', 'placeholder' => 'Received By', 'label' => false]); ?>
                       
                       </div>
                   </div>
                </div> 

                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- Select multiple-->
                       <div class="form-group"> 
                            <?= $this->Form->button(__('Update'), ['class' => 'btn btn-success']) ?>
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
