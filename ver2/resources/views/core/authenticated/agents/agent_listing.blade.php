@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Wallet Listing @stop

@section('content')



<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Agents
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            {{$title}}
        </h5>
        <div class="form-desc">
            {{$description}}
        </div>
        <div class="table-responsive">
            <table id="allAgentTable" width="100%" class="table table-striped table-lightfont">
                <thead>
                    <tr>
                        <th>Agent Name</th>
                        <th>Agent Code</th>
                        <th>Primary Device Code</th>
                        <th>Primary User</th>
                        <th>&nbsp</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Agent Name</th>
                        <th>Agent Code</th>
                        <th>Primary Device Code</th>
                        <th>Primary User</th>
                        <th>&nbsp</th>
                    </tr>
                </tfoot>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>


@include('core.authenticated.agents.fund_agent')

@stop
@section('section_title') Customer Accounts List @stop
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
		viewAgents(jwtToken, 'allAgentTable');
    });

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
