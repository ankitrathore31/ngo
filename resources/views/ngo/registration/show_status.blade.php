@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Registration Status</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reg.status.form') }}">Status</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Result</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div class="alert alert-success fade-in-alert">{{ session('success') }}</div>
            @endif

            @php
                $isApproved = $record->status == 1;
                $isRegistered = !empty($record->registration_no);
            @endphp

            <div class="card shadow p-4 result-card">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <div>
                        <h4 class="fw-bold mb-0">{{ $record->name }}</h4>
                        <small class="text-muted">{{ $record->reg_type }} · Identity No: {{ $record->identity_no }}</small>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('reg.status.form') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> New Search
                        </a>
                    </div>
                </div>

                <hr>

                <!-- Status Boxes -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="status-box p-3 rounded {{ $isApproved ? 'status-approved' : 'status-pending' }}">
                            <div class="d-flex align-items-center">
                                <i
                                    class="bi {{ $isApproved ? 'bi-check-circle-fill' : 'bi-hourglass-split spin-icon' }} fs-2 me-3"></i>
                                <div>
                                    <h6 class="mb-0">Application Status</h6>
                                    <span class="fw-bold">{{ $isApproved ? 'Approved' : 'Pending' }}</span>
                                </div>
                            </div>
                            <div class="mt-2 small">
                                <div><strong>Application No:</strong> {{ $record->application_no ?? 'N/A' }}</div>
                                <div><strong>Date:</strong>
                                    {{ $record->application_date ? \Carbon\Carbon::parse($record->application_date)->format('d-m-Y') : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="status-box p-3 rounded {{ $isRegistered ? 'status-approved' : 'status-pending' }}">
                            <div class="d-flex align-items-center">
                                <i
                                    class="bi {{ $isRegistered ? 'bi-patch-check-fill' : 'bi-hourglass-split spin-icon' }} fs-2 me-3"></i>
                                <div>
                                    <h6 class="mb-0">Registration Status</h6>
                                    <span class="fw-bold">{{ $isRegistered ? 'Registered' : 'Not Registered Yet' }}</span>
                                </div>
                            </div>
                            <div class="mt-2 small">
                                <div><strong>Registration No:</strong> {{ $record->registration_no ?? 'N/A' }}</div>
                                <div><strong>Date:</strong>
                                    {{ $record->registration_date ? \Carbon\Carbon::parse($record->registration_date)->format('d-m-Y') : 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Quick Details -->
                <div class="row mt-2">
                    <div class="col-sm-4 mb-2"><strong>Guardian's Name:</strong> {{ $record->gurdian_name }}</div>
                    <div class="col-sm-4 mb-2"><strong>Gender:</strong> {{ $record->gender }}</div>
                    <div class="col-sm-4 mb-2"><strong>Phone:</strong> {{ $record->phone }}</div>
                    <div class="col-sm-4 mb-2"><strong>Occupation:</strong> {{ $record->occupation ?? 'N/A' }}</div>
                    <div class="col-sm-4 mb-2"><strong>Caste:</strong> {{ $record->caste ?? 'N/A' }}</div>
                    <div class="col-sm-4 mb-2"><strong>Religion:</strong> {{ $record->religion ?? 'N/A' }}</div>
                    <div class="col-12 mb-2">
                        <strong>Full Address:</strong>
                        {{ $record->village }}, {{ $record->post }}, {{ $record->block }},
                        {{ $record->district }}, {{ $record->state }} - {{ $record->pincode }}
                        ({{ $record->area_type }})
                    </div>
                </div>

                <!-- Facilities / Survey Details -->
                <hr>
                <div class="mb-2">
                    <h5><u>Facilities Details</u></h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center facilities-table">
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
                                <tr>
                                    <td>1</td>
                                    <td>
                                        {{ $record->application_date ? \Carbon\Carbon::parse($record->application_date)->format('d-m-Y') : 'Not Found' }}
                                    </td>
                                    <td>Application No.</td>
                                    <td>{{ $record->application_no ?? 'Pending' }}</td>
                                    <td>{{ $record->status == 1 ? 'Approved' : 'Pending' }}</td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td>
                                        {{ $record->registration_date ? \Carbon\Carbon::parse($record->registration_date)->format('d-m-Y') : 'Not Found' }}
                                    </td>
                                    <td>Registration No.</td>
                                    <td>{{ $record->registration_no ?? 'Pending' }}</td>
                                    <td>{{ $record->status == 1 ? 'Approved' : 'Pending' }}</td>
                                    <td></td>
                                </tr>

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

                                @php $serial = 4; @endphp
                                @forelse ($surveys as $survey)
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
                                        <td>Distribute Place: {{ $survey->distribute_place ?? 'Pending' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-muted">No distributed facilities yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Download Buttons -->
                <div class="d-flex gap-3 mt-4 flex-wrap">
                    <a href="{{ route('view-reg', [$record->id, $record->reg_type]) }}" target="_blank"
                        class="btn btn-outline-primary download-btn">
                        <i class="bi bi-file-earmark-text"></i> Download Registration Form
                    </a>

                    @if ($isRegistered)
                        <a href="{{ route('show-reg-card', [$record->id, $record->reg_type]) }}" target="_blank"
                            class="btn btn-success download-btn">
                            <i class="bi bi-card-checklist"></i> Download Registration Card
                        </a>
                    @else
                        <button class="btn btn-secondary" disabled title="Available once registered">
                            <i class="bi bi-card-checklist"></i> Registration Card (Not Available Yet)
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        .result-card {
            opacity: 0;
            transform: translateY(15px);
            animation: fadeUp .5s ease forwards;
            border-radius: 14px;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .status-box {
            transition: transform .2s ease;
        }

        .status-box:hover {
            transform: translateY(-4px);
        }

        .status-approved {
            background-color: #e6f7ec;
            border: 1px solid #28a745;
            color: #1e7e34;
        }

        .status-pending {
            background-color: #fff8e6;
            border: 1px solid #ffc107;
            color: #a86b00;
        }

        .spin-icon {
            animation: spin 2.5s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        .download-btn {
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0, 0, 0, .12);
        }

        .fade-in-alert {
            animation: fadeUp .4s ease forwards;
        }

        .facilities-table tbody tr {
            opacity: 0;
            animation: rowIn .4s ease forwards;
        }

        .facilities-table tbody tr:nth-child(1) {
            animation-delay: .05s;
        }

        .facilities-table tbody tr:nth-child(2) {
            animation-delay: .1s;
        }

        .facilities-table tbody tr:nth-child(3) {
            animation-delay: .15s;
        }

        .facilities-table tbody tr:nth-child(4) {
            animation-delay: .2s;
        }

        .facilities-table tbody tr:nth-child(5) {
            animation-delay: .25s;
        }

        @keyframes rowIn {
            from {
                opacity: 0;
                transform: translateX(-8px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
@endsection
