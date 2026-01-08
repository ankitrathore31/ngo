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
            @page {
                size: A4 portrait;
                margin: 8mm;
            }

            html,
            body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 0;
                font-size: 10px;
            }

            body * {
                visibility: hidden;
            }

            .print-container,
            .print-container * {
                visibility: visible;
            }

            .print-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            /* Each token takes ~46mm height (297mm - 16mm margins = 281mm / 6 = ~46.8mm) */
            .print-card {
                width: 100%;
                margin-bottom: 1mm;
                page-break-inside: avoid;
                box-sizing: border-box;
                overflow: hidden;
            }

            /* Force new page after every 6 tokens */
            .print-card:nth-of-type(6n) {
                page-break-after: always;
                margin-bottom: 0;
            }

            /* Compact spacing */
            .print-card .p-2 {
                padding: 2mm !important;
            }

            .text-center.mb-4 {
                margin-bottom: 2mm !important;
            }

            .border-bottom {
                padding-bottom: 1mm !important;
            }

            /* Header styling */
            .print-h4 {
                font-size: 15px !important;
                padding: 2px 0 !important;
                background: red !important;
                color: white !important;
                text-align: center;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            h3 {
                font-size: 13px !important;
                margin: 1mm 0 !important;
            }

            h5 {
                font-size: 11px !important;
                margin: 1mm 0 !important;
            }

            h6 {
                font-size: 9px !important;
                margin: 0.5mm 0 !important;
            }

            p {
                margin: 0.5mm 0 !important;
                font-size: 9px !important;
            }

            /* Logo and images */
            .print-card img {
                max-width: 70px !important;
                max-height: 65px !important;
                object-fit: contain;
            }

            /* Row spacing */
            .row {
                margin-bottom: 1mm !important;
            }

            .mb-3 {
                margin-bottom: 1mm !important;
            }

            /* Column spacing */
            .col-sm-2,
            .col-sm-4,
            .col-sm-6,
            .col-sm-8,
            .col-sm-10,
            .col-sm-12 {
                padding: 0 2mm !important;
            }

            strong {
                font-size: 9px !important;
            }

            /* Signature section */
            .mt-5 {
                margin-top: 2mm !important;
            }

            .text-danger {
                font-size: 9px !important;
            }

            /* Hide non-print elements */
            .btn,
            .no-print,
            button,
            .alert {
                display: none !important;
            }
        }
    </style>


    <div class="wrapper">
        <div class="d-flex justify-content-between align-item-centre mb-0 mt-4">
            <h5 class="mb-0">Distribute Facilities Token</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Token</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row mt-4">
            <div class="col-md-12">
                <form method="GET" action="{{ route('show-beneficiarie-token') }}" class="row g-3 mb-4">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            {{-- <label for="session_filter" class="form-label">Select Session</label> --}}
                            <select name="session_filter" id="session_filter" class="form-control">
                                <option value="">All Sessions</option> <!-- Default option to show all -->
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

                        <div class="col-md-3 mb-3">
                            <select id="category_filter" name="category_filter"
                                class="form-control @error('category_filter') is-invalid @enderror">
                                <option value="">-- Select Facilities Category --</option>
                                @foreach ($category as $cat)
                                    <option value="{{ $cat->category }}"
                                        {{ request('category_filter') == $cat->category ? 'selected' : '' }}>
                                        {{ $cat->category }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_filter')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class=" col-md-3">
                            {{-- <label for="bene_category">Beneficiarie Eligibility Category</label> --}}
                            <select id="bene_category" name="bene_category" class="form-control">
                                <option value="">-- Select Beneficiarie Eligibility Category --</option>
                                <option value="Homeless Families">1. Homeless Families</option>
                                <option value="People living in kutcha or one-room houses">2. People living in kutcha or
                                    one-room houses</option>
                                <option value="Widows">3. Widows</option>
                                <option value="Elderly Women">4. Elderly Women</option>
                                <option value="Persons with Disabilities">5. Persons with Disabilities</option>
                                <option value="Landless">6. Landless</option>
                                <option value="Economically Weaker Section">7. Economically Weaker Section</option>
                                <option value="Laborers">8. Laborers</option>
                                <option value="Scheduled Tribes">9. Scheduled Tribes</option>
                                <option value="Scheduled Castes">10. Scheduled Castes</option>
                                <option value="Based on Low Income">11. Based on Low Income</option>
                                <option value="Affected People">12. Affected People</option>
                                <option value="Marginal Farmers">13. Marginal Farmers</option>
                                <option value="Small Farmers">14. Small Farmers</option>
                                <option value="Large Farmers">15. Large Farmers</option>
                            </select>
                        </div>


                        <div class="col-md-3 form-group mb-3">
                            <input type="date" id="distribute_date" name="distribute_date" class="form-control"
                                value="{{ old('distribute_date') }}">
                            <small class="form-text text-muted"><b>Select Distribute Date</b></small>
                            @error('distribute_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @php
                            $districtsByState = config('districts');
                        @endphp
                        <div class="col-md-3 col-sm-6 form-group mb-3">
                            {{-- <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label> --}}
                            <select class="form-control @error('state') is-invalid @enderror" name="state"
                                id="stateSelect">
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
                            <a href="{{ route('show-beneficiarie-token') }}"
                                class="btn btn-info text-white me-1">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="container-fluid mt-5">
            <!-- Language Toggle -->
            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h5 class="mb-0">
                    <span>Token</span>
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">Print </button>
                    {{-- <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button> --}}
                </div>
            </div>
            <div class="print-container">
                <?php $tokenCounter = 1; ?>
                @forelse ($beneficiarie as $item)
                    @forelse ($item->surveys as $survey)
                        <?php $survey->token_no = $tokenCounter;
                        $tokenCounter++; ?>
                        <div class=" rounded print-card">
                            <div class="" style="border: 9px solid red;">
                                <div>
                                    <div class="p-2" style="border: 9px solid #138808;">
                                        <div class="text-center mb-4 border-bottom pb-2">
                                            <div class="row" style="margin: 0;">
                                                <div class="col-sm-12">
                                                    <h3 style="margin: 0;"><b>TOKEN</b></h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-2 text-center text-md-start">
                                                    <img src="{{ asset('images/LOGO.png') }}" alt="Logo"
                                                        width="150" height="140">
                                                </div>
                                                <div class="col-sm-10">
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
                                                            <span data-lang="hi">ग्राम - कैंचू टांडा, पोस्ट - अमरिया, जिला
                                                                -
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
                                        <div class="row mb-3">
                                            <div class="col-sm-12 mb-3">
                                                <h5><b>Token / Notice / Seat / Matarial / Gate Pass No:</b>
                                                    <b>{{ str_pad($survey->token_no, 2, '0', STR_PAD_LEFT) }}</b>
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-4 mb-3">
                                                <strong>Registraition No:</strong> {{ $item->registration_no }}
                                            </div>
                                            <div class="col-sm-4 mb-3">
                                                <strong>Registraition Date:</strong>
                                                {{ \Carbon\Carbon::parse($item->registration_date)->format('d-m-Y') }}
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
                                                        <strong>Father / Husband's Name:</strong>
                                                        {{ $item->gurdian_name }}
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
                                                        {{ $item->state }} -
                                                        {{ $item->pincode }},({{ $item->area_type }})
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
                                                        $item->reg_type === 'Member'
                                                            ? 'member_images/'
                                                            : 'benefries_images/';
                                                @endphp

                                                <div class=" mb-3">
                                                    <img src="{{ asset($imagePath . $item->image) }}" alt="Image"
                                                        class="img-thumbnail" width="150" style="max-width: 250">
                                                </div>
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
                                                <strong>items ID No:</strong> {{ $item->identity_no }}
                                            </div>

                                            <div class="col-sm-4 mb-3">
                                                <strong>Distribute Date:</strong>
                                                {{ \Carbon\Carbon::parse($survey->distribute_date)->format('d-m-Y') }}
                                            </div>
                                            <div class="col-sm-4 mb-3">
                                                <strong>Distribution Matarial Name:</strong> {{ $survey->facilities }}
                                            </div>

                                            <div class="col-sm-12 mb-3">
                                                <strong>Distribute Place:</strong>
                                                {{ $survey->distribute_place ?? 'No Found' }}
                                            </div>

                                        </div>

                                        <div class="row d-flex justify-content-around mt-5">
                                            <div class="col-sm-6 text-center">
                                            </div>

                                            <div class="col-sm-6 text-center">
                                                @if (!empty($signatures['director']) && file_exists(public_path($signatures['director'])))
                                                    <div id="directorSignatureBox" class="mt-2">
                                                        <p class="text-success no-print">Attached</p>
                                                        <img src="{{ asset($signatures['director']) }}"
                                                            alt="Director Signature" class="img"
                                                            style="max-height: 80px;">
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
                        </div>
                    @empty
                        {{-- Beneficiary exists but NO token --}}
                        <div class="alert alert-warning text-center my-4">
                            <strong>No token available</strong>
                        </div>
                    @endforelse
                @empty
                    {{-- No beneficiaries at all --}}
                    <div class="alert alert-warning text-center my-4">
                        <strong>No token available</strong>
                    </div>
                @endforelse
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
