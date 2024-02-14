<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;

class VendorServiceController extends Controller
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

    public function getNewVendorService($vendorId=NULL)
    {
        $data = array();
        $data['token'] = \Auth::user()->token;
        if($vendorId!=NULL)
        {
            $data['vendorServiceIdS'] = $vendorId;
        }
        $result = handleSOAPCalls('listAllMerchants', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/UtilityServices?wsdl', $data);


        if($result->status == 410)
        {
            $merchantList = json_decode($result->merchantList);
            return view('core.authenticated.vendorservice.new-vendor-service', compact('merchantList'));
        }else
        {
            return \Redirect::back()->with('error', 'Device transactions fetch failed');
        }

    }

    public function postNewVendorService()
    {
        $input = \Input::all();
        $data['merchantIdS'] = \Crypt::encrypt(intval($input['merchant']));
        $data['serviceName'] = $input['serviceName'];
        $data['amountPayable'] = floatval($input['amountPayable']);
        $data['description'] = $input['serviceDescription'];
        $data['token'] = \Auth::user()->token;

        //dd($data);



        $result = handleSOAPCalls('createNewVendorService', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/VendorServices?wsdl', $data);


        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 410)
        {
            return \Redirect::to('/potzr-staff/vendor-service/vendor-service-listing')->with('message', 'New Vendor Service Created Successfully');
        }else
        {
            return \Redirect::back()->with('error', 'Device transactions fetch failed');
        }

    }


    public function getVendorServiceListing($merchantId=NULL)
    {
        $data = array();
        $data['token'] = \Auth::user()->token;
        if($merchantId!=NULL)
        {
            $data['merchantIdS'] = \Crypt::encrypt(intval($merchantId));
        }


        $result = handleSOAPCalls('listVendorServices', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/VendorServices?wsdl', $data);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 100)
        {
            $vendorServiceList = json_decode($result->vendorServiceList);
            $merchant = json_decode($result->merchant);
            return view('core.authenticated.vendorservice.vendor_service_listing', compact('merchant', 'vendorServiceList'));
        }else
        {
            return \Redirect::back()->with('error', 'Device transactions fetch failed');
        }

    }

    public function getLast5Transactions($vendorServiceId)
    {
        $data = array();
        $data['vendorServiceIdS'] = ($vendorServiceId);
        $data['token'] = \Auth::user()->token;
        $data['count'] = intval(5);

        $result = handleSOAPCalls('listTransactions', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/TransactionServices?wsdl', $data);





        if(handleTokenUpdate($result)==false)
        {
            return response()->json(['status' => -1, 'msg'=>'Login session expired. Please relogin again']);
        }

        if($result->status == 410)
        {
            $transactionList = json_decode($result->transactionList);
            $vendorService = json_decode($result->vendorService);

            $i=0;
            $table = "<table class='table table-bordered table-hover dataTable col col-md-12'><thead><th class='col col-md-1'>S/N</th><th class='col col-md-4'>Date</th><th class='col col-md-4'>Transaction Ref</th><th class='col col-md-5'>Amount</th></thead><tbody>";

            if(sizeof($transactionList)>0) {
                foreach ($transactionList as $transaction) {
                    $table = $table . "<tr><td>" . $i++ . "</td><td>" . $transaction->transactionDate . "</td>";
                    $table = $table . "<td>" . $transaction->transactionRef . "</td>";
                    $table = $table . "<td>" . number_format($transaction->amount, 2, '.', ',') . "</td>";
                }
            }else
            {
                $table = $table . "<tr><td colspan='3'>No Transactions Occured Recently</td>";
            }
            $table = $table . "</tbody></table>";


            //email & SMS epin and mpin to customer
            return response()->json(['status' => (sizeof($transactionList)>0 ? 1 : 0),
                'table' => $table]);
        }
    }

    public function getVendorServiceStatusUpdate($status, $vendorServiceId)
    {
        $data['token'] = \Auth::user()->token;
        $data['vendorServiceIdS'] = $vendorServiceId;
        if($status=='suspend-vendor-service')
            $data['status'] = 2;
        else if($status=='reactivate-vendor-service')
            $data['status'] = 0;

        $result = handleSOAPCalls('updateVendorServiceStatus', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/VendorServices?wsdl', $data);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 410)
        {
            if(\Auth::user()->role_code == \App\Models\Roles::$POTZR_STAFF)
                return \Redirect::to('/potzr-staff/vendor-service/vendor-service-listing')->with('message', 'Vendor Service Updated Successfully');
            else if(\Auth::user()->role_code == \App\Models\Roles::$MERCHANT)
                return \Redirect::to('/merchant/vendor-service/vendor-service-listing')->with('message', 'Vendor Service Updated Successfully');
        }else
        {
            return \Redirect::back()->with('error', 'Device transactions fetch failed');
        }
    }



}
