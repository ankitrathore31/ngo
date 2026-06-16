@extends('home.layout.MasterLayout')

@section('title', $item->title . ' — Rare Material Auction')

{{-- @push('styles') --}}
<style>
    :root {
        --gold: #C9A84C;
        --deep: #1A1208;
        --cream: #F7F3EC;
        --rust: #8B3A1A;
        --jade: #2C5F4A;
        --silver: #94908A;
    }

    /* ── Breadcrumb ─────────────────────── */
    .auction-breadcrumb {
        background: var(--cream);
        padding: 12px 0;
        border-bottom: 1px solid rgba(0, 0, 0, .06);
    }

    /* ── Main layout ────────────────────── */
    .auction-detail-wrap {
        padding: 40px 0 60px;
    }

    /* ── Gallery column ─────────────────── */
    .gallery-col {
        position: sticky;
        top: 90px;
    }

    .main-image-wrap {
        border-radius: 14px;
        overflow: hidden;
        background: #F0EBE1;
        aspect-ratio: 1/1;
        position: relative;
        cursor: zoom-in;
    }

    .main-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .4s ease;
    }

    .main-image-wrap:hover img {
        transform: scale(1.06);
    }

    .view-3d-btn {
        position: absolute;
        bottom: 14px;
        right: 14px;
        background: rgba(0, 0, 0, .7);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, .2);
        border-radius: 8px;
        padding: 8px 16px;
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .5px;
        cursor: pointer;
        backdrop-filter: blur(6px);
        transition: background .2s;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .view-3d-btn:hover {
        background: rgba(201, 168, 76, .8);
        color: #fff;
    }

    .thumb-strip {
        display: flex;
        gap: 10px;
        margin-top: 12px;
        flex-wrap: wrap;
    }

    .thumb-item {
        width: 72px;
        height: 72px;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid transparent;
        cursor: pointer;
        transition: border-color .2s, transform .2s;
        flex-shrink: 0;
    }

    .thumb-item.active {
        border-color: var(--gold);
    }

    .thumb-item:hover {
        transform: scale(1.05);
    }

    .thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* 3D modal */
    .modal-3d .modal-content {
        background: #0d0d0d;
        border: 1px solid rgba(201, 168, 76, .3);
        border-radius: 16px;
    }

    .modal-3d .modal-header {
        border-color: rgba(255, 255, 255, .08);
        color: #fff;
    }

    .iframe-3d {
        width: 100%;
        height: 70vh;
        border: none;
        border-radius: 8px;
    }

    /* ── Info column ────────────────────── */
    .item-category-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 10px;
    }

    .item-main-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(1.6rem, 3.5vw, 2.4rem);
        font-weight: 700;
        color: var(--deep);
        line-height: 1.15;
        margin-bottom: 14px;
    }

    .rarity-pill {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 50px;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-right: 8px;
    }

    .rarity-unique {
        background: #FFF8DC;
        color: #B8860B;
        border: 1px solid #C9A84C;
    }

    .rarity-very_rare {
        background: #FEE8E6;
        color: #C0392B;
        border: 1px solid #C0392B;
    }

    .rarity-rare {
        background: #F5EFF8;
        color: #8E44AD;
        border: 1px solid #8E44AD;
    }

    .rarity-common {
        background: #E8F8F0;
        color: #27AE60;
        border: 1px solid #27AE60;
    }

    /* Specs grid */
    .specs-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin: 20px 0;
    }

    .spec-card {
        background: var(--cream);
        border-radius: 10px;
        padding: 12px 14px;
        border: 1px solid rgba(0, 0, 0, .05);
    }

    .spec-lbl {
        font-size: .65rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--silver);
        font-weight: 700;
        margin-bottom: 3px;
    }

    .spec-val {
        font-size: .88rem;
        font-weight: 600;
        color: var(--deep);
    }

    /* Live bid box */
    .live-bid-box {
        background: linear-gradient(135deg, var(--deep), #2D1F0A);
        border-radius: 14px;
        padding: 24px;
        color: #fff;
        margin: 22px 0;
        position: relative;
        overflow: hidden;
    }

    .live-bid-box::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(201, 168, 76, .15) 0%, transparent 70%);
    }

    .live-bid-label {
        font-size: .65rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: rgba(255, 255, 255, .5);
        font-weight: 700;
    }

    .live-bid-amount {
        font-family: 'Playfair Display', serif;
        font-size: 2.4rem;
        font-weight: 700;
        color: var(--gold);
        line-height: 1;
        margin: 4px 0 2px;
    }

    .bid-count-text {
        font-size: .78rem;
        color: rgba(255, 255, 255, .45);
    }

    /* Large countdown */
    .big-timer {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-top: 16px;
        flex-wrap: wrap;
    }

    .big-timer-unit {
        text-align: center;
        background: rgba(255, 255, 255, .08);
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 10px;
        padding: 10px 14px;
        min-width: 64px;
    }

    .big-timer-num {
        font-family: 'Courier New', monospace;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--gold);
        line-height: 1;
        display: block;
    }

    .big-timer-lbl {
        font-size: .58rem;
        text-transform: uppercase;
        color: rgba(255, 255, 255, .4);
        letter-spacing: 1.5px;
        margin-top: 2px;
        display: block;
    }

    .big-timer-sep {
        font-size: 1.8rem;
        color: rgba(201, 168, 76, .4);
        font-weight: 300;
        line-height: 1;
    }

    /* Bid leaderboard */
    .bid-board {
        background: #fff;
        border: 1px solid rgba(0, 0, 0, .07);
        border-radius: 12px;
        overflow: hidden;
    }

    .bid-board-header {
        background: var(--cream);
        padding: 12px 16px;
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--silver);
        border-bottom: 1px solid rgba(0, 0, 0, .06);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .bid-row {
        display: flex;
        align-items: center;
        padding: 10px 16px;
        border-bottom: 1px solid rgba(0, 0, 0, .04);
        transition: background .15s;
    }

    .bid-row:last-child {
        border-bottom: none;
    }

    .bid-row:hover {
        background: var(--cream);
    }

    .bid-rank {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .72rem;
        font-weight: 700;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .rank-1 {
        background: #FFF5CC;
        color: #B8860B;
        border: 1px solid var(--gold);
    }

    .rank-2 {
        background: #F0F0F0;
        color: #666;
        border: 1px solid #ccc;
    }

    .rank-3 {
        background: #FDEBD0;
        color: #E67E22;
        border: 1px solid #E67E22;
    }

    .rank-n {
        background: #F5F5F5;
        color: #999;
        border: 1px solid #e0e0e0;
    }

    .bid-bidder-name {
        flex: 1;
        font-size: .85rem;
        font-weight: 600;
        color: var(--deep);
    }

    .bid-amount-lbl {
        font-family: 'Playfair Display', serif;
        font-size: .98rem;
        font-weight: 700;
        color: var(--jade);
    }

    /* ── About section ──────────────────── */
    .about-material-section {
        background: var(--cream);
        border-radius: 14px;
        padding: 28px;
        margin-top: 28px;
    }

    .about-heading {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--deep);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .about-heading::before {
        content: '';
        width: 3px;
        height: 1.2rem;
        background: var(--gold);
        border-radius: 2px;
        display: inline-block;
    }

    /* ── Bid form ───────────────────────── */
    #bid-form {
        background: #fff;
        border: 2px solid rgba(201, 168, 76, .25);
        border-radius: 16px;
        padding: 28px;
        margin-top: 28px;
    }

    .bid-form-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--deep);
        margin-bottom: 6px;
    }

    .bid-form-subtitle {
        font-size: .82rem;
        color: var(--silver);
        margin-bottom: 24px;
    }

    .form-section-label {
        font-size: .65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: var(--gold);
        margin-bottom: 14px;
        margin-top: 20px;
        padding-bottom: 6px;
        border-bottom: 1px solid rgba(201, 168, 76, .2);
    }

    .custom-form-control {
        border: 1.5px solid rgba(0, 0, 0, .1);
        border-radius: 8px;
        padding: 10px 14px;
        font-size: .88rem;
        color: var(--deep);
        transition: border-color .2s, box-shadow .2s;
        width: 100%;
    }

    .custom-form-control:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(201, 168, 76, .12);
    }

    .custom-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        appearance: none;
    }

    .bid-amount-input-wrap {
        position: relative;
    }

    .bid-currency-prefix {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-weight: 700;
        color: var(--jade);
        font-size: 1.1rem;
        z-index: 2;
    }

    .bid-amount-field {
        padding-left: 34px !important;
        font-size: 1.3rem !important;
        font-weight: 700;
        color: var(--jade) !important;
        font-family: 'Playfair Display', serif;
    }

    .btn-place-bid {
        width: 100%;
        background: linear-gradient(135deg, var(--rust), #A0471F);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 14px;
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: .5px;
        cursor: pointer;
        transition: all .3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-place-bid:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(139, 58, 26, .4);
    }

    .btn-place-bid:active {
        transform: translateY(0);
    }

    /* Hammer animation on bid submit */
    @keyframes hammer-hit {
        0% {
            transform: rotate(-20deg);
        }

        40% {
            transform: rotate(15deg);
        }

        60% {
            transform: rotate(-8deg);
        }

        80% {
            transform: rotate(5deg);
        }

        100% {
            transform: rotate(0deg);
        }
    }

    .hammer-icon {
        display: inline-block;
    }

    .form-submitting .hammer-icon {
        animation: hammer-hit .5s ease;
    }

    .min-bid-hint {
        text-align: center;
        font-size: .78rem;
        color: var(--silver);
        margin-top: 8px;
    }

    .min-bid-hint strong {
        color: var(--jade);
    }
</style>
{{-- @endpush --}}

@section('content')


    <div class="auction-detail-wrap">
        <div class="container">
            <div class="row g-5">


                <div class="col-lg-5">
                    <div class="gallery-col">
                        <div class="main-image-wrap" id="mainImageWrap">
                            @php
                                $thumbnail = $item->images->where('image_type', 'thumbnail')->first();
                            @endphp

                            <img src="{{ $thumbnail ? asset($thumbnail->image_path) : asset('images/no-image.png') }}"
                                alt="{{ $item->title }}" id="mainImage" onclick="openLightbox(this.src)">
                            {{-- <img src="{{ asset($item->image_path) }}" id="mainImage" onclick="openLightbox(this.src)" alt="{{ $item->title }}" 
                                > --}}

                            @if ($item->model_3d_url)
                                <a href="#" class="view-3d-btn" data-bs-toggle="modal" data-bs-target="#modal3d">
                                    <i class="fas fa-cube"></i> View 3D Model
                                </a>
                            @endif
                        </div>

                        {{-- Thumbnails --}}
                        <div class="thumb-strip">
                            @foreach ($item->galleryImages as $i => $img)
                                <div class="thumb-item {{ $i === 0 ? 'active' : '' }}"
                                    onclick="switchMainImage(this, '{{ asset($img->image_path) }}')">
                                    <img src="{{ asset($img->image_path) }}" alt="View {{ $i + 1 }}">
                                </div>
                            @endforeach

                            @if ($item->model_3d_url)
                                <div class="thumb-item d-flex align-items-center justify-content-center bg-dark"
                                    style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#modal3d">
                                    <i class="fas fa-cube text-warning" style="font-size:1.4rem;"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="col-lg-7">

                    <div class="item-category-tag">
                        <i class="fas fa-gem"></i>
                        {{ $item->material_type ?? 'Rare Material' }}
                    </div>

                    <h1 class="item-main-title">{{ $item->title }}</h1>

                    <div class="mb-3">
                        <span class="rarity-pill rarity-{{ $item->rarity_level }}">
                            {{ ucfirst(str_replace('_', ' ', $item->rarity_level)) }}
                        </span>
                        @if ($item->certificate_number)
                            <span class="rarity-pill" style="background:#E8F4FF;color:#1565C0;border:1px solid #1565C0;">
                                <i class="fas fa-certificate me-1"></i>Cert #{{ $item->certificate_number }}
                            </span>
                        @endif
                    </div>

                    <p class="text-muted" style="font-size:.92rem;line-height:1.7;">{{ $item->description }}</p>

                    {{-- Specs grid --}}
                    <div class="specs-grid">
                        @if ($item->origin)
                            <div class="spec-card">
                                <div class="spec-lbl"><i class="fas fa-location-dot me-1"></i>Origin</div>
                                <div class="spec-val">{{ $item->origin }}</div>
                            </div>
                        @endif
                        @if ($item->age_period)
                            <div class="spec-card">
                                <div class="spec-lbl"><i class="fas fa-hourglass me-1"></i>Age / Period</div>
                                <div class="spec-val">{{ $item->age_period }}</div>
                            </div>
                        @endif
                        @if ($item->dimensions)
                            <div class="spec-card">
                                <div class="spec-lbl"><i class="fas fa-ruler-combined me-1"></i>Dimensions</div>
                                <div class="spec-val">{{ $item->dimensions }}</div>
                            </div>
                        @endif
                        @if ($item->weight)
                            <div class="spec-card">
                                <div class="spec-lbl"><i class="fas fa-weight-hanging me-1"></i>Weight</div>
                                <div class="spec-val">{{ $item->weight }}</div>
                            </div>
                        @endif
                        @if ($item->condition)
                            <div class="spec-card">
                                <div class="spec-lbl"><i class="fas fa-shield-check me-1"></i>Condition</div>
                                <div class="spec-val">{{ $item->condition }}</div>
                            </div>
                        @endif
                        @if ($item->provenance)
                            <div class="spec-card">
                                <div class="spec-lbl"><i class="fas fa-scroll me-1"></i>Provenance</div>
                                <div class="spec-val" style="font-size:.8rem;">{{ Str::limit($item->provenance, 60) }}
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Live bid box --}}
                    <div class="live-bid-box">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                            <div>
                                <div class="live-bid-label">Current Highest Bid</div>
                                <div class="live-bid-amount" id="detailBidVal">
                                    ₹{{ number_format($topBid ?? $item->starting_bid, 0) }}
                                </div>
                                <div class="bid-count-text">{{ $bidCount }} bids placed · Starting:
                                    ₹{{ number_format($item->starting_bid, 0) }}</div>
                            </div>
                            <div>
                                <div class="live-bid-label">Auction Closes In</div>
                                <div class="big-timer" data-ends="{{ $item->auction_end->toIso8601String() }}"
                                    id="bigTimer">
                                    <div class="big-timer-unit">
                                        <span class="big-timer-num" id="bt-d">--</span>
                                        <span class="big-timer-lbl">Days</span>
                                    </div>
                                    <span class="big-timer-sep">:</span>
                                    <div class="big-timer-unit">
                                        <span class="big-timer-num" id="bt-h">--</span>
                                        <span class="big-timer-lbl">Hours</span>
                                    </div>
                                    <span class="big-timer-sep">:</span>
                                    <div class="big-timer-unit">
                                        <span class="big-timer-num" id="bt-m">--</span>
                                        <span class="big-timer-lbl">Mins</span>
                                    </div>
                                    <span class="big-timer-sep">:</span>
                                    <div class="big-timer-unit">
                                        <span class="big-timer-num" id="bt-s">--</span>
                                        <span class="big-timer-lbl">Secs</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bid leaderboard --}}
                    @if ($item->bids->isNotEmpty())
                        <div class="bid-board mb-4">
                            <div class="bid-board-header">
                                <span>Live Bid Leaderboard</span>
                                <span class="text-success" style="font-size:.68rem;">
                                    <i class="fas fa-circle me-1" style="font-size:.45rem;"></i>Live
                                </span>
                            </div>
                            @foreach ($item->bids as $i => $bid)
                                <div class="bid-row">
                                    <div class="bid-rank rank-{{ $i < 3 ? $i + 1 : 'n' }}">{{ $i + 1 }}</div>
                                    <div class="bid-bidder-name">
                                        {{ Str::mask($bid->bidder_name, '*', 3) }}
                                    </div>
                                    <div class="bid-amount-lbl">₹{{ number_format($bid->bid_amount, 0) }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- About material --}}
                    @if ($item->about_material)
                        <div class="about-material-section">
                            <div class="about-heading">About This Material</div>
                            <div style="font-size:.9rem;color:#444;line-height:1.8;">
                                {!! nl2br(e($item->about_material)) !!}
                            </div>
                        </div>
                    @endif

                    {{-- ═══ BID FORM ═══ --}}
                    @if ($item->status === 'active' && !$item->auction_end->isPast())
                        <div id="bid-form">
                            <h3 class="bid-form-title"><i class="fas fa-gavel me-2 text-warning"></i>Place Your Bid</h3>
                            <p class="bid-form-subtitle">Your bid is a donation pledge. The highest bidder at close wins
                                the artifact.</p>

                            @if ($errors->any())
                                <div class="alert alert-danger py-2 small mb-3">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success py-2 small mb-3">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('auction.bid', $item->id) }}" method="POST" id="bidForm">
                                @csrf

                                {{-- Bid amount --}}
                                <div class="mb-4">
                                    <label class="fw-semibold mb-2" style="font-size:.85rem;">Your Bid Amount</label>
                                    <div class="bid-amount-input-wrap">
                                        <span class="bid-currency-prefix">₹</span>
                                        <input type="number" name="bid_amount"
                                            class="custom-form-control bid-amount-field" id="bidAmountInput"
                                            min="{{ ($topBid ?? $item->starting_bid) + 1 }}" step="1"
                                            placeholder="{{ ($topBid ?? $item->starting_bid) + 100 }}"
                                            value="{{ old('bid_amount') }}" required>
                                    </div>
                                    <p class="min-bid-hint">Minimum bid:
                                        <strong>₹{{ number_format(($topBid ?? $item->starting_bid) + 1, 0) }}</strong>
                                    </p>
                                </div>

                                {{-- Personal info --}}
                                <div class="form-section-label"><i class="fas fa-user me-1"></i>Personal Information</div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Full Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="bidder_name" class="custom-form-control"
                                            value="{{ old('bidder_name') }}" required placeholder="Your full name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Email Address <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="bidder_email" class="custom-form-control"
                                            value="{{ old('bidder_email') }}" required placeholder="your@email.com">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Phone Number <span
                                                class="text-danger">*</span></label>
                                        <input type="tel" name="bidder_phone" class="custom-form-control"
                                            value="{{ old('bidder_phone') }}" required placeholder="+91 XXXXX XXXXX">
                                    </div>
                                </div>

                                {{-- Address --}}
                                <div class="form-section-label"><i class="fas fa-location-dot me-1"></i>Address Details
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">House No / Street</label>
                                        <input type="text" name="bidder_house_no" class="custom-form-control"
                                            value="{{ old('bidder_house_no') }}" placeholder="H. No., Street name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Village / City</label>
                                        <input type="text" name="bidder_village" class="custom-form-control"
                                            value="{{ old('bidder_village') }}" placeholder="Village or city name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">Block / Tehsil</label>
                                        <input type="text" name="bidder_block" class="custom-form-control"
                                            value="{{ old('bidder_block') }}" placeholder="Block / Tehsil">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">District <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="bidder_district" class="custom-form-control"
                                            value="{{ old('bidder_district') }}" required placeholder="District">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-semibold">State <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="bidder_state" class="custom-form-control"
                                            value="{{ old('bidder_state') }}" required placeholder="State">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-semibold">Pincode</label>
                                        <input type="text" name="bidder_pincode" class="custom-form-control"
                                            value="{{ old('bidder_pincode') }}" placeholder="110001">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-semibold">Country <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="bidder_country" class="custom-form-control"
                                            value="{{ old('bidder_country', 'India') }}" required>
                                    </div>
                                </div>

                                {{-- ID info --}}
                                <div class="form-section-label"><i class="fas fa-id-card me-1"></i>Identity Verification
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label small fw-semibold">ID Type</label>
                                        <select name="bidder_id_type" class="custom-form-control custom-select">
                                            <option value="">Select ID Type</option>
                                            <option value="aadhar"
                                                {{ old('bidder_id_type') == 'aadhar' ? 'selected' : '' }}>
                                                Aadhar Card</option>
                                            <option value="pan" {{ old('bidder_id_type') == 'pan' ? 'selected' : '' }}>
                                                PAN
                                                Card</option>
                                            <option value="passport"
                                                {{ old('bidder_id_type') == 'passport' ? 'selected' : '' }}>Passport
                                            </option>
                                            <option value="voter_id"
                                                {{ old('bidder_id_type') == 'voter_id' ? 'selected' : '' }}>Voter ID
                                            </option>
                                            <option value="other"
                                                {{ old('bidder_id_type') == 'other' ? 'selected' : '' }}>
                                                Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label small fw-semibold">ID Number</label>
                                        <input type="text" name="bidder_id_number" class="custom-form-control"
                                            value="{{ old('bidder_id_number') }}" placeholder="Enter ID number">
                                    </div>
                                </div>

                                <button type="submit" class="btn-place-bid" id="bidSubmitBtn">
                                    <span class="hammer-icon"><i class="fas fa-gavel"></i></span>
                                    Place Bid · ₹<span
                                        id="bidPreview">{{ number_format(($topBid ?? $item->starting_bid) + 100, 0) }}</span>
                                </button>
                                <p class="min-bid-hint">
                                    <i class="fas fa-shield-halved me-1"></i>
                                    Your bid is reviewed by admin before it appears publicly. You'll be notified if you win.
                                </p>
                            </form>
                        </div>
                    @elseif($item->status === 'winner_selected' || $item->status === 'completed')
                        <div class="alert"
                            style="background:#E8F8F0;border:1px solid #27AE60;border-radius:12px;padding:20px;">
                            <h5 style="color:#27AE60;font-family:'Playfair Display',serif;"><i
                                    class="fas fa-trophy me-2"></i>Auction Closed — Winner Selected</h5>
                            <p class="mb-0 text-muted small">This auction has concluded. The winner has been notified and
                                is completing their donation.</p>
                        </div>
                    @else
                        <div class="alert"
                            style="background:#FFF8DC;border:1px solid #C9A84C;border-radius:12px;padding:20px;">
                            <h5 style="color:#B8860B;font-family:'Playfair Display',serif;"><i
                                    class="fas fa-clock me-2"></i>Auction Ended</h5>
                            <p class="mb-0 text-muted small">This auction has closed. Browse other active auctions.</p>
                        </div>
                    @endif

                </div>{{-- end right col --}}
            </div>{{-- end row --}}
        </div>{{-- end container --}}
    </div>

    {{-- ══════════════════════════════════
     3D MODEL MODAL
══════════════════════════════════ --}}
    @if ($item->model_3d_url)
        <div class="modal fade modal-3d" id="modal3d" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" style="font-family:'Playfair Display',serif;font-size:1rem;">
                            <i class="fas fa-cube me-2 text-warning"></i>3D View — {{ $item->title }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-2">
                        <iframe class="iframe-3d" src="{{ $item->model_3d_url }}" allow="fullscreen; vr"
                            title="3D Model Viewer">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Lightbox --}}
    <div id="lightbox"
        style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.9);z-index:9999;align-items:center;justify-content:center;cursor:zoom-out;"
        onclick="closeLightbox()">
        <img id="lightboxImg" style="max-width:90vw;max-height:90vh;border-radius:8px;object-fit:contain;" src=""
            alt="">
    </div>




    <script>
        // ── Gallery switcher ───────────────
        function switchMainImage(thumb, src) {
            document.getElementById('mainImage').src = src;
            document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
            thumb.classList.add('active');
        }

        // ── Lightbox ───────────────────────
        function openLightbox(src) {
            document.getElementById('lightboxImg').src = src;
            document.getElementById('lightbox').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').style.display = 'none';
            document.body.style.overflow = '';
        }

        // ── Big countdown ──────────────────
        const endDate = new Date("{{ $item->auction_end->toIso8601String() }}");

        function tickBig() {
            const diff = endDate - new Date();
            if (diff <= 0) {
                ['bt-d', 'bt-h', 'bt-m', 'bt-s'].forEach(id => document.getElementById(id).textContent = '00');
                return;
            }
            const d = Math.floor(diff / 86400000);
            const h = Math.floor((diff % 86400000) / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);
            document.getElementById('bt-d').textContent = String(d).padStart(2, '0');
            document.getElementById('bt-h').textContent = String(h).padStart(2, '0');
            document.getElementById('bt-m').textContent = String(m).padStart(2, '0');
            document.getElementById('bt-s').textContent = String(s).padStart(2, '0');
        }
        tickBig();
        setInterval(tickBig, 1000);

        // ── Bid preview ────────────────────
        const bidInput = document.getElementById('bidAmountInput');
        const bidPreview = document.getElementById('bidPreview');
        if (bidInput && bidPreview) {
            bidInput.addEventListener('input', () => {
                const v = parseInt(bidInput.value) || 0;
                bidPreview.textContent = v.toLocaleString('en-IN');
            });
        }

        // ── Form hammer animation ──────────
        const bidForm = document.getElementById('bidForm');
        const submitBtn = document.getElementById('bidSubmitBtn');
        if (bidForm) {
            bidForm.addEventListener('submit', function() {
                submitBtn.classList.add('form-submitting');
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Placing Bid...';
            });
        }

        // ── Live status polling ────────────
        setInterval(async () => {
            try {
                const r = await fetch('/auctions/api/live/{{ $item->id }}');
                const d = await r.json();
                const el = document.getElementById('detailBidVal');
                if (el) el.textContent = '₹' + Number(d.top_bid).toLocaleString('en-IN');
            } catch (e) {}
        }, 10000);
    </script>
@endsection
