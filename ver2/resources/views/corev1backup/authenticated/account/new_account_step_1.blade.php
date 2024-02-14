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
                <h3 class="box-title">Step One - Customer EagleCard Account Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/bank-teller/customers/add-new-account" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Customer Verification Number<br>
                        </label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="verificationNumber" id="inputEmail3" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Account Type</label>

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
                        <label for="inputEmail3" class="col-sm-3 control-label">Account Currency</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="accountCurrency" required>
                                <option>-Select One-</option>
                                @foreach($all_currency as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Opening Balance</label>

                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="openingBalance" id="inputEmail3" required>
                        </div>
                    </div>
					
                </div>
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
@section('section_title') New Customer Account @stop
@section('scripts')

@stop