@extends('home.layout.MasterLayout')

@section('content')
    <style>
        @media print {
            body * {
                visibility: hidden !important;
            }

            .container,
            .container * {
                visibility: visible !important;
            }

            .container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .btn,
            .btn *,
            .no-print {
                display: none !important;
            }
        }
    </style>


    <div class="d-flex justify-content-between align-items-center m-3">
        <h5 class="mb-0">Application Status</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                <li class="breadcrumb-item"><a href="{{ route('applictionStatus') }}">Back</a></li>
                <li class="breadcrumb-item active" aria-current="page">Status</li>
            </ol>
        </nav>
    </div>
    @if (session('success'))
        <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="container my-4">
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
                    <h4 style=" font-size:20px;"><b><span>{{ $application->reg_type }}</span> Application Status</b>
                    </h4>
                    <p style="">Track your application details below</p>
                </div>
            </div>
        </div>
        {{-- <div class="text-center mb-4">
            <h3 class="fw-bold"> </h3>
            <p class="text-muted"></p>
        </div> --}}

        <div class="card shadow-sm border">
            {{-- <div class="card-header bg-primary text-white">
                <strong>Applicant Information</strong>
            </div> --}}
            <div class="card-body p-4">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Application Date</th>
                            <td>{{ \Carbon\Carbon::parse($application->application_date ?? now())->format('d-m-Y') }}
                            </td>
                            <th>Application Number</th>
                            <td>{{ $application->application_no }}</td>

                        </tr>
                        <tr>
                            <th width="30%">Full Name</th>
                            <td>{{ $application->name ?? 'N/A' }}</td>
                            <th>Phone Number</th>
                            <td>{{ $application->phone ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th width="30%">Father/Husband Name</th>
                            <td>{{ $application->gurdian_name ?? 'N/A' }}</td>
                            <th>Mother Name</th>
                            <td>{{ $application->mother_name ?? 'N/A' }}</td>
                        </tr>
                        {{-- <tr>
                            <th>Registered Date</th>
                            <td>{{ \Carbon\Carbon::parse($application->registration_date ?? now())->format('d-m-Y') }}</td>
                            <th>Registration Number</th>
                            <td>{{ $application->registration_no ?? 'N/A' }}</td>
                        </tr> --}}
                        <tr>
                            <th>DOB</th>
                            <td>{{ \Carbon\Carbon::parse($application->dob ?? now())->format('d-m-Y') }}</td>
                            <th>Gender</th>
                            <td>{{ $application->gender ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Application Status</th>
                            <td>
                                @if (isset($application->status))
                                    <span
                                        class="badge {{ $application->status == 1 ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $application->status == 1 ? 'Approved' : 'Pending' }}
                                    </span>
                                @else
                                    <span class="text-muted">Not Available</span>
                                @endif
                            </td>

                            <th>Remark</th>
                            <td>
                                @if (isset($application->status))
                                    @if ($application->status == 1)
                                        <span class="text-success">Your application has been approved and forwarded to the
                                            Founder</span>
                                    @else
                                        <span class="text-warning">Your application is still under review. Please wait for
                                            approval.</span>
                                    @endif
                                @else
                                    <span class="text-muted">No remarks available.</span>
                                @endif
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 text-end no-print">
            <a href="#" onclick="window.print()" class="btn btn-outline-primary me-2">
                <i class="bi bi-printer"></i> Print
            </a>
            {{-- <a href="{{ route('certificate.download', $application->id) }}" class="btn btn-success">
                <i class="bi bi-download"></i> Download Certificate
            </a> --}}
        </div>
    </div>
@endsection
