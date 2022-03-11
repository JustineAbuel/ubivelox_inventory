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
                <h3 class="card-title"><legend><?= __('Add User') ?></legend></h3> 
                    
    <?= $this->Html->link(__('Add New User'), ['action' => 'add'], ['class' => 'button float-right btn btn-primary float-right  ']) ?>
 
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr>
                    <th><?= ucfirst('id') ?></th>
                    <th><?= ucfirst('user') ?></th>
                    <th><?= ucfirst('username') ?></th>  
                    <th><?= ucfirst('contact no') ?></th>   
                    <th><?= ucfirst('role_id') ?></th>
                    <th><?= ucfirst('date added') ?></th>   
                    <th class="actions"><?= __('Actions') ?></th>
                  </tr>
                  </thead> 
                  <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $this->Number->format($user->id) ?></td>
                        <td>
                            <?= ucfirst(h($user->lastname)) . ' '. ucfirst(h($user->firstname)) . ' ' .ucfirst(h($user->middlename[0])) . '. ' ?>
                            <p class="m-0"><small><?= h($user->email) ?></small></p>
                        </td>
                        <td><?= h($user->username) ?></td> 
                        <td><?= h($user->contactno) ?></td>  
                        <td><?= h($user->user_role->role_name) ?></td>
                        <td><?= h($user->date_added) ?></td>
                        <td class="actions   "> 
                            <?php  
                            if($this->request->getAttribute('identity')->can('view', $user)){
                              echo $this->Html->link(
                                  "<font color='blue' size='3px'><i class='fa fa-eye'></i></font>", 
                                  [ 'Controller' => 'CategoriesController', 'action' => 'view', $user->id ],
                                  [ 'escape' => false]  //'escape' => false - convert plain text to html 
                                );  
                              }
                            ?>
                            <?php 
                            
                            if($this->request->getAttribute('identity')->can('edit', $user)){
                              echo $this->Html->link(
                                "<font color='green' size='3px'><i class='fa fa-edit'></i></font>", 
                                [ 'Controller' => 'CategoriesController', 'action' => 'edit',  $user->id ],
                                [ 'escape' => false ]  //'escape' => false - convert plain text to html
                              ); 
                            }
                            ?>
                            <?php 
                            
                            if($this->request->getAttribute('identity')->can('edit', $user)){
                              echo $this->Form->postLink(
                                "<font color='red' size='3px'><i class='fa fa-trash'></i></font>", 
                                [ 'Controller' => 'CategoriesController', 'action' => 'delete', $user->id ],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $user->id),
                                    'escape' => false //'escape' => false - convert plain text to html
                                ], 
                              ); 
                            }
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