@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Approve Training Beneficiarie List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Approve Beneficiaries </li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="card shadow p-2 bg-primary">
                        <div class="card-body text-white text-center">
                            <div class="card-title">
                                <b>Total Training Beneficiaries:</b>
                            </div>
                            <div class="card-text">
                                {{ $record->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">

                        <thead class="table-primary">
                            <tr>
                                <th>Roll No.</th>
                                <th>Training Center Code</th>
                                <th>Training Center Name</th>
                                <th>Training Center Address</th>
                                <th>Center Incharge</th>
                                <th>Registration No.</th>
                                <th>Learner Name</th>
                                <th>Father/Husband Name</th>
                                <th>Learner Address</th>
                                <th>Mobile No.</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Religion</th>
                                <th>Age</th>
                                {{-- <th>Center Code</th> --}}
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
                                    <td>{{ $item->center->center_code }}</td>
                                    <td>{{ $item->center->center_name }}</td>
                                    <td>{{ $item->center->center_address }},{{ $item->center->post }},{{ $item->center->town }}
                                        ,{{ $item->center->district }},{{ $item->center->state }}
                                    </td>
                                    <td>{{ \App\Models\Staff::find($item->center->incharge)->name ?? '' }}</td>
                                    <td>{{ $item->beneficiare->registration_no ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->name ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->gurdian_name ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->village ?? '' }},
                                        {{ $item->beneficiare->post ?? '' }},
                                        {{ $item->beneficiare->block ?? '' }},
                                        {{ $item->beneficiare->district ?? '' }},
                                        {{ $item->beneficiare->state ?? '' }} - {{ $item->beneficiare->pincode ?? '' }}
                                    </td>
                                    <td>{{ $item->beneficiare->phone ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->caste ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->religion_category ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->religion ?? 'N/A' }}</td>
                                    <td>{{ $item->beneficiare->dob ? \Carbon\Carbon::parse($item->beneficiare->dob)->age . ' years' : 'Not Found' }}
                                    </td>
                                    {{-- <td>{{ $item->center_code}}</td> --}}
                                    <td>{{ $item->facilities_category ?? 'N/A' }}</td>
                                    <td>{{ \App\Models\Course::find($item->training_course)->course ?? '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->start_date)->format('d-m-Y') }} To
                                        {{ \Carbon\Carbon::parse($item->end_date)->format('d-m-Y') }}
                                    </td>
                                    <td>{{ $item->duration }}</td>
                                    <td>{{ $item->beneficiare->academic_session ?? 'N/A' }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ route('show-approve-bene-training', ['id' => $item->id, 'center_code' => $item->center_code]) }}"
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
