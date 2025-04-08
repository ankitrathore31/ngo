<?php include("common/connection.php");
include "common/db_function.php";

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $marital_status = $_POST['marital_status'];
    $city = $_POST['city'];
    $post = $_POST['post'];
    $district = $_POST['district'];
    $state = $_POST['state'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];


    if (email($email, 'email')) {
        if (email($phone, 'phone')) {
    
            if ($password == $confirm_password) {
                $password = password_hash($password, PASSWORD_BCRYPT);
                $sql = "INSERT INTO user(username,email,phone,gender,dob,marital_status,city,post,district,state,password) 
                        VALUES('$username','$email','$phone','$gender','$dob','$marital_status','$city','$post','$district','$state','$password')";
    
                $query = mysqli_query($db, $sql);
                if ($query) {

                    $to = $email;
                    $subject = "Welcome to ".$hm_title."Trust";
                    $headers = "From: " . strip_tags("$hm_email") . "\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $message = '<html><body>';
                    $message .= '<table>';
                    $message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . strip_tags($name) . "</td></tr>";
                    $message .= "<tr style='background: #eee;'><td><strong>UserId:</strong> </td><td>" . strip_tags($hmpre.$userid) . "</td></tr>";
                    $message .= "<tr style='background: #eee;'><td><strong>Password:</strong> </td><td>" . strip_tags($password) . "</td></tr>";
                    $message .= "<tr style='background: #eee;'><td><strong>Transaction Password:</strong> </td><td>" . strip_tags($transaction_pass) . "</td></tr>";
                    $message .= "</table>";
                    $message .= "</body></html>";
                    mail($to, $subject, $message, $headers);

                    echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Registered successfully!',
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            window.location.href = 'login.php'; // Redirect to login or another page
                        });
                    </script>";
                } else {
                    echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Database error: " . mysqli_error($db) . "',
                            confirmButtonColor: '#d33'
                        }).then(() => {
                            window.history.back();
                        });
                    </script>";
                }
    
            } else {
                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Confirm Password doesn\'t match!',
                        confirmButtonColor: '#d33'
                    }).then(() => {
                        window.history.back();
                    });
                </script>";
            }
    
        } else {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Phone Number Already Exists!',
                    confirmButtonColor: '#d33'
                }).then(() => {
                    window.history.back();
                });
            </script>";
        }
    
    } else {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Email Already Exists!',
                confirmButtonColor: '#d33'
            }).then(() => {
                window.history.back();
            });
        </script>";
    }    
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="container-fluid">
    <div class="card m-5">
        <div class="card-header text-center">
            <p>Fill The Fields For Create An Account</p>
        </div>
        <div class="card-body">
            <form method="post" class="local-form">
                <div class="row">
                    <div class=" col-md-4 mb-3">
                        <label for="name" class="form-label">Username:</label>
                        <input type="text" name="username" class="form-control" id="name" required>
                    </div>
                    <div class=" col-md-4 mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>
                    <div class=" col-md-4 mb-3">
                        <label for="phone" class="form-label">Phone:</label>
                        <input type="text" name="phone" class="form-control" id="phone" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Gender:</label>
                        <div class="d-flex">
                            <div class="form-check me-3">
                                <input type="radio" name="gender" value="Male" class="form-check-input" id="male" required>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="gender" value="Female" class="form-check-input" id="female" required>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="dob" class="form-label">Date Of Birth:</label>
                        <input type="date" name="dob" class="form-control" id="dob" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Marital Status:</label>
                        <div class="d-flex">
                            <div class="form-check me-3">
                                <input type="radio" name="marital_status" value="Married" class="form-check-input" id="married" required>
                                <label class="form-check-label" for="married">Married</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="marital_status" value="Unmarried" class="form-check-input" id="unmarried" required>
                                <label class="form-check-label" for="unmarried">Unmarried</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="city" class="form-label">Village/City:</label>
                        <input type="text" name="city" class="form-control" id="city" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="post" class="form-label">Post:</label>
                        <input type="text" name="post" class="form-control" id="post" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="district" class="form-label">District:</label>
                        <input type="text" name="district" class="form-control" id="district" required>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="state">Select State:</label>
                        <select id="state" name="state" class="form-control" required>
                            <option value="" selected>-- Select State --</option>
                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                            <option value="Assam">Assam</option>
                            <option value="Bihar">Bihar</option>
                            <option value="Chhattisgarh">Chhattisgarh</option>
                            <option value="Goa">Goa</option>
                            <option value="Gujarat">Gujarat</option>
                            <option value="Haryana">Haryana</option>
                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                            <option value="Jharkhand">Jharkhand</option>
                            <option value="Karnataka">Karnataka</option>
                            <option value="Kerala">Kerala</option>
                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                            <option value="Maharashtra">Maharashtra</option>
                            <option value="Manipur">Manipur</option>
                            <option value="Meghalaya">Meghalaya</option>
                            <option value="Mizoram">Mizoram</option>
                            <option value="Nagaland">Nagaland</option>
                            <option value="Odisha">Odisha</option>
                            <option value="Punjab">Punjab</option>
                            <option value="Rajasthan">Rajasthan</option>
                            <option value="Sikkim">Sikkim</option>
                            <option value="Tamil Nadu">Tamil Nadu</option>
                            <option value="Telangana">Telangana</option>
                            <option value="Tripura">Tripura</option>
                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                            <option value="Uttarakhand">Uttarakhand</option>
                            <option value="West Bengal">West Bengal</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password:</label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4 mb-3 mt-4">
                        <input type="submit" class="btn btn-success w-50" name="submit" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>