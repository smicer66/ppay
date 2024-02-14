<?php
use phpseclib\Crypt\RSA;

/**
 * Generate Primary Key for inserting values
 * @return string
 */

define("FEE_PAYMENT_CATEGORY", 3);
define("APPLICANT_PAYMENT_CATEGORY", 2);
define("SUBSCRIPTION_PAYMENT_CATEGORY", 1);
define ('HMAC_SHA256', 'sha256');
define("PAYMENT_DETAILS_NEW_BEVURA", "0000");
define("PAYMENT_DETAILS_LISTING", "0001");
define("CARD_COLLECTION_VIEW", "0002");
define("OTP_COLLECTION_VIEW", "0003");
define("PAYMENT_ERROR_VIEW", "0004");
define("WALLET_OTP_COLLECTION_VIEW", "005");
define("WALLET_BILL_VIEW", "006");
define("PAY_FROM_LOGGED_IN_WALLET", "007");
define("PAY_FROM_LOGGED_IN_WALLET_OTP", "008");
define("PAY_FROM_LOGGED_IN_ACCOUNT_OTP", "0081");
define("PAY_FROM_LOGGED_IN_WALLET_SUCCESS_PAGE", "009");
define("PAY_FROM_LOGGED_IN_WALLET_FAIL_PAGE", "010");
define("PAY_FROM_LOGGED_IN_WALLET_TRANSFER_FUNDS_SUCCESS", "103");
define("FUND_CARD_FROM_WALLET_VIEW", "011");
define("CYBERSOURCE_PAYMENT_DETAILS_LISTING", "2001");
define("CYBERSOURCE_PAYMENT_INITIALIZE", "201");
define("CYBERSOURCE_PAYMENT_FAILED", "202");
define("PAYMENT_OPTIONS_LISTING", "203");
define("PAYMENT_DETAILS_ONLINE_BANKING_SELECT_VIEW", "204");
define("ZICB_ACQUIRER_CODE", "001");
define("WALLET_ACCESS", "040");
define("TOKENIZE", "050");
define("TOKENIZE_OTP", "051");
define("TOKENIZATION_SUCCESS_PAGE", "052");
define("TOKENIZATION_FAIL_PAGE", "053");



define("CYBERSOURCE_PROFILE_ID", 'E00109B5-665F-4696-A37D-96FAA1C718E5');
define("CYBERSOURCE_ACCESS_KEY", 'ec5891c2e1513fc5a62054abca70593f');
define("PROBASEWALLET_MERCHANT_CODE", "KWAD6L3DWL");
define("PROBASEWALLET_DEVICE_CODE", "OTA84AD9");
//define("PROBASEKEY", "PROBASE");
define("PROBASEKEY", "7k3PNoGyagCRDR3oReoufiNzj0SWXnN2");
//define("DEMO_CYBERSOURCE_PROFILE_ID", 'E25266EE-4CC1-4023-8FFD-441BA1FA41A1');
//define("DEMO_CYBERSOURCE_ACCESS_KEY", 'e7834645737f370393cabf45d8485820');
define("BEVURA_DEVICE_CODE", "BGAGQ0IK");
define("BEVURA_MERCHANT_CODE", "KWAD6L3DWL");


define("ZRLDEVICECODE", "GV4L8WPU");
define("ZRLMERCHANTCODE", "MWCYY2RBNX");

function primary_key()
{
    $t = microtime(true);
    $micro = sprintf("%06d", ($t - floor($t)) * 1000000);
    $d = new DateTime(date('Y-m-d H:i:s.' . $micro, $t));
    return $d->format("YmdHisu");
}

function signData($data, $secretKey) {
	return base64_encode(hash_hmac('sha256', $data, $secretKey, true));
}

function buildDataToSign($params) {
	$signedFieldNames = explode(",",$params["signed_field_names"]);
	foreach ($signedFieldNames as &$field) {
		$dataToSign[] = $field . "=" . $params[$field];
	}
	return commaSeparate($dataToSign);
}

function commaSeparate ($dataToSign) {
	return implode(",",$dataToSign);
}

function getAllTransactionStatus(){
    return [
        'PENDING' => 'PENDING',
        'SUCCESS' => 'SUCCESS',
        'FAIL' => 'FAIL',
        'REVERSED' => 'REVERSED',
        'PAIDOUT' => 'PAIDOUT',
        'CUSTOMER_CANCELED' => 'CUSTOMER_CANCELED'
    ];
}


function get_random_do_you_know()
{
	$array = [
		"Did you know 11% of people are left handed",
		"Did you know August has the highest percentage of births",
		"Did you know unless food is mixed with saliva you can't taste it",
		"Did you know the average person falls asleep in 7 minutes",
		"Did you know a bear has 42 teeth",
		"Did you know an ostrich's eye is bigger than its brain",
		"Did you know lemons contain more sugar than strawberries",
		"Did you know 8% of people have an extra rib",
		"Did you know 85% of plant life is found in the ocean",
		"Did you know Ralph Lauren's original name was Ralph Lifshitz",
		"Did you know rabbits like licorice",
		"Did you know the Hawaiian alphabet has 13 letters",
		"Did you know 'Topolino' is the name for Mickey Mouse Italy",
		"Did you know a lobsters blood is colorless but when exposed to oxygen it turns blue",
		"Did you know armadillos have 4 babies at a time and are all the same sex",
		"Did you know reindeer like bananas",
		"Did you know the longest recorded flight of a chicken was 13 seconds",
		"Did you know birds need gravity to swallow",
		"Did you know the most commonly used letter in the alphabet is E",
		"Did you know the 3 most common languages in the world are Mandarin Chinese, Spanish and English",
		"Did you know dreamt is the only word that ends in mt",
		"Did you know the first letters of the months July through to November spell JASON",
		"Did you know a cat has 32 muscles in each ear",
		"Did you know Perth is Australia's windiest city",
		"Did you know Elvis's middle name was Aron",
		"Did you know goldfish can see both infrared and ultraviolet light",
		"Did you know the smallest bones in the human body are found in your ear",
		"Did you know cats spend 66% of their life asleep",
		"Did you know Switzerland eats the most chocolate equating to 10 kilos per person per year",
		"Did you know money is the number one thing that couples argue about",
		"Did you know macadamia nuts are toxic to dogs",
		"Did you know when lightning strikes it can reach up to 30,000 degrees celsius (54,000 degrees fahrenheit)",
		"Did you know spiders are arachnids and not insects",
		"Did you know each time you see a full moon you always see the same side",
		"Did you know stewardesses is the longest word that is typed with only the left hand",
		"Did you know honey is the only natural food which never spoils",
		"Did you know M&M's chocolate stands for the initials for its inventors Mars and Murrie",
		"Did you know that you burn more calories eating celery than it contains (the more you eat the thinner you become)",
		"Did you know the only continent with no active volcanoes is Australia",
		"Did you know the longest street in the world is Yonge street in Toronto Canada measuring 1,896 km (1,178 miles)",
		"Did you know about 90% of the worlds population kisses",
		"Did you know Coca-Cola originally contained cocaine",
		"Did you know the Internet was originally called ARPANet (Advanced Research Projects Agency Network) designed by the US department of defense",
		"Did you know toilets use 35% of indoor water use",
		"Did you know the fortune cookie was invented in San Francisco",
		"Did you know Koalas sleep around 18 hours a day",
		"Did you know the first Burger King was opened in Florida Miami in 1954",
		"Did you know all insects have 6 legs",
		"Did you know the croissant was invented in Austria",
		"Did you know In eastern Africa you can buy beer brewed from bananas",
		"Did you know African Grey Parrots have vocabularies of over 200 words",
		"Did you know a giraffe can clean its ears with its 21 inch tongue",
		"Did you know Australia was originally called New Holland",
		"Did you know 'Lonely Planet' for travelers is based in Melbourne Australia",
		"Did you know the sentence 'the quick brown fox jumps over the lazy dog' uses every letter in the English alphabet",
		"Did you know the Grand Canyon can hold around 900 trillion footballs",
		"Did you know all the blinking in one day equates to having your eyes closed for 30 minutes",
		"Did you know your foot has 26 bones in it",
		"Did you know the average human brain contains around 78% water",
		"Did you know 1 nautical knot equates to 1.852 Kph (1.150 mph)",
	];
	return $array[rand(0, (sizeof($array) - 1))];
}




function get_delivery_status()
{
	return [null=> '-Select One-', '0' => 'Fail', '1' => 'Success' ];
}


function send_sms($mobile, $msg, $sender=NULL)
{
	return true;
	$xml = null;
	//$mobile="260967307151";//Kachi
	//$mobile="260968499817";//Andrea
	//$mobile = "260979041293";
	//$msg = urlencode($msg);
	//dd($mobile);
	$url = "http://smsapi.probasesms.com/apis/text/index.php?username=testclient&password=password&mobiles=".
			$mobile."&message=".$msg."&sender=".($sender==NULL ? 'ProbasePAY' : $sender)."&type=TEXT";
	//dd($url);
	//dd($mobile);
	if(!((strpos($mobile, '260')==0 && strlen($mobile)==12) || (strpos($mobile, '+260')==0 && strlen($mobile)==13) || (strpos($mobile, '0')==0 && strlen($mobile)==10)))
	{

		//return \Redirect::back()->with('error', 'Invalid mobile number provided. Your mobile number is not a valid Zambian mobile number');
	}
	else
	{
		if(strpos($mobile, '+260')==0 && strlen($mobile)==13)
		{
			$mobile = substr($mobile, 1);
		}
		else if(strpos($mobile, '0')==0 && strlen($mobile)==10)
		{
			$mobile = '26'.$mobile;
		}
	}

	try{
		$getdata = http_build_query(
			array(
				'username' => 'smspbs@123$$',
				'password' => 'pbs@sms123$$',
				'mobiles'=> $mobile,
				'message'=> $msg,
				'sender'=>  'Bevura',
				'type' => 'TEXT'
			)
		);



		$url = "https://probasesms.com/text/multi/res/trns/sms?".$getdata;
		//dd($url);
		//$responseSms = file_get_contents($url);
		$responseSms = "";
		$body = (trim(preg_replace('/\s+/', ' ', $responseSms)));
        //dd($body);



		$xml = new \SimpleXMLElement($body);
		$str_ = "";
		if(isset($xml->error))
		{
		    $str = ($xml->error);
		    $str_=($str);
		}
		else
		{
		    $str = ($xml->response[0]->messagestatus);
		    $str_=($str);
		}
		//dd($str_[0]);
		$smsLog = new \App\Models\SmsLog();
		$smsLog->id = primary_key();
		$smsLog->receipient_no = $mobile;
		$smsLog->response = $body;
		$smsLog->message = $msg;
		if($str_=='SUCCESS')
		{
			$smsLog->success = 1;
		}else
		{
			$smsLog->success = 0;
		}
		$smsLog->save();
	}catch(\Exception $e)
	{
	    //dd($e);
	    $smsLog = new \App\Models\SmsLog();
		$smsLog->id = primary_key();
		$smsLog->receipient_no = $mobile;
		$smsLog->response = $body;
		$smsLog->message = $msg;
		$smsLog->success = 0;
		$smsLog->save();
	}


	return true;
}




function festival_send_sms($mobile, $msg, $sender=NULL)
{
	return send_sms($mobile, $msg, NULL);
	/*$xml = null;
	//$mobile="260964804133";//Kachi
	//$mobile="260968499817";//Andrea
	//$mobile="260974365365";//Roy
	//dd($mobile);
	$msg = urlencode($msg);
	$url = "http://smsapi.probasesms.com/apis/text/index.php?username=demo&password=password&mobiles=".
			$mobile."&message=".$msg."&sender=".($sender==NULL ? 'STANBIC' : $sender)."&type=TEXT";

	$_h = curl_init();
	curl_setopt($_h, CURLOPT_HEADER, 1);
	curl_setopt($_h, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($_h, CURLOPT_HTTPGET, 1);
	curl_setopt($_h, CURLOPT_URL, $url );
	curl_setopt($_h, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
	curl_setopt($_h, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
	$ty = curl_exec($_h);
	try{
		$header_size = curl_getinfo($_h, CURLINFO_HEADER_SIZE);
		$header = substr($ty, 0, $header_size);
		$body = substr($ty, $header_size);

		curl_close($_h);
		$body = (trim(preg_replace('/\s+/', ' ', $body)));



		$xml = new \SimpleXMLElement($body);
		//print_r($xml);
		$str = ($xml->response[0]->messagestatus);
		$str_=($str);

		$smsLog = new \App\Models\SmsLog();
		$smsLog->id = primary_key();
		$smsLog->receipient_no = $mobile;
		$smsLog->response = $body;
		$smsLog->message = $msg;
		if($str_=='SUCCESS')
		{
			$smsLog->success = 1;
		}else
		{
			$smsLog->success = 0;
		}
		$smsLog->save();
	}
	catch(\Exception $e)
	{

		$smsLog = new \App\Models\SmsLog();
		$smsLog->id = primary_key();
		$smsLog->receipient_no = $mobile;
		$smsLog->response = $body;
		$smsLog->message = $msg;
		$smsLog->success = 0;
		$smsLog->save();
	}
//			echo ($xml->error[0]);
	if(($xml!=NULL && $xml->error[0]) != 'SUCCESS')
	{
		return false;
	}
	return true;*/
}



function calculateDateDiff($startDate, $endDate, $format)
{
	$dob = explode(' ', $startDate)[0];
	$strtotime = strtotime($dob);
	$dobs = explode('-', (date('Y-n-j', $strtotime)));

	$cd = \Carbon\Carbon::createFromDate($dobs[0], $dobs[2], $dobs[1]);
	return $cd->diff($endDate)->format($format);
}

function write_file($text, $destination = '/tmp/text.txt')
{

}

function deleteDir($dirPath)
{
	$dirPath_ = $dirPath;
	if (file_exists($dirPath)) {

		if (substr($dirPath, strlen($dirPath) - 1, 1) != DIRECTORY_SEPARATOR) {
			$dirPath_ .= DIRECTORY_SEPARATOR;
		}
		$files = glob($dirPath_ . '*', GLOB_MARK);

		foreach ($files as $file) {
			if (is_dir($file)) {
				deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
		return true;
	}
	return false;
}

function read_file($file)
{

}

function get_month()
{
    $str = "January::February::March::April::May::June::July::August::September::October::November::December";
    return explode('::', $str);
}

function encrypt_($key)
{
    return \Crypt::encrypt($key);
}

function decrypt_($string)
{
    return \Crypt::decrypt($string);
}


function encrypt_msg_rsa($msg, $key)
{
    $rsa = new RSA();
    $rsa->loadKey($key);
    $ciphertext = $rsa->encrypt($msg);
    return base64_encode($ciphertext);
}

function decrypt_msg_rsa($ciphertext, $key)
{
    $rsa = new RSA();
    $rsa->loadKey($key);
    $ciphertext = base64_decode($ciphertext);
    $msg = $rsa->decrypt($ciphertext);
    return $msg;
}


function colorBands()
{
    return ['e0ffc2', 'ffe8a8', 'c4e2ff', 'ffe3e0', 'ffd6fd'];
}

function user_agent()
{
    return $_SERVER['HTTP_USER_AGENT'];
}

function ip_address()
{
    return $_SERVER['HTTP_HOST']; //change this later
}

function apply_discount($amt, $percentage)
{
    return $amt - ($amt / 100 * $percentage);
}

function send_mail($view, $to, $recipientName, $subject, $data = array())
{
	//$to = $to;


	try{

		$beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
		$beautymail->send($view, $data, function($message) use($to, $subject)
		{

			$from = 'no-reply@probasepay.com';
			$message
					->from($from)
					->to($to, $to)
					->subject($subject);
		});
	}catch(\Exception $e)
	{
	}
}

function u_logout()
{
    if(\Auth::user())
    {
        \Auth::logout();
        sleep(4);
        \Auth::logout();
	\Session::flush();
    }
}

/*
 * This not the real implementation. later
 */
function is_url($str)
{
    return $str == null ? false : true;
}

function format_naira($money, $format = true, $currency = true)
{
    return ($format) ? ($currency ? "ZMW" : "") . number_format($money, 2) : ($currency ? "ZMW " : "") . $money;
}

function generate_trans_ref($val = 9)
{
    return str_random($val);
}


function handlePostSchoolFeePayment($input, $school)
{
	$decision = $input['decision'];
	$reason_code = $input['reason_code'];
	$transaction_id = $input['transaction_id'];
	$req_transaction_uuid = $input['req_transaction_uuid'];
	$req_access_key = $input['req_access_key'];
	$auth_trans_ref_no = $input['auth_trans_ref_no'];
	$signature = $input['signature'];
	$req_card_number = $input['req_card_number'];
	$req_reference_number = $input['req_reference_number'];
	$req_merchant_defined_data1 = $input['req_merchant_defined_data1'];
	$req_amount = $input['req_amount'];

	if($decision!=NULL && $reason_code!=NULL && $transaction_id!=NULL && $req_transaction_uuid!=NULL
			&& $req_access_key!=NULL && $auth_trans_ref_no!=NULL && $signature!=NULL
			&& $decision == "ACCEPT" && $reason_code== 100)
	{

		$paymentHistory = \App\Models\PaymentHistories::where('ref_no', '=', $req_reference_number)
				->where('transaction_id', '=', $req_transaction_uuid)->where('school_id', '=', $school->id);

		/*echo "1.".$req_reference_number."<br>";
        echo "2.".$transaction_id."<br>";
        dd($paymentHistory->first());*/

		if($paymentHistory->count()>0)
		{
			$paymentHistory = $paymentHistory->first();



			$data = Session::get('fee_save');
			$data['trans_ref'] = $paymentHistory->ref_no;
			$data = (object)$data;



			$str = \Session::get('academic_year_term');
			if ($req_amount == null || is_numeric($req_amount)!=1 || $req_amount!=$paymentHistory->amount) {
				return back()->with('error', 'Invalid transaction. Kindly request reversal of transaction');
			}
			else
			{
				//process the payment.
				$to_json = [];
				$to_json['session_term'] = Session::get('academic_year_term')->yearName . " - " . Session::get('academic_year_term')->termName;

				$fee_criteria_list = $data->fee_criteria_item;



				$to_json['fee_criterias'] = $fee_criteria_list;
				$to_json['fee_items_amount'] = $data->fee_items_amount;
				$to_json['amount_to_pay'] = $data->amount_to_pay;
				$to_json['balance'] = $data->balance;
				$to_json['student_id'] = $data->student_id;
				$to_json['payment_type'] = 'ATM';
				DB::beginTransaction();
				try {
					$student = \App\Models\Students::find($data->student_id);
					$to_json['class'] = $student->current_class->name."-".$student->current_class_arm->arm_name;
					$fees_to_json = json_encode($to_json);

					$paymentHistory->status = 'Success';
					$paymentHistory->card_no = $req_card_number;
					$paymentHistory->save();

					//load last discount to the school fee
					$discount = \App\Models\FeeDiscounts::where('student_id', $student->id)
							->where('status', 'Active')
							->orderBy('id', 'desc')
							->limit(1)
							->first();

					$last_fee_tracker = \App\Models\FeeTrackers::find($data->prev_fee_tracker_id);
					if ($last_fee_tracker == null) {
						if ($discount != null) {
							$data->amount_to_pay = apply_discount($data->amount_to_pay, $discount->discount);
						}
						$balance = $req_amount - $data->amount_to_pay;
					} else {
						if ($last_fee_tracker->class_id == $student->current_class_id && $last_fee_tracker->school_term_id == $str->school_term_id) {
							if ($last_fee_tracker->is_remaining_balance == 'Yes') {
								$balance = $req_amount - $last_fee_tracker->balance;
							} else {
								$balance = $req_amount - $last_fee_tracker->balance;
							}
						} else {
							if ($discount != null) {
								$data->amount_to_pay = apply_discount($data->amount_to_pay, $discount->discount);
							}
							if ($last_fee_tracker->is_remaining_balance == 'Yes') {
								$balance = $req_amount - $last_fee_tracker->balance - $data->amount_to_pay;
							} else {
								if ($req_amount == $data->amount_to_pay) {
									$balance = ($last_fee_tracker->balance) - $data->amount_to_pay;
								} else {
									$balance = ($req_amount + $last_fee_tracker->balance) - $data->amount_to_pay;
								}
							}
						}
					}
					if (!Input::has('school_fee_id')) {

						$fee_tracker = new \App\Models\FeeTrackers();
						$fee_tracker->id = primary_key();
						$fee_tracker->trans_log_json = $fees_to_json;
						$fee_tracker->payment_history_id = $paymentHistory->id;
						$fee_tracker->amount_to_pay = $data->amount_to_pay;
						$fee_tracker->amount_paid = $req_amount;
						$fee_tracker->class_id = $student->current_class_id;
						$fee_tracker->class_arm_id = $student->current_class__arm_id;
						$fee_tracker->school_term_id = $str->school_term_id;
						$fee_tracker->balance = abs($balance);
						if (!is_null($discount)) {
							$fee_tracker->discount_id = $discount->id;
						}
						$fee_tracker->user_id = $student->user->id;
						/*if ($this->user->role_code != Roles::$ROLE_SCHOOL_STUDENT) {
							if (\Auth::user()->role_code != \App\Models\Roles::$ROLE_SCHOOL_PARENT) {*/
						$fee_tracker->status = 'Success';
						/*} else {
							$fee_tracker->status = 'Pending';
						}
					}*/
						$fee_tracker->is_remaining_balance = $balance < 0 ? 'Yes' : 'No';
						$fee_tracker->save();
					}
					\DB::commit();
					\Session::remove('fee_save');
					return \Redirect::to('/student/payment/view-fees-receipt/'.$paymentHistory->id)->with('message', 'Payment was successful for the amount ZMW'.number_format($paymentHistory->amount, 2, '.', ',').'. Transaction ID: #'.strtoupper(join('-', str_split($paymentHistory->transaction_id, 4))));
				} catch (Exception $e) {
					//dd($e);
					DB::rollback();
					return back()->with('error', 'Your reqyest could not be processed, please try again later.')->withInput();
				}


				\Session::remove('fee_save');

			}


		}
		else
		{
			return back()->with('error', 'Invalid transaction. Kindly request reversal of transaction');
		}

	}
	else
	{
		return back()->with('error', 'Invalid transaction. Kindly request reversal of transaction');
	}
}




function generate_salt()
{
    $salt = "";
    for ($i = 0; $i < 50; $i++) {
        $salt .= chr(rand(33, 126));
    }
    return $salt;
}

function get_genders()
{
    return [null => 'Select', 'MALE' => 'Male', 'FEMALE' => 'Female'];
}

function get_card_type()
{
	return [null => 'Select One', 'Visa' => 'Visa', 'Mastercard' => 'Mastercard'];
}


function get_religions()
{
    return [null => 'Select', 'ISLAM' => 'Islam', 'CHRISTIANITY' => 'Christianity', 'OTHERS' => 'Others'];
}

function get_relationships()
{
    return [null => 'Select', 'FATHER' => 'Father', 'MOTHER' => 'Mother', 'GUARDIAN' => 'Guardian'];
}

function accomodation_types()
{
    return [null => 'Select', 'DAY' => 'Day', 'BOARDING' => 'Boarding'];
}

function get_occupations()
{
    return [null => 'Select', 'BANKER' => ucfirst('BANKER'), 'CIVIL SERVANT' => ucfirst('CIVIL SERVANT'), 'PRIVATE' => ucfirst('PRIVATE')];
}

function get_staff_types()
{
    return [null => 'Select One', 'Teaching' => ucfirst('Teaching'), 'Non Teaching' => ucfirst('Non Teaching'), 'Management' => ucfirst('Management')];
}

function get_due_date_type()
{
	return [null => 'Select One', 'Every Week' => ucfirst('Every Week'), 'Every 2 Weeks' => ucfirst('Every 2 Weeks'), 'Last Day of the Month' => ucfirst('Last Day of the Month')];
}

function get_admin_types($id=NULL)
{
    $ar = [null => 'Select One', 'HELP_DESK' => ucfirst('Help Desk'), 'SCHOOL_ACCOUNTANT' => 'School Accountant',
	'HUMAN_RESOURCE_ADMIN' => 'Human Resource Admin'];
	if(!is_null($id))
		return $ar[$id];
	else
		return $ar;
}

function get_role_types($id=NULL)
{
	$ar = [null => 'Select One', 'HELP_DESK' => ucfirst('Help Desk'), 'SCHOOL_ACCOUNTANT' => 'School Accountant',
			'HUMAN_RESOURCE_ADMIN' => 'Human Resource Admin', 'SKU_ADMIN' => 'School Administrator',
			'SKU_STAFF' => 'School Staff/Teacher', 'STUDENT' => 'Student',
			'PARENT' => 'Parent', 'HEAD_TEACHER' => 'Head Teacher'];
	if(!is_null($id))
		return $ar[$id];
	else
		return $ar;
}

function get_year_months()
{
	$ar = [null => 'Select A Month', 'January'=> 'January', 'February'=> 'February', 'March'=> 'March', 'April'=> 'April'
		, 'May'=> 'May', 'June'=> 'June', 'July'=> 'July', 'August'=> 'August'
		, 'September'=> 'September', 'October'=> 'October', 'November'=> 'November', 'December'=> 'December'];

	return $ar;
}

function get_months()
{
	$ar = [0=> 'January', 1=> 'February', 2=> 'March', 3=> 'April'
		, 4=> 'May', 5=> 'June', 6=> 'July', 7=> 'August'
		, 8=> 'September', 9=> 'October', 10=> 'November', 11=> 'December'];

	return $ar;
}


function payment_platforms()
{
    return [
        'REMITA' => ['title' => 'Remita Payment Processing', 'logo' => '/images/remita.jpg'],
//        'INTERSWITCH' => ['title' => 'Interswitch Payment Processing'],
        'GTPAY' => ['title' => 'GTPay', 'logo' => '/images/GTPay.png'],
    ];
}

/**  additional functions implemented by Kingsley Eze */
function get_class_type()
{
    return [null=> 'Select', 'NUR' => 'Nursery', 'PRI' => 'Primary','JSS' => 'Junior Secondary','SSS' => 'Senior Secondary' ];
}

function get_class_type_name()
{

    $type = ['NUR' => 'Nursery', 'PRI' => 'Primary','JSS' => 'Junior Secondary','SSS' => 'Senior Secondary' ];

    return $type;
}

function get_class_level()
{
    return [
      'NUR' => ['Level 1', 'Level 2', 'Level 3'],
        'PRI' => ['Level 1', 'Level 2', 'Level 3', 'Level 4', 'Level 5', 'Level 6'],
        'JSS' => ['Level 1', 'Level 2', 'Level 3'],
        'SSS' => ['Level 1', 'Level 2', 'Level 3']
    ];
}

function get_classFullName($arm_id){

    $class_arm = \App\Models\ClassArms::where('id','=',$arm_id)->with('class_')->first();



    return get_class_type()[$class_arm->class_->class_type].' '.$class_arm->class_->class_level.''.$class_arm->arm_name;
}


function get_banks(){

    return \App\Models\Banks::where('status','=','active')->lists('name', 'id');
}


function get_item_type()
{
	return [
		'Physical' => 'Physical',
		'Service' => 'Service'
	];
}


function getExamTypeScore($student_id, $subject_id,$examType ,$schoolId)
{
    $total = \App\Models\GradingScore::where('school_id','=', $schoolId)
                                        ->where('subject_id','=', $subject_id)
                                        ->where('student_id','=', $student_id)
                                        ->where('exam_type','=', $examType)
										->whereNull('notEditable')
                                        ->sum('score');

    if(empty($total) || $total == NULL)
    {
        $total = '-';
    }

    return $total;
}


function whatGrade($score, $compare)
{
	//dd($compare);
	foreach($compare as $com)
	{
		if($score>= $com->lowest && $score<= $com->maximum)
		{
			return $com->type;
			break;
		}
	}
}


function totalScore($student_id, $subject_id, $schoolId)
{
    $total = \App\Models\GradingScore::where('school_id','=', $schoolId)
                                        ->where('subject_id','=', $subject_id)
                                        ->where('student_id','=', $student_id)
                                        ->sum('score');

    if(empty($total) || $total == NULL)
    {
        $total = '-';
    }

    return $total;
}

function getGrade($student_id,$subject_id, $schoolId)
{
    $total = totalScore($student_id, $subject_id, $schoolId);

    if(empty($total) || $total == '-')
    {
        $total = '-';
        return $total;
    }else {

        $grades = \App\Models\GradingSchemeGrades::where('school_id', '=', $schoolId)->orderBy('type','asc')->get();

        foreach($grades as $grade)
        {
            if($grade->lowest < $total)
                return $grade->type;
            else
                continue;
        }

    }
}

function getTimeTableActivity($period_id, $day, $array)
{
    $active = '-';
	$i =0;

	if(array_key_exists($day, $array))
	{
		$day = $array[$day];
		foreach($day as $d)
		{
			if(array_key_exists($period_id, $d))
			{
				$active = $d[$period_id];
				break;
			}
		}
	}
    return $active;

}

function getPercentAttendance($school_id, $student_id, $class_id)
{
    $percent = null;

    $totalStudentAttendance = \App\Models\StudentAttendance::where('school_id','=' ,$school_id->id)
                            ->where('class_id','=', $class_id)
                            ->where('student_id','=', $student_id)
                            ->whereNull('is_absent')
                            ->count();

    $totalAttendanceClass = \App\Models\AttendanceHistories::where('school_id','=' ,$school_id->id)
                                                             ->where('class_id','=', $class_id)
                                                             ->count();
//    dd($totalAttendanceClass);
    if($totalStudentAttendance != 0 && $totalAttendanceClass !=0)
        $percent = ($totalStudentAttendance / $totalAttendanceClass) * 100;
    else
        $percent = 0;

    return $percent;
}

function getAttendanceType($school_id, $student_id, $class_id, $type)
{
    $notFound = '-';

    $totalAttendanceClass = \App\Models\AttendanceHistories::where('school_id','=' ,$school_id->id)
        ->where('class_id','=', $class_id)
        ->count();

    $totalStudentAttendance = \App\Models\StudentAttendance::where('school_id','=' ,$school_id->id)
        ->where('class_id','=', $class_id)
        ->where('student_id','=', $student_id)
        ->whereNull('is_absent')
        ->count();

    if($type == 'totalDays')
    {
        return $totalAttendanceClass;

    }elseif($type == 'presentDays'){

        return $totalStudentAttendance;

    }elseif($type == 'absentDays')
    {
        $absent = $totalAttendanceClass - $totalStudentAttendance;

        return $absent;
    }

    return $notFound;

}


function createModelObject(array $array, $model)
{
    foreach($array as $key => $value)
    {
        $model->{$key} = $value;
    }

    return $model;
}


function getResource()
{
	$url = explode('/', $_SERVER['REQUEST_URI']);
	$resource = NULL;

	if($url[1]=='pages')
	{
		$resource = \App\Models\Page::where('trait_url', '=', $url[2])->first();
	}
	return $resource;
}


function getMenu($menuCode)
{

	$menu = \App\Models\Menu::where('menu_code', '=', $menuCode)->with(['menuItems' => function($t){
		$t = $t->whereNull('parent_item_id')->with('childMenuItem');
	}])->first();
	//Return JSON format
	$mn = array();
	$mnIt = array();

	//dd($menu->menuItems);
	foreach($menu->menuItems as $menuItem)
	{

		if((\Auth::user() && !is_null($menuItem->item_auth) && $menuItem->item_auth==1)
				|| (!\Auth::user() && !is_null($menuItem->item_auth) && $menuItem->item_auth==0)
			|| (is_null($menuItem->item_auth)))
		{
			$chmit = array();
			$mnIt['title'] = $menuItem->menu_item_name;
			$mnIt['url'] = $menuItem->url;

			foreach ($menuItem->childMenuItem as $childMenuIt) {

				$chmit_1 = array();
				$chmit_1['title'] = $childMenuIt->menu_item_name;
				$chmit_1['url'] = $childMenuIt->url;

				array_push($chmit, $chmit_1);

			}
			$mnIt['child'] = $chmit;
			array_push($mn, $mnIt);
		}
	}
	return (json_encode($mn));
}


function getPage($page_trait)
{
	$page = \App\Models\Page::where('trait_url', '=', $page_trait)->where('status', '=', 'Published')->first();
	//Return JSON format
	$mn = array();
	$mn['title'] = $page->page_name;
	$mn['contents'] = $page->contents;
	return (json_encode($mn));
}




function getUtilitiesPath()
{
	$school = \App\Models\Schools::where('preferred_url', '=', $_SERVER['SERVER_NAME'])->first();
	return "/utility/".$school->id."/";
}










/****ProbasePay functions***/
function handleSOAPCalls($soapWrapper, $serviceName, $serviceMethodName, $wsdl, $data)
{
    try
    {
        $soapWrapper->add($serviceName, function ($service) use ($serviceMethodName, $wsdl) {
    		$service
    				//->name($serviceMethodName)
    				->wsdl($wsdl)
    				->trace(true)
    				->cache(WSDL_CACHE_NONE);
    	});


    	$soapReturn = null;
    	//SoapWrapper::service($serviceMethodName, function ($service) use ($data, $serviceMethodName, &$soapReturn) {
			//dd($service->getFunctions());
			$soapReturn = ($soapWrapper->call($serviceName.'.'.$serviceMethodName, $data));
			//dd($soapReturn);
    	//});
    	$soapData = $soapReturn->return!=null && is_object($soapReturn->return) ? null : json_decode($soapReturn->return);
    	return $soapData;
    }
    catch(\SoapFault $e)
    {
        $rp = [];
        $rp['status'] = 500;
        $rp['message'] = 'Connection timeout issues experienced';
        return (object)$rp;
    }
}




function sendPostRequest($url, $jsonData)
{
	$ch = curl_init($url);
	//dd($jsonData);

	/*$jsonDataEncoded = json_encode($jsonData);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
	//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: plain/text'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	dd([$url, $result]);
	try{
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($result, 0, $header_size);
		$body = substr($result, $header_size);


		curl_close($ch);
		$body = (trim(preg_replace('/\s+/', ' ', $body)));

		return $body;


	}
	catch(\Exception $e)
	{
		return $e;
	}*/


	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => $jsonData,
		//"username=potzr_staff@gmail.com&encPassword=eyJpdiI6InRLOXJlM0t3cFR6WmNpdVJPWUdxNkE9PSIsInZhbHVlIjoiQTMxNGRFaHhLT3E4UEkwL1dheVV4Zz09IiwibWFjIjoiZmZjMjhmYTdjZTg5NGM3ZDUxYjViY2E4NzVkN2Y1OWYwNDM4M2FiNjA0YTg4M2E0MjY3MzVkYTgzYzE0Mzg4MyJ9&bankCode=PROBASE",
		CURLOPT_HTTPHEADER => array(
			"Content-Type: application/x-www-form-urlencoded"
		),
	));

	$response = curl_exec($curl);

	//dd($response);
	try{
		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$header = substr($response, 0, $header_size);
		$body = substr($response, $header_size);


		curl_close($curl);

		//dd($body);
		$body = (trim(preg_replace('/\s+/', ' ', $body)));

		//return $body;
		return $response;


	}
	catch(\Exception $e)
	{
		return $e;
	}

}


function get_merchant_status_list()
{
	return
	['Active', 'Inactive', 'Disabled By Administrator'];

}


function get_device_types()
{
	return
	['Web', 'POS', 'ATM', 'MPQR'];
}


function get_device_status()
{
	return
	['ACTIVE', 'INACTIVE', 'DISABLED', 'DELETED'];
}


function get_account_status()
{
	return
	['ACTIVE', 'INACTIVE', 'DISABLED'];
}

function sendGetRequest($url, $data=NULL)
{

	if($data!=null)
		$url = $url."?".$data;




	$_h = curl_init();
	curl_setopt($_h, CURLOPT_HEADER, 1);
	curl_setopt($_h, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($_h, CURLOPT_HTTPGET, 1);
	curl_setopt($_h, CURLOPT_URL, $url );
	curl_setopt($_h, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
	curl_setopt($_h, CURLOPT_DNS_CACHE_TIMEOUT, 2 );
	$ty = curl_exec($_h);
	try{
		$header_size = curl_getinfo($_h, CURLINFO_HEADER_SIZE);
		$header = substr($ty, 0, $header_size);
		$body = substr($ty, $header_size);

		//dd($body);
		curl_close($_h);
		$body = (trim(preg_replace('/\s+/', ' ', $body)));

		return $body;


	}
	catch(\Exception $e)
	{
		return $e;
	}

}




function getRoleInterpretRoute($roleCode)
{

	if($roleCode!=NULL && $roleCode=='POTZR_STAFF')
	{
		return "potzr-staff";
	}else if($roleCode!=NULL && $roleCode=='BANK_STAFF')
	{
		return "bank-teller";
	}else if($roleCode!=NULL && $roleCode=='MERCHANT')
	{
		return "merchant";
	}else if($roleCode!=NULL && $roleCode=='MERCHANT')
	{
		return "merchant";
	}
	else if($roleCode!=NULL && $roleCode=='EXCO_STAFF')
	{
		return "exco-staff";
	}
	return "guest";
}


function handleTokenUpdate($result)
{

//select * from transactions transactio0_ cross join walletaccounts walletacco1_ cross join walletaccounts walletacco2_ cross join accounts account3_
// cross join accounts account4_ cross join customers customer5_ cross join customers customer6_ cross join users user7_
// cross join users user8_ where (transactio0_.creditWalletAccount_id=walletacco1_.id and walletacco1_.account_id=account3_.id and
// account3_.customer_id=customer5_.id and customer5_.user_id=user7_.id or transactio0_.debitWalletAccount_id=walletacco2_.id and
// walletacco2_.account_id=account4_.id and account4_.customer_id=customer6_.id and customer6_.user_id=user8_.id) and transactio0_.channel=5


	if(isset($result->status) && $result->status != -1 ) {

		/*$tk = $result->token;

		$usr = \Auth::user();
		$usr->token = $tk;
		$id = \Crypt::encrypt($usr);
		\Auth::updateSessionId($id);
		return true;*/
		//\Auth::setUser($usr);
		//dd($tk);
		//dd($usr);
	}else{

		u_logout();
		\Session::forget('data');
		return false;
	}
	return true;
}



function evaluateGuestTokenUpdate($result)
{


	if(isset($result->status) && $result->status != -1 ) {

		return true;
	}else{
		\Session::forget('data');
		return false;
	}
}



function getAllCardType()
{
	return [
		//'EAGLE_CARD' => 'EAGLE CARD',
		'TUTUKA_VIRTUAL_CARD' => 'Virtual Card - MasterCard',
		'TUTUKA_PHYSICAL_CARD' => 'Physical Card - MasterCard'
	];
}


function getAllCardTypes()
{
	return [
		'Eagle Card', 'MasterCard - Virtual', 'MasterCard - Physical', 'MasterCard - MPQR'
	];
}


function getAllCardStatus()
{
	return [
		'ACTIVE', 'INACTIVE', 'DISABLED', 'DELETED', 'RETIRED', 'NOT_ISSUED', 'ISSUED', 'STOPPED'
	];
}

function getAllAccountType()
{
	return [
			//'SAVINGS' => 'SAVINGS',
			//'CURRENT' => 'CURRENT',
			//'VIRTUAL' => 'VIRTUAL'
			'SAVINGS' => 'SAVINGS',
			'CURRENT' => 'CURRENT',
			'VIRTUAL' => 'VIRTUAL',
			'DEVICE_SETTLEMENT' => 'DEVICE SETTLEMENT',
			'PROBASE_TUTUKA_MASTERCARD_TRANSIT_ACCOUNT' => 'MASTERCARD TRANSIT ACCOUNT',
			'MERCHANT_TRANSIT_ACCOUNT' => 'MERCHANT TRANSIT ACCOUNT',
			'PROBASE_TUTUKA_MASTERCARD_POOL_ACCOUNT' => 'POOL ACCOUNT',
			'CORPORATE_ACCOUNT' => 'CORPORATE ACCOUNT',
			'COLLECTIONS' => 'PROBASE COLLECTIONS ACCOUNT',
			'AGENT_ACCOUNT' => 'AGENT ACCOUNT'
	];
}


function getAllIdentificationType()
{
	return [
			//'SAVINGS' => 'SAVINGS',
			//'CURRENT' => 'CURRENT',
			'NRC' => 'NRC',
			'INTERNATIONAL_PASSPORT' => 'INTERNATIONAL PASSPORT',
			'DRIVERS_LICENSE' => 'DRIVERS LICENSE'
	];
}


function getAllCustomerTypes()
{
	return [
			'INDIVIDUAL' => 'Individual Customer',
			'CORPORATE' => 'Corporate Customer'
	];
}

function getAllCurrency()
{
	return [
			'ZMW' => 'Zambian Kwacha',
			'TZS' => 'Tanzanian Shilling',
	];
}


function ifnullzero($x)
{
	if(is_null($x) || $x==null)
	{
		return 0.00;
	}
	return $x;
}

function getAllServiceTypes()
{
	$all = [];
	$all['DEPOSIT_OTC'] = 'Deposit Over The Counter';
	$all['PAY_MERCHANT'] = 'Pay Merchant';
	$all['DEBIT_MERCHANT'] = 'Debit Merchant Account';
	$all['REVERSE_PAYMENT_TO_MERCHANT'] = 'Reverse Merchant Payment';
	$all['DEBIT_CARD'] = 'Debit Customer Card';
	$all['CASHBACK'] = 'Cashback';
	$all['ADJUSTMENT'] = 'Load Card Funding Adjustment';
	$all['CREDIT_CARD'] = 'Credit Card With Funds';
	$all['REVERSE_DEBIT_ON_CARD'] = 'Reverse Debit On Card';
	$all['REVERSE_CREDIT_ON_CARD'] = 'Reverse Credit On Card'; 
	$all['CASH_PAYMENT'] = 'Receive Cash Payment';
	$all['REVERSE_REFUND'] = 'Reverse Payment Refund';
	$all['MPQR_WALLET_LOAD'] = 'MPQR Wallet Funding';
	$all['REVERSE_MPQR_WALLET_LOAD'] = 'Reverse MPQR Wallet Funding';
	$all['DEBIT_WALLET'] = 'Debit Wallet';
	$all['CREDIT_WALLET'] = 'Credit Wallet'; 
	$all['REVERSE_DEBIT_ON_WALLET'] = 'Reverse Debit on Wallet';
	$all['FT_WALLET_TO_WALLET'] = 'Funds Transfer (Wallet to Wallet)';
	$all['REVERSE_CREDIT_ON_WALLET'] = 'Reverse Funds Transfer to Wallet'; 
	$all['FT_WALLET_TO_CARD'] = 'Funds Transfer (Wallet to Card)'; 
	$all['FT_CARD_TO_WALLET'] = 'Funds Transfer (Card to Wallet)';
	$all['FT_CARD_TO_CARD'] = 'Funds Transfer (Card To Card)';
	$all['MTN_AIRTIME_PURCHASE'] = 'Airtime Purchase - MTN';
	$all['SERVICE_CHARGE'] = 'Service Charge';
	$all['PAY_MERCHANT_BY_QR'] = 'Pay Merchant By QR Scan';
	$all['GROUP_CONTRIBUTION'] = 'Village Banking Contribution';
	$all['GROUP_CONTRIBUTION_PENALTY'] = 'Village Banking Contribution Penalty'; 
	$all['GROUP_LOAN_REPAYMENT'] = 'Village Banking Repayment';
	$all['LOAD_CAPITAL_FUNDS'] = 'Load Capital Funds In Equity';
	$all['WITHDRAW_CASH'] = 'Withdraw Cash';// From Bank Or Agent
	$all['RECEIVE_MONEY'] = 'Receive money';// in your wallet or card
	$all['INTERBANK_TRANSFER'] = 'Transfer Money to a Bank Account';
	$all['LOAD_ZESCO_STOCK'] = 'Load ZESCO Stock';
	$all['LOAD_MTN_STOCK'] = 'Load MTN Stock';
	$all['LOAD_AIRTEL_STOCK'] = 'Load AIRTEL Stock';
	$all['LOAD_ZAMTEL_STOCK'] = 'Load ZAMTEL Stock';
	$all['LOAD_BULK_SMS'] = 'Load Bulk SMS';
	$all['GROUP_CREATION'] = 'Village Banking Group Creation';
	$all['GROUP_LOAN_APPLICATION'] = 'Collect A Village Banking Group Loan';
	$all['ZESCO_PURCHASE'] = 'Power Purchase - ZESCO';
	$all['AIRTEL_AIRTIME_PURCHASE'] = 'Airtime Purchase - AIRTEL';
	$all['ZAMTEL_AIRTIME_PURCHASE'] = 'Airtime Purchase - ZAMTEL';
	$all['CABLE_TV_PURCHASE_DSTV'] = 'Cable TV Subscription - DSTV';
	$all['CABLE_TV_PURCHASE_GOTV'] = 'Cable TV Subscription - GOTV';
	$all['CABLE_TV_PURCHASE_TOPSTAR'] = 'Cable TV Subscription - TOPSTAR';
	$all['FT_WALLET_TO_MOBILE_NUMBER'] = 'Funds Transfer to Mobile Number';
	$all['RECEIVE_FT_FOR_MOBILE'] = 'Receive Funds Transfer';
	$all['DEPOSIT_BY_AGENT'] = 'Funds Deposited By An Agent';
	$all['DIRECT_TRANSACTION_ENTRY'] = 'Manual Accounting Entry';
	$all['NKANA_WATER_BILL_PAYMENT'] = 'Nkana Water Bill Payment';
	$all['FT_WALLET_TO_BANK'] = 'Funds Transfer Wallet To Bank';
	$all['FT_CARD_TO_BANK'] = 'Funds Transfer Card To Bank';
	$all['GROUP_CLOSE_OUT'] = 'Group Contributions Close-Out';
	$all['FUND_AGENT_WALLET'] = 'Fund Agents Wallet';
	$all['WITHDRAW_CASH_AGENT'] = 'Agent Withdraws Funds';
	$all['FUND_WALLET_BY_MOBILE_MONEY_MTN'] = 'Fund Wallet Using Mobile Money (MTN)';
	$all['FT_WALLET_TO_BANK_NFS'] = 'Funds Transfer Wallet To Bank (NFS)';
	$all['FT_CARD_TO_BANK_NFS'] = 'Funds Transfer Card To Bank (NFS)';
	$all['FT_WALLET_TO_MOBILE_MONEY'] = 'Funds Transfer Wallet To Mobile Money';
	$all['FT_CARD_TO_MOBILE_MONEY'] = 'Funds Transfer Card To Mobile Money';
	$all['FT_WALLET_TO_KAZANG'] = 'Funds Transfer Wallet To KAZANG (NFS)';
	$all['FT_CARD_TO_KAZANG'] = 'Funds Transfer Card To KAZANG (NFS)';
	$all['FT_WALLET_TO_CGRATE'] = 'Funds Transfer Wallet To CGRATE (NFS)';
	$all['FT_CARD_TO_CGRATE'] = 'Funds Transfer Card To CGRATE (NFS)';
	$all['FT_WALLET_TO_ZOONA'] = 'Funds Transfer Wallet To ZOONA (NFS)';
	$all['FT_CARD_TO_ZOONA'] = 'Funds Transfer Card To ZOONA (NFS)';
	$all['FT_WALLET_TO_TENGA'] = 'Funds Transfer Wallet To TENGA (NFS)';
	$all['FT_CARD_TO_TENGA'] = 'Funds Transfer Card To TENGA (NFS)';
	$all['BORROW_FUNDS'] = 'Borrow Funds - Pay Later';
	$all['FT_WALLET_TO_BANK_INTERNAL_TRANSFER'] = 'Funds Transfer Wallet To Bank (Internal Transfer)';
	$all['FUND_WALLET_BY_MOBILE_MONEY_AIRTEL'] = 'Fund Wallet Using Mobile Money (AIRTEL)';
	$all['FUND_WALLET_BY_MOBILE_MONEY_ZAMTEL'] = 'Fund Wallet Using Mobile Money (ZAMTEL)';
	$all['BORROW_FUNDS_REPAYMENT'] = 'Loan Repayment';
	$all['PAY_BY_PROBASE_QR'] = 'Pay By Probase QR';
	$all['FT_CARD_TO_BANK_INTERNAL_TRANSFER'] = 'Funds Transfer Card to ZICB';
	$all['REFUND_CARD'] = 'Mastercard Card Refund';

	
	
	return $all;
}




function getAllServiceTypesForAgentReport()
{
	$all = [];
	$all['INTERBANK_TRANSFER'] = 'Transfer Money to a Bank Account';
	$all['DEPOSIT_BY_AGENT'] = 'Funds Deposited By An Agent';
	$all['FT_WALLET_TO_BANK'] = 'Funds Transfer Wallet To Bank';
	$all['FT_CARD_TO_BANK'] = 'Funds Transfer Card To Bank';
	$all['FUND_WALLET_BY_MOBILE_MONEY_MTN'] = 'Fund Wallet Using Mobile Money (MTN)';
	$all['FUND_WALLET_BY_MOBILE_MONEY_AIRTEL'] = 'Fund Wallet Using Mobile Money (AIRTEL)';
	$all['FUND_WALLET_BY_MOBILE_MONEY_ZAMTEL'] = 'Fund Wallet Using Mobile Money (ZAMTEL)';
	$all['FT_WALLET_TO_BANK_NFS'] = 'Funds Transfer Wallet To Bank (NFS)';
	$all['FT_CARD_TO_BANK_NFS'] = 'Funds Transfer Card To Bank (NFS)';
	$all['FT_WALLET_TO_MOBILE_MONEY'] = 'Funds Transfer Wallet To Mobile Money';
	$all['FT_CARD_TO_MOBILE_MONEY'] = 'Funds Transfer Card To Mobile Money';
	$all['FT_WALLET_TO_KAZANG'] = 'Funds Transfer Wallet To KAZANG (NFS)';
	$all['FT_CARD_TO_KAZANG'] = 'Funds Transfer Card To KAZANG (NFS)';
	$all['FT_WALLET_TO_CGRATE'] = 'Funds Transfer Wallet To CGRATE (NFS)';
	$all['FT_CARD_TO_CGRATE'] = 'Funds Transfer Card To CGRATE (NFS)';
	$all['FT_WALLET_TO_ZOONA'] = 'Funds Transfer Wallet To ZOONA (NFS)';
	$all['FT_CARD_TO_ZOONA'] = 'Funds Transfer Card To ZOONA (NFS)';
	$all['FT_WALLET_TO_TENGA'] = 'Funds Transfer Wallet To TENGA (NFS)';
	$all['FT_CARD_TO_TENGA'] = 'Funds Transfer Card To TENGA (NFS)';
	$all['FT_WALLET_TO_BANK_INTERNAL_TRANSFER'] = 'Funds Transfer Wallet To Bank (Internal Transfer)';
	$all['BORROW_FUNDS_REPAYMENT'] = 'Loan Repayment';

	
	
	return $all;
}


function getAllChannel()
{
	$channel  = [
			'WEB' => 'WEB',
			'POS' => 'POS',
			'OTC' => 'OTC',
			'ONLINE_BANKING' => 'ONLINE BANKING',
			'MOBILE' => 'MOBILE',
            'WALLET' => 'WALLET',
            'VISA_MASTERCARD_WEB' => 'VISA_MASTERCARD_WEB',
            'UBA' => 'UBA',
            'ATM' => 'ATM',
            'NOT_SPECIFIED' => 'NOT_SPECIFIED',
            'CARD' => 'CARD',
            'SYSTEM' => 'SYSTEM',
            'USSD' => 'USSD'
	];

	return $channel;
}


function getAllBanks()
{
	$channel  = [
			"ABC" => "Banc ABC",
			"BOZ" => "Bank of Zambia",
			"ABBZ" => "AB Bank Zambia",
			"FNB" => "First National Bank",
			"BB" => "Barclays Bank",
			"IZB" => "Indo-Zambia Bank",
			"ZB" => "ZANACO Bank"];
	return $channel;
}


function getAllMerchantStatus()
{
	$status = [
			"ACTIVE" => "Active",
			"INACTIVE" => "Inactive",
			"DISABLED" => "Disabled"];
	return $status;
}

function getAllPrivileges()
{
	$privileges=[
		"Merchants" =>
			["11" => "Create & Update Merchant",
			"12" => "View Merchant",
			"13" => "View Merchant Transactions",
			"14" => "Disable/Enable Merchant"],
		"Merchant Devices" =>
			["21" => "Create Device",
			"22" => "View & Update Device",
			"23" => "View Device Transactions",
			"24" => "Disable & Enable Devices"],
		"Banks" =>
			["31" => "Create & Update Bank",
			"32" => "View Bank",
			"33" => "View Bank Transactions",
			"34" => "Create & Update Bank Staff",
			"35" => "View Bank Staff"],
		"Virtual Accounts" =>
			["41" => "Create & Update Account",
			"42" => "View Account",
			"43" => "View & Suspend/Re-activate Account",
			"44" => "View & Fund Account",
			"45" => "Query Last Five Transactions"],
		"Credit & Debit Cards" =>
			["51" => "Add New Credit/Debit Card to Account",
			"52" => "Block Credit/Debit Card",
			"53" => "Delete Card",
			"54" => "Deactivate & Reactivate Card",
			"55" => "Create & Update Card Scheme",
			"56" => "Deactivate & Activate Card Scheme"],
		"Mobile Money Accounts" =>
			["61" => "Setup Mobile Money Accounts",
			"62" => "View Mobile Money Accounts",
			"63" => "Suspend Mobile Money Account",
			"64" => "View Last 5 Transactions"],
		"Pool Accounts" =>
			["71" => "Create & Update New Pool Accounts",
			"72" => "View Pool Accounts",
			"73" => "Fund Pool Accounts",
			"74" => "View Last 5 Transactions"],
		"Vendor Services" =>
			["81" => "Create & Update Vendor Service",
			"82" => "Suspend Merchant Vendor Service",
			"83" => "Activate & Deactivate Vendor Service",
			"84" => "View Last 5 Transactions"],
		"Transactions" =>
			["91" => "View All Transactions",
			"92" => "Generate Transaction Reports",
			"93" => "Generate Transaction Payout Reports",
			"94" => "Upload Transactions Paid Out",
			"95" => "Reverse Transactions"],
		"EWallet Accounts" =>
			["101" => "View Accounts Attached To An EWallet",
			"102" => "Suspend EWallet Account",
			"103" => "Reactivate EWallet Account",
			"104" => "Last Five Transactions"],
		"User Management" =>
			["111" => "View Portal User Accounts",
			"112" => "Disable & Enable Portal User Account",
			"113" => "Manage Portal User Privileges"]
		];

	return $privileges;
}



function formatPaymentResponse($channel, $response, $defaultReturnUrl)
{
    try
    {
    	$returnResponse = array();

    	if($channel == 'WEB') {

    		if (evaluateGuestTokenUpdate($response) == false) {

    			$returnResponse["statusmessage"] = "Transaction Timed Out";
    			if(isset($response->message))
    			    $returnResponse["reason"] = $response->message;
    			if(isset($response->merchantId))
    			    $returnResponse["merchantId"] = $response->merchantId;
    			if(isset($response->deviceCode))
    			    $returnResponse["deviceCode"] = $response->deviceCode;
    			$returnResponse["status"] = '01';
    			if(isset($response->txnRef))
    			    $returnResponse["transactionRef"] = $response->txnRef;
    			if(isset($response->transactionDate))
    			    $returnResponse["transactionDate"] = $response->transactionDate;
    			if(isset($response->orderId))
    			    $returnResponse["orderId"] = $response->orderId;
    			if(isset($response->returnUrl))
    			    $returnResponse["redirectUrl"] = $response->returnUrl;
    			if(isset($response->autoReturnToMerchant))
    			    $returnResponse["returnToMerchant"] = $response->autoReturnToMerchant;
    			if(isset($response->customdata))
    			    $returnResponse["customdata"] = $response->customdata;
    		} else {

    			if (isset($response->status) && $response->status == "00") {

                    //dd($returnResponse);
    				$returnResponse["statusmessage"] = "Transaction Successful";
    				$returnResponse["reason"] = $response->message;
    				$returnResponse["merchantId"] = $response->merchantId;
    				$returnResponse["deviceCode"] = $response->deviceCode;
    				$returnResponse["status"] = '00';
    				if(isset($response->txnRef))
    				    $returnResponse["transactionRef"] = $response->txnRef;
    				if(isset($response->transactionRefs))
    				    $returnResponse["transactionRef"] = $response->transactionRefs;

    				$returnResponse["transactionDate"] = $response->transactionDate;
    				$returnResponse["orderId"] = $response->orderId;
    				$returnResponse["redirectUrl"] = $response->returnUrl;
    				$returnResponse["returnToMerchant"] = $response->autoReturnToMerchant;
    			    if(isset($response->customdata))
    			        $returnResponse["customdata"] = $response->customdata;

    				$customerMobileContact = isset($response->customerMobileContact) ? $response->customerMobileContact : null;
    				if($customerMobileContact!=null)
    				{
        				$amountDebited = $response->amount;
        				$accountNo = $response->debitedAccountNo;
        				$msg = "Account Debit\n";
        				$msg = $msg . "Acct No: " . $accountNo;
        				$msg = $msg . "\nAmount Deposited:ZMW" . $amountDebited;
        				$msg = $msg . "\n\nThank You.";
        				send_sms($customerMobileContact, $msg);
    				}
    				//
    				//return view('core.authenticated.ewallet.ewallet_account_attached_listing', compact('txnRef', 'orderId', 'transaction', 'billingAddress'));
    			} else if (isset($response->status) && $response->status != "00") {
    				$returnResponse["statusmessage"] = "Transaction Failed";
    				$returnResponse["reason"] = $response->message;
    				if(isset($response->merchantId))
    				    $returnResponse["merchantId"] = $response->merchantId;
    				if(isset($response->deviceCode))
    				    $returnResponse["deviceCode"] = $response->deviceCode;
    				$returnResponse["status"] = '09';
    				if(isset($response->txnRef))
    				    $returnResponse["transactionRef"] = $response->txnRef;
    				if(isset($response->transactionDate))
    				    $returnResponse["transactionDate"] = $response->transactionDate;
    				if(isset($response->orderId))
    				    $returnResponse["orderId"] = $response->orderId;
    				if(isset($response->returnUrl))
    				    $returnResponse["redirectUrl"] = $response->returnUrl;
    				if(isset($response->autoReturnToMerchant))
    				    $returnResponse["returnToMerchant"] = $response->autoReturnToMerchant;
    			    if(isset($response->customdata))
    			        $returnResponse["customdata"] = $response->customdata;
    			} else {
    				$returnResponse["statusmessage"] = "Transaction Failed. Invalid Data Received";
    				$returnResponse["reason"] = $response->message;
    				$returnResponse["status"] = '02';
    				if(isset($response->data))
    				   $returnResponse["data"] = $response->data;
    				if(isset($response->transactionDate))
    				   $returnResponse["transactionDate"] = $response->transactionDate;
    				$returnResponse["redirectUrl"] = $defaultReturnUrl;
    				$returnResponse["returnToMerchant"] = "1";
    			    if(isset($response->customdata))
    			        $returnResponse["customdata"] = $response->customdata;
    			}
    		}
    	}
    }
    catch(\Exception $e)
    {
        return null;
    }

	return $returnResponse;
}


function getServiceBaseURL()
{
	//return "10.71.39.18:8080";
	return "localhost:8080";
}


function formatPan($pan) {
    // TODO Auto-generated method stub
    if($pan==null)
        return "";

    $len = strlen($pan);
    $pan1 = substr($pan, 0, 4);
    $pan2 = substr($pan, ($len-4));
    $pad = "";
    $len = $len - 8;
    while($len>0)
    {
        $pad = $pad."*";
        $len = $len - 1;
    }

    return ($pan1 . $pad . $pan2);
}



function getRoleTypesByCustomKey($customKey)
{
    $rtypes = [
        'bank-staff' => 'BANK_STAFF',
        'merchant' => 'MERCHANT',
        'customer' => 'CUSTOMER',
        'admin-staff' => 'ADMIN_USER',
        'potzr-staff' => 'POTZR_STAFF',
        'accountant' => 'ACCOUNTANT',
        'agent' => 'AGENT',
        'exco-staff' => 'EXCO_STAFF'
    ];
    return $rtypes[$customKey];
}


function allRoleTypes()
{
    return ['BANK_STAFF', 'MERCHANT', 'CUSTOMER', 'ADMIN_USER', 'POTZR_STAFF', 'ACCOUNTANT', 'AGENT'];
}


function allUserStatus()
{
    return ['ACTIVE', 'INACTIVE', 'ADMIN_DISABLED', 'LOCKED'];
}


function allMPQRDataStatus()
{
	return ['ACTIVE', 'DISABLED'];
}



function glAccountTypes()
{
	$all = [];
	$all['ASSET'] = 'Assets';
	$all['LIABILITY'] = 'Liabilities';
	$all['EQUITY'] = 'Equity';
	$all['INCOME'] = 'Income';
	$all['EXPENSE'] = 'Expenses';
	return $all;
}

function allChargeTypes()
{
	$all = []; 
	$all['PERCENTAGE_OF_TRANSACTION'] = 'Percentage of Transaction';
	$all['FLAT_VALUE'] = 'Flat Value';
	return $all;
}

function allServiceTypes()
{
	/*$all = [];
	$all['DEPOSIT_OTC'] = 'Deposit Over The Counter';
	$all['PAY_MERCHANT'] = 'Pay Merchant';
	$all['DEBIT_MERCHANT'] = 'Debit Merchant Account';
	$all['REVERSE_MPQR_WALLET_LOAD'] = 'Reverse MPQR Wallet Funding';
	$all['DEPOSIT_OTC'] = 'Deposit Over The Counter';
	$all['REVERSE_PAYMENT_TO_MERCHANT'] = 'Reverse Payment To Merchant';
	$all['DEBIT_CARD'] = 'Debit Customer Card';
	$all['CASHBACK'] = 'Cashback';
	$all['ADJUSTMENT'] = 'Load Card Funding Adjustment';
	$all['CREDIT_CARD'] = 'Credit Card With Funds';
	$all['REVERSE_DEBIT_ON_CARD'] = 'Reverse Debit On Card';
	$all['REVERSE_CREDIT_ON_CARD'] = 'Reverse Credit On Card'; 
	$all['CASH_PAYMENT'] = 'Receive Cash Payment';
	$all['REVERSE_REFUND'] = 'Reverse Payment Refund';
	$all['MPQR_WALLET_LOAD'] = 'MPQR Wallet Funding';
	$all['REVERSE_MPQR_WALLET_LOAD'] = 'Reverse MPQR Wallet Funding';
	$all['DEBIT_WALLET'] = 'Debit Wallet';
	$all['CREDIT_WALLET'] = 'Credit Wallet'; 
	$all['REVERSE_DEBIT_ON_WALLET'] = 'Reverse Debit on Wallet';
	$all['FT_WALLET_TO_WALLET'] = 'Funds Transfer (Wallet to Wallet)';
	$all['REVERSE_CREDIT_ON_WALLET'] = 'Reverse Funds Transfer to Wallet'; 
	$all['FT_WALLET_TO_CARD'] = 'Funds Transfer (Wallet to Card)'; 
	$all['FT_CARD_TO_WALLET'] = 'Funds Transfer (Card to Wallet)';
	$all['FT_CARD_TO_CARD'] = 'Funds Transfer (Card To Card)';
	$all['MTN_AIRTIME_PURCHASE'] = 'Airtime Purchase - MTN';
	$all['SERVICE_CHARGE'] = 'Service Charge';
	$all['PAY_MERCHANT_BY_QR'] = 'Pay Merchant By QR Scan';
	$all['GROUP_CONTRIBUTION'] = 'Village Banking Contribution';
	$all['GROUP_CONTRIBUTION_PENALTY'] = 'Village Banking Contribution Penalty'; 
	$all['GROUP_LOAN_REPAYMENT'] = 'Village Banking Repayment';
	$all['LOAD_CAPITAL_FUNDS'] = 'Load Capital Funds In Equity';
	$all['WITHDRAW_CASH'] = 'Withdraw Cash';// From Bank Or Agent
	$all['RECEIVE_MONEY'] = 'Receive money';// in your wallet or card
	$all['INTERBANK_TRANSFER'] = 'Transfer Money to a Bank Account';
	$all['LOAD_ZESCO_STOCK'] = 'Load ZESCO Stock';
	$all['LOAD_MTN_STOCK'] = 'Load MTN Stock';
	$all['LOAD_AIRTEL_STOCK'] = 'Load AIRTEL Stock';
	$all['LOAD_ZAMTEL_STOCK'] = 'Load ZAMTEL Stock';
	$all['LOAD_BULK_SMS'] = 'Load Bulk SMS';
	$all['GROUP_CREATION'] = 'Village Banking Group Creation';
	$all['GROUP_LOAN_APPLICATION'] = 'Collect A Village Banking Group Loan';
	$all['ZESCO_PURCHASE'] = 'Power Purchase - ZESCO';
	$all['AIRTEL_AIRTIME_PURCHASE'] = 'Airtime Purchase - AIRTEL';
	$all['ZAMTEL_AIRTIME_PURCHASE'] = 'Airtime Purchase - ZAMTEL';
	$all['CABLE_TV_PURCHASE_DSTV'] = 'Cable TV Subscription - DSTV';
	$all['CABLE_TV_PURCHASE_GOTV'] = 'Cable TV Subscription - GOTV';
	$all['CABLE_TV_PURCHASE_TOPSTAR'] = 'Cable TV Subscription - TOPSTAR';
	$all['FT_WALLET_TO_MOBILE_NUMBER'] = 'Funds Transfer to Mobile Number';
	$all['RECEIVE_FT_FOR_MOBILE'] = 'Receive Funds Transfer';
	$all['DEPOSIT_BY_AGENT'] = 'Funds Deposited Through An Agent';
	$all['DIRECT_TRANSACTION_ENTRY'] = 'Manual Entry';
	$all['NKANA_WATER_BILL_PAYMENT'] = 'Nkana Water Bill Payment';
	$all['FT_WALLET_TO_BANK'] = 'Funds Transfer Wallet To Bank';
	$all['FT_CARD_TO_BANK'] = 'Funds Transfer Card To Bank';*/
	$all = [];
	$all['DEPOSIT_OTC'] = 'Deposit Over The Counter';
	$all['PAY_MERCHANT'] = 'Pay Merchant';
	$all['DEBIT_MERCHANT'] = 'Debit Merchant Account';
	$all['REVERSE_PAYMENT_TO_MERCHANT'] = 'Reverse Merchant Payment';
	$all['DEBIT_CARD'] = 'Debit Customer Card';
	$all['CASHBACK'] = 'Cashback';
	$all['ADJUSTMENT'] = 'Load Card Funding Adjustment';
	$all['CREDIT_CARD'] = 'Credit Card With Funds';
	$all['REVERSE_DEBIT_ON_CARD'] = 'Reverse Debit On Card';
	$all['REVERSE_CREDIT_ON_CARD'] = 'Reverse Credit On Card'; 
	$all['CASH_PAYMENT'] = 'Receive Cash Payment';
	$all['REVERSE_REFUND'] = 'Reverse Payment Refund';
	$all['MPQR_WALLET_LOAD'] = 'MPQR Wallet Funding';
	$all['REVERSE_MPQR_WALLET_LOAD'] = 'Reverse MPQR Wallet Funding';
	$all['DEBIT_WALLET'] = 'Debit Wallet';
	$all['CREDIT_WALLET'] = 'Credit Wallet'; 
	$all['REVERSE_DEBIT_ON_WALLET'] = 'Reverse Debit on Wallet';
	$all['FT_WALLET_TO_WALLET'] = 'Funds Transfer (Wallet to Wallet)';
	$all['REVERSE_CREDIT_ON_WALLET'] = 'Reverse Funds Transfer to Wallet'; 
	$all['FT_WALLET_TO_CARD'] = 'Funds Transfer (Wallet to Card)'; 
	$all['FT_CARD_TO_WALLET'] = 'Funds Transfer (Card to Wallet)';
	$all['FT_CARD_TO_CARD'] = 'Funds Transfer (Card To Card)';
	$all['MTN_AIRTIME_PURCHASE'] = 'Airtime Purchase - MTN';
	$all['SERVICE_CHARGE'] = 'Service Charge';
	$all['PAY_MERCHANT_BY_QR'] = 'Pay Merchant By QR Scan';
	$all['GROUP_CONTRIBUTION'] = 'Village Banking Contribution';
	$all['GROUP_CONTRIBUTION_PENALTY'] = 'Village Banking Contribution Penalty'; 
	$all['GROUP_LOAN_REPAYMENT'] = 'Village Banking Repayment';
	$all['LOAD_CAPITAL_FUNDS'] = 'Load Capital Funds In Equity';
	$all['WITHDRAW_CASH'] = 'Withdraw Cash';// From Bank Or Agent
	$all['RECEIVE_MONEY'] = 'Receive money';// in your wallet or card
	$all['INTERBANK_TRANSFER'] = 'Transfer Money to a Bank Account';
	$all['LOAD_ZESCO_STOCK'] = 'Load ZESCO Stock';
	$all['LOAD_MTN_STOCK'] = 'Load MTN Stock';
	$all['LOAD_AIRTEL_STOCK'] = 'Load AIRTEL Stock';
	$all['LOAD_ZAMTEL_STOCK'] = 'Load ZAMTEL Stock';
	$all['LOAD_BULK_SMS'] = 'Load Bulk SMS';
	$all['GROUP_CREATION'] = 'Village Banking Group Creation';
	$all['GROUP_LOAN_APPLICATION'] = 'Collect A Village Banking Group Loan';
	$all['ZESCO_PURCHASE'] = 'Power Purchase - ZESCO';
	$all['AIRTEL_AIRTIME_PURCHASE'] = 'Airtime Purchase - AIRTEL';
	$all['ZAMTEL_AIRTIME_PURCHASE'] = 'Airtime Purchase - ZAMTEL';
	$all['CABLE_TV_PURCHASE_DSTV'] = 'Cable TV Subscription - DSTV';
	$all['CABLE_TV_PURCHASE_GOTV'] = 'Cable TV Subscription - GOTV';
	$all['CABLE_TV_PURCHASE_TOPSTAR'] = 'Cable TV Subscription - TOPSTAR';
	$all['FT_WALLET_TO_MOBILE_NUMBER'] = 'Funds Transfer to Mobile Number';
	$all['RECEIVE_FT_FOR_MOBILE'] = 'Receive Funds Transfer';
	$all['DEPOSIT_BY_AGENT'] = 'Funds Deposited By An Agent';
	$all['DIRECT_TRANSACTION_ENTRY'] = 'Manual Accounting Entry';
	$all['NKANA_WATER_BILL_PAYMENT'] = 'Nkana Water Bill Payment';
	$all['FT_WALLET_TO_BANK'] = 'Funds Transfer Wallet To Bank';
	$all['FT_CARD_TO_BANK'] = 'Funds Transfer Card To Bank';
	$all['GROUP_CLOSE_OUT'] = 'Group Contributions Close-Out';
	$all['FUND_AGENT_WALLET'] = 'Fund Agents Wallet';
	$all['WITHDRAW_CASH_AGENT'] = 'Agent Withdraws Funds';
	$all['FUND_WALLET_BY_MOBILE_MONEY_MTN'] = 'Fund Wallet Using Mobile Money (MTN)';
	$all['FT_WALLET_TO_BANK_NFS'] = 'Funds Transfer Wallet To Bank (NFS)';
	$all['FT_CARD_TO_BANK_NFS'] = 'Funds Transfer Card To Bank (NFS)';
	$all['FT_WALLET_TO_MOBILE_MONEY'] = 'Funds Transfer Wallet To Mobile Money';
	$all['FT_CARD_TO_MOBILE_MONEY'] = 'Funds Transfer Card To Mobile Money';
	$all['FT_WALLET_TO_KAZANG'] = 'Funds Transfer Wallet To KAZANG (NFS)';
	$all['FT_CARD_TO_KAZANG'] = 'Funds Transfer Card To KAZANG (NFS)';
	$all['FT_WALLET_TO_CGRATE'] = 'Funds Transfer Wallet To CGRATE (NFS)';
	$all['FT_CARD_TO_CGRATE'] = 'Funds Transfer Card To CGRATE (NFS)';
	$all['FT_WALLET_TO_ZOONA'] = 'Funds Transfer Wallet To ZOONA (NFS)';
	$all['FT_CARD_TO_ZOONA'] = 'Funds Transfer Card To ZOONA (NFS)';
	$all['FT_WALLET_TO_TENGA'] = 'Funds Transfer Wallet To TENGA (NFS)';
	$all['FT_CARD_TO_TENGA'] = 'Funds Transfer Card To TENGA (NFS)';
	$all['BORROW_FUNDS'] = 'Borrow Funds - Pay Later';
	$all['FT_WALLET_TO_BANK_INTERNAL_TRANSFER'] = 'Funds Transfer Wallet To ZICB';
	$all['FUND_WALLET_BY_MOBILE_MONEY_AIRTEL'] = 'Fund Wallet Using Mobile Money (AIRTEL)';
	$all['FUND_WALLET_BY_MOBILE_MONEY_ZAMTEL'] = 'Fund Wallet Using Mobile Money (ZAMTEL)';
	$all['BORROW_FUNDS_REPAYMENT'] = 'Loan Repayment';
	$all['PAY_BY_PROBASE_QR'] = 'Pay By Probase QR';
	$all['FT_CARD_TO_BANK_INTERNAL_TRANSFER'] = 'Funds Transfer Card to ZICB';
	$all['REFUND_CARD'] = 'Mastercard Card Refund';




	return $all;
}


function getDoubleNumb($num)
{
	if(isset($num) && $num!=null)
		return $num;
	else
		return 0.00;
}



function getprefixperuserole()
{
	$role = \Auth::user()->role_code;
	if($role=='POTZR_STAFF')
	{
		return 'potzr-staff';
	}
	else if($role=='BANK_STAFF')
	{
		return 'bank-staff';
	}
	else if($role=='MERCHANT')
	{
		return 'merchant';
	}
	else if($role=='ACCOUNTANT')
	{
		return 'accountant';
	}
	else if($role=='AGENT')
	{
		return 'agent';
	}
}



function getRequestTypes()
{
	$all = ['BALANCE_INQUIRY',  
	'REMOTE_DEBIT',  
	'CREATE_VIRTUAL_CARD',  
	'ACTIVATE_CARD',  
	'CHANGE_CARD_PIN',  
	'CREATE_QR_DATA',  
	'DEACTIVATE_QR_DATA',  
	'DEDUCT_ADJUSTMENT',  
	'DEDUCT_REVERSAL_LOG',  
	'GET_CUSTOMER__ACTIVE_CARDS',  
	'GET_CARD_STATUS',  
	'LOAD_AUTH',  
	'LOAD_AUTH_REVERSAL',  
	'LOAD_MPQR',  
	'LOAD_MPQR_REVERSAL',  
	'LINK_CUSTOMER_TO_CARD',  
	'LOAD_ADJUSTMENT',  
	'LOAD_ADJUSTMENT_REVERSAL',  
	'SERVER_RESTART',  
	'ORDER_NEW_CARD',  
	'RETIRE_CARD',  
	'STOP_CARD_REMOTE',  
	'STOP_CARD_LOCAL',  
	'TRANSFER_CARD',  
	'UNSTOP_CARD',  
	'CHANGE_CARD_BEARER',  
	'CHANGE_CARD_CVV',  
	'FUNDS_TRANSFER',  
	'PAY_BILLS',  
	'USER_SIGNUP',  
	'SMS_SEND',  
	'EMAIL_SEND',
	'SERVER_SHUTDOWN'];
	return $all;
}




function getNFSServiceIds()
{
	return [
		"AIRTEL_MONEY"=>"344",
		"MTN_MONEY"=>"335",
		"ZAMTEL_MONEY"=>"350",
		"KAZANG"=>"311",
		"CGRATE"=>"338",
		"ZOONA"=>"000",
		"TENGA"=>"347",
	];
}