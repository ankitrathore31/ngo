@extends('ngo.layout.master')
@section('content')
    <div class="container-fluid py-4">

        {{-- Auth Member Info Card --}}
        <div class="card border-0 shadow-sm mb-4"
            style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-auto">
                        @if ($actor->image)
                            <img src="{{ asset('member_images/' . $actor->image) }}"
                                class="rounded-circle border border-3 border-warning" width="70" height="70"
                                style="object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center"
                                style="width:70px;height:70px;font-size:26px;font-weight:700;color:#1a1a2e;">
                                {{ strtoupper(substr($actor->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="col text-white">
                        <h5 class="mb-0 fw-bold">{{ $actor->name }}</h5>
                        <small class="text-warning">{{ $actor->position ?? 'No Position Assigned' }}</small>
                        <div class="mt-1">
                            <span class="badge bg-warning text-dark me-2">{{ $actor->application_no }}</span>
                            <span class="badge bg-light text-dark">
                                {{ $actorLevel ? \App\Helpers\PositionHierarchy::getLevelLabel($actorLevel) : '—' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-auto text-end">
                        {{-- Add New Union Member Button --}}

                        @if ($actor->is_ngo || ($actor->position && \App\Helpers\PositionHierarchy::canAddSubMembers($actor->position)))
                            <button class="btn btn-warning fw-bold" data-bs-toggle="modal"
                                data-bs-target="#addNewUnionMemberModal">
                                <i class="bi bi-person-plus-fill me-1"></i> Add New Union Member
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (!$actor->is_ngo && !$actor->position)
            <div class="alert alert-warning shadow-sm">
                <strong>Position Not Assigned!</strong> Contact your administrator.
            </div>
        @elseif (!$actor->is_ngo && !\App\Helpers\PositionHierarchy::canAddSubMembers($actor->position))
            <div class="alert alert-danger shadow-sm">
                <strong>Not Allowed!</strong> ग्राम स्तर के सदस्य यूनियन मेंबर नहीं जोड़ सकते।
            </div>
        @endif
        <div class="row">
            <form method="GET" action="{{ route('union.reg.list') }}" class="row g-3 mb-4">

                <div class="col-md-3">
                    <input type="text" name="name" value="{{ request('name') }}" class="form-control"
                        placeholder="Search Name">
                </div>

                <div class="col-md-3">
                    <input type="text" name="gurdian_name" value="{{ request('gurdian_name') }}" class="form-control"
                        placeholder="Father/Husband Name">
                </div>

                <div class="col-md-2">
                    <input type="text" name="application_no" value="{{ request('application_no') }}"
                        class="form-control" placeholder="Application No">
                </div>

                <div class="col-md-2">
                    <input type="text" name="phone" value="{{ request('phone') }}" class="form-control"
                        placeholder="Mobile Number">
                </div>

                <div class="col-md-2">

                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>

                    <a href="{{ route('union.reg.list') }}" class="btn btn-info text-white">

                        Reset

                    </a>

                </div>

            </form>
        </div>
        {{-- Approved Members & Beneficiaries Table --}}
        <div class="card shadow-sm">
            {{-- <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-people-fill me-2"></i>Approved Members &amp; Beneficiaries</h5>
            </div> --}}
            <div class="card-body table-responsive">

                @if ($approvemember->count() > 0)
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr.</th>
                                <th>Source</th>
                                <th>Application Date</th>
                                <th>Application No.</th>
                                <th>registration Date</th>
                                <th>registration No.</th>
                                {{-- <th>Image</th> --}}
                                <th>Name</th>
                                <th>Father/Husband</th>
                                <th>Position Type</th>
                                <th>Position</th>
                                <th>Address</th>
                                <th>Caste</th>
                                <th>Category</th>
                                <th>Religion</th>
                                <th>Mobile</th>
                                <th>Session</th>
                                <th>Add to Union</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($approvemember as $index => $item)
                                @php
                                    $itemId = $item['id'];
                                    $sourceModel = $item['_source'];
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="badge {{ $sourceModel === 'Member' ? 'bg-primary' : 'bg-success' }}">
                                            {{ $sourceModel }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item['application_date'])->format('d-m-Y') }}</td>
                                    <td>{{ $item['application_no'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item['registration_date'])->format('d-m-Y') }}</td>
                                    <td>{{ $item['registration_no'] }}</td>
                                    {{-- <td>
                                        <img src="{{ asset('member_images/' . ($item['image'] ?? 'default.png')) }}"
                                            width="60" class="rounded"
                                            onerror="this.src='{{ asset('member_images/default.png') }}'">
                                    </td> --}}
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['gurdian_name'] ?? '—' }}</td>
                                    <td>{{ $item['position_type'] ?? 'Not Found' }}</td>
                                    <td>{{ $item['position'] ?? 'Not Found' }}</td>
                                    <td class="text-start" style="min-width:160px; font-size:12px;">
                                        {{ $item['village'] ?? '' }}{{ isset($item['village']) && $item['village'] ? ', ' : '' }}
                                        {{ $item['post'] ?? '' }}, {{ $item['block'] ?? '' }},<br>
                                        {{ $item['district'] ?? '' }}, {{ $item['state'] ?? '' }} -
                                        {{ $item['pincode'] ?? '' }}
                                    </td>
                                    <td>{{ $item['caste'] ?? '—' }}</td>
                                    <td>{{ $item['religion_category'] ?? '—' }}</td>
                                    <td>{{ $item['religion'] ?? '—' }}</td>
                                    <td>{{ $item['phone'] ?? '—' }}</td>
                                    <td>{{ $item['academic_session'] ?? '—' }}</td>
                                    <td>
                                        @if ($actor->is_ngo || ($actor->position && \App\Helpers\PositionHierarchy::canAddSubMembers($actor->position)))
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#addUnionModal_{{ $sourceModel }}_{{ $itemId }}">
                                                <i class="bi bi-plus-circle me-1"></i>Add to Union Member
                                            </button>
                                        @else
                                            <span class="text-muted small">N/A</span>
                                        @endif
                                    </td>
                                </tr>

                                @if ($actor->is_ngo || ($actor->position && \App\Helpers\PositionHierarchy::canAddSubMembers($actor->position)))
                                    <div class="modal fade" id="addUnionModal_{{ $sourceModel }}_{{ $itemId }}"
                                        tabindex="-1">
                                        tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form action="{{ route('store.union.member') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="source_id" value="{{ $itemId }}">
                                                    <input type="hidden" name="source_model" value="{{ $sourceModel }}">
                                                    <input type="hidden" name="member_by" value="{{ $actor->id }}">

                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">
                                                            <i class="bi bi-person-check-fill me-2"></i>
                                                            Add {{ $item['name'] }} to Union
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">

                                                        {{-- Member Summary --}}
                                                        <div
                                                            class="alert alert-light border d-flex align-items-center gap-3 mb-3">

                                                            <strong>{{ $item['name'] }}</strong>
                                                            <span
                                                                class="badge {{ $sourceModel === 'Member' ? 'bg-primary' : 'bg-success' }} ms-2">{{ $sourceModel }}</span><br>
                                                            <small class="text-muted">{{ $item['application_no'] }} |
                                                                {{ $item['phone'] ?? '' }}</small>
                                                        </div>
                                                    </div>

                                                    <div class="row g-3">

                                                        {{-- Union Select --}}
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Select Union <span
                                                                    class="text-danger">*</span></label>
                                                            <select name="union_id" class="form-select" required>
                                                                <option value="">-- Select Union --</option>
                                                                @foreach ($unions as $union)
                                                                    <option value="{{ $union->id }}">
                                                                        {{ $union->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        {{-- Join Date --}}
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-semibold">Join Date <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="date" name="join_date" class="form-control"
                                                                value="{{ date('Y-m-d') }}" required>
                                                        </div>

                                                        {{-- Position Level --}}
                                                        <div class="col-12">
                                                            <div class="border rounded p-3 bg-light">
                                                                <h6 class="text-primary fw-bold mb-3">
                                                                    <i class="bi bi-diagram-3-fill me-2"></i>Position
                                                                    in Union
                                                                </h6>
                                                                <div class="row g-3">
                                                                    <div class="col-md-4">
                                                                        <label class="form-label">Level <span
                                                                                class="text-danger">*</span></label>
                                                                        <select class="form-select" name="position_type"
                                                                            id="posType_{{ $sourceModel }}_{{ $itemId }}"
                                                                            required
                                                                            onchange="updateUnionPositions('{{ $sourceModel }}_{{ $itemId }}')">
                                                                            <option value="" disabled selected>--
                                                                                Select Level --</option>
                                                                            @foreach ($allowedLevels as $levelKey => $positions)
                                                                                <option value="{{ $levelKey }}">
                                                                                    {{ \App\Helpers\PositionHierarchy::getLevelLabel($levelKey) }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4"
                                                                        id="posBox_{{ $sourceModel }}_{{ $itemId }}"
                                                                        style="display:none">
                                                                        <label class="form-label">Position <span
                                                                                class="text-danger">*</span></label>
                                                                        <select class="form-select" name="position"
                                                                            id="pos_{{ $sourceModel }}_{{ $itemId }}"
                                                                            required>
                                                                            <option value="" disabled selected>--
                                                                                Select Position --</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4"
                                                                        id="areaBox_{{ $sourceModel }}_{{ $itemId }}"
                                                                        style="display:none">
                                                                        <label class="form-label">Working Area <span
                                                                                class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control"
                                                                            name="working_area"
                                                                            placeholder="e.g. Delhi Zone 3" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success fw-bold">
                                                <i class="bi bi-person-check-fill me-1"></i> Save to Union
                                            </button>
                                        </div>
                                        </form>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-warning text-center mb-0">
                        No approved records found.
                    </div>
                @endif
            </div>
        </div>

        @if ($actor->is_ngo || ($actor->position && \App\Helpers\PositionHierarchy::canAddSubMembers($actor->position)))
            <div class="modal fade" id="addNewUnionMemberModal" tabindex="-1">
                <div class="modal-dialog modal-xl modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content" style="max-height:90vh;">

                        <div class="modal-header bg-warning">
                            <h5 class="modal-title fw-bold text-dark">
                                <i class="bi bi-person-plus-fill me-2"></i>Register New Union Member
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body overflow-auto">

                            @php $districtsByState = config('districts'); @endphp

                            {{-- Union & Join Date --}}
                            <div class="border rounded p-3 mb-4 bg-light">
                                <form action="{{-- --}}" method="POST">
                                    @csrf
                                    <h6 class="text-primary fw-bold mb-3"><i class="bi bi-building me-2"></i>Union Details
                                    </h6>
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Select Union <span
                                                    class="text-danger">*</span></label>
                                            <select name="union_id" class="form-select" required>
                                                <option value="">-- Select Union --</option>
                                                @foreach ($unions as $union)
                                                    <option value="{{ $union->id }}">{{ $union->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Join Date <span class="text-danger">*</span></label>
                                            <input type="date" name="join_date" class="form-control"
                                                value="{{ date('Y-m-d') }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Session <span class="text-danger">*</span></label>
                                            <select class="form-select" name="academic_session" required>
                                                <option value="">Select Session</option>
                                                @foreach ($sessions as $session)
                                                    <option value="{{ $session->session_date }}">
                                                        {{ $session->session_date }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                            </div>

                            {{-- Position Section --}}
                            <div class="border rounded p-3 mb-4 bg-light">
                                <h6 class="text-primary fw-bold mb-3"><i class="bi bi-diagram-3-fill me-2"></i>Position
                                    Details</h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Select Level <span class="text-danger">*</span></label>
                                        <select class="form-select" id="new_position_type" name="position_type" required
                                            onchange="updateNewUnionPositions()">
                                            <option value="" disabled selected>-- Select Level --</option>
                                            @foreach ($allowedLevels as $levelKey => $positions)
                                                <option value="{{ $levelKey }}">
                                                    {{ \App\Helpers\PositionHierarchy::getLevelLabel($levelKey) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4" id="new_position_box" style="display:none">
                                        <label class="form-label">Select Position <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="new_position" name="position" required>
                                            <option value="" disabled selected>-- Select Position --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4" id="new_working_area_box" style="display:none">
                                        <label class="form-label">Working Area <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="working_area"
                                            placeholder="e.g. Delhi, UP Zone 3">
                                    </div>
                                </div>
                            </div>

                            {{-- Identity --}}
                            <div class="border rounded p-3 mb-4">
                                <h6 class="text-primary fw-bold mb-3"><i class="bi bi-card-text me-2"></i>Identity
                                    Information</h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Identity Type <span class="text-danger">*</span></label>
                                        <select class="form-select" name="identity_type" required>
                                            <option value="" disabled selected>Select</option>
                                            @foreach (['Aadhar Card', 'Voter ID Card', 'Pan Card', 'Markshhet', 'Driving License', 'Narega Card', 'Ration Card', 'Bank Passbook', 'Any Id Card'] as $idType)
                                                <option value="{{ $idType }}">{{ $idType }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Identity Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="identity_no"
                                            id="new_identity_no" placeholder="Enter ID Number" required>
                                        <small id="new_check_identity" class="form-text"></small>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">ID Document <small
                                                class="text-muted">(Image/PDF)</small></label>
                                        <input type="file" class="form-control" name="id_document"
                                            accept="image/*,.pdf">
                                    </div>
                                </div>
                            </div>

                            {{-- Application Details --}}
                            <div class="border rounded p-3 mb-4">
                                <h6 class="text-primary fw-bold mb-3"><i
                                        class="bi bi-file-earmark-text me-2"></i>Application Details</h6>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Application Date <span
                                                class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="application_date"
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Photo</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="border rounded d-flex align-items-center justify-content-center bg-light"
                                                style="width:55px;height:55px;overflow:hidden;" id="newPhotoWrap">
                                                <span id="newPhotoPlaceholder"><i
                                                        class="bi bi-person fs-4 text-muted"></i></span>
                                                <img id="newPhotoPreview" src=""
                                                    style="width:55px;height:55px;object-fit:cover;display:none;">
                                            </div>
                                            <input type="file" class="form-control" name="image" accept="image/*"
                                                onchange="previewNewPhoto(this)">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Personal Info --}}
                            <div class="border rounded p-3 mb-4">
                                <h6 class="text-primary fw-bold mb-3"><i class="bi bi-person-fill me-2"></i>Personal
                                    Information</h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Father/Husband Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="gurdian_name" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Mother Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="mother_name" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="dob" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Gender <span class="text-danger">*</span></label>
                                        <select class="form-select" name="gender" required>
                                            <option value="" disabled selected>Select</option>
                                            @foreach (['Male', 'Female', 'Other'] as $g)
                                                <option value="{{ $g }}">{{ $g }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Marital Status <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" name="marital_status" required>
                                            <option value="" disabled selected>Select</option>
                                            @foreach (['Married', 'Unmarried'] as $ms)
                                                <option value="{{ $ms }}">{{ $ms }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="phone" maxlength="10"
                                            required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Occupation <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="occupation" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Education Level</label>
                                        <select class="form-select" name="eligibility">
                                            <option value="">Select</option>
                                            @foreach (['Uneducated', 'Literate', 'Nursery', 'Below Primary', 'Primary Passed', 'Below Middle', 'Middle Passed', 'Highschool', 'Intermediate', 'B.A.', 'B.Sc.', 'B.Com.', 'B.Tech.', 'M.A.', 'M.Sc.', 'M.Com.', 'M.Tech.', 'Other'] as $edu)
                                                <option value="{{ $edu }}">{{ $edu }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="border rounded p-3 mb-4">
                                <h6 class="text-primary fw-bold mb-3"><i class="bi bi-geo-alt-fill me-2"></i>Address
                                    Information</h6>
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">State <span class="text-danger">*</span></label>
                                        <select class="form-select" name="state" id="newStateSelect" required>
                                            <option value="">Select State</option>
                                            @foreach ($districtsByState as $state => $districts)
                                                <option value="{{ $state }}">{{ $state }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">District <span class="text-danger">*</span></label>
                                        <select class="form-select" name="district" id="newDistrictSelect" required>
                                            <option value="">Select District</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Area Type <span class="text-danger">*</span></label>
                                        <select class="form-select" name="area_type" required>
                                            <option value="" disabled selected>Select</option>
                                            <option value="Rular">Rural</option>
                                            <option value="Urban">Urban</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Block/Town <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="block" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Post <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="post" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Village/Locality</label>
                                        <input type="text" class="form-control" name="village">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Pincode</label>
                                        <input type="number" class="form-control" name="pincode">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Nationality <span class="text-danger">*</span></label>
                                        <select class="form-select" name="country" required>
                                            <option value="India" selected>India</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Religion & Caste --}}
                            <div class="border rounded p-3 mb-4">
                                <h6 class="text-primary fw-bold mb-3"><i class="bi bi-people-fill me-2"></i>Religion &
                                    Caste</h6>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Religion <span class="text-danger">*</span></label>
                                        <select class="form-select" name="religion" required>
                                            <option value="" disabled selected>Select</option>
                                            @foreach (['Hindu', 'Islam', 'Christian', 'Sikh', 'Buddhist', 'Parsi'] as $rel)
                                                <option value="{{ $rel }}">{{ $rel }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Caste Category <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" name="religion_category" required>
                                            <option value="" disabled selected>Select</option>
                                            @foreach (['General', 'OBC', 'SC', 'ST', 'Minority'] as $cat)
                                                <option value="{{ $cat }}">{{ $cat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Caste <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="caste" required>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning fw-bold text-dark">
                                <i class="bi bi-person-plus-fill me-1"></i>Register Union Member
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <script>
            const allowedLevels = @json($allowedLevels);

            // ── Per-row modal position dropdowns ──────────────────────────────────────
            function updateUnionPositions(key) {
                const typeEl = document.getElementById('posType_' + key);
                const posEl = document.getElementById('pos_' + key);
                const posBox = document.getElementById('posBox_' + key);
                const areaBox = document.getElementById('areaBox_' + key);

                const levelKey = typeEl.value;
                posEl.innerHTML = '<option value="" disabled selected>-- Select Position --</option>';

                if (allowedLevels[levelKey]) {
                    allowedLevels[levelKey].forEach(p => {
                        const o = document.createElement('option');
                        o.value = p;
                        o.text = p;
                        posEl.add(o);
                    });
                    posBox.style.display = '';
                    areaBox.style.display = '';
                } else {
                    posBox.style.display = 'none';
                    areaBox.style.display = 'none';
                }
            }

            // ── New union member modal position dropdowns ─────────────────────────────
            function updateNewUnionPositions() {
                const levelKey = document.getElementById('new_position_type').value;
                const posEl = document.getElementById('new_position');
                posEl.innerHTML = '<option value="" disabled selected>-- Select Position --</option>';

                if (allowedLevels[levelKey]) {
                    allowedLevels[levelKey].forEach(p => {
                        const o = document.createElement('option');
                        o.value = p;
                        o.text = p;
                        posEl.add(o);
                    });
                    document.getElementById('new_position_box').style.display = '';
                    document.getElementById('new_working_area_box').style.display = '';
                } else {
                    document.getElementById('new_position_box').style.display = 'none';
                    document.getElementById('new_working_area_box').style.display = 'none';
                }
            }

            // ── Photo preview (new union member form) ─────────────────────────────────
            function previewNewPhoto(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        document.getElementById('newPhotoPreview').src = e.target.result;
                        document.getElementById('newPhotoPreview').style.display = 'block';
                        document.getElementById('newPhotoPlaceholder').style.display = 'none';
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // ── State → District (new union member form) ──────────────────────────────
            const districtsByState = @json($districtsByState);
            const newStateSelect = document.getElementById('newStateSelect');
            const newDistrictSelect = document.getElementById('newDistrictSelect');

            if (newStateSelect) {
                newStateSelect.addEventListener('change', function() {
                    newDistrictSelect.innerHTML = '<option value="">Select District</option>';
                    (districtsByState[this.value] || []).forEach(d => {
                        const o = document.createElement('option');
                        o.value = d;
                        o.text = d;
                        newDistrictSelect.add(o);
                    });
                });
            }

            // ── Identity number live check (new union member form) ────────────────────
            let identityTimer;
            const newIdentityInput = document.getElementById('new_identity_no');
            if (newIdentityInput) {
                newIdentityInput.addEventListener('input', function() {
                    clearTimeout(identityTimer);
                    const val = this.value.trim();
                    const hint = document.getElementById('new_check_identity');
                    if (val.length < 4) {
                        hint.innerHTML = '';
                        return;
                    }
                    identityTimer = setTimeout(() => {
                        hint.innerHTML = '<span class="text-muted">Checking...</span>';
                        fetch(`{{ route('check.identity') }}?identity_no=${encodeURIComponent(val)}`)
                            .then(r => r.json())
                            .then(data => {
                                hint.innerHTML = data.exists ?
                                    '<span class="text-danger"><i class="bi bi-x-circle"></i> Already registered</span>' :
                                    '<span class="text-success"><i class="bi bi-check-circle"></i> Available</span>';
                            });
                    }, 600);
                });
            }
        </script>
    @endsection
