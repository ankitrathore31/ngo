@extends('home.layout.MasterLayout')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">True Story List</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">True Story</li>
            </ol>
        </nav>
    </div>

    @if (session('success'))
        <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="container mt-4">
        <div class="row">
            @forelse ($stories as $story)
                <div class="col-md-6 col-lg-6 mb-4">
                    <div class="story-card card border-0 shadow-sm h-100 overflow-hidden">
                        {{-- Image Section --}}
                        @php
                            $images = $story->file_path ? json_decode($story->file_path, true) : [];
                        @endphp

                        @if (!empty($images))
                            <div id="carousel{{ $story->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($images as $index => $img)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset($img) }}" class="d-block w-100 story-image"
                                                alt="Story Image">
                                        </div>
                                    @endforeach
                                </div>
                                @if (count($images) > 1)
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carousel{{ $story->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carousel{{ $story->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                @endif
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="card-body p-4 d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark mb-2">{{ $story->name }}</h5>

                            @if ($story->date)
                                <p class="text-muted small mb-3">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ \Carbon\Carbon::parse($story->date)->format('F j, Y') }}
                                </p>
                            @endif

                            <p class="card-text text-secondary mb-3" style="flex-grow: 1;">
                                {{ $story->description }}
                            </p>

                            {{-- YouTube Video --}}
                            @if ($story->link)
                                <div class="ratio ratio-16x9 mb-3">
                                    <iframe src="{{ $story->link }}?autoplay=0&mute=0" title="YouTube video player"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen></iframe>
                                </div>
                            @endif
                        </div>

                        {{-- Footer --}}
                        <div
                            class="card-footer bg-white border-0 d-flex justify-content-between align-items-center px-4 pb-3">
                            <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3">True Story</a>
                            <span class="text-muted small"><i
                                    class="bi bi-clock me-1"></i>{{ $story->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center mt-5">
                    <h6 class="text-muted">No stories available yet.</h6>
                </div>
            @endforelse
        </div>
    </div>

    {{-- Styling --}}
    <style>
        .story-card {
            border-radius: 12px;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        .story-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.1);
        }

        .story-card .card-title {
            font-size: 1.15rem;
            color: #0d6efd;
        }

        .story-card .card-text {
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .story-image {
            height: 230px;
            width: 100%;
            object-fit: contain;
            /* SHOW FULL IMAGE */
            background-color: #f2f2f2;
            /* optional neutral background */
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }


        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
        }

        .btn-outline-primary {
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .btn-outline-primary:hover {
            background-color: #0d6efd;
            color: white;
        }
    </style>

@endsection
