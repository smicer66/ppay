@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->

<div class="col-md-10 col-sm-12">
<div class="row">
  <div class="col-sm-12">
<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Card Batches
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            All Card Batches
        </h5>
        <div class="form-desc">
            List of all card batches. Use the action button to carry out an action on a card
        </div>
        <div class="table-responsive">
            <table id="cardbatchtable" width="100%" class="table table-striped table-lightfont">
                <thead>
                    <tr>
                        <th>Batch No</th>
                        <th>Card No</th>
                        <th>Card Type</th>
                        <th>Tracking Number</th>
                        <th>Acquirer</th>
                        <th>Issuer</th>
                        <th>Status</th>
                        <th>&nbsp</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Batch No</th>
                        <th>Card No</th>
                        <th>Card Type</th>
                        <th>Tracking Number</th>
                        <th>Acquirer</th>
                        <th>Issuer</th>
                        <th>Status</th>
                        <th>&nbsp</th>
                    </tr>
                </tfoot>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>
</div>


@include('core.authenticated.ecards.includes.issue_physical_card')

@stop
@section('section_title') Card Batch List @stop
@section('scripts')
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
    <script type="text/javascript" src="/js/action.js"></script>
    <script>
	
	var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
	viewBatchCardList(jwtToken, '{{PROBASEWALLET_DEVICE_CODE}}');
    </script>
@stop
