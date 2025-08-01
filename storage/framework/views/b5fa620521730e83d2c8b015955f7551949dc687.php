
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="<?php echo e(Session::get('favicon')); ?>" rel="icon">
  <title><?php echo e(__("message.Log In")); ?> | <?php echo e($setting->title); ?></title>
  <link href="<?php echo e(asset('public/admin')); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo e(asset('public/admin')); ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo e(asset('public/admin')); ?>/css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
        <div class="col-lg-12 mt-5 pt-2">
            <div class="text-center">
               <img src="<?php echo e(Session::get('logo')); ?>" alt="" height="50" class="logo logo-dark" />
            </div>
         </div>
      <div class="col-xl-4 col-lg-6 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                    <?php if(Session::has('message')): ?>
                        <div class="col-sm-12">
                           <div class="alert  <?php echo e(Session::get('alert-class', 'alert-danger')); ?> alert-dismissible fade show" role="alert">
                              <?php echo e(Session::get('message')); ?>

                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                        </div>
                        <?php endif; ?>
                  <div class="text-center">
                    
                    <h1 class="h4 text-gray-900 mb-4"><?php echo e(__("message.Sign in to continue to Admin")); ?></h1>
                  </div>
                  <form action="<?php echo e(url('admin/postlogin')); ?>" method="post">
                    <?php echo e(csrf_field()); ?>

                    <div class="form-group">
                      <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                        placeholder='<?php echo e(__("message.Enter Email Address")); ?>' value="<?php echo e($email); ?>" name="email" required>
                    </div>
                    <div class="form-group">
                      <input type="password"  name="password" class="form-control" id="exampleInputPassword" value="<?php echo e($pass); ?>" placeholder='<?php echo e(__("message.Enter password")); ?>' required>
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck"><?php echo e(__('message.Remember me')); ?></label>
                      </div>
                    </div>
                    <div class="form-group">
                      <button class="btn btn-primary btn-block" type="submit"><?php echo e(__('message.Log In')); ?></button>
                    </div>
                    <hr>
                  </form>
                  <div class="text-center">

                  </div>
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 mt-5">
            <div class="text-center">
                <p>© <?php echo e(date('Y')); ?> <?php echo e(__("message.System Name")); ?> <i class="mdi mdi-heart text-danger"></i> <?php echo e(__("message.by Admin Panel")); ?></p>
            </div>
         </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="<?php echo e(asset('public/admin')); ?>/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo e(asset('public/admin')); ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo e(asset('public/admin')); ?>/vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?php echo e(asset('public/admin')); ?>/js/ruang-admin.min.js"></script>
</body>

</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-admin/resources/views/admin/login.blade.php ENDPATH**/ ?>