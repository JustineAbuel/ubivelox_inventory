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
                    <h3 class="card-title ">Item details</h3> 
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
                
                <!-- <label>Legend:</label>
                <button type="button" class="table-primary">Available</button>
                <button type="button" class="table-warning">Re-Stock</button>
                <button type="button" class="table-danger">Out of Stock</button><br><br> -->

                <dl>
                  <dt class="blue"></dt>
                  <dd>Available</dd>

                  <dt class="orange"></dt>
                  <dd>Re-Stock</dd>

                  <dt class="red"></dt>
                  <dd>Out of Stock</dd>
                </dl>
                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr>  
                    <th><?= ucfirst('item') ?></th>  
                    <th><?= ucfirst('serial no') ?></th> 
                    <th><?= ucfirst('quantity') ?></th>
                    <th><?= ucfirst('supplier') ?></th>
                    <th><?= ucfirst('item type') ?></th>
                    <th><?= ucfirst('quality') ?></th>
                     
                    <th>QR Code</th>
                    <th class="actions"><?= __('Actions') ?></th>
                  </tr>
                  </thead>
                  <tbody> 
                        <?php 
                    if(h($item['quantity']) > 0){
                        $tr_class = "table-primary";
                      if(h($item['quantity']) <= 1){
                          $tr_class = "table-warning";
                      }
                    }
                    else{
                      $tr_class = "table-danger";
                    }
                    ?>
                <tr class="<?php echo $tr_class; ?>"> 
                    <td>
                      <div class="media"> 
                      <?php 
                          $imageclass = 'rounded-circle align-self-center mr-3';
                          $imagestyle = 'height:2.1rem;width:2.1rem;object-fit: cover;';
                          if(!$item->image){      
                            echo $this->Html->image('item-default.png', ['class' => $imageclass, 'style' => $imagestyle,'alt'=>'User img' ]); 

                          }else{
                        ?>
                            <a data-fancybox="gallery" class="primary-btn" href="img/uploads/itemimages/<?= $item->id ?>/<?= $item->image; ?>">
                              <?php
                                echo $this->Html->image('uploads/itemimages/'.$item->id.'/'.$item->image, ['class' => $imageclass, 'style' => $imagestyle,'alt'=>'User img' ]);   
                              ?>
                            </a>
                        <?php
                            }
                        ?>
                        <div class="media-body">
                          <h6 class="mt-0"> <small> <b><?= $item->has('category') ?  $item->category->category_name  : '' ?></b>  > 
                          <b><?= $item->has('subcategory') ?  $item->subcategory->subcategory_name  : '' ?> </b></small></h6>
                          <blockquote class="mt-1  mx-0 bg-transparent"><?= h($item->item_name) ?></blockquote>
                        </div>
                      </div> 
                    </td>
                    <td><?= $item->serial_no ?></td>
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
                            " <span style='color:black;'><i class='fa fa-plus' ></i> </span>", 
                            '#addQuantityModal',
                            ['escape' => false, 'data-toggle' => "modal", 'data-name'=> $item->item_name, 'data-id'=>  $item->id, 'class'=>"open-AddStockDialog border-transparent bg-transparent p-0" ]
                            ); 
                            ?>
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
 
<!-- Modal -->
<div class="modal fade" id="addQuantityModal" tabindex="-1" aria-labelledby="addQuantityModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addQuantityModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="number" name="item-id" id="item-id"   class="form-control" value=""/>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="addQuantityBtn">Add quantity</button>
      </div>
    </div>
  </div>
</div> 
 

<?= $this->Html->css('plugins/legend.css'); ?>
<!-- START - This is needed to show image in a popup upon image click --> 
<?= $this->Html->css('plugins/fancybox/fancybox.min.css'); ?>
<?= $this->Html->script('plugins/fancybox/fancybox.min.js'); ?>
<!-- END - This is needed to show image in a popup upon image click -->


<script>
$( document ).ready(function() {
    $('#addQuantityModal').on('hidden.bs.modal', function () {
      $("input[name=item-id]").val('') 
    })
    $(document).on("click", ".open-AddStockDialog", function () {
        var itemId = $(this).data('id');
        var itemName = $(this).data('name'); 
        $(".modal-header #addQuantityModalLabel").html('Add stocks to <b>' + itemName + '</b>'); 
        $("input[name=item-id]").attr('id', itemId)
  
    }); 
    $('#addQuantityBtn').click(function(){
        var quantity =  $("input[name=item-id]").val() 
        var itemId =  $("input[name=item-id]").attr('id')
        $.ajax({
            method: "POST",
            url: "<?= $this->Url->build(['controller' => 'Items', 'action' => 'addStocksQuantity']) ?>",
            type:"JSON",
            data: {
                item_id: itemId,
                quantity: quantity
            },
            headers: {
                'X-CSRF-Token': $("[name='_csrfToken']").val()
            },
            
            beforeSend: function(){  },
            success: function(msg){ 

                location.reload();
                 
            },
            cache: false, 
            error:function (xhr, ajaxOptions, thrownError){  
                alert(thrownError); 
            }     
        })
    })
    function reloadTable() { table = $('#example1').DataTable(); table.ajax.reload(); }; 
});
$(function () {
  $("#example1").DataTable({
    "responsive": true, "lengthChange": false, "autoWidth": false,
    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
    "ordering": false,
    "paging":   true,
    "lengthMenu": [[5, 25, 50, -1], [5, 25, 50, "All"]]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)'); 

  
  
}); 
        
 
</script>