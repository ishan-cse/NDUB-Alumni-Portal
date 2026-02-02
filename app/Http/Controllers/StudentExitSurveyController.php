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
    public function create()
    {
        return view('admin.student.student_exit_survey');
    }

    /**
     * Store survey data
     */
    public function store(Request $request)
    {
        // ================= VALIDATION =================
        $request->validate([
            // Governance
            'a1' => 'required|integer|min:1|max:5',
            'a2' => 'required|integer|min:1|max:5',
            'a3' => 'required|integer|min:1|max:5',
            'a4' => 'required|integer|min:1|max:5',
            'a5' => 'required|integer|min:1|max:5',
            'a6' => 'required|integer|min:1|max:5',
            'a7' => 'required|integer|min:1|max:5',
            'a8' => 'required|integer|min:1|max:5',
            'a9' => 'required|integer|min:1|max:5',
            'a10'=> 'required|integer|min:1|max:5',

            // Curriculum
            'b1' => 'required|integer|min:1|max:5',
            'b2' => 'required|integer|min:1|max:5',
            'b3' => 'required|integer|min:1|max:5',
            'b4' => 'required|integer|min:1|max:5',
            'b5' => 'nullable|string',

            // Structures & Facilities
            'c1' => 'required|integer|min:1|max:5',
            'c2' => 'required|integer|min:1|max:5',
            'c3' => 'required|integer|min:1|max:5',
            'c4' => 'required|integer|min:1|max:5',
            'c5' => 'required|integer|min:1|max:5',
            'c6' => 'required|integer|min:1|max:5',
            'c7' => 'required|integer|min:1|max:5',

            // Teaching-Learning
            'd1' => 'required|integer|min:1|max:5',
            'd2' => 'required|integer|min:1|max:5',
            'd3' => 'required|integer|min:1|max:5',
            'd4' => 'required|integer|min:1|max:5',
            'd5' => 'required|integer|min:1|max:5',

            // Learning Assessment
            'e1' => 'required|integer|min:1|max:5',
            'e2' => 'required|integer|min:1|max:5',
            'e3' => 'required|integer|min:1|max:5',
            'e4' => 'required|integer|min:1|max:5',
            'e5' => 'nullable|string',
            'e6' => 'required|integer|min:1|max:5',
            'e7' => 'required|integer|min:1|max:5',
            'e8' => 'required|integer|min:1|max:5',
            'e9' => 'required|integer|min:1|max:5',
            'e10'=> 'required|integer|min:1|max:5',

            // PLOs
            'f1'  => 'required|integer|min:1|max:5',
            'f2'  => 'required|integer|min:1|max:5',
            'f3'  => 'required|integer|min:1|max:5',
            'f4'  => 'required|integer|min:1|max:5',
            'f5'  => 'required|integer|min:1|max:5',
            'f6'  => 'required|integer|min:1|max:5',
            'f7'  => 'required|integer|min:1|max:5',
            'f8'  => 'required|integer|min:1|max:5',
            'f9'  => 'required|integer|min:1|max:5',
            'f10' => 'required|integer|min:1|max:5',
            'f11' => 'required|integer|min:1|max:5',
            'f12' => 'required|integer|min:1|max:5',

            'f13' => 'nullable|string',
            'f14' => 'nullable|string',
            'f15' => 'nullable|string',
            'f16' => 'nullable|string',
            'f17' => 'nullable|string',
        ]);

        try {
            // ================= STORE DATA =================
            ExitSurvey::create([
                // Governance
                'a1' => $request->a1,
                'a2' => $request->a2,
                'a3' => $request->a3,
                'a4' => $request->a4,
                'a5' => $request->a5,
                'a6' => $request->a6,
                'a7' => $request->a7,
                'a8' => $request->a8,
                'a9' => $request->a9,
                'a10'=> $request->a10,

                // Curriculum
                'b1' => $request->b1,
                'b2' => $request->b2,
                'b3' => $request->b3,
                'b4' => $request->b4,
                'b5' => $request->b5,

                // Structures
                'c1' => $request->c1,
                'c2' => $request->c2,
                'c3' => $request->c3,
                'c4' => $request->c4,
                'c5' => $request->c5,
                'c6' => $request->c6,
                'c7' => $request->c7,

                // Teaching
                'd1' => $request->d1,
                'd2' => $request->d2,
                'd3' => $request->d3,
                'd4' => $request->d4,
                'd5' => $request->d5,

                // Assessment
                'e1' => $request->e1,
                'e2' => $request->e2,
                'e3' => $request->e3,
                'e4' => $request->e4,
                'e5' => $request->e5,
                'e6' => $request->e6,
                'e7' => $request->e7,
                'e8' => $request->e8,
                'e9' => $request->e9,
                'e10'=> $request->e10,

                // PLO
                'f1'  => $request->f1,
                'f2'  => $request->f2,
                'f3'  => $request->f3,
                'f4'  => $request->f4,
                'f5'  => $request->f5,
                'f6'  => $request->f6,
                'f7'  => $request->f7,
                'f8'  => $request->f8,
                'f9'  => $request->f9,
                'f10' => $request->f10,
                'f11' => $request->f11,
                'f12' => $request->f12,

                'f13' => $request->f13,
                'f14' => $request->f14,
                'f15' => $request->f15,
                'f16' => $request->f16,
                'f17' => $request->f17,
            ]);

            return redirect()->back()->with('success', 'Student Exit Survey submitted successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }
}
