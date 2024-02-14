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
        <form id="formValidate" action="/accountant/journal-entries/setup" method="post">
          <h5 class="form-header">
            	Journal Entries Setup
          </h5>
          <div class="form-desc">
            	Specify which GL Accounts receive entries for any of the transaction types.
          </div>
          <?php
	asort($allServiceTypes);
	  ?>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                	<div class="table-responsive">
                    		<label for="">Service Type:</label>
				<div class="col-md-3 col-sm-6" style="padding-left: 0px !important; padding-bottom: 20px !important;">
							<select class="form-control" required="required" id="serviceType" name="serviceType" data-error="Select the bank this pool account belongs to">
								<option value>-Select Service Charge-</option>
                     					@foreach($allServiceTypes as $sTypeKey => $sType)
                     					<option value="{{$sTypeKey }}">{{$sType}}</option>
                     					@endforeach
               					</select>
				</div>
				<table id="" width="100%" class="table table-striped table-lightfont">
				    <thead>
                                    <tr role="row" style="background-color: #000 !important; color: #fff !important">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Charge</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">DR (GL Account)</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">CR (GL Account)</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Collections Wallet</th>
                                    </tr>
                                </thead>
                                
                                <tbody id="tbody">
                                    
                                </tbody>
				</table>
                  	</div>
              </div>
            </div>
            
          </div>

          <div class="form-buttons-w" id="saveSetupdiv">
            <button class="btn btn-primary" type="submit"> Save Setup</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
@stop
@section('section_title') Journal Entries Setup @stop
@section('scripts')

<script>
$(document).ready(function(){
	var html = '';
							html = html + '<tr role="row" class="odd">';
								html = html + '<td class="sorting_1" colspan="4" style="text-align: center !important">';
									html = html + 'Select a service type to provide the journal entries setup for that service type';
								html = html + '</td>';
							html = html + '</tr>';
						$('#tbody').html(html);
});




$('#serviceType').on('change', function(){


							var html = html + '<tr role="row" class="odd">';
								html = html + '<td class="sorting_1" colspan="4" style="text-align: center !important">';
									html = html + 'Loading....';
								html = html + '</td>';
							html = html + '</tr>';

	$('#tbody').html(html);
	$('#saveSetupdiv').hide();

	html = '';




	var serviceCharges = {};
	
	console.log(serviceCharges);
	var jwtToken = '{{\Auth::user()->token}}';
	console.log(jwtToken);
	jwtToken = 'Bearer ' + "{{\Session::get('jwt_token')}}";
	var formData = {};
	formData['serviceType'] = $('#serviceType').val();
	console.log(formData);
	if ($('#serviceType').val()=='') {
		//alert('SOMETHING WRONG');
		toastr.error("Provide all required information before submitting");
	} else {
		
		var url = '/api/service-charges/get-service-charge-by-service-type';
		$.ajax({
			type: "POST",
			url: (url),
			data: (JSON.stringify(formData)),
			processData: false,
			contentType: false,
			cache: false,
			headers: {"Authorization": jwtToken},
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				if(1==1)
				{
					//alert(33);
					if(data1.status==100)
					{
						var serviceCharges = data1.list;
						var glAccounts = data1.glAccounts;
						var currentJournalEntrySetupList = data1.currentJournalEntrySetupList;
						var collectionAccounts = data1.collectionAccounts;

console.log("collectionAccounts ");
console.log(collectionAccounts );
						var currentJournalEntrySetupList_ = [];
						if(currentJournalEntrySetupList!=null && currentJournalEntrySetupList.length>0)
						{
							for(var k=0; k<currentJournalEntrySetupList.length; k++)
							{
								var key1DR = currentJournalEntrySetupList[k]['glAccountIdDR'];
								var key1CR = currentJournalEntrySetupList[k]['glAccountIdCR'];
								currentJournalEntrySetupList_[currentJournalEntrySetupList[k]['chargeName']+"DR"]= key1DR;
								currentJournalEntrySetupList_[currentJournalEntrySetupList[k]['chargeName']+"CR"]= key1CR;
							}
						}
console.log(currentJournalEntrySetupList_);
						var html = "";
						if(serviceCharges!=null && serviceCharges.length>0)
						{
							


							for(var i=0; i<serviceCharges.length; i++)
							{
							var serviceCharge = serviceCharges[i];
							html = html + '<tr role="row" class="odd">';
								html = html + '<td class="sorting_1">';
									html = html + serviceCharge['chargeName'] + '<span style="color: #ff6600">*</span>';
									html = html + "<br><small>(Exclusive Charge)</small>";
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch('+serviceCharge['id']+')" required="required" id="dr'+serviceCharge['id']+'" name="dr_glaccount[]" data-error="Select the GL Account to debit">';
										html = html + '<option value>-Select GL Account to Debit-</option>';
										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];
											if(currentJournalEntrySetupList_[serviceCharge['chargeName'] + 'DR']==glAccount['id'])
												html = html + '<option selected value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###'+ serviceCharge['id'] +'">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###'+ serviceCharge['id'] +'">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';

										}
									html = html + '</select>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch('+serviceCharge['id']+')" required="required" id="cr'+serviceCharge['id']+'" name="cr_glaccount[]" data-error="Select the GL Account to credit">';
										html = html + '<option value>-Select GL Account to Credit-</option>';

										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];
											if(currentJournalEntrySetupList_[serviceCharge['chargeName'] + 'CR']==glAccount['id'])
												html = html + '<option selected value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###'+ serviceCharge['id'] +'">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###'+ serviceCharge['id'] +'">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';

										}
									html = html + '</select>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="" required="required" id="collectionAccount'+serviceCharge['id']+'" name="collectionAccount[]" data-error="Select a Collection Account">';
										html = html + '<option value>-Select A Collections Wallet-</option>';

										for(var j=0; j<collectionAccounts.length; j++)
										{
											var collectionAccount = collectionAccounts[j];
console.log(collectionAccount);
											html = html + '<option value="'+ collectionAccount['id'] +'###'+ collectionAccount['accountName'] + '###'+ collectionAccount['accountIdentifier'] +'">'+ collectionAccount['accountIdentifier'] + ' - ' + collectionAccount['accountName']  +'</option>';

										}
									html = html + '</select>';
								html = html + '</td>';
							html = html + '</tr>';

							}






							html = html + '<tr role="row" class="odd">';
								html = html + '<td class="sorting_1">';
									html = html + 'Transaction Amount<span style="color: #ff6600">*</span>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch(0)" required="required" id="dr0" name="dr_glaccount[]" id="dr" data-error="Select the GL Account to debit">';
										html = html + '<option value>-Select GL Account to Debit-</option>';
										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];
											if(currentJournalEntrySetupList_['Transaction AmountDR']==glAccount['id'])
												html = html + '<option selected value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###0">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###0">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';

										}
									html = html + '</select>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch(0)" required="required" id="cr0" name="cr_glaccount[]" data-error="Select the GL Account to credit">';
										html = html + '<option value>-Select GL Account to Credit-</option>';
										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];
											if(currentJournalEntrySetupList_['Transaction AmountCR']==glAccount['id'])
												html = html + '<option selected  value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###0">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###0">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
										}
									html = html + '</select>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="" required="required" id="collectionAccount'+serviceCharge['id']+'" name="collectionAccount[]" data-error="Select a collections account">';
										html = html + '<option value>-Select A Collections Wallet-</option>';

										for(var j=0; j<collectionAccounts.length; j++)
										{
											var collectionAccount = collectionAccounts[j];
											html = html + '<option value="'+ collectionAccount['id'] +'###'+ collectionAccount['accountName'] + '###'+ collectionAccount['accountIdentifier'] +'">'+ collectionAccount['accountIdentifier'] + ' - ' + collectionAccount['accountName']  +'</option>';
										}
									html = html + '</select>';
								html = html + '</td>';
							html = html + '</tr>';




							

							html = html + '<tr role="row" class="odd">';
								html = html + '<td class="sorting_1">';
									html = html + 'Discount Value<br><small>(Provide where applicable)</small>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch(0)" required="required" id="drdisc" name="dr_glaccount[]" data-error="Select the GL Account to debit">';
										html = html + '<option value>-Select GL Account to Debit-</option>';
										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];
											if(currentJournalEntrySetupList_['Discount ValueDR']==glAccount['id'])
												html = html + '<option selected value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-2">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-2">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';

										}
									html = html + '</select>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch(0)" required="required" id="crdisc" name="cr_glaccount[]" data-error="Select the GL Account to credit">';
										html = html + '<option value>-Select GL Account to Credit-</option>';
										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];
											if(currentJournalEntrySetupList_['Discount ValueCR']==glAccount['id'])
												html = html + '<option selected value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-2">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-2">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
										}
									html = html + '</select>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="" required="required" id="collectionAccount'+serviceCharge['id']+'" name="collectionAccount[]" data-error="Select a collections account">';
										html = html + '<option value>-Select A Collections Wallet-</option>';

										for(var j=0; j<collectionAccounts.length; j++)
										{
											var collectionAccount= collectionAccounts[j];
											html = html + '<option value="'+ collectionAccount['id'] +'###'+ collectionAccount['accountName'] + '###'+ collectionAccount['accountIdentifier'] +'">'+ collectionAccount['accountIdentifier'] + ' - ' + collectionAccount['accountName']  +'</option>';

										}
									html = html + '</select>';
								html = html + '</td>';
							html = html + '</tr>';



						if($('#serviceType').val()=="PAY_MERCHANT" || $('#serviceType').val()=="PAY_MERCHANT_BY_QR")
						{
							html = html + '<tr role="row" class="odd">';
								html = html + '<td class="sorting_1">';
									html = html + 'Merchant Scheme Fixed Charge<br><small>(Provide where applicable)</small>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch(0)" required="required" id="drfixedchargemerchantscheme" name="dr_glaccount[]" data-error="Select the GL Account to debit">';
										html = html + '<option value>-Select GL Account to Debit-</option>';
										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];
											if(currentJournalEntrySetupList_['Discount ValueDR']==glAccount['id'])
												html = html + '<option selected value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-4">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-4">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';

										}
									html = html + '</select>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch(0)" required="required" id="crfixedchargemerchantscheme" name="cr_glaccount[]" data-error="Select the GL Account to credit">';
										html = html + '<option value>-Select GL Account to Credit-</option>';
										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];
											if(currentJournalEntrySetupList_['Discount ValueCR']==glAccount['id'])
												html = html + '<option selected value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-4">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-4">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
										}
									html = html + '</select>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="" required="required" id="collectionAccount'+serviceCharge['id']+'" name="collectionAccount[]" data-error="Select a collections account">';
										html = html + '<option value>-Select A Collections Wallet-</option>';

										for(var j=0; j<collectionAccounts.length; j++)
										{
											var collectionAccount= collectionAccounts[j];
											html = html + '<option value="'+ collectionAccount['id'] +'###'+ collectionAccount['accountName'] + '###'+ collectionAccount['accountIdentifier'] +'">'+ collectionAccount['accountIdentifier'] + ' - ' + collectionAccount['accountName']  +'</option>';

										}
									html = html + '</select>';
								html = html + '</td>';
							html = html + '</tr>';



							html = html + '<tr role="row" class="odd">';
								html = html + '<td class="sorting_1">';
									html = html + 'Merchant Scheme Transaction Fee<br><small>(Provide where applicable)</small>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch(0)" required="required" id="drtxnfeemerchantscheme" name="dr_glaccount[]" data-error="Select the GL Account to debit">';
										html = html + '<option value>-Select GL Account to Debit-</option>';
										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];
											if(currentJournalEntrySetupList_['Discount ValueDR']==glAccount['id'])
												html = html + '<option selected value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-5">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-5">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';

										}
									html = html + '</select>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch(0)" required="required" id="crtxnfeemerchantscheme" name="cr_glaccount[]" data-error="Select the GL Account to credit">';
										html = html + '<option value>-Select GL Account to Credit-</option>';
										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];
											if(currentJournalEntrySetupList_['Discount ValueCR']==glAccount['id'])
												html = html + '<option selected value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-5">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-5">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
										}
									html = html + '</select>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="" required="required" id="collectionAccount'+serviceCharge['id']+'" name="collectionAccount[]" data-error="Select a collections account">';
										html = html + '<option value>-Select A Collections Wallet-</option>';

										for(var j=0; j<collectionAccounts.length; j++)
										{
											var collectionAccount= collectionAccounts[j];
											html = html + '<option value="'+ collectionAccount['id'] +'###'+ collectionAccount['accountName'] + '###'+ collectionAccount['accountIdentifier'] +'">'+ collectionAccount['accountIdentifier'] + ' - ' + collectionAccount['accountName']  +'</option>';

										}
									html = html + '</select>';
								html = html + '</td>';
							html = html + '</tr>';
						}
							

							/*html = html + '<tr role="row" class="odd">';
								html = html + '<td class="sorting_1">';
									html = html + 'Settlement Entry<br><small>(Applicable only to GL entries for Immediate Settlement)</small>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch(0)" required="required" id="drdisc" name="dr_glaccount[]" data-error="Select the GL Account to debit">';
										html = html + '<option value>-Select GL Account to Debit-</option>';
										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];
											if(currentJournalEntrySetupList_['Discount ValueDR']==glAccount['id'])
												html = html + '<option selected value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-2">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-3">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';

										}
									html = html + '</select>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch(0)" required="required" id="crdisc" name="cr_glaccount[]" data-error="Select the GL Account to credit">';
										html = html + '<option value>-Select GL Account to Credit-</option>';
										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];
											if(currentJournalEntrySetupList_['Discount ValueCR']==glAccount['id'])
												html = html + '<option selected value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-2">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-3">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
										}
									html = html + '</select>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch('+serviceCharge['id']+')" required="required" id="cr'+serviceCharge['id']+'" name="cr_glaccount[]" data-error="Select the GL Account to credit">';
										html = html + '<option value>-Select A Collections Wallet-</option>';

										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];
											if(currentJournalEntrySetupList_[serviceCharge['chargeName'] + 'CR']==glAccount['id'])
												html = html + '<option selected value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###'+ serviceCharge['id'] +'">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###'+ serviceCharge['id'] +'">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';

										}
									html = html + '</select>';
								html = html + '</td>';
							html = html + '</tr>';*/


							$('#saveSetupdiv').show();


						}
						else
						{

							html = html + '<tr role="row" class="odd">';
								html = html + '<td class="sorting_1">';
									html = html + 'Transaction Amount';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch(0)" required="required" id="dr0" name="dr_glaccount[]" id="dr" data-error="Select the GL Account to debit">';
										html = html + '<option value>-Select GL Account to Debit-</option>';
										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];

											if(currentJournalEntrySetupList_['Transaction AmountDR']==glAccount['id'])
												html = html + '<option selected value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###0">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###0">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';

										}
									html = html + '</select>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch(0)" required="required" id="cr0" name="cr_glaccount[]" data-error="Select the GL Account to credit">';
										html = html + '<option value>-Select GL Account to Credit-</option>';
										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];
											if(currentJournalEntrySetupList_['Transaction AmountCR']==glAccount['id'])
												html = html + '<option selected value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###0">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###0">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';

										}
									html = html + '</select>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="" required="required" id="collectionAccount" name="collectionAccount[]" data-error="Select a collections account">';
										html = html + '<option value>-Select A Collections Wallet-</option>';

										for(var j=0; j<collectionAccounts.length; j++)
										{
											var collectionAccount = collectionAccounts[j];
											html = html + '<option value="'+ collectionAccount['id'] +'###'+ collectionAccount['accountName'] + '###'+ collectionAccount['accountIdentifier'] +'">'+ collectionAccount['accountIdentifier'] + ' - ' + collectionAccount['accountName']  +'</option>';
										}
									html = html + '</select>';

								html = html + '</td>';
							html = html + '</tr>';






							html = html + '<tr role="row" class="odd">';
								html = html + '<td class="sorting_1">';
									html = html + 'Discount Value<br><small>(Applicable only to GL entries)</small>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch(0)" required="required" id="drdisc" name="dr_glaccount[]" data-error="Select the GL Account to debit">';
										html = html + '<option value>-Select GL Account to Debit-</option>';
										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];
											if(currentJournalEntrySetupList_['Discount ValueDR']==glAccount['id'])
												html = html + '<option selected value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-2">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-2">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';

										}
									html = html + '</select>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="checkmatch(0)" required="required" id="crdisc" name="cr_glaccount[]" data-error="Select the GL Account to credit">';
										html = html + '<option value>-Select GL Account to Credit-</option>';
										for(var j=0; j<glAccounts.length; j++)
										{
											var glAccount = glAccounts[j];
											if(currentJournalEntrySetupList_['Discount ValueCR']==glAccount['id'])
												html = html + '<option selected value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-2">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
											else
												html = html + '<option value="'+ glAccount['id'] +'###'+ glAccount['glAccountName'] +'###'+ glAccount['glAccountCode'] +'###-2">'+ glAccount['glAccountName'] + ' - ' + glAccount['glAccountCode']  +'</option>';
										}
									html = html + '</select>';
								html = html + '</td>';
								html = html + '<td class="sorting_1">';
									html = html + '<select class="form-control" onchange="" required="required" id="collectionAccount0" name="collectionAccount[]" data-error="Select a collections account">';
										html = html + '<option value>-Select A Collections Wallet-</option>';

										for(var j=0; j<collectionAccounts.length; j++)
										{
											var collectionAccount= collectionAccounts[j];
											html = html + '<option value="'+ collectionAccount['id'] +'###'+ collectionAccount['accountName'] + '###'+ collectionAccount['accountIdentifier'] +'">'+ collectionAccount['accountIdentifier'] + ' - ' + collectionAccount['accountName']  +'</option>';

										}
									html = html + '</select>';
								html = html + '</td>';
							html = html + '</tr>';
							$('#saveSetupdiv').show();


							$('#saveSetupdiv').show();
						}
						$('#tbody').html(html);



						$('#dismissBtn').click();
						$('#new_card_modal').show();
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						//logoutUser('Your session has ended. Please log in to continue', window.location.href);
						$('#saveSetupdiv').hide();
					}
					else
					{
						toastr.error(data1.message);
						$('#saveSetupdiv').hide();
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
						$('#saveSetupdiv').hide();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}
});

function checkmatch(id)
{
	var dr = $('#dr'+id).val();
	var cr = $('#cr'+id).val();

	console.log([dr, cr]);
	if(dr!='' && cr!='' && dr==cr)
	{
		//alert('GL account to debit can not be the same as the GL account to credit');
		//$('#dr'+id).val('');
		//$('#cr'+id).val('')
	}
}

</script>
@stop