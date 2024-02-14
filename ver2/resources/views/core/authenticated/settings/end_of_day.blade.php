@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('style')
    <style>


        .smart_coops_modal {
            max-width: calc(100% - 10%);
            height: calc(100% - 10%) !important;
            margin: 1.75rem auto;
        }

        .smart_coops_modal1 {
            height: calc(100% - 5%) !important;
        }

        #mainFrame{
            height: calc(100%) !important;
        }

    </style>
@stop

@section('content')

    @include('partials.errors')
    <!-- Info boxes -->
    <div class="element-wrapper col-md-12">

            <h6 class="element-header">End Of Day
		  <button class="btn btn-primary pull-right" style="color: #fff !important" onclick="handleRunOfDay()" id="runbtn">Run End Of Day</button>
		  <button class="btn btn-primary pull-right" style="display: none !important; background-color: #000000 !important; border-color: #000 !important; color: #fff !important" onclick="handleRunOfDay()" id="runbtnstatus">Running End Of Day...</button>
		  
            </h6>



        <div class="element-box">
            <h5 class="form-header">
                All  End-Of-Day Ran
            </h5>

            <div class="form-desc">
                List of all end of day ran.<br>
                Click on any of the end of day to view the details.<br>
            </div>
	     <div class="table-responsive">
                <table id="allendofdayran" width="100%" class="table table-striped table-lightfont">
                    <thead>
                    <tr>
                        <th>Date Ran</th>
                        <th>Ran By</th>
                        <th>Started At</th>
                        <th>Ended At</th>
                        <th class="text-left">Status</th>
                        <th class="text-right">Village Loan Penalties Incurred</th>
                    </tr>
                    </thead>

                    <tbody id="allendofdayranbody">

                    </tbody>
                </table>
            </div>
            
            <div class="col col-lg-12 col-md-12 col-xs-12 col-sm-12" style="clear: both !important">
        </div>
    </div>


@stop
@section('section_title') End Of Day Ran @stop
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
	     var filter = null;
		

		var queryStr = "";
		var serverToken = '{{\Auth::user()->token}}';
            	viewEndOfDayList(jwtToken, 1000, filter, queryStr, serverToken);
        });


	
	function handleRunOfDay()
	{
		var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
	     	var filter = null;
		

		var queryStr = "";
		var serverToken = '{{\Auth::user()->token}}';
            	runEndOfDay(jwtToken, 1000, filter, queryStr, serverToken);

	}

    </script>
@stop

