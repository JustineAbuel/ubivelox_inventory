<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $item
 * @var \Cake\Collection\CollectionInterface|string[] $categories
 */
?>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?= $this->Flash->render() ?>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Item</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <?= $this->Form->create($item, ['type' => 'file']) ?>
                        <div class="row custom-padding">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php

                                    $imageclass = ' align-self-center mr-3';
                                    $imagestyle = 'height:5rem;width:5rem;object-fit: cover;';
                                    if (!$item->image) {
                                        echo $this->Html->image('item-default.png', ['class' => $imageclass, 'style' => $imagestyle, 'alt' => 'User img', 'id' => 'imageRender']);
                                    } else {
                                        // $this->Html->image('uploads/itemimages/'.$item->image, ['class' => $imageclass, 'style' => $imagestyle,'alt'=>'User img', 'id' => 'imageRender' ]);   

                                        echo $this->Html->image('uploads/itemimages/' . $item->id . '/' . $item->image, ['class' => $imageclass, 'style' => $imagestyle, 'alt' => 'User img', 'id' => 'imageRender']);
                                    }
                                    ?>
                                    <div class="custom-file mt-3">
                                        <?= $this->Form->control('image_file', [
                                            'type' => 'file', 'class' => 'custom-file-input', 'id' => 'customFile', 'placeholder' => 'Image', 'label' => false,
                                            "accept" => "image/png, image/gif, image/jpeg"
                                        ]); ?>
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                    <span class="text-danger"><small><b> Only accepts .png, .jpg, .jpeg. File size must not exceed 5MB</b> </small></span>
                                </div>
                            </div>
                        </div>



                        <div class="row custom-padding">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <?= $this->Form->control('category_id', ['options' => $categories, 'class' => 'form-control', 'placeholder' => 'Category']); ?>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">

                                    <?= $this->Form->control('subcategory_id', ['options' => $subcategories, 'class' => 'form-control', 'placeholder' => 'Subategory']); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row custom-padding">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">

                                    <?= $this->Form->control('item_name', ['class' => 'form-control', 'placeholder' => 'Item name']); ?>

                                </div>
                            </div>

                            <div class="col-sm-6 row">
                                <!-- text input -->
                                <div class="form-group col-md-6">

                                    <?= $this->Form->control('base_quantity', ['class' => 'form-control', 'placeholder' => 'Base Quantity', 'label' => ['text' => 'Base Quantity <small style="color:red">Default value: 100</small>', 'escape' => false]]); ?>

                                </div>
                                <div class="form-group col-md-6">

                                    <?= $this->Form->control('quantity', ['class' => 'form-control', 'placeholder' => 'Quantity']); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row custom-padding">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">

                                    <?= $this->Form->control('serial_no', ['class' => 'form-control', 'placeholder' => 'Serial Number']); ?>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">

                                    <?= $this->Form->control('supplier_id', ['options' => $company, 'class' => 'form-control']); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row custom-padding">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">

                                    <?= $this->Form->control('issued_date', ['class' => 'form-control']); ?>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">

                                    <?= $this->Form->control('manufacturer_warranty', ['class' => 'form-control', 'empty' => true]); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row custom-padding">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">

                                    <?= $this->Form->control('item_type_id', ['options' => $itemTypes, 'class' => 'form-control', 'placeholder' => 'Type ']); ?>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <label for="quality">Quality</label>
                                <div class="form-group">
                                    <?php
                                    $this->Form->setTemplates([
                                        'nestingLabel' => '<div class="form-check form-check-inline">{{input}}<label{{attrs}} class="my-auto">{{text}}</label></div>',
                                        'formGroup' => '{{label}}{{input}}',
                                    ]);
                                    echo  $this->Form->radio('quality', $quality, ['type' => 'radio', 'class' => 'form-check-input',]);
                                    ?>


                                </div>

                            </div>
                        </div>

                        <div class="row custom-padding">

                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <?= $this->Form->control('item_description', ['class' => 'form-control', 'placeholder' => 'Item Description']); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">

                                    <?= $this->Form->control('remarks', ['class' => 'form-control', 'placeholder' => 'Remarks ']); ?>

                                </div>
                            </div>

                        </div>


                        <div class="row custom-padding">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">

                                    <?= $this->Form->control('operating_system', ['class' => 'form-control', 'placeholder' => 'Operating System ']); ?>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">

                                    <?= $this->Form->control('kernel', ["class" => 'form-control', 'placeholder' => 'Kernel ']); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row custom-padding">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">

                                    <?= $this->Form->control('header_type', ['class' => 'form-control', 'placeholder' => 'Header Type ']); ?>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">

                                    <?= $this->Form->control('firmware', ["class" => 'form-control', 'placeholder' => 'Firmware ']); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row custom-padding">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">

                                    <?= $this->Form->control('features', ['class' => 'form-control', 'placeholder' => 'Features ']); ?>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">

                                    <?= $this->Form->control('part_no', ["class" => 'form-control', 'placeholder' => 'Part number ']); ?>
                                </div>
                            </div>
                        </div>


                        <div class="row custom-padding">
                            <div class="col-sm-6">
                                <!-- Select multiple-->
                                <div class="form-group">
                                    <button class="btn btn-primary">Update</button>
                                    <a href="<?php echo $this->Url->build(('/items'), array('action' => 'userlist')); ?>" class="btn btn-warning">
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

<script>
    document.getElementById("customFile").onchange = function() {
        var reader = new FileReader();

        reader.onload = function(e) {
            // get loaded data and render thumbnail.
            document.getElementById("imageRender").src = e.target.result;
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };

    $(document).ready(function() {

        $('#category-id').change(() => {

            var categoryId = $('#category-id').val();
            $.ajax({
                method: "POST",
                url: "<?= $this->Url->build(['controller' => 'Items', 'action' => 'getsubcategories']) ?>",
                type: "JSON",
                data: {
                    category_id: categoryId
                },
                headers: {
                    'X-CSRF-Token': $("[name='_csrfToken']").val()
                },

                beforeSend: function() {},
                success: function(msg) {
                    console.log(msg.subcategories)
                    $("#subcategory-id").empty().append(msg.subcategories);
                },
                cache: false,
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            })
        })


    });
</script>