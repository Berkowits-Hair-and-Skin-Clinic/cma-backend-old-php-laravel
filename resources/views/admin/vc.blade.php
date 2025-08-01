@extends('admin.layout')
@section('title')
    {{ __('message.Appointment') }} | {{ __('message.Admin') }} {{ __('message.Appointment') }}
@stop
@section('meta-data')
@stop
@section('content')

    <div class="container-fluid mb-4">
        <div class="row">
            <?php //var_dump($all_consultation); ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (Session::has('message'))
                            <div class="col-sm-12">
                                <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show"
                                    role="alert">{{ Session::get('message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        @endif
                        <h4 class="card-title">{{ __('Video Consultation') }} {{ __('message.List') }}</h4>
                        <div class="table-responsive p-3">
                        <table id="vctable" class="table table-bordered dt-responsive tablels">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('VC ID') }}</th>
                                    <th>{{ __('message.Patient Name') }}</th>
                                    <th>{{ __('DoctorName') }}</th>
                                    <th>{{ __('CenterName') }}</th>
                                    <th>{{ __('message.DateTime') }}</th>
                                    <th>{{ __('message.Status') }}</th>
                                    <th>{{ __('Payment') }}</th>
                                </tr>
                            </thead>
                            
                            <?php 
                                foreach($all_consultation as $row){
                                    $data_doctor = json_decode($row['doctor_details'], true);
                                    if(empty($data_doctor['name']) OR $data_doctor['name']==null){
                                        $doctor_name="NA";
                                        $center_name="NA";
                                    }else{
                                        $doctor_name=$data_doctor['name'];
                                        $center_name=$data_doctor['centre'];;
                                    }
                                    ?><tr>
                                        <td>{{$row['encryption_id']}}</td>
                                        <td>{{$row['firstname']}} {{$row['firstname']}}</td>
                                        <td>{{$doctor_name}}</td>
                                        <td>{{$center_name}}</td>
                                        <td>{{$row['preferred_date']}} {{$row['time_slot']}}</td>
                                        <td>{{$row['status']}}</td>
                                        <td>{{$row['payment_status']}}</td>
                                        </tr>
                                    <?php
                                    
                                }
                            ?>
                            
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
    $('#vctable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true
    });
    </script>

@stop
