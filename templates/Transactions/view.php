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
                          <?= $this->Html->link(__('Request/Add Item/s'), ['controller' => 'TransactionItems','action' => 'add?tid='.$transaction->id], ['class' => 'button btn btn-primary']) ?>
                          <?= $this->Html->link(__('Edit Transaction'), ['controller' => 'Transactions','action' => 'edit?tid='.$transaction->id], ['class' => 'button btn btn-primary']) ?>
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


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <?= $this->Flash->render() ?><!-- Validation Alert Display Here -->
            <div class="card">
              <div class="card-header     "> 
                <h3 class="card-title ">List of Requested/Added Items</h3>                   
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>QR Code</th>
                    <th>Internal Warranty Date</th>
                    <th>Action</th>
                  </tr>
                  </thead> 
                  <tbody>
                    <?php foreach ($transactionItems as $transactionItem): ?>
                    <tr>
                        <td><?= h($transactionItem->item_name) ?></td>
                        <td><?= h($transactionItem->quantity) ?></td>
                        <td>
                          <?php
                          $this->Common->generateQrInView($transactionItem->item_id)
                          ?>
                        </td>
                        <td><?= h($transactionItem->internal_warranty) ?></td>
                        <td class="actions   "> 

                            <?php echo $this->Html->link(
                                "<font color='green' size='5px'><i class='fa fa-edit'></i></font>", 
                                [ 'controller' => 'TransactionItems', 'action' => 'edit/'.$transactionItem->id.'?tid='.$transaction->id],
                                [ 'escape' => false ]//'escape' => false - convert plain text to html 
                            );  ?>

                            <?php echo $this->Form->postLink(
                                "<font color='red' size='5px'><i class='fa fa-trash'></i></font>", 
                                [ 'controller' => 'TransactionItems', 'action' => 'delete/'.$transactionItem->id.'?tid='.$transaction->id ],
                                [ 'confirm' => __('Are you sure you want to delete # {0}?', $transactionItem->id), 'escape' => false ]//'escape' => false - convert plain text to html],   
                            );  ?> 
                        </td>
                    </tr>

                    <?php endforeach; ?> 
                  </tbody>
                  <!--
                  <tfoot>
                  <tr>
                    <th></th>
                  </tr>
                  </tfoot>
                  -->
                </table>
                <table>
                  <tr>
                      <td colspan="12">
                        <h4>
                          <font color="#1C05F3">Total Item Quantity: 
                        <?php 
                        foreach ($totalQuantity as $amount) {
                          echo " ' ".$amount->total." ' ";
                        } 
                        //echo $totalQuantity;
                        ?>
                          </font>
                        </h4>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <!--<?= $this->Html->link(__('Process Transaction'), ['controller' => 'TransactionItems','action' => 'processtransaction?tid='.$transaction->id], ['class' => 'button btn btn-primary']) ?>-->
                        <a class="btn btn-primary" onclick="alert('Under Maintenance!')">Process Transaction</a>

                        <!--<?= $this->Html->link(__('Generate Transaction Slip'), ['controller' => 'TransactionItems','action' => 'generatetransslip?tid='.$transaction->id], ['class' => 'button btn btn-warning']) ?>-->
                        <a class="btn btn-warning" onclick="alert('Under Maintenance!')">Generate Transaction Slip</a>

                        <!--<?= $this->Html->link(__('Cancel Transaction'), ['controller' => 'TransactionItems','action' => 'canceltransaction?tid='.$transaction->id], ['class' => 'button btn btn-danger']) ?>-->
                        <a class="btn btn-danger" onclick="alert('Under Maintenance!')">Cancel Transaction</a>
                      </td>
                    </tr>
                </table>
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
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
      "paging":   true,
      "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
