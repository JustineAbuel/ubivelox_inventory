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
                    $this->Common->generateQrInView($transaction->id)
                    ?>
                </h3> 
                <?php 
                    if($transaction->cancelled != ""){
                    ?>
                    <center><h2><font color="red">*** CANCELLED TRANSACTION ***</font></h2></center>
                    <?php 
                    }
                ?>
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
                        <?php 
                        if($transaction->cancelled != "" || $transaction->received_by != "" ||  $transaction->received_date != ""){
                        ?>
                        <a href="<?php echo $this->Url->build(('/transactions')); ?>" class="btn btn-success"><font color="#F7F7F7">Back to Transaction List</font></a>
                        <?php
                        }
                        else{
                        ?>
                          <?= $this->Html->link(__('Request/Add Item/s'), ['controller' => 'TransactionItems','action' => 'add?tid='.$transaction->id], ['class' => 'button btn btn-primary']) ?>
                          <?= $this->Html->link(__('Edit Transaction'), ['controller' => 'Transactions','action' => 'edit?tid='.$transaction->id], ['class' => 'button btn btn-primary']) ?>
                           <a href="<?php echo $this->Url->build(('/transactions')); ?>" class="btn btn-success"><font color="#F7F7F7">Back to Transaction List</font></a>
                           <?php 
                        }
                        ?>
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
                    <th>Serial Number</th>
                    <th>Quantity</th>
                    <th>QR Code</th>
                    <th>Internal Warranty Date</th>
                    <?php 
                    if($transaction->cancelled != ""){ //if cancelled
                    ?>
                    <th>Action</th>
                    <?php    
                    }
                    elseif($transaction->received_by != "" ||  $transaction->received_date != ""){ //if received
                    }
                    else{
                    ?>
                    <th>Action</th>
                    <?php 
                    }
                    ?>
                  </tr>
                  </thead> 
                  <tbody>
                    <?php 
                    if($counttransitemrec > 0){ //check if there is a record found
                    ?>
                    <?php foreach ($transactionItems as $transactionItem): ?>
                    <tr>
                        <td>
                          <?php 
                              $imageclass = 'rounded-circle align-self-center mr-3';
                              $imagestyle = 'height:2.1rem;width:2.1rem;object-fit: cover;';
                              if(!$transactionItem->image){      
                                echo $this->Html->image('uploads/itemimages/product.png', ['class' => $imageclass, 'style' => $imagestyle,'alt'=>'User img' ]); 

                              }else{
                              ?>
                              <a data-fancybox="gallery" class="primary-btn" href="../img/uploads/itemimages/<?php echo $transactionItem->image; ?>">
                              <?php
                                echo $this->Html->image('uploads/itemimages/'.$transactionItem->image, ['class' => $imageclass, 'style' => $imagestyle,'alt'=>'User img' ]);   
                              ?>
                              </a>
                              <?php
                              }
                          ?>
                          <?= h($transactionItem->item_name) ?>
                        </td>
                        <td><?= h($transactionItem->serial_no) ?></td>
                        <td><?= h($transactionItem->quantity) ?></td>
                        <td>
                          <?php
                          $this->Common->generateQrInView($transactionItem->item_id)
                          ?>
                        </td>
                        <td><?= h($transactionItem->internal_warranty) ?></td>

                            <?php /*echo $this->Html->link(
                                "<font color='green' size='5px'><i class='fa fa-edit'></i></font>", 
                                [ 'controller' => 'TransactionItems', 'action' => 'edit/'.$transactionItem->id.'?tid='.$transaction->id],
                                [ 'escape' => false ]//'escape' => false - convert plain text to html 
                            );  */?>
                            <?php 
                            if($transaction->cancelled != ""){
                            ?>
                            <td>
                              <center><font color="red">*** CANCELLED ITEM ***</font></center>  
                            </td>
                            <?php
                            }
                            elseif($transaction->received_by != "" ||  $transaction->received_date != ""){
                            }
                            else{
                            ?>
                            <td class="actions   "> 
                            <?php echo $this->Form->postLink(
                                "<font color='red' size='5px'><i class='fa fa-trash'></i></font>", 
                                [ 'controller' => 'TransactionItems', 'action' => 'delete/'.$transactionItem->id.'?tid='.$transaction->id ],
                                [ 'confirm' => __('Are you sure you want to delete # {0}?', $transactionItem->id), 'escape' => false ]//'escape' => false - convert plain text to html],   
                            );  ?> 
                            <?php 
                            ?>
                            </td>
                            <?php
                            }
                            ?>
                    </tr>

                    <?php endforeach; ?> 
                    <?php 
                    }
                    else{
                    ?>
                    <tr>
                      <td colspan="12">No Result Found</td>
                    </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                  <!--
                  <tfoot>
                  <tr>
                    <th></th>
                  </tr>
                  </tfoot>
                  -->
                </table>
                <?php 
                if($counttransitemrec > 0){
                ?>
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
                    <?php 
                    if($transaction->cancelled != ""){ //if cancelled
                    }
                    else{
                    ?>
                    <tr>
                      <td>
                        <br>
                        <?= $this->Html->link(__('Generate Transaction Slip'), ['controller' => 'TransactionItems','action' => 'printtrans?tid='.$transaction->id], ['class' => 'button btn btn-warning']) ?>
                        <br><br>
                      </td>
                    </tr>
                    <?php 
                    }
                    ?>
                    <?php 
                    if($transaction->cancelled != ""){ //if cancelled
                    ?>
                    <center><h2><font color="red">*** CANCELLED TRANSACTION ***</font></h2></center>
                    <?php
                    }
                    elseif($transaction->received_by != "" ||  $transaction->received_date != ""){ //if already received
                    }
                    else{
                    ?>
                    <tr>
                      <td>
                        <?php echo $this->Form->postLink(
                                "<font color='red' size='5px'><i class='fa fa-times'> Cancel Transaction</i></font>", 
                                [ 'controller' => 'TransactionItems', 'action' => 'canceltransaction?tid='.$this->request->getQuery('tid')],
                                [ 'confirm' => __('Are you sure you want to cancel transaction # {0}?', $this->request->getQuery('tid')), 'escape' => false ]//'escape' => false - convert plain text to html],   
                        ); ?>
                      </td>
                    </tr>
                    <?php 
                    }
                    ?>
                </table>
                <?php
                }
                ?>
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

<!-- START - This is needed to show image in a popup upon image click -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.css">
<!-- END - This is needed to show image in a popup upon image click -->

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
      "paging":   true,
      //"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
      "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, 500]]
      //"lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]]
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
