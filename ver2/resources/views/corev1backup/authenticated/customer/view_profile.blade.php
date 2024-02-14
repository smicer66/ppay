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
                <h3 class="box-title">View Customer Profile</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/bank-teller/customers/view-customer" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="box-header with-border">
                        <h3 class="box-title">Customer Bio-Data</h3>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">First Name</label>

                        <div class="col-sm-9">
                            {{$customer->firstName}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Last Name</label>

                        <div class="col-sm-9">
                            {{$customer->lastName}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Other Name</label>

                        <div class="col-sm-9">
                            {{$customer->otherName}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Address Line</label>

                        <div class="col-sm-9">
                            {{$customer->addressLine1}}<br>
                            {{$customer->addressLine2}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Province & District</label>

                        <div class="col-sm-8">

                            {{$customer->locationDistrict->name}}
                            <!--customer->locationDistrict->province->provinceName-->
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Gender</label>

                        <div class="col-sm-9">
                            {{$customer->gender}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Date Of Birth</label>

                        <div class="col-sm-9">
                            {{$customer->dateOfBirth}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Contact Mobile No</label>

                        <div class="col-sm-9">
                            {{$customer->contactMobile}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Alternative Mobile No</label>

                        <div class="col-sm-9">
                            {{isset($customer->altContactMobile) ? $customer->altContactMobile : 'N/A'}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Contact Email Address</label>

                        <div class="col-sm-9">
                            {{$customer->contactEmail}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Alternative Email Address</label>

                        <div class="col-sm-9">
                            {{isset($customer->altContactEmail) ? $customer->altContactEmail : 'N/A'}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Verification Number</label>

                        <div class="col-sm-9">
                            {{$customer->verificationNumber}}
                        </div>
                    </div>
                </div>
                <input type="hidden" value="{{\Crypt::encrypt($customer)}}" name="data">
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-primary pull-right">Update Customer Profile</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') Customer Profile @stop
@section('scripts')

@stop