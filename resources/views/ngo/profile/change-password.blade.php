@extends('ngo.layout.master')
@section('content')
    <div class="main-content">
        <div class="container my-5">
            <div class="row g-4 justify-content-center">

                {{-- 👤 User Info Card --}}
                <div class="col-md-6">
                    <div class="card shadow-sm border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">User Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">User Email</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->email }}" readonly>
                            </div>

                            @if (Auth::user()->user_type == 'staff')
                                <div class="mb-3">
                                    <label class="form-label">Staff Name</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->staff->name }}"
                                        readonly>
                                </div>
                            @endif

                            @if (Auth::user()->user_type == 'ngo')
                                <div class="mb-3">
                                    <label class="form-label">Ngo Name</label>
                                    <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-control" value="********" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 🔑 Change Password Card --}}
                <div class="col-md-6">
                    <div class="card shadow-sm border-success">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Change Password</h5>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.change') }}">
                                @csrf

                                {{-- New Password --}}
                                <div class="mb-3">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="new_password" class="form-control" required>
                                </div>

                                {{-- Confirm New Password --}}
                                <div class="mb-3">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="new_password_confirmation" class="form-control" required>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-success">Change Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>


    </div>
@endsection
