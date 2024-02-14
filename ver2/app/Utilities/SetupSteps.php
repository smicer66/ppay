<?php
/************************************************************/
/**   Created by Igbalajobi Jamiu O. on 10/13/15  11:04 AM   **/
/************************************************************/


namespace App\Utilities;

use App\Models\ApplicantParents;
use App\Models\Applicants;
use App\Models\DataBanks;
use App\Models\Packages;
use App\Models\PaymentCategories;
use App\Models\Roles;
use App\Models\Schools;
use App\Models\SchoolStaff;
use App\Models\StaffAcademicHistory;
use App\Models\StaffEmploymentHistory;
use App\Models\Subscriptions;
use App\Models\PaymentHistories;
use App\Models\User;
use App\Models\UserProfiles;
use Session;
use DB;
use Hash;
use InvalidArgumentException;

class SetupSteps
{
    var $steps;

    public function __construct(array $steps)
    {
        $this->steps = $steps;
    }

    public function saveTemp($step, array $data)
    {
        if (!in_array($step, $this->steps)) {
            throw new InvalidArgumentException;
        }
        \Session::put($step, $data);
        return \Session::save();
    }
	
	public function saveTempV1($step, array $data, $allData=NULL)
    {
		if(!is_null($allData))
		{
			$allData = array();
		}
		$allData[$step] = $data;
        return $allData;
    }

    public function clearSavedData(array $keys, $keyExcept = array())
    {
        foreach ($keys as $key) {
            if (in_array($key, $this->steps) && !in_array($key, $keyExcept)) {
                Session::remove($key);
            }
        }
    }

    public function check_session()
    {
        $d = $this->getSavedData();
        return ($d == null || count($d) <= 0);
    }

    public function getSavedData()
    {
        $data = [];
        foreach ($this->steps as $step) {
            if (isset(Session::all()[$step])) {
                $data[] = Session::all()[$step];
            }
        }
        $data_all = [];
        for ($i = 0; $i < sizeof($data); $i++) {
            $data_all = array_merge($data_all, $data[$i]);
        }
        $data = $data_all;
        return $data_all;
    }

    public function createSchool(User $user, $payment_mode)
    {

        $data = $this->getSavedData();
		$synctracker = new \App\Models\Synctracker();

        $preferred_url = null;
        DB::beginTransaction();
        try {
			if($data['system_mode'] != 'OFFLINE')
			{
				if (isset($data['domain']) && trim($data['domain']) != "") {
					$preferred_url = $data['domain'];
				} else {
					$preferred_url = $data['preferred_url'] . '.' . env('DOMAIN_NAME');
				}
			}
            $package_id = $data['package_id'];

            //create school
            $school = new Schools();
            $school->name = $data['school_name'];
            $school->address_line1 = $data['address_line1'];
            $school->address_line2 = $data['address_line2'];
            $school->city = $data['city'];
            $school->state_id = $data['state_id'];
            $school->contact_phone1 = $data['contact_phone1'];
//        $school->contact_phone2 = $data['contact_phone2'];
            $school->contact_email = $data['contact_email'];
            $school->setup_type = $data['system_mode'];
            $school->status = 'Inactive';
            $school->school_admin_user_id = $user->id;
			if($data['system_mode'] != 'OFFLINE')
			{
           		$school->preferred_url = $preferred_url;
			}
			$school->confirmation_code = strtoupper(str_random(10));
			$school->mobile_code = '260';
            $school->save();
			
			$synctracker = $synctracker->createNewSyncTracker(1, $school, 'Schools', $school->id);

            $subscription = new Subscriptions();
            $subscription->school_id = $school->id;
            $subscription->package_id = $package_id;
            $subscription->status = 'Inactive';
            $subscription->save();
			$synctracker = $synctracker->createNewSyncTracker(1, $school, 'Subscriptions', $school->id);

            $u = User::find($user->id);
            $u->package_id = $package_id;
            $u->school_id = $school->id;
            $u->save();
			$synctracker = $synctracker->createNewSyncTracker(2, $school, 'User', $user->id);


            $payment_history = new PaymentHistories();
            $payment_history->id = primary_key();
            $payment_history->user_id = $user->id;
            $payment_history->ref_no = generate_trans_ref();
            $payment_history->amount = Packages::find($package_id)->amount;
            $payment_history->status = 'Pending';
            $payment_history->payment_mode = $payment_mode;

            $payCat = PaymentCategories::where('name', 'Subscription')->first();
            $payment_history->payment_category_id = $payCat->id;
            $payment_history->payment_category_instance_id = $subscription->id;
            $payment_history->save();
			$synctracker = $synctracker->createNewSyncTracker(1, $school, 'PaymentHistories', $user->id);
            DB::commit();
			$array[0] = $school;
			$array[1] = $subscription;
            return $array;
        } catch (\Exception $e) {
			dd($e->getMessage());
            DB::rollback();
            return false;
        }

    }

    public function createApplicant($data, $school_id, $school_, $rrr_code, $applicantNo, $schoolTerm, $academicYear)
    {
		
		$synctracker = new \App\Models\Synctracker();
        DB::beginTransaction();
        try {
            $passport_databank_id = null;
            //Move the temporal file to appropriate location
            $tmp_file = Session::get('applicant_passport');
            if (file_exists($tmp_file)) {
                $destination = '/files/passports/' . $school_id . '/';
//                dd(public_path() . $destination);
                if (!is_dir(public_path() . $destination))
                    mkdir('files/passports/' . $school_id . '/', 0777, true);
                $name = Session::get('applicant_passport_name');
                if (copy($tmp_file, public_path() . $destination . $name)) {
                    $passport_databank_id = primary_key();
                    $data_bank = new DataBanks();
                    $data_bank->id = $passport_databank_id;
                    $data_bank->file_name = $name;
                    $data_bank->file_url = $destination;
                    $data_bank->file_path = $destination;
                    if ($data_bank->save()) {
                        @unlink($tmp_file);
						$synctracker = $synctracker->createNewSyncTracker(1, $school_, 'FILES', $passport_databank_id);
                    }
                }
            }
			
			
			$uscheck = Applicants::where('email', '=', $data['email']."89");
			if($uscheck->count()>0)
			{
				return back()->with('input', $data)->with('error', "Invalid Email Address Provided. This email address has already been taken up by another applicant.");
			}
			
			
            $applicant_id = primary_key();
            $applicant = new Applicants();
            $applicant->id = $applicant_id;
            $applicant->school_id = $school_id;
            $applicant->applicant_no = $applicantNo;
            $applicant->class_id = $data['class_id'];
            $applicant->first_name = $data['first_name'];
            $applicant->surname = $data['surname'];
            $applicant->other_name = $data['other_name'];
            $applicant->email = $data['email'];
			$applicant->mobile_number = $data['mobile_number'];
            $applicant->gender = $data['gender'];
            $applicant->date_of_birth = $data['date_of_birth'];
            $applicant->address_line1 = $data['address_line1'];
            $applicant->address_line2 = $data['address_line2'];
            $applicant->lga_id = $data['lga_id'];
            $applicant->religion = $data['religion'];
            $applicant->accommodation_type = $data['accommodation_type'];
            $applicant->hobbies = $data['hobbies'];
            $applicant->passport_data_bank_id = $passport_databank_id;
			$applicant->bank_rrr_code = $rrr_code;
            $applicant->is_paid = 0;
			$applicant->referee = $data['referee'];
			
			
			$admissionAmount = \App\Models\AdmissionAmount::where('class_id', '=', $data['class_id'])
				->where('academic_year_id', '=', $academicYear)
				->where('status', '=', '1')
				->orderBy('updated_at')->first();
			
            $applicant->amount_to_pay = $admissionAmount==NULL ? NULL : $admissionAmount->amount;
			$applicant->academic_term_id =  $schoolTerm;
			$applicant->academic_year_id =  $academicYear;
			
            $applicant->save();
			
			$synctracker = $synctracker->createNewSyncTracker(1, $school_, 'Applicant', $applicant_id);


			$i1 = 0;
			$i2 = "";
            foreach($data['admission_one_b'] as $data1) {
                $applicant_guardian = new ApplicantParents();
				$guardianId = primary_key();
                $applicant_guardian->id = $guardianId;
                $applicant_guardian->school_id = $school_id;
                $applicant_guardian->applicant_id = $applicant_id;
                $applicant_guardian->surname = $data1['parent_surname1'];
                $applicant_guardian->first_name = $data1['parent_first_name1'];
                $applicant_guardian->relationship = $data1['parent_relationship1'];
                $applicant_guardian->phone = $data1['parent_phone1'];
                $applicant_guardian->occupation = $data1['parent_occupation1'];
                $applicant_guardian->email = $data1['parent_email1'];
                $applicant_guardian->address_line1 = $data1['parent_address_line11'];
                $applicant_guardian->address_line2 = $data1['parent_address_line21'];
				if($i1==0)
				{
					$i2 = $data1['parent_phone1'];
					$i1++;
				}
                $applicant_guardian->save();
				$synctracker = $synctracker->createNewSyncTracker(1, $school_, 'ApplicantParents', $guardianId);
            }
			
			
            DB::commit();
			$msg = urlencode("Admission Application Details. Applicant No: ".$applicantNo." | Applicant Name: ".$data['first_name']." ".$data['surname']);
			$snd = send_sms($data['mobile_number'], $msg,$school_);
			
			
            return $applicant_id;
        } catch (\Exception $e) {
			dd($e);
            DB::rollback();
            return false;
        }
    }

    function createStaff($domain, Schools $schools)
    {
		$password = str_random(8);
		$password = env('DEFAULT_PASSWORD');
        $data = (object)$this->getSavedData();
		//dd(Session::all());
		//Move the temporal file to appropriate location
		
		$tmp_file = Session::get('staff_passport');
		$synctracker = new \App\Models\Synctracker();
		
				
//==		dd($data);
        $staff = null;
        if (isset($data->id)) {
            $staff = SchoolStaff::with(['employment_histories', 'academic_histories'])->find($data->id);
        }
//        dd($staff);
			
			DB::beginTransaction();
			try {
				$synctracker = new \App\Models\Synctracker();
				$action = null;
				if ($staff == null) {
					$user_profile_id = primary_key();
					$user_profile = new UserProfiles();
					$action = 1;
				} else {
					$user_profile_id = $staff->user_profile_id;
					$user_profile = UserProfiles::find($user_profile_id);
					$action = 2;
				}
				$user_profile->id = $user_profile_id;
				$user_profile->school_id = $schools->id;
				$user_profile->first_name = $data->first_name;
				$user_profile->date_of_birth = $data->date_of_birth;
				$user_profile->last_name = $data->last_name;
				$user_profile->other_name = $data->other_name;
				$user_profile->gender = $data->gender;
				if ($staff == null) {
					$user_profile->email = $data->email;
				}
				$user_profile->phone = $data->phone;
				$user_profile->address_line1 = $data->address_line1;
				$user_profile->address_line2 = $data->address_Line2;
				$user_profile->state_of_origin_lga_id = $data->lga_id;
				$user_profile->resident_state_id = $data->resident_state_id;
				$user_profile->save();
				
				$synctracker = $synctracker->createNewSyncTracker($action, $schools, 'UserProfiles', $user_profile_id);
				

				//upload the signature and passport if exist
				$passport_databank_id = null;
				if ($staff != null) {
					$passport_databank_id = $staff->passport_data_bank_id;
				}
				//Move the temporal file to appropriate location
				$tmp_file = Session::get('staff_passport');

				if (file_exists($tmp_file) && !is_dir($tmp_file)) {
					$destination = '/files/passport/' . $schools->id . '/';
					if (!is_dir('files/passport/' . $schools->id . '/')) {
						mkdir('files/passport/' . $schools->id . '/', 0777, true);
					}
					$name = Session::get('staff_passport_name');
					
					if (copy($tmp_file, public_path() . $destination . $name)) {
						$pId = primary_key();
						$passport_databank_id = $pId;
						$data_bank = new DataBanks();
						$data_bank->id = $passport_databank_id;
						$data_bank->file_name = $name;
						$data_bank->file_url = $destination;
						$data_bank->file_path = $destination;
						if ($data_bank->save()) {
							@unlink($tmp_file);
							$synctracker = $synctracker->createNewSyncTracker(1, $schools, 'DataBanks', $pId);
							$synctracker = $synctracker->createNewSyncTracker(1, $schools, 'FILES', '/files/passport/' . $schools->id . '/'.$data_bank->file_name);
							Session::remove('staff_passport');
							Session::remove('staff_passport_name');
						}
						
					}
				}

				$signature_databank_id = null;
				if ($staff != null) {
					$signature_databank_id = $staff->signature_data_bank_id;
				}
				$tmp_file = Session::get('staff_signature');
				if (file_exists($tmp_file) && !is_dir($tmp_file)) {
					$destination = '/files/signature/' . $schools->id . '/';
					if (!is_dir('files/signature/' . $schools->id . '/')) {
						mkdir('files/signature/' . $schools->id . '/', 0777, true);
					}
					$name = Session::get('staff_signature_name');
					if (copy($tmp_file, public_path() . $destination . $name)) {
						$pId = primary_key();
						$signature_databank_id = $pId;
						$data_bank = new DataBanks();
						$data_bank->id = $signature_databank_id;
						$data_bank->file_name = $name;
						$data_bank->file_url = $destination;
						$data_bank->file_path = $destination;
						if ($data_bank->save()) {
							@unlink($tmp_file);
							$synctracker = $synctracker->createNewSyncTracker(1, $schools, 'DataBanks', $pId);
							$synctracker = $synctracker->createNewSyncTracker(1, $schools, 'FILES', '/files/signature/' . $schools->id . '/'.$data_bank->file_name);
							Session::remove('staff_signature');
							Session::remove('staff_signature_name');
							
						}
					}
				}

				$pId = primary_key();
				$user_id = $pId;
				$user_value = null;
				$activation_token = str_random(30);
				$status = 'Active';
				$activationLink = NULL;
				//if ($data->create_account == "true") {
				if ($staff == null) {
					if (strtolower($schools->setup_type) == "online") {
						$user = new User();
						$user->id = $user_id;
						$user->user_profile_id = $user_profile_id;
						$user->username = $data->email;
						$user->password = Hash::make($password);
						$user->role_code = Roles::$ROLE_SKU_STAFF;
						$user->status = $status;
						$user->first_time_login = 'YES';
						$user->school_id = $schools->id;
						$user->save();
						$synctracker = $synctracker->createNewSyncTracker(1, $schools, 'User', $pId);
						$activationLink = "http://" . $domain . '.' . env('DOMAIN_NAME') . "/first-login/?verify_code=" . $activation_token;
						send_mail('email.signup', $data->email, $data->last_name . ' ' . $data->first_name, 'Staff Account Profile', compact('activationLink'));
					} elseif (strtolower($schools->setup_type) == "offline") {
						//send the user a password reset option
						$user = new User();
						$user->id = $user_id;
						$user->user_profile_id = $user_profile_id;
						$user->username = $data->email;
						$user->role_code = Roles::$ROLE_SKU_STAFF;
						$user->password = Hash::make($password);
						$password = $password;
						$user->status = 'Active';
						$user->first_time_login = 'YES';
						$user->activation_token = $activation_token;
						$user->school_id = $schools->id;
						$user->save();
						$synctracker = $synctracker->createNewSyncTracker(1, $schools, 'User', $pId);
						//send the user a reset password token
						
					}
					elseif (strtolower($schools->setup_type) == "both") {
						//send the user a password reset option
						$user = new User();
						$user->id = $user_id;
						$user->user_profile_id = $user_profile_id;
						$user->username = $data->email;
						$user->role_code = Roles::$ROLE_SKU_STAFF;
						//dd($data);
						if(env('SYSTEM_MODE')=="0")
						{
							$user->password = Hash::make($password);
							$password = $password;
						}else
						{
							$user->password = Hash::make($password);
							$password = $password;
						}
						$user->status = 'Active';
						$user->first_time_login = 'YES';
						$user->activation_token = $activation_token;
						$user->school_id = $schools->id;
						$user->save();
						$synctracker = $synctracker->createNewSyncTracker(1, $schools, 'User', $pId);
						//send the user a reset password token
						
					}
				//}
				}

				//Save staff record
				$action = NULL;
				if ($staff == null) {
					$school_staff_id = primary_key();
					$school_staff = new SchoolStaff();
					$action = 1;
					$school_staff->staff_type = $data->staff_type;
				} else {
					$school_staff_id = $staff->id;
					$school_staff = SchoolStaff::find($school_staff_id);
					$action = 2;
				}

				$school_staff->id = $school_staff_id;
				$school_staff->school_id = $schools->id;
				$school_staff->user_profile_id = $user_profile_id;
				//if ($data->create_account == "true") {
				if ($staff == null) {
					$school_staff->user_id = $user_id;
				}
				//}
				$school_staff->signature_data_bank_id = $signature_databank_id;
				$school_staff->passport_data_bank_id = $passport_databank_id;
				$school_staff->employment_date = $data->employment_date;
				$school_staff->job_title = $data->job_title;
				$school_staff->status = 'Active';
				$school_staff->staff_id = $data->staff_id;
				$school_staff->national_id = $data->national_id;
				$school_staff->email_alt = $data->email_alt;
				$school_staff->phone_alt = $data->phone_alt;
				$school_staff->marital_status = $data->marital_status;
				$school_staff->save();
				$synctracker = $synctracker->createNewSyncTracker($action, $schools, 'SchoolStaff', $school_staff_id);


				//create the staff academic history

				if(isset($data->staff_two_b))
				{
					$emp1 = $data->staff_two_b;
					
					
					foreach($emp1 as $emp)
					{
					
						$emp_id = primary_key();
						$employmet = new StaffEmploymentHistory();
						$employmet->id = $emp_id;
		
		
						//dd($emp);
						/*$emp = (array)$data;
						
						if ($staff != null && count($staff->employment_histories) != 0 && isset($staff->employment_histories[$i - 1])) {
							$emp_id = $staff->employment_histories[$i - 1]->id;
							$employmet = StaffEmploymentHistory::find($emp_id);
						} else {
							$employmet = new StaffEmploymentHistory();
							$employmet->id = $emp_id;
						}
						
						$x=$i;
						if($i>1)
						{
							$x = '1'.$i;
						}*/
						$employmet->school_id = $schools->id;
						$employmet->school_staff_id = $school_staff_id;
						$employmet->employer_name = $emp['employer_name1'];
						$employmet->employment_period = $emp['employment_period1'];
						$employmet->employment_period_ends = $emp['employment_period_end1'];
						$employmet->employer_address1 = $emp['employer_address11'];
						$employmet->employer_address2 = $emp['employer_address21'];
						$employmet->employmentPosition = $emp['employment_position1'];
						$employmet->save();
						$school_staff->employment_period_ends = $employmet->employment_period_ends;
						$school_staff->save();
						$synctracker = $synctracker->createNewSyncTracker(1, $schools, 'StaffEmploymentHistory', $emp_id);
					}
				}
				
				



				if(isset($data->staff_two))
				{
					//create the staff academic history
					$emp1 = $data->staff_two;
					
					foreach($emp1 as $emp){
						//dd($emp);
						$aca_id = primary_key(); 
						$academ = new StaffAcademicHistory;
						$academ->id = $aca_id;
						/*if ($staff != null && count($staff->academic_histories) != 0 && isset($staff->academic_histories[$i - 1])) {
							$aca_id = $staff->academic_histories[$i - 1]->id;
							$academ = StaffAcademicHistory::find($aca_id);
						} else {
						   
						}
						
						$x=$i;
						if($i>1)
						{
							$x = '1'.$i;
						}*/
						$academ->school_id = $schools->id;
						$academ->school_staff_id = $school_staff_id;
						$academ->issuing_body = $emp['issuing_body1'];
						$academ->qualification_title = $emp['qualification_title1'];
						$academ->expired_on = $emp['expires_on1'];
						$academ->grade = $emp['grade1'];
						$academ->year = $emp['year1'];
						$academ->save();
						$synctracker = $synctracker->createNewSyncTracker(1, $schools, 'StaffAcademicHistory', $aca_id);
					}
				}
				DB::commit();
				$name = $user_profile->first_name." ".$user_profile->last_name;
				
				$username = $user_profile->email;
				
				$msg = urlencode("New Staff Details. Staff Id: ".$data->staff_id." | Staff Name: ".$data->first_name." ".$data->last_name);
				
				//dd($schools->mobileCode);
				$snd = send_sms($data->phone, $msg,$schools);
				$this->clearSavedData($this->steps);
				return $school_staff;
			} catch (\Exception $e) {
				//dd($e->getMessage());
				DB::rollback();
				return NULL;
			}
    }
	
	
	
	
	
	
	


}