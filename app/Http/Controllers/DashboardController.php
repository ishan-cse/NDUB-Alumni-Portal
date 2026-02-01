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
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Image;
use File;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller{
    public function dashboard(){
        if(Auth::user()->role_id==1 || Auth::user()->role_id==2){
                $programs = Program::all();
                $batchs = Batch::all();
                $SignUpNotRegistered = GraduateList::where('sign_up_status', 1)->where('registration_complete_status', 0)->count();
                $notSignUp = GraduateList::where('sign_up_status', 0)->where('registration_complete_status', 0)->count();
                $TotalRegistrationComplete = GraduateList::where('registration_complete_status', 1)->where('child_account_status', 0)->count();
                $TotalRegisteredOneProgram = GraduateList::where('registration_complete_status', 1)->where('student_program_choice', 1)->count();
                $TotalRegisteredDoubleProgram = GraduateList::where('registration_complete_status', 1)->where('student_program_choice', 3)->where('child_account_status', 0)->count();
                $TotalUnregisteredStudent = GraduateList::where('registration_complete_status', 0)->count();
                $InfoFillUp = GraduateList::where('registration_complete_status', 0)->where('edit_start_status', 1)->where('child_account_status', 0)->count();
                $TotalRegistrationConfirmed = GraduateList::where('registration_complete_status', 1)->where('registration_confirmation_status', 1)->where('child_account_status', 0)->count();
                $TotalRegistrationConfirmedOneProgram = GraduateList::where('registration_complete_status', 1)->where('registration_confirmation_status', 1)->where('student_program_choice', 1)->count();
                $TotalRegistrationConfirmedDoubleProgram = GraduateList::where('registration_complete_status', 1)->where('registration_confirmation_status', 1)->where('student_program_choice', 3)->where('child_account_status', 0)->count();
                $TotalRegistrationCompletedButNotConfirmed = GraduateList::where('registration_complete_status', 1)->where('registration_confirmation_status', 0)->where('child_account_status', 0)->count();
                return view('admin.dashboard.dashboard', compact('SignUpNotRegistered', 'notSignUp', 'TotalRegistrationComplete', 'TotalRegisteredOneProgram', 'TotalRegisteredDoubleProgram', 'TotalUnregisteredStudent', 'InfoFillUp', 'TotalRegistrationConfirmed', 'TotalRegistrationConfirmedOneProgram', 'TotalRegistrationConfirmedDoubleProgram', 'TotalRegistrationCompletedButNotConfirmed', 'programs', 'batchs'));    
        }elseif(Auth::user()->role_id==3){
            $user = GraduateList::where('id', Auth::user()->graduate_lists_id)->first();
    
            if($user->child_account_status=='0'){
                
                return view('student.dashboard.dashboard', compact('user'));
            }elseif($user->child_account_status=='1'){
                return view('student.dashboard.second-program-dashboard', compact('user'));
            }
        }
    }
}
