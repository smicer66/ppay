<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use Illuminate\Support\Facades\Auth;
use JWTAuth;


class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
		parent::__construct();
    }

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



	public function getBillsIndex(Request $request)
	{
		$all = $request->all();


		/*$token = $all['token'];
		$payload = JWTAuth::setToken($token)->getPayload();

		\Session::put('jwt_token', $all['token']);
		\Session::put('server_token', $all['stk']);

        	$user = JWTAuth::toUser($token);
//dd($user);*/
		return view('guests.payment.web.bills.bills_dashboard', compact('all'));
	}


	public function getUtilitiesPaid(Request $request, $vendor)
	{
		$all = $request->all();

		$serviceType = "";
		if($vendor=="MTN")
			$serviceType = "MTN_AIRTIME_PURCHASE";
		if($vendor=="AIRTEL")
			$serviceType = "AIRTEL_AIRTIME_PURCHASE";
		if($vendor=="ZAMTEL")
			$serviceType = "ZAMTEL_AIRTIME_PURCHASE";
		if($vendor=="DSTV")
			$serviceType = "CABLE_TV_PURCHASE_DSTV";
		if($vendor=="GOTV")
			$serviceType = "CABLE_TV_PURCHASE_GOTV";
		if($vendor=="TOPSTAR")
			$serviceType = "CABLE_TV_PURCHASE_TOPSTAR";

		return view('core.authenticated.utility.utility_listing', compact('all', 'vendor', 'serviceType'));
	}



	public function getCustomerLoans(Request $request)
	{
		$all = $request->all();
		
		return view('core.authenticated.utility.customer_loans_listing', compact('all'));
	}

}
