@extends('admin.layout.AdminLayout')
@Section('content')
    <div class="row card  m-5">
        <div class="col m-3 d-flex justify-content-center">
            <h3><u><b>ACTIVITY</b></u></h3>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <a href="{{ 'addactivity' }}" class="btn btn-success float-right">Add Activity</a>

        </div>
        <div class="row m-3">
            <div class="col">
                <div class="">
                    <table class="table border">
                        <thead>
                            <tr class=" table-primary">
                                <th scope="col">Sr.No.</th>
                                <th scope="col">Date/Time</th>
                                <th scope="col">Program Image</th>
                                <th scope="col">Program Name</th>
                                <th scope="col">Program Category</th>
                                <th scope="col">Program Address</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activity as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->program_date)->format('d-m-Y') }}
                                        <br> {{ $item->program_time }}
                                    </td>
                                    <td><img src="{{ asset('program_images/'.$item->program_image) }}" width="200px" height="100px" alt="image"></td>
                                    <td>{{ $item->program_name }}</td>
                                    <td>{{ $item->program_category }}</td>
                                    <td>{{ $item->program_address }}</td>
                                    <td> 
                                        <a href="" class="btn btn-sm bg-success me-2">
                                            <i class="fa-regular fa-eye"></i></a>
                                        <a href="{{-- 'editslider/'.$item->id --}}" class="btn btn-sm bg-primary me-2">
                                        <i class="fa-regular fa-pen-to-square"></i></a>
                                        <a href="{{-- 'removeslider/'.$item->id --}}" class="btn btn-sm bg-danger me-2">
                                            <i class="fa-regular fa-trash-can"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
