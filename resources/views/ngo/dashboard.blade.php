@extends('ngo.layout.master')
@section('content')
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
        @php
            $user = auth()->user();
            $isStaff = $user && $user->user_type === 'staff';
        @endphp
        <div class=" mt-4">
            <div class="container my-4">
                @if (!$isStaff || $user->hasPermission('beneficiarie-add') || $user->hasPermission('all-beneficiarie-list'))
                    <h5 class=" fw-bold mb-2">- Beneficiaries </h5>

                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-white bg-primary p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-plus fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Total Beneficiaries</p>
                                        <h5 class="mb-0">{{ $allbene }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-white bg-warning p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clock fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Pending Beneficiaries</p>
                                        <h5 class="mb-0">{{ $penbene }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-white bg-success p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Approved Beneficiaries</p>
                                        <h5 class="mb-0">{{ $apbene }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-white bg-danger p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-times-circle fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Rejected Beneficiaries</p>
                                        <h5 class="mb-0">{{ $rebene }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (
                    !$isStaff ||
                        ($user->hasPermission('add-activity') ||
                            $user->hasPermission('activity-list') ||
                            $user->hasPermission('add-event') ||
                            $user->hasPermission('event-list')))
                    <div class="row ">
                        <h5 class="fw-bold mb-2">- Activities</h5>
                        @if (!$isStaff || $user->hasPermission('add-activity'))
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card text-white bg-info p-3 h-100 card-hover">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-running fa-2x me-3"></i>
                                        <div>
                                            <p class="mb-1">Today's Activities</p>
                                            <h5 class="mb-0">{{ $todayacti }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card text-white bg-warning p-3 h-100 card-hover">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clipboard-list fa-2x me-3"></i>
                                        <div>
                                            <p class="mb-1">Total Activities</p>
                                            <h5 class="mb-0">{{ $allacti }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (!$isStaff || $user->hasPermission('add-event'))
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card text-white bg-info p-3 h-100 card-hover">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clipboard-list fa-2x me-3"></i>
                                        <div>
                                            <p class="mb-1">Today Event</p>
                                            <h5 class="mb-0">0</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card text-white bg-primary p-3 h-100 card-hover">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clipboard-list fa-2x me-3"></i>
                                        <div>
                                            <p class="mb-1">Total Event</p>
                                            <h5 class="mb-0">0</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
                @if (
                    !$isStaff ||
                        $user->hasPermission('member-list') ||
                        $user->hasPermission('add-member-position') ||
                        $user->hasPermission('member-position-list') ||
                        $user->hasPermission('member-activity') ||
                        $user->hasPermission('active-members') ||
                        $user->hasPermission('inactive-members'))
                    <div class="row">
                        <h5 class="fw-bold mb-2">- Memebers</h5>
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-success p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Total Members</p>
                                        <h5 class="mb-0">{{ $allmem }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-success p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Active Members</p>
                                        <h5 class="mb-0">{{ $appmem }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-danger p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-times-circle fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Inactive Members</p>
                                        <h5 class="mb-0">{{ $penmem }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (
                    !$isStaff ||
                        $user->hasPermission('add-staff') ||
                        $user->hasPermission('staff-list') ||
                        $user->hasPermission('appointment-letter') ||
                        $user->hasPermission('resign-letter') ||
                        $user->hasPermission('staff-salary') ||
                        $user->hasPermission('staff-idcard') ||
                        $user->hasPermission('staff-passbook') ||
                        $user->hasPermission('staff-activity'))
                    <div class="row">
                        <h5 class="fw-bold mb-2">- Staff</h5>
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-info p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-tie fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Total Staff</p>
                                        <h5 class="mb-0">{{$totalStaff}}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-success p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Present Staff</p>
                                        <h5 class="mb-0">0</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-danger p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-times-circle fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Absent Staff</p>
                                        <h5 class="mb-0">0</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (
                    !$isStaff ||
                        $user->hasPermission('donation') ||
                        $user->hasPermission('donation-list') ||
                        $user->hasPermission('online-donor-list') ||
                        $user->hasPermission('donation-card-list') ||
                        $user->hasPermission('all-donor-list') ||
                        $user->hasPermission('donation-report'))
                    <div class="row">
                        <h5 class="fw-bold mb-2">- Donation</h5>
                        @if (!$isStaff || $user->hasPermission('donation'))
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card text-white bg-success p-3 h-100 card-hover">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-hand-holding-usd fa-2x me-3"></i>
                                        <div>
                                            <p class="mb-1">Today's Donation</p>
                                            <h5 class="mb-0">₹ {{ $todaydonate }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (!$isStaff || $user->hasPermission('onilne-donor-list'))
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card text-white bg-primary p-3 h-100 card-hover">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-donate fa-2x me-3"></i>
                                        <div>
                                            <p class="mb-1">Total Online Donation</p>
                                            <h5 class="mb-0">₹ {{ $succdonate }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (!$isStaff || $user->hasPermission('donation-list'))
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card text-white bg-info p-3 h-100 card-hover">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-donate fa-2x me-3"></i>
                                        <div>
                                            <p class="mb-1">Total Offline Donation</p>
                                            <h5 class="mb-0">₹ {{ $offlinedonate }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (!$isStaff || $user->hasPermission('all-donor-list'))
                            <div class="col-md-3 col-sm-6 mb-3">
                                <div class="card text-white bg-success p-3 h-100 card-hover">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-hand-holding-usd fa-2x me-3"></i>
                                        <div>
                                            <p class="mb-1">Total Donation</p>
                                            <h5 class="mb-0">₹ {{ $totaldonation }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
                @if (
                    !$isStaff ||
                        $user->hasPermission('add-bill') ||
                        $user->hasPermission('bill-list') ||
                        $user->hasPermission('generate-bill') ||
                        $user->hasPermission('gbs-bill-list') ||
                        $user->hasPermission('sanstha-bill-list'))
                    <div class="row">
                        <h5 class="fw-bold mb-2">- Cost</h5>
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-danger p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-coins fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Today's Cost</p>
                                        <h5 class="mb-0">0</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-dark bg-warning p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-invoice-dollar fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Total Cost</p>
                                        <h5 class="mb-0">0</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-secondary p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-wallet fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Remaining Amount</p>
                                        <h5 class="mb-0">0</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
