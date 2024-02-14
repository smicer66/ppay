@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->

<div class="content-box">
	<div class="element-wrapper">
		<div class="element-box">
			<div>
				<div class="steps-w">
					<div class="step-triggers">
						<a class="step-trigger active" href="#stepContent1">Merchant Bio-Data</a>
						<a class="step-trigger" href="#stepContent2">Merchant Scheme</a>
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
								<input type="hidden" name="merchantId" id="merchantIdStepOne" value="{{$merchant->id}}" class="merchantId">
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
                                            @if(\Auth::user()->role_code==\App\Models\Roles::$CUSTOMER || \Auth::user()->role_code==\App\Models\Roles::$MERCHANT)
                                                <label for="">Your Company Name<span style="color:red !important">*</span></label>
                                            @else
											    <label for="">Merchant Company Name<span style="color:red !important">*</span></label>
                                            @endif
											<input name="companyName" value="{{$request->old('companyName') ? $request->old('companyName') : ($merchant!=null ? $merchant->companyName : '')}}" type="text" class="form-control" id="companyName" placeholder="Provide Merchants Company Name" required>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Country of Operation<span style="color:red !important">*</span></label>
											<select name="operationCountry" id="operationCountry" class="form-control" required>
												<option value>-Country Code-</option>
												@foreach($countries as $country)
													<option value="{{$country->id}}" {{$request->old('operationCountry') && $request->old('operationCountry')==$country->id ? 'selected' : ($merchant!=null && $merchant->countryOfOperation_id==$country->id ? 'selected' : '')}}>{{$country->name}}</option>
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
															<option value="{{$country->mobileCode}}" {{$request->old('countrycode') && $request->old('countrycode')==$country->mobileCode ? 'selected' : ($merchant!=null && substr($merchant->contactMobile, 0, 3)==$country->mobileCode ? 'selected' : '')}}>+{{$country->mobileCode}} {{$country->name}}</option>
														@endforeach
													</select>
												</div>
												<div class="col col-md-8" style="padding-left:0px !important;">
													<input name="mobileNo" value="{{$request->old('mobileNo') ? $request->old('mobileNo') : (substr($merchant->contactMobile, 3))}}"  type="tel" class="form-control" placeholder="e.g. 803000000" id="mobileNo" required>
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
															<option value="{{$country->mobileCode}}" {{$request->old('altcountrycode') && $request->old('altcountrycode')==$country->mobileCode ? 'selected' : ($merchant!=null && isset($merchant->altContactMobile) && $merchant->altContactMobile!=null && substr($merchant->altContactMobile, 0, 3)==$country->mobileCode ? 'selected' : '')}}>+{{$country->mobileCode}} {{$country->name}}</option>
														@endforeach
													</select>
												</div>
												<div class="col col-md-8" style="padding-left:0px !important;">
													<input name="altMobileNo" value="{{$request->old('altMobileNo') ? $request->old('altMobileNo') : ($merchant!=null && isset($merchant->altContactMobile) && $merchant->altContactMobile!=null ? substr($merchant->altContactMobile, 3) : '')}}" type="tel" class="form-control" id="altMobileNo" placeholder="e.g. 803000000">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Contact Email Address<span style="color:red !important">*</span></label>
											<input name="email" value="{{$request->old('email') ? $request->old('email') : (($merchant->contactEmail))}}" type="email" class="form-control" id="email" required placeholder="This will also serve as your username e.g. xyz@gmail.com">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Alternative Email Address</label>
											<input name="altEmail" value="{{$request->old('altEmail') ? $request->old('altEmail') : (isset($merchant->contactEmail) && $merchant->altContactEmail!=null ? $merchant->altContactEmail: '')}}" type="email" class="form-control" id="altEmail" placeholder="Optional">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Address Line 1<span style="color:red !important">*</span></label>
											<input name="addressLine1" value="{{$request->old('addressLine1') ? $request->old('addressLine1') : (isset($merchant->contactEmail) && $merchant->altContactEmail!=null ? $merchant->altContactEmail: '')}}" type="text" class="form-control" id="addressLine1" required placeholder="1st Line of address">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Address Line 2<span style="color:red !important">*</span></label>
											<input name="addressLine2" value="{{$request->old('addressLine2') ? $request->old('addressLine2') : (isset($merchant->contactEmail) && $merchant->altContactEmail!=null ? $merchant->altContactEmail: '')}}" type="text" required class="form-control" id="addressLine2" placeholder="2nd Line of address">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Company Logo(Max. 1MB)</small></span></label>
											<input name="companyLogo" accept="image/*" type="file" class="form-control" id="companyLogo" placeholder="Select Merchants Company Logo">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Certificate of Incorporation(Max. 2MB)</small></span></label>
											<input name="companyCertificate" accept="image/*,application/pdf" type="file" class="form-control" id="companyCertificate" placeholder="Select Merchants Certificate of Incorporation">
										</div>
									</div>
								</div>
								<div class="row">

									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Company Registration No<span style="color:red !important">*</span></label>
											<input type="text" value="{{$request->old('companyRegNo') ? $request->old('companyRegNo') : (isset($merchant->companyRegNo) && $merchant->companyRegNo!=null ? $merchant->companyRegNo : '')}}" name="companyRegNo" class="form-control" id="companyRegNo" required placeholder="Companys Registration Number">
										</div>
									</div>
								</div>
								<div class="form-buttons-w text-right">
									<a class="btn btn-primary step-trigger-btn" onclick="updateMerchant('stepContent2', event, 'Bearer {{\Session::get('jwt_token')}}')" style="cursor: pointer !important;"> Save</a>
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
								<input type="hidden" name="merchantId" id="merchantIdStepTwo" value="{{$merchant->merchantCode}}" class="merchantId">

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

										<option value="{{$i."_".$merchantScheme->id}}" {{$request->old('merchantScheme') && $request->old('merchantScheme')==($i++."_".$merchantScheme->id) ? 'selected' : ($merchant!=null && $merchant->merchantScheme_id==$merchantScheme->id ? 'selected' : '')}}>{{$merchantScheme->schemename}}</option>
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
											<option value="{{$i."_".$bank->id}}" {{$request->old('merchantBank') && $request->old('merchantBank')==($i++."_".$bank->id) ? 'selected' : ($merchantBankAccount!=null && $merchantBankAccount->merchantBank_id==$bank->id ? 'selected' : '')}}>{{$bank->bankName}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Bank Account Name<span style="color:red !important">*</span></label>
									<input type="text" value="{{$request->old('bankAccountName') ? $request->old('bankAccountName') : ($merchantBankAccount!=null ? $merchantBankAccount->bankAccountName : '')}}" placeholder="Merchants' Bank Account Name for Receiving Funds" name="bankAccountName" class="form-control" id="bankAccountName" required>
								</div>
								<div class="form-group">
									<label for="">Bank Account No<span style="color:red !important">*</span></label>
									<input type="tel" value="{{$request->old('bankAccountNo') ? $request->old('bankAccountNo') : ($merchantBankAccount!=null ? $merchantBankAccount->bankAccountNumber : '')}}" placeholder="Merchants' Bank Account for Receiving Funds" name="bankAccountNo" class="form-control" id="inputEmail3" required>
								</div>
								<div class="form-group">
									<label for="">Branch Code<span style="color:red !important">*</span></label>
									<input type="tel" value="{{$request->old('bankBranchCode') ? $request->old('bankBranchCode') : ($merchantBankAccount!=null ? $merchantBankAccount->bankBranchCode : '')}}" placeholder="Merchants' Bank Branch Code" name="bankBranchCode" class="form-control" id="bankBranchCode" required>
								</div>
								<div class="form-buttons-w text-right">
									<a class="btn btn-primary step-trigger-btn" onclick="updateMerchantScheme('stepContent2', event, 'Bearer {{\Session::get('jwt_token')}}')" style="cursor: pointer !important;"> Continue</a>
									<a class="btn btn-primary step-trigger-btn" id="btn2" style="display: none !important" href="#stepContent3"> Continue</a>
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
@section('section_title') Update Merchant Profile @stop
@section('scripts')
<script type="text/javascript" src="/js/action.js"></script>




@stop