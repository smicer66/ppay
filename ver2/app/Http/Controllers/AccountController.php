<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use Maatwebsite\Excel\Facades\Excel;

class AccountController extends Controller
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


    public function updateAccountStatus($status, $accountIdS)
    {
        $data = array();
        $data['accountIdS'] = $accountIdS;
        $data['status'] = $status=="suspend-account" ? "0" : ($status=="reactivate-account" ? "1" : "2");
        $data['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('listAccountCards', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/AccountServices?wsdl', $data);

        //dd($result);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 110)
        {
            return \Redirect::back()->with('message', 'Account updated successfully');
        }else
        {
            return \Redirect::back()->with('error', $result->message);
        }
    }



    public function getViewAccountCards($accountId)
    {
        $data = array();
        $data['accountIdS'] = $accountId;
        $data['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('listAccountCards', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/AccountServices?wsdl', $data);

        //dd($result);

        if(handleTokenUpdate($result)==false)
        {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 110)
        {
            $customercardlist = json_decode($result->customercardlist);

            $account = json_decode($result->account);
            return view('core.authenticated.ecards.ecard_listing', compact('customercardlist', 'account'));
        }else
        {
            return \Redirect::back()->with('error', 'Accessing list of cards under account failed. Please try again');
        }
    }


    public function postFundAccount($aid, $banktransactionid, $amountPaid)
    {
        $data = array();
        $data['accountIdS'] = $aid;
        $data['bankTransactionId'] = $banktransactionid;
        $data['amountPaid'] = $amountPaid;
        $data['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('fundAccount', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/AccountServices?wsdl', $data);

        //dd($result);

        if(handleTokenUpdate($result)==false)
        {
            return response()->json(['status' => -1, 'msg'=>'Login session expired. Please relogin again']);
        }

        if($result->status == 110)
        {
            $transaction = json_decode($result->transaction);
            $amountFunded = $result->amountFunded;
            $mobile = $result->mobileNo;
            $newBalance = $result->newBalance;
            $accountNo = $result->accountNo;
            $txnDate = $result->txnDate;

            $msg = "Acct Credit. \nAcct No: ".$accountNo."\nAmt: ZMW".$amountFunded."\Bal:ZMW".$newBalance."\nDate:".$txnDate."";
            send_sms($mobile, $msg);

            return response()->json(['status' => 1,
                'txnId' => $transaction->transactionRef,
                'msg' => $result->message.". TXN REF: #".$transaction->transactionRef]);
        }else
        {
            if(isset($result->transaction)) {
                $transaction = json_decode($result->transaction);
                return response()->json(['status' => 0, 'msg' => $transaction->message]);
            }else
            {
                return response()->json(['status' => 0, 'msg' => 'Account Funding Failed']);
            }
        }
    }





    public function addNewCardToAccount($nameOnCard, $cardType, $cardScheme, $addmobilemoney, $accountId)
    {
        $data = array();
        $data['accountIdS'] = urldecode($accountId);
        $data['nameOnCard'] = urldecode($nameOnCard);
        $data['cardType'] = urldecode($cardType);
        $data['cardSchemeIdS'] = urldecode($cardScheme);
        $data['addMobileMoneyS'] = urldecode($addmobilemoney);
        $data['token'] = \Auth::user()->token;

        $result = handleSOAPCalls('addNewCard', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/AccountServices?wsdl', $data);



        if(handleTokenUpdate($result)==false)
        {
            return response()->json(['status' => -1, 'msg'=>'Login session expired. Please relogin again']);
        }/**/

        if($result->status == 5000)
        {
            $transaction = json_decode($result->transaction);
            $mpin = isset($result->mpin) ? $result->mpin : null;
            $epin = isset($result->epin) ? $result->epin : null;
            $cardno = isset($result->cardno) ? $result->cardno : null;
            $mobileNo = isset($result->mobileNo) ? $result->mobileNo : null;
            $cvv = isset($result->cvv) ? $result->cvv : null;

            $msg = "New Probase Card Detail. \nCard No: ".$cardno."\nPin:".$epin."\nCVV:".$cvv."\nMobile Account No:".$mobileNo."\nMobile Pin:".$mpin."\n";
            send_sms($mobileNo, $msg);

            //email & SMS epin and mpin to customer
            return response()->json(['status' => 1,
                'txnId' => $transaction->transactionRef,
                'msg' => $result->message.". TXN REF: #".$transaction->transactionRef]);
        }else
        {
            if(isset($result->transaction)) {
                $transaction = json_decode($result->transaction);
                return response()->json(['status' => 0, 'msg' => $transaction->message]);
            }else
            {
                return response()->json(['status' => 0, 'msg' => 'Account Funding Failed']);
            }
        }
    }






    public function downloadBatchAccountTemplate($primaryAccount=NULL)
    {
        $data = array();
        $customer = null;
        $account = null;

        if($primaryAccount!=null) {
            $data['accountIdS'] = $primaryAccount;
            $data['token'] = \Auth::user()->token;

            $result = handleSOAPCalls('getAccountById', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/AccountServices?wsdl', $data);

            if (handleTokenUpdate($result) == false) {
                return redirect('/')->with('error', 'Login session expired. Please relogin again');
            }

            $customer = json_decode($result->customer);
            $account = json_decode($result->account);
        }

        Excel::create("Batch Account Upload Template",
            function ($excel) use ($customer, $account) {
                $excel->sheet('List of Accounts', function ($sheet) use ($customer, $account) {
                    $data = array();
                    $sheet->freezeFirstRowAndColumn();
                    $sheet->loadView('core.authenticated.account.batch_account_template')
                        ->with('customer', $customer)->with('account', $account);
                });
            })
        ->download('xls');
    }


    public function getUploadBatchAccountTemplate($primaryAccountId=NULL)
    {
        $customer = null;
        $account = null;
        $all_card_schemes = \Auth::user()->all_card_schemes;
        $all_card_schemes = json_decode($all_card_schemes);


        if($primaryAccountId!=null) {
            $data['accountIdS'] = $primaryAccountId;
            $data['token'] = \Auth::user()->token;

            $result = handleSOAPCalls('getAccountById', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/AccountServices?wsdl', $data);

            if (handleTokenUpdate($result) == false) {
                return redirect('/')->with('error', 'Login session expired. Please relogin again');
            }

            $customer = json_decode($result->customer);
            $account = json_decode($result->account);
        }
        return view('core.authenticated.account.batch_upload_account', compact('all_card_schemes', 'account', 'customer', 'primaryAccountId'));
    }


    public function postUploadBatchAccountTemplate(Request $request, $primaryAccountId = NULL)
    {
        $this->validate($request, [
            'template' => 'required',
            'cardScheme' => 'required',
        ]);

        $cardScheme = \Input::get('cardScheme');
        $excel = \Input::file('template');
        $parentCustomerId = \Input::get('parentCustomerId');

        $file = $request->file('template');

        $extension = $file->getClientOriginalExtension();
        /*$direct = '/'.$this->school->id.'/'.Input::get('class') . '/' . time();
        \Storage::disk('local')->put($direct . '/' . $file->getClientOriginalName() . '.' . $extension,
            \File::get($file));*/


        $sheet = Excel::load($request->file('template'))->noHeading(true)->skip(2);
        $rows = $sheet->get();

        //dd($rows->all());
        $count_ = 0;
        $push_ = [];
        $primaryAccountId_ = null;
        foreach ($rows->all() as $row) {
            $row = $row->values();
            $count_++;
            $ar = [];

            //dd($row->get(0));
            if($count_==1)
            {

                if($row->get(0)!=NULL && $row->get(0)=='PRIMARY ACCOUNT HOLDER')
                    $primaryAccountId_ = $row->get(1);
            }

            if($count_ > 9) {
                if ($row->get(0) != NULL && strlen(trim($row->get(0))) > 0 &&
                    $row->get(1) != NULL && strlen(trim($row->get(1))) > 0 &&
                    $row->get(3) != NULL && strlen(trim($row->get(3))) > 0 &&
                    $row->get(5) != NULL && strlen(trim($row->get(5))) > 0 &&
                    $row->get(7) != NULL && strlen(trim($row->get(7))) > 0 &&
                    $row->get(9) != NULL && strlen(trim($row->get(9))) > 0 &&
                    $row->get(10) != NULL && strlen(trim($row->get(10))) > 0 && (trim(strtoupper($row->get(10))) == "MALE" || trim(strtoupper($row->get(10))) == "FEMALE") &&
                    $row->get(12) != NULL && strlen(trim($row->get(12))) > 0 && (trim(strtoupper($row->get(12))) == "CURRENT" || trim(strtoupper($row->get(12))) == "SAVINGS") &&
                    $row->get(13) != NULL && strlen(trim($row->get(13))) > 0 &&
                    $row->get(14) != NULL && strlen(trim($row->get(14))) > 0 && (trim(strtoupper($row->get(14))) == "YES" || trim(strtoupper($row->get(14))) == "NO") &&
                    $row->get(15) != NULL && strlen(trim($row->get(15))) > 0 && (trim(strtoupper($row->get(15))) == "YES" || trim(strtoupper($row->get(15))) == "NO")
                ) {
                    $ar['addressLine1'] = $row->get(3);
                    if($row->get(4)!=null && strlen(trim($row->get(4)))>0)
                        $ar['addressLine2'] = $row->get(4);

                    if ($row->get(6) != NULL && strlen(trim($row->get(6))) > 0)
                        $ar['altContactEmail'] = $row->get(6);

                    if ($row->get(8) != NULL && strlen(trim($row->get(8))) > 0)
                        $ar['altContactMobile'] = $row->get(8);

                    $ar['contactEmail'] = $row->get(5)."@testmail.com";
                    $ar['contactMobile'] = $row->get(7);
                    $ar['dateOfBirth'] = $row->get(9);
                    $ar['firstName'] = $row->get(0);
                    $ar['gender'] = $row->get(10);
                    $ar['lastName'] = $row->get(1);

                    if ($row->get(2) != NULL && strlen(trim($row->get(2))) > 0)
                        $ar['otherName'] = $row->get(2);

                    $ar['nameOnCard'] = $row->get(11);
                    $ar['accountType'] = $row->get(12);
                    $ar['openingAccountAmount'] = $row->get(13);
                    $ar['eWalletAccountCreateTrue'] = $row->get(14)=="Yes" ? "true" : "false";
                    $ar['mobileMoneyCreateTrue'] = $row->get(15)=="Yes" ? "true" : "false";
                    $ar['currencyCode'] = "ZMK";
                    $ar['countryCode'] = "026";
                    array_push($push_, $ar);
                }
            }


        }

        //dd($push_);
        $data['bulkCustomerData'] = (json_encode($push_));
        $data['token'] = \Auth::user()->token;
        $data['customerType'] = 'INDIVIDUAL';
        if($primaryAccountId!=NULL)
            $data['parentAccountId'] = \Crypt::decrypt($primaryAccountId);
        if($parentCustomerId!=NULL)
            $data['parentCustomerId'] = intval($parentCustomerId);
        $data['cardSchemeId'] = intval($cardScheme);
        $data['currencyCode'] = "ZMK";
        $data['countryCode'] = "026";

        //dd($data);
        $result = handleSOAPCalls('createNewBulkCustomerAccount', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/CustomerServices?wsdl', $data);


        if (handleTokenUpdate($result) == false) {
            return redirect('/')->with('error', 'Login session expired. Please relogin again');
        }

        //dd($result);
        if($result->status == 115)
        {
            $parentCustomer = json_decode($result->parentCustomer);
            $parentAccount = json_decode($result->parentAccount);
            //dd(($parentAccount));
            $corporateCustomerSubAccountList = json_encode($result->corporateCustomerSubAccountList);
            $jsonReturnInfo = ($result->jsonReturnInfo);

            for($i=0; $i<sizeof($jsonReturnInfo);$i++) {
                $jsonReturnInfo_ = $jsonReturnInfo[$i];
                $cardno = isset($jsonReturnInfo_->pan) ? $jsonReturnInfo_->pan : null;
                $epin = isset($jsonReturnInfo_->pin) ? $jsonReturnInfo_->pin : null;
                $mobileNo = isset($jsonReturnInfo_->mobileContact) ? $jsonReturnInfo_->mobileContact : null;
                $mpin = isset($jsonReturnInfo_->mpin) ? $jsonReturnInfo_->mpin : null;
                $msg = "New Probase Card Detail. ".($cardno==null ? "" : ("\nCard No: " . $cardno)) .
                    ($epin==null ? "" : ("\nPin:" . $epin)) .
                    ($mobileNo==null ? "" : ("\nMobile Account No:" . $mobileNo)).
                    ($mpin==null ? "" : ("\nMobile Pin:" . $mpin . "\n"));
                send_sms($mobileNo, $msg);
            }

            return \Redirect::to('/bank-teller/accounts/list-corporate-sub-accounts/'.\Crypt::encrypt($parentAccount->id).'/0')->with('message', $result->message);
        }else
        {
            return \Redirect::back()->with('error', isset($result->message) ? $result->message : 'Error encountered. Please try again');
        }

        /*\Storage::disk('local')->deleteDirectory($direct);
        if($array!=null  && sizeof($array)>0)
        {
            return redirect()->to('/admin/user/students')->with('warning', gtv('SOME_STUDENTS_PUSHED_UP')."<br>".join(', ', $array));
        }
        return redirect('admin/user/students')->with('message',gtv('STUDENT_UPDATED'));*/

    }



    public function getWalletOverviewForCustomer()
    {
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
        else if($authData->status==-1) {
            return \Redirect::to('/logout')->with('warning', 'Login to continue');
        }

        $accountIdentifier = null;
        if($accounts!=null && sizeof($accounts)>0)
            $accountIdentifier = $accounts[0]->accountIdentifier;

        //dd($authData);
        return view('core.authenticated.account.account_overview', compact('accounts', 'cards', 'accountIdentifier'));
    }



    public function getCardsOverviewForCustomer()
    {
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
        $transactions = null;
        if($authData->status==5000) {
            $accounts = $authData->accounts;
            $cards = $authData->cards;
            $transactions = $authData->transactions;
        }
        else if($authData->status==-1) {
            return \Redirect::to('/auth/login')->with('warning', 'Login to continue');
        }

        $accountIdentifier = null;
        if($accounts!=null && sizeof($accounts)>0)
            $accountIdentifier = $accounts[0]->accountIdentifier;

        //dd($cards);
        $transactionStatuses = array_keys(getAllTransactionStatus());
        $serviceTypes = array_values(getAllServiceTypes());
        $serviceTypesKeys = array_keys(getAllServiceTypes());
        $currencies = array_keys(getAllCurrency());
        return view('core.authenticated.ecards.cards_overview', compact('accounts', 'cards', 'accountIdentifier', 'transactions', 'transactionStatuses', 'serviceTypes', 'currencies', 'serviceTypesKeys'));
    }


    public function getViewListCorporateSubAccounts($corporateAcctId, $page=NULL)
    {
        $data = array();
        if($page==NULL)
            $page = 0;

        $data['token'] = \Auth::user()->token;
        $data['corporateAcctId'] = $corporateAcctId;
        $data['index'] = $page;
        $data['count'] = 100;

        $result = handleSOAPCalls('listCorporateSubAccountsEcards', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CardServices?wsdl', $data);

        //dd($result);

        if(handleTokenUpdate($result)==false)
        {
            u_logout();
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if($result->status == 110)
        {
            $corporateCustomerAccountEcardList = json_decode($result->corporateCustomerAccountEcardList);

            $account = json_decode($result->corporateAccount);
            //dd($account);
            $accessingUserRole = getRoleInterpretRoute(\Auth::user()->role_code);
            return view('core.authenticated.customer.corporate_sub_accounts_listing', compact('corporateAcctId', 'page', 'account', 'corporateCustomerAccountEcardList', 'accessingUserRole'));
        }else
        {
            return \Redirect::back()->with('error', 'Failed to access customer listing');
        }
    }




    public function getViewWalletTransactions($walletId=NULL)
    {

        return view('core.authenticated.transactions.wallet_transaction_listing', compact('walletId'));
    }


    public function getWalletOverview()
    {
        return view('core.authenticated.account.account_listing_view_for_customer');
    }
}
