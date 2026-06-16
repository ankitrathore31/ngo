<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class AuctionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'about_material', 'origin', 'age_period',
        'material_type', 'dimensions', 'weight', 'condition', 'rarity_level',
        'starting_bid', 'reserve_price', 'current_highest_bid', 'current_winner_id',
        'auction_start', 'auction_end', 'status', 'model_3d_url',
        'certificate_number', 'provenance',
    ];

    protected $casts = [
        'auction_start' => 'datetime',
        'auction_end'   => 'datetime',
        'starting_bid'  => 'decimal:2',
        'reserve_price' => 'decimal:2',
        'current_highest_bid' => 'decimal:2',
    ];

    public function images()
    {
        return $this->hasMany(AuctionImage::class, 'auction_item_id')->orderBy('sort_order');
    }

    public function bids()
    {
        return $this->hasMany(AuctionBid::class, 'auction_item_id')->orderByDesc('bid_amount');
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'current_winner_id');
    }

    public function getThumbnailAttribute()
    {
        $img = $this->images()->where('image_type', 'thumbnail')->first()
            ?? $this->images()->first();
        return $img ? asset('storage/' . $img->image_path) : asset('images/auction-placeholder.jpg');
    }

    public function getGalleryImagesAttribute()
    {
        return $this->images()->whereIn('image_type', ['gallery', 'thumbnail'])->get();
    }

    public function isActiveAttribute()
    {
        return $this->status === 'active'
            && $this->auction_start->lte(now())
            && $this->auction_end->gt(now());
    }

    public function getTimeRemainingAttribute()
    {
        if ($this->auction_end->isPast()) return 'Ended';
        $diff = now()->diff($this->auction_end);
        if ($diff->days > 0) return $diff->days . 'd ' . $diff->h . 'h';
        if ($diff->h > 0) return $diff->h . 'h ' . $diff->i . 'm';
        return $diff->i . 'm ' . $diff->s . 's';
    }

    public function getDisplayBidAttribute()
    {
        return $this->current_highest_bid ?? $this->starting_bid;
    }

    public function getRarityColorAttribute()
    {
        return match($this->rarity_level) {
            'unique'    => '#FFD700',
            'very_rare' => '#C0392B',
            'rare'      => '#8E44AD',
            default     => '#2ECC71',
        };
    }
}