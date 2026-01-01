<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('hospital_code')->unique();
            $table->string('hospital_name');
            $table->string('address')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('operator_name')->nullable();
            $table->date('registration_date')->nullable();
            $table->string('status')->default('active');

            $table->string('operator_aadhar')->nullable();
            $table->string('operator_degree')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('license_no')->nullable();

            $table->string('gst_document')->nullable();
            $table->string('license_document')->nullable();
            $table->string('operator_degree_document')->nullable();
            $table->string('operator_aadhar_document')->nullable();
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
        Schema::dropIfExists('hospitals');
    }
}
