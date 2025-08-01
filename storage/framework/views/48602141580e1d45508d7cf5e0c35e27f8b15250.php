<?php $__env->startSection('title'); ?>
<?php echo e(__('Video Consultation List')); ?>

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
   <!--<div class="title-box centred bg-color-2">
      <div class="pattern-layer">
         <div class="pattern-1" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-70.png')); ?>');"></div>
         <div class="pattern-2" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-71.png')); ?>');"></div>
      </div>
      <div class="auto-container">
         <div class="title">
            <h1><?php echo e(__('message.Doctor Dashboard')); ?></h1>
         </div>
      </div>
   </div>-->
   <div class="lower-content">
      <ul class="bread-crumb clearfix">
         <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('message.Home')); ?></a></li>
         <li><?php echo e(__('Video Consultation List')); ?></li>
      </ul>
   </div>
</section>
<section class="doctors-dashboard bg-color-3">
   <div class="left-panel">
      <div class="profile-box">
         <div class="upper-box">
            <figure class="profile-image">
               <?php if($doctordata->image!=""): ?>
               <img src="<?php echo e(asset('public/upload/doctors').'/'.$doctordata->image); ?>" alt="">
               <?php else: ?>
               <img src="<?php echo e(asset('public/front_pro/assets/images/resource/profile-2.png')); ?>" alt="">
               <?php endif; ?>
            </figure>
            <div class="title-box centred">
               <div class="inner">
                  <h3><?php echo e($doctordata->name); ?></h3>
                  <p><?php echo e(isset($doctordata->departmentls)?$doctordata->departmentls->name:""); ?></p>
               </div>
            </div>
         </div>
         <div class="profile-info">
         <ul class="list clearfix">
               <li><a href="<?php echo e(url('doctordashboard')); ?>"><i class="fas fa-columns"></i><?php echo e(__('message.Dashboard')); ?></a></li>
               <li><a href="<?php echo e(url('videoconsultationlist')); ?>" class="current"><i class="fas fa-calendar-alt"></i><?php echo e(__('Video Consultation')); ?></a></li>
               <li><a href="<?php echo e(url('doctorappointment')); ?>" ><i class="fas fa-calendar-alt"></i><?php echo e(__('message.Appointment')); ?></a></li>
               <li><a href="<?php echo e(url('center_employees')); ?>" ><i class="fas fa-calendar-alt"></i><?php echo e(__('Employees')); ?></a></li>
               <li><a href="<?php echo e(url('doctorreview')); ?>" ><i class="fas fa-star"></i><?php echo e(__('message.Reviews')); ?></a></li>
               <li><a href="<?php echo e(url('doctoreditprofile')); ?>"><i class="fas fa-user"></i><?php echo e(__('message.My Profile')); ?></a></li>
               <li><a href="<?php echo e(url('doctorchangepassword')); ?>"><i class="fas fa-unlock-alt"></i><?php echo e(__('message.Change Password')); ?></a></li>
               <li><a href="<?php echo e(url('logout')); ?>"><i class="fas fa-sign-out-alt"></i><?php echo e(__("message.Logout")); ?></a></li>
               <!--<li><a href="<?php echo e(url('doctortiming')); ?>"><i class="fas fa-clock"></i><?php echo e(__('message.Schedule Timing')); ?></a></li>
               <li><a href="<?php echo e(url('doctor_hoilday')); ?>" ><i class="fas fa-star"></i><?php echo e(__('message.My Hoilday')); ?></a></li>
               <li><a href="<?php echo e(url('doctorsubscription')); ?>"><i class="fas fa-rocket"></i><?php echo e(__('message.My Subscription')); ?></a></li>
               <li><a href="<?php echo e(url('paymenthistory')); ?>"><i class="fas fa-user"></i><?php echo e(__('message.Payment History')); ?></a></li>-->
            </ul>
         </div>
      </div>
   </div>
   <div class="right-panel">
      <div class="content-container">
         <div class="outer-container">
            <div class="feature-content">
            </div>
            <div class="feature-content">
            </div>
            <div class="doctors-appointment">
               <div class="title-box">
                  <h3><?php echo e(__('Video Consultation')); ?></h3>
                  <div class="btn-box">
                        <?php 
                           if(!empty($type)){
                              switch($type){
                                 case '1':
                                    ?>
                                       <a href="<?php echo e(url('videoconsultationlist?type=1')); ?>" class="theme-btn-one"><?php echo e(__('message.Today')); ?></a>
                                       <a href="<?php echo e(url('videoconsultationlist?type=3')); ?>" class="theme-btn-two"><?php echo e(__('message.Upcoming')); ?></a>
                                       <a href="<?php echo e(url('videoconsultationlist?type=4')); ?>" class="theme-btn-two"><?php echo e(__('Completed')); ?></a>
                                       <a href="<?php echo e(url('videoconsultationlist?type=5')); ?>" class="theme-btn-two"><?php echo e(__('Absent')); ?></a>
                                    <?php
                                 break;
                                 case '3':
                                    ?>
                                        <a href="<?php echo e(url('videoconsultationlist?type=1')); ?>" class="theme-btn-two"><?php echo e(__('message.Today')); ?></a>
                                       <a href="<?php echo e(url('videoconsultationlist?type=3')); ?>" class="theme-btn-one"><?php echo e(__('message.Upcoming')); ?></a>
                                       <a href="<?php echo e(url('videoconsultationlist?type=4')); ?>" class="theme-btn-two"><?php echo e(__('Completed')); ?></a>
                                       <a href="<?php echo e(url('videoconsultationlist?type=5')); ?>" class="theme-btn-two"><?php echo e(__('Absent')); ?></a>
                                    <?php
                                 break;
                                 case '4':
                                    ?>
                                     <a href="<?php echo e(url('videoconsultationlist?type=1')); ?>" class="theme-btn-two"><?php echo e(__('message.Today')); ?></a>
                                    <a href="<?php echo e(url('videoconsultationlist?type=3')); ?>" class="theme-btn-two"><?php echo e(__('message.Upcoming')); ?></a>
                                    <a href="<?php echo e(url('videoconsultationlist?type=4')); ?>" class="theme-btn-one"><?php echo e(__('Completed')); ?></a>
                                    <a href="<?php echo e(url('videoconsultationlist?type=5')); ?>" class="theme-btn-two"><?php echo e(__('Absent')); ?></a>
                                 <?php
                                    
                                 break;
                                 case '5':
                                    ?>
                                     <a href="<?php echo e(url('videoconsultationlist?type=1')); ?>" class="theme-btn-two"><?php echo e(__('message.Today')); ?></a>
                                    <a href="<?php echo e(url('videoconsultationlist?type=3')); ?>" class="theme-btn-two"><?php echo e(__('message.Upcoming')); ?></a>
                                    <a href="<?php echo e(url('videoconsultationlist?type=4')); ?>" class="theme-btn-two"><?php echo e(__('Completed')); ?></a>
                                    <a href="<?php echo e(url('videoconsultationlist?type=5')); ?>" class="theme-btn-one"><?php echo e(__('Absent')); ?></a>
                                 <?php
                                    break;
                              }

                           }else{
                              ?>
                               <a href="<?php echo e(url('videoconsultationlist?type=1')); ?>" class="theme-btn-one"><?php echo e(__('message.Today')); ?></a>
                              <a href="<?php echo e(url('videoconsultationlist?type=3')); ?>" class="theme-btn-two"><?php echo e(__('message.Upcoming')); ?></a>
                              <a href="<?php echo e(url('videoconsultationlist?type=4')); ?>" class="theme-btn-two"><?php echo e(__('Completed')); ?></a>
                              <a href="<?php echo e(url('videoconsultationlist?type=5')); ?>" class="theme-btn-two"><?php echo e(__('Absent')); ?></a>
                           <?php

                           }

                        ?>
                        
                  </div>
               </div>
               <div class="doctors-list">
                  <div class="table-outer">
                     <table class="doctors-table">
                        <thead class="table-header">
                           <tr>
                              <th><?php echo e(__("message.Patient Name")); ?></th>
                              <th><?php echo e(__("Consultation Date")); ?></th>
                             <!-- <th><?php echo e(__("message.Phone")); ?></th>-->
                              <th><?php echo e(__('message.ServiceName')); ?></th>
                              <th><?php echo e(__('Doctor')); ?></th>
                              <th><?php echo e(__("message.Status")); ?></th>
                              <th><?php echo e(__("Details")); ?></th>

                           </tr>
                        </thead>
                        <tbody>
                          <?php if(count($bookdata)>0): ?>
                            <?php $__currentLoopData = $bookdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                           <tr>
		                              <td>
                                    <label style="margin-left: 10px;"><b><i style="margin-right: 10px;" class="fas fa-user"></i></b> <?php echo e($bo->firstname); ?> <?php echo e($bo->lastname); ?></label>
		                              </td>
		                              <td>
		                                 <label><?php echo e(date("F d,Y",strtotime($bo->preferred_date))); ?></label>
		                                 <span class="time" style="width: 100%;"><?php echo e($bo->time_slot); ?></span>
		                              </td>
		                              <!--<td>
		                                 <p><?php echo e($bo->phone); ?></p>
		                              </td>-->
                                    <td><?php echo e($bo->concern); ?></td>
                                    <?php 
                                       $doctor_details=json_decode($bo->doctor_details,true);
                                    ?>
                                    <td><?php echo e($doctor_details['name']); ?></td>
		                              <td>
                                    <?php echo e($bo->status); ?>

		                              </td>
                                    <td>
                                    <a href="<?php echo e(url('videoconsultation_detail',$bo->encryption_id)); ?>" class="theme-btn-two"><?php echo e(__('Detail')); ?></a>
		                              </td>

		                           </tr>
                              
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php else: ?>
                             <tr><td colspan="5" style="text-align: center;    padding: 18px;"><?php echo e(__("message.No Data Found")); ?></td></tr>
                           <?php endif; ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/user/doctor/video_consultation_list.blade.php ENDPATH**/ ?>