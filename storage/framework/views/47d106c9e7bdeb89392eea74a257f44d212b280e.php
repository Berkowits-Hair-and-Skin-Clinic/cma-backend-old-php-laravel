<?php $__env->startSection('title'); ?>
    <?php echo e(__('message.Pharmacy')); ?> <?php echo e(__('message.Medicine')); ?>

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

                            </div>
                            <h4 class="card-title float-left"><?php echo e(__('message.Medicine')); ?> <?php echo e(__("message.List")); ?></h4>
                            <p> <a href="<?php echo e(url('admin/addmedicine/' . $pharmacy_id . '/0')); ?>" type="button"  class="btn btn-primary waves-effect waves-light mb-3 float-right"></i><?php echo e(__('message.Add')); ?> <?php echo e(__('message.Medicine')); ?></a></p>
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered dt-responsive tablels"
                                    id="dataTable" style="border-collapse: collapse; width: 100%;">
                                    <thead class="thead-light">
                                        <tr>

                                            <th><?php echo e(__('message.Id')); ?></th>
                                            <th><?php echo e(__('message.Image')); ?></th>
                                            <th><?php echo e(__('message.Name')); ?></th>
                                            <th><?php echo e(__('message.description')); ?></th>
                                            <th><?php echo e(__('message.Price')); ?></th>
                                            <th><?php echo e(__('message.Action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($data->id); ?></td>
                                                <td>
                                                    <img src="<?php echo e(asset('public/upload/pharmacymedicine/' . $data->image)); ?>"
                                                        width="60px;" alt="">
                                                </td>
                                                <td><?php echo e($data->name); ?></td>
                                                <td><?php echo e($data->description); ?></td>
                                                <td><?php echo e($data->price); ?></td>
                                                <td>
                                                    <a href="<?php echo e(url('admin/addmedicine/' . $data->pharmacy_id . '/' . $data->id)); ?>"
                                                        class="px-3 text-primary"><i
                                                            class="fas fa-edit"></i></a>

                                                    <?php if(Session::get('is_demo') == '0'): ?>
                                                        <a href="#" onclick="disablebtn()"
                                                            class="px-3 px-3 text-danger"><i class="fas fa-trash">
                                                            </i></a>
                                                    <?php else: ?>
                                                        <a href="<?php echo e(route('medicinedelete', $data->id)); ?>"
                                                            class="px-3 px-3 text-danger"><i class="fas fa-trash">
                                                            </i></a>
                                                    <?php endif; ?>
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

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-admin/resources/views/admin/pharmacy/pharmacymedicine.blade.php ENDPATH**/ ?>