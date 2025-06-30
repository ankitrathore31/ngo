@extends('ngo.layout.master')
@section('content')
    <style>
        #recordTable {
            border-collapse: collapse;
            width: 100%;
        }

        #recordTable th,
        #recordTable td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }

        #recordTable th {
            background-color: #e9f2fb;
            font-weight: bold;
        }

        .donation-row:hover {
            background-color: #f0f8ff;
            cursor: pointer;
        }
    </style>

    <div class="wrapper">
        <div class="d-flex justify-content-between align-donation-centre mb-2 mt-3">
            <h5 class="mb-0">Donation</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-donation"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-donation active" aria-current="page">Donation</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container mt-2">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <span data-lang="hi">दान पंजीकरण फॉर्म</span>
                    <span data-lang="en">Donation Registration Form</span>
                </h5>
                <div>
                    <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('donation-list') }}" class="btn btn-success">Donation List</a>
                </div>
                <div class="card-body shadow rounded p-4 my-4">
                    <form action="{{ route('update-donation', $donation->id) }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <!-- Receipt No. -->
                            <div class="col-md-4">
                                <label class="form-label">
                                    <span data-lang="hi">रसीद क्रमांक</span>
                                    <span data-lang="en">Receipt No.</span>
                                </label>
                                <input type="text" class="form-control @error('receipt_no') is-invalid @enderror"
                                    name="receipt_no" value="{{ $donation->receipt_no }}" readonly>
                                @error('receipt_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">
                                    <span data-lang="hi">सेशन</span>
                                    <span data-lang="en">Session</span>
                                </label>
                                <select class="form-control @error('session') is-invalid @enderror" name="session" required>
                                    <option value="">Select Session</option>
                                    @foreach ($data as $session)
                                        <option value="{{ $session->session_date }}"
                                            {{ old('session', $donation->academic_session) == $session->session_date ? 'selected' : '' }}>
                                            {{ $session->session_date }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('session')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <!-- Date -->
                            <div class="col-md-4">
                                <label class="form-label">
                                    <span data-lang="hi">तारीख</span>
                                    <span data-lang="en">Date</span>
                                </label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    name="date" value="{{ $donation->date }}">
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Full Name -->
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <span data-lang="hi">श्री / श्रीमती का नाम</span>
                                        <span data-lang="en">Full Name</span>
                                    </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ $donation->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Mobile Number -->
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <span data-lang="hi">मोबाइल नंबर</span>
                                        <span data-lang="en">Mobile Number</span>
                                    </label>
                                    <input type="text" class="form-control @error('mobile') is-invalid @enderror"
                                        name="mobile" value="{{ $donation->mobile }}" maxlength="10" pattern="[0-9]{10}"
                                        placeholder="10-digit number">
                                    @error('mobile')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Father/Husband Name -->
                        <div class="mb-3">
                            <label class="form-label">
                                <span data-lang="hi">पिता/पति का नाम</span>
                                <span data-lang="en">Father/Husband's Name</span>
                            </label>
                            <input type="text" class="form-control @error('gurdian_name') is-invalid @enderror"
                                name="gurdian_name" value="{{ $donation->gurdian_name }}">
                            @error('gurdian_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Address -->
                            <div class="col-md-3 mb-3">
                                <label class="form-label">
                                    <span data-lang="hi">पता</span>
                                    <span data-lang="en">Address</span>
                                </label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    name="address" value="{{ $donation->address }}">

                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="block" class="form-label">Block: <span class="text-danger">*</span></label>
                                <input type="text" name="block" id="block"
                                    class="form-control @error('block') is-invalid @enderror"
                                    value="{{ $donation->block }}" required>
                                @error('block')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @php
                                $districtsByState = config('districts');
                            @endphp
                            <div class="col-md-3 form-group mb-3">
                                <label for="stateSelect" class="form-label">State: <span
                                        class="text-danger">*</span></label>
                                <select class="form-control  @error('state') is-invalid @enderror" name="state"
                                    id="stateSelect" required>
                                    <option value="">Select State</option>
                                    @foreach ($districtsByState as $state => $districts)
                                        <option value="{{ $state }}"
                                            {{ (old('state') ?? $donation->state) == $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 form-group mb-3">
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
                        </div>
                        <!-- Amount -->
                        <div class="mb-3">
                            <label class="form-label">
                                <span data-lang="hi">राशि (₹)</span>
                                <span data-lang="en">Amount (₹)</span>
                            </label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                        name="amount" id="amountInput" value="{{ $donation->amount }}"
                                        oninput="updateAmountInWords()" placeholder="₹">
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="amountWords" readonly
                                        placeholder="Amount in words">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <span data-lang="hi">भुगतान का प्रकार</span>
                                <span data-lang="en">Payment Method</span>
                            </label>
                            <select class="form-select @error('payment_method') is-invalid @enderror"
                                name="payment_method" id="payment_method">
                                <option value="">Select...</option>
                                <option value="Cash"
                                    {{ old('payment_method', $donation->payment_method) == 'Cash' ? 'selected' : '' }}>नकद
                                    / Cash</option>
                                <option value="Cheque"
                                    {{ old('payment_method', $donation->payment_method) == 'Cheque' ? 'selected' : '' }}>
                                    चेक / Cheque</option>
                                <option value="UPI"
                                    {{ old('payment_method', $donation->payment_method) == 'UPI' ? 'selected' : '' }}>
                                    यूपीआई / UPI</option>
                                <option value="Other"
                                    {{ old('payment_method', $donation->payment_method) == 'Other' ? 'selected' : '' }}>
                                    अन्य / Other</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cheque Fields -->
                        <div id="chequeFields" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Cheque No.</label>
                                <input type="text" class="form-control" name="cheque_no"
                                    value="{{ old('cheque_no', $donation->cheque_no) }}">
                                @error('cheque_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Bank Name</label>
                                <input type="text" class="form-control" name="bank_name"
                                    value="{{ old('bank_name', $donation->bank_name) }}">
                                @error('bank_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Bank Branch</label>
                                <input type="text" class="form-control" name="bank_branch"
                                    value="{{ old('bank_branch', $donation->bank_branch) }}">
                                @error('bank_branch')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cheque Date</label>
                                <input type="date" class="form-control" name="cheque_date"
                                    value="{{ old('cheque_date', $donation->cheque_date) }}">
                                @error('cheque_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- UPI Fields -->
                        <div id="upiFields" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Transaction Number</label>
                                <input type="text" class="form-control" name="transaction_no"
                                    value="{{ old('transaction_no', $donation->transaction_no) }}">
                                @error('transaction_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Transaction Date</label>
                                <input type="date" class="form-control" name="transaction_date"
                                    value="{{ old('transaction_date', $donation->transaction_date) }}">
                                @error('transaction_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Other Details -->
                        <div class="row">
                            <div class="mb-4 col-md-4">
                                <label for="depositor_name" class="form-label">Depositor Name</label>
                                <input type="text" name="depositor_name" id="depositor_name"
                                    value="{{ old('depositor_name', $donation->depositor_name) }}" class="form-control">
                                @error('depositor_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4 col-md-4">
                                <label for="relationship" class="form-label">Relationship of Depositor</label>
                                <input type="text" name="relationship" id="relationship"
                                    value="{{ old('relationship', $donation->relationship) }}" class="form-control">
                                @error('relationship')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4 col-md-4">
                                <label for="recipient_name" class="form-label">Recipient Name</label>
                                <input type="text" name="recipient_name" id="recipient_name"
                                    value="{{ old('recipient_name', $donation->recipient_name) }}" class="form-control">
                                @error('recipient_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="remark" class="form-label">Remark / Comment / SMS</label>
                                <textarea name="remark" id="remark" rows="3" class="form-control">{{ old('remark', $donation->remark) }}</textarea>
                                @error('remark')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary">
                            {{-- <span data-lang="hi">सहेजें</span> --}}
                            <span>Update Deposite</span>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        function setLanguage(lang) {
            document.querySelectorAll('[data-lang]').forEach(el => {
                el.style.display = el.getAttribute('data-lang') === lang ? 'inline' : 'none';
            });
        }
        window.onload = () => setLanguage('en'); // Set Hindi as default
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


        function numberToWordsHI(num) {
            const ones = ['', 'एक', 'दो', 'तीन', 'चार', 'पांच', 'छह', 'सात', 'आठ', 'नौ', 'दस',
                'ग्यारह', 'बारह', 'तेरह', 'चौदह', 'पंद्रह', 'सोलह', 'सत्रह', 'अठारह', 'उन्नीस'
            ];
            const tens = ['', '', 'बीस', 'तीस', 'चालीस', 'पचास', 'साठ', 'सत्तर', 'अस्सी', 'नब्बे'];

            const numToHindiWords = (n) => {
                if (n === 0) return '';
                if (n < 20) return ones[n];
                if (n < 100) return tens[Math.floor(n / 10)] + (n % 10 !== 0 ? ' ' + ones[n % 10] : '');
                if (n < 1000) return ones[Math.floor(n / 100)] + ' सौ' + (n % 100 !== 0 ? ' ' + numToHindiWords(n %
                    100) : '');
                if (n < 100000) return numToHindiWords(Math.floor(n / 1000)) + ' हजार' + (n % 1000 !== 0 ? ' ' +
                    numToHindiWords(n % 1000) : '');
                if (n < 10000000) return numToHindiWords(Math.floor(n / 100000)) + ' लाख' + (n % 100000 !== 0 ? ' ' +
                    numToHindiWords(n % 100000) : '');
                return numToHindiWords(Math.floor(n / 10000000)) + ' करोड़' + (n % 10000000 !== 0 ? ' ' +
                    numToHindiWords(n % 10000000) : '');
            };

            return numToHindiWords(num).trim() + ' रुपये मात्र';
        }


        function updateAmountInWords() {
            const amount = parseInt(document.getElementById('amountInput').value);
            const lang = document.querySelector('[data-lang][style*="inline"]')?.getAttribute('data-lang') || 'hi';
            let words = '';

            if (!isNaN(amount)) {
                if (lang === 'en') {
                    words = numberToWordsEN(amount);
                } else {
                    words = numberToWordsHI(amount);
                }
            }

            document.getElementById('amountWords').value = words;
        }
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
    <script>
        const allDistricts = @json($districtsByState);

        // Use old values if they exist, otherwise fallback to $beneficiarie
        const oldState = "{{ old('state', $donation->state) }}";
        const oldDistrict = "{{ old('district', $donation->district) }}";

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
