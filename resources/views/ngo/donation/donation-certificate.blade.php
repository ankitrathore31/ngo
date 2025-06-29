@extends('ngo.layout.master')
@section('content')
    <style>
        .print-red-bg {
            background-color: #dc3545 !important;
            /* Bootstrap 'bg-danger' color */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color: white !important;
        }

        @media print {
            body * {
                visibility: hidden;
                font-size: 12px;

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
                max-width: 210mm;
                /* A4 width */
                padding: 15mm;
                /* Print-friendly padding */
                box-sizing: border-box;
            }

            html,
            body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            .print-red-bg {
                background-color: #dc3545 !important;
                /* Bootstrap 'bg-danger' color */
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: white !important;
            }


            @page {
                size: A4;
                margin: 20mm;
            }

            /* Optional: Hide any interactive or irrelevant UI */
            button,
            .btn,
            .no-print {
                display: none !important;
            }
        }
    </style>
    <div class="wrapper">
        <div class="d-flex justify-content-between align-record-centre mb-2 mt-3">
            <h5 class="mb-0">Donation Certificate</h5>
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">
                <span data-lang="hi">दान पंजीकरण फॉर्म</span>
                <span data-lang="en">Donation Registration Form</span>
            </h5>
            <div>
                <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button>
            </div>
            <div class=" d-flex justify-content-between">
                <a href="{{ route('donation-list') }}" class="btn btn-success">Donation List</a>
                <button onclick="window.print()" class="btn btn-primary">Print Certificate</button>
            </div>
        </div>
        <div class="container-fluid mt-2">
            <div class="card">
                <div class="card-body shadow rounded p-4 my-4 print-card">
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
                                <h4
                                    style="background-color: red; color: white; font-size: 28px; word-spacing: 8px; text-align: center;">
                                    <b>
                                        <span data-lang="hi">ज्ञान भारती संस्था</span>
                                        <span data-lang="en">GYAN BHARTI SANSTHA</span>
                                    </b>
                                </h4>
                                <h6 style="color: blue;"><b>
                                        <span data-lang="hi">ग्राम - कैंचू टांडा, पोस्ट - अमरिया, जिला - पीलीभीत, उत्तर
                                            प्रदेश -
                                            262121</span>
                                        <span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District - Pilibhit, UP
                                            -
                                            262121</span>
                                    </b></h6>
                                <p style="margin: 0;">
                                    <span data-lang="hi"><b>आयकर अधिनियम 80G, 12A, के अंतर्गत रजिस्टर्ड</b></span>
                                    <span data-lang="en"><b>Registered under Income Tax Act 80G, 12A</b></span>
                                </p>
                                <p style="margin: 0;"><b>
                                        <span data-lang="hi">पंजीकरण सं.: 80G-AAEAG7650BF20231 | 12A: AAEAG7650BE20231 |
                                            दिनांक:
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
                    <div class="row ">

                    </div>

                    <div class="row d-flex justify-content-between">
                        <div class="col-md-4">
                            <strong>Receipt No:</strong> {{ $donor->receipt_no }}
                        </div>

                        <div class="col-4">
                            <h4 class="text-center mb-4 bg-danger text-white p-2">
                                <strong data-lang="en">DONATION CERTIFICATE</strong>
                                <strong data-lang="hi">डोनेशन प्रमाण पत्र</strong>
                            </h4>
                        </div>
                        <div class="col-md-4 text-end">
                            <strong>Date:</strong> {{ \Carbon\Carbon::parse($donor->date)->format('d-m-Y') }}
                        </div>
                        {{-- <div class="col-md-4">
                            <strong>Session:</strong> {{ $donor->academic_session }}
                        </div> --}}
                    </div>

                    <p style="font-size: 1.2rem; line-height: 1.8;" data-lang="hi">
                        यह प्रमाणित किया जाता है कि
                        <strong>ज्ञान भारती संस्था</strong> को
                        <strong class="text-success">₹{{ $donor->amount }}</strong>
                        की राशि <strong>{{ $donor->name }}</strong>
                        पुत्र/पत्नी <strong>{{ $donor->gurdian_name }}</strong>, निवासी
                        <strong>{{ $donor->address }}</strong>
                        द्वारा दान स्वरूप प्राप्त हुई है। संस्था इस धनराशि का उपयोग
                        गरीब, असहाय एवं निराश्रित लोगों के कल्याण हेतु करेगी। संस्था
                        आपके उज्ज्वल भविष्य की कामना करती है एवं आपका हार्दिक आभार प्रकट करती है।
                    </p>

                    <hr>

                    <p style="font-size: 1.2rem; line-height: 1.8;" data-lang="en">
                        This is to certify that <strong>Gyan Bharti Sanstha</strong> has received a donation of
                        <strong class="text-success">₹{{ $donor->amount }}</strong> from
                        <strong>{{ $donor->name }}</strong>,
                        S/O or W/O <strong>{{ $donor->gurdian_name }}</strong>, resident of
                        <strong>{{ $donor->address }}</strong>. The Sanstha will utilize this amount for the welfare
                        of the poor, helpless and destitute. We sincerely thank you and wish you a bright future.
                    </p>

                    <div class="mt-5 d-flex justify-content-between">
                        <div>

                            <strong>Payment Method:</strong> {{ ucfirst($donor->payment_method) }}
                        </div>

                        <div class="text-end">
                            <strong>Authorized Signature</strong><br><br>
                            {{-- <img src="{{ asset('images/signature.png') }}" alt="Signature" height="60"> --}}
                            <!-- optional -->
                        </div>
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
