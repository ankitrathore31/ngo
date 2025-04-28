@extends('ngo.layout.master')
@Section('content')
<!-- Custom CSS for Hover Animation -->
<style>
    .card-hover {
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .card-hover:hover {
        transform: translateY(-7px) scale(1.02);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .card i {
        display: block;
    }

    .card p {
        font-size: 0.9rem;
        margin: 0;
    }

    .card h5 {
        font-weight: bold;
    }
</style>
<div class="container my-4">
    <!-- Total Beneficiaries Registration -->
    <h5 class="mb-3">📝 Beneficiaries Overview</h5>
    <div class="row g-3">
        <div class="col-md-3 col-sm-6">
            <div class="card bg-primary text-white card-hover p-3">
                <i class="fas fa-user-plus fa-2x mb-2"></i>
                <p class="mb-1">Total Beneficiaries Registration</p>
                <h5>120</h5>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card bg-warning text-dark card-hover p-3">
                <i class="fas fa-tasks fa-2x mb-2"></i>
                <p class="mb-1">Pending / Approved / Rejected</p>
                <h5>20 / 80 / 10</h5>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card bg-secondary text-white card-hover p-3">
                <i class="fas fa-venus-mars fa-2x mb-2"></i>
                <p class="mb-1">Gender & Religion Wise</p>
                <h5>60 M / 60 F</h5>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card bg-danger text-white card-hover p-3">
                <i class="fas fa-trash-alt fa-2x mb-2"></i>
                <p class="mb-1">Deleted Registrations</p>
                <h5>5</h5>
            </div>
        </div>
    </div>

    <!-- Staff Overview -->
    <h5 class="mt-5 mb-3">👨‍💼 Staff Overview</h5>
    <div class="row g-3">
        <div class="col-md-3 col-sm-6">
            <div class="card bg-info text-white card-hover p-3">
                <i class="fas fa-user-tie fa-2x mb-2"></i>
                <p class="mb-1">Total Staff</p>
                <h5>25</h5>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card bg-light text-dark card-hover p-3">
                <i class="fas fa-calendar-check fa-2x mb-2"></i>
                <p class="mb-1">Present / Absent</p>
                <h5>18 / 7</h5>
            </div>
        </div>
    </div>

    <!-- Members Overview -->
    <h5 class="mt-5 mb-3">👥 Member Overview</h5>
    <div class="row g-3">
        <div class="col-md-3 col-sm-6">
            <div class="card bg-success text-white card-hover p-3">
                <i class="fas fa-users fa-2x mb-2"></i>
                <p class="mb-1">Total Members</p>
                <h5>100</h5>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card bg-dark text-white card-hover p-3">
                <i class="fas fa-toggle-on fa-2x mb-2"></i>
                <p class="mb-1">Active / Inactive</p>
                <h5>70 / 30</h5>
            </div>
        </div>
    </div>

    <!-- Donations Overview -->
    <h5 class="mt-5 mb-3">💰 Donation Overview</h5>
    <div class="row g-3">
        <div class="col-md-3 col-sm-6">
            <div class="card bg-success text-white card-hover p-3">
                <i class="fas fa-hand-holding-usd fa-2x mb-2"></i>
                <p class="mb-1">Today's Donation</p>
                <h5>₹5,000</h5>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card bg-primary text-white card-hover p-3">
                <i class="fas fa-donate fa-2x mb-2"></i>
                <p class="mb-1">Total Donation</p>
                <h5>₹1,20,000</h5>
            </div>
        </div>
    </div>

    <!-- Expense Overview -->
    <h5 class="mt-5 mb-3">📉 Expenses Overview</h5>
    <div class="row g-3">
        <div class="col-md-3 col-sm-6">
            <div class="card bg-danger text-white card-hover p-3">
                <i class="fas fa-coins fa-2x mb-2"></i>
                <p class="mb-1">Today's Cost</p>
                <h5>₹2,000</h5>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card bg-warning text-dark card-hover p-3">
                <i class="fas fa-file-invoice-dollar fa-2x mb-2"></i>
                <p class="mb-1">Total Cost</p>
                <h5>₹90,000</h5>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card bg-secondary text-white card-hover p-3">
                <i class="fas fa-wallet fa-2x mb-2"></i>
                <p class="mb-1">Remaining Amount</p>
                <h5>₹30,000</h5>
            </div>
        </div>
    </div>

    <!-- Activities Overview -->
    <h5 class="mt-5 mb-3">🏃 Activities Overview</h5>
    <div class="row g-3">
        <div class="col-md-3 col-sm-6">
            <div class="card bg-info text-white card-hover p-3">
                <i class="fas fa-running fa-2x mb-2"></i>
                <p class="mb-1">Today's Activities</p>
                <h5>8</h5>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card bg-dark text-white card-hover p-3">
                <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                <p class="mb-1">Total Activities</p>
                <h5>220</h5>
            </div>
        </div>
    </div>

</div>



@endsection