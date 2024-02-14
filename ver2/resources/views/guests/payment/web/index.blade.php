@extends('guests.payment.web.layout')
@section('content')
@include('partials.errors')
<form action="/payments/translate-payment" method="post" enctype="application/x-www-form-urlencoded">
    <div class="col col-md-12" style="padding:12px;">
        <div>
        <label col-form-label style="font-size: 15px;"><strong>Payment Summary</strong></label>
        </div>
        <div>
        <label col-form-label style="font-size: 12px;"><strong>Please review the following details for this transaction</strong></label>
        </div>
        <div>
        <?php
        $x = 0;
        ?>
        <table class="table table-bordered table-hover col col-md-12" style="font-size:12px" id="paytable">
        <thead class="thead-inverse">
        <th class="col col-md-9">
            Description
        </th>
        <th class="col col-md-3">
            <div style="text-align: right">Item Price</div>
        </th>
        </thead>
        <tbody>
        @for($f=0; $f<sizeof($itemAmounts); $f++)
        <tr class="{{$x++%2==0 ? 'table-success' : ''}}">
            <td class="col col-md-9">{{$paymentItems[$f]}}</td>
            <td class="col col-md-3"><div style="text-align: right">{{$currency}}{{number_format($itemAmounts[$f], 2, '.', ',')}}</div></td>
        </tr>
        @endfor
        </tbody>
        <tfooter>
        <tr class="table-info" style="font-weight: bold">
            <td class=" col col-md-9"><div style="text-align: right">Total</div></td>
            <td class="col col-md-3"><div style="text-align: right">{{$currency}}{{number_format($amt, 2, '.', ',')}}</div></td>
        </tr>
        </tfooter>
        </table>
        </div>


        <div>
        &nbsp;
        </div>

        <div>
        <div class="alert-success" style="padding: 10px">
        <label col-form-label style="font-size: 15px;"><strong>Payment Options</strong></label>
        </div>
        <div>
        &nbsp;
        </div>
        <div style="font-size:13px;">
            <div class="col col-md-6" style="padding-bottom:25px">
                <input type="radio" name="payoption" value="LOCALVISA" required>&nbsp;<img src="/images/visa-mastercard.png" height="45px"><br>
                <span style="padding-left:25px; font-weight: bold">Local Bank Card</span>
            </div>
            <div class="col col-md-6" style="padding-bottom:25px">
                <input type="radio" name="payoption" value="EAGLECARD" required>&nbsp;<img src="/images/eaglecard.png" height="45px"><br>
                <span style="padding-left:35px; font-weight: bold">Eagle Card</span>
            </div>


            @if(isset($all_banks))
                <div class="col col-md-6" style="padding-bottom:25px">
                    <input type="radio" name="payoption" value="BANKONLINE" required>&nbsp;
                    <select name="net-banking" class="form-control-sm">
                        <option>-Select A Bank-</option>
                        @foreach($all_banks as $key => $bank)
                        <option value="{{$bank->bankCode}}">{{$bank->bankName}}</option>
                        @endforeach
                    </select><br>
                    <span style="padding-left:25px; font-weight: bold">Net Banking</span>
                </div>
            @endif

            <div class="col col-md-6" style="padding-bottom:25px">
                <input type="radio" name="payoption" value="OTC" required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <img src="/images/otc.png" height="45px"><br>
                <span style="padding-left:35px; font-weight: bold">Over The Counter Payment</span>
            </div>




            <!--<div class="col col-md-6" style="padding-bottom:25px">
                <input type="radio" name="payoption" value="MMONEY">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <img src="/images/mmoney.jpg" height="45px"><br>
                <span style="padding-left:35px; font-weight: bold">Eagle Card Mobile Money</span>
            </div>-->

            <div class="col col-md-12" style="padding-bottom:25px">
                <input type="radio" name="payoption" value="WALLET" required>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <img src="/images/probasewallet.png" height="45px"><br>
                <span style="padding-left:40px; font-weight: bold">ProbaseWallet</span>
            </div>
        <div>
        &nbsp;
        </div>


        </div>
        <div>
        &nbsp;
        </div>
        </div>

        <div>
        &nbsp;
        </div>

        <div>
        <div class="alert-success" style="padding: 10px">
        <label col-form-label style="font-size: 15px;"><strong>Billing Information</strong></label>
        </div>
        <div>
        &nbsp;
        </div>
        <div class="form-group" style="font-size:13px;">
        <div class="col col-md-4">
        <label col-form-label for="exampleInputPassword1"><strong>Payer Information</strong></label>
        </div>
        <div class="col col-md-8">
        <div class="col col-md-6" style="padding-bottom:15px;">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user"  style="font-size:11px;"></i></div>
                <input required value="John" type="text" name="firstName" class="form-control font12" style="font-size:11px;" id="exampleInputPassword1" placeholder="">
            </div>
            <span><small>First Name</small></span>
        </div>
        <div class="col col-md-6" style="padding-bottom:15px;">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-user" style="font-size:11px;"></i></div>
                <input required value="Paul" type="text" name="lastName" class="form-control font12" style="font-size:11px;" id="exampleInputPassword1" placeholder="">
            </div>
            <span><small>Last Name</small></span>
        </div>
        <div class="col col-md-6" style="padding-bottom:15px;">
            <div class="input-group">
                <div class="input-group-addon" style="font-size:11px;">@</div>
                <input required value="test@gmail.com" type="text" name="email" class="form-control font12" style="font-size:11px;" id="exampleInputPassword1" placeholder="">
            </div>
            <span><small>Email Address</small></span>
        </div>
        <div class="col col-md-6" style="padding-bottom:15px;">
            <div class="input-group">
                <div class="col col-md-4" style="padding:0px !important">
                    <select class="form-control" id="country" name="countryCode" style="width:none !important; padding:0px !important; height: 1.9rem !important; font-size:11px;">
                        <option value="">---</option>
                        @foreach($all_countries as $key => $country)
                            <option value="{{$country->id}}">+{{$country->mobileCode}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col col-md-8" style="padding:0px !important">
                    <input required value="0903780448" type="text" name="phoneNumber" class="form-control" style="width:none !important;  font-size:11px;" id="exampleInputPassword1" placeholder="">
                </div>
            </div>
            <span><small>Phone Number</small></span>
        </div>
        </div>
        </div>

        <div class="form-group" style="font-size:13px;">
        <div class="col col-md-4">
        <label col-form-label for="exampleInputPassword1"><strong>Billing Address</strong></label>
        </div>
        <div class="col col-md-8">
        <div class="col col-md-12" style="padding-bottom:15px;">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-home" style="font-size:11px;"></i></div>
                <input required value="143 Redmond Close" type="text" class="form-control font12" style="font-size:11px;" name="streetAddress" id="exampleInputPassword1" placeholder="">
            </div>
            <span><small>Street Address</small></span>
        </div>
        <div class="col col-md-12" style="padding-bottom:15px;">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-home" style="font-size:11px;"></i></div>
                <input required value="Lusaka" type="text" class="form-control font12" style="font-size:11px;" name="city" id="exampleInputPassword1" placeholder="">
            </div>
            <span><small>City</small></span>
        </div>
        <div class="col col-md-12" style="padding-bottom:15px;">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-home" style="font-size:11px;"></i></div>
                <select required name="Province" class="form-control font12" id="province" style="font-size:12px">
                    <option value>-Select Province-</option>
                    @foreach($all_provinces as $key => $province)
                        <option value="{{$province->id}}">{{$province->provinceName}}</option>
                    @endforeach
                </select>
            </div>
            <span><small>Province</small></span>
        </div>
        <div class="col col-md-12" style="padding-bottom:15px;">
            <div class="input-group">
                <div class="input-group-addon"><i class="fa fa-home" style="font-size:11px;"></i></div>
                <select required name="district" id="district" class="form-control font12" style="font-size:12px">
                    <option value>-Select District-</option>
                </select>
            </div>
            <span><small>District</small></span>
        </div>
        <div class="col col-md-12" style="padding-bottom:15px;">
            <div class="input-group">
                <input type="submit" name="continue" class="col col-md-12 btn btn-primary" value="CONTINUE">
            </div>
        </div>
        </div>
        </div>
        </div>

        <input type="hidden" name="data" value="{{$input}}">
    </div>
</form>
@endsection

@section('scripts')
    <script>

        jQuery(function () {

            $("#country").on('change', function () {
                var $this = $(this);
                var province = $("#province");
                var district = $("#district");
                var countryId = $(this).val();
                //lga.html('loading...');
                $("#province").empty();
                $("#district").empty();
                district.prepend($('<option>', {
                    text: '-Select District-',
                    value: null
                }));

                province.prepend($('<option>', {
                    text: 'Loading provinces...Please Wait',
                    value: null
                }));
                $.ajax({
                    url: '/utility/services/pull-province/' + countryId,
                    dataType: 'json',
                    success: function (resp) {
                        if (resp.status === 1) {
                            $("#province").empty();
                            $("#district").empty();
                            $.each(resp.data, function (k, v) {
                                province.append($('<option>', {
                                    value: k + '_' + v,
                                    text: v
                                }));
                            });
                            province.prepend($('<option>', {
                                text: '-You can now select a province-',
                                value: null
                            }));
                        }
                    },
                    complete: function () {
                        $this.removeClass('disabled');
                        $("#province").removeClass('disabled');
                    }
                });

            });


            $("#province").on('change', function () {
                var $this = $(this);
                var district = $("#district");
                var provinceId = $(this).val();
                //lga.html('loading...');
                $("#district").empty();
                district.prepend($('<option>', {
                    text: 'Loading districts...Please Wait',
                    value: null
                }));
                $.ajax({
                    url: '/utility/services/pull-district/' + provinceId,
                    dataType: 'json',
                    success: function (resp) {
                        if (resp.status === 1) {
                            $("#district").empty();
                            $.each(resp.data, function (k, v) {
                                district.append($('<option>', {
                                    value: k + '_' + v,
                                    text: v
                                }));
                            });
                            district.prepend($('<option>', {
                                text: '-You can now select a district-',
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