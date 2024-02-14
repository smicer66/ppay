<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use JWTAuth;
use Illuminate\Support\Str;
use Illuminate\Encryption\Encrypter;
use \PDF;
use \ZipArchive;

class ApiController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
		parent::__construct();
        $this->middleware(['api'], ['except' => ['index', 'postRegisterCustomer', 'pullBalancesByToken']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
	}



	public function getCustomerStatement(Request $request, $type, $instanceId, $token)
	{
		/*$file = public_path()."/zipake_terms_conditions.pdf";
		//dd(public_path());
		$file = \File::get($file);*/

		$data = [
	            'title' => 'Welcome to ItSolutionStuff.com',
       	     'date' => date('m/d/Y')
        	];


		try
		{	
			$dataStr = "&token=".$token."&deviceCode=".BEVURA_DEVICE_CODE;

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
//dd($dataStr);
//dd($authData);
			$subTitle = '';
			if ($authData->status == 5000)
			{	
				$transactionList= $authData->transactionList;
				$glAccountTypes = array_values(glAccountTypes());
				$customer = $authData->customer[0];
//dd($customer);
				$accountTypes = getAllAccountType();
				$currencies = getAllCurrency();
				$allCardTypes = getAllCardTypes();

				if($type=='wallet')
				{

					$pdf = PDF::loadView('core.authenticated.transactions.statement_of_account', compact('accountTypes', 'currencies', 'transactionList', 'glAccountTypes', 'subTitle', 'customer', 'instanceId'));
					return $pdf->download('itsolutionstuff.pdf');

				}
				if($type=='card')
				{
					return view('core.authenticated.transactions.statement_for_card', compact('accountTypes', 'currencies', 'transactionList', 'glAccountTypes', 'subTitle', 'customer', 'allCardTypes', 'instanceId'));
					return $pdf->download('itsolutionstuff.pdf');

				}
				if($type=='customer')
				{

					$opciones_ssl=array(
						"ssl"=>array(
							"verify_peer"=>false,
							"verify_peer_name"=>false,
						),
					);
					$img_path = 'images/bevurabluelogo.png';
					$extencion = pathinfo($img_path, PATHINFO_EXTENSION);
					$data = file_get_contents($img_path, false, stream_context_create($opciones_ssl));
					$img_base_64 = base64_encode($data);
					$path_img = 'data:image/' . $extencion . ';base64,' . $img_base_64;
					
					$pdf = PDF::loadView('core.authenticated.transactions.statement_of_account_pdf', 
						compact('path_img', 'accountTypes', 'currencies', 'transactionList', 'glAccountTypes', 'subTitle', 'customer', 'allCardTypes', 'instanceId')
					);
					$pdf->setEncryption(substr($customer->accountIdentifier, strlen($customer->accountIdentifier)-4));


					/*
					$pdf = PDF::loadView('core.authenticated.transactions.statement_of_account_pdf', 
						compact('path_img', 'accountTypes', 'currencies', 'transactionList', 'glAccountTypes', 'subTitle', 'customer', 'allCardTypes', 'instanceId'), 
							[
				                     'format' => 'A4-L',
				                     'orientation' => 'L',
				                     'mode' => 'c'
			              		]
					);*/
					return $pdf->download($customer->firstName.' '.$customer->lastName.' - Wallet Card Statement '.date('Ymd').'.pdf');
				}

			} 
			else if ($authData->status == -1) 
			{
			
				//return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

			} 
			else 
			{
				//return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your service charge(s). Please try again');
			}
		}
		catch(\Exception $e)
		{
			dd($e);
		}



          
        	//$pdf = PDF::loadView('myPDF', $data);
    
        	//return $pdf->download('itsolutionstuff.pdf');
   		/*$response = \Response::make($file, 200);
		$response->header('Content-Type', 'application/pdf');
   		$response->header('Content-Type', 'application/pdf');
   		return $response;*/
	}





	public function getTransactionReceipt(Request $request, $type, $instanceId, $token)
	{
		/*$file = public_path()."/zipake_terms_conditions.pdf";
		//dd(public_path());
		$file = \File::get($file);*/

		$data = [
	            'title' => 'Welcome to ItSolutionStuff.com',
       	     'date' => date('m/d/Y')
        	];


		try
		{	
			$dataStr = "&token=".$token."&deviceCode=".BEVURA_DEVICE_CODE;

			$dataStr = $dataStr.($instanceId!=null ? $dataStr."&transactionRef=".$instanceId : "");
			
			//dd($dataStr );
			$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/TransactionServicesV2/getTransactionDetails';
			$authDataStr = sendPostRequest($url, $dataStr);

			$authData = json_decode($authDataStr);
			//return response()->json($authData, 200);
//dd($authData);
//dd($authData);
			$subTitle = '';
			if ($authData->status == 5000)
			{	
				$transaction= $authData->transaction;
				$currencies = getAllCurrency();
				$allCardTypes = getAllCardTypes();
				$serviceType = array_keys(getAllServiceTypes())[$authData->transaction->serviceType];


//dd($serviceType);

				$opciones_ssl=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);
				$img_path = 'images/bevurabluelogo.png';
				$extencion = pathinfo($img_path, PATHINFO_EXTENSION);
				$data = file_get_contents($img_path, false, stream_context_create($opciones_ssl));
				$img_base_64 = base64_encode($data);
				$path_img = 'data:image/' . $extencion . ';base64,' . $img_base_64;
				
				


				if($serviceType!=null)
				{
					$pdf = PDF::loadView('core.authenticated.transactions.'.strtolower($serviceType).'_pdf', 
						compact('path_img', 'transaction', 'currencies', 'allCardTypes', 'instanceId')
					);
					return $pdf->download(strtoupper($instanceId).' - Receipt.pdf');
				}

			} 
			else if ($authData->status == -1) 
			{
			
				//return \Redirect::to('/auth/login')->with('error', 'Your session has expired. Please try to login to continue what you were doing');

			} 
			else 
			{
				//return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'We experienced issues creating your service charge(s). Please try again');
			}
		}
		catch(\Exception $e)
		{
			dd($e);
		}



          
        	//$pdf = PDF::loadView('myPDF', $data);
    
        	//return $pdf->download('itsolutionstuff.pdf');
   		/*$response = \Response::make($file, 200);
		$response->header('Content-Type', 'application/pdf');
   		$response->header('Content-Type', 'application/pdf');
   		return $response;*/
	}


    public function postRegisterCustomer(Request $request)
    {
	try
	{

        $all = $request->all();
	 //return $all;
		

        $rules = ['mobileNumber' => 'required|between:9,10', 'password' => 'required', 'confirmPassword' => 'required|same:password', 'firstName' => 'required',
            'lastName' => 'required',
        ];

        $messages = [
            'mobileNumber.required' => 'Specify a valid mobile number belonging to you.',
            'mobileNumber.between' => 'The mobile number you provided is not a valid Zambian mobile number. Please provide a valid one',
            'password.required' => 'Please specify a valid password',
            'confirmPassword.required' => 'Retype your password in the confirmation password field',
            'confirmPassword.same' => 'Your password and the confirmation passwords must match',
            'firstName.required' => 'Please specify your first name',
            'lastName.required' => 'Please specify your last name',
            'securityQuestionId.required' => 'Please specify your preferred security question',
            'securityAnswer.required' => 'Please specify the answer to your security question',
        ];



        $validator = \Validator::make($all, $rules, $messages);
        if($validator->fails())
        {
            $errMsg = json_decode($validator->messages(), true);
            $str_error = "";
            $i = 1;
            $array_errors = [];
            foreach($errMsg as $key => $value)
            {
                foreach($value as $val) {
                    array_push($array_errors, $val);
                }
            }
            //$errors = join('<br>', $array_errors);
		$errors = ($array_errors[0]);

            return response()->json(['message' => $errors, 'success' => false], 200);
        }



	 
        if(strlen($all['mobileNumber'])==10 && substr($all['mobileNumber'], 0, 1)=='0')
        {
            $all['mobileNumberEdited'] = substr($all['mobileNumber'], 1);
        }
        else
        {
            if(strlen($all['mobileNumber'])==10 && substr($all['mobileNumber'], 0, 1)!='0')
            {
                return response()->json(['message' => 'Invalid mobile number provided. Please provide a valid Zambian mobile number', 'success'=>false], 200);
            }
            else
            {
                $all['mobileNumberEdited'] = $all['mobileNumber'];
            }
        }
	
        $data = [];
        //$password = encrypt(($all['password']));
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
        $password = $encrypterFrom->encrypt($all['password']."");
        //dd($password);
        $data['username'] = $all['countrycode']."".$all['mobileNumberEdited'];
        $data['mobileNumber'] = $all['countrycode']."".$all['mobileNumberEdited'];
        $data['encPassword'] = $password;
        $data['firstName'] = $all['firstName'];
        $data['lastName'] = $all['lastName'];
        $data['otherName'] = $all['otherName'];
        $data['securityQuestionId'] = $all['securityQuestionId'];
        $data['securityAnswer'] = $all['securityAnswer'];
        $data['roleCode'] = 'CUSTOMER';
        $data['acquirerCode'] = $defaultAcquirer['acquirerCode'];
	 $data['probasePayDeviceCode'] = isset($all['probasePayDeviceCode']) ? $all['probasePayDeviceCode'] : PROBASEWALLET_DEVICE_CODE;
	 $data['probasePayMerchantCode'] = isset($all['probasePayMerchantCode']) ? $all['probasePayMerchantCode'] : PROBASEWALLET_MERCHANT_CODE;
	 $data['isBiometric'] = isset($all['isBiometric']) && $all['isBiometric']!=null ? $all['isBiometric'] : 0;
	 $data['autoAuthenticate'] = isset($all['autoAuthenticate']) && $all['autoAuthenticate']!=null ? $all['autoAuthenticate'] : 0;

        
	if(isset($all['deviceKey']) && isset($all['deviceId']) && $all['deviceKey']!=null && strlen($all['deviceKey'])>0 && $all['deviceId']!=null && strlen($all['deviceId'])>0)
	{
		$data['deviceId'] = $all['identifier'];
        	$data['deviceVersion'] = $all['deviceVersion'];
        	$data['deviceName'] = $all['deviceName'];
        	$data['deviceKey'] = $all['deviceKey'];
        	$data['device_app_id'] = $all['deviceId'];
	}
	else
	{
			//return response()->json(['keys'=>array_keys($all), 'message' => 'New profile user could not be created. Invalid request format', 'success'=>false], 200);
	}
	//return response()->json(['keys'=>array_keys($data)], 200);
	

        $result = null;
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UserServicesV2/createNewUserAccount';
        $authDataStr = sendPostRequest($url, $dataStr);
        $authData = json_decode($authDataStr);

        if($authData->status==500) {
            $otp = $authData->otp;
	     $loggedInData = $authData->loggedInData;

		$resp = [];
		if(isset($loggedInData->status) && $loggedInData->status!=null && $loggedInData->status == 600) {
				$token = $loggedInData->token;
				

				$resp['status'] = 100;
				$resp['isBiometric'] = isset($loggedInData->isBiometric) ? $loggedInData->isBiometric : null;
				$resp['usernameStr'] = "+".join(' ', str_split($loggedInData->mobileno, 3));
				$resp['success'] = true;
				$resp['message'] = 'Logged in successfully';


                    		$resp['customerId'] = isset($loggedInData->customer_id) ? $loggedInData->customer_id : null;
                    		$resp['server_token'] = $loggedInData->token;
                    		$resp['auth_id'] = $loggedInData->id;
                   		$resp['roleCode'] = $loggedInData->role_code;
                    		$resp['mobileNumber'] = $loggedInData->mobileno;
                    		$resp['username'] = $loggedInData->username;
                    		$resp['accounts'] = isset($loggedInData->accounts) ? json_encode($loggedInData->accounts) : json_encode([]);
                    		$resp['cards'] = isset($loggedInData->ecards) ? json_encode($loggedInData->ecards) : json_encode([]);
                    		$resp['status'] = 100;
                    		$resp['success'] = true;
                    		$resp['displayName'] = $loggedInData->firstName." ".$loggedInData->lastName;
                    		$resp['profile_pix'] = isset($loggedInData->profile_pix) && $loggedInData->profile_pix!=null ? $loggedInData->profile_pix : null;
                    		$resp['userData'] = $loggedInData;
                    		$resp['walletExists'] =isset($loggedInData->walletExists) ? $loggedInData->walletExists : false;
                    		$resp['ecardExists'] = isset($loggedInData->ecardExists) ? $loggedInData->ecardExists : false;
                    		$resp['customerVerificationNo'] = isset($loggedInData->customerVerificationNo) ? $loggedInData->customerVerificationNo : null;
				$resp['cardSupport'] = isset($loggedInData->cardSupport) ? $loggedInData->cardSupport : null;
				$resp['token'] = $token;

		}
		else if(isset($loggedInData->status) && $loggedInData->status!=null && $loggedInData->status == 604) {
					$resp['status'] = 100;
					$resp['isBiometric'] = isset($loggedInData->isBiometric) ? $loggedInData->isBiometric : null;
					$resp['usernameStr'] = "+".join(' ', str_split($loggedInData->username, 3));
					$resp['success'] = true;
					$resp['message'] = 'Logged in successfully';


	                    		$resp['customerId'] = isset($loggedInData->customer_id) ? $loggedInData->customer_id : null;
					$resp['server_token'] = $loggedInData->token;
					$resp['auth_id'] = $loggedInData->id;
					$resp['roleCode'] = $loggedInData->role_code;
					$resp['mobileNumber'] = $loggedInData->mobileno;
					$resp['username'] = $loggedInData->username;
					$resp['accounts'] = isset($loggedInData->accounts) ? json_encode($loggedInData->accounts) : json_encode([]);
					$resp['cards'] = isset($loggedInData->ecards) ? json_encode($loggedInData->ecards) : json_encode([]);
					$resp['status'] = 100;
					$resp['success'] = true;
					$resp['displayName'] = $loggedInData->firstName." ".$loggedInData->lastName;
					$resp['profile_pix'] = isset($loggedInData->profile_pix) && $loggedInData->profile_pix!=null ? $loggedInData->profile_pix : null;
					$resp['userData'] = $loggedInData;
					$resp['walletExists'] =isset($loggedInData->walletExists) ? $loggedInData->walletExists : false;
					$resp['ecardExists'] = isset($loggedInData->ecardExists) ? $loggedInData->ecardExists : false;
					$resp['customerVerificationNo'] = isset($loggedInData->customerVerificationNo) ? $loggedInData->customerVerificationNo : null;
					$resp['cardSupport'] = isset($loggedInData->cardSupport) ? $loggedInData->cardSupport : null;
					$resp['token'] = $token;


		}
		
            $msg = "Dear ".$all['firstName']." ".$data['lastName'].".\nWelcome to Bevura - Your new convenience. Please login using this one-time password:\n";
            $msg = $msg . "OTP: " . $otp;
            $msg = $msg . "\n\nThank You.";
            //send_sms($data['username'], $msg);
            return response()->json(['message' => "Awesome! We've just created a new Bevura profile for you. Please log in to create a wallet and start making use of your wallet", 'success' => true, 'loggedInData'=>$loggedInData, 'verificationNumber' => $authData->verificationNumber], 200);
        }
        else if($authData->status==504) {
            return response()->json(['status'=>$authData->status, 'message' => 'We could not create a new Bevura profile  for you. The mobile number provided has already signed up for the Bevura service. Please log in with the same mobile number to create a wallet', 'success' => false], 200);
        }
        else {
            return response()->json(['message' => 'We could not create a new Bevura profile for you. Please try again', 'success' => false], 200);
        }
	}
	catch(\Exception $e)
	{
		return response()->json(['message' => $e->getLine(), 'success' => false], 200);
	}
    }



	public function getCustomerAcountDetailsByCustomerNumber(Request $request)
    	{
        	$input = $request->all();
		$mobileNumber = $input['customerNumber'];
		$merchantId = $input['merchantCode'];
		$deviceCode = $input['deviceCode'];
		$serviceTypeId = $input['serviceTypeId'];
		$customerNumber = $mobileNumber;
		$hash = $input['hash'];

		$req["merchantCode"] = $merchantId;
		$req["deviceCode"] = $deviceCode;
		$req["serviceTypeId"] = $serviceTypeId;
		$req["customerNumber"] = $customerNumber;
		$req["hash"] = $hash;
		//$req["zicbAuthKey"] = $zicbAuthKey;



		$dataStr  = "";
		foreach($req as $d => $v)
		{
			$dataStr = $dataStr."".$d."=".$v."&";
		}

		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountServicesV2/getAllEWalletAccountBalanceByCustomer';

		$result = sendGetRequest($url, $dataStr);

		if(isset($result->status) && $result->status == 2003)
		{
			$walletBalanceList = $result->balanceList;
			$walletBalanceList = json_decode($walletBalanceList, TRUE);
			return response()->json(['message' => 'Wallet balances pulled', 'walletBalance'=>$walletBalanceList,  'success' => true, 'status'=> 5000], 200);

		}
		else
		{
			return response()->json(['message' => 'Wallet balances not pulled successfully', 'respData'=>$result,  'success' => false, 'status'=> 5001], 200);
		}

	}


    	

	public function previewUploadBulkAgentFunding(Request $request)
	{

	}




	public function uploadBulkAgentFunding(Request $request)
	{

	}



    public function getCustomerStatisticsOld(Request $request)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);
        $all = $request->all();
        $data = [];
        $data['token'] = \Auth::user()->token;


        $result = null;
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/getCustomerDashboardStatistics';
        $authDataStr = sendPostRequest($url, $dataStr);
        $authData = json_decode($authDataStr);
        //dd($authData);
        $accounts = null;
        $cards = null;
        $transactions = null;
        if($authData->status==5000) {
            $accounts = $authData->accounts;
            $cards = $authData->cards;
            $transactions = $authData->transactions;
            return response()->json(['message' => "Customer statistics pulled successfully", 'success' => true, 'status' => 100, 'cards'=> $cards, 'accounts' => $accounts], 200);
        }
        else if($authData->status==-1) {
            return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
        }
    }



    public function getCustomerStatistics(Request $request)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);
        $all = $request->all();
        $data = [];
        $data['token'] = \Auth::user()->token;


        $result = null;
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/getCustomerDashboardStatistics';
        $authDataStr = sendPostRequest($url, $dataStr);
        $authData = json_decode($authDataStr);
        //dd($authData);
        $accounts = null;
        $cards = null;
        $transactions = null;
        if($authData->status==5000) {
            $accounts = $authData->accounts;
            $cards = $authData->cards;
            $transactions = $authData->transactions;
            return response()->json(['message' => "Customer statistics pulled successfully", 'success' => true, 'status' => 100, 'cards'=> $cards, 'accounts' => $accounts], 200);
        }
        else if($authData->status==-1) {
            return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
        }
    }




    public function postValidateNFSAccount(Request $request, $type=NULL)
    {
		try
		{

			$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
			}
			$data['merchantId'] = $all['merchantId'];
			$data['deviceCode'] = $all['deviceCode'];
			//return response()->json(['message' => $all, 'success' => $token, 'status' => -1], 200);
			$url = "";
			if($all['validateType']=='NFS') {
				$data['bankCode'] = $all['bankReceipient'];
				$data['serviceType'] = 'FT_WALLET_TO_BANK_NFS';
				$data['destinationIdentifier'] = $all['accountNumber'];
				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/WalletServicesV2/validateNFSBankAccount';
			}
			if($all['validateType']=='MTN_MONEY') {
				$data['serviceType'] = 'FT_WALLET_TO_MOBILE_MONEY';
				$data['bankCode'] = 'MTN';
				$data['destinationIdentifier'] = $all['accountNumber'];
				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/WalletServicesV2/validateNFSBankAccount';
			}

			if($all['validateType']=='AIRTEL_MONEY') {
				$data['serviceType'] = 'FT_WALLET_TO_MOBILE_MONEY';
				$data['bankCode'] = 'AIRTEL';
				$data['destinationIdentifier'] = $all['accountNumber'];
				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/WalletServicesV2/validateNFSBankAccount';
			}

			if($all['validateType']=='ZAMTEL_MONEY') {
				$data['serviceType'] = 'FT_WALLET_TO_MOBILE_MONEY';
				$data['bankCode'] = 'ZAMTEL';
				$data['destinationIdentifier'] = $all['accountNumber'];
				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/WalletServicesV2/validateNFSBankAccount';
			}


			if($all['validateType']=='TENGA') {
				$data['serviceType'] = 'FT_WALLET_TO_TENGA';
				$data['bankCode'] = 'TENGA';
				$data['destinationIdentifier'] = $all['accountNumber'];
				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/WalletServicesV2/validateNFSBankAccount';
			}


			if($all['validateType']=='KAZANG') {
				$data['serviceType'] = 'FT_WALLET_TO_KAZANG';
				$data['bankCode'] = 'KAZANG';
				$data['destinationIdentifier'] = $all['accountNumber'];
				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/WalletServicesV2/validateNFSBankAccount';
			}
			
			//return response()->json(['dt'=>$data, 'message' => "Validation was not successful", 'success' => true, 'status' => 500], 200);

			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}
			$authDataStr = sendPostRequest($url, $dataStr);
			$authData = json_decode($authDataStr);

			//dd($authData);
				//return response()->json(['message' => "Login to continue", 'success' => true, 'status' => 21, 'd'=>$authData ], 200);

			if($authData->status==5000) {
				$otpRef = $authData->otpRef;
				$otpLength = $authData->otpLength;

				if($all['validateType']=='NFS')
				{
					$customerName = $authData->customerName;
					$transferCharge = $authData->transferCharge;
					return response()->json(['customerName' => $customerName, 'transferCharge' => isset($transferCharge) ? $transferCharge : 0.00, 'otpLength' => $otpLength, 'otpRef' => $otpRef, 'message' => "Customer Validated Successfully", 'success' => true, 'status' => 100], 200);
				}
				if($all['validateType']=='MTN_MONEY')
				{
					$customerName = $authData->customerName;
					$transferCharge = $authData->transferCharge;
					return response()->json(['customerName' => $customerName, 'transferCharge' => isset($transferCharge) ? $transferCharge : 0.00, 'otpLength' => $otpLength, 'otpRef' => $otpRef, 'message' => "Customer Validated Successfully", 'success' => true, 'status' => 100], 200);
				}
				if($all['validateType']=='AIRTEL_MONEY')
				{
					$customerName = $authData->customerName;
					$transferCharge = $authData->transferCharge;
					return response()->json(['customerName' => $customerName, 'transferCharge' => isset($transferCharge) ? $transferCharge : 0.00, 'otpLength' => $otpLength, 'otpRef' => $otpRef, 'message' => "Customer Validated Successfully", 'success' => true, 'status' => 100], 200);
				}
				if($all['validateType']=='ZAMTEL_MONEY')
				{
					$customerName = $authData->customerName;
					$transferCharge = $authData->transferCharge;
					return response()->json(['customerName' => $customerName, 'transferCharge' => isset($transferCharge) ? $transferCharge : 0.00, 'otpLength' => $otpLength, 'otpRef' => $otpRef, 'message' => "Customer Validated Successfully", 'success' => true, 'status' => 100], 200);
				}

				if($all['validateType']=='TENGA')
				{
					$customerName = $authData->customerName;
					$transferCharge = $authData->transferCharge;
					return response()->json(['customerName' => $customerName, 'transferCharge' => isset($transferCharge) ? $transferCharge : 0.00, 'otpLength' => $otpLength, 'otpRef' => $otpRef, 'message' => "Customer Validated Successfully", 'success' => true, 'status' => 100], 200);
				}
			}
			else if($authData->status==-1) {
				return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
			}
			else
			{
				$status = isset($authData->status) ? $authData->status : null;
				$message = isset($authData->message) ? $authData->message : null;
				return response()->json(['message' => $message!=null ? $message : 'We experienced an issue validating the receipient', 'success' => true, 'status' => $status!=null ? $status : 4001], 200);
			}
		}
		catch(\Exception $e)
		{
			return response()->json(['message' => "Validation was not successful", 'success' => true, 'status' => 500, 'e'=>$e->getLine()], 200);
		}
    }




    public function postValidateUtilityMeter(Request $request, $type=NULL)
    {
		try
		{
			$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
			}
			$data['merchantId'] = $all['merchantId'];
			$data['deviceCode'] = $all['deviceCode'];

			if(isset($all['isBorrow']) && $all['isBorrow']!=null)
			{
				$data['isBorrow'] = $all['isBorrow'];
			}
			//return response()->json(['message' => $all, 'success' => $token, 'status' => -1], 200);
			$url = "";
			if($all['utilityBillType']=='AIRTIME') {
				$data['telcoProvider'] = $all['utilityBillAirtimeNetwork'];
				$data['receipient'] = $all['utilityBillAirtimeReceipientNumber'];
				$data['amount'] = $all['utilityBillAmount'];
				if(isset($all['debitSourceType']) && $all['debitSourceType']=="My Wallet")
				{
					$data['debitSourceType'] = "WALLET";
					$data['accountIdentifier'] = explode('|||', $all['utilityBillPayFrom'])[0];
				}
				else
				{
					$data['debitSourceType'] = "CARD";
					$data['cardSerialNo'] = explode('|||', $all['utilityBillPayFrom'])[0];
					$data['cardTrackingNo'] = explode('|||', $all['utilityBillPayFrom'])[1];
				}
				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BillServicesV2/validateAirtime';
			}
			if($all['utilityBillType']=='ELECTRICITY') {
				$data['vendorProvider'] = "ZESCO";
				$data['receipient'] = $all['utilityBillMeterNo'];
				$data['amount'] = $all['utilityBillAmount'];
				if(isset($all['debitSourceType']) && $all['debitSourceType']=="My Wallet")
				{
					$data['debitSourceType'] = "WALLET";
					$data['accountIdentifier'] = explode('|||', $all['utilityBillPayFrom'])[0];
				}
				else
				{
					$data['debitSourceType'] = "CARD";
					$data['cardSerialNo'] = explode('|||', $all['utilityBillPayFrom'])[0];
					$data['cardTrackingNo'] = explode('|||', $all['utilityBillPayFrom'])[1];
				}
				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BillServicesV2/validateElectricity';
			}
			if($all['utilityBillType']=='WATER') {
				$data['vendorProvider'] = "ZESCO";
				$data['receipient'] = $all['utilityBillMeterNo'];
				$data['amount'] = $all['utilityBillAmount'];
				$data['cardSerialNo'] = explode('|||', $all['utilityBillPayFrom'])[0];
				$data['cardTrackingNo'] = explode('|||', $all['utilityBillPayFrom'])[1];
				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BillServicesV2/validateElectricity';
			}
			if($all['utilityBillType']=='DSTV' || $all['utilityBillType']=='GOTV' || $all['utilityBillType']=='TOPSTAR') {
				$data['vendorProvider'] = "Multi-Choice";
				$data['receipient'] = $all['smartCardNumber'];
				$data['amount'] = $all['utilityBillAmount'];
				if(isset($all['debitSourceType']) && $all['debitSourceType']=="My Wallet")
				{
					$data['debitSourceType'] = "WALLET";
					$data['accountIdentifier'] = explode('|||', $all['utilityBillPayFrom'])[0];
				}
				else
				{
					$data['debitSourceType'] = "CARD";
					$data['cardSerialNo'] = explode('|||', $all['utilityBillPayFrom'])[0];
					$data['cardTrackingNo'] = explode('|||', $all['utilityBillPayFrom'])[1];
				}
				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BillServicesV2/validateDSTV';
			}

			

			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}
			$authDataStr = sendPostRequest($url, $dataStr);
			$authData = json_decode($authDataStr);

			//dd($authData);

			if($authData->status==6000061) {
				$validationToken = $authData->validationToken;
				$otpRef = $authData->otpRef;
				$otpLength = $authData->otpLength;

				$repaymentLoanAmount = isset($authData->repaymentAmount) && !is_null($authData->repaymentAmount) ? $authData->repaymentAmount : null;

				$chargesTotal = isset($authData->chargesTotal) && !is_null($authData->chargesTotal) ? $authData->chargesTotal : null;

				if($all['utilityBillType']=='AIRTIME') {
					return response()->json(['validationToken' => $validationToken, 'otpLength' => $otpLength, 'otpRef' => $otpRef, 'repaymentLoanAmount'=>$repaymentLoanAmount!=null ? $repaymentLoanAmount : null, 
						'chargesTotal' => !is_null($chargesTotal) ? $chargesTotal : null, 'message' => "A One-Time Password has been sent to your mobile number. Please provide to confirm your purchase", 'success' => true, 'status' => 100], 200);
				}
				if($all['utilityBillType']=='ELECTRICITY') {
					$customerInfo = $authData->customerInfo;
					return response()->json(['customerInfo' => $customerInfo, 'otpLength' => $otpLength, 'validationToken' => $validationToken, 'otpRef' => $otpRef, 'repaymentLoanAmount'=>$repaymentLoanAmount!=null ? $repaymentLoanAmount : null, 
						'chargesTotal' => !is_null($chargesTotal) ? $chargesTotal : null, 'message' => "A One-Time Password has been sent to your mobile number. Please provide to confirm your purchase", 'success' => true, 'status' => 100], 200);
				}
				if($all['utilityBillType']=='DSTV' || $all['utilityBillType']=='GOTV' || $all['utilityBillType']=='TOPSTAR') {
					$customerInfo = $authData->customerInfo;


					$amountDue = $customerInfo->amount_due;
					$chargesDue = $authData->chargesDue;

					$amountToPay = $all['utilityBillAmount'];

					if($amountToPay>($chargesDue+$amountDue))
					{
						return response()->json(['customerInfo' => $customerInfo, 'otpLength' => $otpLength, 'validationToken' => $validationToken, 'otpRef' => $otpRef, 'repaymentLoanAmount'=>$repaymentLoanAmount!=null ? $repaymentLoanAmount : null, 
							'chargesTotal' => !is_null($chargesTotal) ? $chargesTotal : null, 'message' => "A One-Time Password has been sent to your mobile number. Please provide to confirm your purchase", 'success' => true, 'status' => 100], 200);
					}
					else
					{
						return response()->json(['message' => 'The amount you intend to pay is less than the total amount due and charges. Please pay the total sum of ZMW'.($chargesDue+$amountDue), 'success' => true, 'status' => 4001, 'chargesDue'=>$chargesDue , 'amountDue'=>$amountDue], 200);
					}
				}
			}
			else if($authData->status==-1) {
				return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
			}
			else
			{
				$status = isset($authData->status) ? $authData->status : null;
				$message = isset($authData->message) ? $authData->message : null;
				return response()->json(['message' => $message!=null ? $message : 'We experienced an issue carrying out the validation', 'success' => true, 'status' => $status!=null ? $status : 4001], 200);
			}
		}
		catch(\Exception $e)
		{
			return response()->json(['message' => "Validation was not successful", 'success' => true, 'status' => 500, 'e'=>$e->getMessage()], 200);
		}
    }



    public function postPurchaseAirtime(Request $request, $type=NULL)
    {
        $data = [];
        $all = $request->all();
	 //return response()->json(['message' => 'Airtime purchase is currently not available. Please try again in a few minutes', 'success' => false, 'status' => 400], 200);
		
        $serviceTypeId= "AIRTIME_PURCHASE";
		//return response()->json(['message' => $all], 200);
		if($type!=null && $type==1)
		{
			$token = $request->get('token');
			$data['token'] = $token;
			$all = $request->all();
			//return response()->json(['message' => $all], 200);
		}
		else
		{
			$token = $request->bearerToken();
			$user = JWTAuth::toUser($token);
			$data['token'] = \Auth::user()->token;
		}
        $data['amount'] = $all['utilityBillAmount'];
        $data['otp'] = $all['otpUtilityPay'];
        $data['otpRef'] = $all['otpRef'];

	 if(isset($all['isBorrow']) && $all['isBorrow']!=null)
	 {
        	$data['isBorrow'] = $all['isBorrow'];
	 }
		if(isset($all['debitSourceType']) && $all['debitSourceType']=="My Wallet")
		{
			$data['debitSourceType'] = "WALLET";
			$data['accountIdentifier'] = explode('|||', $all['utilityBillPayFrom'])[0];
		}
		else
		{
			$data['debitSourceType'] = "CARD";
			$data['cardSerialNo'] = explode('|||', $all['utilityBillPayFrom'])[0];
			$data['cardTrackingNo'] = explode('|||', $all['utilityBillPayFrom'])[1];
		}
        $data['channel'] = $all['channel'];
        $data['orderRef'] = isset($all['orderRef']) && $all['orderRef']!=null ? $all['orderRef'] : strtoupper(Str::random(8));
        $data['validationToken'] = $all['utilityBillDivStepTwoValidationToken'];
		$data['serviceTypeId'] = $serviceTypeId;

        if($all['utilityBillType']=='AIRTIME') {
            $data['telcoProvider'] = $all['utilityBillAirtimeNetwork'];
            $data['receipient'] = $all['utilityBillAirtimeReceipientNumber'];
            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BillServicesV2/purchaseAirtime';
        }
        if($all['utilityBillType']=='ELECTRICITY') {
            $data['telcoProvider'] = $all['utilityBillAirtimeNetwork'];
            $data['receipient'] = $all['utilityBillAirtimeReceipientNumber'];
            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BillServicesV2/purchaseElectricity';
        }


        $merchantId = "";
        $deviceCode = "";
		if(isset($all['merchantId']) && $all['merchantId']!=null)
		{
			$data['merchantId'] = $all['merchantId'];
			$merchantId = $all['merchantId'];
		}
		else
		{
			$data['merchantId'] = PROBASEWALLET_MERCHANT_CODE;
			$merchantId = PROBASEWALLET_MERCHANT_CODE;
		}
		
		if(isset($all['deviceCode']) && $all['deviceCode']!=null)
		{
			$data['deviceCode'] = $all['deviceCode'];
			$deviceCode = $all['deviceCode'];
		}
		else
		{
			$data['deviceCode'] = PROBASEWALLET_DEVICE_CODE;
			$deviceCode = PROBASEWALLET_DEVICE_CODE;
		}



        $acquirer = \DB::table('acquirer')->where('isDefault', '=', 1)->first();
        $amount= (number_format($all['utilityBillAmount'], 2, '.', ''));
        $rt = "";
        //$apkey = $acquirer->accessExodus;
	 $apkey = PROBASEKEY;
        $orderId = $data['orderRef'];
        $toHash = "$merchantId$deviceCode$serviceTypeId$orderId$amount$rt$apkey";
        $hash = hash('sha512', $toHash);

        $data['hash'] = $hash;
        $data['hashStr'] = $toHash;

		
        //dd($data);

        $result = null;
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }

        $authDataStr = sendPostRequest($url, $dataStr);
        $authData = json_decode($authDataStr);



        if($authData->status==5000) {
            $message = $authData->message;
            return response()->json(['message' => $message, 'success' => true, 'status' => 100], 200);
        }
        else if($authData->status==-1) {
            return response()->json(['message' => "Login to continue", 'success' => false, 'status' => -1], 200);
        }
        else{
            $message = $authData->message;
            $status = $authData->status;
            return response()->json(['message' => $message, 'success' => false, 'status' => $status], 200);
        }
    }




    public function postPurchaseElectricity(Request $request, $type=NULL)
    {
		$data = [];
        $all = $request->all();
		
		$token ="";
        $serviceTypeId= "ELECTRICITY_PURCHASE";
		//return response()->json(['message' => $all], 200);
		if($type!=null && $type==1)
		{
			$token = $request->get('token');
			
			$all = $request->all();
			//return response()->json(['message' => $all], 200);
		}
		else
		{
			$token = $request->bearerToken();
			$token = \Auth::user()->token;
			$user = JWTAuth::toUser($token);
			
		}
		
        $data['amount'] = $all['utilityBillAmount'];
        $data['otp'] = $all['otpUtilityPay'];
        $data['otpRef'] = $all['otpRef'];

	 if(isset($all['isBorrow']) && $all['isBorrow']!=null)
	 {
        	$data['isBorrow'] = $all['isBorrow'];
	 }

		if(isset($all['debitSourceType']) && $all['debitSourceType']=="My Wallet")
		{
			$data['debitSourceType'] = "WALLET";
			$data['accountIdentifier'] = explode('|||', $all['utilityBillPayFrom'])[0];
		}
		else
		{
			$data['debitSourceType'] = "CARD";
			$data['cardSerialNo'] = explode('|||', $all['utilityBillPayFrom'])[0];
			$data['cardTrackingNo'] = explode('|||', $all['utilityBillPayFrom'])[1];
		}
        $data['channel'] = $all['channel'];
        $data['orderRef'] = strtoupper(Str::random(8));
        $data['validationToken'] = $all['utilityBillDivStepTwoValidationToken'];
		$data['serviceTypeId'] = $serviceTypeId;

        
		$data['vendorProvider'] = isset($all['utilityBillAirtimeNetwork']) && $all['utilityBillAirtimeNetwork']!=null ? $all['utilityBillAirtimeNetwork'] : "ZESCO";
		$data['receipient'] = $all['utilityBillMeterNo'];
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BillServicesV2/purchaseElectricity';
		

        $merchantId = "";
        $deviceCode = "";
		if(isset($all['merchantId']) && $all['merchantId']!=null)
		{
			$data['merchantId'] = $all['merchantId'];
			$merchantId = $all['merchantId'];
		}
		else
		{
			$data['merchantId'] = PROBASEWALLET_MERCHANT_CODE;
			$merchantId = PROBASEWALLET_MERCHANT_CODE;
		}
		//return response()->json(['message' => $data, 'success' => false, 'status' => $status], 200);
		
		if(isset($all['deviceCode']) && $all['deviceCode']!=null)
		{
			$data['deviceCode'] = $all['deviceCode'];
			$deviceCode = $all['deviceCode'];
		}
		else
		{
			$data['deviceCode'] = PROBASEWALLET_DEVICE_CODE;
			$deviceCode = PROBASEWALLET_DEVICE_CODE;
		}


        $acquirer = \DB::table('acquirer')->where('isDefault', '=', 1)->first();
        $amount= (number_format($all['utilityBillAmount'], 2, '.', ''));
        $rt = "";
        //$apkey = $acquirer->accessExodus;
	 $apkey = PROBASEKEY;
        $orderId = $data['orderRef'];
        $toHash = "$merchantId$deviceCode$serviceTypeId$orderId$amount$rt$apkey";
        $hash = hash('sha512', $toHash);

        $data['hash'] = $hash;
        $data['hashStr'] = $toHash;
	 $data['token'] = $token;	
		//KWAD6L3DWL-OTA84AD9-ELECTRICITY_PURCHASE-LM9AB5EM-10.00--WMXGGHowzFdq0fpTg93pYmA5Wjuiq97l
		//DEBIT_WALLET3TQDPMKY10.00WMXGGHowzFdq0fpTg93pYmA5Wjuiq97l


        //dd($data);

        $result = null;
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }
					$ap = new \App\Models\AppError();
					$ap->error_trace = json_encode($data);
					$ap->url = "";
					$ap->error_dump = json_encode($data);
					$ap->user_username = "";
					$ap->save();

        $authDataStr = sendPostRequest($url, $dataStr);
        $authData = json_decode($authDataStr);
		//return response()->json(['b'=>$data], 200);

        //dd($authData);


        if($authData->status==5000) {
            $message = $authData->message;
            return response()->json(['message' => $message, 'success' => true, 'status' => 100], 200);
        }
        else if($authData->status==-1) {
            return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
        }
        else{
            $message = $authData->message;
            $status = $authData->status;
            return response()->json(['df'=>$toHash, 'message' => $message, 'success' => true, 'status' => $status, 'b'=>$data], 200);
        }
    }



    public function postPurchaseDstv(Request $request, $type=NULL)
    {
		try
		{
			$data = [];
			$all = $request->all();
			
			
			$serviceTypeId= "DSTV_PURCHASE";
			//return response()->json(['message' => $all], 200);
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$all = $request->all();
				//return response()->json(['message' => $all], 200);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
			}
			
			$data['amount'] = $all['utilityBillAmount'];
			$data['otp'] = $all['otpUtilityPay'];
			$data['otpRef'] = $all['otpRef'];
			if(isset($all['debitSourceType']) && $all['debitSourceType']=="My Wallet")
			{
				$data['debitSourceType'] = "WALLET";
				$data['accountIdentifier'] = explode('|||', $all['utilityBillPayFrom'])[0];
			}
			else
			{
				$data['debitSourceType'] = "CARD";
				$data['cardSerialNo'] = explode('|||', $all['utilityBillPayFrom'])[0];
				$data['cardTrackingNo'] = explode('|||', $all['utilityBillPayFrom'])[1];
			}
			$data['channel'] = $all['channel'];
			$data['orderRef'] = strtoupper(Str::random(8));
			$data['validationToken'] = $all['utilityBillDivStepTwoValidationToken'];
			$data['serviceTypeId'] = $serviceTypeId;

			
			$data['vendorProvider'] = "DSTV";
			$data['receipient'] = $all['smartCardNumber'];
			$url = '';
			
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BillServicesV2/purchaseDSTV';
			
			$merchantId = "";
			$deviceCode = "";
			if(isset($all['merchantId']) && $all['merchantId']!=null)
			{
				$data['merchantId'] = $all['merchantId'];
				$merchantId = $all['merchantId'];
			}
			else
			{
				$data['merchantId'] = PROBASEWALLET_MERCHANT_CODE;
				$merchantId = PROBASEWALLET_MERCHANT_CODE;
			}
			
			if(isset($all['deviceCode']) && $all['deviceCode']!=null)
			{
				$data['deviceCode'] = $all['deviceCode'];
				$deviceCode = $all['deviceCode'];
			}
			else
			{
				$data['deviceCode'] = PROBASEWALLET_DEVICE_CODE;
				$deviceCode = PROBASEWALLET_DEVICE_CODE;
			}




			$acquirer = \DB::table('acquirer')->where('isDefault', '=', 1)->first();
			$amount= (number_format($all['utilityBillAmount'], 2, '.', ''));
			$rt = "";
	 		$apkey = PROBASEKEY;
			//$apkey = $acquirer->accessExodus;
			$orderId = $data['orderRef'];
			$toHash = "$merchantId$deviceCode$serviceTypeId$orderId$amount$rt$apkey";
			$hash = hash('sha512', $toHash);

			$data['hash'] = $hash;
			$data['hashStr'] = $toHash;


			//return response()->json(['message' => $data], 200);
			//dd($data);

			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}

			$authDataStr = sendPostRequest($url, $dataStr);
			$authData = json_decode($authDataStr);

			//dd($authData);


			if($authData->status==5000) {
				$message = $authData->message;
				return response()->json(['message' => $message, 'success' => true, 'status' => 100], 200);
			}
			else if($authData->status==-1) {
				return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
			}
			else{
				$message = $authData->message;
				$status = $authData->status;
				return response()->json(['message' => $message, 'success' => true, 'status' => $status], 200);
			}
		}
		catch(\Exception $e)
		{
			return response()->json(['message' => 'We experienced issues paying for your DSTV subscription', 'exception'=>$e->getMessage(), 'success' => false, 'status' => -500], 200);
		}
    }



    public function postCreateNewWalletAndCard(Request $request)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);
        $all = $request->all();
        $rules = ['newWalletCardScheme' => 'required', 'newWalletCardType' => 'required', 'newWalletAddressLine1' => 'required', 'newWalletAddressLine2' => 'required',
            'newWalletDistrict' => 'required', 'newWalletMeansOfIdentification' => 'required', 'newWalletIdentityNumber' => 'required', 'newWalletDateOfBirth' => 'required'
        ];

        $messages = [
            'newWalletCardScheme.required' => 'Specify your card type preference',
            'newWalletCardType.required' => 'Please specify if you want a physical card or a virtual wallet',
            'newWalletAddressLine1.required' => 'Specify your address',
            'newWalletAddressLine2.same' => 'Specify the city you live in',
            'newWalletDistrict.required' => 'Please specify the district your city is in',
            'newWalletMeansOfIdentification.required' => 'Please specify your preferred means of identification',
            'newWalletIdentityNumber.required' => 'Please specify your identity number',
            'newWalletDateOfBirth.required' => 'Please specify your date of birth'
        ];



        $validator = \Validator::make($all, $rules, $messages);
        if($validator->fails())
        {
            $errMsg = json_decode($validator->messages(), true);
            $str_error = "";
            $i = 1;
            $array_errors = [];
            foreach($errMsg as $key => $value)
            {
                foreach($value as $val) {
                    array_push($array_errors, $val);
                }
            }
            $errors = join('<br>', $array_errors);
            return response()->json(['message' => $errors, 'success' => false], 200);
        }

        $data = [];

        //dd($this->all_card_schemes);
        $chosenCardScheme = null;
        foreach($this->all_card_schemes as $acs)
        {
            if($acs->id==$all['newWalletCardScheme'])
            {
                $chosenCardScheme = $acs;
            }
        }





        $defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
        $defaultAcquirer = ($defaultAcquirer->toArray());

        $dob = explode('/', $all['newWalletDateOfBirth']);
        $data['firstName'] = \Auth::user()->firstName;
        $data['lastName'] = \Auth::user()->lastName;
        if(\Auth::user()->otherName!=null)
            $data['otherName'] = \Auth::user()->otherName;
        $data['addressLine1'] = $all['newWalletAddressLine1'];
        $data['addressLine2'] = $all['newWalletAddressLine2'];
        $data['contactEmail'] = $all['newWalletEmailAddress'];
        $data['district'] = $all['newWalletDistrict'];
        $data['dateOfBirth'] = $dob[2]."-".$dob[1]."-".$dob[0];
        if($all['newWalletMeansOfIdentification']=='NATIONAL_ID')
            $data['meansOfIdentificationType'] = "NRC";
        if($all['newWalletMeansOfIdentification']=='INTERNATIONAL_PASSPORT')
            $data['meansOfIdentificationType'] = "INTERNATIONAL_PASSPORT";
        if($all['newWalletMeansOfIdentification']=='DRIVERS_LICENSE')
            $data['meansOfIdentificationType'] = "DRIVERS_LICENSE";

        $data['meansOfIdentificationNumber'] = $all['newWalletIdentityNumber'];
        $data['gender'] = $all['newWalletGender'];

	 $idphototaken = null;
	 if(isset($all['identityPhoto']) && $all['identityPhoto']!=null)
	 {
		$base64image = $all['identityPhoto'];
		$image = str_replace('data:image/png;base64,', '', $base64image);
        	$image = str_replace(' ', '+', $image);
        	$imageName = Str::random(10).'.'.'png';
        	\File::put(public_path(). '/files/passports/' . $imageName, base64_decode($image));
		//return response()->json(['data' => ['imageName' => $imageName ], 'public_path()'=>public_path(), 'success'=>true], 200);
		$fileUrl = $imageName;
		$data['newWalletIdPhoto'] = $fileUrl;
	 }

        $data['customerVerificationNumber'] = \Auth::user()->customerVerificationNo;
        $data['token'] = $user->token;
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }

        //dd($data);
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/updateCustomerProfile';
        $authDataStr = sendPostRequest($url, $dataStr);
        //dd($authDataStr);
        $authData = json_decode($authDataStr);
        if($authData->status==114) {

            $data['customerVerificationNo'] = $user->customerVerificationNo;
            $data['currencyCode'] = isset($chosenCardScheme->currency) ? $chosenCardScheme->currency : null;
            $data['accountType'] = 'VIRTUAL';
            $data['openingAccountAmount'] = 0.00;
            $data['acquirerId'] = $defaultAcquirer['id'];
            $data['token'] = $user->token;

            //dd($data);
            $result = null;
            $dataStr = "";
            foreach ($data as $d => $v) {
                $dataStr = $dataStr . "" . $d . "=" . $v . "&";
            }
            $url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/CustomerServicesV2/addAccountToCustomer';
            $authDataStr = sendPostRequest($url, $dataStr);
            //dd($authDataStr);
            $authData = json_decode($authDataStr);
            if ($authData->status == 100)
            {

                $data = [];
                $accountIdentifier = $authData->accountIdentifier;
                $authData = null;

                if($all['newWalletCardType']=='TUTUKA_VIRTUAL_CARD') {

                    $data1 = [];
                    $data1['customerVerificationNo'] = $user->customerVerificationNo;
                    $data1['accountIdentifier'] = $accountIdentifier;
                    $data1['acquirerId'] = $defaultAcquirer['id'];
                    $data1['cardSchemeId'] = $chosenCardScheme->id;
                    $data1['currencyCodeId'] = $chosenCardScheme->currency;
                    $data['token'] = $user->token;
                    $data['encryptedData'] = \Crypt::encryptPseudo(json_encode($data1), true, $defaultAcquirer['accessExodus']);
                    $dataStr = "";
                    foreach ($data as $d => $v) {
                        $dataStr = $dataStr . "" . $d . "=" . $v . "&";
                    }
                    $url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/CustomerServicesV2/createTutukaVirtualCard';
                    $authDataStr = sendPostRequest($url, $dataStr);
                    $authData = json_decode($authDataStr);

                    if ($authData->status == 5000) {
                        return response()->json(['message' => "Awesome! Your wallet and a card has been created for you. You can start transacting with your Bevura virtual wallet", 'success' => true, 'status' => 100], 200);
                    } else if ($authData->status == -1) {
                        return response()->json(['message' => 'Your session has expired. Please try to login to continue what you were doing', 'success' => false, 'status' => -1], 200);
                    } else {
                        return response()->json(['message' => 'Awesome! Your wallet has been created for you. You can add a card to start transacting with your card', 'success' => false], 200);
                    }

                }
                else if($all['newWalletCardType']=='TUTUKA_PHYSICAL_CARD') {
                    $data1 = [];
                    $data1['customerVerificationNo'] = $user->customerVerificationNo;
                    $data1['acquirerId'] = $defaultAcquirer['id'];
                    $data1['cardSchemeId'] = $chosenCardScheme->id;
                    $data1['currencyCodeId'] = $chosenCardScheme->currency;
                    $data['token'] = $user->token;
                    $data['encryptedData'] = \Crypt::encryptPseudo(json_encode($data1), true, $defaultAcquirer['accessExodus']);
                    $dataStr = "";
                    foreach ($data as $d => $v) {
                        $dataStr = $dataStr . "" . $d . "=" . $v . "&";
                    }
                    $url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/CustomerServicesV2/createTutukaVirtualCard';
                    $authDataStr = sendPostRequest($url, $dataStr);
                    $authData = json_decode($authDataStr);

                    if ($authData->status == 5000) {
                        return response()->json(['message' => "Awesome! Your wallet and a card has been created for you. You can start transacting with your Bevura card/wallet", 'success' => true, 'status' => 100], 200);
                    } else if ($authData->status == -1) {
                        return response()->json(['message' => 'Your session has expired. Please try to login to continue what you were doing', 'success' => false, 'status' => -1], 200);
                    } else {
                        return response()->json(['message' => 'Awesome! Your wallet has been created for you. You can add a card to start transacting with your card', 'success' => false], 200);
                    }
                }


            }
            else if ($authData->status == -1) {
                return response()->json(['message' => 'Your session has expired. Please try to login to continue what you were doing', 'success' => false, 'status' => -1], 200);
            } else if ($authData->status == 504) {
                return response()->json(['message' => 'We could not create a new Bevura account for you. Please provide another mobile number as this mobile number may have been taken', 'success' => false], 200);
            } else if ($authData->status == 5007) {
                return response()->json(['message' => 'We could not create a new Bevura account for you. '.$authData->message, 'success' => false], 200);
            } else {
                return response()->json(['message' => 'We could not create a new Bevura account for you. Please try again', 'success' => false], 200);
            }
        }
        else if ($authData->status == -1) {
            return response()->json(['message' => 'Your session has expired. Please try to login to continue what you were doing', 'success' => false, 'status' => -1], 200);
        }
        else
        {
            return response()->json(['message' => 'We could not create a new Bevura account for you. Please try again', 'success' => false], 200);
        }
    }




	public function postAddCardToAccount(Request $request, $type=NULL)
	{
		try
		{
			
			$data = [];
			$all = [];
			
			$token = null;
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$all = $request->all();
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
			}
			//return response()->json($all, 200);

			//return response()->json([$all], 200);
			//$all = $request->all();
			$rules = ['newWalletCardScheme' => 'required', 'newWalletCardType' => 'required', 'accountIdentifier' => 'required', 'nameOnCard' => 'required'];

			$messages = [
				'accountIdentifier.required' => 'Invalid request. Please refresh your page and try again',
				'newWalletCardScheme.required' => 'Specify your card type preference',
				'newWalletCardType.required' => 'Please specify if you want a physical card or a virtual wallet',
				'nameOnCard.required' => 'Please enter the name on the card',
			];
			$acquirerId = $all['acquirerId'];



			$validator = \Validator::make($all, $rules, $messages);
			if($validator->fails())
			{
				$errMsg = json_decode($validator->messages(), true);
				$str_error = "";
				$i = 1;
				$array_errors = [];
				foreach($errMsg as $key => $value)
				{
					foreach($value as $val) {
						array_push($array_errors, $val);
					}
				}
				$errors = join('<br>', $array_errors);
				return response()->json(['message' => $errors, 'success' => false], 200);
			}

			$data = [];
			

			//dd($this->all_card_schemes);
			$chosenCardScheme = null;
			

			//dd($all);

			$defaultAcquirer = \App\Models\Acquirer::where('id', '=', $acquirerId)->first();
			$defaultAcquirer = ($defaultAcquirer->toArray());

			$data = [];
			$accountIdentifier = $all['accountIdentifier'];
			$authData = null;

			//return response()->json($all, 200);

			

			if($all['newWalletCardType']=='TUTUKA_VIRTUAL_CARD') {

				$data1 = [];
				if($type!=null && $type==1)
				{
					$data1['cardType'] = $all['newWalletCardType'];
					$data1['token'] = $all['token'];
					$data1['cardSchemeId'] = $all['cardScheme'];
					$data1['nameOnCard'] = $all['nameOnCard'];					

				}
				else
				{
					foreach($this->all_card_schemes as $acs)
					{
						if($acs->id==$all['newWalletCardScheme'])
						{
							$chosenCardScheme = $acs;
						}
					}
			
					$data1['cardType'] = $all['newWalletCardType'];
					$data1['token'] = $user->token;
					$data1['cardSchemeId'] = $all['newWalletCardScheme'];
					$data1['nameOnCard'] = $all['nameOnCard'];
				}
				$data1['accountIdentifier'] = ($accountIdentifier);

				//$data['encryptedData'] = \Crypt::encryptPseudo(json_encode($data1), true, $defaultAcquirer['accessExodus']);

				//$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        			//$data1['accountIdentifier'] = $encrypterFrom->encrypt($accountIdentifier);



				$dataStr = "";
				foreach ($data1 as $d => $v) {
					$dataStr = $dataStr . "" . $d . "=" . $v . "&";
				}
				//return response()->json($data1 , 200);

				$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountServicesV2/addCardToAccount';
				$authDataStr = sendPostRequest($url, $dataStr);
				$authData = json_decode($authDataStr);


				if ($authData->status == 5000) {
					$cardDetails = $authData->card;
					return response()->json(['cardDetails'=> $cardDetails, 'message' => "Awesome! Your new card has been created for you. You can start transacting with your Bevura Mastercard", 'success' => true, 'status' => 100], 200);
				} else if ($authData->status == -1) {
					return response()->json(['message' => 'Your session has expired. Please try to login to continue what you were doing', 'success' => false, 'status' => -1], 200);
				} else {
					return response()->json(['message' => 'We experienced issues adding a new card for you. Please try again', 'success' => false], 200);
				}

			}
			else if($all['newWalletCardType']=='TUTUKA_PHYSICAL_CARD') {
				$data1 = [];
				if($type!=null && $type==1)
				{
					$data1['customerVerificationNo'] = $all['customerVerificationNo'];
					$data['token'] = $all['token'];
				}
				else
				{
					$data1['customerVerificationNo'] = $user->customerVerificationNo;
					$data['token'] = $user->token;
				}
				$data1['acquirerId'] = $defaultAcquirer['id'];
				$data1['cardSchemeId'] = $chosenCardScheme->id;
				$data1['currencyCodeId'] = $chosenCardScheme->currency;
				$data['encryptedData'] = \Crypt::encryptPseudo(json_encode($data1), true, $defaultAcquirer['accessExodus']);
				$dataStr = "";
				foreach ($data as $d => $v) {
					$dataStr = $dataStr . "" . $d . "=" . $v . "&";
				}
				$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/CustomerServicesV2/createTutukaVirtualCard';
				$authDataStr = sendPostRequest($url, $dataStr);
				$authData = json_decode($authDataStr);

				if ($authData->status == 5000) {
					return response()->json(['message' => "Awesome! Your wallet and a card has been created for you. You can start transacting with your Bevura card/wallet", 'success' => true, 'status' => 100], 200);
				} else if ($authData->status == -1) {
					return response()->json(['message' => 'Your session has expired. Please try to login to continue what you were doing', 'success' => false, 'status' => -1], 200);
				} else {
					return response()->json(['message' => 'Awesome! Your wallet has been created for you. You can add a card to start transacting with your card', 'success' => false], 200);
				}
			}
		}
		catch(\Exception $e)
		{
			
			return response()->json(['message' => $e->getMessage(), 'line'=>$e->getLine()], 200);
		}
	}


    public function postCreateNewCard(Request $request, $type=NULL)
    {
		
		try
		{
			
			$data = [];
			$all = [];
			
			$token = null;
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$all = $request->all();
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
			}
			//return response()->json($all, 200);

			//return response()->json([$all], 200);
			//$all = $request->all();
			$rules = ['newWalletCardScheme' => 'required', 'newWalletCardType' => 'required', 'accountIdentifier' => 'required', 'nameOnCard' => 'required'];

			$messages = [
				'accountIdentifier.required' => 'Invalid request. Please refresh your page and try again',
				'newWalletCardScheme.required' => 'Specify your card type preference',
				'newWalletCardType.required' => 'Please specify if you want a physical card or a virtual wallet',
				'nameOnCard.required' => 'Please specify the name on the card',
			];
			$acquirerId = $all['acquirerId'];




			$nameOnCard = $all['nameOnCard'];
			$nameOnCard = trim($nameOnCard);
			$nameOnCard = explode(' ', $nameOnCard);
			if(sizeof($nameOnCard)==2)
			{
			}
			else
			{
				return response()->json(['message' => 'Please provide only the card holders first and last name', 'success' => false], 200);
			}
			$validator = \Validator::make($all, $rules, $messages);
			if($validator->fails())
			{
				$errMsg = json_decode($validator->messages(), true);
				$str_error = "";
				$i = 1;
				$array_errors = [];
				foreach($errMsg as $key => $value)
				{
					foreach($value as $val) {
						array_push($array_errors, $val);
					}
				}
				$errors = join('<br>', $array_errors);
				return response()->json(['message' => $errors, 'success' => false], 200);
			}

			$data = [];
			

			//dd($this->all_card_schemes);
			$chosenCardScheme = null;
			

			//dd($all);

			$defaultAcquirer = \App\Models\Acquirer::where('id', '=', $acquirerId)->first();
			$defaultAcquirer = ($defaultAcquirer->toArray());

			$data = [];
			$accountIdentifier = $all['accountIdentifier'];
			$authData = null;

			//return response()->json($all, 200);

			

			if($all['newWalletCardType']=='TUTUKA_VIRTUAL_CARD') {

				$data1 = [];
				if($type!=null && $type==1)
				{
					$data1['customerVerificationNo'] = $all['customerVerificationNo'];
					if(isset($all['acquirerId']) && $all['acquirerId']!=null)
					{
						$data1['acquirerId'] = $all['acquirerId'];
					}
					else
					{
						foreach($this->all_card_schemes as $acs)
						{
							if($acs->id==$all['newWalletCardScheme'])
							{
								$chosenCardScheme = $acs;
							}
						}
						$data1['acquirerId'] = intVal($defaultAcquirer['id']);
					}
					$data1['nameOnCard'] = $all['nameOnCard'];
					$data1['cardSchemeId'] = $all['newWalletCardScheme'];
					$data1['currencyCodeId'] = $all['currencyCodeId'];
					$data1['deviceCode'] = $all['deviceCode'];
					$data1['merchantId'] = $all['merchantId'];
					$data['token'] = $all['token'];
					

				}
				else
				{
					foreach($this->all_card_schemes as $acs)
					{
						if($acs->id==$all['newWalletCardScheme'])
						{
							$chosenCardScheme = $acs;
						}
					}
			
					$data1['customerVerificationNo'] = $user->customerVerificationNo;
					$data1['acquirerId'] = intVal($defaultAcquirer['id']);
					$data['token'] = $user->token;
					$data1['cardSchemeId'] =  intVal($chosenCardScheme->id);
					$data1['currencyCodeId'] = $chosenCardScheme->currency;
					$data1['deviceCode'] = $all['deviceCode'];
					$data1['merchantId'] = $all['merchantId'];

				}
				$data1['accountIdentifier'] = $accountIdentifier;
				//$data['encryptedData'] = \Crypt::encryptPseudo(json_encode($data1), true, $defaultAcquirer['accessExodus']);
				//return response()->json($data1, 200);
				$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        			$data['encryptedData'] = $encrypterFrom->encrypt(json_encode($data1));



				$dataStr = "";
				foreach ($data as $d => $v) {
					$dataStr = $dataStr . "" . $d . "=" . $v . "&";
				}
				

				$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/CustomerServicesV2/createTutukaVirtualCard';
				$authDataStr = sendPostRequest($url, $dataStr);
				$authData = json_decode($authDataStr);
				//return response()->json($authData, 200);

				if ($authData->status == 5000) {
					$cardDetails = $authData->card;
					return response()->json(['cardDetails'=> $cardDetails, 'message' => "Awesome! Your new card has been created for you. You can start transacting with your Bevura Mastercard", 'success' => true, 'status' => 100], 200);
				} else if ($authData->status == -1) {
					return response()->json(['message' => 'Your session has expired. Please try to login to continue what you were doing', 'success' => false, 'status' => -1], 200);
				} else {
					return response()->json(['message' => 'We experienced issues adding a new card for you. Please try again', 'success' => false], 200);
				}

			}
			else if($all['newWalletCardType']=='TUTUKA_PHYSICAL_CARD') {
				$data1 = [];
				if($type!=null && $type==1)
				{
					$data1['customerVerificationNo'] = $all['customerVerificationNo'];
					$data['token'] = $all['token'];
				}
				else
				{
					$data1['customerVerificationNo'] = $user->customerVerificationNo;
					$data['token'] = $user->token;
				}
				$data1['acquirerId'] = $defaultAcquirer['id'];
				$data1['cardSchemeId'] = $chosenCardScheme->id;
				$data1['currencyCodeId'] = $chosenCardScheme->currency;
				$data1['nameOnCard'] = $all['nameOnCard'];
				$data['encryptedData'] = \Crypt::encryptPseudo(json_encode($data1), true, $defaultAcquirer['accessExodus']);
				$dataStr = "";
				foreach ($data as $d => $v) {
					$dataStr = $dataStr . "" . $d . "=" . $v . "&";
				}
				$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/CustomerServicesV2/createTutukaVirtualCard';
				$authDataStr = sendPostRequest($url, $dataStr);
				$authData = json_decode($authDataStr);

				if ($authData->status == 5000) {
					return response()->json(['message' => "Awesome! Your wallet and a card has been created for you. You can start transacting with your Bevura card/wallet", 'success' => true, 'status' => 100], 200);
				} else if ($authData->status == -1) {
					return response()->json(['message' => 'Your session has expired. Please try to login to continue what you were doing', 'success' => false, 'status' => -1], 200);
				} else {
					return response()->json(['message' => 'Awesome! Your wallet has been created for you. You can add a card to start transacting with your card', 'success' => false], 200);
				}
			}
		}
		catch(\Exception $e)
		{
			
			return response()->json(['message' => $e->getMessage()], 200);
		}
	}





    public function postValidatePhysicalCard(Request $request, $type=NULL)
    {
		
		try
		{
			
			$data = [];
			$all = [];
			
			$token = null;
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$all = $request->all();
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
			}
			//return response()->json($all, 200);

			//return response()->json([$all], 200);
			//$all = $request->all();
			$rules = ['cardData' => 'required', 'cardHolderText' => 'required', 'merchantCode' => 'required', 'deviceCode' => 'required'];

			$messages = [
				'cardData.required' => 'Invalid card information provided. Please ensure you provide complete card details',
				'cardHolderText.required' => 'Specify the card holders name',
				'merchantCode.required' => 'Invalid request. Vital information missing',
				'deviceCode.required' => 'Invalid request. Vital information missing',
				'appId.required'=> 'Invalid request. Vital information missing'
			];

			$data1['cardData'] = urlencode($all['cardData']);
			$data1['token'] = $all['token'];
			$data1['cardHolderText'] = $all['cardHolderText'];
			$data1['merchantCode'] = $all['merchantCode'];
			$data1['deviceCode'] = $all['deviceCode'];
			$data1['appId'] = $all['appId'];

			$validator = \Validator::make($all, $rules, $messages);
			if($validator->fails())
			{
				$errMsg = json_decode($validator->messages(), true);
				$str_error = "";
				$i = 1;
				$array_errors = [];
				foreach($errMsg as $key => $value)
				{
					foreach($value as $val) {
						array_push($array_errors, $val);
					}
				}
				$errors = join('<br>', $array_errors);
				return response()->json(['message' => $errors, 'success' => false], 200);
			}

			$data = [];
			

			//dd($this->all_card_schemes);
			$chosenCardScheme = null;
			

			//dd($all);

			//$defaultAcquirer = \App\Models\Acquirer::where('id', '=', $acquirerId)->first();
			//$defaultAcquirer = ($defaultAcquirer->toArray());

			$data = [];
			//$accountIdentifier = $all['accountIdentifier'];
			$authData = null;

			//$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        		//$data['encryptedData'] = $encrypterFrom->encrypt(json_encode($data1));
        		//$data['acquirerCode'] = $defaultAcquirer->acquirerCode;
			$dataStr = "";
			foreach ($data1 as $d => $v) {
				$dataStr = $dataStr . "" . $d . "=" . $v . "&";
			}
			//return response()->json($dataStr , 200);

				

			$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/CardServicesV2/validatePhysicalCard';
			$authDataStr = sendPostRequest($url, $dataStr);
			$authData = json_decode($authDataStr);
			//return response()->json($authData, 200);

			if ($authData->status == 5000) {
				$cardDetails = $authData->card;
				return response()->json(['cardDetails'=> $authData, 'message' => "Awesome! Your card has been validated", 'success' => true, 'status' => 100], 200);
			} else if ($authData->status == -1) {
				return response()->json(['message' => 'Your session has expired. Please try to login to continue what you were doing', 'success' => false, 'status' => -1], 200);
			} else {
				return response()->json(['message' => 'We experienced issues validating your card. Please try again', 'success' => false], 200);
			}

		}
		catch(\Exception $e)
		{
			
			return response()->json(['message' => $e->getMessage(), 'line'=>$e->getLine()], 200);
		}
	}


    public function getAccountOverview(Request $request, $accountIdentifier, $merchantCode=NULL, $deviceCode=NULL)
    {
        $token = $request->bearerToken();
		//$token = $request->get('token');
		//return response()->json(['token' => $token, 'success'=>true], 200);
        $user = JWTAuth::toUser($token);

		
		
		//dd(1212);
        //dd($token);
        //dd($user);
        //dd(JWTAuth::parseToken()->authenticate());

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountServicesV2/getAccountBalance';
        $data = 'accountIdentifier='.urlencode($accountIdentifier).'&token='.$token;
        if($merchantCode!=null)
            $data = $data."&merchantCode=".$merchantCode;
        if($deviceCode!=null)
            $data = $data."&deviceCode=".$deviceCode;
        //return response()->json(['url' => $url, 'success'=>true], 200);
        $accountBalance = sendPostRequest($url, $data);


		//return response()->json(['url'=>$url, 'data'=>$data, 'accountBalance' => $accountBalance, 'success'=>true], 200);
		
        if($accountBalance==null)
        {
            $accountBalance = [];
        }
        else
        {
            $accountBalance = json_decode($accountBalance);
        }
        //, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
        return response()->json(['data' => ['accountBalance' => $accountBalance], 'success'=>true], 200);
    }







    public function checkIfMerchantExists(Request $request, $merchantCompanyName, $merchantCompanyId=NULL)
	{
		$token = $request->bearerToken();
		$user = JWTAuth::toUser($token);

		//dd($token);
		//dd($user);
		//dd(JWTAuth::parseToken()->authenticate());

		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/MerchantServicesV2/getMerchantByMerchantName';
		$data = 'merchantCompanyName='.urlencode($merchantCompanyName).'&token='.$user->token;
		if($merchantCompanyId!=null)
			$data = $data."&merchantCompanyId=".$merchantCompanyId;
		//dd($url);
		$server_output = sendGetRequest($url, $data);
		$server_output = json_decode($server_output);
		if($server_output==null)
		{
			return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
		}
		//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
		return response()->json(['data' => $server_output, 'success'=>true], 200);
	}



    public function checkIfBankExists(Request $request, $bankName, $bankId=NULL)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        //dd($token);
        //dd($user);
        //dd(JWTAuth::parseToken()->authenticate());

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BankServicesV2/getBankByBankName';
        $data = 'bankName='.urlencode($bankName).'&token='.$user->token;
        if($bankId!=null)
            $data = $data."&bankId=".$bankId;
        //dd($url);
        $server_output = sendGetRequest($url, $data);
        $server_output = json_decode($server_output);
        if($server_output==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }
        //, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
        return response()->json(['data' => $server_output, 'success'=>true], 200);
    }



    public function checkIfIssuerExists(Request $request, $issuerName, $issuerCode, $issuerId=NULL)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        //dd($token);
        //dd($user);
        //dd(JWTAuth::parseToken()->authenticate());

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BankServicesV2/getIssuerByIssuerNameOrIssuerCode';
        $data = 'issuerName='.urlencode($issuerName).'&issuerCode='.urlencode($issuerCode).'&token='.$user->token;
        if($issuerId!=null)
            $data = $data."&issuerId=".$issuerId;
        //dd($url);
        $server_output = sendGetRequest($url, $data);
        $server_output = json_decode($server_output);
        if($server_output==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }
        //, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
        return response()->json(['data' => $server_output, 'success'=>true], 200);
    }









     	public function postUpdateMerchantBioData(Request $request)
    	{
		$dataForServer = "";
		$data = $request->except('companyLogo', 'companyCertificate');
		//dd($data);
        	$dest = 'merchants/bio-data/';
        	$file_logo = $request->file('companyLogo');

//dd($file_logo);

		if($file_logo!=null)
		{
        		$file_name_logo = Str::random(25) . '.' . $file_logo->getClientOriginalExtension();
			if ($file_logo->move($dest, $file_name_logo)) {
				$dataForServer = $dataForServer.'&companyLogo='.$file_name_logo;
				$dataForServer = $dataForServer.'&companyData='.$file_name_logo;
			}
		}

		$file_cert = $request->file('companyCertificate');
		if($file_cert!=null)
		{
        		$file_name_cert = Str::random(25) . '.' . $file_cert->getClientOriginalExtension();
			if ($file_cert->move($dest, $file_name_cert)) {
				$dataForServer = $dataForServer.'&certificateOfIncorporation='.$file_name_cert;
			}
		}
		
		$token = \Auth::user()->token;
		//$data = $data->except(['companyLogo', 'companyCertificate']);
		

		$dataForServer = $dataForServer.'&addressLine1='.urlencode($data['addressLine1']);
		$dataForServer = $dataForServer.'&addressLine2='.urlencode($data['addressLine2']);
		$dataForServer = $dataForServer.'&altContactEmail='.$data['altEmail'];
		$dataForServer = $dataForServer.'&altContactMobile='.$data['altcountrycode']."".$data['altMobileNo'];
		$dataForServer = $dataForServer.'&companyName='.urlencode($data['companyName']);
		$dataForServer = $dataForServer.'&companyRegNo='.urlencode($data['companyRegNo']);
		$dataForServer = $dataForServer.'&contactEmail='.$data['email'];
		$dataForServer = $dataForServer.'&contactMobile='.$data['countrycode']."".$data['mobileNo'];
		$dataForServer = $dataForServer.'&operationCountry='.urlencode($data['operationCountry']);
		$dataForServer = $dataForServer.'&merchantName='.urlencode($data['companyName']);
		$dataForServer = $dataForServer.'&trafficDeviceCode='.BEVURA_DEVICE_CODE;
		$dataForServer = $dataForServer.'&token='.$token;


		if(isset($data['merchantId']) && $data['merchantId']!=null)
		{
			$dataForServer = $dataForServer.'&merchantId='.$data['merchantId'];
		}
		else
		{
			$contactPerson = explode(' ', $data['contactPerson']);
			$dataForServer = $dataForServer.'&firstName='.urlencode(sizeof($contactPerson)>0 ? $contactPerson[0] : "");
			$dataForServer = $dataForServer.'&lastName='.urlencode(sizeof($contactPerson)==1 ? $contactPerson[1] : (sizeof($contactPerson)>2 ? $contactPerson[2] : ""));
			$dataForServer = $dataForServer.'&otherName='.urlencode(sizeof($contactPerson)>2 ? $contactPerson[1] : "");
		}

		//dd($dataForServer);
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/MerchantServicesV2/createNewMerchant';
		$server_output = sendPostRequest($url, $dataForServer);
		//dd($server_output);
		$server_output = json_decode($server_output);
		if($server_output==null)
		{
			return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
		}
		//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
		return response()->json(['data' => $server_output, 'success'=>true], 200);
        }


	public function postUpdateMerchantBankAndScheme(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $token = \Auth::user()->token;
        $dataForServer = "";
        if(isset($data['merchantScheme']))
            $dataForServer = $dataForServer.'&merchantScheme='.explode('_', $data['merchantScheme'])[1];
        $dataForServer = $dataForServer.'&merchantBank='.explode('_', $data['merchantBank'])[1];
        $dataForServer = $dataForServer.'&bankAccountName='.urlencode($data['bankAccountName']);
        $dataForServer = $dataForServer.'&bankAccountNo='.urlencode($data['bankAccountNo']);
        $dataForServer = $dataForServer.'&bankBranchCode='.urlencode($data['bankBranchCode']);
		$dataForServer = $dataForServer.'&token='.$token;
        $dataForServer = $dataForServer.'&merchantCode='.$data['merchantId'];

        //dd($dataForServer);
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/MerchantServicesV2/updateMerchantScheme';
        $server_output = sendPostRequest($url, $dataForServer);
        //dd($server_output);
        $server_output = json_decode($server_output);
        if ($server_output==null) {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }
        //, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
        return response()->json(['data' => $server_output, 'success'=>true], 200);
    }


	public function postAddNewMerchantDevice(Request $request)
    {
		$data = $request->all();
		//dd($data);
        $token = \Auth::user()->token;
		$dataForServer = "";

		$dataForServer = $dataForServer.'&merchantId='.($data['merchantId']);
        if (isset($data['deviceId']) && $data['deviceId']!=null) {
            $dataForServer = $dataForServer.'&deviceId='.(\Crypt::decrypt($data['deviceId']));
        }
		$dataForServer = $dataForServer.'&deviceType='.urlencode($data['deviceType']);
		$dataForServer = $dataForServer.'&switchToLive=1';
		$dataForServer = $dataForServer.'&token='.($token);

		$dataForServer = $dataForServer.'&notifyMobile='.$data['notifycountrycode']."".$data['notifyMobile'];//$data['notifycountrycode']
		$dataForServer = $dataForServer.'&notifyEmail='.$data['notifyEmail'];
            $dataForServer = $dataForServer.'&acquirerId='.urlencode($data['mpqrAcquirerId']);
//dd($data);
        if ($data['deviceType']=='0') {	//WEB
            $dataForServer = $dataForServer.'&domainUrl='.urlencode($data['domainUrl']);
            $dataForServer = $dataForServer.'&forwardSuccessUrl='.urlencode($data['forwardSuccessUrl']);
            $dataForServer = $dataForServer.'&forwardFailureUrl='.urlencode($data['forwardFailureUrl']);
            $dataForServer = $dataForServer.'&token='.($token);
            $dataForServer = $dataForServer.'&mastercardAccept='.(in_array('MASTERCARD', $data['acceptedCards']) ? 1 : 0);
            $dataForServer = $dataForServer.'&visaAccept='.(in_array('VISA', $data['acceptedCards']) ? 1 : 0);
            $dataForServer = $dataForServer.'&eagleCardAccept='.(in_array('EAGLECARD', $data['acceptedCards']) ? 1 : 0);
            $dataForServer = $dataForServer.'&bankOnlineAccept='.(in_array('ONLINEBANKING', $data['acceptedCards']) ? 1 : 0);
            $dataForServer = $dataForServer.'&mobileMoneyAccept='.(in_array('MOBILEMONEY', $data['acceptedCards']) ? 1 : 0);
            $dataForServer = $dataForServer.'&walletAccept='.(in_array('WALLET', $data['acceptedCards']) ? 1 : 0);
            $dataForServer = $dataForServer.'&zicbAuthKey='.urlencode($data['zicbAuthKey']);
            $dataForServer = $dataForServer.'&zicbServiceKey='.urlencode($data['zicbServiceKey']);
            $dataForServer = $dataForServer.'&zicbAuthKeyUAT='.urlencode($data['zicbAuthKeyuat']);
            $dataForServer = $dataForServer.'&zicbServiceKeyUAT='.urlencode($data['zicbServiceKeyuat']);
            $dataForServer = $dataForServer.'&cybersourceLiveAccessKey='.urlencode($data['cybersourceLiveAccessKey']);
            $dataForServer = $dataForServer.'&cybersourceLiveProfileId='.urlencode($data['cybersourceLiveProfileId']);
            $dataForServer = $dataForServer.'&cybersourceLiveSecretKey='.urlencode($data['cybersourceLiveSecretKey']);
            $dataForServer = $dataForServer.'&cybersourceDemoAccessKey='.urlencode($data['cybersourceDemoAccessKey']);
            $dataForServer = $dataForServer.'&cybersourceDemoProfileId='.urlencode($data['cybersourceDemoProfileId']);
            $dataForServer = $dataForServer.'&cybersourceDemoSecretKey='.urlencode($data['cybersourceDemoSecretKey']);
            $dataForServer = $dataForServer.'&ubaServiceKey='.urlencode($data['ubaServiceKey']);
            $dataForServer = $dataForServer.'&ubaMerchantId='.urlencode($data['ubaMerchantId']);
		}
		else if ($data['deviceType']=='1') {	//POS
            $dataForServer = $dataForServer.'&deviceSerialNo='.urlencode($data['posDeviceSerialNo']);
			$dataForServer = $dataForServer.'&deviceCode='.urlencode($data['posDeviceCode']);
            $dataForServer = $dataForServer.'&forwardSuccessUrl='.urlencode($data['posForwardSuccess']);
		}
		else if ($data['deviceType']=='2') {	//ATM
            $dataForServer = $dataForServer.'&deviceSerialNo='.urlencode($data['atmDeviceSerialNo']);
			$dataForServer = $dataForServer.'&deviceCode='.urlencode($data['atmDeviceCode']);
            $dataForServer = $dataForServer.'&forwardSuccessUrl='.urlencode($data['atmForwardSuccess']);
		}
		else if ($data['deviceType']=='3') {	//MPQR
            $dataForServer = $dataForServer.'&mpqrDeviceCode='.urlencode($data['mpqrDeviceCode']);
            $dataForServer = $dataForServer.'&mpqrDeviceSerialNo='.urlencode($data['mpqrDeviceSerialNo']);
            $dataForServer = $dataForServer.'&mpqrAcquirerId='.($data['mpqrAcquirerId']);
            //$dataForServer = $dataForServer.'&mpqrCardSchemeId='.($data['mpqrCardSchemeId']);
            //$dataForServer = $dataForServer.'&mpqrCurrencyCode='.('ZMW');
            //$dataForServer = $dataForServer.'&mpqrPoolAccountId='.($data['mpqrPoolAccountId']);

		if(isset($data['deviceId']) && $data['deviceId']!=null)
		{

		}
		else
		{
	     		$dataForServer = $dataForServer.'&walletNumber='.($data['walletNumber']);
		}

	     $dataForServer = $dataForServer.'&mpqrDataType='.$data['mpqrDataType'];

        }

	//dd($dataForServer );

        //dd($dataForServer);
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/DeviceServicesV2/createNewMerchantDevice';
        $server_output = sendPostRequest($url, $dataForServer);
        //dd($server_output);
        $server_output = json_decode($server_output);
        if ($server_output==null) {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }
        //, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
        return response()->json(['data' => $server_output, 'success'=>true], 200);
	}



	public function getMerchantList(Request $request)
	{
		$data['status'] = 'ACTIVE';
        $data['token'] = \Auth::user()->token;
        //$result = handleSOAPCalls('listMerchants', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', $data);
        $data = 'token='.\Auth::user()->token;
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/MerchantServicesV2/listMerchantsV2';
        $authDataStr = sendGetRequest($url, $data);
        $authData = json_decode($authDataStr);



        if($authData->status == 210) {
            $list = ($authData->merchantlist);
			$allDt = [];
			for($i1=0; $i1<sizeof($list); $i1++)
			{
				//dd($list[$i1]);
				$merchant = $list[$i1];
				$y =$list[$i1]->id;
				$dt = [];
				$dt['more'] = '';
				$dt['merchantName']= '<strong>'.$list[$i1]->merchantName.'</strong>';
				$dt['merchantCode'] = $list[$i1]->merchantCode;
				$dt['contactEmail'] = $list[$i1]->contactEmail;
				$dt['bankAccount'] = isset($list[$i1]->bankAccount) ? $list[$i1]->bankAccount : "N/A";
				$dt['companyName'] = isset($list[$i1]->companyName) ? $list[$i1]->companyName : "N/A";
				$dt['contactMobile'] = isset($list[$i1]->contactMobile) ? $list[$i1]->contactMobile : "N/A";
				$dt['companyRegNo'] = isset($list[$i1]->companyRegNo) ? $list[$i1]->companyRegNo : "N/A";
				$dt['bankBranchCode'] = isset($list[$i1]->bankBranchCode) ? $list[$i1]->bankBranchCode : "N/A";
				$dt['bank'] = isset($list[$i1]->bankName) ? $list[$i1]->bankName : "N/A";
				$dt['primaryContactPerson'] = $list[$i1]->firstName." ".$list[$i1]->lastName." ".$list[$i1]->otherName;
				$dt['status'] = get_merchant_status_list()[$list[$i1]->status];

				$str = "";



				$str = $str.'<div class="btn-group mr-1 mb-1">';;
					$str = $str.'<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>';
					$str = $str.'<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">';


						//$str = $str.'<a class="dropdown-item" href="/potzr-staff/merchants/view-merchant-account/'.$y.'">View Merchant Account</a>';
						if($merchant->status==1)
						{
							//$str = $str.'<a class="dropdown-item" href="/potzr-staff/merchants/add-merchant-account/'.$y.'">Add Merchant Bank Account</a>';
						}
						//$str = $str.'<a class="dropdown-item" href="/potzr-staff/merchants/merchant-bank-account-listing/'.$y.'">Merchant Bank Accounts</a>';
						$str = $str.'<a class="dropdown-item" href="/potzr-staff/merchants/view-merchant-transactions/'.$y.'">Merchant Transactions</a>';
						if($merchant->status==0)
						{
							$str = $str.'<a class="dropdown-item" href="/potzr-staff/merchants/manage-merchant-status/'.$y.'/disable">Disable Merchant</a>';
							$str = $str.'<a class="dropdown-item" href="/potzr-staff/merchants/update-merchant-account/step-one/'.$y.'">Update Account</a>';
						}
						else if($merchant->status==2)
						{
							$str = $str.'<a class="dropdown-item" href="/potzr-staff/merchants/manage-merchant-status/'.$y.'/enable">Enable Merchant Account</a>';
						}

						$str = $str.'<a class="dropdown-item" href="/potzr-staff/merchants/view-merchant-devices/'.$y.'">View Merchant Devices</a>';

						if($merchant->status==0)
						{
							$str = $str.'<a class="dropdown-item" href="/potzr-staff/merchants/add-merchant-device/'.$y.'">Add New Devices</a>';
						}
						//$str = $str.'<a class="dropdown-item" href="/potzr-staff/vendor-service/vendor-service-listing/'.$y.'">View Vendor Services</a>';
					$str = $str.'</div>';
				$str = $str.'</div>';
				$dt['action'] = $str;
				array_push($allDt, $dt);
			}
			//dd($allDt);
			return response()->json(['status'=>$authData->status, 'data'=>$allDt]);
		}
		else if($authData->status == -1)
		{
			return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
		}
		else
        {
            return response()->json(['status' => 0, 'data' => []]);
        }

	}



	public function pullDeviceList($merchantId=null)
	{

		$data = 'token='.\Auth::user()->token;
		if($merchantId!=null)
			$data = $data.'&merchantId='.(($merchantId));
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/DeviceServicesV2/listDevice';
        $authDataStr = sendGetRequest($url, $data);
		//dd($authDataStr);
		$authData = json_decode($authDataStr);

        if($authData->status == 710)
        {
			$accessingUserRole = getRoleInterpretRoute(\Auth::user()->role_code);
            $user = \Auth::user();
            $all_card_schemes = json_decode($user->all_card_schemes);
            $all_card_type = getAllCardType();

			$list = ($authData->devicelist);
			$allDt = [];
            if ($list!=null) {
                for ($i1=0; $i1<sizeof($list); $i1++) {

                    try {
                        $y =$list[$i1]->id;
                        $merchantId =$list[$i1]->merchantId;
                        $dt = [];
                        $dt['merchantName']= $list[$i1]->merchantName;
                        $dt['acquirerName']= $list[$i1]->acquirerName;
                        $dt['deviceType']= get_device_types()[$list[$i1]->deviceType];
                        $dt['deviceCode']= $list[$i1]->deviceCode;
                        //$dt['success_fail_url_notifications'] = "<b>Success URL:</b> ".$list[$i1]->successUrl."<br><b>Fail URL:</b> ".$list[$i1]->failureUrl."<br><b>Email:</b> ".$list[$i1]->emailNotify."<br><b>SMS:</b> ".$list[$i1]->mobileNotify;
                        $dt['success_fail_url_notifications'] = "<b>Email:</b> ".$list[$i1]->emailNotify."<br><b>SMS:</b> ".$list[$i1]->mobileNotify;
                        $dt['status'] = get_device_status()[$list[$i1]->status];
			   $dt['isLive'] = isset($list[$i1]->switchToLive) && $list[$i1]->switchToLive==true ? 'Live Mode' : 'UAT Mode';

                        $str = "";
                        $str = $str.'<div class="btn-group mr-1 mb-1">';
                        ;
                        $str = $str.'<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>';
                        $str = $str.'<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">';
                        $str = $str.'<a style="cursor: pointer !important" data-target="#device_view_modal" data-toggle="modal" class="dropdown-item" onclick="viewDevice('.$y.', \''.\Session::get('jwt_token').'\')">View Device</a>';

                        if ($dt['status'] == 'INACTIVE') {
                            if (\Auth::user()->role_code == \App\Models\Roles::$MERCHANT) {
                                $str = $str.'<a class="dropdown-item" href="/merchant/devices/update-device-status/enable/'.$y.'">Enable Device</a>';
                            }
                        } elseif ($dt['status'] == 'ACTIVE') {
                            if (\Auth::user()->role_code == \App\Models\Roles::$POTZR_STAFF) {
					if($dt['status'] == 'DISABLED')
                                		$str = $str.'<a class="dropdown-item" href="/potzr-staff/devices/update-device-status/enable/'.$y.'">Enable Device</a>';
					else
                                		$str = $str.'<a class="dropdown-item" href="/potzr-staff/devices/update-device-status/disable/'.$y.'">Disable Device</a>';

                                $str = $str.'<a class="dropdown-item" href="/potzr-staff/merchants/add-merchant-device/'.$merchantId.'/'.$y.'">Update Device</a>';
                            }
                        } elseif ($dt['status'] == 'DISABLED') {
                            if (\Auth::user()->role_code == \App\Models\Roles::$POTZR_STAFF) {
					$str = $str.'<a class="dropdown-item" href="/potzr-staff/devices/update-device-status/enable/'.$y.'">Enable Device</a>';

                            }
                        }
			   if(isset($list[$i1]->switchToLive) && $list[$i1]->switchToLive==true)
			   {
				$str = $str.'<a class="dropdown-item" href="/potzr-staff/devices/update-device-mode/0/'.$y.'">Switch To UAT Mode</a>';
			   }
			   else
			   {
				$str = $str.'<a class="dropdown-item" href="/potzr-staff/devices/update-device-mode/1/'.$y.'">Switch To Live Mode</a>';
			   }

                        if (\Auth::user()->role_code == \App\Models\Roles::$POTZR_STAFF) {
                            $str = $str.'<a class="dropdown-item" href="/potzr-staff/devices/view-device-transactions/'.$y.'">Device Transactions</a>';
                        } elseif (\Auth::user()->role_code == \App\Models\Roles::$MERCHANT) {
                            $str = $str.'<a class="dropdown-item" href="/merchant/devices/view-device-transactions/'.$y.'">Device Transactions</a>';
                        }

                        $str = $str.'</div>';
                        $str = $str.'</div>';
                        $dt['action'] = $str;
                        array_push($allDt, $dt);
					}
					catch(\Exception $e)
					{

					}
                }
            }

			return response()->json(['status'=>110, 'data' => $allDt, 'merchantName'=>isset($authData->merchantName) && $authData->merchantName!=null ? $authData->merchantName : null]);
		}
		else if($authData->status == -1)
		{
			return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
		}
		else
        {
            //return \Redirect::back()->with('error', 'Failed to access customer accounts listing');
			return response()->json(['status' => 0, "message"=> 'Failed to access device listing']);
        }
	}


	public function pullDevice($deviceId=null)
	{

		$data = 'token='.\Auth::user()->token;
		if($deviceId!=null)
			$data = $data.'&deviceId='.(($deviceId));
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/DeviceServicesV2/getADevice';
        $authDataStr = sendGetRequest($url, $data);
		//dd($authDataStr);
		$authData = json_decode($authDataStr);

        if($authData->status == 710)
        {
			$accessingUserRole = getRoleInterpretRoute(\Auth::user()->role_code);
            $user = \Auth::user();

			$device = ($authData->device);
			$device->status = get_device_status()[$device->status];
			$device->deviceType = get_device_types()[$device->deviceType];

			return response()->json(['status'=>110, 'data' => $device]);
		}
		else if($authData->status == -1)
		{
			return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
		}
		else
        {
            //return \Redirect::back()->with('error', 'Failed to access customer accounts listing');
			return response()->json(['status' => 0, "message"=> 'Failed to access device listing']);
        }
	}


	public function pullBankList(Request $request)
	{

		$data = 'token='.\Auth::user()->token;
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BankServicesV2/listBanks';
        $authDataStr = sendGetRequest($url, $data);
		//dd($authDataStr);
		$authData = json_decode($authDataStr);
		$token = $request->bearerToken();


        if($authData->status == 410)
        {
			$accessingUserRole = getRoleInterpretRoute(\Auth::user()->role_code);
            $user = \Auth::user();
		//dd($user);
			$list = ($authData->bankList);
//dd($list);
			$allDt = [];
            if ($list!=null) {
                for ($i1=0; $i1<sizeof($list); $i1++) {

                    $y =$list[$i1]->id;
                    $bankId =$list[$i1]->id;
                    $dt = [];
                    $dt['bankName']= $list[$i1]->bankName;
                    $dt['bankCode']= $list[$i1]->bankCode;
                    $dt['id']= $list[$i1]->id;
			$dt['bicCode']= $list[$i1]->bicCode;
                    $dt['onlineBankingURL']= "".(isset($list[$i1]->onlineBankingURL) && $list[$i1]->onlineBankingURL!=null ? $list[$i1]->onlineBankingURL : "");
                    //."<br><b>Live:</b> ".(isset($list[$i1]->liveEndpoint) && $list[$i1]->liveEndpoint!=null ? $list[$i1]->liveEndpoint : "N/A")."<br><b>Demo:</b> ".(isset($list[$i1]->demoEndpoint) && $list[$i1]->demoEndpoint!=null ? $list[$i1]->demoEndpoint : "N/A");
                    //$dt['status'] = isset($list[$i1]->isLive) && $list[$i1]->isLive!=null && $list[$i1]->isLive==1 ? 'Yes' : 'No';
			$dt['isNFSValidationEnabled']= isset($list[$i1]->isNFSValidationEnabled) && $list[$i1]->isNFSValidationEnabled!=null ? $list[$i1]->isNFSValidationEnabled : null;
			$dt['isRTGSTransferEnabled']= isset($list[$i1]->isRTGSTransferEnabled) && $list[$i1]->isRTGSTransferEnabled!=null ? $list[$i1]->isRTGSTransferEnabled : null;
			$dt['isNFSTransferEnabled']= isset($list[$i1]->isNFSTransferEnabled) && $list[$i1]->isNFSTransferEnabled!=null ? $list[$i1]->isNFSTransferEnabled: null;
			$dt['nfsServiceCode']= isset($list[$i1]->nfsServiceCode) && $list[$i1]->nfsServiceCode!=null ? $list[$i1]->nfsServiceCode : null;

                    $str = "";
                    $str = $str.'<div class="btn-group mr-1 mb-1">';;
						$str = $str.'<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>';
						$str = $str.'<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">';


							//$str = $str.'<a class="dropdown-item" style="cursor: pointer" onclick="javascript:showLastFiveTransactions(\''.$list[$i1]->bankName.'\', \''.$bankId.'\', \''.$token.'\');">Last 5 Transactions</a>';
							$str = $str.'<a class="dropdown-item" href="/potzr-staff/banks/new-bank?bankId='.$bankId.'&bankName='.$list[$i1]->bankName.'&bankCode='.$list[$i1]->bankCode.'&bicCode='.$list[$i1]->bicCode.'&onlineBankingURL='.(isset($list[$i1]->onlineBankingURL) ? $list[$i1]->onlineBankingURL : '').'&countryOfOperation_id='.(isset($list[$i1]->countryOfOperation_id) ? $list[$i1]->countryOfOperation_id : '').'&liveBankCode='.(isset($list[$i1]->liveBankCode) ? $list[$i1]->liveBankCode : '').'">Update Bank</a>';
							//$str = $str.'<a class="dropdown-item" href="/potzr-staff/banks/staff-listing/'.$bankId.'">Bank Staff</a>';
							//$str = $str.'<a class="dropdown-item" href="/potzr-staff/register">New Bank Staff</a>';


                    	$str = $str.'</div>';
                    $str = $str.'</div>';
                    $dt['action'] = $str;
                    array_push($allDt, $dt);
                }
            }

			return response()->json(['status'=>110, 'data' => $allDt]);
		}
		else if($authData->status == -1)
		{
			return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
		}
		else
        {
            //return \Redirect::back()->with('error', 'Failed to access customer accounts listing');
			return response()->json(['status' => 0, "message"=> 'Failed to access bank listing']);
        }
	}




	public function pullBankListForMobile(Request $request)
    	{
        	//$token = $request->bearerToken();
		$token = $request->get('token');
		$data = 'token='.$token;

		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BankServicesV2/listBanks';
        	$authDataStr = sendGetRequest($url, $data);
		$authData = json_decode($authDataStr);


        if($authData->status == 410)
        {
			$list = ($authData->bankList);

			$allDt = [];
            if ($list!=null) {
                for ($i1=0; $i1<sizeof($list); $i1++) {

                    $y =$list[$i1]->id;
                    $bankId =$list[$i1]->id;
                    $dt = [];
			$dt['isNFSValidationEnabled']= isset($list[$i1]->isNFSValidationEnabled) && $list[$i1]->isNFSValidationEnabled!=null ? $list[$i1]->isNFSValidationEnabled : null;
			$dt['isRTGSTransferEnabled']= isset($list[$i1]->isRTGSTransferEnabled) && $list[$i1]->isRTGSTransferEnabled!=null ? $list[$i1]->isRTGSTransferEnabled : null;
			$dt['isNFSTransferEnabled']= isset($list[$i1]->isNFSTransferEnabled) && $list[$i1]->isNFSTransferEnabled!=null ? $list[$i1]->isNFSTransferEnabled: null;
			$dt['nfsServiceCode']= isset($list[$i1]->nfsServiceCode) && $list[$i1]->nfsServiceCode!=null ? $list[$i1]->nfsServiceCode : null;
                    $dt['bankName']= $list[$i1]->bankName;
                    $dt['bankCode']= $list[$i1]->bankCode;
                    $dt['id']= $list[$i1]->id;
                    $dt['isPartnerBank']= isset($list[$i1]->isPartnerBank) && !is_null($list[$i1]->isPartnerBank) ? $list[$i1]->isPartnerBank : 0;
                    $dt['onlineBankingURL']= "".(isset($list[$i1]->onlineBankingURL) ? $list[$i1]->onlineBankingURL : "");
                    //."<br><b>Live:</b> ".(isset($list[$i1]->liveEndpoint) && $list[$i1]->liveEndpoint!=null ? $list[$i1]->liveEndpoint : "N/A")."<br><b>Demo:</b> ".(isset($list[$i1]->demoEndpoint) && $list[$i1]->demoEndpoint!=null ? $list[$i1]->demoEndpoint : "N/A");
                    //$dt['status'] = isset($list[$i1]->isLive) && $list[$i1]->isLive!=null && $list[$i1]->isLive==1 ? 'Yes' : 'No';

                    $str = "";
                    $str = $str.'<div class="btn-group mr-1 mb-1">';;
						$str = $str.'<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>';
						$str = $str.'<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">';

							/*if (isset($list[$i1]->isLive) && $list[$i1]->isLive!=null && $list[$i1]->isLive==1) {
								$str = $str.'<a class="dropdown-item" href="/merchant/devices/update-bank-status/demo/'.$y.'">Switch To Demo Mode</a>';

							} else
							{
								$str = $str.'<a class="dropdown-item" href="/potzr-staff/devices/update-bank-status/live/'.$y.'">Switch To Live Mode</a>';
							}*/
							$str = $str.'<a class="dropdown-item" style="cursor: pointer" onclick="javascript:shownewcard(2, \''.$list[$i1]->bankName.'\', \''.$bankId.'\');loadAId(\''.$bankId.'\', \'last5txns\')">Last 5 Transactions</a>';
							$str = $str.'<a class="dropdown-item" href="/potzr-staff/banks/new-bank/'.$bankId.'">Update Bank</a>';
							$str = $str.'<a class="dropdown-item" href="/potzr-staff/banks/staff-listing/'.$bankId.'">Bank Staff</a>';
							$str = $str.'<a class="dropdown-item" href="/potzr-staff/register">New Bank Staff</a>';


                    	$str = $str.'</div>';
                    $str = $str.'</div>';
                    $dt['action'] = $str;
                    array_push($allDt, $dt);
                }
            }

			return response()->json(['status'=>110, 'data' => $allDt]);
		}
		else if($authData->status == -1)
		{
			return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
		}
		else
        {
            //return \Redirect::back()->with('error', 'Failed to access customer accounts listing');
			return response()->json(['status' => 0, "message"=> 'Failed to access bank listing']);
        }
	}



	
	public function pullBankBranchListForMobile(Request $request)
    	{
        	//$token = $request->bearerToken();
		$token = $request->get('token');
		$bankCode = $request->get('bankCode');
		$data = 'token='.$token."&bankCode=".$bankCode;

		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BankServicesV2/listBankBranches';
        	$authDataStr = sendGetRequest($url, $data);
		$authData = json_decode($authDataStr);


	        if($authData->status == 410)
       	 {
			$list = ($authData->bankBranchList);

			$allDt = [];
       	     	if ($list!=null) {
              	  	for ($i1=0; $i1<sizeof($list); $i1++) 
				{

		                    	$y =$list[$i1]->id;
       		             	$bankId =$list[$i1]->id;
              		      	$dt = [];
                    			$dt['bankName']= $list[$i1]->bankName;
	                    		$dt['bankCode']= $list[$i1]->bankCode;
	                    		$dt['bicCode']= $list[$i1]->bicCode;
	                    		$dt['sortCode']= $list[$i1]->sortCode;
	                    		$dt['branchDetails']= $list[$i1]->branchDetails;
              	      		array_push($allDt, $dt);
                		}
            		}

			return response()->json(['status'=>110, 'data' => $allDt]);
		}
		else if($authData->status == -1)
		{
			return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
		}
		else
       	{
            		//return \Redirect::back()->with('error', 'Failed to access customer accounts listing');
			return response()->json(['status' => 0, "message"=> 'Failed to access bank listing']);
       	}
	}



	public function pullCardSchemeList()
	{

		$data = 'token='.\Auth::user()->token;
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/listCardSchemes';
        $authDataStr = sendGetRequest($url, $data);
		//dd($authDataStr);
		$authData = json_decode($authDataStr);


        if($authData->status == 2100)
        {
			$accessingUserRole = getRoleInterpretRoute(\Auth::user()->role_code);
            $user = \Auth::user();


			$arr_keys = array_keys(getAllCurrency());
			$list = ($authData->cardSchemeList);

			$allDt = [];
            if ($list!=null) {
                for ($i1=0; $i1<sizeof($list); $i1++) {

                    $y =$list[$i1]->id;
                    $dt = [];
                    $dt['schemeName']= $list[$i1]->schemeName;
                    $dt['schemeCode']= $list[$i1]->schemeCode;
                    $dt['overrideFixedFee']= number_format($list[$i1]->overrideFixedFee, 2, '.', ',');
                    $dt['overrideTransactionFee']= number_format($list[$i1]->overrideTransactionFee, 2, '.', ',');
					$dt['minimumBalance']= number_format($list[$i1]->minimumBalance, 2, '.', ',');
					$dt['currency']= isset($list[$i1]->currency) && !is_null($list[$i1]->currency) ? $arr_keys[$list[$i1]->currency] : "ZMW";
                    $str = "";
                    $str = $str.'<div class="btn-group mr-1 mb-1">';;
						$str = $str.'<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>';
						$str = $str.'<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">';

							if(\Auth::user()->role_code == \App\Models\Roles::$POTZR_STAFF)
							{
								$str = $str.'<a href="/potzr-staff/ecards/new-scheme/'.$y.'">Update Scheme</a>';
							}


                    	$str = $str.'</div>';
                    $str = $str.'</div>';
                    $dt['action'] = $str;
                    array_push($allDt, $dt);
                }
            }

			return response()->json(['status'=>110, 'data' => $allDt]);
		}
		else if($authData->status == -1)
		{
			return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
		}
		else
        {
            //return \Redirect::back()->with('error', 'Failed to access customer accounts listing');
			return response()->json(['status' => 0, "message"=> 'Failed to access bank listing']);
        }
	}




	public function pullCustomerCardRequestList(Request $request, $customerId=null)
	{
		$all = $request->all();

        	$customer = null;
		$deviceCode = isset($all['deviceCode']) && $all['deviceCode']!=null ? $all['deviceCode'] : PROBASEWALLET_DEVICE_CODE;
		$data = 'deviceCode='.$deviceCode.'&token='.\Auth::user()->token;
        	if($customerId!=NULL)
			$data = $data.'&customerId='.$customerId;


		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/listCardRequests';
        	$authDataStr = sendGetRequest($url, $data);

		$result = json_decode($authDataStr);
		//dd($result);
        if($result->status == 110)
        {

            $customer = isset($result->customer) ? ($result->customer) : null;
            $accessingUserRole = getRoleInterpretRoute(\Auth::user()->role_code);
            $user = \Auth::user();
			$all_card_status = getAllCardStatus();


			$list = ($result->cardRequests);
			//dd($list);
			$allDt = [];
			for($i1=0; $i1<sizeof($list); $i1++)
			{
				$x=-1;
				try{
					$x =$list[$i1]->id;

					$dt = [];
					//$panLength = strlen($list[$i1]->pan) - 10;
					$replacer = "";
					for($y=0; $y<8; $y++)
					{
						$replacer = $replacer."*";
					}


					$dt['full_name'] = $list[$i1]->firstName." ".$list[$i1]->lastName."<br>".$list[$i1]->contactMobile;
					$dt['nameOnCard'] = $list[$i1]->nameOnCard;
					$dt['accountIdentifier'] = $list[$i1]->accountIdentifier;
					$dt['schemeName'] = $list[$i1]->schemeName;
					$dt['actionedBy'] = isset($list[$i1]->actionedByUserFullName) && $list[$i1]->actionedByUserFullName!=null ? $list[$i1]->actionedByUserFullName : "N/A";
					$dt['status'] = str_replace("_", " ", $all_card_status[$list[$i1]->status]);
					$str = "";
					$str = $str.'<div class="btn-group">';
						//$str = $str.'<button class="btn btn-sm btn-primary" type="button">Action</button>';
						$str = $str.'<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">';
							$str = $str.'<span class="caret"></span>';
							$str = $str.'<span class="sr-only">Toggle Dropdown</span>';
						$str = $str.'</button>';
						$str = $str.'<ul role="menu" class="dropdown-menu">';
							if($dt['status']=="NOT ISSUED")
							{
								$str = $str.'<li style="cursor: pointer !Important"><a onclick="javascript:viewIssuePhysicalCard('.$x.', \''.addslashes($dt['full_name']).'\', \''.addslashes($dt['nameOnCard']).'\', \''.$dt['accountIdentifier'].'\', \''.$dt['schemeName'].'\', \''.(\Session::get('jwt_token')).'\');">Issue Card</a></li>';
								
							}

						$str = $str.'</ul>';
					$str = $str.'</div>';
					$dt['action'] = $str;
					array_push($allDt, $dt);
				}
				catch(\Exception $e)
				{
					dd($e);
				}
			}
			//dd($allDt);
			return response()->json(['status'=>210, 'data' => $allDt]);
            //return view('core.authenticated.account.account_listing', compact('accessingUserRole', 'customer', 'customeracctlist'));

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








	public function pullCustomerCardList(Request $request, $customerId=null)
	{
		$all = $request->all();

        	$customer = null;
		$deviceCode = isset($all['deviceCode']) && $all['deviceCode']!=null ? $all['deviceCode'] : PROBASEWALLET_DEVICE_CODE;
		$data = 'deviceCode='.$deviceCode.'&token='.\Auth::user()->token;
        	if($customerId!=NULL)
			$data = $data.'&customerId='.$customerId;


		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/listCards';
        	$authDataStr = sendGetRequest($url, $data);

		$result = json_decode($authDataStr);

        if($result->status == 110)
        {

            $customer = isset($result->customer) ? ($result->customer) : null;
            $accessingUserRole = getRoleInterpretRoute(\Auth::user()->role_code);
            $user = \Auth::user();
            $all_card_schemes = json_decode($user->all_card_schemes);
			$all_card_type = getAllCardTypes();
			$all_card_status = getAllCardStatus();


			$list = ($result->customercardlist);
			//dd($list);
			$allDt = [];
			for($i1=0; $i1<sizeof($list); $i1++)
			{
				$x=-1;
				try{
					$x =$list[$i1]->id;

					$dt = [];
					//$panLength = strlen($list[$i1]->pan) - 10;
					$replacer = "";
					for($y=0; $y<8; $y++)
					{
						$replacer = $replacer."*";
					}


					//dd($list[$i1]);
					$pan = $list[$i1]->pan1.$replacer.$list[$i1]->pan2;
					$stopFlag = isset($list[$i1]->stopFlag) && $list[$i1]->stopFlag!=null && $list[$i1]->stopFlag=1 ? 'Yes' : 'No';
					$dt['pan'] = $pan;
					$dt['full_name'] = $list[$i1]->firstName." ".$list[$i1]->lastName;
					$dt['accountIdentifier'] = $list[$i1]->accountIdentifier;
					$dt['serialNo'] = $list[$i1]->serialNo;
					$dt['schemeName'] = $list[$i1]->schemeName;
					$dt['cardType'] = $all_card_type[$list[$i1]->cardType];
					$dt['cardBalance'] = $list[$i1]->currencyCode."".number_format($list[$i1]->cardBalance, 2, '.', ',');
					$dt['status'] = $all_card_status[$list[$i1]->status];
					$dt['trackingNo'] = isset($list[$i1]->trackingNumber) ? $list[$i1]->trackingNumber : "";

					$str = "";
					$str = $str.'<div class="btn-group">';
						//$str = $str.'<button class="btn btn-sm btn-primary" type="button">Action</button>';
						$str = $str.'<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">';
							$str = $str.'<span class="caret"></span>';
							$str = $str.'<span class="sr-only">Toggle Dropdown</span>';
						$str = $str.'</button>';
						$str = $str.'<ul role="menu" class="dropdown-menu">';
							if($dt['status']=="ACTIVE")
							{
								if(isset($stopFlag) && $stopFlag!=null && $stopFlag==1)
								{
									$str = $str.'<li><a href="/potzr-staff/ecards/card-status/reactivate/'.$list[$i1]->serialNo.'">Unstop Card</a></li>';
									$str = $str.'<li><a href="/potzr-staff/ecards/card-status/delete/'.$x.'">Delete Card</a></li>';
								}
								else
								{
									$str = $str.'<li><a href="/potzr-staff/ecards/card-status/stop/'.$list[$i1]->serialNo.'">Stop Card'.$dt['cardType'].'</a></li>';
									if($dt['cardType']=="MasterCard - Physical")
									{
										//$str = $str.'<li><a style="cursor: pointer !important" onclick="javascript:viewChangeCardPin('.$x.', \''.$dt['accountIdentifier'].'\', \''.$dt['full_name'].'\', \''.$dt['cardType'].'\', \''.$dt['schemeName'].'\', \''.$dt['serialNo'].'\', \''.$dt['pan'].'\', \''.$dt['trackingNo'].'\');">Change Card Pin</a></li>';
										//$str = $str.'<li><a data-target="#card_transfer_modal" data-toggle="modal" style="cursor: pointer !important" onclick="javascript:transferCard('.$x.', \''.$dt['full_name'].'\', \''.$dt['accountIdentifier'].'\', \''.$dt['cardType'].'\', \''.$dt['serialNo'].'\', \''.$dt['pan'].'\', \''.$dt['schemeName'].'\');">Transfer Card</a></li>';
										$str = $str.'<li><a data-target="#card_transfer_modal" data-toggle="modal" style="cursor: pointer !important" onclick="javascript:updateCardBearer('.$x.', \''.$dt['full_name'].'\', \''.$dt['accountIdentifier'].'\', \''.$dt['cardType'].'\', \''.$dt['serialNo'].'\', \''.$dt['pan'].'\', \''.$dt['schemeName'].'\', \''.$dt['trackingNo'].'\');">Update Card Bearer</a></li>';
									}
									if($dt['cardType']=="MasterCard - Virtual")
									{
										//$str = $str.'<li><a data-target="#changecvv_modal" data-toggle="modal" onclick="javascript:viewChangeCardCVV('.$x.', \''.$dt['accountIdentifier'].'\', \''.$dt['full_name'].'\', \''.$dt['cardType'].'\', \''.$dt['schemeName'].'\', \''.$dt['serialNo'].'\', \''.$dt['pan'].'\');">Change Card CVV</a></li>';
									}
								}
								$str = $str.'<li><a href="/potzr-staff/ecards/card-status/block/'.$list[$i1]->serialNo.'">Block Card</a></li>';
								$str = $str.'<li><a href="/potzr-staff/ecards/card-status/issue/'.$list[$i1]->serialNo.'">Refresh Card</a></li>';
								$str = $str.'<li><a onclick="javascript:viewChangeCardPin('.$x.', \''.$dt['accountIdentifier'].'\', \''.$dt['full_name'].'\', \''.$dt['cardType'].'\', \''.$dt['schemeName'].'\', \''.$dt['serialNo'].'\', \''.$dt['pan'].'\', \''.$dt['trackingNo'].'\');">Change Card Pin</a></li>';
								//$str = $str.'<li><a data-target="#card_balance_modal" data-toggle="modal" style="cursor: pointer" onclick="javascript:viewCardBalance(\''.\Session::get('jwt_token').'\', '.$x.', \''.$dt['accountIdentifier'].'\', \''.$dt['full_name'].'\', \''.$dt['cardType'].'\', \''.$dt['schemeName'].'\', \''.$dt['status'].'\', \''.$dt['serialNo'].'\');">Balance On Card</a></li>';
								if(\Auth::user()->role_code == \App\Models\Roles::$ACCOUNTANT)
								{
									$str = $str.'<li><a href="/accountant/accounts/statement-of-account/card/'.$x.'">Statement of Transactions</a></li>';
								}
								//$str = $str.'<li><a data-target="#card_transfer_modal" data-toggle="modal" style="cursor: pointer" onclick="javascript:viewCardTransfer(\''.\Session::get('jwt_token').'\', '.$x.', \''.$dt['accountIdentifier'].'\', \''.$dt['full_name'].'\', \''.$dt['cardType'].'\', \''.$dt['schemeName'].'\', \''.$dt['status'].'\', \''.$dt['serialNo'].'\');">Transfer Card</a></li>';
							}
							else if($dt['status']=="INACTIVE")
							{
								if($dt['cardType']=="MasterCard - Physical")
								{
									$str = $str.'<li><a href="/potzr-staff/ecards/card-status/activate/'.$dt['serialNo'].'">Activate Card</a></li>';
								}
							}
							else if($dt['status']=="STOPPED")
							{
								$str = $str.'<li><a href="/potzr-staff/ecards/card-status/reactivate/'.$list[$i1]->serialNo.'">Unstop Card</a></li>';
							}

						$str = $str.'</ul>';
					$str = $str.'</div>';
					$dt['action'] = $str;
					array_push($allDt, $dt);
				}
				catch(\Exception $e)
				{
					dd($e);
				}
			}
			//dd($allDt);
			return response()->json(['status'=>210, 'data' => $allDt, 'customer' => $customer]);
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


	public function getApiUser(Request $request) {
    		return $request->user();
	}




	public function postChangeCardPin(Request $request)
	{
		$data = array();
	 	$all = $request->all();
		//return response()->json(['message' => $all, 'success'=>false], 200);

        	$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
        	//dd($defaultAcquirer->toArray());
        	if($defaultAcquirer==null)
        	{
           		return response()->json(['message' => 'Error encountered. ERR00AQ1', 'success'=>false], 200);
        	}

        	$defaultAcquirer = $defaultAcquirer->toArray();

        	//$password = \Crypt::encrypt($all['password']);
        	$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        	$data['acquirerCode'] = $defaultAcquirer['acquirerCode'];
		$data['deviceCode'] = PROBASEWALLET_DEVICE_CODE;

		$encryptedData = [];
		$encryptedData['serialNo'] = $all['serialNo'];
		$encryptedData['trackingNumber'] = $all['trackingNo'];
		$encryptedData['epin'] = rand(1000, 9999)."";
		$encryptedData_ = [];
		array_push($encryptedData_, $encryptedData);
		


		$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        	//$password = \Crypt::encryptPseudo($all['password'], true, );
        	$encryptedData= $encrypterFrom->encrypt(json_encode($encryptedData_)."");
		$data['encryptedData'] = $encryptedData;

		//return response()->json(['message' => $data, 'success'=>false], 200);

		$encryptedData = 
		$data['encryptedData'] = $encryptedData;
        	$data['token'] = \Auth::user()->token;
//return response()->json(['message' => $data, 'success'=>false], 200);

        	$dataStr = "";
        	foreach($data as $d => $v)
        	{
           		$dataStr = $dataStr."".$d."=".$v."&";
        	}


        	$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/changeCustomerCardPin';

        	$authDataStr = sendPostRequest($url, $dataStr);

        	$result = json_decode($authDataStr);
//dd($result);



        	if($result->status == 6000)
        	{
            		$available_balance = ($result->available_balance);
            		$current_balance = ($result->current_balance);
            		$cardCurrency = $result->cardCurrency;
            		$cardBalanceData = ['availableBalance'=>number_format(abs($available_balance), 2, '.', ', '), 'availableBalanceNegative'=>($available_balance<0 ? 1 : 0),
                		'current_balance'=>number_format(abs($current_balance), 2, '.', ', '), 'current_balance_negative'=>($current_balance<0 ? 1 : 0),
                		'cardCurrency'=>$cardCurrency];
        	}
        	else if($result->status == -1)
        	{
            		return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        	}
        	else
        	{
            		return response()->json(['status' => 0, 'data' => []]);
        	}

	 	return response()->json(['status'=>100, 'cardBalance'=>$cardBalanceData]);
	}
    




	public function postUpdateCardBearer(Request $request)
	{
		$data = array();
	 	$all = $request->all();
		//return response()->json(['message' => $all, 'success'=>false], 200);

        	$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
        	//dd($defaultAcquirer->toArray());
        	if($defaultAcquirer==null)
        	{
           		return response()->json(['message' => 'Error encountered. ERR00AQ1', 'success'=>false], 200);
        	}

        	$defaultAcquirer = $defaultAcquirer->toArray();

        	//$password = \Crypt::encrypt($all['password']);
        	$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        	$data['acquirerCode'] = $defaultAcquirer['acquirerCode'];
		$data['deviceCode'] = PROBASEWALLET_DEVICE_CODE;

		$encryptedData = [];
		$encryptedData['serialNo'] = $all['cardSerialNumber'];
		$encryptedData['deviceCode'] = PROBASEWALLET_DEVICE_CODE;
		$encryptedData['trackingNumber'] = $all['cardTrackingNumber'];
		$encryptedData['nameOnCard'] = $all['newNameOnCard'];
		$encryptedData['walletNumber'] = $all['newWalletNumber'];
		//$encryptedData_ = [];
		//array_push($encryptedData_, $encryptedData);
		$encryptedData_ = $encryptedData;
		


		$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        	//$password = \Crypt::encryptPseudo($all['password'], true, );
        	$encryptedData= $encrypterFrom->encrypt(json_encode($encryptedData_)."");
		$data['encryptedData'] = $encryptedData;

		//return response()->json(['message' => $data, 'success'=>false], 200);

		$encryptedData = 
		$data['encryptedData'] = $encryptedData;
        	$data['token'] = \Auth::user()->token;
//return response()->json(['message' => $data, 'success'=>false], 200);

        	$dataStr = "";
        	foreach($data as $d => $v)
        	{
           		$dataStr = $dataStr."".$d."=".$v."&";
        	}


        	$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/updateTutukaCompanionCardBearer';

        	$authDataStr = sendPostRequest($url, $dataStr);

        	$result = json_decode($authDataStr);
//dd($authDataStr);



        	if($result->status == 5000)
        	{
            		return response()->json(['success'=>true, 'status' => 1, 'message'=>'The selected card has been updated to reflect the new bearers details']);
        	}
        	else if($result->status == -1)
        	{
            		return response()->json(['success'=>false, 'status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        	}
        	else
        	{
            		return response()->json(['success'=>false, 'status' => 0, 'data' => []]);
        	}

	 	return response()->json(['status'=>100, 'cardBalance'=>$cardBalanceData]);
	}
    





	public function postGetCardBatches(Request $request)
	{
		$data = array();
	 	$all = $request->all();
		$data['deviceCode'] = PROBASEWALLET_DEVICE_CODE;
        	$data['token'] = \Auth::user()->token;

        	$dataStr = "";
        	foreach($data as $d => $v)
        	{
           		$dataStr = $dataStr."".$d."=".$v."&";
        	}


        	$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/listCardBatches';

        	$authDataStr = sendPostRequest($url, $dataStr);

        	$result = json_decode($authDataStr);
		//dd($result);



        	if($result->status == 5000)
        	{
            		$cardBatches = ['cardBatches'=>$result->cardBins];
        	}
        	else if($result->status == -1)
        	{
            		return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        	}
        	else
        	{
            		return response()->json(['status' => 0, 'data' => []]);
        	}

	 	return response()->json(['status'=>100, 'cardBatches'=>$cardBatches]);
	}
    



	public function postConfirmCardIssue(Request $request)
	{
		$all = $request->all();
		//dd($all);

		$data = array();
	 	$all = $request->all();
		

        	$dataStr = "";
        	foreach($data as $d => $v)
        	{
           		$dataStr = $dataStr."".$d."=".$v."&";
        	}



		$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
	 	$defaultAcquirer = $defaultAcquirer->toArray();
	 	$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        	$requestId = $all['requestId'];
		$cardNumber = $all['cardNumber'];

        	$data['requestId'] = $requestId;
		$data['cardNumber'] = $cardNumber;
		$enc = $encrypterFrom->encrypt(json_encode($data)."");
		$data = [];
		$data['encryptedData'] = $enc;
		$data['deviceCode'] = $all['deviceCode'];
        	$data['token'] = \Auth::user()->token;

        	$dataStr = "";
        	foreach($data as $d => $v)
        	{
            		$dataStr = $dataStr."".$d."=".$v."&";
        	}


        	$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/TutukaServicesV2/linkCustomerToTutukaCompanionPhysicalCard';

        	$authDataStr = sendPostRequest($url, $dataStr);

        	$result = json_decode($authDataStr);
		//dd($result);



        	if($result->status == 5000)
        	{
            		$cardBatches = ['cardBatches'=>$result->cardBins];
        	}
        	else if($result->status == -1)
        	{
            		return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        	}
        	else
        	{
            		return response()->json(['status' => 0, 'data' => []]);
        	}

	 	return response()->json(['status'=>100, 'cardBatches'=>$cardBatches]);

	}




    public function pullBalancesByToken(Request $request)
    {
        $data = array();
	 $all = $request->all();


        $defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
        //dd($defaultAcquirer->toArray());
        if($defaultAcquirer==null)
        {
            return response()->json(['message' => 'Error encountered. ERR00AQ1', 'success'=>false], 200);
        }

        $defaultAcquirer = $defaultAcquirer->toArray();

        //$password = \Crypt::encrypt($all['password']);
        $encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        $data['acquirerCode'] = $defaultAcquirer['acquirerCode'];


	 if(isset($all['bevuraTokenCard']) && $all['bevuraTokenCard']!=null)
	 {
	 	$data['bevuraTokenCard'] = $all['bevuraTokenCard'];
	 }

	 
        $data['hash'] = $all['hash'];
        $data['merchantCode'] = $all['merchantCode'];
        $data['deviceCode'] = $all['deviceCode'];
	 

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/cardBalanceByTokenization';

        $authDataStr = sendPostRequest($url, $dataStr);

        $result = json_decode($authDataStr);




        if($result->status == 6000)
        {
            $available_balance = ($result->available_balance);
            $current_balance = ($result->current_balance);
            $cardCurrency = $result->cardCurrency;
            $cardBalanceData = ['availableBalance'=>number_format(abs($available_balance), 2, '.', ', '), 'availableBalanceNegative'=>($available_balance<0 ? 1 : 0),
                'current_balance'=>number_format(abs($current_balance), 2, '.', ', '), 'current_balance_negative'=>($current_balance<0 ? 1 : 0),
                'cardCurrency'=>$cardCurrency];
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'data' => []]);
        }

	 return response()->json(['status'=>100, 'cardBalance'=>$cardBalanceData]);
    }



    public function pullCardBalance($cardId)
    {
        $user = \Auth::user();

        $data = array();
        $data['cardId'] = $cardId;
        $data['merchantCode'] = PROBASEWALLET_MERCHANT_CODE;
        $data['deviceCode'] = PROBASEWALLET_DEVICE_CODE;
        $data['token'] = \Auth::user()->token;


        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/cardBalance';

        $authDataStr = sendPostRequest($url, $dataStr);

        $result = json_decode($authDataStr);




        if($result->status == 6000)
        {
            $available_balance = ($result->available_balance);
            $current_balance = ($result->current_balance);
            $cardCurrency = $result->cardCurrency;
            $customer = ($result->customer);
            $account = $result->account;
            $card = ($result->card);
            return response()->json(['status'=>100, 'customer' => $customer, 'account'=>$account, 'card'=>$card,
                'availableBalance'=>number_format(abs($available_balance), 2, '.', ', '), 'availableBalanceNegative'=>($available_balance<0 ? 1 : 0),
                'current_balance'=>number_format(abs($current_balance), 2, '.', ', '), 'current_balance_negative'=>($current_balance<0 ? 1 : 0),
                'cardCurrency'=>$cardCurrency]);
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



    public function postNewCustomer(Request $request)
    {
		$data = $request->all();
        $customerImage = null;
        $data['token'] = \Auth::user()->token;
        $data['customerType'] = 'INDIVIDUAL';
        $data['altContactEmail'] = $data['altEmail'];
        $data['altContactMobile'] = $data['altcountrycode']==null && $data['altcountrycode']==null ? null : $data['altMobileNo']."".$data['altMobileNo'];
        $data['contactEmail'] = $data['email'];
        $data['contactMobile'] = $data['countrycode']."".$data['mobileNo'];
        $data['dateOfBirth'] = $data['dateOfBirth'];
        $data['customerImage'] = $customerImage;
		//$data['currencyCode'] = $data['currencyCode'];
		$data['currencyCode'] = "ZMW";
        $data['accountType'] = "VIRTUAL";
		$data['openingAccountAmount'] = null;
        $data['district'] = explode('_', $data['districtOfResidence'])[0];

		if(\Auth::user()->role_type==\App\Models\Roles::$POTZR_STAFF)
			$data['issuerId'] = $data['issuer'];

        //dd($data);
        $dataStr = "";
		foreach($data as $d => $v)
		{
			$dataStr = $dataStr."".$d."=".$v."&";
		}

		//dd($dataStr);
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/createNewCustomerAccount';
		$result = sendPostRequest($url, $dataStr);

		$result = json_decode($result);

		if($result->status == 100)
		{
			return response()->json(['status' => 100, 'message'=>$result->message, 'customerName'=>$result->customerName, 'customerVerificationNumber'=>$result->customerNumber, 'accountNumber'=>$result->accountNo]);
        }
		else if($result->status == -1)
		{
			return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
		}
		else
        {
            //return \Redirect::back()->with('error', 'Failed to access customer accounts listing');
			return response()->json(['status' => 0, "message"=> isset($result->message) ? $result->message : 'Failed to create a wallet for the customer. Please try again']);
        }
    }



	/*public function postAddNewCardToAccount(Request $request)
	{
		$all = $request->all();


        	$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
		$defaultAcquirer = $defaultAcquirer->toArray();
		$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
		$data = [];
	       $data['accountIdentifier'] = $encrypterFrom->encrypt($all['accountIdentifier']);
	       $data['cardType'] = $all['newCardCardType'];
	       $data['cardSchemeId'] = $all['newCardCardScheme'];
	       $data['nameOnCard'] = $all['newCardCardHolder'];
	       $data['token'] = \Auth::user()->token;

		dd($data);


			$dataStr = "";
			foreach($data1 as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}

			//dd($dataStr);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/addAccountToCustomer';
			$result = sendPostRequest($url, $dataStr);
			//dd($result);
			$result = json_decode($result);
			if($result==null)
			{
				return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
			}

			if (handleTokenUpdate($result) == false) {
				return response()->json(['status' => -1, 'message'=>'Login session expired. Please relogin again']);
			}

			if ($result->status == 2102)
				return response()->json(['message' => 'New Card Scheme Created Successfully', 'success'=>true], 200);
			else if($result->status == 2103)
				return response()->json(['message' => 'Card Scheme Updated Successfully', 'success'=>true], 200);
			else
				return response()->json(['message' => 'Card Creation/Update Failed', 'success'=>false], 200);

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
					$msg = "Dear ".$customerName.".\nYour New Account Details are:\n";
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

				\Session::forget('data');
				return \Redirect::to('/bank-teller/customers/customer-listing');
			}else
			{
				return \Redirect::back()->with('error', 'Failed to access customer listing');
			}


	}*/




    public function postAddNewCustomerAccount(Request $request)
    {
		$token = $request->bearerToken();
		$user = JWTAuth::toUser($token);
		$data = $request->all();

		$all_issuers = $this->all_issuers;
        $userIssuer = null;

        if (\Auth::user()->role_code==\App\Models\Roles::$BANK_TELLER) {
            foreach ($all_issuers as $iss) {
                if ($iss->issuerCode==\Auth::user()->staff_bank_code) {
                    $userIssuer = $iss;
                }
            }
		}

        //$data = \Crypt::decrypt($data['data']);
        //dd($data);
        $data1['customerVerificationNo'] = $data['addNewAccountCustomerVerificationNumber'];
        $data1['currencyCode'] = $data['accountCurrency'];
		$data1['accountType'] = $data['accountType'];

		if($data['addNewAccountMerchantCode']!=null && strlen(trim($data['addNewAccountMerchantCode']))>0)
			$data1['merchantCode'] = $data['addNewAccountMerchantCode'];
		if($data['addNewAccountDeviceCode']!=null && strlen(trim($data['addNewAccountDeviceCode']))>0)
			$data1['deviceCode'] = $data['addNewAccountDeviceCode'];

		if(isset($userIssuer) && $userIssuer!=null && $userIssuer->holdFundsYes!=null && $userIssuer->holdFundsYes===false)
			$data1['openingAccountAmount'] = $data['openingBalance'];

        $data1['token'] = \Auth::user()->token;

        //dd($data1);
		//$result = handleSOAPCalls('addAccountToCustomer', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data1);
		$dataStr = "";
		foreach($data1 as $d => $v)
		{
			$dataStr = $dataStr."".$d."=".$v."&";
		}

		//dd($dataStr);
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/addAccountToCustomer';
		$result = sendPostRequest($url, $dataStr);
		//dd($result);
		$result = json_decode($result);
		if($result==null)
		{
			return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
		}

		if (handleTokenUpdate($result) == false) {
			return response()->json(['status' => -1, 'message'=>'Login session expired. Please relogin again']);
		}

		if ($result->status == 2102)
			return response()->json(['message' => 'New Card Scheme Created Successfully', 'success'=>true], 200);
		else if($result->status == 2103)
			return response()->json(['message' => 'Card Scheme Updated Successfully', 'success'=>true], 200);
		else
			return response()->json(['message' => 'Card Creation/Update Failed', 'success'=>false], 200);

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
                $msg = "Dear ".$customerName.".\nYour New Account Details are:\n";
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

            \Session::forget('data');
            return \Redirect::to('/bank-teller/customers/customer-listing');
        }else
        {
            return \Redirect::back()->with('error', 'Failed to access customer listing');
        }

    }






    public function postAddNewCollectionAccount(Request $request)
    {
		$token = $request->bearerToken();
		$user = JWTAuth::toUser($token);
		$data = $request->all();

		$all_issuers = $this->all_issuers;
        $userIssuer = null;

        if (\Auth::user()->role_code==\App\Models\Roles::$BANK_TELLER) {
            foreach ($all_issuers as $iss) {
                if ($iss->issuerCode==\Auth::user()->staff_bank_code) {
                    $userIssuer = $iss;
                }
            }
		}

        //$data = \Crypt::decrypt($data['data']);
        //dd($data);
        $data1['customerId'] = $data['customerId'];
        $data1['currencyCode'] = $data['currencyCode'];
	 $data1['deviceCode'] = $data['deviceCode'];
	 $data1['accountName'] = $data['accountName'];

        $data1['token'] = \Auth::user()->token;

        //dd($data1);
		//$result = handleSOAPCalls('addAccountToCustomer', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data1);
		$dataStr = "";
		foreach($data1 as $d => $v)
		{
			$dataStr = $dataStr."".$d."=".$v."&";
		}

		//dd($dataStr);
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/createNewCollectionsAccount';
		$result = sendPostRequest($url, $dataStr);
		//dd($result);
		$result = json_decode($result);
		if($result==null)
		{
			return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
		}

		if (handleTokenUpdate($result) == false) {
			return response()->json(['status' => -1, 'message'=>'Login session expired. Please relogin again']);
		}

		if ($result->status == 100)
			return response()->json(['message' => 'New Collection Account Created Successfully', 'success'=>true, 'status'=>100], 200);
		else
			return response()->json(['message' => 'New Collection Account Creation/Update Failed', 'success'=>false], 200);

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
                $msg = "Dear ".$customerName.".\nYour New Account Details are:\n";
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

            \Session::forget('data');
            return \Redirect::to('/bank-teller/customers/customer-listing');
        }else
        {
            return \Redirect::back()->with('error', 'Failed to access customer listing');
        }

    }




    public function postAddNewCustomerAccountAndCard(Request $request, $type=NULL)
	{
		try{



			$token = null;
			$data = [];
			$all = [];
			$data1 = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data1['token'] = $token;
				$all = $request->all();
				$data = $all;
				unset($all['token']);
				$data1['merchantCode'] = PROBASEWALLET_MERCHANT_CODE;
				$data1['deviceCode'] = PROBASEWALLET_DEVICE_CODE;


				$rules = ['homeAddress' => 'required', 'city' => 'required', 'district' => 'required', 'identityNumber' => 'required',
       	     			'meansOfIdentification' => 'required', 
					'gender'=>'required', 'dateOfBirth'=>'required'
	        		];

        			$messages = [
            				'homeAddress.required' => 'Specify a valid home address',
       	     			'city.required' => 'Specify the city you live in',
	            			'district.required' => 'Specify the district the city you live in belongs to',
            				'identityNumber.required' => 'Please provide your identification number',
            				'meansOfIdentification.required' => 'Please specify your preferred means of identification',
					'gender.required'=>'Specify your gender',
					'dateOfBirth.required'=>'Specify your date of birth'
	        		];



       	 		$validator = \Validator::make($all, $rules, $messages);
	        		if($validator->fails())
				{
			            $errMsg = json_decode($validator->messages(), true);
			            $str_error = "";
		       	     $i = 1;
				     $array_errors = [];
			            foreach($errMsg as $key => $value)
			            {
		       	         foreach($value as $val) {
			                    array_push($array_errors, $val);
			                }
			            }	
		       	     //$errors = join('<br>', $array_errors);
					$errors = ($array_errors[0]);

			            return response()->json(['message' => $errors, 'all'=>$all, 'respData'=>['status'=>5001], 'success'=>false], 200);
			       }

			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data1['token'] = \Auth::user()->token;
				$all = $request->all();
				$data = $all;
				$all_issuers = $this->all_issuers;
				$userIssuer = null;
				if (\Auth::user()->role_code==\App\Models\Roles::$BANK_TELLER) {
					foreach ($all_issuers as $iss) {
						if ($iss->issuerCode==\Auth::user()->staff_bank_code) {
							$userIssuer = $iss;
							if(isset($userIssuer) && $userIssuer!=null && $userIssuer->holdFundsYes!=null && $userIssuer->holdFundsYes===false)
								$data1['openingAccountAmount'] = $data['openingBalance'];
						}
					}
				}
				
				$data1['currencyCode'] = $data['accountCurrency'];
				$data1['accountType'] = $data['accountType'];
				
			}

			
			

			//$data = \Crypt::decrypt($data['data']);
			//dd($data);
			$idphototaken = null;
	 		if(isset($all['identityPhoto']) && $all['identityPhoto']!=null)
	 		{
				$base64image = $all['identityPhoto'];
				$image = str_replace('data:image/png;base64,', '', $base64image);
        			$image = str_replace(' ', '+', $image);
        			$imageName = Str::random(10).'.'.'png';
	        		\File::put(public_path(). '/files/passports/' . $imageName, base64_decode($image));
				//return response()->json(['data' => ['imageName' => $imageName ], 'public_path()'=>public_path(), 'success'=>true], 200);
				$fileUrl = $imageName;
				$data1['newWalletIdPhoto'] = $fileUrl;
			}

			if(isset($all['identityPhotoBack']) && $all['identityPhotoBack']!=null)
	 		{
				$base64image = $all['identityPhotoBack'];
				$image = str_replace('data:image/png;base64,', '', $base64image);
        			$image = str_replace(' ', '+', $image);
        			$imageName = Str::random(10).'.'.'png';
	        		\File::put(public_path(). '/files/passports/' . $imageName, base64_decode($image));
				//return response()->json(['data' => ['imageName' => $imageName ], 'public_path()'=>public_path(), 'success'=>true], 200);
				$fileUrl = $imageName;
				$data1['newWalletIdPhotoBack'] = $fileUrl;
			}
			//$data1['identityPhoto'] = $data['identityPhoto'];
			$data1['districtId'] = explode("_", $data['district'])[0];
			$data1['addressLine1'] = $data['homeAddress'];
			$data1['addressLine2'] = $data['city'];
			$data1['meansOfIdentificationType'] = $data['meansOfIdentification'];
			$data1['meansOfIdentificationNumber'] = $data['identityNumber'];
			$data1['contactEmail'] = $data['email'];
			$data1['gender'] = $data['gender'];
			$data1['dateOfBirth'] = $data['dateOfBirth'];
			$data1['customerVerificationNo'] = $data['addNewAccountCustomerVerificationNumber'];
			$data1['currencyCode'] = $data['accountCurrency'];
			$data1['accountType'] = $data['accountType'];

			if(isset($data['addNewAccountMerchantCode']) && $data['addNewAccountMerchantCode']!=null && strlen(trim($data['addNewAccountMerchantCode']))>0)
				$data1['merchantCode'] = $data['addNewAccountMerchantCode'];
			if(isset($data['addNewAccountDeviceCode']) && $data['addNewAccountDeviceCode']!=null && strlen(trim($data['addNewAccountDeviceCode']))>0)
				$data1['deviceCode'] = $data['addNewAccountDeviceCode'];
			if(isset($data['isTokenize']) && $data['isTokenize']==1)
				$data1['isTokenize'] = $data['isTokenize'];

			//return response()->json(['message' => $data1, 'respData'=>['status'=>5001], 'success'=>false], 200);

			


			//dd($data);
			//$result = handleSOAPCalls('addAccountToCustomer', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data1);
			$dataStr = "";
			foreach($data1 as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}

			//dd($dataStr);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/addAccountAndDefaultCardToCustomer';
			$result = sendPostRequest($url, $dataStr);
						
			$ap = new \App\Models\AppError();
			$ap->error_trace = $result ;
			$ap->url = "";
			$ap->error_dump = $result ;
			$ap->user_username = "";
			$ap->save();



			if($result==null)
			{
				return response()->json(['message' => 'Error encountered', 'success'=>false, 'data1'=>$data1], 200);
			}
			$result = json_decode($result);

			if($type!=null && $type==1)
			{
				
			}
			else
			{
				if (handleTokenUpdate($result) == false) {
					return response()->json(['status' => -1, 'message'=>'Login session expired. Please relogin again']);
				}
			}
			
			if ($result->status == 5000)
			{
				if($type!=null && $type==1)
				{			
					$ap = new \App\Models\AppError();
					$ap->error_trace = json_encode($result);
					$ap->url = "";
					$ap->error_dump = json_encode($result);
					$ap->user_username = "";
					$ap->save();
				}
				$respData = [];
				if($type!=null && $type==1)
				{
					
					if(isset($result->accounts) && $result->accounts!=null)
					{
						$respData['accounts'] = $result->accounts;
						if(isset($result->ecards) && $result->ecards!=null)
						{
							$respData['ecards'] = $result->ecards;
						}
					}
					$respData['walletExists'] = isset($result->walletExists) ? $result->walletExists : false;
					$respData['ecardExists'] = isset($result->ecardExists) ? $result->ecardExists : false;
					
					
					$accountNo = isset($result->accountIdentifier) ? $result->accountIdentifier : NULL;
					$cardSerialNo = isset($result->cardSerialNo) ? $result->cardSerialNo : NULL;
					$cardSerialNo = isset($result->cardSerialNo) ? $result->cardSerialNo : NULL;
					$nameOnCard = isset($result->nameOnCard) ? $result->nameOnCard : NULL;
					$customerName = isset($result->customername) ? $result->customername : NULL;
					$customerMobileContact = isset($result->mobileContact) ? $result->mobileContact : NULL;
					$ecardPan = isset($result->cardPan) ? \Crypt::decrypt($result->cardPan) : NULL;
					$ecardpin = isset($result->ecardpin) ? \Crypt::decrypt($result->ecardpin) : NULL;
					$ecardexpire = isset($result->ecardexpire) ? \Crypt::decrypt($result->ecardexpire) : NULL;
					$ecardcvv = isset($result->ecardcvv) ? \Crypt::decrypt($result->ecardcvv) : NULL;
					$tokenListing = null;

					if(isset($data['isTokenize']) && $data['isTokenize']==1)
					{
						$tokenListing = isset($result->tokenListing) ? ($result->tokenListing) : NULL;
						//$respData['acctBevuraTokens'] = $acctBevuraTokens;
						$respData['tokenListing'] = $tokenListing;

					}
					
					$respData['cardSerialNo'] = $cardSerialNo;
					$respData['nameOnCard'] = $nameOnCard;
					$respData['customerName'] = $customerName;
					$respData['status'] = 5000;
					
					
					if($accountNo!=NULL) {
						$respData['accountNo'] = $accountNo;
						$msg = "Dear ".$customerName.".\nWe have created a Bevura Wallet. Please proceed to fund the wallet. Your wallet details:\n";
						$msg = $msg . "Wallet No:" . $accountNo;
						$msg = $msg . "\n\nThank You.";
						send_sms($customerMobileContact, $msg);
					}

					if($ecardPan!=NULL)
					{
						$msg = "Dear ".$customerName.".\nWe have created your primary Mastercard Virtual Card. You can fund your card to manage your spending. Your card details:\n";
						$msg = $msg."Card No:".$ecardPan;
						$msg = $msg."Card Pin:".$ecardpin;
						$msg = $msg."Expiry Date:".$ecardexpire;
						$msg = $msg."Card CVV:".$ecardcvv;
						$msg = $msg."\n\nThank You.";
						send_sms($customerMobileContact, $msg);
					}

					/*if($mobacctdetail!=NULL)
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
					}*/
					
					$ap = new \App\Models\AppError();
					$ap->error_trace = json_encode($respData);
					$ap->url = "";
					$ap->error_dump = json_encode($respData);
					$ap->user_username = "";
					$ap->save();
					return response()->json(['message' => 'New Wallet Created Successfully', 'respData'=>$respData, 'success'=>true], 200);//, 'data'=>$result
				}
				else
				{
					
					$sess = (\Session::all());
					$auth_id = \Auth::user()->id;
					$sessDt = \Session::get('login_'.$auth_id);
					$sessDt = json_decode($sessDt);

					$accountNo = isset($result->accountIdentifier) ? $result->accountIdentifier : NULL;
					$cardSerialNo = isset($result->cardSerialNo) ? $result->cardSerialNo : NULL;
					$cardSerialNo = isset($result->cardSerialNo) ? $result->cardSerialNo : NULL;
					$nameOnCard = isset($result->nameOnCard) ? $result->nameOnCard : NULL;
					$customerName = isset($result->customername) ? $result->customername : NULL;
					$customerMobileContact = isset($result->mobileContact) ? $result->mobileContact : NULL;
					
					
					\Session::put('login_'.$auth_id, json_encode($sessDt));
					session()->save();
					
					
					$respData['cardSerialNo'] = $cardSerialNo;
					$respData['nameOnCard'] = $nameOnCard;
					$respData['customerName'] = $customerName;
					$respData['status'] = 5000;
					
					if($accountNo!=NULL) {
						$respData['accountNo'] = $accountNo;
						$msg = "Dear ".$customerName.".\nWe have created a Bevura Wallet. Please proceed to fund the wallet. Your wallet details:\n";
						$msg = $msg . "Wallet No:" . $accountNo;
						$msg = $msg . "\n\nThank You.";
						send_sms($customerMobileContact, $msg);
					}
					//dd([$result, $result->accounts[0], $result->ecards]);
					if(isset($result->accounts) && $result->accounts!=null)
					{
						$sessDt->accounts = $result->accounts;
						if(isset($result->ecards) && $result->ecards!=null && sizeof($result->ecards)>0)
						{
							$sessDt->ecards = $result->ecards;
							if(($result->ecards[0]->serialNo)!=null)
							{
								$ecardPan = $result->ecards[0]->serialNo;
								$ecardPan = substr($ecardPan, strlen($ecardPan)-4);
								if($ecardPan!=NULL)
								{
									$ecardPanEnding = $ecardPan ;
									$msg = "Dear ".$customerName.".\nYour primary Mastercard Virtual Card ending in ".$ecardPanEnding." with has been created for you. You can fund your card to manage your spending. Please log into your Bevura online wallet to access your card\n\nThank You.";
									send_sms($customerMobileContact, $msg);
								}
							}
						}
					}
					

					
					
					
					return response()->json(['message' => 'New Wallet Created Successfully', 'success'=>true, 'respData'=>$respData, 'data'=>$result], 200);
				}
			}
			else if ($result->status == 900){
				return response()->json(['input'=>$all, 'customerVerificationNo'=> $result->customerVerificationNo, 'message' => 'We found an existing wallet matching the details provided. Please enter the OTP sent to the mobile number you provided to your bank', 'success'=>false, 'respData'=>$result], 200);
			}
			else{
				return response()->json(['message' => isset($result->message) ? $result->message : 'Wallet Creation Failed', 'success'=>false, 'data'=>$result], 200);
			}

			//dd($result);

			/*if(handleTokenUpdate($result)==false)
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
				$accountNo = isset($result->accountIdentifier) ? $result->accountIdentifier : NULL;
				$amountDeposited = $result->amountDeposited;
				$ecarddetail = isset($result->ecarddetail) ? json_decode($result->ecarddetail) : NULL;
				$mobacctdetail = isset($result->mobacctdetail) ? json_decode($result->mobacctdetail) : NULL;
				$pswd = isset($result->useracctid) ? $result->useracctid : NULL;
				$walletcode = isset($result->walletcode) ? $result->walletcode : NULL;




				if($accountNo!=NULL) {
					$msg = "Dear ".$customerName.".\nYour New Account Details are:\n";
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

				\Session::forget('data');
				return \Redirect::to('/bank-teller/customers/customer-listing');
			}else
			{
				return \Redirect::back()->with('error', 'Failed to access customer listing');
			}*/
		}
		catch(\Exception $e)
		{
			$ap = new \App\Models\AppError();
			$ap->error_trace = $e->getMessage();
			$ap->url = "";
			$ap->error_dump = $e->getMessage();
			$ap->user_username = "";
			$ap->save();
			return response()->json(['message' => 'Wallet Creation Failed', 'success'=>false, 'data'=>$result, 'er'=>$e->getMessage(), 'l'=>$e->getLine()], 200);
		}

	}



	public function postValidateWalletForCreation(Request $request, $type=NULL)
	{
		$result = null; 
		try{
			$token = null;
			$data = [];
			$all = [];
			$data1 = [];
			if($type!=null && $type==1)
			{
				$all = $request->all();
				$data = $all;
				unset($all['token']);
				$data1['merchantCode'] = PROBASEWALLET_MERCHANT_CODE;
				$data1['deviceCode'] = PROBASEWALLET_DEVICE_CODE;
				$data1['customerVerificationNo'] = $all['customerVerificationNo'];
			}
			else
			{
				$all = $request->all();
				$data = $all;
				$all_issuers = $this->all_issuers;
				$userIssuer = null;
				$data1['merchantCode'] = PROBASEWALLET_MERCHANT_CODE;
				$data1['deviceCode'] = PROBASEWALLET_DEVICE_CODE;
				$data1['customerVerificationNo'] = $all['customerVerificationNo'];
				
			}

			
			

			//$data = \Crypt::decrypt($data['data']);
			//dd($data);

			$data1['otp'] = $data['otp'];
			$data1['mobileNumber'] = $data['mobileNumber'];

			$dataStr = "";
			foreach($data1 as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}

			//dd($dataStr);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/confirmOTPAndCreateWallet';
			$result = sendPostRequest($url, $dataStr);
						

			if($result==null)
			{
				return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
			}
			$result = json_decode($result);
			if($result==null)
			{
				return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
			}
			//$result = json_decode($result);

			if($type!=null && $type==1)
			{
				
			}
			else
			{
				if (handleTokenUpdate($result) == false) {
					return response()->json(['status' => -1, 'message'=>'Login session expired. Please relogin again']);
				}
			}
			
			if ($result->status == 5000)
			{
				if($type!=null && $type==1)
				{			
					$ap = new \App\Models\AppError();
					$ap->error_trace = json_encode($result);
					$ap->url = "";
					$ap->error_dump = json_encode($result);
					$ap->user_username = "";
					$ap->save();
				}
				$respData = [];
				if($type!=null && $type==1)
				{
					
					if(isset($result->accounts) && $result->accounts!=null)
					{
						$respData['accounts'] = $result->accounts;
						if(isset($result->ecards) && $result->ecards!=null)
						{
							$respData['ecards'] = $result->ecards;
						}
					}
					$respData['walletExists'] = isset($result->walletExists) ? $result->walletExists : false;
					$respData['ecardExists'] = isset($result->ecardExists) ? $result->ecardExists : false;
					
					
					$accountNo = isset($result->accountIdentifier) ? $result->accountIdentifier : NULL;
					$cardSerialNo = isset($result->cardSerialNo) ? $result->cardSerialNo : NULL;
					$cardSerialNo = isset($result->cardSerialNo) ? $result->cardSerialNo : NULL;
					$nameOnCard = isset($result->nameOnCard) ? $result->nameOnCard : NULL;
					$customerName = isset($result->customername) ? $result->customername : NULL;
					$customerMobileContact = isset($result->mobileContact) ? $result->mobileContact : NULL;
					$ecardPan = isset($result->cardPan) ? \Crypt::decrypt($result->cardPan) : NULL;
					$ecardpin = isset($result->ecardpin) ? \Crypt::decrypt($result->ecardpin) : NULL;
					$ecardexpire = isset($result->ecardexpire) ? \Crypt::decrypt($result->ecardexpire) : NULL;
					$ecardcvv = isset($result->ecardcvv) ? \Crypt::decrypt($result->ecardcvv) : NULL;
					
					
					$respData['cardSerialNo'] = $cardSerialNo;
					$respData['nameOnCard'] = $nameOnCard;
					$respData['customerName'] = $customerName;
					$respData['status'] = 5000;
					
					
					if($accountNo!=NULL) {
						$respData['accountNo'] = $accountNo;
						$msg = "Dear ".$customerName.".\nWe have created a Bevura Wallet. Please proceed to fund the wallet. Your wallet details:\n";
						$msg = $msg . "Wallet No:" . $accountNo;
						$msg = $msg . "\n\nThank You.";
						send_sms($customerMobileContact, $msg);
					}

					if($ecardPan!=NULL)
					{
						$msg = "Dear ".$customerName.".\nWe have created your primary Mastercard Virtual Card. You can fund your card to manage your spending. Your card details:\n";
						$msg = $msg."Card No:".$ecardPan;
						$msg = $msg."Card Pin:".$ecardpin;
						$msg = $msg."Expiry Date:".$ecardexpire;
						$msg = $msg."Card CVV:".$ecardcvv;
						$msg = $msg."\n\nThank You.";
						send_sms($customerMobileContact, $msg);
					}

					/*if($mobacctdetail!=NULL)
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
					}*/
					
					$ap = new \App\Models\AppError();
					$ap->error_trace = json_encode($respData);
					$ap->url = "";
					$ap->error_dump = json_encode($respData);
					$ap->user_username = "";
					$ap->save();
					return response()->json(['message' => 'New Wallet Created Successfully', 'respData'=>$respData, 'success'=>true], 200);//, 'data'=>$result
				}
			}
			else
			{
				return response()->json(['status' => 5001, 'message'=> isset($result->message) ? $result->message : 'Failed to validate OTP', 'respData'=>$result]);
			}

		}
		catch(\Exception $e)
		{
			$ap = new \App\Models\AppError();
			$ap->error_trace = $e->getMessage();
			$ap->url = "";
			$ap->error_dump = $e->getMessage();
			$ap->user_username = "";
			$ap->save();
			return response()->json(['message' => 'Wallet Validation Failed', 'success'=>false, 'data'=>$result, 'er'=>$result, 'l'=>$e->getLine()], 200);
		}

	}



	public function postNewCardScheme(Request $request)
    {
		$token = $request->bearerToken();
		$user = JWTAuth::toUser($token);
        $input = $request->all();
        $cardSchemeId = NULL;
        $schemeName = ($input['schemeName']);
        $fixedFee = doubleval($input['fixedFee']);
        $transactionFee = doubleval($input['transactionFee']);
        $currency = ($input['currency']);
        $minimumBalance = ($input['minimumBalance']);
        if($request->has('cardSchemeId'))
            $cardSchemeId = $input['cardSchemeId'];


        try {
            $data = array();
            $data['token'] = $user->token;
            $data['schemeName'] = $schemeName;
            $data['overrideFixedFee'] = $fixedFee;
            $data['overrideTransactionFee'] = $transactionFee;
			$data['currency'] = $currency;
			$data['minimumBalance'] = $minimumBalance;
			$data['cardSchemeId'] = $cardSchemeId;


			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}


			//dd($dataStr);

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/createUpdateScheme';
			$result = sendPostRequest($url, $dataStr);
			//dd($server_output);
			$result = json_decode($result);
			if($result==null)
			{
				return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
			}

            if (handleTokenUpdate($result) == false) {
				return response()->json(['status' => -1, 'message'=>'Login session expired. Please relogin again']);
            }

            if ($result->status == 2102)
                return response()->json(['message' => 'New Card Scheme Created Successfully', 'success'=>true], 200);
            else if($result->status == 2103)
                return response()->json(['message' => 'Card Scheme Updated Successfully', 'success'=>true], 200);
            else
				return response()->json(['message' => 'Card Creation/Update Failed', 'success'=>false], 200);


			/*if ($result->status == 2102)
                return \Redirect::to('/potzr-staff/ecards/card-scheme-listing')->with('message', 'New Card Scheme Created Successfully');
            if($result->status == 2103)
                return \Redirect::to('/potzr-staff/ecards/card-scheme-listing')->with('message', 'Card Scheme Updated Successfully');
            else
				return \Redirect::back()->with('error', isset($result->message) ? $result->message : 'Card Creation/Update Failed');*/




        }catch(Exception $e)
        {
			dd($e);
			return response()->json(['message' => 'Card Creation/Update Failed', 'success'=>false], 200);
        }

	}










	public function pullCorporateCustomerAccountList(Request $request, $customerId=NULL)
	{
		$token = $request->bearerToken();
		$user = JWTAuth::toUser($token);

		$data = array();
        $data['token'] = $user->token;
	 $data['customerType'] = 'CORPORATE';
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/listCustomerAccountsByType';
        if($user->role_code==\App\Models\Roles::$CUSTOMER)
        {
            $data['userId'] = (intval(\Auth::user()->id));
            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/listCustomerAccountsByUserId';
        }
        else {
            if ($customerId != NULL)
                $data['customerId'] = (intval($customerId));
        }


		$dataStr = "";
		foreach($data as $d => $v)
		{
			$dataStr = $dataStr."".$d."=".$v."&";
		}

		//$result = handleSOAPCalls('listCustomerAccounts', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data);

		$result = sendGetRequest($url, $dataStr);
		$result = json_decode($result);
		//dd($result);
		//dd($result->customeracctlist[0]);

		if($result==null)
		{
			return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
		}

        if($result->status == 110)
        {

            $customer = isset($result->customer) ? ($result->customer) : null;
            $accessingUserRole = getRoleInterpretRoute(\Auth::user()->role_code);
            $user = \Auth::user();


			$list = ($result->customeracctlist);
			//dd($list[sizeof($list)-1]);
			$allDt = [];
			for($i1=0; $i1<sizeof($list); $i1++)
			{
				//dd($list[$i1]);
				$y =$list[$i1]->id;
				$dt = [];
				$dt['id']= $list[$i1]->id;
				$dt['customerName']= isset($list[$i1]->firstName) && isset($list[$i1]->lastName) ? $list[$i1]->firstName.' '.$list[$i1]->lastName : 'N/P';
				$dt['accountIdentifier']= $list[$i1]->accountIdentifier;
				$dt['accountType'] = array_keys(getAllAccountType())[$list[$i1]->accountType];
				$dt['bankName'] = $list[$i1]->bankName;
				$dt['accountBalance'] = isset($list[$i1]->accountBalance) ? (number_format($list[$i1]->accountBalance, 2, '. ', ',')) : (number_format(0, 2, '. ', ','));
				$dt['currency'] = array_keys(getAllCurrency())[$list[$i1]->probasePayCurrency];
				$dt['status'] = get_account_status()[$list[$i1]->status];

				$str = "";
				$str = $str.'<div class="btn-group" id="btngroup'.$dt['id'].'">';
					//$str = $str.'<button class="btn btn-sm btn-primary" type="button">Action</button>';
					$str = $str.'<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">';
						$str = $str.'<span class="caret"></span>';
						$str = $str.'<span class="sr-only">Toggle Dropdown</span>';
					$str = $str.'</button>';
					$str = $str.'<ul role="menu" class="dropdown-menu">';
					if(\Auth::user()->role_code == \App\Models\Roles::$ACCOUNTANT)
					{
						$str = $str.'<li><a href="/accountant/accounts/statement-of-account/wallet/'.$y.'">View Wallet Statement</a></li>';
					}
					else
					{
						//$str = $str.'<li id="addCardWalletLink'.$y.'"><a style="cursor: pointer" data-target="#new_card_modal" data-toggle="modal" class="" onclick="javascript:addNewCard('.$list[$i1]->id.', \''.$list[$i1]->accountIdentifier.'\', \''.($list[$i1]->lastName.' '.$list[$i1]->firstName.(isset($list[$i1]->otherName) && $list[$i1]->otherName!=null ? ' '.$list[$i1]->otherName : '')).'\', \''.$list[$i1]->verificationNumber.'\');">Add Card To Wallet</a></li>';
						$str = $str.'<li><a style="cursor: pointer" data-target="#account_cards_modal" data-toggle="modal" class="" onclick="javascript:viewAccountCards(\''.\Session::get('jwt_token').'\', '.$list[$i1]->id.', \''.$list[$i1]->accountIdentifier.'\', \''.($list[$i1]->lastName.' '.$list[$i1]->firstName.(isset($list[$i1]->otherName) && $list[$i1]->otherName!=null ? ' '.$list[$i1]->otherName : '')).'\', \''.$list[$i1]->verificationNumber.'\');">Wallet Cards</a></li>';
						if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
						{
                            $str = $str.'<li id="fundWalletLink'.$y.'"><a style="cursor: pointer !important" data-target="#fund_account_modal" data-toggle="modal" onclick="fundAccount(\''.$dt['accountIdentifier'].'\', \''.$dt['accountIdentifier'].'<br>'.$dt['bankName'].'\', '.$y.', \''.\Session::get('jwt_token').'\');loadAId('.$y.', \'fundAccount\')">Fund Wallet</a></li>';
							//$str = $str.'<li><a style="cursor: hand" data-target="#new_card_modal" data-toggle="modal" onclick="javascript:loadAddNewCardView(\''.$dt['accountIdentifier'].'\', \''.$list[$i1]->firstName.'\', \''.$list[$i1]->lastName.'\', \''.$list[$i1]->verificationNumber.'\');">Add New Credit/Debit Card</a></li>';
						}
						$str = $str.'<li><a  style="cursor: pointer" onclick="javascript:shownewcard(2, \''.$dt['accountIdentifier'].' - '.$dt['bankName'].'\', '.$y.');loadAId('.$y.', \'last5txns\')">Last 5 Transactions</a></li>';
						if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
						{
							if(get_account_status()[$list[$i1]->status]=='ACTIVE')
							{
								$str = $str.'<li id="deactivateWalletLink'.$y.'"><a onclick="updateAccountStatus(0, '.$y.', \''.\Session::get('jwt_token').'\')" style="cursor: pointer !important;">Deactivate EWallet</a></li>';
							}
							else
							{
								$str = $str.'<li id="deactivateWalletLink'.$y.'"><a onclick="updateAccountStatus(1, '.$y.', \''.\Session::get('jwt_token').'\')" style="cursor: pointer !important;">Activate EWallet</a></li>';
							}
						}

						if(isset($value->customer->customerType) && $value->customer->customerType!=NULL && $value->customer->customerType=="CORPORATE")
						{
							$str = $str.'<li><a href="/bank-teller/accounts/list-corporate-sub-accounts/'.$y.'">View Corporate Customers </a></li>';
							$str = $str.'<li><a href="/bank-teller/accounts/download-batch-accounts-template/'.$y.'">Batch Sub-Account Template</a></li>';
							$str = $str.'<li><a href="/bank-teller/accounts/upload-batch-accounts-template/'.$y.'">Upload Sub-Account Template</a></li>';


						}
					}
					$str = $str.'</ul>';
				$str = $str.'</div>';
				$dt['action'] = $str;
				array_push($allDt, $dt);
			}
//dd($result);
            if(isset($result->customer))
			    return response()->json(['status'=>110, 'data' => $allDt, 'customer'=>$result->customer]);
            else
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



    public function pullCustomerAccountByUserId(Request $request, $customerId=NULL)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        $data = array();
        $data['token'] = $user->token;
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/listCustomerAccounts';
        if($user->role_code==\App\Models\Roles::$CUSTOMER)
        {
            $data['userId'] = (intval(\Auth::user()->id));
            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/listCustomerAccountsByUserId';
        }


        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }

        //$result = handleSOAPCalls('listCustomerAccounts', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data);

        $result = sendGetRequest($url, $dataStr);
        $result = json_decode($result);
        //dd($data);
        //dd($result->customeracctlist[0]);

        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }

        if($result->status == 110)
        {

            $customer = isset($result->customer) ? ($result->customer) : null;
            $accessingUserRole = getRoleInterpretRoute(\Auth::user()->role_code);
            $user = \Auth::user();


            $list = ($result->customeracctlist);
            //dd($list[sizeof($list)-1]);

            //dd($list[$i1]);
            $i1 = 0;
            $y =$list[0];
//dd($result);
            if(isset($result->customer))
                return response()->json(['status'=>110, 'data' => $y, 'customer'=>$result->customer]);
            else
                return response()->json(['status'=>110, 'data' => $y]);
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



	public function pullAccountCardList(Request $request, $accountId)
	{

		$token = $request->bearerToken();
		$user = JWTAuth::toUser($token);
		$data = array();
        	$data['token'] = $user->token;
		$data['merchantCode'] = PROBASEWALLET_MERCHANT_CODE;
		$data['deviceCode'] = PROBASEWALLET_DEVICE_CODE;
        	if($accountId!=NULL)
            		$data['accountIdentifier'] = (($accountId));


		$dataStr = "";
		foreach($data as $d => $v)
		{
			$dataStr = $dataStr."".$d."=".$v."&";
		}

		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountServicesV2/listAccountCards';
//dd($url."?".$dataStr);
		//$result = handleSOAPCalls('listCustomerAccounts', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data);
		$result = sendGetRequest($url, $dataStr);
		$result = json_decode($result);
//dd($result);
        if($result->status == 110)
        {
            $accessingUserRole = getRoleInterpretRoute(\Auth::user()->role_code);
            $user = \Auth::user();
            $all_card_schemes = json_decode($user->all_card_schemes);
            $all_card_type = getAllCardType();


			$list = ($result->customercardlist);
			if(sizeof($list)>0)
            {
                $customerName = $result->customercardlist[0]->full_name;
            }
			$currentBalance = isset($result->currentBalance) ? $result->currentBalance : 0;
			$floatingBalance = isset($result->floatingBalance) ? $result->floatingBalance : 0;
			$availableBalance = isset($result->availableBalance) ? $result->availableBalance : 0;
			$account = isset($result->account) ? $result->account : 0;
			$allDt = [];
			for($i1=0; $i1<sizeof($list); $i1++)
			{
				//dd($list[$i1]);
				$x=-1;
				try{
					$x =$list[$i1]->id;
				}
				catch(\Exception $e)
				{
					//dd($list[$i1]);
				}
				$dt = [];

				$pan = $list[$i1]->pan;
				$dt['pan']= $pan;
				$dt['full_name'] = $list[$i1]->full_name;
				$dt['accountIdentifier'] = $list[$i1]->accountIdentifier;
				$dt['serialNo'] = $list[$i1]->serialNo;
				$dt['schemeName'] = $list[$i1]->schemeName;
				$dt['cardType'] = $list[$i1]->cardType;
				$dt['status'] = $list[$i1]->status;
				$dt['cardBalance'] = $list[$i1]->cardCurrency."".(number_format($list[$i1]->cardBalance, 2, '.', ','));

				$str = "";
				$str = $str.'<div class="btn-group">';
					//$str = $str.'<button class="btn btn-sm btn-primary" type="button">Action</button>';
					$str = $str.'<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">';
						$str = $str.'<span class="caret"></span>';
						$str = $str.'<span class="sr-only">Toggle Dropdown</span>';
					$str = $str.'</button>';
					$str = $str.'<ul role="menu" class="dropdown-menu">';
						if(\Auth::user()->role_code == \App\Models\Roles::$POTZR_STAFF)
						{
							if($list[$i1]->status=="ACTIVE")
							{
								if(isset($list[$i1]->stopFlag) && $list[$i1]->stopFlag!=null && $list[$i1]->stopFlag==1)
								{
									$str = $str.'<li><a href="/potzr-staff/ecards/card-status/reactivate/'.$list[$i1]->serialNo.'">Unstop Card</a></li>';
									$str = $str.'<li><a href="/potzr-staff/ecards/card-status/delete/'.$x.'">Delete Card</a></li>';
								}
								else
								{
									$str = $str.'<li><a href="/potzr-staff/ecards/card-status/stop/'.$list[$i1]->serialNo.'">Stop Card</a></li>';
									if($list[$i1]->cardType=="TUTUKA_PHYSICAL_CARD")
									{
										$str = $str.'<li><a onclick="javascript:viewChangeCardPin('.$x.', \''.$list[$i1]->accountIdentifier.'\', \''.$list[$i1]->full_name.'\', \''.str_replace('_', ' ', $list[$i1]->cardType).'\', \''.$list[$i1]->schemeName.'\', \''.$list[$i1]->serialNo.'\', \''.$pan.'\');">Change Card Pin</a></li>';
										$str = $str.'<li><a onclick="javascript:transferCard('.$x.', \''.$dt['full_name'].'\', \''.$dt['accountIdentifier'].'\', \''.$dt['cardType'].'\', \''.$dt['serialNo'].'\', \''.$pan.'\', \''.$dt['schemeName'].'\');">Transfer Card</a></li>';
									}
									if($list[$i1]->cardType=="TUTUKA_VIRTUAL_CARD")
									{
										//$str = $str.'<li><a data-target="#changecvv_modal" data-toggle="modal" style="cursor: pointer" onclick="javascript:viewChangeCardCVV('.$x.', \''.$list[$i1]->accountIdentifier.'\', \''.$list[$i1]->full_name.'\', \''.str_replace('_', ' ', $list[$i1]->cardType).'\', \''.$list[$i1]->schemeName.'\', \''.$list[$i1]->serialNo.'\', \''.$pan.'\');">Change Card CVV</a></li>';
									}
								}
								$str = $str.'<li><a href="/potzr-staff/ecards/card-status/block/'.$list[$i1]->serialNo.'">Block Card</a></li>';
								//$str = $str.'<li><a data-target="#card_balance_modal" data-toggle="modal" style="cursor: pointer" onclick="javascript:viewCardBalance(\''.\Session::get('jwt_token').'\', '.$x.', \''.$list[$i1]->accountIdentifier.'\', \''.$list[$i1]->full_name.'\', \''.str_replace('_', ' ', $list[$i1]->cardType).'\', \''.$list[$i1]->schemeName.'\', \''.str_replace('_', ' ', $list[$i1]->status).'\', \''.$list[$i1]->serialNo.'\');">Balance On Card</a></li>';
							}
							else if($list[$i1]->status=="INACTIVE")
							{
								if($list[$i1]->cardType=="TUTUKA_PHYSICAL_CARD")
								{
									$str = $str.'<li><a href="/potzr-staff/ecards/card-status/activate/'.$x.'">Activate Card</a></li>';
								}
							}
							else if($dt['status']=="STOPPED")
							{
								$str = $str.'<li><a href="/potzr-staff/ecards/card-status/reactivate/'.$list[$i1]->serialNo.'">Unstop Card</a></li>';
							}
						}
						else if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
                        {
                            if($list[$i1]->status=="ACTIVE")
                            {
                                if(isset($list[$i1]->stopFlag) && $list[$i1]->stopFlag!=null && $list[$i1]->stopFlag==1)
                                {
                                    $str = $str.'<li><a href="/potzr-staff/ecards/card-status/reactivate/'.$list[$i1]->serialNo.'">Unstop Card</a></li>';
                                    $str = $str.'<li><a href="/potzr-staff/ecards/card-status/delete/'.$x.'">Delete Card</a></li>';
                                }
                                else
                                {
                                    $str = $str.'<li><a href="/potzr-staff/ecards/card-status/stop/'.$list[$i1]->serialNo.'">Stop Card</a></li>';
                                    if($list[$i1]->cardType=="TUTUKA_PHYSICAL_CARD")
                                    {
                                        $str = $str.'<li><a onclick="javascript:viewChangeCardPin('.$x.', \''.$list[$i1]->accountIdentifier.'\', \''.$list[$i1]->full_name.'\', \''.str_replace('_', ' ', $list[$i1]->cardType).'\', \''.$list[$i1]->schemeName.'\', \''.$list[$i1]->serialNo.'\', \''.$pan.'\');">Change Card Pin</a></li>';
                                        $str = $str.'<li><a onclick="javascript:transferCard('.$x.', \''.$dt['full_name'].'\', \''.$dt['accountIdentifier'].'\', \''.$dt['cardType'].'\', \''.$dt['serialNo'].'\', \''.$pan.'\', \''.$dt['schemeName'].'\');">Transfer Card</a></li>';
                                    }
                                    if($list[$i1]->cardType=="TUTUKA_VIRTUAL_CARD")
                                    {
                                        //$str = $str.'<li><a data-target="#changecvv_modal" data-toggle="modal" onclick="javascript:viewChangeCardCVV('.$x.', \''.$list[$i1]->accountIdentifier.'\', \''.$list[$i1]->full_name.'\', \''.str_replace('_', ' ', $list[$i1]->cardType).'\', \''.$list[$i1]->schemeName.'\', \''.$list[$i1]->serialNo.'\', \''.$pan.'\');">Change Card CVV</a></li>';
                                    }
                                }
                                $str = $str.'<li><a href="/potzr-staff/ecards/card-status/block/'.$list[$i1]->serialNo.'">Block Card</a></li>';
                                //$str = $str.'<li><a data-target="#card_balance_modal" data-toggle="modal" style="cursor: pointer" onclick="javascript:viewCardBalance(\''.\Session::get('jwt_token').'\', '.$x.', \''.$list[$i1]->accountIdentifier.'\', \''.$list[$i1]->full_name.'\', \''.str_replace('_', ' ', $list[$i1]->cardType).'\', \''.$list[$i1]->schemeName.'\', \''.str_replace('_', ' ', $list[$i1]->status).'\', \''.$list[$i1]->serialNo.'\');">Balance On Card</a></li>';
                            }
                            else if($list[$i1]->status=="INACTIVE")
                            {
                                if($list[$i1]->cardType=="TUTUKA_PHYSICAL_CARD")
                                {
                                    $str = $str.'<li><a href="/potzr-staff/ecards/card-status/activate/'.$list[$i1]->serialNo.'">Activate Card</a></li>';
                                }
                            }
							else if($dt['status']=="STOPPED")
							{
								$str = $str.'<li><a href="/potzr-staff/ecards/card-status/reactivate/'.$list[$i1]->serialNo.'">Unstop Card</a></li>';
							}
                        }

					$str = $str.'</ul>';
				$str = $str.'</div>';
				$dt['action'] = $str;
				array_push($allDt, $dt);
			}

			return response()->json(['status'=>100, 'data' => $allDt, 'currentBalance'=>$currentBalance, 'account'=>$account, 'floatingBalance'=>$floatingBalance, 'availableBalance'=>$availableBalance]);
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



	public function pullBatchCards(Request $request)
	{
		$data = array();
        $data['token'] = \Auth::user()->token;
		$deviceCode = $request->get('deviceCode');

		//dd($data);

		//$result = handleSOAPCalls('listBatchCards', 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/TutukaServicesV2?wsdl', $data);
		$dataStr = "deviceCode=".$deviceCode."&";
		foreach($data as $d => $v)
		{
			$dataStr = $dataStr."".$d."=".$v."&";
		}

		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/listBatchCards';
		//$result = handleSOAPCalls('listCustomerAccounts', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data);
		$result = sendGetRequest($url, $dataStr);
		$result = json_decode($result);


		//dd($result);
        if($result->status == 5000)
        {
            $batchCardList = ($result->cardBins);
			$allBatchCards = [];
			for($i1=0; $i1<sizeof($batchCardList); $i1++)
			{
			    $id = $batchCardList[$i1]->id;
				//dd($batchCardList[$i1]);
				$batchCard = [];
				$batchCard['card_batch_code']= isset($batchCardList[$i1]->cardBatchCode) ? $batchCardList[$i1]->cardBatchCode : 'N/A';
				$batchCard['card_no']= $batchCardList[$i1]->pan;
				$batchCard['card_type'] = getAllCardTypes()[$batchCardList[$i1]->cardType];
				$batchCard['tracking_number'] = $batchCardList[$i1]->trackingNumber;
				$batchCard['acquirer'] = $batchCardList[$i1]->acquirerName;
				$batchCard['issuer'] = $batchCardList[$i1]->issuerName;
				$batchCard['status'] = str_replace('_', ' ', getAllCardStatus()[$batchCardList[$i1]->status]);

				$str = "";
				$str = $str.'<div class="btn-group">';
					//$str = $str.'<button class="btn btn-sm btn-primary" type="button">Action</button>';
					$str = $str.'<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">';
						$str = $str.'<span class="caret"></span>';
						$str = $str.'<span class="sr-only">Toggle Dropdown</span>';
					$str = $str.'</button>';
					$str = $str.'<ul role="menu" class="dropdown-menu">';
						if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
						{
							if(str_replace('_', ' ', getAllCardStatus()[$batchCardList[$i1]->status])=="NOT ISSUED")
							{
								$str = $str.'<li><a href="/bank-teller/ecards/card-bin-status/issue/'.$id.'">Issue Card</a></li>';
							}
							else if(str_replace('_', ' ', getAllCardStatus()[$batchCardList[$i1]->status])=="ISSUED")
                            {
                                $str = $str.'<li><a data-target="#view_card_bin_issued" data-toggle="modal" onclick="viewCardBinIssued(\''.\Session::get('jwt_token').'\', '.$id.');">View Card Holder</a></li>';
                            }
						}
						if(\Auth::user()->role_code == \App\Models\Roles::$POTZR_STAFF)
						{
							if(str_replace('_', ' ', getAllCardStatus()[$batchCardList[$i1]->status])=="NOT ISSUED")
							{
								$str = $str.'<li><a onclick="showCardStatus('.$id.')">Card Status</a></li>';
								$str = $str.'<li><a onclick="showIssueCard('.$id.')">Issue Card</a></li>';
								$str = $str.'<li><a href="/potzr-staff/ecards/card-bin-status/delete-card/'.$id.'">Delete Card</a></li>';
							}
						}
					$str = $str.'</ul>';
				$str = $str.'</div>';
				$batchCard['action'] = $str;
				array_push($allBatchCards, $batchCard);
			}

            return response()->json(['success'=>true, 'cardBatch'=>$allBatchCards], 200);
        }else
        {
            return response()->json(['success'=>false, 'status'=>isset($result->status) ? $result->status : -1], 200);
        }
	}



	public function getECardScheme($id=NULL)
	{
		$cardScheme = NULL;
        try {
            if ($id != NULL) {
                $data = array();
                $data['token'] = \Auth::user()->token;
                $data['cardSchemeId'] = $id;

				$dataStr = "";
				foreach($data as $d => $v)
				{
					$dataStr = $dataStr."".$d."=".$v."&";
				}


				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/pullCardScheme';
				//$result = handleSOAPCalls('pullCardScheme', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/CardServicesV2?wsdl', $data);
				$result = sendGetRequest($url, $dataStr);
				$result = json_decode($result);
				if($result==null)
				{
					return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
				}

				if (handleTokenUpdate($result) == false) {
					return response()->json(['status' => -1, 'message'=>'Login session expired. Please relogin again']);
				}

                if ($result->status == 2100) {
					$cardScheme = $result->cardScheme;
					return response()->json(['success'=>true, 'cardScheme'=>$cardScheme], 200);
				}
				else
				{
					//return \Redirect::back()->with('error', 'Failed to access customer listing');
					return response()->json(['status' => -1, 'message'=>'Failed to access customer listing']);
                }
            }
        }catch(Exception $e)
        {
            dd($e);
        }
	}




	public function pullCustomerList(Request $request)
	{
		$data = array();
		$token = $request->bearerToken();
		$user = JWTAuth::toUser($token);
		$accessingUserRole = getRoleInterpretRoute($user->role_code);
		$data['token'] = \Auth::user()->token;

		$dataStr = "";
		foreach($data as $d => $v)
		{
			$dataStr = $dataStr."".$d."=".$v."&";
		}


		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/listCustomers';
		//$result = handleSOAPCalls('pullCardScheme', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/CardServicesV2?wsdl', $data);
		$result = sendGetRequest($url, $dataStr);

		$result = json_decode($result);

		if($result==null)
		{
			return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
		}

		if (handleTokenUpdate($result) == false) {
			return response()->json(['status' => -1, 'message'=>'Login session expired. Please relogin again']);
		}

        if($result->status == 110)
        {
            $list = ($result->customerlist);
			$allDt = [];
			for($i1=0; $i1<sizeof($list); $i1++)
			{
				//dd($list[$i1]);
				$y =$list[$i1]->id;
				$dt = [];
				$dt['full_name']= strtoupper($list[$i1]->lastName)." ".$list[$i1]->firstName.(isset($list[$i1]->otherName) && strlen($list[$i1]->otherName)>0 ? " ".$list[$i1]->otherName : "");
				$dt['customerType'] = $list[$i1]->customerType;
				$dt['verificationNumber'] = $list[$i1]->verificationNumber;
				$dt['contactMobile'] = $list[$i1]->contactMobile;
				$dt['contactEmail'] = $list[$i1]->contactEmail;
				$dt['status'] = $list[$i1]->status;




				$str = "";
				$str = $str.'<div class="btn-group">';
					//$str = $str.'<button class="btn btn-sm btn-primary" type="button">Action</button>';
					$str = $str.'<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">';
						$str = $str.'<span class="caret"></span>';
						$str = $str.'<span class="sr-only">Toggle Dropdown</span>';
					$str = $str.'</button>';
					$str = $str.'<ul role="menu" class="dropdown-menu">';
						$str = $str.'<li><a data-target="#customer_accounts_modal" data-toggle="modal" onclick="viewCustomerAccounts(\''.\Session::get('jwt_token').'\', \'customerAccountsTable\',  '.$y.', \''.$dt['full_name'].'\', \''.$dt['verificationNumber'].'\')">View Customer Accounts</a></li>';
						$str = $str.'<li><a data-target="#account_cards_modal" data-toggle="modal" onclick="viewCustomerCards(\''.\Session::get('jwt_token').'\', '.$y.', \''.$dt['full_name'].'\', \''.$dt['verificationNumber'].'\', \'accountcardtable\', \''.BEVURA_DEVICE_CODE.'\')">View Customer Bevura Cards</a></li>';
						$str = $str.'<li><a data-target="#account_cards_modal" data-toggle="modal" onclick="viewCustomerCards(\''.\Session::get('jwt_token').'\', '.$y.', \''.$dt['full_name'].'\', \''.$dt['verificationNumber'].'\', \'accountcardtable\', \''.PROBASEWALLET_DEVICE_CODE.'\')">View Customer ZICB Cards</a></li>';
						$str = $str.'<li><a data-target="#customer_profile_modal" data-toggle="modal"  onclick="viewCustomerProfile(\''.\Session::get('jwt_token').'\', '.$y.')">View Profile</a></li>';
					if($list[$i1]->customerType=='COLLECTIONS')
					{
						$str = $str.'<li><a data-toggle="modal"  onclick="viewAddCorporateAccount(\''.\Session::get('jwt_token').'\', '.$y.')">Add Account</a></li>';
					}
						//if($user->role_code == \App\Models\Roles::$BANK_TELLER)
							//$str = $str.'<li><a href="/'.$accessingUserRole.'/customers/add-new-account">Add New Account</a></li>';

							//$str = $str.'<li><a style="cursor: pointer !important" data-target="#new-account-modal-step-one" data-toggle="modal" onclick="addNewAccount('.$y.', \''.\Session::get('jwt_token').'\', \''.$dt['full_name'].'\', \''.$dt['verificationNumber'].'\', \'\', \'\')">Add New Account</a></li>';

						//if($user->role_code == \App\Models\Roles::$BANK_TELLER)
						//	$str = $str.'<li><a href="/'.$accessingUserRole.'/customers/update-profile/'.$y.'">Update Profile</a></li>';

					$str = $str.'</ul>';
				$str = $str.'</div>';
				$dt['action'] = $str;
				array_push($allDt, $dt);
			}

            return response()->json(['data' => $allDt, "recordsTotal"=> sizeof($allDt), "recordsFiltered"=> sizeof($allDt)]);
        }
		else
        {
            return response()->json(['status' => 0, 'data' => []]);
        }
	}



    public function setupAutoDebit(Request $request, $type=NULL)
    {
		//return response()->json(['message' => $request->all()], 200);
        	$data = array();
		$token = null;
        	$data = [];
		$all = [];
		if($type!=null && $type==1)
		{
			$token = $request->get('token');
			$data['token'] = $token;
       		$data['accountNumber'] = $request->get('accountIdentifier');
        		$data['isEnabled'] = intval($request->get('addAutoDebit'));
			$all = $request->all();
			unset($all['token']);
		}
		else
		{
			$token = $request->bearerToken();
			$user = JWTAuth::toUser($token);
			$data['token'] = \Auth::user()->token;
       		$data['accountNumber'] = $request->get('accountIdentifier');
        		$data['isEnabled'] = intval($request->get('addAutoDebit'));
			$all = $request->all();
		}
       	$data['merchantCode'] = $request->get('merchantCode');
       	$data['deviceCode'] = $request->get('deviceCode');



        	$dataStr = "";
       	foreach($data as $d => $v)
        	{
            		$dataStr = $dataStr."".$d."=".$v."&";
        	}

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AutoDebitServicesV2/customerEnableAutoDebit';
        $server_output = sendPostRequest($url, $dataStr);
        //return response()->json(['message' => $server_output, 'success'=>false], 200);
        $result = json_decode($server_output);
        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }

        if (handleTokenUpdate($result) == false) {
            return response()->json(['status' => -1, 'message'=>'Login session expired. Please relogin again']);
        }
        //, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data


        if($result->status == 5000)
        {
            return response()->json(['message' => $result->message, 'success'=>true], 200);
        }
	 else
        {
            return response()->json(['success'=>false, 'status' => 0, 'message'=>(isset($result->message) ? $result->message : ($data['isEnabled']=="1" ? 'Automatic Debits Activation ' : 'Automatic Debits Deactivation ')).' was not successful. Please try again']);
        }
    }




    public function activateEWallet(Request $request, $status, $accountId, $type=NULL)
    {
		//return response()->json(['message' => $request->all()], 200);
        	$data = array();
		$token = null;
        	$data = [];
		$all = [];
		if($type!=null && $type==1)
		{
			$token = $request->get('token');
			$data['token'] = $token;
			$all = $request->all();
			unset($all['token']);
		}
		else
		{
			$token = $request->bearerToken();
			$user = JWTAuth::toUser($token);
			$data['token'] = \Auth::user()->token;
			$all = $request->all();
		}


        $data['accountId'] = $accountId;
        $data['status'] = intval($status);

        //$result = handleSOAPCalls('activateEWallet', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/AccountServices?wsdl', $data);
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountServicesV2/updateAccountStatus';
        $server_output = sendPostRequest($url, $dataStr);
        //dd($server_output);
        $result = json_decode($server_output);
        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }

        if (handleTokenUpdate($result) == false) {
            return response()->json(['status' => -1, 'message'=>'Login session expired. Please relogin again']);
        }
        //, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data


        if($result->status == 100)
        {
            return response()->json(['message' => $result->message, 'success'=>true], 200);
        }else
        {
            return response()->json(['success'=>false, 'status' => 0, 'message'=>(isset($result->message) ? $result->message : ($status=="1" ? 'Activation ' : 'Deactivation ')).' was not successful. Please try again']);
        }
    }




	public function enableBiometric(Request $request, $type=NULL)
	{
		$data = array();
		$token = null;
        	$data = [];
		$all = [];
		if($type!=null && $type==1)
		{
			$token = $request->get('token');
			$data['token'] = $token;
			$all = $request->all();

			$data['isEnabled'] = $all['isEnabled'];
			unset($all['token']);
		}
		else
		{
			$token = $request->bearerToken();
			$user = JWTAuth::toUser($token);
			$data['token'] = \Auth::user()->token;
			$all = $request->all();
			$data['isEnabled'] = $all['isEnabled'];
		}

		//return response()->json(['message' => $data, 'success'=>false], 200);
			
			//$result = handleSOAPCalls('activateEWallet', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/AccountServices?wsdl', $data);
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/enableBiometric';
			$server_output = sendPostRequest($url, $dataStr);
			//dd($server_output);
			$result = json_decode($server_output);
			if($result==null)
			{
				return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
			}

			if($result->status == -1) {
				return response()->json(['status' => -1, 'message'=>'Login session expired. Please relogin again']);
			}
			else if($result->status == 5000)
			{
				return response()->json(['message' => $result->message, 'success'=>true, 'status'=>100], 200);
			}else
			{
				return response()->json(['success'=>false, 'status' => 0, 'message'=>(isset($result->message) ? $result->message : ($data['isEnabled']==1 ? 'Biometric fingerprint authentication was not enabled ' : 'Biometric fingerprint authentication was not disabled ')).' successfully. Please try again']);
			}
	}


    public function pullCustomerProfile(Request $request, $customerId)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        $data = array();
        $data['customerId'] = $customerId;
        $data['token'] = $user->token;

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/getCustomer';
        $server_output = sendGetRequest($url, $dataStr);
        $result = json_decode($server_output);
        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }


        if($result->status == 100)
        {
            return response()->json($result);
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



	

	public function postGetAgentList(Request $request)
	{
		$token = $request->bearerToken();
        	$user = JWTAuth::toUser($token);

        	$data = array();
       	$data['token'] = $user->token;

        	$dataStr = "";
        	foreach($data as $d => $v)
        	{
            		$dataStr = $dataStr."".$d."=".$v."&";
        	}

        	$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/listAgents';
        	$server_output = sendGetRequest($url, $dataStr);
        	$result = json_decode($server_output);
		//dd($result);
        	if($result==null)
        	{
            		return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        	}


       	if($result->status == 5000)
        	{

			$list = ($result->agentlist);
			$allDt = [];
			for($i1=0; $i1<sizeof($list); $i1++)
			{
				//dd($list[$i1]);
				$agent = $list[$i1];
				$y =$list[$i1]->id;
				$dt = [];
				$dt['companyName']= '<strong>'.$list[$i1]->companyName.'</strong>';
				$dt['agentCode'] = $list[$i1]->agentCode;
				$dt['deviceCode'] = $list[$i1]->deviceCode;
				$dt['fullName'] = $list[$i1]->fullName;
				$dt['status'] = $list[$i1]->agentStatus==1 ? "Active" : "Inactive";

				$str = "";



				$str = $str.'<div class="btn-group mr-1 mb-1">';;
					$str = $str.'<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>';
					$str = $str.'<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">';


						//$str = $str.'<a class="dropdown-item" href="/accountant/agents/fund-agent/'.$y.'">Fund Agent</a>';
			                        $str = $str.'<a style="cursor: pointer !important" data-target="#fund_agent_modal" data-toggle="modal" class="dropdown-item" onclick="viewFundAgent('.$y.', \''.$list[$i1]->companyName.'\',  \''.\Session::get('jwt_token').'\')">Fund Agent</a>';
						if($agent->status==1)
						{
							$str = $str.'<a class="dropdown-item" href="/potzr-staff/merchants/add-merchant-account/'.$y.'">Disable Agent</a>';
						}
						else
						{
							$str = $str.'<a class="dropdown-item" href="/potzr-staff/merchants/add-merchant-account/'.$y.'">Enable Agent</a>';
						}
					$str = $str.'</div>';
				$str = $str.'</div>';
				$dt['action'] = $str;
				array_push($allDt, $dt);
			}


            		return response()->json(['agentlist'=>$allDt, 'status'=>sizeof($allDt)>0 ? 5000 : 110]);

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




    public function postGetCardDetailsByCardBinId(Request $request, $id)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        $data = array();
        $data['binId'] = $id;
        $data['token'] = $user->token;

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        //dd($dataStr);

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/getCardByCardBinId';
        $server_output = sendPostRequest($url, $dataStr);
        $result = json_decode($server_output);

        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }


        if($result->status == 5000)
        {
            return response()->json($result);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any card mapped to the card bin.']);
        }
    }


    public function pullMerchantTransactionList(Request $request, $merchantId=NULL)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        $data = array();
        if($merchantId!=null)
            $data['merchantId'] = $merchantId;

        $data['token'] = $user->token;

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        //dd($dataStr);

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/MerchantServicesV2/getMerchantTransactions';
        $server_output = sendGetRequest($url, $dataStr);
        $result = json_decode($server_output);
        //dd($result);

        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }


	$merchantNameToDisplay  = null;
	 if($merchantId!=null)
	{
		$merchantNameToDisplay = $result->merchant->merchantName;
	}


        $channelsList = array_keys(getAllChannel());
        $statusList = array_keys(getAllTransactionStatus());
        $currencyList = array_keys(getAllCurrency());
        $serviceTypesList = array_keys(allServiceTypes());
	 //dd(allServiceTypes());
        if($result->status == 210)
        {
            $merchanttransactionslist = $result->merchanttransactionslist;
            $dt = [];
            foreach($merchanttransactionslist as $mtl)
            {
                $dt_ = [];
                $dt_['merchantName'] = '<strong>'.(isset($mtl->merchantName) && $mtl->merchantName!=null ? $mtl->merchantName : 'N/A').'</strong>';
                $dt_['transactionDate'] = date('Y, M d H:i', strtotime($mtl->transactionDate)).'<sup></sup>';
                $dt_['transactionRef'] = join('-', str_split($mtl->transactionRef, 4));
                $dt_['payerName'] = isset($mtl->payerName) ? strtoupper(strtolower($mtl->payerName)) : "N/A";
                $dt_['sourceIdentity'] = isset($mtl->accountIdentifier) && $mtl->accountIdentifier!=null ? $mtl->accountIdentifier : (isset($mtl->trackingNumber) && $mtl->trackingNumber!=null ? $mtl->trackingNumber: 'N/A');
                $dt_['channel'] = ucfirst(strtolower(str_replace('_', ' ', $channelsList[$mtl->channel])));
                $dt_['serviceType'] = ucfirst(strtolower(str_replace('_', ' ', $serviceTypesList[$mtl->serviceType])));
		  if($statusList[$mtl->status]=='PENDING')
                	$dt_['status'] = '<div class="btn btn-sm btn-primary">'.ucfirst(strtolower(str_replace('_', ' ', $statusList[$mtl->status]))).'</div>';
		  else if($statusList[$mtl->status]=='SUCCESS')
                	$dt_['status'] = '<div class="btn btn-sm btn-success">'.ucfirst(strtolower(str_replace('_', ' ', $statusList[$mtl->status]))).'</div>';
		  else if($statusList[$mtl->status]=='FAILED')
                	$dt_['status'] = '<div class="btn btn-sm btn-danger">'.ucfirst(strtolower(str_replace('_', ' ', $statusList[$mtl->status]))).'</div>';
		  else
                	$dt_['status'] = '<div class="btn btn-sm btn-danger">'.ucfirst(strtolower(str_replace('_', ' ', $statusList[$mtl->status]))).'</div>';
                $dt_['amount'] = number_format($mtl->amount, 2, '.', ',');
		  $dt_['currency'] = $currencyList[$mtl->probasePayCurrency];


                array_push($dt, $dt_);
            }
            return response()->json(['status' => 100, 'list' => $dt, 'merchantNameToDisplay'=>$merchantNameToDisplay ]);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any card mapped to the card bin.']);
        }
    }



    public function pullCardTransactionList(Request $request, $cardId=NULL)
    {

        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        $data = array();
        if($cardId!=null)
	 {
            $data['creditCardId'] = $cardId;
	 }
	 $data['filter'] = 'card';
	 

        $data['token'] = $user->token;
//dd($data);

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".urlencode($v)."&";
        }




        //dd($dataStr);

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/TransactionServicesV2/listTransactions';
        $server_output = sendGetRequest($url, $dataStr);
        $result = json_decode($server_output);


        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }

//dd($result);
        $channelsList = array_keys(getAllChannel());
        $statusList = array_keys(getAllTransactionStatus());
        $currencyList = array_keys(getAllCurrency());
        $serviceTypesList = array_keys(getAllServiceTypes());
        if($result->status === 410)
        {
            $cardtransactionslist = $result->transactionList;
            $dt = [];
	     $d1 = 1;
            foreach($cardtransactionslist as $mtl)
            {
                $dt_ = [];
                $dt_['id'] = isset($mtl->id) ? $mtl->id : '';
		  $dt_['sno'] = $d1++.".";
                $dt_['trackingNumber'] = isset($mtl->trackingNumber) ? formatPan($mtl->trackingNumber) : 'N/A';
                $dt_['transactionDate'] = date('Y, M d H:i', strtotime($mtl->transactionDate)).'';
                $dt_['transactionRef'] = join('-', str_split(strtoupper($mtl->transactionRef), 4));
                $dt_['payerName'] = strtoupper(strtolower($mtl->payerName));
                $dt_['orderRef'] = isset($mtl->orderRef) && $mtl->orderRef!=null ? strtoupper($mtl->orderRef) : 'N/A';
                $dt_['channel'] = strtoupper(strtolower(str_replace('_', ' ', $channelsList[$mtl->channel])));
                $dt_['serviceType'] = ucfirst(strtolower(str_replace('_', ' ', $serviceTypesList[$mtl->serviceType])));
                $dt_['status'] = ucfirst(strtolower(str_replace('_', ' ', $statusList[$mtl->status])));
                $dt_['amount'] = $currencyList[$mtl->probasePayCurrency].number_format($mtl->amount, 2, '.', ',');


                array_push($dt, $dt_);
            }
            return response()->json(['status' => 100, 'list' => $dt, 'ff'=>$cardtransactionslist ]);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any card mapped to the card bin.']);
        }
    }



    public function pullWalletTransactionList(Request $request, $walletId=NULL)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        $data = array();
        if($walletId!=null)
            $data['walletId'] = $walletId;

        $data['token'] = $user->token;

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        //dd($dataStr);

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountServicesV2/getAccountTransactions';
        $server_output = sendGetRequest($url, $dataStr);
        $result = json_decode($server_output);


        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }


        $channelsList = array_keys(getAllChannel());
        $statusList = array_keys(getAllTransactionStatus());
        $currencyList = array_keys(getAllCurrency());
        $serviceTypesList = array_keys(getAllServiceTypes());
        if($result->status === 0)
        {
            $wallettransactionslist = $result->wallettransactionslist;
            $dt = [];
            foreach($wallettransactionslist as $mtl)
            {
                $dt_ = [];
                $dt_['accountIdentifier'] = isset($mtl->accountIdentifier) ? ($mtl->accountIdentifier) : 'N/A';
                $dt_['transactionDate'] = date('Y, M d H:i', strtotime($mtl->transactionDate)).'';
                $dt_['transactionRef'] = strtoupper(strtolower($mtl->transactionRef));
                $dt_['payerName'] = ucfirst(strtolower($mtl->payerName));
                $dt_['accountNo'] = isset($mtl->merchantAccount) && $mtl->merchantAccount!=null ? $mtl->merchantAccount : 'N/A';
                $dt_['channel'] = ucfirst(strtolower(str_replace('_', ' ', $channelsList[$mtl->channel])));
                $dt_['serviceType'] = ucfirst(strtolower(str_replace('_', ' ', $serviceTypesList[$mtl->serviceType])));
                $dt_['status'] = ucfirst(strtolower(str_replace('_', ' ', $statusList[$mtl->status])));
                $dt_['amount'] = $currencyList[$mtl->probasePayCurrency].number_format($mtl->amount, 2, '.', ',');


                array_push($dt, $dt_);
            }
            return response()->json(['status' => 100, 'list' => $dt]);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any card mapped to the card bin.']);
        }
    }




    public function pullCustomerLoansList(Request $request)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        $data = array();

        $data['token'] = $user->token;

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        //dd($dataStr);

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BillServicesV2/getCustomerLoans';
        $server_output = sendPostRequest($url, $dataStr);
        $result = json_decode($server_output);




        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }


        if($result->status === 5000)
        {
            $customerLoans = $result->customerLoans;
            $dt = [];
            
            return response()->json(['status' => 100, 'list' => $customerLoans]);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any card mapped to the card bin.']);
        }
    }






    public function pullTransactionList(Request $request, $type=NULL)
    {
	try
	{

		$token = null;
        	$data = [];
		$all = [];
		$user = null;
		if($type!=null && $type==1)
		{
			$token = $request->get('token');
			$data['token'] = $token;
			$all = $request->all();
			unset($all['token']);
			$data['customerVerificationNumber'] = $request->get('customerVerificationNo');

		}
		else
		{
			$token = $request->bearerToken();
			$user = JWTAuth::toUser($token);
			$data['token'] = \Auth::user()->token;
			$all = $request->all();




        		if($user->role_code==\App\Models\Roles::$CUSTOMER)
            			$data['customerVerificationNumber'] = $user->customerVerificationNo;


        		if($user->role_code==\App\Models\Roles::$AGENT)
			{
            			$data['filter'] = 'agent';
            			$data['agentCode'] = 'IO930dk49';
			}
		}


					$ap = new \App\Models\AppError();
					$ap->error_trace = json_encode($request->all());
					$ap->url = "";
					$ap->error_dump = json_encode($data);
					$ap->user_username = "";
					$ap->save();

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }
	 $filter = null;

	 $filter = $request->has('filter') ? $request->get('filter') : null;
	 //$dataStr = $dataStr."&count=".(isset($all['count']) ? $all['count'] : 1000)."&filter=".($filter==null ? '' : $filter);


	 if(isset($all['count']) && $all['count']=='All')
	 {
	 	$dataStr = $dataStr."&count=-1";
	 }
	 else if(isset($all['count']))
	 {
	 	$dataStr = $dataStr."&count=".(isset($all['count']) ? $all['count'] : 1000);
	 }
	 $dataStr = $dataStr."&filter=".($filter==null ? '' : $filter);



	foreach($all as $a1 => $a2)
	{
		$dataStr = $dataStr ."&".$a1."=".urlencode($a2);
	}


        //dd($request->all());
		


        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/TransactionServicesV2/listTransactions';
        $server_output = sendGetRequest($url, $dataStr);
//dd($server_output);
        $result = json_decode($server_output);
//dd($result);
	


        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'server_output'=>$server_output, 'success'=>false], 200);
        }


        $channelsList = array_keys(getAllChannel());
        $statusList = array_keys(getAllTransactionStatus());
        $currencyList = array_keys(getAllCurrency());
        $serviceTypesList = array_values(getAllServiceTypes());
	 $x11 = 1;
	 //dd($result);
        if($result->status === 410)
        {
            $transactionList = $result->transactionList;

            $dt = [];
		
		if($type!=null && $type==1)
		{

			foreach ($transactionList as $mtl) {




                    		$y = $mtl->id;
                    		$dt_ = [];
                    		$dt_['id'] = $x11++;
                    		$dt_['status'] = ucfirst(strtolower(str_replace('_', ' ', $statusList[$mtl->status])));
				$dt_['transactionDate'] = date('Y, M d H:i', strtotime($mtl->transactionDate)) . '';
				$dt_['transactionRef'] = isset($mtl->transactionRef) && $mtl->transactionRef!=null ? strtoupper(strtolower($mtl->transactionRef)) : null;
				$dt_['transactionDetail'] = isset($mtl->transactionDetail) && $mtl->transactionDetail != null ? $mtl->transactionDetail : 'N/A';
				$dt_['detail'] = isset($mtl->details) && $mtl->details!= null ? $mtl->details: 'N/A';
				$dt_['serviceType'] = isset($serviceTypesList[$mtl->serviceType]) ? ((str_replace('_', ' ', $serviceTypesList[$mtl->serviceType]))) : 'N/A';
				$dt_['currency'] = $currencyList[$mtl->probasePayCurrency];
				$dt_['amount'] = number_format($mtl->amount, 2, '.', ',');
				$dt_['creditAccountTrue'] = isset($mtl->creditAccountTrue) ? $mtl->creditAccountTrue : false;
				$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
				$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
				$dt_['debitCardTrue'] = isset($mtl->debitCardTrue) ? $mtl->debitCardTrue: false;
				$dt_['summary'] = isset($mtl->summary) ? $mtl->summary: null;
				$dt_['isReversed'] = isset($mtl->isReversed) ? $mtl->isReversed: null;
				$dt_['transactionDetail'] = isset($mtl->transactionDetail) ? $mtl->transactionDetail: null;
				$dt_['totalAmountDebited'] = number_format($mtl->amount + ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
						(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');
					if($dt_['serviceType']=="Collect A Village Banking Group Loan" || $dt_['serviceType']=="Group Contributions Close-Out")
					{
						$dt_['creditAccountTrue'] = true;
						$dt_['isCredit'] = true;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitCardTrue'] = false;
						$dt_['totalAmountDebited'] = number_format($mtl->amount, 2, '.', ',');

					}
					else if($dt_['serviceType']=="Withdraw Cash")
					{
						$dt_['detail'] = 'Cash Withdrawal';

					}
					else
					{
						$dt_['creditAccountTrue'] = isset($mtl->creditAccountTrue) ? $mtl->creditAccountTrue : false;
						$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
						$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
						$dt_['debitCardTrue'] = isset($mtl->debitCardTrue) ? $mtl->debitCardTrue: false;
						$dt_['totalAmountDebited'] = number_format($mtl->amount + ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
							(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');
					
					}
				$dt_['customerId'] = isset($mtl->customerId) && $mtl->customerId!=null ?  (($mtl->customerId)) : '';
				$dt_['recipientDetails'] = isset($mtl->recipientDetails) && $mtl->recipientDetails!=null ?  (($mtl->recipientDetails)) : '';



				array_push($dt, $dt_);
			}

		}
		else
		{

            		if($user->role_code==\App\Models\Roles::$CUSTOMER)
            		{
                		foreach ($transactionList as $mtl) {
                    			$y = $mtl->id;
                    			$dt_ = [];
                    			$dt_['id'] = $x11++;



                    			$dt_['status'] = ucfirst(strtolower(str_replace('_', ' ', $statusList[$mtl->status])));
					$dt_['transactionDate'] = date('Y, M d H:i', strtotime($mtl->transactionDate)) . '';
					$dt_['transactionRef'] = isset($mtl->transactionRef) && $mtl->transactionRef!=null ?  strtoupper(strtolower($mtl->transactionRef)) : 'N/A';
					$dt_['transactionDetail'] = isset($mtl->transactionDetail) && $mtl->transactionDetail != null ? $mtl->transactionDetail : 'N/A';
					$dt_['detail'] = isset($mtl->details) && $mtl->details!= null ? $mtl->details: 'N/A';
					$dt_['serviceType'] = isset($serviceTypesList[$mtl->serviceType]) ? ((str_replace('_', ' ', $serviceTypesList[$mtl->serviceType]))) : 'N/A';
					$dt_['currency'] = $currencyList[$mtl->probasePayCurrency];
					$dt_['amount'] = number_format($mtl->amount, 2, '.', ',');
					$dt_['isReversed'] = isset($mtl->isReversed) ? $mtl->isReversed: null;

					if($dt_['serviceType']=="Collect A Village Banking Group Loan")
					{
						$dt_['creditAccountTrue'] = true;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitCardTrue'] = false;
						$dt_['totalAmountDebited'] = number_format($mtl->amount - ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
							(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');

					}
					else if($dt_['serviceType']=="Withdraw Cash")
					{
						$dt_['detail'] = 'Cash Withdrawal';

					}
					else
					{
						$dt_['creditAccountTrue'] = isset($mtl->creditAccountTrue) ? $mtl->creditAccountTrue : false;
						$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
						$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
						$dt_['debitCardTrue'] = isset($mtl->debitCardTrue) ? $mtl->debitCardTrue: false;
						$dt_['totalAmountDebited'] = number_format($mtl->amount + ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
							(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');
					
					}

					$dt_['summary'] = isset($mtl->summary) ? $mtl->summary: null;
					$dt_['transactionDetail'] = isset($mtl->transactionDetail) ? $mtl->transactionDetail: null;


					if($dt_['serviceType']=="Collect A Village Banking Group Loan")
					{
						$dt_['creditAccountTrue'] = true;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitCardTrue'] = false;
						$dt_['totalAmountDebited'] = number_format($mtl->amount - ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
							(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');

					}
					$dt_['customerId'] = isset($mtl->customerId) && $mtl->customerId!=null ?  (($mtl->customerId)) : '';
					$dt_['recipientDetails'] = isset($mtl->recipientDetails) && $mtl->recipientDetails!=null ?  (($mtl->recipientDetails)) : '';
					
					array_push($dt, $dt_);
				}


			}


			else if($user->role_code==\App\Models\Roles::$AGENT)
            		{

                		foreach ($transactionList as $mtl) {
                    			$y = $mtl->id;
                    			$dt_ = [];
                    			$dt_['id'] = $x11++;



                    			$dt_['status'] = ucfirst(strtolower(str_replace('_', ' ', $statusList[$mtl->status])));
					$dt_['transactionDate'] = date('Y, M d H:i', strtotime($mtl->transactionDate)) . '';
					$dt_['transactionRef'] = isset($mtl->transactionRef) && $mtl->transactionRef!=null ?  strtoupper(strtolower($mtl->transactionRef)) : 'N/A';
					$dt_['payerName'] = isset($mtl->payerName) ? (strtoupper(strtolower($mtl->payerName)).'<br>'.(isset($mt1->payerMobile) ? $mt1->payerMobile : '')) : '';
					$dt_['transactionDetail'] = isset($mtl->transactionDetail) && $mtl->transactionDetail != null ? $mtl->transactionDetail : 'N/A';
					$dt_['detail'] = isset($mtl->details) && $mtl->details!= null ? $mtl->details: 'N/A';
					$dt_['serviceType'] = isset($serviceTypesList[$mtl->serviceType]) ? ((str_replace('_', ' ', $serviceTypesList[$mtl->serviceType]))) : 'N/A';
					$dt_['currency'] = $currencyList[$mtl->probasePayCurrency];
					$dt_['amount'] = number_format($mtl->amount, 2, '.', ',');
					$dt_['isReversed'] = isset($mtl->isReversed) ? $mtl->isReversed: null;


					$customData = isset($mtl->customData) && $mtl->customData!=null ? $mtl->customData : null;
					$dt_["bvSource"] = "";
					$dt_["partnerAccount"] = "";
					$dt_["partnerCustomerName"] = "";
					$dt_["partnerType"] = "";
					$dt_["otherBankRef"] = "";
					$dt_["acquirerRef"] = "";
					$dt_["txnType"] = "";
					$dt_["remarks"] = "";

					if($customData!=null)
					{ 
						$customData = explode('|||', $customData);
						$dt_["bvSource"] = $customData[0];
						$dt_["partnerAccount"] = $customData[1];
						$dt_["partnerCustomerName"] = $customData[2];
						$dt_["partnerType"] = $customData[3];
						$dt_["otherBankRef"] = $customData[4];
						$dt_["acquirerRef"] = $customData[5];
						$dt_["txnType"] = $customData[6];
						$dt_["remarks"] = $customData[7];
					}
					

					if($dt_['serviceType']=="Collect A Village Banking Group Loan")
					{
						$dt_['creditAccountTrue'] = true;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitCardTrue'] = false;
						$dt_['totalAmountDebited'] = number_format($mtl->amount - ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
							(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');

					}
					else if($dt_['serviceType']=="Withdraw Cash")
					{
						$dt_['detail'] = 'Cash Withdrawal';

					}
					else
					{
						$dt_['creditAccountTrue'] = isset($mtl->creditAccountTrue) ? $mtl->creditAccountTrue : false;
						$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
						$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
						$dt_['debitCardTrue'] = isset($mtl->debitCardTrue) ? $mtl->debitCardTrue: false;
						$dt_['totalAmountDebited'] = number_format($mtl->amount + ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
							(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');
					
					}

					$dt_['summary'] = isset($mtl->summary) ? $mtl->summary: null;
					$dt_['transactionDetail'] = isset($mtl->transactionDetail) ? $mtl->transactionDetail: null;


					if($dt_['serviceType']=="Collect A Village Banking Group Loan")
					{
						$dt_['creditAccountTrue'] = true;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitCardTrue'] = false;
						$dt_['totalAmountDebited'] = number_format($mtl->amount - ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
							(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');

					}
					$dt_['customerId'] = isset($mtl->customerId) && $mtl->customerId!=null ?  (($mtl->customerId)) : '';
					$dt_['recipientDetails'] = isset($mtl->recipientDetails) && $mtl->recipientDetails!=null ?  (($mtl->recipientDetails)) : '';
					$dt_['balance'] = isset($mtl->currentCardBalance) ? number_format($mtl->currentCardBalance, 2, '.', ',') : (isset($mtl->currentAccountBalance) ? number_format($mtl->currentAccountBalance, 2, '.', ',') : 'N/A');

					array_push($dt, $dt_);
				}


			}

			else {
//dd($transactionList );
//dd($serviceTypesList);
				foreach ($transactionList as $mtl) {
					$y = $mtl->id;
					$dt_ = [];



                    			$dt_['id'] = $x11++.".";
					$dt_['transactionDate'] = date('Y, M d H:i', strtotime($mtl->transactionDate))."<br><a style='text-decoration: underline !important; color: #0d6efd !important; cursor: pointer !important'>".join('-', str_split(strtoupper(strtolower($mtl->transactionRef)), 4))."</a>";
					$dt_['payerName'] = isset($mtl->payerName) ? (strtoupper(strtolower($mtl->payerName)).'<br>'.(isset($mt1->payerMobile) ? $mt1->payerMobile : '')) : '';
					$dt_['accountNo'] = isset($mtl->merchantAccount) && $mtl->merchantAccount != null ? $mtl->merchantAccount : 'N/A';
					$dt_['currency'] = $currencyList[$mtl->probasePayCurrency];
					$dt_['isReversed'] = isset($mtl->isReversed) ? $mtl->isReversed: null;
					$dt_['isReversed'] = isset($mtl->isReversed) ? $mtl->isReversed: null;

					$sty = "";
					if(isset($mtl->serviceType))
					{
						if(isset($serviceTypesList[$mtl->serviceType]) && $serviceTypesList[$mtl->serviceType]!=null)
						{
							$sty = $sty.((str_replace('_', ' ', $serviceTypesList[$mtl->serviceType])))."<br>";
						}
						else
						{
							$sty = $sty.$mtl->serviceType."<br>";
						}
					}
					else
					{
						$sty = "Not Applicable<br>";
					}

					if(isset($dt_['currency']))
					{
						$sty = $sty."<small style='float: left !important; padding: 5px !important;'><span class='currencymodespan' title='Currency: ".$dt_['currency']."'>".$dt_['currency']."</span></small>";
					}

					if(isset($mtl->channel))
					{
						$sty = $sty."<small style='float: left !important; padding: 5px !important;'><span class='channelspan' title='Channel: ".ucfirst(strtolower(str_replace('_', ' ', $channelsList[$mtl->channel])))."'>".ucfirst(strtolower(substr($channelsList[$mtl->channel], 0, 1)))."</span></small>";
					}

					if(isset($mtl->debitCardId))
					{
						$sty = $sty."<small style='float: left !important; padding: 5px !important;'><span class='paymentmodespan' title='Payment Mode: Bevura Card'><i class='fa fa-credit-card'></i></span></small>";
					}
					else
					{
						if(isset($mtl->debitAccountId))
							$sty = $sty."<small style='float: left !important; padding: 5px !important;'><span class='paymentmodespan' title='Payment Mode: Bevura Wallet'><i class='fa fa-wallet'></i></span></small>";
					}
					
					
					$dt_['serviceType'] = $sty;
					$dt_['detail'] = isset($mtl->details) && $mtl->details!= null ? $mtl->details: 'N/A';
					$dt_['status'] = '<small><span class="'.strtolower(str_replace('_', ' ', $statusList[$mtl->status])).'status">'.strtoupper(strtolower(str_replace('_', ' ', $statusList[$mtl->status]))).'</span></small>';
					$dt_['amount'] = number_format($mtl->amount, 2, '.', ',');
					$dt_['totalCharges'] = number_format(getDoubleNumb(isset($mtl->fixedCharge) ? $mtl->fixedCharge : 0) + 
						getDoubleNumb(isset($mtl->transactionPercentage) ? $mtl->transactionPercentage : 0) + 
						getDoubleNumb(isset($mtl->schemeTransactionCharge) ? $mtl->schemeTransactionCharge : 0) + 
						getDoubleNumb(isset($mtl->transactionCharge) ? $mtl->transactionCharge : 0), 2, '.', ',');
					$dt_['totalAmountDebited'] = number_format($mtl->amount + ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
						(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');
					$dt_['creditAccountTrue'] = isset($mtl->creditAccountTrue) ? $mtl->creditAccountTrue : false;
					$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
					$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
					$dt_['debitCardTrue'] = isset($mtl->debitCardTrue) ? $mtl->debitCardTrue: false;
					$dt_['summary'] = isset($mtl->summary) ? $mtl->summary: null;
					$dt_['transactionDetail'] = isset($mtl->transactionDetail) ? $mtl->transactionDetail: null;
					$dt_['balance'] = isset($mtl->currentCardBalance) ? number_format($mtl->currentCardBalance, 2, '.', ',') : (isset($mtl->currentAccountBalance) ? number_format($mtl->currentAccountBalance, 2, '.', ',') : 'N/A');
					$dt_['currentPoolAccountBalance'] = isset($mtl->currentPoolAccountBalance) ? number_format($mtl->currentPoolAccountBalance, 2, '.', ',') : 'N/A';
					$str = "";


					$str = $str . '<div class="btn-group mr-1 mb-1">';
					$str = $str.'<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>';
					$str = $str . '<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">';

					if ($statusList[$mtl->status] == 'PENDING') {
						if($user->role_code==\App\Models\Roles::$ACCOUNTANT)
						{
							$str = $str . '<a class="dropdown-item" href="/accountant/transaction/confirm-transaction/' . $y . '">Confirm Transaction</a>';
						}
					}
		            		if($user->role_code==\App\Models\Roles::$ACCOUNTANT)
					{
						$str = $str . '<a style="cursor: pointer !important" class="dropdown-item" onclick="viewJournalEntries(' . $y . ')">View Journal Entries</a>';
						if(isset($dt_['isReversed']) && $dt_['isReversed']==true)
						{

						}
						else
						{
							$str = $str . '<a style="cursor: pointer !important" class="dropdown-item" onclick="viewReverseTransaction(' . $y . ')">Reverse Transaction</a>';
						}
					}
					$str = $str . '</div>';
					$str = $str . '</div>';
					$dt_['action'] = $str;
					$dt_['customerId'] = isset($mtl->customerId) && $mtl->customerId!=null ?  (($mtl->customerId)) : '';
					$dt_['recipientDetails'] = isset($mtl->recipientDetails) && $mtl->recipientDetails!=null ?  (($mtl->recipientDetails)) : '';

					array_push($dt, $dt_);
				}
			}
		}
            	return response()->json(['status' => 100, 'list' => $dt]);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any card mapped to the card bin.']);
        }
	}
	catch(\Exception $e)
	{
		return response()->json(['status' => 0, 'message' => 'System error', 'ed'=> $e->getMessage(), 'el'=>$e->getLine()]);

	}
    }









    public function pullLogsList(Request $request)
    {
	try
	{

		$token = null;
        	$data = [];
		$all = [];
		$user = null;
		/*if($type!=null && $type==1)
		{
			$token = $request->get('token');
			$data['token'] = $token;
			$all = $request->all();
			unset($all['token']);

		}
		else
		{*/
			$token = $request->bearerToken();
			$user = JWTAuth::toUser($token);
			$data['token'] = \Auth::user()->token;
			$all = $request->all();
			$data['reqtype'] = isset($all['reqtype']) ? $all['reqtype'] : null;
			$data['requestMobileNumber'] = isset($all['requestMobileNumber']) ? $all['requestMobileNumber'] : null;
			$data['requestStartDate'] = isset($all['requestStartDate']) ? $all['requestStartDate'] : null;
			$data['requestEndDate'] = isset($all['requestEndDate']) ? $all['requestEndDate'] : null;

		//}



					$ap = new \App\Models\AppError();
					$ap->error_trace = json_encode($request->all());
					$ap->url = "";
					$ap->error_dump = json_encode($data);
					$ap->user_username = "";
					$ap->save();

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }
	 $filter = null;

	 $filter = $request->has('filter') ? $request->get('filter') : null;
	 $dataStr = $dataStr."&count=".(isset($all['count']) ? $all['count'] : 1000)."&filter=".($filter==null ? '' : $filter);


	//dd($dataStr);


        //dd($request->all());
		


        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/listRequestLogs';
        $server_output = sendPostRequest($url, $dataStr);
//dd($server_output);
        $result = json_decode($server_output);
//dd($result);
	


        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'server_output'=>$server_output, 'success'=>false], 200);
        }


        $channelsList = array_keys(getAllChannel());
        $statusList = array_keys(getAllTransactionStatus());
        $currencyList = array_keys(getAllCurrency());
        $serviceTypesList = array_values(getAllServiceTypes());
	 $x11 = 1;
//dd($result);
        if($result->status === 5000)
        {
            $requestLogsList = $result->request_logs;

            $dt = [];
            	return response()->json(['status' => 100, 'list' => $requestLogsList]);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any card mapped to the card bin.']);
        }
	}
	catch(\Exception $e)
	{
		return response()->json(['status' => 0, 'message' => 'System error', 'ed'=> $e->getMessage(), 'el'=>$e->getLine()]);

	}
    }





	public function postReverseTransaction(Request $request)
	{
		try
		{
			$all = $request->all();

			$dataStr = "transactionId=".$all['transactionId']."&deviceCode=".$all['deviceCode']."&token=".\Auth::user()->token;


        		//dd($dataStr );
					


        		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/TransactionServicesV2/reverseTransaction';
        		$server_output = sendPostRequest($url, $dataStr);

			$result = json_decode($server_output);
			if($result==null)
        		{
            			return response()->json(['message' => 'Error encountered', 'server_output'=>$server_output, 'success'=>false], 200);
        		}

			return response()->json(['status' => 100, 'list' => $all]);
		}
		catch(\Exception $e)
		{
			return response()->json(['status' => 0, 'message' => 'System error', 'ed'=> $e->getMessage(), 'el'=>$e->getLine()]);
		}
	}



	public function pullReversalList(Request $request, $type=NULL)
    	{
	try
	{

		$token = null;
        	$data = [];
		$all = [];
		$user = null;
		if($type!=null && $type==1)
		{
			$token = $request->get('token');
			$data['token'] = $token;
			$all = $request->all();
			unset($all['token']);
			//dd($data);
		}
		else
		{
			$token = $request->bearerToken();
			$user = JWTAuth::toUser($token);
			$data['token'] = \Auth::user()->token;
			$all = $request->all();

		}

	//dd($data);

					$ap = new \App\Models\AppError();
					$ap->error_trace = json_encode($request->all());
					$ap->url = "";
					$ap->error_dump = json_encode($data);
					$ap->user_username = "";
					$ap->save();

        
	$dataStr = "";
	foreach($data as $a1 => $a2)
	{
		$dataStr = $dataStr ."&".$a1."=".urlencode($a2);
	}


	//dd($data);

	//dd($dataStr );
       //dd($request->all());
					


        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/TransactionServicesV2/listReversalRequests';
	//dd($token."".$url."");
        $server_output = sendGetRequest($url, $dataStr);
	 //dd($server_output);
        $result = json_decode($server_output);
	//dd($token."".$url."".$server_output);

	


        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'server_output'=>$server_output, 'success'=>false], 200);
        }

	 //dd($result);
        $statusList = array_keys(getAllTransactionStatus());
        $x11 = 1;
        if($result->status === 5000)
        {
            $transactionList = $result->reversalRequests;

            $dt = [];
		
		
            	return response()->json(['status' => 100, 'list' => $transactionList ]);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any card mapped to the card bin.']);
        }
	}
	catch(\Exception $e)
	{
		return response()->json(['status' => 0, 'message' => 'System error', 'ed'=> $e->getMessage(), 'el'=>$e->getLine()]);

	}
    }


    public function postUpdateVillageBankGroupSettings(Request $request)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        $all = $request->all();
        //dd($all);



        $data = array();
        $data['token'] = $user->token;
        $data['groupData'] = urlencode($all['villageBankingGroupSettingsEncInfo']);
        $data['vbsettingsgroupId'] = $all['vbsettingsgroupId'];
        $data['registrationFees'] = isset($all['villageBankingSettingsRegistrationFees']) && $all['villageBankingSettingsRegistrationFees']>0 ? $all['villageBankingSettingsRegistrationFees'] : null;
        $data['registrationFeesApplicable'] = isset($all['villageBankingSettingsRegistrationFees']) && $all['villageBankingSettingsRegistrationFees']>0 ? 1 : 0;
        $data['membershipfees'] = isset($all['villageBankingSettingsMembershipFees']) && $all['villageBankingSettingsMembershipFees']>0 ? $all['villageBankingSettingsMembershipFees'] : null;
        $data['membershipFeesCheckbox'] = isset($all['villageBankingSettingsMembershipFees']) && $all['villageBankingSettingsMembershipFees']>0 ? 1 : null;
        $data['constitution'] = ($all['villageBankingSettingsRules']);
        $data['membershipFeesCheckbox'] = $all['villageBankingSettingsMembershipFees']>0 && $all['villageBankingSettingsMembershipFeesIntervalType']!=-1 && $all['villageBankingSettingsMembershipFeesPeriod']>0 ? 1 : null;
        if($all['villageBankingSettingsMembershipFeesIntervalType']=='ONCE')
        {
            $data['every_only'] = 'Once';
            $data['membershipintervaltype'] = ($all['villageBankingSettingsMembershipFeesIntervalType']);
            $data['membershipinterval'] = 1;
            $data['numberOfTimes'] = 1;
        }
        else
        {
            if(in_array($all['villageBankingSettingsMembershipFeesIntervalType'], ['DAY', 'WEEK', 'MONTH', 'YEAR']))
            {
                $data['every_only'] = 'Every';
                $data['membershipintervaltype'] = ($all['villageBankingSettingsMembershipFeesIntervalType']);
                $data['membershipinterval'] = 1;
                $data['numberOfTimes'] = $all['villageBankingSettingsMembershipFeesPeriod'];
            }
        }


        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        //dd($dataStr);

        $url = 'https://smartcoops.org/api/update-cooperative-dues';
        $server_output = sendPostRequest($url, $dataStr);
        $result = json_decode($server_output);



        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }
        if($result->status === 0)
        {
            $dt = [];
            $villageBankGroup = \App\Models\VillageBankGroup::where('cooperative_code', '=', $all['vbsettingsgroupId'])->first();

            $villageBankingSetting = \App\Models\VillageBankGroupSetting::where('village_bank_group_id', '=', $villageBankGroup->id)->first();

            if($villageBankingSetting==null)
            {
                $settings = [];
                $villageBankingSetting = new \App\Models\VillageBankGroupSetting();
                $villageBankingSetting->village_bank_group_id = $villageBankGroup->id;
                $villageBankingSetting->settings = 1;
            }

            $dt['status'] = 100;
            $dt['success'] = true;
            $dt['message'] = 'Your village banking group settings have been updated successfully.';
            return response()->json($dt);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            $msg = isset($result->message) && $result->message!=null ? $result->message : null;
            return response()->json(['status' => 0, 'message' => $msg!=null ? $msg : 'Your village banking group settings could not be saved. Please try again']);
        }

    }


    public function postCreateNewVillageBankGroup(Request $request)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        $all = $request->all();

        $data = array();
        $data['token'] = $user->token;
        $data['company_name'] = ($all['villageBankingGroupName']);
        $data['company_address'] = ($all['villageBankingContactAddress']);
        $data['company_email'] = ($all['villageBankingEmail']);
        $data['pri_phone'] = ($all['villageBankingMobileNumber']);
        $data['countryCode'] = ($all['villageBankingMobileNumberCode']);
        $data['isOpen'] = ($all['isOpen']);
        $data['thirdPartySystem'] = 1;
        $data['addCompanyAdmin'] = 1;
        $data['position'] = 'ADMINISTRATOR';
        $data['canlogin'] = 1;
        $data['firstname'] = ($user->firstName);
        $data['lastname'] = ($user->lastName);
        $data['countryCode'] = (substr($user->username, 0, 3));
        $data['countrycode'] = (substr($user->username, 0, 3));
        $data['mobilenumber'] = (substr($user->username, 3));
        $data['emailaddress'] = (is_null($user->userEmail) ? $all['villageBankingEmail'] : $user->userEmail);
        $data['allPersonnelCount'] = 1;
        $data['autoGeneratePassword'] = 1;
        $data['generateOtp'] = 1;
        $data['returnPassword'] = 1;
        $data['roletype'] = ('COMPANY ADMIN');


        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        //dd($dataStr);

        $url = 'https://smartcoops.org/api/create-new-cooperative';
        $server_output = sendPostRequest($url, $dataStr);
        $result = json_decode($server_output);

        //dd($result);

        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }
        if($result->status === 0)
        {
            $dt = [];
            $villageBankGroup = new \App\Models\VillageBankGroup();
            $villageBankGroup->group_name = $all['villageBankingGroupName'];
            $villageBankGroup->group_public_key = $result->third_party_public_key;
            $villageBankGroup->cooperative_code = $result->cooperative_code;
            $villageBankGroup->cooperative_id = $result->cooperative_id;
            $villageBankGroup->bgColor = mt_rand(0, sizeof(colorBands()) - 1);
            $villageBankGroup->save();

            $pswdEnc = encrypt_msg_rsa($result->password, $result->third_party_public_key);

            $villageBankGroupMember = new \App\Models\VillageBankGroupMember();
            $villageBankGroupMember->village_bank_group_id = $villageBankGroup->id;
            $villageBankGroupMember->full_name = $user->firstName." ".$user->lastName;
            $villageBankGroupMember->role_type = 'COMPANY ADMIN';
            $villageBankGroupMember->username = $user->username;
            $villageBankGroupMember->password = ($pswdEnc);
            $villageBankGroupMember->status = 'Inactive';
            $villageBankGroupMember->otp = $result->otp;
            $villageBankGroupMember->smartcoops_user_guest_data = $result->guest_signup_code;
            $villageBankGroupMember->save();

            $dt['vbid'] = $villageBankGroup->id;
            $dt['status'] = 100;
            $dt['success'] = true;
            $dt['pd'] = $result->password;
            $dt['message'] = 'Your new village banking group has been created for you.';
            return response()->json($dt);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            $msg = isset($result->message) && $result->message!=null ? $result->message : null;
            return response()->json(['status' => 0, 'message' => $msg!=null ? $msg : 'Your village banking group could not be created. Please try again']);
        }
    }



    public function postVillageBankingRemoveGroupMember(Request $request, $type=NULL)
    {

        $token = $request->bearerToken();

        		$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
			}

	//return response()->json(['data' => $data], 200);
        $dataStr = "";

        $data['groupId'] = $all ['groupId'];
        $data['removeCustomerId'] = $all ['groupMemberCustomerId'];
	 

        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }

	//return response()->json(['data' => $data], 200);

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/removeGroupMember';
        $server_output = sendPostRequest($url, $dataStr);
                //dd($authDataStr);
        $authData = json_decode($server_output);

        if ($authData->status == -1) {
		return response()->json(['message' => 'Login to continue', 'success'=>false, 'status'=>-1], 200);
	}
	else {
		return response()->json(['data' => $authData, 'success'=>true, 'status'=>100], 200);
	}

    }



    public function postValidateVillaBankMemberOtp(Request $request)
    {

        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        $all = $request->all();

        $vbGroup = \App\Models\VillageBankGroup::where('id', '=', $all['vbotpgroupId'])->first();
        $vbMember = \App\Models\VillageBankGroupMember::where('village_bank_group_id', '=', $all['vbotpgroupId'])
            ->where('username', '=', $user->username)->first();
        $data = array();
        $data['token'] = $user->token;
        $data['username'] = $user->username;
        $data['password'] = urlencode($vbMember->password);
        $data['otp'] = ($all['vbotp1']."".$all['vbotp2']."".$all['vbotp3']."".$all['vbotp4']."".$all['vbotp5']."".$all['vbotp6']);
        $data['group_code'] = $vbGroup->cooperative_code;
        //$data['token'] = $all['vbotpgroupId'];

        //dd($data);


        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        //dd($dataStr);

        $url = 'https://smartcoops.org/api/validate-group-member-otp';

        $server_output = sendPostRequest($url, $dataStr);
        $result = json_decode($server_output);




        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }
        if($result->status === 0)
        {

            $dt['vbid'] = $vbGroup->id;
            $dt['status'] = 100;
            $dt['success'] = true;
            $dt['message'] = 'Your village banking account has been activated. You can start using your account';
            return response()->json($dt);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            $msg = isset($result->message) && $result->message!=null ? $result->message : null;
            return response()->json(['status' => 0, 'message' => $msg!=null ? $msg : 'Your village banking account could not be activated. Please try again']);
        }
    }



    public function pullUtilitiesPaidList(Request $request)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        $data = array();
        $data['token'] = $user->token;
        $data['deviceCode'] = $request->get('deviceCode');
        if($user->role_code==\App\Models\Roles::$CUSTOMER)
            $data['customerVerificationNumber'] = $user->customerVerificationNo;

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        //dd($dataStr);

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/TransactionServicesV2/listUtilitiesPaid';
        $server_output = sendGetRequest($url, $dataStr);
        $result = json_decode($server_output);




        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }

	 $channelsList = array_keys(getAllChannel());
        $currencyList = array_keys(getAllCurrency());
	 $serviceTypesList = array_keys(getAllServiceTypes());


        if($result->status === 410)
        {
            $transactionList = $result->transactionList;
//dd($transactionList);
            $dt = [];

            if($user->role_code==\App\Models\Roles::$CUSTOMER)
            {
                foreach ($transactionList as $mtl) {
                    $y = $mtl->id;
                    $dt_ = [];
                    $dt_['status'] = ucfirst(strtolower(str_replace('_', ' ', $mtl->status)));
                    $dt_['transactionDate'] = date('Y, M d H:i', strtotime($mtl->created_at)) . '';
                    $dt_['transactionRef'] = strtoupper(strtolower($mtl->transactionRef));
                    $dt_['transactionDetail'] = isset($mtl->transactionDetail) && $mtl->transactionDetail != null ? $mtl->transactionDetail : 'N/A';
                    $dt_['utilityType'] = ((str_replace('_', ' ', $mtl->utilityType)));
                    $dt_['amount'] = $mtl->probasePayCurrency . number_format($mtl->amount, 2, '.', ',');
		      $dt_['currency'] =$mtl->probasePayCurrency;

                    array_push($dt, $dt_);
                }


            }
            else {
		  $i = 1;
                foreach ($transactionList as $mtl) {
                    $y = $mtl->id;
                    $dt_ = [];
                    $dt_['sno'] = $i++;
                    $dt_['orderRef'] = strtoupper(strtolower($mtl->orderRef));
                    $dt_['transactionRef'] = strtoupper(strtolower($mtl->transactionRef));
                    $dt_['vendor'] = strtoupper(strtolower($mtl->vendor));
                    $dt_['transactionYear'] = date('Y', strtotime($mtl->created_at));
                    $dt_['transactionMonth'] = date('M', strtotime($mtl->created_at));
                    $dt_['amount'] = number_format($mtl->amount, 2, '.', ',');
                    $dt_['utilityIdentifier'] = isset($mtl->utilityIdentifier) && $mtl->utilityIdentifier!=null ? strtoupper(strtolower($mtl->utilityIdentifier)) : "N/A";
                    $dt_['status'] = $mtl->status;//ucfirst(strtolower(str_replace('_', ' ', $statusList[$mtl->status])));
                    $dt_['transactionDate'] = date('Y, M d H:i', strtotime($mtl->created_at));
                    $dt_['payerName'] = isset($mtl->payerName) && $mtl->payerName!=null ? strtoupper(strtolower($mtl->payerName)) : "N/A";
                    $dt_['amountDebited'] = number_format($mtl->amount, 2, '.', ',');
		      $dt_['currency'] =$mtl->probasePayCurrency;
                    $dt_['accountNo'] = isset($mtl->merchantAccount) && $mtl->merchantAccount != null ? $mtl->merchantAccount : 'N/A';
                    $dt_['channel'] = isset($mtl->channel) && $mtl->channel!=null ? ucfirst(strtolower(str_replace('_', ' ', $channelsList[$mtl->channel]))) : "N/A";
                    $dt_['serviceType'] = isset($mtl->serviceType) ? ((str_replace('_', ' ', $serviceTypesList[$mtl->serviceType]))) : "N/A";
                    

                    $str = "";


                    $str = $str . '<div class="btn-group mr-1 mb-1">';
                    //$str = $str.'<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>';
                    $str = $str . '<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">';

                    if ($mtl->status == 'PENDING') {
				if($user->role_code==\App\Models\Roles::$ACCOUNTANT)
				{
                        		$str = $str . '<a class="dropdown-item" href="/potzr-staff/transaction/confirm-transaction/' . $y . '">Confirm Transaction</a>';
				}
                    }
                    $str = $str . '</div>';
                    $str = $str . '</div>';
                    $dt_['action'] = $str;

                    array_push($dt, $dt_);
                }
            }
            return response()->json(['status' => 100, 'list' => $dt]);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any card mapped to the card bin.']);
        }
    }

    public function postCreateBank(Request $request)
    {
        $input = $request->all();
        //$allowedCurrency = $input['allowedCurrency'];
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        $data = array();
        $data['token'] = $user->token;

        $dataStr = "";


        //dd($dataStr);
        //$data['allowedCurrency'] = join('###', $input['allowedCurrency']);
        $data['bankName'] = $input['bankName'];
        $data['bankCode'] = $input['bankCode'];
        $data['liveBankCode'] = $input['liveBankCode'];
	 $data['countryId'] = $input['operationCountry'];
        $data['onlineBankingUrl'] = $input['onlineBankingURL'];
        $data['bicCode'] = $input['bicCode'];
        $data['token'] = \Auth::user()->token;
	 if(isset($input['bankId']) && $input['bankId']!=null)
	 {
        	$data['bankId'] = $input['bankId'];
	 }



        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BankServicesV2/createNewBank';
        $server_output = sendPostRequest($url, $dataStr);
        $result = json_decode($server_output);



        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }


        if (handleTokenUpdate($result) == false) {
            return response()->json(['success' => false, 'status' => -1, 'message' => 'Login session expired. Please relogin again']);
        }

        if ($result->status == 6000058) {
            return response()->json(['success' => true, 'status' => 100, 'message' => 'Your bank has been created/updated successfully']);
        } else {
            return response()->json(['success' => false, 'status' => 1, 'message' => 'Your bank could not be created/updated successfully']);
        }
    }




    public function postCreateIssuer(Request $request)
    {
        $input = $request->all();
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        $data = array();
        $data['token'] = $user->token;

        $dataStr = "";


        //dd($dataStr);
        $data['issuerName'] = $input['issuerName'];
        $data['issuerCode'] = $input['issuerCode'];
	 if(isset($input['issuerId']) && $input['issuerId']!=null && strlen(trim($input['issuerId']))>0)
        	$data['issuerId'] = $input['issuerId'];


        $data['token'] = \Auth::user()->token;

        //dd($data);
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BankServicesV2/createNewIssuer';
        $server_output = sendPostRequest($url, $dataStr);
        $result = json_decode($server_output);





        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }


        if (handleTokenUpdate($result) == false) {
            return response()->json(['success' => false, 'status' => -1, 'message' => 'Login session expired. Please relogin again']);
        }

        if ($result->status == 6000059) {
            return response()->json(['success' => true, 'status' => 100, 'message' => 'Your issuer has been created/updated successfully']);
        } else {
            return response()->json(['success' => false, 'status' => 1, 'message' => 'Your issuer could not be created/updated successfully']);
        }
    }


    public function getUserList(Request $request, $role=NULL)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        //dd($token);
        //dd($user);
        //dd(JWTAuth::parseToken()->authenticate());

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UserServicesV2/listAllUsers';
        $data = 'token='.$user->token;


        if($role!=null)
            $data = $data."&urole=".getRoleTypesByCustomKey($role);
        //dd($url);
        $server_output = sendGetRequest($url, $data);
        $server_output = json_decode($server_output);
//return response()->json(['data' => $server_output, 'success'=>true], 200);
        //dd($server_output);
        if($server_output==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }
	 $allDt = [];
        if($server_output->status==5000)
        {
            
            foreach($server_output->userList as $us)
            {

                $dt = [];
                $y = $us->id;
                $dt['full_name'] = $us->firstName." ".$us->lastName.(isset($us->otherName) && $us->otherName!=null ? ' '.$us->otherName : '');
                $dt['username'] = $us->username;//."".json_encode($us);
                $dt['mobile_number'] = isset($us->mobileNo) && $us->mobileNo!=null ? $us->mobileNo : 'N/A';
                $dt['email_address'] = isset($us->userEmail) && $us->userEmail!=null ? $us->userEmail : 'N/A';
                $dt['role'] = ucfirst(strtolower(str_replace('_', ' ', allRoleTypes()[$us->roleType])));
                $dt['status'] = ucfirst(strtolower(str_replace('_', ' ', allUserStatus()[$us->status])));

                $str = "";



                $str = $str.'<div class="btn-group mr-1 mb-1">';;
                $str = $str.'<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>';
                $str = $str.'<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">';


		  if(allRoleTypes()[$us->roleType]!='CUSTOMER')
		  {
                	$str = $str.'<a class="dropdown-item" href="/potzr-staff/users/view-merchant-account/'.$y.'">Update User</a>';
		  }
		  else
		  {
                	$str = $str.'<a class="dropdown-item" href="/potzr-staff/users/resend-user-credentials/'.$y.'">Resend User Credentials</a>';
		  }


                if($us->status==3)
                {
                    $str = $str.'<a class="dropdown-item" href="/potzr-staff/users/manage-user-status/'.$y.'/unlock">Unlock User Account</a>';
                }
                if(allUserStatus()[$us->status]=='ACTIVE')
                {
                    $str = $str.'<a class="dropdown-item" href="/potzr-staff/users/manage-user-status/'.$y.'/disable">Disable User Account</a>';
                }
                else if(allUserStatus()[$us->status]=='ADMIN_DISABLED')
                {
                    $str = $str.'<a class="dropdown-item" href="/potzr-staff/users/manage-user-status/'.$y.'/enable">Enable User Account</a>';
                }

                $str = $str.'</div>';
                $str = $str.'</div>';
                $dt['action'] = $str;
                array_push($allDt, $dt);
            }
        }
        //, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
        return response()->json(['data' => $allDt, 'success'=>true], 200);
    }






    public function getApplicationSettings(Request $request)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        //dd($token);
        //dd($user);
        //dd(JWTAuth::parseToken()->authenticate());

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/getApplicationSetting';
        $data = 'token='.$user->token;


        $server_output = sendGetRequest($url, $data);
        $server_output = json_decode($server_output);

        //dd($server_output);
        if($server_output==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }
        if($server_output->status==5000)
        {
            return response()->json(['data' => $server_output, 'success'=>true], 200);
        }
        if($server_output->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        //, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
        return response()->json(['message' => $server_output->message, 'success'=>false], 200);
    }



    public function postUpdateSettings(Request $request)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);
        $input = $request->all();

        //dd($input);

        $data['token'] = \Auth::user()->token;
        $data['appSettings'] = json_encode($input);
        //dd($data);

        $dataStr = "";

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/updateApplicationSetting';
        //$data = 'token='.$user->token;
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".($v==null ? "" : $v)."&";
        }

        //dd($dataStr);


        $result = sendPostRequest($url, $dataStr);
        $result = json_decode($result);
        //dd($result);

        $txnList = ($result);

        if(handleTokenUpdate($result)==false)
        {
            return response()->json(['status' => -1, 'msg'=>'Login session expired. Please relogin again']);
        }


        if($result->status == 5000)
        {
            return response()->json(['message' => 'Updating Application Settings Completed!', 'success'=>true], 200);
        }else
        {
            return response()->json(['message' => 'Updating Application Settings Failed!', 'success'=>false], 200);
        }
    }


    public function postTransferWalletToCard(Request $request)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);
        $input = $request->all();
        $amount = $input['amountAccountOverViewTransferToCard'];
        $cardReceipient = $input['cardAccountOverViewTransferToCard'];
        $cardReceipient = explode('|||', $cardReceipient);

        //dd($input);

        $data = [];
        $data['token'] = \Auth::user()->token;


        $result = null;
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/getCustomerDashboardStatistics';
        $authDataStr = sendPostRequest($url, $dataStr);
        //dd($authDataStr);
        $authData = json_decode($authDataStr);
        //dd($authData);
        $accounts = null;
        $cards = null;
        if($authData->status==5000) {
            $accounts = $authData->accounts;
            $cards = $authData->cards;

            if($accounts!=null && sizeof($accounts)>0) {
                $account = $accounts[0];
                $data = [];
                $data['token'] = \Auth::user()->token;
                $data['accountIdentifier'] = $account->accountIdentifier;
                $data['amount'] = $amount;
                $data['channel'] = "WEB";
                $data['cardTrackingId'] = $cardReceipient[0];
                $data['cardSerialNo'] = $cardReceipient[1];


                $result = null;
                $dataStr = "";
                foreach ($data as $d => $v) {
                    $dataStr = $dataStr . "" . $d . "=" . $v . "&";
                }
                $url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/WalletServicesV2/fundCardFromWallet';
                $authDataStr = sendPostRequest($url, $dataStr);
                //dd($authDataStr);
                $authData = json_decode($authDataStr);
                //dd($authData);
                $accounts = null;
                $cards = null;
                if ($authData->status == 5000) {
                    return response()->json(['message' => 'Funds transfered successfully.', 'success'=>true, 'status'=>100, 'transferOrderRef'=> $authData->orderRef, 'newBalance'=> $authData->newBalance, 'accountIdentifier' => $authData->accountIdentifier, 'receipientInfo'=>$authData->receipientInfo, 'amountTransferred'=> $authData->amountTransferred], 200);
                } else if ($authData->status == -1) {
                    return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1, 'accountIdentifier' => $authData->accountIdentifier], 200);
                } else {
                    return response()->json(['message' => $authData->message, 'success'=>true, 'status'=>$authData->status, 'accountIdentifier' => $authData->accountIdentifier], 200);
                }
            }
        }
        else if($authData->status==-1) {
            return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1, 'accountIdentifier' => $authData->accountIdentifier], 200);
        }



    }


    public function getCardTransactionByOrderRef(Request $request, $orderRef, $cardSerialNo)
    {
        $token = $request->bearerToken();
        $user = JWTAuth::toUser($token);

        $merchantCode = PROBASEWALLET_MERCHANT_CODE;
        $deviceCode = PROBASEWALLET_DEVICE_CODE;
        $apiKey = PROBASEKEY;

        //$toHash = "$orderRef$apiKey$merchantCode";
        //$hash = hash('sha512', $toHash);
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/TransactionServicesV2/getTransactionStatus';
        $data = 'orderRef='.urlencode($orderRef).'&token='.$user->token;
        $data = $data."&cardSerialNo=".$cardSerialNo;
        /*if($merchantCode!=null)
            $data = $data."&merchantCode=".$merchantCode;
        if($deviceCode!=null)
            $data = $data."&deviceCode=".$deviceCode;
        if($deviceCode!=null)
            $data = $data."&hash=".$hash;*/
        //dd($url);
        $accountBalance = sendGetRequest($url, $data);

        //dd($accountBalance);
        if($accountBalance==null)
        {
            $accountBalance = [];
        }
        else
        {
            $accountBalance = json_decode($accountBalance);
        }
        //, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
        return response()->json(['data' => ['transactionStatus' => $accountBalance], 'success'=>true], 200);
    }


	public function getEncryptData($str)
	{
		$defaultAcquirer = \App\Models\Acquirer::where('id', '=', 1)->first();
		$ar = $defaultAcquirer->toArray();
		//dd($ar['accessExodus']);
		$st = \Crypt::encryptPseudo($str, true, $ar['accessExodus']);
		dd([$ar['accessExodus'], $st]);
	}

    public function postTransferFunds(Request $request, $type=NULL)
    {

		try
		{

			$token = null;
			$data = [];
			$all = [];
			$defaultAcquirer = null;
			$user = null;
			$input = [];
			if($type!=null && $type==1)
			{
				$all = $request->all();
				$token = $request->get('token');

				$acquirerId = $request->get('acquirerId');
				$data['token'] = $token;
				$input = $request->all();

				unset($all['token']);
				
				$defaultAcquirer = \App\Models\Acquirer::where('id', '=', $acquirerId)->first();
				$defaultAcquirer = $defaultAcquirer->toArray();
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
				$input = $request->all();
				
				$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
				$defaultAcquirer = $defaultAcquirer->toArray();
			}


$ap = new \App\Models\AppError();
						$ap->error_trace = json_encode($all);
						$ap->url = "";
						$ap->error_dump = json_encode($all);
						$ap->user_username = "";
						$ap->save();

			$data['merchantId'] = $all['merchantId'];
			$data['deviceCode'] = $all['deviceCode'];
			$data['acquirerId'] = $all['acquirerId'];
			$input = $all;
			//return response()->json($data);
			//return response()->json(['message' => $defaultAcquirer], 200);


			$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');

			
			if($input['internalFundsTransferTransferType']=='WALLET_TO_CARD')
			{
				
				$amount = doubleval($input['internalFundsTransferTransferAmount']);
				$cardReceipient = $input['internalFundsTransferTransferCardTrackingId'];
				$firstFour = $input['internalFundsTransferTransferCardFirstFour'];
				$lastFour = $input['internalFundsTransferTransferCardLastFour'];
				$appId = $input['appId'];
				$cardSerialNo = isset($input['internalFundsTransferTransferCardSerialNo']) ? $input['internalFundsTransferTransferCardSerialNo'] : null;
				$cardRecipientPan = isset($input['internalFundsTransferTransferCardHashedPan']) ? $input['internalFundsTransferTransferCardHashedPan'] : null;
				
				//dd($input);



				$result = null;
				$dataStr = "";
				foreach($data as $d => $v)
				{
					$dataStr = $dataStr."".$d."=".$v."&";
				}
				//return response()->json(['dd' => $data], 200);
				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/getCustomerDashboardStatistics';
				$authDataStr = sendPostRequest($url, $dataStr);
				//dd($authDataStr);
				$authData = json_decode($authDataStr);
				//dd($authData);
				$accounts = null;
				$cards = null;
				if($authData->status==5000) {
					$accounts = $authData->accounts;
					$cards = $authData->cards;

					if($accounts!=null && sizeof($accounts)>0) {
						$account = $accounts[0];
						$data = [];
						$data['merchantId'] = $all['merchantId'];
						$data['deviceCode'] = $all['deviceCode'];
						if($type!=null && $type==1)
						{
							$data['token'] = $token;
							$data['amount'] = $amount;

							$data['accountIdentifier'] = $encrypterFrom->encrypt($account->accountIdentifier."");
							//\Crypt::encryptPseudo($account->accountIdentifier, true, $defaultAcquirer['accessExodus']);
							//return response()->json(['message' => $data['accountIdentifier']], 200);

							//\Crypt::encryptPseudo($cardReceipient_[0], true, $defaultAcquirer['accessExodus']);
							$data['serviceTypeId'] = 'FT_WALLET_TO_CARD';
							if($cardSerialNo!=null)
							{
								$data['cardSerialNo'] = $encrypterFrom->encrypt($cardSerialNo."");
								$cardReceipient_ = explode('|||', $cardReceipient);
								$data['cardTrackingId'] = $encrypterFrom->encrypt($cardReceipient_[0]."");
							}
							else
							{
								$data['cardTrackingId'] = $encrypterFrom->encrypt($cardReceipient."");
							}

							$data['channel'] = $input['channel'];
						}
						else
						{
							$data['token'] = \Auth::user()->token;
							$data['accountIdentifier'] = $account->accountIdentifier;
							$data['amount'] = $amount;
							$data['channel'] = "WEB";
							$data['cardTrackingId'] = $cardReceipient;
						}
							$data['firstFour'] = $encrypterFrom->encrypt($firstFour ."");
							$data['lastFour'] = $encrypterFrom->encrypt($lastFour ."");
						//return response()->json($data);
						$merchantId = $data['merchantId'];
						$deviceCode = $data['deviceCode'];
						$serviceTypeId = $data['serviceTypeId'];
						$orderId = $input['orderRef'];
						$amount = $data['amount'];
						$rt = $input['rt'];
						$data['rt'] = $rt;
						$data['orderRef'] = $orderId;
						$data['appId'] = $appId;
						$apkey = PROBASEKEY;
						$amount= (number_format($amount , 2, '.', ''));
						$toHash = "$merchantId$deviceCode$serviceTypeId$orderId$amount$rt$apkey";
						$hash = hash('sha512', $toHash);

						$data['hash'] = $hash;
						$data['otp'] = isset($all['otp']) ? $all['otp'] : null;

						$result = null;
						$dataStr = "";
						foreach ($data as $d => $v) {
							$dataStr = $dataStr . "" . $d . "=" . $v . "&";
						}
						//return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>1, 'rtr' => $cardSerialNo], 200);
						$url = null;

//return response()->json(['message' => $cardSerialNo, 'success'=>false, 'status'=>344], 200);
						if($cardSerialNo!=null)
						{
							
							$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/WalletServicesV2/fundCardFromWallet';
						}
						else
						{
							$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/WalletServicesV2/fundBeneficiaryCardFromWallet';
						}
						$authDataStr = sendPostRequest($url, $dataStr);
						
						$authData = json_decode($authDataStr);
						//dd($authData);
						$accounts = null;
						$cards = null;
						if ($authData->status == 5000) {
							return response()->json(['message' => 'Funds transfered successfully.', 'success'=>true, 'status'=>100, 'accountIdentifier' => $account->accountIdentifier], 200);
						} else if ($authData->status == -1) {
							return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1, 'accountIdentifier' => $account->accountIdentifier], 200);
						} else {
							return response()->json(['message' => $authData->message, 'success'=>true, 'status'=>$authData->status, 'accountIdentifier' => $account->accountIdentifier], 200);
						}
					}
				}
				else if($authData->status==-1) {
					return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1, 'accountIdentifier' => $authData->accountIdentifier], 200);
				}
			}


			else if($input['internalFundsTransferTransferType']=='CARD_TO_WALLET')
			{
				
				$input = $request->all();
				$amount = $input['internalFundsTransferTransferAmount'];
				$walletReceipient = $input['internalFundsTransferTransferWalletId'];
				$cardData = $input['internalFundsTransferSourceCard'];
				$orderId = strtoupper(Str::random(8));
				


				$result = null;
				$dataStr = "";
				foreach($data as $d => $v)
				{
					$dataStr = $dataStr."".$d."=".$v."&";
				}

				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/getCustomerDashboardStatistics';
				$authDataStr = sendPostRequest($url, $dataStr);
				//dd($authDataStr);
				$authData = json_decode($authDataStr);

				$accounts = null;
				$cards = null;



				if($authData->status==5000) {


						$cardData  = $encrypterFrom->encrypt($cardData."");
						$serviceTypeId = "FT_CARD_TO_WALLET";
						$data['amount'] = $amount;
						$data['cardData'] = $cardData;
						if($type!=null && $type==1)
							$data['channel'] = "MOBILE";
						else
							$data['channel'] = "WEB";

						$data['walletReceipient'] = $encrypterFrom->encrypt($walletReceipient."");
						$data['serviceTypeId'] = $serviceTypeId;
						$data['orderRef'] = $orderId;
						$data['otp'] = isset($all['otp']) ? $all['otp'] : null;

						$rt = "";
						$apkey = PROBASEKEY;
						$merchantId = $all['merchantId'];
						$deviceCode = $all['deviceCode'];
						$amount = (number_format($data['amount'], 2, '.', ''));


						$toHash = "$merchantId$deviceCode$serviceTypeId$orderId$amount$rt$apkey";
						$hash = hash('sha512', $toHash);
						$data['hash'] = $hash;

						//return response()->json(['message' => ($toHash )]);
						$result = null;
						$dataStr = "";
						foreach ($data as $d => $v) {
							$dataStr = $dataStr . "" . $d . "=" . $v . "&";
						}
						$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/WalletServicesV2/fundWalletFromCard';
						$authDataStr = sendPostRequest($url, $dataStr);
						//dd($authDataStr);
						$authData = json_decode($authDataStr);

						$accounts = null;
						$cards = null;
						if ($authData->status == 5000) {
							return response()->json(['message' => 'Funds transfered successfully to Wallet - '.$walletReceipient, 'success'=>true, 'status'=>100, 'accountIdentifier' => $walletReceipient], 200);
						} else if ($authData->status == -1) {
							return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1, 'accountIdentifier' => $walletReceipient], 200);
						} else {
							return response()->json(['message' => $authData->message, 'success'=>true, 'status'=>$authData->status, 'accountIdentifier' => $walletReceipient], 200);
						}

				}
				else if($authData->status==-1) {
					return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1, 'accountIdentifier' => $walletReceipient], 200);
				}
			}

			else if($input['internalFundsTransferTransferType']=='CARD_TO_CARD')
			{
				
				$input = $request->all();
				$amount = $input['internalFundsTransferTransferAmount'];
				$cardReceipient = $input['internalFundsTransferTransferCardTrackingId'];
				$cardDataSource = $input['internalFundsTransferSourceCard'];
				$firstFour = $input['internalFundsTransferTransferCardFirstFour'];
				$firstFourSource = $input['internalFundsTransferSourceCardFirstFour'];
				$lastFour = $input['internalFundsTransferTransferCardLastFour'];
				$lastFourSource = $input['internalFundsTransferSourceCardLastFour'];
				$serialNo = isset($input['internalFundsTransferTransferCardSerialNo']) ? $input['internalFundsTransferTransferCardSerialNo'] : null;
				$serialNoSource = $input['internalFundsTransferSourceCardSerialNo'];
				$recipientType = isset($input['recipientType']) ? $input['recipientType'] : null;
				$orderId = strtoupper(Str::random(8));
				


				$result = null;
				$dataStr = "";
				foreach($data as $d => $v)
				{
					$dataStr = $dataStr."".$d."=".$v."&";
				}

				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/getCustomerDashboardStatistics';
				$authDataStr = sendPostRequest($url, $dataStr);
				//dd($authDataStr);
				$authData = json_decode($authDataStr);

				$accounts = null;
				$cards = null;



				if($authData->status==5000) {


						//$cardData  = $encrypterFrom->encrypt($cardData."");
						$serviceTypeId = "FT_CARD_TO_WALLET";
						$data['amount'] = $amount;
						$data['cardTrackingIdDestination'] = $encrypterFrom->encrypt($cardReceipient."");
						$data['cardTrackingIdSource'] = $encrypterFrom->encrypt($cardDataSource."");
						if($type!=null && $type==1)
							$data['channel'] = "MOBILE";
						else
							$data['channel'] = "WEB";

						$data['firstFourSource'] = $encrypterFrom->encrypt($firstFourSource."");
						$data['lastFourSource'] = $encrypterFrom->encrypt($lastFourSource."");
						$data['serialNoSource'] = $encrypterFrom->encrypt($serialNoSource."");

						$data['firstFourDestination'] = $encrypterFrom->encrypt($firstFour."");
						$data['lastFourDestination'] = $encrypterFrom->encrypt($lastFour."");
						$data['appId'] = $input['appId'];
						if($serialNo!=null)
						{
							$data['serialNoDestination'] = $encrypterFrom->encrypt($serialNo."");
						}

						$data['serviceTypeId'] = $serviceTypeId;
						$data['orderRef'] = $orderId;

						$rt = "";
						$apkey = PROBASEKEY;
						$merchantId = $all['merchantId'];
						$deviceCode = $all['deviceCode'];
						$amount = (number_format($data['amount'], 2, '.', ''));


						$toHash = "$merchantId$deviceCode$serviceTypeId$orderId$amount$rt$apkey";
						$hash = hash('sha512', $toHash);
						$data['hash'] = $hash;
						$data['otp'] = isset($all['otp']) ? $all['otp'] : null;


						//return response()->json(['message' => ($toHash )]);
						$result = null;
						$dataStr = "";
						foreach ($data as $d => $v) {
							$dataStr = $dataStr . "" . $d . "=" . $v . "&";
						}

						if($recipientType!=null && $recipientType=="My Card")
							$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/WalletServicesV2/fundCardFromCard';
						else if($recipientType!=null && $recipientType=="Another Card")
							$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/WalletServicesV2/fundBeneficiaryCardFromCard';


						$authDataStr = sendPostRequest($url, $dataStr);
						//dd($authDataStr);
						$authData = json_decode($authDataStr);

						$accounts = null;
						$cards = null;
						if ($authData->status == 5000) {
							$receipientInfo = $authData->receipientInfo;
							$receipientInfo = json_decode($receipientInfo);
							return response()->json(['message' => 'Funds transfered successfully to Card - '.$receipientInfo->recepientCardIdentifier, 'success'=>true, 'status'=>100, 'sourceCardIdentifier' => $receipientInfo->sourceCardIdentifier], 200);
						} else if ($authData->status == -1) {
							return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1], 200);
						} else {
							return response()->json(['message' => $authData->message, 'success'=>true, 'status'=>$authData->status], 200);
						}

				}
				else if($authData->status==-1) {
					return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1, 'sourceCardIdentifier' => $cardData], 200);
				}
			}


			else if($input['internalFundsTransferTransferType']=='WALLET_TO_WALLET')
			{
						
				$amount = $input['internalFundsTransferTransferAmount'];
				$walletReceipient = $input['internalFundsTransferTransferWalletNumber'];

				//dd($input);
				//unset($data['token']);


				$result = null;
				$dataStr = "";
				foreach($data as $d => $v)
				{
					$dataStr = $dataStr."".$d."=".$v."&";
				}
				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/getCustomerDashboardStatistics';
				$authDataStr = sendPostRequest($url, $dataStr);
				//dd($authDataStr);
				$authData = json_decode($authDataStr);
				//dd($authData);
				$accounts = null;
				$cards = null;
				


			
				if($authData->status==5000) {

					$accounts = $authData->accounts;
					$cards = $authData->cards;

					if($accounts!=null && sizeof($accounts)>0) {
						$account = $accounts[0];
						$walletReceipient_ = $encrypterFrom->encrypt($walletReceipient."");
						//\Crypt::encryptPseudo($walletReceipient, true, $defaultAcquirer['accessExodus']);
						$accountIdentifier_ = $encrypterFrom->encrypt($account->accountIdentifier."");
						//\Crypt::encryptPseudo($account->accountIdentifier, true, $defaultAcquirer['accessExodus']);
						$orderId = strtoupper(Str::random(8));
						$data = [];
						$data['token'] = $token;
						$data['merchantId'] = $all['merchantId'];
						$data['deviceCode'] = $all['deviceCode'];
						$data['walletReceipient'] = $walletReceipient_;
						$data['accountIdentifier'] = $accountIdentifier_;
						$data['amount'] = $amount;
						$data['orderRef'] = $orderId;
						if($type!=null && $type==1)
						{
							$data['channel'] = "MOBILE";
						}
						else
						{
							$data['channel'] = "WEB";
						}
						$data['serviceTypeId'] = "FT_WALLET_TO_WALLET";
				
						$merchantId = $data['merchantId'];
						$deviceCode = $data['deviceCode'];
						$serviceTypeId = "FT_WALLET_TO_WALLET";
						$amount = (number_format($data['amount'], 2, '.', ''));
						$rt = "";
						$apkey = $defaultAcquirer['accessExodus'];
						
						$toHash = "$merchantId$deviceCode$serviceTypeId$orderId$amount$rt$apkey";
						$hash = hash('sha512', $toHash);

						$data['hash'] = $hash;
						$data['narration'] = $all['narration'];
						$data['otpRef'] = $all['otpRef'];
						$data['otp'] = $all['otp'];
						//return response()->json($data['otp']);
						
						
						//return response()->json(array_keys($data));


						$result = null;
						$dataStr = "";
						foreach ($data as $d => $v) {
							$dataStr = $dataStr . "" . $d . "=" . $v . "&";
						}
						$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/WalletServicesV2/fundWalletFromWallet';
//return response()->json($data);
						



						$authDataStr = sendPostRequest($url, $dataStr);
						//dd($authDataStr);
						$authData = json_decode($authDataStr);
						//dd($authData);
						$accounts = null;
						$cards = null;
						if ($authData->status == 5000) {
							return response()->json(['message' => 'Funds transfered successfully to '. $walletReceipient, 'data'=>$authData,  'success'=>true, 'status'=>100, 'accountIdentifier' => $walletReceipient], 200);
						} else if ($authData->status == -1) {
							return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1, 'accountIdentifier' => $walletReceipient], 200);
						} else {
							return response()->json(['message' => $authData->message, 'success'=>true, 'status'=>$authData->status, 'accountIdentifier' => $walletReceipient], 200);
						}
					}
				}
				else if($authData->status==-1) {
					return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1, 'accountIdentifier' => $walletReceipient], 200);
				}
			}


			else if($input['internalFundsTransferTransferType']=='WALLET_TO_MOBILE_NUMBER')
			{
						
				//dd($input);
				//unset($data['token']);


				$result = null;
				$dataStr = "";
				foreach($data as $d => $v)
				{
					$dataStr = $dataStr."".$d."=".$v."&";
				}
				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/getCustomerDashboardStatistics';
				$authDataStr = sendPostRequest($url, $dataStr);
				//dd($authDataStr);
				$authData = json_decode($authDataStr);
				//dd($authData);
				$accounts = null;
				$cards = null;
				
			
				if($authData->status==5000) {

					$accounts = $authData->accounts;
					$cards = $authData->cards;

					if($accounts!=null && sizeof($accounts)>0) {
						$account = $accounts[0];
						//\Crypt::encryptPseudo($walletReceipient, true, $defaultAcquirer['accessExodus']);
						$accountIdentifier_ = $encrypterFrom->encrypt($account->accountIdentifier."");
						//\Crypt::encryptPseudo($account->accountIdentifier, true, $defaultAcquirer['accessExodus']);
						$orderId = $input['orderRef'];
						$data = [];
						$data['token'] = $token;
						$data['merchantId'] = $all['merchantId'];
						$data['deviceCode'] = $all['deviceCode'];
						$data['accountIdentifier'] = $accountIdentifier_;
						$data['orderRef'] = $orderId;
										
						$merchantId = $data['merchantId'];
						$deviceCode = $data['deviceCode'];
						$serviceTypeId = "FT_WALLET_TO_MOBILE_NUMBER";
						$rt = "";
						$apkey = $defaultAcquirer['accessExodus'];
						
						$toHash = "$merchantId$deviceCode$serviceTypeId$orderId$rt$apkey";
						$hash = hash('sha512', $toHash);

						$data['hash'] = $hash;
						$data['otpRef'] = $all['otpRef'];
						$data['otp'] = $all['otp'];
						//return response()->json($data['otp']);
						//return response()->json(['message' => $data, 'success'=>true, 'status'=>$authData->status], 200);
						
						//return response()->json(array_keys($data));


						$result = null;
						$dataStr = "";
						foreach ($data as $d => $v) {
							$dataStr = $dataStr . "" . $d . "=" . $v . "&";
						}
						$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/WalletServicesV2/fundWalletToMobileNumber';
//return response()->json($data);
						



						$authDataStr = sendPostRequest($url, $dataStr);
						//dd($authDataStr);
						$authData = json_decode($authDataStr);
						//dd($authData);
						$accounts = null;
						$cards = null;
						if ($authData->status == 5000) {
							$mobileReceipient = $authData->mobileReceipient;
							return response()->json(['message' => 'Funds transfered successfully to '. $mobileReceipient, 'data'=>$authData,  'success'=>true, 'status'=>100], 200);
						} else if ($authData->status == -1) {
							return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1], 200);
						} else {
							return response()->json(['message' => $authData->message, 'success'=>true, 'status'=>$authData->status], 200);
						}
					}
				}
				else if($authData->status==-1) {
					return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1, 'accountIdentifier' => $walletReceipient], 200);
				}
			}

			else if($input['internalFundsTransferTransferType']=='BANK_TRANSFER')
			{
				//return response()->json(['message' => $orderId], 200);		
				$amount = $input['externalFundsTransferTransferAmount'];
				$accountReceipient = $input['externalFundsTransferDestinationAccount'];
				$sourceType = $input['externalFundsTransferSourceType'];
				$transferType = $input['transferMode'];
				$cardData = null;
				if($sourceType == "CARD")
				{
					$cardData = $input['externalFundsTransferSourceIdentifier'];
				}
				$sortCode = $input['externalFundsTransferBankBranchCode'];
				$bicCode = $input['externalFundsTransferBankCode'];
				$receipientName = isset($input['receipientName']) && $input['receipientName']!=null ? $input['receipientName'] : null;


				//dd($input);
				//unset($data['token']);


				$result = null;
				$dataStr = "";
				foreach($data as $d => $v)
				{
					$dataStr = $dataStr."".$d."=".$v."&";
				}
				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/getCustomerDashboardStatistics';
				$authDataStr = sendPostRequest($url, $dataStr);
				//dd($authDataStr);
				$authData = json_decode($authDataStr);
				//dd($authData);
				$accounts = null;
				$cards = null;
				
			
				if($authData->status==5000) {

					$accounts = $authData->accounts;
					$cards = $authData->cards;

					if($accounts!=null && sizeof($accounts)>0) {
						$account = $accounts[0];
						$accountReceipient_ = $encrypterFrom->encrypt($accountReceipient."");
						//\Crypt::encryptPseudo($accountReceipient, true, $defaultAcquirer['accessExodus']);
						$accountIdentifier_ = $encrypterFrom->encrypt($account->accountIdentifier."");
						//\Crypt::encryptPseudo($account->accountIdentifier, true, $defaultAcquirer['accessExodus']);
						$orderId = "BV".strtoupper(Str::random(14));
						$data = [];
						$data['token'] = $token;
						$data['merchantId'] = $all['merchantId'];
						$data['deviceCode'] = $all['deviceCode'];
						$data['destinationIdentifier'] = $accountReceipient_;
						$data['transferType'] = $transferType;
						$serviceTypeId = null;
						if($sourceType == "CARD")
						{
							$data['sourceIdentifier'] = $cardData;
							$data['serviceTypeId'] = "FT_CARD_TO_BANK";
							$data['sourceType'] = "CARD";
							$serviceTypeId = "FT_CARD_TO_BANK";
						}
						else if($sourceType == "WALLET")
						{
							$data['sourceIdentifier'] = $accountIdentifier_;
							$data['serviceTypeId'] = "FT_WALLET_TO_BANK";
							$serviceTypeId = "FT_WALLET_TO_BANK";
							$data['sourceType'] = "WALLET";
						}
						$data['sortCode'] = $sortCode;
						$data['bicCode'] = $bicCode;
						$data['receipientName'] = $receipientName;

						if(isset($all['branchCodeFromVerify']) && $all['branchCodeFromVerify']!=null)
						{
							$data['branchCodeFromVerify'] = $all['branchCodeFromVerify'];
						}
						$data['amount'] = $amount;
						$data['orderRef'] = $orderId;
						$data['receipientName'] = $receipientName;
						if($type!=null && $type==1)
						{
							$data['channel'] = "MOBILE";
						}
						else
						{
							$data['channel'] = "WEB";
						}
						
				
						$merchantId = $data['merchantId'];
						$deviceCode = $data['deviceCode'];
						
						$amount = (number_format($data['amount'], 2, '.', ''));
						$rt = "";
						$apkey = $defaultAcquirer['accessExodus'];
						
						$toHash = "$merchantId$deviceCode$serviceTypeId$orderId$amount$rt$apkey";
						$hash = hash('sha512', $toHash);

						$data['hash'] = $hash;
						$data['narration'] = $all['narration'];
						$data['otpRef'] = isset($all['otpRef']) ? $all['otpRef'] : null;
						$data['otp'] = isset($all['otp']) ? $all['otp'] : null;
						//return response()->json($data['otp']);
						
						
						//return response()->json(array_keys($data));


						$result = null;
						$dataStr = "";
						foreach ($data as $d => $v) {
							$dataStr = $dataStr . "" . $d . "=" . $v . "&";
						}
						$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/WalletServicesV2/fundBankAccountFromWalletAndCard';
//return response()->json($data);
						



						$authDataStr = sendPostRequest($url, $dataStr);
						//dd($authDataStr);
						$authData = json_decode($authDataStr);
						//dd($authData);
						$accounts = null;
						$cards = null;
						if ($authData->status == 5000) {
							return response()->json(['message' => 'Funds transfered successfully!', 'data'=>$authData,  'success'=>true, 'status'=>100], 200);
						} else if ($authData->status == -1) {
							return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1], 200);
						} else {
							return response()->json(['message' => $authData->message, 'success'=>true, 'status'=>$authData->status], 200);
						}
					}
				}
				else if($authData->status==-1) {
					return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1, 'accountIdentifier' => $walletReceipient], 200);
				}
			}

			else if($input['internalFundsTransferTransferType']=='3PARTY_WALLET_TRANSFER')
			{
				//return response()->json(['message' => $orderId], 200);		
				$amount = $input['externalFundsTransferTransferAmount'];
				$accountReceipient = $input['externalFundsTransferDestinationAccount'];
				$sourceType = $input['externalFundsTransferSourceType'];
				$transferType = $input['transferMode'];
				$cardData = null;
				if($sourceType == "CARD")
				{
					$cardData = $input['externalFundsTransferSourceIdentifier'];
				}
				
				$receipientName = isset($input['receipientName']) && $input['receipientName']!=null ? $input['receipientName'] : null;


				//dd($input);
				//unset($data['token']);


				$result = null;
				$dataStr = "";
				foreach($data as $d => $v)
				{
					$dataStr = $dataStr."".$d."=".$v."&";
				}
				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/getCustomerDashboardStatistics';
				$authDataStr = sendPostRequest($url, $dataStr);
				//dd($authDataStr);
				$authData = json_decode($authDataStr);
				//dd($authData);
				$accounts = null;
				$cards = null;
				
			
				if($authData->status==5000) {

					$accounts = $authData->accounts;
					$cards = $authData->cards;

					if($accounts!=null && sizeof($accounts)>0) {
						$account = $accounts[0];
						$accountReceipient_ = $encrypterFrom->encrypt($accountReceipient."");
						//\Crypt::encryptPseudo($accountReceipient, true, $defaultAcquirer['accessExodus']);
						$accountIdentifier_ = $encrypterFrom->encrypt($account->accountIdentifier."");
						//\Crypt::encryptPseudo($account->accountIdentifier, true, $defaultAcquirer['accessExodus']);
						$orderId = "BV".strtoupper(Str::random(14));
						$data = [];
						$data['token'] = $token;
						$data['merchantId'] = $all['merchantId'];
						$data['deviceCode'] = $all['deviceCode'];
						$data['destinationIdentifier'] = $accountReceipient_;
						$data['transferType'] = $transferType;
						$serviceTypeId = null;
						if($sourceType == "CARD")
						{
							$data['sourceIdentifier'] = $cardData;
							$data['serviceTypeId'] = "FT_CARD_TO_BANK";
							$data['sourceType'] = "CARD";
							$serviceTypeId = "FT_CARD_TO_BANK";
						}
						else if($sourceType == "WALLET")
						{
							$data['sourceIdentifier'] = $accountIdentifier_;
							$data['serviceTypeId'] = "FT_WALLET_TO_BANK";
							$serviceTypeId = "FT_WALLET_TO_BANK";
							$data['sourceType'] = "WALLET";
						}
						$data['receipientName'] = $receipientName;
						$data['amount'] = $amount;
						$data['orderRef'] = $orderId;
						$data['receipientName'] = $receipientName;
						if($type!=null && $type==1)
						{
							$data['channel'] = "MOBILE";
						}
						else
						{
							$data['channel'] = "WEB";
						}
						$data['sortCode'] = getNFSServiceIds()[$all['transferMode']];
				
						$merchantId = $data['merchantId'];
						$deviceCode = $data['deviceCode'];
						
						$amount = (number_format($data['amount'], 2, '.', ''));
						$rt = "";
						$apkey = $defaultAcquirer['accessExodus'];
						
						$toHash = "$merchantId$deviceCode$serviceTypeId$orderId$amount$rt$apkey";
						$hash = hash('sha512', $toHash);

						$data['hash'] = $hash;
						$data['narration'] = $all['narration'];
						$data['otpRef'] = isset($all['otpRef']) ? $all['otpRef'] : null;
						$data['otp'] = isset($all['otp']) ? $all['otp'] : null;
						//return response()->json([$transferType]);
						
						
						//return response()->json(array_keys($data));


						$result = null;
						$dataStr = "";
						foreach ($data as $d => $v) {
							$dataStr = $dataStr . "" . $d . "=" . $v . "&";
						}



						$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/WalletServicesV2/fundBankAccountFromWalletAndCard';
//return response()->json($data);
						



						$authDataStr = sendPostRequest($url, $dataStr);
						//dd($authDataStr);
						$authData = json_decode($authDataStr);
						//dd($authData);
						$accounts = null;
						$cards = null;
						if ($authData->status == 5000) {
							return response()->json(['message' => 'Funds transfered successfully!', 'data'=>$authData,  'success'=>true, 'status'=>100], 200);
						} else if ($authData->status == -1) {
							return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1], 200);
						} else {
							return response()->json(['message' => $authData->message, 'success'=>true, 'status'=>$authData->status], 200);
						}
					}
				}
				else if($authData->status==-1) {
					return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1, 'accountIdentifier' => $walletReceipient], 200);
				}
			}
			else if($input['internalFundsTransferTransferType']=='MMONEY_TO_WALLET')
			{
				$input = $request->all();
				//return response()->json(['message' => $input], 200);
				$amount = $input['amount'];
				$walletReceipient = $input['receipient'];
				$orderId = strtoupper(Str::random(8));
				//unset($input['token']);
				//return response()->json(['message' => $input], 200);


				$result = null;
				$dataStr = "";


				$walletReceipient1 = $walletReceipient;
				$walletReceipient = $encrypterFrom->encrypt($walletReceipient."");
				$serviceTypeId = "FUND_WALLET_BY_MOBILE_MONEY";
				$data['amount'] = number_format(($amount), 2, '.', '');
				$data['token'] = $input['token'];
				$data['merchantId'] = $input['merchantId'];
				$data['walletReceipient'] = $walletReceipient;
				$data['deviceCode'] = $input['deviceCode'];
				$data['sourceMobileNumber'] = $input['sourceMobileNumber'];
				$data['receipientType'] = "WALLET";

				if($type!=null && $type==1)
					$data['channel'] = "MOBILE";
				else
					$data['channel'] = "WEB";

				$data['orderRef'] = $orderId;
				$data['serviceTypeId'] = $serviceTypeId;

				$rt = "";
				$apkey = PROBASEKEY;
				$narration = ("MMONEYFUNDING~".$input['receipient']."~".$input['sourceMobileNumber']."~".$amount."~".$data['receipientType']);
				$merchantId = $input['merchantId'];
				$deviceCode = $input['deviceCode'];
				$data['sourceMobileNumber'] = $input['sourceMobileNumber'];
				$data['narration'] = $input['deviceCode'];
				$amount = (number_format($data['amount'], 2, '.', ''));



				$toHash = "$merchantId$deviceCode$serviceTypeId$orderId$amount$rt$apkey";
				$hash = hash('sha512', $toHash);
				$data['hash'] = $hash;

				//return response()->json(['message' => ($toHash )]);
				$result = null;
				$dataStr = "";
				foreach ($data as $d => $v) {
					$dataStr = $dataStr . "" . $d . "=" . $v . "&";
				}
				$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/WalletServicesV2/ussdPostCheckout';
				$authDataStr = sendPostRequest($url, $dataStr);
				//dd($authDataStr);
				$authData = json_decode($authDataStr);

				$accounts = null;
				$cards = null;
				if ($authData->status == 5000) {
					return response()->json(['message' => 'You will receive a prompt on the mobile number '.$input['sourceMobileNumber'].'. Enter your PIN to authorize your payment of ZMW'.$amount.' to wallet number '.$walletReceipient1, 'success'=>true, 'status'=>100, 'accountIdentifier' => $walletReceipient], 200);
				} else if ($authData->status == -1) {
					return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1, 'accountIdentifier' => $walletReceipient], 200);
				} else {
					return response()->json(['message' => $authData->message, 'success'=>true, 'status'=>$authData->status, 'accountIdentifier' => $walletReceipient], 200);
				}
				

			}

			else
			{
				$amount = $input['amountAccountOverViewTransferToCard'];
				$cardReceipient = $input['cardAccountOverViewTransferToCard'];
				$cardReceipient = explode('|||', $cardReceipient);

				//dd($input);

				$data = [];
				$data['token'] = \Auth::user()->token;


				$result = null;
				$dataStr = "";
				foreach($data as $d => $v)
				{
					$dataStr = $dataStr."".$d."=".$v."&";
				}
				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/getCustomerDashboardStatistics';
				$authDataStr = sendPostRequest($url, $dataStr);
				//dd($authDataStr);
				$authData = json_decode($authDataStr);
				//dd($authData);
				$accounts = null;
				$cards = null;
				if($authData->status==5000) {
					$accounts = $authData->accounts;
					$cards = $authData->cards;

					if($accounts!=null && sizeof($accounts)>0) {
						$account = $accounts[0];
						$data = [];
						$data['token'] = \Auth::user()->token;
						$data['accountIdentifier'] = $account->accountIdentifier;
						$data['amount'] = $amount;
						$data['channel'] = "WEB";
						$data['cardTrackingId'] = $cardReceipient[0];
						$data['cardSerialNo'] = $cardReceipient[1];


						$result = null;
						$dataStr = "";
						foreach ($data as $d => $v) {
							$dataStr = $dataStr . "" . $d . "=" . $v . "&";
						}
						$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/WalletServicesV2/fundCardFromWallet';
						$authDataStr = sendPostRequest($url, $dataStr);
						//dd($authDataStr);
						$authData = json_decode($authDataStr);
						//dd($authData);
						$accounts = null;
						$cards = null;
						if ($authData->status == 5000) {
							return response()->json(['message' => 'Funds transfered successfully.', 'success'=>true, 'status'=>100, 'accountIdentifier' => $authData->accountIdentifier], 200);
						} else if ($authData->status == -1) {
							return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1, 'accountIdentifier' => $authData->accountIdentifier], 200);
						} else {
							return response()->json(['message' => $authData->message, 'success'=>true, 'status'=>$authData->status, 'accountIdentifier' => $authData->accountIdentifier], 200);
						}
					}
				}
				else if($authData->status==-1) {
					return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1, 'accountIdentifier' => $authData->accountIdentifier], 200);
				}
			}
		}
		catch(\Exception $e)
		{
			return response()->json(['message' => 'Error encountered doing your transfer', 'dd'=>$e->getMessage(), 'dd1'=>$e->getLine()], 200);
		}



    }
	
	
	
	
	
	public function postValidateWallet(Request $request, $type=NULL)
	{
		try
		{
			$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$acquirerId = $request->get('acquirerId');
				//$data['token'] = $token;
				$all = $request->all();
				//unset($all['token']);
				$defaultAcquirer = \App\Models\Acquirer::where('id', '=', $acquirerId)->first();
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
				$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
			}

			//
			//dd($defaultAcquirer->toArray());
			if($defaultAcquirer==null)
			{
				return response()->json(['message' => 'Error encountered. ERR00AQ1', 'success'=>false], 200);
			}
			//return response()->json(['message' => $all, 'success'=>false], 200);


			$defaultAcquirer = $defaultAcquirer->toArray();
				
			$data['merchantId'] = $all['merchantId'];
			$data['deviceCode'] = $all['deviceCode'];
			$data['token'] = $all['token'];
			$data['bankAccountNo'] = $all['walletNumber'];

			if(isset($all['serviceType']) && $all['serviceType']!=null)
			{
				$data['serviceType'] = $all['serviceType'];
			}

			$data['acquirerCode'] = $defaultAcquirer['acquirerCode'];
			//return response()->json(['data' => $data, 'success'=>true], 200);
			
			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}
			//dd($dataStr);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountServicesV2/validateWalletDetails';
			$authDataStr = sendPostRequest($url, $dataStr);
			//dd($authDataStr);
			//return response()->json(['data' => $authDataStr, 'success'=>true], 200);
			$authData = json_decode($authDataStr);
			//dd($authData);
			return response()->json(['data' => $authData, 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage(), 'success'=>false], 200);
		}
	}



	
	
	
	public function validateWalletMobileNumberDetails(Request $request, $type=NULL)
	{
		try
		{
			$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$acquirerId = $request->get('acquirerId');
				//$data['token'] = $token;
				$all = $request->all();
				//unset($all['token']);
				$defaultAcquirer = \App\Models\Acquirer::where('id', '=', $acquirerId)->first();
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
				$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
			}

			//
			//dd($defaultAcquirer->toArray());
			if($defaultAcquirer==null)
			{
				return response()->json(['message' => 'Error encountered. ERR00AQ1', 'success'=>false], 200);
			}
			//return response()->json(['message' => $all, 'success'=>false], 200);


			$defaultAcquirer = $defaultAcquirer->toArray();
				
			$data['merchantId'] = $all['merchantId'];
			$data['deviceCode'] = $all['deviceCode'];
			$data['token'] = $all['token'];
			$data['bankAccountNo'] = $all['walletNumber'];

			if(isset($all['serviceType']) && $all['serviceType']!=null)
			{
				$data['serviceType'] = $all['serviceType'];
				$data['transactionAmount'] = $all['transactionAmount'];
			}

			$data['acquirerCode'] = $defaultAcquirer['acquirerCode'];
			//return response()->json(['data' => $data, 'success'=>true], 200);

			$result = null;
			$dataStr = "";

			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}
			//return response()->json(['data' => $data, 'success'=>true], 200);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountServicesV2/validateWalletMobileNumberDetails';

			//return response()->json(['data' => $data, 'success'=>true], 200);
			$authDataStr = sendPostRequest($url, $dataStr);
			//return response()->json(['data' => $authDataStr , 'success'=>true], 200);
			//dd($authDataStr);
			//return response()->json(['data' => $authDataStr, 'success'=>true], 200);
			$authData = json_decode($authDataStr);
			//dd($authData);
			return response()->json(['data' => $authData, 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage(), 'success'=>false], 200);
		}
	}






	public function postValidateCard(Request $request, $type=NULL)
	{
		try
		{
			$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$acquirerId = $request->get('acquirerId');
				//$data['token'] = $token;
				$all = $request->all();
				//unset($all['token']);
				
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
				
			}


				
			$data['merchantCode'] = $all['merchantId'];
			$data['deviceCode'] = $all['deviceCode'];
			$data['token'] = $all['token'];
			$data['firstFour'] = urlencode($all['firstFour']);
			$data['lastFour'] = urlencode($all['lastFour']);
			$data['hashedPan'] = urlencode($all['hashedPan']);
			$data['appId'] = $all['appId'];
			//return response()->json(['data' => $data, 'success'=>true], 200);
			
			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}
			//dd($dataStr);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/validateCard';
			$authDataStr = sendPostRequest($url, $dataStr);
			//dd($authDataStr);
			//return response()->json(['data' => $authDataStr, 'success'=>true], 200);
			$authData = json_decode($authDataStr);
			//dd($authData);
			return response()->json(['data' => $authData, 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage(), 'success'=>true], 200);
		}
	}


    public function getJWTIdentifier()
	{
	return $this->getKey();
	}

	public function getJWTCustomClaims()
	{
	return [];
	}

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
	
	
	
	
	public function getAccountOverviewForMobile(Request $request, $accountIdentifier, $merchantCode=NULL, $deviceCode=NULL)
    {
        //$token = $request->bearerToken();
		$token = $request->get('token');
		//return response()->json(['token' => $token, 'success'=>true], 200);
		//return response()->json(['token' => $user, 'success'=>true], 200);

		
		
		//dd(1212);
        //dd($token);
        //dd($user);
        //dd(JWTAuth::parseToken()->authenticate());

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountServicesV2/getAccountBalance';
        $data = 'accountIdentifier='.urlencode($accountIdentifier).'&token='.$token;
        if($merchantCode!=null)
            $data = $data."&merchantCode=".$merchantCode;
        if($deviceCode!=null)
            $data = $data."&deviceCode=".$deviceCode;
        //return response()->json(['url' => $url, 'success'=>true], 200);
        $accountBalance = sendPostRequest($url, $data);
	 $aB = json_decode($accountBalance);


		//return response()->json(['url'=>$url, 'data'=>$data, 'accountBalance' => $accountBalance, 'success'=>true], 200);
		
        if($accountBalance==null)
        {
            $accountBalance = [];
        }
        else
        {
            $accountBalance = json_decode($accountBalance);
        }
        //, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
        return response()->json(['data' => ['outstandingBorrowing'=>isset($aB->outstandingBorrowing) && $aB->outstandingBorrowing!=null ? $aB->outstandingBorrowing : 0.00, 'accountBalance' => $accountBalance], 'success'=>true], 200);
    }
	
	
	
	public function postValidateMerchantAndInitiateMerchantPayment(Request $request, $type=NULL)
    {
		try
		{
			$all = [];
			$debitSource = null;
			$recipientMerchantCode = null;
			$paymentReferenceNumber = null;
			$totalAmount = null;
			$debitSourceType = null;
			$deviceCode = null;
			$merchantId = null;

			$token = null;
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$all = $request->all();
				unset($all['token']);
				//$token = $request->bearerToken();
				//return response()->json(['dr'=> $all]);
				$debitSource = $request->get('accountIdentifier');
				$recipientMerchantCode = $request->get('recipientDeviceCode');
				$paymentReferenceNumber = $request->get('paymentReferenceNumber');
				$totalAmount = $request->get('amount');
				$debitSourceType = $request->get('debitSourceType');
				$deviceCode = $request->get('deviceCode');
				$merchantId = $request->get('merchantId');
				//return response()->json(['token' => $token, 'success'=>true], 200);
				//return response()->json(['token' => $user, 'success'=>true], 200);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$all = $request->all();
				//$token = $request->bearerToken();
				//return response()->json(['dr'=> $all]);
				$debitSource = $request->get('accountIdentifier');
				$recipientMerchantCode = $request->get('recipientDeviceCode');
				$paymentReferenceNumber = $request->get('paymentReferenceNumber');
				$totalAmount = $request->get('amount');
				$debitSourceType = $request->get('debitSourceType');
				$deviceCode = $request->get('deviceCode');
				$merchantId = $request->get('merchantId');
				//return response()->json(['token' => $token, 'success'=>true], 200);
				//return response()->json(['token' => $user, 'success'=>true], 200);
			}



			
			
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BillServicesV2/validateMerchant';
			$data = '';
			
			//
			
						
			$data = $data."&amount=".$totalAmount;
			if($paymentReferenceNumber!=null)
				$data = $data."&paymentReferenceNumber=".$paymentReferenceNumber;
			if($merchantId!=null)
				$data = $data."&merchantId=".$merchantId;
			if($deviceCode!=null)
				$data = $data."&deviceCode=".$deviceCode;
			
			if($debitSourceType=="My Wallet")
			{
				$data = $data.'&recipientDeviceCode='.$recipientMerchantCode.'&accountIdentifier='.urlencode($debitSource)."&debitSourceType=WALLET".'&token='.$token;
			}
			else if($debitSourceType=="My Card")
			{
				$cardSerialNo = explode("|||", $debitSource)[0];
				$cardTrackingNo = explode("|||", $debitSource)[1];
				$data = $data.'&recipientDeviceCode='.$recipientMerchantCode.'&cardSerialNo='.urlencode($cardSerialNo).'&cardTrackingNo='.$cardTrackingNo."&debitSourceType=CARD".'&token='.$token;
			}

			//return response()->json((['dd'=>$data ] ));
			$validateMerchantResp = sendPostRequest($url, $data);

			//return response()->json(['url'=>$url, 'data'=>$data, 'accountBalance' => $accountBalance, 'success'=>true], 200);
			
			if($validateMerchantResp==null)
			{
				$validateMerchantResp = [];
			}
			else
			{
				$validateMerchantResp = json_decode($validateMerchantResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['dd'=>4, 'validateMerchantResp' => $validateMerchantResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json($e->getMessage());
		}
    }
	
	



	
	
	public function postValidateQRCode(Request $request, $type=NULL)
    {
		try
		{
			$all = [];
			$qrCode = null;
			$deviceCode = null;
			$merchantId = null;
			

			$token = null;
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$all = $request->all();
				unset($all['token']);
				//$token = $request->bearerToken();
				//return response()->json(['dr'=> $all]);
				$qrCode = $request->get('mpqrData');
				$deviceCode = $request->get('deviceCode');
				$merchantId = $request->get('merchantId');
				//return response()->json(['token' => $token, 'success'=>true], 200);
				//return response()->json(['token' => $user, 'success'=>true], 200);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$all = $request->all();
				//$token = $request->bearerToken();
				//return response()->json(['dr'=> $all]);
				$qrCode = $request->get('mpqrData');
				$deviceCode = $request->get('deviceCode');
				$merchantId = $request->get('merchantId');
				//return response()->json(['token' => $token, 'success'=>true], 200);
				//return response()->json(['token' => $user, 'success'=>true], 200);
			}






			
			
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/DeviceServicesV2/validateQRCode';
			$data = 'token='.$token;
			//
			
						

			if($qrCode!=null)
				$data = $data."&qrCode=".$qrCode;
			if($merchantId!=null)
				$data = $data."&merchantCode=".$merchantId;
			if($deviceCode!=null)
				$data = $data."&deviceCode=".$deviceCode;
			
			//return response()->json((['dd'=>$data ] ));
			$validateQRResp = sendPostRequest($url, $data);

			//return response()->json(['url'=>$url, 'data'=>$data, 'accountBalance' => $accountBalance, 'success'=>true], 200);
			
			if($validateQRResp ==null)
			{
				$validateQRResp = [];
			}
			else
			{
				$validateQRResp = json_decode($validateQRResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['validateQRCode' => $validateQRResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json($e->getMessage());
		}
    }





	
	public function postValidateProbaseQRCode(Request $request, $type=NULL)
    {
		try
		{
			$all = [];
			$qrCode = null;
			$deviceCode = null;
			$merchantId = null;
			$amount = null;
			

			$token = null;
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$all = $request->all();
				unset($all['token']);
				//$token = $request->bearerToken();
				//return response()->json(['dr'=> $all]);
				$qrCode = $request->get('qrCode');
				$deviceCode = $request->get('deviceCode');
				$merchantId = $request->get('merchantId');
				$amount = $request->get('amount');
				//return response()->json(['token' => $token, 'success'=>true], 200);
				//return response()->json(['token' => $user, 'success'=>true], 200);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$all = $request->all();
				//$token = $request->bearerToken();
				//return response()->json(['dr'=> $all]);
				$qrCode = $request->get('qrCode');
				$amount = $request->get('amount');
				$deviceCode = $request->get('deviceCode');
				$merchantId = $request->get('merchantId');
				//return response()->json(['token' => $token, 'success'=>true], 200);
				//return response()->json(['token' => $user, 'success'=>true], 200);
			}






			
			
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/DeviceServicesV2/validateProbaseQRCode';
			$data = 'token='.$token;
			//
			
						

			if($qrCode!=null)
				$data = $data."&qrCode=".$qrCode;

			if($amount!=null)
				$data = $data."&amount=".$amount;
			if($merchantId!=null)
				$data = $data."&merchantCode=".$merchantId;
			if($deviceCode!=null)
				$data = $data."&deviceCode=".$deviceCode;
			
			//return response()->json((['dd'=>$data ] ));
			$validateQRResp = sendPostRequest($url, $data);

			//return response()->json(['url'=>$url, 'data'=>$data, 'accountBalance' => $accountBalance, 'success'=>true], 200);
			
			if($validateQRResp ==null)
			{
				$validateQRResp = [];
			}
			else
			{
				$validateQRResp = json_decode($validateQRResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['validateQRCode' => $validateQRResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json($e->getMessage());
		}
    }




	public function postCreateProbaseQRCode(Request $request, $type=NULL)
    {
		try
		{
			$all = [];
			$qrCode = null;
			$deviceCode = null;
			$merchantId = null;
			

			$token = null;
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$all = $request->all();
				unset($all['token']);
				//$token = $request->bearerToken();
				//return response()->json(['dr'=> $all]);
				$deviceCode = $request->get('deviceCode');
				$merchantId = $request->get('merchantId');
				//return response()->json(['token' => $token, 'success'=>true], 200);
				//return response()->json(['token' => $user, 'success'=>true], 200);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$all = $request->all();
				//$token = $request->bearerToken();
				//return response()->json(['dr'=> $all]);
				$deviceCode = $request->get('deviceCode');
				$merchantId = $request->get('merchantId');
				//return response()->json(['token' => $token, 'success'=>true], 200);
				//return response()->json(['token' => $user, 'success'=>true], 200);
			}






			
			
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/DeviceServicesV2/createNewProbaseQR';
			$data = 'token='.$token;
			//
			
				
			if($merchantId!=null)
				$data = $data."&merchantCode=".$merchantId;
			if($deviceCode!=null)
				$data = $data."&deviceCode=".$deviceCode;
			
			//return response()->json((['dd'=>$data ] ));
			$createNewProbaseQRResp = sendPostRequest($url, $data);

			//return response()->json(['url'=>$url, 'data'=>$data, 'accountBalance' => $accountBalance, 'success'=>true], 200);
			
			if($createNewProbaseQRResp==null)
			{
				$createNewProbaseQRResp = [];
			}
			else
			{
				$createNewProbaseQRResp = json_decode($createNewProbaseQRResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['createNewProbaseQRResp' => $createNewProbaseQRResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json($e->getMessage());
		}
    }
	
	
	
	
	public function postPayMerchant(Request $request)
    {
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//dd($all);
			//return response()->json(['data' => ['33' => $all], 'success'=>true], 200);
			//return response()->json(['data' => ['payMerchantResp' => $all], 'success'=>false], 200);
			//return response()->json(array_keys($all));
			$token = $request->get('token');
			$debitSource = $request->get('accountIdentifier');
			$recipientMerchantCode = $request->get('recipientDeviceCode');
			$paymentReferenceNumber = $request->get('paymentReferenceNumber');
			$totalAmount = $request->get('amount');
			$debitSourceType = $request->get('debitSourceType');
			$deviceCode = $request->get('deviceCode');
			$merchantId = $request->get('merchantId');
			$orderRef = strtoupper(Str::random(8));
			$otp = $request->get('otp');
			$otpRef = $request->get('otpRef');
			$payeeName = $request->get('payeeName');
			$merchantName = $request->get('merchantName');
			$studentRegNo = $request->get('studentRegNo');
			$isScanToPay = $request->has('isScanToPay') ? $request->get('isScanToPay') : null;
			//return response()->json(['token' => $token, 'success'=>true], 200);
			//return response()->json(['token' => $user, 'success'=>true], 200);
			$serviceTypeId= "PAY_MERCHANT";
			
			$narration = $request->get('narration');
			$narration = $narration==null ? ("SCHLFEES~".$merchantName."~".$payeeName."~".$totalAmount."~".$debitSourceType."~".$recipientMerchantCode."~".$studentRegNo) : $narration;
			$longNarration = $request->get('longNarration');
			
			
			
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BillServicesV2/payMerchant';
			$data = 'recipientDeviceCode='.$recipientMerchantCode.'&accountIdentifier='.urlencode($debitSource);
			
			
			$data = $data."&amount=".$totalAmount."&channel=MOBILE";
			
			if($debitSourceType=="WALLET")
			{
				$data = $data.'&recipientDeviceCode='.$recipientMerchantCode.'&accountIdentifier='.urlencode($debitSource).'&debitSourceType=WALLET';
			}
			else if($debitSourceType=="My Card")
			{
				$cardSerialNo = explode("|||", $debitSource)[0];
				$cardTrackingNo = explode("|||", $debitSource)[1];
				$data = $data.'&recipientDeviceCode='.$recipientMerchantCode.'&cardSerialNo='.urlencode($cardSerialNo).'&cardTrackingNo='.$cardTrackingNo.'&debitSourceType=CARD';
			}
			
			//return response()->json(['data' => $data], 200);
			$data = $data.'&token='.$token;
			
			if($paymentReferenceNumber!=null)
			{
				$data = $data."&paymentReferenceNumber=".$paymentReferenceNumber;
				$data = $data."&orderRef=".$orderRef;
				
			}
			else
			{
				$orderRef = strtoupper(Str::random(8));
				$data = $data."&orderRef=".$orderRef;
			}
			if($merchantId!=null)
				$data = $data."&merchantId=".$merchantId;
			if($deviceCode!=null)
				$data = $data."&deviceCode=".$deviceCode;
			
			$data = $data.'&serviceTypeId='.$serviceTypeId;
			$data = $data.'&token='.$token;
			$data = $data.'&otp='.$otp;
			$data = $data.'&otpRef='.$otpRef;
			$data = $data.'&narration='.$narration;

			if($isScanToPay!=null)
				$data = $data.'&isScanToPay='.$isScanToPay;

			if($longNarration!=null)
				$data = $data.'&longNarration='.$longNarration;
			
			
			$acquirer = \DB::table('acquirer')->where('isDefault', '=', 1)->first();
			$amount= (number_format($totalAmount, 2, '.', ''));
			$rt = "";
			//$apkey = $acquirer->accessExodus;
	 		$apkey = PROBASEKEY;
			$toHash = "$merchantId$deviceCode$serviceTypeId$orderRef$amount$rt$apkey";
			$hash = hash('sha512', $toHash);
			$data = $data.'&hash='.$hash;
			
			$validateMerchantResp = sendPostRequest($url, $data);
			
			//return response()->json([$toHash]);
			//KWAD6L3DWLOTA84AD9PAY_MERCHANT4HOEIH245.00WMXGGHowzFdq0fpTg93pYmA5Wjuiq97l
			//KWAD6L3DWL-OTA84AD9PAY_MERCHANTBSY1BWI15.00WMXGGHowzFdq0fpTg93pYmA5Wjuiq97l
			


			//return response()->json(['url'=>$url, 'data'=>$data, 'accountBalance' => $accountBalance, 'success'=>true], 200);
			
			if($validateMerchantResp==null)
			{
				$validateMerchantResp = [];
			}
			else
			{
				$validateMerchantResp = json_decode($validateMerchantResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['payMerchantResp' => $validateMerchantResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
    }





	
	public function postPayByProbaseQR(Request $request)
    {
		$debitSource = '';
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//dd($all);
			//return response()->json(['data' => ['33' => $all], 'success'=>true], 200);
			//return response()->json(['data' => ['payMerchantResp' => $all], 'success'=>false], 200);
			//return response()->json(array_keys($all));
			$token = $request->get('token');
			$debitSource = $request->get('accountIdentifier');
			$paymentReferenceNumber = $request->get('paymentReferenceNumber');
			$totalAmount = $request->get('amount');
			$debitSourceType = $request->get('debitSourceType');
			$deviceCode = $request->get('deviceCode');
			$merchantId = $request->get('merchantId');
			$orderRef = strtoupper(Str::random(8));
			$otp = $request->get('otp');
			$otpRef = $request->get('otpRef');
			$payeeName = $request->get('payeeName');
			$isScanToPay = $request->has('isScanToPay') ? $request->get('isScanToPay') : null;
			//return response()->json(['token' => $token, 'success'=>true], 200);
			//return response()->json(['token' => $user, 'success'=>true], 200);
			$serviceTypeId= "PAY_MERCHANT";
			$recipientQRCode = $request->get('recipientQRCode');
			
			$narration = $request->get('narration');
			$narration = $narration==null ? ("PAYBYPROBASEQR~".$debitSource."~".$payeeName."~".$totalAmount."~".$debitSourceType."~".$recipientQRCode) : $narration;
			$longNarration = $request->get('longNarration');
			
			
			
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BillServicesV2/payByProbaseQR';
			$data = '';
			
			
			$data = $data."&amount=".$totalAmount."&channel=MOBILE&recipientQRCode=".$recipientQRCode;
			
			if($debitSourceType=="WALLET")
			{
				$data = $data.'&accountIdentifier='.urlencode($debitSource).'&debitSourceType=WALLET';
			}
			else if($debitSourceType=="My Card")
			{
				$cardSerialNo = explode("|||", $debitSource)[0];
				$cardTrackingNo = explode("|||", $debitSource)[1];
				$data = $data.'&cardSerialNo='.urlencode($cardSerialNo).'&cardTrackingNo='.$cardTrackingNo.'&debitSourceType=CARD&accountIdentifier='.urlencode($cardTrackingNo);
			}
			
			//return response()->json(['data' => $data], 200);
			$data = $data.'&token='.$token;
			
			if($paymentReferenceNumber!=null)
			{
				$data = $data."&paymentReferenceNumber=".$paymentReferenceNumber;
				$data = $data."&orderRef=".$orderRef;
				
			}
			else
			{
				$data = $data."&orderRef=".$orderRef;
			}
			if($merchantId!=null)
				$data = $data."&merchantId=".$merchantId;
			if($deviceCode!=null)
				$data = $data."&deviceCode=".$deviceCode;
			
			$data = $data.'&serviceTypeId='.$serviceTypeId;
			$data = $data.'&token='.$token;
			$data = $data.'&otp='.$otp;
			$data = $data.'&otpRef='.$otpRef;
			$data = $data.'&narration='.$narration;

			if($isScanToPay!=null)
				$data = $data.'&isScanToPay='.$isScanToPay;

			if($longNarration!=null)
				$data = $data.'&longNarration='.$longNarration;
			
			
			$acquirer = \DB::table('acquirer')->where('isDefault', '=', 1)->first();
			$amount= (number_format($totalAmount, 2, '.', ''));
			$rt = "";
			//$apkey = $acquirer->accessExodus;
	 		$apkey = PROBASEKEY;
			$toHash = "$merchantId$deviceCode$serviceTypeId$orderRef$amount$rt$apkey";
			$hash = hash('sha512', $toHash);
			$data = $data.'&hash='.$hash;
			
			$validateMerchantResp = sendPostRequest($url, $data);
			
			//return response()->json([$toHash]);
			//KWAD6L3DWLOTA84AD9PAY_MERCHANT4HOEIH245.00WMXGGHowzFdq0fpTg93pYmA5Wjuiq97l
			//KWAD6L3DWL-OTA84AD9PAY_MERCHANTBSY1BWI15.00WMXGGHowzFdq0fpTg93pYmA5Wjuiq97l
			


			//return response()->json(['url'=>$url, 'data'=>$data, 'accountBalance' => $accountBalance, 'success'=>true], 200);
			
			if($validateMerchantResp==null)
			{
				$validateMerchantResp = [];
			}
			else
			{
				$validateMerchantResp = json_decode($validateMerchantResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['payMerchantResp' => $validateMerchantResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $debitSource], 200);
		}
    }



	public function postPayMerchantByQR(Request $request)
    {
		try{
			//$token = $request->bearerToken();
			$all = $request->all();

			$token = $request->get('token');
			$debitSource = $request->get('accountIdentifier');
			$recipientDeviceCode = $request->get('recipientDeviceCode');
			$paymentReferenceNumber = $request->get('paymentReferenceNumber');
			$totalAmount = $request->get('amount');
			$debitSourceType = $request->get('debitSourceType');
			$deviceCode = $request->get('deviceCode');
			$merchantId = $request->get('merchantId');
			$orderRef = strtoupper(Str::random(8));
			$otp = isset($all['otp']) ? $all['otp'] : null;
			$otpRef = isset($all['otpRef']) ? $all['otpRef'] : null;
			$payeeName = $request->get('payeeName');
			$merchantName = $request->get('merchantName');
			//return response()->json(['token' => $token, 'success'=>true], 200);
			//return response()->json(['token' => $user, 'success'=>true], 200);
			$serviceTypeId= "PAY_MERCHANT_BY_QR";
			
			$narration = $request->get('narration');
			$narration = $narration==null ? ("SCHLFEES~".$merchantName."~".$payeeName."~".$totalAmount."~".$debitSourceType."~".$recipientMerchantCode) : $narration;
			
			
			
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BillServicesV2/payMerchant';
			$data = 'recipientDeviceCode='.$recipientMerchantCode.'&accountIdentifier='.urlencode($debitSource);
			
			
			$data = $data."&amount=".$totalAmount."&channel=MOBILE";
			
			if($debitSourceType=="WALLET")
			{
				$data = $data.'&recipientDeviceCode='.$recipientDeviceCode.'&accountIdentifier='.urlencode($debitSource).'&debitSourceType=WALLET';
			}
			else if($debitSourceType=="CARD")
			{
				$cardSerialNo = explode("|||", $debitSource)[0];
				$cardTrackingNo = explode("|||", $debitSource)[1];
				$data = $data.'&recipientDeviceCode='.$recipientDeviceCode.'&cardSerialNo='.urlencode($cardSerialNo).'&cardTrackingNo='.$cardTrackingNo.'&debitSourceType=CARD';
			}
			
			//return response()->json(['data' => $data], 200);
			$data = $data.'&token='.$token;
			
			if($paymentReferenceNumber!=null)
			{
				$data = $data."&paymentReferenceNumber=".$paymentReferenceNumber;
				$data = $data."&orderRef=".$orderRef;
				
			}
			else
			{
				$orderRef = strtoupper(Str::random(8));
				$data = $data."&orderRef=".$orderRef;
			}
			if($merchantId!=null)
				$data = $data."&merchantId=".$merchantId;
			if($deviceCode!=null)
				$data = $data."&deviceCode=".$deviceCode;
			
			$data = $data.'&serviceTypeId='.$serviceTypeId;
			$data = $data.'&token='.$token;
			if($otp!=null && $otpRef!=null)
			{
				$data = $data.'&otp='.$otp;
				$data = $data.'&otpRef='.$otpRef;
			}
			$data = $data.'&narration='.$narration;
			
			
			$acquirer = \DB::table('acquirer')->where('isDefault', '=', 1)->first();
			$amount= (number_format($totalAmount, 2, '.', ''));
			$rt = "";
			//$apkey = $acquirer->accessExodus;
	 		$apkey = PROBASEKEY;
			$toHash = "$merchantId$deviceCode$serviceTypeId$orderRef$amount$rt$apkey";
			$hash = hash('sha512', $toHash);
			$data = $data.'&hash='.$hash;
			
			$validateMerchantResp = sendPostRequest($url, $data);
			
			//return response()->json([$toHash]);
			//KWAD6L3DWLOTA84AD9PAY_MERCHANT4HOEIH245.00WMXGGHowzFdq0fpTg93pYmA5Wjuiq97l
			//KWAD6L3DWL-OTA84AD9PAY_MERCHANTBSY1BWI15.00WMXGGHowzFdq0fpTg93pYmA5Wjuiq97l
			


			//return response()->json(['url'=>$url, 'data'=>$data, 'accountBalance' => $accountBalance, 'success'=>true], 200);
			
			if($validateMerchantResp==null)
			{
				$validateMerchantResp = [];
			}
			else
			{
				$validateMerchantResp = json_decode($validateMerchantResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['payMerchantResp' => $validateMerchantResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
    }




	public function postManageCard(Request $request, $type=NULL)
    	{
		try
		{

			$token = null;
			$data = [];
			$all = [];
			$defaultAcquirer = null;
			$user = null;
			$input = [];
			if($type!=null && $type==1)
			{
				$all = $request->all();
				$token = $request->get('token');

				$acquirerId = $request->get('acquirerId');
				$data['token'] = $token;
				$input = $request->all();


				unset($all['token']);
				$defaultAcquirer = \App\Models\Acquirer::where('id', '=', $acquirerId)->first();
				$defaultAcquirer = $defaultAcquirer->toArray();
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
				$input = $request->all();
				
				$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
				$defaultAcquirer = $defaultAcquirer->toArray();
			}


			$ap = new \App\Models\AppError();
			$ap->error_trace = json_encode($all);
			$ap->url = "";
			$ap->error_dump = json_encode($all);
			$ap->user_username = "";
			$ap->save();

			$data['merchantId'] = $all['merchantId'];
			$data['deviceCode'] = $all['deviceCode'];
			$input = $all;
			//return response()->json($all);
			//return response()->json(['message' => $defaultAcquirer], 200);


			$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');

			
			if($input['action']=='BLOCK_CARD')
			{
				$cardReceipient = $all['cardData'];
				$notes = $all['notes']==null ? "" : $all['notes'];
				$stopCardReasonId = $all['stopCardReasonId'];
				$pin = isset($all['pin']) ? $all['pin'] : null;

					$cardInfo = [];
					$cardInfo['notes'] = $notes;
					$cardInfo['stopCardReasonId'] = $stopCardReasonId;
					$cardInfo['cardId'] = $cardReceipient;
					$cardInfo = json_encode($cardInfo);
					$cardInfo = $encrypterFrom->encrypt($cardInfo);


					$data['epin'] = $pin;
					$data['appDeviceId'] = $all['appDeviceId'];
					$data['encryptedData'] = $cardInfo;
					if($type!=null && $type==1)
					{
						$data['token'] = $token;
					}
					else
					{
						$data['token'] = \Auth::user()->token;
					}



					$result = null;
					$dataStr = "";
					foreach ($data as $d => $v) {
						$dataStr = $dataStr . "" . $d . "=" . $v . "&";
					}
					
					$url = null;
					$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/TutukaServicesV2/stopTutukaCompanionCard';
					$authDataStr = sendPostRequest($url, $dataStr);
					
					$authData = json_decode($authDataStr);
					//dd($authData);
					$accounts = null;
					$cards = null;
					if ($authData->status == 5000) {
						return response()->json(['message' => 'Your card has been successfully blocked', 'success'=>true, 'status'=>100], 200);
					} else if ($authData->status == -1) {
						return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1], 200);
					} else {
						return response()->json(['message' => $authData->message, 'success'=>true, 'status'=>$authData->status], 200);
					}
			}
			else if($input['action']=='UNBLOCK_CARD')
			{

				$cardReceipient = $all['cardData'];
				$notes = $all['notes']==null ? "" : $all['notes'];
				$pin = isset($all['pin']) ? $all['pin'] : null;

					$cardInfo = [];
					$cardInfo['notes'] = $notes;
					$cardInfo['cardId'] = $cardReceipient;
					$cardInfo = json_encode($cardInfo);
					$cardInfo = $encrypterFrom->encrypt($cardInfo);


					$data['epin'] = $pin;
					$data['appDeviceId'] = $all['appDeviceId'];
					$data['encryptedData'] = $cardInfo;
					if($type!=null && $type==1)
					{
						$data['token'] = $token;
					}
					else
					{
						$data['token'] = \Auth::user()->token;
					}



					$result = null;
					$dataStr = "";
					foreach ($data as $d => $v) {
						$dataStr = $dataStr . "" . $d . "=" . $v . "&";
					}
					
					$url = null;
					$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/TutukaServicesV2/unstopTutukaCompanionCard';
					$authDataStr = sendPostRequest($url, $dataStr);
					
					$authData = json_decode($authDataStr);
					//dd($authData);
					$accounts = null;
					$cards = null;
					if ($authData->status == 5000) {
						return response()->json(['message' => 'Your card has been successfully unblocked', 'success'=>true, 'status'=>100], 200);
					} else if ($authData->status == -1) {
						return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1], 200);
					} else {
						return response()->json(['message' => $authData->message, 'success'=>true, 'status'=>$authData->status], 200);
					}
			}
			else if($input['action']=='CHANGE_CARD_PIN')
			{
				$cardReceipient = $all['cardData'];
				$pin = $all['epin'];
				$npin = $all['npin'];
				$cpin = $all['cpin'];


				if(!($npin!=null && strlen($npin)==4 && $npin==$cpin))
				{
					return response()->json(['message' => 'Invalid new pin provided. Your new pin and confirmation pin must match', 'success'=>true, 'status'=>101], 200);
				}

				/*if(!($pin!=null && strlen($pin)==4))
				{
					return response()->json(['message' => 'Invalid new pin provided. Your new pin and confirmation pin must match', 'success'=>true, 'status'=>101], 200);
				}*/

				if($pin==$npin)
				{
					return response()->json(['message' => 'Invalid new pin provided. You must provide a different pin from your current pin', 'success'=>true, 'status'=>101], 200);
				}

					$cardInfo = [];

					$cardInfo['cardId'] = $cardReceipient;
					$cardInfo = json_encode($cardInfo);
					$cardInfo = $encrypterFrom->encrypt($cardInfo);


					$data['epin'] = $pin;
					$data['npin'] = $npin;
					$data['appDeviceId'] = $all['appDeviceId'];
					$data['encryptedData'] = $cardInfo;
					if($type!=null && $type==1)
					{
						$data['token'] = $token;
					}
					else
					{
						$data['token'] = \Auth::user()->token;
					}



					$result = null;
					$dataStr = "";
					foreach ($data as $d => $v) {
						$dataStr = $dataStr . "" . $d . "=" . $v . "&";
					}
					
					$url = null;
					$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/TutukaServicesV2/changeTutukaCompanionPhysicalCardPin';
					$authDataStr = sendPostRequest($url, $dataStr);
					
					$authData = json_decode($authDataStr);
					//dd($authData);
					$accounts = null;
					$cards = null;
					if ($authData->status == 5000) {
						return response()->json(['message' => 'Your card pin has been successfully changed', 'success'=>true, 'status'=>100], 200);
					} else if ($authData->status == -1) {
						return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1], 200);
					} else {
						return response()->json(['message' => $authData->message, 'success'=>true, 'status'=>$authData->status], 200);
					}
			}
			else if($input['action']=='CHANGE_CVV_CARD')
			{
				$cardReceipient = $all['cardData'];
				$pin = $all['epin'];



					$cardInfo = [];

					$cardInfo['cardId'] = $cardReceipient;
					$cardInfo = json_encode($cardInfo);
					$cardInfo = $encrypterFrom->encrypt($cardInfo);


					$data['epin'] = $pin;
					$data['appDeviceId'] = $all['appDeviceId'];
					$data['encryptedData'] = $cardInfo;
					if($type!=null && $type==1)
					{
						$data['token'] = $token;
					}
					else
					{
						$data['token'] = \Auth::user()->token;
					}



					$result = null;
					$dataStr = "";
					foreach ($data as $d => $v) {
						$dataStr = $dataStr . "" . $d . "=" . $v . "&";
					}
					
					$url = null;
					$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/TutukaServicesV2/updateTutukaCompanionVirtualCardCVV';
					$authDataStr = sendPostRequest($url, $dataStr);
					
					$authData = json_decode($authDataStr);
					//dd($authData);
					$accounts = null;
					$cards = null;
					if ($authData->status == 5000) {
						return response()->json(['message' => 'Your card CVV has been successfully changed', 'success'=>true, 'status'=>100], 200);
					} else if ($authData->status == -1) {
						return response()->json(['message' => 'Login to continue', 'success'=>true, 'status'=>-1], 200);
					} else {
						return response()->json(['message' => $authData->message, 'success'=>true, 'status'=>$authData->status], 200);
					}
			}
		}
		catch(\Exception $e)
		{
			return response()->json(['message' => 'Error encountered processsing your request', 'dd'=>$e->getMessage(), 'dd1'=>$e->getLine()], 200);
		}



    }



	public function postGetMPQRDataList(Request $request, $type=NULL)
    	{
		try
		{
			$token = null;
			$data = [];
			$all = [];
			$defaultAcquirer = null;
			$user = null;
			$input = [];
			if($type!=null && $type==1)
			{
				$all = $request->all();
				$token = $request->get('token');

				$data['token'] = $token;
				$input = $request->all();


				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
				$input = $request->all();
			}
			 $dataStr = "";
	 		foreach($data as $d => $v)
	 		{
				$dataStr = $dataStr."".$d."=".$v."&";
			}

        		//$result = handleSOAPCalls('listMPQR', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/DeviceServices?wsdl', $data);
	 		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/DeviceServicesV2/listMPQR';
			$authDataStr = sendPostRequest($url, $dataStr);
	 		//dd($authDataStr);
	 		$result = json_decode($authDataStr);

        		if(handleTokenUpdate($result)==false)
        		{
            			return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
        		}

        		if($result->status == 710)
        		{
            			$data= ($result->data);

				$allDt = [];
				
				for($i1=0; $i1<sizeof($data); $i1++)
				{
					$entry = $data[$i1];
					$us = $entry;
					$y =$entry->id;
					$status = allMPQRDataStatus()[$us->status];

					$dt = [];
					//$dt['cardId'] = $us->cardId;
					$dt['deviceCode'] = isset($us->deviceCode) && $us->deviceCode!=null ? $us->deviceCode: 'N/A';
					$dt['deviceSerialNo'] = isset($us->deviceSerialNo) && $us->deviceSerialNo!=null ? $us->deviceSerialNo : 'N/A';
					$dt['merchantName'] = isset($us->merchantName) && $us->merchantName!=null ? $us->merchantName : 'N/A';

					//$dt['nameOnCard'] = isset($us->nameOnCard) && $us->nameOnCard!=null ? $us->nameOnCard: 'N/A';
					$dt['customerName'] = (isset($us->firstName) && $us->firstName!=null ? $us->firstName: '').''.(isset($us->lastName) && $us->lastName!=null ? ' '.$us->lastName: '');
					$dt['qrCardNumber'] = isset($us->qrCardNumber) && $us->qrCardNumber!=null ? $us->qrCardNumber: 'N/A';
					$dt['qrDataImage'] = isset($us->qrDataImage) && $us->qrDataImage!=null ? $us->qrDataImage: 'N/A';
					$dt['status'] = $status;

					$str = "";



					$str = $str.'<div class="btn-group mr-1 mb-1">';;
					$str = $str.'<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>';
					$str = $str.'<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">';


					$str = $str.'<a class="dropdown-item" style="cursor: pointer" onclick="javascript:showQRCodeImage(\''.$dt['qrDataImage'].'\')">View Code</a>';

					$str = $str.'</div>';
					$str = $str.'</div>';
					$dt['action'] = $str;
					array_push($allDt, $dt);
				}				

            			return response()->json(['message' => 'Data pulled successfully', 'success'=>true, 'status'=>100, 'data'=>$allDt], 200);

        		}else
        		{
            			return \Redirect::back()->with('error', 'Data pull failed');
        		}

		}
		catch(\Exception $e)
		{

			return response()->json(['message' => 'Data pulled successfully', 'success'=>true, 'status'=>101], 200);

		}
	}



	public function postGetProbaseQRDataList(Request $request, $type=NULL)
    	{
		try
		{
			$token = null;
			$data = [];
			$all = [];
			$defaultAcquirer = null;
			$user = null;
			$input = [];
			if($type!=null && $type==1)
			{
				$all = $request->all();
				$token = $request->get('token');

				$data['token'] = $token;
				$input = $request->all();


				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
				$input = $request->all();
			}
			 $dataStr = "";
	 		foreach($data as $d => $v)
	 		{
				$dataStr = $dataStr."".$d."=".$v."&";
			}

        		//$result = handleSOAPCalls('listMPQR', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/DeviceServices?wsdl', $data);
	 		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/DeviceServicesV2/listProbaseQR';
			$authDataStr = sendPostRequest($url, $dataStr);
	 		//dd($authDataStr);
	 		$result = json_decode($authDataStr);

        		if(handleTokenUpdate($result)==false)
        		{
            			return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
        		}

        		if($result->status == 710)
        		{
            			$data= ($result->data);

				$allDt = [];
				
				for($i1=0; $i1<sizeof($data); $i1++)
				{
					$entry = $data[$i1];
					$us = $entry;
					$y =$entry->id;
					$status = allMPQRDataStatus()[$us->status];

					$dt = [];
					//$dt['cardId'] = $us->cardId;
					$dt['walletNumber'] = isset($us->accountIdentifier) && $us->accountIdentifier!=null ? $us->accountIdentifier: 'N/A';
					$dt['customerName'] = (isset($us->firstName) && $us->firstName!=null ? ($us->firstName.' ') : '')."".(isset($us->lastName) && $us->lastName!=null ? $us->lastName : '');
					$dt['trackingNumber'] = isset($us->qrTrackingNumber) && $us->qrTrackingNumber!=null ? $us->qrTrackingNumber: 'N/A';
					$dt['type'] = (isset($us->mpqrDataType) && $us->mpqrDataType!=null ? ($us->mpqrDataType==0 ? 'Personal' : 'Corporate') : 'Personal');
					$dt['status'] = $status;

					$str = "";



					$str = $str.'<div class="btn-group mr-1 mb-1">';;
					$str = $str.'<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>';
					$str = $str.'<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">';


					$str = $str.'<a class="dropdown-item" style="cursor: pointer" onclick="javascript:showProbaseQRCodeImage(\''.$us->qrSaveDataImagePath.'\')">View Code</a>';

					$str = $str.'</div>';
					$str = $str.'</div>';
					$dt['action'] = $str;
					array_push($allDt, $dt);
				}				

            			return response()->json(['message' => 'Data pulled successfully', 'success'=>true, 'status'=>100, 'data'=>$allDt], 200);

        		}else
        		{
            			return \Redirect::back()->with('error', 'Data pull failed');
        		}

		}
		catch(\Exception $e)
		{
dd($e);
			return response()->json(['message' => 'Data pulled successfully', 'success'=>true, 'status'=>101], 200);

		}
	}
	



	public function postUpdateLoginOptions(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();

			$token = $request->get('token');
			$pinLogin= $request->get('pinLogin');
						

			
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/updateLoginOption';
			$data = 'isPinLogin='.$pinLogin;
			
						
			//return response()->json(['data' => $data], 200);
			$data = $data.'&token='.$token;

			//return response()->json(['data' => $data], 200);


			
			$updateLoginResp = sendPostRequest($url, $data);

			
			if($updateLoginResp ==null)
			{
				$updateLoginResp = [];
			}
			else
			{
				$updateLoginResp = json_decode($updateLoginResp );
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['updateLoginResp' => $updateLoginResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}



	public function postGetUserSummary(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();

			$token = $request->get('token');
			$pinLogin= $request->get('pinLogin');
						

			
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/postGetUserSummary';
			$data = 'isPinLogin='.$pinLogin;
			
						
			//return response()->json(['data' => $data], 200);
			$data = $data.'&token='.$token;

			//return response()->json(['data' => $data], 200);


			
			$updateLoginResp = sendPostRequest($url, $data);

			
			if($updateLoginResp ==null)
			{
				$updateLoginResp = [];
			}
			else
			{
				$updateLoginResp = json_decode($updateLoginResp );
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['updateLoginResp' => $updateLoginResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}


	public function postUpdateAuthPin(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
			$oldPin= $request->get('oldPin');
			$newPin= $request->get('newPin');

						

			
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/postUpdateAuthPin';
			$data = 'newPin='.$newPin.'&oldPin='.$oldPin.'&token='.$token;
			
						

			//return response()->json(['data' => $data], 200);


			
			$updateAuthPinResp = sendPostRequest($url, $data);

			
			if($updateAuthPinResp ==null)
			{
				$updateAuthPinResp = [];
			}
			else
			{
				$updateAuthPinResp = json_decode($updateAuthPinResp );
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['updateAuthPinResp' => $updateAuthPinResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}



	
	public function postUpdatePassword(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return response()->json(array_keys($all));

			//return ($all);

			$token = $request->get('token');
			$oldPwd= $request->get('oldPwd');
			$newPwd= $request->get('newPwd');

						

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
        		$oldPwd = $encrypterFrom->encrypt($oldPwd."");
        		$newPwd = $encrypterFrom->encrypt($newPwd."");


			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/changePassword';
			$data = 'encPassword='.$newPwd.'&currentpassword='.$oldPwd.'&token='.$token;
			
						

			//return response()->json(['data' => $data], 200);


			
			$updateAuthPwdResp= sendPostRequest($url, $data);

			
			if($updateAuthPwdResp==null)
			{
				$updateAuthPwdResp= [];
			}
			else
			{
				$updateAuthPwdResp= json_decode($updateAuthPwdResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['updateAuthPwdResp' => $updateAuthPwdResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	
	public function postUpdateEmailAddress(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
			$emailAddress= $request->get('emailAddress');

						

			
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/postUpdateEmailAddress';
			$data = 'emailAddress='.$emailAddress.'&token='.$token;
			
						

			//return response()->json(['data' => $data], 200);


			
			$updateEmailAddressResp= sendPostRequest($url, $data);

			
			if($updateEmailAddressResp==null)
			{
				$updateEmailAddressResp= [];
			}
			else
			{
				$updateEmailAddressResp= json_decode($updateEmailAddressResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['updateEmailAddressResp' => $updateEmailAddressResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}





	
	public function postUpdateUserProfile(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
			$firstName= $request->get('firstName');
			$lastName= $request->get('lastName');
			$otherName= $request->get('otherName');
			$address= $request->get('address');
			$city= $request->get('city');
			$customerVerificationNumber= $request->get('customerVerificationNumber');

						

			
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/updateCustomerProfile';
			$data = 'city='.$city.'&address='.$address.'&otherName='.$otherName.'&lastName='.$lastName.'&firstName='.$firstName.'&token='.$token.'&customerVerificationNumber='.$customerVerificationNumber;
			
						

			//return response()->json(['data' => $data], 200);


			
			$updateProfileResp= sendPostRequest($url, $data);

			
			if($updateProfileResp==null)
			{
				$updateProfileResp= [];
			}
			else
			{
				$updateProfileResp= json_decode($updateProfileResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['updateProfileResp' => $updateProfileResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}





	public function postUpdateProfilePicture(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
			$base64image= $request->get('base64image');
        		$image = str_replace('data:image/png;base64,', '', $base64image);
        		$image = str_replace(' ', '+', $image);
        		$imageName = Str::random(10).'.'.'png';
        		\File::put(public_path(). '/files/passports/' . $imageName, base64_decode($image));
			//return response()->json(['data' => ['imageName' => $imageName ], 'public_path()'=>public_path(), 'success'=>true], 200);
			$fileUrl = $imageName;			

			
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/postUpdateProfilePicture';
			$data = 'fileImageName='.$imageName.'&token='.$token;
			
						

			//return response()->json(['data' => $data], 200);


			
			$updateProfilePictureResp= sendPostRequest($url, $data);

			
			if($updateProfilePictureResp==null)
			{
				$updateProfilePictureResp= [];
			}
			else
			{
				$updateProfilePictureResp= json_decode($updateProfilePictureResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['updateProfilePictureResp' => $updateProfilePictureResp, 'fileUrl'=>$fileUrl], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}



	
	public function postUpdateVillageBankGroupConstitution(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/updateGroupConstitution';
			$groupId = $all['groupId'];
			$shortName = "";
			$constitution = $all['constitution'];
			$data = 'groupId='.$groupId.'&constitution='.$constitution.'&token='.$token;
			//return ([$data]);
						

			//return response()->json(['data' => $data], 200);


			
			$newGroupResp= sendPostRequest($url, $data);

			
			if($newGroupResp==null)
			{
				$newGroupResp= [];
			}
			else
			{
				$newGroupResp= json_decode($newGroupResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['updateConstitutionResp' => $newGroupResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}





	public function postJoinGroupInvitationWithCode(Request $request, $type=NULL)
    	{
		try{
			//$token = $request->bearerToken();
			$all = [];
			$data = [];
			$token = null;

			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
			}

			//return response()->json(['dt'=>$all]);

						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/approveOrDisapproveJoinRequest';
			//$groupId = $all['groupId'];
			$shortName = "";
			//$data = 'groupId='.$groupId.'&isApproved=1';

			$inviteCode=$all["inviteCode"];
			$isApproved=$all["isApproved"];

			if(strlen($inviteCode)>0)
				$data = "joinCode=".$inviteCode.'&isApproved='.$isApproved;


			$data = $data.'&token='.$token;
			//return ([$data]);
						

			//return response()->json(['data' => $data], 200);


			
			$joinGroupResp= sendPostRequest($url, $data);

			
			if($joinGroupResp==null)
			{
				$joinGroupResp= [];
			}
			else
			{
				$joinGroupResp= json_decode($joinGroupResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['joinGroupResp' => $joinGroupResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	public function postSendGroupInvitation(Request $request, $type=NULL)
    	{
		try{
			//$token = $request->bearerToken();
			$all = [];
			$data = [];
			$token = null;

			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
			}

			//return response()->json(['dt'=>$all]);

						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/sendGroupInvitations';
			$groupId = $all['groupId'];
			$shortName = "";
			$data = 'groupId='.$groupId;

			$memberNumber1=$all["memberNumber1"];
			$memberNumber2=$all["memberNumber2"];
			$memberNumber3=$all["memberNumber3"];
			$memberNumber4=$all["memberNumber4"];
			$memberNumber5=$all["memberNumber5"];

			if(strlen($memberNumber1)>0)
				$data = $data."&number1=".$memberNumber1;
			if(strlen($memberNumber2)>0)
				$data = $data."&number2=".$memberNumber2;
			if(strlen($memberNumber3)>0)
				$data = $data."&number3=".$memberNumber3;
			if(strlen($memberNumber4)>0)
				$data = $data."&number4=".$memberNumber4;
			if(strlen($memberNumber5)>0)
				$data = $data."&number5=".$memberNumber5;


			$data = $data.'&token='.$token;
			//return ([$data]);
						

			//return response()->json(['data' => $data], 200);


			
			$groupInvitationResp= sendPostRequest($url, $data);

			
			if($groupInvitationResp==null)
			{
				$groupInvitationResp= [];
			}
			else
			{
				$groupInvitationResp= json_decode($groupInvitationResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['groupInvitationResp' => $groupInvitationResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}

	
	public function postCreateVillageBankGroup(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/createNewGroup';
			$name = $all['groupName'];
			$shortName = "";
			$story = $all['aboutGroup'];
			$isOpen = isset($all['groupType']) && $all['groupType']==1 ? 1 : (isset($all['groupType']) && $all['groupType']==0 ? 0 : null);
			$maximumMembers = $all['maxMembers'];
			$backgroundColor = $all['backgroundColor'];
			$fontColor = $all['fontColor'];
			$maximumMembers = $all['maxMembers'];
			$otp= $all["otp"];
			$sourceType= $all["sourceType"];

			$appId = $all['appId'];
			$deviceCode = $all['deviceCode'];
			$merchantId = $all['merchantId'];
			$data = 'name='.$name.'&shortName='.$shortName.'&story='.$story.'&isOpen='.$isOpen.'&token='.$token.'&maximumMembers='.$maximumMembers.'&backgroundColor='.$backgroundColor.'&fontColor='.$fontColor.'&appId='.$appId;
			$data = $data.'&otp='.$otp.'&sourceType='.$sourceType.'&deviceCode='.$deviceCode.'&merchantId='.$merchantId;
			if($sourceType=="WALLET")
			{
				$walletNumber= $all["walletNumber"];
				$data = $data.'&walletNumber='.urlencode($walletNumber).'&channel=MOBILE';
			}
			else if($sourceType=="CARD")
			{
				$firstFour= $all["firstFour"];
				$lastFour= $all["lastFour"];
				$cardSerialNo= $all["cardSerialNo"];
				$cardTrackingId= $all["cardTrackingId"];
			
				$data = $data.'&firstFour='.urlencode($firstFour).'&lastFour='.urlencode($lastFour).'&cardSerialNo='.urlencode($cardSerialNo).'&cardTrackingId='.urlencode($cardTrackingId).'&channel=MOBILE';
			}
			//return response()->json(['data' => ['newGroupResp' => $otp], 'success'=>true], 200);

						

			//return response()->json(['data' => $data], 200);


			
			$newGroupResp= sendPostRequest($url, $data);

			
			if($newGroupResp==null)
			{
				$newGroupResp= [];
			}
			else
			{
				$newGroupResp= json_decode($newGroupResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['newGroupResp' => $newGroupResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}






	
	public function postGetVillageBankingSummary(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/villageBankingSummary';
			$data = 'token='.$token;
			
						

			//return response()->json(['data' => $data], 200);


			
			$newGroupResp= sendPostRequest($url, $data);

			
			if($newGroupResp==null)
			{
				$newGroupResp= [];
			}
			else
			{
				$newGroupResp= json_decode($newGroupResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['newGroupResp' => $newGroupResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}


	public function postRequestGroupJoin(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/createNewGroupRequest';
			$data = 'token='.$token.'&groupId='.$all['groupId'];
			
						

			//return response()->json(['data' => $data], 200);


			
			$joinRequestResp= sendPostRequest($url, $data);

			
			if($joinRequestResp==null)
			{
				$joinRequestResp= [];
			}
			else
			{
				$joinRequestResp= json_decode($joinRequestResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['joinRequestResp' => $joinRequestResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}


	
	
	public function postGetVillageBankingGroupSummary(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/villageBankingGroupSummary';
			$data = 'token='.$token."&groupId=".$all['groupId'];
			
						

			//return response()->json(['data' => $data], 200);


			
			$groupSummaryResp= sendPostRequest($url, $data);

			
			if($groupSummaryResp==null)
			{
				$groupSummaryResp= [];
			}
			else
			{
				$groupSummaryResp= json_decode($groupSummaryResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['groupSummaryResp' => $groupSummaryResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}


	
	
	
	public function postGetVillageBankingLoanWindow(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/getLoanApplicationWindow';
			$data = 'token='.$token."&groupId=".$all['groupId'];
			
						

			//return response()->json(['data' => $data], 200);


			
			$loanWindowResp= sendPostRequest($url, $data);

			
			if($loanWindowResp==null)
			{
				$loanWindowResp= [];
			}
			else
			{
				$loanWindowResp= json_decode($loanWindowResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => $loanWindowResp, 'success'=>true, 'status'=>100], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}
	
	public function postVillageBankingUpdateContributionSettings(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return response()->json(['all'=> $all, 'success' => false], 200);
			//return ($all);


        $rules = ['groupId' => 'required', 'amount' => 'required_if:contributionType,FIXED', 'howManyTimes' => 'required', 'periodType' => 'required_if:contributionType,FLEXIBLETIMEBOUND', 
		'periodType' => 'required_if:contributionType,FIXED', 'contributionType'=>'required'];

        $messages = [
            'groupId.required' => 'General system error. Your Session has ended. Please log out and log in again to try this action',
            'amount.required_if' => 'Specify the amount members pay at regular intervals',
            'howManyTimes.required' => 'Specify how often members pay',
            'periodType.required_if' => 'Specify how often members pay',
            'token.required' => 'Your Session has ended. Please log out and log in again to try this action',
	     'contributionType.required' => 'The groups type of contribution must be provided'
        ];



        $validator = \Validator::make($all, $rules, $messages);
        if($validator->fails())
        {
            $errMsg = json_decode($validator->messages(), true);
            $str_error = "";
            $i = 1;
            $array_errors = [];
            foreach($errMsg as $key => $value)
            {
                foreach($value as $val) {
                    array_push($array_errors, $val);
                }
            }
            $errors = join('<br>', $array_errors);
            return response()->json(['message' => $errors, 'success' => false], 200);
        }


			$token = $request->get('token');
			$groupId =$request->get('groupId');
			$amount = $request->get('amount');
			$howManyTimes = $request->get('howManyTimes');
			$periodType = $request->get('periodType');
			$contributionType = $request->get('contributionType');

			$amount = doubleVal($amount);
			$howManyTimes = intVal($howManyTimes);

			$groupId = intVal($groupId );
				

			if($howManyTimes<0 || $amount<0)
			{
				return response()->json(['message' => 'Invalid period and amount provided', 'success' => false], 200);
			}


			

						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/villageBankingUpdateContributionSettings';
			$data = 'token='.$token."&groupId=".$groupId;
			if($amount!=null)
				$data = $data."&amount=".$amount;

			$data = $data."&howManyTimes=".$howManyTimes;

			if($periodType!=null)
				$data = $data."&periodType=".$periodType;

			$data = $data."&contributionType=".$contributionType;

			
						

			//return response()->json(['data' => $data], 200);


			
			$updateContributionResp= sendPostRequest($url, $data);

			
			if($updateContributionResp==null)
			{
				$updateContributionResp= [];
			}
			else
			{
				$updateContributionResp= json_decode($updateContributionResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['updateContributionResp' => $updateContributionResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getLine()], 200);
		}
	}






	
	
	public function postVillageBankingUpdateLoanSettings(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);


        $rules = ['groupId' => 'required', 'loanRate' => 'required', 'loanRateType' => 'required', 'maxLoanPeriod' => 'required', 'periodType' => 'required', 'loanSystem' => 'required'
		];

        $messages = [
            'groupId.required' => 'General system error. Your Session has ended. Please log out and log in again to try this action',
            'loanRate.between' => 'Specify the interest rate',
            'loanRateType.required' => 'Specify the type of interest',
            //'minLoanAmount.required' => 'Specify the minimum loan amount allowed',
            'token.required' => 'Your Session has ended. Please log out and log in again to try this action',
            //'maxLoanAmount.between' => 'Specify the maximum loan amount members can request for',
            'maxLoanPeriod.required' => 'Specify the maximum period members can take a loan',
            'periodType.required' => 'Specify the type of period',
            'loanSystem.required' => 'Specify the type of loan system you prefer to use',
        ];



        $validator = \Validator::make($all, $rules, $messages);
        if($validator->fails())
        {
            $errMsg = json_decode($validator->messages(), true);
            $str_error = "";
            $i = 1;
            $array_errors = [];
            foreach($errMsg as $key => $value)
            {
                foreach($value as $val) {
                    array_push($array_errors, $val);
                }
            }
            $errors = join('<br>', $array_errors);
            return response()->json(['data'=> ['updateLoanResp'=>['message' => $errors, 'success' => false]]], 200);
        }


			$token = $request->get('token');
			$groupId =$request->get('groupId');
			$loanRate = $request->get('loanRate');
			$loanRateType = $request->get('loanRateType');
			$minLoanAmount = $request->get('minLoanAmountPercent');

			$maxLoanAmount =$request->get('maxLoanAmountPercent');
			$maxLoanPeriod = $request->get('maxLoanPeriod');
			$periodType = $request->get('periodType');
			$loanSystem = $request->get('loanSystem');
			$loanApplyPeriod = $request->get('loanApplyPeriod');

			$loanRate = doubleVal($loanRate);
			$minLoanAmount = doubleVal($minLoanAmount);
			$maxLoanAmount = doubleVal($maxLoanAmount);
			$maxLoanPeriod = intVal($maxLoanPeriod);
			$loanApplyPeriod = intVal($loanApplyPeriod);

			$groupId = intVal($groupId );
				

			if($maxLoanPeriod <0)
			{
				return response()->json(['data'=> ['updateLoanResp'=>['message' => 'Ensure you provide a valid loan period', 'success' => false]]], 200);
			}


			

						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/villageBankingUpdateLoanSettings';
			$data = 'token='.$token."&groupId=".$groupId."&loanRate=".$loanRate."&loanRateType=".$loanRateType."&minLoanAmount=".$minLoanAmount;
			$data = $data.'&maxLoanAmount='.$maxLoanAmount."&maxLoanPeriod=".$maxLoanPeriod."&periodType=".$periodType."&loanSystem=".$loanSystem."&loanApplyPeriod=".$loanApplyPeriod;

            		//return response()->json(['message' => $data , 'success' => false], 200);
						

			//return response()->json(['data' => $data], 200);


			
			$updateLoanResp= sendPostRequest($url, $data);

			
			if($updateLoanResp==null)
			{
				$updateLoanResp= [];
			}
			else
			{
				$updateLoanResp= json_decode($updateLoanResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['updateLoanResp' => $updateLoanResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	


	public function postGroupJoin(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/createNewGroupMember';
			$data = 'token='.$token.'&groupId='.$all['groupId'].'&isAdmin=0';
			
						

			//return response()->json(['data' => $data], 200);


			
			$joinRequestResp= sendPostRequest($url, $data);

			
			if($joinRequestResp==null)
			{
				$joinRequestResp= [];
			}
			else
			{
				$joinRequestResp= json_decode($joinRequestResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['joinRequestResp' => $joinRequestResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}






	public function postStartContributions(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/startContributionPackage';
			$data = 'token='.$token.'&groupId='.$all['groupId'].'&startOrEnd='.$all['startOrEnd'].'&packageId='.$all['packageId'].'&isReview='.$all['isReview'].'&channel='.$all['channel'].'&deviceCode='.$all['deviceCode'];
			
						

			//return response()->json(['data' => $data], 200);


			
			$joinRequestResp= sendPostRequest($url, $data);

			
			if($joinRequestResp==null)
			{
				$joinRequestResp= [];
			}
			else
			{
				$joinRequestResp= json_decode($joinRequestResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data

			if($all['startOrEnd']==0)
			{
				return response()->json(['data' => ['endContributionsResp' => $joinRequestResp], 'success'=>true], 200);
			}
			else if($all['startOrEnd']==1)
			{
				return response()->json(['data' => ['startContributionsResp' => $joinRequestResp], 'success'=>true], 200);
			}
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	public function postValidateForTransfer(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/validateForFundsTransfer';
			$data = 'deviceCode='.$all['deviceCode'].'&transferType='.$all['transferType'].'&sourceType='.$all['sourceType'].'&amount='.$all['amount'].'&receipientAccount='.$all['receipientAccount'].'&selectedBankRecipient='.$all['selectedBankRecipient'].'&token='.$token;
			if(isset($all['bankBranch']) && $all['bankBranch']!=null)
			{
				$data = $data.'&bankBranch='.$all['bankBranch'];
			}

						

			//return response()->json(['data' => $data], 200);


			
			$joinRequestResp= sendPostRequest($url, $data);
			$joinRequestResp= json_decode($joinRequestResp);
			
			
			return response()->json(['data' => ['validatedResp' => $joinRequestResp], 'success'=>true, 'status'=>100], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}







	
	public function postGetVillageBankingJoinRequestList(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/villageBankingJoinRequestList';
			$data = 'groupId='.$all['groupId'].'&token='.$token;
			
						

			//return response()->json(['data' => $data], 200);


			
			$newGroupResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['newGroupResp' => $newGroupResp], 'success'=>true], 200);
			

			if($newGroupResp==null)
			{
				$newGroupResp= [];
			}
			else
			{
				$newGroupResp= json_decode($newGroupResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['newGroupResp' => $newGroupResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}



		
	public function postVillageBankingApproveJoinRequest(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/approveOrDisapproveJoinRequest';
			$data = 'joinRequestId='.$all['joinRequestId'].'&isApproved='.$all['isApproved'].'&token='.$token;
			
						

			//return response()->json(['data' => $data], 200);


			
			$approveJoinResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['newGroupResp' => $newGroupResp], 'success'=>true], 200);
			

			if($approveJoinResp==null)
			{
				$approveJoinResp= [];
			}
			else
			{
				$approveJoinResp= json_decode($approveJoinResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['approveJoinResp' => $approveJoinResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}





	public function postVillageBankingGroupMembers(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/listGroupMembers';
			$data = 'groupId='.$all['groupId'].'&token='.$token;
			
						

			//return response()->json(['data' => $data], 200);


			
			$membersResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['membersResp' => $membersResp], 'success'=>true], 200);
			

			if($membersResp==null)
			{
				$membersResp= [];
			}
			else
			{
				$membersResp= json_decode($membersResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['membersResp' => $membersResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}








	public function postVillageMakeAdmin(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/makeGroupMemberAdmin';
			$data = 'groupMemberId='.$all['groupMemberId'].'&token='.$token.'&isMakeAdmin='.$all['isMakeAdmin'];
			if(isset($all['position']) && $all['position']!=null)
			{
				$data = $data."&position=".$all['position'];
			}
						

			//return response()->json(['data' => $data], 200);


			
			$makeAdminResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['makeAdminResp' => $makeAdminResp], 'success'=>true], 200);
			

			if($makeAdminResp==null)
			{
				$makeAdminResp= [];
			}
			else
			{
				$makeAdminResp= json_decode($makeAdminResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['makeAdminResp' => $makeAdminResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	public function postVillageBankingContributionList(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/listGroupContributions';
			$data = 'groupId='.$all['groupId'].'&token='.$token;
			if(isset($all['type']))
			{
				$data = $data.'&type='.$all['type'];
			}
			
						

			//return response()->json(['data' => $data], 200);


			
			$contributionsResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['contributionsResp' => $contributionsResp], 'success'=>true], 200);
			

			if($contributionsResp==null)
			{
				$contributionsResp= [];
			}
			else
			{
				$contributionsResp= json_decode($contributionsResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['contributionsResp' => $contributionsResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	public function postGetVillageBankingLoanSummary(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/getVillageBankingLoanSummary';
			$data = 'groupId='.$all['groupId'].'&token='.$token;
			if(isset($all['type']))
			{
				$data = $data.'&type='.$all['type'];
			}
			
						

			//return response()->json(['data' => $data], 200);


			
			$loanSummaryResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['loanSummaryResp' => $loanSummaryResp], 'success'=>true], 200);
			

			if($loanSummaryResp==null)
			{
				$loanSummaryResp= [];
			}
			else
			{
				$loanSummaryResp= json_decode($loanSummaryResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['loanSummaryResp' => $loanSummaryResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	public function postGetVillageBankingGroupActivitySummary(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/getVillageBankingGroupActivitySummary';
			$data = 'groupId='.$all['groupId'].'&token='.$token;
			if(isset($all['type']))
			{
				$data = $data.'&type='.$all['type'];
			}
			
						

			//return response()->json(['data' => $data], 200);


			
			$groupActivitySummaryResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['groupActivitySummaryResp' => $groupActivitySummaryResp], 'success'=>true], 200);
			

			if($groupActivitySummaryResp==null)
			{
				$groupActivitySummaryResp= [];
			}
			else
			{
				$groupActivitySummaryResp= json_decode($groupActivitySummaryResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['groupActivitySummaryResp' => $groupActivitySummaryResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}



	public function postCalculateLoanRepaymentSchedule(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/generateLoanRepaymentDetails';
			$data = 'loanTermId='.$all['loanTermId'].'&token='.$token;
			$data = $data.'&principal='.doubleVal($all['amount']);
			$data = $data.'&term='.intVal($all['period']);
			$data = $data.'&loanDetails='.$all['loanDetails'];			
						

			//return response()->json(['data' => $data], 200);


			
			$loanSummaryResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['loanSummaryResp' => $loanSummaryResp], 'success'=>true], 200);
			

			if($loanSummaryResp==null)
			{
				$loanSummaryResp= [];
			}
			else
			{
				$loanSummaryResp= json_decode($loanSummaryResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['loanSummaryResp' => $loanSummaryResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	public function postApplyForVillageBankingLoan(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/applyForGroupLoan';
			$data = 'loanTermId='.$all['loanTermId'].'&token='.$token;
			$data = $data.'&principal='.doubleVal($all['amount']);
			$data = $data.'&term='.intVal($all['period']);
			$data = $data.'&loanDetails='.$all['loanDetails'];			
						

			//return response()->json(['data' => $data], 200);


			
			$loanApplyResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['loanSummaryResp' => $loanSummaryResp], 'success'=>true], 200);
			

			if($loanApplyResp==null)
			{
				$loanApplyResp= [];
			}
			else
			{
				$loanApplyResp= json_decode($loanApplyResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['loanApplyResp' => $loanApplyResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	public function postApproveVillageBankingLoan(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/approveOrDisapproveLoan';
			$data = 'groupId='.$all['groupId'].'&token='.$token.'&deviceCode='.$all['deviceCode'].'&channel='.$all['channel'].'&loanId='.$all['loanId'];
			$data = $data.'&isApprove='.$all['isApprove'];			
						

			//return response()->json(['data' => $data], 200);


			
			$loanApproveResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['loanApproveResp' => $loanApproveResp], 'success'=>true], 200);
			

			if($loanApproveResp==null)
			{
				$loanApproveResp= [];
			}
			else
			{
				$loanApproveResp= json_decode($loanApproveResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['loanApproveResp' => $loanApproveResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	public function postGetVillageBankingLoans(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/getVillageBankingLoans';
			$data = 'groupId='.$all['groupId'].'&token='.$token;
						

			//return response()->json(['data' => $data], 200);


			
			$loanApproveResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['loanApproveResp' => $loanApproveResp], 'success'=>true], 200);
			

			if($loanApproveResp==null)
			{
				$loanApproveResp= [];
			}
			else
			{
				$loanApproveResp= json_decode($loanApproveResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['loanApproveResp' => $loanApproveResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	public function postGetSecurityQuestions(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/getSecurityQuestions';
			$data = 'x=1';
						

			//return response()->json(['data' => $data], 200);


			
			$securityQuestionsResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['securityQuestionsResp' => $securityQuestionsResp, 'ur'=>$url], 'success'=>true], 200);
			

			if($securityQuestionsResp==null)
			{
				$securityQuestionsResp= [];
			}
			else
			{
				$securityQuestionsResp= json_decode($securityQuestionsResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['securityQuestionsResp' => $securityQuestionsResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	public function postRecoverPassword(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/forgotPassword';
			$data = 'username='.urlencode($all['mobileNumber']).'&securityQuestionId='.urlencode($all['securityQuestionSelectedId']).'&securityQuestionAnswer='.urlencode($all['securityQuestionAnswer']);
						

			//return response()->json(['data' => $data], 200);


			
			$recoverPasswordResp= sendGetRequest($url, $data);
			//return response()->json(['data' => ['recoverPasswordResp' => $recoverPasswordResp, 'ur'=>$url], 'success'=>true], 200);
			

			if($recoverPasswordResp==null)
			{
				$recoverPasswordResp= [];
			}
			else
			{
				$recoverPasswordResp= json_decode($recoverPasswordResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['recoverPasswordResp' => $recoverPasswordResp==null ? ['status'=>'604', 'message'=>'We could not recover your password. Please try again'] : $recoverPasswordResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	public function postGetAllNotifications(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/getAllNotifications';
			$data = 'token='.$token;
						

			//return response()->json(['data' => $data], 200);


			
			$notificationsResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['notificationsResp' => $notificationsResp, 'ur'=>$url], 'success'=>true], 200);
			

			if($notificationsResp==null)
			{
				$notificationsResp= [];
			}
			else
			{
				$notificationsResp= json_decode($notificationsResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['notificationsResp' => $notificationsResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}



	public function postCreateNewPersonalMastercardPass(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());
			//return response()->json(['data' => [33]], 200);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/DeviceServicesV2/createNewMerchantDevice';
			$merchantId = $all['merchantId'];
			$mpqrAcquirerId = $all['mpqrAcquirerId'];
			$mpqrCardSchemeId = $all['mpqrCardSchemeId'];
			$mpqrCurrencyCode = $all['mpqrCurrencyCode'];
			$walletNumber = $all['accountIdentifier'];
			$notifyEmail = $all['notifyEmail'];
			$notifyMobile = $all['notifyMobile'];
			$mpqrDataType = $all['mpqrDataType'];


			$data = 'mpqrDataType='.$mpqrDataType .'&notifyMobile='.$notifyMobile.'&merchantId='.$merchantId;
			$data = $data.'&deviceType=3&switchToLive=1&acquirerId='.$mpqrAcquirerId.'&mpqrCardSchemeId='.$mpqrCardSchemeId;
			$data = $data.'&mpqrCurrencyCode='.$mpqrCurrencyCode.'&walletNumber='.$walletNumber.'&token='.$token;
			if($notifyEmail!=null)
				$data = $data.'&notifyEmail='.$notifyEmail;
						

			//return response()->json(['data' => $data], 200);


			
			$personalMastercardPassResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['notificationsResp' => $notificationsResp, 'ur'=>$url], 'success'=>true], 200);
			

			if($personalMastercardPassResp==null)
			{
				$personalMastercardPassResp= [];
			}
			else
			{
				$personalMastercardPassResp= json_decode($personalMastercardPassResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['personalMastercardPassResp' => $personalMastercardPassResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	public function postCreateGroupMessage(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());
			//return response()->json(['data' => [33]], 200);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/createNewGroupMessage';
			$groupMessage = $all['groupMessage'];
			$groupId = $all['groupId'];

			$data = 'groupMessage='.$groupMessage.'&groupId='.$groupId.'&token='.$token;
						

			//return response()->json(['data' => $data], 200);


			
			$groupMessageResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['groupMessageResp' => $groupMessageResp, 'ur'=>$url], 'success'=>true], 200);
			

			if($groupMessageResp==null)
			{
				$groupMessageResp= [];
			}
			else
			{
				$groupMessageResp= json_decode($groupMessageResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['groupMessageResp' => $groupMessageResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}



	public function postSendSupportMessage(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());
			//return response()->json(['data' => [33]], 200);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/createNewSupportMessage';
			$supportMessage= $all['supportMessage'];


			$data = 'supportMessage='.urlencode($supportMessage).'&token='.$token;
						

			//return response()->json(['data' => $data], 200);


			
			$supportMessageResp= sendPostRequest($url, $data);

			

			if($supportMessageResp==null)
			{
				$supportMessageResp= [];
			}
			else
			{
				$supportMessageResp= json_decode($supportMessageResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['supportMessageResp' => $supportMessageResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	public function postSendSupportMessageForAdmin(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());
			//return response()->json(['data' => [33]], 200);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/createNewSupportMessageForAdmin';
			
			$data = '';

			foreach($all as $k => $v)
			{
				$data = $data.'&'.$k.'='.urlencode($v);
			}
			$data = $data.'&token='.\Auth::user()->token;
				


			//return response()->json(['data' => $data], 200);


			
			$supportMessageResp= sendPostRequest($url, $data);

			

			if($supportMessageResp==null)
			{
				$supportMessageResp= [];
			}
			else
			{
				$supportMessageResp= json_decode($supportMessageResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['supportMessageResp' => $supportMessageResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	public function postReadGroupNotification(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());
			//return response()->json(['data' => [33]], 200);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/readGroupMessage';
			$notificationId = $all['notificationId'];

			$data = 'notificationId='.$notificationId.'&token='.$token;
						

			//return response()->json(['data' => $data], 200);


			
			$readNotificationResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['readNotificationResp' => $readNotificationResp, 'ur'=>$url], 'success'=>true], 200);
			

			if($readNotificationResp==null)
			{
				$readNotificationResp= [];
			}
			else
			{
				$readNotificationResp= json_decode($readNotificationResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['readNotificationResp' => $readNotificationResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}




	public function postPayGroupContributions(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());
			//return response()->json(['data' => [33]], 200);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/payGroupContributions';
			$amount= $all['amount'];
			$groupId= $all['groupId'];
			$sourceType= $all['sourceType'];
			$debitSource = $all['debitSource'];
			$deviceCode= $all['deviceCode'];
			$merchantId= $all['merchantId'];
			$channel= $all['channel'];
			$orderRef= $all['orderRef'];
			$appId= $all['appId'];

			$data = "";
			if($sourceType=="CARD")
			{
				$serialNo = $all['serialNo'];
				$firstFour = $all['firstFour'];
				$lastFour = $all['lastFour'];
				$data = 'amount='.$amount.'&token='.$token.'&groupId='.$groupId.'&sourceType='.$sourceType.'&debitSource='.urlencode($debitSource);
				$data = $data."&deviceCode=".$deviceCode."&merchantId=".$merchantId."&channel=".$channel."&orderRef=".$orderRef;
				$data = $data."&cardSerialNo=".urlencode($serialNo)."&cardPanFirstFour=".urlencode($firstFour)."&cardPanLastFour=".urlencode($lastFour)."&appId=".$appId;
			}
			else if($sourceType=="WALLET")
			{
				$data = 'amount='.$amount.'&token='.$token.'&groupId='.$groupId.'&sourceType='.$sourceType.'&debitSource='.urlencode($debitSource);
				$data = $data."&deviceCode=".$deviceCode."&merchantId=".$merchantId."&channel=".$channel."&orderRef=".$orderRef."&appId=".$appId;
			}


        		



						

			//return response()->json(['data' => $data], 200);


			
			$payGroupContributionsResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['payGroupContributionsResp' => $payGroupContributionsResp, 'ur'=>$url], 'success'=>true], 200);
			

			if($payGroupContributionsResp==null)
			{
				$payGroupContributionsResp= [];
			}
			else
			{
				$payGroupContributionsResp= json_decode($payGroupContributionsResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['payGroupContributionsResp' => $payGroupContributionsResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}



	public function postPayGroupFlexibleContribution(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
			//return response()->json(['data' => $all], 200);
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());
			//return response()->json(['data' => [33]], 200);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/payGroupContributions';
			$amount= $all['amount'];
			$groupId= $all['groupId'];
			$sourceType= $all['sourceType'];
			$debitSource = $all['debitSource'];
			$deviceCode= $all['deviceCode'];
			$merchantId= $all['merchantId'];
			$channel= $all['channel'];
			$orderRef= $all['orderRef'];


        		
			$appId= $all['appId'];



			$data = "";
			if($sourceType=="CARD")
			{
				$serialNo = $all['serialNo'];
				$firstFour = $all['firstFour'];
				$lastFour = $all['lastFour'];
				$data = 'amount='.$amount.'&token='.$token.'&groupId='.$groupId.'&sourceType='.$sourceType.'&debitSource='.urlencode($debitSource);
				$data = $data."&deviceCode=".$deviceCode."&merchantId=".$merchantId."&channel=".$channel."&orderRef=".$orderRef;
				$data = $data."&cardSerialNo=".urlencode($serialNo)."&cardPanFirstFour=".urlencode($firstFour)."&cardPanLastFour=".urlencode($lastFour)."&appId=".$appId;
			}
			else if($sourceType=="WALLET")
			{
				$data = 'amount='.$amount.'&token='.$token.'&groupId='.$groupId.'&sourceType='.$sourceType.'&debitSource='.urlencode($debitSource);
				$data = $data."&deviceCode=".$deviceCode."&merchantId=".$merchantId."&channel=".$channel."&orderRef=".$orderRef."&appId=".$appId;
			}



			//$data = 'amount='.$amount.'&token='.$token.'&groupId='.$groupId.'&sourceType='.$sourceType.'&debitSource='.$debitSource;
			//$data = $data."&deviceCode=".$deviceCode."&merchantId=".$merchantId."&channel=".$channel."&orderRef=".$orderRef;			

			//return response()->json(['data' => $data], 200);


			
			$payGroupContributionsResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['payGroupContributionsResp' => $payGroupContributionsResp, 'ur'=>$url], 'success'=>true], 200);
			

			if($payGroupContributionsResp==null)
			{
				$payGroupContributionsResp= [];
			}
			else
			{
				$payGroupContributionsResp= json_decode($payGroupContributionsResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['payGroupContributionsResp' => $payGroupContributionsResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage(), 'line'=> $e->getLine()], 200);
		}
	}





	public function postVillageBankingApproveLoanApplication(Request $request, $type=NULL)
    	{
		try{
			$all = [];
			$data = [];
			$token = null;

			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
			}

			//$token = $request->bearerToken();
			//$all = $request->all();
			//return ($all);

			//$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());
			//return response()->json(['data' => [33]], 200);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/approveOrDisapproveLoanRequest';
			$loanId= $all['loanId'];
			$isApprove= $all['isApprove'];


			//return response()->json(['data' => $all], 200);	



			$data = 'isApprove='.$isApprove.'&token='.$token.'&loanId='.$loanId.'&deviceCode='.$all['deviceCode'].'&channel='.$all['channel'];			




			
			$approveOrDisapproveLoanResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['approveOrDisapproveLoanResp' => $approveOrDisapproveLoanResp, 'ur'=>$url], 'success'=>true], 200);
			

			if($approveOrDisapproveLoanResp==null)
			{
				$approveOrDisapproveLoanResp= [];
			}
			else
			{
				$approveOrDisapproveLoanResp= json_decode($approveOrDisapproveLoanResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['approveOrDisapproveLoanResp' => $approveOrDisapproveLoanResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}



	public function postVillageBankingLoanRepaymentSchedule(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());
			//return response()->json(['data' => [33]], 200);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/getLoanRepaymentSchedule';
			$loanId= $all['loanId'];


        		



			$data = 'token='.$token.'&loanId='.$loanId;			

			//return response()->json(['data' => $data], 200);


			
			$getLoanRepaymentScheduleResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['getLoanRepaymentScheduleResp' => $getLoanRepaymentScheduleResp, 'ur'=>$url], 'success'=>true], 200);
			

			if($getLoanRepaymentScheduleResp==null)
			{
				$getLoanRepaymentScheduleResp= [];
			}
			else
			{
				$getLoanRepaymentScheduleResp= json_decode($getLoanRepaymentScheduleResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['getLoanRepaymentScheduleResp' => $getLoanRepaymentScheduleResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}



	public function postVillageBankingLoanRepayment(Request $request)
    	{
		try{
			//$token = $request->bearerToken();
			$all = $request->all();
			//return ($all);

			$token = $request->get('token');
						
			//dd(1212);
			//dd($token);
			//dd($user);
			//dd(JWTAuth::parseToken()->authenticate());
			//return response()->json(['data' => [33]], 200);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/repayVillageBankingLoan';
			$loanId= isset($all['loanId']) ? $all['loanId'] : null;
			$groupId= isset($all['groupId']) ? $all['groupId'] : null;
			$sourceType= $all['sourceType'];
			$debitSource= urlencode($all['debitSource']);
			$channel= $all['channel'];
			$orderRef= $all['orderRef'];
			$amount= $all['amount'];
			$deviceCode= $all['deviceCode'];
			$merchantId= $all['merchantId'];
			$appId = $all['appId'];
			//return response()->json(['data' => ['repayVillageBankingLoanResp' => $all['debitSource']], 'success'=>true], 200);
        		



			$data = 'appId='.$appId.'&amount='.$amount.'&sourceType='.$sourceType.'&debitSource='.$debitSource.'&merchantId='.$merchantId.'&deviceCode='.$deviceCode.'&channel='.$channel.'&orderRef='.$orderRef;			
			if($loanId!=null)
			{
				$data = $data.'&loanId='.$loanId;
			}
			if($groupId!=null)
			{
				$data = $data.'&groupId='.$groupId;
			}
			$data = $data.'&token='.$token;
			//return response()->json(['data' => $data], 200);


			
			$repayVillageBankingLoanResp= sendPostRequest($url, $data);
			//return response()->json(['data' => ['repayVillageBankingLoanResp' => $repayVillageBankingLoanResp, 'ur'=>$url], 'success'=>true], 200);
			

			if($repayVillageBankingLoanResp==null)
			{
				$repayVillageBankingLoanResp= [];
			}
			else
			{
				$repayVillageBankingLoanResp= json_decode($repayVillageBankingLoanResp);
			}
			//, 'merchantCompanyName'=>$merchantCompanyName, 'url'=>$url, 'data'=>$data
			return response()->json(['data' => ['repayVillageBankingLoanResp' => $repayVillageBankingLoanResp], 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage()], 200);
		}
	}



	


	public function postCreateChatKeyExchange(Request $request)
	{
		try
		{
			$all = $request->all();//->json()
			//$chatMessage = \App\Models\ChatMessageSec::where('chat_unique_id', '=', $all['um']);
			$pair1 = $all['mn']."".$all['um'];
			$pair2 = $all['um']."".$all['mn'];
			$chatMessage = \DB::select('Select tp.* from chat_message_sec tp where tp.deleted_at IS NULL AND (CONCAT(tp.key_mobile, tp.key_source_mobile) = "'.$pair1.'" OR CONCAT(tp.key_mobile, tp.key_source_mobile) = "'.$pair2.'")');			
			
				

			$returnData = [];
			if(sizeof($chatMessage) > 0)
			{
				$chatMessage = $chatMessage[0];
				$returnData['status'] = 1;
				$returnData['sec'] = $chatMessage;
			}
			else
			{
				$chatMessage = new \App\Models\ChatMessageSec();

				$chatMessage->key_entry = $all['pk'];
				$chatMessage->key_mobile = $all['mn'];
				$chatMessage->key_source = $all['ui'];
				$chatMessage->key_source_mobile = $all['um'];
				$chatMessage->chat_unique_id = $all['cid'];
				$chatMessage->save();


				$data1 = [];
				$data1['recp'] = $chatMessage->key_mobile;
				$data1['srcp'] = $chatMessage->key_source_mobile;
				$data1['pk'] = $chatMessage->key_entry;
				$data1['cid'] = $chatMessage->chat_unique_id;
				$data1['status'] = 1;
				$data1['messageType'] = 'NEWSECK';
				$data = json_encode($data1);
				$data = 'data='.urlencode($data);
				$url = "http://140.82.52.195:8081/post-new-chat-key";
				$server_output = sendPostRequest($url, $data);
				$returnData['status'] = 0;
			}
			

			
			$returnData['message'] = 'Success';
			return response()->json($returnData);
		


		}
		catch(\Exception $e)
		{
			$returnData = [];
			$returnData['status'] = 1;
			$returnData['message'] = 'Incomplete information provided. Please provide required information to search for available trips';
			$returnData['line'] = $e->getLine();
			$returnData['msg'] = $e->getMessage();
			return response()->json($returnData);
		}


	}



	


	


	public function postSendChatMessage(Request $request)
	{
		try
		{
			$all = $request->all();//->json()
			$chatMessage = \App\Models\ChatMessage::where('message_uid', '=', $all['messageId']);
			if($chatMessage->count() > 0)
			{
				$chatMessage = $chatMessage->first();
				
				$returnData = [];
				$returnData['status'] = 0;
				$returnData['message'] = 'Incomplete information provided. Please provide required information to search for available trips';
				$returnData['message_unique_id'] = $e->getLine();
				$returnData['chatMessage'] = $chatMessage;
				return response()->json($returnData);
			}
			else
			{
				$chatMessage = new \App\Models\ChatMessage();
			}


			$chatMessage->message_uid = $all['messageId'];
			$chatMessage->message_string_body = $all['message'];
			$chatMessage->message_parent_id = isset($all['messageParentId']) ? $all['messageParentId'] : null;
			$chatMessage->chat_pair = $all['chatPair'];
			$chatMessage->sender_user_id = $all['senderUserId'];
			$chatMessage->sender_mobile = $all['sourceMobile'];
			$chatMessage->recipient_mobile = $all['recipientMobile'];
			$chatMessage->device_sent_time = $all['sentTime'];
			$chatMessage->is_delivered = 0;
			$chatMessage->save();
			
			$data1 = [];
			$data1['chatMessage'] = $chatMessage;
			$data1['chatPair'] = $all['chatPair'];
			$data1['status'] = 1;
			$data1['messageType'] = 'NEWCHATMESSAGE';
			$data = json_encode($data1);
			$data = 'data='.urlencode($data);
			$url = "http://140.82.52.195:8081/push-new-chat-message";
			$server_output = sendPostRequest($url, $data);
				

			$returnData = [];
			$returnData['status'] = 0;
			$returnData['message'] = 'Success';
			return response()->json($returnData);
		


		}
		catch(\Exception $e)
		{
			dd($e);
			$returnData = [];
			$returnData['status'] = 1;
			$returnData['message'] = 'Incomplete information provided. Please provide required information to search for available trips';
			$returnData['line'] = $e->getLine();
			$returnData['msg'] = $e->getMessage();
			return response()->json($returnData);
		}


	}



	public function postGetServiceChargeByServiceType(Request $request)
	{
	 $token = $request->bearerToken();


        $user = JWTAuth::toUser($token);


	 $all = ($request->json()->all());

        $data = array();
        if(isset($all['serviceType']) && $all['serviceType']!=null)
            $data['serviceType'] = $all['serviceType'];

        $data['token'] = $user->token;

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        //dd($dataStr);

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountingServicesV2/getServiceChargesByServiceType';
        $server_output = sendPostRequest($url, $dataStr);
        $result = json_decode($server_output);
        //dd($result);

        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }



        if($result->status == 5000)
        {
            $serviceCharges= $result->serviceCharges;
            $glAccounts = $result->glaccounts;
            $currentJournalEntrySetupList = isset($result->currentJournalEntrySetupList) ? $result->currentJournalEntrySetupList : [];
            $collectionAccounts = isset($result->collectionAccounts) ? $result->collectionAccounts: [];
		//dd($currentJournalEntrySetupList );
            return response()->json(['status' => 100, 'list' => $serviceCharges, 'glAccounts'=>$glAccounts, 'currentJournalEntrySetupList'=>$currentJournalEntrySetupList, 'collectionAccounts'=>$collectionAccounts]);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any card mapped to the card bin.']);
        }
	}




	
	public function postFundPoolAccount(Request $request)
	{
	 $token = $request->bearerToken();


        $user = JWTAuth::toUser($token);


	 $all = ($request->json()->all());

        $data = array();
        $data['poolAccountId'] = $all['poolAccountId'];
        $data['bankTransactionRef'] = $all['bankTransactionRef'];
        $data['amount'] = $all['amount'];
        $data['deviceCode'] = BEVURA_DEVICE_CODE;
        $data['merchantCode'] = BEVURA_MERCHANT_CODE;
        $data['valueDate'] = $all['valueDate'];






        $data['token'] = $user->token;

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        //dd($dataStr);

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountServicesV2/fundPoolAccount';
        $server_output = sendPostRequest($url, $dataStr);
        $result = json_decode($server_output);
        //dd($result);

        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }



        if($result->status == 110)
        {
		
            return response()->json(['status' => 100]);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any card mapped to the card bin.']);
        }
	}




	public function postUpdateAcquirer(Request $request)
	{
	 $token = $request->bearerToken();

        $user = JWTAuth::toUser($token);


	 $all = ($request->json()->all());
	 //return response()->json(['message' => $all, 'success'=>false], 200);
        $all['token'] = $user->token;

        $dataStr = "";
        foreach($all as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        //dd($dataStr);

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BankServicesV2/createNewAcquirer';
        $server_output = sendPostRequest($url, $dataStr);
        $result = json_decode($server_output);
        //dd($result);

        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }



        if($result->status == 110)
        {
		
            return response()->json(['status' => 100]);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any card mapped to the card bin.']);
        }
	}





	
	public function postFundAccount(Request $request, $type=NULL)
	{


	 $token = $request->bearerToken();

        


	 $all = ($request->json()->all());

        $data = array();
	 $defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
	 $defaultAcquirer = $defaultAcquirer->toArray();
	 
        $data['bankTransactionId'] = $all['bankTransactionId'];
        $data['amountPaid'] = $all['amount'];
        $data['deviceCode'] = BEVURA_DEVICE_CODE;
        $data['merchantCode'] = BEVURA_MERCHANT_CODE;
	 $data['channel'] = 'WEB';
	 $data['hash'] = isset($all['hash']) ? $all['hash'] : null;
		$data['serviceTypeId'] = $all['serviceTypeId'];




		if($type==NULL)
		{
			$user = JWTAuth::toUser($token);
        		$data['token'] = $user->token;
	 		$data['orderRef'] = strtoupper(Str::random(8));
			$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
		       $accountIdS = $encrypterFrom->encrypt($all['accountId']."");


		       $data['accountIdS'] = $accountIdS;
		}
		else
		{
			$data['token'] = $all['token'];
			$data['orderRef'] = $all['orderRef'];
			$data['accountIdS'] = $all['accountId'];

		}	

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        //dd($dataStr);

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountServicesV2/fundAccount';
        $server_output = sendPostRequest($url, $dataStr);
        $result = json_decode($server_output);
        //dd($result);

        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }



        if($result->status == 5000)
        {
		
            return response()->json(['status' => 100, 'data'=>$result]);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any card mapped to the card bin.']);
        }
	}





	
	public function postCashoutAccount(Request $request, $type=NULL)
	{


			$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
			}

	 //dd($all);
        //$data = array();
	 $defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
	 $defaultAcquirer = $defaultAcquirer->toArray();
	 
        $data['bankTransactionId'] = $all['bankTransactionId'];
        $data['amountToPay'] = $all['amount'];
        $data['serviceType'] = isset($all['serviceType']) ? $all['serviceType'] : null;
        $data['pin'] = $all['pin'];
        $data['deviceCode'] = BEVURA_DEVICE_CODE;
        $data['merchantCode'] = BEVURA_MERCHANT_CODE;
	 $data['channel'] = 'WEB';
	 $data['hash'] = isset($all['hash']) ? $all['hash'] : null;
		$data['serviceTypeId'] = $all['serviceTypeId'];




		if($type==NULL)
		{
			$user = JWTAuth::toUser($token);
        		//$data['token'] = $token;
	 		$data['orderRef'] = strtoupper(Str::random(8));
			$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
		       $accountIdS = $encrypterFrom->encrypt($all['accountId']."");


		       $data['accountIdS'] = $accountIdS;
		}
		else
		{
			//$data['token'] = $all['token'];
			$data['orderRef'] = $all['orderRef'];
			$data['accountIdS'] = $all['accountId'];

		}	
            	//return response()->json($data);
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }

		//return response()->json(['status' => 103, 'data'=>$data]);

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountServicesV2/cashOutAccount';
        $server_output = sendPostRequest($url, $dataStr);
        $result = json_decode($server_output);
        //dd($result);

        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }



        if($result->status == 110)
        {
		
            return response()->json(['status' => 100, 'data'=>$result]);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any card mapped to the card bin.']);
        }
	}



	public function pullCustomerByAccountNumber(Request $request)
	{
		$token = $request->bearerToken();


       	$user = JWTAuth::toUser($token);


	 	$all = ($request->json()->all());

        	$data = array();
	 	$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
	 	$defaultAcquirer = $defaultAcquirer->toArray();
	 	$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        	$accountIdS = $encrypterFrom->encrypt($all['accountNumber']."");


        	$data['accountNumber'] = $accountIdS;
        	$data['deviceCode'] = BEVURA_DEVICE_CODE;
		$data['token'] = $user->token;

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        //dd($dataStr);

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/getCustomerDataByAccountNumber';
        $server_output = sendPostRequest($url, $dataStr);
        $result = json_decode($server_output);
        //dd($result);

        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        }



        if($result->status == 100)
        {
		
            return response()->json(['status' => 100, 'resp'=>$result]);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any customer/account matching the account number provided']);
        }
	}




	public function issuePhysicalCardToAccount(Request $request)
	{
		$token = $request->bearerToken();


       	$user = JWTAuth::toUser($token);


	 	$all = ($request->json()->all());

        	$data = array();
	 	$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
	 	$defaultAcquirer = $defaultAcquirer->toArray();
	 	$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        	$cardBinId = $all['cardBinId'];
		$accountId = $all['accountId'];
		$cardSchemeId = $all['cardScheme'];


        	$data['cardBinId'] = $cardBinId;
		$data['accountId'] = $accountId;
		$data['cardSchemeId'] = $cardSchemeId;
		$enc = $encrypterFrom->encrypt(json_encode($data)."");
		$data = [];
		$data['encryptedData'] = $enc;
		$data['token'] = $user->token;
        	$data['deviceCode'] = BEVURA_DEVICE_CODE;

        	$dataStr = "";
        	foreach($data as $d => $v)
        	{
            		$dataStr = $dataStr."".$d."=".$v."&";
        	}


        	//dd($dataStr);

        	$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/TutukaServicesV2/linkCustomerToTutukaCompanionPhysicalCard';
        	$server_output = sendPostRequest($url, $dataStr);
        	$result = json_decode($server_output);
        	//dd($result);

        	if($result==null)
        	{
            		return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        	}



        	if($result->status == 100)
        	{
		
            		return response()->json(['status' => 100, 'resp'=>$result]);
        	}
        	else if($result->status == -1)
        	{
            		return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        	}
        	else
        	{
            		return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any customer/account matching the account number provided']);
        	}
	}



	public function getBinCardStatus(Request $request)
	{
		$token = $request->bearerToken();


       	$user = JWTAuth::toUser($token);


	 	$all = ($request->json()->all());

        	$data = array();
	 	$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
	 	$defaultAcquirer = $defaultAcquirer->toArray();
	 	$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        	$cardBinId = $all['cardBinId'];
		$accountId = $all['accountId'];
		$cardSchemeId = $all['cardScheme'];


        	$data['cardBinId'] = $cardBinId;
		$data['accountId'] = $accountId;
		$data['cardSchemeId'] = $cardSchemeId;
		$enc = $encrypterFrom->encrypt(json_encode($data)."");
		$data = [];
		$data['encryptedData'] = $enc;
		$data['token'] = $user->token;
        	$data['deviceCode'] = PROBASEWALLET_DEVICE_CODE;

        	$dataStr = "";
        	foreach($data as $d => $v)
        	{
            		$dataStr = $dataStr."".$d."=".$v."&";
        	}


        	//dd($dataStr);

        	$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/TutukaServicesV2/linkCustomerToTutukaCompanionPhysicalCard';
        	$server_output = sendPostRequest($url, $dataStr);
        	$result = json_decode($server_output);
        	//dd($result);

        	if($result==null)
        	{
            		return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
        	}



        	if($result->status == 100)
        	{
		
            		return response()->json(['status' => 100, 'resp'=>$result]);
        	}
        	else if($result->status == -1)
        	{
            		return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        	}
        	else
        	{
            		return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any customer/account matching the account number provided']);
        	}
	}



	
	public function postValidateMobileNumber(Request $request, $type=NULL)
	{
		$defaultAcquirer = null;
		try
		{
			$token = null;
			$data = [];
			$all = [];
			
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$acquirerId = $request->get('acquirerId');
				//$data['token'] = $token;
				$all = $request->all();
				//unset($all['token']);
				$defaultAcquirer = \App\Models\Acquirer::where('id', '=', $acquirerId)->first();
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;

				$all = $request->all();
				$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
			}

			//
			//dd($defaultAcquirer->toArray());

			if($defaultAcquirer==null)
			{
				return response()->json(['message' => 'Error encountered. ERR00AQ1', 'success'=>false], 200);
			}
			$defaultAcquirer = $defaultAcquirer->toArray();
			//return response()->json(['message' => $defaultAcquirer, 'success'=>false], 200);


			$accountIdentifier = $all['accountIdentifier'];
			$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
			$enc = $encrypterFrom->encrypt($all['accountIdentifier']."");
			//return response()->json(['message' => $enc, 'success'=>false, 'ddd'=>$defaultAcquirer['accessExodus']], 200);
			$data['channel'] = $all['channel'];


			
				
			$data['amount'] = $all['amount'];
			$data['merchantId'] = $all['merchantId'];
			$data['deviceCode'] = $all['deviceCode'];
			$data['token'] = $all['token'];
			$data['receiverNumber'] = $all['countryCode']."".(substr($all['receiverNumber'], 0, 1)=="0" ? substr($all['receiverNumber'], 1) : $all['receiverNumber']);
			$data['countryCode'] = $all['countryCode'];
			$data['acquirerCode'] = $defaultAcquirer['acquirerCode'];
			$data['accountIdentifier'] = $enc;

			if(isset($all['debitSourceType']) && $all['debitSourceType']=="My Wallet")
			{
				$data['sourceType'] = "WALLET";
				$data['accountIdentifier'] = $enc;
			}
			else
			{
				$data['sourceType'] = "CARD";
				$data['cardSerialNo'] = explode('|||', $all['utilityBillPayFrom'])[0];
				$data['cardTrackingNo'] = explode('|||', $all['utilityBillPayFrom'])[1];
			}

			$data['orderRef'] = strtoupper(Str::random(8));
			//return response()->json(['data' => $data, 'success'=>true], 200);
			
			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}
			//dd($dataStr);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountServicesV2/validateMobileNumberReceiver';
			$authDataStr = sendPostRequest($url, $dataStr);
			//dd($authDataStr);
			//return response()->json(['data' => $authDataStr, 'success'=>true], 200);
			$authData = json_decode($authDataStr);
			//dd($authData);
			return response()->json(['data' => $authData, 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage(), 'success'=>true, 'ddff'=>$defaultAcquirer['accessExodus']], 200);
		}
	}


	public function postViewPoolAccountBalance(Request $request, $type=NULL)
	{
		$defaultAcquirer = null;
		try
		{
			$token = null;
			$data = [];
			$all = [];
			
			
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;

				$all = $request->all();

			//return response()->json(['message' => $all , 'success'=>false], 200);
			$data['poolAccountId'] = $all['poolAccountId'];
			$data['merchantCode'] = $all['merchantCode'];
			$data['deviceCode'] = $all['deviceCode'];
			//$data['token'] = $all['token'];
			
			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}
			//dd($dataStr);
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountingServicesV2/getPoolAccountBalanceAtBank';
			$authDataStr = sendPostRequest($url, $dataStr);
			//dd($url );
			//return response()->json(['data' => $authDataStr, 'success'=>true], 200);
			$authData = json_decode($authDataStr);
			//dd($authData);
			return response()->json(['data' => $authData, 'success'=>true], 200);
		}
		catch(\Exception $e)
		{
			return response()->json(['data' => $e->getMessage(), 'success'=>true], 200);
		}
	}



	


	public function postGetJournalEntries(Request $request, $filter)
	{
		$all = $request->all();
		$all['filter'] = $filter;
		$token = $request->bearerToken();
        	$user = JWTAuth::toUser($token);
       	$all['token'] = \Auth::user()->token;
		$data = '';
		foreach($all as $k => $a)
		{
			$data = $k."=".$a."&".$data;
		}
		//dd($data);

		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountingServicesV2/listJournalEntries';

		$server_output = sendPostRequest($url, $data);
		$authData = json_decode($server_output);


		return response()->json($authData);
	}



	public function postGetDashboardStatistics(Request $request)
	{
		$all = $request->all();
		$token = $request->bearerToken();
        	$user = JWTAuth::toUser($token);
       	$all['token'] = \Auth::user()->token;
		$data = '';
		foreach($all as $k => $a)
		{
			$data = $k."=".$a."&".$data;
		}
		//dd($data);

		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/TransactionServicesV2/getDashboardStatistics';

		$server_output = sendPostRequest($url, $data);
		$authData = json_decode($server_output);


		return response()->json($authData);
	}



	public function postRequestNewPhysicalCard(Request $request, $type=NULL)
	{
		$token = null;
		$data = [];
		$all = [];
		if($type!=null && $type==1)
		{
			$token = $request->get('token');
			$data['token'] = $token;
			$all = $request->all();
			unset($all['token']);
		}
		else
		{
			$token = $request->bearerToken();
			$user = JWTAuth::toUser($token);
			$data['token'] = \Auth::user()->token;
			$all = $request->all();
		}
		//return response()->json($all);
		$data['deviceCode'] = $all['deviceCode'];
		$data['appId'] = $all['appId'];
		$data['encryptedData'] = $all['encryptedData'];
		
       	//$all['token'] = \Auth::user()->token;
		$dataStr = '';
		foreach($data as $k => $a)
		{
			$dataStr = $k."=".$a."&".$dataStr;
		}
		
		//return response()->json($dataStr);

		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/TutukaServicesV2/orderNewTutukaCompanionPhysicalCard';
		//return response()->json($url);
		$server_output = sendPostRequest($url, $dataStr);
		$authData = json_decode($server_output);


		return response()->json($authData);
	}





    public function postGetVillageBankingListing(Request $request, $type=NULL)
    {
		try
		{
			$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
			}
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/GroupServices/listAllVillageGroups';


			

			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}
			$authDataStr = sendPostRequest($url, $dataStr);
			$authData = json_decode($authDataStr);

			//dd($authData);

			if($authData->status==5000) {
				return response()->json(['data' => $authData->groupList, 'success' => true, 'status' => 100], 200);
				
			}
			else if($authData->status==-1) {
				return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
			}
			else
			{
				$status = isset($authData->status) ? $authData->status : null;
				$message = isset($authData->message) ? $authData->message : null;
				return response()->json(['message' => $message!=null ? $message : 'We experienced an issue carrying out the validation', 'success' => true, 'status' => $status!=null ? $status : 4001], 200);
			}
		}
		catch(\Exception $e)
		{
			return response()->json(['message' => "Validation was not successful", 'success' => true, 'status' => 500], 200);
		}
    }



    public function postRunEndOfDay(Request $request, $type=NULL)
    {
		try
		{
			$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
			}
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/runEndOfDay';


			

			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}
			$authDataStr = sendPostRequest($url, $dataStr);
			$authData = json_decode($authDataStr);

			//dd($authData);

			if($authData->status==5000) {
				return response()->json(['data' => [], 'success' => true, 'status' => 100], 200);
				
			}
			else if($authData->status==-1) {
				return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
			}
			else
			{
				$status = isset($authData->status) ? $authData->status : null;
				$message = isset($authData->message) ? $authData->message : null;
				return response()->json(['message' => $message!=null ? $message : 'We experienced an issue running your end of day', 'success' => true, 'status' => $status!=null ? $status : 4001], 200);
			}
		}
		catch(\Exception $e)
		{
//dd($e);
			return response()->json(['message' => "Running End of Day was not successful", 'success' => true, 'status' => 500], 200);
		}
    }




    public function postGetEndOfDayRanList(Request $request, $type=NULL)
    {
		try
		{
			$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
			}
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/getEndOfDaysRan';


			

			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}
			$authDataStr = sendPostRequest($url, $dataStr);
			$authData = json_decode($authDataStr);

			//dd($authData);

			if($authData->status==5000) {
				return response()->json(['data' => $authData->eodRan, 'success' => true, 'status' => 100], 200);
				
			}
			else if($authData->status==-1) {
				return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
			}
			else
			{
				$status = isset($authData->status) ? $authData->status : null;
				$message = isset($authData->message) ? $authData->message : null;
				return response()->json(['message' => $message!=null ? $message : 'We experienced an issue pulling your list of End of Day ran', 'success' => true, 'status' => $status!=null ? $status : 4001], 200);
			}
		}
		catch(\Exception $e)
		{

			return response()->json(['message' => "We experienced an issue pulling your list of End of Day", 'success' => true, 'status' => 500], 200);
		}
    }




    public function postGetChargeList(Request $request, $type=NULL)
    {
		try
		{
			$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['appId'] = $request->get('appId');
				$data['encryptedData'] = urlencode($request->get('encryptedData'));
				$data['token'] = $token;
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$data['appId'] = $request->get('appId');
				$data['encryptedData'] = urlencode($request->get('encryptedData'));
				$all = $request->all();
			}
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountingServicesV2/listServiceCharges';


			//return response()->json(['data' => $all, 'success' => false, 'status' => 100], 200);

			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}

			//return response()->json(['data' => $data, 'success' => false, 'status' => 100], 200);


			$authDataStr = sendPostRequest($url, $dataStr);
			$authData = json_decode($authDataStr);

			//dd($authData);

			

			if($authData->status==5000) {
				$serviceChargeList = $authData->serviceChargeList;


				$arr = [];
				foreach($serviceChargeList as $sc)
				{
					array_push($arr, getAllServiceTypes()[$sc->serviceTypeName]."###".($sc->valueType==1 ? ('ZMW'.number_format($sc->valuation, 2, '.', ',')) : (number_format($sc->valuation, 2, '.', ',').'%')));
				}
				sort($arr);
				return response()->json(['data' => $arr, 'success' => true, 'status' => 100], 200);
				
			}
			else if($authData->status==-1) {
				return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
			}
			else
			{
				$status = isset($authData->status) ? $authData->status : null;
				$message = isset($authData->message) ? $authData->message : null;
				return response()->json(['message' => $message!=null ? $message : 'We experienced an issue pulling a list of our current charges', 'success' => true, 'status' => $status!=null ? $status : 4001], 200);
			}
		}
		catch(\Exception $e)
		{

			return response()->json(['message' => "We experienced an issue pulling a list of our current charges", 'success' => true, 'status' => 500], 200);
		}
    }





    public function postGetSavingsList(Request $request, $type=NULL)
    {
		$authData = null;
		try
		{
			$token = null;
			$data = [];
			$all = [];

			//return response()->json(['data' => [333], 'success' => false, 'status' => 100], 200);
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$data['deviceCode'] = $request->get('deviceCode');
				$data['merchantId'] = $request->get('merchantId');
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$data['deviceCode'] = $request->get('deviceCode');
				$data['merchantId'] = $request->get('merchantId');
				$all = $request->all();
			}
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountingServicesV2/listSavings';


			//return response()->json(['data' => $all, 'success' => false, 'status' => 100], 200);

			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}

			


			$authDataStr = sendPostRequest($url, $dataStr);


			//return response()->json(['data' => $authDataStr, 'success' => false, 'status' => 100], 200);
			$authData = json_decode($authDataStr);

			//dd($authData);

			

			if($authData->status==5000) {
				$savingsList = $authData->savingsList;


				
				return response()->json(['data' => $savingsList, 'success' => true, 'status' => 100], 200);
				
			}
			else if($authData->status==-1) {
				return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
			}
			else
			{
				$status = isset($authData->status) ? $authData->status : null;
				$message = isset($authData->message) ? $authData->message : null;
				return response()->json(['message' => $message!=null ? $message : 'We experienced an issue pulling a list of your savings', 'success' => true, 'status' => $status!=null ? $status : 4001, 'ad'=>$authData], 200);
			}
		}
		catch(\Exception $e)
		{

			return response()->json(['message' => "We experienced an issue pulling a list of your savings", 'success' => true, 'status' => 500, 'e'=>$e->getMessage(), 'dd'=>$authData ], 200);
		}
    }





    public function postGetBorrowingsList(Request $request, $type=NULL)
    {
		$authData = null;
		try
		{
			$token = null;
			$data = [];
			$all = [];

			//return response()->json(['data' => [333], 'success' => false, 'status' => 100], 200);
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$data['deviceCode'] = $request->get('deviceCode');
				$data['merchantId'] = $request->get('merchantId');
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$data['deviceCode'] = $request->get('deviceCode');
				$data['merchantId'] = $request->get('merchantId');
				$all = $request->all();
			}
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountingServicesV2/listBorrowings';


			//return response()->json(['data' => $all, 'success' => false, 'status' => 100], 200);

			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}

			


			$authDataStr = sendPostRequest($url, $dataStr);


			//return response()->json(['data' => $authDataStr, 'success' => false, 'status' => 100], 200);
			$authData = json_decode($authDataStr);

			//dd($authData);

			

			if($authData->status==5000) {
				$savingsList = $authData->borrowingsList;


				
				return response()->json(['data' => $savingsList, 'success' => true, 'status' => 100], 200);
				
			}
			else if($authData->status==-1) {
				return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
			}
			else
			{
				$status = isset($authData->status) ? $authData->status : null;
				$message = isset($authData->message) ? $authData->message : null;
				return response()->json(['message' => $message!=null ? $message : 'We experienced an issue pulling a list of your borrowings', 'success' => true, 'status' => $status!=null ? $status : 4001, 'ad'=>$authData], 200);
			}
		}
		catch(\Exception $e)
		{

			return response()->json(['message' => "We experienced an issue pulling a list of your borrowings", 'success' => true, 'status' => 500, 'e'=>$e->getMessage(), 'dd'=>$authData ], 200);
		}
    }




	public function getLendingParameters(Request $request, $type=NULL)
	{
		try
		{
			$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
			}
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/listLendingDetails';


			

			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}

			//return response()->json(['data' => $data, 'success' => false, 'status' => 100], 200);


			$authDataStr = sendPostRequest($url, $dataStr);
			$authData = json_decode($authDataStr);

			//dd($authData);

			if($authData->status==5000) {
				return response()->json(['data' => ['rate'=> $authData->rate, 'maxAmount'=>$authData->maximumAmount], 'success' => true, 'status' => 100], 200);
				
			}
			else if($authData->status==-1) {
				return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
			}
			else
			{
				$status = isset($authData->status) ? $authData->status : null;
				$message = isset($authData->message) ? $authData->message : null;
				return response()->json(['message' => $message!=null ? $message : 'We experienced an issue pulling your lending details', 'success' => true, 'status' => $status!=null ? $status : 4001], 200);
			}
		}
		catch(\Exception $e)
		{

			return response()->json(['message' => "We experienced an issue pulling your lending details", 'success' => true, 'status' => 500], 200);
		}
	}





    public function postGetActiveMastercardList(Request $request, $type=NULL)
    {
		try
		{
			$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['appId'] = $request->get('appId');
				$data['encryptedData'] = urlencode($request->get('encryptedData'));
				$data['token'] = $token;
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$data['appId'] = $request->get('appId');
				$data['encryptedData'] = urlencode($request->get('encryptedData'));
				$all = $request->all();
			}
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/listActiveMasterCards';


			

			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}

			//return response()->json(['data' => $data, 'success' => false, 'status' => 100], 200);


			$authDataStr = sendPostRequest($url, $dataStr);
			$authData = json_decode($authDataStr);

			//dd($authData);

			if($authData->status==1000033) {
				return response()->json(['data' => $authData->cardEntries, 'success' => true, 'status' => 100], 200);
				
			}
			else if($authData->status==-1) {
				return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
			}
			else
			{
				$status = isset($authData->status) ? $authData->status : null;
				$message = isset($authData->message) ? $authData->message : null;
				return response()->json(['message' => $message!=null ? $message : 'We experienced an issue pulling your list of your cards', 'success' => true, 'status' => $status!=null ? $status : 4001], 200);
			}
		}
		catch(\Exception $e)
		{

			return response()->json(['message' => "We experienced an issue pulling your list of your cards", 'success' => true, 'status' => 500], 200);
		}
    }



    public function postViewAutomaticBillPayments(Request $request, $type=NULL)
    {
		try
		{
			$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['token'] = $token;
				$data['deviceCode'] = $request->get('deviceCode');
				$data['merchantId'] = $request->get('merchantId');
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$data['deviceCode'] = $request->get('deviceCode');
				$data['merchantId'] = $request->get('merchantId');
				$all = $request->all();
			}
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BillServicesV2/listAutomaticBillPurchases';




			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}

			//return response()->json(['data' => $data, 'success' => false, 'status' => 100], 200);
			//return response()->json(['message' => $authData, 'success' => true, 'status' => 500], 200);

			$authDataStr = sendPostRequest($url, $dataStr);
			$authData = json_decode($authDataStr);
			//return response()->json(['message' => $authData->status, 'success' => true, 'status' => 500], 200);
			//dd($authData);

			if($authData->status==5000) {
				return response()->json(['data' => $authData->billAutoDebitMandates, 'success' => true, 'status' => 100], 200);
				
			}
			else if($authData->status==-1) {
				return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
			}
			else
			{
				$status = isset($authData->status) ? $authData->status : null;
				$message = isset($authData->message) ? $authData->message : null;
				return response()->json(['message' => $message!=null ? $message : 'We experienced an issue pulling your list of your automatic bill payments', 'success' => true, 'status' => $status!=null ? $status : 4001], 200);
			}
		}
		catch(\Exception $e)
		{

			return response()->json(['message' => "We experienced an issue pulling your list of your automatic bill payments", 'success' => true, 'status' => 500], 200);
		}
    }





    public function postStartAutoBillPayment(Request $request, $type=NULL)
    {
		try
		{
			$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['accountIdentifier'] = $request->get('accountIdentifier');
				$data['recipientDeviceNumber'] = $request->get('recipientDeviceNumber');
				$data['intervalType'] = $request->get('intervalType');
				$data['debitSourceType'] = $request->get('debitSourceType');
				$data['amount'] = $request->get('amount');
				$data['cardSerialNo'] = $request->get('cardSerialNo');
				$data['cardTrackingNo'] = $request->get('cardTrackingNo');
				$data['deviceCode'] = $request->get('deviceCode');
				$data['merchantId'] = $request->get('merchantId');
				$data['billType'] = $request->get('billType');
				$data['endDate'] = $request->get('endDate');
				$data['token'] = $token;
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['accountIdentifier'] = $request->get('accountIdentifier');
				$data['recipientDeviceNumber'] = $request->get('recipientDeviceNumber');
				$data['intervalType'] = $request->get('intervalType');
				$data['debitSourceType'] = $request->get('debitSourceType');
				$data['amount'] = $request->get('amount');
				$data['cardSerialNo'] = $request->get('cardSerialNo');
				$data['cardTrackingNo'] = $request->get('cardTrackingNo');
				$data['deviceCode'] = $request->get('deviceCode');
				$data['merchantId'] = $request->get('merchantId');
				$data['billType'] = $request->get('billType');
				$data['endDate'] = $request->get('endDate');
				$data['token'] = \Auth::user()->token;
				$all = $request->all();
			}
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BillServicesV2/createBillAutoPurchase';

			//return response()->json($data);
			

			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}

			//return response()->json(['data' => $data, 'success' => false, 'status' => 100], 200);


			$authDataStr = sendPostRequest($url, $dataStr);
			$authData = json_decode($authDataStr);

			//dd($authData);

			if($authData->status==5000) {
				return response()->json(['message' => $authData->message, 'success' => true, 'status' => 100], 200);
				
			}
			else if($authData->status==-1) {
				return response()->json(['message' => "Login to continue", 'success' => false, 'status' => -1], 200);
			}
			else
			{
				$status = isset($authData->status) ? $authData->status : null;
				$message = isset($authData->message) ? $authData->message : null;
				return response()->json(['message' => $message!=null ? $message : 'We experienced an issue creating your automatic billing', 'success' => true, 'status' => $status!=null ? $status : 4001], 200);
			}
		}
		catch(\Exception $e)
		{

			return response()->json(['message' => "We experienced an issue creating your automatic billing", 'success' => true, 'status' => 500], 200);
		}
    }






    public function postStopAutoBillPayment(Request $request, $type=NULL)
    {
		try
		{
			$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['autoBillId'] = $request->get('autoBillId');
				$data['token'] = $token;
				$data['deviceCode'] = $request->get('deviceCode');
				$data['merchantId'] = $request->get('merchantId');
				$data['billType'] = $request->get('billType');
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['autoBillId'] = $request->get('autoBillId');
				$data['token'] = \Auth::user()->token;
				$data['deviceCode'] = $request->get('deviceCode');
				$data['merchantId'] = $request->get('merchantId');
				$data['billType'] = $request->get('billType');
				$all = $request->all();
			}
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BillServicesV2/stopBillAutoPurchase';

			//return response()->json($data);
			

			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}

			//return response()->json(['data' => $data, 'success' => false, 'status' => 100], 200);


			$authDataStr = sendPostRequest($url, $dataStr);
			$authData = json_decode($authDataStr);

			//dd($authData);

			if($authData->status==5000) {
				return response()->json(['message' => $authData->message, 'success' => true, 'status' => 100], 200);
				
			}
			else if($authData->status==-1) {
				return response()->json(['message' => "Login to continue", 'success' => false, 'status' => -1], 200);
			}
			else
			{
				$status = isset($authData->status) ? $authData->status : null;
				$message = isset($authData->message) ? $authData->message : null;
				return response()->json(['message' => $message!=null ? $message : 'We experienced an issue stopping your automatic billing', 'success' => true, 'status' => $status!=null ? $status : 4001], 200);
			}
		}
		catch(\Exception $e)
		{

			return response()->json(['message' => "We experienced an issue stopping your automatic billing", 'success' => true, 'status' => 500], 200);
		}
    }




	public function postGetMastercardList(Request $request, $type=NULL)
    {
		try
		{
			$token = null;
			$data = [];
			$all = [];
			if($type!=null && $type==1)
			{
				$token = $request->get('token');
				$data['appId'] = $request->get('appId');
				$data['encryptedData'] = urlencode($request->get('encryptedData'));
				$data['token'] = $token;
				$all = $request->all();
				unset($all['token']);
			}
			else
			{
				$token = $request->bearerToken();
				$user = JWTAuth::toUser($token);
				$data['token'] = \Auth::user()->token;
				$data['appId'] = $request->get('appId');
				$data['encryptedData'] = urlencode($request->get('encryptedData'));
				$all = $request->all();
			}
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/listActiveMasterCards';
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/listAllMasterCards';

			//return response()->json(['data212' => $all], 200);
			

			$result = null;
			$dataStr = "";
			foreach($data as $d => $v)
			{
				$dataStr = $dataStr."".$d."=".$v."&";
			}

			//return response()->json(['data' => $data, 'success' => false, 'status' => 100], 200);


			$authDataStr = sendPostRequest($url, $dataStr);
			$authData = json_decode($authDataStr);

			//dd($authData);

			if($authData->status==1000033) {
				return response()->json(['data' => $authData->cardEntries, 'success' => true, 'status' => 100], 200);
				
			}
			else if($authData->status==-1) {
				return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
			}
			else
			{
				$status = isset($authData->status) ? $authData->status : null;
				$message = isset($authData->message) ? $authData->message : null;
				return response()->json(['message' => $message!=null ? $message : 'We experienced an issue pulling your list of your Mastercard cards', 'success' => true, 'status' => $status!=null ? $status : 4001], 200);
			}
		}
		catch(\Exception $e)
		{

			return response()->json(['message' => "We experienced an issue pulling your list of your Mastercard cards", 'success' => true, 'status' => 500], 200);
		}
    }






	public function pullCustomerAccountList(Request $request, $customerId=NULL)
	{
		$token = $request->bearerToken();
		$user = JWTAuth::toUser($token);

		$data = array();
        	$data['token'] = $user->token;
        	$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/listCustomerAccounts';
        	if($user->role_code==\App\Models\Roles::$CUSTOMER)
        	{
            		$data['userId'] = (intval(\Auth::user()->id));
            		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/listCustomerAccountsByUserId';
        	}
        	else {
            		if ($customerId != NULL)
                		$data['customerId'] = (intval($customerId));
        	}


		$dataStr = "";
		foreach($data as $d => $v)
		{
			$dataStr = $dataStr."".$d."=".$v."&";
		}

		//$result = handleSOAPCalls('listCustomerAccounts', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServices?wsdl', $data);

		$result = sendGetRequest($url, $dataStr);
		$result = json_decode($result);
		//dd($result);
		//dd($result->customeracctlist[0]);

		if($result==null)
		{
			return response()->json(['message' => 'Error encountered', 'success'=>false], 200);
		}

        if($result->status == 110)
        {

            $customer = isset($result->customer) ? ($result->customer) : null;
            $accessingUserRole = getRoleInterpretRoute(\Auth::user()->role_code);
            $user = \Auth::user();


			$list = ($result->customeracctlist);
			//dd($list[sizeof($list)-1]);
			$allDt = [];
			for($i1=0; $i1<sizeof($list); $i1++)
			{
				//dd($list[$i1]);
				$y =$list[$i1]->id;
				$dt = [];
				$dt['id']= $list[$i1]->id;
				$dt['customerName']= isset($list[$i1]->firstName) && isset($list[$i1]->lastName) ? $list[$i1]->firstName.' '.$list[$i1]->lastName : 'N/P';
				$dt['accountIdentifier']= $list[$i1]->accountIdentifier;
				$dt['accountType'] = str_replace("_", " ", array_keys(getAllAccountType())[$list[$i1]->accountType]);
				$dt['bankName'] = $list[$i1]->bankName;
				$dt['accountBalance'] = isset($list[$i1]->accountBalance) ? (number_format($list[$i1]->accountBalance, 2, '. ', ',')) : (number_format(0, 2, '. ', ','));
				$dt['currency'] = array_keys(getAllCurrency())[$list[$i1]->probasePayCurrency];
				$dt['status'] = get_account_status()[$list[$i1]->status];

				$str = "";
				$str = $str.'<div class="btn-group" id="btngroup'.$dt['id'].'">';
					//$str = $str.'<button class="btn btn-sm btn-primary" type="button">Action</button>';
					$str = $str.'<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button" aria-expanded="false">';
						$str = $str.'<span class="caret"></span>';
						$str = $str.'<span class="sr-only">Toggle Dropdown</span>';
					$str = $str.'</button>';
					$str = $str.'<ul role="menu" class="dropdown-menu">';
					if(\Auth::user()->role_code == \App\Models\Roles::$ACCOUNTANT)
					{
						$str = $str.'<li><a href="/accountant/accounts/statement-of-account/wallet/'.$y.'">View Wallet Statement</a></li>';
					}
					else
					{
						//$str = $str.'<li id="addCardWalletLink'.$y.'"><a style="cursor: pointer" data-target="#new_card_modal" data-toggle="modal" class="" onclick="javascript:addNewCard('.$list[$i1]->id.', \''.$list[$i1]->accountIdentifier.'\', \''.($list[$i1]->lastName.' '.$list[$i1]->firstName.(isset($list[$i1]->otherName) && $list[$i1]->otherName!=null ? ' '.$list[$i1]->otherName : '')).'\', \''.$list[$i1]->verificationNumber.'\', \''.$dt['currency'].'\', \''.$list[$i1]->acquirer_id.'\');">Add Card To Wallet</a></li>';
						$str = $str.'<li><a style="cursor: pointer" data-target="#account_cards_modal" data-toggle="modal" class="" onclick="javascript:viewAccountCards(\''.\Session::get('jwt_token').'\', '.$list[$i1]->id.', \''.$list[$i1]->accountIdentifier.'\', \''.($list[$i1]->lastName.' '.$list[$i1]->firstName.(isset($list[$i1]->otherName) && $list[$i1]->otherName!=null ? ' '.$list[$i1]->otherName : '')).'\', \''.$list[$i1]->verificationNumber.'\');">Wallet Cards</a></li>';
						if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
						{
                            $str = $str.'<li id="fundWalletLink'.$y.'"><a style="cursor: pointer !important" data-target="#fund_account_modal" data-toggle="modal" onclick="fundAccount(\''.$dt['accountIdentifier'].'\', \''.$dt['accountIdentifier'].'<br>'.$dt['bankName'].'\', '.$y.', \''.\Session::get('jwt_token').'\');loadAId('.$y.', \'fundAccount\')">Fund Wallet</a></li>';
							//$str = $str.'<li><a style="cursor: hand" data-target="#new_card_modal" data-toggle="modal" onclick="javascript:loadAddNewCardView(\''.$dt['accountIdentifier'].'\', \''.$list[$i1]->firstName.'\', \''.$list[$i1]->lastName.'\', \''.$list[$i1]->verificationNumber.'\');">Add New Credit/Debit Card</a></li>';
						}
						//$str = $str.'<li><a  style="cursor: pointer" onclick="javascript:shownewcard(2, \''.$dt['accountIdentifier'].' - '.$dt['bankName'].'\', '.$y.');loadAId('.$y.', \'last5txns\')">Last 5 Transactions</a></li>';
						$str = $str.'<li><a style="cursor: hand" data-target="#transaction_modal" data-toggle="modal" onclick="javascript:loadTransactionModalView(\''.\Session::get('jwt_token').'\', \''.$dt['accountIdentifier'].'\', \''.$list[$i1]->firstName.'\', \''.$list[$i1]->lastName.'\', \''.$list[$i1]->verificationNumber.'\', '.$y.');">Last 5 Transactions</a></li>';

						if(\Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER)
						{
							if(get_account_status()[$list[$i1]->status]=='ACTIVE')
							{
								$str = $str.'<li id="deactivateWalletLink'.$y.'"><a onclick="updateAccountStatus(0, '.$y.', \''.\Session::get('jwt_token').'\')" style="cursor: pointer !important;">Deactivate EWallet</a></li>';
							}
							else
							{
								$str = $str.'<li id="deactivateWalletLink'.$y.'"><a onclick="updateAccountStatus(1, '.$y.', \''.\Session::get('jwt_token').'\')" style="cursor: pointer !important;">Activate EWallet</a></li>';
							}
						}

						if(isset($value->customer->customerType) && $value->customer->customerType!=NULL && $value->customer->customerType=="CORPORATE")
						{
							$str = $str.'<li><a href="/bank-teller/accounts/list-corporate-sub-accounts/'.$y.'">View Corporate Customers </a></li>';
							$str = $str.'<li><a href="/bank-teller/accounts/download-batch-accounts-template/'.$y.'">Batch Sub-Account Template</a></li>';
							$str = $str.'<li><a href="/bank-teller/accounts/upload-batch-accounts-template/'.$y.'">Upload Sub-Account Template</a></li>';


						}
					}
					$str = $str.'</ul>';
				$str = $str.'</div>';
				$dt['action'] = $str;
				array_push($allDt, $dt);
			}
//dd($result);
            		if(isset($result->customer))
			    	return response()->json(['status'=>110, 'data' => $allDt, 'customer'=>$result->customer]);
            		else
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




	public function getMasterCardDailyReports()
	{

		$date1_ = date('Y-m-d');
		$date1 = date('Ymd', strtotime('-1 day', strtotime($date1_)));
		$date2 = date('Y_m_d', strtotime('-1 day', strtotime($date1)));
		//dd($date1);
		$reportdate = date('Y-m-d');
		$reportdate = date('Y-m-d', strtotime('-1 day', strtotime($reportdate)));


		/*for($uu=6; $uu<7; $uu++)
		{
			$uu1 = $uu<10 ? "0".$uu : $uu;
		$date1 = "202204".$uu1;
		$date2 = "2022_04_".$uu1;
		$reportdate = "2022-04-".$uu1;*/

		$url = storage_path('app').'/mastercardreports/'.$reportdate;
		if(!\File::exists($url))
			$x = \File::makeDirectory($url);
		//dd([$url, $x, storage_path('app')]);
		
		

		$url_physical_prefix = "https://voucherengine.tutuka.com/downloads/E0C958C2-90FC-6089-47BDE851DF5BBC25/";
		$urlsphysical = [];
		$urlsvirtual = [];


		array_push($urlsphysical, "ProbasePhysicalcards_MarkOffFile_GMT_plus_2_00h00_".$date1.".csv|||Mark off file");
		array_push($urlsphysical, "DailySettlementReport_CAMID1754_(".$date2.").xls|||Card programme Summary Settlement file");
		array_push($urlsphysical, "Daily_Settlement_Report_ICA031082_(".$date2.").xls|||ICA Summary Settlement file");
		array_push($urlsphysical, "ProbasePhysicalcardsDailySettlements".$date1.".csv|||Detailed Settlement file");
		array_push($urlsphysical, "Forex_Fee_Report_".$date2.".csv|||FX markup file");
		array_push($urlsphysical, "ProbasePhysicalcards_UnsettledTransactionReport_".$date1.".csv|||Unsettled Transaction Report");
		array_push($urlsphysical, "ProbasePhysicalcards_Linked_Cards_".$date1.".csv|||Card Linked report");
		array_push($urlsphysical, "ProbasePhysicalcards_DailyAuthFailure_".$date1.".csv|||Failed transaction report");
		array_push($urlsphysical, "ProbasePhysicalcards_ProbaseEMV_PanDetails_".$date1.".csv|||PAN detail report");

		$url_virtual_prefix = "https://voucherengine.tutuka.com/downloads/E17AF254-F484-74CA-9AB54549885E166D/";
		array_push($urlsvirtual, "ProbaseVirtualCompanion_Created_Cards_".$date1.".csv|||Card created report");
		array_push($urlsvirtual, "ProbaseVirtualCompanion_Linked_Cards_".$date1.".csv|||Card linked report");
		array_push($urlsvirtual, "ProbaseVirtualCompanion_MarkOffFile_GMT_plus_2_00h00_".$date1.".csv|||Mark off file");
		array_push($urlsvirtual, "DailySettlementReport_CAMID1756_(".$date2.").xls|||Card programme Summary Settlement file");
		array_push($urlsvirtual, "Daily_Settlement_Report_ICA031082_(".$date2.").xls|||ICA Summary Settlement file");
		array_push($urlsvirtual, "ProbaseVirtualCompanionDailySettlements".$date1.".csv|||Detailed Settlement file");
		array_push($urlsvirtual, "Forex_Fee_Report_".$date2.".csv|||FX markup file");
		array_push($urlsvirtual, "ProbaseVirtualCompanion_UnsettledTransactionReport_".$date1.".csv|||Unsettled Transaction Report");
		array_push($urlsvirtual, "ProbaseVirtualCompanion_DailyAuthFailure_".$date1.".csv|||Failed transaction report");



		$reports = \App\Models\Report::where('report_date', '=', $reportdate)->get();
		foreach($reports as $r)
		{
			$r->delete();
		}


		
		
		foreach($urlsphysical as $u)
		{
			$url = $url_physical_prefix ."".explode('|||', $u)[0];

			$report = new \App\Models\Report();
			$report->name = explode('|||', $u)[0];
			$report->report_type = explode('|||', $u)[1];
			$report->report_date = $reportdate;
			$report->is_downloaded = 0;
			$report->is_physical_card = 1;

			try
			{
				$contents = file_get_contents($url);
				$name = explode('|||', $u)[0];
				file_put_contents(storage_path('app').'/mastercardreports/'.$reportdate.'/'.$name, $contents);
				$report->is_downloaded = 1;
			}
			catch(\Exception $e)
			{
				$report->is_downloaded = 0;
				$report->fail_reason = $e->getMessage()." - ".$e->getLine();				
			}
			$report->save();
		}


		foreach($urlsvirtual as $u)
		{
			$url = $url_virtual_prefix."".explode('|||', $u)[0];

			$report = new \App\Models\Report();
			$report->name = explode('|||', $u)[0];
			$report->report_type = explode('|||', $u)[1];
			$report->report_date = $reportdate;
			$report->is_downloaded = 0;
			$report->is_physical_card = 0;

			try
			{
				$contents = file_get_contents($url);
				$name = explode('|||', $u)[0];
				file_put_contents(storage_path('app').'/mastercardreports/'.$reportdate.'/'.$name, $contents);
				$report->is_downloaded = 1;
			}
			catch(\Exception $e)
			{
				$report->is_downloaded = 0;
				$report->fail_reason = $e->getMessage()." - ".$e->getLine();				
			}
			$report->save();
		}



		/*$zip = new ZipArchive;
		$xx=0;
		$fileName = storage_path('app').'/mastercardreports/report'.$reportdate.'.zip';
		if ($zip->open(($fileName), ZipArchive::CREATE) === TRUE)
		{
			$files = \File::files(storage_path('app').'/mastercardreports');
			foreach ($files as $key => $value) {
				$relativeNameInZipFile = basename($value);
				$zip->addFile($value, $relativeNameInZipFile);
			}
			$zip->close();
			$xx=1;
		}



		}*/

		return response()->json(['status' => 0, "message"=> 'OK']);
	}




	public function postUploadBatchCardToServer(Request $request)
	{
        	//dd(\Auth::user());
        	$push_ = [];
        	$ar = [];
		$ar['serialNo'] = $request->get('serialNo');
              $ar['trackingNumber'] = $request->get('trackingNo')."";
              $ar['cardNumber'] = $request->get('panNo')."";
              $ar['cardBatchCode'] = $request->get('cardBatchCode')."";
		array_push($push_, $ar);

        	$data['token'] = \Auth::user()->token;
        	$data['acquirerId'] = $request->get('acquirer');
        	$data['issuerId'] = $request->get('issuer');
        	$data['encryptedData'] = \Crypt::encrypt(json_encode($push_));

        	//dd($data);

        	$dataStr = "";
        	foreach($data as $d => $v)
        	{
            		$dataStr = $dataStr."".$d."=".$v."&";
        	}



		$cardBinCount = \App\Models\CardBin::where('serial_no','=', $request->get('serialNo'))->where('tracking_no','=', $request->get('trackingNo'))->where('pan','=', $request->get('panNo'))->where('status', '=', 1);
		//dd($cardBinCount);

		if($cardBinCount->count()>0)
		{
            		return response()->json(['status' => 1, "success"=>false, "message"=> 'Failed', 'message2'=>'Card already uploaded']);
		}

        	//dd($dataStr);

        	$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/uploadPhysicalCardBin';
        	$result = sendPostRequest($url, $dataStr);
        	$result = json_decode($result);



        	//$result = handleSOAPCalls('uploadTutukaCompanionPhysicalCardBin', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/TutukaServices?wsdl', $data);
       	// $result = handleSOAPCalls('uploadPhysicalCardBin', 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/CardServicesV2?wsdl', $data);
       	handleTokenUpdate($result);


        	if (handleTokenUpdate($result) === false) {
            		return response()->json(['status' => 1, "success"=>false, "message"=> 'Failed', 'message2'=>'Session expired']);
        	}

        	//dd($result);
        	if($result->status == 5000)
        	{
			$cardBin = new \App\Models\CardBin();
			$cardBin->serial_no = $request->get('serialNo');
			$cardBin->tracking_no = $request->get('trackingNo');
			$cardBin->pan = $request->get('panNo');
			$cardBin->status = 1;
			$cardBin->uploaded_by_user_id = \Auth::user()->id;
			$cardBin->save();


            		return response()->json(['status' => 0, "success"=>true, "message"=> 'OK']);
        	}else
        	{
            		return response()->json(['status' => 1, "success"=>false, "message"=> 'Failed', 'message2'=>isset($result->message) && !is_null($result->message) ? $result->message : 'Card upload failure']);
        	}

	}




	public function pullSupportMessageList(Request $request)
	{
		$data['token'] = \Auth::user()->token;
        	//$result = handleSOAPCalls('listMerchants', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', $data);
        	$data = 'token='.\Auth::user()->token;
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/getSupportMessages';
       	$authDataStr = sendGetRequest($url, $data);
        	$authData = json_decode($authDataStr);

//dd($authData);

        if($authData->status == 5000) {
            $list = ($authData->supportMessages);
			$allDt = [];
			for($i1=0; $i1<sizeof($list); $i1++)
			{
				//dd($list[$i1]);
				$y =$list[$i1]->id;
				$dt = [];
				$dt['createdAt']= '<strong>'.$list[$i1]->createdAt.'</strong>';
				$dt['sendersName'] = $list[$i1]->sendersName;
				$dt['details'] = $list[$i1]->details;

				$str = "";



				$str = $str.'<div class="btn-group mr-1 mb-1">';;
					$str = $str.'<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>';
					$str = $str.'<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">';


						$str = $str.'<a class="dropdown-item" href="/potzr-staff/support-messages/close-support-message/'.$y.'">Close Support Message</a>';
						
					$str = $str.'</div>';
				$str = $str.'</div>';
				$dt['action'] = $str;
				array_push($allDt, $dt);
			}
			//dd($allDt);
			return response()->json(['status'=>$authData->status, 'data'=>$allDt]);
		}
		else if($authData->status == -1)
		{
			return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
		}
		else
        {
            return response()->json(['status' => 0, 'data' => []]);
        }

	}





    public function pullJournalEntryList(Request $request, $type=NULL)
    {



		try
		{	
			$dataStr = "&token=".\Auth::user()->token."&deviceCode=".PROBASEWALLET_DEVICE_CODE;


			if($request->has("glaccountid") && $request->get("glaccountid")!=null)
				$dataStr = $dataStr."&glAccountId=".$request->get("glaccountid");


			if($request->has("serviceType") && $request->get("serviceType")!=null)
				$dataStr = $dataStr."&serviceType=".$request->get("serviceType");

			if($request->has("startDate") && $request->get("startDate")!=null)
				$dataStr = $dataStr."&startDate=".$request->get("startDate");

			if($request->has("endDate") && $request->get("endDate")!=null)
				$dataStr = $dataStr."&endDate=".$request->get("endDate");



			$glAccountId = $request->has('glaccountid') ? $request->get('glaccountid') : null;
			$glaccountname = $request->has('glaccountname') ? $request->get('glaccountname') : null;
			$glaccountcode = $request->has('glaccountcode') ? $request->get('glaccountcode') : null;
			$dataStr = $dataStr.($glAccountId!=null ? $dataStr."&glAccountId=".$glAccountId : "");
			//dd($dataStr );
			$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/AccountingServicesV2/listJournalEntries';
			$authDataStr = sendPostRequest($url, $dataStr);

			$authData = json_decode($authDataStr);
			//return response()->json($authData, 200);

//dd($authData->status);
			
			if ($authData->status == 5000)
			{	
				$subTitle = '';
				$journalEntryList= $authData->journalEntryList;
				$glAccountTypes = array_values(glAccountTypes());
				$serviceTypes = array_values(getAllServiceTypes());
				if($glAccountId!=null && $glaccountname!=null && $glaccountcode!=null)
				{
					$subTitle = ' for GL Account - '.$glaccountname.' ('.$glaccountcode.')';
				}

				return response()->json(['status'=> 100, 'jeList'=>$journalEntryList, 'glAccountTypes'=>$glAccountTypes, 'serviceTypes'=>$serviceTypes, 'message' => 'Journal Entries Found', 'subTitle'=>$subTitle, 'success' => true], 200);
			} 
			else if ($authData->status == -1) 
			{
				\Auth::logout();
				return response()->json($authData, 200);
			} 
			else 
			{
				return response()->json($authData, 200);
			}

		}
		catch(\Exception $e)
		{
			dd($e);
		}



	/*try
	{

		$token = null;
        	$data = [];
		$all = [];
		$user = null;
		if($type!=null && $type==1)
		{
			$token = $request->get('token');
			$data['token'] = $token;
			$all = $request->all();
			unset($all['token']);
			$data['customerVerificationNumber'] = $request->get('customerVerificationNo');

		}
		else
		{
			$token = $request->bearerToken();
			$user = JWTAuth::toUser($token);
			$data['token'] = \Auth::user()->token;
			$all = $request->all();




        		if($user->role_code==\App\Models\Roles::$CUSTOMER)
            			$data['customerVerificationNumber'] = $user->customerVerificationNo;


        		if($user->role_code==\App\Models\Roles::$AGENT)
			{
            			$data['filter'] = 'agent';
            			$data['agentCode'] = 'IO930dk49';
			}
		}


					$ap = new \App\Models\AppError();
					$ap->error_trace = json_encode($request->all());
					$ap->url = "";
					$ap->error_dump = json_encode($data);
					$ap->user_username = "";
					$ap->save();

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }
	 $filter = null;

	 $filter = $request->has('filter') ? $request->get('filter') : null;
	 $dataStr = $dataStr."&count=".(isset($all['count']) ? $all['count'] : 1000)."&filter=".($filter==null ? '' : $filter);


	foreach($all as $a1 => $a2)
	{
		$dataStr = $dataStr ."&".$a1."=".urlencode($a2);
	}


        //dd($request->all());
		


        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/TransactionServicesV2/listTransactions';
        $server_output = sendGetRequest($url, $dataStr);
//dd($server_output);
        $result = json_decode($server_output);
//dd($result);
	


        if($result==null)
        {
            return response()->json(['message' => 'Error encountered', 'server_output'=>$server_output, 'success'=>false], 200);
        }


        $channelsList = array_keys(getAllChannel());
        $statusList = array_keys(getAllTransactionStatus());
        $currencyList = array_keys(getAllCurrency());
        $serviceTypesList = array_values(getAllServiceTypes());
	 $x11 = 1;
	 //dd($result);
        if($result->status === 410)
        {
            $transactionList = $result->transactionList;

            $dt = [];
		
		if($type!=null && $type==1)
		{

			foreach ($transactionList as $mtl) {




                    		$y = $mtl->id;
                    		$dt_ = [];
                    		$dt_['id'] = $x11++;
                    		$dt_['status'] = ucfirst(strtolower(str_replace('_', ' ', $statusList[$mtl->status])));
				$dt_['transactionDate'] = date('Y, M d H:i', strtotime($mtl->transactionDate)) . '';
				$dt_['transactionRef'] = isset($mtl->transactionRef) && $mtl->transactionRef!=null ? strtoupper(strtolower($mtl->transactionRef)) : null;
				$dt_['transactionDetail'] = isset($mtl->transactionDetail) && $mtl->transactionDetail != null ? $mtl->transactionDetail : 'N/A';
				$dt_['detail'] = isset($mtl->details) && $mtl->details!= null ? $mtl->details: 'N/A';
				$dt_['serviceType'] = isset($serviceTypesList[$mtl->serviceType]) ? ((str_replace('_', ' ', $serviceTypesList[$mtl->serviceType]))) : 'N/A';
				$dt_['currency'] = $currencyList[$mtl->probasePayCurrency];
				$dt_['amount'] = number_format($mtl->amount, 2, '.', ',');
				$dt_['creditAccountTrue'] = isset($mtl->creditAccountTrue) ? $mtl->creditAccountTrue : false;
				$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
				$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
				$dt_['debitCardTrue'] = isset($mtl->debitCardTrue) ? $mtl->debitCardTrue: false;
				$dt_['summary'] = isset($mtl->summary) ? $mtl->summary: null;
				$dt_['isReversed'] = isset($mtl->isReversed) ? $mtl->isReversed: null;
				$dt_['transactionDetail'] = isset($mtl->transactionDetail) ? $mtl->transactionDetail: null;
				$dt_['totalAmountDebited'] = number_format($mtl->amount + ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
						(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');
					if($dt_['serviceType']=="Collect A Village Banking Group Loan" || $dt_['serviceType']=="Group Contributions Close-Out")
					{
						$dt_['creditAccountTrue'] = true;
						$dt_['isCredit'] = true;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitCardTrue'] = false;
						$dt_['totalAmountDebited'] = number_format($mtl->amount, 2, '.', ',');

					}
					else if($dt_['serviceType']=="Withdraw Cash")
					{
						$dt_['detail'] = 'Cash Withdrawal';

					}
					else
					{
						$dt_['creditAccountTrue'] = isset($mtl->creditAccountTrue) ? $mtl->creditAccountTrue : false;
						$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
						$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
						$dt_['debitCardTrue'] = isset($mtl->debitCardTrue) ? $mtl->debitCardTrue: false;
						$dt_['totalAmountDebited'] = number_format($mtl->amount + ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
							(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');
					
					}
				$dt_['customerId'] = isset($mtl->customerId) && $mtl->customerId!=null ?  (($mtl->customerId)) : '';
				$dt_['recipientDetails'] = isset($mtl->recipientDetails) && $mtl->recipientDetails!=null ?  (($mtl->recipientDetails)) : '';



				array_push($dt, $dt_);
			}

		}
		else
		{

            		if($user->role_code==\App\Models\Roles::$CUSTOMER)
            		{
                		foreach ($transactionList as $mtl) {
                    			$y = $mtl->id;
                    			$dt_ = [];
                    			$dt_['id'] = $x11++;



                    			$dt_['status'] = ucfirst(strtolower(str_replace('_', ' ', $statusList[$mtl->status])));
					$dt_['transactionDate'] = date('Y, M d H:i', strtotime($mtl->transactionDate)) . '';
					$dt_['transactionRef'] = isset($mtl->transactionRef) && $mtl->transactionRef!=null ?  strtoupper(strtolower($mtl->transactionRef)) : 'N/A';
					$dt_['transactionDetail'] = isset($mtl->transactionDetail) && $mtl->transactionDetail != null ? $mtl->transactionDetail : 'N/A';
					$dt_['detail'] = isset($mtl->details) && $mtl->details!= null ? $mtl->details: 'N/A';
					$dt_['serviceType'] = isset($serviceTypesList[$mtl->serviceType]) ? ((str_replace('_', ' ', $serviceTypesList[$mtl->serviceType]))) : 'N/A';
					$dt_['currency'] = $currencyList[$mtl->probasePayCurrency];
					$dt_['amount'] = number_format($mtl->amount, 2, '.', ',');
					$dt_['isReversed'] = isset($mtl->isReversed) ? $mtl->isReversed: null;

					if($dt_['serviceType']=="Collect A Village Banking Group Loan")
					{
						$dt_['creditAccountTrue'] = true;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitCardTrue'] = false;
						$dt_['totalAmountDebited'] = number_format($mtl->amount - ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
							(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');

					}
					else if($dt_['serviceType']=="Withdraw Cash")
					{
						$dt_['detail'] = 'Cash Withdrawal';

					}
					else
					{
						$dt_['creditAccountTrue'] = isset($mtl->creditAccountTrue) ? $mtl->creditAccountTrue : false;
						$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
						$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
						$dt_['debitCardTrue'] = isset($mtl->debitCardTrue) ? $mtl->debitCardTrue: false;
						$dt_['totalAmountDebited'] = number_format($mtl->amount + ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
							(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');
					
					}

					$dt_['summary'] = isset($mtl->summary) ? $mtl->summary: null;
					$dt_['transactionDetail'] = isset($mtl->transactionDetail) ? $mtl->transactionDetail: null;


					if($dt_['serviceType']=="Collect A Village Banking Group Loan")
					{
						$dt_['creditAccountTrue'] = true;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitCardTrue'] = false;
						$dt_['totalAmountDebited'] = number_format($mtl->amount - ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
							(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');

					}
					$dt_['customerId'] = isset($mtl->customerId) && $mtl->customerId!=null ?  (($mtl->customerId)) : '';
					$dt_['recipientDetails'] = isset($mtl->recipientDetails) && $mtl->recipientDetails!=null ?  (($mtl->recipientDetails)) : '';
					
					array_push($dt, $dt_);
				}


			}


			else if($user->role_code==\App\Models\Roles::$AGENT)
            		{

                		foreach ($transactionList as $mtl) {
                    			$y = $mtl->id;
                    			$dt_ = [];
                    			$dt_['id'] = $x11++;



                    			$dt_['status'] = ucfirst(strtolower(str_replace('_', ' ', $statusList[$mtl->status])));
					$dt_['transactionDate'] = date('Y, M d H:i', strtotime($mtl->transactionDate)) . '';
					$dt_['transactionRef'] = isset($mtl->transactionRef) && $mtl->transactionRef!=null ?  strtoupper(strtolower($mtl->transactionRef)) : 'N/A';
					$dt_['payerName'] = isset($mtl->payerName) ? (strtoupper(strtolower($mtl->payerName)).'<br>'.(isset($mt1->payerMobile) ? $mt1->payerMobile : '')) : '';
					$dt_['transactionDetail'] = isset($mtl->transactionDetail) && $mtl->transactionDetail != null ? $mtl->transactionDetail : 'N/A';
					$dt_['detail'] = isset($mtl->details) && $mtl->details!= null ? $mtl->details: 'N/A';
					$dt_['serviceType'] = isset($serviceTypesList[$mtl->serviceType]) ? ((str_replace('_', ' ', $serviceTypesList[$mtl->serviceType]))) : 'N/A';
					$dt_['currency'] = $currencyList[$mtl->probasePayCurrency];
					$dt_['amount'] = number_format($mtl->amount, 2, '.', ',');
					$dt_['isReversed'] = isset($mtl->isReversed) ? $mtl->isReversed: null;


					$customData = isset($mtl->customData) && $mtl->customData!=null ? $mtl->customData : null;
					$dt_["bvSource"] = "";
					$dt_["partnerAccount"] = "";
					$dt_["partnerCustomerName"] = "";
					$dt_["partnerType"] = "";
					$dt_["otherBankRef"] = "";
					$dt_["acquirerRef"] = "";
					$dt_["txnType"] = "";
					$dt_["remarks"] = "";

					if($customData!=null)
					{ 
						$customData = explode('|||', $customData);
						$dt_["bvSource"] = $customData[0];
						$dt_["partnerAccount"] = $customData[1];
						$dt_["partnerCustomerName"] = $customData[2];
						$dt_["partnerType"] = $customData[3];
						$dt_["otherBankRef"] = $customData[4];
						$dt_["acquirerRef"] = $customData[5];
						$dt_["txnType"] = $customData[6];
						$dt_["remarks"] = $customData[7];
					}
					

					if($dt_['serviceType']=="Collect A Village Banking Group Loan")
					{
						$dt_['creditAccountTrue'] = true;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitCardTrue'] = false;
						$dt_['totalAmountDebited'] = number_format($mtl->amount - ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
							(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');

					}
					else if($dt_['serviceType']=="Withdraw Cash")
					{
						$dt_['detail'] = 'Cash Withdrawal';

					}
					else
					{
						$dt_['creditAccountTrue'] = isset($mtl->creditAccountTrue) ? $mtl->creditAccountTrue : false;
						$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
						$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
						$dt_['debitCardTrue'] = isset($mtl->debitCardTrue) ? $mtl->debitCardTrue: false;
						$dt_['totalAmountDebited'] = number_format($mtl->amount + ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
							(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');
					
					}

					$dt_['summary'] = isset($mtl->summary) ? $mtl->summary: null;
					$dt_['transactionDetail'] = isset($mtl->transactionDetail) ? $mtl->transactionDetail: null;


					if($dt_['serviceType']=="Collect A Village Banking Group Loan")
					{
						$dt_['creditAccountTrue'] = true;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitAccountTrue'] = false;
						$dt_['debitCardTrue'] = false;
						$dt_['totalAmountDebited'] = number_format($mtl->amount - ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
							(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');

					}
					$dt_['customerId'] = isset($mtl->customerId) && $mtl->customerId!=null ?  (($mtl->customerId)) : '';
					$dt_['recipientDetails'] = isset($mtl->recipientDetails) && $mtl->recipientDetails!=null ?  (($mtl->recipientDetails)) : '';
					$dt_['balance'] = isset($mtl->currentCardBalance) ? number_format($mtl->currentCardBalance, 2, '.', ',') : (isset($mtl->currentAccountBalance) ? number_format($mtl->currentAccountBalance, 2, '.', ',') : 'N/A');

					array_push($dt, $dt_);
				}


			}

			else {
//dd($transactionList );
//dd($serviceTypesList);
				foreach ($transactionList as $mtl) {
					$y = $mtl->id;
					$dt_ = [];



                    			$dt_['id'] = $x11++.".";
					$dt_['transactionDate'] = date('Y, M d H:i', strtotime($mtl->transactionDate))."<br><a style='text-decoration: underline !important; color: #0d6efd !important; cursor: pointer !important'>".join('-', str_split(strtoupper(strtolower($mtl->transactionRef)), 4))."</a>";
					$dt_['payerName'] = isset($mtl->payerName) ? (strtoupper(strtolower($mtl->payerName)).'<br>'.(isset($mt1->payerMobile) ? $mt1->payerMobile : '')) : '';
					$dt_['accountNo'] = isset($mtl->merchantAccount) && $mtl->merchantAccount != null ? $mtl->merchantAccount : 'N/A';
					$dt_['currency'] = $currencyList[$mtl->probasePayCurrency];
					$dt_['isReversed'] = isset($mtl->isReversed) ? $mtl->isReversed: null;
					$dt_['isReversed'] = isset($mtl->isReversed) ? $mtl->isReversed: null;

					$sty = "";
					if(isset($mtl->serviceType))
					{
						if(isset($serviceTypesList[$mtl->serviceType]) && $serviceTypesList[$mtl->serviceType]!=null)
						{
							$sty = $sty.((str_replace('_', ' ', $serviceTypesList[$mtl->serviceType])))."<br>";
						}
						else
						{
							$sty = $sty.$mtl->serviceType."<br>";
						}
					}
					else
					{
						$sty = "Not Applicable<br>";
					}

					if(isset($dt_['currency']))
					{
						$sty = $sty."<small style='float: left !important; padding: 5px !important;'><span class='currencymodespan' title='Currency: ".$dt_['currency']."'>".$dt_['currency']."</span></small>";
					}

					if(isset($mtl->channel))
					{
						$sty = $sty."<small style='float: left !important; padding: 5px !important;'><span class='channelspan' title='Channel: ".ucfirst(strtolower(str_replace('_', ' ', $channelsList[$mtl->channel])))."'>".ucfirst(strtolower(substr($channelsList[$mtl->channel], 0, 1)))."</span></small>";
					}

					if(isset($mtl->debitCardId))
					{
						$sty = $sty."<small style='float: left !important; padding: 5px !important;'><span class='paymentmodespan' title='Payment Mode: Bevura Card'><i class='fa fa-credit-card'></i></span></small>";
					}
					else
					{
						if(isset($mtl->debitAccountId))
							$sty = $sty."<small style='float: left !important; padding: 5px !important;'><span class='paymentmodespan' title='Payment Mode: Bevura Wallet'><i class='fa fa-wallet'></i></span></small>";
					}
					
					
					$dt_['serviceType'] = $sty;
					$dt_['detail'] = isset($mtl->details) && $mtl->details!= null ? $mtl->details: 'N/A';
					$dt_['status'] = '<small><span class="'.strtolower(str_replace('_', ' ', $statusList[$mtl->status])).'status">'.strtoupper(strtolower(str_replace('_', ' ', $statusList[$mtl->status]))).'</span></small>';
					$dt_['amount'] = number_format($mtl->amount, 2, '.', ',');
					$dt_['totalCharges'] = number_format(getDoubleNumb(isset($mtl->fixedCharge) ? $mtl->fixedCharge : 0) + 
						getDoubleNumb(isset($mtl->transactionPercentage) ? $mtl->transactionPercentage : 0) + 
						getDoubleNumb(isset($mtl->schemeTransactionCharge) ? $mtl->schemeTransactionCharge : 0) + 
						getDoubleNumb(isset($mtl->transactionCharge) ? $mtl->transactionCharge : 0), 2, '.', ',');
					$dt_['totalAmountDebited'] = number_format($mtl->amount + ((isset($mtl->fixedCharge) && $mtl->fixedCharge!=null ? $mtl->fixedCharge : 0) + (isset($mtl->transactionPercentage) && $mtl->transactionPercentage!=null ? $mtl->transactionPercentage : 0) + 
						(isset($mtl->schemeTransactionCharge) && $mtl->schemeTransactionCharge!=null ? $mtl->schemeTransactionCharge : 0) + (isset($mtl->transactionCharge) && $mtl->transactionCharge!=null ? $mtl->transactionCharge : 0)), 2, '.', ',');
					$dt_['creditAccountTrue'] = isset($mtl->creditAccountTrue) ? $mtl->creditAccountTrue : false;
					$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
					$dt_['debitAccountTrue'] = isset($mtl->debitAccountTrue) ? $mtl->debitAccountTrue: false;
					$dt_['debitCardTrue'] = isset($mtl->debitCardTrue) ? $mtl->debitCardTrue: false;
					$dt_['summary'] = isset($mtl->summary) ? $mtl->summary: null;
					$dt_['transactionDetail'] = isset($mtl->transactionDetail) ? $mtl->transactionDetail: null;
					$dt_['balance'] = isset($mtl->currentCardBalance) ? number_format($mtl->currentCardBalance, 2, '.', ',') : (isset($mtl->currentAccountBalance) ? number_format($mtl->currentAccountBalance, 2, '.', ',') : 'N/A');
					$dt_['currentPoolAccountBalance'] = isset($mtl->currentPoolAccountBalance) ? number_format($mtl->currentPoolAccountBalance, 2, '.', ',') : 'N/A';
					$str = "";


					$str = $str . '<div class="btn-group mr-1 mb-1">';
					$str = $str.'<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>';
					$str = $str . '<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">';

					if ($statusList[$mtl->status] == 'PENDING') {
						if($user->role_code==\App\Models\Roles::$ACCOUNTANT)
						{
							$str = $str . '<a class="dropdown-item" href="/accountant/transaction/confirm-transaction/' . $y . '">Confirm Transaction</a>';
						}
					}
		            		if($user->role_code==\App\Models\Roles::$ACCOUNTANT)
					{
						$str = $str . '<a style="cursor: pointer !important" class="dropdown-item" onclick="viewJournalEntries(' . $y . ')">View Journal Entries</a>';
						if(isset($dt_['isReversed']) && $dt_['isReversed']==true)
						{

						}
						else
						{
							$str = $str . '<a style="cursor: pointer !important" class="dropdown-item" onclick="viewReverseTransaction(' . $y . ')">Reverse Transaction</a>';
						}
					}
					$str = $str . '</div>';
					$str = $str . '</div>';
					$dt_['action'] = $str;
					$dt_['customerId'] = isset($mtl->customerId) && $mtl->customerId!=null ?  (($mtl->customerId)) : '';
					$dt_['recipientDetails'] = isset($mtl->recipientDetails) && $mtl->recipientDetails!=null ?  (($mtl->recipientDetails)) : '';

					array_push($dt, $dt_);
				}
			}
		}
            	return response()->json(['status' => 100, 'list' => $dt]);
        }
        else if($result->status == -1)
        {
            return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
        }
        else
        {
            return response()->json(['status' => 0, 'message' => isset($result->message) ? $result->message : 'We can not find any card mapped to the card bin.']);
        }
	}
	catch(\Exception $e)
	{
		return response()->json(['status' => 0, 'message' => 'System error', 'ed'=> $e->getMessage(), 'el'=>$e->getLine()]);

	}*/
    }
	
}




	