<?php

namespace App\Http\Controllers;

use App\Models\academic_session;
use App\Models\Member;
use App\Models\Union;
use Illuminate\Http\Request;
use App\Helpers\PositionHierarchy;
use App\Models\UnionMember;
use Carbon\Carbon;

class UnionController extends Controller
{

    public function AddUnion()
    {
        $data = academic_session::all();
        $states = config('states');

        $lastUnion = Union::orderBy('id', 'desc')->first();

        if ($lastUnion && $lastUnion->union_no) {

            // Remove UIDN prefix (4 characters)
            $lastNumber = intval(substr($lastUnion->union_no, 4));

            $nextNumber = $lastNumber + 1;

            // UIDN + 4 digit padded number
            $nextUnionNo = 'UIDN' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        } else {

            $nextUnionNo = 'UIDN0001';
        }

        return view(
            'ngo.union.add-union',
            compact('data', 'states', 'nextUnionNo')
        );
    }

    public function StoreUnion(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'union_no' => 'required|unique:unions,union_no',
            'academic_session' => 'required',
            'formation_date' => 'nullable|date',
            'state' => 'required',
            'district' => 'required',
        ]);

        Union::create([
            'name' => $request->name,
            'union_no' => $request->union_no,
            'union_certificate_format' => $request->union_certificate_format,
            'academic_session' => $request->academic_session,
            'formation_date' => $request->formation_date,
            'area_type' => $request->area_type,
            'address' => $request->address,
            'block' => $request->block,
            'state' => $request->state,
            'district' => $request->district,
        ]);

        return redirect()->route('union.list')
            ->with('success', 'Union Created Successfully');
    }

    public function EditUnion($id)
    {
        $union = Union::findOrFail($id);
        $data = academic_session::all();
        $states = config('states');

        return view(
            'ngo.union.edit-union',
            compact('union', 'data', 'states')
        );
    }

    public function UpdateUnion(Request $request, $id)
    {
        $union = Union::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'academic_session' => 'required',
            'formation_date' => 'nullable|date',
            'state' => 'required',
            'district' => 'required',
        ]);

        $union->update([
            'name' => $request->name,
            'union_certificate_format' => $request->union_certificate_format,
            'academic_session' => $request->academic_session,
            'formation_date' => $request->formation_date,
            'area_type' => $request->area_type,
            'address' => $request->address,
            'block' => $request->block,
            'state' => $request->state,
            'district' => $request->district,
        ]);

        return redirect()->route('union.list')
            ->with('success', 'Union Updated Successfully');
    }

    public function DeleteUnion($id)
    {
        $union = Union::findOrFail($id);
        $union->delete();

        return redirect()->back()
            ->with('success', 'Union Deleted Successfully');
    }

    public function ListUnion(Request $request)
    {
        $query = Union::query();

        // Search Filters
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('union_no')) {
            $query->where('union_no', 'like', '%' . $request->union_no . '%');
        }

        if ($request->filled('address')) {
            $query->where('address', 'like', '%' . $request->address . '%');
        }

        if ($request->filled('block')) {
            $query->where('block', 'like', '%' . $request->block . '%');
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        if ($request->filled('area_type')) {
            $query->where('area_type', $request->area_type);
        }

        if ($request->filled('academic_session')) {
            $query->where('academic_session', $request->academic_session);
        }

        $unions = $query->get();

        $states = config('districts');

        return view('ngo.union.list-union', compact('unions', 'states'));
    }

    public function RegList(Request $request)
    {
        $authUser = auth()->user();

        // Define level hierarchy (top to bottom)
        $levelOrder = [
            'rashtriya',
            'pradesh',
            'mandal',
            'jila',
            'nagar',
            'block',
            'gram'
        ];

        if ($authUser->user_type === 'member') {

            // Find logged-in member
            $authMember = Member::where('email', $authUser->email)->first();
            $authMemberId = $authMember->id;
            if (!$authMember) {
                return redirect()->back()->with('error', 'Member profile not found.');
            }

            $memberLevel = strtolower(trim($authMember->position_type));

            // Get index of logged-in member level
            $currentIndex = array_search($memberLevel, $levelOrder);

            if ($currentIndex === false) {
                // Invalid level → show none
                $queryMember = Member::whereRaw('0 = 1');
            } else {

                // Get all levels below current level
                $allowedLevels = array_slice($levelOrder, $currentIndex + 1);

                if (empty($allowedLevels)) {
                    // Gram level → nothing below
                    $queryMember = Member::whereRaw('0 = 1');
                } else {
                    $queryMember = Member::where('status', 1)
                        ->whereIn('position_type', $allowedLevels);
                }
            }
        } else {
            // NGO sees all active members
            $queryMember = Member::where('status', 1);
        }
        if ($authUser->user_type === 'member') {
            $authMember = Member::where('email', $authUser->email)->first();
            $member_by = $authMember->id;
        } else {
            $member_by = $authUser->id;
        }
        // ------------------ Filters ------------------

        if ($request->filled('session_filter')) {
            $queryMember->where('academic_session', $request->session_filter);
        }

        if ($request->filled('application_no')) {
            $search = $request->application_no;
            $queryMember->where(function ($q) use ($search) {
                $q->where('application_no', 'like', "%$search%")
                    ->orWhere('registration_no', 'like', "%$search%");
            });
        }

        if ($request->filled('identity_no')) {
            $identity = $request->identity_no;
            $queryMember->where(function ($q) use ($identity) {
                $q->where('phone', 'like', "%$identity%")
                    ->orWhere('identity_no', 'like', "%$identity%");
            });
        }

        if ($request->filled('name')) {
            $name = trim($request->name);
            $queryMember->where(function ($q) use ($name) {
                $q->where('name', 'like', "{$name}%")
                    ->orWhere('gurdian_name', 'like', "{$name}%");
            });
        }

        if ($request->filled('block')) {
            $queryMember->where('block', 'like', "%{$request->block}%");
        }

        if ($request->filled('state')) {
            $queryMember->where('state', $request->state);
        }

        if ($request->filled('district')) {
            $queryMember->where('district', $request->district);
        }

        // ------------------------------------------------

        $approvemember = $queryMember->orderBy('created_at', 'asc')->get();
        $data          = academic_session::all();
        $states        = config('states');
        $unions = Union::get();
        $layout = $authUser->user_type === 'member'
            ? 'member.layout.master'
            : 'ngo.layout.master';

        return view('ngo.union.reg-list', compact(
            'data',
            'approvemember',
            'states',
            'layout',
            'unions',
            'member_by'
        ));
    }

    public function StoreUnionMember(Request $request)
    {
        $request->validate([
            'union_id' => 'required|exists:unions,id',
            'member_id' => 'required|exists:members,id',
            'join_date' => 'required|date',
        ]);

        $joinDate = Carbon::parse($request->join_date);
        $exists = UnionMember::where('union_id', $request->union_id)
            ->where('member_id', $request->member_id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'member_id' => 'This member is already in this union.'
                ]);
        }
        UnionMember::updateOrCreate(
            [
                'union_id' => $request->union_id,
                'member_id' => $request->member_id,
                'member_by' => $request->member_by,
            ],
            [
                'join_date' => $joinDate,
                'expiry_date' => $joinDate->copy()->addYear(),
                'status' => 1
            ]
        );

        return back()->with('success', 'Member added to union successfully.');
    }

    public function RenewUnionMember($id)
    {
        $unionMember = UnionMember::findOrFail($id);

        $newJoinDate = Carbon::today();
        $unionMember->update([
            'join_date' => $newJoinDate,
            'expiry_date' => $newJoinDate->copy()->addYear(),
            'status' => 1
        ]);

        return back()->with('success', 'Membership renewed for 1 year.');
    }
    public function ListUnionMember(Request $request)
    {
        $authUser = auth()->user();

        $query = UnionMember::with(['member', 'union']);

        if ($authUser->user_type === 'member') {

            $authMember = Member::where('email', $authUser->email)->first();

            if (!$authMember) {
                return back()->with('error', 'Member profile not found.');
            }

            $memberLevel = strtolower(trim($authMember->position_type));

            $levelOrder = [
                'rashtriya',
                'pradesh',
                'mandal',
                'jila',
                'nagar',
                'block',
                'gram'
            ];

            $currentIndex = array_search($memberLevel, $levelOrder);

            if ($currentIndex !== false) {

                $allowedLevels = array_slice($levelOrder, $currentIndex + 1);

                if (!empty($allowedLevels)) {

                    $query->whereHas('member', function ($q) use ($allowedLevels) {
                        $q->whereIn('position_type', $allowedLevels)
                            ->where('status', 1);
                    });
                } else {
                    $query->whereRaw('0 = 1');
                }
            } else {
                $query->whereRaw('0 = 1');
            }
        }



        // Filter by Union
        if ($request->filled('union_id')) {
            $query->where('union_id', $request->union_id);
        }

        // Filter by Added By (member_by)
        if ($request->filled('member_by')) {
            $query->where('member_by', $request->member_by);
        }

        $unionMembers = $query->orderBy('created_at', 'desc')->get();

        $unions = Union::all();
        $members = Member::where('status', 1)->get();

        $layout = $authUser->user_type === 'member'
            ? 'member.layout.master'
            : 'ngo.layout.master';

        return view('ngo.union.union-member', compact(
            'unionMembers',
            'unions',
            'members',
            'layout'
        ));
    }

    public function UnionMemberCertificate($id)
{
    $unionMember = UnionMember::with(['member', 'union'])
        ->findOrFail($id);

    $member = $unionMember->member;
    $union  = $unionMember->union;
    $authUser = auth()->user();
     $layout = $authUser->user_type === 'member'
            ? 'member.layout.master'
            : 'ngo.layout.master';
    return view('ngo.union.certificate', compact(
        'unionMember',
        'member',
        'union',
        'layout'
    ));
}
}
