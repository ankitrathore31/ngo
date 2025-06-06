<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Gallery;
use App\Models\beneficiarie;
use App\Models\Member;
use App\Models\academic_session;
use App\Models\Working_Area;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class HomeControlller extends Controller
{
    public function home()
    {
        $data = academic_session::all();
        $areaTypeCounts = Working_Area::select('area_type', DB::raw('count(*) as total'))
            ->groupBy('area_type')
            ->pluck('total', 'area_type');

        return view('home.welcome', compact('data', 'areaTypeCounts'));
    }
    public function index()
    {
        $data = academic_session::all()->sortByDesc('session_date');

        Session::put('all_academic_session', $data);

        $areaTypeCounts = Working_Area::select('area_type', DB::raw('count(*) as total'))
            ->groupBy('area_type')
            ->pluck('total', 'area_type');

        return view('home.welcome', compact('data', 'areaTypeCounts'));
    }

    public function activitypage()
    {
        $activity = Activity::orderBy('program_date', 'asc')->get();
        return view('home.activity.SocialActivity', compact('activity'));
    }

    public function viewreport($id)
    {
        $activity = Activity::findOrFail($id);

        return view('home.activity.ViewActivity', compact('activity'));
    }

    public function servicepage()
    {
        return view('home.pages.service');
    }

    public function aboutpage()
    {
        return view('home.pages.about_us');
    }

    public function eventpage()
    {
        return view('home.pages.event');
    }

    public function projectpage()
    {
        return view('home.pages.project');
    }

    public function newspage()
    {
        $images = Gallery::where('gallery_type', 'news')->get();
        return view('home.gallery.newspaper', compact('images'));
    }

    public function photo()
    {
        $images = Gallery::where('gallery_type', 'gallery')->get();
        return view('home.gallery.gallery', compact('images'));
    }

    public function certificatepage()
    {
        return view('home.pages.certification');
    }

    public function rewardpage()
    {
        return view('home.pages.reward');
    }

    public function donatepage()
    {
        return view('home.donation.donate');
    }

    public function contactpage()
    {
        return view('home.pages.contact');
    }

    public function helpeducation()
    {
        return view('home.donation.help-education');
    }

    public function helpclothe()
    {
        return view('home.donation.help-clothe');
    }

    public function helpfood()
    {
        return view('home.donation.help-food');
    }

    public function helpenvironment()
    {
        return view('home.donation.help-environment');
    }

    public function notice()
    {
        return view('home.pages.notice');
    }

    public function applictionStatus()
    {
        return view('home.status.application_status');
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'application_no' => 'required|string',
        ]);

        $application = null;

        if ($request) {
            $application = beneficiarie::where('application_no', $request->application_no)->first();
        } elseif ($request) {
            $application = Member::where('application_no', $request->application_no)->first();
        }

        if (!$application) {
            return back()->with('error', 'Application not found.')->withInput();
        }

        return view('home.status.show-application', compact('application'))->with('success', 'Application  found.');
    }

    public function certiStatus()
    {
        return view('home.status.certificate-verify');
    }

    public function facilitiesStatus()
    {
        return view('home.status.facilities-status');
    }

    public function showfacilities(Request $request)
    {
        $request->validate([
            'identity_no' => 'required',
        ]);

        // Remove spaces from Aadhar
        $identityNo = str_replace(' ', '', $request->identity_no);

        $beneficiarie = \App\Models\beneficiarie::with(['surveys'])->withTrashed()
            ->where('identity_no', $identityNo)
            ->first();

        if (!$beneficiarie) {
            return back()->with('error', 'Facilities not found.')->withInput();
        }

        return view('home.status.show_facilities', compact('beneficiarie'))->with('success', 'Facilities found.');
    }

    public function showarea($text)
    {
        $area = Working_Area::where('area_type', $text)->orderBy('area', 'asc')->get();
        $totalarea = Working_Area::where('area_type', $text)->count();
        return view('home.pages.working-area', compact('area', 'text', 'totalarea'));
    }

    public function filterAreaCounts(Request $request)
    {
        $query = Working_Area::query();

        if ($request->has('session') && $request->session !== '') {
            $query->where('academic_session', $request->session);
        }

        $areaTypeCounts = $query->select('area_type', DB::raw('count(*) as total'))
            ->groupBy('area_type')
            ->pluck('total', 'area_type');

        return response()->json($areaTypeCounts);
    }
}
