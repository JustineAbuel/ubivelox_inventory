<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemType[]|\Cake\Collection\CollectionInterface $itemType
 */
?>
 

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
          
          <?= $this->Flash->render() ?>

            <div class="card">
              <div class="card-header     "> 
                    <h3 class="card-title "><?= __('Item Types') ?></h3> 
                    
    <?= $this->Html->link(__('New item type'), ['action' => 'add'], ['class' => 'button float-right btn btn-primary float-right  ']) ?>
 
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr>
                    <th><?= ucfirst('id') ?></th>
                    <th><?= ucfirst('type name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th> 
                  </tr>
                  </thead> 
                  <tbody>
                    
                    <?php foreach ($itemType as $itemType): ?>
                    <tr>
                        <td><?= $this->Number->format($itemType->id) ?></td>
                        <td><?= h($itemType->type_name) ?></td>
                        <td class="actions">
                                <?php echo $this->Html->link(
                                    "<font color='blue' size='3px'><i class='fa fa-eye'></i></font>", 
                                    [ 'Controller' => 'CategoriesController', 'action' => 'view',  $itemType->id ],
                                    [ 'escape' => false ]//'escape' => false - convert plain text to html
                                );?>
                                <?php echo $this->Html->link(
                                    "<font color='green' size='3px'><i class='fa fa-edit'></i></font>", 
                                    [ 'Controller' => 'CategoriesController', 'action' => 'edit',  $itemType->id ],
                                    [ 'escape' => false ]//'escape' => false - convert plain text to html 
                                );  ?>
                                <?php echo $this->Form->postLink(
                                    "<font color='red' size='3px'><i class='fa fa-trash'></i></font>", 
                                    [ 'Controller' => 'CategoriesController', 'action' => 'delete',   $itemType->id ],
                                    [ 'confirm' => __('Are you sure you want to delete # {0}?', $itemType->id), 'escape' => false ]//'escape' => false - convert plain text to html],   
                                );  ?>  
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