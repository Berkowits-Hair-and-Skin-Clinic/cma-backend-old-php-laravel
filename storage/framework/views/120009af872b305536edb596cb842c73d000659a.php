<?php $__env->startSection('title'); ?>
<?php echo e(__("message.specialities")); ?> | <?php echo e(__("message.Admin")); ?> <?php echo e(__("message.specialities")); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection("meta-data"); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("content"); ?>
<div class="main-content">
   <div class="page-content">
      <div class="container-fluid mb-4">
         <div class="row">
            <div class="col-12">
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
                     <h4 class="card-title float-left"><?php echo e(__("message.specialities")); ?> <?php echo e(__("message.List")); ?></h4>
                     <p><a class="btn btn-primary float-right" href="<?php echo e(url('admin/saveservices/0')); ?>"><?php echo e(__("message.Add")); ?> <?php echo e(__("message.specialities")); ?></a></p>
                     <div class="table-responsive p-3">
                     <table id="servicestable" class="table table-bordered dt-responsive tablels">
                        <thead class="thead-light">
                           <tr>
                              <th><?php echo e(__("message.Id")); ?></th>
                              <th><?php echo e(__("message.Icon")); ?></th>
                              <th><?php echo e(__("message.Name")); ?></th>
                              <th><?php echo e(__("message.Action")); ?></th>
                           </tr>
                        </thead>
                     </table>
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

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\rutik\live\bookappointment__medical\resources\views/admin/service/default.blade.php ENDPATH**/ ?>