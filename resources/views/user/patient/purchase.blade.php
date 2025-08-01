@extends('user.layout')
@section('title')
    {{ __('Purchase Order') }}
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
            <div class="content-container">
                <div class="outer-container">
                    <div class="doctors-appointment">
                        <div class="title-box">
                            <h3>{{ __('Purchase Order') }}</h3>
                        </div>
                        <div class="doctors-list m-3">
                            <div class="table-outer">
                                <table class="" id="myTable">
                                    <thead class="table-header">
                                        <tr>
                                            <th>{{ __('Center') }}</th>
                                            <th>{{ __('Product') }}</th>
                                            <th>{{ __('Date') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Invoice') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productsData['products'] as $product)
                                            <tr>
                                                <td>{{ $product['center']['name'] }}</td>
                                                <td>
                                                    <p>{{ $product['name'] }}</p>
                                                </td>
                                                <td>{{ $product['sale_date'] }}</td>
                                                <td>{{ $product['price_paid']  }}</td>
                                                <td>{{ $product['invoice']['invoice_number'] }}</td>
                                                

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('message.Order Details') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div id="m_data">

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

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
        <script>
            function get_orderdata(id) {
                $("#m_data").empty();
                $.ajax({

                    url: $("#path_admin").val() + "/get_orderdata" + "/" + id,
                    data: {},
                    success: function(data) {
                        console.log(data);
                        // Access order details
                        var orderDetails = data[1];
                        console.log("Order Details:", orderDetails);

                        // Access order data
                        var orderData = data[0];
                        console.log("Order Data:", orderData);

                        var currency = data[2];
                        console.log("currency Data:", currency);



                        var aaa = {{ __('message.RTL') }};
                        if (aaa == 0) {
                            var isRTL = 1;
                        } else {
                            var isRTL = 0;
                        }

                        // Example: Displaying order details dynamically for RTL and LTR
                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "{{ __('message.Order ID') }}" + ": </b>" + orderDetails.id + "</p>");
                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "{{ __('message.Name') }}" + ": </b>" + orderDetails.user_id + "</p>");
                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "{{ __('message.Phone') }}" + ": </b>" + orderDetails.phone + "</p>");
                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "{{ __('message.Address') }}" + ": </b>" + orderDetails.address + "</p>");
                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "{{ __('message.Note') }}" + ": </b>" + orderDetails.message + "</p>");

                        if (orderDetails.payment_type != null) {
                            $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                                "{{ __('message.Payment Type') }}" + ": </b>" + orderDetails.payment_type +
                                "</p>");
                        }

                        $("#m_data").append("<p style='text-align: " + (isRTL ? "right" : "left") + ";'><b>" +
                            "{{ __('message.Pharmacy') }} {{ __('message.Name') }}" + ": </b>" + orderDetails
                            .Pharmacy_id + "</p><hr>");

                        if (orderDetails.order_type == 2) {
                            var subtotal = 0;
                            orderData.forEach(function(item) {
                                subtotal += item.qty * item.price;

                                var itemHTML =
                                    '<div class="col-12" style="border-bottom:1px solid #e5e7ec; direction: ' +
                                    (isRTL ? "rtl" : "ltr") + ';">' +
                                    '<p><b>' + item.name + '</b></p>' +
                                    '<div class="row">' +
                                    '<div class="col-4">' +
                                    '<p>{{ __('message.Price') }}: ' + item.price + currency[1] + '</p>' +
                                    '</div>' +
                                    '<div class="col-4" style="text-align: center;">' +
                                    '<p>{{ __('message.Qty') }}: ' + item.qty + '</p>' +
                                    '</div>' +
                                    '<div class="col-4" style="display: inline; text-align: ' + (isRTL ?
                                        "left" : "right") + ';">' +
                                    '<p>{{ __('message.Total') }}: ' + (item.qty * item.price) + currency[
                                        1] + '</p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';
                                $('#m_data').append(itemHTML);
                            });

                            // Display total amounts dynamically based on RTL or LTR
                            $('#m_data').append("<p class='mt-2' style='text-align: " + (isRTL ? "left" : "right") +
                                "; padding-" + (isRTL ? "left" : "right") +
                                ":15px;'>{{ __('message.Sub Total') }}: " + subtotal + currency[1] + "</p>");
                            $('#m_data').append("<p class='mt-2' style='text-align: " + (isRTL ? "left" : "right") +
                                "; padding-" + (isRTL ? "left" : "right") +
                                ":15px;'>{{ __('message.Delivery Charge') }}: " + orderDetails
                                .delivery_charge + currency[1] + "</p>");
                            $('#m_data').append("<p class='mt-2' style='text-align: " + (isRTL ? "left" : "right") +
                                "; padding-" + (isRTL ? "left" : "right") +
                                ":15px;'>{{ __('message.Tax') }}: " + orderDetails.tax + currency[1] + "</p>");
                            $('#m_data').append("<p class='mt-2' style='text-align: " + (isRTL ? "left" : "right") +
                                "; padding-" + (isRTL ? "left" : "right") +
                                ":15px;'>{{ __('message.Total') }}: " + orderDetails.total + currency[1] +
                                "</p>");
                        } else {
                            // Handle prescription image
                            $('#m_data').append('<img src="' + $("#path_admin").val() +
                                '/public/upload/orderprescription/' + orderDetails.prescription +
                                '" style="width: 100%; direction: ' + (isRTL ? "rtl" : "ltr") + ';">');
                        }
                    }
                });
            }
        </script>


    </section>
@stop
@section('footer')
@stop
