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
        <div class="d-flex justify-content-between align-item-centre mb-0 mt-4">
            <h5 class="mb-0">Training Certificate</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Certificate</li>
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
            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h5 class="mb-0">
                    {{-- <span data-lang="hi">दान रसीद</span> --}}
                    <span>Training Certificate</span>
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">Print Certificate</button>
                    <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button>
                </div>
            </div>
            <div class="card shadow rounded p-4 my-4 border border-dark print-card">
                <div class="text-center mb-4 border-bottom pb-2">
                    <!-- Header -->
                    <div class="row">
                        <div class="col-sm-2 text-center text-md-start">
                            <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="120" height="120">
                        </div>
                        <div class="col-sm-10">
                            <p style="margin: 0;" class="d-flex justify-content-around"><b>
                                    <span>NEETI AYOG ID NO. UP/2023/0360430</span>&nbsp;
                                    &nbsp; &nbsp;<span>NGO NO. UP/00033062</span>&nbsp; &nbsp;
                                    &nbsp; &nbsp;<span>PAN: AAEAG7650B</span>&nbsp;
                                </b></p>
                            <h4 class="print-h4 p-1"><b>
                                    <span data-lang="hi">ज्ञान भारती संस्था</span>
                                    <span data-lang="en">GYAN BHARTI SANSTHA</span>
                                </b></h4>
                            <h6 style="color: blue;"><b>
                                    <span data-lang="hi">ग्राम - कैंचू टांडा, पोस्ट - अमरिया, जिला - पीलीभीत, उत्तर प्रदेश -
                                        262121</span>
                                    <span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District - Pilibhit, UP -
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
                    </div>
                </div>


                <div class="row d-flex justify-content-center   ">
                    <div class="col-sm-6 mb-2">
                        <p class="text-center fw-bold p-2 print-red-bg">
                            <span data-lang="hi">प्रशिक्षण प्रमाणपत्र</span>
                            <span data-lang="en">Training Certificate</span>
                        </p>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 mb-2">
                        <p><strong>
                                <span data-lang="hi">प्रमाण-पत्र क्रमांक:</span>
                                <span data-lang="en">Certificate No.:</span>
                            </strong> &nbsp;{{ $record->certificate_no }}</p>
                    </div>

                    <div class="col-sm-4 mb-2">
                        <p><strong>
                                <span data-lang="hi">पंजीकरण क्रमांक:</span>
                                <span data-lang="en">Registration No.:</span>
                            </strong> &nbsp;{{ $record->beneficiare->registration_no }}</p>
                    </div>

                    <div class="col-sm-4 mb-2">
                        <p><strong>
                                <span data-lang="hi">रोल नं.</span>
                                <span data-lang="en">Roll No.: </span>
                            </strong> &nbsp;
                            {{ $record->roll_no }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <div class="d-flex align-items-center w-100">
                            <strong class="mr-2" style="white-space: nowrap;">
                                <span data-lang="hi">प्रमाणित किया जाता है कि श्री/कुमारी/श्रीमती</span>
                                <span data-lang="en">It is Certified that Shri/Km./Smt:</span>
                            </strong>
                            <div class="flex-grow-1 border-bottom border-dark text-break">
                                &nbsp; {{ $record->beneficiare->name }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-2">
                        <div class="d-flex align-items-center w-100">
                            <strong class="mr-2" style="white-space: nowrap;">
                                <span data-lang="hi">पिता/पति का नाम</span>
                                <span data-lang="en">Father/Husband's Name:</span>
                            </strong>
                            <div class="flex-grow-1 border-bottom border-dark text-break">
                                &nbsp;{{ $record->beneficiare->gurdian_name }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 mb-2">
                        <div class="d-flex align-items-center w-100">
                            <strong class="mr-2" style="white-space: nowrap;">
                                <span data-lang="hi">गांव/मोहल्ला</span>
                                <span data-lang="en">Village/Locality</span>:
                            </strong>
                            <div class="flex-grow-1 border-bottom border-dark text-break">
                                &nbsp;{{ $record->beneficiare->village }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 mb-2">
                        <div class="d-flex align-items-center w-100">
                            <strong class="mr-2" style="white-space: nowrap;">
                                <span data-lang="hi">पोस्ट/कस्बा</span>
                                <span data-lang="en">Post/Town</span>:
                            </strong>
                            <div class="flex-grow-1 border-bottom border-dark text-break">
                                &nbsp;{{ $record->beneficiare->post }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 mb-2">
                        <div class="d-flex align-items-center w-100">
                            <strong class="mr-2" style="white-space: nowrap;">
                                <span data-lang="hi">जिला</span>
                                <span data-lang="en">District</span>:
                            </strong>
                            <div class="flex-grow-1 border-bottom border-dark text-break">
                                &nbsp;{{ $record->beneficiare->district }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 mb-2">
                        <div class="d-flex align-items-center w-100">
                            <strong class="mr-2" style="white-space: nowrap;">
                                <span data-lang="hi">राज्य</span>
                                <span data-lang="en">State</span>:
                            </strong>
                            <div class="flex-grow-1 border-bottom border-dark text-break">
                                &nbsp;{{ $record->beneficiare->state }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2 mb-2">
                        <div class="d-flex align-items-start w-100">
                            <strong class="mr-2" style="white-space: nowrap;">
                                <span data-lang="hi">देश</span>
                                <span data-lang="en">Country</span>:
                            </strong>
                            <div class="flex-grow-1 border-bottom border-dark text-break">
                                {{ $record->beneficiare->country }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-7 mb-2">
                        <div class="d-flex align-items-start w-100">
                            <strong class="mr-2" style="white-space: nowrap;">
                                <span data-lang="hi">पाठ्यक्रम/गतिविधि पूरी की</span>
                                <span data-lang="en">Completed the course/Activity in</span>
                            </strong>
                            <div class="flex-grow-1 border-bottom border-dark text-break">
                                &nbsp;{{ $record->training_course }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mb-2">
                        <div class="d-flex align-items-start w-100">
                            <strong class="mr-2" style="white-space: nowrap;">
                                <span data-lang="hi">द्वारा आयोजित</span>
                                <span data-lang="en">Organised by</span>
                            </strong>
                            <div class="flex-grow-1 border-bottom border-dark text-break">
                                &nbsp;{{ $center->center_code }}, {{ $center->center_name }},
                                {{ $center->center_address }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 mb-2">
                        <div class="d-flex align-items-start w-100">
                            <strong class="mr-2" style="white-space: nowrap;">
                                <span data-lang="hi">प्रशिक्षण प्रारंभ तिथि</span>
                                <span data-lang="en">Training start date </span>
                            </strong>
                            <div class="flex-grow-1 border-bottom border-dark text-break">
                                &nbsp;{{ \Carbon\Carbon::parse($record->start_date)->format('d-m-Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 mb-2">
                        <div class="d-flex align-items-start w-100">
                            <strong class="mr-2" style="white-space: nowrap;">
                                <span data-lang="hi">प्रशिक्षण समाप्ति तिथि</span>
                                <span data-lang="en">Training end date </span>
                            </strong>
                            <div class="flex-grow-1 border-bottom border-dark text-break">
                                &nbsp;{{ \Carbon\Carbon::parse($record->end_date)->format('d-m-Y') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 mb-2">
                        <div class="d-flex align-items-start w-100">
                            <strong class="mr-2" style="white-space: nowrap;">
                                <span data-lang="hi">अवधि</span>
                                <span data-lang="en">Training Duration</span>
                            </strong>
                            <div class="flex-grow-1 border-bottom border-dark text-break">
                                &nbsp;{{ $record->duration }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <div class="d-flex align-items-start w-100">
                            <strong>
                                <span data-lang="en">Successfully and secured</span>
                                <span data-lang="hi">सफलतापूर्वक एवं सुरक्षित</span>
                                <span data-lang="hi">श्रेणी</span>
                                <span data-lang="en">grade</span>
                            </strong>
                            <div class="flex-grow-1 border-bottom border-dark text-break">
                                &nbsp;{{ $record->grade }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-2">
                        <div class="d-flex align-items-start w-100">
                            <strong class="mr-2" style="white-space: nowrap;">
                                <span data-lang="hi">विशेष प्रतिभा.</span>
                                <span data-lang="en">Special Talent.</span>
                            </strong>
                            <div class="flex-grow-1 border-bottom border-dark text-break">
                                &nbsp;{{ $record->talent }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-between">
                    <div class="col-sm-3 mb-2">
                        <div class="d-flex align-items-start w-100">
                            <strong class="mr-2" style="white-space: nowrap;">
                                <span data-lang="hi">जारी करने की तिथि</span>
                                <span data-lang="en">Issue Date</span>
                            </strong>
                            <div class="flex-grow-1 border-bottom border-dark text-break">
                                &nbsp;{{ isset($record->issue_date) ? \Carbon\Carbon::parse($record->issue_date)->format('d-m-Y') : '' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-5 mb-2">
                        <div class="d-flex align-items-start w-100">
                            <strong class="mr-2" style="white-space: nowrap;">
                                <span data-lang="hi">आधार नं.</span>
                                <span data-lang="en">AADHAR NO.</span>
                            </strong>
                            <div class="flex-grow-1 border-bottom border-dark text-break">
                                &nbsp; {{ $record->beneficiare->identity_no }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-between mt-5">
                    <div class="col-sm-4 text-center">
                        @if (!empty($signatures['program_manager']) && file_exists(public_path($signatures['program_manager'])))
                            <div id="pmSignatureBox" class="mt-2">
                                <p class="text-success no-print">Attached</p> <!-- This line is hidden in print -->
                                <img src="{{ asset($signatures['program_manager']) }}" alt="PM Signature" class="img"
                                    style="max-height: 100px;"> <!-- This will print -->
                                <br>
                                <button class="btn btn-danger btn-sm mt-2 no-print"
                                    onclick="togglePM(false)">Remove</button>
                            </div>
                        @else
                            <p class="text-muted mt-2 no-print">Not attached</p> <!-- Hidden only in print -->
                        @endif
                        <strong>Digitally Signed By <br>
                            DROPTI DEVI RATHOR <br>
                            PROGRAM OFFICER
                        </strong><br>
                    </div>

                    <div class="col-sm-4 text-center">
                        @if (!empty($signatures['director']) && file_exists(public_path($signatures['director'])))
                            <div id="directorSignatureBox" class="mt-2">
                                <p class="text-success no-print">Attached</p>
                                <img src="{{ asset($signatures['director']) }}" alt="Director Signature" class="img"
                                    style="max-height: 100px;">
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
                        <strong>Digitally Signed By <br>
                            MANOJ KUMAR RATHOR <br>
                            DIRECTOR
                        </strong><br>
                    </div>
                </div>

                <div class="col-sm-12 text-center mt-2 fw-bold">
                    Grade Marks : A=76 to 100 B= 51 to 75 C= 26 to 50 D= 1 to 25
                </div>
            </div>
        </div>
        <script>
            function setLanguage(lang) {
                document.querySelectorAll('[data-lang]').forEach(el => {
                    el.style.display = el.getAttribute('data-lang') === lang ? 'inline' : 'none';
                });
            }
            window.onload = () => setLanguage('en'); // Set Eng as default
        </script>
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
