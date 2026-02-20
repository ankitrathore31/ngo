@extends('ngo.layout.master')
@section('content')
    <div class="container mt-4">

        <div class="d-flex justify-content-between mb-3">
            <h5>Union List</h5>
            <a href="{{ route('add.union') }}" class="btn btn-primary">Add Union</a>
        </div>

        @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
        @endif

        {{-- Search Form --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('union.list') }}">
                    <div class="row">

                        <div class="col-md-3 mb-2">
                            <input type="text" name="name" class="form-control" placeholder="Search Name"
                                value="{{ request('name') }}">
                        </div>

                        <div class="col-md-2 mb-2">
                            <input type="text" name="union_no" class="form-control" placeholder="Union ID"
                                value="{{ request('union_no') }}">
                        </div>

                        <div class="col-md-2 mb-2">
                            <input type="text" name="address" class="form-control" placeholder="Address"
                                value="{{ request('address') }}">
                        </div>

                        <div class="col-md-2 mb-2">
                            <input type="text" name="block" class="form-control" placeholder="Block"
                                value="{{ request('block') }}">
                        </div>

                        <div class="col-md-3 mb-2">
                            <select name="state" id="stateSelect" class="form-control">
                                <option value="">Select State</option>
                                @foreach ($states as $state => $districts)
                                    <option value="{{ $state }}" {{ request('state') == $state ? 'selected' : '' }}>
                                        {{ $state }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 mb-2">
                            <select name="district" id="districtSelect" class="form-control">
                                <option value="">Select District</option>
                            </select>
                        </div>

                        <div class="col-md-2 mb-2">
                            <select name="area_type" class="form-control">
                                <option value="">Area Type</option>
                                <option value="Rural" {{ request('area_type') == 'Rural' ? 'selected' : '' }}>Rural
                                </option>
                                <option value="Urban" {{ request('area_type') == 'Urban' ? 'selected' : '' }}>Urban
                                </option>
                            </select>
                        </div>

                        <div class="col-md-2 mb-2">
                            <input type="text" name="academic_session" class="form-control" placeholder="Session"
                                value="{{ request('academic_session') }}">
                        </div>

                        <div class="col-md-2 mb-2">
                            <button type="submit" class="btn btn-success w-100">Search</button>
                        </div>

                        <div class="col-md-2 mb-2">
                            <a href="{{ route('union.list') }}" class="btn btn-secondary w-100">Reset</a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- Union Table --}}
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Union ID</th>
                            <th>Formation Date</th>
                            <th>Name</th>
                            <th>Session</th>
                            <th>Area</th>
                            <th>Address</th>
                            <th>Block</th>
                            <th>State</th>
                            <th>District</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($unions as $union)
                            <tr>
                                <td>{{ $loop->iteration  }}</td>
                                <td>{{ $union->union_no }}</td>
                                <td>{{ $union->formation_date }}</td>
                                <td>{{ $union->name }}</td>
                                <td>{{ $union->academic_session }}</td>
                                <td>{{ $union->area_type }}</td>
                                <td>{{ $union->address }}</td>
                                <td>{{ $union->block }}</td>
                                <td>{{ $union->state }}</td>
                                <td>{{ $union->district }}</td>
                                 <td>
                                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                                            {{-- <a href="{{ route('view.vendor', $union->id) }}"
                                                class="btn btn-success btn-sm px-3">
                                                <i class="fa-regular fa-eye"></i>
                                            </a> --}}
                                            <a href="{{ route('edit.union', $union->id) }}" class="btn btn-primary btn-sm"
                                                title="Edit">
                                                <i class="fa-regular fa-edit"></i>
                                            </a>
                                            <a href="{{ route('delete.union', $union->id) }}"
                                                class="btn btn-danger btn-sm "
                                                onclick="return confirm('Do you want to delete union')" title="Delete">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </div>
                                    </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No Records Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- District Script --}}
    <script>
        const allDistricts = @json($states);
        const selectedState = "{{ request('state') }}";
        const selectedDistrict = "{{ request('district') }}";

        function populateDistricts(state) {
            const districtSelect = document.getElementById('districtSelect');
            districtSelect.innerHTML = '<option value="">Select District</option>';

            if (allDistricts[state]) {
                allDistricts[state].forEach(function(district) {
                    const selected = (district === selectedDistrict) ? 'selected' : '';
                    districtSelect.innerHTML += `<option value="${district}" ${selected}>${district}</option>`;
                });
            }
        }

        if (selectedState) {
            populateDistricts(selectedState);
        }

        document.getElementById('stateSelect')
            .addEventListener('change', function() {
                populateDistricts(this.value);
            });
    </script>
@endsection
