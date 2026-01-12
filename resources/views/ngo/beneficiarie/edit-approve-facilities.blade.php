@extends('ngo.layout.master')
@section('content')
    <style>
        .upload-container {
            text-align: center;
            margin-top: 15px;
            padding: 10px 20px;
            margin-left: 50px;
        }

        .image-placeholder {
            width: 150px;
            height: 150px;
            /* border: 2px dashed #ccc; */
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            background-color: rgb(223, 226, 228);
        }

        .image-placeholder img {
            max-width: 100%;
            max-height: 100%;
            display: none;
        }

        .upload-btn {
            display: inline-block;
            background-color: #343a40;
            color: #fff;
            padding: 10px 15px;
            margin-right: 180px;
            font-size: 16px;
            width: auto;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }

        .upload-btn:hover {
            background-color: #495057;
        }

        #uploadInput {
            display: none;
        }
    </style>

    <div class="wrapper">
        {{-- <div class="main-content"> --}}
        <!-- Breadcrumb -->
        <div class="row d-flex justify-content-end mt-2">
            <div class="col-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('ngo') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Distribute Facilities status</li>
                    </ol>
                </nav>
            </div>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container-fluide m-3">
            <div class="card bg-white p-2 shadow rounded">
                <div class="text-black text-center border-bottom pb-3">
                    <h4 class=" p-3 bg-info rounded"><b>BENEFICIARIE </b></h4>
                </div>
                <div class="card-body m-1">
                    <div class="border-bottom pb-3 mb-4">
                        <h5 class="text-black"><b>Information</b></h5>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row d-flex justify-content-between">
                                    <!-- Application Date -->
                                    <div class="col-md-5 col-sm-6 form-group mb-3 bg-light">
                                        <label class="form-label">Application Date:</label>
                                        <p class="form-control-plaintext">{{ $beneficiarie->application_date }}</p>
                                    </div>

                                    <div class="col-md-5 col-sm-6 form-group mb-3 bg-light">
                                        <label class="form-label">Application No:</label>
                                        <p class="form-control-plaintext">{{ $beneficiarie->application_no }}</p>
                                    </div>

                                    <div class="col-md-5 col-sm-6 form-group mb-3 bg-light">
                                        <label class="form-label">Registration Date:</label>
                                        <p class="form-control-plaintext">{{ $beneficiarie->registration_date }}</p>
                                    </div>

                                    <div class="col-md-5 col-sm-6 form-group mb-3 bg-light">
                                        <label class="form-label">Registration No:</label>
                                        <p class="form-control-plaintext">{{ $beneficiarie->registration_no }}</p>
                                    </div>

                                    <!-- Full Name -->
                                    <div class="col-md-5 col-sm-6 form-group mb-3 bg-light">
                                        <label class="form-label">Full Name:</label>
                                        <p class="form-control-plaintext">{{ $beneficiarie->name }}</p>
                                    </div>

                                    <!-- Date of Birth -->
                                    <div class="col-md-5 col-sm-6 form-group mb-3 bg-light">
                                        <label class="form-label">Date of Birth:</label>
                                        <p class="form-control-plaintext">{{ $beneficiarie->dob }}</p>
                                    </div>
                                </div>

                                <div class="row d-flex justify-content-between">
                                    <!-- Gender -->
                                    <div class="col-md-5 col-sm-6 form-group mb-3 bg-light">
                                        <label class="form-label">Gender:</label>
                                        <p class="form-control-plaintext">{{ $beneficiarie->gender }}</p>
                                    </div>

                                    <!-- Eligibility / Education Level -->
                                    <div class="col-md-5 form-group mb-3 bg-light">
                                        <label class="form-label">Eligibility / Education Level:</label>
                                        <p class="form-control-plaintext">{{ $beneficiarie->eligibility }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="upload-container">
                                    @if (!empty($beneficiarie->image))
                                        <img id="previewImage"
                                            src="{{ asset('benefries_images/' . $beneficiarie->image) }}" alt="Preview"
                                            width="160">
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="row d-flex justify-content-between">

                            <div class="col-md-3 form-group mb-3 bg-light">
                                <label class="form-label">Marital Status:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->marital_status }}</p>
                            </div>

                            <div class="col-md-3 mb-3 bg-light">
                                <label class="form-label">Father/Husband Name:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->gurdian_name }}</p>
                            </div>

                            <div class="col-md-3 mb-3 bg-light">
                                <label class="form-label">Mother Name:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->mother_name }}</p>
                            </div>

                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-3 form-group mb-3 bg-light">
                                <label class="form-label">Village/Locality:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->village }}</p>
                            </div>

                            <div class="col-md-3 form-group mb-3 bg-light">
                                <label class="form-label">Post/Town:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->post }}</p>
                            </div>

                            <div class="col-md-3 form-group mb-3 bg-light">
                                <label class="form-label">Area Type:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->area_type }}</p>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-3 form-group mb-3 bg-light">
                                <label class="form-label">Block:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->block }}</p>
                            </div>

                            <div class="col-md-3 form-group mb-3 bg-light">
                                <label class="form-label">State:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->state }}</p>
                            </div>

                            <div class="col-md-3 form-group mb-3 bg-light">
                                <label class="form-label">District:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->district }}</p>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-3 form-group mb-3 bg-light">
                                <label class="form-label">Pincode:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->pincode }}</p>
                            </div>

                            <div class="col-md-3 form-group mb-3 bg-light">
                                <label class="form-label">Nationality:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->country }}</p>
                            </div>

                            <div class="col-md-3 col-sm-6 form-group mb-3 bg-light">
                                <label class="form-label">Email:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->email }}</p>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="col-md-3 col-sm-6 form-group mb-3 bg-light">
                                <label class="form-label">Phone:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->phone }}</p>
                            </div>

                            <div class="col-md-3 mb-3 bg-light">
                                <label class="form-label">Religion:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->religion }}</p>
                            </div>

                            <div class="col-md-3 mb-3 bg-light">
                                <label class="form-label">Religion Category:</label>
                                <p class="form-control-plaintext">{{ $beneficiarie->religion_category }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 bg-light">
                            <label class="form-label">Caste:</label>
                            <p class="form-control-plaintext">{{ $beneficiarie->caste }}</p>
                        </div>
                    </div>

                    <div class="row">

                        <!-- Occupation -->
                        <div class="col-md-4 mb-3 bg-light">
                            <div class="form-group">
                                <label class="form-label">Occupation:</label>
                                <p class="form-control-plaintext">
                                    {{ $beneficiarie->occupation ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">What beneficiaries need help with:</label>
                            <div class="border rounded p-2" style="background-color: #f8f9fa;">
                                {{ $beneficiarie->help_needed }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card mt-4 p-3 border border-success rounded">
                <h5 class="text-success text-center">About Beneficiarie Survey & Facilities</h5>

                <div class="row">
                    @if ($beneficiarie->surveys)
                        {{-- @foreach ($beneficiarie->surveys as $survey) --}}
                        <div class="col-md-4 mb-3">
                            <div class="bg-light border rounded p-3 h-100">
                                <label class="form-label fw-bold">Survey Date:</label>
                                <p>{{ \Carbon\Carbon::parse($survey->survey_date)->format('d-m-Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">

                            <div class="bg-light border rounded p-3 h-100">
                                <label class="form-label fw-bold">Survey Details:</label>
                                <p><strong>Details:</strong> {{ $survey->survey_details ?? 'Not Found' }}</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="bg-light border rounded p-3 h-100">
                                <label class="form-label fw-bold">Facilities Category:</label>
                                <p class="card-text"><strong>Category:</strong>
                                    {{ $survey->facilities_category ?? 'Not Found' }}</p>
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <div class="bg-light border rounded p-3 h-100">
                                <label class="form-label fw-bold">Facilities Details:</label>
                                <p class="card-text"><strong>Facilities:</strong> {{ $survey->facilities ?? 'Not Found' }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="bg-light border rounded p-3 h-100">
                                <label class="form-label fw-bold">Distribute Date:</label>
                                <p>{{ \Carbon\Carbon::parse($survey->distribute_date)->format('d-m-Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <div class="bg-light border rounded p-3 h-100">
                                <label class="form-label fw-bold">Distribute Place:</label>
                                <p class="card-text"><strong>Facilities:</strong>
                                    {{ $survey->distribute_place ?? 'Not Found' }}
                                </p>
                            </div>
                        </div>

                        {{-- @endforeach --}}
                    @else
                        <div class="col-12">
                            <div class="alert alert-warning">No survey data available for this beneficiary.</div>
                        </div>
                </div>
                @endif
            </div>
            <div class="card mt-4 p-3 border border-success rounded">
                <form
                    action="{{ route('update-distribute-facilities-status', ['beneficiarie_id' => $beneficiarie->id, 'survey_id' => $survey->id]) }}"
                    method="POST">
                    @csrf
                    <h5 class="text-success text-center">
                        Edit Distribute Beneficiarie Facilities Status
                    </h5>

                    {{-- Approve Officer --}}
                    <div class="mt-2 mb-3">
                        <label class="form-label">Approve Officer:</label>
                        <select name="officer" class="form-control @error('officer') is-invalid @enderror">
                            <option value="">Select Approve Officer</option>
                            @foreach ($staff as $person)
                                @php
                                    $value =
                                        $person->name .
                                        ' ( ' .
                                        $person->staff_code .
                                        ' ) ( ' .
                                        $person->position .
                                        ' )';
                                @endphp
                                <option value="{{ $value }}"
                                    {{ old('officer', $survey->survey_officer) == $value ? 'selected' : '' }}>
                                    {{ $person->name }} ({{ $person->staff_code }}) ({{ $person->position }})
                                </option>
                            @endforeach
                        </select>
                        @error('officer')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="mb-3 mt-1">
                        <label class="form-label">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="">Select Status</option>
                            <option value="Pending" {{ old('status', $survey->status) == 'Pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="Distributed"
                                {{ old('status', $survey->status) == 'Distributed' ? 'selected' : '' }}>
                                Distributed
                            </option>
                            <option value="Reject" {{ old('status', $survey->status) == 'Reject' ? 'selected' : '' }}>
                                Reject
                            </option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Pending / Reject Reason --}}
                    <div class="mb-3 mt-1" id="pendingDiv"
                        style="{{ in_array(old('status', $survey->status), ['Pending', 'Reject']) ? '' : 'display:none;' }}">
                        <label class="form-label">
                            Reason <span class="text-danger">*</span>
                        </label>
                        <textarea name="pending_reason" class="form-control" rows="3">{{ old('pending_reason', $survey->pending_reason) }}</textarea>
                        @error('pending_reason')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">
                            Update Distribution Status
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status');
            const PendingDiv = document.getElementById('pendingDiv');

            function togglePendingReason() {
                if (statusSelect.value === 'Pending' || statusSelect.value === 'Reject') {
                    PendingDiv.style.display = 'block';
                } else {
                    PendingDiv.style.display = 'none';
                }
            }

            // Run on page load
            togglePendingReason();

            // Run on change
            statusSelect.addEventListener('change', togglePendingReason);
        });
    </script>
@endsection
