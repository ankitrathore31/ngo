@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Demand Beneficiarie List For Facilities</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Demand Beneficiarie List</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Registration No.</th>
                                <th>Name</th>
                                <th>Father/Husband Name</th>
                                <th>Address</th>
                                <th>Identity No.</th>
                                <th>Identity Type</th>
                                <th>Mobile No.</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Religion</th>
                                <th>Age</th>
                                <th>Survey Date</th>
                                <th>Survey Details</th>
                                <th>Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php $srNo = 1; @endphp
                        <tbody>
                            @foreach ($surveys as $survey)
                                @php $item = $survey->beneficiarie; @endphp
                                <tr>
                                    <td>{{ $srNo++ }}</td>
                                    <td>{{ $item->registration_no ?? 'No Found'}}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->gurdian_name }}</td>
                                    <td>{{ $item->village }}, {{ $item->post }}, {{ $item->block }},
                                        {{ $item->district }}, {{ $item->state }} - {{ $item->pincode }},
                                        ({{ $item->area_type }})</td>
                                    <td>{{ $item->identity_no }}</td>
                                    <td>{{ $item->identity_type }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->caste }}</td>
                                    <td>{{ $item->religion_category }}</td>
                                    <td>{{ $item->religion }}</td>
                                    <td>{{ $item->dob ? \Carbon\Carbon::parse($item->dob)->age . ' years' : 'Not Found' }}
                                    </td>
                                    <td>{{ $survey->survey_date ? \Carbon\Carbon::parse($survey->survey_date)->format('d-m-Y') : 'Not Found' }}
                                    </td>
                                    <td>{{ $survey->survey_details }}</td>
                                    <td>{{ $item->academic_session }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ route('add-beneficiarie-facilities', [$item->id, $survey->id]) }}"
                                                class="btn btn-primary btn-sm px-3">+ Facilities</a>

                                            <a href="{{ route('show-beneficiarie-survey', [$item->id, $survey->id]) }}"
                                                class="btn btn-success btn-sm px-3"><i class="fa-regular fa-eye"></i>
                                                Survey</a>

                                            <a href="{{ route('delete-survey', [$item->id, $survey->id]) }}"
                                                class="btn btn-danger btn-sm px-3"
                                                onclick="return confirm('Are you sure want to delete survey?')">
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
