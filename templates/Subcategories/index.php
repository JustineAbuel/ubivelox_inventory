 
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category[]|\Cake\Collection\CollectionInterface $categories
 */
?>
 
  <!-- Content Wrapper. Contains page content -->

  <div class="modal fade" id="uploadCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload CSV Data (Item Subcategory)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      <?= $this->Form->create($subcategories, ['type' => 'file' ]) ?> 
        <label>Select Item Category:</label>
        <select name="category_id" class="form-control" required="">
            <option value="">Select Item Category</option>
            <?php 
            foreach ($categories as $key => $category) {
              ?>
              <option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
              <?php
            }
            ?>
        </select>
        
        <label>Select Item Subcategory CSV File:</label>
        <input type="file" name="file" accept=".csv" class="form-control" required="">
        <small><strong><font color="red">Only .csv file type is allowed</font></strong></small>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="submit">Import/Upload Data</button>
      </div>
      
      <?= $this->Form->end() ?>
    </div>
  </div>
</div> 

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
          
          <?= $this->Flash->render() ?>

            <div class="card">
              <div class="card-header     "> 
                    <h3 class="card-title ">List of Subcategories</h3> 
                    
    
                <div class="card-tools">  
                <?= $this->Html->link(__('New Subcategory'), ['action' => 'add'], ['class' => 'button float-right btn btn-primary float-right  ']) ?>
                    <?= $this->Html->link(
                      "<font color='white' size='3px'><i class='fa fa-file-excel'></i></font> Mass upload Subcategory", 
                      ['action' => 'uploadcsv'], 
                      ['class' => 'float-right btn btn-success float-right mr-2 ',
                      'data-toggle' => 'modal','data-target' => '#uploadCategoryModal', 'escape' => false ]) 
                    ?>
 
                </div>
                
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
                    <?php foreach ($subcategories as $subcategory): ?>
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