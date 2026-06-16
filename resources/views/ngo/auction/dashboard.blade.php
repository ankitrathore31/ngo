@extends('ngo.layout.master')

@section('title', 'Auction Dashboard')

{{-- @push('styles') --}}
    <style>
        :root {
            --gold: #C9A84C;
            --gold-light: #F0E0A8;
            --deep: #1A1208;
            --cream: #F7F3EC;
            --rust: #8B3A1A;
            --jade: #2C5F4A;
            --jade-light: #E6F4EE;
        }

        /* ── Layout ─────────────────────────────────── */
        .dash-wrap {
            padding: 28px 0;
        }

        /* ── Page Header ────────────────────────────── */
        .dash-hero {
            background: linear-gradient(145deg, #1A1208 0%, #a117f1 60%, #3A2810 100%);
            border-radius: 16px;
            padding: 32px 36px;
            color: #fff;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
        }

        .dash-hero::before {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(201, 168, 76, .07);
            pointer-events: none;
        }

        .dash-hero::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: 30%;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: rgba(201, 168, 76, .04);
            pointer-events: none;
        }

        .hero-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 4px;
            letter-spacing: -.3px;
        }

        .hero-sub {
            color: rgba(255, 255, 255, .45);
            font-size: 1.2rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin: 0;
        }

        .hero-time {
            font-size: .92rem;
            color: rgba(255, 255, 255, .35);
            margin-top: 10px;
        }

        /* ── KPI Cards ──────────────────────────────── */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 14px;
            margin-bottom: 28px;
        }

        .kpi-card {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .06);
            border-radius: 14px;
            padding: 20px 18px 16px;
            position: relative;
            transition: box-shadow .2s, transform .2s;
            overflow: hidden;
        }

        .kpi-card:hover {
            box-shadow: 0 6px 24px rgba(0, 0, 0, .07);
            transform: translateY(-2px);
        }

        .kpi-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 14px 14px 0 0;
        }

        .kpi-gold::before {
            background: linear-gradient(90deg, var(--gold), #E8C96A);
        }

        .kpi-jade::before {
            background: linear-gradient(90deg, #2C5F4A, #4A9B78);
        }

        .kpi-blue::before {
            background: linear-gradient(90deg, #1565C0, #42A5F5);
        }

        .kpi-rust::before {
            background: linear-gradient(90deg, #8B3A1A, #D4603A);
        }

        .kpi-purple::before {
            background: linear-gradient(90deg, #6B3FA0, #9C6DD4);
        }

        .kpi-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            margin-bottom: 12px;
        }

        .kpi-gold .kpi-icon {
            background: #FEF7E6;
            color: var(--gold);
        }

        .kpi-jade .kpi-icon {
            background: var(--jade-light);
            color: var(--jade);
        }

        .kpi-blue .kpi-icon {
            background: #E8F4FF;
            color: #1565C0;
        }

        .kpi-rust .kpi-icon {
            background: #FDF0EA;
            color: var(--rust);
        }

        .kpi-purple.kpi-icon {
            background: #F3EDF9;
            color: #6B3FA0;
        }

        .kpi-purple .kpi-icon {
            background: #F3EDF9;
            color: #6B3FA0;
        }

        .kpi-val {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--deep);
            line-height: 1;
            margin-bottom: 4px;
        }

        .kpi-lbl {
            font-size: .67rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #999;
            font-weight: 700;
        }

        .kpi-trend {
            position: absolute;
            top: 18px;
            right: 16px;
            font-size: .7rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
        }

        .trend-up {
            background: #E6F9F0;
            color: #1A7A4A;
        }

        .trend-warn {
            background: #FFF8E1;
            color: #B8860B;
        }

        .trend-info {
            background: #E8F4FF;
            color: #1565C0;
        }

        /* ── Section headers ────────────────────────── */
        .section-hd {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .section-hd h6 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--deep);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-hd h6 i {
            color: var(--gold);
            font-size: .85rem;
        }

        .section-link {
            font-size: .73rem;
            font-weight: 700;
            color: var(--gold);
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .section-link:hover {
            color: var(--rust);
        }

        /* ── Active Auctions Panel ──────────────────── */
        .active-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .active-item {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .06);
            border-radius: 12px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: box-shadow .15s;
        }

        .active-item:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, .06);
        }

        .active-thumb {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid rgba(0, 0, 0, .07);
            flex-shrink: 0;
        }

        .active-info {
            flex: 1;
            min-width: 0;
        }

        .active-title {
            font-weight: 700;
            font-size: .85rem;
            color: var(--deep);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 3px;
        }

        .active-meta {
            font-size: .72rem;
            color: #999;
        }

        .active-bid-col {
            text-align: right;
            flex-shrink: 0;
        }

        .active-bid-amt {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1rem;
            font-weight: 700;
            color: var(--jade);
        }

        .active-bid-lbl {
            font-size: .65rem;
            color: #bbb;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* progress bar for countdown */
        .auction-progress {
            height: 3px;
            background: #eee;
            border-radius: 4px;
            margin-top: 6px;
            overflow: hidden;
        }

        .auction-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--gold), #E8C96A);
            border-radius: 4px;
            transition: width .5s;
        }

        /* ── Bid Count Badge ────────────────────────── */
        .bid-badge {
            background: var(--cream);
            border: 1px solid rgba(0, 0, 0, .07);
            border-radius: 20px;
            font-size: .88rem;
            font-weight: 700;
            color: #777;
            padding: 2px 10px;
            white-space: nowrap;
        }

        /* ── Recent Bids Table ──────────────────────── */
        .bids-table-wrap {
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .06);
            border-radius: 14px;
            overflow: hidden;
        }

        .bids-table {
            width: 100%;
            border-collapse: collapse;
        }

        .bids-table thead th {
            background: var(--cream);
            font-size: .85rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #888;
            font-weight: 700;
            padding: 10px 16px;
            border: none;
        }

        .bids-table tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0, 0, 0, .04);
            font-size: .82rem;
        }

        .bids-table tbody tr:last-child td {
            border-bottom: none;
        }

        .bids-table tbody tr:hover {
            background: #fafaf8;
        }

        .bidder-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--rust));
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: .65rem;
            font-weight: 700;
            color: #fff;
            margin-right: 8px;
            flex-shrink: 0;
        }

        .bid-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: .63rem;
            font-weight: 700;
            letter-spacing: .8px;
            text-transform: uppercase;
        }

        .pill-pending {
            background: #FFF8E1;
            color: #B8860B;
            border: 1px solid #F5D98A;
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

        .pill-cancelled {
            background: #FEF2F0;
            color: #C0392B;
            border: 1px solid #E8A49C;
        }

        .bid-amount {
            font-family: 'Playfair Display', Georgia, serif;
            font-weight: 700;
            color: var(--jade);
        }

        /* ── Quick Actions ──────────────────────────── */
        .qa-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .qa-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, .07);
            background: #fff;
            text-decoration: none;
            transition: all .15s;
            cursor: pointer;
        }

        .qa-btn:hover {
            border-color: var(--gold);
            box-shadow: 0 3px 12px rgba(201, 168, 76, .12);
            transform: translateY(-1px);
        }

        .qa-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
            flex-shrink: 0;
        }

        .qa-label {
            font-size: .98rem;
            font-weight: 700;
            color: var(--deep);
            line-height: 1.2;
        }

        .qa-desc {
            font-size: .67rem;
            color: #aaa;
            margin-top: 1px;
        }

        /* ── Mini Chart Bar ─────────────────────────── */
        .mini-bars {
            display: flex;
            align-items: flex-end;
            gap: 4px;
            height: 48px;
        }

        .mini-bar {
            flex: 1;
            background: var(--gold-light);
            border-radius: 3px 3px 0 0;
            position: relative;
            transition: background .2s;
            cursor: pointer;
        }

        .mini-bar:hover {
            background: var(--gold);
        }

        .mini-bar-today {
            background: var(--gold);
        }

        /* ── Status Overview Donut ──────────────────── */
        .donut-legend {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .legend-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: .98rem;
        }

        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
            flex-shrink: 0;
        }

        .legend-left {
            display: flex;
            align-items: center;
            color: #555;
        }

        .legend-count {
            font-weight: 700;
            color: var(--deep);
        }

        /* ── Notification dot ───────────────────────── */
        .notif-dot {
            display: inline-block;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #E74C3C;
            margin-left: 5px;
            vertical-align: middle;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: .5;
                transform: scale(.7);
            }
        }

        /* ── Winner Queue ───────────────────────────── */
        .winner-card {
            background: linear-gradient(135deg, #FFF8E6, #FFFBF0);
            border: 1px solid rgba(201, 168, 76, .3);
            border-radius: 12px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
        }

        .winner-trophy {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, var(--gold), #E8A020);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: .9rem;
            flex-shrink: 0;
        }

        .winner-info {
            flex: 1;
            min-width: 0;
        }

        .winner-name {
            font-weight: 700;
            font-size: .82rem;
            color: var(--deep);
        }

        .winner-item {
            font-size: .72rem;
            color: #999;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .winner-amount {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--gold);
            font-size: .95rem;
        }

        .btn-approve {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            background: var(--gold);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: .72rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
            transition: background .15s;
        }

        .btn-approve:hover {
            background: var(--rust);
            color: #fff;
        }

        /* ── Responsive ─────────────────────────────── */
        @media (max-width: 1199px) {
            .kpi-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 767px) {
            .kpi-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .qa-grid {
                grid-template-columns: 1fr;
            }

            .dash-hero {
                padding: 22px 18px;
            }

            .hero-title {
                font-size: 1.3rem;
            }
        }
    </style>
{{-- @endpush --}}

@section('content')
    <div class="wrapper">
        <div class="container-fluid dash-wrap">

            {{-- ════ HERO HEADER ════ --}}
            <div class="dash-hero">
                <div class="row align-items-center g-3">
                    <div class="col-md-6">
                        <p class="hero-sub mb-2"><i class="fas fa-gavel me-2" style="color:var(--gold);"></i>Auction Command
                            Centre</p>
                        <h2 class="hero-title">Rare Material Auctions</h2>
                        <p class="hero-time">
                            <i class="fas fa-circle me-1"
                                style="font-size:.45rem;color:#4ADE80;vertical-align:middle;animation:pulse-dot 2s infinite;"></i>
                            Live Dashboard &nbsp;·&nbsp; {{ now()->format('l, d F Y  ·  h:i A') }}
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <a href="{{ route('ngo.auction.create') }}" class="btn btn-sm px-4 py-2 me-2"
                            style="background:var(--gold);color:#fff;border-radius:10px;font-weight:700;font-size:.8rem;border:none;">
                            <i class="fas fa-plus me-1"></i> New Auction
                        </a>
                        <a href="{{ route('ngo.auction.index') }}" class="btn btn-sm px-4 py-2"
                            style="background:rgba(255,255,255,.1);color:#fff;border:1px solid rgba(255,255,255,.2);border-radius:10px;font-weight:600;font-size:.8rem;">
                            <i class="fas fa-list me-1"></i> All Auctions
                        </a>
                    </div>
                </div>
            </div>

            {{-- ════ KPI STRIP ════ --}}
            <div class="kpi-grid">

                <div class="kpi-card kpi-gold">
                    <div class="kpi-icon"><i class="fas fa-gavel"></i></div>
                    <div class="kpi-val">{{ $stats['total_auctions'] }}</div>
                    <div class="kpi-lbl">Total Auctions</div>
                    <span class="kpi-trend trend-info">All Time</span>
                </div>

                <div class="kpi-card kpi-jade">
                    <div class="kpi-icon"><i class="fas fa-circle" style="font-size:.5rem;"></i></div>
                    <div class="kpi-val" style="color:#2C5F4A;">{{ $stats['active_auctions'] }}</div>
                    <div class="kpi-lbl">Active Now</div>
                    @if ($stats['active_auctions'] > 0)
                        <span class="kpi-trend trend-up">Live</span>
                    @endif
                </div>

                <div class="kpi-card kpi-blue">
                    <div class="kpi-icon"><i class="fas fa-hand-paper"></i></div>
                    <div class="kpi-val" style="color:#1565C0;">{{ $stats['total_bids'] }}</div>
                    <div class="kpi-lbl">Total Bids</div>
                    <span class="kpi-trend trend-info">Cumulative</span>
                </div>

                <div class="kpi-card kpi-rust">
                    <div class="kpi-icon"><i class="fas fa-clock"></i></div>
                    <div class="kpi-val" style="color:#8B3A1A;">
                        {{ $stats['pending_bids'] }}
                        @if ($stats['pending_bids'] > 0)
                            <span class="notif-dot"></span>
                        @endif
                    </div>
                    <div class="kpi-lbl">Pending Bids</div>
                    @if ($stats['pending_bids'] > 0)
                        <span class="kpi-trend trend-warn">Review</span>
                    @endif
                </div>

                <div class="kpi-card kpi-purple">
                    <div class="kpi-icon"><i class="fas fa-rupee-sign"></i></div>
                    <div class="kpi-val" style="color:#6B3FA0;font-size:1.3rem;">
                        ₹{{ number_format($stats['total_collected'], 0) }}
                    </div>
                    <div class="kpi-lbl">Total Collected</div>
                    <span class="kpi-trend trend-up">Donations</span>
                </div>

            </div>

            {{-- ════ MAIN GRID ════ --}}
            <div class="row g-4">

                {{-- LEFT COL (col-8) --}}
                <div class="col-lg-8">

                    {{-- ── Active Auctions ── --}}
                    <div class="mb-4">
                        <div class="section-hd">
                            <h6><i class="fas fa-fire"></i> Active Auctions
                                @if ($stats['active_auctions'] > 0)
                                    <span class="badge ms-1"
                                        style="background:var(--jade-light);color:var(--jade);font-size:.65rem;padding:3px 9px;border-radius:20px;">{{ $stats['active_auctions'] }}
                                        Live</span>
                                @endif
                            </h6>
                            <a href="{{ route('ngo.auction.index') }}?status=active" class="section-link">
                                View All <i class="fas fa-arrow-right" style="font-size:.65rem;"></i>
                            </a>
                        </div>

                        @if ($activeItems->isNotEmpty())
                            <div class="active-list">
                                @foreach ($activeItems as $item)
                                    @php
                                        $start = $item->auction_start ?? now()->subDays(2);
                                        $end = $item->auction_end;
                                        $total = max(
                                            1,
                                            \Carbon\Carbon::parse($start)->diffInSeconds(\Carbon\Carbon::parse($end)),
                                        );
                                        $elapsed = \Carbon\Carbon::parse($start)->diffInSeconds(now());
                                        $pct = min(100, round(($elapsed / $total) * 100));
                                        $timeLeft = \Carbon\Carbon::parse($end)->diffForHumans([
                                            'parts' => 2,
                                            'join' => ' ',
                                        ]);
                                    @endphp
                                    <div class="active-item">
                                        <img src="{{ $item->thumbnail ?? 'https://placehold.co/50x50/C9A84C/fff?text=A' }}"
                                            alt="{{ $item->title }}" class="active-thumb">

                                        <div class="active-info">
                                            <div class="active-title">{{ Str::limit($item->title, 40) }}</div>
                                            <div class="active-meta d-flex align-items-center gap-2 flex-wrap">
                                                <span><i class="fas fa-clock"
                                                        style="font-size:.6rem;color:var(--gold);"></i> Ends
                                                    {{ $timeLeft }}</span>
                                                <span class="bid-badge"><i class="fas fa-hand-paper"
                                                        style="font-size:.55rem;"></i> {{ $item->bids_count }} bids</span>
                                                <span
                                                    style="font-size:.68rem;color:#bbb;">{{ ucfirst(str_replace('_', ' ', $item->rarity_level ?? 'rare')) }}</span>
                                            </div>
                                            <div class="auction-progress mt-2">
                                                <div class="auction-progress-bar" style="width:{{ $pct }}%;">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="active-bid-col">
                                            <div class="active-bid-amt">
                                                {{ $item->current_highest_bid ? '₹' . number_format($item->current_highest_bid, 0) : '—' }}
                                            </div>
                                            <div class="active-bid-lbl">Top Bid</div>
                                            <a href="{{ route('ngo.auction.bids', $item->id) }}"
                                                class="btn btn-sm mt-2 px-2 py-1"
                                                style="font-size:.68rem;background:var(--jade-light);color:var(--jade);border:1px solid #A5D6B7;border-radius:7px;font-weight:700;">
                                                Manage
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5"
                                style="background:#fff;border:1px dashed #ddd;border-radius:14px;">
                                <i class="fas fa-gavel fa-2x mb-3 d-block" style="color:#ddd;"></i>
                                <p class="text-muted small mb-2">No active auctions running</p>
                                <a href="{{ route('ngo.auction.create') }}" class="btn btn-sm px-4"
                                    style="background:var(--gold);color:#fff;border-radius:8px;font-weight:700;border:none;">
                                    <i class="fas fa-plus me-1"></i> Start One
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- ── Recent Bids ── --}}
                    <div class="mb-4">
                        <div class="section-hd">
                            <h6><i class="fas fa-history"></i> Recent Bids
                                @if ($stats['pending_bids'] > 0)
                                    <span class="badge ms-1"
                                        style="background:#FFF8E1;color:#B8860B;font-size:.65rem;padding:3px 9px;border-radius:20px;">
                                        {{ $stats['pending_bids'] }} Pending<span class="notif-dot ms-1"></span>
                                    </span>
                                @endif
                            </h6>
                            <a href="{{ route('ngo.auction.index') }}" class="section-link">
                                All Bids <i class="fas fa-arrow-right" style="font-size:.65rem;"></i>
                            </a>
                        </div>

                        <div class="bids-table-wrap">
                            <table class="bids-table">
                                <thead>
                                    <tr>
                                        <th>Bidder</th>
                                        <th>Auction Item</th>
                                        <th>Amount</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentBids as $bid)
                                        @php
                                            $initials = strtoupper(
                                                substr($bid->bidder_name ?? 'U', 0, 1) .
                                                    substr(strrchr($bid->bidder_name ?? ' A', ' '), 1, 1),
                                            );
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bidder-avatar">{{ $initials ?: 'U' }}</div>
                                                    <div>
                                                        <div class="fw-semibold"
                                                            style="font-size:.82rem;color:var(--deep);">
                                                            {{ $bid->bidder_name ?? 'Anonymous' }}</div>
                                                        <div style="font-size:.68rem;color:#bbb;">
                                                            {{ $bid->bidder_email ?? '—' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="max-width:160px;">
                                                <div
                                                    style="font-size:.8rem;font-weight:600;color:#333;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                                    {{ Str::limit($bid->auctionItem->title ?? 'Unknown Item', 30) }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="bid-amount">₹{{ number_format($bid->bid_amount, 0) }}</span>
                                            </td>
                                            <td style="font-size:.75rem;color:#999;white-space:nowrap;">
                                                {{ $bid->created_at->diffForHumans() }}
                                            </td>
                                            <td>
                                                @php $s = $bid->status ?? 'pending'; @endphp
                                                <span class="bid-status-pill pill-{{ $s }}">
                                                    @if ($s === 'pending')
                                                        <i class="fas fa-circle" style="font-size:.35rem;"></i>
                                                    @endif
                                                    {{ ucfirst($s) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if (($bid->status ?? 'pending') === 'pending' && !$bid->ngo_approved)
                                                    <form method="POST"
                                                        action="{{ route('ngo.auction.approveBid', $bid->id) }}"
                                                        class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn-approve">
                                                            <i class="fas fa-check"></i> Approve
                                                        </button>
                                                    </form>
                                                @elseif($bid->status === 'won')
                                                    <span style="font-size:.72rem;color:var(--jade);font-weight:700;">
                                                        <i class="fas fa-trophy me-1"></i>Winner
                                                    </span>
                                                @else
                                                    <span style="font-size:.72rem;color:#bbb;">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted"
                                                style="font-size:.82rem;">
                                                <i class="fas fa-inbox fa-lg d-block mb-2 opacity-25"></i>
                                                No bids received yet
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                {{-- RIGHT COL (col-4) --}}
                <div class="col-lg-4">

                    {{-- ── Quick Actions ── --}}
                    <div class="mb-4">
                        <div class="section-hd">
                            <h6><i class="fas fa-bolt"></i> Quick Actions</h6>
                        </div>
                        <div class="qa-grid">
                            <a href="{{ route('ngo.auction.create') }}" class="qa-btn">
                                <div class="qa-icon" style="background:#FEF7E6;color:var(--gold);"><i
                                        class="fas fa-plus"></i></div>
                                <div>
                                    <div class="qa-label">New Auction</div>
                                    <div class="qa-desc">Create listing</div>
                                </div>
                            </a>
                            <a href="{{ route('ngo.auction.index') }}" class="qa-btn">
                                <div class="qa-icon" style="background:var(--jade-light);color:var(--jade);"><i
                                        class="fas fa-list"></i></div>
                                <div>
                                    <div class="qa-label">All Auctions</div>
                                    <div class="qa-desc">View & manage</div>
                                </div>
                            </a>
                            <a href="{{ route('ngo.auction.index') }}?status=closed" class="qa-btn">
                                <div class="qa-icon" style="background:#FDF0EA;color:var(--rust);"><i
                                        class="fas fa-lock"></i></div>
                                <div>
                                    <div class="qa-label">Closed</div>
                                    <div class="qa-desc">Select winners</div>
                                </div>
                            </a>
                            <a href="{{ route('ngo.auction.index') }}?status=winner_selected" class="qa-btn">
                                <div class="qa-icon" style="background:#FFF8E1;color:#B8860B;"><i
                                        class="fas fa-trophy"></i></div>
                                <div>
                                    <div class="qa-label">Winners</div>
                                    <div class="qa-desc">Notify & confirm</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    {{-- ── Status Breakdown ── --}}
                    <div class="mb-4">
                        <div class="section-hd">
                            <h6><i class="fas fa-chart-pie"></i> Status Breakdown</h6>
                        </div>
                        <div style="background:#fff;border:1px solid rgba(0,0,0,.06);border-radius:14px;padding:18px;">
                            @php
                                use App\Models\AuctionItem;
                                $breakdown = [
                                    ['label' => 'Active', 'color' => '#2C5F4A', 'status' => 'active'],
                                    ['label' => 'Draft', 'color' => '#999', 'status' => 'draft'],
                                    ['label' => 'Closed', 'color' => '#C0392B', 'status' => 'closed'],
                                    ['label' => 'Winner Selected', 'color' => '#B8860B', 'status' => 'winner_selected'],
                                    ['label' => 'Completed', 'color' => '#1565C0', 'status' => 'completed'],
                                ];
                                $total = max(1, $stats['total_auctions']);
                            @endphp

                            {{-- Simple SVG Donut --}}
                            <div class="text-center mb-3">
                                <svg width="100" height="100" viewBox="0 0 100 100">
                                    @php
                                        $colors = ['#2C5F4A', '#999', '#C0392B', '#B8860B', '#1565C0'];
                                        $counts = collect($breakdown)
                                            ->map(fn($b) => AuctionItem::where('status', $b['status'])->count())
                                            ->toArray();
                                        $total2 = max(1, array_sum($counts));
                                        $offset = 0;
                                        $r = 38;
                                        $cx = 50;
                                        $cy = 50;
                                        $circumference = 2 * M_PI * $r;
                                    @endphp
                                    @foreach ($counts as $i => $cnt)
                                        @php
                                            $dash = ($cnt / $total2) * $circumference;
                                            $gap = $circumference - $dash;
                                        @endphp
                                        <circle cx="{{ $cx }}" cy="{{ $cy }}"
                                            r="{{ $r }}" fill="none" stroke="{{ $colors[$i] }}"
                                            stroke-width="12"
                                            stroke-dasharray="{{ round($dash, 2) }} {{ round($gap, 2) }}"
                                            stroke-dashoffset="{{ -$offset }}"
                                            transform="rotate(-90 {{ $cx }} {{ $cy }})" />
                                        @php $offset += $dash; @endphp
                                    @endforeach
                                    <text x="50" y="46" text-anchor="middle" font-size="13" font-weight="700"
                                        fill="#1A1208" font-family="Georgia,serif">{{ $stats['total_auctions'] }}</text>
                                    <text x="50" y="60" text-anchor="middle" font-size="7" fill="#999"
                                        font-family="sans-serif">TOTAL</text>
                                </svg>
                            </div>

                            <div class="donut-legend">
                                @foreach ($breakdown as $i => $row)
                                    @php $cnt = AuctionItem::where('status',$row['status'])->count(); @endphp
                                    <div class="legend-row">
                                        <div class="legend-left">
                                            <span class="legend-dot" style="background:{{ $row['color'] }};"></span>
                                            {{ $row['label'] }}
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="legend-count">{{ $cnt }}</span>
                                            <div
                                                style="width:60px;height:4px;background:#eee;border-radius:2px;overflow:hidden;">
                                                <div
                                                    style="width:{{ $total > 0 ? round(($cnt / $total) * 100) : 0 }}%;height:100%;background:{{ $row['color'] }};border-radius:2px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- ── Winners Awaiting Approval ── --}}
                    @php
                        use App\Models\AuctionBid;
                        $pendingWinners = AuctionBid::with('auctionItem')
                            ->where('status', 'won')
                            ->where('ngo_approved', false)
                            ->latest()
                            ->take(4)
                            ->get();
                    @endphp

                    @if ($pendingWinners->isNotEmpty())
                        <div class="mb-4">
                            <div class="section-hd">
                                <h6>
                                    <i class="fas fa-trophy"></i> Awaiting Approval
                                    <span class="notif-dot"></span>
                                </h6>
                            </div>
                            @foreach ($pendingWinners as $wb)
                                <div class="winner-card">
                                    <div class="winner-trophy"><i class="fas fa-trophy"></i></div>
                                    <div class="winner-info">
                                        <div class="winner-name">{{ $wb->bidder_name ?? 'Unknown Bidder' }}</div>
                                        <div class="winner-item">{{ Str::limit($wb->auctionItem->title ?? '—', 28) }}
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="winner-amount">₹{{ number_format($wb->bid_amount, 0) }}</div>
                                        <form method="POST" action="{{ route('ngo.auction.approveWinner', $wb->id) }}"
                                            class="mt-1">
                                            @csrf
                                            <button type="submit" class="btn-approve">
                                                <i class="fas fa-check"></i> Confirm
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    {{-- ── Bid Activity Sparkline (last 7 days) ── --}}
                    <div class="mb-4">
                        <div class="section-hd">
                            <h6><i class="fas fa-chart-bar"></i> Bid Activity</h6>
                            <span style="font-size:.7rem;color:#bbb;">Last 7 days</span>
                        </div>
                        <div style="background:#fff;border:1px solid rgba(0,0,0,.06);border-radius:14px;padding:18px;">
                            @php
                                $days = collect(range(6, 0))->map(function ($d) {
                                    $date = now()->subDays($d);
                                    return [
                                        'label' => $date->format('D'),
                                        'count' => AuctionBid::whereDate('created_at', $date->toDateString())->count(),
                                        'today' => $d === 0,
                                    ];
                                });
                                $maxCount = max(1, $days->max('count'));
                            @endphp
                            <div class="mini-bars mb-2">
                                @foreach ($days as $d)
                                    @php $h = max(4, round(($d['count']/$maxCount)*48)); @endphp
                                    <div class="mini-bar {{ $d['today'] ? 'mini-bar-today' : '' }}"
                                        style="height:{{ $h }}px;"
                                        title="{{ $d['label'] }}: {{ $d['count'] }} bids">
                                    </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-between"
                                style="font-size:.63rem;color:#bbb;text-transform:uppercase;letter-spacing:.5px;">
                                @foreach ($days as $d)
                                    <span
                                        style="{{ $d['today'] ? 'color:var(--gold);font-weight:700;' : '' }}">{{ $d['label'] }}</span>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-between mt-2"
                                style="font-size:.72rem;font-weight:700;color:#555;">
                                @foreach ($days as $d)
                                    <span
                                        style="{{ $d['today'] ? 'color:var(--gold);' : '' }}">{{ $d['count'] }}</span>
                                @endforeach
                            </div>
                            <div class="mt-3 pt-3" style="border-top:1px solid rgba(0,0,0,.05);">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span style="font-size:.72rem;color:#999;">Week Total</span>
                                    <span
                                        style="font-size:.88rem;font-weight:700;color:var(--deep);">{{ $days->sum('count') }}
                                        bids</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- /RIGHT COL --}}

            </div>
            {{-- /MAIN GRID --}}

        </div>
    </div>



    <script>
        // Auto-refresh KPIs every 60 seconds (optional live feel)
        // setTimeout(() => window.location.reload(), 60000);
    </script>
@endsection
