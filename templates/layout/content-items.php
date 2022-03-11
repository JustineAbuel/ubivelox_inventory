  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Items</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List of Items</h3><br><br>
                <?php echo $this->Html->link((
                  '<button class="btn btn-primary">Add New Item</button>'
                  ), array(
                    'action' => 'add-item'), 
                  array(
                    'escape' => false //'escape' => false - convert plain text to html
                  )); ?>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table hover">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Item Name</th>
                    <th>Stocks</th>
                    <th>Description</th>
                    <th>Date Added</th>
                    <th>Date Updated</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($items as $item): ?>
                    <tr>
                      <td><?php echo h($item['id']); ?></td> 
                      <td><?php echo h($item['item_name']); ?></td>
                      <td><?php echo h($item['stocks']); ?></td>
                      <td><?php echo h($item['description']); ?></td>
                      <td><?php echo h($item['date_added']); ?></td>
                      <td><?php echo h($item['date_updated']); ?></td>
                      <td>
                        <?php echo $this->Html->link(
                          "<font color='green' size='5px'><i class='fa fa-edit'></i></font>", 
                          array(
                            'action' => 'edit-item', 
                            $item['id']
                          ),
                          array(
                            'escape' => false //'escape' => false - convert plain text to html
                          )
                          ); 
                        ?>
                        <?php echo $this->Form->postLink(
                          "<font color='red' size='5px'><i class='fa fa-trash'></i></font>", 
                          array(
                            'action' => 'delete-item', 
                            $item['id']
                          ),
                          array(
                            'escape' => false //'escape' => false - convert plain text to html
                          ),
                          'Are you sure you want to delete this record??'
                          ); 
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