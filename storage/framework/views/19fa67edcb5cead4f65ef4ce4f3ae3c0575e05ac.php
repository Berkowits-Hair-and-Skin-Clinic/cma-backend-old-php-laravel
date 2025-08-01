<?php $__env->startSection('title'); ?>
    <?php echo e(__('message.Languages_Translation')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-data'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0"><?php echo e(__('message.Languages_Translation')); ?></h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active"><?php echo e(__('message.Languages_Translation')); ?></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="display: flex;justify-content: center;">
                    <div class="col-md-12 col-lg-6">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h1><?php echo e(__('message.Edit')); ?> (<?php echo e(strtoupper($lang)); ?>)</h1>

                                <form action="<?php echo e(route('languages.update', ['lang' => $lang, 'key' => $key])); ?>"
                                    method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <div class="form-group">
                                        <label for="key"><?php echo e(__('message.Key')); ?></label>
                                        <input type="text" name="key" id="key" class="form-control"
                                            value="<?php echo e($key); ?>" required readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="value"><?php echo e(__('message.Value')); ?></label>
                                        <input type="text" name="value" id="value" class="form-control"
                                            value="<?php echo e($value); ?>" required>
                                    </div>
                                    <?php if(Session::get('is_demo') == '0'): ?>
                                        <button type="button" onclick="disablebtn()"
                                            class="btn custom-btn"><?php echo e(__('message.Submit')); ?></button>
                                    <?php else: ?>
                                        <button class="btn custom-btn" type="submit"
                                            value="Submit"><?php echo e(__('message.Submit')); ?></button>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\rutik\live\bookappointment__medical\resources\views/admin/languages/edit.blade.php ENDPATH**/ ?>