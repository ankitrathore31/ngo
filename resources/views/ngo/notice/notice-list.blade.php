@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between aligin-item-center mb-3 mt-2">
            <h5 class="mb-0">Notice List</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Notice</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="containert-fluid">
            <div class="card rounded m-3">
                <div class="card-body responsive-table">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Date</th>
                                <th>Notice For</th>
                                <th>Notice</th>
                                <th>Status</th>
                                <th>Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notice as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \carbon\carbon::parse($item->date)->format('d-m-Y') }}</td>
                                    <td>{{ $item->notice_for }}</td>
                                    <td>{{ $item->notice }}</td>
                                    <td>{{ $item->notice == 1 ? 'Showed' : 'Hide' }}</td>
                                    <td>{{ $item->academic_session }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ route('notice-status', $item->id) }}" class="btn btn-sm btn-success" title="status">
                                                {{$item->status == 1 ? 'Showed' : 'Hide' }}
                                            </a>

                                            <a href="{{ route('view-notice', $item->id) }}" class="btn btn-sm btn-info" title="view">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>

                                            <a href="{{ route('edit-notice', $item->id) }}" class="btn btn-sm btn-Primary" title="Edit">
                                                <i class="fa-regular fa-edit"></i>
                                            </a>

                                            <a href="{{ route('delete-notice', $item->id) }}" class="btn btn-sm btn-danger" title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this notice?')">
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
