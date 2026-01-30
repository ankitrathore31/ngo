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
            <div class="row mb-3 mt-4">
                @php
                    $user = auth()->user();
                    $isStaff = $user && $user->user_type === 'staff';
                @endphp
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-1">

                        @if (!$isStaff || $user->hasPermission('educationfacility_hospital_list'))
                            <a href="{{ route('list.school') }}" class="btn btn-sm btn-primary">
                                School List
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_generate'))
                            <a href="{{ route('eduaction.reg.list') }}" class="btn btn-sm btn-primary">
                                Education Card Generate
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('eduaction.card.list') }}" class="btn btn-sm btn-primary">
                                Education Card List
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('eduaction.demand.list') }}" class="btn btn-sm btn-primary">
                                Demand Education Facility
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('eduaction.demand.pending.list') }}" class="btn btn-sm btn-primary">
                                Demand Pending Facility
                            </a>
                        @endif
                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('education.list.Investigationfacility') }}" class="btn btn-sm btn-primary">
                                Investigation Education Facility
                            </a>
                        @endif
                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('education.list.Investigationfacility') }}" class="btn btn-sm btn-primary">
                                Verify Education Facility
                            </a>
                        @endif
                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('education.list.Approvalfacility') }}" class="btn btn-sm btn-primary">
                                Approval Education Facility
                            </a>
                        @endif
                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('education.list.Approvefacility') }}" class="btn btn-sm btn-primary">
                                Approve Education Facility
                            </a>
                        @endif

                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Registraition List For Education Card</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Education Card</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <form method="GET" action="{{ route('eduaction.reg.list') }}" class="row g-3 mb-4">
                    <div class="row">
                        <div class="col-md-3 col-sm-4">
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
                        <div class="col-md-3 col-sm-4 mb-3">
                            <input type="number" class="form-control" name="application_no"
                                placeholder="Search By Application/Registration No.">
                        </div>
                        <div class="col-md-3 col-sm-4 mb-3">
                            <input type="number" class="form-control" name="registration_no"
                                placeholder="Search By Mobile/Idtinty No.">
                        </div>
                        <div class="col-md-3 col-sm-4 mb-3">
                            <input type="text" class="form-control" name="name"
                                placeholder="Search By Person/Guardian's Name">
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
                            <a href="{{ route('eduaction.reg.list') }}" class="btn btn-info text-white me-1">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            @php
                $isSearchApplied = request()->anyFilled([
                    'session_filter',
                    'application_no',
                    'registration_no',
                    'name',
                    'reg_type',
                    'state',
                    'district',
                    'block',
                ]);
            @endphp

            @if ($isSearchApplied)

                <div class="card shadow-sm">
                    <div class="card-body table-responsive">
                        @if ($combined->count() > 0)
                            <table class="table table-bordered table-hover align-middle text-center">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Application Date</th>
                                        <th>Application No.</th>
                                        <th>Registration Date</th>
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
                                        <th>Education Card</th>
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
                                                <img src="{{ asset(($item instanceof \App\Models\beneficiarie ? 'benefries_images/' : 'member_images/') . $item->image) }}"
                                                    width="80">
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->gurdian_name }}</td>
                                            <td>
                                                {{ $item->village }},
                                                {{ $item->post }},
                                                {{ $item->block }},
                                                {{ $item->district }},
                                                {{ $item->state }} - {{ $item->pincode }}
                                            </td>
                                            <td>{{ $item->caste }}</td>
                                            <td>{{ $item->religion_category }}</td>
                                            <td>{{ $item->religion }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->reg_type ?? 'Member' }}</td>
                                            <td>{{ $item->academic_session }}</td>
                                            <td>
                                                <a href="{{ route('generate.educationcard', ['id' => $item->id, 'type' => $item->reg_type]) }}"
                                                    class="btn btn-success btn-sm">
                                                    Generate Education Card
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-warning text-center mb-0">
                                No records found for the selected search criteria.
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">
                    Please use the search filters above and click <strong>Search</strong> to view records.
                </div>
            @endif

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
