<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Plan;
use App\Models\Signature;
use App\Models\WorkLog;
use App\Models\WorkPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffWorkController extends Controller
{
    public function WorkList(Request $request)
    {
        $user = Auth::user();
        $date = $request->input('date', now()->toDateString());
        $session = academic_session::all();

        // ✅ Base query
        $query = WorkLog::query();

        // 🧠 Role-based filter
        if ($user->user_type === 'staff') {
            // Staff see only their own logs
            $query->where('user_id', $user->id);
        } else {
            // NGO/Admin filters
            if ($request->user_filter === 'staff') {
                $query->where('user_type', 'staff');
            } elseif ($request->user_filter === 'ngo') {
                $query->where('user_type', 'ngo');
            } // else show all by default

            $query->when($request->name, fn($q) => $q->where('user_name', 'like', '%' . $request->name . '%'));
            $query->when($request->code, fn($q) => $q->where('user_code', 'like', '%' . $request->code . '%'));
        }

        // 🗓️ Common filters
        $query->when($request->date, fn($q) => $q->whereDate('work_date', $request->date));
        $query->when($request->session_filter, fn($q) => $q->where('work_date', 'like', '%' . $request->session_filter . '%'));

        // 📋 Fetch logs
        $logs = $query
            ->orderBy('user_name')
            ->orderByDesc('work_date')
            ->get()
            ->groupBy('user_name');

        // 📊 Stats
        if ($user->user_type === 'staff') {
            $totalLogs = WorkLog::where('user_id', $user->id)->count();
            $todayLogs = WorkLog::where('user_id', $user->id)->whereDate('work_date', now())->count();
        } else {
            $totalLogs = WorkLog::count();
            $todayLogs = WorkLog::whereDate('work_date', now())->count();
        }

        return view('ngo.staff-work.staff-work-list', compact('logs', 'date', 'session', 'user', 'totalLogs', 'todayLogs'));
    }
}
