@extends('core.authenticated.layout.layout1')
@section('title')  ProbasePay | Pool Account @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="col-md-8 col-sm-12">
<div class="row">
  <div class="col-sm-12">
    <div class="element-wrapper">
      <div class="element-box">
        <form id="formValidate" action="/accountant/gl-accounts/new-gl-account" method="post">
          <h5 class="form-header">
            {{isset($glAccount) && $glAccount!=null ? "Update GL Account" : "New GL Account(s)"}}
          </h5>
          <div class="form-desc">
		@if(isset($glAccount) && $glAccount!=null)
		<input type="hidden" name="glAccountId" value="{{$glAccount->id}}">
		@endif
            {{isset($glAccount) && $glAccount!=null ? "Update this GL Account" : "Create a new GL Accounts this system will be making use of"}}
          </div>


		<div class="row">
                    		<table id="" width="100%" class="table table-striped table-lightfont">
				    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending"
                                            aria-label="Rendering engine: activate to sort column descending">GL Account Type</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">GL Account Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1"
                                            aria-label="Platform(s): activate to sort column ascending">GL Account Code</th>
                                        	@if(isset($glAccount) && $glAccount!=null)

						@else
						<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                            aria-label="CSS grade: activate to sort column ascending">Action</th>
						@endif
                                    </tr>
                                </thead>
                                <?php
                                $x=1;
                                ?>
                                <tbody>
                                   <tr role="row" class="odd" id="row1">
                                        	<td class="sorting_1">
							<select class="form-control" required="required" name="glAccountType[]" data-error="Select GL Account type">
								<option value>-Select A GL Account Type-</option>
                     					@foreach($glAccountTypes as $glAccountType => $glType)
                     					<option value="{{$glAccountType}}" {{isset($glAccount) && $glAccount!=null && $glAccount->glAccountType==$glAccountType ? 'selected' : ''}} >{{$glType}}</option>
                    						@endforeach
               					</select>
							<div class="help-block form-text text-muted form-control-feedback">
                  						Select a valid GL Account Type
                					</div>
						</td>
                                        	<td>
							<input value="{{isset($glAccount) && $glAccount!=null ? $glAccount->glAccountName : ''}}" class="form-control" name="accountName[]" data-minlength="3" data-error="GL Account Name must be provided" placeholder="" required="required" type="text">
                					<div class="help-block form-text text-muted form-control-feedback">
                  						Enter a valid GL Account Name
                					</div>
						</td>
                                        	<td>
							<input value="{{isset($glAccount) && $glAccount!=null ? $glAccount->glAccountCode : ''}}" class="form-control" name="accountNumber[]" data-minlength="1" data-error="GL Account Code must be provided" placeholder="" required="required" type="text">
                					<div class="help-block form-text text-muted form-control-feedback">
                  						Enter a valid GL Account Code
                					</div>
						</td>
						@if(isset($glAccount) && $glAccount!=null)

						@else
                                        	<td>
							<a onclick="duplicateHtmlObject('row', 1, document.getElementById('idCount').value); increaseId()"  class="btn btn-primary" style="color: #ffffff">+</a>
							<div class="">
                  						&nbsp;
                					</div>
                                        	</td>
						@endif
                                    </tr>
                                </tbody>
				</table>
            
          </div>



          
          <div class="form-buttons-w">
            <button class="btn btn-primary" type="submit"> Save GL Account(s)</button>
          </div>
<input type="hidden" name="idCount" id="idCount" value="1">
        </form>
      </div>
    </div>
  </div>
</div>
</div>
@stop
@section('section_title') New Pool Account @stop
@section('scripts')

<script>
function duplicateHtmlObject(divName, id, newId)
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

function increaseId()
{
	
}

</script>


@stop