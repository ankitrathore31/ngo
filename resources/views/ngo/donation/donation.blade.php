@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-item-centre mb-0 mt-3">
            <h5 class="mb-0">Donation</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Donation</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('donation-list') }}" class="btn btn-success">Donation List</a>
                </div>
                <div class="card-body shadow rounded p-4 my-4">
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
                                    name="receipt_no" value="{{ old('receipt_no') }}">
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
                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                                value="{{ old('address') }}">
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
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>नकद / Cash
                                </option>
                                <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>चेक /
                                    Cheque</option>
                                <option value="upi" {{ old('payment_method') == 'upi' ? 'selected' : '' }}>यूपीआई / UPI
                                </option>
                                <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>अन्य /
                                    Other</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary">
                            <span data-lang="hi">सहेजें</span>
                            <span data-lang="en">Save</span>
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
@endsection
