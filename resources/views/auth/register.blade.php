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
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">Create An Account</div>
                    <div class="card-body">

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

                            <!-- Name -->
                            <div class="form-group mb-3">
                                <label for="" class="form-label"><strong>Ngo Name:</strong></label>
                                <input type="text" name="name" class="form-control" placeholder="Ngo Name"
                                    value="{{ old('name') }}" required autofocus>
                            </div>

                            <!-- Email Address -->
                            <div class="form-group mb-3">
                                <label for="" class="form-label"><strong>Email:</strong></label>
                                <input type="email" name="email" class="form-control" placeholder="Email Address"
                                    value="{{ old('email') }}" required>
                            </div>

                            <!-- Contact Number -->
                            <div class="form-group mb-3">
                                <label for="" class="form-label"><strong>Mobile No:</strong></label>
                                <input type="number" name="phone_number" class="form-control" placeholder="Enter Contact No."
                                    value="{{ old('phone_number') }}" required>
                            </div>

                            <!-- Password -->
                            <div class="form-group mb-3">
                                <label for="" class="form-label"><strong>Password:</strong></label>
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    required autocomplete="new-password">
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group mb-3">
                                <label for="" class="form-label"><strong>Confirm Password:</strong></label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Confirm Password" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group text-right mb-3">
                                <a href="{{ route('login') }}" class="text-muted small">Already registered?</a>
                            </div>
                            <div class="form-group mb-3">
                                <button class="btn btn-outline-primary btn-block" type="submit">
                                    <i class="fas fa-user-plus mr-2"></i>Register
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and FontAwesome -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>

</html>
