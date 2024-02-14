@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Teller @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes --><div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Mobile Accounts</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                    <div class="box-header">
                        <h3 class="box-title">Mobile Account Listing</h3>
                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            <table id="allMobileMoneyAccountsTable" class="display" style="width:100%">
                                <thead>

                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Mobile No</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Account No</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Account Holder</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">Card No</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">Status</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $x=1;
                                ?>
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
@section('section_title') Mobile Account List @stop
@section('scripts')
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
	<script type="text/javascript" src="/js/action.js"></script>
    <script>
	
	$(document).ready(function() 
	{
		viewMobileMoneyAccountList();
	});
	</script>
	
    <script>
    @if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
        function shownewcard(fxn, accountname, account) {
            if (fxn == 0) {
                document.getElementById('accountname').innerHTML = accountname;
                document.getElementById('account').value = account;
                document.getElementById('last5txn').style.display = 'none';
                document.getElementById('nameoncard').style.display = 'none';
                document.getElementById('cardtype').style.display = 'none';
                document.getElementById('cardscheme').style.display = 'none';
                document.getElementById('extraoptions').style.display = 'none';
                document.getElementById('txnId').style.display = 'block';
                document.getElementById('amtPaid').style.display = 'block';
                $("#wrapper_1").fadeIn();
            }
            else if (fxn == 1) {
                document.getElementById('accountname').innerHTML = accountname;
                document.getElementById('account').value = account;
                document.getElementById('nameoncard').style.display = 'block';
                document.getElementById('cardtype').style.display = 'block';
                document.getElementById('cardscheme').style.display = 'block';
                document.getElementById('extraoptions').style.display = 'block';
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
                document.getElementById('nameoncard').style.display = 'none';
                document.getElementById('cardtype').style.display = 'none';
                document.getElementById('cardscheme').style.display = 'none';
                document.getElementById('extraoptions').style.display = 'none';
                document.getElementById('txnId').style.display = 'none';
                document.getElementById('amtPaid').style.display = 'none';
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

                    }
                });

            }
        }
        function hidenewcard(){$("#wrapper_1").fadeOut();}
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
                    <h4 class="modal-title">Fund Mobile Money Account</h4>
                </div>
                <div class="modal-body" style="background-color: #00c0ef !important;">
                    <form class="form-horizontal" autocomplete="off" action="/potzr-staff/mobile-money/fund-account" method="post" enctype="application/x-www-form-urlencoded">
                        <input type="hidden" name="account" value="" id="account">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Mobile Number</label>

                                <div class="col-sm-9">
                                    <span id="accountname"></span>
                                </div>
                            </div>
                            <div class="form-group" id="txnId">
                                <label for="inputEmail3" class="col-sm-3 control-label">Bank Transaction Id</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Name on Card" required>
                                </div>
                            </div>
                            <div class="form-group" id="amtPaid">
                                <label for="inputEmail3" class="col-sm-3 control-label">Amount Paid:</label>

                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="inputEmail3" placeholder="Name on Card" required>
                                </div>
                            </div>
                            <div class="form-group" id="last5txn">
                                <label for="inputEmail3" class="col-sm-3 control-label">Last 5 Transactions</label>

                                <div class="col-sm-9">

                                    <div id="last5txnlist">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <!-- /.box-footer -->
                    </form>
                </div>
                <div class="modal-footer" style="background-color: #00a7d0 !important">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-outline">Add Card</button>
                </div>
            </div>

        </div>
    @endif
@stop