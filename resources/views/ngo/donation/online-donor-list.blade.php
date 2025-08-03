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
                <h5 class="mb-0">Online Donation List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Donor List</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('online-donor-list') }}" class="row g-3 mb-4">
                        <div class="col-md-4">
                            {{-- <label for="session_filter" class="form-label">Select Session</label> --}}
                            <select name="session_filter" id="session_filter" class="form-control"
                                onchange="this.form.submit()">
                                <option value="">All Sessions</option> <!-- Default option to show all -->
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 d-flex">
                            <button type="submit" class="btn btn-primary me-2">Search</button>
                            <a href="{{ route('online-donor-list') }}" class="btn btn-info text-white me-2">Reset</a>
                        </div>
                    </form>
                    <button onclick="printTable()" class="btn btn-primary mb-3">Print Table</button>

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
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                {{-- <th>Order ID</th> --}}
                                <th>Name</th>
                                <th>Address</th>
                                <th>Identity No.</th>
                                <th>Identity Type</th>
                                <th>Mobile no.</th>
                                <th>Email</th>
                                <th>Donation Category</th>
                                <th>Donation Amount</th>
                                <th>Donate Date</th>
                                <th>Status</th>
                                <th>Remark</th>
                                {{-- <th>Session</th> --}}
                                <th class="no-print">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($donor as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    {{-- <td>{{ $item->order_id }}</td> --}}
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->address }}
                                        {{ $item->block }}
                                        {{ $item->district }}
                                        {{ $item->state }} - {{ $item->donor_pincode }}
                                    </td>
                                    <td>{{ $item->donor_aadhar }} {{ $item->donor_pancard }}</td>
                                    <td>{{ $item->id_type }}</td>
                                    <td>{{ $item->mobile }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->donation_category ?? 'No Found' }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>
                                        {{ $item->date ? \Carbon\Carbon::parse($item->date)->format('d-m-Y') : 'No Found' }}
                                    </td>
                                    <td>{{ $item->status }} </td>
                                    <td>{{ $item->donation_remark }}</td>
                                    {{-- <td>{{ $survey->academic_session }}</td> --}}
                                    <td class="no-print">
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ route('view-donation', $item->id) }}"
                                                class="btn btn-success btn-sm " title="View">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
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
