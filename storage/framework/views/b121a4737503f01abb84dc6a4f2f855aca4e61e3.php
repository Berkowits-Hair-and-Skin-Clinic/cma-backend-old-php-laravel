<?php $__env->startSection('title'); ?>
<?php echo e(__("message.banner")); ?> | <?php echo e(__("message.Admin")); ?> <?php echo e(__("message.banner")); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('meta-data'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="main-content">
   <div class="page-content">
      <div class="container-fluid">

         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-body">
                     <?php if(Session::has('message')): ?>
                     <div class="col-sm-12">
                        <div class="alert  <?php echo e(Session::get('alert-class', 'alert-info')); ?> alert-dismissible fade show" role="alert"><?php echo e(Session::get('message')); ?>

                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                     </div>
                     <?php endif; ?>
                     <h4 class="card-title float-left"><?php echo e(__("message.banner")); ?> <?php echo e(__("message.List")); ?></h4>
                      <p><a class="btn btn-primary float-right" data-toggle="modal" data-target="#staticBackdrop" style="color: white;"><?php echo e(__("message.Add Banner")); ?></a></p>
                      <div class="table-responsive p-3">
                     <table id="bannertable" class="table table-bordered dt-responsive tablels">
                        <thead class="thead-light">
                           <tr>
                              <th><?php echo e(__("message.Id")); ?></th>
                              <th><?php echo e(__("message.Image")); ?></th>
                              <th><?php echo e(__("message.Action")); ?></th>
                           </tr>
                        </thead>
                     </table>
                      </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
 <input type="hidden" id="site" value="<?php echo e(url('/')); ?>" />
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?php echo e(__("message.Add Banner")); ?></h5>
      </div>

      <form action="<?php echo e(url('admin/savebanner')); ?>" class="needs-validation" method="post" enctype="multipart/form-data">
        <?php echo e(csrf_field()); ?>

          <div class="modal-body">
            <main class="main_full">
              <div class="container">
                <div class="panel">
                  <div class="button_outer">
                    <div class="btn_upload">
                     <label><?php echo e(__("message.Upload Image")); ?></label>
                      <input type="file" id="upload_file" name="image[]" multiple required>

                    </div>
                    <div class="processing_bar"></div>
                    <div class="success_box"></div>
                  </div>
                </div>
                <div class="error_msg"></div>

              </div>
            </main>
          </div>
          <center>
          <div style="padding: 0.75rem; border-top: 1px solid #f5f6f8;border-bottom-right-radius: calc(0.3rem - 1px);border-bottom-left-radius: calc(0.3rem - 1px);">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('message.Close')); ?></button>
          <!--<button type="submit" class="btn btn-primary">Submit</button>-->
           <?php if(Session::get("is_demo")=='0'): ?>
              <button type="button" onclick="disablebtn()" class="btn btn-primary"><?php echo e(__('message.Submit')); ?></button>
           <?php else: ?>
               <button  class="btn btn-primary" type="submit" value="Submit"><?php echo e(__("message.Submit")); ?></button>
           <?php endif; ?>
          </div>
          </center>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="Backdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><?php echo e(__("message.Edit Banner")); ?></h5>
      </div>

      <form action="<?php echo e(url('admin/updatebanner')); ?>" class="needs-validation" method="post" enctype="multipart/form-data">
        <?php echo e(csrf_field()); ?>

          <div class="modal-body">
            <main class="main_full">
              <div class="container">
                <div class="panel">
                  <div class="button_outer">
                    <div class="btn_upload">
                     <label><?php echo e(__("message.Upload Image")); ?></label>
                     <img src="" width=50 id="banner_image" style="width:70%">
                      <input type="file" id="upload_file" name="image" multiple required>

                     <input type="hidden" name="id" id="img_id">

                    </div>
                    <div class="processing_bar"></div>
                    <div class="success_box"></div>
                  </div>
                </div>
                <div class="error_msg"></div>

              </div>
            </main>
          </div>
          <center>
          <div style="padding: 0.75rem; border-top: 1px solid #f5f6f8;border-bottom-right-radius: calc(0.3rem - 1px);border-bottom-left-radius: calc(0.3rem - 1px);">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('message.Close')); ?></button>
           <?php if(Session::get("is_demo")=='0'): ?>
              <button type="button" onclick="disablebtn()" class="btn btn-primary"><?php echo e(__('message.Submit')); ?></button>
           <?php else: ?>
               <button  class="btn btn-primary" type="submit" value="Submit"><?php echo e(__("message.Submit")); ?></button>
           <?php endif; ?>
          </div>
          </center>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer'); ?>
<script>

function edit_img(id){
    $("#img_id").val(id);
    $.ajax({

         url:$("#siteurl").val()+"/edit-img"+"/"+id,
         data: { },
         success: function(data)
         {
            var url=$("#site").val()+"/public/upload/banner"+"/"+data;

            $("#banner_image").attr("src",url);
            // $("#stone_name").val(data.name);
         }
        });

}

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/berkowits/cma-backend/resources/views/admin/banner/default.blade.php ENDPATH**/ ?>