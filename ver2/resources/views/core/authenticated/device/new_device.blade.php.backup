@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Devices @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{isset($device) ? "Update" : "New"}} Device Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" novalidate action="/potzr-staff/devices/new-device" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="panel panel-info">
                        <div class="panel-body" style="background-color: #d9edf7 !important">
                            <small>All items with a red asterisk are required</small>
                        </div>
                    </div>
                    <div id="merchantdetails" style="">
						<div class="form-group">
							<div class="box-header with-border">
								<h3 class="box-title">Merchant Details</h3>
							</div>
							<label for="inputEmail3" class="col-sm-3 control-label">Merchant<span style="color:red !important">*</span></label>

							<div class="col-sm-9">
								<select class="form-control" name="merchant" required>
									<option value="">-Select A Merchant-</option>
									@if(isset($merchantId) && $merchantId!=NULL)
										@foreach($merchantList as $merchant)
											@if($merchantId==$merchant->id)
											<option selected value="{{$merchantId}}">{{$merchant->merchantCode}} - {{$merchant->merchantName}}</option>
											@endif
										@endforeach
									@else
										@foreach($merchantList as $merchant)
											<option {{$merchant->id==$merchantId ? 'selected': ''}} value="{{$merchant->id}}">{{$merchant->merchantCode}} - {{$merchant->merchantName}}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
                    </div>


                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Device Type<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <select class="form-control" id="deviceType" name="deviceType" required onchange="javasript:handleDeviceTypes()">
                                <option value="">-Select A Device Type-</option>
                                <option value="WEB" {{isset($device) && $device->deviceType=="WEB" ? 'selected' : ''}}>Payments On the Web</option>
                                <option value="POS" {{isset($device) && $device->deviceType=="POS" ? 'selected' : ''}}>Point of Sale Devices</option>
                                <option value="ATM" {{isset($device) && $device->deviceType=="ATM" ? 'selected' : ''}}>Automated Teller Machines</option>
                                <option value="MPQR" {{isset($device) && $device->deviceType=="MPQR" ? 'selected' : ''}}>MPQR Devices</option>
                            </select>
                        </div>
                    </div>

					
					


                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Notify Email of Transactions</label>

                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="emailNotify" id="inputEmail3" value="{{isset($device) && isset($device->emailNotify) ? $device->emailNotify : ''}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Notify Mobile No of Transactions</label>

                        <div class="col-sm-9">
                            <div class="col col-md-3" style="padding-left:0px !important;">
                                <select name="notifycountrycode" class="form-control">
                                    <option value>-Country Code-</option>
                                    <!--foreach($countries as $country)-->
                                        <option value="260">+260 Zambia</option>
                                    <!--endforeach-->
                                </select>
                            </div>
                            <div class="col col-md-9" style="padding-left:0px !important; padding-right: 0px !important;">
								<input type="text" class="form-control" name="mobileNotify" id="inputEmail3" value="{{isset($device) && isset($device->mobileNotify) ? $device->mobileNotify : ''}}">
							</div>
                        </div>
                    </div>

                    <div id="webpaymentsdevices" style="display: {{isset($device) && $device->deviceType=="WEB" ? 'block' : 'none'}}">
                        <div class="box-header with-border">
                            <h3 class="box-title">Web Payments Device Details</h3>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Domain URL<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="domainURL" id="domainURL" required value="{{isset($device) && isset($device->domainUrl) ? $device->domainUrl : ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Forward to URL (Successful Transactions)<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="forwardSuccess" id="forwardSuccess" required value="{{isset($device) && isset($device->successUrl) ? $device->successUrl : ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Forward to URL (Failure Transactions)<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="forwardFail" id="forwardFail" required value="{{isset($device) && isset($device->failureUrl) ? $device->failureUrl : ''}}">
                            </div>
                        </div>
						
						<hr>
						
						<div class="box-header with-border">
							<h3 class="box-title">3rd Party Gateway Credentials & Keys</h3>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Cybersource Access Key(Live)</label>

							<div class="col-sm-9">
								<input type="text" value="{{isset($device) && isset($device->cybersourceLiveAccessKey) ? $device->cybersourceLiveAccessKey : ''}}" placeholder="Provide a valid Cybersource Live Access key if you have one" name="cybersourceLiveAccessKey" class="form-control" id="cybersourceLiveAccessKey">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Cybersource Profile Id(Live)</label>

							<div class="col-sm-9">
								<input type="text" value="{{isset($device) && isset($device->cybersourceLiveProfileId) ? $device->cybersourceLiveProfileId : ''}}" placeholder="Provide a valid Cybersource Live Profile Id if you have one" name="cybersourceLiveProfileId" class="form-control" id="cybersourceLiveProfileId">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Cybersource Secret Key(Live)</label>

							<div class="col-sm-9">
								<input type="text" value="{{isset($device) && isset($device->cybersourceLiveSecretKey) ? $device->cybersourceLiveSecretKey : ''}}" placeholder="Provide a valid Cybersource Live Secret key if you have one" name="cybersourceLiveSecretKey" class="form-control" id="cybersourceLiveSecretKey">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Cybersource Access Key(Demo)</label>

							<div class="col-sm-9">
								<input type="text" value="{{isset($device) && isset($device->cybersourceDemoAccessKey) ? $device->cybersourceDemoAccessKey : ''}}" placeholder="Provide a valid Cybersource Demo Access key if you have one" name="cybersourceDemoAccessKey" class="form-control" id="cybersourceDemoAccessKey">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Cybersource Profile Id(Demo)</label>

							<div class="col-sm-9">
								<input type="text" value="{{isset($device) && isset($device->cybersourceDemoProfileId) ? $device->cybersourceDemoProfileId : ''}}" placeholder="Provide a valid Cybersource Demo Profile Id if you have one" name="cybersourceDemoProfileId" class="form-control" id="cybersourceDemoProfileId">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Cybersource Secret Key(Demo)</label>

							<div class="col-sm-9">
								<input type="text" value="{{isset($device) && isset($device->cybersourceDemoSecretKey) ? $device->cybersourceDemoSecretKey : ''}}" placeholder="Provide a valid Cybersource Demo Secret key if you have one" name="cybersourceDemoSecretKey" class="form-control" id="cybersourceDemoSecretKey">
							</div>
						</div>
						
						<hr>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">UBA Service Key</label>

							<div class="col-sm-9">
								<input type="text" value="{{isset($device) && isset($device->ubaServiceKey) ? $device->ubaServiceKey : ''}}" placeholder="Provide a valid UBA Service Key if you have one" name="ubaServiceKey" class="form-control" id="ubaServiceKey">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">UBA Merchant Id</label>

							<div class="col-sm-9">
								<input type="text" value="{{isset($device) && isset($device->ubaMerchantId) ? $device->ubaMerchantId : ''}}" placeholder="Provide a valid UBA Merchant Id if you have one" name="ubaMerchantId" class="form-control" id="ubaMerchantId">
							</div>
						</div>
                    </div>




                    <div id="posdevicedetails" style="display: {{isset($device) && $device->deviceType=="POS" ? 'block' : 'none'}}">
                        <div class="box-header with-border">
                            <h3 class="box-title">Point of Sale Device Details</h3>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">POS Device Code<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="posDeviceCode" id="posDeviceCode" required value="{{isset($device) && isset($device->deviceCode) ? $device->deviceCode : ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">POS Device Serial No<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="posDeviceSerialNo" id="posDeviceSerialNo" required value="{{isset($device) && isset($device->deviceSerialNo) ? $device->deviceSerialNo : ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Success Transaction URL</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="posForwardSuccess" id="posForwardSuccess" required value="{{isset($device) && isset($device->successUrl) ? $device->successUrl : ''}}">
                            </div>
                        </div>
                    </div>






                    <div id="atmdevicedetails" style="display: {{isset($device) && $device->deviceType=="ATM" ? 'block' : 'none'}}">
                        <div class="box-header with-border">
                            <h3 class="box-title">Automated Teller Machine Device Details</h3>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">ATM Device Code<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="atmDeviceCode" id="atmDeviceCode" required value="{{isset($device) && isset($device->deviceCode) ? $device->deviceCode : ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">ATM Device Serial No<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="atmDeviceSerial" id="atmDeviceSerial" required value="{{isset($device) && isset($device->deviceSerialNo) ? $device->deviceSerialNo : ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Success Transaction URL<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="atmForwardSuccess" id="atmForwardSuccess" required value="{{isset($device) && isset($device->successUrl) ? $device->successUrl : ''}}">
                            </div>
                        </div>
                    </div>




                    <div id="mpqrdevicedetails" style="display: {{isset($device) && $device->deviceType=="MPQR" ? 'block' : 'none'}}">
                        <div class="box-header with-border">
                            <h3 class="box-title">MPQR Device Details</h3>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">MPQR Device Code<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="mpqrDeviceCode" id="mpqrDeviceCode" required value="{{isset($device) && isset($device->mpqrDeviceCode) ? $device->mpqrDeviceCode : ''}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">MPQR Device Serial No<span style="color:red !important">*</span></label>

                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="mpqrDeviceSerialNo" id="mpqrDeviceSerialNo" required value="{{isset($device) && isset($device->mpqrDeviceSerialNo) ? $device->mpqrDeviceSerialNo : ''}}">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                @if(isset($deviceId) && $deviceId!=NULL)
                    <input type="hidden" name="deviceId" value="{{$deviceId}}">
                @endif
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    @if(isset($device))
                        <button type="submit" class="btn btn-sm btn-success pull-right">Add New Merchant Device</button>
                    @else
                        <button type="submit" class="btn btn-sm btn-success pull-right">Save Merchant Device</button>
                    @endif
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') {{isset($device) ? "Update" : "New"}} Device Details @stop
@section('scripts')
<style>
    .control-label{
        font-weight: 100 !important;
        text-align: left !important;
        padding-left: 30px !important;
    }
</style>
<script>
	
    function handleDeviceTypes()
    {
        deviceType = document.getElementById('deviceType').value;
        console.log("Devicetype = " + deviceType);
        if(deviceType=="WEB"){
            document.getElementById('mpqrdevicedetails').style.display='none';document.getElementById('atmdevicedetails').style.display='none';document.getElementById('posdevicedetails').style.display='none';document.getElementById('webpaymentsdevices').style.display='block';}
        if(deviceType=="POS"){
            document.getElementById('mpqrdevicedetails').style.display='none';document.getElementById('atmdevicedetails').style.display='none';document.getElementById('webpaymentsdevices').style.display='none';document.getElementById('posdevicedetails').style.display='block';}
        if(deviceType=="ATM"){
            document.getElementById('mpqrdevicedetails').style.display='none';document.getElementById('posdevicedetails').style.display='none';document.getElementById('webpaymentsdevices').style.display='none';document.getElementById('atmdevicedetails').style.display='block';}
		if(deviceType=="MPQR"){
            document.getElementById('mpqrdevicedetails').style.display='block';document.getElementById('posdevicedetails').style.display='none';document.getElementById('webpaymentsdevices').style.display='none';document.getElementById('atmdevicedetails').style.display='none';}

    }
</script>
@stop