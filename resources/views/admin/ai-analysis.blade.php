@extends('admin.layout')
@section('title')
    {{ __('AI ANALYSIS') }} | {{ __('message.Admin') }} {{ __('Report') }}
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
                        <h4 class="card-title">{{ __('AI ANALYSIS') }} {{ __('message.List') }}</h4>
                        <div class="table-responsive p-3">
                        <table id="ai-analysis-table" class="table table-bordered dt-responsive tablels">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('id_enc') }}</th>
                                    <th>{{ __('fullname') }}</th>
                                    <th>{{ __('email') }}</th>
                                    <th>{{ __('phone') }}</th>
                                    <th>{{ __('gender') }}</th>
                                    <th>{{ __('date_add') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            
                            <?php 
                                foreach($all_ai_analysis as $row){
                                    $report_url=env('BERKOWITS_AI_ANALYSIS_REPORT_URL').$row['id_enc'];
                                    ?><tr>
                                        <td>{{$row['id_enc']}}</td>
                                        <td>{{$row['fullname']}}</td>
                                        <td>{{$row['email']}}</td>
                                        <td>{{$row['phone']}}</td>
                                        <td>{{$row['gender']}}</td>
                                        <td>{{$row['date_add']}}</td>
                                        <td><a href="{{$report_url}}" target="_blank"><i class="fas fa-eye"></i></a></td>
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
    $('#ai-analysis-table').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true
    });
    </script>

@stop
