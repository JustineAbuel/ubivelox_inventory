<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Outgoing[]|\Cake\Collection\CollectionInterface $categories
 */
?>
 
  <!-- Content Wrapper. Contains page content -->


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
          
          <?= $this->Flash->render() ?>

            <div class="card">
              <div class="card-header     "> 
                    <h3 class="card-title "><?= $title ?></h3> 
                    
                    <?= $this->Html->link(__('New Outgoing Transaction Item'), ['action' => 'add'], ['class' => 'button float-right btn btn-primary float-right  ']) ?>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <label>Legend:</label>
                <button type="button" class="table-danger">For Repair</button>
                <button type="button" class="table-success">Repaired</button>
                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr class="table-primary">
                    <th>Transaction ID</th>
                    <th>Transaction Code</th>
                    <th>Item Name</th>
                    <th>Serial Number</th>
                    <th>Status</th>
                    <th>QR Code</th>
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
                        $trclass = "table-light";
                    }
                    elseif($outgoing->status == 4){ //for repair
                        $itemstat  = "For Repair";
                        $trclass = "table-danger";
                    }
                    elseif($outgoing->status == 5){ //repaired
                        $itemstat  = "Repaired";
                        $trclass = "table-success";
                    }
                    else{
                        $itemstat  = "";
                    }
                    ?>
                    <tr class="<?php echo $trclass; ?>">
                        <td><?= h($outgoing->transaction_id) ?></td>
                        <td><!--<?= h($outgoing->transaction_code) ?>-->
                          <strong><?= $this->Html->link(__($outgoing->transaction_code), ['controller' => 'Transactions', 'action' => 'view?tid='.$outgoing->transaction_id]) ?></strong>
                        </td>
                        <td><?= h($outgoing->item_name) ?></td>
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
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
      "paging":   true,
      "lengthMenu": [[100, 200, 300, -1],
        [100, 200, 300, "All"]],
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