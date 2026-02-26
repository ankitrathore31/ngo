<style>
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

    /* Make dropdowns appear in front */
    /* Prevent menu items from being cut off */
    .navbar-nav {
        flex-wrap: wrap;
    }

    .nav-item {
        white-space: nowrap;
    }


    .navbar-nav .nav-link {
        padding: 0.5rem 0.8rem;
        font-size: 0.9rem;
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
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a href="{{ route('member') }}" class="nav-link text-white"><i class="fas fa-tachometer-alt"></i>
                        DASHBOARD</a>
                </li>

                <!-- Inbox -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-tasks"></i> Member
                    </a>
                    <ul class="dropdown-menu bg-primary">
                        <li><a class="dropdown-item" href="{{ route('add.submember') }}">Add Sub Member</a></li>
                        <li><a class="dropdown-item" href="{{ route('member.sub-member.list') }}">Sub Member List</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>