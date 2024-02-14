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
                <h3 class="box-title">New Merchant Account Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/merchants/new-merchant-account" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Merchant</label>

                        <div class="col-sm-9">
                            {{$merchant->merchantName}}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Merchant Bank</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="merchantBank" required>
                                <option value="">-Select A Bank-</option>
                                <?php
                                $i = 0;
                                ?>
                                @foreach($all_banks as $bank)
                                    <option value="{{$bank->id}}">{{$bank->bankName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Bank Account Name</label>

                        <div class="col-sm-9">
                            <input type="text" placeholder="Merchants' Bank Account Name for Receiving Funds" name="bankAccountName" class="form-control" id="bankAccountName" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Bank Account No</label>

                        <div class="col-sm-9">
                            <input type="number" placeholder="Merchants' Bank Account for Receiving Funds" name="bankAccountNo" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Branch Code</label>

                        <div class="col-sm-9">
                            <input type="text" placeholder="Merchants' Bank Branch Code" name="bankBranchCode" class="form-control" id="bankBranchCode" required>
                        </div>
                    </div>
                    
                </div>

                <input type="hidden" name="data" value="{{$merchantId}}">
                <!-- /.box-body -->
                <div class="box-footer">
                    <a onclick="javascript:history.back(-1)" class="btn btn-sm btn-danger">Go Back</a>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Add</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') New Merchant Account @stop
@section('scripts')

@stop