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
                                Approval Education Facility
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
                <h5 class="mb-0">Verify Education Facility List</h5>
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
                <form method="GET" action="{{ route('education.list.Verifyfacility') }}" class="row g-3 mb-4">
                    <div class="row">
                        <div class="col-md-3 col-sm-4">
                            <select name="session_filter" id="session_filter" class="form-control">
                                <option value="">All Sessions</option>
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-4 mb-3">
                            <input type="text" class="form-control" name="educationcard_no"
                                placeholder="Search By Education Card No.">
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

                        @php
                            $districtsByState = config('districts');
                        @endphp
                        <div class="col-md-3 col-sm-6 form-group mb-3">
                            {{-- <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label> --}}
                            <select class="form-control @error('state') is-invalid @enderror" name="state"
                                id="stateSelect">
                                <option value="">Select State</option>
                                @foreach ($districtsByState as $state => $districts)
                                    <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>
                                        {{ $state }}
                                    </option>
                                @endforeach
                            </select>
                            @error('state')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-3 col-sm-6 form-group mb-3">
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
                            <a href="{{ route('education.list.Verifyfacility') }}"
                                class="btn btn-info text-white me-1">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    @if ($combined->count())
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Education Card Registration Date</th>
                                    <th>Education Card No</th>
                                    <th>Registration No</th>
                                    <th>Registration Date</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Father/Husband Name</th>
                                    <th>Address</th>
                                    <th>Caste</th>
                                    <th>Caste Category</th>
                                    <th>Religion</th>
                                    <th>Mobile No.</th>
                                    <th>Registration Type</th>
                                    <th>Student</th>
                                    <th>Fees Slip No</th>
                                    <th>Fees Submit Date</th>
                                    <th>Fees Amount</th>
                                    <th>Investigation Officer</th>
                                    <th>Verify Officer</th>
                                    <th class="text-danger">Form Remark</th>
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
                                        <td>{{ \Carbon\Carbon::parse($card->education_registration_date)->format('d-m-Y') }}
                                        </td>
                                        <td>{{ $card->educationcard_no }}</td>
                                        <td>{{ $item->registration_no }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->registration_date)->format('d-m-Y') }}</td>

                                        <td>
                                            <img src="{{ asset(($item instanceof \App\Models\beneficiarie ? 'benefries_images/' : 'member_images/') . $item->image) }}"
                                                width="100">
                                        </td>

                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->gurdian_name }}</td>

                                        <td>
                                            {{ $item->village }},
                                            {{ $item->post }},
                                            {{ $item->block }},
                                            {{ $item->district }},
                                            {{ $item->state }} - {{ $item->pincode }}
                                            ({{ $item->area_type }})
                                        </td>

                                        <td>{{ $item->caste }}</td>
                                        <td>{{ $item->religion_category }}</td>
                                        <td>{{ $item->religion }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->reg_type ?? 'Member' }}</td>

                                        <td>{{ implode(', ', $card->students ?? []) }}</td>
                                        <td>{{ $facility->fees_slip_no }}</td>
                                        <td>{{ \Carbon\Carbon::parse($facility->fees_submit_date)->format('d-m-Y') }}</td>
                                        <td>{{ $facility->fees_amount }}</td>
                                        <td>
                                            @php
                                                $staff = staffByEmail($facility->investigation_officer);
                                            @endphp

                                            @if ($staff)
                                                {{ $staff->name }} ({{ $staff->staff_code }}) - {{ $staff->position }}
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $staff = !empty($facility->verify_officer)
                                                    ? staffByEmail($facility->verify_officer)
                                                    : null;
                                            @endphp

                                            @if ($staff)
                                                {{ $staff->name }} ({{ $staff->staff_code }}) - {{ $staff->position }}
                                            @else
                                                <span class="text-muted">Verify officer not selected</span>
                                            @endif
                                        </td>

                                        <td class="text-start">
                                            @if (!empty($facility->remark))
                                                <span class="badge bg-danger mb-1">Rejected</span>
                                                <div class="border border-danger rounded p-2 mt-1 text-danger small">
                                                    {{ $facility->remark }}
                                                </div>
                                            @else
                                                <span class="badge bg-warning text-dark">In Progress</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('investigation.education.facility.show', $facility->id) }}"
                                                class="btn btn-sm btn-success mb-1">
                                                Show
                                            </a>

                                            @if ($user->user_type === 'ngo')
                                                <form
                                                    action="{{ route('demand.education.facility.delete', $facility->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this record?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm mb-1">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    @else
                        <div class="alert alert-warning text-center mb-0">
                            No records found for the selected search criteria.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
