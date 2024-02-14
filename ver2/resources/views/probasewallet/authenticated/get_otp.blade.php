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
                                            $payFrom = explode(':::', $payFrom);
                                            ?>
                                            @for($i=0; $i<(sizeof($payFrom) - 1); $i++)
                                            <a href="#"><small>{{explode('---', $payFrom[$i])[1]}}<br>
                                            {{explode('---', $payFrom[$i])[2]}}</small></a>

                                            <div style="font-size:8px; height:8px">&nbsp;</div>
                                            @endfor
                                        </div>
                                    </h4>

                            </div>
                            <hr>

                        </div>

                    </div>

                    <div class="col-lg-8 col-md-7">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Enter OTP</h4>
                            </div>

                            <form action="/wallet/pay/customer/pay_bill/send_otp" method="POST" name="PayWalletForm" >
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

                    <div class="col-lg-8 col-md-7">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Make A Payment</h4>
                            </div>
                            <div class="content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Transaction Ref Number(s)</label>
                                            @foreach($txnRef as $key => $value)
                                                <div>{{$value}}</div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Order No</label>
                                            <div>{{$orderId}}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="content table-responsive table-full-width">
                                    <table class="table table-striped">
                                        <thead>
                                        <th>ID</th>
                                        <th>Item Name</th>
                                        <th style="text-align:right">Amount(ZMW)</th>
                                        </thead>
                                        <tbody>
                                        @for($f=0; $f<sizeof($paymentItems);$f++)
                                            <tr>
                                                <td>{{$x++}}.</td>
                                                <td>{{$paymentItems[$f]}}</td>
                                                <td style="text-align:right">{{number_format($paymentAmounts[$f], 2, '.', ',')}}</td>
                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>

                                </div>

                                <div class="clearfix"></div>


                            </div>
                        </div>
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