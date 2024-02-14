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

<div class="holder" style="border: 0px solid #000">
    <div class="reserve-box mt-30" style="border: 0px double #EBE9E8; background-color: #f7f7f7 !important; padding-bottom: 15px !important; position: relative !important; border: 0px double #EBE9E8; margin-bottom: 0px !important">
        <div class="col-xs-12 col-sm-12 col-lg-12 col-md-12" style="text-transform: uppercase;
            background: #DB3944;
            color: #FFF;
            line-height: 1;
            margin: 0;
            margin-top: -3px;
            padding: 15px 23px; ">
            <div style="float: left !important; " class="col col-md-5 col-sm-5 col-lg-5 col-xs-5"><h5 style="padding: 0px !Important; margin-top: 0px !important; float: left !important">ProbasePay</h5></div>
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
                            <strong>A new Bevura account has been created for you.</strong></br>
                            We have sent you a code to activate your new Bevura account when next you login to make a payment
                            <br><a href="/ajax-payment-details.html/{{PAYMENT_DETAILS_LISTING}}/{{$input}}">Proceed to my payment</a>
                        </center>
                </div>
</div>





<script>


function loginToPay()
{
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
                    console.log(window.location);
                    logoutUser('Your session has ended. Please log in to continue', window.location.href);
                }
                else
                {
                    toastr.error(data1.message);
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


$("#country").on('change', function () {
	var $this = $(this);
	var province = $("#province");
	var district = $("#district");
	var countryId = $(this).val();
	//lga.html('loading...');
	$("#province").empty();
	$("#district").empty();
	district.prepend($('<option>', {
		text: '-Select District-',
		value: null
	}));

	province.prepend($('<option selected>', {
		text: 'Loading provinces...Please Wait',
		value: null
	}));
	$.ajax({
		url: '/utility/services/pull-province/' + countryId,
		dataType: 'json',
		success: function (resp) {
			if (resp.status === 1) {
				$("#province").empty();
				$("#district").empty();
				province.append($('<option>', {
					text: '-Select A Province-',
					value: null
				}));
				$.each(resp.data, function (k, v) {
					province.append($('<option>', {
						value: k + '_' + v,
						text: v
					}));
				});
			}
		},
		complete: function () {
			$this.removeClass('disabled');
			$("#province").removeClass('disabled');
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
