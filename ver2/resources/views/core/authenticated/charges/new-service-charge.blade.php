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
        <form id="formValidate" action="/accountant/service-charges/new-service-charge" method="post">
          <h5 class="form-header">
            New Service Charges
          </h5>
          <div class="form-desc">
            Provide a breakdown of the exclusive charges applicabble to a service type. The value of the charge component will be charged in the transaction amounts currency
          </div>
          
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                	<div class="table-responsive">
                    		<label for="">Service Type:</label>
				<div>{{$serviceTypeName}}</div>
				<table id="" width="100%" class="table table-striped table-lightfont">
				    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Charge Component</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Value Type</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">Value</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <tr role="row" class="odd" id="row1">
                                        	<td class="sorting_1">
							<select class="form-control" required="required" name="chargeComponent[]" data-error="Select a charge component">
								<option value>-Select A Charge Component-</option>
                     					@foreach($chargecomponentlist as $chargecomponent)
                     					<option value="{{$chargecomponent->id}}">{{$chargecomponent->chargeName}}</option>
                     					@endforeach
               					</select>
						</td>
                                        	<td class="sorting_1">
							<select class="form-control" required="required" name="valueType[]" data-error="Select a charge type">
								<option value>-Select A Charge Component-</option>
								<option value="PERCENTAGE_OF_TRANSACTION">Percentage of Transaction Amount</option>
								<option value="FLAT_VALUE">Flat Charge</option>
               					</select>
						</td>
                                        	<td class="sorting_1">
							<input class="form-control" data-minlength="1" placeholder="Enter Value" name="valuation[]" required="required" step="0.0001" type="number" data-error="Specify the valuatiion of the charge">
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
            <button class="btn btn-primary" type="submit"> Save Service Charges</button>
          </div>
<input type="hidden" name="idCount" id="idCount" value="1">
<input type="hidden" name="ids" id="ids" value="1">
<input type="hidden" name="serviceTypeCode" id="ids" value="{{$serviceTypeCode}}">
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
	var xCount = {{sizeof($chargecomponentlist)}};
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