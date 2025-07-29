<?php

use App\Models\Organization;
use App\Models\OrganizationMember;

if(!function_exists('print_hello')){
    function print_hello(){
        $data = 'hello helper';
        return $data;
    }
}

if(!function_exists('organization')){
    function organization(){
        $data = Organization::get();
        return $data;
    }
}

if(!function_exists('totalOrgMember')){
    function totalOrgMember($org_id){
        $data = OrganizationMember::where('organization_id',$org_id)->count();
        return $data;
    }
}