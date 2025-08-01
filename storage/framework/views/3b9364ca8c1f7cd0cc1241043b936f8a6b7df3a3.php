<?php $__env->startSection('title'); ?>
    <?php echo e(__('message.Setting')); ?> | <?php echo e(__('message.Admin')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-data'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="container-fluid" style="margin-bottom: 15%;">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"> <?php echo e(__('message.Setting')); ?></h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active"> <?php echo e(__('message.Setting')); ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <?php if(Session::has('message')): ?>
                            <div class="col-sm-12">
                                <div class="alert  <?php echo e(Session::get('alert-class', 'alert-info')); ?> alert-dismissible fade show"
                                    role="alert"><?php echo e(Session::get('message')); ?>

                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        <?php endif; ?>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true"><?php echo e(__('message.Admin')); ?>

                                    <?php echo e(__('message.Basic Details')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false"><?php echo e(__('message.Basic Details')); ?></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                                    aria-controls="contact" aria-selected="false"><?php echo e(__('message.Upload Section')); ?></a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <form action="<?php echo e(url('admin/updatesettingfour')); ?>" method="post"
                                    enctype="multipart/form-data">
                                    <?php echo e(csrf_field()); ?>


                                    <div class="form-group">
                                        <label for="verti-nav-phoneno-input"><?php echo e(__('message.Commission')); ?></label>
                                        <input type="number" required name="commission"
                                            value="<?php echo e(isset($data->commission) ? $data->commission : ''); ?>"
                                            class="form-control" id="verti-nav-phoneno-input" min="1" step="0.01"
                                            max="100">
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class=" form-control-label">
                                            <?php echo e(__('message.timezone')); ?>

                                            <span class="reqfield">*</span>
                                        </label>
                                        <select class="form-control" name="timezone" id="timezone" required="">
                                            <option value=""><?php echo e(__('messages.select_timezone')); ?></option>
                                            <?php $__currentLoopData = $timezone; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tz => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($tz); ?>"
                                                    <?= $data->timezone == $tz ? ' selected="selected"' : '' ?>>
                                                    <?php echo e($value); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class=" form-control-label">
                                            <?php echo e(__('message.currency')); ?>

                                            <span class="reqfield">*</span>
                                        </label>
                                        <select class="form-control" name="currency" id="currency" required="">
                                            <option value="<?php echo e($data->currency); ?>" selected><?php echo e($data->currency); ?>

                                            </option>
                                            <?php echo $__env->make('admin.currency', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label
                                                    for="verti-nav-phoneno-input"><?php echo e(__('message.Pharmacy Tax')); ?>(%)</label>
                                                <input type="number" required name="pharmacy_tax"
                                                    value="<?php echo e(isset($data->pharmacy_tax) ? $data->pharmacy_tax : ''); ?>"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label
                                                    for="verti-nav-phoneno-input"><?php echo e(__('message.Pharmacy Delivery Charge')); ?></label>
                                                <input type="number" required name="pharmacy_delivery_charge"
                                                    value="<?php echo e(isset($data->pharmacy_delivery_charge) ? $data->pharmacy_delivery_charge : ''); ?>"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label
                                                    for="verti-nav-phoneno-input"><?php echo e(__('message.map_api_key')); ?></label>
                                                <input type="text" required name="map_api_key"
                                                    value="<?php echo e(isset($data->map_api_key) ? $data->map_api_key : ''); ?>"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label
                                                    for="verti-nav-phoneno-input"><?php echo e(__('message.latitude')); ?></label>
                                                <input type="text" required name="map_lat"
                                                    value="<?php echo e(isset($data->map_lat) ? $data->map_lat : ''); ?>"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label
                                                    for="verti-nav-phoneno-input"><?php echo e(__('message.longitude')); ?></label>
                                                <input type="text" required name="map_long"
                                                    value="<?php echo e(isset($data->map_long) ? $data->map_long : ''); ?>"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="verti-nav-phoneno-input"><?php echo e(__('message.admin_theme_color')); ?></label>
                                                    <input type="color" required name="admin_theme_color"
                                                    value="<?php echo e(isset($data->admin_theme_color) ? $data->admin_theme_color : ''); ?>"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="verti-nav-phoneno-input"><?php echo e(__('message.web_theme_color')); ?></label>
                                                    <input type="color" required name="web_theme_color"
                                                    value="<?php echo e(isset($data->web_theme_color) ? $data->web_theme_color : '#ff9136'); ?>"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="verti-nav-phoneno-input"><?php echo e(__('message.web_box_shadow')); ?></label>
                                                    <input type="color" required name="web_box_shadow"
                                                    value="<?php echo e(isset($data->web_box_shadow) ? $data->web_box_shadow : '#ffe7d1'); ?>"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="verti-nav-phoneno-input"><?php echo e(__('message.web_bg_light')); ?></label>
                                                    <input type="color" required name="web_bg_light"
                                                    value="<?php echo e(isset($data->web_bg_light) ? $data->web_bg_light : '#f3eae2'); ?>"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="verti-nav-phoneno-input"><?php echo e(__('message.web_bg_dark')); ?></label>
                                                    <input type="color" required name="web_bg_dark"
                                                    value="<?php echo e(isset($data->web_bg_dark) ? $data->web_bg_dark : '#ffe0c5'); ?>"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="verti-nav-phoneno-input"><?php echo e(__('message.web_bg_black')); ?></label>
                                                    <input type="color" required name="web_bg_black"
                                                    value="<?php echo e(isset($data->web_bg_black) ? $data->web_bg_black : '#323232'); ?>"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="formrow-customCheck"
                                                name="doctor_approved" value="1"
                                                <?= isset($data->doctor_approved) && $data->doctor_approved == '1' ? 'checked="checked"' : '' ?>>
                                            <label class="custom-control-label"
                                                for="formrow-customCheck"><?php echo e(__('message.You Need To Approve Doctors Profile')); ?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                id="formrow-customCheck11"
                                                <?= isset($data->is_rtl) && $data->is_rtl == '1' ? 'checked="checked"' : '' ?>
                                                name="is_rtl" value="2">
                                            <label class="custom-control-label"
                                                for="formrow-customCheck11"><?php echo e(__('message.Is RTL')); ?></label>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <?php if(Session::get('is_demo') == '0'): ?>
                                            <button type="button" onclick="disablebtn()"
                                                class="btn btn-primary"><?php echo e(__('message.Submit')); ?></button>
                                        <?php else: ?>
                                            <button class="btn btn-primary" type="submit"
                                                value="Submit"><?php echo e(__('message.Submit')); ?></button>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <form action="<?php echo e(url('admin/updatesettingone')); ?>" method="post"
                                    enctype="multipart/form-data">
                                    <?php echo e(csrf_field()); ?>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="verti-nav-phoneno-input"><?php echo e(__('message.Phone')); ?></label>
                                                <input type="text" required name="phone"
                                                    value="<?php echo e(isset($data->phone) ? $data->phone : ''); ?>"
                                                    class="form-control" id="verti-nav-phoneno-input">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="verti-nav-email-input"><?php echo e(__('message.Email')); ?></label>
                                                <input type="email" required="" name="email"
                                                    value="<?php echo e(isset($data->email) ? $data->email : ''); ?>"
                                                    class="form-control" id="verti-nav-email-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="verti-nav-address-input"><?php echo e(__('message.Address')); ?></label>
                                                <textarea id="verti-nav-address-input" required name="address" id="address" class="form-control" rows="2"> <?php echo e(isset($data->address) ? $data->address : ''); ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="verti-nav-phoneno-input"><?php echo e(__('message.App Store URL')); ?></label>
                                        <input type="text" required name="app_url"
                                            value="<?php echo e(isset($data->app_url) ? $data->app_url : ''); ?>"
                                            class="form-control" id="verti-nav-phoneno-input">
                                    </div>
                                    <div class="form-group">
                                        <label for="verti-nav-phoneno-input"><?php echo e(__('message.Play Store URL')); ?></label>
                                        <input type="text" required name="playstore_url"
                                            value="<?php echo e(isset($data->playstore_url) ? $data->playstore_url : ''); ?>"
                                            class="form-control" id="verti-nav-phoneno-input">
                                    </div>

                                    <div class="mt-4">
                                        <?php if(Session::get('is_demo') == '0'): ?>
                                            <button type="button" onclick="disablebtn()"
                                                class="btn btn-primary"><?php echo e(__('message.Submit')); ?></button>
                                        <?php else: ?>
                                            <button type="submit"
                                                class="btn btn-primary w-md"><?php echo e(__('message.Submit')); ?></button>
                                        <?php endif; ?>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <form action="<?php echo e(url('admin/updatesettingtwo')); ?>" method="post"
                                    enctype="multipart/form-data">
                                    <?php echo e(csrf_field()); ?>


                                    <div class="form-group">
                                        <label for="verti-nav-pancard-input"><?php echo e(__('message.Name')); ?></label>
                                        <?php if(isset($data->title)): ?>
                                            <input type="text" class="form-control" value="<?php echo e($data->title); ?>"
                                                name="title">
                                        <?php else: ?>
                                            <input type="text" class="form-control" name="title" required="">
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="verti-nav-pancard-input"><?php echo e(__('message.Main Banner')); ?></label>
                                        <?php if(isset($data->main_banner)): ?>
                                            <img src="<?php echo e(asset('public/image_web') . '/' . $data->main_banner); ?>"
                                                style="width: 150px;height: 150px">
                                            <input type="file" class="form-control" id="verti-nav-pancard-input"
                                                name="main_banner">
                                        <?php else: ?>
                                            <input type="file" class="form-control" name="main_banner"
                                                id="verti-nav-pancard-input" required="">
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="verti-nav-vatno-input"><?php echo e(__('message.Favicon')); ?></label>
                                        <?php if(isset($data->favicon)): ?>
                                            <img src="<?php echo e(asset('public/image_web') . '/' . $data->favicon); ?>">
                                            <input type="file" class="form-control" id="verti-nav-pancard-input"
                                                name="favicon">
                                        <?php else: ?>
                                            <input type="file" class="form-control" name="favicon"
                                                id="verti-nav-pancard-input" required="">
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="verti-nav-cstno-input"><?php echo e(__('message.LOGO')); ?></label>
                                        <?php if(isset($data->logo)): ?>
                                            <img src="<?php echo e(asset('public/image_web') . '/' . $data->logo); ?>"
                                                style="width: 250px;">
                                            <input type="file" class="form-control" id="verti-nav-pancard-input"
                                                name="logo">
                                        <?php else: ?>
                                            <input type="file" class="form-control" name="logo"
                                                id="verti-nav-pancard-input" required="">
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="verti-nav-servicetax-input"><?php echo e(__('message.App Banner')); ?></label>
                                        <?php if(isset($data->app_banner)): ?>
                                            <img src="<?php echo e(asset('public/image_web') . '/' . $data->app_banner); ?>"
                                                style="width: 250px;">
                                            <input type="file" class="form-control" id="verti-nav-pancard-input"
                                                name="app_banner">
                                        <?php else: ?>
                                            <input type="file" class="form-control" name="app_banner"
                                                id="verti-nav-pancard-input" required="">
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="verti-nav-companyuin-input"><?php echo e(__('message.Appointment Process Icon 1')); ?></label>
                                        <?php if(isset($data->icon1)): ?>
                                            <img src="<?php echo e(asset('public/image_web') . '/' . $data->icon1); ?>"
                                                style="width: 250px;">
                                            <input type="file" class="form-control" id="verti-nav-pancard-input"
                                                name="icon1">
                                        <?php else: ?>
                                            <input type="file" class="form-control" name="icon1"
                                                id="verti-nav-pancard-input" required="">
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="verti-nav-declaration-input"><?php echo e(__('message.Appointment Process Icon 2')); ?></label>
                                        <?php if(isset($data->icon2)): ?>
                                            <img src="<?php echo e(asset('public/image_web') . '/' . $data->icon2); ?>"
                                                style="width: 250px;">
                                            <input type="file" class="form-control" id="verti-nav-pancard-input"
                                                name="icon2">
                                        <?php else: ?>
                                            <input type="file" class="form-control" name="icon2"
                                                id="verti-nav-pancard-input" required="">
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            for="verti-nav-declaration-input"><?php echo e(__('message.Appointment Process Icon 3')); ?></label>
                                        <?php if(isset($data->icon3)): ?>
                                            <img src="<?php echo e(asset('public/image_web') . '/' . $data->icon3); ?>"
                                                style="width: 250px;">
                                            <input type="file" class="form-control" id="verti-nav-pancard-input"
                                                name="icon3">
                                        <?php else: ?>
                                            <input type="file" class="form-control" name="icon3"
                                                id="verti-nav-pancard-input" required="">
                                        <?php endif; ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="verti-nav-declaration-input"><?php echo e(__("message.About page img 1")); ?></label>
                                        <?php if(isset($data->icon3)): ?>
                                        <img src="<?php echo e(asset('public/image_web').'/'.$data->about_img_1); ?>" style="width: 250px;">
                                        <input type="file" class="form-control" id="verti-nav-pancard-input"  name="about_img_1">
                                        <?php else: ?>
                                        <input type="file" class="form-control" name="about_img_1" id="verti-nav-pancard-input" required="">
                                        <?php endif; ?>
                                     </div>

                                     <div class="form-group">
                                        <label for="verti-nav-declaration-input"><?php echo e(__("message.About page img 2")); ?></label>
                                        <?php if(isset($data->icon3)): ?>
                                        <img src="<?php echo e(asset('public/image_web').'/'.$data->about_img_2); ?>" style="width: 250px;">
                                        <input type="file" class="form-control" id="verti-nav-pancard-input"  name="about_img_2">
                                        <?php else: ?>
                                        <input type="file" class="form-control" name="about_img_2" id="verti-nav-pancard-input" required="">
                                        <?php endif; ?>
                                     </div>

                                    <div class="mt-4">
                                        <?php if(Session::get('is_demo') == '0'): ?>
                                            <button type="button" onclick="disablebtn()"
                                                class="btn btn-primary"><?php echo e(__('message.Submit')); ?></button>
                                        <?php else: ?>
                                            <button class="btn btn-primary" type="submit"
                                                value="Submit"><?php echo e(__('message.Submit')); ?></button>
                                        <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/freakd1c/public_html/demo/bookappointment/resources/views/admin/setting.blade.php ENDPATH**/ ?>