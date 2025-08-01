
<?php $__env->startSection('title'); ?>
<?php echo e(__('message.Schedule Timing')); ?>

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
            <h1><?php echo e(__('message.Schedule Timing')); ?></h1>
         </div>
      </div>
   </div>
   <div class="lower-content">
      <ul class="bread-crumb clearfix">
         <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('message.Home')); ?></a></li>
         <li><?php echo e(__('message.Schedule Timing')); ?></li>
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
               <li><a href="<?php echo e(url('doctortiming')); ?>" class="current"><i class="fas fa-clock"></i><?php echo e(__('message.Schedule Timing')); ?></a></li>
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
               <div class="upper-box clearfix">
                  <div class="text pull-left">
                     <h3><?php echo e(__('message.Schedule Timing')); ?></h3>
                  </div>
               </div>
            </div> 
            <div class="custom-all-timing-main-box">
               <form action="<?php echo e(url('updatedoctortiming')); ?>" method="post">
                   <?php echo e(csrf_field()); ?>  
              <input type="hidden" name="doctor_id" value="<?php echo e(Session::get('user_id')); ?>"/>
               <ul class="accordion-box">
                  <?php $arr=array(0=>__("message.Monday"),1=>__("message.Tuesday"),2=>__("message.Wednesday"),3=>__("message.Thursday"),4=>__("message.Friday"),5=>__("message.Saturday"),6=>__("message.Sunday"));?>
                        <?php for($i=0;$i<7;$i++): ?>
                            <li class="accordion block ">
                               <div class="acc-btn">
                                   <div class="icon-outer"></div>
                                   <h4><?php echo e($arr[$i]); ?></h4>
                               </div>
                               <div class="acc-content">
                                 <input type="hidden" name="arr[]" id="day_id_<?php echo e($i); ?>" value="<?php echo e($i); ?>">
                                   <div class="btn-box">
                                    <button type="button" onclick="addnewslot('<?php echo e($i); ?>')" class="theme-btn-one">
                                      <?php echo e(__("message.Add Time")); ?>

                                       <i class="far fa-plus"></i>
                                    </button>
                                 </div>
                                 <div id="day_<?php echo e($i); ?>">
                                    <?php $j=0;$temp=0;?>
                                     <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <?php if(isset($d)&&$d->day_id==$i): ?>
                                          <div class="timing-slot-main-box" id="slotdiv<?php echo e($i); ?><?php echo e($j); ?>">
                                             <div class="doctors-sidebar">
                                                <div class="form-widget">
                                                   <div class="form-inner">
                                                      <div class="appointment-time">

                                                     <!--   <div class="form-group">
                                                            <input type="text" name="time" placeholder="Start Time" autocomplete="off">
                                                            <i class="far fa-clock"></i>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="text" name="time" placeholder="End Time" autocomplete="off">
                                                            <i class="far fa-clock"></i>
                                                        </div>-->


                                                         <div class="form-group">
                                                            <input type="time" name="arr[<?php echo e($i); ?>][start_time][]" id="start_time_<?php echo e($i); ?>_0" placeholder='<?php echo e(__("message.Start Time")); ?>' value="<?php echo e(isset($d->start_time)?$d->start_time:''); ?>" onchange="checkduration('<?php echo e($i); ?>','<?php echo e($j); ?>')" >
                                                         </div>
                                                         <div class="form-group">
                                                            <input type="time" name="arr[<?php echo e($i); ?>][end_time][]" id="end_time_<?php echo e($i); ?>_0" placeholder='<?php echo e(__("message.End Time")); ?>'value="<?php echo e(isset($d->end_time)?$d->end_time:''); ?>" onchange="checkduration('<?php echo e($i); ?>','<?php echo e($j); ?>')">
                                                         </div> 


                                                         <div class="custom-dropdown" id="timerange" >
                                                            <select class="" name="arr[<?php echo e($i); ?>][duration][]" required="" id="duration_<?php echo e($i); ?>_<?php echo e($j); ?>" onchange="getslot(this.value,'<?php echo e($i); ?>','<?php echo e($j); ?>')">
                                                               <?php echo html_entity_decode($d->options);?>
                                                            </select>
                                                         </div>
                                                         <?php if($j!=0): ?>
                                                          <div class="custom-btn-box btn-box" style="margin-left: 15px;">
                                                            <a href="javascript:removescdehule('<?php echo e($i); ?>','<?php echo e($j); ?>')" class="theme-btn-one">
                                                               <?php echo e(__("message.delete")); ?>

                                                            </a>
                                                         </div>
                                                         <?php endif; ?>
                                                         <div class="slot-doctor-profile-main-box">
                                                            <ul id="slot_<?php echo e($i); ?>_<?php echo e($j); ?>">
                                                               <?php for($k=0;$k<count($d->getslotls);$k++){ ?>
                                                               <li>
                                                                  <label><?php echo e($d->getslotls[$k]->slot); ?></label>
                                                               </li>
                                                               <?php } ?>
                                                         </div>
                                                   </div>  
                                                </div>
                                             </div> 
                                             </div>  
                                          </div>
                                          <?php $j++;$temp=1;?>
                                       <?php endif; ?>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                       <?php if($temp==0): ?>
                                           <div class="timing-slot-main-box" id="slotdiv<?php echo e($i); ?>0">
                                             <div class="doctors-sidebar">
                                                <div class="form-widget">
                                                   <div class="form-inner">
                                                      <div class="appointment-time">
                                                         <div class="form-group">
                                                            <input type="time" id="start_time_<?php echo e($i); ?>_0"  placeholder='<?php echo e(__("message.Start Time")); ?>' name="arr[<?php echo e($i); ?>][start_time][0]"  onchange="checkduration('<?php echo e($i); ?>','0')">
                                                           
                                                         </div>
                                                         <div class="form-group">
                                                            <input type="time" id="end_time_<?php echo e($i); ?>_0" name="arr[<?php echo e($i); ?>][end_time][0]" onchange="checkduration('<?php echo e($i); ?>','0')" placeholder='<?php echo e(__("message.End Time")); ?>'>
                                                           
                                                         </div>  
                                                         <div class="custom-dropdown" id="timerange" >
                                                            <select class=""  name="arr[<?php echo e($i); ?>][duration][0]" id="duration_<?php echo e($i); ?>_0" onchange="getslot(this.value,'<?php echo e($i); ?>',0)" >
                                                               <option value=""><?php echo e(__("message.Select Duration")); ?></option>      
                                                            </select>
                                                         </div>

                                                         <div class="slot-doctor-profile-main-box">
                                                            <ul id="slot_<?php echo e($i); ?>_0">
                                                            
                                                            </ul>
                                                         </div>
                                                   </div>  
                                                </div>
                                             </div> 
                                             </div>  
                                          </div>
                                       <?php endif; ?>
                                 </div>
                               </div>
                               <input type="hidden" id="total_slot_day_<?php echo e($i); ?>" value="<?php echo e($j+1); ?>"> 
                           </li>
                        <?php endfor; ?>   

               </ul>
                <div class="btn-box" style="margin-top: 15px">
                   <button class="theme-btn-one" type="submit"><?php echo e(__("message.Submit")); ?><i class="icon-Arrow-Right"></i></button>
              
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/freakd1c/public_html/demo/bookappointment/resources/views/user/doctor/doctortiming.blade.php ENDPATH**/ ?>