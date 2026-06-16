@extends('home.layout.master')

@section('title', 'Bid Placed Successfully')

<style>
    :root {
        --gold: #C9A84C;
        --deep: #1A1208;
        --cream: #F7F3EC;
        --rust: #8B3A1A;
        --jade: #2C5F4A;
    }

    .confirmation-wrap {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        background: var(--cream);
    }

    .confirmation-card {
        background: #fff;
        border-radius: 20px;
        max-width: 680px;
        width: 100%;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .1);
    }

    .conf-header {
        background: linear-gradient(135deg, var(--deep), #2D1F0A);
        padding: 40px 36px 36px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .conf-header::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 400px 300px at 50% 50%, rgba(201, 168, 76, .12) 0%, transparent 70%);
    }

    .hammer-anim-wrap {
        width: 80px;
        height: 80px;
        background: rgba(201, 168, 76, .12);
        border: 2px solid rgba(201, 168, 76, .3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        animation: popIn .5s cubic-bezier(.34, 1.56, .64, 1) both;
    }

    @keyframes popIn {
        0% {
            transform: scale(0);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .hammer-icon-big {
        font-size: 2.2rem;
        color: var(--gold);
        animation: hammerSwing .6s ease .4s both;
    }

    @keyframes hammerSwing {
        0% {
            transform: rotate(-30deg);
        }

        40% {
            transform: rotate(18deg);
        }

        65% {
            transform: rotate(-8deg);
        }

        80% {
            transform: rotate(5deg);
        }

        100% {
            transform: rotate(0deg);
        }
    }

    .conf-title {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.8rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 8px;
        position: relative;
    }

    .conf-subtitle {
        color: rgba(255, 255, 255, .55);
        font-size: .9rem;
        position: relative;
    }

    .conf-bid-amount {
        font-family: 'Playfair Display', serif;
        font-size: 2.6rem;
        font-weight: 700;
        color: var(--gold);
        position: relative;
        margin-top: 16px;
        animation: countUp .6s ease .3s both;
    }

    @keyframes countUp {
        0% {
            transform: translateY(12px);
            opacity: 0;
        }

        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .conf-body {
        padding: 32px 36px;
    }

    .notice-box {
        background: linear-gradient(135deg, #FFF8E1, #FFF3CC);
        border: 1.5px solid rgba(201, 168, 76, .4);
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 28px;
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }

    .notice-icon {
        width: 36px;
        height: 36px;
        background: rgba(201, 168, 76, .15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gold);
        font-size: 1rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .notice-title {
        font-weight: 700;
        font-size: .88rem;
        color: var(--deep);
        margin-bottom: 3px;
    }

    .notice-text {
        font-size: .8rem;
        color: #666;
        line-height: 1.6;
        margin: 0;
    }

    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
        border: 1px solid rgba(0, 0, 0, .08);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 28px;
    }

    .detail-row {
        display: contents;
    }

    .detail-row>div {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(0, 0, 0, .06);
        font-size: .85rem;
    }

    .detail-row:last-child>div {
        border-bottom: none;
    }

    .detail-lbl {
        background: var(--cream);
        font-weight: 700;
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #888;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .detail-val {
        font-weight: 600;
        color: var(--deep);
    }

    .address-detail-box {
        background: var(--cream);
        border-radius: 10px;
        padding: 16px 18px;
        margin-bottom: 28px;
        border: 1px solid rgba(0, 0, 0, .06);
    }

    .address-detail-title {
        font-size: .68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #aaa;
        margin-bottom: 8px;
    }

    .address-detail-text {
        font-size: .88rem;
        color: var(--deep);
        line-height: 1.7;
    }

    .steps-list {
        list-style: none;
        padding: 0;
        margin: 0 0 28px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .step-item {
        display: flex;
        gap: 14px;
        align-items: flex-start;
    }

    .step-num {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: var(--deep);
        color: var(--gold);
        font-size: .72rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .step-text {
        font-size: .85rem;
        color: #555;
        line-height: 1.55;
    }

    .step-text strong {
        color: var(--deep);
    }

    .conf-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-back-auction {
        flex: 1;
        background: linear-gradient(135deg, var(--rust), #A0471F);
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 13px 20px;
        font-size: .88rem;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all .3s;
    }

    .btn-back-auction:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(139, 58, 26, .4);
    }

    .btn-browse {
        padding: 13px 20px;
        border: 2px solid rgba(0, 0, 0, .1);
        border-radius: 10px;
        font-size: .88rem;
        font-weight: 600;
        color: var(--deep);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all .2s;
    }

    .btn-browse:hover {
        border-color: var(--gold);
        color: var(--deep);
    }

    .ref-id-box {
        text-align: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid rgba(0, 0, 0, .06);
    }

    .ref-id-text {
        font-size: .72rem;
        color: #aaa;
        letter-spacing: 1px;
    }

    .ref-id-val {
        font-family: 'Courier New', monospace;
        font-size: .88rem;
        font-weight: 700;
        color: var(--deep);
        background: var(--cream);
        padding: 3px 12px;
        border-radius: 6px;
        border: 1px solid rgba(0, 0, 0, .08);
    }

    .item-preview-strip {
        display: flex;
        align-items: center;
        gap: 14px;
        background: var(--cream);
        border-radius: 12px;
        padding: 14px 18px;
        margin-bottom: 28px;
        text-decoration: none;
        border: 1px solid rgba(0, 0, 0, .06);
        transition: border-color .2s;
    }

    .item-preview-strip:hover {
        border-color: var(--gold);
    }

    .item-preview-img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .item-preview-title {
        font-family: 'Playfair Display', serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--deep);
        margin-bottom: 2px;
    }

    .item-preview-sub {
        font-size: .75rem;
        color: #999;
    }
</style>

@section('content')
    <div class="confirmation-wrap">
        <div class="confirmation-card">

            {{-- Header --}}
            <div class="conf-header">
                <div class="hammer-anim-wrap">
                    <i class="fas fa-gavel hammer-icon-big"></i>
                </div>
                <h2 class="conf-title">Bid Placed!</h2>
                <p class="conf-subtitle">Your bid is pending admin review</p>
                <div class="conf-bid-amount">₹{{ number_format($bid->bid_amount, 0) }}</div>
            </div>

            {{-- Body --}}
            <div class="conf-body">

                {{-- Notice --}}
                <div class="notice-box">
                    <div class="notice-icon"><i class="fas fa-shield-halved"></i></div>
                    <div>
                        <div class="notice-title">Your bid is under review</div>
                        <p class="notice-text">
                            Admin will verify and approve your bid shortly. Once approved, it will appear on the public
                            leaderboard.
                            If you win when the auction closes, you will be notified at
                            <strong>{{ $bid->bidder_email }}</strong>.
                        </p>
                    </div>
                </div>

                {{-- Item preview --}}
                <a href="{{ route('auction.show', $bid->auctionItem->id) }}" class="item-preview-strip">
                    <img src="{{ $bid->auctionItem->thumbnail }}" alt="{{ $bid->auctionItem->title }}"
                        class="item-preview-img">
                    <div>
                        <div class="item-preview-title">{{ $bid->auctionItem->title }}</div>
                        <div class="item-preview-sub">
                            {{ $bid->auctionItem->material_type ?? 'Rare Material' }} ·
                            Auction ends {{ $bid->auctionItem->auction_end->format('d M Y, h:i A') }}
                        </div>
                    </div>
                    <i class="fas fa-chevron-right ms-auto" style="color:#ccc;"></i>
                </a>

                {{-- Bid details --}}
                <div class="details-grid">
                    <div class="detail-row">
                        <div class="detail-lbl"><i class="fas fa-user"></i> Name</div>
                        <div class="detail-val">{{ $bid->bidder_name }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-lbl"><i class="fas fa-envelope"></i> Email</div>
                        <div class="detail-val">{{ $bid->bidder_email }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-lbl"><i class="fas fa-phone"></i> Phone</div>
                        <div class="detail-val">{{ $bid->bidder_phone ?? '—' }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-lbl"><i class="fas fa-id-card"></i> ID</div>
                        <div class="detail-val">
                            {{ $bid->bidder_id_type ? ucfirst($bid->bidder_id_type) . ' · ' . $bid->bidder_id_number : '—' }}
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-lbl"><i class="fas fa-calendar"></i> Bid Time</div>
                        <div class="detail-val">{{ $bid->created_at->format('d M Y, h:i A') }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-lbl"><i class="fas fa-circle-dot"></i> Status</div>
                        <div class="detail-val">
                            <span style="color:#B8860B;font-weight:700;">⏳ Pending Review</span>
                        </div>
                    </div>
                </div>

                {{-- Address --}}
                <div class="address-detail-box">
                    <div class="address-detail-title"><i class="fas fa-location-dot me-1"></i>Your Address</div>
                    <div class="address-detail-text">
                        @if ($bid->bidder_house_no)
                            <strong>{{ $bid->bidder_house_no }}</strong>,
                        @endif
                        @if ($bid->bidder_village)
                            {{ $bid->bidder_village }},
                        @endif
                        @if ($bid->bidder_block)
                            <br>Block: {{ $bid->bidder_block }},
                        @endif
                        @if ($bid->bidder_district)
                            District: <strong>{{ $bid->bidder_district }}</strong>,
                        @endif
                        @if ($bid->bidder_state)
                            {{ $bid->bidder_state }},
                        @endif
                        @if ($bid->bidder_pincode)
                            PIN: {{ $bid->bidder_pincode }},
                        @endif
                        <strong> {{ $bid->bidder_country }}</strong>
                    </div>
                </div>

                {{-- What happens next --}}
                <h6
                    style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:700;color:var(--deep);margin-bottom:16px;">
                    What Happens Next?
                </h6>
                <ul class="steps-list">
                    <li class="step-item">
                        <div class="step-num">1</div>
                        <div class="step-text"><strong>Admin reviews your bid</strong> — usually within a few hours. We
                            verify identity details before approving.</div>
                    </li>
                    <li class="step-item">
                        <div class="step-num">2</div>
                        <div class="step-text"><strong>Your bid goes live</strong> on the public leaderboard once approved.
                        </div>
                    </li>
                    <li class="step-item">
                        <div class="step-num">3</div>
                        <div class="step-text"><strong>Auction closes</strong> on
                            {{ $bid->auctionItem->auction_end->format('d M Y') }}. The highest approved bid wins.</div>
                    </li>
                    <li class="step-item">
                        <div class="step-num">4</div>
                        <div class="step-text"><strong>Winner is notified by email</strong> at {{ $bid->bidder_email }}
                            with donation payment instructions.</div>
                    </li>
                </ul>

                {{-- Actions --}}
                <div class="conf-actions">
                    <a href="{{ route('auction.show', $bid->auctionItem->id) }}" class="btn-back-auction">
                        <i class="fas fa-gavel"></i> Back to Auction
                    </a>
                    <a href="{{ route('auction.index') }}" class="btn-browse">
                        <i class="fas fa-search"></i> Browse More
                    </a>
                </div>

                {{-- Ref ID --}}
                <div class="ref-id-box">
                    <div class="ref-id-text">Your Bid Reference ID</div>
                    <div class="ref-id-val">#BID-{{ str_pad($bid->id, 6, '0', STR_PAD_LEFT) }}</div>
                    <div class="ref-id-text mt-1">Save this for your records</div>
                </div>

            </div>
        </div>
    </div>
@endsection
