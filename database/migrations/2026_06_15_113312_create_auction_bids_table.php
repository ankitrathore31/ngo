<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auction_bids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auction_item_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('bidder_name');
            $table->string('bidder_email');
            $table->string('bidder_phone')->nullable();

            // Address fields
            $table->string('bidder_house_no')->nullable();
            $table->string('bidder_village')->nullable();
            $table->string('bidder_block')->nullable();
            $table->string('bidder_district')->nullable();
            $table->string('bidder_state')->nullable();
            $table->string('bidder_country')->default('India');
            $table->string('bidder_pincode')->nullable();

            $table->string('bidder_id_type')->nullable();  // aadhar, pan, passport
            $table->string('bidder_id_number')->nullable();

            $table->decimal('bid_amount', 12, 2);
            $table->enum('status', ['pending', 'active', 'outbid', 'won', 'lost', 'cancelled'])->default('pending');
            $table->boolean('admin_approved')->default(false);
            $table->string('payment_order_id')->nullable();
            $table->string('payment_session_id')->nullable();
            $table->enum('payment_status', ['unpaid', 'pending', 'paid', 'failed'])->default('unpaid');
            $table->string('notification_sent')->nullable(); // 'winner', 'outbid', 'closed'
            $table->text('admin_note')->nullable();
            $table->timestamps();

            $table->foreign('auction_item_id')->references('id')->on('auction_items')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auction_bids');
    }
};