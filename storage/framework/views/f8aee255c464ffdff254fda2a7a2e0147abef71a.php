<?php $__env->startSection('title'); ?>
    <?php echo e(__('message.save')); ?> <?php echo e(__('message.Pharmacy')); ?> | <?php echo e(__('message.Admin')); ?> <?php echo e(__('message.Pharmacy')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-data'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0"><?php echo e(__('message.save')); ?> <?php echo e(__('message.Pharmacy')); ?></h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('admin/Pharmacy')); ?>"><?php echo e(__('message.Pharmacy')); ?></a>
                            </li>
                            <li class="breadcrumb-item active"><?php echo e(__('message.save')); ?> <?php echo e(__('message.Pharmacy')); ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="display: flex;justify-content: center;">
            <div class="col-xl-8 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="<?php echo e(url('admin/updatepharmacy')); ?>" class="needs-validation" method="post"
                            enctype="multipart/form-data">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="id" id="doctor_id" value="<?php echo e($id); ?>">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="mar20">
                                            <div id="uploaded_image">
                                                <div class="upload-btn-wrapper">
                                                    <button type="button" class="btn imgcatlog">
                                                        <input type="hidden" name="real_basic_img" id="real_basic_img"
                                                            value="<?= isset($data->image) ? $data->image : '' ?>" />
                                                        <?php
                                                        if (isset($data->image)) {
                                                            $path = asset('public/upload/doctors') . '/' . $data->image;
                                                        } else {
                                                            $path = asset('public/upload/doctors/medicine.png');
                                                        }
                                                        ?>
                                                        <img src="<?php echo e($path); ?>" alt="..."
                                                            class="img-thumbnail imgsize" id="basic_img" width="150px">
                                                    </button>
                                                    <input type="hidden" name="basic_img" id="basic_img1" />
                                                    <input type="file" name="upload_image" id="upload_image" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name"><?php echo e(__('message.Name')); ?><span
                                                class="reqfield">*</span></label>
                                        <input type="text" class="form-control"
                                            placeholder='<?php echo e(__('message.Enter Pharmacy Name')); ?>' id="name"
                                            name="name" required="" value="<?php echo e(isset($data->name) ? $data->name : ''); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label for="password"><?php echo e(__('message.Password')); ?><span
                                                class="reqfield">*</span></label>
                                        <input type="password" class="form-control" id="password"
                                            placeholder='<?php echo e(__('message.Enter password')); ?>' name="password" required=""
                                            value="<?php echo e(isset($data->password) ? $data->password : ''); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="phoneno"><?php echo e(__('message.Phone')); ?><span
                                                class="reqfield">*</span></label>
                                        <input type="text" class="form-control" id="phoneno"
                                            placeholder='<?php echo e(__('message.Enter Phone')); ?>' name="phoneno" required=""
                                            value="<?php echo e(isset($data->phoneno) ? $data->phoneno : ''); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="email"><?php echo e(__('message.Email')); ?><span
                                                class="reqfield">*</span></label>
                                        <input type="email" class="form-control" id="email"
                                            placeholder='<?php echo e(__('message.Enter Email Address')); ?>' name="email"
                                            required="" <?= isset($id) && $id != 0 ? 'readonly' : '' ?>
                                            value="<?php echo e(isset($data->email) ? $data->email : ''); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="email"><?php echo e(__('message.Working Time')); ?><span
                                                class="reqfield">*</span></label>
                                        <input type="text" class="form-control" id="working_time"
                                            placeholder='<?php echo e(__('message.Enter Working Time')); ?>' name="working_time"
                                            required="" value="<?php echo e(isset($data->working_time) ? $data->working_time : ''); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="aboutus"><?php echo e(__('message.About Us')); ?><span
                                                class="reqfield">*</span></label>
                                        <textarea id="aboutus" class="form-control" rows="5" name="aboutus"
                                            placeholder='<?php echo e(__('message.Enter About Pharmacy')); ?>' required=""><?php echo e(isset($data->aboutus) ? $data->aboutus : ''); ?></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="services"><?php echo e(__('message.Services')); ?><span
                                                class="reqfield">*</span></label>
                                        <textarea id="services" class="form-control" rows="5"
                                            placeholder='<?php echo e(__('message.Enter Description about Services')); ?>' name="services" required=""><?php echo e(isset($data->services) ? $data->services : ''); ?></textarea>
                                    </div>
                                </div>
                            </div>

                            

                                <div class="form-group">
                                    <label for="address_address"><?php echo e(__('message.Address')); ?></label>
                                    <input type="text" id="address-input" name="address" class="form-control map-input" required>
                                    <input type="hidden" name="lat" id="address-latitude" value="<?php echo e(isset($data->lat) ? $data->lat : $setting->map_lat); ?>" />
                                    <input type="hidden" name="lon" id="address-longitude" value="<?php echo e(isset($data->lon) ? $data->lon : $setting->map_long); ?>" />
                                </div>
                                <div id="address-map-container" style="width:100%;height:300px; ">
                                    <div style="width: 100%; height: 70%" id="address-map"></div>
                                </div>
                            <div class="row">
                                <div class="form-group">
                                    <?php if(Session::get('is_demo') == '0'): ?>
                                        <button type="button" onclick="disablebtn()"
                                            class="btn btn-primary"><?php echo e(__('message.Submit')); ?></button>
                                    <?php else: ?>
                                        <button class="btn btn-primary" type="submit"
                                            value="Submit"><?php echo e(__('message.Submit')); ?></button>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e($setting->map_api_key); ?>&libraries=places&callback=initialize"
    async defer></script>
<script>
    function initialize() {

        $('form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
        const locationInputs = document.getElementsByClassName("map-input");

        const autocompletes = [];
        const geocoder = new google.maps.Geocoder;
        for (let i = 0; i < locationInputs.length; i++) {

            const input = locationInputs[i];
            const fieldKey = input.id.replace("-input", "");
            const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(
                fieldKey + "-longitude").value != '';

            const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -33.8688;
            const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 151.2195;

            const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
                center: {
                    lat: latitude,
                    lng: longitude
                },
                zoom: 13
            });
            const marker = new google.maps.Marker({
                map: map,
                position: {
                    lat: latitude,
                    lng: longitude
                },
            });

            marker.setVisible(isEdit);

            const autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.key = fieldKey;
            autocompletes.push({
                input: input,
                map: map,
                marker: marker,
                autocomplete: autocomplete
            });
        }

        for (let i = 0; i < autocompletes.length; i++) {
            const input = autocompletes[i].input;
            const autocomplete = autocompletes[i].autocomplete;
            const map = autocompletes[i].map;
            const marker = autocompletes[i].marker;

            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                marker.setVisible(false);
                const place = autocomplete.getPlace();

                geocoder.geocode({
                    'placeId': place.place_id
                }, function(results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        const lat = results[0].geometry.location.lat();
                        const lng = results[0].geometry.location.lng();
                        setLocationCoordinates(autocomplete.key, lat, lng);
                    }
                });

                if (!place.geometry) {
                    window.alert("No details available for input: '" + place.name + "'");
                    input.value = "";
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

            });
        }
    }

    function setLocationCoordinates(key, lat, lng) {
        const latitudeField = document.getElementById(key + "-" + "latitude");
        const longitudeField = document.getElementById(key + "-" + "longitude");
        latitudeField.value = lat;
        longitudeField.value = lng;
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\rutik\live\bookappointment__medical\resources\views/admin/pharmacy/savepharmacy.blade.php ENDPATH**/ ?>