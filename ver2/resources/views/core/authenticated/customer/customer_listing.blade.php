@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')

        <!-- Info boxes -->
<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Customers
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            All Customers
        </h5>
        <div class="form-desc">
            List of all customers. Use the action button to carry out an action on a card
        </div>
        <div class="table-responsive">
            <table id="customerTableList" width="100%" class="table table-striped table-lightfont">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Customer Type</th>
                        <th>Verification No</th>
                        <th>Mobile Number</th>
                        <th>Contact Email</th>
                        <th>Status</th>
                        <th>&nbsp</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Full Name</th>
                        <th>Customer Type</th>
                        <th>Verification No</th>
                        <th>Mobile Number</th>
                        <th>Contact Email</th>
                        <th>Status</th>
                        <th>&nbsp</th>
                    </tr>
                </tfoot>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>


@include('core.authenticated.account.new_account_step_1')
@include('core.authenticated.customer.customer_account_list')
@include('core.authenticated.ecards.account_cards_list')
@include('core.authenticated.customer.view_profile')
@include('core.authenticated.ecards.card_balance')
@include('core.authenticated.account.new_collection_account')
@include('core.authenticated.ecards.new_card')
@include('core.authenticated.partials.quick_view_change_card_cvv')



@stop
@section('section_title') Card Batch List @stop
@section('scripts')
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
    <script type="text/javascript" src="/js/action.js?x=920"></script>
    <script>

	var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
	viewCustomerList(jwtToken);
    </script>
@stop

@section('style')
    <style>
        @media (min-width: 992px) {
            .modal-lg, .modal-xl {
                max-width: 90vw !important;
            }
        }

        a{
            cursor: pointer !important;
        }
    </style>
@stop
