@extends('core.authenticated.layout.layout')
@section('title')  ProbasePay | Card Scheme Profile @stop

@section('content')

@include('partials.errors')
        <!-- Info boxes -->


<div class="content-box">
	<div class="element-wrapper">
		<div class="element-box">
			<div>
				<div class="steps-w">
					<div class="step-triggers">
						@if(isset($id) && $id!=NULL)
                            <h3 class="box-title">Update Card Scheme</h3>
                        @else
                            <h3 class="box-title">New Card Scheme</h3>
                        @endif
					</div>
					<div class="step-contents">
						<div class="step-content active" id="stepContent1">
							<form action id="newCardSchemeForm" data-toggle="validator">
                                @if(isset($id) && !is_null($id))
                                <input type="hidden" name="cardSchemeId" value="{{$id}}">
                                @endif
								<div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="schemeName">Scheme Name<span style="color:red !important">*</span></label>
                                            <input class="form-control" value="{{isset($cardScheme) && $cardScheme!=NULL ? $cardScheme->schemeName : ""}}" id="schemeName" name="schemeName" placeholder="Provide Unique Scheme Name" type="text">
                                        </div>
                                    </div>
                                </div>
								<div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="fixedFee">Fixed Fee<span style="color:red !important">*</span> <small>Charge per transaction)</small></label>
                                            <input class="form-control" value="{{isset($cardScheme) && $cardScheme!=NULL && isset($cardScheme->overrideFixedFee) ? $cardScheme->overrideFixedFee : ""}}" id="fixedFee" name="fixedFee" placeholder="Provide Fixed Fee" type="text">
                                        </div>
                                    </div>
                                </div>
								<div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="transactionFee">Transaction Fee (%)<span style="color:red !important">*</span> <small>(% of each transaction for cards on this scheme)</small></label>
                                            <input class="form-control" id="transactionFee" value="{{isset($cardScheme) && $cardScheme!=NULL && isset($cardScheme->overrideTransactionFee) ? $cardScheme->overrideTransactionFee : ""}}" name="transactionFee" placeholder="Provide Transaction Fee" type="text">

								        </div>
                                    </div>
                                </div>
								<div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="minimumBalance">Minimum Balance<span style="color:red !important">*</span> <small></small></label>
                                            <input class="form-control" id="minimumBalance" value="{{isset($cardScheme) && $cardScheme!=NULL && isset($cardScheme->minimumBalance) ? $cardScheme->minimumBalance : ""}}" name="minimumBalance" placeholder="Provide Transaction Fee" type="text">

								        </div>
                                    </div>
                                </div>
								<div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="minimumBalance">Currency<span style="color:red !important">*</span> <small></small></label>
                                            <select class="form-control" id="currency" name="currency">
                                                <option value="ZMW">Zambian Kwacha</option>
                                                <option value="TZS">Tanzanian Shilling</option>
                                            </select>

								        </div>
                                    </div>
                                </div>

								<div class="form-buttons-w text-right devicebtns">

                                    @if(isset($id) && $id!=NULL)
                                        <a class="btn btn-primary col-md-1 step-trigger-btn" id="btn3" style="display: block !important" onclick="createNewCardScheme('{{\Session::get('jwt_token')}}')" > Save</a>
                                    @else
                                        <a class="btn btn-primary col-md-1 step-trigger-btn" id="btn3" style="display: block !important" onclick="createNewCardScheme('{{\Session::get('jwt_token')}}')" > Create</a>
                                    @endif
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>



@stop
@section('section_title') {{isset($cardScheme) && $cardScheme!=NULL ? "Update" : "New"}} Card Scheme Profile @stop
@section('scripts')

<script>
$('.devicebtns').show();


$(function(e){
    @if(isset($id) && $id!=null)
    getNewCardScheme('{{\Session::get('jwt_token')}}', {{$id}});
    @endif
});

function createNewCardScheme(jwtToken)
{
    jwtToken = 'Bearer ' + jwtToken;
    console.log(jwtToken);
    var form = $('#newCardSchemeForm')[0];
    var formData = new FormData(form);
    var url = '/api/ecards/new-card-scheme';
    console.log(formData);
    $.ajax({
        type: "POST",
        url: (url),
        data: (formData),
        processData: false,
        contentType: false,
        cache: false,
        headers: {"Authorization": jwtToken},
        timeout: 600000,
        success: function handleSuccess(data1){
            console.log(data1);
            if(data1.success===true)
            {
                //alert(33);
                toastr.success(data1.message);
                window.location = '/potzr-staff/ecards/card-scheme-listing';
            }
            else if(data1.success===-1)
            {
                logoutUser('Your session has ended. Please log in to continue', window.location.href);
            }
            else if(data1.success===false)
            {
                toastr.error(data1.message);
            }
        },
        error: function (e) {
            console.log(e);
            toastr.error('We experienced an issue creating/updating your card scheme. Please try again.');
        }
    });
}



function currencyList()
{
    return ['ZMW', 'TWS'];
}

function getNewCardScheme(jwtToken, id)
{
    jwtToken = 'Bearer ' + jwtToken;
    console.log(jwtToken);
    var form = $('#newCardSchemeForm')[0];
    var formData = new FormData(form);
    var url = '/api/ecards/get-card-scheme/' + id;
    console.log(formData);
    $.ajax({
        type: "GET",
        url: (url),
        data: (formData),
        processData: false,
        contentType: false,
        cache: false,
        headers: {"Authorization": jwtToken},
        timeout: 600000,
        success: function handleSuccess(data1){
            console.log(data1);
            if(data1.success===true)
            {
                //alert(33);
                $('#cardSchemeId').val(data1.cardScheme.id);
                $('#schemeName').val(data1.cardScheme.schemeName);
                $('#schemeName').val(data1.cardScheme.schemeName);
                $('#fixedFee').val(data1.cardScheme.overrideFixedFee);
                $('#transactionFee').val(data1.cardScheme.overrideTransactionFee);
                $('#minimumBalance').val(data1.cardScheme.minimumBalance);
                $('#currency').val(currencyList()[data1.cardScheme.currency]);
                //window.location = '/potzr-staff/ecards/card-scheme-listing';
            }
            else if(data1.success===-1)
            {
                logoutUser('Your session has ended. Please log in to continue', window.location.href);
            }
            else if(data1.success===false)
            {
                toastr.error(data1.message);
            }
        },
        error: function (e) {
            console.log(e);
            toastr.error('We experienced an issue creating/updating your card scheme. Please try again.');
        }
    });
}
</script>
@stop
