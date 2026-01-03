<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_facilities', function (Blueprint $table) {
            $table->id();
            $table->enum('treatment_type', ['treatment_start', 'treatment_end']);
            $table->string('medical_name');
            $table->string('bill_no');
            $table->date('bill_date');
            $table->decimal('bill_gst', 10, 2)->nullable();
            $table->decimal('bill_amount', 10, 2);
            $table->string('bill_upload')->nullable();
            $table->string('person_paying_bill')->nullable();
            $table->string('investigation_officer')->nullable();
            $table->string('verification_report')->nullable();
            $table->string('bill_witness')->nullable();
            $table->string('bill_witness_number')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('health_facilities');
    }
}
