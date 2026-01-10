@extends('ngo.layout.master')
@Section('content')
    <style>
        .hover-card {
            transition: all 0.3s ease-in-out;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            background-color: #f9fafb;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
    <div class="wrapper">
        <div class="container-fluid mt-4">
            <div class="row mb-3 mt-4">
                @php
                    $user = auth()->user();
                    $isStaff = $user && $user->user_type === 'staff';
                @endphp
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-1">

                        @if (!$isStaff || $user->hasPermission('educationfacility_add_disease'))
                            <a href="{{ route('add.class') }}" class="btn btn-sm btn-primary">
                                Add Class
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_hospital_list'))
                            <a href="{{ route('list.school') }}" class="btn btn-sm btn-primary">
                                School List
                            </a>
                        @endif

                        @if (!$isStaff || $user->hasPermission('educationfacility_educationcard_generate'))
                            <a href="{{ route('eduaction.reg.list') }}" class="btn btn-sm btn-primary">
                                Education Card Generate
                            </a>
                        @endif

                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Add Class</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Education Card</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="container mt-4">
                <div class="card shadow-sm border-0">

                    <div class="card-body">
                        <form action="{{ route('store.class') }}" method="POST" class="mb-4">
                            @csrf

                            <div class="row g-3 align-items-end">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        Class Name
                                    </label>
                                    <input type="text" name="class"
                                        class="form-control @error('class') is-invalid @enderror"
                                        value="{{ old('class') }}" placeholder="Enter class name">

                                    @error('class')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-success w-100">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                        <hr>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 80px;">Sr. No.</th>
                                        <th>Class Name</th>
                                        <th style="width: 120px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($classes as $key => $class)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $class->class }}</td>
                                            <td>
                                                <a href="{{ route('delete.class', $class->id) }}"
                                                    onclick="return confirm('Are you sure you want to delete this class?')"
                                                    class="btn btn-danger btn-sm">
                                                    Delete
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">
                                                No data found
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
