@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Corporate Wallet Listing @stop

@section('content')

@include('partials.errors')

<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Wallets
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            {{$title}}
		<button class="btn btn-primary pull-right" style="color: #fff !important" onclick="handleNewCorporateAccount()" id="">Create New Corporate Account</button>
        </h5>
        <div class="form-desc">
            {{$description}}
        </div>
        <div class="table-responsive">
            <table id="allCorporateCustomerAccountTable" width="100%" class="table table-striped table-lightfont">
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Representative Name</th>
                        <th>Account Number</th>
                        <th>Bank Domiciled</th>
                        <th>Currency</th>
                        <th>Account Status</th>
			   <th>Balance</th>
                        <th>&nbsp</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Customer Name</th>
                        <th>Account Number</th>
                        <th>Bank Domiciled</th>
                        <th>Currency</th>
                        <th>Account Status</th>
			   <th>Balance</th>
                        <th>&nbsp</th>
                    </tr>
                </tfoot>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

@include('core.authenticated.account.new_corporate_account')


@stop
@section('section_title') Corporate Customer Accounts List @stop
@section('scripts')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
	<script type="text/javascript" src="/js/action.js"></script>

    <script>
    $(document).ready(function()
	{
        var jwtToken = '{{\Session::get('jwt_token')}}';
		viewCorporateCustomerAccounts(jwtToken, 'allCorporateCustomerAccountTable');
    });

    function loadAId(x, action)
    {
        document.getElementById('aid').value = x;
        document.getElementById('action').value = action;
    }

    </script>
@stop

@section('style')
<style>
    @media (min-width: 992px) {
        .modal-lg, .modal-xl {
            max-width: 90vw !important;
        }
    }
</style>
@stop
