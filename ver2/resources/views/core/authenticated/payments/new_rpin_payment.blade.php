@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Devices @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">New Vendor Service Payment</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" novalidate action="/bank-teller/vendor-service/new-payment" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Merchant</label>

                        <div class="col-sm-9">
                            <select class="form-control" id="merchant" name="merchant" required>
                                <option value="">-Select A Merchant-</option>
                                @foreach($merchantList as $merchant)
                                    <option selected value="{{$merchant->id}}">{{$merchant->merchantCode}} - {{$merchant->merchantName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Vendor Service</label>

                        <div class="col-sm-9">
                            <select class="form-control" id="vendorService" name="vendorService" required>
                                <option value="">-Select Merchants Vendor Service-</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Amount Customer Is Paying</label>

                        <div class="col-sm-9">
                            <input type="number" class="form-control" name="amount" id="amount" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Customers Full Name/Identitification Id</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="payeeFullName" id="payeeFullName" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Customers Mobile Number</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="payeeMobile" id="payeeMobile" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Customers Email Address</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="payeeEmail" id="payeeEmail" required>
                        </div>
                    </div>

                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-default">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success pull-right">Pay For Vendor Service</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') New Vendor Service Payment @stop
@section('scripts')
<script>

    jQuery(function () {
        $("#merchant").on('change', function () {
            console.log("We are testing");
            var $this = $(this);
            var vendorService = $("#vendorService");
            var merchantId = $(this).val();
            console.log("merchantId" + merchantId);
            //lga.html('loading...');
            console.log("/utility/services/pull-vendor-service/" + merchantId);
            $.ajax({
                url: '/utility/services/pull-vendor-service/' + merchantId,
                dataType: 'json',
                success: function (resp) {
                    if (resp.status === 1) {
                        vendorService.empty();
                        $.each(resp.data, function (k, v) {
                            vendorService.append($('<option>', {
                                value: k + '_' + v,
                                text: v
                            }));
                        });
                        vendorService.prepend($('<option>', {
                            text: '-Select Vendor Service-',
                            value: null
                        }));
                    }
                },
                complete: function () {
                    $this.removeClass('disabled');
                    $("#vendorService").removeClass('disabled');
                }
            });

        });
    });
</script>
@stop