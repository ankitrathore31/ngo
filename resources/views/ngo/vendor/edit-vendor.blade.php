@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-items-center mb-1 mt-2">
            <h5 class="mb-0">Edit Vendor</h5>
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
                <form action="{{ route('update.vendor', $vendor->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <h5 class="mb-4 mt-2">- Edit Vendor/Shop/Farm Details</h5>

                        <div class="col-md-4 mb-3">
                            <label for="academic_session">Session <span class="login-danger">*</span></label>
                            <select class="form-control" name="academic_session" id="academic_session" required>
                                <option value="">Select Session</option>
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ $vendor->academic_session == $session->session_date ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-4 mb-3">
                            <label for="registration_no">Registration No:</label>
                            <input type="text" id="registration_no" name="registration_no" class="form-control"
                                value="{{ $vendor->registration_no }}" readonly>
                        </div>

                        <div class="col-sm-4 mb-3">
                            <label for="registration_date">Registration Date:</label>
                            <input type="date" id="registration_date" name="registration_date" class="form-control"
                                value="{{ $vendor->registration_date }}" required>
                        </div>

                        <div class="col-sm-4 mb-3">
                            <label for="shop">Vendor/Shop/Farm:</label>
                            <input type="text" id="shop" name="shop" class="form-control"
                                value="{{ $vendor->shop }}" required>
                        </div>

                        <div class="col-sm-4 mb-3">
                            <label for="vendor_type">Vendor Type</label>
                            <select name="vendor_type" id="vendor_type" class="form-select">
                                <option value="">Select Role</option>
                                <option value="Proprietor" {{ $vendor->vendor_type == 'Proprietor' ? 'selected' : '' }}>
                                    Proprietor</option>
                                <option value="Owner" {{ $vendor->vendor_type == 'Owner' ? 'selected' : '' }}>Owner
                                </option>
                                <option value="Partner" {{ $vendor->vendor_type == 'Partner' ? 'selected' : '' }}>Partner
                                </option>
                            </select>
                        </div>

                        <div class="col-sm-4 mb-3">
                            <label for="name">Seller Name:</label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ $vendor->name }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="village">Village/Locality:</label>
                            <input type="text" name="village" id="village" class="form-control"
                                value="{{ $vendor->village }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="post">Post/Town:</label>
                            <input type="text" name="post" id="post" class="form-control"
                                value="{{ $vendor->post }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="block">Block:</label>
                            <input type="text" name="block" id="block" class="form-control"
                                value="{{ $vendor->block }}" required>
                        </div>

                        @php
                            $districtsByState = config('districts');
                        @endphp
                        <div class="col-md-4 form-group mb-3">
                            <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label>
                            <select class="form-control  @error('state') is-invalid @enderror" name="state"
                                id="stateSelect" required>
                                <option value="">Select State</option>
                                @foreach ($districtsByState as $state => $districts)
                                    <option value="{{ $state }}"
                                        {{ (old('state') ?? $vendor->state) == $state ? 'selected' : '' }}>
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
                                @if (!empty($selectedState) && isset($districtsByState[$selectedState]))
                                    @foreach ($districtsByState[$selectedState] as $district)
                                        <option value="{{ $district }}"
                                            {{ $selectedDistrict == $district ? 'selected' : '' }}>
                                            {{ $district }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                            @error('district')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-4 mb-3">
                            <label for="mobile">Mobile:</label>
                            <input type="text" id="mobile" name="mobile" class="form-control"
                                value="{{ $vendor->mobile }}" required>
                        </div>

                        <div class="col-sm-4 mb-3">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="{{ $vendor->email }}" required>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label>Shop GST No</label>
                            <input type="text" name="shop_gst_no" class="form-control"
                                value="{{ $vendor->shop_gst_no }}">
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label>Operator GST No</label>
                            <input type="text" name="operator_gst_no" class="form-control"
                                value="{{ $vendor->operator_gst_no }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Shop GST Upload</label>
                            <input type="file" name="shop_gst_file" class="form-control">
                            @if ($vendor->shop_gst_file)
                                <a href="{{ asset($vendor->shop_gst_file) }}" target="_blank">View File</a>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Operator GST Upload</label>
                            <input type="file" name="operator_gst_file" class="form-control">
                            @if ($vendor->operator_gst_file)
                                <a href="{{ asset($vendor->operator_gst_file) }}" target="_blank">View File</a>
                            @endif
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label>Vendor PAN No</label>
                            <input type="text" name="vendor_pan_no" class="form-control"
                                value="{{ $vendor->vendor_pan_no }}">
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label>Operator PAN No</label>
                            <input type="text" name="operator_pan_no" class="form-control"
                                value="{{ $vendor->operator_pan_no }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Shop PAN Upload</label>
                            <input type="file" name="shop_pan_file" class="form-control">
                            @if ($vendor->shop_pan_file)
                                <a href="{{ asset($vendor->shop_pan_file) }}" target="_blank">View File</a>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Operator PAN Upload</label>
                            <input type="file" name="operator_pan_file" class="form-control">
                            @if ($vendor->operator_pan_file)
                                <a href="{{ asset($vendor->operator_pan_file) }}" target="_blank">View File</a>
                            @endif
                        </div>

                    </div>
                    <div class="row mb-3 mt-2">
                        {{-- Vendor/Shop/Farm Account Detail --}}
                        <h4>Vendor/Shop/Farm Account Detail</h4>

                        <div class="form-group mb-2">
                            <label for="vendor_account_no">Vendor/Shop/Farm Account No.</label>
                            <input type="text" name="vendor_account_no" id="vendor_account_no"
                                class="form-control @error('vendor_account_no') is-invalid @enderror"
                                value="{{ old('vendor_account_no', $vendor->vendor_account_no) }}">
                            @error('vendor_account_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="vendor_account_holder">Vendor/Shop/Farm Account Holder Name</label>
                            <input type="text" name="vendor_account_holder" id="vendor_account_holder"
                                class="form-control @error('vendor_account_holder') is-invalid @enderror"
                                value="{{ old('vendor_account_holder', $vendor->vendor_account_holder) }}">
                            @error('vendor_account_holder')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="vendor_bank_name">Vendor/Shop/Farm Bank Name</label>
                            <input type="text" name="vendor_bank_name" id="vendor_bank_name"
                                class="form-control @error('vendor_bank_name') is-invalid @enderror"
                                value="{{ old('vendor_bank_name', $vendor->vendor_bank_name) }}">
                            @error('vendor_bank_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="vendor_bank_branch">Vendor/Shop/Farm Bank Branch Name</label>
                            <input type="text" name="vendor_bank_branch" id="vendor_bank_branch"
                                class="form-control @error('vendor_bank_branch') is-invalid @enderror"
                                value="{{ old('vendor_bank_branch', $vendor->vendor_bank_branch) }}">
                            @error('vendor_bank_branch')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="vendor_bank_ifsc">Vendor/Shop/Farm Bank IFSC Code</label>
                            <input type="text" name="vendor_bank_ifsc" id="vendor_bank_ifsc"
                                class="form-control @error('vendor_bank_ifsc') is-invalid @enderror"
                                value="{{ old('vendor_bank_ifsc', $vendor->vendor_bank_ifsc) }}">
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
                                value="{{ old('operator_account_no', $vendor->operator_account_no) }}">
                            @error('operator_account_no')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="operator_account_holder">Operator Account Holder Name</label>
                            <input type="text" name="operator_account_holder" id="operator_account_holder"
                                class="form-control @error('operator_account_holder') is-invalid @enderror"
                                value="{{ old('operator_account_holder', $vendor->operator_account_holder) }}">
                            @error('operator_account_holder')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="operator_bank_name">Operator Bank Name</label>
                            <input type="text" name="operator_bank_name" id="operator_bank_name"
                                class="form-control @error('operator_bank_name') is-invalid @enderror"
                                value="{{ old('operator_bank_name', $vendor->operator_bank_name) }}">
                            @error('operator_bank_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="operator_bank_branch">Operator Bank Branch Name</label>
                            <input type="text" name="operator_bank_branch" id="operator_bank_branch"
                                class="form-control @error('operator_bank_branch') is-invalid @enderror"
                                value="{{ old('operator_bank_branch', $vendor->operator_bank_branch) }}">
                            @error('operator_bank_branch')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="operator_bank_ifsc">Operator Bank IFSC Code</label>
                            <input type="text" name="operator_bank_ifsc" id="operator_bank_ifsc"
                                class="form-control @error('operator_bank_ifsc') is-invalid @enderror"
                                value="{{ old('operator_bank_ifsc', $vendor->operator_bank_ifsc) }}">
                            @error('operator_bank_ifsc')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="row mb-3 mt-2">
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-primary w-100" value="Update Vendor">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        const allDistricts = @json($districtsByState);

        // Use old values if they exist, otherwise fallback to $beneficiarie
        const oldState = "{{ old('state', $vendor->state) }}";
        const oldDistrict = "{{ old('district', $vendor->district) }}";

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

        // Initial load
        if (oldState) {
            populateDistricts(oldState);
        }

        // On state change
        document.getElementById('stateSelect').addEventListener('change', function() {
            populateDistricts(this.value);
        });
    </script>
@endsection
