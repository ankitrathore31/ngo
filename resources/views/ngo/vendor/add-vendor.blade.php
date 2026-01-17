@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-items-center mb-1 mt-2">
            <h5 class="mb-0">Add Vendor</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-1 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Vendor</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container mt-5">
            <div class="card-body mb-3 shadow p-2 bg-light">
                <form action="{{ route('store.vendor') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <h5 class="mb-4 mt-2">- Vendor/Shop/Farm/Name Deatails</h5>
                        <div class="col-md-4 mb-3">
                            <label for="academic_session" class=" bold">Session <span class="login-danger">*</span></label>
                            <select class="form-control @error('academic_session') is-invalid @enderror"
                                name="academic_session" id="academic_session" required>
                                <option value="">Select Session</option>
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ old('academic_session') == $session->session_date ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                            @error('academic_session')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class=" col-sm-4 mb-3">
                            <label for="registration_no">Vendor/Shop/Farm Registration no:</label>
                            <input type="text" id="registration_no" name="registration_no" class="form-control"
                                value="{{ old('registration_no', $nextRegistrationNo) }}" readonly required>
                            @error('registration_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class=" col-sm-4 mb-3">
                            <label for="registration_date">Vendor/Shop/Farm Registration Date:</label>
                            <input type="date" id="registration_date" name="registration_date" class="form-control"
                                value="{{ old('registration_date') }}" required>
                            @error('registration_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class=" col-sm-4 mb-3">
                            <label for="shop">Vendor/Shop/Farm:</label>
                            <input type="text" id="shop" name="shop" class="form-control"
                                value="{{ old('shop') }}" required>
                            @error('shop')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class=" col-sm-4 mb-3">
                            <label for="vendor_type" class="label">Vendor Type</label>
                            <select name="vendor_type" id="vendor_type"
                                class="form-select @error('vendor_type') is-invalid @enderror">
                                <option value="">Select Role</option>
                                <option value="Proprietor" {{ old('vendor_type') == 'Proprietor' ? 'selected' : '' }}>
                                    Proprietor
                                </option>
                                <option value="Owner" {{ old('vendor_type') == 'Owner' ? 'selected' : '' }}>Owner</option>
                                <option value="Partner" {{ old('vendor_type') == 'Partner' ? 'selected' : '' }}>Partner
                                </option>
                            </select>
                            @error('vendor_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class=" col-sm-4 mb-3">
                            <label for="name">Seller Type Name:</label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ old('name') }}" required>
                            @error('name')
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
                                class="form-control @error('post') is-invalid @enderror" value="{{ old('post') }}"
                                required>
                            @error('post')
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

                        <div class=" col-sm-4 mb-3">
                            <label for="mobile">Mobile:</label>
                            <input type="text" id="mobile" name="mobile" class="form-control"
                                value="{{ old('mobile') }}" max="10" required>
                            @error('mobile')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class=" col-sm-4 mb-3">
                            <label for="email">Email:</label>
                            <input type="text" id="email" name="email" class="form-control"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 mt-2">
                        <div id="gst_input_wrapper" class="col-sm-6 mb-3">
                            <label for="gst">Vendor/Shop/Farm GST</label>
                            <input type="text" name="shop_gst_no" id="gst" class="form-control"
                                value="{{ old('gst') }}">
                        </div>

                        <div class="col-sm-6 mb-2">
                            <label for="gst">Operator GST</label>
                            <input type="text" name="operator_gst_no" id="gst" class="form-control"
                                value="{{ old('gst') }}">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="">Shop Gst Upload</label>
                            <input type="file" name="shop_gst" id=""accept="image/*,application/pdf"
                                capture="environment" class="form-control @error('shop_gst') is in-valid @enderror">
                            @error('shop_gst')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="">Operator Gst Upload</label>
                            <input type="file" name="operator_gst" id=""accept="image/*,application/pdf"
                                capture="environment" class="form-control @error('operator_gst') is in-valid @enderror">
                            @error('operator_gst')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div id="pancard_input_wrapper" class="col-sm-6 mb-3">
                            <label for="pancard">Vendor/Shop/Farm PAN Card Number:</label>
                            <input type="text" name="vendor_pan_no" id="pancard" class="form-control"
                                value="{{ old('pancard') }}">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="pancard">Operator PAN Card Number:</label>
                            <input type="text" name="operator_pan_no" id="pancard" class="form-control"
                                value="{{ old('pancard') }}">
                        </div>

                        <div class="col-md-6 mb-2">
                            <label for="">Shop Pan Card Upload</label>
                            <input type="file" name="shop_pan" id="" accept="image/*,application/pdf"
                                capture="environment" class="form-control @error('shop_pan') is in-valid @enderror">
                            @error('shop_pan')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="">Operator Pan Card Upload</label>
                            <input type="file" name="operator_pan" id=""accept="image/*,application/pdf"
                                capture="environment" class="form-control @error('operator_pan') is in-valid @enderror">
                            @error('operator_pan')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 mt-3">
                        {{-- Vendor/Shop/Farm Account Detail --}}
                        <h4>Vendor/Shop/Farm Account Detail</h4>

                        <div class="form-group mb-2">
                            <label for="vendor_account_no">Vendor/Shop/Farm Account No.</label>
                            <input type="text" name="vendor_account_no" id="vendor_account_no"
                                class="form-control @error('vendor_account_no') is-invalid @enderror"
                                value="{{ old('vendor_account_no') }}">
                            @error('vendor_account_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="vendor_account_holder">Vendor/Shop/Farm Account Holder Name</label>
                            <input type="text" name="vendor_account_holder" id="vendor_account_holder"
                                class="form-control @error('vendor_account_holder') is-invalid @enderror"
                                value="{{ old('vendor_account_holder') }}">
                            @error('vendor_account_holder')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="vendor_bank_name">Vendor/Shop/Farm Bank Name</label>
                            <input type="text" name="vendor_bank_name" id="vendor_bank_name"
                                class="form-control @error('vendor_bank_name') is-invalid @enderror"
                                value="{{ old('vendor_bank_name') }}">
                            @error('vendor_bank_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="vendor_bank_branch">Vendor/Shop/Farm Bank Branch Name</label>
                            <input type="text" name="vendor_bank_branch" id="vendor_bank_branch"
                                class="form-control @error('vendor_bank_branch') is-invalid @enderror"
                                value="{{ old('vendor_bank_branch') }}">
                            @error('vendor_bank_branch')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="vendor_bank_ifsc">Vendor/Shop/Farm Bank IFSC Code</label>
                            <input type="text" name="vendor_bank_ifsc" id="vendor_bank_ifsc"
                                class="form-control @error('vendor_bank_ifsc') is-invalid @enderror"
                                value="{{ old('vendor_bank_ifsc') }}">
                            @error('vendor_bank_ifsc')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr>

                        {{-- Operator Account Detail --}}
                        <h4>Operator Account Detail</h4>

                        <div class="form-group mb-2">
                            <label for="operator_account_no">Operator Account No.</label>
                            <input type="text" name="operator_account_no" id="operator_account_no"
                                class="form-control @error('operator_account_no') is-invalid @enderror"
                                value="{{ old('operator_account_no') }}">
                            @error('operator_account_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="operator_account_holder">Operator Account Holder Name</label>
                            <input type="text" name="operator_account_holder" id="operator_account_holder"
                                class="form-control @error('operator_account_holder') is-invalid @enderror"
                                value="{{ old('operator_account_holder') }}">
                            @error('operator_account_holder')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="operator_bank_name">Operator Bank Name</label>
                            <input type="text" name="operator_bank_name" id="operator_bank_name"
                                class="form-control @error('operator_bank_name') is-invalid @enderror"
                                value="{{ old('operator_bank_name') }}">
                            @error('operator_bank_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="operator_bank_branch">Operator Bank Branch Name</label>
                            <input type="text" name="operator_bank_branch" id="operator_bank_branch"
                                class="form-control @error('operator_bank_branch') is-invalid @enderror"
                                value="{{ old('operator_bank_branch') }}">
                            @error('operator_bank_branch')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="operator_bank_ifsc">Operator Bank IFSC Code</label>
                            <input type="text" name="operator_bank_ifsc" id="operator_bank_ifsc"
                                class="form-control @error('operator_bank_ifsc') is-invalid @enderror"
                                value="{{ old('operator_bank_ifsc') }}">
                            @error('operator_bank_ifsc')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="row mb-3 mt-2">
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-success w-100" value="Add Vendor">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
@endsection
