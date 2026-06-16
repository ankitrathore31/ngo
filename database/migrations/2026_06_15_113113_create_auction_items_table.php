<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auction_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('about_material')->nullable();
            $table->string('origin')->nullable();
            $table->string('age_period')->nullable();
            $table->string('material_type')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('weight')->nullable();
            $table->string('condition')->nullable();
            $table->string('rarity_level')->default('rare'); // common, rare, very_rare, unique
            $table->decimal('starting_bid', 12, 2)->default(0);
            $table->decimal('reserve_price', 12, 2)->nullable();
            $table->decimal('current_highest_bid', 12, 2)->nullable();
            $table->unsignedBigInteger('current_winner_id')->nullable();
            $table->dateTime('auction_start');
            $table->dateTime('auction_end');
            $table->enum('status', ['draft', 'active', 'closed', 'winner_selected', 'completed'])->default('draft');
            $table->string('model_3d_url')->nullable(); // optional 3D model embed URL
            $table->string('certificate_number')->nullable();
            $table->string('provenance')->nullable(); // history of ownership
            $table->timestamps();

            $table->foreign('current_winner_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auction_items');
    }
};