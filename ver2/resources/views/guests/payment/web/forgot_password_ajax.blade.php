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

		@if($key!=WALLET_ACCESS)
            <div style="float: right !important; text-align:right !Important; font-size: 11px !important" class="col col-md-7 col-sm-7 col-lg-7 col-xs-7"><small>{{strtoupper($orderId)}}<br>Order Ref</small></div>
		@endif
        </div>
        <div style="clear: both !important; padding-left: 0px !important; padding-right: 0px !important" class="container-fluid invoice-container" id="section-to-print" style="margin-left:0px !important; margin-right: 0px !important;">
            @include('partials.errors')


            <form action="/api/forgot-password" id="recoverPasswordForm" method="post" enctype="application/x-www-form-urlencoded">
                <input type="hidden" name="orderId" value="{{$orderId}}">
                <input type="hidden" name="data" value="{{$input}}">
                <div class="panel panel-default">
                    <?php $x=1; $total =$totalAmount ; ?>

                    <div class="col-xs-12 col-sm-12" style="cursor: pointer">
			@if($key!=WALLET_ACCESS)
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
                                        <div class="col col-md-10 col-sm-10 col-xs-10 col-lg-10" style="padding-right: 0px !Important">
                                        <input type="number" maxlength="9" size="9" id="loginToPayForgotPasswordMobileNoField" name="loginToPayForgotPasswordMobileNoField" value="" required class="form-control " style="
                                           opacity: .8;
                                           cursor: text;
                                           background-color: #fff !important;
                                           -webkit-transition: all ease-out 120ms;
                                           -o-transition: all ease-out 120ms;
                                           transition: all ease-out 120ms;
                                           z-index: 50000;" placeholder="example 967000000"/>
                                        </div>
                                    </div>



                                    


                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-top: 10px !Important; padding-left: 0px !Important">
                                        <a href="javascript:goBackToPayment()" class="recoveryOption forgotPassword">Go Back To Payment</a>
                                    </div>

                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-top: 10px !Important; padding-left: 0px !Important; padding-right: 0px !Important">
                                        <a id="loginToPayLink" href="javascript:recoverPassword()" class="btn btn-primary mt-15 col-md-12 col-lg-12 col-sm-12 col-xs-12" name="submitButton" value="Create Account">Reset My Password <i class="fa fas fa-angle-double-right"></i></a>
    <!--<input type="submit">-->
                                    </div>


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
                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-left: 0px !Important">
                                        <a class="" href="javascript:history.back(-1)">Cancel</a>
                                    </div>

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

		@if($key!=WALLET_ACCESS)
            
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

var loginToPayLinkCount = 0;
function recoverPassword()
{

	if(loginToPayLinkCount%2==0)
	{
		toggleLoading();
		loginToPayLinkCount++;
		$('#loginToPayLink').html("Recovering your password. Please wait...");
    		var form = $('#recoverPasswordForm')[0];
    		var formData = new FormData(form);
		console.log(formData);
		formData['username'] = formData['countrycode'] + formData['loginToPayForgotPasswordMobileNoField'];
    		console.log(formData);
    		var url = '/api/forgot-password';
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

				$('#loginToPayLink').html('Reset My Password <i class="fa fas fa-angle-double-right"></i>');
				loginToPayLinkCount++;

				if(data1!=null && data1.status!=undefined && data1.status!=null && data1.status==100)
				{

					toastr.success(data1.message!=undefined && data1.message!=null ? data1.message : 'Your password has been reset and sent to your mobile number in a text message', '', toastroptions);
					var $modalDashboard = $('#ajaxPaymentOptionDetailsListMenuModal');

					testMode = 0;
					url = '/ajax-payment-details.html/0001/{{$input}}';
					if(testMode==0)
					{
						setTimeout(function(){
			
							console.log(url);
							$modalDashboard.load(url, '', function(){
								$modalDashboard.modal();
								if(document.getElementById("username"))
									document.getElementById("username").focus();
								handleNotifications();
							});
						}, 1000);
					}
					else
					{
						window.location = url;
					}

				}
				else
				{
					toastr.error(data1.message!=undefined && data1.message!=null ? data1.message : 'Your password reset was not successful. Please try again', '', toastroptions);

				}
                
            
        		},
        		error: function (e) {
				toggleLoading();
				$('#loginToPayLink').html('Reset My Password <i class="fa fas fa-angle-double-right"></i>');
				loginToPayLinkCount++;
            			toastr.error('We experienced an issue resetting your password. Please try again.', '', toastroptions);
        		}
    		});
	}
	
}

</script>