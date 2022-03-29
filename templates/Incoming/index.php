<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Incoming[]|\Cake\Collection\CollectionInterface $incoming
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
                    <h3 class="card-title ">List of Incoming Items</h3> 
               
              </div>
              <!-- /.card-header -->
              <div class="card-body"> 
                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr>  
                     
                    <th><?= ucfirst('item id') ?></th>
                    <th><?= ucfirst('quantity') ?></th>
                    <th><?= ucfirst('total stocks') ?></th>
                    <th><?= ucfirst('date added') ?></th>
                    <th><?= ucfirst('added by') ?></th> 
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($incoming as $incoming): ?>
                <tr >  
                    <td><?= $incoming->has('item') ? $this->Html->link($incoming->item->item_name, ['controller' => 'Items', 'action' => 'view', $incoming->item->id]) : '' ?></td>
                    <td><?= $this->Number->format($incoming->quantity) ?></td>
                    <td><?= $this->Number->format($incoming->item->quantity) ?></td>
                    <td><?= h($incoming->date_added) ?></td>
                    <td><?= $this->Number->format($incoming->added_by) ?></td> 
                </tr>
                <?php endforeach; ?>  

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
    "ordering": false,
    "paging":   true,
    "lengthChange": true,      
    "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, 500]]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)'); 

  
  
}); 
        
 
</script>