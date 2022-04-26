<?php

use Cake\I18n\FrozenTime;

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

<div class="modal fade" id="uploadItemsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Upload CSV Data (Items)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <?= $this->Form->create($items, ['type' => 'file']) ?>
                <input type="file" name="file" accept=".csv" class="form-control" required="">
                <small><strong>
                        <font color="red">Only .csv file type is allowed</font>
                    </strong></small>

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
                        <h3 class="card-title ">List of Items</h3>
                        <div class="card-tools">

                            <?= $this->Html->link(
                                ' Add New Item ',
                                ['Controller' => 'ItemsController',   'action' => 'add',],
                                ['class' => 'btn btn-primary float-right '],
                                ['escape' => false]
                            ); ?>
                            <?= $this->Html->link(
                                "<font color='white' size='3px'><i class='fa fa-file-excel'></i></font> Mass upload Items",
                                ['action' => 'uploadcsv'],
                                [
                                    'class' => 'float-right btn btn-success float-right mr-2 ',
                                    'data-toggle' => 'modal', 'data-target' => '#uploadItemsModal', 'escape' => false
                                ]
                            )
                            ?>

                        </div>
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
                                    <th><?= ucfirst('serial No.') ?></th>
                                    <th><?= ucfirst('quantity') ?></th>
                                    <th><?= ucfirst('supplier') ?></th>
                                    <th><?= ucfirst('item Type') ?></th>
                                    <th><?= ucfirst('quality') ?></th>

                                    <th>QR Code</th>
                                    <th class="actions"><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item) : ?>
                                    <?php
                                    // $percent = $item->base_quantity * .75;
                                    // dd($percent);
                                    if (h($item['quantity']) > ($item->base_quantity * .75)) {
                                        $tr_class = "table-primary";
                                    } elseif (h($item['quantity']) == 0) {
                                        $tr_class = "table-danger";
                                    } elseif (h($item['quantity']) <= ($item->base_quantity * .5)) {
                                        $tr_class = "table-warning";
                                    }
                                    ?>
                                    <tr class="<?php echo $tr_class; ?>">
                                        <td>
                                            <div class="media">
                                                <?php
                                                $imageclass = 'rounded-circle align-self-center mr-3';
                                                $imagestyle = 'height:2.1rem;width:2.1rem;object-fit: cover;';
                                                if (!$item->image) {
                                                    echo $this->Html->image('item-default.png', ['class' => $imageclass, 'style' => $imagestyle, 'alt' => 'User img']);
                                                } else {
                                                ?>
                                                    <a data-fancybox="gallery" class="primary-btn" href="img/uploads/itemimages/<?= $item->id ?>/<?= $item->image; ?>">
                                                        <?php
                                                        echo $this->Html->image('uploads/itemimages/' . $item->id . '/' . $item->image, ['class' => $imageclass, 'style' => $imagestyle, 'alt' => 'User img']);
                                                        ?>
                                                    </a>
                                                <?php
                                                }
                                                ?>
                                                <div class="media-body">
                                                    <h6 class="mt-0"> <small> <b><?= $item->has('category') ?  $item->category->category_name  : '' ?></b> >
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
                                                ['escape' => false, 'data-toggle' => "modal", 'data-name' => $item->item_name, 'data-id' =>  $item->id, 'class' => "open-AddStockDialog border-transparent bg-transparent p-0"]
                                            );
                                            ?>
                                            <?php echo $this->Html->link(
                                                "<font color='blue' size='3px'><i class='fa fa-eye'></i></font>",
                                                ['Controller' => 'ItemsController', 'action' => 'view', $item->id],
                                                ['escape' => false] //'escape' => false - convert plain text to html 
                                            );
                                            ?>
                                            <?php echo $this->Html->link(
                                                "<font color='green' size='3px'><i class='fa fa-edit'></i></font>",
                                                ['Controller' => 'ItemsController', 'action' => 'edit',  $item['id']],
                                                ['escape' => false] //'escape' => false - convert plain text to html
                                            );
                                            ?>
                                            <?php echo $this->Form->postLink(
                                                "<font color='red' size='3px'><i class='fa fa-trash'></i></font>",
                                                ['Controller' => 'ItemsController', 'action' => 'delete', $item['id']],
                                                ['confirm' => 'Are you sure you want to delete this record?', 'escape' => false] //'escape' => false - convert plain text to html                            
                                            );
                                            ?>

                                        </td>
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

<!-- Modal -->
<div class="modal fade" id="addQuantityModal" tabindex="-1" aria-labelledby="addQuantityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuantityModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="number" name="item-id" id="item-id" required min="0" class="form-control" value="" />
                <div class="errorMsgQuantity"></div>
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
    $(document).ready(function() {
        $('#addQuantityModal').on('hidden.bs.modal', function() {
            $("input[name=item-id]").val('')
        })
        $(document).on("click", ".open-AddStockDialog", function() {
            var itemId = $(this).data('id');
            var itemName = $(this).data('name');
            $(".modal-header #addQuantityModalLabel").html('Add stocks to <b>' + itemName + '</b>');
            $("input[name=item-id]").attr('id', itemId)
        });
        $('#addQuantityBtn').click(function() {
            var quantity = $("input[name=item-id]").val()
            var itemId = $("input[name=item-id]").attr('id')
            if (quantity <= 0 || quantity == null || quantity == "") {
                $('.errorMsgQuantity').html('<small>Please enter a valid value</small>')
                $("#" + itemId).addClass("is-invalid").focus()
            } else {
                $.ajax({
                    method: "POST",
                    url: "<?= $this->Url->build(['controller' => 'Items', 'action' => 'addStocksQuantity']) ?>",
                    type: "JSON",
                    data: {
                        item_id: itemId,
                        quantity: quantity
                    },
                    headers: {
                        'X-CSRF-Token': $("[name='_csrfToken']").val()
                    },

                    beforeSend: function() {},
                    success: function(msg) {

                        location.reload();

                    },
                    cache: false,
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError);
                    }
                })
            }
        })

    });
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "order": [],
            "paging": true,
            "lengthChange": true,
            "lengthMenu": [
                [25, 50, 100, -1],
                [25, 50, 100, 500]
            ],

        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    });
</script>