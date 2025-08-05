@extends('admin.layout.AdminLayout')
@Section('content')
    <style>
        .dashboard-card {
            border: none;
            border-radius: 12px;
            padding: 20px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: start;
            gap: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .dashboard-card .icon {
            font-size: 30px;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 10px;
            border-radius: 50%;
        }

        .dashboard-card .info-text {
            font-size: 14px;
            margin: 0;
            opacity: 0.9;
        }

        .dashboard-card h5 {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
        }

        .card-wrapper {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            transform: scale(1.02);
        }
    </style>
    <div class="wrapper">
        <div class="container mt-5">
            <div class="row">
                <!-- Total Visitors Card -->
                <div class="col-md-6 mb-4">
                           <h5><b> - Website Traffic</b></h5>
                    <!-- Today's Visitors Card -->
                    <div class="card card-hover" style="background-color: rgb(240, 248, 255); transition: 0.3s;">
                        <div class="card-body">
                            <h5 class="card-title" style="color: rgb(25, 42, 86);">Visitors Today</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Tracked for the Current Day</h6>
                            <p class="card-text display-4" style="color: rgb(0, 123, 255); font-weight: bold;">
                                {{ todayVisitor() }}</p>
                        </div>
                    </div>
                    <br>
                    <!-- Total Visitors Card -->
                    <div class="card card-hover" style="background-color: rgb(245, 245, 245); transition: 0.3s;">
                        <div class="card-body">
                            <h5 class="card-title" style="color: rgb(39, 174, 96);">Total Visitors</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Cumulative Count</h6>
                            <p class="card-text display-4" style="color: rgb(22, 160, 133); font-weight: bold;">
                                {{ totalVisitor() }}</p>
                        </div>
                    </div>
                </div>
                <!-- Visitor Pie Chart -->
                <div class="col-md-6 mb-4">
                    <div class="card card-hover">
                        <div class="card-body">
                            <h5 class="card-title">Visitors by Month</h5>
                            <h6 class="card-subtitle mb-2 text-muted">This Year</h6>
                            <div class="chart-container" style="position: relative; height: 300px;">
                                <canvas id="visitorChart"></canvas>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-5">
            <div class="row g-4">
                <!-- Total Users -->
                <div class="col-md-4 col-sm-6">
                    <div class="dashboard-card bg-success card-wrapper">
                        <i class="fas fa-users icon"></i>
                        <div>
                            <p class="info-text">Total Ngo</p>
                            <h5>{{ $ngo->count() }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Active Users -->
                <div class="col-md-4 col-sm-6">
                    <div class="dashboard-card bg-primary card-wrapper">
                        <i class="fas fa-user-check icon"></i>
                        <div>
                            <p class="info-text">Active Ngo</p>
                            <h5>{{ $activengo }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Inactive Users -->
                <div class="col-md-4 col-sm-6">
                    <div class="dashboard-card bg-warning card-wrapper">
                        <i class="fas fa-user-times icon"></i>
                        <div>
                            <p class="info-text">Inactive Ngo</p>
                            <h5>{{ $inactiveNgo }}</h5>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-5">
            <div class="card m-2 shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Ngo List</h4>
                    <span class="fw-bold">Total: {{ $ngo->count() }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="userTable" class="table table-striped table-bordered align-middle" style="width:100%">
                            <thead class="table-primary">
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>NGO Name</th>
                                    <th>Founder Name</th>
                                    <th>Email</th>
                                    <th>Mobile No.</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ngo as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->ngo_name }}</td>
                                        <td>{{ $item->founder_name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone_number }}</td>
                                        <td>{{ $item->start_date }}</td>
                                        <td>{{ $item->end_date }}</td>
                                        <td>
                                            <form action="{{ route('ngo.toggleStatus', $item->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('POST') <!-- Use POST method, as your route expects POST -->
                                                <button type="submit"
                                                    class="btn btn-sm {{ $item->status == 1 ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                                    style="min-width: 90px; height: 35px;">
                                                    {{ $item->status == 1 ? 'Active' : 'Deactivate' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td style="white-space: nowrap; width: 250px;">
                                            <div class="btn-group" role="group" style="gap: 5px;">
                                                <a href="{{ route('view-ngo', $item->id) }}"
                                                    class="btn btn-sm btn-outline-success"
                                                    style="min-width: 70px; height: 35px;">View</a>

                                                <a href="{{ route('edit-ngo', $item->id) }}"
                                                    class="btn btn-sm btn-info text-white"
                                                    style="min-width: 60px; height: 35px;">Edit</a>

                                                <form action="{{ route('delete-ngo', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger text-white"
                                                        style="min-width: 60px; height: 35px;">Delete</button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach

                                <!-- More rows go here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                responsive: true,
                "pageLength": 5,
                "lengthMenu": [5, 10, 25, 50],
                "columnDefs": [{
                    "orderable": false,
                    "targets": 4
                }]
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const monthlyData = @json(monthlyVisitorData());
        const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];

        const ctx = document.getElementById('visitorChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Monthly Visitors',
                    data: monthlyData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(201, 203, 207, 0.8)',
                        'rgba(102, 187, 106, 0.8)',
                        'rgba(239, 83, 80, 0.8)',
                        'rgba(123, 31, 162, 0.8)',
                        'rgba(66, 133, 244, 0.8)',
                        'rgba(233, 30, 99, 0.8)',
                    ],
                    borderRadius: 6,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'rgb(100, 100, 100)'
                        },
                        grid: {
                            color: 'rgba(200,200,200,0.1)'
                        }
                    },
                    x: {
                        ticks: {
                            color: 'rgb(100, 100, 100)'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endsection
