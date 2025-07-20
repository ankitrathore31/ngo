@extends('ngo.layout.master')
@Section('content')
    <style>
        /* Reset print layout */

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
            @page {
                size: A4;
                margin: 1cm;
            }

            body * {
                visibility: hidden;
            }

            .print-card,
            .print-card * {
                visibility: visible;
            }

            .btn,
            .navbar,
            .footer,
            .no-print {
                display: none !important;
            }

            .print-card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                font-family: 'Arial', sans-serif;
                font-size: 12pt;
                color: #000;
                background: #fff;
            }

            img {
                max-width: 100px !important;
                height: auto !important;
            }

            h4,
            h6 {
                margin: 0;
                padding: 0;
            }

            .print-card .row {
                margin-bottom: 5px;
            }

            strong {
                font-weight: 600;
            }

            .mb-3,
            .mb-4,
            .mb-5 {
                margin-bottom: 10px !important;
            }

            .shadow,
            .rounded {
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            .card {
                border: none;
                padding: 0;
            }

            .border-bottom {
                border-bottom: 1px solid #000 !important;
            }

            a[href]:after {
                content: "";
            }

            .img-thumbnail {
                border: 1px solid #999;
            }

            .text-center,
            .text-md-start {
                text-align: center !important;
            }

            label.from-label {
                font-weight: bold;
            }


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

        }
    </style>
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Staff</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-record"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-record active" aria-current="page">&nbsp;  Staff</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="container my-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">Staff Info</h2>
                    <button onclick="window.print()" class="btn btn-primary">Print / Download</button>
                </div>

                <div class="card p-4 shadow rounded print-card">
                    <div class="text-center mb-4 border-bottom pb-2">
                        <!-- Header -->
                        <div class="row">
                            <div class="col-sm-2 text-center text-md-start">
                                <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80" height="80">
                            </div>
                            <div class="col-sm-10">
                                {{-- <p style="margin: 0;" class="d-flex justify-content-around"><b>
                                        <span>NEETI AYOG ID NO. UP/2023/0360430</span>&nbsp;
                                        &nbsp; &nbsp;<span>NGO NO. UP/00033062</span>&nbsp; &nbsp;
                                        &nbsp; &nbsp;<span>PAN: AAEAG7650B</span>&nbsp;
                                    </b></p> --}}
                                <h4 class="print-h4"><b>
                                        {{-- <span data-lang="hi">ज्ञान भारती संस्था</span> --}}
                                        <span data-lang="en">GYAN BHARTI SANSTHA</span>
                                    </b></h4>
                                <h6 style="color: blue;"><b>
                                        {{-- <span data-lang="hi">ग्राम - कैंचू टांडा, पोस्ट - अमरिया, जिला - पीलीभीत, उत्तर
                                            प्रदेश -
                                            262121</span> --}}
                                        <span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District - Pilibhit, UP
                                            -
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
                    <div class="row mb-3">
                        <div class="col-sm-4 mb-3">
                            <strong>Application Date:</strong>
                            {{ \Carbon\Carbon::parse($record->application_date)->format('d-m-Y') }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Joining Date:</strong>
                            {{ \Carbon\Carbon::parse($record->joining_date)->format('d-m-Y') }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Session:</strong> {{ $record->academic_session }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <strong>Position:</strong> {{ $record->position }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Name:</strong> {{ $record->name }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Guardian's Name:</strong> {{ $record->gurdian_name }}
                                </div>
                                {{-- <div class="col-sm-6 mb-3">
                                    <strong>Mother's Name:</strong> {{ $record->mother_name }}
                                </div> --}}
                                <div class="col-sm-6 mb-3">
                                    <strong>Area Type:</strong> {{ $record->area_type }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Village/Locality:</strong>{{ $record->village }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Post/Town:</strong> {{ $record->post }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Block:</strong> {{ $record->block }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>District</strong> {{ $record->district }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>State</strong> {{ $record->state }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Pincode:</strong> {{ $record->pincode }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            {{-- @if ($record->image) --}}
                            <div class=" mb-3">
                                <img src="{{ asset($record->image) }}" alt="Image" class="img-thumbnail" width="150">
                            </div>
                            {{-- @endif --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <strong>Country:</strong> {{ $record->country }}
                        </div>

                        <div class="col-sm-4 mb-3">
                            <strong>Gender:</strong> {{ $record->gender }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Phone:</strong> {{ $record->phone }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Email:</strong> {{ $record->email ?? 'N/A' }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Cast:</strong> {{ $record->caste }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Religion Category:</strong> {{ $record->caste_category }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Religion:</strong> {{ $record->religion }}
                        </div>



                        <div class="col-sm-4 mb-3">
                            <strong>Date of Birth:</strong>
                            {{ \Carbon\Carbon::parse($record->dob)->format('d-m-Y') }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Marital Status:</strong> {{ $record->marital_status }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Eligibility:</strong> {{ $record->eligibility ?? 'N/A' }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Degree:</strong> {{ $record->degree }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Experience:</strong> {{ $record->experience }} Year
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Identity Type:</strong> {{ $record->identity_type }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Identity Number:</strong> {{ $record->identity_no }}
                        </div>
                    </div>
                    <div class="row mb-2 no-print">
                        <div class="col-sm-12">
                            <strong>Password</strong> &nbsp; {{$record->password}}
                        </div>
                    </div>
                    <div class="row mb-3 no-print">
                        <h5>- Staff Power</h5>
                        <div class="col-sm-12">
                            @php
                            $permissions = json_decode($record->permissions); @endphp
                            @if (!empty($permissions))
                                <ul class="mb-0">
                                    @foreach ($permissions as $perm)
                                        <li>{{ str_replace('-', ' ', $perm) }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <small class="text-muted">No Permissions assigned</small>
                            @endif
                        </div>
                    </div>
                    <div class="row no-print">
                        {{-- ID Document --}}
                        <div class="col-md-4 mb-3">
                            <label for="id_document" class="form-label">ID Document</label>
                            @if (isset($record) && $record->id_document)
                                <div class="mb-2">
                                    @if (Str::endsWith($record->id_document, ['.jpg', '.jpeg', '.png']))
                                        <img src="{{ asset($record->id_document) }}" alt="ID Document" class="img-fluid"
                                            style="max-height: 150px;">
                                    @else
                                        <a href="{{ asset($record->id_document) }}" target="_blank">View ID
                                            Document (PDF)</a>
                                    @endif
                                </div>
                            @endif

                        </div>

                        {{-- Experience Document --}}
                        <div class="col-md-4 mb-3">
                            <label for="experience_document" class="form-label">Experience Document</label>
                            @if (isset($record) && $record->experience_document)
                                <div class="mb-2">
                                    @if (Str::endsWith($record->experience_document, ['.jpg', '.jpeg', '.png']))
                                        <img src="{{ asset($record->experience_document) }}" alt="Experience Document"
                                            class="img-fluid" style="max-height: 150px;">
                                    @else
                                        <a href="{{ asset($record->experience_document) }}" target="_blank">View
                                            Experience Document (PDF)</a>
                                    @endif
                                </div>
                            @endif

                        </div>

                        {{-- Marksheet --}}
                        <div class="col-md-4 mb-3">
                            <label for="marksheet" class="form-label">Marksheet Upload</label>
                            @if (isset($record) && $record->marksheet)
                                <div class="mb-2">
                                    @if (Str::endsWith($record->marksheet, ['.jpg', '.jpeg', '.png']))
                                        <img src="{{ asset($record->marksheet) }}" alt="Marksheet" class="img-fluid"
                                            style="max-height: 150px;">
                                    @else
                                        <a href="{{ asset($record->marksheet) }}" target="_blank">View
                                            Marksheet
                                            (PDF)</a>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-between mt-2">
                        <div class="col-sm-5 mb-5">
                            <label for="" class="from-label"><b>Staff
                                    Signature</b></label>
                        </div>
                        <div class="col-sm-5 text-center">
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
                            @endif
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
