@extends('home.layout.MasterLayout')
@Section('content')

<div class="wrapper">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-white border-bottom p-2">
                        <div class="card-title text-center">
                            <h5>Donate For Education</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action=" {{ route('pay') }}">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" name="donor_name" id="name" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Email:</label>
                                <input type="email" name="donor_email" id="name" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Number:</label>
                                <input type="number" name="donor_number" id="name" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="amount" class="form-label">Amount:</label>
                                <input type="number" name="donation_amount" value="3000" id="name" class="form-control" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <input type="submit" class="btn btn-success" value="Donate">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <img src="images/education2.jpg" alt="" class="img-fluid" width="100%">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection