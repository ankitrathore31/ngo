@extends('home.layout.MasterLayout')

@section('title', 'Rare Material Auction — Preserve Heritage, Empower Lives')

{{-- @push('styles') --}}
<style>
    :root {
        --auction-gold: #C9A84C;
        --auction-deep: #1A1208;
        --auction-cream: #F7F3EC;
        --auction-rust: #8B3A1A;
        --auction-jade: #2C5F4A;
        --auction-silver: #94908A;
        --rarity-unique: #FFD700;
        --rarity-vrare: #C0392B;
        --rarity-rare: #8E44AD;
        --rarity-common: #27AE60;
    }

    /* ── Hero ─────────────────────────────────── */
    .auction-hero {
        background: linear-gradient(135deg, #1A1208 0%, #2D1F0A 50%, #1A1208 100%);
        position: relative;
        overflow: hidden;
        padding: 100px 0 80px;
    }

    .auction-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background:
            radial-gradient(ellipse 600px 400px at 20% 50%, rgba(201, 168, 76, .12) 0%, transparent 70%),
            radial-gradient(ellipse 400px 300px at 80% 30%, rgba(139, 58, 26, .10) 0%, transparent 70%);
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(201, 168, 76, .12);
        border: 1px solid rgba(201, 168, 76, .3);
        color: var(--auction-gold);
        border-radius: 50px;
        padding: 6px 18px;
        font-size: 0.75rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .hero-badge .pulse-dot {
        width: 8px;
        height: 8px;
        background: #22C55E;
        border-radius: 50%;
        animation: pulse-live 1.5s infinite;
    }

    @keyframes pulse-live {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
        }

        50% {
            opacity: .5;
            transform: scale(1.4);
        }
    }

    .hero-headline {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(2.4rem, 5vw, 4rem);
        font-weight: 700;
        color: #fff;
        line-height: 1.15;
        letter-spacing: -.5px;
        margin-bottom: 18px;
    }

    .hero-headline .gold-text {
        color: var(--auction-gold);
    }

    .hero-subtitle {
        color: rgba(255, 255, 255, .65);
        font-size: 1.05rem;
        max-width: 550px;
        line-height: 1.7;
        margin-bottom: 36px;
    }

    .hero-stats {
        display: flex;
        gap: 36px;
        flex-wrap: wrap;
    }

    .hero-stat-val {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        color: var(--auction-gold);
        line-height: 1;
    }

    .hero-stat-lbl {
        font-size: 0.72rem;
        color: rgba(255, 255, 255, .5);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-top: 2px;
    }

    .hero-scroll-indicator {
        position: absolute;
        bottom: 28px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        color: rgba(255, 255, 255, .3);
        font-size: .7rem;
        letter-spacing: 1px;
        animation: float-bob 2s ease-in-out infinite;
    }

    @keyframes float-bob {

        0%,
        100% {
            transform: translateX(-50%) translateY(0);
        }

        50% {
            transform: translateX(-50%) translateY(6px);
        }
    }

    /* ── Section labels ───────────────────────── */
    .section-eyebrow {
        font-size: .7rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--auction-gold);
        font-weight: 700;
        margin-bottom: 10px;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.6rem, 3vw, 2.4rem);
        font-weight: 700;
        color: var(--auction-deep);
        line-height: 1.2;
    }

    /* ── Auction card ─────────────────────────── */
    .auction-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, .06);
        box-shadow: 0 2px 20px rgba(0, 0, 0, .06);
        transition: transform .3s ease, box-shadow .3s ease;
        display: flex;
        flex-direction: column;
    }

    .auction-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 48px rgba(0, 0, 0, .12);
    }

    /* Image gallery strip */
    .card-gallery {
        position: relative;
        overflow: hidden;
        height: 230px;
        background: #f0ece4;
    }

    .card-gallery .gallery-main {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s ease;
    }

    .auction-card:hover .gallery-main {
        transform: scale(1.04);
    }

    .card-gallery .gallery-thumbs {
        position: absolute;
        bottom: 10px;
        left: 10px;
        display: flex;
        gap: 6px;
    }

    .gallery-thumb-btn {
        width: 36px;
        height: 36px;
        border-radius: 6px;
        overflow: hidden;
        border: 2px solid rgba(255, 255, 255, .7);
        cursor: pointer;
        transition: border-color .2s;
    }

    .gallery-thumb-btn:hover {
        border-color: var(--auction-gold);
    }

    .gallery-thumb-btn img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-rarity-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        backdrop-filter: blur(8px);
    }

    .rarity-unique {
        background: rgba(255, 215, 0, .2);
        color: #B8860B;
        border: 1px solid rgba(255, 215, 0, .5);
    }

    .rarity-very_rare {
        background: rgba(192, 57, 43, .2);
        color: #C0392B;
        border: 1px solid rgba(192, 57, 43, .5);
    }

    .rarity-rare {
        background: rgba(142, 68, 173, .2);
        color: #8E44AD;
        border: 1px solid rgba(142, 68, 173, .5);
    }

    .rarity-common {
        background: rgba(39, 174, 96, .2);
        color: #27AE60;
        border: 1px solid rgba(39, 174, 96, .5);
    }

    .card-body-inner {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title-link {
        font-family: 'Playfair Display', serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--auction-deep);
        text-decoration: none;
        display: block;
        margin-bottom: 6px;
        line-height: 1.3;
        transition: color .2s;
    }

    .card-title-link:hover {
        color: var(--auction-rust);
    }

    .card-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 14px;
    }

    .meta-pill {
        font-size: .7rem;
        color: var(--auction-silver);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Bid info strip */
    .bid-strip {
        background: var(--auction-cream);
        border-radius: 10px;
        padding: 14px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    .bid-current-label {
        font-size: .65rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--auction-silver);
        font-weight: 600;
    }

    .bid-current-val {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--auction-jade);
        line-height: 1;
    }

    /* Countdown timer */
    .countdown-timer {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .timer-unit {
        text-align: center;
        background: var(--auction-deep);
        color: #fff;
        border-radius: 6px;
        padding: 4px 8px;
        min-width: 40px;
    }

    .timer-num {
        font-family: 'Courier New', monospace;
        font-size: 1rem;
        font-weight: 700;
        line-height: 1;
        color: var(--auction-gold);
    }

    .timer-lbl {
        font-size: .55rem;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .5);
        letter-spacing: 1px;
    }

    .timer-sep {
        color: var(--auction-gold);
        font-weight: 700;
        font-size: 1rem;
    }

    .card-footer-actions {
        padding: 14px 20px;
        border-top: 1px solid rgba(0, 0, 0, .06);
        display: flex;
        gap: 10px;
    }

    /* ── Bid button ───────────────────────────── */
    .btn-bid-now {
        flex: 1;
        background: linear-gradient(135deg, var(--auction-rust), #A0471F);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 16px;
        font-size: .85rem;
        font-weight: 600;
        letter-spacing: .5px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all .3s;
        cursor: pointer;
    }

    .btn-bid-now:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(139, 58, 26, .4);
    }

    .btn-view-details {
        padding: 10px 14px;
        border: 1.5px solid rgba(0, 0, 0, .12);
        border-radius: 8px;
        font-size: .82rem;
        color: var(--auction-deep);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all .2s;
    }

    .btn-view-details:hover {
        border-color: var(--auction-gold);
        color: var(--auction-rust);
    }

    /* ── Closed auctions ──────────────────────── */
    .section-closed {
        background: var(--auction-cream);
    }

    .closed-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, .06);
        opacity: .85;
        transition: opacity .2s;
    }

    .closed-card:hover {
        opacity: 1;
    }

    .closed-card .img-wrap {
        height: 160px;
        overflow: hidden;
        position: relative;
    }

    .closed-card .img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: grayscale(.3);
    }

    .closed-overlay {
        position: absolute;
        inset: 0;
        background: rgba(26, 18, 8, .5);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .closed-badge-text {
        background: rgba(0, 0, 0, .7);
        color: #fff;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 4px;
        border: 1px solid rgba(255, 255, 255, .2);
    }

    /* ── Empty state ──────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: var(--auction-cream);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2rem;
        color: var(--auction-gold);
    }
</style>
{{-- @endpush --}}

@section('content')


    {{-- <section class="auction-hero">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="hero-badge">
                        <span class="pulse-dot"></span>
                        Live Auctions Open Now
                    </div>
                    <h1 class="hero-headline">
                        Bid to <span class="gold-text">Preserve</span><br>
                        Rare Heritage<br>Materials
                    </h1>
                    <p class="hero-subtitle">
                        Every bid supports our mission. Donate through bidding — the highest bidder wins the artifact and
                        funds conservation of India's irreplaceable heritage.
                    </p>
                    <div class="hero-stats">
                        <div>
                            <div class="hero-stat-val">{{ $activeAuctions->count() }}</div>
                            <div class="hero-stat-lbl">Live Auctions</div>
                        </div>
                        <div>
                            <div class="hero-stat-val">{{ number_format(\App\Models\AuctionBid::count()) }}+</div>
                            <div class="hero-stat-lbl">Total Bids</div>
                        </div>
                        <div>
                            <div class="hero-stat-val">
                                ₹{{ number_format(\App\Models\AuctionBid::where('payment_status', 'paid')->sum('bid_amount') / 100000, 1) }}L+
                            </div>
                            <div class="hero-stat-lbl">Funds Raised</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-flex justify-content-end">
                    <div class="position-relative">
                        <div
                            style="width:320px;height:320px;border-radius:50%;background:radial-gradient(circle,rgba(201,168,76,.15) 0%,transparent 70%);border:1px solid rgba(201,168,76,.1);display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-gem" style="font-size:6rem;color:rgba(201,168,76,.3);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-scroll-indicator">
            <span>EXPLORE</span>
            <i class="fas fa-chevron-down"></i>
        </div>
    </section> --}}

    {{-- ══════════════════════════════════
     ACTIVE AUCTIONS
══════════════════════════════════ --}}
    <section class="py-5 bg-white">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <div class="section-eyebrow">Active Now</div>
                    <h2 class="section-title mb-0">Open Auctions</h2>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="hero-badge" style="margin-bottom:0; animation:none;">
                        <span class="pulse-dot"></span>
                        {{ $activeAuctions->count() }} Live
                    </span>
                </div>
            </div>

            @if ($activeAuctions->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-gavel"></i></div>
                    <h5 style="font-family:'Playfair Display',serif;">No Active Auctions Right Now</h5>
                    <p class="text-muted">Check back soon — new rare items are added regularly.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach ($activeAuctions as $item)
                        <div class="col-md-6 col-xl-4">
                            <div class="auction-card" data-item-id="{{ $item->id }}">

                                {{-- Gallery --}}
                                <div class="card-gallery">
                                    @php
                                        $thumbnail = $item->images->where('image_type', 'thumbnail')->first();
                                    @endphp

                                    <img src="{{ $thumbnail ? asset($thumbnail->image_path) : asset('images/no-image.png') }}"
                                        alt="{{ $item->title }}">

                                    <span class="card-rarity-badge rarity-{{ $item->rarity_level }}">
                                        {{ ucfirst(str_replace('_', ' ', $item->rarity_level)) }}
                                    </span>

                                    @if ($item->galleryImages->count() > 1)
                                        <div class="gallery-thumbs">
                                            @foreach ($item->galleryImages->take(4) as $img)
                                                <div class="gallery-thumb-btn"
                                                    onclick="switchImg('{{ $item->id }}','{{ asset($img->image_path) }}')">
                                                    <img src="{{ asset($img->image_path) }}" alt="">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                {{-- Body --}}
                                <div class="card-body-inner">
                                    <a href="{{ route('auction.show', $item->id) }}"
                                        class="card-title-link">{{ $item->title }}</a>

                                    <div class="card-meta">
                                        @if ($item->origin)
                                            <span class="meta-pill"><i class="fas fa-location-dot"></i>
                                                {{ $item->origin }}</span>
                                        @endif
                                        @if ($item->age_period)
                                            <span class="meta-pill"><i class="fas fa-hourglass"></i>
                                                {{ $item->age_period }}</span>
                                        @endif
                                        <span class="meta-pill"><i class="fas fa-gavel"></i> {{ $item->bids_count }}
                                            bids</span>
                                    </div>

                                    {{-- Bid strip --}}
                                    <div class="bid-strip">
                                        <div>
                                            <div class="bid-current-label">Current Bid</div>
                                            <div class="bid-current-val" id="bid-val-{{ $item->id }}">
                                                ₹{{ number_format($item->display_bid, 0) }}
                                            </div>
                                        </div>
                                        <div class="countdown-timer"
                                            data-ends="{{ $item->auction_end->toIso8601String() }}"
                                            data-id="{{ $item->id }}">
                                            <div class="timer-unit">
                                                <div class="timer-num" id="d-{{ $item->id }}">--</div>
                                                <div class="timer-lbl">Days</div>
                                            </div>
                                            <span class="timer-sep">:</span>
                                            <div class="timer-unit">
                                                <div class="timer-num" id="h-{{ $item->id }}">--</div>
                                                <div class="timer-lbl">Hrs</div>
                                            </div>
                                            <span class="timer-sep">:</span>
                                            <div class="timer-unit">
                                                <div class="timer-num" id="m-{{ $item->id }}">--</div>
                                                <div class="timer-lbl">Min</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Footer actions --}}
                                <div class="card-footer-actions">
                                    <a href="{{ route('auction.show', $item->id) }}#bid-form" class="btn-bid-now">
                                        <i class="fas fa-gavel"></i> Place Bid
                                    </a>
                                    <a href="{{ route('auction.show', $item->id) }}" class="btn-view-details">
                                        <i class="fas fa-eye"></i> Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>


    @if ($closedAuctions->isNotEmpty())
        <section class="section-closed py-5">
            <div class="container">
                <div class="section-eyebrow">Recently Closed</div>
                <h2 class="section-title mb-4">Past Auctions</h2>
                <div class="row g-3">
                    @foreach ($closedAuctions as $item)
                        <div class="col-sm-6 col-md-4 col-lg-2">
                            <a href="{{ route('auction.show', $item->id) }}" class="text-decoration-none">
                                <div class="closed-card">
                                    <div class="img-wrap">
                                        @php
                                            $thumbnail = $item->images->where('image_type', 'thumbnail')->first();
                                        @endphp

                                        <img src="{{ $thumbnail ? asset($thumbnail->image_path) : asset('images/no-image.png') }}"
                                            alt="{{ $item->title }}">
                                        <div class="closed-overlay">
                                            <span class="closed-badge-text">Closed</span>
                                        </div>
                                    </div>
                                    <div class="p-2">
                                        <p class="mb-0 small fw-semibold text-dark"
                                            style="font-size:.78rem;line-height:1.3;">{{ Str::limit($item->title, 30) }}
                                        </p>
                                        <p class="mb-0 text-muted" style="font-size:.7rem;">{{ $item->bids_count }} bids
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif


    <section class="py-5 bg-white">
        <div class="container">
            <div class="text-center mb-5">
                <div class="section-eyebrow">Process</div>
                <h2 class="section-title">How the Auction Works</h2>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach ([['icon' => 'fa-eye', 'title' => 'Browse Items', 'desc' => 'Explore rare materials with full details, 4–5 photo gallery, and 3D view.'], ['icon' => 'fa-gavel', 'title' => 'Place Your Bid', 'desc' => 'Enter your bid amount and contact info. Each bid is a donation pledge.'], ['icon' => 'fa-hourglass-half', 'title' => 'Admin Reviews', 'desc' => 'Our team verifies every bid before it appears on the leaderboard.'], ['icon' => 'fa-trophy', 'title' => 'Winner Notified', 'desc' => 'Highest bidder when auction closes wins. Admin confirms and notifies by email.'], ['icon' => 'fa-heart', 'title' => 'Donate & Receive', 'desc' => 'Complete your donation payment and receive the rare artifact with certificate.']] as $step)
                    <div class="col-sm-6 col-md-4 col-lg-2-custom text-center">
                        <div
                            style="width:60px;height:60px;background:linear-gradient(135deg,#F7F3EC,#EDE5D5);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;box-shadow:0 2px 12px rgba(201,168,76,.2);">
                            <i class="fas {{ $step['icon'] }}" style="color:var(--auction-gold);font-size:1.3rem;"></i>
                        </div>
                        <h6
                            style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:700;margin-bottom:6px;">
                            {{ $step['title'] }}</h6>
                        <p class="text-muted mb-0" style="font-size:.8rem;line-height:1.55;">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>




    <script>
        // ── Gallery switcher ───────────────────────────
        function switchImg(id, src) {
            document.getElementById('main-img-' + id).src = src;
        }

        // ── Countdown timers ───────────────────────────
        document.querySelectorAll('.countdown-timer').forEach(timer => {
            const ends = new Date(timer.dataset.ends);
            const id = timer.dataset.id;

            function tick() {
                const now = new Date();
                const diff = ends - now;
                if (diff <= 0) {
                    ['d', 'h', 'm'].forEach(k => document.getElementById(k + '-' + id).textContent = '00');
                    return;
                }
                const days = Math.floor(diff / 86400000);
                const hours = Math.floor((diff % 86400000) / 3600000);
                const mins = Math.floor((diff % 3600000) / 60000);
                document.getElementById('d-' + id).textContent = String(days).padStart(2, '0');
                document.getElementById('h-' + id).textContent = String(hours).padStart(2, '0');
                document.getElementById('m-' + id).textContent = String(mins).padStart(2, '0');
            }
            tick();
            setInterval(tick, 30000);
        });

        // ── Live bid polling ───────────────────────────
        document.querySelectorAll('[data-item-id]').forEach(card => {
            const id = card.dataset.itemId;
            setInterval(async () => {
                try {
                    const res = await fetch(`/auctions/api/live/${id}`);
                    const data = await res.json();
                    const el = document.getElementById('bid-val-' + id);
                    if (el) el.textContent = '₹' + Number(data.top_bid).toLocaleString('en-IN');
                } catch (e) {}
            }, 15000);
        });
    </script>
@endsection
