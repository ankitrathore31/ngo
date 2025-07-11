@extends('ngo.layout.master')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Add Event</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('event-list') }}">Event List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Event</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="card m-1">
            <div class="card-body">
                <form action="{{ route('save-event') }}" method="POST" enctype="multipart/form-data" class="m-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Event Name <span class="text-danger">*</span></label>
                            <input type="text" name="event" class="form-control @error('event') is-invalid @enderror"
                                placeholder="Enter Event Name" value="{{ old('event') }} " required>
                            @error('event')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Event Category <span class="text-danger">*</span></label>
                            <select name="event_category" class="form-control @error('event_category') is-invalid @enderror"
                                required>
                                <option value="">Select Category</option>
                                <option value="Public Program">Public Program</option>
                                <option value="Government Program">Government Program</option>
                                <option value="Education">Education</option>
                                <option value="Environment">Environment</option>
                                <option value="Social Awareness Program">Social Awareness Program</option>
                                <option value="Cultural Program">Cultural Program</option>
                                <option value="Sanitation Program">Sanitation Program</option>
                                <option value="Health Program">Health Program</option>
                                <option value="Poor Alleviation">Poor Alleviation</option>
                                <option value="Women Empowerment">Women Empowerment</option>
                                <option value="Social Problem">Social Problem</option>
                                <option value="Peace Talks Program">Peace Talks Program</option>
                                <option value="Skill Development">Skill Development</option>
                                <option value="Religious Program">Religious Program</option>
                                <option value="Agriculture Program">Agriculture Program</option>
                                <option value="Labour Tools Distribution">Labour Tools Distribution</option>
                                <option value="Drinking Water">Drinking Water</option>
                                <option value="Ration Distribution">Ration Distribution</option>
                                <option value="Disaster Management">Disaster Management</option>
                                <option value="Economic Help">Economic Help</option>
                                <option value="Cow Service">Cow Service</option>
                                <option value="Animal Food">Animal Food</option>
                                <option value="Other Activities">Other Activities</option>
                            </select>
                            @error('event_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Event Date <span class="text-danger">*</span></label>
                            <input type="date" name="event_date"
                                class="form-control @error('event_date') is-invalid @enderror" required>
                            @error('event_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Event Session <span class="text-danger">*</span></label>
                            <select name="event_session" class="form-control @error('event_session') is-invalid @enderror"
                                required>
                                <option value="">Select Session</option>
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}">{{ $session->session_date }}</option>
                                @endforeach
                            </select>
                            @error('event_session')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Event Time <span class="text-danger">*</span></label>
                            <input type="time" name="event_time"
                                class="form-control @error('event_time') is-invalid @enderror" required>
                            @error('event_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Event Address <span class="text-danger">*</span></label>
                            <textarea name="event_address" class="form-control @error('event_address') is-invalid @enderror" rows="3"
                                placeholder="Enter Address" required></textarea>
                            @error('event_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Event Report <span class="text-danger">*</span></label>
                            <textarea name="event_report" class="form-control @error('event_report') is-invalid @enderror" rows="3"
                                placeholder="Enter Report" required> {{ old('event_report') }}</textarea>
                            @error('event_report')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Event Image <span class="text-danger">*</span></label>
                            <input type="file" name="event_image" id="event_image" accept="image/*"
                                class="form-control @error('event_image') is-invalid @enderror" style="display: none;"
                                onchange="previewImage(); validateFile();" required>
                            <button type="button" class="btn btn-primary"
                                onclick="document.getElementById('event_image').click()">Choose Event Image</button>
                            <div id="imagePreviewContainer" class="mt-2">
                                <img id="imagePreview" src="" alt="Image Preview"
                                    style="max-width: 200px; max-height: 200px; display: none;">
                            </div>
                            <div id="fileError" class="text-danger" style="display: none;"></div>
                            @error('event_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group text-center mt-3">
                        <button type="submit" class="btn btn-success">Save Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage() {
            const file = document.getElementById('event_image').files[0];
            const imagePreview = document.getElementById('imagePreview');
            const fileError = document.getElementById('fileError');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
                fileError.style.display = 'none';
            }
        }

        function validateFile() {
            const file = document.getElementById('event_image').files[0];
            const fileError = document.getElementById('fileError');

            if (file) {
                const fileSizeMB = file.size / 1024 / 1024;
                const fileType = file.type.split('/')[0];

                if (fileSizeMB > 25) {
                    fileError.textContent = 'File size should be less than or equal to 25MB.';
                    fileError.style.display = 'block';
                    document.getElementById('event_image').value = '';
                    document.getElementById('imagePreview').style.display = 'none';
                    return false;
                }

                if (fileType !== 'image') {
                    fileError.textContent = 'Only image files are allowed.';
                    fileError.style.display = 'block';
                    document.getElementById('event_image').value = '';
                    document.getElementById('imagePreview').style.display = 'none';
                    return false;
                }

                fileError.style.display = 'none';
            }

            return true;
        }
    </script>
@endsection
