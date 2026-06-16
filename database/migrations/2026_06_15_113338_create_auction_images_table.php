<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auction_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('auction_item_id');
            $table->string('image_path');
            $table->string('image_type')->default('gallery'); // gallery, thumbnail, 3d_view
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->foreign('auction_item_id')->references('id')->on('auction_items')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auction_images');
    }
};