<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
             $table->string('school_code')->unique();
            $table->date('registration_date')->nullable();
            $table->string('school_name');
            $table->string('contact_number')->nullable();
            $table->text('address')->nullable();
            $table->string('principal_name')->nullable();
            $table->string('affiliation_board')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('principal_aadhar')->nullable();

            // File paths
            $table->string('registration_certificate')->nullable();
            $table->string('affiliation_certificate')->nullable();
            $table->string('principal_appointment_letter')->nullable();
            $table->string('principal_aadhar_document')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('schools');
    }
}
