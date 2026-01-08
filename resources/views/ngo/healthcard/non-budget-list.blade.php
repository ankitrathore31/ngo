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
                            <a href="{{ route('list.DemandPendinghealthfacility') }}"
                                class="btn btn-sm btn-warning text-dark">
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Non Budget Health Facility List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Health Card</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <form method="GET" action="{{ route('list.NonBudgethealthfacility') }}" class="row g-3 mb-4">
                    <div class="row">
                        <div class="col-md-3 col-sm-4 mb-3">
                            <input type="text" class="form-control" name="healthcard_no"
                                placeholder="Search By Health Card No.">
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
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary me-1">Search</button>
                            <a href="{{ route('list.NonBudgethealthfacility') }}"
                                class="btn btn-info text-white me-1">Reset</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    {{-- @if ($combined->count()) --}}
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Health Card Registration Date</th>
                                <th>Health Card No</th>
                                <th>Registration No</th>
                                <th>Registration Date</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Father/Husband/Guardian's Name</th>
                                <th>Address</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Religion</th>
                                <th>Mobile No</th>
                                <th>Registration Type</th>
                                <th>Disease Name</th>
                                <th>Bill No</th>
                                <th>Bill Date</th>
                                <th>Bill Amount</th>
                                <th>Investigation Officer</th>
                                <th>Verify Officer</th>
                                <th>Clearness Amount</th>
                                <th>Status</th>
                                <th>Reason</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($combined as $index => $row)
                                @php
                                    $item = $row['person'];
                                    $card = $row['card'];
                                    $facility = $row['facility'];
                                @endphp
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>{{ \Carbon\Carbon::parse($card->Health_registration_date)->format('d-m-Y') }}
                                    </td>
                                    <td>{{ $card->healthcard_no }}</td>
                                    <td>{{ $item->registration_no }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->registration_date)->format('d-m-Y') }}</td>

                                    <td>
                                        <img src="{{ asset(($item instanceof \App\Models\beneficiarie ? 'benefries_images/' : 'member_images/') . $item->image) }}"
                                            width="80">
                                    </td>

                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->gurdian_name }}</td>
                                    <td>{{ $item->village }}, {{ $item->block }}, {{ $item->district }},
                                        {{ $item->state }}</td>
                                    <td>{{ $item->caste }}</td>
                                    <td>{{ $item->religion_category }}</td>
                                    <td>{{ $item->religion }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->reg_type ?? 'Member' }}</td>

                                    <td>{{ implode(', ', $card->diseases ?? []) }}</td>

                                    {{-- HealthFacility fields --}}
                                    <td>{{ $facility->bill_no ?? '-' }}</td>
                                    <td>
                                        {{ $facility->bill_date ? \Carbon\Carbon::parse($facility->bill_date)->format('d-m-Y') : '-' }}
                                    </td>

                                    <td>{{ number_format($facility->bill_amount ?? 0, 2) }}</td>
                                    <td>{{ $facility->investigation_officer }}</td>
                                    <td>{{ $facility->verify_officer }}</td>
                                    <td>{{ number_format($facility->clearness_amount ?? 0, 2) }}</td>
                                    <td>{{ $facility->status }}</td>
                                    <td>{{ $facility->reason }}</td>
                                    <td>
                                        <a href="{{ route('healthfacility.final.form.show', $facility->id) }}"
                                            class="btn btn-warning btn-sm me-2 mb-1" title="Edit">
                                            Show
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
