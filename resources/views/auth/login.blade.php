<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NGO Login</title>

    <!-- Bootstrap 4 -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            overflow: hidden;
        }

        .split {
            height: 100vh;
            display: flex;
        }

        .left-panel {
            flex: 1;
            background: linear-gradient(to bottom right, #6a0dad, #9d50bb);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            flex-direction: column;
        }

        .left-panel h1 {
            font-size: 2.5rem;
            animation: fadeInLeft 1s ease-in-out;
        }

        .left-panel i {
            font-size: 4rem;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }

        .right-panel {
            flex: 1;
            background: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border-radius: 12px;
            animation: fadeInUp 1s ease;
        }

        .login-card .form-control {
            border-radius: 10px;
        }

        .btn-primary {
            width: 100%;
            border-radius: 10px;
        }

        .create-account {
            text-align: center;
            margin-top: 20px;
        }

        .icon-animate {
            font-size: 4rem;
            margin-bottom: 20px;
            transition: opacity 0.5s ease;
        }

        .icon-fade-out {
            opacity: 0;
        }

        .icon-fade-in {
            opacity: 1;
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease forwards;
        }

        .fade-in-left {
            animation: fadeInLeft 0.8s ease forwards;
        }

        .bounce {
            animation: bounce 1s infinite;
        }

        .icon-animate i {
            animation: bounce 1s infinite;
        }


        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .eye-icon {
            width: 24px;
            height: 24px;
            transition: all 0.3s ease;
        }

        .eye-icon path {
            transition: opacity 0.3s ease;
        }

        .eye-icon path#eyeClosed {
            opacity: 0;
        }

        .eye-icon.closed path#eyeOpen {
            opacity: 0;
        }

        .eye-icon.closed path#eyeClosed {
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="split">
        <!-- Left Panel -->
        <div class="left-panel">
            <div id="icon-rotator" class="icon-animate">
                <i class="bi bi-person-fill"></i>
            </div>
            <h1 class="fade-in-up">Gyan Bharti Sanstha</h1>
            <p class="fade-in-left">Welcome to the Sanstha Portal</p>
        </div>
        <!-- Right Panel -->
        <div class="right-panel">
            <div class="login-card">
                <h4 class="text-center mb-4">Sign In</h4>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input id="email" type="email" class="form-control" name="email"
                            value="{{ old('email') }}" required autofocus>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input id="password" type="password" name="password" class="form-control"
                                value="{{ old('password') }}" required>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary toggle-password-btn"
                                    onclick="togglePasswordVisibility()">
                                    <svg id="eyeIcon" class="eye-icon" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 64 64">
                                        <path id="eyeOpen"
                                            d="M32 16C18 16 6 32 6 32s12 16 26 16 26-16 26-16S46 16 32 16zm0 26a10 10 0 1 1 0-20 10 10 0 0 1 0 20z"
                                            fill="currentColor" />
                                        <path id="eyeClosed"
                                            d="M4 4l56 56M32 16c-9 0-17.4 6-24 16 2.4 3.6 5.1 6.8 8.2 9.4M60 32s-12-16-28-16a25.6 25.6 0 0 0-6.8.9M12 12l40 40"
                                            stroke="currentColor" stroke-width="4" fill="none" opacity="0" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- Remember Me -->
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="btn btn-primary">{{ __('Log In') }}</button>

                    <!-- Forgot Password -->
                    {{-- <div class="">
                        <a href="#">Forgot your password?</a>
                    </div> --}}
                    @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    @endif

                    <!-- Create Account -->
                    <div class="create-account">
                        <p>Don't have an account? <a href="#" class="text-primary">Sign Up</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            const isPasswordVisible = passwordInput.type === 'text';
            passwordInput.type = isPasswordVisible ? 'password' : 'text';

            eyeIcon.classList.toggle('closed', !isPasswordVisible);
        }
    </script>

    <script>
        const icons = [
            'bi-person-fill', // User
            'bi-cash-coin', // Donate
            'bi-shield-lock-fill', // Lock
            'bi-building', // NGO style
        ];

        let currentIndex = 0;
        const iconElement = document.getElementById('icon-rotator');

        function rotateIcon() {
            iconElement.classList.remove('icon-fade-in');
            iconElement.classList.add('icon-fade-out');

            setTimeout(() => {
                currentIndex = (currentIndex + 1) % icons.length;
                iconElement.innerHTML = `<i class="bi ${icons[currentIndex]}"></i>`;
                iconElement.classList.remove('icon-fade-out');
                iconElement.classList.add('icon-fade-in');
            }, 500); // Wait for fade out
        }

        // Start rotating every 3 seconds
        setInterval(rotateIcon, 3000);
    </script>

</body>

</html>
