@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">working Area</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Working Area</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="container mt-5">
                <div class="card shadow p-5 bg-light m-3">
                    <form action="{{ route('store-area') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="area_type" class="form-label">Working Area Type <span
                                        class="text-danger">*</span></label>
                                <select name="area_type" id="area_type" class="form-control" required
                                    onchange="toggleAreaField()">
                                    <option value="">Select Area Type</option>
                                    <option value="Country" {{ old('area_type') == 'Country' ? 'selected' : '' }}>Country
                                    </option>
                                    <option value="State" {{ old('area_type') == 'State' ? 'selected' : '' }}>State
                                    </option>
                                    <option value="District" {{ old('area_type') == 'District' ? 'selected' : '' }}>District
                                    </option>
                                    <option value="Tehsil" {{ old('area_type') == 'Tehsil' ? 'selected' : '' }}>Tehsil
                                    </option>
                                    <option value="Block" {{ old('area_type') == 'Block' ? 'selected' : '' }}>Block
                                    </option>
                                    <option value="City/Town" {{ old('area_type') == 'City/Town' ? 'selected' : '' }}>
                                        City/Town
                                    </option>
                                    <option value="Village" {{ old('area_type') == 'Village' ? 'selected' : '' }}>Village
                                    </option>
                                    <option value="Family" {{ old('area_type') == 'Family' ? 'selected' : '' }}>Family
                                    </option>
                                </select>
                                @error('area_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="academic_session" class="form-label bold"> Session <span
                                        class="login-danger">*</span></label>
                                <select class="form-control @error('academic_session') is-invalid @enderror"
                                    name="academic_session" required>
                                    <option value="">Select Session</option>
                                    @foreach ($data as $session)
                                        <option value="{{ $session->session_date }}">
                                            {{ $session->session_date }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- State Dropdown --}}
                            <div class="col-md-4 mb-3" id="stateDiv" style="display: none;">
                                <label for="stateSelect" class="form-label">State: <span
                                        class="text-danger">*</span></label>
                                <select class="form-control select2 @error('state') is-invalid @enderror" name="state"
                                    id="stateSelect">
                                    <option value="">Select State</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state }}"
                                            {{ old('state') == $state ? 'selected' : '' }}>
                                            {{ $state }}</option>
                                    @endforeach
                                </select>
                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Area Name Input --}}
                            <div class="col-md-4 mb-3" id="areaDiv" style="display: none;">
                                <label for="area" class="form-label">Area Name: <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="area" id="area"
                                    class="form-control @error('area') is-invalid @enderror" value="{{ old('area') }}"
                                    placeholder="Enter Area Name: ">
                                @error('area')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <input type="submit" class="btn btn-success btn-shadow w-100 btn-rounded" value="Add Area">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleAreaField() {
            const areaType = document.getElementById('area_type').value;
            const stateDiv = document.getElementById('stateDiv');
            const areaDiv = document.getElementById('areaDiv');
            const stateSelect = document.getElementById('stateSelect');
            const areaInput = document.getElementById('area');

            if (areaType === 'State') {
                stateDiv.style.display = 'block';
                areaDiv.style.display = 'none';
                areaInput.value = stateSelect.value;

                stateSelect.addEventListener('change', () => {
                    areaInput.value = stateSelect.value;
                });
            } else {
                stateDiv.style.display = 'none';
                areaDiv.style.display = 'block';
                areaInput.value = '';
            }
        }
        document.addEventListener('DOMContentLoaded', toggleAreaField);
    </script>
@endsection
