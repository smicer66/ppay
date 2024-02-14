<!--<!doctype html>
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

</head>-->
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

.stroke-transparent {
 -webkit-text-stroke: 1px #757474;
 -webkit-text-fill-color: transparent;
}


input[type='radio'] + label:before {
    font-family: none !important;
    content: none !important;
}


input[type='radio']:checked + label:before {
    font-family: none !important;
    content: none !important;
}

</style>
<!--<div class="pull-right" style="padding-right: 30px; padding-top:5px;">
	<a href="javascript:closeModals()"><i class="fa fa-close"></i></a>
</div>-->

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
            <div style="float: right !important; text-align:right !Important; font-size: 11px !important" class="col col-md-7 col-sm-7 col-lg-7 col-xs-7"><small>{{strtoupper($orderId)}}<br>Order Ref</small></div>

        </div>
        <div style="clear: both !important; padding-left: 0px !important; padding-right: 0px !important" class="container-fluid invoice-container" id="section-to-print" style="margin-left:0px !important; margin-right: 0px !important;">
            @include('partials.errors')
            <div class="" style="clear: both !important; bottom: 0px; color: #000 !important; padding-right: 0px !important">
                <div class="col-xs-12 col-sm-12" style="padding-top: 15px !important; padding-bottom: 10px !important; padding-left: 20px !Important; cursor: pointer; font-size: 18px !important">
                    Choose a payment method<br>
                </div>


                @if(isset($payment_options->bevuraWalletAccept) && $payment_options->bevuraWalletAccept==1)
                <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background: #fff !important; padding: 0px !important; padding-top: 10px !important; padding-bottom: 10px !important">
                    <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background: hsla(0,0%,88%,.95) !important; padding: 10px !important">
                        <div class="col col-md-2 col-sm-2 col-xs-2 col-lg-2" style="text-align: left !important; padding: 0px !important; padding: 0px !important; padding-left: 15px !important;">
                            <i class="fas fa-wallet stroke-transparent" style="color: #fff !important; font-size: 14px !important;"></i>
                        </div>
                        <div class="col col-md-10 col-sm-10 col-xs-10 col-lg-10" style="padding: 0px !important">
                            <a onclick="handleNextSendToSelectedPaymentOption(0)" style="color: #337ab7 !important; cursor: pointer !important">Pay Using Bevura Wallet</a>
                        </div>
                    </div>
                </div>
                @endif

                @if(isset($payment_options->mastercardAccept) && $payment_options->mastercardAccept==1)
                <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background: #fff !important; padding: 0px !important; padding-top: 10px !important; padding-bottom: 10px !important">
                    <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background: hsla(0,0%,88%,.95) !important; padding: 10px !important">
                        <div class="col col-md-2 col-sm-2 col-xs-2 col-lg-2" style="text-align: left !important; padding: 0px !important; padding: 0px !important; padding-left: 15px !important;">
                            <i class="fab fa-cc-mastercard stroke-transparent" style="color: #fff !important; font-size: 14px !important;"></i>
                        </div>
                        <div class="col col-md-10 col-sm-10 col-xs-10 col-lg-10" style="padding: 0px !important">
                            <a onclick="handleNextSendToSelectedPaymentOption(1)" style="color: #337ab7 !important; cursor: pointer !important">Pay Using Mastercard</a>
                        </div>
                    </div>
                </div>
                @endif

                @if(isset($payment_options->mobileMoneyAccept) && $payment_options->mobileMoneyAccept==1)
                <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background: #fff !important; padding: 0px !important; padding-top: 10px !important; padding-bottom: 10px !important">
                    <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background: hsla(0,0%,88%,.95) !important; padding: 10px !important">
                        <div class="col col-md-2 col-sm-2 col-xs-2 col-lg-2" style="text-align: left !important; padding: 0px !important; padding: 0px !important; padding-left: 15px !important;">
                            <i class="fas fa-mobile stroke-transparent" style="color: #fff !important; font-size: 14px !important;"></i>
                        </div>
                        <div class="col col-md-10 col-sm-10 col-xs-10 col-lg-10" style="padding: 0px !important">
                            <a onclick="handleNextSendToSelectedPaymentOption(2)" style="color: #337ab7 !important; cursor: pointer !important">Pay Using Mobile Money</a>
                        </div>
                    </div>
                </div>
                @endif

                @if(isset($payment_options->visaAccept) && $payment_options->visaAccept==1)
                <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background: #fff !important; padding: 0px !important; padding-top: 10px !important; padding-bottom: 10px !important">
                    <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background: hsla(0,0%,88%,.95) !important; padding: 10px !important">
                        <div class="col col-md-2 col-sm-2 col-xs-2 col-lg-2" style="text-align: left !important; padding: 0px !important; padding: 0px !important; padding-left: 15px !important;">
                            <i class="fab fa-cc-visa stroke-transparent" style="color: #fff !important; font-size: 14px !important;"></i>
                        </div>
                        <div class="col col-md-10 col-sm-10 col-xs-10 col-lg-10" style="padding: 0px !important">
                            <a onclick="handleNextSendToSelectedPaymentOption(3)" style="color: #337ab7 !important; cursor: pointer !important">Pay Using A Visa Card</a>
                        </div>
                    </div>
                </div>
                @endif

                @if(isset($payment_options->onlineBankingAccept) && $payment_options->onlineBankingAccept==1)
                <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background: #fff !important; padding: 0px !important; padding-top: 10px !important; padding-bottom: 10px !important">
                    <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background: hsla(0,0%,88%,.95) !important; padding: 10px !important">
                        <div class="col col-md-2 col-sm-2 col-xs-2 col-lg-2" style="text-align: left !important; padding: 0px !important; padding: 0px !important; padding-left: 15px !important;">
                            <i class="fas fa-university stroke-transparent" style="color: #fff !important; font-size: 14px !important;"></i>
                        </div>
                        <div class="col col-md-10 col-sm-10 col-xs-10 col-lg-10" style="padding: 0px !important">
                            <a onclick="handleNextSendToSelectedPaymentOption(4)" style="color: #337ab7 !important; cursor: pointer !important">Pay Using Online Banking</a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding: 15px !important">
                <a class="" href="javascript:history.back(-3)">Cancel Payment</a>
            </div>
    </div>

</div>



<script>

    function handleNextSendToSelectedPaymentOption(x)
    {
        if(x==0)
        {
           loadBevuraWalletPaymentDetails('2001', '{{$input}}');
        }
        if(x==1)
        {
           loadMastercardPaymentDetails('2001', '{{$input}}');
        }
        if(x==2)
        {
           loadMobileMoneyPaymentDetails('2001', '{{$input}}');
        }
        if(x==3)
        {
           loadCyberSourcePaymentDetails('2001', '{{$input}}');
        }
        if(x==4)
        {
           loadOnlineBankingPaymentDetails('2001', '{{$input}}');
        }
    }


</script>
