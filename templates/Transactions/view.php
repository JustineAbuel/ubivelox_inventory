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
                    <strong>
                        <h3>Transaction Code: <p style="font-family:'Courier New';color: #1C05F3;"><?= h($transaction->transaction_code) ?></p></h3>
                    </strong>
                    <?php
                    $this->Common->generateQrInView($transaction->transaction_code)
                    ?>
                    <?= $this->Html->link(__('Request Item/s'), ['controller' => 'TransactionItems','action' => 'add/'.$transaction->id], ['class' => 'button float-right btn btn-primary float-right ']) ?>
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
                            <?=  $this->Form->control('company_from', ['options' => $company, 'class' => 'form-control', 'placeholder' => 'Company From', 'label' => false,'disabled']); ?>
 
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 
                            <label>Company To</label>
                            <?=  $this->Form->control('company_to', ['options' => $company, 'class' => 'form-control', 'placeholder' => 'Company To', 'label' => false,'disabled']); ?>
 
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Transaction Type</label>
                            <?=  $this->Form->control('transaction_type_id', ['options' => $transactionType,'class' => 'form-control', 'placeholder' => 'Transaction Type', 'label' => false,'disabled']); ?>
                       
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Transaction Status</label>
                            <?=  $this->Form->control('status', ['options' => $transactionStatus,'class' => 'form-control', 'placeholder' => 'Transaction Status', 'label' => false,'disabled']); ?>
                       
                       </div>
                   </div>
                   <div class="col-sm-12">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Transaction Subject</label>
                            <?=  $this->Form->control('subject', ['class' => 'form-control', 'placeholder' => 'Subject', 'label' => false,'disabled']); ?>
                       
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Received By:</label>
                            <?=  $this->Form->control('received_by', ['options' => $users,'class' => 'form-control', 'placeholder' => 'Received By', 'label' => false,'disabled']); ?>
                       
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Received Date:</label>
                            <?=  $this->Form->control('received_date', ['class' => 'form-control', 'placeholder' => 'Received By', 'label' => false,'disabled']); ?>
                       
                       </div>
                   </div>
                </div> 

                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- Select multiple-->
                       <div class="form-group"> 
                           <a href="<?php echo $this->Url->build(('/transactions')); ?>" class="btn btn-success"><font color="#F7F7F7">Back to Transaction List</font></a>
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
