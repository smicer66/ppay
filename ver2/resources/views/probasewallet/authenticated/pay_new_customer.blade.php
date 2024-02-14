@extends('probasewallet.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')


    <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <form action="/wallet/pay/customer/pay_customer/send_wallet_code" method="POST" name="PayWalletForm" >
                        <div class="col-lg-4 col-md-5">
                            <div class="card card-user">
                                <div class="content">
                                    <div class="" style="padding-bottom:20px; padding-left:5px;">

                                      <h4 class="title">Current Balance:<br />
                                         <a href="#"><small>ZMW{{number_format($balance, 2, '.', ',')}}</small></a>
                                      </h4>
                                    </div>


                                    <h4 class="title">Pay From Account:<br />
                                        <div style="padding-left:5px;">
                                            <?php
                                            $i=0;
                                            $x=1;
                                            $balanceList = $balanceList->map;
                                            ?>
                                            @foreach($balanceList as $key => $value)
                                                <input type="radio" class="" name="pay_from" value="{{$key}}" {{$i++==0 ? 'checked' : ''}}>
                                                <a href="#"><small>{{explode('---', $key)[1]}}<br>
                                                        Bal: ZMW{{number_format($value, 2, '.', ',')}}</small></a>

                                                <div style="font-size:8px; height:8px">&nbsp;</div>
                                            @endforeach
                                        </div>
                                    </h4>

                                </div>
                                <hr>
                            </div>

                        </div>
                        <div class="col-lg-8 col-md-7">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Enter Customers Wallet Number:</h4>
                                </div>


                                    <div class="content">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Receipient Wallet Account Number:</label>
                                                    <div><input name="walletcode_account" type="text" placeholder="Format (Wallet Code-Account Number)" class="form-control border-input"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Amount:</label>
                                                    <div><input name="amount" type="number" min="1" max="{{$balance}}" step="0.5" placeholder="Total Amount To Send" class="form-control border-input"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Access Code:</label>
                                                    <div><input name="accesscode" maxlength="4" type="number" min="1" max="9999" step="1" placeholder="Access Code For Receipient to Access Funds Transferred" class="form-control border-input"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Payment Info:</label>
                                                    <div><input type="text" name="payinfo" class="form-control border-input"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="text-right">
                                            <button id="paycustomer" type="submit" class="btn btn-success btn-fill btn-wd" onclick="javascript:handleSubmit();">Confirm Payment</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <input type="hidden" name="data" value="{{$data1}}">


                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </form>

                </div>
            </div>
        </div>

@stop


@section('scripts')
    <script type="text/javascript">
        function handleSubmit()
        {
            this.document.getElementById('paycustomer').disabled = 'disabled';
            this.document.PayWalletForm.submit();
        }

    </script>
@stop