<?php @session_start();
if (function_exists('date_default_timezone_set')) {
    date_default_timezone_set("Asia/Kolkata");
}

$date = date('Y-m-d');
$time = date('h:i a');

// Check if the form is submitted
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

 $email = strtolower($email);
  $password = strtolower($password);


// exit();

    // Security: Prepared Statement to prevent SQL Injection
    $query = "SELECT * FROM user WHERE email=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_num_rows($result);

    if ($rows > 0) {
        $user_data = mysqli_fetch_assoc($result);

        if ($password==$user_data['password']) {
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user_data['role']; // Store user role in session

            // Redirect based on role
            if ($user_data['role'] === 'admin') {
               echo "<script>window.location.href=('https://gyanbhartingo.org/Admin/dashboard.php');</script>"; // Redirect admin
            }elseif($user_data['role'] === 'user') {
                echo "<script>window.location.href=('https://gyanbhartingo.org/user/dashboard.php');</script>"; // Redirect regular user
            }else{
                header("Location: user_dashboard.php"); 
            }
            exit();
        } else {
            echo "<script>alert('Invalid Password');window.location.assign('');</script>";
        }
    } else {
        echo "<script>alert('Invalid UserId/Password');window.location.assign('');</script>";
    }
}
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="container d-flex justify-content-center mt-5">
    <div class="card d-flex flex-row">
        <div class="col-md-6 d-flex justify-content-center align-items-center m-2">
            <img src="assets/images/cart.jpg" alt="image" class="img-fluid">
        </div>
        <div class="col-md-6">
            <div class="card-body m-2">
                <h5 class="card-tile text-center">Login Here</h5>
                <form method="POST" >
                    <div class="mb-3">
                        <label for="email" class="form-label">Email/User Id</label>
                        <input type="email" class="form-control" id="email" name="email" autocapitalize="none" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="submit" class="btn btn-success">Login</button>
                    </div>
                    <div class="mt-2 d-flex justify-content-between align-items-center">
                        <a href="signup.php" class="text-decoration-none text-primary">Create an Account</a>
                        <a href="/forgot_password" class="text-decoration-none text-danger">Forget Password</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Add some custom styles for spacing -->
<style>
    .card {
        width: 100%;
        max-width: 800px;
    }

    .card-body {
        background-color: #f7f7f7;
        height: auto;
    }

    .btn-success {
        width: 100%;
    }

    .img-fluid {
        width: 100%;
        height: auto;
        max-height: 400px;
    }
    body{
        text-transform: none !important;
    }
</style>
