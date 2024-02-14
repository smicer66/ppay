<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;

class EWalletController extends Controller
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
    
    
    public function validateAndMapExistingZICBWallet()
    {
        $input = \Input::all();
		//return response()->json(['response' => ['status'=> 1, 'message'=>$input]], 200);
		
		$otp1 = $input['otp1'];
		$otp2 = $input['otp2'];
		$otp3 = $input['otp3'];
		$otp4 = $input['otp4'];
		$otp5 = $input['otp5'];
		$otp6 = $input['otp6'];
		$otpRef = $input['otpRef'];
		$otp = $otp1."".$otp2."".$otp3."".$otp4."".$otp5."".$otp6;
		
		$firstName = $input['firstName'];
        $lastName = $input['lastName'];
        $email = $input['email'];
        $payerPhone = $input['payerPhone'];
        $nationalId = $input['nationalId'];
        $streetAddress = $input['streetAddress'];
        $city = $input['city'];
        $province = $input['provincezicb'];
        $district = $input['districtzicb'];
        $merchantCode = $input['merchantCode'];
        $deviceCode = $input['deviceCode'];
        $serviceTypeId = $input['serviceTypeId'];
        $responseUrl = $input['responseUrl'];
        $orderId = $input['orderId'];
        $isWalletOrAccount = $input['isWalletOrAccount'];
        $dateOfBirth = $input['dateOfBirth'];//"1960-12-06";
        $gender = $input['gender'];
        
        $req = [];
        $req['merchantCode'] = $merchantCode;
        $req['deviceCode'] = $deviceCode;
        $req['firstName'] = $firstName;
		$req['lastName'] = $lastName;
		$req['addressLine1'] = $streetAddress;
		$req['addressLine2'] = $city;
		$req['addressLine3'] = $city;
		$req['addressLine4'] = $province;
		$req['addressLine5'] = $district;
		$req['uniqueType'] = "NRC";
		$req['uniqueValue'] = $nationalId;
		$req['dateOfBirth'] = $dateOfBirth;
		$req['email'] = $email;
		$req['sex'] = $gender;
		$req['mobileNumber'] = $payerPhone;
		$req['accType'] = "WA";
		$req['serviceTypeId'] = $serviceTypeId;
		$req['orderId'] = $orderId;
		$req['responseUrl'] = $responseUrl;
		$req['isWalletOrAccount'] = $isWalletOrAccount;
		$req['otp'] = $otp;
		$req['otpref'] = $otpRef;
		$req['bankCode'] = "3001";
		
		//return response()->json(['response' => ['status'=> 2, 'message'=>$req]], 200);
		
		
		
		$result = handleSOAPCalls('verifyZICBOTPAndCreateWallet', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/WalletServices?wsdl', $req);
		return response()->json(['response' => [$result]], 200);
		if($result!=null)
		{
		    //$result = json_decode($result'] = $TRUE);
		    //dd($result);
		    //return response()->json(['response' => [$result]]'] = $200);
		    $status = isset($result->status) ? $result->status : null;
		    $message = isset($result->message) ? $result->message : null;
		    if($status!=null && $status==5004)
		    {
		        $accountBalances = isset($result->accountBalances) ? $result->accountBalances : [];
		        return response()->json(['response' => ['status'=> 1, 'message'=>'A One-Time Password (OTP) has been sent to the mobile number linked to your account. Please provide the OTP in the box below', 'accountBalances' => $accountBalances]], 200);
		    }
		    else if($status!=null && $status==900)
		    {
		        return response()->json(['response' => ['status'=> 2, 'message'=>$input]], 200);
		    }
		    else
		    {
		        return response()->json(['response' => ['status'=> 0, 'message'=>$message==null ? 'We could not verify your mobile number is linked to an existing ZICB Account' : $message]], 200);
		    }
		}
		else 
		{
		    return response()->json(['response' => ['status'=> 0, 'message'=>$message==null ? 'We could not verify your mobile number is linked to an existing ZICB Account' : $message]], 200);
		}
    }
    
    public function createZICBWallet(Request $request)
    {
        $input = $request->all();
		//return response()->json(['response' => ['status'=> 1, 'message'=>$input]], 200);
		
		$firstName = $input['firstName'];
        $lastName = $input['lastName'];
        $email = $input['email'];
        $payerPhone = $input['payerPhone'];
        $nationalId = $input['nationalId'];
        $streetAddress = $input['streetAddress'];
        $city = $input['city'];
        $province = $input['provincezicb'];
        $district = $input['districtzicb'];
        $merchantCode = $input['merchantCode'];
        $deviceCode = $input['deviceCode'];
        $serviceTypeId = $input['serviceTypeId'];
        $responseUrl = $input['responseUrl'];
        $orderId = $input['orderId'];
        $isWalletOrAccount = $input['isWalletOrAccount'];
        
        $req = [];
        $req['merchantCode'] = $merchantCode;
        $req['deviceCode'] = $deviceCode;
        $req['firstName'] = $firstName;
		$req['lastName'] = $lastName;
		$req['addressLine1'] = $streetAddress;
		$req['addressLine2'] = $city;
		$req['addressLine3'] = $city;
		$req['addressLine4'] = $province;
		$req['addressLine5'] = $district;
		$req['email'] = $email;
		$req['mobileNumber'] = $payerPhone;
		$req['serviceTypeId'] = $serviceTypeId;
		$req['orderId'] = $orderId;
		$req['responseUrl'] = $responseUrl;
		$req['isWalletOrAccount'] = $isWalletOrAccount;
			
		$result = handleSOAPCalls('mapExistingBankWallet', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/WalletServices?wsdl', $req);
		if($result!=null)
		{
		    //$result = json_decode($result'] = $TRUE);
		    //dd($result);
		    //return response()->json(['response' => [$result]]'] = $200);
		    $status = isset($result->status) ? $result->status : null;
		    $message = isset($result->message) ? $result->message : null;
		    if($status!=null && $status==5004)
		    {
		        $accountBalances = isset($result->accountBalances) ? $result->accountBalances : [];
		        return response()->json(['response' => ['status'=> 1, 'input'=>$input, 'message'=>'A One-Time Password (OTP) has been sent to the mobile number linked to your account. Please provide the OTP in the box below', 'accountBalances' => $accountBalances]], 200);
		    }
		    else if($status!=null && $status==900)
		    {
		        return response()->json(['response' => ['status'=> 2, 'otpRef'=>$result->otpRef, 'input'=>$input, 'message'=>'A One-Time Password (OTP) has been sent to the mobile number linked to your account. Please provide the OTP in the box below']], 200);
		    }
		    else
		    {
		        return response()->json(['response' => ['status'=> 0, 'input'=>$input, 'message'=>$message==null ? 'We could not verify your mobile number is linked to an existing ZICB Account' : $message]], 200);
		    }
		}
		else 
		{
		    return response()->json(['response' => ['status'=> 0, 'input'=>$input, 'message'=>$message==null ? 'We could not verify your mobile number is linked to an existing ZICB Account' : $message]], 200);
		}
    }
    
    
    
    
    
    
    public function createWallet(Request $request)
    {
		$input = $request->all();
		//return $req;
		
		//return response()->json(['response' => ['status'=> 1, 'message'=>$input]], 200);
		$rules = ['merchantCode' => 'required', 
			'deviceCode' => 'required', 
			'firstName' => 'required', 
			'lastName' => 'required', 
			'addressLine1' => 'required', 
			'uniqueType' => 'required', 
			'uniqueValue' => 'required', 
			'dateOfBirth' => 'required', 
			'email' => 'required', 
			'sex' => 'required', 
			'mobileNumber' => 'required', 
			'accType' => 'required', 
			'currency' => 'required', 
			'bankCode' => 'required', 
			
		];
		
		$messages = [
		    'merchantCode.required' => 'Invalid merchant code', 
			'deviceCode.required' => 'Invalid device code', 
			'firstName.required' => 'Provide a first name', 
			'lastName.required' => 'Provide a last name', 
			'addressLine1.required' => 'Provide 1st line of address', 
			'uniqueType.required' => 'Specify the means of identification', 
			'uniqueValue.required' => 'Provide your identification number for the means of identification you provided', 
			'dateOfBirth.required' => 'Provide your date of birth', 
			'email.required' => 'Provide your email address', 
			'sex.required' => 'Provide your email address', 
			'mobileNumber.required' => 'Provide your mobile number', 
			'accType.required' => 'Specify the account type', 
			'currency.required' => 'Specify the currency', 
			'bankCode.required' => 'Specify your bank', 
		];
		
			
			
		$messages = ['surchargeAmount.required' => 'Amount to be surcharged must be provided'];
		$validator = \Validator::make($input, $rules, $messages);
		if($validator->fails())
		{
			$errMsg = json_decode($validator->messages(), true);
			$str_error = [];
			$i = 1;
			foreach($errMsg as $key => $value)
			{
				foreach($value as $val) {
					array_push($str_error, ($val));
				}
			}
			return response()->json(['response' => ['status'=> 1, 'message'=>$str_error]], 200);
		}/*
		
        //dd(22);
		$headers = [
			//'authKey' => 'Mgl0DlqjD8nuzXLOjUfWiKctuS9JHUg1b7dDR3pfFRxUupaRJzWwRXLJV1Rv3Q7BiKcLvbU0RrzITQoWUpWYA09Vk9s9ZafDvyecefhuNGZsm3VgbQGbVyUxX0r1Pcydqu6VOVZuofrOzStdQPvRXzhVnKfyPivcUwhI6A5mQdI5FEnvvYm7M8D25sRcuQK3vwKSk0vAeP1VfJxaCZydgW2dHvwk9kwYkTmVeKaypGNTMDF89NVlxi5rLETzu3wpAU1Dp25boxZp0fkt2cqs7AgsFZOZlbvMfSxTVjXmd7gz92fYnUVwIMJ7h0mXEnab93QudyohFwsmnpVKRkBGSRBPeDRBRETvwAFTs8jJYhfmqNB65lXTABq2L5rDaDJjs3qaUiN8hrWWCLpUaca0ytss94e1bIXBJAN3R9gz7eJ3VO6IUSGkuO1qbQMDi1NrNwfTdy0Xdawg8eU0qjhLqr5awCPIQXGhOwIVdIlUCfndpHZGwkLwdz2DO41URBMBcRJ9Q5C7jIfws69H1RjOUrwFYy9ZOCp0uVOIdlwmQ3gujcBi4NbX78tWhvBHd0DX18ieK8v3UWiapRIRwVG7zmCHbD66z7LdXu8MqfzDX1seupwZ45QIbY4DSZIlvAqipg9KPMZxLDfd9Y7IdEavlPaZP6aIgGJlM5X9kXaZRjFEvtL5TuSrNoUMQTcMIZqS7gTaqiDnhZzkcuMf1JGNIPKbOQuTOTFpnDyj11xB9r6QG0pLglQl8gejHi9wwyypQ4bmmI0irIvt5xEwTU3pguFF7cIBojyEVD7ipy3SDvo47eeWJoehCfleWAI30UzgVQNKSNFtyauh0ccADDnWZS6QauwVEOj4kaGRplJgfdtT4Vwo7waWmcJxrsL4pWzPfMMEIqvP71KWXVGLA3r4NkygxT9hysuD15ZtU22V5jr9gokAq10NnlZ3t9YWEMEXFU23FCd9F7cswrsaAoFvlLsbQV7eNwfKr0AogreHgbhnPbTkhBR5zAxGGPxY49dfNCpk4tZa2EBjeTemGInMKxPiJPtIKxH3uswOnPXS6k2mtMZu5qS4t9v0itKaw0LBtBrx7K9yT79tLxICBB9o4mTmtg3jE',
		];
		$client = new \GuzzleHttp\Client(['headers' => $headers]);  
		*/
		//dd($parameters);
		/*$allData = [];
		//$allData['merchantCode'] = $req['merchantCode'];
		//$allData['deviceCode'] = $req['deviceCode'];
		$allData['firstName'] = $req['firstName'];
		$allData['lastName'] = $req['lastName'];
		$allData['addressLine1'] = $req['addressLine1'];
		$allData['addressLine2'] = $req['addressLine2'];
		$allData['uniqueType'] = $req['uniqueType'];
		$allData['uniqueValue'] = $req['uniqueValue'];
		$allData['dateOfBirth'] =  $req['dateOfBirth'];
		$allData['email'] = $req['email'];
		$allData['sex'] = $req['sex'];
		$allData['mobileNumber'] = $req['mobileNumber'];
		$allData['accType'] = $req['accType'];
		$allData['currency'] = $req['currency'];
		$allData['bankCode'] = $req['bankCode'];
		$parameters["request"] = $allData;
		$parameters["service"] = "ZB0631";*/
        		
        //return response()->json(['response' => ['status'=> 1, 'message'=>$parameters]], 200);
		//dd($allData);
		//$input = json_decode($input, TRUE);
		// response()->json(['response' => ['status'=> 1, 'message'=>sizeof($input)]], 200);
		//dd(getServiceBaseURL());
        //$result = handleSOAPCalls('createBankWallet', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/WalletServices?wsdl', $req);
		
    	$req["addressLine1"] = $input["addressLine1"];
    	$req["addressLine2"] = $input["addressLine2"];
    	$req["contactMobile"] = $input["mobileNumber"];
    	$req["contactEmail"] = $input["email"];
    	$req["dateOfBirth"] = $input["dateOfBirth"];
    	$req["firstName"] = $input["firstName"];
    	$req["gender"] = $input["sex"];
    	$req["lastName"] = $input["lastName"];
    	$req["district"] = intVal($input["district"]);
    	$req["currencyCode"] = "ZMW";
    	$req["accountType"] = "VIRTUAL";
    	$req["openingAccountAmount"] = 0.00;
		$req["customerType"] = "INDIVIDUAL";
    	$req["meansOfIdentificationType"] = $input["uniqueType"];
    	$req["meansOfIdentificationNumber"] = $input["uniqueValue"];
		$req["merchantId"] = $input["merchantCode"];
    	$req["deviceCode"] = $input["deviceCode"];
		$req["acquirerId"] = ZICB_ACQUIRER_CODE;
    	$req["accType"] = $input["accType"];
    	//$req["currency"] = $input["currency"];
    	//$req["bankCode"] = $input["bankCode"];
    	//$req["authKey"] = $input["zicbAuthKey"];
		$parameters['request'] = $req;
		$parameters['service'] = "ZB0631";
		//$result = handleSOAPCalls('createBankWallet', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/WalletServices?wsdl', $req);
        //$result = handleSOAPCalls('createNewMerchantCustomerAccount', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CustomerServicesV2?wsdl', $req);


        $dataStr = "";
		foreach($req as $d => $v)
		{
			$dataStr = $dataStr."".$d."=".$v."&";
		}
        //$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/createNewMerchantCustomerAccount';
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/createNewCustomerAccount';
		$result = sendPostRequest($url, $dataStr);
		$result = json_decode($result);



		if($result!=null)
		{
		    //$result = json_decode($result, TRUE);
		    //dd($result);
		    //return response()->json(['response' => [$result]], 200);
		    $status = isset($result->status) ? $result->status : null;
		    if($status!=null && $status==100)
		    {
		        return response()->json(['response' => ['status'=> 1, 'message'=>'Customer wallet creation was successful', 'dataResp'=>$result]], 200);
		    }
		    else
		    {
		        return response()->json(['response' => ['status'=> 0, 'message'=>'Customer wallet creation failed', 'dataResp'=>$result]], 200);
		    }
		}
		//dd($result);
        /*try
        {
            //return response()->json(['response' => ['status'=> 1, 'message'=>$parameters]], 200);
            //return $parameters;
            $response = $client->request('POST', 'http://41.175.14.69:7664/api/json/commercials/probase/zicb/fundsTransfer', 
                [\GuzzleHttp\RequestOptions::JSON => $parameters]
            );
			//dd($response->getBody()->getContents());
    		$response = $response->getBody()->getContents();
			$response = json_decode($response, TRUE);
			dd($response);
    		return response()->json(['response' => ['status'=> 1, 'message'=>$response]], 200);
        }
        catch(\Exception $e)
        {
			dd($e);
            //return response()->json(['response' => ['status'=> 1, 'message'=>$e->getMessage()]], 200);
        }*/

        return response()->json(['response' => ['status' => 0, 'message' => 'Customer wallet creation failed', 'dataResp'=>$result]], 200);
    }
	

    public function getEWalletListing()
    {
        $data = array();
        $data['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('listEWalletAccounts', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/WalletServices?wsdl', $data);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 410)
        {
            $walletAcctList = json_decode($result->walletAcctList);
            return view('core.authenticated.ewallet.ewallet_listing', compact('walletAcctList'));
        }else
        {
            return \Redirect::back()->with('error', 'EWallet Listing failed');
        }

    }


    public function getEWalletAccountListing($walletId)
    {
        $data = array();
        $data['walletIdS'] = $walletId;
        $data['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('getAccountsAttached', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/WalletServices?wsdl', $data);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 410)
        {
            $walletAcctAttachedList = json_decode($result->walletAcctList);
            $wallet = json_decode($result->wallet);
            return view('core.authenticated.ewallet.ewallet_account_attached_listing', compact('walletAcctAttachedList', 'wallet'));
        }else
        {
            return \Redirect::back()->with('error', 'EWallet Listing failed');
        }

    }







}
