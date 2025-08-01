<?php $__env->startSection('title'); ?>
    <?php echo e(__('message.save')); ?> <?php echo e(__('message.Pharmacy')); ?> | <?php echo e(__('message.Admin')); ?> <?php echo e(__('message.Pharmacy')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-data'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?php echo e(__('message.save')); ?> <?php echo e(__('message.Pharmacy')); ?></h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('admin/Pharmacy')); ?>"><?php echo e(__('message.Pharmacy')); ?></a>
                            </li>
                            <li class="breadcrumb-item active"><?php echo e(__('message.save')); ?> <?php echo e(__('message.Pharmacy')); ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="display: flex;justify-content: center;">
            <div class="col-xl-8 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo e(url('admin/updatemedicine')); ?>" class="needs-validation" method="post"
                            enctype="multipart/form-data">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="pharmacy_id" id="pharmacy_id" value="<?php echo e($pharmacy_id); ?>">
                            <input type="hidden" name="medicine_id" id="medicine_id" value="<?php echo e($medicine_id); ?>">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="mar20">
                                            <div id="uploaded_image">
                                                <div class="upload-btn-wrapper">
                                                    <button type="button" class="btn imgcatlog">
                                                        <input type="hidden" name="real_basic_img" id="real_basic_img"
                                                            value="<?= isset($data->image) ? $data->image : '' ?>" />
                                                        <?php
                                                        if (isset($data->image)) {
                                                            $path = asset('public/upload/pharmacymedicine') . '/' . $data->image;
                                                        } else {
                                                            $path = asset('public/upload/pharmacymedicine/medicine.png');
                                                        }
                                                        ?>
                                                        <img src="<?php echo e($path); ?>" alt="..."
                                                            class="img-thumbnail imgsize" id="basic_img" width="150px;">
                                                    </button>
                                                    <input type="hidden" name="basic_img" id="basic_img1" />
                                                    <input type="file" name="upload_image" id="upload_image" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name"><?php echo e(__('message.Name')); ?><span
                                                class="reqfield">*</span></label>
                                        <input type="text" class="form-control"
                                            placeholder=' <?php echo e(__('message.Enter')); ?> <?php echo e(__('message.Medicine')); ?> <?php echo e(__('message.Name')); ?>'
                                            id="name" name="name" required=""
                                            value="<?= isset($data->name) ? $data->name : '' ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="password"><?php echo e(__('message.Price')); ?><span
                                                class="reqfield">*</span></label>
                                        <input type="text" class="form-control" id="Price"
                                            placeholder='<?php echo e(__('message.Enter')); ?> <?php echo e(__('message.Price')); ?>'
                                            name="price" required=""
                                            value="<?= isset($data->price) ? $data->price : '' ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="description"><?php echo e(__('message.description')); ?><span
                                                class="reqfield">*</span></label>
                                        <textarea id="description" class="form-control" rows="5" placeholder='<?php echo e(__('message.Enter Your Description')); ?>'
                                            name="description" required=""><?php echo e(isset($data->description) ? $data->description : ''); ?></textarea>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                            </div>




                            <div class="row">
                                <div class="form-group">
                                    <?php if(Session::get('is_demo') == '0'): ?>
                                        <button type="button" onclick="disablebtn()"
                                            class="btn btn-primary"><?php echo e(__('message.Submit')); ?></button>
                                    <?php else: ?>
                                        <button class="btn btn-primary" type="submit"
                                            value="Submit"><?php echo e(__('message.Submit')); ?></button>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-admin/resources/views/admin/pharmacy/savemedicine.blade.php ENDPATH**/ ?>