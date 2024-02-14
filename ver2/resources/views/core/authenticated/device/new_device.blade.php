mpqrDataType

@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | New Device @stop

@section('content')

@include('partials.errors')


<div class="content-box">
	<div class="element-wrapper">
		<div class="element-box">
			<div>
				<div class="steps-w">
					<div class="step-triggers">
								@if(isset($device) && $device!=null)
						<a class="step-trigger active" href="#stepContent1">Update A Device</a>
								@else
						<a class="step-trigger active" href="#stepContent1">Add A New Device</a>
								@endif
					</div>
					<div class="step-contents">
						<div class="step-content active" id="stepContent1">
							<form action id="merchantInfoFormStepThree" data-toggle="validator">
								@if(isset($device) && $device!=null)
								<input type="hidden" name="deviceId" value="{{\Crypt::encrypt($device->id)}}">
								@endif
								<div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Merchant<span style="color:red !important">*</span></label>
                                            <select class="form-control" name="merchantId" required id="merchantId">
                                                <option value>-Select A Merchant-</option>
                                                @if(isset($merchantId) && $merchantId!=NULL)
                                                    @foreach($merchantList as $merchant)
                                                        @if($merchantId==$merchant->id)
                                                        <option selected value="{{$merchantId}}">{{$merchant->merchantCode}} - {{$merchant->merchantName}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    @foreach($merchantList as $merchant)
                                                        <option {{$merchant->id==$merchantId ? 'selected': ''}} value="{{$merchant->id}}">{{$merchant->merchantCode}} - {{$merchant->merchantName}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>


					<div class="col-sm-6">
                                        &nbsp;
                                    </div>
                                </div>
                                <hr class="col-md-12">


								<div class="row" style="">
									<div class="col-sm-6">

										<div class="form-group">
											<label for="">Device Type<span style="color:red !important">*</span></label>
											<select class="form-control" name="deviceType" id="deviceType" required>
												@foreach($all_device_types as $key => $value)
													<option value="{{$key}}" {{$request->old('deviceType') && $request->old('deviceType')==$key ? 'selected' : (isset($device) && $device!=null && isset($device->deviceType) && $device->deviceType!=null && $device->deviceType==$key ? 'selected' : '')}}>{{$value}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group" id="mpqrdataselector" style="display: none !important">
				                                            <label for="inputEmail3" class="col-sm-3 control-label">MPQR Type<span style="color:red !important">*</span></label>
				                                            <select class="form-control" name="mpqrDataType" id="mpqrDataType">
                            				                    	<option value>-Select A Merchant-</option>
				                                                	<option value="PERSONAL">PERSONAL MPQR</option>
											<option value="CORPORATE">CORPORATE MPQR</option>
				                                            </select>
                            				              </div>

									</div>
								</div>
                                
								<div class="row webdevice devices" style="display:none !important">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Acquirer<span style="color:red !important">*</span></label>
											<select class="form-control" name="mpqrAcquirerId" id="mpqrAcquirerId">
												@foreach($all_acquirers as $key => $value)
													<option value="{{$value->id}}" {{$request->old('mpqrAcquirerId') && $request->old('mpqrAcquirerId')==$value->id ? 'selected' : (isset($device) && $device!=null && isset($device->acquirer_id) && $device->acquirer_id!=null && $value->id==$device->acquirer_id ? 'selected' : '')}}>{{$value->acquirerName}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Domain URL<span style="color:red !important">*</span></label>
											<input class="form-control" value="{{isset($device) && $device!=null && isset($device->domainUrl) && $device->domainUrl!=null ? $device->domainUrl : ''}}" id="domainUrl" name="domainUrl" placeholder="Enter URL to Website" type="text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Forward to URL (Successful Transactions)<span style="color:red !important">*</span></label>
											<input class="form-control" value="{{isset($device) && $device!=null && isset($device->successUrl ) && $device->successUrl !=null ? $device->successUrl : ''}}" id="forwardSuccessUrl" name="forwardSuccessUrl" placeholder="Enter an endpoint" type="text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Forward to URL (Failure Transactions)<span style="color:red !important">*</span></label>
											<input class="form-control" value="{{isset($device) && $device!=null && isset($device->failureUrl ) && $device->failureUrl !=null ? $device->failureUrl : ''}}" id="forwardFailureUrl" name="forwardFailureUrl" placeholder="Enter an endpoint" type="text">
										</div>
									</div>
								</div>

								<div class="row webdevice devices" style="display:none !important">
									<hr class="col-md-12">
									<div class="box-header with-border col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<h4 class="box-title">Payment Modes Accepted</h4>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label for="">MasterCard</label><br>
											<input class="form-control" {{isset($device) && $device!=null && isset($device->mastercardAccept) && $device->mastercardAccept==true ? 'checked' : ''}} name="acceptedCards[]" value="MASTERCARD" type="checkbox">
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label for="">Visa</label><br>
											<input class="form-control" {{isset($device) && $device!=null && isset($device->visaAccept) && $device->visaAccept==true ? 'checked' : ''}} name="acceptedCards[]" value="VISA" type="checkbox">
										</div>
									</div>
									<!--<div class="col-sm-2">
										<div class="form-group">
											<label for="">Bevura Cards</label><br>
											<input class="form-control" {{isset($device) && $device!=null && isset($device->probaseOwned) && $device->probaseOwned==true ? 'checked' : ''}} name="acceptedCards[]" value="EAGLECARD" type="checkbox">
										</div>
									</div>-->
									<div class="col-sm-2">
										<div class="form-group">
											<label for="">Online Banking</label><br>
											<input class="form-control" {{isset($device) && $device!=null && isset($device->bankOnlineAccept) && $device->bankOnlineAccept==true ? 'checked' : ''}} name="acceptedCards[]" value="ONLINEBANKING" type="checkbox">
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label for="">Mobile Money</label><br>
											<input class="form-control" {{isset($device) && $device!=null && isset($device->mobileMoneyAccept) && $device->mobileMoneyAccept==true ? 'checked' : ''}} name="acceptedCards[]" value="MOBILEMONEY" type="checkbox">
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label for="">Bevura Wallet</label><br>
											<input class="form-control" {{isset($device) && $device!=null && isset($device->walletAccept) && $device->walletAccept==true ? 'checked' : ''}} name="acceptedCards[]" value="WALLET" type="checkbox">
										</div>
									</div>
								</div>
								<div class="row webdevice devices" style="display:none !important">
									<hr class="col-md-12">
									<div class="box-header with-border col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<h4 class="box-title">3rd Party Gateway Credentials & Keys</h4>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Cybersource Access Key(Live)</label>
											<input class="form-control" value="{{isset($device) && $device!=null && isset($device->cybersourceLiveAccessKey) && $device->cybersourceLiveAccessKey!=null ? $device->cybersourceLiveAccessKey : ''}}" id="cybersourceLiveAccessKey" name="cybersourceLiveAccessKey" placeholder="" type="text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Cybersource Profile Id(Live)</label>
											<input class="form-control" value="{{isset($device) && $device!=null && isset($device->cybersourceLiveProfileId) && $device->cybersourceLiveProfileId!=null ? $device->cybersourceLiveProfileId : ''}}" id="cybersourceLiveProfileId" name="cybersourceLiveProfileId" placeholder="" type="text">
										</div>
									</div>
								</div>
								<div class="row webdevice devices" style="display:none !important">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Cybersource Secret Key(Live)</label>
											<input class="form-control" value="{{isset($device) && $device!=null && isset($device->cybersourceLiveSecretKey) && $device->cybersourceLiveSecretKey!=null ? $device->cybersourceLiveSecretKey : ''}}" id="cybersourceLiveSecretKey" name="cybersourceLiveSecretKey" placeholder="" type="text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Cybersource Access Key(Demo)</label>
											<input class="form-control" value="{{isset($device) && $device!=null && isset($device->cybersourceDemoAccessKey) && $device->cybersourceDemoAccessKey!=null ? $device->cybersourceDemoAccessKey : ''}}" id="cybersourceDemoAccessKey" name="cybersourceDemoAccessKey" placeholder="" type="text">
										</div>
									</div>
								</div>
								<div class="row webdevice devices" style="display:none !important">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Cybersource Profile Id(Demo)</label>
											<input class="form-control" value="{{isset($device) && $device!=null && isset($device->cybersourceDemoProfileId) && $device->cybersourceDemoProfileId!=null ? $device->cybersourceDemoProfileId : ''}}" id="cybersourceDemoProfileId" name="cybersourceDemoProfileId" placeholder="" type="text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Cybersource Secret Key(Demo)</label>
											<input class="form-control" value="{{isset($device) && $device!=null && isset($device->cybersourceDemoSecretKey) && $device->cybersourceDemoSecretKey!=null ? $device->cybersourceDemoSecretKey : ''}}" id="cybersourceDemoSecretKey" name="cybersourceDemoSecretKey" placeholder="" type="text">
										</div>
									</div>
								</div>
								<div class="row webdevice devices" style="display:none !important">
									<hr class="col-md-12">
									<div class="box-header with-border col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<h4 class="box-title">Bank Credentials & Keys</h4>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">UBA Service Key</label>
											<input class="form-control" value="{{isset($device) && $device!=null && isset($device->ubaServiceKey) && $device->ubaServiceKey!=null ? $device->ubaServiceKey : ''}}" id="ubaServiceKey" name="ubaServiceKey" placeholder="" type="text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">UBA Merchant Id</label>
											<input class="form-control" value="{{isset($device) && $device!=null && isset($device->ubaMerchantId) && $device->ubaMerchantId!=null ? $device->ubaMerchantId : ''}}" id="ubaMerchantId" name="ubaMerchantId" placeholder="" type="text">
										</div>
									</div>
								</div>
								<div class="row webdevice devices" style="display:none !important">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ZICB Auth Key (Live)</label>
											<input class="form-control" value="{{isset($device) && $device!=null && isset($device->zicbAuthKey) && $device->zicbAuthKey!=null ? $device->zicbAuthKey : ''}}" id="zicbAuthKey" name="zicbAuthKey" placeholder="" type="text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ZICB Service Key (Live)</label>
											<input class="form-control" value="{{isset($device) && $device!=null && isset($device->zicbServiceKey) && $device->zicbServiceKey!=null  ? $device->zicbServiceKey : ''}}" id="zicbServiceKey" name="zicbServiceKey" placeholder="" type="text">
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ZICB Auth Key (UAT)</label>
											<input class="form-control" value="{{isset($device) && $device!=null && isset($device->zicbDemoAuthKey) && $device->zicbDemoAuthKey !=null  ? $device->zicbDemoAuthKey : ''}}" id="zicbAuthKeyuat" name="zicbAuthKeyuat" placeholder="" type="text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ZICB Service Key (UAT)</label>
											<input class="form-control" value="{{isset($device) && $device!=null && isset($device->zicbDemoServiceKey ) && $device->zicbDemoServiceKey !=null  ? $device->zicbDemoServiceKey : ''}}" id="zicbServiceKeyuat" name="zicbServiceKeyuat" placeholder="" type="text">
										</div>
									</div>
								</div>
								<div class="row posdevice devices" style="display:none !important">
									<hr class="col-md-12">
									<div class="box-header with-border col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<h4 class="box-title">Point of Sale Device Details</h4>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">POS Device Code<span style="color:red !important">*</span></label>
											<input type="text" value="{{$request->old('posDeviceCode') ? $request->old('posDeviceCode') : (isset($device) && $device!=null && isset($device->deviceCode) && $device->deviceCode!=null  ? $device->deviceCode : '')}}" name="posDeviceCode" class="form-control" id="posDeviceCode">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">POS Device Serial No<span style="color:red !important">*</span></label>
											<input type="text" value="{{$request->old('posDeviceSerialNo') ? $request->old('posDeviceSerialNo') : (isset($device) && $device!=null && isset($device->deviceSerialNo ) && $device->deviceSerialNo !=null  ? $device->deviceSerialNo : '')}}" class="form-control" id="posDeviceSerialNo" name="posDeviceSerialNo" >
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Success Transaction URL<span style="color:red !important">*</span></label>
											<input type="text" value="{{$request->old('posForwardSuccess') ? $request->old('posForwardSuccess') : (isset($device) && $device!=null && isset($device->successUrl ) && $device->successUrl !=null  ? $device->successUrl : '')}}" name="posForwardSuccess" class="form-control" id="posForwardSuccess">
										</div>
									</div>
								</div>
								<div class="row atmdevice devices" style="display:none !important">
									<hr class="col-md-12">
									<div class="box-header with-border col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<h4 class="box-title">Automated Teller Machine Device Details</h4>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ATM Device Code<span style="color:red !important">*</span></label>
											<input type="number" value="{{$request->old('atmDeviceCode') ? $request->old('atmDeviceCode') : (isset($device) && $device!=null && isset($device->deviceCode ) && $device->deviceCode !=null  ? $device->deviceCode : '')}}" name="atmDeviceCode" class="form-control" id="atmDeviceCode">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ATM Device Serial No<span style="color:red !important">*</span></label>
											<input type="number" value="{{$request->old('atmDeviceSerialNo') ? $request->old('atmDeviceSerialNo') : (isset($device) && $device!=null && isset($device->deviceSerialNo ) && $device->deviceSerialNo !=null  ? $device->deviceSerialNo : '')}}" name="atmDeviceSerialNo" class="form-control" id="atmDeviceSerialNo">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Success Transaction URL<span style="color:red !important">*</span></label>
											<input type="text" value="{{$request->old('atmForwardSuccess') ? $request->old('atmForwardSuccess') : (isset($device) && $device!=null && isset($device->successUrl ) && $device->successUrl !=null  ? $device->successUrl : '')}}" name="atmForwardSuccess" class="form-control" id="atmForwardSuccess">
										</div>
									</div>
								</div>
								<div class="row qrdevice devices" style="display:none !important">
									<hr class="col-md-12">
									<div class="box-header with-border col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<h4 class="box-title">QR Payment Details For Receiving Payments</h4>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">MPQR Device Code<span style="color:red !important">*</span></label>
											<input type="number" value="{{$request->old('mpqrDeviceCode') ? $request->old('mpqrDeviceCode') : (isset($device) && $device!=null && isset($device->deviceCode ) && $device->deviceCode !=null  ? $device->deviceCode : '')}}" name="mpqrDeviceCode" class="form-control" id="mpqrDeviceCode">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">MPQR Device Serial No<span style="color:red !important">*</span></label>
											<input type="number" value="{{$request->old('mpqrDeviceSerialNo') ? $request->old('mpqrDeviceSerialNo') : (isset($device) && $device!=null && isset($device->deviceSerialNo ) && $device->deviceSerialNo !=null  ? $device->deviceSerialNo : '')}}" name="mpqrDeviceSerialNo" class="form-control" id="mpqrDeviceSerialNo">
										</div>
									</div>
									<!--<div class="col-sm-6">
										<div class="form-group">
											<label for="">Acquirer<span style="color:red !important">*</span></label>
											<select class="form-control" name="mpqrAcquirerId" id="mpqrAcquirerId">
												@foreach($all_acquirers as $key => $value)
													<option value="{{$value->id}}" {{$request->old('mpqrAcquirerId') && $request->old('mpqrAcquirerId')==$value->id ? 'selected' : (isset($device) && $device!=null && isset($device->acquirer_id) && $device->acquirer_id!=null && $value->id==$device->acquirer_id ? 'selected' : '')}}>{{$value->acquirerName}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Card Scheme<span style="color:red !important">*</span></label>
											<select class="form-control" name="mpqrCardSchemeId" id="mpqrCardSchemeId">
												@foreach($all_card_schemes as $key => $value)
													<option value="{{$value->id}}" {{$request->old('mpqrCardSchemeId') && $request->old('mpqrCardSchemeId')==$key ? 'selected' : ''}}>{{$value->schemeName}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Preffered Currency<span style="color:red !important">*</span></label>
											<select class="form-control" name="mpqrCurrencyCode" id="mpqrCurrencyCode">
												<option value="ZMW" {{$request->old('mpqrCurrencyCode') && $request->old('mpqrCurrencyCode')=='ZMW' ? 'selected' : ''}}>Zambian Kwacha</option>
												<option value="TZS" {{$request->old('mpqrCurrencyCode') && $request->old('mpqrCurrencyCode')=='TZS' ? 'selected' : ''}}>Tanzanian Shilling</option>
											</select>
										</div>
									</div>-->

									@if(!(isset($device) && $device!=null))
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Wallet Number<span style="color:red !important">*</span></label>
											<input type="number" value="{{$request->old('walletNumber') ? $request->old('walletNumber') : ''}}" name="walletNumber" class="form-control" id="walletNumber">
											<input type="hidden" name="mpqrDataType" id="mpqrDataType" value="PERSONAL">
										</div>
									</div>
									@endif
								</div>


								<div class="row" style="display:block !important">
									<hr class="col-md-12">
									<div class="box-header with-border col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<h4 class="box-title">Notifications on Transactions</h4>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Notify Email of Transactions</label>									
											<input type="email" value="{{$request->old('notifyEmail') ? $request->old('notifyEmail') : (isset($device) && $device!=null && isset($device) && $device!=null && isset($device->emailNotify) && $device->emailNotify!=null ? $device->emailNotify  : '')}}" name="notifyEmail" class="form-control" id="notifyEmail">
										</div>
									</div>
									<div class="col-sm-6">
											<label for="">Notify Mobile No of Transactions</label>
										<div class="row">

											<div class="col-md-4" style="clear: both !important; float: left !important">
												<select name="notifycountrycode" id="notifycountrycode" class="form-control" required>
													<option value>-Country Code-</option>
													@foreach($countries as $country)
													<option value="{{$country->mobileCode}}" {{$request->old('notifycountrycode') && $request->old('notifycountrycode')==$country->mobileCode ? 'selected' : (isset($device) && $device!=null && isset($device->mobileNotify) && $device->mobileNotify!=null && substr($device->mobileNotify, 0, 3)==$country->mobileCode ? ('selected') : '')}}>+{{$country->mobileCode}} - ({{$country->name}})</option>
													@endforeach
												</select>
											</div>
											<div class="col-md-8" style="float: left !importants">
												<div class="form-group">
													
													<input type="tel" value="{{$request->old('notifyMobile') ? substr($request->old('notifyMobile'), 3) : (isset($device) && $device!=null && isset($device->mobileNotify) && $device->mobileNotify!=null ? substr($device->mobileNotify, 3) : '')}}" name="notifyMobile" class="form-control" id="notifyMobile">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-buttons-w text-right devicebtns">
									<a class="btn btn-primary step-trigger-btn" onclick="goToStep('stepContent1', event)" style="cursor: pointer !important;"> Save</a>
									<a class="btn btn-primary step-trigger-btn" id="btn3" style="display: none !important" href="#stepContent1"> Save</a>
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
@section('section_title') New Device @stop
@section('scripts')
<script>
	var goToId_ = null;
	function goToStep(goToId, e)
	{
		console.log(goToId);
		if(goToId=='stepContent1')
		{
			goToId_ = goToId;
			var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
			if (($('#merchantInfoFormStepThree').validator('validate').has('.has-error').length)) {
				//alert('SOMETHING WRONG');
				toastr.error("Provide all required information before submitting form");
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
				var zicbAuthKeyUAT = $('#zicbAuthKeyuat').val();
				var zicbServiceKeyUAT = $('#zicbServiceKeyuat').val();

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
				var walletNumber = $('#walletNumber').val();

				if(deviceType=='0')	//WEB
				{
					if(merchantId!=null && merchantId.length>0 && domainUrl.length>0 && forwardSuccessUrl.length>0 && forwardSuccessUrl.length>0 && forwardSuccessUrl.length>0)
					{
						continueYes = true;
					}
				}
				else if(deviceType=='1') //POS
				{
					if(merchantId!=null && merchantId.length>0 && posDeviceCode.length>0 && posDeviceSerialNo.length>0 && posForwardSuccess.length>0)
					{
						continueYes = true;
					}
				}
				else if(deviceType=='2') //ATM
				{
					if(merchantId!=null && merchantId.length>0 && atmDeviceCode.length>0 && atmDeviceSerialNo.length>0 && atmForwardSuccess.length>0)
					{
						continueYes = true;
					}
				}
				else if(deviceType=='3') //MPQR
				{
					@if(isset($device) && $device!=null)
					if(merchantId!=null && merchantId.length>0 && mpqrDeviceCode.length>0 && mpqrDeviceSerialNo.length>0 && mpqrAcquirerId.length>0)//mpqrCardSchemeId.length>0 &&  && mpqrCurrencyCode!=null
					{
						continueYes = true;
					}
					@else
					if(merchantId!=null && merchantId.length>0 && mpqrDeviceCode.length>0 && mpqrDeviceSerialNo.length>0 && walletNumber!=null && mpqrAcquirerId.length>0)//mpqrCardSchemeId.length>0 &&  && mpqrCurrencyCode!=null
					{
						continueYes = true;
					}
					@endif
				}
				
				if(continueYes===true)
				{	
					console.log(goToId_);
					handleNewMerchantDevice(goToId, jwtToken);
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


	function handleNewMerchantDevice(goToId, jwtToken)
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
						window.location = '/potzr-staff/merchants/view-merchant-devices';
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
		@if(isset($device) && $device!=null)
			handleDeviceTypeChange();
		@endif
	});
		
	
	


	$('#deviceType').on('change', function(){
		handleDeviceTypeChange();
	})


	function handleDeviceTypeChange()
	{
		console.log($('#deviceType').val());
		var deviceType = $('#deviceType').val();
		$('.devices').hide();
		if(deviceType=='0')	//WEB
		{
			$('.webdevice').show();
			$('#mpqrdataselector').hide();
		}
		else if(deviceType=='1')	//POS
		{
			$('.posdevice').show();
			$('#mpqrdataselector').hide();
		}
		else if(deviceType=='2')	//ATM
		{
			$('.atmdevice').show();
			$('#mpqrdataselector').hide();
		}
		else if(deviceType=='3')	//QR
		{
			$('.qrdevice').show();
			$('#mpqrdataselector').show();
		}
		$('.devicebtns').show();
	}
</script>
@stop