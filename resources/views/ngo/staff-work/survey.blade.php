@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-items-center mb-1 mt-2">
            <h5 class="mb-0">Survey</h5>
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
            <form id="surveyForm" method="POST" action="{{ route('store.survey') }}">
                @csrf
                <div class="row">
                    <h5><b>Survey Info</b></h5>
                    <div class="col-md-12">
                        {{-- <p> Sanstha Name: &nbsp; Gyan Bharti Sanstha, Kainchu Tanda, Amaria Pilibhit (UP) 262121</p> --}}
                    </div>
                    <input type="hidden" name="user_id" value="{{ $user_id }}" readonly>

                    <div class="col-md-6 mb-3">
                        <label for="date">Survey Date:</label>
                        <input type="date" id="date" name="date" class="form-control" value="{{ old('date') }}"
                            required>
                        @error('date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="project_code">Project Code:</label>
                        <input type="text" id="project_code" name="project_code" class="form-control"
                            value="{{ old('project_code') }}" required>
                        @error('project_code')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="project_name">Project Name:</label>
                        <input type="text" id="project_name" name="project_name" class="form-control"
                            value="{{ old('project_name') }}" required>
                        @error('project_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="center">Center Name:</label>
                        <input type="text" id="center" name="center" class="form-control"
                            value="{{ old('center') }}" required>
                        @error('center')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-sm-6 mb-3">
                        <label for="animator_code">Animator Code:</label>
                        <input type="text" id="animator_code" name="animator_code" class="form-control"
                            value="{{ old('animator_code', $user_code) }}" readonly required>
                        @error('animator_code')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="animator_name">Animator Name:</label>
                        <input type="text" id="animator_name" name="animator_name" class="form-control"
                            value="{{ old('animator_name', $user_name) }}" readonly required>
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
                                    {{ old('session') == $session->session_date ? 'selected' : '' }}>
                                    {{ $session->session_date }}
                                </option>
                            @endforeach
                        </select>
                        @error('session')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="row mb-2 mt-1">
                    <div class="col">
                        <h5><b>Add Beneficiary Survey</b></h5>
                    </div>
                </div>
                <div id="beneficiary-form" class="row g-3 mt-4">
                    <!-- Search Input -->
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" id="searchInput" class="form-control"
                                placeholder="Search by Reg. No, Name, Phone, or ID No">
                        </div>
                    </div>

                    <!-- Results Table -->
                    <div id="recordTableDiv" style="display: none;" class="table-responsive">
                        <table id="recordTable" class="table table-bordered table-striped table-hover"
                            style="border-collapse: collapse; width: 100%;">
                            <thead class="table-primary">
                                <tr>
                                    <th>Type</th>
                                    <th>Registration No</th>
                                    <th>Name</th>
                                    <th>Father/Husband</th>
                                    <th>Mother</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Identity Type</th>
                                    <th>Identity No</th>
                                    <th>Session</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($record as $item)
                                    <tr class="record-row" data-name="{{ $item->name }}"
                                        data-phone="{{ $item->phone }}"
                                        data-gurdian="{{ $item->gurdian_name }}"data-registration="{{ $item->registration_no }}"
                                        data-registrationDate="{{ $item->registration_date }}"
                                        data-address="{{ $item->village }}, {{ $item->post }}"
                                        data-block="{{ $item->block }}" data-district="{{ $item->district }}"
                                        data-state="{{ $item->state }}" style="cursor: pointer;">
                                        <td>{{ get_class($item) === 'App\\Models\\beneficiarie' ? 'Beneficiary' : 'Member' }}
                                        </td>
                                        <td>{{ $item->registration_no ?? 'Not Found' }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->gurdian_name }}</td>
                                        <td>{{ $item->mother_name }}</td>
                                        <td>{{ $item->village }},{{ $item->post }},{{ $item->town }},{{ $item->district }},{{ $item->state }}
                                        </td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->identity_type ?? '—' }}</td>
                                        <td>{{ $item->identity_no ?? '—' }}</td>
                                        <td>{{ $item->academic_session ?? '_' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Selected Record Info -->
                    <div id="selectedRecord" class="mt-3" style="display: none;">
                        <div class="card shadow-sm border rounded p-3 bg-light">
                            <h5 class="card-title text-primary">Selected Person Details</h5>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0" id="selectedInfo">
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="col-md-6 mb-3">
                        <label for="survey_id">Survey ID:</label>
                        <input type="text" id="survey_id" name="survey_id" class="form-control"
                            value="{{ old('survey_id', $newSurveyId) }}" readonly required>
                        @error('survey_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Identity Type -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="identity_type" class="form-label">Identity Type: <span
                                    class="text-danger">*</span></label>
                            <select class="form-control @error('identity_type') is-invalid @enderror" id="identity_type"
                                name="identity_type" required>
                                <option value="" disabled {{ old('identity_type') ? '' : 'selected' }}>
                                    Select Identity Type</option>
                                <option value="Aadhar Card" {{ old('identity_type') == 'Aadhar Card' ? 'selected' : '' }}>
                                    Aadhar Card
                                </option>
                                <option value="Voter ID Card"
                                    {{ old('identity_type') == 'Voter ID Card' ? 'selected' : '' }}>Voter ID
                                    Card
                                </option>
                                <option value="Pan Card" {{ old('identity_type') == 'Pan Card' ? 'selected' : '' }}>Pan
                                    Card
                                </option>
                                <option value="Markshhet" {{ old('identity_type') == 'Markshhet' ? 'selected' : '' }}>
                                    Markshhet
                                </option>
                                <option value="Driving License"
                                    {{ old('identity_type') == 'Driving License' ? 'selected' : '' }}>Driving
                                    License</option>
                                <option value="Narega Card" {{ old('identity_type') == 'Narega Card' ? 'selected' : '' }}>
                                    Narega Card
                                </option>
                                <option value="Ration Card" {{ old('identity_type') == 'Ration Card' ? 'selected' : '' }}>
                                    Ration Card
                                </option>
                                <option value="Bank Passbook"
                                    {{ old('identity_type') == 'Bank Passbook' ? 'selected' : '' }}>Bank
                                    Passbook
                                </option>
                                <option value="Any Id Card" {{ old('identity_type') == 'Any Id Card' ? 'selected' : '' }}>
                                    Any Id Card
                                </option>
                            </select>
                            @error('identity_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Identity Number -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="identity_no" class="form-label">Identity Card Number: <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('identity_no') is invalid @enderror"
                                id="identity_no" name="identity_no" placeholder="Enter Identity Card No" required>
                            <small id="identity_no_hint" class="form-text text-muted"></small>
                            <small id="check_identity" class="form-text"></small>
                            @error('identity_no')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div id="identity_info" class="text-center"
                        style="margin-top:1px; margin-bottom:4px; color:red; display:none;">
                        Survey ID: <span id="identity_reg"></span> &nbsp; &nbsp;
                        Name: <span id="identity_name"></span> &nbsp; &nbsp;
                        Father/Husband: <span id="identity_guardian"></span> &nbsp; &nbsp;
                        Animator Name: <span id="animator_name"></span>
                    </div>

                    {{-- Name --}}
                    <div class="col-md-6">
                        <label for="name">Name: <span class="text-danger">*</span></label>
                        <input type="text" id="name" class="form-control">
                    </div>

                    {{-- Father/Husband Name --}}
                    <div class="col-md-6">
                        <label for="father_husband_name">Father/Husband Name: <span class="text-danger">*</span></label>
                        <input type="text" id="father_husband_name" class="form-control">
                    </div>

                    @php
                        $districtsByState = config('districts');
                    @endphp
                    <div class="col-md-6 form-group mb-3">
                        <label for="stateSelect" class="form-label">Address &nbsp; State: <span
                                class="text-danger">*</span></label>
                        <select class="form-control @error('state') is-invalid @enderror" name="state" id="stateSelect"
                            required>
                            <option value="">Select State</option>
                            @foreach ($districtsByState as $state => $districts)
                                <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>
                                    {{ $state }}
                                </option>
                            @endforeach
                        </select>
                        @error('state')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="districtSelect" class="form-label">District: <span
                                class="text-danger">*</span></label>
                        <select class="form-control @error('district') is-invalid @enderror" name="district"
                            id="districtSelect" required>
                            <option value="">Select District</option>
                        </select>
                        @error('district')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="area_type" class="form-label">Area Type: <span class="text-danger">*</span></label>
                        <select class="form-control" id="area_type" required>
                            <option value="" selected disabled>Select Area</option>
                            <option value="Rular" {{ old('area_type') == 'Rular' ? 'selected' : '' }}>
                                Rular
                            </option>
                            <option value="Urban" {{ old('area_type') == 'Urban' ? 'selected' : '' }}>
                                Urban
                            </option>
                        </select>
                        @error('area_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="block_name">Block:</label>
                        <input type="text" id="block_name" name="block" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label for="post_town">Post/Town:</label>
                        <input type="text" id="post_town" name="post_town" class="form-control">
                    </div>

                    {{-- Address --}}
                    <div class="col-md-6">
                        <label for="address">Village/Locality: <span class="text-danger">*</span></label>
                        <textarea id="address" class="form-control" rows="2"></textarea>
                    </div>

                    {{-- Mobile No. --}}
                    <div class="col-md-6">
                        <label for="mobile_no">Mobile No.: <span class="text-danger">*</span></label>
                        <input type="text" id="mobile_no" class="form-control" maxlength="10">
                    </div>

                    {{-- Caste --}}
                    <div class="col-md-6">
                        <label for="caste">Caste:</label>
                        <input type="text" id="caste" class="form-control">
                    </div>

                    <!-- Caste Category -->
                    <div class="col-md-6 mb-3">
                        <label for="category" class="form-label">Caste Category <span
                                class="text-danger">*</span></label>
                        <select class="form-select @error('caste_category') is-invalid @enderror" id="category"
                            name="caste_category" required>
                            <option value="" disabled {{ old('caste_category') ? '' : 'selected' }}>
                                Select Category</option>
                            @foreach (['General', 'OBC', 'SC', 'ST', 'Minority'] as $category)
                                <option value="{{ $category }}"
                                    {{ old('caste_category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                        @error('caste_category')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Age --}}
                    <div class="col-md-6">
                        <label for="age">Age: <span class="text-danger">*</span></label>
                        <input type="number" id="age" class="form-control" min="1" max="120">
                    </div>

                    {{-- Beneficiaries Type --}}
                    <div class="col-md-6">
                        <label for="beneficiaries_type">Scheme Type: <span class="text-danger">*</span></label>
                        <select class="form-control @error('beneficiaries_type') is-invalid @enderror"
                            id="beneficiaries_type" name="beneficiaries_type" required>
                            <option value="" disabled {{ old('beneficiaries_type') ? '' : 'selected' }}>Select
                                Scheme Type</option>
                            @foreach (['CM Child Welfare (CM Baal Seva)', 'Economically Weaker Section', 'Elderly Women', 'Homeless Families', 'Laborers', 'Landless', 'Large Farmers', 'Labour Card', 'Marginal Farmers', 'Old Age', 'People Living in Kutcha or One-Room Houses', 'Persons with Disabilities (Viklang Log)', 'Scheduled Castes', 'Shadi Anudaan', 'Samuhik vivah', 'Scheduled Tribes', 'Small Farmers', 'Sumangla Scheme', 'Victims (Pidit Log)', 'Widows'] as $category)
                                <option value="{{ $category }}"
                                    {{ old('beneficiaries_type') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Disability --}}
                    <div class="col-md-6" id="disability_div">
                        <label for="disability_percentage">Disability %:</label>
                        <input type="number" id="disability_percentage" class="form-control" min="0"
                            max="100">
                    </div>

                    {{-- Widow Since --}}
                    <div class="col-md-6" id="widow_since_div">
                        <label for="widow_since">Widow Since:</label>
                        <input type="text" id="widow_since" class="form-control">
                    </div>

                    {{-- Type of Victim --}}
                    <div class="col-md-6" id="type_of_victim_div">
                        <label for="type_of_victim">Type of Victim:</label>
                        <input type="text" id="type_of_victim" class="form-control">
                    </div>

                    {{-- Class (for Sumangla & Baal Seva) --}}

                    <div class="col-md-6">
                        <label for="class">Class:</label>
                        <input type="text" id="class" name="class_name" class="form-control">
                    </div>
                    {{-- Person Death Date (for Baal Seva) --}}
                    <div class="col-md-6" id="death_date_div">
                        <label for="death_date">Person Death Date:</label>
                        <input type="date" id="death_date" class="form-control">
                    </div>

                    {{-- Labour Card Details --}}
                    <div class="col-md-6" id="labour_card_no_div">
                        <label for="labour_card_no">Labour Card No:</label>
                        <input type="text" id="labour_card_no" class="form-control">
                    </div>

                    <div class="col-md-6" id="labour_card_date_div">
                        <label for="labour_card_date">Labour Card Date:</label>
                        <input type="date" id="labour_card_date" class="form-control">
                    </div>

                    {{-- Land (for all Farmer types) --}}
                    <div class="col-md-6" id="land_div">
                        <label for="land">Land (in Beegah):</label>
                        <input type="text" id="land" class="form-control">
                    </div>

                    {{-- Remark (default for others) --}}
                    <div class="col-md-6" id="remark_div">
                        <label for="remark">Remark:</label>
                        <input type="text" id="remark" class="form-control">
                    </div>

                    {{-- Place Identification Mark --}}
                    <div class="col-md-6">
                        <label for="place_identification_mark">Place Identification Mark:</label>
                        <textarea id="place_identification_mark" class="form-control" rows="2"></textarea>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="button" class="btn btn-success" onclick="addBeneficiary()">Add Beneficiary to
                        List</button>
                    <small class="text-muted d-block mt-2">
                        <i class="fa fa-info-circle"></i> Click "Add Beneficiary to List" to add this person to the list,
                        or click "Save Survey" to save all (including current form data).
                    </small>
                </div>
                <hr>

                <!-- BENEFICIARY LIST -->
                <h5>Added Beneficiaries</h5>
                <ul id="beneficiary-list" class="list-group mb-4"></ul>
                <button type="submit" class="btn btn-primary">Save Survey</button>
            </form>
        </div>

    </div>
    <script>
        let beneficiaries = [];
        let currentSurveyNumber = parseInt("{{ intval(substr($newSurveyId, -7)) }}");
        const surveyPrefix = "3126SID";

        // Generate next survey ID
        function getNextSurveyId() {
            currentSurveyNumber++;
            return `${surveyPrefix}${String(currentSurveyNumber).padStart(7, "0")}`;
        }

        // Collect data from inputs
        function getBeneficiaryData() {
            return {
                survey_id: document.getElementById('survey_id').value.trim(),
                identity_type: document.getElementById('identity_type').value.trim(),
                identity_no: document.getElementById('identity_no').value.trim(),
                name: document.getElementById('name').value.trim(),
                father_husband_name: document.getElementById('father_husband_name').value.trim(),
                state: document.getElementById('stateSelect').value.trim(),
                district: document.getElementById('districtSelect').value.trim(),
                area_type: document.getElementById('area_type').value.trim(),
                block: document.getElementById('block_name').value.trim(),
                post_town: document.getElementById('post_town').value.trim(),
                address: document.getElementById('address').value.trim(),
                mobile_no: document.getElementById('mobile_no').value.trim(),
                caste: document.getElementById('caste').value.trim(),
                caste_category: document.getElementById('category').value.trim(),
                age: document.getElementById('age').value.trim(),
                beneficiaries_type: document.getElementById('beneficiaries_type').value.trim(),
                disability_percentage: document.getElementById('disability_percentage').value.trim(),
                widow_since: document.getElementById('widow_since').value.trim(),
                type_of_victim: document.getElementById('type_of_victim').value.trim(),
                class_name: document.getElementById('class').value.trim(),
                death_date: document.getElementById('death_date').value.trim(),
                labour_card_no: document.getElementById('labour_card_no').value.trim(),
                labour_card_date: document.getElementById('labour_card_date').value.trim(),
                land: document.getElementById('land').value.trim(),
                remark: document.getElementById('remark').value.trim(),
                place_identification_mark: document.getElementById('place_identification_mark').value.trim(),
            };
        }

        // Check if current form has data
        function hasCurrentFormData() {
            const ben = getBeneficiaryData();
            return ben.name || ben.mobile_no || ben.beneficiaries_type;
        }

        // Add a beneficiary to the list
        function addBeneficiary() {
            const ben = getBeneficiaryData();

            // Validation
            if (!ben.name || !ben.mobile_no || !ben.beneficiaries_type) {
                alert('⚠️ Please fill at least Name, Mobile No. and Scheme Type.');
                return;
            }

            if (!/^\d{10}$/.test(ben.mobile_no)) {
                alert('⚠️ Invalid Mobile Number. Must be 10 digits.');
                return;
            }

            // Push to array
            beneficiaries.push(ben);
            updateBeneficiaryList();

            // Generate and show next Survey ID
            const nextId = getNextSurveyId();
            document.getElementById('survey_id').value = nextId;

            // Clear ONLY beneficiary form fields (keep header info)
            clearBeneficiaryForm();

            alert('✅ Beneficiary added to list!');
        }

        // Clear ONLY beneficiary form fields (NOT header fields like date, project_code, etc.)
        function clearBeneficiaryForm() {
            // List of IDs to clear (beneficiary-specific fields only)
            const fieldsToClear = [
                'identity_type', 'identity_no', 'name', 'father_husband_name',
                'stateSelect', 'districtSelect', 'area_type', 'block_name',
                'post_town', 'address', 'mobile_no', 'caste', 'category',
                'age', 'beneficiaries_type', 'disability_percentage',
                'widow_since', 'type_of_victim', 'class', 'death_date',
                'labour_card_no', 'labour_card_date', 'land', 'remark',
                'place_identification_mark'
            ];

            fieldsToClear.forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    if (el.tagName === 'SELECT') {
                        el.selectedIndex = 0; // Reset to first option
                    } else {
                        el.value = '';
                    }
                }
            });

            // Clear the district dropdown
            document.getElementById('districtSelect').innerHTML = '<option value="">Select District</option>';
        }

        // Update beneficiary list display
        function updateBeneficiaryList() {
            const list = document.getElementById('beneficiary-list');
            list.innerHTML = '';

            if (beneficiaries.length === 0) {
                list.innerHTML = '<li class="list-group-item text-muted">No beneficiaries added to list yet.</li>';
                return;
            }

            beneficiaries.forEach((b, i) => {
                list.innerHTML += `
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span>
                <strong>${b.survey_id}</strong> — ${b.name} — ${b.mobile_no} (${b.beneficiaries_type})
            </span>
            <button type="button" class="btn btn-sm btn-danger" onclick="removeBeneficiary(${i})">❌ Remove</button>
        </li>`;
            });
        }

        // Remove beneficiary from list
        function removeBeneficiary(index) {
            if (confirm('Are you sure you want to remove this beneficiary from the list?')) {
                beneficiaries.splice(index, 1);
                updateBeneficiaryList();
            }
        }

        // Create hidden inputs for ALL beneficiaries (list + current form)
        function createHiddenInputs() {
            // Remove existing hidden inputs
            document.querySelectorAll('input[name^="beneficiaries["]').forEach(el => el.remove());

            const form = document.getElementById('surveyForm');

            // Create array combining list + current form data
            let allBeneficiaries = [...beneficiaries];

            // Check if current form has data
            if (hasCurrentFormData()) {
                const currentData = getBeneficiaryData();
                allBeneficiaries.push(currentData);
            }

            // Create hidden inputs for all beneficiaries
            allBeneficiaries.forEach((ben, i) => {
                for (const key in ben) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `beneficiaries[${i}][${key}]`;
                    input.value = ben[key] || '';
                    form.appendChild(input);
                }
            });
        }

        // Form submission handler
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('surveyForm');

            form.addEventListener('submit', (e) => {
                e.preventDefault(); // Prevent default submission

                // Count total beneficiaries (list + current form)
                let totalCount = beneficiaries.length;
                if (hasCurrentFormData()) {
                    totalCount++;
                }

                // Check if there's any data to save
                if (totalCount === 0) {
                    alert(
                        '⚠️ Please fill beneficiary information or add beneficiaries to the list before saving.'
                    );
                    return;
                }

                // Create hidden inputs (includes both list + current form)
                createHiddenInputs();

                // Confirm submission
                let message = '';
                if (beneficiaries.length > 0 && hasCurrentFormData()) {
                    message =
                        `✅ You are submitting:\n- ${beneficiaries.length} beneficiary/beneficiaries from the list\n- 1 beneficiary from current form\n\nTotal: ${totalCount} beneficiaries.\n\nContinue?`;
                } else if (beneficiaries.length > 0) {
                    message =
                        `✅ You are submitting ${beneficiaries.length} beneficiary/beneficiaries from the list. Continue?`;
                } else {
                    message = `✅ You are submitting 1 beneficiary from the current form. Continue?`;
                }

                const ok = confirm(message);
                if (ok) {
                    form.submit(); // Actually submit the form
                }
            });

            // Initialize list display
            updateBeneficiaryList();
        });
    </script>

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
