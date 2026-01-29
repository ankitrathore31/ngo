<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('education_facilities', function (Blueprint $table) {
            $table->id();
            $table->string('reg_id');
            $table->string('card_id');
            $table->string('fees_type');
            $table->string('registration_no');
            $table->string('fees_slip_no');
            $table->string('father_name')->nullable();
            $table->date('fees_submit_date');
            $table->decimal('fees_amount', 10, 2);
            $table->string('slip')->nullable();
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
        Schema::dropIfExists('education_facilities');
    }
}
