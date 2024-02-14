<!----><!doctype html>
<html lang="en" style="background: rgba(255, 255, 255, 1) !important;" >

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ProbasePay</title>
	<meta name="description" content="HTML Responsive Template for Restaurant Finder Based on Twitter Bootstrap 3.x.x" />
	<meta name="keywords" content="restaurant, dinner, lunch, eat, food, rice, dine, menu, dining, meal, cafe, breakfast" />
	<meta name="author" content="crenoveative">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/v2/images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/v2/images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/v2/images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="/v2/images/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="/v2/images/ico/favicon.png">
	<link rel="stylesheet" type="text/css" href="/v2/bootstrap/css/bootstrap.min.css" media="screen">
	<link href="/v2/css/animate.css" rel="stylesheet">
	<link href="/v2/css/main.css" rel="stylesheet">
	<link href="/v2/css/component.css" rel="stylesheet">
	<link href="/v2/css/style.css" rel="stylesheet">
	<link href="/v2/css/your-style.css" rel="stylesheet">
	<link href="/v2/css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<link href="/v2/css/loading_busy.css" rel="stylesheet">

<style>

.forum {
	border: 1px solid #eee;
	margin: 0;
	padding: 0;
	-webkit-transition: 0.3s;
	transition: 0.3s;
}

.forum:hover {
	box-shadow: 0 8px 12px 0 rgba(0,0,0,0.2)
}


.holder{
    /*width: calc((100vw - 60%)/2) !important;
    margin-left: calc((100vw - 30%)/2) !important;*/
}


</style>
</head>
<!--<div class="pull-right" style="padding-right: 30px; padding-top:5px;">
	<a href="javascript:closeModals()"><i class="fa fa-close"></i></a>
</div>-->

<div class="loading hidden">
	<div class='uil-ring-css' style='transform:scale(0.79);'>
		<div></div>
	</div>
</div>
<div class="holder" style="border: 0px solid #000">
    <div class="reserve-box mt-30" style="position: relative !important; border: 0px double #EBE9E8; margin-bottom: 0px !important">
        <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="text-transform: uppercase;
            background: #DB3944;
            color: #FFF;
            line-height: 1;
            margin: 0;
            margin-top: -3px;
            padding: 15px 23px; ">
            <div style="float: left !important; padding-left: 0px !important;" class="col col-md-5 col-sm-5 col-lg-5 col-xs-5"><h5 style="padding: 0px !Important; margin-top: 0px !important; float: left !important">Bevura</h5></div>
            <div style="float: right !important; text-align:right !Important; font-size: 11px !important; padding-right: 0px !important;" class="col col-md-7 col-sm-7 col-lg-7 col-xs-7"><small>{{strtoupper($orderId)}}<br>Order Ref</small></div>

        </div>
        <div style="clear: both !important; padding-left: 0px !important; padding-right: 0px !important" class="container-fluid invoice-container" id="section-to-print" style="margin-left:0px !important; margin-right: 0px !important;">            @include('partials.errors')
				
                <input type="hidden" name="data" value="{{$input}}">
				
				@if(is_null($accountBalance))
					<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="border-bottom: 1px solid #dedede">&nbsp;</div>
					<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding: 0px; padding-right: 10px; padding-top: 10px; ">
						<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
							Welcome to Bevura. You do not have a Bevura wallet at the moment. <br>
							<a onclick="handleCreateBevuraAccountWallet()" style="cursor: pointer !important" class="btn btn-primary btn-sm mt-15" name="submitButton" id="" value=""><i class="fa fas fa-plus"></i> Please click here to create one</a>

						</div>
						<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding-top: 10px !Important; border-bottom: 0px solid #dedede">
							<a class=" mt-15" href="javascript:history.back(-3)">Cancel Payment</a>
						</div>
	

					</div>
				@else
				
					<div class="panel panel-default" style="padding-left:0px !important; padding-right: 0px !important">
						<div class="col-xs-12 col-sm-12" style="cursor: pointer; padding-left:0px !important; padding-right: 0px !important">
							<div style="float: left !important; " class="col col-md-5 col-sm-5 col-lg-5 col-xs-5">&nbsp;<?php echo ""; ?></div>

				                     <div class="pull-right col col-md-7 col-sm-7 col-lg-7 col-xs-7" style="padding-top: 5px !important; text-align: right !Important; font-weight: bold !important">Your Bill: {{$currency}}{{number_format($totalAmount, 2, '.', ',')}}</div>
							@if(isset($accountBalance) && isset($accountBalance->availableBalance) && $accountBalance->availableBalance==0.00)

							@else
								@if(($cards!=null && sizeof($cards)>0))
									<div class="col-xs-12 col-sm-12" style="cursor: pointer; font-size: 18px !important">
										Choose a card or your wallet to pay from<br>
										<div style="cursor: pointer; font-size: 14px !important; background-color: #d9edf7 !important; padding: 4px !important; border-radius: 10px">Paying from your Bevura wallet is convenient and easy. We will send you a one-time payment to confirm you initiated this payment</div>
									</div>
								@else
									<div class="col-xs-12 col-sm-12" style="padding-left: 5px !Important; cursor: pointer; font-size: 18px !important">
										You can pay from your wallet<br>
										<div style="cursor: pointer; font-size: 14px !important">Paying from your Bevura wallet is convenient and easy. We will send you a one-time payment to confirm you initiated this payment</div>
									</div>
								@endif
							@endif

							<div class="row gap-20">
								<div class="col-xs-12 col-sm-12 col-md-12">

									<div class="form-group" style="padding-top:10px !important">
									@if(isset($accountBalance) && isset($accountBalance->availableBalance) && $accountBalance->availableBalance==0.00)
										<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="border-bottom: 1px solid #dedede">&nbsp;</div>
										<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding: 0px; padding-right: 10px; padding-top: 10px; ">
											<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
												You do not have any funds in your wallet. Fund your wallet to start transacting
												<br>
												<strong>Wallet Number:</strong> {{$accountBalance->account->accountIdentifier}}<br><br>
												<div style="background-color:#eee !important; border-radius: 10px; padding: 10px  ">
													<strong>How to Fund Your Wallet</strong><br>
													Dial <strong>*345#</strong> on your mobile phone to access and fund your wallet
												</div>


											</div>
											<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding-top: 10px !Important; border-bottom: 0px solid #dedede">
												<a class=" mt-15" href="javascript:history.back(-3)">Cancel Payment</a>
											</div>


										</div>
									@else
										<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding-bottom: 0px; padding-top: 10px; ">
											<div class="col-xs-4 col-sm-4 col-lg-4 col-md-4">
												<img src="/img/bevura_logo.png" class="img-responsive" style="background-color: #224fb4; max-width: 100%;, height: auto; and display: block; width: 60% !important; padding: 0px !important;">
												<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding: 0px !Important; padding-top: 5px !important; ">
													<button data-id="{{\Crypt::encrypt(
																$accountBalance->account->accountIdentifier."~~~".
																""."~~~".
																""."~~~".
																""."~~~".
																$loginData['firstName']."~~~".
																$loginData['lastName']."~~~".
																""."~~~".
																$loginData['mobileno']."~~~".
																(isset($loginData['email']) ? $loginData['email'] : "")."~~~".
																""."~~~".
																""."~~~".
																""."~~~")}}" data-xy={{$accountBalance->availableBalance}} onclick="handleWalletSelect(this, {{$accountBalance->availableBalance}}, {{$totalAmount}}, 0)" class="cardsBv btn btn-sm" data-toggle="button" aria-pressed="false" autocomplete="off">Use Wallet</button>
														

												</div>
											</div>
											<div class="col-xs-8 col-sm-8 col-lg-8 col-md-8">
												{{$accountBalance->account->customerFullName}}<br>
												{{$accountBalance->account->accountIdentifier}}<br>
												<strong style="font-weight: bold !important">Available Balance: <small>{{$currency}}</small>{{number_format($accountBalance->availableBalance, 2, '.', ',')}}</strong>

											</div>
											
											<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="border-bottom: 1px solid #dedede; padding-top:0px !important; padding-right: 0px !important; height: 5px">&nbsp;</div>
											
										</div>
										@if(($cards!=null && sizeof($cards)>0))
											@foreach($cards as $card)
												<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding-bottom: 0px; padding-top: 10px;">
													<div class="col-xs-4 col-sm-4 col-lg-4 col-md-4">
														<img src="/img/mastercard_logo.png" class="img-responsive" style="max-width: 100%;, height: auto; and display: block; width: 60% !important; padding: 0px !important;">
														<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding: 0px !Important; padding-top: 5px !important; ">
															<button data-id="{{\Crypt::encrypt(
																$card->serialNo."~~~".
																$card->trackingNumber."~~~".
																$card->cvv."~~~".
																$card->expiryDate."~~~".
																$loginData['firstName']."~~~".
																$loginData['lastName']."~~~".
																""."~~~".
																$loginData['mobileno']."~~~".
																(isset($loginData['email']) ? $loginData['email'] : "")."~~~".
																""."~~~".
																""."~~~".
																""."~~~")}}" data-xy={{$card->cardBalance}} onclick="handleCardSelect(this, {{$card->cardBalance}}, {{$totalAmount}}, 1)" class="cardsBv btn btn-sm" data-toggle="button" aria-pressed="false" autocomplete="off">Use Card</button>
																<!--<small style=""><a href="/ajax-payment-fund-card-from-wallet.html/011/{{$input}}/{{$orderId}}/{{$card->serialNo}}">Fund Card</a></small>-->

														</div>
													</div>
													<div class="col-xs-8 col-sm-8 col-lg-8 col-md-8">
														{{$card->nameOnCard}}<br>
														{{str_split($card->pan, 4)[0]}} *** *** {{str_split($card->pan, 4)[3]}}<br>
														<strong style="font-weight: bold !important">Balance: <small>{{$currency}}</small>{{number_format($card->cardBalance, 2, '.', ',')}}</strong>

													</div>

													<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="border-bottom: 1px solid #dedede; padding-top:0px !important; padding-right: 0px !important; height: 5px">&nbsp;</div>
												</div>
											@endforeach
											<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding-top: 10px !Important; border-bottom: 0px solid #dedede">
												<div class="col-xs-4 col-sm-4 col-lg-4 col-md-4">
													<a class="" href="javascript:history.back(-3)">Cancel Payment</a>
												</div>
											</div>
										@else
											
											<!--<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="border-bottom: 1px solid #dedede">&nbsp;</div>-->
											<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding: 0px; padding-right: 10px; padding-top: 10px; ">
												<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
													You do not have any cards to pay from.
													<br><a href="/ajax-pay-from-logged-in-new-wallet-step-two.html/101/{{$input}}/{{$orderId}}" class="btn btn-primary btn-sm mt-15" name="submitButton" id="" value=""><i class="fa fas fa-plus"></i> Add A Card To Your Profile</a>

												</div>
												<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding-top: 10px !Important; border-bottom: 0px solid #dedede">
													<a class=" mt-15" href="javascript:history.back(-3)">Cancel Payment</a>
												</div>


											</div>
										@endif
										
										@if(($cards!=null && sizeof($cards)>0) || (isset($accountBalance) && isset($accountBalance->availableBalance) && $accountBalance->availableBalance>0.00))
											<div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-top: 10px !Important; padding-left: 0px !Important; padding-right: 0px !Important">
												<form id="processPaymentFromWalletForm" method="post">
													<input type="hidden" name="selectedCards" value="" id="selectedCards">
													<input type="hidden" name="selectedCardType" value="" id="selectedCardType">
													<input type="hidden" name="data" value="{{$input}}">
												</form>
												<button onclick="handleProcessPay()" disabled class="btn btn-primary mt-15 col-md-12 col-lg-12 col-sm-12 col-xs-12" name="submitButton" id="continueWalletPaymentStepOne" value="Validate OTP To Pay">Continue <i class="fa fas fa-angle-double-right"></i></button>
											</div>
										@endif
									@endif


									</div>

								</div>
							</div>

						</div>

					</div>
				@endif

    </div>
</div>




<!--<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/jquery-migrate-1.4.1.min.js"></script>
<script type="text/javascript" src="/v2/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/SmoothScroll.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/jquery.waypoints.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/jquery.slicknav.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/spin.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/jquery.introLoader.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/fancySelect.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/bootstrap-rating.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/select2.full.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/slick.min.js"></script>-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/jquery.placeholder.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/ion.rangeSlider.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/readmore.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/bootstrap-modalmanager.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/instagram.min.js"></script>
<!--<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/bootstrap3-wysihtml5.min.js"></script>-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/customs.js?x=1"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/customs-reservation.js"></script>
<script type="text/javascript" src="/js/action.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script><!-- -->
<script>


var testMode =  0;



var loadingOverlay = document.querySelector('.loading');

function toggleLoading(){
  document.activeElement.blur();
  
  if (loadingOverlay.classList.contains('hidden')){
    loadingOverlay.classList.remove('hidden');
  } else {
    loadingOverlay.classList.add('hidden');
  }
}

var toastroptions = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-center",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}


function handleCreateBevuraAccountWallet()
{
	url="/ajax-pay-from-logged-in-new-wallet-step-two.html/101/{{$input}}/{{$orderId}}";
	var $modalDashboard = $('#ajaxPaymentOptionDetailsListMenuModal');//ajaxPaymentDetailsListMenuModal
	setTimeout(function(){
		console.log(url);
		$modalDashboard.load(url, '', function(){
			$modalDashboard.modal();
			handleNotifications();
		});
	}, 1000);
}



var loginToPayLinkCount = 0;
function handleProcessPay()
{
    /*var $cardsBvList = $('.cardsBv');
    var selection =[];
    $cardsBvList.each(function(i, obj) {
        if(obj.classList.contains("btn-info"))
            selection.push($(obj).data("id"));
    });

    if(selection.length > 0)
    {
        $('#selectedCards').val(selection.join("|||"));
        $('#processPaymentFromWalletForm').attr("action", "/initiate-wallet-payment")
        $('#processPaymentFromWalletForm').submit();
    }*/


    var $cardsBvList = $('.cardsBv');
    var selection =[];
    $cardsBvList.each(function(i, obj) {
        if(obj.classList.contains("btn-info"))
		{
            selection.push($(obj).data("id"));
		}
    });
    $('#selectedCards').val(selection.join("|||"));
    var form = $('#processPaymentFromWalletForm')[0];
    var formData = new FormData(form);
    var url = '';
	
	if($('#selectedCardType').val()=='Wallet')
		url = '/initiate-account-payment';
	else if($('#selectedCardType').val()=='Card')
		url = '/initiate-wallet-payment';
	
	if(loginToPayLinkCount%2==0)
	{
		toggleLoading();
		loginToPayLinkCount++;
		$('#loginToPayLink').html("Logging In. Please wait...");
    		$.ajax({
			type: "POST",
			url: (url),
			data: (formData),
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);

				$('#loginToPayLink').html('Proceed <i class="fa fas fa-angle-double-right"></i>');
				loginToPayLinkCount++;
				if(data1.success===true)
				{
					//alert(33);
					if(data1.status==100)
					{
						//toastr.success(data1.message, '', toastroptions );
						var $modalDashboard = $('#ajaxPaymentOptionDetailsListMenuModal');
						$(document).ready(function(){

							//$modal.modal('hide');
							//$modalForgotPassword.modal('hide');

							//$('body').modalmanager('loading');

							//window.location = '/ajax-pay-from-logged-in-wallet.html/{{PAY_FROM_LOGGED_IN_WALLET}}/{{$input}}/' + data1.txn_ref;
							
							if($('#selectedCardType').val()=='Wallet')
								url = '/ajax-pay-from-logged-in-wallet-otp.html/{{PAY_FROM_LOGGED_IN_ACCOUNT_OTP}}/{{$input}}/' + data1.txn_ref + '/' + data1.otp_txn_ref + '/' + data1.otp_receipient;
							else if($('#selectedCardType').val()=='Card')
								url = '/ajax-pay-from-logged-in-wallet-otp.html/{{PAY_FROM_LOGGED_IN_WALLET_OTP}}/{{$input}}/' + data1.txn_ref + '/' + data1.otp_txn_ref + '/' + data1.otp_receipient;

	console.log("url....");
	console.log(url);	
							if(testMode==0)
							{
								setTimeout(function(){
									//url = '/ajax-pay-from-logged-in-wallet.html/{{PAY_FROM_LOGGED_IN_WALLET}}/{{$input}}/' + data1.txn_ref;
									
									console.log(url);
									 $modalDashboard.load(url, '', function(){
										$modalDashboard.modal();
										//document.getElementById("loginToPayOtp1").focus();
										handleNotifications();
									});
								}, 1000);
							}
							else
							{
								window.location = url;
							}
						});
					}
					else if(data1.status==-1)
					{
						toggleLoading();

						logoutUser('Your session has ended. Please log in to continue', window.location.href);
						
					}
					else
					{
						toggleLoading();
						toastr.error(data1.message, '', toastroptions );
						//console.log(window.location);
						//toastr.info(data1.message, '', toastroptions );
						var $modalDashboard = $('#ajaxPaymentDetailsListMenuModal');
						/*$(document).ready(function(){

							//$modal.modal('hide');
							//$modalForgotPassword.modal('hide');

							//$('body').modalmanager('loading');
							url = '/ajax-payment-details.html/{{PAYMENT_DETAILS_LISTING}}/{{$input}}';
							if(testMode==0)
							{
								setTimeout(function(){
									
									console.log(url);
									 $modalDashboard.load(url, '', function(){
										$modalDashboard.modal();
										handleNotifications();
									});
								}, 1000);
							}
							else
							{
								window.location = url;
							}
						});*/
					}

					//toastr.success(data1.message, '', toastroptions );
				}
				else
				{

					toggleLoading();
					toastr.error(data1.message, '', toastroptions );
					$('#dismissBtn').click();
					$('#new_card_modal').show();
				}
			},
			error: function (e) {
				
				toggleLoading();
				$('#loginToPayLink').html('Proceed <i class="fa fas fa-angle-double-right"></i>');
				loginToPayLinkCount++;
				toastr.error('We experienced an issue generating your dashboard. Please try again.', '', toastroptions );
			}
		});
	}
}


function handleCardSelect(bthis, amount, bill, tp)
{
    var totalSelected = 0.00;
    var $cardsBvList = $('.cardsBv');
	$('#selectedCardType').val('Card')
    if(bthis.classList.contains("btn-info"))
    {
        console.log("btn-info exists");
        $(bthis).removeClass("btn-info");
    }
    else
    {
        $cardsBvList.each(function(i, obj) {
            if(obj.classList.contains("btn-info"))
                totalSelected = totalSelected + parseFloat($(obj).data("xy"));
        });

        console.log(totalSelected);
        if(totalSelected>=bill)
        {
        }
        else
        {
            $(bthis).addClass("btn-info");
        }
    }

    totalSelected = 0.00;
    $cardsBvList.each(function(i, obj) {
        if(obj.classList.contains("btn-info"))
            totalSelected = totalSelected + parseFloat($(obj).data("xy"));
    });

    console.log([totalSelected, bill]);

    if(totalSelected>=bill)
    {
        $('#continueWalletPaymentStepOne').removeAttr("disabled");
    }
    else
    {
        $('#continueWalletPaymentStepOne').attr("disabled", true);
    }
	
	
}



function handleWalletSelect(bthis, amount, bill, tp)
{
    var totalSelected = 0.00;
    var $cardsBvList = $('.cardsBv');
	$('#selectedCardType').val('Wallet')
    if(bthis.classList.contains("btn-info"))
    {
        console.log("btn-info exists");
        $(bthis).removeClass("btn-info");
    }
    else
    {
        $cardsBvList.each(function(i, obj) {
            if(obj.classList.contains("btn-info"))
                totalSelected = totalSelected + parseFloat($(obj).data("xy"));
        });

        console.log(totalSelected);
        if(totalSelected>=bill)
        {
        }
        else
        {
            $(bthis).addClass("btn-info");
        }
    }

    totalSelected = 0.00;
    $cardsBvList.each(function(i, obj) {
        if(obj.classList.contains("btn-info"))
            totalSelected = totalSelected + parseFloat($(obj).data("xy"));
    });

    console.log([totalSelected, bill]);

    if(totalSelected>=bill)
    {
        $('#continueWalletPaymentStepOne').removeAttr("disabled");
    }
    else
    {
        $('#continueWalletPaymentStepOne').attr("disabled", true);
    }



}

jQuery('#loginToPayOtp1').keyup(function () {
    var inputVal = $(this).val();
    //var characterReg = /^[0-9]{5}$/;
    console.log(inputVal);
    if (inputVal.length>0) {
        document.getElementById("loginToPayOtp2").focus();
    }
});
jQuery('#loginToPayOtp2').keyup(function () {
    var inputVal = $(this).val();
    //var characterReg = /^[0-9]{5}$/;
    console.log(inputVal);
    if (inputVal.length>0) {
        document.getElementById("loginToPayOtp3").focus();
    }
});
jQuery('#loginToPayOtp3').keyup(function () {
    var inputVal = $(this).val();
    //var characterReg = /^[0-9]{5}$/;
    console.log(inputVal);
    if (inputVal.length>0) {
        document.getElementById("loginToPayOtp4").focus();
    }
});
jQuery('#loginToPayOtp4').keyup(function () {
    var inputVal = $(this).val();
    //var characterReg = /^[0-9]{5}$/;
    console.log(inputVal);
    if (inputVal.length>0) {
        validateOTPToPay();
    }
});



function validateOTPToPay()
{
    var form = $('#loginToPayOtpForm')[0];
    var formData = new FormData(form);
    var url = '/api/otp-login-to-pay';
    $.ajax({
        type: "POST",
        url: (url),
        data: (formData),
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        success: function handleSuccess(data1){
            console.log(data1);
            if(data1.success===true)
            {
                //alert(33);
                if(data1.status==100)
                {
                    //toastr.success(data1.message, '', toastroptions );
                    var $modalDashboard = $('#ajaxPaymentDetailsListMenuModal');
                    $(document).ready(function(){

                        //$modal.modal('hide');
                        //$modalForgotPassword.modal('hide');

                        //$('body').modalmanager('loading');

                        setTimeout(function(){
                            url = '/ajax-pay-from-logged-in-wallet.html/{{PAY_FROM_LOGGED_IN_WALLET}}/{{$input}}/' + data1.txn_ref;
                            console.log(url);
                             $modalDashboard.load(url, '', function(){
                                $modalDashboard.modal();
                                document.getElementById("loginToPayOtp1").focus();
                                handleNotifications();
                            });
                        }, 1000);
                    });
                }
                else if(data1.status==-1)
                {
                    console.log(window.location);
                    toastr.info('Your session has ended. Please login again to continue', '', toastroptions );
                    var $modalDashboard = $('#ajaxPaymentDetailsListMenuModal');
                    $(document).ready(function(){

                        //$modal.modal('hide');
                        //$modalForgotPassword.modal('hide');

                        //$('body').modalmanager('loading');

                        setTimeout(function(){
                            url = '/ajax-payment-details.html/{{PAYMENT_DETAILS_LISTING}}/{{$input}}';
                            console.log(url);
                             $modalDashboard.load(url, '', function(){
                                $modalDashboard.modal();
                                handleNotifications();
                            });
                        }, 1000);
                    });
                }
                else
                {
                    toastr.error(data1.message, '', toastroptions );

                }

                //toastr.success(data1.message, '', toastroptions );
            }
            else
            {
                toastr.error(data1.message, '', toastroptions );
                $('#dismissBtn').click();
                $('#new_card_modal').show();
            }
        },
        error: function (e) {
            toastr.error('We experienced an issue updating your merchant profile. Please try again.', '', toastroptions );
        }
    });
}



</script>
