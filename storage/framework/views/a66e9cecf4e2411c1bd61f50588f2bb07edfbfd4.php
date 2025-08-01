<head>
           <link href="<?php echo e(asset('public/front_pro/assets/css/style.css?v=fgfdgf')); ?>" rel="stylesheet">
           <link href="<?php echo e(asset('public/front_pro/assets/css/bootstrap.css')); ?>" rel="stylesheet">
      <link href="<?php echo e(asset('public/front_pro/assets/css/jquery.fancybox.min.css')); ?>" rel="stylesheet">
      <link href="<?php echo e(asset('public/front_pro/assets/css/animate.css')); ?>" rel="stylesheet">
      <link href="<?php echo e(asset('public/front_pro/assets/css/color.css')); ?>" rel="stylesheet">
</head>

<section class="registration-section bg-color-3">
            <div class="pattern">
                <div class="pattern-1" style="background-image: url('https://healthdrfinder.co.za/doctorfinder/public/front_pro/assets/images/shape/shape-85.png');"></div>
                <div class="pattern-2" style="background-image: url('https://healthdrfinder.co.za/doctorfinder/public/front_pro/assets/images/shape/shape-86.png');"></div>
            </div>
            <div class="auto-container">
                <div class="inner-box">
                    <div class="content-box">
                        <div class="title-box">
                            <h3>Reset Password</h3>
                           
                        </div>
                        <div class="inner">
                           <form action="<?php echo e(url('resetnewpwd')); ?>" method="post" class="registration-form">
                                 <?php echo e(csrf_field()); ?>

                                 <input type="hidden" name="code" value="<?php echo e($code ?? ''); ?>" />
                                 <input type="hidden" name="id" value="<?php echo e($id ?? ''); ?>" />
                                 <input type="hidden" name="type" value="<?php echo e($type ?? ''); ?>" />
                                <div class="row clearfix">
                                    
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label>Enter New Password</label>
                                        <input type="password" name="npwd" id="npwd" placeholder="Enter New Password" required="">
                                    </div>
                                     <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label>Enter Re Enter New Password</label>
                                        <input type="password" name="rpwd" id="rpwd" placeholder="Enter Re Enter New Password" required="">
                                    </div>
                                   
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                        <button type="submit" class="theme-btn-one">Reset Password<i class="icon-Arrow-Right"></i></button>
                                    </div>
                                </div>
                            </form>
                                                        
                        </div>
                    </div>
                </div>
            </div>
        </section><?php /**PATH /home2/freakd1c/public_html/demo/bookappointment/resources/views/user/resetpwd.blade.php ENDPATH**/ ?>