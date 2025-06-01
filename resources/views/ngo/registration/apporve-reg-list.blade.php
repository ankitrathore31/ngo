@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Approve Registraition List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Approve List</li>
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
                                {{-- @foreach (Session::get('all_academic_session') as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach --}}
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
                    <a href="{{ route('registration') }}" class="btn btn-success btn-sm">+ New Registraition</a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr> 
                                <th>Sr. No.</th>                               
                                <th>Application Date</th>
                                <td>Application No.</td>
                                <th>Registration No.</th>
                                <th>Registration Date.</th>
                                <th>Name</th>
                                <th>Father/Husband Name</th>
                                <th>Number</th>
                                <th>Type</th>
                                <th>Session</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($approvebeneficiarie as $item)
                                <tr>
                                   <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->application_date)->format('d-m-Y') }}<br>
                                    </td>
                                    <td>{{ $item->application_no }}</td>
                                    <td>{{ $item->registration_no }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->registraition_date)->format('d-m-Y') }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->gurdian_name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->reg_type }}</td>
                                     <td>{{$item->academic_session}}</td>
                                    <td>
                                        @if ($item->status == 1)
                                            Approve
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">

                                            <a href="{{ route('show-apporve-reg', $item->id )}}"
                                                class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="View" style="min-width: 38px; height: 38px;">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>

                                            <a href="#"
                                                class="btn btn-primary btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="Edit" style="min-width: 38px; height: 38px;">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>

                                            <a href=" {{ route('delete-view', $item->id) }}"
                                                class="btn btn-danger btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="Delete" style="min-width: 38px; height: 38px;">
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
