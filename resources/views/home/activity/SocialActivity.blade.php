@extends('home.layout.MasterLayout')
@Section('content')
    <div class="container-fluid bg-white">
        <div class="row d-flex justify-content-end">
            <div class="col-auto  mb-3">
                <nav aria-label="breadcrumb  bg-white">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Social Activity</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row m-3">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-white">
                        <tr class=" bg-success">
                            <th scope="col">Sr.No.</th>
                            <th scope="col">Date/Time</th>
                            <th scope="col">Program Image</th>
                            <th scope="col">Program Name</th>
                            <th scope="col">Program Category</th>
                            <th scope="col">Program Address</th>
                            <th scope="col">View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activity as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->program_date)->format('d-m-Y') }}
                                    <br> {{ $item->program_time }}
                                </td>
                                <td><img src="{{ asset('program_images/' . $item->program_image) }}" width="200px"
                                        height="100px" alt="image"></td>
                                <td>{{ $item->program_name }}</td>
                                <td>{{ $item->program_category }}</td>
                                <td>{{ $item->program_address }}</td>
                                <td>
                                    <a href="{{ 'viewreport/' . $item->id }}" class="btn btn-sm bg-success me-2">
                                        <i class="fa-regular fa-eye"></i></a>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
