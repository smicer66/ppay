<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use Illuminate\Support\Str;
use Illuminate\Encryption\Encrypter;

class CardController extends Controller
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


	public function getNewBatchCardUpload()
	{
        $loginData = json_decode(session()->all()['login_1']);
        $allAcquirers = $loginData->all_acquirers;
        $allAcquirers = json_decode($allAcquirers);
        $allIssuers = $loginData->all_issuers;
        $allIssuers = json_decode($allIssuers);

		return view('core.authenticated.ecards.batch_card_upload', compact('allIssuers', 'allAcquirers'));
	}

	public function getDownloadBatchCardTemplate()
	{
		$data = array();
        $customer = null;
        $account = null;


        \Excel::create("Batch Card Upload Template",
            function ($excel){
                $excel->sheet('List of Physical Cards', function ($sheet) {
                    $data = array();
                    $sheet->loadView('core.authenticated.ecards.batch_card_template');
                });
            }
        )->download('xls');
	}



	public function postUploadBatchCardTemplate(Request $request)
	{
		$this->validate($request, [
            		'template' => 'required',
        	]);

		//dd($request->all());
        $excel = $request->file('template');

        $file = $request->file('template');

        $extension = $file->getClientOriginalExtension();
        /*$direct = '/'.$this->school->id.'/'.Input::get('class') . '/' . time();
        \Storage::disk('local')->put($direct . '/' . $file->getClientOriginalName() . '.' . $extension,
            \File::get($file));*/


        //$sheet = \Excel::load($request->file('template'))->noHeading(true)->skip(3);
        $sheet = \Excel::toArray(new \App\Models\User, $request->file('template'));
        $sheet = $sheet[0];
        $count = 0;
        $push_ = [];
        $primaryAccountId_ = null;
        foreach ($sheet as $row) {

            if ($count>1 && $count<50) {
                $ar = [];


                if ($row[0] != null && strlen(trim($row[0])) > 0 &&
                    $row[1] != null && strlen(trim($row[1])) > 0 &&
                    $row[2] != null && strlen(trim($row[2])) > 0) {
                    $ar['serialNo'] = $row[0]."";
                    $ar['trackingNumber'] = $row[1]."";
                    $ar['cardNumber'] = $row[2]."";

                    array_push($push_, $ar);
                }
            }
            $count++;
        }

        $data['token'] = \Auth::user()->token;
        $data['acquirerId'] = $request->get('acquirer');
        $data['issuerId'] = $request->get('issuer');
        $data['encryptedData'] = \Crypt::encrypt(json_encode($push_));

        //dd($data);

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        //dd($dataStr);

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/uploadPhysicalCardBin';
        $result = sendPostRequest($url, $dataStr);
        $result = json_decode($result);



        //$result = handleSOAPCalls('uploadTutukaCompanionPhysicalCardBin', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/TutukaServices?wsdl', $data);
       // $result = handleSOAPCalls('uploadPhysicalCardBin', 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/CardServicesV2?wsdl', $data);
        handleTokenUpdate($result);


        if (handleTokenUpdate($result) === false) {
            return redirect('/')->with('error', 'Login session expired. Please relogin again');
        }

        //dd($result);
        if($result->status == 5000)
        {
            return \Redirect::to('/potzr-staff/ecards/batch-card-listing')->with('message', $result->message);
        }else
        {
            return \Redirect::back()->with('error', isset($result->message) ? $result->message : 'Error encountered. Please try again');
        }

	}



	


	public function postUploadBatchCardTemplateV2(Request $request)
	{
		$this->validate($request, [
            		'template' => 'required',
        	]);

		//dd($request->all());
        	$excel = $request->file('template');

        	$file = $request->file('template');

		$dataRead = $this->readCSV($request, $file,array('delimiter' => ','));
		$batchCode = strtoupper(Str::random(16));
       	$acquirerId = $request->get('acquirer');
	       $issuerId = $request->get('issuer');
		return view('core.authenticated.ecards.batch_upload_step_two', compact('dataRead', 'batchCode', 'acquirerId', 'issuerId'));
		dd(33);

	}









	public function readCSV($request, $csvFile, $array)
	{
		//phpinfo();
//dd(330);
		//ini_set('max_execution_time', 600); 
		$all = $request->all();
		try
		{
    			$file_handle = fopen($csvFile, 'r');
    			while (!feof($file_handle)) {
				$line_of_text[] = fgetcsv($file_handle, 0, $array['delimiter']);
    			}
			fclose($file_handle);


			$responseDataAll = [];
			$i=0;

			return ($line_of_text);

			

		}
		catch(\Exception $e)
		{

		}

		//dd($responseDataAll);
	}




	public function getBatchCardListing()
    {
        return view('core.authenticated.ecards.batch_card_listing');
    }



    public function getCardListing()
    {
        return view('core.authenticated.ecards.ecard_listing');
    }


    public function getCardRequestListing()
    {
        return view('core.authenticated.ecards.card_request_listing');
    }





    public function getUpdateCardStatus($status, $cardId)
    {
        if($status=='reactivate')
            $status = 0;
        else if($status=='delete')
            $status = 1;
        else if($status=='block')
            $status = 2;
        else if($status=='activate')
            $status = 0;
        else if($status=='stop')
            $status = 7;
        else if($status=='issue')
            $status = 6;


	$defaultAcquirer = \App\Models\Acquirer::where('isDefault', '=', 1)->first();
        //dd($defaultAcquirer->toArray());
        if($defaultAcquirer==null)
        {
            return response()->json(['message' => 'Error encountered. ERR00AQ1', 'success'=>false], 200);
        }

        $defaultAcquirer = $defaultAcquirer->toArray();

        $encrypterFrom = new Encrypter($defaultAcquirer['accessExodus'], 'AES-256-CBC');
        //$password = \Crypt::encryptPseudo($all['password'], true, );
        $cardId= $encrypterFrom->encrypt($cardId."");



        $data = array();
        $data['cardIdS'] = $cardId;
        $data['status'] = $status;
        $data['deviceCode'] = BEVURA_DEVICE_CODE;
        $data['token'] = \Auth::user()->token;
	 $data['stopCardReason'] = 3;
        
       // dd($push);

        $dataStr = "";
        foreach($data as $d => $v)
        {
            $dataStr = $dataStr."".$d."=".$v."&";
        }


        //dd($dataStr);

        $url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/CardServicesV2/updateCardStatus';
        $result = sendPostRequest($url, $dataStr);
//dd($result);
        $result = json_decode($result);
//	 dd($result);



        //$result = handleSOAPCalls('uploadTutukaCompanionPhysicalCardBin', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/TutukaServices?wsdl', $data);
       // $result = handleSOAPCalls('uploadPhysicalCardBin', 'http://' . getServiceBaseURL() . '/ProbasePayEngineV2/services/CardServicesV2?wsdl', $data);
        //handleTokenUpdate($result);


        
        if (handleTokenUpdate($result) == false) {
            return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
        }

        if ($result->status == 100) {
            return \Redirect::back()->with('message', $result->message);
        } else {
            return \Redirect::back()->with('error', $result->message);
        }
    }


    public function getCardSchemeListing()
    {
        return view('core.authenticated.ecards.ecard_scheme_listing');
    }



    public function getNewCardScheme($id=NULL)
    {

        return view('core.authenticated.ecards.new_card_scheme', compact('id'));
    }


    public function getNewCard($id=NULL)
    {
        return view('core.authenticated.ecards.new_card', compact('id'));
    }





    public function addRemoveMMoney($action, $aid, $mobileNo)
    {

        if($action=="deactivate-mmoney") {
            $data = array();
            $data['cardIdS'] = $aid;
            $data['token'] = \Auth::user()->token;
            $result = handleSOAPCalls('deactivateMobileMoney', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CardServices?wsdl', $data);

            if (handleTokenUpdate($result) == false) {
                return redirect('/auth/login')->with('error', 'Login session expired. Please relogin again');
            }

            if ($result->status == 100) {
                return \Redirect::back()->with('message', 'Mobile Account deactivated successfully');
            } else {
                return \Redirect::back()->with('message', 'Mobile Account deactivation failed');
            }
        }
        else if($action=="activate-mmoney") {
            $data = array();
            $data['cardIdS'] = $aid;
            $data['mobileNumber'] = $mobileNo;
            $data['token'] = \Auth::user()->token;

            $result = handleSOAPCalls('activateMobileMoney', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/CardServices?wsdl', $data);

            //dd($result);

            if (handleTokenUpdate($result) == false) {
                return response()->json(['status' => -1, 'msg'=>'Login session expired. Please relogin again']);
            }

            if ($result->status == 410) {
                $mobileaccount = json_decode($result->mobileaccount);
                //send mobile account new pin OR
                //Send mobile acount new pin
                $mpin = isset($result->mpin) ? $result->mpin : null;
                $mobileNo = isset($result->mobileNo) ? $result->mobileNo : null;

                $msg = "New Probase Mobile Account Detail. \nMobile Account No:".$mobileNo."\nMobile Pin:".$mpin."\n";
                send_sms($mobileNo, $msg);

                return response()->json(['status' => 1,
                    'msg' => $result->message]);
            } else {
                if (isset($result->mobileaccount)) {
                    return response()->json(['status' => 0, 'msg' => $result->message]);
                } else {
                    return response()->json(['status' => 0, 'msg' => 'Mobile Account Activation Failed']);
                }
            }
        }
    }





    public function getViewCardTransactions($cardId=NULL)
    {

        return view('core.authenticated.transactions.card_transaction_listing', compact('cardId'));
    }



	public function getViewMastercardReports(Request $request)
	{
        	return view('core.authenticated.ecards.mastercard_reports');
	}



	public function getDownloadMastercardReport($reportType, $date, $cardtype)
	{
		$report = \App\Models\Report::where('report_type', '=', $reportType)->where('report_date', '=', $date)
			->where('is_downloaded', '=', 1)->where('is_physical_card', '=', $cardtype==0 ? 1 : 0)->first();

		if($report==null)
		{
			return \Redirect::back()->with('error', 'No report for the specified date is available matching the report name');
		}
		//dd($report);

		//var/www/html/domains/probasepay.com/ver2.0/storage/app/mastercardreports/2022-04-06/ProbasePhysicalcards_MarkOffFile_GMT_plus_2_00h00_20220406.csv",
		//var/www/html/domains/probasepay.com/ver2.0/storage/app/mastercardreports/2022-04-06/ProbasePhysicalcards_MarkOffFile_GMT_plus_2_00h00_20220406.csv

		$fileName = storage_path('app').'/mastercardreports/'.$date.'/'.$report->name;
		$fileNameParts = explode('.', $fileName);
		$headers = array(
              	'Content-Type' => 'text/'.$fileNameParts[sizeof($fileNameParts)-1],
            	);

		//dd($report->report_type.'_'.$date.'.'.$fileNameParts[sizeof($fileNameParts)-1]);

    		return \Response::download($fileName , $report->report_type.'_'.$date.'.'.$fileNameParts[sizeof($fileNameParts)-1], $headers);
	}


	public function getCloseSupportMessage(Request $request, $supportMessageId)
	{

		$data['token'] = \Auth::user()->token;
        	//$result = handleSOAPCalls('listMerchants', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', $data);
        	$data = 'token='.\Auth::user()->token.'&supportMessageId='.$supportMessageId;
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/closeSupportMessage';
       	$authDataStr = sendGetRequest($url, $data);
        	$authData = json_decode($authDataStr);

		if($authData->status == 5000) {
			return \Redirect::back()->with('message', isset($authData->message) ? $authData->message : 'Support issue has been closed successfully');
		}
		else
		{
			return \Redirect::back()->with('error', isset($authData->message) ? $authData->message : 'Error encountered closing this support issue');
		}
	}

	public function getSupportMessages(Request $request)
	{

		$data['token'] = \Auth::user()->token;
        	//$result = handleSOAPCalls('listMerchants', 'http://'.getServiceBaseURL().'/ProbasePayEngine/services/MerchantServices?wsdl', $data);
        	$data = 'token='.\Auth::user()->token;
		$url = 'http://'.getServiceBaseURL().'/ProbasePayEngineV2/services/UtilityServicesV2/getSupportMessages';
       	$authDataStr = sendGetRequest($url, $data);
        	$authData = json_decode($authDataStr);

//dd($authData);

        if($authData->status == 5000) {
		$list = ($authData->supportMessages);
		return view('core.authenticated.utility.support_messages', compact('list'));
            /*$list = ($authData->supportMessages);
			$allDt = [];
			for($i1=0; $i1<sizeof($list); $i1++)
			{
				//dd($list[$i1]);
				$y =$list[$i1]->id;
				$dt = [];
				$dt['createdAt']= '<strong>'.$list[$i1]->createdAt.'</strong>';
				$dt['sendersName'] = $list[$i1]->sendersName;
				$dt['details'] = $list[$i1]->details;

				$str = "";



				$str = $str.'<div class="btn-group mr-1 mb-1">';;
					$str = $str.'<button aria-expanded="false" aria-haspopup="true" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" id="dropdownMenuButton1" type="button">Action</button>';
					$str = $str.'<div aria-labelledby="dropdownMenuButton1" class="dropdown-menu">';


						$str = $str.'<a class="dropdown-item" href="/potzr-staff/support-messages/close-support-message/'.$y.'">Close Support Message</a>';
						
					$str = $str.'</div>';
				$str = $str.'</div>';
				$dt['action'] = $str;
				array_push($allDt, $dt);
			}
			//dd($allDt);
			return response()->json(['status'=>$authData->status, 'data'=>$allDt]);*/
		}
		else if($authData->status == -1)
		{
			return response()->json(['status' => -1, 'message'=>'Your logged in session has expired. You have been logged out. Please log in again']);
		}
		else
        {
            return response()->json(['status' => 0, 'data' => []]);
        }
		
	}



}
