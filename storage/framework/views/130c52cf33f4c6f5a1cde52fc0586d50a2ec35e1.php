<?php $__env->startSection('title'); ?>
    <?php echo e(__('Payment Link(PayByLink)')); ?> | <?php echo e(__('message.Admin')); ?> <?php echo e(__('Report')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-data'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="container-fluid mb-4">
        <div class="row">
            <?php //var_dump($all_consultation); ?>
            <div class="col-12">
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
                        <h4 class="card-title"><?php echo e(__('Pay By Link')); ?> <?php echo e(__('message.List')); ?></h4>
                        <div class="table-responsive p-3">
                        <table id="payment_by_link" class="table table-bordered dt-responsive tablels">
                            <thead class="thead-light">
                                <tr>
                                    <th><?php echo e(__('id')); ?></th>
                                    <th><?php echo e(__('payment_link_id')); ?></th>
                                    <th><?php echo e(__('payment_id')); ?></th>
                                    <th><?php echo e(__('name')); ?></th>
                                    <th><?php echo e(__('email')); ?></th>
                                    <th><?php echo e(__('phone')); ?></th>
                                    <th><?php echo e(__('amount')); ?></th>
                                    <th><?php echo e(__('zenoti_invoice_id')); ?></th>
                                    <th><?php echo e(__('date_add')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            
                            <?php 
                                foreach($all_payment as $row){
                                    if(empty($row['payment_id']) OR $row['payment_id']=NULL){
                                        $payment_id="NULL";
                                    }else{
                                        $payment_id=$row['payment_id'];
                                    }
                                    if(empty($row['zenoti_invoice_id']) OR $row['zenoti_invoice_id']=NULL){
                                        $zenoti_invoice_id="NULL";
                                    }else{
                                        $zenoti_invoice_id=$row['zenoti_invoice_id'];
                                    }
                                    ?><tr>
                                        <td><?php echo e($row['id']); ?></td>
                                        <td><?php echo e($row['payment_link_id']); ?></td>
                                        <td><?php echo e($payment_id); ?></td>
                                        <td><?php echo e($row['name']); ?></td>
                                        <td><?php echo e($row['email']); ?></td>
                                        <td><?php echo e($row['phone']); ?></td>
                                        <td><?php echo e($row['amount']); ?></td>
                                        <td><?php echo e($zenoti_invoice_id); ?></td>
                                        <td><?php echo e($row['created_at']); ?></td>
                                        <td></td>
                                        </tr>
                                    <?php
                                    
                                }
                            ?>
                            
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
    $('#payment_by_link').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true
    });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/admin/payment_by_link.blade.php ENDPATH**/ ?>