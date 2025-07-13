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
            <h5 class="mb-0">View Work Plan</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Work Plan</li>
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
                    <span>Work Plan</span>
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
                            <div class="col-sm-2 text-center text-md-start">
                                <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80" height="80">
                            </div>
                            <div class="col-sm-10">
                                <p class="d-flex justify-content-between w-100" style="margin: 0; font-weight: bold;">
                                    <span>CSR NO. CSR00059991</span>
                                    <span>12A AAEAG7650BE20231</span>
                                    <span>80G AAEAG7650BF20231</span>
                                </p>

                                <p class="d-flex justify-content-between w-100" style="margin: 0; font-weight: bold;">
                                    <span>NEETI AYOG ID NO. UP/2023/0360430</span>
                                    <span>NGO NO. UP/00033062</span>
                                    <span>PAN: AAEAG7650B</span>
                                </p>

                                <h4 class="text-center print-h4" style="margin: 0;">
                                    <span data-lang="hi" style="font-size: inherit; font-weight: inherit;">ज्ञान भारती
                                        संस्था</span>
                                    <span style="font-size: inherit; font-weight: inherit;">GYAN BHARTI SANSTHA</span>
                                </h4>

                                <h6 style="color: blue;"><b>
                                        <span data-lang="hi">ग्राम - कैंचू टांडा, पोस्ट - अमरिया, जिला - पीलीभीत, उत्तर
                                            प्रदेश -
                                            262121</span>
                                        <span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District - Pilibhit, UP
                                            -
                                            262121</span>
                                    </b></h6>

                                <p class="w-100" style="font-size: 14px; margin: 0; font-weight: bold;">
                                    Website: www.gyanbhartingo.org | Email: gyanbhartingo600@gmail.com | Mob: 9411484111
                                </p>
                            </div>

                        </div>
                    </div>
                    <div class="container-fluid py-4" style="font-size: 16px; line-height: 1.8;">
                        <!-- Top Info -->
                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <strong>Session:</strong> {{ $workplan->academic_session }}
                            </div>
                            <div>
                                <strong>Date:</strong> {{ \Carbon\Carbon::parse($workplan->date)->format('d-m-Y') }}
                            </div>
                        </div>

                        <!-- Project & Animator Details -->
                        <div class="row mb-2">
                            <div class="col-sm-4"><b>Project Code:</b> {{ $workplan->project_code }}</div>
                            <div class="col-sm-4"><b>Project Name:</b> {{ $workplan->project_name }}</div>
                            <div class="col-sm-4"><b>Center:</b> {{ $workplan->center }}</div>
                            <div class="col-sm-4"><b>State:</b> {{ $workplan->state }}</div>
                            <div class="col-sm-4"><b>District:</b> {{ $workplan->district }}</div>
                            <div class="col-sm-4"><b>Animator Code:</b> {{ $workplan->animator_code }}</div>
                            <div class="col-sm-4"><b>Animator Name:</b> {{ $workplan->name }}</div>
                            <div class="col-sm-4"><b>Month Of:</b> {{ $workplan->month_of }}</div>
                            <div class="col-sm-4"><b>From Date:</b> {{ $workplan->date }} &nbsp; <b>To:</b>
                                {{ $workplan->to }}</div>
                        </div>

                        <!-- Work Plan Table -->
                        <div class="row mt-3">
                            <div class="col-sm-12">
                                <div class="card-body table-responsive">
                                    <table class="table table-bordered table-hover align-middle text-center">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Work Date</th>
                                                <th>Work Address</th>
                                                <th>Work Name</th>
                                                <th>Work Type</th>
                                                <th>Worker Name</th>
                                                <th>Work With</th>
                                                <th>Benefits</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($plans as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($item->work_date)->format('d-m-Y') }}</td>
                                                    <td>{{ $item->work_address }}</td>
                                                    <td>{{ $item->work_name }}</td>
                                                    <td>{{ $item->work_type }}</td>
                                                    <td>{{ $item->worker_name }}</td>
                                                    <td>{{ $item->work_with }}</td>
                                                    <td>{{ $item->benefits }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Signatures -->
                        <div class="row d-flex justify-content-between mt-5">
                            <div class="col-sm-3 text-center">
                                <strong>Animator Signature</strong><br>
                                {{ $workplan->name ?? 'N/A' }}
                            </div>
                            <div class="col-sm-3 text-center">
                                <strong>Supervisor Signature</strong><br>
                                {{-- {{ $workplan->supervisor_name ?? 'Supervisor Name' }} --}}
                            </div>
                            <div class="col-sm-3 text-center">
                                <strong>Checker Signature</strong><br>
                                {{-- {{ $workplan->checker_name ?? 'Checker Name' }} --}}
                            </div>
                            <div class="col-sm-3 text-center">
                                <strong>Sanstha Head Signature</strong><br>
                                @if (!empty($signatures['sanstha_head']) && file_exists(public_path($signatures['sanstha_head'])))
                                    <img src="{{ asset($signatures['sanstha_head']) }}" alt="Sanstha Head Signature"
                                        class="img" style="max-height: 100px;">
                                @else
                                    <p class="text-muted">Not attached</p>
                                @endif
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
