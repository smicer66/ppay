@extends('core.authenticated.layout.layout1')
@section('title')  ProbasePay | Charge Component(s) @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="col-md-12 col-sm-12">
<div class="row">
  <div class="col-sm-12">
    <div class="element-wrapper">
      <div class="element-box">

          <h5 class="form-header">
            List of Pool Accounts
          </h5>
          <div class="form-desc">
            All pool accounts on the system are displayed here
          </div>
          
	
          <div class="row">
                    		<table id="" width="100%" class="table table-striped table-lightfont">
				    <thead>
                                    <tr role="row" style="background-color: #000 !important; color: #fff !important;">
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Bank</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Account No</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"  style="text-align: center !important"
                                            aria-label="Platform(s): activate to sort column ascending">Customer Funds Domiciled Here?</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"  style="text-align: right !important"
                                            aria-label="Platform(s): activate to sort column ascending">Minimum Balance</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"  style="text-align: right !important"
                                            aria-label="Platform(s): activate to sort column ascending">Current Balance</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"  style="text-align: right !important"
                                            aria-label="Platform(s): activate to sort column ascending">Bank Balance</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" style="text-align: right !important"
                                            aria-label="CSS grade: activate to sort column ascending">Action</th>
                                    </tr>
                                </thead>
                                <?php
                                $x=1;
                                ?>
                                <tbody>
                                    @foreach($poolAccountList as $poolaccount)
                                   <tr role="row" class="odd">
						@if(isset($poolaccount->isTrustPoolAccount) && $poolaccount->isTrustPoolAccount==1)
                                        	<td style="font-weight: bold !important">{{strtoupper($poolaccount->bankName)}}</td>
                                        	<td class="sorting_1" style="font-weight: bold !important">{{$poolaccount->accountNumber}}</td>
						<td style="text-align: center; font-weight: bold !important">Yes</td>
						<td style="text-align: right !important; font-weight: bold !important">{{number_format($poolaccount->minimumBalance, 2, '.', ',')}}</td>
						<td style="text-align: right !important; font-weight: bold !important">{{number_format($poolaccount->currentBalance, 2, '.', ',')}}</td>
						<td style="text-align: right !important"><div style="padding-top: 10px !important; padding-bottom: 10px !important; font-weight: bold !important; display: none !important" id="availablebalanceDiv{{$poolaccount->id}}"></div><button style="clear: both !important;" class="btn btn-primary" onclick="viewBankBalance({{$poolaccount->id}})">View Bank Balance</button></td>

                                        	<td style="text-align: right !important; font-weight: bold !important">

							<div class="btn-group mr-1 mb-1">
        							<button aria-expanded="false" aria-haspopup="true" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton2" type="button">Action</button>
        							<div aria-labelledby="dropdownMenuButton2" class="dropdown-menu">
          								<a class="dropdown-item" href="#"> Update Pool Account</a>
          								<a class="dropdown-item" style="cursor: pointer !important" onclick="handleShowLoadPoolAccountView({{$poolaccount->id}})"> Fund Pool Account</a>
        							</div>
      							</div>

                                        	</td>
						@else
                                        	<td>{{strtoupper($poolaccount->bankName)}}</td>
                                        	<td class="sorting_1">{{$poolaccount->accountNumber}}</td>
						<td style="text-align: center">No</td>
						<td style="text-align: right !important">{{number_format($poolaccount->minimumBalance, 2, '.', ',')}}</td>
						<td style="text-align: right !important">{{number_format($poolaccount->currentBalance, 2, '.', ',')}}</td>
						<td style="text-align: right !important"><button onclick="viewBankBalance({{$poolaccount->id}})" class="btn btn-primary">View Bank Balance</button></td>

                                        	<td style="text-align: right !important">

							<div class="btn-group mr-1 mb-1">
        							<button aria-expanded="false" aria-haspopup="true" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton2" type="button">Action</button>
        							<div aria-labelledby="dropdownMenuButton2" class="dropdown-menu">
          								<a class="dropdown-item" href="#"> Update Pool Account</a>
          								<a class="dropdown-item" href="/accountant/pool-accounts/make-trust-account/{{$poolaccount->id}}/{{BEVURA_MERCHANT_CODE}}/{{BEVURA_DEVICE_CODE}}"> Make Trust Account</a>
          								<a class="dropdown-item" style="cursor: pointer !important" onclick="handleShowLoadPoolAccountView({{$poolaccount->id}})"> Fund Pool Account</a>
        							</div>
      							</div>

                                        	</td>
						@endif
                                    </tr>
                                    @endforeach
                                </tbody>
				</table>
            
          </div>
          
          
      </div>
    </div>
  </div>
</div>
</div>

<form id="poollistingform"></form>
@include('core.authenticated.poolaccount.includes.load_pool_account', compact('poolAccountList'))



@stop
@section('section_title') New Charge Component(s) @stop




<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/js/action.js?version=4.5.0"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


@section('scripts')

<script>
function viewBankBalance(poolId)
{
	var jwtToken = '{{\Session::get('jwt_token')}}';
	var deviceCode = '{{BEVURA_DEVICE_CODE}}';
	var merchantCode = '{{BEVURA_MERCHANT_CODE}}';
	viewPoolBalanceAtBank(jwtToken, deviceCode, poolId, merchantCode);
}
</script>

@stop










