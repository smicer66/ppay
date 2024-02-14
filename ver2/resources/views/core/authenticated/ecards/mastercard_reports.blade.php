@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Merchant @stop

@section('content')


        <!-- Info boxes -->

<div class="col-md-12 col-sm-12">
<div class="row">
  <div class="col-sm-12">
<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Mastercard Report List
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            All Reports
        </h5>
        <div class="form-desc">
            List of all Mastercard reports. Enter the report date to download a report for a specific date.
        </div>
        <div class="table-responsive">


		<div class="col-md-12" style="padding-left: 0px !Important">

			<h6>Select Report Date</h6>
			<div class="col-md-2" style="float: left !important">
			<select id="day" class="form-control">
				<option value>--Day--</option>
				@for($x=1; $x<32; $x++)
					@if($x<10)
					<option value="0{{$x}}">0{{$x}}</option>
					@else
					<option value="{{$x}}">{{$x}}</option>
					@endif
				@endfor
			</select>
			</div>


			<?php
			$dates = ['01'=>'January', '02'=>'February', '03'=>'March', '04'=>'April', '05'=>'May', '06'=>'June', '07'=>'July', '08'=>'August', '09'=>'September', '10'=>'October', '11'=>'November', '12'=>'December', ];
			?>
			<div class="col-md-2" style="float: left !important">
			<select id="month" class="form-control">
				<option value>--Month--</option>
				@foreach($dates as $x => $y)
					<option value="{{$x}}">{{$y}}</option>
				@endforeach

			</select>
			</div>

			

			<div class="col-md-2" style="float: left !important">
			<select id="year" class="form-control">
				<option value>--Day--</option>
				<option value="{{date('Y')}}">{{date('Y')}}</option>
				<option value="{{date('Y')-1}}">{{date('Y')-1}}</option>
			</select>
			</div>
		</div>
            <table id="" width="100%" class="table table-striped table-lightfont">
                <thead>
                    <tr>
                        <th>Report Name</th>
                        <th>&nbsp</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th><strong style="font-weight: bold !Important">PHYSICAL CARDS</strong></th>
                        <th><strong style="font-weight: bold !Important">VIRTUAL CARDS</strong></th>
                    </tr>
                    <tr>
                        <th><a onclick="handledownload('Mark off file', 0)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">Mark off file</a></th>
                        <th><a onclick="handledownload('Card created report', 1)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">Card created report</a></th>
                    </tr>
                    <tr>
                        <th><a onclick="handledownload('Card programme Summary Settlement file', 0)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">Card Programme Summary Settlement file</a></th>
                        <th><a onclick="handledownload('Card linked report', 1)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">Card linked report</a></th>
                    </tr>
                    <tr>
                        <th><a onclick="handledownload('ICA Summary Settlement file', 0)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">ICA Summary Settlement file</a></th>
                        <th><a onclick="handledownload('Mark off file', 1)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">Mark off file</a></th>
                    </tr>
                    <tr>
                        <th><a onclick="handledownload('Detailed Settlement file', 0)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">Detailed Settlement file</a></th>
                        <th><a onclick="handledownload('Card programme Summary Settlement file', 1)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">Card programme Summary Settlement file</a></th>
                    </tr>
                    <tr>
                        <th><a onclick="handledownload('FX markup file', 0)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">FX markup file</a></th>
                        <th><a onclick="handledownload('ICA Summary Settlement file', 1)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">ICA Summary Settlement file</a></th>
                    </tr>
                    <tr>
                        <th><a onclick="handledownload('Unsettled Transaction Report', 0)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">Unsettled Transaction Report</a></th>
                        <th><a onclick="handledownload('Detailed Settlement file', 1)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">Detailed Settlement file</a></th>
                    </tr>
                    <tr>
                        <th><a onclick="handledownload('Card Linked report', 0)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">Card Linked report</a></th>
                        <th><a onclick="handledownload('FX markup file', 1)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">FX markup file</a></th>
                    </tr>
                    <tr>
                        <th><a onclick="handledownload('Failed transaction report', 0)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">Failed transaction report</a></th>
                        <th><a onclick="handledownload('Unsettled Transaction Report', 1)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">Unsettled Transaction Report</a></th>
                    </tr>
                    <tr>
                        <th><a onclick="handledownload('PAN detail report', 0)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">PAN detail report</a></th>
                        <th><a onclick="handledownload('Failed transaction report', 1)" style="cursor: pointer !important; text-decoration: underline !important; color: blue">Failed transaction report</a>s</th>
                    </tr>




                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>
</div>

@stop
@section('section_title') Mastercard Reports @stop
@section('scripts')
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
    <script type="text/javascript" src="/js/action.js"></script>
    <script>
	
	function handledownload(url, x)
	{
		
		var reportDate = $('#year').val() + "-" + $('#month').val() + "-" + $('#day').val();
		console.log("reportDate ....");
		console.log(reportDate );
		var formData = new FormData();
		formData.append("reportName", url);
		formData.append("reportDate", reportDate);
		formData.append("isVirtual", x);




		var url = '/potzr-staff/ecards/get-mastercard-report/' + url + '/' + reportDate + '/' + x;
		window.location = url;

		//alert(url);
		/*$.ajax({
			type: "POST",
			url: (url),
			data: (formData),
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				if(data1.success===true)
				{
					//alert(33);
					if(data1.status==100)
					{
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.message);
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});*/



	}
    </script>
@stop


