<?php $__env->startSection('title'); ?>
 <?php echo e(__('Login By OTP')); ?>

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
                        <h1><?php echo e(__('message.Login By OTP')); ?></h1>
                    </div>
                </div>
            </div>
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('message.Home')); ?></a></li>
                        <li><?php echo e(__('message.Forgot Password')); ?></li>
                    </ul>
                </div>
            </div>
</section>-->

<div class="row">
<div class="col-lg-6 col-md-6 col-sm-12 col-12">
    <section class="registration-section bg-color-4" style="margin-top: -30px;">
                <div class="pattern">
                    <div class="pattern-1" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-85.png')); ?>');"></div>
                    <div class="pattern-2" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-86.png')); ?>');"></div>
                </div>
                <div class="auto-container">
                    <div class="inner-box">
                        <div class="content-box">
                            <div class="title-box">
                                <h3><?php echo e(__('Existing Client')); ?></h3>
                                <a href="<?php echo e(url('register_firsttimeuser')); ?>"><?php echo e(__('New Client?')); ?></a>
                            </div>
                            <div class="inner">
                            <!--<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link  active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                        role="tab" aria-controls="pills-home"
                                        aria-selected="true"><?php echo e(__('First Time Consultation User')); ?></a>
                                </li>
                            </ul>-->
                                <?php 
                                    if(isset($_REQUEST['msg'])){
                                        $msg=ucwords(str_replace("_"," ",$_REQUEST['msg']));
                                        ?>
                                            <h4><?=$msg?></h4>
                                        <?php
                                    }
                                ?>
                                <form action="<?php echo e(url('loginbyotpcontroller')); ?>" method="post" class="registration-form">
                                    <?php echo e(csrf_field()); ?>

                                    <div class="row clearfix">
                                        
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                            <label><?php echo e(__('message.Phone')); ?></label>
                                            <input type="text" name="phone" placeholder="<?php echo e(__('message.Enter Phone')); ?>" required="">
                                        </div>
                                    
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                            <button type="submit" class="theme-btn-one"><?php echo e(__('message.GET OTP')); ?><i class="icon-Arrow-Right"></i></button>
                                        </div>
                                    </div>
                                </form>
                                <div class="text"><span><?php echo e(__('message.or')); ?></span></div>
                            
                                <div class="login-now"><p><?php echo e(__('New to Berkowits?')); ?><a href="<?php echo e(url('register_firsttimeuser')); ?>"><?php echo e(__('Click Here')); ?></a></p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <section class="agent-section" style="background: aliceblue;">

    </section>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 col-12">
    <section class="registration-section bg-color-4" style="margin-top: -30px;">
    <div class="container">
        <h3  align='center'>Booking a service or appointment for the first time?</h3><hr />
        <div class="title"><h4 align='center' />Your First Step to Radiance Starts Here!</h4></div>
        <div class="description" align='center'>
            <p >At Berkowits, we believe in personalized care that helps you look and feel your best. Booking your first appointment is easy and quick. Let our expert team provide you with a tailored treatment plan that suits your needs.</p>
        </div>
        <div align='center'><br /><a href="<?php echo e(url('register_firsttimeuser')); ?>" class="theme-btn-one">Book Your First Appointment</a></div>
    </div>
    </section>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/user/patient/loginbyotp.blade.php ENDPATH**/ ?>