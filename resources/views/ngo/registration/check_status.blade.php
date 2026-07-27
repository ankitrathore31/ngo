@extends('ngo.layout.master')
@section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Check Registration Status</h5>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-light px-3 py-2 mb-0 rounded">
                        <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Status</li>
                    </ol>
                </nav>
            </div>

            @if (session('error'))
                <div class="alert alert-danger fade-in-alert">{{ session('error') }}</div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow p-4 status-search-card">
                        <h5 class="text-center mb-4 fw-bold text-primary">Search Registration</h5>
                        <form action="{{ route('reg.status.check') }}" method="POST" id="statusForm">
                            @csrf
                            <label class="form-label">Identity No / Application No / Registration No</label>

                            <div class="input-wrap">
                                <input type="text" name="search_no" id="searchInput" class="form-control form-control-lg"
                                    value="{{ old('search_no') }}" placeholder="Enter any one number" required
                                    autocomplete="off">
                                <span class="input-highlight"></span>
                            </div>

                            @error('search_no')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <button type="submit" class="btn btn-primary w-100 mt-4 btn-lg pulse-btn" id="checkBtn">
                                <span class="btn-text"><i class="bi bi-search"></i> Check Status</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        .status-search-card {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp .5s ease forwards;
            border-radius: 14px;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animated underline that grows on focus */
        .input-wrap {
            position: relative;
        }

        .input-highlight {
            position: absolute;
            left: 0;
            bottom: 0;
            height: 2px;
            width: 0;
            background: #0d6efd;
            transition: width .3s ease;
        }

        #searchInput:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }

        #searchInput:focus~.input-highlight {
            width: 100%;
        }

        /* Bounce feedback while typing */
        .input-bounce {
            animation: bounceIn .25s ease;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(1);
            }

            40% {
                transform: scale(1.02);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Shake when invalid on submit */
        .shake {
            animation: shake .4s ease;
            border-color: #dc3545 !important;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-6px);
            }

            40%,
            80% {
                transform: translateX(6px);
            }
        }

        .pulse-btn:hover {
            animation: pulse .6s;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, .5);
            }

            100% {
                box-shadow: 0 0 0 12px rgba(13, 110, 253, 0);
            }
        }

        /* Loading state on button */
        .btn-loading .btn-text {
            visibility: hidden;
        }

        .btn-loading::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 18px;
            height: 18px;
            margin: -9px 0 0 -9px;
            border: 3px solid rgba(255, 255, 255, .4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }

        #checkBtn {
            position: relative;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .fade-in-alert {
            animation: fadeUp .4s ease forwards;
        }
    </style>

    <script>
        const input = document.getElementById('searchInput');
        const form = document.getElementById('statusForm');
        const btn = document.getElementById('checkBtn');

        input.addEventListener('input', function() {
            this.classList.remove('shake');
            this.classList.add('input-bounce');
            setTimeout(() => this.classList.remove('input-bounce'), 250);
        });

        form.addEventListener('submit', function(e) {
            if (!input.value.trim()) {
                e.preventDefault();
                input.classList.add('shake');
                setTimeout(() => input.classList.remove('shake'), 400);
                return;
            }
            btn.classList.add('btn-loading');
            btn.disabled = true;
        });
    </script>
@endsection
