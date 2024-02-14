@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Teller @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Update Customer Bio-Data</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/bank-teller/customers/update-customer" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">First Name</label>

                        <div class="col-sm-9">
                            <input type="text" value="{{$customer->firstName}}" class="form-control" name="firstName" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Last Name</label>

                        <div class="col-sm-9">
                            <input type="text" value="{{$customer->lastName}}" class="form-control" name="lastName" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Other Name</label>

                        <div class="col-sm-9">
                            <input type="text" value="{{$customer->otherName}}" class="form-control" name="otherName" id="inputEmail3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Address Line 1</label>

                        <div class="col-sm-9">
                            <input type="text" value="{{$customer->addressLine1}}" class="form-control" name="addressLine1" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Address Line 2</label>

                        <div class="col-sm-9">
                            <input type="text" value="{{$customer->addressLine2}}" class="form-control" name="addressLine2" id="inputEmail3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Country Located</label>

                        <div class="col-sm-4">
                            <select class="form-control" name="country"  id="country_current" required>
                                <option>-Select One-</option>
                                @foreach($all_countries as $country)
                                    <option value="{{$country->id}}" {{(isset($customer->locationDistrict->countryId) && $customer->locationDistrict->countryId==$country->id) ? 'selected' : ''}}>{{$country->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Province & District</label>

                        <div class="col-sm-4">
                            <select class="form-control" name="province"  id="province" required>
                                <option>-Select One-</option>
                                @foreach($all_provinces as $province)
                                    @if(isset($customer->locationDistrict->countryId) && $customer->locationDistrict->countryId = $province->countryId)
                                        <option value="{{$province->id}}" {{(isset($customer->locationDistrict) && $customer->locationDistrict->provinceId==$province->id) ? 'selected' : ''}}>{{$province->provinceName}}</option>
                                    @else
                                        <option value="{{$province->id}}" {{(isset($customer->locationDistrict) && $customer->locationDistrict->provinceId==$province->id) ? 'selected' : ''}}>{{$province->provinceName}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4 pull-right">
                            <select class="form-control" name="district" id="district" required>
                                <option>-Select One-</option>
                                <option value="{{$customer->locationDistrict->id}}">{{$customer->locationDistrict->name}}</option>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Gender</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="gender">
                                <option value="MALE" {{$customer->gender=='MALE' ? 'selected' : ''}}>Male</option>
                                <option value="FEMALE" {{$customer->gender=='FEMALE' ? 'selected' : ''}}>Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Date Of Birth</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{date('Y-m-d', strtotime($customer->dateOfBirth))}}" name="dateOfBirth" id="inputEmail3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Contact Mobile No</label>

                        <div class="col-sm-9">
                            <div class="col col-md-4" style="padding:0px !important;">
                                <select class="form-control" id="country" name="country" style="width:none !important; padding-left:0px !important; " required>
                                    <option value="">---</option>
                                    @foreach($all_countries as $key => $country)
                                        <option value="{{$country->mobileCode}}" {{(isset($customer->contactMobile) && substr($customer->contactMobile, 0, 3)==$country->mobileCode) ? 'selected' : ''}}>+{{($country->mobileCode)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col col-md-8" style="padding:0px !important; padding-left:30px !important">
                                <!--<input required value="0903780448" type="text" name="phoneNumber" class="form-control" style="width:none !important;  font-size:11px;" id="exampleInputPassword1" placeholder="">-->
                                <input type="text" class="form-control" value="{{substr($customer->contactMobile, 3)}}" name="mobileNo" id="inputEmail3" required>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Alternative Mobile No</label>

                        <div class="col-sm-9">
                            <div class="col col-md-4" style="padding:0px !important">
                                <select class="form-control" id="countryalt" style="width:none !important; padding-left:0px !important; " name="countryalt" required>
                                    <option value="">---</option>
                                    @foreach($all_countries as $key => $country)
                                        <option value="{{$country->mobileCode}}" {{(isset($customer->altContactMobile) && substr($customer->altContactMobile, 0, 3)==$country->mobileCode) ? 'selected' : ''}}>+{{($country->mobileCode)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col col-md-8" style="padding:0px !important; padding-left:30px !important">
                                <!--<input required value="0903780448" type="text" name="phoneNumber" class="form-control" style="width:none !important;  font-size:11px;" id="exampleInputPassword1" placeholder="">-->
                                <input type="text" class="form-control" value="{{isset($customer->altContactMobile) ? substr($customer->altContactMobile, 3) : ''}}" name="altMobileNo" id="inputEmail3" required>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Contact Email Address</label>

                        <div class="col-sm-9">
                            {{$customer->contactEmail}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Alternative Email Address</label>

                        <div class="col-sm-9">
                            <input type="email" class="form-control" value="{{isset($customer->altContactEmail) ? $customer->altContactEmail : ''}}" id="inputEmail3" name="altEmail">
                        </div>
                    </div>
                </div>

                <input type="hidden" name="customerId" value="{{\Crypt::encrypt($customer->id)}}">
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Save</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') Update Customer Profile @stop
@section('scripts')
    <script>

            $("#country_current").on('change', function () {
                var $this = $(this);
                var province = $("#province");
                var countryId = $(this).val();
                var district = $("#district");
                //lga.html('loading...');
                $.ajax({
                    url: '/utility/services/pull-province/' + countryId,
                    dataType: 'json',
                    success: function (resp) {
                        province.empty();
                        district.empty();
                        if (resp.status === 1) {
                            $.each(resp.data, function (k, v) {
                                province.append($('<option>', {
                                    value: k + '_' + v,
                                    text: v
                                }));
                            });
                            province.prepend($('<option>', {
                                text: 'Select Province',
                                value: null
                            }));

                            district.prepend($('<option>', {
                                text: '-Select District-',
                                value: null
                            }));
                        }
                    },
                    complete: function () {

                    }
                });

            });

            $("#province").on('change', function () {
                var $this = $(this);
                var district = $("#district");
                var provinceId = $(this).val();
                //lga.html('loading...');
                $.ajax({
                    url: '/utility/services/pull-district/' + provinceId,
                    dataType: 'json',
                    success: function (resp) {
                        district.empty();
                        if (resp.status === 1) {

                            $.each(resp.data, function (k, v) {
                                district.append($('<option>', {
                                    value: k + '_' + v,
                                    text: v
                                }));
                            });
                            district.prepend($('<option>', {
                                text: '-Select District-',
                                value: null
                            }));
                        }
                    },
                    complete: function () {

                    }
                });

            });




    </script>
@stop