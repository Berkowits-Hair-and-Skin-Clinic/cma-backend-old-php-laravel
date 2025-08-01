  
  <?php $__env->startSection('title'); ?>
      <?php echo e(__('message.My Subscription')); ?>

  <?php $__env->stopSection(); ?>
  <?php $__env->startSection('meta-data'); ?>
      <meta property="og:type" content="website" />
      <meta property="og:url" content="<?php echo e(__('message.System Name')); ?>" />
      <meta property="og:title" content="<?php echo e(__('message.System Name')); ?>" />
      <meta property="og:image" content="<?php echo e(asset('public/image_web/') . '/' . $setting->favicon); ?>" />
      <meta property="og:image:width" content="250px" />
      <meta property="og:image:height" content="250px" />
      <meta property="og:site_name" content="<?php echo e(__('message.System Name')); ?>" />
      <meta property="og:description" content="<?php echo e(__('message.meta_description')); ?>" />
      <meta property="og:keyword" content="<?php echo e(__('message.Meta Keyword')); ?>" />
      <link rel="shortcut icon" href="<?php echo e(asset('public/image_web/') . '/' . $setting->favicon); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $__env->stopSection(); ?>
  <?php $__env->startSection('content'); ?>
      <style>
          .boxed label {
              display: inline-block;
              width: 200px;
              padding: 10px;
              border: solid 2px #ccc;
              transition: all 0.3s;
          }

          .boxed input[type="radio"] {
              display: none;
          }

          .boxed input[type="radio"]:checked+label {
              border: solid 2px green;
          }
      </style>
      <section class="page-title-two">
          <div class="title-box centred bg-color-2">
              <div class="pattern-layer">
                  <div class="pattern-1"
                      style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-70.png')); ?>');">
                  </div>
                  <div class="pattern-2"
                      style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-71.png')); ?>');">
                  </div>
              </div>
              <div class="auto-container">
                  <div class="title">
                      <h1><?php echo e(__('message.My Subscription')); ?></h1>
                  </div>
              </div>
          </div>
          <div class="lower-content">
              <ul class="bread-crumb clearfix">
                  <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('message.Home')); ?></a></li>
                  <li><?php echo e(__('message.My Subscription')); ?></li>
              </ul>
          </div>
      </section>
      <section class="doctors-dashboard bg-color-3">
          <div class="left-panel">
              <div class="profile-box">
                  <div class="upper-box">
                      <figure class="profile-image">
                          <?php if($doctordata->image != ''): ?>
                              <img src="<?php echo e(asset('public/upload/doctors') . '/' . $doctordata->image); ?>" alt="">
                          <?php else: ?>
                              <img src="<?php echo e(asset('public/front_pro/assets/images/resource/profile-2.png')); ?>" alt="">
                          <?php endif; ?>
                      </figure>
                      <div class="title-box centred">
                          <div class="inner">
                              <h3><?php echo e($doctordata->name); ?></h3>
                              <p><?php echo e(isset($doctordata->departmentls) ? $doctordata->departmentls->name : ''); ?></p>
                          </div>
                      </div>
                  </div>
                  <div class="profile-info">
                      <ul class="list clearfix">
                          <li><a href="<?php echo e(url('doctordashboard')); ?>"><i
                                      class="fas fa-columns"></i><?php echo e(__('message.Dashboard')); ?></a></li>
                          <li><a href="<?php echo e(url('doctorappointment')); ?>"><i
                                      class="fas fa-calendar-alt"></i><?php echo e(__('message.Appointment')); ?></a></li>
                          <li><a href="<?php echo e(url('doctortiming')); ?>"><i
                                      class="fas fa-clock"></i><?php echo e(__('message.Schedule Timing')); ?></a></li>
                          <li><a href="<?php echo e(url('doctorreview')); ?>"><i class="fas fa-star"></i><?php echo e(__('message.Reviews')); ?></a>
                          </li>
                          <li><a href="<?php echo e(url('doctor_hoilday')); ?>"><i
                                      class="fas fa-star"></i><?php echo e(__('message.My Hoilday')); ?></a></li>
                          <li><a href="<?php echo e(url('doctoreditprofile')); ?>"><i
                                      class="fas fa-user"></i><?php echo e(__('message.My Profile')); ?></a></li>
                          <li><a href="<?php echo e(url('paymenthistory')); ?>"><i
                                      class="fas fa-user"></i><?php echo e(__('message.Payment History')); ?></a></li>
                          <li><a href="<?php echo e(url('mysubscription')); ?>" class="current"><i
                                      class="fas fa-rocket"></i><?php echo e(__('message.My Subscription')); ?></a></li>
                          <li><a href="<?php echo e(url('doctorchangepassword')); ?>"><i
                                      class="fas fa-unlock-alt"></i><?php echo e(__('message.Change Password')); ?></a></li>
                          <li><a href="<?php echo e(url('logout')); ?>"><i
                                      class="fas fa-sign-out-alt"></i><?php echo e(__('message.Logout')); ?></a></li>
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
                                  <h3><?php echo e(__('message.My Subscription')); ?></h3>
                              </div>
                              <div class="inner-box">
                                  <?php if(Session::has('message')): ?>
                                      <div class="col-sm-12">
                                          <div class="alert  <?php echo e(Session::get('alert-class', 'alert-info')); ?> alert-dismissible fade show"
                                              role="alert">
                                              <?php echo e(Session::get('message')); ?>

                                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                      </div>
                                  <?php endif; ?>
                                  <div class="row g-2">
                                      <?php $__currentLoopData = $mysubscriptionlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $mysubscriptionlist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <div class="col-4 p-4">
                                              <div class="row justify-content-between"
                                                  style="background-color: #f3eae2;border-radius: 10px;">
                                                  <div class="col-9 my-3">
                                                      <h4><?php echo e(__('message.Plan Details')); ?></h4>
                                                      <b>$<?php echo e($mysubscriptionlist->amount); ?>/<?php echo e($mysubscriptionlist->subscription_id); ?>

                                                          <?php echo e(__('message.month')); ?> </b></br>

                                                      <span><i class="far fa-calendar-alt"></i>
                                                          <?php echo e(\Carbon\Carbon::parse($mysubscriptionlist->date)->format('Y-m-d')); ?></span><br>
                                                      </b><?php echo e(__('message.Payment Type')); ?> : </b>
                                                      <?php if($mysubscriptionlist->payment_type == 1): ?>
                                                          <?php echo e(__('message.Braintree')); ?>

                                                      <?php elseif($mysubscriptionlist->payment_type == 2): ?>
                                                          <?php echo e(__('message.Bank Deposit')); ?>

                                                      <?php elseif($mysubscriptionlist->payment_type == 3): ?>
                                                          <?php echo e(__('message.Razorpay')); ?>

                                                      <?php elseif($mysubscriptionlist->payment_type == 4): ?>
                                                          <?php echo e(__('message.Paystack')); ?>

                                                      <?php elseif($mysubscriptionlist->payment_type == 5): ?>
                                                          <?php echo e(__('message.Stripe')); ?>

                                                      <?php endif; ?>
                                                      </br>
                                                  </div>
                                                  <div class="col-3  mt-4">
                                                      <span>
                                                          <?php if($index == 0): ?>
                                                              <?php if($mysubscriptionlist->status == '1'): ?>
                                                                  <span style="padding: 5px;border-radius: 5px;"
                                                                      class="btn btn-warning"><?php echo e(__('message.Not Active')); ?></span>
                                                              <?php elseif($mysubscriptionlist->status == '2'): ?>
                                                                  <span style="padding: 5px;border-radius: 5px;"
                                                                      class="btn btn-success"><?php echo e(__('message.Active')); ?></span>
                                                              <?php else: ?>
                                                                  <span style="padding: 5px;border-radius: 5px;"
                                                                      class="btn btn-danger"><?php echo e(__('message.Expired')); ?></span>
                                                              <?php endif; ?>
                                                          <?php else: ?>
                                                          <span style="padding: 5px;border-radius: 5px;"
                                                          class="btn btn-danger"><?php echo e(__('message.Expired')); ?></span>
                                                          <?php endif; ?>

                                                      </span>
                                                  </div>
                                              </div>

                                          </div>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  </div>
                              </div>
                          </div>

                          <div class="single-box add_css" style="display:none; margin-top:20xp;">
                              <div class="title-box">
                                  <h3><?php echo e(__('message.Subscription List')); ?></h3>
                              </div>
                              <div class="inner-box">
                                  <?php if(Session::has('message')): ?>
                                      <div class="col-sm-12">
                                          <div class="alert  <?php echo e(Session::get('alert-class', 'alert-info')); ?> alert-dismissible fade show"
                                              role="alert">
                                              <?php echo e(Session::get('message')); ?>

                                              <button type="button" class="close" data-dismiss="alert"
                                                  aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                      </div>
                                  <?php endif; ?>


                              </div>

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

<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/user/doctor/mysubscription.blade.php ENDPATH**/ ?>