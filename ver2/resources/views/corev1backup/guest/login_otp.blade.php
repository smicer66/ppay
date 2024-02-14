<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') | </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css?aks=23">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css?as=23">

    <link rel="stylesheet" href="/css/bootstrap.min.css?f=333">
    <link href="/bootstraptour/css/bootstrap-tour-standalone.min.css?kss=2212" rel="stylesheet">

    <link rel="stylesheet" href="/css/login.css?f=333">
    <script src="/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/bootstraptour/js/bootstrap-tour-standalone.min.js?kal=211"></script>
    
</head>
<body></body>
<section class="login-form-wrap">
    <h1><strong>ProbasePay</strong></h1>
    @include('partials.errors')
    <form class="login-form" method="post" action="/auth/otp-login">
        <!--<label style="margin-bottom:0px !important; display:block !important;">
            <input type="text" name="otp" required placeholder="Please Provide" value="">
        </label>-->
        <label style="margin-bottom:0px !important; display:block !important; font-size:15px; color:#fff">
            One Time Password
        </label>
        <div class="col col-md-12" style="clear:both; padding: 3px !important">&nbsp;</div>
        <label class="col col-md-3" style="padding-left: 0px !important; padding-right: 1px !important; margin-bottom:0px !important; display:block !important;">
            <input required maxlength=1 type="tel" class="col col-md-12" name="otp1" id="otp1" required style="padding: 6px; text-align: center" placeholder="">
        </label>
        <label class="col col-md-3" style="padding-left: 1px !important; padding-right: 1px !important; margin-bottom:0px !important; display:block !important;">
            <input required maxlength=1 type="tel" class="col col-md-12" name="otp2" id="otp2" required style="padding: 6px; text-align: center" placeholder="">
        </label>
        <label class="col col-md-3" style="padding-left: 1px !important; padding-right: 1px !important; margin-bottom:0px !important; display:block !important;">
            <input required maxlength=1 type="tel" class="col col-md-12" name="otp3" id="otp3" required style="padding: 6px; text-align: center" placeholder="">
        </label>
        <label class="col col-md-3" style="padding-left: 1px !important; padding-right: 0px !important; margin-bottom:0px !important; display:block !important;">
            <input required maxlength=1 type="tel" class="col col-md-12" name="otp4" id="otp4" required style="padding: 6px; text-align: center" placeholder="">
        </label>
        <div class="col col-md-12" style="clear:both; padding: 3px !important">&nbsp;</div>
        <input type="hidden" name="token" value="{{$token}}">
        <input type="submit" value="Login">
        <input type="submit" value="Resend Token">
    </form>
    <h5><a href="/auth/login">Re-Login Again</a></h5>
</section>

<script>
	
jQuery('document').ready(function () {
	document.getElementById("otp1").focus();
	
});

jQuery('#otp1').keyup(function () {
    var inputVal = $(this).val();
	//var characterReg = /^[0-9]{5}$/; 	
	console.log(inputVal);
	if (inputVal.length>0) {
		document.getElementById("otp2").focus();
	}
});
jQuery('#otp2').keyup(function () {
	var inputVal = $(this).val();
	//var characterReg = /^[0-9]{5}$/; 		
	console.log(inputVal);						
	if (inputVal.length>0) {
		document.getElementById("otp3").focus();
	}
});
jQuery('#otp3').keyup(function () {
	var inputVal = $(this).val();
	//var characterReg = /^[0-9]{5}$/; 
	console.log(inputVal);								
	if (inputVal.length>0) {
		document.getElementById("otp4").focus();
	}
});
jQuery('#otp4').keyup(function () {
	var inputVal = $(this).val();
	//var characterReg = /^[0-9]{5}$/; 	
	console.log(inputVal);							
	if (inputVal.length>0) {
		document.getElementById("registerbutton").focus();
	}
});
</script>