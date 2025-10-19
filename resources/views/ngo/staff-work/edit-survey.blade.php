@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-items-center mb-1 mt-2">
            <h5 class="mb-0">Edit Survey</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-1 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Survey</li>
                </ol>
            </nav>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="container mt-5">
            <form id="editSurveyForm" method="POST" action="{{ route('update.survey', $survey->id) }}">
                @csrf
                <div class="row">
                    <h5><b>Edit Survey Info</b></h5>

                    <input type="hidden" name="user_id" value="{{ $survey->user_id }}">

                    <div class="col-md-6 mb-3">
                        <label for="date">Survey Date:</label>
                        <input type="date" id="date" name="date" class="form-control"
                            value="{{ old('date', $survey->date) }}" required>
                        @error('date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="project_code">Project Code:</label>
                        <input type="text" id="project_code" name="project_code" class="form-control"
                            value="{{ old('project_code', $survey->project_code) }}" required>
                        @error('project_code')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="project_name">Project Name:</label>
                        <input type="text" id="project_name" name="project_name" class="form-control"
                            value="{{ old('project_name', $survey->project_name) }}" required>
                        @error('project_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="center">Center Name:</label>
                        <input type="text" id="center" name="center" class="form-control"
                            value="{{ old('center', $survey->center) }}" required>
                        @error('center')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-sm-6 mb-3">
                        <label for="animator_code">Animator Code:</label>
                        <input type="text" id="animator_code" name="animator_code" class="form-control"
                            value="{{ old('animator_code', $survey->animator_code) }}" readonly required>
                        @error('animator_code')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="animator_name">Animator Name:</label>
                        <input type="text" id="animator_name" name="animator_name" class="form-control"
                            value="{{ old('animator_name', $survey->animator_name) }}" readonly required>
                        @error('animator_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="session" class="bold">Session <span class="text-danger">*</span></label>
                        <select class="form-control @error('session') is-invalid @enderror" name="session" id="session"
                            required>
                            <option value="">Select Session</option>
                            @foreach ($data as $session)
                                <option value="{{ $session->session_date }}"
                                    {{ old('session', $survey->session) == $session->session_date ? 'selected' : '' }}>
                                    {{ $session->session_date }}
                                </option>
                            @endforeach
                        </select>
                        @error('session')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>

                <div class="row mb-2 mt-3">
                    <div class="col">
                        <h5><b>Beneficiary Information</b></h5>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <label for="survey_id">Survey ID:</label>
                        <input type="text" id="survey_id" name="survey_id" class="form-control"
                            value="{{ old('survey_id', $survey->survey_id) }}" readonly required>
                        @error('survey_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Identity Type -->
                    <div class="col-md-6 mb-3">
                        <label for="identity_type" class="form-label">Identity Type: <span
                                class="text-danger">*</span></label>
                        <select class="form-control @error('identity_type') is-invalid @enderror" id="identity_type"
                            name="identity_type" required>
                            <option value="" disabled>Select Identity Type</option>
                            @foreach (['Aadhar Card', 'Voter ID Card', 'Pan Card', 'Markshhet', 'Driving License', 'Narega Card', 'Ration Card', 'Bank Passbook', 'Any Id Card'] as $type)
                                <option value="{{ $type }}"
                                    {{ old('identity_type', $survey->identity_type) == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        @error('identity_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Identity Number -->
                    <div class="col-md-6 mb-3">
                        <label for="identity_no" class="form-label">Identity Card Number: <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('identity_no') is-invalid @enderror"
                            id="identity_no" name="identity_no" value="{{ old('identity_no', $survey->identity_no) }}"
                            placeholder="Enter Identity Card No" required>
                        @error('identity_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div class="col-md-6 mb-3">
                        <label for="name">Name: <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name', $survey->name) }}" required>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Father/Husband Name -->
                    <div class="col-md-6 mb-3">
                        <label for="father_husband_name">Father/Husband Name: <span class="text-danger">*</span></label>
                        <input type="text" id="father_husband_name" name="father_husband_name" class="form-control"
                            value="{{ old('father_husband_name', $survey->father_husband_name) }}" required>
                        @error('father_husband_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    @php
                        $districtsByState = config('districts');
                    @endphp

                    <!-- State -->
                    <div class="col-md-6 form-group mb-3">
                        <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label>
                        <select class="form-control @error('state') is-invalid @enderror" name="state" id="stateSelect"
                            required>
                            <option value="">Select State</option>
                            @foreach ($districtsByState as $state => $districts)
                                <option value="{{ $state }}"
                                    {{ old('state', $survey->state) == $state ? 'selected' : '' }}>
                                    {{ $state }}
                                </option>
                            @endforeach
                        </select>
                        @error('state')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- District -->
                    <div class="col-md-6 form-group mb-3">
                        <label for="districtSelect" class="form-label">District: <span
                                class="text-danger">*</span></label>
                        <select class="form-control @error('district') is-invalid @enderror" name="district"
                            id="districtSelect" required>
                            <option value="">Select District</option>
                            @if (old('state', $survey->state) && isset($districtsByState[old('state', $survey->state)]))
                                @foreach ($districtsByState[old('state', $survey->state)] as $district)
                                    <option value="{{ $district }}"
                                        {{ old('district', $survey->district) == $district ? 'selected' : '' }}>
                                        {{ $district }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('district')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Area Type -->
                    <div class="col-md-6 form-group mb-3">
                        <label for="area_type" class="form-label">Area Type: <span class="text-danger">*</span></label>
                        <select class="form-control" id="area_type" name="area_type" required>
                            <option value="" disabled>Select Area</option>
                            <option value="Rular"
                                {{ old('area_type', $survey->area_type) == 'Rular' ? 'selected' : '' }}>
                                Rular
                            </option>
                            <option value="Urban"
                                {{ old('area_type', $survey->area_type) == 'Urban' ? 'selected' : '' }}>
                                Urban
                            </option>
                        </select>
                        @error('area_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Block -->
                    <div class="col-md-6 mb-3">
                        <label for="block_name">Block:</label>
                        <input type="text" id="block_name" name="block" class="form-control"
                            value="{{ old('block', $survey->block) }}">
                    </div>

                    <!-- Post/Town -->
                    <div class="col-md-6 mb-3">
                        <label for="post_town">Post/Town:</label>
                        <input type="text" id="post_town" name="post_town" class="form-control"
                            value="{{ old('post_town', $survey->post_town) }}">
                    </div>

                    <!-- Address -->
                    <div class="col-md-6 mb-3">
                        <label for="address">Village/Locality: <span class="text-danger">*</span></label>
                        <textarea id="address" name="address" class="form-control" rows="2" required>{{ old('address', $survey->address) }}</textarea>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Mobile No. -->
                    <div class="col-md-6 mb-3">
                        <label for="mobile_no">Mobile No.: <span class="text-danger">*</span></label>
                        <input type="text" id="mobile_no" name="mobile_no" class="form-control"
                            value="{{ old('mobile_no', $survey->mobile_no) }}" maxlength="10" required>
                        @error('mobile_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Caste -->
                    <div class="col-md-6 mb-3">
                        <label for="caste">Caste:</label>
                        <input type="text" id="caste" name="caste" class="form-control"
                            value="{{ old('caste', $survey->caste) }}">
                    </div>

                    <!-- Caste Category -->
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Caste Category <span
                                class="text-danger">*</span></label>
                        <select class="form-select @error('caste_category') is-invalid @enderror" id="category"
                            name="caste_category" required>
                            <option value="" disabled>Select Category</option>
                            @foreach (['General', 'OBC', 'SC', 'ST', 'Minority'] as $category)
                                <option value="{{ $category }}"
                                    {{ old('caste_category', $survey->caste_category) == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                        @error('caste_category')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Age -->
                    <div class="col-md-6 mb-3">
                        <label for="age">Age: <span class="text-danger">*</span></label>
                        <input type="number" id="age" name="age" class="form-control"
                            value="{{ old('age', $survey->age) }}" min="1" max="120" required>
                        @error('age')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Beneficiaries Type -->
                    <div class="col-md-6 mb-3">
                        <label for="beneficiaries_type">Scheme Type: <span class="text-danger">*</span></label>
                        <input list="beneficiaries_type_list"
                            class="form-control @error('beneficiaries_type') is-invalid @enderror" id="beneficiaries_type"
                            name="beneficiaries_type"
                            value="{{ old('beneficiaries_type', $survey->beneficiaries_type) }}"
                            placeholder="Select or type new type" required>
                        <datalist id="beneficiaries_type_list">
                            @foreach (['CM Child Welfare (CM Baal Seva)', 'Economically Weaker Section', 'Elderly Women', 'Homeless Families', 'Laborers', 'Landless', 'Large Farmers', 'Labour Card', 'Marginal Farmers', 'Old Age', 'People Living in Kutcha or One-Room Houses', 'Persons with Disabilities (Viklang Log)', 'Scheduled Castes', 'Shadi Anudaan', 'Samuhik vivah', 'Scheduled Tribes', 'Small Farmers', 'Sumangla Scheme', 'Victims (Pidit Log)', 'Widows'] as $type)
                                <option value="{{ $type }}"></option>
                            @endforeach
                        </datalist>
                        @error('beneficiaries_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Disability -->
                    <div class="col-md-6 mb-3" id="disability_div">
                        <label for="disability_percentage">Disability %:</label>
                        <input type="number" id="disability_percentage" name="disability_percentage"
                            class="form-control"
                            value="{{ old('disability_percentage', $survey->disability_percentage) }}" min="0"
                            max="100">
                    </div>

                    <!-- Widow Since -->
                    <div class="col-md-6 mb-3" id="widow_since_div">
                        <label for="widow_since">Widow Since:</label>
                        <input type="text" id="widow_since" name="widow_since" class="form-control"
                            value="{{ old('widow_since', $survey->widow_since) }}">
                    </div>

                    <!-- Type of Victim -->
                    <div class="col-md-6 mb-3" id="type_of_victim_div">
                        <label for="type_of_victim">Type of Victim:</label>
                        <input type="text" id="type_of_victim" name="type_of_victim" class="form-control"
                            value="{{ old('type_of_victim', $survey->type_of_victim) }}">
                    </div>

                    <!-- Class -->
                    <div class="col-md-6 mb-3" id="class_div">
                        <label for="class">Class:</label>
                        <input type="text" id="class" name="class_name" class="form-control"
                            value="{{ old('class_name', $survey->class_name) }}">
                    </div>

                    <!-- Person Death Date -->
                    <div class="col-md-6 mb-3" id="death_date_div">
                        <label for="death_date">Person Death Date:</label>
                        <input type="date" id="death_date" name="death_date" class="form-control"
                            value="{{ old('death_date', $survey->death_date) }}">
                    </div>

                    <!-- Labour Card No -->
                    <div class="col-md-6 mb-3" id="labour_card_no_div">
                        <label for="labour_card_no">Labour Card No:</label>
                        <input type="text" id="labour_card_no" name="labour_card_no" class="form-control"
                            value="{{ old('labour_card_no', $survey->labour_card_no) }}">
                    </div>

                    <!-- Labour Card Date -->
                    <div class="col-md-6 mb-3" id="labour_card_date_div">
                        <label for="labour_card_date">Labour Card Date:</label>
                        <input type="date" id="labour_card_date" name="labour_card_date" class="form-control"
                            value="{{ old('labour_card_date', $survey->labour_card_date) }}">
                    </div>

                    <!-- Land -->
                    <div class="col-md-6 mb-3" id="land_div">
                        <label for="land">Land (in Beegah):</label>
                        <input type="text" id="land" name="land" class="form-control"
                            value="{{ old('land', $survey->land) }}">
                    </div>

                    <!-- Remark -->
                    <div class="col-md-6 mb-3" id="remark_div">
                        <label for="remark">Remark:</label>
                        <input type="text" id="remark" name="remark" class="form-control"
                            value="{{ old('remark', $survey->remark) }}">
                    </div>

                    <!-- Place Identification Mark -->
                    <div class="col-md-6 mb-3">
                        <label for="place_identification_mark">Place Identification Mark:</label>
                        <textarea id="place_identification_mark" name="place_identification_mark" class="form-control" rows="2">{{ old('place_identification_mark', $survey->place_identification_mark) }}</textarea>
                    </div>
                </div>

                <hr>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Update Survey
                    </button>
                    <a href="{{ route('survey.list') }}" class="btn btn-secondary">
                        <i class="fa fa-times"></i> Cancel
                    </a>
                </div>
            </form>

        </div>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tableDiv = document.getElementById('recordTableDiv');
            const tableRows = document.querySelectorAll('.record-row');
            const selectedRecord = document.getElementById('selectedRecord');
            const selectedInfo = document.getElementById('selectedInfo');

            // ✅ Search filter logic
            searchInput.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                let match = false;

                tableRows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    if (text.includes(query)) {
                        row.style.display = '';
                        match = true;
                    } else {
                        row.style.display = 'none';
                    }
                });

                tableDiv.style.display = query && match ? 'block' : 'none';
            });

            // ✅ Handle row click — fill form fields
            tableRows.forEach(row => {
                row.addEventListener('click', function() {
                    const name = this.dataset.name || '';
                    const phone = this.dataset.phone || '';
                    const gurdian = this.dataset.gurdian || '';
                    const address = this.dataset.address || '';
                    const block = this.dataset.block || '';
                    const district = this.dataset.district || '';
                    const state = this.dataset.state || '';
                    const registration = this.dataset.registration || '';
                    const registrationDate = this.dataset.registrationdate || '';

                    // ✅ Fill inputs by ID (not name)
                    const safeSet = (id, value) => {
                        const el = document.getElementById(id);
                        if (el) el.value = value;
                    };

                    safeSet('name', name);
                    safeSet('father_husband_name', gurdian);
                    safeSet('address', address);
                    safeSet('mobile_no', phone);
                    safeSet('block_name', block);
                    safeSet('stateSelect', state);
                    safeSet('survey_id', registration);

                    // ✅ Populate districts based on state
                    populateDistricts(state);
                    const districtSelect = document.getElementById('districtSelect');
                    if (districtSelect) districtSelect.value = district;

                    // ✅ Show selected info card
                    selectedInfo.innerHTML = `
                    <div class="row">
                        <div class="col-md-3"><strong>Name:</strong> ${name}</div>
                        <div class="col-md-3"><strong>Mobile:</strong> ${phone}</div>
                        <div class="col-md-3"><strong>Registration No.:</strong> ${registration}</div>
                        <div class="col-md-3"><strong>District:</strong> ${district}</div>
                    </div>
                `;
                    selectedRecord.style.display = 'block';

                    // ✅ Hide the table and clear search
                    tableDiv.style.display = 'none';
                    searchInput.value = '';
                });
            });
        });
    </script>

    <script>
        // ✅ State → District logic (unchanged but slightly improved)
        const allDistricts = @json($districtsByState);
        const oldDistrict = "{{ old('district') }}";
        const oldState = "{{ old('state') }}";

        function populateDistricts(state, selectedDistrict = '') {
            const districtSelect = document.getElementById('districtSelect');
            districtSelect.innerHTML = '<option value="">Select District</option>';

            if (allDistricts[state]) {
                allDistricts[state].forEach(function(district) {
                    const selected = (district === selectedDistrict) ? 'selected' : '';
                    districtSelect.innerHTML += `<option value="${district}" ${selected}>${district}</option>`;
                });
            }
        }

        // ✅ Initialize on load
        if (oldState) {
            populateDistricts(oldState, oldDistrict);
        }

        // ✅ On state change
        document.getElementById('stateSelect').addEventListener('change', function() {
            populateDistricts(this.value);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeInput = document.getElementById('beneficiaries_type');

            const fields = {
                disability: document.getElementById('disability_div'),
                widow: document.getElementById('widow_since_div'),
                victim: document.getElementById('type_of_victim_div'),
                class: document.getElementById('class_div'),
                deathDate: document.getElementById('death_date_div'),
                labourCardNo: document.getElementById('labour_card_no_div'),
                labourCardDate: document.getElementById('labour_card_date_div'),
                land: document.getElementById('land_div'),
                remark: document.getElementById('remark_div')
            };

            function hideAll() {
                Object.values(fields).forEach(div => div.style.display = 'none');
            }

            function updateFields() {
                const value = typeInput.value.trim().toLowerCase();
                hideAll();

                // CM Baal Seva
                if (value.includes('baal seva')) {
                    fields.class.style.display = 'block';
                    fields.deathDate.style.display = 'block';
                }
                // Sumangla Scheme
                else if (value === 'sumangla scheme') {
                    fields.class.style.display = 'block';
                }
                // Widows
                else if (value === 'widows') {
                    fields.widow.style.display = 'block';
                    fields.victim.style.display = 'block';
                }
                // Victims
                else if (value.includes('pidit log') || value.includes('victim')) {
                    fields.victim.style.display = 'block';
                }
                // Persons with Disabilities
                else if (value.includes('viklang log')) {
                    fields.disability.style.display = 'block';
                }
                // Labour Card
                else if (value.includes('labour card')) {
                    fields.labourCardNo.style.display = 'block';
                    fields.labourCardDate.style.display = 'block';
                }
                // Any Farmer Type
                else if (value.includes('farmer')) {
                    fields.land.style.display = 'block';
                }
                // Default Case
                else {
                    fields.remark.style.display = 'block';
                }
            }

            // Run when input changes
            typeInput.addEventListener('input', updateFields);

            // Initialize on load
            updateFields();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeInput = document.getElementById('beneficiaries_type');

            // ✅ Map of all field divs by purpose
            const fields = {
                disability: document.getElementById('disability_div'),
                widow: document.getElementById('widow_since_div'),
                victim: document.getElementById('type_of_victim_div'),
                class: document.getElementById('class').closest('.col-md-6'), // fixed
                deathDate: document.getElementById('death_date_div'),
                labourCardNo: document.getElementById('labour_card_no_div'),
                labourCardDate: document.getElementById('labour_card_date_div'),
                land: document.getElementById('land_div'),
                remark: document.getElementById('remark_div')
            };

            // ✅ Hide all optional sections
            function hideAll() {
                Object.values(fields).forEach(div => {
                    if (div) div.style.display = 'none';
                });
            }

            // ✅ Logic to show relevant fields based on Scheme Type
            function updateFields() {
                const value = (typeInput.value || '').trim().toLowerCase();
                hideAll();

                if (value.includes('baal seva')) {
                    // CM Child Welfare (CM Baal Seva)
                    fields.class.style.display = 'block';
                    fields.deathDate.style.display = 'block';
                } else if (value.includes('sumangla')) {
                    // Sumangla Scheme
                    fields.class.style.display = 'block';
                } else if (value.includes('widow')) {
                    // Widows
                    fields.widow.style.display = 'block';
                } else if (value.includes('victim') || value.includes('pidit')) {
                    // Victims
                    fields.victim.style.display = 'block';
                } else if (value.includes('viklang')) {
                    // Persons with Disabilities
                    fields.disability.style.display = 'block';
                } else if (value.includes('labour card')) {
                    // Labour Card
                    fields.labourCardNo.style.display = 'block';
                    fields.labourCardDate.style.display = 'block';
                } else if (value.includes('farmer')) {
                    // All farmer types
                    fields.land.style.display = 'block';
                } else {
                    // Default case — show Remark field
                    fields.remark.style.display = 'block';
                }
            }

            // ✅ Run when input changes
            typeInput.addEventListener('input', updateFields);

            // ✅ Initialize on page load
            updateFields();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const identityType = document.getElementById('identity_type');
            const identityNo = document.getElementById('identity_no');
            const hint = document.getElementById('identity_no_hint');

            identityType.addEventListener('change', function() {
                const type = this.value;
                let pattern = '';
                let message = '';

                switch (type) {
                    case 'Aadhar Card':
                        pattern = '^[2-9]{1}[0-9]{11}$';
                        message = 'Enter 12-digit Aadhar Number.';
                        break;
                    case 'Voter ID Card':
                        pattern = '^[A-Z]{3}[0-9]{7}$';
                        message = 'Enter valid Voter ID (e.g., ABC1234567).';
                        break;
                    case 'Pan Card':
                        pattern = '^[A-Z]{5}[0-9]{4}[A-Z]{1}$';
                        message = 'Enter valid PAN number (e.g., ABCDE1234F).';
                        break;
                    case 'Driving License':
                        pattern = '^[A-Z]{2}[0-9]{2} ?[0-9]{11}$';
                        message = 'Enter valid Driving License number (e.g., RJ14 12345678901).';
                        break;
                    case 'Markshhet':
                    case 'Narega Card':
                    case 'Ration Card':
                        pattern = '^[a-zA-Z0-9/-]{5,20}$';
                        message = 'Enter a valid number (alphanumeric, 5-20 chars).';
                        break;
                    default:
                        pattern = '';
                        message = '';
                }

                identityNo.setAttribute('pattern', pattern);
                identityNo.setCustomValidity('');
                hint.textContent = message;
            });

            // Optional: Prevent form submission if invalid
            document.querySelector('form').addEventListener('submit', function(e) {
                if (!identityNo.checkValidity()) {
                    e.preventDefault();
                    identityNo.reportValidity();
                }
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('identity_no').addEventListener('input', function() {
            let value = this.value.trim();
            let hint = document.getElementById('check_identity');
            let infoLine = document.getElementById('identity_info');

            if (value.length === 0) {
                hint.textContent = '';
                infoLine.style.display = 'none';
                return;
            }

            fetch(`/check-survey-identity?identity_no=${encodeURIComponent(value)}`)
                .then(res => res.json())
                .then(data => {
                    hint.textContent = data.message;
                    hint.style.color = data.exists ? 'red' : 'green';

                    if (data.exists) {
                        document.getElementById('identity_name').textContent = data.name || '';
                        document.getElementById('identity_reg').textContent = data.survey_id || '';
                        document.getElementById('identity_guardian').textContent = data.father_husband_name ||
                            '';
                        document.getElementById('animator_name').textContent = data.animator_name || '';
                        infoLine.style.display = 'block';
                    } else {
                        infoLine.style.display = 'none';
                    }
                })
                .catch(() => {
                    hint.textContent = 'Error checking identity.';
                    hint.style.color = 'orange';
                    infoLine.style.display = 'none';
                });
        });
    </script>

@endsection
