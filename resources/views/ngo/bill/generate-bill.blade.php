@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-items-center mb-1 mt-3">
            <h5 class="mb-0">Generate Bill/Voucher</h5>
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
        <div class="container mt-5">
            <form method="POST" action="{{ route('store-bill') }}">
                @csrf
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <label for="bill_no">Bill/Voucher No:</label>
                        <input type="text" id="bill_no" name="bill_no" class="form-control"
                            value="{{ old('bill_no') }}" required>
                        @error('bill_no')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="date">Bill Date:</label>
                        <input type="date" id="date" name="bill_date" class="form-control"
                            value="{{ old('date') }}" required>
                        @error('date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}"
                            required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="guardian_name">Father/Husband Name:</label>
                        <input type="text" id="guardian_name" name="guardian_name" class="form-control"
                            value="{{ old('guardian_name') }}" required>
                        @error('guardian_name')
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
                        <label for="districtSelect" class="form-label">District: <span class="text-danger">*</span></label>
                        <select class="form-control @error('district') is-invalid @enderror" name="district"
                            id="districtSelect" required>
                            <option value="">Select District</option>
                        </select>
                        @error('district')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="branch" class="form-label">Branch: <span class="text-danger">*</span></label>
                        <input type="text" name="branch" id="branch"
                            class="form-control @error('branch') is-invalid @enderror" value="{{ old('branch') }}"
                            required>
                        @error('branch')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="centre" class="form-label">Centre: <span class="text-danger">*</span></label>
                        <input type="text" name="centre" id="centre"
                            class="form-control @error('centre') is-invalid @enderror" value="{{ old('centre') }}"
                            required>
                        @error('centre')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" class="form-control"
                            value="{{ old('date') }}" required>
                        @error('date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="work" class="form-label">Work: <span class="text-danger">*</span></label>
                        <textarea name="work" id="work" class="form-control @error('work') is-invalid @enderror">{{ old('work') }}</textarea>
                        @error('work')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label class="form-label">
                            <span>Payment Method</span>
                        </label>
                        <select class="form-select @error('payment_method') is-invalid @enderror" name="payment_method">
                            <option value="">Select...</option>
                            <option value="Cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>नकद / Cash
                            </option>
                            <option value="Cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>चेक /
                                Cheque</option>
                            <option value="UPI" {{ old('payment_method') == 'upi' ? 'selected' : '' }}>यूपीआई / UPI
                            </option>
                            <option value="Other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>अन्य /
                                Other</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="chequeFields" style="display: none;">
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label class="form-label">Cheque No.</label>
                                <input type="text" class="form-control" name="cheque_no"
                                    value="{{ old('cheque_no') }}">
                                @error('cheque_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="form-label">Bank Name</label>
                                <input type="text" class="form-control" name="bank_name"
                                    value="{{ old('bank_name') }}">
                                @error('bank_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="form-label">Bank Branch</label>
                                <input type="text" class="form-control" name="bank_branch"
                                    value="{{ old('bank_branch') }}">
                                @error('bank_branch')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="form-label">Cheque Date</label>
                                <input type="date" class="form-control" name="cheque_date"
                                    value="{{ old('cheque_date') }}">
                                @error('cheque_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div id="upiFields" style="display: none;">
                        <div class="row">
                            <div class="col-md-4 form-group mb-3">
                                <label class="form-label">Transaction Number</label>
                                <input type="text" class="form-control" name="transaction_no"
                                    value="{{ old('transaction_no') }}">
                                @error('transaction_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label class="form-label">Transaction Date</label>
                                <input type="date" class="form-control" name="transaction_date"
                                    value="{{ old('transaction_date') }}">
                                @error('transaction_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Generate Voucher</button>
            </form>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethod = document.querySelector('select[name="payment_method"]');
            const chequeFields = document.getElementById('chequeFields');
            const upiFields = document.getElementById('upiFields');

            function togglePaymentFields() {
                const method = paymentMethod.value;

                chequeFields.style.display = method === 'Cheque' ? 'block' : 'none';
                upiFields.style.display = method === 'UPI' ? 'block' : 'none';
            }

            // Initial check (for old input value on validation error)
            togglePaymentFields();

            // On change
            paymentMethod.addEventListener('change', togglePaymentFields);
        });
    </script>
@endsection
