<?php

namespace App\Utilities;

/**
 * Created by PhpStorm.
 * User: Kingsley Eze
 * Date: 12/10/2015
 * Time: 9:16 AM
 */

use App\Models\AcademicYear;
use App\Models\ApplicantParents;
use App\Models\Applicants;
use App\Models\AttendanceHistories;
use App\Models\ClassArms;
use App\Models\Classes;
use App\Models\CurriculumSubject;
use App\Models\Department;
use App\Models\GradingScheme;
use App\Models\GradingSchemeGrades;
use App\Models\GradingScore;
use App\Models\LessonNoteSubjects;
use App\Models\RequestForAbsence;
use App\Models\SchoolAcademicYearTerm;
use App\Models\SchoolActivities;
use App\Models\SchoolExtraCurricularActivities;
use App\Models\SchoolPsychomotor;
use App\Models\Schools;
use App\Models\SchoolStaff;
use App\Models\SchoolTerm;
use App\Models\SchoolTimetable;
use App\Models\SchoolTimetablePeriod;
use App\Models\StaffAcademicHistory;
use App\Models\StaffAttendance;
use App\Models\StaffEmploymentHistory;
use App\Models\StudentAttendance;
use App\Models\StudentExtraCurricular;
use App\Models\StudentPsychomotor;
use App\Models\Students;
use App\Models\SubjectClasses;
use App\Models\Subjects;
use App\Models\Subscriptions;
use App\Models\User;
use App\Models\PaymentHistories;
use App\Models\UserProfiles;

class Synchronizer
{
    var $schoolData = [];
    var $studentData = [];
    var $staffData = [];
    var $structData = [];
    var $academicData = [];
    var $attendData = [];
    var $calendarData = [];
    var $performData = [];
    var $usersData = [];

    public function __construct()
    {
//        $this->schoolData = $data;
    }

    public function buildSchool($code)
    {
		$code = ($code);
		
		$reposturl = "http://smartschoolbox.com/build/local/school/sync/".$code;
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $reposturl,
			CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1'
		));
		$resp = curl_exec($curl);
		curl_close($curl);
		$response = json_decode($resp);
		
		//var_dump($response);
		$resp = json_decode($response);
			
		dd($resp);
			
			
        $school = Schools::where('confirmation_code','=',$code)->first();

        if($school === null)
        {

            return $this->schoolData = null;
        }else{

            $this->schoolData['school'] = Schools::where('confirmation_code','=',$code)->first();
            $this->schoolData['subscription'] = Subscriptions::where('school_id','=',$school->id)->first();
            $this->schoolData['system_admin'] = User::whereId($school->school_admin_user_id)->first();
            $this->schoolData['payment'] = PaymentHistories::where('user_id','=',$school->school_admin_user_id)->first();

            return $this->schoolData;
        }

    }
	
	
	public function generateSchoolDataFromOnline($code)
    {
        $school = Schools::where('confirmation_code','=',$code)->first();

        if($school === null)
        {
            return $this->schoolData = null;
        }else{

            $this->schoolData['school'] = Schools::where('confirmation_code','=',$code)->first();
            $this->schoolData['subscription'] = Subscriptions::where('school_id','=',$school->id)->first();
            $this->schoolData['system_admin'] = User::whereId($school->school_admin_user_id)->first();
            $this->schoolData['payment'] = PaymentHistories::where('user_id','=',$school->school_admin_user_id)->first();

            return $this->schoolData;
        }

    }

    public function copySchool($school, $subscription, $user, $payment)
    {
        \DB::beginTransaction();

        try {

            $school1 = (array)$school;
            $school =  new Schools();
            $modelSchool = createModelObject($school1,$school);
            $modelSchool->save();

            $sub1 = (array)$subscription;
            $subscription =  new Subscriptions();
            $modelSubscription = createModelObject($sub1,$subscription);
            $modelSubscription->save();

            $usr1 = (array)$user;
            $user =  new User();
            $modelUser = createModelObject($usr1,$user);
            $modelUser->save();

            $pay1 = (array)$payment;
            $payment =  new PaymentHistories();
            $modelPay = createModelObject($pay1,$payment);
            $modelPay->save();

                \DB::commit();

                return true;

        } catch (\Exception $e) {

            \DB::rollback();

            dd($e->getMessage());

            return false;
        }
    }


    public function buildStudent($school_id, $s)
    {
        $this->staffData = null;
		echo $s;
		$t = strtotime($s);
		$date = date('Y-m-d H:i:s', $t);
		$syncTracker= \App\Models\Synctracker::where('school_id', '=', $school_id)
			->where('created_at', '>', $date)
			->where(function($x){
				$x = $x->where('model', '=', 'Applicants')
					->orWhere('model', '=', 'ApplicantParents')
					->orWhere('model', '=', 'Student')
					->orWhere('model', '=', 'User')
					->orWhere('model', '=', 'PaymentHistories');
			})->get();
			/*
					*/
//		dd($syncTracker);
		$arr_applicant = array();
		$arr_applicant_parents = array();
		$arr_student = array();
		$arr_user = array();
		$arr_pay = array();

        

		foreach($syncTracker as $sync)
		{
			if($sync->model=='Applicants')
				array_push($arr_applicant, $sync->instance_id);
			elseif($sync->model=='ApplicantParents')
				array_push($arr_applicant_parents, $sync->instance_id);
			elseif($sync->model=='Student')
				array_push($arr_student, $sync->instance_id);
			elseif($sync->model=='User')
				array_push($arr_user, $sync->instance_id);
			elseif($sync->model=='PaymentHistories')
				array_push($arr_pay, $sync->instance_id);
		}
		
		
		$this->studentData['applicants'] = Applicants::where('school_id','=', $school_id)->whereIn('id', $arr_applicant)->get();
		$this->studentData['applicant_parents'] = ApplicantParents::where('school_id','=', $school_id)->whereIn('id', $arr_applicant_parents)->get();
		$this->studentData['payment'] = PaymentHistories::where('school_id','=',$school_id)->whereIn('id', $arr_pay)->get();
		$this->studentData['students'] = Students::where('school_id','=',$school_id)->whereIn('id', $arr_student)->get();
		$this->studentData['user'] = Students::where('school_id','=',$school_id)->whereIn('id', $arr_user)->get();
		return $this->studentData;
    }


    public function copyStudent($applicant, $applicant_parent, $payment, $student)
    {
        $loopApp = sizeof($applicant);
        $loopAppParent = sizeof($applicant_parent);
        $loopPayment = sizeof($payment);
        $loopStd = sizeof($student);

        \DB::beginTransaction();

        try {

            for ($i = 0; $i < $loopApp; ++$i) {
                $array = (array)$applicant[$i];
                $applicant[$i] = new Applicants();
                $modelApp = createModelObject($array, $applicant[$i]);
                $modelApp->save();
            }

            for ($i = 0; $i < $loopAppParent; ++$i) {
                $array = (array)$applicant_parent[$i];
                $applicant_parent[$i] = new ApplicantParents();
                $modelAppParent = createModelObject($array, $applicant_parent[$i]);
                $modelAppParent->save();
            }

            for ($i = 0; $i < $loopPayment; ++$i) {
                $array = (array)$payment[$i];
                $payment[$i] = new PaymentHistories();
                $modelPayment = createModelObject($array, $payment[$i]);
                $modelPayment->save();
            }

            for ($i = 0; $i < $loopStd; ++$i) {
                $array = (array)$student[$i];
                $student[$i] = new Students();
                $modelStd = createModelObject($array, $student[$i]);
                $modelStd->save();
            }

            \DB::commit();

            return true;

        } catch (\Exception $e) {

            \DB::rollback();

            dd($e->getMessage());

            return false;
        }
    }

    public function buildStaff($school_id, $s)
    {
        $this->staffData = null;
		echo $s;
		$t = strtotime($s);
		$date = date('Y-m-d H:i:s', $t);
		$syncTracker= \App\Models\Synctracker::where('school_id', '=', $school_id)
			->where('created_at', '>', $date)
			->where(function($x){
				$x = $x->where('model', '=', 'SchoolStaff')
					->orWhere('model', '=', 'StaffEmploymentHistory')
					->orWhere('model', '=', 'StaffAcademicHistory');
			})->get();
			/*
					*/
//		dd($syncTracker);
		$arr_staff = array();
		$arr_acad = array();
		$arr_emp = array();
		foreach($syncTracker as $sync)
		{
			if($sync->model=='SchoolStaff')
				array_push($arr_staff, $sync->instance_id);
			elseif($sync->model=='StaffAcademicHistory')
				array_push($arr_acad, $sync->instance_id);
			elseif($sync->model=='StaffEmploymentHistory')
				array_push($arr_emp, $sync->instance_id);
		}
		
		$this->staffData['school_staff'] = SchoolStaff::where('school_id','=', $school_id)->whereIn('id', $arr_staff)->get();
		$this->staffData['staff_academic'] = StaffAcademicHistory::where('school_id','=', $school_id)->whereIn('id', $arr_acad)->get();
		$this->staffData['staff_history'] = StaffEmploymentHistory::where('school_id','=',$school_id)->whereIn('id', $arr_emp)->get();

//            $this->staffData['staff_attendance'] = StaffAttendance::where('school_id','=',$school_id)->get();
//		dd($this->staffData);
		return $this->staffData;

    }

    public function copyStaff($staff, $academic, $employ)
    {
        $loopStaff = sizeof($staff);
        $loopAcademic = sizeof($academic);
        $loopEmploy = sizeof($employ);

        \DB::beginTransaction();

        try {

            for ($i = 0; $i < $loopStaff; ++$i) {
                $array = (array)$staff[$i];
                $staff[$i] = new SchoolStaff();
                $modelStaff = createModelObject($array, $staff[$i]);
                $modelStaff->save();
            }

            for ($i = 0; $i < $loopAcademic; ++$i) {
                $array = (array)$academic[$i];
                $academic[$i] = new StaffAcademicHistory();
                $modelStaffAcademic = createModelObject($array, $academic[$i]);
                $modelStaffAcademic->save();
            }

            for ($i = 0; $i < $loopEmploy; ++$i) {
                $array = (array)$employ[$i];
                $employ[$i] = new StaffEmploymentHistory();
                $modelStaffEmploy = createModelObject($array, $employ[$i]);
                $modelStaffEmploy->save();
            }

            \DB::commit();

            return true;

        } catch (\Exception $e) {

            \DB::rollback();

            dd($e->getMessage());

            return false;
        }
    }

    public function buildSchoolStructure($school_id)
    {
        $school = Schools::where('id','=',$school_id)->first();

        if($school === null)
        {

            return $this->structData = null;
        }else{

            $this->structData['departments'] = Department::where('school_id','=', $school_id)->get();
            $this->structData['classes'] = Classes::where('school_id','=', $school_id)->get();
            $this->structData['class_arms'] = ClassArms::where('school_id','=',$school_id)->get();

//            $this->staffData['staff_attendance'] = StaffAttendance::where('school_id','=',$school_id)->get();

            return $this->structData;
        }

    }


    public function copySchoolStructure($dept, $classes, $classArms)
    {
        $loopDept = sizeof($dept);
        $loopClass = sizeof($classes);
        $loopClassArm = sizeof($classArms);

        \DB::beginTransaction();

        try {

            for ($i = 0; $i < $loopDept; ++$i) {
                $array = (array)$dept[$i];
                $dept[$i] = new Department();
                $modelObject = createModelObject($array, $dept[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopClass; ++$i) {
                $array = (array)$classes[$i];
                $classes[$i] = new Classes();
                $modelObject = createModelObject($array, $classes[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopClassArm; ++$i) {
                $array = (array)$classArms[$i];
                $classArms[$i] = new ClassArms();
                $modelObject = createModelObject($array, $classArms[$i]);
                $modelObject->save();
            }

            \DB::commit();

            return true;

        } catch (\Exception $e) {

            \DB::rollback();

            dd($e->getMessage());

            return false;
        }
    }


    public function buildAcademics($school_id)
    {
        $school = Schools::where('id','=',$school_id)->first();

        if($school === null)
        {

            return $this->academicData = null;
        }else{

            $this->academicData['subjects'] = Subjects::where('school_id','=', $school_id)->get();
            $this->academicData['subjectClass'] = SubjectClasses::where('school_id','=', $school_id)->get();
            $this->academicData['gradeScheme'] = GradingScheme::where('school_id','=',$school_id)->get();
            $this->academicData['gradeSchemeGrade'] = GradingSchemeGrades::where('school_id','=',$school_id)->get();
            $this->academicData['gradeScore'] = GradingScore::where('school_id','=',$school_id)->get();
            $this->academicData['lessonNoteSubject'] = LessonNoteSubjects::where('school_id','=',$school_id)->get();
            $this->academicData['curriculumSubject'] = CurriculumSubject::where('school_id','=',$school_id)->get();

            return $this->academicData;
        }

    }

    public function copyAcademics($subjects, $subjectClass, $gradeScheme,$gradeSchemeGrade,$gradeScore, $lessonNoteSubject, $curriculumSubject  )
    {
        $loopSub = sizeof($subjects);
        $loopClass = sizeof($subjectClass);
        $loopGScheme = sizeof($gradeScheme);
        $loopGSchemeGrade = sizeof($gradeSchemeGrade);
        $loopGScore = sizeof($gradeScore);
        $loopLessonNote = sizeof($lessonNoteSubject);
        $loopCSub = sizeof($curriculumSubject);

        \DB::beginTransaction();

        try {

            for ($i = 0; $i < $loopSub; ++$i) {
                $array = (array)$subjects[$i];
                $subjects[$i] = new Subjects();
                $modelObject = createModelObject($array, $subjects[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopClass; ++$i) {
                $array = (array)$subjectClass[$i];
                $subjectClass[$i] = new SubjectClasses();
                $modelObject = createModelObject($array, $subjects[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopGScheme; ++$i) {
                $array = (array)$gradeScheme[$i];
                $gradeScheme[$i] = new GradingScheme();
                $modelObject = createModelObject($array, $gradeScheme[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopGSchemeGrade; ++$i) {
                $array = (array)$gradeSchemeGrade[$i];
                $gradeSchemeGrade[$i] = new GradingSchemeGrades();
                $modelObject = createModelObject($array, $gradeSchemeGrade[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopGScore; ++$i) {
                $array = (array)$gradeScore[$i];
                $gradeScore[$i] = new GradingScore();
                $modelObject = createModelObject($array, $gradeScore[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopLessonNote; ++$i) {
                $array = (array)$lessonNoteSubject[$i];
                $lessonNoteSubject[$i] = new LessonNoteSubjects();
                $modelObject = createModelObject($array, $lessonNoteSubject[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopCSub; ++$i) {
                $array = (array)$curriculumSubject[$i];
                $curriculumSubject[$i] = new CurriculumSubject()    ;
                $modelObject = createModelObject($array, $curriculumSubject[$i]);
                $modelObject->save();
            }



            \DB::commit();

            return true;

        } catch (\Exception $e) {

            \DB::rollback();

            dd($e->getMessage());

            return false;
        }
    }


    public function buildAttendance($school_id)
    {
        $school = Schools::where('id','=',$school_id)->first();

        if($school === null)
        {

            return $this->academicData = null;
        }else{

            $this->attendData['requestForAbsence'] = RequestForAbsence::where('school_id','=', $school_id)->get();
            $this->attendData['studentAttendance'] = StudentAttendance::where('school_id','=', $school_id)->get();
            $this->attendData['staffAttendance'] = StaffAttendance::where('school_id','=', $school_id)->get();
            $this->attendData['AttendanceHistory'] = AttendanceHistories::where('school_id','=', $school_id)->get();

            return $this->attendData;
        }

    }

    public function copyAttendance($request, $student, $staff, $history)
    {
        $loopReq = sizeof($request);
        $loopStd = sizeof($student);
        $loopStaff = sizeof($staff);
        $loopHistory = sizeof($history);

        \DB::beginTransaction();

        try {

            for ($i = 0; $i < $loopReq; ++$i) {
                $array = (array)$request[$i];
                $request[$i] = new RequestForAbsence();
                $modelObject = createModelObject($array, $request[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopStd; ++$i) {
                $array = (array)$student[$i];
                $student[$i] = new StudentAttendance();
                $modelObject = createModelObject($array, $student[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopStaff; ++$i) {
                $array = (array)$staff[$i];
                $staff[$i] = new StaffAttendance();
                $modelObject = createModelObject($array, $staff[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopHistory; ++$i) {
                $array = (array)$history[$i];
                $history[$i] = new AttendanceHistories();
                $modelObject = createModelObject($array, $history[$i]);
                $modelObject->save();
            }


            \DB::commit();

            return true;

        } catch (\Exception $e) {

            \DB::rollback();

            dd($e->getMessage());

            return false;
        }
    }

    public function buildCalendar($school_id)
    {
        $school = Schools::where('id','=',$school_id)->first();

        if($school === null)
        {

            return $this->calendarData = null;
        }else{

            $this->calendarData['academicYear'] = AcademicYear::where('school_id','=', $school_id)->get();
            $this->calendarData['academicYearTerm'] = SchoolAcademicYearTerm::where('school_id','=', $school_id)->get();
            $this->calendarData['schoolActivities'] = SchoolActivities::where('school_id','=', $school_id)->get();
            $this->calendarData['SchoolTerm'] = SchoolTerm::where('school_id','=', $school_id)->get();
            $this->calendarData['SchoolTimetable'] = SchoolTimetable::where('school_id','=', $school_id)->get();
            $this->calendarData['SchoolTimetablePeriod'] = SchoolTimetablePeriod::where('school_id','=', $school_id)->get();

            return $this->attendData;
        }
    }

    public function copyCalendar($year, $yearTerm, $activities, $term, $timetable, $period)
    {
        $loopYear = sizeof($year);
        $loopYearTerm = sizeof($yearTerm);
        $loopAct = sizeof($activities);
        $loopTerm = sizeof($term);
        $loopTime = sizeof($timetable);
        $loopPeriod = sizeof($period);

        \DB::beginTransaction();

        try {

            for ($i = 0; $i < $loopYear; ++$i) {
                $array = (array)$year[$i];
                $year[$i] = new AcademicYear();
                $modelObject = createModelObject($array, $year[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopYearTerm; ++$i) {
                $array = (array)$yearTerm[$i];
                $yearTerm[$i] = new SchoolAcademicYearTerm();
                $modelObject = createModelObject($array, $yearTerm[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopAct; ++$i) {
                $array = (array)$activities[$i];
                $activities[$i] = new SchoolActivities();
                $modelObject = createModelObject($array, $activities[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopTerm; ++$i) {
                $array = (array)$term[$i];
                $term[$i] = new SchoolTerm();
                $modelObject = createModelObject($array, $term[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopTime; ++$i) {
                $array = (array)$timetable[$i];
                $timetable[$i] = new SchoolTimetable();
                $modelObject = createModelObject($array, $timetable[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopPeriod; ++$i) {
                $array = (array)$period[$i];
                $period[$i] = new SchoolTimetablePeriod();
                $modelObject = createModelObject($array, $period[$i]);
                $modelObject->save();
            }


            \DB::commit();

            return true;

        } catch (\Exception $e) {

            \DB::rollback();

            dd($e->getMessage());

            return false;
        }
    }

    public function buildPerformance($school_id)
    {
        $school = Schools::where('id','=',$school_id)->first();

        if($school === null)
        {

            return $this->performData = null;
        }else{

            $this->performData['schoolExtraActivities'] = SchoolExtraCurricularActivities::where('school_id','=', $school_id)->get();
            $this->performData['schoolPsychomotor'] = SchoolPsychomotor::where('school_id','=', $school_id)->get();
            $this->performData['studentExtraActivities'] = StudentExtraCurricular::where('school_id','=', $school_id)->get();
            $this->performData['studentPsychomotor'] = StudentPsychomotor::where('school_id','=', $school_id)->get();

            return $this->performData;
        }
    }


    public function copyPerformance($schoolExtra, $schPsy, $stdExtra, $stdPsy)
    {
        $loopSchExtra = sizeof($schoolExtra);
        $loopSchPsy = sizeof($schPsy);
        $loopStdExtra = sizeof($stdExtra);
        $loopStdPsy = sizeof($stdPsy);

        \DB::beginTransaction();

        try {

            for ($i = 0; $i < $loopSchExtra; ++$i) {
                $array = (array)$schoolExtra[$i];
                $schoolExtra[$i] = new SchoolExtraCurricularActivities();
                $modelObject = createModelObject($array, $schoolExtra[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopSchPsy; ++$i) {
                $array = (array)$schPsy[$i];
                $schPsy[$i] = new SchoolPsychomotor();
                $modelObject = createModelObject($array, $schPsy[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopStdExtra; ++$i) {
                $array = (array)$stdExtra[$i];
                $stdExtra[$i] = new StudentExtraCurricular();
                $modelObject = createModelObject($array, $stdExtra[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopStdPsy; ++$i) {
                $array = (array)$stdPsy[$i];
                $stdPsy[$i] = new StudentPsychomotor();
                $modelObject = createModelObject($array, $stdPsy[$i]);
                $modelObject->save();
            }

            \DB::commit();

            return true;

        } catch (\Exception $e) {

            \DB::rollback();

            dd($e->getMessage());

            return false;
        }
    }


    public function buildUsers($school_id)
    {
        $school = Schools::where('id','=',$school_id)->first();

        if($school === null)
        {

            return $this->usersData = null;
        }else{

            $this->usersData['users'] = User::where('school_id','=', $school_id)->get();
            $this->usersData['userProfile'] = UserProfiles::where('school_id','=', $school_id)->get();

            return $this->usersData;
        }
    }


    public function copyUsers($users, $userProfile)
    {
        $loopUser = sizeof($users);
        $loopUserPro = sizeof($userProfile);

        \DB::beginTransaction();

        try {

            for ($i = 0; $i < $loopUser; ++$i) {
                $array = (array)$users[$i];
                $users[$i] = new User();
                $modelObject = createModelObject($array, $users[$i]);
                $modelObject->save();
            }

            for ($i = 0; $i < $loopUserPro; ++$i) {
                $array = (array)$userProfile[$i];
                $userProfile[$i] = new UserProfiles();
                $modelObject = createModelObject($array, $userProfile[$i]);
                $modelObject->save();
            }

            \DB::commit();

            return true;

        } catch (\Exception $e) {

            \DB::rollback();

            dd($e->getMessage());

            return false;
        }
    }



}