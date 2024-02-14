<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Encryption\Encrypter;
use Redirect;
use Illuminate\Support\Str;

class UserController extends Controller
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


    public function getRegister()
    {
        $role = new \App\Models\Roles();
        $rolesList = $role->getAdminCreationRolesList();
        $user = \Auth::user();


        $all_banks = json_decode($user->all_banks);
        $all_provinces_ = json_decode($user->all_provinces);
	$all_countries = json_decode($user->all_countries);
        $all_provinces = array();

        foreach($all_provinces_ as $province)
            $all_provinces[$province->id] = $province->provinceName;



        return view('core.authenticated.admin_user.new_admin_staff', compact('rolesList', 'all_provinces', 'all_banks', 'all_countries'));
    }

    public function getUserListing(Request $request, $urole=NULL)
    {

        return view('core.authenticated.admin_user.admin_user_listing', compact('urole'));
    }

    public function postRegister(Request $request)
    {
        $data = $request->all();
        $pswd = Str::random(6);


		$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
        	//dd($defaultAcquirer->toArray());
        	if($defaultAcquirer==null)
        	{
            		return response()->json(['message' => 'Error encountered. ERR00AQ1', 'success'=>false], 200);
        	}

        	$defaultAcquirer = $defaultAcquirer->toArray();
        	$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        	$password= $encrypterFrom->encrypt($pswd."");


        $data['encPassword'] = $password;
        $data['bankId'] = intval($data['bankId']);
        $data['locationDistrict_id'] = intval($data['locationDistrict_id']);
        $data['token'] = \Auth::user()->token;
        $data['probasePayMerchantCode'] = BEVURA_MERCHANT_CODE;
        $data['probasePayDeviceCode'] = BEVURA_DEVICE_CODE;
	 $data['roleCode'] = $data['role_type'];
	 $data['username'] = $data['contactEmail'];
	 $data['mobileNumber'] = $data['countryalt']."".$data['contactMobile'];
	 //$data['username'] = "temboadams@gmail.com";


	//dd($data);


        $file_name = NULL;
        if ($request->hasFile('profilePix')) {
            $file = \Input::file('profilePix');
            $file_name = str_random(25) . '.' . $file->getClientOriginalExtension();
            $dest = 'files/passports/';
            $file->move($dest, $file_name);
            unset($data['profilePix']);
            $data['profilePix'] = $file_name;

        }

        $result = null;


	 




	 if($data['role_type']=='CUSTOMER')
	 {
	 	$data['setRegistrationCode'] = isset($data['setRegistrationCode']) && $data['setRegistrationCode']!=null && $data['setRegistrationCode']==0 ? 1 : 0;
	 }
	 else
	 {
	 	unset($data['setRegistrationCode']);
	 }

	 $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        if($data['role_type']=='BANK_STAFF')
        {
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UserServices/createBankStaff';
		$authDataStr = sendPostRequest($url, $dataStr);
        	$authData = json_decode($authDataStr);


            //$result = handleSOAPCalls('createBankStaff', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/UserServices?wsdl', $data);
        }
        else {
//dd($data);
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UserServicesV2/createNewUserAccount';
		$authDataStr = sendPostRequest($url, $dataStr);
        	$authData = json_decode($authDataStr);

            //$result = handleSOAPCalls('createNewAdminUser', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/UserServices?wsdl', $data);
        }

        


	 
        

        if($authData->status == 500)
        {

		if($data['role_type']=='ACCOUNTANT')
		{

		}
		else if($data['role_type']=='EXCO_STAFF')
		{

		}
		else
		{
            		$mobile = $data['contactMobile'];
            		$msg = "Welcome to ProbasePay.com. \nYour Password is ".$pswd."\n\nThank You.";
            		send_sms($mobile, $msg);
            		return \Redirect::to('/potzr-staff/user-listing/agent')->with('message', 'New User Account Successfully created');
		}
        }
	 dd($authData);
        return \Redirect::back()->with('error', 'New User Account creation failed. '.(isset($authData->message) && $authData->message!=null ? $authData->message : ''));
        //dd($result);
    }


    public function getProfileView($id=NULL)
    {
        return view('probasewallet.authenticated.user', compact('rolesList', 'all_provinces', 'all_banks'));
    }


	public function getManageUserStatus(Request $request, $id, $action)
	{
		$all = $request->all();
		//dd([$action, $id, $all]);
		$status = null;
		$userIds = $id;
		if($action=='disable')
		{
			$status = 0;
		}
		else if($action=='enable')
		{
			$status = 1;
		}
		else if($action=='unlock')
		{
			$status = 1;
		}

		$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
        	//dd($defaultAcquirer->toArray());
        	if($defaultAcquirer==null)
        	{
            		return response()->json(['message' => 'Error encountered. ERR00AQ1', 'success'=>false], 200);
        	}

        	$defaultAcquirer = $defaultAcquirer->toArray();
        	$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        	$userIds= $encrypterFrom->encrypt($id."");


		$data['token'] = \Auth::user()->token;
		$data['status'] = $status;
		$data['userIdS'] = $userIds;
	 	$data['deviceCode'] = BEVURA_DEVICE_CODE;
	 	$data['merchantCode'] = BEVURA_MERCHANT_CODE;
//dd($data);
		$result = null;
        	$dataStr = "";
        	foreach($data as $d => $v)
        	{
            		$dataStr = $dataStr."".$d."=".$v."&";
        	}

//dd($dataStr);

//dd($action);
        	$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UserServicesV2/updateUserStatus';
        	$authDataStr = sendPostRequest($url, $dataStr);
        	$authData = json_decode($authDataStr);

        	if($authData->status==502) {
            		return \Redirect::back()->with('message', 'Users status updated successfully');
        	}
       	else {
            		return \Redirect::back()->with('message', isset($authData->message) && $authData->message!=null ? $authData->message : 'Users status could not be updated');
        	}
		
	}





	public function getResendUserCredentials(Request $request, $id	)
	{
		$all = $request->all();
		$userIds = $id;
		
		$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
        	//dd($defaultAcquirer->toArray());
        	if($defaultAcquirer==null)
        	{
            		return response()->json(['message' => 'Error encountered. ERR00AQ1', 'success'=>false], 200);
        	}

        	$defaultAcquirer = $defaultAcquirer->toArray();
        	$encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        	$userIds= $encrypterFrom->encrypt($id."");


		$data['token'] = \Auth::user()->token;
		$data['userIdS'] = $userIds;
	 	$data['deviceCode'] = BEVURA_DEVICE_CODE;
	 	$data['merchantCode'] = BEVURA_MERCHANT_CODE;
//dd($data);
		$result = null;
        	$dataStr = "";
        	foreach($data as $d => $v)
        	{
            		$dataStr = $dataStr."".$d."=".$v."&";
        	}

//dd($dataStr);

//dd($action);
        	$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UserServicesV2/resendUserCredentials';
        	$authDataStr = sendPostRequest($url, $dataStr);
        	$authData = json_decode($authDataStr);

        	if($authData->status==5000) {
            		return \Redirect::back()->with('message', 'User has been sent their security credentials');
        	}
       	else {
            		return \Redirect::back()->with('message', isset($authData->message) && $authData->message!=null ? $authData->message : 'Users security credentials could not be sent');
        	}
		
	}
}
