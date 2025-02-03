@extends('home.layout.MasterLayout')
@Section('content')
    <div class="row card  m-5">
        <div class="col m-3 d-flex justify-content-center">
            <h3><u><b>ACTIVITY</b></u></h3>
        </div>
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
                        <th scope="col">View</th>
                      </tr>
                    </thead>
                    <tbody>
                        {{-- @php
                        $previousMonth = null;
                      @endphp
                      @foreach ($activity as $item)
                        @php
                          $currentMonth = \Carbon\Carbon::parse($item->program_date)->format('F Y'); // Format as Month Year
                        @endphp
                  
                        @if ($currentMonth !== $previousMonth)
                          <!-- New month row, add month title -->
                          <tr>
                            <td colspan="7" class="text-center font-weight-bold" style="background-color: #f0f8ff;">
                              {{ $currentMonth }}
                            </td>
                          </tr>
                        @endif --}}
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
                                <a href=" {{ route('viewactivity') }}" class="btn btn-sm bg-success me-2">
                                    <i class="fa-regular fa-eye"></i></a>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection