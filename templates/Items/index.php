<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item[]|\Cake\Collection\CollectionInterface $items
 */
?>
 <style>
   th {
    white-space: nowrap;
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
                    <h3 class="card-title ">List of Items</h3> 
                    <?php echo $this->Html->link((
                    ' Add New Item '
                    ),[
                        'Controller' => 'ItemsController',
                        'action' => 'add',
                       
                    ],  [ 'class' => 'btn btn-primary float-right justify-content-end'],
                        
                        [
                            'escape' => false //'escape' => false - convert plain text to html
                        ]); ?> 
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <label>Legend:</label>
                <button type="button" class="table-primary">Available</button>
                <button type="button" class="table-warning">Re-Stock</button>
                <button type="button" class="table-danger">Out of Stock</button><br><br>
                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr>  
                    <th><?= ucfirst('item') ?></th>
                    <th><?= ucfirst('category') ?></th>
                    <th><?= ucfirst('subcategory') ?></th> 
                    <th><?= ucfirst('quantity') ?></th>
                    <th><?= ucfirst('supplier') ?></th>
                    <th><?= ucfirst('item type') ?></th>
                    <th><?= ucfirst('quality') ?></th>
                     
                    <th>QR Code</th>
                    <th class="actions"><?= __('Actions') ?></th>
                  </tr>
                  </thead>
                  <tbody>
                       <?php foreach ($items as $item): ?>
                        <?php 
                    if(h($item['quantity']) > 0){
                        $tr_class = "table-primary";
                        if(h($item['stocks']) <= 1){
                        $tr_class = "table-warning";
                      }
                    }
                    else{
                      $tr_class = "table-danger";
                    }
                    ?>
                <tr class="<?php echo $tr_class; ?>"> 
                    <td><?= h($item->item_name) ?></td>
                    <td><?= $item->has('category') ?  $item->category->category_name  : '' ?></td>
                    <td><?= $item->has('subcategory') ?  $item->subcategory->subcategory_name  : '' ?></td>
                    <td><?= $this->Number->format($item->quantity) ?></td>
                    <td><?= $item->company->company_name ?></td>
                    <td><?= $item->item_type->type_name ?></td>
                    <td><?= $item->quality == 0 ? 'Brand New' : 'Second Hand' ?></td>
                     
                    <td>
                          <?php
                            $this->Common->generateQrInView($item->id)
                          ?>
                    </td> 
                    <td>
                        <?php echo $this->Html->link(
                            "<font color='blue' size='3px'><i class='fa fa-eye'></i></font>", 
                            [ 'Controller' => 'ItemsController', 'action' => 'view' ,$item->id ],
                            [ 'escape' => false ]//'escape' => false - convert plain text to html 
                            ); 
                            ?>
                        <?php echo $this->Html->link(
                          "<font color='green' size='3px'><i class='fa fa-edit'></i></font>", 
                          [ 'Controller' => 'ItemsController', 'action' => 'edit',  $item['id'] ],
                          [ 'escape' => false ] //'escape' => false - convert plain text to html
                          ); 
                        ?>
                        <?php echo $this->Form->postLink(
                          "<font color='red' size='3px'><i class='fa fa-trash'></i></font>", 
                          [ 'Controller' => 'ItemsController', 'action' => 'delete', $item['id'] ],
                          [ 'confirm' => 'Are you sure you want to delete this record?', 'escape' => false ]//'escape' => false - convert plain text to html                            
                          ); 
                          ?>
                    </td>
                </tr>
                <?php endforeach; ?> 
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