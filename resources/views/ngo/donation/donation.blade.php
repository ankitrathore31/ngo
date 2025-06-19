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

        .record-row:hover {
            background-color: #f0f8ff;
            cursor: pointer;
        }
    </style>

    <div class="wrapper">
        <div class="d-flex justify-content-between align-record-centre mb-2 mt-3">
            <h5 class="mb-0">Donation</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-record"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-record active" aria-current="page">Donation</li>
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
                    <!-- Search Input -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <input type="text" id="searchInput" class="form-control"
                                placeholder="Search by Reg. No, Name, Phone, or ID No">
                        </div>
                    </div>

                    <!-- Results Table -->
                    <!-- Results Table -->
                    <div id="recordTableDiv" style="display: none;" class="table-responsive">
                        <table id="recordTable" class="table table-bordered table-striped table-hover"
                            style="border-collapse: collapse; width: 100%;">
                            <thead class="table-primary">
                                <tr>
                                    <th>Type</th>
                                    <th>Registration No</th>
                                    <th>Name</th>
                                    <th>Father/Husband</th>
                                    <th>Phone</th>
                                    <th>Identity Type</th>
                                    <th>Identity No</th>
                                    <th>Session</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($record as $item)
                                    <tr class="record-row" data-name="{{ $item->name }}" data-phone="{{ $item->phone }}"
                                        data-gurdian="{{ $item->gurdian_name }}"data-registration="{{ $item->registration_no }}"
                                        data-registrationDate="{{ $item->registration_date }}"
                                        data-address="{{ $item->village }}, {{ $item->post }}, {{ $item->block }}, {{ $item->district }}, {{ $item->state }} - {{ $item->pincode }}"
                                        style="cursor: pointer;">
                                        <td>{{ get_class($item) === 'App\\Models\\beneficiarie' ? 'Beneficiary' : 'Member' }}
                                        </td>
                                        <td>{{ $item->registration_no ?? 'Not Found' }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->gurdian_name }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->identity_type ?? '—' }}</td>
                                        <td>{{ $item->identity_no ?? '—' }}</td>
                                        <td>{{ $item->academic_session ?? '_' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>



                    <!-- Selected Record Info -->
                    <div id="selectedRecord" class="mt-3" style="display: none;">
                        <div class="card shadow-sm border rounded p-3 bg-light">
                            <h5 class="card-title text-primary">Selected Person Details</h5>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0" id="selectedInfo">
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr>


                    <form action="{{ route('save-donation') }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <!-- Receipt No. -->
                            <div class="col-md-4">
                                <label class="form-label">
                                    <span data-lang="hi">रसीद क्रमांक</span>
                                    <span data-lang="en">Receipt No.</span>
                                </label>
                                <input type="text" class="form-control @error('receipt_no') is-invalid @enderror"
                                    name="receipt_no" value="{{ old('receipt_no', $newReceiptNo) }}">
                                @error('receipt_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Session -->
                            <div class="col-md-4">
                                <label class="form-label">
                                    <span data-lang="hi">सेशन</span>
                                    <span data-lang="en">Session</span>
                                </label>
                                <select class="form-control @error('session') is-invalid @enderror" name="session" required>
                                    <option value="">Select Session</option>
                                    @foreach ($data as $session)
                                        <option value="{{ $session->session_date }}"
                                            {{ old('session') == $session->session_date ? 'selected' : '' }}>
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
                                    name="date" value="{{ old('date') }}">
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
                                        name="name" value="{{ old('name') }}">
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
                                        name="mobile" value="{{ old('mobile') }}" maxlength="10" pattern="[0-9]{10}"
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
                                name="gurdian_name" value="{{ old('gurdian_name') }}">
                            @error('gurdian_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label class="form-label">
                                <span data-lang="hi">पता</span>
                                <span data-lang="en">Address</span>
                            </label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror"
                                name="address" value="{{ old('address') }}">

                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                                        name="amount" id="amountInput" value="{{ old('amount') }}"
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

                        <!-- Payment Method -->
                        <div class="mb-3">
                            <label class="form-label">
                                <span data-lang="hi">भुगतान का प्रकार</span>
                                <span data-lang="en">Payment Method</span>
                            </label>
                            <select class="form-select @error('payment_method') is-invalid @enderror"
                                name="payment_method">
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
                        <!-- Conditional Fields for Cheque -->
                        <!-- Cheque Fields -->
                        <div id="chequeFields" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Cheque No.</label>
                                <input type="text" class="form-control" name="cheque_no"
                                    value="{{ old('cheque_no') }}">
                                @error('cheque_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Bank Name</label>
                                <input type="text" class="form-control" name="bank_name"
                                    value="{{ old('bank_name') }}">
                                @error('bank_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Bank Branch</label>
                                <input type="text" class="form-control" name="bank_branch"
                                    value="{{ old('bank_branch') }}">
                                @error('bank_branch')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cheque Date</label>
                                <input type="date" class="form-control" name="cheque_date"
                                    value="{{ old('cheque_date') }}">
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
                                    value="{{ old('transaction_no') }}">
                                @error('transaction_no')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Transaction Date</label>
                                <input type="date" class="form-control" name="transaction_date"
                                    value="{{ old('transaction_date') }}">
                                @error('transaction_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>



                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary">
                            {{-- <span data-lang="hi">सहेजें</span> --}}
                            <span>Deposite</span>
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
            const searchInput = document.getElementById('searchInput');
            const tableDiv = document.getElementById('recordTableDiv');
            const tableRows = document.querySelectorAll('.record-row');
            const selectedRecord = document.getElementById('selectedRecord');
            const selectedInfo = document.getElementById('selectedInfo');

            // Filter on search input
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                let match = false;

                tableRows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    if (text.includes(query)) {
                        row.style.display = '';
                        match = true;
                    } else {
                        row.style.display = 'none';
                    }
                });

                if (query.trim() === '') {
                    tableDiv.style.display = 'none';
                } else {
                    tableDiv.style.display = match ? 'block' : 'none';
                }
            });

            // Fill input fields on row click
            // Fill input fields on row click
            tableRows.forEach(row => {
                row.addEventListener('click', function() {
                    const name = this.dataset.name;
                    const phone = this.dataset.phone;
                    const gurdian = this.dataset.gurdian;
                    const address = this.dataset.address;
                    const identityNo = this.dataset
                        .identityno;
                    const registration = this.dataset.registration;
                    const registrationDate = this.dataset.registrationDate;

                    // Fill the form inputs
                    document.querySelector('input[name="name"]').value = name;
                    document.querySelector('input[name="mobile"]').value = phone;
                    document.querySelector('input[name="gurdian_name"]').value = gurdian;
                    document.querySelector('input[name="address"]').value = address;

                    // Show selected info in a better format
                    selectedInfo.innerHTML = `
                        <div class="row">
                        <div class="col-md-3"><strong>Name:</strong> ${name}</div>
                        <div class="col-md-3"><strong>Mobile:</strong> ${phone}</div>
                        <div class="col-md-3"><strong>Registration No.:</strong> ${registration}</div>
                        
                        
                    `;

                    selectedRecord.style.display = 'block';
                    tableDiv.style.display = 'none';

                    // Clear and hide the search input
                    searchInput.value = '';
                    // searchInput.style.display = 'none';
                });
            });

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
