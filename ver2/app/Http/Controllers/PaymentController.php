<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use Illuminate\Support\Str;
use Illuminate\Encryption\Encrypter;

class PaymentController extends Controller
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


	public function initializeReversalPayment()
	{
		$input = \Input::all();
		//dd($input['description']);
		$dataForServer['reversalRequestId'] 		= $input['reversalRequestId'];
		$dataForServer['reverseTransactionRef'] 	= $input['reverseTransactionRef'];
		$dataForServer['hash'] 						= $input['hash'];
		$dataForServer['orderId'] 					= $input['orderId'];
		$dataForServer['amount'] 					= number_format($input['amount'], 2, '.', '');
		$dataForServer['description'] 				= $input['description'];
		$dataForServer['merchantCode'] 				= $input['merchantCode'];
		$dataForServer['deviceCode'] 				= $input['deviceCode'];



		$result = handleSOAPCalls('requestReverseTransaction', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/TransactionServices?wsdl', $dataForServer);

		return \Response::json($result);
	}


	public function initializePaymentForWebV1(Request $request)
	{
	    	$all = $request->all();
	    	dd($all);
	    	if($all!=null)
        	{
            		if(isset($all['paymentItem']) && isset($all['amount']) && isset($all['currency']) && isset($all['merchantId']) && isset($all['hash']) && isset($all['deviceCode']) && isset($all['serviceTypeId']) && isset($all['orderId']))
            		{
                		if($all['paymentItem']!=null && $all['amount']!=null && $all['currency']!=null && $all['merchantId']!=null && $all['hash']!=null && $all['deviceCode']!=null && $all['serviceTypeId']!=null && $all['orderId']!=null)
                		{
                    			return view('guests.payment.web.', compact('response'));
                		}
            		}
        	}
	}

    public function initializePaymentForWeb(Request $request)
    {
        

		$url = request()->headers->get('referer');
		$host = parse_url($url, PHP_URL_HOST);
		$returnurl = null;
		//\Session::forget('returnurl');

		if(!\Session::has('returnurl') && $host!="demo.probasepay.com" && $host!="demo.payments.probasepay.com")
		{
		    \Session::put('returnurl', $url);
		    $returnurl = $url;
		}
		else
		{
		    $returnurl = \Session::get('returnurl');
		    //dd($returnurl);
		}
        $input = $request->all();

        if(isset($input['str_error']))
        {
            //dd($input['str_error']);
            \Session::put('error', $input['str_error']);
        }
		//dd(\App\Models\ServiceType::$GENERAL_ECOMMERCE);


        //dd(\App\Models\ServiceType::$SCHOOL_FEES." --- ".$input['serviceTypeId']);
        if(in_array('serviceTypeId', array_keys($input)))
        {

            $serviceType = $input['serviceTypeId'];
            //dd(\App\Models\ServiceType::$GENERAL_ECOMMERCE);
            //dd([\App\Models\ServiceType::$GENERAL_ECOMMERCE, \App\Models\ServiceType::$SCHOOL_FEES, $serviceType]);
            //dd(\App\Models\ServiceType::$GENERAL_ECOMMERCE." - ".$serviceType);
            //dd(\App\Models\ServiceType::$GENERAL_ECOMMERCE);
            switch($serviceType)
            {
                case \App\Models\ServiceType::$GENERAL_ECOMMERCE :
                    //dd($input);

                    return $this->handleForGeneralEcommerce($input);
                    break;
                case \App\Models\ServiceType::$SCHOOL_FEES :
                    //dd(12);
                    return $this->handleForTutionFees($input);
                    break;
                case \App\Models\ServiceType::$ACCESS_WALLET :
                    //dd(12);
                    return $this->handleForAccessWallet($input);
                    break;
                case \App\Models\ServiceType::$TOKENIZE :
                    //dd(12);
                    return $this->handleForTokenize($input);
                    break;
            }
        }else{

            //No ServiceType In Form submitted
            //dd(333);
            if(isset($input['data']))
            {
                $data = (\Crypt::decrypt($input['data']));
                $input = $input + $data;
            }
            //dd($input);
            $response["statusmessage"] = "Service Type Not Found";
            $response["reason"] = "Service Type Not Found. ";
            $response["merchantId"] = isset($input['merchantId']) ? $input['merchantId'] : '';
            $response["deviceCode"] = isset($input['deviceCode']) ? $input['deviceCode'] : '';
            $response["status"] = '04';
            $response["transactionRef"] = isset($input['txnRef']) ? $input['txnRef'] : $input['orderId'];
            $response["txn_ref"] = isset($input['txnRef']) ? $input['txnRef'] : $input['orderId'];
            $response["txnRef"] = isset($input['txnRef']) ? $input['txnRef'] : $input['orderId'];
            $response["transactionDate"] = date('Y-m-d H:i:s');
            $response["orderId"] = $input['orderId'];
            $response["redirectUrl"] = isset($input['returnUrl']) ? $input['returnUrl'] : $returnurl;
            return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
        }

    }


    public function postMapAccountToWallet(Request $request)
    {
        $input = $request->all();
        //dd($input);
        $dataForServer['merchantCode'] = $input['merchantCode'];
        $dataForServer['accountNumber'] = $input['accountNumber'];
        $dataForServer['deviceCode'] = $input['deviceCode'];
        $dataForServer['firstName'] = $input['firstName'];
        $dataForServer['lastName'] = $input['lastName'];
        $dataForServer['addressLine1'] = $input['addressLine1'];
        $dataForServer['addressLine2'] = $input['addressLine2'];
        $dataForServer['addressLine3'] = $input['addressLine3'];
        $dataForServer['addressLine4'] = $input['addressLine4'];
        $dataForServer['addressLine5'] = $input['addressLine5'];
        $dataForServer['uniqueType'] = "NRC";
        $dataForServer['uniqueValue'] = $input['uniqueValue'];
        $dataForServer['dateOfBirth'] = $input['dateOfBirth'];
        $dataForServer['email'] = $input['email'];
        $dataForServer['sex'] = $input['sex'];
        $dataForServer['mobileNumber'] = $input['mobileNumber'];
        $dataForServer['accType'] = "WA";
        $dataForServer['currency'] = $input['currency'];
        $dataForServer['idFront'] = $input['idFront'];
        $dataForServer['idBack'] = $input['idBack'];
        $dataForServer['custImg'] = $input['custImg'];
        $dataForServer['custSig'] = $input['custSig'];
        $dataForServer['bankCode'] = $input['bankCode'];
        dd($result);
        $result = handleSOAPCalls('mapExistingBankWallet', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/WalletServices?wsdl', $dataForServer);

    }

    public function loadPaymentOptionsDetailsView($key, $input)
	{
        $billIdEnc = $input;
		$input = \Crypt::decrypt($input);
		//dd($input);
		$billdata = \App\Models\BillData::where('id', '=', $input)->first();
		//dd([$billdata, $input]);
		$input = json_decode($billdata->data, TRUE);

		//dd($input);
		\Session::remove('error');
		\Session::remove('message');
		if(isset($input['sessionContainer']))
		{
		    if(isset($input['sessionContainer']['error']))
		        \Session::put('error', $input['sessionContainer']['error']);
		    elseif(isset($input['sessionContainer']['message']))
		        \Session::put('message', $input['sessionContainer']['message']);

		    unset($input['sessionContainer']);
		    $billdata->data = json_encode($input);
		    $billdata->save();
		}
		$paymentItems = is_string($input['paymentItem']) ? json_decode($input['paymentItem'], TRUE) : $input['paymentItem'];
        $itemAmounts = is_string($input['amount']) ? json_decode($input['amount'], TRUE) : $input['amount'];
        $currency = $input['currency'];
        //dd($currency);

        $bank_count = isset($input['bank_count']) ? $input['bank_count'] : null;
		$bank_options = [];
		for($x1=1; $x1<($bank_count+1); $x1++)
		{
		    $index1 = 'bank_code_'.$x1;
		    $bank_code = $input[$index1];
		    array_push($bank_options, $bank_code);
		}

        $amt = 0;

        if(sizeof($paymentItems)>0 && sizeof($paymentItems)==sizeof($itemAmounts)) {
            for ($i = 0; $i < sizeof($itemAmounts); $i++) {
                $amt = $amt + $itemAmounts[$i];
            }

            //dd(11);
            $dataForServer['merchantCode'] = $input['merchantId'];
            $dataForServer['hash'] = $input['hash'];
            $dataForServer['deviceCode'] = $input['deviceCode'];
            $dataForServer['serviceTypeId'] = $input['serviceTypeId'];
            $dataForServer['orderId'] = $input['orderId'];
            $dataForServer['amount'] = number_format($amt, 2, '.', '');
            //$dataForServer['responseUrl'] = $input['responseurl'];
			$orderId = $input['orderId'];

            //$result = handleSOAPCalls('pullPaymentDefaultData', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/UtilityServices?wsdl', $dataForServer);

            //$result = handleSOAPCalls('listMerchants', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', $data);
//dd($dataForServer);
            $dataStr = "";
            foreach($dataForServer as $k => $v)
            {
                $dataStr = $dataStr."".$k."=".urlencode($v)."&";
            }
            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/pullPaymentDefaultData';


            $authDataStr = sendGetRequest($url, $dataStr);
			//dd([$input, $authDataStr]);
            $result = json_decode($authDataStr);
            //dd($result);



            if(isset($result->status) && $result->status == 1000)
            {
                $all_banks = ($result->all_banks);
                $all_provinces = ($result->all_provinces);
                $all_countries = ($result->all_countries);
                $fixedChargePerTransaction = floatval($result->fixedChargePerTransaction);
                $percentagePerTransaction = floatval($result->percentagePerTransaction);
                $payment_options = $result->payment_options;

				//dd($input);
				$select_options = false;
				$payment_options = [];
				if(isset($result->payment_options))
				{
				    $select_options = true;
				    $payment_options = $result->payment_options;
				}
                //dd($payment_options);

                //dd($walletBalanceList);
                //dd($input);
                $newInput = $input;
                //dd($newInput);
                //$input = \Crypt::encrypt($input);
                $input = $billIdEnc;

				$key = PAYMENT_DETAILS_LISTING;

				return view('guests.payment.web.payment_options_details_view', compact('select_options', 'newInput', 'payment_options', 'bank_options', 'key', 'input', 'orderId', 'amt',
                    'paymentItems', 'itemAmounts', 'all_banks', 'all_provinces', 'fixedChargePerTransaction',
                    'percentagePerTransaction','all_countries', 'currency', 'payment_options'));
            }
            else
            {
                $response["statusmessage"] = isset($result->message) ? $result->message : "System Error";
                $response["reason"] = isset($result->message) ? $result->message : "System Error";
                $response["merchantId"] = $input['merchantId'];
                $response["deviceCode"] = $input['deviceCode'];
                $response["status"] = isset($result->status) ? $result->status : '99';
                $response["transactionDate"] = date('Y-m-d H:i:s');
                $response["orderId"] = $input['orderId'];
                //$response["redirectUrl"] = $input['responseurl'];
                //dd($response);
                return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
            }
        }
        else{
            //dd(22);
            $response["statusmessage"] = "Invalid Dataset";
            $response["reason"] = "Invalid Dataset Provided. Parameters Provided are Incomplete";
            $response["merchantId"] = $input['merchantId'];
            $response["deviceCode"] = $input['deviceCode'];
            $response["status"] = '12';
            $response["transactionDate"] = date('Y-m-d H:i:s');
            $response["orderId"] = $input['orderId'];
            $response["redirectUrl"] = $input['responseurl'];
            //dd($response);
            return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
        }
	}








    public function loadWalletLoginView($key, $input)
	{
        	//dd($input);
		$bank_options = [];
		 $billIdEnc = $input;
		$input = \Crypt::decrypt($input);
		//dd($input);
		$billdata = \App\Models\BillData::where('id', '=', $input)->first();
		//dd([$billdata, $input]);
		$input = json_decode($billdata->data, TRUE);

		\Session::remove('error');
		\Session::remove('message');
		if(isset($input['sessionContainer']))
		{
		    if(isset($input['sessionContainer']['error']))
		        \Session::put('error', $input['sessionContainer']['error']);
		    elseif(isset($input['sessionContainer']['message']))
		        \Session::put('message', $input['sessionContainer']['message']);

		    unset($input['sessionContainer']);
		    $billdata->data = json_encode($input);
		    $billdata->save();
		}
		
		$dataStr = "";
		$amt = 0;
		$orderId = null;
		$dataForServer['merchantCode'] = $input['merchantId'];
            $dataForServer['hash'] = $input['hash'];
            $dataForServer['deviceCode'] = $input['deviceCode'];
            $dataForServer['serviceTypeId'] = $input['serviceTypeId'];

		
            		$dataForServer['orderId'] = $input['orderId'];
            		$dataForServer['amount'] = number_format($amt, 2, '.', '');
			$orderId = $input['orderId'];

            		$dataStr = "";
            		foreach($dataForServer as $k => $v)
            		{
               		$dataStr = $dataStr."".$k."=".urlencode($v)."&";
            		}
		


            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/pullPaymentDefaultData';


            $authDataStr = sendGetRequest($url, $dataStr);
		$result = json_decode($authDataStr);




            if(isset($result->status) && $result->status == 1000)
            {
                $all_banks = ($result->all_banks);
                $all_provinces = ($result->all_provinces);
                $all_countries = ($result->all_countries);
                $fixedChargePerTransaction = floatval($result->fixedChargePerTransaction);
                $percentagePerTransaction = floatval($result->percentagePerTransaction);
                $payment_options = $result->payment_options;

				//dd($input);
				$select_options = false;
				$payment_options = [];
				if(isset($result->payment_options))
				{
				    $select_options = true;
				    $payment_options = $result->payment_options;
				}
                //dd($payment_options);

                //dd($walletBalanceList);
                //dd($input);
                $newInput = $input;
                //dd($newInput);
                //$input = \Crypt::encrypt($input);
                $input = $billIdEnc;
				$walletBalanceList = [];

				

				


					if($key==TOKENIZE)
					{

					}
					else
					{
						$key = WALLET_ACCESS;
					}
					$paymentItems = isset($input['paymentItem']) && is_string($input['paymentItem']) ? json_decode($input['paymentItem'], TRUE) : (isset($input['paymentItem']) ? $input['paymentItem'] : []);
        				$itemAmounts = isset($input['amount']) && is_string($input['amount']) ? json_decode($input['amount'], TRUE) : (isset($input['amount']) ? $input['amount'] : []);
       				$currency = isset($input['currency']) ? $input['currency'] : "ZMW";
					return view('guests.payment.web.payment_details_view', compact('select_options', 'newInput', 'payment_options', 'bank_options', 'key', 'input', 'orderId', 'amt',
                    				'paymentItems', 'itemAmounts', 'all_banks', 'all_provinces', 'fixedChargePerTransaction',
                    				'percentagePerTransaction','all_countries', 'currency', 'walletBalanceList'));
				
				

            }
            else
            {
                $response["statusmessage"] = isset($result->message) ? $result->message : "System Error";
                $response["reason"] = isset($result->message) ? $result->message : "System Error";
                $response["merchantId"] = $input['merchantId'];
                $response["deviceCode"] = $input['deviceCode'];
                $response["status"] = isset($result->status) ? $result->status : '99';
                $response["transactionDate"] = date('Y-m-d H:i:s');
                $response["orderId"] = $input['orderId'];
                //$response["redirectUrl"] = $input['responseurl'];
                //dd($response);
                return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
            }
        
	}


    public function loadPaymentDetailsView($key, $input)
	{

        $billIdEnc = $input;
		$input = \Crypt::decrypt($input);
		//dd($input);
		$billdata = \App\Models\BillData::where('id', '=', $input)->first();
		//dd([$billdata, $input]);
		$input = json_decode($billdata->data, TRUE);

		//dd($input);
		\Session::remove('error');
		\Session::remove('message');
		if(isset($input['sessionContainer']))
		{
		    if(isset($input['sessionContainer']['error']))
		        \Session::put('error', $input['sessionContainer']['error']);
		    elseif(isset($input['sessionContainer']['message']))
		        \Session::put('message', $input['sessionContainer']['message']);

		    unset($input['sessionContainer']);
		    $billdata->data = json_encode($input);
		    $billdata->save();
		}
		$paymentItems = is_string($input['paymentItem']) ? json_decode($input['paymentItem'], TRUE) : $input['paymentItem'];
        $itemAmounts = is_string($input['amount']) ? json_decode($input['amount'], TRUE) : $input['amount'];
        $currency = $input['currency'];
        //dd($currency);

        $bank_count = isset($input['bank_count']) ? $input['bank_count'] : null;
		$bank_options = [];
		for($x1=1; $x1<($bank_count+1); $x1++)
		{
		    $index1 = 'bank_code_'.$x1;
		    $bank_code = $input[$index1];
		    array_push($bank_options, $bank_code);
		}

        $amt = 0;

        if(sizeof($paymentItems)>0 && sizeof($paymentItems)==sizeof($itemAmounts)) {
            for ($i = 0; $i < sizeof($itemAmounts); $i++) {
                $amt = $amt + $itemAmounts[$i];
            }

            //dd(11);
            $dataForServer['merchantCode'] = $input['merchantId'];
            $dataForServer['hash'] = $input['hash'];
            $dataForServer['deviceCode'] = $input['deviceCode'];
            $dataForServer['serviceTypeId'] = $input['serviceTypeId'];
            $dataForServer['orderId'] = $input['orderId'];
            $dataForServer['amount'] = number_format($amt, 2, '.', '');
            //$dataForServer['responseUrl'] = $input['responseurl'];
			$orderId = $input['orderId'];

            //$result = handleSOAPCalls('pullPaymentDefaultData', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/UtilityServices?wsdl', $dataForServer);

            //$result = handleSOAPCalls('listMerchants', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', $data);
//dd($dataForServer);
            $dataStr = "";
            foreach($dataForServer as $k => $v)
            {
                $dataStr = $dataStr."".$k."=".urlencode($v)."&";
            }
            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/pullPaymentDefaultData';


            $authDataStr = sendGetRequest($url, $dataStr);
			//dd([$url, $input, $authDataStr]);
            $result = json_decode($authDataStr);
            //dd($result);



            if(isset($result->status) && $result->status == 1000)
            {
                $all_banks = ($result->all_banks);
                $all_provinces = ($result->all_provinces);
                $all_countries = ($result->all_countries);
                $fixedChargePerTransaction = floatval($result->fixedChargePerTransaction);
                $percentagePerTransaction = floatval($result->percentagePerTransaction);
                $walletBalanceList = [];

				//dd($input);
				$select_options = false;
				$payment_options = [];
				if(isset($input['payment_options']))
				{
				    $select_options = true;
				    $payment_options = explode('|', $input['payment_options']);
				}

				if(isset($input['probasepay_wallet_customer_verification_no']))
				{
					$probasepay_wallet_customer_verification_no = $input['probasepay_wallet_customer_verification_no'];
					$merchantId = $input['merchantId'];
					$deviceCode = $input['deviceCode'];
					$serviceTypeId = $input['serviceTypeId'];
					$customerNumber = $probasepay_wallet_customer_verification_no;
					$hashForWallet = isset($input['hashForWallet']) ? $input['hashForWallet'] : "";
					//dd($input);
					//$zicbAuthKey = isset($input['zicbAuthKey']) ? $input['zicbAuthKey'] : "";

					$req["merchantCode"] = $merchantId;
					$req["deviceCode"] = $deviceCode;
					$req["serviceTypeId"] = $serviceTypeId;
					$req["customerNumber"] = $probasepay_wallet_customer_verification_no;
					$req["hash"] = $hashForWallet;
					//$req["zicbAuthKey"] = $zicbAuthKey;




					$result = handleSOAPCalls('getAllEWalletAccountBalanceByCustomer', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/WalletServices?wsdl', $req);
//dd([$req, $result, $input['hashForWalletStr']]);
                    //dd($result);
					if(isset($result->status) && $result->status == 2003)
					{

						$walletBalanceList = $result->balanceList;
						$walletBalanceList = json_decode($walletBalanceList, TRUE);

					}
				}

                //dd($walletBalanceList);
                //dd($input);
                $newInput = $input;
                //dd($newInput);
                //$input = \Crypt::encrypt($input);
                $input = $billIdEnc;

				$key = PAYMENT_DETAILS_LISTING;

				return view('guests.payment.web.payment_details_view', compact('select_options', 'newInput', 'payment_options', 'bank_options', 'key', 'input', 'orderId', 'amt',
                    'paymentItems', 'itemAmounts', 'all_banks', 'all_provinces', 'fixedChargePerTransaction',
                    'percentagePerTransaction','all_countries', 'currency', 'walletBalanceList'));
            }
            else
            {
				//dd(33);
                $response["statusmessage"] = isset($result->message) ? $result->message : "System Error";
                $response["reason"] = isset($result->message) ? $result->message : "System Error";
                $response["merchantId"] = $input['merchantId'];
                $response["deviceCode"] = $input['deviceCode'];
                $response["status"] = isset($result->status) ? $result->status : '99';
                $response["transactionDate"] = date('Y-m-d H:i:s');
                $response["orderId"] = $input['orderId'];
                //$response["redirectUrl"] = $input['responseurl'];
                //dd($response);
                return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
            }
        }
        else{
            //dd(22);
            $response["statusmessage"] = "Invalid Dataset";
            $response["reason"] = "Invalid Dataset Provided. Parameters Provided are Incomplete";
            $response["merchantId"] = $input['merchantId'];
            $response["deviceCode"] = $input['deviceCode'];
            $response["status"] = '12';
            $response["transactionDate"] = date('Y-m-d H:i:s');
            $response["orderId"] = $input['orderId'];
            $response["redirectUrl"] = $input['responseurl'];
            //dd($response);
            return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
        }
	}




    public function loadPaymentOnlineBankingDetailsView($key, $input)
    {
        //dd($input);
        $billIdEnc = $input;
        $data = \Crypt::decrypt($input);
        $billdata = \App\Models\BillData::where('id', '=', $data)->first();
        $data = $billdata->data;
        $data = json_decode($data, TRUE);
        //dd([$all, $data]);
        $orderId = $data['orderId'];
        $currency = $data['currency'];
        $total = doubleVal($data['total_amount']);

        $dataForServer['merchantCode'] = $data['merchantId'];
        $dataForServer['hash'] = $data['hash'];
        $dataForServer['deviceCode'] = $data['deviceCode'];
        $dataForServer['serviceTypeId'] = $data['serviceTypeId'];
        $dataForServer['orderId'] = $data['orderId'];
        $dataForServer['amount'] = number_format($amt, 2, '.', '');
        //$dataForServer['responseUrl'] = $data['responseurl'];
		$orderId = $data['orderId'];

        $dataStr = "";
        foreach($dataForServer as $k => $v)
        {
            $dataStr = $dataStr."".$k."=".urlencode($v)."&";
        }
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/pullPaymentDefaultData';


        $authDataStr = sendGetRequest($url, $dataStr);
		//dd([$input, $authDataStr]);
        $result = json_decode($authDataStr);
        //dd($result);



        if(isset($result->status) && $result->status == 1000)
        {
            $all_banks = ($result->all_banks);
            $all_provinces = ($result->all_provinces);
            $all_countries = ($result->all_countries);
            $fixedChargePerTransaction = floatval($result->fixedChargePerTransaction);
            $percentagePerTransaction = floatval($result->percentagePerTransaction);

            $result1 = json_decode($authDataStr, TRUE);

            /*$dataToSend = [];
            $dataToSend['paymentReference'] = $input['orderId'];
            $dataToSend['expiryDate'] = date('m/d/Y');
            $dataToSend['amount'] = $total;
            $dataToSend['paymentDescription'] = "Payment Ref - ".$input['orderId']." ".$data['currency'].$total;
            $dataToSend['systemId'] = "MRID";
            $dataToSend['redirectUrl'] = "https://demo.payments.probasepay.com/payments/confirm-payment";


            $params = $dataToSend;
            $keysIndex = [];

            $cyber_url = $result1['online_banking_url'];
			return view('guests.payment.cybersource.forward', compact('params', 'cyber_url', 'all_banks'));*/
            $key = PAYMENT_DETAILS_ONLINE_BANKING_SELECT_VIEW;
            return view('guests.payment.online_banking.bank_select_for_payment', compact('billIdEnc',  'key', 'input', 'orderId', 'amt',
                'billdata', 'fixedChargePerTransaction', 'all_countries',
                'percentagePerTransaction','currency'));
        }
    }



	public function postHandlePaymentOnlineBankingInitiation($key, $input)
    {
        $all = $request->all();
        $input = $all;
        //dd($all);
        $data = \Crypt::decrypt($all['data']);
        $billdata = \App\Models\BillData::where('id', '=', $data)->first();
        $data = $billdata->data;
        $data = json_decode($data, TRUE);
        //dd([$all, $data]);
        $total = doubleVal($data['total_amount']);
        $jsonData = array(
            'amount' => (number_format($total, 2, '.', '')),
            'responseUrl' => $data['responseurl'],
            'orderId' => $input['orderId'],
            'hash' => $data['hash'],
            'merchantId' => $data['merchantId'],
            'deviceCode' => $data['deviceCode'],
            'serviceTypeId' => $data['serviceTypeId'],
            'firstName' => $input['firstName'],
            'lastName' => $input['lastName'],
            'countryCode' => $data['country_code'],
            'billPayeeMobile' => $input['payeeMobile'],
            'email' => $input['payeeEmail'],
            'streetAddress' => $input['streetAddress'],
            'city' => $input['city'],
            'country' => explode('###', $input['country'])[2],
            'district' => isset($input['district']) && sizeof(explode('_', $input['district']))>1 ? explode('_', $input['district'])[1] : "");
        if(isset($data['customdata']))
        {
            $jsonData['customdata'] = serialize($data['customdata']);
        }
        if(isset($data['currency']))
        {
            $jsonData['currency'] = $data['currency'];
        }

        $defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
        //dd($defaultAcquirer->toArray());
        if($defaultAcquirer==null)
        {
            return response()->json(['message' => 'Error encountered. ERR00AQ1', 'success'=>false], 200);
        }

        $defaultAcquirer = $defaultAcquirer->toArray();

        //dd($input);
        //dd($jsonData);
        $jsonData = \Crypt::encrypt(json_encode($jsonData));

        $jsonDataLump = array('txnDetail' => $jsonData);
        $jsonEncode = json_encode($jsonDataLump);
        //dd($jsonEncode);
        $base64 = base64_encode($jsonEncode);
        $dataForServer = array('transactionObject' => $base64,
            'acquirerCode' => $defaultAcquirer['acquirerCode']
            //, 'zicbAuthKey'=>$input['zicbAuthKey']
            //'merchantId' => $input['merchantId'],
            //'deviceCode' => $input['deviceCode']
        );

        $dataStr = "";
        foreach($dataForServer as $k => $v)
        {
            $dataStr = $dataStr."".$k."=".urlencode($v)."&";
        }



        //$result = handleSOAPCalls('initiateCyberSourcePayment', '', $dataForServer);
        $url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/PaymentServicesV2/initiateBankOnlinePaymentV2';
        $authDataStr = sendPostRequest($url, $dataStr);
        //dd([$input, $authDataStr]);
        $result = json_decode($authDataStr);
        //dd(\Crypt::decrypt($input['data']));
        //dd();
        //dd([$input, $data, $dataForServer, $result]);

        if (isset($result->status) && $result->status == 1002) {

            $result1 = json_decode($authDataStr, TRUE);

            $dataToSend = [];
            $dataToSend['paymentReference'] = $input['orderId'];
            $dataToSend['expiryDate'] = date('m/d/Y');
            $dataToSend['amount'] = $total;
            $dataToSend['paymentDescription'] = "Payment Ref - ".$input['orderId']." ".$data['currency'].$total;
            $dataToSend['systemId'] = "MRID";
            $dataToSend['redirectUrl'] = "https://demo.payments.probasepay.com/payments/confirm-payment";


            $params = $dataToSend;
            $keysIndex = [];

            $cyber_url = $result1['online_banking_url'];
			return view('guests.payment.cybersource.forward', compact('params', 'cyber_url'));
            return view('guests.payment.cybersource.capture_payee_details', compact('billIdEnc',  'key', 'input', 'orderId', 'amt',
                'billdata', 'fixedChargePerTransaction', 'all_countries',
                'percentagePerTransaction','currency'));
        }
    }




	public function loadCardCollectionView($key, $data)
	{
		$input = \Crypt::decrypt($data);
		//dd($input);
		if(is_array($input))
		{
		    $input = $input['temp_holder_id'];
		}
	//	dd($input);
		//dd($input);
        /*$paymentItems = $input['paymentItem'];
        $itemAmounts = $input['amount'];
        $payerName = $input['payerName'];*/
        //dd($input);
		$tempHolder = \App\Models\TempHolder::where('id', '=', $input)->first();
		$data = $tempHolder->temp_holder;
		$input = \Crypt::decrypt($data);
		//dd($input);
		$totalAmount = 0;
		for($x=0; $x<sizeof($input['amount']); $x++)
		{
		    $totalAmount = $totalAmount + $input['amount'][$x];
		}
		//($input);



        return view('guests.payment.web.card-collection-view', compact('totalAmount', 'data', 'itemAmounts', 'paymentItems', 'payerName', 'input', 'tempHolder'));


	}

	public function loadOtpCollectionView($key, $data, $txnRef, $token=NULL)
	{
	    $inputId = $data;
		$input1 = \Crypt::decrypt($data);
		$input1 = \App\Models\BillData::where('id', '=', $input1)->first();
		$input = $input1->data;
		$username = $input1->username;
		$input = json_decode($input, TRUE);
		//dd($input);
		//$tempHolder = \App\Models\TempHolder::where('id', '=', $input)->first();
		//dd($tempHolder);
		//$data = $tempHolder->temp_holder;
		//$input = \Crypt::decrypt($data);
		//dd($input);
		$input['txnRef'] = $txnRef;
		$token = $input1->token_data;
		$data = \Crypt::encrypt($input);
        /*$paymentItems = $input['paymentItem'];
        $itemAmounts = $input['amount'];
        $payerName = $input['payerName'];*/
        $totalAmount = $input['total_amount'];
        $orderId = $input['orderId'];
        $currency = $input['currency'];
        $input = $inputId;
        return view('guests.payment.web.otp-collection-view', compact('key', 'totalAmount', 'input', 'data', 'currency', 'token', 'orderId', 'username'));
	}



	public function loadOtpCollectionAndWalletCreateView($key, $customerVerificationNo, $data, $token)
	{
	    $inputId = $data;
		$input1 = \Crypt::decrypt($data);
		$input1 = \App\Models\BillData::where('id', '=', $input1)->first();
		$input = $input1->data;
		$username = $input1->username;
		$input = json_decode($input, TRUE);
		$deviceCode = $input['deviceCode'];
		//dd($input);
		//$tempHolder = \App\Models\TempHolder::where('id', '=', $input)->first();
		//dd($tempHolder);
		//$data = $tempHolder->temp_holder;
		//$input = \Crypt::decrypt($data);
		//dd($input);
		$token = $input1->token_data;
		$data = \Crypt::encrypt($input);
              $input = $inputId;
        return view('guests.payment.web.otp-collection-and-wallet-create-view', compact('deviceCode', 'key', 'customerVerificationNo', 'input', 'data', 'token', 'username'));
	}

	public function loadWalletOtpCollectionView($key, $data, $txnRef, $token)
	{
		$input = \Crypt::decrypt($data);
		$input = \App\Models\BillData::where('id', '=', $input)->first();
		$input = $input->data;
		$input = \Crypt::decrypt($input);
		//($input);
		//$tempHolder = \App\Models\TempHolder::where('id', '=', $input)->first();
		//dd($tempHolder);
		//$data = $tempHolder->temp_holder;
		//$input = \Crypt::decrypt($data);
		//dd($input);
		$input['txnRef'] = $txnRef;
		$input['token'] = $token;
		$data = \Crypt::encrypt($input);
        /*$paymentItems = $input['paymentItem'];
        $itemAmounts = $input['amount'];
        $payerName = $input['payerName'];*/
        //dd($input);
        $totalAmount = $input['total'];
        return view('guests.payment.web.wallet-otp-collection-view', compact('key', 'totalAmount', 'input', 'data', 'paymentItems', 'itemAmounts', 'payerName'));
	}


	public function loadPaymentErrorView($key, $transactionRef, $data=null)
	{
		$input = \Crypt::decrypt($data);
		//dd($input);
		//$tempHolder = \App\Models\TempHolder::where('id', '=', $input)->first();
		//dd($tempHolder);
		//$data = $tempHolder->temp_holder;
		//$input = \Crypt::decrypt($data);
		//dd($input);
		$input['txnRef'] = $transactionRef;
		$data = \Crypt::encrypt($input);
        /*$paymentItems = $input['paymentItem'];
        $itemAmounts = $input['amount'];
        $payerName = $input['payerName'];*/
        //dd($input);
        $totalAmount = $input['total'];
        return view('guests.payment.web.payment-error-view', compact('input', 'data'));
	}




    private function handleForTutionFees($input)
    {

        //dd($input);
		$sessionContainer = [];
		if(\Session::has('error') || \Session::has('message'))
		{
			$sessionError = \Session::get('error');
			$sessionMessage = \Session::get('message');
			$sessionContainer['error'] = $sessionError;
			$sessionContainer['message'] = $sessionMessage;
		}
        /*$paymentItems = $input['paymentItem'];
        $itemAmounts = $input['amount'];
        $currency = $input['currency'];
        $amt = 0;
        if(sizeof($paymentItems)>0 && sizeof($paymentItems)==sizeof($itemAmounts)) {
            for ($i = 0; $i < sizeof($itemAmounts); $i++) {
                $amt = $amt + $itemAmounts[$i];
            }

            $dataForServer['merchantCode'] = $input['merchantId'];
            $dataForServer['hash'] = $input['hash'];
            $dataForServer['deviceCode'] = $input['deviceCode'];
            $dataForServer['serviceTypeId'] = $input['serviceTypeId'];
            $dataForServer['orderId'] = $input['orderId'];
            $dataForServer['amount'] = number_format($amt, 2, '.', '');
            $dataForServer['responseUrl'] = $input['responseurl'];
			$orderId = $input['orderId'];

            $result = handleSOAPCalls('pullPaymentDefaultData', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/UtilityServices?wsdl', $dataForServer);

			//dd($result);


            if(isset($result->status) && $result->status == 1000)
            {
                $all_banks = json_decode($result->all_banks);
                $all_provinces = json_decode($result->all_provinces);
                $all_countries = json_decode($result->all_countries);
                $fixedChargePerTransaction = floatval($result->fixedChargePerTransaction);
                $percentagePerTransaction = floatval($result->percentagePerTransaction);

                $input = \Crypt::encrypt($input);


                return view('guests.payment.web.index', compact('input', 'orderId', 'paymentTitle', 'amt',
                    'paymentItems', 'itemAmounts', 'all_banks', 'all_provinces', 'fixedChargePerTransaction',
                    'percentagePerTransaction','all_countries', 'currency'));*/
                $billData = new \App\Models\BillData();
                $billData->data = json_encode($input);
                //dd($billData);
                $billData->save();

                $input = $billData->id;
                $input = \Crypt::encrypt($input);
                \Session::put('billDataId', $billData->id);


                //dd($input);
				$key = PAYMENT_DETAILS_LISTING;
				//BillData

				return view('secure.dashboard', compact('sessionContainer', 'key', 'input'));
            /*}
            else
            {
                $response["statusmessage"] = isset($result->message) ? $result->message : "System Error";
                $response["reason"] = isset($result->message) ? $result->message : "System Error";
                $response["merchantId"] = $input['merchantId'];
                $response["deviceCode"] = $input['deviceCode'];
                $response["status"] = isset($result->status) ? $result->status : '99';
                $response["transactionDate"] = date('Y-m-d H:i:s');
                $response["orderId"] = $input['orderId'];
                $response["redirectUrl"] = $input['responseurl'];
                return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
            }

        }
        else{
            $response["statusmessage"] = "Invalid Dataset";
            $response["reason"] = "Invalid Dataset Provided. Parameters Provided are Incomplete";
            $response["merchantId"] = $input['merchantId'];
            $response["deviceCode"] = $input['deviceCode'];
            $response["status"] = '12';
            $response["transactionDate"] = date('Y-m-d H:i:s');
            $response["orderId"] = $input['orderId'];
            $response["redirectUrl"] = $input['responseurl'];
            return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
        }*/
    }





	private function handleForAccessWallet($input)
	{
        //dd($input);
		$sessionContainer = [];
		if(\Session::has('error') || \Session::has('message'))
		{
			$sessionError = \Session::get('error');
			$sessionMessage = \Session::get('message');
			$sessionContainer['error'] = $sessionError;
			$sessionContainer['message'] = $sessionMessage;
		}


		$billData = new \App\Models\BillData();
        	$billData->data = json_encode($input);
        	//dd($billData);
        	$billData->save();
        	$input = $billData->id;
        	$input = \Crypt::encrypt($input);
        	\Session::put('billDataId', $billData->id);


        	//dd($billData->data);
        	//$key = PAYMENT_DETAILS_LISTING;
        	$key = WALLET_ACCESS;
		return view('secure.dashboard', compact('key', 'input'));
        }


	private function handleForTokenize($input)
	{
        //dd($input);
		$sessionContainer = [];
		if(\Session::has('error') || \Session::has('message'))
		{
			$sessionError = \Session::get('error');
			$sessionMessage = \Session::get('message');
			$sessionContainer['error'] = $sessionError;
			$sessionContainer['message'] = $sessionMessage;
		}


		$billData = new \App\Models\BillData();
        	$billData->data = json_encode($input);
        	//dd($billData);
        	$billData->save();
        	$input = $billData->id;
        	$input = \Crypt::encrypt($input);
        	\Session::put('billDataId', $billData->id);


        	//dd($billData->data);
        	//$key = PAYMENT_DETAILS_LISTING;
        	$key = TOKENIZE;
		return view('secure.dashboard', compact('key', 'input'));
	}

    private function handleForGeneralEcommerce($input)
    {
        $sessionContainer = [];
        if(\Session::has('error') || \Session::has('message'))
        {
            $sessionError = \Session::get('error');
            $sessionMessage = \Session::get('message');
            $sessionContainer['error'] = $sessionError;
            $sessionContainer['message'] = $sessionMessage;
        }
        /*if(sizeof($input)>0)
        {

            $paymentItems = $input['paymentItem'];
            $itemAmounts = $input['amount'];
            $currency = $input['currency'];
            $amt = 0;
            if (sizeof($paymentItems) > 0 && sizeof($paymentItems) == sizeof($itemAmounts)) {
                for ($i = 0; $i < sizeof($itemAmounts); $i++) {
                    $amt = $amt + $itemAmounts[$i];
                }

                $dataForServer['merchantCode'] = $input['merchantId'];
                $dataForServer['hash'] = $input['hash'];
                $dataForServer['deviceCode'] = $input['deviceCode'];
                $dataForServer['serviceTypeId'] = $input['serviceTypeId'];
                $dataForServer['orderId'] = $input['orderId'];
                $dataForServer['amount'] = number_format($amt, 2, '.', '');
                $dataForServer['responseUrl'] = $input['responseurl'];
                $input = \Crypt::encrypt($input);

                $result = handleSOAPCalls('pullPaymentDefaultData', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/UtilityServices?wsdl', $dataForServer);


                if (isset($result->status) && $result->status == 1000) {
                    $all_provinces = json_decode($result->all_provinces);
                    $all_countries = json_decode($result->all_countries);
                    $all_banks = json_decode($result->all_banks);


                    $fixedChargePerTransaction = floatval($result->fixedChargePerTransaction);
                    $percentagePerTransaction = floatval($result->percentagePerTransaction);
                    return view('guests.payment.web.index', compact('input', 'paymentTitle', 'amt',
                        'paymentItems', 'itemAmounts', 'all_provinces', 'fixedChargePerTransaction',
                        'percentagePerTransaction', 'all_countries', 'all_banks', 'currency'));
                } else {
                    $returnResponse["statusmessage"] = isset($result->message) ? $result->message : "System Error";
                    $returnResponse["reason"] = isset($result->message) ? $result->message : "System Error";
                    $returnResponse["merchantId"] = $input['merchantId'];
                    $returnResponse["deviceCode"] = $input['deviceCode'];
                    $returnResponse["status"] = isset($result->status) ? $result->status : '99';
                    $returnResponse["transactionRef"] = $input['txnRef'];
                    $returnResponse["transactionDate"] = date('Y-m-d H:i:s');
                    $returnResponse["orderId"] = $input['orderId'];
                    $returnResponse["redirectUrl"] = $input['returnUrl'];
                    return view('guests.payment.web.eagle_card_payment_final_route', compact('returnResponse'));
                }
            } else {
                $returnResponse["statusmessage"] = "Invalid Dataset";
                $returnResponse["reason"] = "Invalid Dataset Provided. Parameters Provided are Incomplete";
                $returnResponse["merchantId"] = $input['merchantId'];
                $returnResponse["deviceCode"] = $input['deviceCode'];
                $returnResponse["status"] = '02';
                $returnResponse["transactionRef"] = $input['txnRef'];
                $returnResponse["transactionDate"] = date('Y-m-d H:i:s');
                $returnResponse["orderId"] = $input['orderId'];
                $returnResponse["redirectUrl"] = $input['returnUrl'];
                return view('guests.payment.web.eagle_card_payment_final_route', compact('returnResponse'));
            }
        }else
        {
            $returnResponse["statusmessage"] = "No Data Provided";
            $returnResponse["reason"] = "No Data Provided. Parameters Provided are Incomplete";
            $returnResponse["status"] = '09';
            $returnResponse["transactionDate"] = date('Y-m-d H:i:s');
            return view('guests.payment.web.eagle_card_payment_final_route', compact('returnResponse'));
        }*/
        //$input = \Crypt::encrypt($input);

        $billData = new \App\Models\BillData();
        $billData->data = json_encode($input);
        //dd($billData);
        $billData->save();
        $input = $billData->id;
        $input = \Crypt::encrypt($input);
        \Session::put('billDataId', $billData->id);


        //dd($billData->data);
        //$key = PAYMENT_DETAILS_LISTING;
        $key = PAYMENT_OPTIONS_LISTING;
		return view('secure.dashboard', compact('key', 'input'));
    }


	public function postTokenize(Request $request)
    {
        $all = $request->all();
        $data = $all['data'];
        $selected = $all['selected'];
        $billIdEnc = $data;
        $data = \Crypt::decrypt($data);
        $billData = \App\Models\BillData::where('id', '=', $data)->first();
        $data1 = $billData->data;
        $data1 = json_decode($data1, TRUE);
        $merchantId = $data1['merchantId'];
        $deviceCode = $data1['deviceCode'];
        $serviceTypeId = $data1['serviceTypeId'];
        $orderId = $data1['orderId'];
        $acquirer = \DB::table('acquirer')->where('isDefault', '=', 1)->first();
        $apkey = $acquirer->accessExodus;
        


        $rt = "";
        $toHash = "$merchantId$deviceCode$serviceTypeId$orderId$rt$apkey";
        $hash = hash('sha512', $toHash);
        $data = [];
        $data['token'] = \Auth::user()->token;
        $data['orderId'] = $orderId;
        $data['hash'] = $hash;
        $data['merchantId'] = $merchantId;
        $data['deviceCode'] = $deviceCode;
        $data['serviceTypeId'] = $serviceTypeId;

	$selected_ = explode('|||', $selected);
	$s2 = [];
	foreach($selected_ as $s1)
	{
		array_push($s2, $s1);
	}
        $data['selected'] = $s2;
        $data['responseUrl'] = $rt;
        $data['hashStr'] = $toHash;
        //dd($data);

        $encrypterFrom = new Encrypter($apkey, 'AES-256-CBC');
        $dataStr = json_encode($data);
        $dataEncrypted = $encrypterFrom->encrypt($dataStr);
        $data = [];
        $data['txnDetail'] = $dataEncrypted;
        $jsonDataLump = json_encode($data);
        $encoded = base64_encode($jsonDataLump);
        $data['transactionObject'] = $encoded;
        $data['token'] = $billData->token_data;
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/PaymentServicesV2/generateOTPForTokenization';

        //dd($data);

        $result = null;
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        $authDataStr = sendPostRequest($url, $dataStr);
        //dd($authDataStr);
        $authData = json_decode($authDataStr);

        //dd($toHash);
        //dd([$toHash, $authData]);


        if($authData->status==900) {
            $message = $authData->message;
            $key = TOKENIZE_OTP;
            $resp = [];
            $resp['key'] = $key;
            $resp['input'] = $billIdEnc;
            $resp['status'] = 100;
            $resp['success'] = true;
            $resp['otp_txn_ref'] = $authData->transactionRef;
            $resp['otp_receipient'] = $authData->otpRec;
            //$resp['sess'] = Jjson_encode(\Session::all());

            //dd(\Auth::user());
            return \Response::json($resp, 200);
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
	
	
	
    public function postInitiateWalletPayment(Request $request)
    {
        $all = $request->all();
        $data = $all['data'];
        $billIdEnc = $data;
        $data = \Crypt::decrypt($data);
        $billData = \App\Models\BillData::where('id', '=', $data)->first();
        $data1 = $billData->data;
        $data1 = json_decode($data1, TRUE);
        $totalAmount = doubleVal($data1['total_amount']);
        $hash = $data1['hash'];
        //dd($data1);


        $selectedCards = $all['selectedCards'];
        $selectedCards = explode('|||', $selectedCards);
        $cardSerialNos = [];
        $cardTrackNos = [];
        $cvvs = [];
        $expDates = [];
        $index = 0;
        $payeeFirstName = "";
        $firstName = "";
        $lastName = "";
        $countryCode = "";
        $billPayeeMobile = "";
        $payeeMobile = "";
        $email = "";
        $payeeEmail = "";
        $streetAddress = "";
        $city = "";
        $district = "";
        $merchantId = $data1['merchantId'];
        $deviceCode = $data1['deviceCode'];
        $serviceTypeId = $data1['serviceTypeId'];
        $currency = $data1['currency'];
        $orderId = $data1['orderId'];
        $acquirer = \DB::table('acquirer')->where('isDefault', '=', 1)->first();
        $apkey = $acquirer->accessExodus;
        foreach($selectedCards as $k => $selectedCard)
        {
            $selectedCard_ = \Crypt::decrypt($selectedCard);
            //dd($selectedCard_);
            $selectedCard_ = explode('~~~', $selectedCard_);
            $expDate = explode(' ', $selectedCard_[3]);
            $expDate = date('Y-m-d', strtotime($expDate[0]));
            $expDate = date('m/y', strtotime($expDate));

            array_push($cardSerialNos, $selectedCard_[0]);
            array_push($cardTrackNos, $selectedCard_[1]);
            array_push($cvvs, $selectedCard_[2]);
            array_push($expDates, $expDate);
            if($k === 0)
            {
                $payeeFirstName = $selectedCard_[4];
                $firstName = $selectedCard_[4];
                $lastName = $selectedCard_[5];
                $countryCode = $selectedCard_[6];
                $billPayeeMobile = $selectedCard_[7];
                $payeeMobile = $selectedCard_[7];
                $email = $selectedCard_[8];
                $payeeEmail = $selectedCard_[8];
                $streetAddress = $selectedCard_[9];
                $city = $selectedCard_[10];
                $district = $selectedCard_[11];

            }
        }


        $rt = "";
        $tamt = number_format($totalAmount, 2, '.', '');
        $toHash = "$merchantId$deviceCode$serviceTypeId$orderId$tamt$rt$apkey";
        //$hash = hash('sha512', $toHash);
        $data = [];
        $data['token'] = \Auth::user()->token;
        $data['cardSerialNo'] = join('~~~', $cardSerialNos);
        $data['cardTrackingNo'] = join('~~~', $cardTrackNos);
        $data['expiryDate'] = join('~~~', $expDates);
        $data['cvv'] = join('~~~', $cvvs);
        $data['payeeFirstName'] = $payeeFirstName;
        $data['payeeEmail'] = $payeeEmail;
        $data['payeeMobile'] = $payeeMobile;
        $data['amount'] = $totalAmount;
        $data['orderId'] = $orderId;
        $data['hash'] = $hash;
        $data['merchantId'] = $merchantId;
        $data['deviceCode'] = $deviceCode;
        $data['serviceTypeId'] = $serviceTypeId;
        $data['currency'] = $currency;
        if(isset($data1['merchant_defined_data']))
            $data['customdata'] =  $data1['merchant_defined_data'];

        $data['firstName'] = $firstName;
        $data['lastName'] = $lastName;
        $data['countryCode'] = $countryCode;
        $data['billPayeeMobile'] = $billPayeeMobile;
        $data['email'] = $email;
        $data['streetAddress'] = $streetAddress;
        $data['city'] = $city;
        $data['district'] = $district;
        $data['responseUrl'] = $rt;
        $data['hashStr'] = $toHash;
        //dd($data);

        $encrypterFrom = new Encrypter($apkey, 'AES-256-CBC');
        $dataStr = json_encode($data);
        $dataEncrypted = $encrypterFrom->encrypt($dataStr);
        $data = [];
        $data['txnDetail'] = $dataEncrypted;
        $jsonDataLump = json_encode($data);
        $encoded = base64_encode($jsonDataLump);
        $data['transactionObject'] = $encoded;
        $data['token'] = $billData->token_data;
        $data['channel'] = "CARD";
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/PaymentServicesV2/generateOTPForTransaction';

        //dd($data);

        $result = null;
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        $authDataStr = sendPostRequest($url, $dataStr);
        //dd($authDataStr);
        $authData = json_decode($authDataStr);

        //dd($toHash);
        //dd($authData);


        if($authData->status==900) {
            $message = $authData->message;
            $key = PAY_FROM_LOGGED_IN_WALLET_OTP;
            $resp = [];
            $resp['key'] = $key;
            $resp['input'] = $billIdEnc;
            $resp['status'] = 100;
            $resp['success'] = true;
            $resp['txn_ref'] = $authData->orderRef;
            $resp['otp_txn_ref'] = $authData->transactionRef;
            $resp['otp_receipient'] = $authData->otpRec;
            //$resp['sess'] = Jjson_encode(\Session::all());

            //dd(\Auth::user());
            //return \Redirect::to('/ajax-pay-from-logged-in-wallet-otp.html/'.PAY_FROM_LOGGED_IN_WALLET_OTP.'/'.$billIdEnc.'/'.$authData->orderRef.'/'.$authData->transactionRef.'/'.$authData->otpRec);
            return \Response::json($resp, 200);
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
	
	
	
	public function postInitiateAccountPayment(Request $request)
    {
        $all = $request->all();
        $data = $all['data'];
        $billIdEnc = $data;
        $data = \Crypt::decrypt($data);
        $billData = \App\Models\BillData::where('id', '=', $data)->first();
        $data1 = $billData->data;
        $data1 = json_decode($data1, TRUE);
        $totalAmount = doubleVal($data1['total_amount']);
        $hash = $data1['hash'];
        //dd($data1);


        $selectedCards = $all['selectedCards'];
        $selectedCards = explode('|||', $selectedCards);
        $cardSerialNos = [];
        $cardTrackNos = [];
        $cvvs = [];
        $expDates = [];
        $index = 0;
        $payeeFirstName = "";
        $firstName = "";
        $lastName = "";
        $countryCode = "";
        $billPayeeMobile = "";
        $payeeMobile = "";
        $email = "";
        $payeeEmail = "";
        $streetAddress = "";
        $city = "";
        $district = "";
        $merchantId = $data1['merchantId'];
        $deviceCode = $data1['deviceCode'];
        $serviceTypeId = $data1['serviceTypeId'];
        $currency = $data1['currency'];
        $orderId = $data1['orderId'];
        $acquirer = \DB::table('acquirer')->where('isDefault', '=', 1)->first();
        $apkey = $acquirer->accessExodus;
        foreach($selectedCards as $k => $selectedCard)
        {
            $selectedCard_ = \Crypt::decrypt($selectedCard);
            //dd($selectedCard_);
            $selectedCard_ = explode('~~~', $selectedCard_);
            $expDate = explode(' ', $selectedCard_[3]);
            $expDate = date('Y-m-d', strtotime($expDate[0]));
            $expDate = date('m/y', strtotime($expDate));

            array_push($cardSerialNos, $selectedCard_[0]);
            array_push($cardTrackNos, $selectedCard_[1]);
            array_push($cvvs, $selectedCard_[2]);
            array_push($expDates, $expDate);
            if($k === 0)
            {
                $payeeFirstName = $selectedCard_[4];
                $firstName = $selectedCard_[4];
                $lastName = $selectedCard_[5];
                $countryCode = $selectedCard_[6];
                $billPayeeMobile = $selectedCard_[7];
                $payeeMobile = $selectedCard_[7];
                $email = $selectedCard_[8];
                $payeeEmail = $selectedCard_[8];
                $streetAddress = $selectedCard_[9];
                $city = $selectedCard_[10];
                $district = $selectedCard_[11];

            }
        }


        $rt = "";
        $tamt = number_format($totalAmount, 2, '.', '');
        $toHash = "$merchantId$deviceCode$serviceTypeId$orderId$tamt$rt$apkey";
        //$hash = hash('sha512', $toHash);
        $data = [];
        $data['token'] = \Auth::user()->token;
        $data['walletIdentifier'] = join('~~~', $cardSerialNos);
        $data['payeeFirstName'] = $payeeFirstName;
        $data['payeeEmail'] = $payeeEmail;
        $data['payeeMobile'] = $payeeMobile;
        $data['amount'] = $totalAmount;
        $data['orderId'] = $orderId;
        $data['hash'] = $hash;
        $data['merchantId'] = $merchantId;
        $data['deviceCode'] = $deviceCode;
        $data['serviceTypeId'] = $serviceTypeId;
        $data['currency'] = $currency;
        if(isset($data1['merchant_defined_data']))
            $data['customdata'] =  $data1['merchant_defined_data'];

        $data['firstName'] = $firstName;
        $data['lastName'] = $lastName;
        $data['countryCode'] = $countryCode;
        $data['billPayeeMobile'] = $billPayeeMobile;
        $data['email'] = $email;
        $data['streetAddress'] = $streetAddress;
        $data['city'] = $city;
        $data['district'] = $district;
        $data['responseUrl'] = $rt;
        $data['hashStr'] = $toHash;
        //dd($data);

        $encrypterFrom = new Encrypter($apkey, 'AES-256-CBC');
        $dataStr = json_encode($data);
        $dataEncrypted = $encrypterFrom->encrypt($dataStr);
        $data = [];
        $data['txnDetail'] = $dataEncrypted;
        $jsonDataLump = json_encode($data);
        $encoded = base64_encode($jsonDataLump);
        $data['transactionObject'] = $encoded;
        $data['token'] = $billData->token_data;
        $data['channel'] = "WALLET";
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/PaymentServicesV2/generateOTPForWalletTransaction';

        //dd($data);

        $result = null;
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        $authDataStr = sendPostRequest($url, $dataStr);
        //dd($authDataStr);
        $authData = json_decode($authDataStr);

        //dd($toHash);
        //dd($authData);


        if($authData->status==900) {
            $message = $authData->message;
            $key = PAY_FROM_LOGGED_IN_WALLET_OTP;
            $resp = [];
            $resp['key'] = $key;
            $resp['input'] = $billIdEnc;
            $resp['status'] = 100;
            $resp['success'] = true;
            $resp['txn_ref'] = $authData->orderRef;
            $resp['otp_txn_ref'] = $authData->transactionRef;
            $resp['otp_receipient'] = $authData->otpRec;
            //$resp['sess'] = Jjson_encode(\Session::all());

            //dd(\Auth::user());
            //return \Redirect::to('/ajax-pay-from-logged-in-wallet-otp.html/'.PAY_FROM_LOGGED_IN_WALLET_OTP.'/'.$billIdEnc.'/'.$authData->orderRef.'/'.$authData->transactionRef.'/'.$authData->otpRec);
            return \Response::json($resp, 200);
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

    public function translatePay()
    {

        $input = \Input::all();
        //dd($input['data']);
        //dd(\Crypt::decrypt($input['data']));

        $rules = ['payoption' => 'required|in:BANKONLINE,LOCALVISA,EAGLECARD,OTC,WALLET,UBA,ZICBWALLET', 'net-banking' => 'required_if:payoption,BANKONLINE', 'firstName' => 'required_if:payoption,LOCALVISA',
			'lastName' => 'required_if:payoption,LOCALVISA', 'email' => 'required_if:payoption,LOCALVISA', 'streetAddress' => 'required_if:payoption,LOCALVISA',
			'city' => 'required_if:payoption,LOCALVISA', 'countryCode' => 'required_if:payoption,LOCALVISA', 'phoneNumber' => 'required_if:payoption,LOCALVISA',
			'Province' => 'required_if:payoption,LOCALVISA', 'district' => 'required_if:payoption,LOCALVISA', 'nationalId' => 'required_if:payoption,LOCALVISA',
			'firstNameuba' => 'required_if:payoption,UBA',
			'lastNameuba' => 'required_if:payoption,UBA', 'emailuba' => 'required_if:payoption,UBA', 'streetAddressuba' => 'required_if:payoption,UBA',
			'cityuba' => 'required_if:payoption,UBA', 'countryCodeUba' => 'required_if:payoption,UBA', 'phoneNumberUba' => 'required_if:payoption,UBA',
			'Provinceuba' => 'required_if:payoption,UBA', 'districtuba' => 'required_if:payoption,UBA', 'nationalIdUba' => 'required_if:payoption,UBA',
			'firstNameBank' => 'required_if:payoption,BANKONLINE',
			'lastNameBank' => 'required_if:payoption,BANKONLINE', 'emailBank' => 'required_if:payoption,BANKONLINE', 'streetAddressBank' => 'required_if:payoption,BANKONLINE',
			'cityBank' => 'required_if:payoption,BANKONLINE', 'countryCodeBank' => 'required_if:payoption,BANKONLINE', 'phoneNumberBank' => 'required_if:payoption,BANKONLINE',
			'ProvinceBank' => 'required_if:payoption,BANKONLINE', 'districtBank' => 'required_if:payoption,BANKONLINE', 'nationalIdBank' => 'required_if:payoption,BANKONLINE'];

		$messages = [
			'payoption.required' => 'Specify your preferred payment option', 'payoption.in' => 'Specify your preferred payment option',
			'net-banking.required_if' => 'Specify your preferred bank for online banking',
			'firstName.required_if' => 'Provide your first name if you intend to use VISA/MASTERCARD payments',
			'lastName.required_if' => 'Provide your last name if you intend to use VISA/MASTERCARD payments',
			'email.required_if' => 'Provide your email address if you intend to use VISA/MASTERCARD payments',
			//'email.email' => 'Provide a valid email address if you intend to use VISA/MASTERCARD payments',
			'streetAddress.required_if' => 'Provide your street address if you intend to use VISA/MASTERCARD payments',
			'city.required_if' => 'Provide your city if you intend to use VISA/MASTERCARD payments',
			'countryCode.required_if' => 'Provide your country code if you intend to use VISA/MASTERCARD payments',
			'phoneNumber.required_if' => 'Provide a valid mobile number if you intend to use VISA/MASTERCARD payments',
			'Province.required_if' => 'Specify your province if you intend to use VISA/MASTERCARD payments',
			'district.required_if' => 'Specify your district if you intend to use VISA/MASTERCARD payments',
			'nationalId.required_if' => 'Specify your National Id Number/TPIN as a means of identification if you intend to use VISA/MASTERCARD payments',
			'firstNameuba.required_if' => 'Provide your first name',
			'lastNameuba.required_if' => 'Provide your last name',
			'emailuba.required_if' => 'Provide your email address',
			//'emailuba.email' => 'Provide a valid email address',
			'streetAddressuba.required_if' => 'Provide your street address',
			'cityuba.required_if' => 'Provide your city',
			'countryCodeUba.required_if' => 'Provide your country code',
			'phoneNumberUba.required_if' => 'Provide a valid mobile number',
			'Provinceuba.required_if' => 'Specify your province',
			'districtuba.required_if' => 'Specify your district',
			'nationalIdUba.required_if' => 'Specify your National Id Number/TPIN as a means of identification',
			'firstNameBank.required_if' => 'Provide your first name',
			'lastNameBank.required_if' => 'Provide your last name',
			'emailBank.required_if' => 'Provide your email address',
			//'emailuba.email' => 'Provide a valid email address',
			'streetAddressBank.required_if' => 'Provide your street address',
			'cityBank.required_if' => 'Provide your city',
			'countryCodeBank.required_if' => 'Provide your country code',
			'phoneNumberBank.required_if' => 'Provide a valid mobile number',
			'ProvinceBank.required_if' => 'Specify your province',
			'districtBank.required_if' => 'Specify your district',
			'nationalIdBank.required_if' => 'Specify your Bank Id Number which you are registered with at the bank. This may be your mobile number, National Id Number/TPIN'
			];
		$validator = \Validator::make($input, $rules, $messages);
		//dd($input);
		if($validator->fails())
		{
			$errMsg = json_decode($validator->messages(), true);
			$str_error = "";
			$i = 1;
			foreach($errMsg as $key => $value)
			{
				foreach($value as $val) {
					$str_error = $str_error.($val)."<br>";
				}
			}

			//return \Redirect::back()->withInput($all)->with('error', $str_error);
			//dd(\Crypt::decrypt($input['data']));
			$params = \Crypt::decrypt($input['data']);
			//dd($params);
			//dd($input);

			//$this->loadPaymentDetailsView('PAYMENT_DETAILS_LISTING', $input['data']);
			return view('secure.submitter', compact('params', 'str_error'));
			//return \Redirect::back()->with('error', $str_error);
		}




        $data = \Crypt::decrypt($input['data']);
        //dd($data);
        $input = $input + $data;



        unset($input['data']);
        //dd($input);


        if (in_array('payoption', array_keys($input)) && $input['payoption']!=NULL) {
            $payoption = $input['payoption'];
            switch ($payoption) {
                case 'EAGLECARD' :
                    return $this->handleEagleCardPayment($input);
                    break;
                case 'LOCALVISA' :
                    return $this->handleCybersourcePayment($input);
                    break;
                case 'UBA' :
                    return $this->handleUbaPayment($input);
                    break;
                case 'BANKONLINE' :
                    return $this->handleBankOnlinePayment($input);
                    break;
                case 'OTC' :
                    return $this->handleOTCPayment($input);
                    break;
                case 'MMONEY' :
                    $this->handleMMoneyPayment($input);
                    break;
                case 'WALLET' :
                    return $this->handleWalletPayment($input);
                    break;
                case 'ZICBWALLET' :
                    return $this->handleZICBWalletPayment($input);
                    break;
            }
        } else {
            //No ServiceType In Form submitted
            $response["statusmessage"] = "Payment Option Not Specified";
            $response["reason"] = "Payment Option Needs to Be Specified";
            $response["merchantId"] = $input['merchantId'];
            $response["deviceCode"] = $input['deviceCode'];
            $response["status"] = '10';
            $response["transactionDate"] = date('Y-m-d H:i:s');
            $response["orderId"] = $input['orderId'];
            $response["redirectUrl"] = $input['responseurl'];
            return \Redirect::to('/payments/init')->with('error', 'Payment Option Not Specified');
        }
    }

    public function postConfirmPayment(Request $request)
    {

        $params = $request->all();
        $billIdEnc = $params['data'];
        $billId = \Crypt::decrypt($billIdEnc);
        $billData1 = \App\Models\BillData::where('id', '=', $billId)->first();
        $billData = (json_decode($billData1->data));

        //

        $orderId = $params['orderId'];
        $transactionRef = $params['transactionRef'];
        $data = $params['data'];
        $token = $params['token'];
        $otp = $params['otp1']."".$params['otp2']."".$params['otp3']."".$params['otp4'];


        $merchantId =$billData->merchantId;
        $deviceCode =$billData->deviceCode;
        $serviceTypeId = $billData->serviceTypeId;
        $tamt = doubleVal($billData->total_amount);
        $acquirer = \DB::table('acquirer')->where('isDefault', '=', 1)->first();
        $apkey = $acquirer->accessExodus;

        //dd($billData);

        $hash = $billData->hash;
        $data = [];
        $data['orderId'] = $orderId;
        $data['transactionRef'] = $transactionRef;
        $data['otp'] = $otp;
        $data['serviceTypeId'] = $billData->serviceTypeId;
        $data['responseUrl'] = $billData->responseurl;
        $data['amount'] = doubleVal($billData->total_amount);
        $data['merchantId'] = $billData->merchantId;
        $data['deviceCode'] = $billData->deviceCode;
        $data['hash'] = $hash;
        $data['token'] = $token;
	 $data['bankNarration'] = $bankNarration;
        //dd($data);
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/PaymentServicesV2/confirmOTPPayment';

        //dd($data);

        $result = null;
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        $authDataStr = sendPostRequest($url, $dataStr);
        $authData = json_decode($authDataStr);
        //dd([$hash, $authData]);

        //dd($toHash);
        //dd($authData);


        if($authData->status==1000016) {
            $message = $authData->message;
            $key = PAY_FROM_LOGGED_IN_WALLET_SUCCESS_PAGE;
            $resp = [];
            $resp['key'] = $key;
            $resp['input'] = $billIdEnc;
            $resp['status'] = 100;
            $resp['success'] = true;
            $resp['order_ref'] = $authData->orderId;
            $resp['txn_ref'] = $authData->txnRef;
            $resp['merchant_id'] = $authData->merchantId;
            $resp['merchant_name'] = $authData->merchantName;
            $resp['channel'] = $authData->channel;
            

            if(isset($authData->customerMobileNumber))
                $resp['customer_mobile_number'] = $authData->customerMobileNumber;
            if(isset($authData->customrEmailAddress))
                $resp['customer_email_address'] = $authData->customerEmailAddress;

            $resp['device_code'] = $authData->deviceCode;
            $resp['transaction_date'] = $authData->transactionDate;
            $resp['auto_return_to_merchant'] = $authData->autoReturnToMerchant;
            $resp['return_url'] = $authData->returnUrl;
            $resp['paying_info'] = $authData->cardInfo;
            //$resp['sess'] = Jjson_encode(\Session::all());

            //dd(\Auth::user());
            $billData1->response_data = json_encode($resp);
            $billData1->status = 1;
            $billData1->save();
            //return \Redirect::to('/ajax-pay-from-logged-in-wallet-success.html/'.PAY_FROM_LOGGED_IN_WALLET_SUCCESS_PAGE.'/'.$billIdEnc);
            return \Response::json($resp, 200);
        }
        else if($authData->status==-1) {
            return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
        }
        else{
            //dd($authData);
            /*$message = $authData->message;
            $key = PAY_FROM_LOGGED_IN_WALLET_SUCCESS_PAGE;
            $resp = [];
            $resp['key'] = $key;
            $resp['input'] = $billIdEnc;
            $resp['status'] = 100;
            $resp['success'] = true;
            $resp['order_ref'] = $authData->orderId;
            $resp['txn_ref'] = $authData->txnRef;
            $resp['merchant_id'] = $billData->merchantId;
            $resp['merchant_name'] = isset($authData->merchantName) ? $authData->merchantName : null;
            $resp['channel'] = isset($authData->channel) ? $authData->channel : null;

            if(isset($authData->customerMobileNumber))
                $resp['customer_mobile_number'] = $authData->customerMobileNumber;
            if(isset($authData->customrEmailAddress))
                $resp['customer_email_address'] = $authData->customerEmailAddress;

            $resp['device_code'] = $billData->deviceCode;
            $resp['transaction_date'] = $authData->transactionDate;
            $resp['auto_return_to_merchant'] = isset($authData->autoReturnToMerchant) ? $authData->autoReturnToMerchant : null;
            $resp['return_url'] = isset($authData->returnUrl) ? $authData->returnUrl : null;
            $resp['paying_info'] = isset($authData->cardInfo) ? $authData->cardInfo : null;
            //$resp['sess'] = Jjson_encode(\Session::all());

            //dd(\Auth::user());
            $billData1->response_data = json_encode($resp);
            $billData1->status = 2;//FAILED
            $billData1->save();

            //return \Redirect::to('/ajax-pay-from-logged-in-wallet-failed.html/'.PAY_FROM_LOGGED_IN_WALLET_FAIL_PAGE.'/'.$billIdEnc);
            return \Response::json($resp, 200);*/

		$message = $authData->message;
            $key = PAY_FROM_LOGGED_IN_WALLET_FAIL_PAGE;
            $resp = [];
            $resp['key'] = $key;
            $resp['input'] = $billIdEnc;
            $resp['status'] = 101;
            $resp['success'] = true;
            $resp['order_ref'] = $authData->orderId;
            $resp['txn_ref'] = $authData->txnRef;
            $resp['merchant_id'] = $billData->merchantId;
            $resp['merchant_name'] = isset($authData->merchantName) ? $authData->merchantName : null;
            $resp['channel'] = isset($authData->channel) ? $authData->channel : null;

            if(isset($authData->customerMobileNumber))
                $resp['customer_mobile_number'] = $authData->customerMobileNumber;
            if(isset($authData->customrEmailAddress))
                $resp['customer_email_address'] = $authData->customerEmailAddress;

            $resp['device_code'] = $billData->deviceCode;
            $resp['transaction_date'] = $authData->transactionDate;
            $resp['auto_return_to_merchant'] = isset($authData->autoReturnToMerchant) ? $authData->autoReturnToMerchant : null;
            $resp['return_url'] = isset($authData->returnUrl) ? $authData->returnUrl : null;
            $resp['paying_info'] = isset($authData->cardInfo) ? $authData->cardInfo : null;
            //$resp['sess'] = Jjson_encode(\Session::all());

            //dd(\Auth::user());
            $billData1->response_data = json_encode($resp);
            $billData1->status = 2;//FAILED
            $billData1->save();

            //return \Redirect::to('/ajax-pay-from-logged-in-wallet-failed.html/'.PAY_FROM_LOGGED_IN_WALLET_FAIL_PAGE.'/'.$billIdEnc);
            return \Response::json($resp, 200);
        }

    }
	
	
	
	
	public function postConfirmAccountPayment(Request $request)
    {

        $params = $request->all();
	//dd($params['data']);
        $billIdEnc = $params['data'];
        $billId = \Crypt::decrypt($billIdEnc);
        $billData1 = \App\Models\BillData::where('id', '=', $billId)->first();
        $billData = (json_decode($billData1->data));
	 //return response()->json(['message' => $billData , 'success' => false, 'status' => 190333], 200);
        //

        $orderId = $params['orderId'];
        $transactionRef = $params['transactionRef'];
        $data = $params['data'];
        $token = $params['token'];
        $otp = $params['otp1']."".$params['otp2']."".$params['otp3']."".$params['otp4'];


        $merchantId =$billData->merchantId;
        $deviceCode =$billData->deviceCode;
        $serviceTypeId = $billData->serviceTypeId;
        $tamt = doubleVal($billData->total_amount);
        $acquirer = \DB::table('acquirer')->where('isDefault', '=', 1)->first();
        $apkey = $acquirer->accessExodus;

        //dd($billData);

        $hash = $billData->hash;
        $data = [];
        $data['orderId'] = $orderId;
        $data['transactionRef'] = $transactionRef;
        $data['otp'] = $otp;
        $data['serviceTypeId'] = $billData->serviceTypeId;
        $data['responseUrl'] = $billData->responseurl;
        $data['amount'] = doubleVal($billData->total_amount);
        $data['merchantId'] = $billData->merchantId;
        $data['deviceCode'] = $billData->deviceCode;
        $data['hash'] = $hash;
        $data['token'] = $token;
	 $data['bankNarration'] = isset($billData->narration) ? $billData->narration : "";
        //dd($data);
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/PaymentServicesV2/confirmOTPForWalletPayment';

        //dd($data);

        $result = null;
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        $authDataStr = sendPostRequest($url, $dataStr);
        $authData = json_decode($authDataStr);
        //dd([$hash, $authData]);

        //dd($toHash);
        //dd($authData);


        if($authData->status==1000016) {
            $message = $authData->message;
            $key = PAY_FROM_LOGGED_IN_WALLET_SUCCESS_PAGE;
            $resp = [];
            $resp['key'] = $key;
            $resp['input'] = $billIdEnc;
            $resp['status'] = 100;
            $resp['success'] = true;
            $resp['order_ref'] = $authData->orderId;
            $resp['txn_ref'] = $authData->txnRef;
            $resp['merchant_id'] = $authData->merchantId;
            $resp['merchant_name'] = $authData->merchantName;
            $resp['channel'] = $authData->channel;

            if(isset($authData->customerMobileNumber))
                $resp['customer_mobile_number'] = $authData->customerMobileNumber;
            if(isset($authData->customrEmailAddress))
                $resp['customer_email_address'] = $authData->customerEmailAddress;

            $resp['device_code'] = $authData->deviceCode;
            $resp['transaction_date'] = $authData->transactionDate;
            $resp['auto_return_to_merchant'] = $authData->autoReturnToMerchant;
            $resp['return_url'] = $authData->returnUrl;
            $resp['paying_info'] = $authData->accountInfo;
            //$resp['sess'] = Jjson_encode(\Session::all());

            //dd(\Auth::user());
            $billData1->response_data = json_encode($resp);
            $billData1->status = 1;
            $billData1->save();
            //return \Redirect::to('/ajax-pay-from-logged-in-wallet-success.html/'.PAY_FROM_LOGGED_IN_WALLET_SUCCESS_PAGE.'/'.$billIdEnc);
            return \Response::json($resp, 200);
        }
        else if($authData->status==-1) {
            return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
        }
        else{
            //dd($authData);
            $message = $authData->message;
            $key = PAY_FROM_LOGGED_IN_WALLET_FAIL_PAGE;
            $resp = [];
            $resp['key'] = $key;
            $resp['input'] = $billIdEnc;
            $resp['status'] = 101;
            $resp['success'] = true;
            $resp['order_ref'] = $authData->orderId;
            $resp['txn_ref'] = $authData->txnRef;
            $resp['merchant_id'] = $billData->merchantId;
            $resp['merchant_name'] = isset($authData->merchantName) ? $authData->merchantName : null;
            $resp['channel'] = isset($authData->channel) ? $authData->channel : null;

            if(isset($authData->customerMobileNumber))
                $resp['customer_mobile_number'] = $authData->customerMobileNumber;
            if(isset($authData->customrEmailAddress))
                $resp['customer_email_address'] = $authData->customerEmailAddress;

            $resp['device_code'] = $billData->deviceCode;
            $resp['transaction_date'] = $authData->transactionDate;
            $resp['auto_return_to_merchant'] = isset($authData->autoReturnToMerchant) ? $authData->autoReturnToMerchant : null;
            $resp['return_url'] = isset($authData->returnUrl) ? $authData->returnUrl : null;
            $resp['paying_info'] = isset($authData->cardInfo) ? $authData->cardInfo : null;
            //$resp['sess'] = Jjson_encode(\Session::all());

            //dd(\Auth::user());
            $billData1->response_data = json_encode($resp);
            $billData1->status = 2;//FAILED
            $billData1->save();

            //return \Redirect::to('/ajax-pay-from-logged-in-wallet-failed.html/'.PAY_FROM_LOGGED_IN_WALLET_FAIL_PAGE.'/'.$billIdEnc);
            return \Response::json($resp, 200);
        }

    }






	public function postConfirmTokenization(Request $request)
    {
        $params = $request->all();
        $billIdEnc = $params['data'];
        $billId = \Crypt::decrypt($billIdEnc);
        $billData1 = \App\Models\BillData::where('id', '=', $billId)->first();
        $billData = (json_decode($billData1->data));

        //

        $transactionRef = $params['transactionRef'];
        $data = $params['data'];
        $token = $params['token'];
        $otp = $params['otp1']."".$params['otp2']."".$params['otp3']."".$params['otp4'];


        $merchantId =$billData->merchantId;
        $deviceCode =$billData->deviceCode;
        $serviceTypeId = $billData->serviceTypeId;
        $acquirer = \DB::table('acquirer')->where('isDefault', '=', 1)->first();
        $apkey = $acquirer->accessExodus;

        //dd($billData);

        $hash = $billData->hash;
        $data = [];
        $data['transactionRef'] = $transactionRef;
        $data['otp'] = $otp;
        $data['serviceTypeId'] = $billData->serviceTypeId;
        $data['responseUrl'] = $billData->responseurl;
        $data['merchantId'] = $billData->merchantId;
        $data['deviceCode'] = $billData->deviceCode;
        $data['token'] = $token;
        //dd($data);
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/PaymentServicesV2/confirmOTPForTokenization';

        //dd($data);

        $result = null;
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        $authDataStr = sendPostRequest($url, $dataStr);
        $authData = json_decode($authDataStr);
        //dd([$hash, $authData]);

        //dd($toHash);
        dd($authData);


        if($authData->status==5000) {
            $message = $authData->message;
            $key = TOKENIZATION_SUCCESS_PAGE;
            $resp = [];
            $resp['key'] = $key;
            $resp['input'] = $billIdEnc;
            $resp['status'] = 100;
            $resp['success'] = true;
            $resp['txn_ref'] = $authData->txnRef;
            $resp['merchant_id'] = $authData->merchantId;
            $resp['merchant_name'] = $authData->merchantName;
            $resp['listing'] = $authData->listing;
            $resp['device_code'] = $authData->deviceCode;
            $resp['auto_return_to_merchant'] = $authData->autoReturnToMerchant;
            $resp['return_url'] = $authData->returnUrl;
            $resp['orderId'] = $billData->orderId;
            //$resp['sess'] = Jjson_encode(\Session::all());

            //dd(\Auth::user());
            $billData1->response_data = json_encode($resp);
            $billData1->status = 1;
            $billData1->save();
            //return \Redirect::to('/ajax-pay-from-logged-in-wallet-success.html/'.PAY_FROM_LOGGED_IN_WALLET_SUCCESS_PAGE.'/'.$billIdEnc);
            return \Response::json($resp, 200);
        }
        else if($authData->status==-1) {
            return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
        }
        else{
            //dd($authData);
            $message = $authData->message;
            $key = TOKENIZATION_FAIL_PAGE;
            $resp = [];
            $resp['key'] = $key;
            $resp['input'] = $billIdEnc;
            $resp['status'] = 101;
            $resp['success'] = true;
            $resp['txn_ref'] = $authData->txnRef;
            $resp['merchant_id'] = $billData->merchantId;
            $resp['merchant_name'] = isset($authData->merchantName) ? $authData->merchantName : null;
            $resp['auto_return_to_merchant'] = isset($authData->autoReturnToMerchant) ? $authData->autoReturnToMerchant : null;
            $resp['return_url'] = isset($authData->returnUrl) ? $authData->returnUrl : null;
            //$resp['sess'] = Jjson_encode(\Session::all());

            //dd(\Auth::user());
            $billData1->response_data = json_encode($resp);
            $billData1->status = 2;//FAILED
            $billData1->save();

            //return \Redirect::to('/ajax-pay-from-logged-in-wallet-failed.html/'.PAY_FROM_LOGGED_IN_WALLET_FAIL_PAGE.'/'.$billIdEnc);
            return \Response::json($resp, 200);
        }

    }


    public function loadPaymentWalletOTPLoggedInView($input, $orderRef, $transactionRef, $otpRec)
   {
       $sessionContainer = [];
       if(\Session::has('error') || \Session::has('message'))
       {
           $sessionError = \Session::get('error');
           $sessionMessage = \Session::get('message');
           $sessionContainer['error'] = $sessionError;
           $sessionContainer['message'] = $sessionMessage;
       }

        $billId = \Crypt::decrypt($input);
        $billData = \App\Models\BillData::where('id', '=', $billId)->first();
        $token = $billData->token_data;
        $billData = $billData->data;
        $billData = json_decode($billData, TRUE);
        $totalAmount = doubleVal($billData['total_amount']);
        $currency = $billData['currency'];
       return view('guests.payment.web.wallet-otp-confirm-payment-view', compact('token', 'totalAmount', 'billData', 'currency', 'orderRef', 'input', 'transactionRef', 'otpRec' ));

   }
   
   
	public function loadPaymentAccountOTPLoggedInView($input, $orderRef, $transactionRef, $otpRec)
	{
       $sessionContainer = [];
       if(\Session::has('error') || \Session::has('message'))
       {
           $sessionError = \Session::get('error');
           $sessionMessage = \Session::get('message');
           $sessionContainer['error'] = $sessionError;
           $sessionContainer['message'] = $sessionMessage;
       }

        $billId = \Crypt::decrypt($input);
        $billData = \App\Models\BillData::where('id', '=', $billId)->first();
        $token = $billData->token_data;
        $billData = $billData->data;
        $billData = json_decode($billData, TRUE);
        $totalAmount = doubleVal($billData['total_amount']);
        $currency = $billData['currency'];
       return view('guests.payment.web.account-otp-confirm-payment-view', compact('token', 'totalAmount', 'billData', 'currency', 'orderRef', 'input', 'transactionRef', 'otpRec' ));

	}


    public function loadPaymentWalletSuccessPaymentView($input)
    {
         $sessionContainer = [];
         if(\Session::has('error') || \Session::has('message'))
         {
             $sessionError = \Session::get('error');
             $sessionMessage = \Session::get('message');
             $sessionContainer['error'] = $sessionError;
             $sessionContainer['message'] = $sessionMessage;
         }

         $billId = \Crypt::decrypt($input);
         $billData = \App\Models\BillData::where('id', '=', $billId)->first();
         $responseData = $billData->response_data;
         $billData = $billData->data;
         $billData = json_decode($billData, TRUE);
         $responseData = json_decode($responseData, TRUE);
            //dd($responseData);
         $orderRef = $billData['orderId'];
         $txnRef = $responseData['txn_ref'];
         $totalAmount = doubleVal($billData['total_amount']);
         $currency = $billData['currency'];
         $merchant_name = $responseData['merchant_name'];
         $customer_mobile_number = isset($responseData['customer_mobile_number']) ? $responseData['customer_mobile_number'] : null;
         $customer_email_address = isset($responseData['customer_email_address']) ? $responseData['customer_email_address'] : null;
         $channel = isset($responseData['channel']) ? $responseData['channel'] : null;
         return view('guests.payment.web.payment-success-view', compact('responseData', 'channel', 'txnRef', 'merchant_name', 'customer_mobile_number', 'customer_email_address', 'billId', 'totalAmount', 'billData', 'currency', 'orderRef', 'input', 'responseData' ));

    }


    public function loadPaymentWalletFailPaymentView($key, $input)
    {
         $sessionContainer = [];
         if(\Session::has('error') || \Session::has('message'))
         {
             $sessionError = \Session::get('error');
             $sessionMessage = \Session::get('message');
             $sessionContainer['error'] = $sessionError;
             $sessionContainer['message'] = $sessionMessage;
         }

         $billId = \Crypt::decrypt($input);
         $billData = \App\Models\BillData::where('id', '=', $billId)->first();
         $responseData = $billData->response_data;
         $billData = $billData->data;
         $billData = json_decode($billData, TRUE);
         $responseData = json_decode($responseData, TRUE);
            //dd($responseData);
         $orderRef = $billData['orderId'];
         $txnRef = $responseData['txn_ref'];
         $totalAmount = doubleVal($billData['total_amount']);
         $currency = $billData['currency'];
         $merchant_name = $responseData['merchant_name'];
         $customer_mobile_number = isset($responseData['customer_mobile_number']) ? $responseData['customer_mobile_number'] : null;
         $customer_email_address = isset($responseData['customer_email_address']) ? $responseData['customer_email_address'] : null;
         $channel = isset($responseData['channel']) ? $responseData['channel'] : null;
         return view('guests.payment.web.payment-fail-view', compact('responseData', 'channel', 'txnRef', 'merchant_name', 'customer_mobile_number', 'customer_email_address', 'billId', 'totalAmount', 'billData', 'currency', 'orderRef', 'input', 'responseData' ));

    }


    public function loadPaymentNewWalletTransferSuccessView($key, $input, $orderRef, $newBalance, $transferReceipientType, $receipientName, $txnfrAmount, $transferOrderRef)
    {
         $sessionContainer = [];
         if(\Session::has('error') || \Session::has('message'))
         {
             $sessionError = \Session::get('error');
             $sessionMessage = \Session::get('message');
             $sessionContainer['error'] = $sessionError;
             $sessionContainer['message'] = $sessionMessage;
         }
         $billId = \Crypt::decrypt($input);
         $billData = \App\Models\BillData::where('id', '=', $billId)->first();
         $responseData = $billData->response_data;
         $billData = $billData->data;
         $billData = json_decode($billData, TRUE);
         $responseData = json_decode($responseData, TRUE);
         $orderRef = $billData['orderId'];
         $txnRef = $responseData['txn_ref'];
         $totalAmount = doubleVal($billData['total_amount']);
         $currency = $billData['currency'];
         $merchant_name = $responseData['merchant_name'];
         $customer_mobile_number = isset($responseData['customer_mobile_number']) ? $responseData['customer_mobile_number'] : null;
         $customer_email_address = isset($responseData['customer_email_address']) ? $responseData['customer_email_address'] : null;
         $channel = isset($responseData['channel']) ? $responseData['channel'] : null;

         return view('guests.payment.web.transfer-funds-success-view', compact('newBalance', 'transferOrderRef', 'transferReceipientType', 'receipientName', 'txnfrAmount', 'channel', 'txnRef', 'merchant_name', 'customer_mobile_number', 'customer_email_address', 'billId', 'totalAmount', 'billData', 'currency', 'orderRef', 'input', 'responseData' ));

    }


    public function handleZICBWalletPayment()
    {


        $input = \Input::all();
        $data = \Crypt::decrypt($input['data']);
        //$tempHolder = \App\Models\TempHolder::where('id', '=', \Crypt::decrypt($input['tempHolder']))->first();
		//$data = $tempHolder->temp_holder;
		//dd(\Crypt::decrypt($data));
		//$input = \Crypt::decrypt($data);
        //dd($input);
		$dataOrig = null;
		$dataOrig = $data;
		//dd(\Crypt::decrypt($input['data']));

        if(isset($input['zicbwallet']) &&
            isset($input['data']) && strlen($input['data'])>0) {
            //$data = \Crypt::decrypt($input['data']);
            //$data = \Crypt::decrypt($data);
            //dd($data);
            $input = $input + $data;
            //dd($input);
            $paymentItems = $input['paymentItem'];
            $itemAmounts = $input['amount'];

            $total = 0;
            for ($i = 0; $i < sizeof($itemAmounts); $i++) {
                $total = $total + $itemAmounts[$i];
            }
            //dd($total);


			//dd($input);
			$walletCode = explode('###', $input['zicbwallet']);
			$walletCode = sizeof($walletCode)==2 ? $walletCode[1] : "";
            $jsonData = array('walletCode' => $walletCode,
                'payeeFirstName' => $input['payerName'],
                'payeeEmail' => $input['payerEmail'],
                'payeeMobile' => $input['payerPhone'],
                'amount' => (number_format($total, 2, '.', '')),
                'responseUrl' => $input['responseurl'],
                'orderId' => $input['orderId'],
                'hash' => $input['hash'],
                'merchantId' => $input['merchantId'],
                'deviceCode' => $input['deviceCode'],
                'serviceTypeId' => $input['serviceTypeId'],
                'firstName' => $input['firstNameWallet'],
                'lastName' => $input['lastNameWallet'],
                'countryCode' => $input['countryCodeWallet'],
                'billPayeeMobile' => $input['phoneNumberWallet'],
                'email' => $input['emailWallet'],
                'streetAddress' => $input['streetAddressWallet'],
                'city' => $input['cityWallet'],
                'nationalId' => $input['nationalIdWallet'],
                'district' => isset($input['districtWallet']) && sizeof(explode('_', $input['districtWallet']))>1 ? explode('_', $input['districtWallet'])[1] : "");
			if(isset($input['customdata']))
			{
                $jsonData['customdata'] = serialize($input['customdata']);
			}
            if(isset($input['currency']))
    		{
                $jsonData['currency'] = $input['currency'];
    		}

            //dd($input);
            //dd($jsonData);
            $jsonData = \Crypt::encrypt(json_encode($jsonData));

            $jsonDataLump = array('txnDetail' => $jsonData);
            $jsonEncode = json_encode($jsonDataLump);
            //dd($jsonEncode);
            $base64 = base64_encode($jsonEncode);
            $dataForServer = array('transactionObject' => $base64, 'channel' => "WALLET"
                //, 'zicbAuthKey'=>$input['zicbAuthKey']
                //'merchantId' => $input['merchantId'],
                //'deviceCode' => $input['deviceCode']
            );


			//dd($input);
            $data = \Crypt::encrypt($input);
            //dd($total);


            $result = handleSOAPCalls('generateOTPForWalletTransaction', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);

            //dd(\Crypt::decrypt($input['data']));
            //dd();
            //dd([$input, $result]);

            if (isset($result->status) && $result->status == "900") {
                $input['txnRef'] = $result->txnRef;
                $input['token'] = $result->token;
                $otp = $result->otp;
                $otpRec = $result->otpRec;

                $msg = "Transaction #" . $result->txnRef . " currently in progress. \nYour OTP to complete transaction is " . $otp . "\n\nThank You.";
                //dd($msg);
                //send_sms($otpRec, $msg);

                $data = \Crypt::encrypt($input);
                $payerName = $input['payerName'];
				$key = WALLET_OTP_COLLECTION_VIEW;
				$sessionContainer = [];
				if(\Session::has('error') || \Session::has('message'))
				{
					$sessionError = \Session::get('error');
					$sessionMessage = \Session::get('message');
					$sessionContainer['error'] = $sessionError;
					$sessionContainer['message'] = $sessionMessage;
				}
                //return view('guests.payment.web.eagle_card_payment_otp', compact('sessionContainer', 'data', 'paymentItems', 'itemAmounts', 'payerName'));

				$txnRef = $result->txnRef;
                $token = $result->token;
                //dd($dataOrig);
				//$input1 = \Crypt::decrypt($dataOrig);
				//$input1 = \Crypt::decrypt($dataOrig['data']);
				$input1 = $dataOrig;//['data'];
				$input2['serviceTypeId'] = $input1['serviceTypeId'];
				$input2['orderId'] = $input1['orderId'];
				$input2['txnRef'] = $result->txnRef;
				$input2['hash'] = $input1['hash'];
				$input2['currency'] = $input1['currency'];
				$input2['responseurl'] = $input1['responseurl'];
				$input2['merchantCode'] = $input['merchantId'];
				$input2['deviceCode'] = $input['deviceCode'];
				$input2['total'] = $total;
				//dd($input2);
				$input = \Crypt::encrypt($input2);

				//dd($input);
				$billData = new \App\Models\BillData();
    			$billData->data = $input;
    			$billData->save();
    			$billDataId = $billData->id;
    			$input = \Crypt::encrypt($billDataId);
    			//dd($billData);
				return view('secure.dashboard', compact('sessionContainer', 'key', 'input', 'txnRef', 'token', 'dataOrig', 'input1'));
            }
            else
            {
                $sessionContainer = [];
				$sessionContainer['error'] = "Payment was not successful. Please try again";
				//$sessionContainer['message'] = $sessionMessage;
				//dd($sessionContainer);
				$input['sessionContainer'] = $sessionContainer;

                $billData = new \App\Models\BillData();
                $billData->data = json_encode($input);
                $billData->save();
                $input = $billData->id;
                $input = \Crypt::encrypt($input);

				$key = PAYMENT_DETAILS_LISTING;
				//BillData
				return view('secure.dashboard', compact('sessionContainer', 'key', 'input'));

            }

        }
    }



    public function handleZICBDirectWalletPayment()
    {
        if(isset($input['zicbwallet']) &&
            isset($input['data']) && strlen($input['data'])>0) {
            $jsonData = array(
                'responseUrl' => $input['responseurl'],
                'orderId' => $input['orderId'],
                'hash' => $input['hash'],
                'amount' => (number_format($total, 2, '.', '')),
                'merchantId' => $input['merchantId'],
                'deviceCode' => $input['deviceCode'],
                'serviceTypeId' => $input['serviceTypeId']
            );
            $defaultReturnUrl = $data['responseurl'];

            $jsonData = \Crypt::encrypt(json_encode($jsonData));

            $jsonDataLump = array('wallobj' => $jsonData);
            $jsonEncode = json_encode($jsonDataLump);
            //dd($jsonEncode);
            $base64 = base64_encode($jsonEncode);
            $dataForServer = array();

            $merchantCode   = $input['merchantId'];
            $deviceCode     = $input['deviceCode'];
            $orderId        = $input['orderId'];
            $walletCode     = explode('###', $input['zicbwallet'])[1];
            $dataForServer = array(
                'merchantCode' => $merchantCode,
                'deviceCode'=>  $deviceCode,
                'orderId' => $orderId,
                'walletObject' => $base64,
                'walletCode' => $walletCode
            );
            //dd($dataForServer);
            $result = handleSOAPCalls('directDebitZICBPayment', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);


            //dd($result);


            if (isset($result->status) && $result->status == "00")
            {
                $response = formatPaymentResponse('WEB', $result, $defaultReturnUrl);

                if(isset($response['autoReturnToMerchant']))
                {
                    unset($response['autoReturnToMerchant']);
                    unset($response['autoReturnToMerchant']);
                }

        		$key = PAYMENT_ERROR_VIEW;
        		//dd($response);
        		if(!isset($response['redirectUrl']))
        		{
        		    $sessionContainer = [];
        			if(\Session::has('error') || \Session::has('message'))
        			{
        				$sessionError = \Session::get('error');
        				$sessionMessage = \Session::get('message');
        				$sessionContainer['error'] = $sessionError;
        				$sessionContainer['message'] = $sessionMessage;
        			}

        			$transactionRef = '';
        			if(isset($response['transactionRef']))
        			    $transactionRef = $response['transactionRef'];

        		    return view('secure.dashboard', compact('sessionContainer', 'key', 'input', 'transactionRef'));
        		}
        		else
        		{
                    return view('guests.payment.web.eagle_card_payment_final_route', compact('data', 'response'));
        		}
            }
            else
            {
                $sessionContainer = [];
				$sessionContainer['error'] = "Payment was not successful. Please try again";
				//$sessionContainer['message'] = $sessionMessage;
				//dd($sessionContainer);
				$input['sessionContainer'] = $sessionContainer;

                $billData = new \App\Models\BillData();
                $billData->data = json_encode($input);
                $billData->save();
                $input = $billData->id;
                $input = \Crypt::encrypt($input);

				$key = PAYMENT_DETAILS_LISTING;
				//BillData
				return view('secure.dashboard', compact('sessionContainer', 'key', 'input'));

            }
        }else{
            //dd($input);
            $sessionContainer = [];
			$sessionContainer['error'] = $sessionError;
			//$sessionContainer['message'] = $sessionMessage;
			$input['sessionContainer'] = $sessionContainer;


			$billData = new \App\Models\BillData();
			$billData->data = json_encode($input);
			$billData->save();
			$input = $billData->id;
			$input = \Crypt::encrypt($input);

			$key = PAYMENT_DETAILS_LISTING;
			//BillData
			return view('secure.dashboard', compact('sessionContainer', 'key', 'input'));
        }
    }



    private function handleEagleCardPayment($input)
    {
        //dd($input);
        /*$data = \Crypt::encrypt($input);
        $paymentItems = $input['paymentItem'];
        $itemAmounts = $input['amount'];
        $payerName = $input['payerName'];

        return view('guests.payment.web.eagle_card_payment', compact('data', 'itemAmounts', 'paymentItems', 'payerName'));*/
        $sessionContainer = [];
		if(\Session::has('error') || \Session::has('message'))
		{
			$sessionError = \Session::get('error');
			$sessionMessage = \Session::get('message');
			$sessionContainer['error'] = $sessionError;
			$sessionContainer['message'] = $sessionMessage;
		}
		$oldinput = $input;
		$input = \Crypt::encrypt($input);
		$tempHolder = new \App\Models\TempHolder();
		$tempHolder->temp_holder = $input;
		$tempHolder->save();

		/*$oldinput['temp_holder_id'] = $tempHolder->id;
		$input = \Crypt::encrypt($oldinput);
		$tempHolder->temp_holder = $input;
		$tempHolder->save();*/

		//dd($tempHolder);
		$input = \Crypt::encrypt($tempHolder->id);
		$key = CARD_COLLECTION_VIEW;
		return view('secure.dashboard', compact('sessionContainer', 'key', 'input'));
    }






    private function handleBankOnlinePayment($input)
    {
        //dd($input);
        $sessionContainer = [];
		if(\Session::has('error') || \Session::has('message'))
		{
			$sessionError = \Session::get('error');
			$sessionMessage = \Session::get('message');
			$sessionContainer['error'] = $sessionError;
			$sessionContainer['message'] = $sessionMessage;
		}
		$data = $input;
        $paymentItems = $input['paymentItem'];
        $itemAmounts = $input['amount'];

        //dd($input);
        //$payment_data = $input['payment_data'];
        //$payment_data = json_decode($payment_data);
        //dd($payment_data);
        $payment_data = $input;

        $bank_ = $data['net-banking'];
        $bank_ = explode('###', $bank_);
        $total = 0;
        $breakdown = array();
        for($i=0; $i<sizeof($itemAmounts); $i++)
        {
            $total = $total + $itemAmounts[$i];
            $breakdown[$paymentItems[$i]] = $itemAmounts[$i];
        }

        $orderId1 = $data['orderId'];

        if(isset($data['net-banking']) && $data['net-banking']!=null)
        {
            $phone = $data['payerPhone'];
            $input['firstName'] = $input['firstNameBank'];
            $input['lastName'] = $input['lastNameBank'];
            $input['countryCode'] = $input['countryCodeBank'];
            $input['billPayeeMobile'] = $input['countryCodeBank']."".$input['phoneNumberBank'];
            $input['email'] = $input['emailBank'];
            $input['streetAddress'] = $input['streetAddressBank'];
            $input['city'] = $input['cityBank'];
            $input['nationalId'] = $input['nationalIdBank'];
            $input['bank'] = sizeof($bank_)==2 ? $bank_[1] : $bank_[0];
            $input['district'] = isset($input['districtBank']) && sizeof(explode('_', $input['districtBank']))>1 ? explode('_', $input['districtBank'])[1] : "";
            $input['customdata'] = json_encode($input);

            $jsonData = array(
                /*'payeeFirstName' => $data['payerNameBank'],
                'payeeEmail' => $data['payerEmailBank'],
                'payeeMobile' => $data['countryCodeBank']."".$data['payerPhoneBank'],
                'amount' => (number_format($total, 2, '.', '')),
                'responseUrl' => $data['responseurl'],
                'orderId' => $data['orderId'],
                'hash' => $data['hash'],
                'merchantId' => $data['merchantId'],
                'serviceTypeId' => $data['serviceTypeId'],
                'deviceCode' => $data['deviceCode'],*/
                'payeeFirstName' => $input['payerName'],
                'payeeEmail' => $input['payerEmail'],
                'payeeMobile' => $data['payerPhone'],
                'amount' => (number_format($total, 2, '.', '')),
                'responseUrl' => $input['responseurl'],
                'orderId' => $input['orderId'],
                'hash' => $data['hash'],
                'merchantId' => $input['merchantId'],
                'deviceCode' => $input['deviceCode'],
                'serviceTypeId' => $input['serviceTypeId'],
                'firstName' => $input['firstNameBank'],
                'lastName' => $input['lastNameBank'],
                'countryCode' => $input['countryCodeBank'],
                'billPayeeMobile' => $input['countryCodeBank']."".$input['phoneNumberBank'],
                'email' => $input['emailBank'],
                'streetAddress' => $input['streetAddressBank'],
                'city' => $input['cityBank'],
                'nationalId' => $input['nationalIdBank'],
                'bank' => sizeof($bank_)==2 ? $bank_[1] : $bank_[0],
                'customdata'=> json_encode($input),
                'district' => isset($input['districtBank']) && sizeof(explode('_', $input['districtBank']))>1 ? explode('_', $input['districtBank'])[1] : ""
            );
            if(isset($input['currency']))
    		{
                $jsonData['currency'] = $input['currency'];
    		}

            //dd($jsonData);
            //$jsonData['orderId'] = strtoupper(join('-', str_split(str_random(16), 4)));
            $defaultReturnUrl = $data['responseurl'];

            $jsonData = \Crypt::encrypt(json_encode($jsonData));

            $jsonDataLump = array('bankingObject' => $jsonData,
                'bankcode' => "PROBASE");
            $jsonEncode = json_encode($jsonDataLump);

            $base64 = base64_encode($jsonEncode);
            $dataForServer = array('bankingTxnObject' => $base64);

            $result = handleSOAPCalls('processBankOnlineWebPayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);
            $data = \Crypt::encrypt($input);


            //dd($result);
            if(isset($result->status) && $result->status == "00")
            {

                /*$response['unique_reference'] = $result->txnRef;
                $response['orderId'] = $result->orderId;
                $response['transactionRef'] = $result->txnRef;
                $response['student_number'] = $input['payerId'];
                $response['student_name'] = $input['payerName'];
                $response['student_id'] = $input['nationalId'];
                $response['term'] = $input['scope'];
                $response['description'] = $input['description'];
                $response['amount'] = number_format($total, 2, '.', '');*/
                //$response['redirectUrl'] = 'http://probase.a2hosted.com/services/probasepay-sch/';
                $response['payerid'] = $phone;
                $response['paymentreference'] = $orderId1;
                $response['paymentdescription'] = $input['description'];
                $response['amount'] = $total;
                //$response['taxbreakdown'] = json_encode($breakdown);
                $response['taxbreakdown'] = json_encode($payment_data);
                $response['orderId'] = $result->orderId;
                $response['txnRef'] = $result->txnRef;
                $response['redirectUrl'] = isset($result->bankRedirectUrl) ? $result->bankRedirectUrl : 'http://probase.a2hosted.com/postpaid/SMARTPAY_1_2/services/rtsainit/';
                //$response['return_url'] = $result->returnUrl;
                $response['return_url'] = "http://demo.payments.probasepay.com/payments/confirm-payment";
                $response['incomplete_return_url'] = $result->returnUrl;

                if(isset($result->customdata))
                {
                    //dd($result->customdata);
                    $customdata = json_decode($result->customdata, TRUE);
                    $response = ($response + $customdata);
                }
                //dd(1);

                //dd($response);
                //return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
               /* $json = json_encode($breakdown);
                $json1["paymentreference"] = $result->txnRef;
                $json1["paymentdescription"]  = "RTSA TEST";
                $json1["amount"] = $total;
                $json1["taxbreakdown"] = $json;
                $json1 = json_encode($json1);
                $ch = curl_init("http://probase.a2hosted.com/postpaid/SMARTPAY_1_2/services/rtsainit/");

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

               curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($json1))
                );

                curl_setopt( $ch, CURLOPT_POSTFIELDS, $json1 );

                //curl_setopt($ch, CURLOPT_POSTFIELDS, array('data' => $json));

                $result = curl_exec($ch);

                $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if($status == 200){
                    echo "Post Successfully!";
                    return \Redirect::away('http://probase.a2hosted.com/postpaid/SMARTPAY_1_2/');
                }*/
                return view('guests.payment.web.net_banking', compact('response'));

            }else
            {
                //dd($result);
                $sessionContainer = [];
				if(\Session::has('error') || \Session::has('message'))
				{
					$sessionError = \Session::get('error');
					$sessionMessage = \Session::get('message');
					$sessionContainer['error'] = $sessionError;
					$sessionContainer['message'] = $sessionMessage;
				}

                $billData = new \App\Models\BillData();
                $billData->data = json_encode($input);
                $billData->save();
                $input = $billData->id;
                $input = \Crypt::encrypt($input);

				$key = PAYMENT_DETAILS_LISTING;
				//BillData
				return view('secure.dashboard', compact('sessionContainer', 'key', 'input'));
            }
        }
        else
        {

        }

    }


    public function confirmPayment(Request $request)
    {
        $params = $request->all();
        if(isset($params['paymentreference']) && isset($params['status']) && isset($params['message']))
        {

        }
		$amount = $params['amount'];
		$merchantId = $params['merchantId'];
		$deviceCode = $params['deviceCode'];
		$serviceTypeId = $params['serviceTypeId'];
		$orderId = $params['orderId'];
		$amount = (number_format($amount, 2, '.', ''));
		$rt = $request->get('returnUrl');
		$apkey = "iA3YvNSQDQTPWzCj2yOyMhb1nb04GoGM";


        /*$toHash = $params['merchantId']."".$params['deviceCode']."".$params['serviceTypeId']."".
					$params['orderId']."".(number_format($amount, 2, '.', ''))."".$request->get('returnUrl')."iA3YvNSQDQTPWzCj2yOyMhb1nb04GoGM";
        //$toHash = "NEVX2UDMVBB0VDCYY11981511018900RwWduZZ2b12.00http://probase.a2hosted.com/postpaid/SMARTPAY_1_2/services/rtsainit/iA3YvNSQDQTPWzCj2yOyMhb1nb04GoGM";
        $toHash = "$merchantId$deviceCode$serviceTypeId$orderId$amount$rt$apkey";

		$toHash1 = $params['merchantId'].'-'.$params['deviceCode'].'-'.$params['serviceTypeId'].
					'-'.$params['orderId'].'-'.(number_format($amount, 2, '.', '')).'-'.$request->get('returnUrl').'-'.'iA3YvNSQDQTPWzCj2yOyMhb1nb04GoGM';
		$hash = hash('sha512', $toHash);
		$params['hash'] = $hash;*/


        $bankCode = $request->get('bankCode');
        $deviceCode = $request->get('deviceCode');
        $amount = $request->get('amount');
        $orderId = $request->get('orderId');
        $txnRef = $request->get('txnRef');
        $hash = $params['hash'];
        $merchantId = $request->get('merchantId');
        $serviceTypeId = $request->get('serviceTypeId');
        $returnUrl = $request->get('returnUrl');
        $customdata  = $request->has('customdata') ? $request->get('customdata') : null;

        $jsonData = array(
            'bankCode' => $params['bankCode'],
            'deviceCode' => $params['deviceCode'],
            'orderId' => $params['orderId'],
            'amount' => (number_format($amount, 2, '.', '')),
            'txnRef' => $params['txnRef'],
            'merchantId' => $params['merchantId'],
            'hash' => $params['hash'],
            'serviceTypeId' => $params['serviceTypeId'],
            'returnUrl' => $params['returnUrl']
        );
        if($customdata!=null)
        {
            $jsonData = $jsonData + array('customdata' => $params['customdata']);
        }

        //dd($jsonData);
        //$jsonData['orderId'] = strtoupper(join('-', str_split(str_random(16), 4)));
        $defaultReturnUrl = $params['returnUrl'];

        $jsonData = \Crypt::encrypt(json_encode($jsonData));

        $jsonDataLump = array('bankingData' => $jsonData,
            'bankCode' => "PROBASE");
        $jsonEncode = json_encode($jsonDataLump);

        $base64 = base64_encode($jsonEncode);
        $dataForServer = array('bankingTxnObject' => $base64);

        $result = handleSOAPCalls('confirmBankOnlineWebPayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);
        //dd($result);
        $response = json_encode($result);
        $response = json_decode($response, TRUE);
        $response['redirectUrl'] = $response['returnUrl'];


        //dd($response);
        return view('guests.payment.web.net_banking', compact('response'));


    }


    public function handleOTCPayment($input)
    {
        $data = $input;
        $paymentItems = $input['paymentItem'];
        $itemAmounts = $input['amount'];

        $total = 0;
        for($i=0; $i<sizeof($itemAmounts); $i++)
        {
            $total = $total + $itemAmounts[$i];
        }


        $jsonData = array(
            'payeeFirstName' => $data['payerName'],
            'payeeEmail' => $data['payerEmail'],
            'payeeMobile' => $data['payerPhone'],
            'amount' => (number_format($total, 2, '.', '')),
            'responseUrl' => $data['responseurl'],
            'orderId' => $data['orderId'],
            'hash' => $data['hash'],
            'merchantId' => $data['merchantId'],
            'serviceTypeId' => $data['serviceTypeId'],
            'billingPayeeFirstName' => $data['firstName'],
            'billingPayeeLastName' => $data['lastName'],
            'billPayeeMobile' => $data['phoneNumber'],
            'billingPayeeEmail' => $data['email'],
            'streetAddress' => $data['streetAddress'],
            'city' => $data['city'],
            'district' => intval($data['district']),
            'deviceCode' => $data['deviceCode'],
            'bank' => $data['net-banking'],
        );
        if(isset($data['currency']))
		{
            $jsonData['currency'] = $data['currency'];
		}
        $defaultReturnUrl = $data['responseurl'];

        $jsonData = \Crypt::encrypt(json_encode($jsonData));

        $jsonDataLump = array('otcObject' => $jsonData,
            'bankcode' => "PROBASE");
        $jsonEncode = json_encode($jsonDataLump);

        $base64 = base64_encode($jsonEncode);
        $dataForServer = array('otcPaymentObject' => $base64);

        $result = handleSOAPCalls('processOTCWebPayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);
        $data = \Crypt::encrypt($input);




        //dd($result);
        if(isset($result->status) && $result->status == "00")
        {

            $response['unique_reference'] = $result->txnRef;
            $response['transactionRef'] = $result->txnRef;
            $response["txn_ref"] = $result->txnRef;
            $response["txnRef"] = $result->txnRef;
            $response['channel'] = $result->channel;
            $response['rpin'] = $result->rPin;
            $response['student_number'] = $input['payerId'];
            $response['student_name'] = $input['payerName'];
            $response['student_id'] = $input['nationalId'];
            $response['term'] = $input['scope'];
            $response['orderId'] = $result->orderId;
            $response['status'] = "00";
            $response['description'] = $input['description'];
            $response['amount'] = number_format($total, 2, '.', '');
            $response['redirectUrl'] = $result->returnUrl;
            //dd($response);
            $amounttopay = $result->amounttopay;
            $payermobile = $result->payermobile;

            $msg = "New Payment Ref No.:".$result->rPin."\nAmount To Pay:".$amounttopay."\nPay at any of our supporting banks or outlets. \nThank You";
            send_sms($payermobile, $msg);


            return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));

        }else
        {
            //dd($result);
            \Session::flash('error', (isset($result->message) ? $result->message : 'Error experienced. Please try again'));
            $payerName = $input['payerName'];
            return \Redirect::back()->with('error', (isset($result->message) ? $result->message : 'Error experienced. Please try again'));
        }



    }


    public function handleMMoneyPayment($input)
	{
		$data = $input;
        $paymentItems = $input['paymentItem'];
        $itemAmounts = $input['amount'];

        $total = 0;
        for($i=0; $i<sizeof($itemAmounts); $i++)
        {
            $total = $total + $itemAmounts[$i];
        }


        $jsonData = array(
            'payeeFirstName' => $data['payerName'],
            'payeeEmail' => $data['payerEmail'],
            'payeeMobile' => $data['payerPhone'],
            'amount' => (number_format($total, 2, '.', '')),
            'responseUrl' => $data['responseurl'],
            'orderId' => $data['orderId'],
            'hash' => $data['hash'],
            'merchantId' => $data['merchantId'],
            'serviceTypeId' => $data['serviceTypeId'],
            'billingPayeeFirstName' => $data['firstName'],
            'billingPayeeLastName' => $data['lastName'],
            'billPayeeMobile' => $data['phoneNumber'],
            'billingPayeeEmail' => $data['email'],
            'streetAddress' => $data['streetAddress'],
            'city' => $data['city'],
            'district' => intval($data['district']),
            'deviceCode' => $data['deviceCode'],
            'bank' => $data['net-banking'],
        );

        if(isset($data['currency']))
		{
            $jsonData['currency'] = $data['currency'];
		}

        $defaultReturnUrl = $data['responseurl'];

        $jsonData = \Crypt::encrypt(json_encode($jsonData));

        $jsonDataLump = array('mmoneyObject' => $jsonData,
            'bankcode' => "PROBASE");
        $jsonEncode = json_encode($jsonDataLump);

        $base64 = base64_encode($jsonEncode);
        $dataForServer = array('mmoneyPaymentObject' => $base64);

        $result = handleSOAPCalls('initiateMMoneyPayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);
        $data = \Crypt::encrypt($input);


        //dd($result);
        if(isset($result->status) && $result->status == 1002)
        {

            $response['unique_reference'] = $result->txnRef;
            $response['transactionRef'] = $result->txnRef;
            $response["txn_ref"] = $result->txnRef;
            $response["txnRef"] = $result->txnRef;
            $response['channel'] = $result->channel;
            $response['rpin'] = $result->rPin;
            $response['student_number'] = $input['payerId'];
            $response['student_name'] = $input['payerName'];
            $response['student_id'] = $input['nationalId'];
            $response['term'] = $input['scope'];
            $response['orderId'] = $result->orderId;
            $response['status'] = "00";
            $response['description'] = $input['description'];
            $response['amount'] = number_format($total, 2, '.', '');
            $response['redirectUrl'] = $result->returnUrl;
            $response['amounttopay'] = $result->amounttopay;
            //dd($response);
            $amounttopay = $result->amounttopay;
            $payermobile = $result->payermobile;

            $msg = "Your Mobile Money Payment Ref No.:".$result->rPin."\nAmount To Pay:".$amounttopay."\nPay Using any of the Mobile Money channels - MTN(*225#). \nThank You";
            send_sms($payermobile, $msg);


            return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));

        }else
        {
            //dd($result);
            \Session::flash('error', (isset($result->message) ? $result->message : 'Error experienced. Please try again'));
            $payerName = $input['payerName'];
            return \Redirect::back()->with('error', (isset($result->message) ? $result->message : 'Error experienced. Please try again'));
        }
	}


    public function handleWalletPayment($input)
    {
        $data = \Crypt::encrypt($input);
        $response['data'] = $data;
        $response['orderId'] = $input['orderId'];
        //$response = $input;
        $response['redirectUrl'] = 'http://wallet.probasepay.com/data/receiver_listener';
        //dd($response);
        return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
    }

    public function handleRedirectToWalletPayment()
    {
        $input = \Input::all();
        $data = \Crypt::encrypt($input);
        $response['data'] = $data;
        $response['rand'] = str_random(5);
        $response['orderId'] = $input['orderId'];
        $response['redirectUrl'] = 'http://wallet.probasepay.com/data/receiver_listener';
        //dd($response);
        return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
    }

    public function processWebEaglePaymentGoToOTP()
    {


        $input = \Input::all();
        //dd(123);
        $tempHolder = \App\Models\TempHolder::where('id', '=', \Crypt::decrypt($input['tempHolder']))->first();
		$data = $tempHolder->temp_holder;
		//dd(\Crypt::decrypt($data));
		//$input = \Crypt::decrypt($data);
        //dd($input);
		$dataOrig = null;
		$dataOrig = $data;
		//dd(\Crypt::decrypt($input['data']));

        if(isset($input['cardnum']) && strlen($input['cardnum'])>0 &&
            isset($input['expdate']) && strlen($input['expdate'])>0 &&
            isset($input['cvv']) && strlen($input['cvv'])>0 &&
            isset($input['data']) && strlen($input['data'])>0) {
            //$data = \Crypt::decrypt($input['data']);
            $data = \Crypt::decrypt($data);
            //dd($data);
            $input = $input + $data;
            //dd($input);
            $paymentItems = $input['paymentItem'];
            $itemAmounts = $input['amount'];

            $total = 0;
            for ($i = 0; $i < sizeof($itemAmounts); $i++) {
                $total = $total + $itemAmounts[$i];
            }
            //dd($total);


			//dd($input);
            $jsonData = array('pan' => $input['cardnum'],
                'cvv' => $input['cvv'],
                'expiryDate' => $input['expdate'],
                'payeeFirstName' => $input['payerName'],
                'payeeEmail' => $input['payerEmail'],
                'payeeMobile' => $input['payerPhone'],
                'amount' => (number_format($total, 2, '.', '')),
                'responseUrl' => $input['responseurl'],
                'orderId' => $input['orderId'],
                'hash' => $input['hash'],
                'merchantId' => $input['merchantId'],
                'deviceCode' => $input['deviceCode'],
                'serviceTypeId' => $input['serviceTypeId'],
                'firstName' => $input['firstNameEagle'],
                'lastName' => $input['lastNameEagle'],
                'countryCode' => $input['countryCodeEagle'],
                'billPayeeMobile' => $input['phoneNumberEagle'],
                'email' => $input['emailEagle'],
                'streetAddress' => $input['streetAddressEagle'],
                'city' => $input['cityEagle'],
                'nationalId' => $input['nationalIdEagle'],
                'district' => isset($input['districtEagle']) && sizeof(explode('_', $input['districtEagle']))>1 ? explode('_', $input['districtEagle'])[1] : "");
			if(isset($input['customdata']))
			{
                $jsonData['customdata'] = serialize($input['customdata']);
			}

			if(isset($input['currency']))
			{
                $jsonData['currency'] = $input['currency'];
			}

            //dd($jsonData);
            $jsonData = \Crypt::encrypt(json_encode($jsonData));

            $jsonDataLump = array('txnDetail' => $jsonData,
                'bankcode' => substr($input['cardnum'], 4, 3));
            $jsonEncode = json_encode($jsonDataLump);
            //dd($jsonEncode);
            $base64 = base64_encode($jsonEncode);
            $dataForServer = array('transactionObject' => $base64, 'channel' => "CARD");


			//dd($input);
            $data = \Crypt::encrypt($input);
            //dd($total);


            $result = handleSOAPCalls('generateOTPForTransaction', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);

           // dd($result);

            if (isset($result->status) && $result->status == 900) {
                $input['txnRef'] = $result->txnRef;
                $input['token'] = $result->token;
                $otp = $result->otp;
                $otpRec = $input['payerPhone'];
                //dd($otpRec);

                $msg = "Transaction #" . $result->txnRef . " currently in progress. \nYour OTP to complete transaction is " . $otp . "\n\nThank You.";
                //dd($msg);
                send_sms($otpRec, $msg);

                $data = \Crypt::encrypt($input);
                $payerName = $input['payerName'];
				$key = OTP_COLLECTION_VIEW;
				$sessionContainer = [];
				if(\Session::has('error') || \Session::has('message'))
				{
					$sessionError = \Session::get('error');
					$sessionMessage = \Session::get('message');
					$sessionContainer['error'] = $sessionError;
					$sessionContainer['message'] = $sessionMessage;
				}
                //return view('guests.payment.web.eagle_card_payment_otp', compact('sessionContainer', 'data', 'paymentItems', 'itemAmounts', 'payerName'));

				$txnRef = $result->txnRef;
                $token = $result->token;
				$input1 = \Crypt::decrypt($dataOrig);
				$input1['cardnum'] = $input['cardnum'];
                $input1['cvv'] = $input['cvv'];
                $input1['expdate'] = $input['expdate'];
				//dd($input1);

				$input2['serviceTypeId'] = $input1['serviceTypeId'];
				$input2['orderId'] = $input1['orderId'];
				$input2['txnRef'] = $result->txnRef;
				$input2['hash'] = $input1['hash'];
				$input2['currency'] = $input1['currency'];
				$input2['responseurl'] = $input1['responseurl'];
				$input2['total'] = $total;
				//dd($input2);
				$input = \Crypt::encrypt($input2);

				//dd($input);
				$billData = new \App\Models\BillData();
    			$billData->data = $input;
    			$billData->save();
    			$billDataId = $billData->id;
    			$input = \Crypt::encrypt($billDataId);
    			//dd($billData);
				return view('secure.dashboard', compact('sessionContainer', 'key', 'input', 'txnRef', 'token', 'dataOrig', 'input1'));
            } else {
                //dd(\Crypt::decrypt($dataOrig));
                \Session::flash('error', (isset($result->message) ? $result->message : 'Error experienced. Please try again'));
                $payerName = $input['payerName'];
                //return view('guests.payment.web.eagle_card_payment', compact('data', 'paymentItems', 'itemAmounts', 'payerName'));
				$input = ($dataOrig);
				$key = CARD_COLLECTION_VIEW;
				$sessionContainer = [];
				if(\Session::has('error') || \Session::has('message'))
				{
					$sessionError = \Session::get('error');
					$sessionMessage = \Session::get('message');
					$sessionContainer['error'] = $sessionError;
					$sessionContainer['message'] = $sessionMessage;
				}
				//dd($tempHolder);
				//dd($input);
				$input = \Crypt::encrypt($tempHolder->id);
				return view('secure.dashboard', compact('sessionContainer', 'key', 'input'));
            }


            $data = \Crypt::encrypt($input);
        }else{
            $data = $input['data'];
            \Session::flash('error', 'Invalid card details provided. Provide Card Number, CVV, and Expiry Date');
            $input = (\Crypt::decrypt($input['data']));
            //dd($input);
            $payerName = $input['payerName'];
            $paymentItems = $input['paymentItem'];
            $itemAmounts = $input['amount'];

			$input = $data;
			$key = CARD_COLLECTION_VIEW;
			$sessionContainer = [];
			if(\Session::has('error') || \Session::has('message'))
			{
				$sessionError = \Session::get('error');
				$sessionMessage = \Session::get('message');
				$sessionContainer['error'] = $sessionError;
				$sessionContainer['message'] = $sessionMessage;
			}
			$input = ($input['tempHolder']);
    		//$input = \Crypt::decrypt($data);
			return view('secure.dashboard', compact('sessionContainer', 'key', 'input'));

            //return view('guests.payment.web.eagle_card_payment', compact('data', 'paymentItems', 'itemAmounts', 'payerName'));
        }
    }

    public function processWebEaglePaymentOTP()
    {
		$sessionContainer = [];
		if(\Session::has('error') || \Session::has('message'))
		{
			$sessionError = \Session::get('error');
			$sessionMessage = \Session::get('message');
			$sessionContainer['error'] = $sessionError;
			$sessionContainer['message'] = $sessionMessage;
		}
        $input = \Input::all();
		//dd($input);

        $data = \Crypt::decrypt($input['data']);
        //dd($data);
        /*$paymentItems = $data['paymentItem'];
        $itemAmounts = $data['amount'];

        $total = 0;
        for($i=0; $i<sizeof($itemAmounts); $i++)
        {
            $total = $total + $itemAmounts[$i];
        }

        /*$jsonData = array('pan' => $data['cardnum'],
            'cvv' => $data['cvv'],
            'expiryDate' => $data['expdate'],
            'payeeFirstName' => $data['payerName'],
            'payeeEmail' => $data['payerEmail'],
            'payeeMobile' => $data['payerPhone'],
            'amount' => (number_format($total, 2, '.', '')),
            'responseUrl' => $data['responseurl'],
            'orderId' => $data['orderId'],
            'hash' => $data['hash'],
            'merchantId' => $data['merchantId'],
            'serviceTypeId' => $data['serviceTypeId'],
            'billingPayeeFirstName' => $data['firstName'],
            'billingPayeeLastName' => $data['lastName'],
            'billPayeeMobile' => $data['phoneNumber'],
            'billingPayeeEmail' => $data['email'],
            'streetAddress' => $data['streetAddress'],
            'city' => $data['city'],
            'district' => intval($data['district']),
            'otp' => $input['otp'],
            'deviceCode' => $data['deviceCode'],
            'transactionRef' => $data['txnRef'],
        );*/
		$jsonData = array(
            'responseUrl' => $data['responseurl'],
            'orderId' => $data['orderId'],
            'hash' => $data['hash'],
            'serviceTypeId' => $data['serviceTypeId'],
            'otp' => $input['otp'],
            'transactionRef' => $data['txnRef'],
        );
        $defaultReturnUrl = $data['responseurl'];

        //dd($jsonData);


        $jsonData = \Crypt::encrypt(json_encode($jsonData));

        $jsonDataLump = array('crdobj' => $jsonData,
            'bankcode' => "PROBASE");
        $jsonEncode = json_encode($jsonDataLump);
        //dd($jsonEncode);
        $base64 = base64_encode($jsonEncode);
        $dataForServer = array('cardObject' => $base64,
            'token' => $data['token']);


        $data = \Crypt::encrypt($input);
        //dd($data);

        $result = handleSOAPCalls('processEagleCardWebPayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);

		//dd($result);

        $response = formatPaymentResponse('WEB', $result, $defaultReturnUrl);

        if(isset($response['autoReturnToMerchant']))
        {
            unset($response['autoReturnToMerchant']);
            unset($response['autoReturnToMerchant']);
        }

		$key = PAYMENT_ERROR_VIEW;
		//dd($response);
		if(!isset($response['redirectUrl']))
		{
		    $sessionContainer = [];
			if(\Session::has('error') || \Session::has('message'))
			{
				$sessionError = \Session::get('error');
				$sessionMessage = \Session::get('message');
				$sessionContainer['error'] = $sessionError;
				$sessionContainer['message'] = $sessionMessage;
			}

			$transactionRef = '';
			if(isset($response['transactionRef']))
			    $transactionRef = $response['transactionRef'];

		    return view('secure.dashboard', compact('sessionContainer', 'key', 'input', 'transactionRef'));
		}
		else
		{
            return view('guests.payment.web.eagle_card_payment_final_route', compact('data', 'response'));
		}
    }



	public function processWalletPaymentsOTP()
    {
		$sessionContainer = [];
		if(\Session::has('error') || \Session::has('message'))
		{
			$sessionError = \Session::get('error');
			$sessionMessage = \Session::get('message');
			$sessionContainer['error'] = $sessionError;
			$sessionContainer['message'] = $sessionMessage;
		}
        $input = \Input::all();
		//dd($input);

        $data = \Crypt::decrypt($input['data']);
        //dd($data);

		$jsonData = array(
            'responseUrl' => $data['responseurl'],
            'orderId' => $data['orderId'],
            'hash' => $data['hash'],
            'serviceTypeId' => $data['serviceTypeId'],
            'otp' => $input['otp'],
            //'amount' => (number_format($total, 2, '.', '')),
            //'merchantId' => $input['merchantId'],
            //'deviceCode' => $input['deviceCode'],
            'transactionRef' => $data['txnRef'],
        );
        $defaultReturnUrl = $data['responseurl'];

        //dd($jsonData);
        $jsonData = \Crypt::encrypt(json_encode($jsonData));

        $jsonDataLump = array('wallobj' => $jsonData);
        $jsonEncode = json_encode($jsonDataLump);
        //dd($jsonEncode);
        $base64 = base64_encode($jsonEncode);
        $dataForServer = array('walletObject' => $base64,
            'token' => $data['token']);


        $dataForServer = [];
        $dataForServer['merchantCode'] = $data['merchantCode'];
        $dataForServer['deviceCode'] = $data['deviceCode'];
        $dataForServer['orderId'] = $data['orderId'];
        $dataForServer['txnRef'] = $data['txnRef'];
        $dataForServer['otp'] = $input['otp'];
        $dataForServer['token'] = $data['token'];
        $dataForServer['walletObject'] = $base64;
        //$dataForServer['zicbAuthKey'] = $data['zicbAuthKey'];
        //dd($dataForServer);
        $data = \Crypt::encrypt($input);
        //dd($data);

        $result = handleSOAPCalls('validateSingleEWalletOTPPayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);

	    //dd($result);



        $defaultReturnUrl = isset($result->returnUrl) ? $result->returnUrl : null;
		//dd($defaultReturnUrl);
		if($defaultReturnUrl==null)
		{

		    $sessionContainer = [];
			$sessionError = 'Error experienced processing your payment';
			$sessionContainer['error'] = $sessionError;

			$billData = new \App\Models\BillData();
            $billData->data = json_encode($input);
            $billData->save();
            $input = $billData->id;
            $input = \Crypt::encrypt($input);
            $billId = \Session::get('billDataId');
            $billData = \App\Models\BillData::where('id', '=', $billId)->first();
            if($billData!=null && $billData->data!=null)
            {
                $input = json_decode($billData->data, TRUE);
                $key = PAYMENT_DETAILS_LISTING;
			    //BillData
			    return view('secure.dashboard', compact('sessionContainer', 'key', 'input'));
            }

		}

        $response = formatPaymentResponse('WEB', $result, $defaultReturnUrl);

        //dd($response);
        if(isset($response['autoReturnToMerchant']))
        {
            unset($response['autoReturnToMerchant']);
            unset($response['autoReturnToMerchant']);
        }
        if($result->status==-1)
		{
		    return view('guests.payment.web.eagle_card_payment_final_route', compact('data', 'response'));
		}

		$key = PAYMENT_ERROR_VIEW;
		//dd($response);
		if(!isset($response['redirectUrl']))
		{
		    $sessionContainer = [];
			if(\Session::has('error') || \Session::has('message'))
			{
				$sessionError = \Session::get('error');
				$sessionMessage = \Session::get('message');
				$sessionContainer['error'] = $sessionError;
				$sessionContainer['message'] = $sessionMessage;
			}

			$transactionRef = '';
			if(isset($response['transactionRef']))
			    $transactionRef = $response['transactionRef'];

		    return view('secure.dashboard', compact('sessionContainer', 'key', 'input', 'transactionRef'));
		}
		else
		{
            return view('guests.payment.web.eagle_card_payment_final_route', compact('data', 'response'));
		}
    }



    public function processWebWalletPaymentOTP()
    {
		$sessionContainer = [];
		if(\Session::has('error') || \Session::has('message'))
		{
			$sessionError = \Session::get('error');
			$sessionMessage = \Session::get('message');
			$sessionContainer['error'] = $sessionError;
			$sessionContainer['message'] = $sessionMessage;
		}
        $input = \Input::all();
		//dd($input);

        $data = \Crypt::decrypt($input['data']);
        //dd($data);

		$jsonData = array(
            'responseUrl' => $data['responseurl'],
            'orderId' => $data['orderId'],
            'hash' => $data['hash'],
            'serviceTypeId' => $data['serviceTypeId'],
            'otp' => $input['otp'],
            'transactionRef' => $data['txnRef'],
        );
        $defaultReturnUrl = $data['responseurl'];

        //dd($jsonData);


        $jsonData = \Crypt::encrypt(json_encode($jsonData));

        $jsonDataLump = array('walletobj' => $jsonData);
        $jsonEncode = json_encode($jsonDataLump);
        //dd($jsonEncode);
        $base64 = base64_encode($jsonEncode);
        $dataForServer = array('walletObject' => $base64,
            'token' => $data['token']);


        $dataForServer = [];
        $dataForServer['merchantCode'] = $data['merchantCode'];
        $dataForServer['deviceCode'] = $data['deviceCode'];
        $dataForServer['orderId'] = $data['orderId'];
        $dataForServer['txnRef'] = $data['txnRef'];
        $dataForServer['otp'] = $input['otp'];
        $dataForServer['token'] = $data['token'];
        //dd($dataForServer);
        $data = \Crypt::encrypt($input);
        //dd($data);

        $result = handleSOAPCalls('validateEWalletOTPPayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);

		//dd($result);

        $response = formatPaymentResponse('WEB', $result, $defaultReturnUrl);

        if(isset($response['autoReturnToMerchant']))
        {
            unset($response['autoReturnToMerchant']);
            unset($response['autoReturnToMerchant']);
        }

		$key = PAYMENT_ERROR_VIEW;
		//dd($response);
		if(!isset($response['redirectUrl']))
		{
		    $sessionContainer = [];
			if(\Session::has('error') || \Session::has('message'))
			{
				$sessionError = \Session::get('error');
				$sessionMessage = \Session::get('message');
				$sessionContainer['error'] = $sessionError;
				$sessionContainer['message'] = $sessionMessage;
			}

			$transactionRef = '';
			if(isset($response['transactionRef']))
			    $transactionRef = $response['transactionRef'];

		    return view('secure.dashboard', compact('sessionContainer', 'key', 'input', 'transactionRef'));
		}
		else
		{
            return view('guests.payment.web.eagle_card_payment_final_route', compact('data', 'response'));
		}
    }



	public function processUBAPaymentResponse()
    {
		$sessionContainer = [];
		if(\Session::has('error') || \Session::has('message'))
		{
			$sessionError = \Session::get('error');
			$sessionMessage = \Session::get('message');
			$sessionContainer['error'] = $sessionError;
			$sessionContainer['message'] = $sessionMessage;
		}
        $input = \Input::all();
		dd($input);
		$bnk = $input['bnk'];
		$refNo = $input['refNo'];
		$transactionId = $input['transactionId'];
		//$status = $input['status'];

        //$data = \Crypt::decrypt($input['data']);

		$jsonData = array(
            'refNo' => $refNo,
            'transactionId' => $transactionId,
            /*'status' => $status*/
        );

        //dd($jsonData);


        $jsonData = \Crypt::encrypt(json_encode($jsonData));

        //$jsonDataLump = array('finishUBAPaymentResponse' => $jsonData,
        //    'bankcode' => "PROBASE");
        //$jsonEncode = json_encode($jsonData);
        //dd($jsonEncode);
        //$base64 = base64_encode($jsonEncode);
        $dataForServer = array('responseData' => $jsonData);


        $data = \Crypt::encrypt($input);
        //dd($dataForServer);

        $result = handleSOAPCalls('finishUBAPaymentResponse', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);

        //dd($result);
        $defaultReturnUrl = isset($result->returnUrl) ? $result->returnUrl : null;
		//dd($defaultReturnUrl);
		if($defaultReturnUrl==null)
		{

		    $sessionContainer = [];
			$sessionError = 'Error experienced processing your payment';
			$sessionContainer['error'] = $sessionError;

			$billData = new \App\Models\BillData();
            $billData->data = json_encode($input);
            $billData->save();
            $input = $billData->id;
            $input = \Crypt::encrypt($input);
            $billId = \Session::get('billDataId');
            $billData = \App\Models\BillData::where('id', '=', $billId)->first();
            if($billData!=null && $billData->data!=null)
            {
                $input = json_decode($billData->data, TRUE);
                $key = PAYMENT_DETAILS_LISTING;
			    //BillData
			    return view('secure.dashboard', compact('sessionContainer', 'key', 'input'));
            }

		}

        $response = formatPaymentResponse('WEB', $result, $defaultReturnUrl);

        //dd($response);
        if(isset($response['autoReturnToMerchant']))
        {
            unset($response['autoReturnToMerchant']);
            unset($response['autoReturnToMerchant']);
        }

		$key = PAYMENT_ERROR_VIEW;
		//dd($response);
		if(!isset($response['redirectUrl']))
		{
		    $sessionContainer = [];
			if(\Session::has('error') || \Session::has('message'))
			{
				$sessionError = \Session::get('error');
				$sessionMessage = \Session::get('message');
				$sessionContainer['error'] = $sessionError;
				$sessionContainer['message'] = $sessionMessage;
			}

			$transactionRef = '';
			if(isset($response['transactionRef']))
			    $transactionRef = $response['transactionRef'];

		    return view('secure.dashboard', compact('sessionContainer', 'key', 'input', 'transactionRef'));
		}
		else
		{
            return view('guests.payment.web.eagle_card_payment_final_route', compact('data', 'response'));
		}
    }



	public function processMobileEaglePaymentGoToOTP()
    {
        $input = \Input::all();
		//dd($input);

        if(isset($input['cardnum']) && strlen($input['cardnum'])>0 &&
            isset($input['expdate']) && strlen($input['expdate'])>0 &&
            isset($input['cvv']) && strlen($input['cvv'])>0) {
            $paymentItems = $input['paymentItem'];
            $itemAmounts = json_decode($input['amount']);

            $total = 0;
            for ($i = 0; $i < sizeof($itemAmounts); $i++) {
                $total = $total + $itemAmounts[$i];
            }


            $jsonData = array('pan' => $input['cardnum'],
                'cvv' => $input['cvv'],
                'expiryDate' => $input['expdate'],
                'payeeFirstName' => $input['payerName'],
                'payeeEmail' => $input['payerEmail'],
                'payeeMobile' => $input['payerPhone'],
                'amount' => (number_format($total, 2, '.', '')),
                'responseUrl' => $input['responseurl'],
                'orderId' => $input['orderId'],
                'hash' => $input['hash'],
                'merchantId' => $input['merchantId'],
                'deviceCode' => $input['deviceCode'],
                'serviceTypeId' => $input['serviceTypeId'],
                'paymentMethod' => 'EagleCard');
			if(isset($input['customdata']))
			{
                $jsonData['customdata'] = serialize($input['customdata']);
			}


            $jsonData = \Crypt::encrypt(json_encode($jsonData));

            $jsonDataLump = array('txnDetail' => $jsonData,
                'bankcode' => substr($input['cardnum'], 4, 3));
            $jsonEncode = json_encode($jsonDataLump);
            //dd($jsonEncode);
            $base64 = base64_encode($jsonEncode);
            $dataForServer = array('transactionObject' => $base64, 'channel' => "CARD");

            $result = handleSOAPCalls('generateOTPForTransaction', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);


            if (isset($result->status) && $result->status == 900) {
				$accts['status'] = 1;
				$accts['message'] = $result->message;
                $accts['txnRef'] = $result->txnRef;
                $accts['token'] = $result->token;
                $accts['otp'] = $result->otp;
                $otp = $result->otp;
                $otpRec = $result->otpRec;

                $msg = "Transaction #" . $result->txnRef . " currently in progress. \nYour OTP to complete transaction is " . $otp . "\n\nThank You.";
                //send_sms($otpRec, $msg);


                return response()->json($accts);
            } else {
                //dd($result);
				$accts['status'] = 0;
				$accts['message'] = $result->status."".$result->message;
                return response()->json($accts);
            }
        }else{
			$accts['status'] = 2;
			$accts['message'] = 'Incomplete input parameters provided';
            return response()->json($accts);
        }
    }




	public function processMobileEaglePaymentProcessPayment()
    {

        $data = \Input::all();
        $paymentItems = $data['paymentItem'];
        $itemAmounts = json_decode($data['amount']);



        $total = 0;
        for($i=0; $i<sizeof($itemAmounts); $i++)
        {
            $total = $total + $itemAmounts[$i];
        }

        $jsonData = array('pan' => $data['cardnum'],
            'cvv' => $data['cvv'],
            'expiryDate' => $data['expdate'],
            'payeeFirstName' => $data['payerName'],
            'payeeEmail' => $data['payerEmail'],
            'payeeMobile' => $data['payerPhone'],
            'amount' => (number_format($total, 2, '.', '')),
            'responseUrl' => $data['responseurl'],
            'orderId' => $data['orderId'],
            'hash' => $data['hash'],
            'merchantId' => $data['merchantId'],
            'serviceTypeId' => $data['serviceTypeId'],
            'billingPayeeFirstName' => $data['firstName'],
            'billingPayeeLastName' => $data['lastName'],
            'billPayeeMobile' => $data['phoneNumber'],
            'billingPayeeEmail' => $data['email'],
            'streetAddress' => $data['streetAddress'],
            'city' => $data['city'],
            'district' => intval($data['district']),
            'otp' => $data['otp'],
            'deviceCode' => $data['deviceCode'],
            'transactionRef' => $data['txnRef'],
        );
        $defaultReturnUrl = $data['responseurl'];

        //dd($jsonData);


        $jsonData = \Crypt::encrypt(json_encode($jsonData));

        $jsonDataLump = array('crdobj' => $jsonData,
            //'bankcode' => "PROBASE");
			'bankcode' => substr($data['cardnum'], 4, 3) );
			//00260350010010116799006

        $jsonEncode = json_encode($jsonDataLump);
        //dd($jsonEncode);
        $base64 = base64_encode($jsonEncode);
        $dataForServer = array('cardObject' => $base64,
            'token' => $data['token']);

			//return $dataForServer;

        //$data = \Crypt::encrypt($data);

        $result = handleSOAPCalls('processEagleCardWebPayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);



		if (isset($result->status) && $result->status == "00") {
			$accts['status'] = 1;
			$accts['message'] = $result->message;
			$accts['txnRef'] = $result->txnRef;
			//$accts['token'] = $result->token;
			$accts['orderId'] = $result->orderId;
			$accts['amount'] = $result->amount;
			$accts['customerMobileContact'] = $result->customerMobileContact;

			$msg = "Transaction #" . $result->txnRef . " for the sum of ZMW".number_format($result->amount, 2, '.', ',')." was successful\n\nThank You.";
			//send_sms($otpRec, $msg);


			return response()->json($accts);
		} else {
			//dd($result);
			$accts['status'] = 0;
			$accts['message'] = $result->status."".$result->message;
			return response()->json($accts);
		}
    }



	public function processMobileProbasePayWalletPaymentGoToOTP()
    {
        $input = \Input::all();

        if(isset($input['wallettoken']) && strlen($input['wallettoken'])>0) {
            $paymentItems = $input['paymentItem'];
            $itemAmounts = json_decode($input['amount']);
			$txnToken = $input['txnToken'];

            $total = 0;
            for ($i = 0; $i < sizeof($itemAmounts); $i++) {
                $total = $total + $itemAmounts[$i];
            }


            $jsonData = array('payFrom' => $input['wallettoken'],
                'billingPayeeFirstName' => $input['payerFirstName'],
				'billingPayeeLastName' => $input['payerLastName'],
                'billingPayeeEmail' => $input['payerEmail'],
                'billPayeeMobile' => $input['payerPhone'],
                'streetAddress' => $input['payerStreetAddress'],
                'city' => $input['payerCity'],
                'district' => $input['payerDistrict'],
                'amount' => (number_format($total, 2, '.', '')),
                'responseUrl' => $input['responseurl'],
                'orderId' => $input['orderId'],
                'hash' => $input['hash'],
                'merchantId' => $input['merchantId'],
                'deviceCode' => $input['deviceCode'],
                'serviceTypeId' => $input['serviceTypeId'],
                'paymentMethod' => 'ProbasePay Wallet');
			if(isset($input['customdata']))
			{
                $jsonData['customdata'] = serialize($input['customdata']);
			}



            $jsonData = \Crypt::encrypt(json_encode($jsonData));

            $jsonDataLump = array('wallobj' => $jsonData);
            $jsonEncode = json_encode($jsonDataLump);
            //dd($jsonEncode);
            $base64 = base64_encode($jsonEncode);
            $dataForServer = array('walletObject' => $base64, 'token'=>$txnToken);
			/*'eyJhbGciOiJIUzI1NiJ9.eyJqdGkiOiJId09rWFFWcGN5IiwiaWF0IjoxNTA5OTUyNzkzLCJzdWIiOiJ7XCJpZFwiOjQsXCJmYWlsZWRMb2dpbkNvdW50XCI6MCxcImxvY2tPdXRcIjpmYWxzZSxcInBhc3N3b3JkXCI6XCJwYXNzd29yZFwiLFwidXNlcm5hbWVcIjpcImN1c3RvbWVyMUBnbWFpbC5jb21cIixcIndlYkFjdGl2YXRpb25Db2RlXCI6XCIzSVdpUDBEb2dvUGhIM1dpYXpCNUpRa1BvYkozRWpyWlwiLFwibW9iaWxlQWN0aXZhdGlvbkNvZGVcIjpcIjNTNncyUlwiLFwic3RhdHVzXCI6XCJBQ1RJVkVcIixcInJvbGVUeXBlXCI6XCJDVVNUT01FUlwiLFwiY3JlYXRlZF9hdFwiOlwiU2VwIDIzLCAyMDE2IDQ6MDE6NTQgQU1cIixcInVwZGF0ZWRfYXRcIjpcIkF1ZyAxMSwgMjAxNyA0OjQxOjE4IEFNXCIsXCJmaXJzdE5hbWVcIjpcIkphbWVzXCIsXCJsYXN0TmFtZVwiOlwiUGF1bFwiLFwib3RoZXJOYW1lXCI6XCJQaGlsaXBcIixcIm1vYmlsZU5vXCI6XCIyNjA5NjQ0NzY5MTRcIixcIm90cFwiOlwiMTE3OFwifSIsImlzcyI6IlBST0JBU0VXQUxMRVQiLCJhdWQiOiIyMDM0IiwiZXhwIjoxNTA5OTU2MzkzfQ.d965keVHZBs6W7oAvGSnn-BbobXr5d2Lo42v04J4jGA'*/


            $result = handleSOAPCalls('processEWalletPaymentGenerateOTP', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);



            if (isset($result->status) && $result->status == 1002) {
				$accts['status'] = 1;
				$accts['message'] = $result->message;
                $accts['txnRef'] = $result->txnRef;
                $accts['otp'] = $result->otp;
				$accts['token'] = $result->token;

                $otp = $result->otp;
                $otpRec = $result->primaryAccountMobile;

                $msg = "Transaction #" . $result->txnRef . " currently in progress. \nYour OTP to complete transaction is " . $otp . "\n\nThank You.";
                //send_sms($otpRec, $msg);

				//return response()->json(['status'=>1, 'message'=>$result->message, 'txnRef'=>$result->txnRef, 'otp'=>$result->otp, 'token'=>$result->token]);
                return (response()->json($accts));
            } else {
                //dd($result);
				$accts['status'] = 0;
				if(isset($result->message))
					$accts['message'] = (isset($result->status) ? $result->status : "-1")."".$result->message;
				else
					$accts['message'] = 'We experienced issues debiting your ProbasePay wallet. Please try again';

                return response()->json($accts);
            }
        }else{
			$accts['status'] = 2;
			$accts['message'] = 'Incomplete input parameters provided';
            return response()->json($accts);
        }
    }




	public function processMobileProbasePayWalletPaymentProcessPayment()
    {

        $data = \Input::all();
        $paymentItems = $data['paymentItem'];
        $itemAmounts = $data['amount'];
		$txnToken = $data['txnToken'];

        $total = 0;
        for($i=0; $i<sizeof($itemAmounts); $i++)
        {
            $total = $total + $itemAmounts[$i];
        }

        $dataForServer = array(
            'merchantCode' => $data['merchantId'],
            'deviceCode' => $data['deviceCode'],
            'orderId' => $data['orderId'],
            'txnRef' => $data['txnRef'],
            'otp' => $data['otp'],
			'token' => $txnToken
        );


        $result = handleSOAPCalls('validateEWalletOTPPayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);

		if (isset($result->status) && $result->status == "00") {
			$accts['status'] = 1;
			$accts['message'] = $result->message;
			$accts['txnRef'] = $result->transactionRefs;
			$accts['orderId'] = $result->orderRef;
			$accts['amount'] = $result->totalamountdebited;
			$accts['customerMobileContact'] = $result->walletMobile;
			$otpRec = $result->walletMobile;

			$msg = "Transaction #" . $result->transactionRefs . " for the sum of ZMW".number_format($result->totalamountdebited, 2, '.', ',')." was successful\n\nThank You.";
			//send_sms($otpRec, $msg);


			return response()->json($accts);
		} else {
			//dd($result);
			$accts['status'] = 0;
			$accts['message'] = isset($result->message) ? $result->message : 'Error experienced debiting wallet. Please try again';
			return response()->json($accts);
		}
    }


	public function creditMobileEagleCardCloseLoopOption()
	{

	}



	public function processMobileEaglePaymentProcessPaymentNoOTP()
    {

        $input = \Input::all();

        if(isset($input['cardnum']) && strlen($input['cardnum'])>0 &&
            isset($input['expdate']) && strlen($input['expdate'])>0 &&
            isset($input['cvv']) && strlen($input['cvv'])>0) {
            $paymentItems = json_decode($input['paymentItem']);
            $itemAmounts = json_decode($input['amount']);

            $total = 0;
            for ($i = 0; $i < sizeof($itemAmounts); $i++) {
                $total = $total + $itemAmounts[$i];
            }


            $names = explode(' ', $input['payerName']);
            $jsonData = array('pan' => $input['cardnum'],
                'cvv' => $input['cvv'],
                'expiryDate' => $input['expdate'],
                'payeeFirstName' => sizeof($names)>0 ? $names[0] : "",
                'payeeLastName' => sizeof($names)>1 ? $names[1] : "",
                'payeeEmail' => $input['payerEmail'],
                'payeeMobile' => $input['payerPhone'],
                'amount' => (number_format($total, 2, '.', '')),
                'responseUrl' => $input['responseurl'],
                'orderId' => $input['orderId'],
                'hash' => $input['hash'],
                'merchantId' => $input['merchantId'],
                'deviceCode' => $input['deviceCode'],
                'currency' => $input['currency'],
                'serviceTypeId' => $input['serviceTypeId']);
			if(isset($input['customdata']))
			{
                $jsonData['customdata'] = serialize($input['customdata']);
			}


            $jsonData = \Crypt::encrypt(json_encode($jsonData));

            $jsonDataLump = array('txnDetail' => $jsonData,
                'bankcode' => substr($input['cardnum'], 4, 3));
            $jsonEncode = json_encode($jsonDataLump);
            //dd($jsonEncode);
            $base64 = base64_encode($jsonEncode);
            $dataForServer = array('transactionObject' => $base64);

            $result = handleSOAPCalls('processClosedLoopPaymentAuthorizeNoOTP', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);


            if (isset($result->status) && $result->status == 900) {
				$accts['status'] = 1;
				$accts['message'] = $result->message;
                $accts['txnRef'] = $result->txnRef;
                //$otp = $result->otp;
                //$otpRec = $result->otpRec;

                $msg = "Transaction #" . $result->txnRef . " was successful.\n\nThank You.";
                //send_sms($otpRec, $msg);


                return response()->json($accts);
            } else if (isset($result->status) && $result->status == "00"){
                //dd($result);
				$accts['status'] = 0;
				$accts['message'] = $result->message;
                $accts['txnRef'] = $result->txnRef;
                return response()->json($accts);
            } else {
                //dd($result);
				$accts['status'] = $result->status;
				$accts['message'] = $result->message;
                return response()->json($accts);
            }
        }else{
			$accts['status'] = 2;
			$accts['message'] = 'Incomplete input parameters provided '.json_encode($input);
            return response()->json($accts);
        }
    }


    public function handleTestGuzzle()
    {
        $client = new \GuzzleHttp\Client();
        $response['redirectUrl'] = 'http://shikola.com/payments/receipt';
        $client->post(
            $response['redirectUrl'],
            array(
                'body' => $response
            )
        );

        //dd($response->getBody());
    }



    public function getEWalletPaymentsListing()
    {
        $data['token'] = \Auth::user()->token;
        $data['channel'] = 'wallet';
        $data['status'] = 'SUCCESS';

        $result = handleSOAPCalls('getUserTransactionsByChannel', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/TransactionServices?wsdl', $data);

        //dd($result);

        if(handleTokenUpdate($result)==false)
        {
            return \Redirect::to('/auth/login')->with('message', 'Session Ended. Login Again');
        }

        if($result->status == 0)
        {
            $transactionList = json_decode($result->transactionList);
            return view('probasewallet.authenticated.payments', compact('data', 'response', 'transactionList'));
        }else
        {
            return \Redirect::back()->with('error', 'Technical Issues Experienced While Retrieving Transaction Listing. Please try again!');
        }
    }




    public function getPayRoutedBill($data)
    {
        $data_ = $data;


        $data1 = NULL;
        $d1 = \App\Models\LoginData::where('order_id', '=', $data);

        if($d1->count()>0)
        {
            $d2 = $d1->first();
            $input['data'] = \Crypt::decrypt($d2->data);

            $d2->delete();
            $data1 = $input['data'];
        }else{
            //dd(11);
            return \Redirect::to('/wallet/dashboard')->with('error', 'Payment has been canceled. Avoid Refreshing your payment page.
            To continue payment, go back to your merchant website.');
        }

        //dd($data1);
        /*if($data1!=NULL && is_array($data1) && in_array('data', array_keys($data1)))
            $data1 = \Crypt::decrypt($data1['data']);*/

        $dataToServer['token'] = \Auth::user()->token;
        $dataToServer['merchantCode'] = $data1['merchantId'];
        $dataToServer['deviceCode'] = $data1['deviceCode'];
        $result = handleSOAPCalls('getUserAccountBalances', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/WalletServices?wsdl', $dataToServer);

        //dd($result);
        if(handleTokenUpdate($result)==false)
        {
            return \Redirect::to('/auth/login/'.$data_)->with('message', 'Session Ended. Relogin');
        }

        if($result->status == 0 && $result->device!=null && $result->merchant!=null && $result->balance!=null && $result->balanceList!=null)
        {
            $balanceList = json_decode($result->balanceList);
            $merchant = json_decode($result->merchant);
            $device = json_decode($result->device);
            $balance = $result->balance;

            $paymentAmounts = $data1['amount'];
            $paymentItems = $data1['paymentItem'];
            $totalAmount = 0.0;
            for($f=0; $f<sizeof($paymentAmounts); $f++)
            {
                $totalAmount = $totalAmount + $paymentAmounts[$f];
            }
            $orderId = $data1['orderId'];
            $deviceCode = $data1['deviceCode'];
            $serviceTypeId = $data1['serviceTypeId'];
            $responseurl = $data1['responseurl'];
            $api_key = $merchant->apiKey;

            $hash = $data1['hash'];
            $toHash = $merchant->merchantCode.$deviceCode.$serviceTypeId.$orderId.number_format($totalAmount, 2, '.', '').$responseurl.$api_key;
            $toHash2 = $merchant->merchantCode."-".$deviceCode."-".$serviceTypeId."-".$orderId."-".number_format($totalAmount, 2, '.', '')."-".$responseurl."-".$api_key;
            $confirmHash = hash('sha512', $toHash);
            //dd($toHash2);


            if($hash==$confirmHash) {
                if (\Auth::user()) {
$data = \Crypt::encrypt($input['data']);
                    return view('probasewallet.authenticated.pay_customer_bill', compact('paymentAmounts',
                        'paymentItems', 'balanceList', 'balance', 'data1', 'merchant', 'orderId', 'data'));
                } else {
                    return \Redirect::to('/auth/login/' . ($data));
                }
            }else
            {
                $response['hash'] = $hash;
                $response['toHash'] = $toHash2;
                $response['confirmHash'] = $confirmHash;
                $response["statusmessage"] = "Invalid Hash";
                $response["reason"] = "Hash Is Invalid";
                $response["merchantId"] = $merchant->merchantCode;
                $response["deviceCode"] = $device->deviceCode;
                $response["status"] = '05';
                $response["orderId"] = $orderId;
                $response["redirectUrl"] = $device->failureUrl;
                return view('probasewallet.authenticated.post_final_route', compact('response'));
            }
        }else
        {
            return \Redirect::back()->with('error', 'Technical Issues Experienced While Retrieving Transaction. Please try again!');
        }
    }


    public function postPayBill()
    {
        $input = \Input::all();

        $data = \Crypt::decrypt($input['data']);
        if(is_array($data) && in_array('data', array_keys($data)))
            $data = \Crypt::decrypt($data['data']);

        $payFrom = "";
        //dd($data);

        $paymentItems = $data['paymentItem'];
        $itemAmounts = $data['amount'];

        $total = 0;
        for($i=0; $i<sizeof($itemAmounts); $i++)
        {
            $total = $total + $itemAmounts[$i];
        }


        for($i=0; $i<sizeof($input['pay_from']); $i++)
        {
            $payFrom = $payFrom."".str_replace('|||', '---', $input['pay_from'][$i]).":::";
        }

        $jsonData = array('payFrom' => $payFrom,
            'payeeFirstName' => $data['payerName'],
            'payeeEmail' => $data['payerEmail'],
            'payeeMobile' => $data['payerPhone'],
            'amount' => (number_format($total, 2, '.', '')),
            'responseUrl' => $data['responseurl'],
            'orderId' => $data['orderId'],
            'hash' => $data['hash'],
            'merchantId' => $data['merchantId'],
            'serviceTypeId' => $data['serviceTypeId'],
            //'billingPayeeFirstName' => $data['firstName'],
            //'billingPayeeLastName' => $data['lastName'],
            //'billPayeeMobile' => $data['phoneNumber'],
            //'billingPayeeEmail' => $data['email'],
            //'streetAddress' => $data['streetAddress'],
            //'city' => $data['city'],
            //'district' => intval($data['district']),
            'deviceCode' => $data['deviceCode'],
        );
        $defaultReturnUrl = $data['responseurl'];

        $merchantId = $data['merchantId'];
        $deviceCode = $data['deviceCode'];
        //dd($jsonData);


        $jsonData = \Crypt::encrypt(json_encode($jsonData));

        $jsonDataLump = array('wallobj' => $jsonData,
            'bankcode' => "PROBASE");
        $jsonEncode = json_encode($jsonDataLump);
        //dd($jsonEncode);
        $base64 = base64_encode($jsonEncode);
        $dataForServer = array('walletObject' => $base64,
            'token' => \Auth::user()->token);


        $data = \Crypt::encrypt($input);
        //dd($dataForServer);
        $result = handleSOAPCalls('processEWalletPaymentGenerateOTP', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);


        if($result->status == 1002) {
            $txnRef = json_decode($result->txnRef);
            $ref = "";
            foreach($txnRef as $tnref => $value)
            {
                $ref = $value.", ";
            }
            $data = array();
            $data['payFrom'] = $result->payFrom;
            $data['balance'] = $result->balance;
            $data['orderId'] = $result->orderId;
            $data['txnRef'] = $txnRef;
            $data['paymentItems'] = $paymentItems;
            $data['itemAmounts'] = $itemAmounts;
            $data['merchantId'] = $merchantId;
            $data['deviceCode'] = $deviceCode;

            $otp = $result->otp;
            $primaryMobile = $result->primaryAccountMobile;
            $msg = "To complete transaction Ref Nos. ".substr($ref, 0, (strlen($ref) - 2))." \nYour OTP is ".$otp."\n\nThank You.";
            send_sms($primaryMobile, $msg, 'ProbWallet');

            return \Redirect::to('/wallet/pay/customer/go-to-otp/'.\Crypt::encrypt($data));
        }else
        {
            return \Redirect::back()->with('error', isset($result->message) ? $result->message : "Errors initializing payment");
        }
    }

    public function getGoToOTP($data1)
    {
        $data = \Crypt::decrypt($data1);
        $balance = $data['balance'];
        $txnRef = ($data['txnRef']);
        $paymentItems = $data['paymentItems'];
        $paymentAmounts = $data['itemAmounts'];
        $payFrom = $data['payFrom'];
        $orderId = $data['orderId'];
        $merchantId = $data['merchantId'];
        $deviceCode = $data['deviceCode'];
        return view('probasewallet.authenticated.get_otp', compact('merchantId', 'deviceCode', 'data1', 'orderId', 'balance', 'txnRef', 'paymentItems', 'paymentAmounts', 'payFrom'));
    }


    public function getPayCustomerGoToOTP($data1)
    {
        $data = \Crypt::decrypt($data1);
        $balance = $data['balance'];
        $txnRef = $data['debitTxnRef'];
        $creditTxnRef = $data['creditTxnRef'];
        $payFrom = $data['payFrom'];
        return view('probasewallet.authenticated.get_new_pay_otp', compact('data1', 'balance', 'txnRef', 'payFrom'));
    }


    public function postSendOTP()
    {
        $input = \Input::all();
        $data =\Crypt::decrypt($input['data']);
        //dd($data);

        $txnRefStr = "";
        foreach($data['txnRef'] as $key => $value)
        {
            //$txnRefStr = $txnRefStr."".$value.":::";
            $txnRefStr = $txnRefStr."".$key.":::";
        }
        $jsonData = array('orderId' => $data['orderId'],
            'txnRef' => $txnRefStr,
            'otp' => $input['otp'],
            'token' => \Auth::user()->token,
            'merchantCode' => $data['merchantId'],
            'deviceCode' => $data['deviceCode']
        );

        //dd($jsonData);


        $result = handleSOAPCalls('validateEWalletOTPPayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $jsonData);
        //dd($result);

        if(isset($result->status) && $result->status == "00")
        {
            $device = json_decode($result->device);
            $response["statusmessage"] = "Payment Transaction Was Successful";
            $response["reason"] = "Payment Transaction Successful";
            $response["merchantId"] = $data['merchantId'];
            $response["deviceCode"] = $data['deviceCode'];
            $response["status"] = '00';
            //$response["transactionRefs"] = substr($result->transactionRefs, 0, (strlen($result->transactionRefs)-3));
            $response["transactionRefs"] = $result->transactionRefs;
            $response["orderId"] = $result->orderRef;
            $response["channels"] = isset($result->channels) && $result->channels!=null ? $result->channels : 'N/A';
            $response["redirectUrl"] = $device->successUrl;

            //dd($response);

            $walletMobile = $result->walletMobile;
            $totalamountdebited = $result->totalamountdebited;
            $orderRef = $result->orderRef;
            $transactionRefs = $result->transactionRefs;

            $msg = "ProbaseWallet Payment successful! \nOrder Id: #".$orderRef."\nTxn Ref: #".$transactionRefs."\nAmount Debited: #".$totalamountdebited."\n\nThank You.";
            send_sms($walletMobile, $msg, 'ProbWallet');


            return view('probasewallet.authenticated.post_final_route', compact('response'));
        }else{
            $device = json_decode($result->device);
            $response["statusmessage"] = "Payment Transaction Was Not Successful";
            $response["reason"] = $result->message;
            $response["merchantId"] = $data['merchantId'];
            $response["deviceCode"] = $data['deviceCode'];
            $response["status"] = isset($result->status) ? $result->status : '99';
            $response["transactionRefs"] = substr($result->transactionRefs, 0, (strlen($result->transactionRefs)-3));
            $response["orderId"] = $result->orderRef;
            $response["redirectUrl"] = $device->successUrl;
            return view('probasewallet.authenticated.post_final_route', compact('response'));
        }
    }


    public function postSendWalletPayment()
    {
        $input = \Input::all();
        //dd($input);
        if(strpos($input['walletcode_account'], "-")>0) {
            $walletCode = explode('-', $input['walletcode_account']);
            $dataForServer['recWalletcode'] = \Crypt::encrypt($walletCode[0]);
            $dataForServer['recAccountIdentifier'] = \Crypt::encrypt($walletCode[1]);
            $dataForServer['amount'] = $input['amount'];
            $dataForServer['detail'] = $input['payinfo'];
            $dataForServer['accesscodeS'] = \Crypt::encrypt(intval($input['accesscode']));
            $dataForServer['accountIdS'] = \Crypt::encrypt(explode('---', $input['pay_from'])[0]);
            $dataForServer['token'] = \Auth::user()->token;
            $dataForServer['currency'] = "ZMW";

            $result = handleSOAPCalls('processGenerateOTPForCustomerPayOut', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);
            //dd($result);

            if(handleTokenUpdate($result)==false)
            {
                return \Redirect::to('/auth/login')->with('error', 'Login session expired. Please relogin again');
            }


            if ($result->status == 1002) {
                //$txnRef = json_decode($result->txnRef);
                $data = array();
                $data['debitTxnRef'] = $result->debitTxnRef;
                $data['creditTxnRef'] = $result->creditTxnRef;
                $data['balance'] = $result->balance;
                $data['payFrom'] = $input['pay_from'];

                $otpRec = $result->otpReceipient;
                $debitTxnRef = $result->debitTxnRef;
                $otp = $result->otp;
                $msg = "Transaction #".$debitTxnRef." currently in progress. \nYour OTP to complete the transaction is ".$otp."\n\nThank You.";
                send_sms($otpRec, $msg);

                return \Redirect::to('/wallet/pay/customer/pay_customer/go-to-otp/' . \Crypt::encrypt($data))->with('message', 'A One-Time Password Has been sent to your mobile phone. Enter this OTP to complete this transfer');
            } else {
                return \Redirect::back()->with('error', isset($result->message) ? $result->message : "Errors initializing payment");
            }
        }else{
            return \Redirect::back()->with('error', "Invalid Wallet Account Code Provided. Receipient Wallet Account Code must be in the format -
            WALLET CODE-WALLET ACCOUNT NUMBER");
        }
    }






    public function postPayCustomerHandleOTP()
    {
        $input = \Input::all();
        $data1 = \Crypt::decrypt($input['data']);


        $data['otp'] = $input['otp'];
        $data['debitTxnRef'] = \Crypt::encrypt($data1['debitTxnRef']);
        $data['creditTxnRef'] = \Crypt::encrypt($data1['creditTxnRef']);
        $data['token'] = \Auth::user()->token;



        $result = handleSOAPCalls('validateEWalletOTPPayout', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $data);


        if(handleTokenUpdate($result)==false)
        {
            return \Redirect::to('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }


        if ($result->status == "00") {
            $txnRef = json_decode($result->txnRef);
            $amount = $result->amount;

            $payerMobile = $result->payerMobile;
            $recieverMobile = $result->recieverMobile;
            $creditBalance = $result->balanceCredit;
            $debitBalance = $result->balanceDebit;
            $paidFrom = $result->paidFrom;
            $paidTo = $result->paidTo;

            $msg = "ProbaseWallet Payout Ref #".$txnRef."\nAccount No:".$paidFrom."\nAmount Debited:ZMW".$amount."\nBal:ZMW".$debitBalance."\n\nThank You";
            send_sms($payerMobile, $msg, 'ProbWallet');

            $msg = "ProbaseWallet Payout Ref #".$txnRef."\nAccount No:\".$paidTo.\"\nAmount Credited:ZMW".$amount."\nBal:ZMW".$creditBalance."\n\nThank You";
            send_sms($recieverMobile, $msg, 'ProbWallet');


            $message = 'Payment transaction was successful. <br>Transaction Ref# :$txnRef<br>Amount Paid: ZMW';
            $message = $message."".number_format($amount, 2, '.', ',');
            return \Redirect::to('/wallet/payments')->with('message', $message);
        } else {
            return \Redirect::back()->with('error', isset($result->message) ? $result->message : "Errors initializing payment");
        }
    }


    public function getPayNewCustomer($merchantCode=NULL, $deviceCode=NULL)
    {
        //dd(\Auth::user());
        //dd(33);
        $input = \Input::all();
        $dataForServer['token'] = \Auth::user()->token;
        if($merchantCode!=null && $deviceCoe!=null)
        {
            $dataForServer['merchantCode'] = $merchantCode;
            $dataForServer['deviceCode'] = $deviceCode;
        }

        $result = handleSOAPCalls('getEWalletAccountBalance', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);


        if($result->status == 2003) {
            $balanceList = json_decode($result->balanceList);
            $balance = $result->balance;
            $data1 = \Crypt::encrypt($input);

            return view('probasewallet.authenticated.pay_new_customer', compact('balanceList', 'balance', 'data1'));
        }else if($result->status == -1) {
            return \Redirect::to('/auth/login');
        }else{
            return \Redirect::back()->with('error', isset($result->message) ? $result->message : "Experienced Issues retrieving your balance");
        }
    }


    public function getPayNewMobileCustomer()
    {
        $input = \Input::all();
        $dataForServer['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('getEWalletAccountBalance', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);


        if($result->status == 2003) {
            $balanceList = json_decode($result->balanceList);
            $balance = $result->balance;
            $data1 = \Crypt::encrypt($input);

            return view('probasewallet.authenticated.pay_new_mobile_customer', compact('balanceList', 'balance', 'data1'));
        }else if($result->status == -1) {
            return \Redirect::to('/auth/login');
        }else{
            return \Redirect::back()->with('error', isset($result->message) ? $result->message : "Experienced Issues retrieving your balance");
        }
    }


    public function postSendWalletPaymentForMobilePayment()
    {
        $input = \Input::all();
        if(strpos($input['mobileno'], "-")>0) {
            $mobileAcct = explode('-', $input['mobileno']);
            $dataForServer['recMobileNo'] = \Crypt::encrypt($mobileAcct[0]);
            $dataForServer['recAccountIdentifier'] = \Crypt::encrypt($mobileAcct[1]);
            $dataForServer['amount'] = $input['amount'];
            $dataForServer['detail'] = $input['payinfo'];
            $dataForServer['accesscodeS'] = \Crypt::encrypt(intval($input['accesscode']));
            $dataForServer['accountIdS'] = \Crypt::encrypt(explode('---', $input['pay_from'])[0]);
            $dataForServer['token'] = \Auth::user()->token;

            $result = handleSOAPCalls('processGenerateOTPForCustomerPayOutForMobilePayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataForServer);


            if(handleTokenUpdate($result)==false)
            {
                return \Redirect::to('/auth/login')->with('error', 'Login session expired. Please relogin again');
            }



            if ($result->status == 1002) {
                //$txnRef = json_decode($result->txnRef);
                $data = array();
                $data['debitTxnRef'] = $result->debitTxnRef;
                $data['creditTxnRef'] = $result->creditTxnRef;
                $data['balance'] = $result->balance;
                $data['payFrom'] = $input['pay_from'];

                $otp = $result->otp;
                $otpRec = $result->otpReceiver;
                $msg = "Transaction #".$result->debitTxnRef." currently in progress. \nYour OTP to complete transaction is ".$otp."\n\nThank You.";
                send_sms($otpRec, $msg);

                return \Redirect::to('/wallet/pay/customer/pay_customer/go-to-otp-for-mobile-payment/' . \Crypt::encrypt($data));
            } else {
                return \Redirect::back()->with('error', isset($result->message) ? $result->message : "Errors initializing payment");
            }
        }else{
            return \Redirect::back()->with('error', "Invalid Wallet Account Code Provided. Receipient Wallet Account Code must be in the format -
            WALLET CODE-WALLET ACCOUNT NUMBER");
        }
    }


    public function getPayCustomerGoToOTPForMobilePayment($data1)
    {
        $data = \Crypt::decrypt($data1);
        $balance = $data['balance'];
        $txnRef = $data['debitTxnRef'];
        $creditTxnRef = $data['creditTxnRef'];
        $payFrom = $data['payFrom'];
        return view('probasewallet.authenticated.get_new_pay_otp_for_mobile_payment', compact('data1', 'balance', 'txnRef', 'payFrom'));
    }


    public function postPayCustomerHandleOTPForMobilePayment()
    {
        $input = \Input::all();
        $data1 = \Crypt::decrypt($input['data']);


        $data['otp'] = $input['otp'];
        $data['debitTxnRef'] = \Crypt::encrypt($data1['debitTxnRef']);
        $data['creditTxnRef'] = \Crypt::encrypt($data1['creditTxnRef']);
        $data['token'] = \Auth::user()->token;



        $result = handleSOAPCalls('validateEWalletOTPPayoutForMobilePayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $data);


        if(handleTokenUpdate($result)==false)
        {
            return \Redirect::to('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }


        if ($result->status == 910) {
            $txnRef = json_decode($result->txnRef);
            $amount = $result->amount;
            $paidFrom = $result->paidFrom;
            $notifyReceipient = $result->notifyReceipient;
            $message = 'Payment transaction was successful. <br>Transaction Ref# :$txnRef<br>Amount Paid: ZMW';
            $message = $message."".number_format($amount, 2, '.', ',');

            $msg = "ProbaseWallet Payment Transaction Successful.\nTXNREF:#".$txnRef."\nAmount:ZMW".$amount."\nAccount Debited:".$paidFrom;
            send_sms($notifyReceipient, $msg, 'ProbWallet');


            return \Redirect::to('/wallet/payments')->with('message', $message);
        } else {
            return \Redirect::back()->with('error', isset($result->message) ? $result->message : "Errors initializing payment");
        }
    }


    public function handleCybersourcePayment()
    {

        $input = \Input::all();
        //dd($input);
        $data1 = \Crypt::decrypt($input['data']);
        $input = \Input::except('data') + $data1;

        $amt = 0;
        $itemAmounts = $input['amount'];
        $paymentItems = $input['paymentItem'];

        $items = "";
        $totaldescription = "";
        if(sizeof($paymentItems)>0 && sizeof($paymentItems)==sizeof($itemAmounts)) {
            for ($i = 0; $i < sizeof($itemAmounts); $i++) {
                $amt = $amt + $itemAmounts[$i];
                $items = $items."".$paymentItems[$i].",";
                $totaldescription = $totaldescription."".$paymentItems[$i]."=".$itemAmounts[$i].";";
            }
        }


		$customdata = isset($input['customdata']) ? $input['customdata'] : NULL;
        if($customdata!=NULL && sizeof($customdata)>0) {

            $data['customdata'] = serialize($customdata);
        }

        //dd($input);
        $countryCode = $input['countryCode'];
        $countryCode = explode(':::', $countryCode);
        $countryId = sizeof($countryCode)>0 ? $countryCode[0] : -1;
        $countryCode = sizeof($countryCode)>1 ? $countryCode[1] : "260";


        $data['billingFirstName'] = $input['firstName'];
        $data['billingLastName'] = $input['lastName'];
        $data['billingPhone'] = $countryCode."".$input['phoneNumber'];
        $data['billingEmail'] = $input['email'];
        $data['billingStreetAddress'] = $input['streetAddress'];
        $data['billingCity'] = ($input['city']);
        $data['billingDistrict'] = (explode('_', $input['district'])[0]);
        $data['merchantId'] = $input['merchantId'];
        $data['deviceCode'] = $input['deviceCode'];
        $data['serviceTypeId'] = $input['serviceTypeId'];
        $data['orderId'] = $input['orderId'];
        $data['hash'] = $input['hash'];
        $data['payerName'] = $input['payerName'];
        $data['payerEmail'] = $input['payerEmail'];
        $data['payerPhone'] = $input['payerPhone'];
        $data['responseurl'] = $input['responseurl'];
        $data['payerId'] = $input['payerId'];
        $data['nationalId'] = $input['nationalId'];
        $data['scope'] = $input['scope'];
        $data['description'] = $input['description'];
        $data['totaldescription'] = $totaldescription;
        $data['amount'] = number_format($amt, 2, '.', '');
        if(isset($input['nationalId']))
        {
            $data['customdata'] = json_encode(['nationalId' => $input['nationalId']]);
        }
        if(isset($input['currency']))
		{
            $data['currency'] = $input['currency'];
		}


        //dd($data);


        $result = handleSOAPCalls('initiateCyberSourcePayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $data);

        //print_r($input);
        //dd($result);



        if (isset($result->status) && $result->status == 1002) {

            $params['amount'] = $result->amount;
            $params['currency'] = $result->currency;
            $params['reference_number'] = $result->reference_number;
            $params['transaction_uuid'] = $result->transaction_uuid;
            $params['transaction_type'] = $result->transaction_type;
            $params['locale'] = $result->locale;
            $params['bill_to_address_city'] = $result->billingCity;
            $params['bill_to_address_country'] = "ZM";
            $params['bill_to_address_line1'] = $result->billingStreetAddress;
            $params['bill_to_address_postal_code'] = substr($result->billingDistrictCode, 0, 5);
            $params['bill_to_address_state'] = substr($result->billingState, 0, 9);
            $params['bill_to_email'] = $result->billingEmail;
            $params['bill_to_forename'] = $result->billingFirstName;
            $params['bill_to_surname'] = $result->billingLastName;
            $params['bill_to_phone'] = $result->billingPhone;
            $params['signed_date_time'] = gmdate("Y-m-d\TH:i:s\Z");
            $params['signed_field_names'] = $result->signed_field_names;
            $params['unsigned_field_names'] = $result->unsigned_field_names;
            $params['profile_id'] = $result->profile_id;
            $params['access_key'] = $result->access_key;
            //$params['signature'] = $result->signature;
            /*for($im=1; $im<101; $im++) {
                $key_1 = 'merchant_defined_data' + $im;
                if (isset($result->$key_1) && $result->$key_1 != NULL) {
                    $params[$key_1] = $result->$key_1;
                }
            }*/
            if(isset($result->customdata) && $result->customdata!=null)
			    $params['customdata'] = $result->customdata;

//dd($params);

            //$keysIndex['profile_id'] = CYBERSOURCE_PROFILE_ID;
			//$keysIndex['access_key'] = CYBERSOURCE_ACCESS_KEY;
			$keysIndex['profile_id'] = $result->profile_id;
			$keysIndex['access_key'] = $result->access_key;

            $keysIndex = [];
            $keys = explode(',', $result->signed_field_names);
            foreach($keys as $k)
            {
				if($k=='unsigned_field_names')
				{
					//echo "111-".$params['unsigned_field_names'];
				}
                if(isset($params[$k]) && $params[$k]!=null)
				{
                    $keysIndex[$k] = $params[$k];
				}
				else
				{
					if($params[$k]=="")
						$keysIndex[$k] = "";
				}
            }



            if(sizeof($keys)>0 && sizeof($keys)==sizeof($keysIndex))
            {

            }
            else
            {
                return \Redirect::to($result->returnUrl)->with('error', 'Insufficient data provided. Consult the api docs for list of fields to be provided');
            }

            if(isset($result->switch_to_live) && $result->switch_to_live==1)
            {
                $keysIndex['signature'] = signData(buildDataToSign($keysIndex), \UserConstants::$CYBERSOURCE_CONSTANT);
            }
            else if(isset($result->switch_to_live) && $result->switch_to_live==0)
            {
                $keysIndex['signature'] = signData(buildDataToSign($keysIndex), \UserConstants::$DEMO_CYBERSOURCE_CONSTANT);
            }

            if(isset($result->cybersource_url))
            {
                $keysIndex['cyber_url'] = $result->cybersource_url;
            }
            //echo $result->signature."<br>";
            //dd($params);
			//dd($keysIndex);
            $data = json_encode($keysIndex);
			$billData = new \App\Models\BillData();
			$billData->data = $data;
			$billData->save(); //dd($billData);

            return \Redirect::to('/payments/forward-cyberpay/'.\Crypt::encrypt($billData->id));

        }
        else {


			/*$response["statusmessage"] = $result->message;
            $response["reason"] = $result->message;
            $response["status"] = $result->status;
            $response["merchantId"] = $input['merchantId'];
            $response["deviceCode"] = $input['deviceCode'];
            $response["channel"] = "VISA_MASTERCARD_WEB";
            $response["transactionDate"] = date('Y-m-d H:i:s');
            $response["orderId"] = $input['orderId'];
            $response["redirectUrl"] = $input['responseurl'];
            $response["amount"] = $input['amount'];
            $response["typeMethod"] = "GET";

			//dd($response);
            return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));*/


            //return \Redirect::back()->with('error', 'Error processing payment');
        }
    }



    public function handleUbaPaymentOld()
    {

        $input = \Input::all();
        //dd($input);
        $data1 = \Crypt::decrypt($input['data']);
        $input = \Input::except('data') + $data1;

        $amt = 0;
        $itemAmounts = $input['amount'];
        $paymentItems = $input['paymentItem'];

        $items = "";
        $totaldescription = "";
        if(sizeof($paymentItems)>0 && sizeof($paymentItems)==sizeof($itemAmounts)) {
            for ($i = 0; $i < sizeof($itemAmounts); $i++) {
                $amt = $amt + $itemAmounts[$i];
                $items = $items."".$paymentItems[$i].",";
                $totaldescription = $totaldescription."".$paymentItems[$i]."=".$itemAmounts[$i].";";
            }
        }


		$customdata = isset($input['customdata']) ? $input['customdata'] : NULL;
        if($customdata!=NULL && sizeof($customdata)>0) {

            $data['customdata'] = serialize($customdata);
        }

        //dd($input);

        $data['billingFirstName'] = $input['firstNameuba'];
        $data['billingLastName'] = $input['lastNameuba'];
        $data['billingPhone'] = $input['countryCodeUba']."".$input['phoneNumberUba'];
        $data['billingEmail'] = $input['emailuba'];
        $data['billingStreetAddress'] = $input['streetAddressuba'];
        $data['billingCity'] = ($input['cityuba']);
        $data['billingDistrict'] = (explode('_', $input['districtuba'])[0]);
        $data['merchantId'] = $input['merchantId'];
        $data['deviceCode'] = $input['deviceCode'];
        $data['serviceTypeId'] = $input['serviceTypeId'];
        $data['orderId'] = $input['orderId'];
        $data['hash'] = $input['hash'];
        $data['payerName'] = $input['payerName'];
        $data['payerEmail'] = $input['payerEmail'];
        $data['payerPhone'] = $input['payerPhone'];
        $data['responseurl'] = $input['responseurl'];
        $data['payerId'] = $input['payerId'];
        $data['nationalId'] = $input['nationalId'];
        $data['scope'] = $input['scope'];
        $data['description'] = $input['description'];
        $data['totaldescription'] = $totaldescription;
        $data['amount'] = number_format($amt, 2, '.', '');
        if(isset($input['nationalId']))
        {
            $data['customdata'] = json_encode(['nationalId' => $input['nationalId']]);
        }
        if(isset($input['currency']))
		{
            $data['currency'] = $input['currency'];
		}


        //dd($data);


        $result = handleSOAPCalls('initiateUBAPayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $data);

        //print_r($input);
        //
        //dd($result);



        if (isset($result->status) && $result->status == 1002) {

            $body['merchantId'] = $result->merchant_id;
			$body['description'] = $result->description;
			$body['total'] = $result->total;
			$body['date'] = $result->date;
			//$body['countryCurrencyCode'] = $result->countryCurrencyCode;
			$body['countryCurrencyCode'] = "967";
			$body['noOfItems'] = $result->noOfItems;
			$body['customerFirstName'] = $result->customerFirstName;
			$body['customerLastname'] = $result->customerLastname;
			//$body['customerEmail'] = $result->customerEmail;
			$body['customerEmail'] = "smicer66@gmail.com";
			$body['customerPhoneNumber'] = $result->customerPhoneNumber;
			//$body['referenceNumber'] = $result->referenceNumber;
			$body['referenceNumber'] = $result->txnRef;
			$body['serviceKey'] = $result->serviceKey;
		    dd($body);

            $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://ucollect.ubagroup.com/cipg-payportal/regptran');
			//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			//curl_setopt($ch, CURLOPT_HEADER, 0);
			//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			// Timeout in seconds
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);

			$response = curl_exec($ch);
			$returnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);

			if($returnCode == 200){
				$transactionId = $response;
				//dd($response);
				$paylink = "https://ucollect.ubagroup.com/cipg-payportal/paytran?id=" .$transactionId;
				//header("Location: ".$paylink);
				return redirect()->away($paylink);
			}else{
				return ['status'=>false, 'response'=>$response, 'returnCode' => $returnCode];
			}

        }
        else {


			$response["statusmessage"] = $result->message;
            $response["reason"] = $result->message;
            $response["status"] = $result->status;
            $response["merchantId"] = $input['merchantId'];
            $response["deviceCode"] = $input['deviceCode'];
            $response["channel"] = "UBA";
            $response["transactionDate"] = date('Y-m-d H:i:s');
            $response["orderId"] = $input['orderId'];
            $response["redirectUrl"] = $input['responseurl'];
            $response["amount"] = $input['amount'];
            $response["typeMethod"] = "GET";

			//dd($response);
            return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));


            //return \Redirect::back()->with('error', 'Error processing payment');
        }
    }



    public function handleUbaPayment()
    {

        $input = \Input::all();
        //dd($input);
        $data1 = \Crypt::decrypt($input['data']);
        $input = \Input::except('data') + $data1;

        $amt = 0;
        $itemAmounts = $input['amount'];
        $paymentItems = $input['paymentItem'];

        $items = "";
        $totaldescription = "";
        if(sizeof($paymentItems)>0 && sizeof($paymentItems)==sizeof($itemAmounts)) {
            for ($i = 0; $i < sizeof($itemAmounts); $i++) {
                $amt = $amt + $itemAmounts[$i];
                $items = $items."".$paymentItems[$i].",";
                $totaldescription = $totaldescription."".$paymentItems[$i]."=".$itemAmounts[$i].";";
            }
        }


		$customdata = isset($input['customdata']) ? $input['customdata'] : NULL;
        if($customdata!=NULL && sizeof($customdata)>0) {

            $data['customdata'] = serialize($customdata);
        }

        //dd($input);

        $data['billingFirstName'] = $input['firstNameuba'];
        $data['billingLastName'] = $input['lastNameuba'];
        $data['billingPhone'] = $input['countryCodeUba']."".$input['phoneNumberUba'];
        $data['billingEmail'] = $input['emailuba'];
        $data['billingStreetAddress'] = $input['streetAddressuba'];
        $data['billingCity'] = ($input['cityuba']);
        $data['billingDistrict'] = (explode('_', $input['districtuba'])[0]);
        $data['merchantId'] = $input['merchantId'];
        $data['deviceCode'] = $input['deviceCode'];
        $data['serviceTypeId'] = $input['serviceTypeId'];
        $data['orderId'] = $input['orderId'];
        $data['hash'] = $input['hash'];
        $data['payerName'] = $input['payerName'];
        $data['payerEmail'] = $input['payerEmail'];
        $data['payerPhone'] = $input['payerPhone'];
        $data['responseurl'] = $input['responseurl'];
        $data['payerId'] = $input['payerId'];
        $data['nationalId'] = $input['nationalId'];
        $data['scope'] = $input['scope'];
        $data['description'] = $input['description'];
        $data['totaldescription'] = $totaldescription;
        $data['amount'] = number_format($amt, 2, '.', '');
        if(isset($input['nationalId']))
        {
            $data['customdata'] = json_encode(['nationalId' => $input['nationalId']]);
        }
        if(isset($input['currency']))
		{
            $data['currency'] = $input['currency'];
		}


        //dd($data);


        $result = handleSOAPCalls('initiateUBAPayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $data);

        //print_r($input);
        //
        //dd($result);



        if (isset($result->status) && $result->status == 1002) {

            $result->merchant_id = 'ZM0700006';
			$body['email'] = "smicer66@gmail.com";
			$body['firstname'] = $result->customerFirstName;
			$body['lastname'] = $result->customerLastname;
			$body['phone'] = $result->customerPhoneNumber;
            $body['merchantID'] = $result->merchant_id;
			$body['uniqueID'] = $result->serviceKey;
			$body['description'] = $result->description;
			$body['amount'] = $result->total;
			$body['returnUrl'] = 'http://payments.probasepay.com/listerner/uba/response';
			$body['transactionid'] = $result->txnRef;
			$body['redirectUrl'] = 'https://zm.instantbillspay.com/api/bill/payment';
			$body['statusmessage'] = 'Loading...';
			//$body['date'] = $result->date;
			//$body['countryCurrencyCode'] = $result->countryCurrencyCode;
			//$body['countryCurrencyCode'] = "967";
			//$body['noOfItems'] = $result->noOfItems;
			//$body['customerEmail'] = $result->customerEmail;
			//$body['referenceNumber'] = $result->referenceNumber;
		    //dd($body);

            //$ch = curl_init();
			/*curl_setopt($ch, CURLOPT_URL, 'https://zm.instantbillspay.com/api/bill/payment');
			//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			//curl_setopt($ch, CURLOPT_HEADER, 0);
			//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			// Timeout in seconds
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);

			$response = curl_exec($ch);
			$returnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);

			if($returnCode == 200){
				$transactionId = $response;
				dd([$result->merchant_id, $response]);
				$paylink = "https://ucollect.ubagroup.com/cipg-payportal/paytran?id=" .$transactionId;
				//header("Location: ".$paylink);
				return redirect()->away($paylink);
			}else{
			    dd([ $response]);
				return ['status'=>false, 'response'=>$response, 'returnCode' => $returnCode];
			}*/

            /*$curl = curl_init();

            $url_end = "email=smicer66@gmail.com&firstname=".urlencode($result->customerFirstName)."&lastname=".urlencode($result->customerLastname)."&phone=".urlencode($result->customerPhoneNumber).
                "&merchantID=".urlencode($result->merchant_id)."&uniqueID=".$result->serviceKey."&description=".urlencode($result->description)."&amount=".$result->total.
                "&returnUrl=".urlencode($input['responseurl'])."&transactionid=".$result->txnRef;
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://zm.instantbillspay.com/api/bill/payment?email=smicer66@gmail.com&firstname=Kachi&lastname=Akujua&phone=2348094073705&merchantID=ZM0700006&uniqueID=283bdea5-c1fa-47a0-8392-43a320d8060f&description=Zambia%20Railway%20Limited%20-%20Purchase%20of%20Tickets&amount=140.00&returnUrl=http://zrl.com/payments/probasepay/response&transactionid=9074808981",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => "email=smicer66%40gmail.com&firstname=Kachi&lastname=Akujua&phone=2348094073705&merchantID=ZM0700006&uniqueID=283bdea5-c1fa-47a0-8392-43a320d8060f&description=Zambia%20Railway%20Limited%20-%20Purchase%20of%20Tickets&amount=140.00&returnUrl=http%3A%2F%2Fzrl.com%2Fpayments%2Fprobasepay%2Fresponse&transactionid=9074808981",
              CURLOPT_HTTPHEADER => array(
                "Accept-Encoding: gzip, deflate",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Content-Type: application/x-www-form-urlencoded",
                "Cookie: PHPSESSID=59cebe18b079c453eb99c0be033033f3; SERVERID=s1; ci_session_ubfe=VMa0J0thoOZdi%2FjdWrY89CVUp5yworeDZBvkRAkCXgxCE%2BdPCzrDh%2Bo%2F33Tj9%2BVDzgjNpalL%2FgnuMnBTWXeGYExoEue1dD4zZpkFJpu%2B66KPC%2FYGeU%2FwXd2MgLi%2Bu0kWD5azXNaG%2BoiCjG9v7Okiqsg1P0%2FOVKHY%2Fd%2FizYUjeGEgOhmtgA6HQw8ZBfStnNLI1yjBGkDmHqikIn46%2BDsLbPjMWGoik6n%2FbsnNX2aj7VnWj1venYGYnMyYAfs97i2ZThJ6Z9NQq1kJQJzATZzw9kvZPFTkguWLH7Hq062OpFo%3D066e81a17e4d0d1deb257c2a32f3335f6314161b",
                "Postman-Token: e2c4843c-a84d-4ecb-b82f-8fc305f0f96d,0cf14214-ed2f-4277-9df1-441f36688767",
                "Referer: https://zm.instantbillspay.com/api/bill/payment?email=smicer66@gmail.com&firstname=Kachi&lastname=Akujua&phone=2348094073705&merchantID=ZM0700006&uniqueID=283bdea5-c1fa-47a0-8392-43a320d8060f&description=Zambia%20Railway%20Limited%20-%20Purchase%20of%20Tickets&amount=140.00&returnUrl=http://zrl.com/payments/probasepay/response&transactionid=9074808981",
                "User-Agent: PostmanRuntime/7.19.0",
                "cache-control: no-cache"
              ),
            ));

            $response = curl_exec($curl);
            $returnCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                dd("cURL Error #:" . $err);
            } else {
                dd([$response, $returnCode]);
            }*/
            $response = $body;
            dd($response);
            return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));

        }
        else {


			$response["statusmessage"] = $result->message;
            $response["reason"] = $result->message;
            $response["status"] = $result->status;
            $response["merchantId"] = $input['merchantId'];
            $response["deviceCode"] = $input['deviceCode'];
            $response["channel"] = "UBA";
            $response["transactionDate"] = date('Y-m-d H:i:s');
            $response["orderId"] = $input['orderId'];
            $response["redirectUrl"] = $input['responseurl'];
            $response["amount"] = $input['amount'];
            $response["typeMethod"] = "GET";

			//dd($response);
            return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));


            //return \Redirect::back()->with('error', 'Error processing payment');
        }
    }



    public function handleTutukaPostResponse()
    {
        $resp = [];
        $resp['status'] = 0;
        $resp['message'] = 'This is a test end point. Data Received';

        $input = \Input::all();
        $billData = new \App\Models\BillData();
        $billData->data = json_encode($input);
        $billData->type = 'Tutuka';
        $billData->save();

        return \Response::json($resp);
    }


    public function handleTutukaGetResponse()
    {
        $resp = [];
        $resp['status'] = 0;
        $resp['message'] = 'This is a test end point. Disabled';

        return \Response::json($resp);
    }


    public function handleForwardToCyberPay($data)
    {
		$data = \Crypt::decrypt($data);
		$billData = \App\Models\BillData::where('id', '=', $data);
        if($billData->count() >0)
		{
			$billData = $billData->first();
			$billData_ = $billData->data;
			$params = json_decode($billData_);
            $billData->delete();
            $cyber_url = $params->cyber_url;
			return view('guests.payment.cybersource.forward', compact('params', 'cyber_url'));
		}else
		{
			return \Redirect::back()->with('error', 'Error processing payment');
		}
    }


    public function handleHandleCybersourceInFrame($key, $billId)
    {
        $billIdDec = \Crypt::decrypt($billId);
        $billData = \App\Models\BillData::where('id', '=', $billIdDec)->first();
        $billdata = json_decode($billData->data, TRUE);
        $currency = $billdata['currency'];
        $totalAmount = $billdata['total_amount'];
        $orderRef = $billdata['orderId'];

        $responseData = $billData->response_data;
        $responseData = json_decode($responseData, TRUE);
        return view('guests.payment.cybersource.handle_exit_from_cybersource', compact('billId', 'billdata', 'currency', 'totalAmount', 'orderRef', 'responseData'));
    }


    public function handleCybersourceResponse(Request $request)
    {
        $all = $request->all();
		//dd($all);
        if(isset($all['decision']) && strtolower($all['decision'])=='decline')
        {
            $response["statusmessage"] = $all['message'];
            $response["reason"] = $all['message'];
            $response["status"] = '11';
            $response["transactionDate"] = date('Y-m-d H:i:s');
            if(isset($all['req_reference_number']))
                $response["merchantId"] = explode('-', $all['req_reference_number'])[0];
            if(isset($all['req_transaction_uuid']))
            {
                $response["transactionRef"] = $all['req_transaction_uuid'];
                $response["txn_ref"] = $all['req_transaction_uuid'];
                $response["txnRef"] = $all['req_transaction_uuid'];
            }
            if(isset($data1['req_reference_number']))
                $response["orderId"] = explode('-', $all['req_reference_number'])[1];


            //dd($response);
            $data1 = json_encode($all);
            $data1 = \Crypt::encrypt($data1);
            $data['responseData'] = $data1;


            $dataStr = "";
            foreach($data as $d => $v)
            {
                $dataStr = $dataStr."".$d."=".$v."&";
            }

            //dd($dataStr);
            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/PaymentServicesV2/finishCyberSourcePaymentV2';
            $authDataStr = sendPostRequest($url, $dataStr);
            //dd($authDataStr);
            $authData = json_decode($authDataStr);
            //dd($authData);
            $data = \Crypt::encrypt($authData);

            //dd(\Auth::user());
            $billData1->response_data = $data;
            $billData1->status = 2;
            $billData1->save();

            $billData1IdEnd = \Crypt::decrypt($billData1->id);
            return \Redirect::to('/ajax-pay-from-cybersource-failed.html/'.CYBERSOURCE_PAYMENT_FAILED.'/'.$billData1IdEnd);
            return \Redirect::to('/payments/error-processing/'.\Crypt::encrypt($response))->with('error', $data1['message']);
        }
        //dd([$data1]);
        $data1 = json_encode($all);
        $data1 = \Crypt::encrypt($data1);
        $data['responseData'] = $data1;

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/PaymentServicesV2/finishCyberSourcePaymentV2';
        $authDataStr = sendPostRequest($url, $dataStr);
        $authData = json_decode($authDataStr);
        //$result = handleSOAPCalls('finishCyberSourcePayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $data);
        //dd([$all, $result]);

        if ($authData==null)
        {
            return \Redirect::back()->with('error', 'General system error processing your payment.');
        }

        //dd($result);
        if($authData->status==1000016) {
            $resp = [];
            $billData1 = null;
            if(isset($authData->customdata) && $authData->customdata!=null)
            {
                $customdata = $authData->customdata;
                $customdata = unserialize($customdata);
                $billDataId = isset($customdata['billDataId']) ? $customdata['billDataId'] : null;
                $custom_data = isset($customdata['customdata']) ? $customdata['customdata'] : null;
                $resp['custom_data'] = $custom_data;
                $billData1 = \App\Models\BillData::where('id', '=', $billDataId)->first();
            }
            //$resp['sess'] = Jjson_encode(\Session::all());

            $billIdEnc = \Crypt::encrypt($billData1->id);
            $message = $authData->message;
            $key = PAY_FROM_LOGGED_IN_WALLET_SUCCESS_PAGE;
            $resp['key'] = $key;
            $resp['input'] = $billIdEnc;
            $resp['status'] = 100;
            $resp['success'] = true;
            $resp['order_ref'] = $authData->orderId;
            $resp['txn_ref'] = $authData->txnRef;
            $resp['merchant_id'] = $authData->merchantId;
            $resp['merchant_name'] = $authData->merchantName;
            $resp['channel'] = $authData->channel;

            if(isset($authData->customerMobileNumber))
                $resp['customer_mobile_number'] = $authData->customerMobileNumber;
            if(isset($authData->customrEmailAddress))
                $resp['customer_email_address'] = $authData->customerEmailAddress;

            $resp['device_code'] = $authData->deviceCode;
            $resp['transaction_date'] = $authData->transactionDate;
            $resp['auto_return_to_merchant'] = $authData->autoReturnToMerchant;
            $resp['return_url'] = $authData->returnUrl;
            $billData1->response_data = json_encode($resp);
            $billData1->status = 1;
            $billData1->save();

            return \Redirect::to('/ajax-pay-from-cybersource-handle-response.html/'.PAY_FROM_LOGGED_IN_WALLET_SUCCESS_PAGE.'/'.$billIdEnc);
            return \Response::json($resp, 200);
        }
        else if($authData->status==-1) {
            return response()->json(['message' => "Login to continue", 'success' => true, 'status' => -1], 200);
        }
        else{

            $billData1->response_data = json_encode($resp);
            $billData1->status = 2;//FAILED
            $billData1->save();
            return \Redirect::to('/ajax-pay-from-logged-in-wallet-failed.html/'.PAY_FROM_LOGGED_IN_WALLET_FAIL_PAGE.'/'.$billIdEnc);
            return \Response::json($resp, 200);
        }


    }






	public function handleCybersourceCancelResponse(Request $request)
    {
        \Session::remove('error');
        $data1 = $request->all();
        //dd($data1);

        if(isset($data1['decision']) && strtolower($data1['decision'])=='CANCEL')
        {
            $response["statusmessage"] = $all['message'];
            $response["reason"] = $all['message'];
            $response["status"] = '11';
            $response["transactionDate"] = date('Y-m-d H:i:s');
            if(isset($all['req_reference_number']))
                $response["merchantId"] = explode('-', $all['req_reference_number'])[0];
            if(isset($all['req_transaction_uuid']))
            {
                $response["transactionRef"] = $all['req_transaction_uuid'];
                $response["txn_ref"] = $all['req_transaction_uuid'];
                $response["txnRef"] = $all['req_transaction_uuid'];
            }
            if(isset($data1['req_reference_number']))
                $response["orderId"] = explode('-', $all['req_reference_number'])[1];
        }
		$data1['operation'] = 'CANCEL';
        $data1 = json_encode($data1);
        $data1 = \Crypt::encrypt($data1);
        $data['responseData'] = $data1;

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/PaymentServicesV2/finishCyberSourcePaymentV2';
        $authDataStr = sendPostRequest($url, $dataStr);
        //dd($authDataStr);
        $authData = json_decode($authDataStr);
        dd($authData);
        $data = \Crypt::encrypt($authData);
        return \Redirect::to('/ajax-pay-from-cybersource-failed.html/'.CYBERSOURCE_PAYMENT_FAILED.'/'.$data);

        //dd($result);

        if (isset($result->status) && $result->status == "5002") {
            $response["statusmessage"] = $result->message;
            $response["reason"] = $result->message;
            $response["merchantId"] = $result->merchantId;
            $response["deviceCode"] = $result->deviceCode;
            $response["channel"] = $result->channel;
            $response["status"] = '5002';
            $response["transactionRef"] = $result->txnRef;
            $response["txn_ref"] = $result->txnRef;
            $response["txnRef"] = $result->txnRef;
            $response["transactionDate"] = date('Y-m-d H:i:s');
            $response["orderId"] = $result->orderId;
            $response["redirectUrl"] = $result->returnUrl;
            $response["amount"] = $result->amount;


            return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
        }else
        {
            $response["statusmessage"] = $result->message;
            $response["reason"] = $result->message;
            $response["status"] = isset($result->status) ? $result->status : "99";
            $response["transactionDate"] = date('Y-m-d H:i:s');
            if(isset($result->merchantId))
                $response["merchantId"] = $result->merchantId;
            if(isset($result->deviceCode))
                $response["deviceCode"] = $result->deviceCode;
            if(isset($result->txnRef))
            {
                $response["transactionRef"] = $result->txnRef;
                $response["txn_ref"] = $result->txnRef;
                $response["txnRef"] = $result->txnRef;
            }
            if(isset($result->orderId))
                $response["orderId"] = $result->orderId;
            if(isset($result->returnUrl))
			{
                $response["redirectUrl"] = $result->returnUrl;
			}
            else
			{
                return \Redirect::to('/payments/init')->with('error', $result->message);
			}

            return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
        }


    }



    public function loadFundCardFromWalletView($key, $input, $orderId, $serialNo)
    {
        $response = '';
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
        $transactions = null;
        $defaultAccount = null;
        $defaultAccountBal = null;
        if($authData->status==5000) {
            $accounts = $authData->accounts;
            $cards = $authData->cards;
            $defaultAccount = $accounts[0];


            $dataBal = [];
            $dataBal['token'] = \Auth::user()->token;
            $dataBal['accountIdentifier'] = $defaultAccount->accountIdentifier;
            $dataBal['merchantCode'] = PROBASEWALLET_MERCHANT_CODE;
            $dataBal['deviceCode'] = PROBASEWALLET_DEVICE_CODE;
            $dataBalStr = "";
            foreach($dataBal as $d => $v)
            {
                $dataBalStr = $dataBalStr."".$d."=".$v."&";
            }
            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountServicesV2/getAccountBalance';
            $dataBalStr = sendGetRequest($url, $dataBalStr);
            $dataBal = json_decode($dataBalStr);
            if(isset($dataBal->status) && $dataBal->status==100)
            {
                $defaultAccountBal = $dataBal;
            }
            else if(isset($dataBal->status) && $dataBal->status==-1)
            {
                return \Redirect::to('/auth/login')->with('warning', 'Login to continue');
            }
            else
            {
                return \Redirect::back()->with('error', 'We could not pull your current wallet balance. Please try again later');
            }
        }
        else if($authData->status==-1) {
            return \Redirect::to('/auth/login')->with('warning', 'Login to continue');
        }
        $currencyList = array_keys(getAllCurrency());
        $billIdEnc = $input;
        $input = \Crypt::decrypt($input);
        $billdata = \App\Models\BillData::where('id', '=', $input)->first();
        $billdata = json_decode($billdata->data, TRUE);
        $currency = $billdata['currency'];
        $totalAmount = $billdata['total_amount'];
        $input = $billIdEnc;

        return view('guests.payment.web.fund_bevura_card_from_wallet_view', compact('serialNo', 'defaultAccountBal', 'defaultAccount', 'totalAmount', 'currency', 'currencyList', 'accounts', 'cards', 'input', 'key', 'serialNo', 'orderId'));
    }

    public function getNewRPINPayment()
    {
        $result = handleSOAPCalls('listMerchants', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', [
            'token' => \Auth::user()->token,
        ]);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/')->with('error', 'Login session expired. Please relogin again');
        }

        $merchantList = json_decode($result->merchantlist);
        return view('core.authenticated.payments.new_rpin_payment', compact('merchantList'));
    }

    public function postNewRPINPayment()
    {
        $data = \Input::all();
        $data = \Crypt::encrypt($data);
        return \Redirect::to('/bank-teller/vendor-service/confirm-payment/'.$data);
    }


    public function getConfirmRPINPayment($data)
    {
        $data1 = \Crypt::decrypt($data);
        return view('core.authenticated.payments.new_rpin_confirm_payment', compact('data1', 'data'));
    }

    public function postConfirmRPINPayment()
    {
        $input = \Input::all();
        $data = \Crypt::decrypt($input['data']);
        $dataService = [
            'token' => \Auth::user()->token,
            'vendorServiceIdS' => \Crypt::encrypt(intval(explode('|||', $data['vendorService'])[0])),
            'amount' => floatval($data['amount']),
            'payeeEmail' => $data['payeeEmail'],
            'payeeMobile' => $data['payeeMobile'],
            'payeeFullName' => $data['payeeFullName'],
        ];


        $result = handleSOAPCalls('processVendorServicePayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataService);


        if(handleTokenUpdate($result)==false)
        {
            return redirect('/')->with('error', 'Login session expired. Please relogin again');
        }

        if (isset($result->status) && $result->status == 0) {
            $txnRef = ($result->txnRef);
            $amount = $result->amounttopay;
            $rPin = $result->rPin;
            $vendorService = json_decode($result->vendorService);
            $vendorService = $vendorService->serviceName;
            $payermobile = $result->payermobile;
            $msg = 'Payment transaction was successful. \nTransaction Ref# :'.$txnRef.'\nAmount'.
                'Paid: ZMW'.number_format($amount, 2, '.', ',').'\nVendor Service:'.$vendorService.'\nRPIN#:'.$rPin;

            $message = 'Payment transaction was successful. <br>Transaction Ref# :'.$txnRef.'<br>Amount'.
                'Paid: ZMW'.number_format($amount, 2, '.', ',').'<br>Vendor Service:'.$vendorService.'<br>RPIN#:'.$rPin;
            send_sms($payermobile, $msg);


            return \Redirect::to('/bank-teller/vendor-service/new-payment')->with('message', $message);
        } else {
            return \Redirect::back()->with('error', isset($result->message) ? $result->message : "Errors experienced making payment");
        }
    }




    /**Get Confirm Existing RPIN*/
    public function getNewExistingRPINPayment()
    {

        return view('core.authenticated.payments.new_existing_rpin_payment');
    }

    public function postNewExistingRPINPayment()
    {
        $input = \Input::all();
        $data = [
            'token' => \Auth::user()->token,
            'rpinS' => \Crypt::encrypt($input['rpin'])
        ];
        $result = handleSOAPCalls('verifyRPINPayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $data);



        if(handleTokenUpdate($result)==false)
        {
            return redirect('/')->with('error', 'Login session expired. Please relogin again');
        }

        if(isset($result->status) && $result->status==0) {
            $data = \Crypt::encrypt(($result));
            return \Redirect::to('/bank-teller/vendor-service/confirm-existing-rpin/'.$data);
        }
        return \Redirect::back()->with('error', isset($result->message) ? $result->message : 'Error experienced find payment matching RPIN provided');


    }


    public function getConfirmExistingRPINPayment($data)
    {
        $data1 = \Crypt::decrypt($data);

        return view('core.authenticated.payments.new_existing_rpin_confirm_payment', compact('data1', 'data'));
    }

    public function postConfirmExistingRPINPayment()
    {
        $input = \Input::all();
        $data = \Crypt::decrypt($input['data']);


        $dataService = [
            'token' => \Auth::user()->token,
            'amount' => floatval($input['amount']),
            'rpinS' => \Crypt::encrypt($data->rpin),
            'transactionRef' => $data->transactionRef,
        ];


        $result = handleSOAPCalls('confirmRPINPayment', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl', $dataService);


        if(handleTokenUpdate($result)==false)
        {
            return redirect('/')->with('error', 'Login session expired. Please relogin again');
        }

        if (isset($result->status) && $result->status == 0) {
            $txnRef = ($result->transactionRef);
            $amount = $result->amount;
            $rPin = $result->rpin;
            $payermobile = $result->customerMobile;
            $msg = 'Payment transaction was successful. \nTransaction Ref# :'.$txnRef.'\nAmount'.
                'Paid: ZMW'.number_format($amount, 2, '.', ',').'\nRPIN#:'.$rPin;

            $message = 'Payment transaction was successful. <br>Transaction Ref# :'.$txnRef.'<br>Amount'.
                'Paid: ZMW'.number_format($amount, 2, '.', ',').'<br>RPIN#:'.$rPin;
            send_sms($payermobile, $msg);


            return \Redirect::to('/bank-teller/vendor-service/existing-rpin')->with('message', $message);
        } else {
            return \Redirect::back()->with('error', isset($result->message) ? $result->message : "Errors experienced making payment");
        }
    }



    public function handleGetOnlineBankResponse()
    {
        handleOnlineBankResponse();
    }

    public function handleOnlineBankResponse()
    {
        $data1 = \Input::all();
        //dd($data1);
        /*s:388:"{"payment_status_":"S","payment_status_description_":"Payment process successfully","bank_reference_":"MXN1493363626",
        "payment_date_":"2017-04-28 07:13:46","unique_reference":"0118347928","student_name":"Sabra Myrtis","student_number":"SFE-2003\/191682",
        "student_id":"2003\/191682","term":"Second term (2017) - 2017 | Demo School","description":"","amount":"100.00","req_amount":"100.00"}";*/
        $data1['req_amount'] = $data1['amount'];
        $data1['statusCode'] = $data1['payment_status_']=='S' ? '0000' : $data1['payment_status_'];
        $data1['statusCode_'] = $data1['payment_status_']=='S' ? '0000' : $data1['payment_status_'];
        $data1['statusDescription'] = $data1['payment_status_description_'];
        $data1['messageReference'] = $data1['bank_reference_'];
        $data1['action'] = $data1['payment_status_']=='S' ? '0000' : $data1['payment_status_'];
        $data1['paymentParticulars'] = json_encode($data1);
        $data1['responseTimestamp'] = $data1['payment_date_'];
        $data1['clientCode'] = $data1['unique_reference'];
        $data1['accessId'] = "";
        $data1['type'] = "";
        $data1['locale'] = "";
        $data1['currency'] = "";
        $data1['country'] = "ZM";
        $data1['requestTimestamp'] = $data1['payment_date_'];
        $data1['message'] = $data1['payment_status_description_'];
        $data1 = json_encode($data1);

        $data1 = \Crypt::encrypt($data1);
        $data['responseData'] = $data1;


        $result = handleSOAPCalls('completePaymentForOnlineBanking', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PaymentServices?wsdl&r=3', $data);






        if (isset($result->status) && $result->status == "00") {
            $response["statusmessage"] = $result->message;
            $response["reason"] = $result->message;
            $response["merchantId"] = $result->merchantId;
            $response["deviceCode"] = $result->deviceCode;
            $response["channel"] = $result->channel;
            $response["status"] = '00';
            $response["transactionRef"] = $result->transactionRef;

            $response["txn_ref"] = $result->transactionRef;
            $response["txnRef"] = $result->transactionRef;
            $response["transactionDate"] = $result->transactionDate;
            $response["orderId"] = $result->orderId;
            $response["redirectUrl"] = $result->returnUrl;
            $response["amount"] = $result->amount;
            $response["amount"] = $result->amount;

            $billingFLName = $result->billingFLName;
            $billingPhone = $result->billingPhone;

            return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
        }else
        {

                   $response["statusmessage"] = "Transaction Failed.";
                   $response["reason"] = "Transaction Failed.";
                   $response["status"] = isset($result->status) ? $result->status : "99";
                   $response["transactionDate"] = date('Y-m-d H:i:s');
                   if(isset($result->merchantId))
                       $response["merchantId"] = $result->merchantId;
                   if(isset($result->deviceCode))
                       $response["deviceCode"] = $result->deviceCode;
                   if(isset($result->txnRef))
                   {
                       $response["transactionRef"] = $result->txnRef;
                       $response["txn_ref"] = $result->txnRef;
                        $response["txnRef"] = $result->txnRef;
                   }
                   if(isset($result->orderId))
                       $response["orderId"] = $result->orderId;
                   if(isset($result->returnUrl))
                       $response["redirectUrl"] = $result->returnUrl;
                   else
                       return \Redirect::to('/payments/init')->with('error', isset($result->message) ? $result->message : "Transaction Failed!");

                   return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
        }
    }


	public function getReversalRequests()
	{

		$filter = null;
		return view('core.authenticated.transactions.transaction_reversal_listing', compact('filter'));

	}


	public function getReversalPaymentDetails()
	{
		$input = \Input::all();
		//dd($input['description']);
		$dataForServer['requestUniqueId'] = $input['requestUniqueId'];
		$dataForServer['hash'] = $input['hash'];
		$dataForServer['merchantCode'] = $input['merchantCode'];
		$dataForServer['deviceCode'] = $input['deviceCode'];
		$dataForServer['amount'] = number_format($input['amount'], 2, '.', '');



		$result = handleSOAPCalls('getRequestReverseTransactionStatus', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/TransactionServices?wsdl', $dataForServer);

		return \Response::json($result);
	}

	public function confirmReversal($requestId)
	{
		$data = array();
		$data['requestId'] = $requestId;
        $data['token'] = \Auth::user()->token;
        $result = handleSOAPCalls('reverseTransaction', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/TransactionServices?wsdl', $data);
		//dd($result);

		if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 5000)
        {
            return \Redirect::back()->with('message', 'Transaction Reversal completed successfully');
        }else
        {
            return \Redirect::back()->with('error', 'Transaction Reversal requests fetch failed');
        }
	}


	public function getFundTransfersList()
    {
        $response = '';
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
        $transactions = null;
        if($authData->status==5000) {
            $accounts = $authData->accounts;
            $cards = $authData->cards;
        }
        else if($authData->status==-1) {
            return \Redirect::to('/auth/login')->with('warning', 'Login to continue');
        }


        $currencyList = array_keys(getAllCurrency());
        return view('core.authenticated.transactions.funds_transfers_listing', compact('response', 'cards', 'currencyList'));
    }



    public function getTransactionAdjustmentsList()
    {
        $response = '';
        return view('core.authenticated.transactions.adjustment_listing', compact('response'));
    }


    public function utilities_paid()
    {
        $response = '';
        return view('core.authenticated.transactions.utilities_paid', compact('response'));
    }

    
    public function loadBillingDetailsCaptureForCybersource($input)
    {
        $billIdEnc = $input;
        //dd($input);
        $input = \Crypt::decrypt($input);
        $billdata = \App\Models\BillData::where('id', '=', $input)->first();
        //dd([$billdata, $input]);
        $input = json_decode($billdata->data, TRUE);
        //dd($input);

        $paymentItems = is_string($input['paymentItem']) ? json_decode($input['paymentItem'], TRUE) : $input['paymentItem'];
        $itemAmounts = is_string($input['amount']) ? json_decode($input['amount'], TRUE) : $input['amount'];
        $currency = $input['currency'];
        $key = CYBERSOURCE_PAYMENT_INITIALIZE;
        $orderId = $input['orderId'];
        $amt = $input['total_amount'];

        $dataForServer['merchantCode'] = $input['merchantId'];
        $dataForServer['hash'] = $input['hash'];
        $dataForServer['deviceCode'] = $input['deviceCode'];
        $dataForServer['serviceTypeId'] = $input['serviceTypeId'];
        $dataForServer['orderId'] = $input['orderId'];
        $dataForServer['amount'] = number_format($amt, 2, '.', '');
        //$dataForServer['responseUrl'] = $input['responseurl'];
        $orderId = $input['orderId'];

        //$result = handleSOAPCalls('pullPaymentDefaultData', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/UtilityServices?wsdl', $dataForServer);

        //$result = handleSOAPCalls('listMerchants', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', $data);
//dd($dataForServer);
        $dataStr = "";
        foreach($dataForServer as $k => $v)
        {
            $dataStr = $dataStr."".$k."=".urlencode($v)."&";
        }
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/pullPaymentDefaultData';


        $authDataStr = sendGetRequest($url, $dataStr);
        //dd([$input, $authDataStr]);
        $result = json_decode($authDataStr);




        if(isset($result->status) && $result->status == 1000)
        {
            $fixedChargePerTransaction = $result->fixedChargePerTransaction;
            $percentagePerTransaction = $result->percentagePerTransaction;
            $all_countries = $result->all_countries;

            return view('guests.payment.cybersource.capture_payee_details', compact('billIdEnc',  'key', 'input', 'orderId', 'amt',
                'billdata', 'fixedChargePerTransaction', 'all_countries',
                'percentagePerTransaction','currency'));
        }
    }



    public function postCaptureCybersourceData(Request $request)
    {
        $all = $request->all();
        $input = $all;
        //dd($all);
        $data = \Crypt::decrypt($all['data']);
        $billdata = \App\Models\BillData::where('id', '=', $data)->first();
        $data = $billdata->data;
        $data = json_decode($data, TRUE);
        //dd([$all, $data]);
        $total = doubleVal($data['total_amount']);
        $jsonData = array(
            'amount' => (number_format($total, 2, '.', '')),
            'responseUrl' => $data['responseurl'],
            'orderId' => $input['orderId'],
            'hash' => $data['hash'],
            'merchantId' => $data['merchantId'],
            'deviceCode' => $data['deviceCode'],
            'serviceTypeId' => $data['serviceTypeId'],
            'firstName' => $input['firstName'],
            'lastName' => $input['lastName'],
            'countryCode' => $data['country_code'],
            'billPayeeMobile' => $input['payeeMobile'],
            'email' => $input['payeeEmail'],
            'streetAddress' => $input['streetAddress'],
            'city' => $input['city'],
            'country' => explode('###', $input['country'])[2],
            'district' => isset($input['district']) && sizeof(explode('_', $input['district']))>1 ? explode('_', $input['district'])[1] : "");
        if(isset($data['customdata']))
        {
            $jsonData['customdata'] = serialize($data['customdata']);
        }
        if(isset($data['currency']))
        {
            $jsonData['currency'] = $data['currency'];
        }

        $defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
        //dd($defaultAcquirer->toArray());
        if($defaultAcquirer==null)
        {
            return response()->json(['message' => 'Error encountered. ERR00AQ1', 'success'=>false], 200);
        }

        $defaultAcquirer = $defaultAcquirer->toArray();

        //dd($input);
        //dd($jsonData);
        $jsonData = \Crypt::encrypt(json_encode($jsonData));

        $jsonDataLump = array('txnDetail' => $jsonData);
        $jsonEncode = json_encode($jsonDataLump);
        //dd($jsonEncode);
        $base64 = base64_encode($jsonEncode);
        $dataForServer = array('transactionObject' => $base64,
            'acquirerCode' => $defaultAcquirer['acquirerCode']
            //, 'zicbAuthKey'=>$input['zicbAuthKey']
            //'merchantId' => $input['merchantId'],
            //'deviceCode' => $input['deviceCode']
        );

        $dataStr = "";
        foreach($dataForServer as $k => $v)
        {
            $dataStr = $dataStr."".$k."=".urlencode($v)."&";
        }



        //$result = handleSOAPCalls('initiateCyberSourcePayment', '', $dataForServer);
        $url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/PaymentServicesV2/initiateCyberSourcePaymentV2';
        $authDataStr = sendPostRequest($url, $dataStr);
        //dd([$input, $authDataStr]);
        $result = json_decode($authDataStr);
        //dd(\Crypt::decrypt($input['data']));
        //dd();
        //dd([$input, $data, $dataForServer, $result]);

        if (isset($result->status) && $result->status == 1002) {
            $signed_field_names = explode(',', $result->signed_field_names);
            $unsigned_field_names = explode(',', $result->unsigned_field_names);

            $result1 = json_decode($authDataStr, TRUE);

            //dd([$signed_field_names, $unsigned_field_names]);
            $dataToSend = [];
            foreach($signed_field_names as $sfn)
            {
                if(isset($result1[$sfn]))
                    $dataToSend[$sfn] = $result1[$sfn];
            }
            foreach($unsigned_field_names as $usfn)
            {
                if(isset($result1[$usfn]))
                    $dataToSend[$usfn] = $result1[$usfn];
            }



            $params = $dataToSend;
            $keysIndex = [];
            $keys = $signed_field_names;
            foreach($keys as $k)
            {
                if($k=='unsigned_field_names')
                {
                    //echo "111-".$params['unsigned_field_names'];
                }
                if(isset($params[$k]) && $params[$k]!=null)
                {
                    $keysIndex[$k] = $params[$k];
                }
                else
                {
                    if($params[$k]=="")
                        $keysIndex[$k] = "";
                }
            }


            $dataToSend['amount'] = number_format($dataToSend['amount'], 2, '.', '');

            if(sizeof($keys)>0 && sizeof($keys)==sizeof($keysIndex))
            {

            }
            else
            {
                return \Redirect::back()->with('error', 'Insufficient data provided. Consult the api docs for list of fields to be provided');
            }

            if(isset($result->switch_to_live) && $result->switch_to_live==1)
            {
                $bdSign = buildDataToSign($dataToSend);
                $params['signature'] = signData($bdSign, \UserConstants::$CYBERSOURCE_CONSTANT);
            }
            else if(isset($result->switch_to_live) && $result->switch_to_live==0)
            {
                $bdSign = buildDataToSign($dataToSend);
                $params['signature'] = signData($bdSign, \UserConstants::$DEMO_CYBERSOURCE_CONSTANT);
            }

            $params['amount'] = number_format($params['amount'], 2, '.', '');
            $params['signed_date_time'] = gmdate("Y-m-d\TH:i:s\Z");
            $cyber_url = $result1['cybersource_url'];
			return view('guests.payment.cybersource.forward', compact('params', 'cyber_url'));
            return view('guests.payment.cybersource.capture_payee_details', compact('billIdEnc',  'key', 'input', 'orderId', 'amt',
                'billdata', 'fixedChargePerTransaction', 'all_countries',
                'percentagePerTransaction','currency'));
        }
    }

    public function postConfirmCybersourceData(Request $request)
    {
        $params = $request->all();
        return view('guests.payment.cybersource.confirm_payee_details', compact('params'));
    }

    public function loadPaymentDetailsViewForCybersource($key, $input)
    {
        $billIdEnc = $input;
        //dd($input);
        $input = \Crypt::decrypt($input);
        $billdata = \App\Models\BillData::where('id', '=', $input)->first();
        //dd([$billdata, $input]);
        $input = json_decode($billdata->data, TRUE);

        //dd($input);
        \Session::remove('error');
        \Session::remove('message');
        if(isset($input['sessionContainer']))
        {
            if(isset($input['sessionContainer']['error']))
                \Session::put('error', $input['sessionContainer']['error']);
            elseif(isset($input['sessionContainer']['message']))
                \Session::put('message', $input['sessionContainer']['message']);

            unset($input['sessionContainer']);
            $billdata->data = json_encode($input);
            $billdata->save();
        }
        $paymentItems = is_string($input['paymentItem']) ? json_decode($input['paymentItem'], TRUE) : $input['paymentItem'];
        $itemAmounts = is_string($input['amount']) ? json_decode($input['amount'], TRUE) : $input['amount'];
        $currency = $input['currency'];
        //dd($currency);

        $bank_count = isset($input['bank_count']) ? $input['bank_count'] : null;
        $bank_options = [];
        for($x1=1; $x1<($bank_count+1); $x1++)
        {
            $index1 = 'bank_code_'.$x1;
            $bank_code = $input[$index1];
            array_push($bank_options, $bank_code);
        }

        $amt = 0;


        if(sizeof($paymentItems)>0 && sizeof($paymentItems)==sizeof($itemAmounts)) {
            for ($i = 0; $i < sizeof($itemAmounts); $i++) {
                $amt = $amt + $itemAmounts[$i];
            }

            //dd(11);
            $dataForServer['merchantCode'] = $input['merchantId'];
            $dataForServer['hash'] = $input['hash'];
            $dataForServer['deviceCode'] = $input['deviceCode'];
            $dataForServer['serviceTypeId'] = $input['serviceTypeId'];
            $dataForServer['orderId'] = $input['orderId'];
            $orderId = $input['orderId'];
            $dataForServer['amount'] = number_format($amt, 2, '.', '');
            //$dataForServer['responseUrl'] = $input['responseurl'];
            $orderId = $input['orderId'];

            //$result = handleSOAPCalls('pullPaymentDefaultData', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/UtilityServices?wsdl', $dataForServer);

            //$result = handleSOAPCalls('listMerchants', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', $data);
//dd($dataForServer);
            $dataStr = "";
            foreach($dataForServer as $k => $v)
            {
                $dataStr = $dataStr."".$k."=".urlencode($v)."&";
            }
            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/pullPaymentDefaultData';


            $authDataStr = sendGetRequest($url, $dataStr);
            //dd([$input, $authDataStr]);
            $result = json_decode($authDataStr);



            if(isset($result->status) && $result->status == 1000)
            {




                $key = CYBERSOURCE_PAYMENT_INITIALIZE;


                $fixedChargePerTransaction = $result->fixedChargePerTransaction;
                $percentagePerTransaction = $result->percentagePerTransaction;


                /*$input = $billIdEnc;
                $newInput = $input;
                return view('guests.payment.cybersource.payment_details_view', compact('newInput',  'key', 'input', 'orderId', 'amt',
                                                    'paymentItems', 'itemAmounts', 'fixedChargePerTransaction', 'billIdEnc',
                                                    'percentagePerTransaction','currency'));*/

                //$all = $request->all();
                //$input = $all;
                //dd([$all, $data]);
                $total = doubleVal($input['total_amount']);
                $jsonData = array(
                    'amount' => (number_format($total, 2, '.', '')),
                    'responseUrl' => $input['responseurl'],
                    'orderId' => $input['orderId'],
                    'hash' => $input['hash'],
                    'merchantId' => $input['merchantId'],
                    'deviceCode' => $input['deviceCode'],
                    'serviceTypeId' => $input['serviceTypeId'],
                    'country' => $input['country_code']
                );
                if(isset($input['customdata']))
                {
                    $customData = [];
                    $customData['billDataId'] = $billdata->id;
                    $customData['customdata'] = $input['customdata'];
                    $jsonData['customdata'] = serialize($customData);
                }
                else
                {
                    
                    $customData = [];
                    $customData['billDataId'] = $billdata->id;
                    $jsonData['customdata'] = serialize($customData);
                }
                if(isset($input['currency']))
                {
                    $jsonData['currency'] = $input['currency'];
                }

                $defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
                //dd($defaultAcquirer->toArray());
                if($defaultAcquirer==null)
                {
                    return response()->json(['message' => 'Error encountered. ERR00AQ1', 'success'=>false], 200);
                }

                $defaultAcquirer = $defaultAcquirer->toArray();

                //dd($input);
                //dd($jsonData);
                $jsonData = \Crypt::encrypt(json_encode($jsonData));

                $jsonDataLump = array('txnDetail' => $jsonData);
                $jsonEncode = json_encode($jsonDataLump);
                //dd($jsonEncode);
                $base64 = base64_encode($jsonEncode);
                $dataForServer = array('transactionObject' => $base64,
                    'acquirerCode' => $defaultAcquirer['acquirerCode']
                    //, 'zicbAuthKey'=>$input['zicbAuthKey']
                    //'merchantId' => $input['merchantId'],
                    //'deviceCode' => $input['deviceCode']
                );

                $dataStr = "";
                foreach($dataForServer as $k => $v)
                {
                    $dataStr = $dataStr."".$k."=".urlencode($v)."&";
                }



                //$result = handleSOAPCalls('initiateCyberSourcePayment', '', $dataForServer);
                $url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/PaymentServicesV2/initiateCyberSourcePaymentV2';
                $authDataStr = sendPostRequest($url, $dataStr);
                //dd([$input, $authDataStr]);
                $result = json_decode($authDataStr);
                //dd($result);
                //dd(\Crypt::decrypt($input['data']));
                //dd([$input, $dataForServer, $result]);

                if (isset($result->status) && $result->status == 1002) {
                    $signed_field_names = explode(',', $result->signed_field_names);
                    $unsigned_field_names = explode(',', $result->unsigned_field_names);

                    $result1 = json_decode($authDataStr, TRUE);

                    //dd([$signed_field_names, $unsigned_field_names]);
                    $dataToSend = [];
                    foreach($signed_field_names as $sfn)
                    {
                        if(isset($result1[$sfn]))
                            $dataToSend[$sfn] = $result1[$sfn];
                    }
                    foreach($unsigned_field_names as $usfn)
                    {
                        if(isset($result1[$usfn]))
                            $dataToSend[$usfn] = $result1[$usfn];
                    }



                    $params = $dataToSend;
                    $keysIndex = [];
                    $keys = $signed_field_names;
                    foreach($keys as $k)
                    {
                        if($k=='unsigned_field_names')
                        {
                            //echo "111-".$params['unsigned_field_names'];
                        }
                        if(isset($params[$k]) && $params[$k]!=null)
                        {
                            $keysIndex[$k] = $params[$k];
                        }
                        else
                        {
                            if($params[$k]=="")
                                $keysIndex[$k] = "";
                        }
                    }


                    $dataToSend['amount'] = number_format($dataToSend['amount'], 2, '.', '');

                    if(sizeof($keys)>0 && sizeof($keys)==sizeof($keysIndex))
                    {

                    }
                    else
                    {
                        return \Redirect::back()->with('error', 'Insufficient data provided. Consult the api docs for list of fields to be provided');
                    }

                    if(isset($result->switch_to_live) && $result->switch_to_live==1)
                    {
                        $bdSign = buildDataToSign($dataToSend);
                        $params['signature'] = signData($bdSign, \UserConstants::$CYBERSOURCE_CONSTANT);
                    }
                    else if(isset($result->switch_to_live) && $result->switch_to_live==0)
                    {
                        $bdSign = buildDataToSign($dataToSend);
                        $params['signature'] = signData($bdSign, \UserConstants::$DEMO_CYBERSOURCE_CONSTANT);
                    }

                    $params['amount'] = number_format($params['amount'], 2, '.', '');
                    $params['signed_date_time'] = gmdate("Y-m-d\TH:i:s\Z");
                    //dd($params);
                    $cyber_url = $result1['cybersource_url'];
                    return view('guests.payment.cybersource.forward', compact('params', 'cyber_url', 'orderId'));
                    return view('guests.payment.cybersource.capture_payee_details', compact('billIdEnc',  'key', 'input', 'orderId', 'amt',
                        'billdata', 'fixedChargePerTransaction', 'all_countries',
                        'percentagePerTransaction','currency'));
                }
                else
                {
                    $data = \Crypt::encrypt($result);
                    return \Redirect::to('/ajax-pay-from-cybersource-failed.html/'.CYBERSOURCE_PAYMENT_FAILED.'/'.$data);
                }


            }
            else
            {
                $response["statusmessage"] = isset($result->message) ? $result->message : "System Error";
                $response["reason"] = isset($result->message) ? $result->message : "System Error";
                $response["merchantId"] = $input['merchantId'];
                $response["deviceCode"] = $input['deviceCode'];
                $response["status"] = isset($result->status) ? $result->status : '99';
                $response["transactionDate"] = date('Y-m-d H:i:s');
                $response["orderId"] = $input['orderId'];
                //$response["redirectUrl"] = $input['responseurl'];
                //dd($response);
                return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
            }
        }
        else{
            //dd(22);
            $response["statusmessage"] = "Invalid Dataset";
            $response["reason"] = "Invalid Dataset Provided. Parameters Provided are Incomplete";
            $response["merchantId"] = $input['merchantId'];
            $response["deviceCode"] = $input['deviceCode'];
            $response["status"] = '12';
            $response["transactionDate"] = date('Y-m-d H:i:s');
            $response["orderId"] = $input['orderId'];
            $response["redirectUrl"] = $input['responseurl'];
            //dd($response);
            return view('guests.payment.web.eagle_card_payment_final_route', compact('response'));
        }
    }
	
	
	public function deviceStatements(Request $request)
	{
		$all = $request->all();
		$startDate = $all['startDate'];
		$endDate = $all['endDate'];
		$deviceCode = $all['deviceCode'];
		$merchantCode = $all['merchantCode'];	
		
		$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
		//dd($defaultAcquirer->toArray());
		if($defaultAcquirer==null)
		{
			return response()->json(['message' => 'Error encountered. ERR00AQ1', 'status'=>0], 200);
		}

		$defaultAcquirer = $defaultAcquirer->toArray();
				
				
		$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/TransactionServicesV2/getMerchantStatementFromBank';
		$dataStr = "deviceCode=".$deviceCode."&startPeriod=".$startDate."&endPeriod=".$endDate."&acquirerCode=".$defaultAcquirer['acquirerCode'];
		$authDataStr = sendGetRequest($url, $dataStr);
		//dd([$input, $authDataStr]);
		$result = json_decode($authDataStr);
		//dd($result);
		//dd(\Crypt::decrypt($input['data']));
		//dd([$input, $dataForServer, $result]);

		if (isset($result->status) && $result->status == 5000) {
			$transactions = $result->transactions;
			$transactions = json_decode($transactions);
			return response()->json(['transactions' => $transactions, 'status'=>1], 200);
		}
		else
		{
			return response()->json(['message' => 'Statement could not be pulled', 'status'=>0], 200);
		}
	}


	public function makeSettlement(Request $request)
	{
		try{
			$deviceCode = $request->get('deviceCode');
			$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
			//dd($defaultAcquirer->toArray());
			if($defaultAcquirer==null)
			{
				return response()->json(['message' => 'Error encountered. ERR00AQ1', 'status'=>0], 200);
			}

			$defaultAcquirer = $defaultAcquirer->toArray();
					
					
			$url = 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/TransactionServicesV2/getMakeDeviceSettlement';
			$dataStr = "deviceCode=".$deviceCode."&acquirerCode=".$defaultAcquirer['acquirerCode'];
			$authDataStr = sendGetRequest($url, $dataStr);
			dd([$authDataStr]);
			$result = json_decode($authDataStr);

			dd($result);
			//dd(\Crypt::decrypt($input['data']));
			//dd([$input, $dataForServer, $result]);

			if (isset($result->status) && $result->status == 5000) {
				$settlementList = $result->settlementList;
				$settlementList = json_decode($settlementList);
				$transactions = ($result->transactions);
				$startDate = $result->startPeriod;
				$endDate = $result->endPeriod;
				return response()->json(['settlementList' => $settlementList, 'transactions' => $transactions, 'startDate' => $startDate, 'endDate' => $endDate, 'status'=>1], 200);
			}
			else if (isset($result->status) && $result->status == 5001) {
				return response()->json(['status'=>0, 'message'=>$result->message], 200);
			}
			else
			{
				return response()->json(['message' => 'Statement could not be pulled', 'status'=>0], 200);
			}
		}
		catch(\Exception $e)
		{
			dd($e);
		}
	}


	public function loadTokenizeOtpView($key, $input, $transactionRef, $otpRec)
	{
       	$sessionContainer = [];
       	if(\Session::has('error') || \Session::has('message'))
       	{
           		$sessionError = \Session::get('error');
           		$sessionMessage = \Session::get('message');
           		$sessionContainer['error'] = $sessionError;
           		$sessionContainer['message'] = $sessionMessage;
       	}

        	$billId = \Crypt::decrypt($input);
       	$billData = \App\Models\BillData::where('id', '=', $billId)->first();
        	$token = $billData->token_data;
        	$billData = $billData->data;
        	$billData = json_decode($billData, TRUE);
		//dd($billData);
       	return view('guests.payment.web.tokenize_bevura_pay_otp_confirm', compact('token', 'billData', 'input', 'transactionRef', 'otpRec' ));

	}

}

