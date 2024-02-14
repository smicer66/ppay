<div aria-hidden="true" class="onboarding-modal modal fade animated" id="transaction_modal" role="dialog" tabindex="-1">
	<div class="modal-dialog modal-lg modal-centered" role="document">
	<div class="modal-content text-center">
		<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span class="deviceDetails" class="close-label"></span><span class="os-icon os-icon-close"></span></button>
		<div class="onboarding-side-by-side">
            <div class="onboarding-content with-gradient col-md-12">
                <h4 style="text-align: left !important;" id="viewAccountCardsTitle">Transactions for Account - <span id="viewAccountCardsAccountNo"></span>
                </h4>

                <div class="table-responsive">
                    <table id="txntable" width="100%" class="table table-striped table-lightfont">
                        <thead>
                        <tr>
                            <!--<th>Account No</th>-->
                            <th>Transaction Date</th>
                            <th>Details</th>
                            <th>Service Type</th>
                            <th>Amount</th>
                            <th>Charges</th>
                            <th>Debit Txn</th>
                            <th>Status</th>
                            <th>&nbsp</th>
                        </tr>
                        </thead>
                        <!--<tfoot>
                        <tr>
                            <th>Transaction Date</th>
                            <th>Details</th>
                            <th>Service Type</th>
                            <th>Amount</th>
                            <th>Charges</th>
                            <th>Debit Txn</th>
                            <th>Status</th>
                            <th>&nbsp</th>
                        </tr>
                        </tfoot>-->
                        <tbody>

                        </tbody>
                    </table>
                </div>

            </div>
		</div>
	</div>
	</div>
</div>


@section('style')
<style>
.pendingstatus{
	background-color: #0d6efd !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.successstatus{
	background-color: #198754 !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.customer_canceledstatus, .failstatus{
	background-color: #dc3545 !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.request_rollbackstatus{
	background-color: #ffc107 !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.reversedstatus{
	background-color: #000000 !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.channelspan{
	background-color: #6c757d !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.paymentmodespan{
	background-color: #ff6600 !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
}

.currencymodespan{
	background-color: #9334eb !important;
	color: #fff !important;
	padding: 5px !important;
	border-radius: 3px !important;
} 
</style>
@stop

