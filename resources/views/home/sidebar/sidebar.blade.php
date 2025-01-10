 <style>
     .navv ul li a {
            color: white;
        }
       

        .social-icons i {
            margin-right: 10px;
            font-size: 24px;
        }
 </style>
 
 <!-- Navbar -->
 <nav class="navbar navbar-expand-lg bg-primary ">
    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse   navv" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ 'welcome' }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Help me</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Publicity</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('activity') }}">Social Activity</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item dropdown bg-primary">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Project
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Running Project</a></li>
                        <li><a class="dropdown-item" href="#">Previous Project</a></li>
                        <li><a class="dropdown-item" href="#">Future Project</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Donation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Notice Board</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('register') }}">Signup</a>
                </li>
            </ul>
        </div>
    </div>
</nav>