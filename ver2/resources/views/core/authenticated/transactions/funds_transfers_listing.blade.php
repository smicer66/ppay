@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')

    @include('partials.errors')
    <!-- Info boxes -->
    <div class="element-wrapper col-md-12">

            <h6 class="element-header">Fund Transfers
                <a style="margin-left: 0px !important; cursor: pointer; color: #fff !important;" data-target="#funds_transfer_overview_modal" data-toggle="modal" class="btn btn-primary pull-right" onclick="loadFTModal('{{\Session::get('jwt_token')}}')">Transfer To Beneficiaries</a>
                <a style="margin-right: 10px !important; cursor: pointer; color: #fff !important;" data-target="#internal_funds_transfer_overview_modal" data-toggle="modal" class="btn btn-primary pull-right">Transfer From Wallet To My Cards</a>
            </h6>



        <div class="element-box">
            <h5 class="form-header">
                All Transfers
            </h5>
            <div class="form-desc">
                List of all transfers.
            </div>
            <div class="table-responsive">
                <table id="allfundtransferstable" width="100%" class="table table-striped table-lightfont">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Transaction Ref</th>
                        <th>Fee</th>
                        <th>Prev. Balance</th>
                        <th>Receipient</th>
                        <th>Channel</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>&nbsp</th>
                    </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('core.authenticated.transactions.funds_transfer')
    @include('core.authenticated.transactions.internal_funds_transfer')

@stop
@section('section_title') Transaction Listing @stop
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
            viewTransactionList(jwtToken);
        });
    </script>
@stop

