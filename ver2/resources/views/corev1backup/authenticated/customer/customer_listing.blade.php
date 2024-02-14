@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Bank Teller @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes --><div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">EagleCard Customer List</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="display" style="width:100%">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Full Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Customer Type</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Verification No</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">Mobile No</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Engine version: activate to sort column ascending">Contact Email</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Status</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--<li><a href="/customers/view-accounts">View Customer Accounts</a></li>
									<li><a href="/{{$accessingUserRole}}/customers/view-account-cards">View Customer Cards</a></li>
									@if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
										<li><a href="/customers/add-new-account">Add New Account</a></li>
									@endif
									<li><a href="/customers/view-profile">View Profile</a></li>
									@if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
										<li><a href="/customers/update-profile">Update Profile</a></li>
									@endif
									-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>



@stop


@section('section_title') New Customer Profile @stop
@section('scripts')
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
    <script type="text/javascript" src="/js/action.js"></script>
	
	<script>
	$(document).ready(function() {
		viewCustomerList();
	} );
	</script>
@stop