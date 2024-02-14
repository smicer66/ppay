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
                <h3 class="box-title">Step Two - EagleCard Debit/Credit Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/bank-teller/customers/add-new-account-step-two" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Name On Card</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nameOnCard" id="inputEmail3" placeholder="Name on Card" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Card Type</label>

                        <div class="col-sm-9">
                            <select class="form-control" required name="cardType">
                                <option>-Select One-</option>
                                @foreach($all_card_type as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Card Scheme</label>

                        <div class="col-sm-9">
                            <select class="form-control" required name="cardScheme">
                                <option>-Select One-</option>
                                @foreach($all_card_schemes as $key => $value)
                                    <option value="{{$key."_".$value->id}}">{{$value->schemeName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Extra Options</label>

                        <div class="col-sm-9">
                            <label class="control-sidebar-subheading">
                                &nbsp;&nbsp;Add Mobile Money to this card
                                <input type="checkbox" class="pull-left" checked name="addMobileMoney">
                            </label>
                            <label class="control-sidebar-subheading">
                                &nbsp;&nbsp;Add eWallet to this card
                                <input type="checkbox" class="pull-left" checked name="addEWallet">
                            </label>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="data" value="{{$data}}">
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