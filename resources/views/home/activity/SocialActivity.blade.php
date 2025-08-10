@extends('home.layout.MasterLayout')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid bg-white">
            <div class="row d-flex justify-content-end">
                <div class="col-auto  mb-3">
                    <nav aria-label="breadcrumb  bg-white">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Social Activity/Work</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-between mb-5">
                <div class="col-sm-4 text-start">
                    <span class="p-1" style="font-size: 25px; font-weight: 500;">
                        Total Activity: <strong>{{ $activity->count() }}</strong>
                    </span>
                </div>
                <div class="col-sm-8" style="font-size: 25px; font-weight: 500;">
                    Social Activity / Work
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form method="GET" action="{{ route('activity') }}" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <select name="session_filter" id="session_filter" class="form-control">
                            <option value="">All Sessions</option>
                            @foreach (Session::get('all_academic_session') as $session)
                                <option value="{{ $session->session_date }}"
                                    {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                    {{ $session->session_date }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <select id="category_filter" name="category_filter"
                            class="form-control @error('category_filter') is-invalid @enderror">
                            <option value="">-- Select Project/Work Category --</option>
                            @foreach ($category as $cat)
                                <option value="{{ $cat->category }}"
                                    {{ request('category_filter') == $cat->category ? 'selected' : '' }}>
                                    {{ $cat->category }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_filter')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 col-sm-6 form-group mb-3">
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                            placeholder="Search by Project / Work Name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 col-sm-6 form-group mb-3">
                        <input type="text" name="address_filter" id="address"
                            class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}"
                            placeholder="Search by Address">
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary me-2">Search</button>
                        <a href="{{ route('activity') }}" class="btn btn-info text-white me-2">Reset</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="row m-3">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="text-white">
                            <tr class=" bg-success">
                                <th scope="col">Sr.No.</th>
                                <th>Session</th>
                                <th scope="col">Date/Time</th>
                                <th scope="col">Program Image</th>
                                <th scope="col">Program Name</th>
                                <th scope="col">Program Category</th>
                                <th scope="col">Program Address</th>
                                <td>Program Session</td>
                                <th scope="col">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activity as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->academic_session }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->program_date)->format('d-m-Y') }}
                                        <br> {{ $item->program_time }}
                                    </td>
                                    <td><img src="{{ asset('program_images/' . $item->program_image) }}" width="200px"
                                            height="100px" alt="image"></td>
                                    <td>{{ $item->program_name }}</td>
                                    <td>{{ $item->program_category }}</td>
                                    <td>{{ $item->program_address }}</td>
                                    <td>{{ $item->academic_session }}</td>
                                    <td>
                                        <a href="{{ route('viewreport', ['id' => $item->id]) }}"
                                            class="btn btn-sm bg-success me-2">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
