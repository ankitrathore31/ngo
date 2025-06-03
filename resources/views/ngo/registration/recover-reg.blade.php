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
                                <td>Application No.</td>
                                <th>Registration Date.</th>
                                <th>Registration No.</th>
                                <th>Name</th>
                                <th>Father/Husband Name</th>
                                <th>Address</th>
                                <th>Mobile No.</th>
                                <th>Caste</th>
                                <th>Caste Category</th>
                                <th>Religion</th>
                                <th>Registration Type</th>
                                <th>Delete Date</th>
                                <th>Reason for Deletion</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deletedBeneficiaries as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                   <td>{{ $item->name }}</td>
                                    <td>{{ $item->gurdian_name}}</td>
                                    <td>{{ $item->village }},
                                            ({{ $item->area_type }})
                                            ,
                                            {{ $item->post }},
                                            {{ $item->block }},
                                            {{ $item->district }},
                                            {{ $item->state }} - {{ $item->pincode }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{$item->caste}}</td>
                                    <td>{{$item->religion_category}}</td>
                                    <td>{{$item->religion}}</td>
                                    <td>{{ $item->reg_type ?? 'Member' }}</td>
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
