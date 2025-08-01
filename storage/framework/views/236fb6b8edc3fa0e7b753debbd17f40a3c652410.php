
<?php $__env->startSection('title'); ?>
<?php echo e(__('message.Doctor Dashboard')); ?>

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
            <h1><?php echo e(__('message.Doctor Dashboard')); ?></h1>
         </div>
      </div>
   </div>
   <div class="lower-content">
      <ul class="bread-crumb clearfix">
         <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('message.Home')); ?></a></li>
         <li><?php echo e(__('message.Doctor Dashboard')); ?></li>
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
               <li><a href="<?php echo e(url('doctordashboard')); ?>" class="current"><i class="fas fa-columns"></i><?php echo e(__('message.Dashboard')); ?></a></li>
               <li><a href="<?php echo e(url('doctorappointment')); ?>" ><i class="fas fa-calendar-alt"></i><?php echo e(__('message.Appointment')); ?></a></li>
               <li><a href="<?php echo e(url('doctortiming')); ?>"><i class="fas fa-clock"></i><?php echo e(__('message.Schedule Timing')); ?></a></li>
               <li><a href="<?php echo e(url('doctorreview')); ?>" ><i class="fas fa-star"></i><?php echo e(__('message.Reviews')); ?></a></li>
               <li><a href="<?php echo e(url('doctor_hoilday')); ?>" ><i class="fas fa-star"></i><?php echo e(__('message.My Hoilday')); ?></a></li>
               <li><a href="<?php echo e(url('doctoreditprofile')); ?>"><i class="fas fa-user"></i><?php echo e(__('message.My Profile')); ?></a></li>
               <li><a href="<?php echo e(url('paymenthistory')); ?>"><i class="fas fa-user"></i><?php echo e(__('message.Payment History')); ?></a></li>
               <li><a href="<?php echo e(url('doctorchangepassword')); ?>"><i class="fas fa-unlock-alt"></i><?php echo e(__('message.Change Password')); ?></a></li>
               <li><a href="<?php echo e(url('logout')); ?>"><i class="fas fa-sign-out-alt"></i><?php echo e(__("message.Logout")); ?></a></li>
            </ul>
         </div>
      </div>
   </div>
   <div class="right-panel">
      <div class="content-container">
         <div class="outer-container">
            <div class="feature-content">
               <div class="row clearfix">
                  <div class="col-xl-4 col-lg-12 col-md-12 feature-block">
                     <div class="feature-block-two">
                        <div class="inner-box">
                           <div class="pattern">
                              <div class="pattern-1" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-79.png')); ?>');"></div>
                              <div class="pattern-2" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-80.png')); ?>');"></div>
                           </div>
                           <div class="icon-box"><i class="icon-Dashboard-1"></i></div>
                           <h3><?php echo e($totalappointment); ?></h3>
                           <h5><?php echo e(__('message.Total Appointment')); ?></h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-12 col-md-12 feature-block">
                     <div class="feature-block-two">
                        <div class="inner-box">
                           <div class="pattern">
                              <div class="pattern-1" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-81.png')); ?>');"></div>
                              <div class="pattern-2" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-82.png')); ?>');"></div>
                           </div>
                           <div class="icon-box"><i class="icon-Dashboard-5"></i></div>
                           <h3><?php echo e($totalreview); ?></h3>
                           <h5><?php echo e(__('message.Total Review')); ?></h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-12 col-md-12 feature-block">
                     <div class="feature-block-two">
                        <div class="inner-box">
                           <div class="pattern">
                              <div class="pattern-1" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-83.png')); ?>');"></div>
                              <div class="pattern-2" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-84.png')); ?>');"></div>
                           </div>
                           <div class="icon-box"><i class="icon-Dashboard-3"></i></div>
                           <h3><?php echo e($totalnewappointment); ?></h3>
                           <h5><?php echo e(__('message.New Appointments')); ?></h5>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="doctors-appointment">
               <div class="title-box">
                  <h3><?php echo e(__('message.Patients Appointments')); ?></h3>
                  <div class="btn-box">
                         <?php if($type==2): ?>
	                         <a href="<?php echo e(url('doctordashboard?type=2')); ?>" class="theme-btn-one"><?php echo e(__('message.past')); ?> <i class="icon-Arrow-Right"></i></a>
	                     <?php else: ?>
	                         <a href="<?php echo e(url('doctordashboard?type=2')); ?>" class="theme-btn-two"><?php echo e(__('message.past')); ?></a>
	                     <?php endif; ?>
	                     <?php if(!isset($type)): ?>
	                         <a href="<?php echo e(url('doctordashboard')); ?>" class="theme-btn-one"><?php echo e(__('message.Today')); ?> <i class="icon-Arrow-Right"></i></a>
	                     <?php else: ?>
	                         <a href="<?php echo e(url('doctordashboard')); ?>" class="theme-btn-two"><?php echo e(__('message.Today')); ?></a>
	                     <?php endif; ?>
	                     <?php if($type==3): ?>
	                          <a href="<?php echo e(url('doctordashboard?type=3')); ?>" class="theme-btn-one"><?php echo e(__('message.Upcoming')); ?> <i class="icon-Arrow-Right"></i></a>
	                     <?php else: ?>
	                          <a href="<?php echo e(url('doctordashboard?type=3')); ?>" class="theme-btn-two"><?php echo e(__('message.Upcoming')); ?></a>
	                     <?php endif; ?>
                  </div>
               </div>
               <div class="doctors-list">
                  <div class="table-outer">
                     <table class="doctors-table">
                        <thead class="table-header">
                           <tr>
                              <th><?php echo e(__("message.Patient Name")); ?></th>
                              <th><?php echo e(__("message.Date")); ?></th>
                              <th><?php echo e(__("message.Phone")); ?></th>
                              <th><?php echo e(__("message.Status")); ?></th>
                              
                           </tr>
                        </thead>
                        <tbody>
                          <?php if(count($bookdata)>0): ?>
                            <?php $__currentLoopData = $bookdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                           <tr>
		                              <td>
		                                 <div class="name-box">
		                                    <figure class="image">
		                                    	<?php if(isset($bo->patientls)&&$bo->patientls->profile_pic!=""): ?>
		                                    	<img src="<?php echo e(asset('public/upload/profile/').'/'.$bo->patientls->profile_pic); ?>" alt="">
		                                    	<?php else: ?>
		                                    	  <img src="<?php echo e(asset('public/upload/profile/profile.png')); ?>" alt="">
		                                    	<?php endif; ?>
		                                    	
		                                    </figure>
		                                    <h5><?php echo e($bo->patientls->name); ?></h5>
		                                   
		                                 </div>
		                              </td>
		                              <td>
		                                 <p><?php echo e(date("F d,Y",strtotime($bo->date))); ?></p>
		                                 <span class="time"><?php echo e($bo->slot_name); ?></span>
		                              </td>
		                              <td>
		                                 <p><?php echo e($bo->phone); ?></p>
		                              </td>
		                              <td>
		                                 <?php 
                                    if($bo->status=='1'){
                                         echo '<span class="status">'.__("message.Received").'</span>';
                                    }else if($bo->status=='2'){
                                         echo '<span class="status">'. __("message.Approved").'</span>';
                                    }else if($bo->status=='3'){
                                         echo '<span class="status">'. __("message.In Process").'</span>';
                                    }
                                    else if($bo->status=='4'){
                                         echo '<span class="status">'. __("message.Completed").'</span>';
                                    }
                                    else if($bo->status=='5'){
                                         echo '<span class="status">'. __("message.Rejected").'</span>';
                                    }else{
                                         echo '<span class="status">'. __("message.Absent").'</span>';
                                    }   
                                    ?>
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
<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/freakd1c/public_html/demo/bookappointment/resources/views/user/doctor/dashboard.blade.php ENDPATH**/ ?>