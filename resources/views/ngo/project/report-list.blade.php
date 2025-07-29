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
                <h5 class="mb-0">Project List</h5>

                <!-- Breadcrumb aligned to right -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Project List</li>
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
                    <form method="GET" action="{{ route('list.project') }}" class="row g-3 mb-4">
                        <div class="col-md-4">
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


                        <div class="col-md-4">
                            {{-- <label for="category_filter" class="form-label">Search by Category</label> --}}
                            <select id="category_filter" name="category_filter"
                                class="form-control @error('category_filter') is-invalid @enderror">
                                <option value="">-- Select Category --</option>
                                <option value="Public Program"
                                    {{ request('category_filter') == 'Public Program' ? 'selected' : '' }}>Public Program
                                </option>
                                <option value="Government Program"
                                    {{ request('category_filter') == 'Government Program' ? 'selected' : '' }}>Government
                                    Program</option>
                                <option value="Education" {{ request('category_filter') == 'Education' ? 'selected' : '' }}>
                                    Education</option>
                                <option value="Environment"
                                    {{ request('category_filter') == 'Environment' ? 'selected' : '' }}>Environment</option>
                                <option value="Social Awareness Program"
                                    {{ request('category_filter') == 'Social Awareness Program' ? 'selected' : '' }}>Social
                                    Awareness Program</option>
                                <option value="Cultural Program"
                                    {{ request('category_filter') == 'Cultural Program' ? 'selected' : '' }}>Cultural
                                    Program</option>
                                <option value="Sanitation Program"
                                    {{ request('category_filter') == 'Sanitation Program' ? 'selected' : '' }}>Sanitation
                                    Program</option>
                                <option value="Health Program"
                                    {{ request('category_filter') == 'Health Program' ? 'selected' : '' }}>Health Program
                                </option>
                                <option value="Poor Alleviation"
                                    {{ request('category_filter') == 'Poor Alleviation' ? 'selected' : '' }}>Poor
                                    Alleviation</option>
                                <option value="Women Empowerment"
                                    {{ request('category_filter') == 'Women Empowerment' ? 'selected' : '' }}>Women
                                    Empowerment</option>
                                <option value="Social Problem"
                                    {{ request('category_filter') == 'Social Problem' ? 'selected' : '' }}>Social Problem
                                </option>
                                <option value="Peace Talks Program"
                                    {{ request('category_filter') == 'Peace Talks Program' ? 'selected' : '' }}>Peace Talks
                                    Program</option>
                                <option value="Skill Development"
                                    {{ request('category_filter') == 'Skill Development' ? 'selected' : '' }}>Skill
                                    Development</option>
                                <option value="Religious Program"
                                    {{ request('category_filter') == 'Religious Program' ? 'selected' : '' }}>Religious
                                    Program</option>
                                <option value="Agriculture Program"
                                    {{ request('category_filter') == 'Agriculture Program' ? 'selected' : '' }}>Agriculture
                                    Program</option>
                                <option value="Labour Tools Distribution"
                                    {{ request('category_filter') == 'Labour Tools Distribution' ? 'selected' : '' }}>
                                    Labour Tools Distribution</option>
                                <option value="Drinking Water"
                                    {{ request('category_filter') == 'Drinking Water' ? 'selected' : '' }}>Drinking Water
                                </option>
                                <option value="Ration Distribution"
                                    {{ request('category_filter') == 'Ration Distribution' ? 'selected' : '' }}>Ration
                                    Distribution</option>
                                <option value="Disaster Management"
                                    {{ request('category_filter') == 'Disaster Management' ? 'selected' : '' }}>Disaster
                                    Management</option>
                                <option value="Economic Help"
                                    {{ request('category_filter') == 'Economic Help' ? 'selected' : '' }}>Economic Help
                                </option>
                                <option value="Cow Service"
                                    {{ request('category_filter') == 'Cow Service' ? 'selected' : '' }}>Cow Service
                                </option>
                                <option value="Animal Food"
                                    {{ request('category_filter') == 'Animal Food' ? 'selected' : '' }}>Animal Food
                                </option>
                                <option value="Other Activities"
                                    {{ request('category_filter') == 'Other Activities' ? 'selected' : '' }}>Other
                                    Activities</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-6 form-group mb-3">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                placeholder="Search by Name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4 d-flex">
                            <button type="submit" class="btn btn-primary me-2">Search</button>
                            <a href="{{ route('list.project') }}" class="btn btn-info text-white me-2">Reset</a>
                        </div>
                    </form>
                    <button onclick="printTable()" class="btn btn-primary mb-3">Print Table</button>
                </div>
            </div>


            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('add.project') }}" class="btn btn-success btn-sm">+ Add Project</a>
                </div>
                <div class="card-body table-responsive printable">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Project Image</th>
                                <th>Project Code</th>
                                <th>project Name</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Project Cost</th>
                                <th>Session</th>
                                <th class="no-print">Report</th>
                                <th class="no-print">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $serial =1; @endphp
                            @foreach ($project as $item)
                                @foreach ($item->reports as $report)
                                    <tr>
                                        <td>{{ $serial++ }}</td>
                                        <td>
                                            <img src="{{ asset($item->image) }}" alt="image" class="img-thumbnail"
                                                width="100">
                                        </td>
                                        <td>
                                            {{ $item->code }}</small>
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->category }}</td>
                                        <td>{{ $item->sub_category }}</td>
                                        @php
                                            $budgetItem = \App\Models\BudgetItem::where('report_id', $report->id);
                                        $totalExpense = $budgetItem->sum('expense'); @endphp
                                        <td>{{ $totalExpense }}</td>
                                        <td>{{ $report->academic_session }}</td>
                                        <td class="no-print">
                                            <a href="{{ route('view.project.report', $item->id) }}"
                                                class="btn btn-sm btn-success" title="View">
                                                View Report
                                            </a>
                                        </td>
                                        <td class="no-print">
                                            <div class="d-flex justify-content-center gap-2 flex-wrap">

                                                <a href="{{ route('edit.project.report', $report->id) }}"
                                                    class="btn btn-sm btn-primary" title="Edit Report">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>

                                                <a href="{{ route('delete.project.report', $report->id) }}"
                                                    class="btn btn-sm btn-danger" title="Delete"
                                                    onclick="return confirm('Do you want to delete report')">
                                                    <i class="fa-regular fa-trash-can"></i>
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
