@extends('home.layout.MasterLayout')

@section('content')
<div class="wrapper">
    <div class="container-fluid mt-4">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-primary"><i class="bi bi-film"></i> True Stories</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded shadow-sm">
                    <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">True Stories</li>
                </ol>
            </nav>
        </div>

        {{-- Story Section 1 --}}
        <div class="row align-items-start mb-5">

            <div class="col-md-6 text-center">
               <b>IMAGES:</b>
            </div>

            {{-- Right Column: Video --}}
            <div class="col-md-6 mt-4 mt-md-0">
               <b>VIDEOS:</b>
            </div>
        </div>

    </div>
</div>

{{-- Custom Styles --}}
<style>
    .ratio iframe {
        border: none;
    }

    .fw-bold {
        letter-spacing: 0.3px;
    }

    .text-secondary {
        line-height: 1.7;
    }

    .img-fluid:hover {
        transform: scale(1.02);
        transition: 0.3s ease-in-out;
    }
</style>
@endsection
