<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Gallery;
use App\Models\beneficiarie;
use App\Models\Member;
use App\Models\Working_Area;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    public function addnotice(){
        $session = academic_session::all();

        return view('ngo.notice.add-notice', compact('session'));
    }
}
