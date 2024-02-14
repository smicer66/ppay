@extends('core.authenticated.layout.layout1')
@section('title')  ProbasePay | Charge Component(s) @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="col-md-8 col-sm-12">
<div class="row">
  <div class="col-sm-12">
    <div class="element-wrapper">
      <div class="element-box">
        <form id="formValidate" action="/accountant/charges/new-charge-component" method="post">
          <h5 class="form-header">
            New Charge Component(s)
          </h5>
          <div class="form-desc">
            Provide a list of charges exclusive to transaction amounts. You can later specify the specific amount for each transaction/bill type
          </div>
          
	
          <div class="row">
            <div class="col-sm-6 rowa" id="row1">
              <div class="form-group rowentry">
                	<label for="">Charge Component Name</label>
			<div class="col-md-12 col-sm-12" style="padding-left: 0px !important; ">
			<div class="col-md-9" style="padding-left: 0px !important; float: left !important">
				<input class="form-control" data-minlength="1" id="companyName0" name="componentName[]" placeholder="" required="required" type="text">
			</div>
			<div class="col-md-3" style="float: left !important">
				<a onclick="duplicateHtmlObject('row', 1, document.getElementById('idCount').value); increaseId()"  class="btn btn-primary">+</a>
			</div>
			</div>
                	<div style="clear: both !important; padding-left: 0px !important; " class="col-md-12 help-block form-text text-muted form-control-feedback">
                  	Enter a valid unique charge component name
                	</div>

              </div>
            </div>
            
          </div>
          
          <div class="form-buttons-w">
            <button class="btn btn-primary" type="submit"> Save Charge Components</button>
          </div>
		<input type="hidden" name="idCount" id="idCount" value="1">
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
	
}

function increaseId()
{
	document.getElementById('idCount').value = document.getElementById('idCount').value + 1;
}



</script>

@stop