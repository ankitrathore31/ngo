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
            <div class="community-donation p-4 border rounded shadow-sm bg-light">
               <div class="donation-form">
                  <form method="post" action="pay.php">
                     <div class="container mt-4">
                        <h5>Your Donation:</h5>
                        <div class="input-group">
                           <span class="input-group-text">₹</span>
                           <input type="text" id="donationAmount" name="donation_amount" class="form-control" placeholder="Enter amount" required>
                        </div>
                        <div class="mt-3">
                           <button class="btn btn-outline-primary donation-btn" data-amount="100">100</button>
                           <button class="btn btn-outline-primary donation-btn" data-amount="200">200</button>
                           <button class="btn btn-outline-primary donation-btn" data-amount="300">300</button>
                           <button class="btn btn-outline-primary donation-btn" data-amount="500">500</button>
                           <button class="btn btn-outline-primary donation-btn" data-amount="1100">1100</button>
                           <button class="btn btn-outline-primary donation-btn" data-amount="2100">2100</button>
                           <button class="btn btn-outline-primary donation-btn" data-amount="5100">5100</button>
                           <button class="btn btn-outline-primary donation-btn" data-amount="11000">11000</button>
                           <button class="btn btn-outline-primary donation-btn" data-amount="21000">21000</button>
                           <button class="btn btn-outline-danger" id="customAmountBtn">Custom</button>
                        </div>
                     </div>
                     <div class="mb-3">
                        <h6 class="mt-2">After Gave Donation Get a Certifiate:</h6>
                     </div>
                     <div class="text-center">
                        <button type="submit" class="btn btn-primary">Donate Now <i class="fa fa-arrow-right"></i></button>
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
               <button class="btn btn-outline-secondary btn-primary text-white btn-sm w-100" onclick="copyText('holder')">Copy</button>
            </div>
         </div>

         <div class="row align-items-center mb-3">
            <div class="col-md-4 fw-bold">Account Number:</div>
            <div class="col-md-6" id="account">08310200000368</div>
            <div class="col-md-2">
               <button class="btn btn-outline-secondary btn-primary text-white btn-sm w-100" onclick="copyText('account')">Copy</button>
            </div>
         </div>

         <div class="row align-items-center mb-3">
            <div class="col-md-4 fw-bold">Bank Name:</div>
            <div class="col-md-6" id="account">Bank Of Baroda</div>
            <div class="col-md-2">
               <button class="btn btn-outline-secondary btn-primary text-white btn-sm w-100" onclick="copyText('account')">Copy</button>
            </div>
         </div>

         <div class="row align-items-center mb-3">
            <div class="col-md-4 fw-bold">IFSC Code:</div>
            <div class="col-md-6" id="ifsc">BARB0AMERIA</div>
            <div class="col-md-2">
               <button class="btn btn-outline-secondary btn-primary text-white btn-sm w-100" onclick="copyText('ifsc')">Copy</button>
            </div>
         </div>

         <div class="row align-items-center mb-3">
            <div class="col-md-4 fw-bold">Branch:</div>
            <div class="col-md-6" id="branch">Ameria</div>
            <div class="col-md-2">
               <button class="btn btn-outline-secondary btn-primary text-white btn-sm w-100" onclick="copyText('branch')">Copy</button>
            </div>
         </div>

         <div class="row align-items-center">
            <div class="col-md-4 fw-bold">Account Type:</div>
            <div class="col-md-6" id="type">Current</div>
            <div class="col-md-2">
               <button class="btn btn-outline-secondary btn-primary text-white btn-sm w-100" onclick="copyText('type')">Copy</button>
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
                  <div class="col-12 d-flex flex-column flex-md-row align-items-center justify-content-between mb-3">
                     <label class="fw-bold text-center text-md-end col-md-5 mb-2 mb-md-0">PhonePe UPI ID:</label>
                     <div class="col-md-5 text-center text-md-start" id="upi">gyanbhartingo@ybl</div>
                     <div class="col-md-2 mt-2 mt-md-0">
                        <button class="btn btn-outline-success btn-sm w-100" onclick="copyText('upi')">Copy</button>
                     </div>
                  </div>

                  <!-- PhonePe No -->
                  <div class="col-12 d-flex flex-column flex-md-row align-items-center justify-content-between mb-3">
                     <label class="fw-bold text-center text-md-end col-md-5 mb-2 mb-md-0">PhonePe UPI Number:</label>
                     <div class="col-md-5 text-center text-md-start" id="phonepe">9719735760</div>
                     <div class="col-md-2 mt-2 mt-md-0">
                        <button class="btn btn-outline-success btn-sm w-100" onclick="copyText('phonepe')">Copy</button>
                     </div>
                  </div>

                  <!-- Pay Now Button -->
                  <div class="col-12 text-end mt-3">
                     <a href="upi://pay?pa=gyanbhartingo@ybl&pn=GYAN%20BHARTI%20SANSTHA" class="btn btn-success">
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
                        <img src="assets/images/qr.jpeg" class="img-fluid mb-3" alt="QR Code" style="max-width: 200px;">
                     </a>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6 text-center">
                     <!-- Download Button -->
                     <a href="assets/images/qr.jpeg" download="GyanBharti_UPI_QR" class="btn btn-outline-primary btn-sm">
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
                  <a href="pay.php" class="btn btn-secondary">Donate Now</a>
               </div>
            </div>
         </div>
         <div class="col-md-4 mb-4">
            <div class="card">
               <img src="images/clothe.jpg" class="card-img-top" alt="Clothes" width="200">
               <div class="card-body">
                  <h5 class="card-title">Help For Clothes</h5>
                  <p class="card-text">Donate for clothes, NGO distributes them</p>
                  <a href="pay.php" class="btn btn-secondary">Donate Now</a>
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
                  <a href="pay.php" class="btn btn-secondary">Donate Now</a>
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

@endsection