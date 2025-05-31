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
                        <li class="breadcrumb-item active" aria-current="page">Add Beneficiarie Facilities</li>
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


                    <div class="row ">
                        <!-- Identity Type -->
                        <div class="col-md-8">
                            <div class="row d-flex justify-content-between">
                                <div class="col-md-3 mb-3 bg-light">
                                    <div class="form-group">
                                        <label class="form-label">Identity Type:</label>
                                        <p class="form-control-plaintext">
                                            {{ $beneficiarie->identity_type ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Identity Card Number -->
                                <div class="col-md-3 mb-3 bg-light">
                                    <div class="form-group">
                                        <label class="form-label">Identity Card Number:</label>
                                        <p class="form-control-plaintext">
                                            {{ $beneficiarie->identity_no ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <!-- Identity Document -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">ID Document Uploaded:</label>
                                    @if (!empty($beneficiarie->id_document))
                                        <img src="{{ asset('benefries_images/' . $beneficiarie->id_document) }}"
                                            alt="Preview" width="150">
                                    @else
                                        <p class="form-control-plaintext">No document uploaded</p>
                                    @endif
                                </div>
                            </div>
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
            <div class="card mt-4 p-3 border rounded">
                <h5 class="text-success text-center">About Beneficiarie Survey</h5>

                <div class="row">

                    @if ($beneficiarie->surveys->count())
                        @foreach ($beneficiarie->surveys as $survey)
                            <div class="col-md-4">
                                <div class="bg-light border rounded p-3 h-100">
                                    <label class="form-label fw-bold">Survey Date:</label>
                                    <p> {{ \Carbon\Carbon::parse($survey->survey_date)->format('d-m-Y') }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-light border rounded p-3 h-100">
                                    <label class="form-label fw-bold">Survey Details:</label>
                                    <p class="card-text"><strong>Details:</strong> {{ $survey->survey_details }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-warning">No survey data available for this beneficiarie.</div>
                    @endif

                </div>
            </div>
            <div class="card mt-4 p-3 border border-success rounded">
                <form action="{{ route('store-beneficiarie-facilities', $beneficiarie->id) }}" method="POST">
                    @csrf
                    <h5 class="text-success text-center">Add Beneficiarie Facilities</h5>

                    <!-- Survey Details -->
                    <div class="mb-3">
                        <label for="facilities_category" class="form-label">
                            Facilities Category<span class="text-danger">*</span>
                        </label>
                        <select name="facilities_category" id="facilities_category"
                            class="form-select @error('facilities_category') is-invalid @enderror" required>
                            <option value="">-- Select Category --</option>
                            <option value="Education" {{ old('facilities_category') == 'Education' ? 'selected' : '' }}>
                                Education</option>
                            <option value="Peace Talk" {{ old('facilities_category') == 'Peace Talk' ? 'selected' : '' }}>
                                Peace Talk</option>
                            <option value="Environment"
                                {{ old('facilities_category') == 'Environment' ? 'selected' : '' }}>Environment</option>
                            <option value="Food" {{ old('facilities_category') == 'Food' ? 'selected' : '' }}>Food
                            </option>
                            <option value="Skill Development"
                                {{ old('facilities_category') == 'Skill Development' ? 'selected' : '' }}>Skill Development
                            </option>
                            <option value="Women Empowerment"
                                {{ old('facilities_category') == 'Women Empowerment' ? 'selected' : '' }}>Women Empowerment
                            </option>
                            <option value="Awareness" {{ old('facilities_category') == 'Awareness' ? 'selected' : '' }}>
                                Awareness</option>
                            <option value="Cultural Program"
                                {{ old('facilities_category') == 'Cultural Program' ? 'selected' : '' }}>Cultural Program
                            </option>
                            <option value="Clean Campaign"
                                {{ old('facilities_category') == 'Clean Campaign' ? 'selected' : '' }}>Clean Campaign
                            </option>
                            <option value="Health Mission"
                                {{ old('facilities_category') == 'Health Mission' ? 'selected' : '' }}>Health Mission
                            </option>
                            <option value="Poor Alleviation"
                                {{ old('facilities_category') == 'Poor Alleviation' ? 'selected' : '' }}>Poor Alleviation
                            </option>
                            <option value="Religious Program"
                                {{ old('facilities_category') == 'Religious Program' ? 'selected' : '' }}>Religious Program
                            </option>
                            <option value="Agriculture Program"
                                {{ old('facilities_category') == 'Agriculture Program' ? 'selected' : '' }}>Agriculture
                                Program</option>
                            <option value="Drinking Water"
                                {{ old('facilities_category') == 'Drinking Water' ? 'selected' : '' }}>Drinking Water
                            </option>
                            <option value="Natural Disaster"
                                {{ old('facilities_category') == 'Natural Disaster' ? 'selected' : '' }}>Natural Disaster
                            </option>
                            <option value="Animal Service"
                                {{ old('facilities_category') == 'Animal Service' ? 'selected' : '' }}>Animal Service
                            </option>
                        </select>
                        @error('facilities_category')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- Survey Date -->
                    <!-- Survey Details -->
                    <div class="mb-3">
                        <label for="facilities" class="form-label">
                            Facilities <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('facilities') is-invalid @enderror" id="facilities" name="facilities"
                            rows="3" required>{{ $beneficiarie->survey_details }}</textarea>
                        @error('facilities')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Add Beneficiarie Facilities</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
