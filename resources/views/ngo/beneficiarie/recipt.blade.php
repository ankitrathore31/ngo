@extends('ngo.layout.master')
@section('content')
    <style>
        .print-red-bg {
            background-color: red !important;
            /* Bootstrap 'bg-danger' color */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color: white !important;

        }

        .print-h4 {
            background-color: red !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            font-size: 28px;
            word-spacing: 20px;
            text-align: center;
        }

        .flag-border {
            border: 8px solid;
            border-image: linear-gradient(to right, #FF9933 33%, , #138808 66%) 1;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        .receipt-text {
            font-size: 18px;
            line-height: 1.7;
            text-align: justify;
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
                max-width: 510mm;
                /* A4 width */
                padding: 10mm;
                /* Print-friendly padding */
                box-sizing: border-box;
            }

            html,
            body {
                width: 510mm;
                height: auto;
                margin: 0;
                padding: 0;
                overflow: hidden;
            }

            .print-red-bg {
                background-color: red !important;
                /* Bootstrap 'bg-danger' color */
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: white !important;

            }

            .print-h4 {
                background-color: red !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                font-size: 28px;
                word-spacing: 20px;
                text-align: center;
            }

            .flag-border {
                border: 8px solid;
                border-image: linear-gradient(to right, #FF9933 33%, #138808 66%) 1;
                padding: 15px;
                border-radius: 10px;
                text-align: center;
            }

            @page {
                size: A4;
                margin: 15mm;
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
        <div class="d-flex justify-content-between align-beneficiarie-centre mb-0 mt-4">
            <h5 class="mb-0">Distribute Facilities Receipt</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-beneficiarie"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-beneficiarie active" aria-current="page">Receipt</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container-fluid mt-5">
            <!-- Language Toggle -->
            <div class="d-flex justify-content-between align-beneficiaries-center mb-3 mt-4">
                <h5 class="mb-0">
                    <span>Receipt</span>
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">Print </button>

                    <button class="btn btn-sm btn-primary" onclick="setLang('en')">English</button>
                    <button class="btn btn-sm btn-success" onclick="setLang('hi')">हिन्दी</button>

                </div>
            </div>
            <div class=" rounded print-card">
                <div class="" style="border: 9px solid red;">
                    <div>
                        <div class="p-2" style="border: 9px solid #138808;">
                            <div class="text-center mb-4 border-bottom pb-2">
                                <div class="row mb-2">
                                    <div class="col-sm-12">
                                        <h3 class="receipt-en"><b>Distribution Material Receipt</b></h3>
                                        <h5 class=" receipt-hi d-none">वितरण सामग्री प्राप्ति रसीद</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2 text-center text-md-start">
                                        <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="150"
                                            height="140">
                                    </div>
                                    <div class="col-sm-8">
                                        <p style="margin: 0;" class="d-flex justify-content-around mb-2"><b>
                                                <span>NEETI AYOG ID NO. UP/2023/0360430</span>&nbsp;
                                                &nbsp; &nbsp;<span>NGO NO. UP/00033062</span>&nbsp; &nbsp;
                                                &nbsp; &nbsp;<span>PAN: AAEAG7650B</span>&nbsp;
                                            </b></p>
                                        <h3 class="P-2"><b>
                                                <span class="print-h4 p-2">GYAN BHARTI SANSTHA</span>
                                            </b></h3>
                                        <h5> <strong>
                                                <span>The Path To Peace And Development</span></strong></h5>
                                        <h6 style="color: blue;"><b>
                                                <span data-lang="hi">ग्राम - कैंचू टांडा, पोस्ट - अमरिया, जिला - पीलीभीत,
                                                    उत्तर प्रदेश -
                                                    262121</span>
                                                <span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District -
                                                    Pilibhit, UP -
                                                    262121</span>
                                            </b></h6>
                                        <p style="font-size: 14px; margin: 0;">
                                            <b>
                                                <span>Website: www.gyanbhartingo.org | Email: gyanbhartingo600@gmail.com
                                                    | Mob:
                                                    9411484111</span>
                                            </b>
                                        </p>
                                    </div>
                                    <div class="col-sm-2 text-center text-md-start">
                                        {{-- <img src="{{ asset('images/plu.png') }}" alt="Logo" width="120"
                                            height="130"> --}}
                                    </div>
                                </div>
                            </div>
                            <!-- ENGLISH RECEIPT -->
                            <p class="receipt-text receipt-en">
                                This is to certify that I,
                                <strong>{{ $beneficiarie->name }}</strong>,
                                son/daughter of
                                <strong>{{ $beneficiarie->gurdian_name }}</strong>,
                                resident of village
                                <strong>{{ $beneficiarie->village }}</strong>,
                                Post <strong>{{ $beneficiarie->post }}</strong>,
                                District <strong>{{ $beneficiarie->district }}</strong>,
                                State <strong>{{ $beneficiarie->state }}</strong>,
                                Pin Code <strong>{{ $beneficiarie->pincode }}</strong>,
                                have received
                                <strong>{{ $survey->facilities }}</strong>
                                from <strong>Gyan Bharti Sanstha</strong>
                                on
                                <strong>{{ \Carbon\Carbon::parse($survey->distribute_date)->format('d-m-Y') }}</strong>.
                                I am very happy.
                            </p>

                            <!-- HINDI RECEIPT -->
                            <p class="receipt-text receipt-hi d-none">
                                प्रमाणित किया जाता है कि मैं
                                <strong>{{ $beneficiarie->name }}</strong>
                                पुत्र/पुत्री
                                <strong>{{ $beneficiarie->gurdian_name }}</strong>,
                                ग्राम <strong>{{ $beneficiarie->village }}</strong>,
                                पोस्ट <strong>{{ $beneficiarie->post }}</strong>,
                                जिला <strong>{{ $beneficiarie->district }}</strong>,
                                राज्य <strong>{{ $beneficiarie->state }}</strong>,
                                पिन कोड <strong>{{ $beneficiarie->pincode }}</strong>
                                का निवासी हूँ।
                                मुझे दिनांक
                                <strong>{{ \Carbon\Carbon::parse($survey->distribute_date)->format('d-m-Y') }}</strong>
                                को <strong>ज्ञान भारती संस्था</strong> के द्वारा
                                <strong>{{ $survey->facilities }}</strong>
                                प्राप्त हुआ है।
                                मुझे बहुत खुशी हो रही है।
                            </p>
                            <div class="row d-flex justify-content-around mt-5">
                                <div class="col-sm-6 text-center">
                                </div>

                                <div class="col-sm-6 text-center">
                                    @if (!empty($signatures['director']) && file_exists(public_path($signatures['director'])))
                                        <div id="directorSignatureBox" class="mt-2">
                                            <p class="text-success no-print">Attached</p>
                                            <img src="{{ asset($signatures['director']) }}" alt="Director Signature"
                                                class="img" style="max-height: 80px;">
                                            <br>
                                            <button class="btn btn-danger btn-sm mt-2 no-print"
                                                onclick="toggleDirector(false)">Remove</button>
                                        </div>

                                        <div id="directorShowBtnBox" class="mt-2 d-none no-print">
                                            <button class="btn btn-primary btn-sm" onclick="toggleDirector(true)">Attached
                                                Signature</button>
                                        </div>
                                    @else
                                        <p class="text-muted mt-2 no-print">Not attached</p>
                                    @endif
                                    <strong class="text-danger">Digitally Signed By <br>
                                        MANOJ KUMAR RATHOR <br>
                                        DIRECTOR
                                    </strong><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function togglePM(show) {
            document.getElementById('pmSignatureBox').classList.toggle('d-none', !show);
            document.getElementById('pmShowBtnBox').classList.toggle('d-none', show);
        }

        function toggleDirector(show) {
            document.getElementById('directorSignatureBox').classList.toggle('d-none', !show);
            document.getElementById('directorShowBtnBox').classList.toggle('d-none', show);
        }
    </script>
    <script>
        function setLang(lang) {
            const en = document.querySelector('.receipt-en');
            const hi = document.querySelector('.receipt-hi');

            if (lang === 'hi') {
                en.classList.add('d-none');
                hi.classList.remove('d-none');
            } else {
                hi.classList.add('d-none');
                en.classList.remove('d-none');
            }
        }
    </script>
@endsection
