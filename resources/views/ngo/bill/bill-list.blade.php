@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Bill List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bill</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <form method="GET" action="{{ route('bill-list') }}" class="row g-3 mb-4">
                    <div class="col-md-3 col-sm-4">
                        <select name="session_filter" id="session_filter" class="form-control"
                        >
                            <option value="">All Sessions</option>
                            @foreach ($session as $session)
                                <option value="{{ $session->session_date }}"
                                    {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                    {{ $session->session_date }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <select id="category_filter" name="category_filter"
                            class="form-control @error('category_filter') is-invalid @enderror">
                            <option value="">-- Select Category --</option>
                            @foreach ($category as $cat)
                                <option value="{{ $cat->category }}"
                                    {{ request('category_filter') == $cat->category ? 'selected' : '' }}>
                                    {{ $cat->category }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_filter')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-3 col-sm-4 mb-3">
                        <input type="number" class="form-control" name="bill_no" placeholder="Search By Bill No.">
                    </div>
                    <div class="col-md-3 col-sm-4 mb-3">
                        <input type="text" class="form-control" name="s_name" placeholder="Search By Name">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary me-1">Search</button>
                        <a href="{{ route('bill-list') }}" class="btn btn-info text-white me-1">Reset</a>
                    </div>
                </form>

            </div>
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Project / Work Category</th>
                                <th>Project / Work Name</th>
                                <th>Bill No.</th>
                                <th>Bill Date</th>
                                <th>Name</th>
                                <th>Shop/Farm</th>
                                <th>Address</th>
                                <th>Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($record as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->work_category }}</td>
                                    <td>{{ $item->work_name }}</td>
                                    <td>{{ $item->bill_no }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }} </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->shop }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>{{ $item->academic_session ?? 'N/A' }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ route('view-bill', $item->id) }}"
                                                class="btn btn-success btn-sm px-3">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            <a href="{{ route('edit-bill', $item->id) }}" class="btn btn-primary btn-sm"
                                                title="Edit">
                                                <i class="fa-regular fa-edit"></i>
                                            </a>
                                            <a href="{{ route('delete-bill', $item->id) }}" class="btn btn-danger btn-sm "
                                                onclick="return confirm('Do you want to delete Bill')" title="Delete">
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
