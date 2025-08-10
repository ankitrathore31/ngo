@extends('ngo.layout.master')
@Section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-address mb-3">
            <h5 class="mb-0">Add Organization Group</h5>
            <!-- Breadcrumb aligned to right -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('list.organization') }}">Organization List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Organization</li>
                </ol>
            </nav>
        </div>
        <div class="card m-1">
            <div class="card-body">
                <form action="{{ route('store.organization') }}" method="POST" enctype="multipart/form-data"
                    class="m-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Organization</label>
                            <select name="headorg_id" id="headorg_id"
                                class="form-control @error('org_id') is-invalid @enderror">
                                <option value="">select organization</option>
                                @foreach ($headorg as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('headorg_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Group ID.</label>
                            <input type="text" class="form-control" value="{{ $nextOrganizationNo }}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="academic_session" class="form-label ">Group Session <span
                                    class="text-danger">*</span></label>
                            <select class="form-control @error('academic_session') is-invalid @enderror"
                                name="academic_session" required>
                                <option value="">Select Session</option>
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}">{{ $session->session_date }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="formation_date">Date of formation:</label>
                            <input type="date" id="formation_date" name="formation_date" class="form-control"
                                value="{{ old('formation_date') }}" required>
                            @error('formation_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3 form-group local-from">
                            <label class="form-label">Group name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                placeholder="Enter Organization Name" required>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="area_type" class="form-label">Area Type: <span class="text-danger">*</span></label>
                            <select name="area_type" class="form-control" id="area_type" required>
                                <option value="" selected disabled>Select Area</option>
                                <option value="Rular" {{ old('area_type') == 'Rular' ? 'selected' : '' }}>
                                    Rular
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
                            <label for="address">Group Address:</label>
                            <input type="text" id="address" name="address" class="form-control"
                                value="{{ old('address') }}" placeholder="Enter Organization Address" required>
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address">Block:</label>
                            <input type="text" id="block" name="block" class="form-control"
                                value="{{ old('block') }}" placeholder="Enter Organization Block" required>
                            @error('block')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        @php
                            $districtsByState = config('districts');
                        @endphp
                        <div class="col-md-6 form-group mb-3">
                            <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label>
                            <select class="form-control @error('state') is-invalid @enderror" name="state"
                                id="stateSelect" required>
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

                        <div class="col-md-6 form-group mb-3">
                            <label for="districtSelect" class="form-label">District: <span
                                    class="text-danger">*</span></label>
                            <select class="form-control @error('district') is-invalid @enderror" name="district"
                                id="districtSelect" required>
                                <option value="">Select District</option>
                            </select>
                            @error('district')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group text-address">
                        <button type="submit" class="btn btn-primary">Submit</button>
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
