<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;

class PoolAccountController extends Controller
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

    public function getLastFiveTransactions($poolAccountId)
    {

        $data['poolAccountIdS'] = $poolAccountId;
        $data['token'] = \Auth::user()->token;
        $result = handleSOAPCalls('lastFiveTransactions', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PoolAccountServices?wsdl', $data);

        $transactionList = json_decode($result->transactionList);
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

        if ($result->status == 100) {
            $poolAccount = json_decode($result->poolAccount);


            return response()->json(['status' => 1,
                'txn' => $strTxns,
                'poolacccount' => $poolAccount,
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

    public function getNewPoolAccount()
    {
        $user = \Auth::user();
        $all_banks = json_decode($user->all_banks);
        return view('core.authenticated.poolaccount.new-pool-account', compact('all_banks'));
    }

    public function postNewPoolAccount(Request $request)
    {
        $input = $request->all();
        $data['bankId'] = $input['bank'];
        $data['thresholdLevel'] = $input['thresholdLevel'];
        //$data['bankTransactionId'] = $input['bankTransactionId'];
        $data['accountNumber'] = $input['accountNo'];
        $data['token'] = \Auth::user()->token;
        $result = handleSOAPCalls('createNewPoolAccount', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PoolAccountServices?wsdl', $data);

        //dd($result);
        if (handleTokenUpdate($result) == false) {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if ($result->status == 400) {
            $poolacct = json_decode($result->poolacct);
            //return view('core.authenticated.mmoney.account_listing', compact('mobileaccountlist'));
            return \Redirect::to('potzr-staff/pool-accounts/pool-account-listing')->with('message', 'New Pool Account created successfully');
        } else {
            return \Redirect::back()->with('error', $result->message);
        }
    }

    public function getPoolAccountListing()
    {
        $data['token'] = \Auth::user()->token;
        $result = handleSOAPCalls('listPoolAccounts', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PoolAccountServices?wsdl', $data);

        //dd($result);
        if (handleTokenUpdate($result) == false) {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if ($result->status == 410) {
            $poolaccountlist = json_decode($result->poolaccountlist);
            return view('core.authenticated.poolaccount.account_listing', compact('poolaccountlist'));
        } else {
            return \Redirect::back()->with('error', $result->message);
        }

    }


    public function getUpdateAccountStatus($status, $id)
    {
        $data['poolAccountIdS'] = $id;
        if($status == 'suspend-account')
            $data['status'] = 1;
        else if($status == 'activate-account')
            $data['status'] = 0;

        $data['token'] = \Auth::user()->token;
        $result = handleSOAPCalls('changePoolAccountStatus', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PoolAccountServices?wsdl', $data);

        //dd($result);
        if (handleTokenUpdate($result) == false) {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if ($result->status == 410) {
            return \Redirect::to('/potzr-staff/pool-accounts/pool-account-listing')-with('message', 'Pool Account Update was successful');
        } else {
            return \Redirect::back()->with('error', $result->message);
        }
    }


    public function fundPoolAccount($poolAccountId, $txnId, $amt)
    {
        $data['poolAccountIdS'] = $poolAccountId;
        $data['bankTransactionId'] = $txnId;
        $data['amountPaid'] = floatval($amt);
        $data['token'] = \Auth::user()->token;
        $data['payerEmail'] = \Auth::user()->username;
        $data['payerMobile'] = \Auth::user()->username;
        $data['payerName'] = \Auth::user()->username;
        $result = handleSOAPCalls('fundAccount', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/PoolAccountServices?wsdl', $data);


        if (handleTokenUpdate($result) == false) {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if ($result->status == 110) {
            $transaction = json_decode($result->transaction);
            return response()->json(['status' => 1,
                'txn' => $transaction,
                'msg' => 'Account Funded Successfully']);
        } else {
            $transaction = json_decode($result->transaction);
            $poolAccount = json_decode($result->poolAccount);
            return response()->json(['status' => 0,
                'txn' => $transaction,
                'msg' => 'Account Funding Failed']);
        }
    }




}
