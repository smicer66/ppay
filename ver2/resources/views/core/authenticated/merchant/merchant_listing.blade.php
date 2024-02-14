@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')


        <!-- Info boxes -->
<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Merchants
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            All Merchants
        </h5>
        <div class="form-desc">
            List of all merchants. Use the action button to carry out an action on a merchant
        </div>
        <div class="table-responsive">
            <table id="merchanttable" width="100%" class="table table-striped table-lightfont">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>Merchant Name</th>
                        <th>Merchant Code</th>
                        <th>Contact Email</th>
                        <th>Bank</th>
                        <th>Bank Account</th>
                        <th>Status</th>
                        <th>&nbsp</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>&nbsp;</th>
                        <th>Merchant Name</th>
                        <th>Merchant Code</th>
                        <th>Contact Email</th>
                        <th>Bank</th>
                        <th>Bank Account</th>
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
@section('section_title') Merchant Listing @stop
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
		viewMerchantList(jwtToken);
	});
	</script>



	<script>
        function format ( dataSource ) {
            var html = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;" width="100%">';
            for (var key in dataSource){
                html += '<tr>'+
                    '<td colspan="4">' + key             +'</td>'+
                    '<td colspan="4">' + dataSource[key] +'</td>'+
                    '</tr>';
            }
            return html += '</table>';
        }

        $(function () {

            var table = $('#merchanttable');
		console.log(table);

            // Add event listener for opening and closing details
            
        });
    	</script>
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
