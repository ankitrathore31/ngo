@extends('ngo.layout.master')
@Section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Add Social Problem Solution</h5>

            <!-- Breadcrumb aligned to right -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ route('ngo') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Social Problem</li>
                </ol>
            </nav>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 mb-2">
                        <b>Problem No:</b> {{ $problem->problem_date }}
                    </div>
                    <div class="col-sm-6 mb-2">
                        <b>Problem Discover By:</b> {{ $problem->problem_by }}
                    </div>
                    <div class="col-sm-12 mb-2">
                        <b>Problem Description:</b> {{ $problem->description }}
                    </div>
                </div>
            </div>
        </div>
        <div class="card m-2">
            <div class="card-body">
                <form action="{{ route('store.solution', $problem->id) }}" method="POST" enctype="multipart/form-data" class="m-3">
                    @csrf
                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label">Solution Date <span
                                    class="text-danger">*</span></label>
                            <input type="date" id=""
                                class=" form-control @error('solution_date') is-invalid @enderror" name="solution_date"
                                placeholder="Select Date" required>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label">Solution Description <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control @error('solution_description') is-invalid @enderror" name="solution_description"
                                    rows="3" placeholder="Solution Description" required>{{ old('solution_description') }}</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="solution_by" class="form-label">Problem Discovered By <span
                                        class="text-danger">*</span></label>
                                <select class="form-control @error('solution_by') is-invalid @enderror" name="solution_by"
                                    required>
                                    <option value="">Select By</option>
                                    @foreach ($staff as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('solution_by', $problem->problem_by ?? '') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }} ({{ $item->position }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('solution_by')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                </form>
            </div>
        </div>
    </div>
@endsection
