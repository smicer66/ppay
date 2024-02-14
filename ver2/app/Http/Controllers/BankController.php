<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use Maatwebsite\Excel\Facades\Excel;

class BankController extends Controller
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

    public function getNewBank(Request $request)
    {
        $all_currency = getAllCurrency();
	 $all = $request->all();
	 //dd($all);
	 $bankId = isset($all["bankId"]) ? $all["bankId"] : null;
	 $bankName= isset($all["bankName"]) ? $all["bankName"] : null;
	 $bankCode= isset($all["bankCode"]) ? $all["bankCode"] : null;
	 $bicCode= isset($all["bicCode"]) ? $all["bicCode"] : null;
	 $onlineBankingURL= isset($all["onlineBankingURL"]) ? $all["onlineBankingURL"] : null;
	 $countryOfOperation_id= isset($all["countryOfOperation_id"]) ? $all["countryOfOperation_id"] : null;
	 $liveBankCode= isset($all["liveBankCode"]) ? $all["liveBankCode"] : null;
        return view('core.authenticated.banks.new_bank', compact('request', 'all_currency', 'liveBankCode', 'countryOfOperation_id', 'onlineBankingURL', 'bicCode', 'bankCode', 'bankName', 'bankId'));
    }



    public function getNewIssuer(Request $request)
    {
        $banks = ($this->all_banks);
        return view('core.authenticated.banks.new_issuer', compact('request', 'banks'));
    }





    public function getBankTransactions($bankId=NULL)
    {
        $data = array();
        $data['count'] = 5;
        $data['token'] = \Auth::user()->token;
        if($bankId!=NULL)
            $data['bankIdS'] = $bankId;

        $result = handleSOAPCalls('listBankTransactions', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/BankServices?wsdl', $data);

        $transactionList = json_decode($result->transactionlist);
        $strTxns = "";
        foreach($transactionList as $transaction)
        {
            $strTxns = $strTxns."Txn Ref: ".$transaction->transactionRef."<br>";
            $strTxns = $strTxns."Date: ".$transaction->transactionDate."<br>";
            if(isset($transaction->creditPoolAccount)){
                $strTxns = $strTxns."Pool Account: ".$transaction->creditPoolAccount->accountNumber."<br>";
                if(isset($transaction->creditAccount)){
                    $strTxns = $strTxns."Customer Account: ".$transaction->creditAccount->accountIdentifier."<br>";
                }
                $strTxns = $strTxns."Amount Credited: ZMW".number_format($transaction->creditAmount, 2, '.', ',')." [CR] by ".$transaction->payerName."<br>";

            }
            else if(isset($transaction->debitPoolAccount)){
                $strTxns = $strTxns."Pool Account: ".$transaction->debitPoolAccount->accountNumber."<br>";
                $strTxns = $strTxns."Amount Debited: ZMW".number_format($transaction->debitAmount, 2, '.', ',')." [DR] by ".$transaction->payerName."<br>";
                if(isset($transaction->debitAccount)){
                    $strTxns = $strTxns."Customer Account: ".$transaction->debitAccount->accountIdentifier."<br>";
                }
            }
            $strTxns = $strTxns."<br><hr>";
        }

        if(strlen($strTxns)==0)
        {
            $strTxns = "No Transactions found!";
        }



        if (handleTokenUpdate($result) == false) {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if ($result->status == 410) {
            $bank = json_decode($result->bank);


            return response()->json(['status' => 1,
                'txn' => $strTxns,
                'bank' => $bank,
                'msg' => 'Transactions on selected account']);
        } else {
            $transaction = json_decode($result->transaction);
            $poolAccount = json_decode($result->poolAccount);
            return response()->json(['status' => 0,
                'txn' => $transaction,
                'poolacccount' => $poolAccount,
                'msg' => 'Transactions on selected account']);
        }
    }


    public function getGenerateTransactionsReceivedForBank()
    {
        //{{\Crypt::encrypt(\Auth::user()->staff_bank_code)}}
        $banks = json_decode(\Auth::user()->all_banks);
        return view('core.authenticated.banks.payments_received', compact('banks'));
    }


    public function paidGenerateTransactionsReceivedForBank()
    {
        $bankStaffCode = \Crypt::encrypt(\Auth::user()->staff_bank_code);
        $data = array();
        $data['token'] = \Auth::user()->token;
        if($bankStaffCode!=NULL)
            $data['recBankCodeS'] = $bankStaffCode;
        if(\Input::has('payoutDate'))
            $data['startTransactionDate'] = \Input::get('payoutDate');

        $result = handleSOAPCalls('listBankTransactions', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/BankServices?wsdl', $data);



        if(handleTokenUpdate($result)==false)
        {
            return response()->json(['status' => -1, 'msg'=>'Login session expired. Please relogin again']);
        }


        if($result->status == 410)
        {
            $transactionList = json_decode($result->transactionlist);

            $payoutDate = \Input::get('payoutDate');
            $bankName = \Input::has('bank') ? explode('|||', \Input::get('bank'))[1] : null;


            $status_type = "Payments Received";

            Excel::create('Transaction Listings for '.$bankName.' - Created '.date('Y-m-d H-i'),
                function ($excel) use ($transactionList, $payoutDate, $bankName, $status_type) {
                    $excel->sheet('TRANSACTIONS', function ($sheet) use ($transactionList, $payoutDate, $bankName, $status_type) {
                        //dd($payoutDate);
                        $sheet->loadView('core.authenticated.banks.payments_results', compact('status_type', 'transactionList', 'bankName', 'payoutDate'));
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


    public function paidGenerateTransactionsPaidOutForBank()
    {
        $bankStaffCode = \Crypt::encrypt(\Auth::user()->staff_bank_code);
        $data = array();
        $data['token'] = \Auth::user()->token;
        if($bankStaffCode!=NULL)
            $data['paidGenerateTransactionsPaidOutForBank'] = $bankStaffCode;
        if(\Input::has('payoutDate'))
            $data['startTransactionDate'] = \Input::get('payoutDate');

        $result = handleSOAPCalls('listBankTransactions', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/BankServices?wsdl', $data);



        if(handleTokenUpdate($result)==false)
        {
            return response()->json(['status' => -1, 'msg'=>'Login session expired. Please relogin again']);
        }


        if($result->status == 410)
        {
            $transactionList = json_decode($result->transactionlist);

            $payoutDate = \Input::get('payoutDate');
            $bankName = \Input::has('bank') ? explode('|||', \Input::get('bank'))[1] : null;


            $status_type = "Payments From Bank Accounts";

            Excel::create('Transaction Listings for '.$bankName.' - Created '.date('Y-m-d H-i'),
                function ($excel) use ($transactionList, $payoutDate, $bankName, $status_type) {
                    $excel->sheet('TRANSACTIONS', function ($sheet) use ($transactionList, $payoutDate, $bankName, $status_type) {
                        //dd($payoutDate);
                        $sheet->loadView('core.authenticated.banks.payments_results', compact('status_type', 'transactionList', 'bankName', 'payoutDate'));
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

    public function getBankListing()
    {
        return view('core.authenticated.banks.bank_listing');
    }

    public function getBankStaffListing($bankIdS)
    {
        $data['token'] = \Auth::user()->token;
        $data['bankIdS'] = $bankIdS;
        $result = handleSOAPCalls('getBankStaffList', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/BankServices?wsdl', $data);


        if (handleTokenUpdate($result) == false) {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if ($result->status == 410) {
            $bankStaffList = json_decode($result->bankStaffList);
            return view('core.authenticated.banks.staff_listing', compact('bankStaffList'));
        } else {
            return \Redirect::back()->with('error', 'No Bank Staff Currently Setup on Platform');
        }
    }


    public function getAcquirerListing()
    {
        $data['token'] = \Auth::user()->token;
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BankServicesV2/listAcquirers';
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }

        $authDataStr = sendGetRequest($url, $dataStr);
        //dd($authDataStr);
        $result = json_decode($authDataStr);

	$login1 = json_decode(\Session::get('login_'.\Auth::user()->id));

	//dd(\Auth::user());
	//dd(\Session::all());
	//dd(($login1));
	$all_merchant_schemes = (($login1)->all_merchant_schemes);
	$all_merchant_schemes = json_decode($all_merchant_schemes);
	$all_banks = $login1->all_banks;
	$banks = json_decode($all_banks);
	$all_currency = ['ZMW'=>'ZMW', 'TZS'=>'TZS'];



        //dd($result);

        if (handleTokenUpdate($result) == false) {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if ($result->status == 410) {
            $acquirerList = ($result->acquirerList);
            return view('core.authenticated.banks.acquirer_listing', compact('acquirerList', 'all_merchant_schemes', 'banks', 'all_currency'));
        } else {
            return \Redirect::back()->with('error', 'No Acquirers Currently Setup on Platform');
        }
    }

    public function getIssuerListing()
    {
        $data['token'] = \Auth::user()->token;
        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/BankServicesV2/listIssuers';
        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }

        $authDataStr = sendGetRequest($url, $dataStr);
        //dd($authDataStr);
        $result = json_decode($authDataStr);
	 //dd($result);



        if (handleTokenUpdate($result) == false) {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if ($result->status == 410) {
            $issuerList = ($result->issuerList);
            return view('core.authenticated.banks.issuer_listing', compact('issuerList'));
        } else {
            return \Redirect::back()->with('error', 'No Issuers Currently Setup on Platform');
        }
    }

    public function getNewBankStaff()
    {
        return view('core.authenticated.banks.new_bank_staff');
    }

    public function getBankStaffPriviledges()
    {
        return view('core.authenticated.banks.staff_priviledges');
    }





}
