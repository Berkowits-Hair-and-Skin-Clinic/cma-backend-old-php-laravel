<?php $__env->startSection('title'); ?>
<?php echo e(__('message.Appointment List')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-data'); ?>
<meta property="og:type" content="website"/>
<meta property="og:url" content="<?php echo e(__('message.System Name')); ?>"/>
<meta property="og:title" content="<?php echo e(__('message.System Name')); ?>"/>
<meta property="og:image" content="<?php echo e(asset('public/image_web/').'/'.$setting->favicon); ?>"/>
<meta property="og:image:width" content="250px"/>
<meta property="og:image:height" content="250px"/>
<meta property="og:site_name" content="<?php echo e(__('message.System Name')); ?>"/>
<meta property="og:description" content="<?php echo e(__('message.meta_description')); ?>"/>
<meta property="og:keyword" content="<?php echo e(__('message.Meta Keyword')); ?>"/>
<link rel="shortcut icon" href="<?php echo e(asset('public/image_web/').'/'.$setting->favicon); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<section class="registration-section bg-color-3">
    <div class="pattern">
        <div class="pattern-1" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-85.png')); ?>');"></div>
        <div class="pattern-2" style="background-image: url('<?php echo e(asset('public/front_pro/assets/images/shape/shape-86.png')); ?>');"></div>
    </div>
    <div class="auto-container">
        <a class=" mb-2" href="<?php echo e(url('backtoappointment')); ?>" style="color:black; text-decoration: underline;" ><?php echo e(__('message.Back to appointment')); ?></a>
        <!--<i class="fa fa-arrow-left" aria-hidden="true"></i>-->
            <div class="content-box">
                <div class="title-box">
                    <h3><?php echo e(__('Appointment Details')); ?></h3>
                </div>
                <div class="inner">
                    <div class="single-item">

                        <div class="row">
                            <div class="col-lg-4 col-xs-3">
                                <figure class="image-box">
                                    <?php if($am->patientls->profile_pic!=""): ?>
                                        <img src="<?php echo e(asset('public/upload/profile').'/'.$am->patientls->profile_pic); ?>" alt="">
                                    <?php else: ?>
                                         <img src="<?php echo e(asset('public/upload/profile/profile.png')); ?>" alt="">
                                    <?php endif; ?>
                                  </figure>
                            </div>
                            <div class="col-lg-4 col-xs-8">
                                  <h4><?php echo e($am->patientls->name); ?></h4>
                                  <ul class="info-list clearfix">
                                      <li><i class="fas fa-clock"></i> <?php echo e(date("F d,Y",strtotime($am->date))); ?>, <?php echo e($am->slot_name); ?></li>
                                      <li><i class="fas fa-envelope"></i> <?php echo e($am->patientls->email); ?></li>
                                      <li><i class="fas fa-phone"></i> <?php echo e($am->phone); ?></li>
                                      <li><i class="fas fa-user"></i><a href="#"><?php echo e($am->service_therapist_detail); ?></a></li>
                                      <li><i class="fas fa-sticky-note"></i>
                                         <?php echo e($am->user_description); ?>

                                      </li>
                                       <?php if($am->prescription_file!=""): ?>
                                     <li><a href="<?php echo e(asset('public/upload/prescription').'/'.$am->prescription_file); ?>" target="_blank" class="btn btn-success" style="color:white"><?php echo e(__("message.View Prescription")); ?></a></li>
                                     <?php endif; ?>
                                       <li style="position: relative; display: inline-block;font-size: 13px;line-height: 16px; font-weight: 600;padding: 5px 15px; border-radius: 15px; background: #ebfbf3;color: #39dc86;">
                                       <?php
                                              if($am->status=='1'){
                                                   echo __("message.Received");
                                              }else if($am->status=='2'){
                                                   echo __("message.Approved");
                                              }else if($am->status=='3'){
                                                   echo __("message.In Process");
                                              }
                                              else if($am->status=='4'){
                                                   echo __("message.Completed");
                                              }
                                              else if($am->status=='5'){
                                                   echo __("message.Rejected");
                                              }else{
                                                   echo __("message.Absent");
                                              }
                                       ?>
                                     </li>

                                  </ul>
                            </div>
                            <div class="col-lg-3 col-xs-12">
                                <button style="width: 100%;" type="button" class="theme-btn-one" data-toggle="modal" data-target="#add_Prescription"><?php echo e(__("message.Add Prescription")); ?></button><br><br>
                                <button style="width: 100%;" type="button" class="theme-btn-one" data-toggle="modal" data-target="#add_report"><?php echo e(__("message.Add Report")); ?></button>
                            </div>
                        </div>
                        <hr />
                        <div class="row pt-4">

                            <h4 class="pl-3"><?php echo e(__("Prescription Details")); ?></h4>
                            <?php if(count($app_medicine) > 0): ?>
                            <?php $__currentLoopData = $app_medicine; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a_m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php
                                $m = json_decode($a_m->medicines);
                                $aa = $m->medicine;
                            ?>

                                <div class="col-10">
                                    <?php $__currentLoopData = $aa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="container ml-3 pt-2">
                                          <div class="row">
                                            <div id="m_name" class="col-10"><?php echo $aa->medicine_name; ?> </div>
                                          </div>
                                          <div class="row">

                                              <div class="col-3">
                                                  <?php echo e(__("message.Type")); ?>: <b><?php echo $aa->type; ?></b>
                                              </div>
                                              <div class="col-3">
                                                  <?php echo e(__("message.Dosage")); ?>: <b><?php echo $aa->dosage; ?></b>
                                              </div>
                                              <div class="col">
                                                  <div class="row ">
                                                     <?php echo e(__("message.Time")); ?>: <?php $__currentLoopData = $aa->time; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div class="card p-1 px-3 mx-1"> <?php echo $time->t_time; ?> </div> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                   </div>
                                              </div>

                                          </div>

                                          <div class="row">
                                            <div class="col"><?php echo e(__("message.Consume it for")); ?> <?php echo $aa->repeat_days; ?> <?php echo e(__("message.Days")); ?></div>
                                          </div>
                                          <hr>
                                        </div>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <div class="col-2">
                                    <a type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_Prescription" onclick="get_desc(<?php echo $a_m->id ?>)" ><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                    <a type="button" class="btn btn-outline-danger" href="<?php echo e(url('delete_prescription', $a_m->id)); ?>"><i class="fa fa-trash "></i></a>
                                </div>


                                    <hr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                            <div class="container m-2">
                                      <?php echo e(__("message.prescription details not found")); ?>

                             </div>
                            <?php endif; ?>

                        </div>
                        <div class="row mb-2">
                            <h4 class="pl-3"><?php echo e(__("message.Report Image")); ?></h4>

                        </div>
                        <div class="row ml-3">
                            <?php if(count($img) > 0): ?>
                                <?php $__currentLoopData = $img; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <div class="card p-2 m-1" style="width: 7rem; height: 100%;">
                                        <img src="<?php echo e(asset('public/upload/ap_img_up').'/'.$image->image); ?>" class="img-fluid" style="border-radius: 10px; flex-grow: 1;">

                                            <div class="h6 text-center mt-2">
                                                <?php echo e($image->name); ?>

                                            </div>
                                        <a type="button" class="btn btn-outline-danger mx-4" href="<?php echo e(url('delete_report', $image->id)); ?>"><i class="fa fa-trash "></i></a>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="container m-2">
                                    <?php echo e(__("message.Report not Uploaded")); ?>

                                </div>
                            <?php endif; ?>
                        </div>

                  </div>
                </div>
            </div>
    </div>

    <div class="modal fade" id="add_Prescription" tabindex="-1" aria-labelledby="exampleModalgridLabel">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title text-center" id="exampleModalgridLabel">
             <?php echo e(__("message.Add Prescription")); ?>

            </h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
        <form action="<?php echo e(url('save_prescription')); ?>" method="post">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="id" value="<?php echo e($apoid); ?>">
            <div class="modal-body">

               <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr"><?php echo e(__("message.Medicine")); ?> </label>
                        <input class="form-control" list="browsers" name="medicine" id="myInput" placeholder="<?php echo e(__('message.Search medicine')); ?>">
                    <datalist id="browsers" class="suggestions">

                    </datalist>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr"><?php echo e(__("message.Type")); ?></label>
                    <div class="custom-dropdown" id="timerange" style="width: 100%;margin-bottom: 10px;" >
                     <select class="" name="type"  required="" style="background:none; border:1px solid #E5E7EC;">
                        <option value="" > <?php echo e(__("message.select")); ?> <?php echo e(__("message.Type")); ?></option>
                        <option value="Tablet" >Tablet</option>
                       <option value="Injection" >Injection</option>
                  </select>
               </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr"><?php echo e(__("message.Dosage")); ?></label>
                    <input type="text" name="dosge" id="dosge" placeholder="<?php echo e(__('message.Enter')); ?> <?php echo e(__('message.Dosage')); ?>" required="">
                </div><br>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr"><?php echo e(__("message.Consum Days")); ?></label>
                    <input type="text" name="repeat_days" id="repeat_days" placeholder="<?php echo e(__('message.Enter')); ?> <?php echo e(__('message.Consum Days')); ?>" required="">
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr"><?php echo e(__("message.Consuming Time")); ?></label>
                    <div class="row">
                        <div class="col-10">
                            <input type="time" name="t_time[]" id="t_time" placeholder="<?php echo e(__('message.Enter')); ?> <?php echo e(__('message.Consuming Time')); ?>" required="" style="background:none; border:1px solid #E5E7EC;width: 100%;border-radius:10px;height: 50px;">
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-light" id="addmore">+</button>
                        </div>
                    </div><br>

                    <div id="showmore">

                    </div>

                </div>
                </div>

               <div class="modal-footer">
                 <button type="submit" class="btn btn-success"><?php echo e(__('message.Submit')); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e(__('message.Close')); ?></button>
              </div>
        </form>
      </div>
   </div>
</div>

<div class="modal fade" id="add_report" tabindex="-1" aria-labelledby="exampleModalgridLabel">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title text-center" id="exampleModalgridLabel">
              <?php echo e(__('message.Add Report')); ?>

            </h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form action="<?php echo e(url('save_prescription')); ?>" method="post" enctype="multipart/form-data" class="registration-form">
              <?php echo e(csrf_field()); ?>

              <input type="hidden" name="id" value="<?php echo e($apoid); ?>">
              <div class="modal-body">

                  <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr"><?php echo e(__('message.Name')); ?></label>
                    <input type="text" name="name" id="name" placeholder="<?php echo e(__('message.Enter')); ?> <?php echo e(__('message.Name')); ?>" required="">
                </div>

                   <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                        <label class="fr"><?php echo e(__('message.Upload Report')); ?></label>
                        <input type="file" name="report_img" required>
                    </div>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                 <button type="submit" class="btn btn-success"><?php echo e(__('message.Submit')); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e(__('message.Close')); ?></button>
              </div>
        </form>
      </div>
   </div>
</div>


<div class="modal fade" id="edit_Prescription" tabindex="-1" aria-labelledby="exampleModalgridLabel">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title text-center" id="exampleModalgridLabel">
              <?php echo e(__("message.Edit Prescription")); ?>

            </h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
        <form action="<?php echo e(url('edit_prescription')); ?>" method="post">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="id1" id="id1" value="">
            <div class="modal-body">

               <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr"><?php echo e(__("message.Medicine")); ?></label>
                        <input class="form-control" list="browsers" name="medicine" id="myInput1" placeholder="Search medicine">
                    <datalist id="browsers" class="suggestions">

                    </datalist>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr"><?php echo e(__("message.Type")); ?></label>
                    <div class="custom-dropdown" id="timerange" style="width: 100%;margin-bottom: 10px;" >
                     <select class="" name="type"  required="" style="background:none; border:1px solid #E5E7EC;">
                        <option value="" ><?php echo e(__("message.select")); ?> <?php echo e(__("message.Type")); ?></option>
                        <option value="Tablet" >Tablet</option>
                       <option value="Injection" >Injection</option>
                  </select>
               </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr"><?php echo e(__("message.Dosage")); ?></label>
                    <input type="text" name="dosge" id="dosge1" placeholder="<?php echo e(__('message.Enter')); ?> <?php echo e(__('message.Dosage')); ?>" required="">
                </div><br>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr"><?php echo e(__("message.Consum Days")); ?></label>
                    <input type="text" name="repeat_days" id="repeat_days1" placeholder="<?php echo e(__('message.Enter')); ?> <?php echo e(__('message.Consum Days')); ?>" required="">
                </div><br>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr"><?php echo e(__("message.Consuming Time")); ?></label><br>
                    <div class="row">
                        <div class="col-10">
                            <input type="time" name="t_time[]" id="t_time1" placeholder="<?php echo e(__('message.Enter')); ?> <?php echo e(__('message.Consuming Time')); ?>" required="" style="background:none; border:1px solid #E5E7EC;width: 100%;border-radius:10px;height: 50px;">
                        </div>
                        <div class="col-10">
                            <button type="button" class="btn btn-light" id="addmore1">+</button>
                        </div>
                    </div><br>

                    <div id="showmore1">

                    </div>

                </div>
                </div>

               <div class="modal-footer">
                 <button type="submit" class="btn btn-success"><?php echo e(__('message.Submit')); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e(__('message.Close')); ?></button>
              </div>
        </form>
      </div>
   </div>
</div>

<input type="hidden" name="url" id="url" value="<?php echo e(url('/')); ?>"></input>

<script>
    $(document).ready(function() {
    $('#addmore').click(function(event) {
        event.preventDefault();
        $('#showmore').append(
            '<div class="row mb-4">' +
                '<div class="col-10">' +
                    '<input type="time" name="t_time[]" id="t_time" placeholder="Enter time" required="" style="background:none; border:1px solid #E5E7EC;width: 100%;border-radius:10px;height: 50px;">' +
                '</div>' +
                '<div class="col">' +
                    '<button type="button" class="btn btn-light remove">-</button>' +
                '</div>' +
            '</div>'
        );
    });

    $('#showmore').on("click", ".remove", function(e) {
        e.preventDefault();
        $(this).closest('.row').remove();
    });
});

$(document).ready(function() {
    $('#addmore1').click(function(event) {
        event.preventDefault();
        $('#showmore1').append(
            '<div class="row mb-4">' +
                '<div class="col-10">' +
                    '<input type="time" name="t_time[]" id="t_time" placeholder="Enter time" required="" style="background:none; border:1px solid #E5E7EC;width: 100%;border-radius:10px;height: 50px;">' +
                '</div>' +
                '<div class="col">' +
                    '<button type="button" class="btn btn-light remove">-</button>' +
                '</div>' +
            '</div>'
        );
    });

    $('#showmore').on("click", ".remove", function(e) {
        e.preventDefault();
        $(this).closest('.row').remove();
    });
});

$(document).ready(function () {
    $('#myInput').on('input', function () {
        var inputText = $(this).val();

        if(inputText == null){
            $('#suggestions').empty();
                $('#browsers').empty();
        }else{
            var url = $('#url').val();
        $.ajax({
            url: url + '/   ',
            method: 'GET',
            data: { inputText: inputText },
            success: function (data) {
                $('.suggestions').empty();

                data.suggestions.forEach(function (suggestion) {
                    $('.suggestions').append($('<option>').val(suggestion));
                });

            },
            error: function (error) {
                console.error(error);
            }
        });


        }

    });
});

$(document).ready(function () {
    $('#myInput1').on('input', function () {
        var inputText = $(this).val();

        if(inputText == null){
            $('#suggestions').empty();
                $('#browsers').empty();
        }else{
            var url = $('#url').val();
        $.ajax({
            url: url + '/getmedicines',
            method: 'GET',
            data: { inputText: inputText },
            success: function (data) {
                $('.suggestions').empty();

                data.suggestions.forEach(function (suggestion) {
                    $('.suggestions').append($('<option>').val(suggestion));
                });

            },
            error: function (error) {
                console.error(error);
            }
        });


        }

    });
});


function get_desc(id){
      $("#m_data").empty();
      $.ajax({

        url:$("#url").val()+"/get-user-appointment1"+"/"+id,
        data: { },
        success: function(data)
        {
          console.log(data);
            if(data.medicine){
                var medicines = data.medicine.medicine;
                $('#id1').val(data.id);
                for (var i = 0; i < medicines.length; i++) {

                for (var j = 0; j < medicines[i].time.length; j++) {
                    var tTime = medicines[i].time[j].t_time;
                  }
                        $('select[name="type"]').val(medicines[i].type);
                        $('#myInput1').append($('#myInput1').val(medicines[i].medicine_name));
                        $('#dosge1').append($('#dosge1').val(medicines[i].dosage));
                        $('#repeat_days1').append($('#repeat_days1').val(medicines[i].repeat_days));

                        var timesContainer = $('#showmore1');
                        timesContainer.empty(); // Clear previous entries

                        for (var j = 0; j < medicines[i].time.length; j++) {
                             var tTime = medicines[i].time[j].t_time;
                            if(j === 0) {
                               $('#t_time1').append($('#t_time1').val(tTime));
                             } else {

                            var timeInput = '<div class="row mb-4">' +
                                               '<div class="col-10">' +
                                                   '<input type="time" name="t_time[]" value="' + tTime + '" required style="background:none; border:1px solid #E5E7EC;width: 100%;border-radius:10px;height: 50px;">' +
                                               '</div>' +
                                               '<div class="col">' +
                                                   '<button type="button" class="btn btn-light remove">-</button>' +
                                               '</div>' +
                                            '</div>';

                            timesContainer.append(timeInput);
                             }


                        }
                  }
            }else{
                $("#m_data").append( '<?php echo e(__('message.Prescription not found')); ?>');
            }

        }
       });

       $(document).on('click', '.remove', function() {
    $(this).closest('.row').remove();
});
    }


</script>

</section>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/user/doctor/prescription.blade.php ENDPATH**/ ?>