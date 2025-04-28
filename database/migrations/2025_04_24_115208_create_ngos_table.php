<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNgosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('ngos', function (Blueprint $table) {
            $table->id();

            $table->string('user_code')->unique();
            $table->string('user_name');
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('password');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('pin_code');
            $table->string('country');

            $table->string('registration_number')->unique();
            $table->date('founding_date');
            $table->string('contact_person');
            $table->string('designation')->nullable();
            $table->string('pan_number')->nullable();

            $table->text('mission')->nullable();    
            $table->text('operating_areas')->nullable();
            $table->text('focus_areas')->nullable();     

            $table->boolean('approved')->default(false);
            $table->string('slug')->unique()->nullable();

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
        Schema::dropIfExists('ngos');
    }
}
