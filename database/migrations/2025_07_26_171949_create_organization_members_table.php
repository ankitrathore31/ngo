<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_members', function (Blueprint $table) {
            $table->id();
            $table->string('academic_session')->nullable();
            $table->string('ngo_id')->nullable();
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('member_id');   // ID from Staff/Donation/etc.
            $table->string('member_type');
            $table->string('member_position');
            $table->date('member_date');
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
        Schema::dropIfExists('organization_members');
    }
}
