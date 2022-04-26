<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?> 
  <!-- Content Wrapper. Contains page content -->
<!-- Modal -->
<?= $this->Form->create($company,['method' => 'post','enctype' => 'multipart/form-data']) ?>
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload CSV Data (Company)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="file" name="file" accept=".csv" class="form-control" required="">
        <small><strong><font color="red">Only .csv file type is allowed</font></strong></small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="submit">Import/Upload Data</button>
      </div>
    </div>
  </div>
</div>
 <?= $this->Form->end() ?>


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
          <?= $this->Flash->render() ?>
          

            <div class="card">
              <div class="card-header"> 
                <h3 class="card-title"> <?= __('List of Company') ?> </h3> 

                <div class="card-tools">  
                    <?= $this->Html->link(__('Add New Company'), ['action' => 'add'], ['class' => 'button float-right btn btn-primary float-right  ']) ?>
                    <?= $this->Html->link(
                      "<font color='white' size='3px'><i class='fa fa-file-excel'></i></font> Upload CSV Data (Company)", 
                      ['action' => 'uploadcsv'], 
                      ['class' => 'float-right btn btn-success float-right mr-2 ',
                      'data-toggle' => 'modal','data-target' => '#uploadModal', 'escape' => false ]) 
                    ?>
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr>
                    <th><?= ucfirst('id') ?></th>
                    <th><?= ucfirst('Company Name') ?></th>
                    <th><?= ucfirst('Type') ?></th>
                    <th><?= ucfirst('Address') ?></th>  
                    <th><?= ucfirst('Mobile No.') ?></th>
                    <th><?= ucfirst('Tel No.') ?></th>
                    <th><?= ucfirst('Email') ?></th>   
                    <th><?= ucfirst('Date Added') ?></th>   
                    <th class="actions"><?= __('Actions') ?></th>
                  </tr>
                  </thead> 
                  <tbody>
                    <?php foreach ($company as $company): ?>
                    <tr>
                        <td><?= $this->Number->format($company->id) ?></td>
                        <td><?= h($company->company_name) ?></td> 
                        <td><?php 
                        if($company->company_type == 1){
                            echo "Client"; //1
                        }
                        else{
                            echo "Supplier"; //2
                        }   
                        ?>    
                        </td>
                        <td><?= h($company->address) ?></td>  
                        <td><?= h($company->contactno) ?></td>
                        <td><?= h($company->tel_no) ?></td>
                        <td><?= h($company->email) ?></td>
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
      "responsive": true, "lengthChange": true, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
      "paging":   true, 
      "lengthChange": true,      
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