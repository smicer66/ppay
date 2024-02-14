@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Teller @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes --><div class="row">
    <div class="col-xs-12">
        <div class="box">
@if(isset($customer) && $customer!=NULL)
            <div class="box-header">
                <h3 class="box-title">Customer Profile</h3>
            </div>
@endif
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
@if(isset($customer) && $customer!=NULL)
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="inputEmail3" class="col-sm-2 control-label">First Name</label>

                            <div class="col-sm-10">
                                @if(isset($customer))
                                    {{$customer->lastName}}, {{$customer->firstName}} {{$customer->otherName}}
                                @elseif(isset($account))
                                    {{$account->customer->lastName}}, {{$account->customer->firstName}} {{$account->customer->otherName}}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="inputEmail3" class="col-sm-2 control-label">Customer Verification No</label>

                            <div class="col-sm-10">

                                @if(isset($customer))
                                    {{$customer->verificationNumber}}
                                @elseif(isset($account))
                                    {{$account->customer->verificationNumber}}
                                @endif
                            </div>
                        </div>
                    </div>
@endif
                    @if(isset($account))
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="inputEmail3" class="col-sm-2 control-label">Account No</label>

                            <div class="col-sm-10">
                                {{$account->accountIdentifier}}
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="box-header">
                        &nbsp;
                    </div>


                    <div class="box-header">
                        <h3 class="box-title">Card Listing</h3>
                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            <table id="allCustomerCardTable" class="display" style="width:100%">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Card No</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Customer Detail</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Account Number</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Serial No</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">Card Scheme</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Card Type</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Card Status</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $x1=0;
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
@section('section_title') EagleCard Customer Card List @stop
@section('scripts')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
	<script type="text/javascript" src="/js/action.js"></script>
    <script>
	
	$(document).ready(function() 
	{
		
		viewCustomerCardList();
	});
	</script>
	<script>
	
    @if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
        function shownewcard(fxn, accountname) {
            document.getElementById('notifymsg').innerHTML = "";
            if (fxn == 0) {
                document.getElementById('accountname').innerHTML = accountname;
                $("#wrapper_1").fadeIn();
            }

        }
        function hidenewcard(){$("#wrapper_1").fadeOut();document.getElementById('notifymsg').innerHTML=""}

        function loadAId(x)
        {
            document.getElementById('aid').value = x;
        }

        function addMobileMoney()
        {
            document.getElementById('clickActor').style.display="none";
            document.getElementById('notifymsg').innerHTML = "<div style='background-color:orange; color:#fff; padding:3px'>Loading...</div>";
            var mobileNo = document.getElementById('mobileNo').value;
            var aid = document.getElementById('aid').value;
            $.ajax({
                url: '/bank-teller/cards/mmoney/activate-mmoney/' + aid + '/' + mobileNo,
                dataType: 'json',
                async: false,
                success: function (resp) {
                    console.log("resp"  + resp);
                    if (resp.status === 1) {
                        document.getElementById('notifymsg').innerHTML = "<div style='background-color:green; color:#fff; padding:3px'>" + resp.msg + "</div>";
                    }else
                    {
                        document.getElementById('notifymsg').innerHTML = "<div style='background-color:red; color:#fff; padding:3px'>" + resp.msg + "</div>";
                    }
                },
                error: function (resp) {
                    console.log("resp"  + resp);
                    document.getElementById('notifymsg').innerHTML = "<div style='background-color:red; color:#fff; padding:3px'>Error experienced funding account</div>";
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
                            <label for="inputEmail3" class="col-sm-3 control-label">Card Number</label>

                            <div class="col-sm-9">
                                <span id="accountname"></span>
                            </div>
                        </div>
                        <div class="form-group clearfix" id="txnId" style="clear:both">
                            <label for="inputEmail3" class="col-sm-3 control-label">Map Card to Mobile Number</label>

                            <div class="col-sm-9" style="clear:both">
                                <input type="text" class="form-control" id="mobileNo" placeholder="Mobile Number" required>
                            </div>
                        </div>
                        <div class="form-group clearfix" id="last5txn" style="display:none">
                            <label for="inputEmail3" class="col-sm-3 control-label">Last 5 Transactions</label>

                            <div class="col-sm-9">

                                <div id="last5txnlist">

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <!-- /.box-footer -->

                </div>
                <div class="modal-footer" style="background-color: #00a7d0 !important">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                    <input type="hidden" name="aid" id="aid" value="">
                    <a onclick="javascript:addMobileMoney()" style="cursor:hand" class="btn btn-outline" id="clickActor">Add Card</a>
                </div>
            </div>

        </div>
    @endif
@stop