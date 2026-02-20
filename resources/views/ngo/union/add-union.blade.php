@extends('ngo.layout.master')
@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Add Union</h5>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item">
                        <a href="{{ route('list.organization') }}">Union List</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Union</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="card m-1">
            <div class="card-body">
                <form action="{{ route('store.union') }}" method="POST" enctype="multipart/form-data" class="m-3">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Union ID</label>
                            <input type="text" class="form-control" name="union_no" value="{{ $nextUnionNo }}" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="academic_session" class="form-label">
                                Union Session <span class="text-danger">*</span>
                            </label>
                            <select class="form-control @error('academic_session') is-invalid @enderror"
                                name="academic_session" required>
                                <option value="">Select Session</option>
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}">
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="formation_date">Date of Formation:</label>
                            <input type="date" id="formation_date" name="formation_date" class="form-control"
                                value="{{ old('formation_date') }}" required>
                            @error('formation_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Union Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                placeholder="Enter Union Name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- NEW FIELD --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Member Certificate Format <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('union_certificate_format') is-invalid @enderror"
                                name="union_certificate_format" placeholder="Enter Certificate Format"
                                value="{{ old('union_certificate_format') }}" required>
                            @error('union_certificate_format')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Area Type <span class="text-danger">*</span>
                            </label>
                            <select name="area_type" class="form-control @error('area_type') is-invalid @enderror" required>
                                <option value="" disabled selected>Select Area</option>
                                <option value="Rural" {{ old('area_type') == 'Rural' ? 'selected' : '' }}>
                                    Rural
                                </option>
                                <option value="Urban" {{ old('area_type') == 'Urban' ? 'selected' : '' }}>
                                    Urban
                                </option>
                            </select>
                            @error('area_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Union Address:</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address') }}"
                                placeholder="Enter Union Address" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Block:</label>
                            <input type="text" name="block" class="form-control" value="{{ old('block') }}"
                                placeholder="Enter Block" required>
                        </div>

                        @php
                            $districtsByState = config('districts');
                        @endphp

                        <div class="col-md-6 mb-3">
                            <label>State <span class="text-danger">*</span></label>
                            <select class="form-control" name="state" id="stateSelect" required>
                                <option value="">Select State</option>
                                @foreach ($districtsByState as $state => $districts)
                                    <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>
                                        {{ $state }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>District <span class="text-danger">*</span></label>
                            <select class="form-control" name="district" id="districtSelect" required>
                                <option value="">Select District</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </form>
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

        if (oldState) {
            populateDistricts(oldState);
        }

        document.getElementById('stateSelect')
            .addEventListener('change', function() {
                populateDistricts(this.value);
            });
    </script>
@endsection
