@extends('ngo.layout.master')
@section('content')
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
            }

            tfoot {
                display: table-footer-group;
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
        <div class="d-flex justify-content-between align-items-center mb-1 mt-2">
            <h5 class="mb-0">Survey List</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-1 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Survey</li>
                </ol>
            </nav>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('survey.list') }}" class="row g-3">
                    <div class="col-md-3 col-sm-6">
                        <select name="session_filter" id="session_filter" class="form-control">
                            <option value="">All Sessions</option>
                            @foreach ($session as $s)
                                <option value="{{ $s->session_date }}"
                                    {{ request('session_filter') == $s->session_date ? 'selected' : '' }}>
                                    {{ $s->session_date }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <input type="date" name="date" class="form-control" value="{{ request('date', $date) }}">
                    </div>

                    {{-- 👇 Only visible for NGO users --}}
                    @if ($user->user_type == 'ngo')

                        <div class="col-md-3 col-sm-6">
                            <input type="text" name="name" class="form-control" value="{{ request('name') }}"
                                placeholder="Search by Staff Name">
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <input type="text" name="code" class="form-control" value="{{ request('code') }}"
                                placeholder="Search by Staff Code">
                        </div>
                    @endif

                    <div class="col-md-3 col-sm-6">
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('survey.list') }}" class="btn btn-info text-white w-100">Reset</a>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <button onclick="printTable()" type="button" class="btn btn-danger text-white w-100">Download
                            PDF</button>
                    </div>
                </form>
            </div>
        </div>

        @if ($surveys->isEmpty())
            <div class="alert alert-info mt-5">No surveys found.</div>
        @else
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
                    <div class="table-responsive mt-5">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Sr No</th>
                                    <th>Survey ID</th>
                                    <th>Survey Date</th>
                                    <th>Animator Name</th>
                                    <th>Beneficiary Name</th>
                                    <th>Father/Husband Name</th>
                                    <th>Address</th>
                                    <th>Mobile No</th>
                                    <th>Scheme Type</th>
                                    <th>Aadhar Benefries father mother gurdian </th>
                                    <th>Account No. Benefries father mother gurdian </th>
                                    <th>Aay Jati Nivas father mother gurdian </th>
                                    <th>Aay Jati nivas Benefries </th>
                                    <th>Adhyan pramn patr Benefries father mother gurdian</th>
                                    <th>Ration Card Benefries father mother gurdian</th>
                                    <th>Color Photo Benefries father mother gurdian</th>
                                    <th>Mobile Aaadhar Link Benefries father mother gurdian</th>
                                    <th>Signature/Thumb Benefries father mother gurdian</th>
                                    <th>Remark</th>
                                    <th>Session</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($surveys as $key => $survey)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td>{{ $survey->user_id }}</td>
                                        <td>{{ $survey->project_code }}</td>
                                        <td>{{ $survey->project_name }}</td>
                                        <td>{{ $survey->center }}</td>
                                        <td>{{ $survey->state }}</td>
                                        <td>{{ $survey->district }}</td>
                                        <td>{{ $survey->animator_code }}</td>
                                        <td>{{ $survey->animator_name }}</td>
                                        <td>{{ $survey->session }}</td>
                                        <td>{{ \Carbon\Carbon::parse($survey->date)->format('d-m-Y') }}</td>
                                        <td>{{ $survey->name }}</td>
                                        <td>{{ $survey->father_husband_name }}</td>
                                        <td>{{ $survey->address }}</td>
                                        <td>{{ $survey->mobile_no }}</td>
                                        <td>{{ $survey->caste }}</td>
                                        <td>{{ $survey->age }}</td>
                                        <td>{{ $survey->beneficiaries_type }}</td>
                                        <td>{{ $survey->disability_percentage }}</td>
                                        <td>{{ $survey->widow_since }}</td>
                                        <td>{{ $survey->type_of_victim }}</td>
                                        <td>{{ $survey->class }}</td>
                                        <td>{{ $survey->place_identification_mark }}</td>
                                        <td class="text-center">
                                            <a href="{{-- route('survey.show', $survey->id) --}}" class="btn btn-sm btn-info">View</a>
                                            <a href="{{-- route('survey.edit', $survey->id) --}}" class="btn btn-sm btn-warning">Edit</a>

                                            @if ($user->user_type === 'ngo')
                                                <form action="{{-- route('survey.destroy', $survey->id) --}}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <script>
        function printTable() {
            window.print();
        }
    </script>
@endsection
