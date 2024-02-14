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


input[type='number'] {
    -moz-appearance:textfield;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}
</style>


<div class="holder">
    <div class="reserve-box mt-30">
        <h5>Bevura</h5>
        <div style="background-color: #fff !important;" class="col-md-12">
            <div class="row mt-10 mb-30">
                <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">

                    <div class="submite-list-wrapper">

                        <div class="row">

                            <div class="col-md-12">

                                <div class="">

                                    <h4 style="padding-bottom: 0px !important; margin-bottom:0px !important"><span><strong>{{isset($input['currency']) ? $input['currency'] : "ZMW"}}{{number_format($totalAmount, 2, '.', ',')}}</strong></span></h4>
                                    <label style="font-weight: 100 !important; font-size: 12px"><strong>Order Id:</strong> {{strtoupper(join('-', str_split($input['orderId'], 4)))}}</label>

                                </div>

                            </div>

                        </div>
                        <div class="submite-list-box">
                            @if($key==OTP_COLLECTION_VIEW)
                                <form action="/payments/process-web-eagle-process-otp" method="post" enctype="application/x-www-form-urlencoded">
                            @elseif($key==WALLET_OTP_COLLECTION_VIEW)
                                <form action="/payments/process-wallet-process-otp" method="post" enctype="application/x-www-form-urlencoded">
                            @endif
                                <input type="hidden" name="data" value="{{$data}}">
                                <div class="row">

                                    <div class="col-xs-12 col-sm-12 mb-30-xs">

                                        <div class="row gap-20">



                                            <div class="col-xs-12 col-sm-12 col-md-12">

                                                <div class="form-group" style="padding-top:10px !important">
                                                    <label style="font-weight: 100 !important">One-Time Password</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                                        <input type="number" maxlength="16" size="16" name="otp" required class="form-control" style="
                                                           opacity: .8;
                                                           cursor: text;
                                                           -webkit-transition: all ease-out 120ms;
                                                           -o-transition: all ease-out 120ms;
                                                           transition: all ease-out 120ms;
                                                           z-index: 50000;" placeholder="Your OTP"/>
                                                    </div>
                                                </div>

                                            </div>



                                            <div class="col-xs-12 col-sm-12">

                                                <!--<div class="checkbox-block font-icon-checkbox">
                                                    <input id="reserve_accept-1" name="reserve_accept" type="checkbox" class="checkbox" />
                                                    <label class="" for="reserve_accept-1">Yes, I want to receive marketing email messages from this restuarant.</label>
                                                </div>

                                                <div class="checkbox-block font-icon-checkbox">
                                                    <input id="reserve_accept-2" name="reserve_accept" type="checkbox" class="checkbox" />
                                                    <label class="" for="reserve_accept-2">Repulsive questions contented him few extensive supported.</label>
                                                </div>-->

                                                <button class="btn btn-success col-md-12 mt-15" name="submitButton" value="Pay">Pay Now</button>
                                                <a href="javascript:history.back(-3)" class="btn btn-danger col-md-12 mt-15">Cancel Payment</a>

                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </form>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
