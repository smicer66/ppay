<?php

namespace App\Http\Controllers\Saas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\StepOneRequest;
use App\Http\Requests\Staff\StepTwoRequest;
use App\Models\Applicants;
use App\Models\Classes;
use App\Models\Countries;
use App\Models\DataBanks;
use App\Models\Lga;
use App\Models\Roles;
use App\Models\Students;
use App\Models\User;
use App\Models\SchoolStaff;
use App\Models\States;
use App\Http\Requests;
use App\Models\Parents;
use App\Utilities\SetupSteps;
use Session;
use Input;
use DB;

class UserController extends Controller
{
    private $staff_one = "staff_one";
    private $staff_two = "staff_two";
    private $staff_two_b = "staff_two_b";
    private $staff_two_b1 = "staff_two_b1";
    private $staff_three = "staff_three";
    private $staff_four = "staff_four";

    private $step_setup = null;

    public function __construct()
    {
        parent::__construct();
        $this->step_setup = new SetupSteps(explode(':::', 'staff_one:::staff_two:::staff_two_b:::staff_two_b1:::staff_three:::staff_four'));
    }

    public function getIndex()
    {
        $staffs = SchoolStaff::where('school_id', $this->school->id);
        return view('saas.user.index', compact('staffs'));
    }

    public function getCreate()
    {
        return redirect('/admin/user/step-one');
    }

    public function getStepOne()
    {
		
        $states[null] = 'Select a State';
        foreach (States::orderBy('name')->get() as $sub) {
            $states[$sub->id] = $sub->name;
        }
        $lgas[null] = 'Select LGA';
        return view('saas.user.step_one', compact('states', 'lgas', 'countries'));
    }

	public function getAdminUser($domain)
	{
		$staffs = \App\Models\User::where('school_id', '=', $this->school->id)->where(function($x){
			$x->where('role_code', '=', \App\Models\Roles::$ROLE_HELP_DESK)
					->orWhere('role_code', '=', \App\Models\Roles::$ROLE_SCHOOL_ACCOUNTANT)
					->orWhere('role_code', '=', \App\Models\Roles::$ROLE_SCHOOL_HR_ADMIN);
		})->with('user_profile');
        return view('saas.user.index_admin', compact('staffs'));
	}

	public function postStepOneAdmin($domain)
	{
		$rules = array();
		$messages = array();
		
		$inputAll = \Input::all();

		if(!in_array('staffid', array_keys($inputAll)))
		{
			$rules['staff_type'] = 'required';
			$rules['email'] = 'required';
			$messages['staff_type.required'] = 'Admin Type is required';
			$messages['email.required'] = 'Email Address is required';
		}
		$rules['last_name'] = 'required';
		$rules['first_name'] = 'required';
		$rules['address_line1'] = 'required';
		$rules['phone'] = 'required';
		
		
		$messages['last_name.required'] = 'Last Name is required';
		$messages['first_name.required'] = 'First Name is required';
		$messages['address_line1.required'] = 'Address Line 1 is required';
		$messages['phone.required'] = 'Phone Number is required';
		
		$input = \Input::all();
		
		$validator = \Validator::make(\Input::all(), $rules, $messages);
		if ($validator->fails()) {
			return back()->with('input', $input)->with('errors', $validator->errors());
		}
		
		if(!in_array('staffid', array_keys($inputAll)))
		{
			$uscheck = \App\Models\User::where('username', '=', $input['email']);
			if($uscheck->count()>0)
			{
				return back()->with('input', $input)->with('error', "Invalid Email Address Provided. This email address has already been taken up by another user.");
			}
		}
  		
  		$userProf = NULL;
		$action = NULL;
		$msg = NULL;
		$password = '';
		if(!in_array('staffid', array_keys($inputAll)))
		{
			$userProf = new \App\Models\UserProfiles();
			$id = primary_key();
			$userProf->id = $id;
			$userProf->email = $input['email'];		
			$userProf->school_id = $this->school->id;	
			$action = 0;
			$msg = 'New Admin User Account Created Successfully. Password of the new admin account created is ';
		}else
		{
			$decryptedStaff = \Crypt::decrypt($inputAll['staffid']);
			$userProf = $decryptedStaff->user_profile;
			$id = $userProf->id;
			$action = 1;
			$msg = 'Admin User Account Updated Successfully!';
		}
		$userProf->address_line1 = $input['address_line1'];
		$userProf->address_line2 = $input['address_Line2'];
		$userProf->address_state_id = $input['resident_state_id'];
		$userProf->city = $input['resident_city'];
		$userProf->first_name = $input['first_name'];
		$userProf->last_name = $input['last_name'];
		$userProf->other_name = $input['other_name'];
		$userProf->phone = $input['phone'];
		$userProf->gender = $input['gender'];
		$userProf->date_of_birth = $input['date_of_birth'];
		$userProf->resident_state_id = $input['resident_state_id'];
		$userProf->state_of_origin_lga_id = $input['lga_id'];
		$userProf->save();

		$synctracker = new \App\Models\Synctracker();
		$synctracker = $synctracker->createNewSyncTracker($action, $this->school, 'UserProfiles', $id);
		
		if(!in_array('staffid', array_keys($inputAll)))
		{
			$usr = new \App\Models\User();
			$verifyCode = str_random(7);
			$password = env('DEFAULT_PASSWORD');
			$id1 = primary_key();
			$usr->id = $id1;
			$usr->username = $input['email'];
			$usr->password = \Hash::make($password);
			$usr->user_profile_id = $id;
			$usr->status = 'Active';
			$usr->school_id = $this->school->id;
			$usr->role_code = $input['staff_type'];
			$usr->first_time_login = 'NO';
			$usr->activation_token = $verifyCode;
			$usr->save();
			
			$msg = urlencode("New Admin Details. Email: ".$input['email']." Password: ".$password);
			$snd = send_sms($input['phone'], $msg, $this->school);
			
			
			$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'User', $id1);
			\Session::flash('message', 'New Admin User Account Created Successfully - The password for the new account created is '.$password);
		}
		//$activationLink = "http://" . env('DOMAIN_NAME') . "/auth/verify/?verify_code=" . $verifyCode;
		if (strtolower($this->school->setup_type) == "online") {
			
			send_mail('email.signup', $input['email'], $input['last_name'] . ' ' . $input['first_name'], 
				'Admin Account Profile', 
				['first_name' => $input['first_name']]
				);
		}elseif (strtolower($this->school->setup_type) == "offline") {
			
		}elseif (strtolower($this->school->setup_type) == "both") {
			//if(env('SYSTEM_MODE')==1)
			
				send_mail('email.signup', $input['email'], $input['last_name'] . ' ' . $input['first_name'], 
					'New School Admin Account Profile', 
					['first_name' => $input['first_name']]
					);
				
		}
		if(!in_array('staffid', array_keys($inputAll)))
		{
			return redirect('/admin/user/create-admin')->with('message', $msg.$password);
		}
		else
		{
			return redirect('/users/profile')->with('message', $msg.$password);
		}
			
	}
	
	
	public function postUpdateStudent()
	{
	
		$userProf = \Crypt::decrypt(\Input::get('userProf'));
		$guards = \Crypt::decrypt(\Input::get('guards'));
		$passport = (\Input::get('passport'));
		$userProf->save();
		$i=0;
		foreach($guards as $guard)
		{
			$guard->id = primary_key()."".$i++;
			$guard->save();
		}
		
		
		if($passport!=NULL)
		{
			$id = primary_key();
			$user = \App\Models\User::where('user_profile_id', '=', $userProf->id)->first();
			$student = \App\Models\Students::where('user_id', '=', $user->id)->first();
			$dbp = new \App\Models\DataBanks();
			$dbp->id = $id;
			$dbp->file_name = $passport;
			$dbp->file_path = 'files/passports/'.$this->school->id.'/';
			$dbp->file_url = 'files/passports/'.$this->school->id.'/';
			if($dbp->save())
			{
				$student->data_bank_passport_id = $id;
				$student->save();
			}
		}
		
		if(\Auth::user()->role_code!=\App\Models\Roles::$ROLE_HELP_DESK)
		{
			return redirect('/users/profile')->with('message', 'User Account updated successfully');
		}else
		{
			return redirect('/admin/user/students')->with('message', 'User Account updated successfully');
		}
		
	}
	
	
	
    public function postStepOne($domain, StepOneRequest $request)
    {
		$usr = NULL;
		Session::remove('staff_passport');
		Session::remove('staff_passport_name');
		$sess = $this->step_setup->getSavedData();
		$rules = array();
		$messages = array();

		
		$inputAll = \Input::all();

		if(!in_array('staffid', array_keys($inputAll)))
		{
			$rules['staff_type'] = 'required';
			$rules['email'] = 'required';
			$messages['staff_type.required'] = 'Staff Type is required';
			$messages['email.required'] = 'Email Address is required';
			$rules['staff_id'] = 'required';
			$messages['staff_id.required'] = 'Staff Id must be provided. Staff Ids are unique in your school';
			if (isset($sess['id']))
			{
			}else
			{
				$usr = \App\Models\User::where('username', '=', Input::get('email'))->where('school_id', '=', $this->school->id);
			}
		}
		$rules['last_name'] = 'required';
		$rules['first_name'] = 'required';
		$rules['address_line1'] = 'required';
		$rules['phone'] = 'required';
		$rules['gender'] = 'required';
		$rules['job_title'] = 'required';
		$rules['date_of_birth'] = 'required';
		$rules['state_id'] = 'required';
		$rules['lga_id'] = 'required';
		$rules['national_id'] = 'required';
		
		
		$messages['last_name.required'] = 'Last Name is required';
		$messages['first_name.required'] = 'First Name is required';
		$messages['address_line1.required'] = 'Address Line 1 is required';
		$messages['phone.required'] = 'Phone Number is required';
		$messages['gender.required'] = 'Gender is required';
		$messages['job_title'] = 'Job Title is required';
		$messages['date_of_birth'] = 'Date of Birth is required';
		$messages['state_id'] = 'State of Origin is required';
		$messages['lga_id'] = 'Local Govt Area is required';
		$messages['national_id'] = 'National ID Number or Passport number is required';
		
		$input = \Input::all();
		$validator = \Validator::make(\Input::all(), $rules, $messages);
		if ($validator->fails()) {
			return back()->withInput()->with('errors', $validator->errors());
		}
		
		
		if(!in_array('staffid', array_keys($inputAll)))
		{
			$uscheck = \App\Models\User::where('username', '=', $input['email']);
			if($uscheck->count()>0)
			{
				return back()->with('input', $input)->with('error', "Invalid Email Address Provided. This email address has already been taken up by another user.");
			}
		}
		
			
		if($usr==NULL || ($usr!=NULL && $usr->count()==0))
		{
			try {
				if (Input::hasFile('passport_file')) {
					$file = Input::file('passport_file');
					$file_name = str_random(25) . '.' . $file->getClientOriginalExtension();
					$dest = 'tmp/passport/';
					$file->move($dest, $file_name);
					Session::remove('staff_passport');
					Session::remove('staff_passport_name');
					Session::put('staff_passport', $dest . $file_name);
					Session::put('staff_passport_name', $file_name);
				}else{
					$snapshotimage = $input['snapshotimage'];
					Session::remove('staff_passport');
					Session::remove('staff_passport_name');
					Session::put('staff_passport', 'tmp/'.$snapshotimage);
					Session::put('staff_passport_name', $snapshotimage);
				}
				
				
				if (Input::hasFile('signature_file')) {
					$file = Input::file('signature_file');
					$file_name = str_random(25) . '.' . $file->getClientOriginalExtension();
					$dest = 'tmp/passport/';
					$file->move($dest, $file_name);
					Session::remove('staff_signature');
					Session::remove('staff_signature_name');
					Session::put('staff_signature', $dest . $file_name);
					Session::put('staff_signature_name', $file_name);
				}
	
				$input = $request->all();
				if (isset($input['_token']))
					unset($input['_token']);
				unset($input['passport_file']);
				unset($input['signature_file']);
				$this->step_setup->saveTemp($this->staff_one, $input);
				$sess = $this->step_setup->getSavedData();
				if (isset($sess['id']))
				{
					$url = '/admin/user/edit-staff-two/' . $sess['id'];
				}
				else
					$url = '/admin/user/step-two/';
				return redirect($url);
			} catch (\Exception $e) {
				return back()->withInput()->with('error', 'Form cannot be submitted, please check your input.');
			}
		}else
		{
			return back()->withInput()->with('error', 'The email address provided has already been used by someone else in your school. Provide another email address to proceed with creating an account.');
		}
    }
	
	

    private function check_session()
    {
        $d = $this->step_setup->getSavedData();
        return ($d == null || count($d) <= 0);
    }

    public function getStepTwo()
    {
        if ($this->check_session()) {
            return redirect('/admin/user/step-one')->with('message', 'Registration timed out. Please start over again');
        }
        $states[null] = 'Select a State';
        foreach (States::orderBy('name')->get() as $sub) {
            $states[$sub->id] = $sub->name;
        }
		
		$data = $this->step_setup->getSavedData();
		
		$quals = NULL;
		if(array_key_exists($this->staff_two, $data))
		{
			$quals = $data[$this->staff_two];
		}
		//dd($quals);
        return view('saas.user.step_two', compact('states', 'quals'));
    }

    public function postStepTwo($domain, StepTwoRequest $request)
    {

		if(\Input::get('actionType')==1)
		{
			$rules = [];
			$input = $request->all();
			$number_of_elements = $request->get('num_of_academic');
			$messages = [];
			$key = ['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth'];
			
			$rules['qualification_title1'] = 'required';
			$rules['grade1'] = 'required';
//			$rules['expires_on1'] = 'required';
	
			$messages['qualification_title1.required'] =  'Qualification title must be provided.';
			$messages['grade1.required'] = 'Grade must be provided.';
//			$messages['expires_on1.required'] = 'Expiration Date must be provided.';
				
				
			/*for ($i = 2; $i <= $number_of_elements; $i++) {
				$rules['qualification_title1' . $i] = 'required';
				$rules['grade1' . $i] = 'required';
				$rules['year1' . $i] = 'required';
	
				$messages['qualification_title1' . $i . '.required'] = $key[($i - 1)] . ' qualification title must be provided.';
				$messages['grade1' . $i . '.required'] = $key[($i - 1)] . ' grade must be provided.';
				$messages['year1' . $i .'.required'] = $key[($i - 1)] . 'academic year must be provided.';
			}*/
			
	
			/*$number_of_elements = $request->get('num_of_employment');
			$key = ['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth'];
			
			$rules['employer_name1'] = 'required';
			$rules['employment_period1'] = 'required';
	
			$messages['employer_name1'. '.required'] = $key[($i - 1)] . ' employer name must be provided';
			$messages['employment_period1.required'] = $key[($i - 1)] . ' employment period must be provided.';
				
			for ($i = 1; $i <= $number_of_elements; $i++) {
			   // $rules['employer_name1' . $i] = 'required';
			   // $rules['employment_period1' . $i] = 'required';
	
			   // $messages['employer_name1' . $i . '.required'] = $key[($i - 1)] . ' employer name must be provided';
			   // $messages['employment_period1' . $i.'.required'] = $key[($i - 1)] . ' employment period must be provided.';
			}*/
			
	
			$validator = \Validator::make(\Input::all(), $rules, $messages);
			if ($validator->fails()) {
				return back()->with('input', $input)->with('errors', $validator->errors());
			}
			if (isset($input['_token'])) unset($input['_token']);
			
			
			$array = array();
			$data = $this->step_setup->getSavedData();

			if(array_key_exists($this->staff_two, $data))
			{
				$data1 = $data[$this->staff_two];
				array_push($data1, $input);
				$data[$this->staff_two] = $data1;
				$input = $data;
			}
			else
			{
				array_push($array, $input);
				$data[$this->staff_two] = $array;
				$input = $data;
			}
			
			$this->step_setup->saveTemp($this->staff_two, $input);
			$sess = $this->step_setup->getSavedData();
			//dd($sess);
			
	
			if (isset($sess['id']))
				$url = '/admin/user/edit-staff-two/' . $sess['id'];
			else
				$url = '/admin/user/step-two/';
			return redirect($url);
		}
		else
		{
			$sess = $this->step_setup->getSavedData();
			if (isset($sess['id']))
				$url = '/admin/user/edit-employment-history/' . $sess['id'];
			else
				$url = '/admin/user/employment-history/';
			return redirect($url);
		}
        
    }
	
	
	
	public function postStepTwoB($domain, StepTwoRequest $request)
    {
		//dd(\Input::all());
		if(\Input::get('actionType')==1)
		{
			$rules = [];
			$input = $request->all();
			$number_of_elements = $request->get('num_of_academic');
			$messages = [];
			$key = ['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth'];
			
			$rules['employer_name1'] = 'required';
			$rules['employment_period1'] = 'required';
			$rules['employment_position1'] = 'required';
	
			$messages['employer_name1.required'] = 'Employer name must be provided';
			$messages['employment_period1.required'] = 'Employment period must be provided.';
			$messages['employment_position1'] = 'Position of employment must be provided';
			
			
				
			
			$validator = \Validator::make(\Input::all(), $rules, $messages);
			if ($validator->fails()) {
				return back()->with('input', $input)->with('errors', $validator->errors());
			}
			if (isset($input['_token'])) unset($input['_token']);
			
			
			$array = array();
			$data = $this->step_setup->getSavedData();

			if(array_key_exists($this->staff_two_b, $data))
			{
				$data1 = $data[$this->staff_two_b];
				array_push($data1, $input);
				$data[$this->staff_two_b] = $data1;
				$input = $data;
			}
			else
			{
				array_push($array, $input);
				$data[$this->staff_two_b] = $array;
				$input = $data;
			}
			
			$this->step_setup->saveTemp($this->staff_two_b, $input);
			
			
						
			
			
	
			if (isset($sess['id']))
				$url = '/admin/user/edit-staff-two/' . $sess['id'];
			else
				$url = '/admin/user/employment-history/';
			return redirect($url);
		}
		else
		{
			$rules = array();
			$messages = array();
			if(strtolower($this->school->setup_type)=='online')
			{
			
			}else if(strtolower($this->school->setup_type)=='offline')
			{
				$rules['password'] = 'required';
				$rules['confirm_password'] = 'required|same:password';
				$messages['password'] = 'required';
				$messages['confirm_password'] = 'required';
			}else if(strtolower($this->school->setup_type)=='both')
			{
				if(env('SYSTEM_MODE')==1)
				{
						
				}else
				{
					$rules['password'] = 'required';
					$rules['confirm_password'] = 'required|same:password';
					$messages['password.required'] = 'You must provide a password for the user';
					$messages['confirm_password.required'] = 'You must retype the password you provided for the yuser in the password confirmation field';
					$messages['confirm_password.same'] = 'Your confirmation password must match the password you provided';
				}
			}
			
			if(strtolower($this->school->setup_type)=='online'){
			
			}else if(strtolower($this->school->setup_type)=='offline')
			{
				$d['password'] = $request->get('password');
				$this->step_setup->saveTemp($this->staff_two_b1, $d);
			}else if(strtolower($this->school->setup_type)=='both')
			{
				if(env('SYSTEM_MODE')==1)
				{
						
				}else
				{
					$d['password'] = $request->get('password');
					$this->step_setup->saveTemp($this->staff_two_b1, $d);
				}
			}
			
			$validator = \Validator::make(\Input::all(), $rules, $messages);
			if ($validator->fails()) {
				return back()->with('input', \Input::all())->with('errors', $validator->errors());
			}
			
			
			$sess = $this->step_setup->getSavedData();
			
			if (isset($sess['id']))	
				$url = '/admin/user/edit-step-three/'. $sess['id'];
			else
				$url = '/admin/user/step-three/';
			return redirect($url);
		}
        
    }
	
	
	public function getEmploymentHistory($domain)
	{
		$states[null] = 'Select a State';
		
        foreach (States::orderBy('name')->get() as $sub) {
            $states[$sub->id] = $sub->name;
        }
		
		$data = $this->step_setup->getSavedData();
		
		$quals = NULL;
		if(array_key_exists($this->staff_two_b, $data))
		{
			$quals = $data[$this->staff_two_b];
		}
		//dd($quals);
        return view('saas.user.step_two_b', compact('states', 'quals'));
	}
	
	
	public function getEditEmploymentHistory($domain, $id)
	{
		$states[null] = 'Select a State';
        foreach (States::orderBy('name')->get() as $sub) {
            $states[$sub->id] = $sub->name;
        }
		
		$data = $this->step_setup->getSavedData();
		$staff = SchoolStaff::with(['user_profile', 'academic_histories', 'employment_histories'])->find($id);
		
		
		$quals = NULL;
		if(array_key_exists($this->staff_two_b, $data))
		{
			$quals = $data[$this->staff_two_b];
		}
		//dd($quals);
        return view('saas.user.step_two_b', compact('states', 'quals', 'staff'));
	}

    public function getEditStaffThree($domain, $id)
    {
        $data = null;
        if (count($this->step_setup->getSavedData()) <= 0) {
            return redirect('/admin/user/step-one')->with('error', 'Registration timed out. Please start over again');
        }
        $passport = '/' . Session::get('staff_passport');
        $staff_signature = '/' . Session::get('staff_signature');
        $data = $this->step_setup->getSavedData();
        $staff = SchoolStaff::with(['user_profile'])->find($id);
        return view('saas.user.step_three', compact('passport', 'data', 'staff_signature', 'staff'));
    }

    public function getStepThree($domain, $id=NULL)
    {
        $data = null;
        if (count($this->step_setup->getSavedData()) <= 0) {
            return redirect('/admin/user/step-one')->with('error', 'Registration timed out. Please start over again');
        }
        $passport = '/' . (Session::get('staff_passport')!=NULL ? Session::get('staff_passport') : "photos/member1.png");

        $staff_signature = '/' . Session::get('staff_signature');
        $data = $this->step_setup->getSavedData();
		//dd($data);
        return view('saas.user.step_three', compact('passport', 'data', 'staff_signature'));
    }
	
	
	public function getEditStepThree($domain, $id=NULL)
    {
        $data = null;
        if (count($this->step_setup->getSavedData()) <= 0) {
            return redirect('/admin/user/step-one')->with('error', 'Registration timed out. Please start over again');
        }
        $data = $this->step_setup->getSavedData();

		$staff = SchoolStaff::with(['user_profile', 'academic_histories', 'employment_histories', 'passport', 'signature'])->find($id);
		//dd($staff);
        $passport = '/' . (Session::get('staff_passport')!=NULL ? Session::get('staff_passport') : "photos/member1.png");
        $staff_signature = (Session::get('staff_signature')!=NULL) ? Session::get('staff_signature') : ($staff->signature!=NULL && $staff->signature->file_path!=NULL ? $staff->signature->file_path."".$staff->signature->file_name : "" );
		//Session::remove('staff_signature_name');
		//Session::remove('staff_signature');
//		dd($staff->passport->file_path);
		if(Session::get('staff_passport')!=NULL)
			$passport = Session::get('staff_passport');
		else
			if($staff->passport!=NULL && $staff->passport->file_path!=NULL)
				$passport = $staff->passport->file_path."".$staff->passport->file_name;
				
				
		if(Session::get('staff_signature')!=NULL)
			$staff_signature = Session::get('staff_signature');
		else
			if($staff->signature!=NULL && $staff->signature->file_path!=NULL)
				$staff_signature = $staff->signature->file_path."".$staff->signature->file_name;
				
			
			
		//dd($staff_signature);
		//dd($data);
        return view('saas.user.step_three', compact('passport', 'data', 'staff_signature','id', 'staff'));
    }



	public function getDeleteQual($domain, $id, $type=NULL)
	{
		if($type==NULL)
		{
			$id = \Crypt::decrypt($id);
			$data = $this->step_setup->getSavedData();
	
			$data1 = $data[$this->staff_two];
			//dd($data1);
			$arrayNew = array();
			for($i=0; $i<sizeof($data1); $i++)
			{
				if($i!=$id)
					array_push($arrayNew, $data1[$i]);
			}
			$data[$this->staff_two] = $arrayNew;
			//dd($data);
			$this->step_setup->saveTemp($this->staff_two, $data);
	//		dd($this->step_setup->getSavedData());
		}
		else
		{
			/*$id = \Crypt::decrypt($id);
			$acadHist = \App\Models\StaffAcademicHistory::where('id', '=', $id)->first();
			$acadHist->delete();*/
			$id = \Crypt::decrypt($id);
			$acadHist = \App\Models\StaffAcademicHistory::where('id', '=', $id)->first();
			$acadHist->delete();
		}
		return back();
	}
	
	
	public function getDeleteHistory($domain, $id, $type=NULL)
	{
		if($type==NULL)
		{
			$id = \Crypt::decrypt($id);
			$data = $this->step_setup->getSavedData();
	
			$data1 = $data[$this->staff_two_b];

			//dd($data1);
			$arrayNew = array();
			for($i=0; $i<sizeof($data1); $i++)
			{
				if($i!=$id)
					array_push($arrayNew, $data1[$i]);
			}
			$data[$this->staff_two_b] = $arrayNew;
			//dd($data);
			$this->step_setup->saveTemp($this->staff_two_b, $data);
	//		dd($this->step_setup->getSavedData());
		}
		else
		{
			/*$id = \Crypt::decrypt($id);
			$acadHist = \App\Models\StaffAcademicHistory::where('id', '=', $id)->first();
			$acadHist->delete();*/
			$id = \Crypt::decrypt($id);
			$acadHist = \App\Models\StaffEmploymentHistory::where('id', '=', $id)->first();
			//dd($acadHist);
			$acadHist->delete();
		}
		return back();
	}

    public function postStepThree($schl_domain, $id=NULL)
    {
		$old_staff = \App\Models\SchoolStaff::where('id', '=', $id)->first();
		$staff = NULL;
		if($old_staff!=NULL)
			$staff = $this->step_setup->createStaff($schl_domain, $this->school);
		else
			$staff = $this->step_setup->createStaff($schl_domain, $this->school);
		
		$url = '/admin/user';
		if(\Auth::user()->role_code == 'SKU_STAFF')
			$url = '/users/profile';
			
        if (!is_null($staff)) {
			if($id!=NULL)
				return redirect($url)->with('message', 'Staff account saved successfully');
			else
            	return redirect($url)->with('message', 'Staff account created successfully');
        } else {
            return back()->with('error', 'Unable to process request, please try again later');
        }
    }
	
	
	function getCreateAdmin($domain, $id=NULL)
	{
		$states[null] = 'Select a State';
        foreach (States::orderBy('name')->get() as $sub) {
            $states[$sub->id] = $sub->name;
        }
        $lgas[null] = 'Select LGA';
        return view('saas.user.step_one_admin', compact('states', 'lgas', 'countries'));
	}

    function getChangeStaffStatus($domain, $id, $status)
    {
        $staff = SchoolStaff::find($id);
        $status = ucfirst($status);
        $resp = false;
		$synctracker = new \App\Models\Synctracker();
		//$synctracker = $synctracker->createNewSyncTracker(0, $schools, 'UserProfiles', $usrId);
        //$s = User::find($staff->user_id);
		$schools = $this->school;
        switch ($status) {
            case 'Delete':
                $staff->delete();
				$usr = \App\Models\User::where('id', '=', $staff->user_id)->first();
				$usrId = $usr->id;
				$usrPId = $usr->user_profile_id;
				$usr->delete();
                $resp = true;
				$synctracker = $synctracker->createNewSyncTracker(0, $schools, 'User', $usrId);
				$synctracker = $synctracker->createNewSyncTracker(0, $schools, 'SchoolStaff', $id);
				$synctracker = $synctracker->createNewSyncTracker(0, $schools, 'UserProfiles', $usrPId);
                break;
            case 'Inactive':
				$staff->status = $status;
                $staff->save();
				$usr = \App\Models\User::where('id', '=', $staff->user_id)->first();
				if($usr!=null)
				{
					$usr->status = 'Blocked';
					$usr->save();
				}
                $resp = true;
				$synctracker = $synctracker->createNewSyncTracker(2, $schools, 'SchoolStaff', $id);
				$synctracker = $synctracker->createNewSyncTracker(2, $schools, 'UserProfiles', $usr==null ? 0 : $usr->id);
                break;
            case 'Active':
                $staff->status = $status;
                $staff->save();
				$usr = \App\Models\User::where('id', '=', $staff->user_id)->first();
				if($usr!=null)
				{
					$usr->status = 'Active';
					$usr->save();
				}
                $resp = true;
				$synctracker = $synctracker->createNewSyncTracker(2, $schools, 'SchoolStaff', $id);
				$synctracker = $synctracker->createNewSyncTracker(2, $schools, 'UserProfiles', $usr==null ? 0 : $usr->id);
                break;
			case 'Retired':
                $staff->status = $status;
                $staff->save();
				$usr = \App\Models\User::where('id', '=', $staff->user_id)->first();
				if($usr!=null)
				{
					$usr->status = 'Blocked';
					$usr->save();
				}
                $resp = true;
				$synctracker = $synctracker->createNewSyncTracker(2, $schools, 'SchoolStaff', $id);
				$synctracker = $synctracker->createNewSyncTracker(2, $schools, 'UserProfiles', $usr==null ? 0 : $usr->id);
                break;
			case 'Resigned':
                $staff->status = $status;
                $staff->save();
				$usr = \App\Models\User::where('id', '=', $staff->user_id)->first();
				if($usr!=null)
				{
					$usr->status = 'Blocked';
					$usr->save();
				}
                $resp = true;
				$synctracker = $synctracker->createNewSyncTracker(2, $schools, 'SchoolStaff', $id);
				$synctracker = $synctracker->createNewSyncTracker(2, $schools, 'UserProfiles', $usr==null ? 0 : $usr->id);
                break;
            default:
                $resp = false;
                break;

        }
        if ($resp) {
            return redirect('admin/user')->with('message', 'User status has been successfully changed');
        } else {
            return redirect('admin/user')->with('error', 'User status could not be changed');
        }
    }
	
	
	
	
	
	function getChangeAdminStatus($domain, $id, $status)
    {
		$id = \Crypt::decrypt($id);
        $staff = User::find($id);
        $status = ucfirst($status);
        $resp = false;
		$synctracker = new \App\Models\Synctracker();
		//$synctracker = $synctracker->createNewSyncTracker(0, $schools, 'UserProfiles', $usrId);
        //$s = User::find($staff->user_id);
		$schools = $this->school;
        switch ($status) {
            case 'Delete':
                $staff->delete();
				$usrPId = $usr->user_profile_id;
				$usrP = \App\Models\UserProfiles::where('id', '=', $usrPId)->first();
				$usrP->delete();
				$usr->delete();
                $resp = true;
				$synctracker = $synctracker->createNewSyncTracker(0, $schools, 'User', $id);
				$synctracker = $synctracker->createNewSyncTracker(0, $schools, 'UserProfiles', $usrPId);
				$resp = true;
                break;
            case 'Inactive':
				if($staff!=null)
				{
					$staff->status = 'Blocked';
					$staff->save();
				}
                $resp = true;
				$synctracker = $synctracker->createNewSyncTracker(2, $schools, 'User', $id);
                break;
            case 'Active':
                $staff->status = $status;
                $staff->save();
				$resp = true;
				$synctracker = $synctracker->createNewSyncTracker(2, $schools, 'User', $id);
                break;
            default:
                $resp = false;
                break;

        }
        if ($resp) {
            return redirect('/admin/user/admin-user')->with('message', 'User status has been successfully changed');
        } else {
            return redirect('/admin/user/admin-user')->with('error', 'User status could not be changed');
        }
    }

    function getChangeStudentStatus($domain, $id, $status)
    {
		$id = \Crypt::decrypt($id);
		$synctracker = new \App\Models\Synctracker();
		
        $student = Students::find($id);
        $status = ucfirst($status);
        $resp = false;
        $s = User::find($student->user->id);
		
        switch ($status) {
            case 'Delete':
                if ($s != null) {
                    $s->delete();
					$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'User', $s->id);
                }
                $student->delete();
				$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'Student', $student->id);
                $resp = true;
                break;
            case 'Inactive':
				$student->status = $status;
                $s->status = 'Blocked';
                $student->save();
				$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'Students', $student->id);
                $s->save();
				$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'User', $s->id);
                $resp = true;
                break;
            case 'Suspend':
				$student->status = $status;
                $s->status = 'Suspended';
                $student->save();
				$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'Students', $student->id);
                $s->save();
				$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'User', $s->id);
                $resp = true;
                break;
            case 'Active':
                $student->status = $status;
                $s->status = $status;
                $student->save();
				$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'Students', $student->id);
                $s->save();
				$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'User', $s->id);
                $resp = true;
                break;
			case 'Graduated':
                $student->status = $status;
                $s->status = $status;
                $student->save();
				$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'Students', $student->id);
                $s->save();
				$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'User', $s->id);
                $resp = true;
                break;
			case 'Left':
                $student->status = $status;
                $s->status = $status;
                $student->save();
				$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'Students', $student->id);
                $s->save();
				$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'User', $s->id);
                $resp = true;
                break;
            default:
                $resp = true;
                break;
        }
        if ($resp) {
            return redirect('admin/user/students/')->with('message', 'Student status has been successfully changed');
        } else {
            return redirect('admin/user/students/')->with('error', 'Student status could not be changed');
        }
    }
	
	
	function getChangeParentStatus($domain, $id, $status)
    {
		$id = \Crypt::decrypt($id);
		$synctracker = new \App\Models\Synctracker();
		
        $parent = Parents::find($id);
        $status = ucfirst($status);
        $resp = false;
        $s = User::find($parent->user->id);
		
        switch ($status) {
            case 'Delete':
                if ($s != null) {
                    $s->delete();
					$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'User', $s->id);
                }
                $parent->delete();
				$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'Parents', $parent->id);
                $resp = true;
                break;
            case 'Inactive':
				$parent->status = $status;
                $s->status = 'Blocked';
                $parent->save();
				$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'Parents', $parent->id);
                $s->save();
				$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'User', $s->id);
                $resp = true;
                break;
            case 'Active':
                $parent->status = $status;
                $s->status = $status;
                $parent->save();
				$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'Parents', $parent->id);
                $s->save();
				$synctracker = $synctracker->createNewSyncTracker(0, $this->school, 'User', $s->id);
                $resp = true;
                break;
            default:
                $resp = true;
                break;
        }
        if ($resp) {
            return redirect('admin/user/parents/')->with('message', 'Parent status has been successfully changed');
        } else {
            return redirect('admin/user/parents/')->with('error', 'Parent status could not be changed');
        }
    }

    function getStudents()
    {
        $students = Students::with(['user'=>function($x){
			$x->with('user_profile');
		}])->where('school_id', '=', $this->school->id);
        return view('saas.user.students', compact('students'));
    }
	
	
	
	public function getParents()
    {
        $parents = \App\Models\Parents::with(['wards', 'user'=>function($x){
			$x->with('user_profile');
		}])->where('school_id', '=', $this->school->id);
		
		//dd($parents->get());
		
        return view('saas.user.parents', compact('parents'));
    }

    public function getViewStaff($domain, $id=NULL)
    {
		$user= \App\Models\User::where('id', '=', $id);
		
		$user= $user->with(array('user_profile' => function($t){
				$t->with(array('origin_lga' => function($r){
					$r->with('state');
				}));
			}))->with(array('school_staff' => function($x){
				$x->with('passport')->with('employment_histories')->with('academic_histories');
			}))->first();
		return view('saas.user.profile.staff', compact('user'));

    }
	
	
	public function getEditStaff($domain, $id=NULL)
    {
		if($id==NULL)
			$id = \Auth::user()->user_profile_id;
			
        $staff = NULL;
		if($id==NULL)
			$staff = SchoolStaff::with(['user_profile','user', 'passport', 'signature', 'employment_histories', 'academic_histories'])->find($id);
		else
			$staff = SchoolStaff::with(['user_profile','user', 'passport', 'signature', 'employment_histories', 'academic_histories'])->where('user_profile_id', '=', $id)->first();
			
		$states = States::orderBy('name')->lists('name', 'id');
        $states[null] = 'Select a State';
        
		if($staff->user_profile->state_of_origin_lga_id!=NULL)
		{
			$lgas = Lga::where('id', '=', $staff->user_profile->state_of_origin_lga_id);
			if($lgas->count()>0)
				$lgas = Lga::where('state_id', '=', $lgas->first()->state_id)->lists('lga_name', 'id');
		}
			
        $lgas[null] = 'Select LGA';

        return view('saas.user.step_one', compact('states', 'lgas', 'countries', 'staff'));
    }

    public function getEditStaffTwo($domain, $id)
    {
        if ($this->check_session()) {
            return redirect('/admin/user/step-one/' . $id)->with('message', 'Registration timed out. Please start over again');
        }

        $staff = SchoolStaff::with(['user_profile', 'academic_histories', 'employment_histories'])->find($id);
        $states[null] = 'Select a State';
        foreach (States::orderBy('name')->get() as $sub) {
            $states[$sub->id] = $sub->name;
        }
		

		
		$data = $this->step_setup->getSavedData();
		
		$quals = NULL;
		if(array_key_exists($this->staff_two, $data))
		{
			$quals = $data[$this->staff_two];
		}

//        dd($staff);
        return view('saas.user.step_two', compact('states', 'staff', 'quals'));
    }


    public function getDeletePassportOrSignature($domain, $type, $id = null)
    {
        DB::beginTransaction();
        try {
            $staff = SchoolStaff::where($type . '_data_bank_id', $id)->first();
            if ($id == null && $staff == null) {
                return back()->with('error', 'cannot delete file');
            }
            $type_field = $type . '_data_bank_id';
            $staff->$type_field = null;
            DataBanks::find($id)->delete();
            DB::commit();
            return back()->with('message', $type . ' deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            return back()->with('error', 'cannot delete file');
        }
    }
	
	
	public function getUserProfile($domain, $id=NULL)
	{
		if($id!=NULL)
		{
			$id = \Crypt::decrypt($id);
		}
		else
		{
			$id = \Auth::user()->id;
		}
		
		
		$user= \App\Models\User::where('id', '=', $id);
		
		if($user->first()->role_code==\App\Models\Roles::$ROLE_SKU_STAFF)
		{
			$user= $user->with(array('user_profile' => function($t){
					$t->with(array('origin_lga' => function($r){
						$r->with('state');
					}));
				}))->with(array('school_staff' => function($x){
					$x->with('passport')->with('employment_histories')->with('academic_histories');
				}))->first();
			return view('saas.user.profile.staff', compact('user'));
		}else if($user->first()->role_code==\App\Models\Roles::$ROLE_SCHOOL_STUDENT)
		{
			$user= $user->with(array('user_profile' => function($t){
					$t->with(array('origin_lga' => function($r){
						$r->with('state');
					}));
				}))->with(array('student' => function($x){
					$x->with('passport')->with('applicant_parents')->with('current_class')->with('current_class_arm');
				}))->first();

			//dd($user);
			return view('saas.user.profile.student', compact('user'));
		}else if($user->first()->role_code==\App\Models\Roles::$ROLE_HELP_DESK)
		{
			$data1= $user->with(array('user_profile' => function($t){
					$t->with(array('origin_lga', 'residentState'));
				}))->first();
//dd($data1);
			return view('saas.user.profile.help_desk', compact('data1'));
		}
	}
	
	
	public function postUpdatePassport()
	{
		$id = NULL;
		if(\Input::has('uid'))
		{
			$id = \Crypt::decrypt(\Input::get('uid'));
		}else
		{
			$id = \Auth::user()->id;
		}
		$synctracker = new \App\Models\Synctracker();
		$staff = \App\Models\SchoolStaff::where('user_id', '=', $id);

		if($staff->count()>0)
		{
			try {
				if (Input::hasFile('passport_file')) {
					$file = Input::file('passport_file');
					$file_name = str_random(25) . '.' . $file->getClientOriginalExtension();
					$destination = 'files/passport/' . $this->school->id . '/';
					$file->move($destination, $file_name);
					$passport_databank_id = primary_key();
                    $data_bank = new DataBanks();
                    $data_bank->id = $passport_databank_id;
                    $data_bank->file_name = $file_name;
                    $data_bank->file_url = $destination;
                    $data_bank->file_path = $destination;
                    if ($data_bank->save()) {
                        
						$staff = $staff->first();
						$staff->passport_data_bank_id = $passport_databank_id;
						$staff->save();
						$synctracker = $synctracker->createNewSyncTracker(1, $this->school, 'FILES', $passport_databank_id);
                    }
				}
				return redirect('users/profile');
			} catch (\Exception $e) {
				dd($e);
				return back()->withInput()->with('error', 'Form cannot be submitted, please check your input.');
			}
		}else
		{
			return back()->withInput()->with('error', 'The email address provided has already been used by someone else in your school. Provide another email address to proceed with creating an account.');
		}
	}
	
	public function postUpdateSignature()
	{
		$id = NULL;
		if(\Input::has('uid'))
		{
			$id = \Crypt::decrypt(\Input::get('uid'));
		}else
		{
			$id = \Auth::user()->id;
		}
		$synctracker = new \App\Models\Synctracker();
		$staff = \App\Models\SchoolStaff::where('user_id', '=', $id);

		if($staff->count()>0)
		{
			try {
				if (Input::hasFile('signature_file')) {

					$file = Input::file('signature_file');
					$file_name = str_random(25) . '.' . $file->getClientOriginalExtension();
					$destination = 'files/signature/' . $this->school->id . '/';
					$file->move($destination, $file_name);
					$passport_databank_id = primary_key();
                    $data_bank = new DataBanks();
                    $data_bank->id = $passport_databank_id;
                    $data_bank->file_name = $file_name;
                    $data_bank->file_url = $destination;
                    $data_bank->file_path = $destination;
                    if ($data_bank->save()) {
						$staff = $staff->first();
						$staff->signature_data_bank_id = $passport_databank_id;
						$staff->save();
						$synctracker = $synctracker->createNewSyncTracker(1, $this->school, 'FILES', $passport_databank_id);
                    }
				}
				return redirect('users/profile');
			} catch (\Exception $e) {
				dd($e);
				return back()->withInput()->with('error', 'Form cannot be submitted, please check your input.');
			}
		}else
		{
			return back()->withInput()->with('error', 'The email address provided has already been used by someone else in your school. Provide another email address to proceed with creating an account.');
		}
	}
	
	
	public function getEditUser($domain, $id=NULL)
	{
		$staff = NULL;
		if(is_null($id))
		{	$staff = User::where('id', '=', \Auth::user()->id);}
		else
		{
			$id = \Crypt::decrypt($id);
			$staff = User::where('id', '=', $id);
		}
		$staff = $staff->with(['user_profile'])->first();
		$states = States::lists('name', 'id');
		$lgas = NULL;
		if($staff->user_profile->state_of_origin_lga_id!=NULL)
		{
			$lgas = Lga::where('id', $staff->user_profile->state_of_origin_lga_id)->first();
			$lgas = Lga::where('state_id', '=', $lgas->state_id)->lists('lga_name', 'id');
		}
		$lgas[null] = 'Select LGA';
		return view('saas.user.step_one_admin', compact('staff', 'states', 'lgas'));
	}
}
