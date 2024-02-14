
<div aria-hidden="true" class="onboarding-modal modal fade animated" role="dialog" tabindex="-1" id="updateAcquirerView">
    <div class="modal-dialog modal-centered" role="document" style="top: 60px !important; width: 100% !important; max-width: 80% !important">
        <div class="modal-content text-center">
            <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span class="os-icon os-icon-close"></span></button>
            <table style="width: 100%;">
                <tr>
                    <td style="padding-left: 50px; text-align: right; padding-right: 20px;">
                        <a href="#" style="color: #261D1D; text-decoration: underline; font-size: 14px; letter-spacing: 1px;"></a><a href="#" style="color: #7C2121; text-decoration: underline; font-size: 14px; margin-left: 20px; letter-spacing: 1px;"></a>
                    </td>
                </tr>
            </table><img alt="" src="img/email-header-img.jpg" style="max-width: 100%; height: auto;">

            <div style="padding: 60px 70px;">
                    <h2 style="margin-top: 0px;">
                        Update Acquirer
                    </h2>
                    <div style="color: #636363; font-size: 14px;">
                        Provide details applicable to the acquirer
                    </div>




                    <table style="margin-top: 30px; width: 100%;">
                        <tr id="customerAccountNumberDiv" style="">
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Acquirer Name:<span style="color: red !important">*</span>
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" required id="acquirername" name="acquirername" placeholder="" type="text">
                                </div>

                            </td>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Acquirer Code:<span style="color: red !important">*</span>
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" required id="acquirercode" name="acquirercode" placeholder="" type="text">
                                </div>

                            </td>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Acquirer Bank:<span style="color: red !important">*</span>
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<select class="form-control" style="text-align: left !important" required id="bankid" name="bankid">
						@foreach($banks as $bank)
						<option value="{{$bank->id}}">{{$bank->bankName}}</option>
						@endforeach
					</select>
                                </div>

                            </td>
                            
                        </tr>

			    <tr>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Customer Funds Sit At Bank:
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<select class="form-control" style="text-align: left !important" id="holdfundsyes" name="holdfundsyes">
						<option value="1">Yes</option>
						<option value="0">No</option>
					</select>
                                </div>

                            </td>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Current Mode:
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<select class="form-control" style="text-align: left !important" id="islive" name="islive">
						<option value="1">Yes</option>
						<option value="0">No</option>
					</select>
                                </div>

                            </td>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Access Key:
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control acquireridnew" style="text-align: left !important" id="accessexodus" name="accessexodus" placeholder="" type="text">
					<div class="acquireridedit" style="padding: 10px !important"></div>
                                </div>

                            </td>
                            
                        </tr>

			    <tr>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Account Creation Endpoint (Live):
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="accountcreationendpoint" name="accountcreationendpoint" placeholder="" type="text">
                                </div>

                            </td>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Account Creation Endpoint (UAT):
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="accountcreationdemoendpoint" name="accountcreationdemoendpoint" placeholder="" type="text">
                                </div>

                            </td>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Funds Transfer Endpoint (Live):
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="fundstransferendpoint" name="fundstransferendpoint" placeholder="" type="text">
                                </div>

                            </td>
                            
                        </tr>

			    <tr>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Funds Transfer Endpoint (UAT):
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="fundstransferdemoendpoint" name="fundstransferdemoendpoint" placeholder="" type="text">
                                </div>

                            </td>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Balance Inquiry Endpoint (Live):
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="balanceinquiryendpoint" name="balanceinquiryendpoint" placeholder="" type="text">
                                </div>

                            </td>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Balance Inquiry Endpoint (UAT):
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="balanceinquirydemoendpoint" name="balanceinquirydemoendpoint" placeholder="" type="text">
                                </div>

                            </td>
                            
                        </tr>

			    <tr>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Auth Key (Live):
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="authkey" name="authkey" placeholder="" type="text">
                                </div>

                            </td>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Auth Key (UAT):
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="demoauthkey" name="demoauthkey" placeholder="" type="text">
                                </div>

                            </td>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Service Key (Live):
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="servicekey" name="servicekey" placeholder="" type="text">
                                </div>

                            </td>
                            
                        </tr>


			    <tr>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Service Key (UAT):
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="demoservicekey" name="demoservicekey" placeholder="" type="text">
                                </div>

                            </td>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Funds Transfer Auth Key (Live):
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="ftauthkey" name="ftauthkey" placeholder="" type="text">
                                </div>

                            </td>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Funds Transfer Auth Key (UAT):
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="ftdemoauthkey" name="ftdemoauthkey" placeholder="" type="text">
                                </div>

                            </td>
                            
                        </tr>


			    <tr>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Funds Transfer Service Key (Live):
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="ftservicekey" name="ftservicekey" placeholder="" type="text">
                                </div>

                            </td>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Funds Transfer Service Key (UAT):
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="ftdemoservicekey" name="ftdemoservicekey" placeholder="" type="text">
                                </div>

                            </td>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Funds Transfer Auth Key (Credit) (Live):
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="creditftauthkey" name="creditftauthkey" placeholder="" type="text">
                                </div>

                            </td>
                            
                        </tr>

			   <tr>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Funds Transfer Auth Key (Credit) (UAT):
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<input class="form-control" style="text-align: left !important" id="democreditftauthkey" name="democreditftauthkey" placeholder="" type="text">
                                </div>

                            </td>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Allowed Currencies:
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<!--<input class="form-control" style="text-align: left !important" id="allowedcurrency" name="allowedcurrency" placeholder="" type="text">-->
							   <select name="allowedcurrency[]" multiple id="allowedcurrency" class="form-control" required>
                                                        @foreach($all_currency as $key => $val)
                                                            <option value="{{$key}}">{{$val}}</option>
                                                        @endforeach
                                                    </select>
                                </div>

                            </td>
                            <td style="padding-right: 10px;">
                                <div style="text-align: left !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Default Merchant Scheme:
                                </div>
				    <div style="font-size: 12px; color: #111; font-weight: bold; margin-bottom: 20px;">
            				<select class="form-control" style="text-align: left !important" id="defaultmerchantschemeid" name="defaultmerchantschemeid">
						@foreach($all_merchant_schemes as $all_merchant_scheme)
						<option value="{{$all_merchant_scheme->id}}">{{$all_merchant_scheme->schemename}}</option>
						@endforeach
					</select>
                                </div>

                            </td>
                            
                        </tr>
                    </table>
          <div class="form-buttons-w">
              <button class="btn btn-primary" id="assignPhysicalCard" style="" type="submit" onclick="updateAcquirerDetails('{{\Auth::user()->token}}', '{{\Session::get('jwt_token')}}')"> Update Acquirer</button>
		<input type="hidden" name="acquirerid" id="acquirerid" value="">

          </div>

            </div>

            
        </div>
    </div>
</div>




