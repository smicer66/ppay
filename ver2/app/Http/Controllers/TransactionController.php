<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;

class TransactionController extends Controller
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

    public function getTransactions(Request $request, $filter=NULL)
    {
	//dd($request->all());
	 $data = $request->all();
        if(\Auth::user()->role_code==\App\Models\Roles::$CUSTOMER) {
            return view('core.authenticated.transactions.customer_transaction_list');
        }
        else if(\Auth::user()->role_code==\App\Models\Roles::$AGENT){
            return view('core.authenticated.transactions.transaction_listing_agent', compact('filter', 'data'));
        }
        else {
            return view('core.authenticated.transactions.transaction_listing', compact('filter', 'data'));
        }
    }

    public function getUtilitiesPaid()
    {
        if(\Auth::user()->role_code==\App\Models\Roles::$CUSTOMER) {
            return view('core.authenticated.transactions.customer_utilities_paid_list');
        }
        else {
            return view('core.authenticated.transactions.utilities_paid_listing');
        }
    }


    public function getViewPaymentsReceived()
    {
        return view('core.authenticated.transactions.payments_received_listing');
    }


    public function getReverseTransaction($device_trans_id)
    {
        $data = array();
        $data['trans_device_idS'] = $device_trans_id;
        $data['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('reverseTransaction', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/TransactionServices?wsdl', $data);



        if(handleTokenUpdate($result)==false)
        {
            return response()->json(['status' => -1, 'msg'=>'Login session expired. Please relogin again']);
        }


        if($result->status == 914)
        {
            $device_trans_id = \Crypt::decrypt($device_trans_id);
            $device_trans_id = explode('-', $device_trans_id);
            return \Redirect::to('/potzr-staff/devices/view-device-transactions/'.\Crypt::encrypt(intval($device_trans_id[0])))->with('message', 'Transactions have been updated successfully.');
        }else
        {
            return \Redirect::back()->with('error', 'Transaction Listing failed.');
        }
    }


    public function checkTransactionByTransactionRef($merchantCode, $deviceCode, $transactionRef, $hash)
    {
        $data = array();
        $data['merchantCode'] = $merchantCode;
        $data['deviceCode'] = $deviceCode;
        $data['transactionRef'] = $transactionRef;
        $data['hash'] = $hash;

        //dd(hash('sha512', $transactionRef."D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8B59E897FA930DA44F9230910DAC9E20641823799A107A02068F7BC0F4CC41D2952E249552255710F".$merchantCode));

        $result = handleSOAPCalls('getTransactionStatus', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/TransactionServices?wsdl', $data);
        //dd($result);

        return response()->json($result);
    }


	public function confirmTransactionByTransactionRef($carrier, $mobilePaymentRefCode, $transactionRef)
    {
		//$hash = hash('sha512', $transactionRef."D3D1D05AFE42AD50818167EAC73C109168A0F108F32645C8B59E897FA930DA44F9230910DAC9E20641823799A107A02068F7BC0F4CC41D2952E249552255710F".$merchantCode);
		//$hash = hash('sha512', $transactionRef."".$deviceCode."".$merchantCode);
        $data = array();
        /* $data['merchantCode'] = $merchantCode;
        $data['deviceCode'] = $deviceCode;*/
		$data['carrier'] = $carrier;
		$data['mobilePaymentRefCode'] = $mobilePaymentRefCode;
        $data['transactionRef'] = $transactionRef;
        //$data['hash'] = $hash;

        $result = handleSOAPCalls('confirmTransactionStatus', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/TransactionServices?wsdl', $data);

        //dd(response()->json($result));

        return $result;
    }




	public function getLogs(Request $request, $type=NULL)
	{
		$data = $request->all();

		 return view('core.authenticated.reports.logs', compact('type', 'data'));
	}


	public function getSearchLogs(Request $request)
	{
		$all = $request->all();
		//dd($all);

		$filter = '';
		foreach($all as $k => $v)
		{
			$filter = $filter."&".$k."=".urlencode($v);
		}

		$url = '/potzr-staff/logs';
		if(isset($all['logType']) && $all['logType']!=null)
		{
			$url = $url.'/'.$all['logType'];
		}

		if(strlen($filter)>0)
		{
			$url = $url.'?'.$filter;
		}

		return \Redirect::to($url);
	}


}
