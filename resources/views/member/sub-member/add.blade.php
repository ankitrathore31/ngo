@extends('member.layout.master')
@section('content')
    <div class="container-fluid py-4">

        {{-- Logged-in Member Info Card --}}
        <div class="card border-0 shadow-sm mb-4"
            style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-auto">
                        @if ($authMember->image)
                            <img src="{{ asset('member_images/' . $authMember->image) }}"
                                class="rounded-circle border border-3 border-warning" width="70" height="70"
                                style="object-fit:cover;">
                        @else
                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center"
                                style="width:70px;height:70px;font-size:26px;font-weight:700;color:#1a1a2e;">
                                {{ strtoupper(substr($authMember->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="col text-white">
                        <h5 class="mb-0 fw-bold">{{ $authMember->name }}</h5>
                        <small class="text-warning">{{ $authMember->position ?? 'No Position Assigned' }}</small>
                        <div class="mt-1">
                            <span class="badge bg-warning text-dark me-2">{{ $authMember->application_no }}</span>
                            <span
                                class="badge bg-light text-dark">{{ $authMemberLevel ? \App\Helpers\PositionHierarchy::getLevelLabel($authMemberLevel) : '—' }}</span>
                        </div>
                    </div>
                    <div class="col-auto text-end text-white">
                        <small class="d-block opacity-75">Sub Members Added</small>
                        <h3 class="fw-bold text-warning mb-0">{{ $subMemberCount }}</h3>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (!$authMember->position)
            <div class="alert alert-warning shadow-sm">
                <i class="bi bi-info-circle-fill me-2"></i>
                <strong>Position Not Assigned!</strong> You need a position assigned before you can add sub-members. Please
                contact your administrator.
            </div>
        @elseif(!\App\Helpers\PositionHierarchy::canAddSubMembers($authMember->position))
            <div class="alert alert-danger shadow-sm">
                <i class="bi bi-x-circle-fill me-2"></i>
                <strong>Not Allowed!</strong> Members with <strong>ग्राम (Village)</strong> level positions cannot add
                sub-members.
            </div>
        @else
            {{-- Registration Form --}}
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i>Add Sub Member</h5>
                    <small class="opacity-75">All sub-members will be registered under:
                        <strong>{{ $authMember->name }}</strong></small>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('member.sub-member.store') }}" enctype="multipart/form-data"
                        id="subMemberForm">
                        @csrf

                        {{-- POSITION SECTION --}}
                        <div class="border rounded p-3 mb-4 bg-light">
                            <h6 class="text-primary mb-3 fw-bold"><i class="bi bi-diagram-3-fill me-2"></i>Position Details
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Select Level <span class="text-danger">*</span></label>
                                    <select class="form-select @error('position_type') is-invalid @enderror"
                                        id="position_type" name="position_type" required onchange="updateSubPositions()">
                                        <option value="" disabled selected>-- Select Level --</option>
                                        @foreach ($allowedLevels as $levelKey => $positions)
                                            <option value="{{ $levelKey }}"
                                                {{ old('position_type') == $levelKey ? 'selected' : '' }}>
                                                {{ \App\Helpers\PositionHierarchy::getLevelLabel($levelKey) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('position_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3" id="position_box"
                                    style="{{ old('position_type') ? '' : 'display:none' }}">
                                    <label class="form-label">Select Position <span class="text-danger">*</span></label>
                                    <select class="form-select @error('position') is-invalid @enderror" id="position"
                                        name="position" required>
                                        <option value="" disabled selected>-- Select Position --</option>
                                        @if (old('position_type') && isset($allowedLevels[old('position_type')]))
                                            @foreach ($allowedLevels[old('position_type')] as $pos)
                                                <option value="{{ $pos }}"
                                                    {{ old('position') == $pos ? 'selected' : '' }}>{{ $pos }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3" id="working_area_box"
                                    style="{{ old('position_type') ? '' : 'display:none' }}">
                                    <label class="form-label">Working Area <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('working_area') is-invalid @enderror"
                                        name="working_area" placeholder="e.g. Delhi, UP Zone 3"
                                        value="{{ old('working_area') }}" required>
                                    @error('working_area')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- IDENTITY SECTION --}}
                        <div class="border rounded p-3 mb-4">
                            <h6 class="text-primary mb-3 fw-bold"><i class="bi bi-card-text me-2"></i>Identity Information
                            </h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Identity Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('identity_type') is-invalid @enderror"
                                        name="identity_type" id="identity_type" required>
                                        <option value="" disabled selected>Select Identity Type</option>
                                        @foreach (['Aadhar Card', 'Voter ID Card', 'Pan Card', 'Markshhet', 'Driving License', 'Narega Card', 'Ration Card', 'Bank Passbook', 'Any Id Card'] as $idType)
                                            <option value="{{ $idType }}"
                                                {{ old('identity_type') == $idType ? 'selected' : '' }}>
                                                {{ $idType }}</option>
                                        @endforeach
                                    </select>
                                    @error('identity_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Identity Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('identity_no') is-invalid @enderror"
                                        name="identity_no" id="identity_no" placeholder="Enter ID Number"
                                        value="{{ old('identity_no') }}" required>
                                    <small id="check_identity" class="form-text"></small>
                                    @error('identity_no')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">ID Document <small
                                            class="text-muted">(Image/PDF)</small></label>
                                    <input type="file" class="form-control" name="id_document" accept="image/*,.pdf">
                                </div>
                            </div>
                        </div>

                        {{-- APPLICATION SECTION --}}
                        <div class="border rounded p-3 mb-4">
                            <h6 class="text-primary mb-3 fw-bold"><i class="bi bi-file-earmark-text me-2"></i>Application
                                Details</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Application Date <span class="text-danger">*</span></label>
                                    <input type="date"
                                        class="form-control @error('application_date') is-invalid @enderror"
                                        name="application_date" value="{{ old('application_date', date('Y-m-d')) }}"
                                        required>
                                    @error('application_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Session <span class="text-danger">*</span></label>
                                    <select class="form-select @error('academic_session') is-invalid @enderror"
                                        name="academic_session" required>
                                        <option value="">Select Session</option>
                                        @foreach ($sessions as $session)
                                            <option value="{{ $session->session_date }}"
                                                {{ old('academic_session') == $session->session_date ? 'selected' : '' }}>
                                                {{ $session->session_date }}</option>
                                        @endforeach
                                    </select>
                                    @error('academic_session')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Photo</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div id="photoPreviewWrap"
                                            class="border rounded d-flex align-items-center justify-content-center bg-light"
                                            style="width:60px;height:60px;overflow:hidden;">
                                            <span class="text-muted small text-center" id="photoPlaceholder"><i
                                                    class="bi bi-person fs-4"></i></span>
                                            <img id="photoPreview" src=""
                                                style="width:60px;height:60px;object-fit:cover;display:none;">
                                        </div>
                                        <input type="file" class="form-control" name="image" id="uploadInput"
                                            accept="image/*" onchange="previewPhoto(this)">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PERSONAL INFO --}}
                        <div class="border rounded p-3 mb-4">
                            <h6 class="text-primary mb-3 fw-bold"><i class="bi bi-person-fill me-2"></i>Personal
                                Information</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Father/Husband Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('gurdian_name') is-invalid @enderror"
                                        name="gurdian_name" value="{{ old('gurdian_name') }}" required>
                                    @error('gurdian_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Mother Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('mother_name') is-invalid @enderror"
                                        name="mother_name" value="{{ old('mother_name') }}" required>
                                    @error('mother_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('dob') is-invalid @enderror"
                                        name="dob" value="{{ old('dob') }}" required>
                                    @error('dob')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select class="form-select @error('gender') is-invalid @enderror" name="gender"
                                        required>
                                        <option value="" disabled selected>Select</option>
                                        @foreach (['Male', 'Female', 'Other'] as $g)
                                            <option value="{{ $g }}"
                                                {{ old('gender') == $g ? 'selected' : '' }}>{{ $g }}</option>
                                        @endforeach
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Marital Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('marital_status') is-invalid @enderror"
                                        name="marital_status" required>
                                        <option value="" disabled selected>Select</option>
                                        @foreach (['Married', 'Unmarried'] as $ms)
                                            <option value="{{ $ms }}"
                                                {{ old('marital_status') == $ms ? 'selected' : '' }}>{{ $ms }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('marital_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" maxlength="10" value="{{ old('phone') }}" required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Occupation <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('occupation') is-invalid @enderror"
                                        name="occupation" value="{{ old('occupation') }}" required>
                                    @error('occupation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Education Level</label>
                                    <select class="form-select @error('eligibility') is-invalid @enderror"
                                        name="eligibility">
                                        <option value="">Select</option>
                                        @foreach (['Uneducated', 'Literate', 'Nursery', 'Below Primary', 'Primary Passed', 'Below Middle', 'Middle Passed', 'Highschool', 'Intermediate', 'B.A.', 'B.Sc.', 'B.Com.', 'B.Tech.', 'M.A.', 'M.Sc.', 'M.Com.', 'M.Tech.', 'Other'] as $edu)
                                            <option value="{{ $edu }}"
                                                {{ old('eligibility') == $edu ? 'selected' : '' }}>{{ $edu }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- ADDRESS INFO --}}
                        <div class="border rounded p-3 mb-4">
                            <h6 class="text-primary mb-3 fw-bold"><i class="bi bi-geo-alt-fill me-2"></i>Address
                                Information</h6>
                            @php $districtsByState = config('districts'); @endphp
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <select class="form-select @error('state') is-invalid @enderror" name="state"
                                        id="stateSelect" required>
                                        <option value="">Select State</option>
                                        @foreach ($districtsByState as $state => $districts)
                                            <option value="{{ $state }}"
                                                {{ old('state') == $state ? 'selected' : '' }}>{{ $state }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">District <span class="text-danger">*</span></label>
                                    <select class="form-select @error('district') is-invalid @enderror" name="district"
                                        id="districtSelect" required>
                                        <option value="">Select District</option>
                                    </select>
                                    @error('district')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Area Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('area_type') is-invalid @enderror" name="area_type"
                                        required>
                                        <option value="" disabled selected>Select</option>
                                        <option value="Rular" {{ old('area_type') == 'Rular' ? 'selected' : '' }}>Rural
                                        </option>
                                        <option value="Urban" {{ old('area_type') == 'Urban' ? 'selected' : '' }}>Urban
                                        </option>
                                    </select>
                                    @error('area_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Block/Town <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('block') is-invalid @enderror"
                                        name="block" value="{{ old('block') }}" required>
                                    @error('block')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Post <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('post') is-invalid @enderror"
                                        name="post" value="{{ old('post') }}" required>
                                    @error('post')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Village/Locality</label>
                                    <input type="text" class="form-control" name="village"
                                        value="{{ old('village') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Pincode</label>
                                    <input type="number" class="form-control" name="pincode"
                                        value="{{ old('pincode') }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Nationality <span class="text-danger">*</span></label>
                                    <select class="form-select" name="country" required>
                                        <option value="India" selected>India</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- RELIGION & CASTE --}}
                        <div class="border rounded p-3 mb-4">
                            <h6 class="text-primary mb-3 fw-bold"><i class="bi bi-people-fill me-2"></i>Religion & Caste
                            </h6>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Religion <span class="text-danger">*</span></label>
                                    <select class="form-select @error('religion') is-invalid @enderror" name="religion"
                                        required>
                                        <option value="" disabled selected>Select</option>
                                        @foreach (['Hindu', 'Islam', 'Christian', 'Sikh', 'Buddhist', 'Parsi'] as $rel)
                                            <option value="{{ $rel }}"
                                                {{ old('religion') == $rel ? 'selected' : '' }}>{{ $rel }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('religion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Caste Category <span class="text-danger">*</span></label>
                                    <select class="form-select @error('religion_category') is-invalid @enderror"
                                        name="religion_category" required>
                                        <option value="" disabled selected>Select</option>
                                        @foreach (['General', 'OBC', 'SC', 'ST', 'Minority'] as $cat)
                                            <option value="{{ $cat }}"
                                                {{ old('religion_category') == $cat ? 'selected' : '' }}>
                                                {{ $cat }}</option>
                                        @endforeach
                                    </select>
                                    @error('religion_category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Caste <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('caste') is-invalid @enderror"
                                        name="caste" value="{{ old('caste') }}" required>
                                    @error('caste')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">
                                <i class="bi bi-person-plus-fill me-2"></i>Register Sub Member
                            </button>
                            <a href="{{ route('member.sub-member.list') }}"
                                class="btn btn-outline-secondary px-4 py-2 ms-2">
                                <i class="bi bi-list-ul me-2"></i>View Sub Members
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        @endif

    </div>
    <script>
        // Positions by level (only allowed levels will be shown via PHP, but JS handles dynamic dropdown)
        const allowedLevels = @json($allowedLevels);

        function updateSubPositions() {
            const levelKey = document.getElementById('position_type').value;
            const positionSelect = document.getElementById('position');
            positionSelect.innerHTML = '<option value="" disabled selected>-- Select Position --</option>';

            if (allowedLevels[levelKey]) {
                allowedLevels[levelKey].forEach(pos => {
                    const opt = document.createElement('option');
                    opt.value = pos;
                    opt.text = pos;
                    positionSelect.add(opt);
                });
                document.getElementById('position_box').style.display = '';
                document.getElementById('working_area_box').style.display = '';
            } else {
                document.getElementById('position_box').style.display = 'none';
                document.getElementById('working_area_box').style.display = 'none';
            }
        }

        // Photo preview
        function previewPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('photoPreview').src = e.target.result;
                    document.getElementById('photoPreview').style.display = 'block';
                    document.getElementById('photoPlaceholder').style.display = 'none';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // State → District
        const districtsByState = @json($districtsByState);
        const stateSelect = document.getElementById('stateSelect');
        const districtSelect = document.getElementById('districtSelect');
        const oldDistrict = "{{ old('district') }}";

        stateSelect.addEventListener('change', function() {
            districtSelect.innerHTML = '<option value="">Select District</option>';
            const districts = districtsByState[this.value] || [];
            districts.forEach(d => {
                const opt = document.createElement('option');
                opt.value = d;
                opt.text = d;
                districtSelect.add(opt);
            });
        });

        // Restore district on validation error
        if (oldDistrict && stateSelect.value) {
            const districts = districtsByState[stateSelect.value] || [];
            districtSelect.innerHTML = '<option value="">Select District</option>';
            districts.forEach(d => {
                const opt = document.createElement('option');
                opt.value = d;
                opt.text = d;
                if (d === oldDistrict) opt.selected = true;
                districtSelect.add(opt);
            });
        }

        // Identity number live check
        let identityCheckTimer;
        document.getElementById('identity_no').addEventListener('input', function() {
            clearTimeout(identityCheckTimer);
            const val = this.value.trim();
            const hint = document.getElementById('check_identity');
            if (val.length < 4) {
                hint.innerHTML = '';
                return;
            }
            identityCheckTimer = setTimeout(() => {
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
    </script>
@endsection
