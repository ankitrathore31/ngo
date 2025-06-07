@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-item-center mb-3 mt-2">
                <h5 class="mb-0">Edit Notice</h5>
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
                            <a href="{{ route('notice-list') }}" class="btn btn-success">Notice List</a>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('update-notice', $notice->id ) }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 mb-3 form-group">
                                        <label for="" class="form-label">Notice Session <span
                                                class="text-danger">*</span></label>
                                        <select name="session" class="form-control" id="">
                                            <option value="">Select Session</option>
                                            @foreach ($session as $session)
                                                <option value="{{ $session->session_date }}"
                                                    {{ old('academic_session', $notice->academic_session) == $session->session_date ? 'selected' : '' }}>
                                                    {{ $session->session_date }}
                                                </option>
                                            @endforeach
                                            @error('session')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3 form-group">
                                        <label for="date" class="form-label">Notice Date<span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            class="datepicker form-control @error('date') is-invalid @enderror"
                                            name="date" value="{{ $notice->date }}" placeholder="DD/MM/YY">
                                        @error('date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3 form-group">
                                        <label for="" class="form-label">Notice For<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" name="notice_for" id="">
                                            <option value="" selected>Select For</option>
                                            <option value="Home" {{ (old('notice_for') ?? $notice->notice_for) == 'Home' ? 'selected' : '' }}>Home</option>
                                            <option value="Member" {{ (old('notice_for') ?? $notice->notice_for) == 'Member' ? 'selected' : '' }}>Member</option>
                                            <option value="Staff" {{ (old('notice_for') ?? $notice->notice_for) == 'Staff' ? 'selected' : '' }}>Staff</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3 form-group">
                                        <label for="notice" class="form-label">Notice Description<span
                                                class="text-danger">*</span></label>
                                        <textarea name="notice" id="notice" cols="30" rows="10"
                                            class="form-control
                                    @error('notice') is-invalid @enderror">{{ $notice->notice }}</textarea>
                                        @error('notice')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-6">
                                        <input type="submit" class="btn btn-success" value="Update Notice">
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
