@extends('user.layout')
@section('title')
{{__('Video Consultation List')}}
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
<section class="page-title-two">
   <!--<div class="title-box centred bg-color-2">
      <div class="pattern-layer">
         <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-70.png')}}');"></div>
         <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-71.png')}}');"></div>
      </div>
      <div class="auto-container">
         <div class="title">
            <h1>{{__('message.Doctor Dashboard')}}</h1>
         </div>
      </div>
   </div>-->
   <div class="lower-content">
      <ul class="bread-crumb clearfix">
         <li><a href="{{url('/')}}">{{__('message.Home')}}</a></li>
         <li>{{__('Video Consultation List')}}</li>
      </ul>
   </div>
</section>
<section class="doctors-dashboard bg-color-3">
   <div class="left-panel">
      <div class="profile-box">
         <div class="upper-box">
            <figure class="profile-image">
               @if($doctordata->image!="")
               <img src="{{asset('public/upload/doctors').'/'.$doctordata->image}}" alt="">
               @else
               <img src="{{asset('public/front_pro/assets/images/resource/profile-2.png')}}" alt="">
               @endif
            </figure>
            <div class="title-box centred">
               <div class="inner">
                  <h3>{{$doctordata->name}}</h3>
                  <p>{{isset($doctordata->departmentls)?$doctordata->departmentls->name:""}}</p>
               </div>
            </div>
         </div>
         <div class="profile-info">
         <ul class="list clearfix">
               <li><a href="{{url('doctordashboard')}}"><i class="fas fa-columns"></i>{{__('message.Dashboard')}}</a></li>
               <li><a href="{{url('videoconsultationlist')}}" class="current"><i class="fas fa-calendar-alt"></i>{{__('Video Consultation')}}</a></li>
               <!--<li><a href="{{url('doctorappointment')}}" ><i class="fas fa-calendar-alt"></i>{{__('message.Appointment')}}</a></li>
               <li><a href="{{url('center_employees')}}" ><i class="fas fa-calendar-alt"></i>{{__('Employees')}}</a></li>-->
               <li><a href="{{url('doctorreview')}}" ><i class="fas fa-star"></i>{{__('message.Reviews')}}</a></li>
               <li><a href="{{url('doctoreditprofile')}}"><i class="fas fa-user"></i>{{__('message.My Profile')}}</a></li>
               <li><a href="{{url('doctorchangepassword')}}"><i class="fas fa-unlock-alt"></i>{{__('message.Change Password')}}</a></li>
               <li><a href="{{url('logout')}}"><i class="fas fa-sign-out-alt"></i>{{__("message.Logout")}}</a></li>
               <!--<li><a href="{{url('doctortiming')}}"><i class="fas fa-clock"></i>{{__('message.Schedule Timing')}}</a></li>
               <li><a href="{{url('doctor_hoilday')}}" ><i class="fas fa-star"></i>{{__('message.My Hoilday')}}</a></li>
               <li><a href="{{url('doctorsubscription')}}"><i class="fas fa-rocket"></i>{{__('message.My Subscription')}}</a></li>
               <li><a href="{{url('paymenthistory')}}"><i class="fas fa-user"></i>{{__('message.Payment History')}}</a></li>-->
            </ul>
         </div>
      </div>
   </div>
   <div class="right-panel">
      <div class="content-container">
         <div class="outer-container">
            <div class="feature-content">
            </div>
            <div class="feature-content">
            </div>
            <div class="doctors-appointment">
               <div class="title-box">
                  <h3>{{__('Video Consultation')}}</h3>
                  <div class="btn-box">
                        <?php 
                           //var_dump($vlc_counter);
                           if(!empty($type)){
                              switch($type){
                                 case '1':
                                    ?>
                                       <a href="{{url('videoconsultationlist?type=1')}}" class="theme-btn-one">{{__('message.Today')}}</a>
                                       <a href="{{url('videoconsultationlist?type=3')}}" class="theme-btn-two">{{__('message.Upcoming')}}</a>
                                       <a href="{{url('videoconsultationlist?type=4')}}" class="theme-btn-two">{{__('Completed')}}</a>
                                       <a href="{{url('videoconsultationlist?type=5')}}" class="theme-btn-two">{{__('Absent')}}</a>
                                       <a href="{{url('videoconsultationlist?type=2')}}" class="theme-btn-two">{{__('Past/Pending')}}</a>
                                    <?php
                                 break;
                                 case '2':
                                    ?>
                                       <a href="{{url('videoconsultationlist?type=1')}}" class="theme-btn-two">{{__('message.Today')}}</a>
                                       <a href="{{url('videoconsultationlist?type=3')}}" class="theme-btn-two">{{__('message.Upcoming')}}</a>
                                       <a href="{{url('videoconsultationlist?type=4')}}" class="theme-btn-two">{{__('Completed')}}</a>
                                       <a href="{{url('videoconsultationlist?type=5')}}" class="theme-btn-two">{{__('Absent')}}</a>
                                       <a href="{{url('videoconsultationlist?type=2')}}" class="theme-btn-one">{{__('Past/Pending')}}</a>
                                    <?php
                                 break;
                                 case '3':
                                    ?>
                                        <a href="{{url('videoconsultationlist?type=1')}}" class="theme-btn-two">{{__('message.Today')}}</a>
                                       <a href="{{url('videoconsultationlist?type=3')}}" class="theme-btn-one">{{__('message.Upcoming')}}</a>
                                       <a href="{{url('videoconsultationlist?type=4')}}" class="theme-btn-two">{{__('Completed')}}</a>
                                       <a href="{{url('videoconsultationlist?type=5')}}" class="theme-btn-two">{{__('Absent')}}</a>
                                       <a href="{{url('videoconsultationlist?type=2')}}" class="theme-btn-two">{{__('Past/Pending')}}</a>
                                    <?php
                                 break;
                                 case '4':
                                    ?>
                                     <a href="{{url('videoconsultationlist?type=1')}}" class="theme-btn-two">{{__('message.Today')}}</a>
                                    <a href="{{url('videoconsultationlist?type=3')}}" class="theme-btn-two">{{__('message.Upcoming')}}</a>
                                    <a href="{{url('videoconsultationlist?type=4')}}" class="theme-btn-one">{{__('Completed')}}</a>
                                    <a href="{{url('videoconsultationlist?type=5')}}" class="theme-btn-two">{{__('Absent')}}</a>
                                    <a href="{{url('videoconsultationlist?type=2')}}" class="theme-btn-two">{{__('Past/Pending')}}</a>
                                 <?php
                                    
                                 break;
                                 case '5':
                                    ?>
                                     <a href="{{url('videoconsultationlist?type=1')}}" class="theme-btn-two">{{__('message.Today')}}</a>
                                    <a href="{{url('videoconsultationlist?type=3')}}" class="theme-btn-two">{{__('message.Upcoming')}}</a>
                                    <a href="{{url('videoconsultationlist?type=4')}}" class="theme-btn-two">{{__('Completed')}}</a>
                                    <a href="{{url('videoconsultationlist?type=5')}}" class="theme-btn-one">{{__('Absent')}}</a>
                                    <a href="{{url('videoconsultationlist?type=2')}}" class="theme-btn-two">{{__('Past/Pending')}}</a>
                                 <?php
                                    break;
                              }

                           }else{
                              ?>
                               <a href="{{url('videoconsultationlist?type=1')}}" class="theme-btn-one">{{__('message.Today')}}</a>
                              <a href="{{url('videoconsultationlist?type=3')}}" class="theme-btn-two">{{__('message.Upcoming')}}</a>
                              <a href="{{url('videoconsultationlist?type=4')}}" class="theme-btn-two">{{__('Completed')}}</a>
                              <a href="{{url('videoconsultationlist?type=5')}}" class="theme-btn-two">{{__('Absent')}}</a>
                              <a href="{{url('videoconsultationlist?type=2')}}" class="theme-btn-two">{{__('Past/Pending')}}</a>
                           <?php

                           }

                        ?>
                        
                  </div>
               </div>
               <div class="doctors-list">
                  <div class="table-outer">
                     <table class="doctors-table">
                        <thead class="table-header">
                           <tr>
                              <th>{{__("message.Patient Name")}}</th>
                              <th>{{__("Consultation Date")}}</th>
                             <!-- <th>{{__("message.Phone")}}</th>-->
                              <th>{{__('message.ServiceName')}}</th>
                              <th>{{__('Doctor')}}</th>
                              <th>{{__("message.Status")}}</th>
                              <th>{{__("Details")}}</th>

                           </tr>
                        </thead>
                        <tbody>
                          @if(count($bookdata)>0)
                            @foreach($bookdata as $bo)
		                           <tr>
		                              <td>
                                    <label style="margin-left: 10px;"><b><i style="margin-right: 10px;" class="fas fa-user"></i></b> {{$bo->firstname}} {{$bo->lastname}}</label>
		                              </td>
		                              <td>
		                                 <label>{{date("F d,Y",strtotime($bo->preferred_date))}}</label>
		                                 <span class="time" style="width: 100%;">{{$bo->time_slot}}</span>
		                              </td>
		                              <!--<td>
		                                 <p>{{$bo->phone}}</p>
		                              </td>-->
                                    <td>{{$bo->concern}}</td>
                                    <?php 
                                       $doctor_details=json_decode($bo->doctor_details,true);
                                    ?>
                                    <td>{{$doctor_details['name']}}</td>
		                              <td>
                                    {{$bo->status}}
		                              </td>
                                    <td>
                                    <a href="{{url('videoconsultation_detail',$bo->encryption_id)}}" class="theme-btn-two">{{__('Detail')}}</a>
		                              </td>

		                           </tr>
                              
                            @endforeach
                           @else
                             <tr><td colspan="5" style="text-align: center;    padding: 18px;">{{__("message.No Data Found")}}</td></tr>
                           @endif
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@stop
@section('footer')
@stop
