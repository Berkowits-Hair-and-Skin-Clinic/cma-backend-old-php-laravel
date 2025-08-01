<?php $__env->startSection('title'); ?>
    <?php echo e(__('Appointment Details')); ?>

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
    <!--<section class="page-title-two">
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
                    <h1><?php echo e(__('message.Medicine Order')); ?></h1>
                </div>
            </div>
        </div>
        <div class="lower-content">
            <ul class="bread-crumb clearfix">
                <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('message.Home')); ?></a></li>
                <li><?php echo e(__('message.Medicine Order')); ?></li>
            </ul>
        </div>
    </section>-->
    <section class="patient-dashboard bg-color-3">
        <div class="left-panel">
            <div class="profile-box patient-profile">
                <div class="upper-box">
                    <figure class="profile-image">
                        <?php if(isset($userdata) && $userdata->profile_pic != ''): ?>
                            <img src="<?php echo e(asset('public/upload/profile') . '/' . $userdata->profile_pic); ?>" alt="">
                        <?php else: ?>
                            <img src="<?php echo e(asset('public/upload/profile/profile.png')); ?>" alt="">
                        <?php endif; ?>
                    </figure>
                    <div class="title-box centred">
                        <div class="inner">
                            <h3><?php echo e(isset($userdata->name) ? $userdata->name : ''); ?></h3>
                            <p><i class="fas fa-envelope"></i><?php echo e(isset($userdata->email) ? $userdata->email : ''); ?></p>
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
            <a style="height: 50px;float:right;"  href="<?php echo e(url('userappointmentdashboard?type=3')); ?>" class="theme-btn-one"><?php echo e(__('Back')); ?> <i class="icon-Arrow-Left"></i></a><br />
            <div class="content-container">
                <div class="outer-container">
                    <div class="doctors-appointment">
                    <div class="title-box" style="margin-bottom: -50px;">
                        <h3>Appointment Details</h3><hr />
                        <?php //var_dump($appointmentDetail[0]['guest']) ?>
                    </div>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-lg-6 col-md-6 feature-block">
                                <div class="title-box">
                                    <h3>Client Details</h3>
                                    <?php //var_dump($appointmentDetail[0]['guest']) ?>
                                </div>
                                <div class="row" style="background-color: #ffffff;padding:20px;margin-top:-60px">
                                    <div class="col-xs-6 col-lg-3 col-md-3">
                                        <label>Name:</label><br />
                                        <label>Phone:</label><br />
                                        <label>Email:</label><br />

                                    </div>
                                    <div class="col-xs-6 col-lg-9 col-md-9">
                                        <label><?php echo e($appointmentDetail[0]['guest']['first_name']." ".$appointmentDetail[0]['guest']['last_name']); ?></label>
                                        <br /><label><?php echo e($appointmentDetail[0]['guest']['mobile']['display_number']); ?></label>
                                        <br /><label><?php echo e($appointmentDetail[0]['guest']['email']); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-6 col-md-6 feature-block">
                                <div class="title-box">
                                    <h3>Service Details</h3>
                                    <?php //var_dump($appointmentDetail[0]['service']) ?>
                                </div>
                                <div class="row" style="background-color: #ffffff;padding:20px;margin-top:-60px">
                                    <div class="col-xs-6 col-lg-6 col-md-6">
                                        <label>Service Name:</label><br /><br />
                                        <label>Category:</label><br />
                                        <label>Sub Category:</label><br />
                                    </div>
                                    <div class="col-xs-6 col-lg-6 col-md-6">
                                        <label><?php echo e($appointmentDetail[0]['service']['name']); ?></label>
                                        <br /><label><?php echo e($appointmentDetail[0]['service']['category']['name']); ?></label>
                                        <br /><label><?php echo e($appointmentDetail[0]['service']['sub_category']['name']); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-6 col-md-6 feature-block">
                                <div class="title-box">
                                    <h3>Therapist Details</h3>
                                    <?php //var_dump($appointmentDetail[0]['therapist']) ?>
                                </div>
                                <div class="row" style="background-color: #ffffff;padding:20px;margin-top:-60px">
                                    <div class="col-xs-6 col-lg-3 col-md-3">
                                        <label>Name:</label><br />
                                        <label>Email:</label><br />
                                    </div>
                                    <div class="col-xs-6 col-lg-9 col-md-9">
                                        <label><?php echo e($appointmentDetail[0]['therapist']['first_name']." ".$appointmentDetail[0]['therapist']['last_name']); ?></label>
                                        <br /><label><?php echo e($appointmentDetail[0]['therapist']['email']); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-6 col-md-6 feature-block" style="background-color: #ffffff;padding:20px;">
                                <div class="title-box">
                                    <h3>Price</h3>
                                    <?php //var_dump($appointmentDetail[0]['price']) ?>
                                </div>
                                <div class="row" style="background-color: #ffffff;padding:20px;margin-top:-60px">
                                    <div class="col-xs-6 col-lg-4 col-md-4">
                                        <label>Price:</label><br />
                                    </div>
                                    <div class="col-xs-6 col-lg-8 col-md-8">
                                        <label><?php echo e($appointmentDetail[0]['price']['final']); ?></label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-lg-12 col-md-12 feature-block" style="background-color: #ffffff;padding:20px;">
                                <div class="title-box">
                                    <h3>Other Details</h3>
                                    <?php //var_dump($appointmentDetail[0]['price']) ?>
                                </div>
                                <div class="row" style="background-color: #ffffff;padding:20px;margin-top:-60px">
                                    <div class="col-xs-6 col-lg-4 col-md-4">
                                        <!-- <label>Appointment id </label><br /> -->
                                        <label>start_time:</label><br />
                                        <label>end_time:</label><br />
                                        <label>status:</label><br />
                                        <label>creation_date:</label><br />
                                        <!-- <label>created_by_id:</label><br /> -->
                                    </div>
                                    <div class="col-xs-6 col-lg-8 col-md-8">
                                        <?php 
                                            $start_time_array=explode("T",$appointmentDetail[0]['start_time']);
                                            $start_time=$start_time_array[0]." ".$start_time_array[1];
                                            $end_time_array=explode("T",$appointmentDetail[0]['end_time']);
                                            $end_time=$end_time_array[0]." ".$end_time_array[1];
                                            $created_time_array=explode("T",$appointmentDetail[0]['creation_date']);
                                            $created_time=$created_time_array[0]." ".$created_time_array[1];
                                        ?>
                                        <!-- <label><?php echo e($appointmentDetail[0]['appointment_id']); ?></label> -->
                                        <label><?php echo e($start_time); ?></label>
                                        <br /><label><?php echo e($end_time); ?></label>
                                        <br /><label><?php echo e($appointmentDetail[0]['status']); ?></label>
                                        <br /><label><?php echo e($created_time); ?></label>
                                        <!-- <br /><label><?php echo e($appointmentDetail[0]['created_by_id']); ?></label> -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->

        <input type="hidden" id="path_admin" value="<?php echo e(url('/')); ?>">

        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                let table = new DataTable('#myTable', {
                    order: [
                        [0, 'desc']
                    ]
                });
            });
        </script>


    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/user/patient/appointmentdetail.blade.php ENDPATH**/ ?>