<?php

use App\Models\beneficiarie;
use App\Models\Beneficiarie_Survey;
use App\Models\Category;
use App\Models\HeadOrganization;
use App\Models\Member;
use App\Models\Organization;
use App\Models\OrganizationMember;
use App\Models\Problem;
use App\Models\Project;
use App\Models\ProjectReport;
use App\Models\Visitor;

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

        // Caste
        // Get unique caste values from your beneficiarie or Member model
        $castes = beneficiarie::where('status', 1)
            ->distinct()
            ->pluck('caste')
            ->filter() // removes null/empty values
            ->toArray();

        // If you also want to include caste values from Member table
        $memberCastes = Member::where('status', 1)
            ->distinct()
            ->pluck('caste')
            ->filter()
            ->toArray();

        // Merge both and remove duplicates
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


        return [
            'total'        => $total,
            'ben'          => $ben,
            'mem'          => $mem,
            'benReligion'  => $benReligion,
            'memReligion'  => $memReligion,
            'benCaste'     => $benCaste,
            'memCaste'     => $memCaste,
        ];
    }
}
