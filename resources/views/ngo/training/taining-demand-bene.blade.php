@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Training Demand Beneficiarie List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Training Demand</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <form method="GET" action="{{ route('taining-demand-bene') }}" class="row g-3 mb-4">
                    <div class="col-md-3 col-sm-4">
                        <select name="session_filter" id="session_filter" class="form-control">
                            <option value="">All Sessions</option>
                            @foreach ($allSessions as $session)
                                <option value="{{ $session->session_date }}"
                                    {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                    {{ $session->session_date }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-4 mb-3">
                        <input type="number" class="form-control" name="application_no"
                            placeholder="Search By Application No.">
                    </div>
                    <div class="col-md-3 col-sm-4 mb-3">
                        <input type="text" class="form-control" name="name" placeholder="Search By Name">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary me-1">Search</button>
                        <a href="{{ route('taining-demand-bene') }}" class="btn btn-info text-white me-1">Reset</a>
                    </div>
                </form>

            </div>
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <td>Application No.</td>
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
                                <th>Status</th>
                                <th>Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($record as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->application_no }}</td>
                                    <td>{{ $item->registration_no }}</td>
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
                                    <td>{{ $item->academic_session }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm px-3 demand-btn"
                                                data-bs-toggle="modal" data-bs-target="#Modal"
                                                data-id="{{ $item->id }}" data-name="{{ $item->name }}"
                                                data-gurdian="{{ $item->gurdian_name }}"
                                                data-address="{{ $item->village }}, 
                                                {{ $item->post }}, {{ $item->town }}, {{ $item->district }}, 
                                                 {{ $item->state }}">
                                                Demand Beneficiarie In Training Center
                                            </a>
                                            <a href="{{ route('view-beneficiarie', $item->id) }}"
                                                class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="View" style="min-width: 38px; height: 38px;">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="positionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="positionModalLabel">Add Beneficiary In Center</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <h6 class="modal-title" id="positionModalLabel">
                            &nbsp; &nbsp; Name: <span id="beneName"></span> &nbsp;&nbsp; Father/Husband Name: <span
                                id="guardianName"></span>
                            <br>
                            &nbsp;&nbsp; Address: <span id="addressBene"></span>
                        </h6>
                        <form action="{{ route('store-demand') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <input type="text" name="beneficiarie_id" value="{{ $item->id }}" hidden>
                                <div class="mb-3">
                                    <label class="form-label">Center Name</label>
                                    <input type="text" class="form-control" id="searchInout" name="training_center"
                                        placeholder="Search Name & Code">
                                </div>

                                <!-- Suggestions dropdown -->
                                <ul id="centerList" class="list-group position-absolute z-3"
                                    style="width: 100%; display: none;"></ul>

                                <!-- Readonly fields for selected center -->
                                <div class="mb-3 mt-2">
                                    <label class="form-label">Center Code</label>
                                    <input type="text" class="form-control" name="center_code" id="center_code" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Center Address</label>
                                    <input type="text" class="form-control" name="center_address" id="center_address"
                                        readonly>
                                </div>

                                <div class="mb-3 form-group">
                                    <label for="session" class="form-label">Training Beneficiarie Session <span
                                            class="text-danger">*</span></label>
                                    <select name="session" class="form-control" id="session">
                                        <option value="">Select Session</option>
                                        @foreach ($allSessions as $s)
                                            <option value="{{ $s->session_date }}"
                                                {{ old('session') == $s->session_date ? 'selected' : '' }}>
                                                {{ $s->session_date }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('session')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="facilities_category" class="form-label">
                                        Facilities Category<span class="text-danger">*</span>
                                    </label>
                                    <select name="facilities_category" id="facilities_category"
                                        class="form-control @error('facilities_category') is-invalid @enderror" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach ($category as $item)
                                            <option value="{{ $item->category }}"
                                                {{ old('facilities_category') == $item->category ? 'selected' : '' }}>
                                                {{ $item->category }}</option>
                                        @endforeach
                                    </select>
                                    @error('facilities_category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="training_course" class="form-label">Training Course</label>
                                    <select name="training_course" id="training_course" class="form-control">
                                        <option value="">Select Course</option>
                                        @foreach ($course as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('training_course', $center->id ?? '') == $item->id ? 'selected' : '' }}>
                                                {{ $item->course }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Training Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date">
                                </div>

                                <!-- End Date -->
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">Training End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date">
                                </div>

                                <!-- Duration Type -->
                                <div class="mb-3">
                                    <label for="duration_type" class="form-label">Select Duration Type</label>
                                    <select class="form-select form-control" id="duration_type">
                                        <option value="">-- Select --</option>
                                        <option value="days">Days</option>
                                        <option value="months">Months</option>
                                        <option value="years">Years</option>
                                    </select>
                                </div>

                                <!-- Duration Result (readonly) -->
                                <div class="mb-3">
                                    <label class="form-label">Training Duration</label>
                                    <input type="text" class="form-control" name="duration" id="duration_result"
                                        readonly>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Beneficiary</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const durationTypeSelect = document.getElementById('duration_type');
        const durationResultInput = document.getElementById('duration_result');

        function calculateDuration() {
            const startVal = startDateInput.value;
            const endVal = endDateInput.value;
            const type = durationTypeSelect.value;

            if (!startVal || !endVal || !type) {
                durationResultInput.value = '';
                return;
            }

            const start = new Date(startVal);
            const end = new Date(endVal);

            if (end < start) {
                durationResultInput.value = 'Invalid date range';
                return;
            }

            const msInDay = 1000 * 60 * 60 * 24;
            const totalDays = Math.round((end - start) / msInDay);

            // Clone dates to avoid mutation
            let s = new Date(start.getTime());
            let e = new Date(end.getTime());

            let years = e.getFullYear() - s.getFullYear();
            let months = e.getMonth() - s.getMonth();
            let days = e.getDate() - s.getDate();

            if (days < 0) {
                months--;
                const tempDate = new Date(e.getFullYear(), e.getMonth(), 0); // last day of previous month
                days += tempDate.getDate();
            }

            if (months < 0) {
                years--;
                months += 12;
            }

            let result = '';

            if (type === 'days') {
                result = `${totalDays} day${totalDays !== 1 ? 's' : ''}`;
            } else if (type === 'months') {
                const totalMonths = (years * 12) + months;
                result += totalMonths ? `${totalMonths} month${totalMonths !== 1 ? 's' : ''} ` : '';
                result += days ? `${days} day${days !== 1 ? 's' : ''}` : '';
                result = result.trim() || '0 months';
            } else if (type === 'years') {
                result += years ? `${years} year${years !== 1 ? 's' : ''} ` : '';
                result += months ? `${months} month${months !== 1 ? 's' : ''} ` : '';
                result += days ? `${days} day${days !== 1 ? 's' : ''}` : '';
                result = result.trim() || '0 years';
            }

            durationResultInput.value = result;
        }

        startDateInput.addEventListener('change', calculateDuration);
        endDateInput.addEventListener('change', calculateDuration);
        durationTypeSelect.addEventListener('change', calculateDuration);
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInout');
            const centerList = document.getElementById('centerList');
            const centerCodeInput = document.getElementById('center_code');
            const centerAddressInput = document.getElementById('center_address');

            let centers = @json($centers); // Laravel Blade injects PHP variable into JS

            // Search and display dropdown
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                centerList.innerHTML = '';

                if (query.trim() === '') {
                    centerList.style.display = 'none';
                    return;
                }

                let filtered = centers.filter(center =>
                    center.center_name.toLowerCase().includes(query) ||
                    center.center_code.toLowerCase().includes(query)
                );

                if (filtered.length === 0) {
                    centerList.innerHTML = '<li class="list-group-item disabled">No centers found</li>';
                } else {
                    filtered.forEach(center => {
                        let li = document.createElement('li');
                        li.classList.add('list-group-item', 'list-group-item-action');
                        li.textContent = `${center.center_name} (${center.center_code})`;
                        li.dataset.name = center.center_name;
                        li.dataset.code = center.center_code;
                        li.dataset.address = center.center_address;
                        centerList.appendChild(li);
                    });
                }

                centerList.style.display = 'block';
            });

            // On click of a suggestion
            centerList.addEventListener('click', function(e) {
                if (e.target && e.target.matches('li.list-group-item')) {
                    const selected = e.target;
                    searchInput.value = selected.dataset.name;
                    centerCodeInput.value = selected.dataset.code;
                    centerAddressInput.value = selected.dataset.address;
                    centerList.style.display = 'none';
                }
            });

            // Hide list when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('#searchInout') && !e.target.closest('#centerList')) {
                    centerList.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const demandButtons = document.querySelectorAll('.demand-btn');

            demandButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const name = this.getAttribute('data-name');
                    const guardian = this.getAttribute('data-gurdian');
                    const address = this.getAttribute('data-address');
                    const id = this.getAttribute('data-id');

                    // Set values in modal
                    document.getElementById('beneName').textContent = name;
                    document.getElementById('guardianName').textContent = guardian;
                    document.getElementById('addressBene').textContent = address;
                    document.querySelector('input[name="beneficiarie_id"]').value = id;
                });
            });
        });
    </script>
@endsection
