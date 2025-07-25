@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between align-items-center mb-1 mt-2">
            <h5 class="mb-0">Add Project Report</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-1 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Project Report</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container mt-2">
            <div class="card-body shadow-sm p-2 bg-light">
                <div class="row">
                    <!-- Project Code -->
                    <div class="col-md-4 mb-3">
                        <label for="project_code">Project Code:</label>
                        <p class="form-control-plaintext">{{ $project->code }}</p>
                    </div>

                    <!-- Project Name -->
                    <div class="col-md-4 mb-3">
                        <label for="project_name">Project Name:</label>
                        <p class="form-control-plaintext">{{ $project->name }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="project_name">Project Category:</label>
                        <p class="form-control-plaintext">{{ $project->category }}</p>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="container mt-4">
            <form method="POST" action="{{ route('store.project.report') }}">
                @csrf
                <input type="number" name="project_id" value="{{$project->id}}" hidden>
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <strong>Project Report Details</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="session" class="fw-bold">Session <span class="text-danger">*</span></label>
                            <select class="form-control @error('session') is-invalid @enderror" name="session"
                                id="session" required>
                                <option value="">-- Select Session --</option>
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

                        <div class="form-group mb-3">
                            <label for="report" class="fw-bold">Project Report:</label>
                            <textarea name="report" id="report" rows="5" class="form-control @error('report') is-invalid @enderror">{{ old('report') }}</textarea>
                            @error('report')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="mission" class="fw-bold">Project Mission</label>
                            <textarea name="mission" id="mission" rows="5" class="form-control @error('mission') is-invalid @enderror">{{ old('mission') }}</textarea>
                            @error('mission')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="conclusion" class="fw-bold">Project Conclusion</label>
                            <textarea name="conclusion" id="conclusion" rows="5"
                                class="form-control @error('conclusion') is-invalid @enderror">{{ old('conclusion') }}</textarea>
                            @error('conclusion')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                        <strong>Expense Allocation</strong>
                        <button type="button" class="btn btn-sm btn-light" onclick="addRow()">+ Add Row</button>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered mb-0" id="items-table">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 5%;">#</th>
                                    <th>Category</th>
                                    <th>Expense (INR)</th>
                                    <th>Details & Allocation</th>
                                    <th style="width: 5%;"></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="card-footer text-end">
                        <strong>Total Amount: ₹<span id="total-amount">0.00</span></strong>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Save Project Report</button>
                </div>
            </form>
        </div>

    </div>

    <!-- JavaScript Section -->
    <script>
        let index = 0;

        function addRow() {
            const tbody = document.querySelector("#items-table tbody");
            const row = document.createElement("tr");

            row.innerHTML = `
            <td class="sr-no">${index + 1}</td>
            <td><input type="text" name="items[${index}][category]" class="form-control" required></td>
            <td><input type="number" name="items[${index}][expense]" class="form-control text-end expense" step="0.01" value="0.00" onchange="updateTotal()"></td>
            <td><input type="text" name="items[${index}][details]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
        `;

            tbody.appendChild(row);
            index++;
            updateSrNo();
            updateTotal();
        }

        function updateSrNo() {
            document.querySelectorAll('#items-table tbody tr').forEach((row, i) => {
                row.querySelector('.sr-no').textContent = i + 1;
            });
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.expense').forEach(input => {
                total += parseFloat(input.value) || 0;
            });

            document.getElementById('total-amount').textContent = total.toFixed(2);
        }

        function removeRow(btn) {
            btn.closest('tr').remove();
            updateSrNo();
            updateTotal();
        }
    </script>
@endsection
