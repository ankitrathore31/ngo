@extends('ngo.layout.master')

@section('title', 'Bids — ' . $item->title)

<style>
    :root {
        --gold: #C9A84C;
        --deep: #1A1208;
        --cream: #F7F3EC;
        --rust: #8B3A1A;
        --jade: #2C5F4A;
    }

    .bids-hero {
        background: linear-gradient(135deg, var(--deep), #4f52e7);
        border-radius: 14px;
        padding: 24px 28px;
        color: #fff;
        margin-bottom: 24px;
        display: flex;
        gap: 20px;
        align-items: center;
        flex-wrap: wrap;
    }

    .bids-hero-img {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid rgba(201, 168, 76, .3);
        flex-shrink: 0;
    }

    .bids-hero-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.3rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 4px;
    }

    .bids-hero-meta {
        font-size: .78rem;
        color: rgba(255, 255, 255, .5);
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
    }

    .bids-hero-stats {
        margin-left: auto;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .bid-stat-mini {
        text-align: center;
    }

    .bid-stat-val {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gold);
        line-height: 1;
    }

    .bid-stat-lbl {
        font-size: .6rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: rgba(255, 255, 255, .4);
        margin-top: 2px;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 50px;
        font-size: .63rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .pill-pending {
        background: #FFF8E1;
        color: #B8860B;
        border: 1px solid var(--gold);
    }

    .pill-active {
        background: #E6F9F0;
        color: #1A7A4A;
        border: 1px solid #A5D6B7;
    }

    .pill-won {
        background: #E8F4FF;
        color: #1565C0;
        border: 1px solid #90CAF9;
    }

    .pill-lost {
        background: #F5F5F5;
        color: #999;
        border: 1px solid #ddd;
    }

    .pill-cancelled {
        background: #FEF2F0;
        color: #C0392B;
        border: 1px solid #E8A49C;
    }

    .pill-outbid {
        background: #FFF3E0;
        color: #E65100;
        border: 1px solid #FFCC80;
    }

    .bid-card {
        background: #fff;
        border: 1px solid rgba(0, 0, 0, .07);
        border-radius: 12px;
        margin-bottom: 14px;
        overflow: hidden;
        transition: box-shadow .2s;
    }

    .bid-card:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, .08);
    }

    .bid-card.is-winner {
        border: 2px solid var(--gold);
        box-shadow: 0 4px 24px rgba(201, 168, 76, .2);
    }

    .bid-card-header {
        background: var(--cream);
        padding: 12px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        border-bottom: 1px solid rgba(0, 0, 0, .05);
    }

    .bid-rank-badge {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .78rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .rank-1 {
        background: #FFF5CC;
        color: #B8860B;
        border: 2px solid var(--gold);
    }

    .rank-2 {
        background: #F0F0F0;
        color: #555;
        border: 2px solid #ccc;
    }

    .rank-3 {
        background: #FDEBD0;
        color: #E67E22;
        border: 2px solid #E67E22;
    }

    .rank-n {
        background: #F5F5F5;
        color: #aaa;
        border: 2px solid #e0e0e0;
    }

    .bid-amount-display {
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--jade);
    }

    .bid-card-body {
        padding: 16px 18px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 14px;
    }

    .info-block .info-lbl {
        font-size: .62rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #aaa;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .info-block .info-val {
        font-size: .85rem;
        font-weight: 600;
        color: var(--deep);
        line-height: 1.4;
    }

    .address-full {
        font-size: .8rem;
        color: #555;
        line-height: 1.6;
        background: var(--cream);
        border-radius: 8px;
        padding: 10px 14px;
        border: 1px solid rgba(0, 0, 0, .06);
    }

    .bid-card-actions {
        padding: 12px 18px;
        border-top: 1px solid rgba(0, 0, 0, .05);
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
        background: #fafafa;
    }

    .act-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 14px;
        border-radius: 7px;
        font-size: .75rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all .15s;
        text-decoration: none;
        letter-spacing: .3px;
    }

    .act-approve {
        background: #E6F9F0;
        color: #1A7A4A;
    }

    .act-approve:hover {
        background: #1A7A4A;
        color: #fff;
    }

    .act-winner {
        background: linear-gradient(135deg, #B8860B, var(--gold));
        color: #fff;
    }

    .act-winner:hover {
        box-shadow: 0 4px 16px rgba(201, 168, 76, .4);
        transform: translateY(-1px);
    }

    .act-reject {
        background: #FEF2F0;
        color: #C0392B;
    }

    .act-reject:hover {
        background: #C0392B;
        color: #fff;
    }

    .act-note {
        font-size: .7rem;
        color: #aaa;
        margin-left: auto;
    }

    .winner-crown {
        position: absolute;
        top: -8px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--gold);
        color: #fff;
        font-size: .6rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 2px 10px;
        border-radius: 50px;
        white-space: nowrap;
    }

    .admin-note-form {
        display: none;
        margin-top: 10px;
        padding: 12px;
        background: #fff3f3;
        border-radius: 8px;
        border: 1px solid #fcc;
    }

    .filter-tabs {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .filter-tab {
        padding: 6px 16px;
        border-radius: 50px;
        font-size: .75rem;
        font-weight: 600;
        cursor: pointer;
        border: 1.5px solid rgba(0, 0, 0, .1);
        background: #fff;
        color: #666;
        transition: all .15s;
    }

    .filter-tab.active,
    .filter-tab:hover {
        border-color: var(--gold);
        color: var(--deep);
        background: rgba(201, 168, 76, .08);
    }

    .close-auction-box {
        background: linear-gradient(135deg, #FFF8E1, #FFF3CC);
        border: 2px solid var(--gold);
        border-radius: 12px;
        padding: 18px 22px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .close-auction-box h6 {
        font-family: 'Playfair Display', serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--deep);
        margin-bottom: 3px;
    }

    .btn-close-auction {
        background: linear-gradient(135deg, var(--rust), #A0471F);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 22px;
        font-size: .82rem;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        transition: all .2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-close-auction:hover {
        box-shadow: 0 6px 20px rgba(139, 58, 26, .4);
        transform: translateY(-1px);
    }

    .empty-bids {
        text-align: center;
        padding: 60px 20px;
        color: #aaa;
    }

    /* View full details trigger */
    .btn-view-full-details {
        margin-top: 10px;
        background: rgba(201, 168, 76, .15);
        border: 1px solid rgba(201, 168, 76, .45);
        color: var(--gold);
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .3px;
        padding: 6px 16px;
        border-radius: 50px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all .2s;
    }

    .btn-view-full-details:hover {
        background: var(--gold);
        color: #fff;
    }

    /* Item details modal — light theme, no dark surfaces */
    #itemDetailsModal .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }

    #itemDetailsModal .modal-header {
        background: var(--cream);
        border-bottom: 1px solid rgba(0, 0, 0, .06);
        padding: 18px 24px;
    }

    #itemDetailsModal .modal-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--deep);
    }

    #itemDetailsModal .modal-body {
        background: #fff;
        padding: 24px;
        max-height: 70vh;
        overflow-y: auto;
    }

    .detail-section {
        margin-bottom: 22px;
    }

    .detail-section:last-child {
        margin-bottom: 0;
    }

    .detail-section-title {
        font-size: .66rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 700;
        color: var(--gold);
        margin-bottom: 10px;
        padding-bottom: 6px;
        border-bottom: 1px solid rgba(201, 168, 76, .2);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
        gap: 14px;
    }

    .detail-item .detail-lbl {
        font-size: .62rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #aaa;
        font-weight: 700;
        margin-bottom: 3px;
    }

    .detail-item .detail-val {
        font-size: .85rem;
        font-weight: 600;
        color: var(--deep);
        line-height: 1.4;
    }

    .detail-text-block {
        font-size: .85rem;
        color: #444;
        line-height: 1.7;
        background: var(--cream);
        border-radius: 10px;
        padding: 14px 16px;
        border: 1px solid rgba(0, 0, 0, .05);
    }

    .detail-img-grid {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .detail-img-grid img {
        width: 88px;
        height: 88px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid rgba(0, 0, 0, .08);
    }
</style>

@section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            {{-- Breadcrumb --}}
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb bg-light px-3 py-2 rounded-pill small mb-0 d-inline-flex">
                    <li class="breadcrumb-item"><a href="{{ url('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ngo.auction.index') }}">Auctions</a></li>
                    <li class="breadcrumb-item active">Bids</li>
                </ol>
            </nav>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show py-2 small mb-3">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Item hero --}}
            <div class="bids-hero">
                {{-- <img src="{{ $item->thumbnail }}" alt="{{ $item->title }}" > --}}
                @php
                    $thumbnail = $item->images->where('image_type', 'thumbnail')->first();
                @endphp

                <img src="{{ $thumbnail ? asset($thumbnail->image_path) : asset('images/no-image.png') }}"
                    alt="{{ $item->title }}" class="bids-hero-img">
                <div>
                    <div class="bids-hero-title">{{ $item->title }}</div>
                    <div class="bids-hero-meta">
                        <span><i class="fas fa-location-dot me-1"></i>{{ $item->origin ?? '—' }}</span>
                        <span><i class="fas fa-hourglass me-1"></i>{{ $item->age_period ?? '—' }}</span>
                        <span><i class="fas fa-calendar me-1"></i>Ends
                            {{ $item->auction_end->format('d M Y h:i A') }}</span>
                        <span class="badge"
                            style="background:rgba(201,168,76,.2);color:var(--gold);font-size:.68rem;">{{ ucfirst(str_replace('_', ' ', $item->rarity_level)) }}</span>
                    </div>
                    <button type="button" class="btn-view-full-details" data-bs-toggle="modal"
                        data-bs-target="#itemDetailsModal">
                        <i class="fas fa-circle-info"></i> View Full Item Details
                    </button>
                </div>
                <div class="bids-hero-stats">
                    <div class="bid-stat-mini">
                        <div class="bid-stat-val">{{ $bids->total() }}</div>
                        <div class="bid-stat-lbl">Total Bids</div>
                    </div>
                    <div class="bid-stat-mini">
                        <div class="bid-stat-val">
                            ₹{{ number_format($item->current_highest_bid ?? $item->starting_bid, 0) }}</div>
                        <div class="bid-stat-lbl">Highest</div>
                    </div>
                    <div class="bid-stat-mini">
                        <div class="bid-stat-val">{{ $bids->where('ngo_approved', false)->count() }}</div>
                        <div class="bid-stat-lbl">Pending</div>
                    </div>
                </div>
            </div>

            {{-- Full Item Details Modal --}}
            <div class="modal fade" id="itemDetailsModal" tabindex="-1" aria-labelledby="itemDetailsModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="itemDetailsModalLabel">
                                <i class="fas fa-scroll me-2" style="color:var(--gold);"></i>{{ $item->title }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            {{-- Description --}}
                            <div class="detail-section">
                                <div class="detail-section-title"><i class="fas fa-align-left"></i> Short Description
                                </div>
                                <div class="detail-text-block">{{ $item->description ?? '—' }}</div>
                            </div>

                            {{-- About material --}}
                            @if ($item->about_material)
                                <div class="detail-section">
                                    <div class="detail-section-title"><i class="fas fa-book-open"></i> About This
                                        Material</div>
                                    <div class="detail-text-block">{{ $item->about_material }}</div>
                                </div>
                            @endif

                            {{-- Material specs --}}
                            <div class="detail-section">
                                <div class="detail-section-title"><i class="fas fa-microscope"></i> Material
                                    Specifications</div>
                                <div class="detail-grid">
                                    <div class="detail-item">
                                        <div class="detail-lbl">Material Type</div>
                                        <div class="detail-val">{{ $item->material_type ?? '—' }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-lbl">Origin / Region</div>
                                        <div class="detail-val">{{ $item->origin ?? '—' }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-lbl">Age / Period</div>
                                        <div class="detail-val">{{ $item->age_period ?? '—' }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-lbl">Condition</div>
                                        <div class="detail-val">{{ $item->condition ?? '—' }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-lbl">Dimensions</div>
                                        <div class="detail-val">{{ $item->dimensions ?? '—' }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-lbl">Weight</div>
                                        <div class="detail-val">{{ $item->weight ?? '—' }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-lbl">Certificate No.</div>
                                        <div class="detail-val">{{ $item->certificate_number ?? '—' }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-lbl">Rarity</div>
                                        <div class="detail-val">
                                            {{ ucfirst(str_replace('_', ' ', $item->rarity_level)) }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Provenance --}}
                            @if ($item->provenance)
                                <div class="detail-section">
                                    <div class="detail-section-title"><i class="fas fa-signature"></i> Provenance
                                        (Ownership History)</div>
                                    <div class="detail-text-block">{{ $item->provenance }}</div>
                                </div>
                            @endif

                            {{-- Auction & pricing --}}
                            <div class="detail-section">
                                <div class="detail-section-title"><i class="fas fa-indian-rupee-sign"></i> Auction &
                                    Pricing</div>
                                <div class="detail-grid">
                                    <div class="detail-item">
                                        <div class="detail-lbl">Starting Bid</div>
                                        <div class="detail-val">₹{{ number_format($item->starting_bid, 0) }}</div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-lbl">Reserve Price</div>
                                        <div class="detail-val">
                                            {{ $item->reserve_price ? '₹' . number_format($item->reserve_price, 0) : 'Not set' }}
                                        </div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-lbl">Auction Start</div>
                                        <div class="detail-val">{{ $item->auction_start->format('d M Y, h:i A') }}
                                        </div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-lbl">Auction End</div>
                                        <div class="detail-val">{{ $item->auction_end->format('d M Y, h:i A') }}
                                        </div>
                                    </div>
                                    <div class="detail-item">
                                        <div class="detail-lbl">Status</div>
                                        <div class="detail-val">
                                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- 3D model --}}
                            @if ($item->model_3d_url)
                                <div class="detail-section">
                                    <div class="detail-section-title"><i class="fas fa-cube"></i> 3D Model</div>
                                    <a href="{{ $item->model_3d_url }}" target="_blank" rel="noopener"
                                        style="font-size:.85rem;color:var(--jade);text-decoration:underline;word-break:break-all;">
                                        {{ $item->model_3d_url }}
                                    </a>
                                </div>
                            @endif

                            {{-- Images --}}
                            @if ($item->images->isNotEmpty())
                                <div class="detail-section">
                                    <div class="detail-section-title"><i class="fas fa-images"></i> Item Images</div>
                                    <div class="detail-img-grid">
                                        @foreach ($item->images as $img)
                                            <img src="{{ asset($img->image_path) }}" alt="">
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>

            {{-- Close auction box --}}
            @if ($item->status === 'active')
                <div class="close-auction-box">
                    <div>
                        <h6><i class="fas fa-lock-open me-2 text-warning"></i>Auction is Currently Active</h6>
                        <p class="mb-0 text-muted small">Closing will finalize bids and automatically select the highest
                            approved bid as winner.</p>
                    </div>
                    <form method="POST" action="{{ route('ngo.auction.close', $item->id) }}"
                        onsubmit="return confirm('Close this auction and determine winner?')">
                        @csrf
                        <button type="submit" class="btn-close-auction">
                            <i class="fas fa-gavel"></i> Close Auction & Select Winner
                        </button>
                    </form>
                </div>
            @endif

            {{-- Filter tabs --}}
            <div class="filter-tabs">
                <button class="filter-tab active" onclick="filterBids('all', this)">All ({{ $bids->total() }})</button>
                <button class="filter-tab" onclick="filterBids('pending', this)">Pending Review</button>
                <button class="filter-tab" onclick="filterBids('active', this)">Approved</button>
                <button class="filter-tab" onclick="filterBids('won', this)">Winner</button>
                <button class="filter-tab" onclick="filterBids('lost', this)">Lost</button>
                <button class="filter-tab" onclick="filterBids('cancelled', this)">Rejected</button>
            </div>

            {{-- Bids list --}}
            @if ($bids->isEmpty())
                <div class="empty-bids">
                    <i class="fas fa-gavel fa-3x mb-3 d-block opacity-20"></i>
                    <h5 style="font-family:'Playfair Display',serif;">No Bids Yet</h5>
                    <p>Bids placed on this auction will appear here for review.</p>
                </div>
            @else
                <div id="bidsContainer">
                    @foreach ($bids as $index => $bid)
                        <div class="bid-card {{ $bid->status === 'won' ? 'is-winner' : '' }} position-relative"
                            data-status="{{ $bid->status }}" data-approved="{{ $bid->ngo_approved ? '1' : '0' }}">

                            @if ($bid->status === 'won')
                                <div class="winner-crown"><i class="fas fa-trophy me-1"></i>Winner</div>
                            @endif

                            {{-- Card header --}}
                            <div class="bid-card-header">
                                <div class="d-flex align-items-center gap-12" style="gap:12px;">
                                    <div class="bid-rank-badge rank-{{ $index < 3 ? $index + 1 : 'n' }}">
                                        {{ $index + 1 }}
                                    </div>
                                    <div>
                                        <div style="font-weight:700;font-size:.92rem;color:var(--deep);">
                                            {{ $bid->bidder_name }}
                                        </div>
                                        <div style="font-size:.72rem;color:#999;">
                                            {{ $bid->bidder_email }} · {{ $bid->bidder_phone }}
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-3">
                                    <div class="bid-amount-display">₹{{ number_format($bid->bid_amount, 0) }}</div>
                                    <span class="status-pill pill-{{ $bid->status }}">
                                        {{ ucfirst($bid->status) }}
                                    </span>
                                    @if (!$bid->ngo_approved && $bid->status !== 'cancelled')
                                        <span class="status-pill"
                                            style="background:#FFF8E1;color:#B8860B;border:1px solid var(--gold);">
                                            <i class="fas fa-clock" style="font-size:.5rem;"></i> Unreviewed
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Card body: all details --}}
                            <div class="bid-card-body">
                                <div class="info-block">
                                    <div class="info-lbl"><i class="fas fa-clock me-1"></i>Bid Placed</div>
                                    <div class="info-val">{{ $bid->created_at->format('d M Y') }}<br>
                                        <span
                                            style="font-weight:400;color:#999;font-size:.78rem;">{{ $bid->created_at->format('h:i A') }}</span>
                                    </div>
                                </div>
                                <div class="info-block">
                                    <div class="info-lbl"><i class="fas fa-id-card me-1"></i>Identity</div>
                                    <div class="info-val">
                                        {{ $bid->bidder_id_type ? ucfirst($bid->bidder_id_type) : '—' }}<br>
                                        <span
                                            style="font-weight:400;color:#999;font-size:.78rem;">{{ $bid->bidder_id_number ?? '—' }}</span>
                                    </div>
                                </div>
                                <div class="info-block" style="grid-column: span 2;">
                                    <div class="info-lbl"><i class="fas fa-location-dot me-1"></i>Full Address</div>
                                    <div class="address-full">
                                        @if ($bid->bidder_house_no)
                                            <strong>{{ $bid->bidder_house_no }}</strong>,
                                        @endif
                                        @if ($bid->bidder_village)
                                            {{ $bid->bidder_village }},
                                        @endif
                                        @if ($bid->bidder_block)
                                            Block: {{ $bid->bidder_block }},
                                        @endif
                                        <br>
                                        @if ($bid->bidder_district)
                                            District: <strong>{{ $bid->bidder_district }}</strong>,
                                        @endif
                                        @if ($bid->bidder_state)
                                            {{ $bid->bidder_state }},
                                        @endif
                                        @if ($bid->bidder_pincode)
                                            PIN: {{ $bid->bidder_pincode }},
                                        @endif
                                        <strong>{{ $bid->bidder_country }}</strong>
                                    </div>
                                </div>
                                @if ($bid->ngo_note)
                                    <div class="info-block" style="grid-column: span 2;">
                                        <div class="info-lbl"><i class="fas fa-note-sticky me-1"></i>NGO Note</div>
                                        <div class="info-val text-muted" style="font-weight:400;">{{ $bid->ngo_note }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Actions --}}
                            <div class="bid-card-actions">
                                @if (!$bid->ngo_approved && $bid->status !== 'cancelled')
                                    {{-- Approve bid --}}
                                    <form method="POST" action="{{ route('ngo.auction.approve.bid', $bid->id) }}">
                                        @csrf
                                        <button type="submit" class="act-btn act-approve">
                                            <i class="fas fa-check"></i> Approve Bid
                                        </button>
                                    </form>
                                @endif

                                @if ($bid->status === 'won' && !$bid->ngo_approved)
                                    {{-- Approve as winner --}}
                                    <form method="POST" action="{{ route('ngo.auction.approve.winner', $bid->id) }}">
                                        @csrf
                                        <button type="submit" class="act-btn act-winner"
                                            onclick="return confirm('Approve {{ $bid->bidder_name }} as winner and send notification?')">
                                            <i class="fas fa-trophy"></i> Approve as Winner & Notify
                                        </button>
                                    </form>
                                @endif

                                @if ($bid->ngo_approved && $bid->status === 'active' && $item->status !== 'winner_selected')
                                    {{-- Manually select as winner --}}
                                    <form method="POST" action="{{ route('ngo.auction.approve.winner', $bid->id) }}">
                                        @csrf
                                        <button type="submit" class="act-btn act-winner"
                                            onclick="return confirm('Select {{ $bid->bidder_name }} as winner and notify them?')">
                                            <i class="fas fa-trophy"></i> Select as Winner
                                        </button>
                                    </form>
                                @endif

                                @if ($bid->status !== 'cancelled' && $bid->status !== 'won')
                                    <button class="act-btn act-reject" onclick="toggleNoteForm({{ $bid->id }})">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                @endif

                                <span class="act-note">#{{ $bid->id }} · Bid ID</span>
                            </div>

                            {{-- Reject note form --}}
                            <div class="admin-note-form px-3 pb-3" id="noteForm-{{ $bid->id }}">
                                <form method="POST" action="{{ route('ngo.auction.reject.bid', $bid->id) }}">
                                    @csrf
                                    <div class="mb-2">
                                        <label class="form-label small fw-semibold">Rejection Reason (optional)</label>
                                        <input type="text" name="note" class="form-control form-control-sm"
                                            placeholder="e.g. Duplicate bid, suspicious activity...">
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-sm btn-danger">Confirm Reject</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                            onclick="toggleNoteForm({{ $bid->id }})">Cancel</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($bids->hasPages())
                    <div class="mt-3">{{ $bids->links() }}</div>
                @endif
            @endif

        </div>
    </div>



    <script>
        function filterBids(status, btn) {
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');

            document.querySelectorAll('.bid-card').forEach(card => {
                if (status === 'all') {
                    card.style.display = '';
                } else if (status === 'pending') {
                    card.style.display = card.dataset.approved === '0' && card.dataset.status !== 'cancelled' ? '' :
                        'none';
                } else {
                    card.style.display = card.dataset.status === status ? '' : 'none';
                }
            });
        }

        function toggleNoteForm(id) {
            const form = document.getElementById('noteForm-' + id);
            form.style.display = form.style.display === 'block' ? 'none' : 'block';
        }
    </script>
@endsection
