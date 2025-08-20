@extends('ngo.layout.master')
@section('content')
    <style>
        /* ::placeholder {
                                                                            font-size: 8px;
                                                                        } */

        .upload-container {
            text-align: center;
            margin-top: 15px;
            padding: 10px 20px;
            margin-left: 50px;
        }

        .image-placeholder {
            width: 150px;
            height: 150px;
            /* border: 2px dashed #ccc; */
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            background-color: rgb(223, 226, 228);
        }

        .image-placeholder img {
            max-width: 100%;
            max-height: 100%;
            display: none;
        }

        .upload-btn {
            display: inline-block;
            background-color: #343a40;
            color: #fff;
            padding: 10px 15px;
            margin-right: 100px;
            font-size: 16px;
            width: auto;
            border-radius: 5px;
            cursor: pointer;
            border: none;
        }

        .upload-btn:hover {
            background-color: #495057;
        }

        #uploadInput {
            display: none;
        }
    </style>
    <div class="wrapper">
        <div class="d-flex justify-content-between aligin-item-center mb-3 mt-2">
            <h5 class="mb-0">Edit Jobs</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Jobs</li>
                </ol>
            </nav>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="container mt-5">
            <div class="card">
                <div class="card-body p-2 bg-light shadow-sm">
                    <form action="{{ route('update.job', $job->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Job Title -->
                            <div class="col-md-6 mb-3">
                                <label for="job_title" class="form-label">Job Title <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="job_title" id="job_title"
                                    class="form-control @error('job_title') is-invalid @enderror"
                                    value="{{ old('job_title', $job->job_title) }}" required>
                                @error('job_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Position -->
                            <div class="col-md-6 mb-3">
                                <label for="position_id" class="form-label">Position</label>
                                <select name="position_id" id="position_id" class="form-control">
                                    <option value="">Select Position</option>
                                    @foreach ($positions as $position)
                                        <option value="{{ $position->id }}"
                                            {{ old('position_id', $job->position_id) == $position->id ? 'selected' : '' }}>
                                            {{ $position->position }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Vacancy -->
                            <div class="col-md-6 mb-3">
                                <label for="vacancy" class="form-label">Number of Vacancies <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="vacancy" id="vacancy"
                                    class="form-control @error('vacancy') is-invalid @enderror"
                                    value="{{ old('vacancy', $job->vacancy) }}" min="1" required>
                                @error('vacancy')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Job Type -->
                            <div class="col-md-6 mb-3">
                                <label for="job_type" class="form-label">Job Type</label>
                                <select name="job_type" id="job_type" class="form-control">
                                    <option value="">Select Type</option>
                                    <option value="Full-time"
                                        {{ old('job_type', $job->job_type) == 'Full-time' ? 'selected' : '' }}>Full-time
                                    </option>
                                    <option value="Part-time"
                                        {{ old('job_type', $job->job_type) == 'Part-time' ? 'selected' : '' }}>Part-time
                                    </option>
                                    <option value="Contract"
                                        {{ old('job_type', $job->job_type) == 'Contract' ? 'selected' : '' }}>
                                        Contract</option>
                                    <option value="Internship"
                                        {{ old('job_type', $job->job_type) == 'Internship' ? 'selected' : '' }}>Internship
                                    </option>
                                </select>
                            </div>

                            <!-- Location -->
                            <div class="col-md-6 mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" name="location" id="location" class="form-control"
                                    value="{{ old('location', $job->location) }}">
                            </div>

                            <!-- Salary -->
                            <div class="col-md-6 mb-3">
                                <label for="salary" class="form-label">Salary</label>
                                <input type="text" name="salary" id="salary" class="form-control"
                                    value="{{ old('salary', $job->salary) }}">
                            </div>

                            <!-- Deadline -->
                            <div class="col-md-6 mb-3">
                                <label for="deadline" class="form-label">Application Deadline</label>
                                <input type="date" name="deadline" id="deadline" class="form-control"
                                    value="{{ old('deadline', $job->deadline) }}">
                            </div>

                            <!-- Description -->
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Job Description</label>
                                <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $job->description) }}</textarea>
                            </div>

                            <!-- Requirements -->
                            <div class="col-md-12 mb-3">
                                <label for="requirements" class="form-label">Requirements</label>
                                <textarea name="requirements" id="requirements" rows="4" class="form-control">{{ old('requirements', $job->requirements) }}</textarea>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="active"
                                        {{ old('status', $job->status) == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="closed"
                                        {{ old('status', $job->status) == 'closed' ? 'selected' : '' }}>Closed
                                    </option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Job</button>
                        <a href="{{ route('list.job') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
