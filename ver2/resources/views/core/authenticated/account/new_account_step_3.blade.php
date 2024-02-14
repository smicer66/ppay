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
                <h3 class="box-title">Confirm Customer Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" action="/bank-teller/customers/add-new-account-step-three" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">










                    <div class="box-header with-border">
                        <h3 class="box-title">EagleCard Account Details</h3>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Customer Verification Number</label>

                        <div class="col-sm-9">
                            {{$data1['verificationNumber']}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Account Type</label>

                        <div class="col-sm-9">
                            {{$all_account_type[$data1['accountType']]}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Account Currency</label>

                        <div class="col-sm-9">
                            {{$all_currency[$data1['accountCurrency']]}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Opening Balance</label>

                        <div class="col-sm-9">
                            {{$data1['openingBalance']}}
                        </div>
                    </div>






                    <div class="box-header with-border">
                        <h3 class="box-title">Credit/Debit Card Details</h3>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Name On Card</label>

                        <div class="col-sm-9">
                            {{$data1['nameOnCard']}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Card Type</label>

                        <div class="col-sm-9">
                            {{$data1['cardType']}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Card Scheme</label>

                        <div class="col-sm-9">
                            <?php
                            $exp = explode('_', $data1['cardScheme']);
                            ?>
                            {{$all_card_schemes[$exp[0]]->schemeName}}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Extra Options</label>

                        <div class="col-sm-9">
                            <label class="control-sidebar-subheading">
                                &nbsp;&nbsp;Add Mobile Money to this card?
                                @if($data1['addMobileMoney']=='on')
                                    Yes
                                @endif
                            </label>
                            <label class="control-sidebar-subheading">
                                &nbsp;&nbsp;Add eWallet to this card
                                @if($data1['addEWallet']=='on')
                                    Yes
                                @endif
                            </label>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="data" value="{{$data}}">
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Add New Account</button>
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