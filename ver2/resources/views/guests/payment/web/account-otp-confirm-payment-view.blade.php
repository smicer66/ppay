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


<div class="loading hidden">
	<div class='uil-ring-css' style='transform:scale(0.79);'>
		<div></div>
	</div>
</div>
<div class="holder" class="reserve-box mt-30">
    <div class="reserve-box mt-30" style="border: 0px double #EBE9E8;">
        <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="text-transform: uppercase;
            background: #DB3944;
            color: #FFF;
            line-height: 1;
            margin: 0;
            margin-top: -3px;
            padding: 15px 23px; ">
            <div style="float: left !important; " class="col col-md-5 col-sm-5 col-lg-5 col-xs-5"><h5 style="padding: 0px !Important; margin-top: 0px !important; float: left !important">Bevura</h5></div>
            <div style="float: right !important; text-align:right !Important; font-size: 11px !important" class="col col-md-7 col-sm-7 col-lg-7 col-xs-7"><small>{{strtoupper($orderRef)}}<br>Order Ref</small></div>

        </div>
        <div style="clear: both !important" class="container-fluid invoice-container" id="section-to-print">
            @include('partials.errors')
            <form action="/api/otp-to-confirm-pay" id="loginToPayOtpConfirmForm" method="post" enctype="application/x-www-form-urlencoded">

                <input type="hidden" name="data" value="{{$input}}">
                <input type="hidden" name="token" value="{{$token}}">
                <input type="hidden" name="orderId" value="{{$orderRef}}">
                <input type="hidden" name="transactionRef" value="{{$transactionRef}}">
                <div class="panel panel-default">


                    <div class="col-xs-12 col-sm-12" style="cursor: pointer">
                        <div style="text-align: right !Important; font-weight: bold !important">{{$currency}}{{number_format($totalAmount, 2, '.', ',')}}</div>

                        <div class="row gap-20">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group" style="padding-top:10px !important">
                                    <h4>Complete Your Payment</h4>
                                    <label style="font-weight: 100 !important">Provide the OTP sent to {{substr($otpRec, 0, 5)}}*****{{substr($otpRec, strlen($otpRec)-2, 2)}}</label>
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
                                        <a href="javascript:validateOTPToPay()" class="btn btn-primary mt-15 col-md-12 col-lg-12 col-sm-12 col-xs-12" name="submitButton" id="validateOTPToPay" value="Validate OTP To Pay">Complete Payment <i class="fa fas fa-angle-double-right"></i></a>
                                        <!--<input type="submit">-->
                                    </div>

                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-left: 0px !Important">
                                        <a class="" href="javascript:history.back(-3)">Cancel Payment</a>
                                    </div>


                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </form>

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




var loginToPayLinkCount = 0;
function validateOTPToPay()
{
    var form = $('#loginToPayOtpConfirmForm')[0];
    var formData = new FormData(form);
    var url = '/api/otp-to-confirm-account-pay';
    

			if(loginToPayLinkCount%2==0)
			{

				toggleLoading();
				loginToPayLinkCount++;
				$('#loginToPayLink').html("Confirming OTP. Please wait...");
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


						$('#loginToPayLink').html('Complete Payment <i class="fa fas fa-angle-double-right"></i>');
						loginToPayLinkCount++;
						if(data1.success===true)
						{

							//alert(33);
							if(data1.status==100)
							{
								//alert(34);
								var $modalDashboard = $('#ajaxPaymentDetailsListMenuModal');
								$(document).ready(function(){

									//$modal.modal('hide');
									//$modalForgotPassword.modal('hide');

									//$('body').modalmanager('loading');
									url = '/ajax-pay-from-logged-in-wallet-success.html/{{PAY_FROM_LOGGED_IN_WALLET_SUCCESS_PAGE}}/{{$input}}';
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
							else if(data1.status==-1)
							{
								toggleLoading();
								logoutUser('Your session has ended. Please log in to continue', window.location.href);
							}
							else
							{
								toastr.error(data1.message, '', toastroptions);
								toggleLoading();
								loginToPayLinkCount++;
								$('#loginToPayLink').html('Complete Payment <i class="fa fas fa-angle-double-right"></i>');

								var $modalDashboard = $('#ajaxPaymentDetailsListMenuModal');
								$(document).ready(function(){

									//$modal.modal('hide');
									//$modalForgotPassword.modal('hide');

									//$('body').modalmanager('loading');
									url = '/ajax-pay-from-logged-in-wallet-fail.html/{{PAY_FROM_LOGGED_IN_WALLET_FAIL_PAGE}}/{{$input}}';
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

							//toastr.success(data1.message);
						}
						else
						{
							//alert(37);
							toastr.error(data1.message, '', toastroptions);
							toggleLoading();
							loginToPayLinkCount++;
							$('#loginToPayLink').html('Complete Payment <i class="fa fas fa-angle-double-right"></i>');

						}
					
					},
					error: function (e) {
						toggleLoading();
						loginToPayLinkCount++;
						$('#loginToPayLink').html('Complete Payment <i class="fa fas fa-angle-double-right"></i>');
						toastr.error('We experienced an issue confirming your OTP. Please try again.', '', toastroptions);

					}
				});
			}
}
</script>
