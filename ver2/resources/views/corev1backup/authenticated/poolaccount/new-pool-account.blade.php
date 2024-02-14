@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Pool Account @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">New Pool Account</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/pool-accounts/new-pool-account" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Bank</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="bank" required>
                                <option>-Select A Bank-</option>
                                @foreach($all_banks as $bank)
                                <option value="{{$bank->id}}">{{$bank->bankName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Bank Account No</label>

                        <div class="col-sm-9">
                            <input type="text" name="accountNo" class="form-control" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Threshold Level</label>

                        <div class="col-sm-9">
                            <input type="number" name="thresholdLevel" class="form-control" id="inputEmail3" required>
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
@section('section_title') New Pool Account @stop
@section('scripts')

@stop