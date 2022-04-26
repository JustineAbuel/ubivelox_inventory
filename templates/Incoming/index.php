<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Incoming[]|\Cake\Collection\CollectionInterface $incoming
 */
?>
<link rel="stylesheet" href="/css/plugins/datatables/dataTables.dateTime.min.css" />
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
                        <div class="row custom-padding">
                            <div class="col-sm-4 row">
                                <!-- text input -->
                                <div class="form-group">
                                    <input type="text" id="min" name="min" placeholder="Date from">
                                </div>
                                <div class="form-group">
                                    <input type="text" id="max" name="max" placeholder="Date to">
                                </div>
                            </div>
                        </div>
                        <table id="example1" class="table table-bordered table-striped table hover">
                            <thead>
                                <tr>

                                    <th><?= ucfirst('item name') ?></th>
                                    <th><?= ucfirst('quantity') ?></th>
                                    <th><?= ucfirst('total stocks') ?></th>
                                    <th><?= ucfirst('date added') ?></th>
                                    <th><?= ucfirst('added by') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($incoming as $incoming) : ?>
                                    <tr>
                                        <td><?= $incoming->has('item') ? $this->Html->link($incoming->item->item_name, ['controller' => 'Items', 'action' => 'view', $incoming->item->id]) : '' ?></td>
                                        <td><?= $this->Number->format($incoming->quantity) ?></td>
                                        <td><?= $this->Number->format($incoming->item->quantity) ?></td>
                                        <td><?= ($incoming->date_added) ?></td>
                                        <td><?= ucfirst($incoming->Users['firstname']) . ' ' . ucfirst($incoming->Users['lastname']) ?></td>
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
<script src="/js/plugins/moment/moment.min.js"></script>
<script src="/js/plugins/datatables/dataTables.dateTime.min.js"></script>
<script>
    // $(function() {
    //     $("#example1").DataTable({
    //         "responsive": true,
    //         "lengthChange": false,
    //         "autoWidth": false,
    //         "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
    //         "ordering": true,
    //         "paging": true,
    //         "lengthChange": true,
    //         "lengthMenu": [
    //             [25, 50, 100, -1],
    //             [25, 50, 100, 500]
    //         ]
    //     }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


    // });
    var minDate, maxDate;

    // Custom filtering function which will search data in column four between two values
    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var min = minDate.val();
            var max = maxDate.val();
            var date = new Date(data[3]);
            console.log(data[3]);

            if (
                (min === null && max === null) ||
                (min === null && date <= max) ||
                (min <= date && max === null) ||
                (min <= date && date <= max)
            ) {
                return true;
            }
            return false;
        }
    );

    $(document).ready(function() {
        // Create date inputs
        minDate = new DateTime($('#min'), {
            format: 'M/D/YY'
        });
        maxDate = new DateTime($('#max'), {
            format: 'M/D/YY'
        });

        // DataTables initialisation
        var table = $('#example1').DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "ordering": true,
            "paging": true,
            "lengthChange": true,
            "lengthMenu": [
                [11, 50, 100, -1],
                [11, 50, 100, 500]
            ]
        });
        table.buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        // Refilter the table
        $('#min, #max').on('change', function() {
            table.draw();
        });
    });
</script>