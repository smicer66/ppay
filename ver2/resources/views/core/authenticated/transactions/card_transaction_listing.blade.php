@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')

    @include('partials.errors')
    <!-- Info boxes -->
    <div class="element-wrapper col-md-12">
        <h6 class="element-header">
            Card Transactions
        </h6>
        <div class="element-box">
            <h5 class="form-header">
                All Card Transactions
            </h5>
            <div class="form-desc">
                List of all card transactions. Use the action button to carry out an action on a card transaction
            </div>





		<form action="/exco-staff/ecards/view-card-transactions" method="get" id="filterform">
		<div class="row">
		<div class="col-md-9">
            		<h5 class="form-header">
                		Reports
            		</h5>
		</div>
		<div class="col-md-3">
			<select id="reportType" name="reportType" class="form-control">
				!--<option value="TRANSACTION">Transaction Report</option>-->
				<option value="CARD">Card Report</option>
			</select>
			@if(\Auth::user()->role_code!=\App\Models\Roles::$AGENT)
			<div class="form-desc" style="border-bottom: 0px !important; padding-bottom: 0px !important">
                		Select a report type to run the report, then click the proceed button
            		</div>
			@endif
		</div>
		
		</div>


		<div class="row filterDiv" id="transactionReportFields" style="margin-left: 0px !important; margin-right: 0px !important"><fieldset class="row"><legend>Apply Filter (Transaction Report)</legend>
			<div class="col-md-3 reportFields" id="">
				<select id="transactionReportFieldCurrency" name="transactionReportFieldCurrency" class="form-control">
					@foreach(getAllCurrency() as $currency => $cur)
					<option value="{{$currency}}">{{$cur}}</option>
					@endforeach
				</select>
			</div>

			
			<div class="col-md-3 reportFields" id="">
				<select id="transactionReportFieldStatus" name="transactionReportFieldStatus" class="form-control">
					<option value>--Status--</option>
					@foreach(getAllTransactionStatus() as $status)
					<option value="{{$status}}">{{str_replace('_', ' ', $status)}}</option>
					@endforeach				
				</select>
			</div>


			<div class="col-md-3 reportFields" id="">
				<select id="transactionReportFieldServiceType" name="transactionReportFieldServiceType" class="form-control">
					<option value>--Service Type--</option>

<?php
$stypes = [];

if(\Auth::user()->role_code==\App\Models\Roles::$AGENT)
{
	$stypes = getAllServiceTypesForAgentReport();
}
else
{
	$stypes = getAllServiceTypes();
}
?>
					@foreach($stypes  as $serviceType => $st)
					<option value="{{$serviceType}}">{{str_replace('_', ' ', $st)}}</option>
					@endforeach				
				</select>
			</div>

			@if(\Auth::user()->role_code!=\App\Models\Roles::$AGENT)
			<div class="col-md-3 reportFields" id="">
				<input type="text" id="transactionReportFieldDevice" name="transactionReportFieldDevice" class="form-control" placeholder="Bevura Device Code"/>
			</div>
			<div class="col-md-3 reportFields" id="">
				<input type="text" id="transactionReportFieldMerchant" name="transactionReportFieldMerchant" class="form-control" placeholder="Bevura Merchant Code"/>
			</div>
			@endif

			<div class="col-md-3 reportFields" id="">
				<input type="number" id="transactionReportFieldMinAmount" name="transactionReportFieldMinAmount" class="form-control" placeholder="Minimum Amount"/>
			</div>
			<div class="col-md-3 reportFields" id="">
				<input type="number" id="transactionReportFieldMaxAmount" name="transactionReportFieldMaxAmount" class="form-control" placeholder="Maximum Amount"/>
			</div>
			<div class="col-md-3 reportFields" id="">
				<input type="number" id="transactionReportFieldWalletNumber" name="transactionReportFieldWalletNumber" class="form-control" placeholder="Wallet Number"/>
			</div>

			@if(\Auth::user()->role_code!=\App\Models\Roles::$AGENT)
			<div class="col-md-3 reportFields" id="">
				<input type="number" id="transactionReportFieldCardNumber" name="transactionReportFieldCardNumber" class="form-control" placeholder="Card Number"/>
			</div>
			@endif


			<div class="col-md-12 col-sm-12 col-lg-12 reportFields" id="" style="clear: both !important;">
				<div class="col-md-3 reportFields" id="" style="clear: both !important; float: left !important">
					<label>Start Date</label><input type="date" id="startDate" name="startDate" class="form-control" placeholder="Start Date"/>
				</div>
				<div class="col-md-3 reportFields" id="" style="float: left !important">
					<label>End  Date</label><input type="date" id="endDate" name="endDate" class="form-control" placeholder="End Date"/>
				</div>
			</div>


			<div class="col-md-12 pull-right text-right" style="">
				<input type="submit" class="btn btn-primary runreport" value="Run Report">
			</div></fieldset>
		</div>







		
		</form>
            <div class="table-responsive">
                <table id="merchanttransactiontable" width="100%" class="table table-striped table-lightfont">
                    <thead>
                    <tr>
                        <th>S/No</th>
                        <th>Date</th>
                        <th>Order Ref</th>
                        <th>Transaction Ref</th>
                        <th>Payer</th>
                        <th>Channel</th>
                        <th>Service Type</th>
                        <th>Status</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>S/No</th>
                        <th>Date</th>
                        <th>Order Ref</th>
                        <th>Transaction Ref</th>
                        <th>Payer</th>
                        <th>Channel</th>
                        <th>Service Type</th>
                        <th>Status</th>
                        <th>Amount</th>
                    </tr>
                    </tfoot>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>



@stop
@section('section_title') Merchant Transaction Listing @stop
@section('scripts')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>-->


	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/datatables.min.css"/>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/datatables.min.js"></script>

    <script type="text/javascript" src="/js/action.js"></script>
    <script>

        $(document).ready(function()
        {
            var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
            viewCardTransactionList(jwtToken, {{$cardId}});
        });
    </script>
@stop
