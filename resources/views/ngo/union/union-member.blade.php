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
                <h5 class="mb-0">Union Member List</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{-- url('dashboard') --}}">Union</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Union Member List</li>
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
                <form method="GET" action="{{ route('union.member.list') }}" class="row g-3 mb-4">

                    <div class="col-md-3">
                        <select name="union_id" class="form-control">
                            <option value="">All Unions</option>
                            @foreach ($unions as $union)
                                <option value="{{ $union->id }}"
                                    {{ request('union_id') == $union->id ? 'selected' : '' }}>
                                    {{ $union->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select name="member_by" class="form-control">
                            <option value="">Added By (All)</option>
                            @foreach ($members as $member)
                                <option value="{{ $member->id }}"
                                    {{ request('member_by') == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }} ( {{ $member->position }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Search</button>
                        <a href="{{ route('union.member.list') }}" class="btn btn-info text-white">Reset</a>
                    </div>

                </form>
            </div>

            <div class="card shadow-sm">
                <div class="card-body table-responsive">

                    @if ($unionMembers->count() > 0)
                        <table class="table table-bordered table-hover text-center">
                            <thead class="table-primary">
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Union Name</th>
                                    <th>Application Date</th>
                                    <th>Application No.</th>
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
                                    <th>Join Date</th>
                                    <th>Expiry Date</th>
                                    <th>Added By</th>
                                    <th>Union Membership</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($unionMembers as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->union->name ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->member->application_date)->format('d-m-Y') }}
                                        </td>
                                        <td>{{ $item->member->application_no }}</td>

                                        <td>
                                            <img src="{{ asset('member_images/' . $item->member->image) }}" width="80">
                                        </td>

                                        <td>{{ $item->member->name }}</td>
                                        <td>{{ $item->member->gurdian_name }}</td>
                                        <td>{{ $item->member->position_type ?? 'No Found' }}</td>
                                        <td>{{ $item->member->position ?? 'No Found' }}</td>
                                        <td>
                                            {{ $item->member->village }},
                                            {{ $item->member->post }},
                                            {{ $item->member->block }},
                                            {{ $item->member->district }},
                                            {{ $item->member->state }} - {{ $item->member->pincode }}
                                        </td>

                                        <td>{{ $item->member->caste }}</td>
                                        <td>{{ $item->member->religion_category }}</td>
                                        <td>{{ $item->member->religion }}</td>
                                        <td>{{ $item->member->phone }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->join_date)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->expiry_date)->format('d-m-Y') }}</td>
                                        <td>
                                            {{ optional(\App\Models\Member::find($item->member_by))->name ?? 'NGO' }}
                                            ({{ optional(\App\Models\Member::find($item->member_by))->position ?? ' ' }} )
                                        </td>
                                        <td>
                                            @php
                                                $isExpired = \Carbon\Carbon::parse($item->expiry_date)->isPast();
                                            @endphp

                                            @if ($isExpired)
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#renewModal{{ $item->id }}">
                                                    Renew Membership
                                                </button>
                                            @else
                                                <span class="badge bg-success">Active</span>
                                            @endif
                                        </td>
                                        <td><a href="{{-- route('view-member', $item->id) --}}"
                                                class="btn btn-success btn-sm mb-1 px-3 d-flex align-items-center justify-content-center"
                                                title="View">
                                                <i class="fa-regular fa-eye"></i>
                                            </a><a href="{{ route('union.member.certificate', $item->id) }}"
                                                class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="View">
                                                Certificate
                                            </a></td>
                                    </tr>
                                    <div class="modal fade" id="renewModal{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <form action="{{ route('renew.union.member', $item->id) }}" method="POST">
                                                    @csrf

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            Renew Membership
                                                        </h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body text-center">

                                                        <p>
                                                            Are you sure you want to renew membership for
                                                            <strong>{{ $item->member->name ?? '' }}</strong>?
                                                        </p>

                                                        <p class="text-danger">
                                                            Expired on:
                                                            {{ \Carbon\Carbon::parse($item->expiry_date)->format('d-m-Y') }}
                                                        </p>

                                                        <p>
                                                            New expiry date will be:
                                                            <strong>
                                                                {{ \Carbon\Carbon::today()->addYear()->format('d-m-Y') }}
                                                            </strong>
                                                        </p>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">
                                                            Yes, Renew
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
                        <div class="alert alert-warning text-center">
                            No union members found.
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>

@endsection
