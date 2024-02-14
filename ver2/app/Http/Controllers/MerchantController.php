<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use Illuminate\Contracts\Auth\Guard;
use JWTAuth;

class MerchantController extends Controller
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

	public function getUSSDEmulator(Request $request)
	{
		return response()->view('core.guest.emulator', compact('request'));

	}

    public function getIndexApi()
    {
        return response()->json([
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => \Auth::user()
        ]);
    }


	public function getSendUssdRequest(Request $request)
	{
		$mobileNumber = $request->get('MOBILE_NUMBER');
		$sessionId = $request->get('SESSION_ID');
		$ussdBody = $request->get('USSD_BODY');
		$serviceKey = $request->get('SERVICE_KEY');
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/USSDServicesV2/ussd';
		$data = 'MOBILE_NUMBER='.$mobileNumber.'&SESSION_ID='.$sessionId.'&USSD_BODY='.urlencode($ussdBody).'&SERVICE_KEY='.urlencode($serviceKey);
		$server_output = sendGetRequest($url, $data);
		//dd($data);
		return response()->json(['Message' => $server_output, 'key'=>'CON'], 200);
	}


    /*public function checkIfMerchantExists(Request $request, $merchantCompanyName, $merchantCompanyId=NULL)
	{
		$token = $request->bearerToken();
		$user = JWTAuth::toUser($token);
		dd(\Session::all());
		dd(JWTAuth::parseToken()->authenticate());

		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/MerchantServices/getMerchantByMerchantName';
		$data = 'merchantCompanyName='.$merchantCompanyName.'&token='.\Auth::user()->token;
		if($merchantCompanyId!=null)
			$data = $data."&merchantCompanyId=".$merchantCompanyId;
		$server_output = sendGetRequest($url, $data);
		//dd($server_output);
		return response()->json(['Message' => $server_output, 'key'=>$token], 200);
	}*/

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

    public function getNewMerchant(Request $request)
    {
        $data = $request->all();
        //$session = json_decode(\Session::all());
        //dd([\Auth::user(), \Session::all()]);
        //$data = (\Auth::user()->id);

        //dd($this->countries);
		/*$data = json_decode($data, TRUE);
		$countries = json_decode($data['all_countries']);
		$all_banks = json_decode($data['all_banks']);
		$all_device_types = json_decode($data['all_device_types']);
		$all_merchant_schemes = json_decode($data['all_merchant_schemes']);*/



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
        return response()->view('core.authenticated.merchant.new_merchant_step_1', compact('breadcrumbs', 'request'));
    }


    public function getViewMerchant(Request $request, $id=NULL)
    {
        return view('core.authenticated.merchant.view_merchant', compact('request'));
    }

    public function getNewMerchantStepTwo()
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

        return view('core.authenticated.merchant.new_merchant_step_2', compact('data', 'all_merchant_schemes',
            'all_device_types', 'all_card_schemes', 'all_provinces', 'all_banks'));
    }



    public function getNewMerchantStepThree()
    {
        $data = \Session::get('data');
        $user = \Auth::user();
        $deviceType = \Crypt::decrypt($data)['deviceType'];
        $all_device_types = json_decode($user->all_device_types);
        return view('core.authenticated.merchant.new_merchant_step_3', compact('data', 'all_device_types', 'deviceType'));
    }

    public function postNewMerchantStepThree()
    {

        $data = \Input::except('data');
        if(strlen($data['zicbAuthKey'])>0 && strlen($data['zicbServiceKey'])>0)
        {

        }
        else
        {
            if(strlen($data['zicbAuthKey'])>0 || strlen($data['zicbServiceKey'])>0)
            {
                return \Redirect::back()->withInput()->with('error', 'If you have valid ZICB credentials, you must provide both the authorized key and the service key');
            }
        }

        $data1 = \Crypt::decrypt(\Input::get('data'));
        $data = $data + $data1;

        $data = \Crypt::encrypt($data);
        \Session::put('data', $data);
        return \Redirect::to('/potzr-staff/merchants/new-merchant-step-four');
    }

    public function getNewMerchantStepFour()
    {
        $data = \Session::get('data');
        $user = \Auth::user();
        $all_banks = json_decode($user->all_banks);
        $all_merchant_schemes = json_decode($user->all_merchant_schemes);
        $all_device_types = json_decode($user->all_device_types);
        $all_card_schemes = json_decode($user->all_card_schemes);
        $all_provinces = json_decode($user->all_provinces);
        $dataView = \Crypt::decrypt($data);

        $merchantScheme = explode('_', $dataView['merchantScheme'])[0];
        $merchantScheme = ($all_merchant_schemes[$merchantScheme]->schemename);

        $merchantBank = explode('_', $dataView['merchantBank'])[0];
        $merchantBank = ($all_banks[$merchantBank]->bankName);


        //dd($all_device_types);
        $deviceType = ($all_device_types->$dataView['deviceType']);

        $arrayKeys = array_keys($dataView);

        //dd(json_decode($all_banks));
        return view('core.authenticated.merchant.new_merchant_step_4', compact('data', 'all_merchant_schemes',
            'all_device_types', 'all_card_schemes', 'all_provinces', 'all_banks', 'dataView',
            'merchantScheme', 'merchantBank', 'deviceType', 'arrayKeys'));
    }


    public function postNewMerchantStepFour()
    {
        $data_ = \Input::get('data');
        $dataForm = \Crypt::decrypt($data_);
        //dd($dataForm);
        $user = \Auth::user();
        $all_banks = json_decode($user->all_banks);
        $all_merchant_schemes = json_decode($user->all_merchant_schemes);
        $all_device_types = json_decode($user->all_device_types);
        $all_card_schemes = json_decode($user->all_card_schemes);
        $all_provinces = json_decode($user->all_provinces);

        $data['merchantCode'] = strtoupper(str_random(10));
        $data['operationCountry'] = $dataForm['operationCountry'];
        $data['addressLine1'] = $dataForm['addressLine1'];
        $data['addressLine2'] = $dataForm['addressLine2'];
        $data['altContactEmail'] = $dataForm['altEmail'];
        $data['altContactMobile'] = $dataForm['altcountrycode']."".$dataForm['altMobileNo'];
        $data['bankAccount'] = $dataForm['bankAccountNo'];
        $data['bankAccountName'] = $dataForm['bankAccountName'];
        $data['bankBranchCode'] = $dataForm['bankBranchCode'];
        $data['certificateOfIncorporation'] = $dataForm['companyCertificate'];
        $data['companyData'] = $dataForm['companyLogo'];
        $data['companyLogo'] = $dataForm['companyLogo'];
        $data['companyName'] = $dataForm['companyName'];
        $data['companyRegNo'] = $dataForm['companyRegNo'];
        $data['contactEmail'] = $dataForm['email'];
        $data['contactMobile'] = $dataForm['countrycode']."".$dataForm['mobileNo'];
        $data['merchantBankId'] = explode('_', $dataForm['merchantBank'])[1];
        $data['merchantName'] = $dataForm['companyName'];
        $data['merchantSchemeId'] = explode('_', $dataForm['merchantScheme'])[1];
        $data['deviceType'] = $all_device_types->$dataForm['deviceType'];
        $data['domainUrl'] = $dataForm['domainURL'];
        $data['forwardSuccessUrl'] = $dataForm['forwardSuccess'];
        $data['forwardFailureUrl'] = $dataForm['forwardFail'];
        $data['deviceCode'] = strtoupper(str_random(8));
        $data['deviceSerialNo'] = strtoupper(str_random(8));
        $data['notifyEmail'] = $dataForm['notifyEmail'];
        $data['notifyMobile'] = $dataForm['notifycountrycode']."".$dataForm['notifyMobile'];
        $contactPerson = explode(' ', $dataForm['contactPerson']);
        $data['firstName'] = sizeof($contactPerson)>0 ? $contactPerson[0] : "";
        $data['lastName'] = sizeof($contactPerson)>1 ? $contactPerson[1] : "";
        $data['otherName'] = sizeof($contactPerson)>2 ? $contactPerson[2] : "";
        $data['autoReturnToMerchantSite'] = true;
        $data['token'] = \Auth::user()->token;
        if(isset($dataForm['zicbAuthKey']) && strlen($dataForm['zicbAuthKey'])>0 && isset($dataForm['zicbServiceKey']) && strlen($dataForm['zicbServiceKey'])>0)
        {
            $data['zicbAuthKey'] = $dataForm['zicbAuthKey'];
            $data['zicbServiceKey'] = $dataForm['zicbServiceKey'];
        }

        if(isset($dataForm['cybersourceLiveAccessKey']) && strlen($dataForm['cybersourceLiveAccessKey'])>0 &&
            isset($dataForm['cybersourceLiveProfileId']) && strlen($dataForm['cybersourceLiveProfileId'])>0 &&
            isset($dataForm['cybersourceLiveSecretKey']) && strlen($dataForm['cybersourceLiveSecretKey'])>0 &&
            isset($dataForm['cybersourceDemoAccessKey']) && strlen($dataForm['cybersourceDemoAccessKey'])>0 &&
            isset($dataForm['cybersourceDemoProfileId']) && strlen($dataForm['cybersourceDemoProfileId'])>0 &&
            isset($dataForm['cybersourceDemoSecretKey']) && strlen($dataForm['cybersourceDemoSecretKey'])>0)
        {
            $data['cybersourceLiveAccessKey'] = $dataForm['cybersourceLiveAccessKey'];
            $data['cybersourceLiveProfileId'] = $dataForm['cybersourceLiveProfileId'];
            $data['cybersourceLiveSecretKey'] = $dataForm['cybersourceLiveSecretKey'];
            $data['cybersourceDemoAccessKey'] = $dataForm['cybersourceDemoAccessKey'];
            $data['cybersourceDemoProfileId'] = $dataForm['cybersourceDemoProfileId'];
            $data['cybersourceDemoSecretKey'] = $dataForm['cybersourceDemoSecretKey'];
        }

        if(isset($dataForm['ubaServiceKey']) && strlen($dataForm['ubaServiceKey'])>0 && isset($dataForm['ubaMerchantId']) && strlen($dataForm['ubaMerchantId'])>0)
        {
            $data['ubaServiceKey'] = $dataForm['ubaServiceKey'];
            $data['ubaMerchantId'] = $dataForm['ubaMerchantId'];
        }

        //dd($data);

        $result = handleSOAPCalls('createNewMerchant', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', $data);

        //dd($result);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 200 || $result->status == 223)
        {
            $merchantCode = $result->merchantCode;
            $deviceCode = $result->deviceCode;
            $password = $result->password;
            $contactMobile = $result->contactMobile;

            $msg = "New Merchant Account Created successfully. \nMerchant Code: ".$merchantCode."\nDevice Code: ".$deviceCode."\nPassword: ".$password."\nThank You.";
            send_sms($contactMobile, $msg);

            \Session::forget('data');
            return redirect('/potzr-staff/merchants/new-merchant')->with('message', 'New Merchant Account Created Successfully');
        }else
        {
            return \Redirect::back()->with('error', 'New Merchant Account Creation Failed');
        }

    }

    public function getViewMerchantAccount($merchantId)
    {
        $result = handleSOAPCalls('getMerchantAccount', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', [
            'merchantId' => \Crypt::encrypt(intval($merchantId)),
            'token' => \Auth::user()->token,
        ]);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }
        $merchant = json_decode($result->merchant);
        //dd($merchant);
        return view('core.authenticated.merchant.view_profile', compact('merchant'));
    }

    public function getAddMerchantAccount($merchantId)
    {
        $result = handleSOAPCalls('getMerchantAccount', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', [
            'merchantId' => \Crypt::encrypt(intval($merchantId)),
            'token' => \Auth::user()->token,
        ]);
        $user = \Auth::user();
        $all_banks = json_decode($user->all_banks);
        $merchant = json_decode($result->merchant);
        //dd($merchant);

        return view('core.authenticated.merchant.new_merchant_bank_account', compact('all_banks', 'merchant', 'merchantId'));
    }

    public function postAddMerchantAccount()
    {

        $input = \Input::all();
        //dd($input);
        //$data = $input['data'];
        $data['bankAccount'] = $input['bankAccountNo'];
        $data['bankId'] = $input['merchantBank'];
        $data['bankAccountName'] = $input['bankAccountName'];
        $data['bankBranchCode'] = $input['bankBranchCode'];
        $data['merchantId'] = ($input['data']);
        $data['token'] = \Auth::user()->token;
        //dd($data);

        $result = handleSOAPCalls('createNewMerchantBankAccount', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', $data);

        //dd($result);
        return \Redirect::to('/potzr-staff/merchants/merchant-listing');
    }


    public function updateMerchantStatus($merchantId, $status)
    {
        $data = [
            'merchantId' => (intval($merchantId)),
            'status' => ($status=='enable' ? 'ACTIVE' : 'DISABLED'),
            'token' => \Auth::user()->token,
        ];
	$dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }

	 $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/MerchantServicesV2/updateMerchantStatus';
        $authDataStr = sendPostRequest($url, $dataStr );
        $result = json_decode($authDataStr);
//dd($data);
        if($result->status==-1)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }
	 else if($result->status==220)
        {
            return \Redirect::back()->with('message', 'Merchant Status Updated successfully');
        }
        //dd($merchant);
        return \Redirect::back()->with('error', isset($result->message) ? $result->message :  'Merchant Status Not updated');
    }


    public function getMerchantListing()
    {


        return view('core.authenticated.merchant.merchant_listing');
    }


    public function getMerchantBankAccountListing($merchantId=NULL)
    {

        $data['token'] = \Auth::user()->token;
        if($merchantId!=null)
        {
            $data['$merchantId'] = \Crypt::encrypt(intval($merchantId));
        }
        $result = handleSOAPCalls('listMerchantBankAccounts', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', $data);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        $merchantBankAccountList = json_decode($result->merchantBankAccountList);
        return view('core.authenticated.merchant.merchant_bank_account_listing', compact('merchantBankAccountList'));
    }


    public function getUpdateMerchantAccountStepOne(Request $request, $merchantId)
    {

        //$result = handleSOAPCalls('getMerchantAccount', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', );
	try {
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/MerchantServicesV2/getMerchantById';

		$data = [
       	     'token' => \Auth::user()->token,
       	     'merchantId' => (($merchantId)),
        	];

		$dataStr = "";
		foreach($data as $d => $k)
		{
			$dataStr = $d."=".urlencode($k)."&".$dataStr;
		}
//dd($url."?".$dataStr);
		$result = sendGetRequest($url, $dataStr);

		$result = json_decode($result);

        	if($result->status==-1)
		{
            		return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        	}
		$merchantBankAccount = $result->merchantBankAccount;
        	$merchant = ($result->merchant);

        
            	return view('core.authenticated.merchant.update_profile_step_1', compact('merchant', 'merchantId', 'request', 'merchantBankAccount'));
        }
	 catch(\ErrorException $e)
        {
            dd($e);
        }
    }

    public function getUpdateMerchantAccountStepTwo()
    {

        $user = \Auth::user();
        $all_banks = json_decode($user->all_banks);
        $all_merchant_schemes = json_decode($user->all_merchant_schemes);
        $data = \Session::get('data');
        $data1 = \Crypt::decrypt($data);
        $merchant = $data1['mzcht'];



        return view('core.authenticated.merchant.update_merchant_step_2', compact('all_merchant_schemes', 'all_banks', 'merchant', 'data'));

    }


    public function postUpdateMerchantAccountStepOne()
    {

        $data = \Input::except('companyLogo', 'companyCertificate', 'merchantId', 'mzcht');
        $dest = 'merchants/bio-data/';
        $file_logo = \Input::hasFile('companyLogo') ? \Input::file('companyLogo') : null;
        $file_name_logo = $file_logo==null ? null : str_random(25) . '.' . $file_logo->getClientOriginalExtension();
        $file_cert = \Input::hasFile('companyCertificate') ? \Input::file('companyCertificate') : null;
        $file_name_cert = $file_cert==null ? null : str_random(25) . '.' . $file_cert->getClientOriginalExtension();

        if ($file_logo!=null && $file_logo->move($dest, $file_name_logo)) {

        }else{
            if(\Input::hasFile('companyLogo')) {
                return \Redirect::back()->with('error', 'Company logo could not uploaded');
            }
        }

        if ($file_cert!=null && $file_cert->move($dest, $file_name_cert)) {

        }else
        {
            if(\Input::hasFile('companyCertificate')) {
                return \Redirect::back()->with('error', 'Certificate of incorporation could not uploaded');
            }
        }
        //$data = $data->except(['companyLogo', 'companyCertificate']);
        if($file_logo!=null)
            $data['companyLogo'] = $file_name_logo;
        if($file_cert!=null)
            $data['companyCertificate'] = $file_name_cert;


        $data['mzcht'] = \Crypt::decrypt(\Input::get('mzcht'));
        $data['merchantId'] = \Crypt::decrypt(\Input::get('merchantId'));

        $data = \Crypt::encrypt($data);
        \Session::put('data', $data);

        return \Redirect::to('/potzr-staff/merchants/update-merchant-account/step-two');
    }



    public function postUpdateMerchantAccountStepTwo()
    {
        $data = \Input::except('data');
        $data1 = \Session::get('data');
        $data1 = \Crypt::decrypt($data1);
        $dataForm = $data1 + $data;

        $user = \Auth::user();
        $all_banks = json_decode($user->all_banks);
        $all_merchant_schemes = json_decode($user->all_merchant_schemes);
        $all_device_types = json_decode($user->all_device_types);
        $all_card_schemes = json_decode($user->all_card_schemes);
        $all_provinces = json_decode($user->all_provinces);

        $data = array();
        $data['addressLine1'] = $dataForm['addressLine1'];
        $data['addressLine2'] = $dataForm['addressLine2'];
        $data['altContactEmail'] = $dataForm['altEmail'];
        $data['altContactMobile'] = $dataForm['altMobileNo'];
        $data['bankAccount'] = $dataForm['bankAccountNo'];
        if(in_array('companyCertificate', array_keys($dataForm)))
            $data['certificateOfIncorporation'] = $dataForm['companyCertificate'];

        if(in_array('companyLogo', array_keys($dataForm))) {
            $data['companyLogo'] = $dataForm['companyLogo'];
            $data['companyData'] = $dataForm['companyLogo'];
        }
        $data['companyRegNo'] = $dataForm['companyRegNo'];
        $data['contactMobile'] = $dataForm['countrycode']."".$dataForm['mobileNo'];
        $data['merchantBankId'] = explode('_', $dataForm['merchantBank'])[1];
        $data['merchantSchemeId'] = explode('_', $dataForm['merchantScheme'])[1];
        $data['merchantId'] = \Crypt::encrypt($dataForm['merchantId']);
        $data['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('createNewMerchant', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', $data);

        //dd($result);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 200 || $result->status == 223)
        {
            $mobile = $dataForm['mobileNo'];
            $pswd = $result->password;
            $deviceCode = $result->deviceCode;
            $merchantCode = $result->merchantCode;
            $msg = "Merchant Account Updated successfully. \nMerchant Code: ".$merchantCode."\nDevice Code: ".$deviceCode."\n\nThank You.";
            send_sms($mobile, $msg);
            \Session::forget('data');
            return redirect('/potzr-staff/merchants/new-merchant')->with('message', 'New Merchant Account Updated Successfully');
        }else
        {
            return \Redirect::back()->with('error', 'New Merchant Account Updated Failed');
        }
    }


    public function getViewMerchantTransactions($merchantId=NULL)
    {

        return view('core.authenticated.transactions.merchant_transaction_listing', compact('merchantId'));
    }


    public function getViewMerchantDevices($merchantId=NULL)
    {
        //dd($merchantId);
        //dd(\Crypt::decryptPseudo($merchantId, \Auth::user()->merchant_dec_key));
        return view('core.authenticated.device.device_listing', compact('merchantId'));

    }

    public function getAddMerchantDevice(Request $request, $merchantId=NULL, $deviceId=NULL)
    {
        $data['status'] = 'ACTIVE';
        $data['token'] = \Auth::user()->token;
        //$result = handleSOAPCalls('listMerchants', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', $data);
        $data = 'token='.\Auth::user()->token;
        if($deviceId!=null)
            $data = $data.'&deviceId='.$deviceId;
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/MerchantServicesV2/listMerchantsV2';
        $authDataStr = sendGetRequest($url, $data);
        $authData = json_decode($authDataStr);


        if(isset($authData->status) && $authData->status!=null && $authData->status == -1) {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($authData->status == 210) {
            $merchantList = ($authData->merchantlist);

            //dd($merchantList);

            if($deviceId!=NULL) {
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/DeviceServicesV2/getADevice';
                $data = array();
                $data['token'] = \Auth::user()->token;
                $data['deviceId'] = $deviceId;
                $data = 'token='.\Auth::user()->token.'&deviceId='.$deviceId;
                $authDataStr = sendGetRequest($url, $data);
                $authData = json_decode($authDataStr);

                if(isset($authData->status) && $authData->status!=null && $authData->status == -1) {
                    return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
                }


                if ($authData->status == 710) {
                    $device = ($authData->device);
                    return view('core.authenticated.device.new_device', compact('merchantList', 'merchantId', 'device', 'deviceId', 'request'));
                }
            }else
            {
                //if($merchantId!=NULL)
                //    $merchantId = \Crypt::decrypt($merchantId);

                return view('core.authenticated.device.new_device', compact('merchantList', 'merchantId', 'request'));
            }
        }else
        {
            return \Redirect::back()->with('error', 'Error encountered pulling merchant list');
        }
    }



    public function getMerchantTransactions($merchantIdS)
    {

        $data = array();
        $data['token'] = \Auth::user()->token;

        if($merchantIdS!=NULL)
        {
            $data['merchantIdS'] = $merchantIdS;
        }
        $result = handleSOAPCalls('listTransactions', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/TransactionServices?wsdl', $data);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 410)
        {
            $transactionList = json_decode($result->transactionList);

            $merchant = json_decode($result->merchant);

            return view('core.authenticated.transactions.transaction_listing', compact('transactionList', 'merchant'));
        }else
        {
            return \Redirect::back()->with('error', 'Device transactions fetch failed');
        }
    }


}
