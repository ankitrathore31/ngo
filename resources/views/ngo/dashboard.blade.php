@extends('ngo.layout.master')
@section('content')
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
                @if (!$isStaff || $user->hasPermission('new-registration') || $user->hasPermission('pending-registration'))
                    <h5 class=" fw-bold mb-2">- Registration </h5>

                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-white bg-primary p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-plus fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Total Registration</p>
                                        <h5 class="mb-0">{{ totalReg() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-white bg-warning p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clock fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Pending Registration</p>
                                        <h5 class="mb-0">{{ totalPendingReg() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-white bg-success p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Approved Registration</p>
                                        <h5 class="mb-0">{{ totalApprovedReg() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-white bg-danger p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-times-circle fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Rejected Registration</p>
                                        <h5 class="mb-0">{{ totalRejectedReg() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (!$isStaff || $user->hasPermission('beneficiarie-add') || $user->hasPermission('all-beneficiarie-list'))
                    <h5 class=" fw-bold mb-2">- Beneficiaries Survey</h5>

                    <div class="row g-3">
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-primary p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-plus fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Total Beneficiaries Survey</p>
                                        <h5 class="mb-0">{{ TotalSurvey() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-warning p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clock fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Pending Beneficiaries Survey</p>
                                        <h5 class="mb-0">{{ PendingSurvey() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-success p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Approved Beneficiaries Survey</p>
                                        <h5 class="mb-0">{{ ApproveSurvey() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                @endif
                @if (!$isStaff || $user->hasPermission('beneficiarie-add') || $user->hasPermission('all-beneficiarie-list'))
                    <h5 class=" fw-bold mb-2">- Beneficiaries </h5>

                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-white bg-primary p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-plus fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Total Beneficiaries</p>
                                        <h5 class="mb-0">{{ ApproveSurvey() }}</h5>
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
                                        <h5 class="mb-0">{{ ApproveSurvey() }}</h5>
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
                @if (!$isStaff || $user->hasPermission('beneficiarie-add') || $user->hasPermission('all-beneficiarie-list'))
                    <h5 class=" fw-bold mb-2">- Beneficiaries Facilities </h5>

                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-white bg-primary p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-plus fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Approve Demand Facilities</p>
                                        <h5 class="mb-0">{{ totalApprovedDemand() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-white bg-warning p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clock fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Pending Demand Facilities</p>
                                        <h5 class="mb-0">{{ totalPendingDemand() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-white bg-success p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Distributed Facilities</p>
                                        <h5 class="mb-0">{{ totalDistributed() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="card text-white bg-danger p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-times-circle fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Rejected Facilities</p>
                                        <h5 class="mb-0">{{ totalRejectedDistributed() }}</h5>
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
                        ($user->hasPermission('add-project') ||
                            $user->hasPermission('project-list') ||
                            $user->hasPermission('report-list')))
                    <div class="row ">
                        <h5 class="fw-bold mb-2">- Projects</h5>
                        @if (!$isStaff || $user->hasPermission('add-project'))
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="card text-white bg-warning p-3 h-100 card-hover">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clipboard-list fa-2x me-3"></i>
                                        <div>
                                            <p class="mb-1">Total Project</p>
                                            <h5 class="mb-0">{{ totalProject() }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (!$isStaff || $user->hasPermission('report-list'))
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="card text-white bg-info p-3 h-100 card-hover">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-running fa-2x me-3"></i>
                                        <div>
                                            <p class="mb-1">Total Project Report</p>
                                            <h5 class="mb-0">{{ totalProjectReport() }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="card text-white bg-warning p-3 h-100 card-hover">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-clipboard-list fa-2x me-3"></i>
                                        <div>
                                            <p class="mb-1">Total Project Category</p>
                                            <h5 class="mb-0">{{ totalProjectCategory() }}</h5>
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
                                        <h5 class="mb-0">{{ $totalStaff }}</h5>
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
                                            <h5 class="mb-0">₹ {{ number_format($todaydonate, 2) }}</h5>
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
                                            <h5 class="mb-0">₹ {{ number_format($succdonate, 2) }}</h5>
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
                                            <h5 class="mb-0">₹ {{ number_format($offlinedonate, 2) }}</h5>
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
                                            <h5 class="mb-0">₹ {{ number_format($totaldonation, 2) }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
                @if (!$isStaff || $user->hasPermission('add-group') || $user->hasPermission('group-list'))
                    <div class="row">
                        <h5 class="fw-bold mb-2">- Organization</h5>
                        <div class="col-md-3 mb-2">
                            <div class="card text-center shadow-sm text-white"
                                style="background: linear-gradient(45deg, #43e97b, #38f9d7);">
                                <div class="card-body">
                                    <p class="card-title fw-bold"> Total Organization </p>
                                    <h5 class="card-text fs-4">{{ TotalOrganization() }}</h5>
                                </div>
                            </div>
                        </div>
                        @php
                            $gradients = [
                                'background: linear-gradient(45deg, #ff6a00, #ffcc00);', // orange to yellow
                                'background: linear-gradient(45deg, #ff416c, #ff4b2b);', // pink to red
                                'background: linear-gradient(45deg, #36d1dc, #5b86e5);', // cyan to blue
                                'background: linear-gradient(45deg, #43e97b, #38f9d7);', // green to teal
                                'background: linear-gradient(45deg, #f7971e, #ffd200);', // orange to gold
                                'background: linear-gradient(45deg, #7f00ff, #e100ff);', // purple to magenta
                            ];
                        @endphp
                        @foreach (organization() as $index => $item)
                            <div class="col-md-3 mb-2">
                                <div class="card text-center shadow-sm text-white"
                                    style="{{ $gradients[$index % count($gradients)] }}">
                                    <div class="card-body">
                                        <p class="mb-1">{{ $item->name }}</p>
                                        <h5 class="mb-0">{{ TotalorganizationGroup($item->id) }}</h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                @endif
                @if (
                    !$isStaff ||
                        $user->hasPermission('add-bill') ||
                        $user->hasPermission('bill-list') ||
                        $user->hasPermission('generate-bill') ||
                        $user->hasPermission('gbs-bill-list') ||
                        $user->hasPermission('sanstha-bill-list'))
                    @php
                        $cost = costTotals();
                    @endphp

                    <div class="row">
                        <h5 class="fw-bold mb-2">- Cost</h5>

                        <div class="col-md-6 col-sm-6 mb-3">
                            <div class="card text-white bg-danger p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-coins fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Today's Cost</p>
                                        <h5 class="mb-0">₹{{ $cost['todayCostAmount'] }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 mb-3">
                            <div class="card text-dark bg-warning p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-invoice-dollar fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Total Cost</p>
                                        <h5 class="mb-0">₹{{ $cost['totalCostAmount'] }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (
                    !$isStaff ||
                        $user->hasPermission('add-bill') ||
                        $user->hasPermission('bill-list') ||
                        $user->hasPermission('generate-bill') ||
                        $user->hasPermission('gbs-bill-list') ||
                        $user->hasPermission('sanstha-bill-list'))
                    @php
                        $cost = costTotals();
                        $totalCostAmount = $cost['totalCostAmount'];
                        $remainingBalance = ($totalIncome ?? 0) - $totalCostAmount;
                    @endphp

                    <div class="row">
                        <h5 class="fw-bold mb-2">- Balance Sheet</h5>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-success p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-invoice-dollar fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Total Income</p>
                                        <h5 class="mb-0">₹{{ number_format($totalIncome, 2) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-dark bg-info p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-invoice-dollar fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Total Cost</p>
                                        <h5 class="mb-0">₹{{ number_format($totalCostAmount, 2) }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-dark bg-secondary p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-wallet fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Total Remaining Amount</p>
                                        <h5 class="mb-0">
                                            <span style="color: {{ $remainingBalance >= 0 ? 'green' : 'red' }};">
                                                {{ $remainingBalance >= 0 ? '+' : '-' }}
                                                ₹{{ number_format(abs($remainingBalance), 2) }}
                                            </span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif


                @if (
                    !$isStaff ||
                        $user->hasPermission('discover-problems') ||
                        $user->hasPermission('problem-list') ||
                        $user->hasPermission('solutions'))
                    <div class="row">
                        <h5 class="fw-bold mb-2">- Social Problem</h5>
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-danger p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-coins fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Discover Social Problems</p>
                                        <h5 class="mb-0">{{ totalProblem() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-dark bg-warning p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-invoice-dollar fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Pending Social Problems</p>
                                        <h5 class="mb-0">{{ totalProblem() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-secondary p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-wallet fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Solutions Social Problems</p>
                                        <h5 class="mb-0">{{ totalSolution() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (
                    !$isStaff ||
                        $user->hasPermission('health-card') ||
                        $user->hasPermission('health-card') ||
                        $user->hasPermission('health-card'))
                    <div class="row">
                        <h5 class="fw-bold mb-2">- Health Card Facility</h5>
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-success p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-coins fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Total Health Card</p>
                                        <h5 class="mb-0">{{ totalHealthCard() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-dark bg-warning p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-file-invoice-dollar fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Demand Health Facility</p>
                                        <h5 class="mb-0">{{ DemandHalthFacility() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-secondary p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-wallet fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Health Facility Bill Investigation</p>
                                        <h5 class="mb-0">{{ InvestigationHalthFacility() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-primary p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-wallet fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Health Facility Bill Verify</p>
                                        <h5 class="mb-0">{{ VerifyHalthFacility() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-warning p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-wallet fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Health Facility Demand Approve</p>
                                        <h5 class="mb-0">{{ ApprovelHalthFacility() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-success p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-wallet fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Health Facility Final Approve</p>
                                        <h5 class="mb-0">{{ ApproveHalthFacility() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-primary p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-wallet fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Pending Health Facility</p>
                                        <h5 class="mb-0">{{ DemandPendingHalthFacility() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-primary p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-wallet fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Non-Budget Health Facility</p>
                                        <h5 class="mb-0">{{ NonBudgetHalthFacility() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card text-white bg-danger p-3 h-100 card-hover">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-wallet fa-2x me-3"></i>
                                    <div>
                                        <p class="mb-1">Health Facility Demand Reject</p>
                                        <h5 class="mb-0">{{ RejectHalthFacility() }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @php
            $user = auth()->user();
            $isNGO = $user && $user->user_type === 'ngo';
        @endphp

        @if ($isNGO)
            <div class="container mt-5">
                <div class="row">
                    <!-- Total Visitors Card -->
                    <div class="col-md-6 mb-4">
                        <h5><b> - Website Traffic</b></h5>
                        <!-- Today's Visitors Card -->
                        <div class="card card-hover" style="background-color: rgb(240, 248, 255); transition: 0.3s;">
                            <div class="card-body">
                                <h5 class="card-title" style="color: rgb(25, 42, 86);">Visitors Today</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Tracked for the Current Day</h6>
                                <p class="card-text display-4" style="color: rgb(0, 123, 255); font-weight: bold;">
                                    {{ todayVisitor() }}</p>
                            </div>
                        </div>
                        <br>
                        <!-- Total Visitors Card -->
                        <div class="card card-hover" style="background-color: rgb(245, 245, 245); transition: 0.3s;">
                            <div class="card-body">
                                <h5 class="card-title" style="color: rgb(39, 174, 96);">Total Visitors</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Cumulative Count</h6>
                                <p class="card-text display-4" style="color: rgb(22, 160, 133); font-weight: bold;">
                                    {{ totalVisitor() }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Visitor Pie Chart -->
                    <div class="col-md-6 mb-4">
                        <div class="card card-hover">
                            <div class="card-body">
                                <h5 class="card-title">Visitors by Month</h5>
                                <h6 class="card-subtitle mb-2 text-muted">This Year</h6>
                                <div class="chart-container" style="position: relative; height: 300px;">
                                    <canvas id="visitorChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const monthlyData = @json(monthlyVisitorData());
        const monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];

        const ctx = document.getElementById('visitorChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Monthly Visitors',
                    data: monthlyData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(201, 203, 207, 0.8)',
                        'rgba(102, 187, 106, 0.8)',
                        'rgba(239, 83, 80, 0.8)',
                        'rgba(123, 31, 162, 0.8)',
                        'rgba(66, 133, 244, 0.8)',
                        'rgba(233, 30, 99, 0.8)',
                    ],
                    borderRadius: 6,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'rgb(100, 100, 100)'
                        },
                        grid: {
                            color: 'rgba(200,200,200,0.1)'
                        }
                    },
                    x: {
                        ticks: {
                            color: 'rgb(100, 100, 100)'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endsection
