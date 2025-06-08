@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between aligin-item-center mb-3 mt-2">
            <h5 class="mb-0">Staff List</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Staff</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="row m-3">
            <form method="GET" action="{{-- route('approve-registration') --}}" class="row g-3 mb-4">
                <div class="col-md-3 col-sm-4">
                    <select name="session_filter" id="session_filter" class="form-control" onchange="this.form.submit()">
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
                    <input type="number" class="form-control" name="staff_code" placeholder="Search By Staff Code.">
                </div>
                <div class="col-md-3 col-sm-4 mb-3">
                    <input type="text" class="form-control" name="name" placeholder="Search By Name">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary me-1">Search</button>
                    <a href="{{ route('staff-list') }}" class="btn btn-info text-white me-1">Reset</a>
                </div>
            </form>

        </div>
        <div class="containert-fluid">
            <div class="card rounded m-3">
                <div class="card-body responsive-table">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Image</th>
                                <th>Staff Code</th>
                                <th>Name</th>
                                <th>Father/Husband Name</th>
                                <th>Address</th>
                                <th>Application Date</th>
                                <th>Joining Date</th>
                                <th>Position</th>
                                <th>Staff Power</th>
                                <th>Mobile no.</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Religion</th>
                                <th>Age</th>
                                <th>Session</th>
                                <th class="no-print">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
