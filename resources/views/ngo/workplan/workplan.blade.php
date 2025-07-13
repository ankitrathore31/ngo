@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-items-center mb-1 mt-2">
            <h5 class="mb-0">Add Work Plan</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-1 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Work Plan</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container mt-3">
            <form method="POST" action="{{ route('store-workplan') }}">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="project_code">Project Code:</label>
                        <input type="number" id="project_code" name="project_code" class="form-control"
                            value="{{ old('project_code') }}" required>
                        @error('project_code')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="project_name">Project Name:</label>
                        <input type="text" id="project_name" name="project_name" class="form-control"
                            value="{{ old('project_name') }}" required>
                        @error('project_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="center">Center Name:</label>
                        <input type="text" id="center" name="center" class="form-control" value="{{ old('center') }}"
                            required>
                        @error('center')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @php
                        $districtsByState = config('districts');
                    @endphp
                    <div class="col-md-4 form-group mb-3">
                        <label for="stateSelect" class="form-label">State: <span class="text-danger">*</span></label>
                        <select class="form-control @error('state') is-invalid @enderror" name="state" id="stateSelect"
                            required>
                            <option value="">Select State</option>
                            @foreach ($districtsByState as $state => $districts)
                                <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>
                                    {{ $state }}
                                </option>
                            @endforeach
                        </select>
                        @error('state')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="districtSelect" class="form-label">District: <span class="text-danger">*</span></label>
                        <select class="form-control @error('district') is-invalid @enderror" name="district"
                            id="districtSelect" required>
                            <option value="">Select District</option>
                        </select>
                        @error('district')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-sm-4 mb-3">
                        <label for="animator_code">Animator Code:</label>
                        <input type="number" id="animator_code" name="animator_code" class="form-control"
                            value="{{ old('animator_code') }}" required>
                        @error('animator_code')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="name">Animator Name:</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="session" class="bold">Session <span class="text-danger">*</span></label>
                        <select class="form-control @error('session') is-invalid @enderror" name="session" id="session"
                            required>
                            <option value="">Select Session</option>
                            @foreach ($data as $session)
                                <option value="{{ $session->session_date }}"
                                    {{ old('session') == $session->session_date ? 'selected' : '' }}>
                                    {{ $session->session_date }}
                                </option>
                            @endforeach
                        </select>
                        @error('session')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="month_of">Month of:</label>
                        <select id="month_of" name="month_of" class="form-control" required>
                            <option value="">-- Select Month --</option>
                            @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                <option value="{{ $month }}" {{ old('month_of') == $month ? 'selected' : '' }}>
                                    {{ $month }}
                                </option>
                            @endforeach
                        </select>
                        @error('month_of')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="col-md-4 mb-3">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" class="form-control"
                            value="{{ old('date') }}" required>
                        @error('date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="to">To:</label>
                        <input type="date" id="to" name="to" class="form-control"
                            value="{{ old('to') }}" required>
                        @error('to')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <table class="table table-bordered" id="items-table">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th class="text-end">Work Date</th>
                            <th class="text-end">Work Address</th>
                            <th class="text-end">Work Name</th>
                            <th class="text-end">Work Type</th>
                            <th class="text-end">Worker Name</th>
                            <th class="text-end">Who to work with</th>
                            <th class="text-end">Benefits of work</th>
                            <th>
                                <button type="button" class="btn btn-success btn-sm" onclick="addRow()">Add</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <button type="submit" class="btn btn-primary">Save WorkPlan</button>
            </form>
        </div>
    </div>
    <script>
        let index = 0;

        function addRow() {
            const tbody = document.querySelector("#items-table tbody");
            const row = document.createElement("tr");

            row.innerHTML = `
            <td class="sr-no">${index + 1}</td>
            <td><input type="date" name="items[${index}][work_date]" class="form-control" required></td>
            <td><input type="text" name="items[${index}][work_address]" class="form-control" required></td>
            <td><input type="text" name="items[${index}][work_name]" class="form-control" required></td>
            <td><input type="text" name="items[${index}][work_type]" class="form-control" required></td>
            <td><input type="text" name="items[${index}][worker_name]" class="form-control" required></td>
            <td><input type="text" name="items[${index}][work_with]" class="form-control" required></td>
            <td><input type="text" name="items[${index}][benefits]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
        `;

            tbody.appendChild(row);
            index++;
            updateSrNo();
        }

        function updateSrNo() {
            document.querySelectorAll('#items-table tbody tr').forEach((row, i) => {
                row.querySelector('.sr-no').textContent = i + 1;
            });
        }

        function removeRow(btn) {
            btn.closest('tr').remove();
            updateSrNo();
        }
    </script>

    <script>
        const allDistricts = @json($districtsByState);
        const oldDistrict = "{{ old('district') }}";
        const oldState = "{{ old('state') }}";

        function populateDistricts(state) {
            const districtSelect = document.getElementById('districtSelect');
            districtSelect.innerHTML = '<option value="">Select District</option>';

            if (allDistricts[state]) {
                allDistricts[state].forEach(function(district) {
                    const selected = (district === oldDistrict) ? 'selected' : '';
                    districtSelect.innerHTML += `<option value="${district}" ${selected}>${district}</option>`;
                });
            }
        }

        // Initial load if editing or validation failed
        if (oldState) {
            populateDistricts(oldState);
        }

        // On state change
        document.getElementById('stateSelect').addEventListener('change', function() {
            populateDistricts(this.value);
        });
    </script>
@endsection
