@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Update Application Settings @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Update Application Settings</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/update-settings" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Minimum Balance Acceptable on ProbasePay</label>

                        <div class="col-sm-8">
                            <input value="{{isset($result->minimumBalance) ? $result->minimumBalance : ''}}" type="number" name="minimumBalance" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Min. Transaction Allowed On Web</label>

                        <div class="col-sm-8">
                            <input value="{{isset($result->minimumTransactionAmountWeb) ? $result->minimumTransactionAmountWeb : ''}}" type="number" name="minimumTransactionAmountWeb" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Max. Transaction Allowed On Web</label>

                        <div class="col-sm-8">
                            <input value="{{isset($result->maximumTransactionAmountWeb) ? $result->maximumTransactionAmountWeb : ''}}" type="number" name="maximumTransactionAmountWeb" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
					
					
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Cybersource Access Key</label>

                        <div class="col-sm-8">
                            <input value="{{isset($result->cyberSourceAccessKey) ? $result->cyberSourceAccessKey : ''}}" type="text" name="cyberSourceAccessKey" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Cybersource Profile Id</label>

                        <div class="col-sm-8">
                            <input value="{{isset($result->cyberSourceProfileId) ? $result->cyberSourceProfileId : ''}}" type="text" name="cyberSourceProfileId" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
					
					
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Cybersource Secret Key</label>

                        <div class="col-sm-8">
                            <input value="{{isset($result->cyberSourceSecretKey) ? $result->cyberSourceSecretKey : ''}}" type="text" name="cyberSourceSecretKey" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Cybersource Locale</label>

                        <div class="col-sm-8">
                            <input value="{{isset($result->cyberSourceLocale) ? $result->cyberSourceLocale : ''}}" type="text" name="cyberSourceLocale" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
					
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">DSTV Payment Vendor Code</label>

                        <div class="col-sm-8">
                            <input value="{{isset($result->paymentVendorCode) ? $result->paymentVendorCode : ''}}" type="text" name="paymentVendorCode" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">DSTV Method of Payment</label>

                        <div class="col-sm-8">
                            <input value="{{isset($result->methodOfPayment) ? $result->methodOfPayment : ''}}" type="text" name="methodOfPayment" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">DSTV Currency Code</label>

                        <div class="col-sm-8">
                            <input value="{{isset($result->currencyCode) ? $result->currencyCode : ''}}" type="text" name="currencyCode" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">DSTV Vendor Code</label>

                        <div class="col-sm-8">
                            <input value="{{isset($result->vendorCode) ? $result->vendorCode : ''}}" type="text" name="vendorCode" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">DSTV Language</label>

                        <div class="col-sm-8">
                            <input value="{{isset($result->language) ? $result->language : ''}}" type="text" name="language" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">DSTV Data Source</label>

                        <div class="col-sm-8">
                            <input value="{{isset($result->dataSource) ? $result->dataSource : ''}}" type="text" name="dataSource" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">DSTV Interface Type</label>

                        <div class="col-sm-8">
                            <input value="{{isset($result->interfaceType) ? $result->interfaceType : ''}}" type="text" name="interfaceType" class="form-control" id="inputEmail3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">DSTV Business Unit</label>

                        <div class="col-sm-8">
                            <input value="{{isset($result->businessUnit) ? $result->businessUnit : ''}}" type="text" name="businessUnit" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success pull-right">save</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') Update Application Settings @stop
@section('scripts')

@stop