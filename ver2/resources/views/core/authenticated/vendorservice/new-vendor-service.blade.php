@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant Service @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">New Vendor Service</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/vendor-service/new-vendor-service" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Merchant</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="merchant">
                                <option>-Select A Merchant-</option>
                                @foreach($merchantList as $merchant)
                                    <option value="{{$merchant->id}}">{{$merchant->merchantName}} - {{$merchant->merchantCode}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Service Name</label>

                        <div class="col-sm-9">
                            <input type="text" name="serviceName" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Amount Payable</label>

                        <div class="col-sm-9">
                            <input type="number" name="amountPayable" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Service Description</label>

                        <div class="col-sm-9">
                            <textarea class="form-control" name="serviceDescription" id="inputEmail3"></textarea>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Create New Service</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') New Vendor Service @stop
@section('scripts')

@stop