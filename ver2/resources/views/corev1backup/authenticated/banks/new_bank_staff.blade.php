@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Staff @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">New Bank Staff</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/banks/new-bank-staff" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Bank</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="bank">
                                <option>option 1</option>
                                <option>option 2</option>
                                <option>option 3</option>
                                <option>option 4</option>
                                <option>option 5</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">First Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3" required name="firstName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Last Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3" required  name="lastName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Other Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3"   name="otherName">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Email Address</label>

                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="inputEmail3" required name="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Date of Birth</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3" name="dateOfBirth">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Gender</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="gender">
                                <option>option 1</option>
                                <option>option 1</option>
                                <option>option 2</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Address Line 1</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3" required name="addressLine1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Address Line 2</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3" name="addressLine2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Province & District</label>

                        <div class="col-sm-4">
                            <select class="form-control" name="province" required>
                                <option>option 1</option>
                                <option>option 1</option>
                                <option>option 2</option>
                            </select>
                        </div>
                        <div class="col-sm-4 pull-right">
                            <select class="form-control" name="district" required>
                                <option>option 1</option>
                                <option>option 1</option>
                                <option>option 2</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Create Bank Staff Account</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') New Bank Staff Account @stop
@section('scripts')

@stop