<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
             $table->string('academic_session')->nullable();
            $table->string('ngo_id')->nullable();
            $table->string('reg_type');
            $table->date('application_date');
            $table->string('name');
            $table->date('dob');
            $table->string('gender');
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
            $table->string('image')->nullable();
            $table->string('identity_type');
            $table->string('identity_no');
            $table->string('id_document')->nullable();
            $table->string('occupation');
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
        Schema::dropIfExists('members');
    }
}
