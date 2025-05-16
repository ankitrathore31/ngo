<style>
    ul>li>a {
        color: white;
        font-weight: 500;
    }
</style>
<!-- Navbar -->
<nav class="navbar navbar-expand-md bg-primary m-3">

    <!-- Main Toast -->
    <div class="toast text-white" id="mainToast" data-delay="3000"
        style="position: fixed; bottom: 10px; right: 10px; z-index: 9999;">
        <!-- <div class="toast-header">
             <strong class="mr-auto" id="toastTitle"></strong>
             <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
          </div> -->
        <div class="toast-body" id="toastBody">
        </div>
    </div>



    <div class="container-fluid">
        <!-- Navbar Toggler for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse overflow-auto" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 flex-wrap">
                <li class="nav-item">
                    <a class="nav-link text-nowrap text-white" href="{{ route('welcome') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="{{ route('about') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="{{ route('service') }}">Services</a>
                </li>
                <!-- <li class="nav-item">
                   <a class="nav-link text-nowrap" href="helpme.php">Help Me</a>
                </li> -->
                <!-- <li class="nav-item">
                   <a class="nav-link text-nowrap" href="publicity.php">Publicity</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link text-nowrap" href=" {{ route('activity') }} ">Social Activity</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="{{ route('event' )}}">Event</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="{{ route('project') }}">Project</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="{{ route('news') }}">Newspaper Cuttings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="{{ route('certificate') }}">Certification</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="{{ route('reward') }}">Achievements & Rewards</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="{{ route('donate-page') }}">Donation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="{{ route('notice') }}">Notice Board</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="{{ route('contact') }}">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="{{ route('login') }}" >Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
