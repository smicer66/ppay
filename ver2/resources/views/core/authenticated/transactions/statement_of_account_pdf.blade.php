<!DOCTYPE html>
<html>
	<head>
		<title>Statement of Accounts</title>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta content="ie=edge" http-equiv="x-ua-compatible">
		<meta content="Bevura Probase" name="keywords">
		<meta content="Probase" name="author">
		<style style="text/css">
			body {
        			font-family: Arial, Helvetica, sans-serif;
				font-size: 11px !important;
    			}
		</style>
	</head>
	<body class="menu-position-side menu-side-left full-screen with-content-panel">
		<div class="all-wrapper with-side-panel solid-bg-all">
			<div class="layout-w">
				<!--------------------
					START - Mobile Menu
					-------------------->
				<div class="content-w" style="padding-left: 0px !important;">
					<div class="content-i">
						<div class="element-wrapper col-md-10" id="statementDiv">
							<div class="element-box">
								<img class="logo_image" src="{{$path_img}}" alt="" width="120">
								<div style="clear: both !important" class="col-md-12">&nbsp;</div>
								<div class="col-md-9" style="">
									<div class="form-header" style="color: #1b13ba !important; font-size: 20px !important;">
										<strong>Statement Of Wallet</strong>
									</div>
									<div class="form-desc" style="font-weight: bold !important; float: left !Important">
										Your Wallet Account Statement
									</div>
									<div style="clear: both !important" class="col-md-12">&nbsp;</div>
									<div class="table-responsive">
										<div>
											<div style="background-color: #c7c7c7  !important; padding: 10px !important; display: inline-block; color: #1b13ba !important; font-weight: bold !important;">Wallet Information</div>
										</div>
										<table id="walletinfotable" width="100%" class="table table-striped table-lightfont" style="clear: both !important">
											<tbody>
												<tr>
													<td style="padding: 10px !important; font-weight: bold !important">Statement Period:</td>
													<td style="padding: 10px !important; text-align: right !important">{{date('M d, Y', strtotime($customer->created_at))}} to {{date('M, d, Y')}}</th>
												</tr>
												<tr style="background-color: #c7c7c7;">
													<td style="padding: 10px !important; font-weight: bold !important">Wallet Number:</td >
													<td style="padding: 10px !important; text-align: right !important">{{join(' ', str_split($customer->accountIdentifier, 4))}}</td >
												</tr>
												<tr>
													<td style="padding: 10px !important; font-weight: bold !important">Wallet Holder:</td >
													<td style="padding: 10px !important; text-align: right !important">{{$customer->firstName}} {{$customer->lastName}}</td>
												</tr>
												<tr style="background-color: #c7c7c7;">
													<td style="padding: 10px !important; font-weight: bold !important">Wallet Class:</td >
													<td style="padding: 10px !important; text-align: right !important">{{array_keys($accountTypes)[$customer->accountType]}}</td >
												</tr>
												<tr>
													<td style="padding: 10px !important; font-weight: bold !important">Date Opened:</td >
													<td style="padding: 10px !important; text-align: right !important">{{date('M d, Y', strtotime($customer->created_at))}}</td>
												</tr>
												<tr style="background-color: #c7c7c7;">
													<td style="padding: 10px !important; font-weight: bold !important">Wallet Balance ({{array_keys($currencies)[$customer->probasePayCurrency]}}):</td>
													<td style="padding: 10px !important; text-align: right !important">{{number_format($customer->accountBalance, 2, '.', ',')}}</th>
												</tr>
											</tbody>
										</table>
										<div>
											<div style="background-color: #c7c7c7  !important; padding: 10px !important; display: inline-block; color: #1b13ba !important; font-weight: bold !Important">Summary Of Your Wallet</div>
										</div>
										<table id="walletinfotable" width="100%" class="table table-striped table-lightfont" style="clear: both !important">
											<thead>
												<tr style="background-color: #000 !important; color: #fff !important;">
													<th width="20%" style="padding: 5px !Important; text-align: left !important">Date</th>
													<th style="padding: 5px !Important; text-align: left !important">Description</th>
													<th width="15%" style="padding: 5px !Important; text-align: right !important">Debit ({{array_keys($currencies)[$customer->probasePayCurrency]}})</th>
													<th width="15%" style="padding: 5px !Important; text-align: right !important">Credit ({{array_keys($currencies)[$customer->probasePayCurrency]}})</th>
													<th width="15%" style="padding: 5px !Important; text-align: right !important">Balance ({{array_keys($currencies)[$customer->probasePayCurrency]}})</th>
												</tr>
											</thead>
											<tbody>
												@foreach($transactionList as $tx)
												<?php
													if($tx->details=='Village Banking Group Creation')
													{
														//if(isset($tx->creditamount) && !is_null($tx->creditamount))
															//dd($tx->creditamount);
														//else
															//dd($tx);
													}
																		if(isset($tx->debitamount) && $tx->debitamount!=null)
																			$amount = $tx->debitamount + (isset($tx->fixedCharge) && $tx->fixedCharge!=null ? $tx->fixedCharge : 0) + (isset($tx->schemeTransactionCharge) && $tx->schemeTransactionCharge!=null ? $tx->schemeTransactionCharge : 0) + (isset($tx->transactionCharge) && $tx->transactionCharge!=null ? $tx->transactionCharge : 0) + (isset($tx->transactionPercentage) && $tx->transactionPercentage!=null ? $tx->transactionPercentage : 0);
																		else if(isset($tx->creditamount) && $tx->creditamount!=null)
																			$amount = $tx->creditamount;
													
																		?>
												<tr style="" >
													<td style="border-bottom: #c7c7c7 1px solid !important; padding: 5px !Important;">{{date('M d, Y', strtotime($tx->created_at))}}</td>
													<td style="border-bottom: #c7c7c7 1px solid !important; padding: 5px !Important;">
													@if($tx->serviceType==25)
													Village Banking Group creation<br>
													Debited From Wallet
													@else
														@if(isset($tx->debitamount) && $tx->debitamount!=null)
															@if(isset($tx->debitPan) && !is_null($tx->debitPan))
															{{isset($tx->details) ? $tx->details : ''}}<br>
															Debited From Card: {{isset($tx->debitPan) && !is_null($tx->debitPan) ? $tx->debitPan: ''}}
															@else
															{{isset($tx->details) ? $tx->details : ''}}<br>
															Debited From Wallet
															@endif
														@elseif(isset($tx->creditamount) && $tx->creditamount!=null)
															@if(isset($tx->debitPan) && !is_null($tx->debitPan))
															{{isset($tx->recipientDetails) ? $tx->recipientDetails: ''}}<br>
															Credited To Card: {{isset($tx->creditPan) && !is_null($tx->creditPan) ? $tx->creditPan : ''}}
															@else
															{{isset($tx->recipientDetails) ? $tx->recipientDetails: ''}}<br>
															Credited To Wallet
															@endif
														@endif
													@endif



													</td>
													<td style="border-bottom: #c7c7c7 1px solid !important; padding: 5px !Important; text-align: right !important">{{isset($tx->debitamount ) && !is_null($tx->debitamount ) ? number_format(($tx->debitamount + (isset($tx->fixedCharge) && $tx->fixedCharge!=null ? $tx->fixedCharge : 0) + (isset($tx->schemeTransactionCharge) && $tx->schemeTransactionCharge!=null ? $tx->schemeTransactionCharge : 0) + (isset($tx->transactionCharge) && $tx->transactionCharge!=null ? $tx->transactionCharge : 0) + (isset($tx->transactionPercentage) && $tx->transactionPercentage!=null ? $tx->transactionPercentage : 0)), 2, '.', ',') : ''}}</td>
													<td style="border-bottom: #c7c7c7 1px solid !important; padding: 5px !Important; text-align: right !important">{{isset($tx->creditamount) && !is_null($tx->creditamount) ? number_format(($tx->creditamount), 2, '.', ',') : ''}}</td>
													@if(isset($tx->debitamount) && !is_null($tx->debitamount))
													<td style="border-bottom: #c7c7c7 1px solid !important; padding: 5px !Important; text-align: right !important">{{isset($tx->currentAccountBalance) && ($tx->currentAccountBalance!=null) ? number_format($tx->currentAccountBalance, 2, '.', ',') : (isset($tx->currentCardBalance) && ($tx->currentCardBalance!=null) ? number_format($tx->currentCardBalance, 2, '.', ',') : '')}}</td>
													@elseif(isset($tx->creditamount) && !is_null($tx->creditamount))
													<td style="border-bottom: #c7c7c7 1px solid !important; padding: 5px !Important; text-align: right !important">{{isset($tx->currentRecipientAccountBalance) && ($tx->currentRecipientAccountBalance!=null) ? number_format($tx->currentRecipientAccountBalance, 2, '.', ',') : (isset($tx->currentRecipientCardBalance) && ($tx->currentRecipientCardBalance!=null) ? number_format($tx->currentRecipientCardBalance, 2, '.', ',') : '')}}</td>
													@endif
												</tr>
												@endforeach
												<tr style="background-color: #c7c7c7  !important; ">
													<td colspan="4" style="border-bottom: #c7c7c7 1px solid !important; padding: 5px !Important;"><strong>Your Current Wallet Balance</strong></th>
													<td style="border-bottom: #c7c7c7 1px solid !important; padding: 5px !Important; text-align: right !important"><strong>{{number_format($customer->accountBalance, 2, '.', ',')}}</strong></th>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div style="clear: both !important" class="col-md-12">&nbsp;</div>
								<div style="clear: both !important" class="col-md-12">&nbsp;</div>
								<div class="" style="float: left  !Important">
									<div class="col-md-12" style="border-radius: 10px !important; background-color: #ededed !important; padding: 10px !important; display: inline-block"><strong style="font-weight: bold !important;">Contact Information:</strong><br>
										www.bevura.com | 
										Bevura | 
										ZCCM-IH Office Park,<br>Mass Media Area, Alick Nkhata Road, | Lusaka Zambia |
										10110 | 
										+260 97 436 5365
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<!-- Info boxes -->