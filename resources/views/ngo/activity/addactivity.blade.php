@extends('ngo.layout.master')
@Section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Add Activity</h5>

            <!-- Breadcrumb aligned to right -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('activitylist') }}">Activity List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Activity</li>
                </ol>
            </nav>
        </div>
        <div class="card m-1">
            {{-- <div class="card-header">
                <div class="card-title border-bottom p-2 bg-info text-center">
                    <h3><b>ADD ACTIVITY</b></h3>
                </div>
            </div> --}}
            <div class="card-body">
                <form action="{{ route('saveactivity') }}" method="POST" enctype="multipart/form-data" class="m-3">
                    @csrf
                    {{-- <div class="row">
                        <div class="col-md-4 col-sm-2 mb-3 text-start">
                            <span class="me-2">Activity Sr. No. </span><input type="number" name="activity_no"
                                class="w-50 @error('activity_no') is-invalid @enderror">
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group local-from">
                            {{-- <label for="">Program name <span class="login-danger">*</span></label> --}}
                            <input type="text" class="form-control @error('program_name') is-invalid @enderror"
                                name="program_name" placeholder="Program Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <select class="form-control select @error('program_category') is-invalid @enderror"
                                name="program_category" required>
                                <option value="" selected>Select Category</option>
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
                        </div>


                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label bold">Program Date <span
                                    class="login-danger">*</span></label>
                            <input type="text" id="datepicker"
                                class="datepicker form-control @error('program_date') is-invalid @enderror"
                                name="program_date" placeholder="Select Date" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="program_session" class="form-label bold">Program Session <span
                                    class="login-danger">*</span></label>
                            <select class="form-control @error('program_session') is-invalid @enderror"
                                name="program_session" required>
                                <option value="">Select Session</option>
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}">{{ $session->session_date }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="program_time" class="form-label bold">Program Time <span
                                    class="login-danger">*</span></label>
                            <input type="time" id="program_time" name="program_time"
                                class="form-control @error('program_time') is-invalid @enderror" placeholder="Select Time"
                                required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                {{-- <label for="">Program Address <span class="login-danger">*</span></label> --}}
                                <textarea class="form-control @error('program_address') is-invalid @enderror" name="program_address" rows="3"
                                    placeholder="Address" required></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                {{-- <label for="">Program Report <span class="login-danger">*</span></label> --}}
                                <textarea class="form-control @error('program_report') is-invalid @enderror" name="program_report" rows="3"
                                    placeholder="Program Report" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <!-- Label for Program Image -->
                                {{-- <label for="program_image" class="form-label">Choose Program Image <span
                                        class="login-danger">*</span></label> --}}

                                <!-- Custom File Input (hidden default) -->
                                <input type="file" class="form-control @error('program_image') is-invalid @enderror"
                                    name="program_image" id="program_image" required accept="image/*" style="display: none;"
                                    onchange="previewImage(); validateFile()">

                                <!-- Custom Button to Trigger File Input -->
                                <button type="button" class="btn btn-primary" id="chooseFileBtn">Choose Program
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
            document.getElementById('program_image').click();
        });

        // Preview the uploaded image
        function previewImage() {
            const file = document.getElementById('program_image').files[0];
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
            const file = document.getElementById('program_image').files[0];
            const fileError = document.getElementById('fileError');

            if (file) {
                const fileSize = file.size / 1024 / 1024; 
                const fileType = file.type.split('/')[0];

                if (fileSize > 40) {
                    fileError.textContent = 'File size should be less than or equal to 25MB.';
                    fileError.style.display = 'block';
                    document.getElementById('program_image').value = ''; // Reset the file input
                    document.getElementById('imagePreview').style.display = 'none'; // Hide the preview
                    return false;
                }

                // File type check (only images)
                if (fileType !== 'image') {
                    fileError.textContent = 'Only image files are allowed.';
                    fileError.style.display = 'block';
                    document.getElementById('program_image').value = ''; // Reset the file input
                    document.getElementById('imagePreview').style.display = 'none'; // Hide the preview
                    return false;
                }
            }

            return true;
        }
    </script>
@endsection
