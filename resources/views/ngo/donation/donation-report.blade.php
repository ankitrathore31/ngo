@extends('ngo.layout.master')
@section('content')
    <style>
        .card {
            border: none;
            border-radius: 8px;
            padding: 15px;
        }

        .card .icon {
            font-size: 24px;
            color: #fff;
            margin-right: 10px;
        }

        .card .info-text {
            font-size: 14px;
            color: #fff;
            margin: 0;
        }

        .card h4 {
            margin: 5px 0 0;
            font-size: 16px;
            color: #fff;
            font-weight: 600;
        }

        .card h5 {
            font-size: 20px;
            color: #fff;
            font-weight: 700;
            margin: 0;
        }

        .dashboard-row {
            gap: 5px;
        }

        .chart-container {
            width: 100%;
            height: 400px;
            /* Fixed height to match both charts */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        canvas {
            max-width: 100% !important;
            max-height: 100% !important;
        }
    </style>
    <style>
        @page {
            size: auto;
            margin: 0;
            /* Remove all margins including top */
        }

        @media print {

            html,
            body {
                margin: 0 !important;
                padding: 0 !important;
                height: 100% !important;
                width: 100% !important;
            }

            body * {
                visibility: hidden;
            }

            .printable,
            .printable * {
                visibility: visible;
            }

            .table th,
            .table td {
                padding: 4px !important;
                font-size: 9px !important;
                border: 1px solid #000 !important;
            }

            .card,
            .table-responsive {
                box-shadow: none !important;
                border: none !important;
                overflow: visible !important;
            }

            .btn,
            .navbar,
            .footer,
            .no-print {
                display: none !important;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }
        }
    </style>
    <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
        <h5 class="mb-0">Donation Report</h5>

        <!-- Breadcrumb aligned to right -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report</li>
            </ol>
        </nav>
    </div>
    @if (session('success'))
        <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <div class="row">
            <form method="GET" action="{{ route('dontaion-report') }}" class="row g-3 mb-4">
                <div class="col-md-3 col-sm-4">
                    <select name="session_filter" id="session_filter" class="form-control" onchange="this.form.submit()">
                        <option value="">All Sessions</option>
                        @foreach ($data as $session)
                            <option value="{{ $session->session_date }}"
                                {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                {{ $session->session_date }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- In your form --}}
                <div class="col-md-2 col-sm-4">
                    <input type="date" name="start_date" class="form-control"
                        value="{{ request('start_date', now()->format('Y-m-d')) }}" placeholder="Start Date">
                </div>
                <div class="col-md-2 col-sm-4">
                    <input type="date" name="end_date" class="form-control"
                        value="{{ request('end_date', now()->format('Y-m-d')) }}" placeholder="End Date">
                </div>


                <div class="col-md-2 col-sm-4">
                    <select name="donation_type" class="form-control">
                        <option value="all" {{ request('donation_type') == 'all' ? 'selected' : '' }}>All</option>
                        <option value="offline" {{ request('donation_type') == 'offline' ? 'selected' : '' }}>Offline
                        </option>
                        <option value="online" {{ request('donation_type') == 'online' ? 'selected' : '' }}>Online</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary me-1">Search</button>
                    <a href="{{ route('dontaion-report') }}" class="btn btn-info text-white me-1">Reset</a>
                </div>
            </form>

        </div>
    </div>

    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body">
                <p><b>- Donation</b></p>
                <div class="row dashboard-row justify-content-between">
                    <div class="col-md-2 col-sm-6 mb-3">
                        <div class="card bg-info text-white ">
                            <i class="fas fa-dollar-sign icon"></i>
                            <div>
                                <p class="info-text">Today Donation</p>
                                <h5>{{ number_format($today, 2) }}</h5>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 mb-3">
                        <div class="card bg-secondary text-white">
                            <!-- <div class="card-body text-center"> -->
                            <i class="fas fa-dollar-sign icon"></i>
                            <!-- <h4>Total Class</h4> -->
                            <div>
                                <p class="info-text">Range Donation</p>
                                <h5>{{ number_format($rangeDonation, 2) }}</h5>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 mb-3">
                        <div class="card bg-success">
                            <i class="fas fa-dollar-sign icon"></i>
                            <div>
                                <p class="info-text">Total Donation</p>
                                <h5>{{ number_format($totalDonation, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 mb-3">
                        <div class="card bg-primary d-flex ">
                            <i class="fas fa-dollar-sign icon"></i>
                            <div>
                                <p class="info-text">This year</p>
                                <h5>{{ number_format($thisYear, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 mb-3">
                        <div class="card bg-warning d-flex ">
                            <i class="fas fa-dollar-sign icon"></i>
                            <div>
                                <p class="info-text">This Month</p>
                                <h5>{{ number_format($thisMonth, 2) }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="d-flex justify-content-between">
                <button onclick="printTable()" class="btn btn-primary mb-1 text-end">Print Table</button>
                <h5>Today Collection ({{ now()->format('d-m-Y') }}): &nbsp;₹{{ number_format($today, 2) }}</h5>
            </div>
        </div>
        <div class="card shadow-sm printable">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Receipt No.</th>
                            <th>Donation date</th>
                            <th>Name</th>
                            <th>Address</th>
                            {{-- <th>Identity No.</th>
                                <th>Identity Type</th> --}}
                            <th>Mobile no.</th>
                            {{-- <th>Email</th> --}}
                            {{-- <th>Donation Category</th> --}}
                            <th>Donation Amount</th>
                            {{-- <th>Status</th> --}}
                            <th>Payment Mode</th>
                            <th>Session</th>
                            {{-- <th class="no-print">Action</th> --}}
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($donations as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->receipt_no ?? '-' }}</td>
                                <td>{{ $item->date ? \Carbon\Carbon::parse($item->date)->format('d-m-Y') : 'Not Found' }}
                                </td>
                                <td>{{ $item->name ?? '-' }}</td>
                                <td>{{ $item->address ?? $item->donor_village }}</td>
                                <td>{{ $item->mobile ?? '-' }}</td>
                                <td>{{ $item->amount }}</td>
                                <td>{{ $item->payment_method ?? 'Online cashfree' }}</td>
                                <td>{{ $item->academic_session }}</td>
                                {{-- <td class="no-print">
                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <a href="{{ route('view-donation', $item->id) }}"
                                            class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                            title="View" style="min-width: 38px; height: 38px;">
                                            <i class="fa-regular fa-eye"></i>
                                        </a>
                                    </div>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>
        </div>
    </div>
@endsection
