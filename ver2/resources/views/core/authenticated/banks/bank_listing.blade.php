@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Listing @stop

@section('content')

@include('partials.errors')

<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Bank List
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            All Banks
        </h5>
        <div class="form-desc">
            List of all banks. Use the action button to carry out an action on a bank
        </div>
        <div class="table-responsive">
            <table id="allBanksTable" width="100%" class="table table-striped table-lightfont">
                <thead>
                    <tr>
                        <th>Bank Name</th>
                        <th>Live Bank Code</th>
                        <th>Bank Identification Code</th>
                        <!--<th>Status</th>-->
                        <th>&nbsp</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Bank Name</th>
                        <th>Live Bank Code</th>
                        <th>Bank Identification Code</th>
                        <!--<th>Status</th>-->
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
@section('section_title') Bank List @stop
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
		viewBankList(jwtToken);
    });
    </script>
@stop
