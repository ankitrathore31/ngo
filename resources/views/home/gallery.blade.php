@extends('home.layout.MasterLayout')
@Section('content')
<style>
    .modal-share {
        text-align: center;
        margin-top: 20px;
    }

    .modal-share .btn {
        font-size: 24px;
        /* Adjust icon size */
        margin-right: 10px;
    }

    .modal-share .btn i {
        line-height: 36px;
        /* Center icons vertically */
    }
</style>
<!-- ==== banner section start ==== -->
<section class="common-banner" style="margin-top: 0px;">
    <div class="container">
        <div class="row">
            <div class="common-banner__content text-center">
                <h2 class="title-animation">Gallery</h2>
            </div>
        </div>
    </div>
    <div class="banner-bg">
        <img src="assets/images/banner/banner-bg.png" alt="Image">
    </div>
    <div class="shape">
        <img src="assets/images/shape.png" alt="Image">
    </div>
</section>

<div class="container mt-5">
    <div class="row row justify-content-between mt-2">
        <div class="col-3">
            <a href="gallery.php" class="btn btn-primary ">Photo</a>
        </div>
        <div class="col-3">
            <a href="meadia.php" class="btn btn-primary ">Video</a>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-4">
            <img src="assets/images/banner/banner-two-bg.png" alt="">
        </div>
        <div class="col-4">
            <img src="assets/images/banner/banner-two-bg.png" alt="">
        </div>
        <div class="col-4">
            <img src="assets/images/banner/banner-two-bg.png" alt="">
        </div>
    </div>
</div>
@endsection