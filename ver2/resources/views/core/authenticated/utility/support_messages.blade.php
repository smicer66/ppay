@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Support Message @stop

@section('content')


        <!-- Info boxes -->

<div class="col-md-12 col-sm-12">
<div class="row">
  <div class="col-sm-12">
<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Support Message List
    </h6>
    <div class="element-box">
	 <div class="col-md-8" style="float: left !important">
        	<h5 class="form-header">
            		All Support  Messages
        	</h5>
	 </div>
	 <div class="col-md-4" style="float: right !important">
		<a onclick="javascript:viewNewSupportMessage()" class="btn btn-primary pull-right">Create A Support Issue</a>
	 </div>

        <div class="form-desc" style="clear: both !important;">
            List of all support messages. Use the action button to carry out an action on a support message
        </div>
        <div class="table-responsive">
            <table id="allSupportMessagesTable" width="100%" class="table table-striped table-lightfont">
                <thead>
                    <tr>
                        <th width="15%">Date Sent</th>
                        <th width="17%">Sent By</th>
                        <th width="10%">Status</th>
                        <th>Details</th>
                        <th>&nbsp</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Date Sent</th>
                        <th>Sent By</th>
                        <th>Status</th>
                        <th>Details</th>
                        <th>&nbsp</th>
                    </tr>
                </tfoot>
                <tbody>
			@foreach($list as $l)
			<tr>
				<td>{{date('Y, M d H:i', strtotime($l->createdAt))}}</td>
				<td>{{$l->sendersName}}</td>
				<td>{{$l->status}}</td>
				<td>{!! nl2br($l->details) !!}</td>
				<td>
					<div class="btn-group mr-1 mb-1">
						<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>';
						<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">
							@if($l->status=="OPENED")
							<a class="dropdown-item" href="/potzr-staff/support-messages/close-support-message/{{$l->id}}">Close Support Issue</a>
							<a class="dropdown-item" onclick='javascript:viewNewSupportMessageReply("{{str_pad(($l->id),8,'0',STR_PAD_LEFT)}}", {{($l->id)}})'>Update Support Issue</a>
							@else
							<a class="dropdown-item" onclick='javascript:viewNewSupportMessageReply("{{str_pad(($l->id),8,'0',STR_PAD_LEFT)}}", {{($l->id)}})'>Re-Open Support Issue</a>
							@endif
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
</div>
</div>
</div>


@include('core.authenticated.partials.quick_view_new_support')
@include('core.authenticated.partials.quick_view_new_support_reply')



@stop
@section('section_title') Support Message List @stop
@section('scripts')
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
    <script type="text/javascript" src="/js/action.js"></script>
    <script>
	
	$(document).ready(function()
	{
        	var jwtToken = 'Bearer {{\Session::get('jwt_token')}}';
	 	var deviceCode = '{{BEVURA_DEVICE_CODE}}';
		viewSupportMessageList(jwtToken, deviceCode);
   	});



    </script>
@stop


