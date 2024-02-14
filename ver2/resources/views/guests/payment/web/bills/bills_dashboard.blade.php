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



	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="/v2/https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="/v2/https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<style>

.reserve-box{

}

</style>
<!--<div class="pull-right" style="padding-right: 30px; padding-top:5px;">
	<a href="javascript:closeModals()"><i class="fa fa-close"></i></a>
</div>-->
<div class="holder">
    <div class="reserve-box mt-30" style="border: 0px double #224fb4;">
        <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="text-transform: uppercase;
            background: #DB3944;
            color: #FFF;
            line-height: 1;
            margin: 0;
            margin-top: -30px;
            padding: 15px 23px; ">
            <div style="float: left !important; " class="col col-md-5 col-sm-5 col-lg-5 col-xs-5"><h5 style="padding: 0px !Important; margin-top: 0px !important; float: left !important">Bevura</h5></div>
            <div style="float: right !important; text-align:right !Important; font-size: 11px !important" class="col col-md-7 col-sm-7 col-lg-7 col-xs-7"><small><br>Other Bills</small></div>

        </div><!---->
        <div style="clear: both !important" class="container-fluid invoice-container" id="section-to-print" style="margin-left:0px !important; margin-right: 0px !important;">
            @include('partials.errors')

                <div class="panel panel-default" style="padding-left:0px !important; padding-right: 0px !important">
                    <div class="col-xs-12 col-sm-12" style="cursor: pointer; padding-left:0px !important; padding-right: 0px !important">
                        <!--<div style="padding-top: 5px !important; text-align: right !Important; font-weight: bold !important">Your Bill:</div>-->

                        <div class="col-xs-12 col-sm-12" style="padding-left: 5px !Important; padding-top: 15px !Important; cursor: pointer; font-size: 18px !important; color: #000000 !important;">
                            <b>Bills & Levies</b>
                        </div>

                        <div class="row gap-20">
                            <div class="col-xs-12 col-sm-12 col-md-12" style="padding: 0px !important; padding-top: 20px !important;">
                            	<div class="col-xs-6 col-sm-6 col-md-6" style="text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
						<div class="" style="float: left !important; text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
							<img src="/images/bills/rtsa.png" style="width: 30px !important; display: inline !important">
						</div>
						<div class="" style="padding-left: 5px !important; float: left !important; text-align: left !important; line-height: 1.5 !important; font-size: 12px !important;" onclick="handleClick('rtsa')">
							Road Taxes<br>
							<div style="font-size: 10px !important; color: #224fb4 !important;">Pay RTSA Dues</div>
						</div>
					</div>


                            	<div class="col-xs-6 col-sm-6 col-md-6" style="text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
						<div class="" style="float: left !important; text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
							<img src="/images/bills/napsa.png" style="width: 30px !important; display: inline !important">
						</div>
						<div class="" style="padding-left: 5px !important; float: left !important; text-align: left !important; line-height: 1.5 !important; font-size: 12px !important;" onclick="handleClick('rtsa')">
							NAPSA Dues<br>
							<div style="font-size: 10px !important; color: #224fb4 !important;">Pay NAPSA Dues</div>
						</div>
					</div>

                            	<div class="col-xs-12 col-sm-12 col-md-12" style="clear: both !important; height: 30px !important;">
					&nbsp;
					</div>

                            	<div class="col-xs-6 col-sm-6 col-md-6" style="text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
						<div class="" style="float: left !important; text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
							<img src="/images/bills/zra.png" style="width: inherit !important; width: 30px !important; display: inline !important">
						</div>
						<div class="" style="padding-left: 5px !important; float: left !important; text-align: left !important; line-height: 1.5 !important; font-size: 12px !important;" onclick="handleClick('rtsa')">
							ZRA Taxes<br>
							<div style="font-size: 10px !important; color: #224fb4 !important;">Pay ZRA Taxes</div>
						</div>
					</div>


                            	<div class="col-xs-6 col-sm-6 col-md-6" style="text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
						<div class="" style="float: left !important; text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
							<img src="/images/bills/nhima_logo.jpg" style="width: inherit !important; width: 30px !important; display: inline !important">
						</div>
						<div class="" style="padding-left: 5px !important; float: left !important; text-align: left !important; line-height: 1.5 !important; font-size: 12px !important;" onclick="handleClick('rtsa')">
							NHIMA Payments<br>
							<div style="font-size: 10px !important; color: #224fb4 !important;">Pay NHIMA Dues</div>
						</div>
					</div>


                            	<div class="col-xs-12 col-sm-12 col-md-12" style="clear: both !important; height: 30px !important;">
					&nbsp;
					</div>


                            	<div class="col-xs-6 col-sm-6 col-md-6" style="text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
						<div class="" style="float: left !important; text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
							<img src="/images/bills/chingola.jpg" style="width: inherit !important; width: 30px !important; display: inline !important">
						</div>
						<div class="" style="padding-left: 5px !important; float: left !important; text-align: left !important; line-height: 1.5 !important; font-size: 12px !important;" onclick="handleClick('rtsa')">
							Chingola Council Dues<br>
							<div style="font-size: 10px !important; color: #224fb4 !important;">Pay Council Dues</div>
						</div>
					</div>


                            	<div class="col-xs-6 col-sm-6 col-md-6" style="text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
						<div class="" style="float: left !important; text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
							<img src="/images/bills/llusaka-city-council.png" style="width: inherit !important; width: 30px !important; display: inline !important">
						</div>
						<div class="" style="padding-left: 5px !important; float: left !important; text-align: left !important; line-height: 1.5 !important; font-size: 12px !important;" onclick="handleClick('rtsa')">
							Lusaka Council Dues<br>
							<div style="font-size: 10px !important; color: #224fb4 !important;">Pay Council Dues</div>
						</div>
					</div>


                            	<div class="col-xs-12 col-sm-12 col-md-12" style="clear: both !important; height: 30px !important;">
					&nbsp;
					</div>



                            	<div class="col-xs-6 col-sm-6 col-md-6" style="text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
						<div class="" style="float: left !important; text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
							<img src="/images/bills/nhima_logo.jpg" style="width: inherit !important; width: 30px !important; display: inline !important">
						</div>
						<div class="" style="padding-left: 5px !important; float: left !important; text-align: left !important; line-height: 1.5 !important; font-size: 12px !important;" onclick="handleClick('rtsa')">
							Internet Data<br>
							<div style="font-size: 10px !important; color: #224fb4 !important;">Buy Internet Data</div>
						</div>
					</div>

				</div>
                        </div>



                            	<div class="col-xs-12 col-sm-12 col-md-12" style="clear: both !important; padding: 5px !important; padding-top: 30px !important; padding-left: 60px !important; padding-right: 60px !important; ">
					<hr>
					</div>

			   <div class="col-xs-12 col-sm-12" style="padding-left: 5px !Important; cursor: pointer; font-size: 18px !important; color: #000000 !important;">
                        	<b>Cooperatives & Investments</b>
                        </div>
                        <div class="row gap-20">
                            <div class="col-xs-12 col-sm-12 col-md-12">


					<div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
						<a href="" class="btn btn-primary btn-sm mt-15" name="submitButton" id="" value=""><i class="fa fas fa-plus"></i> Create A Cooperative</a>
					</div>

                            </div>
                        </div>

                            	<div class="col-xs-12 col-sm-12 col-md-12" style="clear: both !important; padding: 5px !important; padding-top: 30px !important; padding-left: 60px !important; padding-right: 60px !important; " onclick="handleClick('rtsa')">
					<hr>
					</div>


			   <div class="col-xs-12 col-sm-12" style="padding-left: 5px !Important; cursor: pointer; font-size: 18px !important; color: #000000 !important;">
                        	<b>Other Finance</b>
                        </div>
                        <div class="row gap-20">
                            <div class="col-xs-12 col-sm-12 col-md-12" style="padding-top: 20px !important;">

                            	<div class="col-xs-6 col-sm-6 col-md-6" style="text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
						<div class="" style="float: left !important; text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
							<img src="/images/bills/bet.png" style="width: 30px !important; display: inline !important">
						</div>
						<div class="" style="padding-left: 5px !important; float: left !important; text-align: left !important; line-height: 1.5 !important; font-size: 12px !important;" onclick="handleClick('rtsa')">
							Bet Payments<br>
							<div style="font-size: 10px !important; color: #224fb4 !important;">Pay for sports bets</div>
						</div>
					</div>


                            	<div class="col-xs-6 col-sm-6 col-md-6" style="text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
						<div class="" style="float: left !important; text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
							<img src="/images/bills/mobilemoneytransfer.jpg" style="width: 30px !important; display: inline !important">
						</div>
						<div class="" style="padding-left: 5px !important; float: left !important; text-align: left !important; line-height: 1.5 !important; font-size: 12px !important;" onclick="handleClick('rtsa')">
							Mobile Money Transfer<br>
							<div style="font-size: 10px !important; color: #224fb4 !important;">Airtel, MTN, ZAMTEL</div>
						</div>
					</div>


                            	<div class="col-xs-12 col-sm-12 col-md-12" style="clear: both !important; height: 30px !important;">
					&nbsp;
					</div>



                            	<div class="col-xs-6 col-sm-6 col-md-6" style="text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
						<div class="" style="float: left !important; text-align: center !important; line-height: 1.5 !important; font-size: 12px !important;">
							<img src="/images/bills/airtimetomoney.jpg" style="width: 30px !important; display: inline !important">
						</div>
						<div class="" style="padding-left: 5px !important; float: left !important; text-align: left !important; line-height: 1.5 !important; font-size: 12px !important;" onclick="handleClick('rtsa')">
							Airtime To Money<br>
							<div style="font-size: 10px !important; color: #224fb4 !important;">Sell Airtime</div>
						</div>
					</div>


				</div>
                        </div>


                    </div>

                </div>

    </div>
</div>





<!-- JS -->
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
<!--<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/bootstrap-modalmanager.js"></script>-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/instagram.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/bootstrap3-wysihtml5.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/customs.js?x=1"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/customs-reservation.js"></script>
<script type="text/javascript" src="/js/action.js"></script>

<script>

$( document ).ready(function() {

});



function handleClick(){
   window.location = '/mobile-extension/coming-soon';
}


function handleProcessPay()
{
    var $cardsBvList = $('.cardsBv');
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
    }
}


function handleCardSelect(bthis, amount, bill)
{
    var totalSelected = 0.00;
    var $cardsBvList = $('.cardsBv');
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
                    //toastr.success(data1.message);
                    var $modalDashboard = $('#ajaxPaymentDetailsListMenuModal');
                    $(document).ready(function(){

                        //$modal.modal('hide');
                        //$modalForgotPassword.modal('hide');

                        //$('body').modalmanager('loading');

                        setTimeout(function(){
                            url = '/ajax-pay-from-logged-in-wallet.html/' + data1.txn_ref;
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
                    //toastr.info(data1.message);
                    var $modalDashboard = $('#ajaxPaymentDetailsListMenuModal');
                    $(document).ready(function(){

                        //$modal.modal('hide');
                        //$modalForgotPassword.modal('hide');

                        //$('body').modalmanager('loading');

                        setTimeout(function(){
                            url = '/ajax-payment-details.html/';
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
                    //toastr.error(data1.message);

                }

                //toastr.success(data1.message);
            }
            else
            {
                toastr.error(data1.message);
                $('#dismissBtn').click();
                $('#new_card_modal').show();
            }
        },
        error: function (e) {
            toastr.error('We experienced an issue updating your merchant profile. Please try again.');
        }
    });
}



</script>
