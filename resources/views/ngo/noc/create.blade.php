@extends('ngo.layout.master')

@section('content')
<div class="wrapper">
    <div class="container-fluid mt-4">

        {{-- ── Page header ────────────────────────────────────────────────── --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="mb-0 fw-semibold text-dark">
                    <i class="fas fa-file-circle-plus me-2 text-primary"></i>Upload NOC
                </h5>
                <small class="text-muted">Add a new No Objection Certificate</small>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded-pill small">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('noc.index') }}">NOC List</a></li>
                    <li class="breadcrumb-item active">Upload NOC</li>
                </ol>
            </nav>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white py-3">
                        <h6 class="mb-0 fw-semibold">
                            <i class="fas fa-upload me-2"></i>NOC Details & File Upload
                        </h6>
                    </div>
                    <div class="card-body p-4">

                        <form action="{{ route('noc.store') }}" method="POST" enctype="multipart/form-data" id="nocForm">
                            @csrf

                            {{-- Row 1: Date + Area --}}
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">
                                        NOC Date <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-calendar-days text-muted"></i>
                                        </span>
                                        <input type="date" name="noc_date"
                                               class="form-control border-start-0 @error('noc_date') is-invalid @enderror"
                                               value="{{ old('noc_date') }}">
                                    </div>
                                    @error('noc_date')
                                        <div class="text-danger small mt-1"><i class="fas fa-circle-exclamation me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">
                                        NOC Area <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-map-location-dot text-muted"></i>
                                        </span>
                                        <input type="text" name="noc_area"
                                               class="form-control border-start-0 @error('noc_area') is-invalid @enderror"
                                               placeholder="e.g. North Zone, Ward 5"
                                               value="{{ old('noc_area') }}">
                                    </div>
                                    @error('noc_area')
                                        <div class="text-danger small mt-1"><i class="fas fa-circle-exclamation me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Row 2: Issuer Name + Designation --}}
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">
                                        Name Of The Person Issuing NOC <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                        <input type="text" name="issuer_name"
                                               class="form-control border-start-0 @error('issuer_name') is-invalid @enderror"
                                               placeholder="Full name of issuing person"
                                               value="{{ old('issuer_name') }}">
                                    </div>
                                    @error('issuer_name')
                                        <div class="text-danger small mt-1"><i class="fas fa-circle-exclamation me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">
                                        Designation Of The Person Issuing NOC <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-id-badge text-muted"></i>
                                        </span>
                                        <input type="text" name="issuer_designation"
                                               class="form-control border-start-0 @error('issuer_designation') is-invalid @enderror"
                                               placeholder="e.g. District Collector"
                                               value="{{ old('issuer_designation') }}">
                                    </div>
                                    @error('issuer_designation')
                                        <div class="text-danger small mt-1"><i class="fas fa-circle-exclamation me-1"></i>{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- File Upload --}}
                            <div class="mb-4">
                                <label class="form-label fw-medium">
                                    NOC File <span class="text-danger">*</span>
                                    <small class="text-muted fw-normal">(PDF, Image, or any document — max 10 MB)</small>
                                </label>

                                <div id="drop-area" class="drop-zone rounded-3 p-4 text-center position-relative @error('noc_file') border-danger @enderror">
                                    <input type="file" name="noc_file" id="noc_file" class="d-none"
                                           accept=".jpg,.jpeg,.png,.gif,.webp,.bmp,.pdf,.doc,.docx,.xls,.xlsx,.txt">

                                    <div id="dropPlaceholder">
                                        <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                                        <p class="mb-1 fw-medium">Drag & drop your file here</p>
                                        <p class="text-muted small mb-3">Supports PDF, Images (JPG/PNG), Word, Excel, and more</p>
                                        <button type="button" class="btn btn-outline-primary btn-sm px-4"
                                                onclick="document.getElementById('noc_file').click()">
                                            <i class="fas fa-folder-open me-2"></i>Browse File
                                        </button>
                                    </div>

                                    {{-- File selected preview --}}
                                    <div id="filePreview" class="d-none">
                                        <div id="imagePreviewBox" class="d-none">
                                            <img id="previewImg" src="" alt="Preview"
                                                 class="img-fluid rounded-2 mb-2" style="max-height:160px;">
                                        </div>
                                        <div id="fileIconBox" class="d-none">
                                            <i id="fileIcon" class="fa-solid fa-file fa-3x mb-2"></i>
                                        </div>
                                        <p id="fileName" class="mb-1 fw-medium"></p>
                                        <p id="fileSize" class="text-muted small mb-2"></p>
                                        <button type="button" class="btn btn-outline-danger btn-sm" id="clearFile">
                                            <i class="fas fa-xmark me-1"></i>Remove
                                        </button>
                                    </div>
                                </div>

                                @error('noc_file')
                                    <div class="text-danger small mt-1"><i class="fas fa-circle-exclamation me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Actions --}}
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-upload me-2"></i>Save NOC
                                </button>
                                <a href="{{ route('noc.index') }}" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-arrow-left me-2"></i>Cancel
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .drop-zone {
        border: 2px dashed #0d6efd66;
        background: #f8f9ff;
        transition: border-color .2s, background .2s;
        cursor: pointer;
        min-height: 160px;
        display: flex; align-items: center; justify-content: center;
    }
    .drop-zone.dragover {
        border-color: #0d6efd;
        background: #e8efff;
    }
    .drop-zone.border-danger {
        border-color: #dc3545aa;
    }
</style>

<script>
    const dropArea  = document.getElementById('drop-area');
    const fileInput = document.getElementById('noc_file');
    const placeholder = document.getElementById('dropPlaceholder');
    const preview   = document.getElementById('filePreview');
    const imgBox    = document.getElementById('imagePreviewBox');
    const iconBox   = document.getElementById('fileIconBox');

    // Drag events
    ['dragenter','dragover'].forEach(ev => {
        dropArea.addEventListener(ev, e => { e.preventDefault(); dropArea.classList.add('dragover'); });
    });
    ['dragleave','drop'].forEach(ev => {
        dropArea.addEventListener(ev, e => { e.preventDefault(); dropArea.classList.remove('dragover'); });
    });
    dropArea.addEventListener('drop', e => {
        fileInput.files = e.dataTransfer.files;
        handleFile(fileInput.files[0]);
    });
    dropArea.addEventListener('click', e => {
        if (!e.target.closest('#filePreview')) fileInput.click();
    });
    fileInput.addEventListener('change', () => handleFile(fileInput.files[0]));
    document.getElementById('clearFile').addEventListener('click', () => {
        fileInput.value = '';
        preview.classList.add('d-none');
        placeholder.classList.remove('d-none');
    });

    function formatBytes(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes/1024).toFixed(1) + ' KB';
        return (bytes/1048576).toFixed(1) + ' MB';
    }

    function handleFile(file) {
        if (!file) return;
        placeholder.classList.add('d-none');
        preview.classList.remove('d-none');
        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileSize').textContent = formatBytes(file.size);

        const ext = file.name.split('.').pop().toLowerCase();
        const imageExts = ['jpg','jpeg','png','gif','webp','bmp'];

        if (imageExts.includes(ext)) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('previewImg').src = e.target.result;
                imgBox.classList.remove('d-none');
                iconBox.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        } else {
            imgBox.classList.add('d-none');
            iconBox.classList.remove('d-none');
            const icon = document.getElementById('fileIcon');
            if (ext === 'pdf') {
                icon.className = 'fa-solid fa-file-pdf fa-3x mb-2 text-danger';
            } else if (['doc','docx'].includes(ext)) {
                icon.className = 'fa-solid fa-file-word fa-3x mb-2 text-primary';
            } else if (['xls','xlsx'].includes(ext)) {
                icon.className = 'fa-solid fa-file-excel fa-3x mb-2 text-success';
            } else {
                icon.className = 'fa-solid fa-file fa-3x mb-2 text-secondary';
            }
        }
    }
</script>
@endsection