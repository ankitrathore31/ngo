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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Investigation Health Facility List</h5>
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
                <form method="GET" action="{{ route('list.Investigationfacility') }}" class="row g-3 mb-4">
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
                            <a href="{{ route('list.Investigationfacility') }}" class="btn btn-info text-white me-1">Reset</a>
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
                                <th>Bill Pay Person</th>
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
                                    <td>{{ $facility->person_paying_bill }}</td>
                                    <td>
                                        {{-- <a href="{{ route('pending.healthfacility.show', $facility->id) }}"
                                            class="btn btn-info btn-sm me-1" title="Show">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a href="{{ route('edit.healthfacility', $facility->id) }}"
                                            class="btn btn-warning btn-sm me-1" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a> --}}

                                        <a href="{{ route('delete.Investigationfacility', $facility->id) }}"
                                            onclick="return confirm('Are sure want to delete Health Facility Investigation')"
                                            class="btn btn-danger btn-sm me-1" title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </a>

                                        <button type="button" class="btn btn-primary btn-sm me-1" data-bs-toggle="modal"
                                            data-bs-target="#investigationModal-{{ $facility->id }}">
                                            Verify
                                        </button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- @endif --}}
            @foreach ($combined as $row)
                @php
                    $facility = $row['facility'];
                    $card = $row['card'];
                    $item = $row['person'];
                @endphp

                <div class="modal fade" id="investigationModal-{{ $facility->id }}" tabindex="-1" aria-hidden="true">

                    <div class="modal-dialog modal-lg">
                        <form method="POST" action="{{ route('investigation.healthfacility.store', $facility->id) }}">
                            @csrf

                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Health Facility Investigation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <strong>Name:</strong> {{ $item->name }}<br>
                                            <strong>Father/Husband Name:</strong> {{ $item->name }}<br>
                                            <strong>Reg No:</strong> {{ $item->registration_no }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Card No:</strong> {{ $card->healthcard_no }}<br>
                                            <strong>Bill No:</strong> {{ $facility->bill_no }}
                                            <strong>Investigation Officer:</strong> {{ $facility->investigation_officer }}
                                            {{-- <strong>Bill No:</strong> {{ $facility->bill_no }} --}}
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="mb-3">
                                        <label class="form-label">Person Paying Bill</label>
                                        <input type="text" name="person_paying_bill" class="form-control"
                                            value="{{ $facility->person_paying_bill }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Investigation Officer</label>
                                        <select name="investigation_officer" class="form-control" required>
                                            <option value="">Select Officer</option>
                                            @foreach ($staff as $person)
                                                <option
                                                    value="{{ $person->name }} ({{ $person->staff_code }}) ({{ $person->position }})"
                                                    {{ $facility->investigation_officer ==
                                                    $person->name . ' (' . $person->staff_code . ') (' . $person->position . ')'
                                                        ? 'selected'
                                                        : '' }}>
                                                    {{ $person->name }} ({{ $person->staff_code }})
                                                    ({{ $person->position }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancel
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            @endforeach



        </div>
    </div>
@endsection
