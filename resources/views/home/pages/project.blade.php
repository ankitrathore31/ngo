@extends('home.layout.MasterLayout')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row d-flex justify-content-end">
                <div class="col-auto  mb-3">
                    <nav aria-label="breadcrumb  bg-white">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Project</li>
                        </ol>
                    </nav>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('project') }}" class="row g-3 mb-4">
                        <div class="col-md-4">
                            {{-- <label for="session_filter" class="form-label">Select Session</label> --}}
                            <select name="session_filter" id="session_filter" class="form-control">
                                <option value="">All Sessions</option> <!-- Default option to show all -->
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-sm-6 form-group mb-3">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                placeholder="Search by Project Name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary me-2">Search</button>
                            <a href="{{ route('project') }}" class="btn btn-info text-white me-2">Reset</a>
                        </div>
                    </form>
                    {{-- <button onclick="printTable()" class="btn btn-primary mb-3">Print Table</button> --}}
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body table-responsive printable">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Session</th>
                                <th>Project Image</th>
                                <th>Project Code</th>
                                <th>project / Work Name</th>
                                <th>Project / Work Category</th>
                                <th>Project Detail</th>
                                <th>Session</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($project as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->academic_session }}</td>
                                    <td>
                                        <img src="{{ asset($item->image) }}" alt="image" class="img-thumbnail"
                                            width="100">
                                    </td>
                                    <td>{{ $item->code }}</td>
                                    <td>
                                        {{ $item->name }}</small>
                                    </td>
                                    <td>{{ $item->category }}</td>
                                    <td>{{ $item->sub_category }}</td>
                                    <td>{{ $item->academic_session }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
