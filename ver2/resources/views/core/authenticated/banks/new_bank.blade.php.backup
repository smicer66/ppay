@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Banks @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">New Bank</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/banks/new-bank" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Bank Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3" required name="bankName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Bank Code</label>

                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="inputEmail3" required name="bankCode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Encryption Code</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3" name="encryptionCode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Online Banking URL</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3" name="onlineBankingURL">
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
@section('section_title') New Customer Account @stop
@section('scripts')

@stop