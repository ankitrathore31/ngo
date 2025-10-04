@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Demand Beneficiarie List For Facilities</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('ngo') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Demand Beneficiarie List</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <form method="GET" action="{{ route('beneficiarie-facilities') }}" class="row g-3 mb-4">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <select name="session_filter" id="session_filter" class="form-control">
                                <option value="">All Sessions</option>
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class=" col-md-4">
                            {{-- <label for="bene_category">Beneficiarie Eligibility Category</label> --}}
                            <select id="bene_category" name="bene_category" class="form-control" >
                                <option value="">-- Select Beneficiarie Eligibility Category --</option>
                                <option value="Homeless Families">1. Homeless Families</option>
                                <option value="People living in kutcha or one-room houses">2. People living in kutcha or
                                    one-room houses</option>
                                <option value="Widows">3. Widows</option>
                                <option value="Elderly Women">4. Elderly Women</option>
                                <option value="Persons with Disabilities">5. Persons with Disabilities</option>
                                <option value="Landless">6. Landless</option>
                                <option value="Economically Weaker Section">7. Economically Weaker Section</option>
                                <option value="Laborers">8. Laborers</option>
                                <option value="Scheduled Tribes">9. Scheduled Tribes</option>
                                <option value="Scheduled Castes">10. Scheduled Castes</option>
                                <option value="Based on Low Income">11. Based on Low Income</option>
                                <option value="Affected People">12. Affected People</option>
                                <option value="Marginal Farmers">13. Marginal Farmers</option>
                                <option value="Small Farmers">14. Small Farmers</option>
                                <option value="Large Farmers">15. Large Farmers</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-4 mb-3">
                            <input type="number" class="form-control" name="application_no"
                                placeholder="Search By Application No.">
                        </div>
                        <div class="col-md-4 col-sm-4 mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Search By Name">
                        </div>
                    </div>
                    <div class="row">
                        @php
                            $districtsByState = config('districts');
                        @endphp
                        <div class="col-md-3 col-sm-6 form-group mb-3">
                            {{-- <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label> --}}
                            <select class="form-control @error('state') is-invalid @enderror" name="state"
                                id="stateSelect">
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
                        <div class="col-md-3 col-sm-6 form-group mb-3">
                            <select class="form-control @error('district') is-invalid @enderror" name="district"
                                id="districtSelect">
                                <option value="">Select District</option>
                            </select>
                            @error('district')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3 col-sm-6 form-group mb-3">
                            <input type="text" name="block" id="block"
                                class="form-control @error('block') is-invalid @enderror" value="{{ old('block') }}"
                                placeholder="Search by Block">
                            @error('block')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3 col-sm-6 form-group mb-3">
                            <input type="text" name="village" id="village"
                                class="form-control @error('village') is-invalid @enderror" value="{{ old('village') }}"
                                placeholder="Search by village">
                            @error('village')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary me-1">Search</button>
                            <a href="{{ route('beneficiarie-facilities') }}" class="btn btn-info text-white me-1">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            {{-- Add this button in card header --}}
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Survey List</h5>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#bulkFacilitiesModal">
                        <i class="fa fa-plus"></i> Add Facilities to Multiple Surveys
                    </button>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>
                                    <input type="checkbox" id="selectAll" class="form-check-input">
                                </th>
                                <th>Sr. No.</th>
                                <th>Registration No.</th>
                                <th>Name</th>
                                <th>Father/Husband Name</th>
                                <th>Address</th>
                                <th>Identity No.</th>
                                <th>Identity Type</th>
                                <th>Mobile No.</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Religion</th>
                                <th>Age</th>
                                <th>Survey Date</th>
                                <th>Survey Details</th>
                                <th>Survey Officer</th>
                                <th>Beneficiarie Eligibility category</th>
                                <th>Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php $srNo = 1; @endphp
                        <tbody>
                            @foreach ($surveys as $survey)
                                @php $item = $survey->beneficiarie; @endphp
                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input survey-checkbox"
                                            value="{{ $survey->id }}" data-beneficiarie-id="{{ $item->id }}">
                                    </td>
                                    <td>{{ $srNo++ }}</td>
                                    <td>{{ $item->registration_no ?? 'No Found' }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->gurdian_name }}</td>
                                    <td>{{ $item->village }}, {{ $item->post }}, {{ $item->block }},
                                        {{ $item->district }}, {{ $item->state }} - {{ $item->pincode }},
                                        ({{ $item->area_type }})
                                    </td>
                                    <td>{{ $item->identity_no }}</td>
                                    <td>{{ $item->identity_type }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->caste }}</td>
                                    <td>{{ $item->religion_category }}</td>
                                    <td>{{ $item->religion }}</td>
                                    <td>{{ $item->dob ? \Carbon\Carbon::parse($item->dob)->age . ' years' : 'Not Found' }}
                                    </td>
                                    <td>{{ $survey->survey_date ? \Carbon\Carbon::parse($survey->survey_date)->format('d-m-Y') : 'Not Found' }}
                                    </td>
                                    <td>{{ $survey->survey_details }}</td>
                                    <td>{{ $survey->survey_officer }}</td>
                                    <td>{{ $survey->bene_category ?? 'No Found' }}</td>
                                    <td>{{ $item->academic_session }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ route('add-beneficiarie-facilities', [$item->id, $survey->id]) }}"
                                                class="btn btn-primary btn-sm px-3">+ Facilities</a>

                                            <a href="{{ route('show-beneficiarie-survey', [$item->id, $survey->id]) }}"
                                                class="btn btn-success btn-sm px-3"><i class="fa-regular fa-eye"></i>
                                                Survey</a>

                                            <a href="{{ route('delete-survey', [$item->id, $survey->id]) }}"
                                                class="btn btn-danger btn-sm px-3"
                                                onclick="return confirm('Are you sure want to delete survey?')">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Modal for Bulk Facilities --}}
            <div class="modal fade" id="bulkFacilitiesModal" tabindex="-1" aria-labelledby="bulkFacilitiesModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="bulkFacilitiesModalLabel">Add Facilities to Multiple Surveys</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('store-bulk-beneficiarie-facilities') }}" method="POST"
                            id="bulkFacilitiesForm">
                            @csrf
                            <div class="modal-body">
                                {{-- Selected Surveys Display --}}
                                <div class="alert alert-info" id="selectedSurveysAlert">
                                    <strong>Selected Surveys:</strong> <span id="selectedCount">0</span>
                                </div>

                                {{-- Hidden input for survey IDs --}}
                                <input type="hidden" name="survey_ids" id="surveyIdsInput">

                                {{-- Session Selection --}}
                                <div class="mb-3">
                                    <label for="session" class="form-label fw-bold">
                                        Session <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control @error('session') is-invalid @enderror" name="session"
                                        required>
                                        <option value="">Select Session</option>
                                        @foreach ($data as $sess)
                                            <option value="{{ $sess->session_date }}">{{ $sess->session_date }}</option>
                                        @endforeach
                                    </select>
                                    @error('session')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Facilities Category --}}
                                <div class="mb-3">
                                    <label for="bulk_facilities_category" class="form-label fw-bold">
                                        Facilities Category <span class="text-danger">*</span>
                                    </label>
                                    <select name="facilities_category" id="bulk_facilities_category"
                                        class="form-select @error('facilities_category') is-invalid @enderror" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach ($category as $item)
                                            <option value="{{ $item->category }}">{{ $item->category }}</option>
                                        @endforeach
                                    </select>
                                    @error('facilities_category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Facilities Details --}}
                                <div class="mb-3">
                                    <label for="bulk_facilities" class="form-label fw-bold">
                                        Facilities <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control @error('facilities') is-invalid @enderror" id="bulk_facilities" name="facilities"
                                        rows="4" placeholder="Enter facility details..." required></textarea>
                                    @error('facilities')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success" id="submitBulkBtn" disabled>
                                    <i class="fa fa-save"></i> Add Facilities
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const surveyCheckboxes = document.querySelectorAll('.survey-checkbox');
            const selectedCountSpan = document.getElementById('selectedCount');
            const surveyIdsInput = document.getElementById('surveyIdsInput');
            const submitBtn = document.getElementById('submitBulkBtn');
            const bulkModal = document.getElementById('bulkFacilitiesModal');

            // Select All functionality
            selectAllCheckbox.addEventListener('change', function() {
                surveyCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateSelectedCount();
            });

            // Individual checkbox change
            surveyCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectAllState();
                    updateSelectedCount();
                });
            });

            // Update select all state
            function updateSelectAllState() {
                const allChecked = Array.from(surveyCheckboxes).every(cb => cb.checked);
                const anyChecked = Array.from(surveyCheckboxes).some(cb => cb.checked);
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = anyChecked && !allChecked;
            }

            // Update selected count and submit button state
            function updateSelectedCount() {
                const selectedCheckboxes = document.querySelectorAll('.survey-checkbox:checked');
                const count = selectedCheckboxes.length;
                selectedCountSpan.textContent = count;

                // Enable/disable submit button
                submitBtn.disabled = count === 0;

                // Update hidden input with survey IDs
                const surveyIds = Array.from(selectedCheckboxes).map(cb => cb.value);
                surveyIdsInput.value = JSON.stringify(surveyIds);
            }

            // Update count when modal is opened
            bulkModal.addEventListener('show.bs.modal', function() {
                updateSelectedCount();
                if (document.querySelectorAll('.survey-checkbox:checked').length === 0) {
                    alert('Please select at least one survey first!');
                    return false;
                }
            });

            // Reset form when modal is closed
            bulkModal.addEventListener('hidden.bs.modal', function() {
                document.getElementById('bulkFacilitiesForm').reset();
            });
        });
    </script>

    <style>
        .survey-checkbox,
        #selectAll {
            cursor: pointer;
            width: 18px;
            height: 18px;
        }

        .modal-header {
            border-bottom: 2px solid #0d6efd;
        }

        #selectedSurveysAlert {
            border-left: 4px solid #0dcaf0;
        }
    </style>
@endsection
