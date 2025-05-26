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

        <div class="container-fluide m-3">
            <div class="card bg-white p-2 shadow rounded">
                <div class="text-black text-center border-bottom pb-3">
                    <h4 class=" p-3 bg-info rounded"><b>VIEW FORM </b></h4>
                </div>
                <div class="card bg-white p-2 shadow rounded">
                    <div class="text-black text-center border-bottom pb-3">
                        <h4 class=" p-3 bg-info rounded"><b>BENEFICIARIE </b></h4>
                    </div>
                    <div class="card-body m-1">
                        <div class="border-bottom pb-3 mb-4">
                            <h5 class="text-black fw-bold">Information</h5>

                            <div class="row g-3">
                                <!-- Application Date -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Application Date:</label>
                                        <p class="mb-0">{{ $beneficiarie->application_date }}</p>
                                    </div>
                                </div>

                                <!-- Application No -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Application No:</label>
                                        <p class="mb-0">{{ $beneficiarie->application_no }}</p>
                                    </div>
                                </div>

                                <!-- Registration Date -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Registration Date:</label>
                                        <p class="mb-0">{{ $beneficiarie->registration_date }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <!-- Registration No -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Registration No:</label>
                                        <p class="mb-0">{{ $beneficiarie->registration_no }}</p>
                                    </div>
                                </div>

                                <!-- Uploaded Image -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100 text-center">
                                        <label class="form-label fw-bold">Uploaded Image:</label><br>
                                        @if (!empty($beneficiarie->image))
                                            <img src="{{ asset('benefries_images/' . $beneficiarie->image) }}"
                                                alt="Program Image" width="100" class="img-fluid rounded">
                                        @else
                                            <p class="form-control-plaintext">No Image uploaded</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Full Name -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Full Name:</label>
                                        <p class="mb-0">{{ $beneficiarie->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <!-- Date of Birth -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Date of Birth:</label>
                                        <p class="mb-0">{{ $beneficiarie->dob }}</p>
                                    </div>
                                </div>

                                <!-- Gender -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Gender:</label>
                                        <p class="mb-0">{{ $beneficiarie->gender }}</p>
                                    </div>
                                </div>

                                <!-- Eligibility -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Eligibility / Education Level:</label>
                                        <p class="mb-0">{{ $beneficiarie->eligibility }}</p>
                                    </div>
                                </div>
                            </div>


                            <div class="row g-3 mt-1">
                                <!-- Marital Status -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Marital Status:</label>
                                        <p class="mb-0">{{ $beneficiarie->marital_status }}</p>
                                    </div>
                                </div>

                                <!-- Guardian Name -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Father/Husband Name:</label>
                                        <p class="mb-0">{{ $beneficiarie->gurdian_name }}</p>
                                    </div>
                                </div>

                                <!-- Mother Name -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Mother Name:</label>
                                        <p class="mb-0">{{ $beneficiarie->mother_name }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <!-- Village -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Village/Locality:</label>
                                        <p class="mb-0">{{ $beneficiarie->village }}</p>
                                    </div>
                                </div>

                                <!-- Post/Town -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Post/Town:</label>
                                        <p class="mb-0">{{ $beneficiarie->post }}</p>
                                    </div>
                                </div>

                                <!-- Area Type -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Area Type:</label>
                                        <p class="mb-0">{{ $beneficiarie->area_type }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <!-- Block -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Block:</label>
                                        <p class="mb-0">{{ $beneficiarie->block }}</p>
                                    </div>
                                </div>

                                <!-- State -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">State:</label>
                                        <p class="mb-0">{{ $beneficiarie->state }}</p>
                                    </div>
                                </div>

                                <!-- District -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">District:</label>
                                        <p class="mb-0">{{ $beneficiarie->district }}</p>
                                    </div>
                                </div>
                            </div>


                            <div class="row g-3 mt-1">
                                <!-- Pincode -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Pincode:</label>
                                        <p class="mb-0">{{ $beneficiarie->pincode }}</p>
                                    </div>
                                </div>

                                <!-- Country -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Nationality:</label>
                                        <p class="mb-0">{{ $beneficiarie->country }}</p>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Email:</label>
                                        <p class="mb-0">{{ $beneficiarie->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <!-- Phone -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Phone:</label>
                                        <p class="mb-0">{{ $beneficiarie->phone }}</p>
                                    </div>
                                </div>

                                <!-- Religion -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Religion:</label>
                                        <p class="mb-0">{{ $beneficiarie->religion }}</p>
                                    </div>
                                </div>

                                <!-- Religion Category -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Religion Category:</label>
                                        <p class="mb-0">{{ $beneficiarie->religion_category }}</p>
                                    </div>
                                </div>
                            </div>


                            <div class="row g-3 mt-1">
                                <!-- Caste -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Caste:</label>
                                        <p class="mb-0">{{ $beneficiarie->caste }}</p>
                                    </div>
                                </div>

                                <!-- Identity Type -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Identity Type:</label>
                                        <p class="mb-0">{{ $beneficiarie->identity_type ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <!-- Identity Card Number -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Identity Card Number:</label>
                                        <p class="mb-0">{{ $beneficiarie->identity_no ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>


                            <div class="row g-3 mt-1">
                                <!-- Identity Document -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">ID Document Uploaded:</label><br>
                                        @if (!empty($beneficiarie->id_document))
                                            <img src="{{ asset('benefries_images/' . $beneficiarie->id_document) }}"
                                                width="150" class="img-thumbnail">
                                        @else
                                            <p class="form-control-plaintext">No document uploaded</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Occupation -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">Occupation:</label>
                                        <p class="mb-0">{{ $beneficiarie->occupation ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <!-- Help Needed -->
                                <div class="col-md-4">
                                    <div class="bg-light border rounded p-3 h-100">
                                        <label class="form-label fw-bold">What beneficiaries need help with:</label>
                                        <div>
                                            {{ $beneficiarie->help_needed }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
