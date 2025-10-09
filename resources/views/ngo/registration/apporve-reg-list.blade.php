@extends('ngo.layout.master')
@Section('content')
    <style>
        .hover-card {
            transition: all 0.3s ease-in-out;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            background-color: #f9fafb;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
    <div class="wrapper">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Approve Registraition List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Approve List</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <form method="GET" action="{{ route('approve-registration') }}" class="row g-3 mb-4">
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
                        <div class="col-md-4 col-sm-4 mb-3">
                            <input type="number" class="form-control" name="application_no"
                                placeholder="Search By Application No.">
                        </div>
                        <div class="col-md-4 col-sm-4 mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Search By Name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="form-group">
                                {{-- <label for="reg_type" class="form-label">Registraition Type <span
                                        class="text-danger">*</span></label> --}}
                                <select class="form-control" id="reg_type" name="reg_type">
                                    <option selected disabled>Select Registration Type</option>
                                    <option value="Beneficiaries"
                                        {{ old('reg_type') == 'Beneficiaries' ? 'selected' : '' }}>
                                        Beneficiaries
                                    </option>
                                    <option value="Member" {{ old('reg_type') == 'Member' ? 'selected' : '' }}>Member
                                    </option>
                                </select>
                                @error('reg_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
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
                            {{-- <label for="districtSelect" class="form-label">District: <span
                                    class="text-danger">*</span></label> --}}
                            <select class="form-control @error('district') is-invalid @enderror" name="district"
                                id="districtSelect">
                                <option value="">Select District</option>
                            </select>
                            @error('district')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-3 col-sm-6 form-group mb-3">
                            {{-- <label for="block" class="form-label">Block: <span class="text-danger">*</span></label> --}}
                            <input type="text" name="block" id="block"
                                class="form-control @error('block') is-invalid @enderror" value="{{ old('block') }}"
                                placeholder="Search by Block">
                            @error('block')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary me-1">Search</button>
                            <a href="{{ route('approve-registration') }}" class="btn btn-info text-white me-1">Reset</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body">

                    <!-- Totals Section -->
                    <div class="row text-center mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="p-4 rounded-4 shadow-sm bg-white hover-card">
                                <i class="fa-solid fa-users fa-2x text-primary mb-2"></i>
                                <h6 class="fw-bold text-primary mb-1">Total Registrations</h6>
                                <p class="fs-4 fw-semibold text-dark mb-0">{{ totalStats()['total'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-4 rounded-4 shadow-sm bg-white hover-card">
                                <i class="fa-solid fa-user-shield fa-2x text-success mb-2"></i>
                                <h6 class="fw-bold text-success mb-1">Total Beneficiaries</h6>
                                <p class="fs-4 fw-semibold text-dark mb-0">{{ totalStats()['ben'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="p-4 rounded-4 shadow-sm bg-white hover-card">
                                <i class="fa-solid fa-user-group fa-2x text-warning mb-2"></i>
                                <h6 class="fw-bold text-warning mb-1">Total Members</h6>
                                <p class="fs-4 fw-semibold text-dark mb-0">{{ totalStats()['mem'] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Religion-Wise Section -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="stat-card rounded-4 p-3 shadow-sm bg-light">
                                <h5 class="fw-bold text-primary mb-3"><i
                                        class="fa-solid fa-hands-praying me-2"></i>Religion-wise Beneficiaries</h5>
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Religion</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (totalStats()['benReligion'] as $religion => $count)
                                            <tr>
                                                <td>{{ $religion }}</td>
                                                <td>{{ $count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="stat-card rounded-4 p-3 shadow-sm bg-light">
                                <h5 class="fw-bold text-success mb-3"><i
                                        class="fa-solid fa-hand-holding-heart me-2"></i>Religion-wise Members</h5>
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Religion</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (totalStats()['memReligion'] as $religion => $count)
                                            <tr>
                                                <td>{{ $religion }}</td>
                                                <td>{{ $count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- 🆕 Caste Category-Wise Section -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="stat-card rounded-4 p-3 shadow-sm bg-light">
                                <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-layer-group me-2"></i>Caste
                                    Category-wise Beneficiaries</h5>
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Category</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (totalStats()['benCategory'] as $category => $count)
                                            <tr>
                                                <td>{{ $category }}</td>
                                                <td>{{ $count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="stat-card rounded-4 p-3 shadow-sm bg-light">
                                <h5 class="fw-bold text-success mb-3"><i class="fa-solid fa-sitemap me-2"></i>Caste
                                    Category-wise Members</h5>
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Category</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (totalStats()['memCategory'] as $category => $count)
                                            <tr>
                                                <td>{{ $category }}</td>
                                                <td>{{ $count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Caste-Wise Section -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="stat-card rounded-4 p-3 shadow-sm bg-light">
                                <h5 class="fw-bold text-primary mb-3"><i
                                        class="fa-solid fa-people-group me-2"></i>Caste-wise Beneficiaries</h5>
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Caste</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (totalStats()['benCaste'] as $caste => $count)
                                            <tr>
                                                <td>{{ $caste ?: 'Not Specified' }}</td>
                                                <td>{{ $count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="stat-card rounded-4 p-3 shadow-sm bg-light">
                                <h5 class="fw-bold text-success mb-3"><i
                                        class="fa-solid fa-users-line me-2"></i>Caste-wise Members</h5>
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Caste</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (totalStats()['memCaste'] as $caste => $count)
                                            <tr>
                                                <td>{{ $caste ?: 'Not Specified' }}</td>
                                                <td>{{ $count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Application Date</th>
                                <td>Application No.</td>
                                <th>Registration Date.</th>
                                <th>Registration No.</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Father/Husband Name</th>
                                <th>Address</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Religion</th>
                                <th>Mobile No.</th>
                                <th>Registration Type</th>
                                <th>Session</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($combined as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->application_date)->format('d-m-Y') }}</td>
                                    <td>{{ $item->application_no }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->registration_date)->format('d-m-Y') }}</td>
                                    <td>{{ $item->registration_no }}</td>
                                    <td>
                                        <img id="previewImage"
                                            src="{{ asset(($item instanceof \App\Models\beneficiarie ? 'benefries_images/' : 'member_images/') . $item->image) }}"
                                            alt="Preview" width="100">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->gurdian_name }}</td>
                                    <td>{{ $item->village }},
                                        {{ $item->post }},
                                        {{ $item->block }},
                                        {{ $item->district }},
                                        {{ $item->state }} - {{ $item->pincode }},({{ $item->area_type }})</td>
                                    <td>{{ $item->caste }}</td>
                                    <td>{{ $item->religion_category }}</td>
                                    <td>{{ $item->religion }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->reg_type ?? 'Member' }}</td>

                                    <td>{{ $item->academic_session }}</td>
                                    <td>Apporve</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ route('edit-apporve-reg', ['id' => $item->id, 'type' => $item->reg_type]) }}"
                                                class="btn btn-info btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="Edit" style="min-width: 38px; height: 38px;">
                                                Decline
                                            </a>

                                            <a href="{{ route('show-apporve-reg', ['id' => $item->id, 'type' => $item->reg_type]) }}"
                                                class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="View" style="min-width: 38px; height: 38px;">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>

                                            <a href="{{ route('delete-view', ['id' => $item->id, 'type' => $item->reg_type ?? 'Member']) }}"
                                                class="btn btn-danger btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="Delete" style="min-width: 38px; height: 38px;">
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
@endsection
