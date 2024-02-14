@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Issuer Listing @stop

@section('content')

@include('partials.errors')

<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Issuer List
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            All Issuers
        </h5>
        <div class="form-desc">
            List of all issuers. Use the action button to carry out an action on a Issuer
        </div>
        <div class="table-responsive">
            <table id="allIssuersTable" width="100%" class="table table-striped table-lightfont">
                <thead>
                    <tr>
                        <th>Issuer Name</th>
                        <th>Issuer Code</th>
                        <th>&nbsp</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Issuer Name</th>
                        <th>Issuer Code</th>
                        <th>&nbsp</th>
                    </tr>
                </tfoot>
                <tbody>
			
                    @foreach($issuerList as $issuer)
                    <tr>
                        <td>{{$issuer->issuerName}}</td>
                        <td>{{$issuer->issuerCode}}</td>
                        <td>&nbsp</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@stop
@section('section_title') Issuer List @stop
@section('scripts')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="http://cdn.datatables.net/responsive/1.0.1/js/dataTables.responsive.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
	<script type="text/javascript" src="/js/action.js"></script>

    
@stop


@section('style')
    <style>

        td.details-control {
            background: url('http://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('http://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
        }
    </style>
@stop
