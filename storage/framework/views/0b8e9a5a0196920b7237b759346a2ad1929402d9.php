
<?php $__env->startSection('title'); ?>
<?php echo e(__('message.Appointment List')); ?>

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
            <h1><?php echo e(__('message.Appointment List')); ?></h1>
         </div>
      </div>
   </div>
   <div class="lower-content">
      <ul class="bread-crumb clearfix">
         <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('message.Home')); ?></a></li>
         <li><?php echo e(__('message.Appointment List')); ?></li>
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
               <li><a href="<?php echo e(url('doctordashboard')); ?>" ><i class="fas fa-columns"></i><?php echo e(__('message.Dashboard')); ?></a></li>
               <li><a href="<?php echo e(url('doctorappointment')); ?>" class="current"><i class="fas fa-calendar-alt"></i><?php echo e(__('message.Appointment')); ?></a></li>
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
                        <div class="appointment-list">
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
                            <div class="upper-box clearfix">
                                <div class="text pull-left">
                                    <h3><?php echo e(__('message.Appointment List')); ?></h3>
                                </div>
                                <div class="select-box pull-right">
                                    <select class="custom-dropdown" style="width: 100%;border: 1px solid #ada3a3;padding: 15px 30px;border-radius: 15px;">
                                       <option value=""><?php echo e(__("message.Any Status")); ?></option>
                                       <option value="1"><?php echo e(__("message.Received")); ?></option>
                                       <option value="3"><?php echo e(__("message.In Process")); ?></option>
                                       <option value="4"><?php echo e(__("message.Completed")); ?></option>
                                       <option value="5"><?php echo e(__("message.Absent")); ?></option>
                                       <option value="0"><?php echo e(__("message.Cancelled")); ?></option>
                                    </select>
                                </div>
                            </div>
                           <?php if(count($appointmentdata)>0): ?>
                              <?php $__currentLoopData = $appointmentdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $am): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <div class="single-item">
                                      <a href="<?php echo e(url('appointment_detail',$am->id)); ?>">
                                      <figure class="image-box">
                                        <?php if($am->patientls->profile_pic!=""): ?>
                                            <img src="<?php echo e(asset('public/upload/profile').'/'.$am->patientls->profile_pic); ?>" alt="">
                                        <?php else: ?>
                                             <img src="<?php echo e(asset('public/upload/profile/profile.png')); ?>" alt="">
                                        <?php endif; ?>
                                      </figure>
                                     
                                      <div class="inner">
                                          <h4><?php echo e($am->patientls->name); ?></h4>
                                          <ul class="info-list clearfix">
                                              <li><i class="fas fa-clock"></i><?php echo e(date("F d,Y",strtotime($am->date))); ?>, <?php echo e($am->slot_name); ?></li>
                                             
                
                                              <li><i class="fas fa-envelope"></i><a href="mailto:<?php echo e($am->patientls->email); ?>"><?php echo e($am->patientls->email); ?></a></li>
                                              <li><i class="fas fa-phone"></i><a href="tel:2265458856"><?php echo e($am->phone); ?></a></li>
                                              <li><i class="fas fa-sticky-note"></i>
                                                 <?php echo e($am->user_description); ?>

                                              </li>
                                               <?php if($am->prescription_file!=""): ?>
                                             <li><a href="<?php echo e(asset('public/upload/prescription').'/'.$am->prescription_file); ?>" target="_blank" class="btn btn-success" style="color:white"><?php echo e(__("message.View Prescription")); ?></a></li>
                                             <?php endif; ?>
                                               <li style="float: left;background: #453f85;color: white;padding: 7px 23px;border-radius: 15px;">
                                               <?php 
                                                      if($am->status=='1'){
                                                           echo __("message.Received");
                                                      }else if($am->status=='2'){
                                                           echo __("message.Approved");
                                                      }else if($am->status=='3'){
                                                           echo __("message.In Process");
                                                      }
                                                      else if($am->status=='4'){
                                                           echo __("message.Completed");
                                                      }
                                                      else if($am->status=='5'){
                                                           echo __("message.Rejected");
                                                      }else{
                                                           echo __("message.Absent");
                                                      }
                                               ?>
                                             </li>

                                          </ul>
                                          
                                          </a>
                                         
                                          <ul class="confirm-list clearfix">
                                            <?php if($am->status == '1'): ?>
                                                <li><a href="<?php echo e(url('changeappointment') . '/3/' . $am->id); ?>"><i
                                                            class="fas fa-check"></i><?php echo e(__('message.Accept')); ?></a></li>
                                                <li><a href="<?php echo e(url('changeappointment') . '/5/' . $am->id); ?>"><i
                                                            class="fas fa-times"></i><?php echo e(__('message.Cancel')); ?></a></li>
                                            <?php elseif($am->status == '3'): ?>
                                                <!-- href="<?php echo e(url('changeappointment') . '/4/' . $am->id); ?>" -->
                                                <li><a href="javascript:void(0)"
                                                        onclick="completeappointment('<?php echo e($am->id); ?>')"
                                                        data-toggle="modal" data-target="#myModal"><i
                                                            class="fas fa-check"></i><?php echo e(__('message.Complete')); ?></a></li>
                                                <li><a href="<?php echo e(url('changeappointment') . '/0/' . $am->id); ?>"><i
                                                            class="fas fa-times"></i><?php echo e(__('message.Absent')); ?></a></li>
                                            <?php endif; ?>
                                        </ul>
                                      </div>
                                  </div>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php endif; ?>
                        </div>
                        <?php echo e($appointmentdata->links()); ?>

            </div>
      </div>
   </div>
   
</section>
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><?php echo e(__("message.Add Prescription")); ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
        <form action="<?php echo e(route('complete-doctor-appointment')); ?>" method="post" enctype="multipart/form-data" class="registration-form">
                                         <?php echo e(csrf_field()); ?>

              <input type="hidden" name="id" id="appointment_id" />
              <div class="modal-body">
                   <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                        <label class="fr"><?php echo e(__('message.Upload Prescription')); ?></label>
                        <input type="file" name="prescription" id="prescription" required>
                    </div>
              </div>
        
              <!-- Modal footer -->
              <div class="modal-footer">
                 <button type="submit" class="btn btn-success"><?php echo e(__('message.Submit')); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
        </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rutik\live\bookappointment\resources\views/user/doctor/appointmentlist.blade.php ENDPATH**/ ?>