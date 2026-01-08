@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
                <div class="row mb-3 mt-4">
            @php
                $user = auth()->user();
                $isStaff = $user && $user->user_type === 'staff';
            @endphp
            <div class="col-12">
                <div class="d-flex flex-wrap gap-1">

                    @if (!$isStaff || $user->hasPermission('healthfacility_add_disease'))
                        <a href="{{ route('add.disease') }}" class="btn btn-sm btn-primary">
                            Add Disease
                        </a>
                    @endif

                    @if (!$isStaff || $user->hasPermission('healthfacility_hospital_list'))
                        <a href="{{ route('list.hospital') }}" class="btn btn-sm btn-primary">
                            Hospital List
                        </a>
                    @endif

                    @if (!$isStaff || $user->hasPermission('healthfacility_healthcard_generate'))
                        <a href="{{ route('generatelist.healthcard') }}" class="btn btn-sm btn-primary">
                            Health Card Generate
                        </a>
                    @endif

                    @if (!$isStaff || $user->hasPermission('healthfacility_healthcard_list'))
                        <a href="{{ route('list.healthcard') }}" class="btn btn-sm btn-primary">
                            Health Card List
                        </a>
                    @endif

                    @if (!$isStaff || $user->hasPermission('healthfacility_demand'))
                        <a href="{{ route('list.demandfacility') }}" class="btn btn-sm btn-warning text-dark">
                            Demand Facility
                        </a>
                    @endif

                    @if (!$isStaff || $user->hasPermission('healthfacility_pending'))
                        <a href="{{ route('list.pendingfacility') }}" class="btn btn-sm btn-info text-white">
                            Facility Pending
                        </a>
                    @endif

                    @if (!$isStaff || $user->hasPermission('healthfacility_bill_investigation'))
                        <a href="{{ route('list.Investigationfacility') }}" class="btn btn-sm btn-secondary">
                            Bill Investigation
                        </a>
                    @endif

                    @if (!$isStaff || $user->hasPermission('healthfacility_bill_verify'))
                        <a href="{{ route('list.Verifyhealthfacility') }}" class="btn btn-sm btn-secondary">
                            Bill Verify
                        </a>
                    @endif

                    @if (!$isStaff || $user->hasPermission('healthfacility_demand_approve'))
                        <a href="{{ route('list.Approvalhealthfacility') }}" class="btn btn-sm btn-success">
                            Demand Approve
                        </a>
                    @endif

                    @if (!$isStaff || $user->hasPermission('healthfacility_final_approve'))
                        <a href="{{ route('list.Approvehealthfacility') }}" class="btn btn-sm btn-success">
                            Final Approve
                        </a>
                    @endif

                    @if (!$isStaff || $user->hasPermission('healthfacility_reject'))
                        <a href="{{ route('list.Rejecthealthfacility') }}" class="btn btn-sm btn-danger">
                            Reject Facility
                        </a>
                    @endif

                    @if (!$isStaff || $user->hasPermission('healthfacility_pending_demand'))
                        <a href="{{ route('list.DemandPendinghealthfacility') }}" class="btn btn-sm btn-warning text-dark">
                            Pending Demand
                        </a>
                    @endif

                    @if (!$isStaff || $user->hasPermission('healthfacility_non_budget'))
                        <a href="{{ route('list.NonBudgethealthfacility') }}" class="btn btn-sm btn-dark">
                            Non-Budget
                        </a>
                    @endif

                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-record-centre mb-0 mt-4">
            <h5 class="mb-0">Add Hospital</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-record"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-record active" aria-current="page">Health Card</li>
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

                <form method="POST" action="{{ route('store.hospital') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <div class="col-md-4 mb-2">
                            <label>Hospital / Clinic / Medical Code</label>
                            <input type="text" class="form-control" value="{{ $nextCode }}" readonly>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Registration Date</label>
                            <input type="date" name="registration_date" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Hospital / Clinic / Medical Name</label>
                            <input type="text" name="hospital_name" class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Contact Number</label>
                            <input type="text" name="contact_number" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Hospital / Clinic / Medical Address</label>
                            <textarea type="text" name="address" class="form-control"></textarea>
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Operator / Doctor Name</label>
                            <input type="text" name="operator_name" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>GST No</label>
                            <input type="text" name="gst_no" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>License No</label>
                            <input type="text" name="license_no" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Operator Aadhar</label>
                            <input type="text" name="operator_aadhar" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Upload GST Document</label>
                            <input type="file" name="gst_document" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Upload License</label>
                            <input type="file" name="license_document" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Upload Operator Degree</label>
                            <input type="file" name="operator_degree_document" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Upload Operator Aadhaar</label>
                            <input type="file" name="operator_aadhar_document" class="form-control">
                        </div>

                        <div class="col-md-4 mb-2">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-12 mt-3">
                            <button class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>

    </div>
@endsection
