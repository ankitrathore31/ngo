<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('academic_session')->nullable();
            $table->string('ngo_id')->nullable();
            $table->string('registration_no');
            $table->date('registration_date');
            $table->string('shop');
            $table->string('vendor_type')->nullable();
            $table->string('name');
            $table->string('village')->nullable();
            $table->string('post');
            $table->string('block');
            $table->string('state');
            $table->string('district');
            $table->string('mobile');
            $table->string('email');

            $table->string('shop_gst_no')->nullable();
            $table->string('operator_gst_no')->nullable();
            $table->string('shop_gst_file')->nullable();
            $table->string('operator_gst_file')->nullable();

            $table->string('vendor_pan_no')->nullable();
            $table->string('operator_pan_no')->nullable();
            $table->string('shop_pan_file')->nullable();
            $table->string('operator_pan_file')->nullable();
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
        Schema::dropIfExists('vendors');
    }
}
