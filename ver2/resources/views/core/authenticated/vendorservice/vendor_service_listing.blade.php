@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Vendor Service @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes --><div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Vendor Service</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">


                    <div class="box-header">
                        <h3 class="box-title">Vendor Service Listing</h3>
                    </div>

                    @if(isset($merchant) && $merchant!=NULL)
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="inputEmail3" class="col-sm-2 control-label">Merchant Name</label>

                                <div class="col-sm-10">
                                    {{$merchant->merchantName}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="inputEmail3" class="col-sm-2 control-label">Merchant Code</label>

                                <div class="col-sm-10">
                                    {{$merchant->merchantCode}}
                                </div>
                            </div>
                        </div>
                    @endif


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
                                            aria-label="Rendering engine: activate to sort column descending">Merchant Code</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Service Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">Amount Payable (ZMW)</th>
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
                                    @foreach($vendorServiceList as $vendorService)
                                        <?php
                                          $id = \Crypt::encrypt($vendorService->id);
                                        ?>
                                    <tr role="row" class="{{$x%2==0 ? 'odd' : 'even'}}">
                                        <td class="sorting_1"><input type="checkbox" name="accounts[]"></td>
                                        <td class="sorting_1">{{$vendorService->merchant!=NULL ? $vendorService->merchant->merchantCode : ""}}</td>
                                        <td>{{$vendorService->serviceName}}</td>
                                        <td>{{number_format($vendorService->amountPayable, 2, '.', ',')}}</td>
                                        <td>{{$vendorService->status}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-primary" type="button">Action</button>
                                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul role="menu" class="dropdown-menu">
                                                    @if(\Auth::user()->role_code == \App\Models\Roles::$POTZR_STAFF)
                                                        @if($vendorService->status=='ACTIVE')
                                                            <li><a href="/potzr-staff/vendor-service/status/suspend-vendor-service/{{$id}}">Suspend Service</a></li>
                                                            <li><a href="/potzr-staff/vendor-service/new-vendor-service/{{$id}}">Update Service</a></li>
                                                        @elseif($vendorService->status=='DISABLED')
                                                            <li><a href="/potzr-staff/vendor-service/status/reactivate-vendor-service/{{$id}}">Reactivate Service</a></li>
                                                        @endif
                                                        <li><a  style="cursor: pointer" onclick="javascript:shownewcard(1, 'servicename', '{{$id}}')">Last 5 Transactions</a></li>
                                                    @endif

                                                    @if(\Auth::user()->role_code == \App\Models\Roles::$MERCHANT)
                                                        @if($vendorService->status=='INACTIVE')
                                                            <li><a href="/merchant/vendor-service/status/reactivate-vendor-service/{{$id}}">Activate Service</a></li>
                                                        @endif
                                                        <li><a  style="cursor: pointer" onclick="javascript:shownewcard(1, 'servicename', '{{$id}}')">Last 5 Transactions</a></li>
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
@section('section_title') Vendor Service List @stop
@section('scripts')
    <script>
    @if(\Auth::user()->role_code == \App\Models\Roles::$MERCHANT)
        function shownewcard(fxn, accountname, account) {
            if (fxn == 1) {
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
                document.getElementById('last5txn').style.display = 'block';
                $("#wrapper_1").fadeIn();
                $.ajax({
                    url: '/merchant/vendor-service/last5transactions/' + account,
                    dataType: 'json',
                    success: function (resp) {
                        //if (resp.status === 1) {


                            document.getElementById('last5txnlist').innerHTML = resp.table;

                        //}
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

    @if(\Auth::user()->role_code == \App\Models\Roles::$MERCHANT)
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
                    <form class="form-horizontal" autocomplete="off" action="/potzr/pool-accounts/new-pool-account" method="post" enctype="application/x-www-form-urlencoded">
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
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Name on Card" required>
                                </div>
                            </div>
                            <div class="form-group" id="amtPaid">
                                <label for="inputEmail3" class="col-sm-3 control-label">Amount Paid:</label>

                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="inputEmail3" placeholder="Name on Card" required>
                                </div>
                            </div>
                            <div class="form-group" id="nameoncard">
                                <label for="inputEmail3" class="col-sm-3 control-label">Name On Card</label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="inputEmail3" placeholder="Name on Card" required>
                                </div>
                            </div>
                            <div class="form-group" id="cardtype">
                                <label for="inputEmail3" class="col-sm-3 control-label">Card Type</label>

                                <div class="col-sm-9">
                                    <select class="form-control" required>
                                        <option>option 1</option>
                                        <option>option 2</option>
                                        <option>option 3</option>
                                        <option>option 4</option>
                                        <option>option 5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="cardscheme">
                                <label for="inputEmail3" class="col-sm-3 control-label">Card Scheme</label>

                                <div class="col-sm-9">
                                    <select class="form-control" required>
                                        <option>option 1</option>
                                        <option>option 2</option>
                                        <option>option 3</option>
                                        <option>option 4</option>
                                        <option>option 5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="extraoptions">
                                <label for="inputEmail3" class="col-sm-3 control-label">Extra Options</label>

                                <div class="col-sm-9">
                                    <label class="control-sidebar-subheading">
                                        &nbsp;&nbsp;Add Mobile Money to this card
                                        <input type="checkbox" class="pull-left" checked>
                                    </label>
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



