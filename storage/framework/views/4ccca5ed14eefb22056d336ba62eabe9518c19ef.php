<?php $__env->startSection('title'); ?>
    <?php echo e(__('message.Pharmacy Order')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-data'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid mb-4">
        <!-- end page title -->
        <?php if(Session::has('message')): ?>
            <div class="col-sm-12">
                <div class="alert <?php echo e(Session::get('alert-class', 'alert-info')); ?> alert-dismissible fade show" role="alert">
                    <i class="uil uil-check me-2"></i>
                    <?php echo e(Session::get('message')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <h4 class="card-title float-left"><?php echo e(__('message.Pharmacy Order')); ?> <?php echo e(__('message.List')); ?>

                            </h4>
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered dt-responsive tablels" id="dataTable"
                                    style="border-collapse: collapse; width: 100%;">
                                    <thead>
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
        <!-- end row -->
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
    </div> <!-- container-fluid -->

    <input type="hidden" id="path_admin" value="<?php echo e(url('/')); ?>">
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



<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/freakd1c/public_html/demo/bookappointment/resources/views/admin/pharmacy/pharmacyorder.blade.php ENDPATH**/ ?>