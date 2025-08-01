@extends('user.layout')
@section('title')
{{__('Client Dashboard')}}
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
<!--<section class="page-title-two">
   <div class="title-box centred bg-color-2">
      <div class="pattern-layer">
         <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-70.png')}}');"></div>
         <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-71.png')}}');"></div>
      </div>
      <div class="auto-container">
         <div class="title">
            <h1>{{__('Zenoti Appointment')}}</h1>
         </div>
      </div>
   </div>
</section>-->

<section class="patient-dashboard bg-color-3">
   <div class="left-panel">
      <div class="profile-box patient-profile">
         <div class="upper-box">
            <figure class="profile-image">
               @if(isset($userdata)&&$userdata->profile_pic!="")
               <img src="{{asset('public/upload/profile').'/'.$userdata->profile_pic}}" alt="">
               @else
               <img src="{{asset('public/upload/profile/profile.png')}}" alt="">
               @endif
            </figure>
            <div class="title-box centred">
               <div class="inner">
                  <h3>{{isset($userdata->name)?$userdata->name:""}}</h3>
                  <p><i class="fas fa-envelope"></i>{{isset($userdata->email)?$userdata->email:""}}</p>
               </div>
            </div>
         </div>
         <div class="profile-info">
            <ul class="list clearfix">
            <li><a href="{{url('searchcenterall')}}"><i class="fas fa-clock"></i>{{__('Book Appointment')}}</a></li>
               <li><a href="{{url('userappointmentdashboard')}}"><i class="fas fa-columns"></i>{{__('message.Appointment History')}}</a></li>
               <li><a href="{{url('userpurchaseproduct')}}"><i class="fas fa-columns"></i>{{__('message.My Purchase')}}</a></li>
               <!--<li><a href="{{url('favouriteuser')}}"><i class="fas fa-heart"></i>{{__('message.Favourite Doctors')}}</a></li>-->
               <li><a href="{{url('viewschedule')}}"><i class="fas fa-clock"></i>{{__('message.My Calendar')}}</a></li>
               <li><a href="{{url('userreview')}}" ><i class="fas fa-comments"></i>{{__('message.Review')}}</a></li>
               <li><a href="{{url('usereditprofile')}}" ><i class="fas fa-user"></i>{{__('message.My Profile')}}</a></li>
               <li><a href="{{url('changepassword')}}"><i class="fas fa-unlock-alt"></i>{{__('message.Change Password')}}</a></li>
               <li><a href="{{url('logout')}}"><i class="fas fa-sign-out-alt"></i>{{__('message.Logout')}}</a></li>
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
                              <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-79.png')}}');"></div>
                              <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-80.png')}}');"></div>
                           </div>
                           <div class="icon-box"><i class="icon-Dashboard-3"></i></div>
                           <h3>{{$totalappointment}}</h3>
                           <h5>{{__('message.Total')}}</h5>
                           <h5>{{__("message.Appointment")}}</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-12 col-md-12 feature-block">
                     <div class="feature-block-two">
                        <div class="inner-box">
                           <div class="pattern">
                              <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-81.png')}}');"></div>
                              <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-82.png')}}');"></div>
                           </div>
                           <div class="icon-box"><i class="icon-Dashboard-email-4"></i></div>
                           <h3>{{$completeappointment}}</h3>
                           <h5>{{__('message.Completed')}}</h5>
                           <h5>{{__("message.Appointment")}}</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-4 col-lg-12 col-md-12 feature-block">
                     <div class="feature-block-two">
                        <div class="inner-box">
                           <div class="pattern">
                              <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-83.png')}}');"></div>
                              <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-84.png')}}');"></div>
                           </div>
                           <div class="icon-box"><i class="icon-Dashboard-5"></i></div>
                           <h3>{{$pendingappointment}}</h3>
                           <h5>{{__("message.Pending")}}</h5>
                           <h5>{{__("message.Appointment")}}</h5>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="doctors-appointment">
            <a style="height: 60px;float:right;color:black"  href="{{url('searchcenterall')}}" class="theme-btn-one"><i style="font-size: 20px;margin-right:10px;color:black;" class="icon-Dashboard-3"></i> {{__('Book New Appointment')}}</a><br />
               <div class="title-box">
                  <h3>{{__("Appointment")}}</h3>
                  <div class="btn-box">
                     @if($type==2)
                     <a href="{{url('userappointmentdashboard?type=2')}}" class="theme-btn-one">{{__('message.past')}} <i class="icon-Arrow-Right"></i></a>
                     @else
                     <a href="{{url('userappointmentdashboard?type=2')}}" class="theme-btn-two">{{__('message.past')}}</a>
                     @endif
                     @if(!isset($type))
                     <a href="{{url('userappointmentdashboard?type=3')}}" class="theme-btn-one">{{__('message.Upcoming')}} <i class="icon-Arrow-Right"></i></a>
                     @else
                     <a href="{{url('userappointmentdashboard?type=3')}}" class="theme-btn-two">{{__('message.Upcoming')}}</a>
                     @endif
                     @if($type==1)
                     <a href="{{url('userappointmentdashboard?type=1')}}" class="theme-btn-one">{{__('message.Today')}} <i class="icon-Arrow-Right"></i></a>
                     @else
                     <a href="{{url('userappointmentdashboard?type=1')}}" class="theme-btn-two">{{__('message.Today')}}</a>

                     @endif
                  </div>
               </div>       
               <div class="doctors-list">
                  <div class="table-outer">
                     <table class="doctors-table">
                        <thead class="table-header">
                           <tr>
                              <th>{{__('message.Service Point')}}</th>
                              <th>{{__('message.ServiceName')}}</th>
                              <th>{{__('Price')}}</th>
                              <th>{{__('message.Date')}}</th>
                              
                              
                              <th>{{__('message.Status')}}</th>

                           </tr>
                        </thead>
                        <tbody>
                           @foreach($bookdata['appointments'] as $appointment)
                              <?php $appointment_group_id=$appointment['appointment_group_id']; ?>
                           @foreach($appointment['appointment_services'] as $service) 
                           <?php $appointment_id=$service['appointment_id']; ?>
                           <tr>
                              <td data-toggle="modal" data-target="#queryModalgrid">
                                 <div class="name-box">
                                    <?php 
                                       //use Illuminate\Support\Facades\DB;
                                       $centerName = Illuminate\Support\Facades\DB::table('doctors')->select('name')->where('center_id', '=', $appointment['center_id'])->where('record_type', '=', 'center')->get();
                                       //var_dump($centerName);
                                    ?>
                                    <label>{{$centerName}}</label>
                                 </div>
                              </td>
                              <td>
                                 <p>{{$service['service']['name']}}</p>
                              </td>
                              <td><p>{{$service['service']['price']['sales']}}</p></td>
                              <td>
                                 <p>{{$service['start_time']}}</p><br />
                                 <p>{{$service['end_time']}}</p>
                              </td>
                              <td>
                              <?php
                                    if($service['appointment_status'] ==0){
                                         echo '<span class="status">'.__("New").'</span>';
                                    }else if($service['appointment_status'] ==1){
                                         echo '<span class="status">'. __("closed").'</span>';
                                    }else if($service['appointment_status'] ==2){
                                         echo '<span class="status">'. __("Checkin").'</span>';
                                    }
                                    else if($service['appointment_status'] ==4){
                                         echo '<span class="status">'. __("Confirmed").'</span>';
                                    }
                                    else if($service['appointment_status'] ==-2){
                                         echo '<span class="status">'. __("No Show").'</span>';
                                    }else{
                                         echo '<span class="status">'. __("message.Absent").'</span>';
                                    }
                                    ?>
                                 <br /><div class="title-box">
                                          <div class="btn-box">
                                             <a class="theme-btn-one" href="{{ url('appointmentdetails') . '/' . $appointment_id}}">Detail</a>
                                          </div>
                                       </div>
                              </td>

                           </tr>
                           
                           @endforeach
                           @endforeach
                        </tbody>
                     </table>
                     
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
<input type="hidden" id="path_admin" value="{{url('/')}}">



</section>
@stop
@section('footer')
@stop
