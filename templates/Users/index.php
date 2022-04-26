<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
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
                        <h3 class="card-title"> <?= __('List of Users') ?> </h3>

                        <?php
                        // $allowedUser = [
                        //   1, //Dev
                        //   2, //HR
                        //   3, //IT
                        // ];
                        // if( in_array($this->request->getAttribute('identity')->role_id, $allowedUser) ){
                        echo $this->Html->link(__('Add New User'), ['action' => 'add'], ['class' => 'button float-right btn btn-primary float-right  ']);
                        // }

                        ?>


                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped table hover">
                            <thead>
                                <tr>
                                    <th><?= ucfirst('id') ?></th>
                                    <th><?= ucfirst('user') ?></th>
                                    <th><?= ucfirst('user Name') ?></th>
                                    <th><?= ucfirst('contact No.') ?></th>
                                    <th><?= ucfirst('role ') ?></th>
                                    <th><?= ucfirst('status') ?></th>
                                    <th><?= ucfirst('date Added') ?></th>
                                    <th class="actions"><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?= $this->Number->format($user->id) ?></td>
                                        <td>
                                            <div class="media">
                                                <?php
                                                $imageclass = 'rounded-circle align-self-center mr-3';
                                                $imagestyle = 'height:2.1rem;width:2.1rem;object-fit: cover;';
                                                if (!$user->image) {
                                                    echo $this->Html->image('avatar.png', ['class' => $imageclass, 'style' => $imagestyle, 'alt' => 'User img']);
                                                } else {
                                                ?>
                                                    <a data-fancybox="gallery" class="primary-btn" href="img/uploads/profilepicture/<?= $user->id ?>/<?= $user->image; ?>">
                                                        <?php
                                                        echo $this->Html->image('uploads/profilepicture/' . $user->id . '/' . $user->image, ['class' => $imageclass, 'style' => $imagestyle, 'alt' => 'User img']);
                                                        ?>
                                                    </a>
                                                <?php
                                                }
                                                ?>
                                                <div class="media-body">
                                                    <h6 class="mt-0"><?= ucfirst(h($user->firstname)) . ' ' . ucfirst(h($user->lastname))  ?></h6>
                                                    <p class="m-0"><small><?= h($user->email) ?></small></p>
                                                </div>
                                            </div>


                                        </td>
                                        <td><?= h($user->username) ?></td>
                                        <td><?= h($user->contactno) ?></td>
                                        <td><?= h($user->user_role->role_name) ?></td>
                                        <td><?= h($user->status == 0 ? 'Active' : 'Inactive') ?></td>
                                        <td><?= h($user->date_added) ?></td>
                                        <td class="actions   ">
                                            <?php
                                            if ($this->request->getAttribute('identity')->can('view', $user)) {
                                                echo $this->Html->link(
                                                    "<font color='blue' size='3px'><i class='fa fa-eye'></i></font>",
                                                    ['Controller' => 'UsersController', 'action' => 'view', $user->id],
                                                    ['escape' => false]  //'escape' => false - convert plain text to html 
                                                );
                                            }
                                            ?>
                                            <?php

                                            if ($this->request->getAttribute('identity')->can('edit', $user)) {
                                                echo $this->Html->link(
                                                    "<font color='green' size='3px'><i class='fa fa-edit'></i></font>",
                                                    ['Controller' => 'UsersController', 'action' => 'edit',  $user->id],
                                                    ['escape' => false]  //'escape' => false - convert plain text to html
                                                );
                                            }
                                            ?>
                                            <?php

                                            if ($this->request->getAttribute('identity')->can('delete', $user)) {
                                                echo $this->Form->postLink(
                                                    "<font color='red' size='3px'><i class='fa fa-trash'></i></font>",
                                                    ['Controller' => 'UsersController', 'action' => 'delete', $user['id']],
                                                    ['confirm' => 'Are you sure you want to delete this record?', 'escape' => false]
                                                );
                                            }
                                            ?>
                                            <?php

                                            if ($this->request->getAttribute('identity')->can('resetPassword', $user)) {
                                                echo $this->Form->postLink(
                                                    "<font color='#ffc107 ' size='3px'><i class='fa fa-lock'></i></font>",
                                                    ['Controller' => 'UsersController', 'action' => 'resetPassword', $user['id']],
                                                    ['confirm' => 'Are you sure you want to reset this user\'s password?', 'escape' => false]
                                                );
                                            }
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



<!-- START - This is needed to show image in a popup upon image click -->
<?= $this->Html->css('plugins/fancybox/fancybox.min.css'); ?>
<?= $this->Html->script('plugins/fancybox/fancybox.min.js'); ?>
<!-- END - This is needed to show image in a popup upon image click -->

<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "paging": true,
            // 'order': false,  
            "lengthChange": true,
            "lengthMenu": [
                [25, 50, 100, -1],
                [25, 50, 100, 500]
            ]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>