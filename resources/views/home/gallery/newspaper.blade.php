@extends('home.layout.MasterLayout')
@Section('content')
<div class="wrapper">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">News Paper</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">News Paper Gallery</li>
                    </ol>
                </nav>
            </div>
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="row">
                @foreach ($images as $image)
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <img src="{{ asset('gallery/' . $image->image) }}" class="card-img-top img-thumbnail"
                                style="height: 200px; object-fit: cover;" data-bs-toggle="modal"
                                data-bs-target="#imageModal" onclick="showImage('{{ asset('gallery/' . $image->image) }}')"
                                alt="Gallery Image">
                            <div class="card-body text-center">
                                <span class="m-1">{{$image->date}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Modal for Enlarged Image -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Gallery</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" class="img-fluid" alt="Enlarged Award">
                    </div>
                </div>
            </div>
        </div>




    </div>
    </div>
    <script>
        function showImage(src) {
            document.getElementById("modalImage").src = src;
        }
    </script>

@endsection