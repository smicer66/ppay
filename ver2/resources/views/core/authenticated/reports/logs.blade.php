@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')

    @include('partials.errors')

    <!-- Info boxes -->
    <div class="element-wrapper col-md-12">
        <h6 class="element-header">
		Logs
        </h6>
        <div class="element-box">
		<form action="/potzr-staff/search-logs" method="get" id="filterform">
		<div class="row">
		<div class="col-md-9">
            		<h5 class="form-header">
                		Logs
            		</h5>
		</div>
				
		</div>


		<div class="row filterDiv" id="transactionReportFields" style="margin-left: 0px !important; margin-right: 0px !important"><fieldset class="row"><legend>Apply Filter</legend>
			<div class="col-md-3 reportFields" id="">
				<select id="logType" name="logType" class="form-control">
					<option value=>--Select Request Type--</option>
					@foreach(getRequestTypes() as $rt)
					<option value="{{$rt}}" {{isset($data['logType']) && $data['logType']==$rt ? 'selected' : '' }}>{{str_replace('_', ' ', $rt)}}</option>
					@endforeach				
				</select>
			</div>
			<div class="col-md-3 reportFields" id="">
				<input type="number" id="requestMobileNumber" name="requestMobileNumber" class="form-control" placeholder="Enter Users Mobile Number" value="{{isset($data['requestMobileNumber']) ? $data['requestMobileNumber'] : ''}}"/>
			</div>
			<div class="col-md-3 reportFields" id="">
				<input type="date" id="requestStartDate" name="requestStartDate" class="form-control" placeholder="Request Start Date" value="{{isset($data['requestStartDate']) ? $data['requestStartDate'] : ''}}"/>
			</div>
			<div class="col-md-3 reportFields" id="">
				<input type="date" id="requestEndDate" name="requestEndDate" class="form-control" placeholder="Request End Date" value="{{isset($data['requestEndDate']) ? $data['requestEndDate'] : ''}}"/>
			</div>
			<div class="col-md-12 pull-right text-right" style="">
				<a style="cursor: pointer !important" class="btn btn-primary runreport">Check Logs</a>
			</div></fieldset>
		</div>


		</form>
            
            <div class="table-responsive reportResponse" style="padding-top: 20px !important;" id="alllogsdiv">
                <table id="alltransactionstable" width="100%" class="table table-striped table-lightfont">
                    <thead>
                    <tr style="background-color: #000 !important; color: #fff !important;">
			   <th></th>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Request Type</th>
                        <th>User Identifier</th>
                        <th>Device Code</th>
                        <th>Is Live</th>
			   <th>Status</th>
                        <th>Request</th>
                        <th>Response</th>
                        <th>Response Level 2</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr style="background-color: #000 !important; color: #fff !important;">
			   <th></th>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Request Type</th>
                        <th>User Identifier</th>
                        <th>Device Code</th>
                        <th>Is Live</th>
			   <th>Status</th>
                        <th>Request</th>
                        <th>Response</th>
                        <th>Response Level 2</th>
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
@section('section_title') Reports @stop

@section('style')

@stop

@section('scripts')


	<style>
.wrapTextStyle1 { 
   white-space: pre-wrap;      /* CSS3 */   
   white-space: -moz-pre-wrap; /* Firefox */    
   white-space: -pre-wrap;     /* Opera <7 */   
   white-space: -o-pre-wrap;   /* Opera 7 */    
   word-wrap: break-word;      /* IE */
    flex-flow: wrap;
    overflow-wrap: anywhere;
}
	</style>
    <link rel="stylesheet" href="/css/aa.css">
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



function Popup(elem) {
	setTimeout(function(){
		$('#alltransactionstable_length').hide();
		$('#alltransactionstable_filter').hide();
		$('#alltransactionstable_info').hide();
		$('#alltransactionstable_paginate').hide();
		$('.actionColumn').hide();
      },1000);


      var mywindow = window.open('', 'new div', 'height=400,width=600');
      mywindow.document.write('<html><head><title></title>');
      mywindow.document.write('<link rel="stylesheet" href="/css/aa.css">');
      mywindow.document.write('<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">');

      mywindow.document.write('<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet" type="text/css">');
      mywindow.document.write('<link href="/bower_components/select2/dist/css/select2.min.css" rel="stylesheet">');
      mywindow.document.write('<link href="/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">');
      mywindow.document.write('<link href="/bower_components/dropzone/dist/dropzone.css" rel="stylesheet">');
      mywindow.document.write('<link href="/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">');
      mywindow.document.write('<link href="/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">');
      mywindow.document.write('<link href="/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">');
      mywindow.document.write('<link href="/bower_components/slick-carousel/slick/slick.css" rel="stylesheet">');
      mywindow.document.write('<link href="/css/main.css?version=4.5.0" rel="stylesheet">');
      mywindow.document.write('<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">');
      mywindow.document.write('<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css">');



      mywindow.document.write('</head><body >');

	setTimeout(function(){

      		mywindow.document.write($('#' + elem).html());
      		mywindow.document.write('</body></html>');
      		mywindow.document.close();
      		mywindow.focus();

		setTimeout(function(){mywindow.print();},1000);
	}, 10000);
      
      
      //mywindow.close();

      return true;
}


        $(document).ready(function()
        {
            var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
	     var filter = null;
		@if(isset($filter) && $filter!=null)
		filter = '{{$filter}}';
		@endif

		var queryStr = "";

		@if(isset($data) && $data!=null)
			@foreach($data as $d => $d1)
				queryStr = "&{{$d}}={{$d1}}" + queryStr;
			@endforeach
		@endif



			$('.reportResponse').hide();
			$('#alllogsdiv').show();

			filter = '';
			@if(isset($type) && $type!=null && strlen(trim($type))>0)
				queryStr = queryStr+ "&reqtype={{strtoupper($type)}}";
			@endif



console.log(filter);
console.log(queryStr);

			var requestTypes = [];
			@foreach(getRequestTypes() as $rt)
				requestTypes.push('{{$rt}}');
			@endforeach
	            	viewRequestLogsList(jwtToken, 1000, filter, queryStr, requestTypes);



		

        });


	
	

	$('.runreport').on('click', function(e){
		$('#filterform').submit();
	});


    </script>
@stop



