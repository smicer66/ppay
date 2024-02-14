@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')


        <!-- Info boxes -->

<div class="col-md-12 col-sm-12">
<div class="row">
  <div class="col-sm-12">
<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Card Request List
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            All Card Requests
        </h5>
        <div class="form-desc">
            List of all card requests. Use the action button to carry out an action on a card request
        </div>
        <div class="table-responsive">
            <table id="allCustomerCardTable" width="100%" class="table table-striped table-lightfont">
                <thead>
                    <tr>
                        <th>Request By</th>
                        <th>Name On Card</th>
                        <th>Wallet Number</th>
                        <th>Card Scheme</th>
                        <th>Actioned By</th>
                        <th>Request Status</th>
                        <th>&nbsp</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Request By</th>
                        <th>Name On Card</th>
                        <th>Wallet Number</th>
                        <th>Card Scheme</th>
                        <th>Actioned By</th>
                        <th>Request Status</th>
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



@include('core.authenticated.ecards.issue_physical_card')


@stop
@section('section_title') Card Request List @stop
@section('scripts')
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
    <script type="text/javascript" src="/js/action.js"></script>
    <script>
	
	$(document).ready(function()
	{
        	var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
	 	var deviceCode = '{{BEVURA_DEVICE_CODE}}';
		viewCustomerCardRequestList(jwtToken, deviceCode);
   	});
    </script>
@stop


