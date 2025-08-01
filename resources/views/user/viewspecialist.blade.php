@extends('user.layout')
@section('title')
{{__('message.Specialist')}}
@stop
@section('meta-data')
<meta property="og:type" content="website"/>
<meta property="og:url" content="{{__('message.Specialist')}}"/>
<meta property="og:title" content="{{__('message.Specialist')}}"/>
<meta property="og:image" content="{{asset('public/image_web/').'/'.$setting->favicon}}"/>
<meta property="og:image:width" content="250px"/>
<meta property="og:image:height" content="250px"/>
<meta property="og:site_name" content="{{__('message.Specialist')}}"/>
<meta property="og:description" content="{{__('message.meta_description')}}"/>
<meta property="og:keyword" content="{{__('message.Meta Keyword')}}"/>
<link rel="shortcut icon" href="{{asset('public/image_web/').'/'.$setting->favicon}}">
<meta name="viewport" content="width=device-width, initial-scale=1">
@stop
@section('content')
<label>Session={{Cookie::get('latitude')}}</label>
<section class="page-title-two">
    <div class="title-box centred bg-color-2">
       <div class="pattern-layer">
          <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-70.png')}}');"></div>
          <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-71.png')}}');"></div>
       </div>
       <div class="auto-container">
          <div class="title">
             <!-- <h1>{{__('message.Concern Title')}}</h1> -->
             <div class="col-lg-6 col-md-6 col-sm-12" style="margin-top: -10px;">
               <div class="form-group">
               <h4 style="color: white;">Select Your Concern</h4>
               <select onchange="filterbyconcern(this.value)" class="form-control" name="concern_category" id="concern_category" required="">
                  <option value="">--Select Concern--</option> 
                  <option value="hair">Concern related to hair</option>    
                  <option value="skin">Concern related to skin</option>
               </select>
            </div>
         </div>
          </div>
       </div>
    </div>
    <!--<div class="lower-content">
       <div class="auto-container">
          <ul class="bread-crumb clearfix">
             <li><a href="{{url('/')}}">{{__('message.Home')}}</a></li>
             <li>{{__('message.Specialist')}}</li>
          </ul>
       </div>
    </div>-->
 </section>

<section class="category-viewspecialistp-section category-section bg-color-3 centred">
   <div class="pattern-layer">
      <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-47.png')}}');"></div>
      <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-48.png')}}');"></div>
   </div>
   <div class="auto-container">
      <div class="sec-title centred">
            <?php 
               $filterby="";
               if(!empty($_REQUEST['filterby'])){
                  $filterby=$_REQUEST['filterby'];
                  $str="Concern related to ".$_REQUEST['filterby'];
                  ?><<h3>{{$str}}</h3><?php
               }
            ?>
            
      </div>
      <div class="row clearfix">
         @foreach($department as $d)
         <?php 
            if(empty($filterby)){
               $query=$d->name;
            }else{
               $query=$filterby;
            }
         ?>
         <div class="col-lg-4 col-md-6 col-sm-6 col-6 category-block">
            <div class="category-block-one wow fadeInUp animated animated animated" data-wow-delay="00ms" data-wow-duration="1500ms" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
               <div class="inner-box">
                  <div class="pattern">
                     <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-45.png')}}');"></div>
                     <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-46.png')}}');"></div>
                  </div>
                  <figure class="icon-box"><img src="{{asset('public/upload/services').'/'.$d->icon}}"  style="height: 150px;width: 100%;" alt=""></figure>
                  <h3><a href="{{url('searchcenterall?query=').$query}}">{{$d->name}}</a></h3>
                  <div class="link"><a href="{{url('searchcenterall?type=').$d->id}}"><i class="icon-Arrow-Right"></i></a></div>
                  <div class="btn-box"><a href="{{url('searchcenterall?query=').$query}}" class="theme-btn-one">{{__('view nearby center')}}<i class="icon-Arrow-Right"></i></a></div>
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </div>
</section>

@stop
@section('footer')



   <script type="text/javascript">
      document.querySelector('.show-btn').addEventListener('click', function() {
        document.querySelector('.sm-menu').classList.toggle('active');
      });
      function filterbyconcern(val) {
            window.location.href = '{{ url('viewspecialist') }}' + '?filterby=' + val;

        }
   </script>



@stop
