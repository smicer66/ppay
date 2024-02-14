@extends('core.authenticated.layout.layout1')
@section('title')  ProbasePay | Manual Journal Entry @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="col-md-8 col-sm-8">
<div class="row">
  <div class="col-sm-12">
    <div class="element-wrapper">
      <div class="element-box">
        <form id="formValidate" action="/accountant/journal-entries/make-journal-entry" method="post">
          <h5 class="form-header">
            Manual Journal Entry
          </h5>
          <div class="form-desc">
            Make manual journal entries using this view
          </div>
          
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                	<div class="table-responsive">
                    		<label for="" style="font-weight: bold !important;">Transaction Details:</label>
				<table id="" width="100%" class="table table-striped table-lightfont">

                                
                                <tbody>
                                    <tr role="row" class="odd" id="">
                                        	<td class="sorting_1">
							<select class="form-control" required="required" name="currency" data-error="Select a charge component">
								<option value>-Select A Currency-</option>
                     					@foreach(getAllCurrency() as $curr => $currency)
                     					<option value="{{$curr}}">{{$currency}}</option>
                     					@endforeach
               					</select>
						</td>
                                        	<td class="sorting_1">
							<input class="form-control" data-minlength="1" placeholder="Enter Transaction Ref" name="transactionRef" required="required" step="0.0001" type="text" data-error="Specify the amount to credit">
						</td>
                                        	<td>
                                            &nbsp;
                                        	</td>
                                    </tr>
					<tr role="row" class="odd" id="">
                                        	<td class="sorting_1">
							<input class="form-control" data-minlength="10" placeholder="Enter Narration" name="narration" required="required" type="text" data-error="Specify the narration">
						</td>
                                        	<td class="sorting_1">
							<input class="form-control" data-minlength="10" placeholder="Enter Value Date" name="valueDate" required="required" step="0.0001" type="date" data-error="Specify the value date">
						</td>
                                        	<td>
                                            &nbsp;
                                        	</td>
                                    </tr>


                                </tbody>
				</table>
                  	</div>
              </div>
            </div>
            
          </div>


          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                	<div class="table-responsive">
                    		<label for="" style="font-weight: bold !important;">Debit Leg:</label>
				<table id="" width="100%" class="table table-striped table-lightfont">

                                
                                <tbody>
                                    <tr role="row" class="odd" id="">
                                        	<td class="sorting_1" width="30%">
							<select class="form-control" required="required" name="drglaccount" data-error="Select a charge component">
								<option value>-Select A GL Account To Debit-</option>
                     					@foreach($glAccountList as $glAccount)
                     					<option value="{{$glAccount->id}}|||{{$glAccount->glAccountName}}|||{{$glAccount->glAccountCode}}">{{$glAccount->glAccountName}} ({{$glAccount->glAccountCode}})</option>
                     					@endforeach
               					</select>
						</td>
                                        	<td class="sorting_1" width="30%">
							<select class="form-control" required="required" name="draccount[]" data-error="Select a debit account">
								<option value>-Select A Collections Account To Debit-</option>
                     					@foreach($collectionAccounts  as $collectionAccount)
                     					<option value="{{$collectionAccount->id}}|||{{$collectionAccount->accountIdentifier}}">{{$collectionAccount->accountName}} - {{$collectionAccount->accountIdentifier}} ({{$collectionAccount->firstName}} {{$collectionAccount->lastName}})</option>
                     					@endforeach
               					</select>
						</td>
                                        	<td class="sorting_1" width="30%">
							<input class="form-control" data-minlength="1" placeholder="Enter Amount" name="dramount" required="required" step="0.0001" type="number" data-error="Specify the amount to credit">
						</td>
                                        	<td>
                                            &nbsp;
                                        	</td>
                                    </tr>
                                    
                                </tbody>
				</table>
                  	</div>
              </div>
            </div>
            
          </div>
          




	   <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                	<div class="table-responsive">
                    		<label for="" style="font-weight: bold !important;">Credit Leg:</label>
				<table id="" width="100%" class="table table-striped table-lightfont">
				    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">GL Account</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Amount</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Add</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr role="row" class="odd" id="row1">
                                        	<td class="sorting_1" width="30%">
							<select class="form-control" required="required" name="cr_glaccount[]" data-error="Select a charge component">
								<option value>-Select A GL Account To Credit-</option>
                     					@foreach($glAccountList as $glAccount)
                     					<option value="{{$glAccount->id}}|||{{$glAccount->glAccountName}}|||{{$glAccount->glAccountCode}}">{{$glAccount->glAccountName}} ({{$glAccount->glAccountCode}})</option>
                     					@endforeach
               					</select>
						</td>
                                        	<td class="sorting_1" width="30%">
							<select class="form-control" required="required" name="craccount[]" data-error="Select a credit account">
								<option value>-Select A Collections Account To Credit-</option>
                     					@foreach($collectionAccounts  as $collectionAccount)
                     					<option value="{{$collectionAccount->id}}|||{{$collectionAccount->accountIdentifier}}">{{$collectionAccount->accountName}} - {{$collectionAccount->accountIdentifier}} ({{$collectionAccount->firstName}} {{$collectionAccount->lastName}})</option>
                     					@endforeach
               					</select>
						</td>
                                        	<td class="sorting_1" width="30%">
							<input class="form-control" data-minlength="1" placeholder="Enter Value" name="cr_amount[]" required="required" step="0.0001" type="number" data-error="Specify the amount to credit">
						</td>
                                        	<td>
                                            <a onclick="duplicateHtmlObject('row', 1, document.getElementById('idCount').value); increaseId()"  class="btn btn-primary" style="color: #ffffff">+</a>
                                        	</td>
                                    </tr>

                                </tbody>
				</table>
                  	</div>
              </div>
            </div>
            
          </div>




          <div class="form-buttons-w">
            <button class="btn btn-primary pull-left" style=""> Save Journal Entries</button>
          </div>
<input type="hidden" name="idCount" id="idCount" value="1">
<input type="hidden" name="ids" id="ids" value="1">
        </form>
      </div>
    </div>
  </div>
</div>
</div>
@stop
@section('section_title') New Charge Component(s) @stop
@section('scripts')

<script>
function duplicateHtmlObject(divName, id, newId)
{
	var ids = document.getElementById('ids').value;
	var xCount = {{sizeof($glAccountList)}};
	if(ids.split('###').length >= xCount)
	{
		alert("You can not create more than " + xCount + " charge component entries");
	}
	else
	{
	    	var original = document.getElementById(divName + (id));
    		var clone = original.cloneNode(true);
	   	clone.id = divName + (newId); // there can only be one element with an ID
    		original.parentNode.appendChild(clone);
		var inputs = clone.getElementsByTagName('input');
		for(var i=0; i<inputs.length; i++)
		{
			inputs[i].value = "";
			inputs[i].id = "companyName" + newId;
		}
		$("#formValidate").validator('update');
		document.getElementById('idCount').value = parseInt(document.getElementById('idCount').value) + 1;
		document.getElementById('ids').value =document.getElementById('ids').value + '###' + document.getElementById('idCount').value;
	}
}

function increaseId()
{
	
}

</script>


@stop