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
						<a class="step-trigger active" href="#stepContent1">Merchant Bio-Data</a>
						<a class="step-trigger" href="#stepContent2">Merchant Scheme</a>
						<a class="step-trigger" href="#stepContent3">Primary Device Details</a>
						<!--<a class="step-trigger" href="#stepContent4">Notifications</a>-->
					</div>
					<div class="step-contents">
						<div class="step-content active" id="stepContent1">

                            <div class="plan-description">
                                <h6>
                                    <strong><label for="">Why Provide Your Company Details?</label></strong>
                                </h6>
                                <p>
                                    For security reasons, we currently only allow valid PACRA registered companies collect payments on our platform. When you provide your company details, we are able to use
                                    the company details you have provided to display to customers making a payment on your website boosting their confidence that the payment is coming to your company
                                </p>
                                <hr>
                            </div>
							<form action id="merchantInfoForm" data-toggle="validator">
								<input type="hidden" name="merchantId" id="merchantIdStepOne" value="" class="merchantId">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
                                            @if(\Auth::user()->role_code==\App\Models\Roles::$CUSTOMER || \Auth::user()->role_code==\App\Models\Roles::$MERCHANT)
                                                <label for="">Your Company Name<span style="color:red !important">*</span></label>
                                            @else
											    <label for="">Merchant Company Name<span style="color:red !important">*</span></label>
                                            @endif
											<input name="companyName" value="{{$request->old('companyName') ? $request->old('companyName') : ''}}" type="text" class="form-control" id="companyName" placeholder="Provide Merchants Company Name" required>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Country of Operation<span style="color:red !important">*</span></label>
											<select name="operationCountry" id="operationCountry" class="form-control" required>
												<option value>-Country Code-</option>
												@foreach($countries as $country)
													<option value="{{$country->id}}" {{$request->old('operationCountry') && $request->old('operationCountry')==$country->id ? 'selected' : ''}}>{{$country->name}}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Contact Mobile No<span style="color:red !important">*</span></label>

											<div class="row">
												<div class="col col-md-4" style="">
													<select name="countrycode" id="countrycode" class="form-control" required>
														<option value>-Country Code-</option>
														@foreach($countries as $country)
															<option value="{{$country->mobileCode}}" {{$request->old('countrycode') && $request->old('countrycode')==$country->mobileCode ? 'selected' : ''}}>+{{$country->mobileCode}} {{$country->name}}</option>
														@endforeach
													</select>
												</div>
												<div class="col col-md-8" style="padding-left:0px !important;">
													<input name="mobileNo" value="{{$request->old('mobileNo') ? $request->old('mobileNo') : ''}}"  type="tel" class="form-control" placeholder="e.g. 803000000" id="mobileNo" required>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Alternative Mobile No</label>
											<div class="row">
												<div class="col col-md-4" style="">
													<select name="altcountrycode" id="altcountrycode" class="form-control">
														<option value>-Country Code-</option>
														@foreach($countries as $country)
															<option value="{{$country->mobileCode}}" {{$request->old('altcountrycode') && $request->old('altcountrycode')==$country->mobileCode ? 'selected' : ''}}>+{{$country->mobileCode}} {{$country->name}}</option>
														@endforeach
													</select>
												</div>
												<div class="col col-md-8" style="padding-left:0px !important;">
													<input name="altMobileNo" value="{{$request->old('altMobileNo') ? $request->old('altMobileNo') : ''}}" type="tel" class="form-control" id="altMobileNo" placeholder="e.g. 803000000">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Contact Email Address<span style="color:red !important">*</span></label>
											<input name="email" value="{{$request->old('email') ? $request->old('email') : ''}}" type="email" class="form-control" id="email" required placeholder="This will also serve as your username e.g. xyz@gmail.com">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Alternative Email Address</label>
											<input name="altEmail" value="{{$request->old('altEmail') ? $request->old('altEmail') : ''}}" type="email" class="form-control" id="altEmail" placeholder="Optional">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Address Line 1<span style="color:red !important">*</span></label>
											<input name="addressLine1" value="{{$request->old('addressLine1') ? $request->old('addressLine1') : ''}}" type="text" class="form-control" id="addressLine1" required placeholder="1st Line of address">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Address Line 2<span style="color:red !important">*</span></label>
											<input name="addressLine2" value="{{$request->old('addressLine2') ? $request->old('addressLine2') : ''}}" type="text" required class="form-control" id="addressLine2" placeholder="2nd Line of address">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Contact Persons' Name<span style="color:red !important">*</span></label>
											<input name="contactPerson" value="{{$request->old('contactPerson') ? $request->old('contactPerson') : ''}}" type="text" class="form-control" id="contactPerson" required placeholder="Provide Companys Representatives Full Names">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Company Logo<span style="color:red !important">*<small>(Max. 1MB)</small></span></label>
											<input name="companyLogo" accept="image/*" type="file" class="form-control" id="companyLogo" required placeholder="Select Merchants Company Logo">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Certificate of Incorporation<span style="color:red !important">*<small>(Max. 2MB)</small></span></label>
											<input name="companyCertificate" accept="image/*,application/pdf" type="file" class="form-control" id="companyCertificate" required placeholder="Select Merchants Certificate of Incorporation">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Company Registration No<span style="color:red !important">*</span></label>
											<input type="text" value="{{$request->old('companyRegNo') ? $request->old('companyRegNo') : ''}}" name="companyRegNo" class="form-control" id="companyRegNo" required placeholder="Companys Registration Number">
										</div>
									</div>
								</div>
								<div class="form-buttons-w text-right">
									<a class="btn btn-primary step-trigger-btn" onclick="goToStep('stepContent2', event)" style="cursor: pointer !important;"> Continue</a>
									<a class="btn btn-primary step-trigger-btn" id="btn1" style="display: none !important" href="#stepContent2"> Continue</a>
								</div>
							</form>
						</div>
						<div class="step-content" id="stepContent2">

                            <div class="plan-description">
                                <h6>
                                    <strong><label for="">Why Provide Your Bank Details?</label></strong>
                                </h6>
                                <p>
                                    Your bank details are used to remit payments to you. When we remit customer payments to you, we will be remitting the payments to this bank account.
                                    If you would prefer a split of the payments in a ratio you prefer, please talk to our customer support for this added feature
                                </p>
                                <hr>
                            </div>
							<form action id="merchantInfoFormStepTwo" data-toggle="validator">
								<input type="hidden" name="merchantId" id="merchantIdStepTwo" value="" class="merchantId">

                                @if(\Auth::user()->role_code==\App\Models\Roles::$CUSTOMER || \Auth::user()->role_code==\App\Models\Roles::$MERCHANT)
                                @else
								<div class="form-group">
									<label for="">Preferred Merchant Scheme<span style="color:red !important">*</span></label>
									<select class="form-control" name="merchantScheme" required>
										<option>-Select A Scheme-</option>
										<?php
										$i = 0;
										?>
										@foreach($all_merchant_schemes as $merchantScheme)

										<option value="{{$i."_".$merchantScheme->id}}" {{$request->old('merchantScheme') && $request->old('merchantScheme')==($i++."_".$merchantScheme->id) ? 'selected' : ''}}>{{$merchantScheme->schemename}}</option>
										@endforeach
									</select>
								</div>
                                @endif
								<div class="form-group">
                                    @if(\Auth::user()->role_code==\App\Models\Roles::$CUSTOMER)
									    <label for="">Your Bank<span style="color:red !important">*</span></label>
                                    @elseif(\Auth::user()->role_code==\App\Models\Roles::$MERCHANT)
                                        <label for="">Your Bank<span style="color:red !important">*</span></label>
                                    @else
                                        <label for="">Merchant Bank<span style="color:red !important">*</span></label>
                                    @endif
									<select class="form-control" name="merchantBank" required>
										<option>-Select A Bank-</option>
										<?php
										$i = 0;
										?>
										@foreach($all_banks as $bank)
											<option value="{{$i."_".$bank->id}}" {{$request->old('merchantBank') && $request->old('merchantBank')==($i++."_".$bank->id) ? 'selected' : ''}}>{{$bank->bankName}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Bank Account Name<span style="color:red !important">*</span></label>
									<input type="text" value="{{$request->old('bankAccountName') ? $request->old('bankAccountName') : ''}}" placeholder="Merchants' Bank Account Name for Receiving Funds" name="bankAccountName" class="form-control" id="bankAccountName" required>
								</div>
								<div class="form-group">
									<label for="">Bank Account No<span style="color:red !important">*</span></label>
									<input type="tel" value="{{$request->old('bankAccountNo') ? $request->old('bankAccountNo') : ''}}" placeholder="Merchants' Bank Account for Receiving Funds" name="bankAccountNo" class="form-control" id="inputEmail3" required>
								</div>
								<div class="form-group">
									<label for="">Branch Code<span style="color:red !important">*</span></label>
									<input type="tel" value="{{$request->old('bankBranchCode') ? $request->old('bankBranchCode') : ''}}" placeholder="Merchants' Bank Branch Code" name="bankBranchCode" class="form-control" id="bankBranchCode" required>
								</div>
								<div class="form-buttons-w text-right">
									<a class="btn btn-primary step-trigger-btn" onclick="goToStep('stepContent3', event)" style="cursor: pointer !important;"> Continue</a>
									<a class="btn btn-primary step-trigger-btn" id="btn2" style="display: none !important" href="#stepContent3"> Continue</a>
								</div>
							</form>
						</div>
						<div class="step-content" id="stepContent3">
                            <div class="plan-description">
                                <h6>
                                    <strong><label for="">What Is My Primary Device?</label></strong>
                                </h6>
                                <p>
                                    Your devices are the websites, point of sale devices, mobile applications which your software developer has developed for you to receive payments
                                    from customers. The first device you add to your profile is your primary device. You can add as many as possible. You will be providing urls our platform will send a notification to when customer transactions are successful or fail.
                                </p>
                                <hr>
                            </div>
                            <form action id="merchantInfoFormStepThree" data-toggle="validator">
								<input type="hidden" name="merchantId" value="" id="merchantIdStepThree" class="merchantId">
								<div class="form-group">
									<label for="">Primary Device Type<span style="color:red !important">*</span></label>
									<select class="form-control" name="deviceType" id="deviceType" required>
										@foreach($all_device_types as $key => $value)
											<option value="{{$key}}" {{$request->old('deviceType') && $request->old('deviceType')==$key ? 'selected' : ''}}>{{$value}}</option>
										@endforeach
									</select>
								</div>
								<div class="row webdevice devices" style="display:none !important">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Domain URL<span style="color:red !important">*</span></label>
											<input class="form-control" id="domainUrl" name="domainUrl" placeholder="Provide the web address of your website" type="text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Forward to URL (Successful Transactions)<span style="color:red !important">*</span></label>
											<input class="form-control" id="forwardSuccessUrl" name="forwardSuccessUrl" placeholder="Provide the url to receive successful transaction notifications" type="text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Forward to URL (Failure Transactions)<span style="color:red !important">*</span></label>
											<input class="form-control" id="forwardFailureUrl" name="forwardFailureUrl" placeholder="Provide the url to receive failed transaction notifications" type="text">
										</div>
									</div>
								</div>
								<div class="row webdevice devices" style="display:none !important">
									<hr class="col-md-12">
									<div class="box-header with-border col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<h4 class="box-title">
                                            Payment Modes Accepted
                                            <small><button class="btn btn-info m-2" data-placement="top" data-toggle="tooltip" title="" type="button" data-original-title="Tick the modes of payment you want to be available to customers" style="color: #fff !important">?</button></small>
                                        </h4>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label for="">MasterCard/Visa</label><br>
											<input class="form-control" name="acceptedCards[]" value="MASTERCARDVISA" type="checkbox">
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label for="">EagleCard</label><br>
											<input class="form-control" name="acceptedCards[]" value="EAGLECARD" type="checkbox">
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label for="">Online Banking</label><br>
											<input class="form-control" name="acceptedCards[]" value="ONLINEBANKING" type="checkbox">
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label for="">Mobile Money</label><br>
											<input class="form-control" name="acceptedCards[]" value="MOBILEMONEY" type="checkbox">
										</div>
									</div>
									<div class="col-sm-2">
										<div class="form-group">
											<label for="">Wallet</label><br>
											<input class="form-control" name="acceptedCards[]" value="WALLET" type="checkbox">
										</div>
									</div>
								</div>
								<div class="row webdevice devices" style="display:none !important">
									<hr class="col-md-12">
									<div class="box-header with-border col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<h4 class="box-title">
                                            3rd Party Gateway Credentials & Keys
                                            <small><span class="btn btn-info m-2" data-placement="top" data-toggle="tooltip" title="" type="button" data-original-title="These keys have been provided by the vendors like Barclays, UBA, ZICB banks. If you dont have one, no worries you will be making use of our default keys" style="color: #fff !important">?</span></small>
                                        </h4>

									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Cybersource Access Key(Live)</label>
											<input class="form-control" id="cybersourceLiveAccessKey" name="cybersourceLiveAccessKey" placeholder="If you have this key, provide it here. Provided by Barclays Bank" type="text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Cybersource Profile Id(Live)</label>
											<input class="form-control" id="cybersourceLiveProfileId" name="cybersourceLiveProfileId" placeholder="If you have this id, provide it here. Provided by Barclays Bank" type="text">
										</div>
									</div>
								</div>
								<div class="row webdevice devices" style="display:none !important">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Cybersource Secret Key(Live)</label>
											<input class="form-control" id="cybersourceLiveSecretKey" name="cybersourceLiveSecretKey" placeholder="If you have this key, provide it here. Provided by Barclays Bank" type="text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Cybersource Access Key(Demo)</label>
											<input class="form-control" id="cybersourceDemoAccessKey" name="cybersourceDemoAccessKey" placeholder="If you have this key, provide it here. Provided by Barclays Bank" type="text">
										</div>
									</div>
								</div>
								<div class="row webdevice devices" style="display:none !important">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Cybersource Profile Id(Demo)</label>
											<input class="form-control" id="cybersourceDemoProfileId" name="cybersourceDemoProfileId" placeholder="If you have this Id, provide it here. Provided by Barclays Bank" type="text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Cybersource Secret Key(Demo)</label>
											<input class="form-control" id="cybersourceDemoSecretKey" name="cybersourceDemoSecretKey" placeholder="If you have this key, provide it here. Provided by Barclays Bank" type="text">
										</div>
									</div>
								</div>
								<div class="row webdevice devices" style="display:none !important">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">UBA Service Key</label>
											<input class="form-control" id="ubaServiceKey" name="ubaServiceKey" placeholder="If you have this key, provide it here. Provided by UBA Bank type"text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">UBA Merchant Id</label>
											<input class="form-control" id="ubaMerchantId" name="ubaMerchantId" placeholder="If you have this id, provide it here. Provided by UBA Bank" type="text">
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
											<label for="">ZICB Auth Key</label>
											<input class="form-control" id="zicbAuthKey" name="zicbAuthKey" placeholder="If you have this key, provide it here. Provided by ZICB Bank" type="text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ZICB Service Key</label>
											<input class="form-control" id="zicbServiceKey" name="zicbServiceKey" placeholder="If you have this key, provide it here. Provided by ZICB Bank" type="text">
										</div>
									</div>
								</div>

								<div class="row webdevice devices" style="display:none !important">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ZICB Auth Key (UAT)</label>
											<input class="form-control" id="zicbAuthKeyuat" name="zicbAuthKeyuat" placeholder="If you have this key, provide it here. Provided by ZICB Bank" type="text">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ZICB Service Key (UAT)</label>
											<input class="form-control" id="zicbServiceKeyuat" name="zicbServiceKeyuat" placeholder="If you have this key, provide it here. Provided by ZICB Bank" type="text">
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
											<input type="text" value="{{$request->old('posDeviceCode') ? $request->old('posDeviceCode') : ''}}" name="posDeviceCode" placeholder="Provide a unique code that identifies your point of sale from your other point of sale devices" class="form-control" id="posDeviceCode">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">POS Device Serial No<span style="color:red !important">*</span></label>
											<input type="text" value="{{$request->old('posDeviceSerialNo') ? $request->old('posDeviceSerialNo') : ''}}" placeholder="Provide the serial number of your point of sale. You will usually find this under the device" class="form-control" id="posDeviceSerialNo" name="posDeviceSerialNo" >
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Success Transaction URL<span style="color:red !important">*</span></label>
											<input type="text" value="{{$request->old('posForwardSuccess') ? $request->old('posForwardSuccess') : ''}}" placeholder="Provide the url to receive successful transaction notifications" name="posForwardSuccess" class="form-control" id="posForwardSuccess">
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
											<input type="number" value="{{$request->old('atmDeviceCode') ? $request->old('atmDeviceCode') : ''}}" placeholder="Provide a unique code that identifies your point of sale from your other point of sale devices" name="atmDeviceCode" class="form-control" id="atmDeviceCode">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">ATM Device Serial No<span style="color:red !important">*</span></label>
											<input type="number" value="{{$request->old('atmDeviceSerialNo') ? $request->old('atmDeviceSerialNo') : ''}}" placeholder="Provide the serial number of your point of sale. You will usually find this under the device" name="atmDeviceSerialNo" class="form-control" id="atmDeviceSerialNo">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Success Transaction URL</label>
											<input type="text" value="{{$request->old('atmForwardSuccess') ? $request->old('atmForwardSuccess') : ''}}" placeholder="Provide the url to receive successful transaction notifications" name="atmForwardSuccess" class="form-control" id="atmForwardSuccess">
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
											<input type="number" value="{{$request->old('mpqrDeviceCode') ? $request->old('mpqrDeviceCode') : ''}}" name="mpqrDeviceCode" placeholder="Provide a unique code that identifies your MPQR device from other devices" class="form-control" id="mpqrDeviceCode">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">MPQR Device Serial No<span style="color:red !important">*</span></label>
											<input type="number" value="{{$request->old('mpqrDeviceSerialNo') ? $request->old('mpqrDeviceSerialNo') : ''}}" name="mpqrDeviceSerialNo" placeholder="Provide the serial number of your MPQR device. You will usually find this under the device" class="form-control" id="mpqrDeviceSerialNo">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Acquirer<span style="color:red !important">*</span></label>
											<select class="form-control" name="mpqrAcquirerId" id="mpqrAcquirerId" required>
												@foreach($all_acquirers as $key => $value)
													<option value="{{$value->id}}" {{$request->old('mpqrAcquirerId') && $request->old('mpqrAcquirerId')==$value->id ? 'selected' : ''}}>{{$value->acquirerName}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Card Scheme<span style="color:red !important">*</span></label>
											<select class="form-control" name="mpqrCardSchemeId" id="mpqrCardSchemeId" required>
												@foreach($all_card_schemes as $key => $value)
													<option value="{{$value->id}}" {{$request->old('mpqrCardSchemeId') && $request->old('mpqrCardSchemeId')==$key ? 'selected' : ''}}>{{$value->schemeName}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Preferred Currency<span style="color:red !important">*</span></label>
											<select class="form-control" name="mpqrCurrencyCode" id="mpqrCurrencyCode" required>
												<option value="ZMW" {{$request->old('mpqrCurrencyCode') && $request->old('mpqrCurrencyCode')=='ZMW' ? 'selected' : ''}}>Zambian Kwacha</option>
												<option value="TZS" {{$request->old('mpqrCurrencyCode') && $request->old('mpqrCurrencyCode')=='TZS' ? 'selected' : ''}}>Tanzanian Shilling</option>
											</select>
										</div>
									</div>
								</div>


								<div class="row qrdevice devices" style="display:block !important">
									<hr class="col-md-12">
									<div class="box-header with-border col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<h4 class="box-title">Wallet Details<span style="color:red !important">*</span></h4>
									</div>
									<div class="col-md-6 col-xs-6 col-lg-6 col-sm-6">
										<div class="form-group">
											<label for="">Wallet Number</label>
											<div class="row">
												<div class="col col-md-12" style="">
													<input placeholder="Funds will sit in the wallet" type="number" value="{{$request->old('walletNumber') ? $request->old('walletNumber') : ''}}" name="walletNumber" class="form-control" id="walletNumber">
												</div>
											</div>
										</div>
									</div>
								</div>


								<div class="row" style="display:block !important">
									<hr class="col-md-12">
									<div class="box-header with-border col-md-12 col-sm-12 col-xs-12 col-lg-12">
										<h4 class="box-title">Notifications on Transactions</h4>
									</div>
									<div class="col-md-6 col-xs-6 col-lg-6 col-sm-6">
										<div class="form-group">
											<label for="">Notify Email of Transactions</label>
											<input placeholder="Notifications of every transaction will be sent to the email you provide here" type="email" value="{{$request->old('notifyEmail') ? $request->old('notifyEmail') : ''}}" name="notifyEmail" class="form-control" id="notifyEmail">
										</div>
									</div>
									<div class="col-md-6 col-xs-6 col-lg-6 col-sm-6">
										<div class="form-group">
											<label for="">Notify Mobile No of Transactions</label><small><span class="btn btn-info m-2" data-placement="top" data-toggle="tooltip" title="" type="button" data-original-title="Charges for sending SMS to this mobile number may be applicable" style="color: #fff !important">?</span></small>
											<div class="row">
												<div class="col col-md-4" style="">
													<select name="notifycountrycode" id="notifycountrycode" class="form-control" required>
														<option value>-Country Code-</option>
															<option value="260">+260 Zambia</option>
														@foreach($countries as $country)
															<option value="{{$country->id}}" {{$request->old('operationCountry') && $request->old('operationCountry')==$country->id ? 'selected' : ''}}>+{{$country->mobileCode}} {{$country->name}}</option>
														@endforeach
													</select>
												</div>
												<div class="col col-md-8" style="padding-left:0px !important;">
													<input placeholder="Notifications of every transaction will be sent to the mobile number you provide here" type="tel" value="{{$request->old('notifyMobile') ? $request->old('notifyMobile') : ''}}" name="notifyMobile" class="form-control" id="notifyMobile">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-buttons-w text-right devicebtns">
									<a class="btn btn-primary step-trigger-btn" onclick="goToStep('stepContent4', event)" style="cursor: pointer !important;"> Continue</a>
									<a class="btn btn-primary step-trigger-btn" id="btn3" style="display: none !important" href="#stepContent4"> Continue</a>
								</div>
							</form>
						</div>
						<!--<div class="step-content" id="stepContent4">
							<form action="/potzr-staff/merchants/new-merchant-step-four" id="merchantInfoFormStepFour" data-toggle="validator">
								<input type="hidden" name="merchantId" id="merchantIdStepFour" value="" class="merchantId">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Notify Email of Transactions</label>
											<input type="email" value="{{$request->old('notifyEmail') ? $request->old('notifyEmail') : ''}}" name="notifyEmail" class="form-control" id="notifyEmail">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Notify Mobile No of Transactions</label>
											<div class="row">
												<div class="col col-md-4" style="">
													<select name="notifycountrycode" id="notifycountrycode" class="form-control" required>
														<option value>-Country Code-</option>
													</select>
												</div>
												<div class="col col-md-8" style="padding-left:0px !important;">
													<input type="tel" value="{{$request->old('notifyMobile') ? $request->old('notifyMobile') : ''}}" name="notifyMobile" class="form-control" id="notifyMobile">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-buttons-w text-right">
									<button class="btn btn-primary">Create Merchant</button>
								</div>
							</form>
						</div>-->
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
				merchantId = $('#merchantIdStepOne').val();

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
				var merchantId = $('#merchantIdStepThree').val();
				var walletNumber = $('#walletNumber').val();

				if(merchantId!=null && merchantId.length>0)
				{
					if(deviceType=='0')	//WEB
					{
						if(domainUrl.length>0 && forwardSuccessUrl.length>0 && forwardSuccessUrl.length>0 && forwardFailureUrl.length>0)
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
						if(mpqrDeviceCode.length>0 && mpqrDeviceSerialNo.length>0 && mpqrCardSchemeId.length>0 && mpqrAcquirerId.length>0 && mpqrCurrencyCode!=null && walletNumber.length>0 )
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
		toastr.info(message);
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
						$('.merchantId').val(data1.data.merchantCode);
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
