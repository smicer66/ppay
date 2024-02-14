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
                <h3 class="box-title"><strong>Step 2/4 - Merchant Account Details</strong></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/merchants/new-merchant-step-two" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="panel panel-info">
                        <div class="panel-body" style="background-color: #d9edf7 !important">
                            <small>All items with a red asterisk are required</small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Merchant Scheme<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <select class="form-control" name="merchantScheme" required>
                                <option>-Select A Scheme-</option>
                                <?php
                                $i = 0;
                                ?>
                                @foreach($all_merchant_schemes as $merchantScheme)
                                <option value="{{$i."_".$merchantScheme->id}}" {{\Input::old('merchantScheme') && \Input::old('merchantScheme')==($i++."_".$merchantScheme->id) ? 'selected' : ''}}>{{$merchantScheme->schemename}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Merchant Bank<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <select class="form-control" name="merchantBank" required>
                                <option>-Select A Bank-</option>
                                <?php
                                $i = 0;
                                ?>
                                @foreach($all_banks as $bank)
                                    <option value="{{$i."_".$bank->id}}" {{\Input::old('merchantBank') && \Input::old('merchantBank')==($i++."_".$bank->id) ? 'selected' : ''}}>{{$bank->bankName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Bank Account Name<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <input type="text" value="{{\Input::old('bankAccountName') ? \Input::old('bankAccountName') : ''}}" placeholder="Merchants' Bank Account Name for Receiving Funds" name="bankAccountName" class="form-control" id="bankAccountName" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Bank Account No</label>

                        <div class="col-sm-9">
                            <input type="tel" value="{{\Input::old('bankAccountNo') ? \Input::old('bankAccountNo') : ''}}" placeholder="Merchants' Bank Account for Receiving Funds" name="bankAccountNo" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Branch Code<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <input type="tel" value="{{\Input::old('bankBranchCode') ? \Input::old('bankBranchCode') : ''}}" placeholder="Merchants' Bank Branch Code" name="bankBranchCode" class="form-control" id="bankBranchCode" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Primary Device Type<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <select class="form-control" name="deviceType" required>
                                <option>-Select A Device Type-</option>
                                @foreach($all_device_types as $key => $value)
                                    <option value="{{$key}}" {{\Input::old('deviceType') && \Input::old('deviceType')==$key ? 'selected' : ''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    
                    
                    
                    
                </div>

                <input type="hidden" name="data" value="{{$data}}">
                <!-- /.box-body -->
                <div class="box-footer">
                    <a onclick="javascript:history.back(-1)" class="btn btn-sm btn-danger"><i class="fa fa-arrow-left"></i> Go Back</a>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Next <i class="fa fa-arrow-right"></i></button>
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