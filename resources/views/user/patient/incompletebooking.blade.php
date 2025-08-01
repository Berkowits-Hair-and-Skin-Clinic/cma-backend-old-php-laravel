@extends('user.layout')
@section('title')
    {{ __('Incomplete Booking') }}
@stop
@section('meta-data')
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ __('message.System Name') }}" />
    <meta property="og:title" content="{{ __('message.System Name') }}" />
    <meta property="og:image" content="{{ asset('public/image_web/') . '/' . $setting->favicon }}" />
    <meta property="og:image:width" content="250px" />
    <meta property="og:image:height" content="250px" />
    <meta property="og:site_name" content="{{ __('message.System Name') }}" />
    <meta property="og:description" content="{{ __('message.meta_description') }}" />
    <meta property="og:keyword" content="{{ __('message.Meta Keyword') }}" />
    <link rel="shortcut icon" href="{{ asset('public/image_web/') . '/' . $setting->favicon }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
@stop
@section('content')
    <!--<section class="page-title-two">
        <div class="title-box centred bg-color-2">
            <div class="pattern-layer">
                <div class="pattern-1"
                    style="background-image: url('{{ asset('public/front_pro/assets/images/shape/shape-70.png') }}');">
                </div>
                <div class="pattern-2"
                    style="background-image: url('{{ asset('public/front_pro/assets/images/shape/shape-71.png') }}');">
                </div>
            </div>
            <div class="auto-container">
                <div class="title">
                    <h1>{{ __('message.Medicine Order') }}</h1>
                </div>
            </div>
        </div>
        <div class="lower-content">
            <ul class="bread-crumb clearfix">
                <li><a href="{{ url('/') }}">{{ __('message.Home') }}</a></li>
                <li>{{ __('message.Medicine Order') }}</li>
            </ul>
        </div>
    </section>-->
    <section class="patient-dashboard bg-color-3">
        <div class="left-panel">
            <div class="profile-box patient-profile">
                <div class="upper-box">
                    <figure class="profile-image">
                        @if (isset($userdata) && $userdata->profile_pic != '')
                            <img src="{{ asset('public/upload/profile') . '/' . $userdata->profile_pic }}" alt="">
                        @else
                            <img src="{{ asset('public/upload/profile/profile.png') }}" alt="">
                        @endif
                    </figure>
                    <div class="title-box centred">
                        <div class="inner">
                            <h3>{{ isset($userdata->name) ? $userdata->name : '' }}</h3>
                            <p><i class="fas fa-envelope"></i>{{ isset($userdata->email) ? $userdata->email : '' }}</p>
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
            <a style="height: 50px;float:right;"  href="{{url('userappointmentdashboard?type=2')}}" class="theme-btn-one">{{__('Back')}} <i class="icon-Arrow-Left"></i></a><br />
            <div class="content-container">
                <div class="outer-container">
                    <div class="doctors-appointment">
                    <div class="title-box" style="margin-bottom: -50px;">
                        <h3>Appointment Details</h3><hr />
                        <?php //var_dump($appointmentDetail[0]['guest']) ?>
                    </div>
                        <div class="row clearfix">
                            <div class="col-xs-12 col-lg-6 col-md-6 feature-block">
                                <div class="title-box">
                                    <h3>Client Details</h3>
                                    <?php //var_dump($appointmentDetail[0]['guest']) ?>
                                </div>
                                <div class="row" style="background-color: #ffffff;padding:20px;margin-top:-60px">
                                    <div class="col-xs-6 col-lg-3 col-md-3">
                                        <label>Name:</label><br />
                                        <label>Phone:</label><br />
                                        <label>Email:</label><br />

                                    </div>
                                    <div class="col-xs-6 col-lg-9 col-md-9">
                                        <label>{{$appointmentDetail[0]['guest']['first_name']." ".$appointmentDetail[0]['guest']['last_name']}}</label>
                                        <br /><label>{{$appointmentDetail[0]['guest']['mobile']['display_number']}}</label>
                                        <br /><label>{{$appointmentDetail[0]['guest']['email']}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-6 col-md-6 feature-block">
                                <div class="title-box">
                                    <h3>Service Details</h3>
                                    <?php //var_dump($appointmentDetail[0]['service']) ?>
                                </div>
                                <div class="row" style="background-color: #ffffff;padding:20px;margin-top:-60px">
                                    <div class="col-xs-6 col-lg-6 col-md-6">
                                        <label>Service Name:</label><br /><br />
                                        <label>Category:</label><br />
                                        <label>Sub Category:</label><br />
                                    </div>
                                    <div class="col-xs-6 col-lg-6 col-md-6">
                                        <label>{{$appointmentDetail[0]['service']['name']}}</label>
                                        <br /><label>{{$appointmentDetail[0]['service']['category']['name']}}</label>
                                        <br /><label>{{$appointmentDetail[0]['service']['sub_category']['name']}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-6 col-md-6 feature-block">
                                <div class="title-box">
                                    <h3>Therapist Details</h3>
                                    <?php //var_dump($appointmentDetail[0]['therapist']) ?>
                                </div>
                                <div class="row" style="background-color: #ffffff;padding:20px;margin-top:-60px">
                                    <div class="col-xs-6 col-lg-3 col-md-3">
                                        <label>Name:</label><br />
                                        <label>Email:</label><br />
                                    </div>
                                    <div class="col-xs-6 col-lg-9 col-md-9">
                                        <label>{{$appointmentDetail[0]['therapist']['first_name']." ".$appointmentDetail[0]['therapist']['last_name']}}</label>
                                        <br /><label>{{$appointmentDetail[0]['therapist']['email']}}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-lg-6 col-md-6 feature-block" style="background-color: #ffffff;padding:20px;">
                                <div class="title-box">
                                    <h3>Inoice Details</h3>
                                    <?php //var_dump($appointmentDetail[0]['price']) ?>
                                </div>
                                <div class="row" style="background-color: #ffffff;padding:20px;margin-top:-60px">
                                    <div class="col-xs-6 col-lg-4 col-md-4">
                                        <label>Invoice Id:</label><br /><br />
                                        <label>Price:</label><br />
                                    </div>
                                    <div class="col-xs-6 col-lg-8 col-md-8">
                                         <label>{{$appointmentDetail[0]['invoice_id']}}</label>
                                        <br /><label>{{$appointmentDetail[0]['price']['final']}}</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-lg-12 col-md-12 feature-block" style="background-color: #ffffff;padding:20px;">
                                <div class="title-box">
                                    <h3>Other Details</h3>
                                    <?php //var_dump($appointmentDetail[0]['price']) ?>
                                </div>
                                <div class="row" style="background-color: #ffffff;padding:20px;margin-top:-60px">
                                    <div class="col-xs-6 col-lg-4 col-md-4">
                                        <label>Appointment id </label><br />
                                        <label>start_time:</label><br />
                                        <label>end_time:</label><br />
                                        <label>status:</label><br />
                                        <label>auto_pay_authorize_status:</label><br />
                                        <label>creation_date:</label><br />
                                        <label>created_by_id:</label><br />
                                        <label>form_id:</label><br />
                                    </div>
                                    <div class="col-xs-6 col-lg-8 col-md-8">
                                         <label>{{$appointmentDetail[0]['appointment_id']}}</label>
                                        <br /><label>{{$appointmentDetail[0]['start_time']}}</label>
                                        <br /><label>{{$appointmentDetail[0]['end_time']}}</label>
                                        <br /><label>{{$appointmentDetail[0]['status']}}</label>
                                        <br /><label>{{$appointmentDetail[0]['auto_pay_authorize_status']}}</label>
                                        <br /><label>{{$appointmentDetail[0]['creation_date']}}</label>
                                        <br /><label>{{$appointmentDetail[0]['created_by_id']}}</label>
                                        <br /><label>{{$appointmentDetail[0]['form_id']}}</label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->

        <input type="hidden" id="path_admin" value="{{ url('/') }}">

        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready(function() {
                let table = new DataTable('#myTable', {
                    order: [
                        [0, 'desc']
                    ]
                });
            });
        </script>


    </section>
@stop
@section('footer')
@stop
