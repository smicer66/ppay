<div id="changeCardCVVWrapper" class="allfloater col col-md-6" style="padding-top:30px;display: none; background: rgba(0,0,0,0.55); top: 0%; position: fixed; z-index:10000; height:100%;width:100%">
	<!--<div id="yourdiv" style="display: inline-block;">You text</div>-->

	<div class="modal-content" class="col col-md-6" style="box-shadow: 0 2px 3px rgba(0,0,0,0.125); position:
absolute; height: 90%; left: 10%;  background-color: transparent; top:5%;opacity: 1 !important;
filter: alpha(opacity=100); width:80%; display:block;">
		<div class="modal-header" style="background-color: #000 !important; color: #fff !important">
			<button type="button" class="close" onclick="javascript:hidenewcard('changeCardCVVWrapper')" aria-label="Close">
				<span aria-hidden="true">×</span></button>
			<h4 class="modal-title" id="modal-title">Change Card CVV</h4>
		</div>
		<div class="modal-body" style="background-color: #fff !important; height:80% !important; overflow-y: scroll">
			<!--<form class="form-horizontal" autocomplete="off" action="/bank-teller/customers/new-customer" method="post" enctype="application/x-www-form-urlencoded">-->
			<input type="hidden" name="account" value="" id="account">
			<div id="notifymsg" style="padding:3px;"></div>
			<div class="box-body">
				<label for="inputEmail3" class="col-sm-6 control-label" style="padding-left: 0px !important"><strong>Customer Name:</strong> <div id="changeCardCVVCustomerName" class="" style="font-weight: 100 !important;"></div></label>
				
				<label for="inputEmail3" class="col-sm-6 control-label pull-right" style="text-align:right !important; padding-left: 0px !important"><strong>Account Number:</strong> <div id="changeCardCVVAccountNumber" class="" style="font-weight: 100 !important;"></div></label>
				
				<div class="col-sm-12" style="padding-left: 0px !important">
					<hr>
					<h4 style="font-weight: bold; text-decoration: underline">Card Details</h4>
                    <div class="form-group col-md-5" id="cardTypeNewCardDiv" style="padding-left: 0px !important">
                        <label for="inputEmail3" class="col-sm-5 control-label" style="padding-left: 0px !important">Card Pan:</label>

                        <div class="col-sm-6" id="changeCardCVVCardPan">
                            
                        </div>
                    </div>
					<div class="form-group col-md-5 pull-right" id="nameOnNewCardDiv" style="padding-right: 0px !important">
                        <label for="inputEmail3" class="col-sm-5 control-label">Type Of Card:</label>

                        <div class="col-sm-6 pull-right" style="padding-right: 0px !important" id="changeCardCVVCardType">
                            
                        </div>
                    </div>
                    <div class="form-group col-md-5" id="cardSchemeNewCardDiv" style="padding-left: 0px !important">
                        <label for="inputEmail3" class="col-sm-5 control-label" style="padding-left: 0px !important">Card Scheme:</label>

                        <div class="col-sm-6" id="changeCardCVVCardScheme">
						
                        </div>
                    </div>
					<div class="form-group col-md-5 pull-right" id="nameOnNewCardDiv" style="padding-right: 0px !important">
                        <label for="inputEmail3" class="col-sm-5 control-label">Card Serial No:</label>

                        <div class="col-sm-6 pull-right" style="padding-right: 0px !important" id="changeCardCVVCardSerialNo">
                            
                        </div>
                    </div>
					<div class="form-group col-md-12" id="changecvvdiv" style="padding: 0px !important">
					
					</div>
					
				</div>
			</div>
			<!-- /.box-body -->
			<!-- /.box-footer -->

		</div>
		<div class="modal-footer" style="background-color: #000 !important; color: #fff !important">
			<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
			<input type="hidden" name="aid" id="aid" value="">
			<a style="cursor:hand" class="btn btn-success" id="changeCardCVVSubmit">Send OTP to Verify CVV Change</a>
		</div>
	</div>

</div>