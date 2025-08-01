<?php $__env->startSection('title'); ?>
<?php echo e(__('Client Dashboard')); ?>

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
<!--<section class="page-title-two">
   <div class="title-box centred bg-color-2">
      <div class="pattern-layer">
         <div class="pattern-1" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-70.png')); ?>');"></div>
         <div class="pattern-2" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-71.png')); ?>');"></div>
      </div>
      <div class="auto-container">
         <div class="title">
            <h1><?php echo e(__('Zenoti Appointment')); ?></h1>
         </div>
      </div>
   </div>
</section>-->

<section class="patient-dashboard bg-color-3">
   <div class="left-panel">
      <div class="profile-box patient-profile">
         <div class="upper-box">
            <figure class="profile-image">
               <?php if(isset($userdata)&&$userdata->profile_pic!=""): ?>
               <img src="<?php echo e(asset('public/upload/profile').'/'.$userdata->profile_pic); ?>" alt="">
               <?php else: ?>
               <img src="<?php echo e(asset('public/upload/profile/profile.png')); ?>" alt="">
               <?php endif; ?>
            </figure>
            <div class="title-box centred">
               <div class="inner">
                  <h3><?php echo e(isset($userdata->name)?$userdata->name:""); ?></h3>
                  <p><i class="fas fa-envelope"></i><?php echo e(isset($userdata->email)?$userdata->email:""); ?></p>
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
            <div class="feature-content">
               <div class="row clearfix">
                  <div class="col-xl-4 col-lg-12 col-md-12 feature-block">
                     <div class="feature-block-two">
                        <div class="inner-box">
                           <div class="pattern">
                              <div class="pattern-1" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-79.png')); ?>');"></div>
                              <div class="pattern-2" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-80.png')); ?>');"></div>
                           </div>
                           <div class="icon-box"><i class="icon-Dashboard-3"></i></div>
                           <h3><?php echo e($totalappointment); ?></h3>
                           <h5><?php echo e(__('message.Total')); ?></h5>
                           <h5><?php echo e(__("message.Appointment")); ?></h5>
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
                           <div class="icon-box"><i class="icon-Dashboard-email-4"></i></div>
                           <h3><?php echo e($completeappointment); ?></h3>
                           <h5><?php echo e(__('message.Completed')); ?></h5>
                           <h5><?php echo e(__("message.Appointment")); ?></h5>
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
                           <div class="icon-box"><i class="icon-Dashboard-5"></i></div>
                           <h3><?php echo e($pendingappointment); ?></h3>
                           <h5><?php echo e(__("message.Pending")); ?></h5>
                           <h5><?php echo e(__("message.Appointment")); ?></h5>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="doctors-appointment">
            <a style="height: 60px;float:right;color:black"  href="<?php echo e(url('searchcenterall')); ?>" class="theme-btn-one"><i style="font-size: 20px;margin-right:10px;color:black;" class="icon-Dashboard-3"></i> <?php echo e(__('Book New Appointment')); ?></a><br />
               <div class="title-box">
                  <h3><?php echo e(__("Appointment")); ?></h3>
                  <div class="btn-box">
                     <?php if($type==2): ?>
                     <a href="<?php echo e(url('userappointmentdashboard?type=2')); ?>" class="theme-btn-one"><?php echo e(__('message.past')); ?> <i class="icon-Arrow-Right"></i></a>
                     <?php else: ?>
                     <a href="<?php echo e(url('userappointmentdashboard?type=2')); ?>" class="theme-btn-two"><?php echo e(__('message.past')); ?></a>
                     <?php endif; ?>
                     <?php if(!isset($type)): ?>
                     <a href="<?php echo e(url('userappointmentdashboard?type=3')); ?>" class="theme-btn-one"><?php echo e(__('message.Upcoming')); ?> <i class="icon-Arrow-Right"></i></a>
                     <?php else: ?>
                     <a href="<?php echo e(url('userappointmentdashboard?type=3')); ?>" class="theme-btn-two"><?php echo e(__('message.Upcoming')); ?></a>
                     <?php endif; ?>
                     <?php if($type==1): ?>
                     <a href="<?php echo e(url('userappointmentdashboard?type=1')); ?>" class="theme-btn-one"><?php echo e(__('message.Today')); ?> <i class="icon-Arrow-Right"></i></a>
                     <?php else: ?>
                     <a href="<?php echo e(url('userappointmentdashboard?type=1')); ?>" class="theme-btn-two"><?php echo e(__('message.Today')); ?></a>

                     <?php endif; ?>
                  </div>
               </div>       
               <div class="doctors-list">
                  <div class="table-outer">
                     <table class="doctors-table">
                        <thead class="table-header">
                           <tr>
                              <th><?php echo e(__('message.Service Point')); ?></th>
                              <th><?php echo e(__('message.ServiceName')); ?></th>
                              <th><?php echo e(__('Price')); ?></th>
                              <th><?php echo e(__('message.Date')); ?></th>
                              
                              
                              <th><?php echo e(__('message.Status')); ?></th>

                           </tr>
                        </thead>
                        <tbody>
                           <?php $__currentLoopData = $bookdata['appointments']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php $appointment_group_id=$appointment['appointment_group_id']; ?>
                           <?php $__currentLoopData = $appointment['appointment_services']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                           <?php $appointment_id=$service['appointment_id']; ?>
                           <tr>
                              <td data-toggle="modal" data-target="#queryModalgrid">
                                 <div class="name-box">
                                    <?php 
                                       //use Illuminate\Support\Facades\DB;
                                       $centerName = Illuminate\Support\Facades\DB::table('doctors')->select('name')->where('center_id', '=', $appointment['center_id'])->where('record_type', '=', 'center')->get();
                                       //var_dump($centerName);
                                    ?>
                                    <label><?php echo e($centerName); ?></label>
                                 </div>
                              </td>
                              <td>
                                 <p><?php echo e($service['service']['name']); ?></p>
                              </td>
                              <td><p><?php echo e($service['service']['price']['sales']); ?></p></td>
                              <td>
                                 <p><?php echo e($service['start_time']); ?></p><br />
                                 <p><?php echo e($service['end_time']); ?></p>
                              </td>
                              <td>
                              <?php
                                    if($service['appointment_status'] ==0){
                                         echo '<span class="status">'.__("New").'</span>';
                                    }else if($service['appointment_status'] ==1){
                                         echo '<span class="status">'. __("closed").'</span>';
                                    }else if($service['appointment_status'] ==2){
                                         echo '<span class="status">'. __("Checkin").'</span>';
                                    }
                                    else if($service['appointment_status'] ==4){
                                         echo '<span class="status">'. __("Confirmed").'</span>';
                                    }
                                    else if($service['appointment_status'] ==-2){
                                         echo '<span class="status">'. __("No Show").'</span>';
                                    }else{
                                         echo '<span class="status">'. __("message.Absent").'</span>';
                                    }
                                    ?>
                                 <br /><div class="title-box">
                                          <div class="btn-box">
                                             <a class="theme-btn-one" href="<?php echo e(url('appointmentdetails') . '/' . $appointment_id); ?>">Detail</a>
                                          </div>
                                       </div>
                              </td>

                           </tr>
                           
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                     </table>
                     
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<input type="hidden" id="path_admin" value="<?php echo e(url('/')); ?>">



</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/user/patient/appointmentdashboard.blade.php ENDPATH**/ ?>