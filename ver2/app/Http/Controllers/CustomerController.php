<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getNewCustomer(Request $request)
    {
        //province, card scheme, gender, account type, currency, card type
        $user = \Auth::user();
        $all_card_schemes = $this->all_card_schemes;
        $all_provinces = $this->all_provinces;
        $all_countries = $this->countries;
        $countries = $this->countries;

        // /dd($all_card_schemes);

        $all_issuers=$this->all_issuers;

        $all_account_type = getAllAccountType();
        $all_currency = getAllCurrency();
        $all_card_type = getAllCardType();
		$all_identification_types = getAllIdentificationType();
		$all_customer_types = getAllCustomerTypes();

        return view('core.authenticated.customer.new_customer_step_1', compact('all_card_schemes',
            'all_provinces', 'all_account_type', 'all_currency', 'all_card_type', 'all_countries',
			'all_identification_types', 'all_customer_types', 'countries', 'request', 'all_issuers'));
    }



    public function getNewCustomerStepTwo()
    {

        $user = \Auth::user();
        $all_account_type = getAllAccountType();
        $all_currency = getAllCurrency();
        $data = \Session::get('data');
        return view('core.authenticated.customer.new_customer_step_2', compact('all_currency', 'all_account_type', 'data'));
    }


    public function postNewCustomerStepTwo()
    {
        $data = \Input::except('data');
        $data1 = \Session::get('data');
        $data1 = \Crypt::decrypt($data1);
        $data = $data + $data1;

        $data = \Crypt::encrypt($data);
        \Session::put('data', $data);
        return \Redirect::to('/bank-teller/customers/new-customer-step-three');
    }

    public function getNewCustomerStepThree()
    {
        $user = \Auth::user();
        $all_card_schemes = json_decode($user->all_card_schemes);
        $all_card_type = getAllCardType();
        $data = \Session::get('data');
        //dd($data);
        //dd($all_card_schemes);
        return view('core.authenticated.customer.new_customer_step_3', compact('data', 'all_card_schemes', 'all_card_type'));
    }

    public function postNewCustomerStepThree()
    {
        $data = \Input::except('data');
        $data1 = \Session::get('data');
        $data1 = \Crypt::decrypt($data1);
        $data = $data + $data1;
        //dd($data);
        $data = \Crypt::encrypt($data);
        \Session::put('data', $data);
        return \Redirect::to('/bank-teller/customers/new-customer-step-four');
    }


    public function getNewCustomerStepFour()
    {
        $user = \Auth::user();
        $all_card_schemes = json_decode($user->all_card_schemes);
        $all_account_type = getAllAccountType();
        $all_currency = getAllCurrency();
        $all_card_type = getAllCardType();
        $all_provinces = json_decode($user->all_provinces);
        $data = \Session::get('data');
        $data1 = \Crypt::decrypt($data);
        //dd($data1);
        return view('core.authenticated.customer.new_customer_step_4', compact('all_provinces', 'data1', 'all_card_schemes', 'all_account_type', 'all_currency', 'all_card_type', 'data'));
    }

    public function postNewCustomerStepFour()
    {

        $data = \Input::all();
        $data = \Crypt::decrypt($data['data']);
        //dd($data);
        $data1['addressLine1'] = $data['addressLine1'];
        $data1['addressLine2'] = $data['addressLine2'];
        $data1['altContactEmail'] = $data['altEmail'];
        $data1['altContactMobile'] = $data['countryalt']."".$data['altMobileNo'];
        $data1['contactEmail'] = $data['email'];
        $data1['contactMobile'] = $data['country']."".$data['mobileNo'];
        $data1['dateOfBirth'] = $data['dateOfBirth'];
        $data1['firstName'] = $data['firstName'];
        $data1['gender'] = $data['gender'];
        $data1['lastName'] = $data['lastName'];
        $data1['otherName'] = $data['otherName'];
        $data1['locationDistrict_id'] = explode('_', $data['district'])[0];
        $data1['cardSchemeId'] = explode('_', $data['cardScheme'])[1];
        $data1['nameOnCard'] = $data['nameOnCard'];
        $data1['cardType'] = $data['cardType'];
        $data1['countryCode'] = '026';
        $data1['currencyCode'] = 'ZMW';
        $data1['accountType'] = $data['accountType'];
		$data1['customerType'] = $data['customerType'];
        $data1['openingAccountAmount'] = 0.00;
        $data1['eWalletAccountCreateTrue'] = false;
        $data1['cardType'] = $data['cardType'];
        $data1['meansOfIdentificationType'] = $data['meansOfIdentificationType'];
        $data1['meansOfIdentificationNumber'] = $data['meansOfIdentificationNumber'];
        if(isset($data['customerImage']) && strlen($data['customerImage'])>0)
            $data1['customerImage'] = $data['customerImage'];

        if(isset($data['addEWallet']) && $data['addEWallet']=='on')
            $data1['eWalletAccountCreateTrue'] = true;

        $data1['mobileMoneyCreateTrue'] = false;
        if(isset($data['addMobileMoney']) && $data['addMobileMoney']=='on')
            $data1['mobileMoneyCreateTrue'] = true;

        /*if($data['verificationNumber']!=NULL && strlen($data['verificationNumber'])>0)
            $data1['verificationNumber'] = $data['verificationNumber'];*/

        $data1['token'] = \Auth::user()->token;
        $data1['customerType'] = $data['customerType'];

        dd($data1);
        $result = handleSOAPCalls('createNewCustomerAccount', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data1);

        //dd($result);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 100 || $result->status == 112)
        {
            $customerName = $result->customerName;
            $customerMobileContact = isset($result->mobileContact) ? $result->mobileContact : NULL;
            $mobacctdetail = isset($result->mobacctdetail) ? $result->mobacctdetail : NULL;
            $mob = $mobacctdetail!=NULL ? json_decode($mobacctdetail) : NULL;
            $mobPin = $mob!=NULL ? ($mob->pin) : NULL;
            $mobileContact = $mob!=NULL ? ($mob->mobileContact) : NULL;
            $card = isset($result->ecarddetail) ? json_decode($result->ecarddetail, false) : NULL;
            $ecardpin = $card!=NULL ? $card->pin : NULL;
            $ecardPan = $card!=NULL ? $card->pan : NULL;
            $ecardcvv = $card!=NULL ? $card->cvv : NULL;
            $ecardexpire = $card!=NULL ? $card->expire : NULL;
            $accountNo = isset($result->accountNo) ? $result->accountNo : NULL;
            $amountDeposited = $result->amountDeposited;
            $ecarddetail = isset($result->ecarddetail) ? json_decode($result->ecarddetail) : NULL;
            $mobacctdetail = isset($result->mobacctdetail) ? json_decode($result->mobacctdetail) : NULL;
            $pswd = isset($result->useracctid) ? $result->useracctid : NULL;
            $walletcode = isset($result->walletcode) ? $result->walletcode : NULL;




            if($accountNo!=NULL) {
                $msg = "Dear ".$customerName.".\nYour Account Details are:\n";
                $msg = $msg . "Acct No:" . $accountNo;
                $msg = $msg . "\Amount Deposited:ZMW" . $amountDeposited;
                $msg = $msg . "\n\nThank You.";
                send_sms($customerMobileContact, $msg);
            }

            if($card!=NULL)
            {
                $msg = "Dear ".$customerName.".\nYour Card Details are:\n";
                $msg = $msg."Card No:".$ecardPan;
                $msg = $msg."Card Pin:".$ecardpin;
                $msg = $msg."Expiry Date:".$ecardexpire;
                $msg = $msg."Card CVV:".$ecardcvv;
                $msg = $msg."\n\nThank You.";
                send_sms($customerMobileContact, $msg);
            }

            if($mobacctdetail!=NULL)
            {
                $msg = "Dear ".$customerName.".\nYour Mobile Account Details are:\n";
                $msg = $msg."Mobile Acct No:".$mobileContact;
                $msg = $msg."Pin:".$mobPin;
                $msg = $msg."\n\nThank You.";
                send_sms($customerMobileContact, $msg);
            }

            if($pswd!=NULL && $walletcode!=NULL)
            {
                $msg = "Dear ".$customerName.".\nYour ProbaseWallet Account Details are:\n";
                $msg = $msg."Wallet Code:".$walletcode;
                $msg = $msg."Wallet Password:".$pswd;
                $msg = $msg."\n\nThank You.";
                send_sms($customerMobileContact, $msg);
            }


            //echo ($userpasswd." - ".$walletcodedetail." - ".$mobacctdetail." - ".$mobacctdetail." - ".$ecardpin." - ".$ecardcvv." - ".$ecardexpire);
            //shoot email to customer informing them of their new account, wallet code, mob pin, card pin cvv expiry date

            //\Session::forget('data');
            return \Redirect::to('/bank-teller/customers/customer-listing')->with('success',
                $result->status==100 ? 'New Customer Profile Setup Successfully' : 'Customer Profile Updated Successfully');
        }else
        {
            return \Redirect::back()->with('error', 'Failed to access customer listing');
        }

    }


    public function getCustomerListing($status=NULL)
    {
        $data = array();
        if($status!=NULL)
            $data['status'] = strtoupper($status);

        $accessingUserRole = getRoleInterpretRoute(\Auth::user()->role_code);
        $all_issuers = $this->all_issuers;
        $userIssuer = null;

        if (\Auth::user()->role_code==\App\Models\Roles::$BANK_TELLER) {
            foreach ($all_issuers as $iss) {
                if ($iss->issuerCode==\Auth::user()->staff_bank_code) {
                    $userIssuer = $iss;
                }
            }
        }

		return view('core.authenticated.customer.customer_listing', compact('accessingUserRole', 'userIssuer'));
        /*$data['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('listCustomers', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data);

        //dd($result);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 110)
        {
            $customerlist = json_decode($result->customerlist);
            return view('core.authenticated.customer.customer_listing', compact('customerlist', 'accessingUserRole'));
        }else
        {
            return \Redirect::back()->with('error', 'Failed to access customer listing');
        }*/

    }



    public function getViewAccountCards($customerId)
    {

        $data = array();
        $data['customerIdS'] = $customerId;
        $data['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('listCustomerCards', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data);



        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 110)
        {
            $customercardlist = json_decode($result->customercardlist);
            $customer = json_decode($result->customer);
            $user = \Auth::user();
            $all_card_schemes = json_decode($user->all_card_schemes);
            $all_card_type = getAllCardType();
            return view('core.authenticated.ecards.ecard_listing', compact('customer', 'customercardlist', 'all_card_schemes', 'all_card_type'));
        }else
        {
            return \Redirect::back()->with('error', 'Failed to access customer listing');
        }
    }


    public function getViewAccounts($customerId=NULL)
    {
        $title = '';
        $description = '';
        if(\Auth::user()->role_code=='CUSTOMER') {
            $title = 'My Wallet Overview';
            $description = '';
        }
        else {
            $title = 'All Wallets';
            $description = 'List of all wallets. Use the action button to carry out an action on a wallet';
        }
        return view('core.authenticated.account.account_listing', compact('title', 'description'));
    }




	public function getViewCorporateAccounts()
	{
		$title = '';
        	$description = '';
        	if(\Auth::user()->role_code=='CUSTOMER') {
            		$title = 'My Wallet Overview';
            		$description = '';
        	}
        	else {
            	$title = 'All Corporate Wallets';
            	$description = 'List of all corporate wallets. Use the action button to carry out an action on a wallet';
        	}
        	return view('core.authenticated.account.corporate_account_listing', compact('title', 'description'));

	}

    public function getViewProfile($customerId)
    {
        $data = array();
        $data['customerId'] = $customerId;
        $data['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('getCustomer', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data);

        //dd($result);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 100)
        {
            $customer = json_decode($result->customer);

            return view('core.authenticated.customer.view_profile', compact('customer'));
        }else
        {
            return \Redirect::back()->with('error', 'Failed to access customer listing');
        }

    }



    public function getLastFiveTransactions($accountId)
    {


        $data = array();
        $data['token'] = \Auth::user()->token;
        $data['creditAccountIdS'] = $accountId;
        $data['debitAccountIdS'] = $accountId;
        $data['status'] = "SUCCESS";
        $data['count'] = intval(5);


        //$result = handleSOAPCalls('listTransactions', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/TransactionServices?wsdl', $data);
	$data = 'token='.\Auth::user()->token;
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/TransactionServicesV2/listTransactions';
        $authDataStr = sendGetRequest($url, $data);
        $authData = json_decode($authDataStr);

        //if(handleTokenUpdate($result)==false)
        //{
         //   return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        //}

        if($authData->status == 410)
        {
            $transactionList = $authData->transactionList;
            $msg = "<table class='col col-md-12'><thead><th>Date</th><th>Channel</th><th>Amount</th></thead><tbody>";
            if(sizeof($transactionList)>0) {
                foreach ($transactionList as $transaction) {
                    $msg = $msg . "<td>" . $transaction->created_at . "</td><td>" . $transaction->channel . "</td>";
                    $msg = $msg . "<td>" . number_format($transaction->amount, 2, '.', ',') . "</td>";
                }
            }else
            {
                $msg = $msg . "<td colspan='3'>No Transactions</td>";
            }
            $msg = $msg."</tbody></table>";

            return response()->json(['status' => 1,
                'msg' => $msg]);
        }else
        {
            return response()->json(['status' => 0,
                'msg' => "Error encountered pulling last five transactions"]);
        }



    }

    public function getAddNewCustomer()
    {
        $all_account_type = getAllAccountType();
        $all_currency = getAllCurrency();
        return view('core.authenticated.account.new_account_step_1', compact('all_account_type', 'all_currency'));
    }

    public function getAddNewCustomerStepTwo()
    {
        $user = \Auth::user();
        $all_card_schemes = json_decode($user->all_card_schemes);
        $all_card_type = getAllCardType();
        $data = \Session::get('data');
        return view('core.authenticated.account.new_account_step_2', compact('all_card_schemes', 'all_card_type', 'data'));
    }

    public function getAddNewCustomerStepThree()
    {
        $user = \Auth::user();
        $all_card_schemes = json_decode($user->all_card_schemes);
        $all_account_type = getAllAccountType();
        $all_currency = getAllCurrency();
        $all_card_type = getAllCardType();
        $all_provinces = json_decode($user->all_provinces);
        $data = \Session::get('data');
        $data1 = \Crypt::decrypt($data);
        return view('core.authenticated.account.new_account_step_3', compact('all_account_type', 'all_currency', 'all_card_schemes', 'all_card_type', 'data', 'data1'));
    }


    public function postViewProfile()
    {
        $data = \Input::get('data');
        $customer = \Crypt::decrypt($data);
        $user = \Auth::user();
        $all_card_schemes = json_decode($user->all_card_schemes);
        $all_account_type = getAllAccountType();
        $all_currency = getAllCurrency();
        $all_card_type = getAllCardType();
        $all_provinces = json_decode($user->all_provinces);

        return view('core.authenticated.customer.update_profile', compact('customer', 'all_provinces', 'data1', 'all_card_schemes', 'all_account_type', 'all_currency', 'all_card_type', 'data'));
    }


    public function getProfileUpdateView($customerId)
    {
        $user = \Auth::user();
        $all_card_schemes = json_decode($user->all_card_schemes);
        $all_account_type = getAllAccountType();
        $all_currency = getAllCurrency();
        $all_card_type = getAllCardType();
        $all_provinces = json_decode($user->all_provinces);
        $all_countries = json_decode($user->all_countries);

        $data = array();
        $data['customerId'] = $customerId;
        $data['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('getCustomer', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data);

        //dd($result);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 100)
        {
            $customer = json_decode($result->customer);
            return view('core.authenticated.customer.update_profile', compact('all_countries', 'customer', 'all_provinces', 'data1', 'all_card_schemes', 'all_account_type', 'all_currency', 'all_card_type', 'data'));
        }else
        {
            return \Redirect::back()->with('error', 'Failed to access customer listing');
        }


    }

    public function postUpdateCustomer()
    {
        $data = \Input::all();
        //dd($data);
        $data1['addressLine1'] = $data['addressLine1'];
        $data1['addressLine2'] = $data['addressLine2'];
        $data1['altContactEmail'] = $data['altEmail'];
        $data1['altContactMobile'] = $data['countryalt']."".$data['altMobileNo'];
        $data1['contactMobile'] = $data['country']."".$data['mobileNo'];
        $data1['dateOfBirth'] = $data['dateOfBirth'];
        $data1['firstName'] = $data['firstName'];
        $data1['gender'] = $data['gender'];
        $data1['lastName'] = $data['lastName'];
        $data1['otherName'] = $data['otherName'];
        $data1['customerId'] = $data['customerId'];
        $data1['locationDistrict_id'] = explode('_', $data['district'])[0];
        $data1['token'] = \Auth::user()->token;


        $result = handleSOAPCalls('createNewCustomerAccount', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data1);

        //dd($result);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 114)
        {
            $customerName = $result->customerName;
            $customerMobileContact = isset($result->mobileContact) ? $result->mobileContact : NULL;
            $mobacctdetail = isset($result->mobacctdetail) ? $result->mobacctdetail : NULL;
            $mob = $mobacctdetail!=NULL ? json_decode($mobacctdetail) : NULL;
            $accountNo = isset($result->accountNo) ? $result->accountNo : NULL;




            if($customerName!=NULL) {
                $msg = "Dear ".$customerName.".\nYour Account has been updated successfully. If you did not initiate ";
                $msg = $msg."this update, kindly contact us";
                $msg = $msg . "\n\nThank You.";
                send_sms($customerMobileContact, $msg);
            }



            \Session::forget('data');
            return \Redirect::to('/bank-teller/customers/customer-listing');
        }else
        {
            return \Redirect::back()->with('error', 'Failed to perform an update on customer profile');
        }
    }




	public function getOrderPhysicalCard()
	{
        return view('core.authenticated.ecards.order_physical_card');
    }


    public function postOrderPhysicalCard()
    {
		//$data = \Input::all();
        $data1['customerId'] = 4;
        $data1['acquirerId'] = 1;
        $data1['cardSchemeId'] = 2;
        $data1['currencyCodeId'] = "ZMW";
        $data1['poolAccountId'] = "1";
        $data1['corporateCustomerId'] = null;
        $data1['corporateCustomerAccountId'] = null;
		$data1 = \Crypt::encrypt(json_encode($data1));
		$data = [];
		$data['encryptedData'] = $data1;
		$data['token'] = \Auth::user()->token;
		//dd($data);
        $result = handleSOAPCalls('orderNewTutukaCompanionPhysicalCard', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/TutukaServices?wsdl', $data);

        dd($result);
	}

}
