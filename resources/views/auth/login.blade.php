<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Login</title> --}}
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            font-size: 1.25rem;
            text-align: center;
            font-weight: 500;
        }
        .form-group label {
            font-weight: 500;
        }
        .btn-primary {
            width: 100%;
        }
        .create-account {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('NGO Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="form-group">
                            <label for="email">{{ __('Email Address') }}</label>
                            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
                        </div>

                        <!-- Remember Me -->
                        <div class="form-group form-check">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label class="form-check-label" for="remember_me">{{ __('Remember Me') }}</label>
                        </div>

                        <!-- Login Button & Forgot Password -->
                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">{{ __('Log In') }}</button>
                        </div>
                        @if (Route::has('password.request'))
                            <div class="form-group text-center">
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        @endif

                        <!-- Create Account Link -->
                        <div class="create-account">
                            <span>Don't have an account?</span>
                            <a href="{{ route('register') }}" class=" btn-primary btn-sm mt-1">Create an Account</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
