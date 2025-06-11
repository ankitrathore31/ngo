@extends('home.layout.MasterLayout')
@Section('content')
    <style>
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
            margin-top: 40px;
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

        .custom-img {
            width: 180px;
            /* Set a fixed width */
            height: 150px;
            /* Set a fixed height */
            /* object-fit: cover; Ensures the image fills the box properly */
        }

        .about_ngo,
        .list-group {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 400;
        }

        .carousel-item img {
            transition: transform 0.5s ease-in-out;
        }

        .carousel-item:hover img {
            transform: scale(1.1);
        }

        @media (max-width: 900px) {
            .hide-sm {
                display: none !important;
            }
        }

        /* Shared style */
        .category-card {
            color: #fff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s ease-in-out;
            cursor: pointer;
        }

        .category-card:hover {
            transform: scale(1.03);
        }

        /* Unique background colors */
        .Public-Program {
            background-color: #3498db;
        }

        .Government-Program {
            background-color: #1abc9c;
        }

        .Education {
            background-color: #e67e22;
        }

        .Environment {
            background-color: #2ecc71;
        }

        .Social-Awareness-Program {
            background-color: #9b59b6;
        }

        .Cultural-Program {
            background-color: #8e44ad;
        }

        .Sanitation-Program {
            background-color: #16a085;
        }

        .Health-Program {
            background-color: #e74c3c;
        }

        .Poor-Alleviation {
            background-color: #d35400;
        }

        .Women-Empowerment {
            background-color: #f39c12;
        }

        .Social-Problem {
            background-color: #c0392b;
        }

        .Peace-Talks-Program {
            background-color: #2980b9;
        }

        .Skill-Development {
            background-color: #27ae60;
        }

        .Religious-Program {
            background-color: #7f8c8d;
        }

        .Agriculture-Program {
            background-color: #2c3e50;
        }

        .Labour-Tools-Distribution {
            background-color: #f1c40f;
        }

        .Drinking-Water {
            background-color: #5dade2;
        }

        .Ration-Distribution {
            background-color: #af7ac5;
        }

        .Disaster-Management {
            background-color: #e84393;
        }

        .Economic-Help {
            background-color: #d98880;
        }

        .Cow-Service {
            background-color: #52be80;
        }

        .Animal-Food {
            background-color: #f1948a;
        }

        .Other-Activities {
            background-color: #7d3c98;
        }
    </style>

    <div class="row d-flex justify-content-between m-3">

        <div class="col-md-2 mb-3">
            <a href="{{ route('photo') }}" class="btn btn-warning text-white w-100">
                Gallery
            </a>
        </div>

        <div class="col-md-2 mb-3">
            <a href="{{ route('online-registration') }}" class="btn btn-success w-100">
                Online Registration
            </a>
        </div>

        <div class="col-md-2 mb-3">
            <a href="{{ route('applictionStatus') }}" class="btn btn-primary w-100">
                Application Status
            </a>
        </div>

        <div class="col-md-2 mb-3">
            <a href="{{ route('certiStatus') }}" class="btn w-100" style="background-color: skyblue; color: white;">
                Certificate Vetify
            </a>
        </div>


        <div class="col-md-2 mb-3">
            <a href="{{ route('certiStatus') }}" class="btn btn-info w-100">
                Certificate Download
            </a>
        </div>

        <div class="col-md-2 mb-3">
            <a href="{{ route('facilitiesStatus') }}" class="btn btn-primary w-100">
                Facilities Status
            </a>
        </div>


    </div>



    <!-- slider -->
    <div class="owl-carousel owl-theme slider">
        <div class="item ">
            <div class="background-image">
                <img src="public/images/ach1.jpeg"
                    alt="slider image">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="text-white"></h1>
                    <h2 class="text-white"></h2>
                    <p class="text-white"></p>
                </div>
            </div>
        </div>
    </div>
    <!-- end slider -->

    <!--info section start-->
    <section id="about" class="py-5 shadow m-3">
        <div class="container-fluid">
            <div class="row d-flex justify-content-between hide-sm">
                <div class="col-md-3 col-sm-6">
                    <img src="{{ asset('images/logo.png') }}" class="img-fluid custom-img" alt="">
                </div>
                <div class="col-md-3 col-sm-6">
                    <img src="{{ asset('images/meri-mati.png') }}" class="img-fluid custom-img" alt="">
                </div>
                <div class="col-md-3 col-sm-6">
                    <img src="{{ asset('images/beti-bachao.png') }}" class="img-fluid custom-img" alt="">
                </div>
                <div class="col-md-3 col-sm-6">
                    <img src="{{ asset('images/gandhi.png') }}" class="img-fluid custom-img" alt="">
                </div>
            </div>
            <div class="row m-4">
                <div class="col-sm-12 col-md-12 col-xxl-12 col-lg-12">
                    <h3 class="fw-bold mb-3 text-center">Welcome To <span class="text-primary">GYAN BHARTI SANSTHA
                        </span></h3>
                    <p class="text-muted fst-italic fs-5">Empowering communities since <strong>30th June 2009</strong></p>
                    <p class="about_ngo"><em>Gyan Bharti Sanstha </em>is working since 2009
                        Donations play a crucial role in supporting NGOs like Gyan Bharti Sanstha in their mission to serve
                        the community.
                        By contributing, donors enable the organization to provide essential services to those in need, such
                        as food aid,
                        healthcare, education, and livelihood support. Every donation, no matter how small, makes a
                        meaningful impact and
                        helps improve the lives of vulnerable individuals and families. Your support can help ensure that
                        Gyan Bharti Sanstha continues its valuable work and reaches more people in need
                    </p>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <i class="fa-solid fa-circle-check text-success me-2"></i> Dedicated to serving the
                                    poor, hungry, and helpless, ensuring necessary support and care.
                                </li>
                                <li class="list-group-item">
                                    <i class="fa-solid fa-circle-check text-success me-2"></i> Providing free education to
                                    underprivileged children for a brighter future.
                                </li>
                                <li class="list-group-item">
                                    <i class="fa-solid fa-circle-check text-success me-2"></i> Offering skill development
                                    programs like sewing training to empower women and unemployed individuals.
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <i class="fa-solid fa-circle-check text-success me-2"></i> Running free food
                                    distribution programs to ensure no one sleeps hungry.
                                </li>
                                <li class="list-group-item">
                                    <i class="fa-solid fa-circle-check text-success me-2"></i> Promoting women’s empowerment
                                    through beauty parlour training and professional skills.
                                </li>
                                <li class="list-group-item">
                                    <i class="fa-solid fa-circle-check text-success me-2"></i> Conducting awareness camps on
                                    health, hygiene, education, and self-sustainability.
                                </li>
                            </ul>
                        </div>
                    </div>
                    <p class="mt-2">
                        <marquee behavior="alternate" direction=""><strong>Note:</strong> Donate money, books, clothes,
                            and other
                            essential items to support our mission. We provide a certificate of appreciation for your
                            generous donations.
                        </marquee>
                    </p>
                    <div class="row d-flex justify-content-between mt-2">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('about') }}" class="btn btn-info"><i class="fas fa-info-circle"></i> More
                                Info</a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('donate-page') }}" class="btn btn-success"><i
                                    class="fas fa-donate"></i>Donate
                                Now</a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="tel:9411484111" class="btn btn-primary"><i class="fas fa-phone-alt"></i>+91
                                9411484111</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- =========== Donation Section Start ============ -->
    <section class="community mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-xl-7">
                    <div class="section__header">
                        <h2 class="text-dark">Join The Community To Give Donation</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="community-donation p-4 border rounded shadow-sm bg-light">
                        <div class="donation-form">
                            <form method="post" action="{{ route('donate') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="name" class="form-label">Donor Name:</label>
                                        <input type="text" class="form-control" name="donor_name" id="name">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="number" class="form-label">Donor Mobile Number:</label>
                                        <input type="number" class="form-control" name="donor_number" id=""
                                            maxlength="10">
                                    </div>
                                </div>
                                <div class=" row">
                                    <div class="col-md-8 mb-3">
                                        <label for="amount" class="form-label">Donation Amount:</label>
                                        <input type="number" class="form-control" name="donation_amount" id="amount"
                                            value="" required>
                                    </div>
                                </div>
                                <div class=" row">
                                    <div class="col-md-6 text-center">
                                        <!-- <input type="submit" class="btn btn-success mt-1" value="Pay Now" name="submit"> -->
                                        <button type="submit" name="submit" class="btn btn-success mt-2">Donate
                                            Now</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ======================== working Area show ========================================== -->
    <section>
        <div class="container-fluid mt-5">
            <div class="row justify-content-center d-flex">
                <div class="col-md-10 justify-content-center d-flex" style="gap: 15px;">
                    <h2 class="section-title mb-4"><b>SANSTHA WORKING AREA</b></h2>


                    <select class="form-control w-25" id="session">
                        <option value="">All Session</option>
                        @foreach ($data as $session)
                            <option value="{{ $session->session_date }}">{{ $session->session_date }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-2">
                    <a href="{{ route('show-area', 'Country') }}" style="text-decoration: none;">
                        <div class="card text-center shadow-sm bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Country</h5>
                                <p class="card-text fs-4 " data-type="Country">{{ $areaTypeCounts['Country'] ?? 0 }}</p>
                                <span>Click Here</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 mb-2">
                    <a href="{{ route('show-area', 'State') }}" style="text-decoration: none;">
                        <div class="card text-center shadow-sm bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">State</h5>
                                <p class="card-text fs-4 counter">{{ $areaTypeCounts['State'] ?? 0 }}</p>
                                <span>Click Here</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3 mb-2">
                    <a href="{{ route('show-area', 'District') }}" style="text-decoration: none;">
                        <div class="card text-center shadow-sm bg-warning text-white">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">District</h5>
                                <p class="card-text fs-4 counter">{{ $areaTypeCounts['District'] ?? 0 }}</p>
                                <span>Click Here</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3 mb-2">
                    <a href="{{ route('show-area', 'Tehsil') }}" style="text-decoration: none;">
                        <div class="card text-center shadow-sm bg-danger text-white">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Tehsil</h5>
                                <p class="card-text fs-4 counter">{{ $areaTypeCounts['Tehsil'] ?? 0 }}</p>
                                <span>Click Here</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-2 mb-2 mt-2">
                    <a href="{{ route('show-area', 'Block') }}" style="text-decoration: none;">
                        <div class="card text-center shadow-sm bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Block</h5>
                                <p class="card-text fs-4 counter">{{ $areaTypeCounts['Block'] ?? 0 }}</p>
                                <span>Click Here</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-2 mb-2 mt-2">
                    <a href="{{ route('show-area', 'City') }}" style="text-decoration: none;">
                        <div class="card text-center shadow-sm bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">City</h5>
                                <p class="card-text fs-4 counter">{{ $areaTypeCounts['City'] ?? 0 }}</p>
                                <span>Click Here</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-2 mb-2 mt-2">
                    <a href="{{ route('show-area', 'Town') }}" style="text-decoration: none;">
                        <div class="card text-center shadow-sm bg-secondary text-white">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Town</h5>
                                <p class="card-text fs-4 counter">{{ $areaTypeCounts['Town'] ?? 0 }}</p>
                                <span>Click Here</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-2 mb-2 mt-2">
                    <a href="{{ route('show-area', 'Village') }}" style="text-decoration: none;">
                        <div class="card text-center shadow-sm bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Village</h5>
                                <p class="card-text fs-4 counter">{{ $areaTypeCounts['Village'] ?? 0 }}</p>
                                <span>Click Here</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-2 mb-2 mt-2">
                    <a href="{{ route('show-area', 'Family') }}" style="text-decoration: none;">
                        <div class="card text-center shadow-sm bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">Family</h5>
                                <p class="card-text fs-4 counter">{{ $areaTypeCounts['Family'] ?? 0 }}</p>
                                <span>Click Here</span>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-2 mb-2 mt-2">
                    <div class="card text-center shadow-sm bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Beneficiary</h5>
                            <p class="card-text fs-4 counter" data-count="1115">1115</p>
                            <span>Click Here</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================ Sanstha Activitis box show ====================== -->
    <section>
        <div class="container-fluid mt-5">
            <!-- Heading -->
            <div class="row justify-content-center d-flex">
                <div class="col-md-10 justify-content-center d-flex" style="gap: 15px;">
                    <h2 class="section-title mb-4"><b>SANSTHA ACTIVITIES</b></h2>
                    <select class="form-control w-25" id="session">
                        <option value="">All Session</option>
                        @foreach ($data as $session)
                            <option value="{{ $session->session_date }}">{{ $session->session_date }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Activity Cards -->
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="ccategory-card bg-primary p-3 rounded text-white">
                        <div class="card-body">
                            <a href="{{route('activity')}}" class="text-white " style="text-decoration: none;">
                                <h5 class="card-title fw-bold">Total Activity</h5>
                                <p class="card-text fs-4 counter" data-count="10">{{ $allacti }}</p>
                            </a>
                        </div>
                    </div>
                </div>
                @php
                    use Illuminate\Support\Str;
                @endphp

                @foreach ($categoryCounts as $category => $count)
                    @php
                        $className = str_replace(' ', '-', $category);
                    @endphp
                    <div class="col-md-3 col-sm-4 mb-3">
                        <div class="category-card {{ $className }}">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $category }}</h5>
                                <p class="card-text fs-4 counter" data-count="{{ $count }}">{{ $count }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ==== service section start ==== -->
    <section>
        <div class="container mt-5">
            <div class="row justify-content-center d-flex">
                <div class="col text-center">
                    <h2 class="section-title mb-4 typed-text"><b>SERVICES</b></h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-lg p-3 mb-5 bg-white rounded facilities">
                        <div class="card-body text-center">
                            <img src="{{ asset('images/sewing.jpeg') }}" class="img-fluid mb-3" alt="Clean Classroom"
                                width="200">
                            <h5 class="card-title font-weight-bold text-primary">SEWING</h5>
                            <p class="card-text text-muted">
                                Sewing are taught here, which develops the students’
                                skills and enhances their intelligence..
                            </p>
                            <a href="service.php" class="btn btn-primary">More Info</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                        <div class="card-body text-center">
                            <img src="{{ asset('images/parlour.jpg') }}" alt="lunch area" class="img-fluid mb-3"
                                width="200">
                            <h5 class="card-title font-weight-bold text-primary">PARLOUR</h5>
                            <p class="card-text text-muted">
                                Our Beauty Parlour Training empowers women with professional beauty skills,
                                helping them achieve financial.
                            </p>
                            <a href="service.php" class="btn btn-primary">More Info</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-lg bg-white rounded p-3 mb-5">
                        <div class="card-body text-center ">
                            <img src="{{ asset('images/education.jpg') }}" alt="" class="img-fluid mb-3"
                                width="200">
                            <h5 class="card-title font-weight-bold text-primary">EDUCATION</h5>
                            <p class="card-text text-muted">
                                Our Sanstha provide free education to children for their
                                future success with professional teachers.
                            </p>
                            <a href="service.php" class="btn btn-primary">More Info</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==== Event section start ==== -->
    <section>
        <div class="container mt-5">
            <div class="row justify-content-center d-flex">
                <div class="col text-center">
                    <h2 class="section-title mb-4 typed-text"><b>LATEST EVENT</b></h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-lg p-3 mb-5 bg-white rounded facilities">
                        <div class="card-body text-center">
                            <img src="{{ asset('public/images/enviroment.jpeg') }}" class="img-fluid mb-3"
                                alt="Clean Classroom" width="200">
                            <h5 class="card-title font-weight-bold text-primary">Environment Meeting</h5>
                            <p class="card-text text-muted">
                                Our Sanstha organizes cleanliness meeting events to raise
                                encourage community participation in maintaining a clean environment
                            </p>
                            <a href="event.php" class="btn btn-primary">More Info</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                        <div class="card-body text-center">
                            <img src="{{ asset('public/images/blanket.jpeg') }}" alt="lunch area" class="img-fluid mb-3"
                                width="200">
                            <h5 class="card-title font-weight-bold text-primary">Blanket Distribution</h5>
                            <p class="card-text text-muted">
                                Our Sanstha organizes blanket distribution drives to provide warmth and comfort to those in
                                need,
                                ensuring protection against harsh weather conditions.
                            </p>
                            <a href="event.php" class="btn btn-primary">More Info</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-lg bg-white rounded p-3 mb-5">
                        <div class="card-body text-center ">
                            <img src="{{ asset('public/images/peace.jpeg') }}" alt="" class="img-fluid mb-3"
                                width="200">
                            <h5 class="card-title font-weight-bold text-primary">Peace Talkin Meeting</h5>
                            <p class="card-text text-muted">
                                Our sanstha organizes peace talk meetings to foster dialogue ,
                                and encourage conflict resolution for a more harmonious community
                            </p>
                            <a href="event.php" class="btn btn-primary">More Info</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==== Donate Section Start ==== -->
    <section class="mt-4 py-5">
        <div class="container">
            <div class="row justify-content-center d-flex">
                <div class="col text-center">
                    <h2 class="section-title mb-4 typed-text"><b>HELP & DONATE NOW</b></h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card shadow-lg bg-white rounded p-3 mb-5">
                        <div class="card-body text-center">
                            <img src="{{ asset('public/images/education2.jpg') }}" class="img-fluid mb-3" width="200">
                            <div class="card-body">
                                <h5 class="card-title">Help For Education</h5>
                                <p class="card-text">Providing Free Education by our NGO</p>
                                <a href="{{ route('help-education') }}" class="btn btn-outline-success">Donate Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-lg bg-white rounded p-3 mb-5">
                        <div class="card-body text-center">
                            <img src="{{ asset('images/FOOD.jpg') }}" class="img-fluid mb-3" width="200">
                            <div class="card-body">
                                <h5 class="card-title">Help For Food</h5>
                                <p class="card-text">Free Food feeding by our NGO</p>
                                <a href="{{ route('help-food') }}" class="btn btn-outline-success">Donate Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-lg bg-white rounded p-3 mb-5">
                        <div class="card-body text-center">
                            <img src="{{ asset('images/clothe.jpg') }}" class="img-fluid mb-3" width="200">
                            <h5 class="card-title">Help For Clothes</h5>
                            <p class="card-text">Donate for clothes, NGO distributes them</p>
                            <a href="{{ route('help-clothe') }}" class="btn btn-outline-success">Donate Now</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <section>
        <div class="container mt-5">
            <div class="text-center">
                <h2>Gallery</h2>
                <p class="text-muted">Explore our sanstha images.</p>
            </div>

            <div id="galleryCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/blanket.jpeg') }}" class="d-block w-100" alt="Image 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/peace-talk.jpeg') }}" class="d-block w-100" alt="Image 2">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/enviroment.jpeg') }}" class="d-block w-100" alt="Image 3">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon " aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>

            <div class="text-center mt-4">
                <a href="gallery.php" class="btn btn-primary">Show More</a>
            </div>
        </div>
    </section>
    <!-- ============ Contact Form Start =========== -->
    <section class="mb-5">
        <div class="container mt-5">
            <div class="text-center">
                <h2>Contact Us</h2>
                <p class="text-muted">We'd love to hear from you! Fill out the form below to get in touch.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <form action="mailto:gyanbhartingo600@gmail.com" method="post" enctype="text/plain">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.getElementById('session').addEventListener('change', function() {
            const session = this.value;

            fetch(`/filter-area-counts?session=${session}`)
                .then(res => res.json())
                .then(data => {
                    document.querySelectorAll('.count').forEach(el => {
                        const type = el.getAttribute('data-type');
                        el.textContent = data[type] || 0;
                    });
                });
        });
    </script>
    <script>
        document.querySelectorAll('.category-card').forEach(card => {
            const hue = Math.floor(Math.random() * 360);
            card.style.backgroundColor = `hsl(${hue}, 70%, 60%)`;
            card.style.color = '#fff';
        });
    </script>
@endsection
