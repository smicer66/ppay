@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Card Scheme Profile @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                @if(isset($cardScheme) && $cardScheme!=NULL)
                    <h3 class="box-title">Update Card Scheme</h3>
                @else
                    <h3 class="box-title">New Card Scheme</h3>
                @endif
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/potzr-staff/ecards/new-scheme" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Scheme Name</label>

                        <div class="col-sm-9">
                            <input type="text" value="{{isset($cardScheme) && $cardScheme!=NULL ? $cardScheme->schemeName : ""}}" class="form-control" name="schemeName" id="inputEmail3" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Fixed Fee</label>

                        <div class="col-sm-9">
                            <small>Charge per transaction)</small><br>
                            <input type="number" value="{{isset($cardScheme) && $cardScheme!=NULL && isset($cardScheme->overrideFixedFee) ? $cardScheme->overrideFixedFee : ""}}" class="form-control" name="fixedFee" id="inputEmail3" step="0.1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Transaction Fee (%)</label>


                        <div class="col-sm-9">
                            <small>(% of each transaction for cards on this scheme)</small><br>
                            <input type="number" class="form-control" value="{{isset($cardScheme) && $cardScheme!=NULL && isset($cardScheme->overrideTransactionFee) ? $cardScheme->overrideTransactionFee : ""}}" name="transactionFee" id="inputEmail3" step="0.1">

                        </div>
                    </div>
                </div>
                @if(isset($cardScheme) && $cardScheme!=NULL)
                <input type="hidden" name="cardScheme" value="{{\Crypt::encrypt($cardScheme)}}">
                @endif
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    @if(isset($cardScheme) && $cardScheme!=NULL)
                        <button type="submit" class="btn btn-sm btn-success pull-right">Save</button>
                    @else
                        <button type="submit" class="btn btn-sm btn-success pull-right">Create</button>
                    @endif
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') {{isset($cardScheme) && $cardScheme!=NULL ? "Update" : "New"}} Card Scheme Profile @stop
@section('scripts')

@stop