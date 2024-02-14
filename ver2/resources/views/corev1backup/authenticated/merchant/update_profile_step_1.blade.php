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
                <h3 class="box-title">Step One - Update Merchant Bio-Data</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/merchants/update-merchant-account/step-one" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Merchant Company Name</label>

                        <div class="col-sm-9">
                            {{$merchant->companyName}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Contact Email Address</label>

                        <div class="col-sm-9">
                            {{$merchant->contactEmail}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Alternative Email Address</label>

                        <div class="col-sm-9">
                            <input type="email" name="altEmail" class="form-control" value="{{isset($merchant->altContactEmail) && $merchant->altContactEmail!=NULL ? $merchant->altContactEmail : ""}}" id="inputEmail3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Contact Mobile No</label>

                        <div class="col-sm-9">
                            <input type="text" name="mobileNo" class="form-control" id="inputEmail3" value="{{$merchant->contactMobile}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Alternative Mobile No</label>

                        <div class="col-sm-9">
                            <input type="text" name="altMobileNo" class="form-control" value="{{isset($merchant->altContactMobile) && $merchant->altContactMobile!=NULL ? $merchant->altContactMobile : ""}}" id="inputEmail3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Address Line 1</label>

                        <div class="col-sm-9">
                            <input type="text" name="addressLine1" class="form-control" value="{{$merchant->addressLine1}}" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Address Line 2</label>

                        <div class="col-sm-9">
                            <input type="text" name="addressLine2" class="form-control" value="{{$merchant->addressLine2}}" id="inputEmail3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Contact Person</label>

                        <div class="col-sm-4">
                            <input type="text" name="contactPerson" class="form-control" value="{{$merchant->companyName}}" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Company Logo</label>

                        <div class="col-sm-9">
                            <img style="float:left" src="/merchants/bio-data/{{$merchant->companyLogo==NULL ? "" : $merchant->companyLogo}}" height="30px" width="30px">&nbsp;&nbsp;
                            <input style="float:left" type="file" name="companyLogo" class="" id="inputEmail3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Certificate of Incorporation</label>

                        <div class="col-sm-9">
                            <img style="float:left" src="/merchants/bio-data/{{$merchant->certificateOfIncorporation==NULL ? "" : $merchant->certificateOfIncorporation}}" height="30px" width="30px">&nbsp;&nbsp;
                            <input style="float:left" type="file" name="companyCertificate" class="" id="inputEmail3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Company Registration No<br>
                        </label>

                        <div class="col-sm-9">
                            <input type="text" name="companyRegNo" class="form-control" value="{{$merchant->companyRegNo}}" id="inputEmail3" required>
                        </div>
                    </div>
                </div>


                <input type="hidden" name="merchantId" value="{{$merchantId}}">
                <input type="hidden" name="mzcht" value="{{\Crypt::encrypt($merchant)}}">
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Next</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') Update Merchant Profile @stop
@section('scripts')

@stop