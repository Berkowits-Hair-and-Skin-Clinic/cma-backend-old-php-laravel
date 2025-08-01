<?php $__env->startSection('title'); ?>
<?php echo e(__("message.My Profile")); ?>

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
            <h1><?php echo e(__("message.My Profile")); ?></h1>
         </div>
      </div>
   </div>
   <div class="lower-content">
      <ul class="bread-crumb clearfix">
         <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__("message.Home")); ?></a></li>
         <li><?php echo e(__("message.My Profile")); ?></li>
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
               <li><a href="<?php echo e(url('doctor_hoilday')); ?>" ><i class="fas fa-star"></i><?php echo e(__('message.My Hoilday')); ?></a></li>
               <li><a href="<?php echo e(url('doctoreditprofile')); ?>" class="current"><i class="fas fa-user"></i><?php echo e(__('message.My Profile')); ?></a></li>
               <li><a href="<?php echo e(url('doctorsubscription')); ?>"><i class="fas fa-rocket"></i><?php echo e(__('message.My Subscription')); ?></a></li>
               <li><a href="<?php echo e(url('paymenthistory')); ?>"><i class="fas fa-user"></i><?php echo e(__('message.Payment History')); ?></a></li>
               <li><a href="<?php echo e(url('doctorchangepassword')); ?>" ><i class="fas fa-unlock-alt"></i><?php echo e(__('message.Change Password')); ?></a></li>
               <li><a href="<?php echo e(url('logout')); ?>"><i class="fas fa-sign-out-alt"></i><?php echo e(__("message.Logout")); ?></a></li>
            </ul>
         </div>
      </div>
   </div>
   <div class="right-panel">
      <div class="content-container">
         <div class="outer-container">
            <div class="add-listing my-profile">
               <div class="single-box">
                  <div class="title-box">
                     <h3><?php echo e(__("message.My Profile")); ?></h3>
                  </div>
                  <div class="inner-box">
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
                     <form action="<?php echo e(url('updatedoctor')); ?>" method="post" enctype="multipart/form-data">
                       <?php echo e(csrf_field()); ?>

                                    <div class="profile-title">
                                        <figure class="image-box">

                                          <?php if($doctordata->image!=""): ?>
                                             <img src="<?php echo e(asset('public/upload/doctors').'/'.$doctordata->image); ?>" alt="" accept="image/*">
                                          <?php else: ?>
                                             <img src="<?php echo e(asset('public/front_pro/assets/images/resource/profile-2.png')); ?>" alt="" >
                                          <?php endif; ?>
                                       </figure>
                                        <div class="upload-photo">
                                            <input type="file" name="upload_image" accept="image/*">
                                            <span></span>
                                        </div>
                                    </div>

                                        <div class="row clearfix">
                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                <label><?php echo e(__('message.Name')); ?></label>
                                                <input type="text" name="name" id="name" placeholder="<?php echo e(__('message.Enter Doctor Name')); ?>" required="" value="<?php echo e(isset($doctordata->name)?$doctordata->name:''); ?>">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                               <div class="seldoctor">
                                                <label><?php echo e(__('message.Specialist')); ?></label>
                                                <select name="department_id" id="department_id">
                                                   <option value=""><?php echo e(__('message.Select Specialist')); ?></option>
                                                   <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                      <option value="<?php echo e($dp->id); ?>" <?= isset($doctordata->department_id)&&$dp->id==$doctordata->department_id?'selected="selected"':""?> ><?php echo e($dp->name); ?></option>
                                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                             </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                <label><?php echo e(__('message.Email')); ?></label>
                                                <input type="email" name="email" placeholder="<?php echo e(__('message.Your email')); ?>" required="" id="email" value="<?php echo e(isset($doctordata->email)?$doctordata->email:''); ?>">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                <label><?php echo e(__('message.Phone no')); ?></label>
                                                <input type="text" name="phoneno" id="phoneno" placeholder="<?php echo e(__('message.Enter Phone No')); ?>" required="" value="<?php echo e(isset($doctordata->phoneno)?$doctordata->phoneno:''); ?>">
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                               <label for="consultation_fees"><?php echo e(__("message.consultation_fees")); ?><span class="reqfield">*</span></label>
                                               <input type="number" required name="consultation_fees" value="<?php echo e(isset($doctordata->consultation_fees)?$doctordata->consultation_fees:''); ?>" class="form-control" id="consultation_fees" min="1" step="0.01" >
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                                <label><?php echo e(__('message.Working Time')); ?></label>
                                                <input type="text" name="working_time" placeholder="<?php echo e(__('message.Enter Working Time')); ?>" required="" id="working_time" value="<?php echo e(isset($doctordata->working_time)?$doctordata->working_time:''); ?>">
                                            </div>


                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label><?php echo e(__('message.About Us')); ?></label>
                                                <textarea name="aboutus" id="aboutus" placeholder="<?php echo e(__('message.Enter About Doctor')); ?>"><?php echo e(isset($doctordata->aboutus)?$doctordata->aboutus:''); ?></textarea>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label><?php echo e(__('message.Services')); ?></label>
                                                <textarea name="services"  id
                                                ="services" placeholder="<?php echo e(__('message.Enter Description about Services')); ?>"><?php echo e(isset($doctordata->services)?$doctordata->services:''); ?></textarea>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label><?php echo e(__('message.Health Care')); ?></label>
                                                <textarea name="healthcare"  id="healthcare" placeholder="<?php echo e(__('message.Enter Health Care')); ?>"><?php echo e(isset($doctordata->healthcare)?$doctordata->healthcare:''); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 p-0"  id="addressorder">
                                          <label><?php echo e(__("message.Address")); ?><span class="reqfield">*</span></label>
                                          <input  type="text" id="us2-address" name="address" placeholder='<?php echo e(__("message.Search Location")); ?>' required data-parsley-required="true" required=""/>
                                       </div>
                                       <div class="map" id="maporder">
                                          <div class="form-group">
                                             <div class="col-md-12 p-0">
                                                <div id="us2"></div>
                                             </div>
                                          </div>
                                       </div>
                                           <input type="hidden" name="lat" id="us2-lat" value="<?php echo e(isset($doctordata->lat)?$doctordata->lat:$setting->map_lat); ?>" />
                                          <input type="hidden" name="lon" id="us2-lon" value="<?php echo e(isset($doctordata->lon)?$doctordata->lon:$setting->map_long); ?>" />

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

<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\rutik\live\bookappointment__medical\resources\views/user/doctor/editprofile.blade.php ENDPATH**/ ?>