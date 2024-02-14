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
                <h3 class="box-title"><strong>Step 3/4 - Primary Device Details</strong></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/merchants/new-merchant-step-three" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="panel panel-info">
                        <div class="panel-body" style="background-color: #d9edf7 !important">
                            <small>All items with a red asterisk are required</small>
                        </div>
                    </div>

                    @if($all_device_types->$deviceType=='WEB')
                        <div class="box-header with-border">
                            <h3 class="box-title">Web Payments Device Details</h3>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Domain URL<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="text" value="{{\Input::old('domainURL') ? \Input::old('domainURL') : ''}}" name="domainURL" class="form-control" id="inputEmail3"   required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Forward to URL (Successful Transactions)<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="text" value="{{\Input::old('forwardSuccess') ? \Input::old('forwardSuccess') : ''}}" name="forwardSuccess" class="form-control" id="inputEmail3" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Forward to URL (Failure Transactions)<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="text" value="{{\Input::old('forwardFail') ? \Input::old('forwardFail') : ''}}" name="forwardFail" class="form-control" id="inputEmail3" required>
                            </div>
                        </div>
						
						
						
						
						<div class="box-header with-border">
							<h3 class="box-title">3rd Party Gateway Credentials & Keys</h3>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Cybersource Access Key(Live)</label>

							<div class="col-sm-9">
								<input type="text" value="{{\Input::old('cybersourceLiveAccessKey') ? \Input::old('cybersourceLiveAccessKey') : ''}}" placeholder="Provide a valid Cybersource Live Access key if you have one" name="cybersourceLiveAccessKey" class="form-control" id="cybersourceLiveAccessKey">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Cybersource Profile Id(Live)</label>

							<div class="col-sm-9">
								<input type="text" value="{{\Input::old('cybersourceLiveProfileId') ? \Input::old('cybersourceLiveProfileId') : ''}}" placeholder="Provide a valid Cybersource Live Profile Id if you have one" name="cybersourceLiveProfileId" class="form-control" id="cybersourceLiveProfileId">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Cybersource Secret Key(Live)</label>

							<div class="col-sm-9">
								<input type="text" value="{{\Input::old('cybersourceLiveSecretKey') ? \Input::old('cybersourceLiveSecretKey') : ''}}" placeholder="Provide a valid Cybersource Live Secret key if you have one" name="cybersourceLiveSecretKey" class="form-control" id="cybersourceLiveSecretKey">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Cybersource Access Key(Demo)</label>

							<div class="col-sm-9">
								<input type="text" value="{{\Input::old('cybersourceDemoAccessKey') ? \Input::old('cybersourceDemoAccessKey') : ''}}" placeholder="Provide a valid Cybersource Demo Access key if you have one" name="cybersourceDemoAccessKey" class="form-control" id="cybersourceDemoAccessKey">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Cybersource Profile Id(Demo)</label>

							<div class="col-sm-9">
								<input type="text" value="{{\Input::old('cybersourceDemoProfileId') ? \Input::old('cybersourceDemoProfileId') : ''}}" placeholder="Provide a valid Cybersource Demo Profile Id if you have one" name="cybersourceDemoProfileId" class="form-control" id="cybersourceDemoProfileId">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Cybersource Secret Key(Demo)</label>

							<div class="col-sm-9">
								<input type="text" value="{{\Input::old('cybersourceDemoSecretKey') ? \Input::old('cybersourceDemoSecretKey') : ''}}" placeholder="Provide a valid Cybersource Demo Secret key if you have one" name="cybersourceDemoSecretKey" class="form-control" id="cybersourceDemoSecretKey">
							</div>
						</div>
						
						<hr>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">UBA Service Key</label>

							<div class="col-sm-9">
								<input type="text" value="{{\Input::old('ubaServiceKey') ? \Input::old('ubaServiceKey') : ''}}" placeholder="Provide a valid UBA Service Key if you have one" name="ubaServiceKey" class="form-control" id="ubaServiceKey">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">UBA Merchant Id</label>

							<div class="col-sm-9">
								<input type="text" value="{{\Input::old('ubaMerchantId') ? \Input::old('ubaMerchantId') : ''}}" placeholder="Provide a valid UBA Merchant Id if you have one" name="ubaMerchantId" class="form-control" id="ubaMerchantId">
							</div>
						</div>
						
						<hr>
						<div class="box-header with-border">
							<h3 class="box-title">Bank Credentials & Keys</h3>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">ZICB Auth Key</label>

							<div class="col-sm-9">
								<input type="text" value="{{\Input::old('zicbAuthKey') ? \Input::old('zicbAuthKey') : ''}}" placeholder="Provide a valid ZICB Auth key if you have one" name="zicbAuthKey" class="form-control" id="zicbAuthKey">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">ZICB Service Key</label>

							<div class="col-sm-9">
								<input type="text" value="{{\Input::old('zicbServiceKey') ? \Input::old('zicbServiceKey') : ''}}" placeholder="Provide a valid ZICB Service key if you have one" name="zicbServiceKey" class="form-control" id="zicbServiceKey">
							</div>
						</div>
                    @endif





                    @if($all_device_types->$deviceType=='POS')
                        <div class="box-header with-border">
                            <h3 class="box-title">Point of Sale Device Details</h3>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">POS Device Code<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="text" value="{{\Input::old('posDeviceCode') ? \Input::old('posDeviceCode') : ''}}" name="posDeviceCode" class="form-control" id="inputEmail3" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">POS Device Serial No<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="text" value="{{\Input::old('posDeviceSerialNo') ? \Input::old('posDeviceSerialNo') : ''}}" class="form-control" id="inputEmail3" name="posDeviceSerialNo" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Success Transaction URL<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="text" value="{{\Input::old('posForwardSuccess') ? \Input::old('posForwardSuccess') : ''}}" name="posForwardSuccess" class="form-control" id="inputEmail3" required>
                            </div>
                        </div>
                    @endif




                    @if($all_device_types->$deviceType=='ATM')
                        <div class="box-header with-border">
                            <h3 class="box-title">Automated Teller Machine Device Details</h3>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">ATM Device Code<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="number" value="{{\Input::old('atmDeviceCode') ? \Input::old('atmDeviceCode') : ''}}" name="atmDeviceCode" class="form-control" id="inputEmail3" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">ATM Device Serial No<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="number" value="{{\Input::old('atmDeviceSerialNo') ? \Input::old('atmDeviceSerialNo') : ''}}" name="atmDeviceSerialNo" class="form-control" id="inputEmail3" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Success Transaction URL</label>

                            <div class="col-sm-9">
                                <input type="text" value="{{\Input::old('atmForwardSuccess') ? \Input::old('atmForwardSuccess') : ''}}" name="atmForwardSuccess" class="form-control" id="inputEmail3" required>
                            </div>
                        </div>
                    @endif
					
					
					
					@if($all_device_types->$deviceType=='MPQR')
                        <div class="box-header with-border">
                            <h3 class="box-title">QR Payments</h3>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">MPQR Device Code<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="number" value="{{\Input::old('mpqrDeviceCode') ? \Input::old('mpqrDeviceCode') : ''}}" name="mpqrDeviceCode" class="form-control" id="mpqrDeviceCode" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">MPQR Device Serial No<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="number" value="{{\Input::old('mpqrDeviceSerialNo') ? \Input::old('mpqrDeviceSerialNo') : ''}}" name="mpqrDeviceSerialNo" class="form-control" id="mpqrDeviceSerialNo" required>
                            </div>
                        </div>
                    @endif
                    
                    
                    
                    
                    
                    <div class="box-header with-border">
                        <h3 class="box-title">Notifications On Payments</h3>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Notify Email of Transactions</label>
    
                        <div class="col-sm-9">
                            <input type="email" value="{{\Input::old('notifyEmail') ? \Input::old('notifyEmail') : ''}}" name="notifyEmail" class="form-control" id="inputEmail3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Notify Mobile No of Transactions</label>
    
                        <div class="col-sm-9">
                            <div class="col col-md-3" style="padding-left:0px !important;">
                                <select name="notifycountrycode" class="form-control" required>
                                    <option value>-Country Code-</option>
                                    <!--foreach($countries as $country)-->
                                        <option value="260">+260 Zambia</option>
                                    <!--endforeach-->
                                </select>
                            </div>
                            <div class="col col-md-9" style="padding-left:0px !important; padding-right: 0px !important;">
                                <input type="tel" value="{{\Input::old('notifyMobile') ? \Input::old('notifyMobile') : ''}}" name="notifyMobile" class="form-control" id="inputEmail3">
                            </div>
                        </div>
                    </div>
                </div>




                
                <!-- /.box-body -->
                <div class="box-footer">
                    <a onclick="javascript:history.back(-1)" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Cancel</a>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Next &nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
                </div>
                <!-- /.box-footer -->
                <input type="hidden" name="data" value="{{$data}}">
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