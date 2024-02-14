@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant Payments @stop

@section('content')

    @include('partials.errors')
    <!-- Info boxes -->
    <div class="element-wrapper col-md-12">
        <h6 class="element-header">
            Merchant Payments<span class="merchantInform"></span>
        </h6>
        <div class="element-box">
            <h5 class="form-header">
                All Merchant Payments<span class="merchantInform"></span>
            </h5>
            <div class="form-desc">
                List of all payments made to merchants. Use the action button to carry out an action on a payment
            </div>
            <div class="table-responsive">
                <table id="merchanttransactiontable" width="100%" class="table table-striped table-lightfont">
                    <thead>
                    <tr>
                        <th>Merchant</th>
                        <th>Date</th>
                        <th>Transaction Ref</th>
                        <th>Payer</th>
                        <th>Source Wallet/Card No</th>
                        <th>Service Type</th>
                        <th>Status</th>
                        <th>Currency</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Merchant</th>
                        <th>Date</th>
                        <th>Transaction Ref</th>
                        <th>Payer</th>
                        <th>Source Wallet/Card No</th>
                        <th>Service Type</th>
                        <th>Status</th>
                        <th>Currency</th>
                        <th>Amount</th>
                    </tr>
                    </tfoot>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>



@stop
@section('section_title') Merchant Payments Listing @stop
@section('scripts')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
    <script type="text/javascript" src="/js/action.js"></script>
    <script>

        $(document).ready(function()
        {
            var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
            viewMerchantTransactionList(jwtToken, {{$merchantId}});
        });
    </script>
@stop
