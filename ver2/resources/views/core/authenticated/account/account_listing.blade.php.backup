@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Teller @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes --><div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Customer Profile</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="box-header">
                        &nbsp;
                    </div>


                    <div class="box-header">
                        <h3 class="box-title">Account Listing</h3>
                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            <table id="allaccounttable" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Customer Name</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Account No</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Account Type</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">Bank</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">EWallet</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Status</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>




@stop
@section('section_title') EagleCard Customer Account List @stop
@section('scripts')
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
	<script type="text/javascript" src="/js/action.js"></script>
    <script>
	
	$(document).ready(function() 
	{
		viewCustomerAccounts();
	});
	
	
	function viewCustomerAccounts() {
		$('#notifymsg').html("");
		$.ajax({
			type: "GET",
			url: "/get-account-list-ajax",
			data: [],
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			success: function (data) {
				console.log(data);
				if(data.status==110)
				{
					$('#allaccounttable').DataTable({
						//"ajax": "/get-customer-list-ajax",
						"data": data.data,
						"columns": [
							{ "data": "customerFullName" },
							{ "data": "accountIdentifier" },
							{ "data": "accountType" },
							{ "data": "bankName" },
							{ "data": "ewalletaccount" },
							{ "data": "status" },
							{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
						]
					});
					
				}
				else
				{
					if(data.status==-1)
					{
						toastr.error(data.message);
						window.location = '/logout';
					}
					toastr.error(data.message);
				}
			},
			error: function (e) {
				toastr.error(data.message);
			}
		});

	}
		
		
    @if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
        function shownewcard(fxn, accountname, account) {
            document.getElementById('notifymsg').innerHTML="";
            document.getElementById('clickActor').style.display="block";
            document.getElementById('txnId').value = '';
            document.getElementById('amtPaid').value = '';
            document.getElementById('nameoncard').value = '';
            document.getElementById('cardtype').value=null;
            document.getElementById('cardscheme').value=null;

            if (fxn == 0) {
                document.getElementById('clickActor').innerHTM = "Fund Account";
                document.getElementById('accountname').innerHTML = accountname;
                document.getElementById('account').value = account;
                document.getElementById('modal-title').innerHTML = 'Fund Account';
                document.getElementById('last5txn').style.display = 'none';
                document.getElementById('nameoncard').style.display = 'none';
                document.getElementById('cardtype').style.display = 'none';
                document.getElementById('cardscheme').style.display = 'none';
                document.getElementById('extraoptions').style.display = 'none';
                document.getElementById('txnId').style.display = 'block';
                document.getElementById('amtPaid').style.display = 'block';
                document.getElementById('btnview').style.display = 'block';
                $("#wrapper_1").fadeIn();
            }
            else if (fxn == 1) {
                document.getElementById('clickActor').innerHTM = "Add Card";
                document.getElementById('accountname').innerHTML = accountname;
                document.getElementById('account').value = account;
                document.getElementById('modal-title').innerHTML = 'Add Debit/Credit Card';
                document.getElementById('nameoncard').style.display = 'block';
                document.getElementById('cardtype').style.display = 'block';
                document.getElementById('cardscheme').style.display = 'block';
                document.getElementById('extraoptions').style.display = 'block';
                document.getElementById('btnview').style.display = 'block';
                document.getElementById('txnId').style.display = 'none';
                document.getElementById('amtPaid').style.display = 'none';
                document.getElementById('last5txn').style.display = 'none';
                $("#wrapper_1").fadeIn();
            }
            else if (fxn == 2) {
                //ajax call for pulling last 5 transactions
                var $this = $(this);
                var htmlStr = '';
                document.getElementById('last5txnlist').innerHTML = 'loading...';
                document.getElementById('accountname').innerHTML = accountname;
                document.getElementById('account').value = account;
                document.getElementById('modal-title').innerHTML = 'Last Five Transactions';
                document.getElementById('nameoncard').style.display = 'none';
                document.getElementById('cardtype').style.display = 'none';
                document.getElementById('cardscheme').style.display = 'none';
                document.getElementById('extraoptions').style.display = 'none';
                document.getElementById('txnId').style.display = 'none';
                document.getElementById('amtPaid').style.display = 'none';
                document.getElementById('btnview').style.display = 'none';
                document.getElementById('last5txn').style.display = 'block';
                $("#wrapper_1").fadeIn();
                $.ajax({
                    url: '/bank-teller/customers/last5transactions/' + account,
                    dataType: 'json',
                    success: function (resp) {
                        if (resp.status === 1) {
                            $.each(resp.data, function (k, v) {
                                htmlStr = htmlStr + '<div>' + k + '</div>';
                            });
                        }
                    },
                    error: function () {
                        document.getElementById('last5txnlist').innerHTML = 'Error encountered pulling last 5 transactions. Please try again';
                    },
                    complete: function () {
                        document.getElementById('clickActor').style.display="block";
                    }
                });

            }
        }
        function hidenewcard(){$("#wrapper_1").fadeOut();document.getElementById('notifymsg').innerHTML=""}

        function loadAId(x, action)
        {
            document.getElementById('aid').value = x;
            document.getElementById('action').value = action;
        }

        function handleOverlayAction()
        {
            document.getElementById('clickActor').style.display="none";
            document.getElementById('notifymsg').innerHTML = "<div style='background-color:orange; color:#fff; padding:3px'>Loading...</div>";
            var banktransactionid = document.getElementById('banktransactionid').value;
            var amountPaid = document.getElementById('amountPaid').value;
            var aid = document.getElementById('aid').value;
            var action = document.getElementById('action').value;
            var nameOnCard = encodeURI(document.getElementById('nameOnCard').value);
            var cardType = encodeURI(document.getElementById('cardType').value);
            var cardScheme = encodeURI(document.getElementById('cardScheme').value);
            var addmobilemoney = encodeURI(document.getElementById('addmobilemoney').value);
            var url = '';
            if(action =='fundAccount')
                url_ = '/bank-teller/accounts/fund-account/' + aid + '/' + banktransactionid + '/' + amountPaid;
            if(action =='addCreditCard')
                url_ = '/bank-teller/accounts/add-card/' + nameOnCard + '/' + cardType + '/' + cardScheme + '/' + addmobilemoney + '/' + aid;

            console.log("url_ = " + url_);

            $.ajax({
                url: url_,
                dataType: 'json',
                async: false,
                success: function (resp) {
                    console.log("resp"  + resp.msg);
                    if (resp.status === 1) {
                        document.getElementById('notifymsg').innerHTML = "<div style='background-color:green; color:#fff; padding:3px'>" + resp.msg + "</div>";
                    }else
                    {
                        document.getElementById('notifymsg').innerHTML = "<div style='background-color:red; color:#fff; padding:3px'>" + resp.msg + "</div>";
                    }
                },
                error: function (resp) {
                    console.log("resp"  + resp);
                    if(action =='fundAccount')
                        document.getElementById('notifymsg').innerHTML = "<div style='background-color:red; color:#fff; padding:3px'>Error experienced funding account</div>";
                    if(action =='addCreditCard')
                        document.getElementById('notifymsg').innerHTML = "<div style='background-color:red; color:#fff; padding:3px'>Error experienced adding a new credit/debit card</div>";
                },
                complete: function () {
                }
            });
        }
    @endif
    </script>
@stop

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