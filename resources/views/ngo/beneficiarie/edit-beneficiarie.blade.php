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
                        <li class="breadcrumb-item active" aria-current="page">View Registraition</li>
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
            <div class="card mt-4 p-3 border border-success rounded">
                <form action="{{ route('update-beneficiarie', $beneficiarie->id) }}" method="POST">
                    @csrf
                    <h5 class="text-success text-center">Edit Beneficiarie</h5>

                    <!-- Survey Details -->
                    <div class="mb-3">
                        <label for="survey_details" class="form-label">
                            Survey Details<span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('survey_details') is-invalid @enderror" id="survey_details"
                            name="survey_details" rows="3" required>{{ $beneficiarie->survey_details }}</textarea>
                        @error('survey_details')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Help by NGO -->
                    <div class="mb-3">
                        <label for="help_by_ngo" class="form-label">
                            Facilities (Help By Ngo):<span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control @error('help_by_ngo') is-invalid @enderror" id="help_by_ngo" name="help_by_ngo"
                            rows="3" required>{{ $beneficiarie->help_by_ngo }}</textarea>
                        @error('help_by_ngo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Survey Date -->
                    <div class="mb-3">
                        <label for="survey_date" class="form-label">
                            Survey Date<span class="text-danger">*</span>
                        </label>
                        <input type="date" class="form-control @error('survey_date') is-invalid @enderror"
                            name="survey_date" value="{{ $beneficiarie->survey_date }}" required>
                        @error('survey_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="bene_category">Beneficiarie Eligibility Category</label>
                        <select id="bene_category" name="bene_category" class="form-control" required>
                            <option value="">-- Select Category --</option>
                            <option value="Homeless Families"
                                {{ old('bene_category', $beneficiarie->bene_category ?? '') == 'Homeless Families' ? 'selected' : '' }}>
                                1. Homeless Families</option>
                            <option value="People living in kutcha or one-room houses"
                                {{ old('bene_category', $beneficiarie->bene_category ?? '') == 'People living in kutcha or one-room houses' ? 'selected' : '' }}>
                                2. People living in kutcha or one-room houses</option>
                            <option value="Widows"
                                {{ old('bene_category', $beneficiarie->bene_category ?? '') == 'Widows' ? 'selected' : '' }}>
                                3. Widows</option>
                            <option value="Elderly Women"
                                {{ old('bene_category', $beneficiarie->bene_category ?? '') == 'Elderly Women' ? 'selected' : '' }}>
                                4. Elderly Women</option>
                            <option value="Persons with Disabilities"
                                {{ old('bene_category', $beneficiarie->bene_category ?? '') == 'Persons with Disabilities' ? 'selected' : '' }}>
                                5. Persons with Disabilities</option>
                            <option value="Landless"
                                {{ old('bene_category', $beneficiarie->bene_category ?? '') == 'Landless' ? 'selected' : '' }}>
                                6. Landless</option>
                            <option value="Economically Weaker Section"
                                {{ old('bene_category', $beneficiarie->bene_category ?? '') == 'Economically Weaker Section' ? 'selected' : '' }}>
                                7. Economically Weaker Section</option>
                            <option value="Laborers"
                                {{ old('bene_category', $beneficiarie->bene_category ?? '') == 'Laborers' ? 'selected' : '' }}>
                                8. Laborers</option>
                            <option value="Scheduled Tribes"
                                {{ old('bene_category', $beneficiarie->bene_category ?? '') == 'Scheduled Tribes' ? 'selected' : '' }}>
                                9. Scheduled Tribes</option>
                            <option value="Scheduled Castes"
                                {{ old('bene_category', $beneficiarie->bene_category ?? '') == 'Scheduled Castes' ? 'selected' : '' }}>
                                10. Scheduled Castes</option>
                            <option value="Based on Low Income"
                                {{ old('bene_category', $beneficiarie->bene_category ?? '') == 'Based on Low Income' ? 'selected' : '' }}>
                                11. Based on Low Income</option>
                            <option value="Affected People"
                                {{ old('bene_category', $beneficiarie->bene_category ?? '') == 'Affected People' ? 'selected' : '' }}>
                                12. Affected People</option>
                            <option value="Marginal Farmers"
                                {{ old('bene_category', $beneficiarie->bene_category ?? '') == 'Marginal Farmers' ? 'selected' : '' }}>
                                13. Marginal Farmers</option>
                            <option value="Small Farmers"
                                {{ old('bene_category', $beneficiarie->bene_category ?? '') == 'Small Farmers' ? 'selected' : '' }}>
                                14. Small Farmers</option>
                            <option value="Large Farmers"
                                {{ old('bene_category', $beneficiarie->bene_category ?? '') == 'Large Farmers' ? 'selected' : '' }}>
                                15. Large Farmers</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="survey_officer" class="form-label">Survey Officer:</label>
                        <select name="survey_officer" class="form-control @error('survey_officer') is-invalid @enderror">
                            <option value="">Select Survey Officer</option>
                            @foreach ($staff as $person)
                                <option value="{{ $person->name }}"
                                    {{ old('survey_officer', $beneficiarie->survey_officer ?? '') == $person->name ? 'selected' : '' }}>
                                    {{ $person->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('survey_officer')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-success">Update Beneficiarie</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
