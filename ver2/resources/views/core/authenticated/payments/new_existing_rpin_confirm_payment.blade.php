@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Devices @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Confirm Existing RPIN Payment</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" novalidate action="/bank-teller/vendor-service/confirm-existing-rpin" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Amount Customer Is To Pay</label>

                        <div class="col-sm-9">
                            ZMW{{number_format($data1->amount, 2, '.', ',')}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Customers Full Name/Identitification Id</label>

                        <div class="col-sm-9">
                            {{$data1->customerName}}
                        </div>
                    </div>



                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Amount Paid</label>

                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="amount" id="amount" required>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="data" value="{{($data)}}">

                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Confirm Payment</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') Confirm Existing RPIN Payment @stop
@section('scripts')
<script>

</script>
@stop