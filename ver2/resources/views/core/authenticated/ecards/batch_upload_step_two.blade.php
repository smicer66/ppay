@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Upload Card Batch - Step Two @stop

@section('content')


        <!-- Info boxes -->

<div class="col-md-12 col-sm-12">
<div class="row">
  <div class="col-sm-12">
<div class="element-wrapper col-md-12">
    <h6 class="element-header">
        Card List
    </h6>
    <div class="element-box">
        <h5 class="form-header">
            All Cards
        </h5>
        <div class="form-desc">
            List of cards found in CSV file uploaded
        </div>
        <div class="table-responsive">
		<input type="hidden" name="acquirer" id="acquirer" value="{{$acquirerId}}">
		<input type="hidden" name="issuer" id="issuer" value="{{$issuerId}}">
		<input type="hidden" name="cardBatchCode" id="cardBatchCode" value="{{$batchCode}}">

            <table id="" width="100%" class="table table-striped table-lightfont">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Serial NO</th>
                        <th>Tracking Number</th>
                        <th>Pan</th>
                        <th>Status</th>
                    </tr>
                </thead>
		  <tbody>
		  <?php
		  $x=1;
		  $y=1;
		  ?>
		  @foreach($dataRead as $lt)
			@if($x++>2)
			<tr id="tag{{$y}}">
				<td><span id="sna{{$y}}" style="text-align: left !important; ">{{$y}}.</span></td>
				<td><span id="snb{{$y}}" style="text-align: left !important; ">{{$lt[0]}}</span></td>
				<td><span id="snc{{$y}}" style="text-align: left !important; ">{{$lt[1]}}</span></td>
				<td><span id="snd{{$y}}" style="text-align: left !important; ">{{$lt[2]}}</span></td>
				<td>
					<div class="btn-primary" style="text-align: center !important; padding: 5px !important;" id="statusDiv{{$y}}">Pending</div>
					<div id="msg{{$y}}" style="text-decoration: italics !important"></div>
					<input type="hidden" name="serialNo[]" id="serialNo{{$y}}" value="{{$lt[0]}}">
					<input type="hidden" name="trackingNo[]" id="trackingNo{{$y}}" value="{{$lt[1]}}">
					<input type="hidden" name="panNo[]" id="panNo{{$y++}}" value="{{$lt[2]}}">
				</td>
			</tr>
			@endif
		  @endforeach
		  </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5"><a onclick="handleJqueryUpload({{$y}})" id="btnClicked" class="btn btn-success pull-right"><span style="color: #fff !important">Upload Batch</span></a></th>
                    </tr>
                </tfoot>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>
</div>



@stop
@section('section_title') Upload Card Batch - Step Two @stop
@section('scripts')
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.css"/>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.21/datatables.min.js"></script>
    <script type="text/javascript" src="/js/action.js"></script>
    <script>
	function handleJqueryUpload(ct)
	{
		console.log(ct);

		if (confirm("Do not Refresh this page!") == true) {
  			var y=0;
			$('#btnClicked').hide();
			var xyz = setInterval(function () {



				console.log('y....'+y);

				if(y>=ct)
				{
					clearTimeout(xyz);
					//$('#fundwalletsbtn').hide();
				}
				else
				{
					y++;
					var serialNo = '#serialNo'+y;
					var trackingNo = '#trackingNo'+y;
					var panNo = '#panNo'+y;

					var formData = new FormData();



					formData.append('trackingNo', $(trackingNo).val());
					formData.append('panNo', $(panNo).val());
					formData.append('serialNo', $(serialNo).val());
					formData.append('acquirer', $('#acquirer').val());
					formData.append('issuer', $('#issuer').val());
					formData.append('cardBatchCode', '{{$batchCode}}');

					var url = '/api/ecards/batch-card-upload-to-server';
					
					console.log(formData);

					$.ajax({
						type: "POST",
						url: (url),
						data: (formData),
						processData: false,
						contentType: false,
						cache: false,
						headers: {"Authorization": 'Bearer {{\Session::get('jwt_token')}}'},
						timeout: 600000,
						success: function handleSuccess(data1){
							console.log(data1);
							if(data1.success===true)
							{
								//alert(33);
								if(data1.status==0)
								{
									var ky0 = '#statusDiv'+ y;
									var ky1 = '#tag'+ y;
									var ky2 = '#sna'+ y;
									var ky3 = '#snb'+ y;
									var ky4 = '#snc'+ y;
									var ky5 = '#snd'+ y;
									var ky6 = '#msg'+ y;
									$(ky0).html("<small><b>Successful</b></small>");
									$(ky0).css("background-color", "#45d949");
									$(ky2).css("font-weight", "bold !important");
									$(ky3).css("font-weight", "bold !important");
									$(ky4).css("font-weight", "bold !important");
									$(ky5).css("font-weight", "bold !important");
									$(ky6).html("");


									var tag = $(ky1);
									$('html,body').animate({scrollTop: tag.offset().top},'slow');
								}
								else
								{
									//toastr.error(data1.message);
									var ky0 = '#statusDiv'+ y;
									var ky1 = '#tag'+ y;
									var ky6 = '#msg'+ y;
									$(ky0).html("<small><b>Failed</b></small>");
									$(ky0).css("background-color", "#eb4034");
									$(ky6).html(data1.message2);
									var tag = $(ky1);
									$('html,body').animate({scrollTop: tag.offset().top},'slow');
								}
								//toastr.success(data1.message);
							}
							else
							{
								var ky0 = '#statusDiv'+ y;
								var ky1 = '#tag'+ y;
								var ky6 = '#msg'+ y;
								var tag = $(ky1);
								$(ky0).html("<small><b>Failed</b></small>");
								$(ky0).css("background-color", "#eb4034");
								$(ky6).html(data1.message2);
								var tag = $(ky1);
								$('html,body').animate({scrollTop: tag.offset().top},'slow');
							}
						},
						error: function (e) {
							//toastr.error('We experienced an issue updating your merchant profile. Please try again.');
							var ky0 = '#statusDiv'+ y;
							var ky1 = '#tag'+ y;
							var ky6 = '#msg'+ y;
							$(ky0).html("<small><b>Failed</b></small>");
							$(ky0).css("background-color", "#eb4034");
							$(ky6).html("Card upload failure");
							var tag = $(ky1);
							$('html,body').animate({scrollTop: tag.offset().top},'slow');
									
						}
					});

				}
				
			}, 5000);
		} else {
		
		}		

		
	}
    </script>
@stop


