<!-- Header Section -->
<header class="container-fluid border-bottom py-2" style="border-bottom: 3px solid #8000ff;">
    <div class="d-flex justify-content-between align-items-center flex-wrap">

        <!-- Left: Logo + Title + Address -->
        <div class="d-flex align-items-center flex-grow-1">
            <img src="images/logo.png" alt="Logo" width="60" height="60" class="me-2">
            <div>
                <h6 class="mb-0 fw-bold text-uppercase">GYAN BHARTI SANSTHA</h6>
                <small class="text-muted">Kainchu Tanda Amaria 262121 Pilibhit (Uttar Pradesh)</small>
            </div>
        </div>

        <!-- Center: Session Select -->
        <div class="text-center mx-auto me-3">
            <label for="sessionSelect" class="form-label mb-0 me-2 fw-semibold">Session Year</label>
            <select class="form-select form-select-sm d-inline-block w-auto" id="session">
                @php
                    $sessions = Session::get('all_academic_session');
                    $sessions = collect($sessions)->sortByDesc('session_date');
                @endphp
                @foreach ($sessions as $session)
                    <option value="{{ $session->session_date }}">{{ $session->session_date }}</option>
                @endforeach
            </select>
        </div>

        <!-- Right: User Dropdown -->
        <div class="dropdown text-end">
            <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" id="userDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <img src="images/logo.png" alt="User" width="40" height="40" class="rounded-circle me-2">
                <div class="text-start">
                    <div class="fw-bold text-dark">GYAN BHARTI SANSTHA</div>
                    <small class="text-primary">Admin</small>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Change Password</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="px-3">
                        @csrf
                        <a class="btn btn-outline-danger btn-sm w-100" href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
