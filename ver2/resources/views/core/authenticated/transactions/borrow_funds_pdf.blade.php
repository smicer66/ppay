<!DOCTYPE html>
<html>
	<head>
		<title>Payment Receipt - {{strtoupper(join('-', str_split($transaction->transactionRef, 4)))}}</title>
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
		<div class="all-wrapper with-side-panel solid-bg-all" style="width: 80% !important; border: 1px dashed #636363; padding: 5px !important;">
			<div class="layout-w">
				<!--------------------
					START - Mobile Menu
					-------------------->
				<div class="content-w" style="padding-left: 0px !important; ">
					<div class="content-i">
						<div class="element-wrapper col-md-10" id="statementDiv">
							<div class="element-box">
								<img class="logo_image" src="{{$path_img}}" alt="" width="120">
								<div class="col-md-12" style="clear: both !important; border-radius: 10px !important; background-color: #ededed !important; padding: 10px !important; display: inline-block"><strong style="font-weight: bold !important;">Contact Information:</strong><br>
									www.bevura.com | 
									Bevura | 
									ZCCM-IH Office Park,<br>Mass Media Area, Alick Nkhata Road, | Lusaka Zambia |
									10110 | 
									+260 97 436 5365
								</div>
								<div style="clear: both !important" class="col-md-12">&nbsp;</div>
								<div class="col-md-9" style="">
									<div class="form-header" style="color: #1b13ba !important; font-size: 20px !important;">
										<strong>Payment Receipt</strong>
									</div>
									<div style="clear: both !important" class="col-md-12">&nbsp;</div>
									<div class="table-responsive">
										<div>
											<div style="background-color: #c7c7c7  !important; padding: 10px !important; display: inline-block; color: #1b13ba !important; font-weight: bold !important;">{{getAllServiceTypes()[array_keys(getAllServiceTypes())[$transaction->serviceType]]}}</div>
										</div>
<?php

$summary = json_decode($transaction->summary);
//dd($transaction);
$receipient = $summary->receipient;
$vendor = isset($summary->receipient) ? $summary->vendor : null;
$breakdown = $summary->breakdown;


?>
										<table id="walletinfotable" width="100%" class="table table-striped table-lightfont" style="clear: both !important">
											<tbody>
												<tr>
													<td style="padding: 10px !important; font-weight: bold !important">Purchase Date:</td>
													<td style="padding: 10px !important; text-align: right !important">{{date('M d, Y H:i', strtotime($transaction->created_at))}}</th>
												</tr>
												<tr style="background-color: #c7c7c7;">
													<td style="padding: 10px !important; font-weight: bold !important">Customer Debited:</td >
													<td style="padding: 10px !important; text-align: right !important">{{$transaction->sourceFirstName}} {{$transaction->sourceLastName}}</td >
												</tr>
												<tr>
													<td style="padding: 10px !important; font-weight: bold !important">Wallet Credited:</td >
													<td style="padding: 10px !important; text-align: right !important">{{$vendor==null ? "" : ($vendor." - ")}}{{$receipient}}</td>
												</tr>
												<tr style="background-color: #c7c7c7;">
													<td style="padding: 10px !important; font-weight: bold !important">Prior Recipient Balance ({{array_keys($currencies)[$transaction->probasePayCurrency]}}):</td >
													<td style="padding: 10px !important; text-align: right !important">{{number_format($transaction->priorRecipientAccountBalance, 2, '.', ',')}}</td>
												</tr>
												<tr>
													<td style="padding: 10px !important; font-weight: bold !important">Recipient Balance Post-Transaction ({{array_keys($currencies)[$transaction->probasePayCurrency]}}):</td >
													<td style="padding: 10px !important; text-align: right !important">{{number_format($transaction->currentRecipientAccountBalance, 2, '.', ',')}}</td>
												</tr>
												<tr style="background-color: #c7c7c7;">
													<td style="padding: 10px !important; font-weight: bold !important">Transaction Reference:</td >
													<td style="padding: 10px !important; text-align: right !important">{{strtoupper(join('-', str_split($transaction->transactionRef, 4)))}}</td >
												</tr>
												<tr>
													<td style="padding: 10px !important; font-weight: bold !important">Loan Amount ({{array_keys($currencies)[$transaction->probasePayCurrency]}}):</td>
													<td style="padding: 10px !important; text-align: right !important">{{number_format($transaction->amount, 2, '.', ',')}}</th>
												</tr>
												<tr style="background-color: #c7c7c7;">
													<td style="padding: 10px !important; font-weight: bold !important">Amount To Repay ({{array_keys($currencies)[$transaction->probasePayCurrency]}}):</td >
													<td style="padding: 10px !important; text-align: right !important">{{strtoupper(join('-', str_split($breakdown->amountToPayBack, 4)))}}</td >
												</tr>
												<tr>
													<td style="padding: 10px !important; font-weight: bold !important">Reason For Loan:</td>
													<td style="padding: 10px !important; text-align: right !important">{{$breakdown->borrowReason}}</th>
												</tr>
											</tbody>
										</table>
										<div>
											<div style="background-color: #c7c7c7  !important; padding: 10px !important; display: inline-block; color: #1b13ba !important; font-weight: bold !Important">Summary Of Your Transaction</div>
										</div>
										<table id="walletinfotable" width="100%" class="table table-striped table-lightfont" style="clear: both !important">
											<thead>
												<tr style="background-color: #000 !important; color: #fff !important;">
													<th width="70%" style="padding: 5px !Important; text-align: left !important">Item</th>
													<th style="padding: 5px !Important; text-align: right !important">Amount ({{array_keys($currencies)[$transaction->probasePayCurrency]}})</th>
												</tr>
											</thead>
											<tbody>
												<?php	
													$tx = $transaction;
												?>
												<tr style="" >
													<td style="border-bottom: #c7c7c7 1px solid !important; padding: 5px !Important;">Airtime Purchase (Direct Top-Up)</td>
													<td style="border-bottom: #c7c7c7 1px solid !important; padding: 5px !Important; text-align: right !important">{{number_format($transaction->amount, 2, '.', ',')}}</td>
												</tr>
												<tr style="" >
													<td style="border-bottom: #c7c7c7 1px solid !important; padding: 5px !Important;">Charge</td>
													<td style="border-bottom: #c7c7c7 1px solid !important; padding: 5px !Important; text-align: right !important">
														{{number_format(ifnullzero($transaction->fixedCharge)+ifnullzero($transaction->transactionCharge), 2, '.', ',')}}
													</td>
												</tr>

												<tr style="background-color: #c7c7c7  !important; ">
													<td style="border-bottom: #c7c7c7 1px solid !important; padding: 5px !Important;"><strong>Total Debited</strong></th>
													<td style="border-bottom: #c7c7c7 1px solid !important; padding: 5px !Important; text-align: right !important"><strong>{{number_format(ifnullzero($transaction->amount)+ifnullzero($transaction->fixedCharge)+ifnullzero($transaction->transactionCharge), 2, '.', ',')}}</strong></th>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div style="clear: both !important" class="col-md-12">&nbsp;</div>
								<div style="clear: both !important" class="col-md-12">&nbsp;</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>


<!-- Info boxes -->