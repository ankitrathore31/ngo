@extends('home.layout.MasterLayout')

@section('content')
    <style>
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
                        {{-- <h5><u>Survey Details</u></h5>
                        <div class="col-sm-12">
                            <div class="col-md-4">
                                <p><strong>Survey Date:</strong>
                                    {{ \Carbon\Carbon::parse($beneficiarie->$surveys->survey_date)->format('d M Y') ?? 'Pending' }}
                                </p>
                            </div>
                            <div class="col-8">
                                <p><strong>Survey Details:</strong> {{$beneficiarie->$surveys->survey_details ?? 'Pending' }}</p>
                            </div>
                        </div> --}}

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
    @endsection
