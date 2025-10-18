@extends('ngo.layout.master')
@section('content')
<div class="main-content">
    <div class="container my-5">
        <div class="card mx-auto shadow-sm" style="max-width: 600px;">
            <div class="card-header bg-warning text-white">
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

                <form method="POST" action="{{-- route('password.change') --}}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">User ID</label>
                        
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Show Password</label>
                        <input type="password" name="old_password" class="form-control" readonly required>
                        <a href="{{-- route('password.forgot') --}}" class="small d-block mt-1">Forgot old password?</a>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

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
@endsection
