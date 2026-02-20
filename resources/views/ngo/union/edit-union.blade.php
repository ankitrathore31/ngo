@extends('ngo.layout.master')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Edit Union</h5>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item">
                        <a href="{{ route('union.list') }}">Union List</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Union</li>
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
                <form action="{{ route('update.union', $union->id) }}" method="POST" enctype="multipart/form-data"
                    class="m-3">

                    @csrf
                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Union ID</label>
                            <input type="text" class="form-control" name="union_no" value="{{ $union->union_no }}"
                                readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Union Session <span class="text-danger">*</span>
                            </label>
                            <select class="form-control @error('academic_session') is-invalid @enderror"
                                name="academic_session" required>

                                <option value="">Select Session</option>

                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ old('academic_session', $union->academic_session) == $session->session_date ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>

                            @error('academic_session')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Date of Formation</label>
                            <input type="date" name="formation_date"
                                class="form-control @error('formation_date') is-invalid @enderror"
                                value="{{ old('formation_date', $union->formation_date) }}" required>
                            @error('formation_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Union Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name', $union->name) }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Member Certificate Format <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control @error('union_certificate_format') is-invalid @enderror"
                                name="union_certificate_format"
                                value="{{ old('union_certificate_format', $union->union_certificate_format) }}" readonly>
                            @error('union_certificate_format')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Area Type <span class="text-danger">*</span>
                            </label>
                            <select name="area_type" class="form-control @error('area_type') is-invalid @enderror" required>

                                <option value="">Select Area</option>

                                <option value="Rural"
                                    {{ old('area_type', $union->area_type) == 'Rural' ? 'selected' : '' }}>
                                    Rural
                                </option>

                                <option value="Urban"
                                    {{ old('area_type', $union->area_type) == 'Urban' ? 'selected' : '' }}>
                                    Urban
                                </option>
                            </select>

                            @error('area_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Union Address</label>
                            <input type="text" name="address" class="form-control"
                                value="{{ old('address', $union->address) }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Block</label>
                            <input type="text" name="block" class="form-control"
                                value="{{ old('block', $union->block) }}" required>
                        </div>

                        @php
                            $districtsByState = config('districts');
                        @endphp

                        <div class="col-md-6 mb-3">
                            <label>State <span class="text-danger">*</span></label>
                            <select class="form-control" name="state" id="stateSelect" required>
                                <option value="">Select State</option>

                                @foreach ($districtsByState as $state => $districts)
                                    <option value="{{ $state }}"
                                        {{ old('state', $union->state) == $state ? 'selected' : '' }}>
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
                            Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        const allDistricts = @json($districtsByState);
        const oldDistrict = "{{ old('district', $union->district) }}";
        const oldState = "{{ old('state', $union->state) }}";

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
