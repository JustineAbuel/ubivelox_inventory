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
            <?= $this->Flash->render() ?><!-- Validation Alert Display Here -->
            <div class="card">
              <div class="card-header     "> 
                <h3 class="card-title "><?= $title ?></h3>                   
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr>
                    <th>Transaction Code</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Internal Warranty Date</th>
                    <th>Action</th>
                  </tr>
                  </thead> 
                  <tbody>
                    <?php foreach ($transactionItems as $transactionItem): ?>
                    <tr>
                        <td><?= $transactionItem->has('transaction') ? $this->Html->link($transactionItem->transaction->transaction_code, ['controller' => 'Transactions', 'action' => 'view?tid='.$transactionItem->transaction->id]) : '' ?></td>
                        <td><?= h($transactionItem->item->item_name) ?></td>
                        <td><?= h($transactionItem->quantity) ?></td>
                        <td><?= h($transactionItem->internal_warranty) ?></td>
                        <td class="actions   "> 
                            <?php echo $this->Html->link(
                            "<font color='blue' size='3px'><i class='fa fa-eye'></i></font>", 
                            [
                                'Controller' => 'TransactionsController',
                                'action' => 'view', 
                                $transactionItem->id
                            ],
                            [
                                'escape' => false //'escape' => false - convert plain text to html
                            ]
                            ); 
                            ?>
                            <?php /*echo $this->Html->link(
                            "<font color='green' size='3px'><i class='fa fa-edit'></i></font>", 
                            [
                                'Controller' => 'TransactionsController',
                                'action' => 'edit', 
                                $transactionItem->id
                            ],
                            [
                                'escape' => false //'escape' => false - convert plain text to html
                            ]
                            ); 
                            */
                            ?>
                            <?php /*echo $this->Form->postLink(
                            "<font color='red' size='3px'><i class='fa fa-trash'></i></font>", 
                            [
                                'Controller' => 'TransactionsController',
                                'action' => 'delete', 
                                $transactionItem->id
                            ],
                            [
                                'confirm' => __('Are you sure you want to delete # {0}?', $transactionItem->id),
                                'escape' => false //'escape' => false - convert plain text to html
                            ],
                            
                            ); 
                            */
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
      "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
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