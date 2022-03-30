<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Outgoing[]|\Cake\Collection\CollectionInterface $categories
 */
?>
<style type="text/css">
dl dt{
    display: inline-block;
    width: 20px;
    height: 20px;
    vertical-align: middle;

    /*border-style: solid;
    border-color: black;
    */
}
dl dd{
    display: inline-block;
    margin: 0px 2px;
    padding-bottom: 0;
    vertical-align: middle;
}
dl dt.blue{
    background: #B8DAFF;
}
dl dt.orange{
    background: #FFEEBA;
}
dl dt.green{
    background: #C3E6CB;
}
dl dt.red{
    background: #F5C6CB;
}
</style>
 
  <!-- Content Wrapper. Contains page content -->


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
          
          <?= $this->Flash->render() ?>

            <div class="card">
              <div class="card-header     "> 
                    <h3 class="card-title ">
                      <strong><?= $title ?><br>
                      <font color="blue"><small>(All Delivered, For Repair, Repaired and For Disposal Items Only)</small>
                      </font>
                    </h3> 
                      </strong>
                    
                    <?= $this->Html->link(__('New Outgoing Transaction Item'), ['action' => 'add'], ['class' => 'button float-right btn btn-primary float-right  ']) ?>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!--
                <label>Legend:</label>
                <button type="button" class="table-light">Delivered</button>
                <button type="button" class="table-warning">For Repair</button>
                <button type="button" class="table-success">Repaired</button>
                <button type="button" class="table-danger">For Disposal</button>
                -->
                <dl>
                  <dt class="blue"></dt>
                  <dd>Delivered</dd>

                  <dt class="orange"></dt>
                  <dd>For Repair</dd>

                  <dt class="green"></dt>
                  <dd>Repaired</dd>

                  <dt class="red"></dt>
                  <dd>For Disposal</dd>
                </dl>

                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr class="table-light">
                    <th>Transaction Code</th>
                    <th>Item Name</th>
                    <th>Serial Number</th>
                    <th>Status</th>
                    <th>Item QR Code</th>
                    <th>Notes/Remarks</th>
                    <th>Date Added</th>
                    <th>Action</th>
                  </tr>
                  </thead> 
                  <tbody>
                    <?php foreach ($outgoing as $outgoing): ?>
                    <?php
                        if($outgoing->status == 2){ //delivered
                        $itemstat  = "Delivered";
                        $trclass = "table-primary";
                    }
                    elseif($outgoing->status == 4){ //for repair
                        $itemstat  = "For Repair";
                        $trclass = "table-warning";
                    }
                    elseif($outgoing->status == 5){ //repaired
                        $itemstat  = "Repaired";
                        $trclass = "table-success";
                    }
                    elseif($outgoing->status == 6){ //for disposal
                        $itemstat  = "For Disposal";
                        $trclass = "table-danger";
                    }
                    else{
                        $itemstat  = "";
                    }
                    ?>
                    <tr class="<?php echo $trclass; ?>">
                        <td><!--<?= h($outgoing->transaction_code) ?>-->
                          <strong><?= $this->Html->link(__($outgoing->transaction_code), ['controller' => 'Transactions', 'action' => 'view?tid='.$outgoing->transaction_id]) ?></strong>
                        </td>
                        <td>
                          <center>
                          <?= h($outgoing->item_name) ?><br>
                          <?php 
                              $imageclass = 'rounded-circle align-self-center mr-3';
                              $imagestyle = 'height:2.1rem;width:2.1rem;object-fit: cover;';
                              if(!$outgoing->image){      
                                echo $this->Html->image('uploads/itemimages/product.png', ['class' => $imageclass, 'style' => $imagestyle,'alt'=>'User img' ]); 

                              }else{
                              ?>
                              <a data-fancybox="gallery" class="primary-btn" href="img/uploads/itemimages/<?php echo $outgoing->itemid.'/'.$outgoing->image; ?>">
                              <?php
                                echo $this->Html->image('uploads/itemimages/'.$outgoing->itemid.'/'.$outgoing->image, ['class' => $imageclass, 'style' => $imagestyle,'alt'=>'User img' ]);   
                              ?>
                              </a>
                              <?php
                              }
                          ?>
                          </center>
                        </td>
                        <td><?= h($outgoing->serial_no) ?></td>
                        <td><?php echo $itemstat; ?></td>
                        <td>
                          <?php
                            $this->Common->generateQrInView($outgoing->item_id)
                          ?>
                        </td>
                        <td><?= h($outgoing->notes) ?></td>
                        <td><?= h($outgoing->date_added) ?></td>
                        <td class="actions   "> 
                            <?php echo $this->Html->link(
                            "<font color='blue' size='3px'><i class='fa fa-eye'></i></font>", 
                            [
                                'Controller' => 'OutgoingController',
                                'action' => 'view', 
                                $outgoing->id
                            ],
                            [
                                'escape' => false //'escape' => false - convert plain text to html
                            ]
                            ); 
                            ?>
                            <?php echo $this->Html->link(
                            "<font color='green' size='3px'><i class='fa fa-edit'></i></font>", 
                            [
                                'Controller' => 'OutgoingController',
                                'action' => 'edit', 
                                $outgoing->id
                            ],
                            [
                                'escape' => false //'escape' => false - convert plain text to html
                            ]
                            ); 
                            ?>
                            <?php echo $this->Form->postLink(
                            "<font color='red' size='3px'><i class='fa fa-trash'></i></font>", 
                            [
                                'Controller' => 'OutgoingController',
                                'action' => 'delete', 
                                $outgoing->id
                            ],
                            [
                                'confirm' => __('Are you sure you want to delete # {0}?', $outgoing->id),
                                'escape' => false //'escape' => false - convert plain text to html
                            ],
                            
                            ); 
                            ?> 
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
<?= $this->Html->css('plugins/fancybox/fancybox.min.css'); ?>
<?= $this->Html->script('plugins/fancybox/fancybox.min.js'); ?>
<!-- END - This is needed to show image in a popup upon image click -->

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
      "paging":   true,
      //"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
      "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, 500]],
      //"lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]]
      //"aaSorting": [0,'asc'], // sorting column 0
      "aaSorting": [], //no sorting
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