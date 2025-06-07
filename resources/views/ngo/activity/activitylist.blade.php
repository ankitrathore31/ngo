@extends('ngo.layout.master')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Activity List</h5>

                <!-- Breadcrumb aligned to right -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Activity List</li>
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
                    <form method="GET" action="{{ route('activitylist') }}" class="row g-3 mb-4">
                        <div class="col-md-4">
                            {{-- <label for="session_filter" class="form-label">Select Session</label> --}}
                            <select name="session_filter" id="session_filter" class="form-control"
                                onchange="this.form.submit()">
                                <option value="">All Sessions</option> <!-- Default option to show all -->
                                @foreach (Session::get('all_academic_session') as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-4">
                            {{-- <label for="category_filter" class="form-label">Search by Category</label> --}}
                            <select id="category_filter" name="category_filter"
                                class="form-control @error('category_filter') is-invalid @enderror" onchange="this.form.submit()">
                                <option value="">-- Select Category --</option>
                                <option value="Public Program"
                                    {{ request('category_filter') == 'Public Program' ? 'selected' : '' }}>Public Program
                                </option>
                                <option value="Government Program"
                                    {{ request('category_filter') == 'Government Program' ? 'selected' : '' }}>Government
                                    Program</option>
                                <option value="Education" {{ request('category_filter') == 'Education' ? 'selected' : '' }}>
                                    Education</option>
                                <option value="Environment"
                                    {{ request('category_filter') == 'Environment' ? 'selected' : '' }}>Environment</option>
                                <option value="Social Awareness Program"
                                    {{ request('category_filter') == 'Social Awareness Program' ? 'selected' : '' }}>Social
                                    Awareness Program</option>
                                <option value="Cultural Program"
                                    {{ request('category_filter') == 'Cultural Program' ? 'selected' : '' }}>Cultural
                                    Program</option>
                                <option value="Sanitation Program"
                                    {{ request('category_filter') == 'Sanitation Program' ? 'selected' : '' }}>Sanitation
                                    Program</option>
                                <option value="Health Program"
                                    {{ request('category_filter') == 'Health Program' ? 'selected' : '' }}>Health Program
                                </option>
                                <option value="Poor Alleviation"
                                    {{ request('category_filter') == 'Poor Alleviation' ? 'selected' : '' }}>Poor
                                    Alleviation</option>
                                <option value="Women Empowerment"
                                    {{ request('category_filter') == 'Women Empowerment' ? 'selected' : '' }}>Women
                                    Empowerment</option>
                                <option value="Social Problem"
                                    {{ request('category_filter') == 'Social Problem' ? 'selected' : '' }}>Social Problem
                                </option>
                                <option value="Peace Talks Program"
                                    {{ request('category_filter') == 'Peace Talks Program' ? 'selected' : '' }}>Peace Talks
                                    Program</option>
                                <option value="Skill Development"
                                    {{ request('category_filter') == 'Skill Development' ? 'selected' : '' }}>Skill
                                    Development</option>
                                <option value="Religious Program"
                                    {{ request('category_filter') == 'Religious Program' ? 'selected' : '' }}>Religious
                                    Program</option>
                                <option value="Agriculture Program"
                                    {{ request('category_filter') == 'Agriculture Program' ? 'selected' : '' }}>Agriculture
                                    Program</option>
                                <option value="Labour Tools Distribution"
                                    {{ request('category_filter') == 'Labour Tools Distribution' ? 'selected' : '' }}>
                                    Labour Tools Distribution</option>
                                <option value="Drinking Water"
                                    {{ request('category_filter') == 'Drinking Water' ? 'selected' : '' }}>Drinking Water
                                </option>
                                <option value="Ration Distribution"
                                    {{ request('category_filter') == 'Ration Distribution' ? 'selected' : '' }}>Ration
                                    Distribution</option>
                                <option value="Disaster Management"
                                    {{ request('category_filter') == 'Disaster Management' ? 'selected' : '' }}>Disaster
                                    Management</option>
                                <option value="Economic Help"
                                    {{ request('category_filter') == 'Economic Help' ? 'selected' : '' }}>Economic Help
                                </option>
                                <option value="Cow Service"
                                    {{ request('category_filter') == 'Cow Service' ? 'selected' : '' }}>Cow Service
                                </option>
                                <option value="Animal Food"
                                    {{ request('category_filter') == 'Animal Food' ? 'selected' : '' }}>Animal Food
                                </option>
                                <option value="Other Activities"
                                    {{ request('category_filter') == 'Other Activities' ? 'selected' : '' }}>Other
                                    Activities</option>
                            </select>
                        </div>

                        <div class="col-md-4 d-flex">
                            <button type="submit" class="btn btn-primary me-2">Search</button>
                            <a href="{{ route('activitylist') }}" class="btn btn-info text-white me-2">Reset</a>
                        </div>
                    </form>
                </div>
            </div>


            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{-- <h5 class="mb-0">Activity List</h5> --}}
                    <a href="{{ route('addactivity') }}" class="btn btn-success btn-sm">+ Add Activity</a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Session</th>
                                <th>Date / Time</th>
                                <th>Program Image</th>
                                <th>Program Name</th>
                                <th>Category</th>
                                <th>Address</th>
                                <th>Session</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activity as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->academic_session}}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->program_date)->format('d-m-Y') }}<br>
                                        <small>{{ $item->program_time }}</small>
                                    </td>
                                    <td>
                                        <img src="{{ asset('program_images/' . $item->program_image) }}" alt="image"
                                            class="img-thumbnail" width="100">
                                    </td>
                                    <td>{{ $item->program_name }}</td>
                                    <td>{{ $item->program_category }}</td>
                                    <td>{{ $item->program_address }}</td>
                                    <td>{{ $item->academic_session }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            <a href="{{ route('viewactivity', $item->id) }}" class="btn btn-sm btn-success"
                                                title="View">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            <a href="{{ route('editactivity', $item->id) }}" class="btn btn-sm btn-primary"
                                                title="Edit">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                            <a href="{{ route('removeactivity', $item->id) }}"
                                                class="btn btn-sm btn-danger" title="Delete">
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
