@extends('ngo.layout.master')
@Section('content')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .print-card,
            .print-card * {
                visibility: visible;
            }

            .print-card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            /* Optional: Hide buttons like Print/Download and Language Toggle */
            button,
            .btn,
            .d-flex.justify-content-between {
                display: none !important;
            }
        }
    </style>
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Social Problem View</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Social Problem</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="container my-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">Social Problem</h2>
                    <button onclick="window.print()" class="btn btn-primary">Print / Download</button>
                </div>

                <div class="card p-4 shadow rounded print-card">
                    <div class="text-center mb-4 border-bottom">
                        <div class="row align-items-center">
                            <div class="col-sm-2 text-center text-md-start">
                                <a href="https://gyanbhartingo.org">
                                    <img src="{{ asset('images/LOGO.png') }}" alt="Logo" width="80" height="80"
                                        class="">
                                </a>
                            </div>
                            <div class="col-sm-10 text-center">
                                <h4 style="color: red; font-weight:500; font-size:25px;"><b>GYAN BHARTI SANSTHA</b></h4>
                                <h6 style="color: blue;"><b>Head Office: Kainchu Tanda Amaria Pilibhit UP 262121</b></h6>
                                <p><b>Website : www.gyanbhartingo.org Email : gyanbhartingo600@gmail.com Mob- 9411484111</b>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-sm-4 mb-3">
                            <strong>Problem Date:</strong>
                            {{ \Carbon\Carbon::parse($record->problem_date)->format('d-m-Y') }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Application No:</strong> {{ $record->problem_no }}
                        </div>
                        <div class="col-sm-4 mb-3">
                            <strong>Session:</strong> {{ $record->academic_session }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12 mb-3">
                            <strong>Problem Discover By:</strong> &nbsp;
                            {{ $staffList[$record->problem_by]->name }}({{ $staffList[$record->problem_by]->position }})
                        </div>
                        <div class="col-sm-6 mb-3">
                            <strong>Address:</strong>&nbsp;{{ $record->address }}
                        </div>
                        <div class="col-sm-6 mb-3">
                            <strong>Block:</strong>&nbsp; {{ $record->block }}
                        </div>
                        <div class="col-sm-6 mb-3">
                            <strong>District</strong>&nbsp; {{ $record->district }}
                        </div>
                        <div class="col-sm-6 mb-2">
                            <strong>State</strong>&nbsp; {{ $record->state }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 mb-2">
                            <strong>Problem Description:</strong>&nbsp; {{ $record->description }}
                        </div>
                    </div>
                    <hr>
                    @if ($record->status == 1)
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-12 mb-3">
                                        <strong>Problem Solution Discover By:</strong> &nbsp;
                                        {{ $staffList[$record->solution_by]->name }}({{ $staffList[$record->solution_by]->position }})
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <strong>Solution Description:</strong>&nbsp; {{ $record->solution_description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endif
                    <div class="row d-flex justify-content-between mt-2">
                        <div class="col-sm-5 mb-5">
                            <label for=""
                                class="from-label"><b>{{ $staffList[$record->problem_by]->name }}({{ $staffList[$record->problem_by]->position }})
                                    <br>
                                    Signature</b></label>
                        </div>
                        <div class="col-sm-5 text-center">
                            @if (!empty($signatures['director']) && file_exists(public_path($signatures['director'])))
                                <div id="directorSignatureBox" class="mt-2">
                                    <p class="text-success no-print">Attached</p>
                                    <img src="{{ asset($signatures['director']) }}" alt="Director Signature" class="img"
                                        style="max-height: 100px;">
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
                            @endif
                            <strong>Digitally Signed By <br>
                                MANOJ KUMAR RATHOR <br>
                                DIRECTOR
                            </strong><br>
                        </div>
                    </div>
                </div>
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
