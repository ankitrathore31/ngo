@extends('ngo.layout.master')
@section('content')
    <style>
        .print-red-bg {
            background-color: red !important;
            /* Bootstrap 'bg-danger' color */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color: white !important;
            font-size: 18px;
        }

        .print-h4 {
            background-color: red !important;
            color: white !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            font-size: 28px;
            word-spacing: 8px;
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
                padding: 10mm;
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
                word-spacing: 8px;
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
            <h5 class="mb-0">Member Certificate</h5>
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
        <div class="container-fluid">
            <!-- Language Toggle -->
            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h5 class="mb-0">
                    {{-- <span data-lang="hi">दान रसीद</span> --}}
                    <span>Member Certificate</span>
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
                            <p style="margin: 0;" class="d-flex justify-content-around"><b>
                                    <span>NEETI AYOG ID NO. UP/2023/0360430</span>&nbsp;
                                    &nbsp; &nbsp;<span>NGO NO. UP/00033062</span>&nbsp; &nbsp;
                                    &nbsp; &nbsp;<span>PAN: AAEAG7650B</span>&nbsp;
                                </b></p>
                            <h4 class="print-h4"><b>
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

                <!-- Donation Fields -->
                <div class="row d-flex justify-content-between">
                    <div class="col-sm-3 mb-2">
                        <p><strong>
                                <span data-lang="hi">प्रमाण-पत्र क्रमांक:</span>
                                <span data-lang="en">Certificate No.:</span>
                            </strong> &nbsp;{{ $record->registration_no }}</p>
                    </div>

                    <div class="col-sm-6 mb-2">
                        <p class="text-center  print-red-bg">
                            <span data-lang="hi">सदस्य प्रमाणपत्र</span>
                            <span data-lang="en">Member Certificate </span>
                        </p>
                    </div>

                    <div class="col-sm-3 mb-2 text-end">
                        <p><strong>
                                <span data-lang="hi">तारीख: </span>
                                <span data-lang="en">Date: </span>
                            </strong> &nbsp;{{ \Carbon\Carbon::parse($record->registration_date)->format('d-m-Y') }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <div style="display: flex; align-items: center; width: 100%;">
                            <strong style="white-space: nowrap; margin-right: 5px;">
                                <span data-lang="hi">प्रमाणित किया जाता है कि श्री/कुमारी/श्रीमती</span>
                                <span data-lang="en">It is Certified that Shri/Km./Smt:</span>
                            </strong>
                            <div
                                style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                &nbsp; {{ $record->name }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 mb-2">
                        <div style="display: flex; align-items: center; width: 100%;">
                            <strong style="white-space: nowrap; margin-right: 5px;">
                                <span data-lang="hi">पिता/पति का नाम</span>
                                <span data-lang="en">Father/Husband's Name:</span>
                            </strong>
                            <div
                                style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                &nbsp;{{ $record->gurdian_name }}
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-4 mb-2">
                        <div style="display: flex; align-items: center; width: 100%;">
                            <strong style="white-space: nowrap; margin-right: 5px;">
                                <span data-lang="hi">गांव/मोहल्ला</span>
                                <span data-lang="en">Village/Locality</span>:
                            </strong>
                            <div
                                style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                &nbsp;{{ $record->village }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 mb-2">
                        <div style="display: flex; align-items: center; width: 100%;">
                            <strong style="white-space: nowrap; margin-right: 5px;">
                                <span data-lang="hi">पोस्ट/कस्बा</span>
                                <span data-lang="en">Post/Town</span>:
                            </strong>
                            <div
                                style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                &nbsp;{{ $record->post }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 mb-2">
                        <div style="display: flex; align-items: center; width: 100%;">
                            <strong style="white-space: nowrap; margin-right: 5px;">
                                <span data-lang="hi">जिला</span>
                                <span data-lang="en">District</span>:
                            </strong>
                            <div
                                style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                &nbsp;{{ $record->district }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 mb-2">
                        <div style="display: flex; align-items: center; width: 100%;">
                            <strong style="white-space: nowrap; margin-right: 5px;">
                                <span data-lang="hi">राज्य</span>
                                <span data-lang="en">State</span>:
                            </strong>
                            <div
                                style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: nowrap; overflow: hidden;">
                                &nbsp;{{ $record->state }}
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2 mb-2">
                        <div style="display: flex; align-items: flex-start; width: 100%;">
                            <strong style="white-space: nowrap; margin-right: 5px;">
                                <span data-lang="hi">देश</span>
                                <span data-lang="en">Country</span>:
                            </strong>
                            <div
                                style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: normal; overflow-wrap: break-word;">
                                {{ $record->country }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7 mb-2">
                        <div style="display: flex; align-items: flex-start; width: 100%;">
                            <strong style="white-space: nowrap; margin-right: 5px;">
                                <span data-lang="hi">के निवासी हैं तथा ज्ञान भारती संस्था में</span>
                                <span data-lang="en">is a resident of and nominated in Gyan Bharti Sanstha</span>
                            </strong>
                            <div
                                style="flex-grow: 1; border-bottom: 1px dotted #000; white-space: normal; overflow-wrap: break-word;">
                                &nbsp;{{ $record->position }}
                            </div>
                        </div>
                    </div>

                </div>
                <span data-lang="en">We have full faith in you that you will cooperate with full honesty and dedication in
                    the promotion, expansion and social work of the organization. His working area is
                    <strong>{{ $record->working_area }}</strong>. We wish you a bright future.
                </span>
                <span data-lang="hi">के रूप में नामित हैं। हमें आप पर पूर्ण विश्वास है कि आप संस्था के प्रचार-प्रसार,
                    विस्तार एवं सामाजिक कार्यों में पूर्ण ईमानदारी एवं निष्ठा से सहयोग करेंगे। उनका कार्य क्षेत्र <strong>
                        {{ $record->working_area }}</strong> है हम आपके उज्ज्वल भविष्य की
                    कामना
                    करते हैं।
                </span>
                <div class="d-flex justify-content-end align-items-center mt-3">
                    {{-- <div class="col-sm-5 text-center">
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
                        <strong>Program Officer & Manager Signature with stamp</strong><br>
                    </div> --}}
                    {{-- <div class="col-sm-2 text-center">
                        <img src="{{ asset('images/iso.png') }}" alt="Logo" width="100" height="100">
                    </div> --}}
                    <div class="col-sm-5 text-end">
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
