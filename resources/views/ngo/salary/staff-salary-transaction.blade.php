@extends('ngo.layout.master')
@Section('content')
    <style>
        /* Reset print layout */
        .print-red-bg {
            background-color: red !important;
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
                margin: 4mm;
                /* smaller margins so receipt looks bigger */
            }

            body * {
                visibility: hidden;
            }

            .receipt-card,
            .receipt-card * {
                visibility: visible;
            }

            .btn,
            .navbar,
            .footer,
            .no-print {
                display: none !important;
            }

            /* Print layout */
            .receipt-card {
                width: 95%;
                /* take almost full page width */
                max-width: 19cm;
                /* A4 width safe zone */
                margin: 0 auto;
                /* center on page */
                border: 1px solid #000;
                page-break-inside: avoid;
            }

            .print-red-bg {
                background-color: red !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                font-size: 18px;
                padding: 4px 8px;
                text-align: center;
            }

            .print-h4 {
                background-color: red !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                font-size: 28px;
                word-spacing: 8px;
                text-align: center;
                padding: 6px 10px;
            }
        }

        /* Screen view */
        .receipt-card {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            background: #fff;
        }
    </style>

    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Staff Salary Tranctions</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-staff"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-staff active" aria-current="page">&nbsp; Salary</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="container my-4">
                @foreach ($transactions as $t)
                    @foreach ($t->payments as $p)
                        <div class="receipt-card border shadow p-3 mb-4 bg-white" id="receipt-{{ $p->id }}">
                            <div class="text-center mb-4 border-bottom pb-2">
                                <div class="row">
                                    <div class="col-sm-2 text-center text-md-start">
                                        <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80"
                                            height="80">
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

                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <strong>Staff Name:</strong> {{ $staff->name }} <br>
                                    <strong>Position:</strong> {{ $staff->position }} <br>
                                    <strong>Guardian:</strong> {{ $staff->gurdian_name }}
                                </div>
                                <div class="col-sm-6 text-end">
                                    <strong>Receipt No:</strong> RCP-{{ $p->id }} <br>
                                    <strong>Payment Date:</strong>
                                    {{ \Carbon\Carbon::parse($p->payment_date)->format('d-m-Y') }} <br>
                                    <strong>Month/Year:</strong>
                                    {{ \Carbon\Carbon::create()->month($t->month)->format('F') }}
                                    {{ $t->year }}
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Amount</th>
                                        <th>Payment Mode</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>₹ {{ number_format($p->amount, 2) }}</b></td>
                                        <td>{{ ucfirst($p->payment_mode) }}</td>
                                        <td>
                                            @if ($p->payment_mode == 'cash')
                                                Paid in Cash
                                            @elseif($p->payment_mode == 'bank')
                                                Bank: {{ $p->bank_name }} <br>
                                                IFSC: {{ $p->ifsc_code }} <br>
                                                Txn ID: {{ $p->transaction_id }}
                                            @elseif($p->payment_mode == 'cheque')
                                                Cheque No: {{ $p->cheque_no }}
                                            @elseif($p->payment_mode == 'upi')
                                                UPI ID: {{ $p->upi_id }} <br>
                                                Txn ID: {{ $p->transaction_id }}
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            {{-- Signature --}}
                            <div class="text-end mt-3">
                                @if (!empty($signatures['director']) && file_exists(public_path($signatures['director'])))
                                    <div id="directorSignatureBox" class="mt-2">
                                        <p class="text-success no-print">Attached</p>
                                        <img src="{{ asset($signatures['director']) }}" alt="Director Signature"
                                            class="img" style="max-height: 80px;">
                                    </div>
                                @else
                                    <p class="text-muted mt-2 no-print">Not attached</p>
                                @endif
                                <strong class="text-danger">Digitally Signed By <br>
                                    MANOJ KUMAR RATHOR <br>
                                    DIRECTOR
                                </strong><br>
                            </div>

                            <div class="text-center mt-3 no-print">
                                <button onclick="window.print()" class="btn btn-primary no-print">
                                    Print Receipt
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endforeach


            </div>
        </div>
    </div>
    <script>
        function togglePM(show) {
            document.getElementById('pmSignatureBox').classList.toggle('d-none', !show);
            document.getElementById('pmShowBtnBox').classList.toggle('d-none', show);
        }

        function toggleDirector(show) {
            document.getElementById('directorSignatureBox').classList.toggle('d-none', !show);
            document.getElementById('directorShowBtnBox').classList.toggle('d-none', show);
        }
    </script>
@endsection
