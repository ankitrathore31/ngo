<?php

namespace App\Http\Controllers;

use App\Helpers\PositionHierarchy;
use App\Models\Member;
use App\Models\beneficiarie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SubMemberController extends Controller
{
    /**
     * Get the currently logged-in member.
     */
    private function getAuthMember(): Member
    {
        $userId = Auth::id();
        return Member::where('phone', Auth::user()->phone_number)->firstOrFail();
    }

    /**
     * Show the Add Sub Member form.
     */
    public function AddSubMember()
    {
        $authMember = $this->getAuthMember();

        // Check if member has a position at all
        if (!$authMember->position) {
            return view('member.sub-member.add', [
                'authMember'     => $authMember,
                'authMemberLevel' => null,
                'allowedLevels'  => [],
                'subMemberCount' => 0,
                'sessions'       => \DB::table('academic_sessions')->orderByDesc('id')->get(),
                'districtsByState' => config('districts'),
            ]);
        }

        // Block gram level from adding sub members
        if (!PositionHierarchy::canAddSubMembers($authMember->position)) {
            return redirect()->route('member.dashboard')
                ->with('error', 'ग्राम स्तर के सदस्य सब-मेंबर नहीं जोड़ सकते।');
        }

        $authMemberLevel = PositionHierarchy::getLevelByPosition($authMember->position);
        $allowedLevels   = PositionHierarchy::getAllowedSubPositions($authMember->position);
        $subMemberCount  = Member::where('added_by', $authMember->id)->count();

        // Load sessions — update model name to match your project
        $sessions = \App\Models\academic_session::orderByDesc('id')->get();

        return view('member.sub-member.add', compact(
            'authMember',
            'authMemberLevel',
            'allowedLevels',
            'subMemberCount',
            'sessions'
        ) + ['districtsByState' => config('districts')]);
    }

    public function StoreSubMember(Request $request)
    {
        $authMember = $this->getAuthMember();

        // --- Permission check ---
        if (!$authMember->position || !PositionHierarchy::canAddSubMembers($authMember->position)) {
            return back()->with('error', 'You are not allowed to add sub members.');
        }

        $allowedLevels = PositionHierarchy::getAllowedSubPositions($authMember->position);
        $allAllowedPositions = array_merge(...array_values($allowedLevels));

        // --- Validation ---
        $validator = Validator::make($request->all(), [
            'position_type'     => 'required|string|in:' . implode(',', array_keys($allowedLevels)),
            'position'          => ['required', 'string', function ($attr, $value, $fail) use ($allAllowedPositions) {
                if (!in_array($value, $allAllowedPositions)) {
                    $fail('Selected position is not allowed under your level.');
                }
            }],
            'working_area'      => 'required|string|max:255',
            'identity_type'     => 'required|string|max:255',
            'identity_no'       => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (
                        \App\Models\Member::where('identity_no', $value)->exists() ||
                        \App\Models\beneficiarie::where('identity_no', $value)->exists()
                    ) {
                        $fail('This identity card number is already registered.');
                    }
                }
            ],
            'id_document'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
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

        // ================================
        // Generate Application Number
        // ================================
        $prefix = '2191000';
        $prefixLength = strlen($prefix);

        $latestMember = Member::where('application_no', 'LIKE', $prefix . '%')
            ->whereRaw("LENGTH(application_no) > ?", [$prefixLength])
            ->selectRaw("CAST(SUBSTRING(application_no, ? + 1) AS UNSIGNED) as seq", [$prefixLength])
            ->orderByDesc('seq')
            ->first();

        $latestBeneficiary = beneficiarie::where('application_no', 'LIKE', $prefix . '%')
            ->whereRaw("LENGTH(application_no) > ?", [$prefixLength])
            ->selectRaw("CAST(SUBSTRING(application_no, ? + 1) AS UNSIGNED) as seq", [$prefixLength])
            ->orderByDesc('seq')
            ->first();

        $lastSequence = max(
            $latestMember ? $latestMember->seq : 0,
            $latestBeneficiary ? $latestBeneficiary->seq : 0
        );

        // ================================
        // Generate Registration Number
        // ================================
        $regPrefix = '2192000';
        $regPrefixLength = strlen($regPrefix);

        $latestRegBeneficiarie = beneficiarie::where('registration_no', 'LIKE', $regPrefix . '%')
            ->whereRaw("LENGTH(registration_no) > ?", [$regPrefixLength])
            ->selectRaw("CAST(SUBSTRING(registration_no, ? + 1) AS UNSIGNED) as seq", [$regPrefixLength])
            ->orderByDesc('seq')
            ->first();

        $latestRegMember = Member::where('registration_no', 'LIKE', $regPrefix . '%')
            ->whereRaw("LENGTH(registration_no) > ?", [$regPrefixLength])
            ->selectRaw("CAST(SUBSTRING(registration_no, ? + 1) AS UNSIGNED) as seq", [$regPrefixLength])
            ->orderByDesc('seq')
            ->first();

        $lastRegSequence = max(
            $latestRegBeneficiarie ? $latestRegBeneficiarie->seq : 54,
            $latestRegMember ? $latestRegMember->seq : 54
        );

        $registrationNo = $regPrefix . ($lastRegSequence + 1);

        // ================================
        // Prepare Data
        // ================================
        $data = $request->except(['image', 'id_document']);

        $data['application_no']   = $prefix . ($lastSequence + 1);
        $data['registration_no']  = $registrationNo;
        $data['registration_date'] = $request->application_date; // SAME as application date
        $data['reg_type']         = 'Member';
        $data['status']           = 1; // DIRECT APPROVED
        $data['added_by']         = $authMember->id;

        // ================================
        // File Upload
        // ================================
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('member_images'), $imageName);
            $data['image'] = $imageName;
        }

        if ($request->hasFile('id_document')) {
            $idDocName = time() . '_id.' . $request->id_document->getClientOriginalExtension();
            $request->id_document->move(public_path('member_images'), $idDocName);
            $data['id_document'] = $idDocName;
        }

        try {
            $newMember = Member::create($data);

            $user = new User();
            $user->name = $newMember->name;
            $user->email = $newMember->email;
            $user->phone_number = $newMember->phone;
            $user->password = Hash::make($newMember->phone);
            $user->user_type = 'member';
            $user->save();

            if (function_exists('logWork')) {
                logWork(
                    'Member',
                    $newMember->id,
                    'Sub Member Added (Direct Approved)',
                    'Added by Member ID: ' . $authMember->id .
                        ' | App No: ' . $newMember->application_no .
                        ' | Reg No: ' . $newMember->registration_no .
                        ' | Name: ' . $newMember->name
                );
            }

            return redirect()
                ->route('member.sub-member.list')
                ->with('success', 'Sub member "' . $newMember->name .
                    '" registered successfully! Reg No: ' . $newMember->registration_no);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function SubmemberList(Request $request)
    {
        $authMember = $this->getAuthMember();

        $query = Member::where('added_by', $authMember->id);

        // Search filter
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                    ->orWhere('phone', 'like', "%$s%")
                    ->orWhere('application_no', 'like', "%$s%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $subMembers = $query->latest()->paginate(15);

        return view('member.sub-member.list', compact('authMember', 'subMembers'));
    }

    public function SubmemberShow($id)
    {
        $authMember = $this->getAuthMember();

        $member = Member::where('id', $id)
            ->where('added_by', $authMember->id)
            ->firstOrFail();

        return view('member.sub-member.show', compact('authMember', 'member'));
    }
}
