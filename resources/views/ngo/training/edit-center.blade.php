@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-item-center mb-3 mt-2">
                <h5 class="mb-0">Add Center</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Training Center</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <div class="col">
                    <div class="card p-3 m-3 bg-light shadow rounded">
                        <div class="card-header">
                            <a href="{{ route('center-list') }}" class="btn btn-success">Training Center List</a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('update-center', $center->id) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="session" class="form-label">Session <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control @error('session') is-invalid @enderror" name="session"
                                            required>
                                            <option value="">Select Session</option>
                                            @foreach ($session as $session)
                                                <option value="{{ $session->session_date }}"
                                                    {{ old('session', $center->academic_session) == $session->session_date ? 'selected' : '' }}>
                                                    {{ $session->session_date }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('session')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Training Center Code -->
                                    <div class="col-md-4 mb-3 form-group">
                                        <label for="center_code" class="form-label">Training Center Code <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="center_code" id="center_code"
                                            class="form-control @error('center_code') is-invalid @enderror"
                                            value="{{ old('center_code', $center->center_code) }}" readonly>
                                        @error('center_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Training Center Name -->
                                    <div class="col-md-4 mb-3 form-group">
                                        <label for="center_name" class="form-label">Training Center Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="center_name" id="center_name"
                                            class="form-control @error('center_name') is-invalid @enderror"
                                            value="{{ old('center_name', $center->center_name) }}">
                                        @error('center_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 form-group mb-3">
                                        <label for="village" class="form-label">Village/Locality: <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="village" id="village"
                                            class="form-control @error('village') is-invalid @enderror"
                                            value="{{ old('village', $center->center_address) }}">
                                        @error('village')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 form-group mb-3">
                                        <label for="post" class="form-label">Post/Town: <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="post" id="post"
                                            class="form-control @error('post') is-invalid @enderror"
                                            value="{{ old('post', $center->post) }}" required>
                                        @error('post')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 form-group mb-3">
                                        <label for="block" class="form-label">Block: <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="block" id="block"
                                            class="form-control @error('block') is-invalid @enderror"
                                            value="{{ old('block', $center->block) }}" required>
                                        @error('block')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- State --}}
                                    @php $districtsByState = config('districts'); @endphp
                                    <div class="col-md-4 mb-3">
                                        <label for="stateSelect">State <span class="text-danger">*</span></label>
                                        <select class="form-control @error('state') is-invalid @enderror" name="state"
                                            id="stateSelect" required>
                                            <option value="">Select State</option>
                                            @foreach ($districtsByState as $state => $districts)
                                                <option value="{{ $state }}"
                                                    {{ old('state', $center->state) == $state ? 'selected' : '' }}>
                                                    {{ $state }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('state')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- District --}}
                                    <div class="col-md-4 mb-3">
                                        <label for="districtSelect">District <span class="text-danger">*</span></label>
                                        <select class="form-control @error('district') is-invalid @enderror" name="district"
                                            id="districtSelect" required>
                                            <option value="{{ old('district', $center->district) }}">
                                                {{ old('district', $center->district) }}
                                            </option>
                                        </select>
                                        @error('district')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-md-4 mb-3 form-group">
                                        <label for="incharge" class="form-label">Center Incharge <span
                                                class="text-danger">*</span></label>
                                        <select name="incharge" class="form-control" id="incharge">
                                            <option value="">Select Incharge</option>
                                            @foreach ($staff as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('incharge', $center->incharge_id ?? '') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }} ({{ $item->position }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('incharge')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <input type="submit" class="btn btn-success" value="Update Training Center">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
