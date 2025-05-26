@extends('home.layout.MasterLayout')
@section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Facilities Status</h5>
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
                        <form action="{{route('check-facilities')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label class="form-label">Aadhar Card No.</label>
                                <input type="text" name="identity_no" id="aadharInput" class="form-control"
                                    value="{{ old('aadhar_no') }}" placeholder="____ ____ ____" maxlength="14"
                                    oninput="formatAadhar(this)">
                                <span id="aadharJsError" class="text-danger"></span>
                                @error('aadhar_no')
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
    <script>
        function formatAadhar(input) {
            let value = input.value.replace(/\D/g, '');

            if (value.length > 4 && value.length <= 8) {
                value = value.slice(0, 4) + ' ' + value.slice(4);
            } else if (value.length > 8) {
                value = value.slice(0, 4) + ' ' + value.slice(4, 8) + ' ' + value.slice(8, 12);
            }
            input.value = value;

            const regex = /^\d{4}\s\d{4}\s\d{4}$/;
            const errorSpan = document.getElementById('aadharJsError');

            if (value && !regex.test(value)) {
                errorSpan.textContent = "Invalid Aadhar format. Use XXXX XXXX XXXX.";
            } else {
                errorSpan.textContent = "";
            }
        }
    </script>
@endsection
