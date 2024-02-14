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
            <div style="float: right !important; text-align:right !Important; font-size: 11px !important; padding-right: 0px !important;" class="col col-md-7 col-sm-7 col-lg-7 col-xs-7">&nbsp;</div>

        </div>
        <div style="clear: both !important; padding-left: 0px !important; padding-right: 0px !important" class="container-fluid invoice-container" id="section-to-print" style="margin-left:0px !important; margin-right: 0px !important;">            @include('partials.errors')

                <input type="hidden" name="data" value="{{$input}}">
				
				@if(!(!is_null($accounts) && isset($accounts) && $accounts!=null))
					<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="border-bottom: 1px solid #dedede">&nbsp;</div>
					<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding: 0px; padding-right: 10px; padding-top: 10px; ">
						<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
							Welcome to Bevura. You do not have a Bevura wallet or a payment card at the moment. <br>
							<a onclick="handleCreateBevuraAccountWallet()" style="cursor: pointer !important" class="btn btn-primary btn-sm mt-15" name="submitButton" id="" value=""><i class="fa fas fa-plus"></i> Please click here to create a wallet</a>

						</div>
						<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding-top: 10px !Important; border-bottom: 0px solid #dedede">
							<a class=" mt-15" href="javascript:history.back(-3)">Cancel</a>
						</div>
	

					</div>
				@else
				
					<div class="panel panel-default" style="padding-left:0px !important; padding-right: 0px !important">
						<div class="col-xs-12 col-sm-12" style="cursor: pointer; padding-left:0px !important; padding-right: 0px !important">
							<div style="float: left !important; " class="col col-md-5 col-sm-5 col-lg-5 col-xs-5">&nbsp;<?php echo ""; ?></div>

				                     <div class="pull-right col col-md-7 col-sm-7 col-lg-7 col-xs-7" style="padding-top: 5px !important; text-align: right !Important; font-weight: bold !important">&nbsp;</div>
							
								@if(($cards!=null && sizeof($cards)>0))
									<div class="col-xs-12 col-sm-12" style="cursor: pointer; font-size: 18px !important">
										Choose card(s) and or wallet(s) to tokenize<br>
										<div style="cursor: pointer; font-size: 14px !important; background-color: #d9edf7 !important; padding: 4px !important; border-radius: 10px">Once you tokenize your card or wallet for a merchant, you won't need to login to pay</div>
									</div>
								@endif
							

							<div class="row gap-20">
								<div class="col-xs-12 col-sm-12 col-md-12">

									<div class="form-group" style="padding-top:10px !important">


										@if(($accounts!=null && sizeof($accounts )>0))
											@foreach($accounts as $account)
										<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding-bottom: 0px; padding-top: 10px; ">
											<div class="col-xs-4 col-sm-4 col-lg-4 col-md-4">
												<img src="/img/bevura_logo.png" class="img-responsive" style="background-color: #224fb4; max-width: 100%; height: auto; display: block; width: 60% !important; padding: 10px !important;">
												<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding: 0px !Important; padding-top: 5px !important; ">
													<button data-xy="{{\Crypt::encrypt($account->accountIdentifier)}}~~~WALLET" class="cardsBv btn btn-sm" data-toggle="button" aria-pressed="false" onclick="handleWalletSelect(this)" autocomplete="off">Select Wallet</button>
													  	

												</div>
											</div>

											<div class="col-xs-8 col-sm-8 col-lg-8 col-md-8" style="text-align: right !important">
												{{$customerName}}<br>
												{{$account->accountIdentifier}}<br>
											</div>
											
											<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="border-bottom: 1px solid #dedede; padding-top:0px !important; padding-right: 0px !important; height: 5px">&nbsp;</div>
											
										</div>
											@endforeach
										@endif

										@if(($cards!=null && sizeof($cards)>0))
											@foreach($cards as $card)
												<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding-bottom: 0px; padding-top: 10px;">
													<div class="col-xs-4 col-sm-4 col-lg-4 col-md-4">
														<img src="/img/mastercard_logo.png" class="img-responsive" style="max-width: 100%; height: auto; display: block; width: 60% !important; padding: 0px !important;">
														<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding: 0px !Important; padding-top: 5px !important; ">
															<button data-xy="{{\Crypt::encrypt(
																$card->serialNo)}}~~~CARD" onclick="handleWalletSelect(this)" class="cardsBv btn btn-sm" data-toggle="button" aria-pressed="false" autocomplete="off">Select Card</button>
																

														</div>
													</div>
													<div class="col-xs-8 col-sm-8 col-lg-8 col-md-8" style="text-align: right !important">
														{{$card->nameOnCard}}<br>
														{{substr($card->serialNo, 0, 4)}} *** *** {{substr($card->serialNo, strlen($card->serialNo)-4)}}<br>

													</div>

													<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="border-bottom: 1px solid #dedede; padding-top:0px !important; padding-right: 0px !important; height: 5px">&nbsp;</div>
												</div>
											@endforeach
											<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding-top: 10px !Important; border-bottom: 0px solid #dedede">
												<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
													<a class="" href="javascript:history.back(-3)">Cancel</a>
												</div>
											</div>
										@else
											
											<!--<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="border-bottom: 1px solid #dedede">&nbsp;</div>
											<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding: 0px; padding-right: 10px; padding-top: 10px; ">
												<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
													You do not have any cards to pay from.
													<br><a href="/ajax-pay-from-logged-in-new-wallet-step-two.html/101/{{$input}}/" class="btn btn-primary btn-sm mt-15" name="submitButton" id="" value=""><i class="fa fas fa-plus"></i> Add A Card To Your Profile</a>

												</div>
												<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding-top: 10px !Important; border-bottom: 0px solid #dedede">
													<a class=" mt-15" href="javascript:history.back(-3)">Cancel</a>
												</div>


											</div>-->
										@endif
										
										@if(($accounts!=null && sizeof($accounts )>0) || ($cards!=null && sizeof($cards)>0))
											<div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-top: 10px !Important; padding-left: 0px !Important; padding-right: 0px !Important">
												<form id="tokenizeWalletForm" method="post">
													<input type="hidden" name="selected" value="" id="selected">
													<input type="hidden" name="data" value="{{$input}}">
												</form>
												<button onclick="handleProcessTokenize()" disabled class="btn btn-primary mt-15 col-md-12 col-lg-12 col-sm-12 col-xs-12" name="submitButton" id="continueWalletPaymentStepOne" value="Validate OTP To Pay">Tokenize <i class="fa fas fa-angle-double-right"></i></button>
											</div>
										@endif
									


									</div>

								</div>
							</div>

						</div>

					</div>
				@endif

    </div>
</div>



<!--
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/jquery-2.2.4.min.js"></script>
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
var totalSelected = [];


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





var loginToPayLinkCount = 0;
function handleProcessTokenize()
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
            selection.push($(obj).data("xy"));
	}
    });
    $('#selected').val(selection.join("|||"));
	console.log(selection.join("|||"));
    var form = $('#tokenizeWalletForm')[0];
    var formData = new FormData(form);
    var url = '/api/tokenize';
	
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

				$('#loginToPayLink').html('Tokenize <i class="fa fas fa-angle-double-right"></i>');
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
							
							url = '/ajax-tokenize-otp.html/{{TOKENIZE_OTP}}/{{$input}}/' + data1.otp_txn_ref + '/' + data1.otp_receipient;

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
						toastr.error(data1.message, '', toastroptions );
						//console.log(window.location);
						//toastr.info(data1.message, '', toastroptions );
						var $modalDashboard = $('#ajaxPaymentDetailsListMenuModal');
						$(document).ready(function(){

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
						});
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





function handleWalletSelect(bthis)
{
    	var tempTotalSelected = [];
	totalSelected = [];

   	if(bthis.classList.contains("btn-info"))
    	{
        	console.log("btn-info exists");
        	$(bthis).removeClass("btn-info");
    	}
   	else
    	{
		$(bthis).addClass("btn-info");
        
    	}
    	var $cardsBvList = $('.cardsBv');
	$cardsBvList.each(function(i, obj) {
            	if(obj.classList.contains("btn-info"))
		{
                	totalSelected.push($(obj).data("xy"));
		}
       });

    
    console.log([totalSelected, totalSelected.length]);

    if(totalSelected.length > 0)
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
