@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')

    @include('partials.errors')
    <!-- Info boxes -->
    <div class="element-wrapper col-md-12">

            <h6 class="element-header">Village Banking
                <a style="margin-left: 0px !important; cursor: pointer; color: #fff !important;" href="/my-groups" class="btn btn-primary pull-right"><strong>+<strong> My Village Banking Groups</a>
            </h6>



        <div class="element-box">
            <h5 class="form-header">
                My Village Banking Group Transactions
            </h5>
            <div class="form-desc">
                List of all village banking group transactions. These are for groups you belong to. This includes groups you created and those you joined.<br>
                Click on any of the village banking group transactions to carry out an action on the group.
            </div>
            <div class="table-responsive">
                <table id="allvillagebankinggrouptransactionstable" width="100%" class="table table-striped table-lightfont">
                    <thead>
                    <tr>
                        <th>Group Name</th>
                        <th>Member</th>
                        <th>Transaction Type</th>
                        <th>Transaction Date</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>&nbsp</th>
                    </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('core.authenticated.village_banking.add_village_bank_group')
    @include('core.authenticated.village_banking.village_bank_group_settings')

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
            viewTransactionList(jwtToken);
        });
    </script>
@stop

