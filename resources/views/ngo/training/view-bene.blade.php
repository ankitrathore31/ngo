@extends('ngo.layout.master')
@Section('content')
    <style>
        /* Reset print layout */
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

        }
    </style>
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Approve Demand Training</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-record"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-record active" aria-current="page">Approve Demand</li>
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
                    <h2 class="fw-bold">Apporve Demand Training</h2>
                    <button onclick="window.print()" class="btn btn-primary">Print / Download</button>
                </div>

                <div class="card p-4 shadow rounded print-card">
                    <div class="text-center mb-4 border-bottom">
                        <div class="row align-items-center">
                            <div class="col-sm-2 text-center text-md-start">
                                <a href="https://gyanbhartingo.org">
                                    <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80" height="80"
                                        class="">
                                </a>
                            </div>
                            <div class="col-sm-10 text-center">
                                <h4 style="color: red; font-weight:500; font-size:25px;"><b>GYAN BHARTI SANSTHA</b></h4>
                                <h6 style="color: blue;"><b>Head Office: Kainchu Tanda Amaria Pilibhit UP 262121</b></h6>
                                <p><b>Website : www.gyanbhartingo.org Email : gyanbhartingo600@gmail.com Mob- 9411484111</b>
                                </p>
                            </div>
                            {{-- <div class="col-sm-4 text-center">
                            <h4 style=" font-size:20px; color:brown;"><b>Session: {{ $activity->academic_session }}</b></h4>
                            <p style=""><b>Activity Report</b></p>
                        </div> --}}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 mb-3">
                            <strong>Application Date:</strong>
                            {{ \Carbon\Carbon::parse($record->beneficiare->application_date)->format('d-m-Y') }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Application No:</strong> {{ $record->beneficiare->application_no }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Registraition Type:</strong> {{ $record->beneficiare->reg_type }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Registraition No:</strong> {{ $record->beneficiare->registration_no }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Registraition Date:</strong>
                            {{ \Carbon\Carbon::parse($record->beneficiare->registraition_date)->format('d-m-Y') }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Session:</strong> {{ $record->beneficiare->academic_session }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <strong>Name:</strong> {{ $record->beneficiare->name }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Guardian's Name:</strong> {{ $record->beneficiare->gurdian_name }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Mother's Name:</strong> {{ $record->beneficiare->mother_name }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Area Type:</strong> {{ $record->beneficiare->area_type }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Village/Locality:</strong>{{ $record->beneficiare->village }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Post/Town:</strong> {{ $record->beneficiare->post }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Block:</strong> {{ $record->beneficiare->block }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>District</strong> {{ $record->beneficiare->district }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>State</strong> {{ $record->beneficiare->state }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Pincode:</strong> {{ $record->beneficiare->pincode }}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            @php
                                $imagePath =
                                    $record->beneficiare->reg_type === 'Member'
                                        ? 'member_images/'
                                        : 'beneficiaries_images/';
                            @endphp

                            {{-- @if ($record->image) --}}
                            <div class=" mb-3">
                                <img src="{{ asset($imagePath . $record->beneficiare->image) }}" alt="Image"
                                    class="img-thumbnail" width="150">
                                {{-- <br>
                                    <strong class="text-center"> Image:</strong> --}}
                            </div>
                            {{-- @endif --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <strong>Country:</strong> {{ $record->beneficiare->country }}
                        </div>

                        <div class="col-sm-4 mb-3">
                            <strong>Gender:</strong> {{ $record->beneficiare->gender }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Phone:</strong> {{ $record->beneficiare->phone }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Email:</strong> {{ $record->beneficiare->email ?? 'N/A' }}
                        </div>


                        <div class="col-sm-4 mb-3">
                            <strong>Eligibility:</strong> {{ $record->beneficiare->eligibility ?? 'N/A' }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Caste:</strong> {{ $record->beneficiare->caste }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Religion Category:</strong> {{ $record->beneficiare->religion_category }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Religion:</strong> {{ $record->beneficiare->religion }}
                        </div>



                        <div class="col-sm-4 mb-3">
                            <strong>Date of Birth:</strong>
                            {{ \Carbon\Carbon::parse($record->beneficiare->dob)->format('d-m-Y') }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Marital Status:</strong> {{ $record->beneficiare->marital_status }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Occupation:</strong> {{ $record->beneficiare->occupation }}
                        </div>

                        <div class="col-sm-4 mb-3">
                            <strong>Identity Type:</strong> {{ $record->beneficiare->identity_type }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Identity Number:</strong> {{ $record->beneficiare->identity_no }}
                        </div>
                        @php
                            $imagePath =
                                $record->beneficiare->reg_type === 'Member'
                                    ? 'member_images/'
                                    : 'beneficiaries_images/';
                        @endphp

                        <div class="col-sm-4 mb-3">

                            <strong>ID Document:</strong>
                            <a href="{{ asset($imagePath . $record->beneficiare->id_document) }}" target="_blank">View
                                Document</a>

                        </div>

                    </div>
                    <div class="row">
                        @if ($record->reg_type == 'Beneficiaries')
                            <div class="col-sm-8 mb-3">
                                <strong>Help Needed:</strong> {{ $record->beneficiare->help_needed }}
                            </div>
                        @endif
                    </div>
                    <h5>- Training Information</h5>
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <strong>Center Code:</strong> {{ $center->center_code }}
                        </div>

                        <div class="col-sm-4 mb-3">
                            <strong>Center Name:</strong> {{ $center->center_name }}
                        </div>

                        <div class="col-sm-8 mb-3">
                            <strong>Center Address:</strong> {{ $center->center_address }}
                        </div>

                        <div class="col-sm-4 mb-3">
                            <strong>Facilities Category:</strong> {{ $record->facilities_category ?? 'N/A' }}
                        </div>

                        <div class="col-sm-4 mb-3">
                            <strong>Training Course:</strong> {{ $record->training_course ?? 'N/A' }}
                        </div>

                        <div class="col-sm-4 mb-3">
                            <strong>Training Dates:</strong>
                            {{ \Carbon\Carbon::parse($record->start_date)->format('d-m-Y') }} To
                            {{ \Carbon\Carbon::parse($record->end_date)->format('d-m-Y') }}
                        </div>

                        <div class="col-sm-4 mb-3">
                            <strong>Duration:</strong> {{ $record->duration }}
                        </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-between mt-2">
                        <div class="col-sm-4 mb-5">
                            <label for="" class="from-label"><b>{{ $record->beneficiare->reg_type }}
                                    Signature</b></label>
                        </div>
                        <div class="col-sm-4 mb-5">
                            <label for="" class="from-label"><b>Signature</b></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
