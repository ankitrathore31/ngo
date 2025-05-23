@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Pending Registraition List</h5>

                <!-- Breadcrumb aligned to right -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pending List</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
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

                                <th>Application Date</th>
                                <th>Application No.</th>
                                <th>Name</th>
                                <th>Number</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingbene as $item)
                                <tr>

                                    <td>
                                        {{ \Carbon\Carbon::parse($item->application_date)->format('d-m-Y') }}<br>
                                    </td>
                                    <td>{{ $item->application_no }}</td>
                                    <td>{{ $item->name }}</td>
                                    {{-- <td>
                                        @php
                                            $imagePath = '';
                                            if ($item->reg_type === 'beneficiaries') {
                                                $imagePath = 'benefries_images/' . $item->image;
                                            } elseif ($item->reg_type === 'member') {
                                                $imagePath = 'member_images/' . $item->image;
                                            }
                                        @endphp

                                        <img src="{{ asset($imagePath) }}" alt="image" class="img-thumbnail"
                                            width="100">

                                    </td> --}}
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->reg_type }}</td>
                                    <td>
                                        @if ($item->status == 0)
                                            Pending
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">

                                            {{-- <form action="{{ route('approve-status', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm px-3"
                                                    style="min-width: 100px; height: 38px;">Approve</button>
                                            </form> --}}

                                            <a href="{{ route('edit-reg', $item->id) }}"
                                                class="btn btn-primary btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="Edit" style="min-width: 38px; height: 38px;">
                                                {{-- <i class="fa-regular fa-pen-to-square"></i> --}}Approve
                                            </a>

                                            <a href="{{ route('view-reg', $item->id) }}"
                                                class="btn btn-success btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="View" style="min-width: 38px; height: 38px;">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>

                                            <!-- Delete Button Triggering Modal -->
                                            <a href="#"
                                                class="btn btn-danger btn-sm px-3 d-flex align-items-center justify-content-center"
                                                title="Delete" style="min-width: 38px; height: 38px;" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $item->id }}">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('delete-reg', $item->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $item->id }}">Confirm
                                                                    Deletion</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Are you sure you want to delete this record?</p>
                                                                <div class="mb-3">
                                                                    <label for="reason{{ $item->id }}"
                                                                        class="form-label">Reason for deletion</label>
                                                                    <textarea class="form-control" id="reason{{ $item->id }}" name="reason" rows="3" required></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">Confirm
                                                                    Delete</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

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
    <script>
        function toggleDeleteForm(id) {
            const form = document.getElementById(`delete-form-${id}`);
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }
    </script>
@endsection
