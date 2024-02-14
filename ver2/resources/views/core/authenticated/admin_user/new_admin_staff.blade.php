@extends('core.authenticated.layout.layout1')
@section('title')  ProbasePay | Pool Account @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="col-md-6 col-sm-12">
<div class="row">
  <div class="col-sm-12">
    <div class="element-wrapper">
      <div class="element-box">
	
            <form class="form-horizontal" autocomplete="off" id="userForm" action="/potzr-staff/register" method="post" enctype="multipart/form-data" data-toggle="validator">

          	<h5 class="form-header">
            	New User
          	</h5>
          	<div class="form-desc">
            	Add new users to the Bevura/Probase System
          	</div>


                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Role Type</label>

                        <div class="col-sm-9">
                            {!! Form::select('role_type', ([null=>'-Select A Role-'] + $rolesList), isset($usr) ? $usr->role_type : null, ['id' => 'role_type', 'class' => 'form-control', 'required' => 'required', 'onchange' =>'javascript:displayBankDetail()']) !!}
                        </div>
                    </div>
                    <div class="sections" id="bankSection" style="display:none">
                        <div class="form-group">
                            <label for="bank" class="col-sm-3 control-label">Bank</label>

                            <div class="col-sm-9">
                                <select class="form-control" name="bankId">
                                    <option>-Select A Bank-</option>
                                    @foreach($all_banks as $bank)
                                        <option value="{{$bank->id}}">{{$bank->bankName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Branch Code</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="branchCode"  name="branchCode">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Identity Number</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="identityNumber" name="identityNumber">
                            </div>
                        </div>
                    </div>
                    <div class="sections" id="agentSection" style="display:none">
                        <div class="form-group">
                            <label for="bank" class="col-sm-3 control-label">Company Name</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="companyName"  name="companyName">
                            </div>
                        </div>                        
			   <div class="form-group">
                            <label for="bank" class="col-sm-3 control-label">Agent Bevura Device Code</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="primaryAgentDeviceCode"  name="primaryAgentDeviceCode">
                            </div>
                        </div>
                    </div>

                    <div class="form-group agent customer accountant potzr exco" style="display:none">
                        <label for="inputEmail3" class="col-sm-12 control-label"><span class="agentRep">Agent Representatives' </span>First Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="firstName"  required  name="firstName">
                        </div>
                    </div>
                    <div class="form-group agent customer accountant potzr exco" style="display:none">
                        <label for="inputEmail3" class="col-sm-12 control-label"><span class="agentRep">Agent Representatives' </span>Last Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="lastName"  required  name="lastName">
                        </div>
                    </div>
                    <div class="form-group agent customer accountant potzr exco" style="display:none">
                        <label for="inputEmail3" class="col-sm-12 control-label"><span class="agentRep">Agent Representatives' </span>Other Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="otherName"   name="otherName">
                        </div>
                    </div>
                    <div class="form-group agent customer accountant potzr exco" style="display:none">
                        <label for="inputEmail3" class="col-sm-12 control-label"><span class="agentRep">Agent Representatives' </span>Profile Pix</label>

                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="profilePix"   name="profilePix">
                        </div>
                    </div>
                    <div class="form-group agent customer accountant potzr exco" style="display:none">
                        <label for="inputEmail3" class="col-sm-12 control-label"><span class="agentRep">Agent Representatives' </span>Email Address</label>

                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="contactEmail"  required name="contactEmail">
                        </div>
                    </div>
                    <div class="form-group agent customer accountant potzr exco" style="display:none">
                        <label for="inputEmail3" class="col-sm-12 control-label"><span class="agentRep">Agent Representatives' </span>Contact Mobile</label>

                        <div class="col-sm-9">
				<div class="row col-md-12">
                            	<div class="col col-md-4" style="padding:0px !important">
                                		<select class="form-control" id="countryalt" style="width:none !important; padding:0px !important; " name="countryalt">
                                    		<option value="">---</option>
                                    		@foreach($all_countries as $key => $country)
                                        		<option value="{{$country->mobileCode}}">+{{$country->mobileCode}}</option>
                                    		@endforeach
                                		</select>
                           		</div>
                            	<div class="col col-md-8" style="padding:0px !important">
                                		<!--<input required value="0903780448" type="text" name="phoneNumber" class="form-control" style="width:none !important;  font-size:11px;" id="exampleInputPassword1" placeholder="">-->
                                		<input type="text" class="form-control" id="contactMobile"  required name="contactMobile">
                            	</div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group agent customer accountant potzr exco" style="display:none">
                        <label for="inputEmail3" class="col-sm-12 control-label"><span class="agentRep">Agent Representatives' </span>Date of Birth</label>

                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="inputEmail3"  name="dateOfBirth" required>
                        </div>
                    </div>
                    <div class="form-group agent customer accountant potzr exco" style="display:none">
                        <label for="inputEmail3" class="col-sm-12 control-label"><span class="agentRep">Agent Representatives' </span>Gender</label>

                        <div class="col-sm-9">

                            {!! Form::select('gender', get_genders(), isset($usr) ? $usr->gender : null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group agent customer accountant potzr exco" style="display:none">
                        <label for="inputEmail3" class="col-sm-12 control-label"><span class="agentRep">Agent Representatives' </span>Address Line 1</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3"  required name="addressLine1">
                        </div>
                    </div>
                    <div class="form-group agent customer accountant potzr exco" style="display:none">
                        <label for="inputEmail3" class="col-sm-12 control-label"><span class="agentRep">Agent Representatives' </span>Address Line 2</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3"   name="addressLine1">
                        </div>
                    </div>
                    <div class="form-group agent customer accountant potzr exco" style="display:none">
                        <label for="inputEmail3" class="col-sm-12 control-label"><span class="agentRep">Agent Representatives' </span>Province & District</label>

				<div class="row col-md-12">
                        		<div class="col-sm-4">
                            	{!! Form::select('province', [null => 'Select One'] + $all_provinces, isset($usr) ? $usr->gender : null, ['class' => 'form-control', 'id' => 'province']) !!}
                        		</div>
                        		<div class="col-sm-4 pull-right">
                            		<select class="form-control" name="locationDistrict_id" id="district" required>
                            		</select>
                        		</div>
                        	</div>
                    </div>
                    <div class="form-group customer" style="display:none">
                        <label for="inputEmail3" class="col-sm-12 control-label">Auto-Generate Password</label>

                        <div class="col-sm-9">
                            {!! Form::select('setRegistrationCode', ['1'=>'Yes', '0'=>'No'], null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer col-md-12">
                    <a class="btn btn-primary step-trigger-btn" onclick="submitForm()" style="cursor: pointer !important;">Create User</a></div>
                <!-- /.box-footer -->
            </form>
	</div>
    </div>
  </div>
</div>
</div>
@stop
@section('section_title') New Admin Staff Account @stop
@section('scripts')
<script>

    function displayBankDetail()
    {
	 $('.agentRep').hide();
        var role_type = document.getElementById('role_type').value;
        console.log("role_type == " + role_type);
        document.getElementById('bankSection').style.display = 'none';
	 document.getElementById('agentSection').style.display = 'none';
	 $('.agent').hide();
	 $('.customer').hide();
	 $('.accountant').hide();
	 $('.potzr').hide();
        if(role_type=='BANK_STAFF'){
            document.getElementById('bankSection').style.display = 'block';
        }
	 else if(role_type=='AGENT'){
            	document.getElementById('agentSection').style.display = 'block';
		$('.customer').hide();
		$('.agent').show();
		$('.accountant').hide();
		$('.potzr').hide();
		$('.exco').hide();
		$('.agentRep').show();

        }
	 else if(role_type=='CUSTOMER'){
		$('.agentRep').hide();
		$('.accountant').hide();
		$('.potzr').hide();
		$('.exco').hide();
		$('.customer').show();
        }
	 else if(role_type=='ACCOUNTANT'){
		$('.agentRep').hide();
		$('.customer').hide();
		$('.potzr').hide();
		$('.exco').hide();
		$('.accountant').show();
        }
	 else if(role_type=='POTZR_STAFF'){
		$('.agentRep').hide();
		$('.customer').hide();
		$('.accountant').hide();
		$('.exco').hide();
		$('.potzr').show();
        }
	 else if(role_type=='EXCO_STAFF'){
		$('.agentRep').hide();
		$('.customer').hide();
		$('.accountant').hide();
		$('.potzr').hide();
		$('.exco').show();
        }

    }


	function submitForm()
	{
		$('#userForm').submit();
	}


    jQuery(function () {
        $("#province").on('change', function () {

            var $this = $(this);
            var district = $("#district");
            var provinceId = $(this).val();
            //lga.html('loading...');
            $.ajax({
                url: '/utility/services/pull-district/' + provinceId,
                dataType: 'json',
                success: function (resp) {
                    if (resp.status === 1) {
                        $.each(resp.data, function (k, v) {
                            district.append($('<option>', {
                                value: k,
                                text: v
                            }));
                        });
                        district.prepend($('<option>', {
                            text: 'Select District',
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
    });
</script>
@stop


@section('styles')
<style>
.agentRep{
	//display: none !important;
}
</style>
@stop