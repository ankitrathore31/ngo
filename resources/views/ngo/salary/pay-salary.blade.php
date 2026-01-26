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
                <h5 class="mb-0">Staff</h5>
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
            <div class="container my-4">
                <div class="card p-4 shadow rounded print-card">
                    <div class="row mb-1">
                        <div class="col-sm-4 mb-3">
                            <strong>Application Date:</strong>
                            {{ \Carbon\Carbon::parse($staff->application_date)->format('d-m-Y') }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Joining Date:</strong>
                            {{ \Carbon\Carbon::parse($staff->joining_date)->format('d-m-Y') }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Session:</strong> {{ $staff->academic_session }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <strong>Position:</strong> {{ $staff->position }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Name:</strong> {{ $staff->name }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Guardian's Name:</strong> {{ $staff->gurdian_name }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Village/Locality:</strong>{{ $staff->village }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Post/Town:</strong> {{ $staff->post }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>Block:</strong> {{ $staff->block }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>District</strong> {{ $staff->district }}
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <strong>State</strong> {{ $staff->state }}
                                </div>
                                {{-- <div class="col-sm-6 mb-3">
                                    <strong>Pincode:</strong> {{ $staff->pincode }}
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            {{-- @if ($staff->image) --}}
                            <div class=" mb-3">
                                <img src="{{ asset($staff->image) }}" alt="Image" class="img-thumbnail" width="120">
                            </div>
                            {{-- @endif --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <strong>Gender:</strong> {{ $staff->gender }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Phone:</strong> {{ $staff->phone }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Email:</strong> {{ $staff->email ?? 'N/A' }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Cast:</strong> {{ $staff->caste }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Religion Category:</strong> {{ $staff->caste_category }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Religion:</strong> {{ $staff->religion }}
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="d-flex justify-content-between bg-light p-2 align-items-center my-3">
                    <h5 class="text-primary">Salary Transactions</h5>
                    <form method="GET" action="{{ route('pay.salary', $staff->id) }}">
                        <select name="year" class="form-select" onchange="this.form.submit()" style="width:auto;">
                            @for ($y = $joiningYear; $y <= $currentYear; $y++)
                                <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </form>
                </div>
                {{-- Salary Card for Selected Year --}}
                <div class="card mb-3">
                    <div class="card-header bg-light text-primary">
                        Salary Year: {{ $selectedYear }}
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Total Salary</th>
                                    <th>Paid</th>
                                    <th>Remaining</th>
                                    <th>Status</th>
                                    <th>Payments</th>
                                    <th class="no-print">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($yearTransactions as $t)
                                    @php
                                        $paidAmount = $t->payments->sum('amount'); // all payments
                                        $remaining = $t->amount - $paidAmount;
                                    @endphp
                                    <tr>
                                        <td>{{ $t->year }}</td>
                                        <td>{{ \Carbon\Carbon::create()->month($t->month)->format('F') }}</td>
                                        <td>{{ $t->amount }}</td>
                                        <td>{{ $paidAmount }}</td>
                                        <td>{{ $remaining }}</td>
                                        <td>
                                            @if ($t->status == 'paid')
                                                <span class="badge bg-success">Paid</span>
                                            @elseif ($t->status == 'partial')
                                                <span class="badge bg-warning text-dark">Partial</span>
                                            @else
                                                <span class="badge bg-danger">Unpaid</span>
                                            @endif
                                        </td>

                                        <!-- Show all payment rows -->
                                        <td>
                                            @if ($t->payments->count() > 0)
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($t->payments as $p)
                                                        <li>
                                                            {{ $p->payment_date }} -
                                                            {{ ucfirst($p->payment_mode) }} -
                                                            <strong>{{ $p->amount }}</strong>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <em>No payments yet</em>
                                            @endif
                                        </td>

                                        <td class="no-print">
                                            @if ($remaining > 0)
                                                <!-- Pay button -->
                                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#payModal{{ $t->id }}">
                                                    Pay
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="payModal{{ $t->id }}" tabindex="-1">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <form action="{{ route('store.salary.payment', $staff->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="year"
                                                                    value="{{ $t->year }}">
                                                                <input type="hidden" name="month"
                                                                    value="{{ $t->month }}">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Pay Salary -
                                                                        {{ \Carbon\Carbon::create()->month($t->month)->format('F') }}
                                                                        {{ $t->year }}
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label>Total Salary</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $t->amount }}" readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Paid So Far</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $paidAmount }}" readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Remaining Balance</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $remaining }}" readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Amount to Pay Now</label>
                                                                        <input type="number" class="form-control"
                                                                            name="amount" max="{{ $remaining }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Payment Date</label>
                                                                        <input type="date" class="form-control"
                                                                            name="payment_date" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Payment Mode</label>
                                                                        <select name="payment_mode"
                                                                            class="form-control payment-mode" required>
                                                                            <option value="">-- Select --</option>
                                                                            <option value="cash">Cash</option>
                                                                            <option value="bank">Bank</option>
                                                                            <option value="cheque">Cheque</option>
                                                                            <option value="upi">UPI</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-3 mode-fields"></div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">Submit
                                                                        Payment</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($t->status != 'unpaid')
                                                <!-- Unpay button -->
                                                <form action="{{ route('unpaid.salary', $t->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit"
                                                        onclick="return confirm('Do you want to unpay salary?')"
                                                        class="btn btn-sm btn-danger">Unpay</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No salary records for this year.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('change', function(e) {
            if (!e.target.classList.contains('payment-mode')) return;

            const select = e.target;
            const modalBody = select.closest('.modal-body');
            const container = modalBody.querySelector('.mode-fields');

            container.innerHTML = '';

            if (select.value === 'bank') {
                container.innerHTML = `
            <div class="mb-3">
                <label>Bank Name</label>
                <input type="text" name="bank_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Bank No.</label>
                <input type="text" name="bank_no" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>IFSC Code</label>
                <input type="text" name="ifsc_code" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Transaction ID</label>
                <input type="text" name="transaction_id" class="form-control" required>
            </div>
        `;
            }

            if (select.value === 'cheque') {
                container.innerHTML = `
            <div class="mb-3">
                <label>Cheque No</label>
                <input type="text" name="cheque_no" class="form-control" required>
            </div>
        `;
            }

            if (select.value === 'upi') {
                container.innerHTML = `
            <div class="mb-3">
                <label>UPI ID</label>
                <input type="text" name="upi_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Transaction ID</label>
                <input type="text" name="transaction_id" class="form-control" required>
            </div>
        `;
            }
        });
    </script>

@endsection
