<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill__items', function (Blueprint $table) {
            $table->id();
            $table->string('academic_session')->nullable();
            $table->string('ngo_id')->nullable();
            $table->foreignId('bill_id')->constrained()->onDelete('cascade');
            $table->string('product')->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('rate', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bill__items');
    }
}
