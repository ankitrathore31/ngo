@extends('home.layout.MasterLayout')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Working Area</h5>

                <!-- Breadcrumb aligned to right -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Working Area</li>
                    </ol>
                </nav>
            </div>

            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">

                    <a href="{{ route('welcome') }}" class="btn btn-success btn-sm">Back</a>
                </div>

                <div class="card-body table-responsive">
                        <div class="row d-flex justify-content-end">
                            <div class="col-sm-6">
                                <h6>Showing Areas for: <span class="text-primary">{{ $text }}</span></h6>
                            </div>
                            <div class="col-sm-6 text-end d-flex justify-content-end">
                                <h6>Total Areas: <span class="text-primary">{{ $totalarea}}</span></h6>
                            </div>
                        </div>

                        <table class="table table-bordered table-hover align-middle text-center mt-3">
                            <thead class="table-primary">
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Session</th>
                                    <th>Area Type</th>
                                    <th>Area</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($area as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->academic_session }}</td>
                                        <td>{{ $item->area_type }}</td>
                                        <td>{{ $item->area }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                </div>
            </div>
        </div>

    </div>
@endsection
