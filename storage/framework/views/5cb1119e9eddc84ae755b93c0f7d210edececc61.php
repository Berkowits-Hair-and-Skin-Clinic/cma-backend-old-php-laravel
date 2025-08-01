<?php $__env->startSection('title'); ?>
    <?php echo e(__('message.Medicine')); ?> | <?php echo e(__('Admin Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-data'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>


    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?php echo e(__('message.save')); ?> <?php echo e(__('message.Medicine')); ?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo e(__('message.Medicine')); ?> /
                                </a></li>
                            <li class="active">  <?php echo e(__('message.save')); ?> <?php echo e(__('message.Medicine')); ?></li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a href="#addproduct-billinginfo-collapse" class="text-dark " data-bs-toggle="collapse"
                            aria-expanded="true" aria-controls="addproduct-billinginfo-collapse">
                            <?php if(Session::has('message')): ?>
                                <div class="col-sm-12">
                                    <div class="alert  <?php echo e(Session::get('alert-class', 'alert-info')); ?> alert-dismissible fade show"
                                        role="alert">
                                        <?php echo e(Session::get('message')); ?>

                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </a>
                        <form action="<?php echo e(route('add')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo e(csrf_field()); ?>

                            
                            
                            
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="productname"><?php echo e(__('message.Medicine')); ?>

                                        <?php echo e(__('message.Name')); ?></label>
                                    <input id="medicinename" name="name" type="text" class="form-control"
                                        placeholder=' <?php echo e(__('message.Enter')); ?> <?php echo e(__('message.Medicine')); ?> <?php echo e(__('message.Name')); ?>'required>
                                    <?php if($errors->has('name')): ?>
                                        <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="price"><?php echo e(__('message.Dosage')); ?></label>
                                    <input id="dosage" name="dosage" type="text" class="form-control"
                                        placeholder='<?php echo e(__('message.Enter')); ?> your <?php echo e(__('message.Dosage')); ?>' required>
                                    <?php if($errors->has('Dosage')): ?>
                                        <span class="text-danger"><?php echo e($errors->first('Dosage')); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            

                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label" for="price"><?php echo e(__('message.description')); ?></label>
                                    <input id="description" name="description" type="text" class="form-control"
                                        placeholder='<?php echo e(__('message.Enter Your Description')); ?>' required>
                                    <?php if($errors->has('Dosage')): ?>
                                        <span class="text-danger"><?php echo e($errors->first('Dosage')); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <label for=""><?php echo e(__('message.Type')); ?> <?php echo e(__('message.Medicine')); ?>

                                        :</label>
                                    <div id="showmore">
                                        <div><input type="text" name="type[]" class="form-control"
                                                placeholder='<?php echo e(__('message.Enter')); ?> <?php echo e(__('message.Medicine')); ?> <?php echo e(__('message.Type')); ?>'
                                                required></div><br>
                                    </div>
                                    <a class="btn btn-sm btn-success" id="addmore" style="color: white;"><?php echo e(__('message.Add Medicine')); ?>

                                        <?php echo e(__('message.Type')); ?></a><br><br>
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary "><?php echo e(__('message.Submit')); ?></button>
                            
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script>
        $(document).ready(function() {

            $('#addmore').click(function() {
                event.preventDefault();
                $('#showmore').append(
                    '<div class="row mb-3"><div class="col-10"><input type="text" name="type[]" class="form-control col-10 " placeholder="" required></div><a href="#" class="remove col-2 p-2  btn btn-icon btn-danger" id="remove"><?php echo e(__('message.delete')); ?></a></div>'
                );

            });

            $('#showmore').on("click", ".remove", function(e) {
                e.preventDefault();
                $(this).parent('div').remove();

            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\rutik\live\bookappointment__medical\resources\views/admin/medicines/add-medicines.blade.php ENDPATH**/ ?>