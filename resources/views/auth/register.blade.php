<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Register - NGO Portal</title> --}}

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f8fa;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }



        .form-control::placeholder {
            color: #aaa;
        }

        .form-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .input-group {
            position: relative;
        }

        .input-group input {
            padding-left: 40px;
        }

        .step-section {
            display: none;
        }

        .step-section.active {
            display: block;
        }

        .step-buttons {
            margin-top: 20px;
        }

        .form-box {
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #f9f9f9;
        }

        .ad-banner {
            text-align: center;
            background-color: #f8d7da;
            padding: 15px;
            border-radius: 8px;
            color: #721c24;
            margin-bottom: 20px;
        }

        .package-card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .package-card h5 {
            font-size: 1.5rem;
        }

        .package-card .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: green;
        }

        .package-card .duration {
            font-size: 1rem;
            color: #666;
        }

        .package-card p {
            margin-bottom: 10px;
        }

        .package-card .select-btn {
            font-size: 1rem;
        }

        .step-section {
            display: none;
        }

        .step-section.active {
            display: block;
        }

        .package-card {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">

                        <!-- Step 1: Advertisement -->
                        <div class="step-section active" id="step1">
                            <h3 class="text-center mb-3">Welcome to NGO Platform</h3>
                            <p class="text-center">
                                🌟 Start managing your NGO efficiently.<br>
                                Create an account to unlock features and grow your impact.
                            </p>
                            <div class="d-flex justify-content-between mt-4">
                                <button class="btn btn-secondary" onclick="goToStep(3)">Skip</button>
                                <button class="btn btn-primary" onclick="goToStep(2)">Next</button>
                            </div>
                        </div>

                        <!-- Step 2: Package Info -->
                        <div class="step-section" id="step2">
                            <h4 class="text-center mb-4">Package Info</h4>

                            <div class="package-card mb-3">
                                <h5>🎁 Free Trial</h5>
                                <p>Duration: <strong>1 Day</strong></p>
                                <p>Price: <strong>$0.00</strong></p>
                                <p><em>Try our platform risk-free for 24 hours.</em></p>
                            </div>

                            <div class="package-card mb-3">
                                <h5>📦 Basic Package</h5>
                                <p>Duration: <strong>12 Month</strong></p>
                                <p>Price: <strong>$10.00</strong></p>
                                <p>Includes limited access to essential NGO tools.</p>
                            </div>

                            <div class="package-card mb-3">
                                <h5>💼 Advanced Package</h5>
                                <p>Duration: <strong>12 Months</strong></p>
                                <p>Price: <strong>$50.00</strong></p>
                                <p>Full access to reports, CRM, support, and advanced features.</p>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button class="btn btn-secondary" onclick="goToStep(1)">Back</button>
                                <button class="btn btn-primary" onclick="goToStep(3)">Next</button>
                            </div>
                        </div>

                        <!-- Step 3: Registration Form -->
                        <div class="step-section" id="step3">
                            <h4 class="text-center mb-4">Create An Account</h4>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="form-group mb-3">
                                    <label><strong>NGO Name</strong></label>
                                    <input type="text" name="name" class="form-control" placeholder="NGO Name"
                                        value="{{ old('name') }}" required autofocus>
                                </div>

                                <div class="form-group mb-3">
                                    <label><strong>Email</strong></label>
                                    <input type="email" name="email" class="form-control"
                                        placeholder="Email Address" value="{{ old('email') }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label><strong>Mobile No</strong></label>
                                    <input type="number" name="phone_number" class="form-control"
                                        placeholder="Enter Contact No." value="{{ old('phone_number') }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label><strong>Password</strong></label>
                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                        required autocomplete="new-password">
                                </div>

                                <div class="form-group mb-3">
                                    <label><strong>Confirm Password</strong></label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Confirm Password" required>
                                </div>

                                <div class="form-group text-end mb-3">
                                    <a href="{{ route('login') }}" class="text-muted">Already registered?</a>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-success w-100" type="submit">
                                        <i class="fas fa-user-plus me-2"></i> Register
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div> <!-- card-body -->
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function goToStep(stepNum) {
            const steps = document.querySelectorAll('.step-section');
            steps.forEach(step => step.classList.remove('active'));
            const target = document.getElementById('step' + stepNum);
            if (target) {
                target.classList.add('active');
            }
        }
    </script>

    <!-- Bootstrap JS and FontAwesome -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
