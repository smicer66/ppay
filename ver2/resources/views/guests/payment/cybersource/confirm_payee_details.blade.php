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


label{
    padding-top: 15px !Important
}


</style>

<body onload="javascript:document.payment_confirmation.submit()">
<div class="holder" style="border: 0px solid #000">
    <div class="reserve-box mt-30" style="position: relative !important; border: 0px double #EBE9E8; margin-bottom: 0px !important">
        <div style="clear: both !important; padding-left: 0px !important; padding-right: 0px !important" class="container-fluid invoice-container" id="section-to-print" style="margin-left:0px !important; margin-right: 0px !important;">
            @include('partials.errors')
            <form name="payment_confirmation" id="payment_confirmation" action="https://testsecureacceptance.cybersource.com/pay" method="post"/>

                <fieldset id="confirmation">
                    <!--<legend>Review Payment Details</legend>
                    <div>
                        <?php
                            foreach($params as $name => $value) {
                                if($name!='submit')
                                {
                                    echo "<div>";
                                    echo "<span class=\"fieldName\">" . $name . "</span><span class=\"fieldValue\">" . $value . "</span>";
                                    echo "</div>\n";
                                }
                            }
                        ?>
                    </div>-->
                </fieldset>
                    <?php
                        foreach($params as $name => $value) {
                            if($name!='submit')
                            {
                                echo "<input type=\"hidden\" id=\"" . $name . "\" name=\"" . $name . "\" value=\"" . $value . "\"/>\n";
                            }
                        }
                        echo "<input type=\"hidden\" id=\"signature\" name=\"signature\" value=\"" . signData(buildDataToSign($params), \UserConstants::$DEMO_CYBERSOURCE_CONSTANT) . "\"/>\n";
                    ?>
                <!--<input type="submit" id="submit" value="Confirm"/>-->
            </form>
    </div>

</div>
</body>

<!-- JS -->
<!----><script type="text/javascript" src="/v2/js/jquery-2.2.4.min.js"></script>
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
<script>
var payoption = 0;
var payoptions = {};
var path = window.location.href;
path = path.split('/');
payoptions['Pay using a VISA Debit/Credit Card'] = '/ajax-payment-details-cyb.html/0001/' + path[path.length-1];
payoptions['Pay using Mobile Money'] = '/ajax-payment-details-mobile-money.html/0001/' + path[path.length-1];
payoptions['Pay using Online Banking'] = '/ajax-payment-details-online-banking.html/0001/' + path[path.length-1];

</script>
