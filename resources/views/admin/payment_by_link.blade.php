@extends('admin.layout')
@section('title')
    {{ __('Payment Link(PayByLink)') }} | {{ __('message.Admin') }} {{ __('Report') }}
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
                        <h4 class="card-title">{{ __('Pay By Link') }} {{ __('message.List') }}</h4>
                        <div class="table-responsive p-3">
                        <table id="payment_by_link" class="table table-bordered dt-responsive tablels">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('id') }}</th>
                                    <th>{{ __('payment_link_id') }}</th>
                                    <th>{{ __('payment_id') }}</th>
                                    <th>{{ __('name') }}</th>
                                    <th>{{ __('email') }}</th>
                                    <th>{{ __('phone') }}</th>
                                    <th>{{ __('amount') }}</th>
                                    <th>{{ __('zenoti_invoice_id') }}</th>
                                    <th>{{ __('date_add') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            
                            <?php 
                                foreach($all_payment as $row){
                                    if(empty($row['payment_id']) OR $row['payment_id']=NULL){
                                        $payment_id="NULL";
                                    }else{
                                        $payment_id=$row['payment_id'];
                                    }
                                    if(empty($row['zenoti_invoice_id']) OR $row['zenoti_invoice_id']=NULL){
                                        $zenoti_invoice_id="NULL";
                                    }else{
                                        $zenoti_invoice_id=$row['zenoti_invoice_id'];
                                    }
                                    ?><tr>
                                        <td>{{$row['id']}}</td>
                                        <td>{{$row['payment_link_id']}}</td>
                                        <td>{{$payment_id}}</td>
                                        <td>{{$row['name']}}</td>
                                        <td>{{$row['email']}}</td>
                                        <td>{{$row['phone']}}</td>
                                        <td>{{$row['amount']}}</td>
                                        <td>{{$zenoti_invoice_id}}</td>
                                        <td>{{$row['created_at']}}</td>
                                        <td></td>
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
    $('#payment_by_link').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true
    });
    </script>

@stop
