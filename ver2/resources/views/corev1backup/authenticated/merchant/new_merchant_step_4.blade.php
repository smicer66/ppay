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
                <h3 class="box-title">Step 4/4 - Confirm Merchant Details</h3>
            </div>


            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/merchants/new-merchant-step-four" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>Merchant Bio-Data</strong></h3>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-5 control-label">Merchant Company Name</label>

                        <div class="col-sm-7">
                            {{in_array('companyName', $arrayKeys) ? $dataView['companyName'] : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-5 control-label">Contact Mobile No</label>

                        <div class="col-sm-7">
                            {{in_array('countrycode', $arrayKeys) ? "+".$dataView['countrycode'] : "N/A"}}{{in_array('mobileNo', $arrayKeys) ? $dataView['mobileNo'] : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-5 control-label">Alternative Mobile No</label>

                        <div class="col-sm-7">
                            {{in_array('altcountrycode', $arrayKeys) ? "+".$dataView['altcountrycode'] : "N/A"}}{{in_array('altMobileNo', $arrayKeys) ? $dataView['altMobileNo'] : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-5 control-label">Contact Email Address</label>

                        <div class="col-sm-7">
                            {{in_array('email', $arrayKeys) ? $dataView['email'] : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-5 control-label">Alternative Email Address</label>

                        <div class="col-sm-7">
                            {{in_array('altEmail', $arrayKeys) ? $dataView['altEmail'] : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-5 control-label">Address Line 1</label>

                        <div class="col-sm-7">
                            {{in_array('addressLine1', $arrayKeys) ? $dataView['addressLine1'] : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-5 control-label">Address Line 2</label>

                        <div class="col-sm-7">
                            {{in_array('addressLine2', $arrayKeys) ? $dataView['addressLine2'] : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-5 control-label">Contact Person</label>

                        <div class="col-sm-7">
                            {{in_array('contactPerson', $arrayKeys) ? $dataView['contactPerson'] : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-5 control-label">Company Logo</label>

                        <div class="col-sm-7">
                            <img src="{{in_array('companyLogo', $arrayKeys) ? '/merchants/bio-data/'.$dataView['companyLogo'] : "N/A"}}" height="30px" width="30px">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-5 control-label">Certificate of Incorporation</label>

                        <div class="col-sm-7">
                            <img src="{{in_array('companyCertificate', $arrayKeys) ? '/merchants/bio-data/'.$dataView['companyCertificate'] : "N/A"}}" height="30px" width="30px">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-5 control-label">Company Registration No<br>
                        </label>

                        <div class="col-sm-7">
                            {{in_array('companyRegNo', $arrayKeys) ? $dataView['companyRegNo'] : "N/A"}}
                        </div>
                    </div>








                    <div class="box-header with-border">
                        <h3 class="box-title"><strong>Merchant Bank Account Details</strong></h3>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-5 control-label">Merchant Scheme</label>

                        <div class="col-sm-7">
                            {{$merchantScheme}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-5 control-label">Merchant Bank</label>

                        <div class="col-sm-7">
                            {{$merchantBank}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-5 control-label">Bank Account No</label>

                        <div class="col-sm-7">
                            {{in_array('bankAccountNo', $arrayKeys) ? $dataView['bankAccountNo'] : "N/A"}}
                        </div>
                    </div>















                    @if($deviceType=='WEB')
                        <div class="box-header with-border">
                            <h3 class="box-title"><strong>Web Payments Device Details</strong></h3>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-5 control-label">Domain URL</label>

                            <div class="col-sm-7">
                                {{in_array('domainURL', $arrayKeys) ? $dataView['domainURL'] : "N/A"}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-5 control-label">Forward to URL (Successful Transactions)</label>

                            <div class="col-sm-7">
                                {{in_array('forwardSuccess', $arrayKeys) ? $dataView['forwardSuccess'] : "N/A"}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-5 control-label">Forward to URL (Failure Transactions)</label>

                            <div class="col-sm-7">
                                {{in_array('forwardFail', $arrayKeys) ? $dataView['forwardFail'] : "N/A"}}
                            </div>
                        </div>
                    @elseif($deviceType=='POS')
                        <div class="box-header with-border">
                            <h3 class="box-title">Point of Sale Device Details</h3>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-5 control-label">POS Device Code</label>

                            <div class="col-sm-7">
                                {{in_array('posDeviceCode', $arrayKeys) ? $dataView['posDeviceCode'] : "N/A"}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" name="posDeviceSerialNo" class="col-sm-5 control-label">POS Device Serial No</label>

                            <div class="col-sm-7">
                                {{in_array('posDeviceSerialNo', $arrayKeys) ? $dataView['posDeviceSerialNo'] : "N/A"}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-5 control-label">Transaction URLs</label>

                            <div class="col-sm-7">
                                {{in_array('posForwardSuccess', $arrayKeys) ? $dataView['posForwardSuccess'] : "N/A"}}
                            </div>
                        </div>
                    @elseif($deviceType=='ATM')
                        <div class="box-header with-border">
                            <h3 class="box-title">Automated Teller Machine Device Details</h3>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-5 control-label">ATM Device Code</label>

                            <div class="col-sm-7">
                                {{in_array('atmDeviceCode', $arrayKeys) ? $dataView['atmDeviceCode'] : "N/A"}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-5 control-label">ATM Device Serial No</label>

                            <div class="col-sm-7">
                                {{in_array('atmDeviceSerialNo', $arrayKeys) ? $dataView['atmDeviceSerialNo'] : "N/A"}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-5 control-label">Transaction URLs</label>

                            <div class="col-sm-7">
                                {{in_array('atmForwardSuccess', $arrayKeys) ? $dataView['atmForwardSuccess'] : "N/A"}}
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-5 control-label">Notify Email of Transactions</label>

                        <div class="col-sm-7">
                            {{in_array('notifyEmail', $arrayKeys) ? $dataView['notifyEmail'] : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-5 control-label">Notify Mobile No of Transactions</label>

                        <div class="col-sm-7">
                            {{in_array('notifyMobile', $arrayKeys) ? "+".$dataView['notifycountrycode']."".$dataView['notifyMobile'] : "N/A"}}
                        </div>
                    </div>
                </div>

                <input type="hidden" name="data" value="{{$data}}">
                <!-- /.box-body -->
                <div class="box-footer">
                    <a onclick="javascript:history.back(-1)" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Go Back</a>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Create Merchant Account&nbsp;&nbsp;&nbsp; <i class="fa fa-save"></i></button>
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