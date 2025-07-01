@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Pending Registraition List</h5>

                <!-- Breadcrumb aligned to right -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pending List</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <form method="GET" action="{{ route('pending-registration') }}" class="row g-3 mb-4">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <select name="session_filter" id="session_filter" class="form-control"
                                >
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
                            <a href="{{ route('pending-registration') }}" class="btn btn-info text-white me-1">Reset</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('registration') }}" class="btn btn-success btn-sm">+ New Registraition</a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Application Date</th>
                                <th>Application No.</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Father/Husband Name</th>
                                <th>Address</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Religion</th>
                                <th>Mobile No.</th>
                                <th>Registration Type</th>
                                <th>Status</th>
                                <th>Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($combined as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td> <!-- Sr. No. -->
                                    <td>{{ \Carbon\Carbon::parse($item->application_date)->format('d-m-Y') }}</td>
                                    <td>{{ $item->application_no }}</td>
                                    <td>
                                        <img id="previewImage"
                                            src="{{ asset(($item instanceof \App\Models\beneficiarie ? 'beneficiaries_images/' : 'member_images/') . $item->image) }}"
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
                                    <td>Pending</td>
                                    <td>{{ $item->academic_session }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ route('edit-reg', ['id' => $item->id, 'type' => $item->reg_type ?? 'Member']) }}"
                                                class="btn btn-primary btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="Edit" style="min-width: 38px; height: 38px;">
                                                Approve
                                            </a>

                                            <a href="{{ route('view-reg', ['id' => $item->id, 'type' => $item->reg_type ?? 'Member']) }}"
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
