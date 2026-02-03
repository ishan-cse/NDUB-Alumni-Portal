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
use App\Models\ExitSurvey;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmEmail;
use Image;
use File;
use Barryvdh\DomPDF\Facade\Pdf;
use Excel;

class StudentExitSurveyController extends Controller{
    public function create(){
        $loggedUser = Auth::user()->id;
        $graduateListId = User::where('id', $loggedUser)->value('graduate_lists_id');
        $exitSurveySubmissionStatus = GraduateList::where('id', $graduateListId)->value('exit_survey_submission_status');
        return view('admin.student.student_exit_survey', compact('exitSurveySubmissionStatus'));
    }

    /**
     * Store Student Exit Survey data
     */
    public function store(Request $request){
        // ---------------- VALIDATION ----------------
        $rules = [];

        // a1–a10
        for ($i = 1; $i <= 10; $i++) {
            $rules['a'.$i] = 'required|integer|min:1|max:5';
        }

        // b1–b4
        for ($i = 1; $i <= 4; $i++) {
            $rules['b'.$i] = 'required|integer|min:1|max:5';
        }

        // c1–c7
        for ($i = 1; $i <= 7; $i++) {
            $rules['c'.$i] = 'required|integer|min:1|max:5';
        }

        // d1–d5
        for ($i = 1; $i <= 5; $i++) {
            $rules['d'.$i] = 'required|integer|min:1|max:5';
        }

        // e1–e4
        for ($i = 1; $i <= 4; $i++) {
            $rules['e'.$i] = 'required|integer|min:1|max:5';
        }

        // f1–f5
        for ($i = 1; $i <= 5; $i++) {
            $rules['f'.$i] = 'required|integer|min:1|max:5';
        }

        // g1–g12
        for ($i = 1; $i <= 12; $i++) {
            $rules['g'.$i] = 'required|integer|min:1|max:5';
        }

        // Text fields
        $rules['h1'] = 'nullable|string';
        $rules['h2'] = 'nullable|string';
        $rules['h3'] = 'nullable|string';
        $rules['h4'] = 'nullable|string';

        $request->validate($rules);

        $loggedUser = Auth::user()->id;

        //dd($request);

        ExitSurvey::create([
            // Governance
            'a1'  => $request->a1,
            'a2'  => $request->a2,
            'a3'  => $request->a3,
            'a4'  => $request->a4,
            'a5'  => $request->a5,
            'a6'  => $request->a6,
            'a7'  => $request->a7,
            'a8'  => $request->a8,
            'a9'  => $request->a9,
            'a10' => $request->a10,

            // Curriculum
            'b1' => $request->b1,
            'b2' => $request->b2,
            'b3' => $request->b3,
            'b4' => $request->b4,

            // Structures & Facilities
            'c1' => $request->c1,
            'c2' => $request->c2,
            'c3' => $request->c3,
            'c4' => $request->c4,
            'c5' => $request->c5,
            'c6' => $request->c6,
            'c7' => $request->c7,

            // Teaching-Learning
            'd1' => $request->d1,
            'd2' => $request->d2,
            'd3' => $request->d3,
            'd4' => $request->d4,
            'd5' => $request->d5,

            // Learning Assessment
            'e1' => $request->e1,
            'e2' => $request->e2,
            'e3' => $request->e3,
            'e4' => $request->e4,

            // Student Support Services
            'f1' => $request->f1,
            'f2' => $request->f2,
            'f3' => $request->f3,
            'f4' => $request->f4,
            'f5' => $request->f5,

            // Engineer’s Attributes (PLOs)
            'g1'  => $request->g1,
            'g2'  => $request->g2,
            'g3'  => $request->g3,
            'g4'  => $request->g4,
            'g5'  => $request->g5,
            'g6'  => $request->g6,
            'g7'  => $request->g7,
            'g8'  => $request->g8,
            'g9'  => $request->g9,
            'g10' => $request->g10,
            'g11' => $request->g11,
            'g12' => $request->g12,

            // Feedback
            'h1' => $request->h1,
            'h2' => $request->h2,
            'h3' => $request->h3,
            'h4' => $request->h4,

            // Meta
            'created_by'=>$loggedUser,
            'created_at'=>Carbon::now()->toDateTimeString(),
        ]);

        $loggedUser = Auth::user()->id;
        $graduateListId = User::where('id', $loggedUser)->value('graduate_lists_id');
        $update = GraduateList::where('id', $graduateListId)->update([
            'exit_survey_submission_status'=>1,
            'updated_by'=>$loggedUser,
            'updated_at'=>Carbon::now()->toDateTimeString(),
        ]);

        return redirect()->back()
            ->with('success', 'Student Exit Survey submitted successfully.');
    }
}
