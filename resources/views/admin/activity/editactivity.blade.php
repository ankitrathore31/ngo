@extends('admin.layout.AdminLayout')
@Section('content')
    <div class="container mt-5">
        <div class="row card m-1">
            <div class="col m-3 d-flex justify-content-center">
                <h3><u><b>ADD ACTIVITY</b></u></h3>
            </div>
        </div>
        <div class="card m-1">
            <form action="{{route ("updateactivity", ['id' => $activity->id]) }}" method="POST" enctype="multipart/form-data" class="m-3">
                @csrf
                <input type="text" hidden value="{{ $activity->id }}">
                <div class="row">
                    <div class="col-md-6 mb-3 form-group local-from">
                        {{-- <label for="">Program name <span class="login-danger">*</span></label> --}}
                        <input type="text" class="form-control @error('program_name') is-invalid @enderror"
                            name="program_name" placeholder="Program Name" value="{{ $activity->program_name }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{-- <label for="">Program Category <span class="login-danger">*</span></label> --}}
                        <select class="form-control select @error('program_category') is-invalid @enderror"
                            name="program_category" required>
                            <option value="" selected>Select Category</option>
                            <option value="Public Program"
                                {{ $activity->program_category == 'Public Program' ? 'selected' : '' }}>Public Program
                            </option>
                            <option value="Entertainment"
                                {{ $activity->program_category == 'Goverment Program' ? 'selected' : '' }}>Goverment Program
                            </option>

                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        {{-- <label for="">Program Date <span class="login-danger">*</span></label> --}}
                        <input type="date" class="form-control @error('program_date') is-invalid @enderror"
                            name="program_date" value="{{ $activity->program_date }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        {{-- <label for="">Program Time <span class="login-danger">*</span></label> --}}
                        <input type="time" class="form-control @error('program_time') is-invalid @enderror"
                            name="program_time" value="{{ $activity->program_time }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        {{-- <label for="">Program Address <span class="login-danger">*</span></label> --}}
                        <textarea class="form-control @error('program_address') is-invalid @enderror" name="program_address" rows="3"
                            placeholder="Address" required>{{ $activity->program_address }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        {{-- <label for="">Program image <span class="login-danger">*</span></label> --}}
                        <input type="file" class="form-control @error('program_image') is-invalid @enderror"
                            name="program_image" value="{{ $activity->program_image }}" required>

                    </div>
                    <div class="col-md-6">
                        <img src="{{ asset('program_images/' . $activity->program_image) }}" width="200px" height="100px"
                            alt="image">
                    </div>
                </div>
                <div class="form-group text-center mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </form>
        </div>
    </div>
@endsection
