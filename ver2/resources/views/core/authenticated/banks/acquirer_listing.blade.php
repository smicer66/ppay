@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Acquirer Listing @stop

@section('content')

@include('partials.errors')

<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Acquirer List
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            All Acquirers
        </h5>
        <div class="form-desc">
            List of all acquirers
        </div>
        <div class="table-responsive">
            <table id="allAcquirersTable" width="100%" class="table table-striped table-lightfont">
                <thead>
                    <tr>
                        <th></th>
                        <th>Acquirer Name</th>
                        <th>Acquirer Code</th>
                        <th>Acquirer Bank</th>
                        <th>Uses Pool Account</th>
                        <th>Is Live</th>
                        <th>Currencies Allowed</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>


                    @foreach($acquirerList as $acquirer)
                        <tr data-authKey="{{isset($acquirer->authKey) && $acquirer->authKey!=null ? $acquirer->authKey : 'N/A'}}"
                        	data-accessExodus="{{isset($acquirer->accessExodus) && $acquirer->accessExodus!=null ? $acquirer->accessExodus: 'N/A'}}"
                        	data-accountCreationDemoEndPoint="{{isset($acquirer->accountCreationDemoEndPoint) && $acquirer->accountCreationDemoEndPoint!=null ? $acquirer->accountCreationDemoEndPoint: 'N/A'}}"
                        	data-accountCreationEndPoint="{{isset($acquirer->accountCreationEndPoint) && $acquirer->accountCreationEndPoint!=null ? $acquirer->accountCreationEndPoint: 'N/A'}}"
                        	data-balanceInquiryDemoEndPoint="{{isset($acquirer->balanceInquiryDemoEndPoint) && $acquirer->balanceInquiryDemoEndPoint!=null ? $acquirer->balanceInquiryDemoEndPoint: 'N/A'}}"
                        	data-balanceInquiryEndPoint="{{isset($acquirer->balanceInquiryEndPoint) && $acquirer->balanceInquiryEndPoint!=null ? $acquirer->balanceInquiryEndPoint: 'N/A'}}"
                        	data-demoAuthKey="{{isset($acquirer->demoAuthKey) && $acquirer->demoAuthKey!=null ? $acquirer->demoAuthKey: 'N/A'}}"
                        	data-demoServiceKey="{{isset($acquirer->demoServiceKey) && $acquirer->demoServiceKey!=null ? $acquirer->demoServiceKey: 'N/A'}}"
                        	data-fundsTransferDemoEndPoint="{{isset($acquirer->fundsTransferDemoEndPoint) && $acquirer->fundsTransferDemoEndPoint!=null ? $acquirer->fundsTransferDemoEndPoint: 'N/A'}}"
                        	data-fundsTransferEndPoint="{{isset($acquirer->fundsTransferEndPoint) && $acquirer->fundsTransferEndPoint!=null ? $acquirer->fundsTransferEndPoint: 'N/A'}}"
                        	data-serviceKey="{{isset($acquirer->serviceKey) && $acquirer->serviceKey!=null ? $acquirer->serviceKey: 'N/A'}}"
                        	data-ftAuthKey="{{isset($acquirer->ftAuthKey) && $acquirer->ftAuthKey!=null ? $acquirer->ftAuthKey: 'N/A'}}"
                        	data-ftDemoAuthKey="{{isset($acquirer->ftDemoAuthKey) && $acquirer->ftDemoAuthKey!=null ? $acquirer->ftDemoAuthKey: 'N/A'}}"
				data-acquirerName="{{$acquirer->acquirerName}}" 
				data-acquirerCode="{{$acquirer->acquirerCode}}" 
				data-bankId="{{isset($acquirer->bank_id) && $acquirer->bank_id!=null ? $acquirer->bank_id: 'N/A'}}{{$acquirer->bank_id}}"
				data-isLive="{{$acquirer->isLive==true ? 1 : 0}}"
				data-holdFundsYes="{{$acquirer->holdFundsYes!=null && $acquirer->holdFundsYes==true ? 1 : 0}}" 
				data-acquirerId="{{$acquirer->id}}"
				data-allowedCurrency="{{isset($acquirer->allowedCurrency) && $acquirer->allowedCurrency!=null ? $acquirer->allowedCurrency: 'N/A'}}"
				data-defaultMerchantSchemeId="{{isset($acquirer->defaultMerchantSchemeId) && $acquirer->defaultMerchantSchemeId!=null ? $acquirer->defaultMerchantSchemeId: 'N/A'}}" 

                        	data-ftDemoServiceKey="{{isset($acquirer->ftDemoServiceKey) && $acquirer->ftDemoServiceKey!=null ? $acquirer->ftDemoServiceKey: 'N/A'}}"
                        	data-ftServiceKey="{{isset($acquirer->ftServiceKey) && $acquirer->ftServiceKey!=null ? $acquirer->ftServiceKey: 'N/A'}}"
                        	data-creditFTAuthKey="{{isset($acquirer->creditFTAuthKey) && $acquirer->creditFTAuthKey!=null ? $acquirer->creditFTAuthKey: 'N/A'}}"
                        	data-demoCreditFTAuthKey="{{isset($acquirer->demoCreditFTAuthKey) && $acquirer->demoCreditFTAuthKey!=null ? $acquirer->demoCreditFTAuthKey: 'N/A'}}">

				<td class="details-control"></td>
                            <td>{{$acquirer->acquirerName}}</td>
                            <td>{{$acquirer->acquirerCode}}</td>
                            <td>{{$acquirer->bankName}}</td>
                            <td>{{$acquirer->holdFundsYes==1 ? 'Yes' : 'No'}}</td>
                            <td>{{$acquirer->isLive==1 ? 'Yes' : 'No'}}</td>
                            <td>{{join(', ', explode('###', $acquirer->allowedCurrency))}}</td>
				<td>
					<div class="btn-group mr-1 mb-1">
						<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>
						<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">
							<a class="dropdown-item" onclick="viewUpdateAcquirer(this)" style="cursor: pointer !important">Update Acquirer</a>
						</div>
					</div>
				</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>




@stop

@include('core.authenticated.banks.includes.update_acquirer', ['all_merchant_schemes'=>$all_merchant_schemes])
@section('section_title') Acquirer List @stop
@section('scripts')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
	<script type="text/javascript" src="/js/action.js"></script>

    <script>
    $(document).ready(function()
	{
        //var jwtToken = '{{\Session::get('jwt_token')}}';
		//viewAcquirerList(jwtToken);
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

            var table = $('#allAcquirersTable').DataTable({});

            // Add event listener for opening and closing details
            $('#allAcquirersTable').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    console.log(tr.data());
                    row.child(format({
                        '<strong>Account Creation EndPoint (Demo):</strong>' : tr.data('accountcreationdemoendpoint'),
                        '<strong>Account Creation EndPoint (Live):</strong>' :  tr.data('accountcreationendpoint'),
                        '<strong>Balance Inquiry EndPoint (Demo):</strong>' : tr.data('balanceinquirydemoendpoint'),
                        '<strong>Balance Inquiry EndPoint (Live):</strong>' :  tr.data('balanceinquiryendpoint'),
                        '<strong>Funds Transfer EndPoint (Demo):</strong>' : tr.data('fundstransferdemoendpoint'),
                        '<strong>Funds Transfer EndPoint (Live):</strong>' :  tr.data('fundstransferendpoint'),
                        '<strong>Auth Key (Demo):</strong>' : '<div style="width: 800px !Important;overflow-wrap: break-word;">' + tr.data('demoauthkey').toString().substring(0, 130) + '...</div>',
                        '<strong>Auth Key (Live):</strong>' : '<div style="width: 800px !Important;overflow-wrap: break-word;">' + tr.data('authkey').toString().substring(0, 130) + '...</div>',
                        '<strong>Service Key (Demo):</strong>' :  tr.data('demoservicekey'),
                        '<strong>Service Key (Live):</strong>' :  tr.data('servicekey'),
                    })).show();
                    tr.addClass('shown');
                }
            });
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