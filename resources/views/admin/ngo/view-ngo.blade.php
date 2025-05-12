@extends('admin.layout.AdminLayout')

@section('content')
    <div class="wrapper">
        <div class="container-fluid">

            <!-- Breadcrumb (hidden in print) -->
            <div class="row justify-content-end mt-4 print-hide">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('admin') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">NGO Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- NGO Profile Card - PRINT AREA -->
            <div class="print-area card shadow-lg p-4 mt-4 border-0">
                <div class="d-flex justify-content-between align-items-center mb-4 print-hide">
                    <h4 class="text-primary mb-0">
                        <i class="fas fa-building me-2"></i> NGO Profile: <strong>{{ $ngo->ngo_name }}</strong>
                    </h4>
                    <button class="btn btn-outline-primary btn-sm" onclick="window.print();">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>

                <div class="row g-4">
                    <!-- Left Column: Details -->
                    <div class="col-md-8">
                        <div class="row g-3">

                            <div class="col-sm-6">
                                <div class="bg-light p-3 rounded border h-100">
                                    <small class="text-muted">Established Year</small>
                                    <div class="fw-bold text-dark">{{ $ngo->established_date }}</div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="bg-light p-3 rounded border h-100">
                                    <small class="text-muted">Founder Name</small>
                                    <div class="fw-bold text-dark">{{ $ngo->founder_name }}</div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="bg-light p-3 rounded border h-100">
                                    <small class="text-muted">Email</small>
                                    <div class="fw-bold text-dark">{{ $ngo->email }}</div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="bg-light p-3 rounded border h-100">
                                    <small class="text-muted">Mobile</small>
                                    <div class="fw-bold text-dark">{{ $ngo->phone_number }}</div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="bg-light p-3 rounded border h-100">
                                    <small class="text-muted">Country</small>
                                    <div class="fw-bold text-dark">{{ $ngo->country }}</div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="bg-light p-3 rounded border h-100">
                                    <small class="text-muted">State</small>
                                    <div class="fw-bold text-dark">{{ $ngo->state }}</div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="bg-light p-3 rounded border h-100">
                                    <small class="text-muted">District</small>
                                    <div class="fw-bold text-dark">{{ $ngo->district }}</div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="bg-light p-3 rounded border h-100">
                                    <small class="text-muted">Post</small>
                                    <div class="fw-bold text-dark">{{ $ngo->post }}</div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="bg-light p-3 rounded border h-100">
                                    <small class="text-muted">Pincode</small>
                                    <div class="fw-bold text-dark">{{ $ngo->pin_code }}</div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="bg-light p-3 rounded border h-100">
                                    <small class="text-muted">Address</small>
                                    <div class="fw-bold text-dark">{{ $ngo->address }}</div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="bg-light p-3 rounded border h-100">
                                    <small class="text-muted">Package</small>
                                    <div class="fw-bold text-dark">{{ $ngo->package }}</div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="bg-light p-3 rounded border h-100">
                                    <small class="text-muted">Start Date</small>
                                    <div class="fw-bold text-dark">{{ $ngo->start_date }}</div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="bg-light p-3 rounded border h-100">
                                    <small class="text-muted">End Date</small>
                                    <div class="fw-bold text-dark">{{ $ngo->end_date }}</div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Right Column: Logo -->
                    <div class="col-md-4 text-center">
                        <label class="form-label text-secondary"><strong>NGO Logo</strong></label>
                        <div class="bg-white p-3 rounded shadow-sm border">
                            <img src="{{ asset('images/' . $ngo->logo) }}" alt="NGO Logo" class="img-fluid rounded"
                                style="max-height: 180px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Print Styling -->
    <style>
        .fade-in {
            animation: fadeInUp 0.7s ease-in-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .print-hide {
                display: none !important;
            }
        }
    </style>
@endsection
