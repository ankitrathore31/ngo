@extends('home.layout.MasterLayout')
@Section('content')
<div class="wrapper">
        <!-- Gallery Section -->
        <div class="mt-5">
            <h3 class="text-center">Acheivement & Reward</h3>
            <div class="row mt-2">
                <div class="col-md-4">
                    <img src="images/ach1.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">
                </div>
                <div class="col-md-4">
                    <img src="images/ach2.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">
                </div>
                <!-- <div class="col-md-4">
                    <img src="aassets/images/ach3.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">
                </div> -->
                <div class="col-md-4">
                    <img src="images/event1.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">
                 </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <img src="images/ach4.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">
                </div>
                <div class="col-md-4">
                    <img src="images/ach5.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">
                </div>
                <div class="col-md-4">
                    <img src="images/ach6.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Enlarged Image -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Acheivement</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" class="img-fluid" alt="Enlarged Award">
                </div>
            </div>
        </div>
    </div>

    <script>
        function showImage(src) {
            document.getElementById("modalImage").src = src;
        }
    </script>
</div>
@endsection
