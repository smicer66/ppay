


function hidenewcard(div){$("#" + div).fadeOut();document.getElementById('notifymsg').innerHTML=""}




var loadingOverlay = document.querySelector('.loading');
var loginToPayLinkCount = 0;

function toggleLoading(){
  document.activeElement.blur();
  
  if (loadingOverlay.classList.contains('hidden')){
    loadingOverlay.classList.remove('hidden');
  } else {
    loadingOverlay.classList.add('hidden');
  }
}




function addANewCardSubmit(formId, jwtToken)
{
	console.log(jwtToken);
	jwtToken = 'Bearer ' + jwtToken;
	var form = $('#' + formId)[0];
	if (($('#' + formId).validator('validate').has('.has-error').length)) {
		toastr.error("Provide all required information before submitting");
	} else {
		var formData = new FormData();
		formData.append("customerVerificationNo", $('#customerVerificationNo').val());
		formData.append("acquirerId", $('#acquirerIdNewCard').val());
		formData.append("newWalletCardScheme", $('#newCardCardScheme').val());
		formData.append("currencyCodeId", $('#currencyCodeNewCard').val());
		formData.append("nameOnCard", $('#newCardCardHolder').val());

		formData.append("accountIdentifier", $('#accountIdentifierNewCard').val());
		formData.append("newWalletCardType", $('#newCardCardType').val());
		formData.append("deviceCode", $('#newCardDeviceCode').val());
		formData.append("merchantId", $('#newCardMerchantId').val());




		var url = '/api/new-account-card';
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
					if(data1.status==100)
					{
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.message);
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}

}


function addNewCustomerAccount(jwtToken)
{
	console.log(jwtToken);
	jwtToken = 'Bearer ' + jwtToken;
	var form = $('#new_account_step_1')[0];
	if (($('#new_account_step_1').validator('validate').has('.has-error').length)) {
		//alert('SOMETHING WRONG');
		toastr.error("Provide all required information before submitting");
	} else {
		var formData = new FormData(form);
		var url = '/api/accounts/add-new-account';
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
					if(data1.status==100)
					{
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.message);
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}
	
}


function loadAddNewCardView(accountIdentifier, firstName, lastName, verificationNumber)
{

	$('#accountNumber').html(accountIdentifier);
	$('#newCardAccoutName').html(firstName + ' ' + lastName);
	$('#newCardCardHolder').val(firstName + ' ' + lastName);
	$('#customerVerificationNumber').val(verificationNumber);
}



function loadTransactionModalView(jwtToken, accountIdentifier, firstName, lastName, verificationNumber, accountId)
{
	$.ajax({
		type: "GET",
		url: "/api/transactions/get-transaction-list-ajax?debitAccountId=" + accountId + "&creditAccountId="+accountId + "&index=0&count=5",
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": 'Bearer ' + jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status!=undefined)
			{
				$('#txntable').DataTable().destroy();
				$('#txntable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.list,
					"columns": [
						//{ "data": "accountNo" },
						{ "data": "transactionDate" },
						{ "data": "detail" },
						{ "data": "serviceType" },
						{ "data": "amount" },
						{ "data": "totalCharges" },
						{ "data": "debitAccountTrue" },
						{ "data": "status" },
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error("We are experiencing a few issues getting your list of customers");
		}
	});

}


function viewCustomerList(jwtToken)
{
	$.ajax({
		type: "GET",
		url: "/api/get-customer-list-ajax",
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==undefined)
			{
				$('#customerTableList').DataTable().destroy();
				$('#customerTableList').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.data,
					"columns": [
						{ "data": "full_name" },
						{ "data": "customerType" },
						{ "data": "verificationNumber" },
						{ "data": "contactMobile" },
						{ "data": "contactEmail" },
						{ "data": "status" },
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error("We are experiencing a few issues getting your list of customers");
		}
	});
}



$('.os-icon-close').on('click', function(){

	//$('.onboarding-modal').hide();
	//document.querySelector("p").closest(".near.ancestor")
	$(this).closest('.onboarding-modal').hide();
});


function showLastFiveTransactions(bankName, bankId, jwtToken)
{
	console.log("jwtToken");
	console.log(jwtToken);
	$.ajax({
		type: "GET",
		url: "/api/transactions/get-transaction-list-ajax?bankId=" + bankId,
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": 'Bearer ' + jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==undefined)
			{
				$('#customerTableList').DataTable().destroy();
				$('#customerTableList').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.data,
					"columns": [
						{ "data": "full_name" },
						{ "data": "customerType" },
						{ "data": "verificationNumber" },
						{ "data": "contactMobile" },
						{ "data": "contactEmail" },
						{ "data": "status" },
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error("We are experiencing a few issues getting your list of customers");
		}
	});
}




$('#addCardToAccount').on('change', function(){
	if($('#addCardToAccount').val()=='Yes')
	{
		$('#nameOnCardDiv').show();
		$('#cardSchemeDiv').show();
		$('#extraOptionsDiv').show();	
		$('#cardTypeDiv').show();		
	}
	else if($('#addCardToAccount').val()=='No')
	{
		$('#nameOnCardDiv').hide();
		$('#cardSchemeDiv').hide();
		$('#extraOptionsDiv').hide();
		$('#cardTypeDiv').hide();
		
	}
});


$('#customerNewCardAccount').on('change', function(){
	$('#cardfundingfromcustomerdiv').hide();
	$('#customerAddNewCardToAccount').hide();
	$.ajax({
		type: "GET",
		url: "/get-account-balance-ajax/" + $('#customerNewCardAccount').val(),
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status!=undefined && data.status==100)
			{
				$('#customerNewCardFundAmount').attr('data-maxAmt', data.floatingBalance);
				$('#customerNewCardFundAmount').attr('data-minAmt', 0.00);
				$('#cardfundingfromcustomerdiv').show();
				$('#customerNewCardFloatingBalance').html(data.accountCurrency + "" + data.floatingBalance);
				$('#customerAddNewCardToAccount').show();
			}
			else
			{
				$('#customerAddNewCardToAccount').hide();
				$('#cardfundingfromcustomerdiv').hide();
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
});





function viewIssuePhysicalCard(currentCardId, cardOwner, nameOnCard, accountIdentifier, schemeName, jwtToken)
{
	//nameOnCard = decodeURIComponent(nameOnCard);
	//cardOwner = decodeURIComponent(cardOwner);
	console.log(currentCardId);
	console.log(cardOwner);
	console.log(accountIdentifier);
	console.log(nameOnCard);
	console.log(schemeName);
	$("#issuePhysicalCardOwnerName").html(cardOwner);
	$("#issuePhysicalCardNameOnCard").html(nameOnCard);
	$("#issuePhysicalCardAccountIdentifier").html(accountIdentifier);
	$("#issuePhysicalCardSchemeName").html(schemeName);
	$(".allfloater").fadeOut();
	$("#issuePhysicalCardWrapper").fadeIn();
	$('#issuePhysicalCardId').val(currentCardId);
	

		var url = '/api/cards/get-card-batches';
		var formData = new FormData();
		$.ajax({
			type: "POST",
			url: (url),
			data: (formData),
			processData: false,
			contentType: false,
			cache: false,
			headers: {"Authorization": 'Bearer ' + jwtToken},
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				//if(data1.success===true)
				//{
					//alert(33);
					if(data1.status==100)
					{
						/**/var $dropdown = $('#issuePhysicalCardCardBatch');


						for(var i1=0; i1<data1.cardBatches.cardBatches.length; i1++)
						{
							console.log(data1.cardBatches.cardBatches[i1]);
							if(data1.cardBatches.cardBatches[i1].cardBatchCode!=undefined && data1.cardBatches.cardBatches[i1].cardBatchCode.length>0)
							{
	    							$dropdown.append($("<option />").val(data1.cardBatches.cardBatches[i1].cardBatchCode).text(data1.cardBatches.cardBatches[i1].cardBatchCode.match(/.{1,4}/g).join('-')));
							}
						}
						
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.message);
					}
					//toastr.success(data1.message);
				//}
				//else
				//{
				//		toastr.error(data1.message);
				//		$('#dismissBtn').click();
				//		$('#new_card_modal').show();
					
				//}
			},
			error: function (e) {
				toastr.error('We experienced an issue issuing this customer a card.');
			}
		});
	
}





function viewChangeCardPin(currentCardId, accountIdentifier, full_name, cardType, schemeName, serialNo, cardPan, trackingNo)
{
	console.log(currentCardId);
	console.log(full_name);
	console.log(accountIdentifier);
	console.log(cardType);
	console.log(schemeName);
	console.log(serialNo);
	$('#changeCardPinCardPan').html(cardPan);
	$('#changeCardPinCardType').html(cardType);
	$('#changeCardPinCardScheme').html(schemeName);
	$('#changeCardPinCustomerName').html(full_name);
	$('#changeCardPinAccountNumber').html(accountIdentifier);
	$('#changeCardPinCardSerialNo').html(serialNo);
	$(".allfloater").fadeOut();
	$("#changeCardPinWrapper").fadeIn();
	$('#cardTrackingNoCardPin').val(trackingNo);
	$('#cardSerialNoCardPin').val(serialNo);
	
	
}

function changeCardPin(jwtToken, sessionToken, deviceCode)
{
		//var form = $('#vbsettingsform')[0];
		//var formData = new FormData(form);
		var url = '/api/cards/change-card-pin';
		var data_ = [];
		data_['deviceCode'] = deviceCode;
		data_['serialNo'] = $('#cardSerialNoCardPin').val();
		data_['trackingNo'] = $('#cardTrackingNoCardPin').val();
		console.log(data_);
		var formData = new FormData();
		formData.append('deviceCode', deviceCode);
		formData.append('token', sessionToken);
		formData.append('serialNo', $('#cardSerialNoCardPin').val());
		formData.append('trackingNo', $('#cardTrackingNoCardPin').val());

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
					if(data1.status==100)
					{
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.message);
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
}




function confirmCardAssign(jwtToken, sessionToken, deviceCode)
{
		//var form = $('#vbsettingsform')[0];
		//var formData = new FormData(form);
		var url = '/api/cards/confirm-card-issue';
		var data_ = [];
		data_['deviceCode'] = deviceCode;
		data_['cardNumber'] = $('#issuePhysicalCardCardNumber').val();
		data_['trackingNo'] = $('#cardTrackingNoCardPin').val();
		console.log(data_);
		var formData = new FormData();
		formData.append('deviceCode', deviceCode);
		formData.append('token', sessionToken);
		formData.append('requestId', $('#issuePhysicalCardId').val());
		formData.append('cardNumber', $('#issuePhysicalCardCardNumber').val());

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
					if(data1.status==100)
					{
						$('#dismissBtn').click();
						toastr.success('Card issued successfully to customer');
						window.location = '/potzr-staff/ecards/card-request-listing';
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.message);
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
}

function viewChangeCardCVV(currentCardId, accountIdentifier, full_name, cardType, schemeName, serialNo, cardPan)
{
	console.log(currentCardId);
	console.log(full_name);
	console.log(accountIdentifier);
	console.log(cardType);
	console.log(schemeName);
	console.log(serialNo);
	$('#changeCardCVVCardPan').html(cardPan);
	$('#changeCardCVVCardType').html(cardType);
	$('#changeCardCVVCardScheme').html(schemeName);
	$('#changeCardCVVCustomerName').html(full_name);
	$('#changeCardCVVAccountNumber').html(accountIdentifier);
	$('#changeCardCVVCardSerialNo').html(serialNo);
	
	$('#changeCardCVVSubmit').on('click', function(){
		handleSubmitChangeCardCVVStepOne(currentCardId);
	});
}



function handleSubmitChangeCardPinStepOne(currentCardId)
{
	//SEND OTP to Card Holder
	//var html = '<div class="form-group col-md-5" style="padding-left: 0px !important" id="">';
	//	html = html + '<label for="inputEmail3" class="col-sm-5 control-label" style="padding-left: 0px !important">Provide OTP:</label>';
	//	html = html + '<div class="col-sm-6" style="padding-right: 0px !important">';
	//		html = html + '<input type="number" class="form-control" name="otpChangePin" id="otpChangePin" placeholder="Enter OTP">';
	//	html = html + '</div>';
	//html = html + '</div>';
	//html = html + '<div class="form-group col-md-5" style="clear: both !important; padding-left: 0px !important" id="">';
	//	html = html + '<label for="inputEmail3" class="col-sm-5 control-label" style="padding-left: 0px !important">New Card Pin:</label>';
	//	html = html + '<div class="col-sm-6" style="padding-right: 0px !important">';
	//		html = html + '<input type="password" class="form-control" name="changeCardPinNewPin" id="changeCardPinNewPin" placeholder="Enter Pin">';
	//	html = html + '</div>';
	//html = html + '</div>';
	//html = html + '<div class="form-group col-md-5 pull-right" style="padding-right: 0px !important" id="">';
	//	html = html + '<label for="inputEmail3" class="col-sm-5 control-label" style="padding-right: 0px !important">Confirm Card Pin:</label>';
	//	html = html + '<div class="col-sm-6" style="padding-right: 0px !important">';
	//		html = html + '<input type="password" class="form-control pull-right" name="changeCardPinConfirmNewPin" id="changeCardPinConfirmNewPin" placeholder="Re-Enter Pin">';
	//	html = html + '</div>';
	//html = html + '</div>';
	//$('#changepindiv').html(html);
	//$('#changeCardPinSubmit').html("Verify OTP & Change Pin");
	//$('#changeCardPinSubmit').on('click', function(){
	//	
	//	handleSubmitChangeCardPinStepTwo(currentCardId, $('#changeCardPinNewPin').val(), $('#changeCardPinConfirmNewPin').val());
	//});
}


function handleSubmitChangeCardPinStepTwo(currentCardId, changeCardPinNewPin, changeCardPinConfirmNewPin)
{
	
}

function handleSubmitChangeCardCVVStepOne(currentCardId)
{
	//SEND OTP to Card Holder
	var html = '<div class="form-group col-md-5" style="padding-left: 0px !important" id="">';
		html = html + '<label for="inputEmail3" class="col-sm-5 control-label" style="padding-left: 0px !important">Provide OTP:</label>';
		html = html + '<div class="col-sm-6" style="padding-right: 0px !important">';
			html = html + '<input type="number" class="form-control" name="otpChangeCVV" id="otpChangeCVV" placeholder="Enter OTP">';
		html = html + '</div>';
	html = html + '</div>';
	html = html + '<div class="form-group col-md-5" style="clear: both !important; padding-left: 0px !important" id="">';
		html = html + '<label for="inputEmail3" class="col-sm-5 control-label" style="padding-left: 0px !important">New Card CVV:</label>';
		html = html + '<div class="col-sm-6" style="padding-right: 0px !important">';
			html = html + '<input type="password" class="form-control" name="changeCardCVVNewCVV" id="changeCardPinNewCVV" placeholder="Enter CVV">';
		html = html + '</div>';
	html = html + '</div>';
	html = html + '<div class="form-group col-md-5 pull-right" style="padding-right: 0px !important" id="">';
		html = html + '<label for="inputEmail3" class="col-sm-5 control-label" style="padding-right: 0px !important">Confirm Card CVV:</label>';
		html = html + '<div class="col-sm-6" style="padding-right: 0px !important">';
			html = html + '<input type="password" class="form-control pull-right" name="changeCardCVVConfirmNewCVV" id="changeCardCVVConfirmNewCVV" placeholder="Re-Enter CVV">';
		html = html + '</div>';
	html = html + '</div>';
	$('#changecvvdiv').html(html);
	$('#changeCardCVVSubmit').html("Verify OTP & Change CVV");
	$('#changeCardCVVSubmit').on('click', function(){
		
		handleSubmitChangeCardCVVStepTwo(currentCardId, $('#changeCardCVVNewCVV').val(), $('#changeCardCVVConfirmNewCVV').val());
	});
}


function handleSubmitChangeCardCVVStepTwo(currentCardId, changeCardCVVNewCVV, changeCardCVVConfirmNewCVV)
{
	
}




function updateCardBearer(currentCardId, customerName, accountIdentifier, cardType, serialNo, cardPan, cardScheme, trackinNumber)
{
	console.log(currentCardId);
	console.log(customerName);
	console.log(accountIdentifier);
	console.log(cardType);
	console.log(serialNo);
	console.log(trackinNumber);
	document.getElementById('notifymsg').innerHTML = "";
	$('#updateCardBearerCardPan').html(cardPan);
	$('#updateCardBearerCardType').html(cardType);
	$('#updateCardBearerCardScheme').html(cardScheme);
	$('#updateCardBearerCustomerName').html(customerName);
	$('#updateCardBearerAccountNumber').html(accountIdentifier);
	$('#updateCardBearerCardSerialNo').html(serialNo);

	$('#cardTrackingNoupdateCardBearer').val(trackinNumber);
	$('#cardSerialNoupdateCardBearer').val(serialNo);

	$(".allfloater").fadeOut();
	$("#updateCardBearerWrapper").fadeIn();
	
	$('#updateCardBearerSubmit').on('click', function(){
		//$('#updateCardBearerSubmit').hide();
	});
}



function handleSubmitUpdateCardBearer(serverToken, jwtToken, deviceCode)
{
	var newWalletNumber = $('#updateCardBearerWalletNo').val();
	var newNameOnCard= $('#updateCardBearerNameOnCard').val();
	var cardTrackingNumber = $('#cardTrackingNoupdateCardBearer').val();
	var cardSerialNumber = $('#cardSerialNoupdateCardBearer').val();


	console.log(newWalletNumber);
	console.log(newNameOnCard);
	console.log(cardTrackingNumber);
	console.log(cardSerialNumber);


		var url = '/api/cards/update-card-bearer';
		var data_ = [];
		data_['deviceCode'] = deviceCode;
		data_['newWalletNumber'] = newWalletNumber;
		data_['newNameOnCard'] = newNameOnCard;
		data_['cardTrackingNumber'] = cardTrackingNumber;
		data_['cardSerialNumber'] = cardSerialNumber;
		console.log(data_);
		var formData = new FormData();
		formData.append('deviceCode', deviceCode);
		formData.append('token', serverToken);
		formData.append('newWalletNumber', newWalletNumber);
		formData.append('newNameOnCard', newNameOnCard);
		formData.append('cardTrackingNumber', cardTrackingNumber);
		formData.append('cardSerialNumber', cardSerialNumber);

		$.ajax({
			type: "POST",
			url: (url),
			data: (formData),
			processData: false,
			contentType: false,
			cache: false,
			headers: {"Authorization": 'Bearer ' + jwtToken},
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				console.log(data1.success);
				if(data1.success===true)
				{

					if(data1.status==1)
					{

						$('#dismissBtn').click();
						toastr.success('Ownership of the card has been updated successfully');
						window.location = '/potzr-staff/ecards/card-listing';
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{

						toastr.error(data1.message);
					}
					//toastr.success(data1.message);
				}
				else
				{

						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});

}




function transferCard(currentCardId, customerName, accountIdentifier, cardType, serialNo, cardPan, cardScheme)
{
	console.log(currentCardId);
	console.log(customerName);
	console.log(accountIdentifier);
	console.log(cardType);
	console.log(serialNo);
	document.getElementById('notifymsg').innerHTML = "";
	$('#transferCardCardPan').html(cardPan);
	$('#transferCardCardType').html(cardType);
	$('#transferCardCardScheme').html(cardScheme);
	$('#transferCardCustomerName').html(customerName);
	$('#transferCardAccountNumber').html(accountIdentifier);
	$('#transferCardCardSerialNo').html(serialNo);
	$(".allfloater").fadeOut();
	$("#transferCardWrapper").fadeIn();
	
	$('#transferCardSubmit').on('click', function(){
		handleSubmitCardTransfer(currentCardId, $('#transferCardTrackingNo').val());
	});
}


function handleSubmitCardTransfer(serverToken, jwtToken, deviceCode)
{
	alert("Not Yet Implemented");
}

function listCustomers()
{
	$('#example21').DataTable().destroy();
	$('#example21').DataTable({
		"ajax": "/get-customer-list-ajax",
		"columns": [
			{ "data": "full_name" },
			{ "data": "customerType" },
			{ "data": "verificationNumber" },
			{ "data": "contactMobile" },
			{ "data": "contactEmail" },
			{ "data": "status" },
			{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
		]
	});
}



function viewBatchCardList(jwtToken, deviceCode)
{
	var url = "/api/get-batch-cards-ajax?deviceCode=" + deviceCode;
	var dt = [];
	dt['deviceCode'] = deviceCode;
	$.ajax({
		type: "GET",
		url:  url,
		data: dt,
		processData: false,
		contentType: false,
		headers: {"Authorization": jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.success===true)
			{

				console.log(data.cardBatch);
				$('#cardbatchtable').DataTable().destroy();
				$('#cardbatchtable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.cardBatch,
					"columns": [
						{ "data": "card_batch_code" },
						{ "data": "card_no" },
						{ "data": "card_type" },
						{ "data": "tracking_number" },
						{ "data": "acquirer" },
						{ "data": "issuer" },
						{ "data": "status" },
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});
			}
			else
			{
				if(data.success==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}



function viewCustomerAccounts(jwtToken, table, customerId, customerName, customerverficationnumber) {
	var url = "/api/get-customer-account-list-ajax";
	console.log([table, jwtToken, customerId, customerName, customerverficationnumber]);
	if(customerId!=undefined && customerId!=null && customerName!=undefined && customerName!=null && customerverficationnumber!=undefined && customerverficationnumber!=null)
	{
		$('#customername').html(customerName);
		$('#customerverficationnumber').html(customerverficationnumber);
		url = url + '/' + customerId;
	}
	$.ajax({
		type: "GET",
		url:  url,
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": "Bearer " + jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==110)
			{
				console.log(data.customer);
				console.log(data.data);
				$('#'+table).DataTable().destroy();
				$('#'+table).DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.data,
					"columns": [
						{ "data": "customerName" },
						{ "data": "accountIdentifier" },
						{ "data": "accountType" },
						{ "data": "bankName" },
						{ "data": "currency" },
						{ "data": "status" },
						{ "data": "accountBalance", "class": 'text-right'},
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});
				if(data.customer!=undefined && data.customer!=null) {
					$('#customerAccountsCustomerName').html(data.customer.firstName + " " + data.customer.lastName + (data.customer.otherName != undefined && data.customer.otherName != null ? (" " + data.customer.otherName) : ""))
				}
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});

}



function viewAgents(jwtToken, table) {
	var url = "/api/get-agent-list-ajax";
	console.log([table, jwtToken]);
	
	$.ajax({
		type: "GET",
		url:  url,
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": "Bearer " + jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==5000)
			{
				console.log(data.agentlist);
				$('#'+table).DataTable().destroy();
				$('#'+table).DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.agentlist,
					"columns": [
						{ "data": "companyName" },
						{ "data": "agentCode" },
						{ "data": "deviceCode" },
						{ "data": "fullName" },
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});

			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});

}




function viewCorporateCustomerAccounts(jwtToken, table, customerId, customerName, customerverficationnumber) {
	var url = "/api/get-corporate-customer-account-list-ajax";
	console.log([table, jwtToken, customerId, customerName, customerverficationnumber]);
	if(customerId!=undefined && customerId!=null && customerName!=undefined && customerName!=null && customerverficationnumber!=undefined && customerverficationnumber!=null)
	{
		$('#customername').html(customerName);
		$('#customerverficationnumber').html(customerverficationnumber);
		url = url + '/' + customerId;
	}
	$.ajax({
		type: "GET",
		url:  url,
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": "Bearer " + jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==110)
			{
				console.log(data.customer);
				console.log(data.data);
				$('#'+table).DataTable().destroy();
				$('#'+table).DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.data,
					"columns": [
						{ "data": "customerName" },
						{ "data": "accountIdentifier" },
						{ "data": "accountType" },
						{ "data": "bankName" },
						{ "data": "currency" },
						{ "data": "status" },
						{ "data": "accountBalance", "class": 'text-right'},
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});
				if(data.customer!=undefined && data.customer!=null) {
					$('#customerAccountsCustomerName').html(data.customer.firstName + " " + data.customer.lastName + (data.customer.otherName != undefined && data.customer.otherName != null ? (" " + data.customer.otherName) : ""))
				}
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});

}




function handleNewCorporateAccount()
{
	$('#dismissBtn').click();
	$('#new_corporate_account_modal').show();
}


function viewCustomerCards(jwtToken, customerId, customerName, customerverficationnumber, tableId, deviceCode) {
	$('#viewAccountCardsAccountNo').html(customerName);
	$('#viewAccountCardsTitle').html('Cards Belonging to Customer - ' + customerName);
	console.log(tableId);
	$.ajax({
		type: "GET",
		url: "/api/get-customer-card-list-ajax/" + customerId + "?deviceCode=" + deviceCode,
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": "Bearer " + jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==210)
			{
				if ( $.fn.dataTable.isDataTable( '#'+tableId ) ) {
					table = $('#' + tableId).DataTable();
					table.destroy();
				}
				$('#' + tableId).DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.data,
					"columns": [
						{ "data": "pan" },
						{ "data": "full_name" },
						{ "data": "accountIdentifier" },
						{ "data": "serialNo" },
						{ "data": "schemeName" },
						{ "data": "cardType" },
						{ "data": "status" },
						{ "data": "cardBalance" },
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});

}

function viewCustomerProfile(jwtToken, customerId)
{
	$.ajax({
		type: "GET",
		url: "/api/get-customer-profile-ajax/" + customerId,
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": "Bearer " + jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{

				$('#customerProfileFullName').html(data.customer.lastName + " " + data.customer.firstName + " " + data.customer.otherName);
				$('#customerProfileGender').html(data.customer.gender);
				$('#customerProfileAddressLine').html(data.customer.addressLine1!=undefined && data.customer.addressLine1!="" ? (data.customer.addressLine1 + '<br>' + data.customer.addressLine2) : "N/A");
				$('#customerProfileLocationDistrict').html(data.customer.locationDistrict!=undefined && data.customer.locationDistrict!="" ? data.customer.locationDistrict : "N/A");
				$('#customerProfileDateOfBirth').html(data.customer.dateOfBirth!=undefined && data.customer.dateOfBirth!="" ? data.customer.dateOfBirth : 'N/A');
				$('#customerProfileContactMobile').html(data.customer.contactMobile);
				$('#customerProfileAltContactMobile').html(data.customer.altContactMobile!=undefined && data.customer.altContactMobile!="" ? data.customer.altContactMobile : 'N/A');
				$('#customerProfileContactEmail').html(data.customer.contactEmail);
				$('#customerProfileAltContactEmail').html(data.customer.altContactEmail!=undefined && data.customer.altContactEmail!="" ? data.customer.altContactEmail : 'N/A');
				$('#viewCustomerProfileCustomerNumber').html(data.customer.verificationNumber);
				$('#meansOfIdentificationNumber').html(data.customer.meansOfIdentificationNumber);
				$('#meansOfIdentificationType').html(data.customer.meansOfIdentificationType.replaceAll('_', ' '));

				$('#profilepix').html('<img src="/files/passports/' + data.customer.customerImage + '" height="180px" style="border-radius: 10px; border: 1px solid #000 !important;">');

				if(data.customer.meansOfIdentificationPhoto.length>0)
					$('#meansofidentificationpix').html('<img src="/files/passports/' + data.customer.meansOfIdentificationPhoto+ '" height="180px" style="border-radius: 10px; border: 1px solid #000 !important;">');
				else
					$('#meansofidentificationpix').html('N/A');

				
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});

}


function viewAccountBalance(accountId, accountNumber, customerName, customerverficationnumber)
{
	$('#notifymsg').html("");
	$(".allfloater").fadeOut();
	$("#accountBalanceWrapper").fadeIn();
	$.ajax({
		type: "GET",
		url: "/get-account-balance-ajax/" + accountId,
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				$('#accountBalanceFullname').html(customerName);
				$('#accountBalanceAccountNumber').html(accountNumber);
				$('#accountCustomerVerficationNumber').html(customerverficationnumber);
				$('#accountCurrentBalanceAmount').html(data.accountCurrency + "" + data.currentBalance);
				$('#accountAvailableBalanceAmount').html(data.accountCurrency + "" + data.availableBalance);
				
				$('#refreshAccountBalance').on('click', function(){
					viewAccountBalance(accountId, accountNumber, customerName, customerverficationnumber);
				});
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}



function viewCardBalance(jwtToken, cardId, accountNumber, full_name, cardType, schemeName, status, serialNo)
{

	$.ajax({
		type: "GET",
		url: "/api/get-card-balance-ajax/" + cardId,
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": 'Bearer ' + jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				$('#cardBalanceCardPan').html(data.card.pan);
				document.getElementById('cardBalanceNewCardAccountName').innerHTML = (full_name);
				console.log(full_name);
				document.getElementById('cardBalanceAccountNumber').innerHTML = (accountNumber);
				console.log(accountNumber);
				document.getElementById('cardBalanceCardTrackingId').innerHTML = (data.card.pan);
				console.log(data.card.pan);
				document.getElementById('cardBalanceCardSerialNo').innerHTML = (serialNo);
				console.log(serialNo);
				document.getElementById('cardBalanceCardScheme').innerHTML = (schemeName);
				document.getElementById('cardBalanceCardType').innerHTML = (cardType);
				document.getElementById('cardCurrentBalanceAmount').innerHTML = ('<span style="color:#ff0000 !important; font-weight: bold !important;">') + ((data.current_balance_negative==true ? '-' : '<span style="color:#000000 !important; font-weight: bold !important;">') + (data.cardCurrency + "" + data.current_balance)) + '</span>';
				document.getElementById('cardAvailableBalanceAmount').innerHTML = ('<span style="color:#ff0000 !important; font-weight: bold !important;">') + ((data.availableBalanceNegative==true ? '-' : '<span style="color:#000000 !important; font-weight: bold !important;">') + (data.cardCurrency + "" + data.availableBalance)) + '</span>';
				document.getElementById('cardCurrentBalanceAmount').style.color = '#000 !important;';
				document.getElementById('cardAvailableBalanceAmount').style.color = '#000 !important;';
				if(data.current_balance_negative===true)
				{
					document.getElementById('cardCurrentBalanceAmount').style.color = '#FF0000 !important;';
				}
				if(data.availableBalanceNegative===true)
				{
					document.getElementById('cardAvailableBalanceAmount').style.color = '#FF0000 !important;';
				}
				console.log([jwtToken, cardId, accountNumber, full_name, cardType, schemeName, status, serialNo, (data.card.pan), (data.cardCurrency + "" + data.current_balance), (data.cardCurrency + "" + data.availableBalance)]);


			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}







function viewCardTransfer(jwtToken, cardId)
{

	$.ajax({
		type: "GET",
		url: "/api/get-card-balance-ajax/" + cardId,
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": 'Bearer ' + jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				$('#cardBalanceCardPan').html(data.card.pan);
				document.getElementById('cardBalanceNewCardAccountName').innerHTML = (full_name);
				console.log(full_name);
				document.getElementById('cardBalanceAccountNumber').innerHTML = (accountNumber);
				console.log(accountNumber);
				document.getElementById('cardBalanceCardTrackingId').innerHTML = (data.card.pan);
				console.log(data.card.pan);
				document.getElementById('cardBalanceCardSerialNo').innerHTML = (serialNo);
				console.log(serialNo);
				document.getElementById('cardBalanceCardScheme').innerHTML = (schemeName);
				document.getElementById('cardBalanceCardType').innerHTML = (cardType);
				document.getElementById('cardCurrentBalanceAmount').innerHTML = ('<span style="color:#ff0000 !important; font-weight: bold !important;">') + ((data.current_balance_negative==true ? '-' : '<span style="color:#000000 !important; font-weight: bold !important;">') + (data.cardCurrency + "" + data.current_balance)) + '</span>';
				document.getElementById('cardAvailableBalanceAmount').innerHTML = ('<span style="color:#ff0000 !important; font-weight: bold !important;">') + ((data.availableBalanceNegative==true ? '-' : '<span style="color:#000000 !important; font-weight: bold !important;">') + (data.cardCurrency + "" + data.availableBalance)) + '</span>';
				document.getElementById('cardCurrentBalanceAmount').style.color = '#000 !important;';
				document.getElementById('cardAvailableBalanceAmount').style.color = '#000 !important;';
				if(data.current_balance_negative===true)
				{
					document.getElementById('cardCurrentBalanceAmount').style.color = '#FF0000 !important;';
				}
				if(data.availableBalanceNegative===true)
				{
					document.getElementById('cardAvailableBalanceAmount').style.color = '#FF0000 !important;';
				}
				console.log([jwtToken, cardId, accountNumber, full_name, cardType, schemeName, status, serialNo, (data.card.pan), (data.cardCurrency + "" + data.current_balance), (data.cardCurrency + "" + data.availableBalance)]);


			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}








function viewMobileMoneyAccountList()
{
	$.ajax({
		type: "GET",
		url: "/get-mobile-money-list-ajax",
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==210)
			{
				$('#allMobileMoneyAccountsTable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.data,
					"columns": [
						{ "data": "mobileNumber" },
						{ "data": "accountIdentifier" },
						{ "data": "full_name" },
						{ "data": "pan" },
						{ "data": "status" },
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}




function viewDeviceList(jwtToken, merchantId)
{
	var url = "/api/devices/get-device-list-ajax";
	if(merchantId!=undefined && merchantId!=null)
	{
		url = url + '/' + merchantId;
	}
	$.ajax({
		type: "GET",
		url: url,
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			console.log(data.merchantName);
			if(data.merchantName!=undefined && data.merchantName!=null)
			{
				$('#belongingToMerchant').html(" - " + data.merchantName);
				$('#belongingToMerchantDesc').html(" - " + data.merchantName);
			}
			if(data.status==110)
			{
				
				$('#allDevicesTable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.data,
					"columns": [
						{ "data": "merchantName" },
						{ "data": "deviceType" },
						{ "data": "deviceCode" },
						{ "data": "acquirerName" },
						{ "data": "success_fail_url_notifications" },
						{ "data": "isLive" },
						{ "data": "status" },
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}


function viewDevice(id, jwtToken)
{
	console.log(id);
	$('.deviceDetails').html("");
	$('#device_view').modal('show');
	var url = "/api/devices/get-device-ajax/" + id;
	$.ajax({
		type: "GET",
		url: url,
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": 'Bearer ' + jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			if(data.status==110)
			{
				console.log(data);
				data = data.data;
				var paymentModes = [];
				var deviceTypes = ['Web', 'POS', 'ATM', 'MPQR'];
				if(data.bankOnlineAccept!=undefined && data.bankOnlineAccept==1)
				{
					paymentModes.push('Online Banking');
				}
				if(data.eagleCardAccept!=undefined && data.eagleCardAccept==1)
				{
					paymentModes.push('Eagle Card');
				}
				if(data.mastercardVisaAccept!=undefined && data.mastercardVisaAccept==1)
				{
					paymentModes.push('MasterCard/Visa');
				}
				if(data.mobileMoneyAccept!=undefined && data.mobileMoneyAccept==1)
				{
					paymentModes.push('Mobile Money');
				}
				if(data.walletAccept!=undefined && data.walletAccept==1)
				{
					paymentModes.push('Wallet Payments');
				}

				$('#viewDeviceLiveMode').html("Test Mode");
				if(data.switchToLive!=undefined && data.switchToLive==1)
				{
					$('#viewDeviceLiveMode').html("Live Mode");
				}
				$('#viewDeviceMerchantName').html(data.merchantName);
				$('#viewDeviceMerchantCode').html(data.merchantCode);
				$('#viewDeviceSerialNo').html(data.deviceSerialNo!=undefined && data.deviceSerialNo!=null ? data.deviceSerialNo : 'Not Provided');
				$('#viewDeviceDeviceType').html(data.deviceType!=undefined && data.deviceType!=null ? data.deviceType : 'N/A');
				$('#viewDeviceSMSNotify').html(data.mobileNotify!=undefined && data.mobileNotify!=null ? data.mobileNotify : 'N/A');
				$('#viewDeviceEmailNotify').html(data.emailNotify!=undefined && data.emailNotify!=null ? data.emailNotify : 'N/A');
				$('#viewDeviceSuccessTransactionURL').html(data.successUrl!=undefined && data.successUrl!=null ? data.successUrl : 'Not Provided');
				$('#viewDeviceFailureTransactionURL').html(data.failureUrl!=undefined && data.failureUrl!=null ? data.failureUrl : 'Not Provided');
				$('#viewDevicePaymentModes').html(paymentModes.length>0 ? paymentModes.join(', ') : 'Not Provided');
				$('#viewDeviceDeviceCode').html(data.deviceCode!=undefined && data.deviceCode!=null ? data.deviceCode : 'Not Applicable');
				$('#viewDeviceMpqrSerialNo').html(data.mpqrDeviceSerialNo!=undefined && data.mpqrDeviceSerialNo!=null ? data.mpqrDeviceSerialNo : 'Not Provided');
				$('#viewDeviceMPQRDeviceCode').html(data.mpqrDeviceCode!=undefined && data.mpqrDeviceCode!=null ? data.mpqrDeviceCode : 'Not Applicable');
				$('#viewDeviceCybDemoAccessKey').html(data.cybersourceDemoAccessKey!=undefined && data.cybersourceDemoAccessKey!=null ? data.cybersourceDemoAccessKey : 'Not Applicable');
				$('#viewDeviceCybDemoProfileId').html(data.cybersourceDemoProfileId!=undefined && data.cybersourceDemoProfileId!=null ? data.cybersourceDemoProfileId : 'Not Applicable');
				$('#viewDeviceCybDemoSecretKey').html(data.cybersourceDemoSecretKey!=undefined && data.cybersourceDemoSecretKey!=null ? data.cybersourceDemoSecretKey : 'Not Applicable');
				$('#viewDeviceCybLiveAccessKey').html(data.cybersourceLiveAccessKey!=undefined && data.cybersourceLiveAccessKey!=null ? data.cybersourceLiveAccessKey : 'Not Applicable');
				$('#viewDeviceCybLiveProfileId').html(data.cybersourceLiveProfileId!=undefined && data.cybersourceLiveProfileId!=null ? data.cybersourceLiveProfileId : 'Not Applicable');
				$('#viewDeviceCybLiveSecretKey').html(data.cybersourceLiveSecretKey!=undefined && data.cybersourceLiveSecretKey!=null ? data.cybersourceLiveSecretKey : 'Not Applicable');
				$('#viewDeviceUBAMerchantId').html(data.ubaMerchantId!=undefined && data.ubaMerchantId!=null ? data.ubaMerchantId : 'Not Applicable');
				$('#viewDeviceUBAServiceKey').html(data.ubaServiceKey!=undefined && data.ubaServiceKey!=null ? data.ubaServiceKey : 'Not Applicable');
				$('#viewDeviceZICBAuthKey').html(data.zicbAuthKey!=undefined && data.zicbAuthKey!=null ? data.zicbAuthKey : 'Not Applicable');
				$('#viewDeviceZICBServiceKey').html(data.zicbServiceKey!=undefined && data.zicbServiceKey!=null ? data.zicbServiceKey : 'Not Applicable');
				$('#viewDeviceCode').html(data.deviceCode);
				$('#viewDeviceCode1').html(data.deviceCode);
				


			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}


function viewFundAgent(agentId, agentName, jwtToken)
{
	console.log(agentName);
	$('.deviceDetails').html("");
	$('#device_view').modal('show');
	$('#agentNameId').html(agentName);
	$('#fundAgentAgentId').val(agentId);
}


function viewBankList(jwtToken)
{
	var url = "/api/banks/get-bank-list-ajax";
	$.ajax({
		type: "GET",
		url: url,
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==110)
			{
				$('#allBanksTable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.data,
					"columns": [
						{ "data": "bankName" },
						{ "data": "bankCode" },
						{ "data": "bicCode" },
						//{ "data": "status" },
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}

function viewCustomerCardList(jwtToken, deviceCode)
{
	$.ajax({
		type: "GET",
		url: "/api/get-customer-card-list-ajax?deviceCode=" + deviceCode,
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==210)
			{
				$('#allCustomerCardTable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.data,
					"columns": [
						{ "data": "pan" },
						{ "data": "full_name" },
						{ "data": "accountIdentifier" },
						{ "data": "serialNo" },
						{ "data": "schemeName" },
						{ "data": "cardType" },
						{ "data": "status" },
						{ "data": "cardBalance" },
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}






function viewSupportMessageList(jwtToken, deviceCode)
{
	$.ajax({
		type: "GET",
		url: "/api/get-support-message-list-ajax?deviceCode=" + deviceCode,
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==5000)
			{
				$('#allSupportMessagesTable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.data,
					"columns": [
						{ "data": "createdAt" },
						{ "data": "sendersName" },
						{ "data": "details" },
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}




function viewCustomerCardRequestList(jwtToken, deviceCode)
{
	$.ajax({
		type: "GET",
		url: "/api/get-customer-card-request-list-ajax?deviceCode=" + deviceCode,
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==210)
			{
				$('#allCustomerCardTable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.data,
					"columns": [
						{ "data": "full_name" },
						{ "data": "nameOnCard" },
						{ "data": "accountIdentifier" },
						{ "data": "schemeName" },
						{ "data": "actionedBy" },
						{ "data": "status" },
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}





function viewMpqrDataList(jwtToken)
{

	var url = '/api/mpqr/get-mpqr-data-list';
	$.ajax({
		type: "POST",
		url: (url),
		data: ([]),
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function handleSuccess(data1){
			console.log(data1);
			if(data1.success!=undefined) {
				if (data1.success === true) {
					//alert(33);
					if (data1.status == 100) {
						$('#allCustomerCardTable').DataTable({
							//"ajax": "/get-customer-list-ajax",
							"data": data1.data,
							"columns": [
								{ "data": "qrCardNumber" },
								{ "data": "customerName" },
								{ "data": "deviceCode" },
								{ "data": "deviceSerialNo" },
								{ "data": "merchantName" },
								{ "data": "status" },
								{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
							]
						});

					} else if (data1.status == -1) {
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					} else {
						toastr.error(data1.message);
					}
					//toastr.success(data1.message);
				} else {
					toastr.error(data1.message);
					$('#dismissBtn').click();
					$('#new_card_modal').show();
				}
			}
			else
			{
				if (data1.status == -1) {
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				} else {
					toastr.error(data1.message);
				}
			}
		},
		error: function (e) {
			toastr.error('We experienced an issue updating your merchant profile. Please try again.');
		}
	});


	
}




function viewProbaseQRDataList(jwtToken)
{

	var url = '/api/probaseqr/get-probaseqr-data-list';
	$.ajax({
		type: "POST",
		url: (url),
		data: ([]),
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function handleSuccess(data1){
			console.log(data1);
			if(data1.success!=undefined) {
				if (data1.success === true) {
					//alert(33);
					if (data1.status == 100) {
						$('#allCustomerCardTable').DataTable({
							//"ajax": "/get-customer-list-ajax",
							"data": data1.data,
							"columns": [
								{ "data": "walletNumber" },
								{ "data": "customerName" },
								{ "data": "trackingNumber" },
								{ "data": "type" },
								{ "data": "status" },
								{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
							]
						});

					} else if (data1.status == -1) {
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					} else {
						toastr.error(data1.message);
					}
					//toastr.success(data1.message);
				} else {
					toastr.error(data1.message);
					$('#dismissBtn').click();
					$('#new_card_modal').show();
				}
			}
			else
			{
				if (data1.status == -1) {
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				} else {
					toastr.error(data1.message);
				}
			}
		},
		error: function (e) {
			toastr.error('We experienced an issue updating your merchant profile. Please try again.');
		}
	});


	
}




function viewMerchantList(jwtToken)
{
	
	$.ajax({
		type: "GET",
		url: "/api/merchants/list-ajax",
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==210)
			{
				var table = $('#merchanttable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					createdRow: function( row, data, dataIndex ) {
        // Set the data-status attribute, and add a class
        $( row )
            .attr('data-companyname', data.companyName!=undefined && data.companyName!=null ? data.companyName : 'N/A')
            .attr('data-companyregno', data.companyRegNo!=undefined && data.companyRegNo!=null ? data.companyRegNo : 'N/A')
            .attr('data-contactmobile', data.contactMobile!=undefined && data.contactMobile!=null ? data.contactMobile : 'N/A')
            .attr('data-bank', data.bank!=undefined && data.bank!=null ? data.bank : 'N/A')
            .attr('data-bankaccount', data.bankAccount!=undefined && data.bankAccount!=null ? data.bankAccount : 'N/A')
            .attr('data-bankbranchcode', data.bankBranchCode!=undefined && data.bankBranchCode!=null ? data.bankBranchCode : 'N/A')
            .addClass('asset-context box');
    },
					"data": data.data,
					"columns": [
						{ "data": "more", "class": "details-control" },
						{ "data": "merchantName" },
						{ "data": "merchantCode" },
						{ "data": "contactEmail" },
						{ "data": "bank" },
						{ "data": "bankAccount" },
						{ "data": "status" },
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});


				$('#merchanttable').on('click', 'td.details-control', function () {

					console.log(table.rows);
              			var tr = $(this).closest('tr');
                			var row = table.row(tr);

                			if (row.child.isShown()) {
                    				// This row is already open - close it
                    				row.child.hide();
                    				tr.removeClass('shown');
                			} else {
                    				// Open this row
                    				console.log(tr.data());
                    				row.child(format({
                        				'<strong>Company Name:</strong>' : tr.data('companyname'),
                        				'<strong>Company PACRA Number:</strong>' :  tr.data('companyregno'),
                        				'<strong>Company Contact Number:</strong>' : tr.data('contactmobile'),
                        				'<strong>Merchants Bank:</strong>' :  tr.data('bank'),
                        				'<strong>Merchants Account Number:</strong>' : tr.data('bankaccount'),
                        				'<strong>Merchants Bank Branch Code:</strong>' :  tr.data('bankbranchcode'),
                    				})).show();
                    				tr.addClass('shown');
                			}
            			});
				
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}



function viewCardTransactionList(jwtToken, cardId)
{

	$.ajax({
		type: "GET",
		url: "/api/ecards/get-card-transaction-list-ajax" + (cardId!=undefined && cardId!=null && cardId>0 ? '/'+cardId : '') + '?filter=card',
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				$('#merchanttransactiontable').DataTable({
					//"ajax": "/get-customer-list-ajax",



					dom: 'Bfrtip',
        				buttons: [
            					'copy', 'csv', 'excel', {
							extend: 'pdfHtml5',
							exportOptions: {
                    						columns: [ 0, 1, 2, 5, 6, 7 ]
							},
							orientation: 'landscape',
							pageSize: 'LEGAL'
						}, 'print'
        				],
					"lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],

					"data": data.list,
					"columns": [
						{ "data": "sno" },
						{ "data": "transactionDate" },
						{ "data": "orderRef" },
						{ "data": "transactionRef" },
						{ "data": "payerName" },
						{ "data": "channel" },
						{ "data": "serviceType" },
						{ "data": "status" },
						{ "data": "amount" },
					]
				});

			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				else {
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}



function viewWalletTransactionList(jwtToken, walletId)
{

	$.ajax({
		type: "GET",
		//url: "/api/accounts/get-wallet-transaction-list-ajax" + (walletId!=undefined && walletId!=null && walletId>0 ? '/'+walletId : '') + '?filter=wallet',
		url: "/api/transactions/get-transaction-list-ajax" + '?filter=wallet',
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				$('#wallettransactiontable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.list,
					"columns": [
						//{ "data": "id" },
						{ "data": "accountIdentifier" },
						{ "data": "transactionDate" },
						{ "data": "transactionRef" },
						{ "data": "payerName" },
						{ "data": "accountNo" },
						{ "data": "channel" },
						{ "data": "serviceType" },
						{ "data": "status" },
						{ "data": "amount" },
					]
				});

			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					//window.location = '/logout';
				}
				else {
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}


function viewReversalList(jwtToken, count, filter, queryStr, serverToken)
{

	var url = "/api/transactions/get-reversal-list-ajax/1?token="+serverToken+"&filter="+filter;
	if(queryStr!=null)
	{
		url = url + queryStr;
	}
	$.ajax({
		type: "POST",
		url: url,
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				$('#alltransactionstable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.list,
					"columns": [
						{ "data": "id" },
						{ "data": "created_at" },
						{ "data": "orderId" },
						{ "data": "payerName" },
						{ "data": "description" },
						{ "data": "status" },
						{ "data": "amount", className: "text-right" },
					]
				});

			}
			else
			{
				if(data.status==-1)
				{
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else {
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}





function viewVillageBankingGroupList(jwtToken, count, filter, queryStr, serverToken)
{

	var url = "/api/village-banking/listing/1";
	var formData = new FormData();
	formData.append('token', serverToken);

	$.ajax({
		type: "POST",
		url: url,
		data: formData,
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				/*$('#allvillagebankinggroupstable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.data,
					"columns": [
						{ "data": "name" },
						{ "data": "gmmembers", className: "text-center" },
						{ "data": "currentBalance", className: "text-right"  },
						{ "data": "loanPackageYes", className: "text-center"  },
						{ "data": "createdAt" },
						{ "data": "activeYes"}					]
				});*/

				$.each(data.data, function (i)
                            {

					var y = data.data[i].id;
                                html = ' <tr> ' +
						  
                                    '<td>' + data.data[i].name + '</td>' +
                                    '<td>' + data.data[i].firstName + ' ' + data.data[i].lastName + '</td>' +
                                    '<td class="text-center">' + data.data[i].gmmembers+ ' of '+ data.data[i].maximumMembers +'</td>' +
                                    '<td class="text-center">' + data.data[i].loanPackageYes + '</td>' +
                                    '<td>' + data.data[i].createdAt+ '</td>' +
                                    '<td>' + data.data[i].activeYes+ '</td>' + 
                                    '<td class="text-right">' + parseFloat(data.data[i].currentBalance).toFixed(2) + '</td>' +
                                    '<td>' +
						'<div class="btn-group mr-1 mb-1">'+
							'<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>'+
							'<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">'+
								'<a class="dropdown-item" href="/potzr-staff/merchants/view-merchant-account/' + y + '">View Members</a>'+
								'<a class="dropdown-item" href="/potzr-staff/merchants/view-merchant-account/' + y + '">View Contributions</a>'+
								'<a class="dropdown-item" href="/potzr-staff/merchants/view-merchant-account/' + y + '">View Loans</a>'+
								'<a class="dropdown-item" href="/potzr-staff/merchants/view-merchant-account/' + y + '">View Transactions</a>'+
							'</div>'+
						'</div>'+
					 '</td>' +  
                                    ' </tr>';
                                $('#allvillagebankinggroupstablebody').append(html);
                            });


			}
			else
			{
				if(data.status==-1)
				{
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else {
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}




function format ( d ) {
    // `d` is the original data object for the row
    var ret = '<table cellpadding="5" cellspacing="0" border="0" style="width: 100% !important; padding-left:50px; table-layout: fixed;">';

	if(d.isRequestXML==0)
	{
    ret = ret + '<tr>'+
            '<td style="width: 10% !important;">Request:</td>'+
            '<td style="white-space:normal !important;"><span class="wrapTextStyle1"><pre>'+JSON.stringify(JSON.parse(d.requestData), undefined, 2)+'</pre></span></td>'+
        '</tr>'+
        '<tr>'+
            '<td style="width: 10% !important;">Response:</td>'+
            '<td><span class="wrapTextStyle1"><pre>'+ d.responseData +'</pre></span></td>'+
        '</tr>';
	//(d.responseData!= undefined ? JSON.stringify(JSON.parse(d.responseData), undefined, 2) : "N/A")
	}
	else if(d.isRequestXML==1)
	{
    ret = ret + '<tr>'+
            '<td style="width: 10% !important;">Request:</td>'+
            '<td style="white-space:normal !important;"><span class="wrapTextStyle1"><pre>'+(d.requestData)+'</pre></span></td>'+
        '</tr>'+
        '<tr>'+
            '<td style="width: 10% !important;">Response:</td>'+
            '<td><span class="wrapTextStyle1"><pre>'+d.responseData+'</pre></span></td>'+
        '</tr>';
	}

	try {
        	ret = ret + '<tr>'+
            		'<td style="width: 10% !important;">ProbasePay Response:</td>'+
            		'<td><span class="wrapTextStyle1"><pre>'+JSON.stringify(JSON.parse(d.responseDataLevel2), undefined, 2)+'</pre></span></td>'+
        	'</tr>'+
    		'</table>';
    	} catch(e) {
        	ret = ret + '<tr>'+
            		'<td style="width: 10% !important;">ProbasePay Response:</td>'+
            		'<td><span class="wrapTextStyle1"><pre>' + d.responseDataLevel2 +'</pre></span></td>'+
        	'</tr>'+
    		'</table>';
    	}
        
    return ret;
}

function viewRequestLogsList(jwtToken, count, filter, queryStr, requestTypes)
{
	const days = [
	  'Sun',
	  'Mon',
	  'Tue',
	  'Wed',
	  'Thu',
	  'Fri',
	  'Sat'
	];

	const months = [
	  'Jan',
	  'Feb',
	  'Mar',
	  'Apr',
	  'May',
	  'Jun',
	  'Jul',
	  'Aug',
	  'Sep',
	  'Oct',
	  'Nov',
	  'Dec'
	];



	console.log(requestTypes);
	var url = "/api/logs/get-logs-list-ajax?filter="+filter;
	if(queryStr!=null)
	{
		url = url + queryStr;
	}
	$.ajax({
		type: "GET",
		url: url,
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				var list = data.list;


				var list1 = [];
				for(var j=0; j<list.length; j++)
				{
					var dt = new Date(list[j].created_at);
console.log(dt);

					const dayName = days[dt.getDay()];
					const monthName = months[dt.getMonth()];
					var mins = dt.getMinutes();
					var hrs = dt.getHours();
					hrs = hrs<10 ? ('0'+hrs) : hrs;
					mins= mins<10 ? ('0'+mins) : mins;
					var formatted = dayName + ', ' + dt.getDate() + ' ' + monthName + ' ' + dt.getFullYear() + ' at ' + hrs + ':' + mins + "HRS";
					var list2 = {};
					list2["id"] = (j + 1) + ".";
					list2["createdAt"] = formatted;
					list2["isRequestXML"] = list[j].isRequestXML;
					list2["isLive"] = list[j].isLive!=undefined ? (list[j].isLive==0 ? "<span class='btn btn-primary btn-sm'>UAT</span>" : "<span class='btn btn-success btn-sm'>Live</span>") : "N/A";
					list2["isResponseXML"] = list[j].isResponseXML;
					list2["requestData"] = list[j].requestData!=undefined ? list[j].requestData: "N/A";
					list2["requestType"] = list[j].requestType!=undefined ? ('<a href="/potzr-staff/logs/'+requestTypes[list[j].requestType]+'">' + requestTypes[list[j].requestType].replaceAll("_", " ") + '</a>') : "N/A";
					list2["responseData"] = list[j].responseData!=undefined ? list[j].responseData : "N/A";
					list2["responseDataLevel2"] = list[j].responseDataLevel2!=undefined ? list[j].responseDataLevel2 : "N/A";
					list2["responseStatus"] = list[j].responseStatus!=undefined ? list[j].responseStatus==1 ? "<span class='btn btn-danger btn-sm'>Failed</span>" : "<span class='btn btn-success btn-sm'>Success</span>" : "<span class='btn btn-primary btn-sm'>Pending</span>";
					list2["actorUsersName"] = list[j].actorUsersName!=undefined ? (list[j].actorUsersName + "<br>") : "";
					list2["actorUsersName"] = list[j].customerMobile!=undefined ? (list2["actorUsersName"] + "" + list[j].customerMobile + "<br>") : "";
					list2["actorUsersName"] = list2["actorUsersName"].length>0 ? list2["actorUsersName"] : "N/A";
					list2["endPoint"] = list[j].endPoint!=undefined ? list[j].endPoint : "N/A";
					list2["requestByDeviceCode"] = list[j].requestByDeviceCode!=undefined ? list[j].requestByDeviceCode : "N/A";
					list2["action"] = "<a href=''>View Request/Response</a>";
					list1.push(list2);
				}

				console.log(list1);

				
				var table = $('#alltransactionstable').DataTable({
					dom: 'Bfrtip',
        				buttons: [
				            'copy', 'csv', 'excel', {
						extend: 'pdfHtml5',
						exportOptions: {
				                    columns: [ 0, 1, 2, 5, 6, 7 ]
						},
						orientation: 'landscape',
						pageSize: 'LEGAL' }, 'print'
        				],

					"lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
					//"ajax": "/get-customer-list-ajax",
					"data": list1,
					"columnDefs": [
            					{
                					"targets": [ 8, 9, 10 ],
                					"visible": false,
                					"searchable": false
            					},
        				],
					"columns": [

						{
                					"className":      'dt-control',
                					"orderable":      false,
                					"data":           null,
                					"defaultContent": ''
            					},
						{ "data": "id" },
						{ "data": "createdAt" },
						{ "data": "requestType" },
						{ "data": "actorUsersName" },
						{ "data": "requestByDeviceCode" },
						{ "data": "isLive" },
						{ "data": "responseStatus" },
						{ "data": "responseData" },
						{ "data": "responseDataLevel2" },
						{ "data": "requestData" },
						/*{ "data": "currentPoolAccountBalance", className: "text-right"  },
						{ "data": "action"},*/
					],   
    					rowCallback: function (row, data) {
        					if ( data.isReversed!=undefined && data.isReversed==true ) {
            						$(row).addClass('strikethrough');
       					}
    					}
				});


    				$('#alltransactionstable tbody').on('click', 'td.dt-control', function () {
        				$("table > tbody > tr").each(function () {
    						if(table.row( $(this) ).child.isShown())
						{
							table.row( $(this) ).child.hide();
							$(this).removeClass('shown');
						}

					});

        				var tr = $(this).closest('tr');
        				var row = table.row( tr );
 
        				if ( row.child.isShown() ) {
            					// This row is already open - close it
            					row.child.hide();
            					tr.removeClass('shown');
        				}
        				else {
            					// Open this row
            					row.child( format(row.data()) ).show();
            					tr.addClass('shown');
        				}
    				} );

			}
			else
			{
				if(data.status==-1)
				{
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else {
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}




function viewTransactionList(jwtToken, count, filter, queryStr)
{

	var url = "/api/transactions/get-transaction-list-ajax?filter="+filter;
	if(queryStr!=null)
	{
		url = url + queryStr;
	}
	$.ajax({
		type: "GET",
		url: url,
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				$('#alltransactionstable').DataTable({
					dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', {
extend: 'pdfHtml5',
exportOptions: {
                    columns: [ 0, 1, 2, 5, 6, 7 ]
},
orientation: 'landscape',
pageSize: 'LEGAL' }, 'print'
        ],
					"lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
					//"ajax": "/get-customer-list-ajax",
					"data": data.list,
					"columns": [
						{ "data": "id" },
						{ "data": "transactionDate" },
						{ "data": "payerName" },
						{ "data": "serviceType" },
						{ "data": "status" },
						{ "data": "amount", className: "text-right" },
						{ "data": "totalCharges", className: "text-right" },
						{ "data": "balance", className: "text-right"  },
						/*{ "data": "currentPoolAccountBalance", className: "text-right"  },*/
						{ "data": "action", className: "actionColumn"},
					],   
    					rowCallback: function (row, data) {
        					if ( data.isReversed!=undefined && data.isReversed==true ) {
            						$(row).addClass('strikethrough');
       					}
    					}
				});

			}
			else
			{
				if(data.status==-1)
				{
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else {
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}






function viewTransactionListForAgent(jwtToken, count, filter, queryStr)
{

	var url = "/api/transactions/get-transaction-list-ajax?filter="+filter;
	if(queryStr!=null)
	{
		url = url + queryStr;
	}
	$.ajax({
		type: "GET",
		url: url,
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{

				




				var table = $('#alltransactionstable').DataTable({
					dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', {
extend: 'pdfHtml5',
exportOptions: {
                    columns: [ 0, 1, 2, 5, 6, 7 ]
},
orientation: 'landscape',
pageSize: 'LEGAL' }, 'print'
        ],
					"lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
					//"ajax": "/get-customer-list-ajax",
					"data": data.list,
					"columnDefs": [
            					{
                					"targets": [ 4, 5, 6, 7, 8, 9, 10, 11],
                					"visible": false,
                					"searchable": false
            					},
        				],/**/
					"columns": [
						{
                					"className":      'dt-control',
                					"orderable":      false,
                					"data":           null,
                					"defaultContent": ''
            					},
						{ "data": "id" },
						{ "data": "transactionDate" },
						{ "data": "transactionRef" },
						{ "data": "bvSource" },
						{ "data": "partnerAccount" },
						{ "data": "partnerCustomerName" },
						{ "data": "partnerType" },
						{ "data": "otherBankRef" },
						{ "data": "acquirerRef" },
						{ "data": "txnType" },
						{ "data": "remarks" },
						{ "data": "payerName" },
						{ "data": "serviceType" },
						{ "data": "status" },
						{ "data": "amount", className: "text-right" },
						{ "data": "balance", className: "text-right"  },
					],   
    					rowCallback: function (row, data) {
        					if ( data.isReversed!=undefined && data.isReversed==true ) {
            						$(row).addClass('strikethrough');
       					}
    					}
				});


				$('#alltransactionstable tbody').on('click', 'td.dt-control', function () {
        				$("table > tbody > tr").each(function () {
    						if(table.row( $(this) ).child.isShown())
						{
							table.row( $(this) ).child.hide();
							$(this).removeClass('shown');
						}

					});

        				var tr = $(this).closest('tr');
        				var row = table.row( tr );
 
        				if ( row.child.isShown() ) {
            					// This row is already open - close it
            					row.child.hide();
            					tr.removeClass('shown');
        				}
        				else {
            					// Open this row
						console.log(row.data());
            					//row.child( format(row.data()) ).show();
            					tr.addClass('shown');
        				}
    				} );

			}
			else
			{
				if(data.status==-1)
				{
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else {
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}





function viewTransactionListForCustomer(jwtToken)
{

	$.ajax({
		type: "GET",
		url: "/api/transactions/get-transaction-list-ajax",
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				$('#alltransactionstable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.list,
					"columns": [
						{ "data": "id" },
						{ "data": "transactionDate" },
						{ "data": "transactionRef" },
						{ "data": "payerName" },
						{ "data": "serviceType" },
						{ "data": "channel" },
						{ "data": "status" },
						{ "data": "currency" },
						{ "data": "amount", className: "text-right" },
						{ "data": "action" },
					]
				});

			}
			else
			{
				if(data.status==-1)
				{
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else {
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}


function handleLoadSmartCoopsInterface(cooperative_code, data)
{
	console.log(cooperative_code);
	console.log(data);
	data = encodeURIComponent(data);
	var url = 'https://smartcoops.org/api/third-party-auth/login/1?cooperative_code=' + cooperative_code + '&data=' + data;
	//var url = 'https://smartcoops.org/dashboard';
	console.log(url);
	//window.location = url;
	$("#mainFrame").attr("src", url);
}


function handleNotifySettingsReqd()
{
	toastr.success('You can only access your village banking group after the settings for the group has been provided. Provide the settings by clicking the settings link');
}


function loadVillageBankingSettings(groupCode, data, groupName)
{
	console.log([groupCode, data, groupName]);
	$('#villageBankingGroupSettingsNameDiv').html(groupName);
	$('#villageBankingGroupSettingsEncInfo').val(data);
	$('#vbsettingsgroupId').val(groupCode);
}


function handleSaveGroupSettings(jwtToken)
{
	vbGroupCode = $('#vbsettingsgroupId').val();
	console.log(vbGroupCode);
	villageBankingSettingsRules = $('#villageBankingSettingsRules').val();
	villageBankingSettingsRegistrationFeesCurrency = $('#villageBankingSettingsRegistrationFeesCurrency').val();
	villageBankingSettingsRegistrationFees = $('#villageBankingSettingsRegistrationFees').val();
	villageBankingSettingsMembershipFeesCurrency = $('#villageBankingSettingsMembershipFeesCurrency').val();
	villageBankingSettingsMembershipFees = $('#villageBankingSettingsMembershipFees').val();
	villageBankingSettingsMembershipFeesIntervalType = $('#villageBankingSettingsMembershipFeesIntervalType').val();
	villageBankingSettingsMembershipFeesAmount = $('#villageBankingSettingsMembershipFeesAmount').val();
	villageBankingSettingsMembershipFeesPeriod = $('#villageBankingSettingsMembershipFeesPeriod').val();
	vbsettingsgroupId = $('#vbsettingsgroupId').val();

	proceed = true;
	if(villageBankingSettingsMembershipFeesAmount!=undefined && villageBankingSettingsMembershipFeesAmount.length>0 && 
		villageBankingSettingsMembershipFeesAmount>0)
	{
		if(villageBankingSettingsMembershipFeesIntervalType==-1)
		{
			toastr.error('If there are applicable membership fees, specify the when the payments are due and how much the membership fees are');
			proceed = false;
		}

		if(villageBankingSettingsMembershipFeesPeriod!=undefined && villageBankingSettingsMembershipFeesPeriod>0)
		{

		}
		else
		{
			toastr.error('If there are applicable membership fees, specify how many times members pay membership fees');
			proceed = false;
		}
	}

	if(proceed===true)
	{
		var form = $('#vbsettingsform')[0];
		var formData = new FormData(form);
		var url = '/api/village-banking/update-group-settings';
		$.ajax({
			type: "POST",
			url: (url),
			data: (formData),
			processData: false,
			contentType: false,
			cache: false,
			headers: {"Authorization": 'Bearer ' + jwtToken},
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				if(data1.success!=undefined) {
					if (data1.success === true) {
						//alert(33);
						if (data1.status == 100) {
							toastr.success(data1.message);
							$('.os-icon-close').click();
							handleLoadSmartCoopsInterface(vbGroupCode, $('#villageBankingGroupSettingsEncInfo').val());
							encData = $('#villageBankingGroupSettingsEncInfo').val();
							html = '<a id="loadSmartCoopsInterfaceLink" data-backdrop="static" data-keyboard="false" data-target="#smart_coops_modal" data-toggle="modal" onclick="handleLoadSmartCoopsInterface(\''+vbGroupCode+'\', \''+encData+'\')" style="cursor: pointer !important" class="btn btn-primary btn-sm">Access Group</a>';
							accessgroupholder = $('#accessgroupholder').html(html);
							$('#loadSmartCoopsInterfaceLink').click();
						} else if (data1.status == -1) {
							console.log(window.location);
							logoutUser('Your session has ended. Please log in to continue', window.location.href);
						} else {
							toastr.error(data1.message);
						}
					} else {
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					}
				}
				else
				{
					if (data1.status == -1) {
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					} else {
						toastr.error(data1.message);
					}
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}
}


function viewCustomerTransactionList(jwtToken)
{

	$.ajax({
		type: "GET",
		url: "/api/transactions/get-transaction-list-ajax",
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				$('#alltransactionstable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.list,
					"columns": [
						{ "data": "status" },
						{ "data": "transactionDate" },
						{ "data": "transactionRef" },
						{ "data": "transactionDetail" },
						{ "data": "serviceType" },
						{ "data": "amount" },
					]
				});

			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					//window.location = '/logout';
				}
				else {
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}


function createVillageGroup(jwtToken)
{
	if (($('#newVillageBankGroupForm').validator('validate').has('.has-error').length)) {
		//alert('SOMETHING WRONG');
		toastr.error("Provide all required information before submitting");
	} else {

		var form = $('#newVillageBankGroupForm')[0];
		var formData = new FormData(form);
		var url = '/api/village-banking/create-new-village-bank-group';
		$.ajax({
			type: "POST",
			url: (url),
			data: (formData),
			processData: false,
			contentType: false,
			cache: false,
			headers: {"Authorization": 'Bearer ' + jwtToken},
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				if(data1.success!=undefined) {
					if (data1.success === true) {
						//alert(33);
						if (data1.status == 100) {
							toastr.success(data1.message);
							$('.os-icon-close').click();
							$('#villageBankingGroupSettingsNameDiv').html($('#villageBankingGroupName').val());
							$('#grpotplink').click();
							$('#vbotpgroupId').val(data1.vbid);
							document.getElementById("vbotp1").focus();
						} else if (data1.status == -1) {
							console.log(window.location);
							logoutUser('Your session has ended. Please log in to continue', window.location.href);
						} else {
							toastr.error(data1.message);
						}
					} else {
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					}
				}
				else
				{
					if (data1.status == -1) {
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					} else {
						toastr.error(data1.message);
					}
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}
}


jQuery('#vbotp1').keyup(function () {
	var inputVal = $(this).val();
	//var characterReg = /^[0-9]{5}$/;
	console.log(inputVal);
	if (inputVal.length>0) {
		document.getElementById("vbotp2").focus();
	}
});
jQuery('#vbotp2').keyup(function () {
	var inputVal = $(this).val();
	//var characterReg = /^[0-9]{5}$/;
	console.log(inputVal);
	if (inputVal.length>0) {
		document.getElementById("vbotp3").focus();
	}
});
jQuery('#vbotp3').keyup(function () {
	var inputVal = $(this).val();
	//var characterReg = /^[0-9]{5}$/;
	console.log(inputVal);
	if (inputVal.length>0) {
		document.getElementById("vbotp4").focus();
	}
});
jQuery('#vbotp4').keyup(function () {
	var inputVal = $(this).val();
	//var characterReg = /^[0-9]{5}$/;
	console.log(inputVal);
	if (inputVal.length>0) {
		document.getElementById("vbotp5").focus();
	}
});
jQuery('#vbotp5').keyup(function () {
	var inputVal = $(this).val();
	//var characterReg = /^[0-9]{5}$/;
	console.log(inputVal);
	if (inputVal.length>0) {
		document.getElementById("vbotp6").focus();
	}
});
jQuery('#vbotp6').keyup(function () {
	var inputVal = $(this).val();
	//var characterReg = /^[0-9]{5}$/;
	console.log(inputVal);
	if (inputVal.length>0) {
		validateOTP($('#vbotpgrouptoken').val());
	}
});



function validateOTP(jwtToken)
{
	var form = $('#vbotpform')[0];
	var formData = new FormData(form);
	var url = '/api/village-banking/otp-validation';

	var poData = jQuery(document.forms['vbotpform']).serializeArray();
	formData = "";
	for (var i=0; i<poData.length; i++)
		formData = formData + '&' + poData[i].name + '=' + poData[i].value;

	$.ajax({
		type: "GET",
		url: (url),
		data: (formData),
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": 'Bearer ' + jwtToken},
		timeout: 600000,
		success: function handleSuccess(data1){
			console.log(data1);
			if(data1.success!=undefined) {
				if (data1.success === true) {
					//alert(33);
					if (data1.status == 100) {
						toastr.success(data1.message);
						$('.os-icon-close').click();
						$('#villageBankingGroupSettingsNameDiv').html($('#villageBankingGroupName').val());
						$('#grpsettingslink').click();
						$('#vbsettingsgroupId').val(data1.vbid);
					} else if (data1.status == -1) {
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					} else {
						toastr.error(data1.message);
					}
				} else {
					toastr.error(data1.message);
					$('#dismissBtn').click();
					$('#new_card_modal').show();
				}
			}
			else
			{
				if (data1.status == -1) {
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				} else {
					toastr.error(data1.message);
				}
			}
		},
		error: function (e) {
			toastr.error('We experienced an issue updating your merchant profile. Please try again.');
		}
	});
}

function viewCustomerUtilitiesPaidList(jwtToken)
{

	$.ajax({
		type: "GET",
		url: "/api/transactions/get-utilities-paid-list-ajax",
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				$('#alltransactionstable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.list,
					"columns": [
						{ "data": "status" },
						{ "data": "transactionDate" },
						{ "data": "transactionRef" },
						{ "data": "transactionDetail" },
						{ "data": "utilityType" },
						{ "data": "amount" },
					]
				});

			}
			else
			{
				if(data.status==-1)
				{
					logoutUser(data.message, window.location.href);
				}
				else {
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}



function viewUtilitiesPaidList(jwtToken, queryStr)
{

	var url = "/api/transactions/get-utilities-paid-list-ajax?"+queryStr;
	$.ajax({
		type: "GET",
		url: url,
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				$('#billstable').DataTable({
					dom: 'Bfrtip',
					buttons: [
						'copy', 'csv', 'excel', {
							extend: 'pdfHtml5',
							exportOptions: {
								columns: [ 0, 1, 2, 5, 6, 7 ]
							},
							orientation: 'landscape',
							pageSize: 'LEGAL' }, 'print'
					],
					"lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
					//"ajax": "/get-customer-list-ajax",
					"data": data.list,
					"columns": [
						{ "data": "sno" },
						{ "data": "orderRef" },
						{ "data": "transactionRef" },
						{ "data": "vendor" },
						{ "data": "transactionYear" },
						{ "data": "transactionMonth" },
						{ "data": "currency"},
						{ "data": "amount","class": "text-right" },
						{ "data": "utilityIdentifier" },
						{ "data": "status" },
						{ "data": "transactionDate" },
						{ "data": "payerName" },
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});

			}
			else
			{
				if(data.status==-1)
				{
					logoutUser(data.message, window.location.href);
				}
				else {
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}




function viewCustomerLoansListing(jwtToken, queryStr)
{

	var url = "/api/customer-loans/get-customer-loans-list-ajax?"+queryStr;
	$.ajax({
		type: "GET",
		url: url,
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				$('#billstable').DataTable({
					dom: 'Bfrtip',
					buttons: [
						'copy', 'csv', 'excel', {
							extend: 'pdfHtml5',
							exportOptions: {
								columns: [ 0, 1, 2, 5, 6, 7 ]
							},
							orientation: 'landscape',
							pageSize: 'LEGAL' }, 'print'
					],
					"lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
					//"ajax": "/get-customer-list-ajax",
					"data": data.list,
					"columns": [
						{ "data": "customerName" },
						{ "data": "principal","class": "text-right"  },
						{ "data": "interestDue","class": "text-right"  },
						{ "data": "principalRepaid","class": "text-right"  },
						{ "data": "interestRepaid","class": "text-right"  },
						{ "data": "rate","class": "text-right"  },
						{ "data": "isRepaid", "class": "upper" },
						{ "data": "utilityType"},
						{ "data": "created_at" },
					]
				});

			}
			else
			{
				if(data.status==-1)
				{
					logoutUser(data.message, window.location.href);
				}
				else {
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}



function viewMerchantTransactionList(jwtToken, merchantId)
{

	var formData = new FormData();
		formData.append('merchantId', merchantId);
		//formData.append('token', sessionToken);

	console.log(merchantId);
	var url = "/api/merchants/get-merchant-transaction-list-ajax" + (merchantId!=undefined && merchantId!=null ? ('/'+merchantId) : '');
	console.log(url);
	$.ajax({
		type: "GET",
		url: url,
		data: formData,
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				if(data.merchantNameToDisplay!=null)
					$('.merchantInform').html(' - ' + data.merchantNameToDisplay);


				$('#merchanttransactiontable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.list,
					"columns": [
						{ "data": "merchantName" },
						{ "data": "transactionDate" },
						{ "data": "transactionRef" },
						{ "data": "payerName" },
						{ "data": "sourceIdentity" },
						{ "data": "serviceType" },
						{ "data": "status" },
						{ "data": "currency", "class": "text-right"},
						{ "data": "amount", "class": "text-right"},
					]
				});

			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					//window.location = '/logout';
				}
				else {
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}

function viewCardSchemeList(jwtToken)
{
	$.ajax({
		type: "GET",
		url: "/api/cards/list-card-schemes-ajax",
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==110)
			{
				$('#allCardSchemesTable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.data,
					"columns": [
						{ "data": "schemeName" },
						{ "data": "schemeCode" },
						{ "data": "overrideFixedFee" },
						{ "data": "overrideTransactionFee" },
						{ "data": "minimumBalance" },
						{ "data": "currency" },
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});
				
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}







function addNewAccount(customerId, token, customerName, customerverficationnumber, merchantCode, deviceCode)
{
	console.log(customerId);
	console.log(token);
	console.log(customerName);
	console.log(customerverficationnumber);
	console.log(merchantCode);
	console.log(deviceCode);
	document.getElementById('newAccountCustomername').innerHTML = customerName;
	document.getElementById('newAccountCustomerverficationnumber').innerHTML = customerverficationnumber;
	$('#addNewAccountCustomerVerificationNumber').val(customerverficationnumber);
	$('#addNewAccountMerchantCode').val(merchantCode);
	$('#addNewAccountDeviceCode').val(deviceCode);
	$(".allfloater").fadeOut();
	$("#newAccountCustomerAccountWrapper").fadeIn();
	$.ajax({
		type: "GET",
		url: "/get-default-data",
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			var all_card_schemes = data.all_card_schemes;
			var all_account_type = data.all_account_type;
			var all_currency = data.all_currency;
			var all_card_type = data.all_card_type;
			var all_provinces = data.all_provinces;
			var all_countries = data.all_countries;
			
			$('#accountType').empty();
			$('#accountCurrency').empty();
			$('#cardType').empty();
			$('#cardScheme').empty();
			
			
			$('#accountType').append($('<option>', { 
				value: null,
				text : '-Select One-' 
			}));
			$('#accountCurrency').append($('<option>', { 
				value: null,
				text : '-Select One-' 
			}));
			$('#cardType').append($('<option>', { 
				value: null,
				text : '-Select One-' 
			}));
			$('#cardScheme').append($('<option>', { 
				value: null,
				text : '-Select One-' 
			}));
			
			$.each(all_account_type, function(key, value) {
				console.log(value);
				console.log(key);
				$('#accountType').append($('<option>', { 
					value: value,
					text : value
				}));
				
			});
			$.each(all_card_type, function(key, value) {
				console.log(value);
				console.log(key);
				$('#cardType').append($('<option>', { 
					value: key,
					text : value
				}));
				
			});
			$.each(all_currency, function(key, value) {
				console.log(value);
				console.log(key);
				$('#accountCurrency').append($('<option>', { 
					value: key,
					text : value
				}));
				
			});
			$.each(all_card_schemes, function(key, value) {
				console.log(value);
				console.log(key);
				$('#cardScheme').append($('<option>', { 
					value: value.id,
					text : value.schemeName
				}));
				
			});
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}


function addNewCardToCustomer(customerId, customerName, customerverficationnumber)
{
	console.log(customerId);
	console.log(customerName);
	console.log(customerverficationnumber);
	document.getElementById('notifymsg').innerHTML = "";
	document.getElementById('customerNewCardCustomerName').innerHTML = customerName;
	document.getElementById('customerNewCardCustomerverficationnumber').innerHTML = customerverficationnumber;
	$('#cardfundingfromcustomerdiv').hide();
	$('#customerAddNewCardToAccount').hide();
	$(".allfloater").fadeOut();
	$("#customerNewCardWrapper").fadeIn();
	
	
	$.ajax({
		type: "GET",
		url: "/get-default-data",
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			var all_card_schemes = data.all_card_schemes;
			var all_account_type = data.all_account_type;
			var all_currency = data.all_currency;
			var all_card_type = data.all_card_type;
			var all_provinces = data.all_provinces;
			var all_countries = data.all_countries;
			
			$('#customerNewCardCardType').empty();
			$('#customerNewCardCardScheme').empty();
			
			
			$('#customerNewCardCardType').append($('<option>', { 
				value: null,
				text : '-Select One-' 
			}));
			$('#customerNewCardCardScheme').append($('<option>', { 
				value: null,
				text : '-Select One-' 
			}));
			
			$.each(all_card_type, function(key, value) {
				console.log(value);
				console.log(key);
				$('#customerNewCardCardType').append($('<option>', { 
					value: key,
					text : value
				}));
				
			});
			$.each(all_card_schemes, function(key, value) {
				console.log(value);
				console.log(key);
				$('#customerNewCardCardScheme').append($('<option>', { 
					value: value.id,
					text : value.schemeName
				}));
				
			});
			
			
			$.ajax({
				type: "GET",
				url: "/get-customer-account-list-ajax/" + customerId,
				data: [],
				processData: false,
				contentType: false,
				cache: false,
				timeout: 600000,
				success: function (data1) {
					console.log(data1);
					/*
					if(floatingBalance!=undefined && floatingBalance!=null)
					{
						console.log(currencyCode + "" + floatingBalance);
						$('#floatingBalance').html(currencyCode + "" + floatingBalance);
						$('#cardfundingfromcustomerdiv').show();
					}
					else
					{
						$('#cardfundingfromcustomerdiv').hide();
					}*/
					
					$('#customerNewCardAccount').empty();
					$('#customerNewCardAccount').append($('<option>', { 
						value: null,
						text : '-Select One-' 
					}));
					$.each(data1.data, function(key, value) {
						console.log(value);
						console.log(key);
						$('#customerNewCardAccount').append($('<option>', { 
							value: value.id,
							text : value.accountIdentifier
						}));
						
					});
				},
				error: function (e) {
					console.error(e);
					toastr.error('We encountered an error. Please try again');
				}
			});
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}

function addNewCard(accountId, accountNumber, customerName, customerverficationnumber, currencyCode, acquirer_id)
{
	
	$('#accountNumber').html(accountNumber);
	$('#newCardAccountName').html(customerName);
	$('#newCardCardHolder').val(customerName);
	$('#accountIdentifierNewCard').val(accountNumber);
	$('#acquirerIdNewCard').val(acquirer_id);
	$('#customerVerificationNo').val(customerverficationnumber);
	$('#currencyCodeNewCard').val(currencyCode);

	$.ajax({
		type: "GET",
		url: "/get-default-data",
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			var all_card_schemes = data.all_card_schemes;
			var all_account_type = data.all_account_type;
			var all_currency = data.all_currency;
			var all_card_type = data.all_card_type;
			var all_provinces = data.all_provinces;
			var all_countries = data.all_countries;
			
			$('#cardTypeNewCard').empty();
			$('#cardSchemeNewCard').empty();
			
			
			$('#cardTypeNewCard').append($('<option>', { 
				value: null,
				text : '-Select One-' 
			}));
			$('#cardSchemeNewCard').append($('<option>', { 
				value: null,
				text : '-Select One-' 
			}));
			
			$.each(all_card_type, function(key, value) {
				console.log(value);
				console.log(key);
				$('#cardTypeNewCard').append($('<option>', { 
					value: key,
					text : value
				}));
				
			});
			$.each(all_card_schemes, function(key, value) {
				console.log(value);
				console.log(key);
				$('#cardSchemeNewCard').append($('<option>', { 
					value: value.id,
					text : value.schemeName
				}));
				
			});
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}





function viewAccountCards(jwtToken, accountId, accountNumber, customerName, customerverficationnumber) {
	jwtToken = 'Bearer ' + jwtToken;
	console.log(jwtToken);
	$.ajax({
		type: "GET",
		url: "/get-account-card-list-ajax/" + accountNumber,
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				//alert(0);
				if ( $.fn.dataTable.isDataTable( '#accountcardtable' ) ) {
					table = $('#accountcardtable').DataTable();
					table.destroy();
				}
				$('#accountcardtable').DataTable({
					//"ajax": "/get-customer-list-ajax",
					"data": data.data,
					"columns": [
						{ "data": "pan" },
						{ "data": "full_name" },
						{ "data": "accountIdentifier" },
						{ "data": "serialNo" },
						{ "data": "schemeName" },
						{ "data": "cardType" },
						{ "data": "status" },
						{ "data": "cardBalance" },
						{ "data": "action", "name": 'action', "orderable": false, "searchable": false }
					]
				});
				$('#viewAccountCardsAccountNo').html(data.account.accountIdentifier);
				$('#viewAccountCardsTitle').html('Cards Belonging to Account - ' + data.account.accountIdentifier);
				
				
				$('#viewAccountCardsAddCard').on('click', function(){
					//hidenewcard('customerAccountWrapper');
					//alert(33);
					console.log(data.account);
					console.log(data.floatingBalance);
					addNewCard(accountId, accountNumber, customerName, customerverficationnumber, data.account.currencyCode, data.floatingBalance);
				});
			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}




function emptySelect(ids)
{
	ids = ids.split('###');
	for(var i=0; i<ids.length; i++)
	{
		$('#' + ids[i]).empty();
	}
}


function handleLoadProvince(provinceId, ob)
{
	var $this = $(this);
	console.log(ob);
	var province = $("#" + provinceId);
	var countryId = ob.value;
	var district = $("#district");
	//lga.html('loading...');
	$.ajax({
		url: '/utility/services/pull-province/' + countryId,
		dataType: 'json',
		success: function (resp) {
			//province.empty();
			//district.empty();

			if (resp.status === 1) {
				console.log(resp.data);
				$.each(resp.data, function (k, v) {
					console.log(k + '---' + v);
					province.append($('<option>', {
						value: k + '_' + v,
						text: v
					}));
				});
				province.prepend($('<option>', {
					text: '-Select Province-',
					value: null
				}));
				district.prepend($('<option>', {
					text: '-Select District-',
					value: null
				}));
			}
		},
		complete: function () {

		}
	});
}

function handleLoadDistrict(districtId, ob)
{
	var $this = $(this);
	var district = $("#" + districtId);
	var provinceId = ob.value.split('_');
	provinceId = provinceId[0];
	//lga.html('loading...');
	$.ajax({
		url: '/utility/services/pull-district/' + provinceId,
		dataType: 'json',
		success: function (resp) {
			district.empty();
			if (resp.status === 1) {

				$.each(resp.data, function (k, v) {
					district.append($('<option>', {
						value: k + '_' + v,
						text: v
					}));
				});
				district.prepend($('<option>', {
					text: '-Select District-',
					value: null
				}));
			}
		},
		complete: function () {

		}
	});
}




function fundAccount(accountnumber, accountname, account, tk) {

	$('#clickActor').html("Fund Account");
	$('#fundAccountAccountName').html(accountname);
	$('#fundAccountAccountNumber').html(accountnumber);
	$('#fundAccountAccountId').html(account);
}



function updateAccountStatus(status, accountId, jwtToken)
{
	jwtToken = 'Bearer ' + jwtToken;
	$.ajax({
		type: "GET",
		url: '/api/accounts/activate-wallet/' + status + '/' + accountId,
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (resp, st) {
			console.log(resp);
			if (resp.success === true) {
				toastr.success(resp.message);

				var btnGroupId = $('#btngroup' + accountId);
				var td_ = btnGroupId.parent();
				if(status===1)
					td_.prev().html('ACTIVE');
				else
					td_.prev().html('DISABLED');

				console.log(status);
				if(status===1)
				{
					$('#deactivateWalletLink'+accountId).html("<a style='cursor: pointer !important' onclick=\"updateAccountStatus(0, " + accountId + ", '" + jwtToken.substring(7) + "')\">Deactivate Account</a>");
					$('#fundWalletLink'+accountId).show();
				}
				else if(status===0)
				{
					$('#deactivateWalletLink'+accountId).html("<a style='cursor: pointer !important' onclick=\"updateAccountStatus(1, " + accountId + ", '" + jwtToken.substring(7) + "')\">Activate Account</a>");
					$('#fundWalletLink'+accountId).hide();
				}
			}
			else
			{
				if(resp.status===-1)
				{
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(resp.message);
				}
			}
		},
		error: function(xhr, desc, err){
			if(xhr.status===403)
			{
				alert('Logout');
				logoutUser('Your session has ended. Please log in to continue', window.location.href);
			}
		},
		complete: function () {

		}
	});


	console.log(jwtToken);
}


function viewCardBinIssued(jwtToken, id)
{
	jwtToken = 'Bearer ' + jwtToken;
	var url = '/api/ecards/card-bin-holder/' + id;
	$.ajax({
		type: "POST",
		url: (url),
		data: ([]),
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function handleSuccess(data1){
			console.log(data1);
			if(data1.success!=undefined) {
				if (data1.success === true) {
					//alert(33);
					if (data1.status == 100) {
						toastr.success(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					} else if (data1.status == -1) {
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					} else {
						toastr.error(data1.message);
					}
					//toastr.success(data1.message);
				} else {
					toastr.error(data1.message);
					$('#dismissBtn').click();
					$('#new_card_modal').show();
				}
			}
			else
			{
				if (data1.status == -1) {
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				} else {
					toastr.error(data1.message);
				}
			}
		},
		error: function (e) {
			toastr.error('We experienced an issue updating your merchant profile. Please try again.');
		}
	});
}




function newBankGoToStep(jwtToken, goToId, e)
{
	console.log(goToId);
	if(goToId=='stepContent2')
	{
		jwtToken = 'Bearer ' + jwtToken;
		goToId_ = goToId;
		if (($('#newBankForm').validator('validate').has('.has-error').length)) {
			//alert('SOMETHING WRONG');
			toastr.error("Provide all required information before submitting");
		} else {
			//$("#form2").submit();
			//alert('EVERYTHING IS GOOD');
			e.preventDefault();
			console.log(goToId_);
			bankId = $('#bankId').val();

			continueYes = true;

			if(continueYes===true)
			{
				console.log(goToId_);
				var url = "/api/banks/confirm-bank-exists/" + $('#bankName').val().trim();
				if($("#bankId") && $("#bankId").val()!=undefined && $("#bankId")!=null)
				{
					url = url + "/" + $('#bankId').val();
				}
				console.log(url);
				//url = url + "?token={{\Session::get('jwt_token')}}";
				$.ajax({
					type: "GET",
					url: (url),
					data: ([]),
					processData: false,
					contentType: false,
					cache: false,
					headers: {"Authorization": jwtToken},
					timeout: 600000,
					success: function handleSuccess(data1){
						console.log(data1);
						console.log(goToId_);
						if(data1.success===true)
						{
							//alert(33);
							console.log(goToId_);
							if(data1.data.status==211)
							{
								handleUpdateBankData(goToId, jwtToken);
							}
							else if(data1.data.status==-1)
							{
								console.log(window.location);
								logoutUser('Your session has ended. Please log in to continue', window.location.href);
							}
							else
							{
								toastr.error(data1.data.message);
							}
							//toastr.success(data1.message);
						}
						else
						{
							toastr.error(data1.message);
						}
					},
					error: function (e) {
						toastr.error('We experienced an issue creating/updating your bank profile. Please try again.');
					}
				});
			}
		}
	}


}


function updateSettingsGoToStep(jwtToken, goToId, e)
{
	console.log(goToId);
	if(goToId=='stepContent2')
	{
		jwtToken = 'Bearer ' + jwtToken;
		goToId_ = goToId;
		if (($('#newSettingsForm').validator('validate').has('.has-error').length)) {
			//alert('SOMETHING WRONG');
			toastr.error("Provide all required information before submitting");
		} else {
			//$("#form2").submit();
			//alert('EVERYTHING IS GOOD');
			e.preventDefault();
			console.log(goToId_);

			continueYes = true;

			if(continueYes===true)
			{
				console.log(goToId_);
				var form = $('#newSettingsForm')[0];
				var formData = new FormData(form);
				var url = '/api/settings/update-settings';
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
						console.log(goToId_);
						if(data1.success!=undefined && data1.success===true)
						{
							//alert(33);
							console.log(goToId_);
							toastr.success(data1.message);
							var goToId = '#'+goToId;
							console.log(goToId);
							window.location = '/potzr-staff/view-settings';
							logoutUser('Your session has ended. Please log in for the changes to take effect', window.location.href);

						}
						else
						{
							if(data1.status===-1)
							{
								console.log(window.location);
								logoutUser('Your session has ended. Please log in to continue', window.location.href);
							}
							else
							{
								toastr.error(data1.message);
							}
						}
					},
					error: function (e) {
						toastr.error('We experienced an issue creating/updating your bank. Please try again.');
					}
				});
			}
		}
	}


}



function createNewCustomer(formId)
{
	var formId = '#' + formId;
	var form = $(formId)[0];
	var formData = new FormData(form);
	var url = '/api/customer-register';
	$.ajax({
		type: "POST",
		url: (url),
		data: (formData),
		processData: false,
		contentType: false,
		cache: false,
		timeout: 600000,
		success: function handleSuccess(data1){
			console.log(data1);
			if(data1.success!=undefined && data1.success===true)
			{
				//alert(33);
				toastr.success(data1.message);
				window.location = '/auth/login';
			}
			else
			{
				toastr.error(data1.message);
			}
		},
		error: function (e) {
			toastr.error('We experienced an issue setting up a new Bevura account for you. Please try again.');
		}
	});
}




function createNewCustomerForBillPayment(formId)
{
	if(loginToPayLinkCount%2==0)
	{
		toggleLoading();
		loginToPayLinkCount++;
	
		var formId = '#' + formId;
		var form = $(formId)[0];
		var formData = new FormData(form);
		var url = '/api/customer-register';
		var orderId = $('#orderId').val();
		var data = $('#data').val();
		console.log([data, orderId]);
		//var $modalDashboard = $('#ajaxPaymentDetailsListMenuModal');
		var $modalDashboard = $('#ajaxPaymentOptionDetailsListMenuModal');

		$.ajax({
			type: "POST",
			url: (url),
			data: (formData),
			processData: false,
			contentType: false,
			cache: false,
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				if(data1.success!=undefined && data1.success===true)
				{
					url = '/ajax-pay-from-logged-in-new-wallet-success.html/102/'+ data +'/' + orderId;
					setTimeout(function(){
								
						console.log(url);
						 $modalDashboard.load(url, '', function(){
							$modalDashboard.modal();
							if(document.getElementById("loginToPayOtp1"))
								document.getElementById("loginToPayOtp1").focus();
							handleNotifications();
						});
					}, 1000);
				}
				else
				{
					toggleLoading();
					loginToPayLinkCount++;
					toastr.error(data1.message);
				}
			},
			error: function (e) {
				toggleLoading();
				loginToPayLinkCount++;
				toastr.error('We experienced an issue setting up a new Bevura account for you. Please try again.');
			}
		});
	}
}


function createNewCustomerWalletForBillPayment(formId, jwtToken, input, orderId, key)
{
	jwtToken = 'Bearer ' + jwtToken;
	var form = $('#' + formId)[0];

		var formData = new FormData(form);
		var url = '/api/accounts/add-new-account-and-default-card';
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
					var $modalDashboard = $('#ajaxPaymentOptionDetailsListMenuModal');

					if(key!=null && key=='040')
					{
						url = '/ajax-pay-from-logged-in-new-wallet-success.html/040/'+ input +'/' + data1.data.accountIdentifier + '-' + data1.data.customerNumber;
						setTimeout(function(){
								
							console.log(url);
							$modalDashboard.load(url, '', function(){
								$modalDashboard.modal();
								if(document.getElementById("loginToPayOtp1"))
									document.getElementById("loginToPayOtp1").focus();
								handleNotifications();
							});
						}, 1000);

					}
					else if(key!=null && key=='050')
					{
						url = '/ajax-pay-from-logged-in-tokenize.html/050/' + input + '/' + orderId;
						setTimeout(function(){
							console.log(url);
							$modalDashboard.load(url, '', function(){
								$modalDashboard.modal();
								//document.getElementById("loginToPayOtp1").focus();
								handleNotifications();
							});
						}, 1000);
					}
					else
					{


						var url = '/ajax-pay-from-logged-in-wallet.html/007/' + input + '/' + orderId;
						//var $modalDashboard = $('#ajaxPaymentDetailsListMenuModal');
						var $modalDashboard = $('#ajaxPaymentOptionDetailsListMenuModal');
						$(document).ready(function(){

                       		 		//$modal.modal('hide');
                        				//$modalForgotPassword.modal('hide');

                        				//$('body').modalmanager('loading');

                        				setTimeout(function(){
                            			console.log(url);
                             				$modalDashboard.load(url, '', function(){
                                					$modalDashboard.modal();
                                					if(document.getElementById("loginToPayOtp1"))
                                    					document.getElementById("loginToPayOtp1").focus();
                                					handleNotifications();
                            				});
                        				}, 1000);
                    				});
					}
				}
				else
				{
					//toastr.error(data1.message!=undefined && data1.message!=null ? data1.message : 'We experienced an issue updating your merchant profile. Please try again.');
					if(data1.respData!=null && data1.respData.status==900)
					{
						var $modalDashboard = $('#ajaxPaymentOptionDetailsListMenuModal');
						$(document).ready(function(){
							url = '';
							url = '/ajax-otp-collection-and-create-wallet-view.html/5081/' + data1.customerVerificationNo + '/' + data1.input.data + '/' + data1.respData.token;
							console.log(url);
							$modalDashboard.load(url, '', function(){
								$modalDashboard.modal();
								if(document.getElementById("loginToPayOtp1"))
									document.getElementById("loginToPayOtp1").focus();
								handleNotifications();
							});
						});
					}
					else
					{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					}

				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});

}




function newIssuerGoToStep(jwtToken, goToId, e)
{
	console.log(goToId);
	if(goToId=='stepContent2')
	{
		jwtToken = 'Bearer ' + jwtToken;
		goToId_ = goToId;
		if (($('#newIssuerForm').validator('validate').has('.has-error').length)) {
			//alert('SOMETHING WRONG');
			toastr.error("Provide all required information before submitting");
		} else {
			//$("#form2").submit();
			//alert('EVERYTHING IS GOOD');
			e.preventDefault();
			console.log(goToId_);
			issuerId = $('#issuerId').val();
			var continueYes = true;
			

			if(continueYes===true)
			{
				console.log(goToId_);
				var url = "/api/issuers/confirm-issuer-exists/" + $('#issuerName').val().trim() + "/" + $('#issuerCode').val().trim();
				if($("#issuerId") && $("#issuerId").val()!=undefined && $("#issuerId")!=null)
				{
					url = url + "/" + $('#issuerId').val();
				}
				console.log(url);
				//url = url + "?token={{\Session::get('jwt_token')}}";
				$.ajax({
					type: "GET",
					url: (url),
					data: ([]),
					processData: false,
					contentType: false,
					cache: false,
					headers: {"Authorization": jwtToken},
					timeout: 600000,
					success: function handleSuccess(data1){
						console.log(data1);
						console.log(goToId_);
						if(data1.success===true)
						{
							//alert(33);
							console.log(goToId_);
							if(data1.data.status==211)
							{
								handleUpdateIssuerData(goToId, jwtToken);
							}
							else if(data1.data.status==-1)
							{
								console.log(window.location);
								logoutUser('Your session has ended. Please log in to continue', window.location.href);
							}
							else
							{
								toastr.error(data1.data.message);
							}
							//toastr.success(data1.message);
						}
						else
						{
							toastr.error(data1.message);
						}
					},
					error: function (e) {
						toastr.error('We experienced an issue creating/updating your bank profile. Please try again.');
					}
				});
			}
		}
	}


}


function handleUpdateBankData(goToId, jwtToken)
{
	var form = $('#newBankForm')[0];
	var formData = new FormData(form);
	var url = '/api/banks/create-bank-data';
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
			console.log(goToId_);
			if(data1.success===true)
			{
				//alert(33);
				console.log(goToId_);
				//alert(data1.status);
				if(data1.status===100)
				{
					toastr.success(data1.message);
					var goToId = '#'+goToId;
					console.log(goToId);
					window.location = '/potzr-staff/banks/bank-listing';
				}
				else if(data1.status===-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data1.message);
				}
				//toastr.success(data1.message);
			}
			else
			{
				toastr.error(data1.message);
			}
		},
		error: function (e) {
			toastr.error('We experienced an issue creating/updating your bank. Please try again.');
		}
	});
}


function handleUpdateIssuerData(goToId, jwtToken)
{
	var form = $('#newIssuerForm')[0];
	var formData = new FormData(form);
	var url = '/api/issuers/create-issuer-data';
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
			console.log(goToId_);
			if(data1.success===true)
			{
				//alert(33);
				console.log(goToId_);
				//alert(data1.status);
				if(data1.status===100)
				{
					toastr.success(data1.message);
					var goToId = '#'+goToId;
					console.log(goToId);
					window.location = '/potzr-staff/issuers/issuer-listing';
				}
				else if(data1.status===-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data1.message);
				}
				//toastr.success(data1.message);
			}
			else
			{
				toastr.error(data1.message);
			}
		},
		error: function (e) {
			toastr.error('We experienced an issue creating/updating your issuer. Please try again.');
		}
	});
}



function viewUserList(jwtToken, urole)
{

	jwtToken = 'Bearer ' + jwtToken;
	console.log(jwtToken);

	var url = "/api/users/get-user-list-ajax/" + urole;
	if(urole=='agent')
		url = "/api/get-agent-list-ajax";


	console.log(url);
	
	$.ajax({
		type: "GET",
		url: url,
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			var dtstatus = false;
			var dt = null;
			if(urole=='agent' && data.status==5000)
			{
				dtstatus = true;
				dt = data.agentlist;
			}
			else if(data.success===true) {
				dtstatus = true;
				dt = data.data;
			}


			if(dtstatus==true)
			{
				data = dt;
					//alert(0);

				if ($.fn.dataTable.isDataTable('#allUsersTable')) {
					table = $('#allUsersTable').DataTable();
					table.destroy();
				}
				console.log(data);

				if(urole=='agent')
				{
					$('#allUsersTable').DataTable({
						//"ajax": "/get-customer-list-ajax",
						"data": data,
						"columns": [
							{"data": "fullName"},
							{"data": "username"},
							{"data": "mobile_number"},
							{"data": "email_address"},
							{"data": "role"},
							{"data": "status"},
							{"data": "action", "name": 'action', "orderable": false, "searchable": false}
						]
					});
				}
				else
				{
					$('#allUsersTable').DataTable({
						//"ajax": "/get-customer-list-ajax",
						"data": data,
						"columns": [
							{"data": "full_name"},
							{"data": "username"},
							{"data": "mobile_number"},
							{"data": "email_address"},
							{"data": "role"},
							{"data": "status"},
							{"data": "action", "name": 'action', "orderable": false, "searchable": false}
						]
					});
				}

				if(urole!=undefined && urole=='bank-staff')
					$('#userlistTitle').html('All Issuer Staff');
				else if(urole!=undefined && urole=='merchant')
					$('#userlistTitle').html('All Merchant Users');
				else if(urole!=undefined && urole=='admin-staff')
					$('#userlistTitle').html('All Administrators');
				else if(urole!=undefined && urole=='potzr-staff')
					$('#userlistTitle').html("All Super Administrators");
				else if(urole!=undefined && urole=='accountants')
					$('#userlistTitle').html("All Accountants");
				else if(urole!=undefined && urole=='customers')
					$('#userlistTitle').html("All Customers");

			}
			else
			{
				toastr.error(dt.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}


function getApplicationSettings(jwtToken)
{
	jwtToken = 'Bearer ' + jwtToken;
	console.log(jwtToken);
	$.ajax({
		type: "GET",
		url: "/api/settings/get-application-settings-ajax",
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.success===true) {
				$('#minimumTransactionAmountWeb').val(data.data.settingJSON.minimumtransactionamountweb);
				$('#maximumTransactionAmountWeb').val(data.data.settingJSON.maximumtransactionamountweb);
				$('#cyberSourceAccessKey').val(data.data.settingJSON.cybersourceaccesskey);
				$('#cyberSourceProfileId').val(data.data.settingJSON.cybersourceprofileid);
				$('#cyberSourceSecretKey').val(data.data.settingJSON.cybersourcesecretkey);
				$('#cyberSourceLocale').val(data.data.settingJSON.cybersourcelocale);
				$('#cyberSourceDemoAccessKey').val(data.data.settingJSON.cybersourcedemoaccesskey);
				$('#cyberSourceDemoProfileId').val(data.data.settingJSON.cybersourcedemoprofileid);
				$('#cyberSourceDemoSecretKey').val(data.data.settingJSON.cybersourcedemosecretkey);
				$('#cyberSourceDemoLocale').val(data.data.settingJSON.cybersourcedemolocale);
			}
			else
			{
				if(data.status==-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}



function readApplicationSettings(jwtToken)
{
	jwtToken = 'Bearer ' + jwtToken;
	console.log(jwtToken);
	$.ajax({
		type: "GET",
		url: "/api/settings/get-application-settings-ajax",
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.success===true) {
				$('#minimumTransactionAmountWeb').html(data.data.settingJSON.minimumtransactionamountweb);
				$('#maximumTransactionAmountWeb').html(data.data.settingJSON.maximumtransactionamountweb);
				$('#cyberSourceAccessKey').html(data.data.settingJSON.cybersourceaccesskey);
				$('#cyberSourceProfileId').html(data.data.settingJSON.cybersourceprofileid);
				$('#cyberSourceSecretKey').html(data.data.settingJSON.cybersourcesecretkey);
				$('#cyberSourceLocale').html(data.data.settingJSON.cybersourcelocale);
				$('#cyberSourceDemoAccessKey').html(data.data.settingJSON.cybersourcedemoaccesskey);
				$('#cyberSourceDemoProfileId').html(data.data.settingJSON.cybersourcedemoprofileid);
				$('#cyberSourceDemoSecretKey').html(data.data.settingJSON.cybersourcedemosecretkey);
				$('#cyberSourceDemoLocale').html(data.data.settingJSON.cybersourcedemolocale);

				$('#cardsupport').html(data.data.settingJSON.cardsupport==1 ? "Yes" : "No");
				$('#zescoTransientAccountId').html(data.data.settingJSON.zescoTransientAccountId);
				$('#payMerchantTransientAccountId').html(data.data.settingJSON.payMerchantTransientAccountIds);
				$('#fundsTransferTransientAccountId').html(data.data.settingJSON.fundsTransferTransientAccountId);
				$('#cableTvTransientAccountId').html(data.data.settingJSON.cableTvTransientAccountId);
				$('#walletFundingTransientAccountId').html(data.data.settingJSON.walletFundingTransientAccountId);
			}
			else
			{
				if(data.status==-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}



function handleWalletOverview(jwtToken)
{
	console.log(jwtToken)
	var url = "/api/get-customer-account-by-user-ajax";
	$.ajax({
		type: "GET",
		url:  url,
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": "Bearer " + jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==110)
			{
				console.log(data.customer);
				console.log(data.data);
				$(".allfloater").fadeOut();
				$("#wallet_overview_modal").fadeIn();

			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				toastr.error(data.message);
			}
		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}



function loadFTModal(jwtToken)
{
	jwtToken = 'Bearer ' + jwtToken;
	var url = '/api/get-customer-statistics';
	$.ajax({
		type: "GET",
		url: (url),
		data: ([]),
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function handleSuccess(data1){
			console.log(data1);
			if(data1.success!=undefined && data1.success===true)
			{
				//alert(33);
				if(data1.status==100)
				{
					cards = data1.cards;
					$('#fundsTransferTransferFromCard').empty();


					$('#fundsTransferTransferFromCard').append($('<option>', {
						value: null,
						text : '-Select One-'
					}));
					$.each(cards, function(key, value) {
						console.log(value);
						console.log(key);
						currencies = ['ZMW', 'TZS'];
						accountCurrency = currencies[value.currency];
						console.log(value.currency);
						$('#fundsTransferTransferFromCard').append($('<option>', {
							value: value.serialNo + '|||' + value.trackingNumber + '|||' + value.nameOnCard + '|||' + value.pan + '|||' + accountCurrency,
							text : value.nameOnCard + ' - ' + value.pan + ' (Balance on Card: ' + accountCurrency + '' + value.cardBalance.toFixed(2) + ')'
						}));

					});
				}
				else if(data1.status==-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data1.message);
				}
				//toastr.success(data1.message);
			}
			else
			{
				toastr.error(data1.message);
				$('#dismissBtn').click();
				$('#new_card_modal').show();

				if(data1.status==-1)
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
			}
		},
		error: function (e) {
			toastr.error('We experienced an issue updating your merchant profile. Please try again.');
		}
	});
}


function doFundsTransferToMultipleReceipients(jwtToken)
{
	var url = '/api/ft/do-funds-transfer';
	var form = $('#ftformToBeneficiary')[0];
	var formData = new FormData(form);

	$.ajax({
		type: "POST",
		url: (url),
		data: (formData),
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": 'Bearer ' + jwtToken},
		timeout: 600000,
		success: function handleSuccess(data1){
			console.log(data1);
			if(data1.success===true)
			{
				//alert(33);
				if(data1.status!=undefined && data1.status==100)
				{
					toastr.success(data1.message);
					validationToken = data1.validationToken;
					otpRef = data1.otpRef;
					customerInfo = data1.customerInfo;

					$('#utilitybillformpurchase').hide();
					$('#utilitybillformpurchasesteptwo').show();
					$('#utilityDivStepTwoType').html($('#utilityBillType').val());
					cardDetails = $('#utilityBillPayFrom').val();
					cardDetails = cardDetails.split("|||");
					console.log(cardDetails[4] + "" + parseFloat($('#utilityBillAmount').val()).toFixed(2));
					$('#utilityBillDivStepTwoAmount').html(cardDetails[4] + "" + parseFloat($('#utilityBillAmount').val()).toFixed(2));
					currency = cardDetails[4]
					cardDetails = currency + " - " + cardDetails[3];
					$('#utilityBillDivStepTwoCard').html(cardDetails);
					$('#utilityBillDivStepTwoMeterNo').html($('#utilityBillMeterNo').val());
					$('#utilityBillDivStepTwoSmartCardNumber').html($('#smartCardNumber').val());
					$('#utilityBillDivStepTwoTelco').html($('#utilityBillAirtimeNetwork').val());
					$('#utilityBillDivStepDSTVProduct').html($('#utilityBillDSTVProduct').val());
					$('#utilityBillDivStepTwoAirtimeReceipientNo').html($('#utilityBillAirtimeReceipientNumber').val());
					$('#utilityBillDivStepTwoValidationToken').val(validationToken);
					$('#otpRef').val(otpRef);
					$('#utilityBillDescription').html("Step Two - Confirm, Provide OTP & Pay");

					if($('#utilityBillType').val()=='ELECTRICITY') {
						$('#utilityBillDivStepTwoCustomerAccountNo').html(customerInfo.customer_data.customer_account_no);
						$('#utilityBillDivStepTwoCustomerAccountAddress').html(customerInfo.customer_data.customer_address);
						$('#utilityBillDivStepTwoCustomerAccountName').html(customerInfo.customer_data.customer_name);
					}
					if($('#utilityBillType').val()=='DSTV') {
						$('#utilityBillDivStepDSTVProduct').html($('#utilityBillDSTVProduct').val().replace('_', ' '));
						$('#utilityBillDivStepTwoDSTVDue').html(currency + '' + customerInfo.amount_due);
						$('#utilityBillDivStepTwoCustomerAccountName').html(customerInfo.customer_name + ' ' + customerInfo.customer_surname);
					}
					if($('#utilityBillType').val()=='TOPSTAR') {
						$('#utilityBillDivStepTwoCustomerAccountNo').html(customerInfo.customer_data.customer_account_no);
						$('#utilityBillDivStepTwoCustomerAccountAddress').html(customerInfo.customer_data.customer_address);
						$('#utilityBillDivStepTwoCustomerAccountName').html(customerInfo.customer_data.customer_name);
					}
					if($('#utilityBillType').val()=='AIRTIME') {
						$('#utilityBillDivStepTwoCustomerAccountNo').html(customerInfo.customer_data.customer_account_no);
						$('#utilityBillDivStepTwoCustomerAccountAddress').html(customerInfo.customer_data.customer_address);
						$('#utilityBillDivStepTwoCustomerAccountName').html(customerInfo.customer_data.customer_name);
					}
				}
				else if(data1.status!=undefined && data1.status==-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data1.message);
				}
				//toastr.success(data1.message);
			}
			else
			{
				if(data1.status!=undefined && data1.status==-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data1.message);
				}
			}
		},
		error: function (e) {
			toastr.error('We experienced an issue updating your merchant profile. Please try again.');
		}
	});
}

$('#fundsTransferTransferReceipientType').on('change', function(){
	$('.fundsTransferTransferReceipientTypeComponent').hide();
	console.log($('#fundsTransferTransferReceipientType').val());
	if($('#fundsTransferTransferReceipientType').val()=='BANK')
		$('.transferToBank').show();
	if($('#fundsTransferTransferReceipientType').val()=='MOBILE')
		$('.transferToMobile').show();
	if($('#fundsTransferTransferReceipientType').val()=='BEVURA WALLET')
		$('.transferToWallet').show();
});


$('#internalFundsTransferTransferType').on('change', function(){
	$('.receipientCardDiv').hide();
	console.log($('#internalFundsTransferTransferType').val());
	if($('#internalFundsTransferTransferType').val()=='WALLET_TO_CARD')
		$('.receipientCardDiv').show();
	if($('#internalFundsTransferTransferType').val()=='CARD_TO_CARD') {
		$('.receipientCardDiv').show();
	}
})


$('#utilityBillType').on('change', function(){
	$('.utilityDiv').hide();
	$('.utilityAccountDetailsDiv').hide();
	$('.utilityAccountDetails').html("");
	console.log($('#utilityBillType').val());
	if($('#utilityBillType').val()=='TOPSTAR') {
		$('.topstar ').show();
		$('#submitUtilityFormButtonValidate').html("Validate Smart Card Number Number");
		$('#utilityBillDescription').html("Step One - Validate Smart Card Number");
	}
	if($('#utilityBillType').val()=='ELECTRICITY') {
		$('.electricity').show();
		$('#submitUtilityFormButtonValidate').html("Validate Meter Number");
		$('#utilityBillDescription').html("Step One - Validate Meter Number");
	}
	if($('#utilityBillType').val()=='AIRTIME') {
		$('.airtime').show();
		$('#submitUtilityFormButtonValidate').html("Validate Mobile Number");
		$('#utilityBillDescription').html("Step One - Validate Receipients Mobile Number");
	}
	if($('#utilityBillType').val()=='DSTV') {
		$('.dstvDiv').show();
		$('#submitUtilityFormButtonValidate').html("Validate Account Number");
		$('#utilityBillDescription').html("Step One - Validate Decoder Number");
	}
})


function validateReceipient(jwtToken)
{
	var url = '/api/validate-utility-meter';
	var form = $('#utilitybillformpurchase')[0];
	var formData = new FormData(form);

	$.ajax({
		type: "POST",
		url: (url),
		data: (formData),
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": 'Bearer ' + jwtToken},
		timeout: 600000,
		success: function handleSuccess(data1){
			console.log(data1);
			if(data1.success===true)
			{
				//alert(33);
				if(data1.status!=undefined && data1.status==100)
				{
					toastr.success(data1.message);
					validationToken = data1.validationToken;
					otpRef = data1.otpRef;
					customerInfo = data1.customerInfo;

					$('#utilitybillformpurchase').hide();
					$('#utilitybillformpurchasesteptwo').show();
					$('#utilityDivStepTwoType').html($('#utilityBillType').val());
					cardDetails = $('#utilityBillPayFrom').val();
					cardDetails = cardDetails.split("|||");
					console.log(cardDetails[4] + "" + parseFloat($('#utilityBillAmount').val()).toFixed(2));
					$('#utilityBillDivStepTwoAmount').html(cardDetails[4] + "" + parseFloat($('#utilityBillAmount').val()).toFixed(2));
					currency = cardDetails[4]
					cardDetails = currency + " - " + cardDetails[3];
					$('#utilityBillDivStepTwoCard').html(cardDetails);
					$('#utilityBillDivStepTwoMeterNo').html($('#utilityBillMeterNo').val());
					$('#utilityBillDivStepTwoSmartCardNumber').html($('#smartCardNumber').val());
					$('#utilityBillDivStepTwoTelco').html($('#utilityBillAirtimeNetwork').val());
					$('#utilityBillDivStepDSTVProduct').html($('#utilityBillDSTVProduct').val());
					$('#utilityBillDivStepTwoAirtimeReceipientNo').html($('#utilityBillAirtimeReceipientNumber').val());
					$('#utilityBillDivStepTwoValidationToken').val(validationToken);
					$('#otpRef').val(otpRef);
					$('#utilityBillDescription').html("Step Two - Confirm, Provide OTP & Pay");

					if($('#utilityBillType').val()=='ELECTRICITY') {
						$('#utilityBillDivStepTwoCustomerAccountNo').html(customerInfo.customer_data.customer_account_no);
						$('#utilityBillDivStepTwoCustomerAccountAddress').html(customerInfo.customer_data.customer_address);
						$('#utilityBillDivStepTwoCustomerAccountName').html(customerInfo.customer_data.customer_name);
					}
					if($('#utilityBillType').val()=='DSTV') {
						$('#utilityBillDivStepDSTVProduct').html($('#utilityBillDSTVProduct').val().replace('_', ' '));
						$('#utilityBillDivStepTwoDSTVDue').html(currency + '' + customerInfo.amount_due);
						$('#utilityBillDivStepTwoCustomerAccountName').html(customerInfo.customer_name + ' ' + customerInfo.customer_surname);
					}
					if($('#utilityBillType').val()=='TOPSTAR') {
						$('#utilityBillDivStepTwoCustomerAccountNo').html(customerInfo.customer_data.customer_account_no);
						$('#utilityBillDivStepTwoCustomerAccountAddress').html(customerInfo.customer_data.customer_address);
						$('#utilityBillDivStepTwoCustomerAccountName').html(customerInfo.customer_data.customer_name);
					}
					if($('#utilityBillType').val()=='AIRTIME') {
						$('#utilityBillDivStepTwoCustomerAccountNo').html(customerInfo.customer_data.customer_account_no);
						$('#utilityBillDivStepTwoCustomerAccountAddress').html(customerInfo.customer_data.customer_address);
						$('#utilityBillDivStepTwoCustomerAccountName').html(customerInfo.customer_data.customer_name);
					}
				}
				else if(data1.status!=undefined && data1.status==-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data1.message);
				}
				//toastr.success(data1.message);
			}
			else
			{
				if(data1.status!=undefined && data1.status==-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data1.message);
				}
			}
		},
		error: function (e) {
			toastr.error('We experienced an issue validating. Please ensure you provide valid information.');
		}
	});
}



function purchaseUtility(jwtToken)
{
	var url = '';
	if($('#utilityBillType').val()=='WATER') {
		url = '/api/purchase-water';
	}
	if($('#utilityBillType').val()=='ELECTRICITY') {
		url = '/api/purchase-electricity';
	}
	if($('#utilityBillType').val()=='AIRTIME') {
		url = '/api/purchase-airtime';
	}
	if($('#utilityBillType').val()=='DSTV') {
		url = '/api/purchase-dstv';
	}
	/*var form = $('#utilitybillformpurchasesteptwo')[0];
	//var formData = new FormData(form);

	//var form1 = $('#utilitybillformpurchase')[0];
	//var formData1 = new FormData(form1);*/

	var formData = new FormData(document.forms['utilitybillformpurchasesteptwo']); // with the file input
	var poData = jQuery(document.forms['utilitybillformpurchase']).serializeArray();
	for (var i=0; i<poData.length; i++)
		formData.append(poData[i].name, poData[i].value);

	formData.append("channel", "WEB");

	console.log(formData)

	$.ajax({
		type: "POST",
		url: (url),
		data: (formData),
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": 'Bearer ' + jwtToken},
		timeout: 600000,
		success: function handleSuccess(data1){
			console.log(data1);
			if(data1.success===true)
			{
				//alert(33);
				if(data1.status!=undefined && data1.status==100)
				{
					toastr.success(data1.message);
					$('.os-icon-close').click();
					location.reload();
				}
				else if(data1.status!=undefined && data1.status==-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data1.message);
				}
				//toastr.success(data1.message);
			}
			else
			{
				if(data1.status!=undefined && data1.status==-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data1.message);
				}
			}
		},
		error: function (e) {
			toastr.error('We experienced an issue updating your merchant profile. Please try again.');
		}
	});
}






function newWallet(token)
{
	$('#wallet_overview_modal').hide();
}




//CUSTOMER
function handleNewCard(jwtToken, e, form1, form2)
{

	jwtToken = 'Bearer ' + jwtToken;
	e.preventDefault();
	form1 = $('#' + form1)[0];
	console.log(form1);
	var formData = new FormData(form1);
	console.log(form2);
	if(form2!=undefined) {
		form2 = $('#' + form2)[0];
		console.log(form2);
		var formData2 = new FormData(form2);
		console.log(formData2);
		if (($(form2).validator('validate').has('.has-error').length)) {
			toastr.error("Provide all required information before submitting");
		} else {

			for (var pair of formData2.entries()) {
				console.log(pair[0]);
				console.log(pair[1]);
				formData.append(pair[0], pair[1]);
			}
		}
	}/**/
	console.log(formData);

	var url = '/api/new-customer-wallet';
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
				if(data1.status!=undefined && data1.status==100)
				{
					toastr.success(data1.message);
					$('.close').click();
				}
				else if(data1.status!=undefined && data1.status==-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data1.message);
				}
				//toastr.success(data1.message);
			}
			else
			{
				if(data1.status!=undefined && data1.status==-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data1.message);
				}
			}
		},
		error: function (e) {
			toastr.error('We experienced an issue updating your merchant profile. Please try again.');
		}
	});
}


function handleAddNewCard(accountIdentifier, jwtToken, e, form1)
{

	jwtToken = 'Bearer ' + jwtToken;
	e.preventDefault();
	form1 = $('#' + form1)[0];
	console.log(form1);
	var formData = new FormData(form1);
	formData.append('accountIdentifier', accountIdentifier);

	console.log(formData);

	var url = '/api/new-customer-card';
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
				if(data1.status!=undefined && data1.status==100)
				{
					toastr.success(data1.message);
					$('.close').click();
					window.location = '/cards-overview';
				}
				else if(data1.status!=undefined && data1.status==-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data1.message);
				}
				//toastr.success(data1.message);
			}
			else
			{
				if(data1.status!=undefined && data1.status==-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data1.message);
				}
			}
		},
		error: function (e) {
			toastr.error('We experienced an issue updating your merchant profile. Please try again.');
		}
	});
}



function loadAccountOverview(jwtToken, accountId)
{

	console.log(jwtToken);
	console.log(accountId);
	jwtToken = 'Bearer ' + jwtToken;
	$.ajax({
		type: "GET",
		url: "/api/get-account-overview-ajax/" + accountId,
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			data = (data.data);
			console.log(data.accountBalance);
			$('#overViewAvailableBalance').html(format_number_for_amount(data.accountBalance.availableBalance) + "<sup><small>" + data.accountBalance.accountCurrency + "</small></sup>" + "")
			$('#overViewCurrentBalance').html(format_number_for_amount(data.accountBalance.currentBalance) + "<sup><small>" + data.accountBalance.accountCurrency  + "</small></sup>" + "")
			$('#todaysBill').html(format_number_for_amount(0) + "<sup><small>" + data.accountBalance.accountCurrency  + "</small></sup>" + "")
			$('.defaultTransferCurrency').html(data.accountBalance.accountCurrency)

		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}



function transferToMyCardFromMyWallet(formId, inputData, orderRef, jwtToken)
{
	jwtToken1 = 'Bearer ' + jwtToken;
	var form = $('#' + formId)[0];
	var formData = new FormData(form);
	var url = '/api/ft/transfer-wallet-to-card';
	$.ajax({
		type: "POST",
		url: (url),
		data: (formData),
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken1},
		timeout: 600000,
		success: function handleSuccess(data1){
			console.log(data1);
			if(data1.success===true)
			{

				if(data1.status===100)
				{
					//alert(33);
					window.location = '/ajax-payment-fund-card-from-wallet-transfer-success.html/103/' + inputData + '/' + orderRef +
						'/' + data1.newBalance + '/' + 'Card' + '/' + data1.receipientInfo + '/' + data1.amountTransferred + '/' + data1.transferOrderRef
				}
				else if(data1.status===-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data1.message);
				}
			}
			else
			{
				toastr.error(data1.message);
			}
		},
		error: function (e) {
			toastr.error('We experienced an issue creating/updating your bank. Please try again.');
		}
	});
}

function loadCardsOverview(jwtToken, accountId)
{

	console.log(jwtToken);
	console.log(accountId);
	jwtToken = 'Bearer ' + jwtToken;
	$.ajax({
		type: "GET",
		url: "/api/get-account-overview-ajax/" + accountId,
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			data = (data.data);
			console.log(data.accountBalance.cardsListing);
			cardsListing = (data.accountBalance.cardsListing);
			var totalMoneyOnCards = 0.00;
			for(var i2=0; i2<cardsListing.length; i2++)
			{
				totalMoneyOnCards = totalMoneyOnCards + cardsListing[i2].cardBalance;
			}
			$('#overViewCardsFundInCards').html(format_number_for_amount(totalMoneyOnCards) + "<sup><small>" + data.accountBalance.accountCurrency + "</small></sup>" + "")
			$('#overViewCardsAvailableFundsInWallet').html(format_number_for_amount(data.accountBalance.availableBalance) + "<sup><small>" + data.accountBalance.accountCurrency  + "</small></sup>" + "")
			$('#overViewCardsTodaysBill').html(format_number_for_amount(0) + "<sup><small>" + data.accountBalance.accountCurrency  + "</small></sup>" + "")
			$('.defaultTransferCurrency').html(data.accountBalance.accountCurrency)

		},
		error: function (e) {
			console.error(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}






function transferWalletToCard(jwtToken)
{
	var card = $('#cardAccountOverViewTransferToCard').val();
	var amt = $('#amountAccountOverViewTransferToCard').val();

	if(card!=undefined && card!=null && amt!=undefined && amt!=null)
	{
		amt = parseFloat(amt);
		if(amt>0) {
			amt = amt.toFixed(2);

			console.log(jwtToken);
			jwtToken1 = 'Bearer ' + jwtToken;
			var form = $('#accountOverViewTransferToCardForm')[0];
			var formData = new FormData(form);
			var url = '/api/ft/transfer-wallet-to-card';
			$.ajax({
				type: "POST",
				url: (url),
				data: (formData),
				processData: false,
				contentType: false,
				cache: false,
				headers: {"Authorization": jwtToken1},
				timeout: 600000,
				success: function handleSuccess(data1){
					console.log(data1);
					if(data1.success===true)
					{

						if(data1.status===100)
						{
							loadAccountOverview(jwtToken, data1.accountIdentifier);
							toastr.success(data1.message);
							$('#amountAccountOverViewTransferToCard').val("")
						}
						else if(data1.status===-1)
						{
							console.log(window.location);
							logoutUser('Your session has ended. Please log in to continue', window.location.href);
						}
						else
						{
							toastr.error(data1.message);
							loadAccountOverview(jwtToken, data1.accountIdentifier);
						}
					}
					else
					{
						toastr.error(data1.message);
						loadAccountOverview(jwtToken, data1.accountIdentifier);
					}
				},
				error: function (e) {
					toastr.error('We experienced an issue creating/updating your bank. Please try again.');
				}
			});
		}
		else
		{
			toastr.error('Invalid amount. Your amount must be greater than zero');
		}
	}
	else
	{
		toastr.error('Invalid selection. Select a valid card to credit');
	}
}


function handleGoToWalletOverViewPage(jwtToken)
{
	$.ajax({
		type: "GET",
		url: "/api/get-customer-statistics",
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": 'Bearer ' + jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				window.location = '/wallet-overview';
			}
			else
			{
				$("#walletOverviewLink").removeAttr("href");
				$("#walletOverviewLink").removeAttr("data-toggle");
				$("#walletOverviewLink").removeAttr("data-target");
				$("#walletOverviewLink").removeAttr("onclick");
				$("#walletOverviewLink").attr("data-toggle",'modal');
				$("#walletOverviewLink").attr("data-target",'#wallet_overview_modal');
				$('#walletOverviewLink').click();
				handleWalletOverview(jwtToken);
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error("We are experiencing a few issues getting your list of customers");
		}
	});

}



function handleGoToCardOverViewPage(jwtToken)
{
	$.ajax({
		type: "GET",
		url: "/api/get-customer-statistics",
		data: [],
		processData: false,
		contentType: false,
		headers: {"Authorization": 'Bearer ' + jwtToken},
		cache: false,
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				//alert(33);
				window.location = '/cards-overview';
			}
			else
			{
				$("#cardOverviewLink").removeAttr("href");
				$("#cardOverviewLink").removeAttr("data-toggle");
				$("#cardOverviewLink").removeAttr("data-target");
				$("#cardOverviewLink").removeAttr("onclick");
				$("#cardOverviewLink").attr("data-toggle",'modal');
				$("#cardOverviewLink").attr("data-target",'#card_overview_modal');
				$('#cardOverviewLink').click();
				handleWalletOverview(jwtToken);
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error("We are experiencing a few issues getting your list of customers");
		}
	});

}


$('#internalFundsTransferTransferType').on('change', function(){
	var transferType = $('#internalFundsTransferTransferType').val();

	$('.internalFundsTransferTransferReceipientTypeComponent').hide();
	if(transferType=='WALLET_TO_WALLET')
	{
		$('#recWalletNumberDiv').show();
		$('#transferDetailsDiv').show();
		$('#transferAmount').show();
	}
	else if(transferType=='WALLET_TO_CARD')
	{
		$('#recCardNumberDiv').show();
		$('#transferDetailsDiv').show();
		$('#transferAmount').show();
	}
	else if(transferType=='CARD_TO_WALLET')
	{
		$('#recWalletNumberDiv').show();
		$('#sourceCardTransferFromCardDiv').show();
		$('#transferDetailsDiv').show();
		$('#transferAmount').show();
	}
	else if(transferType=='CARD_TO_CARD')
	{
		$('#recCardNumberDiv').show();
		$('#sourceCardTransferFromCardDiv').show();
		$('#transferDetailsDiv').show();
		$('#transferAmount').show();
	}
});


function doFundsTransferToSingleReceipient(jwtToken)
{
	jwtToken = 'Bearer ' + jwtToken;
	var form = $('#transferFundsForm')[0];
	if (($('#transferFundsForm').validator('validate').has('.has-error').length)) {
		//alert('SOMETHING WRONG');
		toastr.error("Provide all required information before submitting");
	} else {
		//alert(444);
		var formData = new FormData(form);
		var url = '/api/do-funds-transfer';
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
					if(data1.status==100)
					{
						toastr.success(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.message);
					}
					//toastr.success(data1.message);
				}
				else
				{
					toastr.error(data1.message);
					$('#dismissBtn').click();
					$('#new_card_modal').show();
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}
}


function loadUtilityModal(jwtToken)
{
	$('.utilityDiv').hide();
	$('#otpRef').val("");
	$('#utilityBillDivStepTwoValidationToken').val("");
	$('#utilitybillformpurchasesteptwo').hide();
	$('#utilitybillformpurchase').show();
	$('.preselect').show();
	jwtToken = 'Bearer ' + jwtToken;
	var url = '/api/get-customer-statistics';
	$.ajax({
		type: "GET",
		url: (url),
		data: ([]),
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function handleSuccess(data1){
			console.log(data1);
			if(data1.success!=undefined && data1.success===true)
			{
				//alert(33);
				if(data1.status==100)
				{
					cards = data1.cards;
					$('#utilityBillPayFrom').empty();


					$('#utilityBillPayFrom').append($('<option>', {
						value: null,
						text : '-Select One-'
					}));
					$.each(cards, function(key, value) {
						console.log(value);
						console.log(key);
						currencies = ['ZMW', 'TZS'];
						accountCurrency = currencies[value.currency];
						console.log(value.currency);
						$('#utilityBillPayFrom').append($('<option>', {
							value: value.serialNo + '|||' + value.trackingNumber + '|||' + value.nameOnCard + '|||' + value.pan + '|||' + accountCurrency,
							text : value.nameOnCard + ' - ' + value.pan
						}));

					});
				}
				else if(data1.status==-1)
				{
					console.log(window.location);
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data1.message);
				}
				//toastr.success(data1.message);
			}
			else
			{
				toastr.error(data1.message);
				$('#dismissBtn').click();
				$('#new_card_modal').show();

				if(data1.status==-1)
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
			}
		},
		error: function (e) {
			toastr.error('We experienced an issue updating your merchant profile. Please try again.');
		}
	});
}




function loadCyberSourcePaymentDetails(key, input)
{
    
    var $modalDashboard = $('#ajaxCybersourcePaymentDetailsListMenuModal');
    $(document).ready(function(){

        //$modal.modal('hide');
        //$modalForgotPassword.modal('hide');

        //$('body').modalmanager('loading');

        setTimeout(function(){
            url = '/ajax-payment-details-cyb.html/'+ key +'/' + input;
            console.log(url);
             //$modalDashboard.load(url, '', function(){
                $modalDashboard.modal();
                
                handleNotifications();
                var x = document.createElement("iframe");
                x.setAttribute("style", "position:fixed;top:0;left:0;z-index:1000;border:none;width:100%;height:100%;");//opacity:0;pointer-events:none;
                x.setAttribute("allowTransparency", "true");
                x.setAttribute("width", "100%");
                x.setAttribute("height", "100%");
                x.setAttribute("name", "probasepaycybersourceframe");
                x.src = "https://demo.payments.probasepay.com/ajax-payment-details-cyb.html/" + key + "/" + input;
                x.setAttribute("id", "probasepaycybersourceframe");
                x.setAttribute("name", "probasepaycybersourceframe");
                var ifexist = document.querySelector("#probasepaycybersourceframe");
                if(ifexist!=undefined)
                    ifexist.remove();

                $('#ajaxCybersourcePaymentDetailsListMenuModal').empty();
                $('#ajaxCybersourcePaymentDetailsListMenuModal').append(x);
                console.log(33330);
            //});
        }, 1000);
    });
}



function loadBevuraWalletPaymentDetails(key, input)
{
    	//var $modalDashboard = $('#ajaxPaymentDetailsListMenuModal');
	var $modalDashboard = $('#ajaxPaymentOptionDetailsListMenuModal');
	$(document).ready(function(){

		//$modal.modal('hide');
		//$modalForgotPassword.modal('hide');

		$('body').modalmanager('loading');

		setTimeout(function(){
            console.log(1111);
            this.this_url  = '/ajax-payment-details.html/'+key+'/' + input;
			$modalDashboard.load('/ajax-payment-details.html/'+key+'/' + input, '', function(){
				$modalDashboard.modal();
				//handleNotifications();
			});
		}, 1000);
	});
}



function loadOnlineBankingPaymentDetails(key, input)
{
   	//var $modalDashboard = $('#ajaxPaymentDetailsListMenuModal');
	var $modalDashboard = $('#ajaxPaymentOptionDetailsListMenuModal');
	$(document).ready(function(){

		//$modal.modal('hide');
		//$modalForgotPassword.modal('hide');

		$('body').modalmanager('loading');

		setTimeout(function(){
            console.log(1111);
            this.this_url  = '/ajax-payment-online-banking-details.html/'+key+'/' + input;
			$modalDashboard.load('/ajax-payment-online-banking-details.html/'+key+'/' + input, '', function(){
				$modalDashboard.modal();
				//handleNotifications();
			});
		}, 1000);
	});
}




function format_number_for_amount(d)
{
	return d.toFixed(2);
}


function logoutUser(msg, url)
{
	toastr.warning(msg);
	window.location = '/logout';
}



function showQRCodeImage(imgData)
{

	//var image = new Image();
	//image.src = 'data:image/png;base64,' + imgData;
	document.getElementById('r_code_holder').innerHTML = "<img style='display: block; margin-left: auto; margin-right: auto;' src='data:image/png;base64,"+imgData+"'>";
	$('#qr_code_image_modal').show();
}


function showProbaseQRCodeImage(imgData)
{

	//var image = new Image();
	//image.src = 'data:image/png;base64,' + imgData;
	document.getElementById('r_code_holder').innerHTML = "<img style='display: block; margin-left: auto; margin-right: auto; height: 600px !important' src='https://probasepay.com/probase_qr_data_images/"+imgData+"'>";
	$('#qr_code_image_modal').show();
}



function handleShowLoadPoolAccountView(id)
{
	$('#load_pool_account_modal').show();
	console.log(id);
	$('#poolAccount').val(id);
}


function submitFundPoolAccountForm(token, pSessionToken)
{
	var valueDate = $('#valueDate').val();
	var amount = $('#amount').val();
	var transactionNumber = $('#transactionNumber').val();
	var poolAccount = $('#poolAccount').val();
	valueDate = valueDate.split("\/");
console.log(valueDate);
	valueDate = valueDate[2] + "-" + valueDate[1] + "-" + valueDate[0];
	console.log([valueDate, amount, transactionNumber, poolAccount]);


	var jwtToken = token;
	console.log(jwtToken);
	jwtToken = 'Bearer ' + pSessionToken;
	var formData = {};
	formData['poolAccountId'] = $('#poolAccount').val();
	formData['bankTransactionRef'] = $('#transactionNumber').val();
	formData['amount'] = $('#amount').val();
	formData['valueDate'] = valueDate ;
	formData['token'] = token;

	console.log(formData);
	if ($('#serviceType').val()=='') {
		//alert('SOMETHING WRONG');
		toastr.error("Provide all required information before submitting");
	} else {
		
		var url = '/api/pool-account/fund-pool-account';
		$.ajax({
			type: "POST",
			url: (url),
			data: (JSON.stringify(formData)),
			processData: false,
			contentType: false,
			cache: false,
			headers: {"Authorization": jwtToken},
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				if(1==1)
				{
					//alert(33);
					if(data1.status==100)
					{
						$('#dismissBtn').click();
						$('#new_card_modal').show();
						window.location = '/accountant/pool-accounts/list-pool-accounts';
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
						$('#saveSetupdiv').hide();
					}
					else
					{
						toastr.error(data1.message);
						$('#saveSetupdiv').hide();
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
						$('#saveSetupdiv').hide();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}
}






function handleFundAccount(token, pSessionToken)
{

	var amountPaid = $('#amountPaid').val();
	var banktransactionid = $('#banktransactionid').val();
	var accountId = $('#aid').val();
	

	var jwtToken = token;
	console.log(jwtToken);
	jwtToken = 'Bearer ' + pSessionToken;
	var formData = {};
	formData['accountId'] = accountId;
	formData['bankTransactionId'] = banktransactionid;
	formData['amount'] = amountPaid;
	formData['token'] = token;
	formData['channel'] = 'WEB';

	console.log(formData);
	if ($('#serviceType').val()=='') {
		//alert('SOMETHING WRONG');
		toastr.error("Provide all required information before submitting");
	} else {
		
		var url = '/api/pool-account/fund-account';
		$.ajax({
			type: "POST",
			url: (url),
			data: (JSON.stringify(formData)),
			processData: false,
			contentType: false,
			cache: false,
			headers: {"Authorization": jwtToken},
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				if(1==1)
				{
					//alert(33);
					if(data1.status==100)
					{
						$('#dismissBtn').click();
						$('#new_card_modal').show();
						window.location = '/accountant/pool-accounts/list-pool-accounts';
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
						$('#saveSetupdiv').hide();
					}
					else
					{
						toastr.error(data1.message);
						$('#saveSetupdiv').hide();
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
						$('#saveSetupdiv').hide();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}
}




function showIssueCard(cardId)
{
	$('#issuePhysicalCard').show();
	$('#accountIdForCardIssue').val('');
	$('#cardBinId').val(cardId);
	$('#customerDetailsFound').html('');
	$('#customerDetailsFoundDiv').hide();
	$('#customerAccountNumberDiv').show();
}



function searchForCustomerAccount(token, pSessionToken)
{
	var acctNo = $('#cardAccountNumber').val();
	

	var jwtToken = token;
	console.log(jwtToken);
	jwtToken = 'Bearer ' + pSessionToken;
	var formData = {};
	formData['accountNumber'] = acctNo;
	formData['token'] = token;

	console.log(formData);
	if ($('#serviceType').val()=='') {
		//alert('SOMETHING WRONG');
		toastr.error("Provide all required information before submitting");
	} else {
		
		var url = '/api/account/find-customer-by-account-number';
		$.ajax({
			type: "POST",
			url: (url),
			data: (JSON.stringify(formData)),
			processData: false,
			contentType: false,
			cache: false,
			headers: {"Authorization": jwtToken},
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				if(1==1)
				{
					//alert(33);
					if(data1.status==100)
					{
						//$('#dismissBtn').click();
						//$('#new_card_modal').show();
						//window.location = '/accountant/pool-accounts/list-pool-accounts';
						$('#customerDetailsFoundDiv').show();
						$('#customerAccountNumberDiv').hide();
						var htmlData = data1.resp.customerName + "</br>" + data1.resp.mobileNumber;
						$('#accountIdForCardIssue').val(data1.resp.accountId);
						$('#customerDetailsFound').html(htmlData);
						$('#searchButton').hide();
						$('#assignPhysicalCard').show();
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
						$('#saveSetupdiv').hide();
					}
					else
					{
						toastr.error(data1.message);
						$('#saveSetupdiv').hide();
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
						$('#saveSetupdiv').hide();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}

}



function showCardBinStatus(token, pSessionToken, cardTrackingNumber)
{
	$('#showCardStatus').show();
	$('#cardTrackingNumber').val(cardTrackingNumber);
	$('#cardStatusDetails').html('');

	var jwtToken = token;
	console.log(jwtToken);
	jwtToken = 'Bearer ' + pSessionToken;
	var formData = {};
	formData['cardTrackingNumber'] = cardScheme;
	formData['token'] = token;

	console.log(formData);
	if ($('#serviceType').val()=='') {
		//alert('SOMETHING WRONG');
		toastr.error("Provide all required information before submitting");
	} else {
		
		var url = '/api/account/get-bin-ecard-status';
		$.ajax({
			type: "POST",
			url: (url),
			data: (JSON.stringify(formData)),
			processData: false,
			contentType: false,
			cache: false,
			headers: {"Authorization": jwtToken},
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				if(1==1)
				{
					//alert(33);
					if(data1.status==100)
					{

						//$('#customerDetailsFoundDiv').show();
						//$('#customerAccountNumberDiv').hide();
						//var htmlData = data1.resp.customerName + "</br>" + data1.resp.mobileNumber;
						//$('#accountIdForCardIssue').val(data1.resp.accountId);
						//$('#customerDetailsFound').html(htmlData);
						//$('#searchButton').hide();
						//$('#assignPhysicalCard').show();
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
						$('#saveSetupdiv').hide();
					}
					else
					{
						toastr.error(data1.message);
						$('#saveSetupdiv').hide();
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
						$('#saveSetupdiv').hide();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}

}



function issuePhysicalCardToAccount(token, pSessionToken)
{
	var acctId= $('#accountIdForCardIssue').val();
	var cardScheme= $('#cardScheme').val();
//alert(cardScheme);
	var cardBinId = $('#cardBinId').val();
	

	var jwtToken = token;
	console.log(jwtToken);
	jwtToken = 'Bearer ' + pSessionToken;
	var formData = {};
	formData['accountId'] = acctId;
	formData['cardBinId'] = cardBinId;
	formData['cardScheme'] = cardScheme;
	formData['token'] = token;

	console.log(formData);
	if ($('#serviceType').val()=='') {
		//alert('SOMETHING WRONG');
		toastr.error("Provide all required information before submitting");
	} else {
		
		var url = '/api/account/issue-physical-card-to-account';
		$.ajax({
			type: "POST",
			url: (url),
			data: (JSON.stringify(formData)),
			processData: false,
			contentType: false,
			cache: false,
			headers: {"Authorization": jwtToken},
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				if(1==1)
				{
					//alert(33);
					if(data1.status==100)
					{
						//$('#dismissBtn').click();
						//$('#new_card_modal').show();
						//window.location = '/accountant/pool-accounts/list-pool-accounts';
						$('#customerDetailsFoundDiv').show();
						$('#customerAccountNumberDiv').hide();
						var htmlData = data1.resp.customerName + "</br>" + data1.resp.mobileNumber;
						$('#accountIdForCardIssue').val(data1.resp.accountId);
						$('#customerDetailsFound').html(htmlData);
						$('#searchButton').hide();
						$('#assignPhysicalCard').show();
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
						$('#saveSetupdiv').hide();
					}
					else
					{
						toastr.error(data1.message);
						$('#saveSetupdiv').hide();
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
						$('#saveSetupdiv').hide();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}

}





function updateAcquirerDetails(token, pSessionToken)
{
	var acctId= $('#acquirerid').val();
	

	var jwtToken = token;
	console.log(jwtToken);
	jwtToken = 'Bearer ' + pSessionToken;
	var formData = {};
	formData["acquirername"] = $("#acquirername").val();
	formData["acquirercode"] = $("#acquirercode").val();
	formData["bankid"] = $("#bankid").val();
	formData["holdfundsyes"] = $("#holdfundsyes").val();
	formData["islive"] = $("#islive").val();
	formData["accessexodus"] = $("#accessexodus").val();
	formData["accountcreationendpoint"] = $("#accountcreationendpoint").val();
	formData["accountcreationdemoendpoint"] = $("#accountcreationdemoendpoint").val();
	formData["fundstransferendpoint"] = $("#fundstransferendpoint").val();
	formData["fundstransferdemoendpoint"] = $("#fundstransferdemoendpoint").val();
	formData["balanceinquiryendpoint"] = $("#balanceinquiryendpoint").val();
	formData["balanceinquirydemoendpoint"] = $("#balanceinquirydemoendpoint").val();
	formData["authkey"] = $("#authkey").val();
	formData["demoauthkey"] = $("#demoauthkey").val();
	formData["servicekey"] = $("#servicekey").val();
	formData["demoservicekey"] = $("#demoservicekey").val();
	formData["ftauthkey"] = $("#ftauthkey").val();
	formData["ftdemoauthkey"] = $("#ftdemoauthkey").val();
	formData["ftservicekey"] = $("#ftservicekey").val();
	formData["ftdemoservicekey"] = $("#ftdemoservicekey").val();
	formData["creditftauthkey"] = $("#creditftauthkey").val();
	formData["democreditftauthkey"] = $("#democreditftauthkey").val();
	formData["allowedcurrency"] = $("#allowedcurrency").val().join('###');
	formData["defaultmerchantschemeid"] = $("#defaultmerchantschemeid").val();
	formData["acquirerid"] = $("#acquirerid").val();

	formData['token'] = token;

	console.log(formData);
	console.log([$('#acquirerid').val(), $('#acquirername').val(), $('#acquirercode').val(), $("#bankid").val()]);
	if ($('#acquirerid').val()=='' || $('#acquirername').val()=='' || $('#acquirercode').val()=='' || $("#bankid").val()=='') {
		//alert('SOMETHING WRONG');
		toastr.error("Provide all required information before submitting");
	} else {
		continueYes = true;
		if($('#holdfundsyes').val()==1)
		{
			if(!($('#accountcreationdemoendpoint').val().length>0 && $('#accountcreationendpoint').val().length>0
				&& $('#balanceinquirydemoendpoint').val().length>0 && $('#balanceinquiryendpoint').val().length>0
				&& $('#fundstransferdemoendpoint').val().length>0  && $('#fundstransferendpoint').val().length>0))
			{
				continueYes = false;
			}
		}


		if(continueYes==true)
		{
		var url = '/api/acquirers/update-acquirer';
		$.ajax({
			type: "POST",
			url: (url),
			data: (JSON.stringify(formData)),
			processData: false,
			contentType: false,
			cache: false,
			headers: {"Authorization": jwtToken},
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				if(1==1)
				{
					//alert(33);
					if(data1.status==0)
					{
						//$('#dismissBtn').click();
						//$('#new_card_modal').show();
						toastr.success(data1.message);
						window.location = '/potzr-staff/acquirers/acquirer-listing';
						
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
						$('#saveSetupdiv').hide();
					}
					else
					{
						toastr.error(data1.message);
						$('#saveSetupdiv').hide();
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
						$('#saveSetupdiv').hide();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
		}
		else
		{
			toastr.error('If this acquirer intends individual wallets to be created at a financial institution, you must provide the financial institutions end-points for creating individual wallets, checking balance inquiry and doing funds transfer');

		}
	}

}




function viewUpdateAcquirer(b)
{
	$('#updateAcquirerView').show();
	var table = $('#allAcquirersTable');
	var tr = $(b).closest('tr');
	$.each(tr.data(), function(key, value) {
        	console.log(key);
		console.log(value);
		if(value!="N/A")
		{
			if(key=="allowedcurrency")
			{
				$.each((value+"").split("###"), function(i,e){
    					//$('#'+key).val(value).change();
					$("#" + key + " option[value='" + e + "']").prop("selected", true);
				});
			}
			else if(key=="accessexodus")
			{
				$('#'+key).val(value).change();
				$('.acquireridedit').html(value);
				$('.acquireridnew').val(value).change();
			}
			else if(key=="bankid" || key=="allowedcurrency")
			{	
				$.each((value+"").split("###"), function(i,e){
    					//$('#'+key).val(value).change();
					$("#" + key + " option[value='" + e + "']").prop("selected", true);
				});
			}
			else if(key=="acquirerid")
			{
				$('.acquireridnew').hide();
				$('.acquireridedit').show();
				$('.acquireridedit').html();
				$('#'+key).val(value).change();
			}
			else
			{
				$('#'+key).val(value).change();
			}
		}
    	});


}




function viewPoolBalanceAtBank(jwtToken, deviceCode, poolAccountId, merchantCode)
{
	console.log(jwtToken);
	jwtToken = 'Bearer ' + jwtToken;
	var formData = new FormData();
	formData.append('deviceCode', deviceCode);
	formData.append('token', jwtToken);
	formData.append('poolAccountId', poolAccountId);
	formData.append('merchantCode', merchantCode);

		var url = '/api/pool-account/view-pool-account-balance';
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
					if(data1.data.status==5000)
					{
						$('#availablebalanceDiv' + poolAccountId).show();
						$('#availablebalanceDiv' + poolAccountId).html(data1.data.currency + "" + data1.data.availablebalance);
					}
					else if(data1.data.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.data.message);
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	
	
}


	function handleReverseTransaction(jwtToken, deviceCode, transactionId)
	{
		var url = '/api/journal-entries/transaction';
		var data_ = [];
		console.log(jwtToken);
		console.log(deviceCode);
		console.log(transactionId);
		var formData = new FormData();
		formData.append('transactionId', transactionId);
		formData.append('deviceCode', deviceCode);

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
				if(1==1)
				{
					
					var list = [];
					for(var j=0; j<data1.journalEntryList.length; j++)
					{
						var le = data1.journalEntryList[j];
						var listEntry = {};
						listEntry["transactionRef"] = le.transactionRef;
						listEntry["valueDate"] = le.valueDate;
						listEntry["isManualEntry"] = le.isManualEntry==true ? "Yes" : "No";
						listEntry["name"] = le.firstName + " " + le.lastName;
						listEntry["glAccountName"] = le.glAccountName + '<br>'+le.glAccountCode+'<br><i>'+accountTypes[le.glAccountType]+'</i>';
						listEntry["dr"] = le.debitCredit==0 ? parseFloat(le.amount).toFixed(2) : '';
						listEntry["cr"] = le.debitCredit==1 ? parseFloat(le.amount).toFixed(2) : '';
						list.push(listEntry);
					}
					//alert(33);
					if(data1.status==5000)
					{
						$('#dismissBtn').click();
						$('#journalviewsubview').show();

						$('#journalentriestablesub').DataTable({
							//"ajax": "/get-customer-list-ajax",
							"data": list,
							"columns": [
								{ "data": "transactionRef", className: "text-left"  },
								{ "data": "valueDate", className: "text-left"  },
								{ "data": "isManualEntry" },
								{ "data": "name", className: "text-left"  },
								{ "data": "glAccountName", className: "text-left"  },
								{ "data": "dr", className: "text-right" },
								{ "data": "cr", className: "text-right" },
							]
						});
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.message);
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}

	function viewJournalEntriesByFilter(jwtToken, deviceCode, transactionId, accountTypes)
	{
		var url = '/api/journal-entries/transaction';
		var data_ = [];
		console.log(jwtToken);
		console.log(deviceCode);
		console.log(transactionId);
		var formData = new FormData();
		formData.append('transactionId', transactionId);
		formData.append('deviceCode', deviceCode);

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
				if(1==1)
				{
					
					var list = [];
					for(var j=0; j<data1.journalEntryList.length; j++)
					{
						var le = data1.journalEntryList[j];
						var listEntry = {};
						listEntry["transactionRef"] = le.transactionRef;
						listEntry["valueDate"] = le.valueDate;
						listEntry["isReversed"] = le.isReversed!=undefined ? le.isReversed : false;
						listEntry["isManualEntry"] = le.isManualEntry==true ? "Yes" : "No";
						listEntry["name"] = le.firstName + " " + le.lastName;
						listEntry["glAccountName"] = le.glAccountName + '<br>'+le.glAccountCode+'<br><i>'+accountTypes[le.glAccountType]+'</i>';
						listEntry["dr"] = le.debitCredit==0 ? parseFloat(le.amount).toFixed(2) : '';
						listEntry["cr"] = le.debitCredit==1 ? parseFloat(le.amount).toFixed(2) : '';
						list.push(listEntry);
					}
					//alert(33);
					if(data1.status==5000)
					{
						$('#dismissBtn').click();
						$('#journalviewsubview').show();
						$('#journalentriestablesub').DataTable().destroy();
						$('#journalentriestablesub').DataTable({
							//"ajax": "/get-customer-list-ajax",
							"data": list,
							"columns": [
								{ "data": "transactionRef", className: "text-left"  },
								{ "data": "valueDate", className: "text-left"  },
								{ "data": "isManualEntry" },
								{ "data": "name", className: "text-left"  },
								{ "data": "glAccountName", className: "text-left"  },
								{ "data": "dr", className: "text-right" },
								{ "data": "cr", className: "text-right" },
							],   
    							rowCallback: function (row, data) {
        							if ( data.isReversed!=undefined && data.isReversed==true ) {
            								$(row).addClass('strikethrough');
       							}
    							}
						});
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.message);
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}



	//function goToStep('stepContent2', event){
function updateMerchant(nextStep, event, jwtToken){

	jwtToken = jwtToken;
	var form = $('#merchantInfoForm')[0];
	var xrt = $('#merchantInfoForm').validator('validate');
	console.log(xrt);
	if ((xrt.has('.has-error').length)) {
		//alert('SOMETHING WRONG');
		toastr.error("Provide all required information before submitting");
	} else {
		var formData = new FormData(form);
console.log(formData);
		var url = '/api/merchants/update-merchant-bio-data';
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
					if(data1.data.status==200)
					{
						//$('#dismissBtn').click();
						//$('#new_card_modal').show();
						toastr.success(data1.data.message);
					}
					else if(data1.data.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.data.message);
					}
					//
				}
				else
				{
						toastr.error(data1.data.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}

}





function updateMerchantScheme(nextStep, event, jwtToken){

	jwtToken = jwtToken;
	var form = $('#merchantInfoFormStepTwo')[0];
	var xrt = $('#merchantInfoFormStepTwo').validator('validate');
	console.log(xrt);
	if ((xrt.has('.has-error').length)) {
		//alert('SOMETHING WRONG');
		toastr.error("Provide all required information before submitting");
	} else {
		var formData = new FormData(form);
		var url = '/api/merchants/update-merchant-bank-and-scheme';
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
					if(data1.data.status==200)
					{
						$('#dismissBtn').click();
						$('#new_card_modal').show();
						toastr.success(data1.data.message);
					}
					else if(data1.data.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.data.message);
					}
					//
				}
				else
				{
						toastr.error(data1.data.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}

}


function cardTypes()
{
	var cardTypes = [];
	cardTypes.push('Eagle Card');
	cardTypes.push('Tutuka Virtual Card');
	cardTypes.push('Tutuka Physical Card');
	cardTypes.push('Tutuka Device Settlement Card');
	return cardTypes;
}


var maxTransactionAmount = 0;
function loadAccountantDashboard(jwtToken, deviceCode, type, token, serviceTypes, statusList)
{
		console.log(serviceTypes);
		var url = '/api/report/dashboard-statistics';
		var formData = new FormData();
		formData.append('deviceCode', deviceCode);
		formData.append('type', type);
		formData.append('token', token);

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
				if(1==1)
				{
					//alert(33);
					if(data1.status!=undefined && data1.status==5000)
					{
						var ecardsCount = data1.ecardsCount;
						var ecardsCount_ = {};

						for(var k=0; k<cardTypes().length; k++)
						{
							ecardsCount_[cardTypes()[k]] = 0;
						}


						var totalCards = 0;
						for(var k=0; k<ecardsCount.length; k++)
						{
							console.log(cardTypes()[ecardsCount[k].cardType]);
							ecardsCount_[cardTypes()[ecardsCount[k].cardType]] = ecardsCount[k].ecardsCount!=undefined ? parseInt(ecardsCount[k].ecardsCount) : 0;
							totalCards = totalCards + ecardsCount_[cardTypes()[ecardsCount[k].cardType]];
						}

						console.log(totalCards);
						$("#transactionsHolder").html(data1.totalTransactions);
						$("#incomeHolder").html("<sup>ZMW</sup>" + (data1.totalIncome==undefined ? parseFloat('0.00').toFixed(2) : parseFloat(data1.totalIncome).toFixed(2) ));
						$("#customerCountHolder").html(data1.customerCount);
						$("#poolBalanceHolder").html("<sup>ZMW</sup>" + parseFloat(data1.poolBalance + "").toFixed(2));
						$("#virtualCardCountHolder").html(ecardsCount_['Tutuka Virtual Card'] + " cards issued");
						$("#physicalCardCountHolder").html(ecardsCount_['Tutuka Physical Card'] + " cards issued");
						$("#walletCountHolder").html(data1.walletCount + " wallets generated");
						if(totalCards>0)
						{
							document.getElementById("virtualCardCountHolderLevel2").style.width = ((ecardsCount_['Tutuka Virtual Card']/totalCards)*100) + '%';
							$("#virtualCardCountHolderLevel3").width((((ecardsCount_['Tutuka Virtual Card']/totalCards)*100)) + "%");
						}
						else
						{
							document.getElementById("virtualCardCountHolderLevel2").style.width = '0%';
							$("#virtualCardCountHolderLevel3").width('100%');
						}
						if(totalCards>0)
							$("#physicalCardCountHolderLevel2").width(((ecardsCount_['Tutuka Physical Card']/totalCards)*100) + '%');
						else
							$("#physicalCardCountHolderLevel2").width('0%');

//alert(data1.walletCount + " --- "  +data1.customerCount);

						$("#walletCountHolderLevel2").width('100%');

						$("#physicalCardCountHolderLevel3").width('100%');
						$("#walletCountHolderLevel3").width(((data1.customerCount/data1.walletCount)*100) + '%');
						$("#mpqrCountHolder").html(data1.mpqrCount + " MPQRs created");
						$("#mpqrCountHolderLevel2").width('40%');
						$("#mpqrCountHolderLevel3").width('100%');
						$("#merchantCountHolder").html(data1.merchantsCount + " signed up");
						$("#merchantCountHolderLevel2").width('40%');
						$("#merchantCountHolderLevel3").width('100%');
						$("#deviceCountHolder").html(data1.devicesCount + " receive payments");
						$("#deviceCountHolderLevel2").width('100%');
						$("#deviceCountHolderLevel3").width('100%');

console.log(((ecardsCount_['Tutuka Virtual Card']/totalCards)*100) + '%');
						var html = "";
						for(var k=0; k<data1.ecardrequests.length; k++)
						{
							html = html + '<tr>';
                              			html = html + '<td class="nowrap">' + data1.ecardrequests[k].firstName + ' ' + data1.ecardrequests[k].lastName + '</td>';
                              			html = html + '<td>' + data1.ecardrequests[k].schemeName + '</td>';
							if(data1.ecardrequests[k].status==0)
                              				html = html + '<td class="text-center"><div class="status-pill yellow" data-title="Complete" data-toggle="tooltip"></div></td>';
							else 
                              				html = html + '<td class="text-center"><div class="status-pill yellow" data-title="Pending" data-toggle="tooltip"></div></td>';

                              			html = html + '<td class="text-right">' + data1.ecardrequests[k].created_at.split(' ')[0] + '</td>';
                              			html = html + '</tr>';
						}

						if(html.length==0)
						{
							html = html + '<tr>';
                              			html = html + '<td colspan="4" class="text-center">No requests or cards created</td>';
                              			html = html + '</tr>';
						}
						console.log(html);
						$('#tbodyForMasterCard').html(html);

						var debitTransactions = data1.debitTransactions;
						var numarr = [];
						for(var k=0; k<debitTransactions.length; k++)
						{
							numarr.push(k);
						}
						numarr = shuffle(numarr);
						console.log(numarr);
						var numarr_ = numarr.slice(0, (numarr.length>8 ? 8 : numarr.length));
						numarr_ = numarr_.sort(function(a, b) {
  							return a - b;
						});
						console.log(numarr_);
						var labels = [];
						var labelData = [];
						for(var k=0; k<numarr_.length; k++)
						{
							labels.push(debitTransactions[numarr_[k]].dtcreated.split('-')[2]);
							labelData.push((parseFloat(debitTransactions[numarr_[k]].totalDebit) + parseFloat(debitTransactions[numarr_[k]].totalCharge)));
							maxTransactionAmount = maxTransactionAmount>(parseFloat(debitTransactions[numarr_[k]].totalDebit) + parseFloat(debitTransactions[numarr_[k]].totalCharge)) ? maxTransactionAmount : (parseFloat(debitTransactions[numarr_[k]].totalDebit) + parseFloat(debitTransactions[numarr_[k]].totalCharge));
						}
						console.log([labels, labelData, maxTransactionAmount]);
                              		loadChart(labels, labelData, maxTransactionAmount);
						loadDonut([ecardsCount_['Tutuka Virtual Card'], ecardsCount_['Tutuka Physical Card']]);
						$('#totalCardsForChar').html(parseFloat(ecardsCount_['Tutuka Virtual Card']) + parseFloat(ecardsCount_['Tutuka Physical Card']));
						$('#virtualcardforchart').html(ecardsCount_['Tutuka Virtual Card'] + " issued");
						$('#physicalcardforchart').html(ecardsCount_['Tutuka Physical Card'] + " issued");


						var transactions = data1.transactions;
						var html = "";
console.log(serviceTypes);
						for(var k=0; k<transactions.length; k++)
						{
							var tx = transactions[k];
							html = html + '<tr>';
							html = html + '<td>' + tx.created_at.split(' ')[0] + '</td>';
							html = html + '<td>' + (tx.orderRef!=undefined ? tx.orderRef.toUpperCase() : '') + '</td>';
							html = html + '<td>'+ (tx.details!=undefined ? tx.details : '') +'</td>';
							html = html + '<td>' + tx.payerName + '</td>';
							html = html + '<td>' + statusList[tx.status] + '</td>';
							html = html + '<td class="text-right"><sup>ZMW</sup>' + parseFloat(tx.amount).toFixed(2) + '</td>';
							html = html + '</tr>';
						}
						if(html.length==0)
						{
							html = html + '<tr>';
                              			html = html + '<td colspan="6" class="text-center">No transactions</td>';
                              			html = html + '</tr>';
						}
						$('#transactionListTable').html(html);



						var html = '<h6 class="element-header"><a href="/potzr-staff/support-messages">Recent Issues</a></h6>';
						html = html + '<div class="element-box-tp">';
						var supportMessages = data1.supportMessages;
						for(var k=0; k<supportMessages .length; k++)
						{
							var tx = supportMessages[k];
							
							  html = html + '<div class="profile-tile">';
								html = html + '<a class="profile-tile-box" href="/potzr-staff/support-messages">';
								  html = html + '<div class="pt-avatar-w">';
									html = html + '<img alt="" src="'+ (tx['profilePix']!=undefined && tx['profilePix']!=null ? ('/images/'+tx['profilePix']) : '/images/defaultuser.png') +'">';
								  html = html + '</div>';
								  html = html + '<div class="pt-user-name">';
									html = html + tx['sendersName'];
								  html = html + '</div>';
								html = html + '</a>';
								html = html + '<div class="profile-tile-meta">';
								  html = html + '<ul>';
									html = html + '<li>';
									  html = html + 'Date Sent:<strong>'+ tx['createdAt'].split(' ')[0] +'</strong>';
									html = html + '</li>';
								  html = html + '</ul>';
								  html = html + '<div class="pt-btn">';
									html = html + '<a class="btn btn-success btn-sm" href="/potzr-staff/support-messages">Read Message</a>';
								  html = html + '</div>';
								html = html + '</div>';
							  html = html + '</div>';
						}

						if(html.length==0)
						{
							html = html + '<div>';
                              			html = html + 'There are no support messages';
                              			html = html + '</div>';
						}
						html = html + '</div>';

console.log(html);
						$('#supportmessagelisting').html(html);



					}
					else if(data1.status!=undefined && data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.message!=undefined ? data1.message : 'Server not reachable');
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message!=undefined ? data1.message : 'Server not reachable');
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
}






function loadAgentDashboard(jwtToken, deviceCode, type, token, serviceTypes, statusList)
{
		console.log(serviceTypes);
		var url = '/api/report/dashboard-statistics';
		var formData = new FormData();
		formData.append('deviceCode', deviceCode);
		formData.append('type', type);
		formData.append('token', token);

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
				if(1==1)
				{
					//alert(33);
					if(data1.status!=undefined && data1.status==5000)
					{
						var ecardsCount = data1.ecardsCount;
						var ecardsCount_ = {};

						for(var k=0; k<cardTypes().length; k++)
						{
							ecardsCount_[cardTypes()[k]] = 0;
						}


						var totalCards = 0;
						for(var k=0; k<ecardsCount.length; k++)
						{
							console.log(cardTypes()[ecardsCount[k].cardType]);
							ecardsCount_[cardTypes()[ecardsCount[k].cardType]] = ecardsCount[k].ecardsCount!=undefined ? parseInt(ecardsCount[k].ecardsCount) : 0;
							totalCards = totalCards + ecardsCount_[cardTypes()[ecardsCount[k].cardType]];
						}

						console.log(totalCards);
						$("#transactionsHolder").html(data1.totalTransactions);
						$("#incomeHolder").html("<sup>ZMW</sup>" + (data1.totalIncome==undefined ? parseFloat('0.00').toFixed(2) : parseFloat(data1.totalIncome).toFixed(2) ));
						$("#customerCountHolder").html(data1.customerCount);
						$("#poolBalanceHolder").html("<sup>ZMW</sup>" + parseFloat(data1.poolBalance + "").toFixed(2));
						$("#virtualCardCountHolder").html(ecardsCount_['Tutuka Virtual Card'] + " cards issued");
						$("#physicalCardCountHolder").html(ecardsCount_['Tutuka Physical Card'] + " cards issued");
						$("#walletCountHolder").html(data1.walletCount + " wallets generated");
						if(totalCards>0)
						{
							document.getElementById("virtualCardCountHolderLevel2").style.width = ((ecardsCount_['Tutuka Virtual Card']/totalCards)*100) + '%';
							$("#virtualCardCountHolderLevel3").width((((ecardsCount_['Tutuka Virtual Card']/totalCards)*100)) + "%");
						}
						else
						{
							document.getElementById("virtualCardCountHolderLevel2").style.width = '0%';
							$("#virtualCardCountHolderLevel3").width('100%');
						}
						if(totalCards>0)
							$("#physicalCardCountHolderLevel2").width(((ecardsCount_['Tutuka Physical Card']/totalCards)*100) + '%');
						else
							$("#physicalCardCountHolderLevel2").width('0%');

//alert(data1.walletCount + " --- "  +data1.customerCount);

						$("#walletCountHolderLevel2").width('100%');

						$("#physicalCardCountHolderLevel3").width('100%');
						$("#walletCountHolderLevel3").width(((data1.customerCount/data1.walletCount)*100) + '%');
						$("#mpqrCountHolder").html(data1.mpqrCount + " MPQRs created");
						$("#mpqrCountHolderLevel2").width('40%');
						$("#mpqrCountHolderLevel3").width('100%');
						$("#merchantCountHolder").html(data1.merchantsCount + " signed up");
						$("#merchantCountHolderLevel2").width('40%');
						$("#merchantCountHolderLevel3").width('100%');
						$("#deviceCountHolder").html(data1.devicesCount + " receive payments");
						$("#deviceCountHolderLevel2").width('100%');
						$("#deviceCountHolderLevel3").width('100%');

console.log(((ecardsCount_['Tutuka Virtual Card']/totalCards)*100) + '%');
						var html = "";
						for(var k=0; k<data1.ecardrequests.length; k++)
						{
							html = html + '<tr>';
                              			html = html + '<td class="nowrap">' + data1.ecardrequests[k].firstName + ' ' + data1.ecardrequests[k].lastName + '</td>';
                              			html = html + '<td>' + data1.ecardrequests[k].schemeName + '</td>';
							if(data1.ecardrequests[k].status==0)
                              				html = html + '<td class="text-center"><div class="status-pill yellow" data-title="Complete" data-toggle="tooltip"></div></td>';
							else 
                              				html = html + '<td class="text-center"><div class="status-pill yellow" data-title="Pending" data-toggle="tooltip"></div></td>';

                              			html = html + '<td class="text-right">' + data1.ecardrequests[k].created_at.split(' ')[0] + '</td>';
                              			html = html + '</tr>';
						}

						if(html.length==0)
						{
							html = html + '<tr>';
                              			html = html + '<td colspan="4" class="text-center">No requests or cards created</td>';
                              			html = html + '</tr>';
						}
						console.log(html);
						$('#tbodyForMasterCard').html(html);

						var debitTransactions = data1.debitTransactions;
						var numarr = [];
						for(var k=0; k<debitTransactions.length; k++)
						{
							numarr.push(k);
						}
						numarr = shuffle(numarr);
						console.log(numarr);
						var numarr_ = numarr.slice(0, (numarr.length>8 ? 8 : numarr.length));
						numarr_ = numarr_.sort(function(a, b) {
  							return a - b;
						});
						console.log(numarr_);
						var labels = [];
						var labelData = [];
						for(var k=0; k<numarr_.length; k++)
						{
							labels.push(debitTransactions[numarr_[k]].dtcreated.split('-')[2]);
							labelData.push((parseFloat(debitTransactions[numarr_[k]].totalDebit) + parseFloat(debitTransactions[numarr_[k]].totalCharge)));
							maxTransactionAmount = maxTransactionAmount>(parseFloat(debitTransactions[numarr_[k]].totalDebit) + parseFloat(debitTransactions[numarr_[k]].totalCharge)) ? maxTransactionAmount : (parseFloat(debitTransactions[numarr_[k]].totalDebit) + parseFloat(debitTransactions[numarr_[k]].totalCharge));
						}
						console.log([labels, labelData, maxTransactionAmount]);
                              		loadChart(labels, labelData, maxTransactionAmount);
						loadDonut([ecardsCount_['Tutuka Virtual Card'], ecardsCount_['Tutuka Physical Card']]);
						$('#totalCardsForChar').html(parseFloat(ecardsCount_['Tutuka Virtual Card']) + parseFloat(ecardsCount_['Tutuka Physical Card']));
						$('#virtualcardforchart').html(ecardsCount_['Tutuka Virtual Card'] + " issued");
						$('#physicalcardforchart').html(ecardsCount_['Tutuka Physical Card'] + " issued");


						var transactions = data1.transactions;
						var html = "";
console.log(serviceTypes);
						for(var k=0; k<transactions.length; k++)
						{
							var tx = transactions[k];
							html = html + '<tr>';
							html = html + '<td>' + tx.created_at.split(' ')[0] + '</td>';
							html = html + '<td>' + (tx.orderRef!=undefined ? tx.orderRef.toUpperCase() : '') + '</td>';
							html = html + '<td>'+ (tx.details!=undefined ? tx.details : '') +'</td>';
							html = html + '<td>' + tx.payerName + '</td>';
							html = html + '<td>' + statusList[tx.status] + '</td>';
							html = html + '<td class="text-right"><sup>ZMW</sup>' + parseFloat(tx.amount).toFixed(2) + '</td>';
							html = html + '</tr>';
						}
						if(html.length==0)
						{
							html = html + '<tr>';
                              			html = html + '<td colspan="6" class="text-center">No transactions</td>';
                              			html = html + '</tr>';
						}
						$('#transactionListTable').html(html);



						var html = '<h6 class="element-header"><a href="/potzr-staff/support-messages">Recent Issues</a></h6>';
						html = html + '<div class="element-box-tp">';
						var supportMessages = data1.supportMessages;
						for(var k=0; k<supportMessages .length; k++)
						{
							var tx = supportMessages[k];
							
							  html = html + '<div class="profile-tile">';
								html = html + '<a class="profile-tile-box" href="/potzr-staff/support-messages">';
								  html = html + '<div class="pt-avatar-w">';
									html = html + '<img alt="" src="'+ (tx['profilePix']!=undefined && tx['profilePix']!=null ? ('/images/'+tx['profilePix']) : '/images/defaultuser.png') +'">';
								  html = html + '</div>';
								  html = html + '<div class="pt-user-name">';
									html = html + tx['sendersName'];
								  html = html + '</div>';
								html = html + '</a>';
								html = html + '<div class="profile-tile-meta">';
								  html = html + '<ul>';
									html = html + '<li>';
									  html = html + 'Date Sent:<strong>'+ tx['createdAt'].split(' ')[0] +'</strong>';
									html = html + '</li>';
								  html = html + '</ul>';
								  html = html + '<div class="pt-btn">';
									html = html + '<a class="btn btn-success btn-sm" href="/potzr-staff/support-messages">Read Message</a>';
								  html = html + '</div>';
								html = html + '</div>';
							  html = html + '</div>';
						}

						if(html.length==0)
						{
							html = html + '<div>';
                              			html = html + 'There are no support messages';
                              			html = html + '</div>';
						}
						html = html + '</div>';

console.log(html);
						$('#supportmessagelisting').html(html);



					}
					else if(data1.status!=undefined && data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.message!=undefined ? data1.message : 'Server not reachable');
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message!=undefined ? data1.message : 'Server not reachable');
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
}


function shuffle(array) {
  let currentIndex = array.length,  randomIndex;

  // While there remain elements to shuffle...
  while (currentIndex != 0) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex--;

    // And swap it with the current element.
    [array[currentIndex], array[randomIndex]] = [
      array[randomIndex], array[currentIndex]];
  }

  return array;
}

	function loadChart(labels, data1, maxTransactionAmount)
	{
		$('#maxTransactionAmountDiv').html('<sup><small>ZMW</small></sup>' + parseFloat(maxTransactionAmount).toFixed(2) + "");
			if ($("#lineChartAcc").length) {
			  var lineChart = $("#lineChartAcc"); // line chart data

			  var lineData = {
				labels: labels,
				datasets: [{
				  label: "Debit Transactions (ZMW)",
				  fill: false,
				  lineTension: 0.3,
				  backgroundColor: "#fff",
				  borderColor: "#047bf8",
				  borderCapStyle: 'butt',
				  borderDash: [],
				  borderDashOffset: 0.0,
				  borderJoinStyle: 'miter',
				  pointBorderColor: "#fff",
				  pointBackgroundColor: "#141E41",
				  pointBorderWidth: 3,
				  pointHoverRadius: 10,
				  pointHoverBackgroundColor: "#FC2055",
				  pointHoverBorderColor: "#fff",
				  pointHoverBorderWidth: 3,
				  pointRadius: 5,
				  pointHitRadius: 100,
				  data: data1,
				  spanGaps: false
				}]
			  }; // line chart init

			  var myLineChart = new Chart(lineChart, {
				type: 'line',
				data: lineData,
				options: {
				  legend: {
					display: false
				  },
				  scales: {
					xAxes: [{
					  ticks: {
						fontSize: '11',
						fontColor: '#969da5'
					  },
					  gridLines: {
						color: 'rgba(0,0,0,0.05)',
						zeroLineColor: 'rgba(0,0,0,0.05)'
					  }
					}],
					yAxes: [{
					  display: false,
					  ticks: {
						beginAtZero: true,
						max: maxTransactionAmount
					  }
					}]
				  }
				}
			  });
			} 
	}



	function loadDonut(data)
	{
			var donutChart1 = $("#donutChart1"); // donut chart data

			  var data1 = {
				labels: ["Virtual Cards", "Physical Cards"],
				datasets: [{
				  data: data,
				  backgroundColor: ["#5797fc", "#7e6fff"],
				  hoverBackgroundColor: ["#5797fc", "#7e6fff"],
				  borderWidth: 6,
				  hoverBorderColor: 'transparent'
				}]
			  }; // -----------------
			  // init donut chart
			  // -----------------

			  new Chart(donutChart1, {
				type: 'doughnut',
				data: data1,
				options: {
				  legend: {
					display: false
				  },
				  animation: {
					animateScale: true
				  },
				  cutoutPercentage: 80
				}
			  });
	}



function viewEndOfDayList(jwtToken, count, filter, queryStr, serverToken)
{

	var url = "/api/end-of-day/get-list/1";
	var formData = new FormData();
	formData.append('token', serverToken);

	$.ajax({
		type: "POST",
		url: url,
		data: formData,
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{
				

				$.each(data.data, function (i)
                            {	  



					var y = data.data[i].id;
                                html = ' <tr> ' +
					
                                    '<td>' + data.data[i].created_at.slice(0, 16) + 'HRS</td>' +
                                    '<td>' + data.data[i].ranByUserName + '</td>' +
                                    '<td class="text-left">' + data.data[i].startDate.slice(0, 16)+ 'HRS</td>' +
                                    '<td class="text-left">' + data.data[i].endDate.slice(0, 16)+ 'HRS</td>' +
                                    '<td class="text-left">' + data.data[i].status+ '</td>' + 
                                    '<td class="text-right">' + parseFloat(data.data[i].villageBankingPenaltiesIncurred).toFixed(2) +'</td>' +
                                    ' </tr>';
                                $('#allendofdayranbody').append(html);
                            });


			}
			else
			{
				if(data.status==-1)
				{
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else {
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}





function runEndOfDay(jwtToken, count, filter, queryStr, serverToken)
{

	
	$('#runbtn').hide();
	$('#runbtnstatus').show();
	

	var url = "/api/end-of-day/run/1";
	var formData = new FormData();
	formData.append('token', serverToken);

	$.ajax({
		type: "POST",
		url: url,
		data: formData,
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			$('#runbtn').show();
			$('#runbtnstatus').hide();

			if(data.status==100)
			{
				
			}
			else
			{
				if(data.status==-1)
				{
					logoutUser('Your session has ended. Please log in to continue', window.location.href);
				}
				else
				{
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}




function createNewCollectionCustomerAccount(serverToken, jwtToken, deviceCode)
{
	console.log(jwtToken);
	jwtToken = 'Bearer ' + jwtToken;

	if (($('#new_collection_account').validator('validate').has('.has-error').length)) {
		//alert('SOMETHING WRONG');
		toastr.error("Provide all required information before submitting");
	} else {
		var formData = new FormData();
		formData.append('customerId', $('#addNewCollectionCustomerId').val());
		formData.append('accountName', $('#accountName').val());
		formData.append('deviceCode', deviceCode);
		formData.append('currencyCode', $('#currencyCode').val());
		formData.append('token', serverToken);

		console.log(formData);
		var url = '/api/accounts/add-new-collection-account';
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
					if(data1.status==100)
					{
						$('#dismissBtn').click();
						toastr.success(data1.message);
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.message);
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
	}
	
}




function viewAddCorporateAccount(jwtToken, customerId)
{
	//alert(33);
	$('#dismissBtn').click();
	$('#addNewCollectionCustomerId').val(customerId);
	$('#add_new_collections_account_modal').show();
}





function handleShowJournalEntryListing(jwtToken, filter)
{
	var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
	$.ajax({
		type: "GET",
		url: "/api/ecards/get-journal-entrieslist-ajax" + "?" + filter,
		data: [],
		processData: false,
		contentType: false,
		cache: false,
		headers: {"Authorization": jwtToken},
		timeout: 600000,
		success: function (data) {
			console.log(data);
			if(data.status==100)
			{


				var jeList = data.jeList;
				var glAccountTypes = data.glAccountTypes;
				var serviceTypes = data.serviceTypes;
				var allJeList = [];
				var totalCredit = 0.00;
				var totalDebit = 0.00;
				for(var k=0; k<jeList.length; k++)
				{
					var vlDate = new Date(jeList[k].valueDate);
					var hrs = vlDate.getHours();
					hrs = hrs<10 ? ("0"+hrs) : hrs;
					var mins = vlDate.getMinutes();
					mins = mins<10 ? ("0"+mins) : mins;
					var jeEntry = [];
					jeEntry['sno'] = (k+1) + ".";
					jeEntry['serviceType'] = serviceTypes[jeList[k].serviceType];
					jeEntry['name'] = jeList[k].firstName + ' ' + jeList[k].lastName;
					jeEntry['valueDate'] = vlDate.getFullYear() + ", " + months[vlDate.getMonth()] + " " + vlDate.getDate() + " " + hrs + ":" + mins;
					jeEntry['transactionRef'] = '<b>' + (jeList[k].transactionRef==undefined ? "N/A" : jeList[k].transactionRef) + '</b>';
					jeEntry['glAccountDetails'] = '<a href="/accountant/gl-accounts/all-journal-entries?glaccountid='+jeList[k].glAccountId+'&'+(filter!=undefined && filter.length>0 ? filter : '')+'">' + jeList[k].glAccountCode + '</a><br>' + jeList[k].glAccountName+ '<br><i>' + glAccountTypes[jeList[k].glAccountType] + '</i>';
					jeEntry['debitAmount'] = '<b>' + (jeList[k].debitCredit==0 ? jeList[k].amount.toFixed(2) : '') + '</b>';
					jeEntry['creditAmount'] = '<b>' + (jeList[k].debitCredit==1 ? jeList[k].amount.toFixed(2) : '') + '</b>';

					jeEntry['isManualEntry'] = jeList[k].isManualEntry!=undefined && jeList[k].isManualEntry==false ? 'No' : 'Yes';
					allJeList.push(jeEntry);

					totalCredit = totalCredit + (jeList[k].debitCredit==1 ? jeList[k].amount : 0);
					totalDebit = totalDebit + (jeList[k].debitCredit==0 ? jeList[k].amount : 0);
				}
				console.log(allJeList);



				

				$('#journalentrylist').DataTable({
					//"ajax": "/get-customer-list-ajax",



					dom: 'Bfrtip',
        				buttons: [
            					'copy', 'csv', 'excel', {
							extend: 'pdfHtml5',
							exportOptions: {
                    						columns: [ 0, 1, 2, 5, 6, 7 ]
							},
							orientation: 'landscape',
							pageSize: 'LEGAL'
						}, 'print'
        				],
					"lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],

					"data": allJeList,
					"columns": [
						{ "data": "sno" },
						{ "data": "transactionRef" },
						{ "data": "valueDate" },
						{ "data": "isManualEntry" },
						{ "data": "serviceType" },
						{ "data": "name" },
						{ "data": "glAccountDetails" },
						{ "data": "debitAmount" },
						{ "data": "creditAmount" },
					]
				});

				$('#debitTotal').html(totalDebit.toLocaleString('en-US', {maximumFractionDigits:2}));
				$('#creditTotal').html(totalCredit.toLocaleString('en-US', {maximumFractionDigits:2}));





			}
			else
			{
				if(data.status==-1)
				{
					toastr.error(data.message);
					window.location = '/logout';
				}
				else {
					toastr.error(data.message);
				}
			}
		},
		error: function (e) {
			console.log(e);
			toastr.error('We encountered an error. Please try again');
		}
	});
}






function viewNewSupportMessage()
{
	$(".allfloater").fadeOut();
	$("#newSupportWrapper").fadeIn();
	
	
}




function viewNewSupportMessageReply(messageid, mId)
{
	$(".allfloater").fadeOut();
	$("#newSupportReplyWrapper").fadeIn();
	$('#currentMessageId').html(messageid);
	$('#supportMessageIdForm').val(mId);
	
	
}




function submitNewSupportMessage(jwtToken, sessionToken, deviceCode)
{
		//var form = $('#vbsettingsform')[0];
		//var formData = new FormData(form);
		var url = '/api/support/create-support-message-for-admin';
		var formData = new FormData();
		formData.append('deviceCode', deviceCode);
		formData.append('token', sessionToken);
		formData.append('transactionDate', $("#transactionDate").val());
		formData.append('transactionRef', $("#transactionRef").val());
		formData.append('transactionAmount', $("#transactionAmount").val());
		formData.append('appVersion', $("#appVersion").val());
		formData.append('walletNumber', $("#walletNumber").val());
		formData.append('cardNumber', $("#cardNumber").val());
		formData.append('details', $("#details").val());
		formData.append('customerNumber', $("#customerNumber").val());

		$.ajax({
			type: "POST",
			url: (url),
			data: (formData),
			processData: false,
			contentType: false,
			cache: false,
			headers: {"Authorization": 'Bearer '+ jwtToken},
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				if(data1.success===true)
				{
					//alert(33);
					console.log(data1.data.supportMessageResp);
					if(data1.data.supportMessageResp.status==5000)
					{
						$('#dismissBtn').click();
						//$('#new_card_modal').show();
						toastr.success(data1.data.supportMessageResp.message);
						window.location = '/potzr-staff/support-messages';
					}
					else if(data1.data.supportMessageResp.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.data.supportMessageResp.message);
					}
					//toastr.success(data1.message);
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
}






function updateSupportMessage(jwtToken, sessionToken, deviceCode)
{
		//var form = $('#vbsettingsform')[0];
		//var formData = new FormData(form);
		var url = '/api/support/create-support-message-for-admin';
		var formData = new FormData();
		formData.append('deviceCode', deviceCode);
		formData.append('token', sessionToken);
		formData.append('supportMessageId', $("#supportMessageIdForm").val());
		formData.append('details', $("#detailsReply").val());
		formData.append('sendSMS', 1);

		console.log($("#detailsReply").val());

		$.ajax({
			type: "POST",
			url: (url),
			data: (formData),
			processData: false,
			contentType: false,
			cache: false,
			headers: {"Authorization": 'Bearer '+ jwtToken},
			timeout: 600000,
			success: function handleSuccess(data1){
				console.log(data1);
				if(data1.success===true)
				{
					//alert(33);
					if(data1.data.supportMessageResp.status==5000)
					{
						$('#dismissBtn').click();
						toastr.success(data1.data.supportMessageResp.message);
					}
					else if(data1.status==-1)
					{
						console.log(window.location);
						logoutUser('Your session has ended. Please log in to continue', window.location.href);
					}
					else
					{
						toastr.error(data1.message);
					}
					//
				}
				else
				{
						toastr.error(data1.message);
						$('#dismissBtn').click();
						$('#new_card_modal').show();
					
				}
			},
			error: function (e) {
				toastr.error('We experienced an issue updating your merchant profile. Please try again.');
			}
		});
}