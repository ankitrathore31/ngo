@extends('ngo.layout.master')
@section('content')
    <style>
        body {
            background: #f2f2f2;
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }

        .letter-container {
            width: 210mm;
            height: 297mm;
            padding: 20mm;
            box-sizing: border-box;
            background: white;
            margin: 0 auto;
        }

        .print-red-bg {
            background-color: red;
            color: white;
            padding: 4px 8px;
            text-align: center;
        }

        .print-h4 {
            font-size: 28px;
            word-spacing: 8px;
            background-color: red;
            color: white;
            text-align: center;
            padding: 5px 0;
        }

        .no-print {
            display: none;
        }

        /* PRINT STYLES */
        @media print {
            @page {
                size: A4;
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
                background: white !important;
            }

            body * {
                visibility: hidden;
            }

            .letter-container,
            .letter-container * {
                visibility: visible;
            }

            .letter-container {
                position: absolute;
                top: 0;
                left: 0;
                width: 210mm;
                height: 297mm;
                padding: 20mm;
                background: white !important;
                box-sizing: border-box;
            }

            .print-red-bg,
            .print-h4 {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                background-color: red !important;
                color: white !important;
            }

            .no-print {
                display: none !important;
            }

            .text-center,
            .text-center * {
                font-size: 12px !important;
                line-height: 1.2 !important;
            }

            .text-center img {
                width: 60px !important;
                height: 60px !important;
            }



            .col-sm-2 {
                width: 20% !important;
                text-align: left !important;
            }

            .col-sm-10 {
                width: 80% !important;
            }

            h4.print-h4 {
                font-size: 20px !important;
                padding: 3px 0 !important;
            }

            h6,
            p {
                margin: 0 !important;
                padding: 0 !important;
            }

            p.d-flex {
                display: flex !important;
                justify-content: space-between !important;
                font-weight: bold !important;
                font-size: 11px !important;
            }

        }
    </style>


    <div class="wrapper">
        <div class="d-flex justify-content-between aligin-item-center mb-3 mt-2">
            <h5 class="mb-0">Staff Appointment Letter</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Appointment Letter</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h5 class="mb-0">
                    <span> Letter</span>
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">Print Letter</button>
                    <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button>
                </div>
            </div>
            <div class="letter-container border print-area">
                <div class="p-4">
                    <div class="text-center mb-4 border-bottom pb-3 mb-2">
                        <!-- Header -->
                        <div class="row">
                            <div class="col-sm-2 text-center text-md-start">
                                <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80" height="80">
                            </div>
                            <div class="col-sm-10">
                                <p class="d-flex justify-content-between w-100" style="margin: 0; font-weight: bold;">
                                    <span>CSR NO. CSR00059991</span>
                                    <span>12A AAEAG7650BE20231</span>
                                    <span>80G AAEAG7650BF20231</span>
                                </p>

                                <p class="d-flex justify-content-between w-100" style="margin: 0; font-weight: bold;">
                                    <span>NEETI AYOG ID NO. UP/2023/0360430</span>
                                    <span>NGO NO. UP/00033062</span>
                                    <span>PAN: AAEAG7650B</span>
                                </p>

                                <h4 class="text-center print-h4" style="margin: 0;">
                                    <span data-lang="hi" style="font-size: inherit; font-weight: inherit;">ज्ञान भारती
                                        संस्था</span>
                                    <span data-lang="en" style="font-size: inherit; font-weight: inherit;">GYAN BHARTI
                                        SANSTHA</span>
                                </h4>

                                <h6 class="w-100" style="color: blue; font-weight: bold; margin: 0;">
                                    <span data-lang="hi">ग्राम - कैंचू टांडा, पोस्ट - अमरिया, जिला - पीलीभीत, उत्तर प्रदेश -
                                        262121</span>
                                    <span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District - Pilibhit, UP -
                                        262121</span>
                                </h6>

                                <p class="w-100" style="font-size: 14px; margin: 0; font-weight: bold;">
                                    Website: www.gyanbhartingo.org | Email: gyanbhartingo600@gmail.com | Mob: 9411484111
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="container py-4" style="font-size: 16px; line-height: 1.8;">
                        <div class=" d-flex justify-content-between mb-3">
                            <div>
                                <strong>
                                    <span data-lang="hi">दिनांक</span>
                                    <span data-lang="en">Date:</span>
                                </strong>
                                {{ \Carbon\Carbon::parse($staff->appointment_date)->format('d-m-Y') }}
                            </div>
                            <div>
                                <strong>
                                    {{-- <span data-lang="hi">दिनांक</span> --}}
                                    <span>Session:</span>
                                </strong>
                                {{ $staff->academic_session }}
                            </div>
                        </div>

                        <div class="mb-2">
                            <strong>
                                <span data-lang="hi">प्रति</span><br>
                                <span data-lang="en">To:</span>
                            </strong><br>
                            {{ $staff->name }} <br>
                            {{ $staff->village }},{{ $staff->post }},{{ $staff->block }},
                            {{ $staff->district }},{{ $staff->state }},({{ $staff->pincode }})
                        </div>

                        <div class="mb-2">
                            <strong>
                                <span data-lang="hi">विषय</span><br>
                                <span data-lang="en">Subject:</span>
                            </strong>
                            &nbsp; Appointment as {{ $staff->position }}
                        </div>

                        <div class="mb-4">
                            Dear {{ $staff->name }}, <br>

                            We are pleased to inform you that you have been appointed as a {{ $staff->position }} at Gyan
                            Bharti
                            Sanstha with effect from {{ $staff->joining_date }}. <br>
                            Date of Joining: {{ $staff->joining_date }} <br>
                            Salary: You will be paid a monthly salary of ₹{{ $salary->salary }} as per the organization's
                            norms. <br>
                            Duties & Responsibilities: You are expected to perform your duties diligently and comply with
                            all organizational policies. <br>
                            We welcome you to the Gyan Bharti Sanstha family and look forward to a successful association.
                            Please sign and return a copy of this letter as a token of acceptance.
                        </div>

                        <div class="row d-flex justify-content-end mt-5">
                            {{-- <div class="col-sm-4 text-center">
                                @if (!empty($signatures['program_manager']) && file_exists(public_path($signatures['program_manager'])))
                                    <div id="pmSignatureBox" class="mt-2">
                                        <p class="text-success no-print">Attached</p> <!-- This line is hidden in print -->
                                        <img src="{{ asset($signatures['program_manager']) }}" alt="PM Signature"
                                            class="img" style="max-height: 100px;"> <!-- This will print -->
                                        <br>
                                        <button class="btn btn-danger btn-sm mt-2 no-print"
                                            onclick="togglePM(false)">Remove</button>
                                    </div>
                                @else
                                    <p class="text-muted mt-2 no-print">Not attached</p> <!-- Hidden only in print -->
                                @endif
                                <strong>Program Officer & Program Manager Signature with stamp</strong><br>
                            </div> --}}

                            <div class="col-sm-5">
                                Yours sincerely, <br>
                                @if (!empty($signatures['director']) && file_exists(public_path($signatures['director'])))
                                    <div id="directorSignatureBox" class="mt-2">
                                        <p class="text-success no-print">Attached</p>
                                        <img src="{{ asset($signatures['director']) }}" alt="Director Signature"
                                            class="img" style="max-height: 100px;">
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
                                @endif <br>
                                <strong>Digitally Signed By <br>
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
        function setLanguage(lang) {
            document.querySelectorAll('[data-lang]').forEach(el => {
                el.style.display = el.getAttribute('data-lang') === lang ? 'inline' : 'none';
            });
        }
        window.onload = () => setLanguage('en'); // Set Eng as default
    </script>
@endsection
