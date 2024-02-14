@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')

    @include('partials.errors')

    <!-- Info boxes -->
    <div class="element-wrapper col-md-12">
        <h6 class="element-header">
		Reversal Requests

        </h6>
        <div class="element-box">
            <h5 class="form-header">
                Last 1000 Reversal Requests
            </h5>
            <div class="form-desc">
                List of last 1000 Reversal Requests. Use the action button to carry out an action on a Reversal Request
            </div>
            <div class="table-responsive">
                <table id="alltransactionstable" width="100%" class="table table-striped table-lightfont">
                    <thead>
                    <tr style="background-color: #000 !important; color: #fff !important;">
                        <th>id</th>
                        <th>Date & Reversal Ref</th>
                        <th>Order Id</th>
                        <th>Customer</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Total Amount</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>Date & Reversal Ref</th>
                        <th>Order Id</th>
                        <th>Customer</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Total Amount</th>
                    </tr>
                    </tfoot>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@include('core.authenticated.charges.includes.journal_entry_float_view')

@stop
@section('section_title') Transaction Listing @stop

@section('style')
<style>
.pendingstatus{
	background-color: #0d6efd !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.successstatus{
	background-color: #198754 !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.customer_canceledstatus, .failstatus{
	background-color: #dc3545 !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.request_rollbackstatus{
	background-color: #ffc107 !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.reversedstatus{
	background-color: #000000 !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.channelspan{
	background-color: #6c757d !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.paymentmodespan{
	background-color: #ff6600 !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.currencymodespan{
	background-color: #9334eb !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
} 
</style>
@stop

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
	     var filter = null;
		@if($filter!=null)
		filter = '{{$filter}}';
		@endif

		var queryStr = "";

		@if(isset($data) && $data!=null)
			@foreach($data as $d => $d1)
				queryStr = "&{{$d}}={{$d1}}" + queryStr;
			@endforeach
		@endif
		var serverToken = '{{\Auth::user()->token}}';
            	viewReversalList(jwtToken, 1000, filter, queryStr, serverToken );
        });



    </script>
@stop



