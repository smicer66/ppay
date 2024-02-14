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
                <h3 class="box-title">Confirm New Vendor Service Payment</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" novalidate action="/bank-teller/vendor-service/confirm-payment" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Vendor Service</label>

                        <div class="col-sm-9">
                            {{explode('|||', $data1['vendorService'])[1]}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Amount Customer Is Paying</label>

                        <div class="col-sm-9">
                            {{$data1['amount']}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Customers Full Name/Identitification Id</label>

                        <div class="col-sm-9">
                            {{$data1['payeeFullName']}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Customers Mobile Number</label>

                        <div class="col-sm-9">
                            {{$data1['payeeMobile']}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Customers Email Address</label>

                        <div class="col-sm-9">
                            {{$data1['payeeEmail']}}
                        </div>
                    </div>

                </div>

                <input type="hidden" name="data" value="{{($data)}}">

                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Confirm Payment</button>
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
<script>

    function handleDeviceTypes()
    {
        deviceType = document.getElementById('deviceType').value;
        console.log("Devicetype = " + deviceType);
        if(deviceType=="WEB")
        {
            document.getElementById('atmdevicedetails').style.display='none';document.getElementById('posdevicedetails').style.display='none';document.getElementById('webpaymentsdevices').style.display='block';}
        if(deviceType=="POS"){
            document.getElementById('atmdevicedetails').style.display='none';document.getElementById('webpaymentsdevices').style.display='none';document.getElementById('posdevicedetails').style.display='block';}
        if(deviceType=="ATM"){
            document.getElementById('posdevicedetails').style.display='none';document.getElementById('webpaymentsdevices').style.display='none';document.getElementById('atmdevicedetails').style.display='block';}

    }
</script>
@stop