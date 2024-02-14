<?php

namespace App\Http\Controllers;

use App\Models\Lga;
use App\Models\Packages;
use App\Models\Roles;
use App\States;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Schools;
use App\Utilities\Synchronizer;
use Mailgun\Mailgun;
use Artisaninweb\SoapWrapper\SoapWrapper;

class ApplicationController extends Controller
{
	protected $soapWrapper;

    public function __construct(SoapWrapper $soapWrapper) {
		$this->soapWrapper = $soapWrapper;
        parent::__construct();
    }

    public function getTest()
    {
        /*$test = \App\Models\Test::where('id', '=', 1)->first();
        $publickey = $test->datatest;
        $privatekey = $test->datatest1;
        dd($publickey);
        $enc = "password";
        $enc = encrypt_msg_rsa($enc, $publickey);
        dd($enc);

        $villageBankGroupMember = \App\Models\VillageBankGroupMember::where('id', '=', 1)->first();
        $villageBankGroup = \App\Models\VillageBankGroup::where('id', '=', 1)->first();
        //dd($villageBankGroup);
        dd([$villageBankGroup, $villageBankGroupMember->password]);*/


	$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
        //dd($defaultAcquirer->toArray());
        if($defaultAcquirer==null)
        {
            return response()->json(['message' => 'Error encountered. ERR00AQ1', 'success'=>false], 200);
        }

        $defaultAcquirer = $defaultAcquirer->toArray();
	$encrypterFrom = new \Illuminate\Encryption\Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
       $dd = $encrypterFrom->decrypt("8ee71add842c5a5e610582eab98d115c1c2f64b2a1b599b2d8f028b849025f5510ff73743b08ce398a8cb996ab0f1501ac3c412b9c5391f15254e9c17b579068");


	dd($dd);
    }

	public function getLogin()
	{
		return view('core.auth.login');
	}


	public function getMenu()
	{
		return view('core.authenticated.admin_user.temp_menu');
	}

	public function pullUsersNoToken()
	{

		//$result = handleSOAPCalls($this->soapWrapper, 'UserServices', 'listAllUsersNoToken', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/UserServices?wsdl',
		//		[]);
		//dd($result);
		//$userListing = json_decode($result->userList);


		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UserServices/listAllUsersNoToken';
		try
		{
			$df = sendPostRequest($url, []);
			dd($df);
			$userListing = sendGetRequest($url, []);
			$userListing = json_decode($userListing);
			$userListing = $userListing->userList;
			return view('guests.user_listing', compact('userListing'));
		}
		catch(\Exception $e)
		{
			dd($e);
		}
	}


	public function getDefaultData()
	{
		$user = \Auth::user();
        $all_card_schemes = json_decode($user->all_card_schemes);
        $all_account_type = getAllAccountType();
        $all_currency = getAllCurrency();
        $all_card_type = getAllCardType();
        $all_provinces = json_decode($user->all_provinces);
        $all_districts = json_decode($user->all_districts);
        $all_countries = json_decode($user->all_countries);
		return response()->json(['all_card_schemes'=>$all_card_schemes, 'all_account_type' => $all_account_type,
			'all_currency' => $all_currency, 'all_card_type' => $all_card_type, 'all_provinces' => $all_provinces,
			'all_countries' => $all_countries, 'all_districts'=>$all_districts]);
	}


	public function getCustomerCardList()
	{
		$data = array();
        $data['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('listCustomerCards', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data);


        if($result->status == 110)
        {
            $list = json_decode($result->customercardlist);
            $customer = isset($result->customer) && $result->customer!=null ? json_decode($result->customer) : null;
            $user = \Auth::user();
            $all_card_schemes = json_decode($user->all_card_schemes);
            $all_card_type = getAllCardType();
            //return view('core.authenticated.ecards.ecard_listing', compact('customer', 'customercardlist', 'all_card_schemes', 'all_card_type'));

			$allDt = [];
			for($i1=0; $i1<sizeof($list); $i1++)
			{
				//dd($list[$i1]);
				$card = $list[$i1];
				$x =$list[$i1]->id;
				$dt = [];
				$pan  = $list[$i1]->pan;
				$dt['full_name']= $list[$i1]->full_name;
				$dt['accountIdentifier'] = $list[$i1]->accountIdentifier;
				$dt['serialNo'] = $list[$i1]->serialNo;
				$dt['pan'] = $list[$i1]->pan;
				$dt['schemeName'] = $list[$i1]->schemeName;
				$dt['cardType'] = $list[$i1]->cardType;
				$dt['status'] = $list[$i1]->status;

				$str = "";
				$str = $str.'<div class="btn-group">';
					$str = $str.'<button class="btn btn-sm btn-primary" type="button">Action</button>';
					$str = $str.'<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">';
						$str = $str.'<span class="caret"></span>';
						$str = $str.'<span class="sr-only">Toggle Dropdown</span>';
					$str = $str.'</button>';
					$str = $str.'<ul role="menu" class="dropdown-menu">';

						if(\Auth::user()->role_code == \App\Models\Roles::$POTZR_STAFF)
						{
							if($ecard->status=="ACTIVE")
							{
								$str = $str.'<li><a href="/potzr-staff/ecards/card-status/block/'.$x.'">Block Card</a></li>';
								$str = $str.'<li><a href="/potzr-staff/ecards/card-status/delete/'.$x.'">Delete Card</a></li>';
							}
							else if($ecard->status=="BLOCKED")
							{
								$str = $str.'<li><a href="/potzr-staff/ecards/card-status/reactivate/'.$x.'">Reactivate Card</a></li>';
							}
						}
						if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
						{
							if(isset($ecard->isMobilemoneyaccount) && $ecard->isMobilemoneyaccount)
							{
								$str = $str.'<li><a href="/bank-teller/cards/mmoney/deactivate-mmoney/'.$x.'">Deactivate Mobile Money</a></li>';
							}
							else
							{
								$str = $str.'<li><a style="cursor: pointer" onclick="javascript:shownewcard(0, \''.$pan.'\');loadAId(\''.$x.'\')">Activate Mobile Money</a></li>';
							}
						}

					$str = $str.'</ul>';
				$str = $str.'</div>';
				$dt['action'] = $str;
				array_push($allDt, $dt);
			}
			return response()->json(['status'=>$result->status, 'data'=>$allDt, 'customer'=>$customer, 'all_card_schemes'=>$all_card_schemes, 'all_card_type'=>$all_card_type]);
        }
		else if($result->status == -1)
		{
			return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
		}
		else
        {
            return response()->json(['status' => 0, 'data' => []]);
        }
	}



	public function pullAccountBalance($accountId)
	{
		$user = \Auth::user();
        $all_card_schemes = json_decode($user->all_card_schemes);
        $all_account_type = getAllAccountType();
        $all_currency = getAllCurrency();
        $all_card_type = getAllCardType();
        $all_provinces = json_decode($user->all_provinces);
        $all_districts = json_decode($user->all_districts);
        $all_countries = json_decode($user->all_countries);

        $data = array();
        $data['accountId'] = $accountId;
        $data['merchantCode'] = PROBASEWALLET_MERCHANT_CODE;
        $data['deviceCode'] = PROBASEWALLET_DEVICE_CODE;
        $data['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('getAccountBalance', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/AccountServices?wsdl', $data);
		//dd($result);

        if($result->status == 100)
        {
            $customer = ($result->customer);
			$account = ($result->account);
			$availableBalance = ($result->availableBalance);
			$currentBalance = ($result->currentBalance);
			$accountCurrency = $result->accountCurrency;
			$floatingBalance = $result->floatingBalance;
            return response()->json(['status'=>$result->status, 'customer' => $customer, 'account'=>$account, 'floatingBalance'=>$floatingBalance,
				'availableBalance'=>number_format($availableBalance, 2, '.', ', '), 'currentBalance'=>number_format($currentBalance, 2, '.', ', '), 'accountCurrency'=>$accountCurrency]);
        }
		else if($result->status == -1)
		{
			return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
		}
		else
        {
            return response()->json(['status' => 0, 'data' => []]);
        }
	}







	public function pullAccountsList()
	{
		$data = array();
        $data['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('listCustomerAccounts', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data);



        if($result->status == 110)
        {
            $customeracctlist = json_decode($result->customeracctlist);
            $accessingUserRole = getRoleInterpretRoute(\Auth::user()->role_code);
            $user = \Auth::user();
            $all_card_schemes = json_decode($user->all_card_schemes);
            $all_card_type = getAllCardType();

			$list = ($result->customeracctlist);
			//dd($list);
			$allDt = [];
			for($i1=0; $i1<sizeof($list); $i1++)
			{
				//dd($list[$i1]);
				$y =$list[$i1]->id;
				$dt = [];
				$dt['accountIdentifier']= $list[$i1]->accountIdentifier;
				$dt['accountType'] = $list[$i1]->accountType;
				$dt['bankName'] = $list[$i1]->bankName;
				$dt['ewalletaccount'] = $list[$i1]->ewalletaccount;
				$dt['status'] = $list[$i1]->status;

				$str = "";
				$str = $str.'<div class="btn-group">';
					$str = $str.'<button class="btn btn-sm btn-primary" type="button">Action</button>';
					$str = $str.'<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">';
						$str = $str.'<span class="caret"></span>';
						$str = $str.'<span class="sr-only">Toggle Dropdown</span>';
					$str = $str.'</button>';
					$str = $str.'<ul role="menu" class="dropdown-menu">';

						$str = $str.'<li><a style="cursor: pointer" onclick="javascript:addNewCard('.$list[$i1]->id.', \''.$list[$i1]->accountIdentifier.'\', \''.$list[$i1]->customerFullName.'\', \''.$list[$i1]->customerverficationnumber.'\');">Add Card To Account</a></li>';
						$str = $str.'<li><a style="cursor: pointer" onclick="javascript:viewAccountCards('.$list[$i1]->id.', \''.$list[$i1]->accountIdentifier.'\', \''.$list[$i1]->customerFullName.'\', \''.$list[$i1]->customerverficationnumber.'\');">Account Cards</a></li>';
						if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
						{
							$str = $str.'<li><a href="/bank-teller/accounts/status/suspend-account/{{$id}}">Suspend Account</a></li>';
						}
						if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
						{
							$str = $str.'<li><a style="cursor: pointer" onclick="javascript:shownewcard(0, '.$dt['accountIdentifier'].' - '.$dt['bankName'].', '.$y.');loadAId('.$y.', \'fundAccount\')">Fund Account</a></li>';
							$str = $str.'<li><a style="cursor: hand" onclick="javascript:shownewcard(1, \''.$dt['accountIdentifier'].' - '.$dt['bankName'].'\', '.$y.');loadAId('.$y.', \'addCreditCard\')">Add New Credit/Debit Card</a></li>';
						}
						$str = $str.'<li><a  style="cursor: pointer" onclick="javascript:shownewcard(2, \''.$dt['accountIdentifier'].' - '.$dt['bankName'].'\', '.$y.');loadAId('.$y.', \'last5txns\')">Last 5 Transactions</a></li>';
						if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
						{
							if(isset($value->ewalletaccount) && $value->ewalletaccount==true)
							{
								$str = $str.'<li><a href="/bank-teller/accounts/activate-wallet/0/'.$y.'">Deactivate EWallet</a></li>';
							}
							else
							{
								$str = $str.'<li><a href="/bank-teller/accounts/activate-wallet/1/'.$y.'">Activate EWallet</a></li>';
							}
						}

						if(isset($value->customer->customerType) && $value->customer->customerType!=NULL && $value->customer->customerType=="CORPORATE")
						{
							$str = $str.'<li><a href="/bank-teller/accounts/list-corporate-sub-accounts/'.$y.'">View Corporate Customers </a></li>';
							$str = $str.'<li><a href="/bank-teller/accounts/download-batch-accounts-template/'.$y.'">Batch Sub-Account Template</a></li>';
							$str = $str.'<li><a href="/bank-teller/accounts/upload-batch-accounts-template/'.$y.'">Upload Sub-Account Template</a></li>';


						}

					$str = $str.'</ul>';
				$str = $str.'</div>';
				$dt['action'] = $str;
				array_push($allDt, $dt);
			}

			return response()->json(['status'=>110, 'data' => $allDt]);
            //return view('core.authenticated.account.account_listing', compact('accessingUserRole', 'customer', 'customeracctlist', 'all_card_schemes', 'all_card_type'));

        }
		else if($result->status == -1)
		{
			return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
		}
		else
        {
            //return \Redirect::back()->with('error', 'Failed to access customer accounts listing');
			return response()->json(['status' => 0, "message"=> 'Failed to access customer accounts listing']);
        }
	}









	public function pullAccountList()
	{
		$data = array();
        $data['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('listCustomerAccounts', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data);
		//dd(result);

        if($result->status == 110)
        {

            $accessingUserRole = getRoleInterpretRoute(\Auth::user()->role_code);
            $user = \Auth::user();
            $all_card_schemes = json_decode($user->all_card_schemes);
            $all_card_type = getAllCardType();


			$list = ($result->customeracctlist);
			//dd($list);
			$allDt = [];
			for($i1=0; $i1<sizeof($list); $i1++)
			{
				//dd($list[$i1]);
				$y =$list[$i1]->id;
				$dt = [];
				$dt['customerFullName']= $list[$i1]->customerFullName;
				$dt['customerverficationnumber']= $list[$i1]->customerverficationnumber;
				$dt['accountIdentifier']= $list[$i1]->accountIdentifier;
				$dt['accountType'] = $list[$i1]->accountType;
				$dt['bankName'] = $list[$i1]->bankName;
				$dt['ewalletaccount'] = $list[$i1]->ewalletaccount===true ? 'Yes' : 'No';
				$dt['status'] = $list[$i1]->status;

				$str = "";
				$str = $str.'<div class="btn-group">';
					$str = $str.'<button class="btn btn-sm btn-primary" type="button">Action</button>';
					$str = $str.'<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">';
						$str = $str.'<span class="caret"></span>';
						$str = $str.'<span class="sr-only">Toggle Dropdown</span>';
					$str = $str.'</button>';
					$str = $str.'<ul role="menu" class="dropdown-menu">';

						$str = $str.'<li><a style="cursor: pointer" onclick="javascript:addNewCard('.$list[$i1]->id.', \''.$list[$i1]->accountIdentifier.'\', \''.$list[$i1]->customerFullName.'\', \''.$list[$i1]->customerverficationnumber.'\');">Add Card To Account</a></li>';
						$str = $str.'<li><a style="cursor: pointer" onclick="javascript:viewAccountCards('.$list[$i1]->id.', \''.$list[$i1]->accountIdentifier.'\', \''.$list[$i1]->customerFullName.'\', \''.$list[$i1]->customerverficationnumber.'\');">Account Cards</a></li>';
						$str = $str.'<li><a style="cursor: pointer" onclick="javascript:viewAccountBalance('.$list[$i1]->id.', \''.$list[$i1]->accountIdentifier.'\', \''.$list[$i1]->customerFullName.'\', \''.$list[$i1]->customerverficationnumber.'\');">Account Balance</a></li>';
						if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
						{
							$str = $str.'<li><a href="/bank-teller/accounts/status/suspend-account/{{$id}}">Suspend Account</a></li>';
						}
						if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
						{
							//$str = $str.'<li><a style="cursor: pointer" onclick="javascript:shownewcard(0, '.$dt['accountIdentifier'].' - '.$dt['bankName'].', '.$y.');loadAId('.$y.', \'fundAccount\')">Fund Account</a></li>';
							//$str = $str.'<li><a style="cursor: hand" onclick="javascript:shownewcard(1, \''.$dt['accountIdentifier'].' - '.$dt['bankName'].'\', '.$y.');loadAId('.$y.', \'addCreditCard\')">Add New Credit/Debit Card</a></li>';
						}
						$str = $str.'<li><a style="cursor: pointer" onclick="javascript:shownewcard(2, \''.$dt['accountIdentifier'].' - '.$dt['bankName'].'\', '.$y.');loadAId('.$y.', \'last5txns\')">Last 5 Transactions</a></li>';
						if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
						{
							if(isset($value->ewalletaccount) && $value->ewalletaccount==true)
							{
								$str = $str.'<li><a href="/bank-teller/accounts/activate-wallet/0/'.$y.'">Deactivate EWallet</a></li>';
							}
							else
							{
								$str = $str.'<li><a href="/bank-teller/accounts/activate-wallet/1/'.$y.'">Activate EWallet</a></li>';
							}
						}

						if(isset($value->customer->customerType) && $value->customer->customerType!=NULL && $value->customer->customerType=="CORPORATE")
						{
							$str = $str.'<li><a href="/bank-teller/accounts/list-corporate-sub-accounts/'.$y.'">View Corporate Customers </a></li>';
							$str = $str.'<li><a href="/bank-teller/accounts/download-batch-accounts-template/'.$y.'">Batch Sub-Account Template</a></li>';
							$str = $str.'<li><a href="/bank-teller/accounts/upload-batch-accounts-template/'.$y.'">Upload Sub-Account Template</a></li>';


						}

					$str = $str.'</ul>';
				$str = $str.'</div>';
				$dt['action'] = $str;
				array_push($allDt, $dt);
			}

			return response()->json(['status'=>110, 'data' => $allDt]);
            //return view('core.authenticated.account.account_listing', compact('accessingUserRole', 'customer', 'customeracctlist', 'all_card_schemes', 'all_card_type'));

        }
		else if($result->status == -1)
		{
			return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
		}
		else
        {
            //return \Redirect::back()->with('error', 'Failed to access customer accounts listing');
			return response()->json(['status' => 0, "message"=> 'Failed to access customer accounts listing']);
        }
	}




	public function pullMobileMoneyList()
	{
		$data = array();
        $data['token'] = \Auth::user()->token;
        $result = handleSOAPCalls('listMobileMoneyAccounts', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MobileMoneyServices?wsdl', $data);
		//dd($result);
        if ($result->status == 410) {
            $mobileaccountlist = json_decode($result->mobileaccountlist);
            $customer = isset($result->customer) ? ($result->customer) : null;
            $accessingUserRole = getRoleInterpretRoute(\Auth::user()->role_code);
            $user = \Auth::user();
            $all_card_schemes = json_decode($user->all_card_schemes);
            $all_card_type = getAllCardType();


			$list = json_decode($result->mobileaccountlist);
			//dd($list);
			$allDt = [];
			for($i1=0; $i1<sizeof($list); $i1++)
			{
				//dd($list[$i1]);
				$x=-1;
				try{
					$x =$list[$i1][0];
					$id = \Crypt::encrypt($x);
					$dt = [];
					//$panLength = strlen($list[$i1]->pan) - 10;
					$replacer = "";
					for($y=0; $y<8; $y++)
					{
						$replacer = $replacer."*";
					}

					//dd($list[$i1]);
					$pan = $list[$i1][6].$replacer.$list[$i1][7];
					$dt['mobileNumber'] = $list[$i1][1];
					$dt['accountIdentifier'] = $list[$i1][2];
					$dt['full_name'] = $list[$i1][3]." ".$list[$i1][4].($list[$i1][5]==null ? "" : (" ".$list[$i1][5]));
					$dt['pan']= $pan;
					$dt['status'] = $list[$i1][8];

					$str = "";
					$str = $str.'<div class="btn-group">';
						$str = $str.'<button class="btn btn-sm btn-primary" type="button">Action</button>';
						$str = $str.'<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">';
							$str = $str.'<span class="caret"></span>';
							$str = $str.'<span class="sr-only">Toggle Dropdown</span>';
						$str = $str.'</button>';
						$str = $str.'<ul role="menu" class="dropdown-menu">';
							if(\Auth::user()->role_code == \App\Models\Roles::$POTZR_STAFF)
							{
								if($dt['status']=='ACTIVATED')
									$str = $str.'<li><a href="/potzr-staff/accounts/suspend-account/'.$id.'">Suspend Mobile Account</a></li>';
							}
							$str = $str.'<li><a  style="cursor: hand" onclick="javascript:shownewcard(2, \'accountname\', \''.$id.'\')">Last 5 Transactions</a></li>';
						$str = $str.'</ul>';
					$str = $str.'</div>';
					$dt['action'] = $str;
					array_push($allDt, $dt);
				}
				catch(\Exception $e)
				{
					dd($list[$i1]);
				}
			}
			//dd($allDt);
			return response()->json(['status'=>210, 'data' => $allDt]);
        }
		else if($result->status == -1)
		{
			return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
		}
		else
        {
            //return \Redirect::back()->with('error', 'Failed to access customer accounts listing');
			return response()->json(['status' => 0, "message"=> 'Failed to access customer accounts listing']);
        }
	}










	public function pullTransactionsNoToken()
	{
//date('Y-m-d')
		$result = handleSOAPCalls('listTransactionsHeavyReturn', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/TransactionServices?wsdl',
				['token' => \Auth::user()->token, 'startTransactionDate' => '2017-02-16', 'endTransactionDate' => date('Y-m-d'), 'index' => 0]);

		$transactionList = json_decode($result->transactionList);
		return view('core.authenticated.transactions.transaction_listing_otp', compact('transactionList'));
	}

	public function pullDistrictsByProvince($provinceId)
	{
		//$result = handleSOAPCalls('listDistrictsByProvince', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/UtilityServices?wsdl',
		//		['districtId' => $provinceId]);
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/listDistrictsByProvince?districtId='.$provinceId;
		$result = sendGetRequest($url, []);
		$result = json_decode($result);

		$districts = $result->districtList;


		$districtArray = [];
		for($i=0; $i<sizeof($districts); $i++)
		{
			$districtArray[$districts[$i]->id] = $districts[$i]->name;
		}
		return response()->json(['status' => 1, 'data' => $districtArray]);
	}



	public function pullDistrictsByCountry($countryId)
    {
        //$result = handleSOAPCalls('listDistrictsByProvince', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/UtilityServices?wsdl',
        //		['districtId' => $provinceId]);
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/listDistrictsByCountry?countryId='.$countryId;
        $result = sendGetRequest($url, []);
        $result = json_decode($result);

        $districts = $result->districtList;


        $districtArray = [];
        for($i=0; $i<sizeof($districts); $i++)
        {
            $districtArray[$districts[$i]->id] = $districts[$i]->name;
        }
        return response()->json(['status' => 1, 'data' => $districtArray]);
    }


	public function pullVendorServicesByMerchant($merchantId)
	{
		$result = handleSOAPCalls('listVendorServices', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/UtilityServices?wsdl',
				['merchantId' => intval($merchantId)]);
		//dd($result);

		if($result->status == 100) {
			$vendorServiceList = json_decode($result->vendorServiceList);
			$vendorServiceArray = [];

			for ($i = 0; $i < sizeof($vendorServiceList); $i++) {
				$vendorServiceArray[$vendorServiceList[$i]->id."|||".$vendorServiceList[$i]->merchant->merchantName] = $vendorServiceList[$i]->serviceName." - ZMW".number_format($vendorServiceList[$i]->amountPayable,2, '.', ',');
			}
			return response()->json(['status' => 1, 'data' => $vendorServiceArray]);
		}else
		{
			return response()->json(['status' => 2, 'data' => []]);
		}
	}

	public function pullProvincesByCountry($countryId)
	{
		/*$result = handleSOAPCalls('listProvinceByCountry', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/UtilityServices?wsdl',
		['countryId' => $countryId]);
		$provinces = $result->provinceList;*/

		$provinceArray = [];
		for($i=0; $i<sizeof($this->all_provinces); $i++)
		{
			if($this->all_provinces[$i]->countryId==$countryId)
				$provinceArray[$this->all_provinces[$i]->id] = $this->all_provinces[$i]->provinceName;
		}
		return response()->json(['status' => 1, 'data' => $provinceArray]);
	}

	public function testSoap()
	{
		//dd(33);
		SoapWrapper::add(function ($service) {
			$service
					->name('createNewMerchant')
					->wsdl('http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl')
					->trace(true);
		});


		$data = [
				'merchantCode' => 'USD',
				'addressLine1'   => 'EUR',
				'altContactEmail'     => '2014-06-05',
				'altContactMobile'       => '1000',
				'bankAccount'   => 'EUR',
				'certificateOfIncorporation'     => '2014-06-05',
				'companyData'       => '1000',
				'companyLogo'   => 'EUR',
				'companyName'     => '2014-06-05',
				'companyRegNo'       => '1000',
				'contactEmail'   => 'EUR',
				'contactMobile'     => '2014-06-05',
				'merchantBankId'       => 1,
				'merchantName'     => 'Test Merchant',
				'merchantSchemeId'       => 1
		];


		SoapWrapper::service('createNewMerchant', function ($service) use ($data) {
			//dd($service->getFunctions());
			dd($service->call('createNewMerchant', [$data]));
		});
	}


	public function tempRouteWalletToLoginPage()
	{
		return \Redirect::to('/wallet/dashboard');
	}

	public function testemail(){
		/*\Mail::send('email.test',
		['testVar' => 'Just a silly test'],
			function($message) {
				$message->to('smicer66@gmail.com')
				   ->subject('A simple test');
			}
		);*/
		$activationLink = "as";
		$beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
		$beautymail->send('email.test', [$activationLink], function($message)
		{

			$message
				->from('bar@example.com')
				->to('smicer66@gmail.com', 'Kachi Akujua')
				->subject('Welcome!');
		});/**/
		//dd($this->school->mobileCode."8094073705");
		//send_sms($this->school->mobile_code."8094073705", "Test", $this->school);
		//dd(strtoupper('4d36e96c-e325-11ce-bfc1-08002be10318 4d36e96c-e325-11ce-bfc1-08002be10318'));

	}

	public function shoot()
	{
		/*$mgClient = new Mailgun('key-d2ae63cf4e7f4e08b04b4ac4e37e10df');
		$domain = "sandboxbe73658e689b4f67b238a6176a8cab5d.mailgun.org";

		# Make the call to the client.
		$result = $mgClient->sendMessage($domain, array(
			'from'    => 'Excited User <postmaster@sandboxbe73658e689b4f67b238a6176a8cab5d.mailgun.org>',
			'to'      => 'Baz <postmaster@sandboxbe73658e689b4f67b238a6176a8cab5d.mailgun.org>',
			'subject' => 'Hello',
			'text'    => 'Testing some Mailgun awesomness!'
		));*/

	}

	public function getSchoolBillingHistory($schoolId)
	{
		$schoolId = \Crypt::decrypt($schoolId);
		$billings = \DB::table('payment_histories')
			->join('payment_categories', 'payment_histories.payment_category_id', '=', 'payment_categories.id')
			->where('payment_categories.name', '=', 'Subscription')
			->join('subscriptions', 'payment_histories.payment_category_instance_id', '=', 'subscriptions.id')
			->where('subscriptions.school_id', '=', $schoolId)
			->join('schools', 'subscriptions.school_id', '=', 'schools.id')
			->join('packages', 'subscriptions.package_id', '=', 'packages.id')
			->select('payment_histories.*', 'subscriptions.*', 'schools.*', 'packages.name as pckName', 'packages.maximum_users as maximum_users', 'payment_histories.updated_at as datePaid', 'payment_histories.status as payStatus', 'subscriptions.status as subStatus', 'subscriptions.id as subId', 'payment_histories.id as paymentId', 'schools.status as schoolstatus', 'schools.id as schoolId')
			->get();
		//dd($billings);
        return view('backend.admin.saas_admin_billing_history', compact('billings'));
	}


	public function indexRefresher($domain)
	{
		\Session::remove('domain_name');
		\Session::remove('school');
		\Session::remove('settings');
		\Session::remove('academic_year_term');
		\Session::remove('grading_scheme_grade');
		return \Redirect::to('/');
	}


	public function viewFullDetails($schoolId)
	{
		$schoolId = \Crypt::decrypt($schoolId);
		$data = \DB::table('schools')
			->where('schools.id', '=', $schoolId)
			->join('subscriptions', 'schools.id', '=', 'subscriptions.school_id')
			->join('payment_histories', 'subscriptions.id', '=', 'payment_histories.payment_category_instance_id')
			->join('payment_categories', 'payment_histories.payment_category_id', '=', 'payment_categories.id')
			->where('payment_categories.name', '=', 'Subscription')
			->join('packages', 'subscriptions.package_id', '=', 'packages.id')
			->select('payment_histories.*', 'subscriptions.*', 'schools.*', 'packages.name as pckName', 'payment_histories.updated_at as datePaid', 'payment_histories.status as payStatus', 'subscriptions.status as subStatus', 'schools.status as schoolstatus', 'schools.status as schoolStatus')
			->orderBy('subscriptions.updated_at', 'DESC')
			->limit(1)->first();
		//dd($school);
		//payment_histories
		$subscriptions = \DB::table('subscriptions')
			->join('schools', 'subscriptions.school_id', '=', 'schools.id')
			->where('schools.id', '=', $schoolId)
			->join('payment_histories', 'subscriptions.id', '=', 'payment_histories.payment_category_instance_id')
			->join('payment_categories', 'payment_histories.payment_category_id', '=', 'payment_categories.id')
			->where('payment_categories.name', '=', 'Subscription')
			->join('packages', 'subscriptions.package_id', '=', 'packages.id')
			->select('payment_histories.created_at as payDate', 'packages.name as pckName', 'subscriptions.id as subId', 'subscriptions.start_date', 'subscriptions.expiring_date', 'payment_histories.status as payStatus', 'payment_histories.id as paymentId', 'payment_histories.id as paymentId', 'payment_histories.*')
			->get();


		return view('backend.admin.complete_school_details', compact('data', 'subscriptions', 'schoolId'));
	}


	public function getHelpFaq($domain)
	{
		$school = $this->school;
		return view('saas.faq.helpdesk.index', compact($school));
	}


	public function activateSchoolAccount($schId)
	{
		$schId = \Crypt::decrypt($schId);
		$school1 = Schools::where('id', '=', $schId)->first();
		$school1->status = 'Active';
		$school1->save();
		return redirect('/admin/dashboard')->with('message', 'Selected School Has Been Activated Successfully');
	}


	public function confirmPayment($paymentId, $subId, $schoolId)
	{
		$paymentId = \Crypt::decrypt($paymentId);
		$payHist = \App\Models\PaymentHistories::where('id', '=', $paymentId)->where('status', '!=', 'Success')->first();
		$payHist->status = 'Success';
		$payHist->save();

		$sub = \App\Models\Subscriptions::where('school_id', '=', \Crypt::decrypt($schoolId))
		->where('subscriptions.expiring_date', '>',  \DB::raw('NOW()'))
		->orderBy('expiring_date', 'DESC');
		$dateStart = date('Y-m-d');
		$time = time();
		if($sub->count()>0)
		{
			$time = strtotime($sub->first()->expiring_date);
			$dateStart = date('Y-m-d', $time);

		}
		//dd($sub->first()->package);
		$sub = \App\Models\Subscriptions::where('id', '=', $subId)->first();
		$sub->start_date = $dateStart;
		$newEndingDate = date('Y-m-d',strtotime(date("Y-m-d", $time) . " + 1 year"));
		$sub->expiring_date = $newEndingDate;
		$sub->save();

		$school = \App\Models\Schools::where('id', '=', \Crypt::decrypt($schoolId))->first();
		$school->max_users = $sub->first()->package->maximum_users;
		$school->current_sub_expire = $newEndingDate;
		$school->save();
		return redirect('/admin/view-full-details/'.($schoolId))->with('message', 'Payment Subscription Has Been Verified! Scroll Down to Activate the selected school');
	}

	public function getSchoolTurnOff($schoolId)
	{
		$schoolId = \Crypt::decrypt($schoolId);
		$school1 = Schools::where('school_admin_user_id', '=', \Auth::user()->id)
			->where('id', '=', $schoolId)->first();
		$school1->status = 'Turned Off';
		$school1->save();
		return redirect('/admin/dashboard')->with('message', 'Your School Has Been Turned Off. Your School will not be accessible anymore');
	}

	public function getSaasDashboard()
	{
		//dd(323);
		 $school1 = NULL;
		 $role = \Auth::user()->role_code;

         if ($role != Roles::$ROLE_SAAS_ADMIN) {
			 $school1=Schools::where('school_admin_user_id', $this->user->id)->with(array('school_subscription' => function($t){
				$t->orderBy('created_at', 'DESC')->with('package');
			 }))->get();
		 }
		 else
		 {
		 	$school1=Schools::with(array('school_subscription' => function($t){
				$t->orderBy('created_at', 'DESC')->with('package');
			 }))->get();

		 }


        //if($school == null)
          //  return redirect('/admin/setup')->with('message', 'Please setup your account ');
        return view('backend.admin.saasadmindashboard', compact('package', 'school1', 'role'));
	}


	public function savePreferredUrl($id, $url)
	{
		$id =\Crypt::decrypt($id);
		$school = Schools::where('id', '=', $id)->first();
		$school->preferredUrl = $url;
		if($school->save())
			return response()->json(['status' => 1, 'newurl' => $url, 'id' => $id]);
		else
			return response()->json(['status' => 0]);
	}

	public function savePreferredUrlForLocal($id, $url)
	{
		$id =\Crypt::decrypt($id);
		$school = Schools::where('id', '=', $id)->first();
		$school->local_ip = $url;
		if($school->save())
			return response()->json(['status' => 1, 'newurl' => $url, 'id' => $id]);
		else
			return response()->json(['status' => 0]);
	}


	public function submitContact()
	{
		$input = \Input::all();
		//dd($input);
		$fname = $input['fname'];
		$email = $input['email'];
		$subj = $input['subj'];
		$mssg = $input['mssg'];
		send_mail('email.contact_us', "contactus@shikola.com", "contactus@shikola.com", 'Contact Request - Message from Shikola Enquirer', compact('fname', 'email', 'subj', 'mssg'));
		send_mail('email.contact_us_reply', "no-reply@shikola.com", $email, 'Contact Request - Thanks from Shikola', compact('fname', 'email', 'subj', 'mssg'));
		return \Redirect::to('/#contact')->with('message', 'Your Message Has Been Sent Successfully');
	}


    public function index()
    {

		$type = 'Online';
		$amount = "304000";
		$activationCode = "jasjdadasjdasdasdsa";
		//send_mail('email.school_signup', "smicer66@gmail.com", "smicer66@gmail.com", 'New School Signup - Welcome', compact('type', 'amount', 'activationCode'));
		//dd(3333);
		/*\Mail::send($view, $data, function($message) use($to, $subject)
		{
			dd(22);
			$message->to($to);
			$message->subject($subject);
		});*/
        $packages = Packages::with(['packageFeatures']);
        return view('guests.home', compact('packages'));
    }

    public function saasIndex($domain = null) {
        //return view('saas.guests.index');

		if($this->school!=NULL) {
			$lp = \App\Models\LandingPage::where('school_id', '=', $this->school->id);
			if($lp->count()==0) {
				return view('layouts.school_site');
			}
			else {
				$menu = \App\Models\Menu::where('school_id', '=', $this->school->id)->with([
						'menuItems' => function($x){
							$x = $x->whereNull('parent_item_id')->with([
								'parentMenuItem'
							]);
						}
					])->get();
//				dd($menu);
				return view('utility.' . $this->school->id . '.landingpage');
			}
		}
		else {
			return view('errors.404');
		}
    }

    public function saasAdminIndex($domain = null)
    {

        if(env('')==0)
        {
            if(Schools::count()==0)
            {
                //display Site Under construction and link to where admin provides cnfirmation code for sync
            }else
            {

            }
        }
        return view('saas.index');
    }


    public function pricing()
    {
        $packages = Packages::with(['packageFeatures']);
        return view('guests.pricing', compact('packages'));
    }

    /*
     * Admin Dashboard
     */
    public function getDashboard()
    {
		$role = \Auth::user()->role_code;

		if ($role == Roles::$ROLE_HELP_DESK) {
			$package = Packages::find($this->user->subscription_id);
			$school1 = Schools::where('school_admin_user_id', $this->user->id)->first();
			//if($school == null)
			//  return redirect('/admin/setup')->with('message', 'Please setup your account ');
			$classArms = \App\Models\ClassArms::where('school_id', '=', $this->school->id)->count();
			$fees = \App\Models\PaymentHistories::where('school_id', '=', $this->school->id)
					->where('payment_category_id', '=', SUBSCRIPTION_PAYMENT_CATEGORY)
					->where('status', '=', 'Success')->count();
			$allusers = \App\Models\User::where('school_id', '=', $this->school->id)->count();
			$allstudents = \App\Models\Students::where('school_id', '=', $this->school->id)->count();
			$allstaff = \App\Models\SchoolStaff::where('school_id', '=', $this->school->id)->count();
			$attendance1 = \App\Models\AttendanceHistories::where('isStudent', '=', '1')
					->where('school_id', '=', $this->school->id)
					->where('attendance_date', '>', date('Y') . '-01-01')
					->where('attendance_date', '<', date('Y') . '-12-31')
					->groupBy(\DB::raw('MONTH(attendance_date)'))
					->selectRaw('sum(no_present) as sum, (attendance_date) as month')
					->lists('sum', 'month');
			$attendance = array();
			foreach ($attendance as $key => $value) {
				$attendance[$key] = $value;
			}

			$attendance_s1 = \App\Models\AttendanceHistories::where('isStudent', '=', '0')
					->where('school_id', '=', $this->school->id)
					->where('attendance_date', '>', date('Y') . '-01-01')
					->where('attendance_date', '<', date('Y') . '-12-31')
					->groupBy(\DB::raw('MONTH(attendance_date)'))
					->selectRaw('sum(no_present) as sum, MONTHNAME(attendance_date) as month')
					->lists('sum', 'month');


			$attendance_s = array();
			foreach ($attendance_s1 as $key => $value) {

				$attendance_s[$key] = $value;
			}

			$payHist = \App\Models\PaymentHistories::where('school_id', '=', $this->school->id)
					->where('payment_category_id', '=', FEE_PAYMENT_CATEGORY);
			$feeSum = 0;
			if ($payHist->count() > 0) {
				$payHist = $payHist->selectRaw('sum(amount) as feeSum')->lists('feeSum');
				$feeSum = $payHist[0];
			} else {
				$feeSum = 0;
			}

			$payHistAdm = \App\Models\PaymentHistories::where('school_id', '=', $this->school->id)
					->where('payment_category_id', '=', APPLICANT_PAYMENT_CATEGORY);
			//dd($payHistAdm->get());
			$admSum = 0;
			if ($payHistAdm->count() > 0) {
				$payHistAdm = $payHistAdm->selectRaw('sum(amount) as admSum')->lists('admSum');
				$admSum = $payHist[0];
			} else {
				$admSum = 0;
			}

			$feeCredit = NULL;

			$feeCredits = \App\Models\FeeTrackers::with(['payment_history' => function ($t) {
				$t = $t->where('school_id', '=', $this->school->id);
			}])->where('is_remaining_balance', '=', 'No');
			$feeCredit = 0;
			if ($feeCredits->count() > 0) {
				$feeCredits = $feeCredits->selectRaw('sum(balance) as feeCredit')->lists('feeCredit');
				$feeCredit = $feeCredits[0];
			} else {
				$feeCredit = 0;
			}


			$userSQL = \App\Models\User::where('school_id', '=', $this->school->id)
					->where('status', '=', 'Active')->orderBy('created_at', 'DESC')->limit(8)
					->with(['user_profile', 'school_staff' => function ($t) {
						$t = $t->with('passport');
					}, 'student' => function ($t) {
						$t = $t->with('passport');
					}]);
			return view('backend.admin.dashboard', compact('userSQL', 'feeCredit', 'feeSum', 'package', 'school1', 'classArms', 'fees', 'admSum', 'allusers', 'allstudents', 'allstaff', 'attendance', 'attendance_s'));
		}
		else if ($role == Roles::$ROLE_SCHOOL_ACCOUNTANT)
		{
			/**Start Here**/
			$feeCredit = NULL;

			$feeCredits = \App\Models\FeeTrackers::with(['payment_history' => function ($t) {
				$t = $t->where('school_id', '=', $this->school->id);
			}])->where('is_remaining_balance', '=', 'No');
			$feeCredit = 0;
			if ($feeCredits->count() > 0) {
				$feeCredits = $feeCredits->selectRaw('sum(balance) as feeCredit')->lists('feeCredit');
				$feeCredit = $feeCredits[0];
			} else {
				$feeCredit = 0;
			}

			$salaryAdvice = \App\Models\SalaryAdvice::where('school_id', '=', $this->school->id)
					->where('status', '=', 'Posted by HR')->count();
			$allStudents = \App\Models\Students::where('school_id', '=', $this->school->id)
				->whereNotIn('status', ['Graduated', 'Inactive', 'Left'])->count();

			$payHistFee = \App\Models\PaymentHistories::where('school_id', '=', $this->school->id)
					->whereIn('payment_category_id', [FEE_PAYMENT_CATEGORY])
					->where('status', '=', 'Success');
			$payHistAdm = \App\Models\PaymentHistories::where('school_id', '=', $this->school->id)
					->whereIn('payment_category_id', [APPLICANT_PAYMENT_CATEGORY])
					->where('status', '=', 'Success');
			$salariesList = \App\Models\StaffSalary::where('school_id', '=', $this->school->id)
					->where('status', '=', 'Paid');
			$invoiceList = \DB::table('supplier_invoices')
					->join('invoice_items', 'invoice_items.invoice_id', '=', 'supplier_invoices.id')
					->where('supplier_invoices.school_id', '=', $this->school->id)
					->where('status', '=', 'Paid');

			$monthlyincome = \App\Models\PaymentHistories::whereIn('status',['Success', 'Pending'])
					->whereIn('payment_category_id', [APPLICANT_PAYMENT_CATEGORY, FEE_PAYMENT_CATEGORY])
					->where('school_id', '=', $this->school->id)
					->where('created_at', '>', date('Y') . '-01-01')
					->where('created_at', '<', date('Y') . '-12-31')
					->selectRaw('sum(amount) as sum, MONTH(created_at) as month')
					->groupBy(\DB::raw('month'))
					->lists('sum', 'month');

			$monthlyschfee = \App\Models\PaymentHistories::whereIn('status',['Success', 'Pending'])
					->whereIn('payment_category_id', [FEE_PAYMENT_CATEGORY])
					->where('school_id', '=', $this->school->id)
					->where('created_at', '>', date('Y') . '-01-01')
					->where('created_at', '<', date('Y') . '-12-31')
					->selectRaw('sum(amount) as sum, MONTH(created_at) as month')
					->groupBy(\DB::raw('month'))
					->lists('sum', 'month');

			$monthlyschapplicant = \App\Models\PaymentHistories::whereIn('status',['Success', 'Pending'])
					->whereIn('payment_category_id', [APPLICANT_PAYMENT_CATEGORY])
					->where('school_id', '=', $this->school->id)
					->where('created_at', '>', date('Y') . '-01-01')
					->where('created_at', '<', date('Y') . '-12-31')
					->selectRaw('sum(amount) as sum, MONTH(created_at) as month')
					->groupBy(\DB::raw('month'))
					->lists('sum', 'month');


			$monthlysalary = \App\Models\StaffSalary::whereIn('status',['Paid'])
					->where('created_at', '>', date('Y') . '-01-01')
					->where('created_at', '<', date('Y') . '-12-31')
					->selectRaw('sum(amount_to_pay+vat+pension-deductions) as sum, MONTH(created_at) as month')
					->groupBy(\DB::raw('month'))
					->lists('sum', 'month');


			$monthlyinvoice = \DB::table('supplier_invoices')
					->join('invoice_items', 'invoice_items.invoice_id', '=', 'supplier_invoices.id')
					->where('supplier_invoices.created_at', '>', date('Y') . '-01-01')
					->where('supplier_invoices.created_at', '<', date('Y') . '-12-31')
					->where('supplier_invoices.school_id', '=', $this->school->id)
					->where('status', '=', 'Paid')
					->selectRaw('sum(invoice_items.unit*invoice_items.quantity - (((invoice_items.unit*invoice_items.quantity) * invoice_items.discount)/100)) as sum, MONTH(supplier_invoices.created_at) as month')
					->groupBy('month')
					->lists('sum', 'month');

			//dd($monthlyinvoice);
			$msala = array();
			foreach($monthlysalary as $key => $val)
			{
				if(!is_null($val))
				{
					$msala[get_months()[$key]] = $val;
				}
			}


			$minv = array();
			foreach($monthlyinvoice as $key => $val)
			{
				if(!is_null($val))
				{
					$minv[get_months()[$key]] = $val;
				}
			}

			$_keys1 = array_keys($minv);
			$_keys2 = array_keys($msala);
			//dd($_keys2);
			$mexp = array();
			for($i=0; $i<12; $i++)
			{
				if(in_array(get_months()[$i], $_keys1) && in_array(get_months()[$i], $_keys2))
				{
					//dd($msala[$i]);
					$mexp[get_months()[$i]] = $minv[get_months()[$i]] + $msala[get_months()[$i]];
				}else{
					if(in_array(get_months()[$i], $_keys1)) {
						$mexp[get_months()[$i]] = $minv[get_months()[$i]];
					}else if(in_array(get_months()[$i], $_keys1)) {
						$mexp[get_months()[$i]] = $msala[get_months()[$i]];
					}
				}
			}


			$miarr = array();
			foreach($monthlyincome as $key => $val)
			{
				if(!is_null($val))
				{
					$miarr[get_months()[$key]] = $val;
				}
			}

			$mfarr = array();
			foreach($monthlyschfee as $key => $val)
			{
				if(!is_null($val))
				{
					$mfarr[get_months()[$key]] = $val;
				}
			}
			//dd($mfarr);

			$maarr = array();
			foreach($monthlyschapplicant as $key => $val)
			{
				if(!is_null($val))
				{
					$maarr[get_months()[$key]] = $val;
				}
			}



			$fees = $payHistFee->count();
			$feeSum = 0;
			if ($payHistFee->count() > 0) {
				$payHistFee = $payHistFee->selectRaw('sum(amount) as feeSum')->lists('feeSum');
				$feeSum = $payHistFee[0];
			} else {
				$feeSum = 0;
			}

			$admSum = 0;
			if ($payHistAdm->count() > 0) {
				$payHistAdm = $payHistAdm->selectRaw('sum(amount) as admSum')->lists('admSum');
				$admSum = $payHistAdm[0];
			} else {
				$admSum = 0;
			}

			//dd($salariesList->get());
			$salaries = 0;
			if ($salariesList->count() > 0) {
				$salariesList = $salariesList->selectRaw('sum(amount_to_pay+vat+pension-deductions) as admSum')->lists('admSum');
				//dd($salariesList);
				$salaries = $salariesList[0] ;
			} else {
				$salaries = 0;
			}


			$invoiceSum = 0;
			if ($invoiceList->count() > 0) {
				$invoiceList = $invoiceList->selectRaw('sum(invoice_items.unit*invoice_items.quantity - (((invoice_items.unit*invoice_items.quantity) * invoice_items.discount)/100)) as admSum')->lists('admSum');
				//dd($invoiceList);
				$invoiceSum = $invoiceList[0] ;
			} else {
				$invoiceSum = 0;
			}

			//dd($salaries);
			//dd($admSum);
			//dd($payHistAdm);

			//dd($mexp);

			$invoices = \App\Models\Invoice::where('school_id', '=', $this->school->id)->count();
			$income = $feeSum + $admSum;
			$expenses = $salaries + $invoiceSum;
			return view('backend.admin.dashboard_accountant', compact('salaryAdvice', 'mexp', 'minv', 'msala', 'mfarr', 'maarr', 'monthlyschfee', 'monthlyschapplicant', 'miarr', 'expenses', 'invoiceSum', 'salaries', 'income', 'invoices', 'allStaff', 'allStudents', 'userSQL', 'feeCredit', 'feeSum', 'package', 'school1', 'classArms', 'fees', 'admSum', 'allusers', 'allstudents', 'allstaff', 'attendance', 'attendance_s'));
		}

		else if ($role == Roles::$ROLE_SCHOOL_HR_ADMIN)
		{
			/**Start Here**/

			$salaryAdvice = \App\Models\SalaryAdvice::where('school_id', '=', $this->school->id)
					->where('status', '=', 'Posted by HR')->count();
			$allStudents = \App\Models\Students::where('school_id', '=', $this->school->id)
					->whereNotIn('status', ['Graduated', 'Inactive', 'Left'])->count();
			$staffList = \App\Models\SchoolStaff::where('school_id', '=', $this->school->id)
					->whereIn('status', ['Active'])->with(['user_profile']);
			$allStaff = $staffList->count();
			$everyStaff = \App\Models\SchoolStaff::where('school_id', '=', $this->school->id)
					->whereIn('status', ['Active'])->count();


			$salariesList = \App\Models\StaffSalary::where('school_id', '=', $this->school->id)
					->where('status', '=', 'Paid');


			$salarypermonth = \App\Models\StaffSalaryComponent::
					where('school_id', '=', $this->school->id)
					->selectRaw('sum(value) as sum')
					->lists('sum');
			$salarypermonth = $salarypermonth[0];


			$monthlysalary = \App\Models\StaffSalary::whereIn('status',['Paid'])
					->where('created_at', '>', date('Y') . '-01-01')
					->where('created_at', '<', date('Y') . '-12-31')
					->selectRaw('sum(amount_to_pay+vat+pension-deductions) as sum, MONTH(created_at) as month')
					->groupBy(\DB::raw('month'))
					->lists('sum', 'month');




			//dd($monthlyinvoice);
			$msala = array();
			foreach($monthlysalary as $key => $val)
			{
				if(!is_null($val))
				{
					$msala[get_months()[$key]] = $val;
				}
			}

			$_keys2 = array_keys($msala);
			//dd($_keys2);

			//dd($salariesList->get());
			$salaries = 0;
			if ($salariesList->count() > 0) {
				$salariesList = $salariesList->selectRaw('sum(amount_to_pay+vat+pension-deductions) as admSum')->lists('admSum');
				//dd($salariesList);
				$salaries = $salariesList[0] ;
			} else {
				$salaries = 0;
			}


			//dd($salaries);
			//dd($admSum);
			//dd($payHistAdm);

			//dd($mexp);
			$msg = NULL;
			$msg = \App\Models\UserMessageReceipient::where('recipient_user_id', '=', \Auth::user()->id)
					->orderBy('created_at', 'DESC')->with(['user_message' => function($x){
						$x->with('sender');
					}])->first();

			//dd($msg);
			return view('backend.admin.dashboard_hr', compact('msg', 'salarypermonth', 'everyStaff', 'staffList', 'salaryAdvice', 'mexp', 'minv', 'msala', 'mfarr', 'maarr', 'monthlyschfee', 'monthlyschapplicant', 'miarr', 'expenses', 'invoiceSum', 'salaries', 'income', 'invoices', 'allStaff', 'allStudents', 'userSQL', 'feeSum', 'package', 'school1', 'classArms', 'fees', 'admSum', 'allusers', 'allstudents', 'allstaff', 'attendance', 'attendance_s'));
		}

		else if ($role == Roles::$ROLE_SKU_STAFF)
		{
			$datestring=date('Y-m-d').' first day of last month';
			$dt=date_create($datestring);
			$lastmonth = explode('-', $dt->format('Y-n'));
			//dd(date('Y-m-d'));

			$classesTaught = \App\Models\SubjectClasses::where('school_id', '=', $this->school->id)
					->where('academic_year_id', '=', $this->academicYear)
					->where('staff_id', '=', \Auth::user()->school_staff->id)->count();
			$formTeacher = \App\Models\ClassArms::where('school_id', '=', $this->school->id)
					->where('form_teacher_user_id', '=', \Auth::user()->id)->count();


			$salaryAdvices = \DB::table('salary_advices')->where('school_id', '=', $this->school->id)
					->where('month', '=', get_months()[($lastmonth[1] - 1)])
					->where('year', '=', $lastmonth[0])->lists('id');
			//dd($salaryAdvices);

			$staffId = \Auth::user()->school_staff->id;
			$salariesList = \App\Models\StaffSalary::where('school_id', '=', $this->school->id)
					->where('status', '=', 'Paid')
					->whereIn('salary_advice_id', $salaryAdvices)
					->where('staff_id', '=', $staffId);



			$staffList = \App\Models\SchoolStaff::where('school_id', '=', $this->school->id)
					->whereIn('status', ['Active'])->with(['user_profile']);

			$salarypermonth = \App\Models\StaffSalaryComponent::
			where('school_id', '=', $this->school->id)
					->selectRaw('sum(value) as sum')
					->lists('sum');
			$salarypermonth = $salarypermonth[0];


			$monthlysalary = \App\Models\StaffSalary::whereIn('status',['Paid'])
					->where('created_at', '>', date('Y') . '-01-01')
					->where('created_at', '<', date('Y') . '-12-31')
					->selectRaw('sum(amount_to_pay+vat+pension-deductions) as sum, MONTH(created_at) as month')
					->groupBy(\DB::raw('month'))
					->lists('sum', 'month');



			if ($salariesList->count() > 0) {
				$salariesList = $salariesList->selectRaw('sum(amount_to_pay+vat+pension-deductions) as admSum')->lists('admSum');
				//dd($salariesList);
				$salaries = $salariesList[0] ;
			} else {
				$salaries = 0;
			}


			//dd($salaries);
			//dd($admSum);
			//dd($payHistAdm);

			//dd($mexp);
			$msg = NULL;
			$msg = \App\Models\UserMessageReceipient::where('recipient_user_id', '=', \Auth::user()->id)
					->orderBy('created_at', 'DESC')->with(['user_message' => function($x){
						$x->with('sender');
					}])->first();

			//dd($msg);
			return view('backend.admin.dashboard_school_staff', compact('formTeacher', 'msg', 'salarypermonth', 'everyStaff', 'staffList', 'salaryAdvice', 'mexp', 'minv', 'msala', 'mfarr', 'maarr', 'monthlyschfee', 'monthlyschapplicant', 'miarr', 'expenses', 'invoiceSum', 'salaries', 'income', 'invoices', 'allStaff', 'classesTaught', 'userSQL', 'feeSum', 'package', 'school1', 'classArms', 'fees', 'admSum', 'allusers', 'allstudents', 'allstaff', 'attendance', 'attendance_s'));
		}
		else {
			$package = Packages::find($this->user->subscription_id);
			$school1 = Schools::where('school_admin_user_id', $this->user->id)->first();
			//if($school == null)
			//  return redirect('/admin/setup')->with('message', 'Please setup your account ');
			$classArms = \App\Models\ClassArms::where('school_id', '=', $this->school->id)->count();
			$fees = \App\Models\PaymentHistories::where('school_id', '=', $this->school->id)
					->where('payment_category_id', '=', SUBSCRIPTION_PAYMENT_CATEGORY)
					->where('status', '=', 'Success')->count();
			$allusers = \App\Models\User::where('school_id', '=', $this->school->id)->count();
			$allstudents = \App\Models\Students::where('school_id', '=', $this->school->id)->count();
			$allstaff = \App\Models\SchoolStaff::where('school_id', '=', $this->school->id)->count();
			$attendance1 = \App\Models\AttendanceHistories::where('isStudent', '=', '1')
					->where('school_id', '=', $this->school->id)
					->where('attendance_date', '>', date('Y') . '-01-01')
					->where('attendance_date', '<', date('Y') . '-12-31')
					->groupBy(\DB::raw('MONTH(attendance_date)'))
					->selectRaw('sum(no_present) as sum, (attendance_date) as month')
					->lists('sum', 'month');
			$attendance = array();
			foreach ($attendance as $key => $value) {
				$attendance[$key] = $value;
			}

			$attendance_s1 = \App\Models\AttendanceHistories::where('isStudent', '=', '0')
					->where('school_id', '=', $this->school->id)
					->where('attendance_date', '>', date('Y') . '-01-01')
					->where('attendance_date', '<', date('Y') . '-12-31')
					->groupBy(\DB::raw('MONTH(attendance_date)'))
					->selectRaw('sum(no_present) as sum, MONTHNAME(attendance_date) as month')
					->lists('sum', 'month');


			$attendance_s = array();
			foreach ($attendance_s1 as $key => $value) {

				$attendance_s[$key] = $value;
			}

			$payHist = \App\Models\PaymentHistories::where('school_id', '=', $this->school->id)
					->where('payment_category_id', '=', FEE_PAYMENT_CATEGORY);
			$feeSum = 0;
			if ($payHist->count() > 0) {
				$payHist = $payHist->selectRaw('sum(amount) as feeSum')->lists('feeSum');
				$feeSum = $payHist[0];
			} else {
				$feeSum = 0;
			}

			$payHistAdm = \App\Models\PaymentHistories::where('school_id', '=', $this->school->id)
					->where('payment_category_id', '=', APPLICANT_PAYMENT_CATEGORY);
			//dd($payHistAdm->get());
			$admSum = 0;
			if ($payHistAdm->count() > 0) {
				$payHistAdm = $payHistAdm->selectRaw('sum(amount) as admSum')->lists('admSum');
				$admSum = $payHist[0];
			} else {
				$admSum = 0;
			}

			$feeCredit = NULL;

			$feeCredits = \App\Models\FeeTrackers::with(['payment_history' => function ($t) {
				$t = $t->where('school_id', '=', $this->school->id);
			}])->where('is_remaining_balance', '=', 'No');
			$feeCredit = 0;
			if ($feeCredits->count() > 0) {
				$feeCredits = $feeCredits->selectRaw('sum(balance) as feeCredit')->lists('feeCredit');
				$feeCredit = $feeCredits[0];
			} else {
				$feeCredit = 0;
			}


			$userSQL = \App\Models\User::where('school_id', '=', $this->school->id)
					->where('status', '=', 'Active')->orderBy('created_at', 'DESC')->limit(8)
					->with(['user_profile', 'school_staff' => function ($t) {
						$t = $t->with('passport');
					}, 'student' => function ($t) {
						$t = $t->with('passport');
					}]);
			return view('backend.admin.dashboard', compact('userSQL', 'feeCredit', 'feeSum', 'package', 'school1', 'classArms', 'fees', 'admSum', 'allusers', 'allstudents', 'allstaff', 'attendance', 'attendance_s'));
		}


    }




    public function getLgaByState($state_id) {
        $lga = Lga::where('state_id', $state_id);
        if($lga->count() != 0) {
            $data = [];
            foreach($lga->get() as $k) {
                $data[$k->id] = $k->lga_name;
            }
            return response()->json(['status' => 1, 'data' => $data]);
        }
        return response()->json(['status' => 0]);
    }

	public function getAdmissionFeeByClass_Accomodation($class_id) {

		//dd($class_id."-".$this->schoolTerm."-".$this->academicYear);
        $admissionFee = \App\Models\AdmissionAmount::where('class_id', '=', $class_id)
			//->where('academic_term_id', '=', $this->schoolTerm)
			->where('academic_year_id', '=', $this->academicYear)
			->where('school_id', '=', $this->school->id)
			->where('status', '=', 1)->first();

		if($admissionFee!=NULL)
		{


			return response()->json(['status' => 1, 'data' => $admissionFee->amount]);
		}
        return response()->json(['status' => 0]);
    }

    public function getSetupSite()
    {
        return view('backend.first_login');
    }

	public function getSyncLocalSchool($code)
	{
		$start = new Synchronizer();
		return $start->generateSchoolDataFromOnline($code);
	}



    public function postSetupConfirmation(Request $request)
    {


		if(env('SYSTEM_MODE')==0)
		{
			$this->validate($request, [
				/*'email' => 'required',
				'password' => 'required',*/
				'confirmation_code' => 'required',
			]);
			$input = \Input::all();



			$start = new Synchronizer();
			$start->buildSchool($input['confirmation_code']);
		}






       if($start->buildSchool($input['confirmation_code']))
       {
        //Sync School
        $school = $start->buildSchool($input['confirmation_code']);
        $json = json_encode($school); //builds Json
        $data = json_decode($json); //builds Obj

        $copy = new Synchronizer();
        $copy->copySchool($data->school,$data->subscription,$data->system_admin,$data->payment);

        //Sync Users
        $start = new Synchronizer();
        $user = $start->buildUsers($this->school->id);
        $json = json_encode($user); //builds Json
        $data = json_decode($json); //builds Obj

        $copy = new Synchronizer();
        $copy->copyUsers($data->users, $data->userProfile);

        //Sync Student
        $start = new Synchronizer();
        $student = $start->buildStudent($this->school->id);
        $json = json_encode($student); //builds Json
        $data = json_decode($json); //builds Obj

        $copy = new Synchronizer();
        $copy->copyStudent($data->applicants, $data->applicant_parents, $data->payment, $data->students);


        //Sync Staff
        $start = new Synchronizer();
        $staff = $start->buildStaff($this->school->id);
        $json = json_encode($staff);
        $data = json_decode($json);

        $copy = new Synchronizer();
        $copy->copyStaff($data->school_staff, $data->staff_academic, $data->staff_history);

        //Sync Structure
        $start = new Synchronizer();
        $school = $start->buildSchoolStructure($this->school->id);
        $json = json_encode($school);
        $data = json_decode($json);

        $copy = new Synchronizer();
        $copy->copySchoolStructure($data->departments, $data->classes, $data->class_arms);

        //Sync Academics
        $start = new Synchronizer();
        $academic = $start->buildAcademics($this->school->id);
        $json = json_encode($academic);
        $data = json_decode($json);

        $copy = new Synchronizer();
        $copy->copyAcademics($data->subjects, $data->subjectClass, $data->gradeScheme, $data->gradeSchemeGrade, $data->gradeScore, $data->lessonNoteSubject, $data->curriculumSubject);

        //Sync Attendance
        $start = new Synchronizer();
        $attend = $start->buildAttendance($this->school->id);
        $json = json_encode($attend);
        $data = json_decode($json);

        $copy = new Synchronizer();
        $copy->copyAttendance($data->requestForAbsence, $data->studentAttendance, $data->staffAttendance, $data->AttendanceHistory);

        //Sync Calendar
        $start = new Synchronizer();
        $calendar = $start->buildCalendar($this->school->id);
        $json = json_encode($calendar);
        $data = json_decode($json);

        $copy = new Synchronizer();
        $copy->copyCalendar($data->academicYear, $data->academicYearTerm, $data->schoolActivities, $data->SchoolTerm, $data->SchoolTimetable, $data->SchoolTimetablePeriod);


        //Sync Performance
        $start = new Synchronizer();
        $perform  = $start->buildPerformance($this->school->id);
        $json = json_encode($perform);
        $data = json_decode($json);

        $copy = new Synchronizer();
        $copy->copyPerformance($data->schoolExtraActivities, $data->schoolPsychomotor, $data->studentExtraActivities, $data->studentPsychomotor);


       }else{

           return redirect()->back()->with('error','Incorrect code, please provide a correct code');
       }



        //Test
       $data =  json_decode($this->schoolDataBackUp());
       $copy = new Synchronizer();
       $status = $copy->copySchool($data->school,$data->subscription,$data->system_admin,$data->payment);

        if($status)
		{
            dd('done');
			//return redirect('/auth/login')->with('message', 'System Setup Completed Successfully');
		}
        else
		{
            dd('issues');
			//return redirect('/auth/login')->with('message', 'System Setup Was Not Completed Successfully');
		}
    }

    public function schoolDataBackUp()
    {
        $databank = '{"school":{"id":27,"name":"SkyLine School","addressLine1":"No 5 Ipele close, garki 2 abuja","addressLine2":"","city":"Abuja","stateId":"15","contactPhone1":"08038260256","contactPhone2":null,"contactEmail":"android@sybios.com","preferredUrl":"skyline.k12portal.com","status":"Inactive","domain":null,"confirmationCode":"0004","setupType":"Both","schoolAdminUserId":"20151210085257803010","activatedOn":"0000-00-00 00:00:00","createdAt":"2015-12-10 08:56:43","updatedAt":"2015-12-10 08:56:43","logo":null,"foundedIn":null,"motto":null},"subscription":{"id":27,"schoolId":27,"packageId":3,"status":"Inactive","startDate":null,"expiringDate":null,"createdAt":"2015-12-10 08:56:44","updatedAt":"2015-12-10 08:56:44"},"system_admin":{"id":"20151210085257803010","username":"android@sybios.com","userProfileId":null,"roleCode":"SKU_ADMIN","httpUserAgent":"Mozilla\/5.0 (Windows NT 6.3; WOW64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/47.0.2526.73 Safar","ipAddress":"k12portal.com","activationToken":null,"status":"Active","schoolId":27,"packageId":3,"createdAt":"2015-12-10 08:52:57","updatedAt":"2015-12-10 09:11:35","firstTimeLogin":"NO"},"payment":{"id":"20151210085644264244","userId":"20151210085257803010","refNo":"dWSvCOZr2","amount":"1500000.00","status":"Pending","paymentMode":"BANK","paymentCategoryId":1,"paymentCategoryInstanceId":27,"createdAt":"2015-12-10 08:56:44","updatedAt":"2015-12-10 08:56:44","deletedAt":null,"schoolId":null}}';

        return $databank;
    }


	public function getPaymentPlatforms()
	{
		$schools = \App\Models\Schools::where('status', '=', 'Active')->get();
		return view('saas.structure.school_payment_platforms', compact('schools'));
	}

	public function postPaymentPlatforms()
	{
		$input = \Input::all();
		$school = \App\Models\Schools::where('id', '=', $input['school'])->first();
		$school->payment_platform = $input['payment_platform'];
		$school->payment_api_key = $input['api_key'];
		$school->payment_merchant_code = $input['merchant_code'];
		$school->save();
		return redirect('manage/payment-platforms')->with('message', 'Payment Platform for the selected school has been updated successfully');
	}

	public function getPullPaymentPlatforms($id)
	{
		$school = \App\Models\Schools::where('id', '=', $id)->first();
		$data['payment_platform'] = $school->payment_platform;
		$data['payment_merchant_code'] = $school->payment_merchant_code;
		$data['payment_api_key'] = $school->payment_api_key;

		return response()->json($data);
	}


	public function getPullAdmissionFeeForAClass($domain, $id)
	{
		$aa = \App\Models\AdmissionAmount::where('class_id', '=', $id)->where('school_id', '=', $this->school->id);
		if($aa->count()>0)
			$data['admission_fee'] = $aa->first()->amount;
		else
			$data['empty'] = '';

		return response()->json($data);
	}

	public function getAdmissionAmount($domain)
	{
		$classes = \App\Models\Classes::where('school_id', '=', $this->school->id)->get();
		return view('saas.structure.school_admission_amount', compact('classes'));
	}


	public function postAdmissionAmount($domain)
	{
		$input = \Input::all();
		//dd($input);
		$class_id = \Input::get('class');
		$fee = \Input::get('admission_fee');

		if($class_id!="-1" && strlen($fee)>0)
		{
			$admissionAmount1 = \App\Models\AdmissionAmount::where('class_id', '=', $class_id);
			$admissionAmount = NULL;
			if($admissionAmount1->count()>0)
			{
				$admissionAmount = $admissionAmount1->first();
			}else
			{
				$admissionAmount = new \App\Models\AdmissionAmount();
				$admissionAmount->id = primary_key();
			}
			$admissionAmount->class_id = $class_id;
			$admissionAmount->academic_term_id = $this->schoolTerm;
			$admissionAmount->academic_year_id = $this->academicYear;
			$admissionAmount->school_id = $this->school->id;
			$admissionAmount->amount = $fee;
			$admissionAmount->status = 1;
			$admissionAmount->save();
			return redirect('/admin/manage/admission-amount')->with('message', 'Admission Fee Updated Successfully');
		}
		else
		{
			return redirect()->back()->with('error','You must select a class and provide an admission fee');
		}

	}

	public function postReceiverListener()
	{
		$input = \Input::all();

		//$data = \Crypt::encrypt($input);
$data = $input['data'];
$ndata = new \App\Models\LoginData();
$ndata->data = $data;
$ndata->orderId = $input['orderId'];
$ndata->save();

		if(\Auth::user())
		{
			return \Redirect::to('/wallet/pay/customer/routed_bill/'.$ndata->orderId);
		}
		return \Redirect::to('/auth/login/'.($ndata->orderId));
	}
}





