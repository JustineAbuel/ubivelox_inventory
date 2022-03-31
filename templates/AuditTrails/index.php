<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditTrail[]|\Cake\Collection\CollectionInterface $auditTrails
 */
?>  
<style>
    tr td {
       padding: .10rem .75rem !important; 
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
                <h3 class="card-title"> <?= __('Audit Trails') ?> </h3> 
                     
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr>
                      
                    <th><?= ucfirst('channel') ?></th>
                    <th><?= ucfirst('IP Address') ?></th>
                    <th><?= ucfirst('user') ?></th>
                    <th><?= ucfirst('role') ?></th>
                    <th><?= ucfirst('directory') ?></th>
                    <th><?= ucfirst('action') ?></th>
                    <th><?= ucfirst('status') ?></th>
                    <th><?= ucfirst('timestamp') ?></th>
                    <th><?= ucfirst('log') ?></th>
                  </tr>
                  </thead> 
                  <tbody>
                    <?php foreach ($auditTrails as $auditTrail): ?>
                    <tr>  
                        <td><?= h($auditTrail->channel == 1 ?'Web': 'Mobile')  ?></td>
                        <td><?= h($auditTrail->ip_address) ?></td>
                        <td><?= h($auditTrail->username) ?></td>
                        <td><?= h($auditTrail->user_roles['role_name']) ?></td>
                        <td><?= h($auditTrail->directory) ?></td>
                        <td><?= h($auditTrail->action) ?></td>
                        <td><?= h($auditTrail->status) ?></td>
                        <td><?= h($auditTrail->timestamp) ?></td>
                        <td><?= h($auditTrail->log) ?></td>
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
      "ordering": false, 
      // "lengthChange": true,      
      "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, 'All']]
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