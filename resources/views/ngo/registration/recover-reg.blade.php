@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3 m-2">
                <h5 class="mb-0">Deleted Registraition List</h5>

                <!-- Breadcrumb aligned to right -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Deleted List</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="container-fluid my-4 mt-3">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Application Date</th>
                                <th>Application No.</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Delete Date</th>
                                <th>Reason for Deletion</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deletedBeneficiaries as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->application_date)->format('d-m-Y') }}<br>
                                    </td>
                                    <td>{{ $item->application_no }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->delete_date)->format('d-m-Y') }}<br>
                                    </td>
                                    <td>{{ $item->delete_reason }}</td>
                                    <td>
                                        <a href="{{ route('recover-item', $item->id) }}"
                                            class="btn btn-success btn-sm">
                                            Recover
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
