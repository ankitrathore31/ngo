<style>
    /* Navbar text styling */
    .navbar-nav .nav-link {
        color: white;
        font-size: 16px;
        font-weight: 500;
    }

    /* Navbar item hover effect */
    .navbar-nav .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.2); /* Subtle background on hover */
        border-radius: 5px;
    }

    /* Dropdown hover effect */
    .navbar-nav .nav-item.dropdown:hover > .dropdown-menu {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    .navbar-nav .dropdown-menu {
        display: none;
        background-color: #007bff; /* Make sure dropdown menu has the same background */
    }

    .dropdown-item {
        color: white;
        font-size: 14px;
        font-weight: 400;
    }

    /* Dropdown item hover effect */
    .dropdown-item:hover {
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 5px;
    }

    /* Dropdown animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-5px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Navbar branding (optional) */
    .navbar-brand {
        font-size: 22px;
        font-weight: bold;
        color: white !important;
    }

    /* Adjusting padding and margins */
    .navbar-toggler {
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .navbar-nav .nav-item {
        margin-left: 15px;
    }
</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-md bg-primary">
    <div class="container-fluid">
        <!-- Toggle for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar content -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav flex-wrap w-100 justify-content-center overflow-auto">
                <!-- Dashboard -->

                <li class="nav-item">
                    <a href="{{ route('ngo')}}" class="nav-link text-white"><i class="fas fa-tachometer-alt"></i> DASHBOARD</a>
                </li>


                <!-- Activity & Event -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-tasks"></i> ACTIVITY</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="{{route('addactivity') }}">Add Activity</a></li>
                        <li><a class="dropdown-item" href="{{ route('activitylist')}}">Activity List</a></li>
                    </ul>
                </li>

                  <!-- Activity & Event -->
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-tasks"></i> EVENT</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="">Add Event</a></li>
                        <li><a class="dropdown-item" href="">Event List</a></li>
                    </ul>
                </li>

                <!-- Setting -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-cogs"></i> SETTING</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="{{ route('working-area') }}">Add Working Area</a></li>
                        <li><a class="dropdown-item" href="{{ route('working-area-list') }}">Working Area List</a></li>
                        <li><a class="dropdown-item" href="#">Course List</a></li>
                        <li><a class="dropdown-item" href="#">Add Course For Centre</a></li>
                    </ul>
                </li>

                <!-- Registration -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-clipboard-list"></i> REGISTRATION</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="{{ route('registration')}}">New Registration</a></li>
                        <li><a class="dropdown-item" href="{{route('pending-registration') }}">Pending Registration</a></li>
                        <li><a class="dropdown-item" href="{{ route('approve-registration')}}">Approve Registration</a></li>
                        <li><a class="dropdown-item" href="{{ route('recover')}}">Deleted Registration</a></li>
                        <li><a class="dropdown-item" href="{{ route('reg-setting') }}">online Registration Setting</a></li>
                    </ul>
                </li>

                <!-- Beneficiaries -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-project-diagram"></i> BENEFICIARIES</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="{{ route('beneficiarie-add-list') }}">Survey Add Beneficiary List</a></li>
                        <li><a class="dropdown-item" href="{{-- route('beneficiarie-add-list') --}}">Survey Recived List</a></li>
                        <li><a class="dropdown-item" href="{{ route('beneficiarie-facilities')}}">Demand Beneficiary Facilities</a></li>
                        <li><a class="dropdown-item" href="{{ route('beneficiarie-facilities-list')}}">Apporval Demand Distribut Facilities List</a></li>
                        <li><a class="dropdown-item" href="{{ route('distributed-list')}}">Distributed Beneficiary Facilities List</a></li>
                        <li><a class="dropdown-item" href="{{ route('pending-distribute-list')}}">Pending Beneficiary Facilities List</a></li>
                        <li><a class="dropdown-item" href="{{route('all-beneficiarie-list')}}">All Beneficiary List</a></li>
                        {{-- <li><a class="dropdown-item" href="#">Target Beneficiaries</a></li> --}}
                    </ul>
                </li>

                <!-- Donation -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-donate"></i> DONATION</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="#">Deposite Donations</a></li>
                        <li><a class="dropdown-item" href="#">Donations List</a></li>
                        <li><a class="dropdown-item" href="#">Donations Report</a></li>
                        <li><a class="dropdown-item" href="#">Donation Card</a></li>
                    </ul>
                </li>

                <!-- Staff -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-users"></i> STAFF</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="#">Add Staff</a></li>
                        <li><a class="dropdown-item" href="#">Staff List</a></li>
                        <li><a class="dropdown-item" href="#">Staff Appointment Letter</a></li>
                        <li><a class="dropdown-item" href="#">Staff Resign Letter</a></li>
                        <li><a class="dropdown-item" href="#">Staff Salary</a></li>
                        <li><a class="dropdown-item" href="#">Staff ID Card</a></li>
                        <li><a class="dropdown-item" href="#">Staff Passbook</a></li>
                        <li><a class="dropdown-item" href="#">Staff Activity</a></li>
                    </ul>
                </li>

                <!-- Membership -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-user-friends"></i> MEMBERSHIP</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="#">Add Member</a></li>
                        <li><a class="dropdown-item" href="#">Member List</a></li>
                        <li><a class="dropdown-item" href="#">Member Activity</a></li>
                        <li><a class="dropdown-item" href="#">Active Members</a></li>
                        <li><a class="dropdown-item" href="#">Unactive Members</a></li>
                    </ul>
                </li>

                <!-- Promote -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-bullhorn"></i> PROMOTE</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="#">Promote Membership</a></li>
                        <li><a class="dropdown-item" href="#">Promote Beneficiary</a></li>
                        <li><a class="dropdown-item" href="#">Promote Staff</a></li>
                    </ul>
                </li>

                <!-- Certificate -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-certificate"></i> CERTIFICATE</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="#">Add Member Certificate</a></li>
                        <li><a class="dropdown-item" href="#">Member Certificate List</a></li>
                        <li><a class="dropdown-item" href="#">Add Beneficiary Certificate</a></li>
                        <li><a class="dropdown-item" href="#">Beneficiary Certificate List</a></li>
                    </ul>
                </li>

                <!-- Training -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-chalkboard-teacher"></i> TRAINING</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="#">Add Training Centre</a></li>
                        <li><a class="dropdown-item" href="#">Training Centre List</a></li>
                        <li><a class="dropdown-item" href="#">Exam Time Table</a></li>
                    </ul>
                </li>

                <!-- Download -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-download"></i> DOWNLOAD</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="#">Beneficiary ID Card</a></li>
                        <li><a class="dropdown-item" href="#">Beneficiary Admit Card</a></li>
                        <li><a class="dropdown-item" href="#">Beneficiary Desk Slip</a></li>
                        <li><a class="dropdown-item" href="#">Beneficiary CC & NOC</a></li>
                    </ul>
                </li>

                <!-- Attendance -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-user-check"></i> ATTENDANCE</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="#">Beneficiary Attendance</a></li>
                        <li><a class="dropdown-item" href="#">Staff Attendance</a></li>
                    </ul>
                </li>

                <!-- Complaint -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-exclamation-triangle"></i> COMPLAINT</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="#">Beneficiary Complaint</a></li>
                        <li><a class="dropdown-item" href="#">Staff Complaint</a></li>
                        <li><a class="dropdown-item" href="#">Service Complaint</a></li>
                    </ul>
                </li>

                <!-- Stock -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-boxes"></i> STOCK</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="#">Add Stock</a></li>
                        <li><a class="dropdown-item" href="#">Stock List</a></li>
                    </ul>
                </li>

                <!-- Cost -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-file-invoice-dollar"></i> COST</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="#">Add Bill Voucher</a></li>
                        <li><a class="dropdown-item" href="#">Bill Voucher List</a></li>
                        <li><a class="dropdown-item" href="#">Pending Bill Vouchers</a></li>
                        <li><a class="dropdown-item" href="#">Edit/Delete Bill Vouchers</a></li>
                    </ul>
                </li>

                <!-- Cash Book -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-book"></i> CASH BOOK</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="#">Daily Report (Graph)</a></li>
                        <li><a class="dropdown-item" href="#">Date-wise Report</a></li>
                        <li><a class="dropdown-item" href="#">Remaining Amount</a></li>
                        <li><a class="dropdown-item" href="#">Year-wise Report</a></li>
                    </ul>
                </li>

                <!-- Gallery -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-images"></i> GALLERY</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="{{ route('add-photos') }}">Add Photos</a></li>
                        {{-- <li><a class="dropdown-item" href="#">Add Newspaper</a></li> --}}
                        <li><a class="dropdown-item" href="{{ route('gallery-list') }}">Manage Gallery</a></li>
                    </ul>
                </li>

                <!-- Social Problem -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-users-cog"></i> SOCIAL PROBLEM</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="#">Discover Social Problems</a></li>
                        <li><a class="dropdown-item" href="#">Problem List</a></li>
                        <li><a class="dropdown-item" href="#">Solutions</a></li>
                        <li><a class="dropdown-item" href="#">Solutions List</a></li>
                    </ul>
                </li>

                <!-- Work Plan -->
                <li class="nav-item">
                    <a class="nav-link text-white" href="#"><i class="fas fa-tasks"></i> WORK PLAN</a>
                </li>

                <!-- Notice -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                            class="fas fa-bullhorn"></i> NOTICE</a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="#">Beneficiary Notice</a></li>
                        <li><a class="dropdown-item" href="#">Staff Notice</a></li>
                        <li><a class="dropdown-item" href="#">User Notice</a></li>
                        <li><a class="dropdown-item" href="#">Member Notice</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
