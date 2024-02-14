@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Customer Loans @stop

@section('content')


        <!-- Info boxes -->
<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Customer Loans
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            All Customer Loans
        </h5>
        <div class="form-desc">
            List of all customer loans. Click the Action button to carry out an action on an entry
        </div>
        <div class="table-responsive">
            <table id="billstable" width="100%" class="table table-striped table-lightfont">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Principal</th>
                        <th>Interest</th>
                        <th>Principal Repaid</th>
                        <th>Interest Repaid</th>
                        <th>Rate (%)</th>
                        <th>Is Paid</th>
                        <th>Utility</th>
                        <th>Date Loaned</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Customer</th>
                        <th>Principal</th>
                        <th>Interest</th>
                        <th>Principal Repaid</th>
                        <th>Interest Repaid</th>
                        <th>Rate (%)</th>
                        <th>Is Paid</th>
                        <th>Utility</th>
                        <th>Date Loaned</th>
                    </tr>
                </tfoot>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>



@stop
@section('title') Utility Purchased - Bevura @stop
@section('section_title') Utility Listing @stop
@section('scripts')
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>-->


	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/datatables.min.css"/>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/datatables.min.js"></script>

	<script type="text/javascript" src="/js/action.js"></script>
    <script>
	
	$(document).ready(function() 
	{
		var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
		viewCustomerLoansListing(jwtToken, 'deviceCode={{BEVURA_DEVICE_CODE}}');
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

            //var table = $('#merchanttable');
		//console.log(table);

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


	td.upper { 
  		text-transform: uppercase 
	}
    </style>
@stop
