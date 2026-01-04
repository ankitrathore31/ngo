@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Add Survey Beneficiarie List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Beneficiarie List</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <form method="GET" action="{{ route('beneficiarie-add-list') }}" class="row g-3 mb-4">
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
                            <select id="bene_category" name="bene_category" class="form-control" required>
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
                            <a href="{{ route('beneficiarie-add-list') }}" class="btn btn-info text-white me-1">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <button type="button" id="openSurveyModal" class="btn btn-primary" disabled>
                        Add Survey (<span id="selectedBeneficiarieCount">0</span>)
                    </button>

                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>
                                    <input type="checkbox" id="select_all">
                                </th>
                                <th>Sr. No.</th>
                                <td>Application No.</td>
                                <th>Registration No.</th>
                                <th>Registraition Date</th>
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
                                <th>Status</th>
                                <th>Beneficiarie Eligibility category</th>
                                <th>Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($beneficiarie as $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="select_item" value="{{ $item->id }}">
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->application_no }}</td>
                                    <td>{{ $item->registration_no }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->registration_date)->format('d-m-Y') }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->gurdian_name }}</td>
                                    <td>{{ $item->village }},
                                        {{ $item->post }},
                                        {{ $item->block }},
                                        {{ $item->district }},
                                        {{ $item->state }} - {{ $item->pincode }},
                                        ({{ $item->area_type }})
                                    </td>
                                    <td>{{ $item->identity_no }}</td>
                                    <td>{{ $item->identity_type }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->caste }}</td>
                                    <td>{{ $item->religion_category }}</td>
                                    <td>{{ $item->religion }}</td>
                                    <td>
                                        {{ $item->dob ? \Carbon\Carbon::parse($item->dob)->age . ' years' : 'Not Found' }}
                                    </td>
                                    <td>
                                        @if ($item->status == 1)
                                            Approve
                                        @endif
                                    </td>
                                    <td>{{ $survey->bene_category ?? 'No Found' }}</td>
                                    <td>{{ $item->academic_session }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ route('add-beneficiarie', $item->id) }}"
                                                class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="View" style="min-width: 38px; height: auto;">
                                                Add Beneficiarie Survey
                                            </a>
                                            <a href="{{ route('view-beneficiarie', $item->id) }}"
                                                class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="View" style="min-width: 38px; height: 38px;">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            <a href="{{-- route('show-beneficiarie-survey', [$item->id, $survey->id]) --}}"
                                                class="btn btn-primary btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="View Survey" style="min-width: 38px; height: 38px;">
                                                <i class="fa-regular "></i> Survey Send
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal fade" id="bulkSurveyModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                    <div class="modal-content">

                        <form action="{{ route('store-bulk-beneficiarie') }}" method="POST">
                            @csrf

                            <!-- Hidden input for selected beneficiaries -->
                            <input type="hidden" name="beneficiarie_ids" id="beneficiarie_ids">

                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title">
                                    Survey Start Beneficiarie
                                    (<span id="modalSelectedCount">0</span> Selected)
                                </h5>

                                <button type="button" class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">

                                @php
                                    $facilities = [
                                        'Housing',
                                        'Toilet',
                                        'Ration Card',
                                        'Antyodaya Card',
                                        'Eligible Household APL Card',
                                        'Green Card',
                                        'MNREGA Card',
                                        'Shramik Card',
                                        'E-Shram Card',
                                        'Ayushman Card',
                                        'Pension in the family',
                                        'Loan',
                                        'Health Card',
                                        'Education Grant',
                                        'Tree Distribution',
                                        'Cleaning Kit',
                                        'Health Kit',
                                        'Nutrition Kit',
                                        'Ration Kit',
                                        'Festival Kit',
                                        'Awareness Meeting',
                                        'Gas Connection',
                                        'Electricity Connection',
                                        'Water Connection',
                                        'Water Supply',
                                        'Family Dispute',
                                        'Peace Dialogue Meeting',
                                        'Self Help Group',
                                        'Training',
                                        'Employment',
                                        'Cloth Distribution',
                                        'Blanket Distribution',
                                        'Gifts',
                                        'Travelling, Picnic or Tour',
                                        'Fruit Distribution',
                                        'Cultural Programme',
                                        'Animal Food',
                                        'Food',
                                        'Agriculture Grant',
                                        'Economic Help',
                                        'Marriage Grant',
                                        'children studying',
                                        'person seeking pension',
                                        'person getting married',
                                        'facility do you want',
                                        'Occupation of head of the family',
                                    ];
                                @endphp

                                <!-- Start Survey -->
                                <div class="mb-4">
                                    <label class="fw-bold">Do you want to fill the survey?</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="start_survey"
                                            value="Yes" id="start_survey_yes">
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="start_survey"
                                            value="No" id="start_survey_no">
                                        <label class="form-check-label">No</label>
                                    </div>
                                </div>

                                <!-- Facilities -->
                                <div id="survey_section" style="display:none">
                                    <div class="row">
                                        @foreach ($facilities as $index => $facility)
                                            <div class="col-md-6 mb-3">
                                                <label class="fw-bold">
                                                    {{ $index + 1 }}. {{ $facility }}
                                                </label><br>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="surveyfacility_status[{{ $facility }}]" value="Yes"
                                                        id="{{ Str::slug($facility) }}_yes">
                                                    <label class="form-check-label">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="surveyfacility_status[{{ $facility }}]" value="No"
                                                        id="{{ Str::slug($facility) }}_no">
                                                    <label class="form-check-label">No</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <hr>

                                <!-- Survey Details -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        Survey Details <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control" name="survey_details" rows="3" required></textarea>
                                </div>

                                <div class="row">
                                    <!-- Survey Date -->
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            Survey Date <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" name="survey_date" class="form-control" required>
                                    </div>

                                    <!-- Category -->
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            Beneficiarie Eligibility Category
                                        </label>
                                        <select name="bene_category" class="form-control" required>
                                            <option value="">-- Select Category --</option>
                                            <option value="Homeless Families">1. Homeless Families</option>
                                            <option value="People living in kutcha or one-room houses">2. People living in
                                                kutcha or
                                                one-room houses</option>
                                            <option value="Widows">3. Widows</option>
                                            <option value="Elderly Women">4. Elderly Women</option>
                                            <option value="Persons with Disabilities">5. Persons with Disabilities</option>
                                            <option value="Landless">6. Landless</option>
                                            <option value="Economically Weaker Section">7. Economically Weaker Section
                                            </option>
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

                                    <!-- Survey Officer -->
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">
                                            Survey Officer
                                        </label>
                                        <select name="survey_officer" class="form-control" required>
                                            <option value="">Select Survey Officer</option>
                                            @foreach ($staff as $person)
                                                <option
                                                    value="{{ $person->name }} ({{ $person->staff_code }}) ({{ $person->position }})">
                                                    {{ $person->name }} ({{ $person->staff_code }})
                                                    ({{ $person->position }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">
                                    Add Beneficiarie Survey
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Cancel
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
document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       SURVEY YES / NO TOGGLE
    ====================================================== */
    const yesRadio = document.getElementById('start_survey_yes');
    const noRadio = document.getElementById('start_survey_no');
    const surveySection = document.getElementById('survey_section');

    if (yesRadio && noRadio && surveySection) {
        const toggleSurvey = () => {
            surveySection.style.display = yesRadio.checked ? 'block' : 'none';
        };
        yesRadio.addEventListener('change', toggleSurvey);
        noRadio.addEventListener('change', toggleSurvey);
    }

    /* =====================================================
       BULK SELECTION LOGIC
    ====================================================== */
    const selectAll = document.getElementById('select_all');
    const items = document.querySelectorAll('.select_item');
    const openModalBtn = document.getElementById('openSurveyModal');
    const tableCount = document.getElementById('selectedBeneficiarieCount');
    const modalCount = document.getElementById('modalSelectedCount');
    const hiddenIds = document.getElementById('beneficiarie_ids');

    if (!selectAll || !openModalBtn || !tableCount || !hiddenIds) {
        console.error('Bulk survey elements missing from DOM.');
        return;
    }

    function updateSelectionState() {
        const selectedItems = Array.from(items).filter(cb => cb.checked);
        const count = selectedItems.length;

        // Update counts
        tableCount.textContent = count;
        if (modalCount) modalCount.textContent = count;

        // Enable / disable button
        openModalBtn.disabled = count === 0;

        // Update hidden input
        hiddenIds.value = selectedItems.map(cb => cb.value).join(',');

        // Select-all checkbox state
        if (items.length > 0) {
            selectAll.checked = count === items.length;
            selectAll.indeterminate = count > 0 && count < items.length;
        }
    }

    /* Select-all click */
    selectAll.addEventListener('change', function () {
        items.forEach(cb => cb.checked = this.checked);
        updateSelectionState();
    });

    /* Individual checkbox click */
    items.forEach(cb => {
        cb.addEventListener('change', updateSelectionState);
    });

    /* =====================================================
       OPEN MODAL BUTTON
    ====================================================== */
    openModalBtn.addEventListener('click', function () {

        if (hiddenIds.value.trim() === '') {
            alert('Please select at least one beneficiary.');
            return;
        }

        // Ensure modal count is correct at open time
        if (modalCount) {
            modalCount.textContent = tableCount.textContent;
        }

        const modalEl = document.getElementById('bulkSurveyModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    });

});
</script>

@endsection
