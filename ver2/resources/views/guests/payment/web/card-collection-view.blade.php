<style>
input[type='number'] {
    -moz-appearance:textfield;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}
</style>
<div class="reserve-box mt-30">
	<h5>ProbasePay</h5>
	<div style="background-color: #fff !important;" class="col-md-12">
		<div class="row mt-10 mb-30">
			@include('errors.errors-jq')
			<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1">
				
				<div class="submite-list-wrapper">
				
					<div class="row">
			
						<div class="col-md-12">
						
							<div class="">
								<h4 style="padding-bottom: 0px !important; margin-bottom:0px !important"><span><strong>{{isset($input['currency']) ? $input['currency'] : "ZMW"}}{{number_format($totalAmount, 2, '.', ',')}}</strong></span></h4>
								<label style="font-weight: 100 !important; font-size: 12px"><strong>Order Id:</strong> {{$input['orderId']}}</label>
							
							</div>
						
						</div>
						
					</div>
					
					<div class="submite-list-box">
						<form action="/payments/process-web-eagle-go-to-otp" method="post" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="data" value="{{$data}}">
                            <input type="hidden" name="tempHolder" value="{{\Crypt::encrypt($tempHolder->id)}}">
							<div class="row">
							
								<div class="col-xs-12 col-sm-12 mb-30-xs">
								
									<div class="row gap-20">
									
										
										<div class="col-xs-12 col-sm-12 col-md-12">
										
											<div class="form-group" style="padding-top:10px !important">
												<label style="font-weight: 100 !important">Card Number</label>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
													<input type="number" maxlength="16" size="16" name="cardnum" required class="form-control" style="
													   opacity: .8;
													   cursor: text;
													   -webkit-transition: all ease-out 120ms;
													   -o-transition: all ease-out 120ms;
													   transition: all ease-out 120ms;
													   z-index: 50000;" placeholder="01234567890123456"/>
												</div>
											</div>
											
										</div>
										
										<div class="col-xs-12 col-sm-12 col-md-12">
										
											<div class="form-group col col-md-6" style="padding-left:0px !important">
												<label style="font-weight: 100 !important">Expiry (MM/YY)</label>
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
													<input type="text" maxlength="5" name="expdate" required class="form-control col col-md-6" placeholder="MM/YY" />
												</div>
											</div>
											
										
											<div class="form-group col col-md-6" style="padding-right:0px !important">
												<label style="font-weight: 100 !important">CVV</label>
												
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
													<input type="number" maxlength="5" name="cvv" required class="form-control col col-md-6" style="
													   opacity: .8;
													   cursor: text;
													   -webkit-transition: all ease-out 120ms;
													   -o-transition: all ease-out 120ms;
													   transition: all ease-out 120ms;
													   z-index: 50000;" placeholder="CVV" />
												</div>
											</div>
											
										</div>
										
										<div class="col-xs-12 col-sm-12">
										
											<!--<div class="checkbox-block font-icon-checkbox">
												<input id="reserve_accept-1" name="reserve_accept" type="checkbox" class="checkbox" />
												<label class="" for="reserve_accept-1">Yes, I want to receive marketing email messages from this restuarant.</label>
											</div>
											
											<div class="checkbox-block font-icon-checkbox">
												<input id="reserve_accept-2" name="reserve_accept" type="checkbox" class="checkbox" />
												<label class="" for="reserve_accept-2">Repulsive questions contented him few extensive supported.</label>
											</div>-->
											
											<button class="btn btn-success col-md-12 mt-15" name="submitButton" value="Pay">Pay Now</button>
											<a href="javascript:history.back(-2)" class="btn btn-danger col-md-12 mt-15">Cancel Payment</a>
										
										</div>
										
									</div>

								</div>
								
							</div>
						</form>
					</div>

				</div>
				
			</div>

		</div>
	</div>
</div>