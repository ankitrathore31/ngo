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

        .printable {
            font-family: "Times New Roman", serif;
            font-size: 18px;
            color: #000;
        }

        hr {
            border-top: 1px solid #000;
            margin: 4px 0;
        }

        @media print {
            .container {
                max-width: 100%;
            }
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
                <h5 class="mb-0">Income & Expenditure</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cash Book</li>
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
                    <div class="col-md-12">
                        <!-- Search Year Form (Single Year) -->
                        <form method="GET" action="{{ route('income.expenditure.view') }}" class="mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Search by Year:</label>
                                    <select name="year" class="form-control" onchange="this.form.submit()">
                                        @for ($y = now()->year; $y >= 2000; $y--)
                                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                                {{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <a href="{{ route('income.expenditure.view') }}" class="btn btn-sm btn-primary mt-4">Refresh</a>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
                <button type="button" onclick="printTable()" class="btn btn-primary mb-2">Print </button>
            </div>
            <div class="container">
                <div class="card shadow-sm printable">
                    <div class="card-body table-responsive">
                        <div class="text-center mb-4 border-bottom pb-2">
                            <!-- Header -->
                            <div class="row">
                                <div class="col-sm-2 text-center text-md-start">
                                    <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="100" height="100">
                                </div>
                                <div class="col-sm-10">
                                    <p style="margin: 0;" class="d-flex justify-content-around"><b>
                                            <span>NEETI AYOG ID NO. UP/2023/0360430</span>&nbsp;
                                            &nbsp; &nbsp;<span>NGO NO. UP/00033062</span>&nbsp; &nbsp;
                                            &nbsp; &nbsp;<span>PAN: AAEAG7650B</span>&nbsp;
                                        </b></p>
                                    <h4 class="print-h4"><b>
                                            <span data-lang="en">GYAN BHARTI SANSTHA</span>
                                        </b></h4>
                                    <h6 style="color: blue;"><b>
                                            <span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District -
                                                Pilibhit,
                                                UP
                                                -
                                                262121</span>
                                        </b></h6>
                                    {{-- <p style="font-size: 14px; margin: 0;">
                                        <b>
                                            <span>Website: www.gyanbhartingo.org | Email: gyanbhartingo600@gmail.com
                                                | Mob:
                                                9411484111</span>
                                        </b>
                                    </p> --}}
                                    <p style="font-size: 14px; margin: 0;">
                                        <b>
                                            Receipt And Payment Account For The Year Ended On {{ $year }}
                                        </b>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="container printable my-4">
                            <div class="border p-3">

                                <hr class="my-2">

                                {{-- ================= TITLES ================= --}}
                                <div class="row fw-bold text-uppercase text-center small mb-1">
                                    <div class="col-md-6">Total Income</div>
                                    <div class="col-md-6 ">Total Expenditure</div>
                                </div>

                                <hr class="my-1">

                                {{-- ================= COLUMN HEADERS ================= --}}
                                <div class="row fw-bold small text-muted mb-1">
                                    <div class="col-md-4">Particulars</div>
                                    <div class="col-md-2 text-end">Amount</div>

                                    <div class="col-md-4">Particulars</div>
                                    <div class="col-md-2 text-end">Amount</div>
                                </div>

                                <hr class="my-1">

                                {{-- ================= BODY ================= --}}
                                @php
                                    $receipts = [];

                                    foreach ($offlineIncome as $row) {
                                        $receipts[] = [
                                            'name' => $row->amountType,
                                            'amount' => $row->total,
                                        ];
                                    }

                                    if (!empty($onlineTotal)) {
                                        $receipts[] = [
                                            'name' => 'Online Donation',
                                            'amount' => $onlineTotal,
                                        ];
                                    }

                                    $payments = [];
                                    foreach ($expenseSummary as $cat => $amt) {
                                        $payments[] = [
                                            'name' => $cat,
                                            'amount' => $amt,
                                        ];
                                    }

                                    $maxRows = max(count($receipts), count($payments));
                                @endphp

                                @for ($i = 0; $i < $maxRows; $i++)
                                    <div class="row py-1 small">
                                        {{-- RECEIPT --}}
                                        <div class="col-md-4">
                                            {{ $receipts[$i]['name'] ?? '' }}
                                        </div>
                                        <div class="col-md-2 text-end">
                                            {{ isset($receipts[$i]) ? number_format($receipts[$i]['amount'], 2) : '' }}
                                        </div>

                                        {{-- PAYMENT --}}
                                        <div class="col-md-4">
                                            {{ $payments[$i]['name'] ?? '' }}
                                        </div>
                                        <div class="col-md-2 text-end">
                                            {{ isset($payments[$i]) ? number_format($payments[$i]['amount'], 2) : '' }}
                                        </div>
                                    </div>
                                @endfor

                                <hr>

                                {{-- ================= TOTAL ================= --}}
                                <div class="row fw-bold small">
                                    <div class="col-md-4 text-end">Total</div>
                                    <div class="col-md-2 text-end">
                                        {{ number_format($grandTotalIncome, 2) }}
                                    </div>

                                    <div class="col-md-4 text-end">Total</div>
                                    <div class="col-md-2 text-end">
                                        {{ number_format($grandTotalExpense, 2) }}
                                    </div>
                                </div>

                                <hr>

                                {{-- ================= CLOSING BALANCE ================= --}}
                                <div class="row fw-bold small">
                                    <div class="col-md-4">Total Remaining Balance</div>
                                    <div class="col-md-2 text-end">
                                        {{ number_format($grandTotalIncome - $grandTotalExpense, 2) }}
                                    </div>
                                </div>

                            </div>
                        </div>

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
