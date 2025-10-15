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
use Carbon\Carbon;

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
         logWork(
            'Notice',
            $notice->id,
            'New Notice Added',
            'Notice Date: ' . $notice->date . ' | Notice: ' . $notice->notice
        );

        return redirect()->route('notice-list')->with('success', 'Notice Add Successfully');
    }

    public function NoticeList(){

        $notice = Notice::get();

        return view('ngo.notice.notice-list', compact('notice'));

    }

    public function viewNotice($id){
        $notice = Notice::find($id);

        return view('ngo.notice.view-notice', compact('notice'));
    }

    public function editNotice($id){
        $notice = Notice::find($id);
        $session = academic_session::all();
        return view('ngo.notice.edit-notice', compact('session','notice'));
    }

    public function updateNotice(Request $request, $id){

        $notice = Notice::find($id);

        $notice->academic_session = $request->session;
        $notice->date = \carbon\carbon::parse($request->date)->format('Y-m-d');
        $notice->notice_for = $request->notice_for;
        $notice->notice = $request->notice;
        $notice->save();

        return redirect()->route('notice-list')->with('success', 'Notice Update Successfully');
    }

    public function deleteNotice($id){

        $notice = Notice::find($id);
        $notice->delete();
        return redirect()->back()->with('success', 'Notice Has Been Deleted');

    }

    public function NoticeStatus(Request $request, $id){

        $notice = Notice::findorFail($id);
        $notice->status = $notice->status == 1 ? 0 : 1;
        $notice->save();
        return redirect()->back()->with('success', 'Notice Status Updated');
    }
}
