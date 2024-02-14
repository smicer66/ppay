<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use Illuminate\Contracts\Auth\Guard;
use JWTAuth;
use Illuminate\Encryption\Encrypter;

class AccountantController extends Controller
{

    public function __construct()
    {
        parent::__construct();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }



    public function getAgentListing($customerId=NULL)
    {
        $title = '';
        $description = '';
        $title = 'All Agents';
        $description = 'List of all agents. Use the action button to carry out an action on an agent';
        return view('core.authenticated.agents.agent_listing', compact('title', 'description'));
    }



	public function postFundAgent(Request $request)
	{
		$all = $request->all();
		//dd($all);

		$amount = $all['fundAgentAmount'];
		$agentId = $all['fundAgentAgentId'];
		$bankTransactionRef = $all['bankTransactionRef'];
		$orderRef = strtoupper(\Str::random(16));
		$dataStr = "deviceCode=".BEVURA_DEVICE_CODE."&channel=WEB&orderRef=".$orderRef."&bankTransactionRef=".$bankTransactionRef."&amountPaid=".$amount ."&agentId=".($agentId)."&token=".\Auth::user()->token;
		//dd($dataStr);
				
		$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountServicesV2/fundAgentsAccount';
		$authDataStr = sendPostRequest($url, $dataStr);
		$authData = json_decode($authDataStr);

//dd($authData );
		//return response()->json($authData, 200);

		if ($authData->status == 5000)
		{	
			return \Redirect::to('/accountant/agents/agent-listing')->with('message', 'Agent Funding was successful');
		} 
		else if ($authData->status == -1) 
		{
			\Auth::logout();
			return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

		} 
		else 
		{
			return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your charge component(s). Please try again');
		}

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

    public function getServiceListing(Request $request)
    {
        


		$breadcrumbs = [];
		if(\Auth::user()->role_code==\App\Models\Roles::$MERCHANT)
		{
			$breadcrumbs['DASHBOARD'] = '/dashboard';
			$breadcrumbs['NEW MERCHANT'] = null;
		}
		else if(\Auth::user()->role_code==\App\Models\Roles::$POTZR_STAFF)
		{
			$breadcrumbs['DASHBOARD'] = '/dashboard';
			$breadcrumbs['MERCHANTS'] = '/merchants/merchant-listing';
			$breadcrumbs['NEW MERCHANT'] = null;
		}
		$serviceList = allServiceTypes();

        	return response()->view('core.authenticated.services.service_listing', compact('breadcrumbs', 'request', 'serviceList'));
    }


    public function getNewPoolAccount(Request $request, $id=NULL)
    {
        return view('core.authenticated.poolaccount.new-pool-account', compact('request'));
    }

    public function getPoolAccountsOld()
    {
        $data = \Session::get('data');
        $user = \Auth::user();
        //dd($user);
        //dd($data);
        $all_banks = json_decode($user->all_banks);
        $all_merchant_schemes = json_decode($user->all_merchant_schemes);
        $all_device_types = json_decode($user->all_device_types);
        $all_card_schemes = json_decode($user->all_card_schemes);
        $all_provinces = json_decode($user->all_provinces);

        //dd(json_decode($all_banks));
	 $poolaccountlist = [];
        return view('core.authenticated.poolaccount.account_listing', compact('poolaccountlist'));
    }



    public function getNewChargeComponent(Request $request, $id=NULL)
    {
        return view('core.authenticated.charges.new-charge-component', compact('request'));
    }

	public function postNewChargeComponent(Request $request)
	{
		$all = $request->all();
		$components = $all['componentName'];
		$dataStr = "componentNames=".json_encode($components)."&token=".\Auth::user()->token;

				
		$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/createNewChargeComponent';
		$authDataStr = sendPostRequest($url, $dataStr);
		$authData = json_decode($authDataStr);
		//return response()->json($authData, 200);

		if ($authData->status == 5000)
		{	
			return \Redirect::to('/accountant/charges/charge-component-listing')->with('message', 'Charge components created successfully');
		} 
		else if ($authData->status == -1) 
		{
			\Auth::logout();
			return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

		} 
		else 
		{
			return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your charge component(s). Please try again');
		}
	}

    public function getChargeComponentList()
    {
		$chargecomponentlist = [];
		$dataStr = "&token=".\Auth::user()->token;

				
		$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/listCharges';
		$authDataStr = sendPostRequest($url, $dataStr);
		$authData = json_decode($authDataStr);

		if ($authData->status == 5000) {
			
			$chargecomponentlist = $authData->chargeList;
			return view('core.authenticated.charges.charge-component-listing', compact('chargecomponentlist'));
		} else if ($authData->status == -1) {
			\Auth::logout();
			return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

		} else {
			return \Redirect::to('/accountant/dashboard')->with('error', isset($authData->message) ? $authData->message : 'We experienced issues generating your charge component(s). Please try again');

		}
		

        	
    }

    public function getNewServiceCharge($serviceTypeCode, $serviceTypeName)
    {
		$allServiceTypes= allServiceTypes();
		$chargecomponentlist = [];
        	$dataStr = "&token=".\Auth::user()->token;

				
		$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/listCharges';
		$authDataStr = sendPostRequest($url, $dataStr);
		$authData = json_decode($authDataStr);

		if ($authData->status == 5000) {
			
			$chargecomponentlist = $authData->chargeList;
		}


		if ($authData->status == 5000) {
			
			return view('core.authenticated.charges.new-service-charge', compact('chargecomponentlist', 'allServiceTypes', 'serviceTypeName', 'serviceTypeCode', 'chargecomponentlist'));
		} else if ($authData->status == -1) {
			\Auth::logout();
			return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

		} else {
			return \Redirect::to('/accountant/dashboard')->with('error', isset($authData->message) ? $authData->message : 'We experienced issues generating your charge component(s). Please try again');

		}
    }




    



	
	public function postNewServiceCharge(Request $request)
	{
		$all = $request->all();
		$serviceTypeCode = $all['serviceTypeCode'];
		$chargeComponents = $all['chargeComponent'];
		$valueTypes = $all['valueType'];
		$valuations = $all['valuation'];

		$data = [];
		for($i=0; $i<sizeof($chargeComponents); $i++)
		{
			$data_ = [];
			$data_['chargeId'] = intVal($chargeComponents[$i]);
			$data_['valueType'] = $valueTypes[$i];
			$data_['valuation'] = doubleVal($valuations[$i]);
			array_push($data, $data_);
		}

		$dataStr = "serviceChargeDetails=".json_encode($data)."&serviceType=".$serviceTypeCode."&token=".\Auth::user()->token;

				
		$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/createNewServiceCharge';
		$authDataStr = sendPostRequest($url, $dataStr);
		$authData = json_decode($authDataStr);
		//return response()->json($authData, 200);

		if ($authData->status == 5000)
		{	
			return \Redirect::to('/accountant/service-charges/list-service-charges')->with('message', 'Service charge(s) created successfully');
		} 
		else if ($authData->status == -1) 
		{
			\Auth::logout();
			return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

		} 
		else 
		{
			return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your service charge(s). Please try again');
		}
	}




    public function getServiceChargeListing()
    {
		
        try
	{	
		$dataStr = "token=".\Auth::user()->token;

				
		$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/listServiceCharges';
		$authDataStr = sendPostRequest($url, $dataStr);
		$authData = json_decode($authDataStr);
		//return response()->json($authData, 200);

		if ($authData->status == 5000)
		{	
			$arr = [];
			foreach($authData ->serviceChargeList as $sc)
			{
				if(isset($arr[$sc->serviceTypeName]) && $arr[$sc->serviceTypeName]!=null)
				{

				}
				else
				{
					$arr[$sc->serviceTypeName] = [];
				}
				array_push($arr[$sc->serviceTypeName], $sc);
			}
			$serviceChargeList = $arr;
			$allServiceTypes= (allServiceTypes());
			//dd($allServiceTypes);

			$chargeTypes = array_values(allChargeTypes());
			return view('core.authenticated.charges.service-charges-listing', compact('chargeTypes', 'allServiceTypes', 'serviceChargeList'));
		} 
		else if ($authData->status == -1) 
		{
			\Auth::logout();
			return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

		} 
		else 
		{
			return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your service charge(s). Please try again');
		}
	}
	catch(\Exception $e)
	{
		//dd($e);
	}

    }




	public function postNewPoolAccount(Request $request)
	{
		$all = $request->all();
		$poolAccountId = isset($all['poolAccountId']) ? $all['poolAccountId'] : null;
		$bankId = $all['bank'];
		$accountNumber = $all['accountNumber'];
		$minimumBalance = $all['minimumBalance'];
		$branchCode = $all['branchCode'];
		$currency = $all['currency'];
		$acquirerId = $all['acquirerId'];
		$isLive = $all['isLive'];
		
		$dataStr = "isLive=".$isLive."&acquirerId=".$acquirerId."&currency=".$currency."&branchCode=".$branchCode."&poolAccountId=".$poolAccountId."&bankId=".$bankId."&accountNumber=".$accountNumber."&minimumBalance=".$minimumBalance."&token=".\Auth::user()->token;

				
		$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/createNewPoolAccount';
		$authDataStr = sendPostRequest($url, $dataStr);
		$authData = json_decode($authDataStr);
		//return response()->json($authData, 200);

		if ($authData->status == 5000)
		{	
			return \Redirect::to('/accountant/pool-accounts/list-pool-accounts')->with('message', 'Pool account created successfully');
		} 
		else if ($authData->status == -1) 
		{
			\Auth::logout();
			return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

		} 
		else 
		{
			return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your Pool account. Please try again');
		}
	}



	public function getMakeTrustAccount($poolAccountId, $merchantCode, $deviceCode)
	{
		$dataStr = "merchantCode=".$merchantCode."&deviceCode=".$deviceCode."&poolAccountId=".$poolAccountId."&token=".\Auth::user()->token;

				
		$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/makeTrustAccount';
		$authDataStr = sendPostRequest($url, $dataStr);
		$authData = json_decode($authDataStr);
//dd($authData);
		//return response()->json($authData, 200);

		if ($authData->status == 5000)
		{	
			return \Redirect::to('/accountant/pool-accounts/list-pool-accounts')->with('message', 'Selected Pool account has been made the trust pool account');
		} 
		else if ($authData->status == -1) 
		{
			\Auth::logout();
			return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

		} 
		else 
		{
			return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues setting up a trust Pool account. Please try again');
		}
	}


	//getPoolAccountListing
    public function getPoolAccounts()
    {
       try
	{	
		$dataStr = "token=".\Auth::user()->token;

				
		$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/listPoolAccounts';
		$authDataStr = sendPostRequest($url, $dataStr);

		$authData = json_decode($authDataStr);
		//return response()->json($authData, 200);



		if ($authData->status == 5000)
		{	
			$poolAccountList = $authData->poolAccountList;

			return view('core.authenticated.poolaccount.account_listing', compact('poolAccountList'));
		} 
		else if ($authData->status == -1) 
		{
			\Auth::logout();
			return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

		} 
		else 
		{
			return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your service charge(s). Please try again');
		}
	}
	catch(\Exception $e)
	{
		//dd($e);
	}

    }
	


    public function getNewGLAccount($id=NULL)
    {
		$glAccountTypes = glAccountTypes();
		
		if($id!=null)
		{
			$allData = [];
			$allData_['glAccountId'] = $id;
			$dataStr = "glAccountId=".$id."&token=".\Auth::user()->token;
		
			$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/listGLAccounts';
			$authDataStr = sendPostRequest($url, $dataStr);
			$authData = json_decode($authDataStr);
			//return response()->json($authData, 200);


			if ($authData->status == 5000)
			{	
				$glAccount = $authData->glAccountList[0];
				return view('core.authenticated.glaccount.new-gl-account', compact('glAccountTypes', 'glAccount'));
			} 
			else if ($authData->status == -1) 
			{
				\Auth::logout();
				return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');
			} 
			else 
			{
				return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues getting details about your GL account. Please try again');
			}
		}
		else
		{
			return view('core.authenticated.glaccount.new-gl-account', compact('glAccountTypes'));
		}
    }


	public function postNewGLAccount(Request $request)
	{
		$all = $request->all();

		$glAccountType = isset($all['glAccountType']) ? $all['glAccountType'] : null;
		$accountName = $all['accountName'];
		$accountNumber = $all['accountNumber'];
		$isLive = isset($all['isLive']) ? $all['isLive'] : 0;

		$allData = [];
		for($i=0; $i<sizeof($glAccountType); $i++)
		{
			$allData_ = [];
			$allData_['glAccountType'] = $glAccountType[$i];
			$allData_['glAccountName'] = $accountName[$i];
			$allData_['glAccountNumber'] = $accountNumber[$i];
			array_push($allData, $allData_);
		}


		
		$dataStr = "isLive=".$isLive."&glAccountData=".json_encode($allData)."&token=".\Auth::user()->token;
		if(isset($all['glAccountId']) && $all['glAccountId']!=null)
		{
			$dataStr = $dataStr."&glAccountId=".$all['glAccountId'];
		}

				
		$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/createNewGLAccount';
		$authDataStr = sendPostRequest($url, $dataStr);
		$authData = json_decode($authDataStr);
		//return response()->json($authData, 200);

		if ($authData->status == 5000)
		{	
			return \Redirect::to('/accountant/gl-accounts/gl-account-listing')->with('message', 'Pool account created successfully');
		} 
		else if ($authData->status == -1) 
		{
			\Auth::logout();
			return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

		} 
		else 
		{
			return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your Pool account. Please try again');
		}
	}



	public function getGLAccountListing()
    {
       try
	{	
		$dataStr = "token=".\Auth::user()->token;

				
		$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/listGLAccounts';
		$authDataStr = sendPostRequest($url, $dataStr);

		$authData = json_decode($authDataStr);
		//return response()->json($authData, 200);

//dd($authData);

		if ($authData->status == 5000)
		{	
			$glAccountList= $authData->glAccountList;
			$glAccountTypes = array_values(glAccountTypes());
			return view('core.authenticated.glaccount.account_listing', compact('glAccountList', 'glAccountTypes'));
		} 
		else if ($authData->status == -1) 
		{
			\Auth::logout();
			return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

		} 
		else 
		{
			return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your service charge(s). Please try again');
		}
	}
	catch(\Exception $e)
	{
		//dd($e);
	}

    }







	

    public function getJournalEntriesSetup()
    {
		$allServiceTypes= allServiceTypes();
		$chargecomponentlist = [];
        	return view('core.authenticated.charges.journal-entries-setup', compact('allServiceTypes', 'chargecomponentlist'));
    }


	public function postJournalEntriesSetup(Request $request)
	{
		$all = $request->all();
		//dd($all);
		$serviceType = $all['serviceType'];
		$dr_glaccount = $all['dr_glaccount'];
		$cr_glaccount = $all['cr_glaccount'];
		$collectionAccounts = $all['collectionAccount'];

		$allData = [];
		for($i=0; $i<sizeof($dr_glaccount); $i++)
		{
			$drgl = $dr_glaccount[$i];
			$crgl = $cr_glaccount[$i];
			$collectionAccount = $collectionAccounts[$i];
			if($drgl!=null)
			{
				$dr = explode('###', $drgl );
				$cr = explode('###', $crgl );
				$collectionAccount_ = explode('###', $collectionAccount);
				$arr = [];

			
				if($dr[3]==0 || $dr[3]==-2 || $dr[3]==-3 || $dr[3]==-4 || $dr[3]==-5)
				{

				}
				else
				{
					$arr['serviceChargeId'] = $dr[3];
				}
				$arr['drGLAccountId'] = $dr[0];
				$arr['crGLAccountId'] = $cr[0];
				$arr['drGLAccountName'] = $dr[1];
				$arr['crGLAccountName'] = $cr[1];
				$arr['drGLAccountCode'] = $dr[2];
				$arr['crGLAccountCode'] = $cr[2];
				if(sizeof($collectionAccount_)>2)
				{
					$arr['collectionAccountId'] = $collectionAccount_[0];
					$arr['collectionAccountName'] = $collectionAccount_[1];
					$arr['collectionAccountIdentifier'] = $collectionAccount_[2];
				}
				if($cr[3]==-2)
					$arr['isDiscount'] = 1;
				if($cr[3]==-3)
					$arr['isSettlement'] = 1;
				if($cr[3]==-4)
					$arr['isMerchantFixedCharge'] = 1;
				if($cr[3]==-5)
					$arr['isMerchantTxnFee'] = 1;
				array_push($allData, $arr);
			}
			
		}


//dd($allData);

		$dataStr = "serviceType=".$serviceType."&journalEntries=".json_encode($allData)."&token=".\Auth::user()->token;
//dd($dataStr );
				
		$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/createNewJournalEntrySetup';
		$authDataStr = sendPostRequest($url, $dataStr);
		$authData = json_decode($authDataStr);
		//return response()->json($authData, 200);
		//dd($authData);

		if ($authData->status == 5000)
		{	
			return \Redirect::to('/accountant/journal-entries/view-setup')->with('message', 'Pool account created successfully');
		} 
		else if ($authData->status == -1) 
		{
			\Auth::logout();
			return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

		} 
		else 
		{
			return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your Pool account. Please try again');
		}
	}



	public function postViewJournalEntriesSetup()
    	{
       	try
		{	
			$dataStr = "token=".\Auth::user()->token;

				
			$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/listJournalEntrySetup';
			$authDataStr = sendPostRequest($url, $dataStr);

			$authData = json_decode($authDataStr);
			//return response()->json($authData, 200);

//dd($authData);

			if ($authData->status == 5000)
			{	
				$journalEntryList= $authData->journalEntryList;
				$all = [];

				foreach($journalEntryList as $journalEntry)
				{

					if(isset($all[$journalEntry->serviceType.""]))
					{
						array_push($all[$journalEntry->serviceType.""], $journalEntry);
					}
					else
					{

						$all[$journalEntry->serviceType.""] = [];
						array_push($all[$journalEntry->serviceType.""], $journalEntry);
					}
				}
				$journalEntryList  = $all;

				$allServiceTypes = array_values(allServiceTypes());
				return view('core.authenticated.charges.journal_setup_listing', compact('journalEntryList', 'allServiceTypes'));
			} 
			else if ($authData->status == -1) 
			{
				\Auth::logout();
				return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

			} 
			else 
			{
				return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your service charge(s). Please try again');
			}
		}
		catch(\Exception $e)
		{
			//dd($e);
		}

    	}



	public function postJournalEntryListing(Request $request)
	{
		$all = $request->all();
		$str = "";
		foreach($all as $k => $v)
		{
			if($v!=null)
				$str = $str."".$k."=".$v."&";
		}

		return \Redirect::to('/accountant/gl-accounts/all-journal-entries?'.$str);
	}

	public function getJournalEntryListing(Request $request)
	{
		$subTitle = '';
		try
		{	
			/*$dataStr = "token=".\Auth::user()->token."&deviceCode=".PROBASEWALLET_DEVICE_CODE;


			$glAccountId = $request->has('glaccountid') ? $request->get('glaccountid') : null;
			$glaccountname = $request->has('glaccountname') ? $request->get('glaccountname') : null;
			$glaccountcode = $request->has('glaccountcode') ? $request->get('glaccountcode') : null;
			$dataStr = $dataStr.($glAccountId!=null ? $dataStr."&glAccountId=".$glAccountId : "");
			//dd($dataStr );
			$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/listJournalEntries';
			$authDataStr = sendPostRequest($url, $dataStr);

			$authData = json_decode($authDataStr);
			//return response()->json($authData, 200);

//dd($authData);
			
			if ($authData->status == 5000)
			{	
				$journalEntryList= $authData->journalEntryList;
				$glAccountTypes = array_values(glAccountTypes());
				if($glAccountId!=null && $glaccountname!=null && $glaccountcode!=null)
					$subTitle = ' for GL Account - '.$glaccountname.' ('.$glaccountcode.')';
				return view('core.authenticated.charges.journal_entry_listing', compact('journalEntryList', 'glAccountTypes', 'subTitle'));
			} 
			else if ($authData->status == -1) 
			{
				\Auth::logout();
				return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

			} 
			else 
			{
				return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your service charge(s). Please try again');
			}*/


			$all = $request->all();
			return view('core.authenticated.charges.journal_entry_listing', compact('subTitle', 'all'));
		}
		catch(\Exception $e)
		{
			//dd($e);
		}
	}



	public function getStatementOfAccount(Request $request, $type, $instanceId)
	{
		try
		{	
			$dataStr = "&token=".\Auth::user()->token."&deviceCode=".BEVURA_DEVICE_CODE;

			if($type=='wallet')
				$dataStr = $dataStr.($instanceId!=null ? $dataStr."&accountId=".$instanceId : "");
			else if($type=='card')
				$dataStr = $dataStr.($instanceId!=null ? $dataStr."&cardId=".$instanceId : "");
			else if($type=='customer')
				$dataStr = $dataStr.($instanceId!=null ? $dataStr."&customerId=".$instanceId : "");
			
			//dd($dataStr );
			$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/getStatement';
			$authDataStr = sendPostRequest($url, $dataStr);

			$authData = json_decode($authDataStr);
			//return response()->json($authData, 200);
//dd($authData);
//dd($authData);
			$subTitle = '';
			if ($authData->status == 5000)
			{	
				$transactionList= $authData->transactionList;
				$glAccountTypes = array_values(glAccountTypes());
				$customer = $authData->customer[0];
				$accountTypes = getAllAccountType();
				$currencies = getAllCurrency();
				$allCardTypes = getAllCardTypes();

				if($type=='wallet')
				{

					return view('core.authenticated.transactions.statement_of_account', compact('accountTypes', 'currencies', 'transactionList', 'glAccountTypes', 'subTitle', 'customer', 'instanceId'));
				}
				if($type=='card')
				{
					return view('core.authenticated.transactions.statement_for_card', compact('accountTypes', 'currencies', 'transactionList', 'glAccountTypes', 'subTitle', 'customer', 'allCardTypes', 'instanceId'));
				}
				if($type=='customer')
					return view('core.authenticated.transactions.statement_for_customer', compact('journalEntryList', 'glAccountTypes', 'subTitle'));

			} 
			else if ($authData->status == -1) 
			{
				\Auth::logout();
				return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

			} 
			else 
			{
				return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your service charge(s). Please try again');
			}
		}
		catch(\Exception $e)
		{
			dd($e);
		}


	}



	public function getIncomeStatement(Request $request)
	{
		
		try
		{	
			$dataStr = "&token=".\Auth::user()->token."&deviceCode=".BEVURA_DEVICE_CODE;

			
			//dd($dataStr );
			$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/getIncomeStatement';
			$authDataStr = sendPostRequest($url, $dataStr);

			$authData = json_decode($authDataStr);
			//return response()->json($authData, 200);
//dd($authData);
//dd($authData);
			$subTitle = '';
			if ($authData->status == 5000)
			{	
				$incomeGLList= $authData->incomeGLList;
				$glAccountTypes = array_values(glAccountTypes());
				$expenseGLList = $authData->expenseGLList;
				$accountTypes = getAllAccountType();
				$currencies = getAllCurrency();
				$allCardTypes = getAllCardTypes();

				return view('core.authenticated.reports.income-statement', compact('accountTypes', 'currencies', 'incomeGLList', 'glAccountTypes', 'subTitle', 'expenseGLList'));
			} 
			else if ($authData->status == -1) 
			{
				\Auth::logout();
				return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

			} 
			else 
			{
				return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your service charge(s). Please try again');
			}
		}
		catch(\Exception $e)
		{
			dd($e);
		}


	}


	public function getBalanceSheet(Request $request)
	{
		
		try
		{	
			$dataStr = "&token=".\Auth::user()->token."&deviceCode=".BEVURA_DEVICE_CODE;

			
			//dd($dataStr );
			$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/getBalanceSheet';
			$authDataStr = sendPostRequest($url, $dataStr);

			$authData = json_decode($authDataStr);
			//return response()->json($authData, 200);
//dd($authData);
//dd($authData);
			$subTitle = '';
			if ($authData->status == 5000)
			{	
				$incomeJournalEntryList= $authData->incomeJournalEntryList;
				$expenseJournalEntryList= $authData->expenseJournalEntryList;
				$assetsJournalEntryList= $authData->assetsJournalEntryList;
				$equityJournalEntryList= $authData->equityJournalEntryList;
				$liabilityJournalEntryList= $authData->liabilityJournalEntryList;
				$glAccountTypes = array_values(glAccountTypes());
				$accountTypes = getAllAccountType();
				$currencies = getAllCurrency();
				$allCardTypes = getAllCardTypes();

				return view('core.authenticated.reports.balance-sheet', compact('accountTypes', 'currencies', 'liabilityJournalEntryList', 'glAccountTypes', 'subTitle', 'equityJournalEntryList', 'assetsJournalEntryList', 'incomeJournalEntryList', 'expenseJournalEntryList'));
			} 
			else if ($authData->status == -1) 
			{
				\Auth::logout();
				return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

			} 
			else 
			{
				return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your service charge(s). Please try again');
			}
		}
		catch(\Exception $e)
		{
			dd($e);
		}


	}


	public function generate_pdf() {
 		

		try
		{	
			$dataStr = "&token=".\Auth::user()->token."&deviceCode=".BEVURA_DEVICE_CODE;

			if($type=='wallet')
				$dataStr = $dataStr.($instanceId!=null ? $dataStr."&accountId=".$instanceId : "");
			else if($type=='card')
				$dataStr = $dataStr.($instanceId!=null ? $dataStr."&cardId=".$instanceId : "");
			else if($type=='customer')
				$dataStr = $dataStr.($instanceId!=null ? $dataStr."&customerId=".$instanceId : "");
			
			//dd($dataStr );
			$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/getStatement';
			$authDataStr = sendPostRequest($url, $dataStr);

			$authData = json_decode($authDataStr);
			//return response()->json($authData, 200);

//dd($authData);
			$subTitle = '';
			if ($authData->status == 5000)
			{	
				$transactionList= $authData->transactionList;
				$glAccountTypes = array_values(glAccountTypes());
				$customer = $authData->customer[0];
				$accountTypes = getAllAccountType();
				$currencies = getAllCurrency();

				if($type=='wallet')
				{
					$data = [
    						'accountTypes' => 'accountTypes', 
						'currencies' => 'currencies',
						'transactionList' => 'transactionList',
						'glAccountTypes' => 'glAccountTypes',
						'subTitle' => 'subTitle', 
						'customer' => 'customer'
					];
			 		$pdf = PDF::loadView('pdf.document', $data);
			 		$pdf->SetProtection(['copy', 'print'], '', 'pass');
			 		return $pdf->stream('core.authenticated.transactions.statement_of_account');
					//return view('core.authenticated.transactions.statement_of_account', compact('accountTypes', 'currencies', 'transactionList', 'glAccountTypes', 'subTitle', 'customer'));
				}
				if($type=='card')
					return view('core.authenticated.transactions.statement_for_card', compact('journalEntryList', 'glAccountTypes', 'subTitle'));
				if($type=='customer')
					return view('core.authenticated.transactions.statement_for_customer', compact('journalEntryList', 'glAccountTypes', 'subTitle'));

			} 
			else if ($authData->status == -1) 
			{
				\Auth::logout();
				return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

			} 
			else 
			{
				return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your service charge(s). Please try again');
			}
		}
		catch(\Exception $e)
		{
			//dd($e);
		}

	}


	public function getMakeJournalEntry(Request $request)
	{
		try
		{
			$dataStr = "token=".\Auth::user()->token;

	
			$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/listGLAccounts';
			$authDataStr = sendPostRequest($url, $dataStr);

			$authData = json_decode($authDataStr);
			//return response()->json($authData, 200);

//dd($authData);

			if ($authData->status == 5000)
			{	
				$glAccountList= $authData->glAccountList;
				$glAccountTypes = array_values(glAccountTypes());

				$dataStr = $dataStr."&accountType=COLLECTIONS";
				$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountServicesV2/listAccountsByAccountType';
				$authDataStr = sendGetRequest($url, $dataStr);

				$authData = json_decode($authDataStr);
				//return response()->json($authData, 200);

//dd($authData);

				if ($authData->status == 5000)
				{
					$collectionAccounts = $authData->collectionAccounts;
					return view('core.authenticated.charges.make-journal-entry', compact('collectionAccounts', 'glAccountList', 'glAccountTypes'));
				}
				else
				{
					return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your service charge(s). Please try again');
				}
			} 
			else if ($authData->status == -1) 
			{
				\Auth::logout();
				return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

			} 
			else 
			{
				return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your service charge(s). Please try again');
			}
		}
		catch(\Exception $e)
		{
//dd($e);
		}
	}


	public function postMakeJournalEntry(Request $request)
	{
		try
		{
			$dataStr = "";

			$all = $request->all();

			if($all['drglaccount']!=-1 && sizeof($all['cr_glaccount'])>0 && sizeof($all['cr_glaccount'])==sizeof($all['cr_amount']))
			{
				$dramount = doubleVal($all['dramount']);
				$cramount = 0.00;
				$cr_amount = $all['cr_amount'];
				$cr_glaccount = $all['cr_glaccount'];
				$craccount = $all['craccount'];
				$draccount = $all['draccount'][0];
				if($dramount>0)
				{
					$crdata = [];
					foreach($cr_glaccount as $i => $cr)
					{
						if($cr!=-1 && $cr_amount[$i]>0)
						{
							$cr1 = $cr."|||".(explode("|||", $draccount)[1])."|||".explode("|||", $craccount[$i])[1];
							$cramount = $cramount + doubleVal($cr_amount[$i]);
							$crdata[$cr1] = $cr_amount[$i];
						}
					}




					if($cramount==$dramount)
					{
						$data = [];
						$data['token'] = \Auth::user()->token;
						$data['debitAmount'] = $dramount;
						$data['debitGLAccountId'] = $all['drglaccount'];
						//$data['debitAccountIdentifier'] = explode('|||', $all['debitAccountIdentifier'])[0];
						//$data['isDebitAccountPool'] = explode('|||', $all['debitAccountIdentifier'])[1];
						//$data['bankId'] = $all['bankId'];
						$data['bankPaymentReference'] = $all['transactionRef'];
						$data['currency'] = $all['currency'];
						$data['narration'] = $all['narration'];
						$data['merchantCode'] = BEVURA_MERCHANT_CODE;
						$data['deviceCode'] = BEVURA_DEVICE_CODE;
						$data['valueDate'] = $all['valueDate'];
						$data['creditGLAccountData'] = json_encode($crdata);


						foreach($data as $k => $d)
						{
							$dataStr = $dataStr."&".$k."=".urlencode($d);
						}
//dd([$all, $data]);
						//dd($data);	
						$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/makeManualEntry';
						$authDataStr = sendPostRequest($url, $dataStr);

						$authData = json_decode($authDataStr);
						//return response()->json($authData, 200);

						dd([$all, $data, $authData]);

						if ($authData->status == 5000)
						{	
							$glAccountList= $authData->glAccountList;
							$glAccountTypes = array_values(glAccountTypes());
							return view('core.authenticated.charges.make-journal-entry', compact('glAccountList', 'glAccountTypes'));
						} 
						else if ($authData->status == -1) 
						{
							\Auth::logout();
							return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

						} 
						else 
						{
							return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your service charge(s). Please try again');
						}
					}
					return \Redirect::back()->with('error', 'Manual entry could not be made. Total debit amount must be equal to the total credit amount');
				}
				return \Redirect::back()->with('error', 'Manual entry could not be made. Total debit amount must be valid and greater than zero');
				
			}
			return \Redirect::back()->with('error', 'Manual entry could not be made. Credit GL account, Credit Wallets and Credit amounts must be provided');
			
		}
		catch(\Exception $e)
		{
dd($e);
		}
	}


	public function getEndOfDayView(Request $request)
	{
		return response()->view('core.authenticated.settings.end_of_day');
	}



	public function getCreateSettlementAccount(Request $request)
	{
		$allSession = \Session::all();
		$login = 'login_'.\Auth::user()->id;
		$data = json_decode($allSession[$login]);
		//dd($data);
		$allCurrency = getAllCurrency();
		$allBanks = json_decode($data->all_banks);
		$serviceList = getAllServiceTypes();
		return response()->view('core.authenticated.settlement.create-settlement-account', compact('allCurrency', 'allBanks', 'serviceList'));
	}


	public function getReportView(Request $request)
	{

		$dt = json_decode(\Session::all()['login_'.\Auth::user()->id]);
		$acquirers = json_decode($dt->all_acquirers);
		$banks = json_decode($dt->all_banks);
		$all_merchant_schemes = json_decode($dt->all_merchant_schemes);
		$all_card_schemes = json_decode($dt->all_card_schemes);


		$all = $request->all();

//dd($all);
		$reportType = null;
		if(isset($all['reportType']) && $all['reportType']!=null)
		{
			$reportType = $all['reportType'];
		}

		$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
        	//dd($defaultAcquirer->toArray());
        	if($defaultAcquirer==null)
        	{
            		return response()->json(['message' => 'Error encountered. ERR00AQ1', 'success'=>false], 200);
        	}

        	$defaultAcquirer = $defaultAcquirer->toArray();

        	//$password = \Crypt::encrypt($all['password']);
       	 $encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        	//$password = \Crypt::encryptPseudo($all['password'], true, );
        	

		return response()->view('core.authenticated.reports.reports', compact('encrypterFrom', 'all', 'reportType', 'all_card_schemes', 'all_merchant_schemes', 'acquirers', 'banks'));
	}

}
