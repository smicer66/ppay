@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Teller @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes --><div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Pool Accounts</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">


                    <div class="box-header">
                        <h3 class="box-title">Pool Account Listing</h3>
                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">&nbsp;</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Account No</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Bank</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">Threshold Level</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Status</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $x=1;
                                ?>
                                <tbody>
                                    @foreach($poolaccountlist as $poolaccount)
                                    <?php
                                      $id = \Crypt::encrypt($poolaccount->id);
                                    ?>
                                    <tr role="row" class="odd">
                                        <td class="sorting_1"><input type="checkbox" name="accounts[]"></td>
                                        <td class="sorting_1">{{$poolaccount->accountNumber}}</td>
                                        <td>{{$poolaccount->bank->bankName}}</td>
                                        <td>{{$poolaccount->thresholdLevel}}</td>
                                        <td>{{$poolaccount->status}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-primary" type="button">Action</button>
                                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul role="menu" class="dropdown-menu">
                                                    @if(\Auth::user()->role_code == \App\Models\Roles::$POTZR_STAFF)
                                                        @if($poolaccount->status=='ACTIVE')
                                                            <li><a href="/potzr-staff/pool-accounts/status/suspend-account/{{$id}}">Suspend Account</a></li>
                                                        @elseif($poolaccount->status=='DISABLED')
                                                            <li><a href="/potzr-staff/pool-accounts/suspend-account/{{$id}}">Reactivate Account</a></li>
                                                        @endif
                                                        @if($poolaccount->status=='ACTIVE')
                                                            <li><a style="cursor: pointer" onclick="javascript:shownewcard(0, '{{$poolaccount->accountNumber." - ".$poolaccount->bank->bankName}}', '{{$id}}');loadAId('{{$id}}', 'fundAccount')">Fund Account</a></li>
                                                        @endif
                                                        <li><a style="cursor: pointer" onclick="javascript:shownewcard(2, '{{$poolaccount->accountNumber." - ".$poolaccount->bank->bankName}}', '{{$id}}');loadAId('{{$id}}', 'last5txns')">Last 5 Transactions</a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
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
@section('section_title') Pool Account List @stop
@section('scripts')
    <script>
        function shownewcard(fxn, accountname, account) {
            document.getElementById('notifymsg').innerHTML="";
            if (fxn == 0) {
                document.getElementById('accountname').innerHTML = accountname;
                document.getElementById('account').value = account;
                document.getElementById('modal-title').innerHTML = 'Add Debit/Credit Card';
                document.getElementById('txnId').style.display = 'block';
                document.getElementById('amtPaid').style.display = 'block';
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
                document.getElementById('txnId').style.display = 'none';
                document.getElementById('amtPaid').style.display = 'none';
                document.getElementById('last5txn').style.display = 'block';
                document.getElementById('fundpoolacctbtn').style.display = 'none';
                $("#wrapper_1").fadeIn();
                $.ajax({
                    url: '/potzr-staff/pool-accounts/last-five-txns/' + account,
                    dataType: 'json',
                    success: function (resp) {
                        if (resp.status === 1) {
                           htmlStr = resp.txn;
                        }else
                        {
                            htmlStr = resp.txn;
                        }
                        document.getElementById('last5txnlist').innerHTML = htmlStr;
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
            var aid = document.getElementById('aid').value;
            var action = document.getElementById('action').value;
            var banktransactionid = encodeURI(document.getElementById('bnktxnid').value);
            var amountPaid = encodeURI(document.getElementById('amt').value);
            var url = '';
            if(action =='fundAccount')
                url_ = '/potzr-staff/pool-accounts/fund-account/' + aid + '/' + banktransactionid + '/' + amountPaid;


            console.log("url_ = " + url_);

            $.ajax({
                url: url_,
                dataType: 'json',
                async: false,
                success: function (resp) {
                    console.log("resp"  + resp.status);
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
    </script>
@stop

@section('extraviews')


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
                <form class="form-horizontal" autocomplete="off" action="/potzr/pool-accounts/new-pool-account" method="post" enctype="application/x-www-form-urlencoded">
                <div class="modal-body" style="background-color: #00c0ef !important;">

                        <div id="notifymsg" style="padding:3px;"></div>

                        <input type="hidden" name="account" value="" id="account">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Account Name</label>

                                <div class="col-sm-9">
                                    <span id="accountname"></span>
                                </div>
                            </div>
                            <div class="form-group" id="txnId">
                                <label for="inputEmail3" class="col-sm-3 control-label">Bank Transaction Id</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="bnktxnid" placeholder="Name on Card" required>
                                </div>
                            </div>
                            <div class="form-group" id="amtPaid">
                                <label for="inputEmail3" class="col-sm-3 control-label">Amount Paid:</label>

                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="amt" placeholder="Name on Card" required>
                                </div>
                            </div>
                            <div class="form-group" id="last5txn">
                                <label for="inputEmail3" class="col-sm-3 control-label">Last 5 Transactions</label>

                                <div class="col-sm-9">

                                    <div id="last5txnlist" style="overflow-y: scroll; height:140px">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <!-- /.box-footer -->
                </div>
                <div class="modal-footer" style="background-color: #00a7d0 !important">
                    <input type="hidden" name="aid" id="aid" value="">
                    <input type="hidden" name="action" id="action" value="">
                    <div class="pull-left col col-md-3">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    </div>
                    <div class="pull-right col col-md-3" id="fundpoolacctbtn">
                        <a onclick="javascript:handleOverlayAction()" style="cursor:hand" class="btn btn-outline" id="clickActor">Fund Pool Account</a>
                    </div>
                </div>
                </form>
            </div>

        </div>

@stop