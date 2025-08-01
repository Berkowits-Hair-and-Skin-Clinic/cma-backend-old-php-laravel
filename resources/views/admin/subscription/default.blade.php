@extends('admin.layout')
@section('title')
{{__("message.Subscription List")}}
@stop
@section('meta-data')
@stop
@section('content')
<div class="main-content">
   <div class="page-content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-body">
                     @if(Session::has('message'))
                     <div class="col-sm-12">
                        <div class="alert  {{ Session::get('alert-class', 'alert-info') }} alert-dismissible fade show" role="alert">{{ Session::get('message') }}
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                     </div>
                     @endif
                     <h4 class="card-title">{{__("message.Subscription List")}} {{__("message.List")}}</h4>
                     <div class="table-responsive mb-4">
                     <table id="subscriptiontable" class="table table-bordered dt-responsive tablels">
                        <thead class="thead-light">
                           <tr>
                              <th>{{__("message.Month")}}</th>
                              <th>{{__("message.Amount")}}</th>
                              <th>{{__("message.Action")}}</th>
                           </tr>
                        </thead>
                     </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@stop
@section('footer')
@stop
