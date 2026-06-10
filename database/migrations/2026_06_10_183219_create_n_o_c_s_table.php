<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNOCSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('n_o_c_s', function (Blueprint $table) {
            $table->id();
            $table->date('noc_date');
            $table->string('noc_area');
            $table->string('issuer_name');
            $table->string('issuer_designation');
            $table->string('file_path');
            $table->string('file_original_name');
            $table->string('file_type');
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
        Schema::dropIfExists('n_o_c_s');
    }
}
