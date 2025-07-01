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
                <h5 class="mb-0">Distributed Beneficiarie Facilities List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Distributed Facilities List</li>
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
                    <form method="GET" action="{{ route('distributed-list') }}" class="row g-3 mb-4">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                {{-- <label for="session_filter" class="form-label">Select Session</label> --}}
                                <select name="session_filter" id="session_filter" class="form-control"
                                    >
                                    <option value="">All Sessions</option> <!-- Default option to show all -->
                                    @foreach ($data as $session)
                                        <option value="{{ $session->session_date }}"
                                            {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                            {{ $session->session_date }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-md-4 mb-3">
                                <select id="category_filter" name="category_filter"
                                    class="form-control @error('category_filter') is-invalid @enderror"
                                    >
                                    <option value="">-- Select Facilities Category --</option>
                                    <option value="Education"
                                        {{ request('category_filter') == 'Education' ? 'selected' : '' }}>
                                        Education</option>
                                    <option value="Peace Talk"
                                        {{ request('category_filter') == 'Peace Talk' ? 'selected' : '' }}>Peace Talk
                                    </option>
                                    <option value="Environment"
                                        {{ request('category_filter') == 'Environment' ? 'selected' : '' }}>Environment
                                    </option>
                                    <option value="Food" {{ request('facilities_category') == 'Food' ? 'selected' : '' }}>
                                        Food
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
                        </div>
                        <div class="row">

                            @php
                                $districtsByState = config('districts');
                            @endphp
                            <div class="col-md-4 col-sm-6 form-group mb-3">
                                {{-- <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label> --}}
                                <select class="form-control @error('state') is-invalid @enderror" name="state"
                                    id="stateSelect" >
                                    <option value="">Select State</option>
                                    @foreach ($districtsByState as $state => $districts)
                                        <option value="{{ $state }}"
                                            {{ old('state') == $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="col-md-4 col-sm-6 form-group mb-3">
                                {{-- <label for="districtSelect" class="form-label">District: <span
                                    class="text-danger">*</span></label> --}}
                                <select class="form-control @error('district') is-invalid @enderror" name="district"
                                    id="districtSelect" >
                                    <option value="">Select District</option>
                                </select>
                                @error('district')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4 col-sm-6 form-group mb-3">
                                {{-- <label for="block" class="form-label">Block: <span class="text-danger">*</span></label> --}}
                                <input type="text" name="block" id="block"
                                    class="form-control @error('block') is-invalid @enderror" value="{{ old('block') }}"
                                    placeholder="Search by Block">
                                @error('block')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary me-1">Search</button>
                                <a href="{{ route('distributed-list') }}"
                                    class="btn btn-info text-white me-1">Reset</a>
                            </div>
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
                                <th>Mobile no.</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Religion</th>
                                <th>Age</th>
                                <th>Distribute Date</th>
                                <th>Distribute Place</th>
                                <th>Facilities Category</th>
                                <th>Facilities</th>
                                <th>Status</th>
                                <th>Signature/
                                    Thumb Impression of the Recipient
                                </th>
                                <th>Session</th>
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
                                            ({{ $item->area_type }})
                                        </td>
                                        <td>{{ $item->identity_no }}</td>
                                        <td>{{ $item->identity_type }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->caste }}</td>
                                        <td>{{ $item->religion_category }}</td>
                                        <td>{{ $item->religion }}</td>
                                        <td>
                                            {{ $item->dob ? \Carbon\Carbon::parse($item->dob)->age . ' years' : 'Not Found' }}
                                        </td>
                                        <td>
                                            {{ $survey->distribute_date ? \Carbon\Carbon::parse($survey->distribute_date)->format('d-m-Y') : 'No Found' }}
                                        </td>
                                        <td>{{ $survey->distribute_place ?? 'No Found' }}</td>
                                        <td>{{ $survey->facilities_category ?? 'No Found' }}</td>
                                        <td>{{ $survey->facilities ?? 'No Found' }}</td>
                                        <td>{{ $survey->status ?? 'No Found' }} </td>
                                        <td></td>
                                        <td>{{ $survey->academic_session }}</td>
                                        <td class="no-print">
                                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                <a href="{{ route('show-beneficiarie-report', [$item->id, $survey->id]) }}"
                                                    class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                    title="View" style="min-width: 38px; height: 38px;">
                                                    <i class="fa-regular fa-eye"></i>
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
     <script>
        const allDistricts = @json($districtsByState);
        const oldDistrict = "{{ old('district') }}";
        const oldState = "{{ old('state') }}";

        function populateDistricts(state) {
            const districtSelect = document.getElementById('districtSelect');
            districtSelect.innerHTML = '<option value="">Select District</option>';

            if (allDistricts[state]) {
                allDistricts[state].forEach(function(district) {
                    const selected = (district === oldDistrict) ? 'selected' : '';
                    districtSelect.innerHTML += `<option value="${district}" ${selected}>${district}</option>`;
                });
            }
        }

        // Initial load if editing or validation failed
        if (oldState) {
            populateDistricts(oldState);
        }

        // On state change
        document.getElementById('stateSelect').addEventListener('change', function() {
            populateDistricts(this.value);
        });
    </script>
@endsection
