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
@endsection
