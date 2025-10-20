@extends('ngo.layout.master')
@section('content')
    <style>
        @page {
            size: auto;
            margin: 0;
            /* Remove all margins including top */
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
        }
    </style>
    <div class="wrapper">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Staff Work List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Staff Work</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif


            <div class="row mb-4">
                <div class="col-md-4">
                    @if ($user->user_type == 'staff')
                        <div class="card border-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title text-success fw-bold mb-2">{{ $user->name ?? 'Staff' }} ||
                                    <strong>Staff Code:</strong> {{ $user->staff->staff_code ?? 'N/A' }}
                                </h5>
                                {{-- <p class="mb-1"></p> --}}
                                <p class="mb-1"><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</p>
                                <p class="mb-0"><strong>User Type:</strong> {{ ucfirst($user->user_type) }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($user->user_type == 'ngo')
                        <div class="card border-primary mb-3">
                            <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <h5 class="card-title text-primary fw-bold mb-2">{{ $user->name }}</h5>
                                    <p class="mb-1"><strong>Email:</strong> {{ $user->email ?? 'N/A' }}</p>
                                    <p class="mb-1"><strong>User Type:</strong>
                                        Founder</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card text-center border-info">
                        <div class="card-body">
                            <h5 class="card-title text-info">Today's Logs</h5>
                            <p class="fs-4 fw-bold">{{ $todayLogs }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-center border-success">
                        <div class="card-body">
                            <h5 class="card-title text-success">Total Work Logs</h5>
                            <p class="fs-4 fw-bold">{{ $totalLogs }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('work.list') }}" class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <select name="session_filter" id="session_filter" class="form-control">
                                <option value="">All Sessions</option>
                                @foreach ($session as $s)
                                    <option value="{{ $s->session_date }}"
                                        {{ request('session_filter') == $s->session_date ? 'selected' : '' }}>
                                        {{ $s->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <input type="date" name="date_from" class="form-control"
                                value="{{ request('date_from', now()->toDateString()) }}">
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <input type="date" name="date_to" class="form-control"
                                value="{{ request('date_to', now()->toDateString()) }}">
                        </div>


                        {{-- 👇 Only visible for NGO users --}}
                        @if ($user->user_type == 'ngo')
                            <div class="col-md-3 col-sm-6">
                                <select name="user_filter" class="form-control">
                                    <option value="">All Users</option>
                                    <option value="ngo" {{ request('user_filter') == 'ngo' ? 'selected' : '' }}>NGO Logs
                                    </option>
                                    <option value="staff" {{ request('user_filter') == 'staff' ? 'selected' : '' }}>Staff
                                        Logs</option>
                                </select>
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <input type="text" name="name" class="form-control" value="{{ request('name') }}"
                                    placeholder="Search by Staff Name">
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <input type="text" name="code" class="form-control" value="{{ request('code') }}"
                                    placeholder="Search by Staff Code">
                            </div>
                        @endif

                        <div class="col-md-3 col-sm-6">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('work.list') }}" class="btn btn-info text-white w-100">Reset</a>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <button onclick="printTable()" type="button" class="btn btn-danger text-white w-100">Download
                                PDF</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm printable">
                <div class="card-body table-responsive">
                    <div class="text-center mb-4 border-bottom pb-2">
                        <!-- Header -->
                        <div class="row">
                            <div class="col-sm-2 text-center text-md-start">
                                <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80" height="80">
                            </div>
                            <div class="col-sm-10">
                                <p style="margin: 0;" class="d-flex justify-content-around"><b>
                                        <span>NEETI AYOG ID NO. UP/2023/0360430</span>&nbsp;
                                        &nbsp; &nbsp;<span>NGO NO. UP/00033062</span>&nbsp; &nbsp;
                                        &nbsp; &nbsp;<span>PAN: AAEAG7650B</span>&nbsp;
                                    </b></p>
                                <h4 class="print-h4"><b>
                                        {{-- <span data-lang="hi">ज्ञान भारती संस्था</span> --}}
                                        <span data-lang="en">GYAN BHARTI SANSTHA</span>
                                    </b></h4>
                                <h6 style="color: blue;"><b>
                                        {{-- <span data-lang="hi">ग्राम - कैंचू टांडा, पोस्ट - अमरिया, जिला - पीलीभीत, उत्तर
                                            प्रदेश -
                                            262121</span> --}}
                                        <span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District - Pilibhit,
                                            UP
                                            -
                                            262121</span>
                                    </b></h6>
                                <p style="font-size: 14px; margin: 0;">
                                    <b>
                                        <span>Website: www.gyanbhartingo.org | Email: gyanbhartingo600@gmail.com
                                            | Mob:
                                            9411484111</span>
                                    </b>
                                </p>
                            </div>
                        </div>
                    </div>

                    @if ($logs->isNotEmpty())
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-hover align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Work Date</th>
                                        <th>Work Category</th>
                                        <th>Staff Name</th>
                                        <th>Staff Code</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sr = 1; @endphp
                                    @foreach ($logs as $userLogs)
                                        @foreach ($userLogs as $log)
                                            <tr>
                                                <td>{{ $sr++ }}</td>
                                                <td>{{ \Carbon\Carbon::parse($log->work_date)->format('d-m-Y') }}</td>
                                                <td>{{ $log->model_name ?? '-' }}</td>
                                                <td>{{ $log->user_name ?? '-' }}</td>
                                                <td>{{ $log->user_code ?? '-' }}</td>
                                                <td>{{ $log->title ?? '-' }}</td>
                                                <td>{{ $log->description ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info text-center m-3">
                            No work logs found for this date.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <script>
        function printTable() {
            window.print();
        }
    </script>
@endsection
