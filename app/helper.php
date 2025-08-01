<?php

use App\Models\beneficiarie;
use App\Models\Beneficiarie_Survey;
use App\Models\HeadOrganization;
use App\Models\Member;
use App\Models\Organization;
use App\Models\OrganizationMember;

if(!function_exists('print_hello')){
    function print_hello(){
        $data = 'hello helper';
        return $data;
    }
}

if (!function_exists('totalReg')) {
    function totalReg() {
        $ben = Beneficiarie::count();
        $mem = Member::count();
        $data = $ben + $mem;
        return $data;
    }
}

if (!function_exists('totalPendingReg')) {
    function totalPendingReg() {
        $ben = Beneficiarie::where('status', 0)->count();
        $mem = Member::where('status', 0)->count();
        $data = $ben + $mem;
        return $data;
    }
}
if (!function_exists('totalRejectedReg')) {
    function totalRejectedReg() {
        $ben = Beneficiarie::onlyTrashed()->count();
        $mem = Member::onlyTrashed()->count();
        $data = $ben + $mem;
        return $data;
    }
}
if (!function_exists('totalApprovedReg')) {
    function totalApprovedReg() {
        $ben = Beneficiarie::where('status', 1)->count();
        $mem = Member::where('status', 1)->count();
        $data = $ben + $mem;
        return $data;
    }
}
if (!function_exists('totalDemand')) {
    function totalDemand() {
        // Count all records where facilities_status is 0 or 1
        return Beneficiarie_Survey::whereIn('facilities_status', [0, 1])->count();
    }
}
if (!function_exists('totalPendingDemand')) {
    function totalPendingDemand() {
        $data = Beneficiarie_Survey::where('facilities_status', 0)->count();
        return $data;
    }
}
if (!function_exists('totalApprovedDemand')) {
    function totalApprovedDemand() {
        $data = Beneficiarie_Survey::where('facilities_status', 1)->count();
        return $data;
    }
}
if (!function_exists('totalDistributed')) {
    function totalDistributed() {
        $data = Beneficiarie_Survey::where('status', 'Distributed')->count();
        return $data;
    }
}
if (!function_exists('totalRejectedDistributed')) {
    function totalRejectedDistributed() {
        $data = Beneficiarie_Survey::where('status', 'Pending')->count();
        return $data;
    }
}
if(!function_exists('organization')){
    function organization(){
        $data = HeadOrganization::get();
        return $data;
    }
}

if(!function_exists('TotalorganizationGroup')){
    function TotalorganizationGroup($id){
        $data = Organization::where('headorg_id',$id)->count();
        return $data;
    }
}

if(!function_exists('totalOrgMember')){
    function totalOrgMember($org_id){
        $data = OrganizationMember::where('organization_id',$org_id)->count();
        return $data;
    }
}

if(!function_exists('organizationGroup')){
    function organizationGroup($headorg_id){
        $data = Organization::where('headorg_id',$headorg_id)->get();
        return $data;
    }
}