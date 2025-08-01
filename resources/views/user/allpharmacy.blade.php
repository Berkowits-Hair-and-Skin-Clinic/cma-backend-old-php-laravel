@extends('user.layout')
@section('title')
{{__('message.Search Pharmacy')}}
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
                        <h1>{{__('message.Search Pharmacy')}}</h1>
                    </div>
                </div>
            </div>
            <div class="lower-content">
                <div class="auto-container">
                    <ul class="bread-crumb clearfix">
                        <li><a href="{{url('/')}}">{{__('message.Home')}}</a></li>
                        <li>{{__('message.Search Pharmacy')}}</li>
                    </ul>
                </div>
            </div>
        </section>-->
        <div class="select-field bg-color-3">
            <div class="auto-container">
                <div class="content-box">
                    <div class="form-inner clearfix">
                        <form action="{{url('searchcentre')}}" method="get">
                            <div class="form-group clearfix">

                                <input type="text" name="term" value="{{$term}}" id="term" placeholder="Ex. {{__('message.Pharmacy')}} {{__('message.Name')}}" required="">
                                @if(!empty($type))
                                 <input type="hidden" name="type" value="{{$type}}">
                                @endif
                                <button type="submit"><i class="icon-Arrow-Right"></i></button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <section class="clinic-section doctors-page-section">
            <div class="auto-container">
                <div class="row clearfix">
                    <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                        <div class="item-shorting clearfix">
                            <div class="left-column pull-left">
                                <h3>{{__('message.Showing')}} {{count($doctorlist)}} {{__('message.Results')}}</h3>
                            </div>
                            <div class="right-column pull-right clearfix">
                               <div class="short-box clearfix">
                                    <div class="select-box">

                                    </div>
                                </div>
                                <div class="menu-box">
                                    <button class="list-view"><i class="icon-List"></i></button>
                                    <button class="grid-view on"><i class="icon-Grid"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="wrapper grid">
                            <div class="clinic-list-content list-item">
                                @foreach($doctorlist as $dl)
                                    <div class="clinic-block-one">
                                        <div class="inner-box">
                                            <div class="pattern">
                                                <div class="pattern-1" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-24.png')}}');"></div>
                                                <div class="pattern-2" style="background-image: url('{{asset('public/front_pro/assets/images/shape/shape-25.png')}}');"></div>
                                            </div>
                                            <figure class="image-box">
                                                @if ($dl->image!="")
                                                <img src="{{asset('public/upload/doctors').'/'.$dl->image}}" alt="" style="height: 155px;">
                                                @else
                                                  <img src="{{asset('public/upload/doctors/defaultpharmacy.png')}}" alt="" style="height: 155px;">
                                                @endif

                                                </figure>
                                            <div class="content-box">
                                                <div class="like-box">
                                                    @if($dl->is_fav=='0')
                                                       @if(empty(Session::has("user_id")))
                                                       <a href="{{url('patientlogin')}}" id="favdoc{{$dl->id}}">
                                                       @else
                                                       <a href="javascript:userfavorite('{{$dl->id}}')" id="favdoc{{$dl->id}}">
                                                       @endif
                                                       @else
                                                       <a href="javascript:userfavorite('{{$dl->id}}')" class="activefav" id="favdoc{{$dl->id}}">
                                                       @endif
                                                         <i class="far fa-heart"></i></a>
                                                </div>
                                                <ul class="name-box clearfix">
                                                    <li class="name"><h3><a href="{{url('viewpharmacy').'/'.$dl->id}}">{{$dl->name}}</a></h3></li>
                                                    <!-- <li><i class="icon-Trust-1"></i></li>
                                                    <li><i class="icon-Trust-2"></i></li> -->
                                                </ul>
                                                <span class="designation">{{isset($dl->departmentls)?$dl->departmentls->name:""}}</span>
                                                <div class="text">
                                                    <p>{{substr($dl->aboutus,0,200)}}</p>
                                                </div>
                                                <div class="rating-box clearfix">
                                                    <ul class="rating clearfix">
                                                        <?php
                                                                      $arr = $dl->avgratting;
                                                                      if (!empty($arr)) {
                                                                          $i = 0;
                                                                          if (isset($arr)) {
                                                                              for ($i = 0; $i < $arr; $i++) {
                                                                                  echo '<li><i class="icon-Star"></i></li>';
                                                                              }
                                                                          }

                                                                              $remaing = 5 - $i;
                                                                              for ($j = 0; $j < $remaing; $j++) {
                                                                                  echo '<li class="light"><i class="icon-Star"></i></li>';
                                                                              }

                                                                      }else{
                                                                           for ($j = 0; $j <5; $j++) {
                                                                                  echo '<li class="light"><i class="icon-Star"></i></li>';
                                                                              }
                                                                       }?>
                                                        <li><a href="{{url('viewpharmacy').'/'.$dl->id}}">({{$dl->totalreview}})</a></li>
                                                    </ul>
                                                    <div class="link"><a href="{{url('viewpharmacy').'/'.$dl->id}}">{{$dl->working_time}}</a></div>
                                                </div>
                                                <div class="location-box">
                                                    <p><i class="fas fa-map-marker-alt"></i>{{substr($dl->address,0,38)}}</p>
                                                </div>
                                                <div class="btn-box"><a href="{{url('viewpharmacy').'/'.$dl->id}}">{{__('message.Visit Now')}}</a></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                  @if(isset($type)&&$type!=""&&isset($term)&&$term!="")
                                     {{$doctorlist->appends(['term' => $term,'type'=>$type])->links()}}
                                  @elseif(isset($type)&&$type!=""&&empty($term))
                                     {{$doctorlist->appends(['type'=>$type])->links()}}
                                  @elseif(isset($type)&&$type!=""&&empty($term))
                                     {{$doctorlist->appends(['term' => $term])->links()}}
                                  @else
                                     {{$doctorlist->links()}}
                                  @endif
                            </div>


                            <div class="clinic-grid-content">
                                <div class="row clearfix">
                                    @foreach($doctorlist as $dl)
                                        <div class="col-lg-6 col-md-6 col-sm-12 team-block">
                                            <div class="team-block-three">
                                                <div class="inner-box">
                                                    <figure class="image-box">
                                                        {{-- <img src="{{asset('public/upload/doctors').'/'.$dl->image}}" alt="" style="height: 245px;"> --}}
                                                        @if ($dl->image != '')
                                                            <img src="{{ asset('public/upload/doctors') . '/' . $dl->image }}" alt="" style="height: 245px;">
                                                        @else
                                                            <img src="{{ asset('public/upload/doctors/defaultpharmacy.png') }}" alt="" style="height: 245px;">
                                                        @endif
                                                          @if($dl->is_fav=='0')
                                                       @if(empty(Session::has("user_id")))
                                                       <a href="{{url('patientlogin')}}" id="favdoc{{$dl->id}}">
                                                       @else
                                                       <a href="javascript:userfavorite1('{{$dl->id}}')" id="favdoc1{{$dl->id}}">
                                                       @endif
                                                       @else
                                                       <a href="javascript:userfavorite1('{{$dl->id}}')" class="activefav" id="favdoc1{{$dl->id}}">
                                                       @endif
                                                         <i class="far fa-heart"></i></a>
                                                    </figure>
                                                    <div class="lower-content">
                                                        <ul class="name-box clearfix">
                                                            <li class="name"><h3><a href="{{url('viewpharmacy').'/'.$dl->id}}">{{$dl->name}}</a></h3></li>
                                                            <!-- <li><i class="icon-Trust-1"></i></li>
                                                            <li><i class="icon-Trust-2"></i></li> -->
                                                        </ul>
                                                        <span class="designation">{{isset($dl->departmentls)?$dl->departmentls->name:""}}</span>
                                                        <div class="rating-box clearfix">
                                                            <ul class="rating clearfix">
                                                                <?php
                                                                      $arr = $dl->avgratting;

                                                                      if (!empty($arr)) {
                                                                          $i = 0;
                                                                          if (isset($arr)) {
                                                                              for ($i = 0; $i < $arr; $i++) {
                                                                                  echo '<li><i class="icon-Star"></i></li>';
                                                                              }
                                                                          }

                                                                              $remaing = 5 - $i;
                                                                              for ($j = 0; $j < $remaing; $j++) {
                                                                                  echo '<li class="light"><i class="icon-Star"></i></li>';
                                                                              }

                                                                      }else{
                                                                           for ($j = 0; $j <5; $j++) {
                                                                                  echo '<li class="light"><i class="icon-Star"></i></li>';
                                                                              }
                                                                       }?>
                                                                <li><a href="{{url('viewpharmacy').'/'.$dl->id}}">({{$dl->totalreview}})</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="location-box">
                                                            <p><i class="fas fa-map-marker-alt"></i>{{substr($dl->address,0,38)}}</p>
                                                        </div>
                                                        <div class="lower-box clearfix">
                                                            <span class="text">{{$dl->working_time}}</span>
                                                            <a href="{{url('viewpharmacy').'/'.$dl->id}}">{{__('message.Visit Now')}}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                  @if(isset($type)&&$type!=""&&isset($term)&&$term!="")
                                     {{$doctorlist->appends(['term' => $term,'type'=>$type])->links()}}
                                  @elseif(isset($type)&&$type!=""&&empty($term))
                                     {{$doctorlist->appends(['type'=>$type])->links()}}
                                  @elseif(isset($type)&&$type!=""&&empty($term))
                                     {{$doctorlist->appends(['term' => $term])->links()}}
                                  @else
                                     {{$doctorlist->links()}}
                                  @endif
                            </div>
                        </div>


                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                        <div class="map-inner ml-10">

                            <div id="map" style="height: 400px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@stop
@section('footer')
<script type="text/javascript">
    function serachsep(val){
         var term=$("#term").val();
         if(term==""){
                if(val!=""){
                    window.location.href='{{url("searchpharmacy")}}'+'?type='+val;
                }
         }else{
            window.location.href='{{url("searchpharmacy")}}'+'?type='+val+"&term="+term;
         }

    }

    function userfavorite1(id){
    $.ajax({
        url: $("#siteurl").val()+"/userfavorite"+'/'+id,
        method:"get",
        success: function( data ) {
            var str=JSON.parse(data);
            var txt='<div class="col-sm-12"><div class="alert  '+str['class']+' alert-dismissible fade show" role="alert">'+str["msg"]+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div>';
            $("#favmsg").html(txt);
            if(str['op']=='1'){
              $("#favdoc1"+id).addClass("activefav");
            }else{
              $("#favdoc1"+id).removeClass("activefav");
            }
        }
    });
  }

</script>
   <script>

        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(-33.863276, 151.207977),
          zoom: 12
        });
            var infoWindow = new google.maps.InfoWindow;
            var markerBounds = new google.maps.LatLngBounds();
            var markers =<?=json_encode($doctorslistmap);?>;
            Array.prototype.forEach.call(markers, function(markerElem) {

              if(markerElem.lat!=null&&markerElem.lon!=null){
                  var id = markerElem.id;
              var name = markerElem.name;
              var address = markerElem.address;
              var type = "D";
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.lat),
                  parseFloat(markerElem.lon));
              markerBounds.extend(point);
              var infowincontent = document.createElement('div');
              var strong = document.createElement('strong');
              strong.textContent = name
              infowincontent.appendChild(strong);
              infowincontent.appendChild(document.createElement('br'));

              var text = document.createElement('text');
              text.textContent = address
              infowincontent.appendChild(text);
              var icon = {
                                            url: "{{asset('public/front_pro/assets/images/icons/map-marker.png')}}", // url
                                            scaledSize: new google.maps.Size(40, 40), // scaled size
                                            origin: new google.maps.Point(0,0), // origin
                                            anchor: new google.maps.Point(0, 0) // anchor
                                        };
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                icon: icon
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
              });

              map.fitBounds(markerBounds);
              map.panToBounds(markerBounds);
              }

            });

        }

initMap();

         </script>

@stop
