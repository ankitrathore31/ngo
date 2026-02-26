@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Position Member List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Position Member List</li>
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
                                <td>Application No.</td>
                                <th>Registration No.</th>
                                <th>Name</th>
                                <th>Father/Husband Name</th>
                                <th>Address</th>
                                <th>Position Type</th>
                                <th>Position</th>
                                <th>Working Area</th>
                                <th>Identity No.</th>
                                <th>Identity Type</th>
                                <th>Mobile No.</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Religion</th>
                                <th>Age</th>
                                <th>Status</th>
                                <th>Session</th>
                                <th>Action</th>
                                <th>Certificate</th>
                                <th>Letter</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($member as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->application_no }}</td>
                                    <td>{{ $item->registration_no ?? 'Not Found' }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->gurdian_name }}</td>
                                    <td>{{ $item->village }},
                                        {{ $item->post }},
                                        {{ $item->block }},
                                        {{ $item->district }},
                                        {{ $item->state }} - {{ $item->pincode }},
                                        ({{ $item->area_type }})
                                    </td>
                                    <td>{{ $item->position_type ?? 'No Found' }}</td>
                                    <td>{{ $item->position ?? 'No Found' }}</td>
                                    <td>{{ $item->working_area ?? 'No Found' }}</td>
                                    <td>{{ $item->identity_no }}</td>
                                    <td>{{ $item->identity_type }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->caste }}</td>
                                    <td>{{ $item->religion_category }}</td>
                                    <td>{{ $item->religion }}</td>
                                    <td>
                                        {{ $item->dob ? \Carbon\Carbon::parse($item->dob)->age . ' years' : 'Not Found' }}
                                    </td>
                                    <td>
                                        @if ($item->status == 1)
                                            Approve
                                        @endif
                                    </td>
                                    <td>{{ $item->academic_session }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">

                                            <a href="{{ route('show-member', $item->id) }}" class="btn btn-success btn-sm"
                                                title="View">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>

                                            @if ($item->email && !in_array($item->email, $existingUserEmails))
                                                <form action="{{ route('member.add-user', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm"
                                                        onclick="return confirm('Create login account for this member?')">
                                                        Add User
                                                    </button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('member-certi', $item->id) }}"
                                            class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                            title="View" style="min-width: 38px; height: 38px;">
                                            Certificate
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('member-letter', $item->id) }}"
                                            class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                            title="View" style="min-width: 38px; height: 38px;">
                                            Letter
                                        </a>
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
