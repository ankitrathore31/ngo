@extends('ngo.layout.master')

@section('title', 'Auction Management')

{{-- @push('styles') --}}
<style>
    :root {
        --gold: #C9A84C;
        --deep: #1A1208;
        --cream: #F7F3EC;
        --rust: #8B3A1A;
        --jade: #2C5F4A;
    }

    .auction-admin-header {
        background: linear-gradient(135deg, var(--deep), #a117f1);
        padding: 28px 32px;
        border-radius: 14px;
        color: #fff;
        margin-bottom: 28px;
    }

    .auction-stat-mini {
        background: rgba(255, 255, 255, .06);
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 10px;
        padding: 14px 18px;
        text-align: center;
    }

    .stat-mini-val {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--gold);
        line-height: 1;
    }

    .stat-mini-lbl {
        font-size: 1.25rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: rgba(255, 255, 255, .45);
        margin-top: 2px;
    }

    .auction-table thead th {
        background: var(--cream);
        border: none;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #666;
        font-weight: 700;
        padding: 12px 16px;
    }

    .auction-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border-color: rgba(0, 0, 0, .05);
    }

    .auction-table tbody tr:hover {
        background: #fafaf8;
    }

    .item-thumb-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .item-thumb-cell img {
        width: 52px;
        height: 52px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid rgba(0, 0, 0, .08);
    }

    .item-thumb-title {
        font-weight: 600;
        font-size: .88rem;
        color: var(--deep);
        line-height: 1.3;
    }

    .item-thumb-sub {
        font-size: .72rem;
        color: #999;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 50px;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .status-active {
        background: #E6F9F0;
        color: #1A7A4A;
        border: 1px solid #A5D6B7;
    }

    .status-draft {
        background: #F0F0F0;
        color: #666;
        border: 1px solid #ddd;
    }

    .status-closed {
        background: #FEF2F0;
        color: #C0392B;
        border: 1px solid #E8A49C;
    }

    .status-winner_selected {
        background: #FFF8E1;
        color: #B8860B;
        border: 1px solid var(--gold);
    }

    .status-completed {
        background: #E8F4FF;
        color: #1565C0;
        border: 1px solid #90CAF9;
    }

    .rarity-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 5px;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: .72rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all .15s;
    }

    .btn-a-edit {
        background: #E8F4FF;
        color: #1565C0;
    }

    .btn-a-edit:hover {
        background: #1565C0;
        color: #fff;
    }

    .btn-a-bids {
        background: #E6F9F0;
        color: #1A7A4A;
    }

    .btn-a-bids:hover {
        background: #1A7A4A;
        color: #fff;
    }

    .btn-a-delete {
        background: #FEF2F0;
        color: #C0392B;
    }

    .btn-a-delete:hover {
        background: #C0392B;
        color: #fff;
    }

    .btn-a-close {
        background: #FFF8E1;
        color: #B8860B;
    }

    .btn-a-close:hover {
        background: #B8860B;
        color: #fff;
    }

    .filter-bar {
        background: #fff;
        border: 1px solid rgba(0, 0, 0, .07);
        border-radius: 10px;
        padding: 14px 20px;
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .filter-select {
        border: 1.5px solid rgba(0, 0, 0, .1);
        border-radius: 7px;
        padding: 6px 12px;
        font-size: .8rem;
        color: var(--deep);
        background: #fff;
        appearance: none;
        cursor: pointer;
    }
</style>
{{-- @endpush --}}

@section('content')
    <div class="wrapper">
        <div class="container-fluid mt-4">

            {{-- Header --}}
            <div class="auction-admin-header">
                <div class="row align-items-center g-3">
                    <div class="col-md-5">
                        <h4 class="mb-1" style="font-family:'Playfair Display',serif;">
                            <i class="fas fa-gavel me-2" style="color:var(--gold);"></i>Auction Management
                        </h4>
                        <p class="mb-0 small" style="color:rgba(255,255,255,.5);">Manage rare material auctions, bids, and
                            winner selection</p>
                    </div>
                    <div class="col-md-7">
                        <div class="row g-2">
                            <div class="col-3">
                                <div class="auction-stat-mini">
                                    <div class="stat-mini-val">{{ $items->count() }}</div>
                                    <div class="stat-mini-lbl">Total</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="auction-stat-mini">
                                    <div class="stat-mini-val" style="color:#4ADE80;">
                                        {{ $items->where('status', 'active')->count() }}</div>
                                    <div class="stat-mini-lbl">Active</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="auction-stat-mini">
                                    <div class="stat-mini-val" style="color:#F87171;">
                                        {{ \App\Models\AuctionBid::where('ngo_approved', false)->where('status', 'pending')->count() }}
                                    </div>
                                    <div class="stat-mini-lbl">Pending Bids</div>
                                </div>
                            </div>
                            <div class="col-3">
                                <a href="{{ route('ngo.auction.create') }}" style="text-decoration:none;">
                                    <div class="auction-stat-mini"
                                        style="cursor:pointer;background:rgba(201,168,76,.15);border-color:rgba(201,168,76,.3);">
                                        <div style="font-size:1.4rem;color:var(--gold);"><i class="fas fa-plus"></i></div>
                                        <div class="stat-mini-lbl">New Auction</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show py-2 small mb-3">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Filter --}}
            <div class="filter-bar">
                <span class="small fw-semibold text-muted">Filter:</span>
                <select class="filter-select" onchange="filterStatus(this.value)">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="draft">Draft</option>
                    <option value="closed">Closed</option>
                    <option value="winner_selected">Winner Selected</option>
                    <option value="completed">Completed</option>
                </select>
                <select class="filter-select" onchange="filterRarity(this.value)">
                    <option value="">All Rarity</option>
                    <option value="unique">Unique</option>
                    <option value="very_rare">Very Rare</option>
                    <option value="rare">Rare</option>
                    <option value="common">Common</option>
                </select>
                <div class="ms-auto">
                    <a href="{{ route('ngo.auction.create') }}" class="btn btn-sm btn-primary px-3">
                        <i class="fas fa-plus me-1"></i> Add Auction
                    </a>
                </div>
            </div>

            {{-- Table --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table auction-table mb-0" id="auctionTable">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Rarity</th>
                                    <th>Start Bid</th>
                                    <th>Highest Bid</th>
                                    <th>Bids</th>
                                    <th>Ends</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $item)
                                    <tr data-status="{{ $item->status }}" data-rarity="{{ $item->rarity_level }}">
                                        <td>
                                            <div class="item-thumb-cell">
                                                @php
                                                    $thumbnail = $item->images
                                                        ->where('image_type', 'thumbnail')
                                                        ->first();
                                                @endphp

                                                <img src="{{ $thumbnail ? asset($thumbnail->image_path) : asset('images/no-image.png') }}"
                                                    alt="{{ $item->title }}">
                                                <div>
                                                    <div class="item-thumb-title">{{ Str::limit($item->title, 35) }}</div>
                                                    <div class="item-thumb-sub">{{ $item->material_type ?? 'Material' }} ·
                                                        {{ $item->origin ?? '—' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="rarity-dot" style="background:{{ $item->rarity_color }};"></span>
                                            <span
                                                style="font-size:.78rem;font-weight:600;">{{ ucfirst(str_replace('_', ' ', $item->rarity_level)) }}</span>
                                        </td>
                                        <td class="fw-semibold" style="font-size:.88rem;">
                                            ₹{{ number_format($item->starting_bid, 0) }}</td>
                                        <td style="color:var(--jade);font-weight:700;font-size:.92rem;">
                                            {{ $item->current_highest_bid ? '₹' . number_format($item->current_highest_bid, 0) : '—' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ $item->bids_count }}</span>
                                        </td>
                                        <td style="font-size:.8rem;">
                                            <div>{{ $item->auction_end->format('d M Y') }}</div>
                                            <div class="text-muted" style="font-size:.7rem;">
                                                {{ $item->auction_end->format('h:i A') }}</div>
                                        </td>
                                        <td>
                                            <span class="status-pill status-{{ $item->status }}">
                                                @if ($item->status === 'active')
                                                    <i class="fas fa-circle" style="font-size:.4rem;"></i>
                                                @endif
                                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 flex-wrap">
                                                <a href="{{ route('ngo.auction.bids', $item->id) }}"
                                                    class="action-btn btn-a-bids">
                                                    <i class="fas fa-gavel"></i> Bids
                                                </a>
                                                <a href="{{ route('ngo.auction.edit', $item->id) }}"
                                                    class="action-btn btn-a-edit">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                @if ($item->status === 'active')
                                                    <form method="POST"
                                                        action="{{ route('ngo.auction.close', $item->id) }}"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Close this auction and determine winner?')">
                                                        @csrf
                                                        <button type="submit" class="action-btn btn-a-close">
                                                            <i class="fas fa-lock"></i> Close
                                                        </button>
                                                    </form>
                                                @endif
                                                <form method="POST"
                                                    action="{{ route('ngo.auction.destroy', $item->id) }}"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Delete this auction permanently?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="action-btn btn-a-delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="fas fa-gavel fa-2x mb-3 d-block opacity-25"></i>
                                            No auctions yet. <a href="{{ route('ngo.auction.create') }}">Create one
                                                now</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- @if ($items->count())
                    <div class="card-footer bg-white border-top-0">
                        {{ $items->links() }}
                    </div>
                @endif --}}
            </div>

        </div>
    </div>


    <script>
        function filterStatus(val) {
            document.querySelectorAll('#auctionTable tbody tr').forEach(row => {
                row.style.display = (!val || row.dataset.status === val) ? '' : 'none';
            });
        }

        function filterRarity(val) {
            document.querySelectorAll('#auctionTable tbody tr').forEach(row => {
                row.style.display = (!val || row.dataset.rarity === val) ? '' : 'none';
            });
        }
    </script>
@endsection
