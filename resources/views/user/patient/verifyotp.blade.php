@extends('user.layout')
@section('title')
 {{__('VERIFY OTP')}}
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
<section class="registration-section bg-color-3">
            <div class="pattern">
                <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-85.png')}}');"></div>
                <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-86.png')}}');"></div>
            </div>
            <div class="auto-container">
                <div class="inner-box">
                    <div class="content-box">
                        <div class="title-box">
                            <h3>{{__('Verify OTP')}}</h3>
                            <a href="{{url('patientlogin')}}">{{__('message.Already a User')}}</a>
                        </div>
                        <div class="inner">
                             <form action="{{url('postloginuserotp')}}" method="post" class="registration-form">
                                {{csrf_field()}}
                                <div class="row clearfix">
                                    
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                        <label>{{__('Enter OTP')}}</label>
                                        <input type="text" name="otp" placeholder="" required="">
                                        <input type="hidden" name="phone" value="{{$phone}}">
                                        <input type="hidden" name="zenoti_id" value="{{$zenoti_id}}">
                                        <input type="hidden" name="center_id" value="{{$center_id}}">
                                    </div>
                                   
                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                        <button type="submit" class="theme-btn-one">{{__('Verify')}}<i class="icon-Arrow-Right"></i></button>
                                    </div>
                                </div>
                            </form>
                          
                             <div class="login-now"><p>{{__('message.Already have an account')}}<a href="{{url('patientlogin')}}">{{__('message.Log In')}}</a></p></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
       <section class="agent-section" style="background: aliceblue;">
   <div class="auto-container">
      <div class="inner-container bg-color-2">
         <div class="row clearfix">
            <div class="col-lg-6 col-md-12 col-sm-12 left-column">
               <div class="content_block_3">
                  <div class="content-box">
                     <h3>{{__('message.Emergency call')}}</h3>
                     <div class="support-box">
                        <div class="icon-box"><i class="fas fa-phone"></i></div>
                        <span>{{__('message.Telephone')}}</span>
                        <h3><a href="tel:{{$setting->phone}}">{{$setting->phone}}</a></h3>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 right-column">
               <div class="content_block_4">
                  <div class="content-box">
                     <h3>{{__('message.Sign up for Newsletter today')}}</h3>
                     <form action="#" method="post" class="subscribe-form">
                        <div class="form-group">
                           <input type="email" name="email" id="emailnews" placeholder="{{__('message.Your email')}}" required="">
                           <button type="button" onclick="addnewsletter()" class="theme-btn-one">{{__('message.Submit now')}}<i class="icon-Arrow-Right"></i></button>
                        </div>
                     </form>
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