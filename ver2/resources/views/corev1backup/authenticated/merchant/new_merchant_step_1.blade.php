@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><strong>Step 1/4 - Merchant Bio-Data</strong></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php $countries = json_decode(\Auth::user()->all_countries);?>

            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/merchants/new-merchant-step-1" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="panel panel-info">
                        <div class="panel-body" style="background-color: #d9edf7 !important">
                            <small>All items with a red asterisk are required</small>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Merchant Company Name<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <input name="companyName" value="{{\Input::old('companyName') ? \Input::old('companyName') : ''}}" type="text" class="form-control" id="inputEmail3" placeholder="Provide Merchants Company Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Country of Operation<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <div class="col col-md-12" style="padding-left:0px !important;">
                                <select name="operationCountry" class="form-control" required>
                                    <option value>-Country Code-</option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}" {{\Input::old('operationCountry') && \Input::old('operationCountry')==$country->id ? 'selected' : ''}}>{{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Contact Mobile No<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <div class="col col-md-3" style="padding-left:0px !important;">
                                <select name="countrycode" class="form-control" required>
                                    <option value>-Country Code-</option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->mobileCode}}" {{\Input::old('countrycode') && \Input::old('countrycode')==$country->mobileCode ? 'selected' : ''}}>+{{$country->mobileCode}} {{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col col-md-9" style="padding-left:0px !important; padding-right: 0px !important;">
                                <input name="mobileNo" value="{{\Input::old('mobileNo') ? \Input::old('mobileNo') : ''}}"  type="text" class="form-control" placeholder="e.g. 803000000" id="inputEmail3" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Alternative Mobile No<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <div class="col col-md-3" style="padding-left:0px !important;">
                                <select name="altcountrycode" class="form-control" required>
                                    <option value>-Country Code-</option>
                                    @foreach($countries as $country)
                                        <option value="{{$country->mobileCode}}" {{\Input::old('altcountrycode') && \Input::old('altcountrycode')==$country->mobileCode ? 'selected' : ''}}>+{{$country->mobileCode}} {{$country->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col col-md-9" style="padding-left:0px !important; padding-right: 0px !important;">
                                <input name="altMobileNo" value="{{\Input::old('altMobileNo') ? \Input::old('altMobileNo') : ''}}" type="text" class="form-control" id="inputEmail3" placeholder="e.g. 803000000">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Contact Email Address<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <input name="email" value="{{\Input::old('email') ? \Input::old('email') : ''}}" type="text" class="form-control" id="inputEmail3" required placeholder="This will also serve as your username e.g. xyz@gmail.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Alternative Email Address</label>

                        <div class="col-sm-9">
                            <input name="altEmail" value="{{\Input::old('altEmail') ? \Input::old('altEmail') : ''}}" type="email" class="form-control" id="inputEmail3" placeholder="Optional">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Address Line 1<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <input name="addressLine1" value="{{\Input::old('addressLine1') ? \Input::old('addressLine1') : ''}}" type="text" class="form-control" id="inputEmail3" required placeholder="1st Line of address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Address Line 2<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <input name="addressLine2" value="{{\Input::old('addressLine2') ? \Input::old('addressLine2') : ''}}" type="text" class="form-control" id="inputEmail3" placeholder="2nd Line of address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Contact Person<span style="color:red !important">*</span></label>

                        <div class="col-sm-4">
                            <input name="contactPerson" value="{{\Input::old('contactPerson') ? \Input::old('contactPerson') : ''}}" type="text" class="form-control" id="inputEmail3" required placeholder="Provide Companys Representatives Full Names">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Company Logo<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <input name="companyLogo" type="file" class="form-control" id="inputEmail3" required placeholder="Select Merchants Company Logo">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Certificate of Incorporation<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <input name="companyCertificate" type="file" class="form-control" id="inputEmail3" required placeholder="Select Merchants Certificate of Incorporation">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Company Registration No<span style="color:red !important">*</span><br>
                        </label>

                        <div class="col-sm-9">
                            <input type="text" value="{{\Input::old('companyRegNo') ? \Input::old('companyRegNo') : ''}}" name="companyRegNo" class="form-control" id="inputEmail3" required placeholder="Companys Registration Number">
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <a onclick="javascript:history.back(-1)" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Cancel</a>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Next <i class="fa fa-arrow-right"></i></button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') New Merchant Profile @stop
@section('scripts')
<style>
    .control-label{
        font-weight: 100 !important;
        text-align: left !important;
        padding-left: 30px !important;
    }
</style>
@stop