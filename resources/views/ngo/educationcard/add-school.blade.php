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
                <h5 class="mb-0">Add School</h5>
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
            <div class="container mt-3">
                <div class="card shadow-sm p-3">

                    <form method="POST" action="{{ route('store.school') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-4 mb-2">
                                <label>School / Institution Code</label>
                                <input type="text" name="school_code" class="form-control" value="{{ $nextCode }}" readonly>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Registration Date</label>
                                <input type="date" name="registration_date" class="form-control">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>School / Institution / Tuition Name</label>
                                <input type="text" name="school_name" class="form-control" required>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Contact Number</label>
                                <input type="text" name="contact_number" class="form-control">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>School / Institution Address</label>
                                <textarea name="address" class="form-control"></textarea>
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Principal / Head / Teacher Name</label>
                                <input type="text" name="principal_name" class="form-control">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Affiliation / Board Name</label>
                                <input type="text" name="affiliation_board" class="form-control">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>School Registration No</label>
                                <input type="text" name="registration_no" class="form-control">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Principal Aadhaar</label>
                                <input type="text" name="principal_aadhar" class="form-control">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Upload Registration Certificate</label>
                                <input type="file" name="registration_certificate" class="form-control">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Upload Affiliation Certificate</label>
                                <input type="file" name="affiliation_certificate" class="form-control">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Upload Principal Appointment Letter</label>
                                <input type="file" name="principal_appointment_letter" class="form-control">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Upload Principal Aadhaar</label>
                                <input type="file" name="principal_aadhar_document" class="form-control">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-success">
                                    Save School
                                </button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
