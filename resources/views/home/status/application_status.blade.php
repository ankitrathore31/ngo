@extends('home.layout.MasterLayout')
@section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Application Status</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Status</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger mt-3">{{ session('error') }}</div>
            @endif


            <div class="row">
                <div class="col">
                    <div class="card-body shadow p-3">
                        <form action="{{ route('check-status') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="col-md-6">
                                <label class="form-label">Application No.</label>
                                <input type="text" name="application_no" class="form-control"
                                    value="{{ old('application_no') }}">
                                @error('application_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="" class="form-label">Application Type: </label>
                                <select class="form-control" id="appliction_type" name="appliction_type">
                                    <option selected disabled>Select Type</option>
                                    <option value="Beneficiaries"
                                        {{ old('reg_type') == 'Beneficiaries' ? 'selected' : '' }}>
                                        Beneficiaries
                                    </option>
                                    <option value="Member" {{ old('reg_type') == 'Member' ? 'selected' : '' }}>Member
                                    </option>
                                </select>
                                @error('appliction_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success mt-4">Check</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
