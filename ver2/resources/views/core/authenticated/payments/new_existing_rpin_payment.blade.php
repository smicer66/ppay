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
            <form class="form-horizontal" autocomplete="off" novalidate action="/bank-teller/vendor-service/existing-rpin" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">RPIN Number:</label>

                        <div class="col-sm-9">
                            <input type="text" placeholder="Provide Valid RPIN" class="form-control" name="rpin" id="rpin" required>
                        </div>
                    </div>


                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Query RPIN</button>
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