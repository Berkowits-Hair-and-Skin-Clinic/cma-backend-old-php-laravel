<?php $__env->startSection('title'); ?>
<?php echo e(__('Book Appointment')); ?>

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
               <li><a href="<?php echo e(url('searchdoctor')); ?>" ><i class="fas fa-clock"></i><?php echo e(__('Book Appointment')); ?></a></li>
               <li><a href="<?php echo e(url('userdashboard')); ?>"><i class="fas fa-columns"></i><?php echo e(__('message.Appointment History')); ?></a></li>
               <li><a href="<?php echo e(url('userpurchaseproduct')); ?>"><i class="fas fa-columns"></i><?php echo e(__('message.My Purchase')); ?></a></li>
               <!--<li><a href="<?php echo e(url('favouriteuser')); ?>"><i class="fas fa-heart"></i><?php echo e(__('message.Favourite Doctors')); ?></a></li>-->
               <li><a href="<?php echo e(url('viewschedule')); ?>"><i class="fas fa-clock"></i><?php echo e(__('message.My Calendar')); ?></a></li>
               <li><a href="<?php echo e(url('userreview')); ?>" ><i class="fas fa-comments"></i><?php echo e(__('message.Review')); ?></a></li>
               <li><a href="<?php echo e(url('usereditprofile')); ?>"class="current"><i class="fas fa-user"></i><?php echo e(__('message.My Profile')); ?></a></li>
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
                     <h3><?php echo e(__('Book Appointment')); ?></h3>
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
                     <form action="<?php echo e(env('APP_URL')); ?>viewdoctor/<?php echo e($doctorDetails->id); ?>" method="get" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                        <div class="row clearfix">
                           <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                           <div class="form-group">
                              <div class="select-box">
                                    <select name="service"  class="form-control">
                                        <option value=""><?php echo e(__('Select Service')); ?></option>
                                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <option value="<?php echo e($service['name']); ?>"><?php echo e($service['name']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                           </div>
                           </div>
                           <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                           <div class="form-group">
                              <div class="select-box">
                                    <select name="specialist" class="form-control">
                                        <option value=""><?php echo e(__('Select Specialist')); ?></option>
                                        <?php $__currentLoopData = $specilaist['employees']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <option value="<?php echo e($employee['personal_info']['name']); ?>"><?php echo e($employee['personal_info']['name']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                           </div>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="btn-box">
               <button class="theme-btn-one" type="submit"><?php echo e(__('Next')); ?><i class="icon-Arrow-Right"></i></button>
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

<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/user/patient/bookstep2.blade.php ENDPATH**/ ?>