@extends('ngo.layout.master')
@Section('content')
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

            /* Optional: Hide buttons like Print/Download and Language Toggle */
            button,
            .btn,
            .d-flex.justify-content-between {
                display: none !important;
            }
        }
    </style>
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Organization Member</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Organization</li>
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
                    <h2 class="fw-bold">Organization Member</h2>
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
                                <p style="margin: 0;" class="d-flex justify-content-around"><b>
                                        <span>NEETI AYOG ID NO. UP/2023/0360430</span>&nbsp;
                                        &nbsp; &nbsp;<span>NGO NO. UP/00033062</span>&nbsp; &nbsp;
                                        &nbsp; &nbsp;<span>PAN: AAEAG7650B</span>&nbsp;
                                    </b></p>
                                <h4 class="print-h4"><b>
                                        {{-- <span data-lang="hi">ज्ञान भारती संस्था</span> --}}
                                        <span>GYAN BHARTI SANSTHA</span>
                                    </b></h4>
                                <h6 style="color: blue;"><b>
                                        <span>Village - Kainchu Tanda, Post - Amaria, District - Pilibhit, UP
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
                        <h5 class="mb-3"><b>- Organization Details</b></h5>
                        <div class="col-sm-3 mb-3">
                            <strong>Organization ID:</strong> {{ $member->organization->organization_no ?? 'N/A' }}
                        </div>
                        <div class="col-sm-5 mb-3">
                            <strong>Organization Name:</strong> {{ $member->organization->name ?? 'N/A' }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Session:</strong> {{ $member->academic_session }}
                        </div>
                        <div class="col-sm-12 mb-3">
                            <strong>Organization Address:</strong>
                            {{ $member->organization->address ?? 'N/A' }},
                            {{ $member->organization->block ?? 'N/A' }},
                            {{ $member->organization->district ?? 'N/A' }},
                            {{ $member->organization->state ?? 'N/A' }}
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <h5 class="mb-3"><b>- Member Details</b></h5>

                        @if (!empty($member->person->registration_no))
                            <div class="col-sm-4 mb-3">
                                <strong>Registraition No:</strong> {{ $member->person->registration_no }}
                            </div>
                        @endif

                        @if (!empty($member->person->registraition_date))
                            <div class="col-sm-4 mb-3">
                                <strong>Registraition Date:</strong>
                                {{ \Carbon\Carbon::parse($member->person->registraition_date)->format('d-m-Y') }}
                            </div>
                        @endif

                        @if (!empty($member->person->academic_session))
                            <div class="col-sm-4 mb-3">
                                <strong>Session:</strong> {{ $member->person->academic_session }}
                            </div>
                        @endif

                        @if (!empty($member->person->name))
                            <div class="col-sm-4 mb-3">
                                <strong>Name:</strong> {{ $member->person->name }}
                            </div>
                        @endif

                        @if (!empty($member->person->gurdian_name))
                            <div class="col-sm-4 mb-3">
                                <strong>Guardian's Name:</strong> {{ $member->person->gurdian_name }}
                            </div>
                        @endif

                        @if (!empty($member->person->village) || !empty($member->person->address))
                            <div class="col-sm-4 mb-3">
                                <strong>Village/Locality:</strong>
                                {{ $member->person->village ?? $member->person->address }}
                            </div>
                        @endif

                        @if (!empty($member->person->post) || !empty($member->person->block))
                            <div class="col-sm-4 mb-3">
                                <strong>Post/Town:</strong>
                                {{ $member->person->post ?? $member->person->block }}
                            </div>
                        @endif

                        @if (!empty($member->person->block))
                            <div class="col-sm-4 mb-3">
                                <strong>Block:</strong> {{ $member->person->block }}
                            </div>
                        @endif

                        @if (!empty($member->person->district))
                            <div class="col-sm-4 mb-3">
                                <strong>District:</strong> {{ $member->person->district }}
                            </div>
                        @endif

                        @if (!empty($member->person->state))
                            <div class="col-sm-4 mb-3">
                                <strong>State:</strong> {{ $member->person->state }}
                            </div>
                        @endif

                        @if (!empty($member->person->pincode))
                            <div class="col-sm-4 mb-3">
                                <strong>Pincode:</strong> {{ $member->person->pincode }}
                            </div>
                        @endif

                        @if (!empty($member->person->country))
                            <div class="col-sm-4 mb-3">
                                <strong>Country:</strong> {{ $member->person->country }}
                            </div>
                        @endif

                        @if (!empty($member->person->gender))
                            <div class="col-sm-4 mb-3">
                                <strong>Gender:</strong> {{ $member->person->gender }}
                            </div>
                        @endif

                        @if (!empty($member->person->phone))
                            <div class="col-sm-4 mb-3">
                                <strong>Phone:</strong> {{ $member->person->phone }}
                            </div>
                        @endif

                        @if (!empty($member->person->email))
                            <div class="col-sm-4 mb-3">
                                <strong>Email:</strong> {{ $member->person->email }}
                            </div>
                        @endif

                        @if (!empty($member->person->eligibility))
                            <div class="col-sm-4 mb-3">
                                <strong>Eligibility:</strong> {{ $member->person->eligibility }}
                            </div>
                        @endif

                        @if (!empty($member->person->caste))
                            <div class="col-sm-4 mb-3">
                                <strong>Caste:</strong> {{ $member->person->caste }}
                            </div>
                        @endif

                        @if (!empty($member->person->religion_category))
                            <div class="col-sm-4 mb-3">
                                <strong>Religion Category:</strong> {{ $member->person->religion_category }}
                            </div>
                        @endif

                        @if (!empty($member->person->religion))
                            <div class="col-sm-4 mb-3">
                                <strong>Religion:</strong> {{ $member->person->religion }}
                            </div>
                        @endif

                        @if (!empty($member->person->dob))
                            <div class="col-sm-4 mb-3">
                                <strong>Date of Birth:</strong>
                                {{ \Carbon\Carbon::parse($member->person->dob)->format('d-m-Y') }}
                            </div>
                        @endif

                        @if (!empty($member->person->marital_status))
                            <div class="col-sm-4 mb-3">
                                <strong>Marital Status:</strong> {{ $member->person->marital_status }}
                            </div>
                        @endif

                        @if (!empty($member->person->occupation))
                            <div class="col-sm-4 mb-3">
                                <strong>Occupation:</strong> {{ $member->person->occupation }}
                            </div>
                        @endif

                        @if (!empty($member->person->identity_type))
                            <div class="col-sm-4 mb-3">
                                <strong>Identity Type:</strong> {{ $member->person->identity_type }}
                            </div>
                        @endif

                        @if (!empty($member->person->identity_no))
                            <div class="col-sm-4 mb-3">
                                <strong>Identity Number:</strong> {{ $member->person->identity_no }}
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <h5 class="mb-3"><b>- Other Details</b></h5>
                        <div class="col-sm-6">
                            <b>Position in Organization:</b> &nbsp; {{ $member->member_position }}
                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-between mt-2">
                        <div class="col-sm-5 mb-5">
                            <label for="" class="from-label"><b>Signature/ Thumb
                                    Impression of the Member</b></label>
                        </div>
                        <div class="col-sm-5 text-center">
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
        </div>

    </div>
@endsection
