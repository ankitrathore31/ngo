<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Gallery;
use App\Models\beneficiarie;
use App\Models\Member;
use App\Models\Notice;
use App\Models\Working_Area;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    public function addnotice(){
        $session = academic_session::all();

        return view('ngo.notice.add-notice', compact('session'));
    }

    public function storeNotice(Request $request){

        $request->validate([
            'session' => 'required',
            'date'    =>  'required|date',
            'notice_for' => 'required',
            'notice' => 'required',
        ]);

        $notice = new Notice;
        $notice->academic_session = $request->session;
        $notice->date = \carbon\carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
        $notice->notice_for = $request->notice_for;
        $notice->notice = $request->notice;
        $notice->save();

        return redirect()->route('')->with('success', 'Notice Add Successfully');
    }

    public function NoticeList(){

        $notice = Notice::get();

        return view('ngo.notice.notice-list', compact('notice'));
    }
}
