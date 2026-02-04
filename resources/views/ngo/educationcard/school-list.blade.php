@extends('ngo.layout.master')
@Section('content')
    <style>
        .hover-card {
            transition: all 0.3s ease-in-out;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            background-color: #f9fafb;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
    <div class="wrapper">
        <div class="container-fluid mt-4">
            <div class="row mb-3 mt-4">
                @php
                    $user = auth()->user();
                    $isStaff = $user && $user->user_type === 'staff';
                @endphp
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-1">

                        @if (!$isStaff || $user->hasPermission('educationfacility_hospital_list'))
                            <a href="{{ route('list.school') }}" class="btn btn-sm btn-info">
                                School List
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_generate'))
                            <a href="{{ route('eduaction.reg.list') }}" class="btn btn-sm btn-success">
                                Education Card Generate
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('eduaction.card.list') }}" class="btn btn-sm btn-primary">
                                Education Card List
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('eduaction.demand.list') }}" class="btn btn-sm btn-warning">
                                Demand Education Facility
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('eduaction.demand.pending.list') }}" class="btn btn-sm btn-warning">
                                Demand Education Pending Facility
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('education.list.Investigationfacility') }}" class="btn btn-sm btn-secondary">
                                Investigation Education Facility
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('education.list.Verifyfacility') }}" class="btn btn-sm btn-dark">
                                Verify Education Facility
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('education.list.Approvalfacility') }}" class="btn btn-sm btn-info">
                                Demand Approval Education Facility
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('education.list.Approvefacility') }}" class="btn btn-sm btn-success">
                                Approve Education Facility
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('education.list.NonBudgetfacility') }}" class="btn btn-sm btn-secondary">
                                Non Budget Education Facility
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('education.list.Rejectfacility') }}" class="btn btn-sm btn-danger">
                                Reject Education Facility
                            </a>
                        @endif

                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">School List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Education Card</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <form method="GET" action="{{ route('list.school') }}" class="row g-3 mb-4">
                    <div class="row">
                        <div class="col-md-3 col-sm-4 mb-3">
                            <input type="text" class="form-control" name="school_name"
                                value="{{ request('school_name') }}" placeholder="Search By School Name">
                        </div>

                        <div class="col-md-3 col-sm-4 mb-3">
                            <input type="text" class="form-control" name="school_code"
                                value="{{ request('school_code') }}" placeholder="Search By School Code">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary me-1">Search</button>
                            <a href="{{ route('list.school') }}" class="btn btn-info text-white me-1">Reset</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="container-fluid mt-4">
                <div class="card shadow-sm">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="{{ route('add.school') }}" class="btn btn-primary btn-sm">
                            + Add School
                        </a>
                    </div>

                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>School Code</th>
                                    <th>Registration Date</th>
                                    <th>School / Institution / Tuition Name</th>
                                    <th>Address</th>
                                    <th>Contact Number</th>
                                    <th>Principal / / Teacher / Head</th>
                                    <th>Status</th>
                                    <th width="180">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schools as $key => $school)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $school->school_code }}</td>
                                        <td>
                                            {{ $school->registration_date ? \Carbon\Carbon::parse($school->registration_date)->format('d-m-Y') : '-' }}
                                        </td>
                                        <td>{{ $school->school_name }}</td>
                                        <td>{{ $school->address }}</td>
                                        <td>{{ $school->contact_number ?? '-' }}</td>
                                        <td>{{ $school->principal_name ?? '-' }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $school->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($school->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('edit.school', $school->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>

                                            <a href="{{ route('delete.school', $school->id) }}"
                                                onclick="return confirm('Are you sure want to delete school?')"
                                                class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No school found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
