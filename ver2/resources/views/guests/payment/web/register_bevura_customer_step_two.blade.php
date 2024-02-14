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
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

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
    <div class="reserve-box mt-30" style="position: relative !important; border: 0px double #EBE9E8; margin-bottom: 0px !important">
        <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="text-transform: uppercase;
            background: #DB3944;
            color: #FFF;
            line-height: 1;
            margin: 0;
            margin-top: -3px;
            padding: 15px 23px; ">
            <div style="float: left !important; " class="col col-md-5 col-sm-5 col-lg-5 col-xs-5"><h5 style="padding: 0px !Important; margin-top: 0px !important; float: left !important">Bevura</h5></div>
		@if($key!=WALLET_ACCESS)
            		<div style="float: right !important; text-align:right !Important; font-size: 11px !important; padding: 0px !important;" class="col col-md-7 col-sm-7 col-lg-7 col-xs-7"><h4 style="margin-bottom: 0px;">Add A Bevura Wallet</h4><!--<small>{{strtoupper($orderId)}}<br>Order Ref</small>--></div>
		@endif

        </div>
        <div style="clear: both !important; padding-left: 0px !important; padding-right: 0px !important" class="container-fluid invoice-container" id="section-to-print">
            @include('partials.errors')
            <form id="createNewCustomerWallet" method="post" enctype="application/x-www-form-urlencoded">
                <input type="hidden" name="orderId" value="{{$orderId}}">
                <input type="hidden" name="data" value="{{$data}}">
                <input type="hidden" name="accountCurrency" id="accountCurrency" value="ZMW">
                <input type="hidden" name="accountType" id="accountType" value="VIRTUAL">
                <input type="hidden" name="addNewAccountCustomerVerificationNumber" id="addNewAccountCustomerVerificationNumber" value="{{\Auth::user()->customerVerificationNo}}">
                <!--<input type="hidden" name="addNewAccountMerchantCode" id="addNewAccountMerchantCode" value="{{PROBASEWALLET_MERCHANT_CODE}}">
                <input type="hidden" name="addNewAccountDeviceCode" id="addNewAccountDeviceCode" value="{{PROBASEWALLET_DEVICE_CODE}}">-->
                <input type="hidden" name="addNewAccountMerchantCode" id="addNewAccountMerchantCode" value="{{$bioData['merchantId']}}">
                <input type="hidden" name="addNewAccountDeviceCode" id="addNewAccountDeviceCode" value="{{$bioData['deviceCode']}}">

                <div class="panel panel-default">


                    <div class="col-xs-12 col-sm-12" style="cursor: pointer">
                        <div style="text-align: left !Important; font-weight: 100 !important; background-color: #bce8f1 !important; border-radius: 10px !important; padding: 5px !important; padding-left: 10px !important; margin-top: 10px !important;"><!--<h4>Add A Bevura Wallet</h4>-->Items with red asterisk(<span style="color: red">*</span>) must be provided</div>


                        <div class="row gap-20">
				<div class="bg-danger col-xs-12 col-sm-12 col-md-12 col-lg-12 notificationReceived" style="display: none !important" id="dangerNotification">
					
				</div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group" style="padding-top:10px !important">





				<div class="input-group  col col-md-12 col-sm-12 col-xs-12  col-lg-12" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                    <label style="font-weight: 100 !important">Email Address</label>
                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background-color: #EBEBEB; padding-right: 0px !Important; padding-left: 0px !Important">
                                        <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                        <input type="email" name="email" id="email" required class="form-control " style="
                                           opacity: .8;
                                           cursor: text;
                                           background-color: #fff !important;
                                           -webkit-transition: all ease-out 120ms;
                                           -o-transition: all ease-out 120ms;
                                           transition: all ease-out 120ms;
                                           z-index: 50000;" placeholder="Provide if you have one"  
						 value="{{isset($bioData) && $bioData!=null && isset($bioData['emailAddress']) && $bioData['emailAddress']!=null ? $bioData['emailAddress'] : ''}}" />
                                        </div>
                                    </div>
				</div>


				<div class="input-group  col col-md-12 col-sm-12 col-xs-12  col-lg-12" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                    <label style="font-weight: 100 !important">What country do you live in?<span style="color: red">*</span></label>
                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background-color: #EBEBEB; padding-right: 0px !Important; padding-left: 0px !Important">
                                        <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                        <select name="country" id="countryCustomerLivesIn" class="form-control" style="border: 0px !important; background: transparent !important">
                                            <option value= class="login-option">--Select One--</option>
                                            @foreach($countries as $country)
							@if(isset($bioData) && $bioData!=null && isset($bioData['countryId']) && $bioData['countryId']!=null && $bioData['countryId']==$country['id'])
                                            		<option value="{{$country['id']}}" selected="selected" class="login-option">{{$country['name']}}</option>
							@else
                                            		<option value="{{$country['id']}}" class="login-option">{{$country['name']}}</option>
							@endif
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
				</div>

				<div class="input-group  col col-md-12 col-sm-12 col-xs-12  col-lg-12" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                    <label style="font-weight: 100 !important">Your Home Address<span style="color: red">*</span></label>
                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-left: 0px !Important; background-color: #EBEBEB; padding-right: 0px !Important">

                                        <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-left: 0px !Important; padding-right: 0px !Important">
                                        <input type="text" maxlength="100" id="homeAddress" name="homeAddress" required class="form-control " style="
                                           opacity: .8;
                                           cursor: text;
                                           background-color: #fff !important;
                                           -webkit-transition: all ease-out 120ms;
                                           -o-transition: all ease-out 120ms;
                                           transition: all ease-out 120ms;
                                           z-index: 50000;" placeholder="example No 10 Alpha Crescent" 
						 value="{{isset($bioData) && $bioData!=null && isset($bioData['homeAddress']) && $bioData['homeAddress']!=null ? $bioData['homeAddress'] : ''}}"
						/>
                                        </div>
                                    </div>
				</div>


				<div class="input-group  col col-md-5 pull-left  col-sm-5 col-xs-5 col-lg-5" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                    <label style="font-weight: 100 !important">City<span style="color: red">*</span></label>
                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background-color: #EBEBEB; padding-right: 0px !Important; padding-left: 0px !Important">
                                        <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                        <input type="text" name="city" id="city" required class="form-control " style="
                                           opacity: .8;
                                           cursor: text;
                                           background-color: #fff !important;
                                           -webkit-transition: all ease-out 120ms;
                                           -o-transition: all ease-out 120ms;
                                           transition: all ease-out 120ms; 
                                           z-index: 50000;" placeholder="City you live in"  
						 value="{{isset($bioData) && $bioData!=null && isset($bioData['city']) && $bioData['city']!=null ? $bioData['city'] : ''}}" />
                                        </div>
                                    </div>
				</div>


				<div class="input-group  col col-md-5 pull-right col-sm-5 col-xs-5 col-lg-5" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                    <label style="font-weight: 100 !important">District<span style="color: red">*</span></label>
                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background-color: #EBEBEB; padding-right: 0px !Important; padding-left: 0px !Important">
                                        <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                        <select name="district" id="district" class="form-control disabled" style="border: 0px !important; background: transparent !important">
							<option value= class="login-option">--Select Your Country First--</option>
                                        </select>
                                        </div>
                                    </div>
				</div>



				<div class="input-group  col col-md-5 pull-left  col-sm-5 col-xs-5 col-lg-5" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                    <label style="font-weight: 100 !important">Date of Birth<span style="color: red">*</span></label>
                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background-color: #EBEBEB; padding-right: 0px !Important; padding-left: 0px !Important">
                                        <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                        <input type="date" name="dateOfBirth" id="dateOfBirth" required class="form-control " style="
                                           opacity: .8;
                                           cursor: text;
                                           background-color: #fff !important;
                                           -webkit-transition: all ease-out 120ms;
                                           -o-transition: all ease-out 120ms;
                                           transition: all ease-out 120ms;
                                           z-index: 50000;" placeholder="YYYY-MM-DD"  
						 value="{{isset($bioData) && $bioData!=null && isset($bioData['dateOfBirth']) && $bioData['dateOfBirth']!=null ? $bioData['dateOfBirth'] : ''}}" />
                                        </div>
                                    </div>
				</div>


				<div class="input-group  col col-md-5 pull-right  col-sm-5 col-xs-5  col-lg-5" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                    <label style="font-weight: 100 !important">Gender<span style="color: red">*</span></label>
                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background-color: #EBEBEB; padding-right: 0px !Important; padding-left: 0px !Important">
                                        <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                        <select name="gender" id="gender" class="form-control disabled" style="border: 0px !important; background: transparent !important">
                                            <option value=>--Select One--</option>
                                            <option value="FEMALE" {{isset($bioData) && $bioData!=null && isset($bioData['gender']) && $bioData['gender']!=null && $bioData['gender']=="FEMALE" ? 'selected' : ''}}>Female</option>
                                            <option value="MALE" {{isset($bioData) && $bioData!=null && isset($bioData['gender']) && $bioData['gender']!=null && $bioData['gender']=="MALE" ? 'selected' : ''}}>Male</option>
                                        </select>
                                        </div>
                                    </div>
				</div>


				<div class="input-group  col col-md-5 pull-left  col-sm-5 col-xs-5  col-lg-5" style="padding-right: 0px !Important; padding-left: 0px !Important">
					@if(isset($bioData) && $bioData!=null && isset($bioData['meansOfIdentificationNumber']) && $bioData['meansOfIdentificationNumber']!=null)
					<label style="font-weight: 100 !important">Identification Type<span style="color: red">*</span></label>
					<div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                        <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                        {{str_replace("_", " ", $bioData['meansOfIdentification'])}}
						<input type="hidden" name="meansOfIdentification" id="meansOfIdentification" value="{{$bioData['meansOfIdentification']}}">
                                        </div>
                                    </div>
					@else
                                    <label style="font-weight: 100 !important">Identification Type<span style="color: red">*</span></label>
                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="background-color: #EBEBEB; padding-right: 0px !Important; padding-left: 0px !Important">
                                        <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                        <select name="meansOfIdentification" id="meansOfIdentification" class="form-control disabled" style="border: 0px !important; background: transparent !important">
                                            <option value=>--Select One--</option>
                                            <option value="NRC" {{isset($bioData) && $bioData!=null && isset($bioData['meansOfIdentification']) && $bioData['meansOfIdentification']!=null && $bioData['meansOfIdentification']=="NRC" ? 'selected' : ''}}>National ID Card</option>
                                            <option value="INTERNATIONAL_PASSPORT" {{isset($bioData) && $bioData!=null && isset($bioData['meansOfIdentification']) && $bioData['meansOfIdentification']!=null && $bioData['meansOfIdentification']=="INTERNATIONAL_PASSPORT" ? 'selected' : ''}}>International Passport</option>
                                            <!--<option value="DRIVERS_LICENSE" {{isset($bioData) && $bioData!=null && isset($bioData['meansOfIdentification']) && $bioData['meansOfIdentification']!=null && $bioData['meansOfIdentification']=="DRIVERS_LICENSE" ? 'selected' : ''}}>Drivers License</option>-->
                                        </select>
                                        </div>
                                    </div>
					@endif
				</div>

				<div class="input-group  col col-md-5 pull-right  col-sm-5 col-xs-5  col-lg-5" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                    
					@if(isset($bioData) && $bioData!=null && isset($bioData['meansOfIdentificationNumber']) && $bioData['meansOfIdentificationNumber']!=null)
                                    <label style="font-weight: 100 !important">Id Number</label>
					<div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                        <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding: 6px 12px; !important">
                                        {{$bioData['meansOfIdentificationNumber']}}
						<input type="hidden" name="identityNumber" id="identityNumber" class="form-control " style="
                                           opacity: .8;
                                           cursor: text;
                                           background-color: #fff !important;
                                           -webkit-transition: all ease-out 120ms;
                                           -o-transition: all ease-out 120ms;
                                           transition: all ease-out 120ms;
                                           z-index: 50000;" placeholder="NRC/Passport number"  
						
						 value="{{isset($bioData) && $bioData!=null && isset($bioData['meansOfIdentificationNumber']) && $bioData['meansOfIdentificationNumber']!=null ? $bioData['meansOfIdentificationNumber'] : ''}}" />
                                        </div>
                                        </div>
                                    </div>
					@else
					<div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                        <label style="font-weight: 100 !important">Id Number<span style="color: red">*</span></label>
					     <div class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-right: 0px !Important; padding-left: 0px !Important">
                                        <input type="text" name="identityNumber" id="identityNumber" required class="form-control " style="
                                           opacity: .8;
                                           cursor: text;
                                           background-color: #fff !important;
                                           -webkit-transition: all ease-out 120ms;
                                           -o-transition: all ease-out 120ms;
                                           transition: all ease-out 120ms;
                                           z-index: 50000;" placeholder="NRC/Passport number"  
						
						 value="" />
                                        </div>
                                    </div>
					@endif
				</div>


                                    <!--<div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-top: 10px !Important; padding-left: 0px !Important">

                                    </div>-->

                                    <div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-top: 10px !Important; padding-left: 0px !Important; padding-right: 0px !Important">
                                        <a onclick="createNewCustomerWalletForBillPayment('createNewCustomerWallet', '{{\Session::get('jwt_token')}}', '{{$data}}', '{{$orderId}}', '{{$key}}')" class="btn btn-primary mt-15 col-md-12 col-lg-12 col-sm-12 col-xs-12" name="submitButton" value="Create Account">Create My Wallet <i class="fa fas fa-angle-double-right"></i></a>
                                        <div href="" class="col col-md-12 col-sm-12 col-xs-12 col-lg-12" style=" font-size: 90%; text-align: center !important">
                                            <small>By clicking, you agree to Bevura's Terms</small>
                                        </div>


                                        <!--<a class="" href="javascript:history.back(-3)" style="font-size: 90%; float: left !important">Cancel Payment</a>-->
    <!--<input type="submit">-->
                                    </div>
                                    <!--<div class="input-group  col col-md-12 col-sm-12 col-xs-12 col-lg-12" style="padding-left: 0px !Important">
                                    </div>-->


                                </div>

                            </div>
                        </div>

                    </div>

                </div>
			<input type="hidden" name="key" id="key" value="{{$key}}">
            </form>

		@if($key!=WALLET_ACCESS && $key!=TOKENIZE)
            <!--<div class="" style="clear: both !important; bottom: 0px; color: #ffcc00 !important; padding-right: 0px !important">
                <div class="col col-md-10 col-sm-10 col-xs-10" style="background-color:#000000 !important; padding: 10px !important" id="payoptiontitle">
                    <a href="/ajax-payment-details-cyb.html/0001/{{$input}}" style="color: #ffcc00 !important; "><i class="fa fa-angle-double-right" aria-hidden="true"></i> Pay using a VISA Debit/Credit Card</a>
                </div>
                <div class="payoptions col col-md-2 col-sm-2 col-xs-2" style="text-align: center !important; background-color:#ffcc00 !important; color: #000000 !important; padding: 10px !important">
                    <i class="fa fa-angle-double-right" aria-hidden="true" style="cursor: pointer !important; font-size: 16px !important"></i>
                </div>
            </div>-->
		@endif
    </div>

</div>


<!-- JS -->
<!--<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/jquery-migrate-1.4.1.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/bootstrap/js/bootstrap.min.js"></script>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/bootstrap-modalmanager.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/bootstrap-modal.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/instagram.min.js"></script>
<!--<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/bootstrap3-wysihtml5.min.js"></script>-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/customs.js?x=1"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/gh/smicer66/ppay/v2/js/customs-reservation.js"></script>
<script type="text/javascript" src="/js/action.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
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

function loginToPay()
{
	$('.notificationReceived').hide();
    var form = $('#loginToPayForm')[0];
    var formData = new FormData(form);
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
                            url = '/ajax-otp-collection-view.html/{{OTP_COLLECTION_VIEW}}/{{$input}}/' + data1.txn_ref;
                            console.log(url);
                             $modalDashboard.load(url, '', function(){
                                $modalDashboard.modal();
                                if(document.getElementById("loginToPayOtp1"))
                                    document.getElementById("loginToPayOtp1").focus();
                                handleNotifications();
                            });
                        }, 1000);
                    });
                }
                else if(data1.status==-1)
                {
			$('#dangerNotification').html('Your session has ended. Please log in to continue');
			$('#dangerNotification').show();
                    console.log(window.location);
                    logoutUser('Your session has ended. Please log in to continue', window.location.href);
                }
                else
                {
			$('#dangerNotification').html(data1.message);
			$('#dangerNotification').show();
                    toastr.error(data1.message);
                }

                //toastr.success(data1.message);
            }
            else
            {
			$('#dangerNotification').html(data1.message);
		 	$('#dangerNotification').show();
                	toastr.error(data1.message);
                	$('#dismissBtn').click();
                	$('#new_card_modal').show();
            }
        },
        error: function (e) {
		$('#dangerNotification').html(data1.message);
		$('#dangerNotification').show();
            toastr.error('We experienced an issue updating your merchant profile. Please try again.');
        }
    });
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




@if(isset($bioData) && $bioData!=null && isset($bioData['countryId']) && $bioData['countryId']!=null)
$(function(){
	var district = $("#district");
	var countryId = $("#countryCustomerLivesIn").val();
	//lga.html('loading...');
	$("#district").empty();
	district.prepend($('<option>', {
		text: '-Select District-',
		value: null
	}));

	district.prepend($('<option selected>', {
		text: 'Loading provinces...Please Wait',
		value: null
	}));
	$.ajax({
		url: '/utility/services/pull-district-by-country/' + countryId,
		dataType: 'json',
		success: function (resp) {
		    console.log(resp);
			if (resp.status === 1) {
				$("#district").empty();
				$.each(resp.data, function (k, v) {
				    console.log(k);
					var s1 = null;
					s1 = {{(isset($bioData) && $bioData!=null && isset($bioData['districtId']) && $bioData['districtId']!=null) ? $bioData['districtId'] : null}};
					district.append($('<option>', {
						value: k + '_' + v,
						selected: s1==k ? true : false,
						text: v
					}));
				});
			}
		},
		complete: function () {
			
		}
	});
});
@endif

$("#countryCustomerLivesIn").on('change', function () {
	var $this = $(this);
	var district = $("#district");
	var countryId = $(this).val();
	//lga.html('loading...');
	$("#district").empty();
	district.prepend($('<option>', {
		text: '-Select District-',
		value: null
	}));

	district.prepend($('<option selected>', {
		text: 'Loading provinces...Please Wait',
		value: null
	}));
	$.ajax({
		url: '/utility/services/pull-district-by-country/' + countryId,
		dataType: 'json',
		success: function (resp) {
		    console.log(resp);
			if (resp.status === 1) {
				$("#district").empty();
				$.each(resp.data, function (k, v) {
				    console.log(k);
					district.append($('<option>', {
						value: k + '_' + v,
						text: v
					}));
				});
			}
		},
		complete: function () {
			$this.removeClass('disabled');
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
