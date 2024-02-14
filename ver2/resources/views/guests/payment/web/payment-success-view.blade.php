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
                                    <center id="countdown">
                                        <img src="/img/greentick.png"  class="img-responsive" style="width: 30%">
                                        <h3 style="color: #66e02d">Payment Was Successful</h3>
                                    </center>
                            </div>
                        </div>

                    </div>

                </div>
            </form>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-12" style="clear: both !important; text-align: left; background-color: #fff !important; padding-top: 15px !important; padding-bottom:30px !Important">
            <span>
            <strong>You paid {{$currency}}{{number_format($totalAmount, 2, '.', ',')}} to the merchant</strong></br>
            {{$merchant_name}}<br><br>

            <strong>Payment Details</strong><br>
            Order Ref: {{$orderRef}}<br>
            Transaction Ref: {{$txnRef}}<br>
            Payment Channel: {{$channel}}<br><br>

            <strong>Notification Sent To:</strong><br>
            @if(isset($customer_mobile_number) && $customer_mobile_number!=null)
            Mobile Number: {{$customer_mobile_number}}<br>
            @endif
            @if(isset($customer_mobile_number) && $customer_mobile_number!=null)
            Email Address: {{$customer_email_address}}<br>
            @endif
            </span>



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

/*

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
*/



$(document).ready(function(){
    
    console.log(444);
    console.log("");

    var status = "{{$responseData['status']==100 ? 0 : $responseData['status']}}";
	counter = 10;
	setInterval(function() {
		html = '';
		
			html = html + '<img src="/img/greentick.png"  class="img-responsive" style="width: 30%">';
              	html = html + '<h3 style="color: #66e02d">Payment Was Successful</h3>';
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

	var ddd = '{{json_encode($responseData)}}';
console.log(ddd);

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
    returnResp['paying_info'] = paying_info;
    


	console.log(returnResp);
    timer = setTimeout(function(){ 
        var windowOrigin        = location.origin;
        console.log(windowOrigin);
        window.parent.postMessage(JSON.stringify(returnResp), '*');
    }, 1000);
});

</script>
