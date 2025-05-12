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
    </style>

    <div class="wrapper">
        <div class="container-fluid mt-5">
            {{-- <div class="row">
                <h1>Welcome, {{ Auth::user()->name }}</h1>
                <p>User Type: {{ Auth::user()->user_type }}</p>
            </div> --}}
            <div class="row g-4">
                <!-- Total Users -->
                <div class="col-md-4 col-sm-6">
                    <div class="dashboard-card bg-success card-wrapper">
                        <i class="fas fa-users icon"></i>
                        <div>
                            <p class="info-text">Total Users</p>
                            <h5>{{ $ngo->count() }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Active Users -->
                <div class="col-md-4 col-sm-6">
                    <div class="dashboard-card bg-primary card-wrapper">
                        <i class="fas fa-user-check icon"></i>
                        <div>
                            <p class="info-text">Active Users</p>
                            <h5>{{ $activengo }}</h5>
                        </div>
                    </div>
                </div>

                <!-- Inactive Users -->
                <div class="col-md-4 col-sm-6">
                    <div class="dashboard-card bg-warning card-wrapper">
                        <i class="fas fa-user-times icon"></i>
                        <div>
                            <p class="info-text">Inactive Users</p>
                            <h5>{{ $inactiveNgo }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-5">
            <div class="card m-2 shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">User List</h4>
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
                                                <a href="{{ route('view-ngo', $item->id) }}" class="btn btn-sm btn-outline-success"
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
@endsection
