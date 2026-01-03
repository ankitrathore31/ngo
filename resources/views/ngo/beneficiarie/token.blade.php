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
            <h5 class="mb-0">Health Card</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-beneficiarie"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-beneficiarie active" aria-current="page">Health Card</li>
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
                    <span>Health Card</span>
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">Print </button>
                    {{-- <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button> --}}
                </div>
            </div>
            <div class=" rounded print-card">
                <div class="" style="border: 9px solid red;">
                    <div>
                        <div class="p-2" style="border: 9px solid #138808;">
                            <div class="text-center mb-4 border-bottom pb-2">
                                <div class="row mb-2">
                                    <div class="col-sm-12">
                                        <h3><b>TOKEN</b></h3>
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
                            <div class="row d-flex justify-content-center">
                                <div class="col-sm-4 mb-2">
                                    <p class="text-center fw-bold p-2">

                                    </p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3">
                                    <h4><b>Token No:</b> <b>{{ $survey->token_no }}</b></h4>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition No:</strong> {{ $beneficiarie->registration_no }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition Date:</strong>
                                    {{ \Carbon\Carbon::parse($beneficiarie->registraition_date)->format('d-m-Y') }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition Type:</strong> {{ $beneficiarie->reg_type }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <strong>Name:</strong> {{ $beneficiarie->name }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Father / Husband's Name:</strong> {{ $beneficiarie->gurdian_name }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Gender:</strong> {{ $beneficiarie->gender }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Date of Birth:</strong>
                                            {{ \Carbon\Carbon::parse($beneficiarie->dob)->format('d-m-Y') }}
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <strong>Address: </strong>
                                            {{ $beneficiarie->village }},
                                            {{ $beneficiarie->post }},
                                            {{ $beneficiarie->block }},
                                            {{ $beneficiarie->district }},
                                            {{ $beneficiarie->state }} -
                                            {{ $beneficiarie->pincode }},({{ $beneficiarie->area_type }})
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Phone:</strong> {{ $beneficiarie->phone }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Marital Status:</strong> {{ $beneficiarie->marital_status }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    @php
                                        $imagePath =
                                            $beneficiarie->reg_type === 'Member'
                                                ? 'member_images/'
                                                : 'benefries_images/';
                                    @endphp

                                    {{-- @if ($beneficiarie->image) --}}
                                    <div class=" mb-3">
                                        <img src="{{ asset($imagePath . $beneficiarie->image) }}" alt="Image"
                                            class="img-thumbnail" width="150" style="max-width: 250">
                                        {{-- <br>
                                    <strong class="text-center"> Image:</strong> --}}
                                    </div>
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 mb-3">
                                    <strong>Caste:</strong> {{ $beneficiarie->caste }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Caste Category:</strong> {{ $beneficiarie->religion_category }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Religion:</strong> {{ $beneficiarie->religion }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <strong>Beneficiaries ID No:</strong> {{ $beneficiarie->identity_no }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Facilities Category:</strong> {{ $survey->facilities_category }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Facilities:</strong> {{ $survey->facilities }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Distribute Date:</strong>
                                    {{ \Carbon\Carbon::parse($survey->distribute_date)->format('d-m-Y') }}
                                </div>
                                <div class="col-sm-12 mb-3">
                                    <strong>Distribute Place:</strong> {{ $survey->distribute_place ?? 'No Found' }}
                                </div>

                            </div>

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
