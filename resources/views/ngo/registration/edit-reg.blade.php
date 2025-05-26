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
                        <li class="breadcrumb-item active" aria-current="page">Registraition</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container-fluide m-3">
            <div class="card bg-white p-2 shadow rounded">
                <div class="text-black text-center border-bottom pb-3">
                    <h4 class=" p-3 bg-info rounded"><b>EDIT FORM </b></h4>
                </div>
                <div class="card-body m-1">
                    <form method="POST" action="{{ route('update-registration', $beneficiarie->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="border-bottom pb-3 mb-4">
                            <h5 class="text-black"><b>Information</b></h5>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 form-group mb-3">
                                            <label for="application_date" class="form-label">Application Date: <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="application_date" id="application_date"
                                                class="form-control datepicker @error('dob') is-invalid @enderror"
                                                value="{{ $beneficiarie->application_date }}" required>
                                            @error('application_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="reg_type" class="form-label">Registration Type <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" id="reg_type" name="reg_type" required>
                                                    <option disabled {{ !$beneficiarie->reg_type ? 'selected' : '' }}>Select
                                                        Type</option>
                                                    <option value="Beneficiaries"
                                                        {{ $beneficiarie->reg_type == 'Beneficiaries' ? 'selected' : '' }}>
                                                        Beneficiaries
                                                    </option>
                                                    <option value="Member"
                                                        {{ $beneficiarie->reg_type == 'Member' ? 'selected' : '' }}>
                                                        Member
                                                    </option>
                                                </select>
                                                @error('reg_type')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-sm-6  form-group mb-3">
                                            <label for="program_session" class="form-label bold">Program Session <span
                                                    class="login-danger">*</span></label>
                                            <select class="form-control @error('program_session') is-invalid @enderror"
                                                name="program_session" required>
                                                <option value="">Select Session</option>
                                                @foreach ($data as $session)
                                                    <option value="{{ $session->session_date }}"
                                                        {{ isset($beneficiarie) && $beneficiarie->academic_session == $session->session_date ? 'selected' : '' }}>
                                                        {{ $session->session_date }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 col-sm-6  form-group mb-3">
                                            <label for="name" class="form-label">Full Name: <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ $beneficiarie->name }}" required>
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-6 form-group mb-3">
                                            <label for="dob" class="form-label">Date of Birth: <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="dob" id="dob"
                                                class="form-control datepicker @error('dob') is-invalid @enderror"
                                                value="{{ $beneficiarie->dob }}" required>
                                            @error('dob')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 col-sm-6 form-group mb-3">
                                            <label for="gender" class="form-label">Gender: <span
                                                    class="text-danger">*</span></label>
                                            <select name="gender" id="gender"
                                                class="form-control @error('gender') is-invalid @enderror" required>
                                                <option value="" disabled
                                                    {{ !(old('gender') ?? $beneficiarie->gender) ? 'selected' : '' }}>
                                                    Select Gender</option>
                                                <option value="Male"
                                                    {{ (old('gender') ?? $beneficiarie->gender) == 'Male' ? 'selected' : '' }}>
                                                    Male</option>
                                                <option value="Female"
                                                    {{ (old('gender') ?? $beneficiarie->gender) == 'Female' ? 'selected' : '' }}>
                                                    Female</option>
                                                <option value="Other"
                                                    {{ (old('gender') ?? $beneficiarie->gender) == 'Other' ? 'selected' : '' }}>
                                                    Other</option>
                                            </select>
                                            @error('gender')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>








                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <div class="upload-container">

                                        @if (!empty($beneficiarie->image))
                                            <img id="previewImage"
                                                src="{{ asset('benefries_images/' . $beneficiarie->image) }}"
                                                alt="Preview" width="160">
                                        @endif



                                        <label for="uploadInput" class="upload-btn">Choose File</label>
                                        <input type="file" id="uploadInput" name="image" accept="image/*">
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                                <div class="col-md-4 form-group mb-3">
                                    <label for="eligibility" class="form-label">Eligibility / Education Level: <span
                                            class="text-danger">*</span></label>
                                    <select name="eligibility" class="form-control" id="eligibility" required>
                                        <option value="" disabled
                                            {{ !(old('eligibility') ?? $beneficiarie->eligibility) ? 'selected' : '' }}>
                                            Select Education Level</option>
                                        <option value="Uneducated"
                                            {{ (old('eligibility') ?? $beneficiarie->eligibility) == 'Uneducated' ? 'selected' : '' }}>
                                            Uneducated</option>
                                        <option value="5th Pass"
                                            {{ (old('eligibility') ?? $beneficiarie->eligibility) == '5th Pass' ? 'selected' : '' }}>
                                            5th Pass</option>
                                        <option value="Secondary"
                                            {{ (old('eligibility') ?? $beneficiarie->eligibility) == 'Secondary' ? 'selected' : '' }}>
                                            Secondary</option>
                                        <option value="Senior Secondary"
                                            {{ (old('eligibility') ?? $beneficiarie->eligibility) == 'Senior Secondary' ? 'selected' : '' }}>
                                            Senior Secondary</option>
                                        <option value="Graduation"
                                            {{ (old('eligibility') ?? $beneficiarie->eligibility) == 'Graduation' ? 'selected' : '' }}>
                                            Graduation</option>
                                        <option value="Post Graduation"
                                            {{ (old('eligibility') ?? $beneficiarie->eligibility) == 'Post Graduation' ? 'selected' : '' }}>
                                            Post Graduation</option>
                                        <option value="Degree Holder"
                                            {{ (old('eligibility') ?? $beneficiarie->eligibility) == 'Degree Holder' ? 'selected' : '' }}>
                                            Degree Holder</option>
                                    </select>
                                    @error('eligibility')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for="marital_status" class="form-label">Marital Status: <span
                                            class="text-danger">*</span></label>
                                    <select name="marital_status" class="form-control" id="marital_status" required>
                                        <option value="" disabled
                                            {{ !(old('marital_status') ?? $beneficiarie->marital_status) ? 'selected' : '' }}>
                                            Select Marital Status
                                        </option>
                                        <option value="Married"
                                            {{ (old('marital_status') ?? $beneficiarie->marital_status) == 'Married' ? 'selected' : '' }}>
                                            Married
                                        </option>
                                        <option value="Unmarried"
                                            {{ (old('marital_status') ?? $beneficiarie->marital_status) == 'Unmarried' ? 'selected' : '' }}>
                                            Unmarried
                                        </option>
                                    </select>
                                    @error('marital_status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group local-forms">
                                        <label class="form-label">Father/Husband Name: <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="gurdian_name" id="gurdian_name"
                                            class="form-control @error('gurdian_name') is-invalid @enderror"
                                            value="{{ $beneficiarie->gurdian_name }}" required>
                                        @error('gurdian_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group local-forms">
                                        <label class="form-label">Mother Name: <span class="text-danger">*</span></label>
                                        <input type="text" name="mother_name" id="mother_name"
                                            class="form-control @error('mother_name') is-invalid @enderror"
                                            value="{{ $beneficiarie->mother_name }}" required>
                                        @error('mother_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for="village" class="form-label">Village/Locality: <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="village" id="village"
                                        class="form-control @error('village') is-invalid @enderror"
                                        value="{{ $beneficiarie->village }}">
                                    @error('village')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group mb-3">
                                    <label for="post" class="form-label">Post/Town: <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="post" id="post"
                                        class="form-control @error('post') is-invalid @enderror"
                                        value="{{ $beneficiarie->post }}" required>
                                    @error('post')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group mb-3">
                                    <label for="area_type" class="form-label">Area Type: <span
                                            class="text-danger">*</span></label>
                                    <select name="area_type" class="form-control" id="area_type" required>
                                        <option value="" disabled
                                            {{ !(old('area_type') ?? $beneficiarie->area_type) ? 'selected' : '' }}>Select
                                            Area Type</option>
                                        <option value="Rular"
                                            {{ (old('area_type') ?? $beneficiarie->area_type) == 'Rular' ? 'selected' : '' }}>
                                            Rular</option>
                                        <option value="Urban"
                                            {{ (old('area_type') ?? $beneficiarie->area_type) == 'Urban' ? 'selected' : '' }}>
                                            Urban</option>
                                    </select>
                                    @error('area_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-md-4 form-group mb-3">
                                    <label for="block" class="form-label">Block: <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="block" id="block"
                                        class="form-control @error('block') is-invalid @enderror"
                                        value="{{ $beneficiarie->block }}" required>
                                    @error('block')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                @php
                                    $districtsByState = config('districts');
                                @endphp
                                <div class="col-md-4 form-group mb-3">
                                    <label for="stateSelect" class="form-label">State: <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control select2 @error('state') is-invalid @enderror"
                                        name="state" id="stateSelect" required>
                                        <option value="">Select State</option>
                                        @foreach ($districtsByState as $state => $districts)
                                            <option value="{{ $state }}"
                                                {{ (old('state') ?? $beneficiarie->state) == $state ? 'selected' : '' }}>
                                                {{ $state }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-md-4 form-group mb-3">
                                    <label for="districtSelect" class="form-label">District: <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('district') is-invalid @enderror" name="district"
                                        id="districtSelect" required>
                                        <option value="">

                                        </option>
                                    </select>
                                    @error('district')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-md-4 form-group mb-3">
                                    <label for="pincode" class="form-label">Pincode: <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="pincode" id="pincode"
                                        class="form-control @error('pincode') is-invalid @enderror"
                                        value="{{ $beneficiarie->pincode }}">
                                    @error('pincode')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group mb-3">
                                    <label for="country" class="form-label">Nationality: <span
                                            class="text-danger">*</span></label>
                                    <select name="country" class="form-control" id="country" required>
                                        <option value="" disabled
                                            {{ !(old('country') ?? $beneficiarie->country) ? 'selected' : '' }}>Select
                                            Nationality</option>
                                        <option value="India"
                                            {{ (old('country') ?? $beneficiarie->country) == 'India' ? 'selected' : '' }}>
                                            India</option>
                                    </select>
                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-md-4 col-sm-6 col-sm-12 form-group mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ $beneficiarie->email }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 col-sm-6  form-group mb-3">
                                    <label for="phone" class="form-label">Phone: <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="phone" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ $beneficiarie->phone }}" required>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="religion" class="form-label">Religion <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select select2 @error('religion') is-invalid @enderror"
                                        id="religion" name="religion" required>
                                        <option value="" disabled
                                            {{ old('religion') ?? $beneficiarie->religion ? '' : 'selected' }}>
                                            Select Religion
                                        </option>
                                        <option value="Hindu"
                                            {{ (old('religion') ?? $beneficiarie->religion) == 'Hindu' ? 'selected' : '' }}>
                                            Hindu</option>
                                        <option value="Islam"
                                            {{ (old('religion') ?? $beneficiarie->religion) == 'Islam' ? 'selected' : '' }}>
                                            Islam</option>
                                        <option value="Christian"
                                            {{ (old('religion') ?? $beneficiarie->religion) == 'Christian' ? 'selected' : '' }}>
                                            Christian</option>
                                        <option value="Sikh"
                                            {{ (old('religion') ?? $beneficiarie->religion) == 'Sikh' ? 'selected' : '' }}>
                                            Sikh</option>
                                        <option value="Buddhist"
                                            {{ (old('religion') ?? $beneficiarie->religion) == 'Buddhist' ? 'selected' : '' }}>
                                            Buddhist</option>
                                        <option value="Parsi"
                                            {{ (old('religion') ?? $beneficiarie->religion) == 'Parsi' ? 'selected' : '' }}>
                                            Parsi</option>
                                    </select>
                                    @error('religion')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="category" class="form-label">Religion Category <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('religion_category') is-invalid @enderror"
                                        id="category" name="religion_category" required>
                                        <option value="" disabled
                                            {{ old('religion_category') ?? $beneficiarie->religion_category ? '' : 'selected' }}>
                                            Select Category
                                        </option>
                                        <option value="General"
                                            {{ (old('religion_category') ?? $beneficiarie->religion_category) == 'General' ? 'selected' : '' }}>
                                            General</option>
                                        <option value="OBC"
                                            {{ (old('religion_category') ?? $beneficiarie->religion_category) == 'OBC' ? 'selected' : '' }}>
                                            OBC</option>
                                        <option value="SC"
                                            {{ (old('religion_category') ?? $beneficiarie->religion_category) == 'SC' ? 'selected' : '' }}>
                                            SC</option>
                                        <option value="ST"
                                            {{ (old('religion_category') ?? $beneficiarie->religion_category) == 'ST' ? 'selected' : '' }}>
                                            ST</option>
                                    </select>
                                    @error('religion_category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group local-forms">
                                        <label class="form-label">Caste: <span class="text-danger">*</span></label>
                                        <input type="text" name="caste" id="caste"
                                            class="form-control @error('caste') is-invalid @enderror"
                                            value="{{ $beneficiarie->caste }}" required>
                                        @error('caste')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="identity_type" class="form-label">Identity Type: <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control @error('identity_type') is-invalid @enderror"
                                        id="identity_type" name="identity_type" required>
                                        <option selected disabled>Select Identity Type</option>
                                        <option value="Aadhar Card"
                                            {{ (old('identity_type') ?? $beneficiarie->identity_type) == 'Aadhar Card' ? 'selected' : '' }}>
                                            Aadhar Card
                                        </option>
                                        <option value="Voter ID Card"
                                            {{ (old('identity_type') ?? $beneficiarie->identity_type) == 'Voter ID Card' ? 'selected' : '' }}>
                                            Voter ID Card
                                        </option>
                                        <option value="Pan Card"
                                            {{ (old('identity_type') ?? $beneficiarie->identity_type) == 'Pan Card' ? 'selected' : '' }}>
                                            Pan Card
                                        </option>
                                        <option value="Markshhet"
                                            {{ (old('identity_type') ?? $beneficiarie->identity_type) == 'Markshhet' ? 'selected' : '' }}>
                                            Markshhet
                                        </option>
                                        <option value="Driving License"
                                            {{ (old('identity_type') ?? $beneficiarie->identity_type) == 'Driving License' ? 'selected' : '' }}>
                                            Driving License
                                        </option>
                                        <option value="Narega Card"
                                            {{ (old('identity_type') ?? $beneficiarie->identity_type) == 'Narega Card' ? 'selected' : '' }}>
                                            Narega Card
                                        </option>
                                        <option value="Ration Card"
                                            {{ (old('identity_type') ?? $beneficiarie->identity_type) == 'Ration Card' ? 'selected' : '' }}>
                                            Ration Card
                                        </option>
                                    </select>
                                    @error('identity_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Identity Number Input -->
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="identity_no" class="form-label">Identity Card Number: <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('identity_no') is-invalid @enderror"
                                        id="identity_no" name="identity_no" placeholder="Enter Identity Card No"
                                        value="{{ old('identity_no') ?? ($beneficiarie->identity_no ?? '') }}" required>
                                    <small id="identity_no_hint" class="form-text text-muted"></small>
                                    @error('identity_no')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <!-- Identity File Upload -->
                            <div class="col-md-4 mb-3">
                                <label for="id_document" class="form-label">ID Document Upload</label>
                                <input type="file" class="form-control" name="id_document" id="id_document">
                                <small id="id_document_hint" class="form-text text-muted"></small>
                                @if (!empty($beneficiarie->id_document))
                                    <img id="previewImage"
                                        src="{{ asset('benefries_images/' . $beneficiarie->id_document) }}"
                                        alt="Preview" width="150">
                                @endif

                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="occupation" class="form-label">Occupation: <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="occupation" id="occupation"
                                    class="form-control @error('occupation') is-invalid @enderror"
                                    value="{{ $beneficiarie->occupation }}" required>
                                @error('occupation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3" id="beneficiaryHelpDiv" style="display: none;">
                                <label for="beneficiary_help" class="form-label">What beneficiaries need help with: <span
                                        class="text-danger">*</span></label>
                                <textarea name="help_needed" id="beneficiary_help" rows="4"
                                    class="form-control @error('beneficiary_help') is-invalid @enderror" required>{{ $beneficiarie->help_needed }}</textarea>
                                @error('beneficiary_help')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group text-center">
                                    <button type="submit" name="submit" class="btn btn-success w-50">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="container-fluid mt-3">
            <div class="row ">
                <div class="col">
                    <div class="card bg-white p-2 shadow rounded m-2">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <form action="{{ route('approve-status', $beneficiarie->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PATCH')

                                    <div class="form-group mb-3">
                                        <label for="registration_date" class="form-label">
                                            Registration Date: <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="registration_date" id="registration_date"
                                            class="form-control datepicker @error('registration_date') is-invalid @enderror"
                                            value="{{ old('registration_date') }}" required>
                                        @error('registration_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-success btn-sm w-50" style="height: 38px;">
                                        Approve
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        const uploadInput = document.getElementById('uploadInput');
        const previewImage = document.getElementById('previewImage');
        const placeholderText = document.getElementById('placeholderText');

        uploadInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                    placeholderText.style.display = 'none';
                };

                reader.readAsDataURL(file);
            }
        });
    </script>
    <script>
        document.getElementById("registraition_no").value = Math.floor(100000 + Math.random() * 9000000);
    </script>

    <!-- Inline Script to load districts -->
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
    <script>
        function updateIDFields() {
            const type = document.getElementById('identity_type').value;
            const hintText = document.getElementById('identity_hint');
            const numberHint = document.getElementById('identity_no_hint');
            const fileHint = document.getElementById('id_document_hint');
            const inputField = document.getElementById('identity_no');

            let subtitle = '';
            let pattern = '';
            let placeholder = '';

            switch (type) {
                case 'Aadhar Card':
                    subtitle = 'Enter 12-digit Aadhar Number';
                    pattern = '\\d{12}';
                    placeholder = 'e.g. 123456789012';
                    break;
                case 'Voter ID Card':
                    subtitle = 'Enter Voter ID like ABC1234567';
                    pattern = '[A-Z]{3}[0-9]{7}';
                    placeholder = 'e.g. ABC1234567';
                    break;
                case 'Pan Card':
                    subtitle = 'Enter PAN like ABCDE1234F';
                    pattern = '[A-Z]{5}[0-9]{4}[A-Z]{1}';
                    placeholder = 'e.g. ABCDE1234F';
                    break;
                case 'Driving License':
                    subtitle = 'Enter Driving License Number';
                    pattern = '.{5,20}';
                    placeholder = 'e.g. DL01XXXXXXX';
                    break;
                case 'Narega Card':
                    subtitle = 'Enter Narega Card Number';
                    pattern = '\\w{5,20}';
                    placeholder = 'Enter Narega Card No';
                    break;
                case 'Ration Card':
                    subtitle = 'Enter Ration Card Number';
                    pattern = '\\w{5,20}';
                    placeholder = 'Enter Ration Card No';
                    break;
                case 'Markshhet':
                    subtitle = 'Enter Marksheet Number';
                    pattern = '.{5,20}';
                    placeholder = 'Enter Marksheet ID';
                    break;
            }

            // Set field hints and pattern
            hintText.textContent = subtitle;
            numberHint.textContent = subtitle;
            fileHint.textContent = `Upload scanned copy of ${type}`;
            inputField.setAttribute('pattern', pattern);
            inputField.setAttribute('placeholder', placeholder);
            inputField.setAttribute('title', subtitle); // shows hint on hover
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const regTypeSelect = document.getElementById('reg_type');
            const beneficiaryHelpDiv = document.getElementById('beneficiaryHelpDiv');

            function toggleBeneficiaryHelp() {
                if (regTypeSelect.value === 'Beneficiaries') {
                    beneficiaryHelpDiv.style.display = 'block';
                } else {
                    beneficiaryHelpDiv.style.display = 'none';
                }
            }

            // Initial check on page load
            toggleBeneficiaryHelp();

            // Listen for changes
            regTypeSelect.addEventListener('change', toggleBeneficiaryHelp);
        });
    </script>
@endsection
