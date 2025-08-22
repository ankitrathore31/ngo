@extends('home.layout.MasterLayout')
@section('content')
    <div class="wrapper">
        <div class="d-flex justify-content-between aligin-item-center mb-3 mt-2">
            <h5 class="mb-0">Apply For Jobs</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                    <li class="breadcrumb-item"><a href="{{ url('welcome') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Vacancies</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="container mb-5">
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header bg-primary text-white text-center py-3">
                <h4 class="mb-0">Apply for {{ $job->position->position }}</h4>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('vacancies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">

                        <!-- Full Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Full Name *</label>
                            <input type="text" name="name" class="form-control form-control-lg"
                                value="{{ old('name') }}" placeholder="Enter your full name" required>
                            @error('name')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email *</label>
                            <input type="email" name="email" class="form-control form-control-lg"
                                value="{{ old('email') }}" placeholder="Enter your email" required>
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Phone *</label>
                            <input type="text" name="phone" class="form-control form-control-lg"
                                value="{{ old('phone') }}" placeholder="Enter your phone number" required>
                            @error('phone')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Position Applied For -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Position *</label>
                            <input type="text" name="position" class="form-control form-control-lg"
                                value="{{ $job->position->position }}" readonly>
                        </div>

                        <!-- Address -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Full Address *</label>
                            <textarea name="address" class="form-control form-control-lg" rows="2" placeholder="Enter your full address"
                                required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Resume Upload -->
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Upload Resume (PDF/DOC) *</label>
                            <input type="file" name="resume" class="form-control form-control-lg"
                                accept=".pdf,.doc,.docx" required>
                            @error('resume')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5">
                                <i class="bi bi-send-fill"></i> Apply Now
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
