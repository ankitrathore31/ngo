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

                        @if (!$isStaff || $user->hasPermission('educationfacility_add_disease'))
                            <a href="{{-- route('add.disease') --}}" class="btn btn-sm btn-primary">
                                Add Class
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_hospital_list'))
                            <a href="{{ route('list.school') }}" class="btn btn-sm btn-primary">
                                School List
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_generate'))
                            <a href="{{ route('eduaction.reg.list') }}" class="btn btn-sm btn-primary">
                                Education Card Generate
                            </a>
                        @endif

                        {{-- @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_list'))
                            <a href="{{ route('eduaction.reg.list') }}" class="btn btn-sm btn-primary">
                                education Card List
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_demand'))
                            <a href="{{ route('list.demandfacility') }}" class="btn btn-sm btn-warning text-dark">
                                Demand Facility
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_pending'))
                            <a href="{{ route('list.pendingfacility') }}" class="btn btn-sm btn-info text-white">
                                Facility Pending
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_bill_investigation'))
                            <a href="{{ route('list.Investigationfacility') }}" class="btn btn-sm btn-secondary">
                                Bill Investigation
                            </a>
                        @endif --}}

                        {{-- @if (!$isStaff || $user->hasPermission('educationfacility_bill_verify'))
                            <a href="{{ route('list.Verifyeducationfacility') }}" class="btn btn-sm btn-secondary">
                                Bill Verify
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_demand_approve'))
                            <a href="{{ route('list.Approvaleducationfacility') }}" class="btn btn-sm btn-success">
                                Demand Approve
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_final_approve'))
                            <a href="{{ route('list.Approveeducationfacility') }}" class="btn btn-sm btn-success">
                                Final Approve
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_reject'))
                            <a href="{{ route('list.Rejecteducationfacility') }}" class="btn btn-sm btn-danger">
                                Reject Facility
                            </a>
                        @endif --}}

                        {{-- @if (!$isStaff || $user->hasPermission('educationfacility_pending_demand'))
                            <a href="{{ route('list.DemandPendingeducationfacility') }}"
                                class="btn btn-sm btn-warning text-dark">
                                Pending Demand
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_non_budget'))
                            <a href="{{ route('list.NonBudgeteducationfacility') }}" class="btn btn-sm btn-dark">
                                Non-Budget
                            </a>
                        @endif --}}

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
                <form method="GET" action="{{ route('list.student') }}" class="row g-3 mb-4">

                    <div class="row">


                        <div class="col-md-3 col-sm-4 mb-3">
                            <input type="text" class="form-control" name="student_name"
                                value="{{ request('student_name') }}" placeholder="Search By Student Name">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary me-1">Search</button>
                            <a href="{{ route('list.student') }}" class="btn btn-info text-white me-1">Reset</a>
                        </div>
                    </div>

                </form>
            </div>


            <div class="container-fluid mt-4">
                <div class="card shadow-sm">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <a href="{{ route('add.student') }}" class="btn btn-primary btn-sm">
                            + Add Student
                        </a>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>

                                    <th>Student Name</th>

                                    <th width="180">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($students as $key => $student)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <td>{{ $student->student_name }}</td>

                                        <td>
                                            <a href="{{ route('edit.student', $student->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <a href="{{ route('edit.student', $student->id) }}"
                                                class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No student found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        @endsection
