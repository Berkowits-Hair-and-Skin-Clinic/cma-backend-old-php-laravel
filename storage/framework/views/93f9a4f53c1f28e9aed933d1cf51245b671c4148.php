
<?php $__env->startSection('title'); ?>
<?php echo e(__('message.My Hoilday')); ?>

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
            <h1><?php echo e(__('message.My Hoilday')); ?></h1>
         </div>
      </div>
   </div>
   <div class="lower-content">
      <ul class="bread-crumb clearfix">
         <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('message.Home')); ?></a></li>
         <li><?php echo e(__('message.My Hoilday')); ?></li>
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
               <li><a href="<?php echo e(url('doctorappointment')); ?>" ><i class="fas fa-calendar-alt"></i><?php echo e(__('message.Appointment')); ?></a></li>
               <li><a href="<?php echo e(url('doctortiming')); ?>"><i class="fas fa-clock"></i><?php echo e(__('message.Schedule Timing')); ?></a></li>
               <li><a href="<?php echo e(url('doctorreview')); ?>" ><i class="fas fa-star"></i><?php echo e(__('message.Reviews')); ?></a></li>
               <li><a href="<?php echo e(url('doctor_hoilday')); ?>" class="current"><i class="fas fa-star"></i><?php echo e(__('message.My Hoilday')); ?></a></li>
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
            
            <div class="doctors-appointment">

               <div class="title-box">
                  <h3><?php echo e(__('message.My Hoilday List')); ?></h3> 
                   <div class="btn-box col-md-6 tdr"><a href="javascript::void(0)" class="theme-btn-one" data-toggle="modal" data-target="#addaddress"><i class="icon-image" ></i><?php echo e(__("message.Add Hoilday")); ?></a></div>                 
               </div>
               <div class="doctors-list">
                  <div class="table-outer">
                     <table class="doctors-table">
                        <thead class="table-header">
                           <tr>
                              <th style="text-align: center;"><?php echo e(__("message.Start Date")); ?></th>
                              <th style="text-align: center;"><?php echo e(__("message.End Date")); ?></th>
                              <th style="text-align: center;"><?php echo e(__("message.description")); ?></th>
                              <th style="text-align: center;"><?php echo e(__("message.action")); ?></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php if(count($doctorhoilday)>0): ?>
                              <?php $__currentLoopData = $doctorhoilday; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dh): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                       <td style="text-align: center;"><?php echo e($dh->start_date); ?></td>
                                       <td style="text-align: center;"><?php echo e($dh->end_date); ?></td>
                                       <td style="text-align: center;"><?php echo e($dh->description); ?></td>
                                       <?php $delete = url('deletedoctorhoilday',array('id'=>$dh->id));?>
                                        <td style="text-align: center;"><a onclick="delete_record('<?php echo e($delete); ?>')" rel="tooltip" title="" class="m-b-10 m-l-5" data-original-title="Remove"><i class="fa fa-trash f-s-25"></i></a></td>
                                    </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           <?php else: ?>
                           <tr>
                                       <td style="text-align: center;"></td>
                                       <td style="text-align: center;"> <p><?php echo e(__("message.No Hoilday Data")); ?></p></td>
                                       <td style="text-align: center;"></td>
                                       <td style="text-align: center;"></td>
                                    </tr>
                             
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
<div class="modal" id="addaddress">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <!-- Modal Header -->
         <div class="modal-header">
            <h4 class="modal-title"><?php echo e(__("message.Add My Hoilday")); ?></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Modal body -->
         <div class="modal-body">
            <form action="<?php echo e(route('post-my-hoilday')); ?>" method="post" id="user_address" class="registration-form">
               <?php echo e(csrf_field()); ?>

               <div class="row clearfix">
                 
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                     <label><?php echo e(__("message.Start Date")); ?></label>
                     <input type="text" name="start_date" class="dateclass" id="start_date" required="">
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                     <label><?php echo e(__("message.End Date")); ?></label>
                     <input type="text" name="end_date" id="end_date" class="dateclass" required="">
                  </div>
                  <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                     <label><?php echo e(__("message.description")); ?></label>
                     <textarea name="description" id="description" required></textarea>                     
                  </div>
               </div>
         </div>
         <!-- Modal footer -->
         <div class="modal-footer">
         <button type="submit" id="address_submit_button" class="btn btn-success"><?php echo e(__("message.Add Hoilday")); ?></button>
         <button type="button" class="btn btn-danger" data-dismiss="modal" ><?php echo e(__("message.Close")); ?></button>
         </div>
         </form>
      </div>
   </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\rutik\live\bookappointment\resources\views/user/doctor/doctor_hoilday.blade.php ENDPATH**/ ?>