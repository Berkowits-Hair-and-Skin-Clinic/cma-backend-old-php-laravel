@extends('user.layout')
@section('title')
{{__('message.User Register')}}
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
            <h1>{{__('message.User Register')}}</h1>
         </div>
      </div>
   </div>
   <div class="lower-content">
      <div class="auto-container">
         <ul class="bread-crumb clearfix">
            <li><a href="{{url('/')}}">{{__('message.Home')}}</a></li>
            <li>{{__('message.User Register')}}</li>
         </ul>
      </div>
   </div>
</section>-->

  
   
   
   


<div class="row">
   <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <section class="registration-section bg-color-4" style="margin-top: -50px;">
         <div class="pattern">
            <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-85.png')}}');"></div>
            <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-86.png')}}');"></div>
         </div>
         <div class="auto-container">
            <div class="inner-box">
               <div class="content-box">
                  <div class="title-box">
                     <h3>Ready for real results? Complete the form to take the first step.</h3>
                  </div>
                  <div class="inner">
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
                     <div id="registererror">
                     </div>
                     <form action="{{url('registerfirsttimeuser')}}" method="post" class="registration-form">
                        {{csrf_field()}}
                        <div class="row clearfix">
                           <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                              <input type="text" id="name" name="name" placeholder="{{__('Your Name')}}" required="" value="{{old('name')}}" />
                              @if ($errors->has('name'))
                                 <span class="text-danger">{{ $errors->first('name') }}</span>
                              @endif
                           </div>
                           <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                              <input type="text" name="phone" id="phone" placeholder="{{__('Your Mobile Number')}}" required="" value="{{old('phone')}}"/>
                              @if ($errors->has('phone'))
                                 <span class="text-danger">{{ $errors->first('phone') }}</span>
                              @endif
                           </div>
                           <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                              <input type="email" name="email" id="email" placeholder="{{__('Your Email')}}" required="" value="{{old('email')}}"/>
                              @if ($errors->has('email'))
                                 <span class="text-danger">{{ $errors->first('email') }}</span>
                              @endif
                           </div>
                           <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                              <div class="custom-check-box">
                                 <div class="custom-controls-stacked">
                                    <label class="custom-control ">
                                    <input type="checkbox" class="material-control-input" name="agree" value="1" required=""/>
                                    <span class="material-control-indicator"></span>
                                    <span class="description">{{__('message.I accept')}} <a href="{{url('/')}}">{{__('message.terms')}}</a> {{__('message.and')}} <a href="{{url('/')}}">{{__('message.conditions')}}</a> {{__('message.and general policy')}}</span>
                                    </label>
                                 </div>
                              </div>
                              @if ($errors->has('agree'))
                                 <span class="text-danger">{{ $errors->first('agree') }}</span>
                              @endif
                           </div>
                           <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                              <button type="submit" class="theme-btn-one">{{__('Get Started')}}<i class="icon-Arrow-Right"></i></button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </div>
   <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <section class="process-style-two bg-color-4 centred" style="margin-top: -30px;margin-right:3%">
         <div class="pattern-layer">
            <div class="pattern-1" style="background-image: url('https://app.berkowits.com/cma/public/front_pro/assets/images/shape/shape-39.png');"></div>
            <div class="pattern-2" style="background-image: url('https://app.berkowits.com/cma/public/front_pro/assets/images/shape/shape-40.png');"></div>
            <div class="pattern-3" style="background-image: url('https://app.berkowits.com/cma/public/front_pro/assets/images/shape/shape-41.png');"></div>
            <div class="pattern-4" style="background-image: url('https://app.berkowits.com/cma/public/front_pro/assets/images/shape/shape-42.png');"></div>
         </div>
         <div class="auto-container">
            <div class="sec-title centred">
               <h2>Appointment Process</h2>
            </div>
            <div class="inner-content">
               <div class="arrow" style="background-image: url('https://app.berkowits.com/cma/public/front_pro/assets/images/icons/arrow-1.png');"></div>
               <div class="row clearfix">
                  <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                     <div class="processing-block-two">
                        <div class="inner-box">
                           <figure class="icon-box"><img src="https://app.berkowits.com/cma/public/image_web/299186.png" alt=""></figure>
                           <h3>Search Center</h3>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                     <div class="processing-block-two">
                        <div class="inner-box">
                           <figure class="icon-box"><img src="https://app.berkowits.com/cma/public/image_web/398067.png" alt=""></figure>
                           <h3>View Center Profile</h3>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12 processing-block">
                     <div class="processing-block-two">
                        <div class="inner-box">
                           <figure class="icon-box"><img src="https://app.berkowits.com/cma/public/image_web/483570.png" alt=""></figure>
                           <h3>Get Instant  Appoinment</h3>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </div>
</div>
<script>
    function checkbothpassword(value){
    var pwd=$("#pwd").val();
    if(pwd!=value){
        var txt=$("#pwdmatch").val();
        $("#cpwd_error").html(txt);
        $("#cpwd").val("");
    }
    }
</script>
@stop
@section('footer')
@stop
