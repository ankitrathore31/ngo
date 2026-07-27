@extends('home.layout.MasterLayout')
@Section('content')
    <div class="wrapper">
        <div class="container-fluid bg-white">
            <div class="row d-flex justify-content-end">
                <div class="col-auto  mb-3">
                    <nav aria-label="breadcrumb  bg-white">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('welcome') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Social Activity/Work</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="activity-hero mb-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-7 hero-fade">
                        <h1 class="hero-title">Social Activity / Work</h1>
                        <p class="hero-subtitle">A glimpse into the programs and initiatives making an impact.</p>
                    </div>
                    <div class="col-md-5">
                        <div class="stat-card hero-fade" style="animation-delay:.15s">
                            <div class="stat-icon"><i class="fa fa-chart-line"></i></div>
                            <div>
                                <div class="stat-number" id="totalCount" data-count="{{ $activity->count() }}">0</div>
                                <div class="stat-label">Total Activities</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">

            <!-- Filter Card -->
            <div class="filter-card mb-5 hero-fade" style="animation-delay:.25s">
                <form method="GET" action="{{ route('activity') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="filter-label">Session</label>
                        <select name="session_filter" id="session_filter" class="form-select modern-input">
                            <option value="">All Sessions</option>
                            @foreach (Session::get('all_academic_session') as $session)
                                <option value="{{ $session->session_date }}"
                                    {{ request('session_filter') == $session->session_date ? 'selected' : '' }}>
                                    {{ $session->session_date }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="filter-label">Category</label>
                        <select id="program_category"
                            class="form-select modern-input @error('program_category') is-invalid @enderror"
                            name="program_category">
                            <option value="" selected>All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="filter-label">Work Name</label>
                        <select name="program_name" id="program_name" class="form-select modern-input" required>
                            <option value="">Select Work Name</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="filter-label">Address</label>
                        <input type="text" name="address_filter" id="address"
                            class="form-control modern-input @error('address') is-invalid @enderror"
                            value="{{ old('address') }}" placeholder="Search by address">
                        @error('address')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-modern-primary">
                            <i class="fa fa-search me-1"></i> Search
                        </button>
                        <a href="{{ route('activity') }}" class="btn btn-modern-outline">
                            <i class="fa fa-rotate-left me-1"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <div class="row m-3">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered activity-table">
                        <thead class="text-white">
                            <tr class=" bg-success">
                                <th scope="col">Sr.No.</th>
                                <th scope="col">Date/Time</th>
                                <th scope="col">Program Image</th>
                                <th scope="col">Program Name</th>
                                <th scope="col">Program Category</th>
                                <th scope="col">Program Address</th>
                                <td>Session</td>
                                <th scope="col">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activity as $item)
                                <tr class="activity-row">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->program_date)->format('d-m-Y') }}
                                        <br> {{ $item->program_time }}
                                    </td>
                                    <td>
                                        <div class="img-frame">
                                            <img src="{{ asset('program_images/' . $item->program_image) }}" alt="image"
                                                loading="lazy" class="program-img">
                                        </div>
                                    </td>
                                    <td>{{ $item->program_name }}</td>
                                    <td>{{ $item->program_category }}</td>
                                    <td>{{ $item->program_address }}</td>
                                    <td>{{ $item->academic_session }}</td>
                                    <td>
                                        <a href="{{ route('viewreport', ['id' => $item->id]) }}"
                                            class="btn btn-sm bg-success me-2 view-btn">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Image frame: bigger, clear, cropped nicely (no squish) */
        .img-frame {
            width: 320px;
            height: 170px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .program-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            image-rendering: -webkit-optimize-contrast;
            transition: transform .4s ease, filter .4s ease;
            display: block;
        }

        .img-frame:hover .program-img {
            transform: scale(1.15);
            filter: brightness(1.05) contrast(1.05);
        }

        /* Row entrance animation */
        .activity-row {
            opacity: 0;
            transform: translateY(20px);
        }

        .activity-row.row-visible {
            animation: rowFadeUp .5s ease forwards;
        }

        @keyframes rowFadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Row hover highlight */
        .activity-table tbody tr {
            transition: background-color .25s ease, box-shadow .25s ease;
        }

        .activity-table tbody tr:hover {
            background-color: #f4fbf6;
            box-shadow: inset 0 0 0 9999px rgba(25, 135, 84, 0.03);
        }

        /* View button pop */
        .view-btn {
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .view-btn:hover {
            transform: scale(1.15);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Count number pulse when it updates */
        #totalCount.pulse {
            animation: countPulse .5s ease;
        }

        @keyframes countPulse {
            0% {
                transform: scale(1);
                color: inherit;
            }

            50% {
                transform: scale(1.3);
                color: #198754;
            }

            100% {
                transform: scale(1);
                color: inherit;
            }
        }

        #totalCount {
            display: inline-block;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --brand-green: #198754;
            --brand-green-dark: #146c43;
            --brand-soft: #eaf7f0;
        }

        .activity-page {
            background: #f7f9fb;
        }

        /* ---------- Hero ---------- */
        .activity-hero {
            background: linear-gradient(135deg, var(--brand-green) 0%, #0f5132 100%);
            padding: 50px 0 70px;
            color: #fff;
            border-radius: 0 0 30px 30px;
            position: relative;
            overflow: hidden;
        }

        .activity-hero::before {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            top: -100px;
            right: -80px;
        }

        .hero-title {
            font-size: 2.1rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .hero-subtitle {
            opacity: .9;
            font-size: 1.05rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            padding: 18px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-label {
            font-size: .85rem;
            opacity: .85;
        }

        .hero-fade {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp .6s ease forwards;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ---------- Filter Card ---------- */
        .filter-card {
            background: #fff;
            border-radius: 18px;
            padding: 24px 28px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            margin-top: -45px;
            position: relative;
            z-index: 2;
        }

        .filter-label {
            font-size: .8rem;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 4px;
            display: block;
        }

        .modern-input {
            border-radius: 10px;
            border: 1px solid #e2e6ea;
            padding: 10px 14px;
            transition: border-color .2s ease, box-shadow .2s ease;
        }

        .modern-input:focus {
            border-color: var(--brand-green);
            box-shadow: 0 0 0 3px rgba(25, 135, 84, .15);
        }

        .btn-modern-primary {
            background: var(--brand-green);
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: transform .15s ease, background .2s ease;
        }

        .btn-modern-primary:hover {
            background: var(--brand-green-dark);
            transform: translateY(-2px);
            color: #fff;
        }

        .btn-modern-outline {
            border: 1px solid #ced4da;
            color: #495057;
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: all .2s ease;
        }

        .btn-modern-outline:hover {
            background: #f1f3f5;
            transform: translateY(-2px);
            color: #212529;
        }

        /* ---------- Activity Cards ---------- */
        .activity-card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
            transition: transform .35s ease, box-shadow .35s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .activity-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 34px rgba(0, 0, 0, 0.12);
        }

        .activity-img-wrap {
            position: relative;
            width: 100%;
            height: 190px;
            overflow: hidden;
        }

        .activity-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform .5s ease;
        }

        .activity-card:hover .activity-img {
            transform: scale(1.1);
        }

        .badge-category {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(25, 135, 84, 0.92);
            color: #fff;
            font-size: .72rem;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
            backdrop-filter: blur(4px);
        }

        .activity-body {
            padding: 18px 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }

        .activity-title {
            font-weight: 700;
            font-size: 1.05rem;
            color: #212529;
            margin-bottom: 4px;
        }

        .activity-meta {
            font-size: .85rem;
            color: #6c757d;
            display: flex;
            gap: 16px;
        }

        .activity-meta i {
            color: var(--brand-green);
            margin-right: 4px;
        }

        .activity-footer {
            margin-top: auto;
            padding-top: 12px;
            border-top: 1px solid #f1f3f5;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .session-pill {
            background: var(--brand-soft);
            color: var(--brand-green-dark);
            font-size: .75rem;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
        }

        .btn-view {
            font-size: .85rem;
            font-weight: 600;
            color: var(--brand-green);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: gap .2s ease, color .2s ease;
        }

        .btn-view:hover {
            gap: 6px;
            color: var(--brand-green-dark);
        }

        /* ---------- Scroll Reveal ---------- */
        .reveal {
            opacity: 0;
            transform: translateY(30px) scale(.97);
            transition: opacity .6s ease, transform .6s ease;
        }

        .reveal.in-view {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Dynamic Work Name dropdown
            const allProjects = @json($allProjects);
            const categorySelect = document.getElementById('program_category');
            const workNameSelect = document.getElementById('program_name');

            categorySelect.addEventListener('change', function() {
                const selectedCategory = this.value;
                workNameSelect.innerHTML = '<option value="">Select Work Name</option>';

                allProjects
                    .filter(project => project.category === selectedCategory)
                    .forEach(project => {
                        const option = document.createElement('option');
                        option.value = project.name;
                        option.text = project.name;
                        workNameSelect.appendChild(option);
                    });
            });

            // Scroll reveal for cards
            const revealEls = document.querySelectorAll('.reveal');
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry, i) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => entry.target.classList.add('in-view'),
                            (i % 9) * 70);
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15
            });

            revealEls.forEach(el => revealObserver.observe(el));

            // Animated count-up for total activities
            const counterEl = document.getElementById('totalCount');
            if (counterEl) {
                const target = parseInt(counterEl.dataset.count, 10) || 0;
                let current = 0;
                const duration = 900;
                const stepTime = Math.max(Math.floor(duration / Math.max(target, 1)), 15);
                const timer = setInterval(() => {
                    current++;
                    counterEl.textContent = current;
                    if (current >= target) clearInterval(timer);
                }, stepTime);
            }
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const allProjects = @json($allProjects);
            const categorySelect = document.getElementById('program_category');
            const workNameSelect = document.getElementById('program_name');

            categorySelect.addEventListener('change', function() {
                const selectedCategory = this.value;
                workNameSelect.innerHTML = '<option value="">Select Work Name</option>';

                const filteredProjects = allProjects.filter(
                    project => project.category === selectedCategory
                );

                filteredProjects.forEach(project => {
                    const option = document.createElement('option');
                    option.value = project.name;
                    option.text = project.name;
                    workNameSelect.appendChild(option);
                });
            });

            // Staggered row entrance animation using IntersectionObserver
            const rows = document.querySelectorAll('.activity-row');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        const row = entry.target;
                        const delay = Array.from(rows).indexOf(row) % 15 * 60; // stagger
                        setTimeout(() => row.classList.add('row-visible'), delay);
                        observer.unobserve(row);
                    }
                });
            }, {
                threshold: 0.1
            });

            rows.forEach(row => observer.observe(row));

            // Pulse the total count once on load
            const totalCount = document.getElementById('totalCount');
            if (totalCount) {
                setTimeout(() => totalCount.classList.add('pulse'), 300);
            }
        });
    </script>
@endsection
