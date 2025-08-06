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
        <div class="container mt-3">
            <h4>- SELECT BILL TYPE</h4>

            <div class="mb-3">
                <select class="form-control" id="billTypeSelector" onchange="toggleContainers()">
                    <option value=""> Select Bill Type </option>
                    <option value="person">Person Bill</option>
                    <option value="sanstha">Sanstha Bill</option>
                </select>
            </div>
        </div>

        <div id="sansthaBillContainer" style="display: none;" class="card border p-3 container mt-5">
            <div class="container mt-5 mb-5">
                <form method="GET" action="{{ route('generate-bill') }}">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label">Search Person/Farm</label>
                            <input type="text" class="form-control" name="search" id="searchInput"
                                placeholder="Search By Shop/Farm/Seller Name" value="{{ request('search') }}">
                        </div>
                    </div>
                </form>

                <!-- Show matched results if any -->
                @if (!$searchResults->isEmpty())
                    <div id="searchBox">
                        <ul class="list-group mt-2">
                            @foreach ($searchResults as $item)
                                <li class="list-group-item" style="cursor: pointer;"
                                    onclick="fillData({{ json_encode($item) }})">
                                    {{ isset($item->name) ? $item->name : $item->b_name }} ({{ $item->shop }})
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="caerd-body shadow-sm p-5 bg-light">
                <form method="POST" action="{{ route('store-gbs-bill') }}">
                    @csrf
                    <div class="row">
                        <!-- Category Dropdown -->
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
                        <div class="col-sm-4 mb-3">
                            <label for="bill_no">Bill/Voucher/Invoice No:</label>
                            <input type="text" id="bill_no" name="bill_no" class="form-control"
                                value="{{ old('bill_no') }}" required>
                            @error('bill_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

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
                            <label for="date">Date:</label>
                            <input type="date" id="date" name="date" class="form-control"
                                value="{{ old('date') }}" required>
                            @error('date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label for="shop">Shop:</label>
                                <input type="text" id="shop" name="shop" class="form-control"
                                    value="{{ old('shop') }}" required>
                                @error('shop')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="mobile">Mobile:</label>
                                <input type="text" id="mobile" name="mobile" class="form-control"
                                    value="{{ old('mobile') }}" required>
                                @error('mobile')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email">Email:</label>
                                <input type="text" id="email" name="email" class="form-control"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address">Address:</label>
                                <input type="text" id="address" name="address" class="form-control"
                                    value="{{ old('address') }}" required>
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="block" class="form-label">Block: <span
                                        class="text-danger">*</span></label>
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
                            <div class="form-group mb-3">
                                <label for="stateSelect" class="form-label">State: <span
                                        class="text-danger">*</span></label>
                                <select class="form-control @error('state') is-invalid @enderror" name="state"
                                    id="stateSelect" required>
                                    <option value="">Select State</option>
                                    @foreach ($districtsByState as $state => $districts)
                                        <option value="{{ $state }}"
                                            {{ old('state') == $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
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

                        </div>
                    </div>

                    <table class="table table-bordered" id="items-table">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Product</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Rate</th>
                                <th class="text-end">Amount</th>
                                <th>
                                    <button type="button" class="btn btn-success btn-sm" onclick="addRow()">Add</button>
                                </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <div class="text-end mb-3">
                        <strong>Total Amount Before Tax: ₹<span id="total-amount">0.00</span></strong>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="cgst">CGST (%)</label>
                            <input type="number" id="cgst" name="cgst" class="form-control" value="0"
                                onchange="updateTotal()">
                        </div>
                        <div class="col-md-2">
                            <label for="sgst">SGST (%)</label>
                            <input type="number" id="sgst" name="sgst" class="form-control" value="0"
                                onchange="updateTotal()">
                        </div>
                        <div class="col-md-2">
                            <label for="igst">IGST (%)</label>
                            <input type="number" id="igst" class="form-control" value="0" readonly>
                        </div>

                    </div>

                    <div class="text-end mb-2">
                        <strong>CGST Amount: ₹<span id="cgst-amount">0.00</span></strong><br>
                        <strong>SGST Amount: ₹<span id="sgst-amount">0.00</span></strong><br>
                        <strong>IGST Amount: ₹<span id="igst-amount">0.00</span></strong><br>
                        <hr>
                        <strong>Grand Total (After Tax): ₹<span id="grand-total">0.00</span></strong>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Voucher</button>
                </form>
            </div>
        </div>

        <div id="personBillContainer" style="display: none;" class="card border p-3 container mt-5">
            <form method="POST" action="{{ route('store-person-bill') }}">
                @csrf
                <div class="row">
                    <!-- Category Dropdown -->
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

                    <div class="col-md-4 form-group mb-3">
                        <label for="bill_date">Bill Date:</label>
                        <input type="date" id="bill_date" name="bill_date" class="form-control"
                            value="{{ old('bill_date') }}" required>
                        @error('bill_date')
                            <small class="text-danger">{{ $message }}</small>
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
                        <input type="number" class="form-control" name="amount" id="amountInput"
                            oninput="updateAmountInWords()" placeholder="₹">
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
        function toggleContainers() {
            const selector = document.getElementById('billTypeSelector');
            const personContainer = document.getElementById('personBillContainer');
            const sansthaContainer = document.getElementById('sansthaBillContainer');

            if (selector.value === "person") {
                personContainer.style.display = 'block';
                sansthaContainer.style.display = 'none';
            } else if (selector.value === "sanstha") {
                personContainer.style.display = 'none';
                sansthaContainer.style.display = 'block';
            } else {
                personContainer.style.display = 'none';
                sansthaContainer.style.display = 'none';
            }
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
        let index = 0;

        function addRow() {
            const tbody = document.querySelector("#items-table tbody");
            const row = document.createElement("tr");

            row.innerHTML = `
        <td class="sr-no">${index + 1}</td>
        <td><input type="text" name="items[${index}][product]" class="form-control" required></td>
        <td><input type="number" name="items[${index}][qty]" class="form-control text-end qty" step="1" value="0" onchange="updateAmount(this)"></td>
        <td><input type="number" name="items[${index}][rate]" class="form-control text-end rate" step="0.01" value="0.00" onchange="updateAmount(this)"></td>
        <td class="text-end amount">0.00</td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
    `;

            tbody.appendChild(row);
            index++;
            updateSrNo();
            updateTotal();
        }

        function updateSrNo() {
            document.querySelectorAll('#items-table tbody tr').forEach((row, i) => {
                row.querySelector('.sr-no').textContent = i + 1;
            });
        }

        function updateAmount(el) {
            const row = el.closest('tr');
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const rate = parseFloat(row.querySelector('.rate').value) || 0;
            const amount = qty * rate;

            row.querySelector('.amount').textContent = amount.toFixed(2);
            updateTotal();
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.amount').forEach(cell => {
                total += parseFloat(cell.textContent);
            });

            // Get CGST and SGST percentage values
            const cgstPercent = parseFloat(document.getElementById('cgst').value) || 0;
            const sgstPercent = parseFloat(document.getElementById('sgst').value) || 0;

            // IGST is the sum of CGST and SGST
            const igstPercent = cgstPercent + sgstPercent;
            document.getElementById('igst').value = igstPercent.toFixed(2);

            // Calculate GST amounts
            const cgstAmount = (total * cgstPercent) / 100;
            const sgstAmount = (total * sgstPercent) / 100;
            const igstAmount = cgstAmount + sgstAmount;

            // Calculate grand total
            const grandTotal = total + igstAmount;

            // Update DOM
            document.getElementById('total-amount').textContent = total.toFixed(2);
            document.getElementById('cgst-amount').textContent = cgstAmount.toFixed(2);
            document.getElementById('sgst-amount').textContent = sgstAmount.toFixed(2);
            document.getElementById('igst-amount').textContent = igstAmount.toFixed(2);
            document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
        }



        function removeRow(btn) {
            btn.closest('tr').remove();
            updateSrNo();
            updateTotal();
        }
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
    <script>
        const allProjects = @json($allProjects);

        document.getElementById('work_category').addEventListener('change', function() {
            const selectedCategory = this.value;
            const workNameSelect = document.getElementById('work_name');

            // Clear current options
            workNameSelect.innerHTML = '<option value="">Select Work Name</option>';

            // Filter projects by selected category
            const filteredProjects = allProjects.filter(p => p.category === selectedCategory);

            // Add options to Work Name dropdown
            filteredProjects.forEach(project => {
                const option = document.createElement('option');
                option.value = project.name;
                option.text = project.name;
                workNameSelect.appendChild(option);
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

@endsection
