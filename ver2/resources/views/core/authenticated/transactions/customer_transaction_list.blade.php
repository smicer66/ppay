@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | My Transactions @stop

@section('content')

    @include('partials.errors')

    <!-- Info boxes -->
    <div class="element-wrapper col-md-12">
        <h6 class="element-header">
            Transactions
        </h6>
        <div class="element-box">
            <h5 class="form-header">
                All Transactions
            </h5>
            <div class="form-desc">
                List of all my transactions. Use the action button to carry out an action on a merchant
            </div>
            <div class="table-responsive">
                <table id="alltransactionstable" width="100%" class="table table-striped table-lightfont">
                    <thead>
                    <tr>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Transaction Ref</th>
                        <th>Transaction Details</th>
                        <th>Service Type</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Transaction Ref</th>
                        <th>Transaction Details</th>
                        <th>Service Type</th>
                        <th>Amount</th>
                    </tr>
                    </tfoot>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>



@stop
@section('section_title') Transaction Listing @stop
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

            @if(\Auth::user()->role_code==\App\Models\Roles::$CUSTOMER)
                viewCustomerTransactionList(jwtToken);
            @else
                viewTransactionList(jwtToken);
            @endif
        });
    </script>
@stop


