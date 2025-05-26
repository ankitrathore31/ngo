@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        {{-- <div class="main-content"> --}}
        <!-- Breadcrumb -->
        <div class="row d-flex justify-content-end mt-2">
            <div class="col-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('ngo') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Beneficiary Report</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container my-5">
            <div class="card shadow-lg p-4 print-area">
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
                            <h4 style=" font-size:20px;"><b>Beneficiary Report</b></h4>
                            {{-- <p style=""><b></b></p> --}}
                        </div>
                    </div>
                </div>
                <!-- etails Section -->
                <div class="row g-2 mt-1">
                    <div class="col-md-6">
                        <p><strong>Application No:</strong> {{ $beneficiarie->application_no }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Registration No:</strong> {{ $beneficiarie->registration_no }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Application Date:</strong> {{ $beneficiarie->application_date }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Registration Date:</strong> {{ $beneficiarie->registration_date }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Full Name:</strong> {{ $beneficiarie->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Date of Birth:</strong> {{ $beneficiarie->dob }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Gender:</strong> {{ $beneficiarie->gender }}</p>
                    </div>
                    {{-- <div class="col-md-6">
                        <p><strong>Eligibility:</strong> {{ $beneficiarie->eligibility }}</p>
                    </div> --}}
                    <div class="col-md-6">
                        <p><strong>Occupation:</strong> {{ $beneficiarie->occupation ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6">
                        <p><strong>Survey Date:</strong>
                            {{ \Carbon\Carbon::parse($beneficiarie->survey_date)->format('d M Y') }}</p>
                    </div>
                    <div class="col-12">
                        <div class="">
                            <p class="mb-0">
                                <b>Full Address:</b>
                                {{ $beneficiarie->village }},
                                ({{ $beneficiarie->area_type }}),
                                {{ $beneficiarie->post }},
                                {{ $beneficiarie->block }},
                                {{ $beneficiarie->district }},
                                {{ $beneficiarie->state }} - {{ $beneficiarie->pincode }}, 
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <p><strong>Survey Details:</strong> {{ $beneficiarie->survey_details }}</p>
                    </div>
                    <div class="col-12">
                        <p><strong>Help by NGO:</strong> {{ $beneficiarie->help_by_ngo }}</p>
                    </div>

                </div>

                <!-- Action Buttons -->
                {{-- <div class="text-center mt-5 no-print">
                    <button class="btn btn-primary me-2" onclick="window.print()">🖨️ Print Report</button>
                    <button class="btn btn-outline-secondary" onclick="shareReport()">📤 Share</button>
                </div> --}}
            </div>
        </div>
    @endsection
