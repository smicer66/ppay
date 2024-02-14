<!doctype html>
<html lang="en" style="background: rgba(255, 255, 255, 1) !important;" >

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Title Of Site -->
	<title>ProbasePay</title>
	<meta name="description" content="HTML Responsive Template for Restaurant Finder Based on Twitter Bootstrap 3.x.x" />
	<meta name="keywords" content="restaurant, dinner, lunch, eat, food, rice, dine, menu, dining, meal, cafe, breakfast" />
	<meta name="author" content="crenoveative">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Fav and Touch Icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/v2/images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/v2/images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="/v2/images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="/v2/images/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="/v2/images/ico/favicon.png">

	<!-- CSS Plugins -->
	<link rel="stylesheet" type="text/css" href="/v2/bootstrap/css/bootstrap.min.css" media="screen">
	<link href="/v2/css/animate.css" rel="stylesheet">
	<link href="/v2/css/main.css" rel="stylesheet">
	<link href="/v2/css/component.css" rel="stylesheet">

	<!-- CSS Custom -->
	<link href="/v2/css/style.css" rel="stylesheet">

	<!-- For your own style -->
	<link href="/v2/css/your-style.css" rel="stylesheet">
	<link href="/v2/css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="/v2/https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="/v2/https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link href="/v2/css/loading_busy.css" rel="stylesheet">
</head>
<style>

.holder{
    /*width: calc((100vw - 60%)/2) !important;
    margin-left: calc((100vw - 30%)/2) !important;*/
}

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
</style>
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
            <div style="float: left !important; " class="col col-md-5 col-sm-5 col-lg-5 col-xs-5"><h5 style="padding: 0px !Important; margin-top: 0px !important; float: left !important">Bevura</h5></div>
            <div style="float: right !important; text-align:right !Important; font-size: 11px !important" class="col col-md-7 col-sm-7 col-lg-7 col-xs-7">
			@if($key!=TOKENIZE)
			<small>{{strtoupper($orderId)}}<br>Order Ref</small>
			@endif
		</div>

        </div>
        <div style="clear: both !important; padding-left: 0px !important; padding-right: 0px !important" class="container-fluid invoice-container" id="section-to-print" style="margin-left:0px !important; margin-right: 0px !important;">
            @include('partials.errors')
            <form action="/api/pin-login-to-pay" id="loginToPayOtpForm" method="post" enctype="application/x-www-form-urlencoded">

                <input type="hidden" name="data" value="{{$input}}">
                <input type="hidden" name="token" value="{{$token}}">
                <input type="hidden" name="orderId" value="{{$orderId}}">
                <div class="panel panel-default">


                    <div class="col-xs-12 col-sm-12" style="cursor: pointer">
                        <div  style="text-align: right !Important; font-weight: bold !important">
				@if($key!=TOKENIZE)
				{{$currency}}{{number_format($totalAmount, 2, '.', ',')}}
				@endif
			    </div>

                        <div class="row gap-20">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group" style="padding-top:10px !important">
                                    <label style="font-weight: 100 !important">Provide your Bevura 2FA-Secure Pin</label>
                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-right: 0px !Important; padding-left: 0px !Important">

                                        <div class="col col-md-3 col-sm-3 col-xs-3 col-lg-3" style="padding-left: 0px !Important">
                                            <input type="number" id="loginToPayOtp1" maxlength="1" size="1" name="otp1" value="" required class="form-control " style="
                                               opacity: .8;
                                               cursor: text;
                                               text-align: center;
                                               background-color: #fff !important;
                                               -webkit-transition: all ease-out 120ms;
                                               -o-transition: all ease-out 120ms;
                                               transition: all ease-out 120ms;
                                               z-index: 50000;"/>
                                        </div>
                                        <div class="col col-md-3 col-sm-3 col-xs-3 col-lg-3" style="padding-left: 0px !Important">
                                            <input type="number" id="loginToPayOtp2" maxlength="1" size="1" name="otp2" value="" required class="form-control " style="
                                               opacity: .8;
                                               cursor: text;
                                               text-align: center;
                                               background-color: #fff !important;
                                               -webkit-transition: all ease-out 120ms;
                                               -o-transition: all ease-out 120ms;
                                               transition: all ease-out 120ms;
                                               z-index: 50000;"/>
                                        </div>
                                        <div class="col col-md-3 col-sm-3 col-xs-3 col-lg-3" style="padding-left: 0px !Important">
                                            <input type="number" id="loginToPayOtp3" maxlength="1" size="1" name="otp3" value="" required class="form-control " style="
                                               opacity: .8;
                                               cursor: text;
                                               text-align: center;
                                               background-color: #fff !important;
                                               -webkit-transition: all ease-out 120ms;
                                               -o-transition: all ease-out 120ms;
                                               transition: all ease-out 120ms;
                                               z-index: 50000;"/>
                                        </div>
                                        <div class="col col-md-3 col-sm-3 col-xs-3 col-lg-3" style="padding-left: 0px !Important">
                                            <input type="number" id="loginToPayOtp4" maxlength="1" size="1" name="otp4" value="" required class="form-control " style="
                                               opacity: .8;
                                               cursor: text;
                                               text-align: center;
                                               background-color: #fff !important;
                                               -webkit-transition: all ease-out 120ms;
                                               -o-transition: all ease-out 120ms;
                                               transition: all ease-out 120ms;
                                               z-index: 50000;"/>
                                        </div>

                                    </div>


                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-top: 10px !Important; padding-left: 0px !Important; padding-right: 0px !Important">
						@if($key!=TOKENIZE)
                                        		<a href="javascript:validateOTPToPay()" class="btn btn-primary mt-15 col-md-12 col-lg-12 col-sm-12 col-xs-12" name="submitButton" id="validateOTPToPay" value="Validate OTP To Pay">Validate OTP To Pay <i class="fa fas fa-angle-double-right"></i></a>
						@else
							<a href="javascript:validateOTPToPay()" class="btn btn-primary mt-15 col-md-12 col-lg-12 col-sm-12 col-xs-12" name="submitButton" id="validateOTPToPay" value="Validate OTP To Pay">Validate One-Time Password <i class="fa fas fa-angle-double-right"></i></a>
						@endif
                                       		<!--<input type="submit">-->
                                    </div>

                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-left: 0px !Important; padding-top: 5px !important;">
						@if($key!=TOKENIZE)
                                        		<a class="" href="javascript:history.back(-3)">Cancel Payment</a>
						@else
                                        		<a class="" href="javascript:history.back(-3)">Cancel</a>
						@endif
                                    </div>


                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </form>

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
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>

var loadingOverlay = document.querySelector('.loading');

function toggleLoading(){
  document.activeElement.blur();
  
  if (loadingOverlay.classList.contains('hidden')){
    loadingOverlay.classList.remove('hidden');
  } else {
    loadingOverlay.classList.add('hidden');
  }
}


var testMode = 0;
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


loginToPayLinkCount = 0;
function validateOTPToPay()
{

	if(loginToPayLinkCount%2==0)
	{
		toggleLoading();
		var form = $('#loginToPayOtpForm')[0];
		var formData = new FormData(form);
		var url = '/api/pin-login-to-pay';
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
				//alert(4555);
				if(data1.success===true)
				{
					//alert(33);
					
					if(data1.status==100)
					{
						//toastr.success(data1.message);
						var $modalDashboard = $('#ajaxPaymentOptionDetailsListMenuModal');
						$(document).ready(function(){

							//$modal.modal('hide');
							//$modalForgotPassword.modal('hide');

							//$('body').modalmanager('loading');

							url = '';
					@if($key!=WALLET_ACCESS && $key!=TOKENIZE)
						url = '/ajax-pay-from-logged-in-wallet.html/{{PAY_FROM_LOGGED_IN_WALLET}}/{{$input}}/' + data1.txn_ref;
					@else
						@if($key==TOKENIZE)
							url = '/ajax-pay-from-logged-in-tokenize.html/{{TOKENIZE}}/{{$input}}/' + data1.txn_ref;
						@else
							//url = '/ajax-pay-from-logged-in-new-wallet-step-two.html/{{WALLET_ACCESS}}/{{$input}}/' + data1.txn_ref;
							url = '/ajax-pay-from-logged-in-wallet.html/{{PAY_FROM_LOGGED_IN_WALLET}}/{{$input}}/' + data1.txn_ref;
						@endif
					@endif


							if(testMode==0)
							{
								setTimeout(function(){
									console.log(url);
									$modalDashboard.load(url, '', function(){
										$modalDashboard.modal();
										//document.getElementById("loginToPayOtp1").focus();
										handleNotifications();
									}
								);
							}, 1000);
							}
							else
							{
								alert(455523235);
								window.location = url;
							}
						});
					}
					else if(data1.status==-1)
					{
						//console.log(window.location);
						toastr.error(data1.message);
						toggleLoading();
						logoutUserFrontView('Your session has ended. Please log in to continue', window.location.href, '{{$input}}');
						
					}
					else
					{
						//toastr.error(data1.message);
						//console.log(window.location);
						//toastr.info(data1.message);
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

					//toastr.success(data1.message);
				}
				else
				{
					toggleLoading();
					toastr.error(data1.message);
					$('#dismissBtn').click();
					$('#new_card_modal').show();
				}/**/
			},
			error: function (e) {
				toggleLoading();
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}
}
</script>
