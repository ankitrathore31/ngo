@extends('ngo.layout.master')

@section('content')
<div class="wrapper">
    <div class="container-fluid mt-4">

        {{-- ── Page header ────────────────────────────────────────────────── --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="mb-0 fw-semibold text-dark">
                    <i class="fas fa-file-magnifying-glass me-2 text-info"></i>View NOC
                </h5>
                <small class="text-muted">NOC Certificate Details</small>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded-pill small">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('noc.index') }}">NOC List</a></li>
                        <li class="breadcrumb-item active">View NOC</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">

                {{-- ── Detail Card ─────────────────────────────────────────── --}}
                <div class="card border-0 shadow-sm mb-4">
                    {{-- Header with NOC badge --}}
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-3">
                            <div class="noc-id-badge">NOC<br><span>#{{ $noc->id }}</span></div>
                            <div>
                                <h6 class="mb-0 fw-semibold">{{ $noc->noc_area }}</h6>
                                <small class="text-muted">
                                    Issued on {{ \Carbon\Carbon::parse($noc->noc_date)->format('d F Y') }}
                                </small>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            {{-- <a href="{{ route('noc.edit', $noc->id) }}" class="btn btn-warning btn-sm px-3">
                                <i class="fas fa-pen-to-square me-1"></i>Edit
                            </a> --}}
                            <form action="{{ route('noc.destroy', $noc->id) }}" method="POST" class="delete-form d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm px-3">
                                    <i class="fas fa-trash-can me-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-4">

                            {{-- Detail rows --}}
                            <div class="col-md-6">
                                <div class="detail-block">
                                    <label class="detail-label">
                                        <i class="fas fa-calendar-days me-2 text-primary"></i>NOC Date
                                    </label>
                                    <p class="detail-value">
                                        {{ \Carbon\Carbon::parse($noc->noc_date)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-block">
                                    <label class="detail-label">
                                        <i class="fas fa-map-location-dot me-2 text-primary"></i>NOC Area
                                    </label>
                                    <p class="detail-value">{{ $noc->noc_area }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-block">
                                    <label class="detail-label">
                                        <i class="fas fa-user me-2 text-primary"></i>Name Of The Person Issuing NO
                                    </label>
                                    <p class="detail-value">{{ $noc->issuer_name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-block">
                                    <label class="detail-label">
                                        <i class="fas fa-id-badge me-2 text-primary"></i>Designation Of The Person Issuing
                                    </label>
                                    <p class="detail-value">{{ $noc->issuer_designation }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-block">
                                    <label class="detail-label">
                                        <i class="fas fa-clock me-2 text-primary"></i>Uploaded On
                                    </label>
                                    <p class="detail-value">{{ $noc->created_at->format('d M Y, h:i A') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-block">
                                    <label class="detail-label">
                                        <i class="fas fa-file me-2 text-primary"></i>File Type
                                    </label>
                                    <p class="detail-value">
                                        @if($noc->file_type === 'image')
                                            <span class="badge bg-success bg-opacity-10 text-success fs-6 fw-normal px-3 py-2">
                                                <i class="fas fa-image me-1"></i>Image
                                            </span>
                                        @elseif($noc->file_type === 'pdf')
                                            <span class="badge bg-danger bg-opacity-10 text-danger fs-6 fw-normal px-3 py-2">
                                                <i class="fas fa-file-pdf me-1"></i>PDF
                                            </span>
                                        @else
                                            <span class="badge bg-warning bg-opacity-10 text-warning fs-6 fw-normal px-3 py-2">
                                                <i class="fas fa-paperclip me-1"></i>Other
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ── NOC File Preview Card ────────────────────────────────── --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <span class="fw-semibold"><i class="fas fa-file-lines me-2 text-muted"></i>NOC Document</span>
                        <a href="{{ asset('noc_files/' . $noc->file_path) }}" target="_blank"
                           class="btn btn-outline-primary btn-sm px-3" download="{{ $noc->file_original_name }}">
                            <i class="fas fa-download me-1"></i>Download
                        </a>
                    </div>
                    <div class="card-body p-4 text-center">
                        @if($noc->file_type === 'image')
                            <img src="{{ asset('noc_files/' . $noc->file_path) }}"
                                 alt="NOC Document"
                                 class="img-fluid rounded-3 shadow-sm"
                                 style="max-height: 500px; cursor: zoom-in;"
                                 onclick="window.open(this.src,'_blank')">
                            <p class="text-muted small mt-2">
                                <i class="fas fa-cursor me-1"></i>Click to open full size
                            </p>
                        @elseif($noc->file_type === 'pdf')
                            <iframe src="{{ asset('noc_files/' . $noc->file_path) }}"
                                    class="rounded-3 border w-100"
                                    style="height: 500px;"
                                    title="NOC PDF">
                            </iframe>
                        @else
                            <div class="py-5">
                                <i class="fas fa-file-lines fa-4x text-muted mb-3 d-block"></i>
                                <p class="fw-medium mb-1">{{ $noc->file_original_name }}</p>
                                <p class="text-muted small mb-3">Preview not available for this file type.</p>
                                <a href="{{ asset('noc_files/' . $noc->file_path) }}" target="_blank"
                                   class="btn btn-primary px-4" download="{{ $noc->file_original_name }}">
                                    <i class="fas fa-download me-2"></i>Download File
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Back button --}}
                <div class="mt-3">
                    <a href="{{ route('noc.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
    .noc-id-badge {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: #fff;
        border-radius: 10px;
        padding: 6px 12px;
        font-size: 10px;
        font-weight: 700;
        text-align: center;
        line-height: 1.4;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .noc-id-badge span { font-size: 15px; }
    .detail-block { padding: 12px 16px; background: #f8f9ff; border-radius: 10px; }
    .detail-label  { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; color: #6c757d; display: block; margin-bottom: 4px; }
    .detail-value  { margin: 0; font-weight: 500; color: #212529; }
</style>

<script>
    document.querySelector('.delete-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        if (confirm('Delete this NOC? This cannot be undone.')) this.submit();
    });
</script>
@endsection