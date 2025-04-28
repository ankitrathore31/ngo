@extends('home.layout.MasterLayout')
@section('content')

<div class="wrapper">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <!-- Info Card -->
                <div class="card mb-4 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-5">
                            <img src="images/food.jpg" class="img-fluid rounded-start w-100 h-100" alt="Feeding the Poor">
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <h5 class="card-title">Feed the Hungry</h5>
                                <h6 class="card-subtitle text-muted mb-2">One Meal Can Save a Life</h6>
                                <p class="card-text">Your contribution helps us serve hot meals to the homeless and underprivileged daily. No one deserves to sleep hungry.</p>
                                <h5 class="text-success">₹1500</h5>
                            </div>
                        </div>
                    </div>
                </div>
    
              <!-- Donation Form (like checkout panel) -->
              <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Donor Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pay') }}">
                        <div class="mb-3">
                            <label for="donor_name" class="form-label">Full Name</label>
                            <input type="text" name="donor_name" id="donor_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="donor_email" class="form-label">Email Address</label>
                            <input type="email" name="donor_email" id="donor_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="donor_number" class="form-label">Contact Number</label>
                            <input type="tel" name="donor_number" id="donor_number" class="form-control"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="donation_amount" class="form-label">Donation Amount</label>
                            <input type="number" name="donation_amount" id="donation_amount" class="form-control"
                                value="1500" readonly>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">Proceed to Donate</button>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

@endsection
