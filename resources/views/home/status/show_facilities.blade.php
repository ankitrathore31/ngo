@extends('home.layout.MasterLayout')

@section('content')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            /* Facilities card is the only thing this page's own print handles.
               The Registration card is printed separately via its own window (see script below),
               so it deliberately has no print rule here. */
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
        }
    </style>
    <div class="wrapper">
        {{-- <div class="main-content"> --}}
        <!-- Breadcrumb -->
        <div class="row d-flex justify-content-end mt-2">
            <div class="col-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Facilities Report</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container my-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Facilities Status</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#registrationModal">Registration Download</button>
                <button onclick="window.print()" class="btn btn-primary">Print / Download</button>
            </div>
            <div class="card shadow-lg p-4 print-card">
                <!-- Report Header -->
                <div class="text-center mb-4 border-bottom">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center text-md-start">
                            <a href="https://gyanbhartingo.org">
                                <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80" height="80"
                                    class="">
                            </a>
                        </div>
                        <div class="col-md-6 text-center">
                            <h4 style="color: red; font-weight:500; font-size:25px;"><b>GYAN BHARTI SANSTHA</b></h4>
                            <h6 style="color: blue;"><b>Head Office: Kainchu Tanda Amaria Pilibhit UP 262121</b></h6>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4 style=" font-size:20px;"><b>Facilities Report</b></h4>
                        </div>
                    </div>
                </div>
                <div class="row g-2 mt-1">
                    <div class="col-sm-4">
                        <p><strong>Registration Type:</strong> {{ $beneficiarie->reg_type ?? 'N/A' }}</p>
                    </div>
                    <div class="col-sm-4">
                        <p><strong>Full Name:</strong> {{ $beneficiarie->name }}</p>
                    </div>
                    <div class="col-sm-4">
                        <p><strong>Father/Husband Name:</strong> {{ $beneficiarie->gurdian_name }}</p>
                    </div>
                    <div class="col-sm-4">
                        <p><strong>Date of Birth:</strong> {{ $beneficiarie->dob }}</p>
                    </div>
                    <div class="col-sm-4">
                        <p><strong>Gender:</strong> {{ $beneficiarie->gender }}</p>
                    </div>
                    <div class="col-sm-4">
                        <p><strong>Occupation:</strong> {{ $beneficiarie->occupation ?? 'N/A' }}</p>
                    </div>
                    <div class="col-sm-4">
                        <p><strong>Caste:</strong> {{ $beneficiarie->caste ?? 'N/A' }}</p>
                    </div>
                    <div class="col-sm-4">
                        <p><strong>Caste Category:</strong> {{ $beneficiarie->religion_category ?? 'N/A' }}</p>
                    </div>
                    <div class="col-sm-4">
                        <p><strong>Religion:</strong> {{ $beneficiarie->religion ?? 'N/A' }}</p>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="">
                            <p class="mb-0">
                                <b>Full Address:</b>
                                {{ $beneficiarie->village }},
                                {{ $beneficiarie->post }},
                                {{ $beneficiarie->block }},
                                {{ $beneficiarie->district }},
                                {{ $beneficiarie->state }} - {{ $beneficiarie->pincode }},
                                ({{ $beneficiarie->area_type }})
                            </p>
                        </div>
                    </div>
                    {{-- <hr> --}}
                    <div class="col-sm-12 mb-3 mt-1">
                        <h5><u>Facilities Details</u></h5>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-hover align-middle text-center">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Date</th>
                                        <th>Facilities Name</th>
                                        <th>Facilities</th>
                                        <th>Status</th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Application Details --}}
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            {{ $beneficiarie->application_date ? \Carbon\Carbon::parse($beneficiarie->application_date)->format('d-m-Y') : 'Not Found' }}
                                        </td>
                                        <td>Application No.</td>
                                        <td>{{ $beneficiarie->application_no ?? 'Pending' }}</td>
                                        <td>{{ $beneficiarie->status == 1 ? 'Approved' : 'Pending' }}</td>
                                        <td></td>
                                    </tr>

                                    {{-- Registration Details --}}
                                    <tr>
                                        <td>2</td>
                                        <td>
                                            {{ $beneficiarie->registration_date ? \Carbon\Carbon::parse($beneficiarie->registration_date)->format('d-m-Y') : 'Not Found' }}
                                        </td>
                                        <td>Registration No.</td>
                                        <td>{{ $beneficiarie->registration_no ?? 'Pending' }}</td>
                                        <td>{{ $beneficiarie->status == 1 ? 'Approved' : 'Pending' }}</td>
                                        <td></td>
                                    </tr>

                                    {{-- First Survey Info --}}
                                    <tr>
                                        <td>3</td>
                                        <td>
                                            @if ($firstSurvey && $firstSurvey->survey_date)
                                                {{ \Carbon\Carbon::parse($firstSurvey->survey_date)->format('d-m-Y') }}
                                            @else
                                                No Survey Date
                                            @endif
                                        </td>

                                        <td>Survey</td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            {{ isset($firstSurvey) && $firstSurvey->survey_details ? $firstSurvey->survey_details : 'No Survey Details' }}
                                        </td>

                                    </tr>
                                    {{-- All Distributed Facilities --}}
                                    @php $serial = 4; @endphp
                                    @foreach ($surveys as $survey)
                                        <tr>
                                            <td>{{ $serial++ }}</td>
                                            <td>
                                                {{ $survey->distribute_date ? \Carbon\Carbon::parse($survey->distribute_date)->format('d-m-Y') : 'Not Found' }}
                                            </td>
                                            <td>{{ $survey->facilities_category ?? 'Pending' }}</td>
                                            <td>{{ $survey->facilities ?? 'Pending' }}</td>
                                            <td>
                                                {{ $survey->status ?? 'Pending' }}
                                                @if ($survey->status !== 'Distributed' && $survey->pending_reason)
                                                    <br><small>Pending reason: {{ $survey->pending_reason }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                Distribute Place: {{ $survey->distribute_place ?? 'Pending' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        {{-- ===================== Registration Preview Modal ===================== --}}
        <div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="registrationModalLabel">Registration Form Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @php
                            $imagePath = $beneficiarie->reg_type === 'Member' ? 'member_images/' : 'benefries_images/';
                        @endphp

                        <div class="card p-4 shadow rounded registration-print-card">
                            <div class="text-center mb-4 border-bottom">
                                <div class="row align-items-center">
                                    <div class="col-sm-2 text-center text-md-start">
                                        <a href="https://gyanbhartingo.org">
                                            <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80"
                                                height="80" class="">
                                        </a>
                                    </div>
                                    <div class="col-sm-10 text-center">
                                        <h4 style="color: red; font-weight:500; font-size:25px;"><b>GYAN BHARTI
                                                SANSTHA</b></h4>
                                        <h6 style="color: blue;"><b>Head Office: Kainchu Tanda Amaria Pilibhit UP
                                                262121</b></h6>
                                        <p><b>Website : www.gyanbhartingo.org Email : gyanbhartingo600@gmail.com
                                                Mob- 9411484111</b>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-4 mb-3">
                                    <strong>Application Date:</strong>
                                    {{ $beneficiarie->application_date ? \Carbon\Carbon::parse($beneficiarie->application_date)->format('d-m-Y') : 'N/A' }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Application No:</strong> {{ $beneficiarie->application_no ?? 'N/A' }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition Type:</strong> {{ $beneficiarie->reg_type ?? 'N/A' }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Registraition No:</strong> {{ $beneficiarie->registration_no ?? 'N/A' }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Session:</strong> {{ $beneficiarie->academic_session ?? 'N/A' }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <strong>Name:</strong> {{ $beneficiarie->name }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Guardian's Name:</strong> {{ $beneficiarie->gurdian_name }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Mother's Name:</strong> {{ $beneficiarie->mother_name ?? 'N/A' }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Area Type:</strong> {{ $beneficiarie->area_type }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Village/Locality:</strong> {{ $beneficiarie->village }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Post/Town:</strong> {{ $beneficiarie->post }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Block:</strong> {{ $beneficiarie->block }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>District</strong> {{ $beneficiarie->district }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>State</strong> {{ $beneficiarie->state }}
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <strong>Pincode:</strong> {{ $beneficiarie->pincode }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <img src="{{ asset($imagePath . $beneficiarie->image) }}" alt="Image"
                                            class="img-thumbnail" width="150">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4 mb-3">
                                    <strong>Country:</strong> {{ $beneficiarie->country ?? 'N/A' }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Gender:</strong> {{ $beneficiarie->gender }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Phone:</strong> {{ $beneficiarie->phone }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Email:</strong> {{ $beneficiarie->email ?? 'N/A' }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Eligibility:</strong> {{ $beneficiarie->eligibility ?? 'N/A' }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Caste:</strong> {{ $beneficiarie->caste }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Religion Category:</strong> {{ $beneficiarie->religion_category }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Religion:</strong> {{ $beneficiarie->religion }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Date of Birth:</strong>
                                    {{ $beneficiarie->dob ? \Carbon\Carbon::parse($beneficiarie->dob)->format('d-m-Y') : 'N/A' }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Marital Status:</strong> {{ $beneficiarie->marital_status ?? 'N/A' }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Occupation:</strong> {{ $beneficiarie->occupation ?? 'N/A' }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Identity Type:</strong> {{ $beneficiarie->identity_type ?? 'N/A' }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>Identity Number:</strong> {{ $beneficiarie->identity_no ?? 'N/A' }}
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <strong>ID Document:</strong>
                                    <a href="{{ asset($imagePath . $beneficiarie->id_document) }}"
                                        target="_blank">View Document</a>
                                </div>
                            </div>

                            <div class="row">
                                @if ($beneficiarie->reg_type == 'Beneficiaries')
                                    <div class="col-sm-8 mb-3">
                                        <strong>Help Needed:</strong> {{ $beneficiarie->help_needed ?? 'N/A' }}
                                    </div>
                                @endif
                            </div>
                            <hr>
                            <div class="row d-flex justify-content-between mt-2">
                                <div class="col-sm-4 mb-5">
                                    <label class="form-label"><b>{{ $beneficiarie->reg_type }} Signature/ Thumb
                                            Impression of the Recipient</b></label>
                                </div>
                                <div class="col-sm-4 mb-5">
                                    <label class="form-label"><b>Signature</b></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="printRegistrationBtn">Print /
                            Download</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- =================== End Registration Preview Modal =================== --}}
    </div>

    <script>
        document.getElementById('printRegistrationBtn').addEventListener('click', function () {
            var cardHtml = document.querySelector('#registrationModal .registration-print-card').outerHTML;

            var printWindow = window.open('', '_blank', 'width=950,height=700');
            if (!printWindow) {
                alert('Please allow pop-ups for this site to print the registration form.');
                return;
            }

            printWindow.document.open();
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="utf-8">
                    <title>Registration Form</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        body { padding: 24px; }
                        .registration-print-card { box-shadow: none !important; }
                        img { max-width: 150px; }
                    </style>
                </head>
                <body>
                    ${cardHtml}
                </body>
                </html>
            `);
            printWindow.document.close();

            // Wait for images/CSS to finish loading before triggering print
            printWindow.onload = function () {
                printWindow.focus();
                printWindow.print();
            };
        });
    </script>
@endsection