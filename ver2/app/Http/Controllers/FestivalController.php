<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;

class FestivalController extends Controller
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

    public function purchaseNewCard()
	{
		$input = \Input::all();
		$cardPan = $input['card_pan'];
		$cvv = $input['cvv'];
		$exp = $input['exp'];
		$amount = $input['amount'];
		$mobilenumber = $input['mobilenumber'];
		$user_id = $input['user_id'];
		
		$dataReq = new \App\Models\DataRequest();
		$dataReq->request = json_encode($input);
		$dataReq->user_id = $input['user_id'];
		$dataReq->type = 'NEW CARD';
		$dataReq->save();
		
		if(isset($input['card_pan']) && strlen($input['card_pan'])>0 &&
            isset($input['exp']) && strlen($input['exp'])>0 &&
            isset($input['cvv']) && strlen($input['cvv'])>0 &&
            isset($input['amount']) && strlen($input['amount'])>0 &&
            isset($input['mobilenumber']) && strlen($input['mobilenumber'])>0 &&
            isset($input['user_id']) && strlen($input['user_id'])>0 && 
            isset($input['firstname']) && strlen($input['firstname'])>0 &&
            isset($input['lastname']) && strlen($input['lastname'])>0) {
            

            if($input['user_id']>0)
            {
                $jsonData1 = array(
    				'pan' => $input['card_pan'],
                    'cvv' => $input['cvv'],
                    'expiryDate' => $input['exp'],
                    'mobilenumber' => $input['mobilenumber'],
                    'amount' => floatval($input['amount']),
                    'mobilenumber' => $input['mobilenumber'],
                    'user_id' => $input['user_id'],
                    'merchantCode' => "RIPHHJI8VR",
                    'deviceCode' => "NGSVT63G",
                    'firstname' => (isset($input['firstname']) ? $input['firstname'] : ""),
                    'lastname' => (isset($input['lastname']) ? $input['lastname'] : ""),
                    'othername' => (isset($input['othername']) ? $input['othername'] : ""));
    				
                $jsonData = \Crypt::encrypt(json_encode($jsonData1));
    
                $jsonDataLump = array('txnDetail' => $jsonData);
                $jsonEncode = json_encode($jsonDataLump);
                //dd($jsonEncode);
                $base64 = base64_encode($jsonEncode);
                $dataForServer = array('transactionObject' => $base64,
                    'bankcode' => substr($input['card_pan'], 0, 3), 'txnData'=>json_encode($jsonData1));
                    //dd($dataForServer);
    
                $result = handleSOAPCalls('activateNewCard', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/VendorServices?wsdl', $dataForServer);
    
    			
    
                if (isset($result->status) && $result->status == 110) {
	                $dataReq->status = 1;
	                $dataReq->save();
	                
	                
    				$accts['status'] = 1;
    				$accts['message'] = $result->message;
    
                    $msg = "Card Assigned Successfully\n\nThank You.";
                    $sms_msg = "Hello".(isset($input['firstname']) ? " ".($input['firstname']) : "")."\nYour new ProbasePay card has been activated and funded with K".floatval($input['amount']).". Welcome to ProbasePay.";
                    $rec = $result->mobileNo;
                    festival_send_sms($rec, $sms_msg);
                    //send_sms($otpRec, $msg);
    
    				
                    return response()->json($accts);
                } else {
                    //dd($result);
                    if (isset($result))
					{
					    $dataReq->responseFromServer = json_encode($result);
					}
	                $dataReq->status = 0;
	                $dataReq->save();
	                
    				$accts['status'] = 0;
    				$accts['message'] = $result->status."".$result->message;
                    return response()->json($accts);
                }
            }
            else
            {
                if (isset($result))
				{
				    $dataReq->responseFromServer = json_encode($result);
				}
                $dataReq->status = 3;
                $dataReq->save();
	                
	                
                $accts['status'] = 3;
    			$accts['message'] = 'Invalid user action. Ensure you are logged in before carrying out this action';
                return response()->json($accts);
            }
        }else{
            
            $dataReq->status = 2;
            $dataReq->save();
	                
	                
			$accts['status'] = 2;
			$accts['message'] = 'Incomplete input parameters provided';
            return response()->json($accts);
        }
		
	}
	
	
	
	public function fundCard()
	{
		$input = \Input::all();
		$cardPan = $input['card_pan'];
		$cvv = $input['cvv'];
		$exp = $input['exp'];
		$amount = $input['amount'];
		$user_id = $input['user_id'];
		
		$dataReq = new \App\Models\DataRequest();
		$dataReq->request = json_encode($input);
		$dataReq->user_id = $input['user_id'];
		$dataReq->type = 'FUND CARD';
		$dataReq->save();
		
		if(isset($input['card_pan']) && strlen($input['card_pan'])>0 &&
            isset($input['exp']) && strlen($input['exp'])>0 &&
            isset($input['cvv']) && strlen($input['cvv'])>0 &&
            isset($input['amount']) && strlen($input['amount'])>0 &&
            isset($input['user_id']) && strlen($input['user_id'])>0) {
            


            if($input['user_id']>0)
            {
                $jsonData1 = array('pan' => $input['card_pan'],
                    'cvv' => $input['cvv'],
                    'expiryDate' => $input['exp'],
                    'user_id' => $input['user_id'],
                    'merchantCode' => "RIPHHJI8VR",
                    'deviceCode' => "NGSVT63G",
                    'orderId' => strtoupper(str_random(8)),
                    'amount' => floatval($input['amount']));
    				
                $jsonData = \Crypt::encrypt(json_encode($jsonData1));
    
                $jsonDataLump = array('txnDetail' => $jsonData);
                $jsonEncode = json_encode($jsonDataLump);
                //dd($jsonEncode);
                $base64 = base64_encode($jsonEncode);
                $dataForServer = array('transactionObject' => $base64,
                    'bankcode' => substr($input['card_pan'], 0, 3), 'txnData'=>json_encode($jsonData1));
                    
                //dd($dataForServer);
    
                $result = handleSOAPCalls('fundCardUsingClosedLoop', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/VendorServices?wsdl', $dataForServer);
    
    
                if (isset($result->status) && $result->status == 110) {
                    
                    $dataReq->responseFromServer = json_encode($result);
		            $dataReq->status = 1;
		            $dataReq->save();
		            
    				$accts['status'] = 1;
    				$accts['message'] = $result->message;
    
                    $msg = "Card Assigned Successfully\n\nThank You.";
                    $sms_msg = "Your ProbasePay Card - ".(isset($input['card_pan']) ? " ".($input['card_pan']) : "")." has been funded with K".floatval($input['amount']).". Your new card balance is K".$result->newBalance.".";
                    $rec = $result->mobileNo;
                    festival_send_sms($rec, $sms_msg);
                    //send_sms($otpRec, $msg);
    
    				
                    return response()->json($accts);
                } else {
                    //dd($result);
                    if (isset($result->status))
					{
					    $dataReq->responseFromServer = json_encode($result);
					}
	                $dataReq->status = 0;
	                $dataReq->save();
		                
    				$accts['status'] = 0;
    				$accts['message'] = isset($result->message) ? $result->message : "".("".$result->message);
                    return response()->json($accts);
                }
            }
            else
            {
                
                $dataReq->status = 3;
                $dataReq->save();
		                
                $accts['status'] = 3;
    			$accts['message'] = 'Invalid user action. Ensure you are logged in before carrying out this action';
                return response()->json($accts);
            }
        }else{
            $dataReq->status = 2;
            $dataReq->save();
            
            
			$accts['status'] = 2;
			$accts['message'] = 'Incomplete input parameters provided';
            return response()->json($accts);
        }
		
	}
	
	
	
	public function getCardBalance()
	{
		$input = \Input::all();
		$cardPan = $input['card_pan'];
		$cvv = $input['cvv'];
		$exp = $input['exp'];
		
		$dataReq = new \App\Models\DataRequest();
		$dataReq->request = json_encode($input);
		$dataReq->type = 'FUND CARD';
		$dataReq->save();
		
		if(isset($input['card_pan']) && strlen($input['card_pan'])>0 &&
            isset($input['exp']) && strlen($input['exp'])>0 &&
            isset($input['cvv']) && strlen($input['cvv'])>0) {
            
            $jsonData1 = array('pan' => $input['card_pan'],
                'cvv' => $input['cvv'],
                'expiryDate' => $input['exp'],
                'merchantCode' => "RIPHHJI8VR",
                'deviceCode' => "NGSVT63G");
				
            $jsonData = \Crypt::encrypt(json_encode($jsonData1));

            $jsonDataLump = array('txnDetail' => $jsonData);
            $jsonEncode = json_encode($jsonDataLump);
            //dd($jsonEncode);
            $base64 = base64_encode($jsonEncode);
            $dataForServer = array('transactionObject' => $base64,
                'bankcode' => substr($input['card_pan'], 0, 3), 'txnData'=>json_encode($jsonData1));
                
            //dd($dataForServer);

            $result = handleSOAPCalls('cardBalance', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/CardServices?wsdl', $dataForServer);
            

            if (isset($result->status) && $result->status == 6000) {
                
                $dataReq->responseFromServer = json_encode($result);
	            $dataReq->status = 1;
	            $dataReq->save();
	            
				$accts['status'] = 1;
				$accts['message'] = "Card Balance for #".$result->pan." is K".$result->balance_amount;
				$accts['data'] = $result->balance_amount;


				
                return response()->json($accts);
            } else {
                //dd($result);
                if (isset($result->status))
				{
				    $dataReq->responseFromServer = json_encode($result);
				}
                $dataReq->status = 0;
                $dataReq->save();
	                
				$accts['status'] = 0;
				$accts['message'] = isset($result->message) ? $result->message : "".("".$result->message);
                return response()->json($accts);
            }
            
        }else{
            $dataReq->status = 2;
            $dataReq->save();
            
            
			$accts['status'] = 2;
			$accts['message'] = 'Incomplete input parameters provided';
            return response()->json($accts);
        }
		
	}
	
	
	
	public function purchaseItems()
	{
		
		$input = \Input::all();
		$cardPan = $input['card_pan'];
		$cvv = $input['cvv'];
		$exp = $input['exp'];
		//$amount = $input['amount'];
		$qtyData = $input['qtyData'];
		$user_id = $input['user_id'];
		
		$dataReq = new \App\Models\DataRequest();
		$dataReq->request = json_encode($input);
		$dataReq->user_id = $input['user_id'];
		$dataReq->type = 'DEBIT CARD';
		$dataReq->save();
		
		
		if(isset($input['card_pan']) && strlen($input['card_pan'])>0 &&
            isset($input['exp']) && strlen($input['exp'])>0 &&
            isset($input['cvv']) && strlen($input['cvv'])>0 &&
            isset($input['qtyData']) && strlen($input['qtyData'])>0 &&
            isset($input['user_id']) && strlen($input['user_id'])>0) {
            
            //echo "<pre>";
            //print_r($input['qtyData']);
            //echo "</pre>";
            
            if($input['user_id']>0)
            {
    			$items = \DB::table('items')->lists('item_price', 'keyword');
    			$qtyData = json_decode($qtyData);
    			$subtotal = 0;
    			$txnRef = strtoupper(str_random(8));
    			$yes = false;
    			$itemPurchasedArray = [];
    			
    			foreach($qtyData as $key => $val)
    			{
    			    
    				$qty = $qtyData->$key;
    				//echo $key."===".($qty)."<br>";
    				if($qty>0)
    				{
    					$total = $qty * $items[$key];
    					$subtotal = $subtotal + $total;
    					$itemPurchased = new \App\Models\ItemPurchased();
    					$itemPurchased->item_key = $key;
    					$itemPurchased->quantity = $qty;
    					$itemPurchased->sellerId = $user_id;
    					$itemPurchased->cardPan = $cardPan;
    					$itemPurchased->totalAmount = $total;
    					$itemPurchased->orderId = $txnRef;
    					$itemPurchased->status = 'Pending';
    					$itemPurchased->save();
    					array_push($itemPurchasedArray, $itemPurchased);
    					$yes = true;
    				}
    			}
    			//dd(11);
    			
    			if($yes==true)
    			{
    				$transaction = new \App\Models\Transaction();
    				$transaction->amount = $subtotal;
    				$transaction->payment_type = 'Card';
    				$transaction->orderId = $txnRef;
    				$transaction->sellerUserId = $user_id;
    				$transaction->status = 'Pending';
    				$transaction->save();
    				
    				$jsonData1 = array('pan' => $input['card_pan'],
    					'cvv' => $input['cvv'],
    					'expiryDate' => $input['exp'],
    					'user_id' => $input['user_id'],
    					'orderId' => $txnRef,
    					'merchantCode' => "RIPHHJI8VR",
    					'deviceCode' => "NGSVT63G",
    					'amount' => floatval($subtotal));
    				
    					
    				$jsonData = \Crypt::encrypt(json_encode($jsonData1));
    
    				$jsonDataLump = array('txnDetail' => $jsonData);
    				$jsonEncode = json_encode($jsonDataLump);
    				//dd($jsonEncode);
    				$base64 = base64_encode($jsonEncode);
    				$dataForServer = array('transactionObject' => $base64,
    					'bankcode' => substr($input['card_pan'], 0, 3), 'txnData'=>json_encode($jsonData1));
    		        //dd($dataForServer);
    
    				$result = handleSOAPCalls('debitCardUsingClosedLoop', 'http://' . getServiceBaseURL() . '/ProbasePayEngine/services/VendorServices?wsdl', $dataForServer);
    				//dd($result);
    				
    
    
    				if (isset($result->status) && $result->status == "00") {
    				
    				
    				    $dataReq->responseFromServer = json_encode($result);
		                $dataReq->status = 1;
		                $dataReq->save();
		            
		            
		            
    					$transaction->status = 'Success';
    					$transaction->save();
    					
    					foreach($itemPurchasedArray as $itemPurchased)
    					{
    						$itemPurchased->status = 'Success';
    						$itemPurchased->save();
    					}
    					
    					$accts['status'] = 1;
    					$accts['message'] = $result->message;
    					$accts['orderId'] = $result->orderId;
    					$accts['txnRef'] = $result->txnRef;
    					$accts['balance'] = $result->balance;
    					$accts['amount'] = $result->amount;
    
    					$msg = "Card Debited Successfully\n\nThank You.";
    					$sms_msg = "DEBIT ALERT\nCard - ".(isset($input['card_pan']) ? " ".($input['card_pan']) : "")." debited K".floatval($subtotal).". Your new card balance is K".$result->balance.".";
                        $rec = $result->mobileNo;
                        festival_send_sms($rec, $sms_msg);
    					//send_sms($otpRec, $msg);
    
    					
    					return response()->json($accts);
    				} else {
    					//dd($result);
    					if (isset($result->status))
    					{
    					    $dataReq->responseFromServer = json_encode($result);
    					}
		                $dataReq->status = 0;
		                $dataReq->save();
		                
    					$transaction->status = 'Failed';
    					$transaction->save();
    					
    					foreach($itemPurchasedArray as $itemPurchased)
    					{
    						$itemPurchased->status = 'Failed';
    						$itemPurchased->save();
    					}
    					$accts['status'] = 0;
    					$accts['message'] = $result->message;
    					return response()->json($accts);
    				}
    			}
    			else
    			{
	                $dataReq->status = -1;
	                $dataReq->save();
		                
    				$accts['status'] = -1;
    				$accts['message'] = "Invalid Items provided for purchase";
    				return response()->json($accts);
    			}
            }
            else
            {
                $dataReq->status = 3;
                $dataReq->save();
		                
                $accts['status'] = 3;
    			$accts['message'] = 'Invalid user action. Ensure you are logged in before carrying out this action';
                return response()->json($accts);
            }


            
        }else{
            $dataReq->status = 2;
            $dataReq->save();
                
                
			$accts['status'] = 2;
			$accts['message'] = 'Incomplete input parameters provided';
            return response()->json($accts);
        }
		
	}
	
	
	
	
	
	public function uploadCustomerData()
	{
		$input = \Input::all();
		
		$dataReq = new \App\Models\DataRequest();
		$dataReq->request = json_encode($input);
		$dataReq->user_id = $input['user_id'];
		$dataReq->type = 'STANBIC EXCEPTION';
		$dataReq->save();
		
		 $rules = ['user_id' => 'required|numeric', 
		'file_path' => 'required', 'file_path' => 'required', 'customer_mobile'=>'required' ];
		
        $messages = [
                'user_id.required' => 'Invalid User attempting to upload data. Please logout and log in back', 
                'user_id.numeric' => 'Invalid User attempting to upload data. Please logout and log in back', 
                'file_path.required' => 'No Receipt Image captured. Ensure you capture an image of the receipt before uploading customer data to the server', 
                'customer_mobile.required' => 'Customer\'s phone number needs to be provided. Provide customers phone number in the customer field'
            ];
        $validator = \Validator::make($input, $rules, $messages);
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
            $accts['status'] = 2;
    		$accts['message'] = $str_error;
            return response()->json($accts);
        }
        
        $file_data = $input['file_path'];
		$customer_name = $input['customer_name'];
		$customer_mobile = $input['customer_mobile'];
		$user_id = $input['user_id'];
        
        $mob = null;
        
		if(substr($customer_mobile, 0, 3) == "260")
        {
	        $mob= strlen(substr($customer_mobile, 2))==10 ? substr($customer_mobile, 2) : null;
        }
        else if(substr($customer_mobile, 0, 2)=="09")
        {
            $mob = strlen($customer_mobile)==10 ? $customer_mobile : null;
        }
            
        if($mob==null)
        {
           return response()->json(['status'=>2, 'message'=>'Mobile number provided does not seem to be a valid Zambian mobile number']);
        }
        
        try
        {
            $customer_mobile = "26".$mob;
            
            $stanbicUser = \App\Models\StanbicPromoUsers::where('customer_mobile', '=', $customer_mobile);
            $count = $stanbicUser->count();
            $imageFileName = $customer_mobile."_".$count;
            
            
            
    		
    		
    		$stanbicUser = new \App\Models\StanbicPromoUsers();
    		$stanbicUser->logged_by_user_id = $user_id;
            $stanbicUser->customer_mobile = $customer_mobile;
            $stanbicUser->customer_name = $customer_name;
            $stanbicUser->status = 'Uploaded';
            $stanbicUser->file_data = $file_data;
            $stanbicUser->identity_id = $count;
            $stanbicUser->save();
            
            
    		
    		
    		
    		
    		$imagePath = "images/".$imageFileName.".png";
    		//file_put_contents($imagePath,base64_decode($file_data));
    		$binary=base64_decode($file_data);
    		header('Content-Type: bitmap; charset=utf-8');
    		$file = fopen($imagePath, 'wb');
    		fwrite($file, $binary);
    		fclose($file);
    		
    		
    		$msg = "Hello +".$customer_mobile.",\nYou have been added to the pool the Stanbic Swip Promotion pool. Keep swiping to increase your chances of winning. Visit goo.gl/fv9ot9 for more details.";
            festival_send_sms($customer_mobile, $msg, "STANBIC");
        }
        catch(\Exception $e)
        {
            $dataReq = new \App\Models\DataRequest();
            $dataReq->request = json_encode($input);
    		$dataReq->user_id = $input['user_id'];
    		$dataReq->type = 'STANBIC EXCEPTION';
    		$dataReq->response_from_server = $e->getMessage();
    		$dataReq->save();
    		
            $accts['status'] = 2;
    		$accts['message'] = 'Customer receipt could not be uploaded successfully. Please try again ';
            return response()->json($accts);
        }

		
		$accts['status'] = 1;
		$accts['message'] = 'Customer receipt uploaded successfully.';
        return response()->json($accts);
		
	}
	
	
	public function viewReceipts()
	{
	    $stanbicUsers = \DB::table('stanbic_promo_users')->join('users', 'stanbic_promo_users.logged_by_user_id', '=', 'users.id')->select('logged_by_user_id', 'customer_mobile', 'customer_name', 'receipt_no', 'status', 'identity_id', 'stanbic_promo_users.id', 'name', 'users.username')->get();
	    
	    return view('core.guest.stanbic_promo_users', compact('stanbicUsers'));
	}
	
	
	public function updateReceipt($id)
	{
	    $stanbicPromoUser = \App\Models\StanbicPromoUsers::where('id', '=', $id)->first();
	    $key = 'receipt_no_'.$id;
	    $stanbicPromoUser->receipt_no = \Input::get($key);
	    $stanbicPromoUser->save();
	    
	    return \Redirect::back()->with('message', 'Receiept number updated successfully');
	}
}

