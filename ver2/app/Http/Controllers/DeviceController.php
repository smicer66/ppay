<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;

class DeviceController extends Controller
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


    public function postAddNewDevice()
    {
        $dataForm = \Input::all();
        $user = \Auth::user();
        $all_banks = json_decode($user->all_banks);
        $all_merchant_schemes = json_decode($user->all_merchant_schemes);
        $all_device_types = json_decode($user->all_device_types);
        $all_card_schemes = json_decode($user->all_card_schemes);
        $all_provinces = json_decode($user->all_provinces);

        $data = array();
        $merchantId = \Crypt::encrypt(intval($dataForm['merchant']));
        $data['merchantId'] = $merchantId;
        $data['deviceType'] = $dataForm['deviceType'];
        $data['notifyEmail'] = $dataForm['emailNotify'];
        $data['notifyMobile'] = $dataForm['mobileNotify'];
        if(in_array('deviceId', array_keys($dataForm))) {
            $data['deviceId'] = $dataForm['deviceId'];
        }

        if($dataForm['deviceType']=="WEB") {
            $data['domainUrl'] = $dataForm['domainURL'];
            $data['forwardSuccessUrl'] = $dataForm['forwardSuccess'];
            $data['forwardFailureUrl'] = $dataForm['forwardFail'];
        }
        else if($dataForm['deviceType']=="POS") {
            $data['deviceCode'] = $dataForm['posDeviceCode'];
            $data['deviceSerialNo'] = $dataForm['posDeviceSerialNo'];
            $data['forwardSuccessUrl'] = $dataForm['posForwardSuccess'];
        }
        else if($dataForm['deviceType']=="ATM") {
            $data['deviceCode'] = $dataForm['atmDeviceCode'];
            $data['deviceSerialNo'] = $dataForm['atmDeviceSerial'];
            $data['forwardSuccessUrl'] = $dataForm['atmForwardSuccess'];
        }

        $data['token'] = \Auth::user()->token;

        //dd($data);

        $result = handleSOAPCalls('createNewMerchantDevice', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/DeviceServices?wsdl', $data);

        //dd($result);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 700)
        {
            $notifyMerchantMobile = $result->notifyMerchantMobile;
            $deviceCode = $result->deviceCode;
            $merchantCode = $result->merchantCode;
            $msg = "New Merchant Device \nMerchant Code: ".$merchantCode."\nDevice Code: ".$deviceCode."\nThank You.";
            send_sms($notifyMerchantMobile, $msg);

            \Session::forget('data');
            return redirect('/potzr-staff/merchants/view-merchant-devices/'.$dataForm['merchant'])
                ->with('message', 'Merchant Device '.(in_array('deviceId', array_keys($dataForm)) ? "Updated" : "Added").' Successfully');
        }else
        {
            return \Redirect::back()->with('error', 'Merchant Device '.(in_array('deviceId', array_keys($dataForm)) ? "Updated" : "Added").' Failed');
        }
    }



    public function updateDeviceStatus($status, $deviceId)
    {
        $data = array();
        $data['deviceId'] = $deviceId;
        $data['newStatus'] = $status=='enable' ? 'ACTIVE' : ($status=='disable' ? 'DISABLED' : '');
        $data['token'] = \Auth::user()->token;

        //dd($data);

        /*$result = handleSOAPCalls('updateDeviceStatus', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/DeviceServices?wsdl', $data);

        //dd($result);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }*/

	 $dataForServer = "";
	 foreach($data as $d => $k)
	 {
		$dataForServer = "&".$d."=".$k."".$dataForServer;
	 }

	 //dd($dataForServer);
	 $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/DeviceServicesV2/updateDeviceStatus';
        $server_output = sendPostRequest($url, $dataForServer);
        //dd($server_output);
        $result = json_decode($server_output);


        if($result->status == 710)
        {
            return \Redirect::back()
                ->with('message', 'Merchant Device Status Updated Successfully');
        }else
        {
            return \Redirect::back()->with('error', 'Merchant Device Status Update Failed');
        }
    }




    public function updateDeviceMode($newMode, $deviceId)
    {
        $data = array();
        $data['deviceId'] = $deviceId;
        $data['newMode'] = $newMode==1 ? 1 : 0;
        $data['token'] = \Auth::user()->token;


	 $dataForServer = "";
	 foreach($data as $d => $k)
	 {
		$dataForServer = "&".$d."=".$k."".$dataForServer;
	 }

	 //dd($dataForServer);
	 $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/DeviceServicesV2/updateDeviceMode';
        $server_output = sendPostRequest($url, $dataForServer);
        //dd($server_output);
        $result = json_decode($server_output);


        if($result->status == 710)
        {
            return \Redirect::back()
                ->with('message', 'Merchant Device Status Updated Successfully');
        }else
        {
            return \Redirect::back()->with('error', 'Merchant Device Status Update Failed');
        }
    }



    public function getViewDeviceTransactions($deviceIdS=NULL)
    {
        $data = array();
        $data['token'] = \Auth::user()->token;
        /*if($deviceIdS!=NULL)
        {
            $data['deviceIdS'] = $deviceIdS;
        }
        //$result = handleSOAPCalls('listDeviceTransactions', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/DeviceServices?wsdl', $data);
	//dd($result);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 710)
        {
            $transactionList = json_decode($result->transactionList);

            $merchant = json_decode($result->device)->merchant;
            $device = json_decode($result->device);

            
        }else
        {
            return \Redirect::back()->with('error', 'Device transactions fetch failed');
        }*/
	 $filter = 'device';
	 $data['deviceId'] = $deviceIdS;
	 return view('core.authenticated.transactions.transaction_listing', compact('filter', 'data'));
    }




    public function getMPQRListing()
    {

        return view('core.authenticated.mpqr.mpqr_listing');
    }




    public function getProbaseQRListing()
    {

        return view('core.authenticated.probaseqr.probaseqr_listing');
    }

}
