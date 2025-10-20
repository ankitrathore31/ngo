@extends('ngo.layout.master')

@section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Add True Story</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">True Story</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row mt-2 mb-3">
        <div class="col">
            <a href="{{route('true.story')}}" class="btn btn-primary">BACK</a>
        </div>
    </div>

            <form action="{{ route('save-story') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- Upload Photos --}}
                <div class="row mb-3">
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

                {{-- Story Name --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Story Title / Name:</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter story title">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- YouTube Link --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="link" class="form-label">YouTube Video Link:</label>
                        <input type="text" name="link" id="link" class="form-control" placeholder="Paste YouTube link">
                        @error('link')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- YouTube Video Preview --}}
                <div class="row mb-3" id="video-preview-container" style="display: none;">
                    <div class="col-md-8">
                        <div class="ratio ratio-16x9 border rounded">
                            <iframe id="video-preview" width="100%" height="400" frameborder="0"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div class="row mb-3">
                    <div class="col">
                        <label for="description" class="form-label">Description:</label>
                        <textarea name="description" id="description" rows="4" class="form-control" placeholder="Write about this story..."></textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Date --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="date" class="form-label">Date:</label>
                        <input type="date" name="date" class="datepicker form-control">
                        @error('date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-success mt-4">Upload</button>
            </form>
        </div>
    </div>

    {{-- JS for Image Preview + YouTube Embed --}}
    <script>
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('images');
        const previewArea = document.getElementById('image-preview');
        const linkInput = document.getElementById('link');
        const videoPreview = document.getElementById('video-preview');
        const videoContainer = document.getElementById('video-preview-container');

        // === Image Drag & Drop Preview ===
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

        dropArea.addEventListener('drop', function(e) {
            e.preventDefault();
            const files = e.dataTransfer.files;
            fileInput.files = files;
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

        // === YouTube Link Live Preview ===
        linkInput.addEventListener('input', function() {
            const url = this.value.trim();
            const videoId = extractYouTubeId(url);
            if (videoId) {
                const embedUrl = `https://www.youtube.com/embed/${videoId}`;
                videoPreview.src = embedUrl;
                videoContainer.style.display = 'block';
            } else {
                videoPreview.src = '';
                videoContainer.style.display = 'none';
            }
        });

        function extractYouTubeId(url) {
            const regExp = /(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|v\/))([\w-]{11})/;
            const match = url.match(regExp);
            return match ? match[1] : null;
        }
    </script>
@endsection
