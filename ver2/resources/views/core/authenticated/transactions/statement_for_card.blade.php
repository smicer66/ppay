@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')

    @include('partials.errors')

    <!-- Info boxes -->
    <div class="element-wrapper col-md-10" id="statementDiv">
        <h6 class="element-header">
		Statement

        </h6>
        <div class="element-box">
		<img class="logo_image" src="/images/bevurabluelogo.png" alt="" width="120">
		<div style="clear: both !important" class="col-md-12">&nbsp;</div>
		<div class="col-md-9" style="float: left !important">
            <h5 class="form-header" style="color: #1b13ba !important">
                Statement Of Transactions For Card
            </h5>
            <div class="form-desc" style="">
                Your Card Statement
            </div>
            <div class="table-responsive">
			<div><div style="background-color: #c7c7c7  !important; padding: 10px !important; display: inline-block; color: #1b13ba !important">Wallet Information</div></div>
                <table id="walletinfotable" width="100%" class="table table-striped table-lightfont" style="clear: both !important">
                   
                    <tbody>
                    			<tr>
                        			<td>Wallet Balance ({{array_keys($currencies)[$customer->probasePayCurrency]}})</td>
                        			<td style="text-align: right !important">{{number_format($customer->cardBalance, 2, '.', ',')}}</th>
                    			</tr>
                    			<tr>
                        			<td >Wallet Class</td >
                        			<td style="text-align: right !important">{{$allCardTypes[$customer->cardType]}}</td >
                    			</tr>
                    			<tr>
                        			<td >Date Opened</td >
                        			<td style="text-align: right !important">{{date('M d, Y', strtotime($customer->created_at))}}</td>
                    			</tr>
                    </tbody>
                </table>

			<div><div style="background-color: #c7c7c7  !important; padding: 10px !important; display: inline-block; color: #1b13ba !important">Summary Of Your Card Transactions</div></div>
                <table id="walletinfotable" width="100%" class="table table-striped table-lightfont" style="clear: both !important">
                   <thead>
                    <tr style="background-color: #000 !important; color: #fff !important;">
                        <th>Date</th>
                        <th>Description</th>
                        <th style="text-align: right !important">Withdrawals ({{array_keys($currencies)[$customer->probasePayCurrency]}})</th>
                        <th style="text-align: right !important">Deposits ({{array_keys($currencies)[$customer->probasePayCurrency]}})</th>
                        <th style="text-align: right !important">Balance ({{array_keys($currencies)[$customer->probasePayCurrency]}})</th>
                    </tr>
                    </thead>
                    <tbody>
					@foreach($transactionList as $tx)
					<?php
//dd($transactionList);
					$amount = 0.00;
					if(isset($tx->debitCardId) && $tx->debitCardId!=null && $tx->debitCardId==$instanceId)
						$amount = $tx->amount + (isset($tx->fixedCharge) && $tx->fixedCharge!=null ? $tx->fixedCharge : 0) + (isset($tx->schemeTransactionCharge) && $tx->schemeTransactionCharge!=null ? $tx->schemeTransactionCharge : 0) + (isset($tx->transactionCharge) && $tx->transactionCharge!=null ? $tx->transactionCharge : 0) + (isset($tx->transactionPercentage) && $tx->transactionPercentage!=null ? $tx->transactionPercentage : 0);
					else if(isset($tx->creditCardId) && $tx->creditCardId!=null && $tx->creditCardId==$instanceId)
						$amount = $tx->amount;

					
					?>
                    			<tr>
                        			<td>{{date('M d, Y', strtotime($tx->created_at))}}</td>
                        			<td>{{isset($tx->details) ? $tx->details : ''}}<br>
							Ref: {{isset($tx->details) ? $tx->transactionRef : ''}}</td>
                        			<td style="text-align: right !important">{{$tx->drCardTrue==1 ? number_format($amount, 2, '.', ',') : ''}}</td>
                        			<td style="text-align: right !important">{{$tx->crCardTrue==1 ? number_format($amount, 2, '.', ',') : ''}}</td>
						@if(isset($tx->debitCardId) && $tx->debitCardId!=null && $tx->debitCardId==$instanceId)
                        			<td style="text-align: right !important">{{isset($tx->currentCardBalance) ? number_format($tx->currentCardBalance, 2, '.', ',') : ''}}</td>
						@elseif(isset($tx->creditCardId) && $tx->creditCardId!=null && $tx->creditCardId==$instanceId)
                        			<td style="text-align: right !important">{{isset($tx->currentRecipientCardBalance) ? number_format($tx->currentRecipientCardBalance, 2, '.', ',') : ''}}</td>
						@endif
                    			</tr>
					@endforeach
                    			<tr style="background-color: #c7c7c7  !important; ">
                        			<td colspan="4"><strong>Your Current Balance</strong></th>
                        			<td style="text-align: right !important"><strong>{{number_format($customer->cardBalance, 2, '.', ',')}}</strong></th>
                    			</tr>

                    </tbody>
                </table>
            	</div>
		</div>
		<div class="col-md-3" style="float: left !important">
			<div class="col-md-12"><div class="col-md-12" style="border-radius: 10px !important; background-color: #ededed !important; padding: 10px !important; display: inline-block"><strong style="font-weight: bold !important;">Statement Period:</strong><br>
				From: {{date('M d, Y', strtotime($customer->created_at))}}<br>
				To: {{date('M, d, Y')}}<br><br>
				<strong style="font-weight: bold !important;">Card Number:</strong><br>
				{{join(' ', str_split($customer->pan, 4))}}<br><br>
				<strong style="font-weight: bold !important;">Card Holder:</strong><br>
				{{$customer->nameOnCard}}
			</div></div>
		<div style="clear: both !important" class="col-md-12">&nbsp;</div>
		<div style="clear: both !important" class="col-md-12">&nbsp;</div>

			<div class="col-md-12"><div class="col-md-12" style="border-radius: 10px !important; background-color: #ededed !important; padding: 10px !important; display: inline-block"><strong style="font-weight: bold !important;">Ways to Deposit:</strong><br>
				Online Banking<br>
				Deposits Over the Counter<br>
				Through Our Agents<br>
				Through Our Agents<br>
			</div></div>


		<div style="clear: both !important" class="col-md-12">&nbsp;</div>
		<div style="clear: both !important" class="col-md-12">&nbsp;</div>

			<div class="col-md-12"><div class="col-md-12" style="border-radius: 10px !important; background-color: #ededed !important; padding: 10px !important; display: inline-block"><strong style="font-weight: bold !important;">Contact Information:</strong><br>
				www.bevura.com<br>
				Bevura<br>
				ZCCM-IH Office Park,<br>Mass Media Area<br>Alick Nkhata Road, <br>Lusaka Zambia<br>
				10110<br>
				+260 97 436 5365
			</div></div>




		</div>
		<div style="clear: both !important" class="col-md-12">&nbsp;</div>
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
	
@stop



