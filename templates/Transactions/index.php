<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 */
?>
<style type="text/css">
dl dt{
    display: inline-block;
    width: 20px;
    height: 20px;
    vertical-align: middle;
    /*
    border-style: solid;
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
            <?= $this->Flash->render() ?><!-- Validation Alert Display Here -->
            <div class="card">
              <div class="card-header     "> 
                <h3 class="card-title "><?= $title ?></h3>                   
                <?= $this->Html->link(__('New Transaction'), ['action' => 'add'], ['class' => 'button float-right btn btn-primary float-right ']) ?>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!--
                <strong>Legend:</strong>
                <button type="button" class="table-primary">Delivered</button>
                <button type="button" class="table-warning">For Delivery</button>
                <button type="button" class="table-danger">Cancelled</button>
                <br><br>
                -->
                <dl>
                  <dt class="blue"></dt>
                  <dd>Delivered</dd>

                  <dt class="orange"></dt>
                  <dd>For Delivery</dd>

                  <dt class="red"></dt>
                  <dd>Cancelled</dd>
                </dl>

                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr>
                    <th>Transaction Code</th>
                    <th>Company To</th>
                    <th>Transaction Type</th>
                    <th>Status</th>
                    <th>QR Code</th>
                    <th>Transaction Date</th> 
                    <th>View Details</th>
                  </tr>
                  </thead> 
                  <tbody>
                    <?php foreach ($transactions as $transaction): ?>
                      <?php 
                      if($transaction->status == 1){ //for-delivery
                          $tr_class = "table-warning";
                      }
                      elseif($transaction->status == 2){ //deliverred
                          $tr_class = "table-primary";
                      }
                      elseif($transaction->status == 3){ //cancelled
                          $tr_class = "table-danger";
                      }else{
                        $tr_class = '';
                      }
                    ?>
                    <tr class="<?php echo $tr_class; ?>">
                        <td><?= h($transaction->transaction_code) ?></td>
                        <td><?= h($transaction->company->company_name ) ?></td>
                        <td><?= h($transaction->transaction_type->transaction_name) ?></td>
                        <td><strong><?= h($transaction->transaction_status->status_name) ?></strong></td>
                        <th>
                          <?php
                          $this->Common->generateQrInView($transaction->id)
                          ?>
                        </th>
                        <td><?= h($transaction->date_added) ?></td>
                        <td class="actions   "> 
                            <?php echo $this->Html->link(
                            "<font color='blue' size='6px'><i class='fa fa-eye'></i></font>", 
                            [
                                'Controller' => 'TransactionsController',
                                'action' => 'view?tid='.$transaction->id
                                
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
                                $transaction->id
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
                                $transaction->id
                            ],
                            [
                                'confirm' => __('Are you sure you want to delete # {0}?', $transaction->id),
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
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
      //"order": [[ 5, "desc" ]],
      "order": [],
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