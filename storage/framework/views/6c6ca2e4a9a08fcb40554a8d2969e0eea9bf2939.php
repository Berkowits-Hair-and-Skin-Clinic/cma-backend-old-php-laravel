<?php $__env->startSection('title'); ?>
    <?php echo e(__('message.Languages_Translation')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-data'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid mb-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <h4 class="card-title float-left mt-3 ml-3"><?php echo e(__('message.Languages_Translation')); ?></h4>
                            <div class="card-body">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a href="<?php echo e(url('admin/languages/en')); ?>"
                                            class="nav-link <?php echo e($lang == 'en' ? 'active' : ''); ?>" id="en_lang"
                                            role="tab" aria-controls="home"
                                            aria-selected="<?php echo e($lang == 'en' ? 'true' : 'false'); ?>"><?php echo e(__('message.english')); ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(url('admin/languages/ar')); ?>"
                                            class="nav-link <?php echo e($lang == 'ar' ? 'active' : ''); ?>" id="ar_lang"
                                            role="tab" aria-controls="contact"
                                            aria-selected="<?php echo e($lang == 'ar' ? 'true' : 'false'); ?>"><?php echo e(__('message.arabic')); ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(url('admin/languages/fr')); ?>"
                                            class="nav-link <?php echo e($lang == 'fr' ? 'active' : ''); ?>" id="fr_lang"
                                            role="tab" aria-controls="home3"
                                            aria-selected="<?php echo e($lang == 'fr' ? 'true' : 'false'); ?>"><?php echo e(__('message.french')); ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(url('admin/languages/es')); ?>"
                                            class="nav-link <?php echo e($lang == 'es' ? 'active' : ''); ?>" id="es_lang"
                                            role="tab" aria-controls="home4"
                                            aria-selected="<?php echo e($lang == 'es' ? 'true' : 'false'); ?>"><?php echo e(__('message.spanish')); ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo e(url('admin/languages/pt')); ?>"
                                            class="nav-link <?php echo e($lang == 'pt' ? 'active' : ''); ?>" id="pt_lang"
                                            role="tab" aria-controls="home5"
                                            aria-selected="<?php echo e($lang == 'pt' ? 'true' : 'false'); ?>"><?php echo e(__('message.portuguese')); ?></a>
                                    </li>
                                </ul>

                                <div class="tab-content mt-4" id="myTabContent">
                                    <!-- English Tab -->
                                    <div class="tab-pane fade <?php echo e($lang == 'en' ? 'show active' : ''); ?>" id="home"
                                        role="tabpanel" aria-labelledby="en_lang">
                                        <div class="table-responsive p-3">
                                        <table id="en_lang_table" class="table table-bordered dt-responsive tablels"
                                            style="width: 100%;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th><?php echo e(__('message.Key')); ?></th>
                                                    <th><?php echo e(__('message.Value')); ?></th>
                                                    <th><?php echo e(__('message.Action')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($key); ?></td>
                                                        <td><?php echo e($value); ?></td>
                                                        <td>
                                                            <a href="<?php echo e(route('languages.edit', ['lang' => $lang, 'key' => $key])); ?>"
                                                                class="btn  text-primary"><i class="fas fa-edit"></i></a>
                                                            
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>

                                    <!-- Arabic Tab -->
                                    <div class="tab-pane fade <?php echo e($lang == 'ar' ? 'show active' : ''); ?>" id="contact"
                                        role="tabpanel" aria-labelledby="ar_lang">
                                        <div class="table-responsive p-3">
                                        <table id="ar_lang_table" class="table table-bordered dt-responsive tablels"
                                            style="width: 100%;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th><?php echo e(__('message.Key')); ?></th>
                                                    <th><?php echo e(__('message.Value')); ?></th>
                                                    <th><?php echo e(__('message.Action')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($key); ?></td>
                                                        <td><?php echo e($value); ?></td>
                                                        <td>
                                                            <a href="<?php echo e(route('languages.edit', ['lang' => $lang, 'key' => $key])); ?>"
                                                                class="btn  text-primary"><i class="fas fa-edit"></i></a>
                                                            
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>

                                    <!-- French Tab -->
                                    <div class="tab-pane fade <?php echo e($lang == 'fr' ? 'show active' : ''); ?>" id="home3"
                                        role="tabpanel" aria-labelledby="fr_lang">
                                        <div class="table-responsive p-3">
                                        <table id="fr_lang_table" class="table table-bordered dt-responsive tablels"
                                            style="width: 100%;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th><?php echo e(__('message.Key')); ?></th>
                                                    <th><?php echo e(__('message.Value')); ?></th>
                                                    <th><?php echo e(__('message.Action')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($key); ?></td>
                                                        <td><?php echo e($value); ?></td>
                                                        <td>
                                                            <a href="<?php echo e(route('languages.edit', ['lang' => $lang, 'key' => $key])); ?>"
                                                                class="btn  text-primary"><i class="fas fa-edit"></i></a>
                                                            
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>

                                    <!-- spinach  Tab -->
                                    <div class="tab-pane fade <?php echo e($lang == 'es' ? 'show active' : ''); ?>" id="home4"
                                        role="tabpanel" aria-labelledby="es_lang">
                                        <div class="table-responsive p-3">
                                        <table id="es_lang_table" class="table table-bordered dt-responsive tablels"
                                            style="width: 100%;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th><?php echo e(__('message.Key')); ?></th>
                                                    <th><?php echo e(__('message.Value')); ?></th>
                                                    <th><?php echo e(__('message.Action')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($key); ?></td>
                                                        <td><?php echo e($value); ?></td>
                                                        <td>
                                                            <a href="<?php echo e(route('languages.edit', ['lang' => $lang, 'key' => $key])); ?>"
                                                                class="btn  text-primary"><i class="fas fa-edit"></i></a>
                                                            
                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>

                                    <!-- Portuguese Tab -->
                                    <div class="tab-pane fade <?php echo e($lang == 'pt' ? 'show active' : ''); ?>" id="home5"
                                        role="tabpanel" aria-labelledby="pt_lang">
                                        <div class="table-responsive p-3">
                                        <table id="pt_lang_table" class="table table-bordered dt-responsive tablels"
                                            style="width: 100%;">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th><?php echo e(__('message.Key')); ?></th>
                                                    <th><?php echo e(__('message.Value')); ?></th>
                                                    <th><?php echo e(__('message.Action')); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($key); ?></td>
                                                        <td><?php echo e($value); ?></td>
                                                        <td>
                                                            <a href="<?php echo e(route('languages.edit', ['lang' => $lang, 'key' => $key])); ?>"
                                                                class="btn  text-primary"><i class="fas fa-edit"></i></a>
                                                            
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
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/freakd1c/public_html/demo/bookappointment/resources/views/admin/languages/index.blade.php ENDPATH**/ ?>