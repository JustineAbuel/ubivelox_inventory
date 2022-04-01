<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 */
?>
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

          <?= $this->Flash->render() ?>
          
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Upload CSV Data (Company)</h3><br><br>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <?= $this->Form->create($company,['method' => 'post','enctype' => 'multipart/form-data']) ?>
                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- text input -->
                       <div class="form-group"> 
                           <input type="file" name="file" accept=".csv" class="form-control" required="">
                           <small><strong><font color="red">Only .csv file type is allowed</font></strong></small>
                       </div>
                   </div>
                </div>

                <div class="row custom-padding">
                   <div class="col-sm-6">
                       <!-- Select multiple-->
                       <div class="form-group"> 
                            <!-- 1=Client, 2=Supplier -->
                            <?= $this->Form->button(__('Upload'), ['class' => 'btn btn-success','type' => 'submit','name' => 'submit']) ?>
                           <a href="<?php echo $this->Url->build(('/company')); ?>" class="btn btn-warning"><font color="#F7F7F7">Cancel</font></a>
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
