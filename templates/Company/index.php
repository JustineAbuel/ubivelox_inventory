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

            <div class="card">
              <div class="card-header     "> 
                <h3 class="card-title"><legend><?= __('Company') ?></legend></h3> 
                    
    <?= $this->Html->link(__('Add New Company'), ['action' => 'add'], ['class' => 'button float-right btn btn-primary float-right  ']) ?>
 
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr>
                    <th><?= ucfirst('id') ?></th>
                    <th><?= ucfirst('Company Name') ?></th>
                    <th><?= ucfirst('Address') ?></th>  
                    <th><?= ucfirst('Contact No') ?></th>   
                    <th><?= ucfirst('Type') ?></th>
                    <th><?= ucfirst('Date Added') ?></th>   
                    <th class="actions"><?= __('Actions') ?></th>
                  </tr>
                  </thead> 
                  <tbody>
                    <?php foreach ($company as $company): ?>
                    <tr>
                        <td><?= $this->Number->format($company->id) ?></td>
                        <td><?= h($company->company_name) ?></td> 
                        <td><?= h($company->address) ?></td>  
                        <td><?= h($company->contactno) ?></td>
                        <td><?php 
                        if($company->company_type == 1){
                            echo "Client"; //1
                        }
                        else{
                            echo "Supplier"; //2
                        }   
                        ?>    
                        </td>
                        <td><?= h($company->date_added) ?></td>
                        <td class="actions"> 
                            <?php echo $this->Html->link(
                              "<font color='blue' size='3px'><i class='fa fa-eye'></i></font>", 
                              [ 'Controller' => 'CompanyController', 'action' => 'view', $company->id ],
                              [ 'escape' => false]  //'escape' => false - convert plain text to html 
                            ); 
                            ?>
                            <?php echo $this->Html->link(
                              "<font color='green' size='3px'><i class='fa fa-edit'></i></font>", 
                              [ 'Controller' => 'CompanyController', 'action' => 'edit',  $company->id ],
                              [ 'escape' => false ]  //'escape' => false - convert plain text to html
                            ); 
                            ?>
                            <?php echo $this->Form->postLink(
                              "<font color='red' size='3px'><i class='fa fa-trash'></i></font>", 
                              [ 'Controller' => 'CompanyController', 'action' => 'delete', $company->id ],
                              [
                                  'confirm' => __('Are you sure you want to delete # {0}?', $company->id),
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