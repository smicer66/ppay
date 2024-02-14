@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Teller @stop

@section('content')

@include('partials.errors')

@if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
	@include('partials.navigation_bar_bank_teller')
@elseif(\Auth::user()->role_code == \App\Models\Roles::$POTZR_STAFF)
	@include('partials.navigation_bar_potzr_staff')
@elseif(\Auth::user()->role_code == \App\Models\Roles::$MERCHANT)
	@include('partials.navigation_bar_merchant')
@endif

@stop
@section('section_title') New Customer Profile @stop
@section('scripts')
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
    <script>
	
	
	$(document).ready(function() {
		$('#example2').DataTable( {
			"ajax": "/get-customer-list-ajax",
			"columns": [
				{ "data": "full_name" },
				{ "data": "customerType" },
				{ "data": "verificationNumber" },
				{ "data": "contactMobile" },
				{ "data": "contactEmail" },
				{ "data": "status" },
				{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
			]
		} );
	} );
    </script>
@stop