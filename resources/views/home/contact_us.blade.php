@extends('home.layout.MasterLayout')
@Section('content')
<style>
   .bi{
      padding: 8px;
   }
</style>
<!-- Contact Section Start -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Contact Details -->
            <div class="col-12 col-xl-6">
                <div class="mb-4">
                    <h2 class="fw-bold">Contact Us</h2>
                </div>

                <div class="mb-3 d-flex align-items-center">
                    <i class="bi bi-geo-alt fs-4 text-primary me-3"></i>
                    <div>
                        <h6 class="mb-1">Location</h6>
                        <p class="mb-0">
                            <a href="https://maps.app.goo.gl/cuE122RHayRaQaHU9" target="_blank" class="text-decoration-none">
                                Head Office: Kainchu Tanda Amaria, Pilibhit 262121 UP Bharat
                            </a>
                        </p>
                    </div>
                </div>

                <div class="mb-3 d-flex align-items-center">
                    <i class="bi bi-telephone fs-4 text-primary me-3"></i>
                    <div>
                        <h6 class="mb-1">Phone</h6>
                        <p class="mb-0"><a href="tel:+919411484111" class="text-decoration-none">+91 9411484111</a></p>
                    </div>
                </div>

                <div class="mb-3 d-flex align-items-center">
                    <i class="bi bi-envelope fs-4 text-primary me-3"></i>
                    <div>
                        <h6 class="mb-1">Email</h6>
                        <p class="mb-0"><a href="mailto:gyanbhartingo600@gmail.com" class="text-decoration-none">gyanbhartingo600@gmail.com</a></p>
                    </div>
                </div>

                <div class="mb-3 d-flex align-items-center">
                    <i class="bi bi-envelope fs-4 text-primary me-3"></i>
                    <div>
                        <h6 class="mb-1">Website</h6>
                        <p class="mb-0"><a href="https://gyanbhartingo.org" class="text-decoration-none">https://gyanbhartingo.org</a></p>
                    </div>
                </div>

                <div class="mb-3 d-flex align-items-center">
                    <i class="bi bi-share fs-4 text-primary me-3"></i>
                    <div>
                        <h6 class="mb-1">Social</h6>
                        <div class="d-flex gap-3">
                            <a href="" target="_blank" class="text-primary fs-5">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="" target="_blank" class="text-primary fs-5">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="" target="_blank" class="text-primary fs-5">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Google Map -->
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3498.2790843508374!2d79.7314167!3d28.7410833!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjjCsDQ0JzI3LjkiTiA3OcKwNDMnNTMuMSJF!5e0!3m2!1sen!2sin!4v1738754673594!5m2!1sen!2sin"
                        width="480" height="310" style="border:0;" allowfullscreen="" loading="lazy">
                    </iframe>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-12 col-xl-6">
                <div class="mb-4">
                    <h4 class="fw-bold">Fill Up The Form</h4>
                    <p>Your email address will not be published. Required fields are marked *</p>
                </div>

                <form action="mailto:gyanbhartingo600@gmail.com" method="post" enctype="text/plain">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Name</label>
                        <input type="text" name="full-name" id="fullName" class="form-control" placeholder="Enter Name" required>
                    </div>

                    <div class="mb-3">
                        <label for="cEmail" class="form-label">Email</label>
                        <input type="email" name="c-email" id="cEmail" class="form-control" placeholder="Enter Email" required>
                    </div>

                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="text" name="phone-number" id="phoneNumber" class="form-control" placeholder="Phone Number" required>
                    </div>

                    <div class="mb-3">
                        <label for="contactMessage" class="form-label">Message</label>
                        <textarea name="contact-message" id="contactMessage" class="form-control" placeholder="Your Message..." rows="4" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Submit <i class="bi bi-arrow-right ms-2"></i></button>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

@endsection
