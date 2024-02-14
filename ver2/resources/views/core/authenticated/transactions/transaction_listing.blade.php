@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')

    @include('partials.errors')

    <!-- Info boxes -->
    <div class="element-wrapper col-md-12">
        <h6 class="element-header">
		@if($filter!=null && $filter=='merchant')
            Merchant Payments
		@elseif($filter!=null && $filter=='mpqr')
            MPQR Transactions
		@elseif($filter!=null && $filter=='card')
            Card Transactions
		@elseif($filter!=null && $filter=='wallet')
            Wallet Transactions
		@elseif($filter!=null && $filter=='device')
            Device Transactions
		@elseif($filter!=null && $filter=='mobile')
            Mobile Transactions
		@elseif($filter!=null && $filter=='ussd')
            USSD Transactions
		@else
            All Transactions
		@endif

        </h6>
        <div class="element-box">
            <h5 class="form-header">
                Last 1000 Transactions
            </h5>
            <div class="form-desc">
                List of last 1000 transactions. Use the action button to carry out an action on a merchant
            </div>
            <div class="table-responsive">
                <table id="alltransactionstable" width="100%" class="table table-striped table-lightfont">
                    <thead>
                    <tr style="background-color: #000 !important; color: #fff !important;">
                        <th>id</th>
                        <th>Date & Txn Ref</th>
                        <th>Customer</th>
                        <th>Service & Channel</th>
                        <th>Status</th>
                        <th>Total Amount</th>
			   <th>Total Charges</th>
                        <th>Balance After</th>
                        <!--<th>Post Pool Balance</th>-->
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>id</th>
                        <th>Date & Txn Ref</th>
                        <th>Customer</th>
                        <th>Service & Channel</th>
                        <th>Status</th>
                        <th>Total Amount</th>
			   <th>Total Charges</th>
                        <th>Balance After</th>
                        <!--<th>Post Pool Balance</th>-->
                        <th>Action</th>
                    </tr>
                    </tfoot>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>



@include('core.authenticated.charges.includes.journal_entry_float_view')

@stop
@section('section_title') Transaction Listing @stop

@section('style')
<style>
.pendingstatus{
	background-color: #0d6efd !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.successstatus{
	background-color: #198754 !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.customer_canceledstatus, .failstatus{
	background-color: #dc3545 !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.request_rollbackstatus{
	background-color: #ffc107 !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.reversedstatus{
	background-color: #000000 !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.channelspan{
	background-color: #6c757d !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.paymentmodespan{
	background-color: #ff6600 !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.currencymodespan{
	background-color: #9334eb !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
} 

table { border-collapse: collapse; empty-cells: show; }


tr.strikethrough  td { position:relative        }

tr.strikethrough td:before {
	/*text-decoration: line-through;
	text-decoration-color: red;*/
	content: " ";
  	position: absolute;
  	top: 50%;
  	left: 0;
  	border-bottom: 1px solid red;
  	width: 100%;
}


tr.strikethrough td:after {
  content: "\00B7";
  font-size: 1px;

}

</style>
@stop

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
	     var filter = null;
		@if($filter!=null)
		filter = '{{$filter}}';
		@endif

		var queryStr = "";

		@if(isset($data) && $data!=null)
			@foreach($data as $d => $d1)
				queryStr = "&{{$d}}={{$d1}}" + queryStr;
			@endforeach
		@endif
            	viewTransactionList(jwtToken, 4000, filter, queryStr );
        });


	
	function viewJournalEntries(transactionId)
	{
		var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
		var deviceCode = '{{PROBASEWALLET_DEVICE_CODE}}';
		var accountTypes = [];
		@foreach(glAccountTypes() as $ga => $ga_)
			accountTypes.push('{{$ga_}}');
		@endforeach
		viewJournalEntriesByFilter(jwtToken, deviceCode, transactionId, accountTypes);
	}


	function viewReverseTransaction(transactionId)
	{
		var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
		var deviceCode = '{{BEVURA_DEVICE_CODE}}';
		
		if (confirm('Please confirm, Are reversing this transaction?'))
		{
			var url = '/api/reverse-transaction';
			var data_ = [];
			console.log(jwtToken);
			console.log(deviceCode);
			console.log(transactionId);
			var formData = new FormData();
			formData.append('transactionId', transactionId);
			formData.append('deviceCode', deviceCode);
			
			$.ajax({
				type: "POST",
				url: (url),
				data: (formData),
				processData: false,
				contentType: false,
				cache: false,
				headers: {"Authorization": jwtToken},
				timeout: 600000,
				success: function handleSuccess(data1){
					console.log(data1);
					
				},
				error: function (e) {
					toastr.error('We experienced an issue updating your merchant profile. Please try again.');
				}
			});
		}
		else
		{
  			// Do nothing!
  			console.log('Thing was not saved to the database.');
		}
	}
    </script>
@stop



