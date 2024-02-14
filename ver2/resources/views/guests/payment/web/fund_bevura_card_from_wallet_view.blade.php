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
    width: calc((100vw - 60%)/2) !important;
    margin-left: calc((100vw - 30%)/2) !important;
}
</style>
<!--<div class="pull-right" style="padding-right: 30px; padding-top:5px;">
	<a href="javascript:closeModals()"><i class="fa fa-close"></i></a>
</div>-->
<div class="holder">
    <div class="reserve-box mt-30" style="border: 0px double #EBE9E8;">
        <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="text-transform: uppercase;
            background: #DB3944;
            color: #FFF;
            line-height: 1;
            margin: 0;
            margin-top: -3px;
            padding: 15px 23px; ">
            <div style="float: left !important; " class="col col-md-5 col-sm-5 col-lg-5 col-xs-5"><h5 style="padding: 0px !Important; margin-top: 0px !important; float: left !important">Bevura</h5></div>
            <div style="float: right !important; text-align:right !Important; font-size: 11px !important" class="col col-md-7 col-sm-7 col-lg-7 col-xs-7"><small>{{strtoupper($orderId)}}<br>Order Ref</small></div>

        </div>
        <div style="clear: both !important" class="container-fluid invoice-container" id="section-to-print" style="margin-left:0px !important; margin-right: 0px !important;">
            @include('partials.errors')

                <div class="panel panel-default" style="padding-left:0px !important; padding-right: 0px !important">
                    <div class="col-xs-12 col-sm-12" style="cursor: pointer; padding-left:0px !important; padding-right: 0px !important">
                        <div style="padding-top: 5px !important; text-align: right !Important; font-weight: bold !important">Your Bill: {{$currency}}{{number_format($totalAmount, 2, '.', ',')}}</div>

                        <div class="col-xs-12 col-sm-12" style="padding-left: 5px !Important; cursor: pointer; font-size: 18px !important">
                            Transfer Funds To Your Card<br>
                            <div style="cursor: pointer; font-size: 14px !important">After transfering funds to your card, you can then make a payment from your card(s). This helps you manage your spending</div>
                        </div>

                        <div class="row gap-20">
                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="form-group" style="padding-top:10px !important">

                                    @if(($cards!=null && sizeof($cards)>0))
                                        <form action="/api/fund-card-from-wallet" id="fundCardFromWalletForm" method="post" enctype="application/x-www-form-urlencoded">

                                            <input type="hidden" id="orderId" name="orderId" value="{{$orderId}}">
                                            <input type="hidden" name="data" value="{{$input}}">
                                            <div class="panel panel-default">


                                                <div class="col-xs-12 col-sm-12" style="cursor: pointer">

                                                    <div class="row gap-20">
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group" style="padding-top:10px !important">



                                                                <label style="font-weight: 100 !important">Your Current Balance</label>
                                                                <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background-color: #EBEBEB; padding-right: 0px !Important; padding-left: 0px !Important">
                                                                    <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding: 10px !important">
                                                                    {{$defaultAccountBal->accountCurrency}}{{number_format($defaultAccountBal->currentBalance, 2, '.', ',')}}
                                                                    </div>
                                                                </div>



                                                                <label style="font-weight: 100 !important">Available Balance</label>
                                                                <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background-color: #EBEBEB; padding-right: 0px !Important; padding-left: 0px !Important">
                                                                    <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding: 10px !important">
                                                                    {{$defaultAccountBal->accountCurrency}}{{number_format($defaultAccountBal->availableBalance, 2, '.', ',')}}
                                                                    </div>
                                                                </div>


                                                                <label style="font-weight: 100 !important">Transfer To My Card<span style="color: red">*</span></label>
                                                                <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background-color: #EBEBEB; padding-right: 0px !Important; padding-left: 0px !Important">
                                                                    <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="text-align: center !Important; padding: 10px !important; padding-left: 0px !important">
                                                                        <select name="cardAccountOverViewTransferToCard" class="form-control col-md-12 col-sm-12 col-lg-12 col-xs-12" id="cardAccountOverViewTransferToCard" style="border: 0px !important; background: transparent !important">
                                                                            @foreach($cards as $card)
                                                                                <option value="{{$card->trackingNumber}}|||{{$card->serialNo}}" class="login-option" {{$serialNo==$card->serialNo ? 'selected' : ''}}>{{str_split($card->pan, 4)[0]}} *** *** {{str_split($card->pan, 4)[3]}}</option>
                                                                            @endforeach

                                                                        </select>
                                                                    </div>
                                                                </div>


                                                                <label style="font-weight: 100 !important">Amount to Transfer<span style="color: red">*</span></label>
                                                                <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background-color: #EBEBEB; padding-right: 0px !Important; padding-left: 0px !important">
                                                                    <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="text-align: center !Important; padding: 10px !important">
                                                                        <input type="number" name="amountAccountOverViewTransferToCard" id="amountAccountOverViewTransferToCard" required class="form-control " value="" style="
                                                                               opacity: .8;
                                                                               cursor: text;
                                                                               background-color: #fff !important;
                                                                               -webkit-transition: all ease-out 120ms;
                                                                               -o-transition: all ease-out 120ms;
                                                                               transition: all ease-out 120ms;
                                                                               z-index: 50000;" placeholder="0.00"/>
                                                                    </div>
                                                                </div>


                                                                <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-top: 10px !Important; padding-left: 0px !Important; padding-right: 0px !Important">
                                                                    <a onclick="transferToMyCardFromMyWallet('fundCardFromWalletForm', '{{$input}}', '{{$orderId}}', '{{\Session::get('jwt_token')}}')" class="btn btn-primary mt-15 col-md-12 col-lg-12 col-sm-12 col-xs-12" name="submitButton" value="Create Account">Transfer To My Card <i class="fa fas fa-angle-double-right"></i></a>




                                                                </div>


                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </form>

                                        <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding-left: 0px !important; padding-top: 10px !Important; border-bottom: 0px solid #dedede">
                                            <a class="" href="javascript:history.back(-3)"><i class="fa fas fa-angle-double-left"></i> Go Back</a>
                                        </div>
                                    @else
                                        <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="border-bottom: 1px solid #dedede">&nbsp;</div>
                                        <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding: 0px; padding-right: 10px; padding-top: 10px; ">
                                            <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12">
                                                You do not have any cards to pay from.
                                                <a href="/ajax-pay-from-logged-in-new-wallet-step-two.html/101/{{$input}}/{{$orderId}}" class="btn btn-primary btn-sm mt-15" name="submitButton" id="" value=""><i class="fa fas fa-plus"></i> Add A Card To Your Profile</a>

                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="padding-top: 10px !Important; border-bottom: 0px solid #dedede">
                                                <a class=" mt-15" href="javascript:history.back(-1)">Go Back</a>
                                            </div>


                                        </div>
                                    @endif


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
