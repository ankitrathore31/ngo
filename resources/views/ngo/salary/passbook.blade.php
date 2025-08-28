@extends('ngo.layout.master')
@Section('content')
    <style>
        /* Reset print layout */

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
            @page {
                size: A4;
                margin: 1cm;
            }

            body * {
                visibility: hidden;
            }

            .print-card,
            .print-card * {
                visibility: visible;
            }

            .btn,
            .navbar,
            .footer,
            .no-print {
                display: none !important;
            }

            .print-card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                font-family: 'Arial', sans-serif;
                font-size: 12pt;
                color: #000;
                background: #fff;
            }

            img {
                max-width: 100px !important;
                height: auto !important;
            }

            h4,
            h6 {
                margin: 0;
                padding: 0;
            }

            .print-card .row {
                margin-bottom: 5px;
            }

            strong {
                font-weight: 600;
            }

            .mb-3,
            .mb-4,
            .mb-5 {
                margin-bottom: 10px !important;
            }

            .shadow,
            .rounded {
                box-shadow: none !important;
                border-radius: 0 !important;
            }

            .card {
                border: none;
                padding: 0;
            }

            .border-bottom {
                border-bottom: 1px solid #000 !important;
            }

            a[href]:after {
                content: "";
            }

            .img-thumbnail {
                border: 1px solid #999;
            }

            .text-center,
            .text-md-start {
                text-align: center !important;
            }

            label.from-label {
                font-weight: bold;
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
                <h5 class="mb-0">Staff Passbook</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-staff"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-staff active" aria-current="page">&nbsp; Staff</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row d-flex justify-content-center mb-5">
                <div class="col-sm-6">
                    <form method="GET" class="mb-3">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <select name="year" class="form-control" onchange="this.form.submit()">
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-6">
                    <button class="btn btn-primary " onclick="window.print()">Print</button>
                </div>
            </div>
            <div class="container mb-5 mt-5">
                <div class="card-body shadow-sm print-card">
                    <div class="text-center mb-4 border-bottom pb-2">
                        <div class="row">
                            <div class="col-sm-2 text-center text-md-start">
                                <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="120" height="120">
                            </div>
                            <div class="col-sm-10">
                                <p style="margin: 0;" class="d-flex justify-content-around"><b>
                                        <span>NEETI AYOG ID NO. UP/2023/0360430</span>&nbsp;&nbsp;
                                        <span>NGO NO. UP/00033062</span>&nbsp;&nbsp;
                                        <span>PAN: AAEAG7650B</span>
                                    </b></p>
                                <h4 class="print-h4"><b>GYAN BHARTI SANSTHA</b></h4>
                                <h6 style="color: blue;"><b>
                                        Village - Kainchu Tanda, Post - Amaria, District - Pilibhit, UP - 262121
                                    </b></h6>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-6 mb-2"><strong>Position:</strong> {{ $staff->position }}</div>
                                <div class="col-sm-6 mb-2"><strong>Name:</strong> {{ $staff->name }}</div>
                                <div class="col-sm-6 mb-2"><strong>Guardian:</strong> {{ $staff->gurdian_name }}</div>
                                <div class="col-sm-6 mb-2"><strong>Village:</strong> {{ $staff->village }}</div>
                                <div class="col-sm-6 mb-2"><strong>Post:</strong> {{ $staff->post }}</div>
                                <div class="col-sm-6 mb-2"><strong>Block:</strong> {{ $staff->block }}</div>
                                <div class="col-sm-6 mb-2"><strong>District:</strong> {{ $staff->district }}</div>
                                <div class="col-sm-6 mb-2"><strong>State:</strong> {{ $staff->state }}</div>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center">
                            <img src="{{ asset($staff->image) }}" alt="Image" class="img-thumbnail" width="120">
                        </div>
                    </div>
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>Date</th>
                                <th>Month</th>
                                <th>Payment Mode</th>
                                <th>Txn Details</th>
                                <th>Amount (₹)</th>
                                <th class="no-print">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($yearTransactions as $t)
                                @foreach ($t->payments as $p)
                                    <tr>
                                        <td class="text-center">
                                            {{ $p->payment_date ? \Carbon\Carbon::parse($p->payment_date)->format('d M Y') : '-' }}
                                        </td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::create()->month($t->month)->format('F') }}
                                            {{ $t->year }}
                                        </td>
                                        <td class="text-center">{{ ucfirst($p->payment_mode) }}</td>
                                        <td>
                                            @if ($p->payment_mode == 'bank')
                                                Bank: {{ $p->bank_name }} | IFSC: {{ $p->ifsc_code }} | Txn ID:
                                                {{ $p->transaction_id }}
                                            @elseif ($p->payment_mode == 'cheque')
                                                Cheque No: {{ $p->cheque_no }}
                                            @elseif ($p->payment_mode == 'upi')
                                                UPI ID: {{ $p->upi_id }} | Txn ID: {{ $p->transaction_id }}
                                            @else
                                                Paid in Cash
                                            @endif
                                        </td>
                                        <td class="text-end"><b>{{ number_format($p->amount, 2) }}</b></td>
                                        <td class="text-center no-print">
                                            @if ($t->status == 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif($t->status == 'partial')
                                                <span class="badge bg-warning text-dark">Partial</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No paid salary transactions found for this year.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="4" class="text-end">Total Salary:</td>
                                <td class="text-end">₹ {{ number_format($totalAmount, 2) }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end">Total Paid:</td>
                                <td class="text-end text-success">₹ {{ number_format($totalPaid, 2) }}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end">Remaining Balance:</td>
                                <td class="text-end text-danger">₹ {{ number_format($remaining, 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
