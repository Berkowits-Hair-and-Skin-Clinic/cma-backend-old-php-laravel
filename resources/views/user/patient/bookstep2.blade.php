@extends('user.layout')
@section('title')
{{__('Book Appointment')}}
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
<section class="patient-dashboard bg-color-3">
   <div class="left-panel">
      <div class="profile-box patient-profile">
         <div class="upper-box">
            <figure class="profile-image">
               @if($userdata->profile_pic!="")
               <img src="{{asset('public/upload/profile').'/'.$userdata->profile_pic}}" alt="">
               @else
               <img src="{{asset('public/upload/profile/profile.png')}}" alt="">
               @endif
            </figure>
            <div class="title-box centred">
               <div class="inner">
                  <h3>{{$userdata->name}}</h3>
                  <p><i class="fas fa-envelope"></i>{{$userdata->email}}</p>
               </div>
            </div>
         </div>
         <div class="profile-info">
            <ul class="list clearfix">
               <li><a href="{{url('searchdoctor')}}" ><i class="fas fa-clock"></i>{{__('Book Appointment')}}</a></li>
               <li><a href="{{url('userappointmentdashboard')}}"><i class="fas fa-columns"></i>{{__('message.Appointment History')}}</a></li>
               <li><a href="{{url('userpurchaseproduct')}}"><i class="fas fa-columns"></i>{{__('message.My Purchase')}}</a></li>
               <!--<li><a href="{{url('favouriteuser')}}"><i class="fas fa-heart"></i>{{__('message.Favourite Doctors')}}</a></li>-->
               <li><a href="{{url('viewschedule')}}"><i class="fas fa-clock"></i>{{__('message.My Calendar')}}</a></li>
               <li><a href="{{url('userreview')}}" ><i class="fas fa-comments"></i>{{__('message.Review')}}</a></li>
               <li><a href="{{url('usereditprofile')}}"class="current"><i class="fas fa-user"></i>{{__('message.My Profile')}}</a></li>
               <li><a href="{{url('changepassword')}}"><i class="fas fa-unlock-alt"></i>{{__('message.Change Password')}}</a></li>
               <li><a href="{{url('logout')}}"><i class="fas fa-sign-out-alt"></i>{{__('message.Logout')}}</a></li>
            </ul>
         </div>
      </div>
   </div>
   <div class="right-panel">
      <div class="content-container">
         <div class="outer-container">
            <div class="add-listing change-password">
               <div class="single-box">
                  <div class="title-box">
                     <h3>{{__('Book Appointment')}}</h3>
                  </div>
                  <div class="inner-box">
                     <div class="profile-title">
                        <div class="upload-photo">
                        </div>
                        @if(Session::has('message'))
                        <div class="col-sm-12">
                           <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">
                              {{ Session::get('message') }}
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                        </div>
                        @endif
                     </div>
                     <form action="{{env('APP_URL')}}viewdoctor/{{$doctorDetails->id}}" method="get" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row clearfix">
                           <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                           <div class="form-group">
                              <div class="select-box">
                                    <select name="service"  class="form-control">
                                        <option value="">{{ __('Select Service') }}</option>
                                        @foreach ($services as $service)
                                             <option value="{{ $service['name']}}">{{ $service['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                           </div>
                           </div>
                           <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                           <div class="form-group">
                              <div class="select-box">
                                    <select name="specialist" class="form-control">
                                        <option value="">{{ __('Select Specialist') }}</option>
                                        @foreach ($specilaist['employees'] as $employee)
                                             <option value="{{  $employee['personal_info']['name']  }}">{{ $employee['personal_info']['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                           </div>
                           </div>
                        </div>
                  </div>
               </div>
               <div class="btn-box">
               <button class="theme-btn-one" type="submit">{{__('Next')}}<i class="icon-Arrow-Right"></i></button>
               </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
@stop
@section('footer')
@stop
