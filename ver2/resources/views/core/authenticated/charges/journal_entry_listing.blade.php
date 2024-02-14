@extends('core.authenticated.layout.layout1')
@section('title')  ProbasePay | Charge Component(s) @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->
<div class="col-md-12 col-sm-12">
<div class="row">
  <div class="col-sm-12">
    <div class="element-wrapper">
      <div class="element-box" style="overflow-x: scroll">

          <h5 class="form-header">
            Journal Entries{{$subTitle}}
          </h5>
          <div class="form-desc">
            Journal Entries on the system are displayed here
          </div>


	   <div class="form-desc">
		<fieldset>
		<legend>Filter Journal Entries</legend>
		<form action="/accountant/gl-accounts/all-journal-entries" method="post" enctype="application/x-www-form-urlencoded">
		<div class="col-md-11" style="float: left !important">
		<div class="col-md-3" style="float: left !important">
            	<select name="serviceType" class="form-control">
			<option value>--Select A Service Type--</option>
			@foreach(getAllServiceTypes() as $ast => $astVal)
			<option value="{{$ast}}" {{isset($all['serviceType']) && $all['serviceType']!=null && $all['serviceType']==$ast ? 'selected' : ''}}>{{$astVal}}</option>
			@endforeach
		</select>
		</div>


		<div class="col-md-3" style="float: left !important">
		<input type="date" name="startDate" class="form-control" placeholder="Enter Start Date" value="{{isset($all['startDate']) && $all['startDate']!=null ? $all['startDate'] : ''}}">
		</div>

		<div class="col-md-3" style="float: left !important">
		<input type="date" name="endDate" class="form-control" placeholder="Enter End Date"  value="{{isset($all['endDate']) && $all['endDate']!=null ? $all['endDate'] : ''}}">
		</div>
		</div>

		<div class="col-md-1" style="float: left !important">
			<input type="submit" class="btn btn-primary" value="Filter">
		</div>
		</form>
		</fieldset>
          </div>
          
	
          <div class="row" style="clear: both !important">
		&nbsp;
	   </div>
	
          <div class="row" style="clear: both !important">
                    		<table id="journalentrylist" width="100%" class="table table-striped table-lightfont">
				    <thead>
                                    <tr role="row" style="background-color: #000 !important; color: #fff !important">
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="1%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: center">S/No</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending" width="15%"
                                            aria-label="Rendering engine: activate to sort column descending">Reference</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" width="30%"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Description & Transaction Date</th>
                                        
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: center">Is Manual Entry</th>
						<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending">Service Type</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="15%"
                                            aria-label="CSS grade: activate to sort column ascending">Transacted By</th>
						<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending">GL Account</th>
						<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right">Debit</th>
						<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right">Credit</th>
                                    </tr>
                                </thead>
                                <?php
                                $x=1;
					$totalDebit = 0.00;
					$totalCredit = 0.00;
                                ?>
                                <tbody>
                                    <tr>
						<td colspan="9" style="text-align: center !important">Processing...</td>
					</tr>
                                </tbody>
					<tfooter>
                                    <tr role="row" style="background-color: #000 !important; color: #fff !important; font-weight: bold !important;">
                                        
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="1%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: center">&nbsp;</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2"
                                            rowspan="1" colspan="1" aria-sort="ascending" width="15%"
                                            aria-label="Rendering engine: activate to sort column descending"><strong>TOTAL</strong></th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" width="30%"
                                            rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">&nbsp;</th>
                                        
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: center">&nbsp;</th>
                                        
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: center">&nbsp;</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="15%"
                                            aria-label="CSS grade: activate to sort column ascending">&nbsp;</th>
						<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending">&nbsp;</th>
						<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right"><b id="debitTotal"></b></th>
						<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" width="10%"
                                            aria-label="CSS grade: activate to sort column ascending" style="text-align: right"><b id="creditTotal"></b></th>
                                    </tr>
                                </tfooter>
				</table>
            
          </div>
          
          
      </div>
    </div>
  </div>
</div>
</div>
@stop
@section('section_title') New Charge Component(s) @stop
@section('scripts')

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/datatables.min.css"/>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.3/b-2.1.1/b-html5-2.1.1/datatables.min.js"></script>
    <script type="text/javascript" src="/js/action.js"></script>

<style>

td{
	vertical-align: top !important;
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




<script>


$(document).ready(function()
{
       var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';

	filter = "";

		@foreach($all as $k => $v)
			@if($v!=null)
				filter = filter + '{{$k}}' + '=' + '{{$v}}&';
			@endif
		@endforeach


	console.log(filter);
	handleShowJournalEntryListing(jwtToken, filter );
});
				
</script>
@stop










