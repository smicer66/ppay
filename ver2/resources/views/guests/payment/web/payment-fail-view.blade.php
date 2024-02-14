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
</style>
<!--<div class="pull-right" style="padding-right: 30px; padding-top:5px;">
	<a href="javascript:closeModals()"><i class="fa fa-close"></i></a>
</div>-->



<div class="holder">
    <div class="reserve-box mt-30" style="border: 0px double #EBE9E8; background-color: #f7f7f7 !important; padding-bottom: 15px !important;">
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
            <form action="/api/login-to-pay" id="loginToPayForm" method="post" enctype="application/x-www-form-urlencoded">
                <input type="hidden" name="orderId" value="{{$orderRef}}">
                <input type="hidden" name="data" value="{{$input}}">
                <div class="panel panel-default" style="background-color: #f7f7f7 !important">


                    <div class="col-xs-12 col-sm-12" style="cursor: pointer; background-color: #f7f7f7 !important">
                        <div style="text-align: right !Important; font-weight: bold !important">{{$currency}}{{number_format($totalAmount, 2, '.', ',')}}</div>

                        <div class="row gap-20">
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="text-align: center;">
                                    <center>
                                        <img src="/img/red-fail.jpg"  class="img-responsive" style="width: 30%">
                                        <h3 style="color: #66e02d">Payment Was Not Successful</h3>
                                    </center>
                            </div>
                        </div>

                    </div>

                </div>
            </form>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-12" style="clear: both !important; text-align: left; background-color: #fff !important; padding-top: 15px !important; padding-bottom:30px !Important">
            <span>
            <strong>You tried to pay {{$currency}}{{number_format($totalAmount, 2, '.', ',')}} to the merchant</strong></br>
            {{$merchant_name}}<br><br>

            <strong>Payment Details</strong><br>
            Order Ref: {{$orderRef}}<br>
            Payment Channel: {{$channel}}<br><br>

    </div>
</div>


<!--
<script type="text/javascript" src="/v2/js/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="/v2/js/jquery-migrate-1.4.1.min.js"></script>
<script type="text/javascript" src="/v2/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/v2/js/SmoothScroll.min.js"></script>
<script type="text/javascript" src="/v2/js/jquery.waypoints.min.js"></script>
<script type="text/javascript" src="/v2/js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="/v2/js/jquery.slicknav.min.js"></script>
<script type="text/javascript" src="/v2/js/spin.min.js"></script>
<script type="text/javascript" src="/v2/js/jquery.introLoader.min.js"></script>
<script type="text/javascript" src="/v2/js/fancySelect.js"></script>
<script type="text/javascript" src="/v2/js/bootstrap-rating.js"></script>
<script type="text/javascript" src="/v2/js/select2.full.js"></script>
<script type="text/javascript" src="/v2/js/slick.min.js"></script>
<script type="text/javascript" src="/v2/js/jquery.placeholder.min.js"></script>
<script type="text/javascript" src="/v2/js/ion.rangeSlider.min.js"></script>
<script type="text/javascript" src="/v2/js/readmore.min.js"></script>
<script type="text/javascript" src="/v2/js/bootstrap-modalmanager.js"></script>
<script type="text/javascript" src="/v2/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="/v2/js/instagram.min.js"></script>
<script type="text/javascript" src="/v2/js/bootstrap3-wysihtml5.min.js"></script>
<script type="text/javascript" src="/v2/js/customs.js?x=1"></script>
<script type="text/javascript" src="/v2/js/customs-reservation.js"></script>
<script type="text/javascript" src="/js/action.js"></script>-->


<script>




$(document).ready(function(){
    
    console.log(444);
    console.log("");
    var status = "{{$responseData['status']==100 ? 0 : $responseData['status']}}";

	counter = 10;
	setInterval(function() {
		html = '';
		
                                        
			html = html + '<img src="/img/red-fail.jpg"  class="img-responsive" style="width: 30%">';
              	html = html + '<h3 style="color: #66e02d">Payment Was Not Successful</h3>';
              	html = html + '<div style="color: #000">Redirecting to merchant site <br>in '+ counter +' seconds</div>';
			if(counter<1)
			{
				counter = 0;
			}
			else
			{
				counter = counter - 1;
			}
			$('#countdown').html(html);
		
	}, 1000);
    var success = "{{$responseData['success']}}";
    var order_ref = "{{$responseData['order_ref']}}";
    var txn_ref = "{{$responseData['txn_ref']}}";
    var merchant_id = "{{$responseData['merchant_id']}}";
    var merchant_name = "{{$responseData['merchant_name']}}";
    var channel = "{{$responseData['channel']}}";
    var customer_mobile_number = null;
    var customer_email_address = null;
    @if(isset($responseData['customer_mobile_number']) && $responseData['customer_mobile_number']!=null)
        customer_mobile_number = "{{$responseData['customer_mobile_number']}}";
    @endif
    @if(isset($responseData['customer_email_address']) && $responseData['customer_email_address']!=null)
        customer_email_address = "{{$responseData['customer_email_address']}}";
    @endif

    var device_code = "{{$responseData['device_code']}}";
    var transaction_date = "{{$responseData['transaction_date']}}";
    var auto_return_to_merchant = {{$responseData['auto_return_to_merchant']}};
    var return_url = "{{$responseData['return_url']}}";
    var paying_info  = null;
    @if(isset($responseData['paying_info']) && $responseData['paying_info']!=null)
        paying_info = '{!!json_encode($responseData['paying_info'])!!}';
    @endif

    var returnResp = {};
    returnResp['status'] = status;
    returnResp['success'] = success;
    returnResp['order_ref'] = order_ref;
    returnResp['txn_ref'] = txn_ref;
    returnResp['merchant_code'] = merchant_id;
    returnResp['device_code'] = device_code;
    returnResp['merchant_name'] = merchant_name;
    returnResp['channel'] = channel;
    returnResp['customer_mobile_number'] = customer_mobile_number;
    returnResp['customer_email_address'] = customer_email_address;
    returnResp['device_code'] = device_code;
    returnResp['transaction_date'] = transaction_date;
    returnResp['auto_return_to_merchant'] = auto_return_to_merchant===1 ? true : false;
    returnResp['return_url'] = return_url;


   console.log(returnResp);

    /**/timer = setTimeout(function(){ 
        var windowOrigin        = location.origin;
        console.log(windowOrigin);
        window.parent.postMessage(JSON.stringify(returnResp), '*');
    }, 1000);
});

</script>
