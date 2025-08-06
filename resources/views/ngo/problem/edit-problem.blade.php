@extends('ngo.layout.master')
@Section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Edit Social Problem</h5>

            <!-- Breadcrumb aligned to right -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('ngo') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Social Problem</li>
                </ol>
            </nav>
        </div>
        <div class="card m-1">
            <div class="card-body">
                <form action="{{ route('update.problem', $problem->id) }}" method="POST" enctype="multipart/form-data"
                    class="m-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3 form-group local-from">
                            <label class="form-label">Problem No <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('problem_no') is-invalid @enderror"
                                name="problem_no" placeholder="Problem Name" value="{{ $problem->problem_no }}" readonly required>
                            @error('problem_no')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Problem Date <span class="text-danger">*</span></label>
                            <input type="date" id=""
                                class=" form-control @error('problem_date') is-invalid @enderror" name="problem_date"
                                placeholder="Select Date" value="{{ $problem->problem_date }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="session" class="form-label">Problem Session <span
                                    class="text-danger">*</span></label>
                            <select class="form-control @error('session') is-invalid @enderror" name="session" required>
                                <option value="">Select Session</option>
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ $session->session_date == $problem->academic_session ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="" class="form-label">Problem Address <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    name="address" rows="3" placeholder="Address" value="{{ $problem->address }}"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="blcok" class="form-label">Block Name:</label>
                                <input type="text" id="block" name="block" class="form-control"
                                    value="{{ old('block', $problem->block) }}" required>
                                @error('block')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            @php
                                $districtsByState = config('districts');
                            @endphp
                            <div class="col-md-6 form-group mb-3">
                                <label for="stateSelect" class="form-label">State: <span
                                        class="text-danger">*</span></label>
                                <select class="form-control  @error('state') is-invalid @enderror" name="state"
                                    id="stateSelect" required>
                                    <option value="">Select State</option>
                                    @foreach ($districtsByState as $state => $districts)
                                        <option value="{{ $state }}"
                                            {{ (old('state') ?? $problem->state) == $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="col-md-6 form-group mb-3">
                                <label for="districtSelect" class="form-label">District: <span
                                        class="text-danger">*</span></label>
                                <select class="form-control @error('district') is-invalid @enderror" name="district"
                                    id="districtSelect" required>
                                    <option value="">Select District</option>
                                    @if (!empty($selectedState) && isset($districtsByState[$selectedState]))
                                        @foreach ($districtsByState[$selectedState] as $district)
                                            <option value="{{ $district }}"
                                                {{ $selectedDistrict == $district ? 'selected' : '' }}>
                                                {{ $district }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>

                                @error('district')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Problem Description <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3"
                                    placeholder="Problem Description" required>{{ old('description', $problem->description) }}</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="problem_by" class="form-label ">Problem Discover By <span
                                        class="text-danger">*</span></label>
                                <select class="form-control @error('problem_by') is-invalid @enderror" name="problem_by"
                                    required>
                                    <option value="">Select By</option>
                                    @foreach ($staff as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('problem_by', $problem->problem_by ?? '') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }} ({{ $item->position }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>

                </form>
            </div>
        </div>
    </div>
    <script>
        const allDistricts = @json($districtsByState);

        // Use old values if they exist, otherwise fallback to $beneficiarie
        const oldState = "{{ old('state', $problem->state) }}";
        const oldDistrict = "{{ old('district', $problem->district) }}";

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

        // Initial load
        if (oldState) {
            populateDistricts(oldState);
        }

        // On state change
        document.getElementById('stateSelect').addEventListener('change', function() {
            populateDistricts(this.value);
        });
    </script>
@endsection
