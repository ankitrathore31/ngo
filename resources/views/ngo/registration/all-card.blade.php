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
            border-image: linear-gradient(to right, #FF9933 33%, white 33%, white 66%, #138808 66%) 1;
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
                height: 133.5mm;
                /* EXACTLY 2 cards per page */
                padding: 10mm;
                box-sizing: border-box;
                page-break-inside: avoid;
                break-inside: avoid;
            }

            /* Changed from 2n+1 to 2n - this applies to every 2nd, 4th, 6th card etc */
            .print-card:nth-of-type(2n) {
                page-break-after: always;
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
                border-image: linear-gradient(to right, #FF9933 33%, white 33%, white 66%, #138808 66%) 1;
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
        <div class="d-flex justify-content-between align-item-centre mb-0 mt-4">
            <h5 class="mb-0">Registraition Card</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Card</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <form method="GET" action="{{ route('all-reg-card') }}" class="row g-3 mb-4">
                <div class="row">
                    <div class="col-md-3 col-sm-4">
                        <select name="session_filter" id="session_filter" class="form-control">
                            <option value="">All Sessions</option>
                            @foreach ($data as $session)
                                <option value="{{ $session->session_date }}"
                                    {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                    {{ $session->session_date }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-4 mb-3">
                        <input type="number" class="form-control" name="application_no"
                            placeholder="Search By Application/Registration No.">
                    </div>
                    <div class="col-md-3 col-sm-4 mb-3">
                        <input type="number" class="form-control" name="registration_no"
                            placeholder="Search By Mobile/Idtinty No.">
                    </div>
                    <div class="col-md-3 col-sm-4 mb-3">
                        <input type="text" class="form-control" name="name"
                            placeholder="Search By Person/Guardian's Name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="form-group">
                            {{-- <label for="reg_type" class="form-label">Registraition Type <span
                                        class="text-danger">*</span></label> --}}
                            <select class="form-control" id="reg_type" name="reg_type">
                                <option selected disabled>Select Registration Type</option>
                                <option value="Beneficiaries" {{ old('reg_type') == 'Beneficiaries' ? 'selected' : '' }}>
                                    Beneficiaries
                                </option>
                                <option value="Member" {{ old('reg_type') == 'Member' ? 'selected' : '' }}>Member
                                </option>
                            </select>
                            @error('reg_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @php
                        $districtsByState = config('districts');
                    @endphp
                    <div class="col-md-3 col-sm-6 form-group mb-3">
                        {{-- <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label> --}}
                        <select class="form-control @error('state') is-invalid @enderror" name="state" id="stateSelect">
                            <option value="">Select State</option>
                            @foreach ($districtsByState as $state => $districts)
                                <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>
                                    {{ $state }}
                                </option>
                            @endforeach
                        </select>
                        @error('state')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                    <div class="col-md-3 col-sm-6 form-group mb-3">
                        {{-- <label for="districtSelect" class="form-label">District: <span
                                    class="text-danger">*</span></label> --}}
                        <select class="form-control @error('district') is-invalid @enderror" name="district"
                            id="districtSelect">
                            <option value="">Select District</option>
                        </select>
                        @error('district')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3 col-sm-6 form-group mb-3">
                        {{-- <label for="block" class="form-label">Block: <span class="text-danger">*</span></label> --}}
                        <input type="text" name="block" id="block"
                            class="form-control @error('block') is-invalid @enderror" value="{{ old('block') }}"
                            placeholder="Search by Block">
                        @error('block')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary me-1">Search</button>
                        <a href="{{ route('all-reg-card') }}" class="btn btn-info text-white me-1">Reset</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="container-fluid mt-5">
            <!-- Language Toggle -->
            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h5 class="mb-0">
                    <span>Registration Card</span>
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">Print </button>
                    {{-- <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button> --}}
                </div>
            </div>
            <div class="print-card">
                @foreach ($combined as $index => $item)
                    <div class="mb-4" style="border: 9px solid red;">
                        <div style="border: 8px solid white;">
                            <div class="p-2" style="border: 9px solid #138808;">
                                <div class="text-center mb-4 border-bottom pb-2">
                                    <div class="row mb-2">
                                        <div class="col-sm-12">
                                            <b>Registration Card /Registration Certificate</b>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2 text-center text-md-start">
                                            <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="120"
                                                height="120">
                                        </div>
                                        <div class="col-sm-10">
                                            <p style="margin: 0;" class="d-flex justify-content-around"><b>
                                                    <span>NEETI AYOG ID NO. UP/2023/0360430</span>&nbsp;
                                                    &nbsp; &nbsp;<span>NGO NO. UP/00033062</span>&nbsp; &nbsp;
                                                    &nbsp; &nbsp;<span>PAN: AAEAG7650B</span>&nbsp;
                                                </b></p>
                                            <h4 class=" p-1"><b>
                                                    <span class="print-h4 p-1" data-lang="hi">ज्ञान भारती संस्था</span>
                                                    <span class="print-h4 p-1" data-lang="en">GYAN BHARTI
                                                        SANSTHA</span>
                                                </b></h4>
                                            <h5> <strong>
                                                    <span>The Path To Peace And Development</span></strong></h5>
                                            <h6 style="color: blue;"><b>
                                                    <span data-lang="hi">ग्राम - कैंचू टांडा, पोस्ट - अमरिया, जिला -
                                                        पीलीभीत,
                                                        उत्तर प्रदेश -
                                                        262121</span>
                                                    <span data-lang="en">Village - Kainchu Tanda, Post - Amaria,
                                                        District -
                                                        Pilibhit, UP -
                                                        262121</span>
                                                </b></h6>
                                            <p style="font-size: 14px; margin: 0;">
                                                <b>
                                                    <span>Website: www.gyanbhartingo.org | Email:
                                                        gyanbhartingo600@gmail.com
                                                        | Mob:
                                                        9411484111</span>
                                                </b>
                                            </p>
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
                                    <div class="col-sm-4 mb-3">
                                        <strong>Registraition No:</strong> {{ $item->registration_no }}
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <strong>Registraition Date:</strong>
                                        {{ \Carbon\Carbon::parse($item->registraition_date)->format('d-m-Y') }}
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <strong>Registraition Type:</strong> {{ $item->reg_type }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                <strong>Name:</strong> {{ $item->name }}
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <strong>Father / Husband's Name:</strong> {{ $item->gurdian_name }}
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <strong>Gender:</strong> {{ $item->gender }}
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <strong>Date of Birth:</strong>
                                                {{ \Carbon\Carbon::parse($item->dob)->format('d-m-Y') }}
                                            </div>
                                            <div class="col-sm-12 mb-3">
                                                <strong>Address: </strong>
                                                {{ $item->village }},
                                                {{ $item->post }},
                                                {{ $item->block }},
                                                {{ $item->district }},
                                                {{ $item->state }} - {{ $item->pincode }},({{ $item->area_type }})
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <strong>Phone:</strong> {{ $item->phone }}
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <strong>Marital Status:</strong> {{ $item->marital_status }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        @php
                                            $imagePath =
                                                $item->reg_type === 'Member' ? 'member_images/' : 'benefries_images/';
                                        @endphp

                                        {{-- @if ($item->image) --}}
                                        <div class=" mb-3">
                                            <img src="{{ asset($imagePath . $item->image) }}" alt="Image"
                                                class="img-thumbnail" width="150" style="max-width: 250">
                                            {{-- <br>
                                    <strong class="text-center"> Image:</strong> --}}
                                        </div>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 mb-3">
                                        <strong>Caste:</strong> {{ $item->caste }}
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <strong>Caste Category:</strong> {{ $item->religion_category }}
                                    </div>
                                    <div class="col-sm-4 mb-3">
                                        <strong>Religion:</strong> {{ $item->religion }}
                                    </div>

                                    <div class="col-sm-4 mb-3">
                                        <strong>Occupation:</strong> {{ $item->occupation }}
                                    </div>
                                    @if ($item->reg_type == 'Beneficiaries')
                                        <div class="col-sm-8 mb-3">
                                            <strong>What do the beneficiaries need?:</strong> {{ $item->help_needed }}
                                        </div>
                                    @endif

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
                                                <button class="btn btn-primary btn-sm"
                                                    onclick="toggleDirector(true)">Attached
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
                @endforeach
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
