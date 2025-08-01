<?php $__env->startSection('title'); ?>
<?php echo e(__("messages.Packages")); ?> | <?php echo e(__("messages.Admin Dashboard")); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-data'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="main-content">
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Edit Medicine</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo e(__('messages.System Name')); ?> / </a></li>
                            <li class="active">Edit Medicine</li>
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
                        <a href="#addproduct-billinginfo-collapse" class="text-dark " data-bs-toggle="collapse" aria-expanded="true" aria-controls="addproduct-billinginfo-collapse">
                            <?php if(Session::has('message')): ?>
                                <div class="col-sm-12">
                                   <div class="alert  <?php echo e(Session::get('alert-class', 'alert-info')); ?> alert-dismissible fade show" role="alert">
                                      <?php echo e(Session::get('message')); ?>

                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                      </button>
                                   </div>
                                </div>
                            <?php endif; ?>

                        </a>
                        <form action="<?php echo e(route('editmedicinessave')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                        <?php echo method_field('PATCH'); ?>
                            
                                
                                    <input type="hidden" name="id" value="<?php echo e($data->id); ?>">
                                    
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="productname">Medicine Name</label>
                                                <input id="medicinename" name="name" type="text" class="form-control" value="<?php echo e($data->name); ?>" placeholder='Enter your Medicine Name'required>
                                                <?php if($errors->has('name')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>


                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="price">Dosage</label>
                                                <input id="dosage" name="dosage" type="text" class="form-control" value="<?php echo e($data->dosage); ?>" placeholder="Enter your Dosage" required>
                                                <?php if($errors->has('Dosage')): ?>
                                                    <span class="text-danger"><?php echo e($errors->first('Dosage')); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="price">Description</label>
                                            <input id="description" name="description" type="text" class="form-control" value="<?php echo e($data->description); ?>" placeholder="Enter your description" required>

                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="">Type Medicine :</label>
                                            <div id="showmore">
                                                <?php
                                                        $s = explode(',',$data->medicine_type);
                                                ?>
                                                <?php $__currentLoopData = $s; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($loop->first): ?>
                                                    <div><input type="text" name="type[]" class="form-control" value="<?php echo e($o); ?>" placeholder="Enter your Type Medicine" required></div><br>
                                                    <?php else: ?>
                                                    <div class="row"><div class="col-10"><input type="text" name="type[]" class="form-control col-10" value="<?php echo e($o); ?>" placeholder="add options" required></div><a href="#" class="remove col-2 p-2 btn btn-icon btn-danger" id="remove">delete</a></div><br>
                                                    <?php endif; ?>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </div>
                                            <a class="btn btn-sm btn-success" id="addmore">Add Medicine type</a><br><br>
                                        </div>
                                    </div>

                                    

                                    <button type="submit" class="btn btn-primary ">Submit</button>
                                
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container-fluid -->
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function(){

        $('#addmore').click(function(){
            event.preventDefault();
            $('#showmore').append('<div class="row"><div class="col-10"><input type="text" name="type[]" class="form-control col-10 " placeholder="add options" required></div><a href="#" class="remove col-2 p-2  btn btn-icon btn-danger" id="remove">delete</a></div><br>');

        });

        $('#showmore').on("click",".remove",function(e){
            e.preventDefault();
            $(this).parent('div').remove();

        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/freakd1c/public_html/demo/bookappointment/resources/views/admin/medicines/edit-medicines.blade.php ENDPATH**/ ?>