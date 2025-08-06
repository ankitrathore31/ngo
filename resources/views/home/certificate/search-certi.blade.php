@extends('home.layout.MasterLayout')
@section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Certificate Download</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Certificate</li>
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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="container mb-4">
                <label for="typeSelector" class="form-label">Select Type</label>
                <select class="form-control" id="typeSelector">
                    <option value="" disabled selected>-- Select --</option>
                    <option value="member">Member</option>
                    <option value="bene">Beneficiary</option>
                    <option value="donor">Donor</option>
                </select>
            </div>

            <div class="container" id="bene">
                <div class="row">
                    <div class="col">
                        <div class="card-body shadow p-3">
                            <form action="{{ route('certi.bene') }}" method="POST" enctype="multipart/form-data">
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
                                    <label class="form-label">Dob</label>
                                    <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                                    @error('dob')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success mt-4">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container" id="donor">
                <div class="row">
                    <div class="col">
                        <div class="card-body shadow p-3">
                            <form action="{{ route('certi.donor') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <label class="form-label">Mobile No.</label>
                                    <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}">
                                    @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success mt-4">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container" id="member">
                <div class="row">
                    <div class="col">
                        <div class="card-body shadow p-3">
                            <form action="{{ route('certi.member') }}" method="POST" enctype="multipart/form-data">
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
                                    <label class="form-label">Dob</label>
                                    <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                                    @error('dob')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success mt-4">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selector = document.getElementById('typeSelector');
            const containers = ['bene', 'donor', 'member'];

            selector.addEventListener('change', function() {
                containers.forEach(id => {
                    document.getElementById(id).style.display = 'none';
                });

                const selected = this.value;
                const selectedForm = document.querySelector(`#${selected} form`);
                if (selectedForm) {
                    selectedForm.setAttribute('action', `/certificate/${selected}`);
                    document.getElementById(selected).style.display = 'block';
                }
            });

            // Initially hide all
            containers.forEach(id => {
                document.getElementById(id).style.display = 'none';
            });
        });
    </script>
@endsection
