<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use App\Models\AuctionItem;
use App\Models\AuctionBid;
use App\Models\AuctionImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class AuctionController extends Controller
{
    // ─── LIST ────────────────────────────────────────────────
    public function index()
    {
        $items = AuctionItem::withCount('bids')
            ->with('images')
            ->get();

        return view('ngo.auction.index', compact('items'));
    }

    // ─── CREATE ───────────────────────────────────────────────
    public function create()
    {
        return view('ngo.auction.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'about_material'  => 'nullable|string',
            'origin'          => 'nullable|string|max:150',
            'age_period'      => 'nullable|string|max:100',
            'material_type'   => 'nullable|string|max:100',
            'dimensions'      => 'nullable|string|max:100',
            'weight'          => 'nullable|string|max:50',
            'condition'       => 'nullable|string|max:100',
            'rarity_level'    => 'required|in:common,rare,very_rare,unique',
            'provenance'      => 'nullable|string',
            'certificate_number' => 'nullable|string|max:100',
            'starting_bid'    => 'required|numeric|min:1',
            'reserve_price'   => 'nullable|numeric|min:0',
            'auction_start'   => 'required|date|after_or_equal:today',
            'auction_end'     => 'required|date|after:auction_start',
            'status'          => 'required|in:draft,active',
            'model_3d_url'    => 'nullable|url',
            'images'   => 'nullable|array|max:10',
'images.*' => 'image|mimes:jpg,jpeg,png,webp',
        ]);

        $item = AuctionItem::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $destinationPath = public_path('auction_images');

            // Create directory if it doesn't exist
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            foreach ($request->file('images') as $index => $image) {
                $fileName = time() . '_' . $index . '_' . $image->getClientOriginalName();

                $image->move($destinationPath, $fileName);

                AuctionImage::create([
                    'auction_item_id' => $item->id,
                    'image_path'      => 'auction_images/' . $fileName,
                    'image_type'      => $index === 0 ? 'thumbnail' : 'gallery',
                    'sort_order'      => $index,
                ]);
            }
        }

        return redirect()->route('ngo.auction.index')
            ->with('success', 'Auction item created successfully!');
    }

    // ─── EDIT ─────────────────────────────────────────────────
    public function edit($id)
    {
        $item = AuctionItem::with('images')->findOrFail($id);
        return view('ngo.auction.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = AuctionItem::findOrFail($id);

        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'about_material'  => 'nullable|string',
            'origin'          => 'nullable|string|max:150',
            'age_period'      => 'nullable|string|max:100',
            'material_type'   => 'nullable|string|max:100',
            'dimensions'      => 'nullable|string|max:100',
            'weight'          => 'nullable|string|max:50',
            'condition'       => 'nullable|string|max:100',
            'rarity_level'    => 'required|in:common,rare,very_rare,unique',
            'provenance'      => 'nullable|string',
            'certificate_number' => 'nullable|string|max:100',
            'starting_bid'    => 'required|numeric|min:1',
            'reserve_price'   => 'nullable|numeric|min:0',
            'auction_start'   => 'required|date',
            'auction_end'     => 'required|date|after:auction_start',
            'status'          => 'required|in:draft,active,closed,winner_selected,completed',
            'model_3d_url'    => 'nullable|url',
            'images.*'        => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $item->update($validated);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {

                $fileName = time() . '_' . $index . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('auction_images'), $fileName);

                AuctionImage::create([
                    'auction_item_id' => $item->id,
                    'image_path'      => 'auction_images/' . $fileName,
                    'image_type'      => 'gallery',
                    'sort_order'      => $item->images()->count() + $index,
                ]);
            }
        }

        return redirect()->route('ngo.auction.index')
            ->with('success', 'Auction item updated!');
    }

    public function destroy($id)
    {
        $item = AuctionItem::with('images')->findOrFail($id);

        foreach ($item->images as $img) {

            $filePath = public_path($img->image_path);

            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $img->delete();
        }

        $item->delete();

        return redirect()
            ->route('ngo.auction.index')
            ->with('success', 'Auction deleted.');
    }

    public function deleteImage($id)
    {
        $img = AuctionImage::findOrFail($id);

        $filePath = public_path($img->image_path);

        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $img->delete();

        return back()->with('success', 'Image removed.');
    }

    // ─── BIDS MANAGEMENT ──────────────────────────────────────
    public function bids($id)
    {
        $item = AuctionItem::with('images')->findOrFail($id);
        $bids = AuctionBid::where('auction_item_id', $id)
            ->orderByDesc('bid_amount')
            ->paginate(20);

        return view('ngo.auction.bids', compact('item', 'bids'));
    }

    public function closeAuction($id)
    {
        $item = AuctionItem::findOrFail($id);
        $item->status = 'closed';
        $item->save();

        // Mark all bids as lost except highest
        $highestBid = AuctionBid::where('auction_item_id', $id)
            ->orderByDesc('bid_amount')
            ->first();

        if ($highestBid) {
            AuctionBid::where('auction_item_id', $id)
                ->where('id', '!=', $highestBid->id)
                ->update(['status' => 'lost']);

            $highestBid->status = 'won';
            $highestBid->save();

            $item->current_winner_id = $highestBid->user_id;
            $item->save();
        }

        return back()->with('success', 'Auction closed. Winner determined.');
    }

    public function approveWinner(Request $request, $bidId)
    {
        $bid  = AuctionBid::with('auctionItem')->findOrFail($bidId);
        $item = $bid->auctionItem;

        $bid->ngo_approved = true;
        $bid->status         = 'won';
        $bid->save();

        $item->status = 'winner_selected';
        $item->current_highest_bid = $bid->bid_amount;
        $item->save();

        // Send winner notification email
        $this->sendWinnerNotification($bid, $item);

        return back()->with('success', 'Winner approved and notified!');
    }

    public function approveBid($bidId)
    {
        $bid = AuctionBid::findOrFail($bidId);
        $bid->ngo_approved = true;
        $bid->status = 'active';
        $bid->save();

        // Update item's current highest bid
        $highest = AuctionBid::where('auction_item_id', $bid->auction_item_id)
            ->where('ngo_approved', true)
            ->max('bid_amount');

        AuctionItem::where('id', $bid->auction_item_id)
            ->update(['current_highest_bid' => $highest]);

        return back()->with('success', 'Bid approved!');
    }

    public function rejectBid(Request $request, $bidId)
    {
        $bid = AuctionBid::findOrFail($bidId);
        $bid->status = 'cancelled';
        $bid->ngo_note = $request->note ?? 'Rejected by ngo';
        $bid->save();
        return back()->with('success', 'Bid rejected.');
    }

    private function sendWinnerNotification(AuctionBid $bid, AuctionItem $item)
    {
        // In production, send actual mail here
        // Mail::to($bid->bidder_email)->send(new WinnerNotificationMail($bid, $item));
        $bid->notification_sent = 'winner';
        $bid->save();
    }

    // ─── DASHBOARD STATS ──────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'total_auctions'  => AuctionItem::count(),
            'active_auctions' => AuctionItem::where('status', 'active')->count(),
            'total_bids'      => AuctionBid::count(),
            'pending_bids'    => AuctionBid::where('status', 'pending')->where('ngo_approved', false)->count(),
            'total_collected' => AuctionBid::where('payment_status', 'paid')->sum('bid_amount'),
        ];

        $recentBids  = AuctionBid::with('auctionItem')->latest()->take(10)->get();
        $activeItems = AuctionItem::where('status', 'active')
            ->withCount('bids')
            ->orderBy('auction_end')
            ->take(5)
            ->get();

        return view('ngo.auction.dashboard', compact('stats', 'recentBids', 'activeItems'));
    }
}
