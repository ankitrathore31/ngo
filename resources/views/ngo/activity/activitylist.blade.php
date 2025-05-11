@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Activity List</h5>

                <!-- Breadcrumb aligned to right -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Activity List</li>
                    </ol>
                </nav>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('activitylist') }}" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <select name="session_filter" class="form-control">
                                <option selected disabled>Select Session</option>
                                @foreach (Session::get('all_academic_session') as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ request('session_filter') == $session->name ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <input type="text" name="category_filter" value="{{ request('category_filter') }}"
                                class="form-control" placeholder="Search by Category">
                        </div>

                        <div class="col-md-4 d-flex">
                            <button type="submit" class="btn btn-primary me-2">Search</button>
                            <a href="{{ route('activitylist') }}" class="btn btn-secondary">All</a>
                        </div>
                    </form>
                </div>
            </div>


            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{-- <h5 class="mb-0">Activity List</h5> --}}
                    <a href="{{ route('addactivity') }}" class="btn btn-success btn-sm">+ Add Activity</a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Activity No.</th>
                                <th>Date / Time</th>
                                <th>Program Image</th>
                                <th>Program Name</th>
                                <th>Category</th>
                                <th>Address</th>
                                <th>Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activity as $item)
                                <tr>
                                    <td>{{ $item->activity_no }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->program_date)->format('d-m-Y') }}<br>
                                        <small>{{ $item->program_time }}</small>
                                    </td>
                                    <td>
                                        <img src="{{ asset('program_images/' . $item->program_image) }}" alt="image"
                                            class="img-thumbnail" width="100">
                                    </td>
                                    <td>{{ $item->program_name }}</td>
                                    <td>{{ $item->program_category }}</td>
                                    <td>{{ $item->program_address }}</td>
                                    <td>{{ $item->academic_session }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ route('viewactivity', $item->id) }}" class="btn btn-sm btn-success" title="View">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            <a href="{{ route('editactivity', $item->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="{{ route('removeactivity', $item->id) }}" class="btn btn-sm btn-danger" title="Delete">
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
