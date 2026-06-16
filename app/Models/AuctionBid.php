<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionBid extends Model
{
    protected $fillable = [
        'auction_item_id', 'user_id', 'bidder_name', 'bidder_email', 'bidder_phone',
        'bidder_house_no', 'bidder_village', 'bidder_block', 'bidder_district',
        'bidder_state', 'bidder_country', 'bidder_pincode',
        'bidder_id_type', 'bidder_id_number',
        'bid_amount', 'status', 'admin_approved',
        'payment_order_id', 'payment_session_id', 'payment_status',
        'notification_sent', 'admin_note',
    ];

    protected $casts = [
        'bid_amount'     => 'decimal:2',
        'admin_approved' => 'boolean',
    ];

    public function auctionItem()
    {
        return $this->belongsTo(AuctionItem::class, 'auction_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFullAddressAttribute()
    {
        return collect([
            $this->bidder_house_no,
            $this->bidder_village,
            $this->bidder_block,
            $this->bidder_district,
            $this->bidder_state,
            $this->bidder_pincode,
            $this->bidder_country,
        ])->filter()->implode(', ');
    }
}