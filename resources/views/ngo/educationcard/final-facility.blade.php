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

        <div class="d-flex justify-content-between align-record-centre mb-0 mt-4">
            <h5 class="mb-0">Education Facility Form</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-record"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-record active" aria-current="page">Education Card</li>
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
            <div class="d-flex justify-content-between align-records-center mb-3 mt-4">
                <h5 class="mb-0">
                    <span> Education Facility Form</span>
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">Print </button>
                    {{-- <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button> --}}
                </div>
            </div>
            <div class=" rounded print-card">
                <div class="card-body m-1 shadow-sm">
                    <div>
                        <div class="p-2">
                            <div class="text-center mb-4 border-bottom pb-2">
                                {{-- <div class="row mb-2">
                                    <div class="col-sm-12">
                                        <h3><b>EDUCATION CARD</b></h3>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-sm-2 text-center text-md-start">
                                        <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="150"
                                            height="140">
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
                                    <h4><b>Education Card No:</b> <b>{{ $card->card_no }}</b></h4>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Education Card Registraition Date:</strong>
                                    {{ \Carbon\Carbon::parse($card->education_registration_date)->format('d-m-Y') }}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition No:</strong> {{ $record->registration_no }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition Date:</strong>
                                    {{ \Carbon\Carbon::parse($record->registration_date)->format('d-m-Y') }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition Type:</strong> {{ $record->reg_type }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <strong>Name:</strong> {{ $record->name }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Father / Husband's Name:</strong> {{ $record->gurdian_name }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Gender:</strong> {{ $record->gender }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Date of Birth:</strong>
                                            {{ \Carbon\Carbon::parse($record->dob)->format('d-m-Y') }}
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <strong>Address: </strong>
                                            {{ $record->village }},
                                            {{ $record->post }},
                                            {{ $record->block }},
                                            {{ $record->district }},
                                            {{ $record->state }} - {{ $record->pincode }},({{ $record->area_type }})
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Phone:</strong> {{ $record->phone }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Marital Status:</strong> {{ $record->marital_status }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    @php
                                        $imagePath =
                                            $record->reg_type === 'Member' ? 'member_images/' : 'benefries_images/';
                                    @endphp

                                    {{-- @if ($record->image) --}}
                                    <div class=" mb-3">
                                        <img src="{{ asset($imagePath . $record->image) }}" alt="Image"
                                            class="img-thumbnail" width="150" style="max-width: 250">
                                        {{-- 
                                    <strong class="text-center"> Image:</strong> --}}
                                    </div>
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4 mb-3">
                                    <strong>Caste:</strong> {{ $record->caste }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Caste Category:</strong> {{ $record->religion_category }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Religion:</strong> {{ $record->religion }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <strong>Occupation:</strong> {{ $record->occupation }}
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <strong>Beneficiaries ID No:</strong> {{ $record->identity_no }}
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <strong>Student Name:</strong>
                                    @if (!empty($card->students))
                                        @foreach ($card->students as $student)
                                            {{ $loop->iteration }}. {{ $student }}@if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    @endif
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <strong>School / Instituion / Tuition / Teacher Name:</strong>

                                    @if (!empty($card->school_name))
                                        @foreach ($card->school_name as $index => $SchoolCode)
                                            @php
                                                $school = \App\Models\School::getByCode($SchoolCode);
                                            @endphp

                                            @if ($school)
                                                <div class="col-12 mt-1">
                                                    {{ $index + 1 }}.
                                                    {{ $school->school_name }},
                                                    {{ $school->address }},
                                                    {{ $school->principle_name }},
                                                    {{ $school->contact_number }}
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif

                                </div>


                            </div>
                            <div class="row">
                                <div>
                                    <h5>Education Demand Facility Details</h5>
                                </div>

                                <div class="col-sm-12 mb-3">
                                    <strong>School / Institution / Tuition / Teacher Name:</strong>
                                    @php
                                        $school = \App\Models\School::getByCode($facility->school);
                                    @endphp
                                    @if ($school)
                                        {{ $school->school_name }},
                                        {{ $school->address }},
                                        {{ $school->principal_name }},
                                        {{ $school->contact_number }}
                                    @else
                                        No school assigned
                                    @endif
                                </div>


                                <div class="col-sm-4 mb-3">
                                    <strong>Fees Type:</strong> {{ $facility->fees_type }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <strong>Registration / SR No:</strong> {{ $facility->registration_no }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <strong>Fees Slip No:</strong> {{ $facility->fees_slip_no }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <strong>Fees Submit Date:</strong>
                                    {{ \Carbon\Carbon::parse($facility->fees_submit_date)->format('d-m-Y') }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <strong>Total Fees Amount:</strong> ₹{{ number_format($facility->fees_amount, 2) }}
                                </div>

                                {{-- <div class="col-sm-4 mb-3">
                                    <strong>Facility Status:</strong>
                                    <span class="badge bg-warning">{{ $facility->status }}</span>
                                </div> --}}

                                <div class="col-sm-4 mb-3">
                                    <strong>Slip Document:</strong>
                                    @if ($facility->slip)
                                        <a href="{{ asset('documents/' . $facility->slip) }}" target="_blank">
                                            View
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <b>Investigation Officer</b> @php
                                        $staff = staffByEmail($facility->investigation_officer);
                                    @endphp

                                    @if ($staff)
                                        {{ $staff->name }} ({{ $staff->staff_code }}) - {{ $staff->position }}
                                    @endif
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <b>Person Paying Fees Name</b>
                                    {{ $facility->person_paying_amount ?? '—' }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <b>Account No.</b>
                                    {{ $facility->account_no ?? '—' }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <b>Account Holder Name</b>
                                    {{ $facility->account_holder_name ?? '—' }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <b>Bank IFSC Code</b>
                                    {{ $facility->ifsc_code ?? '—' }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <b>Bank Name</b>
                                    {{ $facility->bank_name ?? '—' }}
                                </div>

                                <div class="col-sm-4 mb-3">
                                    <b>Bank Branch</b>
                                    {{ $facility->bank_branch ?? '—' }}
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <b>Account Holder Address</b>
                                    {{ $facility->account_holder_address ?? '—' }}
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <b>Verify Officer</b>
                                    @php
                                        $verifyStaff = staffByEmail($facility->verify_officer);
                                    @endphp

                                    @if ($verifyStaff)
                                        {{ $verifyStaff->name }} ({{ $verifyStaff->staff_code }}) -
                                        {{ $verifyStaff->position }}
                                    @else
                                        <span class="text-muted">Not Assigned</span>
                                    @endif
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <b>Investigation Proof</b>
                                    @if ($facility->investigation_proof)
                                        <a href="{{ asset($facility->investigation_proof) }}" target="_blank">
                                            View Uploaded Proof
                                        </a>
                                    @else
                                        <span class="text-muted">No file uploaded</span>
                                    @endif
                                </div>
                                @if ($facility->verify_proof)
                                    <div class="mb-3 col-sm-6 no-print">
                                        <b>Verify Proof:</b>
                                        <a href="{{ asset('images/' . $facility->verify_proof) }}" target="_blank">
                                            View Proof
                                        </a>
                                    </div>
                                @endif
                                  <div class="col-sm-4 mb-3">
                                    <b>Clearness Amount</b>
                                    {{ $facility->clearness_amount ?? '—' }}
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <b>Status</b>
                                    {{ $facility->status ?? '—' }}
                                </div>
                            </div>
                            <div class="row d-flex mt-4 justify-content-between">
                                @if ($facility->investigation_officer)
                                    <div class="col-sm-4 mb-3">
                                        @php
                                            $investigationStaff = staffByEmail($facility->investigation_officer);
                                        @endphp
                                        <b>Investigation Officer Sign</b> <br>
                                        @if ($investigationStaff)
                                            {{ $investigationStaff->name }}
                                        @endif
                                    </div>
                                @endif
                                <div class="col-sm-4 mb-3">
                                    @if ($facility->verify_proof)
                                        @php
                                            $verifyStaff = staffByEmail($facility->verify_officer);
                                        @endphp
                                        <b>Verify Officer Sign</b> <br>
                                        @if ($verifyStaff)
                                            {{ $verifyStaff->name }}
                                        @endif
                                    @endif
                                </div>
                                @if ($facility->status == 'Approve')
                                    <div class="col-sm-4 text-center">
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
                                @endif

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

    <script>
        function toggleReasonField() {
            const status = document.getElementById('status').value;
            const reasonField = document.getElementById('reason_field');

            if (status === 'Reject' || status === 'Non-Budget' || status === 'Demand-Pending') {
                reasonField.style.display = 'block';
            } else {
                reasonField.style.display = 'none';
            }
        }
    </script>
@endsection
