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
                        <form method="POST" action="{{ route('save-ngo') }}" enctype="multipart/form-data">
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
                                                    value="{{ old('established_date') }}">
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
                                                    value="{{ old('ngo_name') }}">
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
                                                    value="{{ old('founder_name') }}">
                                                @error('founder_name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="email" class="form-label"><strong>Email</strong></label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="email" name="email" placeholder="Enter Email"
                                                    value="{{ old('email') }}">
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
                                                    value="{{ old('phone_number') }}">
                                                @error('phone_number')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="country" class="form-label"><strong>Country</strong></label>
                                                <input type="text"
                                                    class="form-control @error('country') is-invalid @enderror"
                                                    id="country" name="country" placeholder="Enter Country"
                                                    value="{{ old('country') }}">
                                                @error('country')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="address" class="form-label"><strong>Address</strong></label>
                                                <input type="text" class="form-control " id="address" name="address"
                                                    placeholder="Enter Village/Locality Name" value="{{ old('address') }}">
                                                {{-- @error('address')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror --}}
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="post" class="form-label"><strong>Post/Town</strong></label>
                                                <input type="text" class="form-control" id="post" name="post"
                                                    placeholder="Enter Post/Town/City Name" value="{{ old('post') }}">
                                                {{-- @error('post')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror --}}
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="district" class="form-label"><strong>District</strong></label>
                                                <input type="text"
                                                    class="form-control @error('district') is-invalid @enderror"
                                                    id="district" name="district" placeholder="Enter District Name"
                                                    value="{{ old('district') }}">
                                                @error('district')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="pin_code" class="form-label"><strong>Pincode</strong></label>
                                                <input type="number"
                                                    class="form-control @error('pin_code') is-invalid @enderror"
                                                    id="pin_code" name="pin_code" placeholder="Enter Pincode"
                                                    value="{{ old('pin_code') }}">
                                                @error('pin_code')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label for="state" class="form-label"><strong>State</strong></label>
                                                <select name="state"
                                                    class="form-control select2 @error('state') is-invalid @enderror">
                                                    <option selected disabled></option>
                                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                    <option value="Assam">Assam</option>
                                                    <option value="Bihar">Bihar</option>
                                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                                    <option value="Goa">Goa</option>
                                                    <option value="Gujarat">Gujarat</option>
                                                    <option value="Haryana">Haryana</option>
                                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                    <option value="Jharkhand">Jharkhand</option>
                                                    <option value="Karnataka">Karnataka</option>
                                                    <option value="Kerala">Kerala</option>
                                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                    <option value="Maharashtra">Maharashtra</option>
                                                    <option value="Manipur">Manipur</option>
                                                    <option value="Meghalaya">Meghalaya</option>
                                                    <option value="Mizoram">Mizoram</option>
                                                    <option value="Nagaland">Nagaland</option>
                                                    <option value="Odisha">Odisha</option>
                                                    <option value="Punjab">Punjab</option>
                                                    <option value="Rajasthan">Rajasthan</option>
                                                    <option value="Sikkim">Sikkim</option>
                                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                                    <option value="Telangana">Telangana</option>
                                                    <option value="Tripura">Tripura</option>
                                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                                    <option value="Uttarakhand">Uttarakhand</option>
                                                    <option value="West Bengal">West Bengal</option>
                                                    <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands
                                                    </option>
                                                    <option value="Chandigarh">Chandigarh</option>
                                                    <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and
                                                        Nagar
                                                        Haveli and Daman and Diu</option>
                                                    <option value="Lakshadweep">Lakshadweep</option>
                                                    <option value="Delhi">Delhi</option>
                                                    <option value="Puducherry">Puducherry</option>
                                                    <option value="Ladakh">Ladakh</option>
                                                    <option value="Lakshadweep">Lakshadweep</option>
                                                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
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
                                        <label for="" class="form-label"><strong>Package</strong></label>
                                        <select class="form-control select2  @error('package') is-invalid @enderror"
                                            name="package" id="">
                                            <option value="" selected>Select Package</option>
                                            <option value="Trial">Trial</option>
                                            <option value="Basic">Basic</option>
                                            <option value="Advance">Advance</option>
                                        </select>
                                        @error('package')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="staff_password" class="form-label"><strong>Password</strong>
                                                <span class="text-danger">*</span></label>
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                id="password" name="password" placeholder="Enter Password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="upload-container">
                                            <label for="ngo_logo" class="form-label"><strong>Upload
                                                    Logo</strong></label>
                                            <input type="file" id="logo" class="form-control" name="logo"
                                                accept="image/*">
                                        </div>
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
    
@endsection
