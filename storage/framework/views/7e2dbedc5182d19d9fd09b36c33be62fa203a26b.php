<?php $__env->startSection('title'); ?>
    <?php echo e(__('AI ANALYSIS')); ?> | <?php echo e(__('message.Admin')); ?> <?php echo e(__('Report')); ?>

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
                        <h4 class="card-title"><?php echo e(__('AI ANALYSIS')); ?> <?php echo e(__('message.List')); ?></h4>
                        <div class="table-responsive p-3">
                        <table id="ai-analysis-table" class="table table-bordered dt-responsive tablels">
                            <thead class="thead-light">
                                <tr>
                                    <th><?php echo e(__('id_enc')); ?></th>
                                    <th><?php echo e(__('fullname')); ?></th>
                                    <th><?php echo e(__('email')); ?></th>
                                    <th><?php echo e(__('phone')); ?></th>
                                    <th><?php echo e(__('gender')); ?></th>
                                    <th><?php echo e(__('date_add')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            
                            <?php 
                                foreach($all_ai_analysis as $row){
                                    $report_url=env('BERKOWITS_AI_ANALYSIS_REPORT_URL').$row['id_enc'];
                                    ?><tr>
                                        <td><?php echo e($row['id_enc']); ?></td>
                                        <td><?php echo e($row['fullname']); ?></td>
                                        <td><?php echo e($row['email']); ?></td>
                                        <td><?php echo e($row['phone']); ?></td>
                                        <td><?php echo e($row['gender']); ?></td>
                                        <td><?php echo e($row['date_add']); ?></td>
                                        <td><a href="<?php echo e($report_url); ?>" target="_blank"><i class="fas fa-eye"></i></a></td>
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
    $('#ai-analysis-table').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true
    });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/admin/ai-analysis.blade.php ENDPATH**/ ?>