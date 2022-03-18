 
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
            
          
          <?= $this->Flash->render() ?>

            <div class="card">
              <div class="card-header     "> 
                    <h3 class="card-title ">View Subcategory</h3> 
                    
    <?= $this->Html->link(__('New Category'), ['action' => 'add'], ['class' => 'button float-right btn btn-primary float-right  ']) ?>
 
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Sub Category </th>
                    <th>Description</th>
                    <th>Date Added</th>
                    <th>Date Updated</th> 
                    <th>Action</th>
                  </tr>
                  </thead> 
                  <tbody> 
                    <tr>
                        <td><?= $this->Number->format($subcategory->id) ?></td>
                        <td><?= $subcategory->category->category_name ?></td>
                        <td><?= h($subcategory->subcategory_name) ?></td>
                        <td><?= h($subcategory->subcategory_description) ?></td>
                        <td><?= h(date('Y-m-d H:i:s', strtotime($subcategory->date_added))) ?></td>
                        <td><?= h($subcategory->date_updated) ?></td>
                        <td class="actions   "> 
                            <?php echo $this->Html->link(
                                "<font color='blue' size='3px'><i class='fa fa-eye'></i></font>", 
                                [ 'Controller' => 'CategoriesController', 'action' => 'view',  $subcategory->id ],
                                [ 'escape' => false ]//'escape' => false - convert plain text to html
                            );?>
                            <?php echo $this->Html->link(
                                "<font color='green' size='3px'><i class='fa fa-edit'></i></font>", 
                                [ 'Controller' => 'CategoriesController', 'action' => 'edit',  $subcategory->id ],
                                [ 'escape' => false ]//'escape' => false - convert plain text to html 
                            );  ?>
                            <?php echo $this->Form->postLink(
                                "<font color='red' size='3px'><i class='fa fa-trash'></i></font>", 
                                [ 'Controller' => 'CategoriesController', 'action' => 'delete',   $subcategory->id ],
                                [ 'confirm' => __('Are you sure you want to delete # {0}?', $subcategory->id), 'escape' => false ]//'escape' => false - convert plain text to html],   
                            );  ?> 
                        </td>
                    </tr> 
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