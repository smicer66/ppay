@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | New Customer Wallet @stop

@section('content')

@include('partials.errors')


<div class="content-box">
	<div class="element-wrapper">
		<div class="element-box">
			<div>
				<div class="steps-w">
					<div class="step-triggers">
						<a class="step-trigger active" href="#stepContent1">New Wallet</a>
					</div>
					<div class="step-contents">
						<div class="step-content active" id="stepContent1">
							<form action id="newCustomerForm" data-toggle="validator">
								<div class="row" style="padding-top: 20px !Important">
									<div class="col-sm-12">
										<div class="form-group">
											<label for=""><h3><u>Wallet Details</u></h3></label>
										</div>
									</div>
								</div>
								<div class="row">
									@if(\Auth::user()->role_code==\App\Models\Roles::$POTZR_STAFF)
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Preferred Issuer<span style="color:red !important">*</span></label>
											<select class="form-control" name="issuer"  id="issuer" onchange="handleIssuerChange(this)" required>
                                                <option value>-Select A Bank-</option>
                                                @foreach($all_issuers as $val)
                                                    <option value="{{$val->id}}_{{isset($val->holdFundsYes) && $val->holdFundsYes===true ? 1 : 0}}_{{$val->allowedCurrency}}">{{$val->issuerName}}</option>
                                                @endforeach
                                            </select>
										</div>
									</div>
									@endif
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Currency of Wallet<span style="color:red !important">*</span></label>
                                            <select class="form-control" name="currencyCode"  id="currencyCode" required>
                                                <!--<option value>-Select A Currency-</option>-->
                                                @foreach($all_currency as $key => $val)
                                                    <!--<option value="{{$key}}">{{$val}}</option>-->
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
								</div>
								@if(\Auth::user()->role_type==\App\Models\Roles::$POTZR_STAFF)
								<div class="row" id="openingAccountAmountRow" style="display: none !important">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Opening Balance<span style="color:red !important">*</span></label>
											<input name="openingAccountAmount" value="" type="number" class="form-control" id="openingAccountAmount" required placeholder="">
										</div>
									</div>
								</div>
								@endif
								<div class="row" style="padding-top: 20px !Important">
									<div class="col-sm-12">
										<div class="form-group">
											<hr>
											<label for=""><h3><u>Customer Bio-Data</u></h3></label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">First Name<span style="color:red !important">*</span></label>
											<input name="firstName" value="" type="text" class="form-control" id="firstName" required placeholder="">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Last Name<span style="color:red !important">*</span></label>
											<input name="lastName" value="" type="text" class="form-control" id="lastName" placeholder="" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Other Name</label>
											<input name="otherName" value="" type="text" class="form-control" id="otherName" placeholder="Optional">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Gender<span style="color:red !important">*</span></label>
											<select class="form-control" name="gender" required>
                                                <option value="MALE">Male</option>
                                                <option value="FEMALE">Female</option>
                                            </select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Date of Birth</label>
											<input name="dateOfBirth" value="" type="text" class="form-control" id="dateOfBirth" required placeholder="Click to Select A Date">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Address Line 1<span style="color:red !important">*</span></label>
											<input name="addressLine1" value="" type="text" class="form-control" id="addressLine1" required placeholder="">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Address Line 2<span style="color:red !important">*</span></label>
											<input name="addressLine2" value="" type="text" class="form-control" id="addressLine2" placeholder="" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Country of Residence<span style="color:red !important">*</span></label>
											<select name="countryOfResidence" id="countryOfResidence" class="form-control" onchange="emptySelect('provinceOfResidence###districtOfResidence'); handleLoadProvince('provinceOfResidence', this)" required>
												<option value>-Select A Country-</option>
												@foreach($countries as $country)
													<option value="{{$country->id}}">{{$country->name}}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Province of Residence<span style="color:red !important">*</span></label>
											<select name="provinceOfResidence" id="provinceOfResidence" class="form-control" onchange="emptySelect('districtOfResidence'); handleLoadDistrict('districtOfResidence', this)" required>
												<option value>-Select A Province-</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">District of Residence<span style="color:red !important">*</span></label>
											<select name="districtOfResidence" id="districtOfResidence" class="form-control" required>
												<option value>-Select A District-</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Means of Identification<span style="color:red !important">*</span></label>
											<select class="form-control" name="meansOfIdentificationType"  id="meansOfIdentificationType" required>
                                                <option value>-Select A Means of Identification-</option>
                                                @foreach($all_identification_types as $key => $val)
                                                    <option value="{{$key}}">{{$val}}</option>
                                                @endforeach
                                            </select>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Identification Number<span style="color:red !important">*</span></label>
											<input name="meansOfIdentificationNumber" value="" type="text" class="form-control" id="meansOfIdentificationNumber" required placeholder="">
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
															<option value="{{$country->mobileCode}}">+{{$country->mobileCode}} {{$country->name}}</option>
														@endforeach
													</select>
												</div>
												<div class="col col-md-8" style="padding-left:0px !important; padding-right: 0px !important">
													<input name="mobileNo" value=""  type="tel" class="form-control" placeholder="e.g. 967000000" id="mobileNo" required>
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
															<option value="{{$country->mobileCode}}">+{{$country->mobileCode}} {{$country->name}}</option>
														@endforeach
													</select>
												</div>
												<div class="col col-md-8" style="padding-left:0px !important; padding-right: 0px !important">
													<input name="altMobileNo" value="" type="tel" class="form-control" id="altMobileNo" placeholder="e.g. 967000000">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Contact Email Address<span style="color:red !important">*</span></label>
											<input name="email" value="{{$request->old('email') ? $request->old('email') : ''}}" type="email" class="form-control" id="email" required placeholder="We will use this to communicate with the customer e.g. xyz@gmail.com">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="">Alternative Email Address</label>
											<input name="altEmail" value="{{$request->old('altEmail') ? $request->old('altEmail') : ''}}" type="email" class="form-control" id="altEmail" placeholder="Optional">
										</div>
									</div>
								</div>
								<div class="form-buttons-w text-right">
									<a class="btn btn-primary step-trigger-btn" onclick="newCustomerGoToStep('stepContent2', event)" style="cursor: pointer !important;"> Continue</a>
									<a style="cursor: pointer !important; display: none !important" data-target="#new_card_modal" id="add_new_card_btn" data-toggle="modal" class="dropdown-item">View Device</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@include('core.authenticated.ecards.new_card')


@stop
@section('section_title') New Merchant @stop
@section('scripts')
<script type="text/javascript" src="/js/action.js"></script>
<script>
	//
	var goToId_ = null;
	function newCustomerGoToStep(goToId, e)
	{
		console.log(goToId);
		if(goToId=='stepContent2')
		{

			$('#customerVerificationNumber').val("");
			$('#accountNumber').val("");
			goToId_ = goToId;
			var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
			if (($('#newCustomerForm').validator('validate').has('.has-error').length)) {
				//alert('SOMETHING WRONG');
				toastr.error("Provide all required information before submitting");

			} else {
				//$("#form2").submit();
				//alert('EVERYTHING IS GOOD');
				e.preventDefault();
				console.log(goToId_);
				var form = $('#newCustomerForm')[0];
                var formData = new FormData(form);
                var url = '/api/customers/new-customer';
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
                            //alert(33);
						if(data1.status==100)
						{
							toastr.info(data1.message);
							$('#newCardAccoutName').html(data1.customerName);
							$('#newCardCardHolder').val(data1.customerName);
							$('#customerVerificationNumber').html(data1.customerVerificationNumber);
							$('#accountNumber').html(data1.accountNumber);
							$('#add_new_card_btn').click();
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
                    },
                    error: function (e) {
                        toastr.error('We experienced an issue updating your merchant profile. Please try again.');
                    }
                });
			}
		}

	}


	function logoutUser(message, redirect)
	{
		toastr.success(message);
		window.location = '/logout?redirect=' + redirect;
	}



	function handleIssuerChange(ob)
	{
		var val = ob.value;
		val = val.split('_');
		console.log(val);
		$('#openingAccountAmountRow').val('');
		$('#openingAccountAmountRow').hide();
		if(val[0]==="0")
		{
			$('#openingAccountAmountRow').show();
		}

		if(val.length>2)
        {
            $('#currencyCode').empty();
            val_ = val[2].split('###');
            $('#currencyCode').append($('<option>', {
                value: null,
                text : '-Select One-'
            }));

            $.each(val_, function(key, value) {
                console.log(value);
                console.log(key);
                $('#currencyCode').append($('<option>', {
                    value: value,
                    text : value
                }));

            });
        }
	}


	$(document).ready(function(){

	});
</script>
@stop


















