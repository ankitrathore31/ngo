<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('union_no')->unique();
            $table->string('union_certificate_format')->nullable();
            $table->string('academic_session');
            $table->date('formation_date')->nullable();
            $table->string('area_type')->nullable();
            $table->text('address')->nullable();
            $table->string('block')->nullable();
            $table->string('state');
            $table->string('district');
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
        Schema::dropIfExists('unions');
    }
}
