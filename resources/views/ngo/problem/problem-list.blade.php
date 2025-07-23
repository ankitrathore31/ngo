@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Social Problem List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Social Problem</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <form method="GET" action="{{ route('problem.list') }}" class="row g-3 mb-4">
                    <div class="col-md-3 col-sm-4">
                        <select name="session_filter" id="session_filter" class="form-control"
                            onchange="this.form.submit()">
                            <option value="">All Sessions</option>
                            @foreach ($session as $s)
                                <option value="{{ $s->session_date }}"
                                    {{ request('session_filter') == $s->session_date ? 'selected' : '' }}>
                                    {{ $s->session_date }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <input type="date" name="problem_date" class="form-control" value="{{ request('problem_date') }}"
                            placeholder="Search by Problem Date">
                    </div>

                    <div class="col-md-3">
                        <input type="text" name="problem_no" class="form-control" value="{{ request('problem_no') }}"
                            placeholder="Search by Problem No">
                    </div>

                    @php
                        $districtsByState = config('districts');
                    @endphp
                    <div class="col-md-3 col-sm-6 form-group mb-3">
                        {{-- <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label> --}}
                        <select class="form-control @error('state') is-invalid @enderror" name="state" id="stateSelect">
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

                    <div class="col-md-3">
                        <input type="text" name="blcok" class="form-control" value="{{ request('blcok') }}"
                            placeholder="Search by Block">
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('problem.list') }}" class="btn btn-info text-white">Reset</a>
                    </div>
                </form>
            </div>
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Problem Date</th>
                                <th>Problem No.</th>
                                <th>Discover By</th>
                                <th>Blcok</th>
                                <th>State</th>
                                <th>District</th>
                                <th>Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($records as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->problem_date)->format('d-m-Y') }} </td>
                                    <td>{{ $item->problem_no }}</td>
                                    <td>{{ $item->problem_by }}</td>
                                    <td>{{ $item->block }}</td>
                                    <td>{{ $item->state }}</td>
                                    <td>{{ $item->district }}</td>
                                    <td>{{ $item->academic_session ?? 'N/A' }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{-- route('view-workplan', $item->id) --}}"
                                                class="btn btn-success btn-sm px-3">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            <a href="{{-- route('edit-workplan', $item->id) --}}"
                                                class="btn btn-primary btn-sm" title="Edit">
                                                <i class="fa-regular fa-edit"></i>
                                            </a>
                                            <a href="{{-- route('delete-workplan', $item->id) --}}"
                                                class="btn btn-danger btn-sm "
                                                onclick="return confirm('Do you want to delete WorkPlan')" title="Delete">
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
