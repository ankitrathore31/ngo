@extends('admin.layout.AdminLayout')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid mt-5">
            {{-- Display success message if present --}}
            @if (session('Success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('Success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- Display error message if present --}}
            @if (session('Error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('Error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="container">
                <div class="card mt-4 shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Session List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="userTable" class="table table-striped table-bordered align-middle"
                                style="width:100%">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Session</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->session_date }}</td>
                                            <td style="white-space: nowrap; width: 250px;">
                                                <div class="btn-group" role="group" style="gap: 5px;">
                                                    <a href="{{ route('edit-session', $item->id) }}"
                                                        class="btn btn-sm btn-info text-white"
                                                        style="min-width: 60px; height: 35px;">Edit</a>

                                                    <a href="{{ route('delete-session', $item->id) }}"
                                                        class="btn btn-sm btn-danger"
                                                        style="min-width: 70px; height: 35px;">Delete</a>
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
