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
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Organization Members List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Organization Members</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <form method="GET" action="{{ route('list.organization.member') }}" class="row g-3 mb-4">
                    <!-- Session Filter -->
                    <div class="col-md-3 col-sm-4">
                        <select name="session" id="session" class="form-control">
                            <option value="">All Sessions</option>
                            @foreach ($sessions as $s)
                                <option value="{{ $s->academic_session }}"
                                    {{ request('session') == $s->academic_session ? 'selected' : '' }}>
                                    {{ $s->academic_session }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Organization Filter -->
                    <div class="col-md-3 col-sm-4">
                        <select name="org" id="org" class="form-control">
                            <option value="">All Organizations</option>
                            @foreach ($organizations as $org)
                                <option value="{{ $org->name }}" {{ request('org') == $org->name ? 'selected' : '' }}>
                                    {{ $org->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Member Name Filter -->
                    <div class="col-md-3">
                        <input type="text" name="member_name" class="form-control" value="{{ request('member_name') }}"
                            placeholder="Search by Member Name">
                    </div>

                    <!-- Buttons -->
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('list.organization.member') }}" class="btn btn-info text-white">Reset</a>
                    </div>

                    <button type="button" onclick="printTable()" class="btn btn-primary mb-3">Print Table</button>
                </form>
            </div>

            <div class="row">
                <div class="col">
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
                                        <span data-lang="en">Village - Kainchu Tanda, Post - Amaria, District - Pilibhit, UP
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
                            <tr>
                                <th>Sr. No</th>
                                <th>Organization ID.</th>
                                <th>Organization Name</th>
                                <th>Formation Date</th>
                                <th>Organization Address</th>
                                <th>Member Name</th>
                                <th>Address</th>
                                <th>Mobile No.</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Religion</th>
                                <th>Age</th>
                                <th>Position</th>
                                <th>session</th>
                                <th class="no-print">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($organizationMembers as $index => $member)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $member->organization->organization_no ?? 'N/A' }}</td>
                                    <td>{{ $member->organization->name ?? 'N/A' }}</td>
                                    <td>{{ \carbon\carbon::parse($member->organization->formation_date)->format('d-m-Y') }}
                                    </td>
                                    <td>{{ $member->organization->address ?? 'N/A' }},
                                        {{ $member->organization->block ?? 'N/A' }},
                                        {{ $member->organization->district ?? 'N/A' }},
                                        {{ $member->organization->state ?? 'N/A' }}
                                    </td>
                                    <td>{{ $member->person->name ?? 'N/A' }}</td>
                                    <td>{{ $member->person->address ?? $member->person->village }}
                                        , {{ $member->person->block }}, {{ $member->person->district }},
                                        {{ $member->person->state }}
                                    </td>
                                    <td>{{ $member->person->phone }}</td>
                                    <td>{{ $member->person->caste }}</td>
                                    <td>{{ $member->person->religion_category ?? $member->person->caste_category }}</td>
                                    <td>{{ $member->person->religion }}</td>
                                    <td>
                                        {{ $member->person->dob ? \Carbon\Carbon::parse($member->person->dob)->age . ' years' : 'Not Found' }}
                                    </td>
                                    <td>{{ $member->member_position ?? 'N/A' }}</td>
                                    <td>{{ $member->academic_session ?? 'N/A' }}</td>
                                    <td class="no-print">
                                        <a href="{{ route('view.organization.member', $member->id) }}"
                                            class="btn btn-success btn-sm me-2">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('delete.organization.member', $member->id) }}"
                                            class="btn btn-danger btn-sm me-2"
                                            onclick="return confirm('Do you want to delete member')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No Members Found</td>
                                </tr>
                            @endforelse
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
