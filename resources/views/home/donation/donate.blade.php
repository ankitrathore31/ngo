@extends('home.layout.MasterLayout')
@Section('content')
    <style>
        .community-donation {
            background-color: white;
        }

        .donation-amount:hover {
            background-color: #007bff;
            color: white;
        }
    </style>
    <!-- ==== Community Section Start ==== -->
    <section class="community mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-xl-7">
                    <div class="section__header">
                        <h2 class="text-dark">Join The Community To Give Donation</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card m-2 shadow-lg p-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h4>Fill the fields for donation <span class="fw-bold" style="font-size: 18px;">( After
                                        Donation Get A Certificate )</span></h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('donate') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        {{-- <input type="hidden" value="" name="amount"> --}}
                                        <label for="name" class="form-label">Donor Name:</label>
                                        <input type="text" class="form-control" name="donor_name" id="name">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Donor Email:</label>
                                        <input type="email" class="form-control" name="donor_email" id="email">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="number" class="form-label">Donor Mobile Number:</label>
                                        <input type="number" class="form-control" name="donor_number" id=""
                                            maxlength="10">
                                    </div>
                                </div>
                                <!-- Toggle Option -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="provideAddress" class="form-label">Do you want to provide address
                                            (Optional)</label>
                                        <select class="form-control" id="provideAddress" onchange="toggleAddressFields()">
                                            <option value="">-- Select --</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Address Fields Section -->
                                <div id="addressSection" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="village" class="form-label">Donor's Village/Locality:</label>
                                            <textarea name="donor_village" id="village" class="form-control"></textarea>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="post" class="form-label">Donor's Post/Block:</label>
                                            <input type="text" name="block" id="post" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="pincode" class="form-label">Pincode:</label>
                                            <input type="number" name="donor_pincode" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="countrySelect">Select Country:</label>
                                            <select class="form-control" id="countrySelect" name="donor_country">
                                                <option value="" selected>-- Select Country --</option>
                                                <option value="India">India</option>
                                                <option value="Afghanistan">Afghanistan</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Algeria">Algeria</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="Brunei">Brunei</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina Faso">Burkina Faso</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cabo Verde">Cabo Verde</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Central African Republic">Central African Republic</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo (Congo-Brazzaville)">Congo</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Eswatini">Eswatini</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Fiji">Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Haiti">Haiti</option>
                                                <option value="Honduras">Honduras</option>
                                                <option value="Hungary">Hungary</option>
                                                <option value="Iceland">Iceland</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option value="Iran">Iran</option>
                                                <option value="Iraq">Iraq</option>
                                                <option value="Ireland">Ireland</option>
                                                <option value="Israel">Israel</option>
                                                <option value="Italy">Italy</option>
                                                <option value="Jamaica">Jamaica</option>
                                                <option value="Japan">Japan</option>
                                                <option value="Jordan">Jordan</option>
                                                <option value="Kazakhstan">Kazakhstan</option>
                                                <option value="Kenya">Kenya</option>
                                                <option value="Kuwait">Kuwait</option>
                                                <option value="Lebanon">Lebanon</option>
                                                <option value="Malaysia">Malaysia</option>
                                                <option value="Maldives">Maldives</option>
                                                <option value="Mexico">Mexico</option>
                                                <option value="Mongolia">Mongolia</option>
                                                <option value="Morocco">Morocco</option>
                                                <option value="Myanmar">Myanmar</option>
                                                <option value="Namibia">Namibia</option>
                                                <option value="Nepal">Nepal</option>
                                                <option value="Netherlands">Netherlands</option>
                                                <option value="New Zealand">New Zealand</option>
                                                <option value="Nigeria">Nigeria</option>
                                                <option value="Norway">Norway</option>
                                                <option value="Oman">Oman</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="Palestine">Palestine</option>
                                                <option value="Panama">Panama</option>
                                                <option value="Peru">Peru</option>
                                                <option value="Philippines">Philippines</option>
                                                <option value="Poland">Poland</option>
                                                <option value="Portugal">Portugal</option>
                                                <option value="Qatar">Qatar</option>
                                                <option value="Romania">Romania</option>
                                                <option value="Russia">Russia</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <option value="Singapore">Singapore</option>
                                                <option value="South Africa">South Africa</option>
                                                <option value="South Korea">South Korea</option>
                                                <option value="Spain">Spain</option>
                                                <option value="Sri Lanka">Sri Lanka</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Turkey">Turkey</option>
                                                <option value="United Arab Emirates">United Arab Emirates</option>
                                                <option value="United Kingdom">United Kingdom</option>
                                                <option value="United States">United States</option>
                                                <option value="Vietnam">Vietnam</option>
                                                <option value="Zambia">Zambia</option>
                                                <option value="Zimbabwe">Zimbabwe</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="stateSelect"><strong>Select State:</strong></label>
                                            <select class="form-control" id="stateSelect" name="donor_state"
                                                onchange="updateDistricts(this.value)">
                                                <option value="">-- Select a State or UT --</option>
                                                <option value="Andhra Pradesh">Andhra Pradesh</option>
                                                <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                                <option value="Assam">Assam</option>
                                                <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands
                                                </option>
                                                <option value="Bihar">Bihar</option>
                                                <option value="Chhattisgarh">Chhattisgarh</option>
                                                <option value="Chandigarh">Chandigarh</option>
                                                <option value="Delhi">Delhi</option>
                                                <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar
                                                    Haveli and Daman and Diu</option>
                                                <option value="Goa">Goa</option>
                                                <option value="Gujarat">Gujarat</option>
                                                <option value="Haryana">Haryana</option>
                                                <option value="Himachal Pradesh">Himachal Pradesh</option>
                                                <option value="Jharkhand">Jharkhand</option>
                                                <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                <option value="Karnataka">Karnataka</option>
                                                <option value="Kerala">Kerala</option>
                                                <option value="Ladakh">Ladakh</option>
                                                <option value="Lakshadweep">Lakshadweep</option>
                                                <option value="Madhya Pradesh">Madhya Pradesh</option>
                                                <option value="Maharashtra">Maharashtra</option>
                                                <option value="Manipur">Manipur</option>
                                                <option value="Meghalaya">Meghalaya</option>
                                                <option value="Mizoram">Mizoram</option>
                                                <option value="Nagaland">Nagaland</option>
                                                <option value="Odisha">Odisha</option>
                                                <option value="Punjab">Punjab</option>
                                                <option value="Puducherry ">Puducherry </option>
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="districtSelect"><strong>Select District:</strong></label>
                                            <select class="form-control" name="donor_district" id="districtSelect"
                                                disabled>
                                                <option value="">-- Select a District --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="confirmIdType" class="form-label">Do you want to provide ID Type?
                                            (Optional)</label>
                                        <select class="form-control" id="confirmIdType" onchange="toggleIdTypeInputs()">
                                            <option value="">Select</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" id="idTypeSelection" style="display: none;">
                                    <div class="col-md-6 mb-3">
                                        <label for="idType" class="form-label">Select ID Type</label>
                                        <select class="form-control" id="idType" onchange="showIdInput()">
                                            <option value="">Select</option>
                                            <option value="aadhar">Aadhar Card</option>
                                            <option value="pan">PAN Card</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" id="aadharInput" style="display: none;">
                                    <div class="col-md-6 mb-3">
                                        <label for="aadhar" class="form-label">Aadhar Card Number</label>
                                        <input type="text" name="donor_aadhar" class="form-control" id="aadhar"
                                            placeholder="Enter Aadhar Number" maxlength="12" oninput="validateAadhar()">
                                        <small id="aadharError" style="color: red; display: none;">Aadhar number must be
                                            12 digits.</small>
                                    </div>
                                </div>
                                <div class="row" id="panInput" style="display: none;">
                                    <div class="col-md-6 mb-3">
                                        <label for="pan" class="form-label">PAN Card Number</label>
                                        <input type="text" class="form-control" name="donor_pancard" id="pan"
                                            placeholder="Enter PAN Number" maxlength="10" oninput="validatePAN()">
                                        <small id="panError" style="color: red; display: none;">PAN number must be in
                                            format: ABCDE1234F.</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="selectCategory" class="form-label">Do you want to select a category
                                            (Optional)
                                            <!-- <span style="font-size: 12px;">(Not Mandatory, you can skip and donate )</span> -->
                                        </label>
                                        <select class="form-select form-control" id="selectCategory"
                                            onchange="toggleCategorySelection()">
                                            <option value="">-- Select --</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6" id="categoryDiv" style="display: none;">
                                    <label for="category" class="form-label">Donation Category:</label>
                                    <select name="donation_category" id="category" class="form-control">
                                        <option value="" selected>Select Category</option>
                                        <option value="Poor Service Donation">Poor Service Donation</option>
                                        <option value="Free Education Donation">Free Education Donation</option>
                                        <option value="Health Care Donation">Health Care Donation</option>
                                        <option value="Food Donation">Food Donation</option>
                                        <option value="Environment">Environment</option>
                                        <option value="Disaster Donation">Disaster Donation</option>
                                        <option value="Skill Development">Skill Development</option>
                                        <option value="Social Service Donation">Social Service Donation</option>
                                        <option value="Training Centre">Training Centre</option>
                                        <option value="School Fees Donation">School Fees Donation</option>
                                        <option value="Book Donation">Book Donation</option>
                                        <option value="Stationary Kit Donation">Stationary Kit Donation</option>
                                        <option value="Tuition Fees Donation">Tuition Fees Donation</option>
                                        <option value="Holi Kit Donation">Holi Kit Donation</option>
                                        <option value="Diwali Kit Donation">Diwali Kit Donation</option>
                                        <option value="Eid Kit Donation">Eid Kit Donation</option>
                                        <option value="Ration Kit Donation">Ration Kit Donation</option>
                                        <option value="Nutrition Kit Donation">Nutrition Kit Donation</option>
                                        <option value="Cow Service Donation">Cow Service Donation</option>
                                        <option value="Free Coaching Donation">Free Coaching Donation</option>
                                        <option value="Plantation Donation">Plantation Donation</option>
                                        <option value="Women Empowerment">Women Empowerment</option>
                                        <option value="Deaddiction">Deaddiction</option>
                                        <option value="Membership Training Fees Donation">Membership Fees Donation</option>
                                        <option value="Training Fees Donation">Training Fees Donation</option>
                                        <option value="Cultural Donation">Cultural Donation</option>
                                        <option value="Economic Help">Economic Help</option>
                                        <option value="Other Donation">Other Donation</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="remark">Remark:</label>
                                        <textarea name="donation_remark" id="remark" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class=" row">
                                    <div class="col-md-6 mb-3">
                                        <label for="amount" class="form-label">Donation Amount:</label>
                                        <input type="number" class="form-control" name="donation_amount" id="amount"
                                            value="" required>
                                    </div>
                                </div>
                                <div class="col-md-6 row">
                                    <div class="text-center">
                                        <!-- <input type="submit" class="btn btn-success mt-1" value="Pay Now" name="submit"> -->
                                        <button type="submit" name="submit" class="btn btn-success mt-2">Pay
                                            Now</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==== Community Section End ==== -->
    <div class="container mt-5">
        <div class="card shadow border-primary">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Sanstha Bank Details</h4>
            </div>
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-md-4 fw-bold">Account Holder Name:</div>
                    <div class="col-md-6" id="holder">GYAN BHARTI SANSTHA</div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary btn-primary text-white btn-sm w-100"
                            onclick="copyText('holder')">Copy</button>
                    </div>
                </div>

                <div class="row align-items-center mb-3">
                    <div class="col-md-4 fw-bold">Account Number:</div>
                    <div class="col-md-6" id="account">08310200000368</div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary btn-primary text-white btn-sm w-100"
                            onclick="copyText('account')">Copy</button>
                    </div>
                </div>

                <div class="row align-items-center mb-3">
                    <div class="col-md-4 fw-bold">Bank Name:</div>
                    <div class="col-md-6" id="account">Bank Of Baroda</div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary btn-primary text-white btn-sm w-100"
                            onclick="copyText('account')">Copy</button>
                    </div>
                </div>

                <div class="row align-items-center mb-3">
                    <div class="col-md-4 fw-bold">IFSC Code:</div>
                    <div class="col-md-6" id="ifsc">BARB0AMERIA</div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary btn-primary text-white btn-sm w-100"
                            onclick="copyText('ifsc')">Copy</button>
                    </div>
                </div>

                <div class="row align-items-center mb-3">
                    <div class="col-md-4 fw-bold">Branch:</div>
                    <div class="col-md-6" id="branch">Ameria</div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary btn-primary text-white btn-sm w-100"
                            onclick="copyText('branch')">Copy</button>
                    </div>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-4 fw-bold">Account Type:</div>
                    <div class="col-md-6" id="type">Current</div>
                    <div class="col-md-2">
                        <button class="btn btn-outline-secondary btn-primary text-white btn-sm w-100"
                            onclick="copyText('type')">Copy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12 mb-3">
                <!-- UPI QR Card -->
                <div class="card shadow border-success">
                    <div class="card-header bg-success text-white text-center">
                        <h4 class="mb-0">UPI - Payment</h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="row gy-3 justify-content-center">

                            <!-- UPI ID -->
                            <div
                                class="col-12 d-flex flex-column flex-md-row align-items-center justify-content-between mb-3">
                                <label class="fw-bold text-center text-md-end col-md-5 mb-2 mb-md-0">PhonePe UPI
                                    ID:</label>
                                <div class="col-md-5 text-center text-md-start" id="upi">gyanbhartingo@ybl</div>
                                <div class="col-md-2 mt-2 mt-md-0">
                                    <button class="btn btn-outline-success btn-sm w-100"
                                        onclick="copyText('upi')">Copy</button>
                                </div>
                            </div>

                            <!-- PhonePe No -->
                            <div
                                class="col-12 d-flex flex-column flex-md-row align-items-center justify-content-between mb-3">
                                <label class="fw-bold text-center text-md-end col-md-5 mb-2 mb-md-0">PhonePe UPI
                                    Number:</label>
                                <div class="col-md-5 text-center text-md-start" id="phonepe">9719735760</div>
                                <div class="col-md-2 mt-2 mt-md-0">
                                    <button class="btn btn-outline-success btn-sm w-100"
                                        onclick="copyText('phonepe')">Copy</button>
                                </div>
                            </div>

                            <!-- Pay Now Button -->
                            <div class="col-12 text-end mt-3">
                                <a href="upi://pay?pa=gyanbhartingo@ybl&pn=GYAN%20BHARTI%20SANSTHA"
                                    class="btn btn-success">
                                    <i class="fa fa-money-bill-wave me-2"></i>Pay Now via UPI
                                </a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-3">
                <!-- UPI QR Card -->
                <div class="card shadow border-warning">
                    <div class="card-header bg-warning text-white text-center">
                        <h4 class="mb-0">Qr Code - Payment</h4>
                    </div>
                    <div class="card-body text-center">
                        <p><strong>Click The Image To Pay</strong></p>
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <!-- QR Image (clickable) -->
                                <a href="upi://pay?pa=gyanbhartingo@ybl&pn=GYAN%20BHARTI%20SANSTHA" target="_blank">
                                    <img src="images/qr.jpeg" class="img-fluid mb-3" alt="QR Code"
                                        style="max-width: 200px;">
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <!-- Download Button -->
                                <a href="images/qr.jpeg" download="GyanBharti_UPI_QR"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-download me-1"></i>Download QR
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="container mt-5"> -->
            <div class="col-md-12 mb-3">
                <div class="card shadow border-info">
                    <div class="card-header bg-info text-white text-center">
                        <h4 class="mb-0">Sanstha Check Payment</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 text-center mb-3 mb-md-0">
                                <p class="mb-0">Pay - GYAN BHARTI SANSTHA KAINCHU TANDA</p>
                            </div>
                            <div class="col-md-6 text-center">
                                <p class="mb-0">Pay - ज्ञान भारती संस्था कैंचू टांडा</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>

    <!-- ==== Donate Section Start ==== -->
    <section class="cause mt-4 py-5 bg-light">
        <div class="container">
            <div class="row align-items-center mb-4">
                <div class="col-md-8">
                    <h2 class="text-dark">Help & donate them when they're in need</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="images/education2.jpg" class="card-img-top" alt="Education" width="200">
                        <div class="card-body">
                            <h5 class="card-title">Help For Education</h5>
                            <p class="card-text">Providing Free Education by our NGO</p>
                            <a href="{{ route('help-education') }}" class="btn btn-secondary">Donate Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="images/food.jpg" class="card-img-top" alt="Food" width="200">
                        <div class="card-body">
                            <h5 class="card-title">Help For Food</h5>
                            <p class="card-text">Free Food feeding by our NGO</p>
                            <a href="{{ route('help-food') }}" class="btn btn-secondary">Donate Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="images/clothe.jpg" class="card-img-top" alt="Clothes" width="200">
                        <div class="card-body">
                            <h5 class="card-title">Help For Clothes</h5>
                            <p class="card-text">Donate for clothes, NGO distributes them</p>
                            <a href="{{ route('help-clothe') }}" class="btn btn-secondary">Donate Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="images/enviroment.jpeg" class="card-img-top" alt="Education" width="200">
                        <div class="card-body">
                            <h5 class="card-title">Help For Environment Protection</h5>
                            <p class="card-text">Environment protection by our NGO</p>
                            <a href="{{ route('help-environment') }}" class="btn btn-secondary">Donate Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="images/peace.jpeg" class="card-img-top" alt="Education" width="200">
                        <div class="card-body">
                            <h5 class="card-title">Help For Skill Development & Trainning Centre</h5>
                            <p class="card-text">Skill Deplopment by our NGO</p>
                            <a href="pay.php" class="btn btn-secondary">Donate Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="images/logo.png" class="card-img-top" alt="Education" width="200">
                        <div class="card-body">
                            <h5 class="card-title">Help For Watershed</h5>
                            <p class="card-text">Watershed service by our NGO</p>
                            <a href="pay.php" class="btn btn-secondary">Donate Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="images/logo.png" class="card-img-top" alt="Education" width="200">
                        <div class="card-body">
                            <h5 class="card-title">Help For Wild Life</h5>
                            <p class="card-text">Wild Life Protection by our NGO</p>
                            <a href="pay.php" class="btn btn-secondary">Donate Now</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>
    <!-- ==== Donate Section End ==== -->


    <!-- JavaScript for handling donation amount selection -->
    <script>
        document.querySelectorAll(".donation-btn").forEach(button => {
            button.addEventListener("click", function(event) {
                event.preventDefault(); // Prevent form submission
                document.getElementById("donationAmount").value = this.getAttribute("data-amount");
            });
        });

        document.getElementById("customAmountBtn").addEventListener("click", function(event) {
            event.preventDefault(); // Prevent form submission
            let customAmount = prompt("Enter your custom donation amount:");
            if (customAmount !== null && !isNaN(customAmount) && customAmount.trim() !== "") {
                document.getElementById("donationAmount").value = customAmount;
            }
        });
    </script>
    <script>
        function copyText(id) {
            const text = document.getElementById(id).innerText;
            navigator.clipboard.writeText(text).then(() => {
                alert(`Copied: ${text}`);
            });
        }
    </script>
    <script>
        function toggleIdTypeInputs() {
            var confirmIdType = document.getElementById("confirmIdType").value;
            var idTypeSelection = document.getElementById("idTypeSelection");
            var idType = document.getElementById("idType");

            if (confirmIdType === "yes") {
                idTypeSelection.style.display = "block";
            } else {
                idTypeSelection.style.display = "none";
                idType.value = "";
                hideIdInputs();
            }
        }

        function showIdInput() {
            var idType = document.getElementById("idType").value;
            var aadharInput = document.getElementById("aadharInput");
            var panInput = document.getElementById("panInput");

            // Hide both inputs initially
            aadharInput.style.display = "none";
            panInput.style.display = "none";

            // Show the selected ID input field
            if (idType === "aadhar") {
                aadharInput.style.display = "block";
            } else if (idType === "pan") {
                panInput.style.display = "block";
            }
        }

        function hideIdInputs() {
            document.getElementById("aadharInput").style.display = "none";
            document.getElementById("panInput").style.display = "none";
        }

        function validateAadhar() {
            var aadhar = document.getElementById("aadhar").value;
            var error = document.getElementById("aadharError");
            if (/^\d{12}$/.test(aadhar)) {
                error.style.display = "none";
            } else {
                error.style.display = "block";
            }
        }

        function validatePAN() {
            var pan = document.getElementById("pan").value;
            var error = document.getElementById("panError");
            if (/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(pan)) {
                error.style.display = "none";
            } else {
                error.style.display = "block";
            }
        }

        function validateNumber() {
            var aadhar = document.getElementById("number").value;
            var error = document.getElementById("numberError");
            if (/^\d{10}$/.test(number)) {
                error.style.display = "none";
            } else {
                error.style.display = "block";
            }
        }

        function toggleCategorySelection() {
            var selectCategory = document.getElementById("selectCategory").value;
            var donationDiv = document.getElementById("categoryDiv");

            if (selectCategory === "yes") {
                categoryDiv.style.display = "block";
            } else {
                categoryDiv.style.display = "none";
            }
        }

        function toggleAddressFields() {
            const choice = document.getElementById('provideAddress').value;
            const addressSection = document.getElementById('addressSection');
            addressSection.style.display = (choice === 'yes') ? 'block' : 'none';
        }
    </script>
    <script>
        function updateDistricts() {
            const state = document.getElementById('stateSelect').value;
            const districtSelect = document.getElementById('districtSelect');

            const stateDistricts = {
                "Andhra Pradesh": [
                    "Allurisitharamaraju", "Ananthapuramu", "Annamayya", "Anakapalli", "Baptla",
                    "Chittoor", "East Godavari", "Eluru", "Guntur", "Kakinada", "Konaseema",
                    "Krishna", "Kurnool", "Nandyal", "N.T.R", "Palnadu", "Parvathipurammanyam",
                    "Prakasam", "Srisathyasai", "SPS Nellore", "Srikakulam", "Tirupati",
                    "Visakhapatnam", "Vizianagaram", "West Godavari", "YSR Kadapa"
                ],
                "Arunachal Pradesh": [
                    "Anjaw", "Changlang", "Dibang Valley", "East Kameng", "East Siang",
                    "Itanagar", "Kra Daadi", "Kurung Kumey", "Lohit", "Longding",
                    "Lower Dibang Valley", "Lower Subansiri", "Namsai", "Papumpare",
                    "Shiyomi", "Siang", "Tawang", "Tirap", "Upper Siang",
                    "Upper Subansiri", "West Kameng", "West Siang"
                ],
                "Assam": [
                    "Baksa", "Barpeta", "Bongaigaon", "Cachar", "Charaideo", "Chirang",
                    "Darrang", "Dhemaji", "Dhubri", "Dibrugarh", "Dima Hasao", "Goalpara",
                    "Golaghat", "Hailakandi", "Jorhat", "Kamrup Metropolitan", "Kamrup",
                    "Karbi Anglong", "Karimganj", "Kokrajhar", "Lakhimpur", "Majuli",
                    "Morigaon", "Nagaon", "Sivasagar", "Sonitpur", "South Salmara-Mankachar",
                    "Tinsukia", "Udalguri", "West Karbi Anglong"
                ],
                "Bihar": [
                    "Araria", "Arwal", "Aurangabad", "Banka", "Begusarai", "Bhagalpur",
                    "Bhojpur", "Buxar", "Darbhanga", "East Champaran", "Gaya", "Gopalganj",
                    "Jamui", "Jehanabad", "Kaimur", "Katihar", "Khagaria", "Kishanganj",
                    "Lakhisarai", "Madhepura", "Madhubani", "Munger", "Muzaffarpur",
                    "Nalanda", "Nawada", "Patna", "Purnea", "Rohtas", "Saharsa", "Samastipur",
                    "Saran", "Sheikhpura", "Sheohar", "Sitamarhi", "Siwan", "Supaul",
                    "Vaishali", "West Champaran"
                ],
                "Chhattisgarh": [
                    "Balod", "Balodabazar Bhatapara", "Balrampur", "Bastar", "Bemetara",
                    "Bijapur", "Bilaspur", "Dantewada", "Dhamtari", "Durg", "Gariaband",
                    "Gaurela Pendra Marwahi", "Jangir Champa", "Jashpur", "Kanker",
                    "Kawardha", "Kondagaon", "Korba", "Korea", "Mahasamund", "Mungeli",
                    "Narayanpur", "Raigarh", "Raipur", "Rajnandgaon", "Sukma", "Surajpur",
                    "Surguja"
                ],
                "Goa": ["North Goa", "South Goa"],
                "Gujarat": [
                    "Ahmedabad", "Amreli", "Anand", "Arvalli", "Banaskantha", "Bharuch",
                    "Bhavnagar", "Botad", "Chhotaudepur", "Dahod", "Devbhumi Dwarka",
                    "Gandhinagar", "Gir Somnath", "Jamnagar", "Junagadh", "Kutch", "Kheda",
                    "Mahesana", "Mahisagar", "Morbi", "Narmada", "Navsari", "Panchmahals",
                    "Patan", "Porbandar", "Rajkot", "Sabarkantha", "Surat", "Surendranagar",
                    "Tapi", "Dang", "Vadodara", "Valsad"
                ],
                "Haryana": [
                    "Ambala", "Bhiwani", "Charkhi Dadri", "Faridabad", "Fathehabad",
                    "Gurugram", "Hisar", "Jhajjar", "Jind", "Kaithal", "Karnal",
                    "Kurukshetra", "Mahendragarh", "Nuh", "Palwal", "Panchkula",
                    "Panipat", "Rewari", "Rohtak", "Sirsa", "Sonipat", "Yamunanagar"
                ],
                "Himachal Pradesh": [
                    "Bilaspur", "Chamba", "Hamirpur", "Kangra", "Kinnaur", "Kullu",
                    "Lahaul and Spiti", "Mandi", "Shimla", "Sirmapur", "Solan", "Una"
                ],
                "Jharkhand": [
                    "Bokaro", "Chaibasa", "Chatra", "Deoghar", "Dhanbad", "Dumka", "Garhwa",
                    "Giridih", "Godda", "Gumla", "Hazaribagh", "Jamshedpur", "Jamtara",
                    "Khunti", "Koderma", "Latehar", "Lohardaga", "Pakur", "Palamu",
                    "Ramgarh", "Ranchi", "Sahibganj", "Seraikela", "Simdega"
                ],

                "Karnataka": [
                    "Bidar", "Kalaburagi", "Vijaypura", "Yadagiri", "Belagavi", "Bagalkot",
                    "Raichur", "Uttar Kannada", "Dharwad", "Gadag", "Koppal", "Ballari",
                    "Vijayanagar", "Haveri", "Davangere", "Shivamogga", "Udupi",
                    "Chikkamagaluru", "Chitradurga", "Dakshin Kannada", "Kodagu", "Hassan",
                    "Tumakuru", "Mysuru", "Mandya", "Chamrajnagar", "Ramanagara", "Bengluru",
                    "Bengaluru Rural", "Kolar", "Chikkaballapura"
                ],

                "Kerala": [
                    "Alappuzha", "Ernakulam", "Idukki", "Kannur", "Kasaragod", "Kollam",
                    "Kottayam", "Kozhikode", "Mallapuram", "Palakkad", "Pathanamthitta",
                    "Thrissur", "Trivandrum", "Wayanad"
                ],
                "Madhya Pradesh": [
                    "Agar Malwa", "Alirajpur", "Anuppur", "Ashokanagar", "Balaghat", "Barwani",
                    "Betul", "Bhind", "Bhopal", "Burhanpur", "Chhatarpur", "Chhindwara",
                    "Damoh", "Datia", "Dewas", "Dhar", "Dindori", "Guna", "Gwalior", "Harda",
                    "Indore", "Jabalpur", "Jhabua", "Katni", "Khandwa", "Khargone", "Mandla",
                    "Mandsaur", "Mauganj", "Morena", "Narmadapurm", "Narsinghpur", "Neemuch",
                    "Niwari", "Panna", "Raisen", "Rajgarh", "Ratlam", "Rewa", "Sagar",
                    "Satna", "Shehore", "Seoni", "Shahdol", "Shajapur", "Sheopur", "Shivpuri",
                    "Sidhi", "Singrouli", "Tikamgarh", "Ujjain", "Umaria", "Vidisha"
                ],

                "Maharashtra": [
                    "Ahmednagar", "Akola", "Amravati", "Aurangabad", "Need", "Bhandara",
                    "Buldhana", "Chandrapur", "Dhule", "Gadchiroli", "Gondia", "Hingoli",
                    "Jalgaon", "Jalna", "Kolhapur", "Latur", "Mumbai City", "Mumbai Suburban",
                    "Nagpur", "Nanded", "Nandurbar", "Nashik", "Osmanabad", "Palghar",
                    "Parbhani", "Pune", "Raigad", "Ratnagiri", "Sangli", "Satara", "Sindudurg",
                    "Solapur", "Thane", "Wardha", "Washim", "Yavatmal"
                ],
                "Manipur": [
                    "Bishnupur", "Chandel", "Churachandpur", "Pherzawl", "Tengnoupal",
                    "Kakching", "Noney", "Imphal East", "Imphal West", "Jiribam", "Kamjong",
                    "Kangpokpi", "Senapati", "Tamenglong", "Thoubal", "Ukhrul"
                ],

                "Meghalaya": [
                    "South West Garo Hills", "West Garo Hills", "North Garo Hills",
                    "East Garo Hills", "South Garo Hills", "West Khasi Hills",
                    "South West Khasi Hills", "Eastern West Khasi Hills", "East Khasi Hills",
                    "Ri Bhoi", "West Jaintia Hills", "East Jaintia Hills"
                ],

                "Mizoram": [
                    "Aizawl", "Lunglei", "Champhai", "Mamit", "Serchhip", "Kolasib",
                    "Lawngtlai", "Saiha", "Khawzawl"
                ],

                "Nagaland": [
                    "Dimapur", "Kiphire", "Kohima", "Longleng", "Mokokchung", "Mon",
                    "Paren", "Phek", "Tuensang", "Wokha", "Zunheboto", "Chumukedima",
                    "Niuland", "Noklak", "Shamator", "Tseminyu"
                ],
                "Orissa": [
                    "Angul", "Balangir", "Baleshwar", "Bargarh", "Bhadrak", "Boudh", "Cuttack",
                    "Deogarh", "Dhenkanal", "Gajapati", "Ganjam", "Jagatsinghpur", "Jajpur",
                    "Jharsuguda", "Kalahandi", "Kandhamal", "Kendrapara", "Kendujhar",
                    "Khorda", "Koraput", "Malkangiri", "Mayurbhanj", "Nabarangpur",
                    "Nayagarh", "Nuapada", "Puri", "Rayagada", "Sambalpur", "Subarnapur",
                    "Sundargarh"
                ],

                "Punjab": [
                    "Amritsar", "Barnala", "Bathinda", "Faridkot", "Fatehgarh Sahib",
                    "Fazilka", "Ferozepur", "Gurdaspur", "Hoshiarpur", "Jalandhar",
                    "Kapurthala", "Ludhiana", "Malerkotla", "Mansa", "Moga", "Sas Nagar",
                    "Sri Muktsar Sahib", "SBS Nagar", "Pathankot", "Patiala", "Rupnagar",
                    "Sangrur", "Tarn Taran"
                ],

                "Rajasthan": [
                    "Ajmer", "Alwar", "Banswara", "Baran", "Barmer", "Bharatpur", "Bhilwara",
                    "Bikaner", "Bundi", "Chittorgarh", "Churu", "Dausa", "Dholpur",
                    "Dungarpur", "Hanumangarh", "Jaisalmer", "Jaipur", "Jalor", "Jhalawar",
                    "Jhunjhunu", "Jodhpur", "Karauli", "Kota", "Nagaur", "Pali", "Pratapgarh",
                    "Rajsamand", "Sawai Madhopur", "Sikar", "Sirohi", "Sri Ganganagar",
                    "Tonk", "Udaipur"
                ],
                "Sikkim": [
                    "Gangtok", "Mangan", "Gyalshing", "Namchi", "Pakyong", "Soreng"
                ],

                "Tamil Nadu": [
                    "Ariyalur", "Chengalpattu", "Chennai", "Coimbatore", "Cuddalore",
                    "Dharmapuri", "Dindigul", "Erode", "Kallakurichi", "Kancheepuram",
                    "Kanniyakumari", "Karur", "Krishnagiri", "Madurai", "Mayiladuthurai",
                    "Nagapattinam", "Namakkal", "Nilgiris", "Perambalur", "Pudukkottai",
                    "Ramanathapuram", "Ranipet", "Salem", "Sivaganga", "Tenkasi", "Thanjavur",
                    "Theni", "Thoothukudi", "Tiruchirapalli", "Tirunelveli", "Tirupathur",
                    "Tiruvannamalai", "Tiruvarur", "Vellore", "Viluppuram", "Virudhunagar"
                ],

                "Telangana": [
                    "Adilabad", "Hyderabad", "Jagtial", "Jangaon", "Jayashankar Bhupalapally",
                    "Jogulamba Gadwal", "Kamareddy", "Karimnagar", "Khammam",
                    "Bhadradri Kothagudem", "Komaram Bheem Asifabad", "Mahabubnagar",
                    "Mahabubabad", "Mancherial", "Medak", "Medchal Malkajgiri", "Mulugu",
                    "Nagarkurnool", "Nalgonda", "Narayanpet", "Nirmal", "Nizamabad",
                    "Pedapalli", "Rajanna Sircilla", "Rangareddy", "Sangareddy", "Siddipet",
                    "Suryapet", "Vikarabad", "Wanaparthy", "Hanumakonda", "Warangal",
                    "Yadadri Bhuvanagari"
                ],

                "Tripura": [
                    "Dhalai", "Gomati", "Khowai", "North Tripura", "Sepahijala",
                    "South Tripura", "Unakoti", "West Tripura"
                ],
                "Uttar Pradesh": [
                    "Agra", "Aligarh", "Allahabad", "Ambedkar Nagar", "Auraiya", "Azamgarh", "Bagpat", "Bahraich",
                    "Ballia", "Balrampur",
                    "Banda", "Barabanki", "Bareilly", "Basti", "Bijnor", "Budaun", "Bulandshahr", "Chandauli",
                    "Chitrakoot", "Deoria",
                    "Etah", "Etawah", "Faizabad", "Farrukhabad", "Fatehpur", "Firozabad", "Gautam Buddha Nagar",
                    "Ghaziabad", "Ghazipur",
                    "Gonda", "Gorakhpur", "Hamirpur", "Hardoi", "Hathras", "Jalaun", "Jaunpur", "Jhansi",
                    "Jyotiba Phule Nagar", "Kannauj",
                    "Kanpur Dehat", "Kanpur Nagar", "Kaushambi", "Kheri", "Kushinagar", "Lalitpur", "Lucknow",
                    "Mahoba", "Maharajganj",
                    "Mainpuri", "Mathura", "Mau", "Meerut", "Mirzapur", "Moradabad", "Muzaffarnagar", "Pilibhit",
                    "Pratapgarh", "RaeBareli",
                    "Rampur", "Saharanpur", "Sant Kabir Nagar", "Sant Ravidas Nagar", "Shahjahanpur", "Shravasti",
                    "Siddharthnagar",
                    "Sitapur", "Sonbhadra", "Sultanpur", "Unnao", "Varanasi", "Manyavar Kanshiram Nagar",
                    "Prabuddha Nagar",
                    "Panchsheel Nagar", "Bhim Nagar", "Chhatrapati Shahuji Maharaj Nagar"
                ],
                "Uttarakhand": [
                    "Almora", "Bageshwar", "Chamoli", "Champawat", "Dehradun", "Haridwar",
                    "Nainital", "Pauri Garhwal", "Pithoragarh", "Rudraprayag", "Tehri Garhwal",
                    "Udham Singh Nagar", "Uttarkashi"
                ],

                "West Bengal": [
                    "North 24 Parganas", "South 24 Parganas", "Bankura", "Birbhum", "Cooch Behar",
                    "Dakshin Dinajpur", "Darjeeling", "Hooghly", "Howrah", "Jalpaiguri",
                    "Jhargram", "Kalimpong", "Kolkata", "Malda", "Murshidabad", "Nadia",
                    "Paschim Burdwan", "Purba Burdwan", "Paschim Medinipur", "Purba Medinipur",
                    "Purulia", "Uttar Dinajpur", "Alipurduar"
                ],

                "Delhi": ["Central Delhi", "North Delhi", "South Delhi", "East Delhi", "North East Delhi",
                    "South West Delhi", "New Delhi", "North West Delhi", "West Delhi", "Shahdara",
                    "South East Delhi"
                ],

                "Andaman and Nicobar Islands": ["Nicobar", "North and Middle Andaman", "South Andaman"],

                "Chandigarh": ["Chandigarh"],

                "Dadra and Nagar Haveli and Daman and Diu": ["Dadra and Nagar Haveli", "Daman", "Diu"],

                "Jammu and Kashmir": ["Anantnag", "Bandipora", "Baramulla", "Budgam", "Doda", "Ganderbal", "Jammu",
                    "Kathua", "Kishtwar", "Kulgam", "Kupwara", "Poonch", "Pulwama", "Rajouri", "Ramban", "Reasi",
                    "Samba", "Shopian", "Srinagar", "Udhampur"
                ],
                "Ladakh": ["Kargil", "Leh"],

                "Lakshadweep": ["Agatti", "Amini", "Andrott", "Bitra", "Chetlat", "Kadmat", "Kalpeni", "Kavaratti",
                    "Kiltan", "Minicoy"
                ],

                "Puducherry": ["Karaikal", "Mahe", "Puducherry", "Yanam"]

            };

            districtSelect.innerHTML = '<option value="">-- Select a District --</option>';
            districtSelect.disabled = true;

            if (stateDistricts[state]) {
                districtSelect.disabled = false;
                stateDistricts[state].forEach(district => {
                    let option = document.createElement("option");
                    option.value = district;
                    option.text = district;
                    districtSelect.appendChild(option);
                });
            }
        }
    </script>
    <script>
        function showToast(type, message) {
            var toast = $('#mainToast');
            var title = (type === 'success') ? 'Success' : 'Error';
            var bgClass = (type === 'success') ? 'bg-success' : 'bg-danger';

            toast.removeClass('bg-success bg-danger').addClass(bgClass);
            toast.find('#toastBody').html(message);

            toast.toast('show');
        }
    </script>
@endsection
