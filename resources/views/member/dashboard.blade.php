<!-- resources/views/member/dashboard.blade.php -->
@extends('member.layout.master')
@section('content')
    <div class="dashboard-wrapper">
        <div class="main-content">
            <div class="container-fluid p-4">
                <!-- Stats Cards -->
                {{-- Profile Card --}}
                @if ($member)
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">

                                {{-- Profile Image --}}
                                <div class="col-md-2 text-center mb-3 mb-md-0">
                                    @if ($member->image)
                                        <img src="{{ asset('member_images/' . $member->image) }}"
                                            class="img-fluid rounded-circle border" width="120">
                                    @else
                                        <div class="bg-secondary bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center"
                                            style="width:120px;height:120px;">
                                            <i class="bi bi-person fs-1 text-secondary"></i>
                                        </div>
                                    @endif
                                </div>

                                {{-- Personal Info --}}
                                <div class="col-md-5">
                                    <h5 class="fw-bold mb-1">{{ $member->name }}</h5>
                                    <p class="text-muted mb-2">
                                        Application No: {{ $member->application_no }}
                                    </p>

                                    <ul class="list-unstyled mb-0 small">
                                        <li><strong>Email:</strong> {{ $member->email }}</li>
                                        <li><strong>Phone:</strong> {{ $member->phone }}</li>
                                        <li><strong>DOB:</strong> {{ \Carbon\Carbon::parse($member->dob)->format('d M Y') }}
                                        </li>
                                        <li><strong>Gender:</strong> {{ $member->gender }}</li>
                                    </ul>
                                </div>

                                {{-- Position / Membership Info --}}
                                <div class="col-md-5">
                                    <h6 class="fw-semibold mb-3">Membership Information</h6>

                                    <div class="row small">

                                        {{-- Status --}}
                                        <div class="col-6 mb-3">
                                            <strong>Status:</strong><br>
                                            @if ($member->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </div>

                                        {{-- Position Type --}}
                                        <div class="col-6 mb-3">
                                            <strong>Position Type:</strong><br>
                                            {{ $member->position_type ?? 'Not Assigned' }}
                                        </div>

                                        {{-- Position --}}
                                        <div class="col-6 mb-3">
                                            <strong>Position:</strong><br>
                                            {{ $member->position ?? 'Not Assigned' }}
                                        </div>

                                        {{-- Working Area --}}
                                        <div class="col-6 mb-3">
                                            <strong>Working Area:</strong><br>
                                            {{ $member->working_area ?? 'Not Assigned' }}
                                        </div>



                                        {{-- Address --}}
                                        {{-- <div class="col-12 mt-2">
                                            <strong>Address:</strong><br>
                                            {{ $member->village }},
                                            {{ $member->post }},
                                            {{ $member->district }},
                                            {{ $member->state }},
                                            {{ $member->country }}
                                        </div> --}}

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endif

                <div class="row mb-4">

                    <div class="col-xl-4 col-sm-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Active Sub Members
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $totalSubMembers ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-sm-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Active Members
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $activeMembers ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-sm-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Activities This Month
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $monthlyActivities ?? 0 }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <!-- Recent Sub Members Table -->
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card shadow">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Recent Sub Members</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="subMembersTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Name</th>
                                                {{-- <th>Email</th> --}}
                                                <th>Position</th>
                                                <th>Working Area</th>
                                                <th>Phone</th>
                                                <th>Join Date</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentSubMembers ?? [] as $index => $member)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $member->name }}</td>
                                                    {{-- <td>{{ $member->email }}</td> --}}
                                                    <td>
                                                        @if ($member->position)
                                                            @php $level = \App\Helpers\PositionHierarchy::getLevelByPosition($member->position); @endphp
                                                            <span
                                                                class="badge bg-{{ \App\Helpers\PositionHierarchy::getLevelColor($level ?? '') }}">{{ $member->position }}</span>
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $member->working_area ?? '—' }}</td>
                                                    <td>{{ $member->phone }}</td>
                                                    <td>{{ $member->created_at->format('d M, Y') }}</td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('member.sub-member.show', $member->id) }}"
                                                            class="btn btn-sm btn-outline-primary" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No active members found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="row mb-4">
                    <div class="col-xl-12 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    Active Member Growth (Last 6 Months)
                                </h6>
                            </div>
                            <div class="card-body">
                                <canvas id="memberGrowthChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const growthCtx = document.getElementById('memberGrowthChart');

        new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels ?? []) !!},
                datasets: [{
                    label: 'Active Members',
                    data: {!! json_encode($chartData ?? []) !!},
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <style>
        .dashboard-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            background-color: #f8f9fc;
        }

        .card {
            border: none;
            border-radius: 0.35rem;
        }

        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .text-xs {
            font-size: 0.7rem;
        }
    </style>
@endsection
