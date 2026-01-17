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
                <h5 class="mb-0">Kyc</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kyc</li>
                    </ol>
                </nav>
            </div>
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="container my-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">Kyc</h2>
                    <button onclick="window.print()" class="btn btn-primary">Print / Download</button>
                </div>

                <div class="card p-4 shadow rounded print-card">

                    <div class="row mb-3">
                        <div class="col-sm-4 mb-3">
                            <strong>Registraition No:</strong> {{ $record->registration_no }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Registraition Date:</strong>
                            {{ \Carbon\Carbon::parse($record->registration_date)->format('d-m-Y') }}
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

                            {{-- @if ($record->image) --}}
                            <div class=" mb-3">
                                <img src="{{ asset($imagePath . $record->image) }}" alt="Image" class="img-thumbnail"
                                    width="150">
                                {{-- <br>
                                    <strong class="text-center"> Image:</strong> --}}
                            </div>
                            {{-- @endif --}}
                        </div>
                    </div>
                    <div class="row">


                        <div class="col-sm-4 mb-3">
                            <strong>Gender:</strong> {{ $record->gender }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Phone:</strong> {{ $record->phone }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Caste:</strong> {{ $record->caste }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Religion Category:</strong> {{ $record->religion_category }}
                        </div>

                    </div>
                    <div class="row">
                        <h5 class="fw-bold mb-3">KYC Details</h5>

                        {{-- Aadhaar Number --}}
                        <p><strong>Aadhaar No:</strong> {{ $kyc->aadhaar_no }}</p>

                        {{-- Verified By --}}
                        <p><strong>Verified By:</strong> {{ $kyc->verified_by }}</p>

                        <p><strong>Verified Date:</strong> {{ $kyc->verified_at }}</p>

                        <p><strong>Status:</strong> {{ $kyc->status }}</p>

                        <hr>

                        {{-- Aadhaar Front --}}
                        <div class="mb-3">
                            <strong>Aadhaar Front:</strong><br>

                            @if ($kyc->aadhaar_front)
                                @if (Str::endsWith($kyc->aadhaar_front, '.pdf'))
                                    <a href="{{ asset($kyc->aadhaar_front) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary mt-2">
                                        View PDF
                                    </a>
                                @else
                                    <img src="{{ asset($kyc->aadhaar_front) }}" class="img-thumbnail mt-2"
                                        style="max-width: 250px;">
                                @endif
                            @else
                                <span class="text-muted">Not Uploaded</span>
                            @endif
                        </div>

                        {{-- Aadhaar Back --}}
                        <div class="mb-3">
                            <strong>Aadhaar Back / Combined:</strong><br>

                            @if ($kyc->aadhaar_back)
                                @if (Str::endsWith($kyc->aadhaar_back, '.pdf'))
                                    <a href="{{ asset($kyc->aadhaar_back) }}" target="_blank"
                                        class="btn btn-sm btn-outline-primary mt-2">
                                        View PDF
                                    </a>
                                @else
                                    <img src="{{ asset($kyc->aadhaar_back) }}" class="img-thumbnail mt-2"
                                        style="max-width: 250px;">
                                @endif
                            @else
                                <span class="text-muted">Not Uploaded</span>
                            @endif
                        </div>

                        {{-- Approve KYC --}}
                        <div class="mb-2 mt-3">
                            <strong>Approve Kyc:</strong><br>
                            @if ($kyc->status === 'pending')
                                <form action="{{ route('kyc.store.status', $kyc->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to approve this KYC?');"
                                    class="mt-2">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Approve
                                    </button>
                                </form>
                            @endif
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
@endsection
