@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Listing @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes --><div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Banks</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">


                    <div class="box-header">
                        <h3 class="box-title">Bank Listing</h3>
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
                                            aria-label="Rendering engine: activate to sort column descending">Bank Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Bank Code</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">Online Banking URL Route</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Encryption Key</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $x=1;
                                ?>
                                <tbody>
                                    @foreach($bankList as $bank)
                                    <tr role="row" class="odd">
                                            <?php
                                            $id = \Crypt::encrypt($bank->id);
                                            $key = $bank->access_exodus;
                                            $panLength = strlen($key) - 10;
                                            $replacer = "";
                                            for($y=0; $y<$panLength; $y++)
                                            {
                                                $replacer = $replacer."*";
                                            }

                                            $key = substr($key, 0, 6).$replacer.substr($key, ($panLength - (4+$y)), 4);
                                            ?>
                                        <td class="sorting_1"><input type="checkbox" name="accounts[]"></td>
                                        <td class="sorting_1">{{$bank->bankName}}</td>
                                        <td>{{$bank->bankCode}}</td>
                                        <td>{{isset($bank->onlineBankingURL) ? $bank->onlineBankingURL : "N/A"}}</td>
                                        <td>{{$key}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-primary" type="button">Action</button>
                                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul role="menu" class="dropdown-menu">
                                                        <li><a style="cursor: pointer" onclick="javascript:shownewcard(2, '{{$bank->bankName}}', '{{$id}}');loadAId('{{$id}}', 'last5txns')">Last 5 Transactions</a></li>
                                                        <li><a href="/potzr-staff/banks/new-bank/{{$id}}">Update Bank</a></li>
                                                        <li><a href="/potzr-staff/banks/staff-listing/{{$id}}">Bank Staff</a></li>
                                                        <li><a href="/potzr-staff/register">New Bank Staff</a></li>
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
@section('section_title') Bank List @stop
@section('scripts')
    <script>
        function shownewcard(fxn, accountname, account) {
            document.getElementById('notifymsg').innerHTML="";
            if (fxn == 2) {
                //ajax call for pulling last 5 transactions
                var $this = $(this);
                var htmlStr = '';
                document.getElementById('last5txnlist').innerHTML = 'loading...';
                document.getElementById('accountname').innerHTML = accountname;
                document.getElementById('account').value = account;
                document.getElementById('modal-title').innerHTML = 'Last Five Transactions';
                document.getElementById('last5txn').style.display = 'block';
                $("#wrapper_1").fadeIn();
                $.ajax({
                    url: '/potzr-staff/banks/bank-transactions/' + account,
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
                <h4 class="modal-title" id="modal-title">Last Five Transactions</h4>
            </div>
                <div class="modal-body" style="background-color: #00c0ef !important;">

                    <div id="notifymsg" style="padding:3px;"></div>

                    <input type="hidden" name="account" value="" id="account">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Bank Name</label>

                        <div class="col-sm-9">
                            <span id="accountname"></span>
                        </div>
                    </div>
                    <div class="box-body">
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
                </div>
        </div>

    </div>
@stop