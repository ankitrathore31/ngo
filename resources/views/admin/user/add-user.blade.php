@extends('admin.layout.AdminLayout')
@Section('content')
<style>
    ::placeholder {
        font-size: 14px;
    }

    .upload-container {
        text-align: center;
        margin-top: 15px;
        padding: 10px 20px;
        margin-left: 50px;
    }

    .image-placeholder {
        width: 150px;
        height: 150px;
        /* border: 2px dashed #ccc; */
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        background-color: rgb(223, 226, 228);
    }

    .image-placeholder img {
        max-width: 100%;
        max-height: 100%;
        display: none;
    }

    .upload-btn {
        display: inline-block;
        background-color: #343a40;
        color: #fff;
        padding: 10px 15px;
        margin-right: 80px;
        font-size: 16px;
        width: auto;
        border-radius: 5px;
        cursor: pointer;
        border: none;
    }

    .upload-btn:hover {
        background-color: #495057;
    }

    #uploadInput {
        display: none;
    }
</style>


<div class="wrapper">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="row d-flex justify-content-end">
            <div class="col-auto">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href=" {{ route('AdminDashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add User</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="container">
            <div class="card shadow-sm">
                <div class="text-black text-center border-bottom pb-3">
                    <h4 class="p-3 mt-2"><strong>Fill The Fields For User Registration </strong></h4>
                </div>
                <div class="card-body m-2">
                    <!-- <h5 class="card-title text-center mb-4">Staff Information</h5> -->
                    <form method="post">
                        <div class="border-bottom pb-3 mb-3">
                            <h4 class="p-3"><strong>NGO DEATILS</strong></h4>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        {{-- <div class="col-md-6 mb-3">
                                            <label for="application_date" class="form-label">Application Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="application_date" name="application_date" placeholder="DD-MM-YYYY">
                                        </div> --}}

                                        <div class="col-md-6 mb-3">
                                            <label for="staff_name" class="form-label">Ngo Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="ngo_name" name="name" placeholder="Enter Staff Name">
                                        </div>
                                    </div>

                                    <div class="row">
                                        {{-- <div class="col-md-6 mb-3">
                                            <label for="staff_code" class="form-label">Staff Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="staff_code" name="staff_code" placeholder="Enter Staff Code">
                                        </div> --}}

                                        <div class="col-md-6 mb-3">
                                            <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                            <select class="form-select" id="gender" name="gender">
                                                <option selected disabled></option>
                                                <option value="Female">Female</option>
                                                <option value="Male">Male</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="dob" name="dob" placeholder="DD-MM-YYYY">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="form-group local-forms">
                                                <label>Mobile No.</label>
                                                <input class="form-control" type="number" name="phone" placeholder="Enter Mobile">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="upload-container">
                                        <div class="image-placeholder">
                                            <img id="previewImage" alt="Preview">
                                            <span id="placeholderText">Upload Staff Photo</span>
                                        </div>
                                        <label for="uploadInput" class="upload-btn">Choose File</label>
                                        <input type="file" id="uploadInput" name="image" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="religion" class="form-label">Religion <span class="text-danger">*</span></label>
                                    <select class="form-select" id="religion" name="religion">
                                        <option selected disabled></option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Islam">Islam</option>
                                        <option value="Christian">Christian</option>
                                        <option value="Sikh">Sikh</option>
                                        <option value="Buddhist">Buddhist</option>
                                        <option value="Parsi">Parsi</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="category" class="form-label">Religion Category <span class="text-danger">*</span></label>
                                    <select class="form-select" id="category" name="religion_category">
                                        <option selected disabled></option>
                                        <option value="General">General</option>
                                        <option value="OBC">OBC</option>
                                        <option value="SC">SC</option>
                                        <option value="ST">ST</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group local-forms">
                                        <label>Caste</label>
                                        <input class="form-control" type="text" name="caste" placeholder="Enter Caste">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="father_name" class="form-label">Father/Husband Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="father_name" name="father" placeholder="Enter Name">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="mother_name" class="form-label">Mother's Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="mother_name" name="mother" placeholder="Enter Name">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="occupation" class="form-label">Guardian's Occupation <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="occupation" name="guardian_occupation" placeholder="Enter Occupation">
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom pb-3 mb-3">
                            <h4 class="p-3"><strong>Staff Address Deatails</strong></h4>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="nationality">Nationality</label>
                                        <input type="text" class="form-control" id="nationality" name="nationality" placeholder="Enter Nationality">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group local-forms">
                                        <label>Address</label>
                                        <input class="form-control" name="address" type="text" placeholder="Enter Village/Locality Name">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group local-forms">
                                        <label>Post/Town</label>
                                        <input class="form-control" name="post" type="text" placeholder="Enter Post/Town Name">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group local-forms">
                                        <label>District</label>
                                        <input class="form-control" name="district" type="text" placeholder="Enter District Name">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group local-forms">
                                        <label>Pincode</label>
                                        <input class="form-control" type="number" name="pincode" placeholder="Enter Pincode">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group local-forms">
                                        <label><span class="login-danger">State</span></label>
                                        <select name="state" class="form-control select">
                                            <option selected disabled></option>
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
                                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                            <option value="Chandigarh">Chandigarh</option>
                                            <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and Daman and Diu</option>
                                            <option value="Lakshadweep">Lakshadweep</option>
                                            <option value="Delhi">Delhi</option>
                                            <option value="Puducherry">Puducherry</option>
                                            <option value="Ladakh">Ladakh</option>
                                            <option value="Lakshadweep">Lakshadweep</option>
                                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="border-bottom pb-3 mb-3">
                            <h4 class="p-3"><strong>Staff Position & Other Details</strong></h4>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="appointment_date">Appointment Date</label>
                                        <input type="date" class="form-control" id="appointment_date" name="appointment_date">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="staffPosition" class="label">Select Staff Position:</label>
                                    <select id="staffPosition" name="staff_position" class="form-select">
                                        <option value="" disabled selected></option>
                                        <option value="Principal">Principal</option>
                                        <option value="Vice Principal">Vice Principal</option>
                                        <!-- <option value="Head of Department">Head of Department</option> -->
                                        <option value="Teacher">Teacher</option>
                                        <!-- <option value="Assistant Teacher">Assistant Teacher</option> -->
                                        <option value="Counselor">Counselor</option>
                                        <option value="Librarian">Librarian</option>
                                        <option value="Administrative Staff">Administrative Staff</option>
                                        <!-- <option value="Support Staff">Support Staff</option> -->
                                        <!-- <option value="Coach">Coach</option> -->
                                        <!-- <option value="Janitor">Janitor</option> -->
                                        <option value="Security">Security</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="id_type">Identity Type</label>
                                        <select class="form-control" id="id_type" name="identity_type">
                                            <option selected disabled>Select Identity Type</option>
                                            <option value="Aadhar Card">Aadhar Card</option>
                                            <option value="Voter ID Card">Voter ID Card</option>
                                            <option value="Pan Card">Pan Card</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="identity_no">Identity Card Number</label>
                                        <input type="number" class="form-control" id="identity_no" name="identity_no" placeholder="Enter Identity Card No">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="qualification">Qualification</label>
                                        <select class="form-select" id="qualification" name="qualification">
                                            <option selected disabled></option>
                                            <option value="5th Pass">5th Pass</option>
                                            <option value="High School">High School</option>
                                            <option value="Intermedite">Intermedite</option>
                                            <option value="B.A">B.A</option>
                                            <option value="M.A">M.A</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="degree">Select Degree:</label>
                                    <select id="degree" name="degree" class="form-select">
                                        <option value="" disabled selected></option>
                                        <option value="PhD">PhD</option>
                                        <option value="Master's Degree">Master's Degree</option>
                                        <option value="Bachelor's Degree">Bachelor's Degree</option>
                                        <option value="Associate's Degree">Associate's Degree</option>
                                        <option value="Diploma">Diploma</option>
                                        <option value="Certificate">Certificate</option>
                                        <option value="No Degree">No Degree</option>
                                    </select>
                                </div>
                                <!-- Experience Year -->
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="experience_year">Experience Year</label>
                                        <select class="form-select" id="experience_year" name="experience_year">
                                            <option selected disabled></option>
                                            <option value="1 Year">1 Year</option>
                                            <option value="2 Year">2 Year</option>
                                            <option value="3 Year">3 Year</option>
                                            <option value="4 Year">4 Year</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="col-md-4 mb-3">
                                    <label for="staffPower">Select Staff Power:</label>
                                    <select id="staffPower" name="staff_power" class="form-select">
                                        <option value="" disabled selected></option>
                                        <option value="Full Authority">Full Authority</option>
                                        <option value="Moderate Authority">Moderate Authority</option>
                                        <option value="Limited Authority">Limited Authority</option>
                                        <option value="Support Role">Support Role</option>
                                    </select>
                                </div> -->
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="staff_password" placeholder="Enter Password" value="">
                                        <div class="invalid-feedback">Please enter a valid password.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group text-center">
                                    <button type="submit" name="submit" class="btn btn-success w-50">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const uploadInput = document.getElementById('uploadInput');
    const previewImage = document.getElementById('previewImage');
    const placeholderText = document.getElementById('placeholderText');

    uploadInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                placeholderText.style.display = 'none';
            };

            reader.readAsDataURL(file);
        }
    });
</script>
@endsection