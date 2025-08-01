@extends('home.layout.MasterLayout')
@Section('content')
    <!--info section start-->
    <section>
        <div class="row justify-content-center d-flex">
            <div class="col text-center">
                <h2 class="section-title mb-4 typed-text"><b>About Us</b></h2>
            </div>
        </div>
        <div class="container-fluid py-5 shadow m-3">
            <div class="row m-4 ">
                <div class="col-sm-12 col-md-8 col-xxl-12 col-lg-12">
                    <h3 class="mb-3 text-center">WELCOME TO <span class="text-danger"><em><b>GYAN BHARTI SANSTHA</b></em></span></h3>
                    <p class="text-muted fst-italic fs-5">Empowering communities since <strong>30th June 2009</strong></p>
                    <p class="about_ngo"><em>Gyan Bharti Sanstha (NGO) </em>is working since 30.06.2009
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
                        <div class="col-4 mb-3">
                            <a href="{{route('donate-page')}}" class="btn btn-success"><i class="fas fa-donate"></i>Donate Now</a>
                        </div>
                        <div class="col-4 mb-3">
                            <a href="tel:9411484111" class="btn btn-primary"><i class="fas fa-phone-alt"></i>+91
                                9411484111</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container my-5">
            <h2 class="text-center text-primary mb-4">NGO के मुख्य कार्य</h2>

            <div class="row">
                <!-- Card 1 -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title text-primary">1</h5>
                            <p class="card-text">समाज में जो वंचित वर्ग है उनको प्रतिनिधित्व प्रदान करना</p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title text-success">2</h5>
                            <p class="card-text">समाज में समस्या को खोजना और उसका समाधान करना</p>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title text-danger">3</h5>
                            <p class="card-text">आपदा के समय राहत और पुनर्वास कार्य करना</p>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title text-warning">4</h5>
                            <p class="card-text">पात्रता के आधार पर कार्य करना</p>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5>5</h5>
                            <p class="card-text">शांति व्यवस्था में सहयोग प्रदान करना </p>
                        </div>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title text-secondary">6</h5>
                            <p class="card-text">समाज का कल्याण करना </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row d-flex justify-content-around">
                <div class="col-md-4">
                    <div class="card shadow-lg bg-white p-3 mb-5">
                        <div class="card-body text-center">
                            <img src="{{asset('images/founder.jpeg')}}" alt="img-fluid mb-3" width="200">
                            <div class="card-title">
                                MR. MANOJ KUMAR
                            </div>
                            <div class="card-text">
                                DIRECTOR & FOUNDER OF NGO
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-lg bg-white p-3 mb-5">
                        <div class="card-body text-center">
                            <img src="{{asset('images/officer.jpeg')}}" alt="img-fluid mb-3" width="200">
                            <div class="card-title">
                                MISS. D.D. RATHORE
                            </div>
                            <div class="card-text">
                                PROJECT MANAGER & PROGRAM OFFICER
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
