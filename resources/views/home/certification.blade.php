@extends('home.layout.MasterLayout')
@Section('content')
<style>
    .certificate-card {
        border: 10px solid #d4af37;
        padding: 10px;
        background: #fff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        text-align: center;
    }

    .certificate-title {
        font-weight: bolder;
        margin-bottom: 10px;
    }

    /* Ensure images are equal width in a row */
    .certificate-images {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .certificate-images img {
        width: 48%;
        /* Keep space between images */
    }

    /* For small screens, make images full width */
    @media (max-width: 768px) {
        .certificate-images {
            flex-direction: column;
            align-items: center;
        }

        .certificate-images img {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row justify-content-center d-flex mb-5">
            <div class="col text-center">
                <h2 class="section-title mb-4 typed-text"><b>Sanstha Certification</b></h2>
            </div>
        </div>
        <div class="row g-3 d-flex justify-content-around">
            <div class="col-md-4 col-sm-6 col-12 mb-3">
                <div class="certificate-card">
                    <h5 class="certificate-title">Ngo Darpan Certificate</h5>
                    <img src="images/certtt.jpeg" class="img-fluid" alt="Certificate 1">
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12 mb-3">
                <div class="certificate-card">
                    <h5 class="certificate-title">ISO Sanstha Certificate</h5>
                    <img src="images/cert7.jpg" class="img-fluid" alt="Certificate 7">
                </div>
            </div>
        </div>
        <!-- Certificates Section -->
        <div class="row g-3 d-flex justify-content-around">

            <div class="col-md-4 col-sm-6 col-12 mb-3">
                <div class="certificate-card">
                    <h5 class="certificate-title">E-Anudhan Certificate</h5>
                    <img src="images/cert2.jpeg" class="img-fluid" alt="Certificate 2">
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12 mb-3">
                <div class="certificate-card">
                    <h5 class="certificate-title">Sanstha Pan Card</h5>
                    <img src="images/cert3.jpg" class="img-fluid" alt="Certificate 3">
                </div>
            </div>

        </div>
        <div class="row  g-3 d-flex justify-content-between">
            <!-- Certificate 12A -->
            <div class="col-lg-6 col-md-6 mb-3">
                <div class="certificate-card">
                    <h5 class="certificate-title text-center">12A Certificate</h5>
                    <!-- <div class="certificate-images"> -->
                    <img src="images/cert6a.jpg" class="img-fluid" alt="Certificate 6A">
                    <img src="images/cert6b.jpg" class="img-fluid" alt="Certificate 6B">
                    <!-- </div> -->
                </div>
            </div>
            <!-- Certificate 80G -->
            <div class="col-lg-6 col-md-6 mb-3">
                <div class="certificate-card">
                    <h5 class="certificate-title text-center">80G Certificate</h5>
                    <!-- <div class="certificate-images"> -->
                    <img src="images/cert8a.jpg" class="img-fluid" alt="Certificate 8A">
                    <img src="images/cert8b.jpg" class="img-fluid" alt="Certificate 8B">
                    <!-- </div> -->
                </div>
            </div>

        </div>
        <div class="row g-3 d-flex justify-content-around">

            <div class="col-md-6 col-sm-6 col-12 mb-3">
                <div class="certificate-card">
                    <h5 class="certificate-title">CSR-1 Certificate</h5>
                    <img src="images/cert4.jpg" class="img-fluid" alt="Certificate 4">
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-12 mb-3">
                <div class="certificate-card">
                    <h5 class="certificate-title">Sanstha Information Certificate</h5>
                    <img src="images/cert5.jpg" class="img-fluid" alt="Certificate 5">
                </div>
            </div>
        </div>
        
        <!-- Certificates Section -->
        <div class="row g-3 d-flex justify-content-around">

            <div class="col-md-6 col-sm-6 col-12 mb-3">
                <div class="certificate-card">
                    <h5 class="certificate-title">Sanstha Account Check</h5>
                    <img src="images/check.jpeg" class="img-fluid" alt="Certificate 2">
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-12 mb-3">
                <div class="certificate-card">
                    <h5 class="certificate-title">Sanstha PAyment Qr</h5>
                    <img src="images/qr.jpeg" class="img-fluid" alt="Certificate 3">
                </div>
            </div>

        </div>
    </div>
</div>

@endsection