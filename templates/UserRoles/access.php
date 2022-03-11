<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
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
              <h3 class="card-title"><legend><?= __('Manage User Role Access ') ?></legend></h3> 
                   

              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                
              <?= $this->Form->create($userAccess) ?> 
              <table id="example1" class="table table-bordered table-striped table hover">
                <thead>
                <tr> 
                  <thead>
                        <td></td>
                        <?php foreach($userRoles as $userRole): ?>
                            <th class="text-center"><?= $userRole->role_name ?></th>
                        <?php endforeach ?>
                    </thead> 
                         
                </tr>
                </thead> 
                <tbody> 
                    <?php foreach($menus as $menu): ?>
                        <tr>
                            <td><?= $menu->menu ?></td>
                            <?php foreach($userRoles as $userRole): ?>
                                <td class="text-center"><?= $this->Form->input('checkbox', ['id' => $menu->id.'_'.$userRole->id ,'type' => 'checkbox', 'class' => 'mx-auto ' ]) ?> </td>
                            <?php endforeach ?>
                        </tr>
                    <?php endforeach ?>
                </tbody> 
              </table>
              
              <div class="row custom-padding mt-3">
                   <div class="col-sm-6">
                       <!-- Select multiple-->
                       <div class="form-group"> 
                            <?= $this->Form->button(__('Save'), ['class' => 'btn btn-primary']) ?>
                           <a href="<?php echo $this->Url->build(('/users')); ?>" class="btn btn-warning"><font color="#F7F7F7">Cancel</font></a>
                       </div>
                   </div>
              </div>
              <?= $this->Form->end() ?>
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