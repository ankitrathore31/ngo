@extends('ngo.layout.master')
@Section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-address mb-3">
            <h5 class="mb-0">Edit Head Organization</h5>
            <!-- Breadcrumb aligned to right -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('list.head.organization') }}">Head Organization List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Organization</li>
                </ol>
            </nav>
        </div>
        <div class="card m-1">
            <div class="card-body">
                <form action="{{ route('update.head.organization',$org->id) }}" method="POST" enctype="multipart/form-data"
                    class="m-3">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="academic_session" class="form-label ">Organization Session <span
                                    class="text-danger">*</span></label>
                            <select class="form-control @error('academic_session') is-invalid @enderror"
                                name="academic_session" required>
                                <option value="">Select Session</option>
                                @foreach ($data as $session)
                                    <option value="{{ $session->session_date }}"
                                        {{ old('academic_session', $org->academic_session) == $session->session_date ? 'selected' : '' }}>
                                        {{ $session->session_date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3 form-group local-from">
                            <label class="form-label">Organization name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name', $org->name) }}" placeholder="Enter Organization Name" required>
                        </div>
                    </div>

                    <div class="form-group text-address">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
