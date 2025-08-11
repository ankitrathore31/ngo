@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-items-center mb-1 mt-2">
            <h5 class="mb-0">Add Vendor</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-1 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Bill/Voucher</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container">
            <form action="">
                <div class="row">
                    <h5 class="mb-2">- Vendor/Shop/Farm/Name Deatails</h5>
                    <div class=" col-sm-4 mb-3">
                        <label for="shop">Vendor/Shop/Farm Registration no:</label>
                        <input type="text" id="shop" name="shop" class="form-control" value="{{ old('shop') }}"
                         value=""   required>
                        @error('shop')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class=" col-sm-4 mb-3">
                        <label for="shop">Vendor/Shop/Farm Registration Date:</label>
                        <input type="text" id="shop" name="shop" class="form-control" value="{{ old('shop') }}"
                            required>
                        @error('shop')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class=" col-sm-4 mb-3">
                        <label for="shop">Vendor/Shop/Farm:</label>
                        <input type="text" id="shop" name="shop" class="form-control" value="{{ old('shop') }}"
                            required>
                        @error('shop')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="role" class="label">Vendor Type</label>
                        <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                            <option value="">Select Role</option>
                            <option value="Proprietor" {{ old('role') == 'Proprietor' ? 'selected' : '' }}>Proprietor
                            </option>
                            <option value="Owner" {{ old('role') == 'Owner' ? 'selected' : '' }}>Owner</option>
                            <option value="Partner" {{ old('role') == 'Partner' ? 'selected' : '' }}>Partner</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="name">Seller Type Name:</label>
                        <input type="text" id="s_name" name="s_name" class="form-control"
                            value="{{ old('s_name') }}" required>
                        @error('s_name')
                            <small class="text-danger">{{ $message }}</small>
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
                            class="form-control @error('post') is-invalid @enderror" value="{{ old('post') }}" required>
                        @error('post')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="block" class="form-label">Block: <span class="text-danger">*</span></label>
                        <input type="text" name="block" id="block"
                            class="form-control @error('block') is-invalid @enderror" value="{{ old('block') }}" required>
                        @error('block')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @php
                        $districtsByState = config('districts');
                    @endphp
                    <div class="col-md-4 form-group mb-3">
                        <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label>
                        <select class="form-control @error('state') is-invalid @enderror" name="state" id="stateSelect"
                            required>
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

                    <div class=" col-sm-4 mb-3">
                        <label for="mobile">Mobile:</label>
                        <input type="text" id="s_mobile" name="s_mobile" class="form-control"
                            value="{{ old('s_mobile') }}" required>
                        @error('s_mobile')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class=" col-sm-4 mb-3">
                        <label for="email">Email:</label>
                        <input type="text" id="s_email" name="s_email" class="form-control"
                            value="{{ old('s_email') }}" required>
                        @error('s_email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="gst_type">Vendor/Shop/Farm Gst:</label>
                        <select id="gst_type" name="gst_type"
                            class="form-select @error('gst_type') is-invalid @enderror" onchange="toggleSingleGstInput()">
                            <option value="">Select</option>
                            <option value="Yes" {{ old('gst_type') == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ old('gst_type') == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>


                    <div id="gst_input_wrapper" class="col-sm-4 mb-3" style="display: none;">
                        <label for="gst">Vendor/Shop/Farm GST</label>
                        <input type="number" name="gst" id="gst" class="form-control"
                            value="{{ old('gst', 0) }}">
                        <label for="gst">Operator GST</label>
                        <input type="number" name="gst" id="gst" class="form-control"
                            value="{{ old('gst', 0) }}">
                    </div>

                    <div class="col-md-4">
                        Vendor/Shop/Farm gst upload
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="pancard_type">PAN Card:</label>
                        <select id="pancard_type" name="pancard_type"
                            class="form-select @error('pancard_type') is-invalid @enderror" onchange="toggleGstInput()">
                            <option value="">Select</option>
                            <option value="Yes" {{ old('pancard_type') == 'Yes' ? 'selected' : '' }}>Yes</option>
                            <option value="No" {{ old('pancard_type') == 'No' ? 'selected' : '' }}>No</option>
                        </select>
                    </div>

                    <div id="pancard_input_wrapper" class="col-sm-4 mb-3" style="display: none;">
                        <label for="pancard">Vendor/Shop/Farm PAN Card Number:</label>
                        <input type="text" name="s_pan" id="pancard" class="form-control"
                            value="{{ old('pancard') }}">
                        <label for="pancard">Operator PAN Card Number:</label>
                        <input type="text" name="s_pan" id="pancard" class="form-control"
                            value="{{ old('pancard') }}">
                    </div>

                    <div class="col-md-4">
                        Vendor/Shop/Farm pan upload
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
