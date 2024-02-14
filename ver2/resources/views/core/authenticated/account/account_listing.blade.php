@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Wallet Listing @stop

@section('content')

@include('partials.errors')

<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Wallets
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            {{$title}}
        </h5>
        <div class="form-desc">
            {{$description}}
        </div>
        <div class="table-responsive">
            <table id="allCustomerAccountTable" width="100%" class="table table-striped table-lightfont">
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th>Account Number</th>
                        <th>Account Type</th>
                        <th>Bank Domiciled</th>
                        <th>Currency</th>
                        <th>Account Status</th>
			   <th>Balance</th>
                        <th>&nbsp</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Customer Name</th>
                        <th>Account Number</th>
                        <th>Account Type</th>
                        <th>Bank Domiciled</th>
                        <th>Currency</th>
                        <th>Account Status</th>
			   <th>Balance</th>
                        <th>&nbsp</th>
                    </tr>
                </tfoot>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

@include('core.authenticated.ecards.new_card')
@include('core.authenticated.ecards.account_cards_list')
@include('core.authenticated.account.account_txns_list')
@include('core.authenticated.ecards.fund_account')



@section('extraviews')

    @if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
        <div id="wrapper_1" class="col col-md-6" style="padding-top:30px;display: none; background: rgba(0,0,0,0.55); top: 0%; position: fixed; z-index:10000; height:100%;width:100%">
            <!--<div id="yourdiv" style="display: inline-block;">You text</div>-->

            <div class="modal-content" class="col col-md-6" style="box-shadow: 0 2px 3px rgba(0,0,0,0.125); position:
      absolute; height: 30px; left: 25%;  background-color: transparent; top:20%;opacity: 1 !important;
        filter: alpha(opacity=100); width:50%; display:block;">
                <div class="modal-header" style="background-color: #00a7d0 !important">
                    <button type="button" class="close" onclick="javascript:hidenewcard()" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="modal-title">Add New Debit/Credit Card</h4>
                </div>
                <div class="modal-body" style="background-color: #00c0ef !important;">
                    <!--<form class="form-horizontal" autocomplete="off" action="/bank-teller/customers/new-customer" method="post" enctype="application/x-www-form-urlencoded">-->
                    <input type="hidden" name="account" value="" id="account">
                    <div id="notifymsg" style="padding:3px;"></div>
                    <div class="box-body">
                        <div class="form-group clearfix">
                            <label for="inputEmail3" class="col-sm-3 control-label">Account Name:</label>

                            <div class="col-sm-9">
                                <span id="accountname"></span>
                            </div>
                        </div>
                        <div class="form-group clearfix" id="txnId" style="">
                            <label for="inputEmail3" class="col-sm-3 control-label">Bank Transaction Id:</label>

                            <div class="col-sm-9" style="">
                                <input type="text" class="form-control" id="banktransactionid" placeholder="Transaction Id" required>
                            </div>
                        </div>
                        <div class="form-group clearfix" id="amtPaid" style="">
                            <label for="inputEmail3" class="col-sm-3 control-label">Amount Paid:</label>

                            <div class="col-sm-9" style="">
                                <input type="number" class="form-control" id="amountPaid" placeholder="Amount Paid" required>
                            </div>
                        </div>
                        <div class="form-group clearfix" id="nameoncard">
                            <label for="inputEmail3" class="col-sm-3 control-label">Name On Card:</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nameOnCard" placeholder="Name on Card" required>
                            </div>
                        </div>
                        <div class="form-group clearfix" id="cardtype">
                            <label for="inputEmail3" class="col-sm-3 control-label">Card Type:</label>

                            <div class="col-sm-9">
                                <select class="form-control" required id="cardType">
                                    <option>-Select Card Type-</option>
                                    @foreach(getAllCardType() as $cardType)
                                        <option value="{{$cardType}}">{{$cardType}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix" id="cardscheme">
                            <label for="inputEmail3" class="col-sm-3 control-label">Card Scheme:</label>

                            <div class="col-sm-9">
                                <select class="form-control" required id="cardScheme">
                                    <option>-Select Card Scheme-</option>
                                    @foreach($all_card_schemes as $key => $cardScheme )
                                        <option value="{{$cardScheme->id}}">{{$cardScheme->schemeName}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group clearfix" id="extraoptions">
                            <label for="inputEmail3" class="col-sm-3 control-label">Extra Options:</label>

                            <div class="col-sm-9">
                                <label class="control-sidebar-subheading">
                                    &nbsp;&nbsp;Add Mobile Account to this card
                                    <input type="checkbox" class="pull-left" checked id="addmobilemoney" value="1">
                                </label>
                            </div>
                        </div>
                        <div class="form-group clearfix" id="last5txn">
                            <label for="inputEmail3" class="col-sm-3 control-label">Last 5 Transactions:</label>

                            <div class="col-sm-9">

                                <div id="last5txnlist">

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <!-- /.box-footer -->

                </div>
                <div class="modal-footer" style="background-color: #00a7d0 !important" id="btnview">
                    <div class="pull-left col col-md-3">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    </div>
                    <input type="hidden" name="aid" id="aid" value="">
                    <input type="hidden" name="action" id="action" value="">
                    <div class="pull-right col col-md-4">
                        <a onclick="javascript:handleOverlayAction()" style="cursor:hand" class="btn btn-outline" id="clickActor">Save</a>
                    </div>
                </div>
            </div>

        </div>
    @endif
@stop

@stop
@section('section_title') Customer Accounts List @stop
@section('scripts')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
	<script type="text/javascript" src="/js/action.js"></script>

    <script>
    $(document).ready(function()
	{
        var jwtToken = '{{\Session::get('jwt_token')}}';
		viewCustomerAccounts(jwtToken, 'allCustomerAccountTable');
    });

    function loadAId(x, action)
    {
        $('#aid').val(x);
        $('#action').val(action);
    }


    function shownewcard(fxn, accountname, account, tk) {
        $('#notifymsg').html("");
        $('#clickActor').show();
        $('#txnId').val('');
        $('#amtPaid').val('');
        $('#nameoncard').val('');
        $('#cardtype').value=null;
        $('#cardscheme').value=null;

        if (fxn == 0) {
            $('#clickActor').innerHTM = "Fund Account";
            $('#accountname').html(accountname);
            $('#account').value(account);
            $('#modal-title').html('Fund Account');
            $('#last5txn').hide();
            $('#nameoncard').hide();
            $('#cardtype').hide();
            $('#cardscheme').hide();
            $('#extraoptions').hide();
            $('#txnId').show();
            $('#amtPaid').show();
            $('#btnview').show();
            $("#wrapper_1").fadeIn();
        }
        else if (fxn == 1) {
            $('#clickActor').innerHTM = "Add Card";
            $('#accountname').html(accountname);
            $('#account').value(account);
            $('#modal-title').html('Add Debit/Credit Card');
            $('#nameoncard').show();
            $('#cardtype').show();
            $('#cardscheme').show();
            $('#extraoptions').show();
            $('#btnview').show();
            $('#txnId').hide();
            $('#amtPaid').hide();
            $('#last5txn').hide();
            $("#wrapper_1").fadeIn();
        }
        else if (fxn == 2) {
            //ajax call for pulling last 5 transactions
            var $this = $(this);
            var htmlStr = '';
            $('#last5txnlist').html('loading...');
            $('#accountname').html(accountname);
            $('#account').val(account);
            $('#modal-title').html('Last Five Transactions');
            $('#nameoncard').hide();
            $('#cardtype').hide();
            $('#cardscheme').hide();
            $('#extraoptions').hide();
            $('#txnId').hide();
            $('#amtPaid').hide();
            $('#btnview').hide();
            $('#last5txn').show();
            $("#wrapper_1").fadeIn();
            $.ajax({
                url: '/potzr-staff/customers/last5transactions/' + account,
                dataType: 'json',
                success: function (resp) {
                    if (resp.status === 1) {
                        $.each(resp.data, function (k, v) {
                            htmlStr = htmlStr + '<div>' + k + '</div>';
                        });
                    }
                },
                error: function () {
                    $('#last5txnlist').html('Error encountered pulling last 5 transactions. Please try again');
                },
                complete: function () {
                    $('#clickActor').show();
                }
            });

        }
    }
    </script>
@stop

@section('style')
<style>
    @media (min-width: 992px) {
        .modal-lg, .modal-xl {
            max-width: 90vw !important;
        }
    }
</style>
@stop
