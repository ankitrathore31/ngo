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
                            <a href="{{route('center-list')}}" class="btn btn-success">Training Center List</a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('store-center') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3 form-group">
                                        <label for="session" class="form-label">Center Session <span
                                                class="text-danger">*</span></label>
                                        <select name="session" class="form-control" id="session">
                                            <option value="">Select Session</option>
                                            @foreach ($session as $s)
                                                <option value="{{ $s->session_date }}"
                                                    {{ old('session') == $s->session_date ? 'selected' : '' }}>
                                                    {{ $s->session_date }}
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
                                            value="{{ old('center_code') }}">
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
                                            value="{{ old('center_name') }}">
                                        @error('center_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Training Center Address -->
                                    <div class="col-md-4 mb-3 form-group">
                                        <label for="center_address" class="form-label">Training Center Address <span
                                                class="text-danger">*</span></label>
                                        <textarea name="center_address" id="center_address" cols="30" rows="4"
                                            class="form-control @error('center_address') is-invalid @enderror" cols="30" rows="10">{{ old('center_address') }}</textarea>
                                        @error('center_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <input type="submit" class="btn btn-success" value="Add Training Center">
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
