@extends('ngo.layout.master')
@Section('content')
    <style>
        .isi-certificate {
            border: 6px solid #b30000;
            /* ISI-style red */
            background-color: #ffffff;
            font-family: "Times New Roman", Times, serif;
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
                        <span>Certificate</span>
                    </h5>
                    <div>
                        <button onclick="window.print()" class="btn btn-primary">Print </button>
                        {{-- <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button> --}}
                    </div>
                </div>
                <div class="isi-certificate p-5 print-card">

                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-uppercase">VENDOR/SHOP/FARM CERTIFICATE</h2>
                    </div>

                    <!-- Certificate Content -->
                    <div class="certificate-text fs-5">

                        <p>
                            This is to certify that
                            <span class="fw-bold text-uppercase">
                                {{ $vendor->shop }}
                            </span>,
                            operated by
                            <span class="fw-bold text-uppercase">
                                {{ $vendor->name }}
                            </span>,
                            has been duly registered as a
                            <span class="fw-bold">
                                {{ $vendor->vendor_type }}
                            </span>
                            under the Vendor / Shop / Farm Registration System.
                        </p>

                        <p>
                            The registered place of  Vendor/ Shop/ farm is located at
                            {{ $vendor->village }}, {{ $vendor->post }},
                            {{ $vendor->block }}, {{ $vendor->district }},
                            {{ $vendor->state }}.
                        </p>

                        <p>
                            The registration has been granted after verification of
                            required documents including identity proof, PAN, GST
                            (where applicable), and banking details.
                        </p>

                        <p>
                            This certificate shall remain valid subject to continuous
                            compliance with the terms, conditions, and provisions
                            prescribed by the competent authority.
                        </p>
                    </div>

                    <!-- Registration Details -->
                    <div class="row mt-4 fs-5">
                        <div class="col-md-6">
                            <p>Vendor/Shop/Farm Registration No: {{ $vendor->registration_no }}</p>

                            <p>
                                Vendor/Shop/Farm Registration Date:
                                {{ \Carbon\Carbon::parse($vendor->registration_date)->format('d M, Y') }}
                            </p>

                            <p>
                                Vendor/Shop/Farm Session:
                                {{ $vendor->academic_session }}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <p>Vendor/Shop/Farm Mobile: {{ $vendor->mobile }}</p>
                            <p>Vendor/Shop/Farm Email: {{ $vendor->email ?? '-' }}</p>
                        </div>
                    </div>


                    <!-- Footer -->
                    <div class="row mt-5 align-items-end">
                        <div class="col-sm-11 text-end">
                            @if (!empty($signatures['director']) && file_exists(public_path($signatures['director'])))
                                <div id="directorSignatureBox" class="mt-2">
                                    <p class="text-success no-print">Attached</p>
                                    <img src="{{ asset($signatures['director']) }}" alt="Director Signature" class="img"
                                        style="max-height: 80px;">
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
