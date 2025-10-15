@extends('ngo.layout.master')

@section('content')
   <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Upload Form</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('ngo') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Form</li>
                </ol>
            </nav>
        </div>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">📤 Upload Form/Document</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('form-downloads.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Document Title <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}" 
                                   placeholder="e.g., Registration Form "
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description (Optional)</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3" 
                                      placeholder="Brief description about this document...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div class="mb-3">
                            <label for="file" class="form-label">Upload File <span class="text-danger">*</span></label>
                            <input type="file" 
                                   class="form-control @error('file') is-invalid @enderror" 
                                   id="file" 
                                   name="file" 
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   required>
                            <small class="text-muted">Allowed: PDF, JPG, PNG | Max size: 10MB</small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview Container -->
                        <div id="preview-container" class="mb-3" style="display: none;">
                            <label class="form-label">Preview</label>
                            <div class="border rounded p-3 text-center bg-light">
                                <img id="image-preview" src="" alt="Preview" style="max-width: 100%; max-height: 300px; display: none;">
                                <div id="pdf-preview" style="display: none;">
                                    <i class="fas fa-file-pdf fa-5x text-danger"></i>
                                    <p class="mt-2 mb-0" id="file-name"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('form-downloads.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Upload Document
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        const previewContainer = document.getElementById('preview-container');
        const imagePreview = document.getElementById('image-preview');
        const pdfPreview = document.getElementById('pdf-preview');
        const fileName = document.getElementById('file-name');

        previewContainer.style.display = 'block';

        if (file.type.startsWith('image/')) {
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                pdfPreview.style.display = 'none';
            }
            reader.readAsDataURL(file);
        } else if (file.type === 'application/pdf') {
            imagePreview.style.display = 'none';
            pdfPreview.style.display = 'block';
            fileName.textContent = file.name;
        }
    }
});
</script>
@endsection