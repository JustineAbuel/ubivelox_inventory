<?php include("inventoryAPI/src/config/db.php"); //important for getting id from company to transactions ?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 */
?>
 
  <!-- Content Wrapper. Contains page content -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header     "> 
                <h3 class="card-title "><?= $title ?></h3>                   
                <?= $this->Html->link(__('New Transaction'), ['action' => 'add'], ['class' => 'button float-right btn btn-primary float-right ']) ?>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong>Legend:</strong>
                <button type="button" class="table-primary">Success</button>
                <button type="button" class="table-warning">On-hold</button>
                <button type="button" class="table-danger">Pending</button>
                <br><br>
                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Company From</th>
                    <th>Company To</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Transaction Type</th>
                    <th>Status</th>
                    <th>Transaction Date</th> 
                    <th>Action</th>
                  </tr>
                  </thead> 
                  <tbody>
                    <?php foreach ($transactions as $transaction): ?>
                      <?php 
                      if($transaction->status == 1){ //pending
                          $tr_class = "table-danger";
                      }
                      elseif($transaction->status == 2){ //on-hold
                          $tr_class = "table-warning";
                      }
                      elseif($transaction->status == 3){ //success
                          $tr_class = "table-primary";
                      }
                    ?>
                      <?php 
                      $db = new db();
                      $pdo = $db->connect();

                      $sql_from = "SELECT id,company_name FROM company WHERE id=".$transaction->company_from;
                      $stmt_from = $pdo->query($sql_from);
                      $row_from = $stmt_from->fetch(PDO::FETCH_ASSOC);
                      $comp_id_from = $row_from['id'];
                      $comp_name_from = $row_from['company_name'];

                      $sql_to = "SELECT id,company_name FROM company WHERE id=".$transaction->company_to;
                      $stmt_to = $pdo->query($sql_to);
                      $row_to = $stmt_to->fetch(PDO::FETCH_ASSOC);
                      $comp_id_to = $row_to['id'];
                      $comp_name_to = $row_to['company_name'];
                      ?>
                    <tr class="<?php echo $tr_class; ?>">
                        <td><?= $this->Number->format($transaction->id) ?></td>
                        <td>
                        <?php 
                        if($comp_id_from == $transaction->company_from){
                          echo $comp_name_from;
                        }
                        ?>
                        </td>
                        <td>
                        <?php 
                        if($comp_id_to == $transaction->company_to){
                          echo $comp_name_to;
                        }
                        ?>
                        </td>
                        <td><?= h($transaction->item->item_name ) ?></td>
                        <td><?= h($transaction->quantity ) ?></td>
                        <td><?= h($transaction->transaction_type->transaction_name) ?></td>
                        <td><strong><?= h($transaction->transaction_status->status_name) ?></strong></td>
                        <td><?= h($transaction->date_added) ?></td>
                        <td class="actions   "> 
                            <?php echo $this->Html->link(
                            "<font color='blue' size='3px'><i class='fa fa-eye'></i></font>", 
                            [
                                'Controller' => 'TransactionsController',
                                'action' => 'view', 
                                $transaction->id
                            ],
                            [
                                'escape' => false //'escape' => false - convert plain text to html
                            ]
                            ); 
                            ?>
                            <?php echo $this->Html->link(
                            "<font color='green' size='3px'><i class='fa fa-edit'></i></font>", 
                            [
                                'Controller' => 'TransactionsController',
                                'action' => 'edit', 
                                $transaction->id
                            ],
                            [
                                'escape' => false //'escape' => false - convert plain text to html
                            ]
                            ); 
                            ?>
                            <?php echo $this->Form->postLink(
                            "<font color='red' size='3px'><i class='fa fa-trash'></i></font>", 
                            [
                                'Controller' => 'TransactionsController',
                                'action' => 'delete', 
                                $transaction->id
                            ],
                            [
                                'confirm' => __('Are you sure you want to delete # {0}?', $transaction->id),
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