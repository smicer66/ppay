
<div aria-hidden="true" class="onboarding-modal modal fade animated" id="fund_agent_modal" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-lg modal-centered" role="document">
	<div class="modal-content text-center">
		<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span class="deviceDetails" class="close-label"></span><span class="os-icon os-icon-close"></span></button>
		<div class="onboarding-side-by-side">
		<div class="onboarding-content with-gradient col-md-12">
			<h4 class="onboarding-title">
			Fund Agent - <span class="deviceDetails" id="agentNameId"></span>
			</h4>
			<div class="onboarding-text" style="color: #000 !important;">
				
			</div>





			<form action="/accountant/agents/fund-agent" method="post">
				<input type="hidden" name="fundAgentAgentId" id="fundAgentAgentId" value="">
				<center>
				    <div style="color: #636363; font-size: 14px;">
                        		Provide the details below to create a new collections account
		                  </div>
				    <div style="text-align: center !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Enter Amount:
                                </div>
				    <div style="text-align: center !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 20%">
            				<input class="form-control" data-minlength="1" id="fundAgentAmount" style="text-align: center !important" name="fundAgentAmount" placeholder="" required="required" type="number">
                                </div>
				    <div style="text-align: center !important; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; font-weight: bold; color: #000; margin-bottom: 5px;">
                                    Enter Bank Reference Number:
                                </div>
				    <div style="text-align: center !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 20%">
            				<input class="form-control" data-minlength="1" id="bankTransactionRef" style="text-align: center !important" name="bankTransactionRef" placeholder="" required="required" type="text">
                                </div>
				    <div style="text-align: center !important; font-size: 14px; color: #111; font-weight: normal; margin-bottom: 20px; width: 20%">
            				<input class="btn btn-success btn-lg" id="" style="text-align: center !important" value="Fund Agent" type="submit">
                                </div>
				</center>
			</form>
		</div>
		</div> 
	</div>
	</div>
</div>