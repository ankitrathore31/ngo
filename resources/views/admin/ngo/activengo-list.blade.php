@extends('admin.layout.AdminLayout')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-5">
            <div class="card m-2 shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Active Ngo List</h4>
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
@endsection
