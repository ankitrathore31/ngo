<?php

use App\Models\beneficiarie;
use App\Models\Beneficiarie_Survey;
use App\Models\Bill;
use App\Models\Bill_Voucher;
use App\Models\Category;
use App\Models\EducationCard;
use App\Models\EducationFacility;
use App\Models\GbsBill;
use App\Models\HeadOrganization;
use App\Models\HealthCard;
use App\Models\HealthFacility;
use App\Models\Member;
use App\Models\Organization;
use App\Models\OrganizationMember;
use App\Models\Problem;
use App\Models\Project;
use App\Models\ProjectReport;
use App\Models\SalaryPayment;
use App\Models\Staff;
use App\Models\Story;
use App\Models\Visitor;
use Illuminate\Support\Facades\DB;
use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

if (!function_exists('hello')) {
    function hello()
    {
        return print('hello');
    }
}

if (!function_exists('totalReg')) {
    function totalReg()
    {
        $ben = Beneficiarie::count();
        $mem = Member::count();
        $data = $ben + $mem;
        return $data;
    }
}

if (!function_exists('totalPendingReg')) {
    function totalPendingReg()
    {
        $ben = Beneficiarie::where('status', 0)->count();
        $mem = Member::where('status', 0)->count();
        $data = $ben + $mem;
        return $data;
    }
}

if (!function_exists('totalRejectedReg')) {
    function totalRejectedReg()
    {
        $ben = Beneficiarie::onlyTrashed()->count();
        $mem = Member::onlyTrashed()->count();
        $data = $ben + $mem;
        return $data;
    }
}

if (!function_exists('totalApprovedReg')) {
    function totalApprovedReg()
    {
        $ben = Beneficiarie::where('status', 1)->count();
        $mem = Member::where('status', 1)->count();
        $data = $ben + $mem;
        return $data;
    }
}

if (!function_exists('TotalSurvey')) {
    function TotalSurvey()
    {
        $data = beneficiarie::where('status', 1)->count();
        return $data;
    }
}

if (!function_exists('PendingSurvey')) {
    function PendingSurvey()
    {
        $data = beneficiarie::where('survey_status', 0)->count();
        return $data;
    }
}

if (!function_exists('ApproveSurvey')) {
    function ApproveSurvey()
    {
        $data = beneficiarie::where('survey_status', 1)->count();
        return $data;
    }
}
if (!function_exists('totalDemand')) {
    function totalDemand()
    {
        // Count all records where facilities_status is 0 or 1
        return Beneficiarie_Survey::whereIn('facilities_status', [0, 1])->count();
    }
}
if (!function_exists('totalPendingDemand')) {
    function totalPendingDemand()
    {
        $data = Beneficiarie_Survey::where('facilities_status', 0)->count();
        return $data;
    }
}
if (!function_exists('totalApprovedDemand')) {
    function totalApprovedDemand()
    {
        $data = Beneficiarie_Survey::where('facilities_status', 1)->count();
        return $data;
    }
}
if (!function_exists('totalDemandDistributed')) {
    function totalDemandDistributed()
    {
        $data = Beneficiarie_Survey::where('facilities_status', 1)->count();
        return $data;
    }
}
if (!function_exists('totalDistributed')) {
    function totalDistributed()
    {
        $data = Beneficiarie_Survey::where('status', 'Distributed')->count();
        return $data;
    }
}
if (!function_exists('totalRejectedDistributed')) {
    function totalRejectedDistributed()
    {
        $data = Beneficiarie_Survey::where('status', 'Pending')->count();
        return $data;
    }
}
if (!function_exists('organization')) {
    function organization()
    {
        $data = HeadOrganization::get();
        return $data;
    }
}
if (!function_exists('TotalOrganization')) {
    function TotalOrganization()
    {
        $data = Organization::count();
        return $data;
    }
}

if (!function_exists('TotalorganizationGroup')) {
    function TotalorganizationGroup($id)
    {
        $data = Organization::where('headorg_id', $id)->count();
        return $data;
    }
}

if (!function_exists('totalOrgMember')) {
    function totalOrgMember($org_id)
    {
        $data = OrganizationMember::where('organization_id', $org_id)->count();
        return $data;
    }
}

if (!function_exists('organizationGroup')) {
    function organizationGroup($headorg_id)
    {
        $data = Organization::where('headorg_id', $headorg_id)->get();
        return $data;
    }
}

if (!function_exists('totalProblem')) {
    function totalProblem()
    {
        $data = Problem::where('status', 0)->count();
        return $data;
    }
}

if (!function_exists('totalSolution')) {
    function totalSolution()
    {
        $data = Problem::where('status', 1)->count();
        return $data;
    }
}

if (!function_exists('totalVisitor')) {
    function totalVisitor()
    {
        $data = Visitor::count();
        return $data;
    }
}


if (!function_exists('todayVisitor')) {
    function todayVisitor()
    {
        return \App\Models\Visitor::whereDate('visit_date', now()->toDateString())->count();
    }
}

if (!function_exists('monthlyVisitorData')) {
    function monthlyVisitorData()
    {
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $data[] = Visitor::whereMonth('created_at', $i)->count();
        }
        return $data;
    }
}
if (!function_exists('totalProject')) {
    function totalProject()
    {
        $data = Project::count();
        return $data;
    }
}
if (!function_exists('totalProjectReport')) {
    function totalProjectReport()
    {
        $data = ProjectReport::count();
        return $data;
    }
}
if (!function_exists('totalProjectCategory')) {
    function totalProjectCategory()
    {
        $data = Category::count();
        return $data;
    }
}
if (!function_exists('totalStats')) {
    function totalStats()
    {
        $ben = beneficiarie::where('status', 1)->count();
        $mem = Member::count();
        $total = $ben + $mem;

        // Religion list
        $religions = ['Hindu', 'Islam', 'Christian', 'Sikh', 'Buddhist', 'Parsi'];

        $benReligion = [];
        $memReligion = [];
        foreach ($religions as $rel) {
            $benReligion[$rel] = beneficiarie::where('status', 1)->where('religion', $rel)->count();
            $memReligion[$rel] = Member::where('status', 1)->where('religion', $rel)->count();
        }

        // Caste list
        $castes = beneficiarie::where('status', 1)
            ->distinct()
            ->pluck('caste')
            ->filter()
            ->toArray();

        $memberCastes = Member::where('status', 1)
            ->distinct()
            ->pluck('caste')
            ->filter()
            ->toArray();

        $castes = array_unique(array_merge($castes, $memberCastes));

        $benCaste = [];
        $memCaste = [];

        foreach ($castes as $cat) {
            $benCaste[$cat] = beneficiarie::where('status', 1)
                ->where('caste', $cat)
                ->count();

            $memCaste[$cat] = Member::where('status', 1)
                ->where('caste', $cat)
                ->count();
        }

        // 🆕 Caste Category list
        $categories = ['General', 'OBC', 'SC', 'ST', 'Minority'];

        $benCategory = [];
        $memCategory = [];
        foreach ($categories as $cat) {
            $benCategory[$cat] = beneficiarie::where('status', 1)
                ->where('religion_category', $cat)
                ->count();

            $memCategory[$cat] = Member::where('status', 1)
                ->where('religion_category', $cat)
                ->count();
        }

        return [
            'total'         => $total,
            'ben'           => $ben,
            'mem'           => $mem,
            'benReligion'   => $benReligion,
            'memReligion'   => $memReligion,
            'benCaste'      => $benCaste,
            'memCaste'      => $memCaste,
            'benCategory'   => $benCategory,
            'memCategory'   => $memCategory,
        ];
    }
}

if (!function_exists('surveyStats')) {
    function surveyStats()
    {
        // Step 1: Get first survey for each beneficiary
        $firstSurveyIds = DB::table('beneficiarie__surveys')
            ->selectRaw('MIN(id) as id')
            ->groupBy('beneficiarie_id')
            ->pluck('id');

        // Step 2: Load those survey records with beneficiary relationship
        $surveys = Beneficiarie_Survey::with('beneficiarie')
            ->whereIn('id', $firstSurveyIds)
            ->get();

        // Step 3: Religion Stats
        $religions = ['Hindu', 'Islam', 'Christian', 'Sikh', 'Buddhist', 'Parsi'];
        $religionStats = [];
        foreach ($religions as $rel) {
            $religionStats[$rel] = $surveys->where('beneficiarie.religion', $rel)->count();
        }

        // Step 4: Caste Stats (auto-detect unique castes)
        $castes = $surveys->pluck('beneficiarie.caste')->filter()->unique();
        $casteStats = [];
        foreach ($castes as $caste) {
            $casteStats[$caste] = $surveys->where('beneficiarie.caste', $caste)->count();
        }

        // Step 5: Caste Category Stats
        $categories = ['General', 'OBC', 'SC', 'ST', 'Minority'];
        $categoryStats = [];
        foreach ($categories as $cat) {
            $categoryStats[$cat] = $surveys->where('beneficiarie.religion_category', $cat)->count();
        }

        // Step 6: Total Surveys
        $total = $surveys->count();

        // Step 7: Return formatted array
        return [
            'total'         => $total,
            'religionStats' => $religionStats,
            'casteStats'    => $casteStats,
            'categoryStats' => $categoryStats,
        ];
    }
}
if (!function_exists('distributeStats')) {
    function distributeStats()
    {
        // Get all distributed surveys
        $distributed = Beneficiarie_Survey::with('beneficiarie')
            ->where('status', 'Distributed')
            ->get();

        // Total distributed
        $total = $distributed->count();

        // Religion stats
        $religions = ['Hindu', 'Islam', 'Christian', 'Sikh', 'Buddhist', 'Parsi'];
        $religionStats = [];
        foreach ($religions as $rel) {
            $religionStats[$rel] = $distributed->where('beneficiarie.religion', $rel)->count();
        }

        // Caste stats
        $castes = $distributed->pluck('beneficiarie.caste')->filter()->unique();
        $casteStats = [];
        foreach ($castes as $caste) {
            $casteStats[$caste] = $distributed->where('beneficiarie.caste', $caste)->count();
        }

        // Caste Category stats
        $categories = ['General', 'OBC', 'SC', 'ST', 'Minority'];
        $categoryStats = [];
        foreach ($categories as $cat) {
            $categoryStats[$cat] = $distributed->where('beneficiarie.religion_category', $cat)->count();
        }

        // Facility Category stats
        $facilityCategories = $distributed->pluck('facilities_category')->filter()->unique();
        $facilityStats = [];
        foreach ($facilityCategories as $fac) {
            $facilityStats[$fac] = $distributed->where('facilities_category', $fac)->count();
        }

        return [
            'total'           => $total,
            'religionStats'   => $religionStats,
            'casteStats'      => $casteStats,
            'categoryStats'   => $categoryStats,
            'facilityStats'   => $facilityStats,
        ];
    }
}
if (!function_exists('logWork')) {
    function logWork($modelName, $recordId, $title, $description)
    {
        $user = Auth::user();
        // if (!$user) return;

        $staff = $user->staff;
        try {
            WorkLog::create([
                'user_id'     => $user->id,
                'user_type'   => $user->user_type,
                'user_name'   => $staff->name ?? $user->name,
                'user_code'   => $staff->staff_code ?? $user->staff_code ?? 'NGO',
                'model_name'  => $modelName,
                'record_id'   => $recordId,
                'work_date'   => now()->toDateString(),
                'title'       => $title,
                'description' => $description,
            ]);
        } catch (\Exception $e) {
            // Avoid breaking your flow if logging fails
            \Log::error('WorkLog failed: ' . $e->getMessage());
        }
    }
}
if (!function_exists('totalStories')) {
    function totalStories()
    {
        return Story::count();
    }
}
if (!function_exists('totalHealthCard')) {
    function totalHealthCard()
    {
        $data = HealthCard::count();
        return $data;
    }
}
if (!function_exists('DemandHalthFacility')) {
    function DemandHalthFacility()
    {
        $data = HealthFacility::where('status', 'Pending')->count();
        return $data;
    }
}
if (!function_exists('InvestigationHalthFacility')) {
    function InvestigationHalthFacility()
    {
        $data = HealthFacility::where('status', 'Investigation')->count();
        return $data;
    }
}
if (!function_exists('VerifyHalthFacility')) {
    function VerifyHalthFacility()
    {
        $data = HealthFacility::where('status', 'Verify')->count();
        return $data;
    }
}
if (!function_exists('ApproveHalthFacility')) {
    function ApproveHalthFacility()
    {
        $data = HealthFacility::where('status', 'Approve')->count();
        return $data;
    }
}
if (!function_exists('ApproveHalthFacility')) {
    function ApproveHalthFacility()
    {
        $data = HealthFacility::where('status', 'Approve')->count();
        return $data;
    }
}
if (!function_exists('ApprovelHalthFacility')) {
    function ApprovelHalthFacility()
    {
        $data = HealthFacility::where('status', 'Approval')->count();
        return $data;
    }
}

if (!function_exists('RejectHalthFacility')) {
    function RejectHalthFacility()
    {
        $data = HealthFacility::where('status', 'Reject')->count();
        return $data;
    }
}

if (!function_exists('NonBudgetHalthFacility')) {
    function NonBudgetHalthFacility()
    {
        $data = HealthFacility::where('status', 'Non-Budget')->count();
        return $data;
    }
}

if (!function_exists('DemandPendinglHalthFacility')) {
    function DemandPendingHalthFacility()
    {
        $data = HealthFacility::where('status', 'Demand-Pending')->count();
        return $data;
    }
}

if (!function_exists('ShowFacilityMenu')) {

    function ShowFacilityMenu(): bool
    {
        $user = Auth::user();

        // Not logged in or not staff
        if (!$user || $user->user_type !== 'staff') {
            return false;
        }

        $email = $user->email;

        return Cache::remember(
            'facility_menu_' . $user->id,
            now()->addMinutes(10),
            function () use ($email) {

                return EducationFacility::where(function ($q) use ($email) {
                    $q->where('investigation_officer', $email)
                        ->orWhere('verify_officer', $email);
                })
                    ->exists()

                    || HealthFacility::where(function ($q) use ($email) {
                        $q->where('investigation_officer', $email)
                            ->orWhere('verify_officer', $email);
                    })
                    ->exists();
            }
        );
    }
}

if (!function_exists('staffByEmail')) {

    function staffByEmail(?string $email)
    {
        if (!$email) {
            return null;
        }

        return Staff::where('email', $email)->first();
    }
}

if (!function_exists('costTotals')) {

    function costTotals()
    {
        $today = Carbon::today()->toDateString();

        $records = collect();

        /* ===== Bill Voucher ===== */
        $records = $records->merge(
            Bill_Voucher::with('items')->get()->map(function ($x) {
                $base = $x->items->sum(fn($i) => $i->qty * $i->rate);
                return [
                    'date' => $x->date,
                    'amount' => $base + ($base * ($x->cgst ?? 0) / 100) + ($base * ($x->sgst ?? 0) / 100)
                ];
            })
        );

        /* ===== Bill ===== */
        $records = $records->merge(
            Bill::with('items')->get()->map(function ($x) {
                $base = $x->items->sum(fn($i) => $i->qty * $i->rate);
                return [
                    'date' => $x->date,
                    'amount' => $base + ($base * ($x->cgst ?? 0) / 100) + ($base * ($x->sgst ?? 0) / 100)
                ];
            })
        );

        /* ===== GBS ===== */
        $records = $records->merge(
            GbsBill::all()->map(fn($x) => [
                'date' => $x->bill_date,
                'amount' => $x->amount
            ])
        );

        /* ===== Salary ===== */
        $records = $records->merge(
            SalaryPayment::all()->map(fn($x) => [
                'date' => $x->payment_date,
                'amount' => $x->amount
            ])
        );

        /* ===== Education Card ===== */
        $records = $records->merge(
            EducationCard::all()->map(fn($x) => [
                'date' => $x->date,
                'amount' => $x->amount
            ])
        );

        /* ===== Health Card ===== */
        $records = $records->merge(
            HealthCard::all()->map(fn($x) => [
                'date' => $x->date,
                'amount' => $x->amount
            ])
        );

        return [
            'todayCostAmount' => $records->where('date', $today)->sum('amount'),
            'totalCostAmount' => $records->sum('amount')
        ];
    }
}

if (!function_exists('memberDashboardData')) {

    function memberDashboardData($authMemberId)
    {
        // Base Query (Same as your list controller)
        $baseQuery = Member::where('added_by', $authMemberId)
                            ->where('status', 1); // Only Active

        /* =========================
           CARD DATA
        ========================= */

        $totalSubMembers = (clone $baseQuery)->count();

        $monthlyActivities = (clone $baseQuery)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        /* =========================
           LAST 6 MONTH GROWTH
        ========================= */

        $chartLabels = [];
        $chartData   = [];

        for ($i = 5; $i >= 0; $i--) {

            $month = Carbon::now()->subMonths($i);

            $chartLabels[] = $month->format('M');

            $count = Member::where('added_by', $authMemberId)
                ->where('status', 1)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->count();

            $chartData[] = $count;
        }

        /* =========================
           RECENT ACTIVE SUB MEMBERS
        ========================= */

        $recentSubMembers = (clone $baseQuery)
            ->latest()
            ->take(10)
            ->get();

        return [
            'totalSubMembers'   => $totalSubMembers,
            'activeMembers'     => $totalSubMembers,
            'monthlyActivities' => $monthlyActivities,
            'chartLabels'       => $chartLabels,
            'chartData'         => $chartData,
            'recentSubMembers'  => $recentSubMembers,
        ];
    }
}
