@extends('ngo.layout.master')
@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Form List</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('ngo') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Form</li>
                </ol>
            </nav>
        </div>
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('form-downloads.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Upload New Form
            </a>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Forms List -->
        @if ($forms->count() > 0)
            <div class="row">
                @foreach ($forms as $form)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm hover-card">
                            <!-- Card Image/Icon -->
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                style="height: 200px;">
                                @if (in_array($form->file_type, ['jpg', 'jpeg', 'png']))
                                    <img src="{{ asset('storage/' . $form->file_path) }}" alt="{{ $form->title }}"
                                        class="img-fluid" style="max-height: 100%; object-fit: cover;">
                                @else
                                    <i class="fas fa-file-pdf fa-5x text-danger"></i>
                                @endif
                            </div>

                            <div class="card-body">
                                <!-- Title -->
                                <h5 class="card-title">{{ $form->title }}</h5>

                                <!-- Description -->
                                @if ($form->description)
                                    <p class="card-text text-muted small">{{ Str::limit($form->description, 100) }}</p>
                                @endif

                                <!-- File Info -->
                                <div class="d-flex justify-content-between text-muted small mb-3">
                                    <span><i class="fas fa-file"></i> {{ strtoupper($form->file_type) }}</span>
                                    <span><i class="fas fa-hdd"></i> {{ $form->file_size_formatted }}</span>
                                    <span><i class="fas fa-download"></i> {{ $form->download_count }}</span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-2">
                                    @if (in_array($form->file_type, ['jpg', 'jpeg', 'png']))
                                        <a href="{{ route('form-downloads.preview', $form->id) }}"
                                            class="btn btn-sm btn-info flex-fill" target="_blank">
                                            <i class="fas fa-eye"></i> Preview
                                        </a>
                                    @endif

                                    <a href="{{ route('form-downloads.download', $form->id) }}"
                                        class="btn btn-sm btn-success flex-fill">
                                        <i class="fas fa-download"></i> Download
                                    </a>

                                    <form action="{{ route('form-downloads.destroy', $form->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this form?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="card-footer text-muted small">
                                <i class="fas fa-user"></i> {{ $form->uploader->name ?? 'Admin' }} |
                                <i class="fas fa-calendar"></i> {{ $form->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-5x text-muted mb-3"></i>
                <h4>No Forms Available</h4>
                <p class="text-muted">There are no forms uploaded yet.</p>
                <a href="{{ route('form-downloads.create') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-plus"></i> Upload First Form
                </a>
            </div>
        @endif
    </div>

    <style>
        .hover-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }
    </style>
@endsection
