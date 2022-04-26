<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<style type="text/css">
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <?= $this->Flash->render() ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> <?= __('Add User') ?> </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?= $this->Form->create($user) ?>

                        <div class="row custom-padding">
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <?= $this->Form->control('firstname', ['class' => 'form-control', 'placeholder' => 'First Name', 'label' => ['text' => 'First Name <span class="text-danger">*</span>', 'escape' => false]]); ?>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <?= $this->Form->control('middlename', ['class' => 'form-control', 'placeholder' => 'Middle  Name', 'label' => ['text' => 'Middle Name']]); ?>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <?= $this->Form->control('lastname', ['class' => 'form-control', 'placeholder' => 'Last  Name', 'label' => ['text' => 'Last Name <span class="text-danger">*</span>', 'escape' => false]]); ?>

                                </div>
                            </div>
                        </div>

                        <div class="row custom-padding">
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <?= $this->Form->control('email', ['class' => 'form-control', 'placeholder' => 'Email', 'label' => ['text' => 'Email <span class="text-danger">*</span>', 'escape' => false]]); ?>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <?= $this->Form->control('username', ['class' => 'form-control', 'placeholder' => 'User Name', 'label' => ['text' => 'User Name <span class="text-danger">*</span>', 'escape' => false]]); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row custom-padding">
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Mobile No. <font color="red">*</font></label>
                                    <input class="form-control" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="11" name="contactno" placeholder="Mobile No." required="true" />
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- text input -->
                                <div class="form-group">
                                    <?= $this->Form->control('role_id', ['options' => $userRole, 'class' => 'form-control', 'placeholder' => 'Role', 'label' => ['text' => 'Role <span class="text-danger">*</span>', 'escape' => false]]); ?>

                                </div>
                            </div>
                        </div>

                        <div class="row custom-padding">
                            <div class="col-sm-6">
                                <!-- Select multiple-->
                                <div class="form-group">
                                    <?= $this->Form->button(__('Add'), ['class' => 'btn btn-primary']) ?>
                                    <a href="<?php echo $this->Url->build(('/users')); ?>" class="btn btn-warning">
                                        <font color="#F7F7F7">Cancel</font>
                                    </a>
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