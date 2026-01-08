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
            <h5 class="mb-0">Add disease</h5>
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

                <form action="{{ route('store.disease') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Health Facility / Disease Name</label>
                            <input type="text" name="disease" class="form-control @error('disease') is-invalid @enderror"
                                value="{{ old('disease') }}">
                            @error('disease')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-3 mt-4">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </div>
                </form>

                <hr>

                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Disease Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($diseases as $key => $disease)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $disease->disease }}</td>
                                <td>
                                    <a href="{{ route('delete.disease', $disease->id) }}"
                                        onclick="return confirm('Are sure want to delete disease')"
                                        class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No data found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>
@endsection
