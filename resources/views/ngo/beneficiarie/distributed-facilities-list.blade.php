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
                            <div class="col-md-3 mb-3">
                                {{-- <label for="session_filter" class="form-label">Select Session</label> --}}
                                <select name="session_filter" id="session_filter" class="form-control">
                                    <option value="">All Sessions</option> <!-- Default option to show all -->
                                    @foreach ($data as $session)
                                        <option value="{{ $session->session_date }}"
                                            {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                            {{ $session->session_date }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 col-sm-4 mb-3">
                                <input type="number" class="form-control" name="application_no"
                                    placeholder="Search By Application/Registration No.">
                            </div>
                            <div class="col-md-3 col-sm-4 mb-3">
                                <input type="number" class="form-control" name="registration_no"
                                    placeholder="Search By Mobile/Idtinty No.">
                            </div>
                            <div class="col-md-3 col-sm-4 mb-3">
                                <input type="text" class="form-control" name="name"
                                    placeholder="Search By Person/Guardian's Name">
                            </div>

                            <div class="col-md-3 mb-3">
                                <select id="category_filter" name="category_filter"
                                    class="form-control @error('category_filter') is-invalid @enderror">
                                    <option value="">-- Select Facilities Category --</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->category }}"
                                            {{ request('category_filter') == $cat->category ? 'selected' : '' }}>
                                            {{ $cat->category }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_filter')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class=" col-md-3">
                                {{-- <label for="bene_category">Beneficiarie Eligibility Category</label> --}}
                                <select id="bene_category" name="bene_category" class="form-control">
                                    <option value="">-- Select Beneficiarie Eligibility Category --</option>
                                    <option value="Homeless Families">1. Homeless Families</option>
                                    <option value="People living in kutcha or one-room houses">2. People living in kutcha or
                                        one-room houses</option>
                                    <option value="Widows">3. Widows</option>
                                    <option value="Elderly Women">4. Elderly Women</option>
                                    <option value="Persons with Disabilities">5. Persons with Disabilities</option>
                                    <option value="Landless">6. Landless</option>
                                    <option value="Economically Weaker Section">7. Economically Weaker Section</option>
                                    <option value="Laborers">8. Laborers</option>
                                    <option value="Scheduled Tribes">9. Scheduled Tribes</option>
                                    <option value="Scheduled Castes">10. Scheduled Castes</option>
                                    <option value="Based on Low Income">11. Based on Low Income</option>
                                    <option value="Affected People">12. Affected People</option>
                                    <option value="Marginal Farmers">13. Marginal Farmers</option>
                                    <option value="Small Farmers">14. Small Farmers</option>
                                    <option value="Large Farmers">15. Large Farmers</option>
                                </select>
                            </div>


                            <div class="col-md-3 form-group mb-3">
                                <input type="date" id="distribute_date" name="distribute_date" class="form-control"
                                    value="{{ old('distribute_date') }}">
                                <small class="form-text text-muted"><b>Select Distribute Date</b></small>
                                @error('distribute_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            @php
                                $districtsByState = config('districts');
                            @endphp
                            <div class="col-md-3 col-sm-6 form-group mb-3">
                                {{-- <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label> --}}
                                <select class="form-control @error('state') is-invalid @enderror" name="state"
                                    id="stateSelect">
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
                            <div class="col-md-3 col-sm-6 form-group mb-3">
                                {{-- <label for="districtSelect" class="form-label">District: <span
                                    class="text-danger">*</span></label> --}}
                                <select class="form-control @error('district') is-invalid @enderror" name="district"
                                    id="districtSelect">
                                    <option value="">Select District</option>
                                </select>
                                @error('district')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3 col-sm-6 form-group mb-3">
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
                                <a href="{{ route('distributed-list') }}" class="btn btn-info text-white me-1">Reset</a>
                            </div>
                        </div>
                    </form>
                    <button onclick="printTable()" class="btn btn-primary mb-3">Print Table</button>
                </div>
            </div>
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body">

                    <!-- Total Distributed -->
                    <div class="row text-center mb-4">
                        <div class="col-md-12">
                            <div class="p-4 bg-white rounded-4 shadow-sm hover-card">
                                <i class="fa-solid fa-truck-fast fa-2x text-success mb-2"></i>
                                <h6 class="fw-bold text-success mb-1">Total Distributed</h6>
                                <p class="fs-4 fw-semibold text-dark mb-0">{{ distributeStats()['total'] }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Facility Category Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="stat-card rounded-4 p-3 shadow-sm bg-light">
                                <h5 class="fw-bold text-success mb-3">
                                    <i class="fa-solid fa-box-open me-2"></i>Facility Category-wise Distribution
                                </h5>
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Facility Category</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (distributeStats()['facilityStats'] as $facility => $count)
                                            <tr>
                                                <td>{{ $facility ?: 'Not Specified' }}</td>
                                                <td>{{ $count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Religion Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="stat-card rounded-4 p-3 shadow-sm bg-light">
                                <h5 class="fw-bold text-primary mb-3">
                                    <i class="fa-solid fa-hands-praying me-2"></i>Religion-wise Distribution
                                </h5>
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Religion</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (distributeStats()['religionStats'] as $religion => $count)
                                            <tr>
                                                <td>{{ $religion }}</td>
                                                <td>{{ $count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Caste Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="stat-card rounded-4 p-3 shadow-sm bg-light">
                                <h5 class="fw-bold text-info mb-3">
                                    <i class="fa-solid fa-users me-2"></i>Caste-wise Distribution
                                </h5>
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Caste</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (distributeStats()['casteStats'] as $caste => $count)
                                            <tr>
                                                <td>{{ $caste ?: 'Not Specified' }}</td>
                                                <td>{{ $count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Caste Category Section -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="stat-card rounded-4 p-3 shadow-sm bg-light">
                                <h5 class="fw-bold text-warning mb-3">
                                    <i class="fa-solid fa-layer-group me-2"></i>Caste Category-wise Distribution
                                </h5>
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Category</th>
                                            <th>Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (distributeStats()['categoryStats'] as $category => $count)
                                            <tr>
                                                <td>{{ $category }}</td>
                                                <td>{{ $count }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
                                <th>Registration No.</th>
                                <th>Beneficiarie Name</th>
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
                                <th>Officer</th>
                                <th>Status</th>
                                <th>Signature/
                                    Thumb Impression of the Recipient
                                </th>
                                <th>Beneficiarie Eligibility category</th>
                                <th>Session</th>
                                <th class="no-print">Action</th>
                                {{-- <th class="no-print">Token No.</th> --}}
                                <th class="no-print">Receiving Receipt</th>
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
                                        <td>{{ $survey->officer ?? 'No Found' }}</td>
                                        <td>{{ $survey->status ?? 'No Found' }} </td>
                                        <td></td>
                                        <td>{{ $survey->bene_category ?? 'No Found' }}</td>
                                        <td>{{ $survey->academic_session }}</td>
                                        <td class="no-print">
                                            <div class="d-flex justify-content-center align-items-center gap-2 flex-wrap">

                                                <a href="{{ route('show-beneficiarie-report', [$item->id, $survey->id]) }}"
                                                    class="btn btn-success btn-sm px-3" title="View">
                                                    <i class="fa-regular fa-eye"></i>
                                                </a>

                                                <a href="{{ route('edit-distribute-facilities', [$item->id, $survey->id]) }}"
                                                    class="btn btn-primary btn-sm px-3" title="Edit">
                                                    <i class="fa-regular fa-edit"></i>
                                                </a>

                                                <a href="{{ route('delete-distribute-facilities', [$item->id, $survey->id]) }}"
                                                    onclick="return confirm('Are you sure want to delete Distribute Facilities')"
                                                    class="btn btn-danger btn-sm px-3" title="Delete">
                                                    <i class="fa-regular fa-trash"></i>
                                                </a>

                                            </div>
                                        </td>

                                        {{-- <td>
                                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                <a href="{{ route('show-beneficiarie-token', [$item->id, $survey->id]) }}"
                                                    class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                    title="View">
                                                    Token
                                                </a>
                                            </div> 
                                        </td> --}}
                                        <td class="no-print">
                                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                <a href="{{ route('show-beneficiarie-receipt', [$item->id, $survey->id]) }}"
                                                    class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                    title="View">
                                                    Recipt
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
