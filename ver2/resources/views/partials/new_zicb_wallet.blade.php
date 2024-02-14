<div class="modal fade" id="manageIncidencesModal" tabindex="-1" role="dialog" aria-labelledby="manageIncidencesModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg col-md-12" role="document" style="width: auto !important; margin: auto !important; padding: 0px !important;">
		<div class="modal-content">
			<form method="post" id="newzicbcustomerform" class="form">
			    <?php
				$newInput = \Crypt::decrypt($input);
				?>
				 <input type="hidden" name="isWalletOrAccount" id="isWalletOrAccount" value="">
			     <input type="hidden" name="orderId" id="orderId" value="{{$orderId}}">
			     <input type="hidden" name="serviceTypeId" id="serviceTypeId" value="{{$newInput['serviceTypeId']}}">
			     <input type="hidden" name="merchantCode" id="merchantCode" value="{{$newInput['merchantId']}}">
			     <input type="hidden" name="deviceCode" id="deviceCode" value="{{$newInput['deviceCode']}}">
			     <!--<input type="hidden" name="responseUrl" id="responseUrl" value="$newInput['responseurl']">-->
				<div class="modal-header bg-primary" style="color: #fff; padding-bottom: 40px">
					<h5 class="modal-title col-md-11" id="manageIncidencesModalLabel">New ZICB Wallet</h5>
					<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true" class="pull-right">&times;</span>
					</button>
				</div>
				<div class="modal-body col-md-12" style="display: inline-block;">


						<div class="col-md-6">
							<div class="form-group">
								<label><strong>First Name:<span style="color: red">*</span></strong></label>
								<br><input type="text" name="firstName" id="firstName" value="{{isset($firstName) && $firstName!=null ? $firstName : ''}}" required class="form-control" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><strong>Last Name:<span style="color: red">*</span></strong></label>
								<br><input type="text" name="lastName" id="lastName" value="{{isset($lastName) && $lastName!=null ? $lastName : ''}}" required class="form-control" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><strong>Email Address:</strong></label>
								<br><input type="text" name="email" id="email" value="{{isset($email) && $email!=null ? $email: ''}}" class="form-control" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><strong>Mobile Number:<span style="color: red">*</span></strong></label>
								<br><input type="text" name="payerPhone" id="payerPhone" value="{{isset($payerPhone) && $payerPhone!=null ? $payerPhone: ''}}" required class="form-control" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><strong>NRC Number:<span style="color: red">*</span></strong></label>
								<br><input type="text" name="nationalId" id="nationalId" value="{{isset($nationalId) && $nationalId!=null ? $nationalId: ''}}" required class="form-control" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><strong>Gender:<span style="color: red">*</span></strong></label>
								<br><select name="gender" id="gender" required class="form-control">
								        <option value="F">Female</option>
								        <option value="M">Male</option>
								    </select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><strong>Date of Birth:<span style="color: red">*</span></strong></label>
								<br><input type="text" placeholder="YYYY-MM-DD" name="dateOfBirth" id="dateOfBirth" value="" required class="form-control" />
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label><strong>Street Address:<span style="color: red">*</span></strong></label>
								<br><input type="text" name="streetAddress" id="streetAddress" value="{{isset($streetAddress) && $streetAddress!=null ? $streetAddress: ''}}" required class="form-control" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><strong>City:<span style="color: red">*</span></strong></label>
								<br><input type="text" name="city" id="city" value="{{isset($city) && $city!=null ? $city: ''}}" required class="form-control" />
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><strong>Province:<span style="color: red">*</span></strong></label>
								<br>
								<select name="provincezicb" id="provincezicb" required class="form-control" onchange="javascript:provinceHandler()">
        							<option selected>Select Province</option>
        							@foreach($all_provinces as $key => $province)
        								<option value="{{$province->id}}">{{$province->provinceName}}</option>
        							@endforeach
        						</select>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><strong>District:<span style="color: red">*</span></strong></label>
								<br>
								<select name="districtzicb" id="districtzicb" required class="form-control">
									<option value>-Select District-</option>
								</select>
							</div>
						</div>


				</div>
				<div class="modal-footer" style="clear:both !important">

					<a onclick="handleNewZICBWallet()" style="margin-top: 5px" class="btn btn-success pull-right">Submit</a>
				</div>
			</form>
		</div>
	</div>
</div>

<style>
    label.error{
        color:red;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" type="text/javascript"></script>
<script>


function handleNewZICBWallet()
{
    $("#addWalletMessage").hide();
    var firstName = $('#firstName').val();
    var lastName = $('#lastName').val();
    var email = $('#email').val();
    var payerPhone = $('#payerPhone').val();
    var nationalId = $('#nationalId').val();
    var streetAddress = $('#streetAddress').val();
    var city = $('#city').val();
    var provincezicb = $('#provincezicb').val();
    var districtzicb = $('#districtzicb').val();
    var gender = $("#gender").val();
    var dateOfBirth = $("#dateOfBirth").val();

    var check = "{{$newInput['deviceCode']}}";
    console.log(check);



    var form = $('#newzicbcustomerform')[0];
    $("#newzicbcustomerform").validate(
        {
            rules: {
                firstName: {
                    required: true
                },
                lastName: {
                    required: true
                },
                email: {
                    email: true
                },
                payerPhone: {
                    required: true
                },
                nationalId: {
                    required: true
                },
                streetAddress: {
                    required: true
                },
                city: {
                    required: true
                },
                districtzicb: {
                    required: true
                },
                provincezicb: {
                    required: true
                },
                gender: {
                    required: true
                },
                dateOfBirth: {
                    required: true
                }
            },
            messages: {
                firstName: "Enter your first name",
                lastName: "Enter your last name",
                email: "Enter a valid email",
                payerPhone: "Enter your mobile number",
                nationalId: "Provide your passport number or national Id number",
                streetAddress: "Enter your physical address",
                city: "Specify your city",
                districtzicb: "Select your district",
                provincezicb: "Select your province",
                gender: "Select your gender",
                dateOfBirth: "Specify your date of birth"

            },
        }
    );
	var data = new FormData(form);
	if($("#newzicbcustomerform").valid())
	{
	    $.ajax({
    		type: "POST",
    		enctype: 'multipart/form-data',
    		url: "/api/create-new-zicb-wallet",
    		data: data,
    		processData: false,
    		contentType: false,
    		cache: false,
    		timeout: 600000,
    		success: function (data) {
    		    console.log(data);
    			if(data.response!=undefined && data.response.status==1)  //OTP Sent
    			{
    				//key = '#coop_member_count_' + data.cooperative_id;
    				//$( key ).html(data.member_count);
    				$('#errorotp1').hide();
    				$('#manageIncidencesModal').modal('toggle');

    				$("#isWalletOrAccountOtp").val(isWalletOrAccount);
                    $("#otpRefOtp").val(data.response.otpRef);
                    $("#firstNameOtp").val(firstName);
                    $("#lastNameOtp").val(lastName);
                    $("#emailOtp").val(email);
                    $("#payerPhoneOtp").val(payerPhone);
                    $("#nationalIdOtp").val(nationalId);
                    $("#streetAddressOtp").val(streetAddress);
                    $("#cityOtp").val(city);
                    $("#provincezicbOtp").val(provincezicb);
                    $("#districtzicbOtp").val(districtzicb);
                    $("#genderOtp").val(gender);
                    $("#dateOfBirth").val(dateOfBirth);

                    var accountBalances = data.response.accountBalances;
                    accountBalances = JSON.parse(accountBalances);
                    console.log(accountBalances);
                    balanceList = accountBalances.balanceList;
                    console.log(balanceList);
                    balanceList = JSON.parse(balanceList);
                    var zicbwalletselect = $('#zicbwalletselect');
                    zicbwalletselect.empty();
                    zicbwalletselect.append($('<option>', {
						value: null,
						text: '--Select A ZICB Wallet Account--'
					}));
                    for(var mn=0; mn<balanceList.length; mn++)
                    {

						console.log(mn);
						console.log(balanceList[mn]);
						var v = balanceList[mn];
						console.log(v);

						var txt = v.walletType.replace("_", " ") + " - " + v.accountNumber + " (ZMW"+ v.currentBalance +")";
						var vl = ("ZICBWALLET###" + v.walletNumber);
						zicbwalletselect.append($('<option>', {
							value: vl,
							text: txt
						}));

					}


					//zicbwalletselect
					$("#addWalletMessageStr").html("Your ZICB Wallet Linked to Mobile Number Has Been Found. Please Proceed With Your Payment");
					$('html, body').animate({
                        scrollTop: $("#zicbwalletdiv").offset().top
                    }, 2000);
                    $("#addWalletMessage").show();
                    $('#zicbwalletselect').focus().select();

    			}
    			else if(data.response!=undefined && data.response.status==2)
    			{
    				//key = '#coop_member_count_' + data.cooperative_id;
    				//$( key ).html(data.member_count);
    				$('#errorotp1').hide();
    				$('#manageIncidencesModal').modal('toggle');
    				$('#newzicbotpModal').modal('toggle');

    				$("#isWalletOrAccountOtp").val(isWalletOrAccount);
                    $("#otpRefOtp").val(data.response.otpRef);
                    $("#firstNameOtp").val(firstName);
                    $("#lastNameOtp").val(lastName);
                    $("#emailOtp").val(email);
                    $("#payerPhoneOtp").val(payerPhone);
                    $("#nationalIdOtp").val(nationalId);
                    $("#streetAddressOtp").val(streetAddress);
                    $("#cityOtp").val(city);
                    $("#provincezicbOtp").val(provincezicb);
                    $("#districtzicbOtp").val(districtzicb);
                    $("#genderOtp").val(gender);
                    $("#dateOfBirthOtp").val(dateOfBirth);
    			}
    			else
    			{
    				$('#errorotp1').html(data.message!=undefined && data.message!=null ? data.message : 'We could not find any bank accounts linked to your mobile number. Please try again');
    				$('#errorotp1').show();
    				//$( ".floater" ).hide();
    				//$( "#newcustomerdiv" ).show();
    			}
    		},
    		error: function (e) {
    			//toastr.error(data.message);
    		}
    	});
	}
	else
	{
	    alert(5);
	}
    /**/
}
</script>
