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

                    <div class="col-md-4 mb-3">
                        <label for="project_code">Project Code:</label>
                        <input type="text" id="project_code" name="project_code" class="form-control"
                            value="{{ old('project_code') }}" required>
                        @error('project_code')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="project_name">Project Name:</label>
                        <input type="text" id="project_name" name="project_name" class="form-control"
                            value="{{ old('project_name') }}" required>
                        @error('project_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="center">Center Name:</label>
                        <input type="text" id="center" name="center" class="form-control" value="{{ old('center') }}"
                            required>
                        @error('center')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @php
                        $districtsByState = config('districts');
                    @endphp
                    <div class="col-md-4 form-group mb-3">
                        <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label>
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

                    <div class="col-md-4 form-group mb-3">
                        <label for="districtSelect" class="form-label">District: <span class="text-danger">*</span></label>
                        <select class="form-control @error('district') is-invalid @enderror" name="district"
                            id="districtSelect" required>
                            <option value="">Select District</option>
                        </select>
                        @error('district')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="animator_code">Animator Code:</label>
                        <input type="text" id="animator_code" name="animator_code" class="form-control"
                            value="{{ old('animator_code', $user_code) }}" readonly required>
                        @error('animator_code')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="animator_name">Animator Name:</label>
                        <input type="text" id="animator_name" name="animator_name" class="form-control"
                            value="{{ old('animator_name', $user_name) }}" readonly required>
                        @error('animator_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
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


                    <div class="col-md-4 mb-3">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" class="form-control"
                            value="{{ old('date') }}" required>
                        @error('date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>


                <!-- BENEFICIARY FORM -->
                <h5><b>Add Beneficiary Survey</b></h5>
                <div id="beneficiary-form" class="row g-3">
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

                    {{-- Address --}}
                    <div class="col-md-6">
                        <label for="address">Address: <span class="text-danger">*</span></label>
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

                    {{-- Age --}}
                    <div class="col-md-6">
                        <label for="age">Age: <span class="text-danger">*</span></label>
                        <input type="number" id="age" class="form-control" min="1" max="120">
                    </div>

                    {{-- Beneficiaries Type --}}
                    <div class="col-md-6">
                        <label for="beneficiaries_type">Beneficiaries Type: <span class="text-danger">*</span></label>
                        <input type="text" id="beneficiaries_type" class="form-control">
                    </div>

                    {{-- Disability --}}
                    <div class="col-md-6">
                        <label for="disability_percentage">Disability %:</label>
                        <input type="number" id="disability_percentage" class="form-control" min="0"
                            max="100">
                    </div>

                    {{-- Widow Since --}}
                    <div class="col-md-6">
                        <label for="widow_since">Widow Since:</label>
                        <input type="text" id="widow_since" class="form-control">
                    </div>

                    {{-- Type of Victim --}}
                    <div class="col-md-6">
                        <label for="type_of_victim">Type of Victim:</label>
                        <input type="text" id="type_of_victim" class="form-control">
                    </div>

                    {{-- Class --}}
                    <div class="col-md-6">
                        <label for="class">Class:</label>
                        <input type="text" id="class" class="form-control">
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

        // Helper function to collect current form data
        function getBeneficiaryData() {
            return {
                name: document.getElementById('name').value.trim(),
                father_husband_name: document.getElementById('father_husband_name').value.trim(),
                address: document.getElementById('address').value.trim(),
                mobile_no: document.getElementById('mobile_no').value.trim(),
                caste: document.getElementById('caste').value.trim(),
                age: document.getElementById('age').value.trim(),
                beneficiaries_type: document.getElementById('beneficiaries_type').value.trim(),
                disability_percentage: document.getElementById('disability_percentage').value.trim(),
                widow_since: document.getElementById('widow_since').value.trim(),
                type_of_victim: document.getElementById('type_of_victim').value.trim(),
                class: document.getElementById('class').value.trim(),
                place_identification_mark: document.getElementById('place_identification_mark').value.trim(),
            };
        }

        // Add a new beneficiary to the list
        function addBeneficiary() {
            const ben = getBeneficiaryData();

            // Validate required fields
            if (!ben.name || !ben.father_husband_name || !ben.address || !ben.mobile_no || !ben.age || !ben
                .beneficiaries_type) {
                alert('Please fill all required beneficiary fields.');
                return;
            }

            // Validate mobile number (10 digits only)
            if (!/^\d{10}$/.test(ben.mobile_no)) {
                alert('Please enter a valid 10-digit mobile number.');
                return;
            }

            // Add to array
            beneficiaries.push(ben);
            updateBeneficiaryList();

            // Clear input fields
            document.querySelectorAll('#beneficiary-form input, #beneficiary-form textarea').forEach(el => el.value = '');
        }

        // Remove beneficiary by index
        function removeBeneficiary(index) {
            beneficiaries.splice(index, 1);
            updateBeneficiaryList();
        }

        // Update the visible beneficiary list and hidden inputs
        function updateBeneficiaryList() {
            const list = document.getElementById('beneficiary-list');
            list.innerHTML = '';

            beneficiaries.forEach((b, i) => {
                list.innerHTML += `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><strong>${i + 1}. ${b.name}</strong> - ${b.father_husband_name} (${b.mobile_no})</span>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeBeneficiary(${i})">❌</button>
                </li>
            `;
            });

            createHiddenInputs();
        }

        // Create hidden inputs for Laravel submission
        function createHiddenInputs() {
            // Remove old hidden inputs
            document.querySelectorAll('input[name^="beneficiaries["]').forEach(input => input.remove());

            const form = document.getElementById('surveyForm');

            beneficiaries.forEach((ben, index) => {
                Object.keys(ben).forEach(key => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `beneficiaries[${index}][${key}]`;
                    input.value = ben[key] || '';
                    form.appendChild(input);
                });
            });
        }

        // Check if current form has data and add it (used before final submit)
        function checkAndAddCurrentBeneficiary() {
            const currentBen = getBeneficiaryData();

            if (
                currentBen.name &&
                currentBen.father_husband_name &&
                currentBen.address &&
                currentBen.mobile_no &&
                currentBen.age &&
                currentBen.beneficiaries_type
            ) {
                // Validate mobile number
                if (!/^\d{10}$/.test(currentBen.mobile_no)) {
                    alert('Please enter a valid 10-digit mobile number.');
                    return false;
                }

                beneficiaries.push(currentBen);
                createHiddenInputs();
                return true;
            }
            return false;
        }

        // Initialize form submit listener
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('surveyForm');

            form.addEventListener('submit', function(e) {
                // Add current form data if not already added
                const addedCurrent = checkAndAddCurrentBeneficiary();

                if (beneficiaries.length === 0) {
                    e.preventDefault();
                    alert('Please add at least one beneficiary before submitting.');
                    return false;
                }

                // Always refresh hidden inputs
                createHiddenInputs();

                if (addedCurrent) {
                    const confirmed = confirm(
                        `You have ${beneficiaries.length} beneficiary/beneficiaries (including the current data). Do you want to submit?`
                    );
                    if (!confirmed) {
                        e.preventDefault();
                        beneficiaries.pop();
                        createHiddenInputs();
                        return false;
                    }
                }
            });
        });
    </script>


    <script>
        const allDistricts = @json($districtsByState);
        const oldDistrict = "{{ old('district') }}";
        const oldState = "{{ old('state') }}";

        function populateDistricts(state) {
            const districtSelect = document.getElementById('districtSelect');
            districtSelect.innerHTML = '<option value="">Select District</option>';

            if (allDistricts[state]) {
                allDistricts[state].forEach(function(district) {
                    const selected = (district === oldDistrict) ? 'selected' : '';
                    districtSelect.innerHTML += `<option value="${district}" ${selected}>${district}</option>`;
                });
            }
        }

        // Initial load if editing or validation failed
        if (oldState) {
            populateDistricts(oldState);
        }

        // On state change
        document.getElementById('stateSelect').addEventListener('change', function() {
            populateDistricts(this.value);
        });
    </script>
@endsection
