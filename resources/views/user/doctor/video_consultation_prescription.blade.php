@extends('user.layout')
@section('title')
{{__('Video Consultation Details')}}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{__('message.System Name')}}"/>
<meta property="og:title" content="{{__('message.System Name')}}"/>
<meta property="og:image" content="{{asset('public/image_web/').'/'.$setting->favicon}}"/>
<meta property="og:image:width" content="250px"/>
<meta property="og:image:height" content="250px"/>
<meta property="og:site_name" content="{{__('message.System Name')}}"/>
<meta property="og:description" content="{{__('message.meta_description')}}"/>
<meta property="og:keyword" content="{{__('message.Meta Keyword')}}"/>
<link rel="shortcut icon" href="{{asset('public/image_web/').'/'.$setting->favicon}}">
<meta name="viewport" content="width=device-width, initial-scale=1">
@stop
@section('content')

<section style="margin-top: -100px;" class="registration-section bg-color-2">
    <div class="auto-container">
        <a class=" mb-2" href="{{url('videoconsultationlist')}}" style="color:white; text-decoration: underline;" >{{__('Back to consultation list')}}</a>
        <!--<i class="fa fa-arrow-left" aria-hidden="true"></i>-->
            <div class="content-box">
                <div class="title-box">
                    <h3>{{__('Video Consultation Details')}}</h3>
                </div>
                <div class="inner">
                    <div class="single-item">

                        <div class="row">
                            <div class="col-lg-4 col-xs-3">
                                <figure class="image-box">
                                        <?php 
                                            switch(strtolower($am->gender)){
                                                case 'male':
                                                    ?><img width="200px" height="200px" src="{{asset('public/upload/profile/profile.png')}}" alt=""><?php
                                                break;
                                                case 'female':
                                                    ?><img width="200px" height="200px" src="{{asset('public/upload/profile/profilefemale2.png')}}" alt=""><?php
                                                break;
                                            }
                                        ?>
                                        
                                  </figure>
                            </div>
                            <div class="col-lg-4 col-xs-8">
                                  <h4>{{ucwords($am->firstname)}} {{ucwords($am->lastname)}}</h4>
                                  <ul class="info-list clearfix">
                                    <li><i class="fas fa-user"></i> {{$am->gender}}</li>
                                      <li><i class="fas fa-clock"></i> {{date("F d,Y",strtotime($am->preferred_date))}}, {{$am->time_slot}}</li>
                                      <li><i class="fas fa-envelope"></i> {{$am->email}}</li>
                                      <li><i class="fas fa-phone"></i> {{$am->phone}}</li>
                                      <?php 
                                      $doctor_details=json_decode($am->doctor_details,true);
                                      ?>
                                      <li><i class="fas fa-user"></i><span> Assigned to {{$doctor_details['name']}}</span><br /></li>
                                       @if($am->prescription_file!="")
                                     <li><a href="{{asset('public/upload/prescription').'/'.$am->prescription_file}}" target="_blank" class="btn btn-success" style="color:white"> {{__("message.View Prescription")}}</a></li>
                                     @endif
                                       <li style="position: relative; display: inline-block;font-size: 13px;line-height: 16px; font-weight: 600;padding: 5px 15px; border-radius: 15px; background: #ebfbf3;color: #39dc86;">
                                            <span>{{ucwords($am->status)}}</span>
                                     </li>
                                     <hr />

                                   </ul>
                                <?php 
                                    if($am->status=="pending"){
                                        ?>
                                        <a style="margin-right: 30px;" href="#" data-toggle="modal" data-target="#mark_completed"><i class="fas fa-check"></i>{{ __(' Mark Completed') }}</a>
                                        <a style="margin-right: 30px;" href="#" data-toggle="modal" data-target="#mark_absent"><i class="fas fa-times"></i>{{ __(' Mark Absent') }}</a>
                                        <?php
                                    

                                    }
                                ?>

                            </div>
                            <div class="col-lg-4 col-xs-12" style="background-color: #FAF9F6;">
                                <a style="width: 100%;color:black"  type="button" class="theme-btn-two" data-toggle="modal" data-target="#add_Prescription"><i style="color: black;font-size:larger;margin-right:10px" class="fa fa-plus"></i>{{__("Add Products/Medicine")}}</a><br>
                                <a style="width: 100%;color:black"  type="button" class="theme-btn-two" data-toggle="modal" data-target="#add_treatment"><i style="color: black;font-size:larger;margin-right:10px" class="fa fa-plus"></i>{{__("Add Treatment/Service")}}</a><br>
                                <a style="width: 100%;color:black"  type="button" class="theme-btn-two" data-toggle="modal" data-target="#add_diagnosis"><i style="color: black;font-size:larger;margin-right:10px" class="fa fa-plus"></i>{{__("Add Diagnosis")}}</a><br>
                                <a style="width: 100%;color:black"  type="button" class="theme-btn-two" data-toggle="modal" data-target="#add_report"><i style="color: black;font-size:larger;margin-right:10px;margin-left:-15px" class="fa fa-file"></i>{{__("message.Add Report")}}</a><br>
                                <?php 
                                    if($am->status=="completed"){
                                        ?>
                                            <button disabled=true style="width: 100%;color:black" type="button" class="theme-btn-two" data-toggle="modal" data-target="#start_video_consultation"><i style="color: black;font-size:larger;margin-right:10px" class="fa fa-video"></i>{{__("Start Consultation")}}</button>
                                            <br /><small>This consultation status is completed. So [Start Consultation] button is inactive now!</small>
                                        <?php
                                    }
                                    if($am->status=="pending"){
                                        ?><a href="<?=$am->google_meet_link?>" target="_blank"  style="width: 100%;color:black" type="button" class="theme-btn-two"><i style="color: black;font-size:larger;margin-right:10px" class="fa fa-video"></i> {{__("Start  Consultation")}}</a><?php
                                    }
                                ?>
                                
                                
                            </div>
                        </div>
                        <hr />
                        <div class="row pt-4">

                            <h5 class="pl-3">{{__("Prescription Details")}}</h5>
                            @if(count($app_medicine) > 0)
                            @foreach($app_medicine as $a_m)

                            @php
                                $m = json_decode($a_m->medicines);
                                $aa = $m->medicine;
                            @endphp

                                <div class="col-10">
                                    @foreach($aa as $aa)
                                        <div class="container ml-3 pt-2">
                                          <div class="row">
                                            <div id="m_name" class="col-10"><b><?php echo $aa->medicine_name; ?></b></div>
                                          </div>
                                          <div class="row">

                                              <div class="col-3">
                                                  {{__("message.Type")}}: <b><?php echo $aa->type; ?></b>
                                              </div>

                                          </div>
                                          <hr>
                                        </div>

                                    @endforeach
                                </div>
                                <div class="col-2">
                                    <!--<a type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#edit_Prescription" onclick="get_desc(<?php echo $a_m->id ?>)" ><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                    <a type="button" class="btn btn-outline-danger" href="{{ url('delete_prescription', $a_m->id) }}"><i class="fa fa-trash "></i></a>-->
                                </div>


                                    <hr>
                            @endforeach
                            <div class="container m-2">
                                <a target="_blank" href="{{url('view_consultation_prescription',$am->encryption_id)}}" class="theme-btn-two"><i style="color: black;font-size:larger;margin-right:10px" class="fa fa-file "></i> {{__('View Prescription File')}}</a>
                                <a target="_blank" href="#" data-toggle="modal" data-target="#share_prescription"  class="theme-btn-two"><i style="color: black;font-size:larger;margin-right:10px" class="fa fa-share-alt"></i> Share Prescription</a>
                                <a href="{{url('share_consultation_checkout_link',$am->encryption_id)}}"  class="theme-btn-two"><i style="color: black;font-size:larger;margin-right:10px" class="fa fa-share-alt"></i> Share Ecommerce Checkout</a>
                            </div>
                            @else
                            <div class="container m-2">
                                      {{__("message.prescription details not found")}}
                             </div>
                            @endif

                        </div>
                        <hr />
                        <div class="row pt-4">
                            <h5 class="pl-3">Reports</h5>

                        </div>
                        <div class="row pt-4">
                            @if(count($img) > 0)
                                @foreach($img as $image)

                                    <div class="card p-2 m-1" style="width: 7rem; height: 100%;">
                                        <img src="{{ asset('public/upload/ap_img_up').'/'.$image->image }}" class="img-fluid" style="border-radius: 10px; flex-grow: 1;">

                                            <div class="h6 text-center mt-2">
                                                {{ $image->name }}
                                            </div>
                                        <a type="button" class="btn btn-outline-danger mx-4" href="{{ url('delete_report', $image->id) }}"><i class="fa fa-trash "></i></a>
                                    </div>
                                @endforeach
                            @else
                                <div class="container m-2">
                                    {{__("message.Report not Uploaded")}}
                                </div>
                            @endif
                        </div>

                        <hr />
                        <!-- Consultation Treatment-->
                            <div class="row pt-4">
                                <h5 class="pl-3">Treatment</h5><br />
                            </div>
                            <div class="row pt-4">
                                <?php 
                                    $consultation_treatment_list=$consultation_treatment;
                                    if(count($consultation_treatment_list)>0){
                                        foreach ($consultation_treatment_list as $row_treatment){
                                            ?>
                                            <div class="row">
                                                <div class="col-12">
                                                <?= htmlspecialchars($row_treatment->treatment_name) ?> 
                                                </div>
                                                <div class="col-12">
                                                <?= htmlspecialchars($row_treatment->treatment_details) ?> 
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        
                                    }
                                ?>
                            </div>
                        <!-- End -->
                        <!-- Consultation Diagnosis-->
                        <div class="row pt-4">
                                <h5 class="pl-3">Diagnosis</h5><br />
                            </div>
                            <div class="row pt-4">
                                <?php 
                                    $consultation_diagnosis_list=$consultation_diagnosis;
                                    if(count($consultation_diagnosis_list)>0){
                                        foreach ($consultation_diagnosis_list as $row_diagnosis){
                                            ?>
                                                <p><?= htmlspecialchars($row_diagnosis->diagnosis_point) ?> </p><br />
                                            <hr />
                                            <?php
                                        }
                                        
                                    }
                                ?>
                            </div>
                        <!-- End -->
                        <div class="row pt-4">
                            <h5 class="pl-3">Logs</h5><br />
                        </div>
                        <div class="row pt-4">
                            <?php 
                                $logs=$consultation_logs;
                            ?>
                            <table>
                                <?php 
                                    if(count($logs)>0){
                                    ?>
                                    <tr>
                                        <th>ID</th>
                                        <th>Message</th>
                                        <th>Log Type</th>
                                        <th>Time</th>
                                    </tr>
                                        <?php
                                    }
                                ?>
                                <?php foreach ($logs as $log): ?>
                                    <?php $details = json_decode($log->log_details, true); ?>
                                    <tr>
                                        <td style="padding: 12px;"> <?= htmlspecialchars($log->encryption_id) ?> </td>
                                        <td style="padding: 12px;"> <?= htmlspecialchars($details['log_activity']) ?> </td>
                                        <td style="padding: 12px;"> <?= htmlspecialchars($log->log_type) ?> </td>
                                        <td style="padding: 12px;"> <?= htmlspecialchars($log->created_at) ?> </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
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
             {{__("Add Consultation Prescription")}}
            </h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
        <form action="{{url('save_consultation_prescription')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="id" value="{{$apoid}}">
            <div class="modal-body">

               <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Medicine")}} </label>
                        <input class="form-control" list="browsers" name="medicine" id="myInput1" placeholder="{{__('message.Search medicine')}}">
                    <datalist id="browsers" class="suggestions">

                    </datalist>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Type")}}</label>
                    <div class="custom-dropdown" id="timerange" style="width: 100%;margin-bottom: 10px;" >
                     <select class="" name="type"  required="" style="background:none; border:1px solid #E5E7EC;">
                        <option value="" > {{__("message.select")}} {{__("message.Type")}}</option>
                        <option value="Liquid" >Liquid</option>
                        <option value="Tablet" >Tablet</option>
                        <option value="Capsule" >Capsule</option>
                        <option value="Gel" >Gel</option>
                        <option value="Injection" >Injection</option>
                        <option value="Others" >Others</option>
                  </select>
               </div>
                </div>

                <!--<div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Dosage")}}</label>
                    <input type="text" name="dosge" id="dosge" placeholder="{{__('message.Enter')}} {{__('message.Dosage')}}" required="">
                </div><br>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Consum Days")}}</label>
                    <input type="text" name="repeat_days" id="repeat_days" placeholder="{{__('message.Enter')}} {{__('message.Consum Days')}}" required="">
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Consuming Time")}}</label>
                    <div class="row">
                        <div class="col-10">
                            <input type="time" name="t_time[]" id="t_time" placeholder="{{__('message.Enter')}} {{__('message.Consuming Time')}}" required="" style="background:none; border:1px solid #E5E7EC;width: 100%;border-radius:10px;height: 50px;">
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-light" id="addmore">+</button>
                        </div>
                    </div><br>

                    <div id="showmore">

                    </div>

                </div>-->
                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("Notes")}}</label>
                    <textarea class="form-control" id="notes_text" name="notes_text" rows="3"></textarea>
                </div>
                </div>

               <div class="modal-footer">
                 <button type="submit" class="btn btn-success">{{__('message.Submit')}}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('message.Close')}}</button>
              </div>
        </form>
      </div>
   </div>
</div>
<!-- Add Diagnosis -->
<div class="modal fade" id="add_diagnosis" tabindex="-1" aria-labelledby="exampleModalgridLabel">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title text-center" id="exampleModalgridLabel">
              {{__('Add Diagnosis')}}
            </h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form action="{{url('save_consultation_prescription')}}" method="post" enctype="multipart/form-data" class="registration-form">
              {{csrf_field()}}
              <input type="hidden" name="id" value="{{$apoid}}">
              <div class="modal-body">

              <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("Write Diagnosis")}}</label>
                    <textarea class="form-control" name="disgnosis_details" id="disgnosis_details" rows="3"></textarea>
                </div>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                <input type="hidden" name="add_type" value="add_diagnosis" />
                 <button type="submit" class="btn btn-success">{{__('message.Submit')}}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('message.Close')}}</button>
              </div>
        </form>
      </div>
   </div>
</div>
<!-- Add treatment -->
<div class="modal fade" id="add_treatment" tabindex="-1" aria-labelledby="exampleModalgridLabel">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title text-center" id="exampleModalgridLabel">
              {{__('Add Treatment/Service')}}
            </h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form action="{{url('save_consultation_prescription')}}" method="post" enctype="multipart/form-data" class="registration-form">
              {{csrf_field()}}
              <input type="hidden" name="id" value="{{$apoid}}">
              <div class="modal-body">

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__('message.Name')}}</label>
                    <input type="text" name="treatment_name" id="treatment_name" placeholder="{{__('message.Enter')}} {{__('Treatment Name')}}" required="">
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("Treatment Details")}}</label>
                    <textarea class="form-control" name="treatment_details" id="treatment_details" rows="3"></textarea>
                </div>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                <input type="hidden" name="add_type" value="add_treatment" />
                 <button type="submit" class="btn btn-success">{{__('message.Submit')}}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('message.Close')}}</button>
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
              {{__('message.Add Report')}}
            </h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form action="{{url('save_consultation_prescription')}}" method="post" enctype="multipart/form-data" class="registration-form">
              {{csrf_field()}}
              <input type="hidden" name="id" value="{{$apoid}}">
              <div class="modal-body">

                  <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__('message.Name')}}</label>
                    <input type="text" name="name" id="name" placeholder="{{__('message.Enter')}} {{__('message.Name')}}" required="">
                </div>

                   <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                        <label class="fr">{{__('message.Upload Report')}}</label>
                        <input type="file" name="report_img" required>
                    </div>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                 <button type="submit" class="btn btn-success">{{__('message.Submit')}}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('message.Close')}}</button>
              </div>
        </form>
      </div>
   </div>
</div>
<div class="modal fade" id="share_prescription" tabindex="-1" aria-labelledby="exampleModalgridLabel">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title text-center" id="exampleModalgridLabel">
              {{__('Share Prescription')}}
            </h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form action="{{url('share_video_consulattion_prescription')}}" method="post" enctype="multipart/form-data" class="registration-form">
              {{csrf_field()}}
              <input type="hidden" name="id" value="{{$apoid}}">
              <div class="modal-body">
                <b><label>Share with client</label></b>
                <p>The prescription link will be shared with the client via WhatsApp and SMS to the number {{$am->phone}}</p>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                <?php $prescription_url=env('APP_URL')."view_consultation_prescription/".$am->encryption_id; ?>
                <input type="hidden" name="phone" id="" value="{{$am->phone}}" />
                <input type="hidden" name="client_name" id="client_name" value="{{ucwords($am->firstname)}}" />
                <input type="hidden" name="doctor_name" id="doctor_name" value="{{$doctor_details['name']}}" />
                <input type="hidden" name="prescription_url" id="prescription_url" value="{{$prescription_url}}" />
                <input type="hidden" name="consultation_id" value="{{$apoid}}">
                <input type="hidden" name="encryption_id" value="{{$consultation_encryption_id}}">
                 <button type="submit" class="btn btn-success">{{__('Send')}}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('message.Close')}}</button>
              </div>
        </form>
        <br />
        <div align='center'><b><h5>OR</h5></b></div>
        <hr />
            <form action="{{url('share_video_consulattion_prescription')}}" method="post" enctype="multipart/form-data" class="registration-form">
              {{csrf_field()}}
              <input type="hidden" name="id" value="{{$apoid}}">
              <div class="modal-body">
                <b><label>Share with others</label></b>
                  <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                     <input type="text" name="client_name" id="client_name" placeholder="Enter person name" required="">
                    <input type="text" name="phone" id="phone" placeholder="Enter 10 digit mobile number" required="">
                </div>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
              <?php $prescription_url=env('APP_URL')."view_consultation_prescription/".$am->encryption_id; ?>
                <input type="hidden" name="doctor_name" id="doctor_name" value="{{$doctor_details['name']}}" />
                <input type="hidden" name="prescription_url" id="prescription_url" value="{{$prescription_url}}" />
                <input type="hidden" name="consultation_id" value="{{$apoid}}">
                <input type="hidden" name="encryption_id" value="{{$consultation_encryption_id}}">
                 <button type="submit" class="btn btn-success">{{__('Share')}}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('message.Close')}}</button>
              </div>
        </form>
      </div>
   </div>
</div>
<div class="modal fade" id="mark_absent" tabindex="-1" aria-labelledby="exampleModalgridLabel">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title text-center" id="exampleModalgridLabel">
              {{__('Mark Absent')}}
            </h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form action="{{ url('update_consultation') . '/' . $am->encryption_id. '/absent'}}" method="post" enctype="multipart/form-data" class="registration-form">
              {{csrf_field()}}
              <input type="hidden" name="id" value="{{$apoid}}">
              <div class="modal-body">
                    <p>This action can not be undo. Are you sure you wnat to mark this consultation as absent?</p>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                 <button type="submit" class="btn btn-success">{{__('Yes')}}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('message.Close')}}</button>
              </div>
        </form>
      </div>
   </div>
</div>
<div class="modal fade" id="mark_completed" tabindex="-1" aria-labelledby="exampleModalgridLabel">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title text-center" id="exampleModalgridLabel">
              {{__('Complete Consultation')}}
            </h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <form action="{{ url('update_consultation') . '/' . $am->encryption_id. '/completed'}}" method="post" enctype="multipart/form-data" class="registration-form">
              {{csrf_field()}}
              <input type="hidden" name="id" value="{{$apoid}}">
              <div class="modal-body">
                    <p>Are you sure you have completed the video consultation before marking it as done?</p>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                 <button type="submit" class="btn btn-success">{{__('Yes')}}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('message.Close')}}</button>
              </div>
        </form>
      </div>
   </div>
</div>

<div class="modal fade" id="start_video_consultation" tabindex="-1" aria-labelledby="exampleModalgridLabel">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title text-center" id="exampleModalgridLabel">
              {{__('Start Video Consultation')}}
            </h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <a href="https://meet.google.com/hbd-senc-oxc" target="_blank"> Join Meet Now</a>
         <iframe src="https://meet.google.com/hbd-senc-oxc" width="800" height="600" allow="camera; microphone"></iframe>
      </div>
   </div>
</div>


<div class="modal fade" id="edit_Prescription" tabindex="-1" aria-labelledby="exampleModalgridLabel">
   <div class="modal-dialog ">
      <div class="modal-content">
         <div class="modal-header">
            <h3 class="modal-title text-center" id="exampleModalgridLabel">
              {{__("message.Edit Prescription")}}
            </h3>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
        <form action="{{url('edit_prescription')}}" method="post">
            {{csrf_field()}}
            <input type="hidden" name="id1" id="id1" value="">
            <div class="modal-body">

               <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Medicine")}}</label>
                        <input class="form-control" list="browsers" name="medicine" id="myInput1" placeholder="Search medicine">
                    <datalist id="browsers" class="suggestions">

                    </datalist>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Type")}}</label>
                    <div class="custom-dropdown" id="timerange" style="width: 100%;margin-bottom: 10px;" >
                     <select class="" name="type"  required="" style="background:none; border:1px solid #E5E7EC;">
                        <option value="" >{{__("message.select")}} {{__("message.Type")}}</option>
                        <option value="Tablet" >Tablet</option>
                       <option value="Injection" >Injection</option>
                  </select>
               </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Dosage")}}</label>
                    <input type="text" name="dosge" id="dosge1" placeholder="{{__('message.Enter')}} {{__('message.Dosage')}}" required="">
                </div><br>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Consum Days")}}</label>
                    <input type="text" name="repeat_days" id="repeat_days1" placeholder="{{__('message.Enter')}} {{__('message.Consum Days')}}" required="">
                </div><br>

                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                    <label class="fr">{{__("message.Consuming Time")}}</label><br>
                    <div class="row">
                        <div class="col-10">
                            <input type="time" name="t_time[]" id="t_time1" placeholder="{{__('message.Enter')}} {{__('message.Consuming Time')}}" required="" style="background:none; border:1px solid #E5E7EC;width: 100%;border-radius:10px;height: 50px;">
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
                 <button type="submit" class="btn btn-success">{{__('message.Submit')}}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('message.Close')}}</button>
              </div>
        </form>
      </div>
   </div>
</div>

<input type="hidden" name="url" id="url" value="{{url('/')}}"></input>

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
            //url: url + '/getmedicines',
            url: url + '/getproductsecom',
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
                $("#m_data").append( '{{__('message.Prescription not found')}}');
            }

        }
       });

       $(document).on('click', '.remove', function() {
    $(this).closest('.row').remove();
});
    }


</script>

</section>


@stop
@section('footer')
@stop
