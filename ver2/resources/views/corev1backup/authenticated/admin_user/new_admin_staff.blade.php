@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Staff @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">New Administrative Staff</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/register" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Role Type</label>

                        <div class="col-sm-9">
                            {!! Form::select('role_type', ([null=>'-Select A Role-'] + $rolesList), isset($usr) ? $usr->role_type : null, ['id' => 'role_type', 'class' => 'form-control', 'required' => 'required', 'onchange' =>'javascript:displayBankDetail()']) !!}
                        </div>
                    </div>
                    <div id="bankSection" style="display:none">
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

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">First Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="firstName"  required  name="firstName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Last Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="lastName"  required  name="lastName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Other Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="otherName"   name="otherName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Profile Pix</label>

                        <div class="col-sm-9">
                            <input type="file" class="form-control" id="profilePix"   name="profilePix">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Email Address</label>

                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="contactEmail"  required name="contactEmail">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Contact Mobile</label>

                        <div class="col-sm-9">
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
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Date of Birth</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3"  name="dateOfBirth">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Gender</label>

                        <div class="col-sm-9">

                            {!! Form::select('gender', get_genders(), isset($usr) ? $usr->gender : null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Address Line 1</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3"  required name="addressLine1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Address Line 2</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3"   name="addressLine1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Province & District</label>

                        <div class="col-sm-4">
                            {!! Form::select('province', [null => 'Select One'] + $all_provinces, isset($usr) ? $usr->gender : null, ['class' => 'form-control', 'id' => 'province']) !!}
                        </div>
                        <div class="col-sm-4 pull-right">
                            <select class="form-control" name="locationDistrict_id" id="district" required>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Create Admin Staff Account</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') New Admin Staff Account @stop
@section('scripts')
<script>

    function displayBankDetail()
    {
        var role_type = document.getElementById('role_type').value;
        console.log("role_type == " + role_type);
        document.getElementById('bankSection').style.display = 'none';
        if(role_type=='BANK_STAFF'){
            document.getElementById('bankSection').style.display = 'block';
        }

    }


    jQuery(function () {
        $("#province").on('change', function () {
            alert("We testify");
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