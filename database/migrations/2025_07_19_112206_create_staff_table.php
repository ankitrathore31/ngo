<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('academic_session')->nullable();
            $table->string('ngo_id')->nullable();
            $table->date('application_date');
            $table->date('joining_date');
            $table->string('staff_code');
            $table->string('name');
            $table->date('dob');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('phone');
            $table->string('gurdian_name');
            $table->string('village')->nullable();
            $table->string('post');
            $table->string('block');
            $table->string('state');
            $table->string('district');
            $table->string('pincode')->nullable();
            $table->string('country');
            $table->string('email')->nullable();
            $table->string('religion');
            $table->string('religion_category');
            $table->string('caste');
            $table->string('eligibility');
            $table->string('degree');
            $table->string('experience');
            $table->string('image')->nullable();
            $table->string('identity_type');
            $table->string('identity_no');
            $table->string('position');
            $table->string('id_document')->nullable();
            $table->string('experience_document')->nullable();
            $table->string('marksheet')->nullable();
            $table->string('occupation');
            $table->json('permissions')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('staff');
    }
}
