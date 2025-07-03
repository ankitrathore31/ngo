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
                <div class="row mb-2">
                    <div class="col-md-3 col-sm-4">
                        <select name="session_filter" id="session_filter" class="form-control">
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
                    <div class="col-md-3 col-sm-4">
                        <input type="date" name="start_date" class="form-control"
                            value="{{ request('start_date', now()->format('Y-m-d')) }}" placeholder="Start Date">
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <input type="date" name="end_date" class="form-control"
                            value="{{ request('end_date', now()->format('Y-m-d')) }}" placeholder="End Date">
                    </div>

                    <div class="col-md-3 col-sm-4">
                        <select name="donation_type" class="form-control">
                            <option value="all" {{ request('donation_type') == 'all' ? 'selected' : '' }}>All</option>
                            <option value="offline" {{ request('donation_type') == 'offline' ? 'selected' : '' }}>Offline
                            </option>
                            <option value="online" {{ request('donation_type') == 'online' ? 'selected' : '' }}>Online
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    @php
                        $districtsByState = config('districts');
                    @endphp
                    <div class="col-md-4 col-sm-6 form-group mb-3">
                        {{-- <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label> --}}
                        <select class="form-control @error('state') is-invalid @enderror" name="state" id="stateSelect">
                            <option value="">Select State</option>
                            @foreach ($districtsByState as $state => $districts)
                                <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>
                                    {{ $state }}
                                </option>
                            @endforeach
                        </select>
                        @error('state')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 col-sm-6 form-group mb-3">
                        {{-- <label for="districtSelect" class="form-label">District: <span
                                    class="text-danger">*</span></label> --}}
                        <select class="form-control @error('district') is-invalid @enderror" name="district"
                            id="districtSelect">
                            <option value="">Select District</option>
                        </select>
                        @error('district')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 col-sm-6 form-group mb-3">
                        {{-- <label for="block" class="form-label">Block: <span class="text-danger">*</span></label> --}}
                        <input type="text" name="block" id="block"
                            class="form-control @error('block') is-invalid @enderror" value="{{ old('block') }}"
                            placeholder="Search by Block">
                        @error('block')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
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
            <div class="d-flex justify-content-between align-items-center mb-2">
                <button onclick="printTable()" class="btn btn-primary">Print Table</button>
                <h5 class="mb-0">Today Collection ({{ now()->format('d-m-Y') }}): ₹{{ number_format($today, 2) }}</h5>
            </div>
        </div>

        <div class="card shadow-sm printable">
            <div class="card-body table-responsive">

                {{-- 🔍 Filter Summary (Shown Above Table) --}}
                @if (
                    !empty($filters['session']) ||
                        !empty($filters['state']) ||
                        !empty($filters['district']) ||
                        !empty($filters['block']))
                    <div class="mb-3 p-3 border rounded bg-light">
                        <h5 class="mb-2 text-black">Traget Record:</h5>
                        <div class="row">
                            @if (!empty($filters['session']))
                                <div class="col-md-3"><strong>Session:</strong> {{ $filters['session'] }}</div>
                            @endif
                            @if (!empty($filters['state']))
                                <div class="col-md-3"><strong>State:</strong> {{ $filters['state'] }}</div>
                            @endif
                            @if (!empty($filters['district']))
                                <div class="col-md-3"><strong>District:</strong> {{ $filters['district'] }}</div>
                            @endif
                            @if (!empty($filters['block']))
                                <div class="col-md-3"><strong>Block:</strong> {{ $filters['block'] }}</div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- 📊 Main Table --}}
                <table class="table table-bordered table-hover align-middle text-center" style="border: 1px solid #000;">
                    <thead class="table-primary" style="border: 1px solid #000;">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Receipt No.</th>
                            <th>Donation Date</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Mobile No.</th>
                            <th>Donation Amount</th>
                            <th>Payment Mode</th>
                            <th>Session</th>
                            <th>State</th>
                            <th>District</th>
                            <th>Block</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $totalAmount = 0; @endphp

                        @foreach ($donations as $item)
                            @php $totalAmount += $item->amount; @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->receipt_no ?? '-' }}</td>
                                <td>{{ $item->date ? \Carbon\Carbon::parse($item->date)->format('d-m-Y') : 'Not Found' }}
                                </td>
                                <td>{{ $item->name ?? '-' }}</td>
                                <td>{{ $item->address ?? $item->donor_village }}</td>
                                <td>{{ $item->mobile ?? '-' }}</td>
                                <td>₹{{ number_format($item->amount, 2) }}</td>
                                <td>{{ $item->payment_method ?? 'Online cashfree' }}</td>
                                <td>{{ $item->academic_session ?? '-' }}</td>
                                <td>{{ $item->state ?? '-' }}</td>
                                <td>{{ $item->district ?? '-' }}</td>
                                <td>{{ $item->block ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr style="font-weight: bold; background-color: #f2f2f2;">
                            <td colspan="6" class="text-end">Total Records: {{ $donations->count() }}</td>
                            <td>₹{{ number_format($totalAmount, 2) }}</td>
                            <td colspan="5">--</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <script>
        function printTable() {
            window.print();
        }
    </script>
    <script>
        const allDistricts = @json($districtsByState);
        const oldDistrict = "{{ old('district') }}";
        const oldState = "{{ old('state') }}";

        function populateDistricts(state) {
            const districtSelect = document.getElementById('districtSelect');
            districtSelect.innerHTML = '<option value="">Select District</option>';

            if (allDistricts[state]) {
                allDistricts[state].forEach(function(district) {
                    const selected = (district === oldDistrict) ? 'selected' : '';
                    districtSelect.innerHTML += `<option value="${district}" ${selected}>${district}</option>`;
                });
            }
        }

        // Initial load if editing or validation failed
        if (oldState) {
            populateDistricts(oldState);
        }

        // On state change
        document.getElementById('stateSelect').addEventListener('change', function() {
            populateDistricts(this.value);
        });
    </script>
@endsection
