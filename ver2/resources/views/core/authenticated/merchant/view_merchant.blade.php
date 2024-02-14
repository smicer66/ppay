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
						<a class="step-trigger active" href="#stepContent1">My Company Details</a>
						<a class="step-trigger" href="#stepContent2">My Bank Details</a>
						<a class="step-trigger" href="#stepContent3">My Devices</a>
						<!--<a class="step-trigger" href="#stepContent4">Notifications</a>-->
					</div>
					<div class="step-contents">
						<div class="step-content active" id="stepContent1">

								<input type="hidden" name="merchantId" value="" class="merchantId">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
                                            @if(\Auth::user()->role_code==\App\Models\Roles::$CUSTOMER || \Auth::user()->role_code==\App\Models\Roles::$MERCHANT)
                                                <label for="">Your Company Name</label>
                                            @else
											    <label for="">Merchant Company Name</label>
                                            @endif
                                            <div class="row">
                                                <div class="col col-md-12" style="">
                                                    St Pauls Company
                                                </div>
                                            </div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Country of Operation</label>
                                            <div class="row">
                                                <div class="col col-md-12" style="">
                                                    Zambia
                                                </div>
                                            </div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Contact Mobile No</label>

											<div class="row">
												<div class="col col-md-12" style="">
													+260967307151
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Alternative Mobile No</label>
											<div class="row">
												<div class="col col-md-12" style="">
													Not Provided
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Contact Email Address</label>

                                            <div class="row">
                                                <div class="col col-md-12" style="">
                                                    contact@gmail.com
                                                </div>
                                            </div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Alternative Email Address</label>

                                            <div class="row">
                                                <div class="col col-md-12" style="">
                                                    Not provided
                                                </div>
                                            </div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">1st Line of Address</label>

                                            <div class="row">
                                                <div class="col col-md-12" style="">
                                                    Not provided
                                                </div>
                                            </div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">2nd Line of Address</label>

                                            <div class="row">
                                                <div class="col col-md-12" style="">
                                                    Not provided
                                                </div>
                                            </div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Contact Persons' Name</label>

                                            <div class="row">
                                                <div class="col col-md-12" style="">
                                                    Joseph Malama
                                                </div>
                                            </div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Company Logo</label>
											<input name="companyLogo" accept="image/*" type="file" class="form-control" id="companyLogo" required placeholder="Select Merchants Company Logo">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Certificate of Incorporation</label>

                                            <div class="row">
                                                <div class="col col-md-12" style="height: 120px !important; overflow: hidden !important;">
                                                    <img src="" style="width: 100% !important;">
                                                </div>
                                            </div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Company Registration No</label>

                                            <div class="row">
                                                <div class="col col-md-12" style="">
                                                    59694-3930-2012
                                                </div>
                                            </div>
										</div>
									</div>
								</div>
								<div class="form-buttons-w text-right">
									<a class="btn btn-primary step-trigger-btn" onclick="goToStep('stepContent2', event)" style="cursor: pointer !important;"> Edit Merchant Profile</a>
									<a class="btn btn-primary step-trigger-btn" id="btn1" style="display: none !important" href="#stepContent2"> Edit Merchant Profile</a>
								</div>
						</div>
						<div class="step-content" id="stepContent2">

								<input type="hidden" name="merchantId" value="" class="merchantId">

                                @if(\Auth::user()->role_code==\App\Models\Roles::$CUSTOMER || \Auth::user()->role_code==\App\Models\Roles::$MERCHANT)
                                @else
								<div class="form-group">
									<label for="">Preferred Merchant Scheme</label>
									Merchant Scheme 1
								</div>
                                @endif
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        @if(\Auth::user()->role_code==\App\Models\Roles::$CUSTOMER)
                                            <label for="">Your Bank</label>
                                        @elseif(\Auth::user()->role_code==\App\Models\Roles::$MERCHANT)
                                            <label for="">Your Bank</label>
                                        @else
                                            <label for="">Merchant Bank</label>
                                        @endif

                                            <div class="row">
                                                <div class="col col-md-12" style="">
                                                    BANC-ABC
                                                </div>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Bank Account Name</label>
                                        <div class="row">
                                            <div class="col col-md-12" style="">
                                                John Doe
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Bank Account No</label>
                                        <div class="row">
                                            <div class="col col-md-12" style="">
                                                4959-3030-0391-0391
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Branch Code</label>
                                        <div class="row">
                                            <div class="col col-md-12" style="">
                                                938495094
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="form-buttons-w text-right">
									<a class="btn btn-primary step-trigger-btn" onclick="goToStep('stepContent3', event)" style="cursor: pointer !important;"> Edit Merchant Profile</a>
									<a class="btn btn-primary step-trigger-btn" id="btn2" style="display: none !important" href="#stepContent3"> Edit Merchant Profile</a>
								</div>
						</div>
						<div class="step-content" id="stepContent3">
								<input type="hidden" name="merchantId" value="" class="merchantId">
								<div class="row" style="display:block !important">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Primary Device Type</label>
                                            <div class="row">
                                                <div class="col col-md-12" style="">
                                                    WEB
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
										<div class="form-group">
											<label for="">Domain URL</label>
                                            <div class="row">
                                                <div class="col col-md-12" style="">
                                                    http://google.com
                                                </div>
                                            </div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Forward to URL (Successful Transactions)</label>

                                            <div class="row">
                                                <div class="col col-md-12" style="">
                                                    http://google.com/success-url
                                                </div>
                                            </div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Forward to URL (Failure Transactions)</label>

                                            <div class="row">
                                                <div class="col col-md-12" style="">
                                                    http://google.com/failure-url
                                                </div>
                                            </div>
										</div>
									</div>
								</div>
								<div class="row webdevice devices" style="display:none !important">

									<div class="col-sm-12">
										<div class="form-group">
											<label for="">Payment Modes Accepted</label><br>
                                            <div class="row">
                                                <div class="col col-md-12" style="">
                                                    Mastercard/VISA, Online Banking
                                                </div>
                                            </div>
										</div>
									</div>
								</div>
                                <div class="form-buttons-w text-right">
                                    <a class="btn btn-primary step-trigger-btn" onclick="goToStep('stepContent2', event)" style="cursor: pointer !important;"> Edit Device</a>
                                    <a class="btn btn-primary step-trigger-btn" id="btn1" style="display: none !important" href="#stepContent2"> Edit Device</a>
                                </div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--------------------
		START - Color Scheme Toggler
		-------------------->
	<!--<div class="floated-colors-btn second-floated-btn">
		<div class="os-toggler-w">
			<div class="os-toggler-i">
				<div class="os-toggler-pill"></div>
			</div>
		</div>
		<span>Dark </span><span>Colors</span>
	</div>
	<div class="floated-customizer-btn third-floated-btn">
		<div class="icon-w">
			<i class="os-icon os-icon-ui-46"></i>
		</div>
		<span>Customizer</span>
	</div>
	<div class="floated-customizer-panel">
		<div class="fcp-content">
			<div class="close-customizer-btn">
				<i class="os-icon os-icon-x"></i>
			</div>
			<div class="fcp-group">
				<div class="fcp-group-header">
					Menu Settings
				</div>
				<div class="fcp-group-contents">
					<div class="fcp-field">
						<label for="">Menu Position</label>
						<select class="menu-position-selector">
							<option value="left">
								Left
							</option>
							<option value="right">
								Right
							</option>
							<option value="top">
								Top
							</option>
						</select>
					</div>
					<div class="fcp-field">
						<label for="">Menu Style</label>
						<select class="menu-layout-selector">
							<option value="compact">
								Compact
							</option>
							<option value="full">
								Full
							</option>
							<option value="mini">
								Mini
							</option>
						</select>
					</div>
					<div class="fcp-field with-image-selector-w">
						<label for="">With Image</label>
						<select class="with-image-selector">
							<option value="yes">
								Yes
							</option>
							<option value="no">
								No
							</option>
						</select>
					</div>
					<div class="fcp-field">
						<label for="">Menu Color</label>
						<div class="fcp-colors menu-color-selector">
							<div class="color-selector menu-color-selector color-bright selected"></div>
							<div class="color-selector menu-color-selector color-dark"></div>
							<div class="color-selector menu-color-selector color-light"></div>
							<div class="color-selector menu-color-selector color-transparent"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="fcp-group">
				<div class="fcp-group-header">
					Sub Menu
				</div>
				<div class="fcp-group-contents">
					<div class="fcp-field">
						<label for="">Sub Menu Style</label>
						<select class="sub-menu-style-selector">
							<option value="flyout">
								Flyout
							</option>
							<option value="inside">
								Inside/Click
							</option>
							<option value="over">
								Over
							</option>
						</select>
					</div>
					<div class="fcp-field">
						<label for="">Sub Menu Color</label>
						<div class="fcp-colors">
							<div class="color-selector sub-menu-color-selector color-bright selected"></div>
							<div class="color-selector sub-menu-color-selector color-dark"></div>
							<div class="color-selector sub-menu-color-selector color-light"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="fcp-group">
				<div class="fcp-group-header">
					Other Settings
				</div>
				<div class="fcp-group-contents">
					<div class="fcp-field">
						<label for="">Full Screen?</label>
						<select class="full-screen-selector">
							<option value="yes">
								Yes
							</option>
							<option value="no">
								No
							</option>
						</select>
					</div>
					<div class="fcp-field">
						<label for="">Show Top Bar</label>
						<select class="top-bar-visibility-selector">
							<option value="yes">
								Yes
							</option>
							<option value="no">
								No
							</option>
						</select>
					</div>
					<div class="fcp-field">
						<label for="">Above Menu?</label>
						<select class="top-bar-above-menu-selector">
							<option value="yes">
								Yes
							</option>
							<option value="no">
								No
							</option>
						</select>
					</div>
					<div class="fcp-field">
						<label for="">Top Bar Color</label>
						<div class="fcp-colors">
							<div class="color-selector top-bar-color-selector color-bright selected"></div>
							<div class="color-selector top-bar-color-selector color-dark"></div>
							<div class="color-selector top-bar-color-selector color-light"></div>
							<div class="color-selector top-bar-color-selector color-transparent"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="floated-chat-btn">
		<i class="os-icon os-icon-mail-07"></i><span>Demo Chat</span>
	</div>
	<div class="floated-chat-w">
		<div class="floated-chat-i">
			<div class="chat-close">
				<i class="os-icon os-icon-close"></i>
			</div>
			<div class="chat-head">
				<div class="user-w with-status status-green">
					<div class="user-avatar-w">
						<div class="user-avatar">
							<img alt="" src="/img/avatar1.jpg">
						</div>
					</div>
					<div class="user-name">
						<h6 class="user-title">
							John Mayers
						</h6>
						<div class="user-role">
							Account Manager
						</div>
					</div>
				</div>
			</div>
			<div class="chat-messages">
				<div class="message">
					<div class="message-content">
						Hi, how can I help you?
					</div>
				</div>
				<div class="date-break">
					Mon 10:20am
				</div>
				<div class="message">
					<div class="message-content">
						Hi, my name is Mike, I will be happy to assist you
					</div>
				</div>
				<div class="message self">
					<div class="message-content">
						Hi, I tried ordering this product and it keeps showing me error code.
					</div>
				</div>
			</div>
			<div class="chat-controls">
				<input class="message-input" placeholder="Type your message here..." type="text">
				<div class="chat-extra">
					<a href="#"><span class="extra-tooltip">Attach Document</span><i class="os-icon os-icon-documents-07"></i></a><a href="#"><span class="extra-tooltip">Insert Photo</span><i class="os-icon os-icon-others-29"></i></a><a href="#"><span class="extra-tooltip">Upload Video</span><i class="os-icon os-icon-ui-51"></i></a>
				</div>
			</div>
		</div>
	</div>
	-->
</div>

@stop
@section('section_title') New Merchant @stop
@section('scripts')
<script>
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
