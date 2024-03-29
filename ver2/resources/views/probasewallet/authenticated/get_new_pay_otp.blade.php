@extends('probasewallet.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')


    <div class="content">
            <div class="container-fluid">
                <div class="row">
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
                                            //$payFrom = explode('---', $payFrom);
                                            ?>

                                            <a href="#"><small>{{explode('---', $payFrom)[1]}}<br>
                                            Bal: ZMW{{number_format($balance, 2, '.', ',')}}</small></a>

                                            <div style="font-size:8px; height:8px">&nbsp;</div>
                                        </div>
                                    </h4>

                            </div>
                            <hr>

                        </div>

                    </div>

                    <div class="col-lg-8 col-md-7">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Transaction Ref: #{{$txnRef}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="header">
                                <h4 class="title">Enter OTP</h4>
                            </div>

                            <form action="/wallet/pay/customer/pay_customer/send_otp" method="POST" name="PayWalletForm" >
                                <div class="content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>OTP:</label>
                                                <div><input type="text" name="otp" class="form-control border-input"></div>
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
                            </form>

                        </div>
                    </div>
                    <div class="clearfix"></div>


                    <div class="col-lg-4 col-md-5">
                        &nbsp;
                    </div>


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