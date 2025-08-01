@extends('admin.layout')
@section('title')
    {{ __('message.Appointment') }} | {{ __('message.Admin') }} {{ __('message.Appointment') }}
@stop
@section('meta-data')
@stop
@section('content')

    <div class="container-fluid mb-4">
        <div class="row">
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
                        <h4 class="card-title">{{ __('message.Appointment') }} {{ __('message.List') }}</h4>
                        <div class="table-responsive p-3">
                        <table id="appointmenttable" class="table table-bordered dt-responsive tablels">
                            <thead class="thead-light">
                                <tr>
                                    <th>{{ __('message.Id') }}</th>
                                    <th>{{ __('message.Doctor Name') }}</th>
                                    <th>{{ __('message.Patient Name') }}</th>
                                    <th>{{ __('message.DateTime') }}</th>
                                    <th>{{ __('message.Phone') }}</th>
                                    <th>{{ __('message.User Description') }}</th>
                                    <th>{{ __('message.Status') }}</th>
                                    <th>{{ __('message.Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
