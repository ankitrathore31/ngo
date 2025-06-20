@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Genrate Training Beneficiarie List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Genrate Certificate </li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                <form method="GET" action="{{ route('genrate-training-certi') }}" class="row g-3 mb-4">
                    <div class="col-md-3 col-sm-4">
                        <select name="session_filter" id="session_filter" class="form-control"
                            onchange="this.form.submit()">
                            <option value="">All Sessions</option>
                            @foreach ($session as $session)
                                <option value="{{ $session->session_date }}"
                                    {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                    {{ $session->session_date }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-4 mb-3">
                        <input type="number" class="form-control" name="application_no"
                            placeholder="Search By Application No.">
                    </div>
                    <div class="col-md-3 col-sm-4 mb-3">
                        <input type="text" class="form-control" name="name" placeholder="Search By Name">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary me-1">Search</button>
                        <a href="{{ route('genrate-training-certi') }}" class="btn btn-info text-white me-1">Reset</a>
                    </div>
                </form>

            </div>
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                {{-- <td>Application No.</td> --}}
                                <th>Registration No.</th>
                                <th>Name</th>
                                <th>Father/Husband Name</th>
                                <th>Address</th>
                                {{-- <th>Identity No.</th>
                                <th>Identity Type</th> --}}
                                <th>Mobile No.</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Religion</th>
                                {{-- <th>Age</th> --}}
                                <th>Center Code</th>
                                <th>Facilities Category</th>
                                <th>Training Course</th> 
                                <th>Start Date & End Date</th>
                                <th>Course Duration</th>
                                <th>Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($record as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    {{-- <td>{{ $item->beneficiare->application_no ?? 'N/A' }}</td> --}}
                                    <td>{{ $item->beneficiare->registration_no ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->name ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->gurdian_name ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->village ?? '' }},
                                        {{ $item->beneficiare->post ?? '' }},
                                        {{ $item->beneficiare->block ?? '' }},
                                        {{ $item->beneficiare->district ?? '' }},
                                        {{ $item->beneficiare->state ?? '' }} - {{ $item->beneficiare->pincode ?? '' }}
                                    </td>
                                    {{-- <td>{{ $item->beneficiare->identity_no ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->identity_type ?? 'N/A' }}</td> --}}
                                    <td>{{ $item->beneficiare->phone ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->caste ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->religion_category ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->religion ?? 'N/A' }}</td>
                                    {{-- <td>{{ $item->beneficiare->dob ? \Carbon\Carbon::parse($item->beneficiare->dob)->age . ' years' : 'Not Found' }}
                                    </td> --}}
                                    <td>{{ $item->center_code}}</td>
                                    <td>{{ $item->facilities_category ?? 'N/A' }}</td>
                                    <td>{{ $item->training_course ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d-m-Y')}} To {{ \Carbon\Carbon::parse($item->end_date)->format('d-m-Y')}}
                                    </td> 
                                    <td>{{$item->duration}}</td>
                                    <td>{{ $item->beneficiare->academic_session ?? 'N/A' }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ route('genrate-training-certificate', $item->id) }}" class="btn btn-success btn-sm px-3"
                                            >
                                            Genrate Certificate
                                            </a>
                                            <a href="{{ route('show-approve-bene-training', $item->id) }}"
                                                class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="View" style="min-width: 38px; height: 38px;">
                                                <i class="fa-regular fa-eye"></i>
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
