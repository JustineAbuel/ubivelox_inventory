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
                        <h3>Transaction Code: <p style="font-family:'Courier New';color: #1C05F3;"><?= h($outgoing->transaction->transaction_code) ?></p></h3>
                    </strong>
                </h3> 
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?= $this->Form->create($outgoing) ?> 

                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 
                            <label>Item Name</label>
                            <?=  $this->Form->control('item_id', ['options' => $items, 'class' => 'form-control', 'placeholder' => 'Company From', 'label' => false,'disabled']); ?>
 
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 
                            <label>Status</label>
                            <select name="status" class="form-control" disabled="">
                              <option value="<?php echo $outgoing->status; ?>">
                                <?php 
                                if($outgoing->status == 2){ //delivered
                                    echo "Delivered";
                                }
                                elseif($outgoing->status == 4){ //for repair
                                    echo "For Repair";
                                }
                                elseif($outgoing->status == 5){ //repaired
                                     echo "Repaired";
                                }
                                else{
                                      echo "";
                                }
                                ?>
                              </option>
                            </select>
 
                       </div>
                   </div>
                   <div class="col-sm-12">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Notes Remarks</label>
                            <?=  $this->Form->control('notes', ['class' => 'form-control', 'placeholder' => 'Internal Warranty Date', 'label' => false,'disabled']); ?>
                       
                       </div>
                   </div>
                </div> 

                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- Select multiple-->
                       <div class="form-group"> 
                           <a href="<?php echo $this->Url->build(('/Outgoing')); ?>" class="btn btn-success"><font color="#F7F7F7">Back to Outgoing Transaction Items</font></a>
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
