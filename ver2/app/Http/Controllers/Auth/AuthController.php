<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\NewUserRequest;
use App\Models\Packages;
use App\Models\User;
use App\Models\UserProfiles;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Http\Request;
use Validator;
use App\Models\Roles;
use App\Http\Controllers\Controller;
use DB;
use Hash;
use Artisaninweb\SoapWrapper\Facades\SoapWrapper;
use JWTAuth;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    protected $auth;

    protected $registrar;
	private $jwtauth;


    public function __construct(Guard $auth, JWTAuth $jwtauth)
    {
        parent::__construct();



        $this->schoolId = isset($this->schoolId) ? $this->schoolId : null; //temporary measure

        $this->auth = $auth;

        $this->middleware('guest', ['except' => array('getRegister', 'postRegister', 'getCompleteRegistration')]);

		$this->jwtauth = $jwtauth;
    }

	public function getNewCustomer()
	{
		return view('core.authenticated.customer.new_customer');
	}

    public function getLogin()
    {

		return view('core.guest.login');
    }


	public function getWalletLoginView($data=NULL)
	{
		return view('probasewallet.guest.login', compact('data'));
	}

	public function getWalletOTPLoginView($token, $data=NULL)
	{
		return view('probasewallet.guest.login_otp', compact('token', 'data'));
	}


	public function getAdminPortalLoginView(Request $request, $data=NULL)
	{
		return view('core.guest.adminportallogin', compact('data'));
	}

	public function getDashboard(Request $request)
	{
		
		//dd(\Session::all());
		if(isset(\Auth::user()->role_code) && \Auth::user()->role_code == \App\Models\Roles::$BANK_TELLER) {
			$dashboardStatistics = \Auth::user()->dashboardStatistics;
			$dashboardStatistics = json_decode($dashboardStatistics);
			$data = json_decode(\Auth::user()->id);

			//$transactionByStatus = $data->transactionByStatus;
			//$transactionByServiceType = $data->transactionByServiceType;
			//$mobileAcctCount = 0;
			//return view('core.authenticated.dashboard.bank_teller', compact('dashboardStatistics', 'transactionByStatus', 'transactionByServiceType'));
			return view('core.authenticated.dashboard.bank_teller', compact('dashboardStatistics'));

		}
		else if(isset(\Auth::user()->role_code) && \Auth::user()->role_code == \App\Models\Roles::$POTZR_STAFF) {
			return view('core.authenticated.dashboard.potzr_staff');
		}
		else if(isset(\Auth::user()->role_code) && \Auth::user()->role_code == \App\Models\Roles::$EXCO_STAFF) {
			return view('core.authenticated.dashboard.exco_staff');
		}
		else if(isset(\Auth::user()->role_code) && \Auth::user()->role_code == \App\Models\Roles::$MERCHANT) {
			$dashboardStatistics = \Auth::user()->dashboardStatistics;
			$dashboardStatistics = json_decode($dashboardStatistics);
			return view('core.authenticated.dashboard.merchant');
		}
		else if(isset(\Auth::user()->role_code) && \Auth::user()->role_code == \App\Models\Roles::$ACCOUNTANT) {
			$dashboardStatistics = \Auth::user()->dashboardStatistics;
			$dashboardStatistics = json_decode($dashboardStatistics);
			return view('core.authenticated.dashboard.accountant');
		}
		else if(isset(\Auth::user()->role_code) && \Auth::user()->role_code == \App\Models\Roles::$AGENT) {
			$dashboardStatistics = \Auth::user()->dashboardStatistics;
			$dashboardStatistics = json_decode($dashboardStatistics);
			return view('core.authenticated.dashboard.agent');
		}
		else if(isset(\Auth::user()->role_code) && \Auth::user()->role_code == \App\Models\Roles::$ADMIN_USER) {
			
			return view('core.authenticated.dashboard.admin_user');
		}
		else if(isset(\Auth::user()->role_code) && \Auth::user()->role_code == \App\Models\Roles::$CUSTOMER) {

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
            		}




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

            		$all_card_schemes = $this->all_card_schemes;


            		return view('core.authenticated.dashboard.customer', compact('breadcrumbs', 'request', 'accounts', 'cards'));

		}

		else
		{
			$sessionData = \Session::all();

			if(isset($sessionData['userData']) && $sessionData['userData']!=null && $sessionData['userData']['role_code']=='ADMIN_USER')
			{
				$breadcrumbs = [];
            			$breadcrumbs['DASHBOARD'] = '/dashboard';
                		$breadcrumbs['NEW MERCHANT'] = null;

				return view('core.authenticated.dashboard.admin_user', compact('breadcrumbs', 'request'));
			}
			//dd($sessionData);
		}
	}

	public function postLoginOld(Request $request)
	{
		dd(encrypt($request->get('password')));

		$redirect = null;
		if (\Request::has('redirect')) {
			$redirect = \Request::get('redirect');
		}
		$credentials = $request->only('username', 'password');

		$user = new User();
		dd($user);
		$this->auth->login($user);
		if ($this->auth->attempt($credentials, false)) {


			if (\Auth::user()->status == 'Inactive') {
				u_logout();
				return back()->with('error', 'Log in failed. Activate your account');
			}
			else if (\Auth::user()->status == 'Active') {
				return redirect('/admin/dashboard');
			} else {
				u_logout();
				return back()->with('error', 'Wrong log in parameters');
			}
		} else {
			return back()->with('error', 'Log in failed');
		}
	}



    public function postWalletLogin(Request $request)
    {
		$input = $request->all();

		$data = NULL;
		if(is_array($input) && in_array('data', array_keys($input))) {
			/*$data = \Crypt::decrypt($input['data']);
			if (is_array($data) && in_array('data', array_keys($data)))
				$data = \Crypt::decrypt($data['data']);*/
			$data = $input['data'];
		}


		$username = $request->get('username');
		$password = encrypt(($request->get('password')));

		try {
			SoapWrapper::add(function ($service) {
				$service
						->name('authenticateWalletUsers')
						->wsdl('http://'.getServiceBaseURL().'/ProbasePayEngine/services/AuthenticationServices?wsdl')
						->trace(true);
			});


			$dataToServer = [
					'username' => $username,
					'encPassword' => $password,
			];

			$authReturn = null;
			SoapWrapper::service('authenticateWalletUsers', function ($service) use ($dataToServer, &$authReturn) {
				$authReturn = ($service->call('authenticateWalletUsers', [$dataToServer]));

			});

			$authData = json_decode($authReturn->return);
			//dd($authData);


			if(isset($authData->role_code) && $authData->role_code!='CUSTOMER')
			{
				return \Redirect::to('/auth/login')->with('error', 'Login failed. Invalid login details provided');
			}

			if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {

			    //dd($data);
				$token = $authData->token;
				$token = \Crypt::encrypt($token);
				$otp = $authData->otp;
				$mobile = $authData->otprecmobile;
				$msg = "Logging Into ProbaseWallet.com? \nYour One-Time Password is ".$otp."\n\nThank You.";
				send_sms($mobile, $msg);
				return \Redirect::to('/auth/otp-login/'.$token.($data==NULL ? '' : '/'.$data));

			}else
			{
				return back()->with('error', 'Error logging in. Please try again later');
			}
		}catch(\Exception $e)
		{
		    //dd($e);
			return back()->with('error', 'Experiencing issues logging in. Try again later');
		}

    }


	public function postAdminPortalLogin(Request $request)
	{
		$all= $request->all();
		//dd($all);

		$credentials = $request->validate([
            		'username' => ['required'],
           		'password' => ['required'],
        	]);


		
		//dd([Auth::attempt($credentials), Auth::user()->getAttributes()]);

        	if (Auth::attempt($credentials)) {
            		//$request->session()->regenerate();

			$userData = [];
			$userData['username'] = $all['username'];
			$userData['role_c'] = $all['username'];
			\Session::put('userData', Auth::user()->getAttributes());

            		return redirect()->intended('/admin-portal/dashboard');
        	}

        	return back()->withErrors([
            		'email' => 'The provided credentials do not match our records.',
        	]);
	}


	public function postWalletLoginOld(Request $request)
	{
		$input = $request->all();

		$data = NULL;
		if(is_array($input) && in_array('data', array_keys($input))) {
			/*$data = \Crypt::decrypt($input['data']);
			if (is_array($data) && in_array('data', array_keys($data)))
				$data = \Crypt::decrypt($data['data']);*/
			$data = $input['data'];
		}

		$username = $request->get('username');
		$password = encrypt(($request->get('password')));

		try {

			SoapWrapper::add(function ($service) {
				$service
						->name('authenticateWalletUsers')
						->wsdl('http://'.getServiceBaseURL().'/ProbasePayEngine/services/AuthenticationServices?wsdl')
						->trace(true);
			});



			$dataToServer = [
					'username' => $username,
					'encPassword' => $password
			];

			$authReturn = null;
			SoapWrapper::service('authenticateWalletUsers', function ($service) use ($dataToServer, &$authReturn) {
				$authReturn = ($service->call('authenticateWalletUsers', [$dataToServer]));
				//dd($authReturn);
			});

			$authData = json_decode($authReturn->return);


			if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {

				$token = $authData->token;
				$token = \Crypt::encrypt($token);
				//$data = $data==NULL ? $data : \Crypt::encrypt($data);

				$otp = $authData->otp;
				$mobile = $authData->otprecmobile;

				$msg = "Logging Into ProbaseWallet.com? \nYour One-Time Password is ".$otp."\n\nThank You.";
				send_sms($mobile, $msg);
				return \Redirect::to('/auth/otp-login/'.$token.($data==NULL ? '' : '/'.$data));
			}else
			{
				return back()->with('error', 'Error logging in. Please try again later');
			}
		}catch(\Exception $e)
		{
			return back()->with('error', 'Experiencing issues logging in. Try again later');
		}

	}


	public function postWalletLoginOTPHandle(Request $request)
	{
		$input = $request->all();

		$data = null;
		$otp = \Crypt::encrypt($request->get('otp'));
		$token = \Crypt::decrypt($request->get('token'));

//return back()->with('error', 'Error logging in. Please try again later');

		if(is_array($input) && in_array('data', array_keys($input)) && strlen($input['data'])>0) {
			//$data = \Crypt::decrypt($input['data']);
			//dd($data);
			//if (is_array($data) && in_array('data', array_keys($data)))
			//	$data = \Crypt::decrypt($data['data']);
			$data = $input['data'];
		}
		//dd(11);

		try {

			SoapWrapper::add(function ($service) {
				$service
						->name('authenticateWalletUsersValidateOTP')
						->wsdl('http://'.getServiceBaseURL().'/ProbasePayEngine/services/AuthenticationServices?wsdl')
						->trace(true);
			});




			$dataToServer = [
					'token' => $token,
					'otp' => $otp
			];

			$authReturn = null;
			SoapWrapper::service('authenticateWalletUsersValidateOTP', function ($service) use ($dataToServer, &$authReturn) {
				$authReturn = ($service->call('authenticateWalletUsersValidateOTP', [$dataToServer]));

			});

			$authData = json_decode($authReturn->return);
			//dd($authData);

			if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {
				$user = new User();
				//$user->id = \Crypt::encrypt($authData);
				$user->id = json_encode($authData);
				$user->username = $authData->username;
				$user->token = $authData->token;
				$user->role_code = $authData->role_code;
				$user->all_banks = $authData->all_banks;
				$user->all_merchant_schemes = $authData->all_merchant_schemes;
				$user->all_device_types = $authData->all_device_types;
				$user->all_card_schemes = $authData->all_card_schemes;
				$user->all_provinces = $authData->all_provinces;
				$user->all_countries = $authData->all_countries;
				$user->profile_pix = (isset($authData->profile_pix) && $authData->profile_pix!=null) ? $authData->profile_pix : null;
				$user->staff_bank_code = isset($authData->staff_bank_code) ? $authData->staff_bank_code : null;
				$user->wallet_code = isset($authData->wallet_code) ? $authData->wallet_code : null;
				$user->firstName = isset($authData->firstName) ? $authData->firstName : null;
				$user->lastName = isset($authData->lastName) ? $authData->lastName : null;
				$user->otherName = isset($authData->otherName) ? $authData->otherName : null;
				$user->walletaccounts = isset($authData->walletaccounts) ? $authData->walletaccounts : null;
				$user->balance = isset($authData->balance) ? $authData->balance : null;
				$user->status = isset($authData->user_status) ? $authData->user_status : null;/**/
				$user->mobileno = $authData->mobileno;
				$user->customerVerificationNo = $authData->customerVerificationNo;

				$this->auth->login($user);

//dd($data);
                //$data = \App\Models\LoginData::where('id', '=', $data)->first();

                if($data!=null)
                {
                    //$data = $data->data;

                    //$data = \Crypt::decrypt($data->data);

    				//if(isset($data) && $data!=NULL)
    				//{
    					return \Redirect::to('/wallet/pay/customer/routed_bill/'.($data));
    				//}
                }
                //dd($data);
				return redirect('/wallet/dashboard');
			}else
			{
				return back()->with('error', 'Error logging in. Please try again later');
			}
		}catch(\Exception $e)
		{
			return back()->with('error', 'Experiencing issues logging in. Try again later');
		}

	}





	public function postWalletLoginPinHandle(Request $request)
	{
		$input = $request->all();

		$data = null;
		$otp = \Crypt::encrypt($request->get('otp'));
		$token = \Crypt::decrypt($request->get('token'));

//return back()->with('error', 'Error logging in. Please try again later');

		if(is_array($input) && in_array('data', array_keys($input)) && strlen($input['data'])>0) {
			//$data = \Crypt::decrypt($input['data']);
			//dd($data);
			//if (is_array($data) && in_array('data', array_keys($data)))
			//	$data = \Crypt::decrypt($data['data']);
			$data = $input['data'];
		}
		//dd(11);

		try {

			SoapWrapper::add(function ($service) {
				$service
						->name('authenticateWalletUsersValidateOTP')
						->wsdl('http://'.getServiceBaseURL().'/ProbasePayEngine/services/AuthenticationServices?wsdl')
						->trace(true);
			});




			$dataToServer = [
					'token' => $token,
					'otp' => $otp
			];

			$authReturn = null;
			SoapWrapper::service('authenticateWalletUsersValidateOTP', function ($service) use ($dataToServer, &$authReturn) {
				$authReturn = ($service->call('authenticateWalletUsersValidateOTP', [$dataToServer]));

			});

			$authData = json_decode($authReturn->return);
			//dd($authData);

			if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {
				$user = new User();
				//$user->id = \Crypt::encrypt($authData);
				$user->id = json_encode($authData);
				$user->username = $authData->username;
				$user->token = $authData->token;
				$user->role_code = $authData->role_code;
				$user->all_banks = $authData->all_banks;
				$user->all_merchant_schemes = $authData->all_merchant_schemes;
				$user->all_device_types = $authData->all_device_types;
				$user->all_card_schemes = $authData->all_card_schemes;
				$user->all_provinces = $authData->all_provinces;
				$user->all_countries = $authData->all_countries;
				$user->profile_pix = (isset($authData->profile_pix) && $authData->profile_pix!=null) ? $authData->profile_pix : null;
				$user->staff_bank_code = isset($authData->staff_bank_code) ? $authData->staff_bank_code : null;
				$user->wallet_code = isset($authData->wallet_code) ? $authData->wallet_code : null;
				$user->firstName = isset($authData->firstName) ? $authData->firstName : null;
				$user->lastName = isset($authData->lastName) ? $authData->lastName : null;
				$user->otherName = isset($authData->otherName) ? $authData->otherName : null;
				$user->walletaccounts = isset($authData->walletaccounts) ? $authData->walletaccounts : null;
				$user->balance = isset($authData->balance) ? $authData->balance : null;
				$user->status = isset($authData->user_status) ? $authData->user_status : null;/**/
				$user->mobileno = $authData->mobileno;
				$user->customerVerificationNo = $authData->customerVerificationNo;

				$this->auth->login($user);

//dd($data);
                //$data = \App\Models\LoginData::where('id', '=', $data)->first();

                if($data!=null)
                {
                    //$data = $data->data;

                    //$data = \Crypt::decrypt($data->data);

    				//if(isset($data) && $data!=NULL)
    				//{
    					return \Redirect::to('/wallet/pay/customer/routed_bill/'.($data));
    				//}
                }
                //dd($data);
				return redirect('/wallet/dashboard');
			}else
			{
				return back()->with('error', 'Error logging in. Please try again later');
			}
		}catch(\Exception $e)
		{
			return back()->with('error', 'Experiencing issues logging in. Try again later');
		}

	}


    public function postLogin(Request $request)
    {
		$username = $request->get('username');
		$password = encrypt(($request->get('password')));

		$deviceVersion= $request->get('deviceVersion');
		$deviceName= $request->get('deviceName');
		$deviceKey= $request->get('deviceKey');
		$deviceAppId= $request->get('deviceAppId');
		$deviceId= $request->get('deviceId');
		$isMobile= $request->get('isMobile');
		$autoAuthenticate= $request->get('autoAuthenticate');


		
		//dd(getServiceBaseURL());
		try {
            $defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
            $defaultAcquirer = $defaultAcquirer->toArray();

		$acquirerCode = $defaultAcquirer['acquirerCode'];

            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/authenticateUsers';
			//$data['username'] = $username;
			//$data['password'] = $password;//dd($data);
			$data = 'username='.$username."&encPassword=".$password."&acquirerCode=".$defaultAcquirer['acquirerCode'];


		if($deviceVersion!=null)
		{
			$data = $data."&deviceVersion=".urlencode($deviceVersion);
		}
		if($deviceName!=null)
		{
			$data = $data."&deviceName=".urlencode($deviceName);
		}
		if($deviceKey!=null)
		{
			$data = $data."&deviceKey=".urlencode($deviceKey);
		}
		if($deviceAppId!=null)
		{
			$data = $data."&deviceAppId=".urlencode($deviceAppId);
		}
		if($deviceId!=null)
		{
			$data = $data."&deviceId=".urlencode($deviceId);
		}



            /*$ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,
                        "username=".$username."&password=".$password);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);

            curl_close ($ch);*/
			$server_output = sendPostRequest($url, $data);

            //dd($server_output);

			/*SoapWrapper::add(function ($service) {
				$service
						->name('authenticateUsers')
						->wsdl('http://'.getServiceBaseURL().'/ProbasePayEngine/services/AuthenticationServices?wsdl')
						->trace(true);
			});


			$data = [
					'username' => $username,
					'encPassword' => $password,
					'bankCode' => '035'
			];

			$authReturn = null;
			SoapWrapper::service('authenticateUsers', function ($service) use ($data, &$authReturn) {
				$authReturn = ($service->call('authenticateUsers', [$data]));

			});

			$authData = json_decode($authReturn->return);*/

			//dd($server_output);
			$authData = json_decode($server_output);

			//dd($authData);


			/*if(isset($authData->role_code) && $authData->role_code=='CUSTOMER') {
                return \Redirect::to('/auth/login')->with('error', 'Login failed. Invalid login details provided');
            }*/

			if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {

			    //dd(33);
				$token = $authData->token;
				//$token = \Crypt::encrypt($token);
				$otp = $authData->otp;
				$mobile = $authData->otprecmobile;
				$msg = "Logging Into ProbasePay.com? \nYour One Time Password is ".$otp."\n\nThank You.";
				//send_sms($mobile, $msg);

				//return \Redirect::to('/auth/otp-login/'.$token.'/'.$otp);
                return view('core.guest.login_otp', compact('token'));

			}
			else if(isset($authData->status) && $authData->status!=null && $authData->status == 604) {

			       //dd(33);
				$token = $authData->token;
				//$token = \Crypt::encrypt($token);
				//$otp = $authData->otp;
				//$mobile = $authData->otprecmobile;
				//$msg = "Logging Into ProbasePay.com? \nYour One Time Password is ".$otp."\n\nThank You.";
				//send_sms($mobile, $msg);
//dd(11);
				//return \Redirect::to('/auth/otp-login/'.$token.'/'.$otp);


                		return view('core.guest.login_otp', compact('token'));









			}else if(isset($authData->status) && $authData->status!=null && $authData->status == 605) {

			       //dd(33);
				//$token = $authData->token;
				//$token = \Crypt::encrypt($token);
				//$otp = $authData->otp;
				//$mobile = $authData->otprecmobile;
				//$msg = "Logging Into ProbasePay.com? \nYour One Time Password is ".$otp."\n\nThank You.";
				//send_sms($mobile, $msg);
//dd(11);
				//return \Redirect::to('/auth/otp-login/'.$token.'/'.$otp);


                		return view('core.guest.login_otp_new_device', compact('username', 'password', 'deviceVersion', 'deviceName', 'deviceKey', 'deviceAppId', 'deviceId', 'isMobile', 'autoAuthenticate', 'acquirerCode'));









			}else
			{

				return back()->with('error', 'Error logging in. Please try again later');
			}
		}catch(\Exception $e)
		{
		      	dd($e);
			return back()->with('error', 'Experiencing issues logging in. Try again later');
		}

    }




    public function postLoginToPay(Request $request)
    {

        $sessionContainer = [];
        if(\Session::has('error') || \Session::has('message'))
        {
            $sessionError = \Session::get('error');
            $sessionMessage = \Session::get('message');
            $sessionContainer['error'] = $sessionError;
            $sessionContainer['message'] = $sessionMessage;
        }




        $all = $request->except('username', 'password');
        $username = $request->get('username');
        $password = encrypt(($request->get('password')));


        //dd($username);
        try {
            $defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
            $defaultAcquirer = $defaultAcquirer->toArray();

            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/authenticateUsers';
            //$data['username'] = $username;
            //$data['password'] = $password;//dd($data);
            $data = 'username='.$username."&encPassword=".$password."&acquirerCode=".$defaultAcquirer['acquirerCode'];

            /*$ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,
                        "username=".$username."&password=".$password);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);

            curl_close ($ch);*/
            $server_output = sendPostRequest($url, $data);

            //dd($server_output);

            /*SoapWrapper::add(function ($service) {
                $service
                        ->name('authenticateUsers')
                        ->wsdl('http://'.getServiceBaseURL().'/ProbasePayEngine/services/AuthenticationServices?wsdl')
                        ->trace(true);
            });


            $data = [
                    'username' => $username,
                    'encPassword' => $password,
                    'bankCode' => '035'
            ];

            $authReturn = null;
            SoapWrapper::service('authenticateUsers', function ($service) use ($data, &$authReturn) {
                $authReturn = ($service->call('authenticateUsers', [$data]));

            });

            $authData = json_decode($authReturn->return);*/

            //dd($server_output);
            $authData = json_decode($server_output);

            //dd($authData);


            /*if(isset($authData->role_code) && $authData->role_code=='CUSTOMER') {
                return \Redirect::to('/auth/login')->with('error', 'Login failed. Invalid login details provided');
            }*/

            if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {

                //dd(33);
                $token = $authData->token;
                //$token = \Crypt::encrypt($token);
                $otp = $authData->otp;
                $mobile = $authData->otprecmobile;
                $msg = "Logging Into ProbasePay.com? \nYour One Time Password is ".$otp."\n\nThank You.";
                //send_sms($mobile, $msg);

                //return \Redirect::to('/auth/otp-login/'.$token.'/'.$otp);
                $input = $all['data'];
                $input1 = (\Crypt::decrypt($input));
                $key = OTP_COLLECTION_VIEW;
                //return view('guests.payment.web.otp-collection-view', compact('token', 'all', 'itemAmounts', 'input', 'orderId', 'currency'));
                return view('secure.dashboard', compact('sessionContainer', 'key', 'input', 'token'));

            }else
            {
                return back()->with('error', 'Error logging in. Please try again later');
            }
        }catch(\Exception $e)
        {
            dd($e);
            return back()->with('error', 'Experiencing issues logging in. Try again later');
        }

    }



	
	public function validateUsername(Request $request)
	{
		$sessionContainer = [];
		if(\Session::has('error') || \Session::has('message'))
		{
			$sessionError = \Session::get('error');
			$sessionMessage = \Session::get('message');
			$sessionContainer['error'] = $sessionError;
			$sessionContainer['message'] = $sessionMessage;
		}




		$all = $request->except('username');
		$username = $request->get('username');
		//return \Response::json($request);

		//dd($username);
		try {
			$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
			$defaultAcquirer = $defaultAcquirer->toArray();
			//return \Response::json($defaultAcquirer);

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/validateUsernameForCustomers';
			$data = 'username='.$username."&acquirerCode=".$defaultAcquirer['acquirerCode'];

			$server_output = sendPostRequest($url, $data);
			$authData = json_decode($server_output);
			
				//return \Response::json($data);



			
        		
                	try
			{        
				/*if(isset($all['deviceKey']) && isset($all['deviceId']) && $all['deviceKey']!=null && strlen($all['deviceKey'])>0 && $all['deviceId']!=null && strlen($all['deviceId'])>0)
				{
					$data = [];
					$data['deviceId'] = $all['identifier'];
        				$data['deviceVersion'] = $all['deviceVersion'];
        				$data['deviceName'] = $all['deviceName'];
        				$data['deviceKey'] = $all['deviceKey'];
        				$data['device_app_id'] = $all['deviceId'];
					$result = null;
        				$dataStr = "";
        				foreach($data as $d => $v)
        				{
            					$dataStr = $dataStr."".$d."=".$v."&";
        				}
        				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UserServicesV2/createNewAppDevice';
        				$deviceResp = sendPostRequest($url, $dataStr);


				}*/
			}
			catch(\Exception $e)
			{
			}


        

			if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {
				
				$resp = [];
				$resp['username'] = $username;
				$resp['isBiometric'] = $authData->isBiometric;
				$resp['fundsTransferCharges'] = isset($authData->fundsTransferCharges) && $authData->fundsTransferCharges!=null ? $authData->fundsTransferCharges : null;
				$resp['fundsTransferToOthersCharges'] = isset($authData->fundsTransferToOthersCharges) && $authData->fundsTransferToOthersCharges!=null ? $authData->fundsTransferToOthersCharges: null;
				$resp['status'] = 100;
				$resp['success'] = true;
				return \Response::json($resp);

			}else
			{
				$resp = [];
				$resp['username'] = $username;
				$resp['status'] = 0;
				$resp['success'] = false;
				$resp['authData'] = $authData;
				$resp['message'] = isset($authData->message) ? $authData->message : 'Error logging in. Please try again later';

				if(isset($authData->escape) && $authData->escape==1)
				{
					$resp['escape'] = 1;
				}
				return \Response::json($resp);
			}
		}catch(\Exception $e)
		{
			$resp = [];
			$resp['status'] = 0;
			$resp['success'] = false;
			$resp['success'] = $e->getMessage();
			$resp['message'] = 'Error logging in. Please try again later';
			return \Response::json($resp);
		}
	}




	public function validateUsernameForMerchants(Request $request)
	{
		$sessionContainer = [];
		if(\Session::has('error') || \Session::has('message'))
		{
			$sessionError = \Session::get('error');
			$sessionMessage = \Session::get('message');
			$sessionContainer['error'] = $sessionError;
			$sessionContainer['message'] = $sessionMessage;
		}




		$all = $request->except('username');
		$username = $request->get('username');
		//return \Response::json($request);

		//dd($username);
		try {
			$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
			$defaultAcquirer = $defaultAcquirer->toArray();
			//return \Response::json($defaultAcquirer);

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/validateUsernameForMerchants';
			$data = 'username='.$username."&acquirerCode=".$defaultAcquirer['acquirerCode'];

			$server_output = sendPostRequest($url, $data);
			$authData = json_decode($server_output);
			
				//return \Response::json($data);



			
        		
                	try
			{        
				/*if(isset($all['deviceKey']) && isset($all['deviceId']) && $all['deviceKey']!=null && strlen($all['deviceKey'])>0 && $all['deviceId']!=null && strlen($all['deviceId'])>0)
				{
					$data = [];
					$data['deviceId'] = $all['identifier'];
        				$data['deviceVersion'] = $all['deviceVersion'];
        				$data['deviceName'] = $all['deviceName'];
        				$data['deviceKey'] = $all['deviceKey'];
        				$data['device_app_id'] = $all['deviceId'];
					$result = null;
        				$dataStr = "";
        				foreach($data as $d => $v)
        				{
            					$dataStr = $dataStr."".$d."=".$v."&";
        				}
        				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UserServicesV2/createNewAppDevice';
        				$deviceResp = sendPostRequest($url, $dataStr);


				}*/
			}
			catch(\Exception $e)
			{
			}


        		


			if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {
				
				$resp = [];
				$resp['username'] = $username;
				$resp['isBiometric'] = $authData->isBiometric;
				$resp['fundsTransferCharges'] = isset($authData->fundsTransferCharges) && $authData->fundsTransferCharges!=null ? $authData->fundsTransferCharges : null;
				$resp['fundsTransferToOthersCharges'] = isset($authData->fundsTransferToOthersCharges) && $authData->fundsTransferToOthersCharges!=null ? $authData->fundsTransferToOthersCharges: null;
				$resp['status'] = 100;
				$resp['success'] = true;
				return \Response::json($resp);

			}else
			{
				$resp = [];
				$resp['username'] = $username;
				$resp['status'] = 0;
				$resp['success'] = false;
				$resp['authData'] = $authData;
				$resp['message'] = isset($authData->message) ? $authData->message : 'Error logging in. Please try again later';

				if(isset($authData->escape) && $authData->escape==1)
				{
					$resp['escape'] = 1;
				}
				return \Response::json($resp);
			}
		}catch(\Exception $e)
		{
			$resp = [];
			$resp['status'] = 0;
			$resp['success'] = false;
			$resp['success'] = $e->getMessage();
			$resp['message'] = 'Error logging in. Please try again later';
			return \Response::json($resp);
		}
	}
	
	
	
	public function postLoginJSONResponse(Request $request)
	{

		$all = $request->except('username');
		$username = $request->get('username');
		$password = (string)($request->get('password'));
		$isMobile = ($request->get('isMobile'));
		$autoAuthenticate = ($request->get('autoAuthenticate'));
		$password = encrypt(($password));
		
		
		try {
			$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
			$defaultAcquirer = $defaultAcquirer->toArray();

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/authenticateUsers';
			//$data['username'] = $username;
			//$data['password'] = $password;//dd($data);
			$data = 'username='.$username."&encPassword=".$password."&acquirerCode=".$defaultAcquirer['acquirerCode'];
			if($autoAuthenticate!=null)
			{
				$data = $data.'&autoAuthenticate='.$autoAuthenticate;

				$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/authenticateUsersWithoutPin';
				$data = $data.'&deviceCode='.$request->get('deviceCode').'&merchantId='.$request->get('merchantId');

			}
			if($isMobile!=null && $isMobile==1)
				$data = $data.'&isMobile=1';




			if(isset($all['deviceKey']) && isset($all['deviceId']) && $all['deviceKey']!=null && strlen($all['deviceKey'])>0 && $all['deviceId']!=null && strlen($all['deviceId'])>0)
			{
				$data = $data.'&deviceId='. $all['deviceId'];
        			$data = $data.'&deviceVersion='. $all['deviceVersion'];
        			$data = $data.'&deviceName='. $all['deviceName'];
        			$data = $data.'&deviceKey='. $all['deviceKey'];
        			$data = $data.'&deviceAppId='. $all['identifier'];
			}


			//return \Response::json($all);

			$server_output = sendPostRequest($url, $data);
			$authData = json_decode($server_output);
			//return \Response::json(['data'=>$authData->isBiometric]);
					$ap = new \App\Models\AppError();
					$ap->error_trace = json_encode($authData );
					$ap->url = "";
					$ap->error_dump = json_encode($authData );
					$ap->user_username = "";
					$ap->save();


			

			if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {

				//dd(33);
				$token = $authData->token;


				$user = new User();
				$user->id =($authData->id);
				$user->username = $authData->username;
				$user->token = $authData->token;
				$user->role_code = $authData->role_code;
				$user->profile_pix = (isset($authData->profile_pix) && $authData->profile_pix!=null) ? $authData->profile_pix : null;
				$user->staff_bank_code = isset($authData->staff_bank_code) ? $authData->staff_bank_code : null;
				$user->mobileno = $authData->mobileno;
				$user->merchant_dec_key = (isset($authData->merchant_key) && $authData->merchant_key!=null) ? $authData->merchant_key : null;
				$user->merchant_id = (isset($authData->merchant_id) && $authData->merchant_id!=null) ? $authData->merchant_id : null;
				$user->customerVerificationNo = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
				//$user->dashboardStatistics = (isset($authData->dashboardStatistics) && $authData->dashboardStatistics!=null) ? $authData->dashboardStatistics : null;
				//$this->auth->login($user, $server_output);

				//dd(\Auth::user());
				$jwttoken = JWTAuth::fromUser($user);



				//return \Response::json(['tk'=>$jwttoken]);
				$resp = [];
				$resp['status'] = 100;
				$resp['isBiometric'] = isset($authData->isBiometric) ? $authData->isBiometric : null;
				$resp['fundsTransferCharges'] = isset($authData->fundsTransferCharges) ? $authData->fundsTransferCharges: null;
				$resp['fundsTransferToOthersCharges'] = isset($authData->fundsTransferToOthersCharges) && $authData->fundsTransferToOthersCharges!=null ? $authData->fundsTransferToOthersCharges: null;
				$resp['usernameStr'] = "+".join(' ', str_split($username, 3));
				$resp['success'] = true;
				$resp['message'] = 'Logged in successfully';


                    		$resp['customerId'] = isset($authData->customer_id) ? $authData->customer_id : null;
                    		$resp['server_token'] = $authData->token;
                    		$resp['auth_id'] = $authData->id;
                   		$resp['roleCode'] = $authData->role_code;
                   		$resp['jwt_token'] = $jwttoken ;
                    		$resp['mobileNumber'] = $authData->mobileno;
                    		$resp['username'] = $authData->username;
                    		$resp['accounts'] = isset($authData->accounts) ? json_encode($authData->accounts) : json_encode([]);
                    		$resp['cards'] = isset($authData->ecards) ? json_encode($authData->ecards) : json_encode([]);
                    		$resp['status'] = 100;
                    		$resp['success'] = true;
                    		$resp['displayName'] = $authData->firstName." ".$authData->lastName;
                    		$resp['profile_pix'] = isset($authData->profile_pix) && $authData->profile_pix!=null ? $authData->profile_pix : null;
                    		$resp['userData'] = $authData;
                    		$resp['walletExists'] =isset($authData->walletExists) ? $authData->walletExists : false;
                    		$resp['ecardExists'] = isset($authData->ecardExists) ? $authData->ecardExists : false;
                    		$resp['customerVerificationNo'] = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
				$resp['cardSupport'] = isset($authData->cardSupport) ? $authData->cardSupport : null;
				$resp['forcePasswordChange'] = isset($authData->forcePasswordChange) ? $authData->forcePasswordChange : null;
				$resp['groupInvitations'] = isset($authData->groupInvitations) ? $authData->groupInvitations: null;
				$resp['token'] = $token;


				//return \Redirect::to('/ajax-otp-collection-view.html/{{OTP_COLLECTION_VIEW}}/'.$input.'/'.$all['orderId']);
				return \Response::json($resp);

			}else if(isset($authData->status) && $authData->status!=null && $authData->status == 604) {


				if(isset($autoAuthenticate) && $autoAuthenticate==1)
				{
					//return \Response::json($authData);
					$token = $authData->token;
					

					$user = new User();
					$user->id =($authData->id);
					$user->username = $authData->username;
					$user->token = $authData->token;
					$user->role_code = $authData->role_code;
					$user->profile_pix = (isset($authData->profile_pix) && $authData->profile_pix!=null) ? $authData->profile_pix : null;
					$user->staff_bank_code = isset($authData->staff_bank_code) ? $authData->staff_bank_code : null;
					$user->mobileno = $authData->mobileno;
					$user->merchant_dec_key = (isset($authData->merchant_key) && $authData->merchant_key!=null) ? $authData->merchant_key : null;
					$user->merchant_id = (isset($authData->merchant_id) && $authData->merchant_id!=null) ? $authData->merchant_id : null;
					$user->customerVerificationNo = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
					//$user->dashboardStatistics = (isset($authData->dashboardStatistics) && $authData->dashboardStatistics!=null) ? $authData->dashboardStatistics : null;
					//$this->auth->login($user, $server_output);
	
					//dd(\Auth::user());
					$jwttoken = JWTAuth::fromUser($user);


					$resp = [];
					$resp['status'] = 100;
					$resp['isBiometric'] = isset($authData->isBiometric) ? $authData->isBiometric : null;
					$resp['fundsTransferCharges'] = isset($authData->fundsTransferCharges) ? $authData->fundsTransferCharges: null;
					$resp['fundsTransferToOthersCharges'] = isset($authData->fundsTransferToOthersCharges) && $authData->fundsTransferToOthersCharges!=null ? $authData->fundsTransferToOthersCharges: null;
					$resp['usernameStr'] = "+".join(' ', str_split($username, 3));
					$resp['success'] = true;
					$resp['message'] = 'Logged in successfully';
	                   		$resp['jwt_token'] = $jwttoken ;


	                    		$resp['customerId'] = isset($authData->customer_id) ? $authData->customer_id : null;
					$resp['server_token'] = $authData->token;
					$resp['auth_id'] = $authData->id;
					$resp['roleCode'] = $authData->role_code;
					$resp['mobileNumber'] = $authData->mobileno;
					$resp['username'] = $authData->username;
					$resp['accounts'] = isset($authData->accounts) ? json_encode($authData->accounts) : json_encode([]);
					$resp['cards'] = isset($authData->ecards) ? json_encode($authData->ecards) : json_encode([]);
					$resp['status'] = 100;
					$resp['success'] = true;
					$resp['displayName'] = $authData->firstName." ".$authData->lastName;
					$resp['profile_pix'] = isset($authData->profile_pix) && $authData->profile_pix!=null ? $authData->profile_pix : null;
					$resp['userData'] = $authData;
					$resp['walletExists'] =isset($authData->walletExists) ? $authData->walletExists : false;
					$resp['ecardExists'] = isset($authData->ecardExists) ? $authData->ecardExists : false;
					$resp['customerVerificationNo'] = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
					$resp['cardSupport'] = isset($authData->cardSupport) ? $authData->cardSupport : null;
					$resp['forcePasswordChange'] = isset($authData->forcePasswordChange) ? $authData->forcePasswordChange : null;
					$resp['groupInvitations'] = isset($authData->groupInvitations) ? $authData->groupInvitations: null;
					$resp['token'] = $token;

					//return \Redirect::to('/ajax-otp-collection-view.html/{{OTP_COLLECTION_VIEW}}/'.$input.'/'.$all['orderId']);
					return \Response::json($resp);

				}
				else
				{
					//dd(33);
					$token = $authData->token;
					//$token = \Crypt::encrypt($token);
					$otp = $authData->otp;
					$mobile = $authData->otprecmobile;
					//$msg = "Logging Into ProbasePay.com? \nYour One Time Password is ".$otp."\n\nThank You.";
					//send_sms($mobile, $msg);
	
					//return \Redirect::to('/auth/otp-login/'.$token.'/'.$otp);
					//$input1 = (\Crypt::decrypt($input));
					
					$resp = [];
					$resp['status'] = 604;
					$resp['token'] = $token;
					$resp['usernameStr'] = "+".join(' ', str_split($username, 3));
					$resp['success'] = true;
					$resp['message'] = 'Please provide your secure pin';

					//return \Redirect::to('/ajax-otp-collection-view.html/{{OTP_COLLECTION_VIEW}}/'.$input.'/'.$all['orderId']);
					return \Response::json($resp);
				}


			}else if(isset($authData->status) && $authData->status!=null && $authData->status == 605) {

				//dd(33);
				/*$token = $authData->token;
				//$token = \Crypt::encrypt($token);
				$otp = $authData->otp;
				$mobile = $authData->otprecmobile;
				//$msg = "Logging Into ProbasePay.com? \nYour One Time Password is ".$otp."\n\nThank You.";
				//send_sms($mobile, $msg);

				//return \Redirect::to('/auth/otp-login/'.$token.'/'.$otp);
				//$input1 = (\Crypt::decrypt($input));
				
				$resp = [];
				$resp['status'] = 604;
				$resp['token'] = $token;
				$resp['usernameStr'] = "+".join(' ', str_split($username, 3));
				$resp['success'] = true;
				$resp['message'] = 'Please provide your secure pin';

				//return \Redirect::to('/ajax-otp-collection-view.html/{{OTP_COLLECTION_VIEW}}/'.$input.'/'.$all['orderId']);
				return \Response::json($resp);*/
				$data = $data.'&deviceId='. $all['identifier'];
        			$data = $data.'&deviceVersion='. $all['deviceVersion'];
        			$data = $data.'&deviceName='. $all['deviceName'];
        			$data = $data.'&deviceKey='. $all['deviceKey'];
        			$data = $data.'&deviceAppId='. $all['deviceId'];

				return \Response::json(['status'=>605, 'success'=>true, 'deviceVersion'=>$all['deviceVersion'], 'deviceName'=>$all['deviceName'], 'deviceKey'=>$all['deviceKey'], 'message'=>'It seems you are logging in from a new device. Check your SMS message for a one-time password',
					'deviceAppId'=>$all['deviceId'], 'deviceId'=>$all['identifier'], 'isMobile'=>$isMobile, 'autoAuthenticate'=>$autoAuthenticate, 'acquirerCode'=>$defaultAcquirer['acquirerCode']]);

			}else
			{
				$resp = [];
				$resp['status'] = 0;
				$resp['message'] = isset($authData->message) ? $authData->message : 'Error logging in. Please try again later';
				return \Response::json($resp);
			}
		}catch(\Exception $e)
		{
			
			$resp = [];
			$resp['status'] = 0;
			$resp['message'] = 'Error logging in. Please try again later'.$e->getLine();
			return \Response::json($resp);
		}

	}





	
	public function postLoginJSONResponseByDevice(Request $request)
	{
		//return \Response::json(['data'=>$request->all()]);
		$all = $request->except('username');
		$username = $request->get('username');
		$deviceAppId = (string)($request->get('deviceAppId'));
		$isMobile = ($request->get('isMobile'));
		$autoAuthenticate = ($request->get('autoAuthenticate'));
		//$password = encrypt(($password));
		
		
		try {
			
			$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
			$defaultAcquirer = $defaultAcquirer->toArray();

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/authenticateUsersByDeviceId';
			//$data['username'] = $username;
			//$data['password'] = $password;//dd($data);
			$data = 'username='.urlencode($username)."&deviceAppId=".urlencode($deviceAppId)."&acquirerCode=".$defaultAcquirer['acquirerCode'];
			$data = $data.'&autoAuthenticate='.$autoAuthenticate.'&deviceCode='.$request->get('deviceCode').'&merchantId='.$request->get('merchantId');
			$data = $data.'&isMobile=1';


			//return \Response::json(['data'=>$data]);

			$server_output = sendPostRequest($url, $data);
			$authData = json_decode($server_output);
			//return \Response::json(['data'=>$authData->status]);
					$ap = new \App\Models\AppError();
					$ap->error_trace = json_encode($authData );
					$ap->url = "";
					$ap->error_dump = json_encode($authData );
					$ap->user_username = "";
					$ap->save();

			

			if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {

				//dd(33);
				$token = $authData->token;


				$user = new User();
                		$user->id =($authData->id);
                		$user->username = $authData->username;
                		$user->token = $authData->token;
               		$user->role_code = $authData->role_code;
                		$user->profile_pix = (isset($authData->profile_pix) && $authData->profile_pix!=null) ? $authData->profile_pix : null;
               		$user->staff_bank_code = isset($authData->staff_bank_code) ? $authData->staff_bank_code : null;
                		$user->mobileno = $authData->mobileno;
               		$user->merchant_dec_key = (isset($authData->merchant_key) && $authData->merchant_key!=null) ? $authData->merchant_key : null;
                		$user->merchant_id = (isset($authData->merchant_id) && $authData->merchant_id!=null) ? $authData->merchant_id : null;
                		$user->customerVerificationNo = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
				$token = JWTAuth::fromUser($user);


				
				$resp = [];
				$resp['jwt_token'] = $token;
                    		$resp['server_token'] = $authData->token;
                    		$resp['auth_id'] = $authData->id;
                   		$resp['roleCode'] = $authData->role_code;
                    		$resp['mobileNumber'] = $authData->mobileno;
                    		$resp['username'] = $authData->username;
                    		$resp['accounts'] = isset($authData->accounts) ? json_encode($authData->accounts) : json_encode([]);
                    		$resp['cards'] = isset($authData->ecards) ? json_encode($authData->ecards) : json_encode([]);
                    		$resp['status'] = 100;
                    		$resp['success'] = true;
                    		$resp['displayName'] = $authData->firstName." ".$authData->lastName;
                    		$resp['profile_pix'] = isset($authData->profile_pix) && $authData->profile_pix!=null ? $authData->profile_pix : null;
                    		$resp['userData'] = $authData;
                    		$resp['walletExists'] =isset($authData->walletExists) ? $authData->walletExists : false;
                    		$resp['ecardExists'] = isset($authData->ecardExists) ? $authData->ecardExists : false;
                    		$resp['customerVerificationNo'] = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
				$resp['cardSupport'] = isset($authData->cardSupport) ? $authData->cardSupport : null;
				$resp['isBiometric'] = isset($authData->isBiometric) ? $authData->isBiometric: null;
				$resp['fundsTransferCharges'] = isset($authData->fundsTransferCharges) ? $authData->fundsTransferCharges: null;
				$resp['fundsTransferToOthersCharges'] = isset($authData->fundsTransferToOthersCharges) && $authData->fundsTransferToOthersCharges!=null ? $authData->fundsTransferToOthersCharges: null;

				$resp['token'] = $token;
				$resp['usernameStr'] = "+".join(' ', str_split($authData->username, 3));
				$resp['message'] = 'Logged in successfully';
                    		$resp['customerId'] = isset($authData->customer_id) ? $authData->customer_id : null;
				$resp['forcePasswordChange'] = isset($authData->forcePasswordChange) ? $authData->forcePasswordChange : null;
				$resp['groupInvitations'] = isset($authData->groupInvitations) ? $authData->groupInvitations: null;









				

				//return \Redirect::to('/ajax-otp-collection-view.html/{{OTP_COLLECTION_VIEW}}/'.$input.'/'.$all['orderId']);
				return \Response::json($resp);

			}else
			{
				$resp = [];
				$resp['status'] = 0;
				$resp['message'] = isset($authData->message) ? $authData->message : 'Error logging in. Please try again later';
				return \Response::json($resp);
			}
		}catch(\Exception $e)
		{
			
			$resp = [];
			$resp['status'] = 0;
			$resp['message'] = 'Error logging in. Please try again later'.$e->getMessage();
			return \Response::json($resp);
		}

	}



    public function postLoginToPayJSONResponse(Request $request)
        {

            $sessionContainer = [];
            if(\Session::has('error') || \Session::has('message'))
            {
                $sessionError = \Session::get('error');
                $sessionMessage = \Session::get('message');
                $sessionContainer['error'] = $sessionError;
                $sessionContainer['message'] = $sessionMessage;
            }




            $all = $request->except('username');
		$countrycode = $request->get('countrycode');
            $username = $request->get('username');
            $password = encrypt(($request->get('password')));
            $input = $all['data'];

		$inputId = \Crypt::decrypt($input);
		$billdata = \App\Models\BillData::where('id', '=', $inputId)->first();
		$data = $billdata->data;
		$data1 = json_decode($data);
		//dd($data);

		if($countrycode!=null)
		{
			$username = $countrycode."".$username;
		}


            //dd($username);
            try {
                $defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
                $defaultAcquirer = $defaultAcquirer->toArray();

                $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/authenticateUsers';
                //$data['username'] = $username;
                //$data['password'] = $password;//dd($data);
                $data = 'username='.$username."&encPassword=".$password."&acquirerCode=".$defaultAcquirer['acquirerCode']."&merchantId=".$data1->merchantId."&deviceCode=".$data1->deviceCode;





                $server_output = sendPostRequest($url, $data);
                $authData = json_decode($server_output);

				//dd($authData);

			if(isset($authData->status) && $authData->status!=null && $authData->status == 604) {

				//dd(33);
				$token = $authData->token;
				//$token = \Crypt::encrypt($token);
				$otp = $authData->otp;
				$mobile = $authData->otprecmobile;
				$txn_ref = $all['orderId'];
				$msg = "Logging Into ProbasePay.com? \nYour One Time Password is ".$otp."\n\nThank You.";
				//send_sms($mobile, $msg);

				//return \Redirect::to('/auth/otp-login/'.$token.'/'.$otp);
				//$input1 = (\Crypt::decrypt($input));
				$key = OTP_COLLECTION_VIEW;
				
				$billdata->token_data = $token;
				$billdata->username = $username;
				$billdata->save();
				//return view('guests.payment.web.otp-collection-view', compact('token', 'all', 'itemAmounts', 'input', 'orderId', 'currency'));

				$resp = [];
				$resp['key'] = $key;
				$resp['input'] = $input;
				$resp['status'] = 100;
				$resp['success'] = true;
				$resp['txn_ref'] = $all['orderId'];
				$resp['message'] = 'Please provide the One-Time Password sent to your phone';
				$resp['isBiometric'] = isset($authData->isBiometric) ? $authData->isBiometric: null;
				$resp['fundsTransferCharges'] = isset($authData->fundsTransferCharges) ? $authData->fundsTransferCharges: null;
				$resp['fundsTransferToOthersCharges'] = isset($authData->fundsTransferToOthersCharges) && $authData->fundsTransferToOthersCharges!=null ? $authData->fundsTransferToOthersCharges: null;

				$resp['forcePasswordChange'] = isset($authData->forcePasswordChange) ? $authData->forcePasswordChange : null;
				$resp['groupInvitations'] = isset($authData->groupInvitations) ? $authData->groupInvitations: null;
				//return \Redirect::to('/ajax-otp-collection-view.html/{{OTP_COLLECTION_VIEW}}/'.$input.'/'.$all['orderId']);
				return \Response::json($resp);

			}
			/*
			OLD VERSION FOR 600 Status
			else if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {

				//dd(33);
				$token = $authData->token;



				//return \Redirect::to('/auth/otp-login/'.$token.'/'.$otp);
				//$input1 = (\Crypt::decrypt($input));
				$key = OTP_COLLECTION_VIEW;
				$inputId = \Crypt::decrypt($input);
				$billdata = \App\Models\BillData::where('id', '=', $inputId)->first();
				$billdata->token_data = $token;
				$billdata->username = $username;
				$billdata->save();
				//return view('guests.payment.web.otp-collection-view', compact('token', 'all', 'itemAmounts', 'input', 'orderId', 'currency'));

				$resp = [];
				$resp['key'] = $key;
				$resp['input'] = $input;
				$resp['status'] = 100;
				$resp['success'] = true;
				$resp['txn_ref'] = $all['orderId'];
				$resp['message'] = 'Please provide the One-Time Password sent to your phone';
				$resp['isBiometric'] = isset($authData->isBiometric) ? $authData->isBiometric: null;
				$resp['fundsTransferCharges'] = isset($authData->fundsTransferCharges) ? $authData->fundsTransferCharges: null;
				$resp['fundsTransferToOthersCharges'] = isset($authData->fundsTransferToOthersCharges) && $authData->fundsTransferToOthersCharges!=null ? $authData->fundsTransferToOthersCharges: null;

				$resp['forcePasswordChange'] = isset($authData->forcePasswordChange) ? $authData->forcePasswordChange : null;
				$resp['groupInvitations'] = isset($authData->groupInvitations) ? $authData->groupInvitations: null;
				//return \Redirect::to('/ajax-otp-collection-view.html/{{OTP_COLLECTION_VIEW}}/'.$input.'/'.$all['orderId']);
				return \Response::json($resp);
				

			}*/
			else if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {

				
				$inputId = \Crypt::decrypt($input);
				$billdata = \App\Models\BillData::where('id', '=', $inputId)->first();
				$billdata->token_data = $authData->token;
				$billdata->username = $username;
				$billdata->save();

				$user = new User();
				$user->id =($authData->id);
				$user->username = $authData->username;
				$user->token = $authData->token;
				$user->role_code = $authData->role_code;
				$user->profile_pix = (isset($authData->profile_pix) && $authData->profile_pix!=null) ? $authData->profile_pix : null;
				$user->staff_bank_code = isset($authData->staff_bank_code) ? $authData->staff_bank_code : null;
				$user->mobileno = $authData->mobileno;
				$user->merchant_dec_key = (isset($authData->merchant_key) && $authData->merchant_key!=null) ? $authData->merchant_key : null;
				$user->merchant_id = (isset($authData->merchant_id) && $authData->merchant_id!=null) ? $authData->merchant_id : null;
				$user->customerVerificationNo = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
				//$user->dashboardStatistics = (isset($authData->dashboardStatistics) && $authData->dashboardStatistics!=null) ? $authData->dashboardStatistics : null;
				$this->auth->login($user, $server_output);

				//dd(\Auth::user());
				$token = JWTAuth::fromUser($user);
				//dd($token);

				$loginKey = 'login_'.$authData->id;
				$jwtKey = 'jwt_token';
				\Session::put('auth_id', $authData->id);
				\Session::put($loginKey, $server_output);
				\Session::put($jwtKey, $token);
				\Session::put('accounts', isset($authData->accounts) ? json_encode($authData->accounts) : json_encode([]));
				\Session::put('cards', isset($authData->ecards) ? json_encode($authData->ecards) : json_encode([]));



				//dd(\Session::all());

				if($user->role_code=='CUSTOMER')
				{


					$key = PAY_FROM_LOGGED_IN_WALLET;
					$resp = [];
					$resp['key'] = $key;
					$resp['input'] = $input;
					$resp['status'] = 105;	//NO PIN REQUIRED
					$resp['success'] = true;
					$resp['txn_ref'] = $billdata->orderId;
					//$resp['sess'] = Jjson_encode(\Session::all());

					//dd(\Auth::user());
					//return \Redirect::to('/ajax-pay-from-logged-in-wallet.html/'.PAY_FROM_LOGGED_IN_WALLET.'/'.$billIdEnc.'/'.$billdata->orderId);
					return \Response::json($resp);
				}
				else
				{
					u_logout();

					$key = PAYMENT_DETAILS_LISTING;
					$resp = [];
					$resp['key'] = $key;
					$resp['input'] = $billIdEnc;
					$resp['status'] = 101;
					$resp['success'] = true;
					$resp['txn_ref'] = $billdata->orderId;
					$resp['message'] = 'Sign up for a customer wallet to pay using Bevura';
					return \Response::json($resp);
				}




			}
			else
			{
				$resp = [];
				$resp['input'] = $input;
				$resp['status'] = 0;
				$resp['message'] = isset($authData->message) ? $authData->message : 'Error logging in. Please try again later';
				return \Response::json($resp);
			}

            }catch(\Exception $e)
            {
                $resp = [];
                $resp['input'] = $input;
                $resp['status'] = 0;
                $resp['message'] = 'Error logging in. Please try again later'.$e->getLine();
                return \Response::json($resp);
            }

        }



    public function postLoginOTPToPayJsonResponse(Request $request)
    {
		//dd($all);
        $otp = $request->get('otp1')."".$request->get('otp2')."".$request->get('otp3')."".$request->get('otp4');
        $otp = \Crypt::encrypt($otp);
        $token = ($request->get('token'));
        $all = ($request->all());
        $billIdEnc = ($request->get('data'));
        $billId = \Crypt::decrypt($billIdEnc);
        $bill = \App\Models\BillData::where('id', '=', $billId)->first();
	$d1 = $bill->data;
	$d1 = json_decode($d1);
	$merchantId_ = $d1->merchantId;
	$deviceCode_ = $d1->deviceCode;


        $billData = null;
        if($bill!=null)
        {
            $billData = $bill->data;
            $billData = json_decode($bill->data, TRUE);
        }
        else
        {
            //return \Redirect::to('/exit');
            u_logout();
            $resp = [];
            $resp['status'] = -99;
            $resp['success'] = false;
            $resp['txn_ref'] = $billData['orderId'];
            $resp['message'] = 'Invalid payment request';

            return \Response::json($resp);
        }
        $all = $request->all();


         try {

            $data = 'otp='.$otp.'&token='.$token.'&merchantId='.$merchantId_.'&deviceCode='.$deviceCode_;
            //$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/authenticateUserVerifyOTP';
            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/authenticateUserVerifyPin';

            $authDataStr = sendPostRequest($url, $data);
            $authData = json_decode($authDataStr);

		//dd($authData);


             if(isset($authData->status) && $authData->status!=null && $authData->status == 3100) {

                 u_logout();
                 $resp = [];
                 $resp['input'] = $billIdEnc;
                 $resp['status'] = -1;
                 $resp['success'] = false;
                 $resp['txn_ref'] = $billData['orderId'];
                 $resp['message'] = 'Your one-time password has expired. Please log in again';

                 return \Response::json($resp);
             }
             else if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {
                $user = new User();
                $user->id =($authData->id);
                $user->username = $authData->username;
                $user->token = $authData->token;
                $user->role_code = $authData->role_code;
                $user->profile_pix = (isset($authData->profile_pix) && $authData->profile_pix!=null) ? $authData->profile_pix : null;
                $user->staff_bank_code = isset($authData->staff_bank_code) ? $authData->staff_bank_code : null;
                $user->mobileno = $authData->mobileno;
                $user->merchant_dec_key = (isset($authData->merchant_key) && $authData->merchant_key!=null) ? $authData->merchant_key : null;
                $user->merchant_id = (isset($authData->merchant_id) && $authData->merchant_id!=null) ? $authData->merchant_id : null;
                $user->customerVerificationNo = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
                //$user->dashboardStatistics = (isset($authData->dashboardStatistics) && $authData->dashboardStatistics!=null) ? $authData->dashboardStatistics : null;
                $this->auth->login($user, $authDataStr);

                //dd(\Auth::user());
                $token = JWTAuth::fromUser($user);
                //dd($token);

                $loginKey = 'login_'.$authData->id;
                $jwtKey = 'jwt_token';
                \Session::put('auth_id', $authData->id);
                \Session::put($loginKey, $authDataStr);
                \Session::put($jwtKey, $token);
                \Session::put('accounts', isset($authData->accounts) ? json_encode($authData->accounts) : json_encode([]));
                \Session::put('cards', isset($authData->ecards) ? json_encode($authData->ecards) : json_encode([]));



                //dd(\Session::all());

                if($user->role_code=='CUSTOMER')
                {

                    $key = PAY_FROM_LOGGED_IN_WALLET;
                    $resp = [];
                    $resp['key'] = $key;
                    $resp['input'] = $billIdEnc;
                    $resp['status'] = 100;
                    $resp['success'] = true;
                    $resp['txn_ref'] = $billData['orderId'];
                    //$resp['sess'] = Jjson_encode(\Session::all());

                    //dd(\Auth::user());
                    //return \Redirect::to('/ajax-pay-from-logged-in-wallet.html/'.PAY_FROM_LOGGED_IN_WALLET.'/'.$billIdEnc.'/'.$billData['orderId']);
                    return \Response::json($resp);
                }
                else
                {
                    u_logout();

                    $key = PAYMENT_DETAILS_LISTING;
                    $resp = [];
                    $resp['key'] = $key;
                    $resp['input'] = $billIdEnc;
                    $resp['status'] = 101;
                    $resp['success'] = true;
                    $resp['txn_ref'] = $billData['orderId'];
                    $resp['message'] = 'Sign up for a customer wallet to pay using Bevura';
                    return \Response::json($resp);
                }




            }else
            {
                u_logout();

                $key = PAYMENT_DETAILS_LISTING;
                $resp = [];
                $resp['key'] = $key;
                $resp['input'] = $billIdEnc;
                $resp['status'] = -1;
                $resp['success'] = true;
                $resp['txn_ref'] = $billData['orderId'];
                $resp['message'] = 'Invalid One-Time Password provided. We could not log you in. Try logging again';
                return \Response::json($resp);
            }
        }catch(\Exception $e)
        {
            u_logout();
            $key = PAYMENT_DETAILS_LISTING;
            $resp = [];
            $resp['key'] = $key;
            $resp['input'] = $billIdEnc;
            $resp['status'] = 500;
            $resp['success'] = true;
            $resp['txn_ref'] = $billData['orderId'];
            $resp['message'] = 'We could not log you in. Try logging again';
            return \Response::json($resp);
        }
    }
	
	




	public function postLoginPinToPayJsonResponse(Request $request)
    {
		//dd($all);
        $otp = $request->get('otp1')."".$request->get('otp2')."".$request->get('otp3')."".$request->get('otp4');
        $otp = \Crypt::encrypt($otp);
        $token = ($request->get('token'));
        $all = ($request->all());
        $billIdEnc = ($request->get('data'));
        $billId = \Crypt::decrypt($billIdEnc);
        $bill = \App\Models\BillData::where('id', '=', $billId)->first();
	$d1 = $bill->data;
	$d1 = json_decode($d1);
	$merchantId_ = $d1->merchantId;
	$deviceCode_ = $d1->deviceCode;


        $billData = null;
        if($bill!=null)
        {
            $billData = $bill->data;
            $billData = json_decode($bill->data, TRUE);
        }
        else
        {
            //return \Redirect::to('/exit');
            u_logout();
            $resp = [];
            $resp['status'] = -99;
            $resp['success'] = false;
            $resp['txn_ref'] = $billData['orderId'];
            $resp['message'] = 'Invalid payment request';

            return \Response::json($resp);
        }
        $all = $request->all();


         try {

            $data = 'otp='.$otp.'&token='.$token.'&merchantId='.$merchantId_.'&deviceCode='.$deviceCode_;
            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/authenticateUserVerifyPin';
            $authDataStr = sendPostRequest($url, $data);
            $authData = json_decode($authDataStr);

		//dd([$data, $authData);


             if(isset($authData->status) && $authData->status!=null && $authData->status == 3100) {

                 u_logout();
                 $resp = [];
                 $resp['input'] = $billIdEnc;
                 $resp['status'] = -1;
                 $resp['success'] = false;
                 $resp['txn_ref'] = $billData['orderId'];
                 $resp['message'] = 'Your 2FA-Secure Pin has expired. Please log in again';

                 return \Response::json($resp);
             }
             else if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {
                $user = new User();
                $user->id =($authData->id);
                $user->username = $authData->username;
                $user->token = $authData->token;
                $user->role_code = $authData->role_code;
                $user->profile_pix = (isset($authData->profile_pix) && $authData->profile_pix!=null) ? $authData->profile_pix : null;
                $user->staff_bank_code = isset($authData->staff_bank_code) ? $authData->staff_bank_code : null;
                $user->mobileno = $authData->mobileno;
                $user->merchant_dec_key = (isset($authData->merchant_key) && $authData->merchant_key!=null) ? $authData->merchant_key : null;
                $user->merchant_id = (isset($authData->merchant_id) && $authData->merchant_id!=null) ? $authData->merchant_id : null;
                $user->customerVerificationNo = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
                //$user->dashboardStatistics = (isset($authData->dashboardStatistics) && $authData->dashboardStatistics!=null) ? $authData->dashboardStatistics : null;
                $this->auth->login($user, $authDataStr);

                //dd(\Auth::user());
                $token = JWTAuth::fromUser($user);
                //dd($token);

                $loginKey = 'login_'.$authData->id;
                $jwtKey = 'jwt_token';
                \Session::put('auth_id', $authData->id);
                \Session::put($loginKey, $authDataStr);
                \Session::put($jwtKey, $token);
                \Session::put('accounts', isset($authData->accounts) ? json_encode($authData->accounts) : json_encode([]));
                \Session::put('cards', isset($authData->ecards) ? json_encode($authData->ecards) : json_encode([]));



                //dd(\Session::all());

                if($user->role_code=='CUSTOMER')
                {

                    $key = PAY_FROM_LOGGED_IN_WALLET;
                    $resp = [];
                    $resp['key'] = $key;
                    $resp['input'] = $billIdEnc;
                    $resp['status'] = 100;
                    $resp['success'] = true;
                    $resp['txn_ref'] = $billData['orderId'];
                    //$resp['sess'] = Jjson_encode(\Session::all());

                    //dd(\Auth::user());
                    //return \Redirect::to('/ajax-pay-from-logged-in-wallet.html/'.PAY_FROM_LOGGED_IN_WALLET.'/'.$billIdEnc.'/'.$billData['orderId']);
                    return \Response::json($resp);
                }
                else
                {
                    u_logout();

                    $key = PAYMENT_DETAILS_LISTING;
                    $resp = [];
                    $resp['key'] = $key;
                    $resp['input'] = $billIdEnc;
                    $resp['status'] = 101;
                    $resp['success'] = true;
                    $resp['txn_ref'] = $billData['orderId'];
                    $resp['message'] = 'Sign up for a customer wallet to pay using Bevura';
                    return \Response::json($resp);
                }




            }else
            {
                u_logout();

                $key = PAYMENT_DETAILS_LISTING;
                $resp = [];
                $resp['key'] = $key;
                $resp['input'] = $billIdEnc;
                $resp['status'] = -1;
                $resp['success'] = true;
                $resp['txn_ref'] = $billData['orderId'];
                $resp['message'] = 'Invalid 2FA-Secure Pin provided. We could not log you in. Try logging again';
                return \Response::json($resp);
            }
        }catch(\Exception $e)
        {
            u_logout();
            $key = PAYMENT_DETAILS_LISTING;
            $resp = [];
            $resp['key'] = $key;
            $resp['input'] = $billIdEnc;
            $resp['status'] = 500;
            $resp['success'] = true;
            $resp['txn_ref'] = $billData['orderId'];
            $resp['message'] = 'We could not log you in. Try logging again';
            return \Response::json($resp);
        }
    }
	
	







    public function postLoginOTPToCreateWalletJsonResponse(Request $request)
    {
		//dd($all);
        $otp = $request->get('otp1')."".$request->get('otp2')."".$request->get('otp3')."".$request->get('otp4');
        //$otp = \Crypt::encrypt($otp);
        $token = ($request->get('token'));
	 $customerVerificationNo = $request->get('customerVerificationNo');
	 $deviceCode = $request->get('deviceCode');
	 $scope = $request->get('scope');
        $all = ($request->all());
        $billIdEnc = ($request->get('data'));
        $billId = \Crypt::decrypt($billIdEnc);
        $bill = \App\Models\BillData::where('id', '=', $billId)->first();
        $billData = null;
        if($bill!=null)
        {
            $billData = $bill->data;
            $billData = json_decode($bill->data, TRUE);
 	     $billData['scope'] = $scope;
	     $bill->data = json_encode($billData);
	     $bill->save();
        }
        else
        {
            //return \Redirect::to('/exit');
            u_logout();
            $resp = [];
            $resp['status'] = -99;
            $resp['success'] = false;
            $resp['txn_ref'] = $billData['orderId'];
            $resp['message'] = 'Invalid payment request';

            return \Response::json($resp);
        }
        $all = $request->all();


         try {

            $data = 'customerVerificationNo='.$customerVerificationNo.'&deviceCode='.$deviceCode.'&otp='.$otp;
            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/confirmOTPAndCreateWallet';
            $authDataStr = sendPostRequest($url, $data);
            $authData = json_decode($authDataStr);


             if(isset($authData->status) && $authData->status!=null && $authData->status == 5000) {
                 $resp = [];
                 $resp['customerName'] = $authData->customerName;
                 $resp['customerNumber'] = $authData->customerNumber;
                 $resp['customerId'] = $authData->customerId;
                 $resp['accountIdentifier'] = $authData->accountIdentifier;
                 $resp['status'] = $authData->status;
                 $resp['responseUrl'] = $authData->responseUrl;
                 $resp['message'] = $authData->message;
		   $resp['scope'] = $scope;
                 return \Response::json($resp);





            }
	     else {

                 u_logout();
                 $resp = [];
                 $resp['input'] = $billIdEnc;
                 $resp['status'] = $authData->status;
                 $resp['message'] = $authData->message;

                 return \Response::json($resp);
             }
        }catch(\Exception $e)
        {
            u_logout();
            $key = PAYMENT_DETAILS_LISTING;
            $resp = [];
            $resp['input'] = $billIdEnc;
            $resp['status'] = $authData->status;
            $resp['message'] = $authData->message;

            return \Response::json($resp);
        }
    }


	

    public function postValidateOtpJsonResponse(Request $request)
    {
		//dd($all);
        $otp = $request->get('otp');
        $otp = \Crypt::encrypt($otp);
        $token = ($request->get('token'));

         try {

            $data = 'otp='.$otp.'&token='.$token;
            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/authenticateUserVerifyOTP';
            $authDataStr = sendPostRequest($url, $data);
            $authData = json_decode($authDataStr);


             if(isset($authData->status) && $authData->status!=null && $authData->status == 3100) {

                 $resp = [];
                 $resp['status'] = -1;
                 $resp['success'] = false;
                 $resp['message'] = 'Your one-time password has expired. Please log in again';

                 return \Response::json($resp);
             }
             else if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {
				 
                $user = new User();
                $user->id =($authData->id);
                $user->username = $authData->username;
                $user->token = $authData->token;
                $user->role_code = $authData->role_code;
                $user->profile_pix = (isset($authData->profile_pix) && $authData->profile_pix!=null) ? $authData->profile_pix : null;
                $user->staff_bank_code = isset($authData->staff_bank_code) ? $authData->staff_bank_code : null;
                $user->mobileno = $authData->mobileno;
                $user->merchant_dec_key = (isset($authData->merchant_key) && $authData->merchant_key!=null) ? $authData->merchant_key : null;
                $user->merchant_id = (isset($authData->merchant_id) && $authData->merchant_id!=null) ? $authData->merchant_id : null;
                $user->customerVerificationNo = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;

                //dd(\Auth::user());
                $token = JWTAuth::fromUser($user);

                if($user->role_code=='CUSTOMER')
                {
                    $resp = [];
                    $resp['jwt_token'] = $token;
                    $resp['server_token'] = $authData->token;
                    $resp['auth_id'] = $authData->id;
                    $resp['roleCode'] = $authData->role_code;
                    $resp['mobileNumber'] = $authData->mobileno;
                    $resp['username'] = $authData->username;
                    $resp['accounts'] = isset($authData->accounts) ? json_encode($authData->accounts) : json_encode([]);
                    $resp['cards'] = isset($authData->ecards) ? json_encode($authData->ecards) : json_encode([]);
                    $resp['status'] = 100;
                    $resp['success'] = true;
                    $resp['displayName'] = $authData->firstName." ".$authData->lastName;
                    $resp['profile_pix'] = isset($authData->profile_pix) && $authData->profile_pix!=null ? $authData->profile_pix : null;
                    $resp['userData'] = $authData;
                    $resp['walletExists'] =isset($authData->walletExists) ? $authData->walletExists : false;
                    $resp['ecardExists'] = isset($authData->ecardExists) ? $authData->ecardExists : false;
                    $resp['customerVerificationNo'] = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
		      $resp['cardSupport'] = isset($authData->cardSupport) ? $authData->cardSupport : null;
					
                    return \Response::json($resp);
                }
                else
                {
                    
                    $resp = [];
                    $resp['key'] = $key;
                    $resp['status'] = 101;
                    $resp['success'] = true;
                    $resp['message'] = 'Sign up for a customer wallet to pay using this Bevura app';
                    return \Response::json($resp);
                }




            }else
            {
                $resp = [];
                $resp['status'] = -1;
                $resp['success'] = true;
                $resp['message'] = 'Invalid One-Time Password provided. We could not log you in. Try logging again';
                return \Response::json($resp);
            }
        }catch(\Exception $e)
        {
            $resp = [];
            $resp['status'] = 500;
            $resp['success'] = true;
            $resp['message'] = 'We could not log you in. Try logging again';
            return \Response::json($resp);
        }
    }




    public function postValidateOtpByAppDeviceJsonResponse(Request $request)
    {
		//dd($all);
        $otp = $request->get('otp');
        $otp = \Crypt::encrypt($otp);
        $token = ($request->get('token'));

         try {






			$deviceVersion= ($request->get('deviceVersion'));
			$deviceName= ($request->get('deviceName'));
			$deviceKey= ($request->get('deviceKey'));
			$deviceAppId= ($request->get('deviceAppId'));
			$deviceId= ($request->get('deviceId'));
			$acquirerCode= ($request->get('acquirerCode'));
			$isMobile= ($request->get('isMobile'));
			$autoAuthenticate= ($request->get('autoAuthenticate'));
			$username= ($request->get('username'));
			$password= ($request->get('password'));

			$data = 'otp='.$otp.'&merchantId='.PROBASEWALLET_MERCHANT_CODE.'&deviceCode='.PROBASEWALLET_DEVICE_CODE;


			if($deviceId!=null)
			{
				$data = $data."&deviceId=".$deviceId;
			}
			if($deviceKey!=null)
			{
				$data = $data."&deviceKey=".$deviceKey;
			}
			if($deviceAppId!=null)
			{
				$data = $data."&deviceAppId=".$deviceAppId;
			}

			if($acquirerCode!=null)
			{
				$data = $data."&acquirerCode=".$acquirerCode;
			}
			if($isMobile!=null)
			{
				$data = $data."&isMobile=".$isMobile;
			}
			if($autoAuthenticate!=null)
			{
				$data = $data."&autoAuthenticate=".$autoAuthenticate;
			}

			if($username!=null)
			{
				$data = $data."&username=".$username;
			}
			if($password!=null)
			{
				$data = $data."&encPassword=".encrypt($password);
			}





            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/authenticateUserVerifyDeviceAppOTP';
            $authDataStr = sendPostRequest($url, $data);
            $authData = json_decode($authDataStr);





             if(isset($authData->status) && $authData->status!=null && $authData->status == 3100) {

                 $resp = [];
                 $resp['status'] = -1;
                 $resp['success'] = false;
                 $resp['message'] = 'Your one-time password has expired. Please log in again';

                 return \Response::json($resp);
             }
             else if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {
				 
                $user = new User();
                $user->id =($authData->id);
                $user->username = $authData->username;
                $user->token = $authData->token;
                $user->role_code = $authData->role_code;
                $user->profile_pix = (isset($authData->profile_pix) && $authData->profile_pix!=null) ? $authData->profile_pix : null;
                $user->staff_bank_code = isset($authData->staff_bank_code) ? $authData->staff_bank_code : null;
                $user->mobileno = $authData->mobileno;
                $user->merchant_dec_key = (isset($authData->merchant_key) && $authData->merchant_key!=null) ? $authData->merchant_key : null;
                $user->merchant_id = (isset($authData->merchant_id) && $authData->merchant_id!=null) ? $authData->merchant_id : null;
                $user->customerVerificationNo = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;

                //dd(\Auth::user());
                $token = JWTAuth::fromUser($user);

                if($user->role_code=='CUSTOMER' || $user->role_code=='AGENT')
                {
                    $resp = [];
                    $resp['jwt_token'] = $token;
                    $resp['server_token'] = $authData->token;
                    $resp['auth_id'] = $authData->id;
                    $resp['roleCode'] = $authData->role_code;
                    $resp['mobileNumber'] = $authData->mobileno;
                    $resp['username'] = $authData->username;
                    $resp['accounts'] = isset($authData->accounts) ? json_encode($authData->accounts) : json_encode([]);
                    $resp['cards'] = isset($authData->ecards) ? json_encode($authData->ecards) : json_encode([]);
                    $resp['status'] = 100;
                    $resp['success'] = true;
                    $resp['displayName'] = $authData->firstName." ".$authData->lastName;
                    $resp['profile_pix'] = isset($authData->profile_pix) && $authData->profile_pix!=null ? $authData->profile_pix : null;
                    $resp['userData'] = $authData;
                    $resp['walletExists'] =isset($authData->walletExists) ? $authData->walletExists : false;
                    $resp['ecardExists'] = isset($authData->ecardExists) ? $authData->ecardExists : false;
                    $resp['customerVerificationNo'] = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
		      $resp['cardSupport'] = isset($authData->cardSupport) ? $authData->cardSupport : null;
					
                    return \Response::json($resp);
                }
                else
                {
                    
                    $resp = [];
                    $resp['key'] = $key;
                    $resp['status'] = 101;
                    $resp['success'] = true;
                    $resp['message'] = 'Sign up for a customer wallet to pay using this Bevura app';
                    return \Response::json($resp);
                }




            }else
            {
                $resp = [];
                $resp['status'] = -1;
                $resp['success'] = true;
                $resp['message'] = 'Invalid One-Time Password provided. We could not log you in. Try logging again';
                return \Response::json($resp);
            }
        }catch(\Exception $e)
        {
            $resp = [];
            $resp['status'] = 500;
            $resp['success'] = true;
            $resp['message'] = 'We could not log you in. Try logging again'.$e->getLine();
            return \Response::json($resp);
        }
    }






    public function postValidatePinJsonResponse(Request $request)
    {
		//dd($all);
        $otp = $request->get('otp');
        $otp = \Crypt::encrypt($otp);
        $token = ($request->get('token'));
        $merchantCode = ($request->get('merchantCode'));
        $deviceCode = ($request->get('deviceCode'));

         try {

            $data = 'otp='.$otp.'&token='.$token.'&merchantId='.$merchantCode.'&deviceCode='.$deviceCode;
            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/authenticateUserVerifyPin';
            $authDataStr = sendPostRequest($url, $data);
            $authData = json_decode($authDataStr);


             if(isset($authData->status) && $authData->status!=null && $authData->status == 3100) {

                 $resp = [];
                 $resp['status'] = -1;
                 $resp['success'] = false;
                 $resp['message'] = 'Your one-time password has expired. Please log in again';

                 return \Response::json($resp);
             }
             else if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {
				 
                $user = new User();
                $user->id =($authData->id);
                $user->username = $authData->username;
                $user->token = $authData->token;
                $user->role_code = $authData->role_code;
                $user->profile_pix = (isset($authData->profile_pix) && $authData->profile_pix!=null) ? $authData->profile_pix : null;
                $user->staff_bank_code = isset($authData->staff_bank_code) ? $authData->staff_bank_code : null;
                $user->mobileno = $authData->mobileno;
                $user->merchant_dec_key = (isset($authData->merchant_key) && $authData->merchant_key!=null) ? $authData->merchant_key : null;
                $user->merchant_id = (isset($authData->merchant_id) && $authData->merchant_id!=null) ? $authData->merchant_id : null;
                $user->customerVerificationNo = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
                $user->isPinSet= isset($authData->isPinSet) ? $authData->isPinSet: null;

                //dd(\Auth::user());
                $token = JWTAuth::fromUser($user);

                if($user->role_code=='CUSTOMER')
                {
                    $resp = [];
                    $resp['jwt_token'] = $token;
                    $resp['server_token'] = $authData->token;
                    $resp['auth_id'] = $authData->id;
                    $resp['roleCode'] = $authData->role_code;
                    $resp['mobileNumber'] = $authData->mobileno;
                    $resp['username'] = $authData->username;
                    $resp['accounts'] = isset($authData->accounts) ? json_encode($authData->accounts) : json_encode([]);
                    $resp['cards'] = isset($authData->ecards) ? json_encode($authData->ecards) : json_encode([]);
                    $resp['status'] = 100;
                    $resp['success'] = true;
                    $resp['displayName'] = $authData->firstName." ".$authData->lastName;
                    $resp['profile_pix'] = isset($authData->profile_pix) && $authData->profile_pix!=null ? $authData->profile_pix : null;
                    $resp['userData'] = $authData;
                    $resp['walletExists'] =isset($authData->walletExists) ? $authData->walletExists : false;
                    $resp['ecardExists'] = isset($authData->ecardExists) ? $authData->ecardExists : false;
                    $resp['customerVerificationNo'] = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
		      $resp['cardSupport'] = isset($authData->cardSupport) ? $authData->cardSupport : null;
		      $resp['isPinSet'] = isset($authData->isPinSet) ? $authData->isPinSet: null;

			
			
			
		
                    return \Response::json($resp);
                }
                else if($user->role_code=='AGENT')
                {
                    $resp = [];
                    $resp['jwt_token'] = $token;
                    $resp['server_token'] = $authData->token;
                    $resp['auth_id'] = $authData->id;
                    $resp['roleCode'] = $authData->role_code;
                    $resp['mobileNumber'] = $authData->mobileno;
                    $resp['username'] = $authData->username;
                    $resp['accounts'] = isset($authData->accounts) ? json_encode($authData->accounts) : json_encode([]);
                    $resp['cards'] = isset($authData->ecards) ? json_encode($authData->ecards) : json_encode([]);
                    $resp['status'] = 100;
                    $resp['success'] = true;
                    $resp['displayName'] = $authData->firstName." ".$authData->lastName;
                    $resp['profile_pix'] = isset($authData->profile_pix) && $authData->profile_pix!=null ? $authData->profile_pix : null;
                    $resp['userData'] = $authData;
                    $resp['walletExists'] =isset($authData->walletExists) ? $authData->walletExists : false;
                    $resp['ecardExists'] = isset($authData->ecardExists) ? $authData->ecardExists : false;
                    $resp['customerVerificationNo'] = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
		      $resp['cardSupport'] = isset($authData->cardSupport) ? $authData->cardSupport : null;
		      $resp['isPinSet'] = isset($authData->isPinSet) ? $authData->isPinSet: null;
		      $resp['agentAccountBalance'] = isset($authData->agentAccountBalance) ? $authData->agentAccountBalance : null;

			
			
			
		
                    return \Response::json($resp);
                }
                else
                {
                    
                    $resp = [];
                    //$resp['key'] = $key;
                    $resp['status'] = 101;
                    $resp['success'] = true;
                    $resp['message'] = 'Sign up for a customer wallet to pay using this Bevura app';
                    return \Response::json($resp);
                }




            }else
            {
                $resp = [];
                $resp['status'] = -1;
                $resp['success'] = true;
                $resp['message'] = 'Invalid One-Time Password provided. We could not log you in. Try logging again';
                return \Response::json($resp);
            }
        }catch(\Exception $e)
        {
            $resp = [];
            $resp['status'] = 500;
            $resp['success'] = true;
            $resp['message'] = 'We could not log you in. Try logging again';
            return \Response::json($resp);
        }
    }




    public function loadPaymentNewWalletView($data, $orderRef)
    {
        $input1 = \Crypt::decrypt($data);
        $input1 = \App\Models\BillData::where('id', '=', $input1)->first();
        $input = $input1->data;
        $username = $input1->username;
        $input = json_decode($input, TRUE);
//dd($input);
        $token = $input1->token_data;
        /*$paymentItems = $input['paymentItem'];
        $itemAmounts = $input['amount'];
        $payerName = $input['payerName'];*/

        $totalAmount = $input['total_amount'];
        $orderId = $input['orderId'];
        $currency = $input['currency'];
        $key = PAYMENT_DETAILS_NEW_BEVURA;
        $input = $data;

	 $merchantId = isset($input['merchantId']) ? $input['merchantId'] : null;
	 $deviceCode = isset($input['deviceCode']) ? $input['deviceCode'] : null;
        return view('guests.payment.web.register_bevura_customer', compact('key', 'totalAmount', 'input', 'data', 'currency', 'token', 'orderId', 'username', 'merchantId', 'deviceCode'));
    }






    public function loadForgotPassword($data, $orderRef)
    {
        $input1 = \Crypt::decrypt($data);
        $input1 = \App\Models\BillData::where('id', '=', $input1)->first();
        $input = $input1->data;
        $username = $input1->username;
        $input = json_decode($input, TRUE);
        $token = $input1->token_data;
        $itemAmounts = $input['amount'];

        /*$paymentItems = $input['paymentItem'];

        $payerName = $input['payerName'];*/

        $totalAmount = $input['total_amount'];
        $orderId = $input['orderId'];
        $currency = $input['currency'];
        $key = PAYMENT_DETAILS_NEW_BEVURA;
        $input = $data;
        return view('guests.payment.web.forgot_password_ajax', compact('itemAmounts', 'key', 'totalAmount', 'input', 'data', 'currency', 'token', 'orderId', 'username'));
    }


    public function loadPaymentNewWalletStepTwoView($key, $data, $orderRef)
    {
        $input1 = \Crypt::decrypt($data);
        $input1 = \App\Models\BillData::where('id', '=', $input1)->first();
        $input = $input1->data;
        $username = $input1->username;
        $input = json_decode($input, TRUE);

	 $bioData = $input;
	 //dd($bioData);

	$data1['mobileNumber'] = \Auth::user()->username;
	$data1['meansOfIdentificationNumber'] = isset($bioData['meansOfIdentificationNumber']) ? $bioData['meansOfIdentificationNumber'] : null;
	$data1['token'] = \Auth::user()->token;
	$data1['deviceCode'] = $bioData['deviceCode'];
	$dataStr = "";
	foreach($data1 as $d => $v)
	{
		$dataStr = $dataStr."".$d."=".$v."&";
	}

	//dd($dataStr);
	$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/getCustomerDataByAccountNumberAndId';
	$result = sendPostRequest($url, $dataStr);
	
	$result = json_decode($result);
	//dd($result);

	if ($result!=null && isset($result->status) && $result->status == 100)
	{
		$respData = [];
							
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
		$customerNumber = isset($result->customerNumber) ? $result->customerNumber : NULL;
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
		$respData['customerNumber'] = $customerNumber;
		
		
							
		$ap = new \App\Models\AppError();
		$ap->error_trace = json_encode($respData);
		$ap->url = "";
		$ap->error_dump = json_encode($respData);
		$ap->user_username = "";
		$ap->save();
		$input1 = \Crypt::decrypt($data);
		$input1 = \App\Models\BillData::where('id', '=', $input1)->first();
			$input = $input1->data;
		$input = json_decode($input, TRUE);


		$orderRef = explode('-', $orderRef);
		$accountNumber = $accountNo;
		$key = '040';
		return view('guests.payment.web.register_bevura_customer_success_view', compact('key', 'input', 'accountNumber', 'customerNumber'));
		
	}


        $token = $input1->token_data;
        $amt = doubleVal($input['total_amount']);
        /*$paymentItems = $input['paymentItem'];
        $itemAmounts = $input['amount'];
        $payerName = $input['payerName'];*/


        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/pullPaymentDefaultData';

        $dataForServer = [];
        $dataForServer['merchantCode'] = $input['merchantId'];
        $dataForServer['hash'] = $input['hash'];
        $dataForServer['deviceCode'] = $input['deviceCode'];
        $dataForServer['serviceTypeId'] = $input['serviceTypeId'];
        $dataForServer['orderId'] = $input['orderId'];
        $dataForServer['amount'] = number_format($amt, 2, '.', '');
        $dataForServer['responseUrl'] = $input['responseurl'];
        $dataStr = "";
        foreach($dataForServer as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }
        $pullPaymentDefaultData = sendGetRequest($url, $dataStr);

        //dd($pullPaymentDefaultData);
        if($pullPaymentDefaultData==null)
        {
            $pullPaymentDefaultData = [];
        }
        else
        {
            $pullPaymentDefaultData = json_decode($pullPaymentDefaultData, TRUE);
        }

        $countries = $pullPaymentDefaultData['all_countries'];
        $districts = $pullPaymentDefaultData['all_districts'];


        $totalAmount = $input['total_amount'];
        $orderId = $input['orderId'];
        $currency = $input['currency'];
	 if($key!=WALLET_ACCESS && $key!=TOKENIZE)
	 {
        	$key = PAYMENT_DETAILS_NEW_BEVURA;
        }
	 $input = $data;
        return view('guests.payment.web.register_bevura_customer_step_two', compact('bioData', 'countries', 'districts', 'key', 'totalAmount', 'input', 'data', 'currency', 'token', 'orderId', 'username'));
    }




    public function loadPaymentTokenizeView($key, $data, $orderRef)
    {
        $input1 = \Crypt::decrypt($data);
        $input1 = \App\Models\BillData::where('id', '=', $input1)->first();
        $input = $input1->data;
        $username = $input1->username;
        $input = json_decode($input, TRUE);

	 $bioData = $input;
	 //dd($bioData);

	$data1['mobileNumber'] = \Auth::user()->username;
	$data1['customerVerificationNumber'] = \Auth::user()->customerVerificationNo;
	$data1['token'] = \Auth::user()->token;
	$dataStr = "";
	foreach($data1 as $d => $v)
	{
		$dataStr = $dataStr."".$d."=".$v."&";
	}

	//dd($dataStr);
	$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CustomerServicesV2/getCustomerDataByMobileNumberAndVerificationNumber';
	$result = sendPostRequest($url, $dataStr);
	
	$result = json_decode($result);
	//dd([$data1, $result]);

	if ($result!=null && isset($result->status) && $result->status == 100)
	{

		$cards = null;
		$accounts = null;
		$respData = [];
		$accountNumber = null;
		$customerNumber = $result->customerNumber;
		$customerName = $result->customerName;
		$currency = null;
							
		if(isset($result->accounts) && $result->accounts!=null)
		{
			$accounts = $result->accounts;
			$accountNumber = $accounts[0]->accountIdentifier;
			$currency = $accounts[0]->currencyCode;

			if(isset($result->ecards) && $result->ecards!=null)
			{
				$cards = $result->ecards;
			}
		}
		

		$orderRef = explode('-', $orderRef);
		$key = TOKENIZE;
		$input = $data;
		return view('guests.payment.web.tokenize_bevura_pay_option_view', compact('currency', 'customerName', 'accounts', 'cards', 'key', 'input', 'accountNumber', 'customerNumber'));
		
	}
	else if ($result!=null && isset($result->status) && $result->status == 7801)
	{
		return $this->loadPaymentNewWalletStepTwoView($key, $data, $orderRef);
		
	}
	else if ($result!=null && isset($result->status) && $result->status == -1)
	{
		//Token Expired
		u_logout();
		$input = $data;
            	$url = '/ajax-payment-wallet-login.html/050/'.$input;
            	return \Redirect::to($url)->with('warning', 'Your session has timed out. Log in to continue your payment');

	}

       
    }


    public function loadPaymentNewWalletSuccessView($key, $data, $orderRef)
    {
        
	 if($key!=WALLET_ACCESS)
	 {
	 	$input1 = \Crypt::decrypt($data);
       	$input1 = \App\Models\BillData::where('id', '=', $input1)->first();
        	$input = $input1->data;
        	$username = $input1->username;
        	$input = json_decode($input, TRUE);
        	$token = $input1->token_data;
        	/*$paymentItems = $input['paymentItem'];
        	$itemAmounts = $input['amount'];
        	$payerName = $input['payerName'];*/
        	$totalAmount = $input['total_amount'];
        	$orderRef = $input['orderId'];
        	$currency = $input['currency'];

		$key = PAYMENT_DETAILS_NEW_BEVURA;
		$input = $data;
        	return view('guests.payment.web.register_bevura_customer_success_view', compact('key', 'totalAmount', 'input', 'data', 'currency', 'token', 'orderRef', 'username'));
	 }
        else
	 {
	 	$input1 = \Crypt::decrypt($data);
       	$input1 = \App\Models\BillData::where('id', '=', $input1)->first();
        	$input = $input1->data;
		$input = json_decode($input, TRUE);


		$orderRef = explode('-', $orderRef);
		$accountNumber = $orderRef[0];
		$customerNumber = $orderRef[1];
        	return view('guests.payment.web.register_bevura_customer_success_view', compact('key', 'input', 'accountNumber', 'customerNumber'));
	 }
    }



    public function loadTokenizationSuccessView($key, $data, $orderRef)
    {
        
	 if($key!=WALLET_ACCESS)
	 {
	 	$input1 = \Crypt::decrypt($data);
       	$input1 = \App\Models\BillData::where('id', '=', $input1)->first();
        	$input = $input1->data;
        	$input = json_decode($input, TRUE);
        	$token = $input1->token_data;
        	/*$paymentItems = $input['paymentItem'];
        	$itemAmounts = $input['amount'];
        	$payerName = $input['payerName'];
        	$totalAmount = $input['total_amount'];
        	$orderRef = $input['orderId'];
        	$currency = $input['currency'];*/

		$key = PAYMENT_DETAILS_NEW_BEVURA;
		$input = $data;
        	return view('guests.payment.web.tokenization_success_view', compact('key', 'input', 'data', 'token'));
	 }
        else
	 {
	 	$input1 = \Crypt::decrypt($data);
       	$input1 = \App\Models\BillData::where('id', '=', $input1)->first();
        	$input = $input1->data;
		$input = json_decode($input, TRUE);


		$orderRef = explode('-', $orderRef);
		$accountNumber = $orderRef[0];
		$customerNumber = $orderRef[1];
        	return view('guests.payment.web.register_bevura_customer_success_view', compact('key', 'input', 'accountNumber', 'customerNumber'));
	 }
    }




    public function loadPaymentNewWalletOtpView($data, $orderRef)
    {
        $input1 = \Crypt::decrypt($data);
        $input1 = \App\Models\BillData::where('id', '=', $input1)->first();
        $input = $input1->data;
        $username = $input1->username;
        $input = json_decode($input, TRUE);
        $token = $input1->token_data;
        /*$paymentItems = $input['paymentItem'];
        $itemAmounts = $input['amount'];
        $payerName = $input['payerName'];*/
        $totalAmount = $input['total_amount'];
        $orderId = $input['orderId'];
        $currency = $input['currency'];
        $key = PAYMENT_DETAILS_NEW_BEVURA;
        $input = $data;
        return view('guests.payment.web.register_bevura_customer_step_two', compact('key', 'totalAmount', 'input', 'data', 'currency', 'token', 'orderId', 'username'));
    }


    public function getLogoutPay()
    {
        u_logout();
        return \Redirect::to('/');
    }
	
	
	
	
    public function getLogoutFrontViewPay(Request $request)
    {
        u_logout();
		$redirect = $request->get('redirect');
        return response()->json(['status'=>1, 'redirectTo'=>$redirect]);
    }


	public function getOTPLoginView($token)
	{

		return view('core.guest.login_otp', compact('token'));
	}



	public function postLoginOTP(Request $request)
	{

		$otp = \Crypt::encrypt($request->get('otp1')."".$request->get('otp2')."".$request->get('otp3')."".$request->get('otp4'));
		//$token = \Crypt::decrypt($request->get('token'));
		$token = ($request->get('token'));


        try {
			/*
			SoapWrapper::add(function ($service) {
				$service
						->name('authenticateUserVerifyOTP')
						->wsdl('http://'.getServiceBaseURL().'/ProbasePayEngine/services/AuthenticationServices?wsdl')
						->trace(true);
			});





			$authReturn = null;
			SoapWrapper::service('authenticateUserVerifyOTP', function ($service) use ($data, &$authReturn) {
			    //dd(2);
				$authReturn = ($service->call('authenticateUserVerifyOTP', [$data]));
				//dd($authReturn);
			});
			*/

			//$authData = json_decode($authReturn->return);
			//$authData = json_decode($authReturn->return);

			$data = 'otp='.$otp.'&token='.$token.'&merchantId='.PROBASEWALLET_MERCHANT_CODE.'&deviceCode='.PROBASEWALLET_DEVICE_CODE;
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/authenticateUserVerifyOTP';
			$authDataStr = sendPostRequest($url, $data);
			$authData = json_decode($authDataStr);

            //dd($authData);

            if(isset($authData->status) && $authData->status!=null && $authData->status == 3100) {
                u_logout();
                return redirect('/auth/login');
            }
            else if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {
				$user = new User();
				//$user->id = \Crypt::encrypt($authData);
				//$user->id =json_encode($authData);
				$user->id =($authData->id);
				$user->username = $authData->username;
				$user->token = $authData->token;
				$user->role_code = $authData->role_code;
				//$user->all_banks = $authData->all_banks;
				//$user->all_merchant_schemes = $authData->all_merchant_schemes;
				//$user->all_device_types = $authData->all_device_types;
				//$user->all_card_schemes = $authData->all_card_schemes;
				//$user->all_provinces = $authData->all_provinces;
				//$user->all_countries = $authData->all_countries;
				$user->profile_pix = (isset($authData->profile_pix) && $authData->profile_pix!=null) ? $authData->profile_pix : null;
				$user->staff_bank_code = isset($authData->staff_bank_code) ? $authData->staff_bank_code : null;
				$user->mobileno = $authData->mobileno;
				$user->merchant_dec_key = (isset($authData->merchant_key) && $authData->merchant_key!=null) ? $authData->merchant_key : null;
				$user->merchant_id = (isset($authData->merchant_id) && $authData->merchant_id!=null) ? $authData->merchant_id : null;
                $user->customerVerificationNo = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
				//$user->dashboardStatistics = (isset($authData->dashboardStatistics) && $authData->dashboardStatistics!=null) ? $authData->dashboardStatistics : null;
				$this->auth->login($user, $authDataStr);

				$token = JWTAuth::fromUser($user);
				//dd($token);

				$loginKey = 'login_'.$authData->id;
				$jwtKey = 'jwt_token';
                \Session::put('auth_id', $authData->id);
				\Session::put($loginKey, $authDataStr);
				\Session::put($jwtKey, $token);
                \Session::put('accounts', isset($authData->accounts) ? json_encode($authData->accounts) : json_encode([]));
                \Session::put('cards', isset($authData->ecards) ? json_encode($authData->ecards) : json_encode([]));

				//dd(\Session::all());

				if($user->role_code=='CUSTOMER')
					return redirect('/dashboard');
				else if($user->role_code=='MERCHANT')
					return redirect('/merchant/transactions/all-device/'.\Crypt::encryptPseudo(intval($authData->merchant_id), $authData->merchant_key));
				else if($user->role_code=='ACCOUNTANT')
					return redirect('/accountant/dashboard');
				else
					return redirect('/'.getRoleInterpretRoute($user->role_code).'/dashboard');





			}else
			{
				return back()->with('error', 'Error logging in. Please try again later');
			}
		}catch(\Exception $e)
		{
			dd($e);
			return back()->with('error', 'Experiencing issues logging in. Try again later');
		}
	}








	public function postLoginAppOTP(Request $request)
	{

		$otp = \Crypt::encrypt($request->get('otp1')."".$request->get('otp2')."".$request->get('otp3')."".$request->get('otp4'));
		//$token = \Crypt::decrypt($request->get('token'));
		$username= ($request->get('username'));
		$password= ($request->get('password'));
		$deviceVersion= ($request->get('deviceVersion'));
		$deviceName= ($request->get('deviceName'));
		$deviceKey= ($request->get('deviceKey'));
		$deviceAppId= ($request->get('deviceAppId'));
		$deviceId= ($request->get('deviceId'));
		$acquirerCode= ($request->get('acquirerCode'));
		$isMobile= ($request->get('isMobile'));
		$autoAuthenticate= ($request->get('autoAuthenticate'));


        try {
			
			//$authData = json_decode($authReturn->return);
			//$authData = json_decode($authReturn->return);



			$data = 'otp='.$otp.'&merchantId='.PROBASEWALLET_MERCHANT_CODE.'&deviceCode='.PROBASEWALLET_DEVICE_CODE;


			if($deviceId!=null)
			{
				$data = $data."&deviceId=".$deviceId;
			}
			if($deviceKey!=null)
			{
				$data = $data."&deviceKey=".$deviceKey;
			}
			if($deviceAppId!=null)
			{
				$data = $data."&deviceAppId=".$deviceAppId;
			}

			if($acquirerCode!=null)
			{
				$data = $data."&acquirerCode=".$acquirerCode;
			}
			if($isMobile!=null)
			{
				$data = $data."&isMobile=".$isMobile;
			}
			if($autoAuthenticate!=null)
			{
				$data = $data."&autoAuthenticate=".$autoAuthenticate;
			}

			if($username!=null)
			{
				$data = $data."&username=".$username;
			}
			if($password!=null)
			{
				$data = $data."&encPassword=".($password);
			}

			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/authenticateUserVerifyDeviceAppOTP';
			$authDataStr = sendPostRequest($url, $data);
			$authData = json_decode($authDataStr);

            //dd($authData);

            if(isset($authData->status) && $authData->status!=null && $authData->status == 3100) {
                u_logout();
                return redirect('/auth/login');
            }
            else if(isset($authData->status) && $authData->status!=null && $authData->status == 600) {
				$user = new User();
				//$user->id = \Crypt::encrypt($authData);
				//$user->id =json_encode($authData);
				$user->id =($authData->id);
				$user->username = $authData->username;
				$user->token = $authData->token;
				$user->role_code = $authData->role_code;
				//$user->all_banks = $authData->all_banks;
				//$user->all_merchant_schemes = $authData->all_merchant_schemes;
				//$user->all_device_types = $authData->all_device_types;
				//$user->all_card_schemes = $authData->all_card_schemes;
				//$user->all_provinces = $authData->all_provinces;
				//$user->all_countries = $authData->all_countries;
				$user->profile_pix = (isset($authData->profile_pix) && $authData->profile_pix!=null) ? $authData->profile_pix : null;
				$user->staff_bank_code = isset($authData->staff_bank_code) ? $authData->staff_bank_code : null;
				$user->mobileno = $authData->mobileno;
				$user->merchant_dec_key = (isset($authData->merchant_key) && $authData->merchant_key!=null) ? $authData->merchant_key : null;
				$user->merchant_id = (isset($authData->merchant_id) && $authData->merchant_id!=null) ? $authData->merchant_id : null;
                $user->customerVerificationNo = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
				//$user->dashboardStatistics = (isset($authData->dashboardStatistics) && $authData->dashboardStatistics!=null) ? $authData->dashboardStatistics : null;
				$this->auth->login($user, $authDataStr);

				$token = JWTAuth::fromUser($user);
				//dd($token);

				$loginKey = 'login_'.$authData->id;
				$jwtKey = 'jwt_token';
                \Session::put('auth_id', $authData->id);
				\Session::put($loginKey, $authDataStr);
				\Session::put($jwtKey, $token);
                \Session::put('accounts', isset($authData->accounts) ? json_encode($authData->accounts) : json_encode([]));
                \Session::put('cards', isset($authData->ecards) ? json_encode($authData->ecards) : json_encode([]));

				//dd(\Session::all());

				if($user->role_code=='CUSTOMER')
					return redirect('/dashboard');
				else if($user->role_code=='MERCHANT')
					return redirect('/merchant/transactions/all-device/'.\Crypt::encryptPseudo(intval($authData->merchant_id), $authData->merchant_key));
				else if($user->role_code=='ACCOUNTANT')
					return redirect('/accountant/dashboard');
				else if($user->role_code=='AGENT')
					return redirect('/agent/dashboard');
				else
					return redirect('/'.getRoleInterpretRoute($user->role_code).'/dashboard');





			}else
			{
				return back()->with('error', 'Error logging in. Please try again later');
			}
		}catch(\Exception $e)
		{
			dd($e);
			return back()->with('error', 'Experiencing issues logging in. Try again later');
		}
	}





	public function postLoginPin(Request $request)
	{

		$otp = \Crypt::encrypt($request->get('otp1')."".$request->get('otp2')."".$request->get('otp3')."".$request->get('otp4'));
		//$token = \Crypt::decrypt($request->get('token'));
		$token = ($request->get('token'));


        	try {
			/*
			SoapWrapper::add(function ($service) {
				$service
						->name('authenticateUserVerifyOTP')
						->wsdl('http://'.getServiceBaseURL().'/ProbasePayEngine/services/AuthenticationServices?wsdl')
						->trace(true);
			});





			$authReturn = null;
			SoapWrapper::service('authenticateUserVerifyOTP', function ($service) use ($data, &$authReturn) {
			    //dd(2);
				$authReturn = ($service->call('authenticateUserVerifyOTP', [$data]));
				//dd($authReturn);
			});
			*/

			//$authData = json_decode($authReturn->return);
			//$authData = json_decode($authReturn->return);

			$data = 'otp='.$otp.'&token='.$token.'&merchantId='.PROBASEWALLET_MERCHANT_CODE.'&deviceCode='.PROBASEWALLET_DEVICE_CODE;
			$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/authenticateUserVerifyPin';
			$authDataStr = sendPostRequest($url, $data);
			$authData = json_decode($authDataStr);

            		

            		if(isset($authData->status) && $authData->status!=null && $authData->status == 3100)
			{
                		u_logout();
                		return redirect('/auth/login');
            		}
            		else if(isset($authData->status) && $authData->status!=null && $authData->status == 600) 
			{
				$user = new User();
				//$user->id = \Crypt::encrypt($authData);
				//$user->id =json_encode($authData);

				$user->id =($authData->id);
				$user->username = $authData->username;
				$user->token = $authData->token;
				$user->role_code = $authData->role_code;
				//$user->all_banks = $authData->all_banks;
				//$user->all_merchant_schemes = $authData->all_merchant_schemes;
				//$user->all_device_types = $authData->all_device_types;
				//$user->all_card_schemes = $authData->all_card_schemes;
				//$user->all_provinces = $authData->all_provinces;
				//$user->all_countries = $authData->all_countries;
				$user->profile_pix = (isset($authData->profile_pix) && $authData->profile_pix!=null) ? $authData->profile_pix : null;
				$user->staff_bank_code = isset($authData->staff_bank_code) ? $authData->staff_bank_code : null;
				$user->mobileno = $authData->mobileno;
				$user->merchant_dec_key = (isset($authData->merchant_key) && $authData->merchant_key!=null) ? $authData->merchant_key : null;
				$user->merchant_id = (isset($authData->merchant_id) && $authData->merchant_id!=null) ? $authData->merchant_id : null;
                		$user->customerVerificationNo = isset($authData->customerVerificationNo) ? $authData->customerVerificationNo : null;
				//$user->dashboardStatistics = (isset($authData->dashboardStatistics) && $authData->dashboardStatistics!=null) ? $authData->dashboardStatistics : null;

				$user->name = $authData->username;

				$this->auth->login($user, $authDataStr);

				$token = JWTAuth::fromUser($user);
				//dd($token);

				$loginKey = 'login_'.$authData->id;
				$jwtKey = 'jwt_token';
                		\Session::put('auth_id', $authData->id);
				\Session::put($loginKey, $authDataStr);
				\Session::put($jwtKey, $token);
                		\Session::put('accounts', isset($authData->accounts) ? json_encode($authData->accounts) : json_encode([]));
                		\Session::put('cards', isset($authData->ecards) ? json_encode($authData->ecards) : json_encode([]));

				//dd(\Session::all());
				//dd($user);

				if($user->role_code=='CUSTOMER')
					return redirect('/dashboard');
				else if($user->role_code=='MERCHANT')
					return redirect('/merchant/transactions/all-device/'.\Crypt::encryptPseudo(intval($authData->merchant_id), $authData->merchant_key));
				else if($user->role_code=='ACCOUNTANT')
					return redirect('/accountant/dashboard');
				else if($user->role_code=='AGENT')
					return redirect('/agent/dashboard');
				else
				{
					return redirect('/'.getRoleInterpretRoute($user->role_code).'/dashboard');
				}





			}else
			{
				return back()->with('error', 'Error logging in. Please try again later');
			}
		}catch(\Exception $e)
		{
			dd($e);
			return back()->with('error', 'Experiencing issues logging in. Try again later');
		}
	}



    public function loadPaymentWalletLoggedInView($input, $transactionRef)
    {

        //dd(\Session::all());
        $sessionContainer = [];
        if(\Session::has('error') || \Session::has('message'))
        {
            $sessionError = \Session::get('error');
            $sessionMessage = \Session::get('message');
            $sessionContainer['error'] = $sessionError;
            $sessionContainer['message'] = $sessionMessage;
        }

        $billDataId = \Crypt::decrypt($input);
        $billData = \App\Models\BillData::where('id', '=', $billDataId)->first();
        $username = $billData->username;
        $billData = $billData->data;
        $billData = json_decode($billData, TRUE);
        $totalAmount = doubleVal($billData['total_amount']);
        $orderId = $billData['orderId'];
        $currency = $billData['currency'];
        $countryCode = $billData['country_code'];
        $merchantId = $billData['merchantId'];
        $deviceCode = $billData['deviceCode'];
        //dd([$totalAmount, $billData]);
        $key = PAY_FROM_LOGGED_IN_WALLET;

        $data = [];
        $data['token'] = \Auth::user()->token;
        $data['merchantId'] = $merchantId;
        $data['deviceCode'] = $deviceCode;
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
        }
        else if($authData->status==-1) {
            u_logout();
            $url = '/ajax-payment-details.html/0001/'.$input;
            return \Redirect::to($url)->with('warning', 'Your session has timed out. Log in to continue your payment');
        }
	 else
	 {
		$accounts = [];
            $cards = [];
	}

		//dd($authData);
        $defaultAccount = null;
        $accountBalance = null;
        if(sizeof($accounts)>0)
        {
            $defaultAccount = $accounts[0];
            $accountIdentifier = $defaultAccount->accountIdentifier;
            //$merchantCode = PROBASEWALLET_MERCHANT_CODE;
            //$deviceCode = PROBASEWALLET_DEVICE_CODE;

            $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AccountServicesV2/getAccountBalance';
            $data = 'accountIdentifier='.urlencode($accountIdentifier).'&token='.\Auth::user()->token;
            //$data = $data."&merchantCode=".PROBASEWALLET_MERCHANT_CODE;
            //$data = $data."&deviceCode=".PROBASEWALLET_DEVICE_CODE;
	     $data = $data."&merchantCode=".$merchantId;
            $data = $data."&deviceCode=".$deviceCode;
            //dd($data );
			
            $accountBalance = sendPostRequest($url, $data);
			//sendGetRequest($url, $data);

            //dd($accountBalance);
            if($accountBalance==null)
            {
                $accountBalance = [];
            }
            else
            {
                $accountBalance = json_decode($accountBalance);
            }
        }
        //dd($accountBalance);
        //dd($cards);
        $all_card_schemes = $this->all_card_schemes;

        $session = (\Session::all());
        $userId = (\Auth::user()->id);
        $loginData = \Session::get('login_'.$userId);
        $loginData = json_decode($loginData, TRUE);
        //dd($accountBalance);
        return view('guests.payment.web.logged_in_wallet_view', compact('accountBalance', 'defaultAccount', 'loginData', 'username', 'totalAmount', 'key', 'input', 'cards', 'all_card_schemes', 'orderId', 'currency', 'countryCode', ));
    }

	public function getRegister()
    {
		$role = new \App\Models\Roles();
		$rolesList = $role->getRolesList();
		$user = \Auth::user();
		$all_banks = json_decode($user->all_banks);
		$all_provinces_ = json_decode($user->all_provinces);
		$all_provinces = array();
		$all_countries = json_decode($user->all_countries);

		foreach($all_provinces_ as $province)
			$all_provinces[$province->id] = $province->provinceName;

		return view('core.authenticated.admin_user.new_admin_staff', compact('all_countries', 'rolesList', 'all_provinces', 'all_banks'));
    }



    public function getRegisterCustomer()
    {
        return view('core.guest.register', compact('this'));
    }


	public function postRegister(Request $request)
	{

		$data = $request->all();
		$data['encPassword'] = encrypt('password');
		$data['bankId'] = intval($data['bankId']);
		$data['locationDistrict_id'] = intval($data['locationDistrict_id']);
		$data['token'] = \Auth::user()->token;

		$result = null;
		if($data['role_type']=='BANK_STAFF')
		{
			$result = handleSOAPCalls('createBankStaff', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/UserServices?wsdl', $data);
		}
		else {
			$result = handleSOAPCalls('createNewAdminUser', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/UserServices?wsdl', $data);
		}

		if(handleTokenUpdate($result)==false)
		{
			return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
		}

		if($result->status == 100 || $result->status == 800)
		{
			return redirect('/register')->with('message', 'New Admin Account Successfully created');
		}
		return \Redirect::back()->with('error', 'New Bank Staff Account creation failed');
	}

    public function postRegisterOld(SignUpRequest $request)
    {
        $packageId = decrypt($request->get('packageId'));
        $username = $request->get('username');
        $password = Hash::make($request->get('password'));
        $status = 'Inactive';
        $role_code = Roles::$ROLE_SCHOOL_ADMIN;
        $pk = primary_key();
        $verifyCode = str_random(30);
        $data = [
            'id' => $pk,
            'username' => $username,
            'password' => $password,
            'http_user_agent' => user_agent(),
            'ip_address' => ip_address(),
            'role_code' => $role_code,
            'package_id' => $packageId,
            'activation_token' => $verifyCode,
            'status' => $status,
            'first_time_login'  => 'NO'
        ];

		//send_mail('email.test', $username, $username, 'Account Activation', ['activationLink' => 'Activation Link is here']);

        $account = User::create($data);
        if ($account) {
            $activationLink = "http://" . env('DOMAIN_NAME') . "/auth/verify/?sub_id=" . encrypt($packageId) . "&verify_code=" . $verifyCode;
			try{
	            send_mail('email.signup', $username, $username, 'Account Activation', ['activationLink' => $activationLink]);
			}catch(\Exception $e)
			{
				//dd($e);

			}
			// You can also click on the link - .$activationLink
            return redirect('auth/login?redirect=register-complete/' . $verifyCode)->with('message', 'Your account has been successfully created. Please proceed to activate your account by clicking on the link in your email.');
        } else {
            return back()->with('error', 'Your account could not be created. Please try again later');
        }
    }

    public function getVerify(Request $request)
    {

        $sub_id = decrypt($request->get('sub_id'));
        $verify_code = $request->get('verify_code');
        $user_account = User::where('activation_token', $verify_code)->first();
        if ($user_account == null) {
            return view('errors.500');
        } else {
            $user_account->status = 'Active';
            $user_account->activation_token = null;
            $user_account->save();
			//dd('auth/login?sub_id='.$request->get('sub_id').'&verify_code='.$request->get('verify_code'));
            return redirect('auth/login?sub_id='.$request->get('sub_id').'&verify_code='.$request->get('verify_code'))->with('message', 'Account activated successfully. Please login to continue.');
        }
    }

    public function getLogout()
    {
        u_logout();
        return redirect('/');
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getCompleteRegistration(Request $request, $activationToken = null)
    {
        $resendMail = $request->get('resend', null);


        if ($activationToken != null) {
            //resend activation email	($resendMail != false && $resendMail == "true") &&
            $account = \App\Models\User::where('activation_token', $activationToken)->first();
            if ($account != null) {
                $activationLink = "http://" . env('DOMAIN_NAME') . "/auth/verify/?sub_id=" . encrypt($account->package_id) . "&verify_code=" . $activationToken;
				try{
                //send_mail('email.signup', $account->username, $account->username, 'Account Activation', compact('activationLink'));
				}catch(\Exception $e){}
                return redirect('auth/login')->with('message', "Activation email has been resent to ".$account->username.". Please check your email to activate your account or copy the link and paste in your url - ".$activationLink);
            }
        }
        return view('guests.complete_registration');
    }


	public function getForgotPassword(){
		return view('core.guest.forgot_password');
	}

	public function postForgotPassword(Request $request){
		$data = $request->all();
		$data['username'] = ($data['username']);

		$result = null;

		$result = handleSOAPCalls('forgotPassword', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/AuthenticationServices?wsdl', $data);



		if($result->status == 602)
		{
			$mobile = $result->recmobile;
			$ps = $result->ps;

			$msg = "Your new Password is ".$ps."\n\nThank You.";
			send_sms($mobile, $msg);
			return redirect('/auth/login')->with('message', isset($result->message) ? $result->message : "Password Reset Failed");
		}
		return \Redirect::back()->with('error', isset($result->message) ? $result->message : "Password Reset Failed");
	}



	public function apiPostForgotPasswordJSONResponse(Request $request){
		$data = $request->all();
		$data['username'] = ($data['countrycode']."".$data['loginToPayForgotPasswordMobileNoField']);
		

		$result = null;

		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/AuthenticationServicesV2/forgotPassword';
		//$result = handleSOAPCalls('forgotPassword', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/AuthenticationServices?wsdl', $data);
		$data = 'username='.$data['username'];

            	$server_output = sendGetRequest($url, $data);
		$result= json_decode($server_output);
		if($result->status == 602)
		{
			$mobile = $result->recmobile;
			//$ps = $result->ps;

			//$msg = "Your new Password is ".$ps."\n\nThank You.";
			//send_sms($mobile, $msg);
			$resp = [];
			$resp['status'] = 100;
			$resp['success'] = true;
			return \Response::json($resp);

		}
		$resp = [];
		$resp['status'] = 101;
		$resp['success'] = true;
		$resp['message']= isset($result->message) ? $result->message : "Password Reset Failed";
		return \Response::json($resp);
		
	}

	public function getPasswordChange($domain=NULL){

		if($domain=="wallet")
			return view('probasewallet.authenticated.changepassword');
		else if($domain=="www")
			return view('core.authenticated.admin_user.change_password');
		else
			return view('core.authenticated.admin_user.change_password');
	}

	public function postPasswordChange(Request $request){
		$input = $request->all();
		$data['currentpassword'] = \Crypt::encrypt($input['password']);
		$data['encPassword'] = \Crypt::encrypt($input['newpassword']);
		$data['token'] = \Auth::user()->token;


		if($input['newpassword']==$input['confirmnewpassword'] && strlen($input['confirmnewpassword'])>6) {


			$result = null;
			$result = handleSOAPCalls('changePassword', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/AuthenticationServices?wsdl', $data);


			if ($result->status == 602) {
				$mobile = $result->recmobile;

				$msg = "Password change was successful\n\nThank You.";
				send_sms($mobile, $msg);
				u_logout();
				return redirect('/auth/login')->with('message', isset($result->message) ? $result->message : "Password Reset Failed");
			}
		}else
		{
			return \Redirect::back()->with('error', "New and Confirm Passwords do not match. Passwords must also exceed 6 characters");
			//passwords dont match
		}
		return \Redirect::back()->with('error', isset($result->message) ? $result->message : "Password Reset Failed");
	}


	protected function createNewUser(NewUserRequest $data)
    {
		//dd($data['username']);
		$user = new \App\Models\FestUser();
		$user->name = $data['name'];
        $user->username = $data['username'];
        $user->password = ($data['password']);
        $user->roleCode = ($data['roleCode']);
        $user->save();
		//dd($userData);
        return $user;
    }


    public function postLoginFestivalUser(Request $request)
	{

        $token = null;
        $rules = ['username' => 'required|numeric',
		'password' => 'required'];

        $messages = [
                'username.required' => 'Your mobile number is required to login',
				'username.numeric' => 'Your mobile number must consist of numbers',
				'password.required' => 'Your Password is required to login'
            ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            $errMsg = json_decode($validator->messages(), true);
            $str_error = "";
            $i = 1;
            foreach($errMsg as $key => $value)
            {
                foreach($value as $val) {
                    $str_error = ($val);
                }
            }
            return response()->json(($str_error), 500);
        }


        $user = \App\Models\FestUser::where('username', '=', $request->get('username'))->where('password', '=', $request->get('password'))->first();
        if($user!=null)
        {
            return response()->json(['status'=>1, 'message'=>'Login Successful', 'id'=>$user->id, 'name'=>$user->name, 'mobile'=>$user->username, 'role_code'=>$user->role_code]);
        }
        else
        {

            return response()->json(['status'=>0, 'message'=>'Login Was Not Successful']);
        }

	}


	public function postLoginStanbicPromoSwiper(Request $request)
	{

        $token = null;
        $rules = ['username' => 'required|numeric',
		'password' => 'required'];

        $messages = [
                'username.required' => 'Your mobile number is required to login',
				'username.numeric' => 'Your mobile number must consist of numbers',
				'password.required' => 'Your Password is required to login'
            ];
        $validator = \Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            $errMsg = json_decode($validator->messages(), true);
            $str_error = "";
            $i = 1;
            foreach($errMsg as $key => $value)
            {
                foreach($value as $val) {
                    $str_error = ($val);
                }
            }
            return response()->json(($str_error), 500);
        }


        $user = \App\Models\FestUser::where('username', '=', $request->get('username'))->where('password', '=', $request->get('password'))->first();
        if($user!=null)
        {
            return response()->json(['status'=>1, 'message'=>'Login Successful', 'id'=>$user->id, 'name'=>$user->name, 'mobile'=>$user->username, 'role_code'=>$user->role_code]);
        }
        else
        {

            return response()->json(['status'=>0, 'message'=>'Login Was Not Successful']);
        }

	}


	public function postLoginStanbicPromoSwiper2(Request $request)
	{

        $input = $request->all();

		return redirect('/view-stanbic-promo-receipts');

	}



	public function getStanicPromoLogin()
    {

		return view('core.guest.login_stanbic');
    }



}
