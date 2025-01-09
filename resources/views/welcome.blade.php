<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="images/logo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <title>Gyan Bharti Sanstha (NGO) </title>
    <style>
        .header {
            padding: 20px 0;
        }

        .social-icons i {
            margin-right: 10px;
            font-size: 24px;
        }

        .navv ul li a {
            color: white;
        }

        .owl-carousel {
            position: relative;
        }

        /* Custom styles for navigation arrows */
        .owl-nav {
            position: absolute;
            /* Position arrows absolutely */
            top: 55%;
            /* Center vertically */
            width: 100%;
            /* Full width to position arrows */
            display: flex;
            /* Flex container for positioning arrows */
            justify-content: space-between;
            /* Space out arrows */
            transform: translateY(-50%);
            /* Adjust for vertical centering */
        }

        .owl-nav .owl-prev,
        .owl-nav .owl-next {
            background-color: #fff;
            color: #ffffff;
            line-height: 100px;
            text-align: center;
            border-radius: 50%;
            font-size: 30px;
            cursor: pointer;
            z-index: 10;
            transition: none;
        }

        .slider {
            margin-top: 110px;
        }

        .owl-nav .owl-prev,
        .owl-nav .owl-next:hover {
            background-color: #fff;
            /* Arrow background color */

        }

        .owl-nav .owl-prev {
            left: 10px;
            /* Position left arrow */
        }

        .owl-nav .owl-next {
            right: 10px;
            /* Position right arrow */
        }

        .owl-nav .owl-next span,
        .owl-prev span {
            font-size: 50px;
            margin: 5px;
        }

        .background-image {
            background-size: cover;
            background-position: center;
            aspect-ratio: 16 / 6.5 !important;
            display: flex;
            align-items: center;
            position: relative;
            justify-content: center;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .background-image img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .content {
            text-align: center;
            color: white;
            /* Adjust text color if needed */
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <header class="container-fluid header">
        <div class="row align-items-center">
            <div class="col-md-2 text-center text-md-start">
                <a href="https://gyanbhartingo.org">
                    <img src="images/LOGO.png" alt="Logo" lin class="img-fluid">
                </a>
            </div>
            <div class="col-md-6 text-center">
                <h3 class="text-danger"><b>GYAN BHARTI SANSTHA (NGO)</b></h3>
                <h4>Together let's help each other</h4>
                <p class="text-primary"><u>HEAD OFFICE- KAINCHU TANDA AMARIA PILIPHIT UP</u></p>
            </div>
            <div class="col-md-4 text-center">
                <p class="text-primary"><u> THE INSTITUTION IN CONTINUOUS SERVICE SINCE 2009</u></p>
                <p class="fw-semibold">Call +919411484111</p>
                <div class="social-icons">
                    <a href="#" class="text-dark"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-dark"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-dark"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </header>
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
                        <a class="nav-link" aria-current="page" href="{{ 'welcome' }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Help me</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Publicity</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Social Activity</a>
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
    <!-- slider -->
    <div class="owl-carousel owl-theme slider">
        {{-- @foreach ($slider as $slideritem) --}}
        <div class="item ">
            <div class="background-image">
                <img src="images/FOOD.JPG" alt="slider image">
                <img src="images/CHILD1.JPG" alt="slider image">
                {{-- <div class="carousel-caption d-none d-md-block">
                        <h1 class="text-white">{{ $slideritem->title }}</h1>
                        <h2 class="text-white">{{ $slideritem->subtitle }}</h2>
                        <p class="text-white">{{ $slideritem->description }}</p>
                    </div> --}}
            </div>
        </div>
        {{-- @endforeach --}}
    </div>
    <!-- end slider -->

    <br>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2 class="mb-3">MR. MANOJ KUMAR</h2>
                <ul class="list-unstyled">
                    <li>DIRECTOR & FOUNDER OF NGO</li>
                    <li>HEAD OFFICE: KAINCHU TANDA AMARIA PILIBHIT UP 262121</li>
                    <li>GYAN BHARTI SANSHTHA : ONE OF THE BEST NGO IN ROHELKHAND (ALWAYS READY FOR SOCIAL SERVICE)</li>
                </ul>
            </div>
            <div class="col-md-4">
                <img src="images/photo.jpeg" class="img-fluid rounded" alt="Manoj Kumar">
            </div>
        </div>
    </div>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-8">
                <h2 class="mb-3">MISS DROPATI DEVI</h2>
                <ul class="list-unstyled">
                    <li>PROJECT MANAGER & PROGRAM OFFICER</li>
                    <li>HEAD OFFICE: KAINCHU TANDA AMARIA PILIBHIT UP 262121</li>
                    <li>GYAN BHARTI SANSHTHA : ONE OF THE BEST NGO IN ROHELKHAND (ALWAYS READY FOR SOCIAL SERVICE)</li>
                </ul>
            </div>
            <div class="col-md-4">
                <img src="images/pic.jpeg" class="img-fluid rounded" alt="Manoj Kumar">
            </div>
        </div>
    </div>
</body>

</html>
