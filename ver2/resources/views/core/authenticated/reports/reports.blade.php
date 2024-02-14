@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')

    @include('partials.errors')

    <!-- Info boxes -->
    <div class="element-wrapper col-md-12">
        <h6 class="element-header">
		@if(isset($filter) && $filter!=null && $filter=='merchant')
            Merchant Payments
		@elseif(isset($filter) && $filter!=null && $filter=='mpqr')
            MPQR Transactions
		@elseif(isset($filter) && $filter!=null && $filter=='card')
            Card Transactions
		@elseif(isset($filter) && $filter!=null && $filter=='wallet')
            Wallet Transactions
		@elseif(isset($filter) && $filter!=null && $filter=='device')
            Device Transactions
		@elseif(isset($filter) && $filter!=null && $filter=='mobile')
            Mobile Transactions
		@elseif(isset($filter) && $filter!=null && $filter=='ussd')
            USSD Transactions
		@else
            Reports
		@endif

        </h6>
        <div class="element-box">

		@if(\Auth::user()->role_code==\App\Models\Roles::$ACCOUNTANT)
		<form action="/accountant/reports/all-reports" method="get" id="filterform">
		@elseif(Auth::user()->role_code==\App\Models\Roles::$POTZR_STAFF)
		<form action="/potzr-staff/reports/all-reports" method="get" id="filterform">
		@elseif(Auth::user()->role_code==\App\Models\Roles::$AGENT)
		<form action="/agent/reports/all-reports" method="get" id="filterform">
		@endif
		<div class="row">
		<div class="col-md-9">
            		<h5 class="form-header">
                		Reports
            		</h5>
		</div>
		<div class="col-md-3">
			<select id="reportType" name="reportType" class="form-control">
				<option value="TRANSACTION" {{isset($all) && isset($all["reportType"]) && $all["reportType"]=='TRANSACTION' ? 'selected' : ''}}>Transaction Report</option>
				@if(\Auth::user()->role_code!=\App\Models\Roles::$AGENT)
				<option value="MERCHANT" {{isset($all) && isset($all["reportType"]) && $all["reportType"]=='MERCHANT' ? 'selected' : ''}}>Merchant Report</option>
				<option value="DEVICE" {{isset($all) && isset($all["reportType"]) && $all["reportType"]=='DEVICE' ? 'selected' : ''}}>Device Report</option>
				<option value="CUSTOMER" {{isset($all) && isset($all["reportType"]) && $all["reportType"]=='CUSTOMER' ? 'selected' : ''}}>Customer Report</option>
				<option value="ACCOUNT" {{isset($all) && isset($all["reportType"]) && $all["reportType"]=='ACCOUNT' ? 'selected' : ''}}>Account Report</option>
				<option value="CARD" {{isset($all) && isset($all["reportType"]) && $all["reportType"]=='CARD' ? 'selected' : ''}}>Card Report</option>
				@endif
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
					<option value="{{$currency}}" {{isset($all) && isset($all["transactionReportFieldCurrency"]) && $all["transactionReportFieldCurrency"]==$currency ? 'selected' : ''}}>{{$cur}}</option>
					@endforeach
				</select>
			</div>

			@if(\Auth::user()->role_code!=\App\Models\Roles::$AGENT)
			<div class="col-md-3 reportFields" id="">
				<select id="transactionReportFieldAcquirer" name="transactionReportFieldAcquirer" class="form-control">
					<option value>--Acquirer--</option>
					@foreach($acquirers as $acq)
					<option value="{{$acq->id}}" {{isset($all) && isset($all["transactionReportFieldAcquirer"]) && $all["transactionReportFieldAcquirer"]==$acq->id ? 'selected' : ''}}>{{$acq->acquirerName}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-3 reportFields" id="">
				<select id="transactionReportFieldChannel" name="transactionReportFieldChannel" class="form-control">
					<option value>--Channel--</option>
					@foreach(getAllChannel() as $channel)
					<option value="{{$channel}}" {{isset($all) && isset($all['transactionReportFieldChannel']) && $all['transactionReportFieldChannel']==$channel ? 'selected' : ''}}>{{str_replace('_', ' ', $channel)}}</option>
					@endforeach				
				</select>
			</div>
			<div class="col-md-3 reportFields" id="">
				<select id="transactionReportFieldCardOrWallet" name="transactionReportFieldCardOrWallet" class="form-control">
					<option value>--Card Or Wallet--</option>
					<option value="CARD" {{isset($all) && isset($all['transactionReportFieldCardOrWallet']) && $all['transactionReportFieldCardOrWallet']=='CARD' ? 'selected' : ''}}>Card Only</option>
					<option value="WALLET" {{isset($all) && isset($all['transactionReportFieldCardOrWallet']) && $all['transactionReportFieldCardOrWallet']=='WALLET' ? 'selected' : ''}}>Wallet Only</option>				
				</select>
			</div>
			@endif

			<div class="col-md-3 reportFields" id="">
				<select id="transactionReportFieldStatus" name="transactionReportFieldStatus" class="form-control">
					<option value>--Status--</option>
					@foreach(getAllTransactionStatus() as $status)
					<option value="{{$status}}" {{isset($all) && isset($all['transactionReportFieldStatus']) && $all['transactionReportFieldStatus']==$status? 'selected' : ''}}>{{str_replace('_', ' ', $status)}}</option>
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
					<option value="{{$serviceType}}" {{isset($all) && isset($all['transactionReportFieldServiceType']) && $all['transactionReportFieldServiceType']==$serviceType ? 'selected' : ''}}>{{str_replace('_', ' ', $st)}}</option>
					@endforeach				
				</select>
			</div>

			@if(\Auth::user()->role_code!=\App\Models\Roles::$AGENT)
			<div class="col-md-3 reportFields" id="">
				<input type="text" id="transactionReportFieldDevice" name="transactionReportFieldDevice" class="form-control" placeholder="Bevura Device Code" value="{{isset($all) && isset($all["transactionReportFieldDevice"]) ? $all["transactionReportFieldDevice"] : ''}}" />
			</div>
			<div class="col-md-3 reportFields" id="">
				<input type="text" id="transactionReportFieldMerchant" name="transactionReportFieldMerchant" class="form-control" placeholder="Bevura Merchant Code" value="{{isset($all) && isset($all["transactionReportFieldMerchant"]) ? $all["transactionReportFieldMerchant"] : ''}}" />
			</div>
			@endif

			<div class="col-md-3 reportFields" id="">
				<input type="number" id="transactionReportFieldMinAmount" name="transactionReportFieldMinAmount" class="form-control" placeholder="Minimum Amount" value="{{isset($all) && isset($all["transactionReportFieldMinAmount"]) ? $all["transactionReportFieldMinAmount"] : ''}}" />
			</div>
			<div class="col-md-3 reportFields" id="">
				<input type="number" id="transactionReportFieldMaxAmount" name="transactionReportFieldMaxAmount" class="form-control" placeholder="Maximum Amount" value="{{isset($all) && isset($all["transactionReportFieldMaxAmount"]) ? $all["transactionReportFieldMaxAmount"] : ''}}" />
			</div>
			<div class="col-md-3 reportFields" id="">
				<input type="number" id="transactionReportFieldWalletNumber" name="transactionReportFieldWalletNumber" class="form-control" placeholder="Wallet Number" value="{{isset($all) && isset($all["transactionReportFieldWalletNumber"]) ? $all["transactionReportFieldWalletNumber"] : ''}}" />
			</div>

			@if(\Auth::user()->role_code!=\App\Models\Roles::$AGENT)
			<div class="col-md-3 reportFields" id="">
				<input type="number" id="transactionReportFieldCardNumber" name="transactionReportFieldCardNumber" class="form-control" placeholder="Card Number" value="{{isset($all) && isset($all["transactionReportFieldCardNumber"]) ? $all["transactionReportFieldCardNumber"] : ''}}" />
			</div>
			@endif


			<div class="col-md-12 col-sm-12 col-lg-12 reportFields" id="" style="clear: both !important;">
				<div class="col-md-3 reportFields" id="" style="clear: both !important; float: left !important">
					<label>Start Date</label><input type="date" id="transactionReportStartDate" name="transactionReportStartDate" class="form-control" placeholder="Start Date" value="{{isset($all) && isset($all["transactionReportStartDate"]) ? $all["transactionReportStartDate"] : ''}}" />
				</div>
				<div class="col-md-3 reportFields" id="" style="float: left !important">
					<label>End  Date</label><input type="date" id="transactionReportEndDate" name="transactionReportEndDate" class="form-control" placeholder="End Date" value="{{isset($all) && isset($all["transactionReportEndDate"]) ? $all["transactionReportEndDate"] : ''}}" />
				</div>
				<div class="col-md-3 reportFields" id="" style="float: left !important">
					<label>Maximum No. of Results</label><select id="transactionsReportCount" name="transactionsReportCount" class="form-control">
						<option value="1000" {{isset($all) && isset($all['transactionsReportCount']) && $all['transactionsReportCount']==1000 ? 'selected' : ''}}>1000</option>
						<option value="2000" {{isset($all) && isset($all['transactionsReportCount']) && $all['transactionsReportCount']==2000 ? 'selected' : ''}}>2000</option>
						<option value="4000" {{isset($all) && isset($all['transactionsReportCount']) && $all['transactionsReportCount']==4000 ? 'selected' : ''}}>4000</option>
						<option value="All" {{isset($all) && isset($all['transactionsReportCount']) && $all['transactionsReportCount']=='All' ? 'selected' : ''}}>All</option>		
					</select>
				</div>
			</div>


			<div class="col-md-12 pull-right text-right" style="">
				<a style="cursor: pointer !important" class="btn btn-primary runreport">Run Report</a>
			</div></fieldset>
		</div>




		<div class="row filterDiv" id="deviceReportFields" style="margin-left: 0px !important; margin-right: 0px !important; display: none !important"><fieldset class="row"><legend>Apply Filter (Devices Report)</legend>
			<div class="col-md-3 reportFields" id="">
				<select id="deviceReportFieldIsLive" name="deviceReportFieldIsLive" class="form-control">
					<option value="0">UAT</option>
					<option value="1">Live</option>				
				</select>
			</div>
			<div class="col-md-3 reportFields" id="">
				<select id="deviceReportFieldStatus" name="deviceReportFieldStatus" class="form-control">
					<option value>--Status--</option>
					@foreach(getAllTransactionStatus() as $status)
					<option value="{{$status}}">{{str_replace('_', ' ', $status)}}</option>
					@endforeach				
				</select>
			</div>

			<div class="col-md-3 reportFields" id="">
				<input type="text" id="deviceReportFieldMerchant" name="deviceReportFieldMerchant" class="form-control" placeholder="Bevura Merchant Code"/>
			</div>
			
			<div class="col-md-12 pull-right text-right" style="">
				<a style="cursor: pointer !important" class="btn btn-primary runreport">Run Report</a>
			</div></fieldset>
		</div>



		<div class="row filterDiv" id="merchantReportFields" style="margin-left: 0px !important; margin-right: 0px !important; display: none !important"><fieldset class="row"><legend>Apply Filter (Merchant Report)</legend>
			<div class="col-md-3 reportFields" id="">
				<select id="merchantReportFieldSettlementBank" name="merchantReportFieldSettlementBank" class="form-control">
					<option value>--Settlement Bank--</option>
					@foreach($banks as $bk)
					<option value="{{$bk->id}}">{{$bk->bankName}}</option>
					@endforeach				
				</select>
			</div>
			<div class="col-md-3 reportFields" id="">
				<select id="merchantReportFieldStatus" name="merchantReportFieldStatus" class="form-control">
					<option value>--Status--</option>
					@foreach(getAllMerchantStatus() as $status)
					<option value="{{$status}}">{{str_replace('_', ' ', $status)}}</option>
					@endforeach				
				</select>
			</div>

			<div class="col-md-3 reportFields" id="">
				<select id="merchantReportFieldMerchantScheme" name="merchantReportFieldMerchantScheme" class="form-control">
					<option value>--Merchant Scheme--</option>
					@foreach($all_merchant_schemes as $scheme)
					<option value="{{$scheme->id}}">{{$scheme->schemename}}</option>
					@endforeach				
				</select>
			</div>
			
			<div class="col-md-12 pull-right text-right" style="">
				<a style="cursor: pointer !important" class="btn btn-primary runreport">Run Report</a>
			</div></fieldset>
		</div>



		<div class="row filterDiv" id="customerReportFields" style="margin-left: 0px !important; margin-right: 0px !important; display: none !important"><fieldset class="row"><legend>Apply Filter (User Report)</legend>
			<div class="col-md-3 reportFields" id="">
				<select id="customerReportFieldCustomerType" name="customerReportFieldCustomerType" class="form-control">
					<option value>--Customer Type--</option>
					<option value="INDIVIDUAL">Individual Customers</option>
					<option value="CORPORATE">Corporate Customers</option>
					<option value="COLLECTIONS">Collections</option>
				</select>
			</div>
			<div class="col-md-3 reportFields" id="">
				<select id="customerReportFieldStatus" name="customerReportFieldStatus" class="form-control">
					<option value>--Status--</option>
					@foreach(getAllMerchantStatus() as $status)
					<option value="{{$status}}">{{str_replace('_', ' ', $status)}}</option>
					@endforeach				
				</select>
			</div>

			<div class="col-md-3 reportFields" id="">
				<select id="customerReportFieldGender" name="customerReportFieldGender" class="form-control">
					<option value>--Gender--</option>
					@foreach($all_merchant_schemes as $scheme)
					<option value="{{$scheme->id}}">{{$scheme->schemename}}</option>
					@endforeach				
				</select>
			</div>
			
			<div class="col-md-12 pull-right text-right" style="">
				<a style="cursor: pointer !important" class="btn btn-primary runreport">Run Report</a>
			</div></fieldset>
		</div>




		<div class="row filterDiv" id="cardReportFields" style="margin-left: 0px !important; margin-right: 0px !important; display: none !important"><fieldset class="row"><legend>Apply Filter (Cards Report)</legend>
			<div class="col-md-3 reportFields" id="">
				<select id="cardReportFieldCurrency" name="cardReportFieldCurrency" class="form-control">
					@foreach(getAllCurrency() as $currency)
					<option value="{{$currency}}">{{$currency}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-3 reportFields" id="">
				<select id="cardReportFieldAcquirer" name="cardReportFieldAcquirer" class="form-control">
					<option value>--Acquirer--</option>
					@foreach($acquirers as $acq)
					<option value="{{$acq->id}}">{{$acq->acquirerName}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-3 reportFields" id="">
				<select id="cardReportFieldCardScheme" name="cardReportFieldCardScheme" class="form-control">
					<option value>--Card Scheme--</option>
					@foreach($all_card_schemes as $scheme)
					<option value="{{$scheme->id}}">{{$scheme->schemeName}}</option>
					@endforeach				
				</select>
			</div>
			<div class="col-md-3 reportFields" id="">
				<select id="cardReportFieldCardType" name="cardReportFieldCardType" class="form-control">
					<option value>--Type of Card--</option>
					@foreach(getAllCardType() as $cardType => $cardTypeName)
					<option value="{{$cardType}}">{{$cardTypeName}}</option>
					@endforeach				
				</select>
			</div>
			<div class="col-md-3 reportFields" id="">
				<select id="cardReportFieldIsLive" name="cardReportFieldIsLive" class="form-control">
					<option value="0">UAT</option>
					<option value="1">Live</option>				
				</select>
			</div>
			<div class="col-md-3 reportFields" id="">
				<select id="cardReportFieldStatus" name="cardReportFieldStatus" class="form-control">
					<option value>--Status--</option>
					@foreach(getAllCardStatus() as $status)
					<option value="{{$status}}">{{str_replace('_', ' ', $status)}}</option>
					@endforeach				
				</select>
			</div>

			<div class="col-md-3 reportFields" id="">
				<input type="number" id="cardReportFieldMinBalance" name="cardReportFieldMinBalance" class="form-control" placeholder="Minimum Balance"/>
			</div>
			<div class="col-md-3 reportFields" id="">
				<input type="number" id="cardReportFieldMaxBalance" name="cardReportFieldMaxBalance" class="form-control" placeholder="Maximum Balance"/>
			</div>


			<div class="col-md-12 col-sm-12 col-lg-12 reportFields" id="" style="clear: both !important;">
				<div class="col-md-3 reportFields" id="" style="clear: both !important; float: left !important">
					<label>Start Date</label><input type="date" id="cardReportStartDate" name="cardReportStartDate" class="form-control" placeholder="Start Date" value="{{isset($all) && isset($all["cardReportStartDate"]) ? $all["cardReportStartDate"] : ''}}" />
				</div>
				<div class="col-md-3 reportFields" id="" style="float: left !important">
					<label>End  Date</label><input type="date" id="cardReportEndDate" name="cardReportEndDate" class="form-control" placeholder="End Date" value="{{isset($all) && isset($all["cardReportEndDate"]) ? $all["cardReportEndDate"] : ''}}" />
				</div>

				<div class="col-md-3 reportFields" id="" style="float: left !important">
					<label>Maximum No. of Results</label><select id="cardReportCount" name="cardReportCount" class="form-control">
						<option value="1000" {{isset($all) && isset($all['cardReportCount']) && $all['cardReportCount']==1000 ? 'selected' : ''}}>1000</option>
						<option value="2000" {{isset($all) && isset($all['cardReportCount']) && $all['cardReportCount']==2000 ? 'selected' : ''}}>2000</option>
						<option value="4000" {{isset($all) && isset($all['cardReportCount']) && $all['cardReportCount']==4000 ? 'selected' : ''}}>4000</option>	
						<option value="All" {{isset($all) && isset($all['cardReportCount']) && $all['cardReportCount']=='All' ? 'selected' : ''}}>All</option>	
					</select>
				</div>
			</div>




			<div class="col-md-12 pull-right text-right" style="">
				<a style="cursor: pointer !important" class="btn btn-primary runreport">Run Report</a>
			</div></fieldset>
		</div>





		<div class="row filterDiv" id="accountReportFields" style="margin-left: 0px !important; margin-right: 0px !important; display: none !important"><fieldset class="row"><legend>Apply Filter (Account Report)</legend>
			<div class="col-md-3 reportFields" id="">
				<select id="accountReportFieldCurrency" name="accountReportFieldCurrency" class="form-control">
					@foreach(getAllCurrency() as $currency)
					<option value="{{$currency}}">{{$currency}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-3 reportFields" id="">
				<select id="accountReportFieldAcquirer" name="accountReportFieldAcquirer" class="form-control">
					<option value>--Acquirer--</option>
					@foreach($acquirers as $acq)
					<option value="{{$acq->id}}">{{$acq->acquirerName}}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-3 reportFields" id="">
				<select id="accountReportFieldCardScheme" name="accountReportFieldCardScheme" class="form-control">
					<option value>--Card Scheme--</option>
					@foreach($all_card_schemes as $scheme)
					<option value="{{$scheme->id}}">{{$scheme->schemeName}}</option>
					@endforeach				
				</select>
			</div>
			<div class="col-md-3 reportFields" id="">
				<select id="accountReportFieldCardType" name="accountReportFieldAccountType" class="form-control">
					<option value>--Type of Account--</option>
					@foreach(getAllAccountType() as $accountType => $accountTypeName)
					<option value="{{$accountType}}">{{$accountTypeName}}</option>
					@endforeach				
				</select>
			</div>
			<div class="col-md-3 reportFields" id="">
				<select id="accountReportFieldIsLive" name="accountReportFieldIsLive" class="form-control">
					<option value="0">UAT</option>
					<option value="1">Live</option>				
				</select>
			</div>
			<div class="col-md-3 reportFields" id="">
				<select id="accountReportFieldStatus" name="accountReportFieldStatus" class="form-control">
					<option value>--Status--</option>
					@foreach(get_account_status() as $status)
					<option value="{{$status}}">{{str_replace('_', ' ', $status)}}</option>
					@endforeach				
				</select>
			</div>

			<div class="col-md-3 reportFields" id="">
				<input type="number" id="accountReportFieldMinBalance" name="accountReportFieldMinBalance" class="form-control" placeholder="Minimum Balance"/>
			</div>
			<div class="col-md-3 reportFields" id="">
				<input type="number" id="accountReportFieldMaxBalance" name="accountReportFieldMaxBalance" class="form-control" placeholder="Maximum Balance"/>
			</div>
			<div class="col-md-12 pull-right text-right" style="">
				<a style="cursor: pointer !important" class="btn btn-primary runreport">Run Report</a>
			</div></fieldset>
		</div>
		</form>
            
            <div class="table-responsive reportResponse" style="padding-top: 20px !important; display: none" id="reportResponseTransaction">
                <table id="alltransactionstable" width="100%" class="table table-striped table-lightfont">
                    


		@if(\Auth::user()->role_code==\App\Models\Roles::$AGENT)
	            	<thead>
                    <tr style="background-color: #000 !important; color: #fff !important;">
			   <th></th>
                        <th>id</th>
                        <th>Date</th>
                        <th>Bevura Txn Ref</th>
                        <th>Bevura Wallet/Card</th>
                        <th>Other Partner Account</th>
                        <th>Other Partner Customer Name</th>
                        <th>Partner Type</th>
                        <th>Other Partner Ref</th>
                        <th>Bank Ref</th>
                        <th>Transaction Type</th>
                        <th>Remarks</th>
                        <th>Bevura Customer</th>
                        <th>Service & Channel</th>
                        <th>Status</th>
                        <th>Total Amount</th>
                        <th>Balance After</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
			   <th></th>
                        <th>id</th>
                        <th>Date</th>
                        <th>Bevura Txn Ref</th>
                        <th>Bevura Wallet/Card</th>
                        <th>Other Partner Account</th>
                        <th>Other Partner Customer Name</th>
                        <th>Partner Type</th>
                        <th>Other Partner Ref</th>
                        <th>Bank Ref</th>
                        <th>Transaction Type</th>
                        <th>Remarks</th>
                        <th>Bevura Customer</th>
                        <th>Service & Channel</th>
                        <th>Status</th>
                        <th>Total Amount</th>
                        <th>Balance After</th>
                    </tr>
                    </tfoot>
		@else
	            	<thead>
                    <tr style="background-color: #000 !important; color: #fff !important;">
                        <th>id</th>
                        <th>Date & Txn Ref</th>
                        <th>Customer</th>
                        <th>Service & Channel</th>
                        <th>Status</th>
                        <th>Total Amount</th>
			   <th>Total Charges</th>
                        <th>Balance After</th>
                        <!--<th>Post Pool Balance</th>-->
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr style="background-color: #000 !important; color: #fff !important;">
                        <th>id</th>
                        <th>Date & Txn Ref</th>
                        <th>Customer</th>
                        <th>Service & Channel</th>
                        <th>Status</th>
                        <th>Total Amount</th>
			   <th>Total Charges</th>
                        <th>Balance After</th>
                        <!--<th>Post Pool Balance</th>-->
                        <th class="actionColumn">Action</th>
                    </tr>
                    </tfoot>
		@endif





                    <tbody>

                    </tbody>
                </table>
            </div>

		<a class="btn btn-primary" onclick="javascript:Popup('reportResponseTransaction')" style="cursor:pointer !important">Print Report</a>
        </div>
    </div>

@include('core.authenticated.charges.includes.journal_entry_float_view')

@stop
@section('section_title') Reports @stop

@section('style')

@stop

@section('scripts')
    <link rel="stylesheet" href="/css/aa.css">
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



function Popup(elem) {
	setTimeout(function(){
		$('#alltransactionstable_length').hide();
		$('#alltransactionstable_filter').hide();
		$('#alltransactionstable_info').hide();
		$('#alltransactionstable_paginate').hide();
		$('.actionColumn').hide();
      },1000);


      var mywindow = window.open('', 'new div', 'height=400,width=600');
      mywindow.document.write('<html><head><title></title>');
      mywindow.document.write('<link rel="stylesheet" href="/css/aa.css">');
      mywindow.document.write('<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">');

      mywindow.document.write('<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet" type="text/css">');
      mywindow.document.write('<link href="/bower_components/select2/dist/css/select2.min.css" rel="stylesheet">');
      mywindow.document.write('<link href="/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">');
      mywindow.document.write('<link href="/bower_components/dropzone/dist/dropzone.css" rel="stylesheet">');
      mywindow.document.write('<link href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">');
      mywindow.document.write('<link href="/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">');
      mywindow.document.write('<link href="/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">');
      mywindow.document.write('<link href="/bower_components/slick-carousel/slick/slick.css" rel="stylesheet">');
      mywindow.document.write('<link href="/css/main.css?version=4.5.0" rel="stylesheet">');
      mywindow.document.write('<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">');
      mywindow.document.write('<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">');



      mywindow.document.write('</head><body >');

	setTimeout(function(){

      		mywindow.document.write($('#' + elem).html());
      		mywindow.document.write('</body></html>');
      		mywindow.document.close();
      		mywindow.focus();

		setTimeout(function(){mywindow.print();},1000);
	}, 10000);
      
      
      //mywindow.close();

      return true;
}


        $(document).ready(function()
        {
            var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
	     var filter = null;
		@if(isset($filter) && $filter!=null)
		filter = '{{$filter}}';
		@endif

		var queryStr = "";

		@if(isset($data) && $data!=null)
			@foreach($data as $d => $d1)
				queryStr = "&{{$d}}={{$d1}}" + queryStr;
			@endforeach
		@endif


		@if(isset($reportType) && $reportType!=null && $reportType=="TRANSACTION")
			$('.reportResponse').hide();
			$('#reportResponseTransaction').show();

			filter = '';
			@if(isset($all['transactionReportFieldChannel']) && $all['transactionReportFieldChannel']!=null && strlen(trim($all['transactionReportFieldChannel']))>0)
				filter = filter + "{{strtolower($all['transactionReportFieldChannel'])}}";
			@endif


			@if(isset($all["transactionReportFieldCurrency"]) && $all["transactionReportFieldCurrency"]!=null && strlen(trim($all["transactionReportFieldCurrency"]))>0)
				queryStr = queryStr+ "&currency={{strtoupper($all["transactionReportFieldCurrency"])}}";
			@endif
			@if(isset($all["transactionReportFieldCardOrWallet"]) && $all["transactionReportFieldCardOrWallet"]!=null && strlen(trim($all["transactionReportFieldCardOrWallet"]))>0)
				queryStr = queryStr+ "&cardOrWallet={{strtolower($all["transactionReportFieldCardOrWallet"])}}";
			@endif
			@if(isset($all["transactionReportFieldStatus"]) && $all["transactionReportFieldStatus"]!=null && strlen(trim($all["transactionReportFieldStatus"]))>0)
				queryStr = queryStr+ "&status={{strtoupper($all["transactionReportFieldStatus"])}}";
			@endif
			@if(isset($all["transactionReportFieldAcquirer"]) && $all["transactionReportFieldAcquirer"]!=null && strlen(trim($all["transactionReportFieldAcquirer"]))>0)
				queryStr = queryStr+ "&acquirerId={{strtolower($all["transactionReportFieldAcquirer"])}}";
			@endif
			@if(isset($all["transactionReportFieldServiceType"]) && $all["transactionReportFieldServiceType"]!=null && strlen(trim($all["transactionReportFieldServiceType"]))>0)
				var dd = '{{str_replace(' ', '_', $all["transactionReportFieldServiceType"])}}';
				queryStr = queryStr+ "&serviceType=" + encodeURIComponent(dd);
			@endif
			@if(isset($all["transactionReportFieldMinAmount"]) && $all["transactionReportFieldMinAmount"]!=null && strlen(trim($all["transactionReportFieldMinAmount"]))>0)
				queryStr = queryStr+ "&minTransactionAmount={{strtolower($all["transactionReportFieldMinAmount"])}}";
			@endif
			@if(isset($all["transactionReportFieldMaxAmount"]) && $all["transactionReportFieldMaxAmount"]!=null && strlen(trim($all["transactionReportFieldMaxAmount"]))>0)
				queryStr = queryStr+ "&maxTransactionAmount={{strtolower($all["transactionReportFieldMaxAmount"])}}";
			@endif
			@if(isset($all["transactionReportFieldDevice"]) && $all["transactionReportFieldDevice"]!=null && strlen(trim($all["transactionReportFieldDevice"]))>0)
				queryStr = queryStr+ "&deviceCode={{strtolower($all["transactionReportFieldDevice"])}}";
			@endif
			@if(isset($all["transactionReportFieldMerchant"]) && $all["transactionReportFieldMerchant"]!=null && strlen(trim($all["transactionReportFieldMerchant"]))>0)
				queryStr = queryStr+ "&merchantCode={{strtolower($all["transactionReportFieldMerchant"])}}";
			@endif
			@if(isset($all["transactionReportFieldWalletNumber"]) && $all["transactionReportFieldWalletNumber"]!=null && strlen(trim($all["transactionReportFieldWalletNumber"]))>0)
				queryStr = queryStr+ "&customerAccountNumber={{strtolower($all["transactionReportFieldWalletNumber"])}}";
			@endif
			@if(isset($all["transactionReportFieldCardNumber"]) && $all["transactionReportFieldCardNumber"]!=null && strlen(trim($all["transactionReportFieldCardNumber"]))>0)
				<?php
				$hashedPan = $encrypterFrom->encrypt($all['transactionReportFieldCardNumber']."");
				?>
				var dd = '{{$hashedPan}}';
				queryStr = queryStr+ "&customerPanNumber=" + encodeURIComponent(dd);
			@endif
			@if(isset($all["cardReportStartDate"]) && $all["cardReportStartDate"]!=null && strlen(trim($all["cardReportStartDate"]))>0 && $all["reportType"]=="CARD")
				queryStr = queryStr+ "&startDate={{($all["cardReportStartDate"])}}";
			@endif
			@if(isset($all["cardReportEndDate"]) && $all["cardReportEndDate"]!=null && strlen(trim($all["cardReportEndDate"]))>0 && $all["reportType"]=="CARD")
				queryStr = queryStr+ "&endDate={{($all["cardReportEndDate"])}}";
			@endif

			@if(isset($all["transactionReportStartDate"]) && $all["transactionReportStartDate"]!=null && strlen(trim($all["transactionReportStartDate"]))>0 && $all["reportType"]=="TRANSACTION")
				queryStr = queryStr+ "&startDate={{($all["transactionReportStartDate"])}}";
			@endif
			@if(isset($all["transactionReportEndDate"]) && $all["transactionReportEndDate"]!=null && strlen(trim($all["transactionReportEndDate"]))>0 && $all["reportType"]=="TRANSACTION")
				queryStr = queryStr+ "&endDate={{($all["transactionReportEndDate"])}}";
			@endif

			@if(isset($all["transactionsReportCount"]) && $all["transactionsReportCount"]!=null && strlen(trim($all["transactionsReportCount"]))>0 && $all["reportType"]=="TRANSACTION")
				@if($all["transactionsReportCount"]!='All')
					queryStr = queryStr+ "&count={{$all["transactionsReportCount"]}}";
				@else
					queryStr = queryStr+ "&count=-1";
				@endif
			@endif


			@if(isset($all["cardReportCount"]) && $all["cardReportCount"]!=null && strlen(trim($all["cardReportCount"]))>0 && $all["reportType"]=="CARD")
				@if($all["cardReportCount"]!='All')
					queryStr = queryStr+ "&count={{$all["cardReportCount"]}}";
				@else
					queryStr = queryStr+ "&count=-1";
				@endif
			@endif




console.log(filter);
console.log(queryStr);

			@if(\Auth::user()->role_code==\App\Models\Roles::$AGENT)
	            		viewTransactionListForAgent(jwtToken, 1000, filter, queryStr );
			@else
	            		viewTransactionList(jwtToken, 1000, filter, queryStr );
			@endif
		@endif
        });


	
	function viewJournalEntries(transactionId)
	{
		var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
		var deviceCode = '{{PROBASEWALLET_DEVICE_CODE}}';
		var accountTypes = [];
		@foreach(glAccountTypes() as $ga => $ga_)
			accountTypes.push('{{$ga_}}');
		@endforeach
		viewJournalEntriesByFilter(jwtToken, deviceCode, transactionId, accountTypes);
	}


	function viewReverseTransaction(transactionId)
	{
		var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
		var deviceCode = '{{BEVURA_DEVICE_CODE}}';
		
		if (confirm('Please confirm, Are reversing this transaction?'))
		{
			var url = '/api/reverse-transaction';
			var data_ = [];
			console.log(jwtToken);
			console.log(deviceCode);
			console.log(transactionId);
			var formData = new FormData();
			formData.append('transactionId', transactionId);
			formData.append('deviceCode', deviceCode);
			
			$.ajax({
				type: "POST",
				url: (url),
				data: (formData),
				processData: false,
				contentType: false,
				cache: false,
				headers: {"Authorization": jwtToken},
				timeout: 600000,
				success: function handleSuccess(data1){
					console.log(data1);
					
				},
				error: function (e) {
					toastr.error('We experienced an issue updating your merchant profile. Please try again.');
				}
			});
		}
		else
		{
  			// Do nothing!
  			console.log('Thing was not saved to the database.');
		}
	}


	$('#reportType').on('change', function(e){
		if($('#reportType').val()=='TRANSACTION')
		{
			$('.filterDiv').hide();		
			$("#transactionReportFields").show();		
		}
		else if($('#reportType').val()=='MERCHANT')
		{
			$('.filterDiv').hide();		
			$("#merchantReportFields").show();		
		}
		else if($('#reportType').val()=='DEVICE')
		{
			$('.filterDiv').hide();		
			$("#deviceReportFields").show();		
		}
		else if($('#reportType').val()=='CUSTOMER')
		{
			$('.filterDiv').hide();		
			$("#customerReportFields").show();		
		}
		else if($('#reportType').val()=='ACCOUNT')
		{
			$('.filterDiv').hide();		
			$("#accountReportFields").show();	
		}
		else if($('#reportType').val()=='CARD')
		{
			$('.filterDiv').hide();		
			$("#cardReportFields").show();			
		}
	});


	$('.runreport').on('click', function(e){
		$('#filterform').submit();
	});


    </script>
@stop



