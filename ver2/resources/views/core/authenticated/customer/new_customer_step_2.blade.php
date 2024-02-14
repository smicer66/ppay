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
                <h3 class="box-title">Step Two - Customer EagleCard Account Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/bank-teller/customers/new-customer-step-two" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="panel panel-info">
                        <div class="panel-body" style="background-color: #d9edf7 !important">
                            <small>All items with a red asterisk are required</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Account Type<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <select class="form-control" name="accountType" required>
                                <option>-Select One-</option>
                                @foreach($all_account_type as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Account Currency<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <select class="form-control" name="accountCurrency" required>
                                <option>-Select One-</option>
                                @foreach($all_currency as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!--<div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Opening Balance<span style="color:red !important">*</span></label>

                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="openingBalance" id="inputEmail3" required value="0.00">
                        </div>
                    </div>-->
                </div>
                <input type="hidden" value="{{$data}}" name="data">
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Next</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') New Customer Profile @stop
@section('scripts')

@stop