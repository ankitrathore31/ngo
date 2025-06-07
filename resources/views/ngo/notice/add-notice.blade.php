@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-item-center mb-3 mt-2">
                <h5 class="mb-0">Add Notice</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Notice</li>
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
                            <a href="" class="btn btn-success">Notice List</a>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3 form-group">
                                        <label for="" class="form-label">Notice Session <span class="text-danger">*</span></label>
                                        <select name="session" class="form-control" id="">
                                            <option value="">Select Session</option>
                                            @foreach ($session as $session)
                                                <option value="{{ $session->session_date }}">
                                                    {{ $session->session_date }}</option>
                                            @endforeach
                                            @error('session')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3 form-group">
                                        <label for="date" class="form-label">Notice Date<span class="text-danger">*</span></label>
                                        <input type="text" class="datepicker form-control @error('date') is-invalid @enderror"
                                            name="date" value="{{ old('date') }}" placeholder="DD/MM/YY">
                                        @error('date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3 form-group">
                                        <label for="" class="form-label">Notice For<span class="text-danger">*</span></label>
                                        <select class="form-control" name="notice_for" id="">
                                            <option value="" selected>Select For</option>
                                            <option value="Home">Home</option>
                                            <option value="Member">Member</option>
                                            <option value="Staff">Staff</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3 form-group">
                                        <label for="notice" class="form-label">Notice Description<span class="text-danger">*</span></label>
                                        <textarea name="notice" id="notice" cols="30" rows="10"
                                            class="form-control
                                    @error('notice') is-invalid @enderror">{{ old('notice') }}</textarea>
                                        @error('notice')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <input type="submit" class="btn btn-success" value="Add Notice">
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
