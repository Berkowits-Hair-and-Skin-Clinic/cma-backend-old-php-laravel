<?php $__env->startSection('title'); ?>
    <?php echo e(__('message.Search Doctors')); ?>

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
    <div class="select-field bg-color-3">
        <div class="auto-container">
            <div class="content-box">
                <div class="form-inner clearfix">
                    <form action="<?php echo e(url('searchcenterall')); ?>" method="get">
                        <div class="form-group clearfix">

                            <input type="text" name="query" value="<?php echo e($term); ?>" id="filterby"
                                placeholder="<?php echo e(__('Search Center...')); ?>" required="">
                            <?php if(!empty($type)): ?>
                                <input type="hidden" name="type" value="<?php echo e($type); ?>">
                            <?php endif; ?>
                            <button type="submit"><i class="icon-Arrow-Right"></i></button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!--<div id="map"></div>
    <p id="status"></p>-->
    <section class="clinic-section doctors-page-section">
        <div class="auto-container">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 content-side">
                    <h3>Please select a center to book your appointment!</h3>
                    <div class="item-shorting clearfix">
                        <div class="left-column pull-left">
                            <h3><?php echo e(__('message.Showing')); ?> <?php echo e(count($doctorlist)); ?> <?php echo e(__('message.Results')); ?></h3>
                            <hr />
                        </div>
                       
                        <div class="right-column pull-right clearfix">
                             <div class="short-box clearfix">
                                <div class="select-box">
                                    <select class="wide" onchange="filterbycity(this.value)">
                                        <option value=""><?php echo e(__('Select City')); ?></option>
                                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($c->city); ?>"><?php echo e($c->city); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="short-box clearfix">
                                <div class="select-box">
                                    <select class="wide" onchange="filterbyQuery(this.value)">
                                        <option value=""><?php echo e(__('message.Specialist by')); ?></option>
                                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($ser->concern_category); ?>"
                                                <?= isset($type) && $type == $ser->id ? 'selected="selected"' : '' ?>>
                                                <?php echo e($ser->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="menu-box">
                                <!-- <button class="list-view"><i class="icon-List"></i></button> -->
                                <!-- <button class="grid-view on"><i class="icon-Grid"></i></button> -->
                            </div>
                        </div>
                    </div>
                    <div class="wrapper grid">
                        <div class="clinic-list-content list-item">
                            <?php $__currentLoopData = $doctorlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="clinic-block-one">
                                    <div class="inner-box">
                                        <div class="pattern">
                                            <div class="pattern-1"
                                                style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-24.png')); ?>');">
                                            </div>
                                            <div class="pattern-2"
                                                style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-25.png')); ?>');">
                                            </div>
                                        </div>
                                        <figure class="image-box">
                                            <?php if($dl->image != ''): ?>
                                                <img src="<?php echo e(asset('public/upload/doctors') . '/' . $dl->image); ?>"
                                                    alt="" style="height: 245px;">
                                            <?php else: ?>
                                                <img src="<?php echo e(asset('public/upload/doctors/default.png')); ?>" alt=""
                                                    style="height: 245px;">
                                            <?php endif; ?>

                                        </figure>
                                        <div class="content-box">
                                            <div class="like-box">
                                                <?php if($dl->is_fav == '0'): ?>
                                                    <?php if(empty(Session::has('user_id'))): ?>
                                                        <a href="<?php echo e(url('patientlogin')); ?>"
                                                            id="favdoc<?php echo e($dl->id); ?>">
                                                        <?php else: ?>
                                                            <a href="javascript:userfavorite1('<?php echo e($dl->id); ?>')"
                                                                id="favdoc1<?php echo e($dl->id); ?>">
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <a href="javascript:userfavorite1('<?php echo e($dl->id); ?>')"
                                                        class="activefav" id="favdoc1<?php echo e($dl->id); ?>">
                                                <?php endif; ?>
                                                <i class="far fa-heart"></i></a>
                                            </div>
                                            <ul class="name-box clearfix">
                                                <li class="name">
                                                    <h3><a
                                                            href="<?php echo e(url('viewdoctor') . '/' . $dl->id); ?>"><?php echo e($dl->name); ?></a>
                                                    </h3>
                                                </li>
                                                <!-- <li><i class="icon-Trust-1"></i></li>
                                                        <li><i class="icon-Trust-2"></i></li> -->
                                            </ul>
                                            <span
                                                class="designation"><?php echo e(isset($dl->departmentls) ? $dl->departmentls->name : ''); ?></span>
                                            <div class="text">
                                                <p><?php echo e(substr($dl->aboutus, 0, 200)); ?></p>
                                            </div>
                                            <div class="rating-box clearfix">
                                                <ul class="rating clearfix">
                                                    <?php
                                                    $arr = $dl->avgratting;
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
                                                    } else {
                                                        for ($j = 0; $j < 5; $j++) {
                                                            echo '<li class="light"><i class="icon-Star"></i></li>';
                                                        }
                                                    } ?>
                                                    <li><a
                                                            href="<?php echo e(url('viewdoctor') . '/' . $dl->id); ?>">(<?php echo e($dl->totalreview); ?>)</a>
                                                    </li>
                                                </ul>
                                                <div class="link"><a
                                                        href="<?php echo e(url('viewdoctor') . '/' . $dl->id); ?>"><?php echo e($dl->working_time); ?></a>
                                                </div>
                                            </div>
                                            <div class="location-box">
                                                <p><i class="fas fa-map-marker-alt"></i><?php echo e(substr($dl->address, 0, 38)); ?>

                                                </p>
                                            </div>
                                            <div class="btn-box"><a
                                                    href="<?php echo e(url('viewdoctor') . '/' . $dl->id); ?>"><?php echo e(__('message.Visit Now')); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($type) && $type != '' && isset($term) && $term != ''): ?>
                                <?php echo e($doctorlist->appends(['term' => $term, 'type' => $type])->links()); ?>

                            <?php elseif(isset($type) && $type != '' && empty($term)): ?>
                                <?php echo e($doctorlist->appends(['type' => $type])->links()); ?>

                            <?php elseif(isset($type) && $type != '' && empty($term)): ?>
                                <?php echo e($doctorlist->appends(['term' => $term])->links()); ?>

                            <?php else: ?>
                                <?php echo e($doctorlist->links()); ?>

                            <?php endif; ?>
                        </div>


                        <div class="clinic-grid-content">
                            <div class="row clearfix">
                                <?php $__currentLoopData = $doctorlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-lg-4 col-md-4 col-sm-12 team-block">
                                        <div class="team-block-three">
                                            <div class="inner-box">
                                                <figure class="image-box">
                                                    <img src="<?php echo e(asset('public/upload/doctors') . '/' . $dl->image); ?>"
                                                        alt="" style="height: 245px;">
                                                    <?php if($dl->is_fav == '0'): ?>
                                                        <?php if(empty(Session::has('user_id'))): ?>
                                                            <a href="<?php echo e(url('patientlogin')); ?>"
                                                                id="favdoc<?php echo e($dl->id); ?>">
                                                            <?php else: ?>
                                                                <a href="javascript:userfavorite('<?php echo e($dl->id); ?>')"
                                                                    id="favdoc<?php echo e($dl->id); ?>">
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <a href="javascript:userfavorite('<?php echo e($dl->id); ?>')"
                                                            class="activefav" id="favdoc<?php echo e($dl->id); ?>">
                                                    <?php endif; ?>
                                                    <i class="far fa-heart"></i></a>
                                                </figure>
                                                <div class="lower-content">
                                                    <ul class="name-box clearfix">
                                                        <li class="name">
                                                            <h3>
                                                            <?php if(empty(Session::has('user_id'))): ?>
                                                                <a href="<?php echo e(url('booking_firsttimeuser') . '/' . $dl->id); ?>"><?php echo e($dl->name); ?></a>
                                                                
                                                            <?php else: ?>
                                                                <a href="<?php echo e(url('booking_firsttimeuser') . '/' . $dl->id); ?>"><?php echo e($dl->name); ?></a>
                                                            </h3>
                                                            <?php endif; ?>
                                                        </li>
                                                        <!-- <li><i class="icon-Trust-1"></i></li>
                                                                <li><i class="icon-Trust-2"></i></li> -->
                                                    </ul>
                                                    <!-- <span class="designation"><?php echo e(isset($dl->departmentls) ? $dl->departmentls->name : ''); ?></span> -->
                                                    <!--<div class="rating-box clearfix">
                                                        <ul class="rating clearfix">
                                                            <?php
                                                            $arr = $dl->avgratting;

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
                                                            } else {
                                                                for ($j = 0; $j < 5; $j++) {
                                                                    echo '<li class="light"><i class="icon-Star"></i></li>';
                                                                }
                                                            } ?>
                                                            <li>
                                                            <?php if(empty(Session::has('user_id'))): ?>
                                                                <a onclick="pleaselogin()" id="show_book" href="#">(<?php echo e($dl->totalreview); ?>)</a>
                                                                
                                                            <?php else: ?>
                                                                <a href="<?php echo e(url('booking_firsttimeuser') . '/' . $dl->id); ?>">(<?php echo e($dl->totalreview); ?>)</a>
                                                            </h3>
                                                            <?php endif; ?>
                                                                    
                                                            </li>
                                                        </ul>
                                                    </div>-->
                                                    <div class="location-box">
                                                        <p><i
                                                                class="fas fa-map-marker-alt"></i><?php echo e(substr($dl->address, 0, 60)); ?>...
                                                        </p>
                                                        <span class="text"> <i
                                                        class="fas fa-clock"></i> Work Timing : <?php echo e($dl->working_time); ?></span>
                                                    </div>
                                                    <div align="center" class="lower-box clearfix">
                                                        <a style="float: right;margin-left:20px;" href="https://maps.google.com/?q=<?php echo e($dl->lat); ?>,<?php echo e($dl->lon); ?>" target="_blank"><?php echo e(__('Get Direction')); ?></a>
                                                        <?php if(Session::has("user_id")): ?>
                                                            <!--<a href="<?php echo e(url('viewdoctor') . '/' . $dl->id); ?>"><?php echo e(__('Book Now')); ?></a>-->
                                                            <a href="<?php echo e(url('booking_firsttimeuser') . '/' . $dl->id); ?>"><?php echo e(__('Book Now')); ?></a>
                                                        <?php else: ?>
                                                            <a href="<?php echo e(url('booking_firsttimeuser') . '/' . $dl->id); ?>"><?php echo e(__('Book Now')); ?></a>
                                                            <!--<button type="button" class="theme-btn-one" onclick="pleaselogin()"  id="show_book"><?php echo e(__('Book Now')); ?><i class="icon-Arrow-Right"></i></button>-->
                                                        <?php endif; ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php if(isset($type) && $type != '' && isset($term) && $term != ''): ?>
                                <?php echo e($doctorlist->appends(['term' => $term, 'type' => $type])->links()); ?>

                            <?php elseif(isset($type) && $type != '' && empty($term)): ?>
                                <?php echo e($doctorlist->appends(['type' => $type])->links()); ?>

                            <?php elseif(isset($type) && $type != '' && empty($term)): ?>
                                <?php echo e($doctorlist->appends(['term' => $term])->links()); ?>

                            <?php else: ?>
                                <?php echo e($doctorlist->links()); ?>

                            <?php endif; ?>
                        </div>
                    </div>


                </div>
                <!--<div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                    <div class="map-inner ml-10">

                        <div id="map" style="height: 400px"></div>
                    </div>
                </div>-->
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
    <script type="text/javascript">
        function filterbyQuery(val) {
            window.location.href = '<?php echo e(url('searchcenterall')); ?>' + '?query=' + val;

        }
        function serachsep(val) {
            window.location.href = '<?php echo e(url('searchcenterall')); ?>' + '?query=' + val;
            var term = $("#term").val();
            if (val != "") {
                   // window.location.href = '<?php echo e(url('searchcenterall')); ?>' + '?type=' + val;
                    window.location.href = '<?php echo e(url('searchcenterall')); ?>' + '?query=' + val;
                }
            if (term == "") {
                if (val != "") {
                   // window.location.href = '<?php echo e(url('searchcenterall')); ?>' + '?type=' + val;
                    window.location.href = '<?php echo e(url('searchcenterall')); ?>' + '?filterby=' + val;
                }
            } else {
                window.location.href = '<?php echo e(url('searchcenterall')); ?>' + '?type=' + val + "&term=" + term;
            }

        }
        function filterbycity(val) {
            window.location.href = '<?php echo e(url('searchcenterall')); ?>' + '?filterby=' + val;

        }
    </script>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                //center: new google.maps.LatLng(-33.863276, 151.207977),
                center: new google.maps.LatLng(28.5497637, 77.2652878),
                zoom: 12
            });
            var infoWindow = new google.maps.InfoWindow;
            var markerBounds = new google.maps.LatLngBounds();
            var markers = <?= json_encode($doctorslistmap) ?>;
            Array.prototype.forEach.call(markers, function(markerElem) {

                if (markerElem.lat != null && markerElem.lon != null) {
                    var id = markerElem.id;
                    var name = markerElem.name;
                    var address = markerElem.address;
                    var type = "D";
                    var point = new google.maps.LatLng(
                        parseFloat(markerElem.lat),
                        parseFloat(markerElem.lon));
                    markerBounds.extend(point);
                    var infowincontent = document.createElement('div');
                    var strong = document.createElement('strong');
                    strong.textContent = name
                    infowincontent.appendChild(strong);
                    infowincontent.appendChild(document.createElement('br'));

                    var text = document.createElement('text');
                    text.textContent = address
                    infowincontent.appendChild(text);
                    var icon = {
                        url: "<?php echo e(asset('public/front_pro/assets/images/icons/map-marker.png')); ?>", // url
                        scaledSize: new google.maps.Size(40, 40), // scaled size
                        origin: new google.maps.Point(0, 0), // origin
                        anchor: new google.maps.Point(0, 0) // anchor
                    };
                    var marker = new google.maps.Marker({
                        map: map,
                        position: point,
                        icon: icon
                    });
                    marker.addListener('click', function() {
                        infoWindow.setContent(infowincontent);
                        infoWindow.open(map, marker);
                    });

                    map.fitBounds(markerBounds);
                    map.panToBounds(markerBounds);
                }

            });

        }

        initMap();
    </script>
    <script> 
        function getLocation() {
            if (navigator.geolocation) {
                //document.getElementById("status").innerText = "Fetching your location...";

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        //let date = new Date();
                        //date.setTime(date.getTime() + (7 * 24 * 60 * 60 * 1000)); // 7 days in milliseconds
                        //let expires = "expires=" + date.toUTCString();

                        // Set cookies for latitude and longitude
                        //document.cookie = "latitude=" + latitude + "; " + expires + "; path=/";
                        //document.cookie = "longitude=" + longitude + "; " + expires + "; path=/";
                        // Update status
                        // document.getElementById("status").innerText = `Latitude: ${latitude}, Longitude: ${longitude}`;
                        document.getElementById("status").innerText = `${latitude},${longitude}`;
                        $.ajax({
                            type: 'POST',
                            url: 'http://localhost/berkowits/cma-backend/api/set_session',
                            data: {latitude: latitude,longitude: longitude},
                            success: function(html){
                            }
                        });
                        // Update map to center on user's location
                        const userLocation = { lat: latitude, lng: longitude };
                        map.setCenter(userLocation);

                        // Place a marker at the user's location
                        if (marker) {
                            marker.setMap(null);  // Remove previous marker
                        }
                        marker = new google.maps.Marker({
                            position: userLocation,
                            map: map,
                            title: "Your Location"
                        });
                    },
                    (error) => {
                        document.getElementById("status").innerText = "Error fetching location: " + error.message;
                    }
                );
            } else {
                document.getElementById("status").innerText = "Geolocation is not supported by this browser.";
            }
        }
        getLocation();
    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/user/searchcenter_firsttimeuser.blade.php ENDPATH**/ ?>