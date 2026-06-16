<?php

namespace App\Http\Controllers;

use App\Models\AuctionItem;
use App\Models\AuctionBid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AuctionBidController extends Controller
{
    // Public auction listing
    public function index()
    {
        $activeAuctions = AuctionItem::where('status', 'active')
            ->where('auction_end', '>', now())
            ->with('images')
            ->withCount('bids')
            ->latest()
            ->get();

        $closedAuctions = AuctionItem::whereIn('status', ['closed', 'winner_selected', 'completed'])
            ->with('images')
            ->withCount('bids')
            ->latest()
            ->take(6)
            ->get();

        return view('home.auction.index', compact('activeAuctions', 'closedAuctions'));
    }

    // Single auction detail + bid form
    public function show($id)
    {
        $item = AuctionItem::with(['images', 'bids' => function ($q) {
            $q->where('ngo_approved', true)->orderByDesc('bid_amount')->take(10);
        }])->findOrFail($id);

        $topBid = AuctionBid::where('auction_item_id', $id)
            ->where('ngo_approved', true)
            ->max('bid_amount');

        $bidCount = AuctionBid::where('auction_item_id', $id)->count();

        return view('home.auction.show', compact('item', 'topBid', 'bidCount'));
    }

    // Place bid
    public function placeBid(Request $request, $id)
    {
        $item = AuctionItem::findOrFail($id);

        if ($item->status !== 'active' || $item->auction_end->isPast()) {
            return back()->withErrors(['error' => 'This auction has ended or is not active.']);
        }

        $minBid = ($item->current_highest_bid ?? $item->starting_bid) + 1;

        $validated = $request->validate([
            'bidder_name'    => 'required|string|max:255',
            'bidder_email'   => 'required|email|max:255',
            'bidder_phone'   => 'required|string|max:20',
            'bidder_house_no'=> 'nullable|string|max:100',
            'bidder_village' => 'nullable|string|max:150',
            'bidder_block'   => 'nullable|string|max:100',
            'bidder_district'=> 'required|string|max:100',
            'bidder_state'   => 'required|string|max:100',
            'bidder_country' => 'required|string|max:100',
            'bidder_pincode' => 'nullable|string|max:20',
            'bidder_id_type' => 'nullable|in:aadhar,pan,passport,voter_id,other',
            'bidder_id_number' => 'nullable|string|max:100',
            'bid_amount'     => "required|numeric|min:{$minBid}",
        ]);

        $bid = AuctionBid::create(array_merge($validated, [
            'auction_item_id' => $item->id,
            'status'          => 'pending',
            'ngo_approved'  => false,
        ]));

        return redirect()->route('auction.bid.confirmation', $bid->id)
            ->with('success', 'Bid placed! Pending Ngo review.');
    }

    // Bid confirmation page
    public function confirmation($bidId)
    {
        $bid  = AuctionBid::with('auctionItem.images')->findOrFail($bidId);
        return view('home.auction.confirmation', compact('bid'));
    }

    // AJAX: current bid status
    public function liveStatus($id)
    {
        $item     = AuctionItem::findOrFail($id);
        $topBid   = AuctionBid::where('auction_item_id', $id)->where('ngo_approved', true)->max('bid_amount');
        $bidCount = AuctionBid::where('auction_item_id', $id)->count();

        return response()->json([
            'top_bid'     => $topBid ?? $item->starting_bid,
            'bid_count'   => $bidCount,
            'time_left'   => $item->auction_end->diffForHumans(),
            'ends_at'     => $item->auction_end->toIso8601String(),
            'is_active'   => $item->status === 'active' && !$item->auction_end->isPast(),
        ]);
    }
}