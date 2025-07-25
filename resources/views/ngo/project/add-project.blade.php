@extends('ngo.layout.master')
@Section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Add Project</h5>
            <!-- Breadcrumb aligned to right -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('list.project') }}">Project List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Project</li>
                </ol>
            </nav>
        </div>
        <div class="card m-1">
            <div class="card-body">
                <form action="{{ route('store.project') }}" method="POST" enctype="multipart/form-data" class="m-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="program_session" class="form-label ">Project Session <span
                                    class="text-danger">*</span></label>
                            <select class="form-control @error('session') is-invalid @enderror" name="session" required>
                                <option value="">Select Session</option>
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}">{{ $session->session_date }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="code" class="form-label">Project Code</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                                value="{{ old('code') }}" placeholder="Enter Project code" required>
                            @error('code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group local-from">
                            <label class="form-label">Project name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                placeholder="Enter Project Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class="form-label">Project Category <span
                                    class="text-danger">*</span></label>
                            <select class="form-control select @error('category') is-invalid @enderror" name="category"
                                required>
                                <option value="" selected>Select Category</option>
                                <option value="Public Project">Public Project</option>
                                <option value="Government Project">Government Project</option>
                                <option value="Education">Education</option>
                                <option value="Environment">Environment</option>
                                <option value="Social Awareness Project">Social Awareness Project</option>
                                <option value="Cultural Project">Cultural Project</option>
                                <option value="Sanitation Project">Sanitation Project</option>
                                <option value="Health Project">Health Project</option>
                                <option value="Poor Alleviation">Poor Alleviation</option>
                                <option value="Women Empowerment">Women Empowerment</option>
                                <option value="Social Problem">Social Problem</option>
                                <option value="Peace Talks Project">Peace Talks Project</option>
                                <option value="Skill Development">Skill Development</option>
                                <option value="Religious Project">Religious Project</option>
                                <option value="Agriculture Project">Agriculture Project</option>
                                <option value="Labour Tools Distribution">Labour Tools Distribution</option>
                                <option value="Drinking Water">Drinking Water</option>
                                <option value="Ration Distribution">Ration Distribution</option>
                                <option value="Disaster Management">Disaster Management</option>
                                <option value="Economic Help">Economic Help</option>
                                <option value="Cow Service">Cow Service</option>
                                <option value="Animal Food">Animal Food</option>
                                <option value="Other Activities">Other Activities</option>
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label">Project Sub Category <span
                                    class="text-danger">*</span></label>
                            <input class="form-control @error('sub_category') is-invalid @enderror" name="sub_category"
                                placeholder="Project Sub Category" value="{{ old('sub_category') }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <!-- Custom File Input (hidden default) -->
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                name="image" id="image" required accept="image/*" style="display: none;"
                                onchange="previewImage(); validateFile()">

                            <!-- Custom Button to Trigger File Input -->
                            <button type="button" class="btn btn-primary" id="chooseFileBtn">Choose Project
                                Image</button>

                            <!-- Image Preview -->
                            <div id="imagePreviewContainer" style="margin-top: 10px;">
                                <img id="imagePreview" src="" alt="Image Preview"
                                    style="max-width: 200px; max-height: 200px; display: none;">
                            </div>

                            <!-- Error Message for Validation -->
                            <div id="fileError" class="text-danger" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Trigger the hidden file input when the button is clicked
        document.getElementById('chooseFileBtn').addEventListener('click', function() {
            document.getElementById('image').click();
        });

        // Preview the uploaded image
        function previewImage() {
            const file = document.getElementById('image').files[0];
            const imagePreview = document.getElementById('imagePreview');
            const fileError = document.getElementById('fileError');

            // Check if a file is selected
            if (file) {
                const reader = new FileReader();

                // Display the image preview
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);

                // Reset error message
                fileError.style.display = 'none';
            }
        }

        // Validate file size (<= 2MB) and file type (only images)
        function validateFile() {
            const file = document.getElementById('image').files[0];
            const fileError = document.getElementById('fileError');

            if (file) {
                const fileSize = file.size / 1024 / 1024;
                const fileType = file.type.split('/')[0];

                if (fileSize > 40) {
                    fileError.textContent = 'File size should be less than or equal to 25MB.';
                    fileError.style.display = 'block';
                    document.getElementById('image').value = ''; // Reset the file input
                    document.getElementById('imagePreview').style.display = 'none'; // Hide the preview
                    return false;
                }

                // File type check (only images)
                if (fileType !== 'image') {
                    fileError.textContent = 'Only image files are allowed.';
                    fileError.style.display = 'block';
                    document.getElementById('image').value = ''; // Reset the file input
                    document.getElementById('imagePreview').style.display = 'none'; // Hide the preview
                    return false;
                }
            }

            return true;
        }
    </script>
@endsection
