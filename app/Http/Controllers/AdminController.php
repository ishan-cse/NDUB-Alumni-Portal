<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Models\GraduateList;
use App\Models\User;
use App\Models\Batch;
use App\Models\Program;
use App\Models\Department;
use App\Models\peo;
use App\Models\peoPo;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmEmail;
use Image;
use File;
use Barryvdh\DomPDF\Facade\Pdf;
use Excel;

class AdminController extends Controller{
    public function dashboard(){
        if(Auth::user()->role_id==1 || Auth::user()->role_id==2){
            return view('admin.dashboard.dashboard');
        }    
    }
    
    public function allStudent(){
        $loggedUser = Auth::user();
        $all = GraduateList::all();
        return view('admin.student.all', compact('loggedUser', 'all'));
    }

    public function addStudent(): View{
        return view('admin.student.add');
    }
    public function addPeo(): View{
        return view('admin.student.peo');
    }

    public function submitPeo(Request $request): RedirectResponse{
        $this->validate($request,[
            
        ],[
            
        ]);
        $loggedUser = Auth::user()->id;

    
            $insert = peo::insert([
                'b1'=>$request->b1,
                'b2'=>$request->b2,
                'b3'=>$request->b3,
                'c1'=>$request->c1,
                'c2'=>$request->c2,
                'created_by'=>$loggedUser,
                'created_at'=>Carbon::now()->toDateTimeString(),
            ]); 

        if($insert){
            Session::flash('success','Submitted Successfully!');
            return redirect()->route('add_peo');
        }else{
            Session::flash('error','Failed!');
            return redirect()->route('add_peo');
        }
    }

       public function addPeoPo(): View{
        return view('admin.student.peo_po');
    }

    public function submitPeoPo(Request $request): RedirectResponse{
        $this->validate($request,[
            
        ],[
            
        ]);
        $loggedUser = Auth::user()->id;

    
            $insert = peoPo::insert([
                'b1'=>$request->b1,
                'b2'=>$request->b2,
                'b3'=>$request->b3,
                'c1'=>$request->c1,
                'c2'=>$request->c2,
                'c3'=>$request->c3,
                'c4'=>$request->c4,
                'c5'=>$request->c5,
                'c6'=>$request->c6,
                'c7'=>$request->c7,
                'c8'=>$request->c8,
                'c9'=>$request->c9,
                'd1'=>$request->d1,
                'd2'=>$request->d2,
                'created_by'=>$loggedUser,
                'created_at'=>Carbon::now()->toDateTimeString(),
            ]); 

        if($insert){
            Session::flash('success','Submitted Successfully!');
            return redirect()->route('add_peo_po');
        }else{
            Session::flash('error','Failed!');
            return redirect()->route('add_peo_po');
        }
    }
    
    public function peoFeedback(){
        
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
    
            $columns = ['b1', 'b2', 'b3'];
            $peoSubmissionCount = Peo::count();
            $percentages = [];
    
            // 🔹 Set your threshold percentage (you can change it anytime)
            $thresholdPercent = 50.0;
    
            // also provide a short variable name used in Blade ($threshold)
            $threshold = $thresholdPercent;
    
            // 🔹 Convert to equivalent rating (1–5 scale)
            $thresholdRating = ($thresholdPercent / 100) * 5;
            //$ratingCutoff = ceil($thresholdRating); // e.g., 47% = 2.35 → 3
    
            $aboveThreshold = [];
            $aboveThresholdPercent = [];
    
            foreach ($columns as $col) {
                $percentages[$col] = [];
    
               
                    $count = Peo::where($col, '>=',  $thresholdRating)->count();
                    $percent = $peoSubmissionCount > 0 ? ($count / $peoSubmissionCount) * 100 : 0;
                    $percentages[$col] = round($percent, 2);
                
            }
    
            // Collect all comments (no filtering)
            $c1Comments = Peo::select('c1')->get();
            $c2Comments = Peo::select('c2')->get();
    
            return view('admin.dashboard.peo_feedback', compact(
                'peoSubmissionCount',
                'percentages',
                'c1Comments',
                'c2Comments',
                'threshold',            // now available to Blade
                'thresholdPercent',     // optional, still available if you used it elsewhere
                'thresholdRating',
            ));
        }
    
        // optional: you may want to redirect if unauthorized
        abort(403);
    }
    
    public function peoPoFeedback(){
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
    
        // 🔹 Columns for threshold percentage
        $columns = ['b1', 'b2', 'b3', 'c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8', 'c9'];
    
        // 🔹 Total number of submissions
        $peoPoSubmissionCount = PeoPo::count();
    
        // 🔹 Array to hold percentages
        $percentages = [];
    
        // 🔹 Set your threshold percentage (you can change this anytime)
        $thresholdPercent = 50.0;
    
        // Provide a short variable name for Blade
        $threshold = $thresholdPercent;
    
        // 🔹 Convert to equivalent rating (1–5 scale)
        $thresholdRating = ($thresholdPercent / 100) * 5;
    
        // 🔹 Calculate how many records meet/exceed threshold for each column
        foreach ($columns as $col) {
            $count = PeoPo::where($col, '>=', $thresholdRating)->count();
            $percent = $peoPoSubmissionCount > 0 ? ($count / $peoPoSubmissionCount) * 100 : 0;
            $percentages[$col] = round($percent, 2);
        }
    
        // 🔹 Collect comments from d1 and d2 columns
        $d1Comments = PeoPo::select('d1')->get();
        $d2Comments = PeoPo::select('d2')->get();
    
        // 🔹 Return data to the Blade view
        return view('admin.dashboard.peo_po_feedback', compact(
            'peoPoSubmissionCount',
            'percentages',
            'd1Comments',
            'd2Comments',
            'threshold',
            'thresholdPercent',
            'thresholdRating'
        ));
    }
    
    // 🔹 Redirect if unauthorized
    abort(403);

}



    public function submitStudent(Request $request): RedirectResponse{
        $this->validate($request,[
            'student_id' => 'required|max:50|unique:graduate_lists,student_id',
            'name'=>'required|max:50',
            //'email'=>'required|max:50',
            'email'=>'max:50',
            'program'=>'required',
        ],[
            'student_id.unique'=>'Student account already exist with this student ID.',
        ]);
        $loggedUser = Auth::user()->id;

        if($request->program==1){
            $insert = GraduateList::where('id', $request->id)->insert([
                'student_id'=>$request->student_id,
                'name'=>$request->name,
                'email'=>$request->email,
                'bachelor_program_status'=>1,
                'created_by'=>$loggedUser,
                'created_at'=>Carbon::now()->toDateTimeString(),
            ]); 
        }elseif($request->program==2){
            $insert = GraduateList::where('id', $request->id)->insert([
                'student_id'=>$request->student_id,
                'name'=>$request->name,
                'email'=>$request->email,
                'master_program_status'=>1,
                'created_by'=>$loggedUser,
                'created_at'=>Carbon::now()->toDateTimeString(),
            ]); 
        }

        if($insert){
            Session::flash('success','Student successfully added!');
            return redirect()->route('add_student');
        }else{
            Session::flash('error','Student add process failed!');
            return redirect()->route('add_student');
        }
    }

    public function viewStudent($encryptedId){
        try {
            $id = Crypt::decryptString($encryptedId);
        } catch (DecryptException $e) {
        }

        $user = GraduateList::where('id', $id)->first();

        if($user->child_account_status=='0'){
            return view('admin.student.view', compact('user'));
        }elseif($user->child_account_status=='1'){
            //return view('student.dashboard.second-program-dashboard', compact('user'));
        }
    }

    public function editStudent($encryptedId): View{
        try {
            $id = Crypt::decryptString($encryptedId);
        } catch (DecryptException $e) {
        }

        $programs = Program::all();
        $batchs = Batch::all();

        $user = GraduateList::where('id', $id)->first();
        return view('admin.student.edit', compact('user', 'programs', 'batchs'));
    }

    public function updateStudent(Request $request): RedirectResponse{
        $this->validate($request,[
            'name'=>'required|max:50',
            'email'=>'required|max:50',
            'program'=>'required',
            'batch'=>'required',
            'admission_year'=>'required|max:50',
            'admission_semester'=>'required|max:50',
            'credit_earned'=>'required|max:255|numeric',
            'cgpa'=>'required|max:4|numeric',
            'passing_trimester'=>'required|max:50',
            'passing_year'=>'required|max:50',
            'father_name'=>'required|max:50',
            'mother_name'=>'required|max:50',
            'phone'=>'required|max:50',
            'blood_group'=>'required|max:50',
            'nid_or_birth_cert_no'=>'required|max:50',
            'nid1_or_birth_cert2_status'=>'required',
            'dob'=>'required',
            'present_address'=>'required|max:100',
            'permanent_address'=>'required|max:100',
            'organization_name'=>'required|max:50',
            'designation'=>'required|max:50',
            'office_phone'=>'required|max:50',
            'office_mobile'=>'required|max:50',
            'office_address'=>'required|max:100',
            'guest1_name'=>'required|max:50',
            'guest1_relationship'=>'required|max:50',
            'guest1_nid_or_birth_cert'=>'required|max:50',
            'guest1_nid1_or_birth_cert2_status'=>'required',
            'guest1_present_address'=>'required|max:100',
            'guest1_permanent_address'=>'required|max:100',
            'guest2_name'=>'max:50',
            'guest2_relationship'=>'max:50',
            'guest2_nid_or_birth_cert'=>'max:50',
            'guest2_present_address'=>'max:100',
            'guest2_permanent_address'=>'max:100',
            'ssc_institute'=>'required|max:50',
            'ssc_board'=>'required|max:50',
            'ssc_result'=>'required|max:50',
            'ssc_group'=>'required|max:50',
            'ssc_passing_year'=>'required|max:50',
            'hsc_institute'=>'required|max:50',
            'hsc_board'=>'required|max:50',
            'hsc_result'=>'required|max:50',
            'hsc_group'=>'required|max:50',
            'hsc_passing_year'=>'required|max:50',
            'bachelor_institute'=>'required|max:50',
            'bachelor_board'=>'max:50',
            'bachelor_result'=>'required|max:50',
            'bachelor_group'=>'max:50',
            'bachelor_passing_year'=>'required|max:50',
            'masters_institute'=>'max:50',
            'masters_result'=>'max:50',
            'masters_passing_year'=>'max:50',
        ],[
            'nid1_or_birth_cert2_status.required'=>'Please choose the option for the number you are entering (NID/Birth Certificate).',
            'guest1_nid1_or_birth_cert2_status.required'=>'Please choose the option for the number you are entering (NID/Birth Certificate).',
        ]);
        $loggedUser = Auth::user()->id;
        $update = GraduateList::where('id', $request->id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'program_id'=>$request->program,
            'batch_id'=>$request->batch,
            'major'=>$request->major,
            'minor'=>$request->minor,
            'admission_year'=>$request->admission_year,
            'admission_semester'=>$request->admission_semester,
            'credit_earned'=>$request->credit_earned,
            'cgpa'=>$request->cgpa,
            'passing_trimester'=>$request->passing_trimester,
            'passing_year'=>$request->passing_year,
            'father_name'=>$request->father_name,
            'mother_name'=>$request->mother_name,
            'phone'=>$request->phone,
            'blood_group'=>$request->blood_group,
            'nid_or_birth_cert_no'=>$request->nid_or_birth_cert_no,
            'nid1_or_birth_cert2_status'=>$request->nid1_or_birth_cert2_status,
            'dob'=>$request->dob,
            'present_address'=>$request->present_address,
            'permanent_address'=>$request->permanent_address,
            'organization_name'=>$request->organization_name,
            'designation'=>$request->designation,
            'office_address'=>$request->office_address,
            'office_phone'=>$request->office_phone,
            'office_mobile'=>$request->office_mobile,
            'guest1_name'=>$request->guest1_name,
            'guest1_relationship'=>$request->guest1_relationship,
            'guest1_nid_or_birth_cert'=>$request->guest1_nid_or_birth_cert,
            'guest1_nid1_or_birth_cert2_status'=>$request->guest1_nid1_or_birth_cert2_status,
            'guest1_present_address'=>$request->guest1_present_address,
            'guest1_permanent_address'=>$request->guest1_permanent_address,
            'guest2_name'=>$request->guest2_name,
            'guest2_relationship'=>$request->guest2_relationship,
            'guest2_nid_or_birth_cert'=>$request->guest2_nid_or_birth_cert,
            'guest2_nid1_or_birth_cert2_status'=>$request->guest2_nid1_or_birth_cert2_status,
            'guest2_present_address'=>$request->guest2_present_address,
            'guest2_permanent_address'=>$request->guest2_permanent_address,
            'ssc_institute'=>$request->ssc_institute,
            'ssc_board'=>$request->ssc_board,
            'ssc_result'=>$request->ssc_result,
            'ssc_group'=>$request->ssc_group,
            'ssc_passing_year'=>$request->ssc_passing_year,
            'hsc_institute'=>$request->hsc_institute,
            'hsc_board'=>$request->hsc_board,
            'hsc_result'=>$request->hsc_result,
            'hsc_group'=>$request->hsc_group,
            'hsc_passing_year'=>$request->hsc_passing_year,
            'bachelor_institute'=>$request->bachelor_institute,
            'bachelor_board'=>$request->bachelor_board,
            'bachelor_result'=>$request->bachelor_result,
            'bachelor_group'=>$request->bachelor_group,
            'bachelor_passing_year'=>$request->bachelor_passing_year,
            'masters_institute'=>$request->masters_institute,
            'masters_result'=>$request->masters_result,
            'masters_passing_year'=>$request->masters_passing_year,
            'edit_start_status'=>1,
            'updated_by_admin'=>$loggedUser,
            'updated_at_by_admin'=>Carbon::now()->toDateTimeString(),
        ]);

        if($update){
            Session::flash('success','Information successfully updated!');
            return redirect()->route('all_student');
        }else{
            Session::flash('error','Information edit process failed!');
            return redirect()->route('admin_edit_student_information');
        }
    }

    public function editStudentEmail($encryptedId): View{
        try {
            $id = Crypt::decryptString($encryptedId);
        } catch (DecryptException $e) {
        }

        $user = GraduateList::where('id', $id)->first();
        return view('admin.student.edit-email', compact('user'));
    }

    public function updateStudentEmail(Request $request): RedirectResponse{
        $id = $request->id;
        $this->validate($request,[
            'student_id' => 'required|max:50|unique:graduate_lists,student_id,'.$id.',id',
            'email'=>'required|max:50',
        ],[
        ]);
        $loggedUser = Auth::user()->id;
        $gradInfo = GraduateList::where('id', $request->id)->first();
        $update1 = GraduateList::where('id', $request->id)->update([
            'student_id'=>$request->student_id,
            'email'=>$request->email,
            'updated_by'=>$loggedUser,
            'updated_at'=>Carbon::now()->toDateTimeString(),
        ]);

        $update2 = User::where('student_id', $gradInfo->student_id)->update([
            'student_id'=>$request->student_id,
            'email'=>$request->email,
            'updated_by'=>$loggedUser,
            'updated_at'=>Carbon::now()->toDateTimeString(),
        ]);

        if($update1 && $update2){
            Session::flash('success','Email successfully updated!');
            return redirect()->route('all_student');
        }else{
            Session::flash('error','Email edit process failed!');
            return redirect()->route('all_student');
        }
    }
    
    public function editProgramStatusConfiguration($encryptedId): View{
        try {
            $id = Crypt::decryptString($encryptedId);
        } catch (DecryptException $e) {
        }

        $user = GraduateList::where('id', $id)->first();
        return view('admin.student.edit-program-status-configuration', compact('user'));
    }

    public function updateProgramStatusConfiguration(Request $request): RedirectResponse{
        $id = $request->id;
        $this->validate($request,[
            'student_program_choice'=>'required',
        ],[
        ]);
        $loggedUser = Auth::user()->id;
        $gradInfo = GraduateList::where('id', $request->id)->first();
        $update1 = GraduateList::where('id', $request->id)->update([
            'student_program_choice'=>$request->student_program_choice,
            'updated_by'=>$loggedUser,
            'updated_at'=>Carbon::now()->toDateTimeString(),
        ]);

        $update2 = User::where('student_id', $gradInfo->student_id)->update([
            'student_program_choice'=>$request->student_program_choice,
            'updated_by'=>$loggedUser,
            'updated_at'=>Carbon::now()->toDateTimeString(),
        ]);

        if($update1 && $update2){
            Session::flash('success','Program status configuration successfully updated!');
            return redirect()->route('all_student');
        }else{
            Session::flash('error','Program status configuration edit process failed!');
            return redirect()->route('all_student');
        }
    }

    public function editSecondProgram($encryptedId){
        try {
            $gradId = Crypt::decryptString($encryptedId);
        } catch (DecryptException $e) {
        }

        $programs = Program::all();
        $batchs = Batch::all();

        $second_program_grad_list_id = GraduateList::where('id', $gradId)->value('second_program_grad_list_id');

        $user = GraduateList::where('id', $second_program_grad_list_id)->first();
        return view('admin.student.second-registration-edit', compact('user', 'programs', 'batchs'));
    }

    /**
     * 
     */
    public function updateSecondProgram(Request $request): RedirectResponse{
        $this->validate($request,[
            'program'=>'required',
            'batch'=>'required',
            'admission_year'=>'required|max:50',
            'admission_semester'=>'required|max:50',
            'credit_earned'=>'required|max:255|numeric',
            'cgpa'=>'required|max:4|numeric',
            'passing_trimester'=>'required|max:50',
            'passing_year'=>'required|max:50',
        ]);
        $loggedUser = Auth::user()->id;
        $update = GraduateList::where('id', $request->id)->update([
            'program_id'=>$request->program,
            'batch_id'=>$request->batch,
            'major'=>$request->major,
            'minor'=>$request->minor,
            'admission_year'=>$request->admission_year,
            'admission_semester'=>$request->admission_semester,
            'credit_earned'=>$request->credit_earned,
            'cgpa'=>$request->cgpa,
            'passing_trimester'=>$request->passing_trimester,
            'passing_year'=>$request->passing_year,
            'second_program_info_complete_status'=>1,
            'edit_start_status'=>1,
            'updated_by'=>$loggedUser,
            'updated_at'=>Carbon::now()->toDateTimeString(),
        ]);

        $parent_program_grad_list_id = GraduateList::where('id', $request->id)->value('second_program_grad_list_id');
        $update1 = GraduateList::where('id', $parent_program_grad_list_id)->update([
            'second_program_info_complete_status'=>1,
            'updated_by'=>$loggedUser,
            'updated_at'=>Carbon::now()->toDateTimeString(),
        ]);

        if($update && $update1){
            Session::flash('success','Information successfully updated!');
            return redirect()->route('all_student');
        }else{
            Session::flash('error','Information edit process failed!');
            return redirect()->route('edit_student_information');
        }
    }
    
    //Excel - not working
    public function studentListExcelFile1(Request $request){
        $reg_complete_grad_list = GraduateList::where('registration_complete_status', 1)->where('id', 1)->get();

        $fileName = "student-list.xls";

        return Excel::download(function($excel) use ($reg_complete_grad_list){
            $excel->sheet('Sheet1', function($sheet) use ($reg_complete_grad_list){
                $sheet->fromArray($reg_complete_grad_list);
            });
        }, $fileName);
        echo 'print';
    }
    
    //CSV - for single program registration completed
    public function registrationCompletedStudentListSingleProgramInExcel(Request $request){
        $filename = 'Registration-completed-student-data-for-single-program.csv';
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
    
        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
    
            // Add CSV headers
            fputcsv($handle, [
                'Sign Up Time',
                'Form Submission Time',
                'Name',
                'Student ID',
                'Program',
                'Batch',
                'Major',
                'Minor',
                'Admission Year',
                'Admission Semester',
                'Father Name',
                'Mother Name',
                'Present Address',
                'Permanent address',
                'Organization Name',
                'Designation',
                'Office Address',
                'Phone',
                'Office Phone',
                'Office Mobile',
                'Email',
                'Blood group',
                'NID/Birth certificate number',
                'Credit Earned',
                'CGPA',
                'Result Publish Date',
                'Date of Birth',
                'Passing trimester/semester',
                'Passing Year',
                'SSC Institute',
                'SSC Board',
                'SSC Group',
                'SSC Passing Year',
                'SSC Result',
                'HSC Institute',
                'HSC Board',
                'HSC Group',
                'HSC Passing Year',
                'HSC Result',
                'Bachelor Institute',
                'Bachelor Board',
                'Bachelor Group',
                'Bachelor Passing Year',
                'Bachelor Result',
                'Masters Institute',
                'Masters Board',
                'Masters Group',
                'Masters Passing Year',
                'Masters Result',
                'Guest1 Name',
                'Guest1 Relationship',
                'Guest1 NID/Birth certificate number',
                'Guest1 Present Address',
                'Guest1 Permanent Address',
                'Guest2 Name',
                'Guest2 Relationship',
                'Guest2 NID/Birth certificate number',
                'Guest2 Present Address',
                'Guest2 Permanent Address',
            ]);
    
             // Fetch and process data in chunks
            GraduateList::where('registration_complete_status', 1)->where('second_program_info_complete_status', 0)->with(['programInfo', 'batchInfo', 'secondProgramInfo'])->chunk(25, function ($registrationCompleteStudentLists) use ($handle) {
                foreach ($registrationCompleteStudentLists as $registrationcompletestudentlist) {
             // Extract data from each employee.
                    $data = [
                        isset($registrationcompletestudentlist->sign_up_time)? $registrationcompletestudentlist->sign_up_time : '',
                        isset($registrationcompletestudentlist->form_submission_date)? $registrationcompletestudentlist->form_submission_date : '',
                        isset($registrationcompletestudentlist->name)? $registrationcompletestudentlist->name : '',
                        isset($registrationcompletestudentlist->student_id)? $registrationcompletestudentlist->student_id : '',
                        isset($registrationcompletestudentlist->programInfo->program_name)? $registrationcompletestudentlist->programInfo->program_name : '',
                        isset($registrationcompletestudentlist->batchInfo->batch_name)? $registrationcompletestudentlist->batchInfo->batch_name : '',
                        isset($registrationcompletestudentlist->major)? $registrationcompletestudentlist->major : '',
                        isset($registrationcompletestudentlist->minor)? $registrationcompletestudentlist->minor : '',
                        isset($registrationcompletestudentlist->admission_year)? $registrationcompletestudentlist->admission_year : '',
                        isset($registrationcompletestudentlist->admission_semester)? $registrationcompletestudentlist->admission_semester : '',
                        isset($registrationcompletestudentlist->father_name)? $registrationcompletestudentlist->father_name : '',
                        isset($registrationcompletestudentlist->mother_name)? $registrationcompletestudentlist->mother_name : '',
                        isset($registrationcompletestudentlist->present_address)? $registrationcompletestudentlist->present_address : '',
                        isset($registrationcompletestudentlist->permanent_address)? $registrationcompletestudentlist->permanent_address : '',
                        isset($registrationcompletestudentlist->organization_name)? $registrationcompletestudentlist->organization_name : '',
                        isset($registrationcompletestudentlist->designation)? $registrationcompletestudentlist->designation : '',
                        isset($registrationcompletestudentlist->office_address)? $registrationcompletestudentlist->office_address : '',
                        isset($registrationcompletestudentlist->phone)? $registrationcompletestudentlist->phone : '',
                        isset($registrationcompletestudentlist->office_phone)? $registrationcompletestudentlist->office_phone : '',
                        isset($registrationcompletestudentlist->office_mobile)? $registrationcompletestudentlist->office_mobile : '',
                        isset($registrationcompletestudentlist->email)? $registrationcompletestudentlist->email : '',
                        isset($registrationcompletestudentlist->blood_group)? $registrationcompletestudentlist->blood_group : '',
                        isset($registrationcompletestudentlist->nid_or_birth_cert_no)? $registrationcompletestudentlist->nid_or_birth_cert_no : '',
                        isset($registrationcompletestudentlist->credit_earned)? $registrationcompletestudentlist->credit_earned : '',
                        isset($registrationcompletestudentlist->cgpa)? $registrationcompletestudentlist->cgpa : '',
                        isset($registrationcompletestudentlist->result_publish_date)? $registrationcompletestudentlist->result_publish_date : '',
                        isset($registrationcompletestudentlist->dob)? $registrationcompletestudentlist->dob : '',
                        isset($registrationcompletestudentlist->passing_trimester)? $registrationcompletestudentlist->passing_trimester : '',
                        isset($registrationcompletestudentlist->passing_year)? $registrationcompletestudentlist->passing_year : '',
                        isset($registrationcompletestudentlist->ssc_institute)? $registrationcompletestudentlist->ssc_institute : '',
                        isset($registrationcompletestudentlist->ssc_board)? $registrationcompletestudentlist->ssc_board : '',
                        isset($registrationcompletestudentlist->ssc_group)? $registrationcompletestudentlist->ssc_group : '',
                        isset($registrationcompletestudentlist->ssc_passing_year)? $registrationcompletestudentlist->ssc_passing_year : '',
                        isset($registrationcompletestudentlist->ssc_result)? $registrationcompletestudentlist->ssc_result : '',
                        isset($registrationcompletestudentlist->hsc_institute)? $registrationcompletestudentlist->hsc_institute : '',
                        isset($registrationcompletestudentlist->hsc_board)? $registrationcompletestudentlist->hsc_board : '',
                        isset($registrationcompletestudentlist->hsc_group)? $registrationcompletestudentlist->hsc_group : '',
                        isset($registrationcompletestudentlist->hsc_passing_year)? $registrationcompletestudentlist->hsc_passing_year : '',
                        isset($registrationcompletestudentlist->hsc_result)? $registrationcompletestudentlist->hsc_result : '',
                        isset($registrationcompletestudentlist->bachelor_institute)? $registrationcompletestudentlist->bachelor_institute : '',
                        isset($registrationcompletestudentlist->bachelor_board)? $registrationcompletestudentlist->bachelor_board : '',
                        isset($registrationcompletestudentlist->bachelor_group)? $registrationcompletestudentlist->bachelor_group : '',
                        isset($registrationcompletestudentlist->bachelor_passing_year)? $registrationcompletestudentlist->bachelor_passing_year : '',
                        isset($registrationcompletestudentlist->bachelor_result)? $registrationcompletestudentlist->bachelor_result : '',
                        isset($registrationcompletestudentlist->masters_institute)? $registrationcompletestudentlist->masters_institute : '',
                        isset($registrationcompletestudentlist->masters_board)? $registrationcompletestudentlist->masters_board : '',
                        isset($registrationcompletestudentlist->masters_group)? $registrationcompletestudentlist->masters_group : '',
                        isset($registrationcompletestudentlist->masters_passing_year)? $registrationcompletestudentlist->masters_passing_year : '',
                        isset($registrationcompletestudentlist->masters_result)? $registrationcompletestudentlist->masters_result : '',
                        isset($registrationcompletestudentlist->guest1_name)? $registrationcompletestudentlist->guest1_name : '',
                        isset($registrationcompletestudentlist->guest1_relationship)? $registrationcompletestudentlist->guest1_relationship : '',
                        isset($registrationcompletestudentlist->guest1_nid_or_birth_cert)? $registrationcompletestudentlist->guest1_nid_or_birth_cert : '',
                        isset($registrationcompletestudentlist->guest1_present_address)? $registrationcompletestudentlist->guest1_present_address : '',
                        isset($registrationcompletestudentlist->guest1_permanent_address)? $registrationcompletestudentlist->guest1_permanent_address : '',
                        isset($registrationcompletestudentlist->guest2_name)? $registrationcompletestudentlist->guest2_name : '',
                        isset($registrationcompletestudentlist->guest2_relationship)? $registrationcompletestudentlist->guest2_relationship : '',
                        isset($registrationcompletestudentlist->guest2_nid_or_birth_cert)? $registrationcompletestudentlist->guest2_nid_or_birth_cert : '',
                        isset($registrationcompletestudentlist->guest2_present_address)? $registrationcompletestudentlist->guest2_present_address : '',
                        isset($registrationcompletestudentlist->guest2_permanent_address)? $registrationcompletestudentlist->guest2_permanent_address : '',
                    ];
    
             // Write data to a CSV file.
                    fputcsv($handle, $data);
                }
            });
    
            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);
    }
    
    //CSV - for double program registration completed
    public function registrationCompletedStudentListDoubleProgramInExcel(Request $request){
        $filename = 'Registration-completed-student-data-for-double-program.csv';
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
    
        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
    
            // Add CSV headers
            fputcsv($handle, [
                'Sign Up Time',
                'Form Submission Time',
                'Name',
                'Student ID',
                'Program',
                'Batch',
                'Major',
                'Minor',
                'Admission Year',
                'Admission Semester',
                'Father Name',
                'Mother Name',
                'Present Address',
                'Permanent address',
                'Organization Name',
                'Designation',
                'Office Address',
                'Phone',
                'Office Phone',
                'Office Mobile',
                'Email',
                'Blood group',
                'NID/Birth certificate number',
                'Credit Earned',
                'CGPA',
                'Result Publish Date',
                'Date of Birth',
                'Passing trimester/semester',
                'Passing Year',
                'SSC Institute',
                'SSC Board',
                'SSC Group',
                'SSC Passing Year',
                'SSC Result',
                'HSC Institute',
                'HSC Board',
                'HSC Group',
                'HSC Passing Year',
                'HSC Result',
                'Bachelor Institute',
                'Bachelor Board',
                'Bachelor Group',
                'Bachelor Passing Year',
                'Bachelor Result',
                'Masters Institute',
                'Masters Board',
                'Masters Group',
                'Masters Passing Year',
                'Masters Result',
                'Guest1 Name',
                'Guest1 Relationship',
                'Guest1 NID/Birth certificate number',
                'Guest1 Present Address',
                'Guest1 Permanent Address',
                'Guest2 Name',
                'Guest2 Relationship',
                'Guest2 NID/Birth certificate number',
                'Guest2 Present Address',
                'Guest2 Permanent Address',
            ]);
    
             // Fetch and process data in chunks
            GraduateList::where('registration_complete_status', 1)->where('second_program_info_complete_status', '!=', 0)->with(['programInfo', 'batchInfo', 'secondProgramInfo'])->chunk(25, function ($registrationCompleteStudentLists) use ($handle) {
                foreach ($registrationCompleteStudentLists as $registrationcompletestudentlist) {
             // Extract data from each employee.
                    $data = [
                        isset($registrationcompletestudentlist->sign_up_time)? $registrationcompletestudentlist->sign_up_time : '',
                        isset($registrationcompletestudentlist->form_submission_date)? $registrationcompletestudentlist->form_submission_date : '',
                        isset($registrationcompletestudentlist->name)? $registrationcompletestudentlist->name : '',
                        isset($registrationcompletestudentlist->student_id)? $registrationcompletestudentlist->student_id : '',
                        isset($registrationcompletestudentlist->programInfo->program_name)? $registrationcompletestudentlist->programInfo->program_name : '',
                        isset($registrationcompletestudentlist->batchInfo->batch_name)? $registrationcompletestudentlist->batchInfo->batch_name : '',
                        isset($registrationcompletestudentlist->major)? $registrationcompletestudentlist->major : '',
                        isset($registrationcompletestudentlist->minor)? $registrationcompletestudentlist->minor : '',
                        isset($registrationcompletestudentlist->admission_year)? $registrationcompletestudentlist->admission_year : '',
                        isset($registrationcompletestudentlist->admission_semester)? $registrationcompletestudentlist->admission_semester : '',
                        isset($registrationcompletestudentlist->father_name)? $registrationcompletestudentlist->father_name : '',
                        isset($registrationcompletestudentlist->mother_name)? $registrationcompletestudentlist->mother_name : '',
                        isset($registrationcompletestudentlist->present_address)? $registrationcompletestudentlist->present_address : '',
                        isset($registrationcompletestudentlist->permanent_address)? $registrationcompletestudentlist->permanent_address : '',
                        isset($registrationcompletestudentlist->organization_name)? $registrationcompletestudentlist->organization_name : '',
                        isset($registrationcompletestudentlist->designation)? $registrationcompletestudentlist->designation : '',
                        isset($registrationcompletestudentlist->office_address)? $registrationcompletestudentlist->office_address : '',
                        isset($registrationcompletestudentlist->phone)? $registrationcompletestudentlist->phone : '',
                        isset($registrationcompletestudentlist->office_phone)? $registrationcompletestudentlist->office_phone : '',
                        isset($registrationcompletestudentlist->office_mobile)? $registrationcompletestudentlist->office_mobile : '',
                        isset($registrationcompletestudentlist->email)? $registrationcompletestudentlist->email : '',
                        isset($registrationcompletestudentlist->blood_group)? $registrationcompletestudentlist->blood_group : '',
                        isset($registrationcompletestudentlist->nid_or_birth_cert_no)? $registrationcompletestudentlist->nid_or_birth_cert_no : '',
                        isset($registrationcompletestudentlist->credit_earned)? $registrationcompletestudentlist->credit_earned : '',
                        isset($registrationcompletestudentlist->cgpa)? $registrationcompletestudentlist->cgpa : '',
                        isset($registrationcompletestudentlist->result_publish_date)? $registrationcompletestudentlist->result_publish_date : '',
                        isset($registrationcompletestudentlist->dob)? $registrationcompletestudentlist->dob : '',
                        isset($registrationcompletestudentlist->passing_trimester)? $registrationcompletestudentlist->passing_trimester : '',
                        isset($registrationcompletestudentlist->passing_year)? $registrationcompletestudentlist->passing_year : '',
                        isset($registrationcompletestudentlist->ssc_institute)? $registrationcompletestudentlist->ssc_institute : '',
                        isset($registrationcompletestudentlist->ssc_board)? $registrationcompletestudentlist->ssc_board : '',
                        isset($registrationcompletestudentlist->ssc_group)? $registrationcompletestudentlist->ssc_group : '',
                        isset($registrationcompletestudentlist->ssc_passing_year)? $registrationcompletestudentlist->ssc_passing_year : '',
                        isset($registrationcompletestudentlist->ssc_result)? $registrationcompletestudentlist->ssc_result : '',
                        isset($registrationcompletestudentlist->hsc_institute)? $registrationcompletestudentlist->hsc_institute : '',
                        isset($registrationcompletestudentlist->hsc_board)? $registrationcompletestudentlist->hsc_board : '',
                        isset($registrationcompletestudentlist->hsc_group)? $registrationcompletestudentlist->hsc_group : '',
                        isset($registrationcompletestudentlist->hsc_passing_year)? $registrationcompletestudentlist->hsc_passing_year : '',
                        isset($registrationcompletestudentlist->hsc_result)? $registrationcompletestudentlist->hsc_result : '',
                        isset($registrationcompletestudentlist->bachelor_institute)? $registrationcompletestudentlist->bachelor_institute : '',
                        isset($registrationcompletestudentlist->bachelor_board)? $registrationcompletestudentlist->bachelor_board : '',
                        isset($registrationcompletestudentlist->bachelor_group)? $registrationcompletestudentlist->bachelor_group : '',
                        isset($registrationcompletestudentlist->bachelor_passing_year)? $registrationcompletestudentlist->bachelor_passing_year : '',
                        isset($registrationcompletestudentlist->bachelor_result)? $registrationcompletestudentlist->bachelor_result : '',
                        isset($registrationcompletestudentlist->masters_institute)? $registrationcompletestudentlist->masters_institute : '',
                        isset($registrationcompletestudentlist->masters_board)? $registrationcompletestudentlist->masters_board : '',
                        isset($registrationcompletestudentlist->masters_group)? $registrationcompletestudentlist->masters_group : '',
                        isset($registrationcompletestudentlist->masters_passing_year)? $registrationcompletestudentlist->masters_passing_year : '',
                        isset($registrationcompletestudentlist->masters_result)? $registrationcompletestudentlist->masters_result : '',
                        isset($registrationcompletestudentlist->guest1_name)? $registrationcompletestudentlist->guest1_name : '',
                        isset($registrationcompletestudentlist->guest1_relationship)? $registrationcompletestudentlist->guest1_relationship : '',
                        isset($registrationcompletestudentlist->guest1_nid_or_birth_cert)? $registrationcompletestudentlist->guest1_nid_or_birth_cert : '',
                        isset($registrationcompletestudentlist->guest1_present_address)? $registrationcompletestudentlist->guest1_present_address : '',
                        isset($registrationcompletestudentlist->guest1_permanent_address)? $registrationcompletestudentlist->guest1_permanent_address : '',
                        isset($registrationcompletestudentlist->guest2_name)? $registrationcompletestudentlist->guest2_name : '',
                        isset($registrationcompletestudentlist->guest2_relationship)? $registrationcompletestudentlist->guest2_relationship : '',
                        isset($registrationcompletestudentlist->guest2_nid_or_birth_cert)? $registrationcompletestudentlist->guest2_nid_or_birth_cert : '',
                        isset($registrationcompletestudentlist->guest2_present_address)? $registrationcompletestudentlist->guest2_present_address : '',
                        isset($registrationcompletestudentlist->guest2_permanent_address)? $registrationcompletestudentlist->guest2_permanent_address : '',
                    ];
    
             // Write data to a CSV file.
                    fputcsv($handle, $data);
                }
            });
    
            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);
    }
    
    //CSV - Unregistered student list
    public function unRegisteredStudentListInExcel(Request $request){
        $filename = 'Unregistered-student-data.csv';
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
    
        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
    
            // Add CSV headers
            fputcsv($handle, [
                'Name',
                'Student ID',
                'Program',
                'Batch',
                'Major',
                'Minor',
                'Admission Year',
                'Admission Semester',
                'Father Name',
                'Mother Name',
                'Present Address',
                'Permanent address',
                'Organization Name',
                'Designation',
                'Office Address',
                'Phone',
                'Office Phone',
                'Office Mobile',
                'Email',
                'Blood group',
                'NID/Birth certificate number',
                'Credit Earned',
                'CGPA',
                'Result Publish Date',
                'Date of Birth',
                'Passing trimester/semester',
                'Passing Year',
                'SSC Institute',
                'SSC Board',
                'SSC Group',
                'SSC Passing Year',
                'SSC Result',
                'HSC Institute',
                'HSC Board',
                'HSC Group',
                'HSC Passing Year',
                'HSC Result',
                'Bachelor Institute',
                'Bachelor Board',
                'Bachelor Group',
                'Bachelor Passing Year',
                'Bachelor Result',
                'Masters Institute',
                'Masters Board',
                'Masters Group',
                'Masters Passing Year',
                'Masters Result',
                'Guest1 Name',
                'Guest1 Relationship',
                'Guest1 NID/Birth certificate number',
                'Guest1 Present Address',
                'Guest1 Permanent Address',
                'Guest2 Name',
                'Guest2 Relationship',
                'Guest2 NID/Birth certificate number',
                'Guest2 Present Address',
                'Guest2 Permanent Address',
            ]);
    
             // Fetch and process data in chunks
            GraduateList::where('registration_complete_status', 0)->with(['programInfo', 'batchInfo', 'secondProgramInfo'])->chunk(25, function ($registrationCompleteStudentLists) use ($handle) {
                foreach ($registrationCompleteStudentLists as $registrationcompletestudentlist) {
             // Extract data from each employee.
                    $data = [
                        isset($registrationcompletestudentlist->name)? $registrationcompletestudentlist->name : '',
                        isset($registrationcompletestudentlist->student_id)? $registrationcompletestudentlist->student_id : '',
                        isset($registrationcompletestudentlist->programInfo->program_name)? $registrationcompletestudentlist->programInfo->program_name : '',
                        isset($registrationcompletestudentlist->batchInfo->batch_name)? $registrationcompletestudentlist->batchInfo->batch_name : '',
                        isset($registrationcompletestudentlist->major)? $registrationcompletestudentlist->major : '',
                        isset($registrationcompletestudentlist->minor)? $registrationcompletestudentlist->minor : '',
                        isset($registrationcompletestudentlist->admission_year)? $registrationcompletestudentlist->admission_year : '',
                        isset($registrationcompletestudentlist->admission_semester)? $registrationcompletestudentlist->admission_semester : '',
                        isset($registrationcompletestudentlist->father_name)? $registrationcompletestudentlist->father_name : '',
                        isset($registrationcompletestudentlist->mother_name)? $registrationcompletestudentlist->mother_name : '',
                        isset($registrationcompletestudentlist->present_address)? $registrationcompletestudentlist->present_address : '',
                        isset($registrationcompletestudentlist->permanent_address)? $registrationcompletestudentlist->permanent_address : '',
                        isset($registrationcompletestudentlist->organization_name)? $registrationcompletestudentlist->organization_name : '',
                        isset($registrationcompletestudentlist->designation)? $registrationcompletestudentlist->designation : '',
                        isset($registrationcompletestudentlist->office_address)? $registrationcompletestudentlist->office_address : '',
                        isset($registrationcompletestudentlist->phone)? $registrationcompletestudentlist->phone : '',
                        isset($registrationcompletestudentlist->office_phone)? $registrationcompletestudentlist->office_phone : '',
                        isset($registrationcompletestudentlist->office_mobile)? $registrationcompletestudentlist->office_mobile : '',
                        isset($registrationcompletestudentlist->email)? $registrationcompletestudentlist->email : '',
                        isset($registrationcompletestudentlist->blood_group)? $registrationcompletestudentlist->blood_group : '',
                        isset($registrationcompletestudentlist->nid_or_birth_cert_no)? $registrationcompletestudentlist->nid_or_birth_cert_no : '',
                        isset($registrationcompletestudentlist->credit_earned)? $registrationcompletestudentlist->credit_earned : '',
                        isset($registrationcompletestudentlist->cgpa)? $registrationcompletestudentlist->cgpa : '',
                        isset($registrationcompletestudentlist->result_publish_date)? $registrationcompletestudentlist->result_publish_date : '',
                        isset($registrationcompletestudentlist->dob)? $registrationcompletestudentlist->dob : '',
                        isset($registrationcompletestudentlist->passing_trimester)? $registrationcompletestudentlist->passing_trimester : '',
                        isset($registrationcompletestudentlist->passing_year)? $registrationcompletestudentlist->passing_year : '',
                        isset($registrationcompletestudentlist->ssc_institute)? $registrationcompletestudentlist->ssc_institute : '',
                        isset($registrationcompletestudentlist->ssc_board)? $registrationcompletestudentlist->ssc_board : '',
                        isset($registrationcompletestudentlist->ssc_group)? $registrationcompletestudentlist->ssc_group : '',
                        isset($registrationcompletestudentlist->ssc_passing_year)? $registrationcompletestudentlist->ssc_passing_year : '',
                        isset($registrationcompletestudentlist->ssc_result)? $registrationcompletestudentlist->ssc_result : '',
                        isset($registrationcompletestudentlist->hsc_institute)? $registrationcompletestudentlist->hsc_institute : '',
                        isset($registrationcompletestudentlist->hsc_board)? $registrationcompletestudentlist->hsc_board : '',
                        isset($registrationcompletestudentlist->hsc_group)? $registrationcompletestudentlist->hsc_group : '',
                        isset($registrationcompletestudentlist->hsc_passing_year)? $registrationcompletestudentlist->hsc_passing_year : '',
                        isset($registrationcompletestudentlist->hsc_result)? $registrationcompletestudentlist->hsc_result : '',
                        isset($registrationcompletestudentlist->bachelor_institute)? $registrationcompletestudentlist->bachelor_institute : '',
                        isset($registrationcompletestudentlist->bachelor_board)? $registrationcompletestudentlist->bachelor_board : '',
                        isset($registrationcompletestudentlist->bachelor_group)? $registrationcompletestudentlist->bachelor_group : '',
                        isset($registrationcompletestudentlist->bachelor_passing_year)? $registrationcompletestudentlist->bachelor_passing_year : '',
                        isset($registrationcompletestudentlist->bachelor_result)? $registrationcompletestudentlist->bachelor_result : '',
                        isset($registrationcompletestudentlist->masters_institute)? $registrationcompletestudentlist->masters_institute : '',
                        isset($registrationcompletestudentlist->masters_board)? $registrationcompletestudentlist->masters_board : '',
                        isset($registrationcompletestudentlist->masters_group)? $registrationcompletestudentlist->masters_group : '',
                        isset($registrationcompletestudentlist->masters_passing_year)? $registrationcompletestudentlist->masters_passing_year : '',
                        isset($registrationcompletestudentlist->masters_result)? $registrationcompletestudentlist->masters_result : '',
                        isset($registrationcompletestudentlist->guest1_name)? $registrationcompletestudentlist->guest1_name : '',
                        isset($registrationcompletestudentlist->guest1_relationship)? $registrationcompletestudentlist->guest1_relationship : '',
                        isset($registrationcompletestudentlist->guest1_nid_or_birth_cert)? $registrationcompletestudentlist->guest1_nid_or_birth_cert : '',
                        isset($registrationcompletestudentlist->guest1_present_address)? $registrationcompletestudentlist->guest1_present_address : '',
                        isset($registrationcompletestudentlist->guest1_permanent_address)? $registrationcompletestudentlist->guest1_permanent_address : '',
                        isset($registrationcompletestudentlist->guest2_name)? $registrationcompletestudentlist->guest2_name : '',
                        isset($registrationcompletestudentlist->guest2_relationship)? $registrationcompletestudentlist->guest2_relationship : '',
                        isset($registrationcompletestudentlist->guest2_nid_or_birth_cert)? $registrationcompletestudentlist->guest2_nid_or_birth_cert : '',
                        isset($registrationcompletestudentlist->guest2_present_address)? $registrationcompletestudentlist->guest2_present_address : '',
                        isset($registrationcompletestudentlist->guest2_permanent_address)? $registrationcompletestudentlist->guest2_permanent_address : '',
                    ];
    
             // Write data to a CSV file.
                    fputcsv($handle, $data);
                }
            });
    
            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);
    }
    
    
    // Registration confirmation
    public function registrationConfirmation(Request $request): RedirectResponse{
        $loggedUser = Auth::user()->id;
        
        $GraduateData = GraduateList::where('id', $request->modal_id)->first();
        $allData = User::where('student_id', $GraduateData->student_id)->first();

        /*
        $details = [
            'name' => $allData->name,
            'title' => 'Food Melody',
            'detailinfo' => $request['details'],
        ];
        */
        
        
        try{
            Mail::to($allData->email)->send(new RegistrationConfirmEmail());
            
            $update = GraduateList::where('id', $request->modal_id)->update([
            'registration_confirmation_status'=>1,
            'updated_by'=>$loggedUser,
            'updated_at'=>Carbon::now()->toDateTimeString(),
            ]);
            
            $second_program_grad_list_id = GraduateList::where('id', $request->modal_id)->value('second_program_grad_list_id');
                
            if($second_program_grad_list_id!=0){
                $update2 = GraduateList::where('id', $second_program_grad_list_id)->update([
                    'registration_confirmation_status'=>1,
                    'updated_by'=>$loggedUser,
                    'updated_at'=>Carbon::now()->toDateTimeString(),
                ]);
            }
            
            if($update){
                Session::flash('success','Registration Successfully Confirmed and Email Sent Successfully');
                return redirect()->route('all_student');
            }else{
                Session::flash('error','Registration confirmation process failed!');
                return redirect()->route('all_student');
            }
        }
        catch (\Exception $e) {
            Session::flash('error','Email sending failed!');
            return redirect()->route('all_student');
        }
        
    }
    
    //CSV - for single program registration confirmed
    public function registrationConfirmedStudentListSingleProgramInExcel(Request $request){
        $filename = 'Registration-confirmed-student-data-for-single-program.csv';
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
    
        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
    
            // Add CSV headers
            fputcsv($handle, [
                'Sign Up Time',
                'Form Submission Time',
                'Name',
                'Student ID',
                'Program',
                'Batch',
                'Major',
                'Minor',
                'Admission Year',
                'Admission Semester',
                'Father Name',
                'Mother Name',
                'Present Address',
                'Permanent address',
                'Organization Name',
                'Designation',
                'Office Address',
                'Phone',
                'Office Phone',
                'Office Mobile',
                'Email',
                'Blood group',
                'NID/Birth certificate number',
                'Credit Earned',
                'CGPA',
                'Result Publish Date',
                'Date of Birth',
                'Passing trimester/semester',
                'Passing Year',
                'SSC Institute',
                'SSC Board',
                'SSC Group',
                'SSC Passing Year',
                'SSC Result',
                'HSC Institute',
                'HSC Board',
                'HSC Group',
                'HSC Passing Year',
                'HSC Result',
                'Bachelor Institute',
                'Bachelor Board',
                'Bachelor Group',
                'Bachelor Passing Year',
                'Bachelor Result',
                'Masters Institute',
                'Masters Board',
                'Masters Group',
                'Masters Passing Year',
                'Masters Result',
                'Guest1 Name',
                'Guest1 Relationship',
                'Guest1 NID/Birth certificate number',
                'Guest1 Present Address',
                'Guest1 Permanent Address',
                'Guest2 Name',
                'Guest2 Relationship',
                'Guest2 NID/Birth certificate number',
                'Guest2 Present Address',
                'Guest2 Permanent Address',
            ]);
    
             // Fetch and process data in chunks
            GraduateList::where('registration_complete_status', 1)->where('registration_confirmation_status', 1)->where('second_program_info_complete_status', 0)->with(['programInfo', 'batchInfo', 'secondProgramInfo'])->chunk(25, function ($registrationCompleteStudentLists) use ($handle) {
                foreach ($registrationCompleteStudentLists as $registrationcompletestudentlist) {
             // Extract data from each employee.
                    $data = [
                        isset($registrationcompletestudentlist->sign_up_time)? $registrationcompletestudentlist->sign_up_time : '',
                        isset($registrationcompletestudentlist->form_submission_date)? $registrationcompletestudentlist->form_submission_date : '',
                        isset($registrationcompletestudentlist->name)? $registrationcompletestudentlist->name : '',
                        isset($registrationcompletestudentlist->student_id)? $registrationcompletestudentlist->student_id : '',
                        isset($registrationcompletestudentlist->programInfo->program_name)? $registrationcompletestudentlist->programInfo->program_name : '',
                        isset($registrationcompletestudentlist->batchInfo->batch_name)? $registrationcompletestudentlist->batchInfo->batch_name : '',
                        isset($registrationcompletestudentlist->major)? $registrationcompletestudentlist->major : '',
                        isset($registrationcompletestudentlist->minor)? $registrationcompletestudentlist->minor : '',
                        isset($registrationcompletestudentlist->admission_year)? $registrationcompletestudentlist->admission_year : '',
                        isset($registrationcompletestudentlist->admission_semester)? $registrationcompletestudentlist->admission_semester : '',
                        isset($registrationcompletestudentlist->father_name)? $registrationcompletestudentlist->father_name : '',
                        isset($registrationcompletestudentlist->mother_name)? $registrationcompletestudentlist->mother_name : '',
                        isset($registrationcompletestudentlist->present_address)? $registrationcompletestudentlist->present_address : '',
                        isset($registrationcompletestudentlist->permanent_address)? $registrationcompletestudentlist->permanent_address : '',
                        isset($registrationcompletestudentlist->organization_name)? $registrationcompletestudentlist->organization_name : '',
                        isset($registrationcompletestudentlist->designation)? $registrationcompletestudentlist->designation : '',
                        isset($registrationcompletestudentlist->office_address)? $registrationcompletestudentlist->office_address : '',
                        isset($registrationcompletestudentlist->phone)? $registrationcompletestudentlist->phone : '',
                        isset($registrationcompletestudentlist->office_phone)? $registrationcompletestudentlist->office_phone : '',
                        isset($registrationcompletestudentlist->office_mobile)? $registrationcompletestudentlist->office_mobile : '',
                        isset($registrationcompletestudentlist->email)? $registrationcompletestudentlist->email : '',
                        isset($registrationcompletestudentlist->blood_group)? $registrationcompletestudentlist->blood_group : '',
                        isset($registrationcompletestudentlist->nid_or_birth_cert_no)? $registrationcompletestudentlist->nid_or_birth_cert_no : '',
                        isset($registrationcompletestudentlist->credit_earned)? $registrationcompletestudentlist->credit_earned : '',
                        isset($registrationcompletestudentlist->cgpa)? $registrationcompletestudentlist->cgpa : '',
                        isset($registrationcompletestudentlist->result_publish_date)? $registrationcompletestudentlist->result_publish_date : '',
                        isset($registrationcompletestudentlist->dob)? $registrationcompletestudentlist->dob : '',
                        isset($registrationcompletestudentlist->passing_trimester)? $registrationcompletestudentlist->passing_trimester : '',
                        isset($registrationcompletestudentlist->passing_year)? $registrationcompletestudentlist->passing_year : '',
                        isset($registrationcompletestudentlist->ssc_institute)? $registrationcompletestudentlist->ssc_institute : '',
                        isset($registrationcompletestudentlist->ssc_board)? $registrationcompletestudentlist->ssc_board : '',
                        isset($registrationcompletestudentlist->ssc_group)? $registrationcompletestudentlist->ssc_group : '',
                        isset($registrationcompletestudentlist->ssc_passing_year)? $registrationcompletestudentlist->ssc_passing_year : '',
                        isset($registrationcompletestudentlist->ssc_result)? $registrationcompletestudentlist->ssc_result : '',
                        isset($registrationcompletestudentlist->hsc_institute)? $registrationcompletestudentlist->hsc_institute : '',
                        isset($registrationcompletestudentlist->hsc_board)? $registrationcompletestudentlist->hsc_board : '',
                        isset($registrationcompletestudentlist->hsc_group)? $registrationcompletestudentlist->hsc_group : '',
                        isset($registrationcompletestudentlist->hsc_passing_year)? $registrationcompletestudentlist->hsc_passing_year : '',
                        isset($registrationcompletestudentlist->hsc_result)? $registrationcompletestudentlist->hsc_result : '',
                        isset($registrationcompletestudentlist->bachelor_institute)? $registrationcompletestudentlist->bachelor_institute : '',
                        isset($registrationcompletestudentlist->bachelor_board)? $registrationcompletestudentlist->bachelor_board : '',
                        isset($registrationcompletestudentlist->bachelor_group)? $registrationcompletestudentlist->bachelor_group : '',
                        isset($registrationcompletestudentlist->bachelor_passing_year)? $registrationcompletestudentlist->bachelor_passing_year : '',
                        isset($registrationcompletestudentlist->bachelor_result)? $registrationcompletestudentlist->bachelor_result : '',
                        isset($registrationcompletestudentlist->masters_institute)? $registrationcompletestudentlist->masters_institute : '',
                        isset($registrationcompletestudentlist->masters_board)? $registrationcompletestudentlist->masters_board : '',
                        isset($registrationcompletestudentlist->masters_group)? $registrationcompletestudentlist->masters_group : '',
                        isset($registrationcompletestudentlist->masters_passing_year)? $registrationcompletestudentlist->masters_passing_year : '',
                        isset($registrationcompletestudentlist->masters_result)? $registrationcompletestudentlist->masters_result : '',
                        isset($registrationcompletestudentlist->guest1_name)? $registrationcompletestudentlist->guest1_name : '',
                        isset($registrationcompletestudentlist->guest1_relationship)? $registrationcompletestudentlist->guest1_relationship : '',
                        isset($registrationcompletestudentlist->guest1_nid_or_birth_cert)? $registrationcompletestudentlist->guest1_nid_or_birth_cert : '',
                        isset($registrationcompletestudentlist->guest1_present_address)? $registrationcompletestudentlist->guest1_present_address : '',
                        isset($registrationcompletestudentlist->guest1_permanent_address)? $registrationcompletestudentlist->guest1_permanent_address : '',
                        isset($registrationcompletestudentlist->guest2_name)? $registrationcompletestudentlist->guest2_name : '',
                        isset($registrationcompletestudentlist->guest2_relationship)? $registrationcompletestudentlist->guest2_relationship : '',
                        isset($registrationcompletestudentlist->guest2_nid_or_birth_cert)? $registrationcompletestudentlist->guest2_nid_or_birth_cert : '',
                        isset($registrationcompletestudentlist->guest2_present_address)? $registrationcompletestudentlist->guest2_present_address : '',
                        isset($registrationcompletestudentlist->guest2_permanent_address)? $registrationcompletestudentlist->guest2_permanent_address : '',
                    ];
    
             // Write data to a CSV file.
                    fputcsv($handle, $data);
                }
            });
    
            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);
    }
    
    //CSV - for double program registration confirmed
    public function registrationConfirmedStudentListDoubleProgramInExcel(Request $request){
        $filename = 'Registration-confirmed-student-data-for-double-program.csv';
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
    
        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
    
            // Add CSV headers
            fputcsv($handle, [
                'Sign Up Time',
                'Form Submission Time',
                'Name',
                'Student ID',
                'Program',
                'Batch',
                'Major',
                'Minor',
                'Admission Year',
                'Admission Semester',
                'Father Name',
                'Mother Name',
                'Present Address',
                'Permanent address',
                'Organization Name',
                'Designation',
                'Office Address',
                'Phone',
                'Office Phone',
                'Office Mobile',
                'Email',
                'Blood group',
                'NID/Birth certificate number',
                'Credit Earned',
                'CGPA',
                'Result Publish Date',
                'Date of Birth',
                'Passing trimester/semester',
                'Passing Year',
                'SSC Institute',
                'SSC Board',
                'SSC Group',
                'SSC Passing Year',
                'SSC Result',
                'HSC Institute',
                'HSC Board',
                'HSC Group',
                'HSC Passing Year',
                'HSC Result',
                'Bachelor Institute',
                'Bachelor Board',
                'Bachelor Group',
                'Bachelor Passing Year',
                'Bachelor Result',
                'Masters Institute',
                'Masters Board',
                'Masters Group',
                'Masters Passing Year',
                'Masters Result',
                'Guest1 Name',
                'Guest1 Relationship',
                'Guest1 NID/Birth certificate number',
                'Guest1 Present Address',
                'Guest1 Permanent Address',
                'Guest2 Name',
                'Guest2 Relationship',
                'Guest2 NID/Birth certificate number',
                'Guest2 Present Address',
                'Guest2 Permanent Address',
            ]);
    
             // Fetch and process data in chunks
            GraduateList::where('registration_complete_status', 1)->where('registration_confirmation_status', 1)->where('second_program_info_complete_status', '!=', 0)->with(['programInfo', 'batchInfo', 'secondProgramInfo'])->chunk(25, function ($registrationCompleteStudentLists) use ($handle) {
                foreach ($registrationCompleteStudentLists as $registrationcompletestudentlist) {
             // Extract data from each employee.
                    $data = [
                        isset($registrationcompletestudentlist->sign_up_time)? $registrationcompletestudentlist->sign_up_time : '',
                        isset($registrationcompletestudentlist->form_submission_date)? $registrationcompletestudentlist->form_submission_date : '',
                        isset($registrationcompletestudentlist->name)? $registrationcompletestudentlist->name : '',
                        isset($registrationcompletestudentlist->student_id)? $registrationcompletestudentlist->student_id : '',
                        isset($registrationcompletestudentlist->programInfo->program_name)? $registrationcompletestudentlist->programInfo->program_name : '',
                        isset($registrationcompletestudentlist->batchInfo->batch_name)? $registrationcompletestudentlist->batchInfo->batch_name : '',
                        isset($registrationcompletestudentlist->major)? $registrationcompletestudentlist->major : '',
                        isset($registrationcompletestudentlist->minor)? $registrationcompletestudentlist->minor : '',
                        isset($registrationcompletestudentlist->admission_year)? $registrationcompletestudentlist->admission_year : '',
                        isset($registrationcompletestudentlist->admission_semester)? $registrationcompletestudentlist->admission_semester : '',
                        isset($registrationcompletestudentlist->father_name)? $registrationcompletestudentlist->father_name : '',
                        isset($registrationcompletestudentlist->mother_name)? $registrationcompletestudentlist->mother_name : '',
                        isset($registrationcompletestudentlist->present_address)? $registrationcompletestudentlist->present_address : '',
                        isset($registrationcompletestudentlist->permanent_address)? $registrationcompletestudentlist->permanent_address : '',
                        isset($registrationcompletestudentlist->organization_name)? $registrationcompletestudentlist->organization_name : '',
                        isset($registrationcompletestudentlist->designation)? $registrationcompletestudentlist->designation : '',
                        isset($registrationcompletestudentlist->office_address)? $registrationcompletestudentlist->office_address : '',
                        isset($registrationcompletestudentlist->phone)? $registrationcompletestudentlist->phone : '',
                        isset($registrationcompletestudentlist->office_phone)? $registrationcompletestudentlist->office_phone : '',
                        isset($registrationcompletestudentlist->office_mobile)? $registrationcompletestudentlist->office_mobile : '',
                        isset($registrationcompletestudentlist->email)? $registrationcompletestudentlist->email : '',
                        isset($registrationcompletestudentlist->blood_group)? $registrationcompletestudentlist->blood_group : '',
                        isset($registrationcompletestudentlist->nid_or_birth_cert_no)? $registrationcompletestudentlist->nid_or_birth_cert_no : '',
                        isset($registrationcompletestudentlist->credit_earned)? $registrationcompletestudentlist->credit_earned : '',
                        isset($registrationcompletestudentlist->cgpa)? $registrationcompletestudentlist->cgpa : '',
                        isset($registrationcompletestudentlist->result_publish_date)? $registrationcompletestudentlist->result_publish_date : '',
                        isset($registrationcompletestudentlist->dob)? $registrationcompletestudentlist->dob : '',
                        isset($registrationcompletestudentlist->passing_trimester)? $registrationcompletestudentlist->passing_trimester : '',
                        isset($registrationcompletestudentlist->passing_year)? $registrationcompletestudentlist->passing_year : '',
                        isset($registrationcompletestudentlist->ssc_institute)? $registrationcompletestudentlist->ssc_institute : '',
                        isset($registrationcompletestudentlist->ssc_board)? $registrationcompletestudentlist->ssc_board : '',
                        isset($registrationcompletestudentlist->ssc_group)? $registrationcompletestudentlist->ssc_group : '',
                        isset($registrationcompletestudentlist->ssc_passing_year)? $registrationcompletestudentlist->ssc_passing_year : '',
                        isset($registrationcompletestudentlist->ssc_result)? $registrationcompletestudentlist->ssc_result : '',
                        isset($registrationcompletestudentlist->hsc_institute)? $registrationcompletestudentlist->hsc_institute : '',
                        isset($registrationcompletestudentlist->hsc_board)? $registrationcompletestudentlist->hsc_board : '',
                        isset($registrationcompletestudentlist->hsc_group)? $registrationcompletestudentlist->hsc_group : '',
                        isset($registrationcompletestudentlist->hsc_passing_year)? $registrationcompletestudentlist->hsc_passing_year : '',
                        isset($registrationcompletestudentlist->hsc_result)? $registrationcompletestudentlist->hsc_result : '',
                        isset($registrationcompletestudentlist->bachelor_institute)? $registrationcompletestudentlist->bachelor_institute : '',
                        isset($registrationcompletestudentlist->bachelor_board)? $registrationcompletestudentlist->bachelor_board : '',
                        isset($registrationcompletestudentlist->bachelor_group)? $registrationcompletestudentlist->bachelor_group : '',
                        isset($registrationcompletestudentlist->bachelor_passing_year)? $registrationcompletestudentlist->bachelor_passing_year : '',
                        isset($registrationcompletestudentlist->bachelor_result)? $registrationcompletestudentlist->bachelor_result : '',
                        isset($registrationcompletestudentlist->masters_institute)? $registrationcompletestudentlist->masters_institute : '',
                        isset($registrationcompletestudentlist->masters_board)? $registrationcompletestudentlist->masters_board : '',
                        isset($registrationcompletestudentlist->masters_group)? $registrationcompletestudentlist->masters_group : '',
                        isset($registrationcompletestudentlist->masters_passing_year)? $registrationcompletestudentlist->masters_passing_year : '',
                        isset($registrationcompletestudentlist->masters_result)? $registrationcompletestudentlist->masters_result : '',
                        isset($registrationcompletestudentlist->guest1_name)? $registrationcompletestudentlist->guest1_name : '',
                        isset($registrationcompletestudentlist->guest1_relationship)? $registrationcompletestudentlist->guest1_relationship : '',
                        isset($registrationcompletestudentlist->guest1_nid_or_birth_cert)? $registrationcompletestudentlist->guest1_nid_or_birth_cert : '',
                        isset($registrationcompletestudentlist->guest1_present_address)? $registrationcompletestudentlist->guest1_present_address : '',
                        isset($registrationcompletestudentlist->guest1_permanent_address)? $registrationcompletestudentlist->guest1_permanent_address : '',
                        isset($registrationcompletestudentlist->guest2_name)? $registrationcompletestudentlist->guest2_name : '',
                        isset($registrationcompletestudentlist->guest2_relationship)? $registrationcompletestudentlist->guest2_relationship : '',
                        isset($registrationcompletestudentlist->guest2_nid_or_birth_cert)? $registrationcompletestudentlist->guest2_nid_or_birth_cert : '',
                        isset($registrationcompletestudentlist->guest2_present_address)? $registrationcompletestudentlist->guest2_present_address : '',
                        isset($registrationcompletestudentlist->guest2_permanent_address)? $registrationcompletestudentlist->guest2_permanent_address : '',
                    ];
    
             // Write data to a CSV file.
                    fputcsv($handle, $data);
                }
            });
    
            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);
    }
    
    ///// registration-completed-but-not-confirmed-student-list-for-single-program-in-excel
    
        public function totalRegistrationCompletedButNotConfirmedSingleProgramInExcel(Request $request){
        $filename = 'Registration-completed-but-not-confirmed-student-data-for-single-program.csv';
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
    
        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
    
            // Add CSV headers
            fputcsv($handle, [
                'Sign Up Time',
                'Form Submission Time',
                'Name',
                'Student ID',
                'Program',
                'Batch',
                'Major',
                'Minor',
                'Admission Year',
                'Admission Semester',
                'Father Name',
                'Mother Name',
                'Present Address',
                'Permanent address',
                'Organization Name',
                'Designation',
                'Office Address',
                'Phone',
                'Office Phone',
                'Office Mobile',
                'Email',
                'Blood group',
                'NID/Birth certificate number',
                'Credit Earned',
                'CGPA',
                'Result Publish Date',
                'Date of Birth',
                'Passing trimester/semester',
                'Passing Year',
                'SSC Institute',
                'SSC Board',
                'SSC Group',
                'SSC Passing Year',
                'SSC Result',
                'HSC Institute',
                'HSC Board',
                'HSC Group',
                'HSC Passing Year',
                'HSC Result',
                'Bachelor Institute',
                'Bachelor Board',
                'Bachelor Group',
                'Bachelor Passing Year',
                'Bachelor Result',
                'Masters Institute',
                'Masters Board',
                'Masters Group',
                'Masters Passing Year',
                'Masters Result',
                'Guest1 Name',
                'Guest1 Relationship',
                'Guest1 NID/Birth certificate number',
                'Guest1 Present Address',
                'Guest1 Permanent Address',
                'Guest2 Name',
                'Guest2 Relationship',
                'Guest2 NID/Birth certificate number',
                'Guest2 Present Address',
                'Guest2 Permanent Address',
            ]);
    
             // Fetch and process data in chunks
            GraduateList::where('registration_complete_status', 1)->where('registration_confirmation_status', 0)->where('second_program_info_complete_status', 0)->with(['programInfo', 'batchInfo', 'secondProgramInfo'])->chunk(25, function ($registrationCompleteStudentLists) use ($handle) {
                foreach ($registrationCompleteStudentLists as $registrationcompletestudentlist) {
             // Extract data from each employee.
                    $data = [
                        isset($registrationcompletestudentlist->sign_up_time)? $registrationcompletestudentlist->sign_up_time : '',
                        isset($registrationcompletestudentlist->form_submission_date)? $registrationcompletestudentlist->form_submission_date : '',
                        isset($registrationcompletestudentlist->name)? $registrationcompletestudentlist->name : '',
                        isset($registrationcompletestudentlist->student_id)? $registrationcompletestudentlist->student_id : '',
                        isset($registrationcompletestudentlist->programInfo->program_name)? $registrationcompletestudentlist->programInfo->program_name : '',
                        isset($registrationcompletestudentlist->batchInfo->batch_name)? $registrationcompletestudentlist->batchInfo->batch_name : '',
                        isset($registrationcompletestudentlist->major)? $registrationcompletestudentlist->major : '',
                        isset($registrationcompletestudentlist->minor)? $registrationcompletestudentlist->minor : '',
                        isset($registrationcompletestudentlist->admission_year)? $registrationcompletestudentlist->admission_year : '',
                        isset($registrationcompletestudentlist->admission_semester)? $registrationcompletestudentlist->admission_semester : '',
                        isset($registrationcompletestudentlist->father_name)? $registrationcompletestudentlist->father_name : '',
                        isset($registrationcompletestudentlist->mother_name)? $registrationcompletestudentlist->mother_name : '',
                        isset($registrationcompletestudentlist->present_address)? $registrationcompletestudentlist->present_address : '',
                        isset($registrationcompletestudentlist->permanent_address)? $registrationcompletestudentlist->permanent_address : '',
                        isset($registrationcompletestudentlist->organization_name)? $registrationcompletestudentlist->organization_name : '',
                        isset($registrationcompletestudentlist->designation)? $registrationcompletestudentlist->designation : '',
                        isset($registrationcompletestudentlist->office_address)? $registrationcompletestudentlist->office_address : '',
                        isset($registrationcompletestudentlist->phone)? $registrationcompletestudentlist->phone : '',
                        isset($registrationcompletestudentlist->office_phone)? $registrationcompletestudentlist->office_phone : '',
                        isset($registrationcompletestudentlist->office_mobile)? $registrationcompletestudentlist->office_mobile : '',
                        isset($registrationcompletestudentlist->email)? $registrationcompletestudentlist->email : '',
                        isset($registrationcompletestudentlist->blood_group)? $registrationcompletestudentlist->blood_group : '',
                        isset($registrationcompletestudentlist->nid_or_birth_cert_no)? $registrationcompletestudentlist->nid_or_birth_cert_no : '',
                        isset($registrationcompletestudentlist->credit_earned)? $registrationcompletestudentlist->credit_earned : '',
                        isset($registrationcompletestudentlist->cgpa)? $registrationcompletestudentlist->cgpa : '',
                        isset($registrationcompletestudentlist->result_publish_date)? $registrationcompletestudentlist->result_publish_date : '',
                        isset($registrationcompletestudentlist->dob)? $registrationcompletestudentlist->dob : '',
                        isset($registrationcompletestudentlist->passing_trimester)? $registrationcompletestudentlist->passing_trimester : '',
                        isset($registrationcompletestudentlist->passing_year)? $registrationcompletestudentlist->passing_year : '',
                        isset($registrationcompletestudentlist->ssc_institute)? $registrationcompletestudentlist->ssc_institute : '',
                        isset($registrationcompletestudentlist->ssc_board)? $registrationcompletestudentlist->ssc_board : '',
                        isset($registrationcompletestudentlist->ssc_group)? $registrationcompletestudentlist->ssc_group : '',
                        isset($registrationcompletestudentlist->ssc_passing_year)? $registrationcompletestudentlist->ssc_passing_year : '',
                        isset($registrationcompletestudentlist->ssc_result)? $registrationcompletestudentlist->ssc_result : '',
                        isset($registrationcompletestudentlist->hsc_institute)? $registrationcompletestudentlist->hsc_institute : '',
                        isset($registrationcompletestudentlist->hsc_board)? $registrationcompletestudentlist->hsc_board : '',
                        isset($registrationcompletestudentlist->hsc_group)? $registrationcompletestudentlist->hsc_group : '',
                        isset($registrationcompletestudentlist->hsc_passing_year)? $registrationcompletestudentlist->hsc_passing_year : '',
                        isset($registrationcompletestudentlist->hsc_result)? $registrationcompletestudentlist->hsc_result : '',
                        isset($registrationcompletestudentlist->bachelor_institute)? $registrationcompletestudentlist->bachelor_institute : '',
                        isset($registrationcompletestudentlist->bachelor_board)? $registrationcompletestudentlist->bachelor_board : '',
                        isset($registrationcompletestudentlist->bachelor_group)? $registrationcompletestudentlist->bachelor_group : '',
                        isset($registrationcompletestudentlist->bachelor_passing_year)? $registrationcompletestudentlist->bachelor_passing_year : '',
                        isset($registrationcompletestudentlist->bachelor_result)? $registrationcompletestudentlist->bachelor_result : '',
                        isset($registrationcompletestudentlist->masters_institute)? $registrationcompletestudentlist->masters_institute : '',
                        isset($registrationcompletestudentlist->masters_board)? $registrationcompletestudentlist->masters_board : '',
                        isset($registrationcompletestudentlist->masters_group)? $registrationcompletestudentlist->masters_group : '',
                        isset($registrationcompletestudentlist->masters_passing_year)? $registrationcompletestudentlist->masters_passing_year : '',
                        isset($registrationcompletestudentlist->masters_result)? $registrationcompletestudentlist->masters_result : '',
                        isset($registrationcompletestudentlist->guest1_name)? $registrationcompletestudentlist->guest1_name : '',
                        isset($registrationcompletestudentlist->guest1_relationship)? $registrationcompletestudentlist->guest1_relationship : '',
                        isset($registrationcompletestudentlist->guest1_nid_or_birth_cert)? $registrationcompletestudentlist->guest1_nid_or_birth_cert : '',
                        isset($registrationcompletestudentlist->guest1_present_address)? $registrationcompletestudentlist->guest1_present_address : '',
                        isset($registrationcompletestudentlist->guest1_permanent_address)? $registrationcompletestudentlist->guest1_permanent_address : '',
                        isset($registrationcompletestudentlist->guest2_name)? $registrationcompletestudentlist->guest2_name : '',
                        isset($registrationcompletestudentlist->guest2_relationship)? $registrationcompletestudentlist->guest2_relationship : '',
                        isset($registrationcompletestudentlist->guest2_nid_or_birth_cert)? $registrationcompletestudentlist->guest2_nid_or_birth_cert : '',
                        isset($registrationcompletestudentlist->guest2_present_address)? $registrationcompletestudentlist->guest2_present_address : '',
                        isset($registrationcompletestudentlist->guest2_permanent_address)? $registrationcompletestudentlist->guest2_permanent_address : '',
                    ];
    
             // Write data to a CSV file.
                    fputcsv($handle, $data);
                }
            });
    
            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);
    }
    
    //CSV - for registration-completed-but-not-confirmed-student-list-for-double-program-in-excel
    public function totalRegistrationCompletedButNotConfirmedDoubleProgramInExcel(Request $request){
        $filename = 'Registration-completed-but-not-confirmed-student-data-for-double-program.csv';
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
    
        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
    
            // Add CSV headers
            fputcsv($handle, [
                'Sign Up Time',
                'Form Submission Time',
                'Name',
                'Student ID',
                'Program',
                'Batch',
                'Major',
                'Minor',
                'Admission Year',
                'Admission Semester',
                'Father Name',
                'Mother Name',
                'Present Address',
                'Permanent address',
                'Organization Name',
                'Designation',
                'Office Address',
                'Phone',
                'Office Phone',
                'Office Mobile',
                'Email',
                'Blood group',
                'NID/Birth certificate number',
                'Credit Earned',
                'CGPA',
                'Result Publish Date',
                'Date of Birth',
                'Passing trimester/semester',
                'Passing Year',
                'SSC Institute',
                'SSC Board',
                'SSC Group',
                'SSC Passing Year',
                'SSC Result',
                'HSC Institute',
                'HSC Board',
                'HSC Group',
                'HSC Passing Year',
                'HSC Result',
                'Bachelor Institute',
                'Bachelor Board',
                'Bachelor Group',
                'Bachelor Passing Year',
                'Bachelor Result',
                'Masters Institute',
                'Masters Board',
                'Masters Group',
                'Masters Passing Year',
                'Masters Result',
                'Guest1 Name',
                'Guest1 Relationship',
                'Guest1 NID/Birth certificate number',
                'Guest1 Present Address',
                'Guest1 Permanent Address',
                'Guest2 Name',
                'Guest2 Relationship',
                'Guest2 NID/Birth certificate number',
                'Guest2 Present Address',
                'Guest2 Permanent Address',
            ]);
    
             // Fetch and process data in chunks
            GraduateList::where('registration_complete_status', 1)->where('registration_confirmation_status', 0)->where('second_program_info_complete_status', '!=', 0)->with(['programInfo', 'batchInfo', 'secondProgramInfo'])->chunk(25, function ($registrationCompleteStudentLists) use ($handle) {
                foreach ($registrationCompleteStudentLists as $registrationcompletestudentlist) {
             // Extract data from each employee.
                    $data = [
                        isset($registrationcompletestudentlist->sign_up_time)? $registrationcompletestudentlist->sign_up_time : '',
                        isset($registrationcompletestudentlist->form_submission_date)? $registrationcompletestudentlist->form_submission_date : '',
                        isset($registrationcompletestudentlist->name)? $registrationcompletestudentlist->name : '',
                        isset($registrationcompletestudentlist->student_id)? $registrationcompletestudentlist->student_id : '',
                        isset($registrationcompletestudentlist->programInfo->program_name)? $registrationcompletestudentlist->programInfo->program_name : '',
                        isset($registrationcompletestudentlist->batchInfo->batch_name)? $registrationcompletestudentlist->batchInfo->batch_name : '',
                        isset($registrationcompletestudentlist->major)? $registrationcompletestudentlist->major : '',
                        isset($registrationcompletestudentlist->minor)? $registrationcompletestudentlist->minor : '',
                        isset($registrationcompletestudentlist->admission_year)? $registrationcompletestudentlist->admission_year : '',
                        isset($registrationcompletestudentlist->admission_semester)? $registrationcompletestudentlist->admission_semester : '',
                        isset($registrationcompletestudentlist->father_name)? $registrationcompletestudentlist->father_name : '',
                        isset($registrationcompletestudentlist->mother_name)? $registrationcompletestudentlist->mother_name : '',
                        isset($registrationcompletestudentlist->present_address)? $registrationcompletestudentlist->present_address : '',
                        isset($registrationcompletestudentlist->permanent_address)? $registrationcompletestudentlist->permanent_address : '',
                        isset($registrationcompletestudentlist->organization_name)? $registrationcompletestudentlist->organization_name : '',
                        isset($registrationcompletestudentlist->designation)? $registrationcompletestudentlist->designation : '',
                        isset($registrationcompletestudentlist->office_address)? $registrationcompletestudentlist->office_address : '',
                        isset($registrationcompletestudentlist->phone)? $registrationcompletestudentlist->phone : '',
                        isset($registrationcompletestudentlist->office_phone)? $registrationcompletestudentlist->office_phone : '',
                        isset($registrationcompletestudentlist->office_mobile)? $registrationcompletestudentlist->office_mobile : '',
                        isset($registrationcompletestudentlist->email)? $registrationcompletestudentlist->email : '',
                        isset($registrationcompletestudentlist->blood_group)? $registrationcompletestudentlist->blood_group : '',
                        isset($registrationcompletestudentlist->nid_or_birth_cert_no)? $registrationcompletestudentlist->nid_or_birth_cert_no : '',
                        isset($registrationcompletestudentlist->credit_earned)? $registrationcompletestudentlist->credit_earned : '',
                        isset($registrationcompletestudentlist->cgpa)? $registrationcompletestudentlist->cgpa : '',
                        isset($registrationcompletestudentlist->result_publish_date)? $registrationcompletestudentlist->result_publish_date : '',
                        isset($registrationcompletestudentlist->dob)? $registrationcompletestudentlist->dob : '',
                        isset($registrationcompletestudentlist->passing_trimester)? $registrationcompletestudentlist->passing_trimester : '',
                        isset($registrationcompletestudentlist->passing_year)? $registrationcompletestudentlist->passing_year : '',
                        isset($registrationcompletestudentlist->ssc_institute)? $registrationcompletestudentlist->ssc_institute : '',
                        isset($registrationcompletestudentlist->ssc_board)? $registrationcompletestudentlist->ssc_board : '',
                        isset($registrationcompletestudentlist->ssc_group)? $registrationcompletestudentlist->ssc_group : '',
                        isset($registrationcompletestudentlist->ssc_passing_year)? $registrationcompletestudentlist->ssc_passing_year : '',
                        isset($registrationcompletestudentlist->ssc_result)? $registrationcompletestudentlist->ssc_result : '',
                        isset($registrationcompletestudentlist->hsc_institute)? $registrationcompletestudentlist->hsc_institute : '',
                        isset($registrationcompletestudentlist->hsc_board)? $registrationcompletestudentlist->hsc_board : '',
                        isset($registrationcompletestudentlist->hsc_group)? $registrationcompletestudentlist->hsc_group : '',
                        isset($registrationcompletestudentlist->hsc_passing_year)? $registrationcompletestudentlist->hsc_passing_year : '',
                        isset($registrationcompletestudentlist->hsc_result)? $registrationcompletestudentlist->hsc_result : '',
                        isset($registrationcompletestudentlist->bachelor_institute)? $registrationcompletestudentlist->bachelor_institute : '',
                        isset($registrationcompletestudentlist->bachelor_board)? $registrationcompletestudentlist->bachelor_board : '',
                        isset($registrationcompletestudentlist->bachelor_group)? $registrationcompletestudentlist->bachelor_group : '',
                        isset($registrationcompletestudentlist->bachelor_passing_year)? $registrationcompletestudentlist->bachelor_passing_year : '',
                        isset($registrationcompletestudentlist->bachelor_result)? $registrationcompletestudentlist->bachelor_result : '',
                        isset($registrationcompletestudentlist->masters_institute)? $registrationcompletestudentlist->masters_institute : '',
                        isset($registrationcompletestudentlist->masters_board)? $registrationcompletestudentlist->masters_board : '',
                        isset($registrationcompletestudentlist->masters_group)? $registrationcompletestudentlist->masters_group : '',
                        isset($registrationcompletestudentlist->masters_passing_year)? $registrationcompletestudentlist->masters_passing_year : '',
                        isset($registrationcompletestudentlist->masters_result)? $registrationcompletestudentlist->masters_result : '',
                        isset($registrationcompletestudentlist->guest1_name)? $registrationcompletestudentlist->guest1_name : '',
                        isset($registrationcompletestudentlist->guest1_relationship)? $registrationcompletestudentlist->guest1_relationship : '',
                        isset($registrationcompletestudentlist->guest1_nid_or_birth_cert)? $registrationcompletestudentlist->guest1_nid_or_birth_cert : '',
                        isset($registrationcompletestudentlist->guest1_present_address)? $registrationcompletestudentlist->guest1_present_address : '',
                        isset($registrationcompletestudentlist->guest1_permanent_address)? $registrationcompletestudentlist->guest1_permanent_address : '',
                        isset($registrationcompletestudentlist->guest2_name)? $registrationcompletestudentlist->guest2_name : '',
                        isset($registrationcompletestudentlist->guest2_relationship)? $registrationcompletestudentlist->guest2_relationship : '',
                        isset($registrationcompletestudentlist->guest2_nid_or_birth_cert)? $registrationcompletestudentlist->guest2_nid_or_birth_cert : '',
                        isset($registrationcompletestudentlist->guest2_present_address)? $registrationcompletestudentlist->guest2_present_address : '',
                        isset($registrationcompletestudentlist->guest2_permanent_address)? $registrationcompletestudentlist->guest2_permanent_address : '',
                    ];
    
             // Write data to a CSV file.
                    fputcsv($handle, $data);
                }
            });
    
            // Close CSV file handle
            fclose($handle);
        }, 200, $headers);
    }
    
    //CSV - for selected program registration confirmed
    public function adminAllSelectedStudentListInExcel(Request $request){
    $program_id = $request->query('program');
    $batch_id = $request->query('batch');
    
    // Retrieve the program and batch info
    $program = Program::where('program_id', $program_id)->first(); 
    $batch = Batch::where('batch_id', $batch_id)->first(); 
    
    // Check if program and batch exist
    if (!$program || !$batch) {
        abort(404, 'Program or Batch not found.');
    }
    
    // Get current date and format it
    $currentDate = now()->format('Y-m-d_H-i-s');
    
    // Create the filename using program name, batch name, and current date
    $filename = $batch->batch_name.' Batch - '.$program->program_name .' - Registration-confirmed-student-data - ' . $currentDate . '.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
        'Pragma' => 'no-cache',
        'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
        'Expires' => '0',
    ];

    return response()->stream(function () use ($program_id, $batch_id) {
        $handle = fopen('php://output', 'w');

        // Add CSV headers
        fputcsv($handle, [
            'Program',
            'Batch',
            'Student ID',
            'Name',
            'Program Status',
            'Signature',
        ]);

        // Fetch and process data in chunks
        GraduateList::where('registration_complete_status', 1)
            ->where('registration_confirmation_status', 1)
            ->where('program_id', $program_id)
            ->where('batch_id', $batch_id)
            ->with(['programInfo', 'batchInfo', 'secondProgramInfo'])
            ->chunk(25, function ($registrationCompleteStudentLists) use ($handle) {
                foreach ($registrationCompleteStudentLists as $registrationcompletestudentlist) {
                    // Extract data from each employee
                    $data = [
                        $registrationcompletestudentlist->programInfo->program_name ?? '',
                        $registrationcompletestudentlist->batchInfo->batch_name ?? '',
                        "'" . (string) $registrationcompletestudentlist->student_id, 
                        $registrationcompletestudentlist->name ?? '',
                        // Set program status based on student_program_choice
                        ($registrationcompletestudentlist->student_program_choice == 3) ? 'Double' : 
                        (($registrationcompletestudentlist->student_program_choice == 1) ? 'Single' : ''), // Default to empty if neither 3 nor 1
                    ];
                    // Write data to a CSV file
                    fputcsv($handle, $data);
                }
            });

        // Close CSV file handle
        fclose($handle);
        }, 200, $headers);
    }
    
}
