@extends($layout)
@Section('content')
    <style>
        .hover-card {
            transition: all 0.3s ease-in-out;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            background-color: #f9fafb;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
    <div class="wrapper">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Member Registraition List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{-- url('dashboard') --}}">Union</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Member List</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->has('member_id'))
                <div class="alert alert-danger">
                    {{ $errors->first('member_id') }}
                </div>
            @endif
            <div class="row">
                <form method="GET" action="{{ route('union.reg.list') }}" class="row g-3 mb-4">
                    <div class="row">
                        <div class="col-md-3 col-sm-4">
                            <select name="session_filter" id="session_filter" class="form-control">
                                <option value="">All Sessions</option>
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-4 mb-3">
                            <input type="number" class="form-control" name="application_no"
                                placeholder="Search By Application/Registration No.">
                        </div>
                        <div class="col-md-3 col-sm-4 mb-3">
                            <input type="number" class="form-control" name="registration_no"
                                placeholder="Search By Mobile/Idtinty No.">
                        </div>
                        <div class="col-md-3 col-sm-4 mb-3">
                            <input type="text" class="form-control" name="name"
                                placeholder="Search By Person/Guardian's Name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary me-1">Search</button>
                            <a href="{{ route('union.reg.list') }}" class="btn btn-info text-white me-1">Reset</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card shadow-sm">
                <div class="card-body table-responsive">

                    @if ($approvemember->count() > 0)
                        <table class="table table-bordered table-hover align-middle text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Application Date</th>
                                    <th>Application No.</th>
                                    <th>Registration Date</th>
                                    <th>Registration No.</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Father/Husband Name</th>
                                    <th>Position Type</th>
                                    <th>Position</th>
                                    <th>Address</th>
                                    <th>Caste</th>
                                    <th>Caste Category</th>
                                    <th>Religion</th>
                                    <th>Mobile No.</th>
                                    <th>Session</th>
                                    <th>Add Member</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($approvemember as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->application_date)->format('d-m-Y') }}</td>
                                        <td>{{ $item->application_no }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->registration_date)->format('d-m-Y') }}</td>
                                        <td>{{ $item->registration_no }}</td>

                                        <td>
                                            <img src="{{ asset('member_images/' . $item->image) }}" width="80">
                                        </td>

                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->gurdian_name }}</td>
                                        <td>{{ $item->position_type ?? 'No Found' }}</td>
                                        <td>{{ $item->position ?? 'No Found' }}</td>
                                        <td>
                                            {{ $item->village }},
                                            {{ $item->post }},
                                            {{ $item->block }},
                                            {{ $item->district }},
                                            {{ $item->state }} - {{ $item->pincode }}
                                        </td>

                                        <td>{{ $item->caste }}</td>
                                        <td>{{ $item->religion_category }}</td>
                                        <td>{{ $item->religion }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->academic_session }}</td>

                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#addUnionModal{{ $item->id }}">
                                                Add to Union
                                            </button>
                                        </td>
                                    </tr>

                                    {{-- Modal For This Member --}}
                                    <div class="modal fade" id="addUnionModal{{ $item->id }}" tabindex="-1">

                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <form action="{{ route('store.union.member') }}" method="POST">
                                                    @csrf

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            Add {{ $item->name }} to Union
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">

                                                        <input type="hidden" name="member_id" value="{{ $item->id }}">
                                                        <input type="hidden" name="member_by" value="{{ $member_by }}">
                                                        <div class="mb-3">
                                                            <label>Select Union</label>
                                                            <select name="union_id" class="form-control" required>
                                                                <option value="">Select Union</option>
                                                                @foreach ($unions as $union)
                                                                    <option value="{{ $union->id }}">
                                                                        {{ $union->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label>Join Date</label>
                                                            <input type="date" name="join_date"
                                                                value="{{ date('Y-m-d') }}" class="form-control" required>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">
                                                            Save
                                                        </button>
                                                    </div>

                                                </form>

                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-warning text-center mb-0">
                            No records found for the selected search criteria.
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

@endsection
