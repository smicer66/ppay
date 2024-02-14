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

</head>
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



.toast-md .toast-wrapper.toast-bottom {
    -webkit-transform: translate3d(0, 100%, 0);
    transform: translate3d(0, 100%, 0);
    top: calc(33vw) !important;
    bottom: auto !important;
}
.toast-md .toast-wrapper {
    width: 90%;
    max-width: 700px !important;
    border-radius: 10px 10px 0px 10px !important;
}

#toast-container {
    position: absolute !important;
    z-index: 9999999999999 !important;
}

.toast-top-center {
    top: calc(10vh) !important;

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
            padding: 15px 23px; padding-right: 0px !important; ">

            <div style="float: left !important; padding-left: 0px !Important; " class="col col-md-5 col-sm-5 col-lg-5 col-xs-5"><h5 style="padding: 0px !Important; margin-top: 0px !important; float: left !important">Bevura</h5></div>

		@if($key!=WALLET_ACCESS && $key!=TOKENIZE)
            <div style="float: right !important; text-align:right !Important; font-size: 11px !important" class="col col-md-7 col-sm-7 col-lg-7 col-xs-7"><small>{{strtoupper($orderId)}}<br>Order Ref</small></div>
		@endif
        </div>
        <div style="clear: both !important; padding-left: 0px !important; padding-right: 0px !important" class="container-fluid invoice-container" id="section-to-print" style="margin-left:0px !important; margin-right: 0px !important;">
            @include('partials.errors')


            <form action="/api/login-to-pay" id="loginToPayForm" method="post" enctype="application/x-www-form-urlencoded">
                <input type="hidden" name="orderId" value="{{$orderId}}">
                <input type="hidden" name="data" value="{{$input}}">
                <div class="panel panel-default">
                    <?php $x=1; $total =0;?>
                    @for($f=0; $f<sizeof($itemAmounts); $f++)
                    <?php $total=$total + $itemAmounts[$f]; ?>
                    @endfor


                    <div class="col-xs-12 col-sm-12" style="cursor: pointer">
			@if($key!=WALLET_ACCESS && $key!=TOKENIZE)
			   <div style="float: left !important; " class="col col-md-5 col-sm-5 col-lg-5 col-xs-5">&nbsp;<?php echo ""; ?></div>

                        <div class="pull-right col col-md-7 col-sm-7 col-lg-7 col-xs-7" style="text-align: right !Important; font-weight: bold !important; padding-right: 0px !important;">{{$currency}}{{number_format($total, 2, '.', ',')}}</div>
			@endif

                        <div class="row gap-20">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group" style="padding-top:10px !important">
                                    <label style="font-weight: 100 !important">Your Mobile Number</label>
                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background-color: #EBEBEB; padding-right: 0px !Important">
                                        <div class="col col-md-2 col-sm-2 col-xs-2 col-lg-2" style="text-align: center !Important; padding-top: 5px !Important; padding-left: 0px !Important">
							<select name="countrycode" id="countrycode" style="border: 0px !important; background: transparent !important">
                                                 	<option value="260" class="login-option">+260</option>
                                            	</select>
					     </div>
                                        <div class="col col-md-10 col-sm-10 col-xs-10 col-lg-10" style="padding-right: 0px !Important"><!--961505858-->
                                        <input type="number" maxlength="9" size="9" id="username" name="username" value="" required class="form-control " style="
                                           opacity: .8;
                                           cursor: text;
                                           background-color: #fff !important;
                                           -webkit-transition: all ease-out 120ms;
                                           -o-transition: all ease-out 120ms;
                                           transition: all ease-out 120ms;
                                           z-index: 50000;" placeholder="example 967000000"/>
                                        </div>
                                    </div>



                                    <label style="font-weight: 100 !important">Your Password</label>
                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background-color: #EBEBEB; padding-right: 0px !Important">
                                        <div class="col col-md-2 col-sm-2 col-xs-2 col-lg-2" style="text-align: center !Important; padding-top: 5px !Important; padding-left: 0px !Important">
                                            <i class="fa fa-lock"></i>
                                        </div>
                                        <div class="col col-md-10 col-sm-10 col-xs-10 col-lg-10" style="padding-right: 0px !Important">
                                        <input type="password" name="password" id="password" required class="form-control " value="" style="
                                           opacity: .8;
                                           cursor: text;
                                           background-color: #fff !important;
                                           -webkit-transition: all ease-out 120ms;
                                           -o-transition: all ease-out 120ms;
                                           transition: all ease-out 120ms;
                                           z-index: 50000;" placeholder="Provide your valid password"/>
                                        </div>
                                    </div>


                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-top: 10px !Important; padding-left: 0px !Important">
                                        <a href="javascript:forgotPassword()" class="recoveryOption forgotPassword">Forgotten your password?</a>
                                    </div>
					@if($key==WALLET_ACCESS)
                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-top: 10px !Important; padding-left: 0px !Important; padding-right: 0px !Important">
                                        <a id="loginToPayLink" href="javascript:loginToPay()" class="btn btn-primary mt-15 col-md-12 col-lg-12 col-sm-12 col-xs-12" name="submitButton" value="Create Account">Proceed <i class="fa fas fa-angle-double-right"></i></a>
    <!--<input type="submit">-->
                                    </div>
					@elseif($key==TOKENIZE)
                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-top: 10px !Important; padding-left: 0px !Important; padding-right: 0px !Important">
                                        <a id="loginToPayLink" href="javascript:loginToPay()" class="btn btn-primary mt-15 col-md-12 col-lg-12 col-sm-12 col-xs-12" name="submitButton" value="Create Account">Proceed To Tokenize <i class="fa fas fa-angle-double-right"></i></a>
    <!--<input type="submit">-->
                                    </div>
					@else
                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-top: 10px !Important; padding-left: 0px !Important; padding-right: 0px !Important">
                                        <a id="loginToPayLink" href="javascript:loginToPay()" class="btn btn-primary mt-15 col-md-12 col-lg-12 col-sm-12 col-xs-12" name="submitButton" value="Create Account">Proceed To Pay <i class="fa fas fa-angle-double-right"></i></a>
    <!--<input type="submit">-->
                                    </div>
					@endif


					@if($key!=WALLET_ACCESS)
                                    <div class="" style="border-top: 1px solid #cbd2d6;
                                                                                  position: relative;
                                                                                  margin: 15px 0 10px;
                                                                                  margin-bottom: 0px !important;
                                                                                  text-align: center;"><span style="background-color: #fff;
                                                                                                                        padding: 0 .5em;
                                                                                                                        position: relative;
                                                                                                                        color: #6c7378;
                                                                                                                        top: -.9em;">or</span></div>

                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="top: -18px !important; padding-top: 0px !Important; padding-left: 0px !Important; padding-right: 0px !Important">
                                        <a style="cursor: pointer !important;" onclick="handleGoToNewWallet('{{$input}}', '{{$orderId}}')" class="btn btn-primary mt-15 col-md-12 col-lg-12 col-sm-12 col-xs-12" name="submitButton" value="Create Account">Get A New Bevura Wallet</a>
                                    </div>
						@if($key!=TOKENIZE)
                                    		<div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-left: 0px !Important">
                                        			<a class="" href="javascript:history.back(-1)">Cancel Payment</a>
                                   		</div>
						@endif

					@else
                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-left: 0px !Important">
                                        <a class="" href="javascript:history.back(-1)">Cancel</a>
                                    </div>
					@endif

                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </form>

		@if($key!=WALLET_ACCESS && $key!=TOKENIZE)
            <!--<div class="" style="clear: both !important; bottom: 0px; color: #ffcc00 !important; padding-right: 0px !important">
                <div class="col col-md-10 col-sm-10 col-xs-10" style="background-color:#000000 !important; padding: 10px !important" id="payoptiontitle">
                    <a href="/ajax-payment-details-cyb.html/0001/{{$input}}" style="color: #ffcc00 !important; "><i class="fa fa-angle-double-right" aria-hidden="true"></i> Pay using a VISA Debit/Credit Card</a>
                    <a onclick="loadCyberSourcePaymentDetails('2001', '{{$input}}')" style="cursor: pointer !important; color: #ffcc00 !important; "><i class="fa fa-angle-double-right" aria-hidden="true"></i> Pay using a VISA Debit/Credit Card</a>
                </div>
                <div class="payoptions col col-md-2 col-sm-2 col-xs-2" style="text-align: center !important; background-color:#ffcc00 !important; color: #000000 !important; padding: 10px !important; float: right !important;">
                    <a style="background-color: transparent !important; padding: 0px !important"><i class="fa fa-angle-double-right" aria-hidden="true" style="cursor: pointer !important; font-size: 16px !important"></i></a>
                </div>
            </div>-->
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
<!----><script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/ion.rangeSlider.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/readmore.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/bootstrap-modalmanager.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/bootstrap-modal.js"></script>
<!----><script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/instagram.min.js"></script>
<!--<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/bootstrap3-wysihtml5.min.js"></script>-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/customs.js?x=1"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/customs-reservation.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script><!-- -->




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
var testMode = 0;
var payoption = 0;
var payoptions = {};
var path = window.location.href;
path = path.split('/');
payoptions['Pay using a VISA Debit/Credit Card'] = '/ajax-payment-details-cyb.html/0001/' + path[path.length-1];
payoptions['Pay using Mobile Money'] = '/ajax-payment-details-mobile-money.html/0001/' + path[path.length-1];
payoptions['Pay using Online Banking'] = '/ajax-payment-details-online-banking.html/0001/' + path[path.length-1];
var payoptionskeys = Object.keys(payoptions);
$('.payoptions').on('click', function(){
    payoption++;
    payoptionmod = payoption%3;
    console.log(payoptionskeys);
    console.log(payoptionmod);
    var paykey = payoptionskeys[payoptionmod];
    console.log(paykey);
    var payval = payoptions[paykey];
    var hm = '<a href="'+payval+'" style="color: #ffcc00 !important; "><i class="fa fa-angle-double-right" aria-hidden="true"></i> ' + paykey + '</a>';
    $('#payoptiontitle').html(hm);
});

var loginToPayLinkCount = 0;
function handleGoToNewWallet(input, orderId)
{
	if(loginToPayLinkCount%2==0)
	{
		toggleLoading();
		loginToPayLinkCount++;
		var $modalDashboard = $('#ajaxPaymentOptionDetailsListMenuModal');

		testMode = 0;
		url = '/ajax-pay-from-logged-in-new-wallet.html/100/{{$input}}/{{$orderId}}';
		if(testMode==0)
		{
			loginToPayLinkCount++;
			setTimeout(function(){
				console.log(url);
				 $modalDashboard.load(url, '', function(){
					$modalDashboard.modal();
					if(document.getElementById("loginToPayOtp1"))
						document.getElementById("loginToPayOtp1").focus();
					handleNotifications();
				});
			}, 1000);
		}
		else
		{
			loginToPayLinkCount++;
			toggleLoading();
			window.location = url;
		}
	}

}


function loginToPay()
{

	if(loginToPayLinkCount%2==0)
	{
		toggleLoading();
		loginToPayLinkCount++;
		$('#loginToPayLink').html("Logging In. Please wait...");
    var form = $('#loginToPayForm')[0];
    var formData = new FormData(form);
	console.log(formData);
	formData['username'] = formData['countrycode'] + formData['username'];
    console.log(formData);
    var url = '/api/login-to-pay';
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


					@if($key==WALLET_ACCESS)
                                    $('#loginToPayLink').html('Proceed <i class="fa fas fa-angle-double-right"></i>');
					@elseif($key==TOKENIZE)
                                    $('#loginToPayLink').html('Proceed to Tokenize <i class="fa fas fa-angle-double-right"></i>');
					@else
					 $('#loginToPayLink').html('Proceed to Pay <i class="fa fas fa-angle-double-right"></i>');
					@endif
		
		loginToPayLinkCount++;
                
            if(data1.success===true)
            {
                //alert(33);
		  if(data1.status==100)
                {
                    //toastr.success(data1.message, '', toastroptions);
                    var $modalDashboard = $('#ajaxPaymentOptionDetailsListMenuModal');
                    $(document).ready(function(){

                        //$modal.modal('hide');
                        //$modalForgotPassword.modal('hide');

                        //$('body').modalmanager('loading');

			url = '';
			@if($key!=WALLET_ACCESS && $key!=TOKENIZE)
				url = '/ajax-otp-collection-view.html/{{OTP_COLLECTION_VIEW}}/{{$input}}/' + data1.txn_ref;
			@else
				@if($key==TOKENIZE)
				url = '/ajax-otp-collection-view.html/{{TOKENIZE}}/{{$input}}/' + data1.txn_ref;
				@else
				url = '/ajax-otp-collection-view.html/{{WALLET_ACCESS}}/{{$input}}/' + data1.txn_ref;
				@endif
			@endif
						
						if(testMode==0)
						{
							//setTimeout(function(){
								
								console.log(url);
								 $modalDashboard.load(url, '', function(){
									$modalDashboard.modal();
									if(document.getElementById("loginToPayOtp1"))
										document.getElementById("loginToPayOtp1").focus();
									handleNotifications();
								});
							//}, 1000);
						}
						else
						{
							window.location = url;
							toastr.error(data1.message, '', toastroptions);
						}
                    });
                }
                else if(data1.status==105)
                {
                    //toastr.success(data1.message, '', toastroptions);
                    var $modalDashboard = $('#ajaxPaymentOptionDetailsListMenuModal');
                    $(document).ready(function(){

                        //$modal.modal('hide');
                        //$modalForgotPassword.modal('hide');

                        //$('body').modalmanager('loading');

			url = '';
			console.log(data1);
			@if($key!=WALLET_ACCESS && $key!=TOKENIZE)
				url = '/ajax-pay-from-logged-in-wallet.html/{{PAY_FROM_LOGGED_IN_WALLET}}/{{$input}}/' + data1.txn_ref;
			@else
				
				@if($key==TOKENIZE)
				url = '/ajax-pay-from-logged-in-new-wallet-step-two.html/{{TOKENIZE}}/{{$input}}/' + data1.txn_ref;
				@else
				url = '/ajax-pay-from-logged-in-new-wallet-step-two.html/{{WALLET_ACCESS}}/{{$input}}/' + data1.txn_ref;
				@endif

			@endif
						
						if(testMode==0)
						{
							setTimeout(function(){
								
								console.log(url);
								 $modalDashboard.load(url, '', function(){
									$modalDashboard.modal();
									if(document.getElementById("loginToPayOtp1"))
										document.getElementById("loginToPayOtp1").focus();
									handleNotifications();
								});
							}, 1000);
						}
						else
						{
							window.location = url;
							toastr.error(data1.message, '', toastroptions);
						}
                    });
                }
                else if(data1.status==-1)
                {
		  	//alert(44554);
			toggleLoading();
                    console.log(window.location);
			toastr.info('Your session has ended. Please login again to continue', '', toastroptions );
                    
                    logoutUser('Your session has ended. Please log in to continue', window.location.href);
                }
                else
                {
		  	//alert(43344);
			toggleLoading();
                    toastr.error(data1.message, '', toastroptions);
                }

                //toastr.success(data1.message, '', toastroptions);
            }
            else
            {
		  //alert(444);
		  toggleLoading();
                toastr.error(data1.message, '', toastroptions);
                $('#dismissBtn').click();
                $('#new_card_modal').show();
            }
        },
        error: function (e) {
		toggleLoading();
		$('#loginToPayLink').html('Proceed to Pay <i class="fa fas fa-angle-double-right"></i>');
		loginToPayLinkCount++;
            toastr.error('We experienced an issue logging in. Please try again.', '', toastroptions);
        }
    });
	}
	
}




function forgotPassword()
{
	var $modalDashboard = $('#ajaxPaymentOptionDetailsListMenuModal');

	testMode = 0;
	url = '/ajax-pay-forgot-password.html/1800/{{$input}}/{{$orderId}}';
	if(testMode==0)
	{
		setTimeout(function(){
			
			console.log(url);
			 $modalDashboard.load(url, '', function(){
				$modalDashboard.modal();
				if(document.getElementById("loginToPayForgotPasswordMobileNoField"))
					document.getElementById("loginToPayForgotPasswordMobileNoField").focus();
				handleNotifications();
			});
		}, 1000);
	}
	else
	{
		window.location = url;
	}

}





$('.walletradios').on('change', function(){
	console.log(this.value);
	handleFlipForWallet(this.value);
})

function handleFlipForWallet(thisvalue)
{
    if(document.getElementById('zicbwalletdiv'))
        document.getElementById('zicbwalletdiv').style.display = 'none';
    if(document.getElementById('netbankingdivinfo'))
        document.getElementById('netbankingdivinfo').style.display = 'none';
	if(document.getElementById('mtndiv'))
        document.getElementById('mtndiv').style.display = 'none';
	if(document.getElementById('airteldiv'))
        document.getElementById('airteldiv').style.display = 'none';
	if(document.getElementById('zamteldiv'))
        document.getElementById('zamteldiv').style.display = 'none';
	if(document.getElementById('probasewalletdiv'))
        document.getElementById('probasewalletdiv').style.display = 'none';
	if(document.getElementById('walletdivinfo'))
        document.getElementById('walletdivinfo').style.display = 'block';
	var div = thisvalue.toLowerCase() + 'div';
	console.log(div);
	document.getElementById(div).style.display = 'block';
}

function handleTabSelector(className, selector)
{
    if(document.getElementById('billaddresslabel'))
        document.getElementById('billaddresslabel').style.display = 'none';
    if(document.getElementById('billaddressdetails'))
        document.getElementById('billaddressdetails').style.display = 'none';
    if(document.getElementById('billaddresslabeluba'))
        document.getElementById('billaddresslabeluba').style.display = 'none';
    if(document.getElementById('billaddressdetailsuba'))
        document.getElementById('billaddressdetailsuba').style.display = 'none';
	if(document.getElementById('zicbwalletdiv'))
        document.getElementById('zicbwalletdiv').style.display = 'none';
    if(document.getElementById('netbankingdivinfo'))
        document.getElementById('netbankingdivinfo').style.display = 'none';
	if(document.getElementById('mtndiv'))
        document.getElementById('mtndiv').style.display = 'none';
	if(document.getElementById('airteldiv'))
        document.getElementById('airteldiv').style.display = 'none';
	if(document.getElementById('zamteldiv'))
        document.getElementById('zamteldiv').style.display = 'none';
	if(document.getElementById('probasewalletdiv'))
        document.getElementById('probasewalletdiv').style.display = 'none';
	if(document.getElementById('walletdivinfo'))
        document.getElementById('walletdivinfo').style.display = 'none';
    //alert(33);

    var radios = document.getElementsByClassName('radios');
    for(var i=0; i<radios.length; i++)
	{
	    var radio = radios[i];
	    radio.checked = false;
	}
	console.log(radios.length);

    var radios = document.getElementsByClassName(className);
    document.getElementById('payoption').value = "-1";
    if(selector=='RADIO')
    {
    	for(var i=0; i<radios.length; i++)
    	{
    	    var radio = radios[i];
    	    radio.checked = false;
    	}
    }
	else if(selector=='SELECT')
    {
        var target = "#target";
        var first_option = "#target option:first";
	    $(target).val($(first_option).val());
    }
}

function handleSelect(val, id, showBillDetails, selector)
{
	document.getElementById('payoption').value = val;
	//alert([val, id]);
	if(document.getElementsByClassName(id))
	{
		if(selector=='RADIO')
		{
			document.getElementById('payoption').value = "-1";
			var ids = document.getElementsByClassName(id);
			for(var i=0; i<ids.length; i++)
			{
				var id_ = ids[i];
				if(id_.checked)
				{
					//alert(id_.value);
					document.getElementById('payoption').value = id_.value;
				}
			}
		}
		else if(selector=='SELECT')
		{
			document.getElementById('payoption').value = "-1";
			var ids = document.getElementsByClassName(id);
			for(var i=0; i<ids.length; i++)
			{
				var id_ = ids[i];
				console.log('id_.value===' + id_.value);
				if(id_.value!='Select Bank')
				{
			        document.getElementById('payoption').value = id_.value.split('###')[0];
				}
			}
		}
	}
	/*document.getElementById('mastercarddiv').style.border = "thick solid #ffffff";
	document.getElementById('eaglecarddiv').style.border = "thick solid #ffffff";
	document.getElementById('otcdiv').style.border = "thick solid #ffffff";
	document.getElementById('walletdiv').style.border = "thick solid #ffffff";
	document.getElementById('bankdiv').style.border = "thick solid #ffffff";
	document.getElementById(id).style.border = "thick solid #DB3944";*/
	if(showBillDetails==1)
	{
	    if(document.getElementById('billaddresslabel'))
	        document.getElementById('billaddresslabel').style.display = 'block';
	    if(document.getElementById('billaddressdetails'))
	        document.getElementById('billaddressdetails').style.display = 'block';
	    if(document.getElementById('billaddresslabeluba'))
	        document.getElementById('billaddresslabeluba').style.display = 'none';
	    if(document.getElementById('billaddressdetailsuba'))
	        document.getElementById('billaddressdetailsuba').style.display = 'none';
    	if(document.getElementById('walletdivinfo'))
            document.getElementById('walletdivinfo').style.display = 'none';
    	if(document.getElementById('netbankingdivinfo'))
            document.getElementById('netbankingdivinfo').style.display = 'none';
	}
	else if(showBillDetails==2)
	{
	    if(document.getElementById('billaddresslabeluba'))
	        document.getElementById('billaddresslabeluba').style.display = 'block';
	    if(document.getElementById('billaddressdetailsuba'))
	        document.getElementById('billaddressdetailsuba').style.display = 'block';
	    if(document.getElementById('billaddresslabel'))
	        document.getElementById('billaddresslabel').style.display = 'none';
	    if(document.getElementById('billaddressdetails'))
	        document.getElementById('billaddressdetails').style.display = 'none';
    	if(document.getElementById('walletdivinfo'))
            document.getElementById('walletdivinfo').style.display = 'none';
    	if(document.getElementById('netbankingdivinfo'))
            document.getElementById('netbankingdivinfo').style.display = 'none';
	}
	else if(showBillDetails==3)
	{
	    if(document.getElementById('billaddresslabeluba'))
	        document.getElementById('billaddresslabeluba').style.display = 'none';
	    if(document.getElementById('billaddressdetailsuba'))
	        document.getElementById('billaddressdetailsuba').style.display = 'none';
	    if(document.getElementById('billaddresslabel'))
	        document.getElementById('billaddresslabel').style.display = 'none';
	    if(document.getElementById('billaddressdetails'))
	        document.getElementById('billaddressdetails').style.display = 'none';
    	if(document.getElementById('walletdivinfo'))
            document.getElementById('walletdivinfo').style.display = 'none';
    	if(document.getElementById('netbankingdivinfo'))
            document.getElementById('netbankingdivinfo').style.display = 'block';
	}
	else
	{
	    if(document.getElementById('billaddresslabel'))
	        document.getElementById('billaddresslabel').style.display = 'none';
	    if(document.getElementById('billaddressdetails'))
	        document.getElementById('billaddressdetails').style.display = 'none';
	    if(document.getElementById('billaddresslabeluba'))
	        document.getElementById('billaddresslabeluba').style.display = 'none';
	    if(document.getElementById('billaddressdetailsuba'))
	        document.getElementById('billaddressdetailsuba').style.display = 'none';
    	if(document.getElementById('walletdivinfo'))
            document.getElementById('walletdivinfo').style.display = 'block';
    	if(document.getElementById('netbankingdivinfo'))
            document.getElementById('netbankingdivinfo').style.display = 'none';
	}



}


$('.zicbwalletselect').on('change', function(){
	console.log(this.value);
	//handleFlipForWallet(this.value);
	if(this.value=='EXISTINGWALLET')
	{
	    $('#errorotp1').hide();
	    $('#isWalletOrAccount').val(0);
	    $('#manageIncidencesModal').modal('toggle');
	}
	else
	{

	}
})

function checkout()
{
    console.log(document.getElementById('net-banking').value.length);
    console.log(document.getElementById('net-banking').value);
    console.log(document.getElementById('payoption').value);
	if(document.getElementById('payoption').value==-1)
	{
		alert('You must specify your preferred payment method by clicking on a payment method first');
	}
	else if(document.getElementById('payoption').value=='BANKONLINE' && document.getElementById('net-banking').value=='Select Bank')
	{
		alert('You must specify your preferred payment method by clicking on a payment method first');
	}
	else
	{
		document.getElementById('form12').submit();
	}
}

$(function(){
	var radios = document.getElementsByClassName('radios');
	for(var i=0; i<radios.length; i++)
	{
	    var radio = radios[i];
	    radio.checked = false;
	}
});


$("#country").on('change', function () {
	var $this = $(this);
	var province = $("#province");
	var district = $("#district");
	var countryId = $(this).val();
	//lga.html('loading...');
	$("#province").empty();
	$("#district").empty();
	district.prepend($('<option>', {
		text: '-Select District-',
		value: null
	}));

	province.prepend($('<option selected>', {
		text: 'Loading provinces...Please Wait',
		value: null
	}));
	$.ajax({
		url: '/utility/services/pull-province/' + countryId,
		dataType: 'json',
		success: function (resp) {
			if (resp.status === 1) {
				$("#province").empty();
				$("#district").empty();
				province.append($('<option>', {
					text: '-Select A Province-',
					value: null
				}));
				$.each(resp.data, function (k, v) {
					province.append($('<option>', {
						value: k + '_' + v,
						text: v
					}));
				});
			}
		},
		complete: function () {
			$this.removeClass('disabled');
			$("#province").removeClass('disabled');
		}
	});

});


$("#province").on('change', function () {
	var $this = $(this);
	var district = $("#district");
	var provinceId = $(this).val();
	//lga.html('loading...');
	$("#district").empty();
	district.prepend($('<option>', {
		text: 'Loading districts...Please Wait',
		value: null
	}));
	$.ajax({
		url: '/utility/services/pull-district/' + provinceId,
		dataType: 'json',
		success: function (resp) {
			if (resp.status === 1) {
				$("#district").empty();
				$.each(resp.data, function (k, v) {
					district.append($('<option>', {
						value: k + '_' + v,
						text: v
					}));
				});
				district.prepend($('<option>', {
					text: '-You can now select a district-',
					value: null
				}));
			}
		},
		complete: function () {
			$this.removeClass('disabled');
			$("#district").removeClass('disabled');
		}
	});

});


$("#provinceuba").on('change', function () {
	var $this = $(this);
	var district = $("#districtuba");
	var provinceId = $(this).val();
	//lga.html('loading...');
	$("#districtuba").empty();
	district.prepend($('<option>', {
		text: 'Loading districts...Please Wait',
		value: null
	}));
	$.ajax({
		url: '/utility/services/pull-district/' + provinceId,
		dataType: 'json',
		success: function (resp) {
			if (resp.status === 1) {
				$("#districtuba").empty();
				$.each(resp.data, function (k, v) {
					district.append($('<option>', {
						value: k + '_' + v,
						text: v
					}));
				});
				district.prepend($('<option>', {
					text: '-You can now select a district-',
					value: null
				}));
			}
		},
		complete: function () {
			$this.removeClass('disabled');
			$("#district").removeClass('disabled');
		}
	});

});

$("#provinceBank").on('change', function () {
	var $this = $(this);
	var district = $("#districtBank");
	var provinceId = $(this).val();
	//lga.html('loading...');
	$("#districtBank").empty();
	district.prepend($('<option>', {
		text: 'Loading districts...Please Wait',
		value: null
	}));
	$.ajax({
		url: '/utility/services/pull-district/' + provinceId,
		dataType: 'json',
		success: function (resp) {
			if (resp.status === 1) {
				$("#districtBank").empty();
				$.each(resp.data, function (k, v) {
					district.append($('<option>', {
						value: k + '_' + v,
						text: v
					}));
				});
				district.prepend($('<option>', {
					text: '-You can now select a district-',
					value: null
				}));
			}
		},
		complete: function () {
			$this.removeClass('disabled');
			$("#district").removeClass('disabled');
		}
	});

});


$("#provincezicb").on('change', function () {
	var $this = $(this);
	var districtzicb = $("#districtzicb");
	var provinceId = $(this).val();
	//lga.html('loading...');
	$("#districtzicb").empty();
	districtzicb.prepend($('<option>', {
		text: 'Loading districts...Please Wait',
		value: null
	}));
	$.ajax({
		url: '/utility/services/pull-district/' + provinceId,
		dataType: 'json',
		success: function (resp) {
			if (resp.status === 1) {
				$("#districtzicb").empty();
				$.each(resp.data, function (k, v) {
					districtzicb.append($('<option>', {
						value: k + '_' + v,
						text: v
					}));
				});
				districtzicb.prepend($('<option>', {
					text: '-You can now select a district-',
					value: null
				}));
			}
		},
		complete: function () {
			$this.removeClass('disabled');
			$("#districtzicb").removeClass('disabled');
		}
	});

});





</script>
