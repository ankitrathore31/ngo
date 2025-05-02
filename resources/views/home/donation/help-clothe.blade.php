@extends('home.layout.MasterLayout')
@section('content')
    <div class="wrapper">
        <!-- Clothes Donation Page -->
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card mb-4 shadow-sm">
                        <div class="row g-0">
                            <div class="col-md-5">
                                <img src="images/clothe.jpg" class="img-fluid rounded-start w-100 h-100"
                                    alt="Clothes Donation">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h5 class="card-title">Clothe the Needy</h5>
                                    <h6 class="card-subtitle text-muted mb-2">Warmth is a Gift</h6>
                                    <p class="card-text">Donate to provide clean and warm clothes to children, elderly, and
                                        families living on the streets.</p>
                                    <h5 class="text-success">₹1000</h5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Donation Form -->
                    <!-- Donation Form (like checkout panel) -->
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Donor Information</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('donate') }}">
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
                                        value="1000" readonly>
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
