@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Transactions @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes --><div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{(isset($merchant) && $merchant!=null) ? "Merchant " : ""}}Transactions List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    @if(isset($device) && $device!=null)
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="inputEmail3" class="col-sm-2 control-label">Device Code</label>

                                <div class="col-sm-10">
                                    {{$device->deviceCode}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="inputEmail3" class="col-sm-2 control-label">Device Serial Number</label>

                                <div class="col-sm-10">
                                    {{$device->deviceSerialNo}}
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($merchant) && $merchant!=null)
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
                    @if(isset($channel) && $channel!=null)
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="inputEmail3" class="col-sm-2 control-label">Channel</label>

                                <div class="col-sm-10">
                                    {{$channel}}
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Date</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">TXN REF</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Payer Name</th>
                                        @if(\Auth::user()->role_code != \App\Models\Roles::$MERCHANT)
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Payee</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">Account No</th>
                                        @endif
                                        @if(!isset($channel))
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Engine version: activate to sort column ascending">OTP</th>
                                        @endif
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Status</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Amount Payable (ZMW)</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Charges (ZMW)</th>
                                    </tr>
                                </thead>
                                <?php
                                    $x=0;
                                    $totalActualAmount=0;
                                    $totalCharge=0;
                                    //dd($transactionList);
                                    ?>
                                <tbody>
                                    @foreach($transactionList as $transaction)
                                        <?php
                                        $charge = 0.00;
                                        $txnCharge = 0;
                                        $amt = 0;
                                        $txnPercent = 1;
                                        $actualAmount = 0;
                                        $amt = $transaction->amount;
                                        $actualAmount = $amt;
                                        /*if(isset($transaction->transactionCharge) && $transaction->transactionCharge!=NULL)
                                            $txnCharge = $transaction->transactionCharge;
                                        if(isset($transaction->transactionPercentage) && $transaction->transactionPercentage!=NULL)
                                            $txnPercent = 1 + ($transaction->transactionPercentage/100);

                                        if(isset($transaction->creditAccountTrue) && $transaction->creditAccountTrue==true)
                                        {
                                            $actualAmount = ($transaction->amount - $txnCharge)/$txnPercent;
                                            $amt = $transaction->amount;
                                        }
                                        else if(isset($transaction->creditAccountTrue) && $transaction->creditAccountTrue==false)
                                        {
                                            $actualAmount = ($transaction->amount - $txnCharge)/$txnPercent;
                                            $amt = $transaction->amount;
                                        }*/
                                        $totalActualAmount = $totalActualAmount + $actualAmount;
                                        $totalCharge = $totalCharge + ($amt - $actualAmount);

                                        ?>
                                    <tr role="row" class="{{$x++%2==0 ? 'even' : 'odd'}}">
                                        <td class="sorting_1">{{$transaction->transactionDate}}</td>
                                        <td>{{$transaction->transactionRef}}</td>
                                        <td>{{isset($transaction->payerName) ? $transaction->payerName : "N/A"}}</td>
                                        @if(\Auth::user()->role_code != \App\Models\Roles::$MERCHANT)
                                        <td>{{isset($transaction->merchant) ? $transaction->merchant->merchantName : "N/A"}}</td>

                                        <td>
                                            @if(isset($transaction->account) && isset($transaction->creditAccountTrue) &&
                                                $transaction->creditAccountTrue!=NULL && $transaction->creditAccountTrue==true
                                                && $transaction->account!=NULL)
                                                {{"CR: ".$transaction->account->accountIdentifier}}
                                            @endif
                                            @if(isset($transaction->account) && isset($transaction->creditAccountTrue) &&
                                                $transaction->creditAccountTrue!=NULL && $transaction->creditAccountTrue==false
                                                && $transaction->account!=NULL)
                                                {{"DR: ".$transaction->account->accountIdentifier}}
                                            @endif

                                            <!--For Pool Account-->
                                            @if(isset($transaction->poolAccount) && isset($transaction->creditPoolAccountTrue) &&
                                                $transaction->creditPoolAccountTrue!=NULL && $transaction->creditPoolAccountTrue==true
                                                && $transaction->poolAccount!=NULL)
                                                {{"CRP: ".$transaction->poolAccount->accountNumber}}
                                            @endif
                                            @if(isset($transaction->poolAccount) && isset($transaction->creditPoolAccountTrue) &&
                                                $transaction->creditPoolAccountTrue!=NULL && $transaction->creditPoolAccountTrue==false
                                                && $transaction->poolAccount!=NULL)
                                                {{"DRP: ".$transaction->poolAccount->accountNumber}}
                                            @endif
                                        </td>
                                        @endif
                                        @if(!isset($channel))
                                        <td class="sorting_1">{{isset($transaction->OTP) ? $transaction->OTP : ''}}</td>
                                        @endif
                                        <td> {{$transaction->status}} &nbsp;&nbsp;&nbsp;
                                            @if(\Auth::user()->role_code == \App\Models\Roles::$POTZR_STAFF)
                                                <a href="/potzr-staff/transactions/reverse/{{$x}}" title="Reverse Transaction"><i class="fa fa-rotate-left"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            {{"CR: ".number_format($actualAmount, 2, '.', ',')}}

                                        </td>
                                        <td>
                                            {{"".number_format(($amt - $actualAmount), 2, '.', ',')}}
                                        </td>

                                    </tr>
                                    @endforeach
                                    <tr role="row" class="odd">
                                        <td colspan="{{(\Auth::user()->role_code != \App\Models\Roles::$MERCHANT) ? 7 : 6}}"><strong>Total</strong></td>
                                        <td>
                                            {{"".number_format($totalActualAmount, 2, '.', ',')}}
                                        </td>
                                        <td>
                                            {{"".number_format($totalCharge, 2, '.', ',')}}
                                        </td>
                                    </tr>
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
@section('section_title') Transaction Listing @stop
@section('scripts')

@stop