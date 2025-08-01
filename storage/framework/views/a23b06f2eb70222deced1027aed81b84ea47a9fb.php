<?php $__env->startSection('title'); ?>
    <?php echo e(__('message.Appointment')); ?> | <?php echo e(__('message.Admin')); ?> <?php echo e(__('message.Appointment')); ?>

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
                        <h4 class="card-title"><?php echo e(__('Video Consultation')); ?> <?php echo e(__('message.List')); ?></h4>
                        <div class="table-responsive p-3">
                        <table id="vctable" class="table table-bordered dt-responsive tablels">
                            <thead class="thead-light">
                                <tr>
                                    <th><?php echo e(__('VC ID')); ?></th>
                                    <th><?php echo e(__('message.Patient Name')); ?></th>
                                    <th><?php echo e(__('DoctorName')); ?></th>
                                    <th><?php echo e(__('CenterName')); ?></th>
                                    <th><?php echo e(__('message.DateTime')); ?></th>
                                    <th><?php echo e(__('message.Status')); ?></th>
                                    <th><?php echo e(__('Payment')); ?></th>
                                </tr>
                            </thead>
                            
                            <?php 
                                foreach($all_consultation as $row){
                                    $data_doctor = json_decode($row['doctor_details'], true);
                                    if(empty($data_doctor['name']) OR $data_doctor['name']==null){
                                        $doctor_name="NA";
                                        $center_name="NA";
                                    }else{
                                        $doctor_name=$data_doctor['name'];
                                        $center_name=$data_doctor['centre'];;
                                    }
                                    ?><tr>
                                        <td><?php echo e($row['encryption_id']); ?></td>
                                        <td><?php echo e($row['firstname']); ?> <?php echo e($row['firstname']); ?></td>
                                        <td><?php echo e($doctor_name); ?></td>
                                        <td><?php echo e($center_name); ?></td>
                                        <td><?php echo e($row['preferred_date']); ?> <?php echo e($row['time_slot']); ?></td>
                                        <td><?php echo e($row['status']); ?></td>
                                        <td><?php echo e($row['payment_status']); ?></td>
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
    $('#vctable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true
    });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/admin/vc.blade.php ENDPATH**/ ?>