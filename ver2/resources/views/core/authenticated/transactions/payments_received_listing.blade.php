@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')

    @include('partials.errors')
    <!-- Info boxes -->
    <div class="element-wrapper col-md-12">
        <h6 class="element-header">
            Payments Received
        </h6>
        <div class="element-box">
            <h5 class="form-header">
                Payments Received From Customers
            </h5>
            <div class="form-desc">
                All payments made by your customers on all your devices (websites, mobile applications, point of sale devices etc) are listed below.
                You can carry out actions on any of the payments depending on the status of the transaction
            </div>
            <div class="table-responsive">
                <table id="alltransactionstable" width="100%" class="table table-striped table-lightfont">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Transaction Ref</th>
                        <th>Customer Name</th>
                        <th>Narration</th>
                        <th>Channel</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>&nbsp</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>Transaction Ref</th>
                        <th>Payer</th>
                        <th>Narration</th>
                        <th>Channel</th>
                        <th>Status</th>
                        <th>Amount</th>
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
@section('section_title') Payments Received @stop
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
