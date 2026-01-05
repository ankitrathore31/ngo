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
                <h5 class="mb-0">Hospital List</h5>
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
                <form method="GET" action="{{ route('list.hospital') }}" class="row g-3 mb-4">
                    <div class="row">
                        <div class="col-md-3 col-sm-4 mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Search By Hospital Name">
                        </div>
                        <div class="col-md-3 col-sm-4 mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Search By Hospital Code">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary me-1">Search</button>
                            <a href="{{ route('list.hospital') }}" class="btn btn-info text-white me-1">Reset</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="container-fluid mt-4">
                <div class="card shadow-sm">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Hospital List</h5>
                        <a href="{{ route('add.hospital') }}" class="btn btn-primary btn-sm">
                            + Add Hospital
                        </a>
                    </div>

                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Hospital Code</th>
                                    <th>Registration Date</th>
                                    <th>Hospital / Clinic / Medical Name</th>
                                    <th>Hospital / Clinic / Medical Address</th>
                                    <th>Contact Number</th>
                                    <th>Doctor / Operator Name</th>
                                    <th>Status</th>
                                    <th width="180">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hospitals as $key => $hospital)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $hospital->hospital_code }}</td>
                                        <td>{{ \Carbon\Carbon::parse($hospital->registration_date)->format('d-m-Y') }}</td>
                                        <td>{{ $hospital->hospital_name }}</td>
                                        <td>{{ $hospital->address }}</td>
                                        <td>{{ $hospital->contact_number ?? '-' }}</td>
                                        <td>{{ $hospital->operator_name }}</td>
                                        <td>
                                            <span
                                                class="badge {{ $hospital->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($hospital->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{-- route('hospital.show', $hospital->id) --}}" class="btn btn-info btn-sm">View</a>

                                            <a href="{{ route('edit.hospital', $hospital->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>

                                            <a href="{{ route('delete.hospital', $hospital->id) }}"
                                                onclick="return confirm('Are sure want to delete hospital')"
                                                class="btn btn-danger btn-sm">Delete</a>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hospital found</td>
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
