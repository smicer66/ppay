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
    /*width: calc((100vw - 60%)/2) !important;
    margin-left: calc((100vw - 30%)/2) !important;*/
}
</style>
<!--<div class="pull-right" style="padding-right: 30px; padding-top:5px;">
	<a href="javascript:closeModals()"><i class="fa fa-close"></i></a>
</div>-->



<div class="holder" style="border: 0px solid #000">
    <div class="reserve-box mt-30" style="border: 0px double #EBE9E8; background-color: #f7f7f7 !important; padding-bottom: 15px !important; position: relative !important; border: 0px double #EBE9E8; margin-bottom: 0px !important">
        <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="text-transform: uppercase;
            background: #DB3944;
            color: #FFF;
            line-height: 1;
            margin: 0;
            margin-top: -3px;
            padding: 15px 23px; ">
            <div style="float: left !important; " class="col col-md-5 col-sm-5 col-lg-5 col-xs-5"><h5 style="padding: 0px !Important; margin-top: 0px !important; float: left !important">Bevura</h5></div>
		@if(isset($key) && $key!="040")
            <div style="float: right !important; text-align:right !Important; font-size: 11px !important" class="col col-md-7 col-sm-7 col-lg-7 col-xs-7">&nbsp;</div>
		@endif
        </div>
        <div style="clear: both !important" class="container-fluid invoice-container" id="section-to-print">
            @include('partials.errors')
            <form action="/api/login-to-pay" id="loginToPayForm" method="post" enctype="application/x-www-form-urlencoded">
		  <div class="panel panel-default" style="background-color: #f7f7f7 !important">


                    <div class="col-xs-12 col-sm-12" style="cursor: pointer; background-color: #f7f7f7 !important">

                        <div class="row gap-20">
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="text-align: center;">
                                    <center>
                                        <img src="/img/greentick.png"  class="img-responsive" style="width: 30%">
                                    </center>
                            </div>
                        </div>

                    </div>


                </div>
            </form>
        </div>
    </div>
                <div class="col-xs-12 col-sm-12 col-md-12" style="clear: both !important; text-align: left; background-color: #fff !important; padding-top: 15px !important;">

                        <center>

                            <strong>Tokenization Complete!</strong></br>
                            Tokens have been sent to the merchant </br>

                        </center>
			   <center id="countdown">
			   </div>
                </div>
</div>

