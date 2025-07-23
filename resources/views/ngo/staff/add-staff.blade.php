@extends('ngo.layout.master')
@section('content')
    <style>
        /* ::placeholder {
                                                    font-size: 8px;
                                                } */

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
            margin-right: 100px;
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
        <div class="d-flex justify-content-between aligin-item-center mb-3 mt-2">
            <h5 class="mb-0">Add Staff</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Staff</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container mt-5">
            <h4 class="mb-4 text-center">Add New Staff</h4>
            <form action="{{ route('store.staff') }}" method="POST" enctype="multipart/form-data"
                class="border p-4 bg-light rounded">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 form-group mb-3">
                                <label for="application_date" class="form-label">Application Date: <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="application_date" id="application_date"
                                    class="form-control @error('dob') is-invalid @enderror"
                                    value="{{ old('application_date') }}" required>
                                @error('application_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="joining_date" class="form-label">Joining Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" id="joining_date" name="joining_date"
                                    class=" form-control @error('joining_date') is-invalid @enderror"
                                    value="{{ old('joining_date') }}" required>
                                @error('joining_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="session" class="form-label bold"> Session <span
                                        class="login-danger">*</span></label>
                                <select class="form-control @error('session') is-invalid @enderror" name="session" required>
                                    <option value="">Select Session</option>
                                    @foreach ($data as $session)
                                        <option value="{{ $session->session_date }}">
                                            {{ $session->session_date }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="staff_code" class="form-label">Staff Code <span
                                        class="text-danger">*</span></label>
                                <input type="text" id="staff_code" name="staff_code"
                                    class="form-control @error('staff_code') is-invalid @enderror"
                                    value="{{ old('staff_code') }}" required>
                                @error('staff_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                                <select name="position" id="position"
                                    class="form-control @error('position') is-invalid @enderror" required>
                                    <option value="">Select Position</option>
                                    @foreach (['Director', 'Consultant/Adviser', 'NGO Manager', 'Finance Manager', 'Project Coordinator', 'Master Trainer', 'Trainer', 'Program Officer', 'Project Manager', 'Area Manager', 'Human Resource Management', 'Supervisor', 'Coordinator', 'Computer Operator', 'Head Clerk', 'Assistant Clerk', 'Surveyor', 'Peon', 'Guard', 'Driver', 'Gardener', 'सुबिधा दाता', 'कृषि सखी', 'समूह सखी', 'विकास सखी', 'पशु सखी', 'सवास्थ्य सखी', 'सहयोगी सखी', 'Animator', 'Volunteer'] as $role)
                                        <option value="{{ $role }}"
                                            {{ old('position') == $role ? 'selected' : '' }}>
                                            {{ $role }}</option>
                                    @endforeach
                                </select>
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 col-sm-6  form-group mb-3">
                                <label for="name" class="form-label">Full Name: <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="upload-container">
                            <div class="image-placeholder">
                                <img id="previewImage" alt="Preview">
                                <span id="placeholderText">Upload Photo</span>
                            </div>
                            <label for="uploadInput" class="upload-btn">Choose File</label>
                            <input type="file" id="uploadInput" name="image" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6 form-group mb-3">
                        <label for="dob" class="form-label">Date of Birth: <span class="text-danger">*</span></label>
                        <input type="date" name="dob" id="dob"
                            class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}" required>
                        @error('dob')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 col-sm-6 form-group mb-3">
                        <label for="gender" class="form-label">Gender: <span class="text-danger">*</span></label>
                        <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror"
                            required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>
                                Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>
                                Female
                            </option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>
                                Other</option>
                        </select>
                        @error('gender')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="col-md-4 mb-3">
                        <label for="father_name" class="form-label">Father/Husband Name</label>
                        <input type="text" name="father_name"
                            class="form-control @error('father_name') is-invalid @enderror"
                            value="{{ old('father_name') }}">
                        @error('father_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="marital_status" class="form-label">Marital Status: <span
                                class="text-danger">*</span></label>
                        <select name="marital_status" class="form-control" id="marital_status" required>
                            <option value="">Select Marital Status</option>
                            <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Married
                            </option>
                            <option value="Unmarried" {{ old('marital_status') == 'Unmarried' ? 'selected' : '' }}>
                                Unmarried
                            </option>
                        </select>
                        @error('marital_status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="village" class="form-label">Village/Locality: <span
                                class="text-danger">*</span></label>
                        <input type="text" name="village" id="village"
                            class="form-control @error('village') is-invalid @enderror" value="{{ old('village') }}">
                        @error('village')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="post" class="form-label">Post/Town: <span class="text-danger">*</span></label>
                        <input type="text" name="post" id="post"
                            class="form-control @error('post') is-invalid @enderror" value="{{ old('post') }}"
                            required>
                        @error('post')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="area_type" class="form-label">Area Type: <span class="text-danger">*</span></label>
                        <select name="area_type" class="form-control" id="area_type" required>
                            <option value="" selected></option>
                            <option value="Rular" {{ old('Rular') == 'Rular' ? 'selected' : '' }}>Rular
                            </option>
                            <option value="Urban" {{ old('Urban') == 'Urban' ? 'selected' : '' }}>Urban
                            </option>
                        </select>
                        @error('area_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="block" class="form-label">Block: <span class="text-danger">*</span></label>
                        <input type="text" name="block" id="block"
                            class="form-control @error('block') is-invalid @enderror" value="{{ old('block') }}"
                            required>
                        @error('block')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @php
                        $districtsByState = config('districts');
                    @endphp
                    <div class="col-md-4 form-group mb-3">
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

                    <div class="col-md-4 form-group mb-3">
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

                    <div class="col-md-4 form-group mb-3">
                        <label for="pincode" class="form-label">Pincode: <span class="text-danger">*</span></label>
                        <input type="number" name="pincode" id="pincode"
                            class="form-control @error('pincode') is-invalid @enderror" value="{{ old('pincode') }}">
                        @error('pincode')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="country" class="form-label">Nationality: <span class="text-danger">*</span></label>
                        <select name="country" class="form-control" id="country">
                            <option value=""></option>
                            <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India
                            </option>
                        </select>
                        @error('country')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 col-sm-6 col-sm-12 form-group mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 col-sm-6  form-group mb-3">
                        <label for="phone" class="form-label">Phone: <span class="text-danger">*</span></label>
                        <input type="text" name="phone" id="phone"
                            class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}"
                            maxlength="10" required>
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group local-forms">
                            <label class="form-label">Caste: <span class="text-danger">*</span></label>
                            <input type="text" name="caste" id="caste"
                                class="form-control @error('caste') is-invalid @enderror" value="{{ old('caste') }}"
                                required>
                            @error('caste')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="caste_category" class="form-label">Caste Category <span
                                class="text-danger">*</span></label>
                        <select class="form-select @error('caste_category') is-invalid @enderror" id="category"
                            name="caste_category" required>
                            <option value="" disabled {{ old('caste_category') ? '' : 'selected' }}>
                                Select Category</option>
                            <option value="General" {{ old('caste_category') == 'General' ? 'selected' : '' }}>
                                General
                            </option>
                            <option value="OBC" {{ old('caste_category') == 'OBC' ? 'selected' : '' }}>
                                OBC
                            </option>
                            <option value="SC" {{ old('caste_category') == 'SC' ? 'selected' : '' }}>SC
                            </option>
                            <option value="ST" {{ old('caste_category') == 'ST' ? 'selected' : '' }}>ST
                            </option>
                            <option value="Minority" {{ old('caste_category') == 'Minority' ? 'selected' : '' }}>
                                Minority
                            </option>
                        </select>
                        @error('caste_category')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="religion" class="form-label">Religion <span class="text-danger">*</span></label>
                        <select class="form-select  @error('religion') is-invalid @enderror" id="religion"
                            name="religion" required>
                            <option value="" disabled {{ old('religion') ? '' : 'selected' }}>
                                Select
                                Religion</option>
                            <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>
                                Hindu
                            </option>
                            <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>
                                Islam
                            </option>
                            <option value="Christian" {{ old('religion') == 'Christian' ? 'selected' : '' }}>
                                Christian
                            </option>
                            <option value="Sikh" {{ old('religion') == 'Sikh' ? 'selected' : '' }}>
                                Sikh
                            </option>
                            <option value="Buddhist" {{ old('religion') == 'Buddhist' ? 'selected' : '' }}>
                                Buddhist
                            </option>
                            <option value="Parsi" {{ old('religion') == 'Parsi' ? 'selected' : '' }}>
                                Parsi
                            </option>
                        </select>
                        @error('religion')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="occupation" class="form-label">Occupation: <span class="text-danger">*</span></label>
                        <input type="text" name="occupation" id="occupation"
                            class="form-control @error('occupation') is-invalid @enderror"
                            value="{{ old('occupation') }}" required>
                        @error('occupation')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Identity Type -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="identity_type" class="form-label">Identity Type: <span
                                    class="text-danger">*</span></label>
                            <select class="form-control" id="identity_type" name="identity_type" required>
                                <option selected disabled>Select Identity Type</option>
                                <option value="Aadhar Card" {{ old('identity_type') == 'Aadhar Card' ? 'selected' : '' }}>
                                    Aadhar Card
                                </option>
                                <option value="Voter ID Card"
                                    {{ old('identity_type') == 'Voter ID Card' ? 'selected' : '' }}>
                                    Voter ID
                                    Card
                                </option>
                                <option value="Pan Card" {{ old('identity_type') == 'Pan Card' ? 'selected' : '' }}>Pan
                                    Card
                                </option>
                                <option value="Markshhet" {{ old('identity_type') == 'Markshhet' ? 'selected' : '' }}>
                                    Markshhet
                                </option>
                                <option value="Driving License"
                                    {{ old('identity_type') == 'Driving License' ? 'selected' : '' }}>
                                    Driving
                                    License</option>
                                <option value="Narega Card" {{ old('identity_type') == 'Narega Card' ? 'selected' : '' }}>
                                    Narega Card
                                </option>
                                <option value="Ration Card" {{ old('identity_type') == 'Ration Card' ? 'selected' : '' }}>
                                    Ration Card
                                </option>
                            </select>
                            @error('identity_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <!-- Identity Number -->
                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="identity_no" class="form-label">Identity Card Number: <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="identity_no" name="identity_no"
                                placeholder="Enter Identity Card No" required>
                            <small id="identity_no_hint" class="form-text text-muted"></small>
                            @error('identity_no')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="eligibility" class="form-label">Eligibility / Education Level:
                            <span class="text-danger">*</span>
                        </label>
                        <select name="eligibility" class="form-control" id="eligibility" required>
                            <option value="">Select Education Level</option>
                            <option value="Uneducated" {{ old('eligibility') == 'Uneducated' ? 'selected' : '' }}>
                                Uneducated
                            </option>
                            <option value="Literate" {{ old('eligibility') == 'Literate' ? 'selected' : '' }}>
                                Literate</option>
                            <option value="Nursery" {{ old('eligibility') == 'Nursery' ? 'selected' : '' }}>
                                Nursery</option>
                            <option value="Below Primary" {{ old('eligibility') == 'Below Primary' ? 'selected' : '' }}>
                                Below
                                Primary
                            </option>
                            {{-- <option value="Primary Failed" {{ old('eligibility') == 'Primary Failed' ? 'selected' : '' }}>
                                Primary Failed
                            </option> --}}
                            <option value="Primary Passed" {{ old('eligibility') == 'Primary Passed' ? 'selected' : '' }}>
                                Primary Passed
                            </option>
                            <option value="Below Middle" {{ old('eligibility') == 'Below Middle' ? 'selected' : '' }}>
                                Below
                                Middle
                            </option>
                            {{-- <option value="Middle Failed" {{ old('eligibility') == 'Middle Failed' ? 'selected' : '' }}>
                                Middle
                                Failed
                            </option> --}}
                            <option value="Middle Passed" {{ old('eligibility') == 'Middle Passed' ? 'selected' : '' }}>
                                Middle
                                Passed
                            </option>
                            <option value="Highschool" {{ old('eligibility') == 'Highschool' ? 'selected' : '' }}>
                                Highschool
                            </option>
                            <option value="Intermediate" {{ old('eligibility') == 'Intermediate' ? 'selected' : '' }}>
                                Intermediate</option>
                            <option value="B.A." {{ old('eligibility') == 'B.A.' ? 'selected' : '' }}>
                                B.A.
                            </option>
                            <option value="B.Sc." {{ old('eligibility') == 'B.Sc.' ? 'selected' : '' }}>
                                B.Sc.
                            </option>
                            <option value="B.Com." {{ old('eligibility') == 'B.Com.' ? 'selected' : '' }}>
                                B.Com.
                            </option>
                            <option value="B.Tech." {{ old('eligibility') == 'B.Tech.' ? 'selected' : '' }}>
                                B.Tech.
                            </option>
                            <option value="M.A." {{ old('eligibility') == 'M.A.' ? 'selected' : '' }}>
                                M.A.
                            </option>
                            <option value="M.Sc." {{ old('eligibility') == 'M.Sc.' ? 'selected' : '' }}>
                                M.Sc.
                            </option>
                            <option value="M.Com." {{ old('eligibility') == 'M.Com.' ? 'selected' : '' }}>
                                M.Com.
                            </option>
                            <option value="M.Tech." {{ old('eligibility') == 'M.Tech.' ? 'selected' : '' }}>
                                M.Tech.
                            </option>
                            <option value="Other" {{ old('eligibility') == 'Other' ? 'selected' : '' }}>
                                Other
                            </option>
                        </select>
                        @error('eligibility')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="degree" class="form-label">Degree</label>
                        <input type="text" name="degree" class="form-control @error('degree') is-invalid @enderror"
                            value="{{ old('degree') }}">
                        @error('degree')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="experience" class="form-label">Experience</label>
                        <input type="text" name="experience"
                            class="form-control @error('experience') is-invalid @enderror"
                            value="{{ old('experience') }}">
                        @error('experience')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="form-group">
                            <label for="staff_password" class="form-label"><strong>New Password</strong>
                                <span class="text-danger">*</span></label>

                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" value="" placeholder="Enter Password">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                        <i class="fa fa-eye" id="eyeIcon"></i> <!-- Eye Icon -->
                                    </span>
                                </div>
                            </div>

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="id_document" class="form-label">Upload ID Document</label>
                        <input type="file" name="id_document"
                            class="form-control @error('id_document') is-invalid @enderror">
                        @error('id_document')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="experience_document" class="form-label">Experience Document</label>
                        <input type="file" name="experience_document"
                            class="form-control @error('experience_document') is-invalid @enderror">
                        @error('experience_document')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="marksheet" class="form-label">Marksheet Upload</label>
                        <input type="file" name="marksheet"
                            class="form-control @error('marksheet') is-invalid @enderror">
                        @error('marksheet')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="mb-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="select-all-permissions">
                            <label class="form-check-label fw-bold" for="select-all-permissions">
                                Select All Permissions
                            </label>
                        </div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="permissions" class="form-label fw-bold">Select Staff Permissions</label>
                        <select id="permissions" class="form-select" size="10">
                            <optgroup label="Activity">
                                <option value="add-activity">Add Activity</option>
                                <option value="activity-list">Activity List</option>
                            </optgroup>

                            <optgroup label="Event">
                                <option value="add-event">Add Event</option>
                                <option value="event-list">Event List</option>
                            </optgroup>

                            <optgroup label="Setting">
                                <option value="add-working-area">Add Working Area</option>
                                <option value="working-area-list">Working Area List</option>
                                {{-- <option value="signature">Signature</option> --}}
                                <option value="course-list">Course List</option>
                                <option value="add-course-centre">Add Course For Centre</option>
                            </optgroup>

                            <optgroup label="Registration">
                                <option value="new-registration">New Registration</option>
                                <option value="pending-registration">Pending Registration</option>
                                <option value="approve-registration">Approve Registration</option>
                                <option value="recover-registration">Deleted Registration</option>
                                <option value="reg-setting">Online Registration Setting</option>
                            </optgroup>

                            <optgroup label="Beneficiaries">
                                <option value="beneficiarie-add">Survey Add Beneficiary List</option>
                                {{-- <option value="survey-received-list">Survey Received List</option> --}}
                                <option value="demand-facilities">Demand Beneficiary Facilities</option>
                                <option value="approval-facilities">Approval Demand Distribute Facilities List
                                </option>
                                <option value="distributed-list">Distributed Beneficiary Facilities List</option>
                                <option value="pending-distribute">Pending Beneficiary Facilities List</option>
                                <option value="all-beneficiarie-list">All Beneficiary List</option>
                            </optgroup>

                            <optgroup label="Donation">
                                <option value="donation">Deposit Donations</option>
                                <option value="donation-list">Donations List</option>
                                <option value="online-donor-list">Online Donations List</option>
                                <option value="donation-card-list">Donation Card</option>
                                <option value="all-donor-list">All Donation List</option>
                                <option value="donation-report">Donations Report</option>
                            </optgroup>

                            <optgroup label="Staff">
                                <option value="add-staff">Add Staff</option>
                                <option value="staff-list">Staff List</option>
                                <option value="appointment-letter">Staff Appointment Letter</option>
                                <option value="resign-letter">Staff Resign Letter</option>
                                <option value="staff-salary">Staff Salary</option>
                                <option value="staff-idcard">Staff ID Card</option>
                                <option value="staff-passbook">Staff Passbook</option>
                                <option value="staff-activity">Staff Activity</option>
                            </optgroup>

                            <optgroup label="Membership">
                                <option value="member-list">Member List</option>
                                <option value="add-member-position">Add Member Position</option>
                                <option value="member-position-list">Member Position List</option>
                                <option value="member-activity">Member Activity</option>
                                <option value="active-members">Active Members</option>
                                <option value="inactive-members">Unactive Members</option>
                            </optgroup>

                            <optgroup label="Promote">
                                <option value="promote-membership">Promote Membership</option>
                                <option value="promote-beneficiary">Promote Beneficiary</option>
                                <option value="promote-staff">Promote Staff</option>
                            </optgroup>

                            <optgroup label="Certificate">
                                <option value="add-member-certificate">Add Member Certificate</option>
                                <option value="member-certificate-list">Member Certificate List</option>
                                <option value="add-beneficiary-certificate">Add Beneficiary Certificate</option>
                                <option value="beneficiary-certificate-list">Beneficiary Certificate List</option>
                            </optgroup>

                            <optgroup label="Letter">
                                <option value="generate-letter">Generate Letter</option>
                                <option value="letter-list">Letter List</option>
                            </optgroup>

                            <optgroup label="Training">
                                <option value="add-center">Add Training Centre</option>
                                <option value="center-list">Training Centre List</option>
                                <option value="training-demand-bene">Training Demand Beneficiary</option>
                                <option value="approve-training-demand">Approve Training Demand</option>
                                <option value="generate-training-certi">Generate Training Certificate</option>
                                <option value="training-certi-list">Training Certificate List</option>
                                <option value="exam-time-table">Exam Time Table</option>
                            </optgroup>

                            <optgroup label="Download">
                                <option value="beneficiary-idcard">Beneficiary ID Card</option>
                                <option value="member-idcard">Member ID Card</option>
                                <option value="donor-idcard">Donor ID Card</option>
                                <option value="beneficiary-admit">Beneficiary Admit Card</option>
                                <option value="beneficiary-desk-slip">Beneficiary Desk Slip</option>
                                <option value="beneficiary-cc-noc">Beneficiary CC & NOC</option>
                            </optgroup>

                            <optgroup label="Attendance">
                                <option value="beneficiary-attendance">Beneficiary Attendance</option>
                                <option value="staff-attendance">Staff Attendance</option>
                            </optgroup>

                            <optgroup label="Complaint">
                                <option value="beneficiary-complaint">Beneficiary Complaint</option>
                                <option value="staff-complaint">Staff Complaint</option>
                                <option value="service-complaint">Service Complaint</option>
                            </optgroup>

                            <optgroup label="Stock">
                                <option value="add-stock">Add Stock</option>
                                <option value="stock-list">Stock List</option>
                            </optgroup>

                            <optgroup label="Cost">
                                <option value="add-bill">Feed Bill/Voucher</option>
                                <option value="bill-list">Bill List</option>
                                <option value="generate-bill">Generate Bill</option>
                                <option value="gbs-bill-list">GBS Person Bill List</option>
                                <option value="sanstha-bill-list">GBS Sanstha Bill List</option>
                            </optgroup>

                            <optgroup label="Cash Book">
                                <option value="daily-report">Daily Report</option>
                                <option value="date-wise-report">Date-wise Report</option>
                                <option value="remaining-amount">Remaining Amount</option>
                                <option value="year-wise-report">Year-wise Report</option>
                            </optgroup>

                            <optgroup label="Gallery">
                                <option value="add-photos">Add Photos</option>
                                <option value="gallery-list">Manage Gallery</option>
                            </optgroup>

                            <optgroup label="Social Problem">
                                <option value="discover-problems">Discover Social Problems</option>
                                <option value="problem-list">Problem List</option>
                                <option value="solutions">Solutions</option>
                                <option value="solutions-list">Solutions List</option>
                            </optgroup>

                            <optgroup label="Work Plan">
                                <option value="add-workplan">Add Work Plan</option>
                                <option value="workplan-list">Work Plan List</option>
                            </optgroup>

                            <optgroup label="Notice">
                                <option value="add-notice">Add Notice</option>
                                <option value="notice-list">Notice List</option>
                            </optgroup>
                        </select>
                    </div>
                    <!-- Display selected permissions as tags -->
                    <div class="mb-3 col-md-6">
                        <label class="form-label fw-bold">Selected Permissions</label>
                        <div id="selected-permissions" class="border rounded p-2 bg-light d-flex flex-wrap gap-2"
                            style="min-height: 40px;">
                            <small class="text-muted">No permissions selected</small>
                        </div>
                    </div>

                    <!-- Hidden inputs to send selected values -->
                    <div id="hidden-permissions"></div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>
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
            const identityType = document.getElementById('identity_type');
            const identityNo = document.getElementById('identity_no');
            const hint = document.getElementById('identity_no_hint');

            identityType.addEventListener('change', function() {
                const type = this.value;
                let pattern = '';
                let message = '';

                switch (type) {
                    case 'Aadhar Card':
                        pattern = '^[2-9]{1}[0-9]{11}$';
                        message = 'Enter 12-digit Aadhar Number.';
                        break;
                    case 'Voter ID Card':
                        pattern = '^[A-Z]{3}[0-9]{7}$';
                        message = 'Enter valid Voter ID (e.g., ABC1234567).';
                        break;
                    case 'Pan Card':
                        pattern = '^[A-Z]{5}[0-9]{4}[A-Z]{1}$';
                        message = 'Enter valid PAN number (e.g., ABCDE1234F).';
                        break;
                    case 'Driving License':
                        pattern = '^[A-Z]{2}[0-9]{2} ?[0-9]{11}$';
                        message = 'Enter valid Driving License number (e.g., RJ14 12345678901).';
                        break;
                    case 'Markshhet':
                    case 'Narega Card':
                    case 'Ration Card':
                        pattern = '^[a-zA-Z0-9/-]{5,20}$';
                        message = 'Enter a valid number (alphanumeric, 5-20 chars).';
                        break;
                    default:
                        pattern = '';
                        message = '';
                }

                identityNo.setAttribute('pattern', pattern);
                identityNo.setCustomValidity('');
                hint.textContent = message;
            });

            // Optional: Prevent form submission if invalid
            document.querySelector('form').addEventListener('submit', function(e) {
                if (!identityNo.checkValidity()) {
                    e.preventDefault();
                    identityNo.reportValidity();
                }
            });
        });
    </script>
    <script>
        const permissionSelect = document.getElementById('permissions');
        const selectedContainer = document.getElementById('selected-permissions');
        const hiddenInputsContainer = document.getElementById('hidden-permissions');
        const positionSelect = document.getElementById('position');
        const selectAllCheckbox = document.getElementById('select-all-permissions');

        let selectedPermissions = new Set();

        function updateSelectedUI() {
            selectedContainer.innerHTML = '';
            hiddenInputsContainer.innerHTML = '';

            if (selectedPermissions.size === 0) {
                selectedContainer.innerHTML = '<small class="text-muted">No permissions selected</small>';
                return;
            }

            selectedPermissions.forEach(value => {
                // Create badge
                const badge = document.createElement('span');
                badge.className = 'badge bg-success d-flex align-items-center';
                badge.style.gap = '8px';

                badge.innerHTML = `
                <span>${value.label}</span>
                <button type="button" class="btn-close btn-close-white btn-sm" aria-label="Remove"></button>
            `;

                // Remove handler
                badge.querySelector('button').addEventListener('click', () => {
                    selectedPermissions.delete(value);
                    updateSelectedUI();
                    selectAllCheckbox.checked = false; // Uncheck Select All if any are removed manually
                });

                selectedContainer.appendChild(badge);

                // Add hidden input
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'staff_permissions[]';
                input.value = value.value;
                hiddenInputsContainer.appendChild(input);
            });
        }

        permissionSelect.addEventListener('change', () => {
            const selectedOption = permissionSelect.options[permissionSelect.selectedIndex];
            const value = selectedOption.value;
            const label = selectedOption.textContent.trim();

            if (![...selectedPermissions].some(p => p.value === value)) {
                selectedPermissions.add({
                    value,
                    label
                });
            }

            updateSelectedUI();
            permissionSelect.selectedIndex = -1; // reset selection
        });

        const allPermissionOptions = Array.from(permissionSelect.options).filter(opt => opt.value);

        const getPermissionsByLabel = (label) => {
            return allPermissionOptions.filter(opt => {
                return opt.closest('optgroup')?.label === label;
            });
        };

        const getAllPermissions = () => {
            return allPermissionOptions;
        };

        function addPermissions(permissions) {
            permissions.forEach(opt => {
                const value = opt.value;
                const label = opt.textContent.trim();
                if (![...selectedPermissions].some(p => p.value === value)) {
                    selectedPermissions.add({
                        value,
                        label
                    });
                }
            });
            updateSelectedUI();
        }

        // Auto-select based on position
        positionSelect.addEventListener('change', function() {
            const position = this.value;
            selectedPermissions.clear(); // reset on position change
            selectAllCheckbox.checked = false;

            if (['Director', 'NGO Manager'].includes(position)) {
                addPermissions(getAllPermissions());
            } else if (['Trainer', 'Master Trainer'].includes(position)) {
                addPermissions(getPermissionsByLabel('Training'));
            }

            updateSelectedUI();
        });

        // Manual Select All
        selectAllCheckbox.addEventListener('change', function() {
            if (this.checked) {
                addPermissions(getAllPermissions());
            } else {
                selectedPermissions.clear();
                updateSelectedUI();
            }
        });

        // Auto-run if editing existing staff (position pre-selected)
        window.addEventListener('DOMContentLoaded', () => {
            if (positionSelect.value) {
                const event = new Event('change');
                positionSelect.dispatchEvent(event);
            }
        });
    </script>


    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        togglePassword.addEventListener('click', function(e) {
            // Toggle the password field type
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;

            // Toggle eye icon
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection
