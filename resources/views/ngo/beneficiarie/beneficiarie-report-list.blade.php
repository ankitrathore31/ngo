@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Beneficiarie Report List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Beneficiarie Report List</li>
                    </ol>
                </nav>
            </div>

            <div class="card shadow-sm">
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
                                <th>Survey Date</th>
                                <th>Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($beneficiarie as $item)
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
                                    <td>{{ \Carbon\Carbon::parse($item->survey_date)->format('d-m-Y') }}</td>
                                     <td>{{$item->academic_session}}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                           
                                            <a href="{{ route('show-beneficiarie-report', $item->id ) }}"
                                                class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="View" style="min-width: 38px; height: 38px;">
                                                <i class="fa-regular fa-eye me-1"></i> Report
                                            </a>
                        
                                            {{-- <a href="{{ route('show-beneficiarie-report', $item->id ) }}"
                                                class="btn btn-primary btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="Edit" style="min-width: 38px; height: 38px;">
                                                <i class="fa-regular fa-edit"></i>
                                            </a> --}}

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
