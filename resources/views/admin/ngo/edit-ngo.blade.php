@extends('admin.layout.AdminLayout')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb -->
            <div class="row d-flex justify-content-end m-4">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href=" {{-- route('admin') --}}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Ngo</li>
                        </ol>
                    </nav>
                </div>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="container-fluid">
                <div class="card shadow-sm round-lg">

                    <div class="card-body">
                        <form method="POST" action="{{ route('update-ngo', $ngo->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="border-bottom pb-3 mb-3">
                                <h4 class="p-3"><strong>NGO DETAILS</strong></h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="established_date" class="form-label"><strong>Established
                                                        Year</strong> <span class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control datepicker @error('established_date') is-invalid @enderror"
                                                    id="established_date" name="established_date" placeholder="DD-MM-YYYY"
                                                    value="{{ $ngo->established_date }}">
                                                @error('established_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="ngo_name" class="form-label"><strong>NGO Name</strong> <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control @error('ngo_name') is-invalid @enderror"
                                                    id="ngo_name" name="ngo_name" placeholder="Enter NGO Name"
                                                    value="{{ $ngo->ngo_name }}">
                                                @error('ngo_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="col-md-4 mb-3">
                                                <label for="founder_name" class="form-label"><strong>Founder
                                                        Name</strong></label>
                                                <input type="text"
                                                    class="form-control @error('founder_name') is-invalid @enderror"
                                                    id="founder_name" name="founder_name" placeholder="Enter Founder Name"
                                                    value="{{ $ngo->founder_name }}">
                                                @error('founder_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="email" class="form-label"><strong>Email</strong></label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" placeholder="Enter Email" value="{{ $ngo->email }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                            <div class="col-md-4 mb-3">
                                                <label for="phone_number" class="form-label"><strong>Mobile Number</strong>
                                                    <span class="text-danger">*</span></label>
                                                <input type="number"
                                                    class="form-control @error('phone_number') is-invalid @enderror"
                                                    id="phone_number" name="phone_number" placeholder="Enter Number"
                                                    value="{{ $ngo->phone_number }}">
                                                @error('phone_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="country" class="form-label"><strong>Country</strong></label>
                                                <input type="text"
                                                    class="form-control @error('country') is-invalid @enderror"
                                                    id="country" name="country" placeholder="Enter Country"
                                                    value="{{ $ngo->country }}">
                                                @error('country')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="address" class="form-label"><strong>Address</strong></label>
                                                <input type="text" class="form-control " id="address" name="address"
                                                    placeholder="Enter Village/Locality Name" value="{{ $ngo->address }}">
                                                @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="post" class="form-label"><strong>Post/Town</strong></label>
                                                <input type="text" class="form-control" id="post" name="post"
                                                    placeholder="Enter Post/Town/City Name" value="{{ $ngo->post }}">
                                                {{-- @error('post')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror --}}
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="district" class="form-label"><strong>District</strong></label>
                                                <input type="text"
                                                    class="form-control @error('district') is-invalid @enderror"
                                                    id="district" name="district" placeholder="Enter District Name"
                                                    value="{{ $ngo->district }}">
                                                @error('district')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="pin_code" class="form-label"><strong>Pincode</strong></label>
                                                <input type="number"
                                                    class="form-control @error('pin_code') is-invalid @enderror"
                                                    id="pin_code" name="pin_code" placeholder="Enter Pincode"
                                                    value="{{ $ngo->pin_code }}">
                                                @error('pin_code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="state" class="form-label"><strong>State</strong></label>
                                                <select name="state"
                                                    class="form-control select2 @error('state') is-invalid @enderror">
                                                    <option selected disabled>Select State</option>

                                                    @php
                                                        $states = [
                                                            'Andhra Pradesh',
                                                            'Arunachal Pradesh',
                                                            'Assam',
                                                            'Bihar',
                                                            'Chhattisgarh',
                                                            'Goa',
                                                            'Gujarat',
                                                            'Haryana',
                                                            'Himachal Pradesh',
                                                            'Jharkhand',
                                                            'Karnataka',
                                                            'Kerala',
                                                            'Madhya Pradesh',
                                                            'Maharashtra',
                                                            'Manipur',
                                                            'Meghalaya',
                                                            'Mizoram',
                                                            'Nagaland',
                                                            'Odisha',
                                                            'Punjab',
                                                            'Rajasthan',
                                                            'Sikkim',
                                                            'Tamil Nadu',
                                                            'Telangana',
                                                            'Tripura',
                                                            'Uttar Pradesh',
                                                            'Uttarakhand',
                                                            'West Bengal',
                                                            'Andaman and Nicobar Islands',
                                                            'Chandigarh',
                                                            'Dadra and Nagar Haveli and Daman and Diu',
                                                            'Lakshadweep',
                                                            'Delhi',
                                                            'Puducherry',
                                                            'Ladakh',
                                                            'Jammu and Kashmir',
                                                        ];
                                                    @endphp

                                                    @foreach ($states as $state)
                                                        <option value="{{ $state }}"
                                                            {{ old('state', $ngo->state ?? '') == $state ? 'selected' : '' }}>
                                                            {{ $state }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error('state')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3 form-group">
                                        <label for="package" class="form-label"><strong>Package</strong></label>
                                        <select class="form-control select2 @error('package') is-invalid @enderror"
                                            name="package" id="package">
                                            <option value="" selected disabled>Select Package</option>

                                            @php
                                                $packages = ['Trial', 'Basic', 'Advance'];
                                            @endphp

                                            @foreach ($packages as $package)
                                                <option value="{{ $package }}"
                                                    {{ old('package', $ngo->package ?? '') == $package ? 'selected' : '' }}>
                                                    {{ $package }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('package')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="staff_password" class="form-label"><strong>Password</strong>
                                                <span class="text-danger">*</span></label>

                                            <div class="input-group">
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password"
                                                    value="{{ old('password', $password ?? '') }}" 
                                                placeholder="Enter Password">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="togglePassword"
                                                        style="cursor: pointer;">
                                                        <i class="fa fa-eye" id="eyeIcon"></i> <!-- Eye Icon -->
                                                    </span>
                                                </div>
                                            </div>

                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="upload-container">
                                            <label for="ngo_logo" class="form-label"><strong>Upload
                                                    Logo</strong></label>
                                            <input type="file" id="logo" value="{{ $ngo->logo }}"
                                                class="form-control" name="logo" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="" class="form-label">Uploaded Logo</label><br>
                                        <img src="{{ asset('images/' . $ngo->logo) }}" alt="logo image"
                                            style="width: 150px; height: auto;">
                                    </div>


                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-2 mt-3">
                                    <div class="form-group ">
                                        <button type="submit" name="submit"
                                            class="btn btn-success w-50">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function() {
            let successAlert = document.getElementById('successMessage');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
        }, 3000); // 3 seconds
    </script>
    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
    
        togglePassword.addEventListener('click', function (e) {
            // Toggle the password field type
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
    
            // Toggle eye icon
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection
