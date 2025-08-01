<?php $__env->startSection('title'); ?>
<?php echo e(__("message.Change Password")); ?> | <?php echo e(__("message.Admin")); ?>

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
                  <h4 class="mb-0"><?php echo e(__("message.Change Password")); ?></h4>
                  <div class="page-title-right">
                     <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo e(__("message.Dashboard")); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo e(__("message.Change Password")); ?></li>
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <div class="row" style="display: flex;justify-content: center;">
            <div class="col-xl-6 col-md-12">
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
                     <form action="<?php echo e(url('admin/updatepassword')); ?>" method="post" >
                        <?php echo e(csrf_field()); ?>

                        <div class="form-group">
                           <label for="formrow-firstname-input"><?php echo e(__("message.Enter Your Current Password")); ?></label>
                           <input type="password" class="form-control" id="currentpwd" name="currentpwd" placeholder='<?php echo e(__("message.Enter Your Current Password")); ?>' required onchange="currentpwdnew(this.value)">
                        </div>
                        <div class="form-group">
                           <label for="formrow-firstname-input"><?php echo e(__("message.Enter Your Current Password")); ?></label>
                           <input type="password" class="form-control" id="newpwd" name="newpwd" placeholder='<?php echo e(__("message.Enter Your Current Password")); ?>' value="" required>
                        </div>
                        <div class="form-group">
                           <label for="formrow-firstname-input"><?php echo e(__("message.Re Enter New Password")); ?></label>
                           <input type="password" class="form-control" id="repwd" name="repwd" placeholder='<?php echo e(__("message.Re Enter New Password")); ?>' required onchange="checkmatchpassword(this.value)">
                        </div>
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<script type="text/javascript">
  function checkmatchpassword(val){
    var npwd=$("#newpwd").val();
    if(npwd!=val){
        alert('<?php echo e(__("message.Password And Confirm Password Must Be Same")); ?>');
        $("#repwd").val("");
    }
}

function currentpwdnew(val){
   $.ajax({
                url: '<?php echo e(url("admin/check_password_same")); ?>'+'/'+val,
                method:"get",
                success: function( data ) {
                    if(data==0){
                        alert('<?php echo e(__("message.Current Password is Wrong")); ?>');
                        $("#currentpwd").val("");
                    }
                }
    });
}

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\rutik\live\bookappointment__medical\resources\views/admin/changepassword.blade.php ENDPATH**/ ?>