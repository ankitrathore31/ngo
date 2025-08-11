@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Training Center List</h5>

                <!-- Breadcrumb aligned to right -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Center List</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <form method="GET" action="{{ route('center-list') }}" class="row g-3 mb-4">
                    <div class="col-md-3 col-sm-4">
                        <select name="session_filter" id="session_filter" class="form-control"
                            >
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
                        <input type="text" class="form-control" name="center_code"
                            placeholder="Search By Center code.">
                    </div>
                    <div class="col-md-3 col-sm-4 mb-3">
                        <input type="text" class="form-control" name="center_name" placeholder="Search By Center Name">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary me-1">Search</button>
                        <a href="{{ route('center-list') }}" class="btn btn-info text-white me-1">Reset</a>
                    </div>
                </form>

            </div>


            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('add-center') }}" class="btn btn-success btn-sm">+ New Center</a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Center Code</th>           
                                <th>Center Name</th>
                                <th>Center Address</th>
                                <th>Block</th>
                                <th>District</th>
                                <th>State</th>  
                                <th>Center Incharge</th>            
                                <th>Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($center as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->center_code}}</td>
                                    <td>{{ $item->center_name}}</td>
                                    <td>{{ $item->center_address}},{{ $item->post}},{{ $item->block}}
                                        ,{{ $item->district}},{{ $item->state}}
                                    </td>
                                    <td>{{ $item->block}}</td>
                                    <td>{{ $item->district}}</td>
                                    <td>{{ $item->state}}</td>
                                    <td>{{ \App\Models\Staff::find($item->incharge)->name ?? '' }}</td>
                                    <td>{{ $item->academic_session}}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">

                                            <a href="{{ route('edit-center', $item->id) }}"
                                                class="btn btn-primary btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="Edit" style="min-width: 38px; height: 38px;">
                                                <i class="fa-regular fa-edit"></i>
                                            </a>
                                             <a href="{{ route('delete-center', $item->id) }}"
                                                class="btn btn-danger btn-sm px-3 d-flex align-items-center justify-content-center"
                                                onclick="return confirm('Do you want to delete Tarining Center')" title="Delete" style="min-width: 38px; height: 38px;">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </div>
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
