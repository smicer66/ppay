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
                <h3 class="box-title">Step Two - Update Merchant Account Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/merchants/update-merchant-account/step-two" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Merchant Scheme</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="merchantScheme" required>
                                <option>-Select A Scheme-</option>
                                <?php
                                $i = 0;
                                ?>
                                @foreach($all_merchant_schemes as $merchantScheme)
                                    <option value="{{$i++."_".$merchantScheme->id}}" {{$merchant->merchantScheme->id==$merchantScheme->id ? "selected" : ""}}>{{$merchantScheme->schemename}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Merchant Bank</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="merchantBank" required>
                                <option>-Select A Bank-</option>
                                <?php
                                $i = 0;
                                ?>
                                @foreach($all_banks as $bank)
                                    <option value="{{$i++."_".$bank->id}}" {{$merchant->merchantBank->id==$bank->id ? "selected" : ""}}>{{$bank->bankName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Bank Account No</label>

                        <div class="col-sm-9">
                            <input type="number" value="{{$merchant->bankAccount}}" name="bankAccountNo" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="merchantId" value="{{$merchant->id}}">
                <input type="hidden" name="data" value="{{$data}}">
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
@section('section_title') Update Merchant Profile @stop
@section('scripts')

@stop