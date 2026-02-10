@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-items-center mb-1 mt-3">
            <h5 class="mb-0">Generate Person Bill/Voucher</h5>
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
        <div id="personBillContainer" class="card border p-3 container mt-5">
            <form method="POST" action="{{ route('store-person-bill') }}">
                @csrf
                <div class="row">

                    <!-- Work Category Dropdown -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Project / Work Category <span class="text-danger">*</span></label>
                        <select name="work_category" id="work_category" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Work Name Dropdown -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Project / Work Name <span class="text-danger">*</span></label>
                        <select name="work_name" id="work_name" class="form-control" required>
                            <option value="">Select Work Name</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="academic_session" class=" bold">Session <span class="login-danger">*</span></label>
                        <select class="form-control @error('academic_session') is-invalid @enderror" name="academic_session"
                            id="academic_session" required>
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

                    <div class="col-md-4 form-group mb-3">
                        <label for="bill_date">Bill Date:</label>
                        <input type="date" id="bill_date" name="bill_date" class="form-control"
                            value="{{ old('bill_date') }}" required>
                        @error('bill_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="">Bill/Voucher/Invoice No.</label>
                        <input type="text" name="bill_no" class="form-control @error('bill_no') is in-valid @enderror"
                            required>
                        @error('bill_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name') }}" required>
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
                        <label for="">Mobile No.</label>
                        <input type="number" maxlength="10" name="mobile"
                            class="form-control @error('mobile') is in-valid @enderror" required>
                        @error('mobile')
                            <span>{{ $message }}</span>
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

                    <div class=" col-md-4 mb-3">
                        <label class="form-label">Amount (₹)</label>
                        <input type="number" class="form-control" name="amount" step="0.01" min="0"
                            id="amountInput" oninput="updateAmountInWords()" placeholder="₹">
                        @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Amount in words</label>
                        <input type="text" class="form-control" id="amountWords" readonly
                            placeholder="Amount in words">
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label class="form-label">
                            <span>Payment Method</span>
                        </label>
                        <select class="form-select @error('payment_method') is-invalid @enderror" name="payment_method"
                            id="payment_method">
                            <option value="">Select...</option>
                            <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>नकद / Cash
                            </option>
                            <option value="Cheque" {{ old('payment_method') == 'Cheque' ? 'selected' : '' }}>चेक / Cheque
                            </option>
                            <option value="UPI" {{ old('payment_method') == 'UPI' ? 'selected' : '' }}>यूपीआई / UPI
                            </option>
                            <option value="Cashfree" {{ old('payment_method') == 'Cashfree' ? 'selected' : '' }}>कैशफ्री /
                                Cashfree</option>
                            <option value="Account" {{ old('payment_method') == 'Account' ? 'selected' : '' }}>खाता /
                                Account</option>
                        </select>

                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Transaction Date (always visible) -->
                    <div class="col-md-4 form-group mb-3">
                        <label class="form-label">Transaction Date</label>
                        <input type="date" class="form-control" name="transaction_date"
                            value="{{ old('transaction_date') }}">
                        @error('transaction_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Cheque Fields (only Cheque No.) -->
                    <div id="chequeFields" style="display: none;">
                        <div class="col-md-4 form-group mb-3">
                            <label class="form-label">Cheque No.</label>
                            <input type="text" class="form-control" name="cheque_no" value="{{ old('cheque_no') }}">
                            @error('cheque_no')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Account Fields -->
                    <div id="accountFields" style="display: none;">
                        <div class="row">
                            <div class="col-md-4 form-group mb-3 mb-3">
                                <label for="account_number" class="form-label">Account Number</label>
                                <input type="text" class="form-control @error('account_number') is-invalid @enderror"
                                    id="account_number" name="account_number" value="{{ old('account_number') }}"
                                    placeholder="Enter Account Number">
                                @error('account_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3 mb-3">
                                <label for="bank_name" class="form-label">Bank Name</label>
                                <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                                    id="bank_name" name="bank_name" value="{{ old('bank_name') }}"
                                    placeholder="Enter Bank Name">
                                @error('bank_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 form-group mb-3 mb-3">
                                <label for="branch_name" class="form-label">Bank Branch</label>
                                <input type="text" class="form-control @error('branch_name') is-invalid @enderror"
                                    id="branch_name" name="branch_name" value="{{ old('branch_name') }}"
                                    placeholder="Enter Branch Name">
                                @error('branch_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 form-group mb-3 mb-3">
                                <label for="ifsc_code" class="form-label">IFSC Code</label>
                                <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror"
                                    id="ifsc_code" name="ifsc_code" value="{{ old('ifsc_code') }}"
                                    placeholder="Enter IFSC Code">
                                @error('ifsc_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Number for UPI and Cashfree -->
                    <div id="transactionNoField" style="display: none;">
                        <div class="col-md-4 form-group mb-3">
                            <label class="form-label">Transaction Number</label>
                            <input type="text" class="form-control" name="transaction_no"
                                value="{{ old('transaction_no') }}">
                            @error('transaction_no')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="col-md-4 form-group mb-3">
                        <label for="place" class="form-label">Place: <span class="text-danger">*</span></label>
                        <textarea name="place" id="place" class="form-control @error('place') is-invalid @enderror">{{ old('place') }}</textarea>
                        @error('place')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">Generate Voucher</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethod = document.getElementById('payment_method');
            const chequeFields = document.getElementById('chequeFields');
            const accountFields = document.getElementById('accountFields');
            const transactionNoField = document.getElementById('transactionNoField');

            function togglePaymentFields() {
                const method = paymentMethod.value;

                // Hide all by default
                chequeFields.style.display = 'none';
                accountFields.style.display = 'none';
                transactionNoField.style.display = 'none';

                if (method === 'Cheque') {
                    chequeFields.style.display = 'block';
                } else if (method === 'Account') {
                    accountFields.style.display = 'block';
                } else if (method === 'UPI' || method === 'Cashfree') {
                    transactionNoField.style.display = 'block';
                }
                // Cash - everything stays hidden
            }

            // Initial setup
            togglePaymentFields();

            // On selection change
            paymentMethod.addEventListener('change', togglePaymentFields);
        });
    </script>
    <script>
        function numberToWordsEN(num) {
            const ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
                'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
            ];
            const tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

            if ((num = num.toString()).length > 9) return 'Overflow';
            let n = ('000000000' + num).slice(-9).match(/(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})/);
            if (!n) return '';

            const getWords = (num) => {
                if (num < 20) return ones[num];
                return tens[Math.floor(num / 10)] + (num % 10 ? ' ' + ones[num % 10] : '');
            };

            let str = '';
            if (+n[1]) str += getWords(+n[1]) + ' Crore ';
            if (+n[2]) str += getWords(+n[2]) + ' Lakh ';
            if (+n[3]) str += getWords(+n[3]) + ' Thousand ';
            if (+n[4]) str += ones[+n[4]] + ' Hundred ';
            if (+n[5]) str += getWords(+n[5]) + ' ';

            return str.trim() + ' Rupees Only';
        }

        function updateAmountInWords() {
            const amount = parseInt(document.getElementById('amountInput').value);
            let words = '';

            if (!isNaN(amount)) {
                words = numberToWordsEN(amount);
            }

            document.getElementById('amountWords').value = words;
        }
    </script>
    <!-- JavaScript to Populate Work Names -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const allProjects = @json($allProjects);
            const categorySelect = document.getElementById('work_category');
            const workNameSelect = document.getElementById('work_name');

            categorySelect.addEventListener('change', function() {
                const selectedCategory = this.value;

                // Clear existing options
                workNameSelect.innerHTML = '<option value="">Select Work Name</option>';

                // Filter projects by selected category
                const filteredProjects = allProjects.filter(project => project.category ===
                    selectedCategory);

                // Populate new options
                filteredProjects.forEach(project => {
                    const option = document.createElement('option');
                    option.value = project.name;
                    option.text = project.name;
                    workNameSelect.appendChild(option);
                });
            });
        });
    </script>
    <script>
        const searchInput = document.getElementById('searchInput');
        const searchBox = document.getElementById('searchBox');

        // Hide result list when input is cleared
        searchInput.addEventListener('input', function() {
            if (this.value.trim() === '' && searchBox) {
                searchBox.style.display = 'none';
            } else if (searchBox) {
                searchBox.style.display = 'block';
            }
        });

        // Fill data function
        function fillData(data) {
            document.getElementById('shop').value = data.shop || '';
            document.getElementById('name').value = data.name || '';
            document.getElementById('address').value = data.address || '';
            document.getElementById('mobile').value = data.mobile || '';
            document.getElementById('email').value = data.email || '';

            // Populate district, block, and state fields if available
            document.getElementById('districtSelect').value = data.district || '';
            document.getElementById('block').value = data.block || '';
            document.getElementById('stateSelect').value = data.state || '';

            // Hide search results after filling data
            if (searchBox) {
                searchBox.style.display = 'none';
            }

            // Clear the input field (optional)
            searchInput.value = '';
        }
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
@endsection
