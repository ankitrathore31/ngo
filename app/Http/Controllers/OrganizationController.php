<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\beneficiarie;
use App\Models\Donation;
use App\Models\Member;
use App\Models\Organization;
use App\Models\OrganizationMember;
use App\Models\Signature;
use App\Models\Staff;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function AddOrg()
    {
        $data = academic_session::all();
        $states = config('states');
        return view('ngo.organization.add-organization', compact('data', 'states'));
    }

    public function Storeorg(Request $request)
    {
        $validate = $request->validate([
            'academic_session' => 'required',
            'name'    =>  'required|string',
            'formation_date' => 'required',
            'address' =>  'required|string',
            'block'    =>  'required|string',
            'state'   =>  'required|string',
            'district' =>  'required|string',
        ]);

        $lastOrg = Organization::orderBy('id', 'desc')->first();
        if ($lastOrg && $lastOrg->organization_no) {
            $lastNumber = intval(substr($lastOrg->organization_no, 5)); // remove 3126G
            $newNumber = $lastNumber + 1;
            $organizationNo = '3126G' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
        } else {
            $organizationNo = '3126G00001';
        }
        $validate['organization_no'] = $organizationNo;
        $org = Organization::create($validate);
        return redirect()->route('list.organization')
            ->with('success', 'Organization Added Successfully');
    }


    public function EditOrg($id)
    {
        $org = Organization::findorFail($id);
        $data = academic_session::all();
        $states = config('states');
        return view('ngo.organization.edit-organization', compact('data', 'states', 'org'));
    }

    public function Updateorg(Request $request, $id)
    {
        $validate = $request->validate([
            'academic_session' => 'required',
            'name'    =>  'required|string',
            'formation_date' => 'required|date',
            'address' =>  'required|string',
            'block'    =>  'required|string',
            'state'   =>  'required|string',
            'district' =>  'required|string',
        ]);

        $org = Organization::findOrFail($id);
        $org->update($validate);

        return redirect()->route('list.organization')->with('success', 'Organization Updated Successfully');
    }


    public function DeleteOrg($id)
    {
        $org = Organization::findOrFail($id);
        $org->organizationMembers()->delete();
        $org->delete();

        return redirect()->back()->with('success', 'Organization and its members deleted successfully');
    }

    public function OrgList(Request $request)
    {

        $query = Organization::query();

        if ($request->session) {
            $query->where('academic_session', $request->session);
        }
        if ($request->session) {
            $query->where('name', '%' . $request->name . '%');
        }
        if ($request->block) {
            $query->where('block', '%' . $request->block . '%');
        }
        if ($request->state) {
            $query->where('state', $request->state);
        }
        if ($request->district) {
            $query->where('district', $request->district);
        }

        $org = $query->get();
        $states = config('states');
        $data = academic_session::all();

        return view('ngo.organization.organization-list', compact('data', 'states', 'org'));
    }

    public function AddOrgMember($id)
    {
        $data = academic_session::all();
        $organization = Organization::findOrFail($id);
        $staff = Staff::all();
        $donations = Donation::all();
        $members = Member::all();
        $beneficiaries = beneficiarie::all();
        $allMembers = $staff->merge($members)->merge($beneficiaries)->merge($donations);
        return view('ngo.organization.add-organization-member', compact('data', 'allMembers', 'organization'));
    }

    public function StoreOrgMember(Request $request, $organizationId)
    {
        $organization = Organization::findOrFail($organizationId);

        $request->validate([
            'academic_session' => 'required|string',
            'members' => 'required|array',
        ]);

        foreach ($request->members as $memberId => $data) {
            OrganizationMember::create([
                'organization_id'   => $organization->id,
                'member_id'         => $data['id'],        // direct access now
                'member_position'          => $data['position'],
                'academic_session'  => $request->academic_session,
            ]);
        }

        return redirect()
            ->route('list.organization.member')
            ->with('success', 'Members added successfully!');
    }


    public function OrgMemberList(Request $request)
    {
        // Get filter values
        $sessionFilter = $request->session;
        $organizationFilter = $request->org;
        $memberNameFilter = $request->member_name;

        // Base query with relationships
        $query = OrganizationMember::with('organization')->orderBy('created_at', 'desc');

        // Apply filters
        if (!empty($sessionFilter)) {
            $query->where('academic_session', $sessionFilter);
        }

        if (!empty($organizationFilter)) {
            $query->whereHas('organization', function ($q) use ($organizationFilter) {
                $q->where('name', 'like', '%' . $organizationFilter . '%');
            });
        }

        if (!empty($memberNameFilter)) {
            $query->where(function ($q) use ($memberNameFilter) {
                // Match member name from multiple tables
                $memberIds = array_merge(
                    Beneficiarie::where('name', 'like', "%{$memberNameFilter}%")->pluck('id')->toArray(),
                    Staff::where('name', 'like', "%{$memberNameFilter}%")->pluck('id')->toArray(),
                    Member::where('name', 'like', "%{$memberNameFilter}%")->pluck('id')->toArray(),
                    Donation::where('name', 'like', "%{$memberNameFilter}%")->pluck('id')->toArray()
                );
                $q->whereIn('member_id', $memberIds);
            });
        }

        // Get filtered results
        $organizationMembers = $query->get()->map(function ($member) {
            $person = Beneficiarie::find($member->member_id)
                ?? Staff::find($member->member_id)
                ?? Member::find($member->member_id)
                ?? Donation::find($member->member_id);
            $member->person = $person;
            return $member;
        });

        // Fetch data for dropdowns
        $organizations = Organization::all();
        $sessions = OrganizationMember::select('academic_session')
            ->distinct()
            ->orderBy('academic_session', 'desc')
            ->get();

        $data = academic_session::all();

        return view('ngo.organization.org-member-list', compact('data','organizationMembers', 'organizations', 'sessions'));
    }


    public function ViewOrgMember($id)
    {
        $member = OrganizationMember::with('organization')->findOrFail($id);
        $person = Beneficiarie::find($member->member_id)
            ?? Staff::find($member->member_id)
            ?? Member::find($member->member_id)
            ?? Donation::find($member->member_id);

        $member->person = $person;
        $signatures = Signature::pluck('file_path', 'role');
        return view('ngo.organization.view-org-member', compact('member', 'signatures'));
    }


    public function DeleteOrgMember($id)
    {
        $orgMember = OrganizationMember::findorFail($id);
        $orgMember->delete();

        return redirect()->back()->with('success', 'Organization Member Deleted Successfully. ');
    }
}
