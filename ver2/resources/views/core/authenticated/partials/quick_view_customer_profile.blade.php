<div id="customerProfileWrapper" class="allfloater col col-md-6" style="padding-top:30px;display: none; background: rgba(0,0,0,0.55); top: 0%; position: fixed; z-index:10000; height:100%;width:100%">
	<!--<div id="yourdiv" style="display: inline-block;">You text</div>-->

	<div class="modal-content" class="col col-md-6" style="box-shadow: 0 2px 3px rgba(0,0,0,0.125); position:
absolute; height: 90%; left: 5%;  background-color: transparent; top:5%;opacity: 1 !important;
filter: alpha(opacity=100); width:90%; display:block;">
		<div class="modal-header" style="background-color: #000 !important; color: #fff !important">
			<button type="button" class="close" onclick="javascript:hidenewcard('customerProfileWrapper')" aria-label="Close">
				<span aria-hidden="true">×</span></button>
			<h4 class="modal-title" id="modal-title">Customer Bio-Data</h4>
		</div>
		<div class="modal-body" style="background-color: #fff !important; height:80% !important; overflow-y: scroll">
			<!--<form class="form-horizontal" autocomplete="off" action="/bank-teller/customers/new-customer" method="post" enctype="application/x-www-form-urlencoded">-->
			<input type="hidden" name="account" value="" id="account">
			<div id="notifymsg" style="padding:3px;"></div>
			<div class="box-body">
				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-5 control-label">Full Name:</label>

					<div class="col-md-6" id="fullname">
						
					</div>
				</div>

				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-5 control-label">Gender:</label>

					<div class="col-md-6" id="gender">
						
					</div>
				</div>
				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-5 control-label">Address Line:</label>

					<div class="col-md-6" id="addressLine">
					
					</div>
				</div>
				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-5 control-label">Province & District:</label>

					<div class="col-sm-6" id="locationDistrict">

					</div>
				</div>
				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-5 control-label">Date Of Birth:</label>

					<div class="col-md-6" id="dateOfBirth">
						
					</div>
				</div>
				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-5 control-label">Contact Mobile No:</label>

					<div class="col-md-6" id="contactMobile">
						
					</div>
				</div>
				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-5 control-label">Alternative Mobile No:</label>

					<div class="col-md-6" id="altContactMobile">
						
					</div>
				</div>
				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-5 control-label">Contact Email Address:</label>

					<div class="col-md-6" id="contactEmail">
						
					</div>
				</div>
				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-5 control-label">Alternative Email Address:</label>

					<div class="col-md-6" id="altContactEmail">
						
					</div>
				</div>
				<div class="form-group  col-md-6">
					<label for="inputEmail3" class="col-sm-5 control-label">Verification Number:</label>

					<div class="col-md-6" id="verificationNumber">
						
					</div>
				</div>
			</div>
			<!-- /.box-body -->
			<!-- /.box-footer -->

		</div>
		<div class="modal-footer" style="background-color: #000 !important; color: #fff !important">
			<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
			<input type="hidden" name="aid" id="aid" value="">
			<a onclick="javascript:addMobileMoney()" style="cursor:hand" class="btn btn-success" id="clickActor">Update Profile</a>
		</div>
	</div>

</div>