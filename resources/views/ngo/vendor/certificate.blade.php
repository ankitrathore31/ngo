@extends('ngo.layout.master')
@Section('content')
    <style>
        .isi-certificate {
            border: 6px solid #b30000;
            /* ISI-style red */
            background-color: #ffffff;
            font-family: "Times New Roman", Times, serif;
            max-width: 510mm;
        }

        .isi-certificate {
            background: #ffffff;
            padding: 40px;
            position: relative;
            font-family: "Georgia", "Times New Roman", serif;
        }

        .isi-certificate::before {
            content: "";
            position: absolute;
            inset: 15px;
            border: 2px dashed #c9a227;
            pointer-events: none;
        }

        .certificate-header h2 {
            color: #0d3b66;
            letter-spacing: 1px;
        }

        .certificate-title {
            font-size: 26px;
            font-weight: bold;
            color: #8b0000;
            text-decoration: underline;
        }

        .certificate-text {
            color: #333;
            line-height: 1.8;
            text-align: justify;
        }

        .highlight {
            color: #0d3b66;
            font-weight: bold;
        }

        .info-box {
            background: #f8f9fa;
            border-left: 5px solid #0d3b66;
            padding: 15px;
            border-radius: 6px;
        }

        .signature-box {
            border-top: 2px solid #333;
            display: inline-block;
            padding-top: 10px;
            margin-top: 15px;
            text-align: center;
        }

        .official-text {
            color: #8b0000;
            font-weight: bold;
            text-transform: uppercase;
        }



        .certificate-text p {
            text-align: justify;
            line-height: 1.8;
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
            border-image: linear-gradient(to right, #FF9933 33%, , #138808 66%) 1;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        @media print {
            body * {
                visibility: hidden;
                font-size: 18px;

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
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Vendor Certificate</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
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
            <div class="container my-5">
                <div class="d-flex justify-content-between align-records-center mb-3 mt-4">
                    <h5 class="mb-0">
                        <span>Vendor / Shop / Farm Certificate</span>
                    </h5>
                    <div>
                        <button onclick="window.print()" class="btn btn-primary">Print </button>
                        {{-- <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button> --}}
                    </div>
                </div>
                <div class="isi-certificate print-card">

                    <!-- Header -->
                    <div class="text-center mb-4 certificate-header">
                        <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="160">
                        <p class="certificate-title mt-3">
                            Vendor / Shop / Farm Registration Certificate
                        </p>
                    </div>

                    <!-- Certificate Content -->
                    <div class="certificate-text fs-5 mt-4">

                        <p>
                            This is to certify that
                            <span class="highlight text-uppercase">{{ $vendor->shop }}</span>,
                            operated by
                            <span class="highlight text-uppercase">{{ $vendor->name }}</span>,
                            has been duly registered as a
                            <span class="highlight">{{ $vendor->vendor_type }}</span>
                            under the <strong>Vendor / Shop / Farm Registration System</strong> &
                            Their registration number is <span class="highlight">{{ $vendor->registration_no }}</span>.
                        </p>

                        <p>
                            The registered place of Vendor / Shop / Farm is situated at
                            <strong>
                                {{ $vendor->village }}, {{ $vendor->post }},
                                {{ $vendor->block }}, {{ $vendor->district }},
                                {{ $vendor->state }}
                            </strong>.
                        </p>

                        <p>
                            The registration has been granted after due verification of required
                            documents including identity proof, PAN, GST (where applicable),
                            and banking credentials.
                        </p>

                        <p>
                            This certificate shall remain valid subject to continuous compliance
                            with applicable rules, terms, and conditions prescribed by the
                            competent authority.
                        </p>
                    </div>

                    <!-- Registration Details -->
                    <div class="row mt-4 fs-5">
                        <div class="col-sm-6">
                            <div class="info-box">
                                <p><strong>Registration No:</strong> {{ $vendor->registration_no }}</p>
                                <p>
                                    <strong>Registration Date:</strong>
                                    {{ \Carbon\Carbon::parse($vendor->registration_date)->format('d M, Y') }}
                                </p>
                                <p><strong>Session:</strong> {{ $vendor->academic_session }}</p>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="info-box">
                                <p><strong>Mobile:</strong> {{ $vendor->mobile }}</p>
                                <p><strong>Email:</strong> {{ $vendor->email ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="row mt-5">
                        <div class="col-sm-12 text-end">

                            @if (!empty($signatures['director']) && file_exists(public_path($signatures['director'])))
                                <img src="{{ asset($signatures['director']) }}" alt="Director Signature"
                                    style="max-height: 80px;">
                            @endif
                            <br>
                            <div class="signature-box">
                                <span class="official-text">
                                    Digitally Signed By <br>
                                    Manoj Kumar Rathor <br>
                                    Director <br>
                                    GYAN BHARTI SANSTHA
                                </span>
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
@endsection
