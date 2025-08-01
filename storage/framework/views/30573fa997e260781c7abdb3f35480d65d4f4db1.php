<?php $__env->startSection('title'); ?>
    <?php echo e(__('message.Medicine Order')); ?>

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
    </section>
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
                        <li><a href="<?php echo e(url('userdashboard')); ?>"><i
                                    class="fas fa-columns"></i><?php echo e(__('message.Dashboard')); ?></a></li>
                        <li><a href="<?php echo e(url('usermedicineorder')); ?>" class="current"><i
                                    class="fas fa-columns"></i><?php echo e(__('message.Medicine Order')); ?></a></li>
                        <li><a href="<?php echo e(url('favouriteuser')); ?>"><i
                                    class="fas fa-heart"></i><?php echo e(__('message.Favourite Doctors')); ?></a></li>
                        <li><a href="<?php echo e(url('viewschedule')); ?>"><i
                                    class="fas fa-clock"></i><?php echo e(__('message.Schedule Timing')); ?></a></li>
                        <li><a href="<?php echo e(url('userreview')); ?>"><i
                                    class="fas fa-comments"></i><?php echo e(__('message.Review')); ?></a></li>
                        <li><a href="<?php echo e(url('usereditprofile')); ?>"><i
                                    class="fas fa-user"></i><?php echo e(__('message.My Profile')); ?></a></li>
                        <li><a href="<?php echo e(url('changepassword')); ?>"><i
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
                    <div class="feature-content">
                        <div class="row clearfix">
                            <div class="col-xl-4 col-lg-12 col-md-12 feature-block">
                                <div class="feature-block-two">
                                    <div class="inner-box">
                                        <div class="pattern">
                                            <div class="pattern-1"
                                                style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-79.png')); ?>');">
                                            </div>
                                            <div class="pattern-2"
                                                style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-80.png')); ?>');">
                                            </div>
                                        </div>
                                        <div class="icon-box"><i class="icon-Dashboard-3"></i></div>
                                        <h3><?php echo e(count($orderdata)); ?></h3>
                                        <h5><?php echo e(__('message.Total')); ?></h5>
                                        <h5><?php echo e(__('message.Order')); ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12 feature-block">
                                <div class="feature-block-two">
                                    <div class="inner-box">
                                        <div class="pattern">
                                            <div class="pattern-1"
                                                style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-81.png')); ?>');">
                                            </div>
                                            <div class="pattern-2"
                                                style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-82.png')); ?>');">
                                            </div>
                                        </div>
                                        <div class="icon-box"><i class="icon-Dashboard-email-4"></i></div>
                                        <h3><?php echo e($complet); ?></h3>
                                        <h5><?php echo e(__('message.Completed')); ?></h5>
                                        <h5><?php echo e(__('message.Order')); ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-12 col-md-12 feature-block">
                                <div class="feature-block-two">
                                    <div class="inner-box">
                                        <div class="pattern">
                                            <div class="pattern-1"
                                                style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-83.png')); ?>');">
                                            </div>
                                            <div class="pattern-2"
                                                style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-84.png')); ?>');">
                                            </div>
                                        </div>
                                        <div class="icon-box"><i class="icon-Dashboard-5"></i></div>
                                        <h3><?php echo e($pending); ?></h3>
                                        <h5><?php echo e(__('message.Pending')); ?></h5>
                                        <h5><?php echo e(__('message.Order')); ?></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="doctors-appointment">
                        <div class="title-box">
                            <h3><?php echo e(__('message.Medicine Order')); ?></h3>
                        </div>
                        <div class="doctors-list m-3">
                            <div class="table-outer">
                                <table class="" id="myTable">
                                    <thead class="table-header">
                                        <tr>
                                            <th><?php echo e(__('message.Id')); ?></th>
                                            <th><?php echo e(__('message.Pharmacy')); ?> <?php echo e(__('message.Name')); ?></th>
                                            <th><?php echo e(__('message.Patients')); ?> <?php echo e(__('message.Name')); ?></th>
                                            <th><?php echo e(__('message.Phone')); ?></th>
                                            <th><?php echo e(__('message.Order')); ?> <?php echo e(__('message.Type')); ?></th>
                                            <th><?php echo e(__('message.Total')); ?></th>
                                            <th><?php echo e(__('message.date')); ?></th>
                                            <th><?php echo e(__('message.More')); ?></th>
                                            <th><?php echo e(__('message.Status')); ?></th>
                                            <th><?php echo e(__('message.Action')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $orderdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($bdata->id); ?></td>
                                                <td>
                                                    <p><?php echo e($bdata->Pharmacy_id); ?></p>
                                                </td>
                                                <td><?php echo e($bdata->user_id); ?> </td>
                                                <td><?php echo e($bdata->phone); ?></td>
                                                <td>
                                                    <?php
                                                    if ($bdata->order_type == '2') {
                                                        echo '<span>' . __('message.Normale') . '</span>';
                                                    } elseif ($bdata->order_type == '1') {
                                                        echo '<span>' . __('message.Prescription') . '</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo e($bdata->total); ?></td>
                                                <td><?php echo e($bdata->created_at); ?></td>
                                                <td>
                                                    <button onclick="get_orderdata(<?php echo $bdata->id; ?>)"
                                                        class="btn btn-primary" data-toggle="modal"
                                                        data-target="#exampleModal"><?php echo e(__('message.More')); ?></button>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($bdata->status == '0') {
                                                        echo '<span class="status">' . __('message.In Process') . '</span>';
                                                    } elseif ($bdata->status == '1') {
                                                        echo '<span class="status">' . __('message.Accept') . '</span>';
                                                    } elseif ($bdata->status == '2') {
                                                        echo '<span class="status">' . __('message.Rejected') . '</span>';
                                                    } elseif ($bdata->status == '3') {
                                                        echo '<span class="status">' . __('message.Completed') . '</span>';
                                                    } elseif ($bdata->status == '4') {
                                                        echo '<span class="status">' . __('message.waiting') . '</span>';
                                                    } elseif ($bdata->status == '5') {
                                                        echo '<span class="status">' . __('message.estimated') . '</span>';
                                                    } elseif ($bdata->status == '6') {
                                                        echo '<span class="status">' . __('message.Cancel') . '</span>';
                                                    } elseif ($bdata->status == '7') {
                                                        echo '<span class="status">' . __('message.Prepared') . '</span>';
                                                    } elseif ($bdata->status == '8') {
                                                        echo '<span class="status">' . __('message.Out for Delivery') . '</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if($bdata->status == '5'): ?>
                                                        <a href="<?php echo e(url('pharmacyorderchangestatus/' . $bdata->id . '/' . '4')); ?>"
                                                            class="btn btn-success"><?php echo e(__('message.Accept')); ?></a>
                                                        <a href="<?php echo e(url('pharmacyorderchangestatus/' . $bdata->id . '/' . '6')); ?>"
                                                            class="btn btn-danger"><?php echo e(__('message.Cancel')); ?></a>
                                                    <?php endif; ?>
                                                </td>

                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('message.Order Details')); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div id="m_data">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

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
        <script>
            function get_orderdata(id) {
                $("#m_data").empty();
                $.ajax({

                    url: $("#path_admin").val() + "/get_orderdata" + "/" + id,
                    data: {},
                    success: function(data) {
                        console.log(data);
                        // Access order details
                        var orderDetails = data[1];
                        console.log("Order Details:", orderDetails);

                        // Access order data
                        var orderData = data[0];
                        console.log("Order Data:", orderData);

                        var currency = data[2];
                        console.log("currency Data:", currency);



                        var aaa = <?php echo e(__('message.RTL')); ?>;
                        if (aaa == 0) {
                            var isRTL = 1;
                        } else {
                            var isRTL = 0;
                        }

                        // Example: Displaying order details dynamically for RTL and LTR
                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "<?php echo e(__('message.Order ID')); ?>" + ": </b>" + orderDetails.id + "</p>");
                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "<?php echo e(__('message.Name')); ?>" + ": </b>" + orderDetails.user_id + "</p>");
                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "<?php echo e(__('message.Phone')); ?>" + ": </b>" + orderDetails.phone + "</p>");
                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "<?php echo e(__('message.Address')); ?>" + ": </b>" + orderDetails.address + "</p>");
                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "<?php echo e(__('message.Note')); ?>" + ": </b>" + orderDetails.message + "</p>");

                        if (orderDetails.payment_type != null) {
                            $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                                "<?php echo e(__('message.Payment Type')); ?>" + ": </b>" + orderDetails.payment_type +
                                "</p>");
                        }

                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "<?php echo e(__('message.Pharmacy')); ?> <?php echo e(__('message.Name')); ?>" + ": </b>" + orderDetails
                            .Pharmacy_id + "</p><hr>");

                        if (orderDetails.order_type == 2) {
                            var subtotal = 0;
                            orderData.forEach(function(item) {
                                subtotal += item.qty * item.price;

                                var itemHTML =
                                    '<div class="col-12" style="border-bottom:1px solid #e5e7ec; direction: ' +
                                    (isRTL ? "rtl" : "ltr") + ';">' +
                                    '<p><b>' + item.name + '</b></p>' +
                                    '<div class="row">' +
                                    '<div class="col-4">' +
                                    '<p><?php echo e(__('message.Price')); ?>: ' + item.price + currency[1] + '</p>' +
                                    '</div>' +
                                    '<div class="col-4" style="text-align: center;">' +
                                    '<p><?php echo e(__('message.Qty')); ?>: ' + item.qty + '</p>' +
                                    '</div>' +
                                    '<div class="col-4" style="display: inline; text-align: ' + (isRTL ?
                                        "left" : "right") + ';">' +
                                    '<p><?php echo e(__('message.Total')); ?>: ' + (item.qty * item.price) + currency[
                                        1] + '</p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';
                                $('#m_data').append(itemHTML);
                            });

                            // Display total amounts dynamically based on RTL or LTR
                            $('#m_data').append("<p class='mt-2' style='text-align: " + (isRTL ? "left" : "right") +
                                "; padding-" + (isRTL ? "left" : "right") +
                                ":15px;'><?php echo e(__('message.Sub Total')); ?>: " + subtotal + currency[1] + "</p>");
                            $('#m_data').append("<p class='mt-2' style='text-align: " + (isRTL ? "left" : "right") +
                                "; padding-" + (isRTL ? "left" : "right") +
                                ":15px;'><?php echo e(__('message.Delivery Charge')); ?>: " + orderDetails
                                .delivery_charge + currency[1] + "</p>");
                            $('#m_data').append("<p class='mt-2' style='text-align: " + (isRTL ? "left" : "right") +
                                "; padding-" + (isRTL ? "left" : "right") +
                                ":15px;'><?php echo e(__('message.Tax')); ?>: " + orderDetails.tax + currency[1] + "</p>");
                            $('#m_data').append("<p class='mt-2' style='text-align: " + (isRTL ? "left" : "right") +
                                "; padding-" + (isRTL ? "left" : "right") +
                                ":15px;'><?php echo e(__('message.Total')); ?>: " + orderDetails.total + currency[1] +
                                "</p>");
                        } else {
                            // Handle prescription image
                            $('#m_data').append('<img src="' + $("#path_admin").val() +
                                '/public/upload/orderprescription/' + orderDetails.prescription +
                                '" style="width: 100%; direction: ' + (isRTL ? "rtl" : "ltr") + ';">');
                        }
                    }
                });
            }
        </script>


    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\xampp\htdocs\rutik\live\bookappointment__medical\resources\views/user/patient/medicineorder.blade.php ENDPATH**/ ?>