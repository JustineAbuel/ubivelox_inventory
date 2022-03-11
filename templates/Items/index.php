<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item[]|\Cake\Collection\CollectionInterface $items
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
                    <th><?= ucfirst('id') ?></th>
                    <th><?= ucfirst('category_id') ?></th>
                    <th><?= ucfirst('item_name') ?></th>
                    <th><?= ucfirst('serial_no') ?></th>
                    <th><?= ucfirst('issued_date') ?></th>
                    <th><?= ucfirst('warranty') ?></th>
                    <th><?= ucfirst('quantity') ?></th>
                    <th><?= ucfirst('supplier_id') ?></th>
                    <th><?= ucfirst('item_type_id') ?></th>
                    <th><?= ucfirst('quality') ?></th>
                    <th><?= ucfirst('part_no') ?></th>
                    <th><?= ucfirst('operating_system') ?></th>
                    <th><?= ucfirst('kernel') ?></th>
                    <th><?= ucfirst('header_type') ?></th>
                    <th><?= ucfirst('firmware') ?></th>
                    <th><?= ucfirst('features') ?></th>
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
                    <td><?= $this->Number->format($item->id) ?></td>
                    <td><?= $item->has('category') ?  $item->category->category_name  : '' ?></td>
                    <td><?= h($item->item_name) ?></td>
                    <td><?= h($item->serial_no) ?></td>
                    <td><?= h($item->issued_date) ?></td>
                    <td><?= h($item->warranty) ?></td>
                    <td><?= $this->Number->format($item->quantity) ?></td>
                    <td><?= $this->Number->format($item->supplier_id) ?></td>
                    <td><?= $this->Number->format($item->item_type_id) ?></td>
                    <td><?= $this->Number->format($item->quality) ?></td>
                    <td><?= h($item->part_no) ?></td>
                    <td><?= h($item->operating_system) ?></td>
                    <td><?= h($item->kernel) ?></td>
                    <td><?= h($item->header_type) ?></td>
                    <td><?= h($item->firmware) ?></td>
                    <td><?= h($item->features) ?></td> 
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