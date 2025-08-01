<?php $__env->startSection('title'); ?>
<?php echo e(__('message.Pharmacy Details')); ?>

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
            <h1><?php echo e(__('message.Pharmacy Details')); ?></h1>
         </div>
      </div>
   </div>
   <div class="lower-content">
      <div class="auto-container">
         <ul class="bread-crumb clearfix">
            <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('message.Home')); ?></a></li>
            <li><?php echo e(__('message.Pharmacy Details')); ?></li>
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
         <div class="col-lg-8 col-md-12 col-sm-12 content-side">
             <div id="favmsg"></div>
            <div class="clinic-details-content doctor-details-content">
               <div class="clinic-block-one">
                  <div class="inner-box">
                     <figure class="image-box">
                        <?php
                           if($data->image==""){
                               $path=asset('public/upload/doctors/defaultpharmacy.png');
                           }else{
                               $path=asset('public/upload/doctors').'/'.$data->image;
                           }

                           ?>
                        
                        <div class="doctor-detail-page-main-box" style="background-image:url('<?php echo e($path); ?>'); background-size: 200px 220px;" ></div>
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
                              <li><i class="fas fa-map-marker-alt"></i><?php echo e(substr($data->address,0,40)); ?>  <a href="https://maps.google.com/?q=<?php echo e($data->lat); ?>,<?php echo e($data->lon); ?>" target="_blank" style="float: right;color: #01b4d9;">| <?php echo e(__('message.View Map')); ?></a></li>
                              <li style="text-align: center;">
                                <i class="fas fa-phone mt-2"></i><a href="<?php echo e($data->phoneno); ?>"><?php echo e($data->phoneno); ?></a>

                                <?php if(Session::has("user_id") && Session::get("role_id") == '1'): ?>
                                <a href="#" class="theme-btn-one" data-toggle="modal" data-target="#addprescription" style="padding: 12px 30px;margin-left: 140px;"><?php echo e(__('message.Upload Prescription')); ?></a>
                                <?php else: ?>
                                    <a href="#" class="theme-btn-one" onclick="pleaselogin()" style="padding: 12px 30px;margin-left: 140px;"><?php echo e(__('message.Upload Prescription')); ?></a>
                                <?php endif; ?>
                            </li>
                              
                           </ul>
                           
                        </div>
                     </div>
                  </div>
               </div>

               <!-- Modal -->
                <div class="modal fade" id="addprescription" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('message.Add Prescription')); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <form action="<?php echo e(url('upload_pre_order')); ?>" method="post" enctype="multipart/form-data">
                                   <?php echo e(csrf_field()); ?>

                                    <input type="hidden" name="Pharmacy_id" id="Pharmacy_id" value="<?php echo e($data->id); ?>">

                                    <div class="form-group">
                                        <label><?php echo e(__('message.Upload Prescription')); ?></label><br>
                                        <input type="file" name="prescription" id="prescription" required>
                                     </div>

                                    <div class="form-group">
                                        <label><?php echo e(__('message.Phone no')); ?></label>
                                        <input type="text" name="phone_no" id="phone_no1" placeholder="<?php echo e(__('message.Enter Your Phone number')); ?>" value="<?php echo e(Session::get("user_phone_no")); ?>" required="">
                                     </div>
                                     <div class="form-group">
                                      <label><?php echo e(__('message.Address')); ?></label>
                                      <input type="text" name="address" id="address1" placeholder="<?php echo e(__('message.Enter')); ?> <?php echo e(__('message.Address')); ?>" required="">
                                   </div>
                                     <div class="form-group">
                                        <label><?php echo e(__('message.Message')); ?></label>
                                        <textarea id="message1" rows="15"  name="message" placeholder="<?php echo e(__('message.Enter Your Message')); ?>"></textarea>
                                     </div>

                                    <div class="btn-box" id="btnappointment">
                                    <button class="theme-btn-one" type="submit" style="box-shadow:none;"><?php echo e(__('message.submit')); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>

               <div class="tabs-box">
                  <div class="tab-btn-box centred">
                     <ul class="tab-btns tab-buttons clearfix">
                         <li class="tab-btn active-btn" data-tab="#tab-3"><?php echo e(__('message.Medicine')); ?></li>
                        <li class="tab-btn " data-tab="#tab-1"><?php echo e(__('message.About Us')); ?></li>
                        <li class="tab-btn" data-tab="#tab-2"><?php echo e(__('message.Services')); ?></li>
                        <li class="tab-btn" data-tab="#tab-4"><?php echo e(__('message.Review')); ?></li>
                     </ul>
                  </div>
                  <div class="tabs-content">

                    <div class="tab  active-tab" id="tab-3">
                        <div class="location-box">
                           <h3><?php echo e(__('message.Medicine')); ?></h3>

                            <div class="clinic-list-content list-item">
                                <?php $__currentLoopData = $medicine; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($dl->image!=""): ?>
                                    <div class="clinic-block-one mb-3" style="border: 1px solid #e5e7ec;border-radius: 5px;">
                                        <div class="inner-box" style="margin-bottom: 0px; padding: 10px 40px 37px 260px;">
                                            <div class="pattern">
                                                <div class="pattern-1" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-24.png')); ?>');"></div>
                                                <div class="pattern-2" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-25.png')); ?>');"></div>
                                            </div>
                                            <figure class="image-box" style="height: 10px;top: 20px;">
                                                <img src="<?php echo e(asset('public/upload/pharmacymedicine').'/'.$dl->image); ?>" alt="" style="height: 135px;">
                                            </figure>
                                            <div class="content-box">
                                                <ul class="name-box clearfix">
                                                    <li class="name"><h3><a href="<?php echo e(url('viewdoctor').'/'.$dl->id); ?>"><?php echo e($dl->name); ?></a></h3></li>
                                                </ul>
                                                <span class="designation"><?php echo e(isset($dl->description)?$dl->description:""); ?></span>

                                                <div class="location-box" style="margin-top: 10px;">
                                                    <?php $currency = explode("-", $setting->currency);?>
                                                    <p><b><?php echo e($dl->price); ?> <?php echo e($currency[1]); ?></b></p>
                                                </div>
                                                <div class="btn-box" style=" bottom: 25px;">
                                                    <?php if(Session::has("user_id") && Session::get("role_id") == '1'): ?>
                                                    <a href="<?php echo e(url('addToCart/'.$dl->id)); ?>" class="theme-btn-one"><?php echo e(__('message.Add Cart')); ?></a>
                                                    <?php else: ?>
                                                        <a href="#" class="theme-btn-one" onclick="pleaselogin()"><?php echo e(__('message.Add Cart')); ?></a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <div class="clinic-block-one mb-3" style="border: 1px solid #e5e7ec;border-radius: 5px;">
                                        <div class="inner-box" style="margin-bottom: 0px; padding: 10px 40px 37px 40px;">
                                            <div class="pattern">
                                                <div class="pattern-1" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-24.png')); ?>');"></div>
                                                <div class="pattern-2" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-25.png')); ?>');"></div>
                                            </div>

                                            <div class="content-box">
                                                <ul class="name-box clearfix">
                                                    <li class="name"><h3><a href="<?php echo e(url('viewdoctor').'/'.$dl->id); ?>"><?php echo e($dl->name); ?></a></h3></li>
                                                </ul>
                                                <span class="designation"><?php echo e(isset($dl->description)?$dl->description:""); ?></span>

                                                <div class="location-box" style="margin-top: 10px;">
                                                    <p><b><?php echo e($dl->price); ?> $</b></p>
                                                </div>
                                                <div class="btn-box" style=" bottom: 25px;">
                                                    <?php if(Session::has("user_id") && Session::get("role_id") == '1'): ?>
                                                    <a href="<?php echo e(url('addToCart/'.$dl->id)); ?>" class="theme-btn-one"><?php echo e(__('message.Add Cart')); ?></a>
                                                    <?php else: ?>
                                                        <a href="#" class="theme-btn-one" onclick="pleaselogin()"><?php echo e(__('message.Add Cart')); ?></a>
                                                    <?php endif; ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>



                        </div>
                     </div>

                     <div class="tab" id="tab-1">
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
                                    <img src="<?php echo e(isset($dr->patientls->profile_pic) ? asset('public/upload/profile/' . $dr->patientls->profile_pic) : asset('public/upload/profile/profile.png')); ?>"  alt="">
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
                                 <h6><?php echo e($dr->patientls->name); ?><span>-
                                    <?php
                                       ?><?php echo e(date("F d, Y",strtotime($dr->created_at))); ?></span>
                                 </h6>
                                 <p><?php echo e($dr->description); ?></p>
                              </div>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </div>
                           <div class="btn-box">
                              <form action="<?php echo e(url('savereview')); ?>" method="post" >
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
                                            <input disabled checked class="rating__input rating__input--none" name="rating3" id="rating3-none" value="1" type="radio" required>
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

                                    <?php if(Session::has("user_id") && Session::get("role_id") == '1'): ?>
                                    <button class="theme-btn-one"><?php echo e(__('message.Submit Review')); ?><i class="icon-Arrow-Right"></i></button>
                                    <?php else: ?>
                                        <a href="#" class="theme-btn-one" onclick="pleaselogin()"><?php echo e(__('message.Submit Review')); ?></a>
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
         <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
            <div class="doctors-sidebar">
               <div class="form-widget">
                  <div class="form-title">
                     <h3><?php echo e(__('message.Cart Details')); ?></h3>
                     <p><?php echo e(__('message.Monday to Sunday')); ?>: <?php echo e($data->working_time); ?></p>
                  </div>
                  <?php $currency = explode("-", $setting->currency);?>
                     <div class="form-inner">
                        <div class="appointment-time">
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

                           <div class="row">
                              <?php if(session()->get('cart') !=null): ?>
                            <?php
                            $cart = session()->get('cart');
                            $subtotal = 0;
                            $subtotal1 = 0;
                            $subtotal2 = 0;
                            ?>
                            <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-12" style="border-bottom:1px solid #e5e7ec;">
                                    <p><b><?php echo e($item['name']); ?></b> <a style="float: right;" href="<?php echo e(url('removeCartItem/'.$item['id'])); ?>"><i style="color: red;" class="far fa-trash"></i></a></p>
                                    <div class="row">
                                        <div class="col-4 pb-2">
                                            <p><?php echo e(__('message.Price')); ?>: <?php echo e($item['price']); ?><?php echo e($currency[1]); ?></p>
                                        </div>
                                        <div class="col-4">
                                            <p><?php echo e(__('message.Qty')); ?>: <?php echo e($item['quantity']); ?></p>
                                        </div>
                                        <div class="col-4" style="display: inline;" >
                                            <p><?php echo e(__('message.Total')); ?>: <?php echo e($item['price'] * $item['quantity']); ?><?php echo e($currency[1]); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $subtotal1 += $item['price'] * $item['quantity'];
                                ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-12">
                                <?php
                                $aa = $setting->pharmacy_delivery_charge + $subtotal1;
                                $subtotal2 =   $aa  * $setting->pharmacy_tax /100 ;

                                $subtotal = $subtotal1 + $subtotal2 + $setting->pharmacy_delivery_charge;
                                  ?>
                                <div class="row">
                                    <div class="col-8" style="text-align: right;">
                                        <b><?php echo e(__('message.Sub Total')); ?>:</b>
                                    </div>
                                    <div class="col-4" style="text-align: right;">
                                        <p> <?php echo e($subtotal1); ?><?php echo e($currency[1]); ?> </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8" style="text-align: right;">
                                        <b><?php echo e(__('message.Delivery Charge')); ?>:</b>
                                    </div>
                                    <div class="col-4" style="text-align: right;">
                                        <p> <?php echo e($setting->pharmacy_delivery_charge); ?><?php echo e($currency[1]); ?> </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8" style="text-align: right;">
                                        <b><?php echo e(__('message.Tax')); ?>(<?php echo e($setting->pharmacy_tax); ?>%):</b>
                                    </div>
                                    <div class="col-4" style="text-align: right;">
                                        <p> <?php echo e($subtotal2); ?><?php echo e($currency[1]); ?> </p>
                                    </div>
                                </div><hr>
                                <div class="row">
                                    <div class="col-8" style="text-align: right;">
                                        <b><?php echo e(__('message.Total')); ?>:</b>
                                    </div>
                                    <div class="col-4" style="text-align: right;">
                                        <p> <?php echo e($subtotal); ?><?php echo e($currency[1]); ?> </p>
                                    </div>
                                </div>

                            </div>
                            </div>
                            <?php else: ?>
                            <?php
                            $subtotal = 0;
                            ?>
                            <?php echo e(__('message.Cart Is empty')); ?>

                            <?php endif; ?>
                           </div>
                        </div>
                        <?php if(session()->get('cart') !=null): ?>
                        <div class="choose-service">
                           <h4><?php echo e(__('message.Enter Information')); ?></h4>
                           <div class="form-group">
                              <label><?php echo e(__('message.Phone no')); ?></label>
                              <input type="text" name="phone_no" id="phone_no" placeholder="<?php echo e(__('message.Enter Your Phone number')); ?>" value="<?php echo e(Session::get("user_phone_no")); ?>" required="">
                           </div>
                           <div class="form-group">
                            <label><?php echo e(__('message.Address')); ?></label>
                            <input type="text" name="address" id="address" placeholder="<?php echo e(__('Enter Your address')); ?>" required="">
                         </div>
                           <div class="form-group">
                              <label><?php echo e(__('message.Message')); ?></label>
                              <textarea id="message" rows="15"  name="message" placeholder="<?php echo e(__('message.Enter Your Message')); ?>"></textarea>
                           </div>
                            <div class="row">
                                <div class="col-md-6">
                                   <div class="custom-check-box">
                                      <div class="custom-controls-stacked">
                                         <label class="custom-control material-checkbox fl">
                                         <input type="radio" class="material-control-input" name="payment_type" id="payment_type_cod" value="3" onchange="changeform(this.value)">
                                         <span class="material-control-indicator"></span>
                                         <span class="description"><?php echo e(__('message.COD')); ?></span>
                                         </label>
                                      </div>
                                   </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="custom-check-box">
                                        <div class="custom-controls-stacked">
                                             <label class="custom-control material-checkbox fl">
                                             <input type="radio" class="material-control-input"  name="payment_type" id="payment_type_stripe" value="2" onchange="changeform(this.value)">
                                             <span class="material-control-indicator"></span>
                                             <span class="description"><?php echo e(__('message.Stripe')); ?></span>
                                             </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="custom-check-box">
                                      <div class="custom-controls-stacked">
                                         <label class="custom-control material-checkbox fl">
                                         <input type="radio" class="material-control-input"  name="payment_type" id="payment_type_rave" value="4" onchange="changeform(this.value)">
                                         <span class="material-control-indicator"></span>
                                         <span class="description"><?php echo e(__('message.Rave')); ?></span>
                                         </label>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="custom-check-box">
                                      <div class="custom-controls-stacked">
                                         <label class="custom-control material-checkbox fl">
                                         <input type="radio" class="material-control-input"  name="payment_type" id="payment_type_paytm" value="5" onchange="changeform(this.value)">
                                         <span class="material-control-indicator"></span>
                                         <span class="description"><?php echo e(__('message.Paytm')); ?></span>
                                         </label>
                                      </div>
                                   </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="custom-check-box">
                                        <div class="custom-controls-stacked">
                                             <label class="custom-control material-checkbox fl">
                                             <input type="radio" class="material-control-input" name="payment_type" id="payment_type_braintree" value="1" onchange="changeform(this.value)">
                                             <span class="material-control-indicator"></span>
                                             <span class="description"><?php echo e(__('message.Braintree')); ?></span>
                                             </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="custom-check-box">
                                        <div class="custom-controls-stacked">
                                             <label class="custom-control material-checkbox fl">
                                             <input type="radio" class="material-control-input"  name="payment_type" id="payment_type_razorpay" value="6" onchange="changeform(this.value)">
                                             <span class="material-control-indicator"></span>
                                             <span class="description"><?php echo e(__('message.Razorpay')); ?></span>
                                             </label>
                                        </div>
                                   </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="custom-check-box">
                                        <div class="custom-controls-stacked">
                                             <label class="custom-control material-checkbox fl">
                                             <input type="radio" class="material-control-input" name="payment_type" id="payment_type_paystack" value="7" onchange="changeform(this.value)">
                                             <span class="material-control-indicator"></span>
                                             <span class="description"><?php echo e(__('message.Paystack')); ?></span>
                                             </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="text-center">

                            <?php if(Session::has("user_id") && Session::get("role_id") == '1'): ?>
                                <?php if(session()->get('cart') !=null): ?>
                                    <button class="theme-btn-one centred" type="button" id="show_book" onclick="bookshow()" ><?php echo e(__('message.place order')); ?><i class="icon-Arrow-Right"></i></button>
                                <?php else: ?>
                                    <button type="button" class="theme-btn-one" onclick="alert('your cart is emty')"  id="show_book"><?php echo e(__('message.place order')); ?><i class="icon-Arrow-Right"></i></button>
                                <?php endif; ?>

                            <?php else: ?>
                                  <button type="button" class="theme-btn-one" onclick="pleaselogin()"  id="show_book"><?php echo e(__('message.place order')); ?><i class="icon-Arrow-Right"></i></button>
                            <?php endif; ?>
                            </div>
                            <div id="braintree_div" style="display:none;">
                                <form action="<?php echo e(url('addpharmacyorder')); ?>" method="post" id="payment-form">
                                   <?php echo e(csrf_field()); ?>

                                    <input type="hidden" name="Pharmacy_id" id="Pharmacy_id" value="<?php echo e($data->id); ?>">
                                    <input type="hidden" name="total" value="<?php echo e($subtotal); ?>">
                                    <input type="hidden" name="tax" value="<?php echo e($subtotal2); ?>">
                                    <input type="hidden" name="delivery_charge" value="<?php echo e($setting->pharmacy_delivery_charge); ?>">
                                    <input type="hidden" name="phone_no" id="phone_no_1">
                                    <input type="hidden" name="address" id="address_1">
                                    <input type="hidden" name="slot" id="slot_1">
                                    <input type="hidden" name="message" id="message_1">
                                    <input type="hidden" name="payment_type" value="braintree">
                                    <div class="bt-drop-in-wrapper">
                                        <div id="bt-dropin"></div>
                                    </div>
                                    <input id="nonce" name="payment_method_nonce" type="hidden" />
                                    <div class="btn-box" id="btnappointment">
                                        <?php if(Session::has("user_id")): ?>
                                              <button class="theme-btn-one" type="submit"><?php echo e(__('message.place order')); ?><i class="icon-Arrow-Right"></i></button>
                                        <?php else: ?>
                                              <button type="button" class="theme-btn-one" onclick="pleaselogin()"><?php echo e(__('message.place order')); ?><i class="icon-Arrow-Right"></i></button>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>

                            <div id="stripe_div" style="display:none;">
                                <form action="<?php echo e(url('addpharmacyorder')); ?>" method="post" id="stripe-form">
                                    <?php echo e(csrf_field()); ?>

                                    <input type="hidden" name="phone_no" id="phone_no_2">
                                    <input type="hidden" name="address" id="address_2">
                                    <input type="hidden" name="slot" id="slot_2">
                                    <input type="hidden" name="message" id="message_2">
                                    <input type="hidden" name="payment_type" value="stripe">
                                    <input type="hidden" name="Pharmacy_id" id="Pharmacy_id" value="<?php echo e($data->id); ?>">
                                    <input type="hidden" name="total" value="<?php echo e($subtotal); ?>">
                                    <input type="hidden" name="tax" value="<?php echo e($subtotal2); ?>">
                                    <input type="hidden" name="delivery_charge" value="<?php echo e($setting->pharmacy_delivery_charge); ?>">
                                    <script
                                      src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                      data-key="<?php echo e(env('STRIPE_KEY')); ?>"
                                      data-amount="<?php echo e($subtotal * 100); ?>"
                                      data-id="stripid"
                                      data-name="<?php echo e(__('message.System Name')); ?>"
                                      data-label="<?php echo e(__('message.place order')); ?>"
                                      data-description=""
                                      data-image="<?php echo e(asset('public/image_web/').'/'.$setting->logo); ?>"
                                      data-locale="auto">
                                    </script>
                                </form>
                            </div>

                            <div id="cod_div" style="display:none;">
                                <form action="<?php echo e(url('addpharmacyorder')); ?>" method="post" id="payment-form">
                                   <?php echo e(csrf_field()); ?>

                                    <input type="hidden" name="Pharmacy_id" id="Pharmacy_id" value="<?php echo e($data->id); ?>">
                                    <input type="hidden" name="total" value="<?php echo e($subtotal); ?>">
                                    <input type="hidden" name="tax" value="<?php echo e($subtotal2); ?>">
                                    <input type="hidden" name="delivery_charge" value="<?php echo e($setting->pharmacy_delivery_charge); ?>">
                                    <input type="hidden" name="phone_no" id="phone_no_3">
                                    <input type="hidden" name="address" id="address_3">
                                    <input type="hidden" name="slot" id="slot_3">
                                    <input type="hidden" name="message" id="message_3">
                                    <input type="hidden" name="payment_type" value="cod">
                                    <div class="bt-drop-in-wrapper">
                                        <div id="bt-dropin"></div>
                                    </div>
                                    <input id="nonce" name="payment_method_nonce" type="hidden" />
                                    <div class="btn-box" id="btnappointment">
                                        <?php if(Session::has("user_id")): ?>
                                              <button class="theme-btn-one" type="submit"><?php echo e(__('message.place order')); ?><i class="icon-Arrow-Right"></i></button>
                                        <?php else: ?>
                                              <button type="button" class="theme-btn-one" onclick="pleaselogin()"><?php echo e(__('message.place order')); ?><i class="icon-Arrow-Right"></i></button>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>

                            <div id="rave_div" style="display:none;">
                                <form action="<?php echo e(url('addpharmacyorder')); ?>" method="post" id="payment-form">
                                   <?php echo e(csrf_field()); ?>

                                    <input type="hidden" name="Pharmacy_id" id="Pharmacy_id" value="<?php echo e($data->id); ?>">
                                    <input type="hidden" name="total" value="<?php echo e($subtotal); ?>">
                                    <input type="hidden" name="tax" value="<?php echo e($subtotal2); ?>">
                                    <input type="hidden" name="delivery_charge" value="<?php echo e($setting->pharmacy_delivery_charge); ?>">
                                    <input type="hidden" name="phone_no" id="phone_no_4">
                                    <input type="hidden" name="address" id="address_4">
                                    <input type="hidden" name="slot" id="slot_4">
                                    <input type="hidden" name="message" id="message_4">
                                    <input type="hidden" name="payment_type" value="Flutterwave">
                                    <div class="bt-drop-in-wrapper">
                                        <div id="bt-dropin"></div>
                                    </div>
                                    <input id="nonce" name="payment_method_nonce" type="hidden" />
                                    <div class="btn-box" id="btnappointment">
                                        <?php if(Session::has("user_id")): ?>
                                              <button class="theme-btn-one" type="submit"><?php echo e(__('message.place order')); ?><i class="icon-Arrow-Right"></i></button>
                                        <?php else: ?>
                                              <button type="button" class="theme-btn-one" onclick="pleaselogin()"><?php echo e(__('message.place order')); ?><i class="icon-Arrow-Right"></i></button>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>

                            <div id="paytm_div" style="display:none;">
                                <form action="<?php echo e(url('addpharmacyorder')); ?>" method="post" id="payment-form">
                                   <?php echo e(csrf_field()); ?>

                                    <input type="hidden" name="Pharmacy_id" id="Pharmacy_id" value="<?php echo e($data->id); ?>">
                                    <input type="hidden" name="total" value="<?php echo e($subtotal); ?>">
                                    <input type="hidden" name="tax" value="<?php echo e($subtotal2); ?>">
                                    <input type="hidden" name="delivery_charge" value="<?php echo e($setting->pharmacy_delivery_charge); ?>">
                                    <input type="hidden" name="phone_no" id="phone_no_5">
                                    <input type="hidden" name="address" id="address_5">
                                    <input type="hidden" name="slot" id="slot_5">
                                    <input type="hidden" name="message" id="message_5">
                                    <input type="hidden" name="payment_type" value="Paytm">
                                    <div class="bt-drop-in-wrapper">
                                        <div id="bt-dropin"></div>
                                    </div>
                                    <input id="nonce" name="payment_method_nonce" type="hidden" />
                                    <div class="btn-box" id="btnappointment">
                                        <?php if(Session::has("user_id")): ?>
                                              <button class="theme-btn-one" type="submit"><?php echo e(__('message.place order')); ?><i class="icon-Arrow-Right"></i></button>
                                        <?php else: ?>
                                              <button type="button" class="theme-btn-one" onclick="pleaselogin()"><?php echo e(__('message.place order')); ?><i class="icon-Arrow-Right"></i></button>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>

                            <div id="razorpay_div" style="display:none;">
                                <form action="<?php echo e(url('addpharmacyorder')); ?>" method="post" id="payment-form">
                                   <?php echo e(csrf_field()); ?>

                                    <input type="hidden" name="Pharmacy_id" id="Pharmacy_id" value="<?php echo e($data->id); ?>">
                                    <input type="hidden" name="total" value="<?php echo e($subtotal); ?>">
                                    <input type="hidden" name="tax" value="<?php echo e($subtotal2); ?>">
                                    <input type="hidden" name="delivery_charge" value="<?php echo e($setting->pharmacy_delivery_charge); ?>">
                                    <input type="hidden" name="phone_no" id="phone_no_6">
                                    <input type="hidden" name="address" id="address_6">
                                    <input type="hidden" name="slot" id="slot_6">
                                    <input type="hidden" name="message" id="message_6">
                                    <input type="hidden" name="type"  value="1">

                                    <input type="hidden" name="payment_type" value="Razorpay">
                                    <div class="bt-drop-in-wrapper">
                                        <div id="bt-dropin"></div>
                                    </div>
                                    <input id="nonce" name="payment_method_nonce" type="hidden" />
                                    <?php if(Session::has("user_id")): ?>
                                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key="<?php echo e($paymentdetail['razorpay_razorpay_key']); ?>"
                                            data-amount="<?php echo e((int)$subtotal*100); ?>"
                                            data-buttontext='<?php echo e(__("message.Pay")); ?>'
                                            data-name="<?php echo e(env('APP_NAME')); ?>"
                                            data-description="Payment"
                                            data-image="<?php echo e(asset('public/image_web/896814.png')); ?>"
                                            data-prefill.name="name"
                                            data-prefill.email="email"
                                            data-theme.color="#d18217">
                                        </script>
                                    <?php else: ?>
                                          <button type="button" class="theme-btn-one" onclick="pleaselogin()"><?php echo e(__('message.place order')); ?><i class="icon-Arrow-Right"></i></button>
                                    <?php endif; ?>
                                </form>
                            </div>

                            <div id="paystack_div" style="display:none;">
                                <form action="<?php echo e(url('addpharmacyorder')); ?>" method="post" id="payment-form">
                                   <?php echo e(csrf_field()); ?>

                                    <input type="hidden" name="Pharmacy_id" id="Pharmacy_id" value="<?php echo e($data->id); ?>">
                                    <input type="hidden" name="total" value="<?php echo e($subtotal); ?>">
                                    <input type="hidden" name="tax" value="<?php echo e($subtotal2); ?>">
                                    <input type="hidden" name="delivery_charge" value="<?php echo e($setting->pharmacy_delivery_charge); ?>">
                                    <input type="hidden" name="phone_no" id="phone_no_7">
                                    <input type="hidden" name="address" id="address_7">
                                    <input type="hidden" name="slot" id="slot_7">
                                    <input type="hidden" name="message" id="message_7">
                                    <input type="hidden" name="payment_type" value="Paystack">
                                    <div class="bt-drop-in-wrapper">
                                        <div id="bt-dropin"></div>
                                    </div>
                                    <input id="nonce" name="payment_method_nonce" type="hidden" />
                                    <div class="btn-box" id="btnappointment">
                                        <?php if(Session::has("user_id") && Session::get("role_id") == '1'): ?>
                                              <button class="theme-btn-one" type="submit"><?php echo e(__('message.place order')); ?><i class="icon-Arrow-Right"></i></button>
                                        <?php else: ?>
                                              <button type="button" class="theme-btn-one" onclick="pleaselogin()"><?php echo e(__('message.place order')); ?><i class="icon-Arrow-Right"></i></button>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <?php endif; ?>
                     </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>

<script src="https://js.braintreegateway.com/web/dropin/1.23.0/js/dropin.min.js"></script>
<script type="text/javascript">
   document.querySelector('.show-btn').addEventListener('click', function() {
     document.querySelector('.sm-menu').classList.toggle('active');
   });
</script>
<script>

   function changeform(val){

      var phone_no = $("#phone_no").val();
      var date = $("#date").val();
      var message = $("#message").val();
      var address = $("#address").val();
      var slot = $('input[name="slot"]:checked').val();
      if(phone_no!=""&&message!=""&&address!=""){
            if($("#payment_type_braintree").prop("checked")==true){
                 $("#braintree_div").css("display","block");
                 $("#cod_div").css("display","none");
                 $("#stripe_div").css("display","none");
                 $("#razorpay_div").css("display","none");
                 $("#paytm_div").css("display","none");
                 $("#rave_div").css("display","none");
                 $("#show_book").css("display","none");
                 $("#paystack_div").css("display","none");
                 $("#phone_no_1").val(phone_no);
                 $("#address_1").val(address);
                 $("#message_1").val(message);
                 $("#slot_1").val(slot);
            }
            if($("#payment_type_stripe").prop("checked")==true){
                 $("#stripe_div").css("display","block");
                 $("#braintree_div").css("display","none");
                 $("#cod_div").css("display","none");
                 $("#razorpay_div").css("display","none");
                 $("#paytm_div").css("display","none");
                 $("#rave_div").css("display","none");
                 $("#show_book").css("display","none");
                 $("#paystack_div").css("display","none");
                 $("#phone_no_2").val(phone_no);
                 $("#address_2").val(address);
                 $("#message_2").val(message);
                 $("#slot_2").val(slot);
            }
            if($("#payment_type_cod").prop("checked")==true){
                 $("#cod_div").css("display","block");
                 $("#braintree_div").css("display","none");
                 $("#stripe_div").css("display","none");
                 $("#razorpay_div").css("display","none");
                 $("#paytm_div").css("display","none");
                 $("#rave_div").css("display","none");
                 $("#show_book").css("display","none");
                 $("#paystack_div").css("display","none");
                 $("#phone_no_3").val(phone_no);
                 $("#address_3").val(address);
                 $("#message_3").val(message);
                 $("#slot_3").val(slot);
            }
            if($("#payment_type_rave").prop("checked")==true){
                 $("#rave_div").css("display","block");
                 $("#braintree_div").css("display","none");
                 $("#stripe_div").css("display","none");
                 $("#cod_div").css("display","none");
                 $("#razorpay_div").css("display","none");
                 $("#paytm_div").css("display","none");
                 $("#show_book").css("display","none");
                 $("#paystack_div").css("display","none");
                 $("#phone_no_4").val(phone_no);
                 $("#address_4").val(address);
                 $("#message_4").val(message);
                 $("#slot_4").val(slot);
            }
            if($("#payment_type_paytm").prop("checked")==true){
                 $("#paytm_div").css("display","block");
                 $("#braintree_div").css("display","none");
                 $("#stripe_div").css("display","none");
                 $("#cod_div").css("display","none");
                 $("#razorpay_div").css("display","none");
                 $("#rave_div").css("display","none");
                 $("#show_book").css("display","none");
                 $("#paystack_div").css("display","none");
                 $("#phone_no_5").val(phone_no);
                 $("#address_5").val(address);
                 $("#message_5").val(message);
                 $("#slot_5").val(slot);
            }
            if($("#payment_type_razorpay").prop("checked")==true){
                 $("#razorpay_div").css("display","block");
                 $("#braintree_div").css("display","none");
                 $("#stripe_div").css("display","none");
                 $("#cod_div").css("display","none");
                 $("#paytm_div").css("display","none");
                 $("#rave_div").css("display","none");
                 $("#show_book").css("display","none");
                 $("#paystack_div").css("display","none");
                 $("#phone_no_6").val(phone_no);
                 $("#address_6").val(address);
                 $("#message_6").val(message);
                 $("#slot_6").val(slot);
            }
            if($("#payment_type_paystack").prop("checked")==true){
                 $("#razorpay_div").css("display","none");
                 $("#braintree_div").css("display","none");
                 $("#stripe_div").css("display","none");
                 $("#cod_div").css("display","none");
                 $("#paytm_div").css("display","none");
                 $("#rave_div").css("display","none");
                 $("#show_book").css("display","none");
                 $("#paystack_div").css("display","block");
                 $("#phone_no_7").val(phone_no);
                 $("#address_7").val(address);
                 $("#message_7").val(message);
                 $("#slot_7").val(slot);
            }


      }else{
            alert("Please Fillup All Field");
            $("#payment_type_braintree").prop("checked", false)
            $("#payment_type_stripe").prop("checked", false)
            $("#payment_type_cod").prop("checked", false)
            $("#payment_type_rave").prop("checked", false)
            $("#payment_type_paytm").prop("checked", false)
            $("#payment_type_razorpay").prop("checked", false)
            $("#payment_type_paystack").prop("checked", false)
      }


    }

    function bookshow(){
        var phone_no = $("#phone_no").val();
        var date = $("#date").val();
        var message = $("#message").val();
        var slot = $('input[name="slot"]:checked').val();
        if(phone_no!=""&&message!=""){
            alert("please choose payment type");
        }
        else{
            alert("Please Fillup All Field");
        }
    }



   var form = document.querySelector('#payment-form');
   var client_token = "<?php echo e($token); ?>";

   braintree.dropin.create({
     authorization: client_token,
     selector: '#bt-dropin',
     paypal: {
       flow: 'vault'
     }
   }, function (createErr, instance) {
     if (createErr) {
       console.log('Create Error', createErr);
       return;
     }
     form.addEventListener('submit', function (event) {
       event.preventDefault();

       instance.requestPaymentMethod(function (err, payload) {
         if (err) {
           console.log('Request Payment Method Error', err);
           return;
         }


         document.querySelector('#nonce').value = payload.nonce;
         form.submit();
       });
     });
   });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/user/viewpharmacy.blade.php ENDPATH**/ ?>