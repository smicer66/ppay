<div id="customerCardWrapper" class="allfloater col col-md-6" style="padding-top:30px;display: none; background: rgba(0,0,0,0.55); top: 0%; position: fixed; z-index:10000; height:100%;width:100%">
	<!--<div id="yourdiv" style="display: inline-block;">You text</div>-->

	<div class="modal-content" class="col col-md-6" style="box-shadow: 0 2px 3px rgba(0,0,0,0.125); position:
absolute; height: 90%; left: 5%;  background-color: transparent; top:5%;opacity: 1 !important;
filter: alpha(opacity=100); width:90%; display:block;">
		<div class="modal-header" style="background-color: #000 !important; color: #fff !important">
			<button type="button" class="close" onclick="javascript:hidenewcard('customerCardWrapper')" aria-label="Close">
				<span aria-hidden="true">×</span></button>
			<h4 class="modal-title" id="modal-title">Cards Mapped To Customer<span id="cardCustomerAccountNo"></span></h4>
		</div>
		<div class="modal-body" style="background-color: #fff !important; height:80% !important; overflow-y: scroll">
			<!--<form class="form-horizontal" autocomplete="off" action="/bank-teller/customers/new-customer" method="post" enctype="application/x-www-form-urlencoded">-->
			<input type="hidden" name="account" value="" id="account">
			<div id="notifymsg" style="padding:3px;"></div>
			<div class="box-body">
				<label for="inputEmail3" class="col-sm-6 control-label" style="padding-left: 0px !important"><strong>Customer Name:</strong> <div id="cardCustomerName" class=""></div></label>
				
				<label for="inputEmail3" class="col-sm-6 control-label" style="padding-left: 0px !important"><strong>Customer Verification Number:</strong> <div id="cardCustomerverficationnumber" class=""></div></label>
				
				<div class="col-sm-12" style="padding-left: 0px !important">
					<hr>
					<table id="customercardtable" class="display" style="width:100%">
						<thead>
							<tr role="row">
								<th class="sorting_asc" tabindex="0" aria-controls="example2"
									rowspan="1" colspan="1" aria-sort="ascending"
									aria-label="Rendering engine: activate to sort column descending">Card Number</th>
								<th class="sorting" tabindex="0" aria-controls="example2"
									rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Full Name</th>
								<th class="sorting" tabindex="0" aria-controls="example2"
									rowspan="1" colspan="1"
									aria-label="Platform(s): activate to sort column ascending">Account Number</th>
								<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
									aria-label="CSS grade: activate to sort column ascending">Card Serial Number</th>
								<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
									aria-label="CSS grade: activate to sort column ascending">Card Scheme</th>
								<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
									aria-label="CSS grade: activate to sort column ascending">Card Type</th>
								<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
									aria-label="CSS grade: activate to sort column ascending">Status</th>
								<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
									aria-label="CSS grade: activate to sort column ascending">Action</th>
							</tr>
						</thead>
						
						<tbody>
							
						</tbody>
					</table>
				</div>
			</div>
			<!-- /.box-body -->
			<!-- /.box-footer -->

		</div>
		<div class="modal-footer" style="background-color: #000 !important; color: #fff !important">
			<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
			<input type="hidden" name="aid" id="aid" value="">
			<a style="cursor:hand" class="btn btn-success" id="customerCardsAddNewCard">Add Card</a>
		</div>
	</div>

</div>