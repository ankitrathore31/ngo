<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Gallery;
use App\Models\beneficiarie;
use App\Models\Member;
use App\Models\academic_session;
use App\Models\Donation;
use App\Models\Notice;
use App\Models\Working_Area;
use App\Models\Event;
use App\Models\Organization;
use App\Models\OrganizationMember;
use App\Models\Staff;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeControlller extends Controller
{
    public function home()
    {
        $data = academic_session::all();
        $areaTypeCounts = Working_Area::select('area_type', DB::raw('count(*) as total'))
            ->groupBy('area_type')
            ->pluck('total', 'area_type');

        $allacti = Activity::count();
        $todayacti = Activity::whereDate('created_at', Carbon::today())->count();

        $allCategories = [
            "Public Program",
            "Government Program",
            "Education",
            "Environment",
            "Social Awareness Program",
            "Cultural Program",
            "Sanitation Program",
            "Health Program",
            "Poor Alleviation",
            "Women Empowerment",
            "Social Problem",
            "Peace Talks Program",
            "Skill Development",
            "Religious Program",
            "Agriculture Program",
            "Labour Tools Distribution",
            "Drinking Water",
            "Ration Distribution",
            "Disaster Management",
            "Economic Help",
            "Cow Service",
            "Animal Food",
            "Other Activities",
        ];

        // Fetch actual counts from DB
        $rawCounts = Activity::select('program_category', DB::raw('count(*) as total'))
            ->groupBy('program_category')
            ->pluck('total', 'program_category')
            ->toArray();

        // Merge with default categories
        $categoryCounts = [];
        foreach ($allCategories as $cat) {
            $categoryCounts[$cat] = $rawCounts[$cat] ?? 0;
        }

        return view('home.welcome', compact('data', 'areaTypeCounts', 'allacti', 'todayacti', 'categoryCounts'));
    }

    public function index()
    {
        $data = academic_session::all()->sortByDesc('session_date');

        Session::put('all_academic_session', $data);

        $areaTypeCounts = Working_Area::select('area_type', DB::raw('count(*) as total'))
            ->groupBy('area_type')
            ->pluck('total', 'area_type');

        $allacti = Activity::count();
        $todayacti = Activity::whereDate('created_at', Carbon::today())->count();

        $allCategories = [
            "Public Program",
            "Government Program",
            "Education",
            "Environment",
            "Social Awareness Program",
            "Cultural Program",
            "Sanitation Program",
            "Health Program",
            "Poor Alleviation",
            "Women Empowerment",
            "Social Problem",
            "Peace Talks Program",
            "Skill Development",
            "Religious Program",
            "Agriculture Program",
            "Labour Tools Distribution",
            "Drinking Water",
            "Ration Distribution",
            "Disaster Management",
            "Economic Help",
            "Cow Service",
            "Animal Food",
            "Other Activities",
        ];

        // Fetch actual counts from DB
        $rawCounts = Activity::select('program_category', DB::raw('count(*) as total'))
            ->groupBy('program_category')
            ->pluck('total', 'program_category')
            ->toArray();

        // Merge with default categories
        $categoryCounts = [];
        foreach ($allCategories as $cat) {
            $categoryCounts[$cat] = $rawCounts[$cat] ?? 0;
        }

        return view('home.welcome', compact('data', 'areaTypeCounts', 'allacti', 'todayacti', 'categoryCounts'));
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

    public function eventpage(Request $request)
    {
        $query = Event::query();

        if ($request->session_filter) {
            $query->where('academic_session', $request->session_filter);
        }

        if ($request->category_filter) {
            $query->where('event_category', $request->category_filter);
        }

        $event = $query->orderBy('event_date', 'asc')->get();
        return view('home.event.event', compact('event'));
    }


    public function showEvent($id)
    {
        $event = Event::find($id);

        return view('home.event.show-event', compact('event'));
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
        $notice = Notice::where('status', 1)->latest()->first();
        return view('home.pages.notice', compact('notice'));
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

        $identityNo = str_replace(' ', '', $request->identity_no);

        $beneficiarie = \App\Models\beneficiarie::with([
            'surveys' => function ($query) {
                $query->whereNotNull('facilities');
                // ->where('facilities', 1);
            }
        ])
            ->withTrashed()
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

    public function eligibility()
    {
        return view('home.pages.eligibility');
    }

    public function groups($id)
    {
        $group = Organization::where('headorg_id', $id)->get();
        return view('home.organization.show-group', compact('group'));
    }

    public function OrgMemberListByOrganization($organization_id)
    {
        
        $organizationMembers = OrganizationMember::with('organization.headOrganization')
            ->where('organization_id', $organization_id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($member) {
                // Find member details from the possible tables
                $member->person = Beneficiarie::find($member->member_id)
                    ?? Staff::find($member->member_id)
                    ?? Member::find($member->member_id)
                    ?? Donation::find($member->member_id);
                return $member;
            });

        // Get organization details (optional)
        $organization = Organization::with('headOrganization')->findOrFail($organization_id);

        return view('home.organization.group-member-list', compact('organization', 'organizationMembers'));
    }

    public function demand()
    {
        return view('home.pages.demand');
    }
}
