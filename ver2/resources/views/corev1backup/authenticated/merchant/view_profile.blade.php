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
                <h3 class="box-title">Merchant Bio-Data</h3>
            </div>


            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/merchants/new-merchant-step-four" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Merchant Company Name</label>

                        <div class="col-sm-9">
                            {{ isset($merchant->companyName) ? $merchant->companyName : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Contact Mobile No</label>

                        <div class="col-sm-9">
                            {{ isset($merchant->contactMobile) ? $merchant->contactMobile : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Alternative Mobile No</label>

                        <div class="col-sm-9">
                            {{ isset($merchant->altContactMobile) ? $merchant->altContactMobile : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Contact Email Address</label>

                        <div class="col-sm-9">
                            {{ isset($merchant->user) ? $merchant->user->username : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Alternative Email Address</label>

                        <div class="col-sm-9">
                            {{ isset($merchant->altContactEmail) ? $merchant->altContactEmail : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Address Line 1</label>

                        <div class="col-sm-9">
                            {{ isset($merchant->addressLine1) ? $merchant->addressLine1 : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Address Line 2</label>

                        <div class="col-sm-9">
                            {{ isset($merchant->addressLine2) ? $merchant->addressLine2 : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Company Logo</label>

                        <div class="col-sm-9">
                            @if(isset($merchant->companyLogo) && $merchant->companyLogo!=null)
                            <img src="{{ isset($merchant->companyLogo) ? '/merchants/bio-data/'.$merchant->companyLogo : "N/A"}}" height="30px" width="30px">
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Certificate of Incorporation</label>

                        <div class="col-sm-9">
                            @if(isset($merchant->certificateOfIncorporation) && $merchant->certificateOfIncorporation!=null)
                            <img src="{{ isset($merchant->certificateOfIncorporation) ? '/merchants/bio-data/'.$merchant->certificateOfIncorporation : "N/A"}}" height="30px" width="30px">
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Company Registration No<br>
                        </label>

                        <div class="col-sm-9">
                            {{ isset($merchant->companyRegNo) ? $merchant->companyRegNo : "N/A"}}
                        </div>
                    </div>






                    <div class="box-header with-border">
                        <h3 class="box-title">Merchant Bank Account Details</h3>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Merchant Scheme</label>

                        <div class="col-sm-9">
                            {{isset($merchant->merchantScheme) && $merchant->merchantScheme!=NULL ? $merchant->merchantScheme->schemename : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Merchant Bank</label>

                        <div class="col-sm-9">
                            {{isset($merchant->merchantBank) && $merchant->merchantBank!=NULL ? $merchant->merchantBank->bankName : "N/A"}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Bank Account No</label>

                        <div class="col-sm-9">
                            {{ isset($merchant->bankAccount) ? $merchant->bankAccount : "N/A"}}
                        </div>
                    </div>

                </div>

                <!-- /.box-body -->
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') Merchant Profile @stop
@section('scripts')

@stop