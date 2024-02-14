@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Teller @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Payments Received</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" novalidate action="/bank-teller/transactions/receive" method="post" enctype="application/x-www-form-urlencoded">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Starting Date</label>

                        <div class="input-group" style="padding-left:15px !important;">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="col-sm-4" style="padding-left:0px !important;">
                                <input type="text" name="payoutDate" class="form-control payoutDate"   required >
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Bank</label>


                        <div class="col-sm-4">
                            <select class="form-control" name="bank"  id="bank" required>
                                <option value>-Select One-</option>
                                @foreach($banks as $bank)
                                    @if($bank->bankCode==\Auth::user()->staff_bank_code)
                                        <option value="{{$bank->id}}|||{{$bank->bankName}}">{{$bank->bankName}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">

                    <button type="submit" class="btn btn-sm btn-success pull-right">Generate Transaction List</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>





<div class="row">
    <!-- right column -->
    <div class="col-md-10">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Payments Paid-Out From Bank</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" autocomplete="off" novalidate action="/bank-teller/transactions/paid-out" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Starting Date</label>

                        <div class="input-group"  style="padding-left:15px !important;">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="col-sm-4" style="padding-left:0px !important;">
                                <input type="text" name="payoutDate" class="form-control payoutDate"   required >
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Bank</label>


                        <div class="col-sm-4">
                            <select class="form-control" name="bank"  id="bank" required>
                                <option value>-Select One-</option>
                                @foreach($banks as $bank)
                                    @if($bank->bankCode==\Auth::user()->staff_bank_code)
                                        <option value="{{$bank->id}}|||{{$bank->bankName}}">{{$bank->bankName}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-sm btn-success pull-right">Generate Transaction List</button>
                </div>
                <!-- /.box-footer -->
            </form>
        </div>
        <!-- /.box -->
    </div>
    <!--/.col (right) -->
</div>
@stop
@section('section_title') Transaction Listing @stop
@section('scripts')
<script>

    $(function () {

        $('.payoutDate').datepicker({
            format: 'yyyy-mm-dd',
            endDate: '+1d'
        });
    });


    jQuery(function () {
        $("#province").on('change', function () {
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
@stop