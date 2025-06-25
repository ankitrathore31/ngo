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

                <div class="col-md-2 col-sm-4">
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}"
                        placeholder="Start Date">
                </div>
                <div class="col-md-2 col-sm-4">
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}"
                        placeholder="End Date">
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
                <p><b>- Offline Donation</b></p>
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
@endsection
