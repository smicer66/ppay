<div class="modal fade" id="newzicbotpModal" tabindex="-1" role="dialog" aria-labelledby="newzicbotpModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg col-md-12" role="document" style="width: auto !important; margin: auto !important; padding: 0px !important;">
		<div class="modal-content">
			<form method="post" id="newzicbotpform" class="form">
			    <?php
				$newInput = \Crypt::decrypt($input);
				?>
				 <input type="hidden" name="isWalletOrAccount" id="isWalletOrAccountOtp" value="">
				 <input type="hidden" name="otpRef" id="otpRefOtp" value="">
				 <input type="hidden" name="firstName" id="firstNameOtp" value="">
				 <input type="hidden" name="lastName" id="lastNameOtp" value="">
				 <input type="hidden" name="email" id="emailOtp" value="">
				 <input type="hidden" name="payerPhone" id="payerPhoneOtp" value="">
				 <input type="hidden" name="nationalId" id="nationalIdOtp" value="">
				 <input type="hidden" name="streetAddress" id="streetAddressOtp" value="">
				 <input type="hidden" name="city" id="cityOtp" value="">
				 <input type="hidden" name="provincezicb" id="provincezicbOtp" value="">
				 <input type="hidden" name="districtzicb" id="districtzicbOtp" value="">
				 <input type="hidden" name="gender" id="genderOtp" value="">
				 <input type="hidden" name="dateOfBirth" id="dateOfBirthOtp" value="">

			     <input type="hidden" name="orderId" id="orderId" value="{{isset($orderId) ? $orderId : ''}}">
			     <input type="hidden" name="serviceTypeId" id="serviceTypeId" value="{{isset($newInput['serviceTypeId']) ? $newInput['serviceTypeId'] : ''}}">
			     <input type="hidden" name="merchantCode" id="merchantCode" value="{{isset($newInput['merchantId']) ? $newInput['merchantId'] : ''}}">
			     <input type="hidden" name="deviceCode" id="deviceCode" value="{{isset($newInput['deviceCode']) ? $newInput['deviceCode'] : ''}}">
			     <input type="hidden" name="responseUrl" id="responseUrl" value="{{isset($newInput['responseurl']) ? $newInput['responseurl'] : ''}}">
				<div class="modal-header bg-primary" style="color: #fff; padding-bottom: 40px">
					<h5 class="modal-title col-md-11" id="newzicbotpModalLabel">Step Two: Verify Your Mobile Number</h5>
					<button type="button" class="close col-md-1" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true" class="pull-right">&times;</span>
					</button>
				</div>
				<div class="modal-body col-md-12" style="display: inline-block;">


						<div class="col-md-12">
							<div class="form-group">
								<label><strong>Enter Your One-Time Password:<span style="color: red">*</span></strong></label>
								<div class="col-md-12" style="padding-left: 0px !important;">
    								<div class="col-md-2" style="padding-left:0px !important; padding-right:0px !important;">
    								    <input maxlength="1" type="text" name="otp1" id="otp1" value="" required class="otp col col-md-11" onkeyup="onKeyUpEvent(1, event)" onfocus="onFocusEvent(1)" />
							        </div>
    								<div class="col-md-2" style="padding-left:-0px !important; padding-right:0px !important;">
    								    <input maxlength="1" type="text" name="otp2" id="otp2" value="" required class="otp col col-md-11" onkeyup="onKeyUpEvent(2, event)" onfocus="onFocusEvent(2)" />
							        </div>
    								<div class="col-md-2" style="padding-left:-0px !important; padding-right:0px !important;">
    								    <input maxlength="1" type="text" name="otp3" id="otp3" value="" required class="otp col col-md-11" onkeyup="onKeyUpEvent(3, event)" onfocus="onFocusEvent(3)" />
							        </div>
    								<div class="col-md-2" style="padding-left:-0px !important; padding-right:0px !important;">
    								    <input maxlength="1" type="text" name="otp4" id="otp4" value="" required class="otp col col-md-11" onkeyup="onKeyUpEvent(4, event)" onfocus="onFocusEvent(4)" />
							        </div>
    								<div class="col-md-2" style="padding-left:-0px !important; padding-right:0px !important;">
    								    <input maxlength="1" type="text" name="otp5" id="otp5" value="" required class="otp col col-md-11" onkeyup="onKeyUpEvent(5, event)" onfocus="onFocusEvent(5)" />
							        </div>
    								<div class="col-md-2" style="padding-left:-0px !important; padding-right:0px !important;">
    								    <input maxlength="1" type="text" name="otp6" id="otp6" value="" required class="otp col col-md-11" onkeyup="onKeyUpEvent(6, event)" onfocus="onFocusEvent(6)" />
							        </div>
    							</div>
							</div>
						</div>

				</div>
				<div class="modal-footer" style="clear:both !important">

					<a onclick="proceedWithOTPVerify()" style="margin-top: 5px" class="btn btn-success pull-right">Proceed</a>
				</div>
			</form>
		</div>
	</div>
</div>

<style>
    label.error{
        color:red;
    }

    .otp{
        height: 45px;
        font-size: 25px;
        text-align: center;
        border: 1px solid #000000;
        -webkit-appearance: none;
        margin: 0;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" type="text/javascript"></script>
<script>
function getCodeBoxElement(index) {
    return document.getElementById('otp' + index);
}


function onKeyUpEvent(index, event) {
    const eventCode = event.which || event.keyCode;
    if (getCodeBoxElement(index).value.length === 1) {
      if (index !== 6) {
        getCodeBoxElement(index+ 1).focus();
      } else {
        getCodeBoxElement(index).blur();
        // Submit code
        console.log('submit code ');
      }
    }
    if (eventCode === 8 && index !== 1) {
      getCodeBoxElement(index - 1).focus();
    }
}


function onFocusEvent(index) {
    for (item = 1; item < index; item++) {
      const currentElement = getCodeBoxElement(item);
      if (!currentElement.value) {
          currentElement.focus();
          break;
      }
    }
}

function proceedWithOTPVerify()
{
    var form = $('#newzicbotpform')[0];
    $("#newzicbotpform").validate(
        {
            rules: {
                otp1: {
                    required: true
                },
                otp2: {
                    required: true
                },
                otp3: {
                    email: true
                },
                otp4: {
                    required: true
                },
                otp5: {
                    required: true
                },
                otp6: {
                    required: true
                },
            },
            messages: {
                otp1: "Provide the OTP",
                otp2: "Provide the OTP",
                otp3: "Provide the OTP",
                otp4: "Provide the OTP",
                otp5: "Provide the OTP",
                otp6: "Provide the OTP"

            },
        }
    );
	var data = new FormData(form);
    $.ajax({
		type: "POST",
		enctype: 'multipart/form-data',
		url: "/api/verify-otp-new-zicb-wallet",
		data: data,
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		success: function (data) {
		    console.log(data);
			if(data.response!=undefined && data.response.status==1)  //OTP Verified
			{
				//key = '#coop_member_count_' + data.cooperative_id;
				//$( key ).html(data.member_count);
				$('#errorotp1').hide();
				$('#newzicbotpModal').modal('toggle');

				//var bank = data.response.
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

</script>
