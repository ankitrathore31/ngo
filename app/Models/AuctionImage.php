<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionImage extends Model
{
    protected $fillable = ['auction_item_id', 'image_path', 'image_type', 'sort_order'];

    public function auctionItem()
    {
        return $this->belongsTo(AuctionItem::class, 'auction_item_id');
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}