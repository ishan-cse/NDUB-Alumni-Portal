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
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Models\SupportTicket;
use Image;
use File;

class SupportTicketController extends Controller{
    public function add(): View{
        return view('support-ticket.add');
    }

    public function submit(Request $request){
        $this->validate($request,[
            'student_id' =>'required|max:255',
            'name' =>'required|max:255',
            'email' =>'required|max:255',
            'phone' =>'required|max:255',
            'details' =>'required|max:255',
        ],[
        ]);

        $insert = SupportTicket::create([
            'student_id' => $request->student_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'details' => $request->details,
            'created_at'=>Carbon::now()->toDateTimeString(),
        ]);

        if($insert){
            Session::flash('success','Submitted successfully!');
            return redirect()->route('add_support_ticket');
        }else{
            Session::flash('error','Submission failed!');
            return redirect()->route('add_support_ticket');
        }

    }
    
    public function allSupportTicket(){
        $all = SupportTicket::orderBy('support_ticket_id', 'DESC')->get();
        return view('support-ticket.all', compact('all'));
    }

    public function solveSupport(Request $request): RedirectResponse{
        $this->validate($request,[
            'remarks'=>'max:255',
        ],[
        ]);
        $loggedUser = Auth::user()->id;
        
        $update = SupportTicket::where('support_ticket_id', $request->modal_id)->update([
            'remarks'=>$request->remarks,
            'complete_status'=>1,
            'updated_by'=>$loggedUser,
            'updated_at'=>Carbon::now()->toDateTimeString(),
        ]);

        if($update){
            Session::flash('success','Successfully updated!');
            return redirect()->route('all_support_ticket');
        }else{
            Session::flash('error','Update process failed!');
            return redirect()->route('all_support_ticket');
        }
    }
}
