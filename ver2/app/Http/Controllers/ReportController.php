<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
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


    public function getGenerateSheet()
    {
        $banks = json_decode(\Auth::user()->all_banks);
        return view('core.authenticated.reports.payout_generate', compact('banks'));
    }


    public function postGenerateSheet()
    {
        $input = \Input::all();

        $data['token'] = \Auth::user()->token;
        if($input['payoutDate']!="")
            $data['startTransactionDate'] = $input['payoutDate'];
        if($input['bank']!="")
            $data['bankId'] = intval(explode('|||', $input['bank'])[0]);
        $data['status'] = 'SUCCESS';
        //dd($data);

        $result = handleSOAPCalls('listTransactionsHeavyReturn', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/TransactionServices?wsdl', $data);

        $txnList = ($result);

        if(handleTokenUpdate($result)==false)
        {
            return response()->json(['status' => -1, 'msg'=>'Login session expired. Please relogin again']);
        }


        if($result->status == 410)
        {
            $transactionList = json_decode($result->transactionList);
            $payoutDate = $input['payoutDate'];
            $bankName = \Input::has('bank') ? explode('|||', $input['bank'])[1] : null;



            Excel::create('Batch Payout Listing - Created '.date('Y-m-d H-i'),
                function ($excel) use ($transactionList, $payoutDate, $bankName) {
                    $excel->sheet('BATCH PAYOUT', function ($sheet) use ($transactionList, $payoutDate, $bankName) {
                        //dd($payoutDate);
                        $sheet->loadView('core.authenticated.reports.payout_generate_results', compact('transactionList', 'bankName', 'payoutDate'));
                        //->with('transactionList', $transactionList)->with('bankName', $bankName)->with('payoutDate', $payoutDate);
                    });
                }
            )->download('xls');

            return \Redirect::to('/potzr-staff/payout/generate-sheet');
        }else
        {
            return \Redirect::back()->with('error', 'Batch Payout Listing Generation Failed. Please Try Again');
        }
    }

    public function uploadPaidOutSheet()
    {
        $input = \Input::all();

        $i = 0;

        $rules['excel'] = 'required';
        $validator = \Validator::make(\Input::all(), $rules);
        if ($validator->fails()) {
            return back()->with('input', $input)->with('errors', $validator->errors());
        }

        $excel = \Input::file('excel');

        $file = \Input::file('excel');
        if ($file==NULL) {
            return \Redirect::back()->with('error', 'Batch Upload Failed. Please try again');
        }

        $extension = $file->getClientOriginalExtension();
        $direct = '/'.time();
        /*\Storage::disk('local')->put($direct . '/' . $file->getClientOriginalName() . '.' . $extension,
            \File::get($file));*/
        $destination = 'files/batchpayout/';
        $name = "Batch Payout Uploaded - ".date("Y-m-d H:i").".".$extension;

        //$excel->move($destination, $name);

        $sheet = Excel::load($file)->noHeading(true)->skip(10);
        $rows = $sheet->get();

        $dataToSendYes = "";

        foreach ($rows->all() as $row) {


            if ((trim(strtoupper($row->get(11)))=="YES"))
            {
                $dataToSendYes = $dataToSendYes."".substr($row->get(2), 1)."|||";
            }
        }
        //\Storage::disk('local')->deleteDirectory($direct);


        if(strlen($dataToSendYes)>0) {
            $data['token'] = \Auth::user()->token;
            $data['paidOutYes'] = $dataToSendYes;
            $data['filename'] = $name;

            $result = handleSOAPCalls('updatePaidOutTransactionStatus', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/TransactionServices?wsdl', $data);
            if(handleTokenUpdate($result)==false)
            {
                return response()->json(['status' => -1, 'msg'=>'Login session expired. Please relogin again']);
            }


            if($result->status == 410)
            {
                $transactionList = json_decode($result->transactionList);
                $channel = getAllChannel()[strtoupper($channel)];
                return view('core.authenticated.transactions.transaction_listing', compact('transactionList', 'channel'));
            }else
            {
                return \Redirect::back()->with('error', 'Transaction Listing failed.');
            }
        }
        else {
            return \Redirect::back()->with('error', 'No transactions have been indicated to have been paid out');
        }
    }

    public function getTransactions($channel=NULL)
    {
        $data = array();
        if($channel != NULL)
            $data['channel'] = strtoupper($channel);

        $data['token'] = \Auth::user()->token;
        $data['count'] = 100;

        $result = handleSOAPCalls('listTransactions', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/TransactionServices?wsdl', $data);



        if(handleTokenUpdate($result)==false)
        {
            return response()->json(['status' => -1, 'msg'=>'Login session expired. Please relogin again']);
        }


        if($result->status == 410)
        {
            $transactionList = json_decode($result->transactionList);
            $channel = getAllChannel()[strtoupper($channel)];
            return view('core.authenticated.transactions.transaction_listing', compact('transactionList', 'channel'));
        }else
        {
            return \Redirect::back()->with('error', 'Transaction Listing failed.');
        }

    }





}
