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
                <h3 class="card-title"><legend><?= __('Edit Outgoing Transaction Item') ?></legend></h3> 
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?= $this->Form->create($outgoing) ?> 

                <div class="row custom-padding">
                   <div class="col-sm-4">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Transaction Code <font color="blue">(Delivered Transactions Only)</font></label>
                            <?php 
                            echo $this->Form->control('transaction_id', ['options' => $transactions,'class' => 'form-control', 'placeholder' => 'Transaction','required','label' => false]);
                            ?>
                       </div>
                   </div>

                   <div class="col-sm-4">
                       <!-- text input -->
                       <div class="form-group">
                            <!--<label>Transaction Items</label>-->
                            <label>Transaction Items <font color="blue">(Delivered Items Only)</font></label>
                            <?php 
                            echo $this->Form->control('item_id', ['options' => $items,'class' => 'form-control', 'placeholder' => 'Transaction Items','required','label' => false]);
                            ?>
                       </div>
                   </div>

                   <div class="col-sm-4">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Status <font color="blue">(For Repair/Repaired)</font></label>
                            <select name="status" class="form-control" required="">
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
                                <option value="4">For Repair</option>
                                <option value="5">Repaired</option>
                            </select>
                       </div>
                   </div>

                   <div class="col-sm-12">
                       <!-- text input -->
                       <div class="form-group">
                            <label>Notes/Remarks</label>
                            <?=  $this->Form->control('notes', ['class' => 'form-control', 'placeholder' => 'Notes/Remarks', 'label' => false]); ?>
                       
                       </div>
                   </div>
                </div> 

                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- Select multiple-->
                       <div class="form-group"> 
                            <?= $this->Form->button(__('Update'), ['class' => 'btn btn-success']) ?>
                           <?= $this->Html->link(__(' Back to Outgoing Transactions'), ['controller' => 'Outgoing','action' => 'index'], ['class' => 'btn btn-warning']) ?>
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

    <script type="text/javascript">
        $(document).ready(function(){
    
        $('#transaction-id').change(() => {
            
            var categoryId = $('#transaction-id').val();
            $.ajax({
                method: "POST",
                url: "<?= $this->Url->build(['controller' => 'Outgoing', 'action' => 'getItems']) ?>",
                type:"JSON",
                data: {
                    transaction_id: categoryId
                },
                headers: {
                    'X-CSRF-Token': $("[name='_csrfToken']").val()
                },
                
                beforeSend: function(){  },
                success: function(msg){
                     console.log(msg.items)
                    $("#item-id").empty().append(msg.items);
                },
                cache: false, 
                error:function (xhr, ajaxOptions, thrownError){  
                    alert(thrownError); 
                }     
            })
        })


    });
    </script>
