@extends('ngo.layout.master')
@section('content')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print-card,
            .print-card * {
                visibility: visible;
            }

            .print-card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            /* Optional: Hide buttons like Print/Download and Language Toggle */
            button,
            .btn,
            .d-flex.justify-content-between {
                display: none !important;
            }
        }
    </style>

    <div class="wrapper">
        <div class="d-flex justify-content-between align-item-centre mb-0 mt-3">
            <h5 class="mb-0">Donation</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">View Donation</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container">
            <!-- Language Toggle -->
            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h5 class="mb-0">
                    <span data-lang="hi">दान रसीद</span>
                    <span data-lang="en">Donation Receipt</span>
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">Print / Download</button>
                    <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button>
                </div>
            </div>
            <div class="card shadow rounded p-4 my-4 border border-dark print-card">
                <div class="text-center mb-4 border-bottom pb-2">
                    <!-- Header -->
                    <div class="row">
                        <div class="col-sm-2 text-center text-md-start">
                            <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80" height="80">
                        </div>
                        <div class="col-sm-10">
                            <p style="margin: 0;">
                                <span data-lang="hi"><b>सोसाइटीज रजिस्ट्रेशन एक्ट 1860 के अंतर्गत पंजीकृत</b></span>
                                <span data-lang="en"><b>Registered under Societies Registration Act 1860</b></span>
                            </p>
                            <h4 style="color: red;"><b>
                                    <span data-lang="hi">ज्ञान भारती संस्था</span>
                                    <span data-lang="en">Gyan Bharti Sanstha</span>
                                </b></h4>
                            <h6 style="color: blue;"><b>
                                    <span data-lang="hi">ग्राम - कैंचू टांडा, पोस्ट - अमरिया, जिला - पीलीभीत, उत्तर प्रदेश -
                                        262121</span>
                                    <span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District - Pilibhit, UP -
                                        262121</span>
                                </b></h6>
                            <p style="margin: 0;">
                                <span data-lang="hi"><b>आयकर अधिनियम 80G, 12A, के अंतर्गत रजिस्टर्ड</b></span>
                                <span data-lang="en"><b>Registered under Income Tax Act 80G, 12A</b></span>
                            </p>
                            <p style="margin: 0;"><b>
                                    <span data-lang="hi">पंजीकरण सं.: 80G-AAEAG7650BF20231 | 12A: AAEAG7650BE20231 | दिनांक:
                                        02-10-2023</span>
                                    <span data-lang="en">Reg. No: 80G-AAEAG7650BF20231 | 12A: AAEAG7650BE20231 | Date:
                                        02-10-2023</span>
                                    <span data-lang="hi">| पैन: AAEAG7650B</span>
                                    <span data-lang="en">| PAN: AAEAG7650B</span>
                                </b></p>
                            {{-- <p style="margin: 0;"><b>

                                </b></p> --}}
                        </div>
                    </div>
                </div>

                <!-- Donation Fields -->
                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <p><strong>
                                <span data-lang="hi">रसीद क्रमांक:</span>
                                <span data-lang="en">Receipt No.:</span>
                            </strong> {{ $donor->receipt_no }}</p>
                    </div>

                    {{-- <div class="col-sm-4 mb-2">
                        <p><strong>
                                <span data-lang="hi">सेशन: </span>
                                <span data-lang="en">Session: </span>
                            </strong> {{ $donor->academic_session }}</p>
                    </div> --}}

                    <div class="col-sm-6 mb-2">
                        <p><strong>
                                <span data-lang="hi">तारीख: </span>
                                <span data-lang="en">Date: </span>
                            </strong> {{ \Carbon\Carbon::parse($donor->date)->format('d-m-Y') }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <p><strong>
                                <span data-lang="hi">श्री / श्रीमती का नाम:</span>
                                <span data-lang="en">Full Name:</span>
                            </strong> {{ $donor->name }}</p>
                    </div>

                    <div class="col-sm-6 mb-2">
                        <p><strong>
                                <span data-lang="hi">पिता/पति का नाम:</span>
                                <span data-lang="en">Father/Husband's Name:</span>
                            </strong> {{ $donor->gurdian_name }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <p><strong>
                                <span data-lang="hi">पता:</span>
                                <span data-lang="en">Address:</span>
                            </strong> {{ $donor->address }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p>
                            <strong>
                                <span data-lang="hi">मोबाइल नंबर</span>
                                <span data-lang="en">Mobile Number</span>
                            </strong> {{ $donor->mobile }}
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <p><strong>
                                <span data-lang="hi">राशि (₹):</span>
                                <span data-lang="en">Amount (₹):</span>
                            </strong>
                            <span id="amountInput" oninput="updateAmountInWords()">
                                {{ $donor->amount }}
                            </span>
                        </p>
                    </div>

                    <div class="col-sm-6 mb-2">
                        <p><strong>
                                <span data-lang="hi">रुपये (शब्दों में):</span>
                                <span data-lang="en">Amount (in words):</span>
                            </strong>
                            <span data-lang="en" id="amount-words-en"></span>
                            <span data-lang="hi" id="amount-words-hi"></span>
                        </p>
                    </div>
                </div>

                {{-- Show Payment Method --}}
                <div class="row">
                    <div class="col-sm-6">
                        <p><strong>
                                <span data-lang="hi">भुगतान का प्रकार नकद/चेक/यूपीआई/अन्य द्वारा:</span>
                                <span data-lang="en">Payment Method (Cash/Cheque/UPI/Other):</span>
                            </strong>{{ $donor->payment_method }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p><strong>
                                <span data-lang="hi">दिनांक:</span>
                                <span data-lang="en">Date:</span>
                            </strong> {{ \Carbon\Carbon::parse($donor->date)->format('d-m-Y') }}</p>
                    </div>
                </div>

                {{-- Conditionally Show Cheque Details --}}
                @if ($donor->payment_method === 'Cheque')
                    <div class="row">
                        <div class="col-sm-3 mb-2"><strong>Cheque No:</strong> {{ $donor->cheque_no }}</div>
                        <div class="col-sm-3 mb-2"><strong>Bank Name:</strong> {{ $donor->bank_name }}</div>
                        <div class="col-sm-3 mb-2"><strong>Bank Branch:</strong> {{ $donor->bank_branch }}</div>
                        <div class="col-sm-3 mb-2"><strong>Cheque Date:</strong> {{ $donor->cheque_date }}</div>
                    </div>
                @endif

                {{-- Conditionally Show UPI Details --}}
                @if ($donor->payment_method === 'UPI')
                    <div class="row">
                        <div class="col-sm-6 mb-2"><strong>Transaction No:</strong> {{ $donor->transaction_no }}</div>
                        <div class="col-sm-6 mb-2"><strong>Transaction Date:</strong> {{ $donor->transaction_date }}</div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <p><strong>
                                <span data-lang="hi">जमाकर्ता का नाम:</span>
                                <span data-lang="en">Depositor Name:</span>
                            </strong> {{ $donor->depositor_name }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p>
                            <strong>
                                <span data-lang="hi">जमाकर्ता का संबंध:</span>
                                <span data-lang="en">Relationship:</span>
                            </strong> {{ $donor->relationship ?? null }}
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <p><strong>
                                <span data-lang="hi">प्राप्तकर्ता का नाम:</span>
                                <span data-lang="en">Recipient Name:</span>
                            </strong> {{ $donor->recipient_name }}</p>
                    </div>
                    <div class="col-sm-6">
                        <p>
                            <strong>
                                <span data-lang="hi">टिप्पणी / संदेश:</span>
                                <span data-lang="en">Remark:</span>
                            </strong> {{ $donor->remark }}
                        </p>
                    </div>
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
            const amountText = document.getElementById('amountInput').textContent;
            const amount = parseInt(amountText);
            if (isNaN(amount)) return;

            document.getElementById('amount-words-en').textContent = numberToWordsEN(amount);
            document.getElementById('amount-words-hi').textContent = numberToWordsHI(amount);
        }

        // Call on page load
        document.addEventListener('DOMContentLoaded', updateAmountInWords);
    </script>
@endsection
