@extends($layout)
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

        <div class="d-flex justify-content-between align-member-centre mb-0 mt-4">
            <h5 class="mb-0">Union Card</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-member"><a href="{{-- url('dashboard') --}}">Union </a></li>
                    <li class="breadcrumb-member active" aria-current="page">Union Card</li>
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
            <div class="d-flex justify-content-between align-members-center mb-3 mt-4">
                <h5 class="mb-0">
                    <span>Union Card</span>
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
                                
                                <div class="row">
                                    <div class="col-sm-2 text-center text-md-start">
                                        <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="130"
                                            height="130">
                                    </div>
                                    <div class="col-sm-10">
                                        <h4 class="mb-2"><b>UNION MEMBERSHIP CARD</b></h4>

                                        <h3><b>
                                                <span class="print-h4 p-2 text-uppercase">
                                                    {{ $union->name }}
                                                </span>
                                            </b></h3>
                                        <h6>
                                            <b> Issued by Gyan Bharti Sanstha</b>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-4 mb-3">
                                    <strong>Union Name:</strong> {{ $union->name }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <strong>Union Position:</strong>
                                    {{ $member->position ?? 'Member' }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <strong>Membership Valid Till:</strong>
                                    {{ \Carbon\Carbon::parse($unionMember->expiry_date)->format('d-m-Y') }}
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-sm-4 mb-3">
                                    <strong>Application No:</strong> {{ $member->application_no }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition No:</strong> {{ $member->registration_no }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition Date:</strong>
                                    {{ \Carbon\Carbon::parse($member->registration_date)->format('d-m-Y') }}
                                </div>
                                {{-- <div class="col-sm-4 mb-3">
                                    <strong>Registraition Type:</strong> {{ $member->reg_type }}
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <strong>Name:</strong> {{ $member->name }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Father / Husband's Name:</strong> {{ $member->gurdian_name }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Gender:</strong> {{ $member->gender }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Date of Birth:</strong>
                                            {{ \Carbon\Carbon::parse($member->dob)->format('d-m-Y') }}
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <strong>Address: </strong>
                                            {{ $member->village }},
                                            {{ $member->post }},
                                            {{ $member->block }},
                                            {{ $member->district }},
                                            {{ $member->state }} - {{ $member->pincode }},({{ $member->area_type }})
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Phone:</strong> {{ $member->phone }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Marital Status:</strong> {{ $member->marital_status }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    @php
                                        $imagePath =
                                            $member->reg_type === 'Member' ? 'member_images/' : 'benefries_images/';
                                    @endphp

                                    {{-- @if ($member->image) --}}
                                    <div class=" mb-3">
                                        <img src="{{ asset($imagePath . $member->image) }}" alt="Image"
                                            class="img-thumbnail" width="150" style="max-width: 250">
                                        {{-- <br>
                                    <strong class="text-center"> Image:</strong> --}}
                                    </div>
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-12 text-center">
                                    <p class=" fw-bold">
                                        This is to certify that the above member is officially enrolled
                                        as a member of <b>{{ $union->name }}</b> under Gyan Bharti Sanstha
                                        for the valid membership period.
                                    </p>
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
