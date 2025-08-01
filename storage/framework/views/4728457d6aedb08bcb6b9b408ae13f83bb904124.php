<?php $__env->startSection('title'); ?>
<?php echo e(__('message.Change Password')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-data'); ?>
<meta property="og:type" content="website"/>
<meta property="og:url" content="<?php echo e(__('message.System Name')); ?>"/>
<meta property="og:title" content="<?php echo e(__('message.System Name')); ?>"/>
<meta property="og:image" content="<?php echo e(asset('public/image_web/').'/'.$setting->favicon); ?>"/>
<meta property="og:image:width" content="250px"/>
<meta property="og:image:height" content="250px"/>
<meta property="og:site_name" content="<?php echo e(__('message.System Name')); ?>"/>
<meta property="og:description" content="<?php echo e(__('message.meta_description')); ?>"/>
<meta property="og:keyword" content="<?php echo e(__('message.Meta Keyword')); ?>"/>
<link rel="shortcut icon" href="<?php echo e(asset('public/image_web/').'/'.$setting->favicon); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<section class="page-title-two">
   <div class="title-box centred bg-color-2">
      <div class="pattern-layer">
         <div class="pattern-1" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-70.png')); ?>');"></div>
         <div class="pattern-2" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-71.png')); ?>');"></div>
      </div>
      <div class="auto-container">
         <div class="title">
            <h1><?php echo e(__('message.Change Password')); ?></h1>
         </div>
      </div>
   </div>
   <div class="lower-content">
      <ul class="bread-crumb clearfix">
         <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__("message.Home")); ?></a></li>
         <li><?php echo e(__('message.Change Password')); ?></li>
      </ul>
   </div>
</section>
<section class="patient-dashboard bg-color-3">
   <div class="left-panel">
      <div class="profile-box patient-profile">
         <div class="upper-box">
            <figure class="profile-image">
               <?php if($userdata->profile_pic!=""): ?>
               <img src="<?php echo e(asset('public/upload/profile').'/'.$userdata->profile_pic); ?>" alt="">
               <?php else: ?>
               <img src="<?php echo e(asset('public/upload/profile/profile.png')); ?>" alt="">
               <?php endif; ?>
            </figure>
            <div class="title-box centred">
               <div class="inner">
                  <h3><?php echo e($userdata->name); ?></h3>
                  <p><i class="fas fa-envelope"></i><?php echo e($userdata->email); ?></p>
               </div>
            </div>
         </div>
         <div class="profile-info">
            <ul class="list clearfix">
            <li><a href="<?php echo e(url('searchcenterall')); ?>"><i class="fas fa-clock"></i><?php echo e(__('Book Appointment')); ?></a></li>
               <li><a href="<?php echo e(url('userappointmentdashboard')); ?>"><i class="fas fa-columns"></i><?php echo e(__('message.Appointment History')); ?></a></li>
               <li><a href="<?php echo e(url('userpurchaseproduct')); ?>"><i class="fas fa-columns"></i><?php echo e(__('message.My Purchase')); ?></a></li>
               <!--<li><a href="<?php echo e(url('favouriteuser')); ?>"><i class="fas fa-heart"></i><?php echo e(__('message.Favourite Doctors')); ?></a></li>-->
               <li><a href="<?php echo e(url('viewschedule')); ?>"><i class="fas fa-clock"></i><?php echo e(__('message.My Calendar')); ?></a></li>
               <li><a href="<?php echo e(url('userreview')); ?>" ><i class="fas fa-comments"></i><?php echo e(__('message.Review')); ?></a></li>
               <li><a href="<?php echo e(url('usereditprofile')); ?>" ><i class="fas fa-user"></i><?php echo e(__('message.My Profile')); ?></a></li>
               <li><a href="<?php echo e(url('changepassword')); ?>"><i class="fas fa-unlock-alt"></i><?php echo e(__('message.Change Password')); ?></a></li>
               <li><a href="<?php echo e(url('logout')); ?>"><i class="fas fa-sign-out-alt"></i><?php echo e(__('message.Logout')); ?></a></li>
            </ul>
         </div>
      </div>
   </div>
   <div class="right-panel">
      <div class="content-container">
         <div class="outer-container">
            <div class="add-listing change-password">
               <div class="single-box">
                  <div class="title-box">
                     <h3><?php echo e(__('message.Change Password')); ?></h3>
                  </div>
                  <div class="inner-box">
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
                     <div id="registererror"></div>
                     
               <form action="<?php echo e(url('updatedoctorpassword')); ?>" method="post" id="passwordChangeForm">
                <?php echo e(csrf_field()); ?>

                <div class="row clearfix">
                   <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                      <label><?php echo e(__('message.Enter Your Current Password')); ?></label>
                      <input type="password"  id="opwd" name="opwd" required="">
                      <span id="msg1" style="display: none;color: red;"><?php echo e(__("message.Current_Password_wrong")); ?></span>
                   </div>
                   <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                   </div>
                   <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                      <label><?php echo e(__('message.Enter Your New Password')); ?></label>
                      <input type="password" name="npwd" id="pwd" required="">
                      <span id="msg2" style="display: none;color: red;"><?php echo e(__("message.Current_Password_new_Password_same")); ?></span>
                   </div>
                   <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                   </div>
                   <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                      <label><?php echo e(__('message.Enter Confirm password')); ?></label>
                      <input type="password" name="conpwd"  id="cpwd" required="">
                      <span id="msg3" style="display: none;color: red;"><?php echo e(__("message.Confirm_Password_not_match")); ?></span>
                   </div>
                   <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                   </div>
                </div>
              </div>
                </div>
                <div class="btn-box">
                <button class="theme-btn-one" type="button" onclick="chengepswd()"><?php echo e(__('message.Save Change')); ?><i class="icon-Arrow-Right"></i></button>
                <a href="<?php echo e(url('changepassword')); ?>" class="cancel-btn"><?php echo e(__("message.Cancel")); ?></a>
                </div>
                </form>
            </div>
         </div>
      </div>
   </div>
   <input type="hidden" id="ccpp" value="<?php echo e($userdata->password); ?>">
</section>

<script>
    function chengepswd() {
    // Get the form fields
    $("#msg1").css("display","none");
    $("#msg2").css("display","none");
    $("#msg3").css("display","none");
    var oldcurrentPassword = document.getElementById('ccpp').value;
    var currentPassword = document.getElementById('opwd').value;
    var newPassword = document.getElementById('pwd').value;
    var confirmPassword = document.getElementById('cpwd').value;

    if (currentPassword === '' || newPassword === '' || confirmPassword === '') {
        alert('All fields are required.');
        return false;
    }else{

        if (oldcurrentPassword !== currentPassword) {
        $("#msg1").css("display","block");
        return false;
        }else{
         $("#msg1").css("display","none");
      }


      if (currentPassword == newPassword) {
        $("#msg2").css("display","block");
        return false;
        }else{
         $("#msg2").css("display","none");
      }


        if (newPassword !== confirmPassword) {
            $("#msg3").css("display","block");
            return false;
        }else{
         $("#msg3").css("display","none");
      }

        document.getElementById('passwordChangeForm').submit();
    }

}
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/user/patient/changepassword.blade.php ENDPATH**/ ?>