@extends('guests.payment.web.layout')
@section('content')
@include('partials.errors')
<?php
  $x = 0;
?>

    <div class="col col-md-12" style="padding:12px;">
        <div>
            &nbsp;
        </div>
        <div class="col col-md-12" style="float:none; margin: 0 auto; padding-left:0px !important">

            <?php
            $total = 0;
            ?>
            @for($f=0; $f<sizeof($paymentItems); $f++)
                <?php
                $total = $total + $itemAmounts[$f];
                ?>
            @endfor
            <div class="col col-md-6" style="margin: 0 auto; padding-left:0px !important; padding-right:0px
            !important; height:380px; overflow: hidden; background-color: #FFF; border-radius: 6px; border: 1px solid #D6D6D6;
            border: 1px solid rgba(0,0,0,.24); -webkit-box-shadow: 0 1px 21px rgba(0,0,0,.17); box-shadow: 0 1px 21px rgba(0,0,0,.17);">

                <div style="padding-top:15px;padding-bottom:15px;">
                    <div  class="col col-md-2">
                        <img src="/images/propay.png" height="40px">
                    </div>
                    <div class="col col-md-10">
                        <strong>{{$payerName}}<br>
                        <span style="font-size:20px;">ZMW{{number_format($total, 2, '.', ',')}}</span></strong>
                    </div>
                </div>
                <div  style="border-bottom: 1px solid rgba(0,0,0,.24); clear:both; font-size:4px;">
                    &nbsp;
                </div>
                <div style="background-color: #F8F8F9; height:400px; padding:20px">

                    <div  style="clear:both; font-size:4px;">
                        &nbsp;
                    </div>

                    <form action="/payments/process-web-eagle-go-to-otp" method="post" enctype="application/x-www-form-urlencoded">
                        <div>
                            <div class="input-group">
                                <div class="input-group-addon" style="background-color: #fff; border-right:0px"><i class="fa fa-credit-card"></i></div>
                                <input type="text" class="form-control" name="cardnum" style="font-weight: 300;
                                       display: block;
                                       color: #888;
                                       letter-spacing: .5px;
                                       font-size: 14px;
                                       border-left: 0px;
                                       padding-left: 8px;
                                       opacity: .8;
                                       cursor: text;
                                       -webkit-transition: all ease-out 120ms;
                                       -o-transition: all ease-out 120ms;
                                       transition: all ease-out 120ms;
                                       z-index: 50000;" placeholder="Card Number">
                            </div>
                        </div>

                        <div  style="clear:both; font-size:20px;">
                            &nbsp;
                        </div>


                        <div style="padding:0px !important;">
                            <div class="col col-md-6" style="padding-left:0px;">
                                <div class="input-group">
                                    <div class="input-group-addon" style="background-color: #fff; border-right:0px"><i class="fa fa-credit-card"></i></div>
                                    <input type="text" class="form-control" name="expdate" style="font-weight: 300;
                                           display: block;
                                           color: #888;
                                           letter-spacing: .5px;
                                           font-size: 14px;
                                           border-left: 0px;
                                           padding-left: 8px;
                                           opacity: .8;
                                           cursor: text;
                                           -webkit-transition: all ease-out 120ms;
                                           -o-transition: all ease-out 120ms;
                                           transition: all ease-out 120ms;
                                           z-index: 50000;" placeholder="MM/YY">
                                </div>
                            </div>

                            <div class="col col-md-6 pull-right" style="padding-right:0px">
                                <div class="input-group pull-right">
                                    <div class="input-group-addon" style="background-color: #fff; border-right:0px"><i class="fa fa-lock"></i></div>
                                    <input type="text" class="form-control" name="cvv" style="font-weight: 300;
                                           display: block;
                                           color: #888;
                                           letter-spacing: .5px;
                                           font-size: 14px;
                                           border-left: 0px;
                                           padding-left: 8px;
                                           opacity: .8;
                                           cursor: text;
                                           -webkit-transition: all ease-out 120ms;
                                           -o-transition: all ease-out 120ms;
                                           transition: all ease-out 120ms;
                                           z-index: 50000;" placeholder="CVV12">
                                </div>
                            </div>
                        </div>


                        <div  style="clear:both; font-size:20px;">
                            &nbsp;
                        </div>


                        <div style="padding:0px !important;">
                            <div class="col col-md-12" style="padding:0px;">
                                <input type="submit" class="form-control btn btn-primary col col-md-12" style="padding:10px; font-size:12px; font-weight:500" name="submit" value="Pay">
                            </div>
                        </div>

                        <div  style="clear:both; font-size:10px;">
                            &nbsp;
                        </div>
                        <input type="hidden" name="data" value="{{$data}}">
                        <input type="hidden" name="tempHolder" value="{{\Crypt::encrypt($tempHolder->id)}}">
                    </form>


                    <div style="text-align:center">
                        <span style="color: #777; font-size: 12px;">OR</span>
                    </div>

                    <div  style="clear:both; font-size:10px;">
                        &nbsp;
                    </div>

                    <div style="padding:0px !important;">
                        <div class="col col-md-12" style="padding:0px;">
                            <input type="submit" class="form-control btn btn-warning col col-md-12" style="padding:10px; font-size:12px; font-weight:500" name="submit" value="Pay With Probase Wallet">
                        </div>
                    </div>

                    <div  style="clear:both; font-size:10px;">
                        &nbsp;
                    </div>


                </div>
            </div>

            <div class="col col-md-6" style="text-align:right">
                <div class="col col-md-12">
                    <table class="table table-hover col col-md-12" style="font-size:12px" id="paytable">
                        <thead class="thead-inverse">
                        <th class="col col-md-8" style="font-size:11px;">
                            Description
                        </th>
                        <th class="col col-md-4">
                            <div style="text-align: right; font-size:11px;">Price (ZMW)</div>
                        </th>
                        </thead>
                        <tbody>

                        @for($f=0; $f<sizeof($paymentItems); $f++)
                        <tr class="{{$x++%2==0 ? 'table-success' : ''}}">
                            <td class="col col-md-8">{{$paymentItems[$f]}}</td>
                            <td class="col col-md-4"><div style="text-align: right">{{number_format($itemAmounts[$f], 2, '.', ',')}}</div></td>
                        </tr>
                        @endfor
                        <tr class="table-info" style="font-weight: bold">
                            <td class=" col col-md-8"><div style="text-align: left">Total</div></td>
                            <td class="col col-md-4"><div style="text-align: right">{{number_format($total, 2, '.', ',')}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="col col-md-6 clearfix" style="clear: both; text-align:center; padding-top: 20px;">
                <img src="/images/verified.png" align="middle">
            </div>
        </div>



    </div>
@endsection

@section('scripts')
    <script>

        jQuery(function () {
            $("#province").on('change', function () {
                alert('handle later');
                var $this = $(this);
                var district = $("#district");
                var provinceId = $(this).val();
                //lga.html('loading...');
                $.ajax({
                    url: '/utility/services/pull-district/' + provinceId,
                    dataType: 'json',
                    success: function (resp) {
                        if (resp.status === 1) {
                            $.each(resp.data, function (k, v) {
                                district.append($('<option>', {
                                    value: k + '_' + v,
                                    text: v
                                }));
                            });
                            district.prepend($('<option>', {
                                text: 'Select District',
                                value: null
                            }));
                        }
                    },
                    complete: function () {
                        $this.removeClass('disabled');
                        $("#district").removeClass('disabled');
                    }
                });

            });
        });



    </script>
@endsection