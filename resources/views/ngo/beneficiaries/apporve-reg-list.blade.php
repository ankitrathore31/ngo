@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Apporve Registraition List</h5>

                <!-- Breadcrumb aligned to right -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Registraition List</li>
                    </ol>
                </nav>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <form method="GET" action="{{-- route('') --}}" class="row g-3 mb-4">
                        <div class="col-md-4">
                            {{-- <label for="session_filter" class="form-label">Select Session</label> --}}
                            <select name="session_filter" id="session_filter" class="form-control"
                                onchange="this.form.submit()">
                                <option value="">All Sessions</option> <!-- Default option to show all -->
                                @foreach (Session::get('all_academic_session') as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 d-flex">
                            <button type="submit" class="btn btn-primary me-2">Search</button>
                            <a href="{{-- route('') --}}" class="btn btn-info text-white me-2">Reset</a>
                        </div>
                    </form>
                </div>
            </div>


            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('registraition') }}" class="btn btn-success btn-sm">+ New Registraition</a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Registration No.</th>
                                <th>Appointment Date</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Number</th>
                                <th>Session</th>
                                <th>Action</th>
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
