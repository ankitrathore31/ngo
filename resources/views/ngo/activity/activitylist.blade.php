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
                <h5 class="mb-0">Activity List</h5>

                <!-- Breadcrumb aligned to right -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Activity List</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
             <div class="container">
            <div class="row justify-content-between mb-5">
                <div class="col-sm-4 text-start">
                    <span class="p-1" style="font-size: 25px; font-weight: 500;">
                        Total Activity: <strong>{{ $activity->count() }}</strong>
                    </span>
                </div>
                <div class="col-sm-8" style="font-size: 25px; font-weight: 500;">
                    Social Activity / Work
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('activitylist') }}" class="row g-3 mb-4">
                        <div class="col-md-4">
                            {{-- <label for="session_filter" class="form-label">Select Session</label> --}}
                            <select name="session_filter" id="session_filter" class="form-control">
                                <option value="">All Sessions</option> <!-- Default option to show all -->
                                @foreach (Session::get('all_academic_session') as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            {{-- <label for="program_category" class="form-label">Program/Work Category <span
                                    class="text-danger">*</span></label> --}}
                            <select id="program_category"
                                class="form-control select @error('program_category') is-invalid @enderror"
                                name="program_category">
                                <option value="" selected>Select project/Work Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3 form-group local-from">
                            {{-- <label for="program_name" class="form-label">Program/Work Name <span
                                    class="text-danger">*</span></label> --}}
                            <select name="program_name" id="program_name" class="form-control" required>
                                <option value="">Select Work Name</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-6 form-group mb-3">
                            <input type="text" name="address_filter" id="address"
                                class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}"
                                placeholder="Search by Address">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary me-2">Search</button>
                            <a href="{{ route('activitylist') }}" class="btn btn-info text-white me-2">Reset</a>
                        </div>
                    </form>
                    <button onclick="printTable()" class="btn btn-primary mb-3">Print Table</button>
                </div>
            </div>


            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('addactivity') }}" class="btn btn-success btn-sm">+ Add Activity</a>
                </div>
                <div class="card-body table-responsive printable">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Session</th>
                                <th>Date / Time</th>
                                <th>Program Image</th>
                                <th>Program/Work Name</th>
                                <th>Work Category</th>
                                <th>Address</th>
                                <th>Session</th>
                                <th class="no-print">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activity as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->academic_session }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->program_date)->format('d-m-Y') }}<br>
                                        <small>{{ $item->program_time }}</small>
                                    </td>
                                    <td>
                                        <img src="{{ asset('program_images/' . $item->program_image) }}" alt="image"
                                            class="img-thumbnail" width="100">
                                    </td>
                                    <td>{{ $item->program_name }}</td>
                                    <td>{{ $item->program_category }}</td>
                                    <td>{{ $item->program_address }}</td>
                                    <td>{{ $item->academic_session }}</td>
                                    <td class="no-print">
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ route('viewactivity', $item->id) }}" class="btn btn-sm btn-success"
                                                title="View">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            <a href="{{ route('editactivity', $item->id) }}" class="btn btn-sm btn-primary"
                                                title="Edit">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="{{ route('removeactivity', $item->id) }}"
                                                class="btn btn-sm btn-danger" title="Delete"
                                                onclick="return confirm('Do you want to delete activity')">
                                                <i class="fa-regular fa-trash-can"></i>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const allProjects = @json($allProjects);
            const categorySelect = document.getElementById('program_category');
            const workNameSelect = document.getElementById('program_name');

            categorySelect.addEventListener('change', function() {
                const selectedCategory = this.value;

                // Clear existing options
                workNameSelect.innerHTML = '<option value="">Select Work Name</option>';

                // Filter projects by selected category
                const filteredProjects = allProjects.filter(
                    project => project.category === selectedCategory
                );

                // Populate new options
                filteredProjects.forEach(project => {
                    const option = document.createElement('option');
                    option.value = project.name;
                    option.text = project.name;
                    workNameSelect.appendChild(option);
                });
            });
        });
    </script>
@endsection
