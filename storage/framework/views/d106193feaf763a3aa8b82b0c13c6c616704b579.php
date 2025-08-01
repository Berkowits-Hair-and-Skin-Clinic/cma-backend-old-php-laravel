<?php $__env->startSection('title'); ?>
<?php echo e(__('message.Doctor Details')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-data'); ?>
<meta property="og:type" content="website"/>
<meta property="og:url" content="<?php echo e($data->name); ?>"/>
<meta property="og:title" content="<?php echo e($data->name); ?>"/>
<meta property="og:image" content="<?php echo e(asset('public/upload/doctors').'/'.$data->image); ?>"/>
<meta property="og:image:width" content="250px"/>
<meta property="og:image:height" content="250px"/>
<meta property="og:site_name" content="<?php echo e($data->name); ?>"/>
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
            <h1><?php echo e(__('message.Doctor Details')); ?></h1>
         </div>
      </div>
   </div>
   <div class="lower-content">
      <div class="auto-container">
         <ul class="bread-crumb clearfix">
            <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('message.Home')); ?></a></li>
            <li><?php echo e(__('message.Doctor Details')); ?></li>
         </ul>
      </div>
   </div>
</section>-->
<?php if(empty($data)): ?>
<?php echo e(__('message.Result Not Found')); ?>

<?php else: ?>
<section class="doctor-details bg-color-3">
   <div class="auto-container">
      <div class="row clearfix">
         <div class="col-lg-6 col-md-6 col-sm-12 content-side">
             <div id="favmsg"></div>
            <div class="clinic-details-content doctor-details-content">
               <div class="clinic-block-one">
                  <div class="inner-box">
                     <figure class="image-box">
                        <?php
                           if($data->image==""){
                               $path=asset('public/upload/doctors/default.png');
                           }else{
                               $path=asset('public/upload/doctors').'/'.$data->image;
                           }
                           ?>
                        <div class="doctor-detail-page-main-box" style="background-image:url('<?php echo e($path); ?>'); background-size: 311px 220px;" ></div>
                     </figure>
                     <div class="content-box">
                        <div class="like-box">
                           <?php if($data->is_fav=='0'): ?>
                        <?php if(empty(Session::has("user_id"))): ?>
                        <a href="<?php echo e(url('patientlogin')); ?>" id="favdoc<?php echo e($data->id); ?>">
                        <?php else: ?>
                        <a href="javascript:userfavorite('<?php echo e($data->id); ?>')" id="favdoc<?php echo e($data->id); ?>">
                        <?php endif; ?>
                        <?php else: ?>
                        <a href="javascript:userfavorite('<?php echo e($data->id); ?>')" class="activefav" id="favdoc<?php echo e($data->id); ?>">
                        <?php endif; ?>
                           <i class="far fa-heart"></i>
                           </a>
                        </div>
                        <div class="middle body">
                           <div class="sm-container">
                              <i class="show-btn fas fa-share-alt"></i>
                              <div class="sm-menu">
                                 <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(url('viewdoctor').'/'.$data->id); ?>"><i class="fab fa-facebook-f"></i></a>
                                 <a href="https://web.whatsapp.com/send?url=<?php echo e(url('viewdoctor').'/'.$data->id); ?>"><i class="fab fa-whatsapp"></i></a>
                                 <a href="https://twitter.com/intent/tweet?text=<?php echo e($data->name); ?>&url=<?php echo e(url('viewdoctor').'/'.$data->id); ?>"><i class="fab fa-twitter"></i></a>
                              </div>
                           </div>
                        </div>
                        <ul class="name-box clearfix">
                           <li class="name">
                              <h2><?php echo e($data->name); ?></h2>
                           </li>
                        </ul>
                        <span class="designation"><?php echo e(isset($data->departmentls->name)?$data->departmentls->name:''); ?></span>
                        <div class="rating-box clearfix">
                           <ul class="rating clearfix">
                              <?php
                                 $arr = $data->avgratting;
                                 if (!empty($arr)) {
                                   $i = 0;
                                   if (isset($arr)) {
                                       for ($i = 0; $i < $arr; $i++) {
                                           echo '<li><i class="icon-Star"></i></li>';
                                       }
                                   }
                                       $remaing = 5 - $i;
                                       for ($j = 0; $j < $remaing; $j++) {
                                           echo '<li class="light" style="color:gray !important"><i class="icon-Star"></i></li>';
                                       }
                                 }else{
                                    for ($j = 0; $j <5; $j++) {
                                           echo '<li class="light" style="color:gray !important"><i class="icon-Star"></i></li>';
                                       }
                                 }?>
                              <li><a href="#">(<?php echo e($data->totalreview); ?>)</a></li>
                           </ul>
                        </div>
                        <div class="text">
                           <p><?php echo e(substr($data->aboutus,0,75)); ?></p>
                        </div>
                        <div class="lower-box clearfix">
                           <ul class="info clearfix">
                              <li><i class="fas fa-map-marker-alt"></i><?php echo e(substr($data->address,0,40)); ?></li>
                              <li><i class="fas fa-phone"></i><a href="<?php echo e($data->phoneno); ?>"><?php echo e($data->phoneno); ?></a></li>
                           </ul>
                           <div class="view-map"><a href="https://maps.google.com/?q=<?php echo e($data->lat); ?>,<?php echo e($data->lon); ?>" target="_blank"><?php echo e(__('message.View Map')); ?></a></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="tabs-box">
                  <div class="tab-btn-box centred">
                     <ul class="tab-btns tab-buttons clearfix">
                        <li class="tab-btn active-btn" data-tab="#tab-1"><?php echo e(__('message.About Us')); ?></li>
                        <li class="tab-btn" data-tab="#tab-2"><?php echo e(__('message.Services')); ?></li>
                        <li class="tab-btn" data-tab="#tab-3"><?php echo e(__('message.Health Care')); ?></li>
                        <li class="tab-btn" data-tab="#tab-4"><?php echo e(__('message.Review')); ?></li>
                     </ul>
                  </div>
                  <div class="tabs-content">
                     <div class="tab active-tab" id="tab-1">
                        <div class="inner-box">
                           <div class="text">
                              <h3><?php echo e(__('message.About')); ?> <?php echo e($data->name); ?>:</h3>
                              <p><?php echo e($data->aboutus); ?></p>
                           </div>
                        </div>
                     </div>
                     <div class="tab" id="tab-2">
                        <div class="experience-box">
                           <div class="text">
                              <h3><?php echo e(__('message.Services')); ?></h3>
                              <p><?php echo e($data->services); ?></p>
                           </div>
                        </div>
                     </div>
                     <div class="tab" id="tab-3">
                        <div class="location-box">
                           <h3><?php echo e(__('message.Health Care')); ?></h3>
                           <?php echo e($data->healthcare); ?>

                        </div>
                     </div>
                     <div class="tab" id="tab-4">
                        <div class="review-box">
                           <h3><?php echo e($data->name); ?> <?php echo e(__('message.Review')); ?></h3>
                           <div class="rating-inner">
                              <div class="rating-box">
                                 <h2><?php echo e(isset($data->avgratting)?number_format($data->avgratting,2):0); ?></h2>
                                 <ul class="clearfix">
                                    <?php
                                       $arr = $data->avgratting;
                                       if (!empty($arr)) {
                                         $i = 0;
                                         if (isset($arr)) {
                                             for ($i = 0; $i < $arr; $i++) {
                                                 echo '<li><i class="icon-Star"></i></li>';
                                             }
                                         }
                                             $remaing = 5 - $i;
                                             for ($j = 0; $j < $remaing; $j++) {
                                                 echo '<li class="light" style="color:gray !important"><i class="icon-Star"></i></li>';
                                             }
                                       }else{
                                          for ($j = 0; $j <5; $j++) {
                                                 echo '<li class="light" style="color:gray !important"><i class="icon-Star"></i></li>';
                                             }
                                       }?>
                                 </ul>
                                 <span><?php echo e(__('message.Based on 5 review')); ?></span>
                              </div>
                              <div class="rating-pregress">
                                 <div class="single-progress">
                                    <?php $star5=  isset($data->startrattinglines['start5'])?$data->startrattinglines['start5']:"0";
                                       $star4=  isset($data->startrattinglines['start4'])?$data->startrattinglines['start4']:"0";
                                       $star3=  isset($data->startrattinglines['start3'])?$data->startrattinglines['start3']:"0";
                                       $star2=  isset($data->startrattinglines['start2'])?$data->startrattinglines['start2']:"0";
                                       $star1=  isset($data->startrattinglines['start1'])?$data->startrattinglines['start1']:"0";
                                       ?>
                                    <style type="text/css">
                                       .doctor-details-content .tabs-box .tabs-content .review-box .rating-inner .rating-pregress .single-progress:first-child .porgress-bar:before {
                                       width: <?php echo e($star5); ?>%;
                                       }
                                       .doctor-details-content .tabs-box .tabs-content .review-box .rating-inner .rating-pregress .single-progress:nth-child(2) .porgress-bar:before {
                                       width: <?php echo e($star4); ?>%;
                                       }
                                       .doctor-details-content .tabs-box .tabs-content .review-box .rating-inner .rating-pregress .single-progress:nth-child(3) .porgress-bar:before {
                                       width: <?php echo e($star3); ?>%;
                                       }
                                       .doctor-details-content .tabs-box .tabs-content .review-box .rating-inner .rating-pregress .single-progress:nth-child(4) .porgress-bar:before {
                                       width: <?php echo e($star2); ?>%;
                                       }
                                       .doctor-details-content .tabs-box .tabs-content .review-box .rating-inner .rating-pregress .single-progress:nth-child(5) .porgress-bar:before {
                                       width: <?php echo e($star1); ?>%;
                                       }
                                    </style>
                                    <span class="porgress-bar"></span>
                                    <div class="text">
                                       <p><i class="icon-Star"></i> <?php echo e(__('message.5 Stars')); ?></p>
                                    </div>
                                 </div>
                                 <div class="single-progress">
                                    <span class="porgress-bar"></span>
                                    <div class="text">
                                       <p><i class="icon-Star"></i><?php echo e(__('message.4 Stars')); ?></p>
                                    </div>
                                 </div>
                                 <div class="single-progress">
                                    <span class="porgress-bar"></span>
                                    <div class="text">
                                       <p><i class="icon-Star"></i><?php echo e(__('message.3 Stars')); ?></p>
                                    </div>
                                 </div>
                                 <div class="single-progress">
                                    <span class="porgress-bar"></span>
                                    <div class="text">
                                       <p><i class="icon-Star"></i><?php echo e(__('message.2 Stars')); ?></p>
                                    </div>
                                 </div>
                                 <div class="single-progress">
                                    <span class="porgress-bar"></span>
                                    <div class="text">
                                       <p><i class="icon-Star"></i><?php echo e(__('message.1 Stars')); ?></p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="review-inner">
                              <?php $__currentLoopData = $data->reviewslist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <div class="single-review-box">
                                 <figure class="image-box">
                                    <img src="<?php echo e(isset($dr->patientls->profile_pic) ? asset('public/upload/profile/' . $dr->patientls->profile_pic) : asset('public/upload/profile/profile.png')); ?>" alt="">
                                </figure>
                                 <ul class="rating clearfix">
                                    <?php
                                       $arr = $dr->rating;
                                       if (!empty($arr)) {
                                         $i = 0;
                                         if (isset($arr)) {
                                             for ($i = 0; $i < $arr; $i++) {
                                                 echo '<li><i class="icon-Star"></i></li>';
                                             }
                                         }
                                             $remaing = 5 - $i;
                                             for ($j = 0; $j < $remaing; $j++) {
                                                 echo '<li class="light"><i class="icon-Star"></i></li>';
                                             }
                                       }else{
                                          for ($j = 0; $j <5; $j++) {
                                                 echo '<li class="light"><i class="icon-Star"></i></li>';
                                             }
                                       }?>
                                 </ul>
                                 <!-- <h6><span>- -->
                                 <h6><span>
                                    <?php
                                       ?><?php echo e(date("F d, Y",strtotime($dr->created_at))); ?></span>
                                 </h6>
                                 <p><?php echo e($dr->patientls->name); ?></p>
                                 <p><?php echo e($dr->description); ?></p>
                              </div>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </div>
                           <div class="btn-box">
                              <form action="<?php echo e(url('savereview')); ?>" method="post">
                                 <?php echo e(csrf_field()); ?>

                                 <input type="hidden" name="doctor_id" value="<?php echo e($data->id); ?>">
                                 <input type="hidden" name="user_id" value="<?php echo e(Session::get('user_id')); ?>">
                                <div class="row clearfix">
                                 <div class="col">
                                    <h3><?php echo e(__('message.Add')); ?> <?php echo e(__('message.Review')); ?></h3>
                                 </div>
                                  <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <style type="text/css">
                                               .rating-group {
                                                 display: inline-flex;
                                               }
                                               /* make hover effect work properly in IE */
                                               .rating__icon {
                                                 pointer-events: none;
                                               }
                                               /* hide radio inputs */
                                               .rating__input {
                                                 position: absolute !important;
                                                 left: -9999px !important;
                                               }
                                               /* hide 'none' input from screenreaders */
                                               .rating__input--none {
                                                 display: none;
                                               }
                                               /* set icon padding and size */
                                               .rating__label {
                                                 cursor: pointer;
                                                 padding: 0 0.1em;
                                                 font-size: 2rem;
                                               }
                                               /* set default star color */
                                               .rating__icon--star {
                                                 color: orange;
                                               }
                                               /* if any input is checked, make its following siblings grey */
                                               .rating__input:checked ~ .rating__label .rating__icon--star {
                                                 color: #ddd;
                                               }
                                               /* make all stars orange on rating group hover */
                                               .rating-group:hover .rating__label .rating__icon--star {
                                                 color: orange;
                                               }
                                               /* make hovered input's following siblings grey on hover */
                                               .rating__input:hover ~ .rating__label .rating__icon--star {
                                                 color: #ddd;
                                               }
                                        </style>
                                    <div id="full-stars-example-two">
                                        <div class="rating-group">
                                            <input disabled checked class="rating__input rating__input--none" name="rating3" id="rating3-none" value="0" type="radio" required>
                                            <label aria-label="1 star" class="rating__label" for="rating3-1"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                            <input class="rating__input" name="rating3" id="rating3-1" value="1" type="radio">
                                            <label aria-label="2 stars" class="rating__label" for="rating3-2"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                            <input class="rating__input" name="rating3" id="rating3-2" value="2" type="radio">
                                            <label aria-label="3 stars" class="rating__label" for="rating3-3"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                            <input class="rating__input" name="rating3" id="rating3-3" value="3" type="radio">
                                            <label aria-label="4 stars" class="rating__label" for="rating3-4"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                            <input class="rating__input" name="rating3" id="rating3-4" value="4" type="radio">
                                            <label aria-label="5 stars" class="rating__label" for="rating3-5"><i class="rating__icon rating__icon--star fa fa-star"></i></label>
                                            <input class="rating__input" name="rating3" id="rating3-5" value="5" type="radio">
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label><?php echo e(__('message.description')); ?></label>
                                        <textarea name="description" required placeholder="<?php echo e(__('message.Enter Your Description')); ?>"></textarea>
                                    </div>
                                       <?php if(empty(Session::has("user_id"))): ?>
                                       <a href="<?php echo e(url('patientlogin')); ?>" class="theme-btn-one"><?php echo e(__('message.Submit Review')); ?></a>
                                       <?php else: ?>
                                       <button class="theme-btn-one"><?php echo e(__('message.Submit Review')); ?><i class="icon-Arrow-Right"></i></button>
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
         <div class="col-lg-6 col-md-6 col-sm-12 sidebar-side">
            <?php $booking=true; ?>
            <div class="doctors-sidebar">
               <div class="form-widget">
                  <div class="form-title">
                     <h3><?php echo e(__('message.Book Appointment')); ?></h3>
                     <p><?php echo e(__('message.Monday to Sunday')); ?>: <?php echo e($data->working_time); ?></p>
                  </div>
                  <form action="<?=env('APP_URL').'bookingv2/'.$data->id?>" method="get" enctype="multipart/form-data">
                        <div class="choose-service">
                           <h4><?php echo e(__('Service Information')); ?></h4>
                                <div class="form-group">
                                <?php if(isset($_REQUEST['service']) && empty($_REQUEST['therapist'])): ?>
                                    <div class="form-group">
                                        <label><?php echo e(__('Service')); ?></label>
                                        <input type="text" name="service_name" id="service_name" value="<?php echo e($services->zenoti_service_name); ?>" placeholder="Enter Service Name" disabled>
                                        <input type="hidden" name="service" id="service" value="<?php echo e($services->zenoti_service_id); ?>" />
                                    </div>
                                    <div class="form-group">
                                        <div class="select-box">
                                            <select class="form-control"  name="therapist" id="therapist" required>
                                                <option value=""><?php echo e(__('Select Specialist')); ?></option>
                                                <option value="any">Any Therapist</option>
                                                <?php $__currentLoopData = $specilaist['therapists']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $therapists): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($therapists['id']); ?>"><?php echo e($therapists['display_name']); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Date</label>
                                        <input type="text" name="date"  id="date" value="<?php echo e(date('Y/m/d')); ?>" id="datepicker" onchange="slotdivchange(this.value)" required>
                                    </div>
                                <?php elseif(isset($_REQUEST['service']) && isset($_REQUEST['therapist'])&& isset($_REQUEST['date']) ): ?>
                                    <?php 
                                        if($_REQUEST['therapist']=="any"){
                                            $therapist_name="Selected Any";
                                        }else{
                                            //$therapist_name=$specilaist['personal_info']['first_name'] .' ' . $specilaist['personal_info']['last_name'];
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label>Selected Service</label>
                                        <input type="text" name="service_name" id="service_name" value="<?php echo e($service_name); ?>" placeholder="Enter Service Name" disabled>
                                        <label style="margin-top: 15px;">Selected Therapist</label>
                                        <input type="text" name="therapist_name" id="therapist_name" value="<?php echo e($therapist_name); ?>"" placeholder="" disabled>
                                          <label>Change Date</label>
                                          <input class="dateForSlots" type="text" value="<?php echo e($_REQUEST['date']); ?>" name="date"  id="date" value="<?php echo e(date('Y/m/d')); ?>" id="datepicker" required>
                                          <div id="ZenotiAvailableSlots"></div>
   
                                        <input type="hidden" name="therapist" id="therapist" value="<?php echo e($therapist_id); ?>" />
                                        <input type="hidden" name="service" id="service" value="<?php echo e($service_id); ?>" />
                                        <input type="hidden" name="booking_id" id="booking_id" value="<?php echo e($booking_id); ?>">
                                        <input type="hidden" name="newdate" id="newdate" value="">
                                        <input type='text' value='' name='newslot' id='newslot'/>
                                        <label style="margin-top: 15px;">Slots Availability (Choose Slot)</label>
                                          <div class="custom-slot-design-box">
                                          <ul id="slotdiv">
                                                <?php if(!empty($slots['slots'])): ?>
                                                <?php 
                                                 $booking=true;
                                                ?>
                                                <?php $__currentLoopData = $slots['slots']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php 
                                                   $slotfulltime=$slot['Time'];
                                                   $slottimearray=explode("T",$slot['Time']);
                                                   $slottimearray2=explode(":",$slottimearray[1]);
                                                   $slottime=$slottimearray2[0].":".$slottimearray2[1];
                                                ?>
                                                <li>
                                                   <?php if($slot['Available']==1): ?>
                                                   <input type='radio' value='<?php echo e($slotfulltime); ?>' name='slot' id='<?php echo e($slottime); ?>'/>
                                                   <label for='<?php echo e($slottime); ?>'><?php echo e($slottime); ?></label>
                                                   <?php else: ?>
                                                   <input style="background-color: gray;" type='radio' value='<?php echo e($slotfulltime); ?>' name='slot' id='<?php echo e($slottime); ?>' disabled/>
                                                   <label style="color: red;" for='<?php echo e($slotfulltime); ?>'><?php echo e($slottime); ?></label>
                                                   <?php endif; ?>
                                                </li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                             <?php else: ?>
                                                <?php $booking=false; ?>
                                                <p style="color: red;margin-left: 10px;"><?php echo e(__("No Slots Available!")); ?></p>
                                             <?php endif; ?>
                                          </ul>
                                       </div>
                                    </div>
                                <?php else: ?>
                                    <!-- only service drop down -->
                                     <input type="hidden" id="center_id" name="center_id" value="<?=$center_id?>" />
                                    <div class="form-group">
                                        <div class="select-box">
                                            <select class="form-control" name="category" id="category" required>
                                                <option value=""><?php echo e(__('Select Category')); ?></option>
                                                <?php $__currentLoopData = $categories['categories']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($category['id']); ?>"><?php echo e($category['name']); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="select-box">
                                            <select class="form-control" name="service" id="zenotiservice" required>
                                                <option value=""><?php echo e(__('Select Service')); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="select-box">
                                            <select class="form-control" name="therapist" id="zenotitherapist" required>
                                                <option value=""><?php echo e(__('Select Therapist')); ?></option>
                                                <option value="any">Any Therapist</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Select Date</label>
                                       <input type="text" name="date"  id="date" value="<?php echo e(date('Y/m/d')); ?>" id="datepicker" onchange="slotdivchange(this.value)" required>
                                        <div id="ZenotiAvailableSlots"></div>
                                    </div>
                                    <input type="hidden" name="action" value="create-booking" />
                                <?php endif; ?>
                                <?php 
                                 if(!empty($slots['slots'])){
                                    ?>
                                       <div class="btn-box">
                                        <button class="theme-btn-one" type="submit"><?php echo e(__('Book Appointment')); ?></button>
                                        <input type="hidden" name="finalbookappointment" value="finalbookappointment" />
                                       </div>
                                    <?php
                                 }elseif(empty($slots['slots']) && $booking==false){
                                    ?>
                                   <div class="btn-box">
                                       <button disabled=ture class="btn-primary" type="submit"><?php echo e(__('No Slots! Please call us')); ?></button>
                                       <input type="hidden" name="finalbookappointment" value="finalbookappointment" />
                                    </div>
                                    <?php
                                 }
                                 else{
                                    ?>
                                    <div class="btn-box">
                                        <button class="theme-btn-one" type="submit"><?php echo e(__('Next')); ?><i class="icon-Arrow-Right"></i></button>
                                    </div>
                                    <?php
                                 }
                                ?>
                                </div>
                           </div>
                        </div>
                    </form>
                     </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<script>
        $(document).ready(function(){
            $('#category').change(function(){
                var category_id = $(this).val();
                var center_id=$('#center_id').val();
                if(category_id){
                    $.ajax({
                        type: 'POST',
                        url: 'http://localhost/berkowits/scripts/bind/fetch_services.php',
                        data: {category_id: category_id,center_id: center_id},
                        success: function(html){
                            $('#zenotiservice').html(html);
                        }
                    });
                }else{
                    $('#zenotiservice').html('<option value="">Select Services</option>');
                }
            });
        });
    </script>
        <script>
        $(document).ready(function(){
            $('#zenotiservice').change(function(){
                var service_arr=$(this).val();
                let arr = service_arr.split("|"); 
                var service_id =arr[0];
                //var service_id = $(this).val();
                var center_id=$('#center_id').val();
                if(service_id){
                    $.ajax({
                        type: 'POST',
                        url: 'http://localhost/berkowits/scripts/bind/fetch_therapist.php',
                        data: {service_id: service_id,center_id: center_id},
                        success: function(html){
                            $('#zenotitherapist').html(html);
                        }
                    });
                }else{
                    $('#zenotitherapist').html('<option value="">Select Therapist</option>');
                }
            });
        });
      </script>
      <script>
        $(document).ready(function(){
            $('#date').change(function(){
                var bookingId=$('#booking_id').val();
                var newDate=$(this).val();
                if(bookingId){
                    $.ajax({
                        type: 'POST',
                        url: 'http://localhost/berkowits/scripts/bind/fetch_slots.php',
                        data: {bookingId: bookingId,newDate: newDate},
                        success: function(html){
                            $('#ZenotiAvailableSlots').html(html);
                            //document.getElementById("slotdiv").style.display = "none";
                            document.getElementById('newdate').value = newDate;
                            var extractedValue = $(html).find('slot').text(); 
                                                // Capture slot value when a slot is selected
                              $('#ZenotiAvailableSlots').on('change', 'input[name="slot"]', function() {
                                    var selectedSlot = $(this).val(); // Get selected slot value
                                    document.getElementById('newslot').value = selectedSlot; // Assign to newslot
                              });
                        }
                    });
                }
            });
        });
      </script>
      
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/user/bookingv2.blade.php ENDPATH**/ ?>