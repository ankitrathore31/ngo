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
    <div class="container-fluid my-4">
        <div class=" mt-4">
            <div class="row g-3">

                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-primary p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-plus fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Total Beneficiaries</p>
                                <h5 class="mb-0">120</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-warning p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Pending Beneficiaries</p>
                                <h5 class="mb-0">20</h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-success p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Approved Beneficiaries</p>
                                <h5 class="mb-0">80</h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-danger p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-times-circle fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Rejected Beneficiaries</p>
                                <h5 class="mb-0">10</h5>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-danger p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-trash-alt fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Deleted Registrations</p>
                                <h5 class="mb-0">5</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-info p-3 h-100 card-hover">
                        <div class="d-flex align-items-center"> 
                            <i class="fas fa-running fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Today's Activities</p>
                                <h5 class="mb-0">8</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Add more cards below as needed -->

                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-warning p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clipboard-list fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Total Activities</p>
                                <h5 class="mb-0">220</h5>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-success p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Total Members</p>
                                <h5 class="mb-0">100</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-success p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Active Members</p>
                                <h5 class="mb-0">70</h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-danger p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-times-circle fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Inactive Members</p>
                                <h5 class="mb-0">30</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-info p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-tie fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Total Staff</p>
                                <h5 class="mb-0">25</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-success p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Present Staff</p>
                                <h5 class="mb-0">18</h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-danger p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-times-circle fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Absent Staff</p>
                                <h5 class="mb-0">7</h5>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-success p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-hand-holding-usd fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Today's Donation</p>
                                <h5 class="mb-0">₹5,000</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-primary p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-donate fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Total Donation</p>
                                <h5 class="mb-0">₹1,20,000</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-danger p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-coins fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Today's Cost</p>
                                <h5 class="mb-0">₹2,000</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card text-dark bg-warning p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-invoice-dollar fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Total Cost</p>
                                <h5 class="mb-0">₹90,000</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card text-white bg-secondary p-3 h-100 card-hover">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-wallet fa-2x me-3"></i>
                            <div>
                                <p class="mb-1">Remaining Amount</p>
                                <h5 class="mb-0">₹30,000</h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
