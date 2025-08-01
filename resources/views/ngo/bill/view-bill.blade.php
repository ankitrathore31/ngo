@extends('ngo.layout.master')
@section('content')
    <style>
        .bill-container {
            background-color: white;
        }

        /* Force consistent font scaling on screen */
        body {
            background: #f2f2f2;
            font-size: 14px;
            line-height: 1.4;
        }

        /* PRINT STYLES */
        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }

            body {
                background: white !important;
            }

            body * {
                visibility: hidden;
            }

            .bill-container,
            .bill-container * {
                visibility: visible;
            }

            .bill-container {
                margin: 0;
                padding: 20mm;
                width: 250mm;
                min-height: auto;
                box-shadow: none;
                position: absolute;
                left: 0;
                top: 0;
            }

            .print-red-bg {
                background-color: red !important;
                /* Bootstrap 'bg-danger' color */
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: white !important;
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

            .no-print {
                display: none !important;
            }
        }

        .print-red-bg {
            background-color: red !important;
            /* Bootstrap 'bg-danger' color */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color: white !important;
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
    </style>
    <div class="wrapper">
        <div class="d-flex justify-content-between align-item-centre mb-0 mt-4">
            <h5 class="mb-0">View Bill</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Bill/Voucher</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                <h5 class="mb-0">
                    <span>Bill</span>
                </h5>
                <div>
                    <button onclick="window.print()" class="btn btn-primary">Print Bill</button>
                    <button class="btn btn-sm btn-outline-primary" onclick="setLanguage('en')">English</button>
                    <button class="btn btn-sm btn-outline-success" onclick="setLanguage('hi')">हिंदी</button>
                </div>
            </div>
            <div class="bill-container border print-area">
                <div class="p-4">

                    <div class="text-center mb-4 border-bottom pb-3 mb-2">
                        <!-- Header -->
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="d-flex justify-content-between w-100 mb-1" style="margin: 0; font-weight: bold;">
                                    <span>GST NO. {{ $bill->gst }}</span>
                                    <span>{{ $bill->role }}: &nbsp; {{ $bill->s_name }}</span>
                                    <span>Phone: {{ $bill->s_mobile }}</span>
                                </p>

                                <h4 class="text-center print-h4" style="margin: 0;">
                                    <span style="font-size: inherit; font-weight: inherit;">{{ $bill->shop }}</span>
                                </h4>

                                <h6 class="w-100" style="color: blue; font-weight: bold; margin: 0;">
                                    <span>{{ $bill->s_address }}</span>
                                </h6>

                                <p class="w-100" style="font-size: 14px; margin: 0; font-weight: bold;">
                                    @if (!empty($bill->s_email))
                                        | Email: {{ $bill->s_email }}
                                    @endif

                                    @if (!empty($bill->s_pan))
                                        | Pan Card: {{ $bill->s_pan }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid py-4" style="font-size: 16px; line-height: 1.8;">
                        <div class=" d-flex justify-content-between mb-3">
                            <div>
                                <strong>
                                    <span>Bill/Voucher/Invoice No.:</span>
                                </strong>
                                {{ $bill->bill_no }}
                            </div>

                            <div>
                                <strong>
                                    <span>Date:</span>
                                </strong>
                                {{ \Carbon\Carbon::parse($bill->date)->format('d-m-Y') }}
                            </div>

                            <div>
                                <strong>
                                    <span>Session:</span>
                                </strong>
                                {{ $bill->academic_session }}
                            </div>
                        </div>
                        <div class="row mb-2">
                            {{-- <h5><strong>- SELLER DETAILS</strong></h5> --}}
                            <div class="col-sm-12">
                                <b>{{ $bill->role }}</b>: &nbsp;{{ $bill->s_name }}
                            </div>
                            {{-- <div class="col-sm-12">
                                <b>Mobile:</b> &nbsp; {{ $bill->s_mobile }}
                            </div>
                            <div class="col-sm-12">
                                <b>Email:</b> &nbsp; {{ $bill->s_email }}
                            </div> --}}
                            <div class="col-sm-12">
                                <b>Shop/Farm:</b> &nbsp; {{ $bill->shop }}
                            </div>
                            {{-- <div class="col-sm-12">
                                <b>Address:</b> &nbsp; {{ $bill->s_address }}
                            </div> --}}
                        </div>

                        <div class="row mb-2">
                            <h5><strong>- BUYER DETAILS</strong></h5>
                            <div class="col-sm-12">
                                <b>Name:</b> &nbsp; {{ $bill->b_name }}
                            </div>
                            <div class="col-sm-12">
                                <b>Mobile:</b> &nbsp; {{ $bill->b_mobile }}
                            </div>
                            <div class="col-sm-12">
                                <b>Email:</b> &nbsp; {{ $bill->b_email }}
                            </div>
                            <div class="col-sm-12">
                                <b>Address:</b> &nbsp; {{ $bill->b_address }}
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-12">
                                <div class="">
                                    <div class="card-body table-responsive">
                                        <table class="table table-bordered table-hover align-middle text-center">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>Sr. No.</th>
                                                    <th>Product</th>
                                                    <th>Quntity</th>
                                                    <th>Rate</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $totalAmount = 0;
                                                @endphp

                                                @foreach ($bill_items as $item)
                                                    @php
                                                        $amount = $item->qty * $item->rate;
                                                        $totalAmount += $amount;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->product }}</td>
                                                        <td>{{ $item->qty }}</td>
                                                        <td>{{ number_format($item->rate, 2) }}</td>
                                                        <td>{{ number_format($amount, 2) }}</td>
                                                    </tr>
                                                @endforeach

                                                @php
                                                    $cgst = $bill->cgst ?? 0;
                                                    $sgst = $bill->sgst ?? 0;
                                                    $igst = $bill->igst ?? 0;

                                                    $cgstAmount = ($totalAmount * $cgst) / 100;
                                                    $sgstAmount = ($totalAmount * $sgst) / 100;
                                                    $igstAmount = $cgstAmount + $sgstAmount;

                                                    $grandTotal =
                                                        $totalAmount + $cgstAmount + $sgstAmount;
                                                @endphp

                                                <tr class="table-secondary fw-bold">
                                                    <td colspan="4" class="text-end">Total Amount</td>
                                                    <td>{{ number_format($totalAmount, 2) }}</td>
                                                </tr>
                                                @if ($cgst > 0)
                                                    <tr>
                                                        <td colspan="4" class="text-end">CGST ({{ $cgst }}%)
                                                        </td>
                                                        <td>{{ number_format($cgstAmount, 2) }}</td>
                                                    </tr>
                                                @endif
                                                @if ($sgst > 0)
                                                    <tr>
                                                        <td colspan="4" class="text-end">SGST ({{ $sgst }}%)
                                                        </td>
                                                        <td>{{ number_format($sgstAmount, 2) }}</td>
                                                    </tr>
                                                @endif
                                                @if ($igst > 0)
                                                    <tr>
                                                        <td colspan="4" class="text-end">IGST ({{ $igst }}%)
                                                        </td>
                                                        <td>{{ number_format($igstAmount, 2) }}</td>
                                                    </tr>
                                                @endif
                                                <tr class="table-dark fw-bold">
                                                    <td colspan="4" class="text-end">Grand Total</td>
                                                    <td>{{ number_format($grandTotal, 2) }}</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between mt-5">
                            <div class="col-sm-5 text-start">
                                <dl class="row">
                                    <dt class="col-sm-4">Account No:</dt>
                                    <dd class="col-sm-8"></dd>

                                    <dt class="col-sm-4">Bank Name:</dt>
                                    <dd class="col-sm-8">Bank Of Baroda</dd>

                                    <dt class="col-sm-4">Branch:</dt>
                                    <dd class="col-sm-8">Ameria</dd>

                                    <dt class="col-sm-4">IFSC Code:</dt>
                                    <dd class="col-sm-8">BARB0AMERIA</dd>
                                </dl>
                            </div>
                            <div class="col-sm-5 text-center">
                                {{-- @if (!empty($signatures['director']) && file_exists(public_path($signatures['director'])))
                                    <div id="directorSignatureBox" class="mt-2">
                                        <p class="text-success no-print">Attached</p>
                                        <img src="{{ asset($signatures['director']) }}" alt="Director Signature"
                                            class="img" style="max-height: 100px;">
                                        <br>
                                        <button class="btn btn-danger btn-sm mt-2 no-print"
                                            onclick="toggleDirector(false)">Remove</button>
                                    </div>

                                    <div id="directorShowBtnBox" class="mt-2 d-none no-print">
                                        <button class="btn btn-primary btn-sm" onclick="toggleDirector(true)">Attached
                                            Signature</button>
                                    </div>
                                @else
                                    <p class="text-muted mt-2 no-print">Not attached</p>
                                @endif --}}
                                {{ $bill->s_name }}<br>
                                <strong>Signature
                                </strong>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        function setLanguage(lang) {
            document.querySelectorAll('[data-lang]').forEach(el => {
                el.style.display = el.getAttribute('data-lang') === lang ? 'inline' : 'none';
            });
        }
        window.onload = () => setLanguage('en'); // Set Eng as default
    </script>
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
