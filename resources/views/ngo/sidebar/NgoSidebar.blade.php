<style>
    /* Keep navbar items in single row with horizontal scroll */
    .navbar-nav {
        white-space: nowrap;
    }

    /* Horizontal scrollbar styling */
    .navbar-nav::-webkit-scrollbar {
        height: 6px;
    }

    .navbar-nav::-webkit-scrollbar-thumb {
        background-color: rgba(255, 255, 255, 0.4);
        border-radius: 10px;
    }

    /* Dropdown menu scroll */
    .dropdown-menu {
        max-height: 70vh;
        overflow-y: auto;
        background-color: var(--bs-primary);
        /* bg-primary */
        border: none;
    }

    /* Dropdown item text */
    .dropdown-menu .dropdown-item {
        color: #ffffff;
        font-weight: 500;
    }

    /* Hover & focus state */
    .dropdown-menu .dropdown-item:hover,
    .dropdown-menu .dropdown-item:focus {
        background-color: rgba(255, 255, 255, 0.15);
        color: #ffffff;
    }

    /* Active dropdown item */
    .dropdown-menu .dropdown-item.active,
    .dropdown-menu .dropdown-item:active {
        background-color: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }

    /* Navbar link styling */
    .navbar-nav .nav-link {
        color: #ffffff;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
    }

    /* Navbar link hover */
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link:focus {
        color: #ffffff;
        background-color: rgba(255, 255, 255, 0.15);
        border-radius: 4px;
    }

    /* Dropdown toggle arrow color */
    .navbar-nav .dropdown-toggle::after {
        border-top-color: #ffffff;
    }

    /* Prevent Bootstrap default white hover */
    .dropdown-item:hover {
        background-image: none;
    }
</style>

@php
    $user = auth()->user();
    $isStaff = $user && $user->user_type === 'staff';
@endphp

<nav class="navbar navbar-expand-md bg-primary" style="margin: 0; padding: 0;">
    <div class="container-fluid">
        <!-- Toggle for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar content -->
        <div class="collapse navbar-collapse navbar-scroll" id="mainNavbar">
            <ul class="navbar-nav flex-row flex-nowrap w-100">

                <li class="nav-item">
                    <a href="{{ route('ngo') }}" class="nav-link text-white"><i class="fas fa-tachometer-alt"></i>
                        DASHBOARD</a>
                </li>

                <!-- Investgation -->
                @if (!$isStaff || ($user->hasPermission('investigation') || $user->hasPermission('investigation')))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-tasks"></i> INVESTIGATION REPORT
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('addactivity') --}}">Total Registration</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Member List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('activitylist') --}}">Total benefries List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Demand List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Distribute Benefries
                                        List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Staff List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Organization</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total True Story List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Social Activty</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Project</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Event List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Donation</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Contact</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Work List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Gallery Backup</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Socail Problem List</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Complain</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Tarining Benefries</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Course List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Working Area</a></li>
                            @endif

                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Balance List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Invest</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Expend</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Stock List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('investigation'))
                                <li><a class="dropdown-item" href="{{-- route('true.story') --}}">Total Website Traffic</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                <!-- Inbox -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-tasks"></i> Staff Work
                    </a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="{{ route('survey.start') }}">Work Start</a></li>
                        <li><a class="dropdown-item" href="{{ route('work.list') }}">Survey Recieved & Start</a></li>
                        <li><a class="dropdown-item" href="{{ route('work.list') }}">Survey Send Complete</a></li>
                        <li><a class="dropdown-item" href="{{ route('work.list') }}">Work Dashboard</a></li>
                        <li><a class="dropdown-item" href="{{ route('survey.list') }}">Work List</a></li>
                        <li><a class="dropdown-item" href="{{ route('Survey.CheckDocument') }}">Work List Check
                                Document</a></li>
                        {{-- <li><a class="dropdown-item" href="{{-- route('activitylist') }}">Pending Work List</a></li>
                        <li><a class="dropdown-item" href="{{-- route('activitylist') }}">Complete Work Send</a></li>
                        <li><a class="dropdown-item" href="{{-- route('activitylist') }}">Complete Work Send List</a> </li> --}}
                    </ul>
                </li>

                <!-- ACTIVITY -->
                @if (!$isStaff || ($user->hasPermission('add-activity') || $user->hasPermission('activity-list')))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-tasks"></i> ACTIVITY
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('add-activity'))
                                <li><a class="dropdown-item" href="{{ route('addactivity') }}">Add Activity</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('activity-list'))
                                <li><a class="dropdown-item" href="{{ route('activitylist') }}">Activity List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('setting'))
                                <li><a class="dropdown-item" href="{{ route('true.story') }}">Add True Story</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Project -->
                @if (
                    !$isStaff ||
                        $user->hasPermission('add-project') ||
                        $user->hasPermission('project-list') ||
                        $user->hasPermission('report-list'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-tasks"></i> PROJECT
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('add-project'))
                                <li><a class="dropdown-item" href="{{ route('add.project') }}">Add Project</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('project-list'))
                                <li><a class="dropdown-item" href="{{ route('list.project') }}">Project List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('report-list'))
                                <li><a class="dropdown-item" href="{{ route('list.project.report') }}">Project
                                        Report</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- EVENT -->
                @if (!$isStaff || ($user->hasPermission('add-event') || $user->hasPermission('event-list')))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-tasks"></i> EVENT
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('add-event'))
                                <li><a class="dropdown-item" href="{{ route('add-event') }}">Add Event</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('event-list'))
                                <li><a class="dropdown-item" href="{{ route('event-list') }}">Event List</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- SETTING -->
                @if (
                    !$isStaff ||
                        $user->hasPermission('add-working-area') ||
                        $user->hasPermission('working-area-list') ||
                        $user->hasPermission('signature') ||
                        $user->hasPermission('course-list') ||
                        $user->hasPermission('add-course-centre'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-cogs"></i> SETTING
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('add-working-area'))
                                <li><a class="dropdown-item" href="{{ route('working-area') }}">Add Working Area</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('working-area-list'))
                                <li><a class="dropdown-item" href="{{ route('working-area-list') }}">Working Area
                                        List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('signature'))
                                <li><a class="dropdown-item" href="{{ route('signature') }}">Signature</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('category.list') }}">Work Category</a></li>
                            @if (!$isStaff || $user->hasPermission('add-course-centre'))
                                <li><a class="dropdown-item" href="{{ route('add.course') }}">Add Course For Training
                                        Centre</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('course-list'))
                                <li><a class="dropdown-item" href="{{ route('list.course') }}">Course List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('setting'))
                                <li><a class="dropdown-item" href="{{ route('form-downloads.index') }}">Add Forms</a>
                                </li>
                                <li><a class="dropdown-item" href="{{ route('true.story') }}">Add True Story</a></li>
                                <li><a class="dropdown-item" href="{{ route('email.list') }}">Emails</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Registration -->
                @if (
                    !$isStaff ||
                        $user->hasPermission('new-registration') ||
                        $user->hasPermission('pending-registration') ||
                        $user->hasPermission('approve-registration') ||
                        $user->hasPermission('recover-registration') ||
                        $user->hasPermission('reg-setting'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-clipboard-list"></i> REGISTRATION
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('new-registration'))
                                <li><a class="dropdown-item" href="{{ route('registration') }}">New Registration</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('pending-registration'))
                                <li><a class="dropdown-item" href="{{ route('pending-registration') }}">Pending
                                        Registration</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('approve-registration'))
                                <li><a class="dropdown-item" href="{{ route('approve-registration') }}">Approve
                                        Registration</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('recover-registration'))
                                <li><a class="dropdown-item" href="{{ route('recover') }}">Deleted Registration</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('reg-setting'))
                                <li><a class="dropdown-item" href="{{ route('reg-setting') }}">Online Registration
                                        Setting</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Beneficiaries -->
                @if (
                    !$isStaff ||
                        $user->hasPermission('beneficiarie-add') ||
                        $user->hasPermission('demand-facilities') ||
                        $user->hasPermission('approval-facilities') ||
                        $user->hasPermission('distributed-list') ||
                        $user->hasPermission('pending-distribute') ||
                        $user->hasPermission('all-beneficiarie-list'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                                class="fas fa-project-diagram"></i> BENEFICIARIES</a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('beneficiarie-add'))
                                <li><a class="dropdown-item" href="{{ route('beneficiarie-add-list') }}">Survey Add
                                        Beneficiary
                                        List</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('survey-received-list') }}">Survey Send</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('survey-received-list') }}">Survey Recived &
                                    Pending List</a>
                            </li>
                            @if (!$isStaff || $user->hasPermission('demand-facilities'))
                                <li><a class="dropdown-item" href="{{ route('beneficiarie-facilities') }}">Demand
                                        Beneficiary
                                        Facilities</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('approval-facilities'))
                                <li><a class="dropdown-item"
                                        href="{{ route('beneficiarie-facilities-list') }}">Apporval
                                        Demand
                                        Distribut Facilities List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('approval-facilities'))
                                <li><a class="dropdown-item" href="{{ route('distributed-list-for-approve') }}">
                                        Approval Distribute Facilities List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('distributed-facilities'))
                                <li><a class="dropdown-item" href="{{ route('distributed-list') }}">All Approve
                                        Distributed
                                        Facilities List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('pending-distribute'))
                                <li><a class="dropdown-item"
                                        href="{{ route('pending-distribute-list') }}">Pending/Reject
                                        Distribute
                                        Facilities List</a></li>
                            @endif

                            {{-- @if (!$isStaff || $user->hasPermission('all-beneficiarie-list'))
                                <li><a class="dropdown-item" href="{{ route('all-beneficiarie-list') }}">All
                                        Beneficiary
                                        List</a></li>
                            @endif --}}
                        </ul>
                    </li>
                @endif

                <!-- Group -->
                @if (
                    !$isStaff ||
                        $user->hasPermission('add-group') ||
                        $user->hasPermission('group-list') ||
                        $user->hasPermission('group-member-list'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-users"></i> GROUP
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('add-head-group'))
                                <li><a class="dropdown-item" href="{{ route('add.head.organization') }}">Add
                                        Organization</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('group-head-list'))
                                <li><a class="dropdown-item"
                                        href="{{ route('list.head.organization') }}">Organization
                                        List</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('add-group'))
                                <li><a class="dropdown-item" href="{{ route('add.organization') }}">Add Group</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('group-list'))
                                <li><a class="dropdown-item" href="{{ route('list.organization') }}">Group List</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('group-member-list'))
                                <li><a class="dropdown-item" href="{{ route('list.organization.member') }}">Group
                                        Member
                                        List</a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                <!-- Donation -->
                @if (
                    !$isStaff ||
                        $user->hasPermission('donation') ||
                        $user->hasPermission('donation-list') ||
                        $user->hasPermission('online-donor-list') ||
                        $user->hasPermission('donation-card-list') ||
                        $user->hasPermission('all-donor-list') ||
                        $user->hasPermission('donation-report'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown"><i
                                class="fas fa-donate"></i> DONATION</a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('donation'))
                                <li><a class="dropdown-item" href="{{ route('donation') }}">Deposite Donations</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('donation-list'))
                                <li><a class="dropdown-item" href="{{ route('donation-list') }}">Donations List</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('online-donor-list'))
                                <li><a class="dropdown-item" href="{{ route('online-donor-list') }}">Online Donations
                                        List</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('donation-card-list'))
                                <li><a class="dropdown-item" href="{{ route('donation-card-list') }}">Donation
                                        Card</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('all-donor-list'))
                                <li><a href="{{ route('all-donor-list') }}" class="dropdown-item">All Donation
                                        List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('donation-report'))
                                <li><a class="dropdown-item" href="{{ route('dontaion-report') }}">Donations
                                        Report</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

            </ul>
        </div>

    </div>
</nav>

<nav class="navbar navbar-expand-md bg-primary" style="margin: 0; padding: 0;">
    <div class="container-fluid no-border">
        <div class="collapse navbar-collapse navbar-scroll" id="mainNavbar">
            <ul class="navbar-nav flex-row flex-nowrap w-100">

                <!-- Staff -->
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-users"></i> STAFF
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('add-staff'))
                                <li><a class="dropdown-item" href="{{ route('add-staff') }}">Add Staff</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('staff-list'))
                                <li><a class="dropdown-item" href="{{ route('staff-list') }}">Staff List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('appointment-letter'))
                                <li><a class="dropdown-item" href="{{ route('staff.list.letter') }}">Staff
                                        Appointment Letter</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('resign-letter'))
                                <li><a class="dropdown-item" href="#">Staff Resign Letter</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('staff-salary'))
                                <li><a class="dropdown-item" href="{{ route('staff.salary') }}">Staff Salary</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('staff-idcard'))
                                <li><a class="dropdown-item" href="{{ route('staff-idcard') }}">Staff ID Card</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('staff-idcard'))
                                <li><a class="dropdown-item" href="{{-- route('staff-idcard') --}}">Staff Premotion</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('staff-idcard'))
                                <li><a class="dropdown-item" href="{{-- route('staff-idcard') --}}">Staff Demotion</a>
                                </li>
                            @endif
                            {{-- @if (!$isStaff || $user->hasPermission('staff-activity'))
                                <li><a class="dropdown-item" href="#">Staff Activity</a></li>
                            @endif --}}
                            @if (!$isStaff || $user->hasPermission('manage-salary'))
                                <li><a class="dropdown-item" href="{{ route('list.salary') }}">Manage Salary</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('position.list') }}">Manage Staff
                                    Position</a></li>
                            <li><a class="dropdown-item" href="{{ route('list.job') }}">Jobs</a></li>
                        </ul>
                    </li>
                @endif

                <!-- Membership -->
                @if (
                    !$isStaff ||
                        $user->hasPermission('member-list') ||
                        $user->hasPermission('add-member-position') ||
                        $user->hasPermission('member-position-list') ||
                        $user->hasPermission('member-activity') ||
                        $user->hasPermission('active-members') ||
                        $user->hasPermission('inactive-members'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user-friends"></i> MEMBERSHIP
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('member-list'))
                                <li><a class="dropdown-item" href="{{ route('member-list') }}">Member List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('add-member-position'))
                                <li><a class="dropdown-item" href="{{ route('add-member-list') }}">Add Member
                                        Position</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('member-position-list'))
                                <li><a class="dropdown-item" href="{{ route('member-position-list') }}">Member
                                        Position List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('member-activity'))
                                <li><a class="dropdown-item" href="{{ route('member-activitylist') }}">Member
                                        Activity</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('active-members'))
                                <li><a class="dropdown-item" href="#">Active Members</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('inactive-members'))
                                <li><a class="dropdown-item" href="#">Unactive Members</a></li>
                            @endif
                        </ul>
                    </li>
                @endif


                <!-- letter -->
                @if (!$isStaff || $user->hasPermission('generate-letter') || $user->hasPermission('letter-list'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-certificate"></i> LETTER
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('generate-letter'))
                                <li><a class="dropdown-item" href="{{ route('genrate-letter') }}">Generate Letter</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('letter-list'))
                                <li><a class="dropdown-item" href="{{ route('letter-list') }}">Letter List</a></li>
                            @endif
                        </ul>
                    </li>
                @endif


                <!-- Training -->
                @if (
                    !$isStaff ||
                        $user->hasPermission('add-center') ||
                        $user->hasPermission('center-list') ||
                        $user->hasPermission('training-demand-bene') ||
                        $user->hasPermission('approve-training-demand') ||
                        $user->hasPermission('generate-training-certi') ||
                        $user->hasPermission('training-certi-list') ||
                        $user->hasPermission('exam-time-table'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-chalkboard-teacher"></i> TRAINING
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('add-center'))
                                <li><a class="dropdown-item" href="{{ route('add-center') }}">Add Training Centre</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('center-list'))
                                <li><a class="dropdown-item" href="{{ route('center-list') }}">Training Centre
                                        List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('training-demand-bene'))
                                <li><a class="dropdown-item" href="{{ route('taining-demand-bene') }}">Training
                                        Demand Beneficiary List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('approve-training-demand'))
                                <li><a class="dropdown-item" href="{{ route('taining-center-bene') }}">Training
                                        Demand Center By Beneficiary
                                        List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('generate-training-certi'))
                                <li><a class="dropdown-item" href="{{ route('genrate-training-certi') }}">Generate
                                        Training Beneficiary Certificate</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('training-certi-list'))
                                <li><a class="dropdown-item" href="{{ route('training-certi-list') }}">Training
                                        Beneficiary Certificate</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('exam-time-table'))
                                <li><a class="dropdown-item" href="#">Exam Time Table</a></li>
                            @endif
                        </ul>
                    </li>
                @endif


                <!-- Download -->
                @if (
                    !$isStaff ||
                        $user->hasPermission('beneficiary-idcard') ||
                        $user->hasPermission('member-idcard') ||
                        $user->hasPermission('donor-idcard') ||
                        $user->hasPermission('beneficiary-admit') ||
                        $user->hasPermission('beneficiary-desk-slip') ||
                        $user->hasPermission('beneficiary-cc-noc') ||
                        $user->hasPermission('staff-idcard'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-download"></i> DOWNLOAD
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('beneficiary-idcard'))
                                <li><a class="dropdown-item" href="{{ route('beneficiary-idcard') }}">Beneficiary ID
                                        Card</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('member-idcard'))
                                <li><a class="dropdown-item" href="{{ route('member-idcard') }}">Member ID Card</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('donor-idcard'))
                                <li><a class="dropdown-item" href="{{ route('donor-idcard') }}">Donor ID Card</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('staff-idcard'))
                                <li><a class="dropdown-item" href="{{ route('staff-idcard') }}">Staff ID Card</a>
                                </li>
                            @endif
                            {{-- @if (!$isStaff || $user->hasPermission('beneficiary-admit'))
                                <li><a class="dropdown-item" href="#">Beneficiary Admit Card</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('beneficiary-desk-slip'))
                                <li><a class="dropdown-item" href="#">Beneficiary Desk Slip</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('beneficiary-cc-noc'))
                                <li><a class="dropdown-item" href="#">Beneficiary CC & NOC</a></li>
                            @endif --}}
                        </ul>
                    </li>
                @endif


                <!-- Complaint -->
                @if (
                    !$isStaff ||
                        $user->hasPermission('beneficiary-complaint') ||
                        $user->hasPermission('staff-complaint') ||
                        $user->hasPermission('service-complaint'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-exclamation-triangle"></i> COMPLAINT
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('beneficiary-complaint'))
                                <li><a class="dropdown-item" href="#">Beneficiary Complaint</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('staff-complaint'))
                                <li><a class="dropdown-item" href="#">Staff Complaint</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('service-complaint'))
                                <li><a class="dropdown-item" href="#">Service Complaint</a></li>
                            @endif
                        </ul>
                    </li>
                @endif


                <!-- Stock -->
                @if (!$isStaff || $user->hasPermission('add-stock') || $user->hasPermission('stock-list'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-boxes"></i> STOCK
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('add-stock'))
                                <li><a class="dropdown-item" href="#">Add Stock</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('stock-list'))
                                <li><a class="dropdown-item" href="#">Stock List</a></li>
                            @endif
                        </ul>
                    </li>
                @endif


                <!-- Cost -->
                @if (
                    !$isStaff ||
                        $user->hasPermission('add-bill') ||
                        $user->hasPermission('bill-list') ||
                        $user->hasPermission('generate-bill') ||
                        $user->hasPermission('gbs-bill-list') ||
                        $user->hasPermission('sanstha-bill-list'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-file-invoice-dollar"></i> COST
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('add-bill'))
                                <li><a class="dropdown-item" href="{{ route('add-bill') }}">Feed
                                        Bill/Voucher/Invoice</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('bill-list'))
                                <li><a class="dropdown-item" href="{{ route('bill-list') }}">Feed
                                        Bill/Voucher/Invoice List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('generate-bill'))
                                <li><a class="dropdown-item" href="{{ route('generate-sanstha-bill') }}">Generate
                                        Sanstha Bill/Voucher</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('generate-bill'))
                                <li><a class="dropdown-item" href="{{ route('generate-person-bill') }}">Generate
                                        Person Bill/Voucher</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('gbs-bill-list'))
                                <li><a class="dropdown-item" href="{{ route('person-bill-list') }}">GBS Person
                                        Bill/Voucher List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('sanstha-bill-list'))
                                <li><a class="dropdown-item" href="{{ route('gbs-bill-list') }}">GBS Sanstha
                                        Bill/Voucher List</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('add.vendor') }}">
                                    Add Vaindar/Shop/Farm</a></li>
                            <li><a class="dropdown-item" href="{{ route('vendor.list') }}">
                                    Vaindar/Shop/Farm List</a></li>
                        </ul>
                    </li>
                @endif


                <!-- Cash Book -->
                @if (
                    !$isStaff ||
                        $user->hasPermission('daily-report') ||
                        $user->hasPermission('date-wise-report') ||
                        $user->hasPermission('remaining-amount') ||
                        $user->hasPermission('daily-work') ||
                        $user->hasPermission('income-list') ||
                        $user->hasPermission('expenditure-list'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-book"></i> CASH BOOK
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('daily-work'))
                                <li><a class="dropdown-item" href="#">Daily Work Lsit</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('income-list'))
                                <li><a class="dropdown-item" href="{{ route('list.income') }}">Income List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('expenditure-list'))
                                <li><a class="dropdown-item" href="{{ route('expenditure.list') }}">Expenditure
                                        List</a></li>
                            @endif
                            {{-- @if (!$isStaff || $user->hasPermission('daily-report'))
                                <li><a class="dropdown-item" href="#">Daily Report (Graph)</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('date-wise-report'))
                                <li><a class="dropdown-item" href="#">Date-wise Report</a></li>
                            @endif --}}
                            {{-- @if (!$isStaff || $user->hasPermission('remaining-amount'))
                                <li><a class="dropdown-item" href="#">Remaining Amount</a></li>
                            @endif --}}
                            @if (!$isStaff || $user->hasPermission('year-wise-report'))
                                <li><a class="dropdown-item"
                                        href="{{ route('balance.report.view') }}">Year/Month-wise
                                        Report</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('year-wise-report'))
                                <li><a class="dropdown-item" href="{{-- route('balance.report.view') --}}">Work Category Laser
                                        Acoount</a></li>
                            @endif
                        </ul>
                    </li>
                @endif


                <!-- Gallery -->
                @if (!$isStaff || $user->hasPermission('add-photos') || $user->hasPermission('gallery-list'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-images"></i> GALLERY
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('add-photos'))
                                <li><a class="dropdown-item" href="{{ route('add-photos') }}">Add Photos</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('gallery-list'))
                                <li><a class="dropdown-item" href="{{ route('gallery-list') }}">Manage Gallery</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


                <!-- Social Problem -->
                @if (
                    !$isStaff ||
                        $user->hasPermission('discover-problems') ||
                        $user->hasPermission('problem-list') ||
                        $user->hasPermission('solutions') ||
                        $user->hasPermission('solutions-list'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-users-cog"></i> SOCIAL PROBLEM
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('discover-problems'))
                                <li><a class="dropdown-item" href="{{ route('problem.add') }}">Discover Social
                                        Problems</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('problem-list'))
                                <li><a class="dropdown-item" href="{{ route('problem.list') }}">Problem List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('solutions'))
                                <li><a class="dropdown-item" href="{{ route('list.for.solution') }}">Solutions</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('solutions-list'))
                                <li><a class="dropdown-item" href="{{ route('solution.list') }}">Solutions List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


                @if (!$isStaff || $user->hasPermission('add-workplan') || $user->hasPermission('workplan-list'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-tasks"></i> WORK PLAN
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('add-workplan'))
                                <li><a class="dropdown-item" href="{{ route('add-workplan') }}">Add Work Plan</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('workplan-list'))
                                <li><a class="dropdown-item" href="{{ route('workplan-list') }}">Work Plan List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>

<nav class="navbar navbar-expand-md bg-primary" style="margin: 0; padding: 0;">
    <div class="container-fluid">
        <div class="collapse navbar-collapse navbar-scroll" id="mainNavbar">
            <ul class="navbar-nav flex-row flex-nowrap w-100">

                <!-- Notice -->
                @if (!$isStaff || $user->hasPermission('add-notice') || $user->hasPermission('notice-list'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-bullhorn"></i> NOTICE
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('add-notice'))
                                <li><a class="dropdown-item" href="{{ route('add-notice') }}">Add Notice</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('notice-list'))
                                <li><a class="dropdown-item" href="{{ route('notice-list') }}">Notice List</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                <!-- Kyc -->
                @if (!$isStaff || $user->hasPermission('kyc') || $user->hasPermission('kyc'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-chalkboard-teacher"></i> KYC
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('kyc'))
                                <li><a class="dropdown-item" href="{{-- route('kyc') --}}">KYC Start</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('kyc'))
                                <li><a class="dropdown-item" href="{{-- route('notice-list') --}}">KYC Pending List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('kyc'))
                                <li><a class="dropdown-item" href="{{-- route('notice-list') --}}">KYC Approve List</a></li>
                            @endif
                        </ul>
                    </li>
                @endif


                <!-- Facility -->
                @if (!$isStaff || $user->hasPermission('kyc') || $user->hasPermission('kyc'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-chalkboard-teacher"></i> FACILITY
                        </a>
                        <ul class="dropdown-menu bg-primary">
                            @if (!$isStaff || $user->hasPermission('kyc'))
                                <li><a class="dropdown-item" href="{{ route('add.disease') }}">Add Disease</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('kyc'))
                                <li><a class="dropdown-item" href="{{ route('list.hospital') }}">Hospital List</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('kyc'))
                                <li><a class="dropdown-item" href="{{ route('generatelist.healthcard') }}">Health
                                        Card Generate</a></li>
                            @endif

                            @if (!$isStaff || $user->hasPermission('kyc'))
                                <li><a class="dropdown-item" href="{{ route('list.healthcard') }}">Health Card
                                        List</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('kyc'))
                                <li><a class="dropdown-item" href="{{ route('list.demandfacility') }}">Demand Health
                                        Facility</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('kyc'))
                                <li><a class="dropdown-item" href="{{ route('list.pendingfacility') }}">Health
                                        Facility Pending</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('kyc'))
                                <li><a class="dropdown-item" href="{{-- route('list.healthcard') --}}">Health Facility Bill
                                        Investigation</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('kyc'))
                                <li><a class="dropdown-item" href="{{-- route('list.healthcard') --}}">Health Facility Bill
                                        Verify</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('kyc'))
                                <li><a class="dropdown-item" href="{{-- route('list.healthcard') --}}">Health Facility Demand
                                        Approve</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('kyc'))
                                <li><a class="dropdown-item" href="{{-- route('list.healthcard') --}}">Final Approve Health
                                        Facility</a></li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('kyc'))
                                <li><a class="dropdown-item" href="{{-- route('list.healthcard') --}}">Health Facility Reject</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('kyc'))
                                <li><a class="dropdown-item" href="{{-- route('list.healthcard') --}}">Pending Health Facility</a>
                                </li>
                            @endif
                            @if (!$isStaff || $user->hasPermission('kyc'))
                                <li><a class="dropdown-item" href="{{-- route('list.healthcard') --}}">Non-Budget Health
                                        Facility</a></li>
                            @endif

                        </ul>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>
