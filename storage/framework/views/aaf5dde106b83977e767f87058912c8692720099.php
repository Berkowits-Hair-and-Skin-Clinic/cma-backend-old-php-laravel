<?php $__env->startSection('title'); ?>
 
 <?php echo e(__('Profile Register')); ?>

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
                        <h1 id="aa"><?php echo e(__('message.Doctor Register')); ?></h1>
                    </div>
                </div>
            </div>
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="<?php echo e(url('/')); ?>"><?php echo e(__('message.Home')); ?></a></li>
                        <li id="aa1"><?php echo e(__('message.Doctor Register')); ?></li>
                    </ul>
                </div>
            </div>
</section>
<section class="registration-section bg-color-3">
            <div class="pattern">
                <div class="pattern-1" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-85.png')); ?>');"></div>
                <div class="pattern-2" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-86.png')); ?>');"></div>
            </div>
            <div class="auto-container">
                <div class="inner-box">
                    <div class="content-box">
                        <div class="title-box">
                            <h3 id="aa2"><?php echo e(__('message.Doctor Register')); ?></h3>
                            <a href="<?php echo e(url('profilelogin')); ?>"><?php echo e(__("message.Already a Profile?")); ?></a>
                        </div>
                        <div class="inner">
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
                             <div id="registererror">

                             </div>

                             <style>
                                .nav-pills .nav-item .nav-link.active {
                                    background-color:#ff9136;
                                    border-radius: 30px;
                                }
                            </style>
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link  active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                        role="tab" aria-controls="pills-home"
                                        aria-selected="true"><?php echo e(__('message.Doctors')); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                        role="tab" aria-controls="pills-profile"
                                        aria-selected="false"><?php echo e(__('message.Pharmacy')); ?></a>
                                </li>

                            </ul>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                    aria-labelledby="pills-home-tab">
                                    <form action="<?php echo e(url('postdoctorregister')); ?>" method="post" class="registration-form">
                                        <?php echo e(csrf_field()); ?>

                                         <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label class="fr" ><?php echo e(__('message.Name')); ?></label>
                                        <input type="text" id="name" name="name" placeholder="<?php echo e(__('message.Your name')); ?>" required="" />
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label class="fr"><?php echo e(__('message.Phone Number')); ?></label>
                                        <input type="text" name="phone" id="phone" placeholder="<?php echo e(__('message.Enter Your Phone number')); ?>" required="" />
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label class="fr"><?php echo e(__('message.Email')); ?></label>
                                        <input type="email" name="email" id="email" placeholder="<?php echo e(__('message.Your email')); ?>" required="" />
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label class="fr"><?php echo e(__('message.Password')); ?></label>
                                        <input type="password" name="password" id="pwd" placeholder="<?php echo e(__('message.Enter password')); ?>" required="" />
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label class="fr"><?php echo e(__('message.Confirm password')); ?></label>
                                        <input type="password" name="cpassword" id="cpwd" onchange="checkbothpassword(this.value)" placeholder="<?php echo e(__('message.Enter Confirm password')); ?>" required="" />
                                        <span id="cpwd_error" style="color: red" ></span>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <div class="custom-check-box fr">
                                            <div class="custom-controls-stacked">
                                                <label class="custom-control ">
                                                    <input type="checkbox" class="material-control-input" name="agree" value="1" required="" />
                                                    <span class="material-control-indicator"></span>
                                                     <span class="description"><?php echo e(__('message.I accept')); ?> <a href="<?php echo e(url('/')); ?>"><?php echo e(__('message.terms')); ?></a> <?php echo e(__('message.and')); ?> <a href="<?php echo e(url('/')); ?>"><?php echo e(__('message.conditions')); ?></a> <?php echo e(__('message.and general policy')); ?></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                        <button type="submit" class="theme-btn-one"><?php echo e(__('message.Register Now')); ?><i class="icon-Arrow-Right"></i></button>
                                    </div>
                                </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                    aria-labelledby="pills-profile-tab">
                                    <form action="<?php echo e(url('postpharmacyregister')); ?>" method="post" class="registration-form">
                                        <?php echo e(csrf_field()); ?>

                                         <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label class="fr" ><?php echo e(__('message.Name')); ?></label>
                                                <input type="text" id="name" name="name" placeholder="<?php echo e(__('message.Your name')); ?>" required="" />
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label class="fr"><?php echo e(__('message.Phone Number')); ?></label>
                                                <input type="text" name="phone" id="phone" placeholder="<?php echo e(__('message.Enter Your Phone number')); ?>" required="" />
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label class="fr"><?php echo e(__('message.Email')); ?></label>
                                                <input type="email" name="email" id="email" placeholder="<?php echo e(__('message.Your email')); ?>" required="" />
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label class="fr"><?php echo e(__('message.Password')); ?></label>
                                                <input type="password" name="password" id="pwd1" placeholder="<?php echo e(__('message.Enter password')); ?>" required="" />
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <label class="fr"><?php echo e(__('message.Confirm password')); ?></label>
                                                <input type="password" name="cpassword" id="cpwd1" onchange="checkbothpassword1(this.value)" placeholder="<?php echo e(__('message.Enter Confirm password')); ?>" required="" />
                                                <span id="cpwd_error1" style="color: red" ></span>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                                <div class="custom-check-box fr">
                                                    <div class="custom-controls-stacked">
                                                        <label class="custom-control ">
                                                            <input type="checkbox" class="material-control-input" name="agree" value="1" required="" />
                                                            <span class="material-control-indicator"></span>
                                                            <span class="description"><?php echo e(__('message.I accept')); ?> <a href="<?php echo e(url('/')); ?>"><?php echo e(__('message.terms')); ?></a> <?php echo e(__('message.and')); ?> <a href="<?php echo e(url('/')); ?>"><?php echo e(__('message.conditions')); ?></a> <?php echo e(__('message.and general policy')); ?></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                                <button type="submit" class="theme-btn-one"><?php echo e(__('message.Register Now')); ?><i class="icon-Arrow-Right"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>


                            <div class="text"><span><?php echo e(__('message.or')); ?></span></div>

                            <div class="login-now"><p><?php echo e(__('message.Already have an account')); ?> <a href="<?php echo e(url('profilelogin')); ?>"><?php echo e(__('message.Login Now')); ?></a></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
       <section class="agent-section" style="background: aliceblue;">
   <div class="auto-container">
      <div class="inner-container bg-color-2">
         <div class="row clearfix">
            <div class="col-lg-6 col-md-12 col-sm-12 left-column">
               <div class="content_block_3">
                  <div class="content-box">
                     <h3><?php echo e(__('message.Emergency call')); ?></h3>
                     <div class="support-box">
                        <div class="icon-box"><i class="fas fa-phone"></i></div>
                        <span><?php echo e(__('message.Telephone')); ?></span>
                        <h3><a href="tel:<?php echo e($setting->phone); ?>"><?php echo e($setting->phone); ?></a></h3>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 right-column">
               <div class="content_block_4">
                  <div class="content-box">
                     <h3><?php echo e(__('message.Sign up for Newsletter today')); ?></h3>
                     <form action="#" method="post" class="subscribe-form">
                        <div class="form-group">
                           <input type="email" name="email" id="emailnews" placeholder="<?php echo e(__('message.Your email')); ?>" required="">
                           <button type="button" onclick="addnewsletter()" class="theme-btn-one"><?php echo e(__('message.Submit now')); ?><i class="icon-Arrow-Right"></i></button>
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
    function handleClick(event) {
        // Prevent the default action of the link
        event.preventDefault();

        // Get the text content of the clicked link
        var clickedText = event.target.textContent;

        // Log the text content
        console.log(clickedText);
        $('#aa').text(clickedText + ' <?php echo e(__("message.Register Now")); ?>');
        $('#aa1').text(clickedText + ' <?php echo e(__("message.Register Now")); ?>');
        $('#aa2').text(clickedText + ' <?php echo e(__("message.Register Now")); ?>');
    }
    document.getElementById("pills-home-tab").addEventListener("click", handleClick);
    document.getElementById("pills-profile-tab").addEventListener("click", handleClick);



    function checkbothpassword(value){
   var pwd=$("#pwd").val();
   if(pwd!=value){
       var txt=$("#pwdmatch").val();
       $("#cpwd_error").html(txt);
       $("#cpwd").val("");
   }
}

function checkbothpassword1(value){
   var pwd=$("#pwd1").val();
   if(pwd!=value){
       var txt=$("#pwdmatch").val();
       $("#cpwd_error1").html(txt);
       $("#cpwd1").val("");
   }
}

</script>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/freakd1c/public_html/demo/bookappointment/resources/views/user/doctor/register.blade.php ENDPATH**/ ?>