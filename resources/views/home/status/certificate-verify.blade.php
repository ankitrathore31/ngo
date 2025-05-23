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
                        <form action="{{-- route('check-status') --}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label class="form-label">Registraition No.</label>
                                <input type="text" name="registraiton_no" class="form-control"
                                    value="{{ old('registraiton_no') }}">
                                @error('registraiton_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Certificate No.</label>
                                <input type="text" name="certificate_no" class="form-control"
                                    value="{{ old('certificate_no') }}">
                                @error('certificate_no')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success mt-4">Verify</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
