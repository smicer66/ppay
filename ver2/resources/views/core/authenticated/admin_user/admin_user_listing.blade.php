@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Admin Staff @stop

@section('content')



    <div class="element-wrapper col-md-12">
        <h6 class="element-header">
            User List
        </h6>
        <div class="element-box">
            <h5 class="form-header" id="userlistTitle">
                All Users
            </h5>
            <div class="form-desc" id="userlistDesc">
                List of users. Use the action button to carry out an action on a user
            </div>
            <div class="table-responsive">
                <table id="allUsersTable" width="100%" class="table table-striped table-lightfont">
                    <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Mobile Number</th>
                        <th>Email Address</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>&nbsp</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Mobile Number</th>
                        <th>Email Address</th>
                        <th>Online Bank Route</th>
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


@stop
@section('section_title') User List @stop
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
            @if($urole==NULL)
            viewUserList(jwtToken);
            @else
            viewUserList(jwtToken, '{{$urole}}');
            @endif
        });
    </script>
@stop

