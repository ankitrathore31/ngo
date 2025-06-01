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

            <div class="row">
                <div class="col-md-12">
                    <form method="GET" action="{{ route('working-area-list') }}" class="row g-3 mb-4">
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
                            <select id="area_filter" name="area_filter"
                                class="form-control @error('area_filter') is-invalid @enderror"
                                onchange="this.form.submit()">
                                <option value=""> Select Area Type </option>
                                <option value="Country" {{ request('area_filter') == 'Country' ? 'selected' : '' }}>Country
                                </option>
                                <option value="State" {{ request('area_filter') == 'State' ? 'selected' : '' }}>State
                                </option>
                                <option value="District" {{ request('category_filter') == 'District' ? 'selected' : '' }}>
                                    District</option>
                                <option value="Tehsil" {{ request('category_filter') == 'Tehsil' ? 'selected' : '' }}>
                                    Tehsil</option>
                                <option value="Block" {{ request('category_filter') == 'Block' ? 'selected' : '' }}>
                                    Block</option>
                                <option value="City/Town"
                                    {{ request('category_filter') == 'City/Town' ? 'selected' : '' }}>
                                    City/Town</option>
                                <option value="Village" {{ request('category_filter') == 'Village' ? 'selected' : '' }}>
                                    Village</option>
                                <option value="Family" {{ request('category_filter') == 'Family' ? 'selected' : '' }}>
                                    Family</option>
                            </select>
                        </div>

                        <div class="col-md-4 d-flex">
                            <button type="submit" class="btn btn-primary me-2">Search</button>
                            <a href="{{ route('working-area-list') }}" class="btn btn-info text-white me-2">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
            <h5>Total Areas by Type</h5>
            <div class="row">
                @foreach ($areaTypeCounts as $count)
                    <div class="col-md-1 col-sm-2 mb-3">
                        <div class="card text-center shadow-sm">
                            <div class="card-body p-1">
                                <h6 class="card-title text-primary">{{ $count->area_type }}</h6>
                                <p class="card-text mb-0">{{ $count->total }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">

                    <a href="{{ route('working-area') }}" class="btn btn-success btn-sm">+ Add Working Area</a>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Session</th>
                                <th>Area Type</th>
                                <th>Area</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($area as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->academic_session }}</td>
                                    <td>{{ $item->area_type }}</td>
                                    <td>{{ $item->area }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">

                                            <a href="{{ route('remove-area', $item->id) }}" class="btn btn-sm btn-danger"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this area?')">
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
