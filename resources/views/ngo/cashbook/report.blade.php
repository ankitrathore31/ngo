@extends('ngo.layout.master')
@Section('content')
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
                /* Keeps header on each page */
            }

            tfoot {
                display: table-row-group;
                /* Shows only at the end, not on every page */
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
                <h5 class="mb-0">Report List</h5>
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
                    <div class="col-md-6">
                        <!-- Generate Report Form (Separate Year) -->
                        <form method="GET" action="{{ route('balance.report.generate') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Generate Report for Year:</label>
                                    <select name="year" class="form-control">
                                        @for ($y = now()->year; $y >= 2000; $y--)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-4 align-self-end">
                                    <button type="submit" class="btn btn-primary">Generate Report</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <!-- Search Year Form (Single Year) -->
                        <form method="GET" action="{{ route('balance.report.view') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Search Report by Year:</label>
                                    <select name="year" class="form-control" onchange="this.form.submit()">
                                        @for ($y = now()->year; $y >= 2000; $y--)
                                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                                {{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <button type="button" onclick="printTable()" class="btn btn-primary mb-2">Print Table</button>
            </div>
            <div class="container">
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
                                            <span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District -
                                                Pilibhit,
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
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Total Income</th>
                                    <th>Total Expenditure Cost</th>
                                    <th>Remaining Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $report)
                                    <tr>
                                        <td>  {{ $year }}</td>
                                        <td>{{ \Carbon\Carbon::create()->month($report->month)->format('F') }}</td>
                                        <td>₹{{ number_format($report->total_income, 2) }}</td>
                                        <td>₹{{ number_format($report->total_expenditure, 2) }}</td>
                                        <td>₹{{ number_format($report->remaining_amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
