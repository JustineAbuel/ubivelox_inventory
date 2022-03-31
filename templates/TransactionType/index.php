<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
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
                <h3 class="card-title"><legend><?= __('Transaction Type') ?></legend></h3> 
                    
    <?= $this->Html->link(__('Add New Transaction Type'), ['action' => 'add'], ['class' => 'button float-right btn btn-primary float-right  ']) ?>
 
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr>
                    <th><?= ucfirst('id') ?></th>
                    <th><?= ucfirst('Transaction Type Name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                  </tr>
                  </thead> 
                  <tbody>
                    <?php foreach ($transactionType as $transactionType): ?>
                    <tr>
                        <td><?= $this->Number->format($transactionType->id) ?></td>
                        <td><?= h($transactionType->transaction_name) ?></td>
                        <td class="actions"> 
                            <?php echo $this->Html->link(
                              "<font color='blue' size='3px'><i class='fa fa-eye'></i></font>", 
                              [ 'Controller' => 'TransactionTypeController', 'action' => 'view', $transactionType->id ],
                              [ 'escape' => false]  //'escape' => false - convert plain text to html 
                            ); 
                            ?>
                            <?php /*echo $this->Html->link(
                              "<font color='green' size='3px'><i class='fa fa-edit'></i></font>", 
                              [ 'Controller' => 'TransactionTypeController', 'action' => 'edit',  $transactionType->id ],
                              [ 'escape' => false ]  //'escape' => false - convert plain text to html
                            ); */
                            ?>
                            <?php /*echo $this->Form->postLink(
                              "<font color='red' size='3px'><i class='fa fa-trash'></i></font>", 
                              [ 'Controller' => 'TransactionTypeController', 'action' => 'delete', $transactionType->id ],
                              [
                                  'confirm' => __('Are you sure you want to delete # {0}?', $transactionType->id),
                                  'escape' => false //'escape' => false - convert plain text to html
                              ], 
                            ); */
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
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
      "paging":   true,
      //"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
      "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, 500]]
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