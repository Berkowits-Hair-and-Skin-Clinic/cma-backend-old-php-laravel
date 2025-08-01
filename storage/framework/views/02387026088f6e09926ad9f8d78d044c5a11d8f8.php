<?php $__env->startSection('title'); ?>
<?php echo e(__("message.Edit Notification Key")); ?> | <?php echo e(__("message.Admin")); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-data'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="main-content">
   <div class="page-content">
      <div class="container-fluid">
         <div class="row" style="display: flex;justify-content: center;">
            <div class="col-xl-12 col-md-12">
               <div class="card">
                  <div class="card-body">
                     <?php if(Session::has('message')): ?>
                     <div class="col-sm-12">
                        <div class="alert  <?php echo e(Session::get('alert-class', 'alert-info')); ?> alert-dismissible fade show" role="alert"><?php echo e(Session::get('message')); ?>

                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                     </div>
                     <?php endif; ?>
                     <h4><?php echo e(__("message.Edit Notification Key")); ?></h4>
                     <div class="row" style="display: flex;justify-content: center;">
                        <div class="col-xl-8 col-md-12 border p-4">
                     <form action="<?php echo e(url('admin/updatenotificationkey')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                        
                        <div class="form-group">
                            <label for="formrow-firstname-input"><?php echo e(__("message.uploade_json_file")); ?></label>
                            <input type="file" class="form-control" required="" id="jsonfile" name="jsonfile">
                         </div>
                         <p><b><?php echo e(__("message.uploaded_file_name")); ?> :</b> <?php echo e($user->not_json_filename); ?></p>
                        <div class="mt-4">
                           <?php if(Session::get("is_demo")=='0'): ?>
                              <button type="button" onclick="disablebtn()" class="btn btn-primary"><?php echo e(__('message.Submit')); ?></button>
                           <?php else: ?>
                               <button  class="btn btn-primary" type="submit" value="Submit"><?php echo e(__("message.Submit")); ?></button>
                           <?php endif; ?>
                        </div>
                     </form>
                     </div>
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

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/admin/notificationkey.blade.php ENDPATH**/ ?>