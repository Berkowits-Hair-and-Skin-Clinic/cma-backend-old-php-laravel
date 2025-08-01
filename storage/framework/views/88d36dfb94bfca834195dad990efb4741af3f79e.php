<?php $__env->startSection('title'); ?>
    <?php echo e(__('message.Medicine')); ?> | <?php echo e(__('Admin Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-data'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid mb-4">
        <!-- end page title -->
        <?php if(Session::has('message')): ?>
            <div class="col-sm-12">
                <div class="alert <?php echo e(Session::get('alert-class', 'alert-info')); ?> alert-dismissible fade show"
                    role="alert">
                    <i class="uil uil-check me-2"></i>
                    <?php echo e(Session::get('message')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <div>
                                <h4 class="card-title float-left"><?php echo e(__('message.Medicine')); ?> <?php echo e(__('message.List')); ?></h4>
                                <a href="<?php echo e(url('admin/medicinesadd')); ?>" type="button"
                                    class="btn btn-primary waves-effect waves-light mb-3 float-right"><i
                                        class="fas fa-user-plus"></i><?php echo e(__('message.Add Medicine')); ?></a>
                            </div>
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered dt-responsive tablels"
                                    id="medicine" style="border-collapse: collapse; width: 100%;">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 120px;"><?php echo e(__('message.Id')); ?> </th>
                                            <th><?php echo e(__('message.Name')); ?> </th>
                                            <th><?php echo e(__('message.Dosage')); ?> </th>
                                            <th><?php echo e(__('message.description')); ?> </th>
                                            <th><?php echo e(__('message.Medicine')); ?> <?php echo e(__('message.Type')); ?> </th>
                                            <th style="width: 120px;"><?php echo e(__('message.Action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>

                                                <td><a href="javascript: void(0);"
                                                        class="text-reset  fw-bold"><?php echo e($user->id); ?></a> </td>

                                                
                                                <td>
                                                    <span><?php echo e($user->name); ?></span>
                                                </td>
                                                <td><?php echo e($user->dosage); ?></td>
                                                <td><?php echo e($user->description); ?></td>
                                                <td><?php echo e($user->medicine_type); ?></td>
                                                <td>
                                                    <a href="<?php echo e(route('editmedicines', $user->id)); ?>"
                                                        class="px-3 text-primary"><i class="fas fa-edit"></i></a>

                                                    <a href="<?php echo e(route('deletemedicines', $user->id)); ?>"
                                                        class="px-3 px-3 text-danger"><i class="fas fa-trash">
                                                        </i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\rutik\live\bookappointment__medical\resources\views/admin/medicines/default.blade.php ENDPATH**/ ?>