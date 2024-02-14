@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')


        <!-- Info boxes -->
<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Devices List<span id="belongingToMerchant"></span>
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            All Devices
        </h5>
        <div class="form-desc">
            List of all devices<span id="belongingToMerchantDesc"></span>. Use the action button to carry out an action on a device
        </div>
        <div class="table-responsive">
            <table id="allDevicesTable" width="100%" class="table table-striped table-lightfont">
                <thead>
                    <tr>
                        <th>Merchant Name</th>
                        <th>Device Type</th>
                        <th>Device Code</th>
                        <th>Acquirer</th>
                        <th>Notifications</th>
                        <th>Is Live</th>
                        <th>Status</th>
                        <th>&nbsp</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Merchant Name</th>
                        <th>Device Type</th>
                        <th>Device Code</th>
                        <th>Acquirer</th>
                        <th>Notifications</th>
                        <th>Is Live</th>
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

@include('core.authenticated.device.view_device')


@stop
@section('section_title') Device Listing @stop
@section('scripts')
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
	<script type="text/javascript" src="/js/action.js"></script>
    <script>
    
    $(document).ready(function(){
        $('.mpqr').hide();
        $('.cyb').hide();
        $('.uba').hide();
        $('.zicb').hide();
    });

	$(document).ready(function() 
	{
        var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
        var merchantId = undefined;
        @if(isset($merchantId) && $merchantId!=null)
            merchantId = {{$merchantId}}
        @endif
		viewDeviceList(jwtToken, merchantId);
    });
    
	</script>
@stop

@section('style')
<style>
    label{
        font-weight: bold !important;
    }

    
</style>
@stop