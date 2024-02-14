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

            <h6 class="element-header">Village Banking
            </h6>



        <div class="element-box">
            <h5 class="form-header">
                All  Village Banking Groups
            </h5>
            <div class="form-desc">
                List of all village banking groups are listed here.<br>
                Click on any of the village banking groups to carry out an action on the group.
            </div>
	     <div class="table-responsive">
                <table id="allvillagebankinggroupstable" width="100%" class="table table-striped table-lightfont">
                    <thead>
                    <tr>
                        <th>Group Name</th>
                        <th>Created By</th>
                        <th class="text-center">Members</th>
                        <th class="text-center">Loans To Members</th>
                        <th>Created On</th>
                        <th>Status</th>
                        <th class="text-right">Mutual Contributions (ZMW)</th>
                        <th>&nbsp</th>
                    </tr>
                    </thead>

                    <tbody id="allvillagebankinggroupstablebody">

                    </tbody>
                </table>
            </div>
            
            <div class="col col-lg-12 col-md-12 col-xs-12 col-sm-12" style="clear: both !important">
        </div>
    </div>

    @include('core.authenticated.village_banking.add_village_bank_group')
    @include('core.authenticated.village_banking.add_village_bank_otp')
    @include('core.authenticated.village_banking.village_bank_group_settings')
    @include('core.authenticated.village_banking.smart_coops_interface')

@stop
@section('section_title') Village Banking @stop
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
            	viewVillageBankingGroupList(jwtToken, 1000, filter, queryStr, serverToken);
        });



    </script>
@stop

