@extends('ngo.layout.master')
@section('content')
    <style>
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
        <div class="main-content">
            <!-- Breadcrumb -->
            <div class="row d-flex justify-content-end">
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Admission</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="container-fluide mt-3">
                <div class="card bg-white p-2 shadow rounded">
                    <div class="text-black text-center border-bottom pb-3">
                        <h4 class=" p-3"><strong>Fill The Fields For Student Admission </strong></h4>
                    </div>
                    <div class="card-body m-1">
                        <form method="post" enctype="multipart/form-data">
                            <!-- Student Information Section -->
                            <div class="border-bottom pb-3 mb-4">
                                <h5 class="text-black"><strong>Student Information</strong></h5>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6 form-group mb-3">
                                                <label for="name" class="form-label">Full Name:</label>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    placeholder="Enter full name" required>
                                            </div>
                                            <div class="col-md-6 form-group mb-3">
                                                <label for="dob" class="form-label">Date of Birth:</label>
                                                <input type="date" name="dob" id="dob" class="form-control"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 form-group mb-3">
                                                <label for="gender" class="form-label">Gender:</label>
                                                <select name="gender" id="gender" class="form-control" required>
                                                    <option value="" selected>Select Gender</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 form-group mb-3">
                                                <label for="phone" class="form-label">Phone:</label>
                                                <input type="text" name="phone" id="phone" class="form-control"
                                                    placeholder="Enter phone number" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 form-group mb-3">
                                                <label for="email" class="form-label">Email:</label>
                                                <input type="email" name="email" id="email" class="form-control"
                                                    placeholder="Enter email address" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="religion" class="form-label">Religion <span
                                                        class="text-danger">*</span></label>
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
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="upload-container">
                                            <div class="image-placeholder">
                                                <img id="previewImage" alt="Preview">
                                                <span id="placeholderText">Upload Student Photo</span>
                                            </div>
                                            <label for="uploadInput" class="upload-btn">Choose File</label>
                                            <input type="file" id="uploadInput" name="image" accept="image/*">
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="category" class="form-label">Religion Category <span
                                                class="text-danger">*</span></label>
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
                                            <label class="form-label">Caste</label>
                                            <input class="form-control" type="text" name="caste"
                                                placeholder="Enter Caste">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Guardian Information Section -->
                            <div class="border-bottom pb-3 mb-4">
                                <h5 class="text-black"><strong>Guardian Information</strong></h5>
                                <div class="row">
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="father" class="form-label">Father's Name:</label>
                                        <input type="text" name="father" id="father" class="form-control"
                                            placeholder="Enter father's name" required>
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="mother" class="form-label">Mother's Name:</label>
                                        <input type="text" name="mother" id="mother" class="form-control"
                                            placeholder="Enter mother's name" required>
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="guardian_phone" class="form-label">Guardian's Phone:</label>
                                        <input type="text" name="guardian_phone" id="guardian_phone"
                                            class="form-control" placeholder="Enter guardian's phone" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Details Section -->
                            <div class="border-bottom pb-3 mb-3">
                                <h5 class="text-black"><strong>Address Details</strong></h5>
                                <div class="row">
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="country" class="form-label">Nationality:</label>
                                        <select name="country" class="form-control" id="country">
                                            <option value=""></option>
                                            <option value="India">India</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4 form-group mb-3">
                                        <label for="hometown" class="form-label">Village / Home Town:</label>
                                        <input type="text" name="hometown" id="hometown" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="district" class="form-label">District:</label>
                                        <input type="text" name="district" id="district" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="pincode" class="form-label">Pincode:</label>
                                        <input type="number" name="pincode" id="pincode" class="form-control"
                                            placeholder="">
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="text" class="form-label">State:</label>
                                        <select class="form-control" id="state" name="state" required>
                                            <option value=""></option>
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
                                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands
                                            </option>
                                            <option value="Chandigarh">Chandigarh</option>
                                            <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli
                                                and Daman and Diu</option>
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

                            <!-- Academic Details Section -->
                            <div class="border-bottom pb-3 mb-4">
                                <h5 class="text-black"><strong>Academic Details</strong></h5>
                                <div class="row">
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="class_select" class="form-label">Select Class:</label>
                                        <select name="class" id="class_select" class="form-control" required>
                                            <option value="" selected></option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="enrollment_date" class="form-label">Enrollment Date:</label>
                                        <input type="date" name="enrollment_date" id="enrollment_date"
                                            class="form-control" required>
                                    </div>
                                    <!-- <div class="row"> -->
                                    <label for="subject" class="form-label">Choose Subject:</label>
                                    <!-- </div> -->
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="form-group text-center">
                                        <button type="submit" name="submit"
                                            class="btn btn-success w-50">Submit</button>
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
