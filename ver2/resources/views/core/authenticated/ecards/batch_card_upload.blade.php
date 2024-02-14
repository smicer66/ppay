@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | New Merchant @stop

@section('content')

@include('partials.errors')


<div class="content-box">


	<div class="element-wrapper">
		<div class="element-box">
			<div>
				<div class="steps-w">
					<div class="step-triggers">
						<a class="step-trigger active" href="#stepContent1">Step One: Download Template</a>
						<a class="step-trigger" href="#stepContent2">Step Two: Upload Card Batch</a>
					</div>
					<div class="step-contents">
						<div class="step-content active" id="stepContent1">
							<div class="form-group col-md-12 col-sm-12 col-lg-12" style="text-align: center !important">
                                <label for="inputEmail3" class="col-sm-12 control-label">
                                    <a href="/files/batch_card_template.xlsx" class="btn btn-lg btn-success pull-left"><i class="fa fa-download"></i> Download Template</a>
                                </label>
                            </div>
                            <div class="form-group col-md-12 col-sm-12 col-lg-12" style="text-align: center !important">
								<div class="form-buttons-w text-right">
									<a class="btn btn-primary step-trigger-btn" onclick="goToStep('stepContent3', event)" style="cursor: pointer !important;"> Next</a>
								</div>
                            </div>
						</div>
						<div class="step-content" id="stepContent2">
                            
							<form enctype="multipart/form-data" action="/potzr-staff/ecards/batch-card-upload-v2" id="batchUploadStepTwo" data-toggle="validator" action="" method="post">
								
                                <label for="inputEmail3" class="col-sm-12 control-label">
                                    <div class="col col-md-4">
                                        <label for="">Issuer:<span style="color:red !important">*</span></label>
                                        <select required name="issuer" class="form-control">
                                            <option value>-Select Issuer-</option>
                                            @foreach($allIssuers as $issuer)
                                            <option value="{{$issuer->id}}">{{$issuer->issuerName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col col-md-4" style="padding-top: 10px !important;">
                                        <label for="">Acquirer:<span style="color:red !important">*</span></label>
                                        <select required name="acquirer" class="form-control">
                                            <option value>-Select Acquirer-</option>
                                            @foreach($allAcquirers as $acquirer)
                                            <option value="{{$acquirer->id}}">{{$acquirer->acquirerName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col col-md-4" style="padding-top: 20px !important">
                                        <label for="">Select Batch File:<span style="color:red !important">*</span></label><br>
                                        <input type="file" name="template">&nbsp;
                                    </div>
                                </label>
								<div class="form-buttons-w text-right">
									<a class="btn btn-primary step-trigger-btn" onclick="uploadCardBatch()" style="cursor: pointer !important;"> Upload Card Batch <i class="fa fa-upload"></i></a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@stop
@section('section_title') New Merchant @stop
@section('scripts')
<script>
    function uploadCardBatch()
    {
        if (($('#batchUploadStepTwo').validator('validate').has('.has-error').length)) {
            //alert('SOMETHING WRONG');
            toastr.error("Provide your card batch file before submitting");
        } else {
            var form = $('#batchUploadStepTwo')[0];
            form.submit();
        }
    }



	var goToId_ = null;
	function goToStep(goToId, e)
	{
		console.log(goToId);
		if(goToId=='stepContent2')
		{
			goToId_ = goToId;
			var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
			if (($('#merchantInfoForm').validator('validate').has('.has-error').length)) {
				//alert('SOMETHING WRONG');
				toastr.error("Provide all required information before submitting");
			} else {
				//$("#form2").submit();
				//alert('EVERYTHING IS GOOD');
				e.preventDefault();
				console.log(goToId_);
				companyLogo = $('#companyLogo').prop('files')[0];
				companyCertificate = $('#companyCertificate').prop('files')[0];
				merchantId = $('#merchantId').val();
				
				continueYes = true;
				if(companyLogo!=undefined && companyLogo!=null && companyCertificate!=undefined && companyCertificate!=null)
				{
					
					if(!(merchantId!=undefined && merchantId!=null))
					{
						if(companyLogo.size ==0 || companyLogo.size > (1024*1000))
						{
							continueYes = false;
							toastr.error('Company logo file must be provided and must not exceed 2MB');
						}
						
						if(companyCertificate.size ==0 || companyCertificate.size > (2048*1000))
						{
							continueYes = false;
							toastr.error('Company certificate file must be provided and must not exceed 2MB');
						}
					}
				}
				
				if(continueYes===true)
				{	
					console.log(goToId_);
					var url = "/api/merchants/confirm-merchant-exists/" + $('#companyName').val();
					if($("#merchantId") && $("#merchantId").val()!=undefined && $("#merchantId")!=null)
					{
						url = url + "/" + $('#merchantId').val();
					}
					console.log(url);
					//url = url + "?token={{\Session::get('jwt_token')}}";
					$.ajax({
						type: "GET",
						url: (url),
						data: ([]),
						processData: false,
						contentType: false,
						cache: false,
						headers: {"Authorization": jwtToken},
						timeout: 600000,
						success: function handleSuccess(data1){
							console.log(data1);
							console.log(goToId_);
							if(data1.success===true)
							{
								//alert(33);
								console.log(goToId_);
								if(data1.data.status==211)
								{
									handleUpdateMerchantBioData(goToId, jwtToken);
								}
								else if(data1.data.status==-1)
								{
									console.log(window.location);
									logoutUser('Your session has ended. Please log in to continue', window.location.href);
								}
								else
								{
									toastr.error(data1.data.message);
								}
								//toastr.success(data1.message);
							}
							else
							{
								toastr.error(data1.message);
							}
						},
						error: function (e) {
							toastr.error('We experienced an issue updating your merchant profile. Please try again.');
						}
					});
				}
			}
		}
		else if(goToId=='stepContent3')
		{
			goToId_ = goToId;
			var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
			if (($('#merchantInfoFormStepTwo').validator('validate').has('.has-error').length)) {
				//alert('SOMETHING WRONG');
				toastr.error("Provide all required information before submitting");
			} else {
				//$("#form2").submit();
				//alert('EVERYTHING IS GOOD');
				e.preventDefault();
				console.log(goToId_);
				continueYes = true;
				
				if(continueYes===true)
				{	
					console.log(goToId_);
					handleUpdateMerchantMerchantScheme(goToId, jwtToken);
				}
			}
		}
		else if(goToId=='stepContent4')
		{
			goToId_ = goToId;
			var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
			if (($('#merchantInfoFormStepThree').validator('validate').has('.has-error').length)) {
				//alert('SOMETHING WRONG');
				toastr.error("Provide all required information before submitting");
			} else {
				//$("#form2").submit();
				//alert('EVERYTHING IS GOOD');
				e.preventDefault();
				console.log(goToId_);
				continueYes = false;
				var deviceType = $('#deviceType').val();
				var domainUrl = $('#domainUrl').val();
				var forwardSuccessUrl = $('#forwardSuccessUrl').val();
				var forwardFailureUrl = $('#forwardFailureUrl').val();
				var cybersourceLiveAccessKey = $('#cybersourceLiveAccessKey').val();
				var cybersourceLiveProfileId = $('#cybersourceLiveProfileId').val();
				var cybersourceLiveSecretKey = $('#cybersourceLiveSecretKey').val();
				var cybersourceDemoAccessKey = $('#cybersourceDemoAccessKey').val();
				var cybersourceDemoProfileId = $('#cybersourceDemoProfileId').val();
				var cybersourceDemoSecretKey = $('#cybersourceDemoSecretKey').val();
				var ubaServiceKey = $('#ubaServiceKey').val();
				var ubaMerchantId = $('#ubaMerchantId').val();
				var zicbAuthKey = $('#zicbAuthKey').val();
				var zicbServiceKey = $('#zicbServiceKey').val();
				var posDeviceCode = $('#posDeviceCode').val();
				var posDeviceSerialNo = $('#posDeviceSerialNo').val();
				var posForwardSuccess = $('#posForwardSuccess').val();
				var atmDeviceCode = $('#atmDeviceCode').val();
				var atmDeviceSerialNo = $('#atmDeviceSerialNo').val();
				var atmForwardSuccess = $('#atmForwardSuccess').val();
				var mpqrDeviceCode = $('#mpqrDeviceCode').val();
				var mpqrDeviceSerialNo = $('#mpqrDeviceSerialNo').val();
				var mpqrCardSchemeId = $('#mpqrCardSchemeId').val();
				var mpqrAcquirerId = $('#mpqrAcquirerId').val();
				var merchantId = $('#merchantId').val();

				if(merchantId!=null && merchantId.length>0)
				{
					if(deviceType=='0')	//WEB
					{
						if(domainUrl.length>0 && forwardSuccessUrl.length>0 && forwardSuccessUrl.length>0 && forwardSuccessUrl.length>0)
						{
							continueYes = true;
						}
					}
					else if(deviceType=='1') //POS
					{
						if(posDeviceCode.length>0 && posDeviceSerialNo.length>0 && posForwardSuccess.length>0)
						{
							continueYes = true;
						}
					}
					else if(deviceType=='2') //ATM
					{
						if(atmDeviceCode.length>0 && atmDeviceSerialNo.length>0 && atmForwardSuccess.length>0)
						{
							continueYes = true;
						}
					}
					else if(deviceType=='3') //MPQR
					{
						if(mpqrDeviceCode.length>0 && mpqrDeviceSerialNo.length>0 && mpqrCardSchemeId.length>0 && mpqrAcquirerId.length>0 && mpqrCurrencyCode!=null )
						{
							continueYes = true;
						}
					}
				}
				
				if(continueYes===true)
				{	
					console.log(goToId_);
					handleUpdateMerchantPrimaryDevice(goToId, jwtToken);
				}
				else
				{
					toastr.error("Provide all required information before submitting");
				}
			}
		}
		
		
	}


	function logoutUser(message, redirect)
	{
		toastr.success(message);
		window.location = '/logout?redirect=' + redirect;
	}

	

	function handleUpdateMerchantBioData(goToId, jwtToken)
	{
		var form = $('#merchantInfoForm')[0];
		var formData = new FormData(form);
		var url = '/api/merchants/update-merchant-bio-data';
		$.ajax({
			type: "POST",
			url: (url),
			data: (formData),
			processData: false,
			contentType: false,
			cache: false,
			headers: {"Authorization": jwtToken},
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				console.log(goToId_);
				if(data1.success===true)
				{
					//alert(33);
					console.log(goToId_);
					if(data1.data.status==200)
					{
						toastr.success(data1.data.message);
						$('.merchantId').val(data1.data.merchantId);
						var goToId = '#'+goToId;
						console.log(goToId);
						$('#btn1').click();
					}
					else if(data1.data.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.data.message);
					}
					//toastr.success(data1.message);
				}
				else
				{
					toastr.error(data1.message);
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}
	

	function handleUpdateMerchantMerchantScheme(goToId, jwtToken)
	{
		var form = $('#merchantInfoFormStepTwo')[0];
		var formData = new FormData(form);
		var url = '/api/merchants/update-merchant-bank-and-scheme';
		$.ajax({
			type: "POST",
			url: (url),
			data: (formData),
			processData: false,
			contentType: false,
			cache: false,
			headers: {"Authorization": jwtToken},
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				console.log(goToId_);
				if(data1.success===true)
				{
					//alert(33);
					console.log(goToId_);
					if(data1.data.status==200)
					{
						toastr.success(data1.data.message);
						var goToId = '#'+goToId;
						console.log(goToId);
						$('#btn2').click();
					}
					else if(data1.data.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.data.message);
					}
					//toastr.success(data1.message);
				}
				else
				{
					toastr.error(data1.message);
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}


	function handleUpdateMerchantPrimaryDevice(goToId, jwtToken)
	{
		var form = $('#merchantInfoFormStepThree')[0];
		var formData = new FormData(form);
		var url = '/api/merchants/new-merchant-device';
		$.ajax({
			type: "POST",
			url: (url),
			data: (formData),
			processData: false,
			contentType: false,
			cache: false,
			headers: {"Authorization": jwtToken},
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				console.log(goToId_);
				if(data1.success===true)
				{
					//alert(33);
					console.log(goToId_);
					if(data1.data.status==700)
					{
						toastr.success(data1.data.message);
						window.location = '/potzr-staff/dashboard';
					}
					else if(data1.data.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.data.message);
					}
					//toastr.success(data1.message);
				}
				else
				{
					toastr.error(data1.message);
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}



	$(document).ready(function(){
		//$("#merchantInfoForm").validate();
		//alert("{{\Session::get('jwt_token')}}");
		$('.devices').hide();
		$('.webdevice').show();
		
	});
		
		
	function validateFormOne()
	{
		var companyName = $('#companyName').val();
		var operationCountry = $('#companyName').val();
		var countrycode = $('#companyName').val();
		var mobileNo = $('#companyName').val();
		var altcountrycode = $('#companyName').val();
		var altMobileNo = $('#companyName').val();
		var email = $('#companyName').val();
		var altEmail = $('#companyName').val();
		var addressLine1 = $('#companyName').val();
		var addressLine2 = $('#companyName').val();
		var contactPerson = $('#companyName').val();
		var companyLogo = $('#companyName').val();
		var companyCertificate = $('#companyName').val();
		var companyRegNo = $('#companyName').val();
		
		
		/*var resp = [];
		resp['status'] =false;
		resp['message'] ='Provide all required information. This will help us keep track of your profile';
		return resp;*/
	}
	
	
	function checkLength(val, length, isGreater)
	{
		if(val!=undefined && val!=null && length!=undefined && length!=null && length>-1)
		{
			if(isGreater!=undefined && isGreater===true)
			{
				if(val.length>length)
				{
					return true;
				}
				
			}
			else if(isGreater!=undefined && isGreater===false)
			{
				if(val.length<length)
				{
					return true;
				}
			}
			else
			{
				if(val.length==length)
				{
					return true;
				}
			}
			return false;
		}
	}


	$('#deviceType').on('change', function(){
		console.log($('#deviceType').val());
		var deviceType = $('#deviceType').val();
		$('.devices').hide();
		if(deviceType=='0')	//WEB
		{
			$('.webdevice').show();
		}
		else if(deviceType=='1')	//POS
		{
			$('.posdevice').show();
		}
		else if(deviceType=='2')	//ATM
		{
			$('.atmdevice').show();
		}
		else if(deviceType=='3')	//QR
		{
			$('.qrdevice').show();
		}
		$('.devicebtns').show();
	})
</script>
@stop