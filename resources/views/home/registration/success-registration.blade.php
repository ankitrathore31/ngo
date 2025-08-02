@extends('home.layout.MasterLayout')

@section('content')
    <!-- Include Animate.css (via CDN) -->
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


    <div class="wrapper mt-4">
        <!-- Breadcrumb -->
        <div class="row d-flex justify-content-end">
            <div class="col-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Registration</li>
                    </ol>
                </nav>
            </div>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container my-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('online-registration') }}" class="btn btn-success me-1">Online Registraition</a>
                <h2 class="fw-bold">Online Registration Form</h2>
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
                            <p><b>Website : www.gyanbhartingo.org Email : gyanbhartingo600@gmail.com Mob- 9411484111</b></p>
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
                        {{ \Carbon\Carbon::parse($record->application_date)->format('d-m-Y') }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Application No:</strong> {{ $record->application_no }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Registraition Type:</strong> {{ $record->reg_type }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Registraition No:</strong>
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
                                <strong>Name:</strong> {{ $record->name }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong>Guardian's Name:</strong> {{ $record->gurdian_name }}
                            </div>
                            <div class="col-sm-6 mb-3">
                                <strong>Mother's Name:</strong> {{ $record->mother_name }}
                            </div>
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
                        @php
                            $imagePath = $record->reg_type === 'Member' ? 'member_images/' : 'benefries_images/';
                        @endphp
                        <div class="mb-3">
                            <img src="{{ asset($imagePath . $record->image) }}" alt="Image" class="img-thumbnail"
                                style="width: 150px; height: 150px; object-fit: cover;">
                        </div>
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
                        <strong>Eligibility:</strong> {{ $record->eligibility ?? 'N/A' }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Caste:</strong> {{ $record->caste }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Religion Category:</strong> {{ $record->religion_category }}
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
                        <strong>Occupation:</strong> {{ $record->occupation }}
                    </div>

                    <div class="col-sm-4 mb-3">
                        <strong>Identity Type:</strong> {{ $record->identity_type }}
                    </div>
                    <div class="col-sm-4 mb-3">
                        <strong>Identity Number:</strong> {{ $record->identity_no }}
                    </div>
                    @php
                        $imagePath = $record->reg_type === 'Member' ? 'member_images/' : 'benefries_images/';
                    @endphp

                    <div class="col-sm-4 mb-3">

                        <strong>ID Document:</strong>
                        <a href="{{ asset($imagePath . $record->id_document) }}" target="_blank">View Document</a>

                    </div>

                </div>
                <div class="row">
                    @if ($record->reg_type == 'Beneficiaries')
                        <div class="col-sm-8 mb-3">
                            <strong>Help Needed:</strong> {{ $record->help_needed }}
                        </div>
                    @endif
                </div>
                <hr>
                <div class="row d-flex justify-content-between mt-2">
                    <div class="col-sm-4 mb-5">
                        <label for="" class="from-label"><b>{{ $record->reg_type }}Signature</b></label>
                    </div>
                    <div class="col-sm-4 mb-5">
                        <label for="" class="from-label"><b>Applicant Signature</b></label>
                    </div>
                    <div class="col-sm-4 mb-5">
                        <label for="" class="from-label"><b>Head Signature</b></label>
                    </div>
                </div>
            </div>
        </div>
    @endsection
