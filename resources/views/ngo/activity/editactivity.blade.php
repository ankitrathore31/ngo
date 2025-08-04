@extends('ngo.layout.master')
@Section('content')
    <div class="container mt-5">
        <div class="card m-1">
            <div class="card-header">
                <div class="card-title border-bottom p-2 bg-info text-center">
                    <h3><b>Edit ACTIVITY</b></h3>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('updateactivity', ['id' => $activity->id]) }}" method="POST"
                    enctype="multipart/form-data" class="m-3">
                    @csrf
                    <input type="text" hidden value="{{ $activity->id }}">
                    {{-- <div class="row">
                        <div class="col-md-4 col-sm-2 mb-3 text-start">
                            <span class="me-2">Activity Sr. No. </span><input type="number"
                                value="{{ $activity->activity_no }}" name="activity_no"
                                class="w-50 @error('activity_no') is-invalid @enderror">
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-md-6 mb-3 form-group local-from">
                            <input type="text" class="form-control @error('program_name') is-invalid @enderror"
                                name="program_name" placeholder="Program Name" value="{{ $activity->program_name }}"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <select class="form-control select @error('program_category') is-invalid @enderror"
                                name="program_category" required>
                                <option value="" selected>Select Category</option>
                                @foreach ($category as $cat)
                                    <option value="{{ $cat->category }}"
                                        {{ isset($activity) && $activity->program_category == $cat->category ? 'selected' : '' }}>
                                        {{ $cat->category }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="">Program Date <span class="login-danger">*</span></label>
                            <input type="text"
                                class="datepicker form-control @error('program_date') is-invalid @enderror"
                                name="program_date" value="{{ $activity->program_date }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="program_session" class="form-label bold">Program Session <span
                                    class="login-danger">*</span></label>
                            <select class="form-control @error('program_session') is-invalid @enderror"
                                name="program_session" required>
                                <option value="">Select Session</option>
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ isset($activity) && $activity->academic_session == $session->session_date ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="program_time" class="form-label bold">Program Time <span
                                    class="login-danger">*</span></label>
                            <input type="text" id="program_time" name="program_time"
                                value="{{ $activity->program_time }}"
                                class="form-control @error('program_time') is-invalid @enderror" placeholder="Select Time"
                                required>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            {{-- <label for="">Program Address <span class="login-danger">*</span></label> --}}
                            <textarea class="form-control @error('program_address') is-invalid @enderror" name="program_address" rows="3"
                                placeholder="Address" required>{{ $activity->program_address }}</textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            {{-- <label for="" class="form-label"><strong>Program Report </strong><span class="login-danger">*</span></label> --}}
                            <textarea class="form-control @error('program_report') is-invalid @enderror" name="program_report" rows="3"
                                placeholder="Program Report" required>{{ $activity->program_report }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            @if ($activity->program_image)
                                <label class="form-label">Current Image:</label><br>
                                <img src="{{ asset('program_images/' . $activity->program_image) }}" width="200"
                                    height="100" alt="Current Image" class="border">
                            @else
                                <p>No image available.</p>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="program_image" class="form-label">Change Image</label>
                            <input type="file" class="form-control @error('program_image') is-invalid @enderror"
                                name="program_image" accept="image/*">
                            @error('program_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Image Display -->
                        {{-- <div class="col-md-6 mb-3">
                            @if ($activity->program_image)
                                <label class="form-label">Current Image:</label><br>
                                <img src="{{ asset('program_images/' . $activity->program_image) }}" width="200"
                                    height="100" alt="Current Image" class="border">
                            @endif
                        </div> --}}
                    </div>

                    <div class="form-group text-center mt-4">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        function previewEditImage() {
            const file = document.getElementById('program_image').files[0];
            const previewImage = document.getElementById('previewImage');
            const maxSizeMB = 2;

            if (file) {
                const fileType = file.type.split('/')[0];
                const fileSize = file.size / 1024 / 1024;

                if (fileType !== 'image') {
                    alert("Only image files are allowed.");
                    previewImage.style.display = 'none';
                    document.getElementById('program_image').value = '';
                    return;
                }

                if (fileSize > maxSizeMB) {
                    alert("File size should be less than 2MB.");
                    previewImage.style.display = 'none';
                    document.getElementById('program_image').value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
