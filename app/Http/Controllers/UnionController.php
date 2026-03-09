<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\beneficiarie;
use App\Models\UnionMember;
use App\Models\Union;
use App\Models\academic_session;
use App\Helpers\PositionHierarchy;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PSpell\Config;

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

    private function getAuthActor(): object
    {
        if (session()->has('union_member_id')) {
            $um = UnionMember::findOrFail(session('union_member_id'));

            return (object) [
                'id'             => $um->id,
                'name'           => $um->name,
                'position'       => $um->position    ?? null,
                'image'          => $um->image        ?? null,
                'application_no' => $um->application_no ?? '—',
                'actor_type'     => 'union_member',
                'is_ngo'         => false,
            ];
        }

        if (auth()->check() && auth()->user()->user_type == 'ngo') {
            $admin = auth()->user();

            return (object) [
                'id'             => $admin->id,
                'name'           => $admin->name,
                'position'       => null, // no restriction for NGO
                'image'          => $admin->image ?? null,
                'application_no' => 'NGO-' . $admin->id,
                'actor_type'     => 'ngo',
                'is_ngo'         => true,
            ];
        }

        abort(403, 'Unauthorized. Please log in.');
    }

    private function resolveAllowedLevels(object $actor): array
    {
        // NGO → allow all levels and positions
        if ($actor->is_ngo) {
            return \App\Helpers\PositionHierarchy::$levels;
        }

        // If union member has no position
        if (!$actor->position) {
            return [];
        }

        // Block lowest level (gram)
        if (!\App\Helpers\PositionHierarchy::canAddSubMembers($actor->position)) {
            return [];
        }

        // Get positions only from levels below the member
        return \App\Helpers\PositionHierarchy::getAllowedSubPositions($actor->position);
    }

    // =========================================================================
    //  LIST — Approved records from BOTH Member & Beneficiarie (status = 1)
    // =========================================================================
    public function RegList(Request $request)
    {
        $actor         = $this->getAuthActor();
        $allowedLevels = $this->resolveAllowedLevels($actor);

        $actorLevel = (!$actor->is_ngo && $actor->position)
            ? PositionHierarchy::getLevelByPosition($actor->position)
            : null;

        // Base queries
        $queryBene   = beneficiarie::where('status', 1);
        $queryMember = Member::where('status', 1);

        // Name search (exact-like search)
        if ($request->filled('name')) {
            $name = $request->name;

            $queryBene->where('name', 'LIKE', "{$name}%");
            $queryMember->where('name', 'LIKE', "{$name}%");
        }

        // Father/Husband name search
        if ($request->filled('gurdian_name')) {
            $father = $request->gurdian_name;

            $queryBene->where('gurdian_name', 'LIKE', "{$father}%");
            $queryMember->where('gurdian_name', 'LIKE', "{$father}%");
        }

        // Application number search
        if ($request->filled('application_no')) {
            $appNo = $request->application_no;

            $queryBene->where('application_no', $appNo);
            $queryMember->where('application_no', $appNo);
        }

        // Mobile search
        if ($request->filled('phone')) {
            $phone = $request->phone;

            $queryBene->where('phone', 'LIKE', "{$phone}%");
            $queryMember->where('phone', 'LIKE', "{$phone}%");
        }

        // Get data
        $beneficiaries = $queryBene->get()
            ->map(fn($b) => array_merge($b->toArray(), ['_source' => 'Beneficiarie']));

        $members = $queryMember->get()
            ->map(fn($m) => array_merge($m->toArray(), ['_source' => 'Member']));

        $approvemember = $beneficiaries
            ->concat($members)
            ->sortByDesc('application_date')
            ->values();

        $unions   = Union::orderBy('name')->get();
        $sessions = academic_session::orderByDesc('id')->get();
        $districtsByState = config('sates');

        return view('ngo.union.reg-list', compact(
            'approvemember',
            'unions',
            'sessions',
            'actor',
            'actorLevel',
            'allowedLevels',
            'districtsByState'
        ));
    }

    public function StoreUnionMember(Request $request)
    {
        $actor         = $this->getAuthActor();
        $allowedLevels = $this->resolveAllowedLevels($actor);

        if (!$actor->is_ngo && empty($allowedLevels)) {
            return back()->with('error', 'You are not allowed to add union members.');
        }

        $allAllowedPositions = count($allowedLevels)
            ? array_merge(...array_values($allowedLevels))
            : [];

        // NGO = open, Union Member = restricted to their allowed levels
        $positionTypeRule = $actor->is_ngo
            ? 'required|string'
            : 'required|string|in:' . implode(',', array_keys($allowedLevels));

        $positionRule = $actor->is_ngo
            ? ['required', 'string']
            : ['required', 'string', function ($a, $v, $fail) use ($allAllowedPositions) {
                if (!in_array($v, $allAllowedPositions)) {
                    $fail('Selected position is not allowed under your level.');
                }
            }];

        $validator = Validator::make($request->all(), [
            'union_id'      => 'required|exists:unions,id',
            'source_id'     => 'required|integer',
            'source_model'  => 'required|in:Member,Beneficiarie',
            'join_date'     => 'required|date',
            'position_type' => $positionTypeRule,
            'position'      => $positionRule,
            'working_area'  => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // ── Duplicate check ───────────────────────────────────────────────────
        $alreadyAdded = UnionMember::where('union_id', $request->union_id)
            ->where('source_id', $request->source_id)
            ->where('source_model', $request->source_model)
            ->exists();

        if ($alreadyAdded) {
            return back()->with('error', 'This member is already in the selected union.');
        }

        // ── Pull full info from source ────────────────────────────────────────
        $source = $request->source_model === 'Member'
            ? Member::findOrFail($request->source_id)
            : beneficiarie::findOrFail($request->source_id);

        $joinDate = Carbon::parse($request->join_date);

        UnionMember::create([
            'union_id'          => $request->union_id,
            'source_model'      => $request->source_model,
            'source_id'         => $request->source_id,
            'member_by'         => $actor->id,
            'added_by_type'     => $actor->actor_type,

            // Position set in modal by actor
            'position_type'     => $request->position_type,
            'position'          => $request->position,
            'working_area'      => $request->working_area,

            // All personal info copied automatically from source
            'identity_type'     => $source->identity_type     ?? null,
            'identity_no'       => $source->identity_no       ?? null,
            'id_document'       => $source->id_document       ?? null,
            'application_no'    => $source->application_no    ?? null,
            'application_date'  => $source->application_date  ?? null,
            'registration_no'   => $source->registration_no   ?? null,
            'registration_date' => $source->registration_date ?? null,
            'academic_session'  => $source->academic_session  ?? null,
            'image'             => $source->image              ?? null,
            'name'              => $source->name,
            'gurdian_name'      => $source->gurdian_name       ?? null,
            'mother_name'       => $source->mother_name        ?? null,
            'dob'               => $source->dob                ?? null,
            'gender'            => $source->gender             ?? null,
            'marital_status'    => $source->marital_status     ?? null,
            'phone'             => $source->phone              ?? null,
            'email'             => $source->email              ?? null,
            'occupation'        => $source->occupation         ?? null,
            'eligibility'       => $source->eligibility        ?? null,
            'state'             => $source->state              ?? null,
            'district'          => $source->district           ?? null,
            'area_type'         => $source->area_type          ?? null,
            'block'             => $source->block              ?? null,
            'post'              => $source->post               ?? null,
            'village'           => $source->village            ?? null,
            'pincode'           => $source->pincode            ?? null,
            'country'           => $source->country            ?? null,
            'religion'          => $source->religion           ?? null,
            'religion_category' => $source->religion_category  ?? null,
            'caste'             => $source->caste              ?? null,

            'join_date'         => $joinDate,
            'expiry_date'       => $joinDate->copy()->addYear(),
            'status'            => 1,
        ]);

        User::create([
            'name'      => $source->name,
            'email'     => $source->email ?? null,
            'phone'     => $source->phone,
            'password'  => Hash::make($source->phone),
            'user_type' => 'union',
        ]);

        return back()->with('success', '"' . $source->name . '" added to union successfully.');
    }

    public function StoreNewUnionMember(Request $request)
    {
        $actor         = $this->getAuthActor();
        $allowedLevels = $this->resolveAllowedLevels($actor);

        if (!$actor->is_ngo && empty($allowedLevels)) {
            return back()->with('error', 'You are not allowed to add union members.');
        }

        $allAllowedPositions = count($allowedLevels)
            ? array_merge(...array_values($allowedLevels))
            : [];

        $positionTypeRule = $actor->is_ngo
            ? 'required|string'
            : 'required|string|in:' . implode(',', array_keys($allowedLevels));

        $positionRule = $actor->is_ngo
            ? ['required', 'string']
            : ['required', 'string', function ($a, $v, $fail) use ($allAllowedPositions) {
                if (!in_array($v, $allAllowedPositions)) {
                    $fail('Selected position is not allowed under your level.');
                }
            }];

        $validator = Validator::make($request->all(), [
            'union_id'          => 'required|exists:unions,id',
            'position_type'     => $positionTypeRule,
            'position'          => $positionRule,
            'working_area'      => 'required|string|max:255',
            'identity_type'     => 'required|string|max:255',
            'identity_no'       => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (
                        UnionMember::where('identity_no', $value)->exists() ||
                        Member::where('identity_no', $value)->exists() ||
                        beneficiarie::where('identity_no', $value)->exists()
                    ) {
                        $fail('This identity number is already registered.');
                    }
                }
            ],
            'id_document'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'join_date'         => 'required|date',
            'application_date'  => 'required|date',
            'academic_session'  => 'required',
            'image'             => 'nullable|image|max:2048',
            'name'              => 'required|string|max:255',
            'gurdian_name'      => 'required|string|max:255',
            'mother_name'       => 'required|string|max:255',
            'dob'               => 'required|date',
            'gender'            => 'required|in:Male,Female,Other',
            'marital_status'    => 'required|in:Married,Unmarried',
            'phone'             => 'required|string|max:10',
            'email'             => 'nullable|email|max:255',
            'occupation'        => 'required|string|max:255',
            'eligibility'       => 'nullable|string|max:100',
            'state'             => 'required|string|max:255',
            'district'          => 'required|string|max:255',
            'area_type'         => 'required|in:Rular,Urban',
            'block'             => 'required|string|max:255',
            'post'              => 'required|string|max:255',
            'village'           => 'nullable|string|max:255',
            'pincode'           => 'nullable|string|max:10',
            'country'           => 'required|string|max:100',
            'religion'          => 'required|string|max:100',
            'religion_category' => 'required|string|max:100',
            'caste'             => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // ── Generate Application No ───────────────────────────────────────────
        $prefix       = '2191000';
        $prefixLength = strlen($prefix);

        $lastSeq = max(
            $this->getLastSeq(Member::class,       'application_no', $prefix, $prefixLength, 0),
            $this->getLastSeq(beneficiarie::class, 'application_no', $prefix, $prefixLength, 0),
            $this->getLastSeq(UnionMember::class,  'application_no', $prefix, $prefixLength, 0)
        );

        // ── Generate Registration No ──────────────────────────────────────────
        $regPrefix       = '2192000';
        $regPrefixLength = strlen($regPrefix);

        $lastRegSeq = max(
            $this->getLastSeq(Member::class,       'registration_no', $regPrefix, $regPrefixLength, 54),
            $this->getLastSeq(beneficiarie::class, 'registration_no', $regPrefix, $regPrefixLength, 54),
            $this->getLastSeq(UnionMember::class,  'registration_no', $regPrefix, $regPrefixLength, 54)
        );

        // ── File Uploads ──────────────────────────────────────────────────────
        $imageName = null;
        $idDocName = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('member_images'), $imageName);
        }

        if ($request->hasFile('id_document')) {
            $idDocName = time() . '_id.' . $request->id_document->getClientOriginalExtension();
            $request->id_document->move(public_path('member_images'), $idDocName);
        }

        $joinDate = Carbon::parse($request->join_date);

        try {
            $newUnionMember = UnionMember::create([
                'union_id'          => $request->union_id,
                'source_model'      => 'Direct',
                'source_id'         => null,
                'member_by'         => $actor->id,
                'added_by_type'     => $actor->actor_type,

                'position_type'     => $request->position_type,
                'position'          => $request->position,
                'working_area'      => $request->working_area,

                'identity_type'     => $request->identity_type,
                'identity_no'       => $request->identity_no,
                'id_document'       => $idDocName,

                'application_no'    => $prefix    . ($lastSeq    + 1),
                'application_date'  => $request->application_date,
                'registration_no'   => $regPrefix . ($lastRegSeq + 1),
                'registration_date' => $request->application_date,
                'academic_session'  => $request->academic_session,

                'image'             => $imageName,
                'name'              => $request->name,
                'gurdian_name'      => $request->gurdian_name,
                'mother_name'       => $request->mother_name,
                'dob'               => $request->dob,
                'gender'            => $request->gender,
                'marital_status'    => $request->marital_status,
                'phone'             => $request->phone,
                'email'             => $request->email,
                'occupation'        => $request->occupation,
                'eligibility'       => $request->eligibility,
                'state'             => $request->state,
                'district'          => $request->district,
                'area_type'         => $request->area_type,
                'block'             => $request->block,
                'post'              => $request->post,
                'village'           => $request->village,
                'pincode'           => $request->pincode,
                'country'           => $request->country,
                'religion'          => $request->religion,
                'religion_category' => $request->religion_category,
                'caste'             => $request->caste,

                'join_date'         => $joinDate,
                'expiry_date'       => $joinDate->copy()->addYear(),
                'status'            => 1,
            ]);

            return back()->with(
                'success',
                'Union member "' . $newUnionMember->name . '" registered! Reg No: ' . $newUnionMember->registration_no
            );
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }

        User::create([
            'name'      => $newUnionMember->name,
            'email'     => $newUnionMember->email ?? null,
            'phone'     => $newUnionMember->phone,
            'password'  => Hash::make($newUnionMember->phone),
            'user_type' => 'union',
        ]);
    }
    
    private function getLastSeq(string $model, string $column, string $prefix, int $prefixLen, int $default): int
    {
        $row = $model::where($column, 'LIKE', $prefix . '%')
            ->whereRaw("LENGTH($column) > ?", [$prefixLen])
            ->selectRaw("CAST(SUBSTRING($column, ? + 1) AS UNSIGNED) as seq", [$prefixLen])
            ->orderByDesc('seq')
            ->first();

        return $row ? (int) $row->seq : $default;
    }

    public function UnionMemberList(Request $request)
    {
        $actor = $this->getAuthActor();

        $query = \App\Models\UnionMember::with('union');

        // If union member login → only his records
        if (!$actor->is_ngo) {
            $query->where('member_by', $actor->id)
                ->where('added_by_type', $actor->actor_type);
        }

        // Filter by Union
        if ($request->filled('union_id')) {
            $query->where('union_id', $request->union_id);
        }

        // Filter by Added By (only NGO allowed)
        if ($actor->is_ngo && $request->filled('member_by')) {
            $query->where('member_by', $request->member_by);
        }

        // Global search
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('application_no', 'LIKE', "%{$search}%")
                    ->orWhere('registration_no', 'LIKE', "%{$search}%")
                    ->orWhere('gurdian_name', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        $unionMembers = $query->orderBy('id', 'desc')->paginate(25);

        $unions = \App\Models\Union::orderBy('name')->get();

        // Added By dropdown only for NGO
        $members = $actor->is_ngo
            ? \App\Models\UnionMember::select('member_by', 'name', 'position')
            ->distinct()
            ->get()
            : collect();

        return view('ngo.union.union-member', compact(
            'unionMembers',
            'actor',
            'unions',
            'members'
        ));
    }

    public function UnionMemberCertificate($id)
    {
        $unionMember = UnionMember::findOrFail($id);
        $union  = $unionMember->union;
        $authUser = auth()->user();

        $layout = $authUser->user_type === 'member'
            ? 'member.layout.master'
            : 'ngo.layout.master';
        return view('ngo.union.certificate', compact(
            'unionMember',
            'union',
            'layout'
        ));
    }
}
