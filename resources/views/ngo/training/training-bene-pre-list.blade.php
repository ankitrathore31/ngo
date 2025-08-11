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

        .days-grid {
            display: grid;
            grid-template-columns: repeat(10, 1fr);
            /* 10 days per row */
            gap: 4px;
            justify-items: center;
        }

        .day-column {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .day-label {
            font-size: 10px;
            margin-bottom: 2px;
        }

        .day-box {
            width: 20px;
            height: 20px;
            border: 1px solid #000;
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
                <h5 class="mb-0">Training Beneficiarie Present List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Approve Beneficiaries </li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <button onclick="printTable()" class="btn btn-primary mb-3">Print Table</button>
            <form method="GET">
                <label for="days">Number of Days:</label>
                <input type="number" name="days" id="days" value="{{ request('days', 40) }}" min="1"
                    max="370">
                <button type="submit">Generate</button>
            </form>
            <div class="card shadow-sm printable">
                <div class="card-body table-responsive">
                    <div class="text-center mb-4 border-bottom pb-3 mb-2">
                        <!-- Header -->
                        <div class="row">
                            <div class="col-sm-2 text-center text-md-start">
                                <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="120" height="120">
                            </div>
                            <div class="col-sm-10">
                                <p style="margin: 0;" class="d-flex justify-content-around"><b>
                                        <span>CSR NO. CSR00059991</span>&nbsp;
                                        &nbsp; &nbsp;<span>12A AAEAG7650BE20231</span>&nbsp; &nbsp;
                                        &nbsp; &nbsp;<span>80G AAEAG7650BF20231</span>&nbsp;
                                    </b></p>
                                <p style="margin: 0;" class="d-flex justify-content-around"><b>
                                        <span>NEETI AYOG ID NO. UP/2023/0360430</span>&nbsp;
                                        &nbsp; &nbsp;<span>NGO NO. UP/00033062</span>&nbsp; &nbsp;
                                        &nbsp; &nbsp;<span>PAN: AAEAG7650B</span>&nbsp;
                                    </b></p>
                                <h4 class="print-h4"><b>
                                        <span>GYAN BHARTI SANSTHA</span>
                                    </b></h4>
                                <h6 style="color: blue;"><b>
                                        <span>Village - Kainchu Tanda, Post - Amaria, District - Pilibhit, UP
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
                    <div class="row card-body shadow mb-5">
                        <div class="col-sm-4 mb-2">
                            <b>Training Center Code:</b> {{ $center->center_code }}
                        </div>
                        <div class="col-sm-4 mb-2">
                            <b>Training Cenetr Name:</b> {{ $center->center_name }}
                        </div>
                        <div class="col-sm-4 mb-2">
                            <b>Training Session:</b> {{ $center->academic_session }}
                        </div>
                        <div class="col-sm-12 mb-2">
                            <b>Training Center Address:
                            </b>{{ $center->center_address }},{{ $center->post }},{{ $center->town }}
                            ,{{ $center->district }},{{ $center->state }}
                        </div>
                        <div class="col-sm-8 mb-3">
                            <b>Center Incharge/Master Trainer: </b>
                            {{ \App\Models\Staff::find($center->incharge)->name ?? '' }}
                        </div>
                        <div class="col-sm-5">
                            <b>Training Start Date</b>
                        </div>
                        <div class="col-sm-2">
                            <b>To</b>
                        </div>
                        <div class="col-sm-5">
                            <b>Training End Date</b>
                        </div>
                    </div>
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Registration No.</th>
                                <th>Learner Name</th>
                                <th>Father/Husband Name</th>
                                <th>Mother Name</th>
                                <th>Learner Address</th>
                                <th>Mobile No.</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Present Date/Days</th>
                                <th>Total Days</th>
                                <th>Total Present</th>
                                <th>Total Absent</th>
                                <th>Learner Signature</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($record as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->beneficiare->registration_no ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->name ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->gurdian_name ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->mother_name ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->village ?? '' }},
                                        {{ $item->beneficiare->post ?? '' }},
                                        {{ $item->beneficiare->block ?? '' }},
                                        {{ $item->beneficiare->district ?? '' }},
                                        {{ $item->beneficiare->state ?? '' }} - {{ $item->beneficiare->pincode ?? '' }}
                                    </td>
                                    <td>{{ $item->beneficiare->phone ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->caste ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->religion_category ?? 'N/A' }}</td>
                                    {{-- <td>{{ $item->beneficiare->religion ?? 'N/A' }}</td> --}}
                                    {{-- <td>{{ $item->beneficiare->academic_session ?? 'N/A' }}</td> --}}
                                    <td>
                                        <div class="days-grid">
                                            @for ($i = 1; $i <= request('days', 40); $i++)
                                                <div class="day-column">
                                                    <div class="day-label">{{ $i }}</div>
                                                    <div class="day-box"></div>
                                                </div>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>{{ request('days', 40) }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
