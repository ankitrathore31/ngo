@extends('ngo.layout.master')
@Section('content')
 <style>
        @page {
            size: auto;
            margin: 0;
            /* Remove all margins including top */
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
        }
    </style>
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Beneficiarie Facilities List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Beneficiarie Facilities List</li>
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
                    <form method="GET" action="{{ route('beneficiarie-facilities-list') }}" class="row g-3 mb-4">
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


                        <div class="col-md-4">
                            <select id="category_filter" name="category_filter"
                                class="form-control @error('category_filter') is-invalid @enderror"
                                onchange="this.form.submit()">
                                <option value="">-- Select Facilities Category --</option>
                                <option value="Education"
                                    {{ request('category_filter') == 'Education' ? 'selected' : '' }}>Education</option>
                                <option value="Peace Talk"
                                    {{ request('category_filter') == 'Peace Talk' ? 'selected' : '' }}>Peace Talk
                                </option>
                                <option value="Environment"
                                    {{ request('category_filter') == 'Environment' ? 'selected' : '' }}>Environment
                                </option>
                                <option value="Food" {{ request('facilities_category') == 'Food' ? 'selected' : '' }}>Food
                                </option>
                                <option value="Skill Development"
                                    {{ request('category_filter') == 'Skill Development' ? 'selected' : '' }}>Skill
                                    Development</option>
                                <option value="Women Empowerment"
                                    {{ request('category_filter') == 'Women Empowerment' ? 'selected' : '' }}>Women
                                    Empowerment</option>
                                <option value="Awareness"
                                    {{ request('category_filter') == 'Awareness' ? 'selected' : '' }}>Awareness
                                </option>
                                <option value="Cultural Program"
                                    {{ request('category_filter') == 'Cultural Program' ? 'selected' : '' }}>Cultural
                                    Program</option>
                                <option value="Clean Campaign"
                                    {{ request('category_filter') == 'Clean Campaign' ? 'selected' : '' }}>Clean
                                    Campaign</option>
                                <option value="Health Mission"
                                    {{ request('category_filter') == 'Health Mission' ? 'selected' : '' }}>Health
                                    Mission</option>
                                <option value="Poor Alleviation"
                                    {{ request('category_filter') == 'Poor Alleviation' ? 'selected' : '' }}>Poor
                                    Alleviation</option>
                                <option value="Religious Program"
                                    {{ request('category_filter') == 'Religious Program' ? 'selected' : '' }}>Religious
                                    Program</option>
                                <option value="Agriculture Program"
                                    {{ request('category_filter') == 'Agriculture Program' ? 'selected' : '' }}>
                                    Agriculture Program</option>
                                <option value="Drinking Water"
                                    {{ request('category_filter') == 'Drinking Water' ? 'selected' : '' }}>Drinking
                                    Water</option>
                                <option value="Natural Disaster"
                                    {{ request('category_filter') == 'Natural Disaster' ? 'selected' : '' }}>Natural
                                    Disaster</option>
                                <option value="Animal Service"
                                    {{ request('category_filter') == 'Animal Service' ? 'selected' : '' }}>Animal
                                    Service</option>
                            </select>
                            @error('category_filter')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-md-4 d-flex">
                            <button type="submit" class="btn btn-primary me-2">Search</button>
                            <a href="{{ route('beneficiarie-facilities-list') }}" class="btn btn-info text-white me-2">Reset</a>
                        </div>
                    </form>
                    <button onclick="printTable()" class="btn btn-primary mb-3">Print Table</button>
                </div>
            </div>
            <div class="card shadow-sm printable">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Registration No.</th>
                                <th>Name</th>
                                <th>Father/Husband Name</th>
                                <th>Address</th>
                                <th>Identity No.</th>
                                <th>Identity Type</th>
                                <th>Mobile No.</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Religion</th>
                                <th>Age</th>
                                <th>Session</th>
                                <th>Survey Date</th>
                                <th>Facilities Category</th>
                                <th>Facilities</th>
                                <th class="no-print">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($beneficiarie as $item)
                                @foreach ($item->surveys as $survey)
                                    <tr>
                                        <td>{{ $loop->parent->iteration }}</td>
                                        <td>{{ $item->registration_no }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->gurdian_name }}</td>
                                        <td>{{ $item->village }},
                                            {{ $item->post }},
                                            {{ $item->block }},
                                            {{ $item->district }},
                                            {{ $item->state }} - {{ $item->pincode }},
                                        ({{ $item->area_type }})</td>
                                            <td>{{ $item->identity_no }}</td>
                                            <td>{{ $item->identity_type }}</td>
                                        <td>{{ $item->phone }}</td>
                                          <td>{{ $item->caste }}</td>
                                          <td>{{ $item->religion_category }}</td>
                                        <td>{{ $item->religion }}</td>
                                        <td>
                                            {{ $item->dob ? \Carbon\Carbon::parse($item->dob)->age . ' years' : 'Not Found' }}
                                        </td>
                                        <td>{{ $item->academic_session }}</td>
                                        <td>
                                            {{ $survey->survey_date ? \Carbon\Carbon::parse($survey->survey_date)->format('d-m-Y') : 'No Found' }}
                                        </td>
                                        <td>{{ $survey->facilities_category ?? 'No Found' }}</td>
                                        <td>{{ $survey->facilities ?? 'No Found' }}</td>
                                        {{-- Survey date --}}
                                        <td class="no-print">
                                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                <a href="{{ route('distribute-beneficiarie-facilities', [$item->id, $survey->id]) }}"
                                                    class="btn btn-primary btn-sm px-3 d-flex align-items-center justify-content-center"
                                                    title="Distribute" style="min-width: 38px; height: 38px;">
                                                    + Distribute
                                                </a>
                                                <a href="{{ route('show-beneficiarie-facilities', [$item->id, $survey->id]) }}"
                                                    class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                    title="View" style="min-width: 38px; height: 38px;">
                                                    <i class="fa-regular fa-eye"></i> Facilities
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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
