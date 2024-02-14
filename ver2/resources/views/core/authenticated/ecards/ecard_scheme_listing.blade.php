@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Card Scheme Listing @stop

@section('content')

@include('partials.errors')

<div class="element-wrapper col-md-10">
    <h6 class="element-header">
        Card Scheme List
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            All Card Schemes
        </h5>
        <div class="form-desc">
            List of all card schemes. Use the action button to carry out an action on a card scheme
        </div>
        <div class="table-responsive col-md-12 col-sm-12 col-xs-12">
            <table id="allCardSchemesTable" width="100%" class="table table-striped table-lightfont col-md-12 col-sm-12 col-xs-12">
                <thead>
                    <tr>
                        <th>Card Scheme Name</th>
                        <th>Scheme Code</th>
                        <th>Fixed Charge</th>
                        <th>Transaction Fee(%)</th>
                        <th>Minimum Balance</th>
                        <th>Currency</th>
                        <th>&nbsp</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Card Scheme Name</th>
                        <th>Scheme Code</th>
                        <th>Fixed Charge</th>
                        <th>Transaction Fee(%)</th>
                        <th>Minimum Balance</th>
                        <th>Currency</th>
                        <th>&nbsp</th>
                    </tr>
                </tfoot>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>


@stop
@section('section_title') Card Scheme List @stop
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
		viewCardSchemeList(jwtToken);
    });
    </script>
@stop