<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\ApplicationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('utility/services/pull-users', 'App\Http\Controllers\ApplicationController@pullUsersNoToken');
Route::get('/utility/services/pull-district/{x}', 'App\Http\Controllers\ApplicationController@pullDistrictsByProvince');
Route::get('/utility/services/pull-district-by-country/{x}', 'App\Http\Controllers\ApplicationController@pullDistrictsByCountry');
Route::get('utility/services/pull-province/{x}', 'App\Http\Controllers\ApplicationController@pullProvincesByCountry');
Route::get('utility/services/pull-vendor-service/{x}', 'App\Http\Controllers\ApplicationController@pullVendorServicesByMerchant');
Route::get('/transaction/check-status/{merchantCode}/{deviceCode}/{transactionRef}/{hash}', 'App\Http\Controllers\TransactionController@checkTransactionByTransactionRef');
Route::get('/transaction/confirm-payment/{merchantCode}/{deviceCode}/{transactionRef}', 'App\Http\Controllers\TransactionController@confirmTransactionByTransactionRef');
Route::get('forgot-password', 'App\Http\Controllers\Auth\AuthController@getForgotPassword');
Route::post('forgot-password', 'App\Http\Controllers\Auth\AuthController@postForgotPassword');
Route::get('view-stanbic-promo-receipts', 'App\Http\Controllers\FestivalController@viewReceipts');
Route::post('update-stanbic-promo-receipts/{id}', 'App\Http\Controllers\FestivalController@updateReceipt');
Route::get('/get-account-list-ajax', 'App\Http\Controllers\ApplicationController@pullAccountList');
Route::get('/get-account-balance-ajax/{accountId}', 'App\Http\Controllers\ApplicationController@pullAccountBalance');
Route::get('/get-default-data', 'App\Http\Controllers\ApplicationController@getDefaultData');
Route::get('/get-mobile-money-list-ajax', 'App\Http\Controllers\ApplicationController@pullMobileMoneyList');
Route::get('/test', 'App\Http\Controllers\ApplicationController@getTest');



Route::group([
    'middleware' => ['auth'],
    'domain' => '{domain}.probasepay.com'
], function () {
    Route::get('/user/password-change', 'App\Http\Controllers\Auth\AuthController@getPasswordChange');
    Route::post('/user/password-change', 'App\Http\Controllers\Auth\AuthController@postPasswordChange');
    Route::get('utility/services/pull-transactions', 'App\Http\Controllers\ApplicationController@pullTransactionsNoToken');
});

Route::group([
    'middleware' => ['auth'],
    'domain' => 'www.{domain}.probasepay.com'
], function () {
    Route::get('/user/password-change', 'App\Http\Controllers\Auth\AuthController@getPasswordChange');
    Route::post('/user/password-change', 'App\Http\Controllers\Auth\AuthController@postPasswordChange');
    Route::get('utility/services/pull-transactions', 'App\Http\Controllers\ApplicationController@pullTransactionsNoToken');
});

Route::group([
    'middleware' => ['auth'],
    'domain' => 'probasepay.com'
], function () {
	Route::get('/menu', 'App\Http\Controllers\ApplicationController@getMenu');
    Route::get('/user/password-change', 'App\Http\Controllers\Auth\AuthController@getPasswordChange');
    Route::post('/user/password-change', 'App\Http\Controllers\Auth\AuthController@postPasswordChange');
    Route::get('utility/services/pull-transactions', 'App\Http\Controllers\ApplicationController@pullTransactionsNoToken');
    Route::get('/auth/logout',  'App\Http\Controllers\Auth\AuthController@getLogoutPay');
    Route::get('/logout',  'App\Http\Controllers\Auth\AuthController@getLogoutPay');
    Route::get('/admin-portal/dashboard', 'App\Http\Controllers\Auth\AuthController@getDashboard');
    Route::get('/admin-portal/start-service', 'App\Http\Controllers\SettingsController@getStartService');


});

/*PAYMENTS.probasepay.com*/
Route::group(['domain' => 'payments.probasepay.com'], function () {


	Route::group([
		'prefix' => '/mobile-bridge/api/v1'
	], function() {
		Route::post('/enable-biometric/{x?}', 'App\Http\Controllers\ApiController@enableBiometric');
		Route::post('/api/get-balance-by-token', 'App\Http\Controllers\ApiController@pullBalancesByToken');
		Route::post('/validate-username', 'App\Http\Controllers\Auth\AuthController@validateUsername');
		Route::post('/validate-username-for-merchants', 'App\Http\Controllers\Auth\AuthController@validateUsernameForMerchants');
	     	Route::post('/validate-nfs-account/{x?}', 'App\Http\Controllers\ApiController@postValidateNFSAccount');
		Route::get('/download-statement/{x}/{y}/{z}', 'App\Http\Controllers\ApiController@getCustomerStatement');
		Route::get('/download-receipt/{x}/{y}/{z}', 'App\Http\Controllers\ApiController@getTransactionReceipt');
		Route::get('/download-mastercard-daily-reports/{x?}', 'App\Http\Controllers\ApiController@getMasterCardDailyReports');


		Route::post('/authenticate-username', 'App\Http\Controllers\Auth\AuthController@postLoginJSONResponse');
		Route::post('/authenticate-username-by-device', 'App\Http\Controllers\Auth\AuthController@postLoginJSONResponseByDevice');
		Route::post('/recover-password', '\App\Http\Controllers\ApiController@postRecoverPassword');
        Route::post('/validate-otp', 'App\Http\Controllers\Auth\AuthController@postValidateOtpJsonResponse');
        Route::post('/validate-otp-by-device-app', 'App\Http\Controllers\Auth\AuthController@postValidateOtpByAppDeviceJsonResponse');

        Route::post('/validate-pin', 'App\Http\Controllers\Auth\AuthController@postValidatePinJsonResponse');
        Route::post('/register-customer', 'App\Http\Controllers\ApiController@postRegisterCustomer');

        Route::post('/stop-auto-bill-payment/{type?}', 'App\Http\Controllers\ApiController@postStopAutoBillPayment');
        Route::post('/start-auto-bill-payment/{type?}', 'App\Http\Controllers\ApiController@postStartAutoBillPayment');
        Route::post('/view-automatic-bill-payments/{type?}', 'App\Http\Controllers\ApiController@postViewAutomaticBillPayments');


		Route::post('/get-account-overview-ajax/{accountId}/{merchantCode?}/{deviceCode?}', 'App\Http\Controllers\ApiController@getAccountOverviewForMobile');
		Route::post('/validate-utility-meter/{x?}', 'App\Http\Controllers\ApiController@postValidateUtilityMeter');
		Route::post('/validate-utility-meter/{x?}', 'App\Http\Controllers\ApiController@postValidateUtilityMeter');
              Route::post('/purchase-airtime/{type?}', 'App\Http\Controllers\ApiController@postPurchaseAirtime');
		Route::post('/airtime-to-money-validate/{x?}', 'App\Http\Controllers\ApiController@postAirtimeToMoneyValidate');
		Route::post('/purchase-electricity/{x?}', 'App\Http\Controllers\ApiController@postPurchaseElectricity');
		Route::post('/purchase-dstv/{x?}', '\App\Http\Controllers\ApiController@postPurchaseDstv');
		Route::post('/validate-merchant/{x?}', '\App\Http\Controllers\ApiController@postValidateMerchantAndInitiateMerchantPayment');
		Route::post('/validate-qrcode/{x?}', '\App\Http\Controllers\ApiController@postValidateQRCode');
		Route::post('/validate-probase-qr-code/{x?}', '\App\Http\Controllers\ApiController@postValidateProbaseQRCode');
		Route::post('/create-probase-qr-code/{x?}', '\App\Http\Controllers\ApiController@postCreateProbaseQRCode');
		Route::post('/pay-merchant', '\App\Http\Controllers\ApiController@postPayMerchant');
		Route::post('/pay-by-probase-qr', '\App\Http\Controllers\ApiController@postPayByProbaseQR');
		Route::post('/validate-mobile-number', '\App\Http\Controllers\ApiController@postValidateMobileNumber');
	     	Route::post('/get-active-mastercard-list/{type?}', 'App\Http\Controllers\ApiController@postGetActiveMastercardList');
	     	Route::post('/get-customer-mastercard-list/{type?}', 'App\Http\Controllers\ApiController@postGetMastercardList');
		
		Route::post('/ft/{x?}', '\App\Http\Controllers\ApiController@postTransferFunds');
		Route::post('/validate-wallet/{x?}', '\App\Http\Controllers\ApiController@postValidateWallet');
		Route::post('/validate-wallet-by-mobile-number/{x?}', '\App\Http\Controllers\ApiController@validateWalletMobileNumberDetails');
		Route::post('/validate-card/{x?}', '\App\Http\Controllers\ApiController@postValidateCard');
		Route::post('/validate-mobile-number/{x?}', '\App\Http\Controllers\ApiController@postValidateMobileNumber');

		Route::post('/create-wallet/{x?}', '\App\Http\Controllers\ApiController@postAddNewCustomerAccountAndCard');
		Route::post('/create-virtual-card/{x?}', '\App\Http\Controllers\ApiController@postCreateNewCard');
		Route::post('/request-physical-card/{x?}', '\App\Http\Controllers\ApiController@postRequestNewPhysicalCard');
		Route::post('/validate-physical-card/{x?}', '\App\Http\Controllers\ApiController@postValidatePhysicalCard');
		Route::post('/validate-wallet-create-otp/{x?}', '\App\Http\Controllers\ApiController@postValidateWalletForCreation');
		Route::get('/encryot/{x?}', '\App\Http\Controllers\ApiController@getEncryptData');

		Route::post('/manage-card/{x?}', '\App\Http\Controllers\ApiController@postManageCard');
		Route::post('/transactions/get-transaction-list-ajax/{x?}', 'App\Http\Controllers\ApiController@pullTransactionList');
		Route::post('/transactions/get-reversal-list-ajax/{x?}', 'App\Http\Controllers\ApiController@pullReversalList');
		Route::post('/update-wallet/{status}/{acctid}/{x?}', 'App\Http\Controllers\ApiController@activateEWallet');
		Route::post('/setup-auto-debit/{x?}', 'App\Http\Controllers\ApiController@setupAutoDebit');
            	Route::post('/get-bank-list-ajax', 'App\Http\Controllers\ApiController@pullBankListForMobile');
            	Route::post('/get-bank-branch-list-ajax', 'App\Http\Controllers\ApiController@pullBankBranchListForMobile');
		Route::post('/update-login-options/{x?}', 'App\Http\Controllers\ApiController@postUpdateLoginOptions');
		Route::post('/get-user-summary/{x?}', 'App\Http\Controllers\ApiController@postGetUserSummary');
		Route::post('/post-update-auth-pin/{x?}', 'App\Http\Controllers\ApiController@postUpdateAuthPin');
		Route::post('/update-email-address/{x?}', 'App\Http\Controllers\ApiController@postUpdateEmailAddress');
		Route::post('/update-user-profile/{x?}', 'App\Http\Controllers\ApiController@postUpdateUserProfile');
		Route::post('/post-update-auth-password/{x?}', 'App\Http\Controllers\ApiController@postUpdatePassword');
		Route::post('/update-profile-picture/{x?}', 'App\Http\Controllers\ApiController@postUpdateProfilePicture');


		


		Route::post('/create-village-bank-group/{x?}', 'App\Http\Controllers\ApiController@postCreateVillageBankGroup');
		Route::post('/send-group-invitation/{x?}', 'App\Http\Controllers\ApiController@postSendGroupInvitation');
		Route::post('/join-group-with-code/{x?}', 'App\Http\Controllers\ApiController@postJoinGroupInvitationWithCode');
		Route::post('/village-banking-update-constitution/{x?}', 'App\Http\Controllers\ApiController@postUpdateVillageBankGroupConstitution');
		Route::post('/village-banking-summary/{x?}', 'App\Http\Controllers\ApiController@postGetVillageBankingSummary');
		Route::post('/village-banking-request-group-join/{x?}', '\App\Http\Controllers\ApiController@postRequestGroupJoin');
		Route::post('/village-banking-group-join', '\App\Http\Controllers\ApiController@postGroupJoin');
		Route::post('/village-banking-group-summary/{x?}', '\App\Http\Controllers\ApiController@postGetVillageBankingGroupSummary');		
		Route::post('/start-contributions/{x?}', '\App\Http\Controllers\ApiController@postStartContributions');
		Route::post('/validate-for-transfer/{x?}', '\App\Http\Controllers\ApiController@postValidateForTransfer');		
		Route::post('/village-banking-update-contribution-settings', '\App\Http\Controllers\ApiController@postVillageBankingUpdateContributionSettings');
		Route::post('/village-banking-update-loan-settings', '\App\Http\Controllers\ApiController@postVillageBankingUpdateLoanSettings');
		Route::post('/village-banking-join-request-list', '\App\Http\Controllers\ApiController@postGetVillageBankingJoinRequestList');
		Route::post('/village-banking-approve-join-request', '\App\Http\Controllers\ApiController@postVillageBankingApproveJoinRequest');
		Route::post('/village-banking-group-members', '\App\Http\Controllers\ApiController@postVillageBankingGroupMembers');
		Route::post('/village-banking-make-admin', '\App\Http\Controllers\ApiController@postVillageMakeAdmin');
		Route::post('/village-banking-contribution-list', '\App\Http\Controllers\ApiController@postVillageBankingContributionList');
		Route::post('/village-banking-loan-summary', '\App\Http\Controllers\ApiController@postGetVillageBankingLoanSummary');
		Route::post('/village-banking-group-activity-summary', '\App\Http\Controllers\ApiController@postGetVillageBankingGroupActivitySummary');
		Route::post('/village-banking-calculate-loan-repayment-schedule', '\App\Http\Controllers\ApiController@postCalculateLoanRepaymentSchedule');
		Route::post('/village-banking-apply-for-loan', '\App\Http\Controllers\ApiController@postApplyForVillageBankingLoan');
		Route::post('/village-banking-approve-loan', '\App\Http\Controllers\ApiController@postApproveVillageBankingLoan');
		Route::post('/village-banking-group-loans', '\App\Http\Controllers\ApiController@postGetVillageBankingLoans');
		Route::post('/get-security-questions', '\App\Http\Controllers\ApiController@postGetSecurityQuestions');
		Route::post('/get-all-notifications', '\App\Http\Controllers\ApiController@postGetAllNotifications');
		Route::post('/create-new-personal-mastercard-pass', '\App\Http\Controllers\ApiController@postCreateNewPersonalMastercardPass');
		Route::post('/send-group-message', '\App\Http\Controllers\ApiController@postCreateGroupMessage');
		Route::post('/send-support-message', '\App\Http\Controllers\ApiController@postSendSupportMessage');
		Route::post('/post-read-notification', '\App\Http\Controllers\ApiController@postReadGroupNotification');
		Route::post('/pay-contributions', '\App\Http\Controllers\ApiController@postPayGroupContributions');
		Route::post('/pay-flexible-contribution', '\App\Http\Controllers\ApiController@postPayGroupFlexibleContribution');
		Route::post('/village-banking-approve-loan-application/{x?}', '\App\Http\Controllers\ApiController@postVillageBankingApproveLoanApplication');		
		Route::post('/village-banking-loan-repayment-schedule', '\App\Http\Controllers\ApiController@postVillageBankingLoanRepaymentSchedule');		
		Route::post('/village-banking-repay-loan', '\App\Http\Controllers\ApiController@postVillageBankingLoanRepayment');
		Route::post('/remove-village-banking-group-member/{x?}', '\App\Http\Controllers\ApiController@postVillageBankingRemoveGroupMember');
		Route::post('/loan-application-window-list/{x?}', '\App\Http\Controllers\ApiController@postGetVillageBankingLoanWindow');
		Route::post('/buy-railway-ticket', '\App\Http\Controllers\ApiController@postBuyRailwayTicket');
		Route::post('/pool-account/fund-account/{type?}', '\App\Http\Controllers\ApiController@postFundAccount');
		Route::post('/pool-account/cash-out-account/{type?}', '\App\Http\Controllers\ApiController@postCashoutAccount');

		
		

		

		Route::post('/send-key-exchange', '\App\Http\Controllers\ApiController@postCreateChatKeyExchange');
		Route::post('/send-message', '\App\Http\Controllers\ApiController@postSendChatMessage');
		
		Route::post('/charge-list/{type?}', '\App\Http\Controllers\ApiController@postGetChargeList');
		Route::post('/savings-list/{type?}', '\App\Http\Controllers\ApiController@postGetSavingsList');
		Route::post('/borrowings-list/{type?}', '\App\Http\Controllers\ApiController@postGetBorrowingsList');
		Route::post('/get-lending-parameters/{type?}', '\App\Http\Controllers\ApiController@getLendingParameters');




		 
			
	});


	
	Route::get('/api/logoutuser', 'App\Http\Controllers\Auth\AuthController@getLogoutFrontViewPay');
    Route::group([
            'middleware' => ['guest']
        ], function () {
        Route::post('/api/customer-register', 'App\Http\Controllers\ApiController@postRegisterCustomer');
        Route::get('/ajax-pay-forgot-password.html/1800/{input}/{transactionRef}', 'App\Http\Controllers\Auth\AuthController@loadForgotPassword');
        Route::get('/ajax-pay-from-logged-in-new-wallet.html/100/{input}/{transactionRef}', 'App\Http\Controllers\Auth\AuthController@loadPaymentNewWalletView');
        Route::get('/ajax-pay-from-logged-in-new-wallet-step-two.html/{key}/{input}/{transactionRef}', 'App\Http\Controllers\Auth\AuthController@loadPaymentNewWalletStepTwoView');
        Route::get('/ajax-pay-from-logged-in-new-wallet-success.html/{key}/{input}/{transactionRef}', 'App\Http\Controllers\Auth\AuthController@loadPaymentNewWalletSuccessView');
        Route::get('/ajax-tokenization-success.html/{key}/{input}/{transactionRef}', 'App\Http\Controllers\Auth\AuthController@loadTokenizationSuccessView');
        Route::get('/ajax-pay-from-logged-in-new-wallet-success.html/{key}/{input}/{transactionRef}', 'App\Http\Controllers\Auth\AuthController@loadPaymentNewWalletSuccessView');
        Route::get('/ajax-pay-from-logged-in-new-wallet-otp.html/101/{input}/{transactionRef}/{transferReceipientType}/{receipientName}', 'App\Http\Controllers\Auth\AuthController@loadPaymentNewWalletOtpView');
        Route::post('/api/login-to-pay', 'App\Http\Controllers\Auth\AuthController@postLoginToPayJSONResponse');
        Route::post('/api/forgot-password', 'App\Http\Controllers\Auth\AuthController@apiPostForgotPasswordJSONResponse');
        Route::post('/api/otp-login-to-pay', 'App\Http\Controllers\Auth\AuthController@postLoginOTPToPayJsonResponse');
        Route::post('/api/pin-login-to-pay', 'App\Http\Controllers\Auth\AuthController@postLoginPinToPayJsonResponse');
        Route::post('/api/otp-validate-create-wallet', 'App\Http\Controllers\Auth\AuthController@postLoginOTPToCreateWalletJsonResponse');
	 Route::post('/api/create-wallet', 'App\Http\Controllers\EWalletController@createWallet');
        Route::get('/api/accounts/get-account-details-by-customer-number', 'App\Http\Controllers\ApiController@getCustomerAcountDetailsByCustomerNumber');


    });


    Route::group([
        'middleware' => ['auth', 'wallet-user']
    ], function () {
        Route::get('/logout', 'App\Http\Controllers\Auth\AuthController@getLogoutPay');
	    Route::get('/ajax-pay-from-logged-in-wallet.html/007/{input}/{transactionRef}', 'App\Http\Controllers\Auth\AuthController@loadPaymentWalletLoggedInView');
        Route::post('/initiate-wallet-payment', 'App\Http\Controllers\PaymentController@postInitiateWalletPayment');
        Route::post('/initiate-account-payment', 'App\Http\Controllers\PaymentController@postInitiateAccountPayment');
        Route::get('/ajax-pay-from-logged-in-wallet-otp.html/008/{input}/{orderRef}/{transactionref}/{otpRec}', 'App\Http\Controllers\PaymentController@loadPaymentWalletOTPLoggedInView');
		Route::get('/ajax-pay-from-logged-in-wallet-otp.html/0081/{input}/{orderRef}/{transactionref}/{otpRec}', 'App\Http\Controllers\PaymentController@loadPaymentAccountOTPLoggedInView');
        Route::post('/api/otp-to-confirm-pay', 'App\Http\Controllers\PaymentController@postConfirmPayment');
        Route::post('/api/otp-to-confirm-account-pay', 'App\Http\Controllers\PaymentController@postConfirmAccountPayment');
        Route::get('/ajax-pay-from-logged-in-wallet-success.html/009/{input}', 'App\Http\Controllers\PaymentController@loadPaymentWalletSuccessPaymentView');
        Route::get('/ajax-pay-from-logged-in-wallet-fail.html/{key}/{input}', 'App\Http\Controllers\PaymentController@loadPaymentWalletFailPaymentView');
        Route::get('/ajax-payment-fund-card-from-wallet.html/{key}/{input}/{orderId}/{serialNo}', 'App\Http\Controllers\PaymentController@loadFundCardFromWalletView');
        Route::get('/ajax-payment-fund-card-from-wallet-success.html/{key}/{input}/{orderId}/{serialNo}', 'App\Http\Controllers\PaymentController@loadFundCardFromWalletView');
        Route::get('/ajax-payment-fund-card-from-wallet-transfer-success.html/{key}/{input}/{transactionRef}/{newBalance}/{transferReceipientType}/{receipientName}/{amountTransferred}/{transferOrderRef}', 'App\Http\Controllers\PaymentController@loadPaymentNewWalletTransferSuccessView');
	 Route::get('/ajax-pay-from-logged-in-tokenize.html/{key}/{input}/{transactionRef}', 'App\Http\Controllers\Auth\AuthController@loadPaymentTokenizeView');
	 Route::post('/api/tokenize', 'App\Http\Controllers\PaymentController@postTokenize');
	 Route::get('/ajax-tokenize-otp.html/{key}/{input}/{ref}/{receipient}', 'App\Http\Controllers\PaymentController@loadTokenizeOtpView');
        Route::post('/api/otp-to-confirm-tokenization', 'App\Http\Controllers\PaymentController@postConfirmTokenization');
	


        Route::group(['middleware'=>['jwt.verify']], function(){
            Route::post('/api/accounts/add-new-account-and-default-card', 'App\Http\Controllers\ApiController@postAddNewCustomerAccountAndCard');
            Route::post('/api/ft/transfer-wallet-to-card', 'App\Http\Controllers\ApiController@postTransferWalletToCard');
            Route::get('/api/get-card-transaction-by-order-ref/{orderRef}/{receipientName}', 'App\Http\Controllers\ApiController@getCardTransactionByOrderRef');
	     
        });
    });

        
	Route::get('/device-payments', 'App\Http\Controllers\PaymentController@deviceStatements');
	Route::get('/make-settlement', 'App\Http\Controllers\PaymentController@makeSettlement');
    Route::get('/', 'App\Http\Controllers\PaymentController@initializePaymentForWeb');
    Route::post('/api/create-new-zicb-wallet', 'App\Http\Controllers\EWalletController@createZICBWallet');
    Route::post('/api/verify-otp-new-zicb-wallet', 'App\Http\Controllers\EWalletController@validateAndMapExistingZICBWallet');
    //Route::get('/map-account-to-wallet', 'App\Http\Controllers\PaymentController@postMapAccountToWallet');
	Route::post('/payments/get-reversal-details', 'App\Http\Controllers\PaymentController@getReversalPaymentDetails');
	Route::post('/payments/init-reversal', 'App\Http\Controllers\PaymentController@initializeReversalPayment');
    Route::get('/user/password-change', 'App\Http\Controllers\Auth\AuthController@getPasswordChange');
    Route::post('/user/password-change', 'App\Http\Controllers\Auth\AuthController@postPasswordChange');
    Route::get('/payments/init', 'App\Http\Controllers\PaymentController@initializePaymentForWeb');
    Route::get('/ajax-payment-option-details.html/{key}/{input}', 'App\Http\Controllers\PaymentController@loadPaymentOptionsDetailsView');
    Route::get('/ajax-payment-wallet-login.html/{key}/{input}', 'App\Http\Controllers\PaymentController@loadWalletLoginView');
    Route::get('/ajax-payment-details.html/{key}/{input}', 'App\Http\Controllers\PaymentController@loadPaymentDetailsView');
    Route::get('/ajax-payment-online-banking-details.html/{key}/{input}', 'App\Http\Controllers\PaymentController@loadPaymentOnlineBankingDetailsView');

	Route::get('/ajax-card-collection-view.html/{key}/{input}', 'App\Http\Controllers\PaymentController@loadCardCollectionView');
	Route::get('/ajax-otp-collection-view.html/{key}/{input}/{txnRef}/{token?}', 'App\Http\Controllers\PaymentController@loadOtpCollectionView');
	Route::get('/ajax-otp-collection-and-create-wallet-view.html/{key}/{customerId}/{data}/{token?}', 'App\Http\Controllers\PaymentController@loadOtpCollectionAndWalletCreateView');
	Route::get('/ajax-wallet-otp-collection-view.html/{key}/{input}/{txnRef}/{token}', 'App\Http\Controllers\PaymentController@loadWalletOtpCollectionView');
	Route::get('/ajax-payment-error-view.html/{key}/{transactionRef}/{input?}', 'App\Http\Controllers\PaymentController@loadPaymentErrorView');
	Route::get('/ajax-wallet-view.html/006/{transactionRef}/{input?}', 'App\Http\Controllers\PaymentController@loadPaymentErrorView');

    Route::get('/ajax-payment-details-cyb.html/{key}/{input}', 'App\Http\Controllers\PaymentController@loadPaymentDetailsViewForCybersource');

    Route::get('/ajax-payment-details-cyb.html/{key}/{input}', 'App\Http\Controllers\PaymentController@loadPaymentDetailsViewForCybersource');
    Route::get('/load-cybersource-view/{input}', 'App\Http\Controllers\PaymentController@loadBillingDetailsCaptureForCybersource');
    Route::post('/api/capture-cybersource-data', 'App\Http\Controllers\PaymentController@postCaptureCybersourceData');
    Route::post('/api/confirm-cybersource-data', 'App\Http\Controllers\PaymentController@postConfirmCybersourceData');
    //Cybersource listener
    Route::post('/payments/listener/receive_cybersource_data', 'App\Http\Controllers\PaymentController@processWebEaglePaymentOTP');
    Route::post('/cybersource/response-complete', 'App\Http\Controllers\PaymentController@handleCybersourceResponse');
    Route::post('/payments/listener/cyb/cancel-process', 'App\Http\Controllers\PaymentController@handleCybersourceCancelResponse');
    Route::get('/payments/listener/cyb/cancel-process', 'App\Http\Controllers\PaymentController@handleCybersourceCancelResponse');
    Route::get('/payments/forward-cyberpay/{data?}', 'App\Http\Controllers\PaymentController@handleForwardToCyberPay');
    Route::get('/ajax-pay-from-cybersource-handle-response.html/{key}/{billId}', 'App\Http\Controllers\PaymentController@handleHandleCybersourceInFrame');



    Route::post('/payments/confirm-payment', 'App\Http\Controllers\PaymentController@confirmPayment');
    Route::get('/payments/confirm-payment', 'App\Http\Controllers\PaymentController@confirmPayment');

    Route::post('payments/translate-payment', 'App\Http\Controllers\PaymentController@translatePay');
    Route::post('payments/process-web-eagle-go-to-otp', 'App\Http\Controllers\PaymentController@processWebEaglePaymentGoToOTP');
    Route::post('payments/process-web-eagle-process-otp', 'App\Http\Controllers\PaymentController@processWebEaglePaymentOTP');
    Route::post('payments/process-wallet-process-otp', 'App\Http\Controllers\PaymentController@processWalletPaymentsOTP');
    Route::post('payments/process-wallet-process-otp-web-ui', 'App\Http\Controllers\PaymentController@processWebWalletPaymentOTP');
	Route::post('payments/process-mobile-eagle-process-otp', 'App\Http\Controllers\PaymentController@processMobileEaglePaymentGoToOTP');
	Route::post('payments/process-mobile-eagle-process-payment', 'App\Http\Controllers\PaymentController@processMobileEaglePaymentProcessPayment');
	Route::post('payments/process-mobile-probase-pay-wallet-process-otp', 'App\Http\Controllers\PaymentController@processMobileProbasePayWalletPaymentGoToOTP');
	Route::post('payments/process-mobile-probase-pay-wallet-payment', 'App\Http\Controllers\PaymentController@processMobileProbasePayWalletPaymentProcessPayment');
	Route::post('payments/process-close-loop-no-otp', 'App\Http\Controllers\PaymentController@processMobileEaglePaymentProcessPaymentNoOTP');
	Route::post('payments/credit-card-close-loop', 'App\Http\Controllers\PaymentController@creditMobileEagleCardCloseLoopOption');




    //TUTUKA
    Route::get('payments/listen/tutuka/companion-response', 'App\Http\Controllers\PaymentController@handleTutukaGetResponse');
    Route::post('payments/listen/tutuka/companion-response', 'App\Http\Controllers\PaymentController@handleTutukaPostResponse');
    Route::get('payments/listen/tutuka/payment-response', 'App\Http\Controllers\PaymentController@handleTutukaGetResponse');
    Route::post('payments/listen/tutuka/payment-response', 'App\Http\Controllers\PaymentController@handleTutukaPostResponse');


    //UBA listener

    //Route::post('payments/listener/uba/response', 'App\Http\Controllers\PaymentController@processUBAPaymentResponse');
    //Route::post('payments/listener/uba/fail-response', 'App\Http\Controllers\PaymentController@processUBAPaymentResponse');
    //Route::post('payments/listener/uba/cancel-response', 'App\Http\Controllers\PaymentController@processUBACancelPaymentResponse');
    //bnk=UBA&refNo=7OESIFCUXQ-CVFU-RBRH-A&transactionId=CTUA408015&status=Approved
    Route::post('/listerner/uba/response', 'App\Http\Controllers\PaymentController@processUBAPaymentResponse');
    Route::post('/listerner/uba/fail-response', 'App\Http\Controllers\PaymentController@processUBAPaymentResponse');
    Route::post('/listerner/uba/cancel-response', 'App\Http\Controllers\PaymentController@processUBACancelPaymentResponse');
    Route::get('/listerner/uba/response', 'App\Http\Controllers\PaymentController@processUBAPaymentResponse');
    Route::get('/listerner/uba/response', 'App\Http\Controllers\PaymentController@processUBAPaymentResponse');
    Route::get('/listerner/uba/fail-response', 'App\Http\Controllers\PaymentController@processUBAPaymentResponse');
    Route::get('/listerner/uba/cancel-response', 'App\Http\Controllers\PaymentController@processUBACancelPaymentResponse');

    Route::post('payments/obank/response', 'App\Http\Controllers\PaymentController@handleOnlineBankResponse');
    Route::get('payments/obank/response', 'App\Http\Controllers\PaymentController@handleGetOnlineBankResponse');
//Route::get('payments/test-guzzle', 'App\Http\Controllers\PaymentController@handleTestGuzzle');
    /*Route::get('payments/error-processing/{errorData}', function($errorData){
       // dd("Error Processing");

        $errorData = \Crypt::decrypt($errorData);
        $response["statusmessage"] = $errorData['statusmessage'];
        $response["reason"] = $errorData['statusmessage'];
        $response["merchantId"] = $input['merchantId'];
        $response["deviceCode"] = $input['deviceCode'];
        $response["status"] = $errorData['status'];
        $response["transactionDate"] = $errorData['transactionDate'];
        if(isset($errorData['orderId']))
            $response["orderId"] = $errorData['orderId'];

        $str_error = $errorData['statusmessage'];
        $params = $response;
        return view('secure.submitter', compact('params', 'App\Http\Controllers\str_error'));
    });*/
});

/*WWW.PAYMENTS.probasepay.com*/
Route::group(['domain' => 'www.payments.probasepay.com'], function () {

    Route::get('/user/password-change', 'App\Http\Controllers\Auth\AuthController@getPasswordChange');
    Route::post('/user/password-change', 'App\Http\Controllers\Auth\AuthController@postPasswordChange');
    Route::post('payments/init', 'App\Http\Controllers\PaymentController@initializePaymentForWeb');
    Route::post('payments/translate-payment', 'App\Http\Controllers\PaymentController@translatePay');
    Route::post('payments/process-web-eagle-go-to-otp', 'App\Http\Controllers\PaymentController@processWebEaglePaymentGoToOTP');
    Route::post('payments/process-web-eagle-process-otp', 'App\Http\Controllers\PaymentController@processWebEaglePaymentOTP');
    Route::post('/payments/confirm-payment', 'App\Http\Controllers\PaymentController@confirmPayment');
    Route::get('/payments/confirm-payment', 'App\Http\Controllers\PaymentController@confirmPayment');

    //Cybersource listener
    Route::post('payments/listener/receive_cybersource_data', 'App\Http\Controllers\PaymentController@processWebEaglePaymentOTP');
    Route::post('payments/listener/cyb/response', 'App\Http\Controllers\PaymentController@handleCybersourceResponse');
    Route::post('payments/listener/cyb/cancel-process', 'App\Http\Controllers\PaymentController@processWebEaglePaymentOTP');
    Route::get('payments/forward-cyberpay/{data?}', 'App\Http\Controllers\PaymentController@handleForwardToCyberPay');
//Route::get('payments/test-guzzle', 'App\Http\Controllers\PaymentController@handleTestGuzzle');
    /*Route::get('payments/error-processing/{errorData}', function($errorData){
        dd("Error Processing");
    });*/
});

/*WALLET.probasepay.com*/
Route::group(['domain' => 'wallet.probasepay.com'], function () {

    //Route::get('payments/test-guzzle', 'App\Http\Controllers\PaymentController@handleTestGuzzle');
    Route::group([
        'middleware' => ['guest']
    ], function () {
        Route::get('auth/login/{x?}', 'App\Http\Controllers\Auth\AuthController@getWalletLoginView');
        Route::post('login-wallet', 'App\Http\Controllers\Auth\AuthController@postWalletLogin');
        Route::post('login-wallet-json', 'App\Http\Controllers\Auth\AuthController@postWalletLoginJSON');
        Route::post('login-wallet/otp', 'App\Http\Controllers\Auth\AuthController@postWalletLoginForOTP');
        Route::get('auth/otp-login/{x}/{data?}', 'App\Http\Controllers\Auth\AuthController@getWalletOTPLoginView');
        Route::post('auth/otp-login', 'App\Http\Controllers\Auth\AuthController@postWalletLoginOTPHandle');
        Route::post('otp-login-json', 'App\Http\Controllers\Auth\AuthController@postWalletLoginOTPHandleJSON');
        Route::post('login-festival-user', 'App\Http\Controllers\Auth\AuthController@postLoginFestivalUser');
		Route::post('create-festival-user', 'App\Http\Controllers\Auth\AuthController@createNewUser');
        Route::post('login-stanbic-promo-swiper', 'App\Http\Controllers\Auth\AuthController@postLoginStanbicPromoSwiper');
        Route::post('login-stanbic-promo-swiper2', 'App\Http\Controllers\Auth\AuthController@postLoginStanbicPromoSwiper2');



    });

    //Route::get('/', 'App\Http\Controllers\ApplicationController@tempRouteWalletToLoginPage');
    Route::get('/logout', 'App\Http\Controllers\Auth\AuthController@getLogout');
    Route::get('data/receiver_listener', 'App\Http\Controllers\ApplicationController@postReceiverListener');
    Route::post('data/receiver_listener', 'App\Http\Controllers\ApplicationController@postReceiverListener');


	Route::post('/api/create-wallet', 'App\Http\Controllers\EWalletController@createWallet');







});

/*WWW.WALLET.probasepay.com*/
Route::group(['domain' => 'www.wallet.probasepay.com'], function () {

    //Route::get('payments/test-guzzle', 'App\Http\Controllers\PaymentController@handleTestGuzzle');
    Route::group([
        'middleware' => ['guest']
    ], function () {
        Route::get('auth/login/{x?}', 'App\Http\Controllers\Auth\AuthController@getWalletLoginView');
        Route::post('login-wallet', 'App\Http\Controllers\Auth\AuthController@postWalletLogin');
        Route::post('login-wallet/otp', 'App\Http\Controllers\Auth\AuthController@postWalletLoginForOTP');
        Route::get('auth/otp-login/{x}/{data?}', 'App\Http\Controllers\Auth\AuthController@getWalletOTPLoginView');
        Route::post('auth/otp-login', 'App\Http\Controllers\Auth\AuthController@postWalletLoginOTPHandle');
    });


    Route::get('/', 'App\Http\Controllers\ApplicationController@tempRouteWalletToLoginPage');
    Route::get('/logout', 'App\Http\Controllers\Auth\AuthController@getLogout');
    Route::get('data/receiver_listener', 'App\Http\Controllers\ApplicationController@postReceiverListener');
    Route::post('data/receiver_listener', 'App\Http\Controllers\ApplicationController@postReceiverListener');


    Route::group([
        'middleware' => ['auth', 'wallet-user'],
        'prefix' => 'wallet'
    ], function () {


        Route::get('dashboard', 'App\Http\Controllers\Auth\AuthController@getDashboard');
        Route::get('profile', 'App\Http\Controllers\UserController@getProfileView');
        Route::get('payments', 'App\Http\Controllers\PaymentController@getEWalletPaymentsListing');
        Route::get('pay/customer/routed_bill/{data?}', 'App\Http\Controllers\PaymentController@getPayRoutedBill');
        Route::post('pay/customer/pay_bill', 'App\Http\Controllers\PaymentController@postPayBill');
        Route::get('pay/customer/go-to-otp/{x}', 'App\Http\Controllers\PaymentController@getGoToOTP');
        Route::post('pay/customer/pay_bill/send_otp', 'App\Http\Controllers\PaymentController@postSendOTP');
        Route::post('pay/customer/pay_customer/send_wallet_code', 'App\Http\Controllers\PaymentController@postSendWalletPayment');
        Route::get('pay/customer/pay_customer/new-payment', 'App\Http\Controllers\PaymentController@getPayNewCustomer');
        Route::get('pay/customer/pay_customer/go-to-otp/{x}', 'App\Http\Controllers\PaymentController@getPayCustomerGoToOTP');
        Route::post('pay/customer/pay_customer/send_otp', 'App\Http\Controllers\PaymentController@postPayCustomerHandleOTP');
        /*Mobile Money Payment*/
        Route::get('pay/customer/pay_customer/new-mobile-payment', 'App\Http\Controllers\PaymentController@getPayNewMobileCustomer');
        Route::post('pay/customer/pay_customer/send_wallet_code_for_mobile_payment', 'App\Http\Controllers\PaymentController@postSendWalletPaymentForMobilePayment');
        Route::get('pay/customer/pay_customer/go-to-otp-for-mobile-payment/{x}', 'App\Http\Controllers\PaymentController@getPayCustomerGoToOTPForMobilePayment');
        Route::post('pay/customer/pay_customer/send_otp_for_mobile_payment', 'App\Http\Controllers\PaymentController@postPayCustomerHandleOTPForMobilePayment');

        Route::get('pay/test', 'App\Http\Controllers\PaymentController@handleTest');
    });
});

/*probasepay.com*/
Route::group(['domain' => 'probasepay.com'], function () {

    Route::get('/', 'App\Http\Controllers\PageController@getIndex');
	Route::get('/privacy-policy', 'App\Http\Controllers\PageController@getPrivacyPolicy');
	Route::get('/play-cards', 'App\Http\Controllers\PageController@playCards');
    Route::post('/listerner/uba/response', 'App\Http\Controllers\PaymentController@processUBAPaymentResponse');
    Route::post('/listerner/uba/fail-response', 'App\Http\Controllers\PaymentController@processUBAPaymentResponse');
    Route::post('/listerner/uba/cancel-response', 'App\Http\Controllers\PaymentController@processUBACancelPaymentResponse');
    Route::get('/listerner/uba/response', 'App\Http\Controllers\PaymentController@processUBAPaymentResponse');
    Route::get('/listerner/uba/fail-response', 'App\Http\Controllers\PaymentController@processUBAPaymentResponse');
    Route::get('/listerner/uba/cancel-response', 'App\Http\Controllers\PaymentController@processUBACancelPaymentResponse');






	Route::get('/download-mobile', 'App\Http\Controllers\PageController@getDownloadMobile');
	Route::group([
        'prefix' => 'mobile-extension'
    	], function () {

		Route::get('/other-bills', 'App\Http\Controllers\BillsController@getBillsIndex');
		Route::get('/terms-and-conditions', 'App\Http\Controllers\PageController@getTermsAndConditions');
		Route::get('/coming-soon', 'App\Http\Controllers\PageController@getComingSoon');
		Route::get('/contact-us', 'App\Http\Controllers\PageController@getContactUsPage');
		Route::get('/live-support-chat', 'App\Http\Controllers\PageController@getLiveChat');
		
		
	});


    Route::group([
        'middleware' => ['guest']
    ], function () {
        Route::get('/auth/customer-register', 'App\Http\Controllers\Auth\AuthController@getRegisterCustomer');
        Route::post('/api/customer-register', 'App\Http\Controllers\ApiController@postRegisterCustomer');
        Route::get('/auth/login', 'App\Http\Controllers\Auth\AuthController@getLogin');
        Route::post('/login', 'App\Http\Controllers\Auth\AuthController@postLogin');
        Route::get('/auth/otp-login/{x}/{y?}', 'App\Http\Controllers\Auth\AuthController@getOTPLoginView');
        Route::post('/auth/otp-login', 'App\Http\Controllers\Auth\AuthController@postLoginOTP');
        Route::post('/auth/pin-login', 'App\Http\Controllers\Auth\AuthController@postLoginPin');
        Route::post('/auth/app-otp-login', 'App\Http\Controllers\Auth\AuthController@postLoginAppOTP');
	 Route::get('/ussd', 'App\Http\Controllers\MerchantController@getSendUssdRequest');


	Route::get('/ussdEmulator', 'App\Http\Controllers\MerchantController@getUSSDEmulator');
	 Route::get('/admin-portal', 'App\Http\Controllers\Auth\AuthController@getAdminPortalLoginView');
        Route::post('/admin-portal', 'App\Http\Controllers\Auth\AuthController@postAdminPortalLogin');
    });
    
    Route::get('/logout', 'App\Http\Controllers\Auth\AuthController@getLogout');
    Route::get('/pages/developers', 'App\Http\Controllers\PageController@getDevelopersPage');


    Route::group([
        'middleware' => ['api']
    ], function () {

        Route::get('/index', 'App\Http\Controllers\ApiController@index');


	


        Route::group(['middleware'=>['auth','jwt.verify']], function(){
            //CUSTOMERS
	     Route::get('/api/ecards/get-journal-entrieslist-ajax/{id?}', 'App\Http\Controllers\ApiController@pullJournalEntryList');
        	Route::post('/api/ecards/batch-card-upload-to-server', 'App\Http\Controllers\ApiController@postUploadBatchCardToServer');
		Route::post('/api/cards/change-card-pin', 'App\Http\Controllers\ApiController@postChangeCardPin');
		Route::post('/api/cards/update-card-bearer', 'App\Http\Controllers\ApiController@postUpdateCardBearer');
            Route::post('/api/cards/get-card-batches', 'App\Http\Controllers\ApiController@postGetCardBatches');
            Route::post('/api/cards/get-card-batches', 'App\Http\Controllers\ApiController@postGetCardBatches');
            Route::post('/api/cards/confirm-card-issue', 'App\Http\Controllers\ApiController@postConfirmCardIssue');

            Route::post('/api/village-banking/create-new-village-bank-group', 'App\Http\Controllers\ApiController@postCreateNewVillageBankGroup');
            Route::get('/api/village-banking/otp-validation', 'App\Http\Controllers\ApiController@postValidateVillaBankMemberOtp');
            Route::post('/api/village-banking/update-group-settings', 'App\Http\Controllers\ApiController@postUpdateVillageBankGroupSettings');
            Route::post('/api/village-banking/listing/{type?}', 'App\Http\Controllers\ApiController@postGetVillageBankingListing');
	     Route::post('/api/end-of-day/run/{type?}', 'App\Http\Controllers\ApiController@postRunEndOfDay');
	     Route::post('/api/end-of-day/get-list/{type?}', 'App\Http\Controllers\ApiController@postGetEndOfDayRanList');




            Route::post('/api/new-customer-wallet', 'App\Http\Controllers\ApiController@postCreateNewWalletAndCard');
            Route::post('/api/new-customer-card', 'App\Http\Controllers\ApiController@postCreateNewCard');
            Route::post('/api/new-account-card', 'App\Http\Controllers\ApiController@postAddCardToAccount');
            Route::get('/api/get-account-overview-ajax/{accountId}/{merchantCode?}/{deviceCode?}', 'App\Http\Controllers\ApiController@getAccountOverview');
            Route::get('/api/get-cards-overview-ajax/{accountId}/{merchantCode?}/{deviceCode?}', 'App\Http\Controllers\ApiController@getCardOverview');
            Route::post('/api/ft/transfer-wallet-to-card', 'App\Http\Controllers\ApiController@postTransferWalletToCard');
            Route::post('/api/do-funds-transfer', 'App\Http\Controllers\ApiController@postTransferFunds');
            Route::get('/api/get-customer-statistics', 'App\Http\Controllers\ApiController@getCustomerStatistics');







            Route::post('/api/validate-utility-meter/{type?}', 'App\Http\Controllers\ApiController@postValidateUtilityMeter');
            Route::post('/api/purchase-airtime/{type?}', 'App\Http\Controllers\ApiController@postPurchaseAirtime');
            Route::post('/api/purchase-electricity', 'App\Http\Controllers\ApiController@postPurchaseElectricity');
            Route::post('/api/purchase-dstv', 'App\Http\Controllers\ApiController@postPurchaseDstv');
	     Route::post('/api/transactions/get-reversal-list-ajax/{x?}', 'App\Http\Controllers\ApiController@pullReversalList');


            Route::get('/api/merchants/confirm-merchant-exists/{merchantName}/{merchantId?}', 'App\Http\Controllers\ApiController@checkIfMerchantExists');
            Route::post('/api/merchants/update-merchant-bio-data', 'App\Http\Controllers\ApiController@postUpdateMerchantBioData');
            Route::post('/api/merchants/update-merchant-bank-and-scheme', 'App\Http\Controllers\ApiController@postUpdateMerchantBankAndScheme');
            Route::post('/api/merchants/new-merchant-device', 'App\Http\Controllers\ApiController@postAddNewMerchantDevice');
            Route::get('/api/merchants/list-ajax', 'App\Http\Controllers\ApiController@getMerchantList');
            Route::get('/api/devices/get-device-list-ajax/{merchantId?}', 'App\Http\Controllers\ApiController@pullDeviceList');
            Route::get('/api/devices/get-device-ajax/{deviceId}', 'App\Http\Controllers\ApiController@pullDevice');
            Route::get('/api/banks/get-bank-list-ajax', 'App\Http\Controllers\ApiController@pullBankList');
            Route::get('/api/cards/list-card-schemes-ajax', 'App\Http\Controllers\ApiController@pullCardSchemeList');
            Route::get('/api/ecards/get-card-scheme/{id}', 'App\Http\Controllers\ApiController@getECardScheme');
            Route::get('/api/get-customer-card-list-ajax/{customerId?}', 'App\Http\Controllers\ApiController@pullCustomerCardList');

            Route::get('/api/get-support-message-list-ajax', 'App\Http\Controllers\ApiController@pullSupportMessageList');
            Route::get('/api/get-customer-card-request-list-ajax', 'App\Http\Controllers\ApiController@pullCustomerCardRequestList');
            Route::get('/api/get-customer-account-list-ajax/{customerId?}', 'App\Http\Controllers\ApiController@pullCustomerAccountList');
            Route::get('/api/get-corporate-customer-account-list-ajax/{customerId?}', 'App\Http\Controllers\ApiController@pullCorporateCustomerAccountList');
            Route::get('/api/get-customer-account-by-user-ajax/{customerId?}', 'App\Http\Controllers\ApiController@pullCustomerAccountByUserId');
	     Route::post('/api/account/find-customer-by-account-number', 'App\Http\Controllers\ApiController@pullCustomerByAccountNumber');
	     Route::post('/api/account/issue-physical-card-to-account', 'App\Http\Controllers\ApiController@issuePhysicalCardToAccount');
	     Route::post('/api/ecards/get-bin-ecard-status', 'App\Http\Controllers\ApiController@getBinCardStatus');

		
            Route::post('/api/ecards/new-card-scheme', 'App\Http\Controllers\ApiController@postNewCardScheme');
            Route::get('/api/get-batch-cards-ajax/{index?}/{count?}', 'App\Http\Controllers\ApiController@pullBatchCards');
            Route::get('/api/get-customer-list-ajax/{index?}/{count?}', 'App\Http\Controllers\ApiController@pullCustomerList');
            Route::post('/api/accounts/create-new-account', 'App\Http\Controllers\ApiController@postCreateNewCustomer');
            Route::post('/api/accounts/add-new-account', 'App\Http\Controllers\ApiController@postAddNewCustomerAccount');
            Route::post('/api/accounts/add-new-collection-account', 'App\Http\Controllers\ApiController@postAddNewCollectionAccount');
            Route::post('/api/customers/new-customer', 'App\Http\Controllers\ApiController@postNewCustomer');
            Route::get('/get-account-card-list-ajax/{customerId}', 'App\Http\Controllers\ApiController@pullAccountCardList');


            Route::get('/api/accounts/activate-wallet/{status}/{x}', 'App\Http\Controllers\ApiController@activateEWallet');
            Route::get('/api/get-customer-profile-ajax/{customerId}', 'App\Http\Controllers\ApiController@pullCustomerProfile');

            Route::get('/api/get-card-balance-ajax/{cardId}', 'App\Http\Controllers\ApiController@pullCardBalance');
            Route::post('/api/ecards/card-bin-holder/{cardBinId}', 'App\Http\Controllers\ApiController@postGetCardDetailsByCardBinId');

            Route::get('/api/merchants/get-merchant-transaction-list-ajax/{id?}', 'App\Http\Controllers\ApiController@pullMerchantTransactionList');
            Route::get('/api/ecards/get-card-transaction-list-ajax/{id?}', 'App\Http\Controllers\ApiController@pullCardTransactionList');
            Route::get('/api/accounts/get-wallet-transaction-list-ajax/{id?}', 'App\Http\Controllers\ApiController@pullWalletTransactionList');

            Route::get('/api/transactions/get-transaction-list-ajax', 'App\Http\Controllers\ApiController@pullTransactionList');
            Route::get('/api/transactions/get-utilities-paid-list-ajax', 'App\Http\Controllers\ApiController@pullUtilitiesPaidList');
            Route::get('/api/banks/confirm-bank-exists/{bankName}/{bankId?}', 'App\Http\Controllers\ApiController@checkIfBankExists');
            Route::post('/api/banks/create-bank-data', 'App\Http\Controllers\ApiController@postCreateBank');
            Route::post('/api/issuers/create-issuer-data', 'App\Http\Controllers\ApiController@postCreateIssuer');

            Route::get('/api/issuers/confirm-issuer-exists/{issuerName}/{issuerCode}', 'App\Http\Controllers\ApiController@checkIfIssuerExists');
            Route::get('/api/users/get-user-list-ajax/{role?}', 'App\Http\Controllers\ApiController@getUserList');
            Route::get('/api/settings/get-application-settings-ajax', 'App\Http\Controllers\ApiController@getApplicationSettings');

            Route::post('/api/settings/update-settings', 'App\Http\Controllers\ApiController@postUpdateSettings');


            Route::post('/api/mpqr/get-mpqr-data-list', 'App\Http\Controllers\ApiController@postGetMPQRDataList');
            Route::post('/api/probaseqr/get-probaseqr-data-list', 'App\Http\Controllers\ApiController@postGetProbaseQRDataList');


		Route::post('/api/service-charges/get-service-charge-by-service-type', 'App\Http\Controllers\ApiController@postGetServiceChargeByServiceType');
		Route::post('/api/pool-account/fund-pool-account', 'App\Http\Controllers\ApiController@postFundPoolAccount');
		Route::post('/api/pool-account/fund-account', 'App\Http\Controllers\ApiController@postFundAccount');
		Route::post('/api/pool-account/view-pool-account-balance', 'App\Http\Controllers\ApiController@postViewPoolAccountBalance');

		Route::post('/api/acquirers/update-acquirer', 'App\Http\Controllers\ApiController@postUpdateAcquirer');


		Route::post('/api/journal-entries/{filter}', 'App\Http\Controllers\ApiController@postGetJournalEntries');
		 

		Route::post('/api/report/dashboard-statistics', 'App\Http\Controllers\ApiController@postGetDashboardStatistics');


		Route::get('/api/get-agent-list-ajax', 'App\Http\Controllers\ApiController@postGetAgentList');
		Route::post('/api/reverse-transaction', 'App\Http\Controllers\ApiController@postReverseTransaction');


            Route::get('/api/logs/get-logs-list-ajax', 'App\Http\Controllers\ApiController@pullLogsList');

	 	Route::post('/api/support/create-support-message-for-admin/{type?}', '\App\Http\Controllers\ApiController@postSendSupportMessageForAdmin');
		Route::get('/api/customer-loans/get-customer-loans-list-ajax/{x?}', 'App\Http\Controllers\ApiController@pullCustomerLoansList');

            




        });

    });


    Route::group([
        'middleware' => ['auth', 'bank-teller'],
        'prefix' => 'bank-teller'
    ], function () {
        Route::get('ecards/card-listing', 'App\Http\Controllers\CardController@getCardListing');
		Route::get('order-physical-card', 'App\Http\Controllers\CustomerController@getOrderPhysicalCard');
		Route::get('/create-linked-virtual-card', 'App\Http\Controllers\CustomerController@getCreateLinkedVirtualCard');
		Route::get('/get-tutuka-card-status', 'App\Http\Controllers\CustomerController@getTutukaCardStatus');
		Route::get('/activate-tutuka-physical-card', 'App\Http\Controllers\CustomerController@getActivateTutukaPhysicalCard');
		Route::get('/link-physical-card-to-customer', 'App\Http\Controllers\CustomerController@getLinkPhysicalCardToCustomer');
		Route::get('/change-physical-card-pin', 'App\Http\Controllers\CustomerController@getChangePhysicalCardPin');
		Route::get('/transfer-physical-card', 'App\Http\Controllers\CustomerController@getTransferPhysicalCard');
		Route::get('/stop-tutuka-card', 'App\Http\Controllers\CustomerController@getStopTutukaCard');
		Route::get('/unstop-tutuka-card', 'App\Http\Controllers\CustomerController@getUnstopTutukaCard');
		Route::get('/retire-tutuka-card', 'App\Http\Controllers\CustomerController@getRetireTutukaCard');
		Route::get('/update-virtual-card-cvv', 'App\Http\Controllers\CustomerController@getUpdateVirtualCardCVV');
		Route::get('/get-active-linked-cards', 'App\Http\Controllers\CustomerController@getActiveLinkedCards');
		Route::get('/update-card-bearer', 'App\Http\Controllers\CustomerController@getUpdateCardBearer');


        Route::get('/ecards/batch-card-listing', 'App\Http\Controllers\CardController@getBatchCardListing');
        Route::get('/ecards/card-scheme-listing', 'App\Http\Controllers\CardController@getCardSchemeListing');
        Route::get('/ecards/view-card-transactions/{x?}', 'App\Http\Controllers\CardController@getViewCardTransactions');
        Route::get('/merchants/view-merchant-transactions/{x?}', 'App\Http\Controllers\MerchantController@getViewMerchantTransactions');
        Route::get('/wallets/view-wallet-transactions/{x?}', 'App\Http\Controllers\AccountController@getViewWalletTransactions');
        //Route::get('/wallets/view-mpqr-transactions/{x?}', 'App\Http\Controllers\TransactionController@getTransactions');
        Route::get('/transactions/{x?}', 'App\Http\Controllers\TransactionController@getTransactions');



	



        Route::get('/dashboard', 'App\Http\Controllers\Auth\AuthController@getDashboard');
        Route::get('/wallet-overview', 'App\Http\Controllers\AccountController@getWalletOverview');
        Route::get('customers/new-customer', 'App\Http\Controllers\CustomerController@getNewCustomer');
        Route::get('customers/new-customer-step-two', 'App\Http\Controllers\CustomerController@getNewCustomerStepTwo');
        Route::post('customers/new-customer-step-two', 'App\Http\Controllers\CustomerController@postNewCustomerStepTwo');
        Route::get('customers/new-customer-step-three', 'App\Http\Controllers\CustomerController@getNewCustomerStepThree');
        Route::post('customers/new-customer-step-three', 'App\Http\Controllers\CustomerController@postNewCustomerStepThree');
        Route::get('customers/new-customer-step-four', 'App\Http\Controllers\CustomerController@getNewCustomerStepFour');
        Route::post('customers/new-customer-step-four', 'App\Http\Controllers\CustomerController@postNewCustomerStepFour');
        Route::get('customers/customer-listing', 'App\Http\Controllers\CustomerController@getCustomerListing');
        Route::post('customers/customer-listing', 'App\Http\Controllers\CustomerController@getNewCustomer');
        Route::get('customers/view-accounts/{x?}', 'App\Http\Controllers\CustomerController@getViewAccounts');
        Route::get('customers/view-account-cards/{x}', 'App\Http\Controllers\CustomerController@getViewAccountCards');
        Route::post('customers/update-customer', 'App\Http\Controllers\CustomerController@postUpdateCustomer');

        Route::get('customers/add-new-account', 'App\Http\Controllers\CustomerController@getAddNewCustomer');
        Route::get('customers/add-new-account-step-two', 'App\Http\Controllers\CustomerController@getAddNewCustomerStepTwo');
        Route::get('customers/add-new-account-step-three', 'App\Http\Controllers\CustomerController@getAddNewCustomerStepThree');


        Route::post('customers/add-new-account-step-two', 'App\Http\Controllers\CustomerController@postAddNewCustomerStepTwo');
        Route::post('customers/add-new-account-step-three', 'App\Http\Controllers\CustomerController@postAddNewCustomerStepThree');

        Route::get('customers/view-profile/{x}', 'App\Http\Controllers\CustomerController@getViewProfile');
        Route::post('customers/view-customer', 'App\Http\Controllers\CustomerController@postViewProfile');
        Route::post('customers/update-profile', 'App\Http\Controllers\CustomerController@getUpdateProfile');
        Route::get('customers/update-profile/{x}', 'App\Http\Controllers\CustomerController@getProfileUpdateView');
        Route::get('customers/last5transactions/{x?}', 'App\Http\Controllers\CustomerController@getLastFiveTransactions');


        /*Accounts*/
        Route::get('accounts/view-account-cards/{x?}', 'App\Http\Controllers\AccountController@getViewAccountCards');
        Route::get('accounts/fund-account/{aid}/{banktransactionid}/{amountPaid}', 'App\Http\Controllers\AccountController@postFundAccount');
        Route::get('accounts/add-card/{nameOnCard}/{cardType}/{cardScheme}/{addmobilemoney}/{accountId}', 'App\Http\Controllers\AccountController@addNewCardToAccount');
        Route::get('accounts/status/{y}/{x}', 'App\Http\Controllers\AccountController@updateAccountStatus');
        Route::get('accounts/download-batch-accounts-template/{primaryAccount?}', 'App\Http\Controllers\AccountController@downloadBatchAccountTemplate');
        Route::get('accounts/upload-batch-accounts-template/{primaryAccount?}', 'App\Http\Controllers\AccountController@getUploadBatchAccountTemplate');
        Route::post('accounts/upload-batch-accounts-template/{primaryAccount?}', 'App\Http\Controllers\AccountController@postUploadBatchAccountTemplate');
        Route::get('accounts/list-corporate-sub-accounts/{x}/{page?}', 'App\Http\Controllers\AccountController@getViewListCorporateSubAccounts');


        /*Cards*/
        Route::get('cards/mmoney/{action}/{aid}/{mobileNo}', 'App\Http\Controllers\CardController@addRemoveMMoney');

        /*Vendor Service*/
        Route::get('vendor-service/new-payment', 'App\Http\Controllers\PaymentController@getNewRPINPayment');
        Route::post('vendor-service/new-payment', 'App\Http\Controllers\PaymentController@postNewRPINPayment');
        Route::get('vendor-service/confirm-payment/{data}', 'App\Http\Controllers\PaymentController@getConfirmRPINPayment');
        Route::post('vendor-service/confirm-payment', 'App\Http\Controllers\PaymentController@postConfirmRPINPayment');


        /*Vendor Service*/
        Route::get('vendor-service/existing-rpin', 'App\Http\Controllers\PaymentController@getNewExistingRPINPayment');
        Route::post('vendor-service/existing-rpin', 'App\Http\Controllers\PaymentController@postNewExistingRPINPayment');
        Route::get('vendor-service/confirm-existing-rpin/{x}', 'App\Http\Controllers\PaymentController@getConfirmExistingRPINPayment');
        Route::post('vendor-service/confirm-existing-rpin', 'App\Http\Controllers\PaymentController@postConfirmExistingRPINPayment');

        /*Transactions*/
        Route::get('transactions/receive', 'App\Http\Controllers\BankController@getGenerateTransactionsReceivedForBank');
        Route::post('transactions/receive', 'App\Http\Controllers\BankController@paidGenerateTransactionsReceivedForBank');
        Route::post('transactions/paid-out', 'App\Http\Controllers\BankController@paidGenerateTransactionsPaidOutForBank');
    });


    /*Authenticated Users who are bank POTZR Staff*/
    /*
    Route::group([
        'middleware' => ['auth', 'potzr-staff'],
        'prefix' => 'potzr-staff'
    ],*/




    Route::middleware(['web', 'auth', 'exco-staff'])->prefix('exco-staff')->group(function ()
    {
	Route::get('dashboard', 'App\Http\Controllers\Auth\AuthController@getDashboard');
        Route::get('/ecards/view-card-transactions/{x?}', 'App\Http\Controllers\CardController@getViewCardTransactions');
        Route::get('/merchants/view-merchant-transactions/{x?}', 'App\Http\Controllers\MerchantController@getViewMerchantTransactions');
        Route::get('/wallets/view-wallet-transactions/{x?}', 'App\Http\Controllers\AccountController@getViewWalletTransactions');
        Route::get('/wallets/view-mpqr-transactions/{x?}', 'App\Http\Controllers\TransactionController@getTransactions');
        Route::get('/transactions/{x?}', 'App\Http\Controllers\TransactionController@getTransactions');
	 Route::get('/utilities/{vendor}', 'App\Http\Controllers\BillsController@getUtilitiesPaid');





    });
    Route::middleware(['web', 'auth', 'potzr-staff'])->prefix('potzr-staff')->group(function ()
    {
        Route::get('dashboard', 'App\Http\Controllers\Auth\AuthController@getDashboard');
		Route::get('/reports/all-reports', 'App\Http\Controllers\AccountantController@getReportView');

		Route::get('/mpqr/mpqr-listing', 'App\Http\Controllers\DeviceController@getMPQRListing');
		Route::get('/probaseqr/qr-listing', 'App\Http\Controllers\DeviceController@getProbaseQRListing');
		
		Route::get('/end-of-day', 'App\Http\Controllers\AccountantController@getEndOfDayView');
		Route::get('/utilities/{vendor}', 'App\Http\Controllers\BillsController@getUtilitiesPaid');
		Route::get('/borrow-pay-later', 'App\Http\Controllers\BillsController@getCustomerLoans');

        /*Merchant Routes*/


            Route::get('merchants/new-merchant', 'App\Http\Controllers\MerchantController@getNewMerchant');
            Route::get('merchants/merchant-listing', 'App\Http\Controllers\MerchantController@getMerchantListing');
            Route::get('merchants/view-merchant-devices/{x?}', 'App\Http\Controllers\MerchantController@getViewMerchantDevices');
            Route::get('merchants/add-merchant-device/{x?}/{y?}', 'App\Http\Controllers\MerchantController@getAddMerchantDevice');    //merchantId && deviceId



            Route::get('ecards/card-scheme-listing', 'App\Http\Controllers\CardController@getCardSchemeListing');
            Route::get('ecards/card-listing', 'App\Http\Controllers\CardController@getCardListing');
            Route::get('ecards/card-request-listing', 'App\Http\Controllers\CardController@getCardRequestListing');
            Route::get('ecards/new-card', 'App\Http\Controllers\CardController@getNewCard');


		Route::get('support-messages', 'App\Http\Controllers\CardController@getSupportMessages');


        Route::get('merchants/view-merchant-account/{x}', 'App\Http\Controllers\MerchantController@getViewMerchantAccount');
        Route::get('merchants/add-merchant-account/{x}', 'App\Http\Controllers\MerchantController@getAddMerchantAccount');
        Route::post('merchants/new-merchant-account', 'App\Http\Controllers\MerchantController@postAddMerchantAccount');
        Route::get('merchants/merchant-bank-account-listing/{x?}', 'App\Http\Controllers\MerchantController@getMerchantBankAccountListing');
        Route::get('merchants/view-merchant-transactions/{x?}', 'App\Http\Controllers\MerchantController@getViewMerchantTransactions');
        Route::get('merchants/manage-merchant-status/{x}/{y}', 'App\Http\Controllers\MerchantController@updateMerchantStatus');
        Route::get('merchants/update-merchant-account/step-one/{x}', 'App\Http\Controllers\MerchantController@getUpdateMerchantAccountStepOne');
        Route::post('merchants/update-merchant-account/step-one', 'App\Http\Controllers\MerchantController@postUpdateMerchantAccountStepOne');
        Route::get('merchants/update-merchant-account/step-two', 'App\Http\Controllers\MerchantController@getUpdateMerchantAccountStepTwo');
        Route::post('merchants/update-merchant-account/step-two', 'App\Http\Controllers\MerchantController@postUpdateMerchantAccountStepTwo');


        //Route::post('merchants/add-merchant-device/{x?}', 'App\Http\Controllers\MerchantController@postAddMerchantDevice');
        //Route::get('merchants/new-merchant-step-two', 'App\Http\Controllers\MerchantController@getNewMerchantStepTwo');
        //Route::get('merchants/new-merchant-step-three', 'App\Http\Controllers\MerchantController@getNewMerchantStepThree');
        //Route::get('merchants/new-merchant-step-four', 'App\Http\Controllers\MerchantController@getNewMerchantStepFour');

	Route::get('vb/village-banking-listing', 'App\Http\Controllers\VillageBankingController@getVillageBankingList');
        Route::get('customers/last5transactions/{x?}', 'App\Http\Controllers\CustomerController@getLastFiveTransactions');

        /*Device Routes*/


        /*Customer Routes*/

        Route::get('customers/new-customer', 'App\Http\Controllers\CustomerController@getNewCustomer');
        Route::get('customers/customer-listing', 'App\Http\Controllers\CustomerController@getCustomerListing');
        Route::post('customers/customer-listing', 'App\Http\Controllers\CustomerController@postCustomerListing');
        Route::get('customers/view-accounts/{x?}', 'App\Http\Controllers\CustomerController@getViewAccounts');
        Route::get('customers/view-account-cards', 'App\Http\Controllers\CustomerController@getViewAccountCards');
        Route::get('customers/view-profile', 'App\Http\Controllers\CustomerController@getViewProfile');
        Route::get('customers/update-profile/{x}', 'App\Http\Controllers\CustomerController@getUpdateProfile');
        Route::get('customers/last5transactions/{x?}', 'App\Http\Controllers\CustomerController@getLastFiveTransactions');

        /*Customer Account Routes*/
        Route::get('accounts/accounts-listing/{x?}', 'App\Http\Controllers\CustomerController@getViewAccounts');
        Route::get('accounts/view-account-cards/{x?}', 'App\Http\Controllers\AccountController@getViewAccountCards');

        /*Ecard Routes*/
        Route::get('ecards/new-scheme/{x?}', 'App\Http\Controllers\CardController@getNewCardScheme');
        Route::post('ecards/new-scheme', 'App\Http\Controllers\CardController@postNewCardScheme');
        //Route::get('ecards/card-scheme-listing', 'App\Http\Controllers\CardController@getCardSchemeListing');
        //Route::get('ecards/card-scheme-status/{x}', 'App\Http\Controllers\CardController@getCardSchemeListing');
        Route::get('ecards/card-status/{status}/{id}', 'App\Http\Controllers\CardController@getUpdateCardStatus');

		/*ECard Bin Routes*/
        Route::get('ecards/batch-card-listing', 'App\Http\Controllers\CardController@getBatchCardListing');
        Route::get('ecards/batch-card-upload/{x?}', 'App\Http\Controllers\CardController@getNewBatchCardUpload');
        Route::post('ecards/batch-card-upload', 'App\Http\Controllers\CardController@postUploadBatchCardTemplate');

        Route::post('ecards/batch-card-upload-v2', 'App\Http\Controllers\CardController@postUploadBatchCardTemplateV2');



		Route::get('ecards/download-batch-card-template', 'App\Http\Controllers\CardController@getDownloadBatchCardTemplate');

        /*Mobile Money Routes*/
        Route::get('mobile-money/mmoney-account-listing', 'App\Http\Controllers\MobileMoneyController@getMMoneyAccountListing');
        Route::post('mobile-money/fund-account', 'App\Http\Controllers\MobileMoneyController@postFundAccount');





        /*Banks Routes*/
        Route::get('banks/new-bank/{x?}', 'App\Http\Controllers\BankController@getNewBank');
        Route::post('banks/new-bank/{x?}', 'App\Http\Controllers\BankController@postNewBank');
            Route::get('banks/bank-listing', 'App\Http\Controllers\BankController@getBankListing');

        Route::get('acquirers/acquirer-listing', 'App\Http\Controllers\BankController@getAcquirerListing');
        Route::get('issuers/new-issuer/{x?}', 'App\Http\Controllers\BankController@getNewIssuer');
        Route::get('issuers/issuer-listing', 'App\Http\Controllers\BankController@getIssuerListing');
        Route::get('banks/bank-transactions/{x?}', 'App\Http\Controllers\BankController@getBankTransactions');
        Route::get('banks/staff-listing/{x?}', 'App\Http\Controllers\BankController@getBankStaffListing');
        Route::get('bank-staff/priviledges', 'App\Http\Controllers\BankController@getBankStaffPriviledges');


        /*Vendors*/
        Route::get('vendor-service/new-vendor-service/{x?}', 'App\Http\Controllers\VendorServiceController@getNewVendorService');
        Route::post('vendor-service/new-vendor-service/{x?}', 'App\Http\Controllers\VendorServiceController@postNewVendorService');
        Route::get('vendor-service/vendor-service-listing/{x?}', 'App\Http\Controllers\VendorServiceController@getVendorServiceListing');
        Route::get('vendor-service/last5transactions/{x}', 'App\Http\Controllers\VendorServiceController@getLast5Transactions');
        Route::get('vendor-service/status/{status}/{x}', 'App\Http\Controllers\VendorServiceController@getVendorServiceStatusUpdate');

        /*Transactions*/
        Route::get('transactions/{x?}', 'App\Http\Controllers\TransactionController@getTransactions');
        Route::get('/ecards/view-card-transactions/{x?}', 'App\Http\Controllers\CardController@getViewCardTransactions');
        Route::get('/ecards/mastercard-reports', 'App\Http\Controllers\CardController@getViewMastercardReports');
        Route::get('/ecards/get-mastercard-report/{fileName}/{date}/{type}', 'App\Http\Controllers\CardController@getDownloadMastercardReport');
        Route::get('/merchants/view-merchant-transactions/{x?}', 'App\Http\Controllers\MerchantController@getViewMerchantTransactions');
        Route::get('/wallets/view-wallet-transactions/{x?}', 'App\Http\Controllers\AccountController@getViewWalletTransactions');

        /*E-Wallet*/
        Route::get('e-wallet/e-wallet-listing', 'App\Http\Controllers\EWalletController@getEWalletListing');
        Route::get('e-wallet/view-accounts/{x}', 'App\Http\Controllers\EWalletController@getEWalletAccountListing');

        /*Devices*/
        Route::post('devices/new-device', 'App\Http\Controllers\DeviceController@postAddNewDevice');
        Route::get('devices/update-device-status/{y}/{x}', 'App\Http\Controllers\DeviceController@updateDeviceStatus');
        Route::get('devices/update-device-mode/{y}/{x}', 'App\Http\Controllers\DeviceController@updateDeviceMode');
        Route::get('devices/view-device-transactions/{x?}', 'App\Http\Controllers\DeviceController@getViewDeviceTransactions');


        /*User*/
        Route::get('register', 'App\Http\Controllers\UserController@getRegister');
        Route::post('register', 'App\Http\Controllers\UserController@postRegister');
        Route::get('user-listing/{type?}', 'App\Http\Controllers\UserController@getUserListing');


        Route::get('users/manage-user-status/{id}/{status}', 'App\Http\Controllers\UserController@getManageUserStatus');
        Route::get('users/resend-user-credentials/{id}', 'App\Http\Controllers\UserController@getResendUserCredentials');


        /*Payout*/
        Route::get('payout/generate-sheet', 'App\Http\Controllers\ReportController@getGenerateSheet');
        Route::post('payout/generate-sheet', 'App\Http\Controllers\ReportController@postGenerateSheet');
        Route::post('payout/upload-paidout-sheet', 'App\Http\Controllers\ReportController@uploadPaidOutSheet');

        /**Users*/
        Route::get('admin-staff-status/{status}/{id}', 'App\Http\Controllers\UserController@updateAdminStaffStatus');

		/*Settings*/
		Route::get('update-settings', 'App\Http\Controllers\SettingsController@getUpdateSettings');
		Route::post('update-settings', 'App\Http\Controllers\SettingsController@postUpdateSettings');
		Route::get('view-settings', 'App\Http\Controllers\SettingsController@getViewSettings');


		/**Reversals**/
		Route::get('reversal-requests', 'App\Http\Controllers\PaymentController@getReversalRequests');
		Route::get('reversal-requests/confirm-reversal/{x}', 'App\Http\Controllers\PaymentController@confirmReversal');


		Route::get('logs/{x?}', 'App\Http\Controllers\TransactionController@getLogs');
		Route::get('search-logs', 'App\Http\Controllers\TransactionController@getSearchLogs');

		Route::get('shutdown-server', 'App\Http\Controllers\SettingsController@getShutDownServer');
		Route::get('restart-server', 'App\Http\Controllers\SettingsController@getShutDownServer');

		Route::get('support-messages/close-support-message/{id}', 'App\Http\Controllers\CardController@getCloseSupportMessage');


		
    });




    /*Authenticated Users who are bank POTZR Staff*/
    Route::group([
        'middleware' => ['auth', 'App\Http\Controllers\merchant'],
        'prefix' => 'merchant'
    ], function () {
        Route::get('dashboard', 'App\Http\Controllers\Auth\AuthController@getDashboard');
        Route::get('devices/view-merchant-devices/{x}', 'App\Http\Controllers\MerchantController@getViewMerchantDevices');
        Route::get('devices/view-device-transactions/{x}', 'App\Http\Controllers\DeviceController@getViewDeviceTransactions');
        Route::get('vendor-service/vendor-service-listing/{x?}', 'App\Http\Controllers\VendorServiceController@getVendorServiceListing');
        Route::get('vendor-service/last5transactions/{x}', 'App\Http\Controllers\VendorServiceController@getLast5Transactions');
        Route::get('vendor-service/status/{status}/{x}', 'App\Http\Controllers\VendorServiceController@getVendorServiceStatusUpdate');
        Route::get('transactions/all-device/{x}', 'App\Http\Controllers\MerchantController@getMerchantTransactions');
    });



    /*Authenticated Users who are bank POTZR Staff*/
    Route::group([
        'middleware' => ['auth', 'App\Http\Middleware\AgentMiddleware'],
        'prefix' => 'agent'
    ], function () {

       Route::get('dashboard', 'App\Http\Controllers\Auth\AuthController@getDashboard');
        Route::get('/transactions/{x?}', 'App\Http\Controllers\TransactionController@getTransactions');
	Route::get('reports/all-reports', 'App\Http\Controllers\AccountantController@getReportView');
    });

    /*Authenticated Users who are bank POTZR Staff*/
    Route::group([
        'middleware' => ['auth', 'App\Http\Middleware\AccountantMiddleware'],
        'prefix' => 'accountant'
    ], function () {
       Route::get('dashboard', 'App\Http\Controllers\Auth\AuthController@getDashboard');
	Route::get('charges/new-charge-component/{x?}', 'App\Http\Controllers\AccountantController@getNewChargeComponent');
	Route::post('charges/new-charge-component/{x?}', 'App\Http\Controllers\AccountantController@postNewChargeComponent');
	Route::get('charges/charge-component-listing', 'App\Http\Controllers\AccountantController@getChargeComponentList');
	Route::get('service-charges/new-service-charge/{x}/{chargeName}', 'App\Http\Controllers\AccountantController@getNewServiceCharge');
	Route::post('service-charges/new-service-charge', 'App\Http\Controllers\AccountantController@postNewServiceCharge');
	Route::get('service-charges/list-service-charges', 'App\Http\Controllers\AccountantController@getServiceChargeListing');
	Route::get('journal-entries/setup', 'App\Http\Controllers\AccountantController@getJournalEntriesSetup');
	Route::post('journal-entries/setup', 'App\Http\Controllers\AccountantController@postJournalEntriesSetup');
	Route::get('journal-entries/view-setup', 'App\Http\Controllers\AccountantController@postViewJournalEntriesSetup');
	Route::get('journal-entries/make-journal-entry', 'App\Http\Controllers\AccountantController@getMakeJournalEntry');
	Route::post('journal-entries/make-journal-entry', 'App\Http\Controllers\AccountantController@postMakeJournalEntry');
        Route::get('/transactions/{x?}', 'App\Http\Controllers\TransactionController@getTransactions');
        Route::get('customers/customer-listing', 'App\Http\Controllers\CustomerController@getCustomerListing');

	Route::get('/end-of-day', 'App\Http\Controllers\AccountantController@getEndOfDayView');
	Route::get('/end-of-days-ran', 'App\Http\Controllers\AccountantController@getEndOfDayView');

	Route::get('/settlement-account/create', 'App\Http\Controllers\AccountantController@getCreateSettlementAccount');
	Route::get('/settlement-account/view', 'App\Http\Controllers\AccountantController@getViewSettlementAccount');


        Route::get('accounts/accounts-listing/{x?}', 'App\Http\Controllers\CustomerController@getViewAccounts');
        Route::get('accounts/view-account-cards/{x?}', 'App\Http\Controllers\AccountController@getViewAccountCards');
        Route::get('ecards/card-listing', 'App\Http\Controllers\CardController@getCardListing');
        Route::get('accounts/statement-of-account/{type?}/{x?}', 'App\Http\Controllers\AccountantController@getStatementOfAccount');

	Route::get('accounts/corporate-accounts-listing', 'App\Http\Controllers\CustomerController@getViewCorporateAccounts');
	
        /*Pool Accounts Routes*/
        Route::get('pool-accounts/new-pool-account/{x?}', 'App\Http\Controllers\AccountantController@getNewPoolAccount');
        Route::post('pool-accounts/new-pool-account', 'App\Http\Controllers\AccountantController@postNewPoolAccount');
        Route::get('pool-accounts/pool-account-listing', 'App\Http\Controllers\AccountantController@getPoolAccountListing');
        Route::get('pool-accounts/last-five-txns/{x?}', 'App\Http\Controllers\AccountantController@getLastFiveTransactions');
        Route::get('pool-accounts/fund-account/{accountId}/{txnId}/{amt}', 'App\Http\Controllers\AccountantController@fundPoolAccount');
        Route::get('pool-accounts/status/{status}/{x}', 'App\Http\Controllers\AccountantController@getUpdateAccountStatus');
	 Route::get('pool-accounts/make-trust-account/{x}/{merchantcode}/{devicecode}', 'App\Http\Controllers\AccountantController@getMakeTrustAccount');
	
        Route::get('devices/view-merchant-devices/{x}', 'App\Http\Controllers\MerchantController@getViewMerchantDevices');
        Route::get('devices/view-device-transactions/{x}', 'App\Http\Controllers\DeviceController@getViewDeviceTransactions');
        Route::get('vendor-service/vendor-service-listing/{x?}', 'App\Http\Controllers\VendorServiceController@getVendorServiceListing');
        Route::get('vendor-service/last5transactions/{x}', 'App\Http\Controllers\VendorServiceController@getLast5Transactions');
        Route::get('vendor-service/status/{status}/{x}', 'App\Http\Controllers\VendorServiceController@getVendorServiceStatusUpdate');
        Route::get('transactions/all-device/{x}', 'App\Http\Controllers\MerchantController@getMerchantTransactions');
        Route::get('pool-accounts/new-pool-account', 'App\Http\Controllers\AccountantController@getNewPoolAccount');
        Route::get('pool-accounts/list-pool-accounts', 'App\Http\Controllers\AccountantController@getPoolAccounts');
        Route::get('gl-accounts/new-gl-account/{id?}', 'App\Http\Controllers\AccountantController@getNewGLAccount');
        Route::post('gl-accounts/new-gl-account', 'App\Http\Controllers\AccountantController@postNewGLAccount');
        Route::get('gl-accounts/gl-account-listing', 'App\Http\Controllers\AccountantController@getGLAccountListing');
        Route::get('services/service-listing', 'App\Http\Controllers\AccountantController@getServiceListing');


	Route::get('gl-accounts/all-journal-entries', 'App\Http\Controllers\AccountantController@getJournalEntryListing');
	Route::post('gl-accounts/all-journal-entries', 'App\Http\Controllers\AccountantController@postJournalEntryListing');
	Route::get('accounting/income-statement', 'App\Http\Controllers\AccountantController@getIncomeStatement');
	Route::get('accounting/balance-sheet', 'App\Http\Controllers\AccountantController@getBalanceSheet');
	Route::get('accounting/capital-adequacy-report', 'App\Http\Controllers\AccountantController@getCapitalAdequacyReport');

	Route::get('agents/agent-listing', 'App\Http\Controllers\AccountantController@getAgentListing');
	Route::post('agents/fund-agent', 'App\Http\Controllers\AccountantController@postFundAgent');

	Route::get('reports/all-reports', 'App\Http\Controllers\AccountantController@getReportView');


    });


    Route::group([
        'middleware' => ['auth', 'wallet-user'],
    ], function () {

        Route::get('dashboard', 'App\Http\Controllers\Auth\AuthController@getDashboard');
        Route::get('wallet-overview', 'App\Http\Controllers\AccountController@getWalletOverviewForCustomer');
        Route::get('cards-overview', 'App\Http\Controllers\AccountController@getCardsOverviewForCustomer');
        Route::get('transactions', 'App\Http\Controllers\TransactionController@getTransactions');
        Route::get('profile', 'App\Http\Controllers\UserController@getProfileView');
        Route::get('payments', 'App\Http\Controllers\PaymentController@getEWalletPaymentsListing');
        Route::get('pay/customer/routed_bill/{data?}', 'App\Http\Controllers\PaymentController@getPayRoutedBill');
        Route::post('pay/customer/pay_bill', 'App\Http\Controllers\PaymentController@postPayBill');
        Route::get('pay/customer/go-to-otp/{x}', 'App\Http\Controllers\PaymentController@getGoToOTP');
        Route::post('pay/customer/pay_bill/send_otp', 'App\Http\Controllers\PaymentController@postSendOTP');
        Route::post('pay/customer/pay_customer/send_wallet_code', 'App\Http\Controllers\PaymentController@postSendWalletPayment');
        Route::get('pay/customer/pay_customer/new-payment', 'App\Http\Controllers\PaymentController@getPayNewCustomer');
        Route::get('pay/customer/pay_customer/go-to-otp/{x}', 'App\Http\Controllers\PaymentController@getPayCustomerGoToOTP');
        Route::post('pay/customer/pay_customer/send_otp', 'App\Http\Controllers\PaymentController@postPayCustomerHandleOTP');
        /*Mobile Money Payment*/
        Route::get('pay/customer/pay_customer/new-mobile-payment', 'App\Http\Controllers\PaymentController@getPayNewMobileCustomer');
        Route::post('pay/customer/pay_customer/send_wallet_code_for_mobile_payment', 'App\Http\Controllers\PaymentController@postSendWalletPaymentForMobilePayment');
        Route::get('pay/customer/pay_customer/go-to-otp-for-mobile-payment/{x}', 'App\Http\Controllers\PaymentController@getPayCustomerGoToOTPForMobilePayment');
        Route::post('pay/customer/pay_customer/send_otp_for_mobile_payment', 'App\Http\Controllers\PaymentController@postPayCustomerHandleOTPForMobilePayment');

        Route::get('pay/test', 'App\Http\Controllers\PaymentController@handleTest');
        Route::get('/fund-transfers', 'App\Http\Controllers\PaymentController@getFundTransfersList');
        Route::get('/transaction-adjustments', 'App\Http\Controllers\PaymentController@getTransactionAdjustmentsList');
        Route::get('/transactions', 'App\Http\Controllers\TransactionController@getTransactions');
        Route::get('/utilities-paid', 'App\Http\Controllers\TransactionController@getUtilitiesPaid');


        Route::get('/new-merchant', 'App\Http\Controllers\MerchantController@getNewMerchant');
        Route::get('/view-merchant', 'App\Http\Controllers\MerchantController@getViewMerchant');
        Route::get('/payments-received', 'App\Http\Controllers\TransactionController@getViewPaymentsReceived');



        Route::get('/my-groups', 'App\Http\Controllers\VillageBankingController@getViewMyGroups');
        Route::get('/my-group-loans', 'App\Http\Controllers\VillageBankingController@getViewGroupLoans');
        Route::get('/my-group-transactions', 'App\Http\Controllers\VillageBankingController@getViewGroupTransactions');


    });

});

/*WWW.probasepay.com*/
Route::group(['domain' => 'www.probasepay.com'], function () {

    Route::group([
        'middleware' => ['guest']
    ], function () {
        Route::get('/auth/login', 'App\Http\Controllers\Auth\AuthController@getLogin');
        Route::post('/login', 'App\Http\Controllers\Auth\AuthController@postLogin');
        Route::get('auth/otp-login/{x}', 'App\Http\Controllers\Auth\AuthController@getOTPLoginView');
        Route::post('auth/otp-login', 'App\Http\Controllers\Auth\AuthController@postLoginOTP');
    });

    Route::get('/', 'App\Http\Controllers\PageController@getIndex');
    Route::get('/logout', 'App\Http\Controllers\Auth\AuthController@getLogout');
    Route::get('/pages/developers', 'App\Http\Controllers\PageController@getDevelopersPage');


    Route::group([
        'middleware' => ['auth', 'App\Http\Controllers\bank-teller'],
        'prefix' => 'bank-teller'
    ], function () {
        Route::get('dashboard', 'App\Http\Controllers\Auth\AuthController@getDashboard');
        Route::get('customers/new-customer', 'App\Http\Controllers\CustomerController@getNewCustomer');
        Route::post('customers/new-customer', 'App\Http\Controllers\CustomerController@postNewCustomer');
        Route::get('customers/new-customer-step-two', 'App\Http\Controllers\CustomerController@getNewCustomerStepTwo');
        Route::post('customers/new-customer-step-two', 'App\Http\Controllers\CustomerController@postNewCustomerStepTwo');
        Route::get('customers/new-customer-step-three', 'App\Http\Controllers\CustomerController@getNewCustomerStepThree');
        Route::post('customers/new-customer-step-three', 'App\Http\Controllers\CustomerController@postNewCustomerStepThree');
        Route::get('customers/new-customer-step-four', 'App\Http\Controllers\CustomerController@getNewCustomerStepFour');
        Route::post('customers/new-customer-step-four', 'App\Http\Controllers\CustomerController@postNewCustomerStepFour');
        Route::get('customers/customer-listing', 'App\Http\Controllers\CustomerController@getCustomerListing');
        Route::post('customers/customer-listing', 'App\Http\Controllers\CustomerController@getNewCustomer');
        Route::get('customers/view-accounts/{x?}', 'App\Http\Controllers\CustomerController@getViewAccounts');
        Route::get('customers/view-account-cards/{x}', 'App\Http\Controllers\CustomerController@getViewAccountCards');
        Route::post('customers/update-customer', 'App\Http\Controllers\CustomerController@postUpdateCustomer');

        Route::get('customers/add-new-account', 'App\Http\Controllers\CustomerController@getAddNewCustomer');
        Route::get('customers/add-new-account-step-two', 'App\Http\Controllers\CustomerController@getAddNewCustomerStepTwo');
        Route::get('customers/add-new-account-step-three', 'App\Http\Controllers\CustomerController@getAddNewCustomerStepThree');

        Route::post('customers/add-new-account', 'App\Http\Controllers\CustomerController@postAddNewCustomer');
        Route::post('customers/add-new-account-step-two', 'App\Http\Controllers\CustomerController@postAddNewCustomerStepTwo');
        Route::post('customers/add-new-account-step-three', 'App\Http\Controllers\CustomerController@postAddNewCustomerStepThree');

        Route::get('customers/view-profile/{x}', 'App\Http\Controllers\CustomerController@getViewProfile');
        Route::post('customers/view-customer', 'App\Http\Controllers\CustomerController@postViewProfile');
        Route::post('customers/update-profile', 'App\Http\Controllers\CustomerController@getUpdateProfile');
        Route::get('customers/update-profile/{x}', 'App\Http\Controllers\CustomerController@getProfileUpdateView');
        Route::get('customers/last5transactions/{x?}', 'App\Http\Controllers\CustomerController@getLastFiveTransactions');


        /*Accounts*/
        Route::get('accounts/view-account-cards/{x?}', 'App\Http\Controllers\AccountController@getViewAccountCards');
        Route::get('accounts/fund-account/{aid}/{banktransactionid}/{amountPaid}', 'App\Http\Controllers\AccountController@postFundAccount');
        Route::get('accounts/add-card/{nameOnCard}/{cardType}/{cardScheme}/{addmobilemoney}/{accountId}', 'App\Http\Controllers\AccountController@addNewCardToAccount');

        Route::get('accounts/status/{y}/{x}', 'App\Http\Controllers\AccountController@updateAccountStatus');


        /*Cards*/
        Route::get('cards/mmoney/{action}/{aid}/{mobileNo}', 'App\Http\Controllers\CardController@addRemoveMMoney');

        /*Vendor Service*/
        Route::get('vendor-service/new-payment', 'App\Http\Controllers\PaymentController@getNewRPINPayment');
        Route::post('vendor-service/new-payment', 'App\Http\Controllers\PaymentController@postNewRPINPayment');
        Route::get('vendor-service/confirm-payment/{data}', 'App\Http\Controllers\PaymentController@getConfirmRPINPayment');
        Route::post('vendor-service/confirm-payment', 'App\Http\Controllers\PaymentController@postConfirmRPINPayment');


        /*Vendor Service*/
        Route::get('vendor-service/existing-rpin', 'App\Http\Controllers\PaymentController@getNewExistingRPINPayment');
        Route::post('vendor-service/existing-rpin', 'App\Http\Controllers\PaymentController@postNewExistingRPINPayment');
        Route::get('vendor-service/confirm-existing-rpin/{x}', 'App\Http\Controllers\PaymentController@getConfirmExistingRPINPayment');
        Route::post('vendor-service/confirm-existing-rpin', 'App\Http\Controllers\PaymentController@postConfirmExistingRPINPayment');

        /*Transactions*/
        Route::get('transactions/receive', 'App\Http\Controllers\BankController@getGenerateTransactionsReceivedForBank');
    });


    /*Authenticated Users who are bank POTZR Staff*/
    Route::group([
        'middleware' => ['auth', 'potzr-staff'],
        'prefix' => 'potzr-staff'
    ], function () {
        Route::get('dashboard', 'App\Http\Controllers\Auth\AuthController@getDashboard');
        /*Merchant Routes*/
        Route::get('merchants/new-merchant', 'App\Http\Controllers\MerchantController@getNewMerchant');
        Route::post('merchants/new-merchant-step-1', 'App\Http\Controllers\MerchantController@postNewMerchant');
        Route::get('merchants/new-merchant-step-two', 'App\Http\Controllers\MerchantController@getNewMerchantStepTwo');
        Route::post('merchants/new-merchant-step-two', 'App\Http\Controllers\MerchantController@postNewMerchantStepTwo');
        Route::get('merchants/new-merchant-step-three', 'App\Http\Controllers\MerchantController@getNewMerchantStepThree');
        Route::post('merchants/new-merchant-step-three', 'App\Http\Controllers\MerchantController@postNewMerchantStepThree');
        Route::get('merchants/new-merchant-step-four', 'App\Http\Controllers\MerchantController@getNewMerchantStepFour');
        Route::post('merchants/new-merchant-step-four', 'App\Http\Controllers\MerchantController@postNewMerchantStepFour');
        Route::get('merchants/merchant-listing', 'App\Http\Controllers\MerchantController@getMerchantListing');
        Route::get('merchants/view-merchant-account/{x}', 'App\Http\Controllers\MerchantController@getViewMerchantAccount');
        Route::get('merchants/view-merchant-transactions/{x?}', 'App\Http\Controllers\MerchantController@getViewMerchantTransactions');
        Route::get('merchants/manage-merchant-status/{x}/{y}', 'App\Http\Controllers\MerchantController@updateMerchantStatus');
        Route::get('merchants/update-merchant-account/step-one/{x}', 'App\Http\Controllers\MerchantController@getUpdateMerchantAccountStepOne');
        Route::post('merchants/update-merchant-account/step-one', 'App\Http\Controllers\MerchantController@postUpdateMerchantAccountStepOne');
        Route::get('merchants/update-merchant-account/step-two', 'App\Http\Controllers\MerchantController@getUpdateMerchantAccountStepTwo');
        Route::post('merchants/update-merchant-account/step-two', 'App\Http\Controllers\MerchantController@postUpdateMerchantAccountStepTwo');
        Route::get('merchants/view-merchant-devices/{x?}', 'App\Http\Controllers\MerchantController@getViewMerchantDevices');
        Route::get('merchants/add-merchant-device/{x?}/{y?}', 'App\Http\Controllers\MerchantController@getAddMerchantDevice');    //merchantId && deviceId
        Route::post('merchants/add-merchant-device/{x?}', 'App\Http\Controllers\MerchantController@postAddMerchantDevice');


        /*Device Routes*/


        /*Customer Routes*/
        Route::get('customers/customer-listing', 'App\Http\Controllers\CustomerController@getCustomerListing');
        Route::post('customers/customer-listing', 'App\Http\Controllers\CustomerController@postCustomerListing');
        Route::get('customers/view-accounts/{x?}', 'App\Http\Controllers\CustomerController@getViewAccounts');
        Route::get('customers/view-account-cards', 'App\Http\Controllers\CustomerController@getViewAccountCards');
        Route::get('customers/view-profile', 'App\Http\Controllers\CustomerController@getViewProfile');
        Route::get('customers/update-profile/{x}', 'App\Http\Controllers\CustomerController@getUpdateProfile');
        Route::get('customers/last5transactions/{x?}', 'App\Http\Controllers\CustomerController@getLastFiveTransactions');

        /*Customer Account Routes*/
        Route::get('accounts/accounts-listing/{x?}', 'App\Http\Controllers\CustomerController@getViewAccounts');
        Route::get('accounts/view-account-cards/{x?}', 'App\Http\Controllers\AccountController@getViewAccountCards');

        /*Ecard Routes*/
        Route::get('ecards/card-listing', 'App\Http\Controllers\CardController@getCardListing');
        Route::get('ecards/new-scheme/{x?}', 'App\Http\Controllers\CardController@getNewCardScheme');
        Route::get('ecards/card-scheme-listing', 'App\Http\Controllers\CardController@getCardSchemeListing');
        //Route::get('ecards/card-scheme-listing', 'App\Http\Controllers\CardController@getCardSchemeListing');
        //Route::get('ecards/card-scheme-status/{x}', 'App\Http\Controllers\CardController@getCardSchemeListing');
        Route::get('ecards/card-status/{status}/{id}', 'App\Http\Controllers\CardController@getUpdateCardStatus');

		/*ECard Bin Routes*/
        Route::get('ecards/batch-card-listing', 'App\Http\Controllers\CardController@getBatchCardListing');
        Route::get('ecards/batch-card-upload/{x?}', 'App\Http\Controllers\CardController@getNewBatchCardUpload');
        Route::post('ecards/batch-card-upload', 'App\Http\Controllers\CardController@postNewBatchCardUpload');


        /*Mobile Money Routes*/
        Route::get('mobile-money/mmoney-account-listing', 'App\Http\Controllers\MobileMoneyController@getMMoneyAccountListing');
        Route::post('mobile-money/fund-account', 'App\Http\Controllers\MobileMoneyController@postFundAccount');


        /*Pool Accounts Routes*/
        Route::get('pool-accounts/new-pool-account/{x?}', 'App\Http\Controllers\PoolAccountController@getNewPoolAccount');
        Route::post('pool-accounts/new-pool-account', 'App\Http\Controllers\PoolAccountController@postNewPoolAccount');
        Route::get('pool-accounts/pool-account-listing', 'App\Http\Controllers\PoolAccountController@getPoolAccountListing');
        Route::get('pool-accounts/new-pool-account/{x?}', 'App\Http\Controllers\PoolAccountController@getNewPoolAccount');
        Route::get('pool-accounts/last-five-txns/{x?}', 'App\Http\Controllers\PoolAccountController@getLastFiveTransactions');
        Route::get('pool-accounts/fund-account/{accountId}/{txnId}/{amt}', 'App\Http\Controllers\PoolAccountController@fundPoolAccount');
        Route::get('pool-accounts/status/{status}/{x}', 'App\Http\Controllers\PoolAccountController@getUpdateAccountStatus');


        /*Banks Routes*/
        Route::get('banks/new-bank/{x?}', 'App\Http\Controllers\BankController@getNewBank');
        Route::post('banks/new-bank/{x?}', 'App\Http\Controllers\BankController@postNewBank');
        Route::get('banks/bank-listing', 'App\Http\Controllers\BankController@getBankListing');
        Route::get('acquirers/acquirer-listing', 'App\Http\Controllers\BankController@getAcquirerListing');
        Route::get('issuers/issuer-listing', 'App\Http\Controllers\BankController@getIssuerListing');
        Route::get('banks/bank-transactions/{x?}', 'App\Http\Controllers\BankController@getBankTransactions');
        Route::get('banks/staff-listing/{x?}', 'App\Http\Controllers\BankController@getBankStaffListing');
        Route::get('bank-staff/priviledges', 'App\Http\Controllers\BankController@getBankStaffPriviledges');


        /*Vendors*/
        Route::get('vendor-service/new-vendor-service/{x?}', 'App\Http\Controllers\VendorServiceController@getNewVendorService');
        Route::post('vendor-service/new-vendor-service/{x?}', 'App\Http\Controllers\VendorServiceController@postNewVendorService');
        Route::get('vendor-service/vendor-service-listing/{x?}', 'App\Http\Controllers\VendorServiceController@getVendorServiceListing');
        Route::get('vendor-service/last5transactions/{x}', 'App\Http\Controllers\VendorServiceController@getLast5Transactions');
        Route::get('vendor-service/status/{status}/{x}', 'App\Http\Controllers\VendorServiceController@getVendorServiceStatusUpdate');

        /*Transactions*/
        Route::get('transactions/{x?}', 'App\Http\Controllers\TransactionController@getTransactions');

        /*E-Wallet*/
        Route::get('e-wallet/e-wallet-listing', 'App\Http\Controllers\EWalletController@getEWalletListing');
        Route::get('e-wallet/view-accounts/{x}', 'App\Http\Controllers\EWalletController@getEWalletAccountListing');

        /*Devices*/
        Route::post('devices/new-device', 'App\Http\Controllers\DeviceController@postAddNewDevice');
        Route::get('devices/update-device-status/{y}/{x}', 'App\Http\Controllers\DeviceController@updateDeviceStatus');
        Route::get('devices/view-device-transactions/{x?}', 'App\Http\Controllers\DeviceController@getViewDeviceTransactions');


        /*User*/
        Route::get('register', 'App\Http\Controllers\UserController@getRegister');
        Route::post('register', 'App\Http\Controllers\UserController@postRegister');
        Route::get('user-listing', 'App\Http\Controllers\UserController@getUserListing');


        /*Payout*/
        Route::get('payout/generate-sheet', 'App\Http\Controllers\ReportController@getGenerateSheet');
        Route::post('payout/generate-sheet', 'App\Http\Controllers\ReportController@postGenerateSheet');
        Route::post('payout/upload-paidout-sheet', 'App\Http\Controllers\ReportController@uploadPaidOutSheet');

        /**Users*/
        Route::get('admin-staff-status/{status}/{id}', 'App\Http\Controllers\UserController@updateAdminStaffStatus');

	/*Settings*/
	Route::get('update-settings', 'App\Http\Controllers\SettingsController@getUpdateSettings');
	Route::post('update-settings', 'App\Http\Controllers\SettingsController@postUpdateSettings');
	Route::get('view-settings', 'App\Http\Controllers\SettingsController@getViewSettings');



    });




    /*Authenticated Users who are bank POTZR Staff*/
    Route::group([
        'middleware' => ['auth', 'App\Http\Controllers\merchant'],
        'prefix' => 'merchant'
    ], function () {
        Route::get('dashboard', 'App\Http\Controllers\Auth\AuthController@getDashboard');
        Route::get('devices/view-merchant-devices/{x}', 'App\Http\Controllers\MerchantController@getViewMerchantDevices');
        Route::get('devices/view-device-transactions/{x}', 'App\Http\Controllers\DeviceController@getViewDeviceTransactions');
        Route::get('vendor-service/vendor-service-listing/{x?}', 'App\Http\Controllers\VendorServiceController@getVendorServiceListing');
        Route::get('vendor-service/last5transactions/{x}', 'App\Http\Controllers\VendorServiceController@getLast5Transactions');
        Route::get('vendor-service/status/{status}/{x}', 'App\Http\Controllers\VendorServiceController@getVendorServiceStatusUpdate');
        Route::get('transactions/all-device/{x}', 'App\Http\Controllers\MerchantController@getMerchantTransactions');
    });

});




