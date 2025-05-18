@extends('ngo.layout.master')

@section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Add Photos</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Gallery</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            {{-- Upload form --}}
            <form action="{{ route('save-photo') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class=" row mb-3">
                    <div class="col">
                        <label class="form-label">Upload Photos</label>

                        <div id="drop-area" class="border rounded p-4 text-center bg-light" style="cursor: pointer;">
                            <p class="text-muted">Drag & drop photos here or click to select</p>
                            <input type="file" name="images[]" id="images" class="d-none" multiple accept="image/*">
                            <button type="button" class="btn btn-outline-primary mt-2"
                                onclick="document.getElementById('images').click();">Choose Files</button>
                        </div>

                        @error('images')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row mt-3" id="image-preview"></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for=" " class="form-label">Date:</label>
                        <input type="text" name="date" class="datepicker form-control" >
                        @error('date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="" class="form-label">Gallery Type: </label>
                        <select class="form-control" name="gallery_type" id="">
                            <option value="" selected>Select Type</option>
                            <option value="Gallery">For Gallery</option>
                            <option value="News">For News Paper</option>
                        </select>
                        @error('gallery_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-4">Upload</button>
            </form>


        </div>
    </div>

    <script>
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('images');
        const previewArea = document.getElementById('image-preview');

        // Drag-over styling
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, e => {
                e.preventDefault();
                dropArea.classList.add('border-primary');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, e => {
                e.preventDefault();
                dropArea.classList.remove('border-primary');
            });
        });

        // Drop event
        dropArea.addEventListener('drop', function(e) {
            e.preventDefault();
            const files = e.dataTransfer.files;
            fileInput.files = files; // Assign to input
            previewImages(files);
        });

        fileInput.addEventListener('change', function() {
            previewImages(this.files);
        });

        function previewImages(files) {
            previewArea.innerHTML = '';
            Array.from(files).forEach(file => {
                if (!file.type.startsWith('image/')) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 mb-3';
                    col.innerHTML = `
                    <div class="card">
                        <img src="${e.target.result}" class="card-img-top" style="height: 180px; object-fit: cover;">
                    </div>
                `;
                    previewArea.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
        }
    </script>
@endsection
