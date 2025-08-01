<?php $__env->startSection('title'); ?>
<?php echo e(__('message.Edit Profile')); ?>

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
            <h1><?php echo e(__('message.Edit Profile')); ?></h1>
         </div>
      </div>
   </div>
   <div class="lower-content">
      <ul class="bread-crumb clearfix">
         <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('message.Home')); ?></a></li>
         <li><?php echo e(__('message.Edit Profile')); ?></li>
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
                <li><a href="<?php echo e(url('userdashboard')); ?>"><i class="fas fa-columns"></i><?php echo e(__('message.Dashboard')); ?></a></li>
                <li><a href="<?php echo e(url('usermedicineorder')); ?>"><i class="fas fa-columns"></i><?php echo e(__('message.Medicine Order')); ?></a></li>
               <li><a href="<?php echo e(url('favouriteuser')); ?>"><i class="fas fa-heart"></i><?php echo e(__('message.Favourite Doctors')); ?></a></li>
               <li><a href="<?php echo e(url('viewschedule')); ?>"><i class="fas fa-clock"></i><?php echo e(__('message.Schedule Timing')); ?></a></li>
               <li><a href="<?php echo e(url('userreview')); ?>" ><i class="fas fa-comments"></i><?php echo e(__('message.Review')); ?></a></li>
               <li><a href="<?php echo e(url('usereditprofile')); ?>" class="current"><i class="fas fa-user"></i><?php echo e(__('message.My Profile')); ?></a></li>
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
                     <h3><?php echo e(__('message.Edit Profile')); ?></h3>
                  </div>
                  <div class="inner-box">
                     <div class="profile-title">
                        <div class="upload-photo">
                        </div>
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
                     </div>
                     <form action="<?php echo e(url('updateuserprofile')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                        <div class="row clearfix">
                           <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                              <figure class="image-box" style="    margin-bottom: 15px;">
                                 <?php if(isset($userdata)&&$userdata->profile_pic!=""): ?>
                                 <img src="<?php echo e(asset('public/upload/profile/').'/'.$userdata->profile_pic); ?>" alt="">
                                 <?php else: ?>
                                 <img src="<?php echo e(asset('public/upload/profile/profile.png')); ?>" alt="">
                                 <?php endif; ?>
                              </figure>
                              <input type="file" name="image">
                           </div>
                           <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                              <label><?php echo e(__('message.Name')); ?></label>
                              <input type="text" name="name" placeholder="<?php echo e(__('message.Enter Your First Name')); ?>" required="" value="<?php echo e(isset($userdata->name)?$userdata->name:''); ?>">
                           </div>
                           <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                              <label><?php echo e(__('message.Phone no')); ?></label>
                              <input type="text" name="phone" placeholder="<?php echo e(__('message.Enter Phone')); ?>" value="<?php echo e(isset($userdata->phone)?$userdata->phone:''); ?>" required="">
                           </div>
                           <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                              <label><?php echo e(__('message.Email')); ?></label>
                              <input type="email" name="email" placeholder="<?php echo e(__('message.Enter Email Address')); ?>" required="" value="<?php echo e(isset($userdata->email)?$userdata->email:''); ?>">
                           </div>
                        </div>
                  </div>
               </div>
               <div class="btn-box">
               <button class="theme-btn-one" type="submit"><?php echo e(__('message.Save Change')); ?><i class="icon-Arrow-Right"></i></button>
               <a href="<?php echo e(url('changepassword')); ?>" class="cancel-btn"><?php echo e(__('message.Cancel')); ?></a>
               </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\rutik\live\bookappointment__medical\resources\views/user/patient/editprofile.blade.php ENDPATH**/ ?>