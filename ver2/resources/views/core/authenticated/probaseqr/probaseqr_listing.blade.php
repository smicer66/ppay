@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Card Scheme Listing @stop

@section('content')

@include('partials.errors')

<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Card List
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            All Probase QR Data
        </h5>
        <div class="form-desc">
            List of all Probase QR Data. Use the action button to carry out an action on a Probase QR Data
        </div>
        <div class="table-responsive">
            <table id="allCustomerCardTable" width="100%" class="table table-striped table-lightfont">
                <thead>
                    <tr>
                        <th>Wallet No</th>
                        <th>Customer Name</th>
                        <th>Tracking Number</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>&nbsp</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Wallet No</th>
                        <th>Customer Name</th>
                        <th>Tracking Number</th>
                        <th>Type</th>
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


@include('core.authenticated.probaseqr.view_probaseqr')


@stop
@section('section_title') Probase QR Data List @stop
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
		viewProbaseQRDataList(jwtToken);
    });
    </script>

	<style>
	.modal-dialog.modal-centered{
		top: calc((100vh/3) - 100px) !important;

		#r_code_holder{
			height: 100px !important;

			img{
				display: block;
				margin-left: auto;
				margin-right: auto;
			}
		}
	}
	</style>
@stop
