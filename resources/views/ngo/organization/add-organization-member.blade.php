@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            <div class="d-flex justify-content-between align-items-center mb-5">
                <h5 class="mb-0">Add Organization Member</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Organization</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Organization info --}}
            <div class="container mb-4">
                <h6><b>- Organization Information</b></h6>
                <div class="card p-2 bg-info">
                    <div class="row">
                        <div class="col-sm-4 mb-2"><b>Session:</b> {{ $organization->academic_session }}</div>
                        <div class="col-sm-4 mb-2"><b>Organization Name:</b> {{ $headOrganization->name }}</div>
                        <div class="col-sm-4 mb-2"><b>Group Name:</b> {{ $organization->name }}</div>
                        <div class="col-sm-4 mb-2"><b>Group Address:</b> {{ $organization->address }}</div>
                        <div class="col-sm-4 mb-2"><b>Group District:</b> {{ $organization->district }}</div>
                        <div class="col-sm-4 mb-2"><b>Group State:</b> {{ $organization->state }}</div>
                    </div>
                </div>
            </div>

            {{-- Search --}}
            <div class="container mb-4">
                <h6><b>- Search Member</b></h6>
                <input type="text" id="searchInput" class="form-control mb-3"
                    placeholder="Search by Name, Guardian Name, Registration No or Staff Code...">

                <table class="table table-bordered d-none" id="membersTable">
                    <thead>
                        <tr>
                            <th>Registraition No./Staff Code</th>
                            <th>Name</th>
                            <th>Father/Husband Name</th>
                            <th>Mother Name</th>
                            <th>Address</th>
                            <th>Caste</th>
                            <th>Caste Category</th>
                            <th>Religion</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allMembers as $member)
                            <tr data-id="{{ $member->id }}" data-name="{{ $member->name }}"
                                data-guardian="{{ $member->gurdian_name ?? 'N/A' }}"
                                data-code="{{ $member->registration_no ?? ($member->staff_code ?? 'N/A') }}">
                                <td>{{ $member->registration_no ?? ($member->staff_code ?? 'N/A') }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->gurdian_name ?? 'N/A' }}</td>
                                <td>{{ $member->mother_name ?? 'N/A' }}</td>
                                <td>{{ $member->village ?? 'N/A' }},{{ $member->post ?? 'N/A' }},{{ $member->town ?? 'N/A' }}
                                    ,{{ $member->district ?? 'N/A' }},{{ $member->state ?? 'N/A' }}
                                </td>
                                <td>{{ $member->caste }}</td>
                                <td>{{ $member->religion_category }}</td>
                                <td>{{ $member->religion }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm add-member-btn">Select</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Selected members --}}
            <div class="container">
                <h6><b>- Selected Members</b></h6>
                @error('members.' . $loop->index)
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="card p-2">
                    <form action="{{ route('store.organization.member', $organization->id) }}" method="POST"
                        id="selectedForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="academic_session" class="form-label">Organization Member Session <span
                                        class="text-danger">*</span></label>
                                <select class="form-control @error('academic_session') is-invalid @enderror"
                                    name="academic_session">
                                    <option value="">Select Session</option>
                                    @foreach ($data as $session)
                                        <option value="{{ $session->session_date }}">{{ $session->session_date }}</option>
                                    @endforeach
                                </select>
                                @error('academic_session')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <table class="table table-bordered d-none" id="selectedMembersTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Guardian Name</th>
                                    <th>Reg./Staff Code</th>
                                    <th>Position</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Dynamic rows --}}
                            </tbody>
                        </table>

                        <button type="submit" id="saveBtn" class="btn btn-success d-none">Save All Members</button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const membersTable = document.getElementById('membersTable');
        const selectedTable = document.getElementById('selectedMembersTable');
        const selectedTableBody = selectedTable.querySelector('tbody');
        const saveBtn = document.getElementById('saveBtn');

        // Search logic
        searchInput.addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = membersTable.querySelectorAll("tbody tr");

            if (filter.length > 0) {
                membersTable.classList.remove('d-none');
            } else {
                membersTable.classList.add('d-none');
            }

            rows.forEach(row => {
                let name = row.dataset.name.toLowerCase();
                let guardian = row.dataset.guardian.toLowerCase();
                let code = row.dataset.code.toLowerCase();

                if (name.includes(filter) || guardian.includes(filter) || code.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Add selected member
        document.querySelectorAll('.add-member-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const memberId = row.dataset.id;
                const memberName = row.dataset.name;
                const guardianName = row.dataset.guardian;
                const code = row.dataset.code;

                // Check duplicate
                if (selectedTableBody.querySelector(`tr[data-id="${memberId}"]`)) {
                    alert("This member is already selected!");
                    return;
                }

                let newRow = document.createElement('tr');
                newRow.setAttribute('data-id', memberId);

                newRow.innerHTML = `
                <td>${memberName}</td>
                <td>${guardianName}</td>
                <td>${code}</td>
                <td>
                    <input type="text" name="members[${memberId}][position]" class="form-control" required>
                    <input type="hidden" name="members[${memberId}][id]" value="${memberId}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-member-btn">Remove</button>
                </td>
            `;

                selectedTableBody.appendChild(newRow);
                selectedTable.classList.remove('d-none');
                saveBtn.classList.remove('d-none');

                // Remove button
                newRow.querySelector('.remove-member-btn').addEventListener('click', function() {
                    newRow.remove();
                    if (selectedTableBody.children.length === 0) {
                        selectedTable.classList.add('d-none');
                        saveBtn.classList.add('d-none');
                    }
                });
            });
        });
    </script>
@endsection
