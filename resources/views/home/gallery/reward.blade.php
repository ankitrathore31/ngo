@extends('home.layout.MasterLayout')
@Section('content')
    <div class="wrapper">
        <!-- Gallery Section -->
        <div class="mt-5">
            <h3 class="text-center mb-4">Acheivement & Reward</h3>
            <div class="row">
                @foreach ($images as $image)
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="{{ asset('gallery/' . $image->image) }}" class="card-img-top img-thumbnail"
                                style="height: 200px; object-fit: cover;" data-bs-toggle="modal" data-bs-target="#imageModal"
                                onclick="showImage('{{ asset('gallery/' . $image->image) }}')" alt="Image">
                            <div class="card-body text-center">
                                <span class="m-1">{{ $image->date }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <img src="images/ach1.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal"
                        data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">
                </div>
                <div class="col-md-4">
                    <img src="images/ach2.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal"
                        data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">
                </div>
                <div class="col-md-4">
                    <img src="images/event1.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal"
                        data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <img src="images/ach4.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal"
                        data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">
                </div>
                <div class="col-md-4">
                    <img src="images/ach5.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal"
                        data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">
                </div>
                <div class="col-md-4">
                    <img src="images/ach6.jpeg" class="img-fluid gallery-img" data-bs-toggle="modal"
                        data-bs-target="#imageModal" onclick="showImage(this.src)" alt="Award">
                </div>
            </div>
        </div>
    </div>

   <!-- Modal for Enlarged Image -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Acheive & Reward</h5>
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
