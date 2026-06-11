@extends('ngo.layout.master')

@section('content')
<div class="wrapper">
    <div class="container-fluid mt-4">

        {{-- ── Page header ────────────────────────────────────────────────── --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="mb-0 fw-semibold text-dark">
                    <i class="fas fa-file-shield me-2 text-primary"></i>NOC List
                </h5>
                {{-- <small class="text-muted">Manage No Objection Certificates</small> --}}
            </div>
            <div class="d-flex align-items-center gap-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded-pill small">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">NOC List</li>
                    </ol>
                </nav>
                <a href="{{ route('noc.create') }}" class="btn btn-primary btn-sm px-3">
                    <i class="fas fa-plus me-1"></i> Add NOC
                </a>
            </div>
        </div>

        {{-- ── Flash messages ─────────────────────────────────────────────── --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                <i class="fas fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- ── Stats cards ─────────────────────────────────────────────────── --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0d6efd !important;">
                    <div class="card-body d-flex align-items-center gap-3 py-3">
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-file-lines text-primary fa-lg"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-4 lh-1">{{ $nocs->total() }}</div>
                            <small class="text-muted">Total NOCs</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #198754 !important;">
                    <div class="card-body d-flex align-items-center gap-3 py-3">
                        <div class="bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-image text-success fa-lg"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-4 lh-1">{{ \App\Models\Noc::where('file_type','image')->count() }}</div>
                            <small class="text-muted">Images</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #dc3545 !important;">
                    <div class="card-body d-flex align-items-center gap-3 py-3">
                        <div class="bg-danger bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-file-pdf text-danger fa-lg"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-4 lh-1">{{ \App\Models\Noc::where('file_type','pdf')->count() }}</div>
                            <small class="text-muted">PDFs</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #fd7e14 !important;">
                    <div class="card-body d-flex align-items-center gap-3 py-3">
                        <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="fas fa-paperclip text-warning fa-lg"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-4 lh-1">{{ \App\Models\Noc::where('file_type','other')->count() }}</div>
                            <small class="text-muted">Other Files</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Table card ───────────────────────────────────────────────────── --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <span class="fw-semibold text-dark">
                    <i class="fas fa-list me-2 text-muted"></i>NOC Records
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="nocTable">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width:55px;">Sr.</th>
                                <th>NOC Date</th>
                                <th>NOC Area</th>
                                <th>Name Of The Person Issuing NO</th>
                                <th>Designation Of The Person Issuing</th>
                                <th style="width:100px;">File</th>
                                <th class="text-center" style="width:140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($nocs as $index => $noc)
                            <tr>
                                <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge bg-primary bg-opacity-10 text-primary fw-normal px-2 py-1">
                                        <i class="fas fa-calendar-days me-1"></i>
                                        {{ \Carbon\Carbon::parse($noc->noc_date)->format('d M Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-medium">{{ $noc->noc_area }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle">
                                            {{ strtoupper(substr($noc->issuer_name, 0, 1)) }}
                                        </div>
                                        <span>{{ $noc->issuer_name }}</span>
                                    </div>
                                </td>
                                <td><span class="text-muted">{{ $noc->issuer_designation }}</span></td>
                                <td>
                                    @if($noc->file_type === 'image')
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            <i class="fas fa-image me-1"></i>Image
                                        </span>
                                    @elseif($noc->file_type === 'pdf')
                                        <span class="badge bg-danger bg-opacity-10 text-danger">
                                            <i class="fas fa-file-pdf me-1"></i>PDF
                                        </span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-warning">
                                            <i class="fas fa-paperclip me-1"></i>File
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        {{-- View --}}
                                        <a href="{{ route('noc.show', $noc->id) }}"
                                           class="btn btn-sm btn-outline-info action-btn"
                                           data-bs-toggle="tooltip" title="View NOC">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        {{-- Edit --}}
                                        <a href="{{ route('noc.edit', $noc->id) }}"
                                           class="btn btn-sm btn-outline-warning action-btn"
                                           data-bs-toggle="tooltip" title="Edit NOC">
                                            <i class="fas fa-pen-to-square"></i>
                                        </a>
                                        {{-- Delete --}}
                                        <form action="{{ route('noc.destroy', $noc->id) }}" method="POST"
                                              class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger action-btn"
                                                    data-bs-toggle="tooltip" title="Delete NOC">
                                                <i class="fas fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-folder-open fa-2x mb-2 d-block opacity-40"></i>
                                        No NOC records found.
                                        <a href="{{ route('noc.create') }}" class="d-block mt-2">Upload your first NOC</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($nocs->hasPages())
            <div class="card-footer bg-white border-top py-3 d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Page {{ $nocs->currentPage() }} of {{ $nocs->lastPage() }}
                </small>
                {{ $nocs->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>

    </div>{{-- /container --}}
</div>

{{-- ── Inline styles ─────────────────────────────────────────────────────── --}}
<style>
    .avatar-circle {
        width: 32px; height: 32px;
        background: linear-gradient(135deg, #0d6efd22, #0d6efd44);
        color: #0d6efd;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700;
        flex-shrink: 0;
    }
    .action-btn {
        width: 32px; height: 32px;
        padding: 0;
        display: inline-flex; align-items: center; justify-content: center;
        border-radius: 8px !important;
    }
    .table > tbody > tr:hover { background-color: #f8f9ff; }
</style>

<script>
    // Tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el, { trigger: 'hover' });
    });

    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this NOC? This action cannot be undone.')) {
                this.submit();
            }
        });
    });

    // Auto-dismiss success alert
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) { const bsAlert = new bootstrap.Alert(alert); bsAlert.close(); }
    }, 4000);
</script>
@endsection