
<style>
    .navv ul li a {
        color: white;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .navv ul li a:hover {
        color: #ffc107; /* yellow highlight on hover */
        transform: translateY(-2px);
    }

    .navv .dropdown-menu {
        background-color: #0d6efd; /* match bootstrap primary */
        transition: all 0.3s ease;
    }

    .navv .dropdown-item {
        color: white;
    }

    .navv .dropdown-item:hover {
        background-color: #0a58ca;
        color: #ffc107;
    }
</style>

<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse navv d-flex justify-content-center" id="navbarNav">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ '/admin' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('add-ngo') }}">
                        <i class="fas fa-user-plus"></i> Add Ngo
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cog"></i> Setting
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{-- route('add-session') --}}">
                            <i class="fas fa-list"></i> Add Session</a>
                        </li>
                        <li><a class="dropdown-item" href="{{-- route('') --}}">
                            <i class="fas fa-"></i>Session List</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
